<!DOCTYPE html>
<html>
    <head>
        <script>
        function imprimer() {
    // body...
  var target=document.getElementById('target').innerHTML;
 var body=document.body.innerHTML;
 //alert('b-1');
 document.body.innerHTML=target;
 //alert('b-2');
 window.print();
 //alert('b-3');
 document.body.innerHTML=body;
//alert('b-4');
}
        </script>        
    </head>
    <body>
        
    
 
        <div class="container">         
<div id='target'>
    <!------------------------header------------------------------>
    <table width="100%" height="100px"  style="text-align:left">
        <tr><th width='30%'>Institut Superieure de Comptabilite et<br>
          d'Administration d'Entreprises
         </th>
           &nbsp;&nbsp;
            <th width='40%'  style="text-align:center">
                Annee universitaire: {{$annUniv->annee}}
                <br>
                @if($annUniv->semestre%2==0)
                Semestre paire
                @else
                Semestre impaire
                @endif
                <br>
                <br>Emplois du temps<br>
                <br>Enseignant(e): 
                @foreach($prof as $prf)
                {{$prf->Nom}}
                @endForeach
               
                <br>
                  &nbsp;&nbsp;
            </th>
            <td></td>
        </tr>
    </table>
  &nbsp;&nbsp;
    <table border='1' width='100%' height='1100px' cellspacing='0' cellpadding='0' style="text-align: center">
        <thead>    @php 
        $dimanche=false;
        $dimJour=-1;
        $fontSize='0.7em';
        echo"<th style='text-align: center' width='45px'>"
                . "Horaire"
             . "</th>";
        
             echo '<th style="text-align: center" width="100px">Dimanche</th>';
        echo '<th style="text-align: center" width="100px">Lundi</th>';
        echo '<th style="text-align: center" width="100px">Mardi</th>';        
        echo '<th style="text-align: center" width="100px">Mercredi</th>';
        echo '<th style="text-align: center" width="100px">Jeudi</th>';
        echo '<th style="text-align: center" width="100px">Vendredi</th>';
        echo '<th style="text-align: center" width="100px">Samedi</th>';

        echo '</thead>';
      
        
        echo"<tbody>";

$rowspan=array(1,1,1,1,1,1,1); 
for($ligne=8;$ligne<=12;$ligne+=2){//les evenements par jour
    
    
     //$date=$result['start'];
    echo"<tr ><td height='50px' width='45px' style='background-color: #e5eaec'>".$ligne."h-".($ligne+2)."h</td>";///horaire
   
    for($col=1;$col<=7;$col++){//les jours de la semaine du travail
if($ligne<10){
    if($ligne==8)
        $ligne='08';
    else
        $ligne='09';
    
    if(!empty($event[$col][$ligne]) ){
    //    $rowspan[$col-1]=date('H',strtotime($event[$col][$ligne]['hF']))-date('H',strtotime($event[$col][$ligne]['hD']));
        echo"<td width='100px'  rowspan=".$rowspan[$col-1]." style='background-color: #e5eaec'>";
        echo"<span style='font-size:".$fontSize.";font-family:arial'>";
        // echo $ligne.'------'.$rowspan[$col-1].'-----'.$col;
        echo $event[$col][$ligne]['mat'].'('.$event[$col][$ligne]['typeCours'].')';
        echo '<br>'.'S'.$event[$col][$ligne]['semestre'];
        echo ', Groupe: '.$event[$col][$ligne]['titreCourt'].'-G'.$event[$col][$ligne]['ordre'];
        echo ', Salle: '.$event[$col][$ligne]['idSalle'];
        
        
        echo "</span></td>";
        }else{
            if($rowspan[$col-1]>1){
                $rowspan[$col-1]--;
            }else{
                echo"<td width='100px'  rowspan='1' style='background-color: #e5eaec'></td>";
            }
        }

}else
    if(!empty($event[$col][$ligne]) ){
    //    $rowspan[$col-1]=date('H',strtotime($event[$col][$ligne]['hF']))-date('H',strtotime($event[$col][$ligne]['hD']));
        echo"<td width='100px'  rowspan=".$rowspan[$col-1]." style='background-color: #e5eaec'>";
        echo"<span style='font-size:".$fontSize.";font-family:arial'>";
        // echo $ligne.'------'.$rowspan[$col-1].'-----'.$col;
        echo $event[$col][$ligne]['mat'].'('.$event[$col][$ligne]['typeCours'].')';
        echo ', Groupe: '.$event[$col][$ligne]['titreCourt'].'-G'.$event[$col][$ligne]['ordre'];
        echo ', Salle: '.$event[$col][$ligne]['idSalle'];
        
        echo "</span></td>";
        }else{
            if($rowspan[$col-1]>1){
                $rowspan[$col-1]--;
            }else{
                echo"<td width='100px'  rowspan='1' style='background-color: #e5eaec'></td>";
            }
        }
       }
    echo"</tr>";
   
}
?>

<!-- ligne separateur entre le matin et le soir -->
<tr><td  height='50px' width='45px' style='background-color: #e5eaec'>14h-15h</td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td><td width='100px'   style='background-color: #e5eaec'></td></tr>
<?php
for($ligne=15;$ligne<=19;$ligne+=2){//les evenements par jour
    
    
     //$date=$result['start'];
    echo"<tr ><td height='50px' width='45px' style='background-color: #e5eaec'>".$ligne."h-".($ligne+2)."h</td>";///horaire
   
    for($col=1;$col<=7;$col++){//les jours de la semaine du travail

    if(!empty($event[$col][$ligne]) ){
        //$rowspan[$col-1]=date('H',strtotime($event[$col][$ligne]['hF']))-date('H',strtotime($event[$col][$ligne]['hD']));
        echo"<td width='100px'  rowspan=".$rowspan[$col-1]." style='background-color: #e5eaec'>";
        echo"<span style='font-size:".$fontSize.";font-family:arial'>";
        // echo $ligne.'------'.$rowspan[$col-1].'-----'.$col;
        echo $event[$col][$ligne]['mat'].'('.$event[$col][$ligne]['typeCours'].')';
        echo ', Groupe: '.$event[$col][$ligne]['titreCourt'].'-G'.$event[$col][$ligne]['ordre'];
        echo ', Salle: '.$event[$col][$ligne]['idSalle'];
        // echo ''.$event[$col][$ligne]['idGroupe'];
        
        echo "</span></td>";
        }else{
            if($rowspan[$col-1]>1){
                $rowspan[$col-1]--;
            }else{
                echo"<td width='100px'  rowspan='1' style='background-color: #e5eaec'></td>";
            }
        }

       }
    echo"</tr>";
   
}

echo'</tbody>';

@endphp
</table>
</div> 
            <div> 
                <style type="text/css">
                    button{
                        padding:10px;
                        font-size:18px;
                        margin-top: 10px
                    }
                    button:hover{
                        font-size: 20px;
                        padding: 8px;
                    }
                </style>    
                <button   onclick="imprimer()" class="btn-success btn-block " style='background-color: #5CB195; color:white'>Imprimer</button>
                <a href="/calendar"><button width="30%" height="40px" style='background-color: #5CB195; color:white'>Acceuil</button></a>
            </div>
        </div>   
       <br><br><br><br><br>

       
    </body>
</html>
