<?php
/**
 * Nombre de la Clase:	cls_DBUbicacion
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla tal_ubicacion
 * Autor:				Ruddy Lujan Bravo
 * Fecha creaciï¿½n:		09-08-2013
 *
 */
class cls_DBUbicacion {
	// Variable que contiene la salida de la ejecuciï¿½n de la funciï¿½n
	// si la funciï¿½n tuvo error (false), salida contendrï¿½ el mensaje de error
	// si la funciï¿½n no tuvo error (true), salida contendrï¿½ el resultado, ya sea un conjunto de datos o un mensaje de confirmaciï¿½n
	var $salida;
	
	// Variable que contedrï¿½ la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecuciï¿½n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funciï¿½n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBUbicacion.php";
	
	// Matriz de parï¿½metros de validaciï¿½n de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarï¿½n o no
	var $decodificar = false;
	function __construct() {
		// Carga los parï¿½metro de validaciï¿½n de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	/**
	 * Nombre de la funciï¿½n:	ListarUbicacion
	 * Propï¿½sito:				Desplegar los registros de tal_almacen en funciï¿½n de los parï¿½metros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaciï¿½n:		
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
	function ListarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_sel';
		$this->codigo_procedimiento = "'AL_ALUB_SEL'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_ubicacion', 'integer');
		$this->var->add_def_cols('id_ubicacion_fk', 'integer');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('tipo_ubicacion', 'varchar');
		$this->var->add_def_cols('tickeado', 'boolean');
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ContarUbicacion
	 * Propï¿½sito:				Contar el total de registros desplegados en funciï¿½n de los parï¿½metros de filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaciï¿½n:		09-08-2013
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
	function ContarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_sel';
		$this->codigo_procedimiento = "'AL_ALUB_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;
		// Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	EliminarUbicacion
	 * Propï¿½sito:				Eliminar registros de la tabla tal_ubicacion mediante filtros
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaciï¿½n:		09-08-2013
	 */
	function EliminarUbicacionArb($id_ubicacion) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_iud';
		$this->codigo_procedimiento = "'AL_ALUB_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("$id_ubicacion"); // id de ubicacion
		$this->var->add_param("NULL"); // id de almacen
		$this->var->add_param("NULL"); // id de amacen_ubicacion_fk
		$this->var->add_param("NULL"); // codigo
		$this->var->add_param("NULL"); // nombre
		$this->var->add_param("NULL"); // estado
		                               // Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarUbicacionArb($id_ubicacion_fk, $id_almacen, $codigo, $nombre, $estado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_iud';
		$this->codigo_procedimiento = "'AL_ALUB_INS'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_ubicacion
		$this->var->add_param($id_ubicacion_fk);//al_id_ubicacion_fk
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param("'$codigo'");//al_codigo
		$this->var->add_param("'$nombre'");//al_nombre
		$this->var->add_param("'$estado'");//al_estado	
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ModificarUbicacionArb($id_ubicacion,$id_ubicacion_fk,$id_almacen, $codigo, $nombre, $estado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_iud';
		$this->codigo_procedimiento = "'AL_ALUB_UPD'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_ubicacion);
		$this->var->add_param($id_ubicacion_fk);
		$this->var->add_param($id_almacen);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$estado'");
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ValidarUbicacionArb($operacion_sql, $id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		// Ejecuta la validaciï¿½n por el tipo de operaciï¿½n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ubicacion");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion", $id_ubicacionion)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_ubicacion_fk - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ubicacion_fk");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion_fk", $id_ubicacion_fk)) {
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
			// Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ubicacion");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ubicacion", $id_ubicacion)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
}
?>
