<!-- Page d'ajout d'une station -->

<?php

include '../utils/interaction_base.php';

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

    $objectData = $database->prepare('INSERT INTO STATION VALUE (NULL, :nom, :adr, :commune, :capa)');


    $objectData->bindValue(':nom', $_POST['NOM_STAT'], PDO::PARAM_STR);
    $objectData->bindValue(':adr', $_POST['ADRESSE_STAT'], PDO::PARAM_STR);
    $objectData->bindValue(':commune', $_POST['COMMUNE_STAT'], PDO::PARAM_INT);
    $objectData->bindValue(':capa', $_POST['CAPACITE_STAT'], PDO::PARAM_INT);

    if (!empty($_POST['ADRESSE_STAT']) && !empty($_POST['COMMUNE_STAT']) && !empty($_POST['CAPACITE_STAT'])){

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
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Ajout d'une station</center></h1>

<br><br><br>
<center>
Nom de la station : <input type=text name="NOM_STAT">
<br><br><br>
Adresse de la station : <input type=text name="ADRESSE_STAT">
<br><br><br>
Commune de la station : <select name="COMMUNE_STAT">
<option></option>
<?=printList("COMMUNE")?>
</select>
<br><br><br>
Capacité de la station : <input type=number name="CAPACITE_STAT">
<br><br><br>
<br>
<input type="submit" name="SUBMIT_STAT"  value="Ajouter la station"> 
<br><br><br>
<br><br><br>

<h1><?=$result?></h1>

</center>


</form>

</body>