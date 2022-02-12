<!-- Page de consultation de la base de donnée -->
<?php


include '../utils/interaction_base.php';

//Contiendra les données à afficher
$toshow=[];

//Permettra eventuellement de recueillir des paramètres optionnels selin la requête
$additionnal="";

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    //main
    //Recueil des données pour une requête personnalisée
    if ($_POST['custom'] != "" && !empty($_POST['submit2'])){
        $toshow = getQuery($_POST['custom'], "custom");
    }
    elseif(!empty($_POST['submit1'])) {
        //Requêtes demandant des paramètres, chaque requête est détaillée dans utils/interaction_base.php
        //Il faut ici demander les paramètres dans un premiers temps
        if ($_POST['request'] == "VELO_PAR_STATION"){
            $part1="Station : <select name=\"ID_STATION\"><option></option>";
            $options=printList("STATION");
            $part2="</select><input type=\"submit\" name=\"submit_velo_par_station\" value=\"soumettre\">";
            $additionnal=$part1.$options.$part2;
        }
        elseif ($_POST['request'] == "STATION_PAR_COMMUNE"){
            $part1="Commune: <select name=\"COMMUNE\"><option></option>";
            $options=printList("COMMUNE");
            $part2="</select><input type=\"submit\" name=\"submit_station_par_commune\" value=\"soumettre\">";
            $additionnal=$part1.$options.$part2;
        }
        elseif ($_POST['request'] == "EMPRUNT_MEME_JOUR"){
            $additionnal="Date: <input type=date name=\"DATE_EMPRUNT\">
                         <input type=\"submit\" name=\"submit_emprunt_meme_jour\" value=\"soumettre\">  ";
        }
        elseif ($_POST['request'] == "STATISTIQUE_1"){
            $additionnal="Etendue de la periode: <input type=date name=\"DATE_11\"><input type=date name=\"DATE_12\">
                         <input type=\"submit\" name=\"submit_statistique_1\" value=\"soumettre\">  ";
        }
        elseif ($_POST['request'] == "STATISTIQUE_2"){
            $additionnal="Etendue de la periode: <input type=date name=\"DATE_21\"><input type=date name=\"DATE_22\">
                         <input type=\"submit\" name=\"submit_statistique_2\" value=\"soumettre\">  ";
        }
        elseif ($_POST['request'] == "STATISTIQUE_3"){
            $part1="Commune: <select name=\"COMMUNE\"><option></option>";
            $options=printList("COMMUNE");
            $part2="</select><input type=\"submit\" name=\"submit_statistique_3\" value=\"soumettre\">";
            $additionnal=$part1.$options.$part2;
        }
        elseif ($_POST['request'] == "STATISTIQUE_4"){
            $part1="Station: <select name=\"STATION\"><option></option>";
            $options=printList("STATION");
            $part2="</select><input type=\"submit\" name=\"submit_statistique_4\" value=\"soumettre\">";
            $additionnal=$part1.$options.$part2;
        }
        //Requête sans paramètre optionnel 
        else{
            $toshow = getQuery($_POST['request'], "select");
        }
    }

    //Récupère finalement les données des requêtes a paramètre en soumettant les paramètres récupéré par l'interface
    elseif(!empty($_POST['submit_velo_par_station'])) {   
        $toshow = getQuery("VELO_PAR_STATION", "select", $_POST['ID_STATION']);
    }
    elseif(!empty($_POST['submit_station_par_commune'])) {   
        $toshow = getQuery("STATION_PAR_COMMUNE", "select", $_POST['COMMUNE']);
    }
    elseif(!empty($_POST['submit_emprunt_meme_jour'])) {   
        $toshow = getQuery("EMPRUNT_MEME_JOUR", "select", $_POST['DATE_EMPRUNT']);
    }
    elseif(!empty($_POST['submit_statistique_1'])) {   
        $toshow = getQuery("STATISTIQUE_1", "select", $_POST['DATE_11'], $_POST['DATE_12']);
    }   
    elseif(!empty($_POST['submit_statistique_2'])) {   
        $toshow = getQuery("STATISTIQUE_2", "select", $_POST['DATE_21'], $_POST['DATE_22']);
    }  
    elseif(!empty($_POST['submit_statistique_3'])) {   
        $toshow = getQuery("STATISTIQUE_3", "select", $_POST['COMMUNE']);
    } 
    elseif(!empty($_POST['submit_statistique_4'])) {   
        $toshow = getQuery("STATISTIQUE_4", "select", $_POST['STATION']);
    } 
    elseif(!empty($_POST['home'])){
        header("location: ../index.php");
    }
}


?>


<meta charset="UTF-8">
<title>FLOTTE DE VELOS (consultation)</title>
<link href="../style/style.css" type="text/css" rel="stylesheet">
<body style="background-color:rgb(210, 210, 255);">
<form method="post">
<input type="submit" name="home"  value="Accueil">
<h1 style="color: rgb(0, 0, 0); font-style: normal; font-family: sans-serif"><center>FLOTTE DE VELOS (consultation)</center></h1>

<br><br>
<!-- Menu déroulant avec les différents choix de requête prédéfinies -->
<center>
<label for="request">Selectionner une information à afficher: </label>
<select id="idrand" name="request">
  <option value="BASE">Selectionner</option>
  <option value="USAGER">Liste des usagers</option>
  <option value="EMPRUNT">Liste des emprunts</option>
  <option value="STATION">Liste des stations</option>
  <option value="VELO">Liste des vélos</option>
  <option value="COMMUNE">Liste des communes</option>
  <option value="DISTANCE">Liste des distances entre chaque station</option>
  <option value="ETAT">Liste des états dans lequel peut être un vélo</option>
  <option value="VELO_STATION">Liste des vélos rangés par station</option>
  <option value="VELO_PAR_STATION">Liste des vélos dans une station donnée</option>
  <option value="VELO_UTILISATION">Liste des vélos en cours d'utilisation</option>
  <option value="STATION_PAR_COMMUNE">Liste des stations pour une commune donnée</option>
  <option value="EMPRUNT_MEME_JOUR"> Liste des adhérents qui ont emprunté plusieurs vélos pour un jour donnée</option>
  <option value="VELO_ETAT"> Liste des vélos avec leur état</option>
  <option value="STATISTIQUE_1"> Moyenne du nombre d’usagers par vélo par jour</option>
  <option value="STATISTIQUE_2"> Moyenne des distances parcourues par les vélos sur une semaine</option>
  <option value="STATISTIQUE_3"> Classement des stations par nombre de places disponibles par commune</option>
  <option value="STATISTIQUE_4"> Classement des vélos les plus chargés par station</option>


</select> 

<input type="submit" name="submit1"  value="soumettre">  
&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;&thinsp;
<!-- Requêtes personnalisées -->

<label for="custom">ou une requête personnalisée: </label>
<input type="text" name="custom">      

<input type="submit" name="submit2"  value="soumettre">  


<!-- Demande éventuelle de paramètre supplémentaire, ou alors affichage de la requête et des données associées -->
<p> <?=$additionnal;?><br><br><?= empty($toshow[1]) ? "" :"Requête SQL executée :"?> <br><?=$toshow[1]?><br><br><?=display($toshow[0]); ?> </p>
</center>

</form>

</body>
