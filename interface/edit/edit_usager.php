<!-- page de modification d'un usager -->

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
    
    
    //Récupère les données de l'utilisateur correspondant pour préremplir le formulaire
    if (!empty($_POST['submit_val_to_edit'])){
        $id=$_POST["USAGER"];
        $reqinfo = getQuery("SELECT * FROM USAGER WHERE ID_USAGER=$id", "custom");
        $attributs = $reqinfo[0];
    }
    $result = "";
    $success = false;
   

    //instanciation de l'objet PDO
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);

    if (!empty($_POST['SUBMIT_U'])){
        
        //preparation de la requête de modification
        $objectData = $database->prepare('UPDATE USAGER SET NOM_USAGER=:nom, PRENOM_USAGER=:prenom, ADRESSE_USAGER=:adr, COMMUNE_USAGER=:commune, DATE_ADHESION=:date_ad WHERE ID_USAGER=:num');
        
        //associe les valeurs selon le résultat du formulaire
        $objectData->bindValue(':num', $_POST['ID_U'], PDO::PARAM_INT);
        $objectData->bindValue(':nom', $_POST['NOM_U'], PDO::PARAM_STR);
        $objectData->bindValue(':prenom', $_POST['PRENOM_U'], PDO::PARAM_STR);
        $objectData->bindValue(':adr', $_POST['ADRESSE_U'], PDO::PARAM_STR);
        $objectData->bindValue(':commune', $_POST['COMMUNE_U'], PDO::PARAM_INT);
        $objectData->bindValue(':date_ad', $_POST['DATE_U'], PDO::PARAM_STR);
        
        //execute la requête uniquement si les champs recquis du formulaire ont été remplis
        if (!empty($_POST['NOM_U']) && !empty($_POST['PRENOM_U']) && !empty($_POST['ADRESSE_U']) && !empty($_POST['COMMUNE_U']) && !empty($_POST['DATE_U'])){
            $success = $objectData->execute();
        }
        if ($success){
            $result = "Modification réalisée avec succès!";
        }
        else{
            $result = "Problème rencontré lors de la modification!";
        }
    }

}


?>



<meta charset="UTF-8">
<title>FLOTTE DE VELOS (modification)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="add"  value="Autre modification">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification d'un usager</center></h1>

<br><br><br>
<center>
Vueillez selectionner l'usager que vous voulez modifier : <select name="USAGER">
<option></option>
<?=printList("USAGER")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br>
<br><br><br>
<br><br><br>
ID usager concernée : <input type=number name="USELESS" value=<?=empty($attributs[0]['ID_USAGER']) ? 0 : $attributs[0]['ID_USAGER']; ?> disabled>
<input type=hidden name="ID_U" value=<?=$attributs[0]['ID_USAGER']?>>
<br><br>
Nouveau nom : <input type=text name="NOM_U" value=<?=$attributs[0]['NOM_USAGER']?>>
<br><br>
Nouveau prenom : <input type=text name="PRENOM_U" value=<?=$attributs[0]['PRENOM_USAGER']?>>
<br><br>
Nouvelle adresse : <input type=text name="ADRESSE_U" value="<?=$attributs[0]['ADRESSE_USAGER']?>">
<br><br>
Nouvelle commune : <select type=text name="COMMUNE_U">
<option value=<?=$attributs[0]['COMMUNE_USAGER']?>><?=$attributs[0]['COMMUNE_USAGER']?></option>
<?=printList("COMMUNE");?>
</select>
<br><br>
Nouvelle date d'adhésion : <input type=date name="DATE_U" value=<?=$attributs[0]['DATE_ADHESION']?>>
<br><br><br><br>
<input type="submit" name="SUBMIT_U"  value="Modifier l'usager"> 
<br><br><br><br>
<br><br><br><br>
<h1><?=$result?></h1>
</center>


</form>

</body>