<?php
/**http://10.10.0.12/endesis/lib/rest/get
 * Step 1: Require the Slim PHP 5 Framework
 */
require 'Slim/Slim.php';

/**
 * Step 2: Instantiate the Slim application
 * Here we instantiate the Slim application with its default settings.
 * However, we could also pass a key-value array of settings.
 * Refer to the online documentation for available settings.
 */
$app = new Slim();
$app->contentType('application/xml');
$headers = $app->request()->headers();
header('Access-Control-Allow-Origin: ' . $headers['ORIGIN']);
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, ENDESIS_USER, ENDESIS_PASSENCR');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 1728000');
include_once("../../lib/configuracion.inc.php");
/**
 * Step 3: Define the Slim application routes
 */
$app->post('/listarcorrespondenciaarchivadaende', 'funcListarCorresArchiv');

 function funcListarCorresArchiv()
 {
 	$app = Slim::getInstance();
 	$headers = $app->request()->headers();
 	if(isset ($headers["ENDESIS_USER"]))
 	{
 		validarAutentificacion($headers);
 	}
 	include_once('../../sis_flujo/control/correspondencia/ActionListarCorrespondenciaENDE.php');
}

 $app->get('/modificarcorrespondenciaarchivadaende', 'funcModificarCorresArchiv');
 function funcModificarCorresArchiv() {
 	$app = Slim::getInstance();
 	$headers = $app->request()->headers();
 	if(isset ($headers["ENDESIS_USER"]))
 	{
 		validarAutentificacion($headers);
 	}
 	include_once('../../sis_flujo/control/correspondencia/ActionModificarCorrespondenciaENDE.php');
 }

function fnDecrypt($sValue, $sSecretKey)
{
	return rtrim(
		mcrypt_decrypt
		(
			MCRYPT_RIJNDAEL_256,
			$sSecretKey,
			base64_decode($sValue),
			MCRYPT_MODE_ECB,
			mcrypt_create_iv(
				mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256,MCRYPT_MODE_ECB),
				MCRYPT_RAND
			)
		), "\0"
	);
}
function validarAutentificacion($headerAuten){
 	include_once('../../sis_seguridad/modelo/cls_DBUsuario.php');
 	include_once("../../lib/lib_general/cls_funciones.php");
 	include_once("../../lib/lib_modelo/cls_middle.php");
 	include_once("../../lib/lib_modelo/cls_conexion.php");
 	include_once("../../lib/lib_control/cls_manejo_xml.php");
 	$usuario= new cls_DBUsuario;
 	$res_usr=$usuario->ListarUsuarioRest($headerAuten["ENDESIS_USER"]);
 	if ($res_usr)
 	{
 		$contrasena_recuperada=$usuario->salida[1];
 		if($contrasena_recuperada=='no')
 		{
 			$xml = new cls_manejo_xml('ROOT');
 			$xml->add_rama('Correspondencia');
 			$cad= "".$headerAuten["ENDESIS_USER"]." No es un Usuario valido para continuar";
 			$xml->add_nodo('ERROR',$cad);
 			$xml->fin_rama();
 			$xml->mostrar_xml();
 			exit;
 		}
 		else
 		{
			$respp=fnDecrypt($headerAuten["ENDESIS_PASSENCR"], $contrasena_recuperada);
	 		$validar_contra=explode('$$$$####$$$$', $respp);
	 		if (count($validar_contra)==2 && $validar_contra[1]== $contrasena_recuperada)
	 		{
				$_POST["tipo"]='rest';
	 			$_POST["login_usuario"]=$headerAuten["ENDESIS_USER"];
	 			$_POST["contrasenia"]=$contrasena_recuperada;
	 			$usr_validado=$usuario->VerificaUsuario($headerAuten["ENDESIS_USER"], $contrasena_recuperada,'1.1.1.1', "99:99:99:99:99:99");
	 			if ($usuario->salida[0]!='t')
	 			{
	 				$xml = new cls_manejo_xml('ROOT');
	 				$xml->add_rama('Correspondencia');
	 				$cad="Contrasena invalida para el usuario". $headerAuten["ENDESIS_USER"];
	 				$xml->add_nodo('ERROR',$cad);
	 				$xml->fin_rama();
	 				$xml->mostrar_xml();
	 				exit;
	 			}
	 			else
	 			{
	 				$_SESSION["autentificado"] = "SI";
	 				$_SESSION["ss_id_usuario"] = $usuario->salida[1];//id_usuario id del usuario
	 				$_SESSION["ss_id_rol"] = $usuario->salida[2];//id_rol asignado al usuario
	 				$_SESSION["ss_id_lugar"] = $usuario->salida[3];//id_lugar id del lugar
	 				$_SESSION["ss_nombre_lugar"] = $usuario->salida[4];//nombre_lugar nombre del lugar
	 				$_SESSION["ss_nombre_empleado"] = $usuario->salida[5];
	 				$_SESSION["ss_paterno_empleado"] = $usuario->salida[6];
	 				$_SESSION["ss_materno_empleado"] = $usuario->salida[7];
	 				$_SESSION["ss_nombre_usuario"] = $_SESSION["ss_paterno_empleado"]." ".$_SESSION["ss_materno_empleado"]." ".$_SESSION["ss_nombre_empleado"];//nombre completo del usuario
	 				$_SESSION["ss_id_empleado"] = $usuario->salida[8];// ID del Empleado
	 				$_SESSION["ss_estilo_usuario"] = $usuario->salida[9];//estilo_usuario estilo para el tema de la interfaz
	 				$_SESSION["CONTRASENA"]=md5('!"·$%&/()=1234567890'.$usuario->salida[15]);
	 				$_SESSION["ss_contrasenia"]=$_SESSION["CONTRASENA"];
	 				$_SESSION["USUARIO"]=$headerAuten["ENDESIS_USER"];
	 				$_SESSION["ss_usuario"]=$_SESSION["USUARIO"];
	 				$_SESSION["ss_rol_adm"]=$usuario->salida[13];// para manejo de retenciones por impuestos
	 				$_SESSION["ss_autentificacion"]=$usuario->salida[14];
	 				$_SESSION["ss_id_uo"]=$usuario->salida[15];// para manejo de retenciones por impuesto
	 				$_SESSION["ss_id_empresa"]=1;
	 				$_SESSION["ss_retencion"]=0.13;
	 				if($usuario->salida[10]=='si')
	 				{
	 					$_SESSION["ss_filtro_avanzado"] = 'true';
	 				}
	 				else
	 				{
	 					$_SESSION["ss_filtro_avanzado"] = 'false';
	 				}
	 				$_SESSION["ss_ip"] = '1.1.1.1';
	 				$_SESSION["ss_mac"] = "99:99:99:99:99:99";
	 				$_SESSION["SESION_TIME"] = time();
	 				$_SESSION["ID_SESSION"] = session_id();
	 				$_SESSION["ss_moneda_principal"] = $usuario->salida[11];
	 				$sty_usu='xtheme-vista.css';
	 				if($_SESSION["ss_estilo_usuario"]!='')
	 				{
	 					$sty_usu=$_SESSION["ss_estilo_usuario"];
	 				}
	 				$_host  = $_SERVER['HTTP_HOST'];
	 				$_uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	 				$_dir = $_SESSION["_PROTO"].$_host.$_uri."/";
	 				session_regenerate_id();
	 				$id_sesion_nueva = session_id();
	 				$ips = $_SERVER['REMOTE_ADDR'];
	 			}
	 		}
	 		else
	 		{
	 			$xml = new cls_manejo_xml('ROOT');
	 			$xml->add_rama('Correspondencia');
	 			$cad="Contrasena invalida para el usuario". $headerAuten["ENDESIS_USER"];
	 			$xml->add_nodo('ERROR',$cad);
	 			$xml->fin_rama();
	 			$xml->mostrar_xml();
	 			exit;
	 		}
 		}

 	}

 }

//POST route
$app->get('/get', 'functionPost');
 function functionPost() {
    echo 'This is a POST route';
};
//PUT route
$app->put('/put','functionPut');
 function functionPut() {
    echo 'This is a PUT route';
};
//DELETE route
$app->delete('/delete','functionDelete');
 function functionDelete () {
    echo 'This is a DELETE route';
};

$app->options('/imodificarcorrespondenciaarchivadaende','funcionOptions');
	function funcionOptions ()
	{
		$app = Slim::getInstance();
		$headers = $app->request()->headers();
		header('Access-Control-Allow-Origin: ' . $headers['ORIGIN']);
		header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
		header('Access-Control-Allow-Headers: content-type, ENDESIS_USER, ENDESIS_PASS');
		header('Access-Control-Allow-Credentials: true');
		header('Access-Control-Max-Age: 1728000');
	};

/*
* Step 4: Run the Slim application
* This method should be called last. This is responsible for executing
* the Slim application using the settings and routes defined above.
*/
$app->run();