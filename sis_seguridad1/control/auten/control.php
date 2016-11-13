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
Versión:				1.5.0nbvnbvnbv
Autor:					Enzo Rojas
**********************************************************
*/
//vemos si el usuario y contraseña es váildo 
//session_destroy();
session_start() ;
include_once(dirname(__FILE__)."../../LibModeloSeguridad.php");
include_once(dirname(__FILE__)."../../../../lib/configuracion.log.php");
include_once(dirname(__FILE__)."../../../../lib/configuracion.inc.php");
$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'control.php';
$ip_origenx = captura_ip();

/*echo '<pre>';
print_r($_REQUEST);
echo '</pre>';
exit;*/


//$x1 = base64_decode($_REQUEST["xph"]);
$x1 = base64_decode($_POST["xph"]);
$x2=json_decode($x1);


//urldecode()


//$contrasena   

//$usu = preg_replace("/\\n", "",$_POST["usuario"]);
$login_usuario = addslashes(htmlentities($x2->{"usuario"},ENT_QUOTES));
//$con = preg_replace("/\\/0", "",$_POST["contrasena"]);
$contrasenia = md5(addslashes(htmlentities($x2 ->{"contrasena"},ENT_QUOTES)));




//$nombre_basedatos = addslashes(htmlentities($_REQUEST["nombre_basedatos"],ENT_QUOTES));
$nombre_basedatos = addslashes(htmlentities($_POST["nombre_basedatos"],ENT_QUOTES));


//$_SESSION["USUARIO"]=addslashes(htmlentities($login_usuario,ENT_QUOTES));

//$_SESSION["CONTRASENA"]=md5(md5(trim($contrasenia)));

	




//cargamos el nombre de la base de datos
//$_SESSION["BASE_DATOS"] = $nombre_basedatos;
$_SESSION["ss_nombre_basedatos"] = $_SESSION["BASE_DATOS"];
//$_SESSION["ss_usuario"]=addslashes(htmlentities($_SESSION["USUARIO"],ENT_QUOTES));
//$_SESSION["ss_contrasenia"]=addslashes(htmlentities($_SESSION["CONTRASENA"],ENT_QUOTES));


$_SESSION["ss_usuario"]=$_SESSION["USUARIO"];
$_SESSION["ss_contrasenia"]=$_SESSION["CONTRASENA"];//md5(md5(trim($contrasenia)));





//echo "----". $login_usuario."*****".$contrasenia;
//exit;


$res = $Custom -> VerificaUsuario("$login_usuario","$contrasenia",$ip_origenx,"99:99:99:99:99:99");
//$res = $Custom -> VerificaUsuario('psarueba','prueba','192.168.0.123','00:19:d1:09:22:7e');



//echo "asdasdasd   " .$Custom->salida[0];
//echo  $x2->{"usuario"}."____".$x2 ->{"contrasena"};
//exit;


if ($Custom->salida[0] != "t")
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
	//jrr (21/01/2011) :Se coloca 1 si el rol es administrador y 0 si no es administrador
	$_SESSION["ss_rol_adm"]=0;
	$_SESSION["ss_id_uo"]=0;
    echo "{success:false}";
	//header("Location: ../../../index.php?errorusuario=si");
    exit; 
 } 
else if ($Custom->salida[0] == "t"){
    //usuario y contraseña válidos 
    //defino una sesion y se guardan datos
	
	include ("../../../lib/configuracion.inc.php");	
	//include_once(dirname(__FILE__)."../../../../lib/configuracion.inc.php");
	$SW_LDAP=TRUE;
	If($Custom->salida[14]=='ldap'){
	
	//ip para utentificacion del LDAP
	ini_set('display_errors',0);
	$_SESSION["CONTRASENA"]=md5('!"·$%&/()=1234567890'.$Custom->salida[15]);
	$_SESSION["ss_contrasenia"]=$_SESSION["CONTRASENA"];//md5(md5(trim($contrasenia)));
	//ip para utentificacion del LDAP
	$conex = ldap_connect("10.10.0.17",389) or die ("No ha sido posible conectarse al servidor"); 
	
	ldap_set_option($conex, LDAP_OPT_PROTOCOL_VERSION, 3);
	
	
	     if ($conex) { 
			   // bind with appropriate dn to give update access 
			   $r=ldap_bind($conex,trim($login_usuario)."@ende.bo",addslashes(htmlentities(trim($contrasenia),ENT_QUOTES))); 
			    
			 if ($r && trim($contrasenia)!= '') 
			   {$SW_LDAP=TRUE;}
			   else 
			   {$SW_LDAP=FALSE;
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
				$_SESSION["ss_rol_adm"]=0;
				
				$_SESSION["ss_id_uo"]=$Custom->salida[15];// para manejo de retenciones por impuesto
		
	            $_SESSION["ss_id_empresa"]=1;//para el manejo de empresa   OJO REVISAR
	            $_SESSION["ss_retencion"]=0.13;// para manejo de retenciones por impuestos
				
			    echo "{success:false}";
	            exit; 
			    
			   } 
			ldap_close($conex); 
		} 
		
	}
	
	if($SW_LDAP==TRUE){
	
		
	//Guardamos en la sesion las variables de usuario y del sistema	
	$_SESSION["autentificado"] = "SI";
	$_SESSION["ss_id_usuario"] = $Custom->salida[1];//id_usuario id del usuario
	$_SESSION["ss_id_rol"] = $Custom->salida[2];//id_rol asignado al usuario
	$_SESSION["ss_id_lugar"] = $Custom->salida[3];//id_lugar id del lugar
	$_SESSION["ss_nombre_lugar"] = $Custom->salida[4];//nombre_lugar nombre del lugar
	$_SESSION["ss_nombre_empleado"] = $Custom->salida[5];
	$_SESSION["ss_paterno_empleado"] = $Custom->salida[6];
	$_SESSION["ss_materno_empleado"] = $Custom->salida[7];	
	$_SESSION["ss_nombre_usuario"] = $_SESSION["ss_paterno_empleado"]." ".$_SESSION["ss_materno_empleado"]." ".$_SESSION["ss_nombre_empleado"];//nombre completo del usuario	
	$_SESSION["ss_id_empleado"] = $Custom->salida[8];// ID del Empleado
	$_SESSION["ss_estilo_usuario"] = $Custom->salida[9];//estilo_usuario estilo para el tema de la interfaz
	$_SESSION["ss_usuario"]=$_SESSION["USUARIO"];
	$_SESSION["ss_contrasenia"]=$_SESSION["CONTRASENA"];
	//jrr (21/01/2011) :Se coloca 1 si el rol es administrador y 0 si no es administrador
	$_SESSION["ss_rol_adm"]=$Custom->salida[13];// para manejo de retenciones por impuestos
	$_SESSION["ss_autentificacion"]=$Custom->salida[14];
	$_SESSION["ss_id_uo"]=$Custom->salida[15];// para manejo de retenciones por impuesto
		
	$_SESSION["ss_id_empresa"]=1;//para el manejo de empresa   OJO REVISAR
	$_SESSION["ss_retencion"]=0.13;// para manejo de retenciones por impuestos
	
	
	//Cambiamos el valor 'si' por 'true'
	if($Custom->salida[10]=='si')
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
	
	//Incluye la moneda principal
	$_SESSION["ss_moneda_principal"] = $Custom->salida[11];
	
	//Redireccionamos al la pagina principal del sistema
	$sty_usu='xtheme-vista.css';
	if($_SESSION["ss_estilo_usuario"]!=''){
	$sty_usu=$_SESSION["ss_estilo_usuario"];
	}
	
	////////////////
	
	  $_host  = $_SERVER['HTTP_HOST'];
	  $_uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	  $_dir = $_SESSION["_PROTO"].$_host.$_uri."/";
	
	
	
	session_regenerate_id();

    $id_sesion_nueva = session_id();
    $ips = $_SERVER['REMOTE_ADDR'];
    
    
	$Custom -> InsertarSesion('NULL',$id_sesion_nueva,$_SERVER['REMOTE_ADDR'],'NULL',$_SESSION["ss_id_usuario"],'activa',date("G:H:s"),'NULL');
	

 
	echo "{success:true,ss_nombre_usuario:'".$_SESSION["ss_nombre_usuario"]."',ss_nombre_basedatos:'".$_SESSION["ss_nombre_basedatos"]."',ss_nombre_lugar:'".$_SESSION["ss_nombre_lugar"]."',ss_estilo_vista:'".$sty_usu."',ss_tiempo_espera:10000,ss_autentificacion:'".$_SESSION["ss_autentificacion"]."',ss_tam_pag:30,ss_direccion:'$_dir',ss_filtro_avanzado:'".$_SESSION["ss_filtro_avanzado"]."'}";
    exit; 
	
    
    
	} 
}
?>