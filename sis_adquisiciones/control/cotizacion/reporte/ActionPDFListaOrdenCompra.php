<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFListaOrdenCompra.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    $Custom = new cls_CustomDBAdquisiciones();
    $id_proceso_compra=$m_id_proceso_compra;
	$cant=1;
	$puntero=0;
	$sortcol="PROCOM.periodo";
	$sortdir="asc";
	$criterio_filtro="COT.id_proceso_compra=".$id_proceso_compra;
	/*$Custom->ListarNumeroOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);	
	foreach($Custom->salida as $p){
		$_SESSION['PDF_numero_proceso']=$p["numero_proceso"];
	}*/
/*	echo "HOLLALALALLALA ".$_SESSION['PDF_numero_proceso'];
	exit;*/
	header("location: ../../../vista/orden_compra/PDFListaOrdenCompra.php?id_proceso_compra=".$id_proceso_compra);
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>