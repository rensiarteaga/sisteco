<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarNuevoProveedor.php
Propósito:				Permite insertar y modificar datos en la tabla tad_proveedor
Tabla:					tad_tad_proveedor
Parámetros:				$codigo
						$observaciones
						$nombre_pago
						$doc_id
						$nombre
						$casilla
						$telefono1
						$telefono2
						$celular1
						$celular2
						$fax
						$email1
						$email2
						$pag_web
						$id_tipo_doc_institucion
						$apellido_paterno
						$apellido_materno
						$nombre
						$doc_id
						$casilla
						$telefono1
						$telefono2
						$celular1
						$celular2
						$pag_web
						$email1
						$email2
						$id_tipo_doc_identificacion
						$tipo_contacto
						$apellido_paterno
						$apellido_materno
						$nombre
						$telefono1
						$celular1
						$celular2
						$email1
						$email2

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-15 12:05:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarNuevoProveedor.php";

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

      if ($get)
		{
			$codigo= $_GET["codigo"];
			$observaciones= $_GET["observaciones"];
			$nombre_pago= $_GET["nombre_pago"];
			$doc_id= $_GET["doc_id"];
			$nombre= $_GET["nombre_ins"];
			$casilla= $_GET["casilla"];
			$telefono1= $_GET["telefono1"];
			$telefono2= $_GET["telefono2"];
			$celular1= $_GET["celular1"];
			$celular2= $_GET["celular2"];
			$fax= $_GET["fax"];
			$email1= $_GET["email1"];
			$email2= $_GET["email2"];
			$pag_web= $_GET["pag_web"];
			$id_tipo_doc_institucion= $_GET["id_tipo_doc_institucion"];
			$apellido_paterno= $_GET["apellido_paterno"];
			$apellido_materno= $_GET["apellido_materno"];
			$nombre_p= $_GET["nombre_p"];
			$doc_id_p= $_GET["doc_id_p"];
			$casilla_p= $_GET["casilla_p"];
			$telefono1_p= $_GET["telefono1_p"];
			$telefono2_p= $_GET["telefono2_p"];
			$celular1_p= $_GET["celular1_p"];
			$celular2_p= $_GET["celular2_p"];
			$pag_web_p= $_GET["pag_web_p"];
			$email1_p= $_GET["email1_p"];
			$email2_p= $_GET["email2_p"];
			$id_tipo_doc_identificacion= $_GET["id_tipo_doc_identificacion"];
			$tipo_contacto= $_GET["tipo_contacto"];
			$apellido_paterno_c= $_GET["apellido_paterno_c"];
			$apellido_materno_c= $_GET["apellido_materno_c"];
			$nombre_c= $_GET["nombre_c"];
			$telefono1_c= $_GET["telefono1_c"];
			$celular1_c= $_GET["celular1_c"];
			$celular2_c= $_GET["celular2_c"];
			$email1_c= $_GET["email1_c"];
			$email2_c= $_GET["email2_c"];
			$id_cuenta= $_GET["id_cuenta"];
			$id_auxiliar= $_GET["id_auxiliar"];
			$direccion_ins= $_GET["direccion_ins"];
			$direccion_p= $_GET["direccion_p"];
			$direccion_c= $_GET["direccion_c"];
			
			$id_depto= $_GET["id_depto"];
			$rubro= $_GET["rubro"];
			$rubro1= $_GET["rubro1"];
			$rubro2= $_GET["rubro2"];

		}
		else
		{
			$codigo= $_POST["codigo"];
			$observaciones= $_POST["observaciones"];
			$nombre_pago= $_POST["nombre_pago"];
			$doc_id= $_POST["doc_id"];
			$nombre= $_POST["nombre_ins"];
			$casilla= $_POST["casilla"];
			$telefono1= $_POST["telefono1"];
			$telefono2= $_POST["telefono2"];
			$celular1= $_POST["celular1"];
			$celular2= $_POST["celular2"];
			$fax= $_POST["fax"];
			$email1= $_POST["email1"];
			$email2= $_POST["email2"];
			$pag_web= $_POST["pag_web"];
			$id_tipo_doc_institucion= $_POST["id_tipo_doc_institucion"];
			$apellido_paterno= $_POST["apellido_paterno"];
			$apellido_materno= $_POST["apellido_materno"];
			$nombre_p= $_POST["nombre_p"];
			$doc_id_p= $_POST["doc_id_p"];
			$casilla_p= $_POST["casilla_p"];
			$telefono1_p= $_POST["telefono1_p"];
			$telefono2_p= $_POST["telefono2_p"];
			$celular1_p= $_POST["celular1_p"];
			$celular2_p= $_POST["celular2_p"];
			$pag_web_p= $_POST["pag_web_p"];
			$email1_p= $_POST["email1_p"];
			$email2_p= $_POST["email2_p"];
			$id_tipo_doc_identificacion= $_POST["id_tipo_doc_identificacion"];
			$tipo_contacto= $_POST["tipo_contacto"];
			$apellido_paterno_c= $_POST["apellido_paterno_c"];
			$apellido_materno_c= $_POST["apellido_materno_c"];
			$nombre_c= $_POST["nombre_c"];
			$telefono1_c= $_POST["telefono1_c"];
			$celular1_c= $_POST["celular1_c"];
			$celular2_c= $_POST["celular2_c"];
			$email1_c= $_POST["email1_c"];
			$email2_c= $_POST["email2_c"];
			$id_cuenta= $_POST["id_cuenta"];
			$id_auxiliar= $_POST["id_auxiliar"];
			$direccion_ins= $_POST["direccion_ins"];
			$direccion_p= $_POST["direccion_p"];
			$direccion_c= $_POST["direccion_c"];
			
			$id_depto= $_POST["id_depto"];
			$rubro= $_POST["rubro"];
			$rubro1= $_POST["rubro1"];
			$rubro2= $_POST["rubro2"];

		}

		////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarNuevoProveedor("insert",$codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c);

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
			$res = $Custom -> InsertarNuevoProveedor($codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c,$tipo_proveedor,$con_contacto,$id_cuenta,$id_auxiliar,$direccion_ins,$direccion_p,$direccion_c,$id_depto,$rubro,$rubro1,$rubro2);

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
		

	

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	

	//Arma el xml para desplegar el mensaje
	$resp = new cls_manejo_mensajes(false);
	$resp->add_nodo("TotalCount", 1);
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