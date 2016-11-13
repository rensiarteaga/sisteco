<?php 
/**
**********************************************************
Nombre de archivo:	    control.php
Propósito:				Permite autenticar al usuario
Tabla:					tsg_usuario
Parámetros:				$login_usuario
						$contrasenia

Valores de Retorno:    	Permite o deniega acceso al sistema
Fecha de Creación:		11 - 06 - 07
Versión:				1.5.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
//vemos si el usuario y contraseña es váildo 
//session_destroy();
session_start();
if($_POST["usuario"]=="test"&&$_POST["contrasena"]=='test')
{
$sw=1;
}
else{
$sw=0;
}

if($sw==0)
{	
	//si no existe le mando otra vez a la portada 
    $_SESSION["autentificado"] = "NO";
	$_SESSION["ss_id_usuario"] = "";
	$_SESSION["ss_id_lugar"] = "";
	$_SESSION["ss_nombre_lugar"] = "";
	$_SESSION["ss_nombre_empleado"] = "";
	$_SESSION["ss_paterno_empleado"] = "";
	$_SESSION["ss_materno_empleado"] = "";
	$_SESSION["ss_nombre_usuario"] = "";
	$_SESSION["ss_id_empleado"] = "";
	$_SESSION["ss_nombre_basedatos"] = "";
	$_SESSION["ss_ip"] = "";
	$_SESSION["ss_mac"] = "";
    echo "{success:false}";
	//header("Location: ../../../index.php?errorusuario=si");
    exit; 
 } 
else{
    //usuario y contraseña válidos 
    //defino una sesion y se guardan datos
	//Guardamos en la sesion las variables de usuario y del sistema	
	
	$_SESSION["autentificado"] = "SI";
	$_SESSION["ss_id_usuario"] = '1';//id_usuario id del usuario
	$_SESSION["ss_id_rol"] = '1';//id_rol asignado al usuario
	$_SESSION["ss_id_lugar"] = '1';//id_lugar id del lugar
	$_SESSION["ss_nombre_lugar"] = 'Bolivia';//nombre_lugar nombre del lugar
	$_SESSION["ss_nombre_empleado"] = 'Rensi';
	$_SESSION["ss_paterno_empleado"] = 'Arteaga';
	$_SESSION["ss_materno_empleado"] = 'Copari';	
	$_SESSION["ss_nombre_usuario"] = 'Rensi Arteaga Copari';
	$_SESSION["ss_id_empleado"] = '1';// ID del Empleado
	$_SESSION["ss_estilo_usuario"] = 'vista';//estilo_usuario estilo para el tema de la interfaz
	$_SESSION["SESION_TIME"] = time();
	//echo "time; ".$_SESSION["SESION_TIME"];
	$_SESSION["ID_SESSION"] = session_id();
		
	echo "{success:true,
		ss_nombre_usuario:'".$_SESSION["ss_nombre_usuario"]."',
		ss_nombre_basedatos:'".$_SESSION["ss_nombre_basedatos"]."',
		ss_nombre_lugar:'".$_SESSION["ss_nombre_lugar"]."',
		ss_estilo_vista:'".$_SESSION["ss_estilo_usuario"]."',
		ss_tiempo_espera:10000}";
     exit;   
}
?>