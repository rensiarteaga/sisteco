<?php
/**
 * Nombre clase:	cls_define_tipo_dato
 * Propósito:		Clase que sirve para definir los diferentes formatos de tipos de datos
 * Autor:			Veimar Soliz Poveda
 * Fecha creación:	12-06-2007
 *
 */
class cls_define_tipo_dato
{
	//variable que contiene la salida de la ejecución de la función
	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Variable allowBlank
	var $allowblank;
	//Bandera de la variable allowblank
	var $bandera_allowblank;
	
	//Variable columna
	var $columna;
	//Bandera de la variable columna
	var $bandera_columna;	
	
	//Variable maxlength
	var $maxlength;
	//Bandera de la variable maxlength
	var $bandera_maxlength;
	
	//Variable minLength
	var $minlength;
	//Bandera de la variable minLength
	var $bandera_minlength;	

	//Variable signo
	var $signo;
	//Bandera de la variable signo
	var $bandera_signo;
	
		
	//Variable que contiene el nombre del archivo
	var $nombre_archivo = "cls_define_tipo_dato.php";	
	
	
	
	/**
	 * Modifica el valor de columna
	 *
	 * @param unknown_type $valor
	 */
	function set_Columna($valor)
	{
		$this->columna = $valor;
		$this->bandera_columna = 1;
	}	
			
	/**
	 * Modifica el valor de AllowBlank
	 *
	 * @param unknown_type $valor
	 */
	function set_AllowBlank($valor)
	{
		$this->allowblank = $valor;
		$this->bandera_allowblank = 1;
	}	
	
	/**
	 * Modifica el valor de MaxLength
	 *
	 * @param unknown_type $valor
	 */
	function set_MaxLength($valor)
	{
		$this->maxlength = $valor;
		$this->bandera_maxlength = 1;
	}
	
	/**
	 * Modifica el valor de minlength
	 *
	 * @param unknown_type $valor
	 */
	function set_MinLength($valor)
	{
		$this->minlength = $valor;
		$this->bandera_minlength = 1;
	}	
	
	/**
	 * Modifica el valor de signo
	 *
	 * @param unknown_type $valor
	 */
	function set_Signo($valor)
	{
		$this->signo = $valor;
		$this->bandera_signo = 1;
	}	
	
	/**
	 * Reinicia los valores por defecto de la clase
	 *
	 */
	function _reiniciar_valor()
	{
		$this->bandera_columna = 0;
		$this->bandera_allowblank = 0;
		$this->bandera_maxlength = 0;
		$this->bandera_minlength = 0;
		$this->bandera_signo = 0;
	}
	
	
	/**
	 * Función con lo criterios de validacion del tipo de dato integer
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoInteger()
	{
		
		$this->matriz_validacion[0] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[0]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[0]['Columna'] ="";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[0]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[0]['allowBlank'] ="false";	
		}
		

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[0]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[0]['maxLength'] = 15;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[0]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[0]['minLength'] =0;	
		}		
		
		/**
		 * Signo del dato
		 */
		if ($this->bandera_signo == 1)	{	
			$this->matriz_validacion[0]['signo'] = $this->signo;
		}
		else 
		{
			$this->matriz_validacion[0]['signo'] ="";	
		}
			
		/**
		 * Tipo de Dato alphaLatino
		 */		
		$this->matriz_validacion[0]['vtype'] = "alphaLatino";
		
		/**
		 * DataType integer
		 */		
		$this->matriz_validacion[0]['dataType'] = "entero";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[0]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[0]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		
		
		
		return $this->matriz_validacion[0];
	}		
	
	
	/**
	 * Función con lo criterios de validacion del tipo de dato date
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoDate()	
	{
		
		$this->matriz_validacion[1] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[1]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[1]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[1]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[1]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[1]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[1]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[1]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[1]['minLength'] = 0;	
		}		
				
		/**
		 * Tipo de Dato alphaLatino
		 */		
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		
		/**
		 * DataType date
		 */		
		$this->matriz_validacion[1]['dataType'] = "fecha";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[1]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[1]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[1]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[1];
	}	
	
	/**
	 * Función con lo criterios de validacion del tipo de dato date time
	 *
	 * @return unknown
	 */
	function TipoDatoDateTime()	
	{
		
		$this->matriz_validacion[1] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[1]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[1]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[1]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[1]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[1]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[1]['maxLength'] = 20;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[1]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[1]['minLength'] = 0;	
		}		
				
		/**
		 * Tipo de Dato alphaLatino
		 */		
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		
		/**
		 * DataType date
		 */		
		$this->matriz_validacion[1]['dataType'] = "fecha_hora";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[1]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[1]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[1]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[1];
	}	
	
	
	/**
	 * Función con lo criterios de validacion del tipo de dato email
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoEmail()	
	{
		
		$this->matriz_validacion[2] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[2]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[2]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[2]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[2]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[2]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[2]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[2]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[2]['minLength'] = 0;	
		}		
			
		/**
		 * Tipo de Dato email
		 */		
		$this->matriz_validacion[2]['vtype'] = "email";
		
		/**
		 * DataType email
		 */		
		$this->matriz_validacion[2]['dataType'] = "email";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[2]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[2]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[2]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[2];
	}	
	
	/**
	 * Función con lo criterios de validacion del tipo de dato url
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoUrl()		
	{
		
		$this->matriz_validacion[3] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[3]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[3]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[3]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[3]['allowBlank'] ="true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[3]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[3]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[3]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[3]['minLength'] = 0;	
		}			
		
		
		/**
		 * Tipo de Dato email
		 */		
		$this->matriz_validacion[3]['vtype'] = "url";
		
		/**
		 * DataType email
		 */		
		$this->matriz_validacion[3]['dataType'] = "url";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[3]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[3]['grow'] = ""; 
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[3]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[3];
	}
	
	/**
	 * Función con lo criterios de validacion del tipo de dato alphalatino
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoAlphalatino()	
	{
		
		$this->matriz_validacion[4] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[4]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[4]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[4]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[4]['allowBlank'] ="true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[4]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[4]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength)	{	
			$this->matriz_validacion[4]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[4]['minLength'] = 0;	
		}		
		
		/**
		 * Tipo de Dato alphalatino
		 */		
		$this->matriz_validacion[4]['vtype'] = "alphalatino";
		
		/**
		 * DataType alphalatino
		 */		
		$this->matriz_validacion[4]['dataType'] = "texto";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[4]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[4]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[4]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[4];
	}
	
	/**
	 * Función con lo criterios de validacion del tipo de dato real
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoReal()
	{
		
		$this->matriz_validacion[5] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[5]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[5]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[5]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[5]['allowBlank'] = "false";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[5]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[5]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[5]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[5]['minLength'] = 0;	
		}		
		
		/**
		 * Signo del dato
		 */
		if ($this->bandera_signo == 1)	{	
			$this->matriz_validacion[5]['signo'] = $this->signo;
		}
		else 
		{
			$this->matriz_validacion[5]['signo'] = "";	
		}			
		
		/**
		 * Tipo de Dato real
		 */		
		$this->matriz_validacion[5]['vtype'] = "real";
		
		/**
		 * DataType real
		 */		
		$this->matriz_validacion[5]['dataType'] = "real";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[5]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[5]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[5];
	}	
	

	/**
	 * Función con lo criterios de validacion del tipo de dato text
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoText()
	{

		$this->matriz_validacion[6] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[6]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[6]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[6]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[6]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[6]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[6]['maxLength'] = 30;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[6]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[6]['minLength'] = 0;	
		}		
				
		/**
		 * Tipo de Dato text
		 */		
		$this->matriz_validacion[6]['vtype'] = "alphalatino";
		
		/**
		 * DataType text
		 */		
		$this->matriz_validacion[6]['dataType'] = "texto";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[6]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[6]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[6]['SelectOnFocus'] = "true";

		return $this->matriz_validacion[6];
	}	

	/**
	 * Función con lo criterios de validacion del tipo de dato time
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoTime()
	{
		
		$this->matriz_validacion[7] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[7]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[7]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[7]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[7]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[7]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[7]['maxLength'] = 15;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[7]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[7]['minLength'] = 0;	
		}		
		
		/**
		 * Tipo de Dato time
		 */		
		$this->matriz_validacion[7]['vtype'] = "hora";
		
		/**
		 * DataType time
		 */		
		$this->matriz_validacion[7]['dataType'] = "hora";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[7]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[7]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[7]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[7];
	}

	/**
	 * Función con lo criterios de validacion del tipo de dato time
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoInterval()
	{
		
		$this->matriz_validacion[8] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[8]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[8]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[8]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[8]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->bandera_maxlength == 1)	{	
			$this->matriz_validacion[8]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[8]['maxLength'] = 15;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[8]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[8]['minLength'] = 0;	
		}		
		
		/**
		 * Tipo de Dato time
		 */		
		$this->matriz_validacion[8]['vtype'] = "interval";
		
		/**
		 * DataType time
		 */		
		$this->matriz_validacion[8]['dataType'] = "interval";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[8]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[8]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[8]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[8];
	}
	/**
	 * Función con lo criterios de validacion del tipo de dato porcentaje de 0 a 1
	 *
	 * @param unknown_type $matriz_tipo_dato
	 * @return unknown
	 */
	function TipoDatoPorcent()
	{
		
		$this->matriz_validacion[8] = array();
		
		/**
		 * Nombre de la columna
		 */
		if ($this->bandera_columna == 1)	{	
			$this->matriz_validacion[8]['Columna'] = $this->columna;
		}
		else 
		{
			$this->matriz_validacion[8]['Columna'] = "";	
		}
		
		/**
		 * Acepta Null o no
		 */
		if ($this->bandera_allowblank == 1)	{	
			$this->matriz_validacion[8]['allowBlank'] = $this->allowblank;
		}
		else 
		{
			$this->matriz_validacion[8]['allowBlank'] = "true";	
		}

		/**
		 * Longitud máxima del dato
		 */
		if ($this->maxlength == 1)	{	
			$this->matriz_validacion[8]['maxLength'] = $this->maxlength;
		}
		else 
		{
			$this->matriz_validacion[8]['maxLength'] = 5;	
		}		
			
		/**
		 * Longitud mínima del dato
		 */
		if ($this->bandera_minlength == 1)	{	
			$this->matriz_validacion[8]['minLength'] = $this->minlength;
		}
		else 
		{
			$this->matriz_validacion[8]['minLength'] = 0;	
		}
				
		/**
		 * Tipo de Dato porcent
		 */		
		$this->matriz_validacion[8]['vtype'] = "porcent";
		
		/**
		 * DataType porcent
		 */		
		$this->matriz_validacion[8]['dataType'] = "porcentaje";
		
		/**
		 * width
		 */		
		$this->matriz_validacion[8]['width'] = "";
		
		/**
		 * grow
		 */		
		$this->matriz_validacion[8]['grow'] = "";
		
		/**
		 * SelectOnFocus
		 */		
		$this->matriz_validacion[8]['SelectOnFocus'] = "true";
		
		return $this->matriz_validacion[8];
	}
	
}//FIN CLASE
?>