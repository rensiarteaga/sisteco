<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarRrhhGasto.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_mem_rrhh
Tabla:					tpr_tpr_mem_rrhh
Parámetros:				$id_mem_rrhh
						$periodo_pres
						$id_memoria_calculo
						$id_moneda

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-10 09:08:19
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarRrhhGasto.php";

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
			$id_mem_rrhh= $_GET["id_mem_rrhh_$j"];
			$periodo_pres= $_GET["periodo_pres_$j"];
			$id_memoria_calculo= $_GET["id_memoria_calculo_$j"];
			$id_moneda= $_GET["id_moneda_$j"];
			$total_general= $_GET["total_general_$j"];
			$tipo_insercion=$_GET["tipo_insercion_$j"];
			$mes_01 = $_GET["mes_01"];
			$mes_02 = $_GET["mes_02"];
			$mes_03 = $_GET["mes_03"];
			$mes_04 = $_GET["mes_04"];
			$mes_05 = $_GET["mes_05"];
			$mes_06 = $_GET["mes_06"];
			$mes_07 = $_GET["mes_07"];
			$mes_08 = $_GET["mes_08"];
			$mes_09 = $_GET["mes_09"];
			$mes_10 = $_GET["mes_10"];
			$mes_11 = $_GET["mes_11"];
			$mes_12 = $_GET["mes_12"];
			$total = $_GET["total"];
		}
		else
		{
			$id_mem_rrhh=$_POST["id_mem_rrhh_$j"];
			$periodo_pres=$_POST["periodo_pres_$j"];
			$id_memoria_calculo=$_POST["id_memoria_calculo_$j"];
			$id_moneda=$_POST["id_moneda_$j"];
			$total_general= $_POST["total_general_$j"];
			$tipo_insercion=$_POST["tipo_insercion_$j"];
			$mes_01 = $_POST["mes_01"];
			$mes_02 = $_POST["mes_02"];
			$mes_03 = $_POST["mes_03"];
			$mes_04 = $_POST["mes_04"];
			$mes_05 = $_POST["mes_05"];
			$mes_06 = $_POST["mes_06"];
			$mes_07 = $_POST["mes_07"];
			$mes_08 = $_POST["mes_08"];
			$mes_09 = $_POST["mes_09"];
			$mes_10 = $_POST["mes_10"];
			$mes_11 = $_POST["mes_11"];
			$mes_12 = $_POST["mes_12"];
			$total = $_POST["total"];
		}
		
		$meses[0] = 0;
		$meses[1] = $mes_01;
		$meses[2] = $mes_02;
		$meses[3] = $mes_03;
		$meses[4] = $mes_04;
		$meses[5] = $mes_05;
		$meses[6] = $mes_06;
		$meses[7] = $mes_07;
		$meses[8] = $mes_08;
		$meses[9] = $mes_09;
		$meses[10] = $mes_10;
		$meses[11] = $mes_11;
		$meses[12] = $mes_12;

		if ($tipo_insercion == "undefined" || $tipo_insercion == "")
		{
			$tipo_insercion=1;
		}
		
		if ($id_mem_rrhh == "undefined" || $id_mem_rrhh == "")
		{
			////////////////////Inserción/////////////////////
			for($i = 1; $i <= 12; $i++)
			{
				if($meses[$i] != 0)	
				{
					$periodo_pres = $i;
					$total_general = $meses[$i];
					
					//Validación de datos (del lado del servidor)
					$res = $Custom->ValidarRrhhGasto("insert",$id_mem_rrhh, $periodo_pres,$id_memoria_calculo,$id_moneda,$total_general);
		
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
		
					//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_mem_rrhh
					$res = $Custom -> InsertarRrhhGasto($id_mem_rrhh, $periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		
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
		}
		else
		{	///////////////////////Modificación////////////////////
			
			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarRrhhGasto("update",$id_mem_rrhh, $periodo_pres,$id_memoria_calculo,$id_moneda,$total_general);

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

			$res = $Custom->ModificarRrhhGasto($id_mem_rrhh, $periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);

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
	if($sortcol == "") $sortcol = "id_mem_rrhh";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "MEMCAL.id_memoria_calculo=''$id_memoria_calculo''";

	$res = $Custom->ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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