<!-- Page d'ajout d'un emprunt -->

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

    //Cas ou les champs facultatifs ne sont pas remplis
    if (empty($_POST['DATE_FIN_EMP']) && empty($_POST['ID_ARRIVEE_EMP'])){

        $objectData = $database->prepare('INSERT INTO EMPRUNT VALUE (NULL, :date_deb , NULL, :stat_dep, NULL, :id_vel, :id_u)');

        $objectData->bindValue(':date_deb', $_POST['DATE_DEBUT_EMP'], PDO::PARAM_STR);
        $objectData->bindValue(':stat_dep', $_POST['ID_DEPART_EMP'], PDO::PARAM_INT);
        $objectData->bindValue(':id_vel', $_POST['ID_VELO_EMP'], PDO::PARAM_INT);
        $objectData->bindValue(':id_u', $_POST['ID_USAGER_EMP'], PDO::PARAM_INT);
    }
    //Autre cas 
    else {
        $objectData = $database->prepare('INSERT INTO EMPRUNT VALUE (NULL, :date_deb , :date_fin, :stat_dep, :stat_arr, :id_vel, :id_u)');

        $objectData->bindValue(':date_deb', $_POST['DATE_DEBUT_EMP'], PDO::PARAM_STR);
        $objectData->bindValue(':date_fin', $_POST['DATE_FIN_EMP'], PDO::PARAM_STR);
        $objectData->bindValue(':stat_dep', $_POST['ID_DEPART_EMP'], PDO::PARAM_INT);
        $objectData->bindValue(':stat_arr', $_POST['ID_ARRIVEE_EMP'], PDO::PARAM_INT);
        $objectData->bindValue(':id_vel', $_POST['ID_VELO_EMP'], PDO::PARAM_INT);
        $objectData->bindValue(':id_u', $_POST['ID_USAGER_EMP'], PDO::PARAM_INT);
    }


    if (!empty($_POST['DATE_DEBUT_EMP']) && !empty($_POST['ID_DEPART_EMP']) && !empty($_POST['ID_VELO_EMP']) && !empty($_POST['ID_USAGER_EMP'])){
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
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Ajout d'un emprunt</center></h1>

<br><br><br>
<center>
Date de début : <input type=date name="DATE_DEBUT_EMP">
<br><br><br>
Date de fin* : <input type=date name="DATE_FIN_EMP">
<br><br><br>
Station de départ : <select name="ID_DEPART_EMP">
<option></option>
<?=printList("STATION");?>
</select>

<br><br><br>
Station d'arrivée* : <select name="ID_ARRIVEE_EMP">
<option></option>
<?=printList("STATION");?>
</select>

<br><br><br>
Velo concerné : <select name="ID_VELO_EMP">
<option></option>
<?=printList("VELO");?>
</select>
<br><br><br>
Usager concerné : <select name="ID_USAGER_EMP">
<option></option>
<?=printList("USAGER");?>
</select>
<br><br><br>
<br>
<input type="submit" name="SUBMIT_ADD"  value="Ajouter l'emprunt"> 
<br><br><br>
<p>*Champs facultatifs</p>
<br><br><br>
<h1><?=$result?></h1>

</center>


</form>

</body>