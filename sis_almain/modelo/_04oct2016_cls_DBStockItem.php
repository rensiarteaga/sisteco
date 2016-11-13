<?php
/**
 * Nombre de la Clase:	cls_DBStockItem
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla tal_stock_item
 * Autor:				UNKNOW
 * Fecha creaciï¿½n:		30-05-2014
 *
 */
class cls_DBStockItem {
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
	var $nombre_archivo = "cls_DBStockItem.php";
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
	 * Nombre de la funciï¿½n:	ListarStockItem
	 * Propï¿½sito:				Desplegar los registros de tal_stock_item en funciï¿½n de los parï¿½metros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creaciï¿½n:		30-05-2014
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
	function ListarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_sel';
		$this->codigo_procedimiento = "'AL_STOCKITEM_SEL'";
		
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
		$this->var->add_def_cols('id_stock_item', 'integer');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('desc_almacen', 'text');
		$this->var->add_def_cols('minimo', 'numeric');
		$this->var->add_def_cols('maximo', 'numeric');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_unidad_medida_base', 'integer');
		$this->var->add_def_cols('nombre', 'varchar');
		
	//	$this->var->add_def_cols('id_ubicacion', 'integer');
	//	$this->var->add_def_cols('desc_ubicacion', 'text');
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ContarStockItem
	 * Propï¿½sito:				Contar el total de registros desplegados en funciï¿½n de los parï¿½metros de filtro
	 * Autor:					UNKNOW
	 * Fecha de creaciï¿½n:		30-05-2014
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
	function ContarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_sel';
		$this->codigo_procedimiento = "'AL_STOCKITEM_COUNT'";
		
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
	 * Nombre de la funciï¿½n:	EliminarStockItem
	 * Propï¿½sito:				Eliminar registros de la tabla tal_stock_item
	 * Autor:					UNKNOW
	 * Fecha de creaciï¿½n:		unknow
	 */
	function EliminarStockItem($hidden_id_stock_item) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_iud';
		$this->codigo_procedimiento = "'AL_STOCKITEM_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("$hidden_id_stock_item"); // id_stock_item
		$this->var->add_param("NULL"); // id_almacen
		$this->var->add_param("NULL"); // id_item
		$this->var->add_param("NULL"); // minimo
		$this->var->add_param("NULL"); // maximo
		$this->var->add_param("NULL"); // id_ubicacion

		                              
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		return $res;
	}
		
	function InsertarStockItem($id_almacen, $id_item, $stock_minimo, $stock_maximo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_iud';
		$this->codigo_procedimiento = "'AL_STOCKITEM_INS'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL"); 
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_item);
		$this->var->add_param($stock_minimo);
		$this->var->add_param($stock_maximo);
	
		//$this->var->add_param($id_ubicacion);
		 
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarStockItem($id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo,$id_ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_iud';
		$this->codigo_procedimiento = "'AL_STOCKITEM_UPD'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_stock_item);
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_item);
		$this->var->add_param($stock_minimo);
		$this->var->add_param($stock_maximo);
		
		$this->var->add_param($id_ubicacion);
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ValidarStockItem($operacion_sql, $id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo){
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		// Ejecuta la validaciï¿½n por el tipo de operaciï¿½n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_stock_item - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_stock_item");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_stock_item", $id_stock_item)) {
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
			// Validar id_item - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar stock_minimo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("minimo");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoReal(), "minimo", $stock_minimo)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar stock_maxmimo - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("maximo");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoReal(), "maximo", $stock_maximo)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
			
		} elseif ($operacion_sql == 'delete') {
			// Validar id_item - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_stock_item");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_stock_item", $id_stock_item)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}

	function UpdateUbicationItemStock($id_stock_item,$id_ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_stock_item_iud';
		$this->codigo_procedimiento = "'AL_UBICACIONSTOCK_UPD'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_stock_item);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param($id_ubicacion);
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}
?>
