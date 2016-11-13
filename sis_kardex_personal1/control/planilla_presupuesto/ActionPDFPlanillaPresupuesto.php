<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFPlanillaPresupuesto.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']='NO';
}
if($_SESSION['autentificado']=='SI')
{
//Parámetros del filtro
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = 'id_planilla';
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
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
	// if ($$ss_)
  /*  echo $_GET["tipo_reporte"];
    exit;*/
    //listar la cabecera el reporte
   // $m_id_planilla=47;
	 switch ($_GET["tipo_reporte"]) {
    	case 'BONO_TE':
    		 
      	        $estado_cons=" col.codigo = ''BONO_TE''";
      	        $titulo='ASIGNACIÓN BONO DE TÉ';
            
      	break;
      	case 'BONO_TRA':
    		 
      	        $estado_cons=" col.codigo = ''BONO_TRA''";
      	         $titulo='ASIGNACIÓN BONO DE TRANSPORTE';
            
      	break;
      	case 'BONO_ROPA':
    		 
      	        $estado_cons=" col.codigo = ''BONO_ROPA''";
      	         $titulo='ASIGNACIÓN BONO DE ROPA';
            
      	break;
      	case 'ANTICIPO':
    		 
      	        $estado_cons=" col.codigo = ''DESQUIN''";
      	        $titulo='ASIGNACIÓN DE ANTICIPO';
      	        
      	break;
      	case 'DESQUIN':
    		 
      	        $estado_cons=" col.codigo = ''DESQUIN''";
      	        $titulo='ABONO EN CUENTAS - ANTICIPOS';        
            
      	break;
      	
      	case 'AFCOOP':
    		 
      	        $estado_cons=" col.codigo = ''AFCOOP''";
      	        $titulo='APORTE FIJO CACSEL ';        
            
      	break;
      	
      	case 'APCOOP':
    		 
      	        $estado_cons=" col.codigo = ''APCOOP''";
      	        $titulo='APORTE 4% CACSEL ';        
            
      	break;
      	
      	 } 
      	 
      	 
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	
	//print_r($Custom->salida); exit;
	$res = $Custom->ListarRepPlanillaPpto($cant,$puntero,$sortcol,$sortdir," plan.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION["PDF_lista_planilla_presupuesto"]=$Custom->salida;
	
	//print_r($Custom->salida); exit;
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/planilla/PDFPlanillaPresupuesto.php");
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
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>