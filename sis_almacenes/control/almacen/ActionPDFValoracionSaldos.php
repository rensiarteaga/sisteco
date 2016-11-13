<?php
session_start();
include_once("../LibModeloAlmacenes.php");
include_once('../../../lib/lib_control/GestionarExcel.php');
//http://lapiz.ende.bo/endesis/sis_almacenes/control/_reportes/total_valoracion_ing_sal/ActionValoracionSaldos.php?reporte_excel=si&fecha=01-31-2011&id_financiador=3&id_regional=20&id_programa=2&id_proyecto=9&id_actividad=4&id_parametro_almacen=6&id_almacen=19&id_almacen_logico=163
$nombre_archivo = 'ActionValoracionSaldos.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSIOvN['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
 
// inicio del excel

	$datosCabecera['valor'][0]='id_item';
	$datosCabecera['valor'][1]='fecha';
	$datosCabecera['valor'][2]='ingresos';
	$datosCabecera['valor'][3]='salidas';
	$datosCabecera['valor'][4]='final';
	$datosCabecera['valor'][5]='almacen';
	$datosCabecera['valor'][6]='almacen_log';
	$datosCabecera['valor'][7]='fecha_rep';
	$datosCabecera['valor'][8]='gestion';
	$datosCabecera['valor'][9]='nombre_item';
	$datosCabecera['valor'][10]='desc_item';
	$datosCabecera['valor'][11]='saldo_fis';
	$datosCabecera['valor'][12]='costo';
	$datosCabecera['valor'][13]='saldo_eco';
	$datosCabecera['valor'][14]='cant_ingresos';
	$datosCabecera['valor'][15]='cant_salidas';
	$datosCabecera['valor'][16]='costo_ingresos';
	$datosCabecera['valor'][17]='costo_salidas';
	$datosCabecera['valor'][18]='diferencia';
	//$datosCabecera['valor'][8]='nombre_afp';
	$datosCabecera['columna'][0]='id_item';
	$datosCabecera['columna'][1]='fecha';
	$datosCabecera['columna'][2]='ingresos';
	$datosCabecera['columna'][3]='salidas';
	$datosCabecera['columna'][4]='final';
	$datosCabecera['columna'][5]='almacen';
	$datosCabecera['columna'][6]='almacen_log';
	$datosCabecera['columna'][7]='fecha_rep';
	$datosCabecera['columna'][8]='gestion';
	$datosCabecera['columna'][9]='nombre_item';
	$datosCabecera['columna'][10]='desc_item';
	$datosCabecera['columna'][11]='saldo_fis';
	$datosCabecera['columna'][12]='costo';
	$datosCabecera['columna'][13]='saldo_eco';
	$datosCabecera['columna'][14]='cant_ingresos';
	$datosCabecera['columna'][15]='cant_salidas';
	$datosCabecera['columna'][16]='costo_ingresos';
	$datosCabecera['columna'][17]='costo_salidas';
	$datosCabecera['columna'][18]='diferencia';
/*	$datosCabecera['columna'][0]='Id_ite';
	$datosCabecera['columna'][1]='Tipo';
	$datosCabecera['columna'][2]='N.U.A';
	$datosCabecera['columna'][3]='Nombres';
	$datosCabecera['columna'][4]='Dias Cot';
	$datosCabecera['columna'][5]='Nov';
	$datosCabecera['columna'][6]='Fech. Nov';
	$datosCabecera['columna'][7]='Cotizable';
	*///$datosCabecera['columna'][8]='AFP';
	
	$datosCabecera['width'][0]=90;
	$datosCabecera['width'][1]=60;
	$datosCabecera['width'][2]=90;
	$datosCabecera['width'][3]=50;
	$datosCabecera['width'][4]=50;
	$datosCabecera['width'][5]=50;
	$datosCabecera['width'][6]=50;
	$datosCabecera['width'][7]=50;
	$datosCabecera['width'][8]=50;
	$datosCabecera['width'][9]=90;
	$datosCabecera['width'][10]=60;
	$datosCabecera['width'][11]=90;
	$datosCabecera['width'][12]=50;
	$datosCabecera['width'][13]=50;
	$datosCabecera['width'][14]=50;
	$datosCabecera['width'][15]=50;
	$datosCabecera['width'][16]=50;
	$datosCabecera['width'][17]=50;
	$datosCabecera['width'][18]=50;
	//$datosCabecera['width'][9]=100;
/*	function busAFP($vafps,$id_afp){
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
 	 } */
	 
 if ($reporte_excel=='si')
	{	
	
	  $Custom=new cls_CustomDBAlmacenes();
	  
	  /*echo " y ahora vuelvo a mirar el mundo a mi favor de aparcando el miedo a sufrir-------------- me muerooo por conecerte sabe lo que piensas y vencer esas tormentas centrar mis ojos tu mirada ---- ser capaz que me duelen al pensar que te voy queriendo cada diaun poco mas";
 exit;*/
	    //var $txt_id_ep;
	//	http://lapiz.ende.bo/endesis/sis_almacenes/control/_reportes/total_valoracion_ing_sal/ActionValoracionSaldos.php?reporte_excel=si&fecha=01-31-2011&id_financiador=3&id_regional=20&id_programa=2&id_proyecto=9&id_actividad=4&id_parametro_almacen=6&id_almacen=19&id_almacen_logico=163
		//SELECT * FROM almin.f_tal_valoracion_sel(131,'10.100.105.56','00:19:d1:09:22:7e','AL_VALSAL_SEL',NULL, NULL,NULL,NULL,NULL,NULL,'3','20','2','9','4',6,NULL,'163','12-31-2011') AS (id_item integer,fecha date,ingresos numeric,salidas numeric,final varchar,almacen varchar,almacen_log varchar,fecha_rep varchar,gestion varchar,nombre_item varchar,desc_item varchar,un_med_bas varchar,saldo_fis numeric,costo numeric,saldo_eco numeric)
 //where id_item=11246
		$Custom->ReporteValoracionSaldos('NULL','NULL','NULL','NULL','NULL','3','20','2','9','4',6,NULL,'19','163','12-31-2011');
		$data=$Custom->salida;
		/*echo "porqueeee";
		exit;*/
		$id=0;
		$id_item='x';
		$saldo_fis=0;
		$saldo_eco=0;
		$val_sal=0;
		$costo_unitario=0;
		$primera_iteracion=1;
		$cont=0;
		$a_final=array();
		$cant_ingresos=0;
		$cant_salidas=0;
		$costo_ingresos=0;
		$costo_salidas=0;

		//echo "tamaño data: ".count($this->data);
		//exit;
		/*print_r($this->data);
		    exit;*/
		foreach ($data as $row){
			//echo "item:".$row['id_item']."<br>";
			if($id_item!=$row['id_item']){
				//echo "entra ddd";
				if($primera_iteracion==0){
					//Actualiza el registro anterior como final
					//echo "XXXXXX: ".$id;
					$a_final[$cont]=$data[$id-1];
					$a_final[$cont]['final']='si';
					$a_final[$cont][4]='si';
					if($a_final[$cont]['saldo_fis']==0){
						$a_final[$cont]['costo']=0;
						$a_final[$cont][13]=0;
					}
					else{
						$a_final[$cont]['costo']=$a_final[$cont]['saldo_eco']/$a_final[$cont]['saldo_fis'];
						$a_final[$cont][13]=$a_final[$cont]['saldo_eco']/$a_final[$cont]['saldo_fis'];
					}
					//Se cambia el orden para la impresión
					$a_final[$cont][15]=$cant_ingresos;
					$a_final[$cont]['cant_ingresos']=$cant_ingresos;
					$a_final[$cont][16]=$cant_salidas;
					$a_final[$cont]['cant_salidas']=$cant_salidas;
					$a_final[$cont][17]=$costo_ingresos;
					$a_final[$cont]['costo_ingresos']=$costo_ingresos;
					$a_final[$cont][18]=$costo_salidas;
					$a_final[$cont]['costo_salidas']=$costo_salidas;
					$a_final[$cont][19]=$a_final[$cont]['saldo_eco']-($costo_ingresos-$costo_salidas);
					$a_final[$cont]['diferencia']=$a_final[$cont]['saldo_eco']-($costo_ingresos-$costo_salidas);
					
					
					

					/*echo"<pre>";
					print_r($this->data[$id-1]);
					echo"</pre>";
					exit;*/


					$cont++;

				}
				else{
					//Entra sólo en la primera iteración
					$primera_iteracion=0;
				}


				/*echo " XXX saldo fis:".$saldo_fis;
				echo " XXX saldo eco:".$saldo_eco;
				echo " XXX costo:".$val_sal;*/
				$id_item=$row['id_item'];
				$saldo_fis=0;
				$saldo_eco=0;
				$val_sal=0;
				$costo_unitario=0;
				$cant_ingresos=0;
				$cant_salidas=0;
				$costo_ingresos=0;
				$costo_salidas=0;
			}

			if($row['salidas'] > 0){
				if($saldo_fis!=0){
					$costo_unitario = $saldo_eco / $saldo_fis;
					$val_sal = $costo_unitario * $row['salidas'];
				}
				//Actualización del Saldo Económico cuando es Salida
				$saldo_eco = $saldo_eco - $val_sal;
				//Acumula las salidas
				$cant_salidas+=$row['salidas'];
			}
			else{
				//Actualización del Saldo Económico cuando es Ingreso
				$saldo_eco = $saldo_eco + $row['costo'];
				//Acumula los ingresos
				$cant_ingresos+=$row['ingresos'];
			}

			//Actualización del Saldo Físico
			$saldo_fis = $saldo_fis + $row['ingresos'] - $row['salidas'];

			//Actualización de tabla
			if($row['salidas']>0){
				//Salidas
				$data[$id]['saldo_fis']=$saldo_fis;
				$data[$id][12]=$saldo_fis;
				$data[$id]['costo']=$val_sal;
				$data[$id][13]=$val_sal;
				$data[$id]['saldo_eco']=$saldo_eco;
				$data[$id][14]=$saldo_eco;
				//Acumula el costo de las salidas
				$costo_salidas+=$data[$id]['costo'];
			}
			else{
				//Ingresos
				$data[$id]['saldo_fis']=$saldo_fis;
				$data[$id][12]=$saldo_fis;
				$data[$id]['saldo_eco']=$saldo_eco;
				$data[$id][14]=$saldo_eco;
				
				//Acumula el costo de las salidas
				$costo_ingresos+=$data[$id]['costo'];

				//echo " variab saldo fis:".$saldo_fis;
				//echo " array saldo fis:".$this->data[$id]['saldo_fis'];
			}
			$id++;
			
		}
        
		/*echo "saldo fis:".$saldo_fis;
		echo " XXX saldo eco:".$saldo_eco;
		echo " XXX costo:".$val_sal;
		exit;*/

		/*echo"<pre>A_FINAL";
		print_r($a_final);
		echo"</pre>";
		exit;
        */
		//=$a_final;
		$v_detalle=$a_final;
		
		
		
		
	   //print_r($v_detalle);
	    //exit;
	
	$Excel = new GestionarExcel();
		$Excel->SetNombreReporte('Valoracion de Items');
		//$afps = $Custom->ObtenerAfps($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		

		//$v_detalle=$_SESSION['valoracion items'];
	    //$v_ob_afps=$Custom->salida;
	    //for ($i=0;$i<count($v_detalle);$i++){
		        $Excel->SetHoja('Primera');  
		        $Excel->SetFila(1);
		        $Excel->SetTitulo('Valoracion de Items Gestion 2011 ',0,1,8); //Colocamos el titulo al reporte
		        $Excel->SetCabeceraDetalle($datosCabecera);//Colocamos el nombre de las columnas
	            //$id_afp=$v_ob_afps[$i]['id_afp'];
		        //$criterio_filtro=" afp.id_afp like ''$id_afp''";
		             
		//$emp_afps_detalle = $Custom->RepEmpleadoAFPsDetalle($cant,$m_id_planilla,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		 //$num_afiliados=sizeof($Custom->salida);
	 	/*	print_r($Custom->salida);
	 		exit;*/
		
		$Excel->setDetalle($v_detalle);
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
               $Excel->setDetalle($datos_resumen[$i]);
	   // }
 	       */     
	
			/*echo "entra???";
			exit;*/
		$Excel->setFin();		
		}
	else {



	$data="fecha=$fecha";
	$data.="&id_financiador=$txt_id_financiador";
	$data.="&id_regional=$txt_id_regional";
	$data.="&id_programa=$txt_id_programa";
	$data.="&id_proyecto=$txt_id_proyecto";
	$data.="&id_actividad=$txt_id_actividad";
	$data.="&id_parametro_almacen=$txt_id_parametro_almacen";
	$data.="&id_almacen=$txt_id_almacen";
	$data.="&id_almacen_logico=$txt_id_almacen_logico";
	
	
	header("location:PDFValoracionSaldos.php?".$data);
	}
}

else
{
	$resp = new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error = 'MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen = "ORIGEN = $nombre_archivo";
	$resp->proc = "PROC = $nombre_archivo";
	$resp->nivel = 'NIVEL = 3';
	echo $resp->get_mensaje();
	exit;

}?>