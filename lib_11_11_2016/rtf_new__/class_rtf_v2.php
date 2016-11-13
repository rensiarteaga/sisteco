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
	// {\info {\title <title>} {\author <author>} {\operator <operator>}}
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
	
	//esta función sirve para agregar una imagen al documento RTF partir de una imagen del disco duro - MFLORES
	function rtfImage($imagen,$tipo)
	{
		
		if (!$fp = fopen($imagen,"rb")) 
		{
	        echo "Cannot open file ($imagen)";
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
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\pngblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			if (($tipo == "jpg") || ($tipo == "jpeg")) {
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\jpegblip\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$ancho."\\pichgoal".$alto;
			}
			
			if (($tipo == "bmp") ) {
								
				$this->retval = "{\\header{\\*\\shppict\n{\\pict\\dibitmap0\\picw" . $tamanio_img[0] . "\\pich" . $tamanio_img[1] . "\\picwgoal".$alto."\\pichgoal".$alto;				
			}
		} 
		else 
		{
			return FALSE;
		}
		$this->retval .= "\\bliptag" . (string)$tag . "{\\*\\blipuid" . sprintf("%032x", $tag) . "}\n";
		$this->retval .= $out;
		$this->retval .= "}}\n}";

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
		//Eliminado el soporte para archivos .GIF porque no todos los procesadores de texto lo soportan (algunos se vuelven locos y bloquean la pc :-s )
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
		} else {
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
		$this->crono = "{\\f3\\fs14 cc:, Cronol, File}";
		$this->cuerpo .= $this->crono;		
	}
	
	//insertar encabezado - MFLORES /13/05/2011
	function header($variable)
	{
		$this->cabecera = "{\\header $variable}";
		$this->cuerpo .= $this->cabecera;
	}	
	
	//insertar numero de pagina - MFLORES /13/05/2011
	function paginacion()
	{
		//$this->setDefaultFontSize(10);
		$this->pagina = "{\\footer \\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\tab\\f3\\fs14     Página \\chpgn}";
		$this->cuerpo .= $this->pagina;		
	}
	
	function margenes($marg)
	{
		$this->margen = "\\margl".$marg;
		$this->cuerpo .= $this->margen;
	}
	
	function tamanio_fuente($text)
	{
		$this->tam_font = "{\\f3\\fs14 $text/}";
		$this->cuerpo .= $this->tam_font;
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
		\\cellx3000		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx5500		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx6000		
		
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx8500	
			
		\\clbrdrl\\brdrw10\\brdrs 
		\\clbrdrt\\brdrw10\\brdrs 
		\\clbrdrr\\brdrw10\\brdrs 
		\\clbrdrb\\brdrw10\\brdrs 
		\\cellx9000
		";
		
		$this->tabla = str_replace(chr(13),'',$this->tabla);
		$this->tabla = str_replace(chr(9),'',$this->tabla);
		$this->tabla = str_replace(chr(10),'',$this->tabla);
		
		//Introducción de los títulos en el primer renglón
		$this->tabla.= "{";  //<-- Fuente de tamaño 20 alineada a la derecha
		$this->tabla.= "\\qr APROBAR \\cell \\qc $aprobar \\cell \\qr ARCHIVAR \\cell \\qc $archivar \\cell \\qr PARA CONOCIMIENTO \\cell \\qc $para_conocimiento \\cell"; //titulos de la tabla
		$this->tabla.= " }\\row"; //<-- Fin del renglón de encabezado
		
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
		
		$this->tabla.= "} ";  //<-- fin de la tabla	
				
		$this->cuerpo .= $this->tabla;
	}
	
	// Header
	function getHeader() {
		$header_buffer = "\\rtf{$this->rtf_version}\\ansi\\deff0\\deftab{$this->tab_width}\n\n";
		
		return $header_buffer;
	}
		
	// Font table
	function getFontTable() {
		global $fonts_array;
		
		$font_buffer = "{\\fonttbl\n";
		foreach($fonts_array AS $fnum => $farray) {
			$font_buffer .= "{\\f{$fnum}\\f{$farray['family']}\\fcharset{$farray['charset']} {$farray['name']}}\n";
		}
		$font_buffer .= "}\n\n";		
		
		return $font_buffer;
	}
	
	// Colour table
	function getColourTable() {
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
				$info_buffer .= "{\\{$name} {$value}}";
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
	function parseDocument() {
		$documentBuffer = $this->specialCharacters($this->document);
		
		if(preg_match("/<UL>(.*?)<\/UL>/mi", $documentBuffer)) {
			$documentBuffer = str_replace("<UL>", "", $documentBuffer);
			$documentBuffer = str_replace("</UL>", "", $documentBuffer);
			$documentBuffer = preg_replace("/<LI>(.*?)<\/LI>/mi", "\\f3\\'B7\\tab\\f{$this->font_face} \\1\\par", $documentBuffer);
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
