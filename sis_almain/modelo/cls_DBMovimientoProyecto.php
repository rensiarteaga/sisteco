<?php
/**
 * Nombre de la Clase:	cls_DBMovimientoProyecto
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tal_movimiento_proyecto
 * Autor:				UNKNOW
 * Fecha creación:		23-10-2014
 *
 */
class cls_DBMovimientoProyecto {
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
	var $nombre_archivo = "cls_DBMovimientoProyecto.php";
	
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
	 * Nombre de la función:	ListarMovimientoProyecto
	 * Propósito:				Desplegar los registros de tal_movimiento_proyecto en función de los parámetros del filtro
	 * Autor:					UNKNOW
	 * Fecha de creación:		23-10-2014
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
	function ListarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_sel';
		$this->codigo_procedimiento = "'AL_MOVPROY_SEL'";
		
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
	
		$this->var->add_def_cols('id_movimiento_proyecto','integer');
		$this->var->add_def_cols('id_almacen','integer');
		$this->var->add_def_cols('desc_almacen','text');
	 	$this->var->add_def_cols('id_tipo_movimiento','integer');
	 	$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('id_documento','integer'); 
		$this->var->add_def_cols('id_contratista','integer');
		$this->var->add_def_cols('desc_contratista','text');
		$this->var->add_def_cols('id_proveedor','integer');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('id_institucion','integer');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('fecha_ingreso','text');
		$this->var->add_def_cols('origen_ingreso','varchar');
		$this->var->add_def_cols('concepto_ingreso','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','text'); 
		$this->var->add_def_cols('nro_contrato','varchar'); 
		$this->var->add_def_cols('nota_remision','varchar');
		$this->var->add_def_cols('entregado_por','varchar');
		//añadido 12-05-2015
		$this->var->add_def_cols('peso_neto','numeric');
		$this->var->add_def_cols('codigo','varchar');
		
		
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
	 * Nombre de la función:	ContarMovimientopROYECTO
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					unknow
	 * Fecha de creación:		23-10-2014
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
	function ContarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_sel';
		$this->codigo_procedimiento = "'AL_MOVPROY_COUNT'";
		 
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
	function EliminarMovimientoProyecto($id_movimiento_proyecto) 
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_iud';
		$this->codigo_procedimiento = "'AL_MOVPROY_DEL'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_movimiento_proyecto");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_almacen
		$this->var->add_param("NULL");//al_id_tipo_movimiento
		$this->var->add_param("NULL");//al_fecha_ingreso
		$this->var->add_param("NULL");//al_origen_ingreso
		$this->var->add_param("NULL");//al_id_contratista
		$this->var->add_param("NULL");//al_id_proveedor
		$this->var->add_param("NULL");//al_id_empleado
		$this->var->add_param("NULL");//al_id_institucion
		$this->var->add_param("NULL");//al_concepto_ingreso
		$this->var->add_param("NULL");//al_observaciones
		//añadido 07-01-2015 
		$this->var->add_param("NULL");//al_entregado
		$this->var->add_param("NULL");//al_nota_remision
		$this->var->add_param("NULL");//al_nro_contrato
		//añadido 12-05-2015
		$this->var->add_param("NULL");//al_peso_neto
		                               
		// Ejecuta la función 
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function InsertarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato,$peso_neto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_iud';
		$this->codigo_procedimiento = "'AL_MOVPROY_INS'";
		 
		$origen_ingreso=strtolower($origen_ingreso);
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		$this->var->add_param("NULL");//al_id_movimiento_proyecto
		$this->var->add_param($almacen);//al_id_almacen
		$this->var->add_param($tipo_mov);//al_id_tipo_movimiento
		$this->var->add_param("'$fecha_ingreso'");//al_fecha_ingreso
		$this->var->add_param("'$origen_ingreso'");//al_origen_ingreso
		$this->var->add_param("$contratista");//al_id_contratista
		$this->var->add_param("$proveedor");//al_id_proveedor
		$this->var->add_param("$empleado");//al_id_empleado
		$this->var->add_param("$institucion");//al_id_institucion
		$this->var->add_param("'$concepto_ingreso'");//al_concepto_ingreso
		$this->var->add_param("'$observaciones'");//al_observaciones
		//añadido 07-01-2015
		$this->var->add_param("'$entregado_por'");//al_entregado
		$this->var->add_param("'$nota_remision'");//al_nota_remision
		$this->var->add_param("'$nro_contrato'");//al_nro_contrato
		//añadido 12-05-2015
		$this->var->add_param("$peso_neto");//al_peso_neto
	
		
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	function ModificarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_iud';
		$this->codigo_procedimiento = "'AL_MOVPROY_UPD'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		$this->var->add_param($id_movimiento_proyecto);//al_id_movimiento_proyecto
		$this->var->add_param($almacen);//al_id_almacen
		$this->var->add_param($tipo_mov);//al_id_tipo_movimiento
		$this->var->add_param("'$fecha_ingreso'");//al_fecha_ingreso
		$this->var->add_param("'$origen_ingreso'");//al_origen_ingreso
		$this->var->add_param("$contratista");//al_id_contratista
		$this->var->add_param("$proveedor");//al_id_proveedor
		$this->var->add_param("$empleado");//al_id_empleado
		$this->var->add_param("$institucion");//al_id_institucion
		$this->var->add_param("'$concepto_ingreso'");//al_concepto_ingreso
		$this->var->add_param("'$observaciones'");//al_observaciones
		//añadido 07-01-2015
		$this->var->add_param("'$entregado_por'");//al_entregado
		$this->var->add_param("'$nota_remision'");//al_nota_remision
		$this->var->add_param("'$nro_contrato'");//al_nro_contrato
		//añadido 12-05-2015
		$this->var->add_param("$peso_neto");//al_peso_neto
		
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
			$tipo_dato->set_MaxLength(255);
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
	
	function FinalizarMovimientoProyecto($id_movimiento_proy)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_iud';
		$this->codigo_procedimiento = "'AL_MOVPROY_FIN'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);
		
		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_movimiento_proy");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_almacen
		$this->var->add_param("NULL");//al_id_tipo_movimiento
		$this->var->add_param("NULL");//al_fecha_ingreso
		$this->var->add_param("NULL");//al_origen_ingreso
		$this->var->add_param("NULL");//al_id_contratista
		$this->var->add_param("NULL");//al_id_proveedor
		$this->var->add_param("NULL");//al_id_empleado
		$this->var->add_param("NULL");//al_id_institucion
		$this->var->add_param("NULL");//al_concepto_ingreso
		$this->var->add_param("NULL");//al_observaciones
		//añadido 07-01-2015
		$this->var->add_param("NULL");//al_entregado
		$this->var->add_param("NULL");//al_nota_remision
		$this->var->add_param("NULL");//al_nro_contrato
		//añadido 12-05-2015
		$this->var->add_param("NULL");//al_peso_neto
		 
		// Ejecuta la función
		$res = $this->var->exec_non_query();
		// Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		// Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	function CorregirMovimientoProyectoIngreso($id_movimiento_proyecto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tai_movimiento_proyecto_iud';
		$this->codigo_procedimiento = "'AL_MOVPROY_CORREG'";
		
		// Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar);

		// Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("$id_movimiento_proyecto");//al_id_movimiento_proyecto
		$this->var->add_param("NULL");//al_id_almacen
		$this->var->add_param("NULL");//al_id_tipo_movimiento
		$this->var->add_param("NULL");//al_fecha_ingreso
		$this->var->add_param("NULL");//al_origen_ingreso
		$this->var->add_param("NULL");//al_id_contratista
		$this->var->add_param("NULL");//al_id_proveedor
		$this->var->add_param("NULL");//al_id_empleado
		$this->var->add_param("NULL");//al_id_institucion
		$this->var->add_param("NULL");//al_concepto_ingreso
		$this->var->add_param("NULL");//al_observaciones
		//añadido 07-01-2015
		$this->var->add_param("NULL");//al_entregado
		$this->var->add_param("NULL");//al_nota_remision
		$this->var->add_param("NULL");//al_nro_contrato
		//añadido 12-05-2015
		$this->var->add_param("NULL");//al_peso_neto
			
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
