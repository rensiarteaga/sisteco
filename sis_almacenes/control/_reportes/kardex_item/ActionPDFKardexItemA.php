<?php

session_start();
include_once('../../LibModeloAlmacenes.php');

$Custom = new cls_CustomDBAlmacenes();
$nombre_archivo = 'ActionPDFKardexItemA.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{   
   $fecha_desde=substr($txt_fecha_desde,3,2).'/'.substr($txt_fecha_desde,0,2).'/'.substr($txt_fecha_desde,6,4);
   $fecha_hasta=substr($txt_fecha_hasta,3,2).'/'.substr($txt_fecha_hasta,0,2).'/'.substr($txt_fecha_hasta,6,4);

   
   
	$_SESSION['PDF_fecha_desde']=$fecha_desde;
	$_SESSION['PDF_fecha_hasta']=$fecha_hasta;
	$_SESSION['PDF_desc_almacen']=$txt_desc_almacen;
	$_SESSION['PDF_desc_almacen_logico']=$txt_desc_almacen_logico;
	$_SESSION['PDF_codigo_ep']=$codigo_ep;
	$_SESSION['PDF_gestion']=$gestion;
	$_SESSION['PDF_nombre_item']=$txt_nombre;
	$_SESSION['PDF_descripcion']=$txt_descripcion;
    if($limit == "") $cant = 2000;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'ITEM.codigo';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
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
	/*echo "dfasdflsdf".$txt_id_item;
	exit;*/
	/*$criterio_filtro= $criterio_filtro ." AND SALIDA.estado_salida=''Finalizado'' AND PARALM.id_parametro_almacen=$txt_id_parametro_almacen and ALMEP.id_fina_regi_prog_proy_acti = $id_fina_regi_prog_proy_acti AND
ALMLOG.id_almacen_logico=$txt_id_almacen_logico and ALMACE.id_almacen=$txt_id_almacen AND
SALIDA.fecha_finalizado_cancelado >=''$txt_fecha_desde'' and SALIDA.fecha_finalizado_cancelado<=''$txt_fecha_hasta'' 
 AND TRAMO.id_tramo = $txt_id_tramo	GROUP BY ITEM.codigo,ITEM.nombre,ITEM.descripcion";*/
	//echo "id_item:".$txt_id_item;
	//exit;
        $salida_det = array();
		$salida_det = $Custom-> ReporteKardexItemDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$txt_id_parametro_almacen,$id_fina_regi_prog_proy_acti,$txt_id_almacen_logico,$txt_id_almacen,$txt_id_item,$txt_fecha_desde,$txt_fecha_hasta);
		$_SESSION['PDF_kardex_item_detalle']=$Custom->salida;
		if($tipo_reporte==3){
			header("location: ../../../vista/_reportes/kardex_item_a/PDFKardexItemCosto.php");
		}elseif ($tipo_reporte==2){
			header("location: ../../../vista/_reportes/kardex_item_a/PDFKardexItemCantidad.php");
		}else{
			header("location: ../../../vista/_reportes/kardex_item_a/PDFKardexItem.php");
		}
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>