<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Calendar;
use App\Matiere;
use App\Groupe;
use App\Professeur;
use App\Salle;
use App\Classe;
use App\Emploicour;
use App\Jour;
use App\Departement;
use App\Filiere;
use App\Semestrecourant;
use App\Profcoursgroupe;
use DB;
use PDF;
class EmploicoursController extends Controller
{

    //listes déroulantes
   public function listeDeroul()
    {
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

            $mats=Matiere::all();
                                            
            $filieres=Filiere::all();
            $classes=Classe::all();
            $pcg=DB::select("select pcg.idProf, pcg.idMat,pcg.idGroupe, p.Nom,  g.ordre from profcoursgroupes pcg, professeurs p, groupes g, matieres m  where pcg.idProf=p.Matricule and g.idGroupe=pcg.idGroupe and
            m.nummat=pcg.idMat ");
            $profs=Professeur::all();
            $depts=Departement::all();
            $salles=Salle::all();
            $grps=Groupe::join('classes','classes.id','=','groupes.idClasse')
                          ->join('filieres','filieres.idFil','=','classes.idFil')
                          ->get(['groupes.idGroupe','groupes.ordre','classes.idFil','classes.titreCourt']);
          
            $semestreCourants=Semestrecourant::all()->first();
            return view('calendarClasse',compact('mats','grps', 'profs','pcg','salles','depts','filieres','classes','semestreCourants','numberWeekOfSemestre','weekOfSemestre','numWeekNow'));
    }



//Filter filieres
    public function filterFilGroupe($idFil,$semestre)
    {
        $matieres=DB::select("select * from matieres where  idFil='$idFil' and semestre=$semestre");
       //Prof du groupe
       $profgroupe=DB::select("select pcg.idProf, p.Nom from profcoursgroupes pcg, professeurs p, groupes g,classes c where pcg.idProf=p.Matricule and g.idGroupe=pcg.idGroupe and c.id=g.idClasse and  c.idFil='$idFil'");

         $groupes=DB::select("select distinct groupes.idGroupe, groupes.ordre, classes.idFil, classes.titreCourt from groupes, classes, filieres, matieres  where classes.id=groupes.idClasse and filieres.idFil=classes.idFil and  matieres.idFil=filieres.idFil and matieres.semestre='$semestre' and  classes.idFil='$idFil'");
        
        return response()->json(['groupes' => $groupes, 'matieres'=>$matieres, 'profgroupe'=>$profgroupe],200);
    }

public function index(){
    //calendrier
           $events=Emploicour::join('matieres','matieres.nummat','=','emploicours.idMat')
                                
                                ->join('salles','salles.id','=','emploicours.idSalle')
                                 ->join('professeurs','professeurs.Matricule','=','emploicours.idProf')
                                 ->join('groupes','groupes.idGroupe','=','emploicours.idGroupe')
                                ->get(['emploicours.id','emploicours.idGroupe','emploicours.idProf','emploicours.idMat','emploicours.idSalle','matieres.mat','emploicours.typeCours','emploicours.heureDebut', 'emploicours.heureFin','salles.nomsalle','professeurs.Nom']);


           $eventTab = [];
            foreach ($events as $event) {
            $data=[ 
                   "title"=> $event->mat,
                    "start"=>$event->heureDebut,
                    "end"=>$event->heureFin,
                    "id"=>$event->id,
                   "idGroupe"=>$event->idGroupe,
                    "idProf"=>$event->idProf,
                    "idMat"=>$event->idMat,
                    "idSalle"=>$event->idSalle,
                    "prof"=>$event->Nom,
                    "Salle"=>$event->nomsalle,
                    "typeCours"=>$event->typeCours,
                    "idDuplicate"=>$event->idDuplicate,
                    "backgroundColor"=>'#636e72',
                    "textColor"=>'white',
                    "position"=>'relative'
                   
                   
          
           
        ];
            array_push($eventTab, $data);
                }

   return response()->json($eventTab);
}

//Filter
 public function showProf($idProf,$anneeCourante)
 {
    //and matieres.semestre=$semestreCourant"
    //$semestreCourant
 //    $dateNow=date('Y-m-d');
   // $numWeekNow=date('W',strtotime($dateNow));
//   echo $dateNow.' et '.$numWeekNow;
$events=DB::select("select emploicours.id,emploicours.idGroupe,emploicours.idProf,emploicours.idMat,emploicours.idSalle,matieres.mat,emploicours.typeCours,emploicours.heureDebut,emploicours.idDuplicate, emploicours.heureFin,salles.nomsalle,professeurs.Nom,classes.titreCourt,groupes.ordre From emploicours, matieres, salles, professeurs, groupes, classes where classes.id=groupes.idClasse and groupes.idGroupe=emploicours.idGroupe and  professeurs.Matricule=emploicours.idProf and salles.id=emploicours.idSalle and matieres.nummat=emploicours.idMat  and emploicours.idProf ='$idProf' and subString(emploicours.heureDebut,1,4)>=$anneeCourante and subString(emploicours.heureDebut,1,4)<=($anneeCourante+1)" );
   
             $eventTab = [];
            foreach ($events as $event) {
            $data=[ 
            "id"=>$event->id,
            "idGroupe"=>$event->idGroupe,
            "idProf"=>$event->idProf,
            "idMat"=>$event->idMat,
            "idSalle"=>$event->idSalle,
           "title"=> $event->mat,
           "start"=>$event->heureDebut,
           "end"=>$event->heureFin,
           "prof"=>$event->Nom,
           "Salle"=>$event->nomsalle,
           "typeCours"=>$event->typeCours,
           "titreCourt"=>$event->titreCourt,
           "ordre"=>$event->ordre,
           "idDuplicate"=>$event->idDuplicate,
           "backgroundColor"=>'gray',
           "textColor"=>'white'
        ];
            array_push($eventTab, $data);
                }
        return response()->json($eventTab);
                   
 }


public function showGroupe($anneeCourante,$semestreCourant,$idFil,$idGroupe)
 {
    $events=DB::select("select emploicours.id,emploicours.idGroupe,emploicours.idProf,emploicours.idMat,emploicours.idSalle,matieres.mat,emploicours.typeCours,emploicours.heureDebut, emploicours.idDuplicate, emploicours.heureFin,salles.nomsalle,professeurs.Nom,classes.titreCourt,groupes.ordre From emploicours, matieres, salles, professeurs, groupes, classes where groupes.idGroupe=emploicours.idGroupe and  professeurs.Matricule=emploicours.idProf and classes.id=groupes.idClasse and salles.id=emploicours.idSalle and matieres.nummat=emploicours.idMat  and emploicours.idGroupe =$idGroupe and subString(emploicours.heureDebut,1,4)>=$anneeCourante and subString(emploicours.heureDebut,1,4)<=($anneeCourante+1) and matieres.semestre=$semestreCourant and classes.idFil='$idFil'" );
   
                         
         $eventTab = [];
            foreach ($events as $event) {
            $data=[ 
            "id"=>$event->id,
            "idGroupe"=>$event->idGroupe,
            "idProf"=>$event->idProf,
            "idMat"=>$event->idMat,
            "idSalle"=>$event->idSalle,
           "title"=> $event->mat,
           "start"=>$event->heureDebut,
           "end"=>$event->heureFin,
           "prof"=>$event->Nom,
           "Salle"=>$event->nomsalle,
           "typeCours"=>$event->typeCours,
           "titreCourt"=>$event->titreCourt,
           "ordre"=>$event->ordre,
           "idDuplicate"=>$event->idDuplicate,
           "backgroundColor"=>'gray',
           "textColor"=>'white',
           "padding"=>'1em'
        ];
            array_push($eventTab, $data);
                }
        return response()->json($eventTab);
 }
 
//Ajout 
public function ajoutEvent(Request $request)
{
    $date_f=date('Y-m-d H:i:s', strtotime($request->dateFin));
       
            $date1=date('Y-m-d H:i:s', strtotime( $request->heureDebut) );
            $date2=date('Y-m-d H:i:s', strtotime($request->heureFin) );
$f=date('N',strtotime($date1));
//$r=date('Y-m-d', strtotime('2021-07-20'-$f));
            
            $idGroupe= $request->idGroupe;
            $idProf= $request->idProf;
            $idMat= $request->idMat;
            $idSalle= $request->idSalle;
            $typeCours= $request->typeCours;
            $heureDebut= $request->heureDebut;
            $heureFin= $request->heureFin;

//validation des champs
            $emploicour=Emploicour::all();
            foreach($emploicour as $e)
            {
       
        if($e->idProf==$idProf && $e->heureDebut==$heureDebut && $e->heureFin==$heureFin){
            return response()->json(['message'=>'Ce professeur est occupé']);
        }
       elseif($e->idSalle==$idSalle& $e->heureDebut==$heureDebut && $e->heureFin==$heureFin ){

         return response()->json(['message'=>'Salle est dèjà occupé']);
        
       }
       elseif($e->idGroupe==$idGroupe && $e->idSalle==$idSalle && $e->heureDebut==$heureDebut && $e->heureFin==$heureFin){

         return response()->json(['message'=>'Groupe est  occupé']);
        
       }
       elseif($e->idProf==$idProf && $e->idGroupe==$idGroupe && $e->idMat==$idMat and $e->idSalle==$idSalle and $e->heureDebut==$heureDebut and $e->heureFin==$heureFin){
            return response()->json(['message'=>'Ce cours existe déjà']);
        }
         
            }
                   if($request->unique=="on"){
                 $emp=DB::insert("insert into emploicours (idGroupe, idProf, idMat, idSalle, typeCours, heureDebut, heureFin, idJour) values($idGroupe, $idProf, '$idMat', $idSalle, '$typeCours','$heureDebut','$heureFin', dayofweek('$heureDebut'))");
                   
                return response()->json(['success'=>'added','emp'=>$emp]);

                
                    }

               elseif($request->repetition=="on"){
               
                     $i=0;

               while($date1< $date_f){

                 $i++;
                 $emp=new Emploicour;
                  $emp->idGroupe= $request->idGroupe;
                   $emp->idProf= $request->idProf;
                   $emp->idMat= $request->idMat;
                   $emp->idSalle= $request->idSalle;
                    $emp->typeCours= $request->typeCours;
                    $emp->save();
                    $updateEmp = Emploicour::find($emp->id);
                    $idDuplicate;
                    $idJour;
                    if($i==1){
                         $date1=date('Y-m-d H:i:s',strtotime('+0 days', strtotime($date1) ));
                           
                 $date2=date('Y-m-d H:i:s',strtotime('+0 days', strtotime($date2 )));
                   
                    $updateEmp->heureDebut=$date1;
                    $updateEmp->heureFin= $date2;
                    $updateEmp->idJour= $idJour=date('w',strtotime($date1))+1;
                    $updateEmp->idDuplicate = $emp->id;
                    $updateEmp->save();
                    $idDuplicate = $emp->id;
                    $idJour=$updateEmp->idJour;
             
            }
            else{
                   $date1=date('Y-m-d H:i:s',strtotime('+7 days', strtotime($date1) ));
                $date2=date('Y-m-d H:i:s',strtotime('+7 days', strtotime($date2 )));

              

               $updateEmp->heureDebut=$date1;
                    $updateEmp->heureFin= $date2;
                    $updateEmp->idDuplicate = $idDuplicate;
                    $updateEmp->idJour=$idJour;
                    $updateEmp->save();
        }
           

           }
          $emp1=Emploicour::find($emp->id);
             return response()->json(['success'=>'added', 'emp1'=>$emp1]);

     //  return response()->json($emp);
          // $emp1=Emploicour::find($emp->id);

       //    return  response()->json($emp1);
       //    return dd($emp1);

        }
             
   
   }
    



//Update and Delete 

     public function action(Request $request)
     {

            if($request->ajax())
            {
                   //Supprimer cours 1er cas
                    if($request->type=='delete1')
                    {

                        $resultat=Emploicour::find($request->id);
                        $resultat->delete();
                        return response()->json($resultat);

                    }

                    //Supprimer cours 2em cas
                    if($request->type=='delete2')
                    {
                        $idProf= $request->idProf;
                        $idGroupe= $request->idGroupe;
                        $idSalle= $request->idSalle;
                        $idMat= $request->idMat;
                        $dateCurrent= $request->start;
                        $end= $request->end;
                         // dd($dateCurrent);
                          
       $events = DB::delete("delete from emploicours where heureDebut<'$dateCurrent' and idProf=$idProf and idGroupe=$idGroupe and idMat='$idMat' and idSalle=$idSalle ");
              
             
               
                    }

                    //Supprimer cours 3em cas
                    if($request->type=='delete3')
                    {
                      
                        $idProf= $request->idProf;
                        $idGroupe= $request->idGroupe;
                        $idSalle= $request->idSalle;
                        $idMat= $request->idMat;
                        $dateCurrent= $request->start;
                        $end= $request->end;
                         // dd($dateCurrent);
                          
       $events = DB::delete("delete from emploicours where heureDebut>'$dateCurrent' and idProf=$idProf and idGroupe=$idGroupe and idMat='$idMat' and idSalle=$idSalle ");
              
                    }


                     //Supprimer cours 4em cas
                    if($request->type=='delete4')
                    {
                       
                       
                        $idProf= $request->idProf;
                        $idGroupe= $request->idGroupe;
                        $idSalle= $request->idSalle;
                        $idMat= $request->idMat;
                        $dateCurrent= $request->start;
                        $end= $request->end;

                         // dd($dateCurrent);
                          
       $events = DB::delete("delete from emploicours where idProf=$idProf and idGroupe=$idGroupe and idMat='$idMat' and idSalle=$idSalle ");
              
              return response()->json($events);
               
                    }

                    //Mise à jour
                    if($request->type=='update')
                    {
                      
                   $idJ=date('w',strtotime($request->start))+1;
                        $resultat=Emploicour::where('id',$request->id)->update([
                        "idGroupe"=>$request->idGroupe,
                        "idProf"=>$request->idProf,
                        "idMat"=>$request->idMat,
                        "idSalle"=>$request->idSalle,
                        "typeCours"=>$request->typeCours,
                        "heureDebut"=> $request->start,
                        "heureFin"=> $request->end,
                        "idJour"=>$idJ,
                        "id"=>$request->id

                        ]);

                        return response()->json($resultat);

                    }

                    //Mise à jour
                    if($request->type=='update1')
                    {

                           //recuperation des donnees
                         $idGroupe=$request->idGroupeModif;
                         $idProf=$request->idProfModif;
                          $idMat=$request->idMat;
                          $idSalle=$request->idSalle;
                           $typeCours=$request->typeCours;
                            $start=$request->start;
                             $end=$request->end;
                             $idDuplicate=$request->idDuplicateM;
                             $id=$request->idM;

                        //validation des champs
      
        /*        foreach($emploicour as $e)
            {
       if($e->idProf==$idProf && $e->idGroupe==$idGroupe && $e->idMat==$idMat and $e->idSalle==$idSalle and $e->heureDebut==$heureDebut and $e->heureFin==$heureFin){
            return response()->json(['message'=>'Ce cours existe déjà']);
        }
        elseif($e->idProf==$idProf && $e->heureDebut==$heureDebut && $e->heureFin==$heureFin){
            return response()->json(['message'=>'Ce professeur est occupé']);
        }
       elseif($e->idGroupe==$idGroupe && $e->heureDebut==$heureDebut && $e->heureFin==$heureFin){

         return response()->json(['message'=>'Ce groupe est occupé']);
        
       }
         
            }*/
         $emploicour=DB::select("select idDuplicate from emploicours where idDuplicate=$idDuplicate");
         $i=count($emploicour);
         //dd($i);
         $j=0;
           while($j<=$i){
           $j++;
           if($j==1){
             $date1=date('Y-m-d H:i:s',strtotime('+0 days', strtotime($start) ));
             $date2=date('Y-m-d H:i:s',strtotime('+0 days', strtotime($end )));

             $resultat=DB::update("update emploicours set 
                        idGroupe=$idGroupe,
                        idProf=$idProf,
                        idMat='$idMat',
                        idSalle=$idSalle,
                        heureDebut=$date1,
                        heureFin=$date2,
                        typeCours='$typeCours' where  idDuplicate=$idDuplicate
                        "
                        );
            }

         else{
          //  dd(count($emploicour->idDuplicate));
             $date1=date('Y-m-d H:i:s',strtotime('+7 days', strtotime($start) ));
             $date2=date('Y-m-d H:i:s',strtotime('+7 days', strtotime($end )));
            
               // dd($date1);
                   $resultat=DB::update("update emploicours set 
                        idGroupe=$idGroupe,
                        idProf=$idProf,
                        idMat='$idMat',
                        idSalle=$idSalle,
                        heureDebut=$date1,
                        heureFin=$date2,
                        typeCours='$typeCours' where  idDuplicate=$idDuplicate
                        "
                        );
                 }
                     }

                   return response()->json($resultat);


                    }
            }
                 


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
  //  echo $dateDebutWeek;
    for($day=1;$day<7;$day++){
        //on incremente les jours 
        $dateDebutWeek=date('Y-m-d', strtotime(' '.$dateDebutWeek ."+1 day"));
        $days[$day]=$dateDebutWeek;
    }
    echo(json_encode($days));
}


     
          //Impression de l'emploi 

            public function empPdf(Request $request){
              
               $anneeCourante=$request->annee;
               $semestre=$request->semestre;
               $idFil=$request->idFil;
               $idGroupe=$request->idGroupe;
               $idProf=$request->idProf;
               $dateDebutW=$request->ListDays;
            $dateFinW=date('Y-m-d', strtotime(' '.$dateDebutW ."+6 day"));
        
       

        //Annee universitaire
        $annUniv=Semestrecourant::first();
        if($idGroupe!=''){
    $grp=DB::select("select distinct c.titreCourt, c.titre, g.ordre from emploicours e, groupes g,  classes c where g.idGroupe=e.idGroupe and c.id=g.idClasse  and e.idGroupe=$idGroupe");
    
       $events=DB::select("select e.id, e.idGroupe, e.idProf, e.idMat, e.idSalle, j.jour,m.mat, e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD, substring(cast(e.heureFin as time),1,5) as hF, dayofweek(substring(e.heureDebut,1,10)) as jou, s.nomsalle, p.Nom, c.titreCourt, c.titre, g.ordre From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c, jours j where g.idGroupe=e.idGroupe and c.id=g.idClasse and p.Matricule=e.idProf and s.id=e.idSalle and m.nummat=e.idMat and e.idJour=j.id and subString(e.heureDebut,1,4)>=$anneeCourante and subString(e.heureDebut,1,4)<=($anneeCourante+1) and m.semestre=$semestre and c.idFil='$idFil' and e.idGroupe=$idGroupe  and substring(cast(e.heureDebut as date),1,10) BETWEEN '$dateDebutW' and '$dateFinW'  order by substring(cast(e.heureDebut as time),1,5), substring(cast(e.heureFin as time),1,5) asc");

$e= json_encode($events);
$event=json_decode($e,true);  
                    
   $data=[];
    for($i=0;$i<count($events);$i++){
        $data[$event[$i]['jou']][substr($event[$i]['hD'],0,2)]=$event[$i];
    }
   $sentData['event']=$data;
    return view('emploi_pdf',$sentData, compact('annUniv','events','grp'));
    
                  }

                  elseif($idProf!=''){
        $events=DB::select("select e.id, e.idGroupe, e.idProf,e.idMat, e.idSalle, j.jour,m.mat,m.semestre, e.typeCours, substring(cast(e.heureDebut as time),1,5) as hD, substring(cast(e.heureFin as time),1,5) as hF, e.typeCours, dayofweek(e.heureDebut) as jou, s.nomsalle, p.Nom, c.titreCourt, g.ordre From emploicours e, matieres m, salles s, professeurs p, groupes g, classes c, jours j where g.idGroupe=e.idGroupe and c.id=g.idClasse and p.Matricule=e.idProf and s.id=e.idSalle and m.nummat=e.idMat and e.idJour=j.id and subString(e.heureDebut,1,4)>=$anneeCourante and subString(e.heureDebut,1,4)<=($anneeCourante+1) and e.idProf=$idProf and substring(cast(e.heureDebut as date),1,10) BETWEEN '$dateDebutW' and '$dateFinW'  order by substring(cast(e.heureDebut as time),1,5), substring(cast(e.heureFin as time),1,5) asc");

     $prof=DB::select("select distinct p.Nom from emploicours e, professeurs p where  e.idProf=p.Matricule and e.idProf=$idProf");

           $e= json_encode($events);
        $event=json_decode($e,true);  
                    
       $data=[];
        for($i=0;$i<count($events);$i++){
            $data[$event[$i]['jou']][substr($event[$i]['hD'],0,2)]=$event[$i];
        }
       $sentData['event']=$data;
        return view('empEnseig_pdf',$sentData, compact('annUniv','events','prof'));
    
                      
                  }

                }



}

