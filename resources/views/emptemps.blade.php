<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/styl.css">
        <link href="css/all.min.css" rel="stylesheet">
         
         
       <title>Acceuil</title>
</head>
<body>
<form method="post" class="form">


                Semestre <select name="">
                  <option >Selectionnez semestre</option>
                  <option value="S1">S1</option>
                 <option value="S2">S2</option>
                 <option value="S3">S3</option>
                 <option value="S4">S4</option>
               </select>
            
               <br> <br>

             
                Departement <select name="type">
                  <option >Selectionnez Departement</option>
                   <option value="ISCAE">ISCAE</option>
                   <option value="Gestion">Gestion</option>
                   <option value="MQ">MQ</option>
                   <option value="NM">NM</option>
               </select>
             

              
                 filiere <select name="type">
                  <option >Selectionnez filiere</option>
                   <option value="Banques & Assurances">Banques & Assurances</option>
                   <option value="Développement Informatique">Développement Informatique</option>
                   <option value="Finance & Comptabilité">Finance & Comptabilité</option>
                   <option value="FC Payante">FC Payante</option>
                   <option value="Gestion des Ressources Humaines"> 
Gestion des Ressources Humaines</option>
                   <option value="Informatique de Gestion">Informatique de Gestion</option>
                   <option value="IG Payante">IG Payante</option>
                   <option value="Réseaux Télécommunications">Réseaux Télécommunications</option>
                   <option value="Statistiques appliquées à l'économie">Statistiques appliquées à l'économie</option>
                   <option value="Technique Commerciale Marketing">Technique Commerciale Marketing</option>
                   <option value="Master Finance & Comptabilité">Master Finance & Comptabilité</option>
                   <option value="Master Informatique Appliquée à la Gestion">Master Informatique Appliquée à la Gestion</option>

               </select>
             
               <br> <br>


      <fieldset>
     <legend>Classe</legend>
       <select name="modelduscooter" onChange="location.href=''+this.options[this.selectedIndex].value+'';">
           <option >Selectionnez classe</option>
           <option value="#">IG</option>
           <option value="#">DI</option>
           <option value="#">RT</option>
       </select>
   </fieldset>

      <fieldset>
     <legend>Professeur</legend>
       <select name="modelduscooter" onChange="location.href=''+this.options[this.selectedIndex].value+'';">
       <option >Selectionnez professeur</option>
       <option value="#">El Moustapha Faty</option>
       <option value="#"> Mohamedou Mohamed</option>
       <option value="#">Mohamed Mahmoud Khatri</option>
         
      
       </select>
   </fieldset>
</form>


</html>