<?php
/**
 * Nombre de la clase:	cls_DBDevengado.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_devengado
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-21 15:43:26
 */

class cls_DBDevengado {
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct() {
		$this->decodificar = $decodificar;
	}
	
	/**
	 * Nombre de la función:	ListarDevengarServicios
	 * Propósito:				Desplegar los registros de tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ListarDevengarServicios($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSER_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'id_devengado', 'int4' );
		$this->var->add_def_cols ( 'id_concepto_ingas', 'int4' );
		$this->var->add_def_cols ( 'id_moneda', 'int4' );
		$this->var->add_def_cols ( 'importe_devengado', 'numeric' );
		$this->var->add_def_cols ( 'importe_pagado', 'numeric' );
		$this->var->add_def_cols ( 'importe_saldo', 'numeric' );
		$this->var->add_def_cols ( 'estado_devengado', 'numeric' );
		$this->var->add_def_cols ( 'fk_devengado', 'int4' );
		$this->var->add_def_cols ( 'id_proveedor', 'int4' );
		$this->var->add_def_cols ( 'id_cheque', 'int4' );
		$this->var->add_def_cols ( 'id_comprobante', 'int4' );
		$this->var->add_def_cols ( 'tipo_devengado', 'numeric' );
		$this->var->add_def_cols ( 'fecha_devengado', 'date' );
		$this->var->add_def_cols ( 'desc_concepto_ingas', 'text' );
		$this->var->add_def_cols ( 'desc_moneda', 'varchar' );
		$this->var->add_def_cols ( 'desc_proveedor', 'text' );
		$this->var->add_def_cols ( 'desc_tipo_devengado', 'text' );
		$this->var->add_def_cols ( 'desc_estado_devengado', 'text' );
		$this->var->add_def_cols ( 'tot_importe_det', 'numeric' );
		$this->var->add_def_cols ( 'tot_porcentaje_det', 'numeric' );
		$this->var->add_def_cols ( 'nombre_pago', 'varchar' );
		$this->var->add_def_cols ( 'nro_cheque', 'integer' );
		$this->var->add_def_cols ( 'fecha_cheque', 'text' );
		$this->var->add_def_cols ( 'nombre_cheque', 'varchar' );
		$this->var->add_def_cols ( 'estado_cheque', 'numeric' );
		$this->var->add_def_cols ( 'desc_estado_cheque', 'text' );
		$this->var->add_def_cols ( 'importe_multa', 'numeric' );
		$this->var->add_def_cols ( 'id_plan_pago', 'integer' );
		$this->var->add_def_cols ( 'id_cotizacion', 'integer' );
		$this->var->add_def_cols ( 'nivel_documento', 'varchar' );
		$this->var->add_def_cols ( 'banco', 'varchar' );
		$this->var->add_def_cols ( 'observaciones', 'varchar' );
		$this->var->add_def_cols ( 'id_depto', 'integer' );
		$this->var->add_def_cols ( 'nombre_depto', 'varchar' );
		$this->var->add_def_cols ( 'id_empleado', 'integer' );
		$this->var->add_def_cols ( 'desc_empleado', 'text' );
		$this->var->add_def_cols ( 'partida', 'text' );
		$this->var->add_def_cols ( 'nit', 'varchar' );
		$this->var->add_def_cols ( 'fecha_reg', 'date' );
		$this->var->add_def_cols ( 'id_periodo_subsistema', 'integer' );
		$this->var->add_def_cols ( 'tipo_gen_pago', 'numeric' );
		$this->var->add_def_cols ( 'desc_tipo_gen_pago', 'text' );
		$this->var->add_def_cols ( 'obs_contabilidad', 'text' );
		$this->var->add_def_cols ( 'tipo_desembolso', 'numeric' );
		$this->var->add_def_cols ( 'id_cajero', 'integer' );
		$this->var->add_def_cols ( 'cajero', 'text' );
		$this->var->add_def_cols ( 'id_caja', 'integer' );
		$this->var->add_def_cols ( 'desc_caja', 'text' );
		$this->var->add_def_cols ( 'id_emp_recep_caja', 'integer' );
		$this->var->add_def_cols ( 'desc_emp_recep_caja', 'text' );
		$this->var->add_def_cols ( 'id_moneda_cueban', 'integer' );
		$this->var->add_def_cols ( 'desc_periodo_subsistema', 'varchar' );
		$this->var->add_def_cols ( 'tipo_plantilla', 'numeric' );
		$this->var->add_def_cols ( 'desc_tipo_plantilla', 'varchar' );
		$this->var->add_def_cols ( 'tipo_pago', 'varchar' );
		$this->var->add_def_cols ( 'id_cuenta_bancaria', 'integer' );
		$this->var->add_def_cols ( 'liquido_pagable', 'numeric' );
		$this->var->add_def_cols ( 'sw_pago_comprometido', 'varchar' );
		$this->var->add_def_cols ( 'sw_solo_devengado', 'varchar' );
		$this->var->add_def_cols ( 'id_comprobante_reg', 'int4' );
		$this->var->add_def_cols ( 'importe_otros_con', 'numeric' );
		$this->var->add_def_cols ( 'importe_total', 'numeric' );
		$this->var->add_def_cols ( 'correl', 'text' );
		$this->var->add_def_cols ( 'id_planilla', 'integer' );
		$this->var->add_def_cols ( 'id_parametro', 'integer' );
		$this->var->add_def_cols ( 'gestion_pres','numeric');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDevengarServicios
	 * Propósito:				Contar los registros de tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ContarDevengarServicios($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSER_COUNT'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'total', 'bigint' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida [0] [0];
		}
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarDevengarServicios
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function InsertarDevengarServicios($id_devengado, $id_concepto_ingas, $id_moneda, $importe_devengado, $estado_devengado, $id_proveedor, $tipo_devengado, $observaciones, $id_depto, $fecha_devengado, $tipo_desembolso, $id_cajero, $id_emp_recep_caja, $id_periodo_subsistema,$tipo_plantilla,$tipo_pago,$id_caja) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $id_concepto_ingas );
		$this->var->add_param ( $id_moneda );
		$this->var->add_param ( $importe_devengado );
		$this->var->add_param ( $estado_devengado );
		$this->var->add_param ( $id_proveedor );
		$this->var->add_param ( $tipo_devengado );
		$this->var->add_param ( $importe_pagado );
		$this->var->add_param ( $importe_saldo );
		$this->var->add_param ( $fk_devengado );//10
		$this->var->add_param ( $id_cheque );
		$this->var->add_param ( $id_documento );
		$this->var->add_param ( $id_comprobante );
		$this->var->add_param ( "'$fecha_devengado'" );
		$this->var->add_param ( $importe_multa );
		$this->var->add_param ( "'$observaciones'" );
		$this->var->add_param ( $id_depto );
		$this->var->add_param ( $tipo_desembolso );
		$this->var->add_param ( $id_cajero );
		$this->var->add_param ( $id_emp_recep_caja );//20
		$this->var->add_param ( $id_periodo_subsistema );
		$this->var->add_param ( $tipo_plantilla );//22
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "'$tipo_pago'" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$id_caja" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarDevengarServicios
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ModificarDevengarServicios($id_devengado, $id_concepto_ingas, $id_moneda, $importe_devengado, $estado_devengado, $id_proveedor, $tipo_devengado, $observaciones, $id_depto, $fecha_devengado, $tipo_desembolso, $id_cajero, $id_emp_recep_caja, $id_periodo_subsistema,$tipo_plantilla,$tipo_pago,$id_caja) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( $id_concepto_ingas );
		$this->var->add_param ( $id_moneda );
		$this->var->add_param ( $importe_devengado );
		$this->var->add_param ( $estado_devengado );
		$this->var->add_param ( $id_proveedor );
		$this->var->add_param ( $tipo_devengado );
		$this->var->add_param ( $importe_pagado );
		$this->var->add_param ( $importe_saldo );
		$this->var->add_param ( $fk_devengado );
		$this->var->add_param ( $id_cheque );
		$this->var->add_param ( $id_documento );
		$this->var->add_param ( $id_comprobante );
		$this->var->add_param ( "'$fecha_devengado'" );
		$this->var->add_param ( $importe_multa );
		$this->var->add_param ( "'$observaciones'" );
		$this->var->add_param ( $id_depto );
		$this->var->add_param ( $tipo_desembolso );
		$this->var->add_param ( $id_cajero );
		$this->var->add_param ( $id_emp_recep_caja );
		$this->var->add_param ( $id_periodo_subsistema );
		$this->var->add_param($tipo_plantilla);
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "'$tipo_pago'" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$id_caja" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarDevengarServicios
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function EliminarDevengarServicios($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_DEL'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ObtenerSaldoDev
	 * Propósito:				Contar los registros de tts_devengado_detalle
	 * Autor:				    RCM
	 * Fecha de creación:		23-10-2008
	 */
	function ObtenerSaldoDev($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSAL_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'saldo', 'numeric' );
		$this->var->add_def_cols ( 'saldo_porc', 'numeric' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	GenerarPago
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		27/10/2008
	 */
	function GenerarPago($fk_devengado, $importe_pagado, $fecha_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $importe_pagado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $fk_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "'$fecha_devengado'" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	ObtenerTotalProrrateado
	 * Propósito:				Obtener el total del importe prorrateado
	 * Autor:				    RCM
	 * Fecha de creación:		13/11/2008
	 */
	function ObtenerTotalProrrateado($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVPRO_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'total_importe', 'numeric' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida [0] [0];
		}
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	ModificarPagoRegulariza
	 * Propósito:				Permite ejecutar la función de modificacion de plantilla de la tabla tts_devengado
	 * Autor:				    JMH
	 * Fecha de creación:		16/11/2009
	 */
	function ModificarPagoRegulariza($id_devengado, $importe_pagado, $fecha_devengado,$tipo_documento,$tipo_documento_regularizado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAGREG_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $importe_pagado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "'$fecha_devengado'" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $tipo_documento );
		$this->var->add_param ( $tipo_documento_regularizado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarPago
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		19/11/2008
	 */
	function ModificarPago($id_devengado, $importe_pagado, $fecha_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $importe_pagado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "'$fecha_devengado'" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPago
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		19/11/2008
	 */
	function EliminarPago($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_DEL'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	VerificarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function VerificarRegistroDocumento($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_VERDOC_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo"<pre>";
		echo print_r($this->salida);
		echo"</pre>";
		exit;*/
		
		/*echo"query:".$this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	VerificarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function VerificarDevengadoPadrePago($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_verif_devengado_padre_pago';
		$this->codigo_procedimiento = "'TS_VERPAD_PAG'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		
		//Carga los parómetros del filtro
		$this->var->cant = "NULL";
		$this->var->puntero = "NULL";
		$this->var->sortcol = "NULL";
		$this->var->sortdir = "NULL";
		$this->var->criterio_filtro = "NULL";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $id_devengado );
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'tipo_pago', 'varchar' );
		$this->var->add_def_cols ( 'tipo_plantilla', 'integer' );
		$this->var->add_def_cols ( 'tipo_doc', 'varchar' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		
		//echo $this->query;
		//exit;
		
		/*echo"<pre>";
		echo print_r($this->salida);
		echo"</pre>";
		exit;
		
		/*echo"query:".$this->query;
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	ExisteDocumento
	 * Propósito:				Verifica si el devengado tiene documento de respaldo
	 * Autor:				    RCM
	 * Fecha de creación:		10/12/2008
	 */
	function ExisteDocumento($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_EXIDOC_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo"<pre>";
		echo print_r($this->salida);
		echo"</pre>";
		exit;*/
		
		//echo"query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	Finalzar Devengado
	 * Propósito:				Permite Finalizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creación:		09/02/2009
	 */
	function FinalizarDevengado($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_FIN'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	FinalizarDevengadoPagado
	 * Propósito:				Permite Finalizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creación:		10/02/2009
	 */
	function FinalizarDevengadoPagado($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_FIN'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	ObtenerSaldoPag
	 * Propósito:				Deveulve el saldo por pagar
	 * Autor:				    RCM
	 * Fecha de creación:		12/02/2009
	 */
	function ObtenerSaldoPag($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEPASA_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'saldo', 'numeric' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	ReporteDevengadoServiciosFin
	 * Propósito:				Reporte al Finalizar la solicitud de Devengado
	 * Autor:				    RCM
	 * Fecha de creación:		05/03/2009
	 */
	function ReporteDevengadoServiciosFin($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_REPDEV_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'fecha_devengado', 'text' );
		$this->var->add_def_cols ( 'desc_ingas_item_serv', 'text' );
		$this->var->add_def_cols ( 'desc_proveedor', 'text' );
		$this->var->add_def_cols ( 'literal', 'text' );
		$this->var->add_def_cols ( 'importe_devengado', 'numeric' );
		$this->var->add_def_cols ( 'partida', 'text' );
		$this->var->add_def_cols ( 'unidad_org', 'text' );
		$this->var->add_def_cols ( 'nombre_financiador', 'varchar' );
		$this->var->add_def_cols ( 'nombre_regional', 'varchar' );
		$this->var->add_def_cols ( 'nombre_programa', 'varchar' );
		$this->var->add_def_cols ( 'nombre_proyecto', 'varchar' );
		$this->var->add_def_cols ( 'nombre_actividad', 'varchar' );
		$this->var->add_def_cols ( 'importe_detalle', 'numeric' );
		$this->var->add_def_cols ( 'porcentaje_devengado', 'text' );
		$this->var->add_def_cols ( 'moneda', 'varchar' );
		$this->var->add_def_cols ( 'observaciones', 'varchar' );
		$this->var->add_def_cols ( 'responsable_aprob', 'text' );
		$this->var->add_def_cols ( 'firma_autorizada', 'text' );
		$this->var->add_def_cols ( 'correl', 'text' );
		$this->var->add_def_cols ( 'forma_pago', 'varchar' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarAprobacionProrrateo
	 * Propósito:				Desplegar los registros para aprobación del Prorrateo
	 * Autor:				    RCM
	 * Fecha de creación:		11/03/2009
	 */
	function ListarAprobacionProrrateo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_APRPRO_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'id_devengado', 'integer' );
		$this->var->add_def_cols ( 'id_devengado_detalle', 'integer' );
		$this->var->add_def_cols ( 'desc_concepto_ingas', 'text' );
		$this->var->add_def_cols ( 'desc_proveedor', 'text' );
		$this->var->add_def_cols ( 'desc_moneda', 'varchar' );
		$this->var->add_def_cols ( 'importe_devengado', 'numeric' );
		$this->var->add_def_cols ( 'porcentaje_devengado', 'numeric' );
		$this->var->add_def_cols ( 'fecha_devengado', 'text' );
		$this->var->add_def_cols ( 'observaciones', 'varchar' );
		$this->var->add_def_cols ( 'nombre_financiador', 'varchar' );
		$this->var->add_def_cols ( 'nombre_regional', 'varchar' );
		$this->var->add_def_cols ( 'nombre_programa', 'varchar' );
		$this->var->add_def_cols ( 'nombre_proyecto', 'varchar' );
		$this->var->add_def_cols ( 'nombre_actividad', 'varchar' );
		$this->var->add_def_cols ( 'desc_unidad_organizacional', 'varchar' );
		$this->var->add_def_cols ( 'aprobado', 'numeric' );
		$this->var->add_def_cols ( 'responsable_aprob', 'text' );
		$this->var->add_def_cols ( 'partida', 'text' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAprobacionProrrateo
	 * Propósito:				Contar los registros de tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		11/03/2009
	 */
	function ContarAprobacionProrrateo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_APRPRO_COUNT'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'total', 'bigint' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida [0] [0];
		}
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ObtenerProrrateoDevengado
	 * Propósito:				Contar los registros de tts_devengado
	 * Autor:				    JMH
	 * Fecha de creación:		16/11/2009
	 */
	function ObtenerProrrateoDevengado($id_devengado){
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_OBAPRPRO_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales
		

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = 1;
		$this->var->puntero = 1;
		$this->var->sortcol = "'asc'";
		$this->var->sortdir = "'asc'";
		$this->var->criterio_filtro = "'asc'";
		
		$id_financiador=$id_devengado;
				
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'aprobado', 'numeric' );
		//$this->var->add_def_cols ( 'case', 'string' );
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if ($res) {
			$this->salida = $this->var->salida [0] [0];
		}
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContabilizarDevengado
	 * Propósito:				Permite Contabilizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creación:		24/04/2009
	 */
	function ContabilizarDevengado($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_CON'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );  
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	FinalizarPago
	 * Propósito:				Permite Finalizar un pago
	 * Autor:				    RCM
	 * Fecha de creación:		27/04/2009
	 */
	function FinalizarPago($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_PAGO_FIN'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	VerificaImporteDocumento
	 * Propósito:				Verifica si el devengado tiene documento de respaldo
	 * Autor:				    RCM
	 * Fecha de creación:		08/05/2009
	 */
	function VerificaImporteDocumento($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_DOCDEV_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo"<pre>";
		echo print_r($this->salida);
		echo"</pre>";
		exit;*/
		
		//echo"query:".$this->query;
		//exit;
		

		return $res;
	}
	
	
	
	/**
	 * Nombre de la función:	ContabilizarDevengadoRegulariz
	 * Propósito:				Permite Contabilizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creación:		08/05/2009
	 */
	function ContabilizarDevengadoRegulariz($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_CRE'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		

		return $res;
	}
	
	/**
	 * Nombre de la función:	GenerarValeCaja
	 * Propósito:				Generar vale de caja para pago de Servicios (genera el vale con su rendición)
	 * Autor:				    RCM
	 * Fecha de creación:		13/07/2009
	 */
	function GenerarValeCaja($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_PAGCAJ_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( "$id_devengado" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//echo "res:".$res;
		//exit;
		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	FinalizarSolicitudDevengado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		23/11/2009
	 */
	function FinalizarSolicitudDevengado($id_devengado,$id_empleado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_SOLPAG_FIN'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( $id_empleado );//id_caja
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
/**
	 * Nombre de la función:	RegistrarDesemDevengado
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		23/11/2009
	 */
	function RegistrarDesemDevengado($id_devengado,$tipo_pago,$tipo_plantilla,$id_cuenta_bancaria) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_REGDES_SOL'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$tipo_plantilla" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "'$tipo_pago'" );
		$this->var->add_param ( "$id_cuenta_bancaria" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContabilizarPago
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		25/11/2009
	 */
	function ContabilizarPago($id_devengado,$tipo_plantilla,$id_cuenta_bancaria) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_CONTPAGO_SOL'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$tipo_plantilla" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$id_cuenta_bancaria" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	RegularizarPago
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creación:		28/11/2009
	 */
	function RegularizarPago($id_devengado,$tipo_plantilla) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_REGPRO_PAG'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "$tipo_plantilla" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
/**
	 * Nombre de la función:	CorregirSolicitudDevengado
	 * Propósito:				Permite ejecutar la función de Correcion de Solicitud de devengado
	 * Autor:				    RCM
	 * Fecha de creación:		12/01/2010
	 */
	function CorregirSolicitudDevengado($id_devengado) {
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_CORSOL_DEV'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento, $this->decodificar );
		$this->var->add_param ( $id_devengado );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );//tipo_plantilla_pago
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		$this->var->add_param ( "NULL" );
		
		//Ejecuta la función
		$res = $this->var->exec_non_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ReciboPago
	 * Propósito:				Reporte Recibo de pago
	 * Autor:				    RCM
	 * Fecha de creación:		09/02/2010
	 */
	function ReciboPago($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_recibo_pago_sel';
		$this->codigo_procedimiento = "'TS_RECPAG_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('monto_original', 'numeric');
		$this->var->add_def_cols('multas', 'numeric');
		$this->var->add_def_cols('descuento_anticipo', 'numeric');
		$this->var->add_def_cols('descuento_garantia', 'numeric');
		$this->var->add_def_cols('por_retgar', 'numeric');
		$this->var->add_def_cols('importe_sujeto', 'numeric');
		$this->var->add_def_cols('desc_plantilla', 'varchar');
		$this->var->add_def_cols('retenciones', 'numeric');
		$this->var->add_def_cols('importe_a_pagar', 'numeric');
		$this->var->add_def_cols('concepto', 'text');
		$this->var->add_def_cols('fecha_pago', 'text');
		$this->var->add_def_cols('desc_moneda', 'varchar');
		$this->var->add_def_cols('moneda', 'varchar');
		$this->var->add_def_cols('literal', 'varchar');
		$this->var->add_def_cols('nombre_pago', 'varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
/**
	 * Nombre de la función:	ReciboPagoDetalleDescuentos
	 * Propósito:				Reporte Recibo de pago, detalle de las retenciones por el tipo de documento de respaldo
	 * Autor:				    RCM
	 * Fecha de creación:		09/02/2010
	 */
	function ReciboPagoDetalleDescuentos($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_recibo_pago_sel';
		$this->codigo_procedimiento = "'TS_REPADE_SEL'";
		
		$func = new cls_funciones ( ); //Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle ( $this->nombre_funcion, $this->codigo_procedimiento );
		
		//Carga los parómetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parómetros especóficos de la estructura programótica
		$this->var->add_param ( $func->iif ( $id_financiador == '', "'%'", "'$id_financiador'" ) ); //id_financiador
		$this->var->add_param ( $func->iif ( $id_regional == '', "'%'", "'$id_regional'" ) ); //id_regional
		$this->var->add_param ( $func->iif ( $id_programa == '', "'%'", "'$id_programa'" ) ); //id_programa
		$this->var->add_param ( $func->iif ( $id_proyecto == '', "'%'", "'$id_proyecto'" ) ); //id_proyecto
		$this->var->add_param ( $func->iif ( $id_actividad == '', "'%'", "'$id_actividad'" ) ); //id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols ( 'tipo_descuento', 'text' );
		$this->var->add_def_cols ( 'descuento', 'numeric' );
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query ();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ValidarDevengarServicios
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-21 15:43:26
	 */
	function ValidarDevengarServicios($operacion_sql, $id_devengado, $id_concepto_ingas, $id_moneda, $importe_devengado, $estado_devengado, $id_proveedor, $tipo_devengado) {
		$this->salida = "";
		$valid = new cls_validacion_serv ( );
		
		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato ( );
		
		//Ejecuta la validación por el tipo de operación
		if ($operacion_sql == 'insert' || $operacion_sql == 'update') {
			if ($operacion_sql == 'update') {
				//Validar id_devengado - tipo int4
				$tipo_dato->_reiniciar_valor ();
				$tipo_dato->set_MaxLength ( 10 );
				$tipo_dato->set_Columna ( "id_devengado" );
				
				if (! $valid->verifica_dato ( $tipo_dato->TipoDatoInteger (), "id_devengado", $id_devengado )) {
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			//Validar id_concepto_ingas - tipo int4
			$tipo_dato->_reiniciar_valor ();
			$tipo_dato->set_Columna ( "id_concepto_ingas" );
			$tipo_dato->set_MaxLength ( 10 );
			$tipo_dato->set_AllowBlank ( true );
			if (! $valid->verifica_dato ( $tipo_dato->TipoDatoInteger (), "id_concepto_ingas", $id_concepto_ingas )) {
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor ();
			$tipo_dato->set_Columna ( "id_moneda" );
			$tipo_dato->set_MaxLength ( 10 );
			$tipo_dato->set_AllowBlank ( true );
			if (! $valid->verifica_dato ( $tipo_dato->TipoDatoInteger (), "id_moneda", $id_moneda )) {
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar importe_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor ();
			$tipo_dato->set_Columna ( "importe_devengado" );
			$tipo_dato->set_MaxLength ( 1179650 );
			$tipo_dato->set_AllowBlank ( true );
			if (! $valid->verifica_dato ( $tipo_dato->TipoDatoReal (), "importe_devengado", $importe_devengado )) {
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar estado_devengado - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_devengado");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_devengado", $estado_devengado))
			{
			$this->salida = $valid->salida;
			return false;
			}*/
			
			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor ();
			$tipo_dato->set_Columna ( "id_proveedor" );
			$tipo_dato->set_MaxLength ( 10 );
			$tipo_dato->set_AllowBlank ( true );
			if (! $valid->verifica_dato ( $tipo_dato->TipoDatoInteger (), "id_proveedor", $id_proveedor )) {
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar tipo_devengado - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_devengado");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_devengado", $tipo_devengado))
			{
			$this->salida = $valid->salida;
			return false;
			}*/
			//Validación exitosa
			return true;
		} elseif ($operacion_sql == 'delete') {
			//Validar id_devengado - tipo int4
			$tipo_dato->_reiniciar_valor ();
			$tipo_dato->set_Columna ( "id_devengado" );
			
			if (! $valid->verifica_dato ( $tipo_dato->TipoDatoInteger (), "id_devengado", $id_devengado )) {
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		} else {
			return false;
		}
	}
}
?>