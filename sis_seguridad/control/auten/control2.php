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
Versión:				1.0.0
Autor:					Enzo Rojas
**********************************************************
*/
//vemos si el usuario y contraseña es váildo 
//session_destroy();
session_start() ;
//session_register('ss_id_usuario');
include_once("../LibModeloSeguridad.php");
include_once("../../../lib/configuracion.log.php");
$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'control.php';
$ip_origenx = captura_ip();


//$usu = preg_replace("/\\n", "",$_POST["usuario"]);
$login_usuario = addslashes(htmlentities($_POST["usuario"],ENT_QUOTES));
//$con = preg_replace("/\\/0", "",$_POST["contrasena"]);
$contrasenia = md5(addslashes(htmlentities($_POST["contrasena"],ENT_QUOTES)));
$nombre_basedatos = addslashes(htmlentities($_POST["nombre_basedatos"],ENT_QUOTES));

//cargamos el nombre de la base de datos
$_SESSION["BASE_DATOS"] = $nombre_basedatos;
$_SESSION["ss_nombre_basedatos"] = $_SESSION["BASE_DATOS"];

//echo "Contraseña |".$contrasenia."|"; 

$res = $Custom -> VerificaUsuario($login_usuario,$contrasenia,$ip_origenx,"99:99:99:99:99:99");

//$res = $Custom -> VerificaUsuario('psarueba','prueba','192.168.0.123','00:19:d1:09:22:7e');
//echo "salida: ".$Custom->salida;

if ($Custom->salida[0] != "t")
{	
	//si no existe le mando otra vez a la portada 
    $_SESSION["autentificado"] = "NO";
	$_SESSION["ss_id_usuario"] = "";
	$_SESSION["ss_id_lugar"] = "";
	$_SESSION["ss_nombre_lugar"] = "";
	$_SESSION["ss_nombre_usuario"] = "";
	$_SESSION["ss_nombre_basedatos"] = "";
	$_SESSION["ss_ip"] = "";
	$_SESSION["ss_mac"] = "";
    //header("Location: ../../../index.php?errorusuario=si");
    echo "{success:false}";
    exit; 
 } 
else if ($Custom->salida[0] == "t"){
    //usuario y contraseña válidos 
    //defino una sesion y se guardan datos
	
	include ("../../../lib/configuracion.inc.php");	
		
	//Guardamos en la sesion las variables de usuario y del sistema	
	
	$_SESSION["autentificado"] = "SI";
	$_SESSION["ss_id_usuario"] = $Custom->salida[1];//id_usuario id del usuario
	$_SESSION["ss_id_rol"] = $Custom->salida[2];//id_rol asignado al usuario
	$_SESSION["ss_id_lugar"] = $Custom->salida[3];//id_lugar id del lugar
	$_SESSION["ss_nombre_lugar"] = $Custom->salida[4];//nombre_lugar nombre del lugar	
	$_SESSION["ss_nombre_usuario"] = $Custom->salida[5];//nombre_usaurio nombre completo del usuario	
	$_SESSION["ss_estilo_usuario"] = $Custom->salida[6];//estilo_usuario estilo para el tema de la interfaz
	
	//Cambiamos el valor 'si' por 'true'
	if($Custom->salida[7]='si')
	{
		$_SESSION["ss_filtro_avanzado"] = 'true';
	}
	else //Cambiamos el valor 'no' por 'false'
	{
		$_SESSION["ss_filtro_avanzado"] = 'false';
	}
	//$_SESSION["ss_filtro_avanzado"] = $Custom->salida[7];//filtro_avanzado bandera para habilitar filtro avanzado
	
	//echo "estilo:".$Custom->salida[5]." filtro: ".$Custom->salida[6];
	
	//$_SESSION["ss_nombre_basedatos"] = $_SESSION["BASE_DATOS"];
	$_SESSION["ss_ip"] = $ip_origenx;
	$_SESSION["ss_mac"] = "99:99:99:99:99:99";
	$_SESSION["SESION_TIME"] = time();
	//echo "time; ".$_SESSION["SESION_TIME"];
	$_SESSION["ID_SESSION"] = session_id();
	
	
	//Redireccionamos al la pagina principal del sistema
    //header ("Location: ../../vista/administracion/layout4.php"); 
    echo "{success:true}";
    exit;   
}
?>