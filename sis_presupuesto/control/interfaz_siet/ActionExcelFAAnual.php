<?php
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionExcelFAAnual.php';

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

	if($sort == '') $sortcol = ' nro_documento ';
	else $sortcol = $sort;

	if($dir == '') $sortdir = ' asc';
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
	$datosCabecera['valor'][0]='nro_documento';
	$datosCabecera['valor'][0]='nro_documento';
	$datosCabecera['valor'][1]='nro_cbte_sol';
	$datosCabecera['valor'][2]='id_cbte_sol';
	$datosCabecera['valor'][3]='importe_sol';
	$datosCabecera['valor'][4]='periodo_sol';
	$datosCabecera['valor'][5]='sw_fa_sol';
	$datosCabecera['valor'][6]='nro_cbte_rend';
	$datosCabecera['valor'][7]='fecha_cbte_rend';
	$datosCabecera['valor'][8]='importe_rend';
	$datosCabecera['valor'][9]='periodo_rend';
	$datosCabecera['valor'][10]='sw_fa_rend';
	$datosCabecera['valor'][11]='nro_cbte_dev';
	$datosCabecera['valor'][12]='id_cbte_dev';
	$datosCabecera['valor'][13]='importe_dev';
	$datosCabecera['valor'][14]='periodo_dev';
	$datosCabecera['valor'][15]='sw_fa_dev';
	$datosCabecera['valor'][16]='estado_fa';
	$datosCabecera['valor'][17]='saldo';
	$datosCabecera['valor'][18]='id_cuenta_doc';
	
	$datosCabecera['columna'][0]='Nro Fondo Avance';
	$datosCabecera['columna'][1]='Nro Cbte. SOL.';
	$datosCabecera['columna'][2]='ID Cbte. SOL ENDESIS';
	$datosCabecera['columna'][3]='Importe SOL';
	$datosCabecera['columna'][4]='Periodo SOL';
	$datosCabecera['columna'][5]='SW_FA SOL.';
	$datosCabecera['columna'][6]='Nro Cbte. Rend.';
	$datosCabecera['columna'][7]='Fecha Cbte Rend.';
	$datosCabecera['columna'][8]='Importe Rend.';
	$datosCabecera['columna'][9]='Periodo Rend.';
	$datosCabecera['columna'][10]='SW_FA Rend';
	$datosCabecera['columna'][11]='Nro Cbte Dev';
	$datosCabecera['columna'][12]='Id Cbte Dev.';
	$datosCabecera['columna'][13]='Importe Dev.';
	$datosCabecera['columna'][14]='Periodo Dev.';
	$datosCabecera['columna'][15]='SW_FA Dev';
	$datosCabecera['columna'][16]='Estado_FA.';
	$datosCabecera['columna'][17]='Saldo';
	$datosCabecera['columna'][18]='id_cuenta_doc';
	

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
	$datosCabecera['width'][15]=60;
	$datosCabecera['width'][16]=60;
	$datosCabecera['width'][17]=60;
	$datosCabecera['width'][18]=60;

 $Excel = new GestionarExcel();
		$Excel->SetNombreReporte('Reporte Fondos Avance Anual');
		
		$Excel->SetHoja('Todos');  
		$Excel->SetFila(0);
		//$Excel->SetTitulo('SEGUIMIENTO DE ',0,1,4); //Colocamos el titulo al reporte
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
        $criterio_filtro = ' 0 = 0 ';
		$detalle_cbtes = $Custom->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,1);
		$Excel->setDetalle($Custom->salida);
	
	
		$Excel->SetHoja('No-Ingresan');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$criterio_filtro ="((coalesce(sw_fa_sol,''si'')=''no'') or (coalesce(sw_fa_rend,''si'')=''no'') or (coalesce(sw_fa_dev,''si'')=''no''))";
		$detalle_cbtes = $Custom->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,2);
		$Excel->setDetalle($Custom->salida);
		
		$Excel->SetHoja('Ingresan');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$criterio_filtro ="((coalesce(sw_fa_sol,''si'')=''si'') and (coalesce(sw_fa_rend,''si'')=''si'') and (coalesce(sw_fa_dev,''si'')=''si'')) ";
		$detalle_cbtes = $Custom->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,3);
		$Excel->setDetalle($Custom->salida);
		
		$Excel->SetHoja('Completados');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$criterio_filtro ="((coalesce(sw_fa_sol,''si'')=''si'') and (coalesce(sw_fa_rend,''si'')=''si'') and (coalesce(sw_fa_dev,''si'')=''si'')) and (coalesce(importe_sol,0)+coalesce(importe_rend,0)+coalesce(importe_dev,0))=0";
		$detalle_cbtes = $Custom->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,4);
		$Excel->setDetalle($Custom->salida);
		
		$Excel->SetHoja('Pendientes');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$criterio_filtro ="((coalesce(sw_fa_sol,''si'')=''si'') and (coalesce(sw_fa_rend,''si'')=''si'') and (coalesce(sw_fa_dev,''si'')=''si'')) and (coalesce(importe_sol,0)+coalesce(importe_rend,0)+coalesce(importe_dev,0))!=0";
		$detalle_cbtes = $Custom->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,5);
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