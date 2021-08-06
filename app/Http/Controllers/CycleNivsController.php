<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cycleniv;
use App\Cycle;
use App\Niveau;
class CyclenivsController extends Controller
{
    public function index(){
    $cycles= Cycle::all();
    $nivx=Niveau::all();
        return view('crudcycleniv', compact('cycles','nivx'));

    }
public function ajout(Request $request){
   //validation des champs
   $this->validate($request,[
    'idCycle'=>'required',
    'idNiv'=>'required'
   ]);
    $cycleNiv=new Cycleniv;
    $cycleNiv->idCycle= $request->idCycle;
    $cycleNiv->idNiv= $request->idNiv;
    $cycleNiv->nom= $request->nom;

   $resultat= $cycleNiv->save();

   if($resultat){
        return response()->json([
            'message'=>"ajout avec succès",
            "code"=>200
    ]);

    }
        else{
    return response()->json([
        'message'=>"ajout échouée",
                "code"=>500
        ]);
    }
    
}
public function destroy(Request $request){
     
   $resultat= Cycleniv::find($request->idCycle);
    if($resultat->delete()){
        return response()->json([
            'message'=>"suppression avec succès",
            "code"=>200
    ]);

    }
    else{
return response()->json([
    'message'=>"suppression échouée",
            "code"=>500
    ]);
}

}
public function editer(Request $request){
     //dd($request->idCycle);
   $resultat= Cycleniv::where('idCycle',$request->idCycle)->first();
    if($resultat){
        return response()->json([
            'message'=>"edition avec succès",
            "code"=>200,
            "data"=>$resultat
    ]);

    }
    else{
return response()->json([
    'message'=>"edition échouée",
            "code"=>500
    ]);
}

}

public function update(Request $request){
    // dd($request);
  $resultat= Cycleniv::where('idCycle',$request->idCycle)->update([
    'idCycle'=> $request->idCycle,
    'idNiv'=> $request->idNiv,
    'nom'=> $request->nom
   ]);
    if($resultat){
        return response()->json([
            'message'=>"modification avec succès",
            "code"=>200,
            "data"=>$resultat
    ]);

    }
    else{
return response()->json([
    'message'=>"modification échouée",
            "code"=>500
    ]);
}

}
    ## AJAX request
    public function getcyclesNiv(Request $request){
        ## Read values
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); 

        $columnIndex_arr = $request->get('order'); 
        $columnName_arr = $request->get('columns'); 
        $order_arr = $request->get('order'); 
        $search_arr = $request->get('search'); 

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortorder = $order_arr[0]['dir'];//asc or desc
        $searchValue = $search_arr['value'];

        $totalRecords = Cycleniv::select('count(*) as allcount')->count();


        

        $totalRecordswithFilter = Cycleniv::select('count(*) as allcount')
                                    ->where('nom','like','%'.$searchValue.'%')
                                    ->count();

        $records = Cycleniv::orderby($columnName,$columnSortorder)   
                            ->where('cyclenivs.nom','like','%'.$searchValue.'%')
                            ->select('cyclenivs.idCycle', 'niveaux.nom as niv', 'cyclenivs.nom as cycleniv')
                            ->join('cycles','cyclenivs.idCycle','cycles.id')
                            ->join('niveaux','cyclenivs.idNiv','niveaux.id')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $idCycle = $record->idCycle;
            $idNiv=$record->niv;
            $nom = $record->cycleniv;
            
        
            $data_arr[] = array(
                "idCycle" => $idCycle,
                "idNiv"=>$idNiv,
                "nom" => $nom
            );
            


         }

             

         $response = array(
            "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
         );

        echo json_encode($response);
        exit;

         }
}
