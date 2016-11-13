<?php
session_start();
//Se valida la autentificación	
	
include_once('../LibModeloFlujo.php');
include("../../../lib/rtf_new/class_rtf_v2.php");

$Custom = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionPDFPlantillaCorrespondencia.php';		

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
		$fecha_origen = $_POST['fecha_origen'];				//fecha
		$id_tipo_accion = $_POST['id_tipo_accion'];
		$nombre_tipo_accion = $_POST['nombre_tipo_accion'];
		$id_documento = $_POST['id_documento'];
		$mensaje = $_POST['mensaje'];
		$observaciones = $_POST['observaciones'];
		$tipo = $_POST['tipo'];			
		$url_archivo = $_POST['url_archivo'];							
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
		$fecha_origen = $_GET['fecha_origen'];				//fecha
		$id_tipo_accion = $_GET['id_tipo_accion'];
		$nombre_tipo_accion = $_GET['nombre_tipo_accion'];
		$id_documento = $_GET['id_documento'];
		$mensaje = $_GET['mensaje'];
		$observaciones = $_GET['observaciones'];
		$tipo = $_GET['tipo'];					
		$url_archivo = $_GET['url_archivo'];	
	}	
			
	$tipo_documento = utf8_decode($desc_documento);	
	setlocale(LC_TIME, 'sp_ES','sp', 'es');
	$fecha_externa = strftime('%d de %B de %Y', strtotime($fecha_origen));
		
	$fecha_origen = date("d-m-Y", strtotime($fecha_origen.'+1 day')); //formatear la fecha "dd-mm-yyyy"
	
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
	
	if($tipo == 'interna')
	{
		$var = 1;
		$res = $Custom-> AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);	
		if(sizeof($Custom->salida[0]['nombre']) == '')
		{
			echo "<script languaje='javascript' type='text/javascript'>alert('NO EXISTEN DESTINATARIOS PARA LA CORRESPONDENCIA SELECCIONADA'); window.close();</script>"; exit;	
		}
	}
	if($tipo == 'emitida') //externa
	{
		$var = 2;
	}
	
	$res = $Custom-> TipoDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_documento);	
	$tipo_doc = $Custom->salida[0]['codigo']; 
		
	$tamanio = sizeof($Custom->salida);	
		
	for($i=0; $i < $tamanio; $i++)
	{		
		$accion = $accion.''.$Custom->salida[$i]['nombre'].',';		
	}
	
	$accion1 = explode(',',$accion);
	$tamanio = sizeof($accion1);
					
	for($i=0; $i < $tamanio; $i++)
	{		
		$acciones = $acciones.''.$accion1[$i].'<BR>';
				
		switch ($accion1[$i])
		{
			case 'Aprobar': $aprobar = 'X';
							break;
							
			case 'Archivar': $archivar = 'X';
							break;
							
			case 'Para Conocimiento': $para_conocimiento = 'X';
							break;
							
			case 'Analizar y comentar': $analizar_comentar = 'X';
							break;
							
			case 'Proceder': $proceder = 'X';
							break;
		
			case 'Difundir': $difundir = 'X';
							break;
							
			case 'Firmar': $firmar = 'X';
							break;
			
			case 'Verificar': $verificar = 'X';
							break;
			
			case 'Informar': $informar = 'X';
							break;
							
			case 'Responder': $responder = 'X';
							break;
							
			case 'Tomar nota': $tomar_nota = 'X';
							break;
							
			case 'Para su consideración': $para_consideracion = 'X';
							break;
		}
	}	
	
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom-> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var);	
	//echo var_dump($Custom); exit;
	if($Custom->salida[0]['estado'] == 'anulado')
	{
		echo "<script languaje='javascript' type='text/javascript'>alert('NO EXISTEN DESTINATARIOS PARA LA CORRESPONDENCIA SELECCIONADA'); window.close();</script>"; exit;	
	}
	
	$tamanio = sizeof($Custom->salida);		
		
	for($i=0; $i < $tamanio; $i++)
	{		
		if($var == 1)	
		{
			$v_empleado = explode(' ',$Custom->salida[$i]['empleado']);
			
			if($v_empleado[3] != '')
			{
				//0=1er nombre, 1=2do nombre, 2=Ap pat, 3=Ap mat										
				$v_empleado[1] = substr($v_empleado[1],0,1);
				$v_empleado[3] = substr($v_empleado[3],0,1);
				
				$Custom->salida[$i]['empleado'] = $v_empleado[0].' '.$v_empleado[1].'. '.$v_empleado[2].' '.$v_empleado[3].'.';
			}
			else 
			{
				//0=1er nombre, 1=Ap pat, 2=Ap mat								
				$v_empleado[2] = substr($v_empleado[2],0,1);
				
				$Custom->salida[$i]['empleado'] = $v_empleado[0].' '.$v_empleado[1].' '.$v_empleado[2].'.';
			}				
			
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.'<strong>'.$Custom->salida[$i]['empleado'].' - '.$Custom->salida[$i]['nombre_cargo'].'</strong>'.chr(13).chr(10).'<TAB><TAB><TAB>'; 
		}
		else
		{
			$remitente = ucwords(strtolower($Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno']));
			$institucion = $Custom->salida[$i]['institucion'];
			$destinatarios = $destinatarios.''.$remitente.'<BR><strong>'.$Custom->salida[$i]['institucion'].'</strong>';
		}
	}
			
	$inicial = explode(' ', $_SESSION["ss_nombre_usuario"]);

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
		       	
	$desc_documento = utf8_decode($desc_documento);
	$desc_documento = mb_strtoupper($desc_documento);
	
	$lugar=strtoupper($_SESSION["ss_nombre_lugar"]);			//lugar
		
 	$referencia = utf8_decode($referencia);
	$referencia = mb_strtoupper($referencia);
	//$referencia = strtoupper($referencia);
   	
	$nombre = utf8_decode($nombre);
	$nombre = mb_strtoupper($nombre);	       	
   	
	$empleado_remitente = utf8_decode($empleado_remitente);
	$empleado_remitente = mb_strtoupper($empleado_remitente);    	
		       	
	if($var == 1)
		$destinatarios = mb_strtoupper($destinatarios);
	
   	$cargo_rem = utf8_decode($cargo_rem); 	       	
	$cargo_rem = mb_strtoupper($cargo_rem); 
	
	$iniciales = strtolower($iniciales);						//iniciales			      	
	$Rtf = new Rtf();
	$azul = 0x00001B39;	    	
				
	Header("Content-type: image/jpeg"); 
		
	if($var == 1)
	{
		$nombre_fichero = $tipo_doc.".jpg";
		$handle = fopen($tipo_doc.".jpg",'r');						
		$contenido = fread($handle, filesize($nombre_fichero));
		fwrite($handle, $contenido);
		$titulo_tmp = imagecreatefromstring($contenido);
		imagejpeg($titulo_tmp,"/tmp/titulo_$id_correspondencia.jpg");
		fclose($handle);
		
		$titulo_doc = imagecreatefromjpeg("/tmp/titulo_$id_correspondencia.jpg");						
		$titulo = $lugar;
		ImageString($titulo_doc, 5, 103, 118, $titulo, '');
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
			
		$titulo = $fecha_origen;
		ImageString($titulo_doc, 5, 333, 118, $titulo, '');
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
		
		$titulo = $numero;
		ImageString($titulo_doc, 5, 449, 118, $titulo, '');
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
	}

	$desc_empleado = ucwords(strtoupper($desc_empleado));
	
	$empleado = explode(' ',$desc_empleado);
	
	if($empleado[3] != '')
	{
		//0=1er nombre, 1=2do nombre, 2=Ap pat, 3=Ap mat
		$aux = $empleado[0];
		$empleado[0] = $empleado[2];
		$empleado[2] = $aux;
		
		$aux = $empleado[1];
		$empleado[1] = $empleado[3];
		$empleado[3] = $aux;
				
		$empleado[1] = substr($empleado[1],0,1);
		$empleado[3] = substr($empleado[3],0,1);
		
		$desc_empleado = $empleado[0].' '.$empleado[1].'. '.$empleado[2].' '.$empleado[3].'.';
	}
	else 
	{
		//0=1er nombre, 1=Ap pat, 2=Ap mat
		$aux = $empleado[1];
		$empleado[1] = $empleado[2];
		$empleado[2] = $aux;
		
		$aux = $empleado[1];
		$empleado[1] = $empleado[0];
		$empleado[0] = $aux;
		
		$empleado[2] = substr($empleado[2],0,1);
		
		$desc_empleado = $empleado[0].' '.$empleado[1].' '.$empleado[2].'.';
	}
	
	if($var == 1) //internas
	{
		$Rtf->setPaperSize(1); //tamaño carta
		$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imágen en el encabezado
		$Rtf->addText('<strong>A:</strong><TAB><TAB><TAB>'.$destinatarios.'<BR>');
		$Rtf->addText('<strong>DE:<TAB><TAB><TAB>'.$desc_empleado.' - '.$cargo_rem.'</strong><BR>');			
		$Rtf->addText('<strong>ASUNTO:<TAB><u>'.$referencia.'</strong></u><BR><BR>');
				
		if($tipo_documento == 'COMUNICACION INTERNA')
		{
			$Rtf->tablaCI($aprobar,$archivar,$para_conocimiento,$analizar_comentar,$proceder,$difundir,$firmar,$verificar,$informar,$responder,$tomar_nota,$para_consideracion);			
		}
		
		$Rtf->addText('<BR><BR><BR><BR><BR><BR>');			
		$Rtf->addText('<TAB><TAB><TAB>Atentamente, <BR><BR><BR><BR><BR>');
		$desc_empleado = ucwords(strtolower($desc_empleado));
		$Rtf->addText('<TAB><TAB><TAB>'.$desc_empleado.'<BR><TAB><TAB><TAB><strong>'.$cargo_rem.'</strong><BR><BR><BR><BR>');		
		$Rtf->tamanio_fuente("$iniciales");				
		$Rtf->addText("\n");
		$Rtf->crono(); //insertar c.c.	
		$Rtf->paginacion(); //inserta número de página
		$Rtf->getDocument('documento.rtf');
	}
	
	else //externas
	{
		$lugar = ucwords(strtolower($lugar));
		$desc_empleado = ucwords(strtolower($desc_empleado));
		//$referencia = ucwords(strtolower($referencia));
		$Rtf->setPaperSize(1);
		$Rtf->margenes(2500);	
		$Rtf->addTextAlign($lugar.", $fecha_externa","derecha");
		$Rtf->addText("\n");
		$Rtf->addText($numero);
		$Rtf->addText('<BR><BR><BR><BR><BR>');		
		$Rtf->addTextAlign("Señor","justificado");
		$Rtf->addText("\n");
		$Rtf->addText("$destinatarios");
		$Rtf->addText("<strong></strong>");
		$Rtf->addText("\n");
		$Rtf->addText("Av. \n");
		$Rtf->addText("Telf.: \n");
		$Rtf->addText("<u>Ciudad.-</u>");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addTextAlign('',"derecha");
		$Rtf->addText("<u><strong>Ref.- $referencia</strong></u>");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addTextAlign("De nuestra consideración:","justificado");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addText('<TAB><TAB>A tiempo de saludarle muy cordialmente,... <BR><BR><BR>');
		$Rtf->addText('<TAB><TAB>Sin otro particular, le reitero mis distinguidas consideraciones,... <BR><BR><BR>');
		$Rtf->addText('<TAB><TAB>Atentamente, <BR><BR><BR><BR><BR>');
		$Rtf->addText('<TAB><TAB>'.$desc_empleado);		
		$Rtf->addText('<BR><TAB><TAB><strong>'.$cargo_rem.'</strong><BR>');
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->tamanio_fuente($iniciales);
		$Rtf->addText("\n");
		$Rtf->crono(); //insertar c.c.		
		$Rtf->getDocument('documento.rtf');
	}	
}
?>