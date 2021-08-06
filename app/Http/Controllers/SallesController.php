<?php 

namespace App\Http\Controllers;
//use App\Exports\SallesExport;
use App\Salle;
use App\Cycle;
use Illuminate\Http\Request;

//use Maatwebsite\Excel\Facades\Excel;
 //use Illuminate\Support\Facades\DB;
class SallesController extends Controller
{

   public function index(){
   
    $cycles= Cycle::all();

   return view('crudSalle',compact('cycles'));
       
    }
  

  public function ajout(Request $request){
   
    $salle=new Salle;

   $salle->nomsalle= $request->nomsalle;
   $salle->cycle= $request->cycle;
   $salle->Sitefr= $request->Sitefr;
   $salle->SiteAr= $request->SiteAr;
   $salle->CapSal= $request->CapSal;
    
   $resultat= $salle->save();

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
     //dd($request->id);
   $resultat= Salle::find($request->id);
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
   $resultat= Salle::where('id',$request->id)->first();
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
  $resultat= Salle::where('id',$request->id)->update([
    'id'=> $request->id,
    'nomsalle'=> $request->nomsalle,
    'cycle'=> $request->cycle,
    'Sitefr'=> $request->Sitefr,
    'SiteAr'=> $request->SiteAr,
    'CapSal'=> $request->CapSal
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
    public function getsalles(Request $request){
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

        $totalRecords = Salle::select('count(*) as allcount')->count();


        //$totalRecords = Salle::all()->count();

        $totalRecordswithFilter = Salle::select('count(*) as allcount')
                                    ->where('nomsalle','like','%'.$searchValue.'%')
                                    ->count();

        $records = Salle::orderby($columnName,$columnSortorder)   
                            ->where('salles.nomsalle','like','%'.$searchValue.'%')
                            ->select('salles.*')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();


          foreach($records as $record){
            $id = $record->id;
            $nomsalle = $record->nomsalle;
            $cycle = $record->cycle;
            $Sitefr = $record->Sitefr;
            $SiteAr = $record->SiteAr;
            $CapSal = $record->CapSal;
         
            $data_arr[] = array(
                "id" => $id,
                "nomsalle" => $nomsalle,
                "cycle" => $cycle,
                "Sitefr" => $Sitefr,
                "SiteAr" => $SiteAr,
                "CapSal" => $CapSal
               
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
