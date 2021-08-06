<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cycle;
use App\Niveau;
class CyclesController extends Controller
{
    
public function index(){
    $cycles= Cycle::all();
    $nivx=Niveau::all();
        return view('crudcycle', compact('cycles','nivx'));

    }
public function ajout(Request $request){
   //validation des champs
   $this->validate($request,[
    'id'=>'required'
   ]);
    $cycle=new Cycle;
     $cycle->id= $request->id;
   $cycle->nom= $request->nom;

   $resultat= $cycle->save();

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
     
   $resultat= Cycle::find($request->id);
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
     //dd($request->id);
   $resultat= Cycle::where('id',$request->id)->first();
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
  $resultat= Cycle::where('id',$request->id)->update([
    'id'=> $request->id,
    'nom'=> $request->nom,
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
    public function getCycle(Request $request){
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

        $totalRecords = Cycle::select('count(*) as allcount')->count();


        //$totalRecords = cycle::all()->count();

        $totalRecordswithFilter = Cycle::select('count(*) as allcount')
                                    ->where('nom','like','%'.$searchValue.'%')
                                    ->count();

        $records = Cycle::orderby($columnName,$columnSortorder)   
                            ->where('cycles.nom','like','%'.$searchValue.'%')
                            ->select('cycles.*')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $id = $record->id;
            $nom = $record->nom;
            
        
            $data_arr[] = array(
                "id" => $id,
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
