<?php
session_start();
include_once("../../LibModeloPresupuesto.php");
$nombre_archivo='PartidaTraspaso.php';

if (!isset($_SESSION['autentificado']))
{
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
		    $Custom = new cls_CustomDBPresupuesto();
		    
			/*$id_partida_presupuesto=$id_partida_presupuesto;
			$id_presupuesto=$id_presupuesto;
			
		 	$_SESSION['rep_mem_cal_financiador']=utf8_decode($nombre_financiador);
			$_SESSION['rep_mem_cal_regional']=utf8_decode($nombre_regional);
		 	$_SESSION['rep_mem_cal_programa']=utf8_decode($nombre_programa);
		 	$_SESSION['rep_mem_cal_proyecto']=utf8_decode($nombre_proyecto);
		 	$_SESSION['rep_mem_cal_actividad']=utf8_decode($nombre_actividad);
		 	$_SESSION['rep_mem_cal_unidad_organizacional']=utf8_decode($desc_unidad_organizacional);
		 	
		 	$tipo_memoria=$tipo_memoria;			
			$id_partida=$id_partida;
			
			$id_moneda=$id_moneda;
		 	$tipo_reporte=$tipo_reporte;*/
			
			$id_partida_traspaso=$id_partida_traspaso;
			
			$cant=1;
	        $puntero=0;
	        //$sortcol='PARTRA.id_partida_traspaso';
	        $sortcol='PARTRA.importe_traspaso';
	        $sortdir='asc';
	        $criterio_filtro='PARTRA.id_partida_traspaso='.$id_partida_traspaso;
	        $res=$Custom->ListarReporteIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	        if($res)
	        {
	        	foreach ($Custom->salida as $f)
	        	{
	        		//$_SESSION['rep_desc_usuario_origen']=$f["desc_usuario_origen"];
	        		$_SESSION['rep_desc_usuario_destino']=$f["desc_usuario_destino"];
	        		$_SESSION['rep_desc_usuario_registro']=$f["desc_usuario_registro"];
	        		$_SESSION['rep_desc_moneda']=$f["desc_moneda"];
	        		$_SESSION['rep_importe_traspaso']=$f["importe_traspaso"];
	        		$_SESSION['rep_fecha_traspaso']=$f["fecha_traspaso"];
	        		$_SESSION['rep_fecha_conclusion']=$f["fecha_conclusion"];	        		
	        		$_SESSION['rep_justificacion']=$f["justificacion"];
	        		$_SESSION['rep_desc_parametro']=$f["desc_parametro"];
	        		$_SESSION['rep_desc_tipo_pres']=$f["desc_tipo_pres"];
	        		//$_SESSION['rep_desc_partida_origen']=$f["desc_partida_origen"];
	        		$_SESSION['rep_desc_partida_destino']=$f["desc_partida_destino"];
	        		//$_SESSION['rep_desc_uo_origen']=$f["desc_uo_origen"];
	        		$_SESSION['rep_desc_uo_destino']=$f["desc_uo_destino"];
	        		//$_SESSION['rep_desc_financiador_origen']=$f["desc_financiador_origen"];
	        		$_SESSION['rep_desc_financiador_destino']=$f["desc_financiador_destino"];
	        		//$_SESSION['rep_desc_regional_origen']=$f["desc_regional_origen"];
	        		$_SESSION['rep_desc_regional_destino']=$f["desc_regional_destino"];
	        		//$_SESSION['rep_desc_programa_origen']=$f["desc_programa_origen"];
	        		$_SESSION['rep_desc_programa_destino']=$f["desc_programa_destino"];
	        		//$_SESSION['rep_desc_proyecto_origen']=$f["desc_proyecto_origen"];
	        		$_SESSION['rep_desc_proyecto_destino']=$f["desc_proyecto_destino"];
	        		//$_SESSION['rep_desc_actividad_origen']=$f["desc_actividad_origen"];
	        		$_SESSION['rep_desc_actividad_destino']=$f["desc_actividad_destino"];
	        		//$_SESSION['rep_desc_fuente_fin_origen']=$f["desc_fuente_fin_origen"];
	        		$_SESSION['rep_desc_fuente_fin_destino']=$f["desc_fuente_fin_destino"]; 	        		
	        	}	        	
	        	
	        	/*if($reformulacion=='no')
	        	{
	        		header("location:PDFPartidaTraspaso.php"); 
	        	}
	        	else
	        	{
	        		header("location:PDFPartidaReformulacion.php");
	        	}*/
	        	if($incremento=='si')
	        	{
	        		header("location:PDFPartidaIncremento.php"); 
	        	}
	        }
			else
			{
				$resp=new cls_manejo_mensajes(true, "401");
	            $resp->mensaje_error='MENSAJE ERROR = No hay Datos en la Cabecera';
	            $resp->origen="ORIGEN = $nombre_archivo";
	            $resp->proc="PROC = $nombre_archivo";
	            $resp->nivel='NIVEL = 1';
	            echo $resp->get_mensaje();
	            exit;
			}
}
else
{
	$resp=new cls_manejo_mensajes(true,"401");
	$resp->mensaje_error='MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen="ORIGEN = $nombre_archivo";
	$resp->proc="PROC = $nombre_archivo";
	$resp->nivel='NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>