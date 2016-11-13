<?php
/**
 * Nombre de la clase:	cls_DBBancarizacionDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_bancarizacion_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-10-15 17:39:51
 */

 
class cls_DBBancarizacionDet
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
	 * Nombre de la función:	ListarBancarizacionDet
	 * Propósito:				Desplegar los registros de tct_bancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ListarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_bancarizacion_det_sel';
		$this->codigo_procedimiento = "'CT_BANCDET_SEL'";

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
		$this->var->add_def_cols('id_bancarizacion_det','int4');
		$this->var->add_def_cols('id_bancarizacion','int4');
		$this->var->add_def_cols('tipo_operacion','varchar');
		$this->var->add_def_cols('modalidad','varchar');
		$this->var->add_def_cols('id_comprobante_dev','int4');
		$this->var->add_def_cols('comprobante_dev','varchar');
		$this->var->add_def_cols('id_comprobante_pago','int4');
		$this->var->add_def_cols('comprobante_pago','varchar');
		$this->var->add_def_cols('id_transaccion_pago','int4');
		$this->var->add_def_cols('concepto_tran','varchar');
		$this->var->add_def_cols('id_transac_valor_pago','int4');
		$this->var->add_def_cols('fecha_reg','timestamp');
		$this->var->add_def_cols('id_usuario_reg','integer');
		$this->var->add_def_cols('login','varchar');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','text');		
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nombre_corto','varchar');
		$this->var->add_def_cols('id_depto','int4');		
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
        $this->var->add_def_cols('origen','varchar');
        $this->var->add_def_cols('acumulado','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query ; exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarBancarizacionDet
	 * Propósito:				Contar los registros de tct_bancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function ContarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_bancarizacion_det_sel';
		$this->codigo_procedimiento = "'CT_BANCDET_COUNT'";

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
	 * Nombre de la función:	RepBancarizacionDet
	 * Propósito:				Desplegar los registros de tct_bancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function RepBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_bancarizacion_det_sel';
		$this->codigo_procedimiento = "'CT_REP_BANCDET'";

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
		$this->var->add_def_cols('modalidad','varchar');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('tipo_transaccion','varchar');
		$this->var->add_def_cols('nit_proveedor','varchar');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_factura','bigint');
		$this->var->add_def_cols('monto_factura','numeric');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('cuenta_doc_pago','varchar');
		$this->var->add_def_cols('monto_doc_pago','numeric');
		$this->var->add_def_cols('monto_acumulado','numeric');
		$this->var->add_def_cols('nit_entidad_financiera','varchar');
		$this->var->add_def_cols('nro_doc_pago','varchar');
		$this->var->add_def_cols('tipo_doc_pago','varchar');
		$this->var->add_def_cols('fecha_doc_pago','date');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query ; exit();
		return $res;
	}

/**
	 * Nombre de la función:	XlsBancarizacion
	 * Propósito:				Desplegar los registros de tct_bancarizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-10-15 17:39:51
	 */
	function XlsBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_bancarizacion_det_sel';
		$this->codigo_procedimiento = "'CT_XLS_BANCDET'";

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
		$this->var->add_def_cols('cons','varchar');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('id_comprobante_pago','integer');
		$this->var->add_def_cols('fecha_cbte','varchar');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('id_comprobante_dev','integer');
		$this->var->add_def_cols('fecha_cbte_dev','varchar');
		$this->var->add_def_cols('acreedor_dev','varchar');
		$this->var->add_def_cols('modalidad','varchar');
		$this->var->add_def_cols('fecha_factura','varchar');
		$this->var->add_def_cols('tipo_transaccion','varchar');
		$this->var->add_def_cols('nit_proveedor','varchar');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_factura','bigint');
		$this->var->add_def_cols('monto_factura','numeric');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('cuenta_doc_pago','varchar');
		$this->var->add_def_cols('monto_doc_pago','numeric');
		$this->var->add_def_cols('monto_acumulado','numeric');
		$this->var->add_def_cols('nit_entidad_financiera','varchar');
		$this->var->add_def_cols('nro_doc_pago','varchar');
		$this->var->add_def_cols('tipo_doc_pago','varchar');
		$this->var->add_def_cols('fecha_doc_pago','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query ; exit();
		return $res;
	}
}?>