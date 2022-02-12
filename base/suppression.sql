-- ============================================================
--   Suppression des tables                             
-- ============================================================

-- drop index ETAT_PK;

drop table ETAT cascade constraints;

-- drop index VELO_PK;

drop table VELO cascade constraints;

-- drop index VELO_FK1;

-- drop index VELO_FK2;

-- drop index COMMUNE_PK;

drop table COMMUNE cascade constraints;

-- drop index STATION_PK;

drop table STATION cascade constraints;

-- drop index STATION_FK1

-- drop index DISTANCE_PK;

drop table DISTANCE cascade constraints;

-- drop index DISTANCE_FK1;

-- drop index DISTANCE_FK2;

-- drop index EMPRUNT_PK;

drop table EMPRUNT cascade constraints;

-- drop index EMPRUNT_FK1;

-- drop index EMPRUNT_FK2;

-- drop index EMPRUNT_FK3;

-- drop index EMPRUNT_FK4;

-- drop index USAGER_PK;

drop table USAGER cascade constraints;

-- drop index USAGER_FK1

-- ============================================================
--   Suppression des vues                               
-- ============================================================

drop view V_DISTANCE;

-- ============================================================
--   Suppression des déclencheurs                               
-- ============================================================

-- EMPRUNT
drop trigger EMPRUNT_STATIONNEMENT_INSERT;

drop trigger EMPRUNT_STATIONNEMENT_UPDATE;

drop trigger EMPRUNT_CHECK_STATION_DEPART;

drop trigger VELO_KILOMETRAGE_INSERT;

drop trigger VELO_KILOMETRAGE_UPDATE;

drop trigger DATE_ET_STATION_ARRIVEE;

drop trigger DATE_FIN_POSTERIEURE_DEBUT_UPDATE;

drop trigger DATE_FIN_POSTERIEURE_DEBUT_INSERT;

drop trigger EMPRUNT_HS;

drop trigger UNIQUE_EMPRUNT;

-- STATION
-- drop trigger INITIALIZE_DISTANCE;

-- DISTANCE
drop trigger DOUBLON_DISTANCE;



