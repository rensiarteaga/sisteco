<?php
/**
 * Nombre de la clase:	cls_DBSalida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_salida
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 15:07:58
 */

class cls_DBSalida
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
	 * Nombre de la función:	ListarSalida
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ListarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALIDA_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','int4');
		$this->var->add_def_cols('correlativo_vale','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalida
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALIDA_COUNT'";

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
	 * Nombre de la función:	ListarSalidaAprobacion
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ListarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SAAPRO_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','int4');
		$this->var->add_def_cols('correlativo_vale','int4');
		$this->var->add_def_cols('fecha_pendiente','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "sql: ".$this->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalidaAprobacion
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SAAPRO_COUNT'";

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
	 * Nombre de la función:	ListarSalidaConsolidada
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ListarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALCON_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','int4');
		$this->var->add_def_cols('correlativo_vale','int4');
		$this->var->add_def_cols('fecha_provisional','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalidaConsolidada
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALCON_COUNT'";

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
	function ListarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALFIN_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','int4');
		$this->var->add_def_cols('correlativo_vale','int4');
		$this->var->add_def_cols('fecha_entregado','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalidaAprobacion
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALFIN_COUNT'";

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
	function ListarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALPEN_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','int4');
		$this->var->add_def_cols('correlativo_vale','int4');
		$this->var->add_def_cols('fecha_aprobado_rechazado','date');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('tipo_entrega','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalidaPendiente
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALPEN_COUNT'";

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
		$this->salida = $this->var->salida[0][0];

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		/*if($res)
		{
		$this->salida = $this->var->salida[0][0];
		}*/

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;


		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarSalida
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function InsertarSalida($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($correlativo_sal);
		$this->var->add_param($correlativo_vale);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$motivo_cancelacion'");
		$this->var->add_param($id_responsable_almacen);//10
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_tipo_material);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_subactividad);
		$this->var->add_param($id_motivo_salida_cuenta);
		$this->var->add_param("'$emergencia'");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarSalida
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ModificarSalida($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param($correlativo_sal);
		$this->var->add_param($correlativo_vale);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$motivo_cancelacion'");
		$this->var->add_param($id_responsable_almacen);//10
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_tipo_material);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_subactividad);
		$this->var->add_param($id_motivo_salida_cuenta);
		$this->var->add_param("'$emergencia'");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ModificarSalidaPendiente
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ModificarSalidaPendiente($id_salida,$estado_salida,$estado_registro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALPEN_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function EliminarSalida($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//5
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//15
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20//observaciones
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//25
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	AprobarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function AprobarSalida($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_APR'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	RechazarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function RechazarSalida($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_REC'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	RechazarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function FinalizarSalida($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	FinalizarSalidaUCProy
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function FinalizarSalidaUCProy($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SAPRUC_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo "query: ".$this->query;
		exit;*/

		return $res;
	}
	/**
	 * Nombre de la función:	CorreccionSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function CorreccionSalida($id_salida,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_COR'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	/**
	 * Nombre de la función:	ConsolidarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ConsolidarSalida($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_CON'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	FinalizarSalidaProy
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function FinalizarSalidaProy($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SAPROY_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*		echo "query: ".$this->query;
		exit;*/

		return $res;
	}

	/**
	 * Nombre de la función:	PedidoMaterialesUC
	 * Propósito:				Despliega formulario de pedido de materiales UC. aumentada en Yucumo 
	 * Autor:				    RCM
	 * Fecha de creación:		04/06/2008
	 */
	function PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PMUCRP_SEL'";
		

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
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('receptor','varchar');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('desc_uc','varchar');
		$this->var->add_def_cols('desc_uc_padre','varchar');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','integer');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('receptor_ci','varchar');
		$this->var->add_def_cols('supervisor','text');
		$this->var->add_def_cols('superv_doc_id','varchar');
		$this->var->add_def_cols('almacenero','text');
		$this->var->add_def_cols('almacenero_doc_id','varchar');
		$this->var->add_def_cols('correlativo_sal','text');
		$this->var->add_def_cols('num_contrato','varchar');
		$this->var->add_def_cols('tramo','varchar');
		$this->var->add_def_cols('subactividad','varchar');
		$this->var->add_def_cols('uc','varchar');
		
		$this->var->add_def_cols('jefe_almacen','text');//9
		$this->var->add_def_cols('doc_jefe_almacen','varchar');
		$this->var->add_def_cols('observaciones','varchar');//11
		$this->var->add_def_cols('almacen_log','varchar');//21
		$this->var->add_def_cols('motivo_sal','varchar');//22
		$this->var->add_def_cols('codigo_proyecto','varchar');//23
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo "query: ".$this->query;
		exit;*/
		/*print ("<pre>");
		print_r($this->salida);
		print ("</pre>");
		exit;*/
		return $res;
	}
	
	

	/**
	 * Nombre de la función:	PedidoMaterialesUCDet
	 * Propósito:				Despliega formulario del detalle de pedido de materiales UC. Aumentada en Yucumo
	 * Autor:				    RCM
	 * Fecha de creación:		04/06/2008
	 */
	function PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PMUCDR_SEL'";

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('cant_unit_uc','numeric');
		$this->var->add_def_cols('peso_kg','numeric');
		$this->var->add_def_cols('unidad_medida','varchar');
		$this->var->add_def_cols('calidad','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('peso_total','numeric');
		$this->var->add_def_cols('cantidad_total','numeric');
		$this->var->add_def_cols('cant_demasia','numeric');
		$this->var->add_def_cols('cantidad_total_dem','numeric');
		
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('desc_uc','varchar');
		$this->var->add_def_cols('cantidad_uc','numeric');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('desc_uc_padre','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('id_supergrupo','integer');
		$this->var->add_def_cols('demasia','varchar');
	

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		/*print ("<pre>");
		print_r($this->salida);
		print ("</pre>");
		exit;*/

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;

		return $res;
	}
	/**
	 * Nombre de la función:	PedidoMaterialesSimplificado
	 * Propósito:				Despliega formulario de pedido de materiales 
	 * Autor:				    ARV
	 * Fecha de creación:		13/02/2009
	 */
	function PedidoMaterialesSimplificado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PMSIMP_SEL'";
		

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
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('receptor','varchar');
		
		$this->var->add_def_cols('almacen_log','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('motivo_sal','varchar');
		
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('receptor_ci','varchar');
		$this->var->add_def_cols('supervisor','text');
		$this->var->add_def_cols('superv_doc_id','varchar');
		$this->var->add_def_cols('almacenero','text');
		$this->var->add_def_cols('almacenero_doc_id','varchar');
		$this->var->add_def_cols('correlativo_sal','text');
		$this->var->add_def_cols('num_contrato','varchar');
		$this->var->add_def_cols('tramo','varchar');
		$this->var->add_def_cols('subactividad','varchar');
			
		$this->var->add_def_cols('jefe_almacen','text');//9
		$this->var->add_def_cols('doc_jefe_almacen','varchar');
		$this->var->add_def_cols('observaciones','varchar');//11
		
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "query: ".$this->query;
		//exit;
		/*print ("<pre>");
		print_r($this->salida);
		print ("</pre>");
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	PedidoMaterialesSimplificadoDet
	 * Propósito:				Despliega formulario de pedido de materiales simplificado detalle
	 * Autor:				    ARV
	 * Fecha de creación:		16/02/2009
	 */
	function PedidoMaterialesSimplificadoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PMSIMD_SEL'";
		

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
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('cant_entregada','numeric');
		$this->var->add_def_cols('unidad_medida','varchar');
		$this->var->add_def_cols('calidad','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_aux','varchar');
		$this->var->add_def_cols('cant_solicitada','numeric');
		$this->var->add_def_cols('peso_neto','numeric');
		
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo "query: ".$this->query;
		exit;*/
		/*print ("<pre>");
		print_r($this->salida);
		print ("</pre>");
		exit;*/
		return $res;
	}

	/**
	 * Nombre de la función:	DiarioSalida
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    RCM
	 * Fecha de creación:		31/08/08
	 */
	function DiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_DIASAL_SEL'";

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
		$this->var->add_def_cols('correlativo_sal','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('almacenero','text');
		$this->var->add_def_cols('jefe_almacen','text');
		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('tramo','varchar');
		$this->var->add_def_cols('almacen','varchar');

		/*echo "query: ".$this->var->get_query();
		exit;*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;



		return $res;
	}

	/**
	 * Nombre de la función:	DiarioSalida
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    RCM
	 * Fecha de creación:		31/08/08
	 */
	function DiarioSalidaAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_DIASAL_ALM'";

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
		$this->var->add_def_cols('correlativo_sal','varchar');
		$this->var->add_def_cols('importe','numeric');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('almacenero','text');
		$this->var->add_def_cols('jefe_almacen','text');
		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('tramo','varchar');
		$this->var->add_def_cols('almacen','varchar');

		/*echo "query: ".$this->var->get_query();
		exit;*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;



		return $res;
	}
	
	/**
	 * Nombre de la función:	PedidoMaterialesDet
	 * Propósito:				Despliega formulario del detalle de pedido de materiales UC. Aumentada en Yucumo
	 * Autor:				    RCM
	 * Fecha de creación:		04/06/2008
	 */
	function PedidoMaterialesDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PEDDET_SEL'";

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
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('cant_entregada','numeric');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('calidad','varchar');
		$this->var->add_def_cols('peso_kg','numeric');
		$this->var->add_def_cols('unidad_medida','varchar');
		$this->var->add_def_cols('peso_total','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		/*print ("<pre>");
		print_r($this->salida);
		print ("</pre>");
		exit;*/

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		/*echo "query: ".$this->query;
		exit;*/

		return $res;
	}

	/**
	 * Nombre de la función:	ValidarSalida
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ValidarSalida($operacion_sql,$id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta){
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_salida - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_salida");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar correlativo_sal - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_sal");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "correlativo_sal", $correlativo_sal))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar correlativo_vale - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_vale");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "correlativo_vale", $correlativo_vale))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contabilizar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizar");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizar", $contabilizar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar contabilizado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizado", $contabilizado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_salida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_salida");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_salida", $estado_salida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar motivo_cancelacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("motivo_cancelacion");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "motivo_cancelacion", $motivo_cancelacion))
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

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_firma_autorizada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_firma_autorizada");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_firma_autorizada", $id_firma_autorizada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_contratista - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_contratista");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contratista", $id_contratista))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_material - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_material");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_material", $id_tipo_material))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subactividad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subactividad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subactividad", $id_subactividad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar id_motivo_salida_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_motivo_salida_cuenta");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_salida_cuenta", $id_motivo_salida_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar contabilizar
			$check = array ("si","no");
			if(!in_array($contabilizar,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'contabilizar': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSalida";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar contabilizado
			$check = array ("si","no");
			if(!in_array($contabilizado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'contabilizado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSalida";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_salida
			$check = array ("Borrador","Pendiente","Aprobado","Rechazado","Entregado","Finalizado","Cancelado");
			if(!in_array($estado_salida,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_salida': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSalida";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar tipo_entrega
			$check = array ("Provisional","Consolidado");
			if(!in_array($tipo_entrega,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'tipo_entrega': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSalida";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar estado_registro
			$check = array ("activo","inactivo","eliminado");
			if(!in_array($estado_registro,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_registro': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarSalida";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_salida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
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