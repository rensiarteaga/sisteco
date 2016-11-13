<?php
/**
 * Nombre del archivo:	ActionGuardarPersona.php
 * Propósito:			Permite insertar y modificar registros de Subsistemas
 * Tabla:				tsg_persona
 * Parámetros:			
 * Valores de Retorno:	
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		28-08-2007
 */
session_start();
include_once("../LibModeloSeguridad.php");

	


$Custom = new cls_CustomDBSeguridad();
$nombre_archivo = 'ActionGuardarPersona.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{   //echo "foto_personassssssssss";
	//include_once("../../../lib_general/funciones.inc.php");
	include_once("../../../lib/lib_general/cls_archivos.php");
	 /* $nombre=$HTTP_POST_FILES['foto_persona']['name'];
	  $tmp_name = $HTTP_POST_FILES['foto_persona']['tmp_name'];
	 */ 
	  
	 $cont=1;
	 
	 
	$f = new cls_archivos();
	//////////////////////////almacena bien cuando el upload esta false
  /*  $hidden_id_persona = $_POST["txt_id_persona_0"];
	$txt_apellido_paterno = $_POST["txt_apellido_paterno_0"];
    $txt_apellido_materno = $_POST["txt_apellido_materno_0"];
	$txt_nombre = $_POST["nombre"];
	$txt_fecha_nacimiento = $_POST["txt_fecha_nacimiento_0"];
	//$txt_foto_persona = $_GET["txt_foto_persona"];
	$txt_doc_id = $_POST["txt_doc_id_0"];
	$txt_genero = $_POST["txt_genero_0"];
	$txt_casilla = $_POST["txt_casilla_0"];
	$txt_telefono1 =$_POST["txt_telefono1_0"];
	$txt_telefono2 = $_POST["txt_telefono2_0"];
	$txt_celular1 =$_POST["txt_celular1_0"];
	$txt_celular2 =$_POST["txt_celular2_0"];
	$txt_pag_web =$_POST["txt_pag_web_0"];
	$txt_email1 = $_POST["txt_email1_0"];
	$txt_email2 = $_POST["txt_email2_0"];
	$txt_email3 = $_POST["txt_email3_0"];
	$txt_fecha_registro = $_POST["txt_fecha_registro_0"];
	$txt_hora_registro = $_POST["txt_hora_registro_0"];
	$txt_fecha_ultima_modificacion = $_POST["txt_fecha_ultima_modificacion_0"];
	$txt_hora_ultima_modificacion = $_POST["txt_hora_ultima_modificacion_0"];
	$txt_observaciones = $_POST["txt_observaciones_0"];
	$hidden_id_tipo_doc_identificacion = $_POST["txt_id_tipo_doc_identificacion_0"];*/	
	////////////////////////// hasta aqui registra bien sin el upload
/*	$hidden_id_persona = $HTTP_POST_FILES["id_persona"];
	$txt_apellido_paterno = $HTTP_POST_FILES["apellido_paterno"];
    $txt_apellido_materno = $HTTP_POST_FILES["apellido_materno"];
	$txt_nombre = $HTTP_POST_FILES["nombre"];
	$txt_fecha_nacimiento = $HTTP_POST_FILES["fecha_nacimiento"];
	$txt_doc_id = $HTTP_POST_FILES["doc_id"];
	$txt_genero = $HTTP_POST_FILES["genero"];
	$txt_casilla = $HTTP_POST_FILES["casilla"];
	$txt_telefono1 =$HTTP_POST_FILES["telefono1"];
	$txt_telefono2 = $HTTP_POST_FILES["telefono2"];
	$txt_celular1 =$HTTP_POST_FILES["celular1"];
	$txt_celular2 =$HTTP_POST_FILES["celular2"];
	$txt_pag_web =$HTTP_POST_FILES["pag_web"];
	$txt_email1 = $HTTP_POST_FILES["email1"];
	$txt_email2 = $HTTP_POST_FILES["email2"];
	$txt_email3 = $HTTP_POST_FILES["email3"];
	$txt_fecha_registro = $HTTP_POST_FILES["fecha_registro"];
	$txt_hora_registro = $HTTP_POST_FILES["hora_registro"];
	$txt_fecha_ultima_modificacion = $HTTP_POST_FILES["fecha_ultima_modificacion"];
	$txt_hora_ultima_modificacion = $HTTP_POST_FILES["hora_ultima_modificacion"];
	$txt_observaciones = $HTTP_POST_FILES["observaciones"];
	$hidden_id_tipo_doc_identificacion = $HTTP_POST_FILES["id_tipo_doc_identificacion"];*/
	//$hidden_id_tipo_doc_identificacion = $HTTP_POST_FILES['id_tipo_doc_identificacion'];
    $hidden_id_persona = $_POST["id_persona"];
	$txt_apellido_paterno = $_POST["apellido_paterno"];
    $txt_apellido_materno = $_POST["apellido_materno"];
	$txt_nombre = $_POST["nombre"];
	$txt_fecha_nacimiento = $_POST["fecha_nacimiento"];
	$txt_doc_id = $_POST["doc_id"];
	$txt_genero = $_POST["genero"];
	$txt_casilla = $_POST["casilla"];
	$txt_telefono1 =$_POST["telefono1"];
	$txt_telefono2 = $_POST["telefono2"];
	$txt_celular1 =$_POST["celular1"];
	$txt_celular2 =$_POST["celular2"];
	$txt_pag_web =$_POST["pag_web"];
	$txt_email1 = $_POST["email1"];
	$txt_email2 = $_POST["email2"];
	$txt_email3 = $_POST["email3"];
	$txt_fecha_registro = $_POST["fecha_registro1"];
	$txt_hora_registro = $_POST["hora_registro"];
	$txt_fecha_ultima_modificacion = $_POST["fecha_ultima_modificacion"];
	$txt_hora_ultima_modificacion = $_POST["hora_ultima_modificacion"];
	$txt_observaciones = $_POST["observaciones"];
	$hidden_id_tipo_doc_identificacion = $_POST["id_tipo_doc_identificacion_value"];
	
	
	$foto_persona = $_HTTP_POST_FILES['foto_persona']['name'];
    $arch = $HTTP_POST_FILES['foto_persona']['tmp_name'];
    //echo "nombre:".$txt_nombre;
    
     $direccion = $f->carga_archivo($HTTP_POST_FILES['foto_persona'],'../../control/persona_2/archivo/' );
    
    
    $res = $Custom->InsertarPersonaFoto($hidden_id_persona,$txt_apellido_paterno,$txt_apellido_materno,
                                        $txt_nombre,$txt_fecha_nacimiento,$HTTP_POST_FILES['foto_persona'],$txt_doc_id,
                                        $txt_genero,$txt_casilla,$txt_telefono1,$txt_telefono2,
                                        $txt_celular1,$txt_celular2,$txt_pag_web,$txt_email1,$txt_email2,$txt_email3,
                                        $txt_fecha_registro,$txt_hora_registro,$txt_fecha_ultima_modificacion,
                                        $txt_hora_ultima_modificacion,$txt_observaciones,$hidden_id_tipo_doc_identificacion);
 		if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "503");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'id_subsistema';
	if($sortdir == "") $sortdir = 'asc';   
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	if($res) $total_registros = $Custom->salida;
    /*$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', 1);
	$resp->add_nodo('mensaje', 'Falta algo :(');
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();*/
	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo('TotalCount', $total_registros);
	$resp->add_nodo('mensaje', $mensaje_exito);
	$resp->add_nodo('tiempo_resp', '200');
	echo $resp->get_mensaje();
	
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 1';
	echo $resp->get_mensaje();
	exit;
}
?>