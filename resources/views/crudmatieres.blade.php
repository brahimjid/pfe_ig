<!DOCTYPE html>
<html>
    <head>
        <title>Matieres</title>
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
<body>
    <center><h3>Gestion des Matieres</h3></center>
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
           
               <select name="sem">
                   <option value="S1">S1</option>
                   <option value="S2">S2</option>
                   <option value="S3">S3</option>
                   <option value="S4">S4</option>
                   <option value="S5">S5</option>
                   <option value="S6">S6</option>
               </select>
               
                <input type=text name="nummat" placeholder="Numero matière">
                <br>
             <input type=text name="mat" placeholder="Matière">
               <input type=text name="NOPRFL" placeholder="NOPRFL">
               
              
     </form>
<button  id=btnadds  class='btn btn-success' > ajouter</button>
</div>

<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="nummat" placeholder="Numero matière">
             <input type=text name="mat" placeholder="Matière">
             <br>
               <input type=text name="NOPRFL" placeholder="NOPRFL">
                <select name="sem">
                   <option value="S1">S1</option>
                   <option value="S2">S2</option>
                   <option value="S3">S3</option>
                   <option value="S4">S4</option>
                   <option value="S5">S5</option>
                   <option value="S6">S6</option>
               </select>
               
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="matTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Numero </td>
               <td>Nom</td>
               <td>NOPRFL</td>
               <td>Semestre</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
       var table= $('#matTable').DataTable({
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
        
            ajax: "{{route('matieres.getmatieres')}}",
            columns: [
             {"data": "nummat"},
            {"data": "mat"},
            {"data": "NOPRFL"},
            {"data": "sem"},
           
          
            {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.nummat}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button data-id="${row.nummat}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]
        }); 

 $('#formmodif').hide();
   $(document).on('click', '#delete',function(){
            if(confirm('vous etes sur?')){
                $.ajax({
                    url:"{{url('Msup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "nummat":$(this).data('id')

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
                    url:"{{url('Medit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "nummat":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="nummat"]').val(response.data.nummat);
                        $('input[name="mat"]').val(response.data.mat);
                        $('input[name="NOPRFL"]').val(response.data.NOPRFL);
                        $('input[name="sem"]').val(response.data.sem);
                        
                       
                    
                    }
                })
            
        });
$('#btnannul').click(function(){

    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upMat')}}",
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
        url : "{{route('Majout')}}",
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