<!DOCTYPE html>
<html>
    <head>
        <title>emploi</title>
         <link rel="stylesheet" type="text/css" href="{{asset('DataTables/datatables.min.css')}}">
     <script type="text/javascript" src="{{asset('jquery-3.5.1.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="css/data.css">
       <link href="css/all.min.css" rel="stylesheet">
       <script type="text/javascript" src="{{asset('DataTables/datatables.min.js')}}"></script>
     <link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
                 
</head>
<body>
	<div id="formajout">
    <form action='' method=post id=form1>
    @csrf 

               <select name="cycle" id="mystatus" onchange="changeStatus()">
                   @foreach($cycles as $cycle)
                   <option value="UM">{{$cycle->nom}}</option>
                   @endForeach
               </select>
               <br>
              <select name="dept" id="my">
                @foreach($depts as $dept)
                   <option value="{{$dept->NODEP}}">{{$dept->LDEPL}}</option>
                   @endForeach
               </select>
               <br>

                <select name="idFil">
                   @foreach($filieres as $filiere)
                   <option value="{{$filiere->idFil}}">{{$filiere->idFil}}</option>
                   @endForeach
               </select>

              <br>
              <select name="idClasse">
                @foreach($classes as $classe)
                   <option value="{{$classe->id}}">{{$classe->titreCourt}}</option>
                   @endForeach
               </select>
               <br>
               <select name="respoDepart">
                @foreach($profs as $prof)
                   <option value="{{$prof->Matricule}}">{{$prof->Nom}}</option>
                   @endForeach
               </select>
                    </form>
                </div>
                    </body>

                     <script >
              document.getElementById("my").style.visibility="hidden";

             function changeStatus(){
              
              var status = document.getElementById("mystatus");
              if(status.value == "UM")
              {
                document.getElementById("my").style.visibility="visible";
              }
              
             }
           </script>   
</html>