<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classe;
use App\Filiere;
use App\Niveau;
class ClassesController extends Controller
{

    public function index(){
        $filieres=Filiere::all();
        $nivx=Niveau::all();
        return view('crudclasse', compact('filieres','nivx'));

    }
public function ajout(Request $request){
    //validation des champs
   $this->validate($request,[
    'idFil'=>'required',
    'niv'=>'required'
   ]);
    $classe=new Classe;

   $classe->idFil= $request->idFil;
   $classe->niv= $request->niv;
   $classe->titreCourt= $request->titreCourt;
   $classe->titre= $request->titre;
    
   $resultat= $classe->save();

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
   $resultat= Classe::find($request->id);
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
    
   $resultat= Classe::where('id',$request->id)->first();
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
  $resultat= Classe::where('id',$request->id)->update([
    'id'=> $request->id,
    'idFil'=> $request->idFil,
    'niv'=> $request->niv,
    'titreCourt'=> $request->titreCourt,
    'titre'=> $request->titre,
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
    public function getClasse(Request $request){
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

        $totalRecords = Classe::select('count(*) as allcount')->count();



        $totalRecordswithFilter = Classe::select('count(*) as allcount')
                                    ->where('titreCourt','like','%'.$searchValue.'%')
                                    ->count();

        $records = Classe::orderby($columnName,$columnSortorder)   
                            ->where('classes.titreCourt','like','%'.$searchValue.'%')
                            ->select('classes.id','classes.idFil','niveaux.nom','classes.titreCourt','classes.titre','classes.anneeUniversitaire','classes.nbrEtudiant')
                            ->join('niveaux','classes.niv','niveaux.id')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $id = $record->id;
            $idFil = $record->idFil;
            $niv = $record->nom;
            $titreCourt = $record->titreCourt;
            $titre = $record->titre;
            $anneeUniversitaire = $record->anneeUniversitaire;
            $nbrEtudiant = $record->nbrEtudiant;

            $data_arr[] = array(
                "id" => $id,
                "idFil" => $idFil,
                "niv" => $niv,
                "titreCourt" => $titreCourt,
                "titre" => $titre,
                "anneeUniversitaire"=>$anneeUniversitaire,
                "nbrEtudiant"=>$nbrEtudiant
             
               
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
