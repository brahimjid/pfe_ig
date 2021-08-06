<!DOCTYPE html>
<html>
    <head>
        <title>Cycle Niveau</title>
        <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
     <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="css/data.css">
       <link href="css/all.min.css" rel="stylesheet">
                          <!--DataTables JS-->
     <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>

</head>
<body>
    <center><h3>Gestion des cycle</h3></center>
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
<button  id=btnadds  class='btn btn-success' > ajouter</button>
</div>
<div id="formmodif">
    <form action='' method=post id=form2>
    @csrf
                <input type=hidden name="idCycle">
                <input type=hidden name="idNiv">
               <input type=text name="nom" placeholder="nom">
         
               
     </form>
<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>
<br><br>
</div>
<!--Table-->
      <table id="cycleNivTable" class="styled-table" border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr class="active-row">
               <td>Cycle</td>
               <td>Niveau</td>
               <td>Nom</td>
               <td>Action</td>
             </tr>
        </thead> 
        <tbody>
            
        </tbody>
           
        
      </table>
     
<script type="text/javascript">
    $(document).ready(function(){
        //Affichage datatables
      var table= $('#cycleNivTable').DataTable({

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
        
            ajax: "{{route('cycleNiv.getcyclesNiv')}}",
            columns: [
            {"data": 'idCycle'},
             {"data": 'idNiv'},
            {"data": 'nom'},
            {
                "data":'Action',orderable:false,searchable:false,
                render:function(data, type, row){
                    return `<button data-id="${row.idCycle}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>
                    <button  data-id="${row.idCycle}" id="delete"><i id="sup" class="fas fa-trash" title="supprimer"></button>`;
                    
                }
            }
            ]
        }); 
      
        $(document).on('click', '#delete',function(){
            if(confirm('vous êtes sûr?')){
                $.ajax({
                    url:"{{url('CyNivsup')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{csrf_token()}}",
                        "idCycle":$(this).data('id')

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
                    url:"{{url('CyNivedit')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "idCycle":$(this).data('id')
                    },
                    success:function(response){
                        console.log(response);
                        $('input[name="idCycle"]').val(response.data.idCycle);
                        $('input[name="idNiv"]').val(response.data.idNiv);
                        $('input[name="nom"]').val(response.data.nom);
                   
                    
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
                    url:"{{url('upcycleNiv')}}",
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
        url : "{{route('CyNivajout')}}",
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
            
      


    });
    
</script>
</body>
</html>