<?php
/**
 * Nombre de la clase:	cls_DBLugar.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsg_tsg_lugar
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 16:40:30
 */

class cls_DBLugar
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
	 * Nombre de la función:	ListarLugar
	 * Propósito:				Desplegar los registros de tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_sel';
		$this->codigo_procedimiento = "'SG_LUGARR_SEL'";

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
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('fk_id_lugar','int4');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('ubicacion','text');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('observacion','text');
		$this->var->add_def_cols('sw_municipio','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*	    echo $this->query;
	    exit();*/

		return $res;
	}
	
	function ListarLugarArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_arb_sel';
		$this->codigo_procedimiento = "'SG_LUGARA_SEL'";

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
		$this->var->add_param("$raiz");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('fk_id_lugar','int4');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('ubicacion','text');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('observacion','text');
		$this->var->add_def_cols('sw_municipio','varchar');
		$this->var->add_def_cols('nombre_nivel','text');		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;

		return $res;
	}
	
	
	function ListarLugarRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_arb_sel';
		$this->codigo_procedimiento = "'SG_LUGARR_SEL'";

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
		$this->var->add_param("$raiz");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('fk_id_lugar','int4');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('ubicacion','text');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('observacion','text');
		$this->var->add_def_cols('sw_municipio','varchar');
		$this->var->add_def_cols('nombre_nivel','text');		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		

		return $res;
	}
	
	function ListarLugarHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_arb_sel';
		$this->codigo_procedimiento = "'SG_LUGARH_SEL'";

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
		$this->var->add_param("$raiz");
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('fk_id_lugar','int4');
		$this->var->add_def_cols('desc_lugar','varchar');
		$this->var->add_def_cols('nivel','int4');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('ubicacion','text');
		$this->var->add_def_cols('telefono1','varchar');
		$this->var->add_def_cols('telefono2','varchar');
		$this->var->add_def_cols('fax','varchar');
		$this->var->add_def_cols('observacion','text');
		$this->var->add_def_cols('sw_municipio','varchar');
		$this->var->add_def_cols('nombre_nivel','text');		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarLugar
	 * Propósito:				Contar los registros de tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_sel';
		$this->codigo_procedimiento = "'SG_LUGARR_COUNT'";

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
	function ListarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_sel';
		$this->codigo_procedimiento = "'SG_LUGMUN_SEL'";

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
		$this->var->add_def_cols('id_lugar','int4');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('codigo','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarLugar
	 * Propósito:				Contar los registros de tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function ContarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_sel';
		$this->codigo_procedimiento = "'SG_LUGMUN_COUNT'";

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
	 * Nombre de la función:	InsertarLugar
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municipio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_iud';
		$this->codigo_procedimiento = "'SG_LUGARR_INS'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($fk_id_lugar);
		$this->var->add_param($nivel);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$ubicacion'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$fax'");
		$this->var->add_param("'$observacion'");
		$this->var->add_param("'$sw_municipio'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
		
	}
	
	
	function DropLugarHoja($id_lugar,$fk_id_lugar,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_iud';
		$this->codigo_procedimiento = "'SG_DROHOJ_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_lugar);
		$this->var->add_param($fk_id_lugar);
		$this->var->add_param("NULL");//nivel
		$this->var->add_param("NULL");//codigo
		$this->var->add_param("NULL");//nombre
		$this->var->add_param("NULL");//ubicacion
		$this->var->add_param("NULL");//telefono1
		$this->var->add_param("NULL");//telefono2
		$this->var->add_param("NULL");//fax
		$this->var->add_param("NULL");//observacion
		$this->var->add_param("NULL");//sw_municipio

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
		
	}
	
	/**
	 * Nombre de la función:	ModificarLugar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municipio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_iud';
		$this->codigo_procedimiento = "'SG_LUGARR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_lugar);
		$this->var->add_param($fk_id_lugar);
		$this->var->add_param($nivel);
		$this->var->add_param("'$codigo'");
		$this->var->add_param("'$nombre'");
		$this->var->add_param("'$ubicacion'");
		$this->var->add_param("'$telefono1'");
		$this->var->add_param("'$telefono2'");
		$this->var->add_param("'$fax'");
		$this->var->add_param("'$observacion'");
		$this->var->add_param("'$sw_municipio'");

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
	 * Nombre de la función:	EliminarLugar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function EliminarLugar($id_lugar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tsg_lugar_iud';
		$this->codigo_procedimiento = "'SG_LUGARR_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_lugar);
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
	 * Nombre de la función:	ValidarLugar
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tsg_lugar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 16:40:30
	 */
	function ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
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
				//Validar id_lugar - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_lugar");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar", $id_lugar))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar fk_id_lugar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fk_id_lugar");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "fk_id_lugar", $fk_id_lugar))
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

			//Validar codigo - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo", $codigo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar nombre - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nombre");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "nombre", $nombre))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar ubicacion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("ubicacion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "ubicacion", $ubicacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono1 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono1");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono1", $telefono1))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar telefono2 - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("telefono2");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "telefono2", $telefono2))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fax - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fax");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "fax", $fax))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observacion - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observacion");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observacion", $observacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_lugar - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_lugar");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_lugar", $id_lugar))
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