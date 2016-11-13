<?php
/**
 * Nombre de la Clase:	cls_DBDetalleMovimiento.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_detalle_movimiento
 * Autor:				Ruddy Limbert Lujan Bravo
 * Fecha creación:		09-09-2013
 *
 */
class cls_DBDetalleMovimiento {
	var $salida;
	var $query;
	// Variables para la ejecución de funciones
	var $var; // middle_client
	var $nombre_funcion; // nombre de la función a ejecutar
	var $codigo_procedimiento; // codigo del procedimiento a ejecutar
	                           
	// Nombre del archivo
	var $nombre_archivo = "cls_DBDetalleMovimiento.php";
	
	// Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array ();
	
	// Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	function __construct() {
		// Carga los parámetro de validación de todas las columnas
		// Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}
	function ListarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_detalle_movimiento_sel';
		$this->codigo_procedimiento = "'AL_DETMOV_SEL'";
		
		$func = new cls_funciones();
		
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
		$this->var->add_def_cols('id_detalle_movimiento', 'integer');
		$this->var->add_def_cols('id_movimiento', 'integer');
		$this->var->add_def_cols('id_item', 'integer');
		$this->var->add_def_cols('cantidad', 'numeric');
		$this->var->add_def_cols('cantidad_solicitada', 'numeric');
		$this->var->add_def_cols('tipo_saldo', 'varchar');
		$this->var->add_def_cols('codigo_movimiento', 'varchar');
		$this->var->add_def_cols('nombre_item', 'varchar');
		$this->var->add_def_cols('desc_item', 'text');
		$this->var->add_def_cols('id_unidad_medida_base', 'integer');
		$this->var->add_def_cols('nombre_medida', 'varchar');
		$this->var->add_def_cols('costo_unitario', 'numeric');
		$this->var->add_def_cols('costo_valorado', 'numeric');
		$this->var->add_def_cols('costo_total', 'numeric');
		 
		
		// Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	function ContarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_detalle_movimiento_sel';
		$this->codigo_procedimiento = "'AL_DETMOV_COUNT'";
		
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
	function InsertarDetalleMovimiento($id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_detalle_movimiento_iud';
		$this->codigo_procedimiento = "'AL_DETMOV_INS'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param("NULL");
		$this->var->add_param($id_movimiento);
		$this->var->add_param($id_item);
		$this->var->add_param("'$cantidad'");
		$this->var->add_param("'$cantidad_solicitada'");
		$this->var->add_param("'$tipo_saldo'");
		$this->var->add_param("'$costo_unitario'");
		$this->var->add_param("'$costo_total'");
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarDetalleMovimiento($id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_detalle_movimiento_iud';
		$this->codigo_procedimiento = "'AL_DETMOV_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_detalle_movimiento);
		$this->var->add_param($id_movimiento);
		$this->var->add_param($id_item);
		$this->var->add_param("'$cantidad'");
		$this->var->add_param("'$cantidad_solicitada'");
		$this->var->add_param("'$tipo_saldo'");
		$this->var->add_param("'$costo_unitario'");
		$this->var->add_param("'$costo_total'");
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function EliminarDetalleMovimiento($id_detalle_movimiento) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_detalle_movimiento_iud';
		$this->codigo_procedimiento = "'AL_DETMOV_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_detalle_movimiento");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ValidarDetalleMovimiento($operacion_sql, $id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo) {
		$this->salida = "";
		$valid = new cls_validacion_serv();
		
		// Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
		
		// Ejecuta la validación por el tipo de operación
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_detalle_movimiento");
				
				if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_detalle_movimiento", $id_detalle_movimiento)) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_movimiento");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_movimiento", $id_movimiento)) {
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "cantidad", $cantidad)) {
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad_solicitada");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "cantidad_solicitada", $cantidad_solicitada)) {
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_saldo");
			$tipo_dato->set_MaxLength(15);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_saldo", $tipo_saldo)) {
				$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MinLength(2);
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item)) {
				$this->salida = $valid->salida;
				return false;
			}
			// validación exitosa
			return true;
		} elseif ($operacion_sql == 'delete') {
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_detalle_movimiento");
			
			if (! $valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_detalle_movimiento", $id_detalle_movimiento)) {
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
