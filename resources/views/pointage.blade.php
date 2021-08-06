<!DOCTYPE html>

 <head>
        <title>Pointage Professeur</title>


<script type="text/javascript" src="{{asset('jquery.min.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">

         <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
        <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
        <link rel="stylesheet" type="text/css" href="css/point.css">
        <link href="css/all.min.css" rel="stylesheet">


<script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('DataTables/dataTables.buttons.min.js')}}"></script>


<script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>


<link rel="stylesheet" type="text/js" href="{{asset('DataTables/dataTables.bootstrap.min.js')}}">


   <link rel="stylesheet" type="text/css" href="{{asset('DataTables/DataTables-1.10.24/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/js" href="{{asset('js/bootstrap.min.js')}}">

  <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datepicker.css')}}">

  <link rel="stylesheet" type="text/js" href="{{asset('js/bootstrap-datepicker.js')}}">
    </head>

<body>
<center><h2>Pointage Professeur</h2></center>

  <nav>
      <ul>
<li class="b1"><a href="./"i  class="fas fa-home"></i> Accueil</a></li>
</ul>
 </nav>

<div id="formaffichage" align="center">
<form method='POST' action='/exportPoint'>
    @csrf

          <br>
<select name='week' id='week' class="custom-select">
    <?php for($week=1;$week<$numberWeekOfSemestre;$week++){
    echo "<option value='".$weekOfSemestre[$week][0]."' ";
    if($week==$numWeekNow)
        echo "selected";
    echo ">S-$week</option>";
    }
    ?>
      </select>
      <br>
            <select name='ListDays' id='ListDays' class="custom-select">
                    </select>
                    <br>
                           <select name='periode' id='periode' class="custom-select">
                              <option>Choisir Période...</option>
                                 <option value="14">Matin</option>
                                   <option value="19">Soire</option>
                                                </select>
<br>
                               <input type="hidden" id="weekText" name="weekText">
                          <button class="imp" type="submit">Imprimer</button>

    </form>

    </div>

<!--<div id="formmodif">
                <form action='' method=post id=form2>
    @csrf

               <input type=hidden name="id">
                  <select name="statusCours" class="form-control w-50">

                   <option value="fait">fait</option>
                    <option value="nonfait" >non fait</option>
                   <option value="férié">férié</option>

               </select>
                </form>
            <button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>


     </div>-->

<!--<button  id="btnmodif"  class='btn btn-success' > enregistrer</button>
<button  id="btnannul"  class='btn btn-success' > annuler</button>-->
<br> <br>

<table class="table table-bordered table-striped" id="order_table">
           <thead>
            <tr>
                <th>id</th>
               <th>Profil</th>
               <th>Horaire</th>
               <th>Nom</th>
               <th>Télé</th>
               <th>Salle</th>
               <th>Matière</th>
               <th>Status</th>
              <th>Action</th>



         </tr>
           </thead>
       </table>


<script>

$(document).ready(function(){

    $('#order_table .formmodif').hide();

  load_data();
          function load_data(ListDays,periode=null)
          {
          var ListDays=$('#ListDays').val();

        $('#order_table').DataTable({
                  processing: false,
                  serverSide: true,
                  ajax: {
                  url:'/year/'+ListDays+'/'+periode,
                  data:{ListDays:ListDays,periode:periode}
                  },

                  columns: [
                  //moment now year
                  {
                    data:'id',
                    name:'id'
                  },
                  {
                   data:'titre',orderable:false,searchable:false,
                   name:'titre'
                  },
                   {
                   data:'Horaire',orderable:false,searchable:false,
                   render:function(data, type, row){
                                   return row['hD']+'h'+'-'+row['hF']+'h'
                              }
                  },
                  {
                   data:'Nom',orderable:false,searchable:false,
                   name:'Nom'
                  },
                  {
                      data:'telephone',orderable:false,searchable:false,
                      name:'telephone'
                  }
                  ,
                   {
                   data:'nomsalle',orderable:false,searchable:false,
                   name:'nomsalle'
                  },
                  {
                   data:'mat',orderable:false,searchable:false,
                   render:function(data, type, row){
                                   return row['mat']+'('+row['typeCours']+')'
                              }

                  },

                  {
                   data:'statusCours',orderable:false,searchable:false,
                   render:function(data, type, row){

            return  row['statusCours'];



            }


                                     },
                                     {
                                      data:'Action',orderable:false,searchable:false,
                   render:function(data, type, row){

                   return  `<button data-id="${row.id}" id="edit"><i id="mod" class="fas fa-edit" title="modifier"></i></button>


<button   id="btnmodif" data-id="${row.id}"><i  id="mod" class="fa fa-check"></i></button>
            <button  id="btnannul"><i class="fa fa-times" aria-hidden="true"></i></button>

<div class="formmodif-${row.id} d-none">
                <form action='' method="post" class="form2-${row.id}">
    @csrf

               <input type=hidden name="id">
                  <select name="statusCours" class="form-control w-100">

                   <option value="fait">fait</option>
                    <option value="nonfait" >non fait</option>
                   <option value="férié">férié</option>

               </select>
                </form>
                </div>`;
                                     }
                  }
                  ]
                 });
          }

        $('.formmodif').hide();
         let id;
 $("#order_table").on('click', '#edit',function(){
         let id = ($(this).data('id'));
           ($(".formmodif-"+id).removeClass('d-none'))


                $.ajax({
                    url:"{{url('editPoint')}}",
                    type:"post",
                    dataType:'json',
                    data:{
                        "_token":"{{ csrf_token() }}",
                        "id":$(this).data('id')
                    },
                    success:function(response){
                        $('input[name="id"]').val(response.data.id);
                        $('input[name="statusCours"]').val(response.data.statusCours);


                    }
                });

        });

// var table;


 $('#btnannul').click(function(){

    $('.formmodif').hide();
});
  $("#order_table").on('click', '#btnmodif',function(){
       let id2 = ($(this).data('id'));

            if(confirm('vous voulez vraiment modifier?')){
                $.ajax({
                    url:"{{url('upPoint')}}",
                    type:"post",
                    dataType:'json',
                    data:$('.form2-'+id2).serialize(),

                    success:function(response){
                       console.log(response);
                        alert("modification avec succès!");
                         // $( '.form2 ')[0].reset();
                      $('#order_table').DataTable().ajax.reload();
                          $('#formmodif').hide();
                    }
                })
            }

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

   let weeks = $('#week').find(":selected").text();
     $("#weekText").val(weeks);

   $('#week').on('change',function(){
       let val=$(this).val();
        weeks = $(this).find(":selected").text();
       $("#weekText").val(weeks);
       // table contient la liste de jours en fr
       chargementSelect(val);
    });

  $('#periode').change(function(){
    var ListDays = $('#ListDays').val();
   // var date =$('#date').val();
    var periode=$(this).val();

    if(ListDays != '' && periode!='')
    {
     $('#order_table').DataTable().destroy();
     load_data(ListDays,periode);
    }
    else
    {
     alert('Erreur ');
    }
   });

});
</script>

 </body>
</html>



