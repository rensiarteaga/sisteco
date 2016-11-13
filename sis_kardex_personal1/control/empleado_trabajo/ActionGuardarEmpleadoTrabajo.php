<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarempleado_empleado_trabajo.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_empleado_trabajo
Tabla:					tkp_empleado_trabajo
Parámetros:				$tkp_id_empleado_trabajo, nombre, fecha_reg, estado_reg
						

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2010-08-11
Versión:				1.0.0
Autor:					Mercedes Zambrana Meneses
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarEmpleado_trabajo.php";

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
			$id_empleado_trabajo=$_GET["id_empleado_trabajo_$j"];
			$descripcion=$_GET["descripcion_$j"];
			$id_institucion=$_GET["id_institucion_$j"];
			$tipo_institucion=$_GET["tipo_institucion_$j"];
			$cargo=$_GET["cargo_$j"];
			$fecha_ini= $_GET["fecha_ini_$j"];
			$fecha_fin= $_GET["fecha_fin_$j"];
			$id_empleado= $_GET["id_empleado_$j"];
			$nombre_institucion= $_GET["nombre_institucion_$j"];
			$direccion_institucion= $_GET["direccion_institucion_$j"];
			$id_persona= $_GET["id_persona_$j"];
		}
		else
		{
			
			$id_empleado_trabajo=$_POST["id_empleado_trabajo_$j"];
			$descripcion=$_POST["descripcion_$j"];
			$id_institucion=$_POST["id_institucion_$j"];
			$tipo_institucion=$_POST["tipo_institucion_$j"];
			$cargo=$_POST["cargo_$j"];
			$fecha_ini= $_POST["fecha_ini_$j"];
			$fecha_fin= $_POST["fecha_fin_$j"];
			$id_empleado= $_POST["id_empleado_$j"];
			$nombre_institucion= $_POST["nombre_institucion_$j"];
			$direccion_institucion= $_POST["direccion_institucion_$j"];
			$id_persona= $_POST["id_persona_$j"];
		}
	    
               
		if ($id_empleado_trabajo == "undefined" || $id_empleado_trabajo== "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarEmpleadoTrabajo("insert",$id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado);

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
			
			//Validación satisfactoria, se ejecuta la inserción en la tabla tsg_persona y tkp_relacion_familiar
			$res = $Custom -> InsertarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona);
			
				if(!$res){
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
			$res = $Custom->ValidarEmpleadoTrabajo("update",$id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado);

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

			$res = $Custom->ModificarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona);

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
	if($sortcol == "") $sortcol = "id_empleado_trabajo";
	if($sortdir == "") $sortdir = "asc";
//	if($criterio_filtro == "") $criterio_filtro = "EMPLEA.id_empleado=''$m_id_empleado''";
	
	if($m_id_persona>0){
		if($criterio_filtro == "") $criterio_filtro = "PERSON.id_persona=''$m_id_persona''";
	}
	if($m_id_empleado>0){
		if($criterio_filtro == "") $criterio_filtro = "EMPLEA.id_empleado=''$m_id_empleado''";
	}

	$res = $Custom->ContarEmpleadoTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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