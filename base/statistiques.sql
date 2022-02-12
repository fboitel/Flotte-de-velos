-- moyenne du nombre d’usagers par vélo par jour,



-- moyenne des distances parcourues par les vélos sur une semaine,



-- classement des stations par nombre de places disponibles par commune,

select STATION_ACTUELLE, count(*) as NOMBRE
from VELO V
group by V.STATION_ACTUELLE, V.REFERENCE_VELO;



"?" -- ? est a définir par l'utilisateur 

-- classement des vélos les plus chargés par station.

select *
from VELO V
where STATION_ACTUELLE is not null
order by V.STATION_ACTUELLE, V.NIVEAU_CHARGE;
