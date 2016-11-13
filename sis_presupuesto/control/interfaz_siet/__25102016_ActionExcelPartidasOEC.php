<?php
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionExcelPartidasOEC.php';

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

	if($sort == '') $sortcol = ' ';
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
	
	// inicio del excel
	
	
	$datosCabecera['valor'][0]='id_siet_cbte_partida';
	$datosCabecera['valor'][1]='codigo_partida';
	$datosCabecera['valor'][2]='importe_partida';
	$datosCabecera['valor'][3]='codigo_oec';
	$datosCabecera['valor'][4]='id_cbte';
	$datosCabecera['valor'][5]='nro_cbte';
	$datosCabecera['valor'][6]='concepto_cbte';
	$datosCabecera['valor'][7]='importe_cbte';
		
	$datosCabecera['columna'][0]='ID Siet CBTE PARTIDA';
	$datosCabecera['columna'][1]='CODIGO PARTIDA.';
	$datosCabecera['columna'][2]='IMPORTE_PARTIDA';
	$datosCabecera['columna'][3]='CODIGO_OEC';
	$datosCabecera['columna'][4]='ID CBTE';
	$datosCabecera['columna'][5]='NRO_CBTE';
	$datosCabecera['columna'][6]='CONCEPTO_CBTE';
	$datosCabecera['columna'][7]='IMPORTE_CBTE';
	
	$datosCabecera['width'][0]=90;
	$datosCabecera['width'][1]=60;
	$datosCabecera['width'][2]=90;
	$datosCabecera['width'][3]=90;
	$datosCabecera['width'][4]=60;
	$datosCabecera['width'][5]=60;
	$datosCabecera['width'][6]=360;
	$datosCabecera['width'][7]=90;
	 	
 $Excel = new GestionarExcel();
		$Excel->SetNombreReporte('PARTIDAS_SIN_OEC');
		$Excel->SetHoja('Partidas sin OEC ');  
		$Excel->SetFila(0);
		//$Excel->SetTitulo('COMPROBANTES SIN PARTIDA',0,1,4); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas

		$detalle_cbtes = $Custom->RepExcelPartidasSinOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
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