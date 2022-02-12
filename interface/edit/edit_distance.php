<?php

include '../utils/interaction_base.php';

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['home'])){
        header("location: ../index.php");
    }
    if (!empty($_POST['edit'])){
        header("location: index_edit.php");
    }
    $attributs=[];
    //Récupère la distance correspondant pour préremplir le formulaire
    if (!empty($_POST['submit_val_to_edit'])){
        $id1=$_POST["STATION_1"];
        $id2=$_POST["STATION_2"];
        $reqinfo = getQuery("SELECT * FROM DISTANCE WHERE STATION_1=$id1 AND STATION_2=$id2", "custom");
        $attributs = $reqinfo[0];
    }
    $result = "";
    $success = false;
    
    //instanciation de l'objet PDO
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);
    
    if (!empty($_POST['SUBMIT_STAT'])){
        //preparation de la requête de mofification
        $objectData = $database->prepare('UPDATE DISTANCE SET DISTANCE_KM=:dist WHERE STATION_1=:stat1 and STATION_2=:stat2');

        //bind the values
        $objectData->bindValue(':stat1', $_POST['STAT_1'], PDO::PARAM_INT);
        $objectData->bindValue(':stat2', $_POST['STAT_2'], PDO::PARAM_STR);
        $objectData->bindValue(':dist', $_POST['DIST'], PDO::PARAM_STR);
        //associe les valeurs selon le résultat du formulaire
        if (!empty($_POST['DIST'])){

            $success = $objectData->execute();
        }

        if ($success){
            $result = "Modification réalisée avec succès!";
        }
        else{
            $result = "Problème rencontré lors de l'ajout!";
        }
    }
}

?>

<meta charset="UTF-8">
<title>FLOTTE DE VELOS (ajout)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="edit"  value="Autre modification">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification sur une distance</center></h1>

<br><br><br>
<center>
Vueillez selectionner les stations que vous voulez modifier : <select name="STATION_1">
<option></option>
<?=printList("STATION")?>
<select>
<select name="STATION_2">
<option></option>
<?=printList("STATION")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br>
<br><br><br>
<br><br><br>
ID des stations concernées : <input type=number name="USELESS1" value=<?=empty($attributs[0]['STATION_1']) ? 0 : $attributs[0]['STATION_1']; ?> disabled>
<input type=hidden name="STAT_1" value=<?=$attributs[0]['STATION_1']?>>
<input type=number name="USELESS2" value=<?=empty($attributs[0]['STATION_2']) ? 0 : $attributs[0]['STATION_2']; ?> disabled>
<input type=hidden name="STAT_2" value=<?=$attributs[0]['STATION_2']?>>
<br><br>
Nouvelle distance : <input type=number name="DIST" value=<?=$attributs[0]['DISTANCE_KM']?>>
<br><br><br><br><br>
<br>
<input type="submit" name="SUBMIT_STAT"  value="Modifier la station"> 
<br><br><br>
<br><br><br>

<h1><?=$result?></h1>

</center>


</form>

</body>