<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use   App\Niveau;
class NiveauxController extends Controller
{
    //


public function index(){
        //$cycle=DB::table('cycle')->get();
        return view('crudniveau');

    }
public function ajout(Request $request){
   
//validation des champs
   $this->validate($request,[
    'id'=>'required',
    'nom'=>'required'
   ]);

    $niveau=new Niveau;
     $niveau->id= $request->id;
     
   $niveau->nom= $request->nom;

    //dd($niveau);
   $resultat= $niveau->save();

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
   $resultat= Niveau::find($request->id);
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
   $resultat= Niveau::where('id',$request->id)->first();
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
  $resultat= Niveau::where('id',$request->id)->update([
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
    public function getNiv(Request $request){
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

        $totalRecords = Niveau::select('count(*) as allcount')->count();


        //$totalRecords = cycle::all()->count();

        $totalRecordswithFilter = Niveau::select('count(*) as allcount')
                                    ->where('nom','like','%'.$searchValue.'%')
                                    ->count();

        $records = Niveau::orderby($columnName,$columnSortorder)   
                            ->where('niveaux.nom','like','%'.$searchValue.'%')
                            ->select('niveaux.*')
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
