<?php
/**
 * Nombre clase:	cls_manejo_xml
 * Propósito:		Permite crear cadenas en formato xml a partir de un nodo principal
 * Autor:			Rodrigo Chumacero Moscoso
 * Fecha creación:	25-05-2007
 */

class cls_manejo_xml
{
	var $xml;//Variable que contendrá el xml
	var $etiqueta_arbol;
	var $func; //instancia de la clase funciones para acceder a sus métodos
	var $array_etiquetas_rama = array();//Array que contendrá las etiquetas de todas las ramas temporalmente
	var $encoding_xml; //Codificación que se utilizará para el xml
	var $encoding_header; //Codificación que se utilizará para el Header de despliegue del xml
	var $version_xml = '1.0' ;//Versión del xml
	var $terminado = false;//Vriable que indica si se colocó ya su fin de nodo raíz

	//Variable que contiene el código del header del html
	var $codigo_header;

	public function __construct($etiqueta_arbol="", $codigo_header="")
	{ 
		session_start();
		//Obtiene las codificaciones de la configuración
		$this->encoding_xml = $_SESSION["CODIFICACION_XML"];
		$this->encoding_header = $_SESSION["CODIFICACION_HEADER"];
		$this->codigo_header = $codigo_header;
		$this->etiqueta_arbol = $etiqueta_arbol;
		$this->func = new cls_funciones();

		
		
		//Crea el encabezado del xml
		if($this->encoding_xml == "")
		{
			$this->xml = "<?xml version=\"$this->version_xml\"?>\n";
		}
		else
		{
		   $this->xml = "<?xml version=\"$this->version_xml\" encoding=\"$this->encoding_xml\"?>\n";
		}

		//Añade el nodo raíz
		
		
		$this->xml .= "<$etiqueta_arbol>\n";
		//$this->xml .="<aaa>\n";
		
	}

	//Añade un nodo xml
	public function add_nodo($etiqueta_nodo, $valor)
	{
		$this->xml .= "<$etiqueta_nodo>$valor</$etiqueta_nodo>\n";
		
	}

	//Añade una rama
	public function add_rama($etiqueta_rama)
	{
		//Coloca temporalmente la etiqueta de la rama, hasta que se cierre (al cerrar se borrará el elemento de la etiqueta)
		array_push($this->array_etiquetas_rama,$etiqueta_rama);
		$this->xml .= "<$etiqueta_rama>\n";
		
		
	}

	public function fin_rama()
	{
		$aux = array_pop($this->array_etiquetas_rama);
		$this->xml .= "</$aux>\n";
		//$this->terminado = true;
		
	}

	public function cadena_xml()
	{ 
		if(!$this->terminado)
		{
			
			//$this->xml .= "</$this->etiqueta_arbol>\n";
			
			$this->terminado = true;
		}
		return $this->xml;
	}

	public function mostrar_xml()
	{
		if(!$this->terminado)
		{
			
			$this->xml .= "</$this->etiqueta_arbol>\n";
			//$this->xml .="</>\n";
			
			$this->terminado = true;
		}

		//Despliega el header del html si es que tuviese
		if($this->codigo_header!="")
		{
			//Despliega el header correspondiente
			$aux = $this->header($this->codigo_header);
			if($aux != '') header($aux);
		}

		//Despliega el header del xml
		if($this->encoding_header == "")
		{
			//header('Content-Type:text/xml');
			header('Content-Type:text');
		}
		else
		{
			header("Content-Type:text; charset=$this->encoding_header");
		}

		//Despliega el xml
		echo $this->xml;
	}

	/**
	 * Nombre función:	header
	 * Propósito:		Devolver el header de html a partir del código header del html
	 * Fecha creación:	25-05-2007
	 * Autor:			Rodrigo Chumacero Moscoso
	 *
	 * @param unknown_type $codigo_header
	 * @return unknown
	 */
	function header($codigo_header)
	{
		switch ($codigo_header)
		{
			case '406':
				return "HTTP/1.1 $codigo_header No Aceptable";
				break;


			case '409':
				return "HTTP/1.1 $codigo_header  Conflict";
				break;


			case '412':
				return "HTTP/1.1 $codigo_header Precondition Failed";  //lo reconoce exoplorer

				break;

			case '500':
				return "HTTP/1.1 $codigo_header  Internal Server Error";
				break;
				
			case '503':
				return "HTTP/1.1 $codigo_header   Service Unavailable"; //lo reconoce exoplorer
				break;

			case '401':
				return "HTTP/1.1 $codigo_header No autorizado"; //lo reconoce exoplorer
				break;

			case '202':
				return "HTTP/1.1 $codigo_header ok";  //lo reconoce exoplorer
				break;

			default:
				return '';
				break;
		}
	}

}
?>