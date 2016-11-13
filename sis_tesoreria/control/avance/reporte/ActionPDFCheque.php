<?php
session_start();
include_once('../../LibModeloTesoreria.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFCheque.php';



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

    if($sort == '') $sortcol = 'CHEQUE.id_cheque';
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
	/*echo "id_avance".$m_id_avance;
	echo "--id_cheque".$m_id_cheque;
	exit;*/
	//$criterio_filtro= $criterio_filtro ." AND AVANCE.id_avance=$m_id_avance";
	///if($m_id_avance==0){
	if($m_id_avance >= 1 && ($m_estado_avance==6 || $m_estado_avance==12)){
		$emite=$Custom->ChequeEmitido($m_id_avance,$m_estado_avance);
	}
	$criterio_filtro= $criterio_filtro ." AND CHEQUE.id_cheque=$m_id_cheque AND CHEVAL.id_moneda=$m_id_moneda";
	//}else{
//	$criterio_filtro= $criterio_filtro ." AND AVANCE.id_avance=$m_id_avance";
	//}
	/*echo "criterio filtro:".$criterio_filtro;
	exit;*/
	/*echo $m_id_cheque;
	echo "moneda".$m_id_moneda;
	exit;*/
	$cheque = array();
	$cheque = $Custom-> ReporteCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	$_SESSION['PDF_cheque']=$Custom->salida;
			foreach ($Custom->salida as $f)
			{   $_SESSION['PDF_fecha_cheque_literal'] = $f["fecha_cheque_literal"];
				$_SESSION['PDF_nombre_cheque']=$f["nombre_cheque"];
				$_SESSION['PDF_importe_avance']=$f["importe_avance"];
				$_SESSION['PDF_importe_avance_literal']=$f["importe_avance_literal"];
				$_SESSION['PDF_fecha_cheque'] = $f["fecha_cheque"];
				$_SESSION['PDF_nombre_institucion'] = $f["nombre_institucion"];
			}
		
	 // $var1="BANCO UNION S.A.";  
	   
	/*if(strcasecmp($var1, $f["nombre_institucion"]) == 0)
	{ */
	 header("location: ../../../vista/solicitud_fondos/PDFEmisionCheque.php");
	/*}
	else{
	 header("location: ../../../vista/solicitud_fondos/PDFEmisionChequeBC.php");	
	}
		*/	   
	}   
	       
else  
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>