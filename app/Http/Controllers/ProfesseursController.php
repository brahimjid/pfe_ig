<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Professeur;
use App\Departement;
use App\Banque;
use App\Grade;

class ProfesseursController extends Controller
{

public function index(){
          $departs= Departement::all();
          $banques= Banque::all();
          $grades= Grade::all();
          
        return view('crudprofesseurs',compact('departs','banques', 'grades'));

    }

   
    //ajout 

public function ajout(Request $request){
   
    //validation des champs
  /* $this->validate($request,[
    'Matricule'=>'required',
    'Nom'=>'required',
    'nodep'=>'required',
    'type'=>'required',
    'telephone'=>'required'
   ]);
   */

    $prof=new Professeur;
    $prof->Matricule=$request->Matricule;
    $prof->Nom= $request->Nom;
    $prof->Noma=$request->Noma;
    $prof->nodep=$request->nodep;
    $prof->type=$request->type;
    $prof->Adresse=$request->Adresse;
    $prof->daten=$request->daten;
    $prof->lieun=$request->lieun;
    $prof->Nat=$request->Nat;
    $prof->telephone=$request->telephone;
    $prof->email=$request->email;
    $prof->Diplome=$request->Diplome;
    $prof->TauxHor=$request->TauxHor;
    $prof->NbHrAPayer=$request->NbHrAPayer;
    $prof->sexe=$request->sexe;
    $prof->Banque=$request->Banque;
    $prof->NumCompte=$request->NumCompte;
    $prof->nbcours=$request->nbcours;
    $prof->grade=$request->grade;
    $prof->Nomf=$request->Nomf;
    
   $resultat= $prof->save();

   if($resultat){
        return response()->json([
            'message'=>"ajout avec succès",
            "code"=>200
    ]);

    }
    else{
return response()->json([
    'message'=>"ajout échoué",
            "code"=>500
    ]);
}
   
}
//supprimer
public function destroy(Request $request){
     
   $resultat= Professeur::find($request->Matricule);
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

//editer
public function editer(Request $request){
     
   $resultat= Professeur::where('Matricule',$request->Matricule)->first();
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
   
  $resultat= Professeur::where('Matricule',$request->Matricule)->update([
    'Matricule'=> $request->Matricule,
    'Nom'=> $request->Nom,
    'Noma'=>$request->Noma,
    'nodep'=>$request->nodep,
    'type'=>$request->type,
    'Adresse'=>$request->Adresse,
    'daten'=>$request->daten,
    'lieun'=>$request->lieun,
    'Nat'=>$request->Nat,
    'telephone'=>$request->telephone,
    'email'=>$request->email,
    'Diplome'=>$request->Diplome,
    'TauxHor'=>$request->TauxHor,
    'NbHrAPayer'=>$request->NbHrAPayer,
    'sexe'=>$request->sexe,
    'Banque'=>$request->Banque,
    'NumCompte'=>$request->NumCompte,
    'nbcours'=>$request->nbcours,
    'grade'=>$request->grade,
    'Nomf'=>$request->Nomf
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

//Datatables
    ## AJAX request
    public function getProf(Request $request){
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

        $totalRecords = Professeur::select('count(*) as allcount')->count();


        $totalRecordswithFilter = Professeur::select('count(*) as allcount')
                                    ->where('Nom','like','%'.$searchValue.'%')
                                    ->count();

        $records = Professeur::orderby($columnName,$columnSortorder)   
                            ->where('professeurs.Nom','like','%'.$searchValue.'%')
                            ->select('professeurs.Matricule','professeurs.Nom','professeurs.Noma','departements.LDEPL','professeurs.type','professeurs.Adresse','professeurs.daten','professeurs.lieun','professeurs.Nat','professeurs.telephone','professeurs.email','professeurs.Diplome','professeurs.TauxHor','professeurs.NbHrAPayer','professeurs.sexe','professeurs.Banque','professeurs.NumCompte','professeurs.nbcours','professeurs.grade','professeurs.Nomf')
                            ->join('departements','professeurs.nodep','departements.NODEP')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

// ->select('professeurs.*')
    
          foreach($records as $record){
            $matricule = $record->Matricule;
            $nom = $record->Nom;
            $noma=$record->Noma;
            $nodep =$record->LDEPL;
            $type =$record->type;
            $adresse =$record->Adresse;
            $daten =$record->daten;
            $lieun  =$record->lieun;
            $nat   =$record->Nat;
            $tel =$record->telephone;
            $email =$record->email;
            $diplome =$record->Diplome;
            $tHor =$record->TauxHor;
            $nbHrAPayer =$record->NbHrAPayer;
            $sexe  =$record->sexe;
            $banque =$record->Banque;
            $numcompte=$record->NumCompte;
            $nbcours =$record->nbcours;
            $grade =$record->grade;
            $nomf=$record->Nomf;

            
      
            $data_arr[] = array(
             "Matricule"=>$matricule,
            "Nom"=>$nom,
            "Noma"=>$noma,
            "nodep"=>$nodep,
            "type"=>$type,
            "Adresse"=>$adresse,
            "daten"=>$daten,
            "lieun"=>$lieun,
            "Nat"=>$nat,
            "telephone"=>$tel,
            "email"=>$email,
            "Diplome"=>$diplome,
            "TauxHor"=>$tHor,
             "NbHrAPayer"=>$nbHrAPayer,
            "sexe"=> $sexe,
            "Banque"=>$banque,
            "NumCompte"=>$numcompte,
            "nbcours"=>$nbcours,
           "grade"=>$grade,
           "Nomf"=>$nomf
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

 public function ajoutGrade(Request $request)
{

     //validation des champs
   $this->validate($request,[
    'Grade'=>'required'
   ]);

    $grade=new Grade;
    $grade->Grade=$request->Grade;
     $resultat= $grade->save();

     if($resultat){
        return response()->json([
            'message'=>"ajout avec succès",
            "code"=>200
    ]);

    }
    else{
return response()->json([
    'message'=>"ajout échoué",
            "code"=>500
    ]);
}
}
}
