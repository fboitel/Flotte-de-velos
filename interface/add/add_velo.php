<!-- Page d'ajout d'un vélo -->
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
    
    if (empty($_POST['STAT_VEL'])){
        $objectData = $database->prepare('INSERT INTO VELO VALUE (NULL, :mark, :kil, :etat, :charge, NULL)');

        $objectData->bindValue(':mark', $_POST['MARQUE_VEL'], PDO::PARAM_STR);
        $objectData->bindValue(':kil', $_POST['KM_VEL'], PDO::PARAM_INT);
        $objectData->bindValue(':etat', $_POST['ETAT_VEL'], PDO::PARAM_STR);
        $objectData->bindValue(':charge', $_POST['CHARGE_VEL'], PDO::PARAM_INT);
    }
    else{
        $objectData = $database->prepare('INSERT INTO VELO VALUE (NULL, :mark, :kil, :etat, :charge, :stat)');

        $objectData->bindValue(':mark', $_POST['MARQUE_VEL'], PDO::PARAM_STR);
        $objectData->bindValue(':kil', $_POST['KM_VEL'], PDO::PARAM_INT);
        $objectData->bindValue(':etat', $_POST['ETAT_VEL'], PDO::PARAM_STR);
        $objectData->bindValue(':charge', $_POST['CHARGE_VEL'], PDO::PARAM_INT);
        $objectData->bindValue(':stat', $_POST['STAT_VEL'], PDO::PARAM_INT);
    }
    if (!empty($_POST['MARQUE_VEL']) && (!empty($_POST['KM_VEL']) || $_POST['KM_VEL'] == 0) && !empty($_POST['ETAT_VEL']) && !empty($_POST['CHARGE_VEL'])){
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
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> Ajout d'un vélo</center></h1>

<br><br><br>
<center>
Marque : <input type=text name="MARQUE_VEL">
<br><br><br>
Kilometrage : <input type=number name="KM_VEL">
<br><br><br>
Etat : 
<select name="ETAT_VEL">
  <option></option>
<?=printList("ETAT");?>
</select> 
<br><br><br>
Niveau de charge : <input type=number name="CHARGE_VEL">
<br><br><br>
Station actuelle : <select name="STAT_VEL">
<option></option>
<option value="">EN SERVICE</option>
<?=printList("STATION");?>

</select>
<br><br><br><br>
<input type="submit" name="SUBMIT_VEL"  value="Ajouter le vélo"> 
<br><br><br>
<br><br><br>
<h1><?=$result?></h1>
</center>


</form>

</body>