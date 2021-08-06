<!DOCTYPE html>
<html lang="fr">
    <head>
      <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Emploi du temps</title>


            <link rel="stylesheet" href="{{asset('bootstrap.css')}}" />
            <link rel="stylesheet" href="{{asset('lib/main.css')}}" />
            <link href="css/all.min.css" rel="stylesheet">
            <!--//select-picker-->
            <link href="{{asset('css/bootstrap-select.css')}}" rel="stylesheet">


    <style>

      body {
        margin: 0;
        padding: 0;
        font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
        font-size: 14px;
      }

      #top {
        background: #eee;
        border-bottom: 1px solid #ddd;
        padding: 0 10px;
        line-height: 40px;
        font-size: 12px;
      }

      #calendar {
        font-size: 14px;
        max-width: 1100px;
        margin: 40px auto;
        padding: 0 10px;
        position:relative;
      }
.fc-event{
    top: 102.5px;
    bottom: -225.5px;
    padding:x 1px;
    z-index: 1;
    left: :0%;
    right: :0%;
}

.pdf{
margin-top: 10px;
margin-left: 55%;
}

.act{
   margin-reight: 10%;
   margin-top: -20px;
}

    </style>
    </head>
    <body>
      <div class="container">
      <div class="navbar">
        <img src="css/lo.png" alt="" height="100" width="105" />
       <h4 class="r">GESTION DES COURS</h4>
  </div>
  </div>


<!--Multi-langues-->
      <div id='top'>

        Langues:
        <select class="custom-select" id='locale-selector'></select>

      </div>
      <br/>
      <!--Modifier semestre courant-->
    <div class="float-right"><button id="updateScurrent"><i class="fas fa-edit" title="Modifier le semestre courant"></i></button>
      <a href="./"><button ><i  class="fas fa-home"></i> Acceuil</button></a>
    </div>
    <br/><br/>
    <form id="editSemestreCurrent">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label >Année</label>
      <select id="anneeUnver" class="form-control" name="anneeUnver">
        <option disabled hidden selected>Choisir Année...</option>
        @for($i=2018; $i<2050; $i++)
                            @php
                            $a1=$i;
                            $a2=$i+1;
                            $anneeUniv=$a1."-".$a2;
                             @endphp
                            <option @if($anneeUniv==$semestreCourants->annee) selected class="border border-warning" @endif value="{{$anneeUniv}}">{{$anneeUniv}}</option>
                            @endfor
      </select>
    </div>
    <div class="form-group col-md-6">
      <label >Semestre</label>
      <select id="CurrentSemestre" class="form-control" name="CurrentSemestre">
        <option disabled hidden selected>Choisir Semestre...</option>
      <option  @if($semestreCourants->semestre==2) selected @endif value="2">Pair</option>
      <option @if($semestreCourants->semestre==3) selected @endif value="3">Impair</option>
      </select>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label >Date Debut</label>
      <input type="text-local" name="dtDebut" class="form-control" value="{{$semestreCourants->dateDebut}}" id="dtDebut">
    </div>
    <div class="form-group col-md-4">
      <label >Date Fin</label>
      <input type="text-local" name="dtFin" class="form-control" value="{{$semestreCourants->dateFin}}" id="dtFin">
    </div>
  <button id="closeForm" type="button" class="btn btn-danger btn-sm">Annuler</button>
  <button id="btnupSemestre" type="button" class="btn btn-primary btn-sm">Enregistrer</button>
</div>
</form>

      <br/><br/>
      <!--Filter Calendar-->
        <div class="card w-105" >
        <div class="card-body">
          <br/>
          <center><h5 class="card-title">Afficher selon :</h5></center>
          <div class="input-group mb-3">
            <form id="formFilter" method='POST' action='/telecharger'>
                 @csrf
                 <div class="btn-group">
                            &nbsp;
                          <select class="custom-select"  name="annee" id="annee">
                            <option disabled hidden selected>Choisir Année...</option>
                            @for($i=2018; $i<2050; $i++)
                            @php
                            $a1=$i;
                            $a2=$i+1;
                            $anneeUniv=$a1."-".$a2;
                             @endphp
                            <option @if($anneeUniv==$semestreCourants->annee) selected class="border border-warning" @endif value="{{$i}}">{{$anneeUniv}}</option>
                            @endfor
                          </select>
                       &nbsp;&nbsp;
                          <select class="custom-select"  name="semestre" id="semestre">
                              <option disabled hidden selected>Choisir Semestre...</option>

                              @if($semestreCourants->semestre%2!=0)
                              <option value="1">S1</option>
                              <option value="3">S3</option>
                              <option value="5">S5</option>
                             @endif
                             @if($semestreCourants->semestre%2==0)
                             <option value="2">S2</option>
                              <option value="4">S4</option>
                              <option value="6">S6</option>
                              @endif
                          </select>
                           &nbsp;&nbsp;
                          <select class="custom-select" name="idFil" id="idFil">
                                <option disabled hidden selected>Choisir Filière...</option>
                              @foreach($filieres as $filiere)
                                <option value="{{$filiere->idFil}}">{{$filiere->idFil}}</option>
                               @endForeach
                          </select>
                           &nbsp;&nbsp;
                          <select class="custom-select"  name="idGroupe" id="idGroupeFilter">
                              <option disabled hidden selected >Choisir Groupe...</option>

                          </select>
                           &nbsp;&nbsp;
                          <select  class="selectpicker" data-live-search="true" name="idProf" id="idProfFilter">
                           <option disabled hidden selected>Choisir Professeur...</option>
                              @foreach($profs as $prof)
                               <option value="{{$prof->Matricule}}">{{$prof->Nom}}</option>
                              @endForeach

                          </select>
&nbsp;
            <select class="custom-select" name='' id='week'>
                <option disabled selected>Choisir Semaine...</option>
                <?php for($week=1;$week<$numberWeekOfSemestre;$week++){
                echo "<option value='".$weekOfSemestre[$week][0]."' ";
                if($week==$numWeekNow)
                    echo "selected";
                echo ">S-$week</option>";
                }
                ?>
            </select>
&nbsp;
        <select class="custom-select" name='ListDays' id='ListDays'>
            <option disabled selected>Choisir Jour...</option>
        </select>
</div>
                  <div class="pull-right">
                   <div class="pdf"><button  type="submit" class="btn btn-primary btn-sm" id="imp"><i class="fas fa-print" title="Export Pdf">PDF</i></button></div>
                      </form> <br>
                  </div>

                      </div>
</div>
                        </div>









      <!--Calendrier-->
      <div id='calendar'></div>

      <!--Formulaire d'ajout d'un cours-->
      <div class="col-md-9">
    <div id="fajout" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
              <div class="modal-header">
                <h5 id='titre' class="modal-title">Ajout d'un cours</h5>
                <button type="button" id="close" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div id='mbody' class="modal-body">
              <form action='' method="post" id="form1">
                            @csrf
                        <div class="col-lg-4 col-sm-4">
                          <label class="radio-inline"><input id="hebdo" type="radio" name="repetition" checked>Hebdomadaire</label>
                         <label id="DFin"> Date Fin <input  type="text" name="dateFin" value="{{$semestreCourants->dateFin}}"></label>
                           <br>
                          <label class="radio-inline"><input id="unique" type="radio" name="unique">Unique</label>

                        </div>
                        <div class="form-group row">
                        <div class="col-sm-10">
                        <input class="form-control" type="hidden" name="idGroupe" id="idGroupe">
                      <input class="form-control" type="text"  id="groupe" readonly>
                    </div>
                  </div>


                         <div class="input-group mb-3">
                          <select class="custom-select"  name="idProf" id="idProf">
                              <option  disabled hidden selected >Choisir Professeur...</option>
                             @foreach($profs as $p)
                              <option value="{{$p->Matricule}}">{{$p->Nom}}</option>
                              @endforeach
                          </select>
                        </div>

                        <div class="input-group mb-3">
                          <select class="custom-select"  id="idMat" name="idMat">
                              <option  disabled hidden selected>Choisir Matière...</option>
                          </select>
                        </div>

                        <div class="input-group mb-3">
                          <select class="custom-select"  id="idSalle" name="idSalle">
                              <option disabled hidden selected\
                               >Choisir Salle...</option>
                            @foreach($salles as $salle)
                              <option value="{{$salle->id}}">{{$salle->nomsalle}}</option>
                            @endForeach
                          </select>
                        </div>

         <div class="input-group mb-3">
                          <select class="custom-select"  id="typeCours" name="typeCours">
                              <option disabled hidden selected>Choisir Type...</option>
                              <option value="TP">TP</option>
                              <option value="TD">TD</option>
                              <option value="Cours">Cours</option>
                              <option value="Autres">Autres</option>
                          </select>
                        </div>

          <div class="col-lg-4 col-sm-4"> Date Debut</div>
          <div class="row">
          <div class="col-lg-8 col-sm-8"><input type=text name=heureDebut id=startTime class=form-control></div>
             </div>
          <div class="col-lg-4 col-sm-4">Date Fin</div>
          <div class="row">
          <div class="col-lg-8 col-sm-8"><input type=text name=heureFin id=endTime class=form-control></div>
          </div>
          </form>
          <span id="error" class="text-danger"></span>
          </div>

          <div class="modal-footer">
             <button  type="submit" id='btnaddc' class="btn btn-info btn-sm">Enregistrer</button>

          </div>
        </div>
      </div>
    </div>

<!--Form : update, duplicate and delete-->

<div class="modal" id="fupd" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Cours</h5>
        <button type="button" class="close" id="fermer" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="idEvent">
        <p id="cours"></p>
        <div id="suppCas">
        <form action='' method='post' id='formSupr'>
          uniquement pour cet événement : <input id="pcas" type="radio" name="cas"><br>
          tous les événements avant : <input  id="dcas" type="radio" name="cas"><br>
          tous les événements après : <input id="trcas" type="radio" name="cas"><br>
          tous les événements : <input id="qcas" type="radio" name="cas"><br>
      </form>
      </div>
      <div class="modal-footer">
        <button id="edit" type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit" title="Modifier"></i></button>
        <button id="delete" type="button" class="btn btn-warning btn-sm" data-dismiss="modal"><i class="fas fa-trash" title="Supprimer"></i></button>
    </div>
  </div>
</div>
</div>
</div>

<!--Formulaire de modification d'un cours-->

    <div id="fupdate" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
              <div class="modal-header">
                <h5 id='titre' class="modal-title">Modification d'un cours</h5>
                <button type="button" id="fermeture" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>
          <div id='mbody' class="modal-body">
            <form action='' method=post id='form2'>
                          @csrf
                         <input class="form-control" type="hidden" name="idDuplicate" id="idDuplicate">
            <label  class="col-sm-2 col-form-label">Groupe</label>
      <div class="col-sm-10">
            <select class="custom-select" id="idGroupeModif" name="idGroupe">
          @foreach($grps as $grp)
        <option value="{{$grp->idGroupe}}">{{$grp->titreCourt}}-G{{$grp->ordre}}</option>
        @endForeach
        </select>
        </div>
      <div class="form-group row">
        <label  class="col-sm-2 col-form-label">Professeur</label>
        <div class="col-sm-10">
            <select class="custom-select" id="idProfModif" name="idProf">
          @foreach($profs as $pf)
        <option value="{{$pf->Matricule}}">{{$pf->Nom}}</option>
        @endForeach
        </select>
        </div>
      </div>

     <div class="input-group mb-3">
         Matière
        <select class="custom-select" id="idMatModif" name="idMat">
        @foreach($mats as $mat)
        <option value="{{$mat->nummat}}">{{$mat->mat}}</option>
        @endForeach
    </select>
      </div>
    <div class="input-group mb-3">Salle
      <select class="custom-select" id="idSalleModif" name="idSalle">
        @foreach($salles as $salle)
        <option value="{{$salle->id}}">{{$salle->nomsalle}}</option>
        @endForeach
    </select>
    </div>
    <div class="input-group mb-3">Type
    <select class="custom-select" id="typeCoursModif" name="typeCours">
        <option>TP</option>
        <option >TD</option>
        <option>Cours</option>
        <option >Autres</option>
    </select>
    </div>

    <div class="col-lg-4 col-sm-4"> Date Debut</div>
    <div class="row">
    <div class="col-lg-8 col-sm-8"><input type=text name=heureDebut id=MstartTime class=form-control></div>

       </div>
    <div class="col-lg-4 col-sm-4">Date Fin</div>
    <div class="row">
    <div class="col-lg-8 col-sm-8"><input type=text name=heureFin id=MendTime class=form-control></div>
    <span id="errorUpdate" class="text-danger"></span>
      </div>
    </form>
          </div>
          <div class="modal-footer">
            <button id='btnupdate' type="button" class="btn btn-primary btn-sm">Enregistrer</button>
          </div>
        </div>
      </div>
    </div>



<!--Dupliquer un evenement-->

    <div id="fdupliquer" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
              <div class="modal-header">
                <h5 id='titre' class="modal-title">Dupliquer un cours</h5>
                <button type="button" id="fermetureDup" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>

              </div>
          <div id='mbody' class="modal-body">
            <form action='' method=post id=form3>
                          @csrf
                       <div class="col-lg-4 col-sm-4">
                          <label class="radio-inline"><input id="hebdomDup" type="radio" name="repetition" checked>Hebdomadaire</label>
                         <label id="dFinalDup"> Date Fin Semestre<input  type="text" name="dateFin" value="{{$semestreCourants->dateFin}}"></label>
                           <br>
                          <label class="radio-inline"><input id="uniDup" type="radio" name="unique">Unique</label>

                        </div>

                        <div class="input-group mb-3">
                          <select class="custom-select"  name="idGroupe" id="DidGroupe">
                              <option disabled hidden selected>Choisir Groupe...</option>
                            @foreach($grps as $grp)
                              <option value="{{$grp->idGroupe}}">{{$grp->titreCourt}}-G{{$grp->ordre}}</option>
                            @endForeach
                          </select>
                          <span id="errorG" class="text-danger"></span>
                        </div>

                         <div class="input-group mb-3">
                          <select class="custom-select"  name="idProf" id="DidProf">
                              <option disabled hidden selected>Choisir Professeur...</option>
                            @foreach($pcg as $pc)
                              <option value="{{$pc->idProf}}">{{$pc->Nom}}</option>
                            @endForeach
                          </select>
                          <span id="errorP" class="text-danger"></span>
                        </div>

                        <div class="input-group mb-3">
                          <select class="custom-select"  id="DidMat" name="idMat">
                              <option disabled hidden selected>Choisir Matière...</option>
                             @foreach($mats as $mat)
                                <option value="{{$mat->nummat}}">{{$mat->mat}}</option>
                             @endForeach
                          </select>
                        </div>

                        <div class="input-group mb-3">
                          <select class="custom-select"  id="DidSalle" name="idSalle">
                              <option disabled hidden selected>Choisir Salle...</option>
                            @foreach($salles as $salle)
                              <option value="{{$salle->id}}">{{$salle->nomsalle}}</option>
                            @endForeach
                          </select>
                        </div>

              <div class="input-group mb-3">
                          <select class="custom-select"  id="DtypeCours" name="typeCours">
                              <option disabled hidden selected>Choisir Type...</option>
                              <option value="TP">TP</option>
                              <option value="TD">TD</option>
                              <option value="Cours">Cours</option>
                              <option value="Autres">Autres</option>
                          </select>
                        </div>

          <div class="col-lg-4 col-sm-4"> Date Debut</div>
          <div class="row">
          <div class="col-lg-8 col-sm-8"><input type=text name=heureDebut id=DupstartTime class=form-control></div>

             </div>
          <div class="col-lg-4 col-sm-4">Date Fin</div>
          <div class="row">
          <div class="col-lg-8 col-sm-8"><input type=text name=heureFin id=DupendTime class=form-control></div>
          </div>
          <br/>
          <span id="errors" class="text-danger"></span>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" id='btnDupliquer' class="btn btn-info btn-sm">Créer  cours</button>
          </div>
        </div>
      </div>
    </div>


          <!--//scripts-->
          <script src="{{asset('jquery.min.js')}}"></script>
          <script src="{{asset('popper.min.js')}}"></script>
          <script src="{{asset('js/bootstrap.min.js')}}"></script>
          <script src="{{asset('jquery-ui.min.js')}}"></script>
          <script src="{{asset('moment.min.js')}}"></script>
          <script src="{{asset('lib/main.js')}}"></script>
          <script src="{{asset('lib/locales-all.js')}}"></script>
          <script src="{{asset('js/bootstrap-select.min.js')}}"></script>



          <script type="text/javascript">

              document.addEventListener('DOMContentLoaded', function() {
                  console.log("here")
                  $('.selectpicker').selectpicker();
                  $.ajaxSetup({
                      headers:{
                          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                      }
                  });
//Refresh selects
                  $('#refresh').click(function(){
                      $('#annee').val('Choisir Année...');
                      $('#semestre').val('Choisir Semestre...');
                      $('#idFil').val('Choisir Filière...');
                      $('#idGroupeFilter').val('Choisir Groupe...');
                      $('#idProfFilter').val('Choisir Enseignant...');
                  });

                  //Radio Bouton Ajout

                  $('#hebdo').click(function(){
                      $('#DFin').show();
                  });

                  $('#unique').click(function(){
                      $('#DFin').hide();
                  });

//Radio Duplicate
                  $('#hebdomDup').click(function(){
                      $('#dFinalDup').show();
                  });

                  $('#uniDup').click(function(){
                      $('#dFinalDup').hide();
                  });

                  //radio bouton delete
                  $('#suppCas').hide();

                  //bouton radio
                  $('input[type="radio"]').on('change',function()
                  {

                      $('input[type="radio"]').not(this).prop('checked', false);
                  });


                  //close modal ajout et update ...
                  $('#close').on('click', function(){
                      $('#fajout').modal('hide');
                      $('#form1')[0].reset();
                      $('#error').text('');
                  });

                  $('#fermer').on('click', function(){
                      $('#fupd').modal('hide');
                  });

                  $('#fermeture').on('click', function(){
                      $('#fupdate').modal('hide');
                  });

                  //close duplicate
                  $('#fermetureDup').on('click', function(){
                      $('#fdupliquer').modal('hide');
                      // $('#fup').hide();
                  });

                  //Filter filiere et groupe
                  $('#idFil').on('change',function(){

                      //console.log(idFil);
                      var selectBox = document.getElementById('idFil');
                      var selectValue = selectBox.options[selectBox.selectedIndex].value;
                      var semestre=document.getElementById('semestre');
                      var selectValueSemestre = semestre.options[semestre.selectedIndex].value;
                      console.log(selectValue);
                      console.log(selectValueSemestre);
                      $.ajax({

                          url:'filterFilere/'+selectValue+'/'+selectValueSemestre,
                          success: function(data) {
                              // console.log(data);
                              var options = [];
                              var groupes = $('#idGroupeFilter').empty();
                              var optionsM=[];
                              var matieres=$('#idMat').empty();
                              $.each(data.groupes, function(key, element) {

                                  //$groupes.append($("<option></option>").attr("value",'').text("Choisir groupe"));
                                  groupes.append($("<option selected></option>").attr("value",element.idGroupe).text(element.titreCourt+'-G'+element.ordre));

                              });
                              $.each(data.matieres, function(key, element) {

                                  matieres.append($("<option></option>")
                                      .attr("value", element.nummat).text(element.mat));


                              });
                              /*       var profgroupe=$('#idProf').empty();
                                     $.each(data.profgroupe, function(key, element) {

                                            profgroupe.append($("<option></option>")
                                             .attr("value", element.idProf).text(element.Nom));


                                     });
                     */

                          },
                          error: function() {
                              alert("Echec");
                          }
                      });


                  });
//affecter la valeur idGroupe
                  $('#idGroupe').on('change',function(){
                      var groupe=$('#idGroupeFilter').val();

                      var idGroupe=$('#idGroupe').val(groupe);

                  });


//changer la langue

                  var initialLocaleCode = 'fr';
                  var localeSelectorEl = document.getElementById('locale-selector');
                  var calendarEl = document.getElementById('calendar');

                  var calendar = new FullCalendar.Calendar(calendarEl, {
                      height: 910,
                      contentHeight: "840",
                      headerToolbar: {
                          left: 'prev,next today',
                          center: 'title',
                          right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                      },
                      locale: initialLocaleCode,
                      buttonIcons: false, // show the prev/next text
                      weekNumbers: true,
                      navLinks: true, // can click day/week names to navigate views
                      editable: true,
                      dayMaxEvents: true, // allow "more" link when too many events
                      initialView:'timeGridWeek',
                      selectable:true,
                      eventContent:function(arg){
                          return {
                              html:arg.event.title+'<br/>'+arg.event.extendedProps.prof+'<br/>'+arg.event.extendedProps.Salle+'<br/>'
                                  +arg.event.extendedProps.typeCours+'<br/>'+arg.event.extendedProps.idGroupe
                          }
                      },

                      //Ajout
                      select:function(event)
                      {
                          var idG = $("#idGroupeFilter").val();
                          var idGText = $("#idGroupeFilter option:selected").text();
                          var idGroupe=$('#idGroupe').val(idG);
                          var groupe=$('#groupe').val(idGText);
                          var startDate = moment(event.start).format("Y-MM-DD HH:mm:ss");
                          var endDate = moment(event.end).format("Y-MM-DD HH:mm:ss");
                          //Mettre des valeurs par defauts pour les inputs
                          $('#startTime').val(startDate);
                          $('#endTime').val(endDate);
                          $('#fajout').modal('toggle');


                          //Envoi des données
                          $('#btnaddc').click(function(){
                              $.ajax({
                                  type:"POST",
                                  url:"/ajoutEvent",
                                  data:$('#form1').serialize(),
                                  success:function(data)
                                  {
                                      if(data.success){
                                          refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                          alert("Ajout avec succès");
                                          $('#fajout').modal('hide');
                                          $('#form1').trigger('reset');

                                      }
                                      $('#error').text(data.message);

                                  }
                              });
                          });

                      },
                      eventResize:function(info)
                      {

                          var startDate = moment(info.event.start).format("Y-MM-DD HH:mm:ss");
                          var endDate = moment(info.event.end).format("Y-MM-DD HH:mm:ss");
                          var idMat = info.event.extendedProps.idMat;
                          console.log(idMat);
                          var typeCours=info.event.extendedProps.typeCours;
                          var idSalle=info.event.extendedProps.idSalle;
                          var idProf=info.event.extendedProps.idProf;
                          var idGroupe=info.event.extendedProps.idGroupe;
                          var idDuplicate=info.event.extendedProps.idDuplicate;
                          var id = info.event.id;

                          $.ajax({
                              url:"/Event/action",
                              type:"POST",
                              data:{
                                  "_token":"{{csrf_token()}}",
                                  idGroupe:idGroupe,
                                  idProf:idProf,
                                  idSalle:idSalle,
                                  idMat:idMat,
                                  typeCours:typeCours,
                                  start:startDate,
                                  end:endDate,
                                  idDuplicate:idDuplicate,
                                  id:id,
                                  type:"update"
                              },
                              success:function(response){
                                  // fullCalendar.refetchEvents();
                                  alert('Modification avec succès');
                                  calendar.refetchEvents();

                              }
                          })


                      },
                      eventDrop: function(info ){

                          var start = moment(info.event.start).format("Y-MM-DD HH:mm:ss");
                          var end = moment(info.event.end).format("Y-MM-DD HH:mm:ss");
                          var idMat = info.event.extendedProps.idMat;

                          var typeCours=info.event.extendedProps.typeCours;
                          var idSalle=info.event.extendedProps.idSalle;
                          var idProf=info.event.extendedProps.idProf;
                          var idGroupe=info.event.extendedProps.idGroupe;
                          var idDuplicate=info.event.extendedProps.idDuplicate;
                          var id = info.event.id;
                          //ajax
                          $.ajax({
                              url:"/Event/action",
                              type:"POST",
                              data:{
                                  "_token":"{{csrf_token()}}",
                                  idGroupe:idGroupe,
                                  idProf:idProf,
                                  idMat:idMat,
                                  idSalle:idSalle,
                                  typeCours:typeCours,
                                  start:start,
                                  end:end,
                                  idDuplicate:idDuplicate,
                                  id:id,

                                  type:"update"
                              },
                              success:function(data){
                                  calendar.refetchEvents();
                                  //console.log(data);
                                  alert('Modification avec succès');
                              }
                          })

                      },
                      eventClick : function(info){
                          var idG = $("#idGroupeFilter").val();
                          var idGText = $("#idGroupeFilter option:selected").text();
                          var idGroupe=$('#idGroupe').val(idG);
                          var groupe=$('#groupe').val(idGText);

                          var startDate = moment(info.event.start).format("Y-MM-DD HH:mm:ss");
                          var endDate = moment(info.event.end).format("Y-MM-DD HH:mm:ss");
                          var matiere=info.event.title;
                          var idMat = info.event.extendedProps.idMat;
                          var typeCours=info.event.extendedProps.typeCours;
                          var idSalle=info.event.extendedProps.idSalle;

                          var Salle= info.event.extendedProps.Salle;
                          var idProf=info.event.extendedProps.idProf;
                          console.log(idProf);
                          var Prof=info.event.extendedProps.prof;
                          var idGroupe=info.event.extendedProps.idGroupe;
                          var idDuplicate=info.event.extendedProps.idDuplicate;
                          var id = info.event.id;
                          var idE= $('#idEvent').val(id);

                          //Affichage message
                          var cours=$('#cours').text(typeCours+': '+matiere+' à la '+Salle);
                          //Affichage modal
                          $('#fupd').modal('show');

                          $('#delete').click(function() {
                              $('#suppCas').show();

                              //1er cas de suppression
                              $('#pcas').click(function(){

                                  $("#pcas").prop("checked", true);
                                  setTimeout(function(){
                                      if (confirm("Vous voulez vraiment supprimer ce cours?"))
                                      {

                                          $.ajax({
                                              url:"/Event/action",
                                              type:"POST",
                                              data:{
                                                  "_token":"{{csrf_token()}}",
                                                  id:id,
                                                  type:"delete1"
                                              },
                                              success:function(response)
                                              {

                                                  refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                                  $('#fupd').modal('hide');
                                                  $('#formSupr').trigger('reset');
                                                  alert("Suppression avec succès");
                                              }
                                          });

                                      }

                                  },300);


                              });

                              //2em cas de suppression
                              $('#dcas').click(function(){
                                  //setTimeout pour retarder la confirmation
                                  setTimeout(function(){
                                      if (confirm("Vous voulez vraiment supprimer ce cours?"))
                                      {

                                          $.ajax({
                                              url:"/Event/action",
                                              type:"POST",
                                              data:{
                                                  "_token":"{{csrf_token()}}",
                                                  id:id,
                                                  end:endDate,
                                                  start:startDate,
                                                  idProf:idProf,
                                                  idGroupe:idGroupe,
                                                  idSalle:idSalle,
                                                  idMat:idMat,
                                                  type:"delete2"
                                              },
                                              success:function(data)
                                              {

                                                  refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                                  $('#fupd').modal('hide');
                                                  $('#formSupr').trigger('reset');
                                                  alert("Suppression avec succès");
                                              }
                                          });

                                      }

                                  },300);

                              });


                              //3em cas de suppression
                              $('#trcas').click(function(){
                                  //setTimeout pour retarder la confirmation
                                  setTimeout(function(){
                                      if (confirm("Vous voulez vraiment supprimer ce cours?"))
                                      {

                                          $.ajax({
                                              url:"/Event/action",
                                              type:"POST",
                                              data:{
                                                  "_token":"{{csrf_token()}}",
                                                  id:id,
                                                  end:endDate,
                                                  start:startDate,
                                                  idProf:idProf,
                                                  idGroupe:idGroupe,
                                                  idSalle:idSalle,
                                                  idMat:idMat,
                                                  type:"delete3"
                                              },
                                              success:function(data)
                                              {

                                                  refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                                  $('#fupd').modal('hide');
                                                  $('#formSupr').trigger('reset');
                                                  alert("Suppression avec succès");
                                              }
                                          });

                                      }

                                  },300);

                              });

                              //4em cas de suppression
                              $('#qcas').click(function(){
                                  //setTimeout pour retarder la confirmation
                                  setTimeout(function(){
                                      if (confirm("Vous voulez vraiment supprimer ce cours?"))
                                      {
                                          $.ajax({
                                              url:"/Event/action",
                                              type:"POST",
                                              data:{
                                                  "_token":"{{csrf_token()}}",
                                                  id:id,
                                                  end:endDate,
                                                  start:startDate,
                                                  idProf:idProf,
                                                  idGroupe:idGroupe,
                                                  idSalle:idSalle,
                                                  idMat:idMat,
                                                  type:"delete4"
                                              },
                                              success:function(data)
                                              {
                                                  console.log(data);
                                                  refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                                  $('#fupd').modal('hide');
                                                  $('#formSupr').trigger('reset');
                                                  alert("Suppression avec succès");
                                              }
                                          });

                                      }

                                  },300);

                              });


                          });
                          //Modification des champs
                          $('#edit').click(function() {

                              var MstartTime=$('#MstartTime').val(startDate);
                              var endTime=$('#MendTime').val(endDate);

                              var idSalles=$('#idSalleModif').val(idSalle);
                              //   var idS=$('#idSalleModif').val();
                              // console.log(idS);
                              var idMats=$('#idMatModif').val(idMat);
                              var typeCoursModif=$('#typeCoursModif').val(typeCours);

                              var idModif=$('#idModif').val(id);
                              var idProfM=$('#idProfModif').val(idProf);
                              var idGroupeM=$('#idGroupeModif').val(idGroupe);

                              var idDupl=$('#idDuplicate').val(idDuplicate);

                              $('#fupd').modal('hide');
                              $('#fupdate').modal('show');
                          });
                          //console.log(idDupl);
                          $('#btnupdate').click(function(){
                              var idGroupeModif=$('#idGroupeModif').val();
                              var idProfModif=$('#idProfModif').val();
                              var idMatiere=$('#idMatModif').val();
                              var type=$('#typeCoursModif').val();
                              var salles=$('#idSalleModif').val();
                              var stDate=$('#MstartTime').val();
                              var edDate=$('#MendTime').val();
                              var idDuplicate=$('#idDuplicate').val();
                              console.log(idGroupeModif);
                              console.log(idMatiere);
                              //ajax
                              $.ajax({
                                  url:"/Event/action",
                                  type:"POST",
                                  dataType:'json',
                                  data:{
                                      idProfModif:idProfModif,
                                      idGroupeModif:idGroupeModif,
                                      idMat:idMatiere,
                                      typeCours:type,
                                      idSalle:salles,
                                      start:stDate,
                                      end:edDate,
                                      idDuplicateM:idDuplicate,
                                      type:"update1"
                                  },
                                  success:function(response){
                                      refreshCalendar(`/filterGrp/${$('#annee').val()}/${$('#semestre').val()}/${$('#idFil').val()}/${$('#idGroupeFilter').val()}`);
                                      $('#fupdate').modal('hide');
                                      $('#form2').trigger('reset');
                                      alert('Modification avec succès');
                                  }
                              })
                          });







                      }



                  });

                  calendar.render();

                  // build the locale selector's options
                  calendar.getAvailableLocaleCodes().forEach(function(localeCode) {
                      var optionEl = document.createElement('option');
                      optionEl.value = localeCode;
                      optionEl.selected = localeCode == initialLocaleCode;
                      optionEl.innerText = localeCode;
                      localeSelectorEl.appendChild(optionEl);
                  });

                  // when the selected option changes, dynamically change the calendar option
                  localeSelectorEl.addEventListener('change', function() {

                      if (this.value) {
                          calendar.setOption('locale', this.value);
                      }
                  });




                  //Filter annee , semestre et prof
                  $("#idProfFilter").on("change",function (){
                      var idProf = $(this).val(),
                          anneeCourante=$('#annee').val(),
                          semestreCourant=$('#semestre').val();
                      //var url=`/filterProf/${idProf}/${anneeCourante}/${semestreCourant}`;
                      //
                      $.ajax({
                          type:'GET',
                          url:`/filterProf/${idProf}/${anneeCourante}`,
                          success:function (data){
                              // refreshCalendar(data);
                              calendar.removeAllEvents();
                              data.forEach(event=>calendar.addEvent(event));


                              /*$.each(data.mats, function(key, element) {

                                 $matieres.append($("<option></option>")
                                  .attr("value", element.nummat).text(element.mat));
                              });
                              */
                          }
                      });
                  });


                  const refreshCalendar = (url)=>{
                      $.ajax({
                          url,
                          success:function (data){
                              calendar.removeAllEvents();
                              data.forEach(event=>calendar.addEvent(event));
                          }

                      });
                  }


//Filter par annee et groupe
                  $('#idGroupeFilter').on('change',function(){
                      var idGroupe = $(this).val();
                      anneeCourante=$('#annee').val(),
                          semestreCourant=$('#semestre').val(),
                          idFil=$('#idFil').val();

                      refreshCalendar(`/filterGrp/${anneeCourante}/${semestreCourant}/${idFil}/${idGroupe}`);
                      // $.ajax({
                      //     url:`/filterGrp/${anneeCourante}/${semestreCourant}/${idFil}/${idGroupe}`,
                      //     success:function (data){
                      //
                      //     calendar.removeAllEvents();
                      //     data.forEach(event=>calendar.addEvent(event));
                      //     }
                      //
                      // });
                  });


//Update Semestre courant
                  $('#editSemestreCurrent').hide();

                  $('#updateScurrent').on('click', function(){
                      $('#editSemestreCurrent').show();
                  });
                  $('#closeForm').on('click', function(){
                      $('#editSemestreCurrent').hide();
                  });


//Update AnneeCourante
                  $('#btnupSemestre').on('click',function(){
                      $.ajax({
                          url:'upSemestreCourant',
                          type:'POST',
                          data:$('#editSemestreCurrent').serialize(),
                          success:function(response){
                              alert("modification avec succès");
                              $('#editSemestreCurrent').hide();
                              location.reload();
                          }

                      });


                  });

                  chargementSelect('<?=$weekOfSemestre[$numWeekNow][0]?>');
                  function chargementSelect(val){

                      var days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

//recup de la bd les noms des img pour l'afficher a noter qu'il ya un bug l'ajax retourn les donnee avant l'insertion
                      $.ajax({
                          url: "days1/"+val,
                          type: 'get',
                          contentType: false,
                          processData: false,
                          success: function(response){
                              var json=JSON.parse(response);
                              // alert('gg');
                              // console.log(response);
                              // console.log(json);
                              var code='';
                              //on vide la liste
                              $('#ListDays').html('');
                              $.each(json, function(i,value){
                                  //   console.log(i,value);
                                  // on ajout la valeur a la liste
                                  $("#ListDays").append(new Option(days[i]+' '+value, value));
                              });

                          }


                      });
                  }


                  $(document).ready(function(){

                      $('#week').on('change',function(){
                          let val=$(this).val();
                          // table contient la liste de jours en fr
                          chargementSelect(val);
                      });

                  });

//form Prof hide
                  $('#faddProf').modal('hide');
                  //Ajout Prof_Cours_Matieres
                  $('#addProf').on('click',function(){

                      $('#faddProf').modal('show');

                  });
                  $('#fermAdd').on('click',function(){
                      $('#faddProf').modal('hide');
                  });

                  $('#btnaddProf').on('click',function(){
                      $.ajax({
                          url:'/ajoutPCG',
                          type:'POST',
                          dataType:"json",
                          data:$('#formProf').serialize(),
                          success:function(response){
                              alert('ajout avec succès');
                              $('formProf')[0].reset();
                              $('#faddProf').hide();
                          },
                          error:function(error){
                              alert('Echec d\'ajout');
                          }
                      });

                  });


//refresh after filter
                  $("#idProfFilter").on("click",function (){
                      var idGroupe = $('#idGroupeFilter').val('');
                      semestreCourant=$('#semestre').val(''),
                          idFil=$('#idFil').val('');
                  });

                  $("#idGroupeFilter").on("click",function (){
                      var idProf = $('#idProfFilter').val('');

                  });


                  //selectpicker
                //  $.fn.selectpicker.Constructor.BootstrapVersion = '4';


              });
          </script>
    </body>
</html>
