<?php
/*
**********************************************************
Nombre de archivo:	    ActionSaveMetodoDepreciacion.php
Propósito:				Permite insertar y modificar metodos de depreciacion
Tabla:					taf_metodo_depreciacion
Parámetros:				$hidden_id_metodo_depreciacion	--> id del metodo de depreciacion
						$descripcion
						$txt_id_usuario_asignacion

Valores de Retorno:    	Número de registros
Fecha de Creación:		24-05-2007
Versión:				
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveEstadoFuncional.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	//Verifica si los datos vienen por post o get
	if (sizeof($_GET) >0)
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
	elseif(sizeof($_POST) >0)
	{
		$get=false;
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para almacenar";
		$resp->origen = "ORIGEN= $nombre_archivo";
		$resp->proc = "PROC =$nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
		echo $resp->get_mensaje();
		exit;
	}
	
	//Envia al Custom la bandera que indica si se decodificará o no
	$CustomActivos->decodificar = $decodificar;

	//Realiza el bucle por todos los ids mandados
	for($j = 0;$j < $cont; $j++)
	{
		if ($get)
		{
			$id_estado_funcional = $_GET["id_estado_funcional_$j"];
			$codigo = $_GET["codigo_$j"];
			$descripcion = $_GET["descripcion_$j"];
			$estado = $_GET["estado_$j"];		
		}
		else
		{
			$id_estado_funcional = $_POST["id_estado_funcional_$j"];
			$codigo = $_POST["codigo_$j"];
			$descripcion = $_POST["descripcion_$j"];
			$estado = $_POST["estado_$j"];	
		}


		if ($id_estado_funcional == "undefined" || $id_estado_funcional =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
		   
			$res = $CustomActivos->ValidarEstadoFuncional("insert",$id_estado_funcional,$codigo,$descripcion,$estado);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
				
							
			}

			$res = $CustomActivos ->CrearEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado);
			if(!$res)
			{
				//Se produjo un error
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
			
		}
		else
		{	//Modificación
			//Validación de datos (del lado del servidor)
			$res = $CustomActivos->ValidarEstadoFuncional("update",$id_estado_funcional,$codigo,$descripcion,$estado);
			if(!$res)
			{
				//Error de validación
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				echo $resp->get_mensaje();
				exit;
			}
								
			$res = $CustomActivos->ModificarEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado);
			if(!$res)
			{
				$resp = new cls_manejo_mensajes(true, "406");
				$resp->mensaje_error = $CustomActivos->salida[1];
				$resp->origen = $CustomActivos->salida[2];
				$resp->proc = $CustomActivos->salida[3];
				$resp->nivel = $CustomActivos->salida[4];
				$resp->query = $CustomActivos->query;
				echo $resp->get_mensaje();
				exit;
			}
		}

	}//END FOR

	/***************no entra aqui cuando es $_GET*************/
	///Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $CustomActivos->salida[1];
	
	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = 'nombres';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $CustomActivos->ContarListaEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $CustomActivos->salida;

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