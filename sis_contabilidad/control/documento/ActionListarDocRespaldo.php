<?php
/**
**********************************************************
Nombre de archivo:	    ActionListarDocumentoRespaldo.php
Propósito:				Permite realizar el listado en tct_rubro
Tabla:					t_tct_rubro
Parámetros:				$cant
						$puntero
						$sortcol
						$sortdir
						$criterio_filtro

Valores de Retorno:    	Listado de Procesos y total de registros listados
Fecha de Creación:		2011-02-07 17:52:34
Versión:				1.0.0
Autor:					Generado Automaticamente
**********************************************************
*/

session_start();
/*echo entra_antes_de_lib ;
exit;*/

include_once('../LibModeloContabilidad.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
/*echo entra_despues_del_lib;
exit;*/

$Custom = new cls_CustomDBContabilidad();
$nombre_archivo = 'ActionListarDocumentoRespaldo.php';

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

	if($sort == '') $sortcol = 'DOC.fecha_documento';
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
	$criterio_filtro = $cond -> obtener_criterio_filtro();
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
		 
		$res = $Custom->ActionListarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad, $_GET['id_departamento'], $_GET['id_gestion'], $_GET['id_periodo'], $_GET['id_moneda'], $_GET['fecha_ini'], $_GET['fecha_fin'],$_GET['id_plantilla']);
		 
		$Excel->setDetalle($Custom->salida);
		$Excel->setFin();		
		}
	else {
    //echo $fecha_ini, $fecha_fin;exit;
	//Obtiene el total de los registros 
	
	$res = $Custom -> ContarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla);

	if($res) $total_registros= $Custom->salida;

	//Obtiene el conjunto de datos de la consulta
	$res = $Custom-> ActionListarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla);
	
	if($res)
	{ 
		$xml = new cls_manejo_xml('ROOT');
		$xml->add_nodo('TotalCount',$total_registros);

		foreach ($Custom->salida as $f)
		{
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
	}}
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