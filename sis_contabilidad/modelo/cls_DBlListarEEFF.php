<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */
class cls_DBlListarEEFFBG
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
	function ContarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_consolidado_new_jgl';
		$this->codigo_procedimiento = "'CT_EEFFCONSOLIDADO_COUNT'";

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

		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$ct_fecha_inicial'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	 	//echo $this->query;exit;
		return $res;
	}
	function listarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_consolidado_new_jgl';
		$this->codigo_procedimiento = "'CT_EEFFCONSOLIDADO_SEL'";

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

		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$ct_fecha_inicial'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('nro_cuenta','VARCHAR');
		$this->var->add_def_cols('nombre_cuenta', 'VARCHAR');
		$this->var->add_def_cols('nro_cuenta_sigma','VARCHAR');
		$this->var->add_def_cols('nombre_cuenta_sigma', 'VARCHAR');
		$this->var->add_def_cols('depto_0', 'VARCHAR');
		$this->var->add_def_cols('depto_1', 'VARCHAR');
		$this->var->add_def_cols('depto_2', 'VARCHAR');
		$this->var->add_def_cols('depto_3', 'VARCHAR');
		$this->var->add_def_cols('depto_4', 'VARCHAR');
		$this->var->add_def_cols('depto_5', 'VARCHAR');
		$this->var->add_def_cols('depto_6', 'VARCHAR');
		$this->var->add_def_cols('depto_7', 'VARCHAR');
		$this->var->add_def_cols('depto_8', 'VARCHAR');
		$this->var->add_def_cols('depto_9', 'VARCHAR');
		$this->var->add_def_cols('depto_10', 'VARCHAR');
		$this->var->add_def_cols('depto_11', 'VARCHAR');
		$this->var->add_def_cols('depto_12', 'VARCHAR');
		$this->var->add_def_cols('depto_13', 'VARCHAR');
		$this->var->add_def_cols('depto_14', 'VARCHAR');
		$this->var->add_def_cols('depto_15', 'VARCHAR');
		$this->var->add_def_cols('depto_16', 'VARCHAR');
		$this->var->add_def_cols('depto_17', 'VARCHAR');
		$this->var->add_def_cols('depto_18', 'VARCHAR');
		$this->var->add_def_cols('depto_19', 'VARCHAR');
		$this->var->add_def_cols('depto_20', 'VARCHAR');
		$this->var->add_def_cols('depto_21', 'VARCHAR');
		$this->var->add_def_cols('depto_22', 'VARCHAR');
		$this->var->add_def_cols('depto_23', 'VARCHAR');
		$this->var->add_def_cols('depto_24', 'VARCHAR');
		$this->var->add_def_cols('depto_25', 'VARCHAR');
		$this->var->add_def_cols('depto_26', 'VARCHAR');
		$this->var->add_def_cols('depto_27', 'VARCHAR');
		$this->var->add_def_cols('depto_28', 'VARCHAR');
		$this->var->add_def_cols('depto_29', 'VARCHAR');
		$this->var->add_def_cols('depto_30', 'VARCHAR');
		$this->var->add_def_cols('total', 'VARCHAR');
		
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
	function ContarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_consolidado_periodico_new_jgl';
		$this->codigo_procedimiento = "'CT_EEFFPERIODO_COUNT'";

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

		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$id_periodos'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	 	//echo $this->query;exit;
		return $res;
	}
	function listarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_consolidado_periodico_new_jgl';
		$this->codigo_procedimiento = "'CT_EEFFPERIODO_SEL'";

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

		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$id_periodos'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		$this->var->add_def_cols('nro_cuenta','VARCHAR');
		$this->var->add_def_cols('nombre_cuenta', 'VARCHAR');
		$this->var->add_def_cols('mes_1', 'NUMERIC');
		$this->var->add_def_cols('mes_2', 'NUMERIC');
		$this->var->add_def_cols('mes_3', 'NUMERIC');
		$this->var->add_def_cols('mes_4', 'NUMERIC');
		$this->var->add_def_cols('mes_5', 'NUMERIC');
		$this->var->add_def_cols('mes_6', 'NUMERIC');
		$this->var->add_def_cols('mes_7', 'NUMERIC');
		$this->var->add_def_cols('mes_8', 'NUMERIC');
		$this->var->add_def_cols('mes_9', 'NUMERIC');
		$this->var->add_def_cols('mes_10', 'NUMERIC');
		$this->var->add_def_cols('mes_11', 'NUMERIC');
		$this->var->add_def_cols('mes_12', 'NUMERIC');
		$this->var->add_def_cols('total', 'NUMERIC');
		 
		
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
	 * Nombre de la función:	ListarDestino
	 * Propósito:				Desplegar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function listarEEFFCuentaResultado($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto, $id_rubro,$ct_fecha_eeff_ini)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cuenta_resultado_pro';
		$this->codigo_procedimiento = "'PR_EEFFBG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->add_param("$ct_id_parametro");//id_lec_irre
		$this->var->add_param("$ct_id_moneda");//id_lectura
		$this->var->add_param("'$ct_ids_fuente_financiamiento'");//id_cod_irre
		$this->var->add_param("'$ct_ids_u_o'");//id_lec_irre
		$this->var->add_param("'$ct_ids_financiador'");//id_lectura
		$this->var->add_param("'$ct_ids_regional'");//id_lectura
		$this->var->add_param("'$ct_ids_programa'");//id_cod_irre
		$this->var->add_param("'$ct_ids_proyecto'");//id_lec_irre
		$this->var->add_param("'$ct_ids_actividad'");//id_lectura
		$this->var->add_param("'$ct_fecha_eeff'");//id_lectura
		$this->var->add_param("$ct_nivel");//id_lectura
		$this->var->add_param("$ct_id_cuenta");//id_lectura
		$this->var->add_param("$pm_id_usuario");//id_lectura
		$this->var->add_param("'PR_EEFFBG_SEL'");//id_lectura
		$this->var->add_param("$id_rubro");//$id_rubro
		$this->var->add_param("'$id_depto'");//id_depto
		$this->var->add_param("'$ct_fecha_eeff_ini'");//id_depto
			
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_cuenta_padre', 'integer');
		$this->var->add_def_cols('id_auxiliar', 'integer');
		$this->var->add_def_cols('nro_cuenta', 'varchar');
		$this->var->add_def_cols('codigo_auxiliar', 'varchar');
		$this->var->add_def_cols('nombre_cuenta', 'varchar');
		$this->var->add_def_cols('nombre_auxiliar', 'varchar');
		$this->var->add_def_cols('nivel_cuenta', 'numeric');
		$this->var->add_def_cols('id_moneda', 'integer');
		$this->var->add_def_cols('saldo', 'numeric');
		//Ejecuta la función de consulta
		//Ejecuta la función de consultaecj
		$res = $this->var->exec_query_sss();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;		exit;
		return $res;
	}/**
	 * Nombre de la función:	ListarDestino
	 * Propósito:				Desplegar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function listarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto, $id_rubro,$ct_fecha_eeff_ini,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cuenta_pro_aux';
		$this->codigo_procedimiento = "'PR_EEFFBG_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->add_param("$ct_id_parametro");//id_lec_irre
		$this->var->add_param("$ct_id_moneda");//id_lectura
		$this->var->add_param("'$ct_ids_fuente_financiamiento'");//id_cod_irre
		$this->var->add_param("'$ct_ids_u_o'");//id_lec_irre
		$this->var->add_param("'$ct_ids_financiador'");//id_lectura
		$this->var->add_param("'$ct_ids_regional'");//id_lectura
		$this->var->add_param("'$ct_ids_programa'");//id_cod_irre
		$this->var->add_param("'$ct_ids_proyecto'");//id_lec_irre
		$this->var->add_param("'$ct_ids_actividad'");//id_lectura
		$this->var->add_param("'$ct_fecha_eeff'");//id_lectura
		$this->var->add_param("$ct_nivel");//id_lectura
		$this->var->add_param("$ct_id_cuenta");//id_lectura
		$this->var->add_param("$pm_id_usuario");//id_lectura
		$this->var->add_param("'PR_EEFFBG_SEL'");//id_lectura
		$this->var->add_param("'$id_depto'");//id_depto
		$this->var->add_param("$id_rubro");//$id_rubro
		$this->var->add_param("'$ct_fecha_eeff_ini'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('id_cuenta','integer');
		$this->var->add_def_cols('id_cuenta_padre', 'integer');
		$this->var->add_def_cols('id_auxiliar', 'integer');
		$this->var->add_def_cols('nro_cuenta', 'varchar');
		$this->var->add_def_cols('codigo_auxiliar', 'varchar');
		$this->var->add_def_cols('nombre_cuenta', 'varchar');
		$this->var->add_def_cols('nombre_auxiliar', 'varchar');
		$this->var->add_def_cols('nivel_cuenta', 'numeric');
		$this->var->add_def_cols('id_moneda', 'integer');
		$this->var->add_def_cols('saldo', 'numeric');
		//Ejecuta la función de consulta
		//Ejecuta la función de consultaecj
		$res = $this->var->exec_query_sss();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	function ContarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cuenta_pro_aux';
		$this->codigo_procedimiento = "'PR_EEFFBG_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->add_param("$ct_id_parametro");//id_lec_irre
		$this->var->add_param("$ct_id_moneda");//id_lectura
		$this->var->add_param("'$ct_ids_fuente_financiamiento'");//id_cod_irre
		$this->var->add_param("'$ct_ids_u_o'");//id_lec_irre
		$this->var->add_param("'$ct_ids_financiador'");//id_lectura
		$this->var->add_param("'$ct_ids_regional'");//id_lectura
		$this->var->add_param("'$ct_ids_programa'");//id_cod_irre
		$this->var->add_param("'$ct_ids_proyecto'");//id_lec_irre
		$this->var->add_param("'$ct_ids_actividad'");//id_lectura
		$this->var->add_param("'$ct_fecha_eeff'");//id_lectura
		$this->var->add_param("$ct_nivel");//id_lectura
		$this->var->add_param("$ct_id_cuenta");//id_lectura
		$this->var->add_param("$pm_id_usuario");//id_lectura
		$this->var->add_param("'PR_EEFFBG_COUNT'");//id_lectura
		$this->var->add_param("'$id_depto'");//id_lectura
		$this->var->add_param("$id_rubro");//id_lectura
		$this->var->add_param("'$ct_fecha_eeff_ini'");//id_lectura
		$this->var->add_param("'$sw_transaccional'");//id_lectura
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		//Ejecuta la función de consulta
		//Ejecuta la función de consultaecj
		$res = $this->var->exec_query_sss();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
		exit;*/
		return $res;
	}
	function ListarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_bg_pro';
		$this->codigo_procedimiento = "'PR_EEFFBG_SEL'";

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
		$this->var->add_param("$id_reporte_eeff");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$fecha_eeff'");//raiz
		$this->var->add_param("$nivel");//raiz
		$this->var->add_param("'$id_depto'");//raiz
		$this->var->add_param("'$fecha_eeff_ini'");//raiz
		$this->var->add_param("'$sw_actualizacion'");//raiz		 
	 		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cuenta','INTEGER');
		$this->var->add_def_cols('id_cuenta_padre','INTEGER');
		$this->var->add_def_cols('id_auxiliar','INTEGER');
		$this->var->add_def_cols('nro_cuenta','varchar');
		
		$this->var->add_def_cols('codigo_auxiliar','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
		$this->var->add_def_cols('nivel_cuenta','numeric');
		$this->var->add_def_cols('id_moneda','INTEGER');		
		$this->var->add_def_cols('saldo ','numeric');
 
   
 
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
	 * Nombre de la función:	ContarDestino
	 * Propósito:				Contar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
		
		
   	function ContarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,
   	$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,
   	$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion)
	{  
		/*echo $id_reporte_eeff."   ".$id_parametro."   ".$id_moneda."   ".$fecha_eeff."   ".$nivel;
		exit();*/
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_bg_pro';
		$this->codigo_procedimiento = "'PR_EEFFBG_COUNT'";

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
		$this->var->add_param("$id_reporte_eeff");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$fecha_eeff'");//raiz
		$this->var->add_param("$nivel");//raiz
		$this->var->add_param("'$id_depto'");//raiz
		$this->var->add_param("'$fecha_eeff_ini'");//raiz
		$this->var->add_param("'$sw_actualizacion'");//raiz
	
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
	
	//--JMH
	function ContarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_saldos_bancarios_periodo';
		$this->codigo_procedimiento = "'CT_SABAPE_COUNT'";

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

		
		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$id_periodos'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	 	//echo $this->query;exit;
		return $res;
	}
	function ListarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_saldos_bancarios_periodo';
		$this->codigo_procedimiento = "'CT_SABAPE_SEL'";

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

	
		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_reporte_eeff");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$id_periodos'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('id_reporte', 'text');
		$this->var->add_def_cols('nombre_auxiliar', 'varchar');
		$this->var->add_def_cols('periodo', 'NUMERIC');
		$this->var->add_def_cols('ingreso', 'NUMERIC');
		$this->var->add_def_cols('egreso', 'NUMERIC');
		$this->var->add_def_cols('saldo', 'NUMERIC');
		$this->var->add_def_cols('saldo_acumulado', 'NUMERIC');
			 
		
 		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;	exit;
		return $res;
	}
	//--fin JMH
	
	/**
	 * Nombre de la función:	EstadoSumasySaldos
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ContarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_sumasysaldos_sel';
		$this->codigo_procedimiento = "'CT_ESTSUMSAL_COUNT'";

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

	
		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$ct_fecha_inicial'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	 	//echo $this->query;exit;
		return $res;
	}
	function ListarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_eeff_sumasysaldos_sel';
		$this->codigo_procedimiento = "'CT_ESTSUMSAL_SEL'";

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

		//Carga los parámetros del filtro
	 	$this->var->add_param("'$ct_deptos'");//$id_rubro
		$this->var->add_param("$ct_id_moneda");//$id_rubro
		$this->var->add_param("'$ct_fecha'");//$id_rubro
		$this->var->add_param("$ct_id_parametro");//$id_rubro
		$this->var->add_param("$ct_nivel");//$id_rubro
		$this->var->add_param("'$ct_fecha_inicial'");//$id_rubro
		$this->var->add_param("'$sw_transaccional'");//$id_rubro
		
		$this->var->add_def_cols('id_cuenta','VARCHAR');
		$this->var->add_def_cols('id_cuenta_padre', 'INTEGER');
		$this->var->add_def_cols('nivel_cuenta', 'NUMERIC');
		$this->var->add_def_cols('nro_cuenta', 'TEXT');
		$this->var->add_def_cols('nombre_cuenta', 'VARCHAR');
		$this->var->add_def_cols('id_auxiliar', 'INTEGER');
		$this->var->add_def_cols('importe_debe', 'NUMERIC');
		$this->var->add_def_cols('importe_haber', 'NUMERIC'); 
		$this->var->add_def_cols('saldo_debe', 'NUMERIC');
		$this->var->add_def_cols('saldo_haber', 'NUMERIC'); 
		
 		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;exit;
		return $res;
	}
}?>