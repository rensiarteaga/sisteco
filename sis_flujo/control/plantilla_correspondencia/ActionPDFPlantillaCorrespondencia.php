<?php
session_start();
//Se valida la autentificaciï¿½n	
	
include_once('../LibModeloFlujo.php');
include("../../../lib/rtf_new/class_rtf_v2.php");

$Custom = new cls_CustomDBFlujo();
$CustomG = new cls_CustomDBFlujo();
$nombre_archivo = 'ActionPDFPlantillaCorrespondencia.php';	
		
//$fecha_actual = date("d-m-Y H:i:s");
function acentos_enies($cadena) {
	$minusculas = array ("á"=>"á","é"=>"é","í"=>"í","ó"=>"ó", "ú"=>"ú","ñ"=>"ñ");
	$mayusculas = array ("Á"=>"Á","É"=>"É","Í"=>"Í","Ó"=>"Ó", "Ú"=>"Ú","Ñ"=>"Ñ");

	$cad = strtr($cadena,$minusculas);
	$cad = strtr($cadena,$mayusculas);
	return $cad;
}

if (! isset($_SESSION['autentificado'])) {
	echo "El usuario no se encuentra autentificado";
}
if ($_SESSION['autentificado'] == 'SI') {
	//Parï¿½metros del filtro
	if ($limit == '')
		$cant = 15;
	else
		$cant = $limit;

	if ($start == '')
		$puntero = 0;
	else
		$puntero = $start;

	if ($sort == '')
		$sortcol = '0=0';
	else
		$sortcol = $sort;

	if ($dir == '')
		$sortdir = 'asc';
	else
		$sortdir = $dir;
	
	//Se valida el mï¿½todo de paso de variables del formulario
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$id_correspondencia = $_POST['id_correspondencia'];		
	} else {
		$id_correspondencia = $_GET['id_correspondencia'];
	}	
	
	$res = $Custom-> PlantillasRTF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);	
	
	$numero = $Custom->salida[0]['numero'];
	$tipo_documento = $Custom->salida[0]['documento'];
	$nivel_academico = $Custom->salida[0]['nivel_academico'];
	$cargo_rem = acentos_enies($Custom->salida[0]['cargo_rem']); //cargo del remitente
	$remitente = acentos_enies($Custom->salida[0]['remitente']); //nombre del remitente
			
	/*$v_remitente = explode(' ',$remitente);
		
	if(sizeof($v_remitente) == 4)
	{
		$remitente = $v_remitente[2].' '.$v_remitente[3].' '.$v_remitente[0].' '.$v_remitente[1];
	}
	elseif(sizeof($v_remitente) == 3)
	{
		$remitente = $v_remitente[2].' '.$v_remitente[0].' '.$v_remitente[1];
	}	
	elseif(sizeof($v_remitente) == 5) 
	{
		$remitente = $v_remitente[3].' '.$v_remitente[4].' '.$v_remitente[0].' '.$v_remitente[1].' '.$v_remitente[2];
	}
	else 
	{
		$remitente = $v_remitente[4].' '.$v_remitente[5].' '.$v_remitente[0].' '.$v_remitente[1].' '.$v_remitente[2].' '.$v_remitente[3];
	}*/
	$desc_empleado = $remitente;
	
	$tipo = $Custom->salida[0]['tipo'];
	$fecha_interna = $Custom->salida[0]['fecha_origen'];
	$institucion = $Custom->salida[0]['institucion'];
	$persona = $Custom->salida[0]['persona'];
	
	$referencia = $Custom->salida[0]['referencia'];			
 	$referencia = acentos_enies($referencia);
	$referencia = mb_strtoupper($referencia);
	$referencia=trim($referencia," \t\n\r\0\x0B");
	
	$lugar = strtoupper($_SESSION["ss_nombre_lugar"]);	//lugar	    
	
	if($nivel_academico != '')
		$nivel_acad = strtoupper(acentos_enies($nivel_academico)).' ';
	else 
		$nivel_acad = 'SR. ';
	//variables que devuelva la consulta
		
	if (eregi('GGN', $numero)) {
		$gerencia = 'GGN';
		$responsable = 'GERENTE GENERAL<BR>RESPONSABLE DEL PROCESO DE<BR>CONTRATACION DIRECTA - RPCD';
	} else {
		$gerencia = 'RPCD';
		$responsable = 'RESPONSABLE DEL PROCESO DE<BR>CONTRATACIï¿½N DIRECTA - RPCD';
	}
		
	setlocale(LC_TIME, 'sp_ES','sp', 'es');
	/**********************cambio 06nov2014 -- mes en ingles para las cartas********************/
	$anio_ext=substr($fecha_interna, 0, 4);
	$mes_ext=substr($fecha_interna, 5, 2);
	$dia_ext=substr($fecha_interna, 8, 2);
	
	if ($mes_ext=="01") $mes_ext="Enero";
	elseif ($mes_ext=="02") $mes_ext="Febrero";
	elseif ($mes_ext=="03") $mes_ext="Marzo";
	elseif ($mes_ext=="04") $mes_ext="Abril";
	elseif ($mes_ext=="05") $mes_ext="Mayo";
	elseif ($mes_ext=="06") $mes_ext="Junio";
	elseif ($mes_ext=="07") $mes_ext="Julio";
	elseif ($mes_ext=="08") $mes_ext="Agosto";
	elseif ($mes_ext=="09") $mes_ext="Septiembre";
	elseif ($mes_ext=="10") $mes_ext="Octubre";
	elseif ($mes_ext=="11") $mes_ext="Noviembre";
	elseif ($mes_ext=="12") $mes_ext="Diciembre";
	else $mes_ext="--";
	
	
	$fecha_externa=$dia_ext.' de '.$mes_ext.' de '.$anio_ext;
	//$fecha_externa = strftime('%d de %B de %Y', strtotime($fecha_interna));
	/************************* fin cambio 06nov2014 -- mes en ingles para las cartas************************/
					
	$fecha_interna = date("d-m-Y", strtotime($fecha_interna)); //formatear la fecha "dd-mm-yyyy"
	
	$fecha_remision = explode('-',$fecha_interna);
	
	$dia = $fecha_remision[0];
	$mes = strtoupper($fecha_remision[1]);
	$anio = $fecha_remision[2];
	
	//Verifica si se harï¿½ o no la decodificaciï¿½n(sï¿½lo pregunta en caso del GET)
	//valores permitidos de $cod -> 'si', 'no'
	
	switch ($cod) {
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
	if ($CantFiltros == '')
		$CantFiltros = 0;

	//Se obtiene el criterio del filtro con formato sql para mandar a la BD
	$cond = new cls_criterio_filtro($decodificar);
	for($i = 0; $i < $CantFiltros; $i ++) {
		$cond->add_condicion_filtro($_POST["filterCol_$i"], $_POST["filterValue_$i"], $_POST["filterAvanzado_$i"]);
	}
		
	$criterio_filtro = $cond -> obtener_criterio_filtro();
			
	//Obtiene el criterio de orden de columnas
	$crit_sort = new cls_criterio_sort($sortcol,$sortdir,'id_empleado');
	$sortcol = $crit_sort->get_criterio_sort();		
	
	if ($tipo == 'interna')
		$var = 1; // interna
	elseif ($tipo == 'emitida')
		$var = 2; // externa
	//if($_SESSION["ss_id_usuario"]==120){echo $Custom->salida[0]['documento'].'---'.$var; exit;}
	if ($tipo_documento == 'COMUNICACION INTERNA') {
		$res = $Custom-> AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia);
			
		if ($Custom->salida[0] == 'f') {
			echo "<script languaje='javascript' type='text/javascript'>alert('El documento de tipo COMUNICACION INTERNA necesita acciones y destinatarios.'); window.close();</script>";
			exit();
		} else {
			$tamanio = sizeof($Custom->salida);
			
			$accion1 = explode('; ',$Custom->salida[0]['nombre']);
			$tamanio_acc = sizeof($accion1);
							
			for($i = 0; $i < $tamanio_acc; $i ++) {
				$acciones = $acciones.''.$accion1[$i].'<BR>';
								
				switch ($accion1[$i]) {
					case 'Aprobar' :
						$aprobar = 'X';
						break;
					case 'Archivar' :
						$archivar = 'X';
						break;
					case 'Para Conocimiento' :
						$para_conocimiento = 'X';
						break;
					case 'Analizar y comentar' :
						$analizar_comentar = 'X';
						break;
					case 'Proceder' :
						$proceder = 'X';
						break;
					case 'Difundir' :
						$difundir = 'X';
						break;
					case 'Firmar' :
						$firmar = 'X';
						break;
					case 'Verificar' :
						$verificar = 'X';
						break;
					case 'Informar' :
						$informar = 'X';
						break;
					case 'Responder' :
						$responder = 'X';
						break;
					case 'Tomar nota' :
						$tomar_nota = 'X';
						break;
					case 'Para su consideración' :
						$para_consideracion = 'X';
						break;
				}		
			}
		}
	}
		
	//Obtiene el conjunto de datos de la consulta para los destinataarios
	$res = $Custom-> Destinatarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var);
	
	$empleado_remision = mb_strtoupper($Custom->salida[0]['nivel_academico']).' '.mb_strtoupper($Custom->salida[0]['nombre'].' '.$Custom->salida[0]['apellido_paterno'].' '.$Custom->salida[0]['apellido_materno']);	
	$cargo_remision = mb_strtoupper($Custom->salida[0]['nombre_cargo']);		
	$tamanio = sizeof($Custom->salida);		
	$nombre_dest_viaje='';
	for($i = 0; $i < $tamanio; $i ++) {
		if($var == 1)	//interna?
		{			
			if($Custom->salida[$i]['nivel_academico'] != '')
				$nivel_acad1 = strtoupper(acentos_enies($Custom->salida[$i]['nivel_academico'])).' ';
			else 
				$nivel_acad1 = 'SR. ';
			
			//chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			$destinatarios = $destinatarios.'<strong>'.$nivel_acad1.$Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno'].' - '.acentos_enies($Custom->salida[$i]['nombre_cargo']).'</strong>'.chr(13).chr(10).'<TAB><TAB><TAB><TAB>';
			$nombre_dest_viaje=$nivel_acad1.$Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno'];
		} else 		// externa
		{
			$persona_externa = ucwords(strtolower($Custom->salida[$i]['nombre'].' '.$Custom->salida[$i]['apellido_paterno'].' '.$Custom->salida[$i]['apellido_materno']));
			$institucion = $Custom->salida[$i]['institucion'];
			$destinatarios = $destinatarios.''.$persona_externa.'<BR><strong>'.$Custom->salida[$i]['institucion'].'</strong>';
		}
	}	
	
	if($var == 1) //interna?
	{
		$destinatarios = mb_strtoupper($destinatarios);
		$destinatarios = acentos_enies($destinatarios);
	}
			
	$inicial = explode(' ', $_SESSION["ss_nombre_usuario"]);	
	
	if (sizeof($inicial) == 4) {
		$iniciales = substr($inicial[2], 0, 1).substr($inicial[3], 0, 1).substr($inicial[0], 0, 1).substr($inicial[1], 0, 1);
	} elseif (sizeof($v_remitente) == 3) {
		$iniciales = substr($inicial[2], 0, 1).substr($inicial[0], 0, 1).substr($inicial[1], 0, 1);
	} else {
		$iniciales = substr($inicial[3], 0, 1).substr($inicial[4], 0, 1).substr($inicial[0], 0, 1).substr($inicial[1], 0, 1).substr($inicial[2], 0, 1);
	}
					 	
	$iniciales = strtolower($iniciales); //iniciales	
		       		
	if ($tipo_documento == 'RESOLUCION DE VIAJES EN FERIADOS O FINES DE SEMANA') {
		$sw = 1;		
		$resG = $CustomG -> EmpleadoGteGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado); //obtener persona con cargo de Gerente Gral.				
		$nivel_viaje = $CustomG -> salida[0]['nivel_academico']; 
		$nombre_viaje = ucwords(strtolower($CustomG -> salida[0]['nombre_completo']));
		$cargo_viaje = $CustomG -> salida[0]['nombre_cargo'];
	}				       	
						      	
	$im = imagecreatetruecolor(50, 20);	
	$azul = 0x00001B39;
	$plomo = imagecolorallocate($im, 110, 110, 112);
	$negro = imagecolorallocate($im, 0, 0, 0);
	$blanco = imagecolorallocate($im, 255, 255, 255);
					
	Header("Content-type: image/jpeg"); 
		
	if ($var == 1) {
		$nombre_fichero = "img/LOGO1 copia.jpg";
		$handle = fopen("img/LOGO1 copia.jpg",'r');	
		
		$contenido = fread($handle, filesize($nombre_fichero));
		fwrite($handle, $contenido);
		$titulo_tmp = imagecreatefromstring($contenido);
		imagejpeg($titulo_tmp,"/tmp/titulo_$id_correspondencia.jpg");
		fclose($handle);
		
		$logotipo = imagecreatefromjpeg("/tmp/titulo_$id_correspondencia.jpg");
						
		$tam_cadena_titulo = strlen($tipo_documento);		
		
		if ($tam_cadena_titulo >= 25) {
			$tipo_documento_1 = explode(' ',$tipo_documento);
			$lenght = sizeof($tipo_documento_1);
			$dim = 0;
			
			for($j = 0; $j <= $lenght; $j ++) {
				if ($dim <= 21) {
					$cadena = $cadena.$tipo_documento_1[$j].' ';
					$dim = strlen($cadena);
				} else
					$cadena1 = $cadena1.$tipo_documento_1[$j].' ';
			}
					
			$tipo_documento = $cadena.chr(13).chr(10).$cadena1;
			
			$fuente = 'fonts_ttf/ariblk.ttf';
			imagettftext($logotipo, 16, 0, 108, 100, $negro, $fuente, $tipo_documento);
		} else {
			$fuente = 'fonts_ttf/ariblk.ttf';
			imagettftext($logotipo, 22, 0, 108, 130, $negro, $fuente, $tipo_documento);			
		}
						
		$fuente = 'fonts_ttf/ARIALNBI.TTF';
		imagettftext($logotipo, 10, 0, 21, 16, $blanco, $fuente, 'ENDESIS');
		imagejpeg($logotipo,"/tmp/titulo_$id_correspondencia.jpg");
		
		$fuente = 'fonts_ttf/tahomabd.ttf';
		imagettftext($logotipo, 10, 0, 170, 175, $negro, $fuente, $lugar);
		imagejpeg($logotipo,"/tmp/titulo_$id_correspondencia.jpg");
			
		imagettftext($logotipo, 10, 0, 406, 175, $negro, $fuente, $fecha_interna);
		imagejpeg($logotipo,"/tmp/titulo_$id_correspondencia.jpg");
		
		imagettftext($logotipo, 10, 0, 520, 175, $negro, $fuente, $numero);
		imagejpeg($logotipo,"/tmp/titulo_$id_correspondencia.jpg");
	}

	$desc_empleado = acentos_enies($desc_empleado);
	$desc_empleado = ucwords(strtoupper($desc_empleado));
	
	$Rtf = new Rtf();
				
	if($var == 1) //internas
	{
		if ($tipo_documento == 'RESOLUCION') {
			$Rtf->margenes(2000,'izq');
			$Rtf->margenes(1500,'der');
			$Rtf->setPaperSize(1);
			$Rtf->rtfImagentxt('img/logo_res copia.jpg','jpg',$numero, $gerencia);					
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
		}

		elseif ($tipo_documento == 'REMISION DE DOCUMENTOS') {
			$Rtf->setPaperSize(1);
			$Rtf->tablaRemision($numero, $tipo_documento,$dia, $mes, $anio, $nivel_acad, $desc_empleado, $empleado_remision, 'img/Logo peq copia.png', $cargo_rem, $cargo_remision);			
		}	
		
		elseif ($tipo_documento == 'ALCANCE DE TRABAJO') {
			$Rtf->setPaperSize(1);
			$Rtf->addTextAlign("","centro");
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
			$Rtf->addText("\n\n\n\n\n");
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imï¿½gen en el encabezado
			$Rtf->cambiar_fuente(3,14,$iniciales.'/');
			$Rtf->addText("\n");
			$Rtf->crono(); //insertar c.c.		
		}	

		elseif ($tipo_documento == 'ACTA DE REUNION') {
			$Rtf->setPaperSize(1); //tamaï¿½o carta			
			$Rtf->margenes(2050,'izq');
			$Rtf->ActaReunion();	
			$Rtf->addTextAlign("","justificado");
			$Rtf->cambiar_fuente(3,14,$iniciales.'/');
			$Rtf->addText("\n");		
			$Rtf->crono(); //insertar c.c.	
			$Rtf->addText("\n");
			$Rtf->paginacion(); //inserta nï¿½mero de pï¿½gina
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imï¿½gen en el encabezado
		}	
			
	// 		ESTA FUNCIONALIDAD ESTA TERMINADA PERO DEBE SER APROBADA PARA PODER UTILIZARLA
 		elseif ($tipo_documento == "INFORME DE VIAJE") {
 			Header("Content-type: text/html");
 			//header("Content-Type: text/enriched\n"); //rtf
 			ini_set('display_errors', 1);
 			include_once ("InformeViajeRTF.php");
 			$filename = "correspondencia_".$id_correspondencia.".rtf";
 			$rtf = new InformeViajeRTF();
 			$rtf->setFilename("/tmp/".$filename);
 			$rtf->setDestinatario(getDestinatariosString($Custom, $tipo));
 			$rtf->setDestViaje($nombre_dest_viaje);
 			$rtf->setRemitente($nivel_acad . utf8_encode($desc_empleado));
 			$rtf->setCargo($cargo_rem);
 			$rtf->setAsunto('<u>'.$referencia.'</u>');
 			//$Rtf->addText("<strong><u>$referencia<BR></strong></u>");
 			$rtf->setImgHeader("/tmp/titulo_$id_correspondencia.jpg");
 			$rtf->writeRTF();
 			header("Content-Type: text/enriched\n"); //rtf
 			header("Content-Disposition: attachment; filename=".$numero.".rtf");
 			readfile("/tmp/".$filename);
 			exit();
			
 		} 
		
		elseif ($sw == 1) 		// RESOLUCION DE VIAJES EN FINES DE SEMANA O FERIADOS
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
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imï¿½gen en el encabezado
		}
			
		else {
			
			
			
			$Rtf->setPaperSize(1); //tamaï¿½o carta			
			$Rtf->margenes(2390,'izq');
			$Rtf->margenes(1265,'der');			
			//$Rtf->addText_fuente_tam(3,18,'<strong><BR>A:</strong><TAB><TAB><TAB>'.$destinatarios.'<BR>'); //para cambiar tamaï¿½o de la fuente en relacion a la que tiene el documento
			$Rtf->addText('<strong><BR>A:</strong><TAB><TAB><TAB><TAB>'.$destinatarios.'<BR>');
			$Rtf->addText('<strong>DE:<TAB><TAB><TAB><TAB>'.$nivel_acad.$desc_empleado.' - '.$cargo_rem.'</strong><BR>');			
			$Rtf->addTextAlign("","justificado");
			$Rtf->addText('<strong><BR>ASUNTO:<TAB><TAB><u>'.$referencia.'</u></strong><BR><BR>');
			
			if ($tipo_documento == 'COMUNICACION INTERNA') {
				$Rtf->tablaCI($aprobar,$archivar,$para_conocimiento,$analizar_comentar,$proceder,$difundir,$firmar,$verificar,$informar,$responder,$tomar_nota,$para_consideracion);		
			} elseif ($tipo_documento == 'ESPECIFICACIONES TECNICAS') {
				$Rtf->tablaEspecificaciones();
			}
			
			elseif ($tipo_documento == 'EVALUACION TECNICA') {
				$Rtf->tablaEvaluacion();
				$Rtf->addText('<strong><BR>Conclusión: </strong> ');
			}
			
			elseif ($tipo_documento == 'REVISION TECNICA') {
				$Rtf->tablaRevision();
			}		
							
			$Rtf->addText('<BR><BR><BR>');			
			$Rtf->addText('<TAB><TAB><TAB><TAB>Atentamente, <BR><BR><BR><BR>');
			$desc_empleado = ucwords(strtolower($desc_empleado));
			$Rtf->addText('<TAB><TAB><TAB><TAB>'.ucwords(strtolower($nivel_acad)).$desc_empleado.'<BR><TAB><TAB><TAB><TAB><strong>'.$cargo_rem.'</strong><BR><BR>');		
			$Rtf->cambiar_fuente(3,16,$iniciales.'/');
			$Rtf->addText("\n");		
			$Rtf->crono(); //insertar c.c.	
			$Rtf->addText("\n");
			$Rtf->paginacion(); //inserta nï¿½mero de pï¿½gina
			$Rtf->rtfImage("/tmp/titulo_$id_correspondencia.jpg",'jpg'); //inserta una imï¿½gen en el encabezado
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
		$Rtf->addText('<BR><TAB><TAB><TAB><TAB><strong>'.   $cargo_rem.'</strong><BR>');
		$Rtf->addText('<BR><BR><BR><BR>');
		$Rtf->cambiar_fuente(3,14,$iniciales.'/');
		$Rtf->addText("\n");
		$Rtf->crono(); //insertar c.c.			
	}

	$Rtf->getDocument("$numero.rtf");
}

function getDestinatariosString($Custom, $tipo) {
	for($i = 0; $i < sizeof($Custom->salida); $i ++) {
		if ($tipo == "interna") 		// interna?
		{
			if ($Custom->salida[$i]['nivel_academico'] != '')
				$nivel_acad1 = strtoupper(acentos_enies($Custom->salida[$i]['nivel_academico'])) . ' ';
			else
				$nivel_acad1 = 'SR. ';
				
			$espacio='';
				
			if($i>0){
				$espacio='    ';
			}
				
				// chr(13).chr(10) = SALTO DE LINEA (ENTER) EN WORD
			if($i<sizeof($Custom->salida)-1){
				
				
				
				$destinatarios = $destinatarios .$espacio. '   <strong>' . $nivel_acad1 . $Custom->salida[$i]['nombre'] . ' ' . $Custom->salida[$i]['apellido_paterno'] . ' ' . $Custom->salida[$i]['apellido_materno'] . ' - ' . acentos_enies($Custom->salida[$i]['nombre_cargo']) . '</strong> <BR>';
			}	else{
				$destinatarios = $destinatarios .$espacio. '   <strong>' . $nivel_acad1 . $Custom->salida[$i]['nombre'] . ' ' . $Custom->salida[$i]['apellido_paterno'] . ' ' . $Custom->salida[$i]['apellido_materno'] . ' - ' . acentos_enies($Custom->salida[$i]['nombre_cargo']) . '</strong> ';
			}
		} else 		// externa
		{
			$persona_externa = ucwords(strtolower($Custom->salida[$i]['nombre'] . ' ' . $Custom->salida[$i]['apellido_paterno'] . ' ' . $Custom->salida[$i]['apellido_materno']));
			$institucion = $Custom->salida[$i]['institucion'];
			$destinatarios = $destinatarios . '' . $persona_externa . '<BR><strong>' . $Custom->salida[$i]['institucion'] . '</strong>';
		}
	}
	
	if ($tipo == "externa") 	// interna?
	{
		$destinatarios = mb_strtoupper($destinatarios);
		$destinatarios = acentos_enies($destinatarios);
	}
	return $destinatarios;
}
?>