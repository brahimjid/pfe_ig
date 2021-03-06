<!DOCTYPE html>
<html>
    <head>
        <title>Jour</title>
        
       <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
        <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="css/data.css">
        <link href="css/all.min.css" rel="stylesheet">
        <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

</head>
<body>
    <center><h3>Gestion des Jours</h3></center>
     <nav>
      <ul>
<li class="b1"><a href="parametrage"i  class="fas fa-home"></i>Parametre</a></li>
</ul>
 </nav>

<br><br>
 <a href="Aliste" id='b'  type="button"><button class="button-3d">crenjour</button></a>
    
    <!--Boutons-->
<button id="btnajout" class ="btn btn-info">+</button>
<div id="formajout">
    <form action='' method=post id=form1>
    @csrf 
             <input type=text name="jour" placeholder="nom de la Jour">
     </form>  
<button  id=btnadds  class='btn btn-success' > ajouter</button>

</div>
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="id" placeholder="id">
                <input type=text name="jour" placeholder="nomjour">

     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
</div>
</div>
</div>
</div>
</div>
<!--Table-->
      <table id="jrlTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>id</td>
               <td>jour</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
      var table= $('#jrlTable').DataTable({
processing: false,
        serverSide: true,
        "lengthMenu":[[3,5,10,25,50,100,-1],[3,5,10,25,50,100,"All"]],
        "responsive":true,
        "lengthChange":true,
        "ServerSide":true,
        "bProcessing": true,
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
    },
            ajax: "{{route('jour.getJour')}}",
            columns: [
            {"data": 'id'},
            {"data": 'jour'},
            {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.id}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button  data-id="${row.id}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></i></button>`;
                    
                }
            }
            ]
        }); 
      
       $('#formmodif').hide();
        $(document).on('click', '#delete',function(){
            if(confirm('vous etes sur?')){
                $.ajax({
                    url:"{{url('Jsup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "id":$(this).data('id')

                    },
                    success:function(response){

                    table.ajax.reload();
                    alert('suppression avec succ??s!');
                    
                    }
                })
            }
        });

   $(document).on('click', '#edit',function(){
             $('#formmodif').show();
                $.ajax({
                    url:"{{url('Jedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "id":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="id"]').val(response.data.id);
                        $('input[name="jour"]').val(response.data.jour);
                   
                    
                    }
                })
            
        });
$('#btnannul').click(function(){

    $('#formmodif').hide();
});
    $(document).on('click', '#btnmodif',function(){
            
            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upJour')}}",
                    type:"post",
                    dataType:'json',
                    data:$('#form2').serialize(),
                    success:function(response){
                       
                        alert("modification avec succ??s!");
                         $('#form1')[0].reset(); // pour actualiser la formuleur d'jout
                        table.ajax.reload();     // actualise la daratable 
                        $('#formmodif').hide(); // .hide tekhfi le formul ileyn newvw meno
                    }
                })
            }
            
        });


/*
 $(document).on('click', '#view',function(){
                $.ajax({
                    url:"{{url('Aliste')}}",
                    type:"get",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "id":$(this).data('id')

                    },
                    success:function(response){

                    alert('suppression avec succ??s!');
                    
                    }
                });
            
        });
        <button  data-id="${row.id}" id="view"><i id="mod" class="fas fa-eye" title="voir"></button>

*/

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
        url : "{{route('JRJout')}}",
         type : "post",
       dataType:"json",
       data: $("#form1").serialize(),
       success : function(response){ 
         alert('ajout avec succ??s');
         table.ajax.reload();
         $('#formajout').hide();
       }

    });
    
            });
/*
          $('#b').click(function () {  

           $('#formcli').modal('toggle');

              });
*/

    });
    
</script>
</body>
</html>