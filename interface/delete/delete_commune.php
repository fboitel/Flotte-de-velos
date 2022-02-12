<!-- Page de suppression d'une commune -->
<?php

include '../utils/interaction_base.php';


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['home'])){
        header("location: ../index.php");
    }
    if (!empty($_POST['delete'])){
        header("location: index_delete.php");
    }

    $result = "";
    $success = false;
  
    //instanciation of a PDO object that reprensent the database
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);
    //Request preparation for adding
    $objectData = $database->prepare('DELETE FROM COMMUNE WHERE ID_COMMUNE=:num');

    //bind the values
    $objectData->bindValue(':num', $_POST['COMMUNE'], PDO::PARAM_INT);
    //execute only if all the fields below have been filled
    if (!empty($_POST['COMMUNE'])){
        $success = $objectData->execute();
    }
    if ($success){
        $result = "Suppression réalisée avec succès!";
    }
    else{
        $result = "Problème rencontré lors de la suppresion!";
    }

}

?>




<meta charset="UTF-8">
<title>FLOTTE DE VELOS (suppression)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="delete"  value="Autre suppression">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center>Suppression d'une commune</center></h1>

<br><br><br>
<center>

<br><br><br>



Vueillez selectionner la commune que vous voulez supprimer : <select name="COMMUNE">
<option></option>
<?=printList("COMMUNE")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="supprimer">
<br><br><br>
<h1><?=$result?></h1>
</center>
</form>

</body>