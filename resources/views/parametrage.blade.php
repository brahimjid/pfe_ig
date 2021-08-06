<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link href="css/all.min.css" rel="stylesheet">
         
         
       <title>Acceuil</title>
 </head>
      <body>
        <title>Acceuil</title>
 </head>
      <body>
  
  <div class="container">
      <div class="navbar">
        <a ><img src="css/lo.png" alt="" height="100" width="105" /></a>
        <h4 class="logo"> ISCAE</h4>
        <nav>
      <ul>
<li class="b1"><a href="./"><i class="fas fa-home" title="retourrner vers l'acceuil"></i>Acceuil</a></li>
</ul>
 </nav>


  </div>
  </div>

<h4 class="r">GESTION DES COURS</h4>

      <div class="date" > 
       <?php 

$mytime = Carbon\Carbon::now();
echo $mytime-> toDateTimeString();

?>
</div>

<div>
<a href=" Jliste"  type="button"><button class="button-3d">Jour</button></a>
<a href="Hliste" type="button"><button class="button-3d">Créneau</button></a>

</div>

   </body>                                                                                                                             
</html>