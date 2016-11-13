<?php
/**
 * Nombre de la Clase:	cls_DBFaseTramoUnidadConstructiva
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_tramo_unidad_constructiva
 * Autor:				UNKNOW
 * Fecha creación:		15-12-2014
 *
 */
class cls_DBTramoUnidadConstructiva 
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
	var $nombre_archivo = "cls_DBTramoUnidadConstructiva.php";
	
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
	 * Nombre de la función:	ListarTramoUnidadConstructiva
	 * Propósito:				Desplegar los registros de tal_tramo en función de los parámetros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		15-12-2014
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
	function ListarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_tramo_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_TRAMUC_SEL'";
		
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
		$this->var->add_def_cols('id_tramo_unidad_constructiva', 'integer');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		$this->var->add_def_cols('desc_uc', 'text');
		$this->var->add_def_cols('id_tramo', 'integer');
		$this->var->add_def_cols('desc_tramo', 'text');
		$this->var->add_def_cols('codigo', 'varchar');
		
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
	 * Nombre de la función:	ContarTramoUnidadConstructiva
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		15-12-2014
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
	function ContarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_tramo_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_TRAMUC_COUNT'";
		
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
	 * Nombre de la función:	EliminarTramoUnidadConstructiva
	 * Propósito:				Eliminar registros de la tabla tal_tramo_uniadd_constructiva mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creación:		24-12-2014
	 */
	function EliminarTramoUC($id_tramo_uc) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_tramo_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AL_TRAMUC_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param($id_tramo_uc);//al_id_tramo_unidad_constructiva
		$this->var->add_param("NULL");//al_id_unidad_constructiva
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
	
	
	function InsertarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_tramo_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AL_TRAMUC_INS'";
	
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_tramo_unidad_constructiva
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
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
	function ModificarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_tramo_unidad_constructiva_iud';
		$this->codigo_procedimiento = "'AL_TRAMUC_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
	
		$this->var->add_param($id_tramo_uc);//al_id_tramo_unidad_constructiva
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
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

	function ValidarTramoUC($sql,$id_tramo_uc,$id_tramo, $id_uc,$estado)
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
				$tipo_dato->set_Columna("id_tramo_unidad_constructiva");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tramo_unidad_constructiva", $id_tramo_uc)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			// Validar 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tramo");
			$tipo_dato->set_AllowBlank(true);
			$tipo_dato->set_MaxLength(20);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tramo", $id_tramo)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_constructiva");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(20);
		
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva", $id_uc)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			
		
			return true;
		} 
		elseif ($operacion_sql == 'delete') 
		{
			// Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tramo_unidad_constructiva");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tramo_unidad_constructiva", $id_tramo_uc)) {
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
