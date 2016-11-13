<?php
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionPDFEjecucionPartidaDetalle.php';

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

	if($sort == '') $sortcol = ' hisasi.id_lugar,nombre_lugar, vemp.nombre_completo,contra.tipo_contrato,vemp.codigo_empleado
       ';
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
     
	//$puntero=$m_id_planilla;
	$id_partida=$_GET['id_partida'];
	
	$id_presupuesto=$_GET['id_presupuesto'];
	
	// inicio del excel


	$datosCabecera['valor'][0]='estado_pres';
	$datosCabecera['valor'][1]='importe_ejecucion';
	$datosCabecera['valor'][2]='fecha_com_eje';
	$datosCabecera['valor'][3]='concepto';
	
	$datosCabecera['columna'][0]='Estado';
	$datosCabecera['columna'][1]='Importe Ejecucion';
	$datosCabecera['columna'][2]='Fecha Comprometido';
	$datosCabecera['columna'][3]='Concepto';
	
	$datosCabecera['width'][0]=200;
	$datosCabecera['width'][1]=200;
	$datosCabecera['width'][2]=200;
	$datosCabecera['width'][3]=360;
	  
	$Excel = new GestionarExcel();
		$Excel->SetNombreReporte('DETALLE EJECUCION PARTIDA');
		$Excel->SetHoja('COMPROMETIDOS');  
		        $Excel->SetFila(1);
		        $Excel->SetTitulo('DETALLE EJECUCION PARTIDA ',0,1,8); //Colocamos el titulo al reporte
		        $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	           
		$detalle = $Custom->ListarDetallePartidaComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$id_partida);
	     /*echo ($Custom->salida);
	     exit;*/
	      
		$Excel->setDetalle($Custom->salida);
		    
 	            
	
		
		$Excel->setFin();		
		


  
     }

else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}

?>