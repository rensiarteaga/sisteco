<?php
/**
 * Nombre de la Clase:	cls_DBSalidaUnidadConstructivaDet
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_salida_uc_detalle
 * Autor:				UNKNOW
 * Fecha creación:		26-12-2014
 *
 */ 
class cls_DBSalidaUnidadConstructivaDet
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
	var $nombre_archivo = "cls_DBSalidaUnidadConstructivaDet.php";
	
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
	 * Nombre de la función:	ListarSalidaUCDet
	 * Propósito:				Desplegar los registros de tal_salida_uc_det en función de los parámetros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		26-12-2014
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
	function ListarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALUCDET_SEL'";
		
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
		$this->var->add_def_cols('id_salida_uc_detalle', 'integer');
		$this->var->add_def_cols('id_salida_uc', 'integer');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		$this->var->add_def_cols('desc_uc', 'text');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('usuario_reg', 'varchar');

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
	 * Nombre de la función:	ContarSalidaUCDet
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		26-12-2014
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
	function ContarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALUCDET_COUNT'";
		
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
		$this->var->add_def_cols('total','bigint');
		
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
	 * Nombre de la función:	EliminarSalidaUCDet
	 * Propósito:				Eliminar registros de la tabla tal_salida_uc_detalle  mediante filtros
	 * Autor:					UNKNOW
	 * Fecha de creación:		26-12-2014
	 */
	function EliminarSalidaUCDet($id_salida_uc_det) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALUCDET_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param($id_salida_uc_det);//al_id_salida_uc_detalle
		$this->var->add_param("NULL");//al_id_salida_uc
		$this->var->add_param("NULL");//al_id_unidad_constructiva
		$this->var->add_param("NULL");//al_cantidad
		 		                               
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function InsertarSalidaUCDet($id_salida_uc_det, $is_salida_uc, $id_uc, $cantidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_iud'; 
		$this->codigo_procedimiento = "'AL_SALUCDET_INS'";
	
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_salida_uc_detalle
		$this->var->add_param($is_salida_uc);//al_id_salida_uc
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
		$this->var->add_param($cantidad);//al_cantidad


		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
				
		return $res;
	}
	
	function ModificarSalidaUCDet($id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALUCDET_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
	
		$this->var->add_param($id_salida_uc_det);//al_id_salida_uc_detalle
		$this->var->add_param($id_salida_uc);//al_id_salida_uc
		$this->var->add_param($id_uc);//al_id_unidad_constructiva
		$this->var->add_param($cantidad);//al_cantidad	
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	function  ValidarSalidaUCDet($sql,$id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad)
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
				$tipo_dato->set_Columna("id_salida_uc_detalle");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_uc_detalle", $id_salida_uc_det)) 
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			// Validar id_almacen - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida_uc");
			$tipo_dato->set_MinLength(1);
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_uc", $is_salida_uc)) {
				$this->salida = $valid->salida;
				return false;
			}
	
			// Validar id_unidad_constructiva - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_constructiva");
			$tipo_dato->set_MinLength(1);
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva", $id_uc)) {
				$this->salida = $valid->salida;
				return false;
			}

			return true;
		} 
		elseif ($operacion_sql == 'delete') 
		{
			// Validar id_reclamo - tipo int8
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida_uc_detalle");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida_uc_detalle", $id_salida_uc_det)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			return true;
		} 
		else {
			return false;
		}
	}
	
	//se añadio las funcionalidades contar y listar de la tabla alma.tal_salida_uc_detalle_item
	
	function ContarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALUCDETITEM_COUNT'";
		
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
		$this->var->add_def_cols('total','bigint');
		
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
	function ListarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_SALUCDETITEM_SEL'";
		
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
		$this->var->add_def_cols('usuario_reg', 'varchar');
		$this->var->add_def_cols('fecha_reg', 'text');
		$this->var->add_def_cols('id_salida_uc_detalle_item', 'integer');
		$this->var->add_def_cols('id_salida_uc_detalle', 'integer');
		$this->var->add_def_cols('cant_sal_uc_detalle', 'numeric');
		$this->var->add_def_cols('cant_item_uc', 'numeric');
		$this->var->add_def_cols('demasia_almacen', 'numeric');
		$this->var->add_def_cols('cantidad_calculada', 'numeric');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('id_unidad_constructiva', 'integer');
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	function ModificarSalidaUCDetItem($id_salida_uc_det_item, $demasia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_SALUCDETITEM_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_salida_uc_det_item);//al_id_salida_uc_detalle
		$this->var->add_param("NULL");//al_id_salida_uc
		$this->var->add_param("NULL");//al_id_unidad_constructiva
		$this->var->add_param($demasia);//al_cantidad
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
}
?>
