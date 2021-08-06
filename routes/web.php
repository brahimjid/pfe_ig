<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Salle
Route::get("Sliste", "SallesController@index");
Route::post("/sup","SallesController@destroy");
Route::post("/edit","SallesController@editer");
Route::post("/upSalle","SallesController@update");

Route::get("salles/getsalles","SallesController@getsalles")->name("salles.getsalles");
Route::get("/pdf","PdfController@exportPdf")->name("pdf");
Route::get("/excel","SallesController@exportExcel")->name("excel");

Route::post("/ajout","SallesController@ajout")->name("ajout");

//Matieres


Route::get("Mliste", "MatieresController@index");
Route::get("Matieres/getmatieres","MatieresController@getmatieres")->name("matieres.getmatieres");
Route::post("/Msup","MatieresController@destroy");
Route::post("/Medit","MatieresController@editer");
Route::post("/upMat","MatieresController@update");
Route::post("/Majout","MatieresController@ajout")->name("Majout");

//Departement

Route::get("Dliste", "DepartementsController@index");
Route::get("Departs/getdeparts","DepartementsController@getdeparts")->name("departs.getdeparts");
Route::post("/Dsup","DepartementsController@destroy");
Route::post("/Dedit","DepartementsController@editer");
Route::post("/upDepart","DepartementsController@update");
Route::post("/Dajout","DepartementsController@ajout")->name("Dajout");


//Groupe

Route::get("Gliste", "GroupesController@index");
Route::get("Groupes/getgroupes","GroupesController@getgroupes")->name("groupe.getgroupe");
Route::post("/Gsup","GroupesController@destroy");
Route::post("/Gedit","GroupesController@editer");
Route::post("/upGroupe","GroupesController@update");
Route::post("/Gajout","GroupesController@ajout")->name("Gajout");

//Filiere

Route::get("Fliste", "FilieresController@index");
Route::get("Filieres/getfilieres","FilieresController@getfilieres")->name("filiere.getfiliere");
Route::post("/Fsup","FilieresController@destroy");
Route::post("/Fedit","FilieresController@editer");
Route::post("/upFiliere","FilieresController@update");
Route::post("/Fajout","FilieresController@ajout")->name("Fajout");


//Cycle

Route::get("Cyliste", "CyclesController@index");
Route::get("Cycles/getcycles","CyclesController@getCycle")->name("cycle.getcycle");
Route::post("/Cysup","CyclesController@destroy");
Route::post("/Cyedit","CyclesController@editer");
Route::post("/upcycle","CyclesController@update");
Route::post("/Cyajout","CyclesController@ajout")->name("Cyajout");


//CycleNiv

Route::get("CyNivliste", "CyclenivsController@index");
Route::get("CycleNiv/getcyclesNiv","CyclenivsController@getcyclesNiv")->name("cycleNiv.getcyclesNiv");
Route::post("/CyNivsup","CyclenivsController@destroy");
Route::post("/CyNivedit","CyclenivsController@editer");
Route::post("/upcycleNiv","CyclenivsController@update");
Route::post("/CyNivajout","CyclenivsController@ajout")->name("CyNivajout");



//Professeurs

Route::get("Pliste", "ProfesseursController@index");
Route::get("Prof/getProf","ProfesseursController@getProf")->name("prof.getProf");
Route::post("/Psup","ProfesseursController@destroy");
Route::post("/Pedit","ProfesseursController@editer");
Route::post("/upProf","ProfesseursController@update");
Route::post("/Pajout","ProfesseursController@ajout")->name("Pajout");
Route::post("/Gradeajout","ProfesseursController@ajoutGrade")->name("Gradeajout");


//Niveaux
Route::get("Nliste", "NiveauxController@index");
Route::get("Niveau/getNiv","NiveauxController@getNiv")->name("niv.getNiv");
Route::post("/Nsup","NiveauxController@destroy");
Route::post("/Nedit","NiveauxController@editer");
Route::post("/upNiv","NiveauxController@update");
Route::post("/Najout","NiveauxController@ajout")->name("Najout");


//Classes
Route::get("Cliste", "ClassesController@index");
Route::get("classe/getClasse","ClassesController@getClasse")->name("classe.getClasse");
Route::post("/Csup","ClassesController@destroy");
Route::post("/Cedit","ClassesController@editer");
Route::post("/upclasse","ClassesController@update");
Route::post("/Cajout","ClassesController@ajout")->name("Cajout");


//Banques
Route::get("Bliste", "BanquesController@index");
Route::get("banque/getBanque","BanquesController@getBanque")->name("banque.getBanque");
Route::post("/Bsup","BanquesController@destroy");
Route::post("/Bedit","BanquesController@editer");
Route::post("/upBanque","BanquesController@update");
Route::post("/Bajout","BanquesController@ajout")->name("Bajout");

//Jour
Route::get("Jliste", "JoursContoller@index");
Route::get("Jjour/getJour","JoursContoller@getJour")->name("jour.getJour");
Route::post("/Jsup","JoursContoller@destroy");
Route::post("/Jedit","JoursContoller@editer");
Route::post("/upJour","JoursContoller@update");
Route::post("/JRJout","JoursContoller@ajout")->name("JRJout");

//Heure
Route::get("Hliste", "HeuresController@index");
Route::get("Heur/getHeure","HeuresController@getHeure")->name("heur.getHeure");
Route::post("/Hsup","HeuresController@destroy");
Route::post("/Hedit","HeuresController@editer");
Route::post("/upHeure","HeuresController@update");
Route::post("/Hajout","HeuresController@ajout")->name("Hajout");

//Association
Route::get("Aliste", "creneaujoursController@index")->name("Aliste");
Route::get("ASC/getASC","creneaujoursController@getASC")->name("ASC.getASC");

//Index
Route::get('/accueil','AccueilController@index');

//emploie
Route::get('emp', function () {
    return view('emptemps');
});



//test
Route::get('test', function () {
    return view('test');
});

//parametre
Route::get('parametrage', function () {
    return view('parametrage');
});

//list
Route::get("list", "listsController@index");

//calendrier
Route::get('calendar','EmploicoursController@listeDeroul');

Route::post('/ajoutEvent',"EmploicoursController@ajoutEvent"); 
Route::post('/upEvent',"EmploicoursController@updateEvent"); 
Route::post('/supEvent',"EmploicoursController@deleteEvent"); 

Route::post('/Event/action',"EmploicoursController@action"); 
//Route::get('/Event/action/{idProf}',"EmploicoursController@action");
//Filter par annee universitaire et prof /{semestreCourant?}
Route::get('/filterProf/{idProf?}/{anneeCourante?}','EmploicoursController@showProf');
Route::get('/filterGrp/{anneeCourante?}/{semestreCourant?}/{idFil?}/{idGroupe?}','EmploicoursController@showGroupe');
//Affichage des profs du groupe
Route::get('/ProfGrp/{groupe?}','EmploicoursController@ProfGrp');


//Les evenements
Route::get('testEvent','EmploicoursController@index');


Route::post('/up','EmploicoursController@editer');
//Filter Filere et groupe
Route::get('filterFilere/{idFil?}/{semestre?}','EmploicoursController@filterFilGroupe');
Route::post('upSemestreCourant','EmploicoursController@updateSemestreCourant');
//Emploi du temps
//Route::get('emploi_pdfs/{anneeCourante?}/{semestreCourant?}/{idFil}/{idGroupe}', 'EmploicoursController@empPdf')->name('pdf');

Route::post('/telecharger','EmploicoursController@empPdf');
//Authentification
Auth::routes();
Route::get('/', 'HomeController@index')->name('index');
Route::get('/h', 'HomeController@home')->name('home');

//Pointage
Route::get('point', 'PointageController@getWeeks');
Route::get(' days1/{val?}','PointageController@days1');
Route::get('/year/{ListDays?}/{periode?}', 'PointageController@filter');
Route::post('/exportPoint', 'PointageController@export');
Route::post('/editPoint', 'PointageController@editerPoint');
Route::post('/upPoint', 'PointageController@updatePoint');

//Prof_Cours_Groupes
Route::get('/profcoursgrp', 'ProfcoursgroupesController@index');
Route::get('/dataProCouG','ProfcoursgroupesController@getPro');
Route::post('/ajoutPCG', 'ProfcoursgroupesController@ajout');
//Impression Test
Route::get('/testImprimer','EmploicoursController@euzza');