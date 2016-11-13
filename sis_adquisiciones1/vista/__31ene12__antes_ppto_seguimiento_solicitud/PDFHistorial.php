<?php
session_start();
require_once('../../../lib/jpgraph/src/jpgraph.php');
require_once("../../../lib/jpgraph/src/jpgraph_gantt.php");
include_once('../../control/LibModeloAdquisiciones.php');
include_once('../../../lib/funciones.inc.php');
	dibujaGrafico();
	
	/**Dibuja el diagrama de gantt
	 * ***************************
	 *
	 */

function dibujaGrafico(){
	
		// Basic Gantt graph
		$graph = new GanttGraph();
		$graph->title->Set("Reporte de Seguimiento de la Solicitud No ".$_SESSION['PDF_num_solicitud']
		." \n Unidad: ".$_SESSION['PDF_nombre_unidad']
		."   EP: ".$_SESSION['PDF_ep']
		);
		$funciones=new funciones();
		$dif_dias=restaFechas($funciones->fecha_normal2($_SESSION['PDF_fecha_min']),$funciones->fecha_normal2($_SESSION['PDF_fecha_max']));
		/*$fecha_max_sol=$_SESSION['PDF_fecha_max'];
		if($dif_dias<14){
			$fecha_max_sol=suma_fechas($_SESSION['PDF_fecha_max'],15);
		}*/
		//echo suma_fechas($funciones->fecha_normal2($_SESSION['PDF_fecha_max']),7);
		//echo $_SESSION['PDF_fecha_min'];
		$graph->SetDateRange($_SESSION['PDF_fecha_min'],suma_fechas($funciones->fecha_normal2($_SESSION['PDF_fecha_max']),14));
				
		// 1.5 line spacing to make more room
		$graph->SetVMarginFactor(1.5);
		
		// Setup some nonstandard colors
		$graph->SetMarginColor('lightgreen@0.8');
		$graph->SetBox(true,'yellow:0.6',2);
		$graph->SetFrame(true,'darkgreen',4);
		$graph->scale->divider->SetColor('yellow:0.6');
		$graph->scale->dividerh->SetColor('yellow:0.6');
		
		
		$Custom = new cls_CustomDBAdquisiciones();
		
		$criterio_filtro=" tipo_estado like ''SOLICITUD'' and solicitud=".$_SESSION['PDF_id_solicitud_compra'];
		$res = $Custom-> ListarHistorialSolicitud(200,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$es_sol=$Custom->salida;
		$total_dias=$_SESSION['PDF_dias'];
		
		// Display month and year scale with the gridlines
		
		if($total_dias<74)
			$graph->ShowHeaders(GANTT_HMONTH | GANTT_HYEAR | GANTT_HWEEK |GANTT_HDAY);
		elseif($total_dias>=74 && $total_dias<201)
			$graph->ShowHeaders(GANTT_HMONTH | GANTT_HYEAR | GANTT_HWEEK );
		else 
			$graph->ShowHeaders(GANTT_HMONTH | GANTT_HYEAR);
		
		$graph->scale->month->grid->SetColor('gray');
		$graph->scale->month->grid->Show(true);
		$graph->scale->year->grid->SetColor('gray');
		$graph->scale->year->grid->Show(true);
		
		// For the titles we also add a minimum width of 100 pixels for the Task name column
		$graph->scale->actinfo->SetColTitles(
		    array('Tipo','Estado','Observaciones Estado','Duracion','Inicio','Fin'),array(30,100));
		 
		$graph->scale->actinfo->SetBackgroundColor('green:0.5@0.5');
		$graph->scale->actinfo->SetFont(FF_ARIAL,FS_NORMAL,10);
		$graph->scale->actinfo->vgrid->SetStyle('solid');
		$graph->scale->actinfo->vgrid->SetColor('gray');
		
		
		// Store the icons in the first column and use plain text in the others
		$data = array();
		
		array_push($data,array(0,array("Solicitud",$_SESSION['PDF_periodo']."/".$_SESSION['PDF_num_solicitud'],'',$_SESSION['PDF_dias']." días",$funciones->fecha_jpgraph($_SESSION['PDF_fecha_min']),$funciones->fecha_jpgraph($_SESSION['PDF_fecha_max']))
		          , $_SESSION['PDF_fecha_min'],$_SESSION['PDF_fecha_max'],FF_FONT2,FS_NORMAL,0,1,$_SESSION['PDF_estado_vigente']));
		
		$cont=1;
		foreach ($es_sol as $f){
			$fin=$f['fecha_fin'];
			if($f['fecha_fin']==''){
				$fin=date("Y-m-d");
				
			}
			
			array_push($data,array($cont,array("Solicitud",$f['estado'],$f['obs_estado']." ",$f['dias']." días",$funciones->fecha_jpgraph($f['fecha_ini']),$funciones->fecha_jpgraph($fin))
		          , $f['fecha_ini'],$fin,FF_FONT2,FS_NORMAL,0,0));
		        
		     $cont++;
		}
		//RECORRE PROCESO DE LA SOLICITUD
		foreach ($_SESSION['PDF_grupo_adq'] as $f){
			
			array_push($data,array($cont,array("Proceso",$f['cod_proceso'],'',$f['dias']." días",$funciones->fecha_jpgraph($f['fecha_min']),$funciones->fecha_jpgraph($f['fecha_max']))
		          , $f['fecha_min'],$f['fecha_max'],FF_FONT2,FS_NORMAL,0,1,$f['estado_vigente']));
		    $cont++;
		    $criterio_filtro=" tipo_estado like ''PROCESO'' and proceso=".$f['id_proceso'].' AND solicitud='.$_SESSION['PDF_id_solicitud_compra'];
			$res = $Custom-> ListarHistorialSolicitud(200,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			$es_sol=$Custom->salida;
			//RECORRE ESTADOS DEL PROCESO
			
			foreach ($es_sol as $k){
				$fin=$k['fecha_fin'];
				if($k['fecha_fin']==''){
					$fin=date("Y-m-d");
					
				}
			
				array_push($data,array($cont,array("Proceso",$k['estado'],$k['obs_estado']." ",$k['dias']." días",$funciones->fecha_jpgraph($k['fecha_ini']),$funciones->fecha_jpgraph($fin))
			          , $k['fecha_ini'],$fin,FF_FONT2,FS_NORMAL,0,0));
			       
			    $cont++;
			}
			
			
			//RECORRE COTIZACIONES DEL PROCESO
			
			$criterio_filtro=" tipo_proceso like ''COTIZACION'' and id_proceso=".$f['id_proceso']."and SOL.id_solicitud_compra=".$_SESSION['PDF_id_solicitud_compra'];
			$res = $Custom-> ListarHistorialGrupo(200,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			$es_cot=$Custom->salida;
			
			
			foreach ($es_cot as $r){
							
				array_push($data,array($cont,array("Cotización",$r['proveedor'],'',$r['dias']." días",$funciones->fecha_jpgraph($r['fecha_min']),$funciones->fecha_jpgraph($r['fecha_max']))
			          , $r['fecha_min'], $r['fecha_max'],FF_FONT2,FS_NORMAL,0,1,$r['estado_vigente']));
			           
			    $cont++;
			    $criterio_filtro=" tipo_estado like ''COTIZACION'' and proceso=".$f['id_proceso'].' AND solicitud='.$_SESSION['PDF_id_solicitud_compra'].' AND cotizacion='. $r['id_cotizacion'];
			
			    $res = $Custom-> ListarHistorialSolicitud(200,0,'','',$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
			$es_cot_det=$Custom->salida;
			//RECORRE ESTADOS DE COTIZACION
			
			foreach ($es_cot_det as $s){
				$fin=$s['fecha_fin'];
				if($s['fecha_fin']==''){
					$fin=date("Y-m-d");
					
				}
			
				array_push($data,array($cont,array("Cotización",$s['estado'],$s['obs_estado']." ",$s['dias']." días",$funciones->fecha_jpgraph($s['fecha_ini']),$funciones->fecha_jpgraph($fin))
			          , $s['fecha_ini'],$fin,FF_FONT2,FS_NORMAL,0,0));
			          
			    $cont++;
			}
			    
			    
			    
			}
			
			
		}
		
		    
		
		// Create the bars and add them to the gantt chart
		for($i=0; $i<count($data); ++$i) {
		    
			if($data[$i][7]!=0){
				
		    	$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],$data[$i][8],10);
			    $bar->title->SetFont(FF_FONT1,FS_BOLD,11);		
			    $bar->rightMark->Show();
			    $bar->rightMark->SetType(MARK_RIGHTTRIANGLE);
			    $bar->rightMark->SetWidth(8);
			    $bar->rightMark->SetColor('black');
			    $bar->rightMark->SetFillColor('black');
		    
			    $bar->leftMark->Show();
			    $bar->leftMark->SetType(MARK_LEFTTRIANGLE);
			    $bar->leftMark->SetWidth(8);
			    $bar->leftMark->SetColor('black');
			    $bar->leftMark->SetFillColor('black');
		    
			    $bar->SetPattern(BAND_SOLID,'black');
			   
			   
		
			    $graph->Add($bar);
		    }
			else{
				
				$bar = new GanttBar($data[$i][0],$data[$i][1],$data[$i][2],$data[$i][3],'',10);
			    if( count($data[$i])>4 )
			        
			    	$bar->title->SetFont($data[$i][4],$data[$i][5],$data[$i][6]);
			    
			    	$bar->SetPattern(BAND_RDIAG,"yellow");
			    
			    $bar->SetFillColor("gray");
			    $bar->progress->SetPattern(GANTT_SOLID,"darkgreen");
			    $bar->title->SetCSIMTarget(array('#1'.$i,'#2'.$i,'#3'.$i,'#4'.$i,'#5'.$i),array('11'.$i,'22'.$i,'33'.$i));
			    $graph->Add($bar);
			    
			}
		}
		
		// ... and display it
		$graph->Stroke();
    	
		
	}
	
	/**Suma la cantidad e dias a una fecha
	 * *******************************************
	 *
	 * @param fecha $fecha
	 * @param entero $ndias
	 * @return fecha sumada
	 */
	
	function suma_fechas($fecha,$ndias)
            

	{
	            
	
	      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
	            
	
	              list($dia,$mes,$año)=split("/", $fecha);
	            
	
	      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
	            
	
	              list($dia,$mes,$año)=split("-",$fecha);
	        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
	        $nuevafecha=date("Y-m-d",$nueva);
	            
	
	      return ($nuevafecha);  
	            
	
	}
	
	/**Resta dos fechas
	 * **********************************************
	 *
	 * @param fecha inicio $dFecIni
	 * @param fecha fin $dFecFin
	 * @return nro de dias
	 */
	
	function restaFechas($dFecIni, $dFecFin)
	{
		
		$dFecIni = str_replace("-","",$dFecIni);
		$dFecIni = str_replace("/","",$dFecIni);
		$dFecFin = str_replace("-","",$dFecFin);
		$dFecFin = str_replace("/","",$dFecFin);
		
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
		ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);
		
		$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
		$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
		
		return round(($date2 - $date1) / (60 * 60 * 24));
	}

	
	
	
	?>