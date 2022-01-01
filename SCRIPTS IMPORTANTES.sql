use bdprimitiva;
SELECT * FROM TabActMes;

INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26679', '2021-08-03 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26680', '2021-08-04 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26681', '2021-08-05 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26682', '2021-08-06 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26683', '2021-08-07 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26684', '2021-08-08 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26685', '2021-08-09 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26686', '2021-08-15 00:00:00', 'CULTOS NORMALES', 'FINCA MONTE NEGRO', '001', '1899-12-30 08:30:00', '45', '1', '1', 'V');
INSERT INTO `bdprimitiva`.`TabActMes` (`CodActMes`, `FecAct`, `DesAct`, `LugAct`, `CodAct`, `HorIni`, `MinTol`, `ConAsi`, `PriAct`, `EstReg`) VALUES ('26687', '2021-08-12 00:00:00', 'ORACION GENERAL MADRUGADAS', 'TEMPLO ZONA E', '002', '1899-12-30 03:00:00', '15', '1', '1', 'V');
SELECT * FROM TabAsi;
SELECT * FROM TabDetAsi;
SELECT * FROM TabActMes;
DELETE FROM TabDetAsi WHERE CodAsi = '120820210650';
DELETE FROM TabAsi WHERE CodAsi = '120820210650';
UPDATE `bdprimitiva`.`TabActMes` SET `EstReg` = 'V' WHERE (`CodActMes` = '26680');

SELECT * FROM TabDetAsi WHERE CodAsi = '120820210650';
SELECT * FROM TabCasasDePaz;

SELECT cdp.CodCasPaz, cdp.CodLid FROM TabCasasDePaz cdp INNER JOIN TabCon c ON cdp.CodLid = c.CodCon ORDER BY c.ApeCon ASC;

SELECT m.CodCon FROM TabMimCasPaz m INNER JOIN TabCon c ON m.CodCon = c.CodCon WHERE m.CodCasPaz = 'CP0087' ORDER BY c.ApeCon;

SELECT da.CodCon, da.NomApeCon, a.FecAsi, da.asistio  FROM TabAsi a INNER JOIN TabDetAsi da ON a.Codasi = da.CodAsi 
WHERE a.CodAsi = '120820210650' AND da.CodCon = 'NC005165'

SELECT * FROM TabAsi;
SELECT * FROM TabCon WHERE ApeCon = "CARMONA OJEDA"
SELECT CONCAT(ApeCon, ' ', NomCon) FROM TabCon WHERE CodCon = "70618375"

SELECT * FROM TabDetAsi WHERE CodAsi = '120820210650'

SELECT cdp.CodCasPaz, cdp.CodLid FROM TabCasasDePaz cdp INNER JOIN TabCon c ON cdp.CodLid = c.CodCon ORDER BY c.ApeCon ASC LIMIT 5;

SELECT da.CodCon, da.NomApeCon, da.Asistio FROM TabAsi a INNER JOIN TabDetAsi da ON a.Codasi = da.CodAsi WHERE  a.CodAsi = '130820210817' AND da.CodCon = 'NC013160';
 
SELECT * FROM users;
SELECT * FROM model_has_roles;
SELECT * FROM FaltasCultoDS;

SELECT * FROM TabDocumentos d INNER JOIN TabDetDocumentos dd ON d.NumReg = dd.NumReg
WHERE dd.CodAct = '001' AND d.Estado = true AND ('2021-08-13 00:00:00' BETWEEN d.FecIniReg AND d.FecFinReg)



SELECT * FROM TabDocumentos;
NC010032
45457495
NC012868
NC005165