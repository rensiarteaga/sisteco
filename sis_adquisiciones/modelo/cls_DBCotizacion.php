<?php
/**
 * Nombre de la clase:	cls_DBCotizacion.php
 * Propï¿½sito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_cotizacion
 * Autor:				(autogenerado)
 * Fecha creaciï¿½n:		2008-05-28 16:58:40
 */

 
class cls_DBCotizacion
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
	 * Nombre de la funciï¿½n:	ListarCotizacion
	 * Propï¿½sito:				Desplegar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ListarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTIZA_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('fecha_venc','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('garantia','varchar');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('forma_pago','varchar');
		$this->var->add_def_cols('tiempo_validez_oferta','varchar');
		$this->var->add_def_cols('fecha_entrega','date');
		$this->var->add_def_cols('tipo_entrega','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('id_proceso_compra','int4');
		//$this->var->add_def_cols('desc_proceso_compra','text');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		//$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('figura_acta','varchar');
		//$this->var->add_def_cols('num_factura','int4');
		$this->var->add_def_cols('num_factura','bigint');
		
		$this->var->add_def_cols('num_orden_compra','int4');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('nombre_pago','varchar');
		$this->var->add_def_cols('siguiente_estado','varchar');
		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		//$this->var->add_def_cols('num_orden_compra_sis','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('fecha_orden_compra','date');
		$this->var->add_def_cols('direccion_proveedor','text');
		$this->var->add_def_cols('mail_proveedor','text');
		$this->var->add_def_cols('telefono1_proveedor','text');
		$this->var->add_def_cols('telefono2_proveedor','text');
		$this->var->add_def_cols('fax_proveedor','text');
		$this->var->add_def_cols('fecha_cotizacion','date');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('num_pagos','int4');
		$this->var->add_def_cols('precio_total_moneda_cotizada','numeric');
		$this->var->add_def_cols('num_detalle_cotizado','bigint');
		$this->var->add_def_cols('todo_pagado','numeric');
		//$this->var->add_def_cols('falta_anular','bigint');
		$this->var->add_def_cols('id_moneda_base','int4');
		//$this->var->add_def_cols('num_detalle_cotizado_gral','bigint');
		$this->var->add_def_cols('num_detalle_adjudicado_gral','numeric');
		$this->var->add_def_cols('precio_total_adjudicado','numeric');
		$this->var->add_def_cols('se_adjudica','varchar');
		$this->var->add_def_cols('num_detalle_adjudicado','bigint');
		$this->var->add_def_cols('id_auxiliar','bigint');
		//$this->var->add_def_cols('pago_completado','int4');
		$this->var->add_def_cols('cantidad_sol','numeric');
		//$this->var->add_def_cols('cant_se_adjudica','bigint');
		$this->var->add_def_cols('factura_total','varchar');
		//$this->var->add_def_cols('num_autoriza_factura','numeric');
		//$this->var->add_def_cols('cod_control_factura','varchar');
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('precio_total_adjudicado_con_impuestos','numeric');
		$this->var->add_def_cols('tipo_documento','integer');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('falta_adjudicar','numeric');
		$this->var->add_def_cols('id_empleado_adjudicacion','int4');
		$this->var->add_def_cols('empleado_adjudicacion','text');
		$this->var->add_def_cols('justificacion_adjudicacion','text');
		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('avance','varchar');
		$this->var->add_def_cols('id_depto_tesoro','int4');
		$this->var->add_def_cols('depto_tesoro','text');
		$this->var->add_def_cols('cant_pagos_def','bigint');
		$this->var->add_def_cols('habilita_otra_gestion','text');
		$this->var->add_def_cols('por_adelanto','numeric');
		$this->var->add_def_cols('por_retgar','numeric');
		$this->var->add_def_cols('estado_adelanto','varchar');
		$this->var->add_def_cols('estado_retgar','varchar');
		$this->var->add_def_cols('avance_habilitado','int4');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('tiene_contrato','numeric');
		$this->var->add_def_cols('monto_adelanto','numeric');
		$this->var->add_def_cols('monto_adelanto_moneda_cotizada','numeric');
		$this->var->add_def_cols('total_cotizado','numeric');
		
		$this->var->add_def_cols('con_contrato','varchar');
		$this->var->add_def_cols('total_aa','numeric');
		$this->var->add_def_cols('total_as','numeric');
		$this->var->add_def_cols('total_dcto_anticipo','numeric');
		$this->var->add_def_cols('fecha_ini_ctto','date');
		$this->var->add_def_cols('fecha_fin_ctto','date');
		
		$this->var->add_def_cols('hora_reg','time');
		$this->var->add_def_cols('usuario_reg','text');
		$this->var->add_def_cols('estado_devengado','varchar');
		$this->var->add_def_cols('fecha_adjudicacion','date');
		//5jun2015
		$this->var->add_def_cols('tiene_anticipo','varchar');
		$this->var->add_def_cols('anticipo_con_ejecucion','varchar');
		
		$this->var->add_def_cols('es_item','integer');
		
		//Ago2015
		$this->var->add_def_cols('es_ampliacion','varchar');
		$this->var->add_def_cols('id_cotizacion_ampliacion','integer');
		$this->var->add_def_cols('desc_cotizacion_ampliacion','varchar');
		//adicionado 16082016: REQ16082016092652 de Ronald Coronel
		//$this->var->add_def_cols('num_sol_por_proc','varchar');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//		echo  $this->query;
//		exit;
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ListarCotizacion
	 * Propï¿½sito:				Desplegar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ListarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTIAF_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre','varchar');
		//$this->var->add_def_cols('num_factura','integer');
		$this->var->add_def_cols('num_factura','bigint');
		$this->var->add_def_cols('fecha_orden_compra','date');
		$this->var->add_def_cols('precio_total_adjudicado','numeric');
		$this->var->add_def_cols('oc_completo','text');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//		echo  $this->query;
//		exit;
		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ContarCotizacion
	 * Propï¿½sito:				Contar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ContarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTIAF_COUNT'";

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

		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	
	
	function ListarAperturaOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_OFEREP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
		$this->var->add_def_cols('proponente','text');
		$this->var->add_def_cols('validez','text');
		$this->var->add_def_cols('formulario','text');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('plazo','text');
		$this->var->add_def_cols('observaciones','text');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	function ListarCabeceraApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_OFECAB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('convocatoria','varchar');
		$this->var->add_def_cols('objeto','varchar');
		$this->var->add_def_cols('precio','numeric');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ContarCotizacion
	 * Propï¿½sito:				Contar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTIZA_COUNT'";

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
//echo $this->query;
//exit;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	
	function VerificarDevengado($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_VERDEV_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $id_cotizacion;//para mandar el id_caja_regis como entero
		$this->var->puntero =0;
		$this->var->sortcol = "'id_cotizacion'";
		$this->var->sortdir = "'asc'";
		$this->var->criterio_filtro = "'0=0'";
		
		$id_financiador='';
		$id_regional='';
		$id_programa='';
		$id_proyecto='';
		$id_actividad='';
		
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));
		


		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('resultado','integer');
		$this->var->add_def_cols('mensaje','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('moneda','varchar');
		

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query; exit;
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	InsertarCotizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de inserciï¿½n de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function InsertarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra, $id_empresa,$retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTIZA_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_venc'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$impuestos'");
		$this->var->add_param("'$garantia'");
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$tiempo_validez_oferta'");
		$this->var->add_param("'$fecha_entrega'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("'$tipo_entrega'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($precio_total);
		$this->var->add_param("'$figura_acta'");
		$this->var->add_param("'$num_factura'");
		$this->var->add_param($num_orden_compra);
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param($num_orden_compra_sis);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param("'$fecha_orden_compra'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param($id_empresa);//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ModificarCotizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ModificarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra,$id_empresa,$fecha_cotizacion,$retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTIZA_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$fecha_venc'");
		$this->var->add_param("'$fecha_reg'");
		
		$this->var->add_param("'$impuestos'");
		$this->var->add_param("'$garantia'");
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$tiempo_validez_oferta'");
		$this->var->add_param("'$fecha_entrega'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("'$tipo_entrega'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($precio_total);
		$this->var->add_param("'$figura_acta'");
		$this->var->add_param("'$num_factura'");
		$this->var->add_param($num_orden_compra);
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param($num_orden_compra_sis);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param("'$fecha_orden_compra'");
		$this->var->add_param("'$fecha_cotizacion'");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param($id_empresa);//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	EliminarCotizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function EliminarCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTIZA_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
				$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	EliminarCotizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de eliminaciï¿½n de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function RevertirRendicion($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTREVCD_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
			$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_cotizacion
	 * @return unknown
	 */
	function TerminarCotizacion($id_cotizacion,$retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTTER_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
				$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	
	/**
	 * ModificarEstadoCotizacion
	 *
	 * @param unknown_type $id_cotizacion
	 * @return unknown
	 */
	function ModificarEstadoCotizacion($id_proceso_compra,$id_cotizacion,$figura_acta,$observaciones_acta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_MODCOT_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");//fecha_venc
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//impuestos
		$this->var->add_param("NULL");//garantia
		$this->var->add_param("NULL");//lugar_entrega
		$this->var->add_param("NULL");//forma_pago
		$this->var->add_param("NULL");//tiempo_validez_oferta
		$this->var->add_param("NULL");//fecha_entrega
		$this->var->add_param("NULL");//tipo_entrega
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_proveedor
		$this->var->add_param("NULL");//id_tipo_categoria_adq
		$this->var->add_param("NULL");//precio_total
		$this->var->add_param("NULL");//figura_acta
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//num_orden_compra
		$this->var->add_param("NULL");//estado_vigente
		$this->var->add_param("NULL");//estado_reg
		$this->var->add_param("NULL");//nombre_pago
		$this->var->add_param("NULL");//siguiente_estado
		$this->var->add_param("NULL");//periodo
		$this->var->add_param("NULL");//gestion
		$this->var->add_param("NULL");//num_orden_compra_sis
		$this->var->add_param("NULL");//num_cotizacion
		$this->var->add_param("NULL");//fecha_orden_compra
		$this->var->add_param("NULL");//fecha_cotizacion
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("'$figura_acta'");//se_adjudica
		$this->var->add_param("'$observaciones_acta'");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
        $this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	function FinalizarCotizacionAdj($id_cotizacion,$fecha_adjudicacion,$id_proceso_compra,$estado_vigente,$id_empleado_adjudicacion,$justificacion_adjudicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTADJ_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$fecha_adjudicacion'");//fecha_venc
		$this->var->add_param("NULL");//$fecha_reg
		$this->var->add_param("NULL");//$impuestos
		$this->var->add_param("NULL");//$garantia
		$this->var->add_param("NULL");//$lugar_entrega
		$this->var->add_param("NULL");//$forma_pago
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("NULL");//$fecha_entrega
		
		$this->var->add_param("NULL");//$tipo_entrega
		//$this->var->add_param("'$observaciones'");//$observaciones
		$this->var->add_param("NULL");//$observaciones 22/04/2010
		$this->var->add_param($id_proceso_compra);//
		$this->var->add_param("NULL");//$id_moneda
		$this->var->add_param("NULL");//$id_proveedor
		$this->var->add_param("NULL");//$id_tipo_categoria_adq
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//$figura_acta
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param("NULL");//$estado_reg
		$this->var->add_param("NULL");//$nombre_pago
		$this->var->add_param("NULL");//$siguiente_estado
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("NULL");//$fecha_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param($id_empleado_adjudicacion);//$id_empleado_adjudicacion
		$this->var->add_param("'$justificacion_adjudicacion'");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/*Autor: Ana Maria Villegas Quispe
	* Fecha ultima de modificación: 20/07/2009
	* Descripción ultima: Se añadió los atributos, forma_de_pago, garantia, moneda, lugar de entrega, tiempo de validez de oferta
	*/
	function ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_REPCOT_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('num_cotizacion','text');
		$this->var->add_def_cols('nombres','text');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('gestion','integer');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('fecha_venc','date');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');
		$this->var->add_def_cols('tiempo_validez_oferta','varchar');
		$this->var->add_def_cols('garantia','varchar');
		$this->var->add_def_cols('forma_pago','varchar');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('fecha_cotizacion','date');//04-12-2013 Adecuacion a RE-SABS 2013
		$this->var->add_def_cols('doc_id','varchar');//04-12-2013 Adecuacion a RE-SABS 2013
		$this->var->add_def_cols('es_item','integer');//jun2015 CI-DEEM
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
   	/*echo $this->query;
		exit;
		*/
		return $res;
	}
	function ReporteCotizacionSC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_REPCOT1_SEL'";

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
		/*$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
		*/
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('num_cotizacion','text');
		/*$this->var->add_def_cols('nombres','text');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('direccion','varchar');
		*/
		$this->var->add_def_cols('gestion','integer');
		$this->var->add_def_cols('tipo_adq','varchar');
		/*$this->var->add_def_cols('fecha_venc','date');
		$this->var->add_def_cols('lugar_entrega','varchar');
		*/
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
    	/*echo $this->query;
		exit;*/
		
		return $res;
	}
	function ReporteOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_REPORD_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('num_cotizacion','text');
		$this->var->add_def_cols('nombres','text');
		$this->var->add_def_cols('casilla','varchar');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('celular1','varchar');
		$this->var->add_def_cols('celular2','varchar');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('email2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('direccion','varchar');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('forma_pago','varchar');
		$this->var->add_def_cols('fecha_entrega','date');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('precio_total_literal','text');
		//$this->var->add_def_cols('imputacion_contable','varchar');
		$this->var->add_def_cols('dias','integer');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');
		$this->var->add_def_cols('nro_generacion_oc','integer');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('num_proceso','text');
		//08.2014 en atencion a nota ENDE-CI-UADM-8/2-14
		$this->var->add_def_cols('justificacion_adjudicacion','text');
		//jun2015
		$this->var->add_def_cols('es_item','integer');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
/*echo $this->query;
		exit;*/
				return $res;
	}
	function RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_CUCOCA_SEL'";

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
		$this->var->add_def_cols('num_solicitud','text');
		$this->var->add_def_cols('fecha_hoy','date');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('nro_proceso','text');
		$this->var->add_def_cols('observaciones_adjudicacion','text');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}

	function ReporteCotizacion1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_CUACOM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		//$this->var->cant = $cant;
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
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('cantidad_cot','numeric');
		$this->var->add_def_cols('id_proceso_compra_det','integer');
		$this->var->add_def_cols('observaciones_det','text');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		 
		return $res;
	}
function RepCuaComServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_CUACOMSE_SEL'";

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
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('precio_total','numeric');
		//$this->var->add_def_cols('id_cotizacion_det','integer');
		$this->var->add_def_cols('cantidad_cot','numeric');
		$this->var->add_def_cols('id_proceso_compra_det','integer');
		$this->var->add_def_cols('observaciones_det','text');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
	
		return $res;
	}
	

	//////////////////////////////////////////////////reporte para el cuadro comparativo ////////////////////////////////////
	function RepProveedoresCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAPROV_SEL'";

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
        $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('nombres','text');
		$this->var->add_def_cols('representantes','text');
		$this->var->add_def_cols('precio_total_cotizacion','numeric');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('porcentaje','numeric');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	function RepItemCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAITE_SEL'";

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
        $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item_aprobado','int4');
		//$this->var->add_def_cols('nombres','text');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	function RepTotalItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUATOT_SEL'";

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
        $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('precio_total','numeric');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;
	*/
		return $res;
	}
	
	
	function RepPlazoCot($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAPLA_SEL'";

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
        $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('fecha_entrega','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;
	*/
		return $res;
	}
	function RepLugarEnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUALUG_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('lugar_entrega','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
	
		return $res;
	}
	function RepFormaPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAFORM_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('forma_pago','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	
	function RepTiemVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUATIE_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('tiempo_validez_oferta','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	function RepGarantia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAGAR_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('garantia','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	
	function RepObservaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_CUAOBS_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('observaciones','text');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
	
		return $res;
	}
	/////////////////hasta aqui para el reporte de cuadro comparativo
	////////////////Aqui el reporte para acta de apertura /////////////////
	function RepActaApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_RACAPE_SEL'";

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
       $this->var->add_param('NULL');//id_actividad
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('num_convocatoria','int4');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('literal_precio_total','varchar');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('observaciones_acta','text');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/*****************************REPORTE: MEMORANDUM SOLICITUD DE PAGO A PROVEEDDOR******************************/
	function RepSolicitudPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_SOLPAG_SEL'";

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
		$this->var->add_param($id_plan_pago);//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('proveedor','text');
		$this->var->add_def_cols('codigo_proceso','text');
		$this->var->add_def_cols('solicitante','text');
		$this->var->add_def_cols('unidad_organizacional','text');
		$this->var->add_def_cols('descripcion_sol','text');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('monto_no_pagado','numeric');
		$this->var->add_def_cols('forma_pago','text');
		//$this->var->add_def_cols('num_factura','int4');
		$this->var->add_def_cols('num_factura','bigint');
		$this->var->add_def_cols('lugar_entrega','text');
		$this->var->add_def_cols('nivel_aprobacion','text');
		$this->var->add_def_cols('descrip','text');
		$this->var->add_def_cols('monto_literal','varchar');
		$this->var->add_def_cols('num_proceso','text');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('gestion','integer');
		
		$this->var->add_def_cols('jefe_depto_bienes','text');
		$this->var->add_def_cols('cargo_depto_bienes','text');
		$this->var->add_def_cols('jefe_depto_contabilidad','text');
		$this->var->add_def_cols('cargo_depto_contabilidad','text');
		$this->var->add_def_cols('nro_cuota','integer');
		$this->var->add_def_cols('observaciones_pago','text');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('monto_sin_ret','numeric');
		$this->var->add_def_cols('impuestos','varchar');
		$this->var->add_def_cols('nro_sol','integer');
		$this->var->add_def_cols('periodo','numeric');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('multas','numeric');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('desc_anticipo','numeric');
		$this->var->add_def_cols('desc_garantia','numeric');
		$this->var->add_def_cols('fecha_devengado','text');
		$this->var->add_def_cols('pago_integrado','varchar');
		$this->var->add_def_cols('descuentos','numeric');
		//$this->var->add_def_cols('monto_no_pagado','numeric');
	//$this->var->add_def_cols('monto_original','numeric');
	
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('anticipo_con_ejecucion','varchar');
		$this->var->add_def_cols('porcentaje_anticipo','numeric');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit(); 
		return $res;
	}
	
	
	
	function RepSolicitudPagoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_SOLPADE_SEL'";

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
		$this->var->add_param($id_plan_pago);//id_actividad
			
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_plan_pago','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('monto_moneda_cotizada','numeric');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/***************************** ----fin ---- REPORTE: MEMORANDUM SOLICITUD DE PAGO A PROVEEDDOR******************************/
	
	
	

	
	function ModificarCotizacionProp($id_cotizacion,$impuestos, $garantia, $lugar_entrega, $forma_pago, $tiempo_validez_oferta, 
	$fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
	$precio_total, $figura_acta, $num_cotizacion,$fecha_cotizacion,$id_empresa,$fecha_recepcion_propuestas,$factura_total,$num_autoriza_factura,$cod_control_factura,$fecha_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_RECOPR_UPD'";  //registro de propuestas de cotizacion

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion); //
		$this->var->add_param("NULL");//'$fecha_venc'
		$this->var->add_param("NULL");//'$fecha_reg'
		$this->var->add_param("'$impuestos'"); //
		$this->var->add_param("'$garantia'"); //
		$this->var->add_param("'$lugar_entrega'"); //
		$this->var->add_param("'$forma_pago'"); //
		$this->var->add_param("'$tiempo_validez_oferta'");//
		$this->var->add_param("'$fecha_entrega'"); //
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("'$tipo_entrega'");//
		$this->var->add_param("'$observaciones'");//
		$this->var->add_param($id_proceso_compra); //
		$this->var->add_param($id_moneda);//
		$this->var->add_param($id_proveedor);//
		$this->var->add_param($id_tipo_categoria_adq);//
		$this->var->add_param($precio_total); //
		$this->var->add_param("'$figura_acta'"); //
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("NULL");//'$estado_vigente'
		$this->var->add_param("NULL");//'$estado_reg'
		$this->var->add_param("NULL");//'$nombre_pago'
		$this->var->add_param("NULL");//'$siguiente_estado'
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param($num_cotizacion);//
		$this->var->add_param("NULL");//'$fecha_orden_compra'
		$this->var->add_param("'$fecha_cotizacion'");//
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("'$factura_total'");//factura_total
		$this->var->add_param("$num_autoriza_factura");//num_autoriza_factura
		$this->var->add_param("'$cod_control_factura'");//cod_control_factura
		$this->var->add_param("'$fecha_factura'");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
/*echo $this->query;
exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ModificarCotizacionOrdenCompra
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de registrar los datos de la orden de compra
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
		function ModificarCotizacionOrdenCompra($id_cotizacion, $lugar_entrega, $forma_pago, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra,$num_pagos,
			$fecha_orden_compra,$id_empresa,$factura_total,$num_factura,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$tipo_pago,$id_caja,$id_cajero,
			$id_depto_tesoro,$tipo_plantilla,$por_adelanto,$por_retgar,$nro_contrato,$monto_adelanto_moneda_cotizada,$fecha_ini_ctto,$fecha_fin_ctto
			//jun2015
		,$tiene_anticipo,$anticipo_con_ejecucion,$con_contrato,$id_cotizacion_ampliacion)
	{/*
	
	$id_cotizacion, $lugar_entrega, $forma_pago, $fecha_entrega,
				     $tipo_entrega, $observaciones, $id_proceso_compra,$num_pagos,$fecha_orden_compra,
				     $id_empresa,$factura_total,$num_factura,$num_autoriza_factura,$justificacion_adjudicacion,
				     $fecha_factura,$tipo_pago,$id_caja,$id_cajero,$id_depto_tesoro,
				     $tipo_plantilla,$por_adelanto,$por_retgar,$nro_contrato,$monto_adelanto_moneda_cotizada,$fecha_ini_ctto,$fecha_fin_ctto,
				     $tiene_anticipo,$ancitipo_con_ejecucion,$con_contrato,$id_cotizacion_ampliacion
	*/
	
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_CORORD_UPD'"; //registrar orden de compra para cotizacion 

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$fecha_ini_ctto'");//'$fecha_venc' --> fecha_ini_ctto
		$this->var->add_param("'$fecha_fin_ctto'");//'$fecha_reg'  --> fecha_fin_ctto
		$this->var->add_param($id_caja);//'$impuestos' //reuso de campo cuando se elija que el pago se lo eralizarï¿½ en caja
		$this->var->add_param("NULL");//'$garantia'
		$this->var->add_param("'$lugar_entrega'");//6
		$this->var->add_param("'$forma_pago'");//7
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("'$fecha_entrega'");//9
		
		$this->var->add_param("'$tipo_entrega'");//10
		$this->var->add_param("'$observaciones'");//11
		$this->var->add_param($id_proceso_compra);//12
		$this->var->add_param($tipo_plantilla);//$id_moneda // reuso de campo id_moneda, cuando se elige fatura_total
		$this->var->add_param($id_cotizacion_ampliacion);//$id_proveedor  ***31 ago2015: se reusa este campo para enviar valor de id_cotizacion_ampliacion
		
		$this->var->add_param($id_depto_tesoro);//$id_tipo_categoria_adq // reuso de campo cuando se elija pago por caja y contiene el id_depto de tesoreria que harï¿½ el pago
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//'$figura_acta'
		$this->var->add_param($num_factura);//$num_factura//18
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("NULL");//'$estado_vigente'
		$this->var->add_param("NULL");//'$estado_reg'
		$this->var->add_param("NULL");//'$nombre_pago'
		$this->var->add_param("NULL");//'$siguiente_estado'
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param($id_cajero);//$num_orden_compra_sis//reuso de campo cuando se elija que el pago se lo eralizarï¿½ en caja
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("'$fecha_orden_compra'");//'$fecha_orden_compra'//28
		$this->var->add_param("NULL");//
		$this->var->add_param($num_pagos);//num_pagos//30
		$this->var->add_param($id_empresa);//id_empresa//31 
				$this->var->add_param("'$tiene_anticipo'");//se_adjudica      *****jun2015: tiene_anticipo
		$this->var->add_param("'$anticipo_con_ejecucion'");//observaciones_acta   *****jun2015: anticipo_con_ejecucion
		
		$this->var->add_param("'$factura_total'");//factura_total//34
		$this->var->add_param($num_autoriza_factura);//num_autoriza_factura//35
		$this->var->add_param("'$cod_control_factura'");//cod_control_factura//36    =>08.2014 contiene la justificacion_adjudicacion
		$this->var->add_param("'$fecha_factura'");//fecha_factura//37
		$this->var->add_param("$monto_adelanto_moneda_cotizada");//retencion alli mando el adelanto en la moneda cotizada jrr 18/08/2009
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("'$tipo_pago'");//tipo_pago (15/04/2009)
		$this->var->add_param($por_adelanto);//por_adelanto (16/06/2009)
		$this->var->add_param($por_retgar);//por_retgar(16/06/2009)
		$this->var->add_param("'$nro_contrato'");//nro_contrato(07/07/2009)
		$this->var->add_param("'$con_contrato'");//con_contrato(26/10/2009)
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	/****************reporte de Ingresos *********************************/
	/**
	 * Nombre de la funciï¿½n:	ListarIngreso
	 * Propï¿½sito:				Desplegar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2007-10-18 20:48:41
	 */
	function ReporteIngresoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_REPING_SEL'";

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
		$this->var->add_param('NULL');//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_almacen','varchar');//0
		$this->var->add_def_cols('correlativo_ing','text');//1
		$this->var->add_def_cols('num_factura','varchar');//2
		$this->var->add_def_cols('fecha_factura','text');//3
		$this->var->add_def_cols('fecha_finalizado_cancelado','text');//4
		$this->var->add_def_cols('origen','varchar');//5
		$this->var->add_def_cols('descripcion','varchar');//6
		$this->var->add_def_cols('responsable','varchar');//7
		$this->var->add_def_cols('almacenero','text');//8
		$this->var->add_def_cols('jefe_almacen','text');//9
		$this->var->add_def_cols('fecha_reg','date');//10
		$this->var->add_def_cols('observaciones','varchar');//11
        $this->var->add_def_cols('id_ingreso','integer');//12
        $this->var->add_def_cols('proveedor','text');//13
        $this->var->add_def_cols('fecha','date');//14
        $this->var->add_def_cols('remision','integer');//15
        $this->var->add_def_cols('num_cotizacion','text');//16
        $this->var->add_def_cols('num_proceso','text');//16
        $this->var->add_def_cols('num_solicitud','varchar');//16
    /*    $this->var->add_def_cols('gestion','integer');
        $this->var->add_def_cols('tipo_adq','text');
	*/	//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo "sql:".$this->query;
     	exit;
*/
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	Detalle del Reporte 
	 * Propï¿½sito:				Desplegar el detalle del ingreso para reporte Vale de Ingreso de Materiales
	 * Autor:				    AVQ
	 * Fecha de creaciï¿½n:		11/09/2008
	 */
	function ReporteIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_INGDET_SEL'";

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
		$this->var->add_param('NULL');//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');//6
		$this->var->add_def_cols('cantidad','numeric');//3
		$this->var->add_def_cols('unidad_med','varchar');//5
		$this->var->add_def_cols('calidad','varchar');//7
		$this->var->add_def_cols('nueva_desc','text');//8
		$this->var->add_def_cols('peso_neto','numeric');//4
		$this->var->add_def_cols('costo','numeric');//9
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*echo "query: ".$this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ObtenerIngresoItem
	 * Propï¿½sito:				Devuelve la cantidad ingresada de un item especï¿½fico
	 * Autor:				    RCM
	 * Fecha de creaciï¿½n:		15/07/2008
	 */
	function IngresoDetSum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_DETSUM_SEL'";

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
		$this->var->add_param('NULL');//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('cantidad','numeric');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*
		echo "query: ".$this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ListarOCCotizacion
	 * Propï¿½sito:				Desplegar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ListarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_OCCOT_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
	    //Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la funciï¿½n:	ContarOCCotizacion
	 * Propï¿½sito:				Contar los registros de tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ContarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_OCCOT_COUNT'";

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
	function ListarListaOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_LISTOC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
       	$this->var->add_def_cols('id_cotizacion','integer');
       	$this->var->add_def_cols('numero_orden','text');
		$this->var->add_def_cols('fecha_cotizacion','date');		
		$this->var->add_def_cols('fecha_orden_compra','date');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('nombre_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('total_bs','numeric');
		$this->var->add_def_cols('total_sus','numeric');
		
		$this->var->add_def_cols('saldo_pagar','numeric');
		$this->var->add_def_cols('saldo_cambio','numeric');
	//	$this->var->add_def_cols('cadena_ep_uo','text');
		//Ejecuta la funciï¿½n de consulta 
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
/*		exit;*/
		return $res;
	}
	/**
	 *Reporte Listado de Ordenes de compra a detalle
	 * Autor. Ana Maria Villegas Quispe
	 * Fecha Modificacion: 27/07/2010
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
	function ListarListaOCDetallado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_LIOCDE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
       	$this->var->add_def_cols('id_cotizacion','integer');
       	$this->var->add_def_cols('numero_orden','text');
       	$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('fecha_orden_compra','text');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('codigo_proceso','text');		
		$this->var->add_def_cols('nombre_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('total_bs','numeric');
		$this->var->add_def_cols('saldo_pagar','numeric');
		$this->var->add_def_cols('fecha_orden','date');
		//$this->var->add_def_cols('saldo_cambio','numeric');
	//	$this->var->add_def_cols('cadena_ep_uo','text');
		//Ejecuta la funciï¿½n de consulta 
		$this->var->add_def_cols('total_devengado_liquido','numeric');
		$this->var->add_def_cols('total_pagado_liquido','numeric');
		
		
		$res = $this->var->exec_query();

		
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	/** 07/05/2009
	 *  Listado de Num_sol, EP y UO asociadas a una OC
	*/
	
	function ListarNumSolEPUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_EPUOOC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
       	$this->var->add_def_cols('num_sol','text');
		$this->var->add_def_cols('ep','text');
		$this->var->add_def_cols('uo','varchar');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	
/************************ acaba el reporte de ingresos ***********************************/
	
	/**
	 * Nombre de la funciï¿½n:	ValidarCotizacion
	 * Propï¿½sito:				Permite ejecutar la validaciï¿½n del lado del servidor de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ValidarCotizacion($operacion_sql,$id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra)
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
				//Validar id_cotizacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cotizacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion", $id_cotizacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}


			//Validar id_proceso_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_compra");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra", $id_proceso_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
			{
				$this->salida = $valid->salida;
				return false;
			}



			

			//Validar estado_vigente - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_vigente");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_vigente", $estado_vigente))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_reg - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_reg");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_pago - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_pago");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_pago", $nombre_pago))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar siguiente_estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("siguiente_estado");
			$tipo_dato->set_MaxLength(30);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "siguiente_estado", $siguiente_estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar num_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("num_cotizacion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "num_cotizacion", $num_cotizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validaciï¿½n de reglas de datos

			//Validar impuestos
			$check = array (1,2,3,4,5);
			if(!in_array($impuestos,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validaciï¿½n en columna 'impuestos': El valor no estï¿½ dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarCotizacion";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validaciï¿½n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cotizacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion", $id_cotizacion))
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
	
	
	function AnularCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTANU_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
        $this->var->add_param("NULL");//retencion
        $this->var->add_param("NULL");//
        $this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
        $this->var->add_param("NULL");//tipo_pago (15/04/2009)
        $this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * funcion que permite adjudicar todo lo que cotizï¿½ un proveedor
	 *
	 * @param unknown_type $id_cotizacion
	 * @param unknown_type $fecha_venc
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $impuestos
	 * @param unknown_type $garantia
	 * @param unknown_type $lugar_entrega
	 * @param unknown_type $forma_pago
	 * @param unknown_type $tiempo_validez_oferta
	 * @param unknown_type $fecha_entrega
	 * @param unknown_type $tipo_entrega
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_proceso_compra
	 * @param unknown_type $id_moneda
	 * @param unknown_type $id_proveedor
	 * @param unknown_type $id_tipo_categoria_adq
	 * @param unknown_type $precio_total
	 * @param unknown_type $figura_acta
	 * @param unknown_type $num_factura
	 * @param unknown_type $num_orden_compra
	 * @param unknown_type $estado_vigente
	 * @param unknown_type $estado_reg
	 * @param unknown_type $nombre_pago
	 * @param unknown_type $siguiente_estado
	 * @param unknown_type $periodo
	 * @param unknown_type $gestion
	 * @param unknown_type $num_orden_compra_sis
	 * @param unknown_type $num_cotizacion
	 * @param unknown_type $fecha_orden_compra
	 * @param unknown_type $id_empresa
	 * @param unknown_type $fecha_cotizacion
	 * @return unknown
	 */
	
	function AdjudicarTodo($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_ADJTOD_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//("'$fecha_reg'");
		
		$this->var->add_param("NULL");//("'$impuestos'");
		$this->var->add_param("NULL");//("'$garantia'");
		$this->var->add_param("NULL");//("'$lugar_entrega'");
		$this->var->add_param("NULL");//("'$forma_pago'");
		$this->var->add_param("NULL");//("'$tiempo_validez_oferta'");
		$this->var->add_param("NULL");//("'$fecha_entrega'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("NULL");//("'$tipo_entrega'");
		$this->var->add_param("NULL");//("'$observaciones'");
		$this->var->add_param("NULL");//($id_proceso_compra);
		$this->var->add_param("NULL");//($id_moneda);
		$this->var->add_param("NULL");//($id_proveedor);
		$this->var->add_param("NULL");//($id_tipo_categoria_adq);
		$this->var->add_param("NULL");//($precio_total);
		$this->var->add_param("NULL");//("'$figura_acta'");
		$this->var->add_param("NULL");//("'$num_factura'");
		$this->var->add_param("NULL");//($num_orden_compra);
		$this->var->add_param("NULL");//("'$estado_vigente'");
		$this->var->add_param("NULL");//("'$estado_reg'");
		$this->var->add_param("NULL");//("'$nombre_pago'");
		$this->var->add_param("NULL");//("'$siguiente_estado'");
		$this->var->add_param("NULL");//($periodo);
		$this->var->add_param("NULL");//($gestion);
		$this->var->add_param("NULL");//($num_orden_compra_sis);
		$this->var->add_param("NULL");//($num_cotizacion);
		$this->var->add_param("NULL");//("'$fecha_orden_compra'");
		$this->var->add_param("NULL");//("'$fecha_cotizacion'");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//($id_empresa);//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$retencion=$_SESSION["ss_retencion"];
		$this->var->add_param($retencion);//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	/**
	 * funcion que revierte las adjudicacion realizadas, revierte Ordenes de Compra y Ordenes de Ingreso a Almacen si corresponde 
	 * regresa las cotizaciones a estado cotizado
	 **/
	function RevertirAdjudicacion($id_cotizacion,$id_proceso_compra){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_REVADJ_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//("'$fecha_reg'");
		
		$this->var->add_param("NULL");//("'$impuestos'");
		$this->var->add_param("NULL");//("'$garantia'");
		$this->var->add_param("NULL");//("'$lugar_entrega'");
		$this->var->add_param("NULL");//("'$forma_pago'");
		$this->var->add_param("NULL");//("'$tiempo_validez_oferta'");
		$this->var->add_param("NULL");//("'$fecha_entrega'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("NULL");//("'$tipo_entrega'");
		$this->var->add_param("NULL");//("'$observaciones'");
		$this->var->add_param("$id_proceso_compra");//($id_proceso_compra);
		$this->var->add_param("NULL");//($id_moneda);
		$this->var->add_param("NULL");//($id_proveedor);
		$this->var->add_param("NULL");//($id_tipo_categoria_adq);
		$this->var->add_param("NULL");//($precio_total);
		$this->var->add_param("NULL");//("'$figura_acta'");
		$this->var->add_param("NULL");//("'$num_factura'");
		$this->var->add_param("NULL");//($num_orden_compra);
		$this->var->add_param("NULL");//("'$estado_vigente'");
		$this->var->add_param("NULL");//("'$estado_reg'");
		$this->var->add_param("NULL");//("'$nombre_pago'");
		$this->var->add_param("NULL");//("'$siguiente_estado'");
		$this->var->add_param("NULL");//($periodo);
		$this->var->add_param("NULL");//($gestion);
		$this->var->add_param("NULL");//($num_orden_compra_sis);
		$this->var->add_param("NULL");//($num_cotizacion);
		$this->var->add_param("NULL");//("'$fecha_orden_compra'");
		$this->var->add_param("NULL");//("'$fecha_cotizacion'");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//($id_empresa);//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function CambiarEstadoCot($id_cotizacion,$observaciones,$id_proceso_compra,$estado_vigente){
	    
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_REESCO_UPD'";//retornar a un estado de la cotizacion

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$fecha_reg
		$this->var->add_param("NULL");//$impuestos
		$this->var->add_param("NULL");//$garantia
		$this->var->add_param("NULL");//$lugar_entrega
		$this->var->add_param("NULL");//$forma_pago
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("NULL");//$fecha_entrega
		
		$this->var->add_param("NULL");//$tipo_entrega
		$this->var->add_param("'$observaciones'");//$observaciones
		$this->var->add_param($id_proceso_compra);//
		$this->var->add_param("NULL");//$id_moneda
		$this->var->add_param("NULL");//$id_proveedor
		$this->var->add_param("NULL");//$id_tipo_categoria_adq
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//$figura_acta
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param("NULL");//$estado_reg
		$this->var->add_param("NULL");//$nombre_pago
		$this->var->add_param("NULL");//$siguiente_estado
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("NULL");//$fecha_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function InsertarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero)

	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_dir_iud';
		$this->codigo_procedimiento = "'AD_COTDIR_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("'$impuestos'");
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($precio_total);
		$this->var->add_param("'$num_factura'");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($id_empresa);//id_empresa
		$this->var->add_param($num_autoriza_factura);//("NULL");//num_autoriza_factura
		$this->var->add_param("'$cod_control_factura'");//("NULL");//cod_control_factura
		$this->var->add_param("'$fecha_factura'");//("NULL");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param($tipo_documento);//tipo_documento
		$this->var->add_param($id_caja);//$id_caja
		$this->var->add_param($id_cajero);//$id_cajero
		$this->var->add_param("NULL");//$id_responsable_adju
		$this->var->add_param("NULL");//$fecha_adjudicacion -- 27/04/10 Fer-Mod-Ad-07
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ModificarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero)

	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_dir_iud';
		$this->codigo_procedimiento = "'AD_COTDIR_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);//id_cotizacion
		$this->var->add_param("'$impuestos'");
		$this->var->add_param("'$forma_pago'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_moneda);
		$this->var->add_param($id_proveedor);
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($precio_total);
		$this->var->add_param("'$num_factura'");
		$this->var->add_param("'$nombre_pago'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($id_empresa);//id_empresa
		$this->var->add_param($num_autoriza_factura);//("NULL");//num_autoriza_factura
		$this->var->add_param("'$cod_control_factura'");//("NULL");//cod_control_factura
		$this->var->add_param("'$fecha_factura'");//("NULL");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param($tipo_documento);//tipo_documento
		$this->var->add_param($id_caja);//$id_caja
		$this->var->add_param($id_cajero);//$id_cajero
		$this->var->add_param("NULL");//$id_responsable_adju
		$this->var->add_param("NULL");//$fecha_adjudicacion -- 27/04/10 Fer-Mod-Ad-07
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function FinalizarCotizacionDir($id_cotizacion,$retencion,$id_empresa,$num_factura,$fecha_factura,$id_caja,$id_cajero,$impuestos,$precio_total,$id_responsable_adjudicacion,$fecha_adjudicacion,$observaciones)

	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_dir_iud';
		$this->codigo_procedimiento = "'AD_COTDIR_FIN'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);//id_cotizacion
		$this->var->add_param($impuestos);//("'$impuestos'");
		$this->var->add_param("NULL");//("'$forma_pago'");
		$this->var->add_param("'$observaciones'");//("'$observaciones'");
		$this->var->add_param("NULL");//($id_proceso_compra);
		$this->var->add_param("NULL");//($id_moneda);
		$this->var->add_param("NULL");//($id_proveedor);
		$this->var->add_param("NULL");//($id_tipo_categoria_adq);
		$this->var->add_param($precio_total);//($precio_total);
		$this->var->add_param($num_factura);//("'$num_factura'");
		$this->var->add_param("NULL");//("'$nombre_pago'");
		$this->var->add_param("NULL");//($periodo);
		$this->var->add_param("NULL");//($gestion);
		$this->var->add_param("NULL");//($num_cotizacion);
		$this->var->add_param($id_empresa);//id_empresa
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("'$fecha_factura'");//fecha_factura
		$this->var->add_param($retencion);//retencion
		$this->var->add_param("NULL");//($tipo_documento);//tipo_documento
		$this->var->add_param($id_caja);//$id_caja
		$this->var->add_param($id_cajero);//$id_cajero
		$this->var->add_param($id_responsable_adjudicacion);//$id_responsable_adju
		$this->var->add_param("'$fecha_adjudicacion'");//$fecha_adjudicacion -- 27/04/10 Fer-Mod-Ad-07
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $impuestos.'precio total'.$precio_total.'num factura'.$num_factura.'fecha fact'.$fecha_factura.'id_caja'.$id_caja.'id cajero'.$id_cajero;
//exit;
		return $res;
	}
	
	
	
	function ModificarRecomendacion($id_cotizacion,$justificacion_adjudicacion){
	    
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_RECOME_UPD'";//retornar a un estado de la cotizacion

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$fecha_reg
		$this->var->add_param("NULL");//$impuestos
		$this->var->add_param("NULL");//$garantia
		$this->var->add_param("NULL");//$lugar_entrega
		$this->var->add_param("NULL");//$forma_pago
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("NULL");//$fecha_entrega
		
		$this->var->add_param("NULL");//$tipo_entrega
		$this->var->add_param("NULL");//$observaciones
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//$id_moneda
		$this->var->add_param("NULL");//$id_proveedor
		$this->var->add_param("NULL");//$id_tipo_categoria_adq
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//$figura_acta
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$estado_reg
		$this->var->add_param("NULL");//$nombre_pago
		$this->var->add_param("NULL");//$siguiente_estado
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("NULL");//$fecha_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("'$justificacion_adjudicacion'");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/*
	*Autor: Ana Maria Villegas
	* Fecha de Creacion: 03/06/2009
	* Nombre: GetIdCotOrdenCompra
	* Descripciï¿½n: Es para obtener el id de cotizaciï¿½n una vez que se recibe el periodo y  numero de orden de compra
	*
	*/
    function GetIdCotOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_IDCOOC_SEL'";

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
		$this->var->add_def_cols('id_cotizacion','int4');
	
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
		return $res;
	}
	
	
	function PagarAdelanto($id_cotizacion){
	    
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		if($accion=='revertir_devengado')
			$this->codigo_procedimiento = "'AD_REVDEV_UPD'";//reversión de devengado
		else 
			$this->codigo_procedimiento = "'AD_PAGADE_UPD'";//pago de adelanto
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$fecha_reg
		$this->var->add_param("NULL");//$impuestos
		$this->var->add_param("NULL");//$garantia
		$this->var->add_param("NULL");//$lugar_entrega
		$this->var->add_param("NULL");//$forma_pago
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("NULL");//$fecha_entrega
		
		$this->var->add_param("NULL");//$tipo_entrega
		$this->var->add_param("NULL");//$observaciones
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//$id_moneda
		$this->var->add_param("NULL");//$id_proveedor
		$this->var->add_param("NULL");//$id_tipo_categoria_adq
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//$figura_acta
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$estado_reg
		$this->var->add_param("NULL");//$nombre_pago
		$this->var->add_param("NULL");//$siguiente_estado
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("NULL");//$fecha_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	function ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_consultores_sel';
		$this->codigo_procedimiento = "'AD_CONSUL_SEL'";
 
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
		$this->var->add_param($func->iif($en_planilla == '',"'%'","'$en_planilla'"));//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('num_os','text');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('num_sol','varchar');
		$this->var->add_def_cols('prox_pago','int4');
		$this->var->add_def_cols('fecha_prox_pago','date');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('id_plan_pago','int4');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('tipo_plantilla','int4');
		//$this->var->add_def_cols('num_factura','int4');
		$this->var->add_def_cols('num_factura','bigint');//10ago12 por modificacion en tabla tad_cotizacion, tad_plan_pago
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('desc_plantilla','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nit','varchar');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('tipo','numeric');
		$this->var->add_def_cols('id_documento','integer');
		$this->var->add_def_cols('por_anticipo','numeric');
		$this->var->add_def_cols('por_retgar','numeric');
		$this->var->add_def_cols('multas','numeric');
		$this->var->add_def_cols('anticipo_cot','numeric');
		$this->var->add_def_cols('retgar_cot','numeric');
		$this->var->add_def_cols('factura_total','varchar');
		$this->var->add_def_cols('periodo','numeric');
		$this->var->add_def_cols('num_ord_compra','integer');
		$this->var->add_def_cols('cuenta_bancaria','varchar');
		$this->var->add_def_cols('obs_descuentos','text');
		$this->var->add_def_cols('importe_iue','numeric');
		$this->var->add_def_cols('importe_it','numeric');
		$this->var->add_def_cols('monto_no_pagado','numeric');
		//$this->var->add_def_cols('fecha_pagado_rep','date');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit; 
		return $res;
	}
	function ListarConsultoresPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_consultores_sel';
		$this->codigo_procedimiento = "'AD_CONPRES_SEL'";
 
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
		$this->var->add_param($func->iif($en_planilla == '',"'%'","'$en_planilla'"));//id_actividad
  
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('num_os','text');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('tipo_plantilla','int4');
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('desc_presupuesto','text');
		//$this->var->add_def_cols('fecha_pagado_rep','date');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	} 
	
	function ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_consultores_sel';
		$this->codigo_procedimiento = "'AD_CONSUL_COUNT'";

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
		$this->var->add_param($func->iif($en_planilla == '',"'%'","'$en_planilla'"));//id_actividad

		
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
//echo $this->query;
//exit;

		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	function FinalizarCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_COTFIN_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//$id_empleado_adjudicacion
		$this->var->add_param("NULL");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("NULL");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	//10-03-2010
	function ModificarDatosServ($id_cotizacion,$nro_contrato,$fecha_ini_ctto,$fecha_fin_ctto){
	    
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_iud';
		$this->codigo_procedimiento = "'AD_RECOME_UPD'";//retornar a un estado de la cotizacion

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_ini_ctto'");//$fecha_reg --> fecha_ini_serv
		$this->var->add_param("NULL");//$impuestos
		$this->var->add_param("NULL");//$garantia
		$this->var->add_param("NULL");//$lugar_entrega
		$this->var->add_param("NULL");//$forma_pago
		$this->var->add_param("NULL");//$tiempo_validez_oferta
		$this->var->add_param("'$fecha_fin_ctto'");//$fecha_entrega --> fecha_fin_serv
		
		$this->var->add_param("NULL");//$tipo_entrega
		$this->var->add_param("NULL");//$observaciones
		$this->var->add_param("NULL");//
		$this->var->add_param("NULL");//$id_moneda
		$this->var->add_param("NULL");//$id_proveedor
		$this->var->add_param("NULL");//$id_tipo_categoria_adq
		$this->var->add_param("NULL");//$precio_total
		$this->var->add_param("NULL");//$figura_acta
		$this->var->add_param("NULL");//$num_factura
		$this->var->add_param("NULL");//$num_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//$estado_reg
		$this->var->add_param("NULL");//$nombre_pago
		$this->var->add_param("NULL");//$siguiente_estado
		$this->var->add_param("NULL");//$periodo
		$this->var->add_param("NULL");//$gestion
		$this->var->add_param("NULL");//$num_orden_compra_sis
		$this->var->add_param("NULL");//$num_cotizacion
		$this->var->add_param("NULL");//$fecha_orden_compra
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_pagos
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//se_adjudica
		$this->var->add_param("NULL");//observaciones_acta
		$this->var->add_param("NULL");//factura_total
		$this->var->add_param("NULL");//num_autoriza_factura
		$this->var->add_param("NULL");//cod_control_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//
		$this->var->add_param("'$justificacion_adjudicacion'");//justificacion_adjudicacion (18/02/2009)
		$this->var->add_param("NULL");//tipo_pago (15/04/2009)
		$this->var->add_param("NULL");//por_adelanto (16/06/2009)
		$this->var->add_param("NULL");//por_retgar(16/06/2009)
		$this->var->add_param("'$nro_contrato'");//nro_contrato(07/07/2009)
		$this->var->add_param("NULL");//con_contrato(26/10/2009)
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/*****************************REPORTE: MEMORANDUM SOLICITUD DE ANTICIPO A PROVEEDDOR******************************/
	function RepSolicitudAnticipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_SOLANT_SEL'";

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
		$this->var->add_param("NULL");//id_actividad

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('proveedor','TEXT');
 		$this->var->add_def_cols('codigo_proceso','TEXT'); 
  		$this->var->add_def_cols('descripcion_sol','TEXT'); 
  		$this->var->add_def_cols('nivel_aprobacion','TEXT'); 
  		$this->var->add_def_cols('precio_total_moneda_cotizada','NUMERIC(18,2)'); 
  		$this->var->add_def_cols('por_adelanto','NUMERIC(11,6)'); 
  		$this->var->add_def_cols('monto_adelanto_moneda_cotizada','NUMERIC');
  		$this->var->add_def_cols('moneda','varchar');
  		$this->var->add_def_cols('descrip','text');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit;
		*/return $res;
	}
	
	
	
	function RepSolicitudAnticipoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_rep_sel';
		$this->codigo_procedimiento = "'AD_SOLANTDE_SEL'";

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
		$this->var->add_param($id_plan_pago);//id_actividad
			
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_plan_pago','integer');
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_partida','varchar');
		$this->var->add_def_cols('monto_moneda_cotizada','numeric');
		
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/***************************** ----fin ---- REPORTE: MEMORANDUM SOLICITUD DE PAGO A PROVEEDDOR******************************/
	
function ListarDetalleGeneralOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_DETGENOC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
       	$this->var->add_def_cols('id_cotizacion','integer');
       	
       	$this->var->add_def_cols('numero_orden','text');
       	$this->var->add_def_cols('ini_estimado','date');
       	$this->var->add_def_cols('fin_estimado','date');
       	$this->var->add_def_cols('tiempo_estimado','integer');
       	$this->var->add_def_cols('fecha_ini_ctto','text');
       	$this->var->add_def_cols('fecha_fin_ctto','text');
       	$this->var->add_def_cols('tiempo_servicio','integer');
       	$this->var->add_def_cols('partida_presupuestaria','text');
       	
       	$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('fecha_orden_compra','text');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('codigo_proceso','text');
		$this->var->add_def_cols('nombre_proveedor','text');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('total_bs','numeric');
		$this->var->add_def_cols('saldo_pagar','numeric');
		
		$this->var->add_def_cols('cbte_dev','varchar');
		$this->var->add_def_cols('cbte_pago','varchar');
		
		//$this->var->add_def_cols('saldo_cambio','numeric');
	//	$this->var->add_def_cols('cadena_ep_uo','text');
		$this->var->add_def_cols('total_devengado','numeric');
		$this->var->add_def_cols('total_pagado','numeric');
		$this->var->add_def_cols('fecha_oc','date');
		//Ejecuta la funciï¿½n de consulta 
		$res = $this->var->exec_query();

		
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit;
		return $res;
	}
	
	
	/********** REPORTE ABONO EN CUENTAS PARA PLANILLA DE CONSULTORES ***************/

	
	 function ListarRepPlanillaAbono($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	 {
	$this->salida = "";
	$this->nombre_funcion = 'f_tad_cotizacion_sel';
	$this->codigo_procedimiento = "'AD_REPABONO_SEL'";
	
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
	
	$this->var->add_def_cols('codigo',' VARCHAR');
	$this->var->add_def_cols('desc_proveedor',' text');
	$this->var->add_def_cols('nro_cuenta','varchar');
	$this->var->add_def_cols('valor','  numeric');
	
	
	//Ejecuta la funciï¿½n de consulta
	$res = $this->var->exec_query();
	
	//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
	$this->salida = $this->var->salida;
	
	//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
	$this->query = $this->var->query;
		return $res;
	}

	//agosto-2015
	function ListarCotizacionAmpliacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTAMP_SEL'";
	
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
	$this->var->add_def_cols('id_cotizacion','int4');
	$this->var->add_def_cols('orden_compra','text');
	$this->var->add_def_cols('codigo_proceso','varchar');
	$this->var->add_def_cols('nro_contrato','varchar');
	
	//Ejecuta la funciï¿½n de consulta
	$res = $this->var->exec_query();
	
	//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
	$this->salida = $this->var->salida;
	
	//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
	$this->query = $this->var->query;
	
	return $res;
	}
	
	
	function ContarCotizacionAmpliacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_sel';
		$this->codigo_procedimiento = "'AD_COTAMP_COUNT'";
	
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
	
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
/***********************/
	
	
	


	function ListarCotizacionCtto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_ctto_sel';
		$this->codigo_procedimiento = "'AD_COTCTTO_SEL'";
	
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
		$this->var->add_def_cols('id_cotizacion_ctto','int4');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('antecedentes','varchar');
		$this->var->add_def_cols('controversias','varchar');
		$this->var->add_def_cols('doc_integrantes','varchar');
		$this->var->add_def_cols('fecha_ctto','date');
		$this->var->add_def_cols('garantias','varchar');
		$this->var->add_def_cols('legislacion','varchar');
		$this->var->add_def_cols('multas','varchar');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('obligaciones','varchar');
		//$this->var->add_def_cols('desc_proceso_compra','text');
		
		$this->var->add_def_cols('partes','varchar');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('vigencia','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		
		//$this->var->add_def_cols('num_sol_por_proc','varchar');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//		echo  $this->query;
		//		exit;
		return $res;
	}
	
	
	function ContarCotizacionCtto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_ctto_sel';
		$this->codigo_procedimiento = "'AD_COTCTTO_COUNT'";
	
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
	
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	function InsertarCotizacionCtto($id_cotizacion_ctto, $id_cotizacion,$antecedentes,$controversias, $doc_integrantes, $fecha_ctto, $garantias, $legislacion, $multas, $nro_contrato, $obligaciones,$controversias,
		$partes,$vigencia )
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_ctto_iud';
		$this->codigo_procedimiento = "'AD_COTCTTO_INS'";
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		
		
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$antecedentes'");
		$this->var->add_param("'$controversias'");
		$this->var->add_param("'$doc_integrantes'");
		$this->var->add_param("'$garantias'");
		$this->var->add_param("'$legislacion'");
		$this->var->add_param("'$multas'");
		$this->var->add_param("'$obligaciones'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("'$partes'");
		$this->var->add_param("'$vigencia'");
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la funciï¿½n:	ModificarCotizacion
	 * Propï¿½sito:				Permite ejecutar la funciï¿½n de modificaciï¿½n de la tabla tad_cotizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creaciï¿½n:		2008-05-28 16:58:40
	 */
	function ModificarCotizacionCtto($id_cotizacion_ctto, $id_cotizacion,$antecedentes,$controversias, $doc_integrantes, $fecha_ctto, $garantias, $legislacion, $multas, $nro_contrato, $obligaciones,$controversias,
		$partes,$vigencia )
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_ctto_iud';
		$this->codigo_procedimiento = "'AD_COTCTTO_UPD'";
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_ctto);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$antecedentes'");
		$this->var->add_param("'$controversias'");
		$this->var->add_param("'$doc_integrantes'");
		$this->var->add_param("'$garantias'");
		$this->var->add_param("'$legislacion'");
		$this->var->add_param("'$multas'");
		$this->var->add_param("'$obligaciones'");
		//$this->var->add_param("'$fecha_limite'");
		$this->var->add_param("'$partes'");
		$this->var->add_param("'$vigencia'");
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	function EliminarCotizacionCtto($id_cotizacion_ctto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_ctto_iud';
		$this->codigo_procedimiento = "'AD_COTCTTO_DEL'";
	
		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_ctto);
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
	
	
}?>