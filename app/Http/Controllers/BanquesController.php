<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Banque;
use Illuminate\Support\Facades\Validator;
class BanquesController extends Controller
{
    public function index(){
        return view('crudbanque');

    }
public function ajout(Request $request){
   //validation des champs
   $r=array(
    'IDBanq'=>'required'
   );
   $error=Validator::make($request->all(),$r);
   if($error->fails()){
        return response()->json(['errors => $error->errors()->all()']);
   }

    $banque=new Banque;
   $banque->IDBanq= $request->IDBanq;
   $banque->LibBanq= $request->LibBanq;
    
   $resultat= $banque->save();

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
public function destroy(Request $request)
{
 

   $resultat= Banque::where('IDBanq',$request->IDBanq)->first();
    if($resultat->delete())
    {
                return response()->json([
                    'message'=>"suppression avec succès",
                    "code"=>200
            ]);

    }
    else
    {
        return response()->json([
            'message'=>"suppression échouée",
                    "code"=>500
            ]);
    }

}



public function editer(Request $request){
     //dd($request->id);
   $resultat= Banque::where('IDBanq',$request->IDBanq)->first();
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
  $resultat= Banque::where('IDBanq',$request->IDBanq)->update([
   'IDBanq'=> $request->IDBanq,
   'LibBanq'=> $request->LibBanq
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
    public function getBanque(Request $request){
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

        $totalRecords = Banque::select('count(*) as allcount')->count();


        $totalRecordswithFilter = Banque::select('count(*) as allcount')
                                    ->where('IDBanq','like','%'.$searchValue.'%')
                                    ->count();

     $records = Banque::orderby($columnName,$columnSortorder)   
                            ->where('banques.IDBanq','like','%'.$searchValue.'%')
                            ->select('banques.*')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();


    
          foreach($records as $record){
            $idBanq = $record->IDBanq;
            $libBanq = $record->LibBanq;
           
          
            $data_arr[] = array(
                "IDBanq" => $idBanq,
                "LibBanq" => $libBanq
               
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
