<?php
/**
**********************************************************
Nombre de archivo:	    ActionGuardarParametro.php
Propósito:				Permite insertar y modificar datos en la tabla tpr_parametro
Tabla:					tpr_tpr_parametro
Parámetros:				$id_parametro
						$gestion_pres
						$estado_gral
						$cod_institucional
						$porcentaje_sobregiro
						$cantidad_niveles

Valores de Retorno:    	Número de registros guardados
Fecha de Creación:		2008-07-02 22:23:50
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = "ActionGuardarParametro.php";

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
			$id_parametro= $_GET["id_parametro_$j"];
			$gestion_pres= $_GET["gestion_pres_$j"];
			$estado_gral= $_GET["estado_gral_$j"];
			$cod_institucional= $_GET["cod_institucional_$j"];
			$porcentaje_sobregiro= $_GET["porcentaje_sobregiro_$j"];
			$niveles_recurso= $_GET["niveles_recurso_$j"];
			$niveles_gasto= $_GET["niveles_gasto_$j"];
			$cod_formulario_gasto= $_GET["cod_formulario_gasto_$j"];
			$cod_formulario_recurso= $_GET["cod_formulario_recurso_$j"];
			$id_gestion= $_GET["id_gestion_$j"];
			$mod_inversion= $_GET["mod_inversion_$j"];
		}
		else
		{
			$id_parametro=$_POST["id_parametro_$j"];
			$gestion_pres=$_POST["gestion_pres_$j"];
			$estado_gral=$_POST["estado_gral_$j"];
			$cod_institucional=$_POST["cod_institucional_$j"];
			$porcentaje_sobregiro=$_POST["porcentaje_sobregiro_$j"];
			$niveles_recurso=$_POST["niveles_recurso_$j"];
			$niveles_gasto=$_POST["niveles_gasto_$j"];
			$cod_formulario_gasto= $_POST["cod_formulario_gasto_$j"];
			$cod_formulario_recurso= $_POST["cod_formulario_recurso_$j"];
			$id_gestion= $_POST["id_gestion_$j"];
			$mod_inversion= $_POST["mod_inversion_$j"];
		}

		if ($id_parametro == "undefined" || $id_parametro == "")
		{
			////////////////////Inserción/////////////////////

			//Validación de datos (del lado del servidor)
			$res = $Custom->ValidarParametro("insert",$id_parametro, $gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);

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

			//Validación satisfactoria, se ejecuta la inserción en la tabla tpr_parametro
			$res = $Custom -> InsertarParametro($id_parametro, $gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);

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
			
			if($accion == "undefined" || $accion == "")
			{			
				//Validación de datos (del lado del servidor)
				$res = $Custom->ValidarParametro("update",$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);
	
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
	
				$res = $Custom->ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);
	
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
			else
			{
				if($accion=='aprobar')
				{
					$res = $Custom->AprobarParametro($id_parametro,$estado_gral);
	
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
				if($accion=='cerrar')
				{
					$res = $Custom->CerrarParametro($id_parametro,$estado_gral);
	
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
				if($accion=='migrar')
				{
					$res = $Custom->MigrarParametro($id_parametro,$estado_gral);
	
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
			} 	
		}
	}//END FOR

	//Guarda el mensaje de éxito de la operación realizada
	if($cont > 1) $mensaje_exito = "Se guardaron todos los datos.";
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = "id_parametro";
	if($sortdir == "") $sortdir = "asc";
	if($criterio_filtro == "") $criterio_filtro = "0=0";

	$res = $Custom->ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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