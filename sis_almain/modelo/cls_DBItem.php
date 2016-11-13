<?php
/**
 * Nombre de la Clase:	cls_DBItem
 * Prop�sito:			Permite ejecutar la funcionalidad de la tabla tal_item
 * Autor:				Ruddy Lujan Bravo
 * Fecha creaci�n:		28-08-2013
 *
 */
class cls_DBItem {
	// Variable que contiene la salida de la ejecuci�n de la funci�n
	// si la funci�n tuvo error (false), salida contendr� el mensaje de error
	// si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida;
	
	// Variable que contedr� la cadena de llamada a las funciones postgres
	var $query;
	
	// Variables para la ejecuci�n de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la funci�n a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBItem.php";
	// Matriz de par�metros de validaci�n de todas las columnas
	var $matriz_validacion = array ();
	// Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;
	function __construct() {
		// Carga los par�metro de validaci�n de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la funci�n:	ListarItem
	 * Prop�sito:				Desplegar los registros de tal_item en funci�n de los par�metros del filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		27-08-2013
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
	function ListarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
	
		//cambio de codigo_procedimiento si filtro_item -> solicitud de salida
		if($id_financiador < 0 || $id_financiador == -1)
		{
			$this->codigo_procedimiento = "'AL_ITEMSOLIC_SEL'";
			$id_financiador = null;
		}
		else {
			$this->codigo_procedimiento = "'AL_ITEMAI_SEL'";
		}
		$func = new cls_funciones(); // Instancia de las funciones generales
		                            
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", "'$id_actividad'")); // id_actividad
		                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('id_unidad_medida', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('codigo_fabrica', 'varchar');
		$this->var->add_def_cols('num_por_clasificacion', 'integer');
		$this->var->add_def_cols('bajo_responsabilidad', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('metodo_valoracion', 'varchar');
		$this->var->add_def_cols('nombre_clasificacion', 'varchar');
		$this->var->add_def_cols('nombre_medida', 'varchar');
		$this->var->add_def_cols('cantidad', 'numeric');
		
		$this->var->add_def_cols('peso', 'numeric');
		$this->var->add_def_cols('calidad', 'varchar');
		$this->var->add_def_cols('orden', 'integer');

		$this->var->add_def_cols('reservados', 'numeric');
		
		$this->var->add_def_cols('id_tipo_material', 'integer');
		$this->var->add_def_cols('desc_tipo_material', 'text');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	/**
	 * Nombre de la funci�n:	ContarItem
	 * Prop�sito:				Contar el total de registros desplegados en funci�n de los par�metros de filtro
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		25-07-2013
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
	function ContarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
		
		//cambio de codigo_procedimiento si filtro_item -> solicitud de salida
		if($id_financiador < 0 || $id_financiador == -1)
		{
			$this->codigo_procedimiento = "'AL_ITEMSOLIC_COUNT'";
			$id_financiador = null;
		}
		else 
		{	$this->codigo_procedimiento = "'AL_ITEMAI_COUNT'";}
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", "'$id_actividad'")); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	/**
	 * Nombre de la funci�n:	EliminarItem
	 * Prop�sito:				Eliminar registros de la tabla tal_item mediante filtros
	 * Autor:					Ruddy Lujan Bravo
	 * Fecha de creaci�n:		27-08-2013
	 */
	function EliminarItem($id_item) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_iud';
		$this->codigo_procedimiento = "'AL_ITEMAI_DEL'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		// Carga par�metros espec�ficos (no incluyen los par�metros fijos)
		$this->var->add_param("$id_item"); // id de almacen
		$this->var->add_param("NULL"); // id de clasificacion
		$this->var->add_param("NULL"); // id de unidad medida
		$this->var->add_param("NULL"); // nombre
		$this->var->add_param("NULL"); // descripcion
		$this->var->add_param("NULL"); // codigo fabrica
		$this->var->add_param("NULL"); // bajo responsabilidad
		$this->var->add_param("NULL"); // estado 
		$this->var->add_param("NULL"); // metodo_valoracion
		
		$this->var->add_param("NULL"); // al_peso
		$this->var->add_param("NULL"); // al_calidad
		                              
		                               // Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarItem($id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_iud';
		$this->codigo_procedimiento = "'AL_ITEMAI_INS'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_clasificacion);
		$this->var->add_param($id_unidad_medida);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$codigo_fabrica'");
		$this->var->add_param("'$bajo_responsabilidad'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$metodo_valoracion'");
		
		$this->var->add_param($peso);//al_peso
		$this->var->add_param("'$calidad'");//al_calidad
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function ModificarItem($id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_iud';
		$this->codigo_procedimiento = "'AL_ITEMAI_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_item);
		$this->var->add_param($id_clasificacion);
		$this->var->add_param($id_unidad_medida);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$codigo_fabrica'");
		$this->var->add_param("'$bajo_responsabilidad'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$metodo_valoracion'");
		
		$this->var->add_param($peso);
		$this->var->add_param("'$calidad'");
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/*
	 * Contar y Listar los items registrados en una unidad constructiva de acuerdo a id_clasificacion
	 *  
	 * */
	function ContarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
		$this->codigo_procedimiento = "'AL_ITEMUC_COUNT'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		                             
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		                                                                              
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	function ListarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
		$this->codigo_procedimiento = "'AL_ITEMUC_SEL'";
		
		$func = new cls_funciones(); // Instancia de las funciones generales
		 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
				
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'",$id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'","'$id_regional'")); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('id_clasificacion', 'integer');
		$this->var->add_def_cols('id_unidad_medida', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');
		$this->var->add_def_cols('descripcion', 'varchar');
		$this->var->add_def_cols('codigo_fabrica', 'varchar');
		$this->var->add_def_cols('num_por_clasificacion', 'integer');
		$this->var->add_def_cols('bajo_responsabilidad', 'varchar');
		$this->var->add_def_cols('estado', 'varchar');
		$this->var->add_def_cols('metodo_valoracion', 'varchar');
		$this->var->add_def_cols('nombre_clasificacion', 'varchar');
		$this->var->add_def_cols('nombre_medida', 'varchar');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('peso', 'numeric');
		$this->var->add_def_cols('calidad', 'varchar');
		$this->var->add_def_cols('orden', 'integer');
		$this->var->add_def_cols('seleccionado', 'integer');
		$this->var->add_def_cols('cantidad_ituc', 'numeric');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	function ValidarItem($operacion_sql, $id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		// Ejecuta la validaci�n por el tipo de operaci�n
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				// Validar id_persona - tipo int8
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_item");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_clasificacion - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clasificacion");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clasificacion", $id_clasificacion)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar id_unidad_medida - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_medida");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_medida", $id_unidad_medida)) {
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
			// Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar codigo_fabrica - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_fabrica");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_fabrica", $codigo_fabrica)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			// Validar bajo_responsabilidad - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("bajo_responsabilidad");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "bajo_responsabilidad", $bajo_responsabilidad)) {
				$this->salida = $valid->salida;
				return false;
			}*/
			// Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(true);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado)) {
				$this->salida = $valid->salida;
				return false;
			}
			// Validar metodo_valoracion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("metodo_valoracion");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "metodo_valoracion", $metodo_valoracion)) {
				$this->salida = $valid->salida;
				return false;
			}
			return true;
		} elseif ($operacion_sql == 'delete') {
			// Validar id_item - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} else {
			return false;
		}
	}
	
	function ContarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
				
		$this->codigo_procedimiento = "'AL_ITVALORIZ_COUNT'";
			
		$func = new cls_funciones(); // Instancia de las funciones generales
		 
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total', 'bigint');
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;
		// Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida[0][0];
		}
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		// Retorna el resultado de la ejecuci�n
		return $res;
	}
	function ListarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_sel';
		
		//cambio de codigo_procedimiento si filtro_item -> solicitud de salida
		$this->codigo_procedimiento = "'AL_ITVALORIZ_SEL'";
		$func = new cls_funciones(); // Instancia de las funciones generales
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento);
		
		// Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		// Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '', "'%'", $id_financiador)); // id_financiador
		$this->var->add_param($func->iif($id_regional == '', "'%'", $id_regional)); // id_regional
		$this->var->add_param($func->iif($id_programa == '', "'%'", $id_programa)); // id_programa
		$this->var->add_param($func->iif($id_proyecto == '', "'%'", $id_proyecto)); // id_proyecto
		$this->var->add_param($func->iif($id_actividad == '', "'%'", $id_actividad)); // id_actividad
		
		// Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item_valoracion', 'integer');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('unidad_medida', 'varchar');
		$this->var->add_def_cols('nombre_item', 'varchar');
		$this->var->add_def_cols('desc_item', 'text');
		
		// Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	function AgregarModificarTipoMaterial($id_item,$id_tipo_material)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_iud';
		$this->codigo_procedimiento = "'AL_ITEMTIPMAT_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_item);
		$this->var->add_param($id_tipo_material);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function AgregarRegistroTipoMaterial($id_tipo_material)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_item_iud';
		$this->codigo_procedimiento = "'AL_ITEMTIPMATINS_UPD'";
		
		// Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_tipo_material);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		// Ejecuta la funci�n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		return $res;
	}
}
?>
