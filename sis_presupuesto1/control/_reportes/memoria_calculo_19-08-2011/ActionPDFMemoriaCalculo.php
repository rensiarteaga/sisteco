<?php
session_start();
include_once("../../LibModeloPresupuesto.php");
$nombre_archivo='ActionPDFMemoriaCalculo.php';
if (!isset($_SESSION['autentificado'])){
	$_SESSION['autentificado']="NO";
}
if($_SESSION['autentificado']=="SI")
{
    $Custom = new cls_CustomDBPresupuesto();
	
    $fuente_financiamiento = $_GET['Fuente_financiamiento'];
    $actividad = $_GET['actividad'];
    $colectivo = $_GET['colectivo'];
    $desc_estado_gral = $_GET['desc_estado_gral'];
    $desc_moneda = $_GET['desc_moneda'];
    $desc_partida = $_GET['desc_partida'];
    $cod_partida = $_GET['cod_partida'];
    $desc_pres = $_GET['desc_pres'];
    $financiador = $_GET['financiador'];
    $formato_reporte = $_GET['formato_reporte']; //pdf - excel
    $gestion_pres = $_GET['gestion_pres'];
    $id_moneda = $_GET['id_moneda'];
    $id_parametro = $_GET['id_parametro'];
    $id_partida = $_GET['id_partida'];
    $id_tipo_pres = $_GET['id_tipo_pres'];
    $memoria = $_GET['memoria']; //general - periodo
    $programa = $_GET['programa'];
    $proyecto = $_GET['proyecto'];
    $regional = $_GET['regional'];
    $tipo_memoria = $_GET['tipo_memoria'];    
    $uo = $_GET['unidad_organizacional'];
    
 	$_SESSION['rep_mem_cal_financiador']=utf8_decode($financiador);
	$_SESSION['rep_mem_cal_regional']=utf8_decode($regional);
 	$_SESSION['rep_mem_cal_programa']=utf8_decode($programa);
 	$_SESSION['rep_mem_cal_proyecto']=utf8_decode($proyecto);
 	$_SESSION['rep_mem_cal_actividad']=utf8_decode($actividad);
 	$_SESSION['rep_mem_cal_unidad_organizacional']=utf8_decode($uo);
 	
	$desc_pres = utf8_decode($desc_pres);
 	
 	$condicion='PARTID.id_partida='.$id_partida;	
		
	$cant=1;
    $puntero=0;
    $sortcol='PARTID.codigo_partida';
    $sortdir='asc';
    $criterio_filtro=$condicion." AND PRESUP.id_presupuesto like ''$id_presupuesto'' AND MEMCAL.tipo_detalle = $tipo_memoria AND MONEDA.id_moneda = $id_moneda";
    $res=$Custom-> ListarCabeceraMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
   
    if($res)
    {
	    if(sizeof($Custom->salida) != 0)	
	    {	
	    	foreach ($Custom->salida as $f)
	    	{
	    		$_SESSION['rep_mem_cal_codigo_partida']=$f["codigo_partida"];
	    		$_SESSION['rep_mem_cal_nombre_partida']=$f["nombre_partida"]; 
	    		$_SESSION['rep_mem_cal_fuente']=$f["fuente"];
	    		$_SESSION['rep_mem_cal_cod_formulario_gasto']=$f["cod_formulario_gasto"];
	    		$_SESSION['rep_mem_cal_gestion_pres']=$f["gestion_pres"];
	    		$_SESSION['rep_mem_cal_fecha_elaboracion']=$f["fecha_elaboracion"];
	    		$_SESSION['rep_mem_cal_simbolo']=$f["simbolo"];    		
	    		$id_partida_presupuesto=$f["id_partida_presupuesto"];
	    		$_SESSION['id_partida_presupuesto']=$id_partida_presupuesto;
	    	}
			
			echo 'Marco1';
			exit();
	    }
	    else 
	    {
			//echo 'Marco';
			//exit();
		
	    	$desc_partida_1 = explode(' - ',$desc_partida);	    	
	    	$_SESSION['rep_mem_cal_codigo_partida']=$desc_partida_1[0];
    		$_SESSION['rep_mem_cal_nombre_partida']=$desc_partida_1[1]; 
    		//$_SESSION['rep_mem_cal_fuente']=$f["fuente"];
    		//$_SESSION['rep_mem_cal_cod_formulario_gasto']=$f["cod_formulario_gasto"];
    		$_SESSION['rep_mem_cal_gestion_pres']=$gestion_pres; 	//$f["gestion_pres"];
    		//$_SESSION['rep_mem_cal_fecha_elaboracion']=$f["fecha_elaboracion"];
    		$_SESSION['rep_mem_cal_simbolo']=$f["simbolo"];    		
    		$id_partida_presupuesto=$f["id_partida_presupuesto"];
	    }
    }
else
{
		echo 'Marco llega al else';
		exit();

}	
    
    if($id_partida_presupuesto == '')
    {
    	//echo 'vacio'; exit;
    	header("location:PDFMemoriaCalculoVacio.php");
    }
    
    else 
    {
	   	if($desc_pres == 'Gasto')
		{
	    	if($memoria==2)
	    	{
	     		header("location:PDFMemoriaCalculoGasto.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
	    	}
	    	else
	    	{
	    		header("location:PDFMemoriaCalculoGastoGeneral.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
	    	}
		}
		
		elseif($desc_pres == 'Inversión')
		{	    	 			
			if($memoria==2)
			{
				header("location:PDFMemoriaCalculoInversion.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
			}
	        	
	        else
	        {
	        	header("location:PDFMemoriaCalculoInversionGeneral.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");
	    	}    		
		}
		
		elseif($desc_pres == 'Recurso')
		{	    	 			
			if($memoria==2)
			{
				header("location:PDFMemoriaCalculoIngreso.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");	        			        	              
	        }
	        else
	        {
	        	header("location:PDFMemoriaCalculoIngresoGeneral.php?id_partida_presupuesto=$id_partida_presupuesto&id_presupuesto=$id_presupuesto&tipo_memoria=$tipo_memoria&id_partida=$id_partida&id_moneda=$id_moneda");
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