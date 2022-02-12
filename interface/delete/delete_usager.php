<!-- Page de suppression d'un usager -->
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
  
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);

    $objectData = $database->prepare('DELETE FROM USAGER WHERE ID_USAGER=:num');

    $objectData->bindValue(':num', $_POST['USAGER'], PDO::PARAM_INT);

    if (!empty($_POST['USAGER'])){
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
<body style="background-color:rgb(255, 255, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="delete"  value="Autre suppression">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Suppression d'un usager</center></h1>

<br><br><br>
<center>

<br><br><br>



Vueillez selectionner l'usager que vous voulez supprimer : <select name="USAGER">
<option></option>
<?=printList("USAGER")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="supprimer">
<br><br><br>
<h1><?=$result?></h1>
</center>
</form>

</body>