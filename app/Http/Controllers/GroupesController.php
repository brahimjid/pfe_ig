<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groupe;
use  App\Classe;
//use App\Filiere;
//use DB;
class GroupesController extends Controller
{
    //

public function index(){
        $classes= Classe::all();
        //$classes=DB::select("select f.idFil, c.id from classes c, groupes g, filieres f where c.id=g.idClasse and c.idFil=f.idFil");
        return view('crudgroupe', compact('classes'));

    }


public function ajout(Request $request){
   
//validation des champs
   $this->validate($request,[
    'idGroupe'=>'required',
    'idClasse'=>'required',
    'ordre'=>'required'
   ]);

    $grp=new Groupe;
    $grp->idGroupe= $request->idGroupe;
    $grp->idClasse= $request->idClasse;
    $grp->ordre= $request->ordre;

    $resultat= $grp->save();
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

//editer
public function editer(Request $request){
     
   $resultat= Groupe::where('idGroupe',$request->idGroupe)->first();
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

//mise à jour
public function update(Request $request){
    // dd($request);
  $resultat= Groupe::where('idGroupe',$request->idGroupe)->update([
    'idGroupe'=> $request->idGroupe,
    'idClasse'=> $request->idClasse,
    'ordre'=> $request->ordre
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

public function destroy(Request $request){
   $resultat= Groupe::find($request->idGroupe);
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
    ## AJAX request
    public function getgroupes(Request $request){
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

        $totalRecords = Groupe::select('count(*) as allcount')->count();


        $totalRecordswithFilter = Groupe::select('count(*) as allcount')
                                    ->where('idClasse','like','%'.$searchValue.'%')
                                    ->count();

        $records =Groupe::orderby($columnName,$columnSortorder)   
                            ->where('groupes.idClasse','like','%'.$searchValue.'%')
                            ->select('groupes.idGroupe','classes.titreCourt','groupes.ordre')
                            ->join('classes','groupes.idClasse','classes.id')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
             $idGroupe = $record->idGroupe;
            $idClasse = $record->titreCourt;
            $ordre = $record->ordre;
           
          
            $data_arr[] = array(
               "idGroupe" => $idGroupe,
                "idClasse" => $idClasse,
                "ordre" => $ordre
                
              
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
