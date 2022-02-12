<?php

/**
 * 
 * Ce fichier emplémente la pupart des fonctions que nous utiliserons dans l'interface 
 * pour intéragir avec le SGBD et traiter ses données
 * 
 */







//Take a string in param and a bool that indicate if the query is custom or not
/**
 * Cette fonction prend une requête SQL de type select en paramètre, ou un mot clef qui sera
 * associé à une requête prédéfinie de l'énoncé notamment
 * 
 * Le paramètre $cust indique si la requête et entièrement formulée ou alors s'il s'agit d'un mot clef
 * 
 * Les paramètres $add1 et $add2 sont optionnels et interviennent dans le cas de certaines requêtes paramétrées
 * 
 */
function getQuery($s, $cust, $add1=0, $add2=0){

    //instanciation de l'objet PDO pour intéragir avec le SGBD
    $user="root";
    $pass="";
    $database = new PDO('mysql:host=localhost;dbname=basevelo', $user, $pass);
    $req = "";

    //gère les requêtes personnalisées
    if ($cust == "custom"){
        $req = $s;
    }
    //gère les requêtes prédéfinies
    //liste des usagers
    elseif ($s == "USAGER"){
        $req = "SELECT * FROM USAGER";
    }
    //liste des emprunts
    elseif ($s == "EMPRUNT"){
        $req = "SELECT * FROM EMPRUNT";
    }
    //liste des velos
    elseif ($s == "VELO"){
        $req = "SELECT * FROM VELO";
    }
    //liste des stations
    elseif ($s == "STATION"){
        $req = "SELECT * FROM STATION";
    }
    //liste des communes
    elseif ($s == "COMMUNE"){
        $req = "SELECT * FROM COMMUNE";
    }
    //liste des distances
    elseif ($s == "DISTANCE"){
        $req = "SELECT * FROM DISTANCE";
    }
    //liste des états
    elseif ($s == "ETAT"){
        $req = "SELECT * FROM ETAT";
    }
    //liste des velos rangés par station
    elseif ($s == "VELO_STATION"){
        $req = "SELECT REFERENCE_VELO, ID_STATION, NOM_STATION, ADRESSE_STATION, COMMUNE_STATION
        FROM VELO V
        INNER JOIN STATION S ON V.STATION_ACTUELLE = S.ID_STATION
        ORDER BY ID_STATION;";
    }
    //liste des velos par station
    elseif ($s == "VELO_PAR_STATION"){
        $req = "SELECT *
        FROM VELO V
        WHERE V.STATION_ACTUELLE='$add1';";
    }
    //liste des velos en cours d'utilisation
    elseif ($s == "VELO_UTILISATION"){
        $req = "SELECT V.REFERENCE_VELO, V.KILOMETRAGE, V.NIVEAU_CHARGE, V.ETAT_VELO
        FROM VELO V
        WHERE V.STATION_ACTUELLE IS NULL;";
    }
    //liste des stations pour une commune donnée
    elseif ($s == "STATION_PAR_COMMUNE"){
        $req = "SELECT *
        FROM STATION S
        WHERE S.COMMUNE_STATION='$add1';";
    }
    // Liste des adhérents qui ont emprunté plusieurs (au moins deux) vélos différents pour un jour donné
    elseif ($s == "EMPRUNT_MEME_JOUR"){
        $req = "SELECT ID_USAGER, NOM_USAGER, PRENOM_USAGER
        from (  SELECT ID_USAGER, NOM_USAGER, PRENOM_USAGER
                FROM USAGER U
                INNER JOIN EMPRUNT E ON U.ID_USAGER = E.USAGER_CONCERNE
                WHERE E.DATE_DEBUT_EMPRUNT ='$add1'
                GROUP BY ID_USAGER, NOM_USAGER, PRENOM_USAGER, VELO_CONCERNE) T
        GROUP BY ID_USAGER, NOM_USAGER, PRENOM_USAGER
        HAVING COUNT(*) >= 2;";
    }
    // Liste des vélos avec leur état
    elseif ($s == "VELO_ETAT"){
        $req = "SELECT REFERENCE_VELO, ETAT_VELO, DESCRIPTION
        FROM VELO V
        INNER JOIN ETAT E ON V.ETAT_VELO = E.LABEL_ETAT
        ORDER BY REFERENCE_VELO ASC;";
    }    
    //Requêtes statistique 1 de l'énoncé : moyenne du nombre d’usagers par vélo par jour
    elseif ($s == "STATISTIQUE_1"){
        $req = "SELECT V.REFERENCE_VELO, COUNT(E.DATE_DEBUT_EMPRUNT)/(DATEDIFF('$add2', '$add1')+1) MOY_EMPRUNT_PAR_VELO_PAR_JOUR 
        FROM VELO V 
        JOIN EMPRUNT E ON V.REFERENCE_VELO = E.VELO_CONCERNE 
        WHERE E.DATE_DEBUT_EMPRUNT BETWEEN '$add1' AND '$add2' GROUP BY (V.REFERENCE_VELO) 
        UNION 
        SELECT V.REFERENCE_VELO, 0 MOY_EMPRUNT_PAR_VELO_PAR_JOUR 
        FROM VELO V WHERE V.REFERENCE_VELO 
        NOT IN (SELECT E.VELO_CONCERNE FROM EMPRUNT E WHERE E.DATE_DEBUT_EMPRUNT BETWEEN '$add1' and '$add2')";
    }
    //requête statistique 2 de l'énoncé : moyenne des distances parcourues par les vélos sur une semaine
    elseif ($s == "STATISTIQUE_2"){
        $req = "SELECT T.REFERENCE_VELO,  SUM(D.DISTANCE_KM)/((DATEDIFF('$add2', '$add1')+1)/7) MOY_DISTANCE_PARCOURU_PAR_VELO_PAR_SEMAINE
        FROM DISTANCE D JOIN 
        (SELECT E.STATION_DEPART S1, E.STATION_ARRIVEE S2, V.REFERENCE_VELO 
        FROM VELO V JOIN EMPRUNT E ON E.VELO_CONCERNE = V.REFERENCE_VELO 
        WHERE E.DATE_FIN_EMPRUNT BETWEEN '$add1' AND '$add2') T 
        WHERE T.S1=D.STATION_1 AND T.S2=D.STATION_2 
        GROUP BY (T.REFERENCE_VELO) 
        UNION 
        SELECT V.REFERENCE_VELO, 0 MOY_DISTANCE_PARCOURU_PAR_VELO_PAR_SEMAINE 
        FROM VELO V WHERE V.REFERENCE_VELO 
        NOT IN (SELECT E.VELO_CONCERNE FROM EMPRUNT E WHERE E.DATE_DEBUT_EMPRUNT BETWEEN '$add1' AND '$add2')";
    }
    //requête statistique 3 de l'énoncé : classement des stations par nombre de places disponibles par commune
    elseif ($s == "STATISTIQUE_3"){
        $req = "SELECT ID_STATION, NOM_STATION, (T1.CAPACITE_STATION - T2.NOMBRE) PLACES from 
        (SELECT S.ID_STATION, S.NOM_STATION, S.CAPACITE_STATION, S.COMMUNE_STATION FROM STATION S) T1 join 
        (SELECT V.STATION_ACTUELLE, COUNT(V.REFERENCE_VELO) NOMBRE FROM VELO V 
        GROUP BY V.STATION_ACTUELLE 
        UNION 
        SELECT S.ID_STATION, 0 NOMBRE FROM STATION S 
        WHERE S.ID_STATION NOT IN (SELECT V.STATION_ACTUELLE FROM VELO V)) T2 
        ON T1.ID_STATION = T2.STATION_ACTUELLE AND T1.COMMUNE_STATION=$add1 ORDER BY PLACES DESC ";
    }
    //requête statistique 4 de l'énoncé : classement des vélos les plus chargés par station
    elseif ($s == "STATISTIQUE_4"){
        $req = "SELECT V.REFERENCE_VELO, V.NIVEAU_CHARGE 
        FROM VELO V WHERE V.STATION_ACTUELLE=$add1 
        ORDER BY V.NIVEAU_CHARGE DESC";
    }
    //Si l'un des cas précédents à été rencontré i.e. $req n'est pas la chaine vide, 
    //retourne un tableau de données, et la requête associée
    if ($req != ""){
        $stats = $database->query($req);
        return [$stats->fetchAll(), $req];
    }

    //Sinon retourn un tableau vide et une chaine vide
    return [[], $req];
}

/** 
 * Cette fonction permet d'afficher les données obtenues par la fonction getQuery correctement dans l'interface 
 */
function display($arr){
    foreach ($arr[0] as $k1=>$i1){
        if (gettype($k1) == "string"){
            echo "<input size=19 value=\"$k1\" disabled>";
        }
    }
    echo "<br><br>";
    foreach ($arr as $k=>$i){
        foreach ($i as $k1=>$i1){
            if (gettype($k1) == "string"){
                echo "<input size=19 value=\"$i1\" disabled>";
            }
        }
        echo "<br>";
    }
}


/**
 * Cette fonction affiche une liste d'options a inclure dans un select pour une table donnée
 * lorsque l'on veut offrir à l'utilisateur une séléction pour remplir un champ * 
 */
function printList($t){

    $data = getQuery($t, "select");

    $list="";

    if ($t == "STATION"){     
        foreach($data[0] as $k=>$i){
            $value=$i['ID_STATION'];
            $disp=$i['NOM_STATION'];
            $list .= "<option value=$value>$value ($disp)</option>";
            }
        }
    elseif ($t == "EMPRUNT"){     
        foreach($data[0] as $k=>$i){
            $value=$i['ID_EMPRUNT'];
            $arg1=$i['DATE_DEBUT_EMPRUNT'];
            $arg2=$i['DATE_FIN_EMPRUNT'];
            $arg3=$i['STATION_DEPART'];
            $arg4=$i['STATION_ARRIVEE'];
            $arg5=$i['VELO_CONCERNE'];
            $arg6=$i['USAGER_CONCERNE'];
            $list .= "<option value=$value>$value (date début : $arg1, date fin : $arg2, station départ : $arg3, station arrivée : $arg4, velo : $arg5, usager : $arg6)</option>";
            }
        }
    elseif ($t == "USAGER"){
        foreach($data[0] as $k=>$i){
            $value=$i['ID_USAGER'];
            $arg1=$i['PRENOM_USAGER'];
            $arg2=$i['NOM_USAGER'];
            $list .= "<option value=$value>$value ($arg1 $arg2)</option>";
        }
    }
    elseif ($t == "VELO"){
        foreach($data[0] as $k=>$i){
            $value=$i['REFERENCE_VELO'];
            $arg1=$i['MARQUE_VELO'];
            $arg2=$i['STATION_ACTUELLE'];
            $list .= "<option value=$value>$value (marque : $arg1; station : $arg2)</option>";
        }
    }
    elseif ($t == "COMMUNE"){
        foreach($data[0] as $k=>$i){
            $value=$i['ID_COMMUNE'];
            $arg1=$i['NOM_COMMUNE'];
            $list .= "<option value=$value>$value ($arg1)</option>";
        }
    }
    elseif ($t == "ETAT"){
        foreach($data[0] as $k=>$i){
            $value=$i['LABEL_ETAT'];
            $arg1=$i['DESCRIPTION'];
            $list .= "<option value=$value>$value ($arg1)</option>";
        }
    }
    return $list;

}

?>