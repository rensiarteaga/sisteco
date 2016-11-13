<?php
	session_start();
	//Se valida la autentificación	
		
	include_once('../LibModeloFlujo.php');

	$Custom = new cls_CustomDBFlujo();
	$nombre_archivo = 'ActionPDFPlantillaCorrespondencia.php';
		
	$inicial = explode(' ', $_GET['desc_empleado']);

	if($inicial[3] != '')
	{
		$aux = $inicial[0];
		$inicial[0] = $inicial[2];
		$inicial[2] = $aux;
		
		$aux = $inicial[1];
		$inicial[1] = $inicial[3];
		$inicial[3] = $aux;
		
		$nombre = $inicial[0].' '.$inicial[1].' '.$inicial[2].' '.$inicial[3];
	}
	else 
	{
		$aux = $inicial[1];
		$inicial[1] = $inicial[2];
		$inicial[2] = $aux;
		
		$aux = $inicial[1];
		$inicial[1] = $inicial[0];
		$inicial[0] = $aux;
		
		$nombre = $inicial[0].' '.$inicial[1].' '.$inicial[2];
	}
	
	for($i = 0; $i < (sizeof($inicial)); $i++)
	{
		$iniciales = $iniciales.substr($inicial[$i], 0, 1);	
	}
	
	$iniciales = strtolower($iniciales);						//iniciales
	$lugar=$_SESSION["ss_nombre_lugar"];						//lugar
	
	if (!isset($_SESSION['autentificado']))
	{
		echo "El usuario no se encuentra autentificado";
	}
	if($_SESSION['autentificado']=='SI')
	{
		//Parámetros del filtro
		if($limit == '') $cant = 15;
		else $cant = $limit;
	
		if($start == '') $puntero = 0;
		else $puntero = $start;
	
		if($sort == '') $sortcol = '0=0';
		else $sortcol = $sort;
	
		if($dir == '') $sortdir = 'asc';
		else $sortdir = $dir;
		
		//Se valida el método de paso de variables del formulario
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
  			$referencia = $_POST['referencia'];					//asunto
  			$desc_empleado = $_POST['desc_empleado'];			//DE:
  			$numero = $_POST['numero'];							//numero
  			$empleado_remitente = $_POST['empleado_remitente'];		
  			$desc_documento = $_POST['desc_documento'];			//tipo documento
  			$id_empleado = $_POST['id_empleado'];			
			$id_correspondencia = $_POST['id_correspondencia'];
			$fecha_reg = $_POST['fecha_reg'];					//fecha
			$id_tipo_accion = $_POST['id_tipo_accion'];
			$nombre_tipo_accion = $_POST['nombre_tipo_accion'];
			$acciones = $_POST['acciones'];
			$mensaje = $_POST['mensaje'];
			$observaciones = $_POST['observaciones'];
			$cite = $_POST['cite'];
						
  			/*$id_depto = $_POST['id_depto'];
			$desc_depto = $_POST['desc_depto'];			
			$id_documento = $_POST['id_documento'];			
			$id_uo = $_POST['id_uo'];
			$desc_uo = $_POST['desc_uo'];
			$id_institucion = $_POST['id_institucion'];
			$desc_institucion = $_POST['desc_institucion'];
			$id_persona = $_POST['id_persona'];
			$desc_persona = $_POST['desc_persona'];			
			$fecha_origen = $_POST['fecha_origen'];
			$hora_origen = $_POST['hora_origen'];
			$fecha_destino = $_POST['fecha_destino'];
			$hora_destino = $_POST['hora_destino'];
			$desc_usuario = $_POST['desc_usuario'];			
			$accion = $_POST['accion'];
			$tipo = $_POST['tipo'];		
			$url_archivo = $_POST['url_archivo'];			
			$uo_remitente = $_POST['uo_remitente'];
			$id_correspondencia_fk = $_POST['id_correspondencia_fk'];
			$padre = $_POST['padre'];			
			$estado = $_POST['estado'];			
			$observaciones_estado = $_POST['observaciones_estado'];
			$derivado = $_POST['derivado'];
			$dias_derivado = $_POST['dias_derivado'];
			$fecha_derivado = $_POST['fecha_derivado'];			
			$ver = $_POST['ver'];			
			$empleados = $_POST['empleados'];	*/				
  			
		} 
		else 
		{
  			$referencia = $_GET['referencia'];					//asunto
  			$desc_empleado = $_GET['desc_empleado'];			//DE:
  			$numero = $_GET['numero'];							//numero
  			$empleado_remitente = $_GET['empleado_remitente'];		
  			$desc_documento = $_GET['desc_documento'];			//tipo documento
  			$id_empleado = $_GET['id_empleado'];			
			$id_correspondencia = $_GET['id_correspondencia'];
			$fecha_reg = $_GET['fecha_reg'];					//fecha
			$id_tipo_accion = $_GET['id_tipo_accion'];
			$nombre_tipo_accion = $_GET['nombre_tipo_accion'];
			$acciones = $_GET['acciones'];
			$mensaje = $_GET['mensaje'];
			$observaciones = $_GET['observaciones'];
			$cite = $_GET['cite'];
						
  			/*$id_depto = $_GET['id_depto'];
			$desc_depto = $_GET['desc_depto'];			
			$id_documento = $_GET['id_documento'];			
			$id_uo = $_GET['id_uo'];
			$desc_uo = $_GET['desc_uo'];
			$id_institucion = $_GET['id_institucion'];
			$desc_institucion = $_GET['desc_institucion'];
			$id_persona = $_GET['id_persona'];
			$desc_persona = $_GET['desc_persona'];			
			$fecha_origen = $_GET['fecha_origen'];
			$hora_origen = $_GET['hora_origen'];
			$fecha_destino = $_GET['fecha_destino'];
			$hora_destino = $_GET['hora_destino'];
			$desc_usuario = $_GET['desc_usuario'];			
			$accion = $_GET['accion'];
			$tipo = $_GET['tipo'];		
			$url_archivo = $_GET['url_archivo'];			
			$uo_remitente = $_GET['uo_remitente'];
			$id_correspondencia_fk = $_GET['id_correspondencia_fk'];
			$padre = $_GET['padre'];			
			$estado = $_GET['estado'];			
			$observaciones_estado = $_GET['observaciones_estado'];
			$derivado = $_GET['derivado'];
			$dias_derivado = $_GET['dias_derivado'];
			$fecha_derivado = $_GET['fecha_derivado'];			
			$ver = $_GET['ver'];			
			$empleados = $_GET['empleados'];	*/					
  		}
		
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
			
		$criterio_filtro = $cond -> obtener_criterio_filtro();
				
		//Obtiene el criterio de orden de columnas
		$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_correspondencia');
		$sortcol = $crit_sort->get_criterio_sort();

		//Obtiene el conjunto de datos de la consulta
		/*$res = $Custom-> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);	
	
		$tamanio = sizeof($Custom->salida);
		
		
		for($i=0; $i < $tamanio; $i++)
		{		
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.$Custom->salida[$i]['empleado'].' - '.$Custom->salida[$i]['nombre_cargo'].' '.chr(13).chr(10); 
		}*/
					
			//Clase necesaria para la generación de reporte  
			require_once('../../../lib/lib_modelo/ReportDriver.php');
			
			//se crea una instancia de la clase pasandole el nombre del archivo del reporte
			
	       	$reporte=new ReportDriver('report_plantilla_correspondencia.jasper','flujo','docx');
	       	//$reporte=new ReportDriver('sr_destinatarios.jasper','flujo','rtf'); $P{SUBREPORT_DIR} + "sr_destinatarios.jasper"
	       	
	       	$referencia = strtoupper($referencia);
	       	$nombre = strtoupper($nombre);	       	
	       	$empleado_remitente = strtoupper($empleado_remitente);
	       	$desc_documento = strtoupper($desc_documento);
	       	    	       
			$reporte->addParametroURL('style_reports','../../../lib/styles_reporte/style_first.jrtx');
			$reporte->addParametroURL('SUBREPORT_DIR','sr_destinatarios.jasper');
			$reporte->addParametro('referencia',$referencia);
			$reporte->addParametro('desc_empleado',$nombre);
			$reporte->addParametro('lugar',$lugar);
			$reporte->addParametro('numero',$numero);
			$reporte->addParametro('empleado_remitente',$empleado_remitente);
			$reporte->addParametro('iniciales',$iniciales);
			$reporte->addParametro('desc_documento',$desc_documento);
			$reporte->addParametro('id_empleado',$id_empleado);			
			$reporte->addParametro('id_correspondencia',$id_correspondencia);
			$reporte->addParametroURL('membrete','membrete.jpg');			
						
			$reporte->runReporte();		
	}
?>