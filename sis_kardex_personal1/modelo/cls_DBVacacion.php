<?php
/**
 * Nombre de la clase:	cls_DBVacacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tkp_tkp_vacacion
 * Autor:				(autogenerado)
 * Fecha creación:		2010-08-17 09:25:59
 */

 
class cls_DBVacacion
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
	 * Nombre de la función:	ListarVacacion
	 * Propósito:				Desplegar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ListarVacacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_sel';
		$this->codigo_procedimiento = "'KP_VACACI_SEL'";

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
		$this->var->add_def_cols('id_vacacion','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('desc_gestion','numeric');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_categoria_vacacion','int4');
		$this->var->add_def_cols('desc_categoria_vacacion','varchar');
		$this->var->add_def_cols('total_dias','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarVacacion
	 * Propósito:				Contar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ContarVacacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_sel';
		$this->codigo_procedimiento = "'KP_VACACI_COUNT'";

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
	 * Nombre de la función:	ListarSolicitud_Licencia
	 * Propósito:				Desplegar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ListarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_sel';
		$this->codigo_procedimiento = "'KP_SOLLIC_SEL'";

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
		$this->var->add_def_cols('id_vacacion','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('desc_gestion','numeric');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('total_dias','numeric');
		$this->var->add_def_cols('id_categoria_vacacion','int4');
		$this->var->add_def_cols('desc_categoria_vacacion','varchar');
		$this->var->add_def_cols('dias_vacacion','int4');
		$this->var->add_def_cols('dias_tomados','numeric');
        $this->var->add_def_cols('fecha_reg','date');
        $this->var->add_def_cols('estado_reg','varchar');
        $this->var->add_def_cols('dias_disponibles','numeric');
        $this->var->add_def_cols('dias_acumulados','numeric');
        $this->var->add_def_cols('dias_adelantados','numeric');
        $this->var->add_def_cols('calculo','numeric');
        $this->var->add_def_cols('dias_compensacion','numeric');
        $this->var->add_def_cols('tipo_contrato','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudLicencia
	 * Propósito:				Contar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ContarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_sel';
		$this->codigo_procedimiento = "'KP_SOLLIC_COUNT'";

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
	 * Nombre de la función:	ListarSolicitudLicenciaDet
	 * Propósito:				Desplegar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ListarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_SEL'";

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
		$this->var->add_def_cols('id_horario','int4');
		$this->var->add_def_cols('id_tipo_horario','int4');
		$this->var->add_def_cols('nombre_tipo_horario','varchar');
		$this->var->add_def_cols('id_vacacion','int4');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('tipo_periodo','varchar');
		$this->var->add_def_cols('horas_por_dia','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('id_empleado_aprobacion','int4');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('repite_anualmente','varchar');
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudLicenciaDet
	 * Propósito:				Contar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ContarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_COUNT'";

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
	 * Nombre de la función:	ListarSolicitudLicenciaDet
	 * Propósito:				Desplegar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ListarAprobarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_APRO_SOLLIC_DET_SEL'";

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
		$this->var->add_def_cols('id_horario','int4');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('id_tipo_horario','int4');
		$this->var->add_def_cols('id_vacacion','int4');
		$this->var->add_def_cols('id_empleado_aprobacion','int4');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('tipo_periodo','varchar');
		$this->var->add_def_cols('horas_por_dia','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('num_solicitud','text');
        //Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudLicenciaDet
	 * Propósito:				Contar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ContarAprobarSolicitudLicenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_APRO_SOLLIC_DET_COUNT'";

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
	 * Nombre de la función:	ListarSolicitudLicenciaDet
	 * Propósito:				Desplegar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ListarAprobarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_APRO_SOLLIC_SEL'";

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
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('id_tipo_horario','int4');
		$this->var->add_def_cols('nombre_tipo_horario','varchar');
		$this->var->add_def_cols('id_vacacion','int4');
		$this->var->add_def_cols('id_empleado_aprobacion','int4');
		$this->var->add_def_cols('num_solicitud','text');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('tipo_contrato','varchar');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSolicitudLicencia
	 * Propósito:				Contar los registros de tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ContarAprobarSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_sel';
		$this->codigo_procedimiento = "'KP_APRO_SOLLIC_COUNT'";

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
	 * Nombre de la función:	InsertarSolicitudLicencia
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarSolicitudLicencia($id_vacacion,$id_gestion,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empleado);
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
	 * Nombre de la función:	ModificarSolicitudLicencia
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ModificarSolicitudLicencia($id_vacacion,$id_gestion,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_vacacion);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empleado);
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
	 * Nombre de la función:	EliminarSolicitudLicencia
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function EliminarSolicitudLicencia($id_vacacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_vacacion);
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
	 * Nombre de la función:	InsertarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
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
	 * Nombre de la función:	ModificarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ModificarSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
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
	 * Nombre de la función:	EliminarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function EliminarSolicitudLicenciaDet($id_horario)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
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
	 * Nombre de la función:	InsertarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarAdelantaLicencia($id_vacacion,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_ADE_LIC_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
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
	 * Nombre de la función:	InsertarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarReformularSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$num_solicitud,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_REF_SOLLIC_DET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("'$num_solicitud'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ModificarReformularSolicitudLicenciaDet($id_horario,$id_tipo_horario,$id_vacacion,$num_solicitud,$fecha_inicio,$fecha_fin,$tipo_periodo,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_SOLLIC_DET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
		$this->var->add_param($id_tipo_horario);
		$this->var->add_param($id_vacacion);
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_fin'");
        $this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_periodo'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'reformula'");
		$this->var->add_param("'$num_solicitud'");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarReformularSolicitudLicenciaDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function EliminarReformularSolicitudLicenciaDet($id_horario,$num_solicitud)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_horario_iud';
		$this->codigo_procedimiento = "'KP_REF_SOLLIC_DET_DEL'";
         
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_horario);
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
		$this->var->add_param("'$num_solicitud'");
		 //  echo "Cls1".$id_horario;
		//echo "<br>".$num_solicitud;
		//exit;
		//Ejecuta la función
		$res = $this->var->exec_non_query();
      
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "Cls2".$id_horario;
		//echo "<br>".$num_solicitud;
        //echo $this->query;
      //  exit;
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarVacacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarVacacion($id_vacacion,$id_gestion,$id_empleado,$id_categoria_vacacion,$total_dias)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_VACACI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria_vacacion);
		$this->var->add_param($total_dias);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarVacacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ModificarVacacion($id_vacacion,$id_gestion,$id_empleado,$id_categoria_vacacion,$total_dias)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_VACACI_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_vacacion);
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_categoria_vacacion);
		$this->var->add_param($total_dias);

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarVacacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function EliminarVacacion($id_vacacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_VACACI_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_vacacion);
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
	 * Nombre de la función:	InsertarSolicitudLicenciaG
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function InsertarSolicitudLicenciaG($id_vacacion,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_vacacion_iud';
		$this->codigo_procedimiento = "'KP_SOLLICG_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_empleado);
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
	 * Nombre de la función:	ValidarVacacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_vacacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2010-08-17 09:25:59
	 */
	function ValidarVacacion($operacion_sql,$id_vacacion,$id_gestion,$id_empleado,$id_categoria_vacacion,$total_dias)
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
				//Validar id_vacacion - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_vacacion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_vacacion", $id_vacacion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_gestion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_gestion", $id_gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_categoria_vacacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_categoria_vacacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_categoria_vacacion", $id_categoria_vacacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar total_dias - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("total_dias");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "total_dias", $total_dias))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_vacacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_vacacion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_vacacion", $id_vacacion))
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
	
	function RepSolicitudLicencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$id_vacacion,$id_tipo_horario,$id_emp_aprobador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_solicitud_licencia_rep';
		$this->codigo_procedimiento = "'KP_SOL_LIC'";

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
		$this->var->add_param($func->iif($id_empleado == '',"'%'","'$id_empleado'"));//id_empleado
		$this->var->add_param($func->iif($id_vacacion == '',"'%'","'$id_vacacion'"));//id_vacacion
		$this->var->add_param($func->iif($id_tipo_horario == '',"'%'","'$id_tipo_horario'"));//id_tipo_horario
		$this->var->add_param($func->iif($id_emp_aprobador == '',"'%'","'$id_emp_aprobador'"));//id_empleado_aprobador

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_empleado','varchar');
		$this->var->add_def_cols('solicitante','text');
		$this->var->add_def_cols('cargo','varchar');
		$this->var->add_def_cols('centro_r','varchar');
		$this->var->add_def_cols('localidad','varchar');	
		$this->var->add_def_cols('antiguedad_ant','integer');	
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('dias_disponibles','numeric');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
		$this->var->add_def_cols('horas_por_dia','numeric');
		$this->var->add_def_cols('num_solicitud','text');
		$this->var->add_def_cols('tipo_contrato','varchar');
		$this->var->add_def_cols('ini_contrato','date');
		$this->var->add_def_cols('dias_compensacion','numeric');
		$this->var->add_def_cols('antiguedad','interval');
		$this->var->add_def_cols('dias_acumulados','numeric');
		$this->var->add_def_cols('dias_tomados','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
			
		return $res;
	}
	
	function SumarHorasXDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empleado,$id_tipo_horario,$numero_sol,$id_vacacion,$id_emp_aprobador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_solicitud_licencia_suma';
		$this->codigo_procedimiento = "'KP_SUM_HORASXDIA'";

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
		$this->var->add_param($func->iif($id_empleado == '',"'%'","'$id_empleado'"));//id_empleado
		$this->var->add_param($func->iif($id_tipo_horario == '',"'%'","'$id_tipo_horario'"));//id_tipo_horario
		$this->var->add_param($func->iif($numero_sol == '',"'%'","'$numero_sol'"));//numero_solicitud
		$this->var->add_param($func->iif($id_vacacion == '',"'%'","'$id_vacacion'"));//id_vacacion
		$this->var->add_param($func->iif($id_emp_aprobador == '',"'%'","'$id_emp_aprobador'"));//id_emp_aprobador
						
		//Carga la definiciï¿½n de columnas con sus tipos de datos	
		$this->var->add_def_cols('suma_horas_x_dia','numeric');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_fin','date');
  				
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();		

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;	
		
		return $res;
	}
	
	function RepResSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_rep_res_solicitud';
		$this->codigo_procedimiento = "'KP_RES_SOL'";

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
		$this->var->add_def_cols('id_horario','integer');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('tipo_licencia','varchar');	
		$this->var->add_def_cols('fecha_inicio','text');	
		$this->var->add_def_cols('fecha_fin','text');
		$this->var->add_def_cols('tipo_periodo','varchar');
		$this->var->add_def_cols('horas_por_dia','numeric');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_reg','text');		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;		
	}

}?>