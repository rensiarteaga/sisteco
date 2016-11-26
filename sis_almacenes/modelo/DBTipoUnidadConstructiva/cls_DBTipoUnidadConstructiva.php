<?php
/**
 * Nombre de la clase:	cls_DBTipoUnidadConstructiva.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_tipo_unidad_constructiva
 * Autor:				(autogenerado)
 * Fecha creación:		2007-11-07 15:46:18
 */

class cls_DBTipoUnidadConstructiva
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
	 * Nombre de la función:	ListarTipoUnidadConstructiva
	 * Propósito:				Desplegar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_SEL'";

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
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarTipoUnidadConstructiva
	 * Propósito:				Contar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ContarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_COUNT'";

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
	 * ***********************************************************
	 * Para el Mannejo de Árboles
	 * 
	 * 
	 ************************************************************* 
	 * 
	 */
	
	/**
	 * Nombre de la función:	ListarTipoUnidadConstructivaAgrupador
	 * Propósito:				Desplegar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarTipoUnidadConstructivaAgrupador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_AGRUP_SEL'";

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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('cantidad','integer');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('estado','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}

	/**
	 * Nombre de la función:	ListarTipoUnidadConstructiva
	 * Propósito:				Desplegar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_RAIZ_SEL'";

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
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_composicion_tuc','integer');
		$this->var->add_def_cols('cantidad','integer');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('id_tuc_padre','integer');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('estado','varchar');
		//$this->var->add_def_cols('cantidad_item','varchar');

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
	 * Nombre de la función:	ContarTipoUnidadConstructiva
	 * Propósito:				Contar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ContarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_COUNT'";

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
	
	function ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_RAMAS_SEL'";

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
		$this->var->add_param("$raiz");//id_actividad
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_composicion_tuc','int4');
		$this->var->add_def_cols('cantidad','int4');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('id_tuc_padre','int4');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('estado','varchar');
		//$this->var->add_def_cols('cantidad_item','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarComposicionTuc
	 * Propósito:				Contar los registros de tal_composicion_tuc
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-06 16:27:45
	 */
	function ContarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_RAMA_COUNT'";

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
		$this->var->add_param("NULL");//raiz


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
	 * Nombre de la función:	ListarTipoUnidadConstructivaItem
	 * Propósito:				Listar los componentes de una Unidades Contructiva
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2007-12-6 16:27:45
	 */
	function ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_ITEM_SEL'";

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
		$this->var->add_param("$raiz");//id_actividad
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos

		$this->var->add_def_cols('id_componente','int4');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo_item','varchar');
		$this->var->add_def_cols('nombre_item','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('cosiderar_repeticion','varchar');
		
		$this->var->add_def_cols('cant_demasia','numeric');
		$this->var->add_def_cols('cant_tot','numeric');
		$this->var->add_def_cols('demasia_porc','numeric');
		
		$this->var->add_def_cols('calidad','varchar');
		$this->var->add_def_cols('nombre_super','varchar');

		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarTipoUnidadConstructivaParaReemp
	 * Propósito:				Desplegar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ListarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_REEMP_SEL'";

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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		//$this->var->add_def_cols('cantidad_item','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarTipoUnidadConstructiva
	 * Propósito:				Contar los registros de tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ContarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TIPOUC_REEMP_COUNT'";

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
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarTipoUnidadConstructivaAgrupador($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TUCAGR_INS'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		elseif($opcional=='false') $opcional='no';
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}



	/**
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarTipoUnidadConstructiva($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_INS'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		elseif($opcional=='false') $opcional='no';
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarTipoUnidadConstructiva($id,$codigo,$nombre,$tipo,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_UPD'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		elseif($opcional=='false') $opcional='no';

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarTipoUnidadConstructiva($id,$id_padre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param("$id_padre");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoUnidadConstructivaAgrupador
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarTipoUnidadConstructivaAgrupador($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TUCAGR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
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
	 * Nombre de la función:	EliminarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarTipoUnidadConstructivaArb($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMTUC_INS'";
		
		if($opcional=='true') $opcional='si';
		else $opcional='no';

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("$cantidad");
		$this->var->add_param("'$opcional'");
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
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMTUC_UPD'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		else $opcional='no';

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("$cantidad");
		$this->var->add_param("'$opcional'");
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
	 * Nombre de la función:	EliminarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarComposicion($id,$id_padre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMTUC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param("$id_padre");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TUCCOM_INS'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		else $opcional='no';
		//elseif($opcional=='false') $opcional='no';

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("$cantidad");
		$this->var->add_param("'$opcional'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$id_padre_nuevo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TUCCOM_UPD'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		else $opcional='no';
		//elseif($opcional=='false') $opcional='no';

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("$cantidad");
		$this->var->add_param("'$opcional'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
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
	 * Nombre de la función:	InsertarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function InsertarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMPON_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("' '");
		$this->var->add_param("NULL");
		$this->var->add_param("$cantidad");
		$this->var->add_param("NULL");
		$this->var->add_param($considerar_repeticion=='true' ? "'si'" : "'no'");
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
	 * Nombre de la función:	ModificarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ModificarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMPON_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");
		$this->var->add_param("$cantidad");
		$this->var->add_param("NULL");
		$this->var->add_param($considerar_repeticion=='true' ? "'si'" : "'no'");
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
	 * Nombre de la función:	EliminarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarComponente($id,$id_padre)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMPON_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	//DRAG AND DROP//
	
	/**
	 * Nombre de la función:	ModificarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function DragAndDropRaiz($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_DRADRO_RAI'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
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
	 * Nombre de la función:	ModificarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function DragAndDropRama($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_DRADRO_RAM'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
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
	 * Nombre de la función:	ModificarComponente
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function DragAndDropItem($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_DRADRO_ITE'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
		$this->var->add_param("$id_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	FinalizarTUC
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function FinalizarTUC($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	FinalizarTUC
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function DesbloquearTUC($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_DES'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoUnidadConstructivaBasurero
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function EliminarTipoUnidadConstructivaBasurero($id)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_TIPOUC_BAS'";
		
		if($tipo=='raiz') $tipo="Raiz";
		elseif($tipo=='rama') $tipo="Rama";
		elseif($tipo=='item') $tipo="Hoja";
		
		if($opcional=='true') $opcional='si';
		elseif($opcional=='false') $opcional='no';
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id");
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

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function CopiarTipoUnidadConstructiva($id,$id_padre,$id_padre_nuevo,$cantidad,$opcional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tipo_unidad_constructiva_arb_iud';
		$this->codigo_procedimiento = "'AL_COMTUC_COP'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id);
		$this->var->add_param("$id_padre");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$cantidad");
		$this->var->add_param($opcional=='true' ? "'si'":"'no'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_padre_nuevo");
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
	 * Nombre de la función:	ListarExistenciaItemUC
	 * Propósito:				Devuelve todos los items de una UC y sus existencias (incluidos items de sus reemplazos)
	 * Autor:				    RCM
	 * Fecha de creación:		17/07/2008
	 */
	function ListarExistenciaItemUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva,$id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_EXTITE_SEL'";

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
		$this->var->add_param("$id_tipo_unidad_constructiva");//raiz
		$this->var->add_param("$id_almacen_logico");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('cant_repetida','bigint');

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
	 * Nombre de la función:	ListarExistenciaItemUC
	 * Propósito:				Devuelve todos los items de una UC y sus existencias (incluidos items de sus reemplazos)
	 * Autor:				    RCM
	 * Fecha de creación:		17/07/2008
	 */
	function ListarExistenciaItemUCRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva, $id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_EXIRAM_SEL'";

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
		$this->var->add_param("$id_tipo_unidad_constructiva");//raiz
		$this->var->add_param("$id_almacen_logico");//raiz
		
		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('cant_repetida','integer');

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
	 * Nombre de la función:	ListarSalidaUCOrigen
	 * Propósito:				Devuelve las salidas de un UC con el origen
	 * Autor:				    RCM
	 * Fecha de creación:		18/07/2008
	 */
	function ListarSalidaUCOrigen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_SALIUC_SEL'";

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
		$this->var->add_param("$id_tipo_unidad_constructiva");//raiz
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('cantidad','numeric');

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
	 * Nombre de la función:	ListarTipoUCPadre
	 * Propósito:				Desplegar un tipo de unidad constructiva más los datos de su padre
	 * Autor:				    RCM
	 * Fecha de creación:		18/07/2008
	 */
	function ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_tuc_arb_sel';
		$this->codigo_procedimiento = "'AL_TUCPAD_SEL'";

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
		$this->var->add_param("$id_tipo_unidad_constructiva");//raiz
		$this->var->add_param("NULL");//raiz

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_tuc_padre','integer');
		$this->var->add_def_cols('nombre_padre','varchar');
		$this->var->add_def_cols('cantidad','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('codigo_padre','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	

	/**
	 * Nombre de la función:	ValidarTipoUnidadConstructiva
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_tipo_unidad_constructiva
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-11-07 15:46:18
	 */
	function ValidarTipoUnidadConstructiva($operacion_sql,$id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg)
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
				//Validar id_tipo_unidad_constructiva - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_tipo_unidad_constructiva");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo", $tipo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar tipo
			$check = array ("Hoja","Rama","Raiz");
			if(!in_array($tipo,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'tipo': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarTipoUnidadConstructiva";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_tipo_unidad_constructiva - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_constructiva");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
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
}?>