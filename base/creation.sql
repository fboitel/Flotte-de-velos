-- ============================================================
--   Nom de la base   :  VELO                                
--   Nom de SGBD      :  MySQL Version 4.1                   
--   Date de creation :  11/11/2021  17:11                       
-- ============================================================

-- ============================================================
--   Table : ETAT                                         
-- ============================================================
create table ETAT
(
    LABEL_ETAT                      CHAR(2)              not null,
    DESCRIPTION                     CHAR(20)             not null,
    constraint pk_etat primary key (LABEL_ETAT)
);

-- ============================================================
--   Table : VELO                                            
-- ============================================================
create table VELO
(
    REFERENCE_VELO                  INT(3)              not null AUTO_INCREMENT,
    MARQUE_VELO                     CHAR(20)               not null,
    KILOMETRAGE                     INT(3)                      ,
    ETAT_VELO                       CHAR(2)                     ,
    NIVEAU_CHARGE                   INT(3)                      ,
    STATION_ACTUELLE                INT(3)                      ,
    constraint pk_velo primary key (REFERENCE_VELO)
);

-- ============================================================
--   contraintes sur les valeurs                               
-- ============================================================

alter table VELO
add constraint CK_KILOMETRAGE check (KILOMETRAGE >= 0);

alter table VELO 
add constraint CK_NIVEAU_CHARGE check (NIVEAU_CHARGE >= 0 and NIVEAU_CHARGE <= 100);

-- ============================================================
--   Index : VELO_FK1                                       
-- ============================================================
-- create index VELO_FK1 on VELO (STATION_ACTUELLE asc);

-- ============================================================
--   Table : COMMUNE                                        
-- ============================================================
create table COMMUNE
(
    ID_COMMUNE                      INT(3)              not null AUTO_INCREMENT,
    NOM_COMMUNE                     CHAR(20)               not null,
    constraint pk_commune primary key (ID_COMMUNE)
);

-- ============================================================
--   Table : STATION                                       
-- ============================================================
create table STATION
(
    ID_STATION                      INT(3)            not null AUTO_INCREMENT,
    NOM_STATION                     CHAR(20)               not null,            
    ADRESSE_STATION                 CHAR(50)               not null,
    COMMUNE_STATION                 INT(3)                      ,
    CAPACITE_STATION                INT(3)                      ,
    constraint pk_station primary key (ID_STATION)
);

-- ============================================================
--   contraintes sur les valeurs                               
-- ============================================================

alter table STATION
add constraint CK_CAPACITE_STATION check (CAPACITE_STATION >= 0);

-- ============================================================
--   Index : STATION_FK1                                       
-- ============================================================
-- create index STATION_FK1 on STATION (COMMUNE_STATION asc);

-- ============================================================
--   Table : DISTANCE                                  
-- ============================================================
create table DISTANCE
(
    STATION_1          INT(3)                not null,
    STATION_2          INT(3)                not null,
    DISTANCE_KM        INT(4)                        ,
    constraint pk_distance primary key (STATION_1, STATION_2)
);

-- ============================================================
--   contraintes sur les valeurs                               
-- ============================================================

alter table DISTANCE
add constraint CK_DISTANCE_KM check (DISTANCE_KM >= 0);

-- ============================================================
--   Index : DISTANCE_FK1                                         
-- ============================================================
-- create index DISTANCE_FK1 on DISTANCE (STATION_1 asc);

-- ============================================================
--   Index : DISTANCE_FK2                                     
-- ============================================================
-- create index DISTANCE_FK2 on DISTANCE (STATION_2 asc);


-- ============================================================
--   Table : EMPRUNT                                 
-- ============================================================
create table EMPRUNT
(
    ID_EMPRUNT                  INT(3)              not null AUTO_INCREMENT,
    DATE_DEBUT_EMPRUNT          DATE                   not null,
    DATE_FIN_EMPRUNT            DATE                           ,
    STATION_DEPART              INT(3)              not null,
    STATION_ARRIVEE             INT(3)                      ,
    VELO_CONCERNE               INT(3)              not null,
    USAGER_CONCERNE             INT(3)              not null,
    constraint pk_emprunt primary key (ID_EMPRUNT)
);

-- ============================================================
--   contraintes sur les valeurs                               
-- ============================================================

alter table EMPRUNT
add constraint CK_DATE check (!DATE_FIN_EMPRUNT or DATE_FIN_EMPRUNT >= DATE_DEBUT_EMPRUNT);

-- ============================================================
--   Index : EMPRUNT_FK1                                     
-- ============================================================
-- create index EMPRUNT_FK1 on EMPRUNT (STATION_DEPART asc);

-- ============================================================
--   Index : EMPRUNT_FK2                                   
-- ============================================================
-- create index EMPRUNT_FK2 on EMPRUNT (STATION_ARRIVEE asc);

-- ============================================================
--   Index : EMPRUNT_FK3                                     
-- ============================================================
-- create index EMPRUNT_FK3 on EMPRUNT (VELO_CONCERNE asc);

-- ============================================================
--   Index : EMPRUNT_FK4                                     
-- ============================================================
-- create index EMPRUNT_FK4 on EMPRUNT (USAGER_CONCERNE asc);

-- ============================================================
--   Table : USAGER                                             
-- ============================================================
create table USAGER
(
    ID_USAGER                     INT(3)              not null AUTO_INCREMENT,
    NOM_USAGER                    CHAR(30)               not null,
    PRENOM_USAGER                 CHAR(30)                       ,
    ADRESSE_USAGER                CHAR(50)                       ,
    COMMUNE_USAGER                INT(3)                      ,
    DATE_ADHESION                 DATE                   not null,
    constraint pk_usager primary key (ID_USAGER)
);

-- ============================================================
--   Index : USAGER_FK1                                       
-- ============================================================
-- create index USAGER_FK1 on USAGER (COMMUNE_USAGER asc);

-- ============================================================
--   contraintes de cles etrangeres                                
-- ============================================================

alter table VELO
    add constraint fk1_velo foreign key (STATION_ACTUELLE)
       references STATION (ID_STATION);

alter table VELO
    add constraint fk2_velo foreign key (ETAT_VELO)
       references ETAT (LABEL_ETAT);

alter table STATION
    add constraint fk1_station foreign key (COMMUNE_STATION)
       references COMMUNE (ID_COMMUNE);

alter table DISTANCE
    add constraint fk1_distance foreign key (STATION_1)
       references STATION (ID_STATION);

alter table DISTANCE
    add constraint fk2_distance foreign key (STATION_2)
       references STATION (ID_STATION);

alter table EMPRUNT
    add constraint fk1_emprunt foreign key (STATION_DEPART)
       references STATION (ID_STATION);

alter table EMPRUNT
    add constraint fk2_emprunt foreign key (STATION_ARRIVEE)
       references STATION (ID_STATION);

alter table EMPRUNT
    add constraint fk3_emprunt foreign key (VELO_CONCERNE)
       references VELO (REFERENCE_VELO);

alter table EMPRUNT
    add constraint fk4_emprunt foreign key (USAGER_CONCERNE)
       references USAGER (ID_USAGER);

alter table USAGER
    add constraint fk1_usager foreign key (COMMUNE_USAGER)
       references COMMUNE (ID_COMMUNE);

-- ============================================================
--   vues                              
-- ============================================================

create or replace view V_DISTANCE as 
select STATION_1, STATION_2, DISTANCE_KM
from DISTANCE
union
select STATION_2, STATION_1, DISTANCE_KM
from DISTANCE
union 
select STATION_1, STATION_1, 0
from DISTANCE
union
select STATION_2, STATION_2, 0
from DISTANCE;

-- ============================================================
--   Déclencheurs                               
-- ============================================================

-- ============================================================
--  Table EMPRUNT                             
-- ============================================================

-- ============================================================
--  create                           
-- ============================================================

-- après création d'un EMPRUNT on fait coincider la station actuelle
-- du vélo concerné avec celle d'arrivée de l'EMPRUNT 
-- (null si emprunt en cours)
delimiter //
create or replace trigger EMPRUNT_STATIONNEMENT_INSERT
after insert on EMPRUNT
for each row
    update VELO V
    set V.STATION_ACTUELLE = new.STATION_ARRIVEE
    where V.REFERENCE_VELO = new.VELO_CONCERNE;
//

-- avant création d'un EMPRUNT on vérifie que le vélo est bien à la 
-- station de départ (pas dans une autre station ou déja dans un emprunt)
create or replace trigger EMPRUNT_CHECK_STATION_DEPART
before insert on EMPRUNT
for each row
begin
	declare STATION_VELO integer; 
    select STATION_ACTUELLE into STATION_VELO
    from VELO V
    where V.REFERENCE_VELO = new.VELO_CONCERNE;

    if (STATION_VELO is null)
    then
        signal sqlstate '45000' set message_text = "Erreur : Le vélo que vous souhaitez
        emprunter est déja engagé dans un emprunt";

    else   
        if (STATION_VELO != new.STATION_DEPART)
        then
            signal sqlstate '45000' set message_text = "Erreur : La station de départ de 
            l'emprunt ne correspond pas à la station actuelle du vélo";
        end if;
	end if;
end;
//

-- après création de la station d'arrivée dans un EMPRUNT on calcul
-- le kilométrage
create or replace trigger VELO_KILOMETRAGE_INSERT
after insert on EMPRUNT
for each row 
if (new.STATION_ARRIVEE is not null) 
then
   	begin
   	declare KILOMETRES_PARCOURUS integer;

    declare STATION_D integer;

    declare STATION_A integer;

    select STATION_DEPART, STATION_ARRIVEE into STATION_D, STATION_A
    from EMPRUNT
    where ID_EMPRUNT = new.ID_EMPRUNT;

	select DISTANCE_KM into KILOMETRES_PARCOURUS
   	from V_DISTANCE D 
   	where D.STATION_1 = STATION_D and D.STATION_2 = STATION_A;

   	update VELO V
   	set V.KILOMETRAGE = V.KILOMETRAGE +  KILOMETRES_PARCOURUS
   	where V.REFERENCE_VELO = new.VELO_CONCERNE;
    end;
end if;
//

-- avant ajout d'un emprunt, on vérifie que le vélo n'est pas hors service
create or replace trigger EMPRUNT_HS
before insert on EMPRUNT
for each row
if (select ETAT_VELO
    from VELO
    where REFERENCE_VELO = new.VELO_CONCERNE) = 'C'
then
    signal sqlstate '45000' set message_text = "Erreur : Le vélo que vous voulez 
    emprunter est hors service";
end if;
//

-- avant l'ajout d'un EMPRUNT on vérifie que l'USAGER_CONCERNE n'est pas déja
-- engagé dans un autre EMPRUNT
create or replace trigger UNIQUE_EMPRUNT
before insert on EMPRUNT
for each row 
if new.USAGER_CONCERNE in (
    select USAGER_CONCERNE 
    from EMPRUNT E
    where E.STATION_ARRIVEE is null
)
then 
    signal sqlstate '45000' set message_text = "Erreur : L'USAGER est déja 
    engagé dans un EMPRUNT";
end if;delimiter //
-- create or replace trigger EMPRUNT_STATIONNEMENT_INSERT
-- after insert on EMPRUNT
-- for each row
--     update VELO V
--     set V.STATION_ACTUELLE = new.STATION_ARRIVEE
--     where V.REFERENCE_VELO = new.VELO_CONCERNE;
-- //

-- -- avant création d'un EMPRUNT on vérifie que le vélo est bien à la 
-- -- station de départ (pas dans une autre station ou déja dans un emprunt)
-- create or replace trigger EMPRUNT_CHECK_STATION_DEPART
-- before insert on EMPRUNT
-- for each row
-- begin
-- 	declare STATION_VELO integer; 
--     select STATION_ACTUELLE into STATION_VELO
--     from VELO V
--     where V.REFERENCE_VELO = new.VELO_CONCERNE;

--     if (STATION_VELO is null)
--     then
--         signal sqlstate '45000' set message_text = "Erreur : Le vélo que vous souhaitez
--         emprunter est déja engagé dans un emprunt";

--     else   
--         if (STATION_VELO != new.STATION_DEPART)
--         then
--             signal sqlstate '45000' set message_text = "Erreur : La station de départ de 
--             l'emprunt ne correspond pas à la station actuelle du vélo";
--         end if;
-- 	end if;
-- end;
-- //

-- -- après création de la station d'arrivée dans un EMPRUNT on calcul
-- -- le kilométrage
-- create or replace trigger VELO_KILOMETRAGE_INSERT
-- after insert on EMPRUNT
-- for each row 
-- if (new.STATION_ARRIVEE is not null) 
-- then
--    	begin
--    	declare KILOMETRES_PARCOURUS integer;

--     declare STATION_D integer;

--     declare STATION_A integer;

--     select STATION_DEPART, STATION_ARRIVEE into STATION_D, STATION_A
--     from EMPRUNT
--     where ID_EMPRUNT = new.ID_EMPRUNT;

-- 	select DISTANCE_KM into KILOMETRES_PARCOURUS
--    	from V_DISTANCE D 
--    	where D.STATION_1 = STATION_D and D.STATION_2 = STATION_A;

--    	update VELO V
--    	set V.KILOMETRAGE = V.KILOMETRAGE +  KILOMETRES_PARCOURUS
--    	where V.REFERENCE_VELO = new.VELO_CONCERNE;
--     end;
-- end if;
-- //

-- -- avant ajout d'un emprunt, on vérifie que le vélo n'est pas hors service
-- create or replace trigger EMPRUNT_HS
-- before insert on EMPRUNT
-- for each row
-- if (select ETAT_VELO
--     from VELO
--     where REFERENCE_VELO = new.VELO_CONCERNE) = 'C'
-- then
--     signal sqlstate '45000' set message_text = "Erreur : Le vélo que vous voulez 
--     emprunter est hors service";
-- end if;
-- //

-- -- avant l'ajout d'un EMPRUNT on vérifie que l'USAGER_CONCERNE n'est pas déja
-- -- engagé dans un autre EMPRUNT
-- create or replace trigger UNIQUE_EMPRUNT
-- before insert on EMPRUNT
-- for each row 
-- if new.USAGER_CONCERNE in (
--     select USAGER_CONCERNE 
--     from EMPRUNT E
--     where E.STATION_ARRIVEE is null
-- )
-- then 
--     signal sqlstate '45000' set message_text = "Erreur : L'USAGER est déja 
--     engagé dans un EMPRUNT";
-- end if;
-- //

-- -- ============================================================
-- --  update                           
-- -- ============================================================

-- -- après modification de la station d'arrivée dans un EMPRUNT on place
-- -- le vélo dans la station d'arrivée
-- create or replace trigger EMPRUNT_STATIONNEMENT_UPDATE
-- after update on EMPRUNT
-- for each row
-- if(new.STATION_ARRIVEE is not null and old.STATION_ARRIVEE is null)	
-- then
--     update VELO V
--     set V.STATION_ACTUELLE = new.STATION_ARRIVEE
--     where V.REFERENCE_VELO = new.VELO_CONCERNE;
-- end if;
-- //

-- -- après modification de la station d'arrivée dans un EMPRUNT on calcul
-- -- le kilométrage
-- create or replace trigger VELO_KILOMETRAGE_UPDATE
-- after update on EMPRUNT
-- for each row 
-- if (new.STATION_ARRIVEE is not null and old.STATION_ARRIVEE is null) 
-- then
--    	begin
--    	declare KILOMETRES_PARCOURUS integer;
    
--     declare STATION_D integer;

--     declare STATION_A integer;

--     select STATION_DEPART, STATION_ARRIVEE into STATION_D, STATION_A
--     from EMPRUNT
--     where ID_EMPRUNT = new.ID_EMPRUNT;

-- 	select DISTANCE_KM into KILOMETRES_PARCOURUS
--    	from V_DISTANCE D
--    	where D.STATION_1 = STATION_D and D.STATION_2 = STATION_A;

--    	update VELO V
--    	set V.KILOMETRAGE = V.KILOMETRAGE +  KILOMETRES_PARCOURUS
--    	where V.REFERENCE_VELO = new.VELO_CONCERNE;
--     end;
-- end if;
-- //

-- -- avant modification de la station d'arrivée dans un EMPRUNT on vérifie
-- -- que la date d'arrivée a bien été changé au même moment et inversement
-- create or replace trigger DATE_ET_STATION_ARRIVEE
-- before update on EMPRUNT
-- for each row
-- begin
-- if (old.STATION_ARRIVEE is null and new.STATION_ARRIVEE is not null
-- and old.DATE_FIN_EMPRUNT = new.DATE_FIN_EMPRUNT)
-- then
--     signal sqlstate '45000' set message_text = "Erreur : Si vous spécifiez la 
--     station d'arrivée d'un emprunt vous devez aussi spécifier la date de fin
--     de celui-ci";
-- end if; 
-- if (old.STATION_ARRIVEE = new.STATION_ARRIVEE
-- and old.DATE_FIN_EMPRUNT is null and new.DATE_FIN_EMPRUNT is not null)
-- then
--     signal sqlstate '45000' set message_text = "Erreur : Si vous spécifiez la 
--     date de fin d'un emprunt vous devez aussi spécifier la station d'arrivée
--     de celui-ci";
-- end if; 
-- end;
-- //


-- -- ============================================================
-- --   Table STATION                              
-- -- ============================================================

-- -- après ajout d'une STATION on place la distance entre celle-ci et les 
-- -- autres à 0 dans la table DISTANCE


-- -- ============================================================
-- --   Table DISTANCE                             
-- -- ============================================================

-- -- empecher l'ajout d'une distance si l'ordre inverse existe
-- create or replace trigger DOUBLON_DISTANCE
-- after insert on DISTANCE
-- for each row
-- if exists 
-- (select * 
-- from DISTANCE
-- where STATION_1 = new.STATION_2 and STATION_2 = new.STATION_1)
-- then
--     signal sqlstate '45000' set message_text = "Erreur : Cette distance existe déjà
--     mais l'ordre des stations est inversée";
-- end if;
-- //


-- delimiter ;

//

-- ============================================================
--  update                           
-- ============================================================

-- après modification de la station d'arrivée dans un EMPRUNT on place
-- le vélo dans la station d'arrivée
create or replace trigger EMPRUNT_STATIONNEMENT_UPDATE
after update on EMPRUNT
for each row
if(new.STATION_ARRIVEE is not null and old.STATION_ARRIVEE is null)	
then
    update VELO V
    set V.STATION_ACTUELLE = new.STATION_ARRIVEE
    where V.REFERENCE_VELO = new.VELO_CONCERNE;
end if;
//

-- après modification de la station d'arrivée dans un EMPRUNT on calcul
-- le kilométrage
create or replace trigger VELO_KILOMETRAGE_UPDATE
after update on EMPRUNT
for each row 
if (new.STATION_ARRIVEE is not null and old.STATION_ARRIVEE is null) 
then
   	begin
   	declare KILOMETRES_PARCOURUS integer;
    
    declare STATION_D integer;

    declare STATION_A integer;

    select STATION_DEPART, STATION_ARRIVEE into STATION_D, STATION_A
    from EMPRUNT
    where ID_EMPRUNT = new.ID_EMPRUNT;

	select DISTANCE_KM into KILOMETRES_PARCOURUS
   	from V_DISTANCE D
   	where D.STATION_1 = STATION_D and D.STATION_2 = STATION_A;

   	update VELO V
   	set V.KILOMETRAGE = V.KILOMETRAGE +  KILOMETRES_PARCOURUS
   	where V.REFERENCE_VELO = new.VELO_CONCERNE;
    end;
end if;
//

-- avant modification de la station d'arrivée dans un EMPRUNT on vérifie
-- que la date d'arrivée a bien été changé au même moment et inversement
create or replace trigger DATE_ET_STATION_ARRIVEE
before update on EMPRUNT
for each row
begin
if (old.STATION_ARRIVEE is null and new.STATION_ARRIVEE is not null
and old.DATE_FIN_EMPRUNT = new.DATE_FIN_EMPRUNT)
then
    signal sqlstate '45000' set message_text = "Erreur : Si vous spécifiez la 
    station d'arrivée d'un emprunt vous devez aussi spécifier la date de fin
    de celui-ci";
end if; 
if (old.STATION_ARRIVEE = new.STATION_ARRIVEE
and old.DATE_FIN_EMPRUNT is null and new.DATE_FIN_EMPRUNT is not null)
then
    signal sqlstate '45000' set message_text = "Erreur : Si vous spécifiez la 
    date de fin d'un emprunt vous devez aussi spécifier la station d'arrivée
    de celui-ci";
end if; 
end;
//


-- ============================================================
--   Table STATION                              
-- ============================================================

-- après ajout d'une STATION on place la distance entre celle-ci et les 
-- autres à 0 dans la table DISTANCE


-- ============================================================
--   Table DISTANCE                             
-- ============================================================

-- empecher l'ajout d'une distance si l'ordre inverse existe
create or replace trigger DOUBLON_DISTANCE
after insert on DISTANCE
for each row
if exists 
(select * 
from DISTANCE
where STATION_1 = new.STATION_2 and STATION_2 = new.STATION_1)
then
    signal sqlstate '45000' set message_text = "Erreur : Cette distance existe déjà
    mais l'ordre des stations est inversée";
end if;
//


delimiter ;
