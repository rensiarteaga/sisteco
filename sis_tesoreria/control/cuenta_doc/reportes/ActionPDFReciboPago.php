<?php
session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFReciboPago.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

    if($sort == '') $sortcol = 'cuedoc.id_cuenta_doc';
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

	/*$criterio_filtro = $cond->obtener_criterio_filtro();
	$criterio_filtro= $criterio_filtro." and cuedoc.id_cuenta_doc=$m_id_cuenta_doc ";
	*/
	$rep_recibo_cab = array();
	$rep_recibo_cab = $Custom->RepReciboPago($cant,$puntero,$sortcol,$sortdir,"cdr.id_cuenta_doc_rendicion=$m_id_cuenta_doc_rendicion",$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_recibo_pago']=$Custom->salida;
		//print_r($Custom->salida);
		//exit;
	
	$i=0;
	if(count($Custom->salida)!=0){
		
		$detalle_solicitud=$Custom->RepReciboPagoMes($cant,$puntero,$sortcol,$sortdir,' cd.id_cuenta_doc_rendicion='.$m_id_cuenta_doc_rendicion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	     $_SESSION['PDF_RepReciboPagoMes']=$Custom->salida;
	       //	print_r($Custom->salida);
	       	//exit;
			foreach ($Custom->salida as $f)
			{
				$mes=$f['mes'];
				$gestion=$f['gestion'];
				$_SESSION['PDF_gestion_'.$i]=$f['gestion'];
				$_SESSION['PDF_mes_literal_'.$i]=$f['mes_literal'];
				$_SESSION['PDF_rendiciones_anteriores_'.$i]=$f['rendiciones_anteriores'];
				$detalle_recibo=$Custom->RepReciboPagoDet($cant,$puntero,$sortcol,$sortdir,' cd.id_cuenta_doc_rendicion='.$m_id_cuenta_doc_rendicion.' and vc.mes='.$mes.' and vc.gestion='.$gestion,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
				$_SESSION['PDF_recibo_det_'.$i]=$Custom->salida;
				
				$i=$i+1;		
			}
			
		 header("location: ../../../vista/solicitud_viaticos2/PDFReciboPago.php");		
	}else{
		 echo"No retorna ningun valor de la base de datos consulte con el Administrador";
	}
			
}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>