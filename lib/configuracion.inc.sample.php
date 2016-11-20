<?php 
/**
*************************************************************************************************
Nombre del Archivo:	configuracion.php
Propósito:			Este archivo carga todas las variables basicas de configuracion del sistema.
Autor:				Veimar Soliz Poveda
Fecha de Creación:	20-06-2006
Observaciones:		Debe incluirse en la mayoria de los scripts
*************************************************************************************************
-------------------------------------------------*/
session_start() ;
// Esta es la variable que indica el host del servidor Postgres
$_SESSION["HOST"] = "10.10.10.10";

$x1 = base64_decode($_POST["xph"]);
$x2=json_decode($x1);


$login_usuario = $x2->{"usuario"};
$contrasenia = $x2 ->{"contrasena"};

$_SESSION["_SEMILLA"]='!"·$%&/()=1234567890';

$_SESSION["USUARIO"]=addslashes(htmlentities($login_usuario,ENT_QUOTES));
//$_SESSION["CONTRASENA"]=md5('!"·$%&/()=1234567890'.md5(trim($contrasenia)));
$_SESSION["CONTRASENA"]=md5($_SESSION["_SEMILLA"].md5(trim($contrasenia)));


$_SESSION["BASE_DATOS"]="dbendesis"; 
$_SESSION["logo"]="../images/logo_reporte.jpg";

//RAC:  CREDENCIALES EXCLUSIVAS PARA VERIFICAR EL LOGUEO
$_SESSION["CON_USUARIO"]=$_SESSION["BASE_DATOS"].'_conexion';
$_SESSION["CON_CONTRASENA"]='!"·$%&/()=?¿¿?=)(/&%$·"!TREPOD0';


//clavece encriptación
$CLAVE_E = "4r";
//tamaño de pagija
$TAMANO_PAGINA = 12;
//tiempo de espera (del lado del cliente)
$TIEMPO_DE_ESPERA = 10000;
//Codificación xml
$_SESSION["CODIFICACION_XML"] = "iso-8859-15";//latin 9
//Codificación HEADER
$_SESSION["CODIFICACION_HEADER"] = "iso-8859-15";//Latin 9
//DEBUG de ERRORES
$_SESSION["DEBUG_ENV"] = false ;//para confirura si se muestran warning y notice
$_SESSION["_PROTO"] ='http://';//para confirura si se muestran warning y notice


?>
