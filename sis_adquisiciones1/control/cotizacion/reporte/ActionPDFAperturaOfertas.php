<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFAperturaOfertas.php';



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

if($sort == '') $sortcol = 'COTIZA.id_cotizacion';
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



		$_SESSION['adq__id_proceso']=$m_id_proceso_compra;
	

	
	
	$Solicitud = $Custom-> ListarCabeceraApertura($cant,$puntero,$sortcol,$sortdir,'pc.id_proceso_compra='.$_SESSION['adq__id_proceso'],$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
	    
		    
			foreach ($Custom->salida as $f)
			{
				$_SESSION['PDF_fecha_cotiza'] = $f["fecha"];
				$_SESSION['PDF_convocatoria']=$f["convocatoria"];
				$_SESSION['PDF_objeto']=$f["objeto"];
				$_SESSION['PDF_precio']=$f["precio"];
				
			}
     		
		header("location: ../../../vista/proceso_compra/PDFAperturaOfertas.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>