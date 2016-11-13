<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFPlanillaEmpleadoBonos.php';

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
   if($_GET["tipo_planilla"]=='aguinaldo2'){
   		switch ($_GET["tipo_reporte"]) {
   			case 'PAGOAGUIN':
   		 
		   		$estado_cons=" col.codigo = ''P2A_TAGUIN''";
		   		$titulo='SEGUNDO AGUINALDO - ESFUERZO POR BOLIVIA';
		   	
		   		break;
		   	case 'PAGOAGUINTODOS':
		   		 
		   		$estado_cons=" col.codigo = ''P2A_TAGUIN''";
		   		$titulo='SEGUNDO AGUINALDO - ESFUERZO POR BOLIVIA';
		   	
		   		break;
		   		
   		}
   
   }else{
	
	
	 switch ($_GET["tipo_reporte"]) {
    	case 'BONO_TE':
    		 
      	        $estado_cons=" col.codigo = ''BONO_TE''";
      	        $titulo='ASIGNACIÓN BONO DE TÉ';
            
      	break;
      	case 'BONO_TRA':
    		 
      	        $estado_cons=" col.codigo = ''BONO_TRA''";
      	         $titulo='ASIGNACIÓN BONO DE TRANSPORTE';
            
      	break;
      	case 'BONO_ROPA':
    		 
      	        $estado_cons=" col.codigo = ''BONO_ROPA''";
      	         $titulo='ASIGNACIÓN BONO DE ROPA';
            
      	break;
      	case 'ANTICIPO':
    		 
      	        $estado_cons=" col.codigo = ''DESQUIN''";
      	        $titulo='ASIGNACIÓN DE ANTICIPO';
      	        
      	break;
      	case 'DESQUIN':
    		 
      	        $estado_cons=" col.codigo = ''DESQUIN''";
      	        $titulo='ABONO EN CUENTAS - ANTICIPOS';        
            
      	break;
      	
      	case 'AFCOOP':
    		 
      	        $estado_cons=" col.codigo = ''AFCOOP''";
      	        $titulo='APORTE FIJO CACSEL ';        
            
      	break;
      	
      	case 'APCOOP':
    		 
      	        $estado_cons=" col.codigo = ''APCOOP''";
      	        $titulo='APORTE 4% CACSEL ';        
            
      	break;
      	case 'PAGOAGUIN':
    		 
      	        $estado_cons=" col.codigo = ''PA_TAGUIN''";
      	        $titulo='AGUINALDOS';        
            
      	break;
      	case 'PAGOAGUINTODOS':
    		 
      	        $estado_cons=" col.codigo = ''PA_TAGUIN''";
      	        $titulo='AGUINALDOS';        
            
      	break;
      	/**/
      	case 'ANTICIPADO':
    		 
      	        $estado_cons=" col.codigo = ''REINT_SAL''";
      	        $titulo='REINTEGRO ENERO-SEPTIEMBRE/2013';        
            
      	break;
      	
      	case 'REINT_SAL':
    		 
      	        $estado_cons=" col.codigo = ''REINT_SAL''";
      	        $titulo='ABONO REINTEGRO ENERO-SEPTIEMBRE/2013';        
            
      	break;
      	
      	case 'PAGOAGUINTODOSCONS':
      		 
      		$estado_cons=" col.codigo = ''2AGUI_CONS''";
      		$titulo='SEGUNDO AGUINALDO CONSULTORES - ESFUERZO POR BOLIVIA';
      		 
      		break;
      	
      	 } 
      	 
   }	 
      	
    $puntero=$m_id_planilla; 	 
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
			$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;
	
			$_SESSION["titulo"]=$titulo;
			$_SESSION["tipo_reporte"]=$_GET["tipo_reporte"];
			$res_detalle = $Custom->ListarSumEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_sum_planilla_empleado_bonos"]=$Custom->salida;
						if($res) $total_registros= $Custom->salida;
	
	
	
	if ($_GET["tipo_reporte"]=='AFCOOP' || $_GET["tipo_reporte"]=='APCOOP'){
				$sortcol='nombre_completo,codigo_empleado';
				$res_detalle = $Custom->ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_lista_planilla_empleado_bonos"]=$Custom->salida;
				header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoBonosCACSEL.php");
	}else IF ($_GET["reporte"]=='ordenado'){
	          
	       		$sortcol='nombre_completo,nro_cuenta,codigo_empleado';
	 			$res_detalle = $Custom->ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_lista_planilla_empleado_bonos"]=$Custom->salida;
	 			header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoBonosSDL.php");
	      }
     else IF ($_GET["reporte"]=='ordenado_aguin'){
	       
	       		$sortcol='nombre_completo,nro_cuenta,codigo_empleado';
	 			$res_detalle = $Custom->ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_lista_planilla_empleado_bonos"]=$Custom->salida;
	
				header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoBonosAguinaldoTodos.php");
	      }
	      
	 else if($res){
	 			$sortcol=' nombre_lugar,nombre_completo,prioridad,nro_cuenta,codigo_empleado';
	 			$res_detalle = $Custom->ListarEmpleadoBonos($cant,$puntero,$sortcol,$sortdir,'  emppla.id_planilla='.$m_id_planilla.' and '.$estado_cons,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
				$_SESSION["PDF_lista_planilla_empleado_bonos"]=$Custom->salida;
	 			header("location:../../vista/_reportes/planilla/PDFPlanillaEmpleadoBonos.php");
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