
<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
/**
 * Autor: Ana Maria VQ
 * Fecha de mod: 03/08/2009
 * Descripción: Se añadió la mayoría de los estados al criterio de filtro a partir del componente que recibe una lista de estados.
 * **/

$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFSolicitudTiemposEstados.php';



if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    if($limit == "") $cant = 15;
	else $cant = $limit;

	if($start == "") $puntero = 0;
	else $puntero = $start;

if($sort == '') $sortcol = 'SOLCOM.id_solicitud_compra';
	else $sortcol = $sort;

	if($dir == "") $sortdir  = 'asc';
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

//Verifica si se manda la cantidad de filtros
	if($CantFiltros=="") $CantFiltros = 0;


//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i=0;$i<$CantFiltros;$i++)
	{
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}

		$criterio_filtro = $cond->obtener_criterio_filtro();
	$estado_cons=" ";
	list($estados[0],
	     $estados[1],
	     $estados[2],
	     $estados[3],
	     $estados[4],
	     $estados[5],
	     $estados[6],
	     $estados[7],
	     $estados[8],
	     $estados[9],
	     $estados[10],
	     $estados[11],
	     $estados[12]) = explode(",",$estado);
	

	for ($i=0;$i<count($estados);$i++){
		
	 if ($estados[$i]=='Todos'){
	    	$estado_cons=$estado_cons." (estado_solicitud like ''%'')";
	    	break;
	 }else{
	 
     
    switch ($estados[$i]) {
    	case 'Anulados':
    		 if($i==0){
      	        $estado_cons=$estado_cons." estado_solicitud like ''s_anulado''";
             }else{
      	        $estado_cons=$estado_cons." or estado_solicitud like ''s_anulado''";
             }
      	break;
    	case 'Aprobados':
    		 if($i==0){
      	      $estado_cons=$estado_cons." estado_solicitud like ''s_aprobado'' or estado_solicitud like ''s_en_proceso''  ";	
 	         }else{
              $estado_cons=$estado_cons." or estado_solicitud like ''s_aprobado'' or estado_solicitud like ''s_en_proceso''  ";	
 		     }
 			
 		break;
 		case 'Borrador':
 			 if($i==0){
      	      $estado_cons=$estado_cons." estado_solicitud like ''s_borrador''";
 			  }else{
              $estado_cons=$estado_cons." or estado_solicitud like ''s_borrador''";
 		     }
    	break;
    	case 'Pendientes pre Aprobacion':
    		if($i==0){
      	     $estado_cons=$estado_cons." estado_solicitud like ''s_pendiente_pre_aprobacion''";
 			  }else{
              $estado_cons=$estado_cons." or estado_solicitud like ''s_pendiente_pre_aprobacion''";
 		     }
    		
    	break;
    	case 'Pre Aprobados':
    		if($i==0){
      	    	$estado_cons=$estado_cons." estado_solicitud like ''s_pre_aprobado''";
    		  }else{
            	$estado_cons=$estado_cons." or estado_solicitud like ''s_pre_aprobado''";
 		     }
    	break;
    	
 		case 'Proceso':
 			if($i==0){
      	    	$estado_cons=$estado_cons." estado_solicitud like ''p_activo'' or estado_solicitud like ''p_en_proceso''";
    		  }else{
            	$estado_cons=$estado_cons." or estado_solicitud like ''p_activo'' or estado_solicitud like ''p_en_proceso''";
 		     }  
		break;
		case 'Cotizacion':
			if($i==0){
      	    	$estado_cons=$estado_cons." estado_solicitud like ''c_cotizado'' or estado_solicitud like ''c_pendiente''";
    		  }else{
            	$estado_cons=$estado_cons." or estado_solicitud like ''c_cotizado'' or estado_solicitud like ''c_pendiente''";
 		     }  
	    break;
        case 'Orden de Compra':
        	 if($i==0){
      	     $estado_cons=$estado_cons." estado_solicitud like ''a_orden_compra''";
        	 }else{
             $estado_cons=$estado_cons." or estado_solicitud like ''a_orden_compra''";
        	 }  
            
        break;
        case 'Pago':
        	 if($i==0){
      	    $estado_cons=$estado_cons." estado_solicitud like ''a_en_pago''";
        	 }else{
             $estado_cons=$estado_cons." or estado_solicitud like ''a_en_pago''";
        	 }  
            
        break;
        case 'Formulacion Plan de Pagos':
        	  if($i==0){
      	   $estado_cons=$estado_cons." estado_solicitud like ''a_formulacion_pp''";
        	 }else{
            $estado_cons=$estado_cons." or estado_solicitud like ''a_formulacion_pp''";
        	 }  
            
        break;
        
        case 'Adjudicacion':
        	  if($i==0){
      	       $estado_cons=$estado_cons." estado_solicitud like ''a_adjudicado'' or estado_solicitud like ''a_aperturado'' or estado_solicitud like ''a_invitado''";
        	 }else{
               $estado_cons=$estado_cons." or estado_solicitud like ''a_adjudicado'' or estado_solicitud like ''a_aperturado'' or estado_solicitud like ''a_invitado''";
         	 }  
        break;
        case 'Finalizados':
            if($i==0){
      	      $estado_cons=$estado_cons." estado_solicitud like ''a_finalizado''";
            }else{
              $estado_cons=$estado_cons." or estado_solicitud like ''a_finalizado''";
            }  
        break;
   		 case '':
             $estado_cons=$estado_cons;
        break;

       }
	 }
	}
  
   
   $criterio_filtro= $criterio_filtro.' AND ( '.$estado_cons.')';
   $UOCabecera = array();
	$UOItem= array();
	$_SESSION['PDF_gestion']=$gestion;
	$_SESSION['PDF_estado']=$estado;
	$_SESSION['PDF_fecha_inicio']=$txt_fecha_desde;
	$_SESSION['PDF_fecha_fin']=$txt_fecha_hasta;
	$_SESSION['PDF_tipo_adq']=$tipo_adq;
    if ($_SESSION['PDF_tipo_adq']=='Bien')
    {
    	$_SESSION['PDF_titulo']='BIENES';
    }else {
    	$_SESSION['PDF_titulo']='SERVICIOS';
    }
	//$_SESSION['PDF_tipo_adq']='Servicio';
	$_SESSION['PDF_estado']=$estado;
	$i=0;
	//$SETDetalle = $Custom->ListarSolEstadosTiemposDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro." and tipadq.tipo_adq like ''$tipo_adq''",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$txt_fecha_desde,$txt_fecha_hasta,$tipo_adq);
	$SETDetalle = $Custom->ListarSolicitudesEstadosTiempos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$txt_fecha_desde,$txt_fecha_hasta,$tipo_adq);
	
	
	$_SESSION['PDF_SETDetalle']=$Custom->salida;
	

	 header("location: ../../../vista/_reportes/solicitudes_et/PDFSolicitudEstadosTiempos_x_Solicitud.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>