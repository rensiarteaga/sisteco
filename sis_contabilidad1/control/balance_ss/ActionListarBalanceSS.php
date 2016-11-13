<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarBalanceSS.php
Propósito:				Permite realizar el listado del reporte balance_ss
Tabla:					tct_cuenta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2009-06-19 17:01:29
Versión:				1.0.0
Autor:					Avq
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarBalanceSS.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'nro_cuenta';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod)
	{
		case 'si':
			$decodificar = true;
			break;
		case 'no':
			$decodificar = false;
			break;
		default:
			$decodificar = true;
			break;
	}

	//Verifica si se manda la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	/*echo "parametro".$id_parametro;
	echo "moneda".$id_moneda;
	echo"nivel".$nivel;
	echo "fecha".$fecha;
	echo "id_depto_conta".$id_depto_conta;
	exit;*/
 
	//Obtiene el total de los registros
 $res = $Custom -> ContarBalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin,$id_depto_conta);
//$res=true;
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res=$Custom->BalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin,$id_depto_conta);
	
	if($res)
	{	$contador=0;
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);
		
		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('suma_debe',$f["suma_debe"]);
			$xml->add_nodo('suma_haber',$f["suma_haber"]);
			$xml->add_nodo('saldo',$f["saldo"]);
			$xml->add_nodo('sw_transaccional',$f["sw_transaccional"]);
			$xml->add_nodo('nivel_cuenta',$f["nivel_cuenta"]);
			$xml->fin_rama();
		$contador++;
		}
		$xml->mostrar_xml();
	}
	else
	{
		//Se produjo un error
		$resp = new cls_manejo_mensajes(true,'406');
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
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>
