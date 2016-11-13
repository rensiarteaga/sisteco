<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarMemoriaGasto.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_mem_inversion_gasto
Tabla:					tpr_tpr_mem_inversion_gasto
Parámetros:				$id_mem_inversion_gasto
						$cantidad
						$costo_unitario
						$periodo_pres
						$tipo_mem
						$id_memoria_calculo
						$id_moneda

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-10 09:08:20
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarMemoriaGasto.php";

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
			$id_mem_inversion_gasto= $_GET["id_mem_inversion_gasto_$j"];
			$cantidad= $_GET["cantidad_$j"];
			$costo_unitario= $_GET["costo_unitario_$j"];
			$periodo_pres= $_GET["periodo_pres_$j"];
			$tipo_mem= $_GET["tipo_mem_$j"];
			$id_memoria_calculo= $_GET["id_memoria_calculo_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$total_general= $_GET["total_general_$j"];
			$tipo_insercion=$_GET["tipo_insercion_$j"];

		}
		else
		{
			$id_mem_inversion_gasto=$_POST["id_mem_inversion_gasto_$j"];
			$cantidad=$_POST["cantidad_$j"];
			$costo_unitario=$_POST["costo_unitario_$j"];
			$periodo_pres=$_POST["periodo_pres_$j"];
			$tipo_mem=$_POST["tipo_mem_$j"];
			$id_memoria_calculo=$_POST["id_memoria_calculo_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$total_general= $_POST["total_general_$j"];
			$tipo_insercion=$_POST["tipo_insercion_$j"];

		}
		
		if ($tipo_insercion == "undefined" || $tipo_insercion == "")
		{
			$tipo_insercion=1;
		}

		if ($id_mem_inversion_gasto == "undefined" || $id_mem_inversion_gasto == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarMemoriaGasto("insert",$id_mem_inversion_gasto, $cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_mem_inversion_gasto
			$res = $Custom -> InsertarMemoriaGasto($id_mem_inversion_gasto, $cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);

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
			$res = $Custom->ValidarMemoriaGasto("update",$id_mem_inversion_gasto, $cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general);

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

			$res = $Custom->ModificarMemoriaGasto($id_mem_inversion_gasto, $cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);

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
	if($sortcol == "") $sortcol = "id_mem_inversion_gasto";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "MEMING.id_memoria_calculo=''$m_id_memoria_calculo''";

	$res = $Custom->ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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