<!-- Page d'ajout d'un usager -->
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

    
    $objectData = $database->prepare('INSERT INTO USAGER VALUE (NULL, :nom, :prenom, :adr, :commune, :date_ad)');

    $objectData->bindValue(':nom', $_POST['NOM_U'], PDO::PARAM_STR);
    $objectData->bindValue(':prenom', $_POST['PRENOM_U'], PDO::PARAM_STR);
    $objectData->bindValue(':adr', $_POST['ADRESSE_U'], PDO::PARAM_STR);
    $objectData->bindValue(':commune', $_POST['COMMUNE_U'], PDO::PARAM_INT);
    $objectData->bindValue(':date_ad', $_POST['DATE_U'], PDO::PARAM_STR);

    if (!empty($_POST['NOM_U']) && !empty($_POST['PRENOM_U']) && !empty($_POST['ADRESSE_U']) && !empty($_POST['COMMUNE_U']) && !empty($_POST['DATE_U'])){

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
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Ajout d'un usager</center></h1>

<br><br><br>
<center>
Nom : <input type=text name="NOM_U">
<br><br><br>
Prenom : <input type=text name="PRENOM_U">
<br><br><br>
Adresse : <input type=text name="ADRESSE_U">
<br><br><br>
Commune : <select type=text name="COMMUNE_U">
<option></option>
<?=printList("COMMUNE");?>
</select>
<br><br><br>
Date d'adhésion : <input type=date name="DATE_U">
<br><br><br><br>
<input type="submit" name="SUBMIT_U"  value="Ajouter l'usager"> 
<br><br><br><br>
<br><br><br><br>
<h1><?=$result?></h1>
</center>


</form>

</body>