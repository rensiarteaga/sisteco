<?php
/* Autor: Ana Maria Villegas
 * Descripción: Reporte de Comprobantes 
 * Fecha Ultima Modificación : 28/07/2009
*/
session_start();
include_once('../../LibModeloContabilidad.php');
$Custom = new cls_CustomDBContabilidad();

$nombre_archivo = 'ActionPDFLibroDiario.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 30;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'COMPROB.fecha_cbte'; // aqui tengo que colocar porque se va a ordenar
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
	
	
	
	 $_SESSION['PDF_fecha_inicio']=$fecha_inicio;
	 $_SESSION['PDF_fecha_fin']=$fecha_fin;
	 $_SESSION['PDF_id_monedad']=$id_moneda;
	 
	 $_SESSION['PDF_moneda']=$moneda_desc;
	
	$criterio_filtro= $criterio_filtro ." AND COMPROB.id_depto=$m_id_depto AND  COMPROB.fecha_cbte >= ''$fecha_inicio'' and COMPROB.fecha_cbte<=''$fecha_fin'' ";
	
	$Comprobante = array();
	$Transaccion = array();
	//$Comprobante = $Custom-> ReporteComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$Comprobante = $Custom-> ReporteLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_comprobante']=$Custom->salida;
	$i=0;
     $_SESSION['PDF_simbolo']=$m_simbolo;
     //m_nombre_depto
    $_SESSION['PDF_nombre_depto']=$m_nombre_depto;
foreach ($Custom->salida as $f)
			{    $id_comprobante=$f["id_comprobante"];
				   $_SESSION['PDF_nro_cbte_'.$i]=$f["nro_cbte"];
                $_SESSION['PDF_fecha_cbte_'.$i]=$f["fecha_cbte"];				       
                $_SESSION['PDF_prefijo_'.$i]=$f["prefijo"];
                $_SESSION['PDF_nombre_acreedor_'.$i]=$f["nombre_acreedor"];		
                $_SESSION['PDF_concepto_cbte_'.$i]=$f["concepto_cbte"];	
                $_SESSION['PDF_cheque_'.$i]=$f["cheque"];	
                $_SESSION['PDF_max_tc_'.$i]=$f["t_c"];	                 			       
                $_SESSION['PDF_aprobacion_'.$i]=$f["aprobacion"];	                 			       
                $_SESSION['PDF_pedido'.$i]=$f["pedido"];	                 			       
                 $Transaccion = $Custom->ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir," 0=0",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$id_moneda);
			    //$Transaccion = $Custom->ListarRegistroTransacion($cant,$puntero,'traval.importe_debe desc , traval.importe_haber',$sortdir," 0=0 ",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$id_moneda);
                 $_SESSION['PDF_transaccion_'.$i]=$Custom->salida;
                 
                // $max_tcr=$Custom->MaxTCListarRegistroTransacion($cant,$puntero,'traval.importe_debe desc , traval.importe_haber',$sortdir," 0=0 ",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$id_comprobante,$id_moneda);
     				/*foreach ($Custom->salida as $sal){
     					$_SESSION['PDF_max_tc_'.$i]=$sal["maximo_tipo_cambio"];
     				}*/
                 $i=$i+1;
    	}
         header("location: ../../../vista/libro_diario/PDFLibroDiario.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>