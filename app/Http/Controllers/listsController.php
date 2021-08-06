<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filiere;
use App\Departement;

use App\Matiere;
use App\Salle;
use App\Cycle;
use App\Classe;
use App\Niveau;
use App\Professeur;
use App\Groupe;
use App\emploicours;
class listsController extends Controller
{
    //
public function index(Request $request){

		$cycles= Cycle::all();
		$depts=Departement::all();
		$filieres=Filiere::all();
        $nivx=Niveau::all();
        $classes= Classe::all();
         $profs=Professeur::all();
   		return view('list',compact('cycles','depts','filieres','nivx','classes','profs'));
        
        $idProf=$request->idProf;
    	return $this->Showcalendar(Emploicour::join('matieres','matieres.nummat','=','emploicours.idMat')
    								->join('salles','salles.id','=','emploicours.idSalle')
    								->join('professeurs','professeurs.Matricule','=','emploicours.idProf')
    								->get(['matieres.mat','emploicours.typeCours', 'emploicours.heureDebut', 'emploicours.heureFin','salles.nomsalle','professeurs.Nom'])
    								

    							);
    	return $this->Showcalendar(Emploicour::where('idProf','=','$idProf')
    								->join('matieres','matieres.nummat','=','emploicours.idMat')
    								->join('salles','salles.id','=','emploicours.idSalle')
    								->join('professeurs','professeurs.Matricule','=','emploicours.idProf')
    								->get(['matieres.mat','emploicours.typeCours', 'emploicours.heureDebut', 'emploicours.heureFin','salles.nomsalle','professeurs.Nom'])
    								

    							);
    }
} 