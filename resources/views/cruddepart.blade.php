<!DOCTYPE html>
<html>
    <head>
        <title>Departement</title>
        
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
    <center><h3>Gestion des Départements</h3></center>
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
         
             <input type=text name="NODEP" placeholder="code département">

               <input type=text name="LDEPL" placeholder="nom">
               <br>

               <input type=text name="LDEPL" placeholder="Nom du département">
               <select name="respoDepart">
                @foreach($profs as $prof)
                   <option value="{{$prof->Matricule}}">{{$prof->Nom}}</option>
                   @endForeach
               </select>

               <input type=text name="LDEPA" placeholder="LDEPA">
               <input type=text name="CDEPA" placeholder="CDEPA">
               <br>
               <input type=number name="CDEPL" placeholder="CDEPL">
               <input type=number name="TDEP" placeholder="TDEP">
     </form>
<button  id=btnadds  class='btn btn-success'>ajouter</button>
</div>
<!--Modifier -->
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="NODEP">
               <input type=text name="LDEPL">
               <br>
                <select name="respoDepart">
                @foreach($profs as $prof)
                   <option value="{{$prof->Matricule}}">{{$prof->Nom}}</option>
                  @endForeach
               </select>
               <input type=text name="LDEPA">
               <br>
               <input type=text name="CDEPA">
               <input type=number name="CDEPL">
               <br>
               <input type=number name="TDEP">
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="departTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Id Département</td>
               <td>Nom</td>
               <td>Responsable</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
       var table= $('#departTable').DataTable({
        
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

            ajax:"{{route('departs.getdeparts')}}",
            columns: [
            {"data": 'NODEP'},
            {"data": 'LDEPL'},
            {"data": 'respoDepart'},
           {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.NODEP}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>  
                     <button data-id="${row.NODEP}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]
        });
        $('#formmodif').hide(); 

        $(document).on('click', '#delete',function(){
            if(confirm('vous etes sûr?')){
                $.ajax({
                    url:"{{url('Dsup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "NODEP":$(this).data('id')

                    },
                    success:function(response){
                        alert('suppression avec succès!');
                      table.ajax.reload();
                    
                    
                    }
                })
            }
        });
   $(document).on('click', '#edit',function(){
             $('#formmodif').show();
                $.ajax({
                    url:"{{url('Dedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "NODEP":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="NODEP"]').val(response.data.NODEP);
                        $('input[name="LDEPL"]').val(response.data.LDEPL);
                        $('input[name="respoDepart"]').val(response.data.respoDepart);
                        $('input[name="LDEPA"]').val(response.data.LDEPA);
                        $('input[name="CDEPA"]').val(response.data.CDEPA);
                        $('input[name="CDEPL"]').val(response.data.CDEPL);
                        $('input[name="TDEP"]').val(response.data.TDEP);
                    
                    }
                })
            
        });
$('#btnannul').click(function(){

    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upDepart')}}",
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
        url : "{{route('Dajout')}}",
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