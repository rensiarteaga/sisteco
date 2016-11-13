<?php
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionExcelSeguimientoFA.php';

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
	$datosCabecera['valor'][0]='nro_cuenta_banco';
	$datosCabecera['valor'][1]='nro_cheque';
	$datosCabecera['valor'][2]='nro_fa';
	$datosCabecera['valor'][3]='id_cbte_sol';
	$datosCabecera['valor'][4]='nro_cbte_sol';
	$datosCabecera['valor'][5]='importe_sol';
	$datosCabecera['valor'][6]='fecha_cbte_sol';
	$datosCabecera['valor'][7]='estado_rendicion';
	
	$datosCabecera['valor'][8]='id_cbte_dev';
	$datosCabecera['valor'][9]='nro_cbte_dev';
	$datosCabecera['valor'][10]='importe_dev';
	$datosCabecera['valor'][11]='fecha_cbte_dev';
	$datosCabecera['valor'][12]='id_cuenta_doc';
	$datosCabecera['valor'][13]='importe_rendicion';
	$datosCabecera['valor'][14]='saldo';
	
	
	
	$datosCabecera['columna'][0]='Nro Cuenta Banco';
	$datosCabecera['columna'][1]='Nro. Cheque';
	$datosCabecera['columna'][2]='Nro. FA';
	$datosCabecera['columna'][3]='ID CBTE. SOL.';
	$datosCabecera['columna'][4]='Nro. CBTE. SOL';
	$datosCabecera['columna'][5]='Importe Sol.';
	$datosCabecera['columna'][6]='Fecha Cbte. Sol';
	$datosCabecera['columna'][7]='Estado Rendición';
	$datosCabecera['columna'][8]='ID. CBTE. DEV';
	$datosCabecera['columna'][9]='NRO. CBTE. DEV.';
	$datosCabecera['columna'][10]='Importe Dev.';
	$datosCabecera['columna'][11]='Fecha Cbte Dev';
	$datosCabecera['columna'][12]='Id Cuenta Doc';
	$datosCabecera['columna'][13]='Importe Rendición';
	$datosCabecera['columna'][14]='Saldo';

	$datosCabecera['width'][0]=60;
	$datosCabecera['width'][1]=60;
	$datosCabecera['width'][2]=60;
	$datosCabecera['width'][3]=60;
	$datosCabecera['width'][4]=60;
	$datosCabecera['width'][5]=60;
	$datosCabecera['width'][6]=60;
	$datosCabecera['width'][7]=60;
	$datosCabecera['width'][8]=60;
	$datosCabecera['width'][9]=60;
	$datosCabecera['width'][10]=60;
	$datosCabecera['width'][11]=60;
	$datosCabecera['width'][12]=60;
	$datosCabecera['width'][13]=60;
	$datosCabecera['width'][14]=60;

 $Excel = new GestionarExcel();
		$Excel->SetNombreReporte('Reporte');
		$Excel->SetHoja('Partidas');  
		$Excel->SetFila(1);
		//$Excel->SetTitulo('SEGUIMIENTO DE ',0,1,4); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas

		$detalle_cbtes = $Custom->RepExcelSeguimientoFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
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