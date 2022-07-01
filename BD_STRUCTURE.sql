use bdprimitiva;

-- -------------------- TABLAS EXCLUSIVAS DEL SISTEMA WEB PARA PARA PERMISOS Y ROLES ------------------------------------------------------

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

-- -------------------- TABLAS EXCLUSIVAS DEL SISTEMA WEB PARA PARA PERMISOS Y ROLES ------------------------------------------------------



-- -------------------- TABLAS PARA LAS ESCUELAS ANTIGUAS --------------------------------------------------------------------------------


DROP TABLE IF EXISTS `TabCursos`;
CREATE TABLE `TabCursos` (
  `CodCur` INTEGER NOT NULL AUTO_INCREMENT, 
  `DesCur` VARCHAR(50), 
  `CurObli` TINYINT(1) DEFAULT 0, 
  `RelPas` VARCHAR(2), 
  `OrdCur` VARCHAR(2) DEFAULT '99', 
  `NumTem` INTEGER, 
  PRIMARY KEY (`CodCur`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabEscuelas`;
CREATE TABLE `TabEscuelas` (
  `NumDis` VARCHAR(12) NOT NULL, 
  `CodCur` INTEGER, 
  `CodMen` VARCHAR(8), 
  `FecIniDis` DATETIME, 
  `FecFinDis` DATETIME, 
  `HorDis` DATETIME, 
  `DiaDis` INTEGER, 
  `FreDis` INTEGER, 
  `NumCla` INTEGER, 
  `DisTer` TINYINT(1) DEFAULT 0,
  PRIMARY KEY (`NumDis`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabTemasDis`;
CREATE TABLE `TabTemasDis` (
  `NumDis` VARCHAR(12) NOT NULL, 
  `NumTem` VARCHAR(2) NOT NULL, 
  `NomTem` VARCHAR(150), 
  `TotAsi` INTEGER DEFAULT 0, 
  `FecTem` DATETIME, 
  `TemDictado` TINYINT(1) DEFAULT 0, 
  `ObsTem` VARCHAR(150), 
  PRIMARY KEY (`NumDis`, `NumTem`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabTemaDisAsistencia`;
CREATE TABLE `TabTemaDisAsistencia` (
  `NumDis` VARCHAR(12) NOT NULL, 
  `Numtem` VARCHAR(2) NOT NULL, 
  `CodCon` VARCHAR(8), 
  `Asistio` TINYINT(1) DEFAULT 0, 
  `ObsAsi` VARCHAR(150)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

-- -------------------- FIN TABLAS PARA LAS ESCUELAS ANTIGUAS --------------------------------------------------------------------------------


-- -------------------- TABLAS PARA CASAS DE PAZ --------------------------------------------------------------------------------

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

DROP TABLE IF EXISTS `TabRedes`;
CREATE TABLE `TabRedes` (
  `ID_RED` VARCHAR(1) NOT NULL, 
  `NOM_RED` VARCHAR(100), 
  `LID_RED` VARCHAR(8), 
  `META_RED` FLOAT NULL, 
  PRIMARY KEY (`ID_RED`)
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `TabMentores`;
CREATE TABLE `TabMentores` (
  `CodMen` VARCHAR(8) NOT NULL, 
  `ID_RED` VARCHAR(1), 
  `Cargo` VARCHAR(50), 
  `FecReg` DATETIME, 
  `FecEnvio` DATETIME, 
  `Estado` VARCHAR(1) DEFAULT 'A',
  PRIMARY KEY (`CodMen`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;


-- -------------------- FIN TABLAS PARA CASAS DE PAZ --------------------------------------------------------------------------------


-- --------------- TABLAS DE INFORMES DE CASAS DE PAZ --------------- 

DROP TABLE IF EXISTS `TabInfCasPaz`;
CREATE TABLE `TabInfCasPaz` (
  `NumInf` INTEGER NOT NULL AUTO_INCREMENT, 
  `CodCasPaz` VARCHAR(6), 
  `FecInf` DATETIME, 
  `NumSem` INTEGER, 
  `ReuSiNo` VARCHAR(2), 
  `EntSiNo` VARCHAR(2), 
  `TotAsiReu` INTEGER, 
  `TotAusReu` INTEGER, 
  `OfreReu` DOUBLE NULL, 
  `EvanCasPaz` VARCHAR(2), 
  `MotNoEvan` VARCHAR(30), 
  `ConvEvan` INTEGER, 
  `ConvReu` INTEGER, 
  `TotConv` INTEGER, 
  `HogMiemVis` INTEGER, 
  `HogNueVis` INTEGER, 
  `TemaSem` VARCHAR(150), 
  `ApeReunion` TINYINT(1) DEFAULT 0, 
  `CulJueMiem` INTEGER, 
  `CulJueVis` INTEGER, 
  `CulJueNue` INTEGER, 
  `CulSabMiem` INTEGER, 
  `CulSabVis` INTEGER, 
  `CulSabNue` INTEGER, 
  `CulDomMiem` INTEGER, 
  `CulDomVis` INTEGER, 
  `CulDomNue` INTEGER, 
  `InfReco` LONGTEXT, 
  `ProAsi` TINYINT(1) DEFAULT 0,
  PRIMARY KEY(NumInf)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabDetInfCas`;
CREATE TABLE `TabDetInfCas` (
  `NumInf` INTEGER, 
  `CodCon` VARCHAR(8), 
  `NomCon` VARCHAR(70), 
  `ApeCon` VARCHAR(70), 
  `TipCon` VARCHAR(30), 
  `AsiReu` VARCHAR(2) DEFAULT 'NO', 
  `VisTraidas` INTEGER, 
  `CulJue` VARCHAR(2), 
  `ObsJue` VARCHAR(100), 
  `CulSab` VARCHAR(2), 
  `ObsSab` VARCHAR(100), 
  `CulDom` VARCHAR(2), 
  `ObsDom` VARCHAR(100)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

-- --------------- FIN TABLAS DE INFORMES DE CASAS DE PAZ --------------- 


-- --------------- TABLAS DE ASISTENCIAS, ACTIVIDADES Y PERMISOS--------------- 

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
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS TabDetDocumentos;
CREATE TABLE TabDetDocumentos (
	NumReg VARCHAR(12) NOT NULL,
    CodAct VARCHAR(3)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS TabDocumentos;
CREATE TABLE TabDocumentos (
	NumReg VARCHAR(12) NOT NULL,
    FecReg DATE,
    CodCon VARCHAR(8) NOT NULL,
    FecIniReg DATE,
    FecFinReg DATE,
    PerCon BOOLEAN,
    Motivo VARCHAR(255),
    Estado BOOLEAN,
    PRIMARY KEY(NumReg)
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

-- --------------- TABLAS DE ASISTENCIAS, ACTIVIDADES Y PERMISOS--------------- 

-- --------------- TABLAS DE GRUPOS Y MIEMBROS --------------- 

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

-- --------------- FIN TABLAS DE GRUPOS Y MIEMBROS --------------- 

-- --------------- TABLAS DE ESCUELAS NUEVAS --------------- 

DROP TABLE IF EXISTS `TabEtapaVision`;
CREATE TABLE `TabEtapaVision` (
  `CodEtapa` VARCHAR(6) NOT NULL, 
  `DesEtapa` VARCHAR(100), 
  PRIMARY KEY (`CodEtapa`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabSubEtapas`;
CREATE TABLE `TabSubEtapas` (
  `CODSUBETP` VARCHAR(6) NOT NULL, 
  `CODEtapa` VARCHAR(6), 
  `DESSUBETP` VARCHAR(100), 
  `REQSUBETP` TINYINT(1) DEFAULT 0, 
  `CODSUBRQT` VARCHAR(6), 
  `ORDEN` INTEGER, 
  `NUMTEMAS` FLOAT NULL, 
  PRIMARY KEY (`CODSUBETP`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabTemasEscuela`;
CREATE TABLE `TabTemasEscuela` (
  `CODTEM` VARCHAR(6) NOT NULL, 
  `ORDEN` FLOAT NULL, 
  `CODSUBETP` VARCHAR(6), 
  `DESTEM` VARCHAR(100), 
  PRIMARY KEY (`CODTEM`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabRegEscuelasCab`;
CREATE TABLE `TabRegEscuelasCab` (
  `NUMREG` VARCHAR(12) NOT NULL, 
  `CODSUBETP` VARCHAR(6), 
  `CODCON` VARCHAR(8), 
  `NUMTEMAS` FLOAT NULL, 
  `ESTSUBETP` TINYINT(1) DEFAULT 0, 
  `FECCPLTO` DATETIME, 
  `OBSSUBETP` VARCHAR(150), 
  PRIMARY KEY (`NUMREG`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabRegEscuelasDet`;
CREATE TABLE `TabRegEscuelasDet` (
  `NUMREG` VARCHAR(12), 
  `CODTEM` VARCHAR(6), 
  `NUMTEM` VARCHAR(2), 
  `DESTEM` VARCHAR(100), 
  `FECASI` DATETIME, 
  `ASISTIO` TINYINT(1) DEFAULT 0
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

-- --------------- FIN TABLAS DE ESCUELAS NUEVAS --------------- 


-- --------------- TABLAS DE LUGARES--------------- 

DROP TABLE IF EXISTS `TabDepPeru`;
CREATE TABLE `TabDepPeru` (
  `Id_Dep` INTEGER NOT NULL AUTO_INCREMENT, 
  `NomDep` VARCHAR(70), 
  PRIMARY KEY (`Id_Dep`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabProPeru`;
CREATE TABLE `TabProPeru` (
  `Id_Pro` INTEGER NOT NULL AUTO_INCREMENT, 
  `Id_Dep` INTEGER, 
  `NomProv` VARCHAR(70),
  PRIMARY KEY (`Id_Pro`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabDisPeru`;
CREATE TABLE `TabDisPeru` (
  `Id_Dis` INTEGER NOT NULL AUTO_INCREMENT, 
  `Id_Pro` INTEGER, 
  `NomDis` VARCHAR(50), 
  INDEX (`Id_Dis`), 
  PRIMARY KEY (`Id_Dis`), 
  INDEX (`Id_Pro`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabLocalidad`;
CREATE TABLE `TabLocalidad` (
  `Id_Localidad` INTEGER NOT NULL AUTO_INCREMENT, 
  `Id_Dis` INTEGER, 
  `NomLoc` VARCHAR(75), 
  INDEX (`Id_Dis`), 
  INDEX (`Id_Localidad`), 
  PRIMARY KEY (`Id_Localidad`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabZonas`;
CREATE TABLE `TabZonas` (
  `Id_Zona` INTEGER NOT NULL AUTO_INCREMENT, 
  `Id_Localidad` INTEGER, 
  `Nom_Zona` VARCHAR(150), 
  INDEX (`Id_Zona`), 
  INDEX (`Id_Localidad`), 
  PRIMARY KEY (`Id_Zona`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

-- --------------- FIN TABLAS DE LUGARES--------------- 


-- --------------- TABLAS DE FAMILIAS --------------- 

DROP TABLE IF EXISTS `TabFamilias`;
CREATE TABLE `TabFamilias` (
  `CodFam` INTEGER NOT NULL AUTO_INCREMENT, 
  `NomFam` VARCHAR(150), 
  `DirFam` VARCHAR(80), 
  `TelFam` VARCHAR(25), 
  PRIMARY KEY (`CodFam`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

-- --------------- FIN TABLAS DE FAMILIAS --------------- 


-- --------------- TABLAS DE USUARIO SISTEMA ANTIGUO --------------- 

DROP TABLE IF EXISTS TabPermisosUsu;
CREATE TABLE TabPermisosUsu (
  CodUsu VARCHAR(3) NOT NULL, 
  IDMenu VARCHAR(2), 
  EstMenu TINYINT(1) DEFAULT 0
) ENGINE=innodb DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS TabUsuarios;
CREATE TABLE TabUsuarios (
  CodUsu VARCHAR(3) NOT NULL, 
  NomApeUsu VARCHAR(150), 
  NomUsu VARCHAR(70), 
  ClaveUsu VARCHAR(10), 
  SkinUsu VARCHAR(30), 
  PerEliReg TINYINT(1) DEFAULT 0, 
  SoloRed TINYINT(1) DEFAULT 0, 
  Id_Red VARCHAR(1),
  PRIMARY KEY(CodUsu)
) ENGINE=innodb DEFAULT CHARSET=utf8;

-- --------------- FIN TABLAS DE USUARIO SISTEMA ANTIGUO --------------- 

-- --------------- TABLAS DE HISTORIAL DE VISITAS --------------- 

DROP TABLE IF EXISTS TabHistorialVis;
CREATE TABLE TabHistorialVis (
  CodAsi VARCHAR(12), 
  CodCon VARCHAR(8), 
  FecReg DATETIME, 
  Motivo VARCHAR(30), 
  Reporte VARCHAR(150)
) ENGINE=innodb DEFAULT CHARSET=utf8;

-- --------------- FIN TABLAS DE HISTORIAL DE VISITAS --------------- 

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
  `CodBarras` VARCHAR(6), 
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
  `ParticipaCasaPaz` TINYINT(1) DEFAULT 0, 
  `EstaEnProceso` TINYINT(1) DEFAULT 0, 
  `DiscipuloCon` VARCHAR(10), 
  `ID_Red` VARCHAR(1) DEFAULT '0', 
  `TipoAsi` VARCHAR(12) DEFAULT 'NORMAL',
  INDEX (`ID_Red`), 
  INDEX (`Id_Zona`), 
  PRIMARY KEY (`CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

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

DROP TABLE IF EXISTS miembros_observados;
CREATE TABLE miembros_observados(
	id int AUTO_INCREMENT,
	CodCon VARCHAR(8) NOT NULL,
    Estado VARCHAR(15) NOT NULL,
    Observacion VARCHAR(255),
    FecReg DATETIME,
	PRIMARY KEY(id)
) ENGINE=innodb DEFAULT CHARSET=utf8;

-- TABLAS SIN RELACIONES

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

DROP TABLE IF EXISTS `TabDatosIglesia`;
CREATE TABLE `TabDatosIglesia` (
  `CodIgle` VARCHAR(3) NOT NULL, 
  `NomIgle` VARCHAR(255), 
  `DirIgle` VARCHAR(255), 
  `TelIgle` VARCHAR(15), 
  `SkinIgle` VARCHAR(100), 
  PRIMARY KEY (`CodIgle`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabTempMiemBajas`;
CREATE TABLE `TabTempMiemBajas` (
  `CodCon` VARCHAR(8) NOT NULL, 
  `Nombres` VARCHAR(150), 
  `Referencia` VARCHAR(70), 
  `CP` TINYINT(1) DEFAULT 0, 
  `EstaEnProceso` TINYINT(1) DEFAULT 0, 
  `Direccion` VARCHAR(100), 
  `UltDiaAsis` DATETIME, 
  `FechUlt` DATETIME, 
  `FaltCon` INTEGER, 
  `FalCasPaz` INTEGER, 
  `Eliminar` TINYINT(1) DEFAULT 0, 
  `ReporteVis` VARCHAR(150), 
  PRIMARY KEY (`CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabCasasMov`;
CREATE TABLE `TabCasasMov` (
  `CodCasPaz` VARCHAR(6), 
  `NumMov` INTEGER, 
  `FecMov` DATETIME, 
  `DetMov` VARCHAR(70), 
  `CodCon` VARCHAR(8), 
  `IngMiem` INTEGER, 
  `SalMiem` INTEGER, 
  `TotMiem` INTEGER
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabTempActividades`;
CREATE TABLE `TabTempActividades` (
  `CodAct` VARCHAR(3), 
  `TipAct` VARCHAR(50), 
  `SelAct` TINYINT(1) DEFAULT 0
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabCargos`;
CREATE TABLE `TabCargos` (
  `IdCargo` INTEGER NOT NULL AUTO_INCREMENT, 
  `DesCar` VARCHAR(30), 
  INDEX (`IdCargo`), 
  PRIMARY KEY (`IdCargo`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabRespo`;
CREATE TABLE `TabRespo` (
  `Id` INTEGER NOT NULL AUTO_INCREMENT, 
  `CodCon` VARCHAR(8), 
  `CodArea` VARCHAR(3), 
  `Observacion` VARCHAR(50), 
  INDEX (`CodArea`), 
  INDEX (`CodCon`), 
  PRIMARY KEY (`Id`)
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
SET autocommit=1;

DROP TABLE IF EXISTS `TabReportesObser`;
CREATE TABLE `TabReportesObser` (
  `CodAsi` VARCHAR(12), 
  `CodCon` VARCHAR(8), 
  `CodCasPaz` VARCHAR(6), 
  `Id_Red` VARCHAR(1), 
  `TipRep` VARCHAR(50), 
  `ObsRep` VARCHAR(255), 
  INDEX (`Id_Red`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabHorarioDis`;
CREATE TABLE `TabHorarioDis` (
  `HORA` DATETIME, 
  `DIA` INTEGER, 
  `DesCur` VARCHAR(100)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabMovimientos`;
CREATE TABLE `TabMovimientos` (
  `NumMov` INTEGER NOT NULL AUTO_INCREMENT, 
  `TipMov` VARCHAR(2), 
  `FecMov` DATETIME, 
  `TipDoc` VARCHAR(50), 
  `NumDoc` VARCHAR(20), 
  `CodTes` VARCHAR(4), 
  `ConMov` VARCHAR(150), 
  `Cantidad` DOUBLE NULL, 
  `IPrecio` DOUBLE NULL, 
  `ISubTotal` DOUBLE NULL, 
  `IIGV` DOUBLE NULL, 
  `ITotal` DOUBLE NULL, 
  `EPrecio` DOUBLE NULL, 
  `ESubTotal` DOUBLE NULL, 
  `EIGV` DOUBLE NULL, 
  `ETotal` DOUBLE NULL, 
  `TipoPago` VARCHAR(10) DEFAULT 'CONTADO', 
  `ModoPago` VARCHAR(1) DEFAULT 'E', 
  `ObsMov` VARCHAR(150), 
  PRIMARY KEY (`NumMov`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabFormatoVision`;
CREATE TABLE `TabFormatoVision` (
  `CodArea` VARCHAR(4), 
  `CodCon` VARCHAR(8), 
  `TEM001` VARCHAR(1) DEFAULT 'F', 
  `TEM002` VARCHAR(1) DEFAULT 'F', 
  `TEM003` VARCHAR(1) DEFAULT 'F', 
  `TEM004` VARCHAR(1) DEFAULT 'F', 
  `TEM005` VARCHAR(1) DEFAULT 'F', 
  `TEM006` VARCHAR(1) DEFAULT 'F', 
  `TEM007` VARCHAR(1) DEFAULT 'F', 
  `TEM008` VARCHAR(1) DEFAULT 'F', 
  `TEM009` VARCHAR(1) DEFAULT 'F', 
  `TEM010` VARCHAR(1) DEFAULT 'F', 
  `TEM011` VARCHAR(1) DEFAULT 'F', 
  `TEM012` VARCHAR(1) DEFAULT 'F', 
  `TEM013` VARCHAR(1) DEFAULT 'F', 
  `TEM014` VARCHAR(1) DEFAULT 'F', 
  `TEM015` VARCHAR(1) DEFAULT 'F', 
  `TEM016` VARCHAR(1) DEFAULT 'F', 
  `TEM017` VARCHAR(1) DEFAULT 'F', 
  `TEM018` VARCHAR(1) DEFAULT 'F', 
  `TEM019` VARCHAR(1) DEFAULT 'F', 
  `TEM020` VARCHAR(1) DEFAULT 'F', 
  `TEM021` VARCHAR(1) DEFAULT 'F', 
  `TEM022` VARCHAR(1) DEFAULT 'F', 
  `TEM023` VARCHAR(1) DEFAULT 'F', 
  `TEM024` VARCHAR(1) DEFAULT 'F', 
  `TEM025` VARCHAR(1) DEFAULT 'F', 
  `TEM026` VARCHAR(1) DEFAULT 'F', 
  `TEM027` VARCHAR(1) DEFAULT 'F', 
  `TEM028` VARCHAR(1) DEFAULT 'F', 
  `TEM029` VARCHAR(1) DEFAULT 'F', 
  `TEM030` VARCHAR(1) DEFAULT 'F', 
  `TEM031` VARCHAR(1) DEFAULT 'F', 
  `TEM032` VARCHAR(1) DEFAULT 'F', 
  `TEM033` VARCHAR(1) DEFAULT 'F', 
  `TEM034` VARCHAR(1) DEFAULT 'F', 
  `TEM035` VARCHAR(1) DEFAULT 'F', 
  `TEM036` VARCHAR(1) DEFAULT 'F', 
  `TEM037` VARCHAR(1) DEFAULT 'F', 
  `TEM038` VARCHAR(1) DEFAULT 'F', 
  `TEM039` VARCHAR(1) DEFAULT 'F', 
  `TEM040` VARCHAR(1) DEFAULT 'F', 
  `TEM041` VARCHAR(1) DEFAULT 'F', 
  `TEM042` VARCHAR(1) DEFAULT 'F', 
  `TEM043` VARCHAR(1) DEFAULT 'F', 
  `TEM044` VARCHAR(1) DEFAULT 'F', 
  `TEM045` VARCHAR(1) DEFAULT 'F', 
  `TEM046` VARCHAR(1) DEFAULT 'F'
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;

DROP TABLE IF EXISTS `TabMensajeriaSMS`;
CREATE TABLE `TabMensajeriaSMS` (
  `CodCon` VARCHAR(8) NOT NULL, 
  `Nombres` VARCHAR(255), 
  `NumCel` VARCHAR(9), 
  PRIMARY KEY (`CodCon`)
) ENGINE=innodb DEFAULT CHARSET=utf8;
SET autocommit=1;


## FOREIGN KEY ##

-- --------------- RELACIONES DE LOS ROLES Y PERMISOS --------------- 

ALTER TABLE users
ADD FOREIGN KEY (`codcon`) REFERENCES `TabCon` (`CodCon`) ON DELETE CASCADE;

ALTER TABLE model_has_permissions
ADD FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE model_has_permissions
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions 
ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE role_has_permissions
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;  

ALTER TABLE model_has_roles 
ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE model_has_roles 
ADD FOREIGN KEY (`model_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
  
-- --------------- FIN DE LAS RELACIONES DE LOS ROLES Y PERMISOS --------------- 
  
  
-- --------------- RELACIONES DE LAS ESCUELAS ANTIGUAS --------------- 

ALTER TABLE TabEscuelas
ADD FOREIGN KEY(`CodCur`) REFERENCES `TabCursos` (`CodCur`) ON DELETE CASCADE;

ALTER TABLE TabTemasDis
ADD FOREIGN KEY(`NumDis`) REFERENCES `TabEscuelas` (`NumDis`) ON DELETE CASCADE;

ALTER TABLE TabTemaDisAsistencia
ADD FOREIGN KEY(`NumDis`) REFERENCES `TabTemasDis` (`NumDis`);

-- ALTER TABLE TabTemaDisAsistencia
-- ADD CONSTRAINT `fk_TemaDisAsistencia_TabTemasDis2` FOREIGN KEY(`Numtem`) REFERENCES `TabTemasDis` (`NumTem`) ON DELETE CASCADE;

ALTER TABLE TabTemaDisAsistencia
ADD FOREIGN KEY(`CodCon`) REFERENCES `TabCon` (`CodCon`) ON DELETE CASCADE;

-- --------------- FIN RELACIONES DE LAS ESCUELAS ANTIGUAS --------------- 


-- --------------- RELACIONES DE CASAS DE PAZ --------------- 

ALTER TABLE TabMimCasPaz
ADD CONSTRAINT fk_CasasDePaz_CodCasPaz FOREIGN KEY (CodCasPaz) REFERENCES TabCasasDePaz(CodCasPaz) ON DELETE CASCADE;

ALTER TABLE TabMimCasPaz
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon) ON DELETE CASCADE; 

ALTER TABLE TabCasasDePaz
ADD CONSTRAINT fk_TabCon_CodCon FOREIGN KEY (CodLid) REFERENCES TabCon(CodCon);

ALTER TABLE TabCasasDePaz
ADD FOREIGN KEY(ID_Red) REFERENCES TabRedes(ID_RED);

ALTER TABLE TabMentores
ADD FOREIGN KEY(ID_RED) REFERENCES TabRedes (ID_RED);

ALTER TABLE TabRedes
ADD FOREIGN KEY (LID_RED) REFERENCES TabCon(CodCon);

-- --------------- FIN RELACIONES DE CASAS DE PAZ --------------- 


-- --------------- RELACIONES DE INFORMES DE CASAS DE PAZ --------------- 

ALTER TABLE TabDetInfCas
ADD FOREIGN KEY(NumInf) REFERENCES TabInfCasPaz(NumInf) ON DELETE CASCADE;

-- --------------- FIN RELACIONES DE INFORMES DE CASAS DE PAZ --------------- 


-- --------------- RELACIONES ASISTENCIAS, ACTIVIDADES Y PERMISOS--------------- 

ALTER TABLE TabDetDocumentos
ADD FOREIGN KEY(CodAct) REFERENCES TabActividades(CodAct) ON DELETE CASCADE;

ALTER TABLE TabDetDocumentos
ADD FOREIGN KEY(NumReg) REFERENCES TabDocumentos(NumReg) ON DELETE CASCADE;

ALTER TABLE TabDocumentos
ADD FOREIGN KEY(CodCon) REFERENCES TabCon(CodCon) ON DELETE CASCADE;

ALTER TABLE TabAsi
ADD FOREIGN KEY(CodAct) REFERENCES TabActividades(CodAct) ON DELETE CASCADE;

ALTER TABLE TabDetAsi
ADD FOREIGN KEY (CodAsi) REFERENCES TabAsi(CodAsi) ON DELETE CASCADE;

ALTER TABLE TabDetAsi
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon) ON DELETE CASCADE;

-- --------------- FIN RELACIONES ASISTENCIAS, ACTIVIDADES Y PERMISOS--------------- 


-- --------------- RELACIONES GRUPOS Y MIEMBROS --------------- 

ALTER TABLE TabGrupos
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon); 

ALTER TABLE TabGruposMiem
ADD FOREIGN KEY (CodArea) REFERENCES TabGrupos(CodArea) ON DELETE CASCADE;

ALTER TABLE TabGruposMiem
ADD FOREIGN KEY (CodCon) REFERENCES TabCon(CodCon) ON DELETE CASCADE;

-- --------------- FIN RELACIONES GRUPOS Y MIEMBROS --------------- 


-- --------------- RELACIONES DE ESCUELAS NUEVAS --------------- 

ALTER TABLE TabSubEtapas
ADD FOREIGN KEY (CodEtapa) REFERENCES TabEtapaVision(CodEtapa) ON DELETE CASCADE;

ALTER TABLE TabTemasEscuela
ADD FOREIGN KEY (CODSUBETP) REFERENCES TabSubEtapas(CODSUBETP) ON DELETE CASCADE;

ALTER TABLE TabRegEscuelasCab
ADD FOREIGN KEY(CODSUBETP) REFERENCES TabSubEtapas(CODSUBETP) ON DELETE CASCADE;

ALTER TABLE TabRegEscuelasDet
ADD FOREIGN KEY(NUMREG) REFERENCES TabRegEscuelasCab(NUMREG) ON DELETE CASCADE;

ALTER TABLE TabRegEscuelasCab
ADD FOREIGN KEY(CODCON) REFERENCES TabCon(CodCon) ON DELETE CASCADE;

-- --------------- FIN RELACIONES DE ESCUELAS NUEVAS --------------- 

-- --------------- RELACIONES DE LUGARES --------------- 

ALTER TABLE TabProPeru
ADD FOREIGN KEY(Id_Dep) REFERENCES TabDepPeru(Id_Dep) ON DELETE CASCADE;

ALTER TABLE TabDisPeru
ADD FOREIGN KEY(Id_Pro) REFERENCES TabProPeru(Id_Pro) ON DELETE CASCADE;

ALTER TABLE TabLocalidad
ADD FOREIGN KEY(Id_Dis) REFERENCES TabDisPeru(Id_Dis) ON DELETE CASCADE;

ALTER TABLE TabZonas
ADD FOREIGN KEY(Id_Localidad) REFERENCES TabLocalidad(Id_Localidad) ON DELETE CASCADE;

ALTER TABLE TabCon
ADD FOREIGN KEY(Id_Zona) REFERENCES TabZonas(Id_Zona);

-- --------------- FIN RELACIONES DE LUGARES --------------- 

-- --------------- RELACIONES DE FAMILIAS --------------- 

ALTER TABLE TabCon
ADD FOREIGN KEY(CodFam) REFERENCES TabFamilias(CodFam);

-- --------------- FIN RELACIONES DE FAMILIAS --------------- 

-- --------------- RELACIONES USUARIOS SISTEMA ANTIGUO --------------- 

ALTER TABLE TabPermisosUsu
ADD FOREIGN KEY(CodUsu) REFERENCES TabUsuarios(CodUsu);

-- --------------- FIN RELACIONES USUARIOS SISTEMA ANTIGUO --------------- 


-- --------------- RELACIONES HISTORIAL DE VISITAS --------------- 

ALTER TABLE TabHistorialVis
ADD FOREIGN KEY (CodCon) REFERENCES TabCon (CodCon);

-- --------------- FIN RELACIONES HISTORIAL DE VISITAS --------------- 


-- --------------- RELACIONES MIEMBROS OBSERVADOS --------------- 

ALTER TABLE miembros_observados
ADD FOREIGN KEY(CodCon) REFERENCES TabCon(codcon) ON DELETE CASCADE;

-- --------------- FIN RELACIONES MIEMBROS OBSERVADOS --------------- 