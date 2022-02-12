<!-- Ce fichier implémente la page d'accueil de l'interface, 
elle offre à l'utilisateur le choix de son action 
et permet de le rediriger vers la page adéquat-->


<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['CONSULT'])){
        header("location: consult/index_consult.php");
    }
    if (!empty($_POST['EDIT'])){
        header("location: edit/index_edit.php");
    }
    if (!empty($_POST['ADD'])){
        header("location: add/index_add.php");
    }
    if (!empty($_POST['DELET'])){
        header("location: delete/index_delete.php");
    }
}
?>


<meta charset="UTF-8">
<title>FLOTTE DE VELOS</title>
<link href="style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">

<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> FLOTTE DE VELOS </center></h1>

<form method="post">
<br>
<br>
<br>
<center>
 
<input type="submit" class="buttonsize" name="CONSULT"  value="CONSULTER">  
<input type="submit" class="buttonsize" name="ADD"  value="AJOUTER">  
<input type="submit" class="buttonsize" name="EDIT"  value="MODIFIER"> 
<input type="submit" class="buttonsize" name="DELET"  value="SUPPRIMER"> 


</center>

<br>



</form>

</body>