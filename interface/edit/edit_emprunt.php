<!-- page de modification d'un emprunt -->

<?php
include '../utils/interaction_base.php';


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['home'])){
        header("location: ../index.php");
    }
    if (!empty($_POST['edit'])){
        header("location: index_edit.php");
    }
    $attributs = [];

    //Récupère les données du vélo correspondant pour préremplir le formulaire
    if (!empty($_POST['submit_val_to_edit'])){
        $id=$_POST["EMPRUNT"];
        $reqinfo = getQuery("SELECT * FROM EMPRUNT WHERE ID_EMPRUNT=$id", "custom");
        $attributs = $reqinfo[0];
    }

    $result = "";
    $success = false;
    //instanciation de l'objet PDO
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);

    if (!empty($_POST['SUBMIT_ED'])){
        //Cas ou les champs facultatifs ne sont pas remplis (emprunt en cours)
        if (empty($_POST['DATE_FIN_EMP']) && empty($_POST['ID_ARRIVEE_EMP'])){
            
            //preparation de la requête de mofification
            $objectData = $database->prepare('UPDATE EMPRUNT SET DATE_DEBUT_EMPRUNT=:date_deb , STATION_DEPART=:stat_dep, VELO_CONCERNE=:id_vel, USAGER_CONCERNE=:id_u WHERE ID_EMPRUNT=:num');
            //associe les valeurs selon le résultat du formulaire
            $objectData->bindValue(':num', $_POST['ID_EMPRUNT'], PDO::PARAM_INT);
            $objectData->bindValue(':date_deb', $_POST['DATE_DEBUT_EMP'], PDO::PARAM_STR);
            $objectData->bindValue(':stat_dep', $_POST['ID_DEPART_EMP'], PDO::PARAM_INT);
            $objectData->bindValue(':id_vel', $_POST['ID_VELO_EMP'], PDO::PARAM_INT);
            $objectData->bindValue(':id_u', $_POST['ID_USAGER_EMP'], PDO::PARAM_INT);
        }
        //Cas où l'emprunt est finalisé
        else {
            //preparation de la requête de mofification
            $objectData = $database->prepare('UPDATE EMPRUNT SET DATE_DEBUT_EMPRUNT=:date_deb, DATE_FIN_EMPRUNT=:date_fin , STATION_DEPART=:stat_dep, STATION_ARRIVEE=:stat_arr, VELO_CONCERNE=:id_vel, USAGER_CONCERNE=:id_u  WHERE ID_EMPRUNT=:num');
            //associe les valeurs selon le résultat du formulaire
            $objectData->bindValue(':num', $_POST['ID_EMPRUNT'], PDO::PARAM_INT);
            $objectData->bindValue(':date_deb', $_POST['DATE_DEBUT_EMP'], PDO::PARAM_STR);
            $objectData->bindValue(':date_fin', $_POST['DATE_FIN_EMP'], PDO::PARAM_STR);
            $objectData->bindValue(':stat_dep', $_POST['ID_DEPART_EMP'], PDO::PARAM_INT);
            $objectData->bindValue(':stat_arr', $_POST['ID_ARRIVEE_EMP'], PDO::PARAM_INT);
            $objectData->bindValue(':id_vel', $_POST['ID_VELO_EMP'], PDO::PARAM_INT);
            $objectData->bindValue(':id_u', $_POST['ID_USAGER_EMP'], PDO::PARAM_INT);
        }
    }

    //execute la requête uniquement si les champs recquis du formulaire ont été remplis
    if (!empty($_POST['DATE_DEBUT_EMP']) && !empty($_POST['ID_DEPART_EMP']) && !empty($_POST['ID_VELO_EMP']) && !empty($_POST['ID_USAGER_EMP'])){
        $success = $objectData->execute();
    }

    if ($success){
        $result = "Modification réalisée avec succès!";
    }
    else{
        $result = "Problème rencontré lors de la modification de l'emprunt!";
    }
  
}


?>




<meta charset="UTF-8">
<title>FLOTTE DE VELOS (ajout)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="edit"  value="Autre Modification">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification sur un emprunt</center></h1>

<br><br><br>
<center>
Selectionner l'emprunt à modifier : <select name="EMPRUNT">
<option></option>
<?=printList("EMPRUNT")?>
</select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br><br><br><br><br><br><br>    
ID de l'emprunt concernée : <input type=number name="USELESS" value=<?=empty($attributs[0]['ID_EMPRUNT']) ? 0 : $attributs[0]['ID_EMPRUNT'];?> disabled>
<input type=hidden name="ID_EMPRUNT" value=<?=$attributs[0]['ID_EMPRUNT']?>>
<br><br>
Nouvelle date de début : <input type=date name="DATE_DEBUT_EMP" value=<?=$attributs[0]["DATE_DEBUT_EMPRUNT"]?>>
<br><br>
Nouvelle date de fin* : <input type=date name="DATE_FIN_EMP" value=<?=$attributs[0]["DATE_FIN_EMPRUNT"]?>>
<br><br>
Nouvelle station de départ : <select name="ID_DEPART_EMP">
<option value=<?=$attributs[0]["STATION_DEPART"]?>><?=$attributs[0]["STATION_DEPART"]?></option>
<?=printList("STATION");?>
</select>

<br><br>
Nouvelle station d'arrivée* : <select name="ID_ARRIVEE_EMP">
<option value=<?=$attributs[0]["STATION_ARRIVEE"]?>><?=$attributs[0]["STATION_ARRIVEE"]?></option>
<?=printList("STATION");?>
</select>

<br><br>
Nouveau vélo concerné : <select name="ID_VELO_EMP">
<option value=<?=$attributs[0]["VELO_CONCERNE"]?>><?=$attributs[0]["VELO_CONCERNE"]?></option>
<?=printList("VELO");?>
</select>
<br><br>
Nouvel usager concerné : <select name="ID_USAGER_EMP">
<option value=<?=$attributs[0]["USAGER_CONCERNE"]?>><?=$attributs[0]["USAGER_CONCERNE"]?></option>
<?=printList("USAGER");?>
</select>
<br><br>
<br>
<input type="submit" name="SUBMIT_ED"  value="Modifier l'emprunt"> 
<br><br><br>
<p>*Champs facultatifs</p>
<br><br><br>
<h1><?=$result?></h1>

</center>


</form>

</body>