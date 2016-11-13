<?php
/**
 * Nombre:	        ActionRptResponsableActivoFijo.php
 * Propósito:		recoge parametrsos de la vista y los pasa al api de agata pera la generacion de un reporte
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-07-2007
 *
 */
session_start();
include_once(dirname(__FILE__)."/../../LibModeloControlAsistencia.php");
include_once(dirname(__FILE__).'/../../../../lib/lib_control/cls_manejo_reportes.php');

$CustomAsistencia=new cls_CustomDBControlAsistencia();
$CustomAsis=new cls_CustomDBControlAsistencia();
$CustomAsisMax=new cls_CustomDBControlAsistencia();
$CustomDif=new cls_CustomDBControlAsistencia();
$CustomSumaInicio1=new cls_CustomDBControlAsistencia();
$CustomSumaInicio2=new cls_CustomDBControlAsistencia();
$CustomSumaInicio3=new cls_CustomDBControlAsistencia();
$CustomSumaInicio4=new cls_CustomDBControlAsistencia();
$CustomSumaFin1=new cls_CustomDBControlAsistencia();
$CustomSumaFin2=new cls_CustomDBControlAsistencia();
$CustomSumaFin3=new cls_CustomDBControlAsistencia();
$CustomSumaFin4=new cls_CustomDBControlAsistencia();
$CustomAsist=new cls_CustomDBControlAsistencia();
$nombre_archivo='ActionRptResumenMensualDescuentos.php';
if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
	
	//Parámetros del filtro
	if($limit == "") $cant=15;
	else $cant=$limit;

	if($start == "") $puntero=0;
	else $puntero=$start;

	if($sort == "") $sortcol='codigo_empleado';
	else $sortcol=$sort;

	if($dir == "") $sortdir='asc';
	else $sortdir=$dir;

	$reporte=new cls_manejo_reportes();
	//$parametros=null;
	$parametros=array ('$fecha_inicio'=>$txt_fecha_ini,
	'$fecha_fin'=>$txt_fecha_fin,
	'$mes'=>$txt_mes 
	);
	$dif_dias=$CustomDif->DiferenciaDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
	$dias=$CustomDif->salida;
	if($dias == 25)
	{
		
		$CustomSumaInicio1->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
		$fecha_fin1=$CustomSumaInicio1->salida;
		$CustomSumaFin1->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin1);
		$fecha_ini1=$CustomSumaFin1->salida;
		$CustomSumaInicio2->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini1,$txt_fecha_fin);
		$fecha_fin2=$CustomSumaInicio2->salida;
		$CustomSumaFin2->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin2);
		$fecha_ini2=$CustomSumaFin2->salida;
		$CustomSumaInicio3->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini2,$txt_fecha_fin);
		$fecha_fin3=$CustomSumaInicio3->salida;
		$CustomSumaFin3->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin3);
		$fecha_ini3=$CustomSumaFin3->salida;
	   $CustomAsisMax->ContarListaSueldo(0,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);   
       $contar_sueldo=$CustomAsisMax->salida;
       $res_max=$CustomAsisMax->ListarSueldo($contar_sueldo,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
      
       $cont=1;
      while ($cont <=4)
      {
      	/////////////// PRIMERA SEMANA //////////////////////////////
      	if($cont==1){
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				  $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$fecha_fin1);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	              	$obs='';
   	              }
   	              else{
   	              	 $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$fecha_fin1);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$txt_fecha_ini,$fecha_fin1,$atraso,$desc,$obs);
   	              }
   				    
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();
      	}
      	///////////////// FIN PRIMERA SEMANA //////////////////////////
      	///////////////// SEGUNDA SEMANA //////////////////////////
      if($cont==2)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				  $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini1,$fecha_fin2);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                 $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini1,$fecha_fin2);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini1,$fecha_fin2,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();
      	}
      	///////////////// FIN SEGUNDA SEMANA //////////////////////////
      	///////////////// TERCERA SEMANA //////////////////////////
      if($cont==3)
      	{
      	    foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				  $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini2,$fecha_fin3);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                $obs='';
   	              }
   	              else{
   				    $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini2,$fecha_fin3);
				    $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini2,$fecha_fin3,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();
      	}
      	///////////////// FIN TERCERA SEMANA //////////////////////////     	
      	///////////////// CUARTA SEMANA //////////////////////////
       if($cont==4)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				 $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini3,$txt_fecha_fin);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini3,$txt_fecha_fin);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini3,$txt_fecha_fin,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}	 	            
      	///////////////// FIN CUARTA SEMANA //////////////////////////      	
      	$cont=$cont +1;     	
      }
	}
	else{
		$CustomSumaInicio1->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$txt_fecha_fin);
		$fecha_fin1=$CustomSumaInicio1->salida;
		$CustomSumaFin1->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin1);
		$fecha_ini1=$CustomSumaFin1->salida;
		$CustomSumaInicio2->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini1,$txt_fecha_fin);
		$fecha_fin2=$CustomSumaInicio2->salida;
		$CustomSumaFin2->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin2);
		$fecha_ini2=$CustomSumaFin2->salida;
		$CustomSumaInicio3->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini2,$txt_fecha_fin);
		$fecha_fin3=$CustomSumaInicio3->salida;
		$CustomSumaFin3->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin3);
		$fecha_ini3=$CustomSumaFin3->salida;
		$CustomSumaInicio4->SumaDiasFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini3,$txt_fecha_fin);
		$fecha_fin4=$CustomSumaInicio4->salida;
		$CustomSumaFin4->SumaDiasInicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$txt_fecha_ini,$fecha_fin4);
		$fecha_ini4=$CustomSumaFin4->salida;
		$CustomAsisMax->ContarListaSueldo(0,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);   
	    $contar_sueldo=$CustomAsisMax->salida;
        $res_max=$CustomAsisMax->ListarSueldo($contar_sueldo,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
         
       
      $cont=1;
      while ($cont <=5){
      	/////////////// PRIMERA SEMANA //////////////////////////////
      	if($cont==1)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				 $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$fecha_fin1);
   	              $existe=$CustomAsist->salida;
   	              echo $existe;
   	              
   	              if($existe){
   	                $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$txt_fecha_ini,$fecha_fin1);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$txt_fecha_ini,$fecha_fin1,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}
      	///////////////// FIN PRIMERA SEMANA //////////////////////////      	
      	///////////////// SEGUNDA SEMANA //////////////////////////      	
      if($cont==2)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				$CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini1,$fecha_fin2);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                 $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini1,$fecha_fin2);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini1,$fecha_fin2,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}      	
      	///////////////// FIN SEGUNDA SEMANA //////////////////////////      	
      	///////////////// TERCERA SEMANA //////////////////////////
      if($cont==3)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				 $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini2,$fecha_fin3);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                $obs=''; 
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini2,$fecha_fin3);
				  $atraso=$CustomAsist->salida;
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini2,$fecha_fin3,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}
      	///////////////// FIN TERCERA SEMANA //////////////////////////     	      	
      	///////////////// CUARTA SEMANA //////////////////////////     
       if($cont==4)
      	{
      	   foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				 $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini3,$fecha_fin4);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini3,$fecha_fin4);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini3,$fecha_fin4,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}	 	      	      	
      	///////////////// FIN CUARTA SEMANA //////////////////////////      	
      	///////////////// QUINTA SEMANA //////////////////////////     
       if($cont==5)
      	{
      	  foreach ($CustomAsisMax->salida as $row){
      		      $id_empleado=$row["id_empleado"];
   				  $sueldo=$row["sueldo"];
   				  $CustomAsist->ExisteDescuento(15,$puntero,$sortcol,$sortdir,'0=0',$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini4,$txt_fecha_fin);
   	              $existe=$CustomAsist->salida;
   	              if($existe){
   	                $obs='';
   	              }
   	              else{
   				  $res=$CustomAsist->Descuento(15,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$fecha_ini4,$txt_fecha_fin);
				  $atraso=$CustomAsist->salida;
	
				if($atraso <='00:30:59'){
	       			$desc=0;
	       			$obs='Sin Descuento';
	              }
	    		elseif($atraso >= '00:31:00' AND $atraso <='00:45:59'){
	       			$desc=($sueldo*1)/240;
	       			$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 1 hora Laboral';
	     			}
	    		elseif ($atraso >= '00:46:00' AND $atraso <= '01:00:59'){
	       			$desc=($sueldo*2)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de 2 horas Laborales';
	                }
	    		elseif ($atraso >= '01:01:00' AND $atraso <= '01:30:00'){
	       			$desc=($sueldo*4)/240;
	        		$desc=number_format($desc,2,'.',',');
	       			$obs='Descuento de Media Jornada Laboral';
	                }
	    		else{
	        		$desc=0;
	     			$obs='Memorandum de Llamada de Atencion';
	     			}
	     	     $descuento=$CustomAsistencia->CrearDescuento("NULL",$id_empleado,$sueldo,$fecha_ini4,$txt_fecha_fin,$atraso,$desc,$obs);   
   	              }
            }
	  			$repetidos=$CustomAsistencia->EliminarRepetidos();	  			
      	}	 	      	      	
      	///////////////// FIN QUINTA SEMANA //////////////////////////      	
      	$cont=$cont +1;     	
      }
	}
 	  $reporte->CreateReport('Pdf','../../../modelo/_reportes/rca_resumen_mensual_descuento.agt',$parametros);
}
else
{
	$resp=new cls_manejo_mensajes(true, "401");
	$resp->mensaje_error="MENSAJE ERROR=Usuario no Autentificado";
	$resp->origen="ORIGEN=$nombre_archivo";
	$resp->proc="PROC=$nombre_archivo";
	$resp->nivel="NIVEL=1";
	echo $resp->get_mensaje();
	exit;
}
?>