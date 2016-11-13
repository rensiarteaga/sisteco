<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBlListarEjecucionPartida 
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
	 * Nombre de la función:	ListarDestino
	 * Propósito:				Desplegar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ListarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_consolidacion_ejecucion';
		$this->codigo_procedimiento = "'PR_CONSISEJE_SEL'";

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
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$ids_presupuesto'");//$ids_presupuesto
		$this->var->add_param("'$ids_depto'");//$ids_depto
		$this->var->add_param("$id_moneda");//$id_moneda 
	
	 	/*$this->var->add_param($id_partida);//id_partida*/
	 		$this->var->add_def_cols('id_partida','integer');
	 		$this->var->add_def_cols('codigo_partida','varchar');
	 		$this->var->add_def_cols('nombre_partida','varchar');
	 		$this->var->add_def_cols('gasto','NUMERIC');
	 		$this->var->add_def_cols('devengado','NUMERIC');
	 		$this->var->add_def_cols('diferencia','NUMERIC');
            
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
   //echo $this->query;exit();
		return $res;
	}
	
	function ContarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_consolidacion_ejecucion';
		$this->codigo_procedimiento = "'PR_CONSISEJE_COUNT'";
		 
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

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
	 	
		$this->var->add_param("'$fecha_fin'");//$fecha_fin
		$this->var->add_param("'$fecha_ini'");//$fecha_ini
		$this->var->add_param("'$ids_presupuesto'");//$ids_presupuesto
		$this->var->add_param("'$ids_depto'");//$ids_depto
		$this->var->add_param("$id_moneda");//$id_moneda 
	 	//$this->var->add_param("'$fecha_ini'");//raiz
		
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
	/*	echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function ListarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_pro';
		$this->codigo_procedimiento = "'PR_EJEPAR_SEL'";

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$ids_concepto_colectivo'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	//$this->var->add_param("'$fecha_ini'");//raiz
		
	 		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_partida','INTEGER');//1
		$this->var->add_def_cols('codigo_partida','VARCHAR');//2 ///PDF
		$this->var->add_def_cols('nombre_partida','text');//3 ///PDF
		$this->var->add_def_cols('desc_partida','VARCHAR');//4
		$this->var->add_def_cols('nivel_partida','NUMERIC');//5
		$this->var->add_def_cols('sw_transaccional','NUMERIC');//6 ///PDF
		$this->var->add_def_cols('tipo_partida','NUMERIC');//7
		$this->var->add_def_cols('id_parametro','INTEGER');//8
		$this->var->add_def_cols('id_partida_padre','INTEGER');//9
		$this->var->add_def_cols('tipo_memoria','NUMERIC');//10
		$this->var->add_def_cols('sw_movimiento','NUMERIC');//11
		$this->var->add_def_cols('id_concepto_colectivo','INTEGER');   //12
 		$this->var->add_def_cols('mes_01','NUMERIC');//13
		$this->var->add_def_cols('mes_02','NUMERIC');//14
		$this->var->add_def_cols('mes_03','NUMERIC');//15
		$this->var->add_def_cols('mes_04','NUMERIC');//16
		$this->var->add_def_cols('mes_05','NUMERIC');//17
		$this->var->add_def_cols('mes_06','NUMERIC');//18
		$this->var->add_def_cols('mes_07','NUMERIC');//19
		$this->var->add_def_cols('mes_08','NUMERIC');//20
		$this->var->add_def_cols('mes_09','NUMERIC');//21
		$this->var->add_def_cols('mes_10','NUMERIC');//22
		$this->var->add_def_cols('mes_11','NUMERIC');//23
		$this->var->add_def_cols('mes_12','NUMERIC');//24
		$this->var->add_def_cols('total','NUMERIC');//25 ///PDF
		$this->var->add_def_cols('comprometido','NUMERIC');//26 ///PDF
		$this->var->add_def_cols('revertido','NUMERIC');//27  ///PDF
		$this->var->add_def_cols('saldo_por_comprometer','NUMERIC');//28  ///PDF
		$this->var->add_def_cols('devengado','NUMERIC');//29 ///PDF
		$this->var->add_def_cols('pagado','NUMERIC');//30 ///PDF
		$this->var->add_def_cols('saldo_por_devengar','NUMERIC');//31 ///PDF
		$this->var->add_def_cols('saldo_por_ingresar','NUMERIC');//32 ///PDF
		$this->var->add_def_cols('traspaso','NUMERIC');//33 ///PDF
		$this->var->add_def_cols('reformulacion','NUMERIC');//34 ///PDF
		$this->var->add_def_cols('presupuesto_vigente','NUMERIC');//35 ///PDF
		$this->var->add_def_cols('saldo_por_devengar_ingreso','NUMERIC');//36
 
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
	function ContarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_pro';
		$this->codigo_procedimiento = "'PR_EJEPAR_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$ids_concepto_colectivo'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	//$this->var->add_param("'$fecha_ini'");//raiz
      
		
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
		/*	echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function ListarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_fech';
		$this->codigo_procedimiento = "'PR_EJEFECH_SEL'";

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	$this->var->add_param("'$fecha_ini'");//raiz
	 		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_partida','INTEGER');//1
		$this->var->add_def_cols('codigo_partida','VARCHAR');//2 ///PDF
		$this->var->add_def_cols('nombre_partida','text');//3 ///PDF
		$this->var->add_def_cols('sw_transaccional','NUMERIC');//6 ///PDF
		$this->var->add_def_cols('traspaso','NUMERIC');//33 ///PDF
		$this->var->add_def_cols('reformulacion','NUMERIC');//34 ///PDF
		$this->var->add_def_cols('comprometido','NUMERIC');//26 ///PDF
		$this->var->add_def_cols('devengado','NUMERIC');//29 ///PDF
		$this->var->add_def_cols('pagado','NUMERIC');//30 ///PDF
		 
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
	 * Nombre de la función:	ContarDestino
	 * Propósito:				Contar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	function ContarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_fech';
		$this->codigo_procedimiento = "'PR_EJEFECH_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	$this->var->add_param("'$fecha_ini'");//raiz
      
		
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
	 * Nombre de la función:	ListarEjecucionPorPartida
	 * Propósito:				Desplegar los registros de tpr_partida_presupuesto
	 * Autor:				    avq
	 * Fecha de creación:		17/08/2009
	 */
	function ListarEjecucionPorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_fin,$tipo_pres,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida';
		$this->codigo_procedimiento = "'PR_EJEPART_SEL'";

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
		$this->var->add_param("'$fecha_fin'");//raiz
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_moneda");//raiz*/
	
	 	/*$this->var->add_param($id_partida);//id_partida*/
		
	 		$this->var->add_def_cols('desc_uo_ep_ff','text');//0
	 		$this->var->add_def_cols('presupuestado','NUMERIC');//1
	 		$this->var->add_def_cols('traspaso','NUMERIC');//2
	 		$this->var->add_def_cols('reformulacion','NUMERIC');//3
	 		$this->var->add_def_cols('pres_vigente','NUMERIC');//4
            $this->var->add_def_cols('comprometido','NUMERIC');//5
            $this->var->add_def_cols('devengado','NUMERIC');//6
            $this->var->add_def_cols('pagado','NUMERIC');//7
            $this->var->add_def_cols('saldo_por_comprometer','NUMERIC');//8
            $this->var->add_def_cols('saldo_x_devengar','NUMERIC');//9
            $this->var->add_def_cols('saldo_x_pagar','NUMERIC');//10
            $this->var->add_def_cols('porcentaje_ejecucion','NUMERIC');//11
            
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	    //echo $this->query;	exit();
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDestino
	 * Propósito:				Contar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	/*function ContarEjecucionPorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida';
		$this->codigo_procedimiento = "'PR_EJEPART_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$ids_concepto_colectivo'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	$this->var->add_param($id_partida);//id_partida
      
		
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
		/*	echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		/*return $res;
	}*/
		/**
	 * Nombre de la función:	ListarEjecucionPartida_x_Fechas
	 * Propósito:				Desplegar los registros de tpr_presupuesto
	 * Autor:				    Ana Maria Villegas Q.
	 * Fecha de creación:		12/01/2010
	 */
	function ListarEjecucionPartida_x_Fechas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_x_fechas';
		//$this->nombre_funcion = 'f_tpr_listar_eje_partida_pro';
		$this->codigo_procedimiento = "'PR_EJPREF_SEL'";

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$ids_concepto_colectivo'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
		$this->var->add_param("'$fecha_ini'");//raiz		
	
	 		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_partida','INTEGER');//1   //0
		$this->var->add_def_cols('codigo_partida','VARCHAR');//2 ///PDF//1
		$this->var->add_def_cols('nombre_partida','text');//3 ///PDF//2
		$this->var->add_def_cols('sw_transaccional','NUMERIC');//6 ///PDF//3
		$this->var->add_def_cols('comprometido','NUMERIC');//26 ///PDF//4
		$this->var->add_def_cols('devengado','NUMERIC');//29 ///PDF//5
		$this->var->add_def_cols('pagado','NUMERIC');//30 ///PDF//6
	
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
	
	function ListarTotalEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_partida_pro_new';
		$this->codigo_procedimiento = "'PR_TOT_EJEC_SEL'";

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
		$this->var->add_param("$tipo_pres");//raiz
		$this->var->add_param("$id_parametro");//raiz
		$this->var->add_param("$id_moneda");//raiz
		$this->var->add_param("'$ids_fuente_financiamiento'");//raiz
		$this->var->add_param("'$ids_u_o'");//raiz
		$this->var->add_param("'$ids_financiador'");//raiz
		$this->var->add_param("'$ids_regional'");//raiz
		$this->var->add_param("'$ids_programa'");//raiz
		$this->var->add_param("'$ids_proyecto'");//raiz
		$this->var->add_param("'$ids_actividad'");//raiz
		$this->var->add_param("'$sw_vista'");//raiz
		$this->var->add_param("'$ids_concepto_colectivo'");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
	 	$this->var->add_param("'$fecha_ini'");//raiz
		
	 		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('periodo','NUMERIC');//1
		$this->var->add_def_cols('valor','NUMERIC');//2 ///PDF
		
 
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
	
}?>