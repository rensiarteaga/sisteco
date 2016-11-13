<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegistroTransacion.php
Propósito:				Permite realizar el listado en tct_transaccion
Tabla:					tct_tct_transaccion
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:57:09
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarGestionarRegistroTransacion.php';

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

	//if($sort == '') $sortcol = 'traval.importe_debe desc , traval.importe_haber ';
	if($sort == '') $sortcol = 'id_transaccion ';
	else $sortcol = $sort;

	//if($dir == '') $sortdir = 'desc';
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
	if (sizeof($_GET) > 0){
	 
		$CantFiltros=$_GET["CantFiltros"];
		$nro_columnas=$_GET["nro_columnas"];		
		$titulo_reporte_excel=$_GET["titulo_reporte_excel"];		
		$get=true;
	}
	if (sizeof($_POST) > 0){
		$CantFiltros=$_POST["CantFiltros"];
		$nro_columnas=$_POST["nro_columnas"];	
		$titulo_reporte_excel=$_POST["titulo_reporte_excel"];		
		$get=false;
	}
	
	for($i=0;$i<$CantFiltros;$i++){ 		
		$cond->add_condicion_filtro($_GET["filterCol_$i"], $_GET["filterValue_$i"], $_GET["filterAvanzado_$i"]);
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	$cond->add_criterio_extra("id_comprobante",$m_id_combrobante);
	//$cond->add_criterio_extra("id_moneda",$m_id_moneda);
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	if($tipo=='libro_diario'){
		if($m_id_moneda==''){
			$criterio_filtro=$criterio_filtro. " AND id_moneda=1";
		}else {
		$criterio_filtro=$criterio_filtro. " AND id_moneda=$m_id_moneda";	
		}
		
	}
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Transaccion');
	$sortcol = $crit_sort->get_criterio_sort();
	
	if ($reporte_excel=='si')
	{	//recupera los valores de las columnas
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];		
		}	
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
		 
		$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		
		 $res = $Custom->ListarGestionarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$_GET['m_id_combrobante'],$_GET['m_id_moneda']);
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
	}else {
		//Obtiene el total de los registros
		$res = $Custom -> ContarRegistroTransacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_combrobante,$m_id_moneda);
	
		if($res) $total_registros= $Custom->salida;
	 	
		//Obtiene el conjunto de datos de la consulta
		$res = $Custom->ListarGestionarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_id_combrobante,$m_id_moneda);
		$total_debe=0;
		$total_haber=0;
		$total_gasto=0;
		$total_recurso=0;
		if($res){ 
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);
	
			foreach ($Custom->salida as $f){
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_transaccion',$f["id_transaccion"]);
				$xml->add_nodo('id_comprobante',$f["id_comprobante"]);
				$xml->add_nodo('desc_comprobante',$f["desc_comprobante"]);
				$xml->add_nodo('id_partida_cuenta',$f["id_partida_cuenta"]);
				$xml->add_nodo('desc_partida_cuenta',$f["desc_partida_cuenta"]);
				$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
				$xml->add_nodo('desc_auxiliar',$f["desc_auxiliar"]);
				$xml->add_nodo('id_orden_trabajo',$f["id_orden_trabajo"]);
				$xml->add_nodo('desc_orden_trabajo',$f["desc_orden_trabajo"]);
				$xml->add_nodo('id_oec',$f["id_oec"]);
				$xml->add_nodo('nombre_oec',$f["nombre_oec"]);
				$xml->add_nodo('concepto_tran',$f["concepto_tran"]);
				$xml->add_nodo('importe_debe',$f["importe_debe"]);
				$xml->add_nodo('importe_haber',$f["importe_haber"]);
				$xml->add_nodo('importe_gasto',$f["importe_gasto"]);
				$xml->add_nodo('importe_recurso',$f["importe_recurso"]);
				$xml->add_nodo('id_presupuesto',$f["id_presupuesto"]);
				$xml->add_nodo('desc_presupuesto',$f["desc_presupuesto"]);
				$xml->add_nodo('tipo_pres',$f["tipo_pres"]);
				$xml->add_nodo('sw_aux',$f["sw_aux"]);
				$xml->add_nodo('sw_oec',$f["sw_oec"]);
				$xml->add_nodo('sw_deha',$f["sw_de_ha"]);
				$xml->add_nodo('id_partida',$f["id_partida"]);
				$xml->add_nodo('id_cuenta',$f["id_cuenta"]);
				$xml->add_nodo('id_moneda',$f["id_moneda"]);
				$xml->add_nodo('nombre',$f["nombre"]);
				$xml->add_nodo('sw_rega',$f["sw_rega"]);
				$xml->add_nodo('disponibilidad',$f["disponibilidad"]);
			
				$xml->add_nodo('importe_gasto_flujo',$f["importe_gasto_flujo"]);
				$xml->add_nodo('importe_recurso_flujo',$f["importe_recurso_flujo"]);
				
				$xml->fin_rama();
				
				$total_debe=$total_debe+$f["importe_debe"];
				$total_haber=$total_haber+$f["importe_haber"];
				$total_gasto=$total_gasto+$f["importe_gasto"];
				$total_recurso=$total_recurso+$f["importe_recurso"];
			}
		 	if($total_registros>0){
				$xml->add_rama('ROWS');
				$xml->add_nodo('id_transaccion',"0");
				$xml->add_nodo('id_comprobante',"0");
				$xml->add_nodo('desc_comprobante',"");
				$xml->add_nodo('id_partida_cuenta',"0");
				$xml->add_nodo('desc_partida_cuenta',"");
				$xml->add_nodo('id_auxiliar',"0");
				$xml->add_nodo('desc_auxiliar',"");
				$xml->add_nodo('id_orden_trabajo',"0");
				$xml->add_nodo('desc_orden_trabajo',"");
				$xml->add_nodo('id_oec',"0");
				$xml->add_nodo('nombre_oec',"");
				$xml->add_nodo('concepto_tran',"");
				$xml->add_nodo('importe_debe',number_format($total_debe,2,'','.'));
				$xml->add_nodo('importe_haber',number_format($total_haber,2,'','.'));
				$xml->add_nodo('importe_gasto',number_format($total_gasto,2,'','.'));
				$xml->add_nodo('importe_recurso',number_format($total_recurso,2,'','.'));
				$xml->add_nodo('id_presupuesto',"0");
				$xml->add_nodo('desc_presupuesto',"");
				$xml->add_nodo('tipo_pres',0);
				$xml->add_nodo('sw_aux',0);
				$xml->add_nodo('sw_oec',0);
				$xml->add_nodo('sw_deha',0);
				$xml->add_nodo('id_partida',"0");
				$xml->add_nodo('id_cuenta',"0");
				$xml->add_nodo('id_moneda',"0");
				$xml->add_nodo('nombre',"0");
				$xml->add_nodo('sw_rega',"0");
				$xml->add_nodo('disponibilidad',"1");
				$xml->fin_rama();
		 	}
			$xml->mostrar_xml();
		}else{
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