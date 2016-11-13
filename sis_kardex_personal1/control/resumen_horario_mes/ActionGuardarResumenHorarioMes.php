<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarResumenHorarioMes.php
Propósito:				Permite insertar y modificar datos en la tabla tkp_resumen_horario_mes
Tabla:					tkp_resumen_horario_mes
Parámetros:				
						
Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-05-12 09:24:17
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = "ActionGuardarResumenHorarioMes.php";

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
			$hidden_id_resumen_horario_mes= $_GET["hidden_id_resumen_horario_mes_$j"];
			$hidden_id_empleado_planilla= $_GET["hidden_id_empleado_planilla_$j"];
			$hidden_id_empleado_planilla_f= $_GET["hidden_id_empleado_planilla_f_$j"];
			$horas_disp= $_GET["horas_disp_$j"];
			$horas_extra= $_GET["horas_extra_$j"];
			$horas_nocturnas= $_GET["horas_nocturnas_$j"];
			$horas_normales_efectivas= $_GET["horas_normales_efectivas_$j"];
			$costo_horas_disp= $_GET["costo_horas_disp_$j"];
			$costo_horas_normales= $_GET["costo_horas_normales_efectivas_$j"];
			$costo_horas_extra= $_GET["costo_horas_extra_$j"];
			$costo_horas_nocturnas= $_GET["costo_horas_nocturnas_$j"];
			$horas_normales= $_GET["horas_normales_$j"];
			$id_planilla= $_GET["m_id_planilla"];
		}
		else
		{
			$hidden_id_resumen_horario_mes= $_POST["hidden_id_resumen_horario_mes_$j"];
			$hidden_id_empleado_planilla= $_POST["hidden_id_empleado_planilla_$j"];
			$hidden_id_empleado_planilla_f= $_POST["hidden_id_empleado_planilla_f_$j"];
			$horas_disp= $_POST["horas_disp_$j"];
			$horas_extra= $_POST["horas_extra_$j"];
			$horas_nocturnas= $_POST["horas_nocturnas_$j"];
			$horas_normales_efectivas= $_POST["horas_normales_efectivas_$j"];
			$costo_horas_disp= $_POST["costo_horas_disp_$j"];
			$costo_horas_normales= $_POST["costo_horas_normales_efectivas_$j"];
			$costo_horas_extra= $_POST["costo_horas_extra_$j"];
			$costo_horas_nocturnas= $_POST["costo_horas_nocturnas_$j"];
			$horas_normales= $_POST["horas_normales_$j"];
			$id_planilla= $_POST["m_id_planilla"];
		}

		if ($hidden_id_resumen_horario_mes == "undefined" || $hidden_id_resumen_horario_mes == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom -> InsertarResumenHorarioMes($hidden_id_resumen_horario_mes,$hidden_id_empleado_planilla_f,$id_planilla);

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
			$res = $Custom->ValidarEmpleadoHorario("update",$hidden_id_resumen_horario_mes, $hidden_id_empleado_planilla,$horas_disp,$horas_normales,$horas_extra,$horas_nocturnas);

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

			$res = $Custom->ModificarResumenHorarioMes($hidden_id_resumen_horario_mes, $hidden_id_empleado_planilla,$horas_disp,$horas_normales,$horas_extra,$horas_nocturnas,$costo_horas_normales,$costo_horas_extra,$costo_horas_nocturnas,$costo_horas_disp,$horas_normales_efectivas);

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
	if($sortcol == "") $sortcol = "RESHORMES.fecha_reg";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "RESHORMES.id_planilla=''$m_id_planilla''";

	$res = $Custom->ContarResumenHorarioMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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