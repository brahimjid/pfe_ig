<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <title>Pintage_Soir</title>
</head>
<body>
<div class="container">    
   <table width="100%" height="100px"  style="text-align:left">
         <tr><th width='30%'>Institut Superieure de Comptabilite et<br>
          d'Administration d'Entreprises
         </th>
           &nbsp;&nbsp;
           <td></td><td></td>
            <th width='40%'  style="text-align:center;">
                Annee universitaire: {{$annUniv->annee}}
                </th>
        </tr>
        <tr><th> &nbsp;&nbsp;
                @if($annUniv->semestre%2==0)
                Semestre paire
                @else
                Semestre impaire
                @endif
            </th>
           </tr>
        <tr><th> Semaine: </th><th><br>Jour: @foreach($jour as $j ){{$j->jour}} @endforeach<br></th>
          <th>Date du jour: {{$ListDays}}</th><th>Periode: Soir</th>
        </tr>
  &nbsp;&nbsp;
 </table>
<table border='1' width='100%' height='110px' cellspacing='0' cellpadding='0' >
  <thead style="text-align: center" >
   <tr>


               <th>Profil</th>
               <th>Horaire</th> 
               <th>Nom</th>
               <th>Télé</th>
               <th>Salle</th>
               <th>Matière</th>
               <th>Signature</th>
         </tr>
  </thead>

  <tbody>
      @foreach($data as $d)
     <tr>
      <td>{{$d->titre}}</td>
      <td>{{$d->hD}}H-{{$d->hF}}H</td>
      <td>{{$d->Nom}}</td>
      <td>{{$d->telephone}}</td>
      <td>{{$d->nomsalle}}</td>
      <td>{{$d->mat}}({{$d->typeCours}})</td>
      <td></td>
      </tr>
      @endforeach
  </tbody>
</table>
</body>

</html>


