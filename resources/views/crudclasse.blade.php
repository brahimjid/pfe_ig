<!DOCTYPE html>
<html>
    <head>
        <title>Classe</title>
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
     <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="css/data.css">
       <link href="css/all.min.css" rel="stylesheet">
                          <!--DataTables JS-->
     <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

<script type="text/javascript" src="{{asset('DataTables/dataTables.buttons.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.colVis.min.js')}}"></script>




</head>
<body>
    <center><h3>Gestion des classe</h3></center>
     <nav>
      <ul>

<li class="b1"><a href="./"i  class="fas fa-home"></i> Accueil</a></li>

</ul>
 </nav>

<br><br>
<button id="btnajout" class ="btn btn-info">+</button>
<div id="formajout">
    <form action='' method=post id=form1>
    @csrf 
              <select name="idFil">
                   @foreach($filieres as $filiere)
                   <option value="{{$filiere->idFil}}">{{$filiere->idFil}}</option>
                   @endForeach
               </select>
               <select name="niv">
                   @foreach($nivx as $niv)
                   <option value="{{$niv->id}}">{{$niv->nom}}</option>
                   @endForeach
               </select>
               <br>
               <input type=text name="titreCourt" placeholder="titre court">
               <input type=text name="titre" placeholder="titre ">
               <br>
                <input type=text name="anneeUniversitaire" placeholder="année universitaire">

                 <input type=number name="nbrEtudiant" placeholder="nombre d'étudiant ">

     </form>
<button  id=btnadds class='btn btn-success' > ajouter</button>
</div>
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="id">
                 <select name="idFil">
                   @foreach($filieres as $filiere)
                   <option value="{{$filiere->idFil}}">{{$filiere->idFil}}</option>
                   @endForeach
               </select>
               <select name="niv">
                   @foreach($nivx as $niv)
                   <option value="{{$niv->id}}">{{$niv->nom}}</option>
                   @endForeach
               </select>
               <input type=text name="titreCourt" placeholder="titre court">
               <input type=text name="titre" placeholder="titre ">
                <input type=text name="anneeUniversitaire" placeholder="année universitaire">
                 <input type=number name="nbrEtudiant" placeholder="nombre d'étudiant ">
               
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="classeTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Id</td>
               <td>Code filière</td>
               <td>Niveau</td>
               <td>TitreCourt</td>
               <td>Titre</td>
               <td>Année universitaire</td>
               <td>Nombre d'étudiant</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
        //Affichage datatables
      var table= $('#classeTable').DataTable({

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
            ajax: "{{route('classe.getClasse')}}",
            columns: [
            {"data": 'id'},
            {"data": 'idFil'},
            {"data": 'niv'},
            {"data": 'titreCourt'},
            {"data": 'titre'},
            {"data": 'anneeUniversitaire'},
            {"data": 'nbrEtudiant'},
            {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.id}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button data-id="${row.id}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]
        }); 
       $('#formmodif').hide();
        $(document).on('click', '#delete',function(){
            if(confirm('vous êtes sûr?')){
                $.ajax({
                    url:"{{url('Csup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "id":$(this).data('id')

                    },
                    success:function(response){

                    table.ajax.reload();
                    alert('suppression avec succès!');
                    
                    }
                })
            }
        });

   $(document).on('click', '#edit',function(){
             $('#formmodif').show();
                $.ajax({
                    url:"{{url('Cedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "id":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="id"]').val(response.data.id);
                        $('input[name="idFil"]').val(response.data.idFil);
                        $('input[name="niv"]').val(response.data.niv);
                        $('input[name="titreCourt"]').val(response.data.titreCourt);
                        $('input[name="titre"]').val(response.data.titre);
                        $('input[name="anneeUniversitaire"]').val(response.data.anneeUniversitaire);
                        $('input[name="nbrEtudiant"]').val(response.data.nbrEtudiant);
                    
                    }
                })
            
        });
$('#btnannul').click(function(){
    $('#form1')[0].reset();
    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upclasse')}}",
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
        url : "{{route('Cajout')}}",
         type : "post",
       dataType:"json",
       data: $("#form1").serialize(),
       success : function(response){ 
         alert('ajout avec succès');
         table.ajax.reload();
         $('#formajout').hide();
       }

    });
    
            });
            
      


    });
    
</script>
</body>
</html>