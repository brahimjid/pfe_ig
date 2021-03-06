<!DOCTYPE html>
<html>
    <head>
        <title>Banque</title>
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="css/data.css">
       <link href="css/all.min.css" rel="stylesheet">
    <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
    
                          <!--DataTables JS-->
     <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

</head>
<body>
    <center><h3>Gestion des Banques</h3></center>
     <nav>
      <ul>
<li class="b1"><a href="./"i  class="fas fa-home" title="retourner vers l'acceuil"></i> Accueil</a></li>
<li class="b1"><a href="Pliste"><i class="fas fa-users" title="retourrner vers la gestion des professeurs"></i> Gestion des  professeurs</a></li>
</ul>
 </nav>

<br><br>
<button id="btnajout" class ="btn btn-info">+</button>
<div id="formajout">
    <form action='' method=post id=form1>
     @csrf
       
             <input type=text name="IDBanq" placeholder="abréviation de la banque">
               
          
               <input type=text name="LibBanq" placeholder="nom de la banque">
     </form>
<button  id=btnadds  class='btn btn-success'>ajouter</button>
</div>
<!--Modifier -->
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="IDBanq">
               <input type=text name="LibBanq">
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="banqueTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Id Banque</td>
               <td>Nom</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
       var table= $('#banqueTable').DataTable({
            processing: false,
            serverSide: true,
            "responsive":true,
        "lengthChange":true,
            "lengthMenu":[3,5,10,25,50,100],
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
        }
    },
        
            ajax:"{{route('banque.getBanque')}}",
            columns: [
            {"data": 'IDBanq'},
            {"data": 'LibBanq'},
           {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.IDBanq}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>  
                     <button data-id="${row.IDBanq}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]
        });
        $('#formmodif').hide(); 

        $(document).on('click', '#delete',function(){
            if(confirm('vous êtes sûr?')){
                $.ajax({
                    url:"{{url('Bsup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "IDBanq":$(this).data('id')

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
                    url:"{{url('Bedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "IDBanq":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="IDBanq"]').val(response.data.IDBanq);
                        $('input[name="LibBanq"]').val(response.data.LibBanq);
                    
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
                    url:"{{url('upBanque')}}",
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
            $('#form1')[0].reset();
        	$('#formajout').hide();
            }
            
        });

        $('#btnadds').click(function () {
        
       $.ajax({
        url : "{{route('Bajout')}}",
         type : "post",
       dataType:"json",
       data: $("#form1").serialize(),
       success : function(data){ 
        var html='';
        if(data.errors){
            html='<ul>';
            for(var count =0; count<data.errors.length; count++){
                html+='<li>'+data.errors[count]+'</li>';
            }
            html+='</ul>';
        }
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
