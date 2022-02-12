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
    //Récupère le nom de la commune à modifier
    if (!empty($_POST['submit_val_to_edit'])){
        $id=$_POST["COMMUNE"];
        $reqinfo = getQuery("SELECT * FROM COMMUNE WHERE ID_COMMUNE=$id", "custom");
        $attributs = $reqinfo[0];
    }

    $result = "";
    $success = false;
  
    //instanciation de l'objet PDO
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);

    if (!empty($_POST['SUBMIT_COM'])){
        //Cas ou la station actuelle est nulle (velo en service)
        $objectData = $database->prepare('UPDATE COMMUNE SET NOM_COMMUNE=:nom WHERE ID_COMMUNE=:num LIMIT 1');

        //associe les valeurs selon le résultat du formulaire
        $objectData->bindValue(':nom', $_POST['NOM_COMMUNE'], PDO::PARAM_STR);
        $objectData->bindValue(':num', $_POST['ID_COMMUNE'], PDO::PARAM_INT);

        if (!empty($_POST['NOM_COMMUNE'])){
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
<title>FLOTTE DE VELOS (ajout)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">


<form method="post">

<input type="submit" name="home"  value="Accueil">
<input type="submit" name="edit"  value="Autre modification">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Modification sur une commune</center></h1>

<br><br><br>
<center>
Vueillez selectionner la commune que vous voulez modifier : <select name="COMMUNE">
<option></option>
<?=printList("COMMUNE")?>
<select>
<input type="submit" name="submit_val_to_edit"  value="soumettre"> 
<br><br><br>
<br><br><br>
<br><br><br>
ID commune concernée : <input type=number name="USELESS" value=<?=empty($attributs[0]['ID_COMMUNE']) ? 0 : $attributs[0]['ID_COMMUNE']; ?> disabled>
<input type=hidden name="ID_COMMUNE" value=<?=$attributs[0]['ID_COMMUNE']?>>
<br>
Nouveau nom de la commune : <input type=text name="NOM_COMMUNE" value=<?=$attributs[0]['NOM_COMMUNE']?>>
<br><br><br>
<br><br><br><br>
<input type="submit" name="SUBMIT_COM"  value="Modifier la commune"> 
<br><br><br>
<h1><?=$result?></h1>

</center>


</form>

</body>