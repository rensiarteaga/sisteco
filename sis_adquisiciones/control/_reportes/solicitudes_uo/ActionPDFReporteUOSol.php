<?php

session_start();
include_once('../../LibModeloAdquisiciones.php');
$Custom = new cls_CustomDBAdquisiciones();

$nombre_archivo = 'ActionPDFReporteUOSol.php';



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

	/*echo "parametro".$id_parametro_adquisicion;
	echo "gestion".$gestion;
	exit;
	*/
	$criterio_filtro = $cond->obtener_criterio_filtro();
	/*echo "estado".$estado;
	exit;*/
	
	$estado_cons="";
	/*echo $estado;
	exit;*/
    switch ($estado) {
		case 'Pendientes':
 			$estado_cons=" and (solcom.estado_vigente_solicitud like ''borrador'' or solcom.estado_vigente_solicitud like ''pre_aprobado'' or solcom.estado_vigente_solicitud like ''pendiente_pre_aprobacion'') ";	
 			
 		break;
 
		case 'Aprobados':
			$estado_cons=" and (solcom.estado_vigente_solicitud like ''aprobado'' or solcom.estado_vigente_solicitud like ''en_proceso'' or solcom.estado_vigente_solicitud like ''finalizado'')";
		break;
		case 'Finalizados':
             $estado_cons=" and (solcom.estado_vigente_solicitud like ''finalizado'')";
        break;
   		case 'Todos':
             $estado_cons=" and (solcom.estado_vigente_solicitud like ''%'')";
        break;

     }
 
	
	/*if($estado=='pendiente'){
	    $estado=" and (solcom.estado_vigente_solicitud like ''borrador'' or solcom.estado_vigente_solicitud like ''pre_aprobado'' or solcom.estado_vigente_solicitud like ''pendiente_pre_aprobacion'') ";	
	}else if ($estado=='aprobado'){
		$estado=" and (solcom.estado_vigente_solicitud like ''aprobado'' or solcom.estado_vigente_solicitud like ''en_proceso'' or solcom.estado_vigente_solicitud like ''finalizado'')";
	}else if($estado=='finalizado')
	{
		$estado=" and (solcom.estado_vigente_solicitud like ''finalizado'')";
	}else {
		$estado=" and (solcom.estado_vigente_solicitud like ''%'')";
	}*/
	
	
	
	$criterio_filtro= $criterio_filtro ."  AND uniorg.id_unidad_organizacional like ''$id_unidad_organizacional'' and solcom.id_fina_regi_prog_proy_acti like ''$id_fina_regi_prog_proy_acti''
    										and solcom.gestion=$gestion 
    										and (solcom.fecha_reg>=''$txt_fecha_desde''AND solcom.fecha_reg<=''$txt_fecha_hasta'')
    										$estado_cons and solcom.estado_vigente_solicitud!=''anulado'' and  (select count(soldet.id_solicitud_compra) as total
 from compro.tad_solicitud_compra_det   soldet
 inner join compro.tad_solicitud_compra solcom1 on(solcom1.id_solicitud_compra=soldet.id_solicitud_compra)
 where  solcom1.id_solicitud_compra= solcom.id_solicitud_compra)<>0 ";
	
	/*$criterio_filtro= $criterio_filtro ."  AND uniorg.id_unidad_organizacional like ''%'' and solcom.id_fina_regi_prog_proy_acti like ''%''
    										and solcom.gestion=2009 
    										and (solcom.fecha_reg>=''01/06/2009''AND solcom.fecha_reg<=''01/14/2009'')
    										 and solcom.siguiente_estado like ''%'' and  (select count(soldet.id_solicitud_compra) as total
 from compro.tad_solicitud_compra_det   soldet
 inner join compro.tad_solicitud_compra solcom1 on(solcom1.id_solicitud_compra=soldet.id_solicitud_compra)
 where  solcom1.id_solicitud_compra= solcom.id_solicitud_compra)<>0  ";*/
//	and tipadq.tipo_adq like ''%''
	
	$UOCabecera = array();
	$UOItem= array();
	
	$i=0;
	$UOCabecera = $Custom-> ListarUOCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro." and tipadq.tipo_adq like ''$tipo_adq''",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	/*echo $id_unidad_organizacional;
	exit;
	*/
	$_SESSION['PDF_UOCabecera']=$Custom->salida;
	$_SESSION['PDF_gestion']=$gestion;
	$_SESSION['PDF_estado']=$estado;
	$_SESSION['PDF_fecha_inicio']=$txt_fecha_desde;
	$_SESSION['PDF_fecha_fin']=$txt_fecha_hasta;
	$_SESSION['PDF_tipo_adq']=$tipo_adq;
	//$_SESSION['PDF_tipo_adq']='Servicio';
	$_SESSION['PDF_estado']=$estado;
	$_SESSION['PDF_nombre_uo']=$nombre_unidad;
	$_SESSION['PDF_nombre_ep']=$codigo_ep;
	//$tipo_adq="Servicio";
	foreach ($Custom->salida as $f)
	{  $j=0;
	  $k=0;
	   $id_unidad_organizacional = $f["id_unidad_organizacional"];
	   $_SESSION['PDF_nombre_uo_'.$i]=$f["nombre_unidad"];
	   $_SESSION['PDF_nombre_financiador_'.$i]=$f["nombre_financiador"];
	   $_SESSION['PDF_nombre_regional_'.$i]=$f["nombre_regional"];
	   $_SESSION['PDF_nombre_programa_'.$i]=$f["nombre_programa"];
	   $_SESSION['PDF_nombre_proyecto_'.$i]=$f["nombre_proyecto"];
	   $_SESSION['PDF_nombre_actividad_'.$i]=$f["nombre_actividad"];
	   if($tipo_adq=='Bien'){
	   	   $UOPartidaItems = $Custom-> ListarUOPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro." and tipadq.tipo_adq like ''Bien''",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	   	     $_SESSION['PDF_UOPartidas_Items']=$Custom->salida;
	   	     $_SESSION['PDF_titulo']="BIENES";
	  	   foreach ($Custom->salida as $f1)
	       {
	    	$id_partida=$f1["id_partida"];
	    	$nombre_partida=$f1["nombre_partida"];
	    	$_SESSION['PDF_nombre_partida_'.$i.$j]=$nombre_partida;
	    	$UOItem = $Custom-> ListarUOItems($cant,$puntero,$sortcol,$sortdir,$criterio_filtro.' and soldet.id_partida='.$id_partida ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	        $_SESSION['PDF_UOItems_'.$i.$j]=$Custom->salida;
	      	$j=$j+1;
	        }
	   }else{ 
	   	
	   	      $_SESSION['PDF_titulo']="SERVICIOS";
	   	     $UOPartidaServicios = $Custom-> ListarUOPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro." and tipadq.tipo_adq like ''Servicio''",$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	         $_SESSION['PDF_UOPartidas_Servicios']=$Custom->salida;
	   	
	        foreach ($Custom->salida as $f2)
	        {   $id_partida=$f2["id_partida"];
	    	$nombre_partida=$f2["nombre_partida"];
	    	$_SESSION['PDF_nombre_partida_'.$i.$k]=$nombre_partida;
	    	$UOServicio = $Custom-> ListarUOServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro.' and soldet.id_partida='.$id_partida,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	        $_SESSION['PDF_UOServicios_'.$i.$k]=$Custom->salida;
	    	$k=$k+1;
	    	
	        }
	   }
	    
	    
	   
	   $i=$i+1;
    }
	 header("location: ../../../vista/_reportes/solicitudes_uo/PDFReporteUOSol.php");
	}
else
	{
		header("HTTP/1.0 401 No autorizado");
		header('Content-Type: text/plain; charset=iso-8859-1');
		echo "No tiene los permisos necesarios ";
	}

?>