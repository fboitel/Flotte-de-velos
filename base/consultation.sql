-- ============================================================
--   consultation                                            
-- ============================================================

-- Informations sur les vélos, les stations, les adhérents.

select * 
from VELO;

select *
from STATION;

select *
from USAGER;

-- Liste des vélos rangé par station, 

select REFERENCE_VELO, ID_STATION, ADRESSE_STATION, COMMUNE_STATION
from VELO V
inner join STATION S on V.STATION_ACTUELLE = S.ID_STATION
order by ID_STATION;

-- Liste des vélos par station,

select *
from VELO V
where V.STATION_ACTUELLE = "?"; -- à faire en PHP

-- la liste des vélos en cours d’utilisation.

select V.REFERENCE_VELO, V.KILOMETRAGE, V.NIVEAU_CHARGE, V.ETAT_VELO
from VELO V
where V.STATION_ACTUELLE is null;

-- Liste des stations dans une commune donnée

select *
from STATION S
where S.COMMUNE_STATION = "?"; -- ? est a définir par l'utilisateur

-- Liste des adhérents qui ont emprunté plusieurs (au moins deux) vélos 
-- différents pour un jour donné

select ID_USAGER, NOM_USAGER, PRENOM_USAGER
from (  select ID_USAGER, NOM_USAGER, PRENOM_USAGER
        from USAGER U
        inner join EMPRUNT E on U.ID_USAGER = E.USAGER_CONCERNE
        where E.DATE_DEBUT_EMPRUNT ="0000-00-00"
        group by ID_USAGER, NOM_USAGER, PRENOM_USAGER, VELO_CONCERNE)
group by ID_USAGER, NOM_USAGER, PRENOM_USAGER
having count(*) = 2;


-- ============================================================
--   mise à jour                                           
-- ============================================================