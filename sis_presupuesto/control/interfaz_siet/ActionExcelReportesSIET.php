<?php
session_start();
include_once('../LibModeloPresupuesto.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBPresupuesto();

$nombre_archivo = 'ActionExcelReportesSIET.php';

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
	$datosCabecera['valor'][0]='gestion';
	$datosCabecera['valor'][1]='mes';
	$datosCabecera['valor'][2]='entidad';
	$datosCabecera['valor'][3]='da_ua';
	$datosCabecera['valor'][4]='numero_documento';
	$datosCabecera['valor'][5]='fecha';
	$datosCabecera['valor'][6]='cuenta';
	$datosCabecera['valor'][7]='libreta';
	$datosCabecera['valor'][8]='importe';
	$datosCabecera['valor'][9]='glosa';
	$datosCabecera['valor'][10]='cheque';
	$datosCabecera['valor'][11]='documento';
	$datosCabecera['valor'][12]='tipo'; //'reversion'
	
	
	
	$datosCabecera['columna'][0]='Gestion';
	$datosCabecera['columna'][1]='Mes';
	$datosCabecera['columna'][2]='Entidad';
	$datosCabecera['columna'][3]='DA_UA';
	$datosCabecera['columna'][4]='Nro. Documento';
	$datosCabecera['columna'][5]='Fecha';
	$datosCabecera['columna'][6]='Cuenta';
	$datosCabecera['columna'][7]='Libreta';
	$datosCabecera['columna'][8]='Importe';
	$datosCabecera['columna'][9]='Glosa.';
	$datosCabecera['columna'][10]='Cheque';
	$datosCabecera['columna'][11]='Documento';
	$datosCabecera['columna'][12]='Tipo';
	

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

        $Excel = new GestionarExcel();
		$Excel->SetNombreReporte('Reporte SIET');
        //Hoja de Gastos
		$Excel->SetHoja('Gastos');  
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$detalle_cbtes = $Custom->RepExcelReportesSietGastos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$Excel->setDetalle($Custom->salida);
		//Hoja de Gastos Detalle
				
		$datosCabecera['valor'][5]='secuencial';
		$datosCabecera['valor'][6]='sisin';
		$datosCabecera['valor'][7]='apertura_progr';
		$datosCabecera['valor'][8]='fuente';
		$datosCabecera['valor'][9]='organismo';
		$datosCabecera['valor'][10]='partida';
		$datosCabecera['valor'][11]='entidad_transf';
		$datosCabecera['valor'][12]='da_ua_transf'; 
		$datosCabecera['valor'][13]='oec';
		$datosCabecera['valor'][14]='importe';
		$datosCabecera['valor'][15]='nro_cbte'; 
		$datosCabecera['valor'][16]='glosa';
		
		$datosCabecera['columna'][5]='Secuencial';
		$datosCabecera['columna'][6]='SISIN';
		$datosCabecera['columna'][7]='Apertura Progr';
		$datosCabecera['columna'][8]='Fuente';
		$datosCabecera['columna'][9]='Organismo';
		$datosCabecera['columna'][10]='Partida';
		$datosCabecera['columna'][11]='Entidad_transf';
		$datosCabecera['columna'][12]='da_ua_transf';
		$datosCabecera['columna'][13]='oec';
		$datosCabecera['columna'][14]='Importe';
		$datosCabecera['columna'][15]='Nro_cbte';
		$datosCabecera['columna'][16]='glosa';
		
		
		
		$Excel->SetHoja('Gastos-Detalle');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$detalle_cbtes = $Custom->RepExcelReportesSietGastosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$Excel->setDetalle($Custom->salida);
		
		$datosCabecera['valor'][5]='fecha';
		$datosCabecera['valor'][6]='cuenta';
		$datosCabecera['valor'][7]='libreta';
		$datosCabecera['valor'][8]='importe';
		$datosCabecera['valor'][9]='glosa';
		$datosCabecera['valor'][10]='cheque';
		$datosCabecera['valor'][11]='documento';
		$datosCabecera['valor'][12]='tipo'; //'reversion'
		$datosCabecera['valor'][13]='';
		$datosCabecera['valor'][14]='';
		$datosCabecera['valor'][15]='';
		$datosCabecera['valor'][16]=''; //'reversion'
		
		$datosCabecera['columna'][5]='Fecha';
		$datosCabecera['columna'][6]='Cuenta';
		$datosCabecera['columna'][7]='Libreta';
		$datosCabecera['columna'][8]='Importe';
		$datosCabecera['columna'][9]='Glosa.';
		$datosCabecera['columna'][10]='Cheque';
		$datosCabecera['columna'][11]='Documento';
		$datosCabecera['columna'][12]='Tipo';
		$datosCabecera['columna'][13]='';
		$datosCabecera['columna'][14]='';
		$datosCabecera['columna'][15]='';
		$datosCabecera['columna'][16]='';
		//Hoja de Recursos
		$Excel->SetHoja('Recursos');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$detalle_cbtes = $Custom->RepExcelReportesSietRecursos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$Excel->setDetalle($Custom->salida);
		
		
		$datosCabecera['valor'][5]='secuencial';
		$datosCabecera['valor'][6]='fuente';
		$datosCabecera['valor'][7]='organismo';
		$datosCabecera['valor'][8]='rubro';
		$datosCabecera['valor'][9]='entidad_transf';
		$datosCabecera['valor'][10]='da_ua_transf';
		$datosCabecera['valor'][11]='oec';
		$datosCabecera['valor'][12]='importe';
		$datosCabecera['valor'][13]='documento';
		$datosCabecera['valor'][14]='glosa';
		
		$datosCabecera['columna'][5]='Secuencial';
		$datosCabecera['columna'][6]='Fuente';
		$datosCabecera['columna'][7]='Organismo';
		$datosCabecera['columna'][8]='Rubro';
		$datosCabecera['columna'][9]='Entidad_transf';
		$datosCabecera['columna'][10]='da_ua_transf';
		$datosCabecera['columna'][11]='Oec';
		$datosCabecera['columna'][12]='Importe';
		$datosCabecera['columna'][13]='Documento';
		$datosCabecera['columna'][14]='Glosa';
		//Hoja de Recursos Detalle
		$Excel->SetHoja('Recursos-Detalle');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$detalle_cbtes = $Custom->RepExcelReportesSietRecursosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$Excel->setDetalle($Custom->salida);
		//Hoja de Traspasos
		$datosCabecera['valor'][4]='fecha_salida_cb';
		$datosCabecera['valor'][5]='numero_documento';
		$datosCabecera['valor'][6]='cuenta_origen';
		$datosCabecera['valor'][7]='libreta_origen';
		$datosCabecera['valor'][8]='entidad_destino';
		$datosCabecera['valor'][9]='da_ua_destino';
		$datosCabecera['valor'][10]='cuenta_destino';
		$datosCabecera['valor'][11]='libreta_destino';
		$datosCabecera['valor'][12]='importe';
		$datosCabecera['valor'][13]='glosa';
		$datosCabecera['valor'][14]='cheque';
		$datosCabecera['valor'][15]='documento';
		$datosCabecera['valor'][16]='nro_fa';
		$datosCabecera['valor'][17]='nro_fa1';
		
		$datosCabecera['columna'][4]='Fecha';
		$datosCabecera['columna'][5]='Nro. Documento';
		$datosCabecera['columna'][6]='Cuenta Origen';
		$datosCabecera['columna'][7]='Libreta Origen';
		$datosCabecera['columna'][8]='Entidad Destino';
		$datosCabecera['columna'][9]='DA_UA Destino';
		$datosCabecera['columna'][10]='cuenta_destino';
		$datosCabecera['columna'][11]='libreta_destino';
		$datosCabecera['columna'][12]='Importe';
		$datosCabecera['columna'][13]='Glosa';
		$datosCabecera['columna'][14]='Cheque';
		$datosCabecera['columna'][15]='Documento';
		$datosCabecera['columna'][16]='nro_fa';
		$datosCabecera['columna'][17]='nro_fa1';
		
		$Excel->SetHoja('Traspasos');
		$Excel->SetFila(0);
		$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
		$detalle_cbtes = $Custom->RepExcelReportesSietTraspasos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
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