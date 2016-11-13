<?php
/**
 * Nombre de la clase:	cls_DBPartidaTraspaso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_partida_traspaso
 * Autor:				(autogenerado)
 * Fecha creación:		2009-02-04 19:45:09
 */

 
class cls_DBPartidaTraspaso
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
	 * Nombre de la función:	ListarPartidaTraspaso
	 * Propósito:				Desplegar los registros de tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function ListarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_sel';
		$this->codigo_procedimiento = "'PR_PARTRA_SEL'";

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
		$this->var->add_def_cols('id_partida_traspaso','int4');
		$this->var->add_def_cols('id_partida_presupuesto_origen','int4');
		$this->var->add_def_cols('id_partida_presupuesto_destino','int4');
		$this->var->add_def_cols('id_partida_ejecucion_origen','int4');
		$this->var->add_def_cols('id_partida_ejecucion_destino','int4');
		$this->var->add_def_cols('id_usu_autorizado_origen','int4');
		$this->var->add_def_cols('desc_usuario_origen','text');
		$this->var->add_def_cols('id_usu_autorizado_destino','int4');
		$this->var->add_def_cols('desc_usuario_destino','text');
		$this->var->add_def_cols('id_usu_autorizado_registro','int4');
		$this->var->add_def_cols('desc_usuario_registro','text');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_traspaso','numeric');
		$this->var->add_def_cols('estado_traspaso','numeric');
		$this->var->add_def_cols('fecha_traspaso','date');
		$this->var->add_def_cols('fecha_conclusion','timestamp');
		$this->var->add_def_cols('justificacion','varchar');
		
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('tipo_pres','numeric');
		
		$this->var->add_def_cols('id_partida_origen','int4');
		$this->var->add_def_cols('desc_partida_origen','text');
		$this->var->add_def_cols('id_partida_destino','int4');
		$this->var->add_def_cols('desc_partida_destino','text');	

		$this->var->add_def_cols('id_presupuesto_origen','int4');
		$this->var->add_def_cols('desc_presupuesto_origen','text');
		$this->var->add_def_cols('id_presupuesto_destino','int4');
		$this->var->add_def_cols('desc_presupuesto_destino','text');
		$this->var->add_def_cols('tipo_traspaso','numeric');	
		

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
	
	function ListarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_incremento_sel';
		$this->codigo_procedimiento = "'PR_PARINC_SEL'";

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
		$this->var->add_def_cols('id_partida_traspaso','int4');
		
		$this->var->add_def_cols('id_partida_presupuesto_destino','int4');
		
		$this->var->add_def_cols('id_partida_ejecucion_destino','int4');
		
		$this->var->add_def_cols('id_usu_autorizado_destino','int4');
		$this->var->add_def_cols('desc_usuario_destino','text');
		$this->var->add_def_cols('id_usu_autorizado_registro','int4');
		$this->var->add_def_cols('desc_usuario_registro','text');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_traspaso','numeric');
		$this->var->add_def_cols('estado_traspaso','numeric');
		$this->var->add_def_cols('fecha_traspaso','date');
		$this->var->add_def_cols('fecha_conclusion','timestamp');
		$this->var->add_def_cols('justificacion','varchar');
		
		$this->var->add_def_cols('id_parametro','int4');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('tipo_pres','numeric');
		
		
		$this->var->add_def_cols('id_partida_destino','int4');
		$this->var->add_def_cols('desc_partida_destino','text');	

		
		$this->var->add_def_cols('id_presupuesto_destino','int4');
		$this->var->add_def_cols('desc_presupuesto_destino','text');
		$this->var->add_def_cols('tipo_traspaso','numeric');	
		

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
	
	function ListarReporteTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_sel';
		$this->codigo_procedimiento = "'PR_REPTRA_SEL'";

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
		
		$this->var->add_def_cols('desc_usuario_origen','text');		
		$this->var->add_def_cols('desc_usuario_destino','text');		
		$this->var->add_def_cols('desc_usuario_registro','text');		
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_traspaso','numeric');		
		$this->var->add_def_cols('fecha_traspaso','date');
		$this->var->add_def_cols('fecha_conclusion','text');
		$this->var->add_def_cols('justificacion','varchar');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('desc_tipo_pres','varchar');
		$this->var->add_def_cols('desc_partida_origen','text');		
		$this->var->add_def_cols('desc_partida_destino','text');
		$this->var->add_def_cols('desc_uo_origen','varchar');		
		$this->var->add_def_cols('desc_uo_destino','varchar');
		$this->var->add_def_cols('desc_financiador_origen','varchar');		
		$this->var->add_def_cols('desc_financiador_destino','varchar');
		$this->var->add_def_cols('desc_regional_origen','varchar');		
		$this->var->add_def_cols('desc_regional_destino','varchar');
		$this->var->add_def_cols('desc_programa_origen','varchar');		
		$this->var->add_def_cols('desc_programa_destino','varchar');
		$this->var->add_def_cols('desc_proyecto_origen','varchar');		
		$this->var->add_def_cols('desc_proyecto_destino','varchar');
		$this->var->add_def_cols('desc_actividad_origen','varchar');		
		$this->var->add_def_cols('desc_actividad_destino','varchar');		
		$this->var->add_def_cols('desc_fuente_fin_origen','varchar');		
		$this->var->add_def_cols('desc_fuente_fin_destino','varchar');			

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;
	}
	
	function ListarReporteIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_incremento_sel';
		$this->codigo_procedimiento = "'PR_REPINC_SEL'";

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
		
		//$this->var->add_def_cols('desc_usuario_origen','text');		
		$this->var->add_def_cols('desc_usuario_destino','text');		
		$this->var->add_def_cols('desc_usuario_registro','text');		
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('importe_traspaso','numeric');		
		$this->var->add_def_cols('fecha_traspaso','date');
		$this->var->add_def_cols('fecha_conclusion','text');
		$this->var->add_def_cols('justificacion','varchar');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('desc_tipo_pres','varchar');
		//$this->var->add_def_cols('desc_partida_origen','text');		
		$this->var->add_def_cols('desc_partida_destino','text');
		//$this->var->add_def_cols('desc_uo_origen','varchar');		
		$this->var->add_def_cols('desc_uo_destino','varchar');
		//$this->var->add_def_cols('desc_financiador_origen','varchar');		
		$this->var->add_def_cols('desc_financiador_destino','varchar');
		//$this->var->add_def_cols('desc_regional_origen','varchar');		
		$this->var->add_def_cols('desc_regional_destino','varchar');
		//$this->var->add_def_cols('desc_programa_origen','varchar');		
		$this->var->add_def_cols('desc_programa_destino','varchar');
		//$this->var->add_def_cols('desc_proyecto_origen','varchar');		
		$this->var->add_def_cols('desc_proyecto_destino','varchar');
		//$this->var->add_def_cols('desc_actividad_origen','varchar');		
		$this->var->add_def_cols('desc_actividad_destino','varchar');		
		//$this->var->add_def_cols('desc_fuente_fin_origen','varchar');		
		$this->var->add_def_cols('desc_fuente_fin_destino','varchar');			

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
	 * Nombre de la función:	ContarPartidaTraspaso
	 * Propósito:				Contar los registros de tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function ContarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_sel';
		$this->codigo_procedimiento = "'PR_PARTRA_COUNT'";

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
	
	function ContarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_incremento_sel';
		$this->codigo_procedimiento = "'PR_PARINC_COUNT'";

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
	 * Nombre de la función:	InsertarPartidaTraspaso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function InsertarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,
			$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,
			$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino, $tipo_traspaso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_iud';
		$this->codigo_procedimiento = "'PR_PARTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_partida_presupuesto_origen);
		$this->var->add_param($id_partida_presupuesto_destino);
		$this->var->add_param($id_partida_ejecucion_origen);
		$this->var->add_param($id_partida_ejecucion_destino);
		$this->var->add_param($id_usu_autorizado_origen);
		//$this->var->add_param();
		$this->var->add_param($id_usu_autorizado_destino);
		//$this->var->add_param();
		$this->var->add_param($id_usu_autorizado_registro);
		//$this->var->add_param();
		$this->var->add_param($id_moneda);
		//$this->var->add_param();
		$this->var->add_param($importe_traspaso);
		$this->var->add_param($estado_traspaso);
		$this->var->add_param("'$fecha_traspaso'");
		$this->var->add_param($fecha_conclusion);
		$this->var->add_param("'$justificacion'");
		
		$this->var->add_param($id_parametro);
		//$this->var->add_param($desc_parametro);
		$this->var->add_param($tipo_pres);
		
		$this->var->add_param($id_partida_origen);
		//$this->var->add_param($desc_partida_origen);
		$this->var->add_param($id_partida_destino);
		//$this->var->add_param($desc_partida_destino);
		
		$this->var->add_param($id_presupuesto_origen);
		//$this->var->add_param($desc_presupuesto_origen);
		$this->var->add_param($id_presupuesto_destino);
		//$this->var->add_param($desc_presupuesto_destino);	
		$this->var->add_param($tipo_traspaso);	
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPartidaTraspaso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function ModificarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,
		$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,
		$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino, $tipo_traspaso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_iud';
		$this->codigo_procedimiento = "'PR_PARTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_traspaso);
		$this->var->add_param($id_partida_presupuesto_origen);
		$this->var->add_param($id_partida_presupuesto_destino);
		$this->var->add_param($id_partida_ejecucion_origen);
		$this->var->add_param($id_partida_ejecucion_destino);
		$this->var->add_param($id_usu_autorizado_origen);
		$this->var->add_param($id_usu_autorizado_destino);
		$this->var->add_param($id_usu_autorizado_registro);
		$this->var->add_param($id_moneda);
		$this->var->add_param($importe_traspaso);
		$this->var->add_param($estado_traspaso);
		$this->var->add_param("'$fecha_traspaso'");
		$this->var->add_param($fecha_conclusion);
		$this->var->add_param("'$justificacion'");
		
		$this->var->add_param($id_parametro);
		//$this->var->add_param($desc_parametro);
		$this->var->add_param($tipo_pres);
		
		$this->var->add_param($id_partida_origen);
		//$this->var->add_param($desc_partida_origen);
		$this->var->add_param($id_partida_destino);
		//$this->var->add_param($desc_partida_destino);
		
		$this->var->add_param($id_presupuesto_origen);
		//$this->var->add_param($desc_presupuesto_origen);
		$this->var->add_param($id_presupuesto_destino);
		//$this->var->add_param($desc_presupuesto_destino);			
		$this->var->add_param($tipo_traspaso);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPartidaTraspaso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function EliminarPartidaTraspaso($id_partida_traspaso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_iud';
		$this->codigo_procedimiento = "'PR_PARTRA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_traspaso);
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
		$this->var->add_param("NULL"); //tipo_traspaso

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarPartidaTraspaso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tpr_partida_traspaso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2009-02-04 19:45:09
	 */
	function ValidarPartidaTraspaso($operacion_sql,$id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion)
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
				//Validar id_partida_traspaso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_partida_traspaso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_traspaso", $id_partida_traspaso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			/*//Validar id_partida_presupuesto_origen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_presupuesto_origen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto_origen", $id_partida_presupuesto_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida_presupuesto_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_presupuesto_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_presupuesto_destino", $id_partida_presupuesto_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_partida_ejecucion_origen - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_ejecucion_origen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_ejecucion_origen", $id_partida_ejecucion_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_partida_ejecucion_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_ejecucion_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_ejecucion_destino", $id_partida_ejecucion_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_usu_autorizado_origen - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usu_autorizado_origen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usu_autorizado_origen", $id_usu_autorizado_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar id_usu_autorizado_destino - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usu_autorizado_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usu_autorizado_destino", $id_usu_autorizado_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_usu_autorizado_registro - tipo int4
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_usu_autorizado_registro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_usu_autorizado_registro", $id_usu_autorizado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}
*/
			//Validar id_moneda - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda", $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar importe_traspaso - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_traspaso");
			$tipo_dato->set_MaxLength(1310722);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_traspaso", $importe_traspaso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_traspaso - tipo numeric
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_traspaso");
			$tipo_dato->set_MaxLength(131072);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "estado_traspaso", $estado_traspaso))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_traspaso - tipo date
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_traspaso");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_traspaso", $fecha_traspaso))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar fecha_conclusion - tipo timestamptz
			/*$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_conclusion");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_conclusion", $fecha_conclusion))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar justificacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("justificacion");
			$tipo_dato->set_MaxLength(500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "justificacion", $justificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_partida_traspaso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida_traspaso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida_traspaso", $id_partida_traspaso))
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
	
	
	function CambiarEstadoPartidaTraspaso($id_partida_traspaso,$accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_partida_traspaso_iud';
		
		if($accion=='enviar_autorizar'){
			$this->codigo_procedimiento = "'PR_PARTRA_ENVIAR_AUTORIZAR'";
		}
		elseif ($accion=='aprobar_modificacion'){
			$this->codigo_procedimiento = "'PR_PARTRA_APROBAR'";
		}
		elseif ($accion=='rechazar_modificacion'){
			$this->codigo_procedimiento = "'PR_PARTRA_RECHAZAR'";
		}
		elseif ($accion=='concluir_modificacion'){
			$this->codigo_procedimiento = "'PR_PARTRA_UPD'";		//PR_PARTRA_CONCLUIR
		}

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_partida_traspaso);
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

		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit();*/

		return $res;
	}
	
function ListarResumenTraspasosAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_traspasos_reporte';

		if($filtro=='Presupuesto')
		{	
			$this->codigo_procedimiento = "'PR_TRASPASOS_PRES'";
		}
		else 
		{
			if($filtro=='Unidad Organizacional')
			{	
				$this->codigo_procedimiento = "'PR_TRASPASOS_UO'";
			}
			else
			{
				if($filtro=='Proyecto')
				{	
					$this->codigo_procedimiento = "'PR_TRASPASOS_PROY'";
				}
			}
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
		$this->var->add_param("'$id_proyecto'");//id_proyecto
		//$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		$this->var->add_param("$id_parametro");
		$this->var->add_param("'$fecha_ini'");
		$this->var->add_param("'$fecha_fin'");		
		$this->var->add_param("'$tipo_pres1'");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("'$id_presupuesto'");
		$this->var->add_param("'$id_uo'");
		$this->var->add_param("'$tipo_traspaso'");
		
		$this->var->add_param("'$id_presupuesto_destino'");
		$this->var->add_param("'$id_uo_destino'");
		$this->var->add_param("'$id_proyecto_destino'");
		

		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_presupuesto','integer');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('presupuesto_inicial','numeric');
		$this->var->add_def_cols('presupuesto_vigente','numeric');
		
		$this->var->add_def_cols('mod_enero','numeric');
		$this->var->add_def_cols('mod_febrero','numeric');
		$this->var->add_def_cols('mod_marzo','numeric');
		$this->var->add_def_cols('mod_abril','numeric');
		$this->var->add_def_cols('mod_mayo','numeric');
		$this->var->add_def_cols('mod_junio','numeric');
		$this->var->add_def_cols('mod_julio','numeric');
		$this->var->add_def_cols('mod_agosto','numeric');
		$this->var->add_def_cols('mod_septiembre','numeric');
		$this->var->add_def_cols('mod_octubre','numeric');
		$this->var->add_def_cols('mod_noviembre','numeric');
		$this->var->add_def_cols('mod_diciembre','numeric');
		
		$this->var->add_def_cols('mod_total','numeric');
		$this->var->add_def_cols('porcentaje_total','text');
	

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit ();*/
		
		return $res;
	}
	
function ListarDetalleTraspasosPorFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso,$id_presupuesto_destino,$id_uo_destino,$id_proyecto_destino)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_traspasos_reporte';

		if($filtro=='Presupuesto')
		{	
			$this->codigo_procedimiento = "'PR_DET_TRASPASOS_PRES'";
		}
		else 
		{
			if($filtro=='Unidad Organizacional')
			{	
				$this->codigo_procedimiento = "'PR_DET_TRASPASOS_UO'";
			}
			else
			{
				if($filtro=='Proyecto')
				{	
					$this->codigo_procedimiento = "'PR_DET_TRASPASOS_PROY'";
				}
			}
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
		$this->var->add_param("'$id_proyecto'");//id_proyecto
		//$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		$this->var->add_param("$id_parametro");
		$this->var->add_param("'$fecha_ini'"); 
		$this->var->add_param("'$fecha_fin'");		
		$this->var->add_param("'$tipo_pres1'");
		$this->var->add_param("$id_moneda");
		$this->var->add_param("'$id_presupuesto'");
		$this->var->add_param("'$id_uo'");
		$this->var->add_param("'$tipo_traspaso'");
		
		$this->var->add_param("'$id_presupuesto_destino'");
		$this->var->add_param("'$id_uo_destino'");
		$this->var->add_param("'$id_proyecto_destino'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_partida_traspaso','integer');
		$this->var->add_def_cols('tipo_traspaso','text');
		$this->var->add_def_cols('descripcion_origen','text');
		$this->var->add_def_cols('partida_origen','text');
		$this->var->add_def_cols('importe_traspaso','numeric');
		
		$this->var->add_def_cols('descripcion_destino','text');
		$this->var->add_def_cols('partida_destino','text');
		$this->var->add_def_cols('justificacion','varchar');
		$this->var->add_def_cols('fecha_conclusion','text'); 
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit ();*/
		
		return $res;
	}
}?>