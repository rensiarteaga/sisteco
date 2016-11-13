<?php
/**
 * Nombre de la clase:	cls_DBOecArb.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla sci.tct_oec
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 15:46:18
 */
class cls_DBOecArb{
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
	 * Propósito:				Desplegar los registros de tct_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarOecRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_sel';
		$this->codigo_procedimiento = "'TS_OEC_RAIZ_SEL'";

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
		$this->var->add_param("$gestion");//gestion

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('nro_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_tesoro','numeric');
		$this->var->add_def_cols('dig_nivel','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}	
	/**
	 * Nombre de la función:	ListarOecArb
	 * Propósito:				Desplegar los registros de tct_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_sel';
		$this->codigo_procedimiento = "'TS_OEC_SEL'";

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
		$this->var->add_param("$gestion");//gestion

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('nro_oec','varchar');
		$this->var->add_def_cols('nombre_oec','varchar');
		$this->var->add_def_cols('desc_oec','varchar');
		$this->var->add_def_cols('nivel_oec','numeric');
		$this->var->add_def_cols('tipo_oec','numeric');
		$this->var->add_def_cols('sw_transaccional','numeric');
		$this->var->add_def_cols('id_oec_padre','integer');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('cantidad_nivel','numeric');
		$this->var->add_def_cols('estado_gestion','numeric');
		$this->var->add_def_cols('gestion_tesoro','numeric');	
		$this->var->add_def_cols('dig_nivel','numeric');
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
	 * Propósito:				Contar los registros de tct_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_oec_arb_sel';
		$this->codigo_procedimiento = "'TS_OEC_COUNT'";
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
	 * Nombre de la función:	ListarOecField
	 * Propósito:				Desplegar los registros de tts_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ListarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_sel';
		$this->codigo_procedimiento = "'TS_OECFIELD_SEL'";

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
		$this->var->add_def_cols('id_oec','int4');
		$this->var->add_def_cols('desc_oec','text');
		$this->var->add_def_cols('nro_oec','varchar');
		$this->var->add_def_cols('nombre_oec','text');
		$this->var->add_def_cols('sw_transaccional','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	/**
	 * Nombre de la función:	ContarOecField
	 * Propósito:				Contar los registros de tts_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_sel';
		$this->codigo_procedimiento = "'TS_OECFIELD_COUNT'";

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
	 * Nombre de la función:	InsertarOecRaiz
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarOecRaiz($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_iud';
		$this->codigo_procedimiento = "'TS_OECRAIZ_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nro_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("'$desc_oec'");
		$this->var->add_param("$nivel_oec");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_parametro");
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
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tts_oec
	 * Autor:				    (autogenerado)	
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_iud';
		$this->codigo_procedimiento = "'TS_OEC_INS'";
			
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$nro_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("'$desc_oec'");
		$this->var->add_param("$nivel_oecl");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$id_oec_padre");
		$this->var->add_param("$id_parametro");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarOecArb
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tts_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_iud';
		$this->codigo_procedimiento = "'TS_OEC_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_oec");
		$this->var->add_param("'$nro_oec'");
		$this->var->add_param("'$nombre_oec'");
		$this->var->add_param("'$desc_oec'");
		$this->var->add_param("$nivel_oecl");
		$this->var->add_param("$tipo_oec");
		$this->var->add_param("$sw_transaccional");
		$this->var->add_param("$id_oec_padre");
		$this->var->add_param("$id_parametro");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarOecArb
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarOecArb($id_oec,$id_oec_padre){
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_iud';
		$this->codigo_procedimiento = "'TS_OEC_DEL'";

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
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tts_oec
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarOecRaiz($id_oec){
		$this->salida = "";
		$this->nombre_funcion = 'f_tts_oec_arb_iud';
		$this->codigo_procedimiento = "'TS_OECRAIZ_DEL'";

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
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query:".$this->query;

		return $res;
	}
}?>