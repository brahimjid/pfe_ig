<!DOCTYPE html>
<html>
    <head>

        <title>Professeurs</title>
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
        <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="css/data.css">
        <link href="css/all.min.css" rel="stylesheet">


<script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/dataTables.buttons.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.colVis.min.js')}}"></script>



<script type="text/javascript" src="{{asset('jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{asset('additional-methods.js')}}"></script>

</head>
<body>
    <center><h3>Gestion des professeurs</h3></center>


     <nav>
      <ul>
<li class="b1"><a href="./"><i class="fas fa-home" title="retourrner vers l'acceuil"></i>Accueil</a></li>
</ul>
 </nav>

<br><br>

<button id="btnajout" class ="btn btn-info">+</button>
<br><br>
<div id="formajout">
    <form action='' method=post id="form1">
     @csrf
             <input type=text name="Matricule" placeholder="votre matricule">
               <input type=text name="Nom" placeholder="nom en français">
               
               <input type=text name="Noma" placeholder="nom en arabe">
               <input type=text name="Adresse" placeholder="adresse">
               <br>
               <input type=date name="daten" placeholder="date de naissance">
               
               <input type=text name="lieun" placeholder="lieu de naissance">
               
               <input type=text name="Nat" placeholder="nationalité">
               
               <input type=text name="telephone" placeholder="telephone">
               <br>
               <input type=text name="email" placeholder="email">
               
               <input type=text name="Diplome" placeholder="diplome">
               
               <input type=text name="TauxHor" placeholder="taux d'horaire">
               
               <input type=text name="NbHrAPayer" placeholder="nombre d'heur à payer">
<br>
  <input type=text name="NumCompte" placeholder="numéro compte">
               <input type=text name="nbcours" placeholder="nombre de cours faits">
                  <input type=text name="Nomf" placeholder="NomF">
                  <br>
                <select name="nodep">
                   @foreach($departs as $depart)
                   <option value="{{$depart->NODEP}}">{{$depart->LDEPL}}</option>
                   @endForeach
               </select>
                <select name="type">
                   <option value="Vacataire">Vacataire</option>
                   <option value="Permanent">Permanent</option>
               </select>
<br>
               <select name="sexe">
                   <option value="M">Masculin</option>
                    <option value="F">Feminin</option>
               </select>
               
               <select name="Banque">
                   @foreach($banques as $banque)
                   <option value="{{$banque->IDBanq}}">{{$banque->IDBanq}}</option>
                   @endForeach
               </select>
               <br>
             
                <select name="grade">
                   @foreach($grades as $grade)
                   <option value="{{$grade->Grade}}">{{$grade->Grade}}</option>
                   @endForeach
               </select>
            
             
     </form>
<button  id=btnadds  class='btn btn-success' > ajouter</button>
</div>


<!--Liste déroulante -->
 <button id="btnajoutP"  class ="btn btn-info">+</button>
 <br>
<button id="btnajoutB"  class ="btn btn-info">Banque</button>
<button id="btnajoutG"  class ="btn btn-info">Grade</button>

 <!--Ajout Banque-->
            
<div id="formajoutB">
    <form action='' method=post id=form3>
     @csrf
       
             <input type=text name="IDBanq" placeholder="abréviation de la banque">
               
          
               <input type=text name="LibBanq" placeholder="nom de la banque">
     </form>
<button  id=btnaddB  class='btn btn-success'>ajouter</button>
<button  id=annulB  class='btn btn-success'>annuler</button>
</div>
<!--Ajout Grade-->
            
<div id="formajoutG">
    <form action='' method=post id=form4>
     @csrf
       
             <input type=text name="Grade" placeholder="grade">
     </form>
<button  id=btnaddG  class='btn btn-success'>ajouter</button>
<button  id=annulG  class='btn btn-success'>annuler</button>
</div>



<div id="formmodif">
    <form action='' method=post id=form2>
     @csrf
             <input type=hidden name="Matricule">
               <input type=text name="Nom" placeholder="nom en français">
               <input type=text name="Noma" placeholder="nom en arabe">
              <select name="nodep">
                   @foreach($departs as $depart)
                   <option value="{{$depart->NODEP}}">{{$depart->LDEPL}}</option>
                   @endForeach
               </select>
             <select name="type">
                   <option value="Vacataire">Vacataire</option>
                   <option value="Permanent">Permanent</option>
               </select>
               <input type=text name="Adresse" placeholder="adresse">
               <input type=date name="daten" placeholder="date de naissance">
               <input type=text name="lieun" placeholder="lieu de naissance">
               <input type=text name="Nat" placeholder="nationalité">
               <input type=text name="telephone" placeholder="telephone">
               <input type=text name="email" placeholder="email">
               <input type=text name="Diplome" placeholder="diplome">
               <input type=text name="TauxHor" placeholder="taux d'horaire">
                <input type=text name="NbHrAPayer" placeholder="nombre d'heur à payer">
                <select name="sexe">
                   <option value="M">Masculin</option>
                    <option value="F">Feminin</option>
               </select>
               <select name="Banque">
                   @foreach($banques as $banque)
                   <option value="{{$banque->IDBanq}}">{{$banque->IDBanq}}</option>
                   @endForeach
               </select>
               <input type=text name="NumCompte" placeholder="numéro compte">
               <input type=text name="nbcours" placeholder="nombre de cours faits">
               <select name="grade">
                   @foreach($grades as $grade)
                   <option value="{{$grade->Grade}}">{{$grade->Grade}}</option>
                   @endForeach
               </select>
               <input type=text name="Nomf" placeholder="NomF">
              
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="profTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Matricule</td>
               <td>Nom en Français</td>
               <td>Nom en Arabe</td>
               <td>Département</td>
               <td>Type</td>
               <td>Adresse</td>
               <td>Date de naissance </td>
               <td>Lieu de naissance</td>
               <td>Nationnalité</td>
               <td>Téléphone</td>
               <td>Email</td>
               <td>Diplôme</td>
               <td>TauxHor</td>
                <td>NbHrApayer</td>
               <td>Genre</td>
               <td>Banque</td>
               <td>NumCompte</td>
               <td>Nbcours</td>
               <td>Grade</td>
                <td>NomF</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){

 

       var table= $('#profTable').DataTable({
        processing: false,
        serverSide: true,
        "lengthMenu":[[3,5,10,25,50,100,-1],[3,5,10,25,50,100,"All"]],
        "responsive":true,
        "lengthChange":true,
        "ServerSide":true,
        "bProcessing": true,
        dom:'lBfrtip',
        buttons: [
           
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        
        "language":{
    "sProcessing":     "Traitement en cours...",
    "sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
    "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
    
        "sNext":       "Suivant",
    
        "sLast":       "Dernier"
        },
        buttons:{
            colvis:'Colonne Visible'
        }
   
    },
            ajax: "{{route('prof.getProf')}}",
            columns: [
            {data: 'Matricule'},
            {data: 'Nom'},
            {data: 'Noma'},
            {data: 'nodep'},
            {data: 'type'},
            {data: 'Adresse'},
            {data: 'daten'},
            {data: 'lieun'},
            {data: 'Nat'},
            {data: 'telephone'},
            {data: 'email'},
            {data: 'Diplome'},
            {data: 'TauxHor'},
            {data: 'NbHrAPayer'},
            {data: 'sexe'},
            {data: 'Banque'},
            {data: 'NumCompte'},
            {data: 'nbcours'},
            {data: 'grade'},
            {data: 'Nomf'},
            {
                data:'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.Matricule}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button data-id="${row.Matricule}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]

        }); 

      
         $('#formmodif').hide(); 
        $(document).on('click', '#delete',function(){
            if(confirm('vous etes sur?')){
                $.ajax({
                    url:"{{url('Psup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "Matricule":$(this).data('id')

                    },
                    success:function(response){

                      table.ajax.reload();
                    alert('suppression avec succès!');
                    t
                    }
                })
            }
        });

$(document).on('click', '#edit',function(){
             $('#formmodif').show();
                $.ajax({
                    url:"{{url('Pedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "Matricule":$(this).data('id')
                    },

                    success:function(response){
            $('input[name="Matricule"]').val(response.data.Matricule);
            $('input[name="Nom"]').val(response.data.Nom);
            $('input[name="Noma"]').val(response.data.Noma);
            $('input[name="nodep"]').val(response.data.nodep);
            $('input[name="type"]').val(response.data.type);
            $('input[name="Adresse"]').val(response.data.Adresse);
            $('input[name="daten"]').val(response.data.daten);
            $('input[name="lieun"]').val(response.data.lieun);
            $('input[name="Nat"]').val(response.data.Nat);
            $('input[name="telephone"]').val(response.data.telephone);
            $('input[name="email"]').val(response.data.email);
            $('input[name="Diplome"]').val(response.data.Diplome);
            $('input[name="TauxHor"]').val(response.data.TauxHor);
            $('input[name="NbHrAPayer"]').val(response.data.NbHrAPayer);
            $('input[name="sexe"]').val(response.data.sexe);
            $('input[name="Banque"]').val(response.data.Banque);
            $('input[name="NumCompte"]').val(response.data.NumCompte);
            $('input[name="nbcours"]').val(response.data.nbcours);
            $('input[name="grade"]').val(response.data.grade);
            $('input[name="Nomf"]').val(response.data.Nomf);
                    }
                })
            
        });


//bouton Banque
 $('#btnajoutB').hide();
 //bouton Grade
 $('#btnajoutG').hide();


//formulaire Banque
 $('#formajoutB').hide();
 //formulaire Grade
 $('#formajoutG').hide();


        $('#btnajoutP').on('click', function(){
            var x=$(this).text();
          if(x=="+")
          {
            $(this).text("-");
             $('#btnajoutB').show();
              $('#btnajoutG').show();
          }
          if(x=="-")
          {
            $(this).text("+");
            $('#btnajoutB').hide();
            $('#btnajoutG').hide();
            }
            
        });

 $('#btnajoutB').click(function () {
        $('#formajoutB').show();
      
});

$('#btnajoutG').click(function () {
        $('#formajoutG').show();
      
});


 $('#btnaddB').click(function () {
        
 $.ajax({
         type : 'POST',
       url : "{{route('Bajout')}}",
       data: $("#form3").serialize(),
       success : function(response){ 
         alert('ajout avec succès');
         //formajout
          $('#formajout').reload();
       },

       error : function(error){                                     
 alert('Echec');
       }

    });
 });
$('#btnaddG').click(function () {
        
       $.ajax({
         type : 'POST',
       url : "{{route('Gradeajout')}}",
       data: $("#form4").serialize(),
       success : function(response){ 
         alert('ajout avec succès');
         
       },

       error : function(error){                                     
 alert('Echec');
       }

    });
});


$('#annulB').click(function(){
  $('#form3')[0].reset();
    $('#formajoutB').hide();
});

$('#annulG').click(function(){
  $('#form4')[0].reset();
    $('#formajoutG').hide();
});



//-------------------------
$('#btnannul').click(function(){
  $('#form1')[0].reset();
    $('#formmodif').hide();
});

    $(document).on('click', '#btnmodif', function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upProf')}}",
                    type:"post",
                    dataType:'json',
                    data:$('#form2').serialize(),
                    success:function(response){
                       
                        alert("modification avec succès!");
                         $('#form1')[0].reset();
                       table.ajax.reload();
                        $('#formmodif').hide();
                    }
                })
            }
            
        });


        $('#formajout').hide();

        $('#btnajout').on('click', function(){
            var x=$(this).text();
          if(x=="+")
          {
            $(this).text("-");
             $('#formajout').show();

          }
          if(x=="-")
          {
            $(this).text("+");
        $('#formajout').hide();
            }
            
        });

        $('#btnadds').click(function () {
        
  
       $.ajax({
         type : 'POST',
       url : "{{route('Pajout')}}",
       data: $("#form1").serialize(),
       success : function(response){ 
                 alert('ajout avec succès');
          table.ajax.reload();
       },

       error : function(error){                                     
 alert('Echec');
       }

    });
      

});




    });
       
</script>
</body>
</html>