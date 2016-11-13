<?php
/**
 * Nombre de la clase:	cls_DBDocumento.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_documento
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-16 17:57:13
 */


class cls_DBDocumento
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
	 * Nombre de la función:	ListarRegistroDocumento
	 * Propósito:				Desplegar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ListarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_REGDOC_SEL'";

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
		$this->var->add_def_cols('id_documento','Integer');
		$this->var->add_def_cols('id_transaccion','Integer');
		$this->var->add_def_cols('desc_transaccion','varchar');
		$this->var->add_def_cols('tipo_documento','numeric');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('poliza_dui','varchar');
		$this->var->add_def_cols('formulario','varchar');
		$this->var->add_def_cols('tipo_retencion','numeric');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('importe_ice ','numeric');
		$this->var->add_def_cols('importe_no_gravado','numeric');
		$this->var->add_def_cols('importe_sujeto','numeric');
		$this->var->add_def_cols('importe_credito','numeric');
		$this->var->add_def_cols('importe_debito','numeric');
		$this->var->add_def_cols('importe_iue ','numeric');
		$this->var->add_def_cols('importe_it','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('desc_plantilla','varchar');
		$this->var->add_def_cols('estado_documento','integer');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*	echo $this->query;
		exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroDocumento
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_REGDOC_COUNT'";

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
	///////////////////////////////////----DOCUMENTO IVA------////////////////////////////////////////////////////////////////
	function ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_antiguo_sel';
		$this->codigo_procedimiento = "'CT_DOCIVA_SEL'";

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
		$this->var->add_param($id_periodo_subsis);
		$this->var->add_param($id_moneda);
		$this->var->add_param($sw_debito_credito);
		$this->var->add_param("'$id_depto'");
		$this->var->add_param("'$tipo_documento'");
		
		$this->var->add_def_cols('fecha_documento_reporte','text');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('razon_social','text');
        $this->var->add_def_cols('nro_documento','bigint');
        $this->var->add_def_cols('nro_autorizacion','varchar');
        $this->var->add_def_cols('codigo_control','varchar');	
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('importe_ice','numeric');
		$this->var->add_def_cols('importe_no_gravado','numeric');
		$this->var->add_def_cols('importe_sujeto','numeric');
		$this->var->add_def_cols('importe_credito','numeric');
		$this->var->add_def_cols('importe_debito','numeric');
		$this->var->add_def_cols('desc_comprobante','text');	
		$this->var->add_def_cols('fecha_documento','date');
		$this->var->add_def_cols('importe_neto','numeric');
		$this->var->add_def_cols('id_documento','bigint');
		if ($sw_debito_credito == 1){
			$this->var->add_def_cols('poliza_dui','varchar');
		}	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//if($_SESSION["ss_id_usuario"]==71){echo $this->query; exit;}
		
		return $res;
	}

	function ListarDocumentoReten($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_retencion,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_DOCRETEN_SEL'";

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
		$this->var->add_param($id_periodo_subsis);
		$this->var->add_param($id_moneda);
		$this->var->add_param($sw_retencion);
		$this->var->add_param("'$id_depto'");
		$this->var->add_param("'$tipo_documento'");
		
		$this->var->add_def_cols('desc_comprobante','text');
		$this->var->add_def_cols('desc_plantilla','varchar');
		$this->var->add_def_cols('razon_social','text');
		$this->var->add_def_cols('fecha_reporte','text');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('importe_iue','numeric');
		$this->var->add_def_cols('importe_it','numeric');
		$this->var->add_def_cols('importe_credito','numeric');
		$this->var->add_def_cols('importe_neto','numeric');
		$this->var->add_def_cols('id_documento','bigint');
		$this->var->add_def_cols('fecha_documento','date');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroDocumento
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_DOCIVA_COUNT'";

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
		/*$this->var->add_param("'$fecha_inicio'");//id_programa
		$this->var->add_param("'$fecha_fin'");//id_proyecto*/
		$this->var->add_param($id_periodo_subsis);//id_periodo
		$this->var->add_param($id_moneda);//id_actividad
		$this->var->add_param($sw_debito_credito);//
		$this->var->add_param("'$id_depto'");//
		$this->var->add_param("'$tipo_documento'");//$id_depto
		
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{	$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function ListarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_IVATOT_SEL'";

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
		$this->var->add_param($id_periodo_subsis);//id_periodo
		$this->var->add_param($id_moneda);//id_actividad
		$this->var->add_param($sw_debito_credito);//id_actividad
		$this->var->add_param("'$id_depto'");//$id_depto
		$this->var->add_param("'$tipo_documento'");//$id_depto
		
		$this->var->add_def_cols('fecha_documento_reporte','text');//fecha_documento 0
		$this->var->add_def_cols('nro_nit','text');//nro_nit  1
		$this->var->add_def_cols('razon_social','varchar');//razon_social   6
        $this->var->add_def_cols('nro_documento','text');//nro_documento  3
        $this->var->add_def_cols('nro_autorizacion','text');//nro_autorizacion  4
        $this->var->add_def_cols('codigo_control','text');//codigo_control   5	
		$this->var->add_def_cols('importe_total','numeric');//importe_total   7
		$this->var->add_def_cols('importe_ice','numeric');//importe_ice   8
		$this->var->add_def_cols('importe_no_gravado','numeric');//importe_no_gravado   9
		$this->var->add_def_cols('importe_sujeto','numeric');//importe_sujeto   10
		$this->var->add_def_cols('importe_credito','numeric');//importe_credito  11
		$this->var->add_def_cols('importe_debito','numeric');//importe_credito   12
		$this->var->add_def_cols('desc_comprobante','text');//nro_cbte  0
		$this->var->add_def_cols('id_documento','text');//importe_credito   12	
		$this->var->add_def_cols('fecha_documento','text');//fecha_documento 0
		$this->var->add_def_cols('importe_neto','numeric');//fecha_documento 0
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ListarDocumentoRetenTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_retencion,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_RETENTOT_SEL'";

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
		$this->var->add_param($id_periodo_subsis);
		$this->var->add_param($id_moneda);
		$this->var->add_param($sw_retencion);
		$this->var->add_param("'$id_depto'");
		$this->var->add_param("'$tipo_documento'");
		
		$this->var->add_def_cols('desc_comprobante','text');
		$this->var->add_def_cols('desc_plantilla','text');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('fecha_reporte','text');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('importe_iue','numeric');
		$this->var->add_def_cols('importe_it','numeric');
		$this->var->add_def_cols('importe_credito','numeric');
		$this->var->add_def_cols('importe_neto','numeric');
		$this->var->add_def_cols('id_documento','text');
		$this->var->add_def_cols('fecha_documento','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroDocumento
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ContarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_IVATOT_COUNT'";

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
		/*$this->var->add_param("'$fecha_inicio'");//id_programa
		$this->var->add_param("'$fecha_fin'");//id_proyecto*/
		$this->var->add_param($id_periodo_subsis);//id_periodo
		$this->var->add_param($id_moneda);//id_actividad
		$this->var->add_param($sw_debito_credito);//
		$this->var->add_param("'$id_depto'");//
		$this->var->add_param("'$tipo_documento'");//$id_depto
		
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{	$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function ListarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_DOCNIT_SEL'";
	
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
		$this->var->add_def_cols('nro_reg','Integer');
		$this->var->add_def_cols('nro_nit','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*	echo $this->query;
			exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroDocumento
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ContarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_DOCNIT_COUNT'";
	
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
	
	function ListarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_DOCNITD_SEL'";
	
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
		$this->var->add_def_cols('id_documento','Integer');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('sw_lcv','varchar');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*	echo $this->query;
		 exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroDocumento
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ContarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_DOCNITD_COUNT'";
	
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
	 * Nombre de la función:	InsertarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iud';
		$this->codigo_procedimiento = "'CT_REGDOC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_transaccion);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$poliza_dui'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param($tipo_retencion);

		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_credito);
		$this->var->add_param($importe_debito);
		$this->var->add_param($importe_ice);
		$this->var->add_param($importe_it);
		$this->var->add_param($importe_iue);
		$this->var->add_param($importe_sujeto);
		$this->var->add_param($importe_total);
		$this->var->add_param($importe_no_gravado);
		$this->var->add_param($estado_documento);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		 //echo  $this->query, exit();
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarDocumento
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function InsertarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo,$fecha_ini,$fecha_fin,$sw_viatico,$id_tipo_destino,$id_cobertura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_doc_descargo_iud';
		$this->codigo_procedimiento = "'CT_DOCUME_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($tipo_documento);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_avance);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param($id_tabla);
		$this->var->add_param($importe_ice);
		$this->var->add_param($importe_exento);
		$this->var->add_param($id_plan_pago);
		
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");
		
		$this->var->add_param("$sw_viatico");
		$this->var->add_param("$id_tipo_destino");
		$this->var->add_param("$id_cobertura");
		//Ejecuta la función
		
		
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iud';
		$this->codigo_procedimiento = "'CT_REGDOC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_transaccion);
		$this->var->add_param($tipo_documento);
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$poliza_dui'");
		$this->var->add_param("'$formulario'");
		$this->var->add_param($tipo_retencion);

		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_credito);
		$this->var->add_param($importe_debito);
		$this->var->add_param($importe_ice);
		$this->var->add_param($importe_it);
		$this->var->add_param($importe_iue);
		$this->var->add_param($importe_sujeto);
		$this->var->add_param($importe_total);
		$this->var->add_param($importe_no_gravado);
		$this->var->add_param($estado_documento);
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	 //echo  $this->query, exit();
		return $res;
	}
	 /**
	 * Nombre de la función:	EliminarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	
	function ModificarCabeceraDocumento($id_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iud';
		$this->codigo_procedimiento = "'CT_CABDOC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param($id_documento);
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param($nro_documento);
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$poliza_dui'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ModificarDocsNit($id_documento,$nro_nit,$razon_social,$sw_lcv)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iud';
		$this->codigo_procedimiento = "'CT_DOCNIT_UPD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
	
		$this->var->add_param($id_documento);
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$sw_lcv'");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
		$this->var->add_param("null");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRegistroDocumento
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function EliminarRegistroDocumento($id_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iud';
		$this->codigo_procedimiento = "'CT_REGDOC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_documento);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ListarDocumentoImporte
	 * Propósito:				Despliega datos del documento con el importe en la moneda principal
	 * Autor:				    RCM
	 * Fecha de creación:		13/02/2009
	 */
	function ListarDocumentoImporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_sel';
		$this->codigo_procedimiento = "'CT_DOCUME_SEL'";

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
		$this->var->add_def_cols('id_documento','integer');
		$this->var->add_def_cols('id_transaccion','integer');
		$this->var->add_def_cols('tipo_documento','numeric');
		$this->var->add_def_cols('nro_documento','bigint');
		$this->var->add_def_cols('fecha_documento','text');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nro_nit','varchar');
		$this->var->add_def_cols('nro_autorizacion','varchar');
		$this->var->add_def_cols('codigo_control','varchar');
		$this->var->add_def_cols('poliza_dui','varchar');
		$this->var->add_def_cols('formulario','varchar');
		$this->var->add_def_cols('tipo_retencion','numeric');
		$this->var->add_def_cols('estado_documento','integer');
		$this->var->add_def_cols('importe_total','numeric');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_ice','numeric');
		$this->var->add_def_cols('importe_exento','numeric');
		$this->var->add_def_cols('tipo','numeric');



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
	 * Nombre de la función:	EliminarDocumento
	 * Propósito:				Eliminar Documento
	 * Autor:				    RCM
	 * Fecha de creación:		16/02/2009
	 */
	function EliminarDocumento($id_documento,$nombre_tabla,$nombre_campo,$id_tabla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_doc_descargo_iud';
		$this->codigo_procedimiento = "'CT_DOCUME_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_documento");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param($id_tabla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_plan_pago
		
		$this->var->add_param("NULL");//id_presupuesto
		$this->var->add_param("NULL");//id_concepto_ingas
		$this->var->add_param("NULL");//id_orden_trabajo
		$this->var->add_param("NULL");//fecha_ini
		$this->var->add_param("NULL");//fecha_fin
		
		$this->var->add_param("NULL");//sw_viaticos
		$this->var->add_param("NULL");//id_tipo_destino
		$this->var->add_param("NULL");//id_cobertura
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

//		echo $this->query;
//		exit;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDocumento
	 * Propósito:				Modificar Documento
	 * Autor:				    RCM
	 * Fecha de creación:		18/02/2009
	 */
	function ModificarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_doc_descargo_iud';
		$this->codigo_procedimiento = "'CT_DOCUME_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_documento");
		$this->var->add_param("$tipo_documento");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("$importe_avance");
		$this->var->add_param("$nro_documento");
		$this->var->add_param("'$fecha_documento'");
		$this->var->add_param("'$razon_social'");
		$this->var->add_param("'$nro_nit'");
		$this->var->add_param("'$nro_autorizacion'");
		$this->var->add_param("'$codigo_control'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$nombre_campo'");
		$this->var->add_param($id_tabla);
		$this->var->add_param($importe_ice);
		$this->var->add_param($importe_exento);
		$this->var->add_param($id_plan_pago);
		
		$this->var->add_param($id_presupuesto);
		$this->var->add_param($id_concepto_ingas);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param("NULL");//fecha_ini
		$this->var->add_param("NULL");//fecha_fin
		
		$this->var->add_param("NULL");//sw_viaticos
		$this->var->add_param("NULL");//id_tipo_destino
		$this->var->add_param("NULL");//id_cobertura
		
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
	 * Nombre de la función:	ListarCabLibroCompraVenta
	 * Propósito:				Desplegar los registros de tct_documento
	 * Autor:				    avq
	 * Fecha de creación:		29/09/2010
	 */
	function ListarCabLibroCompraVenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_periodo_subsis,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_iva_sel';
		$this->codigo_procedimiento = "'CT_DOCIVACAB_SEL'";

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
		$this->var->add_param($id_periodo_subsis);//id_periodo
		$this->var->add_param($id_moneda);//id_actividad
		$this->var->add_param($sw_debito_credito);//id_actividad
		$this->var->add_param("'$id_depto'");//$id_depto
		$this->var->add_param("'$tipo_documento'");//$id_depto
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_sucursal','Integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('razon_social','varchar');
		$this->var->add_def_cols('nit','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('nombre_resp','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();
		return $res;
	}
	

	/**
	 * Nombre de la función:	ValidarRegistroDocumento
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_documento
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:13
	 */
	function ValidarRegistroDocumento($operacion_sql,$id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion)
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
				//Validar id_documento - tipo Integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_documento");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_transaccion - tipo Integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transaccion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion", $id_transaccion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_documento - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_documento");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_documento", $tipo_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_documento - tipo Integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_documento", $nro_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_documento - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_documento", $fecha_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar razon_social - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("razon_social");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "razon_social", $razon_social))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_nit - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_nit");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_nit", $nro_nit))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_autorizacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_autorizacion");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nro_autorizacion", $nro_autorizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_control - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_control");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_control", $codigo_control))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar poliza_dui - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("poliza_dui");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "poliza_dui", $poliza_dui))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar formulario - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("formulario");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "formulario", $formulario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_retencion - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_retencion");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_retencion", $tipo_retencion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_documento - tipo Integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
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

	function ValidarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento){
		if($importe_ice+$importe_exento>=$importe_avance){
			$this->salida[0] = "f";
			$this->salida[1] = "El ICE y el Exento no deben superar al Importe Total";
			$this->salida[2] = "ORIGEN = cls_DBDocumento";
			$this->salida[3] = "PROC = ValidarDocumento";
			$this->salida[4] = "NIVEL = 3";
			return false;
		}

		//Validación exitosa
		return true;
	}
	
	///documentos Respaldo///
/**
	 * Nombre de la función:	ActionListarDocumentoRespaldo
	 * Propósito:				lista los registros de tct_documento
	 * Autor:				    williams Escobar
	 * Fecha de creación:		2011-02-07 17:30:13
	 */
	function ActionListarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_tipo_plantilla)
	{
	  $this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_respaldo_sel';
		$this->codigo_procedimiento = "'CT_DOCRESPALDO_SEL'";

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
		$this->var->add_param("'$id_departamento'");//id_departamento
		$this->var->add_param($id_gestion);//id_gestion
		$this->var->add_param($id_periodo);//id_periodo
		$this->var->add_param($id_moneda);//$id_moneda
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$id_tipo_plantilla'");//$id_tipo_planilla
		
		
		$this->var->add_def_cols('fecha_documento_reporte','text');//fecha_documento 0
		$this->var->add_def_cols('nro_nit','varchar');//nro_nit  1
		$this->var->add_def_cols('razon_social','text');//razon_social   6
        $this->var->add_def_cols('nro_documento','bigint');//nro_documento  3
        $this->var->add_def_cols('nro_autorizacion','varchar');//nro_autorizacion  4
        $this->var->add_def_cols('codigo_control','varchar');//codigo_control   5
			
		$this->var->add_def_cols('importe_total','numeric');//importe_total   7
		$this->var->add_def_cols('importe_ice','numeric');//importe_ice   8
		$this->var->add_def_cols('importe_no_gravado','numeric');//importe_no_gravado   9
		$this->var->add_def_cols('importe_sujeto','numeric');//importe_sujeto   10
		$this->var->add_def_cols('importe_credito','numeric');//importe_credito  11
		$this->var->add_def_cols('importe_debito','numeric');//importe_credito   12
		$this->var->add_def_cols('desc_comprobante','text');//nro_cbte  0
		$this->var->add_def_cols('id_documento','bigint');//importe_credito   12	
		$this->var->add_def_cols('fecha_documento','date');//fecha_documento 0
		
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
	
//fin documentos respaldo
//contar ActionListarDocumentoRespaldo
/**
	 * Nombre de la función:	ContarDocumentoRespaldo
	 * Propósito:				Contar los registros de tct_documento
	 * Autor:				    williams Escobar
	 * Fecha de creación:		2011-02-07 17:30:13
	 */
	function ContarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_tipo_plantilla)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_documento_respaldo_sel';
		$this->codigo_procedimiento = "'CT_DOCRESPALDO_COUNT'";

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
		$this->var->add_param("'$id_departamento'");//id_departamento
		$this->var->add_param($id_gestion);//id_periodo
		$this->var->add_param($id_periodo);//id_gestion
		$this->var->add_param($id_moneda);//$id_moneda
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$id_tipo_plantilla'");//$id_tipo_planilla
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
          
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{	$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
//fin ActionListarDocumentoRespaldo 
	

}?>
