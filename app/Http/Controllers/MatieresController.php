<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Matiere;
class MatieresController extends Controller
{
    //

public function index(){
        return view('crudmatieres');

    }
public function ajout(Request $request){
    
    $matieres=new Matiere;
    $matieres->nummat= $request->nummat;
    $matieres->mat= $request->mat;
    $matieres->NOPRFL= $request->NOPRFL;
    $matieres->sem= $request->sem;
  
    
     $matieres->save();
   
}
public function destroy(Request $request){
     
   $resultat= Matiere::find($request->nummat)->first();
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
   $resultat= Matiere::where('nummat',$request->nummat)->first();
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
    
  $resultat= Matiere::where('nummat',$request->nummat)->update([
    'nummat'=> $request->nummat,
    'mat'=> $request->mat,
    'NOPRFL'=> $request->NOPRFL,
    'sem'=> $request->sem
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
    public function getmatieres(Request $request){
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

        $totalRecords = Matiere::select('count(*) as allcount')->count();


        

        $totalRecordswithFilter = Matiere::select('count(*) as allcount')
                                    ->where('mat','like','%'.$searchValue.'%')
                                    ->count();

        $records =Matiere::orderby($columnName,$columnSortorder)   
                            ->where('matieres.mat','like','%'.$searchValue.'%')
                            ->select('matieres.*')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
             $nummat = $record->nummat;
            $mat = $record->mat;
            $NOPRFL = $record->NOPRFL;
            $sem = $record->sem;
           
          
            $data_arr[] = array(
               "nummat" => $nummat,
                "mat" => $mat,
                "NOPRFL" => $NOPRFL,
                "sem" => $sem
                
              
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
public function exportExcel(){


    return Excel::download(new matieresExport, 'matieres.xlsx');
} 

}
