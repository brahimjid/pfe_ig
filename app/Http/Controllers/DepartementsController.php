<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departement;
use App\Professeur;
class DepartementsController extends Controller
{
    
public function index(){
        $profs=Professeur::all();
        return view('cruddepart', compact('profs'));

    }
public function ajout(Request $request){
   //validation des champs
   $this->validate($request,[
    'NODEP'=>'required',
    'LDEPL'=>'required'
   ]);

    $depart=new Departement;
   $depart->NODEP= $request->NODEP;
   $depart->LDEPL= $request->LDEPL;
   $depart->respoDepart= $request->respoDepart;
   $depart->LDEPA= $request->LDEPA;
   $depart->CDEPA= $request->CDEPA;
   $depart->TDEP= $request->TDEP;
    
   $resultat= $depart->save();

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
 

   $resultat= Departement::where('NODEP',$request->NODEP)->first();
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
   $resultat= Departement::where('NODEP',$request->NODEP)->first();
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
  $resultat= Departement::where('NODEP',$request->NODEP)->update([
   'NODEP'=> $request->NODEP,
   'LDEPL'=> $request->LDEPL,
   'respoDepart'=>$request->respoDepart,
   'LDEPA'=> $request->LDEPA,
   'CDEPA'=> $request->CDEPA,
   'TDEP'=> $request->TDEP
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
    public function getdeparts(Request $request){
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

        $totalRecords = Departement::select('count(*) as allcount')->count();


        //$totalRecords = depart::all()->count();

        $totalRecordswithFilter = Departement::select('count(*) as allcount')
                                    ->where('LDEPL','like','%'.$searchValue.'%')
                                    ->count();

     $records = Departement::orderby($columnName,$columnSortorder)   
                            ->where('departements.LDEPL','like','%'.$searchValue.'%')
                            ->select('departements.NODEP','departements.LDEPL','professeurs.Nom')
                            ->join('professeurs','departements.respoDepart','professeurs.Matricule')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();


    
          foreach($records as $record){
            $nodep = $record->NODEP;
            $ldepl = $record->LDEPL;
            $respoDepart=$record->Nom;
          
            $data_arr[] = array(
                "NODEP" => $nodep,
                "LDEPL" => $ldepl,
                "respoDepart" => $respoDepart
               
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