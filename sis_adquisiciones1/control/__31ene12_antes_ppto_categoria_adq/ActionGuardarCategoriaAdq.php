<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarCategoriaAdq.php
Propósito:				Permite insertar y modificar datos en la tabla tad_categoria_adq
Tabla:					tad_tad_categoria_adq
Parámetros:				$id_categoria_adq
						$nombre
						$observaciones
						$descripcion
						$fecha_reg
						$precio_min
						$precio_max
						$id_moneda

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-14 16:23:16
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloAdquisiciones.php");

$Custom = new cls_CustomDBAdquisiciones();
$nombre_archivo = "ActionGuardarCategoriaAdq.php";

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
			$id_categoria_adq= $_GET["id_categoria_adq_$j"];
			$nombre= $_GET["nombre_$j"];
			$observaciones= $_GET["observaciones_$j"];
			$descripcion= $_GET["descripcion_$j"];
			$fecha_reg= $_GET["fecha_reg_$j"];
			$precio_min= $_GET["precio_min_$j"];
			$precio_max= $_GET["precio_max_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$norma= $_GET["norma_$j"];
			$simplificada= $_GET["simplificada_$j"];
			$defecto= $_GET["defecto_$j"];

		}
		else
		{
			$id_categoria_adq=$_POST["id_categoria_adq_$j"];
			$nombre=$_POST["nombre_$j"];
			$observaciones=$_POST["observaciones_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$fecha_reg=$_POST["fecha_reg_$j"];
			$precio_min=$_POST["precio_min_$j"];
			$precio_max=$_POST["precio_max_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$norma= $_POST["norma_$j"];
			$simplificada= $_POST["simplificada_$j"];
			$defecto= $_POST["defecto_$j"];

		}

		
		
		
		if ($id_categoria_adq == "undefined" || $id_categoria_adq == "")
		{
			////////////////////Inserción/////////////////////
			if($clon=='si'){
				$res = $Custom->ClonarCategoriaAdq($m_id_categoria_adq);

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
			}else{
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCategoriaAdq("insert",$id_categoria_adq, $nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tad_categoria_adq
			$res = $Custom -> InsertarCategoriaAdq($id_categoria_adq, $nombre, $observaciones, $descripcion, $fecha_reg, $precio_min, $precio_max, $id_moneda,$norma,$simplificada,$defecto);

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
		}
		else
		{	///////////////////////Modificación////////////////////
			
			
			
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarCategoriaAdq("update",$id_categoria_adq, $nombre, $observaciones, $descripcion, $fecha_reg, $precio_min, $precio_max, $id_moneda,$norma,$simplificada,$defecto);

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

			$res = $Custom->ModificarCategoriaAdq($id_categoria_adq, $nombre, $observaciones, $descripcion, $fecha_reg, $precio_min, $precio_max, $id_moneda,$norma,$simplificada,$defecto);

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
	if($sortcol == "") $sortcol = "id_categoria_adq";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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