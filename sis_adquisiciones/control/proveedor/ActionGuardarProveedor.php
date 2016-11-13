<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarProveedor.php
Propósito:				Permite insertar y modificar datos en la tabla tad_proveedor
Tabla:					tad_tad_proveedor
Parámetros:				$hidden_id_proveedor
						$txt_codigo
						$txt_observaciones
						$txt_fecha_reg
						$txt_id_institucion
						$txt_id_persona

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2007-10-17 10:31:08
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarProveedor.php";

if (!isset($_SESSION["autentificado"]))
{
	$_SESSION["autentificado"]="NO";
}
if($_SESSION["autentificado"]=="SI")
{
	//Verifica si los datos vienen por POST o GET
	if (sizeof($_GET) > 0)
	{
		$get=true;
		$cont=1;
		
		//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
		//valores permitidos de $cod -> "si", "no"
		switch ($cod)
		{
			case "si":
				$decodificar = true;
				break;
			case "no":
				$decodificar = false;
				break;
			default:
				$decodificar = true;
				break;
		}
	}
	elseif(sizeof($_POST) > 0)
	{
		$get = false;
		$cont =  $_POST["cantidad_ids"];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar.";
		$resp->origen = "ORIGEN = ";
		$resp->proc = "PROC = ";
		$resp->nivel = "NIVEL = 4";
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$Custom->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_proveedor= $_GET["hidden_id_proveedor_$j"];
			
			$observaciones= $_GET["observaciones_$j"];
			$id_institucion= $_GET["id_institucion_$j"];
			$id_persona= $_GET["id_persona_$j"];
			$nombre_pago= $_GET["nombre_pago_$j"];
			$fax_proveedor=$_GET["fax_proveedor_$j"];
			$casilla_proveedor=$_GET["casilla_proveedor_$j"];
			$id_depto=$_GET["id_depto_$j"];
			$rubro1=$_GET["rubro1_$j"];
			$rubro2=$_GET["rubro2_$j"];
			$tipo=$_GET["tipo_$j"];
			$id_rubro=$_GET["id_rubro_$j"];
			//$codigo= $_GET["codigo_$j"];
			//$fecha_reg= $_GET["txt_fecha_reg_$j"];
			
			//$usuario= $_GET["txt_usuario_$j"];
			//$contrasena= $_GET["txt_contrasena_$j"];
			//$confirmado= $_GET["txt_confirmado_$j"];
			//$id_cuenta= $_GET["txt_id_cuenta_$j"];
			//$id_auxiliar= $_GET["txt_id_auxiliar_$j"];
	
            //$direccion_proveedor=$_GET["txt_direccion_proveedor_$j"];
           // $telefono1_proveedor=$_GET["txt_telefono1_proveedor_$j"];
           // $telefono2_proveedor=$_GET["txt_telefono2_proveedor_$j"];
			//$mail_proveedor=$_GET["txt_mail_proveedor_$j"];
			
		   // $celular1_proveedor=$_GET["txt_celular1_proveedor_$j"];
		   // $celular2_proveedor=$_GET["txt_celular2_proveedor_$j"];
		   // $email2_proveedor=$_GET["txt_email2_proveedor_$j"];
    		//$pag_web_proveedor=$_GET["txt_pag_web_proveedor_$j"];
    		//$nombre_contacto=$_GET["txt_nombre_contacto_$j"];
    		//$direccion_contacto=$_GET["txt_direccion_contacto_$j"];
    		//$telefono_contacto=$_GET["txt_telefono_contacto_$j"];
    		//$email_contacto=$_GET["txt_email_contacto_$j"];
    		//$tipo_contacto=$_GET["txt_tipo_contacto_$j"];
    		//$id_contacto=$_GET["id_contacto_$j"];
    		//$txt_con_contacto=$_GET["txt_con_contacto_$j"];
    		
    		//$rubro=$_GET["txt_rubro_$j"];
    		
    		//$paterno=$_GET["paterno_$j"];
    		//$materno=$_GET["materno_$j"];
    		//$nombre=$_GET["nombre_$j"];
    		//$id_tipo_doc_identificacion=$_GET["id_tipo_doc_identificacion_$j"];
    		//$id_tipo_doc_institucion=$_GET["id_tipo_doc_institucion_$j"];
			//$doc_id=$_GET["doc_id_$j"];
			
			//$nombre_institucion=$_GET["txt_proveedor_$j"];
		}
		else
		{
			$id_proveedor= $_POST["hidden_id_proveedor_$j"];
			
			$observaciones= $_POST["observaciones_$j"];
			$id_institucion= $_POST["id_institucion_$j"];
			$id_persona= $_POST["id_persona_$j"];
			$nombre_pago= $_POST["nombre_pago_$j"];
			$fax_proveedor=$_POST["fax_proveedor_$j"];
			$casilla_proveedor=$_POST["casilla_proveedor_$j"];
			$id_depto=$_POST["id_depto_$j"];
			$rubro1=$_POST["rubro1_$j"];
			$rubro2=$_POST["rubro2_$j"];
			$tipo=$_POST["tipo_$j"];
			$id_rubro=$_POST["id_rubro_$j"];
		}
//echo $tipo;
//exit;
		if($id_persona>0){
			$id_documento=$id_tipo_doc_identificacion;
		}else{
			$id_documento=$id_tipo_doc_institucion;
		}
		if ($id_proveedor == "undefined" || $id_proveedor == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarProveedor("insert",$id_proveedor, $txt_codigo,$txt_observaciones,$txt_fecha_reg,$txt_id_institucion,$txt_id_persona);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_proveedor
			$res = $Custom -> InsertarProveedor(
		
			$id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
			$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
			$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    		$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    		$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre, $id_rubro,$id_documento,$doc_id, $nombre_institucion
			
			);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1] . " (iteración $cont)";
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				$resp->query = $Custom->query;
				echo $resp->get_mensaje();
				exit;
			}
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarProveedor("update",$id_proveedor, $txt_codigo, $txt_observaciones, $txt_fecha_reg, $txt_id_institucion, $txt_id_persona);

			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $Custom->salida[1];
				$resp->origen = $Custom->salida[2];
				$resp->proc = $Custom->salida[3];
				$resp->nivel = $Custom->salida[4];
				echo $resp->get_mensaje();
				exit;
			}


			$res = $Custom->ModificarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
			$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
			$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    		$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    		$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre, $id_rubro,$id_documento,$doc_id, $nombre_institucion
			);

			
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
		}

	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_proveedor";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $Custom->salida;

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", $total_registros);
	$resp->add_nodo("mensaje", $mensaje_exito);
	$resp->add_nodo("tiempo_resp", "200");
	echo $resp->get_mensaje();
	exit;
}
else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = "MENSAJE ERROR = Usuario no Autentificado";
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = "NIVEL = 1";
	echo $resp->get_mensaje();
	exit;
}
?>