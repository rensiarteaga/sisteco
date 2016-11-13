<?php
/**
 * Nombre de la Clase:	cls_DBDepreciacion
 * Propósito:			Permite ejecutar la funcionalidad de la tabla taf_depreciacion
 * Autor:				Rodrigo Chumacero Moscoso
 * Fecha creación:		11-06-2007
 *
 */
class cls_DBDepreciacion
{
	//Variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida;

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query;

	//Variables para la ejecución de funciones
	var $var; //middle_client
	var $nombre_funcion; //nombre de la función a ejecutar
	var $codigo_procedimiento; //codigo del procedimiento a ejecutar

	//Nombre del archivo
	var $nombre_archivo = "cls_DBDepreciacion.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		$this->cargar_param_valid();

		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarDepreciacion
	 * Propósito:				Desplegar los registros de taf_depreciacion en función de los parámetros del filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		11-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEP_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_depreciacion','integer');
		$this->var->add_def_cols('fecha_desde','date');
		$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('monto_vigente_ant','numeric');
		$this->var->add_def_cols('monto_vigente','numeric');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('depreciacion_acum_ant','numeric');
		$this->var->add_def_cols('depreciacion','numeric');
		$this->var->add_def_cols('nuevo_monto','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('id_moneda','integer');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
		
		
	}

	/**
	 * Nombre de la función:	ContarListaDepreciacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		11-06-2007
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarListaDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEP_SEL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
	 * Nombre de la función:	ListarDepreciacion2Det
	 * Propósito:				Desplegar los registros de taf_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:40
	 */
	function ListarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEPRDET_SEL'";

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
		$this->var->add_def_cols('id_depreciacion','int4');
		$this->var->add_def_cols('fecha_desde','date');
		$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('monto_vigente_ant','numeric');
		$this->var->add_def_cols('monto_vigente','numeric');
		$this->var->add_def_cols('vida_util','int4');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('depreciacion_acum_ant','numeric');
		$this->var->add_def_cols('depreciacion','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('id_activo_fijo','int4');
		$this->var->add_def_cols('desc_activo_fijo','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('monto_vigente_ant_2','numeric');
		$this->var->add_def_cols('monto_vigente_2','numeric');
		$this->var->add_def_cols('vida_util_2','int4');
		$this->var->add_def_cols('depreciacion_acum_ant_2','numeric');
		$this->var->add_def_cols('depreciacion_2','numeric');
		$this->var->add_def_cols('depreciacion_acum_2','numeric');
		$this->var->add_def_cols('monto_actualiz_ant','numeric');
		$this->var->add_def_cols('monto_actualiz','numeric');
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('monto_actualiz_2','numeric');
		$this->var->add_def_cols('dep_acum_actualiz_2','numeric');
		$this->var->add_def_cols('id_grupo_depreciacion','int4');
		$this->var->add_def_cols('desc_grupo_depreciacion','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarDepreciacion2Det
	 * Propósito:				Contar los registros de taf_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:40
	 */
	function ContarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEPRDET_COUNT'";

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
	 * Nombre de la función:	EliminarDepreciacion2Det
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_depreciacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-07-20 14:54:40
	 */
	function EliminarDepreciacion2Det($id_depreciacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_iud';
		$this->codigo_procedimiento = "'AF_DEPRDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_depreciacion);
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
	 * Nombre de la función:	CrearDepreciacion
	 * Propósito:				Permite ejecutar la función de inserción de la taf_depreciacion de la base de datos,
	 * 							con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		11-06-2007
	 *
	 * @param unknown_type $id_depreciacion
	 * @param unknown_type $fecha_desde
	 * @param unknown_type $fecha_hasta
	 * @param unknown_type $monto_vigente_ant
	 * @param unknown_type $monto_vigente
	 * @param unknown_type $vida_util
	 * @param unknown_type $tipo_cambio_ini
	 * @param unknown_type $tipo_cambio_fin
	 * @param unknown_type $depreciacion_acum_ant
	 * @param unknown_type $depreciacion
	 * @param unknown_type $nuevo_monto
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $depreciacion_acum
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function CrearDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion';
		$this->codigo_procedimiento = "'AF_DEP_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param("NULL");//id_depreciacion
		$this->var->add_param("'$fecha_desde'");//fecha_desde
		$this->var->add_param("'$fecha_hasta'");//fecha_hasta
		$this->var->add_param($monto_vigente_ant);//monto_vigente_ant
		$this->var->add_param($monto_vigente);//monto_vigente
		$this->var->add_param($vida_util);//vida_util
		$this->var->add_param($tipo_cambio_ini);//tipo_cambio_ini
		$this->var->add_param($tipo_cambio_fin);//tipo_cambio_fin
		$this->var->add_param($depreciacion_acum_ant);//depreciacion_acum_ant
		$this->var->add_param($depreciacion);//depreciacion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($depreciacion_acum);//depreciacion_acum
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_moneda);//id_moneda

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
	 * Nombre de la función:	EliminarDepreciacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla taf_depreciacion de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		11-06-2007
	 *
	 * @param unknown_type $id_depreciacion
	 * @return unknown
	 */
	function  EliminarDepreciacion($id_depreciacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion';
		$this->codigo_procedimiento = "'AF_DEP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param('NULL');//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_depreciacion);//id_depreciacion
		$this->var->add_param('NULL');//fecha_desde
		$this->var->add_param('NULL');//fecha_hasta
		$this->var->add_param('NULL');//monto_vigente_ant
		$this->var->add_param('NULL');//monto_vigente
		$this->var->add_param('NULL');//vida_util
		$this->var->add_param('NULL');//tipo_cambio_ini
		$this->var->add_param('NULL');//tipo_cambio_fin
		$this->var->add_param('NULL');//depreciacion_acum_ant
		$this->var->add_param('NULL');//depreciacion
		$this->var->add_param('NULL');//fecha_reg
		$this->var->add_param('NULL');//estado
		$this->var->add_param('NULL');//depreciacion_acum
		$this->var->add_param('NULL');//id_activo_fijo
		$this->var->add_param('NULL');//id_moneda

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarDepreciacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla taf_depreciacion de la base de datos
	 * con los parámetros requeridos
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha de creación:		11-06-2007
	 *
	 * @param unknown_type $id_depreciacion
	 * @param unknown_type $fecha_desde
	 * @param unknown_type $fecha_hasta
	 * @param unknown_type $monto_vigente_ant
	 * @param unknown_type $monto_vigente
	 * @param unknown_type $vida_util
	 * @param unknown_type $tipo_cambio_ini
	 * @param unknown_type $tipo_cambio_fin
	 * @param unknown_type $depreciacion_acum_ant
	 * @param unknown_type $depreciacion
	 * @param unknown_type $nuevo_monto
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $depreciacion_acum
	 * @param unknown_type $id_activo_fijo
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function  ModificarDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion';
		$this->codigo_procedimiento = "'AF_DEP_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		//Carga parámetros específicos (no incluyen los parámetros fijos)
		$this->var->add_param("NULL");//id_fina_regi_prog_proy_acti
		$this->var->add_param($id_depreciacion);//id_depreciacion
		$this->var->add_param("'$fecha_desde'");//fecha_desde
		$this->var->add_param("'$fecha_hasta'");//fecha_hasta
		$this->var->add_param($monto_vigente_ant);//monto_vigente_ant
		$this->var->add_param($monto_vigente);//monto_vigente
		$this->var->add_param($vida_util);//vida_util
		$this->var->add_param($tipo_cambio_ini);//tipo_cambio_ini
		$this->var->add_param($tipo_cambio_fin);//tipo_cambio_fin
		$this->var->add_param($depreciacion_acum_ant);//depreciacion_acum_ant
		$this->var->add_param($depreciacion);//depreciacion
		$this->var->add_param("'$fecha_reg'");//fecha_reg
		$this->var->add_param("'$estado'");//estado
		$this->var->add_param($depreciacion_acum);//depreciacion_acum
		$this->var->add_param($id_activo_fijo);//id_activo_fijo
		$this->var->add_param($id_moneda);//id_moneda

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	//function Depreciar($fecha_fin, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo, $codigo_temp)
	function Depreciar($fecha_fin, $id_depto, $codigo_temp)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_af_depreciacion_new';
		$this->codigo_procedimiento = "'AF_DEP'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		$func = new cls_funciones();//Instancia de las funciones generales

		//Carga los parámetros específicos de la estructura programática
		/*$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad*/

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		//$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("'$id_depto'");//id_depto
		
		/*$this->var->add_param("'$id_tipo_activo'");//id_tipo_activo
		$this->var->add_param("'$id_sub_tipo_activo'");//id_sub_tipo_activo
		$this->var->add_param("'$id_activo_fijo'");//id_activo_fijo*/
		
		
		$this->var->add_param("'$codigo_temp'");//codigo_temp
		$this->var->add_param("'no'");//rev_dep
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
   /*   echo "salida[0]=".$this->salida[0];
		echo "salida[1]=".$this->salida[1];
		echo "salida[2]=".$this->salida[2];
		echo "salida[3]=".$this->salida[3];

		echo "-----res = ".$res ."------";*/
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
	
		return $res;
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	
//function DepreciarInv($fecha_fin, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo, $codigo_temp)
	function DepreciarInv($fecha_fin, $id_depto, $codigo_temp)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_af_depreciacion_new';
		$this->codigo_procedimiento = "'AF_DEP'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);

		$func = new cls_funciones();//Instancia de las funciones generales

		//Carga los parámetros específicos de la estructura programática
		/*$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad*/

		//Carga parámetros específicos (no incluyen los parámetros fijos)
		//$this->var->add_param("'$fecha_ini'");//fecha_ini
		$this->var->add_param("'$fecha_fin'");//fecha_fin
		$this->var->add_param("'$id_depto'");//id_depto
		
		/*$this->var->add_param("'$id_tipo_activo'");//id_tipo_activo
		$this->var->add_param("'$id_sub_tipo_activo'");//id_sub_tipo_activo
		$this->var->add_param("'$id_activo_fijo'");//id_activo_fijo*/
		
		
		$this->var->add_param("'$codigo_temp'");//codigo_temp
		$this->var->add_param("'si'");//rev_dep

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
      /*echo "salida[0]=".$this->salida[0];
		echo "salida[1]=".$this->salida[1];
		echo "salida[2]=".$this->salida[2];
		echo "salida[3]=".$this->salida[3];

		echo "-----res = ".$res ."------";*/
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
/*		echo "query: ".$this->query;
		exit;*/
	
		return $res;
	}	
	
////////////////////////////////////////////////////////////////////////////////////////////////////////
	/**
	  * Nombre de la función:	ValidarDepreciacion
	 * Propósito:				Realiza una validación de datos del lado del servidor (sin consultar a BD)
	 * Autor:					Rodrigo Chumacero Moscoso
	 * Fecha creación:			11-06-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_activo
	 * @param unknown_type $codigo
	 * @param unknown_type $descripcion
	 * @param unknown_type $flag_depreciacion
	 * @param unknown_type $fecha_reg
	 * @param unknown_type $estado
	 * @param unknown_type $id_metodo_depreciacion
	 * @param unknown_type $id_moneda
	 * @return unknown
	 */
	function ValidarDepreciacion($operacion_sql, $id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		//operacion_sql se refiere a que operación validar (por ejemplo: insert, update, delete; podrían ser otros específicos)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Ejecuta la validación por el tipo de operación
		switch ($operacion_sql) {
			case 'insert':

				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha_desde", $fecha_desde))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "fecha_hasta", $fecha_hasta))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[3], "monto_vigente_ant", $monto_vigente_ant))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "vida_util", $vida_util))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"tipo_cambio_ini", $tipo_cambio_ini))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"tipo_cambio_fin", $tipo_cambio_fin))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"depreciacion_acum_ant", $depreciacion_acum_ant))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"depreciacion", $depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[9] ,"nuevo_monto", $nuevo_monto))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[10] ,"fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[11] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[12] ,"depreciacion_acum", $depreciacion_acum))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[13] ,"id_activo_fijo", $id_activo_fijo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[14] ,"id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}


				//Validación exitosa
				return true;
				break;

			case 'update':
				/*******************************Verificación de datos****************************/
				//Verifica que las columnas obligatorias tengan datos, que tenga formato válido y un tamaño válido
				//Se valida todas las columnas de la tabla

				if(!$valid->verifica_dato($this->matriz_validacion[0], "id_depreciacion", $id_depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[1], "fecha_desde", $fecha_desde))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[2], "fecha_hasta", $fecha_hasta))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[3], "monto_vigente_ant", $monto_vigente_ant))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[4], "vida_util", $vida_util))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[5] ,"tipo_cambio_ini", $tipo_cambio_ini))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[6] ,"tipo_cambio_fin", $tipo_cambio_fin))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[7] ,"depreciacion_acum_ant", $depreciacion_acum_ant))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[8] ,"depreciacion", $depreciacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[9] ,"nuevo_monto", $nuevo_monto))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[10] ,"fecha_reg", $fecha_reg))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[11] ,"estado", $estado))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[12] ,"depreciacion_acum", $depreciacion_acum))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[13] ,"id_activo_fijo", $id_activo_fijo))
				{
					$this->salida = $valid->salida;
					return false;
				}
				if(!$valid->verifica_dato($this->matriz_validacion[14] ,"id_moneda", $id_moneda))
				{
					$this->salida = $valid->salida;
					return false;
				}

				//Validación exitosa
				return true;
				break;
			case 'delete':
				break;
			default:
				return false;
				break;
		}

	}

	function cargar_param_valid()
	{
		$this->matriz_validacion[0] = array();
		$this->matriz_validacion[0]['Columna'] = "id_depreciacion";
		$this->matriz_validacion[0]['allowBlank'] = "false";
		$this->matriz_validacion[0]['maxLength'] = 15;
		$this->matriz_validacion[0]['minLength'] = 0;
		$this->matriz_validacion[0]['SelectOnFocus'] = "true";
		$this->matriz_validacion[0]['vtype'] = "alphanum";
		$this->matriz_validacion[0]['dataType'] = "entero";
		$this->matriz_validacion[0]['width'] = "";
		$this->matriz_validacion[0]['grow'] = "";

		$this->matriz_validacion[1] = array();
		$this->matriz_validacion[1]['Columna'] = "fecha_desde";
		$this->matriz_validacion[1]['allowBlank'] = "false";
		$this->matriz_validacion[1]['maxLength'] = 10;
		$this->matriz_validacion[1]['minLength'] = 0;
		$this->matriz_validacion[1]['SelectOnFocus'] = "false";
		$this->matriz_validacion[1]['vtype'] = "alphaLatino";
		$this->matriz_validacion[1]['dataType'] = "texto";
		$this->matriz_validacion[1]['width'] = "";
		$this->matriz_validacion[1]['grow'] = "";

		$this->matriz_validacion[2] = array();
		$this->matriz_validacion[2]['Columna'] = "fecha_hasta";
		$this->matriz_validacion[2]['allowBlank'] = "false";
		$this->matriz_validacion[2]['maxLength'] = 100;
		$this->matriz_validacion[2]['minLength'] = 0;
		$this->matriz_validacion[2]['SelectOnFocus'] = "false";
		$this->matriz_validacion[2]['vtype'] = "alphaLatino";
		$this->matriz_validacion[2]['dataType'] = "texto";
		$this->matriz_validacion[2]['width'] = "";
		$this->matriz_validacion[2]['grow'] = "";

		$this->matriz_validacion[3] = array();
		$this->matriz_validacion[3]['Columna'] = "monto_vigente_ant";
		$this->matriz_validacion[3]['allowBlank'] = "false";
		$this->matriz_validacion[3]['maxLength'] = 2;
		$this->matriz_validacion[3]['minLength'] = 0;
		$this->matriz_validacion[3]['SelectOnFocus'] = "false";
		$this->matriz_validacion[3]['vtype'] = "alphaLatino";
		$this->matriz_validacion[3]['dataType'] = "texto";
		$this->matriz_validacion[3]['width'] = "";
		$this->matriz_validacion[3]['grow'] = "";

		$this->matriz_validacion[4] = array();
		$this->matriz_validacion[4]['Columna'] = "monto_vigente";
		$this->matriz_validacion[4]['allowBlank'] = "true";
		$this->matriz_validacion[4]['maxLength'] = 30;
		$this->matriz_validacion[4]['minLength'] = 0;
		$this->matriz_validacion[4]['SelectOnFocus'] = "true";
		$this->matriz_validacion[4]['vtype'] = "alphaLatino";
		$this->matriz_validacion[4]['dataType'] = "fecha";
		$this->matriz_validacion[4]['width'] = "";
		$this->matriz_validacion[4]['grow'] = "";

		$this->matriz_validacion[5] = array();
		$this->matriz_validacion[5]['Columna'] = "vida_util";
		$this->matriz_validacion[5]['allowBlank'] = "false";
		$this->matriz_validacion[5]['maxLength'] = 10;
		$this->matriz_validacion[5]['minLength'] = 0;
		$this->matriz_validacion[5]['SelectOnFocus'] = "true";
		$this->matriz_validacion[5]['vtype'] = "alphaLatino";
		$this->matriz_validacion[5]['dataType'] = "texto";
		$this->matriz_validacion[5]['width'] = "";
		$this->matriz_validacion[5]['grow'] = "";

		$this->matriz_validacion[6] = array();
		$this->matriz_validacion[6]['Columna'] = "tipo_cambio_ini";
		$this->matriz_validacion[6]['allowBlank'] = "false";
		$this->matriz_validacion[6]['maxLength'] = 15;
		$this->matriz_validacion[6]['minLength'] = 0;
		$this->matriz_validacion[6]['SelectOnFocus'] = "false";
		$this->matriz_validacion[6]['vtype'] = "alphaLatino";
		$this->matriz_validacion[6]['dataType'] = "integer";
		$this->matriz_validacion[6]['width'] = "";
		$this->matriz_validacion[6]['grow'] = "";

		$this->matriz_validacion[7] = array();
		$this->matriz_validacion[7]['Columna'] = "tipo_cambio_fin";
		$this->matriz_validacion[7]['allowBlank'] = "false";
		$this->matriz_validacion[7]['maxLength'] = 15;
		$this->matriz_validacion[7]['minLength'] = 0;
		$this->matriz_validacion[7]['SelectOnFocus'] = "false";
		$this->matriz_validacion[7]['vtype'] = "alphaLatino";
		$this->matriz_validacion[7]['dataType'] = "integer";
		$this->matriz_validacion[7]['width'] = "";
		$this->matriz_validacion[7]['grow'] = "";

		$this->matriz_validacion[8] = array();
		$this->matriz_validacion[8]['Columna'] = "depreciacion_acum_ant";
		$this->matriz_validacion[8]['allowBlank'] = "false";
		$this->matriz_validacion[8]['maxLength'] = 15;
		$this->matriz_validacion[8]['minLength'] = 0;
		$this->matriz_validacion[8]['SelectOnFocus'] = "false";
		$this->matriz_validacion[8]['vtype'] = "alphaLatino";
		$this->matriz_validacion[8]['dataType'] = "integer";
		$this->matriz_validacion[8]['width'] = "";
		$this->matriz_validacion[8]['grow'] = "";

		$this->matriz_validacion[9] = array();
		$this->matriz_validacion[9]['Columna'] = "depreciacion";
		$this->matriz_validacion[9]['allowBlank'] = "false";
		$this->matriz_validacion[9]['maxLength'] = 15;
		$this->matriz_validacion[9]['minLength'] = 0;
		$this->matriz_validacion[9]['SelectOnFocus'] = "false";
		$this->matriz_validacion[9]['vtype'] = "alphaLatino";
		$this->matriz_validacion[9]['dataType'] = "integer";
		$this->matriz_validacion[9]['width'] = "";
		$this->matriz_validacion[9]['grow'] = "";

		$this->matriz_validacion[10] = array();
		$this->matriz_validacion[10]['Columna'] = "nuevo_monto";
		$this->matriz_validacion[10]['allowBlank'] = "false";
		$this->matriz_validacion[10]['maxLength'] = 15;
		$this->matriz_validacion[10]['minLength'] = 0;
		$this->matriz_validacion[10]['SelectOnFocus'] = "false";
		$this->matriz_validacion[10]['vtype'] = "alphaLatino";
		$this->matriz_validacion[10]['dataType'] = "integer";
		$this->matriz_validacion[10]['width'] = "";
		$this->matriz_validacion[10]['grow'] = "";

		$this->matriz_validacion[11] = array();
		$this->matriz_validacion[11]['Columna'] = "fecha_reg";
		$this->matriz_validacion[11]['allowBlank'] = "false";
		$this->matriz_validacion[11]['maxLength'] = 15;
		$this->matriz_validacion[11]['minLength'] = 0;
		$this->matriz_validacion[11]['SelectOnFocus'] = "false";
		$this->matriz_validacion[11]['vtype'] = "alphaLatino";
		$this->matriz_validacion[11]['dataType'] = "integer";
		$this->matriz_validacion[11]['width'] = "";
		$this->matriz_validacion[11]['grow'] = "";

		$this->matriz_validacion[12] = array();
		$this->matriz_validacion[12]['Columna'] = "estado";
		$this->matriz_validacion[12]['allowBlank'] = "false";
		$this->matriz_validacion[12]['maxLength'] = 15;
		$this->matriz_validacion[12]['minLength'] = 0;
		$this->matriz_validacion[12]['SelectOnFocus'] = "false";
		$this->matriz_validacion[12]['vtype'] = "alphaLatino";
		$this->matriz_validacion[12]['dataType'] = "integer";
		$this->matriz_validacion[12]['width'] = "";
		$this->matriz_validacion[12]['grow'] = "";

		$this->matriz_validacion[13] = array();
		$this->matriz_validacion[13]['Columna'] = "depreciacion_acum";
		$this->matriz_validacion[13]['allowBlank'] = "false";
		$this->matriz_validacion[13]['maxLength'] = 15;
		$this->matriz_validacion[13]['minLength'] = 0;
		$this->matriz_validacion[13]['SelectOnFocus'] = "false";
		$this->matriz_validacion[13]['vtype'] = "alphaLatino";
		$this->matriz_validacion[13]['dataType'] = "integer";
		$this->matriz_validacion[13]['width'] = "";
		$this->matriz_validacion[13]['grow'] = "";

		$this->matriz_validacion[14] = array();
		$this->matriz_validacion[14]['Columna'] = "id_activo_fijo";
		$this->matriz_validacion[14]['allowBlank'] = "false";
		$this->matriz_validacion[14]['maxLength'] = 15;
		$this->matriz_validacion[14]['minLength'] = 0;
		$this->matriz_validacion[14]['SelectOnFocus'] = "false";
		$this->matriz_validacion[14]['vtype'] = "alphaLatino";
		$this->matriz_validacion[14]['dataType'] = "integer";
		$this->matriz_validacion[14]['width'] = "";
		$this->matriz_validacion[14]['grow'] = "";

		$this->matriz_validacion[15] = array();
		$this->matriz_validacion[15]['Columna'] = "id_moneda";
		$this->matriz_validacion[15]['allowBlank'] = "false";
		$this->matriz_validacion[15]['maxLength'] = 15;
		$this->matriz_validacion[15]['minLength'] = 0;
		$this->matriz_validacion[15]['SelectOnFocus'] = "false";
		$this->matriz_validacion[15]['vtype'] = "alphaLatino";
		$this->matriz_validacion[15]['dataType'] = "integer";
		$this->matriz_validacion[15]['width'] = "";
		$this->matriz_validacion[15]['grow'] = "";
	}
	
	
	/*--------------------------------------- LISTA REPORTE DEPRECIACION ------------------------------*/
	/*----------------------------- Adicionado por Marcos A. Flores Valda -----------------------------*/
	function ListarDepreciacionRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEPRE_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion
				
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		
		$this->var->add_def_cols('codigo','varchar(100)');				
  		$this->var->add_def_cols('fecha_desde','date'); 
  		$this->var->add_def_cols('fecha_hasta','date'); 
  		$this->var->add_def_cols('vida_util','integer');
  		$this->var->add_def_cols('monto_actualiz_ant','numeric(18,2)'); 
  		$this->var->add_def_cols('monto_actualiz','numeric(18,2)'); 
  		$this->var->add_def_cols('monto_actualiz_ant_2','numeric(18,2)');
  		$this->var->add_def_cols('depreciacion_acum_ant','numeric(10,2)');
  		$this->var->add_def_cols('dep_acum_actualiz','numeric(18,2)');
  		$this->var->add_def_cols('vida_util_2','integer');
  		$this->var->add_def_cols('depreciacion','numeric(10,2)');
  		$this->var->add_def_cols('depreciacion_acum','numeric(10,2)');
  		$this->var->add_def_cols('monto_vigente_ant','numeric(10,2)');
  		$this->var->add_def_cols('monto_vigente','numeric(10,2)');  		
  		$this->var->add_def_cols('tipo_cambio_ini','numeric(10,7)');
		$this->var->add_def_cols('tipo_cambio_fin','numeric(10,7)');
		$this->var->add_def_cols('id_grupo_depreciacion','integer');  
		$this->var->add_def_cols('ano_fin','numeric(4,0)');
		$this->var->add_def_cols('mes_fin','numeric(2,0)');		
		$this->var->add_def_cols('nombre_depto','varchar(200)');   
  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;		
		return $res;
	}
	
	/*--------------------------------------- CABECERA REPORTE DEPRECIACION ------------------------------*/
	
	/*------------------------------- LISTA REPORTE DEPRECIACION DETALLE ------------------------------*/
	/*----------------------------- Adicionado por Marcos A. Flores Valda -----------------------------*/

	function Cabecera_rep_det_dep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo_det,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_detalle_depreciacion';
		$this->codigo_procedimiento = "'AF_RDD_CABECERA'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($id_activo_fijo_det == '',"'%'","'$id_activo_fijo_det'"));//id_activo_fijo
		$this->var->add_param($func->iif($fecha_desde == '',"'%'","'$fecha_desde'"));//fecha_desde
		$this->var->add_param($func->iif($fecha_hasta == '',"'%'","'$fecha_hasta'"));//fecha_hasta
		
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('descripcion_larga','varchar');
		$this->var->add_def_cols('monto_compra','numeric');
		$this->var->add_def_cols('vida_util_original','integer');
		$this->var->add_def_cols('fecha_inidep','date');
  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;exit;
						
		return $res;
	}
	
	/*--------------------------------------- CUERPO REPORTE DEPRECIACION DETALLE ------------------------------*/
	
	function Cuerpo_rep_det_dep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_detalle_depreciacion';
		$this->codigo_procedimiento = "'AF_RDD_CUERPO'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($id_activo_fijo == '',"'%'","'$id_activo_fijo'"));//id_activo_fijo
		$this->var->add_param($func->iif($fecha_desde == '',"'%'","'$fecha_desde'"));//fecha_desde
		$this->var->add_param($func->iif($fecha_hasta == '',"'%'","'$fecha_hasta'"));//fecha_hasta
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		/*$this->var->add_def_cols('fecha','text');
		 $this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualiz_valor','numeric'); //
		$this->var->add_def_cols('valor_total','numeric');
		$this->var->add_def_cols('dep_acum_inicial','numeric');
		$this->var->add_def_cols('actualiz_dep','numeric');  	//
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('dep_mensual','numeric'); //
		$this->var->add_def_cols('depreciacion_acum','numeric');
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('factor_actualiz','numeric');
		$this->var->add_def_cols('id_activo_fijo','integer');*/
		//modificado 16/05/2014
		$this->var->add_def_cols('fecha','text');
		$this->var->add_def_cols('valor_contable','numeric');
		$this->var->add_def_cols('actualizacion','numeric'); //
		$this->var->add_def_cols('valor_total','numeric'); //
		$this->var->add_def_cols('depreciacion_acumulada_inicial','numeric');
		$this->var->add_def_cols('actualizacion_depreciacion','numeric');
		$this->var->add_def_cols('deprec_acumulada_actualizada','numeric');  	//
		$this->var->add_def_cols('depreciacion_periodo','numeric');
		$this->var->add_def_cols('depreciacion_acumulada','numeric'); //
		$this->var->add_def_cols('valor_neto','numeric');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('tipo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('id_activo_fijo','integer');
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		/*echo 'cons: '.$this->query;
		 exit;*/
			
		return $res;
	}
	
	/*------------------------------- SUMA DATOS EN DEPRECIACION DETALLE ------------------------------*/
	/*----------------------------- Adicionado por Marcos A. Flores Valda -----------------------------*/
	function SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_activo_fijo,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_rep_detalle_depreciacion';
		$this->codigo_procedimiento = "'AF_SUMAS_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($id_activo_fijo == '',"'%'","'$id_activo_fijo'"));//id_activo_fijo
		$this->var->add_param($func->iif($fecha_desde == '',"'%'","'$fecha_desde'"));//fecha_desde
		$this->var->add_param($func->iif($fecha_hasta == '',"'%'","'$fecha_hasta'"));//fecha_hasta
				
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		$this->var->add_def_cols('suma_act_valor','numeric');
		$this->var->add_def_cols('suma_act_dep','numeric');		
		$this->var->add_def_cols('suma_dep_mensual','numeric');
  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;	
		
		return $res;
	}
	
	/*--------------------------------------- FIN REPORTE DEPRECIACION DETALLE ------------------------------*/
	
	
	//añadido 02/05/2014
	
	//depreciacion contabilizado
	
	function ContarDepreciacion2Contabilizado($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEP_CONTA_COUNT'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
	
	function ListarDepreciacion2Contabilizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEP_CONTA_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_grupo_depreciacion','integer');
		$this->var->add_def_cols('anio_fin','numeric');
		$this->var->add_def_cols('mes_fin_deprec','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('usuario_reg','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('id_grupo_proceso','integer');
		$this->var->add_def_cols('proyecto','varchar');
	
	
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		//echo $this->query;exit;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ActionPDFActivoFijoHistorialDepreciaciones
	 * Propósito:				Genear un reporte historico de las depreciaciones dado un activo fijo
	 * Autor:					Elmer Velasquez
	 * Fecha creación:			22/04/2014
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @return unknown
	 */
	function ActionPDFActivoFijoHistorialDepreciaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_taf_depreciacion_consultas';
		$this->codigo_procedimiento = "'AF_DEP_DETAF_SEL'";
	
		$func = new cls_funciones();//Instancia de las funciones generales
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
	
		//Carga los parámetros del filtro
		$this->var->cant = $cant;
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
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('fecha_desde','date');
		$this->var->add_def_cols('fecha_hasta','date');
		$this->var->add_def_cols('vida_util','integer');
		$this->var->add_def_cols('monto_actualiz_ant','numeric');
		$this->var->add_def_cols('monto_actual','numeric');
		$this->var->add_def_cols('depreciacion_acum_ant','numeric');
		$this->var->add_def_cols('dep_acum_actualiz','numeric');
		$this->var->add_def_cols('depreciacion','numeric');
		$this->var->add_def_cols('depreciacion_acumulada','numeric');
		$this->var->add_def_cols('monto_anterior','numeric');
		$this->var->add_def_cols('monto_vigente','numeric');
		$this->var->add_def_cols('tpo_cambio_ini','numeric');
		$this->var->add_def_cols('tipo_cambio_fin','numeric');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('proyecto','varchar');
		$this->var->add_def_cols('tipo_activo','text');
		$this->var->add_def_cols('desc_proceso','text');
		$this->var->add_def_cols('id_grupo_depreciacion','integer');+
		$this->var->add_def_cols('id_activo_fijo','integer');
		$this->var->add_def_cols('id_tipo_activo','integer');
		$this->var->add_def_cols('id_depreciacion','integer');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	// fin 02/05/2014
}?>
