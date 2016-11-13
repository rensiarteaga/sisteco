<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarPartidaCuenta.php
Propósito:				Permite realizar el listado en tpr_partida_cuenta
Tabla:					tpr_tpr_partida_cuenta
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-07-07 11:38:59
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBPresupuesto();
$nombre_archivo = 'ActionListarPartidaCuenta.php';

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

	if($sort == '') $sortcol = 'id_partida_cuenta';
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
	
	//--jgl inicio
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
	//--jgl fin

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
 
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	if($m_sw_partida_cuenta=='si' ){  
	$criterio_filtro=$criterio_filtro." and PARCUE.id_parametro in (select id_parametro from presto.tpr_parametro where id_gestion=".$m_id_gestion.")";
	}	
	
	if($sw_reg_comp=='si'&&$m_id_presupuesto )
	{
		
		if($m_momneto!=0)
		{
				$criterio_filtro=$criterio_filtro." AND  PARCUE.id_partida in (	select id_partida 
																		from presto.tpr_partida_presupuesto 
																		where id_presupuesto =".$m_id_presupuesto."
																	Union
																	select id_partida   
																	from presto.tpr_partida 
																	where sw_movimiento=2 and  sw_transaccional=1 and
																		   id_parametro in (select id_parametro 
																		   					from presto.tpr_presupuesto 
																		  			 		where id_presupuesto =".$m_id_presupuesto.")	   
																		   
																		   ) ";
		}
		
		if($m_momneto==0)
		{
				$criterio_filtro=$criterio_filtro." AND  PARCUE.id_partida in ( select id_partida   
																				from presto.tpr_partida 
																				where sw_movimiento=2 and  sw_transaccional=1 and
																					   id_parametro in (select id_parametro 
																					   					from presto.tpr_presupuesto 
																					  			 		where id_presupuesto =".$m_id_presupuesto.")	   
																		   
																		  		 ) ";
		}

	}	
	
	if($sw_reg_comp=='si'&&$m_id_presupuesto && $sw_cambio='no' && $m_id_partida )
	{
		
		$criterio_filtro=$criterio_filtro." AND  PARCUE.id_partida in (	select id_partida 
																		from presto.tpr_partida_presupuesto 
																		where id_presupuesto =".$m_id_presupuesto.")
											and  PARCUE.id_partida = $m_id_partida";

	}	
	
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'PartidaCuenta');
	$sortcol = $crit_sort->get_criterio_sort();
	
	
		//--jgl inicio
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
		
		                
		$res = $Custom->ListarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad); 
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	else {
//--jgl fin

	//Obtiene el total de los registros
	$res = $Custom -> ContarPartidaCuenta($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_partida_cuenta',$f["id_partida_cuenta"]);
			$xml->add_nodo('id_debe',$f["id_debe"]);
			$xml->add_nodo('debe',$f["debe"]);
			$xml->add_nodo('id_haber',$f["id_haber"]);
			$xml->add_nodo('haber',$f["haber"]);
			$xml->add_nodo('id_recurso',$f["id_recurso"]);
			$xml->add_nodo('recurso',$f["recurso"]);
			$xml->add_nodo('id_gasto',$f["id_gasto"]);
			$xml->add_nodo('gasto',$f["gasto"]);
			$xml->add_nodo('sw_deha',$f["sw_deha"]);
			$xml->add_nodo('sw_rega',$f["sw_rega"]);
			$xml->add_nodo('id_parametro',$f["id_parametro"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('nro_cuenta',$f["nro_cuenta"]);
			$xml->add_nodo('nombre_cuenta',$f["nombre_cuenta"]);
			$xml->add_nodo('codigo_partida',$f["codigo_partida"]);
			$xml->add_nodo('nombre_partida',$f["nombre_partida"]);
			$xml->add_nodo('desc_parcta',$f["recurso"].$f["gasto"]." ".$f["debe"].$f["haber"]);
			$xml->add_nodo('id_moneda',$f["id_moneda"]);
			$xml->add_nodo('desc_moneda',$f["desc_moneda"]);
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
	//--jgl inicio 
   }
	//--jgl fin
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