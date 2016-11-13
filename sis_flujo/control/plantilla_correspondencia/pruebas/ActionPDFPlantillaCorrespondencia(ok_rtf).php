<?php
	session_start();
	//Se valida la autentificación	
		
	include_once('../LibModeloFlujo.php');
	include("../../../lib/rtf_new/class_rtf_v2.php");

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
		
		$res = $Custom-> CargoEmpleadoRem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado);
		$cargo_rem = $Custom->salida[0]['nombre_cargo'];
	
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
		$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_empleado');
		$sortcol = $crit_sort->get_criterio_sort();				

		//Obtiene el conjunto de datos de la consulta
		$res = $Custom-> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);		
		$tamanio = sizeof($Custom->salida);		
		
		for($i=0; $i < $tamanio; $i++)
		{		
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.$Custom->salida[$i]['empleado'].' - '.$Custom->salida[$i]['nombre_cargo'].chr(13).chr(10); 
		}	
				   	       	
       	$referencia = strtoupper($referencia);
       	$nombre = strtoupper($nombre);	       	
       	$empleado_remitente = strtoupper($empleado_remitente);
       	$desc_documento = strtoupper($desc_documento);
       	$destinatarios = strtoupper($destinatarios);
       	$cargo_rem = strtoupper($cargo_rem);
    	$Rtf = new Rtf();	    	
    				
		/*---------------- para dar formato al word -------------------*/
		
/*			{\rtf1{\fonttbl{\f0 Arial;}} 				\
		\f0\fs20 Texto del documento\par 			|
		}											|
													|
		{\rtf1{\fonttbl{\f0\ Arial;}{\f1 Verdana;}} |-	para la fuente en word
		\f0\fs20 Letra en Arial\par 				|
		\f1 Letra en Verdana\f0\par 				|
		} 											/

		//TIPO
		\b texto \b0 - Texto en negrita
		\i texto \i0 - Texto en cursiva
		\ul texto \ulnone - Texto subrayado
		\fs40 texto \fs20- Tamaño del texto, antes de empezar a escribir, definimos el tamaño de texto como 20 (\fs20 ), pues si queremos cambiarlo, usaremos '\ftXX ' donde XX es el tamaño y luego volveremos al tamaño por defecto con '\fs20 '
		\par - Final de línea

		//COLORES
		{\rtf1{\fonttbl{\f0 Arial;}} 
		{\colortbl ;\red255\green0\blue0;\red0\green0\blue255;} 
		\f0\fs20\cf1 Rojo\par 
		\cf2 Azul\par 
		\cf0 Automatico 
		}*/
		
		/*-------------------------------------------------------------*/
		$nombre_doc = 'documento.doc'; 			
		$contenido = '{\rtf1{\fonttbl{\f0 Tahoma;}}\qc\b\f0\fs40\ '.$desc_documento.' \par\b0\fs20\ql\b\par 		'.$lugar.'\b0\b				'.$fecha_reg.'\b0\b			'.$numero.'\b0\b\par\par DE:	   '.$nombre.' - '.$cargo_rem.'\b0\b\par A:	   '.$destinatarios.'\b0\b\par ASUNTO: \ul '.$referencia.'\ulnone\b0\par\par\par\par\par\par\par\par\par\par\par\par\par\par\par\par\par\ql Atentamente, \par\par\par\par\qc\par '.$nombre.'\par\b '.$cargo_rem.' \par\b0\ql\par '.$iniciales.'/}';
											
		header( "Content-Type: application/octet-stream"); 
		header( "Content-Disposition: attachment; filename=".$nombre_doc.""); 			
		print($contenido);
	}
?>