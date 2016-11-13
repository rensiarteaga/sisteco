<?php
/**
 * Nombre de la clase:	cls_DBSolicitudCompraDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_solicitud_compra_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-16 09:53:31
 */

 
class cls_DBSolicitudCompraDet
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
	
	/**ListarSolicitudCompraDet
	 * Nombre de la función:	ListarSolicitudCompraDet
	 * Propósito:				Desplegar los registros de tad_solicitud_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ListarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_SOLDET_SEL'";

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
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('id_item_antiguo','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio_referencial_estimado','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('fecha_inicio_serv','date');
		$this->var->add_def_cols('fecha_fin_serv','date');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('partida_presupuestaria','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('pac_verificado','varchar');
		$this->var->add_def_cols('id_solicitud_compra','int4');
		$this->var->add_def_cols('desc_solicitud_compra','int4');
		$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('desc_servicio','varchar');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('monto_aprobado','numeric');
		$this->var->add_def_cols('mat_bajo_responsabilidad','varchar');
		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('grupo','varchar');
		$this->var->add_def_cols('subgrupo','varchar');
		$this->var->add_def_cols('id1','varchar');
		$this->var->add_def_cols('id2','varchar');
		$this->var->add_def_cols('id3','varchar');
		$this->var->add_def_cols('tipo_servicio','varchar');
		$this->var->add_def_cols('item','varchar');
		$this->var->add_def_cols('abreviatura','varchar');
		//$this->var->add_def_cols('desc_empleado_tpm_frppa','text');
		$this->var->add_def_cols('num_solicitud','int4');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('precio_referencial_moneda_seleccionada','numeric');
		$this->var->add_def_cols('precio_total_moneda_seleccionada','numeric');
		$this->var->add_def_cols('precio_total_referencial','numeric');
		$this->var->add_def_cols('especificaciones_tecnicas','text');
		$this->var->add_def_cols('id_item_reformulado','int4');
		$this->var->add_def_cols('id_servicio_reformulado','int4');
		$this->var->add_def_cols('monto_ref_reformulado','numeric');
		$this->var->add_def_cols('reformular','varchar');
		$this->var->add_def_cols('desc_item_reformulado','text');
		$this->var->add_def_cols('desc_servicio_reformulado','text');
		
		$this->var->add_def_cols('id_cuenta','int4');
		$this->var->add_def_cols('desc_cuenta','varchar');
		$this->var->add_def_cols('id_partida','int4');
		$this->var->add_def_cols('codigo_partida','text');
		$this->var->add_def_cols('almacenable','varchar');
		$this->var->add_def_cols('descripcion_item','varchar');
		$this->var->add_def_cols('motivo_ref','text');
		$this->var->add_def_cols('id_unidad_medida_base','integer');
		$this->var->add_def_cols('precio_referencial_total_as','numeric');
		$this->var->add_def_cols('total_gestion','numeric');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('monto_ref_reformulado_as','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudCompraDet
	 * Propósito:				Contar los registros de tad_solicitud_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ContarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_SOLDET_COUNT'";

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
//		echo $this->query;
//		exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	
		/**
	 * Nombre de la función:	ListarSolicitudCompraDetGrup
	 * Propósito:				Desplegar los registros de tad_solicitud_compra_det
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ListarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_GRSOLDET_SEL'";

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
	
    $this->var->add_def_cols('id_solicitud_compra_det','int4');
	$this->var->add_def_cols('id_item_antiguo','int4');
	$this->var->add_def_cols('cantidad','numeric');
	$this->var->add_def_cols('precio_referencial_estimado','numeric');
	$this->var->add_def_cols('fecha_reg','date');
	$this->var->add_def_cols('fecha_inicio_serv','date');
	$this->var->add_def_cols('fecha_fin_serv','date');
	$this->var->add_def_cols('descripcion','varchar');
	$this->var->add_def_cols('partida_presupuestaria','varchar');
	$this->var->add_def_cols('estado_reg','varchar');
	$this->var->add_def_cols('pac_verificado','varchar');
	$this->var->add_def_cols('id_solicitud_compra','int4');
	$this->var->add_def_cols('id_servicio','int4');				
	$this->var->add_def_cols('id_item','int4');
	$this->var->add_def_cols('codigo_item','varchar');
	$this->var->add_def_cols('nombre_item','varchar');
	$this->var->add_def_cols('monto_aprobado','numeric');
	$this->var->add_def_cols('mat_bajo_responsabilidad','varchar');
	$this->var->add_def_cols('supergrupo','varchar');
	$this->var->add_def_cols('grupo','varchar');
	$this->var->add_def_cols('subgrupo','varchar');
	$this->var->add_def_cols('id1','varchar');
	$this->var->add_def_cols('id2','varchar');
	$this->var->add_def_cols('id3','varchar');
	$this->var->add_def_cols('tipo_servicio','varchar');
    $this->var->add_def_cols('nombre_unid_base','varchar');
    $this->var->add_def_cols('id_proceso_compra','int4');
    $this->var->add_def_cols('codigo_proceso','varchar');
    $this->var->add_def_cols('id_proceso_compra_det','int4');
    $this->var->add_def_cols('id_grupo_sp_det','int4');
    $this->var->add_def_cols('servicio','varchar');
    $this->var->add_def_cols('id_unidad_medida_base_serv','int4');    
    $this->var->add_def_cols('nombre_unid_base_serv','varchar');
        
        
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudCompraDetGrup
	 * Propósito:				Contar los registros de tad_solicitud_compra_det
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ContarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_GRSOLDET_COUNT'";

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
	
	/**Reporte de Solicitud Compra Detalle
	 * Nombre de la función:	ListarSolicitudCompraDet
	 * Propósito:				Desplegar los registros de tad_solicitud_compra_det
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-06-17 09:53:31
	 */
	function ReporteSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_RESODE_SEL'";

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
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','text');
	    $this->var->add_def_cols('cantidad','numeric');
	    $this->var->add_def_cols('abreviatura','varchar');
	    $this->var->add_def_cols('imputacion_contable','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	/**Reporte de Solicitud Compra Detalle
	 * Nombre de la función:	ListarSolicitudCompraDet
	 * Propósito:				Desplegar los registros de tad_solicitud_compra_det
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-06-17 09:53:31
	 */
	function ReporteVerificacionBien($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		if($id_financiador==1){
			$this->codigo_procedimiento = "'AD_VEDEBIREF_SEL'";
		}
		else{
			$this->codigo_procedimiento = "'AD_VEDEBI_SEL'";
		}

		//$id_financiador='';
		
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
		$this->var->add_param($id_financiador == 'null');//id_financiador
		$this->var->add_param($id_regional == 'null');//id_regional
		$this->var->add_param($id_programa == 'null');//id_programa
		$this->var->add_param($id_proyecto == 'null');//id_proyecto
		$this->var->add_param($id_actividad =='null');//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('unidad_medida','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio','numeric');
	    $this->var->add_def_cols('monto_ref','numeric');
	    $this->var->add_def_cols('monto_total','numeric');
	    $this->var->add_def_cols('reformular','varchar');
	    $this->var->add_def_cols('id_solicitud_compra_det','integer');
	    $this->var->add_def_cols('refo_item','varchar');
	    $this->var->add_def_cols('refo_monto','varchar');
	    $this->var->add_def_cols('motivo_ref','text');
	    
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	
	function ReporteVerificacionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		
		if($id_financiador==1){
			$this->codigo_procedimiento = "'AD_VEDESEREF_SEL'";
		}
		else{
			$this->codigo_procedimiento = "'AD_VEDESE_SEL'";
		}

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
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('unidad_medida','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio','numeric');
	    $this->var->add_def_cols('monto_ref','numeric');
	    $this->var->add_def_cols('monto_total','numeric');
	    $this->var->add_def_cols('reformular','varchar');
	    $this->var->add_def_cols('id_solicitud_compra_det','integer');
	    $this->var->add_def_cols('refo_item','varchar');
	    $this->var->add_def_cols('refo_monto','varchar');
	    $this->var->add_def_cols('motivo_ref','text');
	    
	    
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;exit;
		
		return $res;
	}
	
	
	
	function ReportePartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_PARDET_SEL'";

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
		$this->var->add_def_cols('codigo_partida','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
	    $this->var->add_def_cols('total','numeric');
	     $this->var->add_def_cols('total_as','numeric');
	    $this->var->add_def_cols('aprobado','varchar');
	     $this->var->add_def_cols('disponible','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	
	/**Reporte de Solicitud Compra Detalle
	 * Nombre de la función:	ListarSolicitudCompraDet
	 * Propósito:				Desplegar los registros de tad_solicitud_compra_det
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-06-17 09:53:31
	 */
	function ReporteSolicitudCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_sel';
		$this->codigo_procedimiento = "'AD_RESOSER_SEL'";

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
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','text');
	    $this->var->add_def_cols('cantidad','numeric');
	    $this->var->add_def_cols('abreviatura','text');
		 $this->var->add_def_cols('imputacion_contable','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSolicitudCompraDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_solicitud_compra_det
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function InsertarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_SOLDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		
		$this->var->add_param($id_item_antiguo);
		$this->var->add_param($cantidad);
		$this->var->add_param($precio_referencial_estimado);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$fecha_inicio_serv'");
		$this->var->add_param("'$fecha_fin_serv'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$partida_presupuestaria'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$pac_verificado'");
		$this->var->add_param($id_solicitud_compra);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item);
		$this->var->add_param($monto_aprobado);
		$this->var->add_param("'$mat_bajo_responsabilidad'");
		$this->var->add_param("'$especificaciones_tecnicas'");
		$this->var->add_param("'$almacenable'");
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param($id_empresa);//id_empresa(campo añadido 16-12-08)
		$this->var->add_param($id_unidad_medida_base);//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param($precio_total_as);//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSolicitudCompraDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_solicitud_compra_det
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ModificarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_SOLDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param($id_item_antiguo);
		$this->var->add_param($cantidad);
		$this->var->add_param($precio_referencial_estimado);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$fecha_inicio_serv'");
		$this->var->add_param("'$fecha_fin_serv'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$partida_presupuestaria'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$pac_verificado'");
		$this->var->add_param($id_solicitud_compra);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item);
		$this->var->add_param($monto_aprobado);
		$this->var->add_param("'$mat_bajo_responsabilidad'");
		$this->var->add_param("'$especificaciones_tecnicas'");
		$this->var->add_param("'$almacenable'");
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param($id_empresa);//id_empresa(campo añadido 16-12-08)
		$this->var->add_param($id_unidad_medida_base);//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param($precio_total_as);//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ModificarDetalleSeguimientoSolicitud($id_solicitud_compra_det,$partida_presupuestaria,$pac_verificado,$monto_aprobado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_PREDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param("'$pac_verificado'");
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param('NULL');
		$this->var->add_param($monto_aprobado);
		$this->var->add_param('NULL');
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//almacenable (campo añadido 22-08)
		$this->var->add_param("$partida_presupuestaria");//id_partida (campo añadido 25-08)
		$this->var->add_param("NULL");//id_empresa(campo añadido 16-12-08)
		$this->var->add_param("NULL");//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param("NULL");//precio_total_as(campo añadido 29/04/08)

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function AprobarRefCompraDet($id_solicitud_compra_det,$reformular,$monto_reformulado,$motivo_ref,$monto_ref_reformulado_as)
	{// echo $monto_reformulado;
//	exit;
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_APRREF_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$reformular'");//estado_reg
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$monto_reformulado");
		$this->var->add_param("NULL");
		$this->var->add_param("'$motivo_ref'");//en vez de especificaciones tecnicas
		$this->var->add_param("NULL");//almacenable (campo añadido 22-08)
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param("NULL");//id_empresa(campo añadido 16-12-08)
		$this->var->add_param("NULL");//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param($monto_ref_reformulado_as);//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit();
	return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSolicitudCompraDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_solicitud_compra_det
	 * Autor:				    Mercedes Zambrana Meneses
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function EliminarSolicitudCompraDet($id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_SOLDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
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
		$this->var->add_param("NULL");//almacenable (campo añadido 22-08)
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param("NULL");//id_empresa(campo añadido 16-12-08)
		$this->var->add_param("NULL");//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param("NULL");//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function AnularSolicitudCompraDet($id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_ANSDET_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
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
		$this->var->add_param("NULL");//almacenable (campo añadido 22-08)
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param("NULL");//id_empresa(campo añadido 16-12-08)
		$this->var->add_param("NULL");//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param("NULL");//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function AprobarVerificacionReformulacion($id_solicitud_compra_det,$reformular)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitud_compra_det_iud';
		$this->codigo_procedimiento = "'AD_VERREF_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$reformular'");//estado_reg
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//almacenable (campo añadido 22-08)
		$this->var->add_param("NULL");//id_partida (campo añadido 25-08)
		$this->var->add_param("NULL");//id_empresa(campo añadido 16-12-08)
		$this->var->add_param("NULL");//id_unidad_medida_base(campo añadido 09/04/08)
		$this->var->add_param("NULL");//precio_total_as(campo añadido 29/04/08)
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarSolicitudCompraDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_solicitud_compra_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-16 09:53:31
	 */
	function ValidarSolicitudCompraDet($operacion_sql,$id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad)
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
				//Validar id_solicitud_compra_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_solicitud_compra_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_compra_det", $id_solicitud_compra_det))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_item_antiguo - tipo int4
		/*	$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item_antiguo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_antiguo", $id_item_antiguo))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar cantidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio_referencial_estimado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio_referencial_estimado");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio_referencial_estimado", $precio_referencial_estimado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_inicio_serv - tipo date
		/*	$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio_serv");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio_serv", $fecha_inicio_serv))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_fin_serv - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_fin_serv");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin_serv", $fecha_fin_serv))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(500);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar partida_presupuestaria - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("partida_presupuestaria");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "partida_presupuestaria", $partida_presupuestaria))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pac_verificado - tipo varchar
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pac_verificado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pac_verificado", $pac_verificado))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_solicitud_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_solicitud_compra");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_compra", $id_solicitud_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_servicio - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_servicio");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio", $id_servicio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar monto_aprobado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("monto_aprobado");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto_aprobado", $monto_aprobado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar mat_bajo_responsabilidad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mat_bajo_responsabilidad");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "mat_bajo_responsabilidad", $mat_bajo_responsabilidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar pac_verificado
			$check = array ("si","no");
			if(!in_array($pac_verificado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'pac_verificado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSolicitudCompraDet";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}*/
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_solicitud_compra_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_solicitud_compra_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_solicitud_compra_det", $id_solicitud_compra_det))
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