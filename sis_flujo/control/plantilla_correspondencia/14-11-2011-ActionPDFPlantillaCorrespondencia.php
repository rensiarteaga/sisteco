<?php
session_start();
//Se valida la autentificación	
	
include_once('../LibModeloFlujo.php');
include("../../../lib/rtf_new/class_rtf_v2.php");

$Custom = new cls_CustomDBFlujo();
$CustomG = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionPDFPlantillaCorrespondencia.php';	
		
$fecha_actual = date("d-m-Y H:i:s");

function acentos_enies($cadena)
{
	$minusculas = array ("á"=>"á","é"=>"é","í"=>"í","ó"=>"ó", "ú"=>"ú","ñ"=>"ñ");
	$mayusculas = array ("Á"=>"Á","É"=>"É","Í"=>"Í","Ó"=>"Ó", "Ú"=>"Ú","Ñ"=>"Ñ");
	
	$cad = strtr($cadena,$minusculas);
	$cad = strtr($cadena,$mayusculas);
	return $cad;
}

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
		//$referencia = $_POST['referencia'];					//asunto
		//$desc_empleado = $_POST['desc_empleado'];			//DE:
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
		$id_correspondencia_fk = $_POST['id_correspondencia_fk'];
	} 
	else 
	{
		//$referencia = $_GET['referencia'];					//asunto
		//$desc_empleado = $_GET['desc_empleado'];			//DE:
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
		$id_correspondencia_fk = $_GET['id_correspondencia_fk'];
	}	
	
	//echo $desc_documento; exit;
	
	if (eregi('GGN', $numero)) 
	{
		$gerencia = 'GGN';
		$responsable = 'GERENTE GENERAL<BR>RESPONSABLE DEL PROCESO DE<BR>CONTRATACIÓN DIRECTA - RPCD';
	}
	else 
	{
		$gerencia = 'RPCD';
		$responsable = 'RESPONSABLE DEL PROCESO DE<BR>CONTRATACIÓN DIRECTA - RPCD';
	}
		
	$tipo_documento = utf8_decode($desc_documento);	
	setlocale(LC_TIME, 'sp_ES','sp', 'es');
	$fecha_externa = strftime('%d de %B de %Y', strtotime($fecha_origen.'+1 day'));
					
	$fecha_origen = date("d-m-Y", strtotime($fecha_origen.'+1 day')); //formatear la fecha "dd-mm-yyyy"
	
	$fecha_remision = explode('-',$fecha_origen);
	
	$dia = $fecha_remision[0];
	$mes = strtoupper($fecha_remision[1]);
	$anio = $fecha_remision[2];
	
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
			
	$cargo_rem = acentos_enies($Custom->salida[0]['nombre_cargo']); //cargo del remitente
	$nombre_rem = acentos_enies($Custom->salida[0]['nombre']); //nombre del remitente
	$ap_pat_rem = acentos_enies($Custom->salida[0]['apellido_paterno']); //ap pat del remitente
	$ap_mat_rem = acentos_enies($Custom->salida[0]['apellido_materno']); //ap mat del remitente
	
	$desc_empleado = "$nombre_rem $ap_pat_rem $ap_mat_rem";
	
	if($Custom->salida[0]['nivel_academico'] != '')
		$nivel_acad = strtoupper(acentos_enies($Custom->salida[0]['nivel_academico'])).' ';
	else 
		$nivel_acad = 'SR. ';
		
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
	}
	if($tipo == 'emitida') //externa
	{
		$var = 2;
	}
	
	$res = $Custom-> TipoDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_documento);	
	$tipo_doc = $Custom->salida[0]['codigo']; 
			
	$res = $Custom-> AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
	//echo var_dump($Custom); exit;
					
	if($Custom->salida[0]['nombre'] == '' && $tipo_documento == 'COMUNICACION INTERNA')
	{
		echo "<script languaje='javascript' type='text/javascript'>alert('DATOS INCORRECTOS PARA LA CORRESPONDENCIA SELECCIONADA. NO EXISTEN ACCIONES.'); window.close();</script>"; exit;	
	}
	else 
	{
	
		$tamanio = sizeof($Custom->salida);
		
		$accion1 = explode('; ',$Custom->salida[0]['nombre']);
		$tamanio_acc = sizeof($accion1);
						
		for($i=0; $i < $tamanio_acc; $i++)
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
	}
		
	//Obtiene el conjunto de datos de la consulta
	$res = $Custom-> PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var);
	//echo var_dump($Custom); Exit;
	
	$empleado_remision = mb_strtoupper($Custom->salida[0]['nivel_academico']).' '.mb_strtoupper($Custom->salida[0]['nombre'].' '.$Custom->salida[0]['apellido_paterno'].' '.$Custom->salida[0]['apellido_materno']);
	
	$cargo_remision = mb_strtoupper($Custom->salida[0]['nombre_cargo']);
	$referencia = $Custom->salida[0]['referencia'];	
	$tamanio = sizeof($Custom->salida);		
	
	for($i=0; $i < $tamanio; $i++)
	{		
		if($var == 1)	
		{			
			/*$v_empleado = explode(' ',acentos_enies($Custom->salida[$i]['empleado'])); //para mostrar nombre con abreviaciones
			
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
			}*/
			
			if($Custom->salida[$i]['nivel_academico'] != '')
				$nivel_acad1 = strtoupper(acentos_enies($Custom->salida[$i]['nivel_academico'])).' ';
			else 
				$nivel_acad1 = 'SR(A). ';
			
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.'<strong>'.$nivel_acad1.$Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno'].' - '.acentos_enies($Custom->salida[$i]['nombre_cargo']).'</strong>'.chr(13).chr(10).'<TAB><TAB><TAB>'; 
		}
		else
		{
			$remitente = ucwords(strtolower($Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno']));
			$institucion = $Custom->salida[$i]['institucion'];
			$destinatarios = $destinatarios.''.$remitente.'<BR><strong>'.$Custom->salida[$i]['institucion'].'</strong>';
		}
	}
	
	//echo $destinatarios; exit;
			
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
	
	if($desc_documento == 'RESOLUCION DE VIAJES EN FERIADOS O FINES DE SEMANA')
	{
		$sw = 1;
		
		$resG = $CustomG -> EmpleadoGteGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado);
		
		//echo var_dump($CustomG); exit;
		
		$nivel_viaje = $CustomG -> salida[0]['nivel_academico']; 
		$nombre_viaje = ucwords(strtolower($CustomG -> salida[0]['nombre_completo']));
		$cargo_viaje = $CustomG -> salida[0]['nombre_cargo'];
	}
		
	$lugar = strtoupper($_SESSION["ss_nombre_lugar"]);			//lugar				
 	$referencia = acentos_enies($referencia);
	$referencia = mb_strtoupper($referencia);
   	
	$nombre = utf8_decode($nombre);
	$nombre = mb_strtoupper($nombre);	       	
   	
	$empleado_remitente = utf8_decode($empleado_remitente);
	$empleado_remitente = mb_strtoupper($empleado_remitente);    	
		       	
	if($var == 1)
	{
		//$destinatarios = utf8_decode($destinatarios);
		$destinatarios = mb_strtoupper($destinatarios);
		$destinatarios = acentos_enies($destinatarios);
	}
	
   	$cargo_rem = mb_strtoupper($cargo_rem);
	
	$codigo_hash = sha1($_SESSION["ss_nombre_usuario"].$lugar.$numero.gregoriantojd(date('m'),date('d'),date('Y')).date("H:i:s")); //HASH
	
	$iniciales = strtolower($iniciales);						//iniciales			      	
	$Rtf = new Rtf();
	$azul = 0x00001B39;
	
	$im = imagecreatetruecolor(50, 20);
	$plomo = imagecolorallocate($im, 110, 110, 112);
	$negro = imagecolorallocate($im, 0, 0, 0);
	$blanco = imagecolorallocate($im, 255, 255, 255);
					
	Header("Content-type: image/jpeg"); 
		
	if($var == 1)
	{					
		/*$nombre_fichero = "img/HASH.jpg";
		$handle = fopen("img/HASH.jpg",'r');
		
		$contenido = fread($handle, filesize($nombre_fichero));
		fwrite($handle, $contenido);
		$titulo_tmp = imagecreatefromstring($contenido);
		imagejpeg($titulo_tmp,"/tmp/HASH.jpg");
		fclose($handle);
		
		$titulo_doc = imagecreatefromjpeg("/tmp/HASH.jpg");
		
		$cod_hash1 = substr($codigo_hash, 0, -20);
		$cod_hash2 = substr($codigo_hash, -20);
		
		ImageString($titulo_doc, 1, 45, 0, $cod_hash1, '');		//hash en imágen de logo
		imagejpeg($titulo_doc,"/tmp/HASH.jpg");
		
		ImageString($titulo_doc, 1, 45, 10, $cod_hash2, '');		//hash en imágen de logo
		imagejpeg($titulo_doc,"/tmp/HASH.jpg");
								
		// Rotar la imagen
		imagejpeg(imagerotate(imagecreatefromjpeg("/tmp/HASH.jpg"), 90, 0),"/tmp/HASH.jpg");*/
		
		/*if($tipo_doc == 'CI' || $tipo_doc == 'CIR' || $tipo_doc == 'CM' || $tipo_doc == 'IL' || $tipo_doc == 'IN' || $tipo_doc == 'IV' || $tipo_doc == 'ME')
		{			
			$nombre_fichero = "img/$tipo_doc.jpg";
			$handle = fopen("img/$tipo_doc.jpg",'r');
		}
		else 
		{*/		
			$nombre_fichero = "img/LOGO1.jpg";
			$handle = fopen("img/LOGO1.jpg",'r');		
		//}
		
		$contenido = fread($handle, filesize($nombre_fichero));
		fwrite($handle, $contenido);
		$titulo_tmp = imagecreatefromstring($contenido);
		imagejpeg($titulo_tmp,"/tmp/titulo_$id_correspondencia.jpg");
		fclose($handle);
		
		$titulo_doc = imagecreatefromjpeg("/tmp/titulo_$id_correspondencia.jpg");
				
		/*if($tipo_doc == 'CI' || $tipo_doc == 'CIR' || $tipo_doc == 'CM' || $tipo_doc == 'IL' || $tipo_doc == 'IN' || $tipo_doc == 'IV' || $tipo_doc == 'ME')
		{
			//generación normal de imagen
		}
		else //caso que no tengan imagenes prediseñadas para el titulo se genera titulo e inserta en la imagen
		{*/
		
		$tam_desc_doc = strlen($desc_documento);		
		
		if($tam_desc_doc >= 25)
		{
			$desc_documento_1 = explode(' ',$desc_documento);
			$lenght = sizeof($desc_documento_1);
			$dim = 0;
			
			for($j = 0; $j <= $lenght; $j++)
			{
				if($dim <= 21)	
				{
					$cadena = $cadena.$desc_documento_1[$j].' ';
					$dim = strlen($cadena);
				}
				else 
					$cadena1 = $cadena1.$desc_documento_1[$j].' ';
			}
					
			$desc_documento = $cadena.chr(13).chr(10).$cadena1;
			
			$fuente = 'fonts_ttf/ariblk.ttf';
			imagettftext($titulo_doc, 16, 0, 135, 100, $negro, $fuente, $desc_documento);
		}		
		else 
		{
			$fuente = 'fonts_ttf/ariblk.ttf';
			imagettftext($titulo_doc, 22, 0, 135, 130, $negro, $fuente, $desc_documento);			
		}
		
		//echo $desc_documento; exit;
				
		//}
		
		/*$cod_hash1 = substr($codigo_hash, 0, -20);
		$cod_hash2 = substr($codigo_hash, -20);
		
		ImageString($titulo_doc, 1, 5, 0, $cod_hash1, $blanco);		//hash en imágen de logo
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
		
		ImageString($titulo_doc, 1, 5, 10, $cod_hash2, $blanco);		//hash en imágen de logo
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");*/
		
		//ImageString($titulo_doc, 2, 35, 5, 'ENDESIS', $blanco);
		$fuente = 'fonts_ttf/ARIALNBI.TTF';
		imagettftext($titulo_doc, 10, 0, 33, 18, $blanco, $fuente, 'ENDESIS');
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
		
		$fuente = 'fonts_ttf/tahomabd.ttf';
		//ImageString($titulo_doc, 4, 190, 118, $lugar, '');
		imagettftext($titulo_doc, 10, 0, 200, 175, $negro, $fuente, $lugar);
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
			
		//ImageString($titulo_doc, 4, 440, 118, $titulo, '');
		imagettftext($titulo_doc, 10, 0, 440, 175, $negro, $fuente, $fecha_origen);
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
		
		//ImageString($titulo_doc, 4, 554, 118, $titulo, '');
		imagettftext($titulo_doc, 10, 0, 558, 175, $negro, $fuente, $numero);
		imagejpeg($titulo_doc,"/tmp/titulo_$id_correspondencia.jpg");
				
		/*// Crear instancias de imágenes
		$origen = imagecreatefromjpeg('/tmp/HASH.jpg');
		$destino = imagecreatefromjpeg("/tmp/titulo_$id_correspondencia.jpg");
		
		// Copiar y fusionar
		imagecopymerge($destino, $origen, 0, 0, 0, 0, 37, 150, 100);
		
		// Imprimir y liberar memoria		
		imagejpeg($destino,"/tmp/titulo_$id_correspondencia.jpg");	*/	
	}

	$desc_empleado = utf8_decode($desc_empleado);
	$desc_empleado = acentos_enies($desc_empleado);
	$desc_empleado = ucwords(strtoupper($desc_empleado));
	
	/*$empleado = explode(' ',$desc_empleado); 
	
	if($empleado[3] != '') //tiene dos nombres
	{
		//0=1er nombre, 1=2do nombre, 2=Ap pat, 3=Ap mat
		$aux = $empleado[0];
		$empleado[0] = $empleado[2];
		$empleado[2] = $aux;
		
		$aux = $empleado[1];
		$empleado[1] = $empleado[3];
		$empleado[3] = $aux;
				
		//$empleado[1] = substr($empleado[1],0,1);
		//$empleado[3] = substr($empleado[3],0,1);
		
		$desc_empleado = $empleado[0].' '.$empleado[1].' '.$empleado[2].' '.$empleado[3];
	}
	else //tiene un solo nombre
	{
		//0=1er nombre, 1=Ap pat, 2=Ap mat
		$aux = $empleado[1];
		$empleado[1] = $empleado[2];
		$empleado[2] = $aux;
		
		$aux = $empleado[1];
		$empleado[1] = $empleado[0];
		$empleado[0] = $aux;
		
		//$empleado[2] = substr($empleado[2],0,1);
		
		$desc_empleado = $empleado[0].' '.$empleado[1].' '.$empleado[2];
	}*/
	
	//echo $desc_documento; exit;	
		
	if($var == 1) //internas
	{
		if($desc_documento == 'RESOLUCION')
		{
			$Rtf->margenes(2000,'izq');
			$Rtf->margenes(1500,'der');
			$Rtf->setPaperSize(1);
			$Rtf->rtfImagentxt('img/logo_res.jpg','jpg',$numero, $gerencia);					
			$Rtf->addTextAlign("","centro");
			$Rtf->addText("<strong><u>$referencia<BR></strong></u>");
			$Rtf->addText("\n");
			$Rtf->addTextAlign('',"justificado");
			$Rtf->addText('<strong><u>CONSIDERANDO:</strong></u>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			
			$Rtf->addText('<strong><u>POR TANTO:</strong></u>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");	
						
			$Rtf->addText("\n");			
			$Rtf->addTextAlign('',"justificado");			
			$Rtf->addText('<strong><u>RESUELVE:</strong></u><BR><BR>');
						
			$Rtf->addText('<strong><u>PRIMERO.-</strong></u><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			
			$Rtf->addTextAlign(ucwords(strtolower($lugar)).", $fecha_externa","centro");
			$Rtf->addText('<BR><BR><BR><BR><BR>');
			$Rtf->addTextAlign('','centro');
			
			$Rtf->addText(ucwords(strtolower($nivel_acad.$desc_empleado)).'<BR><strong>'.$responsable.'</strong>');
			$Rtf->getDocument("$numero.rtf");
		}

		elseif($desc_documento == 'REMISION DE DOCUMENTOS')
		{
			$Rtf->setPaperSize(1);
			$Rtf->tablaRemision($numero, $desc_documento,$dia, $mes, $anio, $nivel_acad, $desc_empleado, $empleado_remision, 'img/Log pequeño.jpg', $cargo_rem, $cargo_remision);			
			//$Rtf->addText("<BR><BR><BR><BR><BR>");				
			$Rtf->getDocument("$numero.rtf");
		}	
		
		elseif($desc_documento == 'ALCANCE DE TRABAJO')
		{
			$Rtf->setPaperSize(1);
			$Rtf->addTextAlign("","centro");
			$Rtf->addText("\n");
			$Rtf->addText("<strong>$referencia<BR></strong>");
			$Rtf->addText("\n");
			$Rtf->addTextAlign('',"justificado");
			$Rtf->addText('<strong>1.<TAB>OBJETO DEL SERVICIO</strong><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>2.<TAB>ALCANCE DEL SERVICIO</strong><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>3.<TAB>LUGAR</strong><BR>');	
			$Rtf->addText("<BR><BR><BR><BR><BR>");			
			$Rtf->addText('<strong>4.<TAB>REQUISITOS</strong><BR>');					
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>5.<TAB>TIEMPOS DE SERVICIO</strong><BR>');
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imágen en el encabezado
			$Rtf->cambiar_fuente(3,14,$iniciales.'/');
			$Rtf->addText("\n");
			$Rtf->crono(); //insertar c.c.		
			$Rtf->getDocument("$numero.rtf");
		}
		
		elseif($sw == 1) // RESOLUCION DE VIAJES EN FINES DE SEMANA O FERIADOS
		{
			$Rtf->setPaperSize(1);
			$Rtf->addTextAlign("","justificado");
			$Rtf->addText("\n");
			$Rtf->addText('<strong>CONSIDERANDO</strong><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>POR LO TANTO.-</strong><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>RESUELVE.-</strong><BR>');	
			$Rtf->addText("<BR><BR><BR><BR><BR>");			
			$Rtf->addText('<strong>PRIMERO.-</strong><BR>');					
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('<strong>SEGUNDO.-</strong><BR>');
			$Rtf->addText("<BR><BR><BR><BR><BR>");
			$Rtf->addText('Regístrese, comuníquese, archívese.<BR>');
			$Rtf->addText("\n");
			$Rtf->addTextAlign(ucwords(strtolower($lugar)).", $fecha_externa","centro");
			$Rtf->addText("<BR><BR><BR><BR><BR>");	
			$Rtf->addText("$nivel_viaje $nombre_viaje");		
			$Rtf->addText("<BR><strong>$cargo_viaje INTERINO</strong><BR>");	
			$Rtf->addText("<BR><BR><BR>");
			$Rtf->addTextAlign("","justificado");
			$Rtf->cambiar_fuente(3,14,$iniciales.'/');
			$Rtf->addText("\n");
			$Rtf->crono(); //insertar c.c.	
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imágen en el encabezado
			
			$Rtf->getDocument("$numero.rtf");
		}		
			
		else 
		{
			$Rtf->setPaperSize(1); //tamaño carta			
			$Rtf->margenes(2050,'izq');
			$Rtf->margenes(1000,'der');			
			//$Rtf->addText_fuente_tam(3,18,'<strong><BR>A:</strong><TAB><TAB><TAB>'.$destinatarios.'<BR>'); //para cambiar tamaño de la fuente en relacion a la que tiene el documento
			$Rtf->addText('<strong><BR>A:</strong><TAB><TAB><TAB>'.$destinatarios.'<BR>');
			$Rtf->addText('<strong>DE:<TAB><TAB><TAB>'.$nivel_acad.$desc_empleado.' - '.$cargo_rem.'</strong><BR>');			
			$Rtf->addTextAlign("","justificado");
			$Rtf->addText('<strong><BR>ASUNTO:<TAB><u>'.$referencia.'</strong></u><BR><BR>');
			
			if($tipo_documento == 'COMUNICACION INTERNA')
			{
				$Rtf->tablaCI($aprobar,$archivar,$para_conocimiento,$analizar_comentar,$proceder,$difundir,$firmar,$verificar,$informar,$responder,$tomar_nota,$para_consideracion);			
			}
			
			$Rtf->addText('<BR><BR><BR><BR><BR><BR>');			
			$Rtf->addText('<TAB><TAB><TAB>Atentamente, <BR><BR><BR><BR><BR>');
			$desc_empleado = ucwords(strtolower($desc_empleado));
			$Rtf->addText('<TAB><TAB><TAB>'.ucwords(strtolower($nivel_acad)).$desc_empleado.'<BR><TAB><TAB><TAB><strong>'.$cargo_rem.'</strong><BR><BR><BR><BR>');		
			$Rtf->cambiar_fuente(3,14,$iniciales.'/');
			$Rtf->addText("\n");		
			$Rtf->crono(); //insertar c.c.	
			$Rtf->addText("\n");
			$Rtf->paginacion(); //inserta número de página
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imágen en el encabezado
			$Rtf->getDocument("$numero.rtf");
		}			
	}
		
	else //externas
	{
		$lugar = ucwords(strtolower($lugar));
		$desc_empleado = ucwords(strtolower($desc_empleado));		
		$Rtf->setPaperSize(1);
		$Rtf->margenes(2300,'izq');	
		$Rtf->margenes(1000,'der');
		$Rtf->addText('<BR><BR><BR><BR><BR>');
		$Rtf->addTextAlign($lugar.", $fecha_externa","derecha");
		$Rtf->addText("\n");
		$Rtf->addText($numero);
		$Rtf->addText('<BR><BR><BR><BR><BR>');		
		$Rtf->addTextAlign("Señor","justificado");
		$Rtf->addText("\n\n");
		$Rtf->addText("$destinatarios");
		$Rtf->addText("<strong></strong>");
		$Rtf->addText("\n");
		$Rtf->addText("Direcc. \n");
		$Rtf->addText("Telf.: \n");
		$Rtf->addText("Fax: \n");
		$Rtf->addText("<u>Ciudad.-</u>");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addTextAlign('',"derecha");
		$Rtf->addText("<TAB><TAB><TAB><TAB><u><strong>Ref.- $referencia</strong></u>");
		$Rtf->addTextAlign('',"justificado");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addTextAlign("De nuestra mayor consideración:","justificado");
		$Rtf->addText('<BR><BR><BR>');
		$Rtf->addText('<TAB><TAB><TAB><TAB>Es grato dirigirnos a su persona, ... <BR><BR><BR>');
		$Rtf->addText('<TAB><TAB><TAB><TAB>Con este particular, ... <BR><BR><BR>');
		$Rtf->addText('<TAB><TAB><TAB><TAB>Atentamente, <BR><BR><BR><BR><BR>');
		$Rtf->addText('<TAB><TAB><TAB><TAB>'.ucwords(strtolower($nivel_acad)).$desc_empleado);		
		$Rtf->addText('<BR><TAB><TAB><strong>'.   $cargo_rem.'</strong><BR>');
		$Rtf->addText('<BR><BR><BR><BR>');
		$Rtf->cambiar_fuente(3,14,$iniciales.'/');
		$Rtf->addText("\n");
		$Rtf->crono(); //insertar c.c.		
		$Rtf->getDocument("$numero.rtf");
		
	}	
}
?>