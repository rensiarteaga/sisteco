<?php
session_start();
include_once("../../LibModeloPresupuesto.php");
$nombre_archivo='MemoriaCalculo.php';
if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI"){
		    $Custom = new cls_CustomDBPresupuesto();
			$id_partida_presupuesto=$id_partida_presupuesto;
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
		 	$tipo_reporte=$tipo_reporte;
		 	
		 	$ejecucion=$ejecucion;
			if($ejecucion=1)
			{
				$condicion='PARTID.id_partida='.$id_partida;	
			}
			else 
			{
				$condicion='PARPRE.id_partida_presupuesto='.$id_partida_presupuesto;
			}
			
			$cant=1;
	        $puntero=0;
	        $sortcol='PARTID.codigo_partida';
	        $sortdir='asc';
	        $criterio_filtro=$condicion.' AND PRESUP.id_presupuesto='.$id_presupuesto.' AND MEMCAL.tipo_detalle='.$tipo_memoria.' AND MONEDA.id_moneda='.$id_moneda;
	        $res=$Custom->ListarCabMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	        if($res){
	        	foreach ($Custom->salida as $f){
	        		$_SESSION['rep_mem_cal_codigo_partida']=$f["codigo_partida"];
	        		$_SESSION['rep_mem_cal_nombre_partida']=$f["nombre_partida"];
	        		$_SESSION['rep_mem_cal_fuente']=$f["fuente"];
	        		$_SESSION['rep_mem_cal_cod_formulario_gasto']=$f["cod_formulario_gasto"];
	        		$_SESSION['rep_mem_cal_gestion_pres']=$f["gestion_pres"];
	        		$_SESSION['rep_mem_cal_fecha_elaboracion']=$f["fecha_elaboracion"];
	        		$_SESSION['rep_mem_cal_simbolo']=$f["simbolo"];
	        		
	        		$id_partida_presupuesto=$f["id_partida_presupuesto"];
	        	}
	        	
	        	if($tipo_reporte=="Periodo"){
	         		header("location:PDFMemoriaCalculoGasto.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
	        	}
	        	else{
	        		header("location:PDFMemoriaCalculoGastoGeneral.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
	        	}
	        }
			else{
				$resp=new cls_manejo_mensajes(true, "401");
	            $resp->mensaje_error='MENSAJE ERROR = No hay Datos en la Cabecera';
	            $resp->origen="ORIGEN = $nombre_archivo";
	            $resp->proc="PROC = $nombre_archivo";
	            $resp->nivel='NIVEL = 1';
	            echo $resp->get_mensaje();
	            exit;
			}
}
else{
	$resp=new cls_manejo_mensajes(true,"401");
	$resp->mensaje_error='MENSAJE ERROR = Usuario no Autentificado';
	$resp->origen="ORIGEN = $nombre_archivo";
	$resp->proc="PROC = $nombre_archivo";
	$resp->nivel='NIVEL = 3';
	echo $resp->get_mensaje();
	exit;
}?>