<?php
session_start();
include_once('../LibModeloTesoreria.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBTesoreria();

$nombre_archivo = 'ActionPDFRepImpViatico.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == '') $cant = 1500;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = ' ';   /// tengo que   cambiar de acuerdo a la consulta
	else $sortcol = $sort;

	if($dir == '') $sortdir = 'desc';
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
	
		
			$id_empleado= $_GET["id_empleado"];
			$fecha_inicio= $_GET["fecha_inicio"];
			$fecha_fin= $_GET["fecha_fin"];
			$reporte= $_GET["reporte"];
			$tipo_personal= $_GET["tipo_personal"];
			$sortcol=$tipo_personal;
			
			$_SESSION["empleado"]=$id_empleado;
			$_SESSION["fecha_inicio"]=$fecha_inicio;
			$_SESSION["fecha_fin"]=$fecha_fin;
			$fecha_inicio= substr( $fecha_inicio,3,2)."/".substr($fecha_inicio,0,2)."/".substr($fecha_inicio,6,4);
			$fecha_fin= substr($fecha_fin,3,2)."/".substr($fecha_fin,0,2)."/".substr($fecha_fin,6,4);
		/*	echo $id_empleado;
			exit;*/
//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++) 
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

	$criterio_filtro = $cond->obtener_criterio_filtro();
	

	$datosCabecera['valor'][0]='fecha_inicio';
	$datosCabecera['valor'][1]='fecha_fin';
	$datosCabecera['valor'][2]='nro_documento';
	$datosCabecera['valor'][3]='nombre_completo';
	$datosCabecera['valor'][4]='concepto';
	
	$datosCabecera['valor'][5]='importe_entregado';
	$datosCabecera['valor'][6]='importe_rendido';
	$datosCabecera['valor'][7]='importe_viatico';
	//$datosCabecera['valor'][8]='nombre_afp';
	
	$datosCabecera['columna'][0]='Fecha Inicio';
	$datosCabecera['columna'][1]='Fecha Fin';
	$datosCabecera['columna'][2]='Nro. Viatico';
	$datosCabecera['columna'][3]='Empleado';
	$datosCabecera['columna'][4]='Concepto';
	$datosCabecera['columna'][5]='Imp. Entregado';
	$datosCabecera['columna'][6]='Imp. Rendido';
	$datosCabecera['columna'][7]='Imp. Viatico';
	//$datosCabecera['columna'][7]='Cotizable';
	//$datosCabecera['columna'][8]='AFP';
	
	$datosCabecera['width'][0]=100;
	$datosCabecera['width'][1]=100;
	$datosCabecera['width'][2]=100;
	$datosCabecera['width'][3]=360;
	$datosCabecera['width'][4]=360;
	$datosCabecera['width'][5]=100;
	$datosCabecera['width'][6]=100;
	$datosCabecera['width'][7]=100;
	
	if ($reporte=='2')
	{	
		
		$Excel = new GestionarExcel();
	$Excel->SetNombreReporte('EmpViaticos');
	$Excel->SetHoja('Viaticos');
	$Excel->SetFila(1);
	$Excel->SetTitulo('ESTADO DE CUENTAS DE EMPLEADOS Y VIATICOs ',0,1,8); //Colocamos el titulo al reporte
	$Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	
	$impviat = $Custom->RepImpViaticoo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_empleado, $fecha_inicio, $fecha_fin);
	$v_impviat=$Custom->salida;
	$nombre_completo='';
	//for ($i=0;$i<count($v_impviat);$i++){
		/*if ($i!=0){
			$Excel->setDetalle($number_format($suma_viatico_emp,2));
		}
		
		if ($v_impviat[$i]['nombre_completo']!=$nombre_completo){
			$Excel->setDetalle($v_impviat[$i]['nombre_completo']);
		}
		*/
		$Excel->setDetalle($v_impviat);
	//}
	
	
	
	$Excel->setFin();
	}
	else {
	
		
	$DetRendicionCuenta = array();
	   
        $DetFondoRotatorio=$Custom->RepImpViaticoo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_empleado, $fecha_inicio, $fecha_fin);
        $_SESSION['PDF_detImpViatico']=$Custom->salida;
    
	 	if(count($Custom->salida)!=0)
	 	{
			header("location: ../../vista/solicitud_viaticos2/PDFRepImpViatico.php");
		}
		else
		{
			echo"No retorna ningún valor de la base de datos consulte con el Administrador";
		}
    }
}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios ";
}

?>