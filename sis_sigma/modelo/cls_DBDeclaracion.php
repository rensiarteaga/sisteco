<?php
/**
 * Nombre de la clase:	cls_DBDeclaracion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_Declaracion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-16 17:55:36
 */
 
class cls_DBDeclaracion
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
	 * Nombre de la función:	ListarRegistroDeclaracion
	 * Propósito:				Desplegar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ListarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_sel';
		$this->codigo_procedimiento = "'SI_DECLAR_SEL'";

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
		$this->var->add_def_cols('id_declaracion','integer');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_reg','date');
	 	$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_empresa','integer');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('empresa','varchar');
		$this->var->add_def_cols('usuario','text');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('id_periodo','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('desc_periodo','numeric');
		$this->var->add_def_cols('archivo','text');
		$this->var->add_def_cols('id_parametro','integer');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDeclaracion
	 * Propósito:				Contar los registros de tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ContarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_sel';
		$this->codigo_procedimiento = "'SI_DECLAR_COUNT'";

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

		/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function InsertarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_DECLAR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empresa);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ModificarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_DECLAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");
		$this->var->add_param("'$estado'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empresa);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_moneda);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	function EliminarDeclaracion($id_declaracion){
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_DECLAR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");
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
	
	function GenerarEjecucion($id_declaracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_EJEPRE_GEN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");
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
	
	function VerificarArchivos($id_declaracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_ascii';
		$this->codigo_procedimiento = "'SI_VERARC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ValidarEjecucion($id_declaracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_declaracion';
		$this->codigo_procedimiento = "'SI_VALEJEC_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function DiferenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_VALEJEC_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
  		$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('codigo_partida',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_partida',' VARCHAR'); 
  		$this->var->add_def_cols('importe_contabilidad','NUMERIC');
  		$this->var->add_def_cols('importe_presupuesto',' NUMERIC'); 
  		$this->var->add_def_cols('diferencia','NUMERIC');
 
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function DiferenciaContaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_CTAPPTO_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
    	$this->var->add_def_cols('de_a',' VARCHAR');
  		$this->var->add_def_cols('id_comprobante',' INTEGER'); 
  		$this->var->add_def_cols('id_presupuesto',' INTEGER'); 
  		$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('codigo_partida',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_partida',' VARCHAR'); 
  		$this->var->add_def_cols('importe_contabilidad','NUMERIC');
  		$this->var->add_def_cols('importe_presupuesto',' NUMERIC'); 
  		$this->var->add_def_cols('diferencia','NUMERIC');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ValidarAcumulado($id_declaracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_declaracion';
		$this->codigo_procedimiento = "'SI_VALTOTAL_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function DiferenciaAcumulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_VALTOTAL_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
    	
        $this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('codigo_partida',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_partida',' VARCHAR');
  		$this->var->add_def_cols('presupuesto',' VARCHAR');
  		$this->var->add_def_cols('vigente','NUMERIC');
  		$this->var->add_def_cols('comprometido','NUMERIC');
  		$this->var->add_def_cols('devengado',' NUMERIC'); 
  		$this->var->add_def_cols('pagado','NUMERIC');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ValidarSigma($id_declaracion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_declaracion';
		$this->codigo_procedimiento = "'SI_VALSIGMA_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function AnularDeclaracion($id_declaracion){
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_ANULA_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");
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
	
	function FinalDeclaracion($id_declaracion){
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_iud';
		$this->codigo_procedimiento = "'SI_FINAL_PRO'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_declaracion");
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
	
	function DiferenciaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_VALSIGMA_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
    	$this->var->add_def_cols('momento',' VARCHAR');
  		$this->var->add_def_cols('id_partida_presto',' INTEGER'); 
  		$this->var->add_def_cols('partida_presto',' VARCHAR'); 
  		$this->var->add_def_cols('id_partida_sigma',' INTEGER');
  		$this->var->add_def_cols('partida_sigma',' VARCHAR'); 
  		$this->var->add_def_cols('importe_presto','NUMERIC');
  		$this->var->add_def_cols('importe_sigma',' NUMERIC'); 
  		$this->var->add_def_cols('importe_diferencia','NUMERIC');
 
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function DiferenciaSigmaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_SIGMAPPTO_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
    	$this->var->add_def_cols('momento',' VARCHAR');
  		$this->var->add_def_cols('id_cbte_conta',' INTEGER'); 
  		$this->var->add_def_cols('id_cbte_sigma',' INTEGER'); 
  		$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('codigo_partida',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_partida',' VARCHAR'); 
  		$this->var->add_def_cols('importe_ppto','NUMERIC');
  		$this->var->add_def_cols('importe_sigma',' NUMERIC'); 
  		$this->var->add_def_cols('diferencia','NUMERIC');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ConsultaRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_PAGOREC_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
        $this->var->add_param("NULL");

    	//Carga la definición de columnas con sus tipos de datos
    	$this->var->add_def_cols('codigo_partida',' VARCHAR'); 
  		$this->var->add_def_cols('nombre_partida',' VARCHAR');
  		$this->var->add_def_cols('id_presupuesto',' INTEGER'); 
  		$this->var->add_def_cols('desc_presupuesto',' VARCHAR');
  		$this->var->add_def_cols('diferencia','NUMERIC');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ConsultaIDQuery($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida,$id_dato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_si_validacion_diferencias_sel';
		$this->codigo_procedimiento = "'SI_IDQUERY_SEL'";

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
		$this->var->add_param("$id_declaracion");
        $this->var->add_param("$id_partida");
		$this->var->add_param("$id_dato");
		
    	//Carga la definición de columnas con sus tipos de datos
    	$this->var->add_def_cols('id_comprobante',' INTEGER');
    	$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('partida',' TEXT');
  		$this->var->add_def_cols('fecha_eje','DATE');
  		$this->var->add_def_cols('importe','NUMERIC');
  		$this->var->add_def_cols('momento',' VARCHAR');
  		$this->var->add_def_cols('id_cuenta_doc',' INTEGER');
  		$this->var->add_def_cols('id_devengado',' INTEGER');
  		$this->var->add_def_cols('id_solicitud_compra',' INTEGER');
  		$this->var->add_def_cols('id_cta_redicion',' INTEGER');
  		$this->var->add_def_cols('id_planilla',' INTEGER');
  		$this->var->add_def_cols('id_partida_ejecucion',' INTEGER');
  		$this->var->add_def_cols('usuario_reg',' VARCHAR');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ValidarRegistroDeclaracion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_Declaracion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ValidarRegistroDeclaracion($id_declaracion,$mes,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario)
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
				//Validar id_Declaracion - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_Declaracion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_Declaracion", $id_Declaracion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nro_cbte - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cbte", $nro_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

		 	//Validar momento_cbte - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("momento_cbte");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "momento_cbte", $momento_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar momento_cbte - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_validacion");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_validacion", $sw_validacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_cbte - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_cbte", $fecha_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar concepto_cbte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto_cbte");
			$tipo_dato->set_MaxLength(1500);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto_cbte", $concepto_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar glosa_cbte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("glosa_cbte");
			$tipo_dato->set_MaxLength(1500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "glosa_cbte", $glosa_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar acreedor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("acreedor");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "acreedor", $acreedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar aprobacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("aprobacion");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "aprobacion", $aprobacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar conformidad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("conformidad");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "conformidad", $conformidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pedido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pedido");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pedido", $pedido))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_periodo_subsis - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo_subsis");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo_subsis", $id_periodo_subsis))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subsistema - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_documento_nro - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clase_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clase_cbte", $id_clase_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_Declaracion - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_declaracion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_Declaracion", $id_Declaracion))
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
	
	/* Nombre de la función:	VerificarOEC
	 * Propósito:				Verfica si las partidas que no son de flujo tienen relacionado su OEC
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function VerificarOEC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_sel';
		$this->codigo_procedimiento = "'SI_VEROEC_SEL'";

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
		$this->var->add_def_cols('partida','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/*
	 * Nombre de la función:	ListarOec
	 * Propósito:				Desplegar los registros de tsi_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_sel';
		$this->codigo_procedimiento = "'SI_OEC_SEL'";

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
		$this->var->add_def_cols('codigo_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('sigla_oec','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarOec
	 * Propósito:				Contar los registros de tct_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_declaracion_sel';
		$this->codigo_procedimiento = "'SI_OEC_COUNT'";

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

		/*	echo $this->query; exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function EjecucionGastoInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel='no')
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_generar_ejecucion_sigma';
		$this->codigo_procedimiento = "'SI_GASINV_REP'";

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
		$this->var->add_param($func->iif($si_id_declaracion == '',"'%'","$si_id_declaracion"));//$si_id_declaracion
		$this->var->add_param($func->iif($si_tipo_presupuesto == '',"'%'","'$si_tipo_presupuesto'"));//$si_tipo_presupuesto
		
		$this->var->add_def_cols('presupuesto','varchar');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('periodo','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad_obra','varchar');
		$this->var->add_def_cols('organismo_financiador','varchar');
		$this->var->add_def_cols('fuente_financiamiento','varchar');		
		$this->var->add_def_cols('partida','varchar');	
		$this->var->add_def_cols('entidad_transf','VARCHAR');
		$this->var->add_def_cols('presupuestado','NUMERIC');
		$this->var->add_def_cols('vigente','NUMERIC');
		$this->var->add_def_cols('compromiso','NUMERIC');
		$this->var->add_def_cols('devengado','NUMERIC');
		$this->var->add_def_cols('pagado','NUMERIC'); 
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
			
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
			
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query; exit();	
		return $res; 
	}
	
	function EjecucionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel='no')
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsi_generar_ejecucion_sigma';
		$this->codigo_procedimiento = "'SI_RECURS_REP'";

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
		$this->var->add_param($func->iif($si_id_declaracion == '',"'%'","$si_id_declaracion"));//$si_id_declaracion
		$this->var->add_param($func->iif($si_tipo_presupuesto == '',"'%'","'$si_tipo_presupuesto'"));//$si_tipo_presupuesto
		
		$this->var->add_def_cols('presupuesto','varchar');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('entidad','varchar');
		$this->var->add_def_cols('periodo','varchar');
		$this->var->add_def_cols('programa','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('actividad_obra','varchar');
		$this->var->add_def_cols('organismo_financiador','varchar');
		$this->var->add_def_cols('fuente_financiamiento','varchar');		
		$this->var->add_def_cols('partida','varchar');	
		$this->var->add_def_cols('entidad_transf','VARCHAR');
		$this->var->add_def_cols('presupuestado','NUMERIC');
		$this->var->add_def_cols('vigente','NUMERIC');
		$this->var->add_def_cols('compromiso','NUMERIC');
		$this->var->add_def_cols('devengado','NUMERIC');
		$this->var->add_def_cols('pagado','NUMERIC'); 
		
		//echo $this->var->get_query_sel();exit;
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
			
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
			
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			
		return $res; 

	}
	
}?>
