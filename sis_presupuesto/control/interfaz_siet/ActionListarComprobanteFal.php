<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarRegistroComprobante.php
Propósito:				Permite realizar el listado en tct_comprobante
Tabla:					tct_tct_comprobante
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2008-09-16 17:55:38
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/
session_start();
include_once("../LibModeloPresupuesto.php");
include_once('../../../lib/lib_control/GestionarExcel.php');


$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionListarComprobanteFaltante.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'sc.id_siet_cbte';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

	//Verifica si se hara o no la decodificacion(solo pregunta en caso del GET)
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

	//Verifica si se mANDa la cantidad de filtros
	if($CantFiltros=='') $CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mANDar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$_POST['CantFiltros'];$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	$id_usuario=$_SESSION["ss_id_usuario"];
	
	/*if($m_vista_siet=='siet_cbte'){
		
												}*/
	if ($id_siet_declara == "undefined" || $id_siet_declara == ""){
		$id_siet_declara=$m_id_siet_declara;
	}
	
	if ($reporte_excel=='si')
	{
		//$criterio_filtro=" TRASP.id_siet_declara =$m_id_siet_declara ";
		for($i=0;$i<$nro_columnas;$i++){
			$datosCabecera['valor'][$i]=$_GET["valor_$i"];
			$datosCabecera['columna'][$i]=$_GET["columna_$i"];
			$datosCabecera['align'][$i]=$_GET["align_$i"];
			$datosCabecera['width'][$i]=$_GET["width_$i"];
		}
		$Excel = new GestionarExcel();
		$Excel->SetNombreReporte("Conciliacion Comprobantes");
		//echo $titulo_reporte_excel; exit();
		$Excel->SetHoja("Comprobantes Faltan Conciliar");
		$Excel->SetFila(0);
		$cant=100000000;
		$puntero=0;
	
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	
		$res = $Custom->ListarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
	
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();
	}
	else {
	
	
	$res = $Custom ->ContarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom->ListarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
	
	if($res)
	{
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
			$xml->add_rama('ROWS');
			$xml->add_nodo('id_cbte',$f["id_cbte"]);
			$xml->add_nodo('id_siet_cbte',$f["id_siet_cbte"]);
			$xml->add_nodo('desc_parametro',$f["desc_parametro"]);
			$xml->add_nodo('nro_cbte',$f["nro_cbte"]);
			$xml->add_nodo('concepto_cbte',$f["concepto_cbte"]);
			$xml->add_nodo('glosa_cbte',$f["glosa_cbte"]);
			$xml->add_nodo('acreedor',$f["acreedor"]);
			$xml->add_nodo('desc_subsistema',$f["desc_subsistema"]);
			$xml->add_nodo('desc_clase',$f["desc_clases"]);
            $xml->add_nodo('id_cuenta_bancaria',$f["id_cuenta_bancaria"]);
			$xml->add_nodo('tipo_declara',$f["tipo_declara"]);
			$xml->add_nodo('id_periodo_dec',$f["id_periodo_dec"]);
            $xml->add_nodo('importe',$f["importe"]);
            $xml->add_nodo('nro_cuenta_banco',$f["nro_cuenta_banco"]);
			$xml->add_nodo('fecha_cbte',$f["fecha_cbte"]);
			$xml->add_nodo('sw_ingresa_declaracion',$f["sw_ingresa_declaracion"]);
			$xml->add_nodo('nro_doc',$f["nro_doc"]);
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