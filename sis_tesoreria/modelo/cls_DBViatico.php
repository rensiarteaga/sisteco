<?php
/**
 * Nombre de la clase:	cls_DBViatico.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tts_tts_viatico
 * Autor:				(autogenerado)
 * Fecha creación:		2008-11-12 11:42:19
 */

 
class cls_DBViatico
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
	 * Nombre de la función:	ListarSolicitudViaticos
	 * Propósito:				Desplegar los registros de tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ListarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_SOLVIA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_viatico','int4');
		
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');

		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');		
		
		$this->var->add_def_cols('id_cuenta_bancaria','int4');
		$this->var->add_def_cols('nombre_institucion','varchar');
		$this->var->add_def_cols('nro_cuenta_banco_cuenta_bancaria','varchar');
		$this->var->add_def_cols('desc_cuenta_bancaria','text');
		$this->var->add_def_cols('nombre_cheque','varchar');		
		
		$this->var->add_def_cols('estado_viatico','numeric');		
		$this->var->add_def_cols('fecha_solicitud','text');
		$this->var->add_def_cols('num_solicitud','varchar');
		
		$this->var->add_def_cols('detalle_viaticos','varchar');
		$this->var->add_def_cols('motivo_viaje','varchar');
		
		$this->var->add_def_cols('detalle_otros','varchar');
		$this->var->add_def_cols('sw_retencion','numeric');
		$this->var->add_def_cols('tipo_pago','numeric');
		$this->var->add_def_cols('id_cheque','integer');
		$this->var->add_def_cols('id_comprobante','integer');
		
		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('importe_regis','numeric');
		$this->var->add_def_cols('concepto_regis','text');
		
		$this->var->add_def_cols('obs_viatico','text');		
		$this->var->add_def_cols('tipo_viatico','numeric');		
		$this->var->add_def_cols('fk_viatico','integer');
		$this->var->add_def_cols('observacion','text');
		
		$this->var->add_def_cols('fecha_inicio','text');
		$this->var->add_def_cols('fecha_fin','text');
		$this->var->add_def_cols('saldo_viatico','numeric');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		
		$this->var->add_def_cols('resp_registro','text');
		$this->var->add_def_cols('id_presupuesto','int4');
		$this->var->add_def_cols('desc_presupuesto','text');
		
		$this->var->add_def_cols('id_responsable_rendicion','int4');	
		$this->var->add_def_cols('desc_responsable_rendicion','text');
		$this->var->add_def_cols('id_autorizacion','int4');	
		$this->var->add_def_cols('desc_autorizacion','text');
		$this->var->add_def_cols('id_aprobacion','int4');	
		$this->var->add_def_cols('desc_aprobacion','text');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION["ss_id_usuario"]==120){echo $this->query;
		exit();}*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarSolicitudViaticos
	 * Propósito:				Desplegar los registros de tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ListarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_PAGVIA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_viatico','int4');
		
		$this->var->add_def_cols('id_unidad_organizacional','int4');
		$this->var->add_def_cols('desc_unidad_organizacional','text');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('apellido_paterno_persona','varchar');
		$this->var->add_def_cols('apellido_materno_persona','varchar');
		$this->var->add_def_cols('nombre_persona','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_categoria','int4');
		$this->var->add_def_cols('desc_categoria','varchar');

		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');		
		
		$this->var->add_def_cols('id_cuenta_bancaria','int4');
		$this->var->add_def_cols('nombre_institucion','varchar');
		$this->var->add_def_cols('nro_cuenta_banco_cuenta_bancaria','varchar');
		$this->var->add_def_cols('desc_cuenta_bancaria','text');
		$this->var->add_def_cols('nombre_cheque','varchar');		
		
		$this->var->add_def_cols('estado_viatico','numeric');		
		$this->var->add_def_cols('fecha_solicitud','text');
		$this->var->add_def_cols('num_solicitud','varchar');
		
		$this->var->add_def_cols('detalle_viaticos','varchar');
		$this->var->add_def_cols('motivo_viaje','varchar');
		
		$this->var->add_def_cols('detalle_otros','varchar');
		$this->var->add_def_cols('sw_retencion','numeric');
		$this->var->add_def_cols('tipo_pago','numeric');
		$this->var->add_def_cols('id_cheque','integer');
		$this->var->add_def_cols('id_comprobante','integer');
		
		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('desc_caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('desc_cajero','text');
		$this->var->add_def_cols('importe_regis','numeric');
		$this->var->add_def_cols('concepto_regis','text');
		
		$this->var->add_def_cols('obs_viatico','text');		
		$this->var->add_def_cols('tipo_viatico','numeric');		
		$this->var->add_def_cols('fk_viatico','integer');
		$this->var->add_def_cols('observacion','text');
		
		$this->var->add_def_cols('fecha_inicio','text');
		$this->var->add_def_cols('fecha_fin','text');
		$this->var->add_def_cols('saldo_viatico','numeric');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		
		$this->var->add_def_cols('resp_registro','text');
		
		$this->var->add_def_cols('id_responsable_rendicion','int4');	
		$this->var->add_def_cols('desc_responsable_rendicion','text');
		$this->var->add_def_cols('id_autorizacion','int4');	
		$this->var->add_def_cols('desc_autorizacion','text');
		$this->var->add_def_cols('id_aprobacion','int4');	
		$this->var->add_def_cols('desc_aprobacion','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	function ListarReporteSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_REPSOL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('fecha_solicitud','text');	
		$this->var->add_def_cols('num_solicitud','varchar');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');
		$this->var->add_def_cols('desc_gerente_area','text');
		$this->var->add_def_cols('motivo_viaje','varchar');
		
		$this->var->add_def_cols('fecha_inicio','text');
		$this->var->add_def_cols('fecha_final','text');
		$this->var->add_def_cols('hora_inicio','text');
		$this->var->add_def_cols('hora_final','text');	
		
		$this->var->add_def_cols('tipo_viaje','varchar');
		$this->var->add_def_cols('institucion','varchar');		
		$this->var->add_def_cols('desc_categoria','varchar');		
		$this->var->add_def_cols('lugar_origen','varchar');
		$this->var->add_def_cols('lugar_destino','varchar');
		$this->var->add_def_cols('nro_dias','numeric');
		
		$this->var->add_def_cols('cobertura','varchar');		
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_pasaje','numeric');
		$this->var->add_def_cols('total_pasaje','numeric');
		$this->var->add_def_cols('importe_viatico','numeric');
		$this->var->add_def_cols('total_viatico','numeric');
		$this->var->add_def_cols('importe_hotel','numeric');
		$this->var->add_def_cols('total_hotel','numeric');
		$this->var->add_def_cols('importe_otros','numeric');
		$this->var->add_def_cols('total_otros','numeric');
		$this->var->add_def_cols('total_general','numeric');
		$this->var->add_def_cols('literal_total','varchar');
					
		$this->var->add_def_cols('detalle_viaticos','varchar');
		$this->var->add_def_cols('detalle_otros','varchar');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('sw_retencion','varchar');
		$this->var->add_def_cols('retencion','numeric');
		$this->var->add_def_cols('obs_viatico','text');
		$this->var->add_def_cols('gerente_financiero','text');
		$this->var->add_def_cols('cargo_vo_bo','varchar');
		$this->var->add_def_cols('estructura_programatica','text');
		
		$this->var->add_def_cols('firma_autorizador','text');
		$this->var->add_def_cols('cargo_autorizador','varchar');
		$this->var->add_def_cols('firma_aprobador','text');
		$this->var->add_def_cols('cargo_aprobador','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit();
		return $res;
	}	
	
	/**
	 * Nombre de la función:	ListarSolicitudViaticos
	 * Propósito:				Desplegar los registros de tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ListarMontosViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_destino,$cobertura,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ts_obtener_viaticos';
		$this->codigo_procedimiento = "'TS_CONSVI_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_destino == '',"1","$id_destino"));
		$this->var->add_param($func->iif($cobertura == '',"1","$cobertura"));
		$this->var->add_param($func->iif($id_moneda == '',"1","$id_moneda"));

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('importe_pasaje','numeric');
		$this->var->add_def_cols('importe_hotel','numeric');
		$this->var->add_def_cols('importe_viaticos','numeric');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ListarReporteRendicionViaticos
	 * Propósito:				Desplegar los registros 
	 * Autor:				    JoSé Mita
	 * Fecha de creación:		hoy
	 */
	function ListarReporteRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_RENVIA_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

			//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos

		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('id_destino','integer');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('fecha_inicio','timestamp');
		$this->var->add_def_cols('fecha_final','timestamp');
		$this->var->add_def_cols('nro_dias','numeric');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('destino','varchar');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('empleado','text');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('fecha_rinde','date');
		$this->var->add_def_cols('num_solicitud','varchar');
		$this->var->add_def_cols('total_hotel','numeric');
		$this->var->add_def_cols('total_otros','numeric');
		$this->var->add_def_cols('total_viatico','numeric');
		
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('importe_entregado','numeric');
		$this->var->add_def_cols('nro_cheque','integer');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('importe_cheque','numeric');
		
		/*viarin.fecha_rinde,
                                  via.num_solicitud,
                                  via.total_hotel,
                                  via.total_otros,
                                  via.total_viatico*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();
		return $res;
	}
	
	
	
	function ListarReporteViaticoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_OBTEP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_unidad','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudViaticos
	 * Propósito:				Contar los registros de tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ContarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_SOLVIA_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit();*/

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function ContarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_sel';
		$this->codigo_procedimiento = "'TS_PAGVIA_COUNT'";
 
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;		
	 
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarSolicitudViaticos
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function InsertarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
						$id_empleado,$id_categoria,$id_moneda,
						$id_cuenta_bancaria,$nombre_cheque,						
						$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
						$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
						$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
						$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
						$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
						$id_responsable_rendicion,$id_autorizacion,$id_aprobacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_iud';
		$this->codigo_procedimiento = "'TS_SOLVIA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria);
		
		$this->var->add_param($id_moneda);		
		
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$nombre_cheque'");		
		$this->var->add_param($estado_viatico);
		
		$this->var->add_param("'$fecha_solicitud'");
		$this->var->add_param("'$num_solicitud'");
		
		$this->var->add_param("'$detalle_viaticos'");
		$this->var->add_param("'$motivo_viaje'");
		
		$this->var->add_param("'$detalle_otros'");
		$this->var->add_param($sw_retencion);
		$this->var->add_param($tipo_pago);
		
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param($importe_regis);
		
		$this->var->add_param($tipo_viatico);		
		$this->var->add_param($fk_viatico);
		$this->var->add_param("'$observacion'");
		
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param($numero_deposito);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$obs_viatico'");
		$this->var->add_param($id_presupuesto);
		
		$this->var->add_param($id_responsable_rendicion);
		$this->var->add_param($id_autorizacion);		
		$this->var->add_param($id_aprobacion);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSolicitudViaticos
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ModificarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
					$id_empleado,$id_categoria,$id_moneda,
					$id_cuenta_bancaria,$nombre_cheque,					
					$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
					$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
					$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
					$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
					$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
					$id_responsable_rendicion,$id_autorizacion,$id_aprobacion)					
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_iud';
		if($tipo_actualizacion==1)	
		{
			$this->codigo_procedimiento = "'TS_SOLVIA_UPD'";
		}	
		else if($tipo_actualizacion==2)
		{
			$this->codigo_procedimiento = "'TS_CHEVIA_UPD'"; 
		}
		else if($tipo_actualizacion==3)
		{
			$this->codigo_procedimiento = "'TS_VIAFIN_UPD'"; 
		}
		else if($tipo_actualizacion==4)
		{
			$this->codigo_procedimiento = "'TS_VALVIA_UPD'"; 
		}
		else if($tipo_actualizacion==5)
		{
			$this->codigo_procedimiento = "'TS_CONCLUIRVIA_UPD'"; 
		}
			
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_viatico);		
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria);
		$this->var->add_param($id_moneda);		
		
		$this->var->add_param($id_cuenta_bancaria);
		$this->var->add_param("'$nombre_cheque'");		
			
		$this->var->add_param($estado_viatico);			
		$this->var->add_param("'$fecha_solicitud'");
		$this->var->add_param("'$num_solicitud'");
		
		$this->var->add_param("'$detalle_viaticos'");
		$this->var->add_param("'$motivo_viaje'");
		$this->var->add_param("'$detalle_otros'");
		
		$this->var->add_param($sw_retencion);
		$this->var->add_param($tipo_pago);
		
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param($importe_regis);
		
		$this->var->add_param($tipo_viatico);		
		$this->var->add_param($fk_viatico);
		$this->var->add_param("'$observacion'");
		
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param($numero_deposito);
		$this->var->add_param($id_depto);
		$this->var->add_param("'$obs_viatico'");
		$this->var->add_param($id_presupuesto);		
		
		$this->var->add_param($id_responsable_rendicion);
		$this->var->add_param($id_autorizacion);		
		$this->var->add_param($id_aprobacion);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSolicitudViaticos
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function EliminarSolicitudViaticos($id_viatico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_viatico_iud';
		$this->codigo_procedimiento = "'TS_SOLVIA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_viatico);
		$this->var->add_param("NULL");	//unidad organizacional
		$this->var->add_param("NULL");	//empleado
		$this->var->add_param("NULL");	//categoria
		$this->var->add_param("NULL");	//moneda
		
		$this->var->add_param("NULL");	//id_cuenta bancaria
		$this->var->add_param("NULL");	//nombre cheque		
				
		$this->var->add_param("NULL");	//estado viatico		
		$this->var->add_param("NULL");	//fecha_solicitud
		$this->var->add_param("NULL");	//num_solicitud
		
		$this->var->add_param("NULL");	//detalle_viaticos
		$this->var->add_param("NULL");	//motivo_viaje		
		$this->var->add_param("NULL");	//detalle_otros
		
		$this->var->add_param("NULL");	//sw_retencion
		$this->var->add_param("NULL");	//tipo_pago
			
		$this->var->add_param("NULL");	//$id_caja
		$this->var->add_param("NULL");	//$id_cajero
		$this->var->add_param("NULL");	//$importe_regis
		
		$this->var->add_param("NULL");	//$tipo_viatico			
		$this->var->add_param("NULL"); 	//$fk_viatico
		$this->var->add_param("NULL"); 	//$observacion
		
		$this->var->add_param("NULL");	//fecha_inicio
		$this->var->add_param("NULL");	//fecha_fin		
		$this->var->add_param("NULL");	//numero_deposito	
		$this->var->add_param("NULL");	//id_depto
		$this->var->add_param("NULL");	//obs_viatico
		$this->var->add_param("NULL");	//id_presupuesto
		
		$this->var->add_param("NULL");	//id_responsable_rendicion
		$this->var->add_param("NULL");	//id_autorizacion
		$this->var->add_param("NULL");	//id_aprobacion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function VerificarSaldoViatico($id_viatico)
	{
		$this->salida = "";
		/*$this->nombre_funcion = 'f_tts_caja_regis_sel';
		$this->codigo_procedimiento = "'TS_VERVAL_SEL'";*/
		
		$this->nombre_funcion = 'f_ts_viatico_sel';
		$this->codigo_procedimiento = "'TS_VERSAL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $id_viatico;//para mandar el id_caja_regis como entero
		$this->var->puntero =0;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "''";
		
		$id_financiador='';
		$id_regional='';
		$id_programa='';
		$id_proyecto='';
		$id_actividad='';
		
		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('resultado','int4');
		$this->var->add_def_cols('monto','numeric');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarSolicitudViaticos
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tts_viatico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-11-12 11:42:19
	 */
	function ValidarSolicitudViaticos($operacion_sql,$id_viatico,$id_unidad_organizacional,
							$id_empleado,$id_categoria,$id_moneda,
							$id_cuenta_bancaria,$nombre_cheque)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_viatico - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_viatico");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico", $id_viatico))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}			

			//Validar id_unidad_organizacional - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria", $id_categoria))
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

			//Validar id_cuenta_bancaria - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta_bancaria");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta_bancaria", $id_cuenta_bancaria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_cheque - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_cheque");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_cheque", $nombre_cheque))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_viatico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_viatico");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_viatico", $id_viatico))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
}?>