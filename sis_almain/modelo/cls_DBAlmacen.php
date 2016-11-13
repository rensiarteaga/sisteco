<?php
/**
 * Nombre de la Clase:	cls_DBAlmacen
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_almacen
 * Autor:				Ruddy Lujan Bravo
 * Fecha creación:		25-07-2013
 *
 */ 
class cls_DBAlmacen {
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
	var $nombre_archivo = "cls_DBAlmacen.php";
	
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
	 * Nombre de la función:	ListarAlmacen
	 * Propósito:				Desplegar los registros de tal_almacen en función de los parámetros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creación:		25-07-2013
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
	function ListarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{

		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_sel'; 
		$this->codigo_procedimiento = "'AL_ALMA_SEL'";
		
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
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('id_lugar', 'integer');
		$this->var->add_def_cols('id_depto', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('direccion', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('tipo_control', 'varchar');
		$this->var->add_def_cols('nombre_lugar', 'varchar');
		$this->var->add_def_cols('nombre_depto', 'varchar');
		$this->var->add_def_cols('demasia', 'numeric');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		// echo $this->query;
		// exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarAlmacen
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creación:		25-07-2013
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
	function ContarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_sel';
		$this->codigo_procedimiento = "'AL_ALMA_COUNT'";
		
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
	 * Nombre de la función:	EliminarAlmacen
	 * Propósito:				Eliminar registros de la tabla tal_almacen mediante filtros
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creación:		125-07-2013
	 */
	function EliminarAlmacen($id_almacen) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMA_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_almacen"); // id de almacen
		$this->var->add_param("NULL"); // id de lugar
		$this->var->add_param("NULL"); // id de departamento
		$this->var->add_param("NULL"); // codigo
		$this->var->add_param("NULL"); // nombre
		$this->var->add_param("NULL"); // direccion
		$this->var->add_param("NULL"); // estado
		$this->var->add_param("NULL"); // tipo_control
		//demasia 17-11-2014
		$this->var->add_param("NULL");//al_demasia
		                               
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function InsertarAlmacen($id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMA_INS'";
	
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_lugar);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$tipo_control'");
		//demasia 17-11-2014
		$this->var->add_param($demasia); 
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarAlmacen($id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALMA_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
	
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_lugar);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$direccion'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$tipo_control'");
		//demasia 17-11-2014
		$this->var->add_param($demasia);
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ActivarInactivarAlmacen($id_almacen) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_almacen_iud';
		$this->codigo_procedimiento = "'AL_ALACTIVE_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_almacen);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		//demasia 17-11-2014
		$this->var->add_param('NULL');
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ValidarAlmacen($operacion_sql, $id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_almacen");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_lugar - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_lugar");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar", $id_lugar)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar id_departamento - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar direccion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("direccion");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "direccion", $direccion)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar tipo_control - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_control");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_control", $tipo_control)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		} elseif ($operacion_sql == 'delete') {
			// Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	function ControlTipoAlmacen($id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ai_tipo_control_almacen';
		$this->codigo_procedimiento = "'AL_TIPO_CONTROL_ALMACEN'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_almacen"); // id de almacen

		 
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		echo $this->query;exit;
		return $res;
	}
}
?>
