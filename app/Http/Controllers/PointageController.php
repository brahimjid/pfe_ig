<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Emploicour;
use App\Semestrecourant;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;





class PointageController extends Controller
{



function filter($ListDays,$periode){

$data=array();
      if(!empty($ListDays && !empty($periode)))

      {

      if($periode==14){
        $data=DB::select("select e.id, c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,2) as hD ,substring(cast(e.heureFin as time),1,2) as hF, p.Nom, p.telephone,e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat  and SubString(e.heureDebut,1,11)='$ListDays' and subString(cast(e.heureFin as time),1,2)<=14");

}

        elseif($periode==19){
    $data=DB::select("select e.id, c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD ,substring(cast(e.heureFin as time),1,5) as hF, p.Nom, p.telephone, e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat and SubString(e.heureDebut,1,11)='$ListDays' and subString(cast(e.heureDebut as time),1,2)>14");

        }


    }

      else
      {
       $data = DB::table('emploicours')
         ->get();


      }

       return datatables()->of($data)->make(true);


}

   //----------------------------------euzza-----------------------------
function getWeeks(){
    // on recupere la date debut et fin du semestre
    $anneeUniversitaire=Semestrecourant::first();
    $dateDebut=$anneeUniversitaire->dateDebut;
    $dateFin=$anneeUniversitaire->dateFin;
   // $dateDebut='2021-02-28 00:00:00';
    //$dateFin='2021-09-28 00:00:00';
    // $dateFin='2021-01-28 00:00:00';
    // $dateDebut='2020-10-28 00:00:00';

   $dateNow=date('Y-m-d');
   $numWeekNow=date('W',strtotime($dateNow));
//compter le nombre des semaines dans le semestre
//recupere le nombre de semaine dans l'annee de chaque date
$nmbreDeWeekInYear_dateDebut=date('W',strtotime($dateDebut));
$nmbreDeWeekInYear_dateFin=date('W',strtotime($dateFin));
//on garde dans ces variable le mois et le jours pour savoir la maniere qu'on va utiliser pour calculer le nombre de semaine entre ces deux dates
$monthDebut=date('md',strtotime($dateDebut));
$monthFin=date('md',strtotime($dateFin));
//le cas de semestre impaire
// example:
// $dateDebut='2021-01-28 00:00:00';
// $dateFin='2021-08-28 00:00:00';
// 821>128 donc
if($monthFin>$monthDebut){
    $numberWeekOfSemestre=$nmbreDeWeekInYear_dateFin-$nmbreDeWeekInYear_dateDebut +1;
    $numWeekNow=$numWeekNow-$nmbreDeWeekInYear_dateDebut +1;}
else{
    //le cas de semestre paire
    // example:
    //  $dateDebut='2020-10-28 00:00:00';
    //  $dateFin='2021-01-28 00:00:00';
    // 128<1028 donc on va compter le nombre de week restant (52 npmbre de week dans l'annee)
    // puis on ajout le nombre de week dans la nouvel annee
    // 52-$nmbreDeWeekInYear_dateDebut= nombre de week restant dans l'annee (ex 2020)
    // $nmbreDeWeekInYear_dateFin= le nombre de week dans la nouvel annee pour la date fixe (2021-01-28 donc 4 week)
    // alors le nombte de week dans ce semestre est = rest + 4
    $numberWeekOfSemestre=(52-$nmbreDeWeekInYear_dateDebut)+$nmbreDeWeekInYear_dateFin +1;
    $numWeekNow=(52-$nmbreDeWeekInYear_dateDebut)+ $numWeekNow +1;
}

// echo $nmbreDeWeekInYear_dateDebut.'<br>'.$nmbreDeWeekInYear_dateFin.'<br>'.$numberWeekOfSemestre;

$weekOfSemestre=array();
// on recupere
$dateDebut=date('Y-m-d', strtotime('sunday '.$dateDebut ."-1 week"));
    $weekOfSemestre[1]=$this->days($dateDebut);
// $dateDebut=date('Y-m-d', strtotime('sunday '.$dateDebut ."+0 week"));
//     $weekOfSemestre[2]=$dateDebut;
for($w=2;$w<=$numberWeekOfSemestre;$w++){
    $dateDebut=date('Y-m-d', strtotime('sunday '.$dateDebut ."+1 week"));
    $weekOfSemestre[$w]=$this->days($dateDebut);
    // echo $dateDebut."<br>";
}
// echo $dateDebut;
//print_r($weekOfSemestre);
//print_r($numberWeekOfSemestre);
/*
$data['numberWeekNow']=  $numWeekNow;
$data['numberWeekOfSemestre']= $numberWeekOfSemestre;
$data['weekOfSemestre']=$weekOfSemestre;
*/
// print_r($data);
//$this->load->view('pointage',$data);
$status=DB::select("select e.id, c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,5) as heureDebut ,substring(cast(e.heureFin as time),1,5) as heureFin, p.Nom, p.telephone, e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat ");
$emploicours=Emploicour::all();
return view('pointage',compact('numberWeekOfSemestre','weekOfSemestre','numWeekNow','status','emploicours'));
}
//cette fonction prend la date debut de la semaine 'Dimanche'
// et nous retourn une array contenant les jours de la semaine
function days($dateDebutWeek){
    $days=array();
    $days[0]=$dateDebutWeek;
    for($day=1;$day<7;$day++){
        //on incremente les jours
        $dateDebutWeek=date('Y-m-d', strtotime(' '.$dateDebutWeek ."+1 day"));
        $days[$day]=$dateDebutWeek;
    }
    return $days;
}

function days1($dateDebutWeek){
    $days=array();
    $days[0]=$dateDebutWeek;
    for($day=1;$day<7;$day++){
        //on incremente les jours
        $dateDebutWeek=date('Y-m-d', strtotime(' '.$dateDebutWeek ."+1 day"));
        $days[$day]=$dateDebutWeek;
    }
    echo(json_encode($days));
}
 public function export(Request $request){

       $weekText =$request->weekText;
               $ListDays=$request->ListDays;
               $periode=$request->periode;
                $week=$request->week;
                $idJour=date('w',strtotime($ListDays))+1;
                $jour=DB::select("select  id, jour from jours where id=$idJour");
                $annUniv=Semestrecourant::first();
        if($periode==14){
 $data=DB::select("select e.id, c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,2) as hD ,substring(cast(e.heureFin as time),1,2) as hF, p.Nom, p.telephone,e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat  and SubString(heureDebut,1,11)='$ListDays' and subString(cast(heureFin as time),1,2)<=14");


            $pdf = PDF::loadView('pointageMatin',compact('data','weekText','annUniv','ListDays','periode','jour'));

            return $pdf->download('pointageMatin.pdf');

                  }

                   elseif($periode==19){
    $data=DB::select("select c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD ,substring(cast(e.heureFin as time),1,5) as hF, p.Nom, p.telephone, e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat and SubString(heureDebut,1,11)='$ListDays' and subString(cast(heureDebut as time),1,2)>14");

      $ListDays=$request->ListDays;
               $periode=$request->periode;
                $week=$request->week;
                $idJour=date('w',strtotime($ListDays))+1;
                $jour=DB::select("select  id, jour from jours where id=$idJour");
            $pdf = PDF::loadView('pointageSoire',compact('data','annUniv','weekText','ListDays','periode','jour'));

            return $pdf->download('pointageSoire.pdf');

                  }

                }

public function testExp(){
     $data=DB::select("select c.titre, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD ,substring(cast(e.heureFin as time),1,5) as hF, p.Nom, p.telephone, e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat");
}



/*public function editerPoint(Request $request){
$id=$request->id;
//dd($id);
   $resultat= DB::select("select e.id, c.titre,e.idMat, m.mat,s.nomsalle,e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD ,substring(cast(e.heureFin as time),1,5) as hF, p.Nom,e.idProf, e.statusCours From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c where g.idGroupe=e.idGroupe and p.Matricule=e.idProf and c.id=g.idGroupe and s.id=e.idSalle and m.nummat=e.idMat and e.id=$id");
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

public function updatePoint(Request $request){
    // dd($request->id);
  $resultat= Emploicour::where('id',$request->id)->update([
    'id'=> $request->id,
    'statusCours'=> $request->statusCours
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
}*/


public function editerPoint(Request $request){
     //dd($request->id);
   $resultat= Emploicour::where('id',$request->id)->first();

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


public function updatePoint(Request $request){
    //dd($request->id);
 /* $statusCours=$request->statusCours;
  $id =$request->id;
$resultat=DB::update("update emploicours set statusCours='$statusCours' where id=$id");*/

$emp = Emploicour::find($request->id);
   $emp->statusCours = $request->statusCours;
   $emp->save();



/*  $resultat= Emploicour::where('id',$request->id)->update([
    'id'=> $request->id,

    'statusCours'=> $request->statusCours

   ]);*/

    // if($emp){
        return response()->json([
            'message'=>"modification avec succès",
            "code"=>200
            // "data"=>$resultat
    ]);

    // }
/*    else{
return response()->json([
    'message'=>"modification échouée",
            "code"=>500
    ]);
}*/

}


}




