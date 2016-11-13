<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFEmpleadosContrato.php';

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

	if($sort == '') $sortcol = ' hisasi.id_lugar,nombre_lugar, contra.tipo_contrato,vemp.nombre_completo,vemp.codigo_empleado
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
	$estado_cons='';
	list($estados[0],
	     $estados[1],
	     $estados[2]
	   
	    ) = explode(",",$tipo_contrato);
	/*echo count($estados);
	exit;*/
  
	for ($i=0;$i<count($estados);$i++){
		
	 if ( ($estados[2])<>''){
	    	$estado_cons=$estado_cons." ( tipo_contrato like ''%'')";
	    	break;
	 }else{
	
     
    switch ($estados[$i]) {
    	case 'planta':
    		 if($i==0){
      	        $estado_cons=$estado_cons."  tipo_contrato like ''planta''";
             }else{
      	        $estado_cons=$estado_cons." or tipo_contrato like ''planta''";
             }
      	break;
    	case 'consultor':
    		 if($i==0){
      	      $estado_cons=$estado_cons." tipo_contrato like ''consultor''  ";	
 	         }else{
              $estado_cons=$estado_cons." or tipo_contrato like ''consultor''  ";	
 		     }
 			
 		break;
 		case 'servicio':
 			 if($i==0){
      	      $estado_cons=$estado_cons." tipo_contrato like ''servicio''";
 			  }else{
              $estado_cons=$estado_cons." or tipo_contrato like ''servicio''";
 		     }
    	break;
    	
      }
	 }
	}
    /*  echo $id_lugar;
      exit;*/
	
                            


	
	if ($tipo_reporte=='listado'){
	
       $criterio_filtro= "(".$estado_cons.")"."
                                  AND hisasi.id_lugar like ''$id_lugar''
                                  AND hisasi.estado_reg <> ''eliminado''
                                  AND (contra.fecha_ini <= ''$fecha_ini'') and (hisasi.fecha_asignacion <= ''$fecha_ini'') ";

       $sortcol="$fecha_ini";
       
      // echo '--'.$criterio_filtro; exit;
       
       
	$res = $Custom->RepEmpleadoContratosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_empleados_contrato_detalle"]=$Custom->salida;
	/*$res_detalle = $Custom->ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$_SESSION["PDF_lista_planilla_empleado_bonos"]=$Custom->salida;
	$_SESSION["titulo"]=$titulo;*/
	$_SESSION["PDF_ec_id_lugar"]=$id_lugar;
	$_SESSION["PDF_ec_tipo_contrato"]=$tipo_contrato;
	$_SESSION["PDF_ec_fecha_ini"]=$fecha_ini;
	$_SESSION["PDF_ec_fecha_fin"]=$fecha_fin;
	$_SESSION["PDF_ec_tipo_reporte"]=$tipo_reporte;
	
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/empleado/PDFEmpleadosContrato.php");
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
  }else{  
  	 $criterio_filtro= "(".$estado_cons.")"; //."
  	 
  	 $id_actividad= $fecha_ini;
                                 /* AND hisasi.id_lugar like ''$id_lugar''
                                  AND hisasi.estado_reg <> ''eliminado''
                                  AND hisasi.estado=''activo'' AND contra.estado_reg=''activo''
                                  AND (contra.fecha_ini <= ''$fecha_ini'') and (hisasi.fecha_asignacion <= ''$fecha_ini'') ";*/
                            
  	  // echo '**'.$criterio_filtro; exit;      
	$res = $Custom->RepEmpleadoContratosCargosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_empleados_cargo_detalle"]=$Custom->salida;
	$_SESSION["PDF_ec_id_lugar"]=$id_lugar;
	$_SESSION["PDF_ec_tipo_contrato"]=$tipo_contrato;
	$_SESSION["PDF_ec_fecha_ini"]=$fecha_ini;
	$_SESSION["PDF_ec_fecha_fin"]=$fecha_fin;
	$_SESSION["PDF_ec_tipo_reporte"]=$tipo_reporte;
	
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/empleado/PDFEmpleadosRelacionContractual.php");
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
}
else
{
	    header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";

}
?>