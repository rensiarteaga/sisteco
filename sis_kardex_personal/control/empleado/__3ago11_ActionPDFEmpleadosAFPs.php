<?php
session_start();
include_once('../LibModeloKardexPersonal.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
//include_once("../../modelo/cls_CustomDBKardexPersonal.php");
$Custom = new cls_CustomDBKardexPersonal();

$nombre_archivo = 'ActionPDFEmpleadosAFPs.php';

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

	if($sort == '') $sortcol = ' hisasi.id_lugar,nombre_lugar, vemp.nombre_completo,contra.tipo_contrato,vemp.codigo_empleado
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

	$puntero=$m_id_planilla;
	
	// inicio del excel

	$datosCabecera['valor'][0]='doc_id';
	$datosCabecera['valor'][1]='tipo';
	$datosCabecera['valor'][2]='nro_afp';
	$datosCabecera['valor'][3]='nombre_completo';
	$datosCabecera['valor'][4]='dias_cot';
	$datosCabecera['valor'][5]='a';
	$datosCabecera['valor'][6]='b';
	$datosCabecera['valor'][7]='valor';
	//$datosCabecera['valor'][8]='nombre_afp';
	
	$datosCabecera['columna'][0]='Doc. Identificacion';
	$datosCabecera['columna'][1]='Tipo';
	$datosCabecera['columna'][2]='N.U.A';
	$datosCabecera['columna'][3]='Nombres';
	$datosCabecera['columna'][4]='Dias Cot';
	$datosCabecera['columna'][5]='Nov';
	$datosCabecera['columna'][6]='Fech. Nov';
	$datosCabecera['columna'][7]='Cotizable';
	//$datosCabecera['columna'][8]='AFP';
	
	$datosCabecera['width'][0]=90;
	$datosCabecera['width'][1]=60;
	$datosCabecera['width'][2]=90;
	$datosCabecera['width'][3]=360;
	$datosCabecera['width'][4]=120;
	$datosCabecera['width'][5]=120;
	$datosCabecera['width'][6]=120;
	$datosCabecera['width'][7]=120;
	$datosCabecera['width'][8]=200;
	//$datosCabecera['width'][9]=100;
	 	function busAFP($vafps,$id_afp){
 	 	    $v_detalle=$vafps;
 	 	for ($k=0;$k<count($v_detalle);$k++){
 	 		if ($id_afp==$v_detalle[$k]['id_afp']){
 	 			switch ($v_detalle[$k]['codigo']){
 	 			   case 'AFP_SSO':
 	 			         
 	 			    $v_detalle_cab[0][0]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			   case 'AFP_RCOM':
 	 			   	$v_detalle_cab[0][1]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			   case 'AFP_CADM':
 	 			   	$v_detalle_cab[0][2]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'APLAB_SOL':
 	 			   	$v_detalle_cab[0][3]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'AFP_RIEPRO':
 	 			   	$v_detalle_cab[0][4]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'AFP_VIVIE':
 	 			   	$v_detalle_cab[0][5]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'APPAT_SOL':
 	 			   	$v_detalle_cab[0][6]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'COTIZABLE':
 	 			   	$v_detalle_cab[0][7]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			    case 'INCTEMP':
 	 			   	$v_detalle_cab[0][8]=$v_detalle[$k]['importe'];
 	 			    break;
 	 			}   
 	 			   
 	 		}
 	 		
 	 	}
 	 	return $v_detalle_cab;
 	 } 
 if ($reporte_excel=='si')
	{	$Excel = new GestionarExcel();
		$Excel->SetNombreReporte('FORMULARIO DE PAGO DE CONTRIBUYENTES');
		$afps = $Custom->ObtenerAfps($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	    $v_ob_afps=$Custom->salida;
	    for ($i=0;$i<count($v_ob_afps);$i++){
		        $Excel->SetHoja($v_ob_afps[$i]['nombre_afp']);  
		        $Excel->SetFila(1);
		        $Excel->SetTitulo('FORMULARIO DE PAGO DE CONTRIBUYENTES '.$v_ob_afps[$i]['nombre_afp'],0,1,8); //Colocamos el titulo al reporte
		        $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	            $id_afp=$v_ob_afps[$i]['id_afp'];
		        $criterio_filtro=" afp.id_afp like ''$id_afp''";
		             
		$emp_afps_detalle = $Custom->RepEmpleadoAFPsDetalle($cant,$m_id_planilla,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		 $num_afiliados=sizeof($Custom->salida);
	 	/*	print_r($Custom->salida);
	 		exit;*/
		$Excel->setDetalle($Custom->salida);
		$v_datos_emp=$Custom-salida;
		
		$sum_afp = $Custom->RepDetalleAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	    $v_sum_afp=$Custom->salida;
					    $v_afps=busAFP($v_sum_afp,$id_afp);
					  $sum_devengado=$v_afps[0][7];
 	 			   	 $sum_tot_ap_lab=$v_afps[0][0]+	$v_afps[0][1]+ $v_afps[0][2]+$v_afps[0][3];
 	                 $sum_tot_ap_pat=$v_afps[0][4]+	$v_afps[0][5]+ $v_afps[0][6];
 	                
 	             
 	                 $v_importe=($v_afps[0][7]+$v_afps[0][8]);
 	                 
 	                 $sum_total=$sum_tot_ap_lab+$sum_tot_ap_pat;
 	                $datos_resumen[$i][0]=array(doc_id=>'TOTALES:',valor=>$sum_devengado);
 	                $datos_resumen[$i][1]=array(doc_id=>'RESUMEN :',valor=>'');
                    $datos_resumen[$i][2]=array(doc_id=>'Número de Afiliados:',valor=>$num_afiliados);
                    $datos_resumen[$i][3]=array(doc_id=>'(-) Salario Por Tramite de Jubilación',valor=>'');
                    $datos_resumen[$i][4]=array(doc_id=>'TOTAL SALARIO DEVENGADO:',valor=>$sum_devengado);
                    $datos_resumen[$i][5]=array(doc_id=>'TOTAL SALARIO COTIZABLE:',valor=>$v_importe);
                    $datos_resumen[$i][6]=array(doc_id=>'APORTE LABORAL:',valor=>'');
                    $datos_resumen[$i][7]=array(doc_id=>'Total Aporte Cuenta Individual',dias_cot=>'10.00%',valor=>$v_afps[0][0]);
                    $datos_resumen[$i][8]=array(doc_id=>'Total Seguro de Riesgo Comun',dias_cot=>'1.71%',valor=>$v_afps[0][1]);
                    $datos_resumen[$i][9]=array(doc_id=>'Total Comisión Administradora'.$v_ob_afps[$i]['nombre_afp'],dias_cot=>'0.50%',valor=>$v_afps[0][2]);
                    $datos_resumen[$i][10]=array(doc_id=>'Total Aporte Solidario:',dias_cot=>'0.50%',valor=>$v_afps[0][3]);
                    
                    $datos_resumen[$i][11]=array(doc_id=>'TOTAL APORTE LABORAL:',valor=>$sum_tot_ap_lab);
 	                $datos_resumen[$i][12]=array(doc_id=>'APORTE PATRONAL:',valor=>'');
                    $datos_resumen[$i][13]=array(doc_id=>'Total Seguro Riesgo Profesional:',dias_cot=>'1.71%',valor=>$v_afps[0][4]);
                    
                    $datos_resumen[$i][14]=array(doc_id=>'Total Aporte Patronal y Vivienda:',dias_cot=>'2.00%',valor=>$v_afps[0][5]);
                    $datos_resumen[$i][15]=array(doc_id=>'Total Aporte Solidario:',dias_cot=>'3.00%',valor=>$v_afps[0][6]);
                    
 	                $datos_resumen[$i][16]=array(doc_id=>'TOTAL APORTE PATRONAL:',valor=>$sum_tot_ap_pat);
 	                
                    $datos_resumen[$i][17]=array(doc_id=>'TOTAL APORTE LABORAL Y PATRONAL SIP',valor=>$sum_total);
               $Excel->setDetalle($datos_resumen[$i]);
	    }
 	            
	
		
		$Excel->setFin();		
		}
	else {
// fin del archivo excel
	
	
	  $criterio_filtro=" afp.id_afp like ''%''";
	$res = $Custom->ListarRepPlanillaCab($cant,$puntero,$sortcol,$sortdir," planil.id_planilla=".$m_id_planilla,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_cab_rep_planilla"]=$Custom->salida;   
	        
	$res = $Custom->RepEmpleadoAFPsDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
	$_SESSION["PDF_empleados_afps_detalle"]=$Custom->salida;
	
	$res = $Custom->RepDetalleAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	$_SESSION["PDF_detalle_afp1"]=$Custom->salida;
	/*print_r($_SESSION["PDF_detalle_afp"]	);
	exit;*/
	if($res) $total_registros= $Custom->salida;
	 if($res)
	 {
		header("location:../../vista/_reportes/empleado/PDFEmpleadosAFPs.php");
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