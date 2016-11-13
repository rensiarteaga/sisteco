<?php
/*
**********************************************************
Nombre de archivo:	    ActionSaveActivoFijoCompCaract.php
Propósito:				Permite insertar y modificarActivoFijoCompCaract
Tabla:					taf_activo_fijo_comp_caract
Parámetros:				$hidden_id_activo_fijo_comp_caract	--> id del ActivoFijoCompCaract
						$descripcion
						

Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versión:				
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");


$CustomActivos = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionSaveProcesoMotivo.php';



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
			$hidden_id_activo_fijo_comp_caract = $_GET["hidden_id_activo_fijo_comp_caract_$j"];
			$txt_descripcion = $_GET["txt_descripcion_$j"];
			$txt_id_caracteristica = $_GET["txt_id_caracteristica_$j"];
			$txt_id_componente = $_GET["txt_id_componente_$j"];
			
		}
		else
		{
			$hidden_id_activo_fijo_comp_caract = $_POST["hidden_id_activo_fijo_comp_caract_$j"];
			$txt_descripcion = $_POST["txt_descripcion_$j"];
			$txt_id_caracteristica = $_POST["txt_id_caracteristica_$j"];
			$txt_id_componente = $_POST["txt_id_componente_$j"];
			
		}


		if ($hidden_id_activo_fijo_comp_caract == "undefined" || $hidden_id_activo_fijo_comp_caract =="")
		{
			///////////////////Inserción
			//Validación de datos (del lado del servidor)
			//echo $txt_descripcion."  ".$txt_id_fina_regi_prog_proy_acti."  ".$txt_id_proceso;
		
			$res = $CustomActivos->ValidarActivoFijoCompCaract("insert",$hidden_id_activo_fijo_comp_caract,$txt_descripcion,$txt_id_caracteristica,$txt_id_componente);
			
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

			$res = $CustomActivos ->CrearActivoFijoCompCaract($hidden_id_activo_fijo_comp_caract,$txt_descripcion,$txt_id_caracteristica,$txt_id_componente);
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
			$res = $CustomActivos->ValidarActivoFijoCompCaract("update",$hidden_id_activo_fijo_comp_caract,$txt_descripcion,$txt_id_caracteristica,$txt_id_componente);
			
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
			$res = $CustomActivos->ModificarActivoFijoCompCaract($hidden_id_activo_fijo_comp_caract,$txt_descripcion,$txt_id_caracteristica,$txt_id_componente);
			
			
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
	if($criterio_filtro == "") $criterio_filtro = "comp.id_componente= $txt_id_componente";

	
	
	$res = $CustomActivos->ContarListaActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	if($res) $total_registros = $CustomActivos->salida[0][0];

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