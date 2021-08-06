<!DOCTYPE html>
<html>
    <head>
        <title>Cycle</title>
         <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
     <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="css/data.css">
       <link href="css/all.min.css" rel="stylesheet">
                          <!--DataTables JS-->
     <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

     <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script type="text/javascript" src="{{asset('DataTables/dataTables.buttons.min.js')}}"></script> 
<script type="text/javascript" src="{{asset('jszip.min.js')}}"></script>
<script type="text/javascript" src="{{asset('pdfmake.min.js')}}"></script>
<script type="text/javascript" src="{{asset('vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.html5.min.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/buttons.colVis.min.js')}}"></script>

</head>
<body>
    <center><h3>Gestion des cycles</h3></center>
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
             <input type=text name="id" placeholder="id">
            <select name="nom">
                   <option value="Licence">Licence</option>
                  <option value="Master">Master</option>
               </select>
        
     </form>
<button  id=btnadds  class='btn btn-success' > ajouter</button>
</div>
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="id">
                 <select name="nom">
                   <option value="Licence">Licence</option>
                  <option value="Master">Master</option>
               </select>
         
               
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>

</div>


<!--cycle niveau-->

<div id="formcycleniv">
    <form action='' method=post id=form3>
    @csrf 
            <select name="idCycle">
                @foreach($cycles as $cycle)
                   <option value="{{$cycle->id}}">{{$cycle->nom}}</option>
                   @endForeach
               </select>
               
               <select name="idNiv">
                @foreach($nivx as $niv)
                   <option value="{{$niv->id}}">{{$niv->nom}}</option>
                 @endForeach
               </select>
               <input type=text name="nom" placeholder="nom">
        
     </form>
<button  id=btnaddcycleniv  class='btn btn-success' > ajouter</button>
<button  id=btnannuler  class='btn btn-success' > annuler</button>
<br><br>
</div>


<!--Table-->
      <table id="cycleTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>id</td>
               <td>nom</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){

        //Affichage datatables
      var table= $('#cycleTable').DataTable({
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
        
            ajax: "{{route('cycle.getcycle')}}",
            columns: [
            {"data": 'id'},
            {"data": 'nom'},
            {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.id}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button  data-id="${row.id}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></i></button><button id="btncycleniv"><i  class="fas fa-plus" title="nouveau"></i></button>`;
                    
                }
            }
            ]
        }); 
      
        $(document).on('click', '#delete',function(){
            if(confirm('vous etes sur?')){
                $.ajax({
                    url:"{{url('Cysup')}}",
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
        
 $('#formmodif').hide();
   $(document).on('click', '#edit',function(){
             $('#formmodif').show();
                $.ajax({
                    url:"{{url('Cyedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "id":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="id"]').val(response.data.id);
                        $('input[name="nom"]').val(response.data.nom);
                   
                    
                    }
                })
            
        });

$('#btnannul').click(function(){

    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upcycle')}}",
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
        url : "{{route('Cyajout')}}",
         type : "post",
       dataType:"json",
       data: $("#form1").serialize(),
       success : function(response){ 
         alert('ajout avec succès!');
         table.ajax.reload();
         $('#formajout').hide();
       }

    });
    
            });
            
     


$('#btnannuler').click(function(){
     $('#form3')[0].reset();
    $('#formcycleniv').hide();
});


$('#formcycleniv').hide();


   $(document).on('click','#btncycleniv',function () {
         $('#formcycleniv').show();

            });

$('#btnaddcycleniv').on('click', function(){
 $.ajax({
        url : "{{route('CyNivajout')}}",
         type : "post",
       dataType:"json",
       data: $("#form3").serialize(),
       success : function(response){ 
         alert('ajout avec succès!');
         table.ajax.reload();
         $('#formcycleniv').hide();
       }

    });
    


    });
 });
    
</script>
</body>
</html>