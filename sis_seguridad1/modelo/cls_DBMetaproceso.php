<?php
/**
 * Nombre de la clase:	cls_DBMetaproceso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_metaproceso
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-26 16:42:27
 */

class cls_DBMetaproceso{
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
	 * Nombre de la función:	ListarMetaproceso
	 * Propósito:				Desplegar los registros de tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_sel';
		$this->codigo_procedimiento = "'SG_METAPR_SEL'";

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
		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('desc_metaproceso','text');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('nombre_achivo','varchar');
		$this->var->add_def_cols('ruta_archivo','text');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('visible','varchar');
		$this->var->add_def_cols('habilitar_log','varchar');
		$this->var->add_def_cols('orden_logico','int4');
		$this->var->add_def_cols('icono','varchar');
		$this->var->add_def_cols('nombre_tabla','varchar');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('codigo_base','varchar');
		$this->var->add_def_cols('tipo_vista','varchar');
		$this->var->add_def_cols('con_ep','varchar');
		$this->var->add_def_cols('con_interfaz','varchar');
		$this->var->add_def_cols('num_datos_hijo','int4');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ListarMetaproceso
	 * Propósito:				Desplegar los registros de tsg_metaproceso en forma de arbol
	 * Autor:				    Rensi Arteaga Copari
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ListarMetaprocesoArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$nodo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_METARB_SEL'";

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
		$this->var->add_param("$nodo");//raiz
		$this->var->add_param("$id_rol");//rol

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('nombre_archivo','varchar');
		$this->var->add_def_cols('ruta_archivo','text');
		$this->var->add_def_cols('fecha_registro','date');
		$this->var->add_def_cols('hora_registro','time');
		$this->var->add_def_cols('fecha_ultima_modificacion','date');
		$this->var->add_def_cols('hora_ultima_modificacion','time');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('visible','varchar');
		$this->var->add_def_cols('habilitar_log','varchar');
		$this->var->add_def_cols('orden_logico','int4');
		$this->var->add_def_cols('icono','varchar');
		$this->var->add_def_cols('nombre_tabla','varchar');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('codigo_base','varchar');
		$this->var->add_def_cols('tipo_vista','varchar');
		$this->var->add_def_cols('con_ep','varchar');
		$this->var->add_def_cols('con_interfaz','varchar');
		$this->var->add_def_cols('num_datos_hijo','int4');

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
	 * Nombre de la función:	ContarMetaproceso
	 * Propósito:				Contar los registros de tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_sel';
		$this->codigo_procedimiento = "'SG_METAPR_COUNT'";

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
	 * Nombre de la función:	InsertarMetaproceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function InsertarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_iud';
		$this->codigo_procedimiento = "'SG_METAPR_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_subsistema);
		$this->var->add_param($fk_id_metaproceso);
		$this->var->add_param($nivel);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_achivo'");
		$this->var->add_param("'$ruta_archivo'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param($orden_logico);
		$this->var->add_param("'$icono'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$codigo_base'");
		$this->var->add_param("'$tipo_vista'");
		$this->var->add_param("'$con_ep'");
		$this->var->add_param("'$con_interfaz'");
		$this->var->add_param($num_datos_hijo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		echo $this->query;
		exit();
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarMetaproceso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ModificarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_iud';
		$this->codigo_procedimiento = "'SG_METAPR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_metaproceso);
		$this->var->add_param($id_subsistema);
		$this->var->add_param($fk_id_metaproceso);
		$this->var->add_param($nivel);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_achivo'");
		$this->var->add_param("'$ruta_archivo'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param($orden_logico);
		$this->var->add_param("'$icono'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$codigo_base'");
		$this->var->add_param("'$tipo_vista'");
		$this->var->add_param("'$con_ep'");
		$this->var->add_param("'$con_interfaz'");
		$this->var->add_param($num_datos_hijo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarMetaproceso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function EliminarMetaproceso($id_metaproceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_iud';
		$this->codigo_procedimiento = "'SG_METAPR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_metaproceso);
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


	/*********************************************************/


	function ListarMetaprocesoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_METRAI_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad




		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');
		$this->var->add_def_cols('checked','boolean');
		$this->var->add_def_cols('color','boolean');
		$this->var->add_def_cols('icono','varchar');
		$this->var->add_def_cols('tipo_vista','varchar');

		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//	exit;

		return $res;
	}

	function ListarMetaprocesoRaizAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_MERIAS_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad




		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');

		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}



	function ListarMetaprocesoRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{//echo $cant." ".$puntero." ".$sortcol. "  ".$sortdir." ".$criterio_filtro;
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_METRAM_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad




		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');
		$this->var->add_def_cols('checked','boolean');
		$this->var->add_def_cols('color','boolean');
		$this->var->add_def_cols('tipo_vista','varchar');
		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			//echo $this->query;
				//exit;
		return $res;
	}
	function ListarMetaprocesoRamaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_MERAAS_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad

	


		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');

		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}


	function ListarMetaprocesoHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_METHOJ_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		/*$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_composicion_tuc','int4');
		$this->var->add_def_cols('cantidad','int4');
		$this->var->add_def_cols('opcional','varchar');
		$this->var->add_def_cols('id_tuc_padre','int4');
		$this->var->add_def_cols('considerar_repeticion','varchar');*/


		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');
		$this->var->add_def_cols('checked','boolean');
		$this->var->add_def_cols('color','boolean');
		$this->var->add_def_cols('tipo_vista','varchar');
		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function ListarMetaprocesoHojaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{

		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_MEHOAS_SEL'";

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
		$this->var->add_param("$id_rol");//id_actividad



		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('fk_id_metaproceso','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_subsistema','int4');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('nombre_achivo','varchar');

		//Ejecuta la función de consulta


		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**********************************************************************************************/



	/**
	 * Nombre de la función:	InsertarMetaproceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function InsertarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_arb_iud';
		$this->codigo_procedimiento = "'SG_METARB_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_subsistema);
		$this->var->add_param($fk_id_metaproceso);
		$this->var->add_param($nivel);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_achivo'");
		$this->var->add_param("'$ruta_archivo'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param($orden_logico);
		$this->var->add_param("'$icono'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$codigo_base'");
		$this->var->add_param("'$tipo_vista'");
		$this->var->add_param("'$con_ep'");
		$this->var->add_param("'$con_interfaz'");
		$this->var->add_param($num_datos_hijo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();
	 
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarMetaprocesoArb
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ModificarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_arb_iud';
		$this->codigo_procedimiento = "'SG_METARB_UPD'";
		
		/*echo "nombre archivo: ". $nombre_achivo;
		exit;*/

		//Instancia la clase midlle para la ejecución &de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_metaproceso);
		$this->var->add_param($id_subsistema);
		$this->var->add_param($fk_id_metaproceso);
		$this->var->add_param($nivel);
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'$nombre_achivo'");
		$this->var->add_param("'$ruta_archivo'");
		$this->var->add_param("'$fecha_registro'");
		$this->var->add_param("'$hora_registro'");
		$this->var->add_param("'$fecha_ultima_modificacion'");
		$this->var->add_param("'$hora_ultima_modificacion'");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$visible'");
		$this->var->add_param("'$habilitar_log'");
		$this->var->add_param($orden_logico);
		$this->var->add_param("'$icono'");
		$this->var->add_param("'$nombre_tabla'");
		$this->var->add_param("'$prefijo'");
		$this->var->add_param("'$codigo_base'");
		$this->var->add_param("'$tipo_vista'");
		$this->var->add_param("'$con_ep'");
		$this->var->add_param("'$con_interfaz'");
		$this->var->add_param($num_datos_hijo);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		echo $this->query;
		exit();
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarMetaprocesoArb
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function EliminarMetaprocesoArb($id_metaproceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_arb_iud';
		$this->codigo_procedimiento = "'SG_METARB_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_metaproceso);
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

	/*-*--------------------------------------------------------------------------------------------------*/
	//   PROCEDIMIENTOS DB - METAPROCESO DB
	/**
	 * Nombre de la función:	ListarMetaprocesoDB_arb
	 * Propósito:				Permite consultar los nodos hijos (tipo procedimiento db) de un metaprocedo
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ListarMetaprocesoDB_arb($sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{

		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_rama_sel';
		$this->codigo_procedimiento = "'SG_PROCDB_ARB_SEL'";
		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
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
		$this->var->add_param("$id_rol");//raiz
		$this->var->add_def_cols('id_metaproceso_db','int4');
		$this->var->add_def_cols('codigo_procedimiento','varchar');
		$this->var->add_def_cols('id_metaproceso','int4');
		$this->var->add_def_cols('nombre_funcion','varchar');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('checked','boolean');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
//		echo $this->query;
//		exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarMetaproceso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function InsertarMetaprocesoDBArb($id_metaproceso,$codigo_procedimiento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_arb_iud';
		$this->codigo_procedimiento = "'SG_METADBARB_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_metaproceso);
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'$codigo_procedimiento'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");//fecha_registro
		$this->var->add_param("NULL");//hora registro
		$this->var->add_param("NULL");//fecha modificacion
		$this->var->add_param("NULL");//hora_ultima modificacion
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("NULL");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
		$this->var->add_param("'NULL'");
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
	 * Nombre de la función:	EliminarMetaproceso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function EliminarMetaprocesoDB($id_metaproceso_db)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_metaproceso_arb_iud';
		$this->codigo_procedimiento = "'SG_METADBARB_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_metaproceso_db); //lo enviamos en lugar de id_metaproceso para no volver a declarar la variable
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
	 * Nombre de la función:	ValidarMetaproceso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_metaproceso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-26 16:42:27
	 */
	function ValidarMetaproceso($operacion_sql,$id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
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
				//Validar id_metaproceso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_metaproceso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_metaproceso", $id_metaproceso))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_subsistema - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fk_id_metaproceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fk_id_metaproceso");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "fk_id_metaproceso", $fk_id_metaproceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nivel - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nivel");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nivel", $nivel))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_procedimiento - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_procedimiento");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_procedimiento", $codigo_procedimiento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_achivo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_achivo");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_achivo", $nombre_achivo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar ruta_archivo - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ruta_archivo");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ruta_archivo", $ruta_archivo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_registro - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_registro");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_registro", $fecha_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_registro - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_registro");
			$tipo_dato->set_MaxLength(8);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_registro", $hora_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_ultima_modificacion - tipo timestamp
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_ultima_modificacion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fecha_ultima_modificacion", $fecha_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar hora_ultima_modificacion - tipo time
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("hora_ultima_modificacion");
			$tipo_dato->set_MaxLength(8);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoTime(), "hora_ultima_modificacion", $hora_ultima_modificacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar visible - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("visible");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "visible", $visible))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar habilitar_log - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("habilitar_log");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "habilitar_log", $habilitar_log))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar orden_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("orden_logico");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "orden_logico", $orden_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar icono - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("icono");
			$tipo_dato->set_MaxLength(200);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "icono", $icono))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre_tabla - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre_tabla");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre_tabla", $nombre_tabla))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar prefijo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("prefijo");
			$tipo_dato->set_MaxLength(5);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "prefijo", $prefijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_base - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_base");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_base", $codigo_base))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar tipo_vista - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_vista");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_vista", $tipo_vista))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar con_ep - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("con_ep");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "con_ep", $con_ep))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar con_interfaz - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("con_interfaz");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "con_interfaz", $con_interfaz))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar num_datos_hijo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("num_datos_hijo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "num_datos_hijo", $num_datos_hijo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validar visible
			$check = array ("si","no");
			if(!in_array($visible,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'visible': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar habilitar_log
			$check = array ("si","no");
			if(!in_array($habilitar_log,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'habilitar_log': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar tipo_vista
			$check = array ("padre","hijo","padre_hijo","reporte","arbol","ninguno");
			if(!in_array($tipo_vista,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'tipo_vista': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar con_ep
			$check = array ("si","no");
			if(!in_array($con_ep,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'con_ep': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validar con_interfaz
			$check = array ("si","no");
			if(!in_array($con_interfaz,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'con_interfaz': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarMetaproceso";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_metaproceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_metaproceso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_metaproceso", $id_metaproceso))
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