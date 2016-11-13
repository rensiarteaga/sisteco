<?php
session_start();
include_once('../LibModeloAdquisiciones.php');
include_once('../../../lib/lib_control/GestionarExcel.php');
$Custom = new cls_CustomDBAdquisiciones();


$nombre_archivo = 'ActionPDFListaPlanilla.php';
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

if($sort == '') $sortcol = 'COTIZA.id_cotizacion';
	else $sortcol = $sort;

	if($dir == "") $sortdir = 'asc';
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
	if($en_planilla=='no'){
		$num_sol="  AND PLA.id_plan_pago not in (select id_plan_pago from compro.tad_plan_pago pp inner join compro.tad_planilla pl on pp.id_planilla=pl.id_planilla
                                                        where (pl.estado_reg=''borrador'' or pl.estado_reg=''pendiente'')) and PLA.estado=''pendiente''
                           ";
	}else{
		if($en_planilla=='si'){
			$num_sol=" inner join compro.tad_plan_pago PP on PP.id_cotizacion=c.id_cotizacion
		           inner join sci.tct_plantilla PLANT on PLANT.tipo_plantilla=PLA.tipo_plantilla
                   inner join compro.tad_planilla PLANIL on PLANIL.id_planilla=PP.id_planilla and PP.id_planilla=$m_id_planilla AND PLA.id_planilla=PLANIL.id_planilla";
		}else{
			
			    
			$num_sol=" AND c.id_depto_tesoro=$m_id_depto_tesoro AND c.id_cotizacion not in (select id_cotizacion from compro.tad_plan_pago pp inner join compro.tad_planilla pl on pp.id_planilla=pl.id_planilla where pp.id_planilla>0 and (pl.estado_reg=''borrador'' or pl.estado_reg=''pendiente'')) and PLA.estado=''pendiente'' ";
		}
	}

	
	$criterio_filtro = $cond -> obtener_criterio_filtro();

	
	//Obtiene el criterio de orden de columnas
	if($sortcol=='numeracion_periodo'){
		$sortcol='num_cotizacion';
	}
	elseif($sortcol=='numeracion_oc'){
		$sortcol='num_orden_compra';
	}else{
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'Cotizacion');
	$sortcol = $crit_sort->get_criterio_sort();
	}
	/*echo 'llega $_POST[m_descripcion]'.$_POST['m_descripcion'];
	echo 'llega $_GET[m_descripcion]'.$_GET['m_descripcion'];
	echo 'llega $m_descripcion'.$m_descripcion;
	echo 'periodo'.$m_periodo_rep;
	echo 'codigo_depto_rep'.$m_codigo_depto_rep;
	echo 'depto_tesoro'.$m_depto_tesoro;
	exit;*/
	   /*data=data+'&m_periodo_rep='+SelectionsRecord.data.periodo_rep;
					    data=data+'&m_codigo_depto_rep='+SelectionsRecord.data.codigo_depto_rep;
					    data=data+'&m_depto_tesoro='+SelectionsRecord.data.depto_tesoro;*/
						
			$datosCabecera['valor'][0]='desc_proveedor';
	$datosCabecera['valor'][1]='num_os';
	$datosCabecera['valor'][2]='nro_contrato';
	$datosCabecera['valor'][3]='monto';
	$datosCabecera['valor'][4]='fecha_pagado';
	$datosCabecera['valor'][5]='tipo_plantilla';
	$datosCabecera['valor'][6]='fecha_factura';
	$datosCabecera['valor'][7]='desc_presupuesto';
	//$datosCabecera['valor'][8]='nombre_afp';
	
	$datosCabecera['columna'][0]='Consultor';
	$datosCabecera['columna'][1]='Orden Servicio';
	$datosCabecera['columna'][2]='Nro Contrato';
	$datosCabecera['columna'][3]='Monto';
	$datosCabecera['columna'][4]='Fecha Pagado';
	$datosCabecera['columna'][5]='Documento';
	$datosCabecera['columna'][6]='Fecha Factura';
	$datosCabecera['columna'][7]='Presupuesto';
	//$datosCabecera['columna'][8]='AFP';
	
	$datosCabecera['width'][0]=360;
	$datosCabecera['width'][1]=90;
	$datosCabecera['width'][2]=60;
	$datosCabecera['width'][3]=60;
	$datosCabecera['width'][4]=120;
	$datosCabecera['width'][5]=120;
	$datosCabecera['width'][6]=120;
	$datosCabecera['width'][7]=120;
	$datosCabecera['width'][8]=200;			
						
	 if ($reporte_excel=='si'){
	 
	 
	
	 
	 $Excel = new GestionarExcel();
		$Excel->SetNombreReporte('Planilla');
		//$afps = $Custom->ObtenerAfps($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	    //$v_ob_afps=$Custom->salida;
	  //  for ($i=0;$i<count($v_ob_afps);$i++){
		        $Excel->SetHoja('Algo');  
		        $Excel->SetFila(1);
		        $Excel->SetTitulo('PLANILLA DE SUELDOS A CONSULTORES'.$_GET['m_periodo'].'/'.$_GET['m_gestion'],0,1,8); //Colocamos el titulo al reporte
		        $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	           // $id_afp=$v_ob_afps[$i]['id_afp'];
		        //$criterio_filtro=" afp.id_afp like ''$id_afp''";
		             
		$res = $Custom->ListarConsultoresPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$num_sol);
// $num_afiliados=sizeof($Custom->salida);
	 	/*	print_r($Custom->salida);
	 		exit;*/
		$Excel->setDetalle($Custom->salida);
		/*$v_datos_emp=$Custom-salida;
		
		$sum_afp = $Custom->RepDetalleAfp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	
	    $v_sum_afp=$Custom->salida;
					    $v_afps=busAFP($v_sum_afp,$id_afp);
					  $sum_devengado=$v_afps[0][7]+$v_afps[0][8];
					        $v_importe=($v_afps[0][7]+$v_afps[0][8]);
					        //$v_importe=($v_afps[0][7]);
 	 			   	 $sum_tot_ap_lab=($v_importe * 0.1)+($v_importe * 0.0171)+($v_importe * 0.005)+($v_importe * 0.005);
 	                 $sum_tot_ap_pat=($v_importe * 0.0171)+($v_importe * 0.02)+($v_importe * 0.03);
 	                
 	             
 	           
 	                 
 	                 $sum_total=$sum_tot_ap_lab+$sum_tot_ap_pat;
 	                $datos_resumen[$i][0]=array(doc_id=>'TOTALES:',valor=>$sum_devengado);
 	                $datos_resumen[$i][1]=array(doc_id=>'RESUMEN :',valor=>'');
                    $datos_resumen[$i][2]=array(doc_id=>'Número de Afiliados:',valor=>$num_afiliados);
                    $datos_resumen[$i][3]=array(doc_id=>'(-) Salario Por Tramite de Jubilación',valor=>'');
                    $datos_resumen[$i][4]=array(doc_id=>'TOTAL SALARIO DEVENGADO:',valor=>$sum_devengado);
                   // $datos_resumen[$i][5]=array(doc_id=>'Incapacidad Temporal:',valor=>$v_afps[0][8]);
                    $datos_resumen[$i][6]=array(doc_id=>'TOTAL SALARIO COTIZABLE:',valor=>$v_importe);
                    $datos_resumen[$i][7]=array(doc_id=>'APORTE LABORAL:',valor=>'');
                    $datos_resumen[$i][8]=array(doc_id=>'Total Aporte Cuenta Individual',dias_cot=>'10.00%',valor=>$v_importe * 0.1);
                    $datos_resumen[$i][9]=array(doc_id=>'Total Seguro de Riesgo Comun',dias_cot=>'1.71%',valor=>$v_importe * 0.0171);
                    $datos_resumen[$i][10]=array(doc_id=>'Total Comisión Administradora'.$v_ob_afps[$i]['nombre_afp'],dias_cot=>'0.50%',valor=>$v_importe * 0.005);
                    $datos_resumen[$i][11]=array(doc_id=>'Total Aporte Solidario:',dias_cot=>'0.50%',valor=>$v_importe * 0.005);
                    
                    $datos_resumen[$i][12]=array(doc_id=>'TOTAL APORTE LABORAL:',valor=>$sum_tot_ap_lab);
 	                $datos_resumen[$i][13]=array(doc_id=>'APORTE PATRONAL:',valor=>'');
                    $datos_resumen[$i][14]=array(doc_id=>'Total Seguro Riesgo Profesional:',dias_cot=>'1.71%',valor=>$v_importe * 0.0171);
                    
                    $datos_resumen[$i][15]=array(doc_id=>'Total Aporte Patronal y Vivienda:',dias_cot=>'2.00%',valor=>$v_importe * 0.02);
                    $datos_resumen[$i][16]=array(doc_id=>'Total Aporte Solidario:',dias_cot=>'3.00%',valor=>$v_importe * 0.03);
                    
 	                $datos_resumen[$i][17]=array(doc_id=>'TOTAL APORTE PATRONAL:',valor=>$sum_tot_ap_pat);
 	                
                    $datos_resumen[$i][18]=array(doc_id=>'TOTAL APORTE LABORAL Y PATRONAL SIP',valor=>$sum_total);
               $Excel->setDetalle($datos_resumen[$i]);*/
	   // }
 	            
	
		
		$Excel->setFin();		
		
	
	 
	 
	 }else{
	$_SESSION['descripcion']=$_GET['m_descripcion'];
	$_SESSION['gestion']=$_GET['m_gestion'];
	$_SESSION['periodo']=$_GET['m_periodo'];
	$_SESSION['periodo_rep']=$_GET['m_periodo_rep'];
	$_SESSION['codigo_depto_rep']=$_GET['m_codigo_depto_rep'];
	$_SESSION['depto_tesoro']=$_GET['m_depto_tesoro'];
	$_SESSION['id_planilla']=$_GET['m_id_planilla'];
	
	
		
	$res = $Custom->ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$num_sol);
	$_SESSION["PDF_array_consultores"]=$Custom->salida;

	header("location: ../../../vista/planilla/PDFPlanillaConsultores.php");
		
	}	
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>