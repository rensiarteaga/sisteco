<?php

/**
* Nombre de archivo:	    subir_archivo
* Propósito:				Permite subir archivos a la BD
* Fecha de Creación:		2011-02-08
* Autor:					Marcos A. Flores Valda
*/
 
class cls_DBAnexo
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct()
	{
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarAnexo
	 * Propósito:				Desplegar los registros de tfl_anexo
	 * Autor:				    Marcos A. Flores Valda
	 * Fecha de creación:		2011-02-08
	 */
	function ListarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_anexo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_subir_archivo_sel';
		$this->codigo_procedimiento = "'FL_ANEXO_SEL'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_anexo','int4');
		$this->var->add_def_cols('nombre','varchar');		//crea el nodo para mostrarlo en el grid
		$this->var->add_def_cols('foto','bytea');
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
				
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarColumna
	 * Propósito:				Contar los registros de tfl_anexo
	 * Autor:				    Marcos A. Flores Valda
	 * Fecha de creación:		2011-02-08
	 */
	function ContarAnexo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_subir_archivo_sel';
		$this->codigo_procedimiento = "'FL_ANEXO_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecución
		return $res;
	}	

	function InsertarArchivoBD($id_anexo,$nombre)
	{		
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_subir_archivo_iud';
		$this->codigo_procedimiento = "'FL_SUBARC_INS'";							
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_anexo);
		$this->var->add_param("'$nombre'");
		//$this->var->add_param("'$buffer1'"); //foto convertida
		//$this->var->add_param($foto); //foto convertida
						
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;

		return $res;
	}
	
}?>