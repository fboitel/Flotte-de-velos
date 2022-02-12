<!-- page de modification d'une station -->

<?php

include '../utils/interaction_base.php';

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['home'])){
        header("location: ../index.php");
    }
    if (!empty($_POST['add'])){
        header("location: index_edit.php");
    }
    $attributs=[];

    //Récupère les données de la station correspondante pour préremplir le formulaire
    if (!empty($_POST['submit_val_to_edit'])){
        $id=$_POST["STATION"];
        $reqinfo = getQuery("SELECT * FROM STATION WHERE ID_STATION=$id", "custom");
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
        $objectData = $database->prepare('UPDATE STATION SET NOM_STATION=:nom, ADRESSE_STATION=:adr, COMMUNE_STATION=:commune, CAPACITE_STATION=:capa WHERE ID_STATION=:num');

        //associe les valeurs selon le résultat du formulaire
        $objectData->bindValue(':num', $_POST['ID_STATION'], PDO::PARAM_INT);
        $objectData->bindValue(':nom', $_POST['NOM_STAT'], PDO::PARAM_STR);
        $objectData->bindValue(':adr', $_POST['ADRESSE_STAT'], PDO::PARAM_STR);
        $objectData->bindValue(':commune', $_POST['COMMUNE_STAT'], PDO::PARAM_INT);
        $objectData->bindValue(':capa', $_POST['CAPACITE_STAT'], PDO::PARAM_INT);
  
        //execute la requête uniquement si les champs recquis du formulaire ont été remplis
        if (!empty($_POST['ADRESSE_STAT']) && !empty($_POST['COMMUNE_STAT']) && !empty($_POST['CAPACITE_STAT'])){

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
<input type="submit" name="add"  value="Autre modification">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification sur une station</center></h1>

<br><br><br>
<center>
Vueillez selectionner la station que vous voulez modifier : <select name="STATION">
<option></option>
<?=printList("STATION")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br>
<br><br><br>
<br><br><br>
ID de la station concernée : <input type=number name="USELESS" value=<?=empty($attributs[0]['ID_STATION']) ? 0 : $attributs[0]['ID_STATION']; ?> disabled>
<input type=hidden name="ID_STATION" value=<?=$attributs[0]['ID_STATION']?>>
<br><br>
Nouveau nom de la station : <input type=text name="NOM_STAT" value=<?=$attributs[0]['NOM_STATION']?>>
<br><br>
Nouvelle adresse de la station : <input type=text name="ADRESSE_STAT" value="<?=$attributs[0]['ADRESSE_STATION']?>">
<br><br>
Nouvelle commune de la station : <select name="COMMUNE_STAT">
<option value=<?=$attributs[0]['COMMUNE_STATION']?>><?=$attributs[0]['COMMUNE_STATION']?></option>
<?=printList("COMMUNE")?>
</select>
<br><br>
Nouvelle capacité de la station : <input type=number name="CAPACITE_STAT" value=<?=$attributs[0]['CAPACITE_STATION']?>>
<br><br><br>
<br>
<input type="submit" name="SUBMIT_STAT"  value="Modifier la station"> 
<br><br><br>
<br><br><br>

<h1><?=$result?></h1>

</center>


</form>

</body>