<!-- Page d'accueil pour les suppressions, l'utilisateur peut choisir la table sur laquelle il veut agir -->

<?php



if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['EMPRUNT'])){
        header("location: delete_emprunt.php");
    }
    if (!empty($_POST['USAGER'])){
        header("location: delete_usager.php");
    }
    if (!empty($_POST['VELO'])){
        header("location: delete_velo.php");
    }
    if (!empty($_POST['STATION'])){
        header("location: delete_station.php");
    }
    if (!empty($_POST['COMMUNE'])){
        header("location: delete_commune.php");
    }
    elseif(!empty($_POST['home'])){
        header("location: ../index.php");
    } 
}

?>

<meta charset="UTF-8">
<title>FLOTTE DE VELOS (ajout)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">
<form method="post">
<input type="submit" name="home"  value="Accueil">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> FLOTTE DE VELOS (suppression) </center></h1>


<br>
<br>
<br>
<center>
 
<input type="submit" class="buttonsize2" name="EMPRUNT"  value="EMPRUNT">  
<input type="submit" class="buttonsize2" name="USAGER"  value="USAGER">  
<input type="submit" class="buttonsize2" name="VELO"  value="VELO"> 
<input type="submit" class="buttonsize2" name="STATION"  value="STATION"> 
<input type="submit" class="buttonsize2" name="COMMUNE"  value="COMMUNE"> 

</center>
<br>



</form>

</body>