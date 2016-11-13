<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarCheque.php
Propósito:				Permite realizar el listado en tct_cheque
Tabla:					tct_tct_cheque
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-17 11:24:35
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarCierreApertura.php';

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

	if($sort == '') $sortcol = 'ciap.id_cierre_apertura';
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
 
	if($m_id_depto_conta!=''){		
	     $criterio_filtro=$criterio_filtro." AND ciap.id_depto_conta = $m_id_depto_conta";
	      
	}
 
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'');
	
	$sortcol = $crit_sort->get_criterio_sort();
	
	

	//Obtiene el total de los registros
	$res = $Custom -> ContarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cierre_apertura',$f["id_cierre_apertura"]);
			$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
			$xml->add_nodo('descripcion',$f["descripcion"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('id_gestion_actual',$f["id_gestion_actual"]);
			$xml->add_nodo('gestion_actual',$f["gestion_actual"]);
			$xml->add_nodo('id_gestion_nueva',$f["id_gestion_nueva"]);
			$xml->add_nodo('gestion_nueva',$f["gestion_nueva"]);
			$xml->add_nodo('sw_volcar',$f["sw_volcar"]);
			$xml->add_nodo('sw_siguiente_gestion',$f["sw_siguiente_gestion"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('nombre',$f["nombre"]);
			$xml->add_nodo('sw_actualizacion',$f["sw_actualizacion"]);
			$xml->add_nodo('sw_estado',$f["sw_estado"]);
			$xml->add_nodo('id_reporte_eeff',$f["id_reporte_eeff"]);
			$xml->add_nodo('nombre_eeff',$f["nombre_eeff"]);
			$xml->add_nodo('id_cuenta_diferencia',$f["id_cuenta_diferencia"]);
			$xml->add_nodo('cuenta',$f["cuenta"]);
			$xml->add_nodo('id_depto_conta',$f["id_depto_conta"]);
			 
 
         $xml->fin_rama();
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