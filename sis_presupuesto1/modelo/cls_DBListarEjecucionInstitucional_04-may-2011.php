<?php
/**
 * Nombre de la clase:	cls_DBListarEjecucionInstitucional.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_presupuesto 
 * Autor:				Ana Maria villegas Quispe
 * Fecha creación:		10/02/2010
 */

 
class cls_DBListarEjecucionInstitucional 
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
	 * Nombre de la función:	ListarEjecucionInstitucional
	 * Propósito:				Desplegar los registros de tpr_presto
	 * Autor:				    Ana Maria Villegas Quispe
	 * Fecha de creación:		10/02/2010
	 */
	/*function ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_institucional';
		$this->codigo_procedimiento = "'PR_EJPRINS_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");
		
			$this->var->add_def_cols('id_partida','INTEGER'); //0
        $this->var->add_def_cols('codigo_partida','varchar');  //1
        $this->var->add_def_cols('nombre_partida','TEXT');//2
        $this->var->add_def_cols('sw_transaccional','NUMERIC'); //3
        $this->var->add_def_cols('presupuestado','NUMERIC'); //4
        $this->var->add_def_cols('modificaciones','NUMERIC');//5
        $this->var->add_def_cols('presupuesto_vigente','NUMERIC');  //6
        $this->var->add_def_cols('compromiso','NUMERIC'); //7
        $this->var->add_def_cols('presupuesto_por_comprometer','NUMERIC');//8
        $this->var->add_def_cols('devengado','NUMERIC'); //9
		$this->var->add_def_cols('devengado_acumulado','NUMERIC');//10
        $this->var->add_def_cols('presupuesto_por_devengar','NUMERIC');//11
        $this->var->add_def_cols('pagado','NUMERIC'); //12
        $this->var->add_def_cols('pagado_acumulado','NUMERIC'); //13
        $this->var->add_def_cols('saldo_por_pagar','NUMERIC');	//14
		//Carga la definición de columnas con sus tipos de datos
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//	exit();
		return $res;
	}*/
	function ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_moneda,$fecha_fin,$fecha_ini,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_institucional';
		$this->codigo_procedimiento = "'PR_EJPRINS_SEL'";

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
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("'general'");//raiz
		$this->var->add_param("NULL");//raiz
		$this->var->add_param("'$fecha_fin'");//raiz
		$this->var->add_param("'$fecha_ini'");//raiz		
		$this->var->add_param("'$id_presupuesto'");
		
			$this->var->add_def_cols('id_partida','INTEGER'); //0
        $this->var->add_def_cols('codigo_partida','varchar');  //1
        $this->var->add_def_cols('nombre_partida','TEXT');//2
        $this->var->add_def_cols('sw_transaccional','NUMERIC'); //3
        $this->var->add_def_cols('presupuestado','NUMERIC'); //4
        $this->var->add_def_cols('modificaciones','NUMERIC');//5
        $this->var->add_def_cols('presupuesto_vigente','NUMERIC');  //6
        $this->var->add_def_cols('compromiso','NUMERIC'); //7
        $this->var->add_def_cols('presupuesto_por_comprometer','NUMERIC');//8
        $this->var->add_def_cols('devengado','NUMERIC'); //9
		$this->var->add_def_cols('devengado_acumulado','NUMERIC');//10
        $this->var->add_def_cols('presupuesto_por_devengar','NUMERIC');//11
        $this->var->add_def_cols('pagado','NUMERIC'); //12
        $this->var->add_def_cols('pagado_acumulado','NUMERIC'); //13
        $this->var->add_def_cols('saldo_por_pagar','NUMERIC');	//14
        $this->var->add_def_cols('cod_trans','VARCHAR');	//15
		//Carga la definición de columnas con sus tipos de datos
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/* echo $this->query;
		exit();*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarEjecucionInstitucionalPresupuesto
	 * Propósito:				Desplegar los registros de tpr_presto
	 * Autor:				    Ana Maria Villegas Quispe
	 * Fecha de creación:		10/02/2010
	 */
	function ListarEjecucionInstitucionalPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_listar_eje_institucional_pres';
		$this->codigo_procedimiento = "'PR_PREINS_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");
		
		$this->var->add_def_cols('id_presupuesto','INTEGER'); //1
        $this->var->add_def_cols('gestion_pres','numeric');  //2
        $this->var->add_def_cols('codigo_ent','varchar');//3
        $this->var->add_def_cols('cod_prg','varchar'); //4
        $this->var->add_def_cols('cod_proy','varchar'); //5
        $this->var->add_def_cols('cod_act','varchar');//6
        $this->var->add_def_cols('codigo_fuente','varchar');  //7
        $this->var->add_def_cols('cod_fin','varchar'); //8
       
		
		
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
