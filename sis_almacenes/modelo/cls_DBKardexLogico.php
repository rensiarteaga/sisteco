<?php
/**
 * Nombre de la clase:	cls_DBKardexLogico.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_kardex_logico
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 15:20:16
 */

class cls_DBKardexLogico
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
	 * Nombre de la función:	ListarKardexLogico
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ListarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_KARDEX_SEL'";

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_kardex_logico','int4');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('stock_minimo','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('costo_total','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('desc_item','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('reservado','numeric');
		$this->var->add_def_cols('gestion','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarKardexLogico
	 * Propósito:				Contar los registros de tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ContarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_KARDEX_COUNT'";

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
	 * Nombre de la función:	InsertarKardexLogico
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function InsertarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_iud';
		$this->codigo_procedimiento = "'AL_KARDEX_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$estado_item'");
		$this->var->add_param($stock_minimo);
		$this->var->add_param($cantidad);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($costo_total);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($reservado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarKardexLogico
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ModificarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_iud';
		$this->codigo_procedimiento = "'AL_KARDEX_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_kardex_logico);
		$this->var->add_param("'$estado_item'");
		$this->var->add_param($stock_minimo);
		$this->var->add_param($cantidad);
		$this->var->add_param($costo_unitario);
		$this->var->add_param($costo_total);
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param($id_item);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($reservado);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarKardexLogico
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function EliminarKardexLogico($id_kardex_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_iud';
		$this->codigo_procedimiento = "'AL_KARDEX_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_kardex_logico);
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
	 * Nombre de la función:	ListarKardexItemIngreso
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		18/08/2008
	 */
	function ListarKardexItemIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_KAITIN_SEL'";

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion_item','text');
		$this->var->add_def_cols('glosa','text');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('costo','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('correl_ing','text');
		$this->var->add_def_cols('fecha_orden','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query: ".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarKardexItemSalida
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		18/08/2008
	 */
	function ListarKardexItemSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_KAITSA_SEL'";

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion_item','text');
		$this->var->add_def_cols('glosa','text');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('costo','numeric');
		$this->var->add_def_cols('costo_unitario','numeric');
		$this->var->add_def_cols('correl_sal','text');
		$this->var->add_def_cols('fecha_orden','text');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "query: ".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarKardexItemSaldo
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		23/10/2008
	 */
	function ListarKardexItemSaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_KAISAL_SEL'";

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('saldo','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarParteDiarioIngreso
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		25/08/2008
	 */
	function ListarParteDiarioIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_PADIIN_SEL'";

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion_item','text');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('mot_ingreso','varchar');
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('saldo_actual','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarParteDiarioSalida
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		27/08/2008
	 */
	function ListarParteDiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_PADISA_SEL'";

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
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion_item','text');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('mot_salida','varchar');
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('demasia','numeric');
		$this->var->add_def_cols('saldo_actual','numeric');
		$this->var->add_param("NULL");

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarExistencias
	 * Propósito:				Desplegar los registros de tal_kardex_logico
	 * Autor:				    RCM
	 * Fecha de creación:		14-10-2008
	 */
	function ListarExistencias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$condiciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_kardex_logico_sel';
		$this->codigo_procedimiento = "'AL_EXISTE_SEL'";

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
		$this->var->add_param($condiciones);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('estado_item','varchar');
		$this->var->add_def_cols('peso_kg','numeric');
		$this->var->add_def_cols('cantidad_ingreso','numeric');
		$this->var->add_def_cols('cantidad_salida','numeric');
		$this->var->add_def_cols('saldo','numeric');
		
		/*echo "query: ".$this->var->get_query();
		exit;*/

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo "query: ".$this->query;
		exit;*/
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarParteDiario
	 * Propósito:				Despliega el Parte Diario total
	 * Autor:				    RCM
	 * Fecha de creación:		24/12/2008
	 */
	function ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$fecha_desde,$fecha_hasta,$id_almacen,$id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_al_parte_diario';
		$this->codigo_procedimiento = "'AL_PARTED_SEL'";

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
		$this->var->add_param($id_parametro_almacen);
		$this->var->add_param("'$fecha_desde'");
		$this->var->add_param("'$fecha_hasta'");
		$this->var->add_param("'$id_almacen'");
		$this->var->add_param("'$id_almacen_logico'");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion_item','varchar');
		$this->var->add_def_cols('cant_saldo_ant','numeric');
		$this->var->add_def_cols('cant_ing','numeric');
		$this->var->add_def_cols('cant_ing_transf','numeric');
		$this->var->add_def_cols('cant_ing_dev','numeric');
		$this->var->add_def_cols('cant_tot_ing','numeric');
		$this->var->add_def_cols('cant_sal','numeric');
		$this->var->add_def_cols('cant_sal_transf','numeric');
		$this->var->add_def_cols('cant_sal_dem','numeric');
		$this->var->add_def_cols('cant_tot_sal','numeric');
		$this->var->add_def_cols('cant_saldo_tot','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo "query:".$this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarKardexLogico
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_kardex_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 15:20:16
	 */
	function ValidarKardexLogico($operacion_sql,$id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$stock,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
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
				//Validar id_kardex_logico - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_kardex_logico");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_kardex_logico", $id_kardex_logico))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar estado_item - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_item", $estado_item))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar stock_minimo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("stock_minimo");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "stock_minimo", $stock_minimo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_unitario - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_unitario");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_unitario", $costo_unitario))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar costo_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_total");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_total", $costo_total))
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

			//Validar id_item - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_item");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item", $id_item))
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

			//Validar reservado - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("reservado");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "reservado", $reservado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar estado_item
			$check = array ("Nuevo","Obsoleto","Usado");
			if(!in_array($estado_item,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'estado_item': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarKardexLogico";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_kardex_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_kardex_logico");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_kardex_logico", $id_kardex_logico))
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