<!-- page d'ajout d'une commune -->

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['home'])){
        header("location: ../index.php");
    }
    if (!empty($_POST['add'])){
        header("location: index_add.php");
    }

    $result = "";
    $success = false;
  

    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);

    $objectData = $database->prepare('INSERT INTO COMMUNE VALUE (NULL, :nom)');


    $objectData->bindValue(':nom', $_POST['NOM_COMMUNE'], PDO::PARAM_STR);

    if (!empty($_POST['NOM_COMMUNE'])){
        $success = $objectData->execute();
    }
    if ($success){
        $result = "Ajout réalisé avec succès!";
    }
    else{
        $result = "Problème rencontré lors de l'ajout!";
    }

}

?>




<meta charset="UTF-8">
<title>FLOTTE DE VELOS (ajout)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="add"  value="Autre ajout">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Ajout d'une commune</center></h1>

<br><br><br>
<center>
Nom de la commune : <input type=text name="NOM_COMMUNE">
<br><br><br>
<br><br><br><br>
<input type="submit" name="SUBMIT_COM"  value="Ajouter la commune"> 
<br><br><br>
<h1><?=$result?></h1>

</center>


</form>

</body>