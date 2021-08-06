<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Departement;
class FilieresController extends Controller
{
    //
public function index(){
        $depts=Departement::all();
        return view('crudfilieres', compact('depts'));

    }
public function ajout(Request $request){
   //validation des champs
   $this->validate($request,[
    'idFil'=>'required',
    'nom'=>'required',
    'dept'=>'required'
   ]);
    $filiere=new Filiere;

    $filiere->idFil= $request->idFil;
   $filiere->nom= $request->nom;
   $filiere->dept= $request->dept;
    
   $resultat= $filiere->save();

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
    //return redirect('crud');
}

public function destroy(Request $request){
     //dd($request->id);
   $resultat= Filiere::find($request->idFil);
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
   $resultat= Filiere::where('idFil',$request->idFil)->first();
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
  $resultat= Filiere::where('idFil',$request->idFil)->update([
    'idFil'=> $request->idFil,
    'nom'=> $request->nom,
    'dept'=> $request->dept,
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
    public function getfilieres(Request $request){
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

        $totalRecords = Filiere::select('count(*) as allcount')->count();


        $totalRecordswithFilter = Filiere::select('count(*) as allcount')
                                    ->where('nom','like','%'.$searchValue.'%')
                                    ->count();

        $records = Filiere::orderby($columnName,$columnSortorder)   
                            ->where('filieres.nom','like','%'.$searchValue.'%')
                            ->select('filieres.idFil', 'filieres.nom', 'departements.LDEPL')
                            ->join('departements', 'filieres.dept', 'departements.NODEP')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $idFil = $record->idFil;
            $nom = $record->nom;
            $dept = $record->LDEPL;
            $data_arr[] = array(
                "idFil" => $idFil,
                "nom" => $nom,
                "dept" => $dept
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
