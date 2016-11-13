<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarFeriado.php
Propósito:				Permite insertar y modificar Feriados
Tabla:					tca_feriado
Parámetros:				$hidden_id_feriado	--> id del feriado
						$descripcion
						$txt_id_usuario_asignacion

Valores de Retorno:    	Número de registros
Fecha de Creación:		24-05-2007
Versión:				
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloControlAsistencia.php");

$Custom = new cls_CustomDBControlAsistencia();
$Customdel = new cls_CustomDBControlAsistencia();
$nombre_archivo = 'ActionGuardarArchivo.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
		include_once("../../lib/funciones.inc.php");
		$f = new funciones();
		$nombre_archivo = $HTTP_POST_FILES['txt_archivo']['name'];
		$arch = $HTTP_POST_FILES['txt_archivo']['tmp_name'];
      // $direccion = $f-> carga_archivo($HTTP_POST_FILES['txt_archivo'],'../../archivo/' );
      	$direccion = $f-> carga_archivo($HTTP_POST_FILES['txt_archivo'],'../../../tmpendesis/' );
       //	echo '*****'.$direccion.'*****'; exit;
       	
		////////////////////////////////////////////////////////////
	    $res = $Custom->ProcesarArchivo($direccion);
	    if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		else{
			$mensaje_exito = 'Se cargaron los registros satisfactoriamente';
			$resp = new cls_manejo_mensajes(false);
	   	    $resp->add_nodo('mensaje', $mensaje_exito);
	        $resp->add_nodo('tiempo_resp', '200');
	        echo $resp->get_mensaje();
	        exit;
		}
	// header("Location: ../../vista/lectura_reloj/lectura_reloj.php");
		
}
?>