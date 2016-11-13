<?php
/* 
 * Autor: Ana María villegas Quispe
 * Fecha de creación: 23/06/2009
 * Descripción: Es el action para que salga todos los documentos respaldo dados las fechas inicio y fin

*/
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFDocumentosRespaldoComprobantes.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ' docval.fecha_documento ';
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'asc';
	else $sortdir = $dir;

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

//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
	/*echo "id_depto_conta".$id_depto;
	echo "fecha_inicio".$fecha_inicio;
	echo "fecha_fin".$fecha_fin;*/
	/*echo "moneda".$moneda;
    exit;*/
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'DocumentoValor');
	$sortcol = $crit_sort->get_criterio_sort();
	
	$m_id_moneda=$_GET["id_moneda"];
	$Comprobante = array();
	$SumDetalle = array();
	$DocumentosVal= array();
	
	$Comprobante = $Custom-> ReporteComprobante($cant,$puntero,'',$sortdir, "  comprob.id_depto=$id_depto and comprob.fecha_cbte>=''$fecha_inicio'' and comprob.fecha_cbte<=''$fecha_fin'' and comprob.id_comprobante in (SELECT   comprod.id_comprobante
																																																			  FROM sci.tct_comprobante comprod
 																																																				INNER JOIN sci.tct_transaccion transa on(transa.id_comprobante=comprod.id_comprobante)
 																																																				INNER JOIN sci.tct_documento docume on(docume.id_transaccion= transa.id_transaccion)
 																																																				WHERE docume.tipo_documento=$tipo_plantilla)",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	
	$_SESSION['PDF_comprobante']=$Custom->salida;
	$i=0;
	$_SESSION['PDF_simbolo_moneda']=$moneda;
	$_SESSION['id_moneda']=$m_id_moneda;

     foreach ($Custom->salida as $f)
			{  
				$id_comprobante=$f["id_comprobante"];
			  
                $DocumentosVal=$Custom->ListarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro.' and planti.tipo_plantilla='.$tipo_plantilla,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$id_moneda);
                $_SESSION['PDF_DetalleRepDocumentos_'.$i]=$Custom->salida;
                
                $SumDetalle=$Custom->SumDocumentosDet($cant,$puntero,"",$sortdir,$criterio_filtro.' and planti.tipo_plantilla='.$tipo_plantilla,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$id_moneda);
                $_SESSION['PDF_SumDetalleDocumentos_'.$i]=$Custom->salida;
                $i=$i+1;
            }
           header("location: ../../../vista/documentos_respaldo/PDFDocumentosRespaldoComprobantes.php");
	}
    else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>