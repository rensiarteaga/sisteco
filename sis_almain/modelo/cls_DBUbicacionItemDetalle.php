<?php
/**
 * Nombre de la Clase:	cls_DBUbicacion
 * Propï¿½sito:			Permite ejecutar la funcionalidad de la tabla tal_ubicacion
 * Autor:				Ruddy Lujan Bravo
 * Fecha creaciï¿½n:		09-08-2013
 *
 */
class cls_DBUbicacionItemDetalle
 {
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
	var $nombre_archivo = "cls_DBUbicacionItemDetalle.php";
	
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
	function ListarUbicacionItemRaices($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_sel';
		$this->codigo_procedimiento = "'AL_ALUBITEM_RAIZ_SEL'";
		
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
		
		$this->var->add_param($id_alma); // id_almacen
		$this->var->add_param("NULL"); // id_nodo
		$this->var->add_param($id_item); // id_item
		
		                                                                              
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
		$this->var->add_def_cols('checked', 'boolean');
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	function ListarUbicacionItemRamaNodo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$raiz,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_sel';
		$this->codigo_procedimiento = "'AL_ALUBITEM_RAMNOD_SEL'";
		
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
		
		$this->var->add_param($id_alma); // id_almacen
		$this->var->add_param($raiz); // id_nodo
		$this->var->add_param($id_item); // id_item
		
		
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
		$this->var->add_def_cols('checked', 'boolean');
		
		// Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		// echo $this->query;exit;
		return $res;
	}

	
	function InsertarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
		$this->codigo_procedimiento = "'AL_UBITEM_RAIZ_INS'"; 
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
		$this->var->add_param($id_ubicacion);//al_id_ubicacion
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param("NULL");//al_orden
		$this->var->add_param("NULL");//al_saldo_item_ubicacion
		$this->var->add_param("NULL");//al_cant_max_ingreso
		$this->var->add_param("NULL");//al_cant_max_salida
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
 	}
 	
 	function InsertarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen)
 	{
 		$this->salida = "";
 		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
 		$this->codigo_procedimiento = "'AL_UBITEM_RAMA_INS'";
 		
 		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
 		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
 		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
 		$this->var->add_param($id_ubicacion);//al_id_ubicacion
 		$this->var->add_param($id_almacen);//al_id_almacen
 		$this->var->add_param($id_item);//al_id_item
 		$this->var->add_param("NULL");//al_orden
 		$this->var->add_param("NULL");//al_saldo_item_ubicacion
 		$this->var->add_param("NULL");//al_cant_max_ingreso
 		$this->var->add_param("NULL");//al_cant_max_salida
 		
 		// Ejecuta la funciï¿½n
 		$res = $this->var->exec_non_query();
 		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
 		$this->salida = $this->var->salida;
 		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
 		$this->query = $this->var->query;
 		//echo $this->query;exit;
 		return $res;
 	}
	
 	function InsertarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen)
 	{
 		$this->salida = "";
 		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
 		$this->codigo_procedimiento = "'AL_UBITEM_NODO_INS'";
 	
 		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
 		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar); 
 		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
 		$this->var->add_param($id_ubicacion);//al_id_ubicacion
 		$this->var->add_param($id_almacen);//al_id_almacen
 		$this->var->add_param($id_item);//al_id_item
 		$this->var->add_param("NULL");//al_orden
 		$this->var->add_param("NULL");//al_saldo_item_ubicacion
 		$this->var->add_param("NULL");//al_cant_max_ingreso
 		$this->var->add_param("NULL");//al_cant_max_salida
 	
 		// Ejecuta la funciï¿½n
 		$res = $this->var->exec_non_query();
 		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
 		$this->salida = $this->var->salida;
 		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
 		$this->query = $this->var->query;
 		//echo $this->query;exit;
 		return $res;
 	}
 	
 	
	function EliminarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
		$this->codigo_procedimiento = "'AL_UBITRAIZ_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
 		$this->var->add_param($id_ubicacion);//al_id_ubicacion
 		$this->var->add_param($id_almacen);//al_id_almacen
 		$this->var->add_param($id_item);//al_id_item
 		$this->var->add_param("NULL");//al_orden
 		$this->var->add_param("NULL");//al_saldo_item_ubicacion
 		$this->var->add_param("NULL");//al_cant_max_ingreso
 		$this->var->add_param("NULL");//al_cant_max_salida
 		
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
		
	function EliminarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
		$this->codigo_procedimiento = "'AL_UBITNODO_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
		$this->var->add_param($id_ubicacion);//al_id_ubicacion
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param("NULL");//al_orden
		$this->var->add_param("NULL");//al_saldo_item_ubicacion
		$this->var->add_param("NULL");//al_cant_max_ingreso
		$this->var->add_param("NULL");//al_cant_max_salida
			
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	function EliminarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_iud'; 
		$this->codigo_procedimiento = "'AL_UBITRAMA_DEL'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parï¿½metros especï¿½ficos (no incluyen los parï¿½metros fijos)
		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
		$this->var->add_param($id_ubicacion);//al_id_ubicacion
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param("NULL");//al_orden
		$this->var->add_param("NULL");//al_saldo_item_ubicacion
		$this->var->add_param("NULL");//al_cant_max_ingreso
		$this->var->add_param("NULL");//al_cant_max_salida
			
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	
	function InsertarUbicacionItemRaizRama($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_detalle_iud';
		$this->codigo_procedimiento = "'AL_UBITEMDET_RR_INS'";
		
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_ubicacion_item_detalle
		$this->var->add_param($id_ubicacion);//al_id_ubicacion
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param("NULL");//al_orden
		$this->var->add_param("NULL");//al_saldo_item_ubicacion
		$this->var->add_param("NULL");//al_cant_max_ingreso
		$this->var->add_param("NULL");//al_cant_max_salida
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	
	function ContarOrdenUbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_sel';
		$this->codigo_procedimiento = "'AL_ORDUBIC_COUNT'";
		
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
		
		$this->var->add_param("NULL"); // id_almacen
		$this->var->add_param("NULL"); // id_nodo
		$this->var->add_param("NULL"); // id_item
		
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
	
	function ListarOrdenbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_sel';
		$this->codigo_procedimiento = "'AL_ORDUBIC_SEL'";
		
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
		
		$this->var->add_param("NULL"); // id_almacen
		$this->var->add_param("NULL"); // id_nodo
		$this->var->add_param("NULL"); // id_item
		
		// Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_ubicacion_item_detalle', 'integer');
		$this->var->add_def_cols('id_ubicacion', 'integer');
		$this->var->add_def_cols('orden', 'integer');
		$this->var->add_def_cols('codigo', 'varchar');
		$this->var->add_def_cols('nombre', 'varchar');

		$this->var->add_def_cols('id_almacen', 'integer');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		
		$this->var->add_def_cols('saldo_item_ubicacion', 'numeric');
		$this->var->add_def_cols('cant_max_ing', 'numeric');
		$this->var->add_def_cols('cant_max_sal', 'numeric');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		 //echo $this->query;exit;
		return $res;
	}
	
	
	function EditarOrdenUbicacion($id_ubicacion_item,$id_almacen,$id_item,$maxing,$maxsal,$orden_actual,$orden_anterior)
	{
	
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_ubicacion_item_iud';
		$this->codigo_procedimiento = "'AL_UBITEM_ORDEN_UPD'"; 
		
	
		// Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param($id_ubicacion_item);//al_id_ubicacion_item_detalle
		$this->var->add_param($orden_anterior);//al_id_ubicacion (ORDEN_ANTERIOR)
		$this->var->add_param($id_almacen);//al_id_almacen
		$this->var->add_param($id_item);//al_id_item
		$this->var->add_param($orden_actual);//al_orden
		$this->var->add_param("NULL");//al_saldo_item_ubicacion
		$this->var->add_param($maxing);//al_cant_max_ingreso
		$this->var->add_param($maxsal);//al_cant_max_salida
		
		// Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	} 

}
?>
