<?php
/**
 * Nombre de la Clase:	cls_DBFaseTramo.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_tramo_fase
 * Autor:				UNKNOW
 * Fecha creación:		05-12-2014
 *
 */ 
class cls_DBFaseTramo
{ 
	// Variable que contiene la salida de la ejecución de la función
	// si la función tuvo error (false), salida contendrá el mensaje de error
	// si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;
	
	// Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecución de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la función a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBFaseTramo.php";
	
	// Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	function __construct() {
		// Carga los parámetro de validación de todas las columnas
		// $this->cargar_param_valid();
		
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarFaseTramo
	 * Propósito:				Desplegar los registros de tal_tramo en función de los parámetros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		09-12-2014
	 *
	 * @param unknown_type $cant        	
	 * @param unknown_type $puntero        	
	 * @param unknown_type $sortcol        	
	 * @param unknown_type $sortdir        	
	 * @param unknown_type $criterio_filtro        	
	 * @param unknown_type $id_financiador        	
	 * @param unknown_type $id_regional        	
	 * @param unknown_type $id_programa        	
	 * @param unknown_type $id_proyecto        	
	 * @param unknown_type $id_actividad        	
	 * @return unknown 
	 */ 
	function ListarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_fase_tramo_sel';
		$this->codigo_procedimiento = "'AL_FATRAM_SEL'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_fase_tramo	', 'integer');
		$this->var->add_def_cols('id_fase', 'integer'); 
		$this->var->add_def_cols('desc_fase', 'text');
		$this->var->add_def_cols('id_tramo', 'integer');
		$this->var->add_def_cols('desc_tramo', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('estado', 'varchar');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarFaseTramo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		05-12-2014
	 *
	 * @param unknown_type $cant        	
	 * @param unknown_type $puntero        	
	 * @param unknown_type $sortcol        	
	 * @param unknown_type $sortdir        	
	 * @param unknown_type $criterio_filtro        	
	 * @param unknown_type $id_financiador        	
	 * @param unknown_type $id_regional        	
	 * @param unknown_type $id_programa        	
	 * @param unknown_type $id_proyecto        	
	 * @param unknown_type $id_actividad        	
	 * @return unknown
	 */
	function ContarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_fase_tramo_sel';
		$this->codigo_procedimiento = "'AL_FATRAM_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero; 
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		// Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		// Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarFaseTramo
	 * Propósito:				Eliminar registros de la tabla tal_fase_tramo mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creación:		09-12-2014
	 */
	function EliminarFaseTramo($id_fase_tramo) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_fase_tramo_iud';
		$this->codigo_procedimiento = "'AL_FATRAM_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param($id_fase_tramo);//al_id_fase_tramo
		$this->var->add_param("NULL");//al_id_fase
		$this->var->add_param("NULL");//al_id_tramo
		$this->var->add_param("'NULL'");//al_estado
		 		                               
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	function InsertarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_fase_tramo_iud';
		$this->codigo_procedimiento = "'AL_FATRAM_INS'";
	
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_fase_tramo
		$this->var->add_param($id_fase);//al_id_fase
		$this->var->add_param($id_tramo);//al_id_tramo
		$this->var->add_param("'$estado'");//al_estado


		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function ModificarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_fase_tramo_iud';
		$this->codigo_procedimiento = "'AL_FATRAM_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
	
		$this->var->add_param($id_fase_tramo);//al_id_fase_tramo
		$this->var->add_param($id_fase);//al_id_fase
		$this->var->add_param($id_tramo);//al_id_tramo
		$this->var->add_param("'$estado'");//al_estado
			
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	function ValidarFaseTramo($sql,$id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($sql == 'insert' || $sql == 'update') 
		{
			if ($sql == 'update') 
			{
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_fase_tramo");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fase_tramo", $id_fase_tramo)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			// Validar id_fase - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fase");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fase", $id_fase)) 
			{
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_tramo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tramo");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tramo", $id_tramo))
			{
				$this->salida = $valid->salida;
				return false;
			}
			// Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(50);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
				
			return true;
		} 
		elseif ($sql == 'delete') 
		{
			// Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fase_tramo");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fase_tramo", $id_fase_tramo)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} 
		else {
			return false;
		}
	}
}
?>