<?php 
/**
*************************************************************************************************
Nombre del Archivo:	configuracion.php
Propósito:			Este archivo carga todas las variables basicas de configuracion del sistema.
Autor:				Veimar Soliz Poveda
Fecha de Creación:	20-06-2006
Observaciones:		Debe incluirse en la mayoria de los scripts
*************************************************************************************************
*/
session_start() ;
	// Esta es la variable que indica el host del servidor Postgres
	$_SESSION["HOST"] = "10.10.0.14";
	//$HOST = "192.168.1.8";
	// Esta es la variable que indica el usuario del servidor Postgres
	$_SESSION["USUARIO"] = "rodrigo" ;
	//$USUARIO = "endesis" ;
	// Esta es la variable que indica la contraseña del usuario de Postgres
	$_SESSION["CONTRASENA"]	= "db_rcm" ;
	//$CONTRASENA	= "1234" ;
	// Esta es la variable que indica la base de datos a utilizar
	$_SESSION["BASE_DATOS"]	= "dbendesis_desarrollo";
	//$BASE_DATOS	= "dbendesis";
	//clavece encriptación
	$CLAVE_E = "4r";
	//tamaño de pagina
	$TAMANO_PAGINA = 12;
	//tiempo de espera (del lado del cliente)
	$TIEMPO_DE_ESPERA = 10000;
	//Codificación xml
	//$_SESSION["CODIFICACION_XML"] = "iso-8859-1";//latin 1
	$_SESSION["CODIFICACION_XML"] = "iso-8859-15";//latin 9
	//$_SESSION["CODIFICACION_XML"] = "utf-8";
	//Codificación HEADER
	//$_SESSION["CODIFICACION_HEADER"] = "iso-8859-1";//Latin 1
	$_SESSION["CODIFICACION_HEADER"] = "iso-8859-15";//Latin 9
	//$_SESSION["CODIFICACION_HEADER"] = "utf-8";
?>