<?php

class cls_DBCbteDepto
{
	//Variable que contiene la salida de la ejecuciÃ³n de la funciÃ³n
	//si la funciÃ³n tuvo error (false), salida contendrÃ¡ el mensaje de error
	//si la funciÃ³n no tuvo error (true), salida contendrÃ¡ el resultado, ya sea un conjunto de datos o un mensaje de confirmaciÃ³n
	var $salida;

	//Variable que contendrÃ¡ la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecuciÃ³n de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la funciÃ³n a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBCbteDepto.php";

	//Matriz de parÃ¡metros de validaciÃ³n de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarÃ¡n o no
	var $decodificar = false;

	function __construct($decodificar)
	{
			
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	
	function ListarCbteDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_cbte_depto_sel';
		$this->codigo_procedimiento = "'AF_CBTEDEPTO_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parÃƒÂ¡metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('id_cbte_depto', 'integer');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_depto', 'integer');
		$this->var->add_def_cols('desc_depto', 'text');
		
	
		//Ejecuta la funciÃƒÂ³n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciÃƒÂ³n y retorna el resultado de la ejecuciÃƒÂ³n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamÃƒÂ³ a la funciÃƒÂ³n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	

	
	
	function ContarCbteDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_cbte_depto_sel';
		$this->codigo_procedimiento = "'AF_CBTEDEPTO_COUNT'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;
		
		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	 
	
	function InsertarCbteDepto($id_depto,$descripcion,$id_regional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_cbte_depto_iud';
		$this->codigo_procedimiento = "'AF_CBTEDEPTO_INS'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param("'$descripcion'");

		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ModificarCbteDepto($id,$id_depto,$descripcion,$id_regional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_cbte_depto_iud';
		$this->codigo_procedimiento = "'AF_CBTEDEPTO_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param("'$descripcion'");
	
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function EliminarCbteDepto($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_cbte_depto_iud';
		$this->codigo_procedimiento = "'AF_CBTEDEPTO_DEL'";
		
		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NUll");

		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
}?>