<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profcoursgroupe;
use App\Matiere;
use App\Groupe;
use App\Professeur;
use App\Classe;
use App\Filiere;
use DB;
class ProfcoursgroupesController extends Controller
{
    //
    public function index()
    {
        $prof=Professeur::all();
        $groupes=Groupe::join('classes','classes.id','=','groupes.idClasse')
                          ->join('filieres','filieres.idFil','=','classes.idFil')
                          ->get(['groupes.idGroupe','groupes.ordre','classes.idFil','classes.titreCourt']);
        $mat=Matiere::all();
        return view('crudProfcoursgroupes',compact('prof','groupes','mat'));
    }


 public function ajout(Request $request){
    $idProf= $request->idProf;
    $idMat=$request->idMat;
    $idGroupe= $request->idGroupe;
   // dd($idGroupe);
    $resultat=DB::insert("insert into Profcoursgroupes values($idProf, '$idMat', $idGroupe)");
/*
    $pcg=new  Profcoursgroupe;
   $pcg->idProf = $request->idProf;
   $pcg->idMat = $request->idMat;
   $pcg->idGroupe = $request->idGroupe;

   $resultat= $pcg->save();
   */
//return $resultat;
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







    public function getPro(){

            $data=DB::select("select c.titreCourt, m.mat, pcg.idProf, p.Nom,g.ordre, g.idGroupe From Profcoursgroupes pcg, matieres m, professeurs p, groupes g, classes c where g.idGroupe=pcg.idGroupe and p.Matricule=pcg.idProf and c.id=g.idGroupe and m.nummat=pcg.idMat");
 return datatables()->of($data)->make(true);
         }
         

}
