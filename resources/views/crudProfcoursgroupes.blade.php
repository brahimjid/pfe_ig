<!DOCTYPE html>
<html>
    <head>
        <title>Profsseur_cours_groupe</title>
       
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


</head>
<body>
    <center><h3>Gestion des cours</h3></center>

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
             <select name="idProf">
                   @foreach($prof as $p)
                   <option value="{{$p->Matricule}}">{{$p->Nom}}</option>
                   @endForeach
               </select>
               <br>
              <select name="idMat">
                   @foreach($mat as $m)
                   <option value="{{$m->nummat}}">{{$m->mat}}</option>
                   @endForeach
               </select>
              <select name="idGroupe">
                   @foreach($groupes as $g)
                   <option value="{{$g->idGroupe}}">{{$g->titreCourt}}-G{{$g->ordre}}</option>
                   @endForeach
               </select>
     </form>
<button  id=btnadds  class='btn btn-success' > ajouter</button>
</div>

<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
               <select name="idProfM">
                   @foreach($prof as $p)
                   <option value="{{$p->Matricule}}">{{$p->nom}}</option>
                   @endForeach
               </select>
               <br>
              <select name="idMatM">
                   @foreach($mat as $m)
                   <option value="{{$m->nummat}}">{{$m->mat}}</option>
                   @endForeach
               </select>
              <select name="idGroupeM">
                   @foreach($groupes as $g)
                   <option value="{{$g->idGroupe}}">{{$g->titreCourt}}-G{{$g->ordre}}</option>
                   @endForeach
               </select>
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br> <br>
</div>
<!--Table--> 
      <table id="mTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
                <td>#</td>
               <td>Professeur</td>
               <td>Matiere</td>
               <td>Groupe</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
        
      var table= $('#mTable').DataTable({
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

           ajax: "/dataProCouG",
            columns: [
            {"data": 'idProf'},
            {"data": 'Nom'},
            {"data": 'mat'},
            {"data": 'idGroupe',
             render:function(data, type, row){
                    return row['titreCourt']+'-G'+row['ordre'];
            }
        },
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
            if(confirm('vous etes sur?')){
                $.ajax({
                    url:"{{url('sup')}}",
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
                    url:"{{url('edit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "idProf":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="idProf"]').val(response.data.idProf);
                        $('input[name="mat"]').val(response.data.mat);
                        $('input[name="idGroupe"]').val(response.data.idGroupe);
                    
                    }
                });
            
        });
        
$('#btnannul').click(function(){

    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upSalle')}}",
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
        url : "/ajoutPCG",
         type : "post",
       dataType:"json",
       data: $("#form1").serialize(),
       success : function(response){ 
         alert('ajout avec succès');
         table.ajax.reload();
         $('#formajout').hide();
       },
       error:function(error){
         alert('Echec d\'ajout');
       }

    });
    
            });
            
      


    });
    
</script>
</body>
</html>
