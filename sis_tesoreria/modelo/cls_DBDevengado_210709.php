<?php
/**
 * Nombre de la clase:	cls_DBDevengado.php
 * Propï¿½sito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_devengado
 * Autor:				(autogenerado)
 * Fecha creaciï¿½n:		2008-10-21 15:43:26
 */


class cls_DBDevengado
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;

	function __construct()
	{
		$this->decodificar=$decodificar;
	}

	/**
	 * Nombre de la funciï¿½n:	ListarDevengarServicios
	 * Propï¿½sito:				Desplegar los registros de tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function ListarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSER_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_devengado','int4');
		$this->var->add_def_cols('id_concepto_ingas','int4');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('importe_devengado','numeric');
		$this->var->add_def_cols('importe_pagado','numeric');
		$this->var->add_def_cols('importe_saldo','numeric');
		$this->var->add_def_cols('estado_devengado','numeric');
		$this->var->add_def_cols('fk_devengado','int4');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('id_cheque','int4');
		$this->var->add_def_cols('id_comprobante','int4');
		$this->var->add_def_cols('tipo_devengado','numeric');
		$this->var->add_def_cols('fecha_devengado','date');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('desc_tipo_devengado','text');
		$this->var->add_def_cols('desc_estado_devengado','text');
		$this->var->add_def_cols('tot_importe_det','numeric');
		$this->var->add_def_cols('tot_porcentaje_det','numeric');
		$this->var->add_def_cols('nombre_pago','varchar');
		$this->var->add_def_cols('nro_cheque','integer');
		$this->var->add_def_cols('fecha_cheque','text');
		$this->var->add_def_cols('nombre_cheque','varchar');
		$this->var->add_def_cols('estado_cheque','numeric');
		$this->var->add_def_cols('desc_estado_cheque','text');
		$this->var->add_def_cols('importe_multa','numeric');
		$this->var->add_def_cols('id_plan_pago','integer');
		$this->var->add_def_cols('id_cotizacion','integer');
		$this->var->add_def_cols('nivel_documento','varchar');
		$this->var->add_def_cols('banco','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('nit','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_periodo_subsistema','integer');
		$this->var->add_def_cols('tipo_gen_pago','numeric');
		$this->var->add_def_cols('desc_tipo_gen_pago','text');
		$this->var->add_def_cols('obs_contabilidad','text');
		$this->var->add_def_cols('tipo_desembolso','numeric');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('caja','text');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ContarDevengarServicios
	 * Propï¿½sito:				Contar los registros de tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function ContarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSER_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	InsertarDevengarServicios
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function InsertarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_devengado);
		$this->var->add_param($estado_devengado);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($tipo_devengado);
		$this->var->add_param($importe_pagado);
		$this->var->add_param($importe_saldo);
		$this->var->add_param($fk_devengado);
		$this->var->add_param($id_cheque);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_comprobante);
		$this->var->add_param("'$fecha_devengado'");
		$this->var->add_param($importe_multa);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_depto);
		$this->var->add_param($tipo_desembolso);
		$this->var->add_param($id_cajero);


		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ModificarDevengarServicios
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function ModificarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_devengado);
		$this->var->add_param($estado_devengado);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($tipo_devengado);
		$this->var->add_param($importe_pagado);
		$this->var->add_param($importe_saldo);
		$this->var->add_param($fk_devengado);
		$this->var->add_param($id_cheque);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_comprobante);
		$this->var->add_param("'$fecha_devengado'");
		$this->var->add_param($importe_multa);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_depto);
		$this->var->add_param($tipo_desembolso);
		$this->var->add_param($id_cajero);

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	EliminarDevengarServicios
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function EliminarDevengarServicios($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ObtenerSaldoDev
	 * Propï¿½sito:				Contar los registros de tts_devengado_detalle
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		23-10-2008
	 */
	function ObtenerSaldoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVSAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('saldo','numeric');
		$this->var->add_def_cols('saldo_porc','numeric');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	GenerarPago
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		27/10/2008
	 */
	function GenerarPago($fk_devengado,$importe_pagado,$fecha_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_pagado);
		$this->var->add_param("NULL");
		$this->var->add_param($fk_devengado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_devengado'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ObtenerTotalProrrateado
	 * Propï¿½sito:				Obtener el total del importe prorrateado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		13/11/2008
	 */
	function ObtenerTotalProrrateado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEVPRO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total_importe','numeric');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//echo "query:".$this->query;
		//exit;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ModificarPago
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		19/11/2008
	 */
	function ModificarPago($id_devengado,$importe_pagado,$fecha_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($importe_pagado);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_devengado'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	EliminarPago
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tts_devengado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		19/11/2008
	 */
	function EliminarPago($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_DEL'";
		
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	VerificarRegistroDocumento
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function VerificarRegistroDocumento($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_VERDOC_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado);
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
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
	 * Nombre de la funciï¿½n:	ExisteDocumento
	 * Propï¿½sito:				Verifica si el devengado tiene documento de respaldo
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		10/12/2008
	 */
	function ExisteDocumento($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_EXIDOC_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado);
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
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
	 * Nombre de la funciï¿½n:	Finalzar Devengado
	 * Propï¿½sito:				Permite Finalizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		09/02/2009
	 */
	function FinalizarDevengado($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		//echo "res:".$res;
		//exit;

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	FinalizarDevengadoPagado
	 * Propï¿½sito:				Permite Finalizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		10/02/2009
	 */
	function FinalizarDevengadoPagado($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVPAG_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		//echo "res:".$res;
		//exit;

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ObtenerSaldoPag
	 * Propï¿½sito:				Deveulve el saldo por pagar
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		12/02/2009
	 */
	function ObtenerSaldoPag($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_DEPASA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('saldo','numeric');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		
		return $res;
	}
	
/**
	 * Nombre de la funciï¿½n:	ReporteDevengadoServiciosFin
	 * Propï¿½sito:				Reporte al Finalizar la solicitud de Devengado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		05/03/2009
	 */
	function ReporteDevengadoServiciosFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_REPDEV_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_devengado','text');
		$this->var->add_def_cols('desc_ingas_item_serv','text');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('literal','text');
		$this->var->add_def_cols('importe_devengado','numeric');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('unidad_org','text');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('importe_detalle','numeric');
		$this->var->add_def_cols('porcentaje_devengado','text');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('responsable_aprob','text');
		$this->var->add_def_cols('firma_autorizada','text');
		$this->var->add_def_cols('correl','text');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ListarAprobacionProrrateo
	 * Propï¿½sito:				Desplegar los registros para aprobaciï¿½n del Prorrateo
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		11/03/2009
	 */
	function ListarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_APRPRO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_devengado','integer');
		$this->var->add_def_cols('id_devengado_detalle','integer');
		$this->var->add_def_cols('desc_concepto_ingas','text');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_devengado','numeric');
		$this->var->add_def_cols('porcentaje_devengado','numeric');
		$this->var->add_def_cols('fecha_devengado','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('aprobado','numeric');
		$this->var->add_def_cols('responsable_aprob','text');
		$this->var->add_def_cols('partida','text');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		return $res;
	}

	/**
	 * Nombre de la funciï¿½n:	ContarAprobacionProrrateo
	 * Propï¿½sito:				Contar los registros de tts_devengado
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		11/03/2009
	 */
	function ContarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_sel';
		$this->codigo_procedimiento = "'TS_APRPRO_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ContabilizarDevengado
	 * Propï¿½sito:				Permite Contabilizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		24/04/2009
	 */
	function ContabilizarDevengado($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_CON'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		//echo "res:".$res;
		//exit;

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	FinalizarPago
	 * Propï¿½sito:				Permite Finalizar un pago
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		27/04/2009
	 */
	function FinalizarPago($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_PAGO_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		//echo "res:".$res;
		//exit;

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	VerificaImporteDocumento
	 * Propï¿½sito:				Verifica si el devengado tiene documento de respaldo
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		08/05/2009
	 */
	function VerificaImporteDocumento($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_devengado_verif_reg_doc';
		$this->codigo_procedimiento = "'TS_DOCDEV_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_devengado);
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
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
	 * Nombre de la funciï¿½n:	ContabilizarDevengadoRegulariz
	 * Propï¿½sito:				Permite Contabilizar un devengado comprometiendo y ejecutando Presupuestos (devengados que no vienen de Adquisiciones)
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		08/05/2009
	 */
	function ContabilizarDevengadoRegulariz($id_devengado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_devengado_iud';
		$this->codigo_procedimiento = "'TS_DEVSER_CRE'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_devengado");
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
		
		//echo "res:".$res;
		//exit;

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		/*echo "<pre>";
		print_r($this->salida);
		echo "</pre>";
		exit;*/

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ValidarDevengarServicios
	 * Propï¿½sito:				Permite ejecutar la validaciï¿½n del lado del servidor de la tabla tts_devengado
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-10-21 15:43:26
	 */
	function ValidarDevengarServicios($operacion_sql,$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validaciï¿½n por el tipo de operaciï¿½n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_devengado - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_devengado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_concepto_ingas - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_concepto_ingas");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_concepto_ingas", $id_concepto_ingas))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_devengado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_devengado");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_devengado", $importe_devengado))
			{
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
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
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
			//Validaciï¿½n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_devengado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_devengado");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_devengado", $id_devengado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaciï¿½n exitosa
			return true;
		}
		else
		{
			return false;
		}
	}
}?>