<!-- Page d'accueil pour les modifications, l'utilisateur peut choisir la table sur laquelle il veut agir -->

<?php



if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (!empty($_POST['EMPRUNT'])){
        header("location: edit_emprunt.php");
    }
    if (!empty($_POST['USAGER'])){
        header("location: edit_usager.php");
    }
    if (!empty($_POST['VELO'])){
        header("location: edit_velo.php");
    }
    if (!empty($_POST['STATION'])){
        header("location: edit_station.php");
    }
    if (!empty($_POST['COMMUNE'])){
        header("location: edit_commune.php");
    }
    if (!empty($_POST['DISTANCE'])){
        header("location: edit_distance.php");
    }
    elseif(!empty($_POST['home'])){
        header("location: ../index.php");
    }
    
}

?>

<meta charset="UTF-8">
<title>FLOTTE DE VELOS (modification)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">
<form method="post">
<input type="submit" name="home"  value="Accueil">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center> FLOTTE DE VELOS (modification) </center></h1>


<br>
<br>
<br>
<center>
 
<input type="submit" class="buttonsize2" name="EMPRUNT"  value="EMPRUNT">  
<input type="submit" class="buttonsize2" name="USAGER"  value="USAGER">  
<input type="submit" class="buttonsize2" name="VELO"  value="VELO"> 
<input type="submit" class="buttonsize2" name="STATION"  value="STATION"> 
<input type="submit" class="buttonsize2" name="COMMUNE"  value="COMMUNE"> 
<input type="submit" class="buttonsize2" name="DISTANCE"  value="DISTANCE"> 

</center>
<br>



</form>

</body>