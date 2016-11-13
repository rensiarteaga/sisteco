<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarAuxiliar.php
Propósito:				Permite desplegar los auxiliar
Tabla:					tct_auxiliar
Parámetros:				$cant
$puntero
$sortcol
$sortdir
$criterio_filtro
$id_usuario_asignacion

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		02-10-2007
Versión:				1.0.0
Autor:					Fernando Prudencio Cardona
**********************************************************
*/
session_start();
include_once("../LibModeloContabilidad.php");
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarAuxiliar.php';

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

	if($sort == '') $sortcol = 'codigo_auxiliar';
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
	
	if($sw_reg_comp=='si' && $cuenta){
		$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select CA.id_auxiliar from sci.tct_cuenta_auxiliar CA where CA.id_cuenta=$cuenta) ";
	}
	if($sw_reg_comp=='si' && $m_id_cuenta){
		$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select CA.id_auxiliar from sci.tct_cuenta_auxiliar CA where CA.id_cuenta=$m_id_cuenta) ";
	}
	if($cuenta){
		$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select CA.id_auxiliar from sci.tct_cuenta_auxiliar CA where CA.id_cuenta=$cuenta) ";
	}
	
	if($sw_referencia_cuenta=='si'&&$m_id_cuenta){
		$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select CA.id_auxiliar from sci.tct_cuenta_auxiliar CA where CA.id_cuenta=$m_id_cuenta) ";
	}
	
	if($m_estado_aux){
		$criterio_filtro=$criterio_filtro." AND estado_auxiliar = 1 ";
	}
	
	/*if($m_sw_rep_libro_mayor=='si'&&$m_id_cuenta){
		$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select DISTINCT CA.id_auxiliar from sci.tct_transaccion CA 
																		INNER JOIN sci.tct_comprobante CB ON (CA.id_comprobante = CB.id_comprobante and CB.id_depto = $m_id_depto and CB.nro_cbte > 0  
																				and CB.fecha_cbte BETWEEN ''$m_fecha_inicio'' and ''$m_fecha_fin'') 
																		where CA.id_cuenta=$m_id_cuenta ) ";
		$sortcol = 'nombre_auxiliar';
		$cant = 300000;
	}
	*/
	
	/*********************************************LIBRO MAYOR ******************/
	 if($por_rango=='true'){
    	$id_cuenta='NULL';
    } else{
    	$cuenta_ini='';
    	$cuenta_fin='';
    }
	if($m_sw_rep_libro_mayor=='si'){
		if($por_rango=='true'){
			$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select DISTINCT CA.id_auxiliar from sci.tct_transaccion CA 
																		INNER JOIN sci.tct_comprobante CB ON (CA.id_comprobante = CB.id_comprobante and CB.id_depto = $m_id_depto and CB.nro_cbte > 0  
																				and CB.fecha_cbte BETWEEN ''$m_fecha_inicio'' and ''$m_fecha_fin'') 
																		where CA.id_cuenta IN (SELECT id_cuenta
                                                     											FROM sci.tct_cuenta
                                                                               					 WHERE nro_cuenta BETWEEN ''$cuenta_ini'' AND ''$cuenta_fin'' AND sw_transaccional=1)) ";
		}else {
			$criterio_filtro=$criterio_filtro." AND id_auxiliar IN (select DISTINCT CA.id_auxiliar from sci.tct_transaccion CA 
																		INNER JOIN sci.tct_comprobante CB ON (CA.id_comprobante = CB.id_comprobante and CB.id_depto = $m_id_depto and CB.nro_cbte > 0  
																				and CB.fecha_cbte BETWEEN ''$m_fecha_inicio'' and ''$m_fecha_fin'') 
																		where CA.id_cuenta=$m_id_cuenta ) ";
		}
		
		$sortcol = 'nombre_auxiliar';
		$cant = 300000;
	}
	/************************************FIN LIBRO MAYOR ****************************/
	
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Auxiliar_7876');
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
		
		                
		$res = $Custom->ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	else {
//--jgl fin
	
	//Obtiene el total de los registros
	$res = $Custom -> ContarAuxiliar($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	//echo $Custom->query;
	//exit;
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_auxiliar',$f["id_auxiliar"]);
			$xml->add_nodo('codigo_auxiliar',$f["codigo_auxiliar"]);
			$xml->add_nodo('nombre_auxiliar',$f["nombre_auxiliar"]);
			$xml->add_nodo('estado_auxiliar',$f["estado_auxiliar"]);
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
