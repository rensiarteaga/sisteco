<?php
/**
 * Nombre de la Clase:	cls_DBIngresos
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_ingresos
 * Autor:				UNKNOW
 * Fecha creación:		05-05-2015
 *
 */
class cls_DBCosto 
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
	var $nombre_archivo = "cls_DBCosto.php";
	
	// Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	function __construct() {
		// Carga los parámetro de validación de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarCosto
	 * Propósito:				Desplegar los registros de tal_ingresos en función de los parámetros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		05-05-2015
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
	function ListarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_costo_sel';
		$this->codigo_procedimiento = "'AL_COSTO_SEL'";
		
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
		$this->var->add_def_cols('id_costo','integer');
		$this->var->add_def_cols('codigo_costo','varchar');
	 	$this->var->add_def_cols('desc_costo','varchar');
	 	$this->var->add_def_cols('estado','varchar');
	 	$this->var->add_def_cols('fecha_reg','text');
	 	$this->var->add_def_cols('usuario_reg','varchar');

		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarCosto
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					unknow
	 * Fecha de creación:		05-05-2015
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
	function ContarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_costo_sel';
		$this->codigo_procedimiento = "'AL_COSTO_COUNT'";
		 
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
	 * Nombre de la función:	EliminarMovimientoProyecto
	 * Propósito:				Eliminar registros de la tabla tal_movimiento_proyecto mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creación:		10-27-2014
	 */
	function EliminarCosto($id_costo) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_costo_iud';
		$this->codigo_procedimiento = "'AL_COSTO_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_costo");//al_id_costo
		$this->var->add_param("NULL");//al_cod_costo
		$this->var->add_param("NULL");//al_desc_costo
		$this->var->add_param("NULL");//al_estado
		                               
		// Ejecuta la función 
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarCosto($id_costo, $cod_costo, $desc_costo, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_costo_iud';
		$this->codigo_procedimiento = "'AL_COSTO_INS'";
		 
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_costo
		$this->var->add_param("'$cod_costo'");//al_cod_costo
		$this->var->add_param("'$desc_costo'");//al_desc_costo
		$this->var->add_param("'$estado'");//al_estado
		
			
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarCosto($id_costo, $cod_costo, $desc_costo, $estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_costo_iud';
		$this->codigo_procedimiento = "'AL_COSTO_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("$id_costo");//al_id_costo
		$this->var->add_param("'$cod_costo'");//al_cod_costo
		$this->var->add_param("'$desc_costo'");//al_desc_costo
		$this->var->add_param("'$estado'");//al_estado
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	function ValidarMovimientoProyecto($sql, $id_movimiento_proyecto, $almacen,$fecha_ingreso, $concepto_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($sql == 'insert' || $sql == 'update') {
			if ($sql == 'update') 
			{
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("id_movimiento_proyecto");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_movimiento_proyecto", $id_movimiento_proyecto)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $almacen)) 
			{
				$this->salida = $valid->salida;
				return false;
			}
			// Validar concepto_ingreso - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto_ingreso");
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto_ingreso", $concepto_ingreso)) {
				$this->salida = $valid->salida;
				return false;
			}

			// Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones)) {
				$this->salida = $valid->salida;
				return false;
			}
		
			return true;
		} 
	}
}
?>
