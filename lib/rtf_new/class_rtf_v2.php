<?php 
// RTF Generator Class
//
// Example of use:
// 	$rtf = new rtf("rtf_config.php");
// 	$rtf->setPaperSize(5);
// 	$rtf->setPaperOrientation(1);
// 	$rtf->setDefaultFontFace(0);
// 	$rtf->setDefaultFontSize(24);
// 	$rtf->setAuthor("noginn");
// 	$rtf->setOperator("me@noginn.com");
// 	$rtf->setTitle("RTF Document");
// 	$rtf->addColour("#000000");
// 	$rtf->addText($_POST['text']);
// 	$rtf->getDocument();
//

require_once("source_rtf.php");

class Rtf {

	// {\colortbl;\red 0\green 0\blue 0;\red 255\green 0\ blue0;\red0 ...}
	var $colour_table = array();
	var $colour_rgb;
	// {\fonttbl{\f0}{\f1}{f...}}
	var $font_table = array();
	var $font_face;
	var $font_size;
	// {\info {\title <title>}{\author <author>}{\operator <operator>}}
	var $info_table = array();
	var $page_width;
	var $page_height;
	var $page_size;
	var $page_orientation;
	var $rtf_version;
	var $tab_width;
	
	var $document;
	var $buffer;
	var $retval;
	var $pagina;
	var $crono;
	var $cabecera;
	var $tabla;
	var $txt_alineado;
	var $margen;
	var $tam_font;
	var $parrafo;
	
	var $cuerpo;
	
	function rtf($config="rtf_config.php") {
		require_once($config);
		
		$this->setDefaultFontFace($font_face);
		$this->setDefaultFontSize($font_size);
		$this->setPaperSize($paper_size);
		$this->setPaperOrientation($paper_orientation);
		$this->rtf_version = $rtf_version;
		$this->tab_width = $tab_width;
	}
	
	function setDefaultFontFace($face) {
		$this->font_face = $face; // $font is interger
	}
	
	function setDefaultFontSize($size) {
		$this->font_size = $size;
	}
	
	function setTitle($title="") {
		$this->info_table["title"] = $title;
	}
	
	function setAuthor($author="") {
		$this->info_table["author"] = $author;
	}
	
	function setOperator($operator="") {
		$this->info_table["operator"] = $operator;
	}
	
	function setPaperSize($size=0) {
		global $inch, $cm, $mm;
		
		// 1 => Letter (8.5 x 11 inch)
		// 2 => Legal (8.5 x 14 inch)
		// 3 => Executive (7.25 x 10.5 inch)
		// 4 => A3 (297 x 420 mm)
		// 5 => A4 (210 x 297 mm)
		// 6 => A5 (148 x 210 mm)
		// Orientation considered as Portrait
		
		switch($size) {
			case 1:
				$this->page_width = floor(8.5*$inch);
				$this->page_height = floor(11*$inch);
				$this->page_size = 1;
				break;	
			case 2:
				$this->page_width = floor(8.5*$inch);
				$this->page_height = floor(14*$inch);
				$this->page_size = 5;
				break;	
			case 3:
				$this->page_width = floor(7.25*$inch);
				$this->page_height = floor(10.5*$inch);
				$this->page_size = 7;
				break;	
			case 4:
				$this->page_width = floor(297*$mm);
				$this->page_height = floor(420*$mm);
				$this->page_size = 8;
				break;	
			case 5:
			default:
				$this->page_width = floor(210*$mm);
				$this->page_height = floor(297*$mm);
				$this->page_size = 9;
				break;	
			case 6:
				$this->page_width = floor(148*$mm);
				$this->page_height = floor(210*$mm);
				$this->page_size = 10;
				break;	
		}
	}
	
	function setPaperOrientation($orientation=0) {
		// 1 => Portrait
		// 2 => Landscape
		
		switch($orientation) {
			case 1:
			default:
				$this->page_orientation = 1;
				break;
			case 2:
				$this->page_orientation = 2;
				break;	
		}
	}
	
	function addColour($hexcode) {
		// Get the RGB values
		$this->hex2rgb($hexcode);
		
		// Register in the colour table array
		$this->colour_table[] = array(
			"red"	=>	$this->colour_rgb["red"],
			"green"	=>	$this->colour_rgb["green"],
			"blue"	=>	$this->colour_rgb["blue"]
		);
	}
	
	// Convert HEX to RGB (#FFFFFF => r255 g255 b255)
	function hex2rgb($hexcode) {
		$hexcode = str_replace("#", "", $hexcode); 
		$rgb = array();
		$rgb["red"] = hexdec(substr($hexcode, 0, 2));
		$rgb["green"] = hexdec(substr($hexcode, 2, 2));
		$rgb["blue"] = hexdec(substr($hexcode, 4, 2));
		
		$this->colour_rgb = $rgb;
	}
	
	// Convert newlines into \par
	function nl2par($text) {
		$text = str_replace("\n", "\\par ", $text);
		
		return $text;
	}
	
	// Add a text string to the document buffer
	function addText($text) 
	{
		//$text = str_replace("\n", "", $text);
		$text = str_replace("\t", "", $text);
		$text = str_replace("\r", "", $text);
				
		$this->document = $text;
				
		// Parse the text into RTF
		$this->cuerpo .= $this->parseDocument();
	}	
	
	function addText_fuente_tam($fuente,$tamanio,$text)
	{				
		$this->parrafo = "{\\rtlch\\fcs1 \\af38\\afs18 \\ltrch\\fcs0 \\b\\f$fuente\\fs$tamanio\\insrsid6379102\\charrsid6379102 $text}";
		
		$this->cuerpo .= $this->parrafo;
	}	
	
	function addTextAlign($text,$align) //MFLORES /13/05/2011
	{
		if($align == 'derecha')
		{
			$this->txt_alineado = "\\qr $text";
		}

		if($align == 'izquierda')
		{
			$this->txt_alineado = "\\ql $text";
		}
		
		if($align == 'centro')
		{
			$this->txt_alineado = "\\qc $text";
		}
		
		if($align == 'justificado')
		{
			$this->txt_alineado = "\\qj $text";
		}
										
		// Parse the text into RTF
		$this->cuerpo .= $this->txt_alineado;
	}	
	
	function InsertarImagen($imagen,$tipo) //inserta imagen
	{		
		if (!$fp = fopen($imagen,"rb")) 
		{
	        echo "No se puede abir la imágen: ($imagen)";
	        return false;
		}
		
		$tamanio_img = GetImageSize($imagen);
		$ancho = $tamanio_img[0] * 15;
		$alto = $tamanio_img[1] * 15;
		$fp = fopen($imagen,"rb");
		$out = "";
		while (!feof($fp))
		{
			$buffer = fread($fp, 64);		
			$out .= bin2hex($buffer) . "\n";
		}
		fclose($fp);
		$tag = 112233; 
		if (($tipo == "png") || ($tipo == "jpg") || ($tipo == "bmp")) 
		{
			if (($tipo == "png")) {
				$this->retval = "{\\*\\shppict\n{\\pict\\pngblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			if (($tipo == "jpg") || ($tipo == "jpeg")) {
				$this->retval = "{\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			
			if (($tipo == "bmp") ) {
								
				$this->retval = "{\\*\\shppict\n{\\pict\\dibitmap0\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$alto."\\pichgoal".$alto;				
			}
		}
		else 
		{
			return FALSE;
		}
		$this->retval .= "\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n";
		$this->retval .= $out;
		$this->retval .= "}}\n";

		//agregar la imagen al cuerpo del documento
		$this->cuerpo .= $this->retval;
		return TRUE;
	}
	
	//esta función sirve para agregar una imagen al documento RTF partir de una imagen del disco duro especificamente para las plantillas internas - MFLORES
	function rtfImage($imagen,$tipo)
	{
		
		if (!$fp = fopen($imagen,"rb")) 
		{
	        echo "No se puede abir la imágen: ($imagen)";
	        return false;
		}
		
		$tamanio_img = GetImageSize($imagen);
		$ancho = $tamanio_img[0] * 0;
		$alto = $tamanio_img[1] * 0;
		$fp = fopen($imagen,"rb");
		$out = "";
		while (!feof($fp))
		{
			$buffer = fread($fp, 64);		
			$out .= bin2hex($buffer) . "\n";
		}
		fclose($fp);
		$tag = 112233; 
		if (($tipo == "png") || ($tipo == "jpg") || ($tipo == "bmp")) 
		{
			if (($tipo == "png")) 
			{
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\pngblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			
			if (($tipo == "jpg") || ($tipo == "jpeg")) 
			{
			//$this->retval = "{\\header{\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
				
			$this->retval = "\\headery100 {\\headerr \\ltrpar \\pard\\plain \\ltrpar\\s17\\ql \\fi-1850\\li0\\ri0\\widctlpar \\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0\\pararsid8616665 \\rtlch\\fcs1 \\af0\\afs22\\alang1025 \\ltrch\\fcs0 \\f3\\fs2 \\lang16394\\langfe1033\\cgrid\\langnp16394\\langfenp1033 {\\rtlch\\fcs1 \\af0 \\ltrch\\fcs0 \\insrsid16461087 {\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			
			}
								
			if (($tipo == "bmp") ) 
			{
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\dibitmap0\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$alto."\\pichgoal".$alto;				
			}
		}
		else 
		{
			return FALSE;
		}
		$this->retval .= "\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n";
		$this->retval .= $out;
		//$this->retval .= "}{\\rtlch\\fcs1 \\af0 \\ltrch\\fcs0 \\insrsid13196994 \\par}}}\n}";

		$this->retval .= "}{\\rtlch\\fcs1 \\af0 \\ltrch\\fcs0 \\insrsid8326554 \\par}}}\n}";
		
		//agregar la imagen al cuerpo del documento
		$this->cuerpo .= $this->retval;
		return TRUE;
	}
	
	function rtfImagentxt($imagen,$tipo,$numero,$gerencia)
	{
		
		if (!$fp = fopen($imagen,"rb")) 
		{
	        echo "No se puede abir la imágen: ($imagen)";
	        return false;
		}
		
		$tamanio_img = GetImageSize($imagen);
		$ancho = $tamanio_img[0] * 0;
		$alto = $tamanio_img[1] * 0;
		$fp = fopen($imagen,"rb");
		$out = "";
		while (!feof($fp))
		{
			$buffer = fread($fp, 64);		
			$out .= bin2hex($buffer) . "\n";
		}
		fclose($fp);
		$tag = 112233; 
		if (($tipo == "png") || ($tipo == "jpg") || ($tipo == "bmp")) 
		{
			if (($tipo == "png")) 
			{
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\pngblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			
			if (($tipo == "jpg") || ($tipo == "jpeg")) 
			{
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
								
			if (($tipo == "bmp") ) 
			{
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\dibitmap0\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$alto."\\pichgoal".$alto;				
			}
		}
		else 
		{
			return FALSE;
		}
		$this->retval .= "\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n";
		$this->retval .= $out;
		$this->retval .= "}}\n \\qr {\\rtlch\\fcs1\\ab\\af3\\afs16 \\ltrch\\fcs0 \\b\\f3\\fs16\\insrsid3410059 \\hich\\af3\\dbch\\af31505\\loch\\f3 \\hich\\f3 RESOLUCI\\'d3\\loch\\f3 \\hich\\f3 N $gerencia N\\'b0\\loch\\f3  $numero}{\\rtlch\\fcs1 \\af31507\\afs24 \\ltrch\\fcs0 \\f39\\fs24\\insrsid3410059 \\hich\\af39\\dbch\\af31505\\loch\\f39 \\par}{\\ltrpar \\pard\\plain \\ltrpar\\s17\\qr \\li0\\ri0\\widctlpar\\tqc\\tx4252\\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\f3\\fs16 \\lang16394\\langfe1033\\cgrid\\langnp16394\\langfenp1033 {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547}{\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\lang3082\\langfe1033\\langnp3082\\insrsid16078547 \\b -Hoja Nº \\b0}{\\field {\\*\\fldinst {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\insrsid16078547 PAGE}}{\\fldrslt{\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\lang1024\\langfe1024\\noproof\\insrsid16078547 1}}}\\sectd \\ltrsect\\linex0\\endnhere\\sectdefaultcl\\sftnbj {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\lang3082\\langfe1033\\langnp3082\\insrsid16078547 \\b  de \\b0}{\\field {\\*\\fldinst {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\insrsid16078547 NUMPAGES}}{\\fldrslt {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\lang1024\\langfe1024\\noproof\\insrsid16078547 1}}}\\sectd \\ltrsect\\linex0\\endnhere\\sectdefaultcl\\sftnbj {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547 -}{\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547 \\par}\\pard \\ltrpar\\s17\\ql \\li0\\ri0\\widctlpar\\tqc\\tx4252\\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547 \\par}}}";
			
		//agregar la imagen al cuerpo del documento
		$this->cuerpo .= $this->retval;
		return TRUE;
	}

	//agregar una imagen al documento .rtf partir de una imagen contenida dentro de una cadena binaria
	function rtfBinImage($dato_foto){
		$imagen=imagecreatefromstring($dato_foto);
		$ancho = imagesx($imagen);
		$alto = imagesy($imagen);
		$anchoTwip = $ancho * 12;
		$altoTwip = $alto * 12;
		imagedestroy($imagen);

		$longitud64 = ceil(strlen($dato_foto)/64);
		for($i=0;$i<$longitud64;$i++)
		{
			$bufer .= bin2hex(substr($dato_foto,$i*64,64));
			$bufer .= "\n";
		}

		//Encontrar el tipo de archivo (solo soportados) a partir de los números mágicos. ref. http://en.wikipedia.org/wiki/Magic_number_%28programming%29
		//Eliminado el soporte para archivos .GIF porque no todos los procesadores de texto lo soportan
		//if (ereg("474946383961",strtoupper($cademnaTipoArchivo)) || ereg("474946383761",strtoupper($cademnaTipoArchivo))) $typeimg='gif';

		if (ereg("FFD8FF",strtoupper(substr($bufer,0,16)))) $typeimg='jpg';
		else if (ereg(strtoupper("89504e470d0a1a0a"),strtoupper(substr($bufer,0,16)))) $typeimg='png';
		else $typeimg='';
		
		$tag = 112233; // puede ser cualquier número

 		if (($typeimg == "png") || ($typeimg == "jpg") || ($typeimg == "bmp")) {
			if (($typeimg == "png")) {
				$this->retval = "{\\*\\shppict\n{\\pict\\pngblip\\picw" . $ancho . "\\pich" . $alto . "\\picwgoal".$anchoTwip."\\pichgoal".$altoTwip;
			}
			if (($typeimg == "jpg") || ($typeimg == "jpeg")) {
				$this->retval = "{\\*\\shppict\n{\\pict\\jpegblip\\picw" . $ancho . "\\pich" . $alto . "\\picwgoal".$anchoTwip."\\pichgoal".$altoTwip;
			}
			
			if (($typeimg == "bmp") ) {
				$this->retval = "{\\*\\shppict\n{\\pict\\dibitmap0\\picw" . $ancho . "\\pich" . $alto . "\\picwgoal".$anchoTwip."\\pichgoal".$altoTwip;
			}
		}else {
			return FALSE;
		}
		
		$this->retval .= "\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n";
		$this->retval .= $bufer;
		$this->retval .= "}\n}";
		
		//agregar la imagen al cuerpo del documento
		$this->cuerpo .= $this->retval;
		
		return TRUE;
	}

	// Ouput the RTF file to html
	function getDocument($fileName) {
		$this->buffer .= "{";
		// Header
		$this->buffer .= $this->getHeader();
		// Font table
		$this->buffer .= $this->getFontTable();
		// Colour table
		$this->buffer .= $this->getColourTable();
		// File Information
		$this->buffer .= $this->getInformation();
		// Default font values
		$this->buffer .= $this->getDefaultFont();
		// Page display settings
		$this->buffer .= $this->getPageSettings();
		//Imagenes y texto
		$this->buffer .= $this->cuerpo;
		//Fin del archivo
		$this->buffer .= "}";

		header("Content-Type: text/enriched\n"); //rtf
		//header("Content-Type: application/vnd.ms-word");	//word		
		//header("Content-Type: application/msword");	//word		
		header("Content-Disposition: attachment; filename=$fileName");
		echo $this->buffer;
				
		}
	
	function saveToFile($filename) {
		$this->buffer .= "{";
		// Header
		$this->buffer .= $this->getHeader();
		// Font table
		$this->buffer .= $this->getFontTable();
		// Colour table
		$this->buffer .= $this->getColourTable();
		// File Information
		$this->buffer .= $this->getInformation();
		// Default font values
		$this->buffer .= $this->getDefaultFont();
		// Page display settings
		$this->buffer .= $this->getPageSettings();
		//Imagenes y texto
		$this->buffer .= $this->cuerpo;
		//Fin del archivo
		$this->buffer .= "}";
		
		$somecontent = $this->buffer;
	
		   if (!$handle = fopen($filename, 'w')) {
		         echo "Cannot open file ($filename)";
		        return false;
		  }
		
		   // Write $somecontent to our opened file.
		   if (fwrite($handle, $somecontent) === FALSE) {
		       echo "Cannot write to file ($filename)";
		       return false;
		  }		   
		  
		   fclose($handle);
		return TRUE;
	
	}
	
	function crono() //MFLORES /13/05/2011
	{
		$this->crono = "{\\f3\\fs16 cc:, Cron., File}";
		$this->cuerpo .= $this->crono;		
	}
	
	//insertar encabezado - MFLORES /13/05/2011
	function header($texto)
	{
		//$this->cabecera = "{\\header $texto}"; 		
		$this->cabecera = "{\\header \\ltrpar \\pard\\plain \\ltrpar\\s15\\ql \\fi0\\li0\\ri0\\widctlpar \\tqc\\tx4252\\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0\\pararsid10766717 \\rtlch\\fcs1 \\af0\\afs22\\alang1025 \\ltrch\\fcs0 \\f31506\\fs20\\lang16394\\langfe1033\\cgrid\\langnp16394\\langfenp1033 {\\rtlch\\fcs1 \\af0 \\ltrch\\fcs0 \\insrsid8548536 Pruebas}{\\rtlch\\fcs1 \\af0 \\ltrch\\fcs0 \\insrsid8326554 \\par}}";
		
		$this->cuerpo .= $this->cabecera;
	}	
	
	//insertar numero de pagina - MFLORES /13/05/2011
	function paginacion()
	{
		$this->pagina = "{\\footer \\ltrpar \\pard\\plain \\ltrpar\\s17\\qr \\li0\\ri0\\widctlpar\\tqc\\tx4252\\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\f3\\fs14 \\lang16394\\langfe1033\\cgrid\\langnp16394\\langfenp1033 {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547}{\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\lang3082\\langfe1033\\langnp3082\\insrsid16078547 P\\'e1gina }{\\field {\\*\\fldinst {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\insrsid16078547 PAGE }}{\\fldrslt{\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\lang1024\\langfe1024\\noproof\\insrsid16078547 1}}}\\sectd \\ltrsect\\linex0\\endnhere\\sectdefaultcl\\sftnbj {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\lang3082\\langfe1033\\langnp3082\\insrsid16078547  de }{\\field {\\*\\fldinst {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\insrsid16078547 NUMPAGES}}{\\fldrslt {\\rtlch\\fcs1 \\ab\\af31507 \\ltrch\\fcs0 \\b\\lang1024\\langfe1024\\noproof\\insrsid16078547 1}}}\\sectd \\ltrsect\\linex0\\endnhere\\sectdefaultcl\\sftnbj {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547}{\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547 \\par}\\pard \\ltrpar\\s17\\ql \\li0\\ri0\\widctlpar\\tqc\\tx4252\\tqr\\tx8504\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid16078547 \\par}}";

		//$this->pagina = "{\\footer \\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\f3\\fs14     Página \\chpgn}";
		$this->cuerpo .= $this->pagina;		
	}
	
	function margenes($marg,$dir)
	{		
		if($dir == 'izq')
			$this->margen = "\\margl$marg";
		
		if($dir == 'der')
			$this->margen = "\\margr$marg";
		
		if($dir == 'sup')
			$this->margen = "\\margt$marg";
			
		if($dir == 'inf')
			$this->margen = "\\margb$marg";
			
		$this->cuerpo .= $this->margen;
	}
	
	function cambiar_fuente($fuente,$tamanio,$text)
	{
		$this->tam_font = "{\\f$fuente\\fs$tamanio $text}";
		$this->cuerpo .= $this->tam_font;
		
	}	
	
	function tablaRemision($numero, $desc_documento,$dia, $mes, $anio, $nivel_acad, $desc_empleado, $empleado_remision, $imagen, $cargo_rem, $cargo_remision) //MFLORES 12/07/2011
	{		
		//$nivel_acad = $nivel_acad.' ';
		$tamanio_img = GetImageSize($imagen);
		$ancho = $tamanio_img[0] * 15;
		$alto = $tamanio_img[1] * 15;
		$fp = fopen($imagen,"rb");
		$out = "";
		while (!feof($fp))
		{
			$buffer = fread($fp, 64);
			$out .= bin2hex($buffer) . "\n";
		}
		fclose($fp);
		$tag = 112233;
		
		//  Definición de las celdas de datos. 
		$this->tabla.= "\\qc {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs18\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid416217 $numero}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\b\\f3\\fs17\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid3868598  {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\b\\f3\\fs28\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid9517307\\charrsid3868598
$desc_documento}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316 \\cell}\\pard \\ltrpar
\\qc \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0 {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid9517307 {\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto."\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n".$out."}}\n}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow0\\irowband0\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmgf\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmgf\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow1\\irowband1\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil 
\\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid9517307\\charrsid9517307 FECHA}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow1\\irowband1\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow2\\irowband2\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth817\\clshdrawnil \\cellx709\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth992\\clshdrawnil \\cellx1701
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth1134\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid416217  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $dia}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $mes}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $anio}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow2\\irowband2\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth817\\clshdrawnil \\cellx709\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth992\\clshdrawnil \\cellx1701\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth1134\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 
\\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow3\\irowband3\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 
\\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316\\charrsid9200263 Detalle}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid9517307\\charrsid9200263  del env\\'edo:}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 
\\b\\f3\\fs20\\insrsid4214316\\charrsid9200263 
\\par}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\f3\\fs20\\insrsid9517307\\charrsid9200263 
\\par}\\pard\\plain \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 
\\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\f3\\fs20\\insrsid9517307\\charrsid9200263 
\\par}\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f39\\fs20\\insrsid9517307 \\cell}\\pard\\plain \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow3\\irowband3\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow4\\irowband4\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 
\\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 
\\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\cell}\\pard\\plain \\ltrpar
\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 \\trowd \\irow4\\irowband4\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt
\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow5\\irowband5\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 
\\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 
\\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\hich\\af38\\dbch\\af31505\\loch\\f3 Motivo }{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3 \\hich\\f3 del env\\'ed\\loch\\f3 o:}{\\rtlch\\fcs1 \\af39 
\\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\par}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 
\\par}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 
\\par}\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 \\cell}\\pard\\plain \\ltrpar
\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow5\\irowband5\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt
\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow6\\irowband6\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 
\\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2992\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877
\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3 Nombre\\cell \\hich\\af38\\dbch\\af31505\\loch\\f3 Cargo}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell \\hich\\af38\\dbch\\af31505\\loch\\f3 Firma}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3  Remitente}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow6\\irowband6\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2992\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow7\\irowband7\\ltrrow\\ts15\\trgaph70\\trrh542\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmgf\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 D}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 E:}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $nivel_acad$desc_empleado}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $cargo_rem}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow7\\irowband7\\ltrrow\\ts15\\trgaph70\\trrh542\\trleft-108\\trbrdrt
\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmgf\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow8\\irowband8\\lastrow \\ltrrow\\ts15\\trgaph70\\trrh550\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt
\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmrg\\clvertalt\\clbrdrt
\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\hich\\af39\\dbch\\af0\\loch\\f3 A}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 :}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $empleado_remision}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $cargo_remision}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow8\\irowband8\\lastrow \\ltrrow\\ts15\\trgaph70\\trrh550\\trleft-108
\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid12402795}\\f3 \\fs16 \\b \\qc {\\i ENDESIS}                                                                                         Original\\b0 \\par\\par\\par\\par\\par \\ql



\\qc {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs18\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid416217 $numero}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\b\\f3\\fs17\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid3868598  {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\b\\f3\\fs28\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid9517307\\charrsid3868598
$desc_documento}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316 \\cell}\\pard \\ltrpar
\\qc \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0 {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid9517307 {\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto."\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n".$out."}}\n}{\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\f3\\fs20\\lang3082\\langfe3082\\langnp3082\\langfenp3082\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39\\afs20 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow0\\irowband0\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmgf\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmgf\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow1\\irowband1\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil 
\\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid9517307\\charrsid9517307 FECHA}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow1\\irowband1\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2943\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow2\\irowband2\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth817\\clshdrawnil \\cellx709\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth992\\clshdrawnil \\cellx1701
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth1134\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid416217  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $dia}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $mes}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid416217 $anio}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\cell \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0  {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316 \\trowd \\irow2\\irowband2\\ltrrow\\ts15\\trgaph70\\trrh90\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid416217\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth817\\clshdrawnil \\cellx709\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth992\\clshdrawnil \\cellx1701\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth1134\\clshdrawnil \\cellx2835\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 
\\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth3119\\clshdrawnil \\cellx5954\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2835\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow3\\irowband3\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307  {\\rtlch\\fcs1 \\af39 
\\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langfenp1033\\insrsid4214316\\charrsid9200263 Detalle}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid9517307\\charrsid9200263  del env\\'edo:}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 
\\b\\f3\\fs20\\insrsid4214316\\charrsid9200263 
\\par}{\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\f3\\fs20\\insrsid9517307\\charrsid9200263 
\\par}\\pard\\plain \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 
\\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af38 \\ltrch\\fcs0 \\f3\\fs20\\insrsid9517307\\charrsid9200263 
\\par}\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f39\\fs20\\insrsid9517307 \\cell}\\pard\\plain \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow3\\irowband3\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow4\\irowband4\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 
\\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 
\\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\cell}\\pard\\plain \\ltrpar
\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 \\trowd \\irow4\\irowband4\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt
\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw30 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow5\\irowband5\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 
\\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 
\\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\hich\\af38\\dbch\\af31505\\loch\\f3 Motivo }{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3 \\hich\\f3 del env\\'ed\\loch\\f3 o:}{\\rtlch\\fcs1 \\af39 
\\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\par}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 
\\par}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 
\\par}\\pard \\ltrpar\\qj \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307 \\cell}\\pard\\plain \\ltrpar
\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow5\\irowband5\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt
\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow6\\irowband6\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 
\\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2992\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877
\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard\\plain \\ltrpar
\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 \\rtlch\\fcs1 \\af31507\\afs22\\alang1025 \\ltrch\\fcs0 \\fs22\\lang3082\\langfe3082\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp3082\\langfenp3082 {
\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3 Nombre\\cell \\hich\\af38\\dbch\\af31505\\loch\\f3 Cargo}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af38\\dbch\\af31505\\loch\\f3}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell \\hich\\af38\\dbch\\af31505\\loch\\f3 Firma}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3  Receptor}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow6\\irowband6\\ltrrow\\ts15\\trgaph70\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv
\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl
\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2992\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvertalt\\clbrdrt\\brdrs\\brdrw30 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row \\ltrrow
}\\trowd \\irow7\\irowband7\\ltrrow\\ts15\\trgaph70\\trrh542\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmgf\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 D}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 E:}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $nivel_acad$desc_empleado}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $cargo_rem}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow7\\irowband7\\ltrrow\\ts15\\trgaph70\\trrh542\\trleft-108\\trbrdrt
\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmgf\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row \\ltrrow}\\trowd \\irow8\\irowband8\\lastrow \\ltrrow\\ts15\\trgaph70\\trrh550\\trleft-108\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 
\\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 \\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt
\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 
\\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmrg\\clvertalt\\clbrdrt
\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 
\\hich\\af39\\dbch\\af0\\loch\\f3 A}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\b\\fs20\\lang16394\\langfe1033\\loch\\af38\\hich\\af39\\dbch\\af0\\langnp16394\\langfenp1033\\insrsid9517307\\charrsid9517307 \\hich\\af39\\dbch\\af0\\loch\\f3 :}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\b\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316\\charrsid9517307 \\cell}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $empleado_remision}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid9517307 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid10754219 $cargo_remision}{\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1
\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 \\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid4214316 \\trowd \\irow8\\irowband8\\lastrow \\ltrrow\\ts15\\trgaph70\\trrh550\\trleft-108
\\trbrdrt\\brdrs\\brdrw10 \\trbrdrl\\brdrs\\brdrw10 \\trbrdrb\\brdrs\\brdrw10 \\trbrdrr\\brdrs\\brdrw10 \\trbrdrh\\brdrs\\brdrw10 \\trbrdrv\\brdrs\\brdrw10 
\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid9200263\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb
\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth675\\clshdrawnil \\cellx567\\clvertalc\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2317\\clshdrawnil \\cellx2884
\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2993\\clshdrawnil \\cellx5877\\clvmrg\\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr
\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth2912\\clshdrawnil \\cellx8789\\row}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 {\\rtlch\\fcs1 \\af39 \\ltrch\\fcs0 
\\f3\\fs20\\lang16394\\langfe1033\\langnp16394\\langfenp1033\\insrsid12402795}\\f3 \\fs16 \\b \\qc {\\i ENDESIS}                                                                                            Copia\\b0";  //<-- fin de la tabla	
				
		$this->cuerpo .= $this->tabla;
	}
	
	function tablaEspecificaciones()
	{
		$this->tabla .= "{";
		
		//  Definición de las celdas de datos. Se definen 2 columnas y 10 filas
		$this->tabla.= "
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx4500
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx9000	
		";
		
		$this->tabla = str_replace(chr(13),'',$this->tabla);
		$this->tabla = str_replace(chr(9),'',$this->tabla);
		$this->tabla = str_replace(chr(10),'',$this->tabla);
		
		$this->tabla.= "{\\fs20\\b";  //<-- Fuente de tamaño 20 alineada a la derecha
		$this->tabla.= "\\qc ESPECIFICACION \\cell \\qc DETALLE \\cell"; //titulos de la tabla
		$this->tabla.= "}\\row"; //<-- Fin del renglón de encabezado
		
		// Introducción de los datos 
		 $datos= array();
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ");
		                                                                   
		foreach($datos as $v)
		{
			 $this->tabla.= " {$v[0]}\\cell {$v[1]}\\cell \n";
			 $this->tabla.= "\\row "; //<-- Fin del renglón
		}
		
		$this->tabla.= "}";  //<-- fin de la tabla	
				
		$this->cuerpo .= $this->tabla;
	}
	
	function tablaRevision()
	{
		$this->tabla .= "\\f3\\fs20 \\ltrrow\\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trleft0\\trftsWidth1\\tblrsid16262128\\tblind5\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth9500\\clshdrawnil \\cellx9500\\pard\\plain \\ltrpar\\qj \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid16262128 \\rtlch\\fcs1 \\af31507\\afs20\\alang1025 \\ltrch\\fcs0 \\fs20\\lang16394\\langfe16394\\loch\\af31506\\hich\\af31506\\dbch\\af31505\\cgrid\\langnp16394\\langfenp16394{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3 DATOS DE LA COMPRA}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\par}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid3700287 \\par}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid3700287 \\cell}\\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trleft0\\trftsWidth1\\tblrsid16262128\\tblind5\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth9500\\clshdrawnil \\cellx9500\\row \\ltrrow}\\pard \\ltrpar\\qj \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid16262128{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3 DATOS DEL EQUIPO}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\par}{\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\par}{\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\cell} \\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\trowd \\irow1\\irowband1\\ltrrow\\ts11\\trleft0\\trftsWidth1\\tblrsid16262128\\tblind5\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth9500\\clshdrawnil \\cellx9500 \\row \\ltrrow}\\pard \\ltrpar\\qj \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid16262128 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3 OBSERVACIONES}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\par \\par}{\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\cell} \\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\trowd \\irow2\\irowband2\\ltrrow\\ts11\\trleft0\\trftsWidth1\\tblrsid16262128\\tblind5\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth9500\\clshdrawnil \\cellx9500 \\row \\ltrrow}\\pard \\ltrpar\\qj \\li0\\ri0\\nowidctlpar\\intbl\\wrapdefault\\faauto\\rin0\\lin0\\pararsid16262128 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\hich\\af3\\dbch\\af31505\\loch\\f3 CONCLUSION}{\\rtlch\\fcs1 \\ab\\af3\\afs20 \\ltrch\\fcs0 \\b\\f3\\fs20\\ul\\insrsid3700287 \\par \\par}{\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\cell} \\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af3\\afs20 \\ltrch\\fcs0 \\f3\\fs20\\insrsid3700287 \\trowd \\irow3\\irowband3\\lastrow \\ltrrow\\ts11\\trleft0\\trftsWidth1\\tblrsid16262128\\tblind5\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10 \\clbrdrl\\brdrs\\brdrw10 \\clbrdrb\\brdrs\\brdrw10 \\clbrdrr\\brdrs\\brdrw10 \\cltxlrtb\\clftsWidth3\\clwWidth9500\\clshdrawnil \\cellx9500\\row} \\pard \\ltrpar\\ql \\li0\\ri0\\sa200\\sl276\\slmult1\\widctlpar\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0 {\\rtlch\\fcs1 \\af31507 \\ltrch\\fcs0 \\insrsid2437689}\\b0 \\f3\\fs20";
			
		$this->cuerpo .= $this->tabla;
	}
	
	function ActaReunion()
	{
		$this->tabla .= "{\\rtlch\\fcs1\\af1\\ltrch\\fcs0\\b\\f3\\fs20\\insrsid3233031 TEMA: }{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs16\\insrsid16266379\\charrsid3233031 \\cell} \\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs16\\insrsid16266379\\charrsid3233031 \\trowd \\irow0\\irowband0\\lastrow \\ltrrow\\ts11\\trgaph70\\trrh722\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv \\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy16\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trautofit1\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031 \\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789 \\row} \\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0\\pararsid7866775 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs16\\insrsid16266379\\charrsid3233031 \\par \\ltrrow}\\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trgaph70\\trrh722\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv \\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposnegy-33\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trautofit1\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031 \\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789 \\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posnegy-33\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid16266379 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid16266379\\charrsid3233031 ACUERDOS ALCANZADOS }{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs16\\insrsid16266379\\charrsid3233031 \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 
\\b\\f3\\fs16\\insrsid16266379\\charrsid3233031 \\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trgaph70\\trrh722\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh
\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposnegy-33\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trautofit1\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031
\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalc\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789
\\row \\ltrrow}\\trowd \\irow1\\irowband1\\lastrow \\ltrrow\\ts11\\trgaph70\\trrh2944\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposnegy-33\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trautofit1\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031
\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posnegy-33\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid16266379 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid16266379\\charrsid8455219 

\\par \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid16266379\\charrsid8455219 \\trowd \\irow1\\irowband1\\lastrow \\ltrrow\\ts11\\trgaph70\\trrh2944\\trleft-108
\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposnegy-33\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8897\\trftsWidthB3\\trftsWidthA3\\trautofit1\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031
\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth8897\\clshdrawnil \\cellx8789
\\row \\ltrrow}\\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trgaph70\\trrh136\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid3233031 NOMBRE
\\cell CARGO\\cell }{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid3233031 E-MAIL}{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid3233031 \\cell INSTITUCI\\'d3N\\cell FIRMA\\cell }\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow0\\irowband0\\ltrrow\\ts11\\trgaph70\\trrh136\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow1\\irowband1\\ltrrow\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow1\\irowband1\\ltrrow
\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow2\\irowband2\\ltrrow\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow2\\irowband2\\ltrrow
\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow3\\irowband3\\ltrrow\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow3\\irowband3\\ltrrow
\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow4\\irowband4\\ltrrow\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow4\\irowband4\\ltrrow
\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow5\\irowband5\\ltrrow\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow5\\irowband5\\ltrrow
\\ts11\\trgaph70\\trrh264\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\trowd \\irow6\\irowband6\\ltrrow\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv
\\brdrs\\brdrw10\\brdrcf1 \\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband
\\tblind0\\tblindtype3 \\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 
\\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792
\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 
\\par \\cell \\cell \\cell \\cell \\cell }\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow6\\irowband6\\ltrrow
\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
\\ltrrow}\\pard \\ltrpar\\ql \\li0\\ri0\\widctlpar\\intbl\\pvpara\\phmrg\\posxc\\posy3\\dxfrtext141\\dfrmtxtx141\\dfrmtxty0\\wraparound\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\pararsid8194242 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 

\\par \\cell \\cell \\cell \\cell }{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid197227}{\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\cell }\\pard \\ltrpar
\\ql \\li0\\ri0\\widctlpar\\intbl\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid8194242\\charrsid8455219 \\trowd \\irow7\\irowband7\\lastrow \\ltrrow\\ts11\\trgaph70\\trrh271\\trleft-108\\trbrdrt
\\brdrs\\brdrw10\\brdrcf1 \\trbrdrl\\brdrs\\brdrw10\\brdrcf1 \\trbrdrb\\brdrs\\brdrw10\\brdrcf1 \\trbrdrr\\brdrs\\brdrw10\\brdrcf1 \\trbrdrh\\brdrs\\brdrw10\\brdrcf1 \\trbrdrv\\brdrs\\brdrw10\\brdrcf1 
\\tpvpara\\tphmrg\\tposxc\\tposy3\\tdfrmtxtLeft141\\tdfrmtxtRight141\\trftsWidth3\\trwWidth8900\\trftsWidthB3\\trftsWidthA3\\trpaddl108\\trpaddr108\\trpaddfl3\\trpaddft3\\trpaddfb3\\trpaddfr3\\tblrsid3233031\\tbllkhdrrows\\tbllkhdrcols\\tbllknocolband\\tblind0\\tblindtype3 
\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth2660\\clshdrawnil \\cellx2552\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl
\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1559\\clshdrawnil \\cellx4111\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr
\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1418\\clshdrawnil \\cellx5529\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 
\\cltxlrtb\\clftsWidth3\\clwWidth2025\\clshdrawnil \\cellx7554\\clvertalt\\clbrdrt\\brdrs\\brdrw10\\brdrcf1 \\clbrdrl\\brdrs\\brdrw10\\brdrcf1 \\clbrdrb\\brdrs\\brdrw10\\brdrcf1 \\clbrdrr\\brdrs\\brdrw10\\brdrcf1 \\cltxlrtb\\clftsWidth3\\clwWidth1238\\clshdrawnil \\cellx8792\\row 
}\\pard \\ltrpar\\qc \\li0\\ri0\\widctlpar\\wrapdefault\\aspalpha\\aspnum\\faauto\\adjustright\\rin0\\lin0\\itap0\\pararsid7866775 {\\rtlch\\fcs1 \\af1 \\ltrch\\fcs0 \\b\\f3\\fs20\\insrsid16266379\\charrsid8455219 \\par \\par}";
			
		$this->cuerpo .= $this->tabla;
	}
		
	function tablaEvaluacion()
	{
		$this->tabla .= "{";
		
		//  Definición de las celdas de datos. Se definen 6 columnas y 10 filas
		$this->tabla.= "
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx1500
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx3000	
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx4500	
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx6000	
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx7500	
		
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx9000	
		";
		
		$this->tabla = str_replace(chr(13),'',$this->tabla);
		$this->tabla = str_replace(chr(9),'',$this->tabla);
		$this->tabla = str_replace(chr(10),'',$this->tabla);
		
		$this->tabla.= "{\\fs16\\b";  //<-- Fuente de tamaño 20 alineada a la derecha
		$this->tabla.= "\\qc ESPECIFICACION \\cell \\qc DETALLE \\cell \\qc \\cell \\qc \\cell \\qc \\cell \\qc \\cell"; //titulos de la tabla
		$this->tabla.= "}\\row\\fs16"; //<-- Fin del renglón de encabezado
		
		// Introducción de los datos 
		 $datos= array();
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		 $datos[]= array("\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ", "\\qj ");
		                                                                   
		foreach($datos as $v)
		{
			 $this->tabla.= " {$v[0]}\\cell {$v[1]}\\cell {$v[2]}\\cell {$v[3]}\\cell {$v[4]}\\cell {$v[5]}\\cell \n";
			 $this->tabla.= "\\row "; //<-- Fin del renglón
		}
		
		$this->tabla.= "}";  //<-- fin de la tabla	
				
		$this->cuerpo .= $this->tabla;
	}
	
	function tablaCI($aprobar,$archivar,$para_conocimiento,$analizar_comentar,$proceder,$difundir,$firmar,$verificar,$informar,$responder,$tomar_nota,$para_consideracion) //MFLORES /13/05/2011
	{
		$this->tabla .= "{";
		//$this->tabla.= "\\trgaph70"; //<-- márgenes izquierdo y derecho de las celdas=70
		//$this->tabla.= "\\trleft-10"; // <-- Posición izquierda la primera celda = -10
		
		//  Definición de las celdas de datos. Se definen 6 columnas y 4 filas
		$this->tabla.= "
		\\clbrdrl\\brdrw10\\brdrs
		\\clbrdrt\\brdrw10\\brdrs
		\\clbrdrr\\brdrw10\\brdrs
		\\clbrdrb\\brdrw10\\brdrs
		\\cellx2500
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx2900		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx5400		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx5800		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx8300	
			
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx8700
		";
		
		$this->tabla = str_replace(chr(13),'',$this->tabla);
		$this->tabla = str_replace(chr(9),'',$this->tabla);
		$this->tabla = str_replace(chr(10),'',$this->tabla);
		
		//Introducción de los títulos en el primer renglón
		$this->tabla.= "{";  //<-- Fuente de tamaño 20 alineada a la derecha
		$this->tabla.= "\\qr APROBAR \\cell \\qc $aprobar \\cell \\qr ARCHIVAR \\cell \\qc $archivar \\cell \\qr PARA CONOCIMIENTO \\cell \\qc $para_conocimiento \\cell"; //titulos de la tabla
		$this->tabla.= "}\\row"; //<-- Fin del renglón de encabezado
		
		// Introducción de los datos 
		 $datos= array();
		 //$datos[]= array("\\qr APROBAR", "\\qc $aprobar", "\\qr ARCHIVAR", "\\qc $archivar", "\\qr PARA CONOCIMIENTO", "\\qc $para_conocimiento");
		 $datos[]= array("\\qr ANALIZAR Y COMENTAR", "\\qc $analizar_comentar", "\\qr PROCEDER", "\\qc $proceder", "\\qr DIFUNDIR", "\\qc $difundir");
		 $datos[]= array("\\qr FIRMAR", "\\qc $firmar", "\\qr VERIFICAR", "\\qc $verificar", "\\qr INFORMAR", "\\qc $informar");
		 $datos[]= array("\\qr RESPONDER", "\\qc $responder", "\\qr TOMAR NOTA", "\\qc $tomar_nota", "\\qr PARA SU CONSIDERACIÓN", "\\qc $para_consideracion");
		                                                                   
		foreach($datos as $v)
		{
			 $this->tabla.= " {$v[0]}\\cell {$v[1]}\\cell {$v[2]}\\cell {$v[3]}\\cell {$v[4]}\\cell {$v[5]}\\cell \n";
			 $this->tabla.= "\\row "; //<-- Fin del renglón
		}
		
		$this->tabla.= "}";  //<-- fin de la tabla	
				
		$this->cuerpo .= $this->tabla;
	}
	
	// Header
	function getHeader() 
	{
		$header_buffer = "\\rtf{$this->rtf_version}\\ansi\\deff0\\deftab{$this->tab_width}\n\n";
		
		return $header_buffer;
	}
		
	// Font table
	function getFontTable() 
	{
		global $fonts_array;
		
		$font_buffer = "{\\fonttbl\n";
		foreach($fonts_array AS $fnum => $farray) {
			$font_buffer .= "{\\f{$fnum}\\f{$farray['family']}\\fcharset{$farray['charset']}{$farray['name']}}\n";
		}
		$font_buffer .= "}\n\n";		
		
		return $font_buffer;
	}
	
	// Colour table
	function getColourTable() 
	{
		$colour_buffer = "";
		if(sizeof($this->colour_table) > 0) {
			$colour_buffer = "{\\colortbl;\n";
			foreach($this->colour_table AS $cnum => $carray) {
				$colour_buffer .= "\\red{$carray['red']}\\green{$carray['green']}\\blue{$carray['blue']};\n";	
			}
			$colour_buffer .= "}\n\n";
		}
		
		return $colour_buffer;
	}
	
	// Information
	function getInformation() {
		$info_buffer = "";
		if(sizeof($this->info_table) > 0) {
			$info_buffer = "{\\info\n";
			foreach($this->info_table AS $name => $value) {
				$info_buffer .= "{\\{$name}{$value}}";
			}
			$info_buffer .= "}\n\n";
		}
		
		return $info_buffer;
	}
	
	// Default font settings
	function getDefaultFont() {
		$font_buffer = "\\f{$this->font_face}\\fs{$this->font_size}\n";
		
		return $font_buffer;
	}
	
	// Page display settings
	function getPageSettings() {
		if($this->page_orientation == 1)
			$page_buffer = "\\paperw{$this->page_width}\\paperh{$this->page_height}\n";
		else
			$page_buffer = "\\paperw{$this->page_height}\\paperh{$this->page_width}\\landscape\n";
			
		$page_buffer .= "\\pgncont\\pgndec\\pgnstarts1\\pgnrestart\n";
		
		return $page_buffer;
	}
	
	// Convert special characters to ASCII
	function specialCharacters($text) {
		$text_buffer = "";
		for($i = 0; $i < strlen($text); $i++)
			$text_buffer .= $this->escapeCharacter($text[$i]);
		
		return $text_buffer;
	}
	
	// Convert special characters to ASCII
	function escapeCharacter($character) {
		$escaped = "";
		if(ord($character) >= 0x00 && ord($character) < 0x20)
			$escaped = "\\'".dechex(ord($character));
		
		if ((ord($character) >= 0x20 && ord($character) < 0x80) || ord($character) == 0x09 || ord($character) == 0x0A)
			$escaped = $character;
		
		if (ord($character) >= 0x80 and ord($character) < 0xFF)
			$escaped = "\\'".dechex(ord($character));

		switch(ord($character)) {
			case 0x5C:
			case 0x7B:
			case 0x7D:
				$escaped = "\\".$character;
				break;
		}
		
		return $escaped;
	}
	
	// Parse the text input to RTF
	function parseDocument() 
	{
		$documentBuffer = $this->specialCharacters($this->document);
		
		if(preg_match("/<UL>(.*?)<\/UL>/mi", $documentBuffer)) 
		{
			$documentBuffer = str_replace("<UL>", "", $documentBuffer);
			$documentBuffer = str_replace("</UL>", "", $documentBuffer);
			$documentBuffer = preg_replace("/<LI>(.*?)<\/LI>/mi", "\\f{$this->font_size}\\'B7\\tab\\f{$this->font_face}\\1\\par", $documentBuffer);
		}
		
		$documentBuffer = preg_replace("/<P>(.*?)<\/P>/mi", "\\1\\par ", $documentBuffer);
		$documentBuffer = preg_replace("/<STRONG>(.*?)<\/STRONG>/mi", "\\b \\1\\b0 ", $documentBuffer);
		$documentBuffer = preg_replace("/<EM>(.*?)<\/EM>/mi", "\\i \\1\\i0 ", $documentBuffer);
		$documentBuffer = preg_replace("/<U>(.*?)<\/U>/mi", "\\ul \\1\\ul0 ", $documentBuffer);
		$documentBuffer = preg_replace("/<STRIKE>(.*?)<\/STRIKE>/mi", "\\strike \\1\\strike0 ", $documentBuffer);
		$documentBuffer = preg_replace("/<SUB>(.*?)<\/SUB>/mi", "{\\sub \\1}", $documentBuffer);
		$documentBuffer = preg_replace("/<SUP>(.*?)<\/SUP>/mi", "{\\super \\1}", $documentBuffer);
		
		$documentBuffer = preg_replace("/<H1>(.*?)<\/H1>/mi", "\\fs48\\b \\1\\b0\\fs{$this->font_size}\\par ", $documentBuffer);
		$documentBuffer = preg_replace("/<H2>(.*?)<\/H2>/mi", "\\fs36\\b \\1\\b0\\fs{$this->font_size}\\par ", $documentBuffer);
		$documentBuffer = preg_replace("/<H3>(.*?)<\/H3>/mi", "\\fs27\\b \\1\\b0\\fs{$this->font_size}\\par ", $documentBuffer);
		
		
		$documentBuffer = preg_replace("/<HR(.*?)>/i", "\\brdrb\\brdrs\\brdrw30\\brsp20 \\pard\\par ", $documentBuffer);
		$documentBuffer = str_replace("<BR>", "\\par ", $documentBuffer);
		$documentBuffer = str_replace("<TAB>", "\\tab ", $documentBuffer);
		
		$documentBuffer = $this->nl2par($documentBuffer);
		
		return $documentBuffer;
	}
}

?>
