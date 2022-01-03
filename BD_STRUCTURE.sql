use iglesiaprimitiva_bdprimitiva;
use bdprimitiva;
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TabTempOracion`;
CREATE TABLE `TabTempOracion` (
  `CodArea` VARCHAR(4), 
  `CodCon` VARCHAR(8), 
  `NomCon` VARCHAR(30), 
  `ApeCon` VARCHAR(40), 
  `Lunes` VARCHAR(30), 
  `Martes` VARCHAR(30), 
  `Miercoles` VARCHAR(30), 
  `Jueves` VARCHAR(30), 
  `Viernes` VARCHAR(30), 
  `Sabado` VARCHAR(30), 
  `Domingo` VARCHAR(30), 
  `NumAsi` VARCHAR(1), 
  `TotAsi` VARCHAR(1)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabActMes`;
CREATE TABLE `TabActMes` (
  `CodActMes` INTEGER NOT NULL AUTO_INCREMENT, 
  `FecAct` DATETIME, 
  `DesAct` VARCHAR(100), 
  `LugAct` VARCHAR(100), 
  `CodAct` VARCHAR(3), 
  `HorIni` DATETIME, 
  `MinTol` INTEGER, 
  `ConAsi` TINYINT(1) DEFAULT 0, 
  `PriAct` TINYINT(1) DEFAULT 0, 
  `ControlHora` DOUBLE NULL, 
  `EstReg` VARCHAR(1) DEFAULT 'V', 
  PRIMARY KEY (`CodActMes`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TabCon`;
CREATE TABLE `TabCon` (
  `CodCon` VARCHAR(8) NOT NULL, 
  `NomCon` VARCHAR(30), 
  `ApeCon` VARCHAR(40), 
  `CodFam` INTEGER DEFAULT 1, 
  `ParFam` VARCHAR(25), 
  `FecNacCon` DATETIME, 
  `SexCon` VARCHAR(9), 
  `EstCivCon` VARCHAR(15), 
  `NumCel` VARCHAR(11), 
  `TelFijo` VARCHAR(11), 
  `EmailCon` VARCHAR(60), 
  `TipCon` VARCHAR(20) DEFAULT 'RECIEN CONVERTIDO', 
  `RefCon` VARCHAR(50), 
  `DirCon` VARCHAR(80), 
  `Id_Zona` INTEGER, 
  `EstCon` VARCHAR(9) DEFAULT 'ACTIVO', 
  `CodBarras` VARCHAR(12), 
  `FecReg` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
  `FuenConv` VARCHAR(45), 
  `FecBau` DATETIME, 
  `LugBau` VARCHAR(75), 
  `MinBau` VARCHAR(75), 
  `ObsRes` VARCHAR(50), 
  `ObsCon` VARCHAR(150), 
  `FueBauIgle` TINYINT(1) DEFAULT 0, 
  `FecBaja` DATETIME, 
  `FalCons` VARCHAR(2) DEFAULT '0', 
  `MotBaja` VARCHAR(150), 
  `CheckDat` TINYINT(1) DEFAULT 0, 
  `FalConsCP` VARCHAR(2) DEFAULT '0', 
  `SoloCasPaz` TINYINT(1) DEFAULT 0, 
  `ParticipaCasaPaz` TINYINT(1) DEFAULT 1, 
  `EstaEnProceso` TINYINT(1) DEFAULT 0, 
  `DiscipuloCon` VARCHAR(10), 
  `ID_Red` VARCHAR(1) DEFAULT '0', 
  INDEX (`ID_Red`), 
  INDEX (`Id_Zona`), 
  PRIMARY KEY (`CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabRedes`;
CREATE TABLE `TabRedes` (
  `ID_RED` VARCHAR(1) NOT NULL, 
  `NOM_RED` VARCHAR(100), 
  `LID_RED` VARCHAR(8), 
  `META_RED` FLOAT NULL, 
  PRIMARY KEY (`ID_RED`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
	id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	codcon varchar(8) NOT NULL,
    email varchar(255)UNIQUE,
    email_verified_at varchar(255),
    password varchar(255),
    active tinyint(4),
    api_token VARCHAR(60) UNIQUE,
    remember_token varchar(100),
    created_at timestamp,
    updated_at timestamp
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TabGrupos`;
CREATE TABLE `TabGrupos` (
  `CodArea` VARCHAR(4) NOT NULL, 
  `CodCon` VARCHAR(8), 
  `DesArea` VARCHAR(60), 
  `EncArea` VARCHAR(150), 
  `FecInicio` DATETIME, 
  `FecFinal` DATETIME, 
  `TipGrup` VARCHAR(1), 
  `GrupoInformal` TINYINT(1) DEFAULT 0, 
  `CheckAux` TINYINT(1) DEFAULT 0, 
  PRIMARY KEY (`CodArea`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabGruposMiem`;
CREATE TABLE `TabGruposMiem` (
  `Item` INTEGER AUTO_INCREMENT, 
  `CodArea` VARCHAR(4) NOT NULL, 
  `CodCon` VARCHAR(8) NOT NULL, 
  `CarDis` VARCHAR(100) DEFAULT 'SIN CARGO', 
  `FecEnv` DATETIME, 
  `EstMim` TINYINT(1) DEFAULT 1, 
  `FecInhab` DATETIME, 
  `ObsMim` VARCHAR(150), 
  INDEX (`Item`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabCasasDePaz`;
CREATE TABLE `TabCasasDePaz` (
  `CodCasPaz` VARCHAR(6) NOT NULL, 
  `CodLid` VARCHAR(8), 
  `DirCasPaz` VARCHAR(255), 
  `FecIniCasPaz` DATETIME, 
  `DiaReuCasPaz` VARCHAR(15), 
  `DiaVisitas` VARCHAR(15), 
  `DiaEvange` VARCHAR(15), 
  `HorReuCasPaz` DATETIME, 
  `FreReuCasPaz` VARCHAR(15), 
  `TipCasPaz` VARCHAR(50), 
  `TotMimCasPaz` INTEGER, 
  `ID_Red` VARCHAR(1), 
  INDEX (`CodLid`), 
  INDEX (`ID_Red`), 
  PRIMARY KEY (`CodCasPaz`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TabMimCasPaz`;
CREATE TABLE `TabMimCasPaz` (
  `CodCasPaz` VARCHAR(6) NOT NULL, 
  `CodCon` VARCHAR(8) NOT NULL, 
  `EstAsiMim` VARCHAR(1), 
  PRIMARY KEY (`CodCasPaz`, `CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabAsi`;
CREATE TABLE `TabAsi` (
  `CodAsi` VARCHAR(12) NOT NULL, 
  `FecAsi` DATETIME, 
  `TipAsi` VARCHAR(30), 
  `CodAct` VARCHAR(3), 
  `HorDesde` DATETIME, 
  `HorHasta` DATETIME, 
  `TotFaltas` INTEGER, 
  `TotAsistencia` INTEGER, 
  `TotPermisos` INTEGER, 
  PRIMARY KEY (`CodAsi`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabDetAsi`;
CREATE TABLE `TabDetAsi` (
  `CodAsi` VARCHAR(12) NOT NULL, 
  `CodCon` VARCHAR(8) NOT NULL, 
  `NomApeCon` VARCHAR(150), 
  `HorLlegAsi` DATETIME, 
  `EstAsi` VARCHAR(1) DEFAULT 'F', 
  `Asistio` TINYINT(1) DEFAULT 0, 
  `Motivo` VARCHAR(100), 
  PRIMARY KEY (`CodAsi`, `CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS activities;
CREATE TABLE activities
(
	id int AUTO_INCREMENT,
    activity varchar(255),    
    description text,
    created_at timestamp,
    updated_at timestamp,    
    PRIMARY KEY(id)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS manage;
CREATE TABLE manage
(
	id int AUTO_INCREMENT,
    activity_id int,
    month int,
    year int,
    created_at timestamp,
    updated_at timestamp,    
    PRIMARY KEY(id)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS manage_details;
CREATE TABLE manage_details
(
	id int AUTO_INCREMENT,
    manage_id int,
    codcon varchar(8),
    nomapecon varchar(150),
    week1 date,
    amount1 decimal(5,2),
    week2 date,
    amount2 decimal(5,2),
    week3 date,
    amount3 decimal(5,2),
    week4 date,
    amount4 decimal(5,2),
    created_at timestamp,
    updated_at timestamp,
    PRIMARY KEY(id)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tabasidiscipulados;
CREATE TABLE tabasidiscipulados
(
	codasi VARCHAR(12) NOT NULL,
    codarea VARCHAR(4) NOT NULL,
    fecasi DATETIME,
    tema VARCHAR(255),
    ofrenda DECIMAL(5,2),
    testimonios text,
    observaciones text,
    totfaltas INTEGER,
    totasistencia INTEGER,
    mes INTEGER,
    anio INTEGER,
    activo TINYINT(1) DEFAULT 1,
    PRIMARY KEY(codasi)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS tabdetasidiscipulados;
CREATE TABLE tabdetasidiscipulados (
  codasi VARCHAR(12) NOT NULL, 
  codcon VARCHAR(8) NOT NULL, 
  nomapecon VARCHAR(150), 
  estasi VARCHAR(1) DEFAULT 'F', 
  asistio TINYINT(1) DEFAULT 0, 
  motivo VARCHAR(100), 
  PRIMARY KEY (`codasi`, `codcon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS FaltasCultoCP;
CREATE TABLE FaltasCultoCP (
  Codcaspaz VARCHAR(6), 
  Codlid VARCHAR(8), 
  Nombreslid VARCHAR(150), 
  Codcon VARCHAR(8), 
  Nombrescomp VARCHAR(150)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS FaltasCultoDS;
CREATE TABLE FaltasCultoDS (
  Codarea VARCHAR(4), 
  Codcon VARCHAR(8), 
  Desarea VARCHAR(60), 
  Nombrescomp VARCHAR(150),
  Cargo VARCHAR(100),
  Motivo VARCHAR(255)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS TabActividades;
CREATE TABLE TabActividades(
	CodAct VARCHAR(3) NOT NULL,
    FecReg DATETIME,
    TipAct VARCHAR(30),
    LugAct VARCHAR(90),
    Tipo VARCHAR(2),
    DiaActOtro VARCHAR(7),
    DiaMes VARCHAR(2),
    DiaSem VARCHAR(1),
    FecIni DATETIME,
    FecFin DATETIME,
    HorEnt TIME,
    MinTol INT,
    ConAsi BOOLEAN,    
    PriAct BOOLEAN,
    PRIMARY KEY(CodAct)
);

DROP TABLE IF EXISTS TabDocumentos;
CREATE TABLE TabDocumentos (
	NumReg VARCHAR(12) NOT NULL,
    FecReg DATE,
    CodCon VARCHAR(8),
    FecIniReg DATE,
    FecFinReg DATE,
    PerCon BOOLEAN,
    Motivo VARCHAR(255),
    Estado BOOLEAN,
    PRIMARY KEY(NumReg)
);

DROP TABLE IF EXISTS TabDetDocumentos;
CREATE TABLE TabDetDocumentos (
	NumReg VARCHAR(12) NOT NULL,
    CodAct VARCHAR(3)
);

DROP TABLE IF EXISTS TabInfCaspaz;
CREATE TABLE TabInfCasPaz (
	NumInf int(10) unsigned NOT NULL AUTO_INCREMENT,
    CodCasPaz VARCHAR(8),
    FecInf DATETIME,
    NumSem INTEGER,
    Anio INTEGER,
    ReuSiNo TINYINT(1),
    TotAsiReu INTEGER,
    TotAusReu INTEGER,
    OfreReu DECIMAL(5,2),
    TemSem VARCHAR(255),
    Enviado TINYINT(1) DEFAULT 1,
    PRIMARY KEY(NumInf)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS TabDetInfCas;
CREATE TABLE TabDetInfCas (
	NumInf int(10) unsigned NOT NULL AUTO_INCREMENT,
    CodCon VARCHAR(8) NOT NULL, 
    NomCon VARCHAR(150),
    ApeCon VARCHAR(150),
    TipCon VARCHAR(150),
    EstAsi VARCHAR(1) DEFAULT 'F', 
    AsiReu TINYINT(1) DEFAULT 0,    
    PRIMARY KEY (`NumInf`, `CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS miembros_observados;
CREATE TABLE miembros_observados(
	id int AUTO_INCREMENT,
	CodCon VARCHAR(8) NOT NULL,
    Estado VARCHAR(15) NOT NULL,
    Observacion VARCHAR(255),
    FecReg DATETIME,
	PRIMARY KEY(id)
) ENGINE=innodb DEFAULT CHARSET=utf8;

## FOREIGN KEY ##
ALTER TABLE users
ADD FOREIGN KEY (codcon) REFERENCES TabCon(CodCon);

ALTER TABLE TabGrupos
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon); 

ALTER TABLE TabGruposMiem
ADD FOREIGN KEY (CodArea) REFERENCES TabGrupos(CodArea);

ALTER TABLE TabGruposMiem
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon);

ALTER TABLE model_has_permissions
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE model_has_roles 
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions 
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
  
ALTER TABLE TabRedes
ADD FOREIGN KEY (LID_RED) REFERENCES TabCon(CodCon);

-- ALTER TABLE `TabAsi` ADD INDEX `CodAsi_index` (`CodAsi`);

ALTER TABLE TabDetAsi
ADD FOREIGN KEY (CodAsi) REFERENCES TabAsi(CodAsi);

ALTER TABLE TabMimCasPaz
ADD CONSTRAINT fk_CasasDePaz_CodCasPaz FOREIGN KEY (CodCasPaz) REFERENCES TabCasasDePaz(CodCasPaz);

ALTER TABLE TabDetAsi
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon);

ALTER TABLE TabMimCasPaz
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon); 

ALTER TABLE TabCasasDePaz
ADD CONSTRAINT fk_TabCon_CodCon FOREIGN KEY (CodLid) REFERENCES TabCon(CodCon); 

ALTER TABLE manage
ADD FOREIGN KEY (activity_id) REFERENCES activities(id); 

ALTER TABLE manage_details
ADD FOREIGN KEY (manage_id) REFERENCES manage(id); 

ALTER TABLE tabdetasidiscipulados
ADD FOREIGN KEY (codasi) REFERENCES tabasidiscipulados(codasi);

ALTER TABLE tabdetasidiscipulados
ADD FOREIGN KEY (codcon) REFERENCES TabCon(codcon);

ALTER TABLE TabDetDocumentos
ADD FOREIGN KEY(NumReg) REFERENCES TabDocumentos(NumReg);

ALTER TABLE TabDetDocumentos
ADD FOREIGN KEY(CodAct) REFERENCES TabActividades(CodAct);

ALTER TABLE TabDetInfCas
ADD FOREIGN KEY(NumInf) REFERENCES TabInfCasPaz(NumInf);

ALTER TABLE TabDetInfCas
ADD FOREIGN KEY(CodCon) REFERENCES TabCon(codcon);

ALTER TABLE miembros_observados
ADD FOREIGN KEY(CodCon) REFERENCES TabCon(codcon);

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABCON
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'TabCon';
    
ALTER TABLE users  DROP FOREIGN KEY users_ibfk_1;
ALTER TABLE TabCasasDePaz DROP FOREIGN KEY fk_TabCon_CodCon;
ALTER TABLE TabMimCasPaz DROP FOREIGN KEY TabMimCasPaz_ibfk_1;
ALTER TABLE TabGrupos DROP FOREIGN KEY TabGrupos_ibfk_1;
ALTER TABLE TabDetAsi DROP FOREIGN KEY TabDetAsi_ibfk_2;
ALTER TABLE TabRedes DROP FOREIGN KEY TabRedes_ibfk_1;
ALTER TABLE TabGruposMiem DROP FOREIGN KEY TabGruposMiem_ibfk_2;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABGRUPOS
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'TabGrupos';
    
ALTER TABLE TabGruposMiem  DROP FOREIGN KEY TabGruposMiem_ibfk_1;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABASI
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'TabAsi';
    
ALTER TABLE TabDetAsi  DROP FOREIGN KEY TabDetAsi_ibfk_1;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABROLES
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'roles';
    
ALTER TABLE model_has_roles  DROP FOREIGN KEY model_has_roles_ibfk_2;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABMIMCASPAZ
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'TabMimCasPaz';
    
ALTER TABLE tabcasasdepaz DROP FOREIGN KEY fk_TabMimCasPaz_CodCasPaz;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE PERMISSIONS
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'permissions';
    
ALTER TABLE model_has_permissions  DROP FOREIGN KEY model_has_permissions_ibfk_1;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS

## CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS DE TABCASASDEPAZ
SELECT
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE
	REFERENCED_TABLE_SCHEMA = 'iglesiaprimitiva_bdprimitiva'
    AND REFERENCED_TABLE_NAME = 'tabcasasdepaz';
    
ALTER TABLE TabMimCasPaz  DROP FOREIGN KEY fk_TabMimCasPaz;
## FIN DE CÓDIGO PARA ELIMINAR CLAVES FORÁNEAS