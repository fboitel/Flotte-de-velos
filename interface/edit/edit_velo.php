<!-- page de modification d'un vélo -->

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

    //Récupère les données du vélo correspondant pour préremplir le formulaire
    if (!empty($_POST['submit_val_to_edit'])){
        $id=$_POST["VELO"];
        $reqinfo = getQuery("SELECT * FROM VELO WHERE REFERENCE_VELO=$id", "custom");
        $attributs = $reqinfo[0];
    }

    $result = "";
    $success = false;
    
    //instanciation de l'objet PDO
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);
    
    if (!empty($_POST['SUBMIT_VEL'])){
        //Cas ou la station actuelle est nulle (velo en service)
        if(empty($_POST['STAT_VEL'])){

            //preparation de la requête de mofification
            $objectData = $database->prepare('UPDATE VELO SET MARQUE_VELO=:mark, KILOMETRAGE=:kil, ETAT_VELO=:etat, NIVEAU_CHARGE=:charge, STATION_ACTUELLE=NULL WHERE REFERENCE_VELO=:num');

            //associe les valeurs selon le résultat du formulaire
            $objectData->bindValue(':num', $_POST['ID_VEL'], PDO::PARAM_INT);
            $objectData->bindValue(':mark', $_POST['MARQUE_VEL'], PDO::PARAM_STR);
            $objectData->bindValue(':kil', $_POST['KM_VEL'], PDO::PARAM_INT);
            $objectData->bindValue(':etat', $_POST['ETAT_VEL'], PDO::PARAM_STR);
            $objectData->bindValue(':charge', $_POST['CHARGE_VEL'], PDO::PARAM_INT);
        }
        //Cas ou le velo est ajouté dans une stations
        else{
            //preparation de la requête d'ajout
            $objectData = $database->prepare('UPDATE VELO SET MARQUE_VELO=:mark, KILOMETRAGE=:kil, ETAT_VELO=:etat, NIVEAU_CHARGE=:charge, STATION_ACTUELLE=:stat WHERE REFERENCE_VELO=:num');

            //associe les valeurs selon le résultat du formulaire
            $objectData->bindValue(':num', $_POST['ID_VEL'], PDO::PARAM_INT);
            $objectData->bindValue(':mark', $_POST['MARQUE_VEL'], PDO::PARAM_STR);
            $objectData->bindValue(':kil', $_POST['KM_VEL'], PDO::PARAM_INT);
            $objectData->bindValue(':etat', $_POST['ETAT_VEL'], PDO::PARAM_STR);
            $objectData->bindValue(':charge', $_POST['CHARGE_VEL'], PDO::PARAM_INT);
            $objectData->bindValue(':stat', $_POST['STAT_VEL'], PDO::PARAM_STR);
        }
        
        //execute la requête uniquement si les champs recquis du formulaire ont été remplis
        if (!empty($_POST['MARQUE_VEL']) && (!empty($_POST['KM_VEL']) || $_POST['KM_VEL'] == 0) && !empty($_POST['ETAT_VEL']) && !empty($_POST['CHARGE_VEL'])){
            $success = $objectData->execute();
        }

        if ($success){
            $result = "Modification réalisé avec succès!";
        }
        else{
            $result = "Problème rencontré lors de l modification!";
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
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification d'un vélo</center></h1>

<br><br><br>
<center>
Vueillez selectionner le vélo que vous voulez modifier : <select name="VELO">
<option></option>
<?=printList("VELO")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br>
<br><br><br>
<br><br><br>
ID commune concernée : <input type=number name="USELESS" value=<?=empty($attributs[0]['REFERENCE_VELO']) ? 0 : $attributs[0]['REFERENCE_VELO']; ?> disabled>
<input type=hidden name="ID_VEL" value=<?=$attributs[0]['REFERENCE_VELO']?>>
<br><br>
Nouvell marque : <input type=text name="MARQUE_VEL" value=<?=$attributs[0]['MARQUE_VELO']?>>
<br><br>
Nouveau kilometrage : <input type=number name="KM_VEL" value=<?=$attributs[0]['KILOMETRAGE']?>>
<br><br>
Nouvel etat : 
<select name="ETAT_VEL">
  <option value=<?=$attributs[0]['ETAT_VELO']?>><?=$attributs[0]['ETAT_VELO']?></option>
<?=printList("ETAT");?>
</select> 
<br><br>
Nouveau niveau de charge : <input type=number name="CHARGE_VEL" value=<?=$attributs[0]['NIVEAU_CHARGE']?>>
<br><br>
Nouvelle station actuelle : <select name="STAT_VEL">
<option value=<?=$attributs[0]['STATION_ACTUELLE']?>><?=$attributs[0]['STATION_ACTUELLE']?></option>
<option value="">EN SERVICE</option>
<?=printList("STATION");?>
</select>
<br><br><br><br>
<input type="submit" name="SUBMIT_VEL"  value="Modifier le vélo"> 

<br><br><br>
<h1><?=$result?></h1>
</center>


</form>

</body>