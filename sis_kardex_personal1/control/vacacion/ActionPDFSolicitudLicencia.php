<?php

/*
 * Nombre:	        
 * Propósito:		
 * Autor:			Marcos A. Flores Valda 
 *
 */

session_start();

include_once("../LibModeloKardexPersonal.php");

$Custom = new cls_CustomDBKardexPersonal();
$nombre_archivo = 'ActionPDFSolicitudLicencia.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}

if($_SESSION['autentificado']=="SI")
{	
	//variables que se reciben de la vista
			
	if($limit == '') $cant = 30000;
	else $cant = $limit;

	if($start == '') $puntero = 0;
	else $puntero = $start;

	if($sort == '') $sortcol = '0=0';
	
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

	$id_empleado = $_GET["hidden_id_empleado_0"];
	$id_vacacion = $_GET["hidden_id_vacacion_0"];
	$id_tipo_horario = $_GET["hidden_id_tipo_horario_0"];
	$id_emp_aprobador = $_GET['hidden_id_empleado_aprobacion_0'];
	
//	echo $_GET["hidden_id_empleado_0"].'-'.$_GET["hidden_id_vacacion_0"].'-'.$_GET["hidden_id_tipo_horario_0"].'-'.$_GET['hidden_id_empleado_aprobacion_0'];
	//echo $id_empleado.'-'.$id_vacacion.'-'.$id_tipo_horario.'-'.$id_emp_aprobador; exit;
	
	$criterio_filtro = $cond -> obtener_criterio_filtro();
	
	$criterio_filtro = $criterio_filtro." and EMPLEA.id_empleado = ".$id_empleado." and horari.id_vacacion = ".$id_vacacion." and horari.id_tipo_horario = ".$id_tipo_horario." and horari.id_empleado_aprobacion = ".$id_emp_aprobador." and horari.estado_reg = ''aprobado''";
						
	$res = $Custom -> RepSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$id_vacacion,$id_tipo_horario,$id_emp_aprobador);
		
	//echo $Custom->salida[0]['codigo_empleado']; exit;
	
	$_SESSION['PDF_codigo_emp']=$Custom->salida[0]['codigo_empleado'];
	$_SESSION['PDF_solicitante']=$Custom->salida[0]['solicitante'];
	$_SESSION['PDF_cargo']=$Custom->salida[0]['cargo'];
	$_SESSION['PDF_centro_r']=$Custom->salida[0]['centro_r'];
	$_SESSION['PDF_localidad']=$Custom->salida[0]['localidad'];
	$_SESSION['PDF_antiguedad_ant']=$Custom->salida[0]['antiguedad_ant'];
	$observaciones=$Custom->salida[0]['observaciones'];
	$_SESSION['PDF_dias_disp']=$Custom->salida[0]['dias_disponibles'];
	
	$_SESSION['PDF_horas']=$Custom->salida[0]['horas_por_dia'];
	$_SESSION['PDF_num_solicitud']=$Custom->salida[0]['num_solicitud'];
	$_SESSION['PDF_tipo_contrato']=$Custom->salida[0]['tipo_contrato'];
	$_SESSION['PDF_dias_comp']=$Custom->salida[0]['dias_compensacion'];
	$_SESSION['PDF_antiguedad']=$Custom->salida[0]['antiguedad'];
	$_SESSION['PDF_dias_acum']=$Custom->salida[0]['dias_acumulados'];
	$_SESSION['PDF_dias_toma']=$Custom->salida[0]['dias_tomados'];
			
	$f_ingreso = explode('-',$Custom->salida[0]['ini_contrato']);
	$_SESSION['PDF_dia'] = $f_ingreso[2];
	$_SESSION['PDF_mes'] = $f_ingreso[1];
	$_SESSION['PDF_anio'] = $f_ingreso[0];
		
	$f_inicio = explode('-',$Custom->salida[0]['fecha_inicio']);
	$f_dia_inicio = $f_inicio[2];
	$f_mes_inicio = $f_inicio[1];
	$f_anio_inicio = $f_inicio[0];
	$_SESSION['PDF_fecha_inicio'] = $f_dia_inicio.'/'.$f_mes_inicio.'/'.$f_anio_inicio;
	
	$f_fin = explode('-',$Custom->salida[0]['fecha_fin']);
	$f_dia_fin = $f_fin[2];
	$f_mes_fin = $f_fin[1];
	$f_anio_fin = $f_fin[0];
	$_SESSION['PDF_fecha_fin'] = $f_dia_fin.'/'.$f_mes_fin.'/'.$f_anio_fin;
	
	if($_SESSION['PDF_obs'] != ' ')
	{
		$_SESSION['PDF_obs'] = $observaciones;
	}
	
	/*-----------------------------------------*/
	$cant = 0;
	$puntero = 0;
	$sortcol = "";
	$sortdir = "";

	$numero_sol = $_SESSION['PDF_num_solicitud'];
	
	$criterio_filtro="vacaci.id_empleado = ".$id_empleado." and horari.id_tipo_horario = ".$id_tipo_horario." and horari.id_vacacion = ".$id_vacacion." and horari.id_empleado_aprobacion = ".$id_emp_aprobador." and horari.num_solicitud = ''".$numero_sol."''"." and horari.estado_reg = ''aprobado''";
	
	$res = $Custom -> SumarHorasXDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$id_tipo_horario,$numero_sol,$id_vacacion,$id_emp_aprobador);

	//echo var_dump($Custom); exit;
	
	$_SESSION['PDF_suma'] = $Custom->salida[0]['suma_horas_x_dia'];
	$_SESSION['PDF_f_inicio'] = $Custom->salida[0]['fecha_inicio'];
	$_SESSION['PDF_f_fin'] = $Custom->salida[0]['fecha_fin'];
		
	/*-----------------------------------------*/
	
	if($res)		
	{
		if($_GET["hidden_id_tipo_horario_0"] == 3) //vacacion
			header("location:../../vista/vacacion/PDFSolicitudLicenciaVac.php");
		
		if($_GET["hidden_id_tipo_horario_0"] == 4) //compensacion
			header("location:../../vista/vacacion/PDFSolicitudLicenciaComp.php");
	}

}
else
{
	header("HTTP/1.0 401 No autorizado");
	header('Content-Type: text/plain; charset=iso-8859-1');
	echo "No tiene los permisos necesarios";
}
?>