-- ============================================================
--    suppression des donnees
-- ============================================================

delete from ETAT ;
delete from VELO ;
delete from STATION ;
delete from DISTANCE ;
delete from EMPRUNT ;
delete from USAGER ;

commit ;

-- ============================================================
--    creation des donnees
-- ============================================================

-- ETAT

insert into ETAT values ('N' ,     'NEUF') ;
insert into ETAT values ('TB' ,     'TRÈS BON ÉTÂT') ;
insert into ETAT values ('B' ,     'BON ÉTÂT') ;
insert into ETAT values ('U' ,     'USÉ') ;
insert into ETAT values ('TU' ,     'TRÈS USÉ') ;
insert into ETAT values ('C' ,     'CASSÉ') ;

commit ;

-- COMMUNE

insert into COMMUNE values (null ,     'BORDEAUX') ;
insert into COMMUNE values (null ,     'TALENCE') ;
insert into COMMUNE values (null ,     'PESSAC') ;
insert into COMMUNE values (null ,     'MERIGNAC') ;

commit ;

-- STATION

insert into STATION values (null ,   'MOZART' ,     '4 AVENUE DE LA PORTE' ,        3 ,     5) ;
insert into STATION values (null ,   'BEETHOVEN' ,   '8 RUE DU BUFFET' ,             2 ,     2) ;
insert into STATION values (null ,   'RAVEL' ,      '7 RUE DU PLACARD' ,            1 ,     3) ;
insert into STATION values (null ,   'RACHMANINOV' ,'18 AVENUE DE LA COMMODE' ,     3 ,     7) ;

commit ;

-- VELO

insert into VELO values (null ,    'BTWIN' ,       50 ,    'TB',    80 ,     1) ;
insert into VELO values (null ,    'PINARELLO' ,   80 ,    'U',    20 ,     1) ;
insert into VELO values (null ,    'RIDLEY' ,      54 ,    'TB',    30 ,     4) ;
insert into VELO values (null ,    'RIDLEY' ,      3 ,     'U',    45 ,     2) ;
insert into VELO values (null ,    'BTWIN' ,       0 ,     'N',    100 ,    4) ;
insert into VELO values (null ,    'PINARELLO' ,   130 ,   'TU',    80 ,     3) ;
insert into VELO values (null ,    'PINARELLO' ,   87 ,   'B',    64 ,     NULL) ;

commit ;

-- DISTANCE

insert into DISTANCE values (1 ,    2 ,     50) ;
insert into DISTANCE values (1 ,    3 ,     69) ;
insert into DISTANCE values (1 ,    4 ,     78) ;
insert into DISTANCE values (2 ,    3 ,     53) ;
insert into DISTANCE values (2 ,    4 ,     75) ;
insert into DISTANCE values (3 ,    4 ,     42) ;

commit ;

-- USAGER

insert into USAGER values (null ,      'SEBASTIEN' ,       'PATRICK' ,     '7 IMPASSE DE LA SARDINE' ,                 3,      '2021-06-20') ;
insert into USAGER values (null ,      'CHEDID' ,          'MATHIEU' ,     '8 RUE DE LA BONNE ETOILE' ,                2,      '2021-06-30') ;
insert into USAGER values (null ,      'CABREL' ,          'FRANCIS' ,     '19 AVENUE DE LA CABANE DU PECHEUR' ,       1,      '2021-07-12') ;
insert into USAGER values (null ,      'PARADIS' ,         'VANESSA' ,     '1 RUE DE LA SEINE' ,                       4,      '2021-08-15') ;
insert into USAGER values (null ,      'MICHEL' ,          'THEO'    ,     '18 PLACE DES BEGE' ,                       4,      '2021-12-01') ;
insert into USAGER values (null ,      'DA SILVA' ,        'ALOÏS' ,       '1 RUE DU SWAG' ,                           4,      '2021-12-01') ;
insert into USAGER values (null ,      'GODO' ,            'GODO' ,        '420 RUE DU TALENT' ,                       4,      '2021-12-02') ;

commit ;

-- EMPRUNT

insert into EMPRUNT values (null ,     '2021-01-30' ,     '2021-01-30',      1 ,     2 ,     1 ,     1) ;
insert into EMPRUNT values (null ,     '2021-01-19' ,     '2021-01-19',      4 ,     1 ,     3 ,     4) ;
insert into EMPRUNT values (null ,     '2021-03-22' ,     '2021-03-22',      2 ,     4 ,     4 ,     1) ;
insert into EMPRUNT values (null ,     '2021-04-04' ,     '2021-04-04',      1 ,     3 ,     2 ,     2) ;
insert into EMPRUNT values (null ,     '2021-04-04' ,     '2021-04-04',      2 ,     3 ,     1 ,     2) ;
insert into EMPRUNT values (null ,     '2021-04-06' ,     '2021-04-06',      1 ,     3 ,     3 ,     3) ;

commit ;


-- ============================================================
--    verification des donnees
-- ============================================================

select count(*),'= 7 ?','ETAT' from ETAT 
union
select count(*),'= 6 ?','VELO' from VELO 
union
select count(*),'= 4 ?','COMMUNE' from COMMUNE 
union
select count(*),'= 4 ?','STATION' from STATION 
union
select count(*),'= 6 ?','DISTANCE' from DISTANCE 
union
select count(*),'= 6 ?','EMPRUNT' from EMPRUNT 
union
select count(*),'= 7 ?','USAGER' from USAGER ;