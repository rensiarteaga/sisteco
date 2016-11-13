<?php
/*
**********************************************************
Nombre de archivo:	    ActionGuardarTipoActivoCuenta.php
Propósito:				modificar y registrar en actif.taf_tipo_activo_cuenta
Tabla:					actif.taf_tipo_activo_cuenta
Parámetros:				
						$id_tipo_activo_cuenta
						$id_tipo_activo
						$codigo_programa
						$cuenta_activo
						$cuenta_depacum 
						$cuenta_gasto

Valores de Retorno:    	Número de registros
Fecha de Creación:		
Versión:			
Autor:					
**********************************************************
*/
session_start();
include_once("../LibModeloActivoFijo.php");

$Custom = new cls_CustomDBActivoFijo();
$nombre_archivo = 'ActionGuardarGrupoProceso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
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
		$cont =  $_POST['cantidad_ids'];
		
		//Por Post siempre se decodifica
		$decodificar = true;
	}
	else
	{
		$resp = new cls_manejo_mensajes(true, "406");
		$resp->mensaje_error = "MENSAJE ERROR = No existen datos para el registro.";
		$resp->origen = "ORIGEN = $nombre_archivo";
		$resp->proc = "PROC = $nombre_archivo";
		$resp->nivel = 'NIVEL = 4';
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
			$id_tipo_activo_cuenta=$_GET["id_tipo_activo_cuenta_$j"];
			$id_tipo_activo=$_GET["id_tipo_activo_$j"];
			$descripcion_programa=$_GET["descripcion_programa_$j"];
			$cuenta_activo=$_GET["cuenta_activo_$j"];
			$cuenta_depacum=$_GET["cuenta_dep_acumulada_$j"];
			$cuenta_gasto=$_GET["cuenta_gasto_$j"];
			$cuenta_activo_auxiliar=$_GET["hidden_aux_cta_activo_$j"];
			$cuenta_dep_acumulada_auxiliar=$_GET["hidden_aux_cta_dep_acumulada_$j"];
			$cuenta_gasto_auxiliar=$_GET["hidden_aux_cta_gasto_$j"];
			$id_tension1=$_GET["id_tension1_$j"];
			$id_tension2=$_GET["id_tension2_$j"];
			$id_tension3=$_GET["id_tension3_$j"];
		
		}
		else
		{
			//se verifica  el codigo programa, para determinar  el campo descripcion_programa de la tabla actif.taf_tipo_activo_cuenta
			$id_tipo_activo_cuenta=$_POST["id_tipo_activo_cuenta_$j"];
			$id_tipo_activo=$_POST["id_tipo_activo_$j"];
			$descripcion_programa=$_POST["descripcion_programa_$j"];
			$cuenta_activo=$_POST["cuenta_activo_$j"];
			$cuenta_depacum=$_POST["cuenta_dep_acumulada_$j"];
			$cuenta_gasto=$_POST["cuenta_gasto_$j"];
			$cuenta_activo_auxiliar=$_POST["hidden_aux_cta_activo_$j"];
			$cuenta_dep_acumulada_auxiliar=$_POST["hidden_aux_cta_dep_acumulada_$j"];
			$cuenta_gasto_auxiliar=$_POST["hidden_aux_cta_gasto_$j"];
			$id_tension1=$_POST["id_tension1_$j"];
			$id_tension2=$_POST["id_tension2_$j"];
			$id_tension3=$_POST["id_tension3_$j"];		
		} 
		
			//if(	strcasecmp($id_tension1,'') !=0	){$id_tension=$id_tension1;}
			//if(	strcasecmp($id_tension2,'') !=0	){$id_tension=$id_tension2;}
			//if(	strcasecmp($id_tension3,'') !=0	){$id_tension=$id_tension3;}
			
			//if (strlen($id_tension1) > 0 )$id_tension=$id_tension1;
			//if (strlen($id_tension2) > 0 )$id_tension=$id_tension2;
			//if (strlen($id_tension3) > 0 )$id_tension=$id_tension3;
			$id_tension=trim($id_tension1.$id_tension2.$id_tension3);
			//echo $cuenta_activo;exit;
		//se verifica  el codigo programa, para determinar  el campo descripcion_programa de la tabla actif.taf_tipo_activo_cuenta
		switch ($descripcion_programa)
		{
			case "Bienes de uso Administracion Central":
			$codigo_programa='ADM';
			break;
			case "Transmision":
			$codigo_programa='TRA';
			break;
			case "Generacion":
			$codigo_programa='GEN';
			break;
			case "Distribucion":
			$codigo_programa='DIS';
			break;
			default:
			$codigo_programa='ADM';
			break;
		}
		
		if ($id_tipo_activo_cuenta== "undefined" || $id_tipo_activo_cuenta== "")
		{ 
			//no es necesario validar los datos q se registraran pues los mismos se obtienen apartir desde combos listados desde otro esquema de la BD
			$res = $Custom -> InsertarTipoActivoCuenta($id_tipo_activo_cuenta,$id_tipo_activo,$codigo_programa,$descripcion_programa,$cuenta_activo,$cuenta_depacum,$cuenta_gasto,$cuenta_activo_auxiliar,$cuenta_dep_acumulada_auxiliar,$cuenta_gasto_auxiliar,$id_tension);
	
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
		{	
//	
			$res = $Custom->ModificarTipoActivoCuenta($id_tipo_activo_cuenta,$id_tipo_activo,$codigo_programa,$descripcion_programa,$cuenta_activo,$cuenta_depacum,$cuenta_gasto,$cuenta_activo_auxiliar,$cuenta_dep_acumulada_auxiliar,$cuenta_gasto_auxiliar,$id_tension);
			
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
	if($cont > 1) $mensaje_exito = 'Se guardaron todos los datos.';
	else $mensaje_exito = $Custom->salida[1];

	//Obtiene el total de los registros. Parámetros del filtro
	if($cant == "") $cant = 100;
	if($puntero == "") $puntero = 0;
	if($sortcol == "") $sortcol = '';
	if($sortdir == "") $sortdir = 'asc';
	if($criterio_filtro == "") $criterio_filtro = '0=0';

	$res = $Custom->CountTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
	if($res) $total_registros = $Custom->salida;

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