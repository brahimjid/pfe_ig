<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use   App\Creneau;

class HeuresController extends Controller
{
 
public function index(){
        return view('crudHeures');

    }
public function ajout(Request $request){
   
    $heure=new  Creneau;
     $heure->id= $request->id;
     $heure->heureDebut= $request->heureDebut;
     $heure->heureFin= $request->heureFin;

   $resultat= $heure->save();

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
   $resultat=  Creneau::find($request->id);
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
   $resultat=  Creneau::where('id',$request->id)->first();
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
  $resultat=  Creneau::where('id',$request->id)->update([
    'id'=> $request->id,
    'heureDebut'=> $request->heureDebut,
    'heureFin'=> $request->heureFin
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
    public function getHeure(Request $request){
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

        $totalRecords =  Creneau::select('count(*) as allcount')->count();

 
        //$totalRecords = cycle::all()->count();

        $totalRecordswithFilter =  Creneau::select('count(*) as allcount')
                                    ->where('heureDebut','like','%'.$searchValue.'%')
                                    ->count();

        $records =  Creneau::orderby($columnName,$columnSortorder)   
                            ->where('creneaux.heureDebut','like','%'.$searchValue.'%')
                            ->select('creneaux.*')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $id = $record->id;
            $heureDebut = $record->heureDebut;
            $heureFin = $record->heureFin;
           
        
            $data_arr[] = array(
                "id" => $id,
                "heureDebut" => $heureDebut,
                "heureFin" => $heureFin
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
