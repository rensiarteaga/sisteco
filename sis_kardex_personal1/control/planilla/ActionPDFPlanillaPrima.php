<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFPlanillaPrima.php';

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
    	
      	case 'REP_PRIMA':
    		 
      	        $estado_cons=" col.codigo = ''PRIMA''";
      	        $titulo='PLANILLA DE PRIMAS
      	         DEL PERSONAL';        
            
      	break;
      	
      	 } 
     $puntero=$m_id_planilla; 	 
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	
	$_SESSION["titulo"]=$titulo;
	$_SESSION["tipo_reporte"]=$_GET["tipo_reporte"];
	$res_detalle = $Custom->ListarSumEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_sum_planilla_aguinaldo"]=$Custom->salida;
	if($res) $total_registros= $Custom->salida;
	
	
	//if ($_GET["tipo_reporte"]=='AFCOOP' || $_GET["tipo_reporte"]=='APCOOP'){
		$sortcol='nombre_completo,codigo_empleado';
		$res_detalle = $Custom->ListarRepPlanillaPrimas($cant,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_planilla);
	$_SESSION["PDF_lista_planilla_aguinaldo"]=$Custom->salida;
	header("location:../../vista/_reportes/planilla/PDFPlanillaPrimas.php");
	/*}
	 
	 
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
	}*/
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>