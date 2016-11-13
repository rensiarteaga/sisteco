<?php
/**
 * Nombre de la clase:	cls_DBUnidadOrganizacional.php
 * Prop?sito:			Permite ejecutar toda la funcionalidad de la tabla kard.tkp_unidad_organizacional
 * Autor:				(autogenerado)
 * Fecha creaci?n:		2007-11-07 15:46:18
 */
class cls_DBCorrespondenciaArb
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
	 * ***********************************************************
	 * Para el Mannejo de ?rboles
	 * 
	 * 
	 ************************************************************* 
	 */
	
	/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacionalRaiz
	 * Prop?sito:				Desplegar los registros de tkp_unidad_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ListarCorrespondenciaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'flujo.f_fl_correspondencia_arb_sel';
		$this->codigo_procedimiento = "'FL_CORRE_RAIZ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("'$fecha_ini'");//id_gestion
		$this->var->add_param("'$fecha_fin'");//mes
		

		
			$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('desc_uo','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('fecha_origen','text');
		$this->var->add_def_cols('fecha_destino','text');
		$this->var->add_def_cols('hora_destino','time');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_tipo_accion','integer');
		$this->var->add_def_cols('nombre_tipo_accion','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('empleado_remitente','varchar');
		$this->var->add_def_cols('uo_remitente','varchar');
		$this->var->add_def_cols('id_correspondencia_fk','integer');
		$this->var->add_def_cols('padre','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('mensaje','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('observaciones_estado','text');
		$this->var->add_def_cols('derivado','varchar');
		$this->var->add_def_cols('dias_derivado','integer');
		$this->var->add_def_cols('fecha_derivado','varchar');
		
		
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}

	/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacional
	 * Prop?sito:				Desplegar los registros de tkp_estructura_organizacional
	 * Autor:				    (autogenerado)
	 * Fecha de creaci?n:		2007-11-07 15:46:18
	 */
	function ListarCorrespondenciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'flujo.f_fl_correspondencia_arb_sel';
		$this->codigo_procedimiento = "'FL_CORRE_RAIZ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par?metros espec?ficos de la estructura program?tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		$this->var->add_param("$agrupador");//raiz
		$this->var->add_param("'$fecha_ini'");//id_gestion
		$this->var->add_param("'$fecha_fin'");//mes
		

	
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('desc_uo','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('fecha_origen','text');
		$this->var->add_def_cols('fecha_destino','text');
		$this->var->add_def_cols('hora_destino','time');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_tipo_accion','integer');
		$this->var->add_def_cols('nombre_tipo_accion','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('empleado_remitente','varchar');
		$this->var->add_def_cols('uo_remitente','varchar');
		$this->var->add_def_cols('id_correspondencia_fk','integer');
		$this->var->add_def_cols('padre','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('mensaje','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('observaciones_estado','text');
		$this->var->add_def_cols('derivado','varchar');
		$this->var->add_def_cols('dias_derivado','integer');
		$this->var->add_def_cols('fecha_derivado','varchar');
		
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;
		return $res;
	}

	
	
	
		/**
	 * Nombre de la funci?n:	ListarUnidadOrganizacional
	 * Prop?sito:				Desplegar los registros de tkp_estructura_organizacional
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creaci?n:		2010
	 */
	function FiltrarCorrespondeciaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'flujo.f_tfl_correspondencia_recursivo_inicia';
		$this->codigo_procedimiento = "'FL_CORREARB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecuci?n de la funci?n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par?metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

	
		$this->var->add_param("$v_id");//raiz
		$this->var->add_param("'$fecha_ini'");//id_gestion
		$this->var->add_param("'$fecha_fin'");//mes

		//Carga la definici?n de columnas con sus tipos de datos
		$this->var->add_def_cols('niveles','varchar');
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('desc_uo','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('fecha_origen','text');
		$this->var->add_def_cols('fecha_destino','text');
		$this->var->add_def_cols('hora_destino','time');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_tipo_accion','integer');
		$this->var->add_def_cols('nombre_tipo_accion','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('empleado_remitente','varchar');
		$this->var->add_def_cols('uo_remitente','varchar');
		$this->var->add_def_cols('id_correspondencia_fk','integer');
		$this->var->add_def_cols('padre','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('mensaje','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('observaciones_estado','text');
		$this->var->add_def_cols('derivado','varchar');
		$this->var->add_def_cols('dias_derivado','integer');
		$this->var->add_def_cols('fecha_derivado','varchar');
		$this->var->add_def_cols('resaltar','varchar');
		//Ejecuta la funci?n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci?n y retorna el resultado de la ejecuci?n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam? a la funci?n de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;
		return $res;
	}
	
}?>