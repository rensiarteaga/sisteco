<?php
/**
 * Nombre de la clase:	cls_DBOrdenSalidaUCDetalle.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_almacen
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-11 09:24:52
 */

class cls_DBOrdenSalidaUCDetalle
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
	 * Nombre de la función:	ListarOrdenSalidaUCDetalle
	 * Propósito:				Desplegar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_orden_salida_uc_detalle','int4');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_tipo_unidad_constructiva','integer');
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('id_unidad_constructiva','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('repeticion','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('id_item','integer');

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
	 * Nombre de la función:	ContarOrdenSalidaUCDetalle
	 * Propósito:				Contar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ContarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional    == '', "'%'", "'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa    == '', "'%'", "'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto    == '', "'%'", "'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad   == '', "'%'", "'$id_actividad'"));//id_actividad
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

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
	 * Nombre de la función:	ListarOrdenSalidaUCDetalle
	 * Propósito:				Desplegar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ListarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_RAMAS_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		$this->var->add_param("$id_raiz");
		$this->var->add_param("$id_orden_salida_uc_detalle");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_tipo_unidad_constructiva','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_composicion_tuc','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('id_tuc_padre','int4');
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('reemplazo','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
//exit;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarOrdenSalidaUCDetalle
	 * Propósito:				Contar los registros de tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ContarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle)
	//function ContarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_RAMAS_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '', "'%'", "'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional    == '', "'%'", "'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa    == '', "'%'", "'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto    == '', "'%'", "'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad   == '', "'%'", "'$id_actividad'"));//id_actividad
		$this->var->add_param("$id_raiz");
		$this->var->add_param("$id_orden_salida_uc_detalle");

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
	function ListarOrdenSalidaUCDetalleItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_ITEM_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
		$this->var->add_param("$raiz");
		$this->var->add_param("$id_orden_salida_uc_detalle");

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
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('cantidad_padre','numeric');
		
		$this->var->add_def_cols('cant_demasia','numeric');
		$this->var->add_def_cols('cant_tot','numeric');
		$this->var->add_def_cols('demasia_porc','numeric');

		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo "query: ".$this->query;
		exit;*/
		return $res;
	}
	
	function ListarOrdenSalidaUCDetalleItemEntregados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_sel';
		$this->codigo_procedimiento = "'AL_OSUCDE_ENT_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = "'$cant'";
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
		$this->var->add_param("$raiz");
		$this->var->add_param("$id_orden_salida_uc_detalle");

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
		$this->var->add_def_cols('considerar_repeticion','varchar');
		$this->var->add_def_cols('cantidad_entregada','numeric');

		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	InsertarOrdenSalidaUCDetalle
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function InsertarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$repeticion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param("$id_salida");
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param($cantidad);
		$this->var->add_param("NULL");//id_item
		$this->var->add_param($repeticion ? "'si'":"'no'");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarOrdenSalidaUCDetalleItem
	 * Propósito:				Permite grabar los items en OrdenSalidaUcDetalle
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function InsertarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_ITEM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_tipo_unidad_constructiva
		$this->var->add_param("$id_salida");
		$this->var->add_param($id_unidad_constructiva);
		$this->var->add_param($cantidad);
		$this->var->add_param("$id_item");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ModificarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$cantidad,$repeticion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_orden_salida_uc_detalle");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);//id_tipo_unidad_constructiva
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param($cantidad);
		$this->var->add_param("NULL");//id_item
		$this->var->add_param($repeticion ? "'si'":"'no'");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ModificarOrdenSalidaUCDetalleRama($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$cantidad,$id_composicion_tuc)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_RAMA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_orden_salida_uc_detalle");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_unidad_constructiva");//id_tipo_unidad_constructiva
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param("$cantidad");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("$id_composicion_tuc");//id_composicion_tuc
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarAlmacen
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ModificarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$cantidad,$id_item)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_ITEM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_orden_salida_uc_detalle");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_tipo_unidad_constructiva
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param($cantidad);
		$this->var->add_param("$id_item");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ReemplazarRamaOrdenSalidaUCDetalle
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ReemplazarRamaOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_composicion_tuc,$cantidad,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_RAMA_REE'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_orden_salida_uc_detalle");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_unidad_constructiva");//id_tipo_unidad_constructiva
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_unidad_constructiva
		$this->var->add_param($cantidad);
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}




	/**
	 * Nombre de la función:	EliminarAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function EliminarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_iud';
		$this->codigo_procedimiento = "'AL_OSUCDE_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_salida_uc_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");//id_composicion_tuc

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	/**
	 * Nombre de la función:	EliminarAlmacen
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function EliminarOrdenSalidaUCDetalleTmp($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_DEL_TMP'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	function EliminarOrdenSalidaUCDetalleInt($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_DEL_INT'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function EliminarVerifReservInt($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_DEL_RES'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function VerificarTipoEntrega($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_VERIF_TIPOENT'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("NULL");//repeticion
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
	 * Nombre de la función:	insertarTucTpmPedido
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function insertarTucTpmPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{


		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_TUC_TMP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_salida_uc_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("'no'");//id_item
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	insertarTucTpmPedido
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2008-01-30 09:24:52
	 */
	function insertarItemTpmPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{


		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_ITEM_TMP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_salida_uc_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("'no'");//id_item
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	verificarPedidoTucTmp
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function verificarPedidoTucTmp($id_salida,$id_almacen_logico)
	{

		//echo "LLEGA AQUI"; exit;
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_VERIF_EXI_TMP'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_orden_salida_uc_detalle
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("'no'");//repeticion
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}


	function insertarTucIntPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_TUC_INT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_salida_uc_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("'no'");//id_item
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}

	/**
	 * Nombre de la función:	insertarTucTpmPedido
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2008-01-30 09:24:52
	 */
	function insertarItemIntPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{


		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_ITEM_INT_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_orden_salida_uc_detalle);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_unidad_constructiva);
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param($cantidad);
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("'no'");//id_item
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/
		
		
		echo "query:".$this->query;
		exit;
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}

	/**
	 * Nombre de la función:	verificarPedidoTucInt
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function verificarPedidoTucInt($id_salida,$id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_VERIF_EXI_INT'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_orden_salida_uc_detalle
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("'no'");//repeticion
		$this->var->add_param($id_almacen_logico);//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;

		return $res;
	}


	/**
	 * Nombre de la función:	modificarSalidaTipoEntrega
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function modificarSalidaTipoEntrega($id_salida,$tipo_entrega)
	{

		//echo "LLEGA AQUI"; exit;
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_OSUCDE_UPD_TIPENTR'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_orden_salida_uc_detalle
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item
		$this->var->add_param("'$tipo_entrega'");//repeticion
		$this->var->add_param("NULL");//id_almacen_logico
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	VerificarReservarPedidoTucInt
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen
	 * Autor:				    Rensi ARteaga Copari
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function VerificarReservarPedidoTucInt($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_orden_salida_uc_detalle_ext';
		$this->codigo_procedimiento = "'AL_VERIFRES_EXI_INT'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");//id_orden_salida_uc_detalle
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_salida");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_item);//id_item
		$this->var->add_param("'no'");//repeticion
		$this->var->add_param("NULL");//id_almacen_logico
		/*if($repeticion)
		$repeticion='si';
		else
		$repeticion='no';
		$this->var->add_param($repeticion);//id_item*/

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
	 * Nombre de la función:	ValidarAlmacen
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_almacen
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-11 09:24:52
	 */
	function ValidarOrdenSalidaUCDetalle($operacion_sql,$id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad)
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
				//Validar id_almacen - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_orden_salida_uc_detalle");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_salida_uc_detalle", $id_orden_salida_uc_detalle))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
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
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_fil_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_unidad_constructiva", $id_tipo_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_fil_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_col_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_constructiva");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_constructiva", $id_unidad_constructiva))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar via_fil_max - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_MinLength(1);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_orden_salida_uc_detalle");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_salida_uc_detalle", $id_orden_salida_uc_detalle))
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
