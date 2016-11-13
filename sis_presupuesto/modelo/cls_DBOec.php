<?php
/**
 * Nombre de la clase:	cls_DBOecArb.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla presto.tpr_oec
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 15:46:18
 */
class cls_DBOec{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;

	function __construct(){
		$this->decodificar=$decodificar;
	}
	/**
	 * ***********************************************************
	 * Para el Mannejo de Árboles
	 * 
	 * 
	 ************************************************************* 
	 */
	/**
	 * Nombre de la función:	ListarOecRaiz
	 * Propósito:				Desplegar los registros de tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	
	
	function ListarOecRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARGAS_RAIZ_SEL'";

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
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//id_presupuesto
        $this->var->add_param("$gestion");//gestion
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('estado_gral','numeric');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('sw_movimiento','numeric');
		$this->var->add_def_cols('dig_nivel','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ListarOecIngresoRaiz
	 * Propósito:				Desplegar los registros de tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarOecIngresoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARING_RAIZ_SEL'";

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
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//id_presupuesto
        $this->var->add_param("$gestion");//gestion
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('estado_gral','numeric');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('sw_movimiento','numeric');
		$this->var->add_def_cols('dig_nivel','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarDetalleOecAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARASI_RAIZ_SEL'";

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
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
        $this->var->add_param("NULL");//raiz
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('sw_movimiento','numeric');
		$this->var->add_def_cols('checked','BOOLEAN');
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
	
	function ListarDetalleOecAsignacionRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_oec,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARASI_RAMA_SEL'";

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
		$this->var->add_param($id_oec);//raiz
		$this->var->add_param($id_presupuesto);//id_presupuesto
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','integer');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('sw_movimiento','numeric');
		$this->var->add_def_cols('checked','boolean');
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
	
	
	/**
	 * Nombre de la función:	ListarOecArb
	 * Propósito:				Desplegar los registros de tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARGAS_ARB_SEL'";

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
		$this->var->add_param("$agrupador");//raiz
		$this->var->add_param("NULL");//id_presupuesto
        $this->var->add_param("$gestion");//gestion
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('gestion_pres','numeric');
		$this->var->add_def_cols('estado_gral','numeric');
		$this->var->add_def_cols('id_oec_padre','integer');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('codigo_padre','varchar');
		$this->var->add_def_cols('tipo_memoria','numeric');
		$this->var->add_def_cols('sw_movimiento','numeric');
		$this->var->add_def_cols('dig_nivel','integer');
		$this->var->add_def_cols('id_concepto_colectivo','integer');
		$this->var->add_def_cols('desc_colectivo','varchar');
		$this->var->add_def_cols('id_oec_sigma','integer');
		$this->var->add_def_cols('ent_trf','varchar');
		$this->var->add_def_cols('cod_ascii','varchar');
		$this->var->add_def_cols('cod_excel','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('cod_trans','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarOecArb
	 * Propósito:				Contar los registros de tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_sel';
		$this->codigo_procedimiento = "'PR_PARGAS_ARB_COUNT'";
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
		$this->var->add_param("$raiz");//raiz
		$this->var->add_param("NULL");//id_presupuesto
		$this->var->add_param("$gestion");//gestion
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;
		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res){
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarOecRaiz
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarOecRaiz($id_oec,$codigo_oec,$nombre_oec,$nivel_oec,$sw_transaccional,$tipo_oec,$id_parametro,$id_oec_padre,$tipo_memoria,$desc_oec){
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_iud';
		$this->codigo_procedimiento = "'PR_PARGASRAI_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("$nivel_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("NULL");
		$this->var->add_param("$tipo_memoria");
		$this->var->add_param("'$desc_oec'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_oec_sigma
		$this->var->add_param("NULL");//ent_trf
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
	 * Nombre de la función:	InsertarOecArb
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_oec
	 * Autor:				    (autogenerado)	
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarOecArb($id_oec,$codigo_oec,$nombre_oec,$nivel_oec,$sw_transaccional,$tipo_oec,$id_parametro,$id_oec_padre,$tipo_memoria,$desc_oec,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans){
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_ARB_INS'";
			
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("$nivel_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("$id_oec_padre");
		$this->var->add_param("$tipo_memoria");
		$this->var->add_param("'$desc_oec'");
		$this->var->add_param("$sw_movimiento");
		
		if($id_concepto_colectivo=="-1"){$this->var->add_param("null");}
		else {$this->var->add_param("$id_concepto_colectivo");}       
		
		$this->var->add_param("$id_oec_sigma");
		$this->var->add_param("'$ent_trf'");
		$this->var->add_param("'$cod_ascii'");
		$this->var->add_param("'$cod_excel'");
		$this->var->add_param("'$cod_trans'");
		 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query ;
		exit();*/
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarOecArb
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarOecArb($id_oec,$codigo_oec,$nombre_oec,$nivel_oec,$sw_transaccional,$tipo_oec,$id_parametro,$id_oec_padre,$tipo_memoria,$desc_oec,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans){
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_ARB_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_oec");
		$this->var->add_param("'$codigo_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("$nivel_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$id_parametro");
		$this->var->add_param("$id_oec_padre");
		$this->var->add_param("$tipo_memoria");
		$this->var->add_param("'$desc_oec'");
        $this->var->add_param("$sw_movimiento");
        
        if($id_concepto_colectivo=="-1"){
        		$this->var->add_param("null");
        }
		else {
			$this->var->add_param("$id_concepto_colectivo");
		}     
		
		$this->var->add_param("$id_oec_sigma");//id_oec_sigma
		$this->var->add_param("'$ent_trf'");//ent_trf
		$this->var->add_param("'$cod_ascii'");
		$this->var->add_param("'$cod_excel'");
		$this->var->add_param("'$cod_trans'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*echo $this->query ;
		exit;*/
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarOecArb
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarOecArb($id_oec,$id_oec_padre){
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_iud';
		$this->codigo_procedimiento = "'PR_PARGAS_ARB_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_oec");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_oec_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");
        $this->var->add_param("NULL");//id_oec_sigma
		$this->var->add_param("NULL");//ent_trf
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
	 * Nombre de la función:	EliminarOecRaiz
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarOecRaiz($id_oec){
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_arb_iud';
		$this->codigo_procedimiento = "'PR_PARGASRAI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_oec");
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
        $this->var->add_param("NULL");//id_oec_sigma
		$this->var->add_param("NULL");//ent_trf
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ListarOec
	 * Propósito:				Desplegar los registros de tpr_oec
	 * Autor:				    ana villegas 
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_sel';
		$this->codigo_procedimiento = "'PR_OEC_SEL'";
	
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
		$this->var->add_def_cols('id_oec','integer');
		$this->var->add_def_cols('codigo_oec','VARCHAR(20)'); 
		$this->var->add_def_cols('sigla_oec','VARCHAR(4)'); 
		$this->var->add_def_cols('desc_oec','VARCHAR(150)'); 
		$this->var->add_def_cols('sw_transaccional','NUMERIC');
		$this->var->add_def_cols('nivel_oec','NUMERIC');
		$this->var->add_def_cols('id_oec_padre','INTEGER');
		$this->var->add_def_cols('id_parametro','INTEGER');
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;
               /*echo $this->query;
               exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarOec
	 * Propósito:				Contar los registros de tpr_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'presto.f_tpr_oec_sel';
		$this->codigo_procedimiento = "'PR_OEC_COUNT'";
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
		if($res){
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
}?>