<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDocumentoIva.php
Propósito:				Permite realizar el listado en tct_rubro
Tabla:					t_tct_rubro
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-10-02 11:34:34
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocumentoIva.php';

if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']='NO';
}

if($_SESSION['autentificado']=='SI')
{
	//Parámetros del filtro
	if($limit == '') $cant = 15;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'DOC.fecha_documento';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hará o no la decodificación(sólo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod){
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
	for($i=0;$i<$CantFiltros;$i++){
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();

	if($sw_debito_credito==1){
		if ($por_comprobante=='true'){
			$sortcol = 'COM.desc_comprobante,DOC.fecha_documento ';
		}else{
			$sortcol = 'DOC.fecha_documento, COM.desc_comprobante ';
		}
	}
	if($sw_debito_credito==2){$sortcol ='DOC.nro_autorizacion, DOC.fecha_documento, DOC.nro_documento '; }	
	
	if($toda_gestion=='true'){
		$hidden_ep_id_actividad = $m_gestion;
	}
	//echo $hidden_ep_id_actividad; exit;	
	//--jgl inicio
	if ($reporte_excel=='si'){
		//recupera los valores de las columnas
		$datosCabecera['valor'][0]='fecha_documento';
		$datosCabecera['valor'][1]='nro_nit';
		$datosCabecera['valor'][2]='razon_social';
		$datosCabecera['valor'][3]='nro_documento';
		$datosCabecera['valor'][4]='nro_autorizacion';
		$datosCabecera['valor'][5]='codigo_control';
		$datosCabecera['valor'][6]='importe_total';
		$datosCabecera['valor'][7]='importe_ice';
		$datosCabecera['valor'][8]='importe_no_gravado';
		$datosCabecera['valor'][9]='importe_sujeto';
		$datosCabecera['valor'][10]='importe_credito';
		$datosCabecera['valor'][11]='importe_debito';
		$datosCabecera['valor'][12]='desc_comprobante';
		$datosCabecera['valor'][13]='id_documento';
	
		$datosCabecera['columna'][0]='fecha_documento';
		$datosCabecera['columna'][1]='nro_nit';
		$datosCabecera['columna'][2]='razon_social';
		$datosCabecera['columna'][3]='nro_documento';
		$datosCabecera['columna'][4]='nro_autorizacion';
		$datosCabecera['columna'][5]='codigo_control';
		$datosCabecera['columna'][6]='importe_total';
		$datosCabecera['columna'][7]='importe_ice';
		$datosCabecera['columna'][8]='importe_no_gravado';
		$datosCabecera['columna'][9]='importe_sujeto';
		$datosCabecera['columna'][10]='importe_credito';
		$datosCabecera['columna'][11]='importe_debito';
		$datosCabecera['columna'][12]='desc_comprobante';
		$datosCabecera['columna'][13]='id_documento';
	
		$datosCabecera['width'][0]=150;
		$datosCabecera['width'][1]=150;
		$datosCabecera['width'][2]=150;
		$datosCabecera['width'][3]=150;
		$datosCabecera['width'][4]=150;
		$datosCabecera['width'][5]=150;
		$datosCabecera['width'][6]=150;
		$datosCabecera['width'][7]=150;
		$datosCabecera['width'][8]=150;
		$datosCabecera['width'][9]=150;
		$datosCabecera['width'][10]=150;
		$datosCabecera['width'][11]=150;
		$datosCabecera['width'][12]=150;
		$datosCabecera['width'][13]=150;
		
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte($titulo_reporte_excel);
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Hoja 1 Datos");
		$Excel->SetFila(3);
		$cant=100000000;
		$puntero=0;
	
		//$Excel->SetTitulo($titulo_reporte_excel,0,3,$nro_columnas); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas		
		
		if($sw_totales=='true'){
			$res = $Custom->ListarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
		}else{
			$res = $Custom->ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
		}
		$DocumentoIva=$Custom->salida;
		$vector=array();
		for ($i=0;$i<=count($DocumentoIva);$i++){
			$fecha_bd=$DocumentoIva[$i]['fecha_documento'];
			$anio=substr($fecha_bd,0,4);
			$mes=substr($fecha_bd,5,2);
			$dia=substr($fecha_bd,8,2);
			$fecha_muestra=$dia.'-'.$mes.'-'.$anio;
			/*echo ''.$fecha_muestra;
			exit;*/
		    $vector[$i]['fecha_documento']=$fecha_muestra;
			$vector[$i]['nro_nit']=$DocumentoIva[$i][1];
			$vector[$i]['razon_social']=$DocumentoIva[$i][2];
			$vector[$i]['nro_documento']=$DocumentoIva[$i][3];
			$vector[$i]['nro_autorizacion']=$DocumentoIva[$i][4];
			$vector[$i]['codigo_control']=$DocumentoIva[$i][5];
			$vector[$i]['importe_total']=$DocumentoIva[$i][6];
			$vector[$i]['importe_ice']=$DocumentoIva[$i][7];
			$vector[$i]['importe_no_gravado']=$DocumentoIva[$i][8];
			$vector[$i]['importe_sujeto']=$DocumentoIva[$i][9];
		    $vector[$i]['importe_credito']=$DocumentoIva[$i][10];
			$vector[$i]['importe_debito']=$DocumentoIva[$i][11];
			$vector[$i]['desc_comprobante']=$DocumentoIva[$i][12];
		   	$vector[$i]['id_documento']=$DocumentoIva[$i][13];
		}
		//print_r($vector);
		//	exit;
		//$Excel->setDetalle($Custom->salida);
		$Excel->setDetalle($vector);
		$Excel->setFin();		
	}
	else{	
		
		//2016
		if($sw_debito_credito==1 && $ndc=='si'){
			$sw_debito_credito=7;
		}
		
		if($sw_debito_credito==2 && $ndc=='si'){
			$sw_debito_credito=8;
		}
		
		if($sw_totales=='true'){
			//Obtiene el total de los registros
			$res = $Custom -> ContarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
			if($res) $total_registros= $Custom->salida;
	
			//Obtiene el conjunto de datos de la consulta
			$res = $Custom->ListarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
		}else{
			$hidden_ep_id_programa = 'sql';
			//Obtiene el total de los registros
			$res = $Custom -> ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
			if($res) $total_registros= $Custom->salida;
	
			//Obtiene el conjunto de datos de la consulta
			$res = $Custom->ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$m_periodo,$m_id_moneda,$sw_debito_credito,$m_id_depto,$tipo_documento);
		}
		
		if($res){ 
			$xml = new cls_manejo_xml('ROOT');
			$xml->add_nodo('TotalCount',$total_registros);

			foreach ($Custom->salida as $f){
				$xml->add_rama('ROWS');			

				$xml->add_nodo('id_documento',$f["id_documento"]);
				$xml->add_nodo('desc_comprobante',$f["desc_comprobante"]);
				$xml->add_nodo('fecha_documento',$f["fecha_documento"]);
				$xml->add_nodo('nro_nit',$f["nro_nit"]);
				$xml->add_nodo('nro_documento',$f["nro_documento"]);
				$xml->add_nodo('nro_autorizacion',$f["nro_autorizacion"]);
				$xml->add_nodo('codigo_control',$f["codigo_control"]);
				$xml->add_nodo('razon_social',$f["razon_social"]);
				$xml->add_nodo('importe_total',$f["importe_total"]);
				$xml->add_nodo('importe_ice',$f["importe_ice"]);
				$xml->add_nodo('importe_no_gravado',$f["importe_no_gravado"]);
				$xml->add_nodo('importe_sujeto',$f["importe_sujeto"]);
				$xml->add_nodo('importe_credito',$f["importe_credito"]);
				$xml->add_nodo('importe_debito',$f["importe_debito"]);
				
				
				$xml->add_nodo('importe_descuento',$f["importe_descuento"]);
				$xml->add_nodo('tipo_compra',$f["tipo_compra"]);
				
				if ($sw_debito_credito == 1){
					$xml->add_nodo('poliza_dui',$f["poliza_dui"]);
				}
				
				if ($sw_debito_credito == 2){
					$xml->add_nodo('importe_exportaciones',$f["importe_exportaciones"]);
					$xml->add_nodo('importe_ventas_gravadas_tasa_0',$f["importe_ventas_gravadas_tasa_0"]);
				}
				$xml->fin_rama();
			}
			$xml->mostrar_xml();
		}
		else{
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
	//--jgl fin
}
else{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>