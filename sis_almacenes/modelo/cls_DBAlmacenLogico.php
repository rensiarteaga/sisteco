<?php
/**
 * Nombre de la clase:	cls_DBAlmacenLogico.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_almacen_logico
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 18:52:59
 */

class cls_DBAlmacenLogico
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
	 * Nombre de la función:	ListarAlmacenLogico
	 * Propósito:				Desplegar los registros de tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ListarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_SEL'";

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
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('obsevaciones','varchar');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen_ep','varchar');
		$this->var->add_def_cols('id_tipo_almacen','int4');
		$this->var->add_def_cols('desc_tipo_almacen','varchar');
		$this->var->add_def_cols('cerrado','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarAlmacenLogico
	 * Propósito:				Para desplegar los almacenes lógicos a partir de un almacén físico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ListarAlmacenLogicoFisEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_SELFISEP'";

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
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('obsevaciones','varchar');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_tipo_almacen','int4');
		$this->var->add_def_cols('desc_tipo_almacen','varchar');
		$this->var->add_def_cols('cerrado','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ListarAlmacenLogico
	 * Propósito:				Para desplegar los almacenes lógicos a partir de un almacén físico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ListarAlmacenLogicoFisEpM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_SELFISEPM'";

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
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('bloqueado','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('obsevaciones','varchar');
		$this->var->add_def_cols('id_almacen_ep','int4');
		$this->var->add_def_cols('desc_almacen','varchar');
		$this->var->add_def_cols('id_tipo_almacen','int4');
		$this->var->add_def_cols('desc_tipo_almacen','varchar');
		$this->var->add_def_cols('cerrado','varchar');
		$this->var->add_def_cols('id_unidad_organizacional','integer');
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarAlmacenLogico
	 * Propósito:				Contar los registros de tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_COUNT'";

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
	 * Nombre de la función:	ContarAlmacenLogico
	 * Propósito:				Contar los registros de los almacenes lógicos obtenidos a partir de un almacén físico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ContarAlmacenLogicoFisEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_COUNTFISEP'";

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
	 * Nombre de la función:	ContarAlmacenLogico
	 * Propósito:				Contar los registros de los almacenes lógicos obtenidos a partir de un almacén físico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ContarAlmacenLogicoFisEPM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_sel';
		$this->codigo_procedimiento = "'AL_ALMLOG_COUNTFISEPM'";

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
	 * Nombre de la función:	InsertarAlmacenLogico
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_iud';
		$this->codigo_procedimiento = "'AL_ALMLOG_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$obsevaciones'");
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_tipo_almacen);
		$this->var->add_param("'$cerrado'");
		$this->var->add_param($id_unidad_organizacional);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAlmacenLogico
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_iud';
		$this->codigo_procedimiento = "'AL_ALMLOG_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$bloqueado'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$obsevaciones'");
		$this->var->add_param($id_almacen_ep);
		$this->var->add_param($id_tipo_almacen);
		$this->var->add_param("'$cerrado'");
		$this->var->add_param($id_unidad_organizacional);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAlmacenLogico
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function EliminarAlmacenLogico($id_almacen_logico)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_almacen_logico_iud';
		$this->codigo_procedimiento = "'AL_ALMLOG_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_almacen_logico);
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
	 * Nombre de la función:	ValidarAlmacenLogico
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_almacen_logico
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 18:52:59
	 */
	function ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado)
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
				//Validar id_almacen_logico - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_almacen_logico");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar bloqueado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("bloqueado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "bloqueado", $bloqueado))
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

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(150);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
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

			//Validar obsevaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("obsevaciones");
			$tipo_dato->set_MaxLength(100);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "obsevaciones", $obsevaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen_ep - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_ep");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_ep", $id_almacen_ep))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_almacen");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_almacen", $id_tipo_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cerrado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cerrado");
			$tipo_dato->set_MaxLength(15);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "cerrado", $cerrado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar bloqueado
			$check = array ("si","no");
			if(!in_array($bloqueado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'bloqueado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacenLogico";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar cerrado
			$check = array ("Gestion","No","Definitivo");
			if(!in_array($cerrado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'cerrado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarAlmacenLogico";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
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