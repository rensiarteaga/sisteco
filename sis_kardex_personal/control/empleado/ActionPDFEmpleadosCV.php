<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFEmpleadosCV.php';

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

	if($sort == '') $sortcol = '';
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

	/*echo $numero.$extension;
	exit;*/
	
	
  	         
	$res = $Custom->DatosEmpleadoCV($cant,$puntero,$sortcol,$sortdir,' emp.id_persona='.$m_id_persona,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_empleados_datos"]=$Custom->salida;
	$_SESSION["PDF_numero_cv"]=$numero;
	$_SESSION["PDF_extension_cv"]=$extension;
	$_SESSION["PDF_tipo_reporte"]=$tipo_reporte;
	
	$res = $Custom->DatosCapacitacionEmpleadoCV($cant,$puntero,$sortcol,$sortdir,' empcap.id_persona='.$m_id_persona,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_empleado_capacitacion_detalle"]=$Custom->salida;
	
	$res = $Custom->DatosExperienciaLabEmpleadoCV($cant,$puntero,$sortcol,$sortdir,' emptra.id_persona='.$m_id_persona,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION["PDF_empleado_trabajos_detalle"]=$Custom->salida;
	
	$res = $Custom->DatosRelacionesFamiliares($cant,$puntero,$sortcol,$sortdir,' emp.id_persona='.$m_id_persona,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

	$_SESSION["PDF_empleado_relaciones_familiares"]=$Custom->salida;
	
	/*print_r($Custom->salida);
	exit;*/
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {   if (sizeof($_SESSION["PDF_empleados_datos"])>0){
		     header("location:../../vista/_reportes/empleado/PDFEmpleadosCV.php");
	      }else{
	      	 echo "La persona no es funcionario ";
	      }
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