<!DOCTYPE html>
	<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
          <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/styl.css">
        <link href="css/all.min.css" rel="stylesheet">
         
<title>Exemple de liens dans une liste déroulante</title>
<script LANGUAGE="JavaScript">
<!--
function change(){
  if (window.document.formListe.liste.selectedIndex != 0)
  //la première valeur est, ici, une valeur bidon qu'on utilise
  //pour donner un titre à la liste déroulante
  window.location = window.document.formListe.liste.options
    [document.formListe.liste.selectedIndex].value
}
// -->
</script>
</head>
<body>
<form NAME="formListe">
  <select NAME="liste" onChange="change()" size="1">
    <option value="liste"> Choisissez un lien </option>
    <option value="./">Home</option>
    <option value="./">Contact</option>
    <option value="javascript.html">JavaScript</option>
    <option value="http://www.altavista.com">Altavista</option>
    <option value="http://www.yahoo.com">Yahoo</option>
  </select>
</form>

    <iframe name="test" 
    width="300"
    height="200"
    src="Bliste" >
</iframe> 
</body>
</html>