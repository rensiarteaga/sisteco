<?php
/**
 * Nombre de la Clase:	cls_DBActivoFijo
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_activo_fijo
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		12-06-2007
 *
 */
class cls_DBActivoFijo
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBActivoFijo.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{	
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarActivoFijo
	 * Propósito:				Desplegar los registros de taf_activo_fijo en función de los parámetros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
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
	function ListarActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		$this->codigo_procedimiento = "'AF_AF_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('vida_util_original','integer');
		$this->var->add_def_cols('vida_util_restante','integer');
		$this->var->add_def_cols('tasa_depreciacion','numeric');
		$this->var->add_def_cols('fecha_ultima_deprec','date');
		$this->var->add_def_cols('depreciacion_acum_ant','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		
		$this->var->add_def_cols('depreciacion_periodo','numeric');
		$this->var->add_def_cols('flag_revaloriz','varchar');
		$this->var->add_def_cols('valor_rescate','numeric');
		$this->var->add_def_cols('fecha_compra','date');
		$this->var->add_def_cols('monto_compra_mon_orig','numeric');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('monto_actual','numeric');
		$this->var->add_def_cols('con_garantia','varchar');
		$this->var->add_def_cols('num_poliza_garantia','varchar');
		$this->var->add_def_cols('fecha_fin_gar','date');
		
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('foto_activo','bytea');
		$this->var->add_def_cols('num_factura','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_sub_tipo_activo','integer');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('id_moneda_original','integer');
		
		
		$this->var->add_def_cols('ubicacion_fisica','varchar');
		$this->var->add_def_cols('orden_compra','varchar');
		$this->var->add_def_cols('desc_tipo_activo','varchar');
		$this->var->add_def_cols('desc_sub_tipo_activo','varchar');
		
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('fecha_ini_dep','date');
		$this->var->add_def_cols('responsable','text');
		$this->var->add_def_cols('custodio','text');
		
		$this->var->add_def_cols('id_estado_funcional','integer');
		$this->var->add_def_cols('desc_estado_funcional','varchar');
		$this->var->add_def_cols('vida_util_2','integer');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('desc_depto','text');
		$this->var->add_def_cols('id_cotizacion','integer');
		$this->var->add_def_cols('desc_cotizacion','varchar');
		$this->var->add_def_cols('id_cotizacion_det','integer');
		$this->var->add_def_cols('id_ep','integer');
		
		$this->var->add_def_cols('desc_ep','text');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');

		$this->var->add_def_cols('id_lugar','integer');
		$this->var->add_def_cols('desc_lugar','varchar');
		
		$this->var->add_def_cols('id_ppto','integer');
		$this->var->add_def_cols('tipo_ppto','varchar');
		
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('desc_presupuesto','text');
		
		$this->var->add_def_cols('id_solicitud_compra','integer');
		$this->var->add_def_cols('clonacion','varchar');
		$this->var->add_def_cols('id_deposito','integer');//agragado en fecha 10 ener 2011 para el id_deposito de la  tabla deposito
		$this->var->add_def_cols('nombre_deposito','varchar');//agragado en fecha 10 ener 2011 para nombre_deposito de la tabla deposito
		$this->var->add_def_cols('tipo_af_bien','varchar');//agragado en fecha 10 ener 2011 para nombre_deposito de la tabla deposito
		$this->var->add_def_cols('proyecto','varchar');//agragado en fecha 10 ener 2011 para nombre_deposito de la tabla deposito
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('nombre_moneda_orig','varchar');
		
		$this->var->add_def_cols('id_unidad_constructiva','integer');
		$this->var->add_def_cols('desc_unidad_constructiva','varchar');
		$this->var->add_def_cols('id_ubicacion','integer');
		$this->var->add_def_cols('desc_ubicacion_fisica','varchar');
		
		$this->var->add_def_cols('tension','varchar');
		$this->var->add_def_cols('bienes_produccion','varchar');
		
		$this->var->add_def_cols('desc_cotizacion_detalle','varchar'); 
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo $this->query; exit;
		return $res;
	}
	////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * Nombre de la función:	Listar CUADRO
	 * Propósito:				Desplegar los registros de taf_activo_fijo en función de los parámetros del filtro
	 * Autor:					Susana Castro
	 * Fecha de creación:		20-03-2008
	 */
	function ListarCuadro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_cuadro_activo_fijo_consultas';
	$this->codigo_procedimiento = "'AF_CUADRO_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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
	$this->var->add_param("'$fecha_inicio'");//fecha_ini
	$this->var->add_param("'$fecha_fin'");//fecha_fin
	//Carga la definición de columnas con sus tipos de datos

	$this->var->add_def_cols('desc_detalle','varchar');//desc_cuadro_actif.desc_detalle
	$this->var->add_def_cols('desc_valor_activo','numeric');// desc_cuadro_actif.desc_valor_activo
	$this->var->add_def_cols('desc_ret_incor','numeric');//desc_cuadro_actif.desc_ret_incor
	$this->var->add_def_cols('actualiz','numeric');//desc_cuadro_actif.actualiz
	$this->var->add_def_cols('valor_actualiz','numeric');//desc_cuadro_actif.valor_actualiz
	$this->var->add_def_cols('depreciacion_acum_ant','numeric');//desc_cuadro_actif.depreciacion_acum_ant
	$this->var->add_def_cols('dep_actualiz','numeric');// desc_cuadro_actif.dep_actualiz
	$this->var->add_def_cols('dep_valor_actuliz','numeric');//desc_cuadro_actif.dep_valor_actuliz
	$this->var->add_def_cols('depreciacion','numeric');//desc_cuadro_actif.depreciacion
	$this->var->add_def_cols('depreciacion_acum','numeric');//desc_cuadro_actif.depreciacion_acum
	$this->var->add_def_cols('monto_vigente','numeric');//desc_cuadro_actif.monto_vigente
	$this->var->add_def_cols('desc_vida_util','integer');//desc_cuadro_actif.desc_vida_util

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
	function ListarCuadroEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_cuadro_activo_fijo_consultas';
	$this->codigo_procedimiento = "'AF_CUADRO_EP_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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
	$this->var->add_param("'$fecha_inicio'");//fecha_ini
	$this->var->add_param("'$fecha_fin'");//fecha_fin
	//Carga la definición de columnas con sus tipos de datos

	$this->var->add_def_cols('id_financiador','integer');//
	$this->var->add_def_cols('nombre_financiador','varchar');//
	$this->var->add_def_cols('id_regional','integer');//
	$this->var->add_def_cols('nombre_regional','varchar');//
	$this->var->add_def_cols('id_programa','integer');//
	$this->var->add_def_cols('nombre_programa','varchar');//
	$this->var->add_def_cols('id_proyecto','integer');//
	$this->var->add_def_cols('nombre_proyecto','varchar');//
	$this->var->add_def_cols('id_actividad','integer');//
	$this->var->add_def_cols('nombre_actividad','varchar');//


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

	////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * Nombre de la función:	Listar ESTADO
	 * Propósito:				Desplegar los registros de taf_activo_fijo en función de los parámetros del filtro
	 * Autor:					Susana Castro
	 * Fecha de creación:		20-03-2008
	 */
	function ListarActivoFijoEstado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_ESTADO_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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

	$this->var->add_def_cols('codigo','varchar');//codigo
	$this->var->add_def_cols('desc_tipo','varchar');//desc_tipo
	$this->var->add_def_cols('desc_subtipo','varchar');//desc_subtipo
	$this->var->add_def_cols('desc_activo_fijo','varchar');//desc_activo_fijo
	$this->var->add_def_cols('fecha_ini_dep','date');//fecha_alta
	$this->var->add_def_cols('orden_compra','varchar');//orden_compra
	$this->var->add_def_cols('monto_compra','numeric');//monto_compra
	$this->var->add_def_cols('depreciacion_acum','numeric');//depreciacion_acum
	$this->var->add_def_cols('monto_actual','numeric');//monto_actual
	$this->var->add_def_cols('vida_util_restante','integer');//vida_util_restante
	$this->var->add_def_cols('desc_empleado','text');//desc_empleado
	$this->var->add_def_cols('desc_unidad_organizacional','varchar');//desc_unidad_organizacional

	//Ejecuta la función de consulta
	$res = $this->var->exec_query();
	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;
	//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
	//echo $this->query."<br>";
	/*echo $this->query;
	exit;*/

	return $res;
	}

	function ListarActivoFijoEstadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_ESTADO_EP_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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


	$this->var->add_def_cols('id_financiador','integer');//
	$this->var->add_def_cols('nombre_financiador','varchar');//
	$this->var->add_def_cols('id_regional','integer');//
	$this->var->add_def_cols('nombre_regional','varchar');//
	$this->var->add_def_cols('id_programa','integer');//
	$this->var->add_def_cols('nombre_programa','varchar');//
	$this->var->add_def_cols('id_proyecto','integer');//
	$this->var->add_def_cols('nombre_proyecto','varchar');//
	$this->var->add_def_cols('id_actividad','integer');//
	$this->var->add_def_cols('nombre_actividad','varchar');//

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

	function ListarActivoFijoEstadoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_ESTADO_EMPL_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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

	$this->var->add_def_cols('codigo','varchar');//codigo
	$this->var->add_def_cols('desc_tipo','varchar');//desc_tipo
	$this->var->add_def_cols('desc_subtipo','varchar');//desc_subtipo
	$this->var->add_def_cols('desc_activo_fijo','varchar');//desc_activo_fijo
	$this->var->add_def_cols('fecha_ini_dep','date');//fecha_alta
	$this->var->add_def_cols('orden_compra','varchar');//orden_compra
	$this->var->add_def_cols('monto_compra','numeric');//monto_compra
	$this->var->add_def_cols('depreciacion_acum','numeric');//depreciacion_acum
	$this->var->add_def_cols('monto_actual','numeric');//monto_actual
	$this->var->add_def_cols('vida_util_restante','integer');//vida_util_restante

	//Ejecuta la función de consulta
	$res = $this->var->exec_query();
	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;
	//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
	//echo $this->query."<br>";
	/*echo $this->query;
	exit;*/
	return $res;
	}

	function ListarActivoFijoEstadoEPEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_ESTADO_EP_EMPL_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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

	$this->var->add_def_cols('id_financiador','integer');//
	$this->var->add_def_cols('nombre_financiador','varchar');//
	$this->var->add_def_cols('id_regional','integer');//
	$this->var->add_def_cols('nombre_regional','varchar');//
	$this->var->add_def_cols('id_programa','integer');//
	$this->var->add_def_cols('nombre_programa','varchar');//
	$this->var->add_def_cols('id_proyecto','integer');//
	$this->var->add_def_cols('nombre_proyecto','varchar');//
	$this->var->add_def_cols('id_actividad','integer');//
	$this->var->add_def_cols('nombre_actividad','varchar');//
	$this->var->add_def_cols('id_empleado','integer');//
	$this->var->add_def_cols('desc_empleado','text');//
	$this->var->add_def_cols('id_unidad_organizacional','integer');//
	$this->var->add_def_cols('desc_unidad_organizacional','varchar');//

	//Ejecuta la función de consulta
	$res = $this->var->exec_query();
	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;
	//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
	//echo $this->query."<br>";
	/*echo $this->query;
	exit;*/
	return $res;
	}


	////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * Nombre de la función:	ListarCodigo de Barras
	 * Propósito:				Desplegar los registros de taf_activo_fijo en función de los parámetros del filtro
	 * Autor:					Susana Castro
	 * Fecha de creación:		20-03-2008
	 */
	function ListarCodigoBarras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_CODBA_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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
	$this->var->add_def_cols('descripcion','varchar');
	$this->var->add_def_cols('desc_tipo_activo','varchar');
	$this->var->add_def_cols('desc_sub_tipo_activo','varchar');
	$this->var->add_def_cols('nombre_regional','varchar');
	//Ejecuta la función de consulta
	$res = $this->var->exec_query();
	//Obtiene el array de salida de la función y retorna el resultado de la ejecución
	$this->salida = $this->var->salida;
	//Obtiene la cadena con que se llamó a la función de postgres
	$this->query = $this->var->query;
	return $res;
	}
	
	////////////////////////////////////////////////////////////////////////////////////////////
	/**
	 * Nombre de la función:	ListarCodigo de Barras
	 * Propósito:				Desplegar los registros de taf_activo_fijo en función de los parámetros del filtro
	 * Autor:					Susana Castro
	 * Fecha de creación:		20-03-2008
	 */
	function ListarActivoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$this->nombre_funcion = 'f_taf_activo_fijo_sel';
	$this->codigo_procedimiento = "'AF_DET_SEL'";

	$func = new cls_funciones();//Instancia de las funciones generales

	//Instancia la clase midlle para la ejecución de la función de la BD
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


	//$this->var->add_def_cols('id_activo_fijo','integer');
	$this->var->add_def_cols('codigo','varchar');
	$this->var->add_def_cols('descripcion_larga','varchar');
	$this->var->add_def_cols('estado','varchar');
	$this->var->add_def_cols('desc_estado_funcional','varchar');
	$this->var->add_def_cols('fecha_compra','text');
	$this->var->add_def_cols('monto_compra','numeric');
	$this->var->add_def_cols('ubicacion_fisica','varchar');
	$this->var->add_def_cols('desc_empleado','text');
	$this->var->add_def_cols('desc_unidad_organizacional','varchar');

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


	///////////////////////////////////////////////////////////////////////////////////////////

	/**
	 * Nombre de la función:	ContarListaActivoFijo
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
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
	function ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		$this->codigo_procedimiento = "'AF_AF_SEL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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

		/*echo "query:" .$this->query;
		exit;*/

		//Retorna el resultado de la ejecución
		return $res;
	}

	/**
	 * Nombre de la función:	CrearActivoFijo
	 * Propósito:				Permite ejecutar la función de inserción de la taf_activo_fijo de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $descripcion_larga
	 * @param unknown_type $vida_util_original
	 * @param unknown_type $vida_util_restante
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $_fecha_ultima_deprec
	 * @param unknown_type $depreciacion_acum_ant
	 * @param unknown_type $depreciacion_acum
	 * @param unknown_type $depreciacion_periodo
	 * @param unknown_type $flag_revaloriz
	 * @param unknown_type $valor_rescate
	 * @param unknown_type $fecha_compra
	 * @param unknown_type $monto_compra_mon_orig
	 * @param unknown_type $monto_compra
	 * @param unknown_type $monto_actual
	 * @param unknown_type $con_garantia
	 * @param unknown_type $num_poliza_garantia
	 * @param unknown_type $fecha_fin_gar
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $foto_activo
	 * @param unknown_type $num_factura
	 * @param unknown_type $tipo_cambio
	 * @param unknown_type $estado
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $id_institucion
	 * @param unknown_type $id_moneda
	 * @param unknown_type $id_moneda_original
	 * @param unknown_type $id_medida
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $id_unidad_constructiva
	 */
	function CrearActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra,$id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
	$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto,$id_ubicacion,$tension,$tipo_bien)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_iud';
		$this->codigo_procedimiento = "'AF_AF_INS'";
		
		if(strlen($tension) == 0 && strlen($tipo_bien) > 0)
			$tension_array="'{-1,".$tipo_bien."}'";
		else if (strlen($tension)== 0 && strlen($tipo_bien)==0)
		{
			$tension_array="'{-1,-1}'";
		}
		else
			$tension_array="'{".$tension.",".$tipo_bien."}'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_activo_fijo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$descripcion_larga'");//descripcion_larga
		$this->var->add_param($vida_util_original);//vida_util_original
		$this->var->add_param($vida_util_restante);//vida_util_restante
		$this->var->add_param($tasa_depreciacion);//tasa_depreciacion
		$this->var->add_param("'$fecha_ultima_deprec'");//fecha_ultima_deprec
		$this->var->add_param($depreciacion_acum_ant);//depreciacion_acum_ant
		$this->var->add_param($depreciacion_acum);//depreciacion_acum
		$this->var->add_param($depreciacion_periodo);//depreciacion_periodo
		$this->var->add_param("'$flag_revaloriz'");//flag_revaloriz
		$this->var->add_param($valor_rescate);//valor_rescate
		$this->var->add_param("'$fecha_compra'");//fecha_compra
		$this->var->add_param($monto_compra_mon_orig);//monto_compra_mon_orig
		$this->var->add_param($monto_compra);//monto_compra
		$this->var->add_param($monto_actual);//monto_actual
		$this->var->add_param("'$con_garantia'");//con_garantia
		$this->var->add_param("'$num_poliza_garantia'");//num_poliza_garantia
		$this->var->add_param("'$fecha_fin_gar'");//fecha_fin_gar
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("NULL");//foto_activo
		$this->var->add_param("'$num_factura'");//num_factura
		$this->var->add_param($tipo_cambio);//tipo_cambio
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param($id_sub_tipo_activo);//id_sub_tipo_activo
		$this->var->add_param($id_institucion);//id_institucion
		$this->var->add_param($id_moneda);//id_moneda
		$this->var->add_param($id_moneda_original);//id_moneda_original
		$this->var->add_param($id_unidad_constructiva);//id_unidad_constructiva
		$this->var->add_param("'$fecha_ini_dep'");//fecha_ini_dep
		$this->var->add_param("'$ubicacion_fisica'");//ubicacion_fisica
		$this->var->add_param("'$orden_compra'");//ubicacion_fisica
		$this->var->add_param($id_estado_funcional);//id_estado_funcional
		$this->var->add_param($monto_compra_2);//id_moneda_original
		$this->var->add_param($monto_actual_2);//id_unidad_constructiva
		$this->var->add_param($depreciacion_acum_2);//fecha_ini_dep
		$this->var->add_param($depreciacion_acum_ant_2);//ubicacion_fisica
		$this->var->add_param($depreciacion_periodo_2);//ubicacion_fisica
		$this->var->add_param($vida_util_2);//id_estado_funcional
		$this->var->add_param($vida_util_restante_2);//id_estado_funcional
		$this->var->add_param($id_depto);//id_estado_funcional
		$this->var->add_param($id_cotizacion);//id_estado_funcional
		$this->var->add_param($id_cotizacion_det);//id_estado_funcional
		$this->var->add_param("'$origen'");//id_estado_funcional
		//$this->var->add_param($id_frppa);//id_estado_funcional
		//$this->var->add_param($id_unidad_organizacional);//id_estado_funcional
		
		$this->var->add_param($id_presupuesto);//id_estado_funcional
		$this->var->add_param($id_lugar);//id_estado_funcional
		$this->var->add_param($id_gestion);//id_estado_funcional
		
		$this->var->add_param($id_solicitud_compra);//id_estado_funcional
		$this->var->add_param("'$clonacion'");//id_estado_funcional
		$this->var->add_param($id_clon);//id_estado_funcional
		$this->var->add_param($id_deposito);//id_deposito se añadio en fecha 10 ener 2011
		$this->var->add_param("'$tipo_af_bien'");//id_estado_funcional
		$this->var->add_param("'$proyecto'");//id_estado_funcional
		$this->var->add_param($id_ubicacion);//id_ubicacion
		$this->var->add_param("$tension_array");//tension
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

//		/echo $this->query; exit;
		/*print("<pre>");
		print_r($this->salida);
		print("</pre>");*/

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarActivoFijo
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_activo_fijo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo
	 * @return unknown
	 */
	function  EliminarActivoFijo($id_activo_fijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_iud';
		$this->codigo_procedimiento = "'AF_AF_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param("NULL");//código
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//descripcion_larga
		$this->var->add_param("NULL");//vida_util_original
		$this->var->add_param("NULL");//vida_util_restante
		$this->var->add_param("NULL");//tasa_depreciacion
		$this->var->add_param("NULL");//fecha_ultima_deprec
		$this->var->add_param("NULL");//depreciacion_acum_ant
		$this->var->add_param("NULL");//depreciacion_acum
		$this->var->add_param("NULL");//depreciacion_periodo
		$this->var->add_param("NULL");//flag_revaloriz
		$this->var->add_param("NULL");//valor_rescate
		$this->var->add_param("NULL");//fecha_compra
		$this->var->add_param("NULL");//monto_compra_mon_orig
		$this->var->add_param("NULL");//monto_compra
		$this->var->add_param("NULL");//monto_actual
		$this->var->add_param("NULL");//con_garantia
		$this->var->add_param("NULL");//num_poliza_garantia
		$this->var->add_param("NULL");//fecha_fin_gar
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//foto_activo
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//tipo_cambio
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//id_sub_tipo_activo
		$this->var->add_param("NULL");//id_institucion
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_moneda_original
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param("NULL");//fecha_ini_dep
		$this->var->add_param("NULL");//ubicacion_fisica
		$this->var->add_param("NULL");//ubicacion_fisica
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param("NULL");//monto_compra_2
		$this->var->add_param("NULL");//monto_actual_2
		$this->var->add_param("NULL");//depreciacion_acum_2
		$this->var->add_param("NULL");//depreciacion_acum_ant_2
		$this->var->add_param("NULL");//depreciacion_periodo_2
		$this->var->add_param("NULL");//vida_util_2
		$this->var->add_param("NULL");//vida_util_restante_2
		
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//id_cot
		$this->var->add_param("NULL");//id_cot_det
		$this->var->add_param("NULL");//origen
		//$this->var->add_param("NULL");//frppa
		//$this->var->add_param("NULL");//uo
		
		
		$this->var->add_param("NULL");//$id_presupuesto);//id_estado_funcional
		$this->var->add_param("NULL");//$id_lugar);//id_estado_funcional
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param("NULL");//id_deposito añadido en fecha 10 de ener 2011
		$this->var->add_param("NULL");//id_deposito añadido en fecha 10 de ener 2011
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param("NULL");//id_ubicacion
		$this->var->add_param("NULL");//tension
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarActivoFijo
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_activo_fijo de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		12-06-2007
	 *
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $descripcion_larga
	 * @param unknown_type $vida_util_original
	 * @param unknown_type $vida_util_restante
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $fecha_ultima_deprec
	 * @param unknown_type $depreciacion_acum_ant
	 * @param unknown_type $depreciacion_acum
	 * @param unknown_type $depreciacion_periodo
	 * @param unknown_type $flag_revaloriz
	 * @param unknown_type $valor_rescate
	 * @param unknown_type $fecha_compra
	 * @param unknown_type $monto_compra_mon_orig
	 * @param unknown_type $monto_compra
	 * @param unknown_type $monto_actual
	 * @param unknown_type $con_garantia
	 * @param unknown_type $num_poliza_garantia
	 * @param unknown_type $fecha_fin_gar
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $foto_activo
	 * @param unknown_type $num_factura
	 * @param unknown_type $tipo_cambio
	 * @param unknown_type $estado
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $id_institucion
	 * @param unknown_type $id_moneda
	 * @param unknown_type $id_moneda_original
	 * @param unknown_type $id_medida
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $id_unidad_constructiva
	 * @return unknown
	 */
	function  ModificarActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
	$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra, $clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto,$id_ubicacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_iud';
		$this->codigo_procedimiento = "'AF_AF_UPD'";

		/*echo"monto compra mon orig:".$monto_compra_mon_orig;
		echo"monto compra".$monto_compra;
		echo"monto actual:".$monto_actual;
		exit;*/
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param("'$codigo'");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$descripcion_larga'");//descripcion_larga
		$this->var->add_param($vida_util_original);//vida_util_original
		$this->var->add_param($vida_util_restante);//vida_util_restante
		$this->var->add_param($tasa_depreciacion);//tasa_depreciacion
		$this->var->add_param("'$fecha_ultima_deprec'");//fecha_ultima_deprec
		$this->var->add_param($depreciacion_acum_ant);//depreciacion_acum_ant
		$this->var->add_param($depreciacion_acum);//depreciacion_acum
		$this->var->add_param($depreciacion_periodo);//depreciacion_periodo
		$this->var->add_param("'$flag_revaloriz'");//flag_revaloriz
		$this->var->add_param($valor_rescate);//valor_rescate
		$this->var->add_param("'$fecha_compra'");//fecha_compra
		$this->var->add_param($monto_compra_mon_orig);//monto_compra_mon_orig
		$this->var->add_param($monto_compra);//monto_compra
		$this->var->add_param($monto_actual);//monto_actual
		$this->var->add_param("'$con_garantia'");//con_garantia
		$this->var->add_param("'$num_poliza_garantia'");//num_poliza_garantia
		$this->var->add_param("'$fecha_fin_gar'");//fecha_fin_gar
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("NULL");//foto_activo
		$this->var->add_param("'$num_factura'");//num_factura
		$this->var->add_param($tipo_cambio);//tipo_cambio
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param($id_sub_tipo_activo);//id_sub_tipo_activo
		$this->var->add_param($id_institucion);//id_institucion
		$this->var->add_param($id_moneda);//id_moneda
		$this->var->add_param($id_moneda_original);//id_moneda_original
		$this->var->add_param($id_unidad_constructiva);//id_unidad_constructiva
		$this->var->add_param("'$fecha_ini_dep'");//fecha_ini_dep
		$this->var->add_param("'$ubicacion_fisica'");//ubicacion_fisica
		$this->var->add_param("'$orden_compra'");//ubicacion_fisica
		$this->var->add_param($id_estado_funcional);//id_estado_funcional
		$this->var->add_param($monto_compra_2);//id_moneda_original
		$this->var->add_param($monto_actual_2);//id_unidad_constructiva
		$this->var->add_param($depreciacion_acum_2);//fecha_ini_dep
		$this->var->add_param($depreciacion_acum_ant_2);//ubicacion_fisica
		$this->var->add_param($depreciacion_periodo_2);//ubicacion_fisica
		$this->var->add_param($vida_util_2);//id_estado_funcional
		$this->var->add_param($vida_util_restante_2);//id_estado_funcional

		$this->var->add_param($id_depto);//id_depto
		$this->var->add_param($id_cotizacion);//id_depto
		$this->var->add_param($id_cotizacion_det);//id_depto
		$this->var->add_param("'$origen'");//id_depto
		//$this->var->add_param($id_frppa);//frppa
		//$this->var->add_param($id_unidad_organizacional);//frppa
		$this->var->add_param($id_presupuesto);//id_estado_funcional
		$this->var->add_param($id_lugar);//id_estado_funcional
		$this->var->add_param($id_gestion);//id_estado_funcional
		
		$this->var->add_param($id_solicitud_compra);//$id_gestion);//id_estado_funcional
		$this->var->add_param("'$clonacion'");//$id_gestion);//id_estado_funcional
		$this->var->add_param($id_clon);//id_estado_funcional
		$this->var->add_param($id_deposito);//id_deposito añadido en fecha 10 de enero 2011
		$this->var->add_param("'$tipo_af_bien'");//id_estado_funcional
		$this->var->add_param("'$proyecto'");//id_estado_funcional
		$this->var->add_param($id_ubicacion);//id_ubicacion
		$this->var->add_param("NULL");//tension
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	function CambiarActivoFijo($id_activo_fijo,$id_unidad_constructiva,$id_ubicacion,$ubicacion_fisica,$observaciones,$descripcion_larga,$id_estado_funcional,$descripcion,$num_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_iud';
		$this->codigo_procedimiento = "'AF_AF_MOD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param("NULL");//código
		$this->var->add_param("'$descripcion'");//descripcion
		$this->var->add_param("'$descripcion_larga'");//descripcion_larga
		$this->var->add_param("NULL");//vida_util_original
		$this->var->add_param("NULL");//vida_util_restante
		$this->var->add_param("NULL");//tasa_depreciacion
		$this->var->add_param("NULL");//fecha_ultima_deprec
		$this->var->add_param("NULL");//depreciacion_acum_ant
		$this->var->add_param("NULL");//depreciacion_acum
		$this->var->add_param("NULL");//depreciacion_periodo
		$this->var->add_param("NULL");//flag_revaloriz
		$this->var->add_param("NULL");//valor_rescate
		$this->var->add_param("NULL");//fecha_compra
		$this->var->add_param("NULL");//monto_compra_mon_orig
		$this->var->add_param("NULL");//monto_compra
		$this->var->add_param("NULL");//monto_actual
		$this->var->add_param("NULL");//con_garantia
		$this->var->add_param("NULL");//num_poliza_garantia
		$this->var->add_param("NULL");//fecha_fin_gar
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//foto_activo
		$this->var->add_param("'$num_factura'");//num_factura
		$this->var->add_param("NULL");//tipo_cambio
		$this->var->add_param("NULL");//estado
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("NULL");//id_sub_tipo_activo
		$this->var->add_param("NULL");//id_institucion
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_moneda_original
		$this->var->add_param($id_unidad_constructiva);//id_unidad_constructiva
		$this->var->add_param("NULL");//fecha_ini_dep
		$this->var->add_param("'$ubicacion_fisica'");//ubicacion_fisica
		$this->var->add_param("NULL");//nro_orden
		$this->var->add_param($id_estado_funcional);//id_estado_funcional
		$this->var->add_param("NULL");//monto_compra_2
		$this->var->add_param("NULL");//monto_actual_2
		$this->var->add_param("NULL");//depreciacion_acum_2
		$this->var->add_param("NULL");//depreciacion_acum_ant_2
		$this->var->add_param("NULL");//depreciacion_periodo_2
		$this->var->add_param("NULL");//vida_util_2
		$this->var->add_param("NULL");//vida_util_restante_2
		
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//id_cot
		$this->var->add_param("NULL");//id_cot_det
		$this->var->add_param("NULL");//origen
		//$this->var->add_param("NULL");//frppa
		//$this->var->add_param("NULL");//uo
		
		
		$this->var->add_param("NULL");//$id_presupuesto);//id_estado_funcional
		$this->var->add_param("NULL");//$id_lugar);//id_estado_funcional
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		$this->var->add_param("NULL");//$id_gestion);//id_estado_funcional
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param("NULL");//id_deposito añadido en fecha 10 de ener 2011
		$this->var->add_param("NULL");//id_deposito añadido en fecha 10 de ener 2011
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param($id_ubicacion);//id_ubicacion
		$this->var->add_param("NULL");//tension
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	//RCM: 29/10/2008
	//function ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	function ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		//$this->codigo_procedimiento = "'AF_CUADAF_SEL'";
		$this->nombre_funcion = 'f_taf_cuadro_activo_fijo_consultas';
		$this->codigo_procedimiento = "'AF_CUAFRE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		$this->var->add_param("'$fecha_desde'");
		$this->var->add_param("'$fecha_hasta'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('financiador','varchar');//0
		$this->var->add_def_cols('regional','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('subprograma','varchar');
		$this->var->add_def_cols('auxiliar','varchar');
		$this->var->add_def_cols('codigo','varchar');//5
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('valor_activo','numeric');
		$this->var->add_def_cols('incremento_actualiz','numeric');
		$this->var->add_def_cols('valor_actualiz','numeric');
		$this->var->add_def_cols('deprec_acum_ini','numeric');//10
		$this->var->add_def_cols('incremento_dep_actualiz','numeric');
		$this->var->add_def_cols('dep_actualiz','numeric');
		$this->var->add_def_cols('deprec_mensual','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');//15

		$this->var->add_def_cols('valor_activo_2','numeric');
		$this->var->add_def_cols('incremento_actualiz_2','numeric');
		$this->var->add_def_cols('valor_actualiz_2','numeric');
		$this->var->add_def_cols('deprec_acum_ini_2','numeric');
		$this->var->add_def_cols('incremento_dep_actualiz_2','numeric');//20
		$this->var->add_def_cols('dep_actualiz_2','numeric');
		$this->var->add_def_cols('deprec_mensual_2','numeric');
		$this->var->add_def_cols('depreciacion_acum_2','numeric');
		$this->var->add_def_cols('valor_neto_2','numeric');
		$this->var->add_def_cols('vida_util_original','integer');//25

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;

		return $res;
	}

	//RCM: 09/03/2009
	//function ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	function ListarCuadroActivoFijoContaAcum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		//$this->codigo_procedimiento = "'AF_CUADAF_SEL'";
		$this->nombre_funcion = 'f_taf_cuadro_activo_fijo_consultas';
		$this->codigo_procedimiento = "'AF_CUAFRE_ACUM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		$this->var->add_param("'$fecha_desde'");
		$this->var->add_param("'$fecha_hasta'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_activo_fijo','integer');//0
		$this->var->add_def_cols('fecha','date');//0
		$this->var->add_def_cols('financiador','varchar');//0
		$this->var->add_def_cols('regional','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('subprograma','varchar');
		$this->var->add_def_cols('auxiliar','varchar');
		$this->var->add_def_cols('codigo','varchar');//5
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('valor_activo','numeric');
		$this->var->add_def_cols('id_financiador','integer');
		$this->var->add_def_cols('id_regional','integer');
		$this->var->add_def_cols('id_programa','integer');
		$this->var->add_def_cols('id_proyecto','integer');
		$this->var->add_def_cols('id_auxiliar','integer');

		$this->var->add_def_cols('incremento_actualiz','numeric');
		$this->var->add_def_cols('valor_actualiz','numeric');
		$this->var->add_def_cols('deprec_acum_ini','numeric');//10
		$this->var->add_def_cols('incremento_dep_actualiz','numeric');
		$this->var->add_def_cols('dep_actualiz','numeric');
		$this->var->add_def_cols('deprec_mensual','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');//15

		$this->var->add_def_cols('valor_activo_2','numeric');
		$this->var->add_def_cols('incremento_actualiz_2','numeric');
		$this->var->add_def_cols('valor_actualiz_2','numeric');
		$this->var->add_def_cols('deprec_acum_ini_2','numeric');//10
		$this->var->add_def_cols('incremento_dep_actualiz_2','numeric');
		$this->var->add_def_cols('dep_actualiz_2','numeric');
		$this->var->add_def_cols('deprec_mensual_2','numeric');
		$this->var->add_def_cols('depreciacion_acum_2','numeric');
		$this->var->add_def_cols('valor_neto_2','numeric');//15
		$this->var->add_def_cols('vida_util_original','integer');//15

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;

		return $res;
	}

	//RCM: 19/03/2009
	function ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	//GVC: 27/07/2010
	//function ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti)
	
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		$this->codigo_procedimiento = "'AF_DETDEP_PRI_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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
		
		//$this->var->add_param($func->iif($id_fina_regi_prog_proy_acti == '',"'%'","'$id_fina_regi_prog_proy_acti'"));//id_ep

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo_activo','varchar');
		$this->var->add_def_cols('subtipo_activo','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('fecha_ini_dep','text');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('vida_util_original','integer');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('valor_contable','numeric');//10
		$this->var->add_def_cols('actualiz_valor','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('dep_acum_inicial','numeric');
		$this->var->add_def_cols('actualiz_dep','numeric');
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('dep_mensual','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');//20
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('factor_actualiz','numeric');

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

	//RCM: 19/03/2009
	function ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	//GVC: 27/07/2010
	//function ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti)
	
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_sel';
		$this->codigo_procedimiento = "'AF_DETDEP_SEC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
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

		//$this->var->add_param($func->iif($id_fina_regi_prog_proy_acti == '',"'%'","'$id_fina_regi_prog_proy_acti'"));//id_ep
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo_activo','varchar');
		$this->var->add_def_cols('subtipo_activo','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('fecha_ini_dep','text');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('vida_util_original','integer');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('valor_contable','numeric');//10
		$this->var->add_def_cols('actualiz_valor','numeric');
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('dep_acum_inicial','numeric');
		$this->var->add_def_cols('actualiz_dep','numeric');
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('dep_mensual','numeric');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');//20
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('factor_actualiz','numeric');

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
	 * Nombre de la función:	ModificarActivoFijoTension
	 * Propósito:				Modifica el campo tension en  actif.taf_activo_fijo
	 * Autor:					Elmer Velasquez
	 * Fecha creación:			18/06/2013
	 */
	function ModificarActivoFijoTension($id_activo_fijo,$tension,$tipo_bien)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_activo_fijo_iud';
		$this->codigo_procedimiento = "'AF_AF_UPD_TENSION'";

		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		if(strlen($tension) == 0)
			$tension_array="'{null,".$tipo_bien."}'";
		else
			$tension_array="'{".$tension.",".$tipo_bien."}'";

		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param("NULL");//código
		$this->var->add_param("NULL");//descripcion
		$this->var->add_param("NULL");//descripcion_larga
		$this->var->add_param("NULL");//vida_util_original
		$this->var->add_param("NULL");//vida_util_restante
		$this->var->add_param("NULL");//tasa_depreciacion
		$this->var->add_param("NULL");//fecha_ultima_deprec
		$this->var->add_param("NULL");//depreciacion_acum_ant
		$this->var->add_param("NULL");//depreciacion_acum
		$this->var->add_param("NULL");//depreciacion_periodo
		$this->var->add_param("NULL");//flag_revaloriz
		$this->var->add_param("NULL");//valor_rescate
		$this->var->add_param("NULL");//fecha_compra
		$this->var->add_param("NULL");//monto_compra_mon_orig
		$this->var->add_param("NULL");//monto_compra
		$this->var->add_param("NULL");//monto_actual
		$this->var->add_param("NULL");//con_garantia
		$this->var->add_param("NULL");//num_poliza_garantia
		$this->var->add_param("NULL");//fecha_fin_gar
		$this->var->add_param("NULL");//fecha_reg
		$this->var->add_param("NULL");//foto_activo
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//tipo_cambio
		$this->var->add_param("NULL");//estado
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//id_sub_tipo_activo
		$this->var->add_param("NULL");//id_institucion
		$this->var->add_param("NULL");//id_moneda
		$this->var->add_param("NULL");//id_moneda_original
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param("NULL");//fecha_ini_dep
		$this->var->add_param("NULL");//ubicacion_fisica
		$this->var->add_param("NULL");//orden_compra
		$this->var->add_param("NULL");//id_estado_funcional
		$this->var->add_param("NULL");//monto_compra_2
		$this->var->add_param("NULL");//monto_actual_2
		$this->var->add_param("NULL");//depreciacion_acum_2
		$this->var->add_param("NULL");//depreciacion_acum_ant_2
		$this->var->add_param("NULL");//depreciacion_periodo_2
		$this->var->add_param("NULL");//vida_util_2
		$this->var->add_param("NULL");//vida_util_restatbte_2
		$this->var->add_param("NULL");//id_depto
		$this->var->add_param("NULL");//id_cotizacion
		$this->var->add_param("NULL");//id_cotizacion_det
		$this->var->add_param("NULL");//origen
		$this->var->add_param("NULL");//id_presupuesto
		$this->var->add_param("NULL");//id_lugar
		$this->var->add_param("NULL");//id_gestion
		$this->var->add_param("NULL");//id_solicitud_compra
		$this->var->add_param("NULL");//clonacion
		$this->var->add_param("NULL");//af_is_clon_origen
		$this->var->add_param("NULL");//id_deposito
		$this->var->add_param("NULL");//tipo_af_bien
		$this->var->add_param("NULL");//proyecto
		$this->var->add_param("NULL");//id-ubicacion
		$this->var->add_param("$tension_array");//af_tension

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit();
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarActivoFijo
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			12-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $descripcion_larga
	 * @param unknown_type $vida_util_original
	 * @param unknown_type $vida_util_restante
	 * @param unknown_type $tasa_depreciacion
	 * @param unknown_type $fecha_ultima_deprec
	 * @param unknown_type $depreciacion_acum_ant
	 * @param unknown_type $depreciacion_acum
	 * @param unknown_type $depreciacion_periodo
	 * @param unknown_type $flag_revaloriz
	 * @param unknown_type $valor_rescate
	 * @param unknown_type $fecha_compra
	 * @param unknown_type $monto_compra_mon_orig
	 * @param unknown_type $monto_compra
	 * @param unknown_type $monto_actual
	 * @param unknown_type $con_garantia
	 * @param unknown_type $num_poliza_garantia
	 * @param unknown_type $fecha_fin_gar
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $foto_activo
	 * @param unknown_type $num_factura
	 * @param unknown_type $tipo_cambio
	 * @param unknown_type $estado
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_sub_tipo_activo
	 * @param unknown_type $id_institucion
	 * @param unknown_type $id_moneda
	 * @param unknown_type $id_moneda_original
	 * @param unknown_type $id_medida
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $id_unidad_constructiva
	 * @return unknown
	 */
	function ValidarActivoFijo($operacion_sql, $id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$fecha_alta,$id_deposito)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();
		$tipo_dato = new cls_define_tipo_dato();
		//Ejecuta la validación por el tipo de operación
		//Validar id_cotizacion - tipo int4
		
	if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
			}
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(20);
				$tipo_dato->set_Columna("codigo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
				{
					$this->salida = $valid->salida;
					return false;
				}
		
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(100);
				$tipo_dato->set_Columna("descripcion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(5000);
				$tipo_dato->set_Columna("descripcion_larga");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion_larga", $descripcion_larga))
				{
					$this->salida = $valid->salida;
					return false;
				}
		
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("vida_util_original");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "vida_util_original",$vida_util_original))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("vida_util_restante");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "vida_util_restante",$vida_util_restante))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("tasa_depreciacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tasa_depreciacion",$tasa_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("fecha_ultima_deprec");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ultima_deprec",$fecha_ultima_deprec))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("depreciacion_acum_ant");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "depreciacion_acum_ant",$depreciacion_acum_ant))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("depreciacion_acum");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "depreciacion_acum",$depreciacion_acum))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("depreciacion_periodo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "depreciacion_periodo",$depreciacion_periodo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(2);
				$tipo_dato->set_Columna("flag_revaloriz");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "flag_revaloriz",$flag_revaloriz))
				{
					$this->salida = $valid->salida;
					return false;
				}

				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("valor_rescate");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "valor_rescate",$valor_rescate))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("fecha_compra");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_compra",$fecha_compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("monto_compra_mon_orig");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto_compra_mon_orig",$monto_compra_mon_orig))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
					
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("monto_compra");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto_compra",$monto_compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
					
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(18);
				$tipo_dato->set_Columna("monto_actual");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto_actual",$monto_actual))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
					
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(2);
				$tipo_dato->set_Columna("con_garantia");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "con_garantia",$con_garantia))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(20);
				$tipo_dato->set_Columna("num_poliza_garantia");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "num_poliza_garantia",$num_poliza_garantia))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
					
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("fecha_fin_gar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin_gar",$fecha_fin_gar))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("fecha_reg");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_reg",$fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("num_factura");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "num_factura",$num_factura))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("tipo_cambio");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "tipo_cambio",$tipo_cambio))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(20);
				$tipo_dato->set_Columna("estado");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado",$estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
					$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(500);
				$tipo_dato->set_Columna("observaciones");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones",$observaciones))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_sub_tipo_activo");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_sub_tipo_activo",$id_sub_tipo_activo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_AllowBlank('true');
				$tipo_dato->set_Columna("id_institucion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion",$id_institucion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				


				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_moneda");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda",$id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_moneda_original");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda_original",$id_moneda_original))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_AllowBlank('true');
				$tipo_dato->set_Columna("id_unidad_constructiva");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva",$id_unidad_constructiva))
				{
					$this->salida = $valid->salida;
					return false;
				}
//echo $fecha_ini_dep; exit;

				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("fecha_ini_dep");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_ini_dep",$fecha_ini_dep))
				{
					$this->salida = $valid->salida;
					return false;
				}
		
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(300);
				$tipo_dato->set_Columna("ubicacion_fisica");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ubicacion_fisica",$ubicacion_fisica))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(20);
				$tipo_dato->set_Columna("orden_compra");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "orden_compra",$orden_compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
				
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_estado_funcional");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_estado_funcional",$id_estado_funcional))
				{
					$this->salida = $valid->salida;
					return false;
				}
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_deposito");
   //echo "el id_Deposito es: ".$id_deposito; exit;
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_deposito",$id_deposito))
				{
					$this->salida = $valid->salida;
					return false;
				}
			
			
				return true;				
				
		
			
		}elseif ($operacion_sql=='delete')
		{
			//Validar id_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_activo_fijo");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_activo_fijo", $id_activo_fijo))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
	}

	
	function ClonarActivoFijo($id_activo_fijo,$cant_clones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_clonar_activo_fijo';
		$this->codigo_procedimiento = "'AF_CLONAF_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($cant_clones);//código
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
	
	function CodificarActivo($id_activo_fijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_af_obtener_codigo';
		$this->codigo_procedimiento = "'AF_CODIGO_GEN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
	
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

}?>