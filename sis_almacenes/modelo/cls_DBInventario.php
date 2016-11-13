<?php
/**
 * Nombre de la clase:	cls_DBInventario.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_inventario
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-30 16:44:48
 */
class cls_DBInventario
{	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	function __construct()
	{		$this->decodificar=$decodificar;
	}
	/**
	 * Nombre de la función:	ListarInventario
	 * Propósito:				Desplegar los registros de tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ListarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVENT_SEL'";
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
		$this->var->add_def_cols('id_inventario','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo_inventario','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_responsable_almacen','text');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen_ep','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_almacenero','int4');
		$this->var->add_def_cols('desc_empleado','int4');
		$this->var->add_def_cols('desc_persona','int4');
		$this->var->add_def_cols('desc_almacenero','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarInventario
	 * Propósito:				Contar los registros de tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ContarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVENT_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	///////////////////////////////////////////
	function ListarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVRES_SEL'";
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
		$this->var->add_def_cols('id_inventario','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo_inventario','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_responsable_almacen','text');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen_ep','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_almacenero','int4');
		$this->var->add_def_cols('desc_empleado','int4');
		$this->var->add_def_cols('desc_persona','int4');
		$this->var->add_def_cols('desc_almacenero','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarInventario
	 * Propósito:				Contar los registros de tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ContarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVRES_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	function ListarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVREV_SEL'";
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
		$this->var->add_def_cols('id_inventario','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo_inventario','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_responsable_almacen','text');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen_ep','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_almacenero','int4');
		$this->var->add_def_cols('desc_empleado','int4');
		$this->var->add_def_cols('desc_persona','int4');
		$this->var->add_def_cols('desc_almacenero','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarInventario
	 * Propósito:				Contar los registros de tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ContarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVREV_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}
	//////////////////
	function ListarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVCON_SEL'";
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
		$this->var->add_def_cols('id_inventario','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('tipo_inventario','varchar');
		$this->var->add_def_cols('id_almacen','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_responsable_almacen','text');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen_ep','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_almacenero','int4');
		$this->var->add_def_cols('desc_empleado','int4');
		$this->var->add_def_cols('desc_persona','int4');
		$this->var->add_def_cols('desc_almacenero','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ContarInventario
	 * Propósito:				Contar los registros de tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ContarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_sel';
		$this->codigo_procedimiento = "'AL_INVCON_COUNT'";
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
		{	$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//Retorna el resultado de la ejecución
		return $res;
	}

	
	///////////////////////////////////////////
	/**
	 * Nombre de la función:	InsertarInventario
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function InsertarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
        $this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarInventario
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ModificarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
		
	/**
	 * Nombre de la función:	EliminarInventario
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function EliminarInventario($id_inventario)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
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
	function IniciarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_INI'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function ReconteoInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_RECONT'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	function RevisarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_REV'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}	
	function ConcluirInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_INVENT_CON'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$tipo_inventario'");
		$this->var->add_param($id_almacen);
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_almacenero);
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}	
	function ActualizaFechaInventario($id_inventario)
	{
		$this->inventario = "";
		$this->nombre_funcion = 'f_tal_inventario_iud';
		$this->codigo_procedimiento = "'AL_FECINV_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_inventario);
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
	 * Nombre de la función:	ValidarInventario
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_inventario
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-30 16:44:48
	 */
	function ValidarInventario($operacion_sql,$id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero){	
		$this->salida = "";
		$valid = new cls_validacion_serv();
		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
			//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{	if($operacion_sql == 'update')
			{	//Validar id_inventario - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_inventario");
				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_inventario", $id_inventario))
				{	$this->salida = $valid->salida;
					return false;
				}
			}
			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar fecha_inicio - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_inicio");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_inicio", $fecha_inicio))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validar fecha_fin - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_fin");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_fin", $fecha_fin))
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

			//Validar tipo_inventario - tipo varchar
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_Columna("tipo_inventario");
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_MinLength(0);

				if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_inventario", $tipo_inventario))
				{
					$this->salida = $valid->salida;
					return false;
				}

			
			//Validar id_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen", $id_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_responsable_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_responsable_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_responsable_almacen", $id_responsable_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_almacen_ep - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_ep");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");		
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_ep", $id_almacen_ep))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
            $tipo_dato->set_AllowBlank("true");			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_allowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			{	$this->salida = $valid->salida;
				return false;
			}
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacenero");
			$tipo_dato->set_MaxLength(10);
            $tipo_dato->set_AllowBlank("true");			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacenero", $id_almacenero))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{	//Validar id_inventario - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_inventario");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_inventario", $id_inventario))
			{	$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;	
		}
		else
		{ 	return false;
		}
	}
	
	function InsertarAjusteInventario($id_ep, $id_almacen,$id_almacen_logico,$tipo_ajuste,$id_item,$cantidad){
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ajuste_inventario_iud';
		$this->codigo_procedimiento = "'AL_AJUINV_PROC'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ep,$id_almacen,$id_almacen_logico,$tipo_ajuste,$id_item,$cantidad);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	
	}
	
	
}?>