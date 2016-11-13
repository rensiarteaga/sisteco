<?php
/**
 * Nombre de la Clase:	cls_DBResumenHorarioMes
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tkp_parametro_cuenta_auxiliar
 * Autor:				Fernanda Prudencio Cardona
 * Fecha creación:		13-10-2010
 *
 */
class cls_DBResumenHorarioMes
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
	var $nombre_archivo = "cls_DBResumenHorarioMes.php";

	//Matriz de parámetros de validación de todas las columnas
	var $matriz_validacion = array();
	
	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct($decodificar)
	{
		//Carga los parámetro de validación de todas las columnas
		//$this->cargar_param_valid();
		
		//Carga en una variable interna la bandera del GET o POST
		$this->decodificar = $decodificar;
	}

	/**
	 * Nombre de la función:	ListarResumenHorarioMes
	 * Propósito:				Desplegar los registros de tkp_resumen_horario_mes en función de los parámetros del filtro
	 * Autor:					Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ListarResumenHorarioMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_sel';
		$this->codigo_procedimiento = "'KP_RESHORMES_SEL'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		//$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad
		$this->var->add_param("'$id_actividad'");//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_resumen_horario_mes','integer');
		$this->var->add_def_cols('id_empleado_planilla','integer');
		$this->var->add_def_cols('usuario_reg','integer');
		$this->var->add_def_cols('horas_disp','numeric');
		$this->var->add_def_cols('horas_normales','numeric');
		$this->var->add_def_cols('horas_extra','numeric');
		$this->var->add_def_cols('horas_nocturnas','numeric');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('parametrizado','integer');
		$this->var->add_def_cols('id_planilla','integer');
		$this->var->add_def_cols('horas_normales_efectivas','numeric');
		$this->var->add_def_cols('costo_horas_normales_efectivas','numeric');
		$this->var->add_def_cols('costo_horas_extra','numeric');
		$this->var->add_def_cols('costo_horas_nocturnas','numeric');
		$this->var->add_def_cols('costo_horas_disp','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarResumenHorarioMes
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ContarResumenHorarioMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_sel';
		$this->codigo_procedimiento = "'KP_RESHORMES_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	ListarEmpleadoPlanillaF
	 * Propósito:				Desplegar los registros de tkp_resumen_horario_mes en función de los parámetros del filtro
	 * Autor:					Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ListarEmpleadoPlanillaF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_sel';
		$this->codigo_procedimiento = "'KP_EMPPLAN_FAL'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_empleado_planilla','integer');
		$this->var->add_def_cols('id_empleado','integer');
		$this->var->add_def_cols('nombre_completo','text');
		$this->var->add_def_cols('id_planilla','integer');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarEmpleadoPlanillaF
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 *
	 */
	function ContarEmpleadoPlanillaF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_sel';
		$this->codigo_procedimiento = "'KP_EMPPLAN_FAL_COUNT'";

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
		$this->var->add_param($func->iif($id_financiador == '',"'%'",$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'",$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'",$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'",$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'",$id_actividad));//id_actividad

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
	 * Nombre de la función:	InsertarResumenHorarioMes
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 * Descripción:             
	
	 */
	function InsertarResumenHorarioMes($id_resumen_horario_mes,$id_empleado_planilla_f,$id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_RESHORMES_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param($id_empleado_planilla_f);
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
	 * Nombre de la función:	ModificarResumenHorarioMes
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function ModificarResumenHorarioMes($id_resumen_horario_mes,$id_empleado_planilla,$horas_disp,$horas_normales,$horas_extra,$horas_nocturnas,$costo_horas_normales,$costo_horas_extra,$costo_horas_nocturnas,$costo_horas_disp,$horas_normales_efectivas)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_RESHORMES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param($id_empleado_planilla);
		$this->var->add_param($horas_disp);
		$this->var->add_param($horas_normales);
		$this->var->add_param($horas_extra);
		$this->var->add_param($horas_nocturnas);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($costo_horas_normales);
		$this->var->add_param($costo_horas_extra);
		$this->var->add_param($costo_horas_nocturnas);
		$this->var->add_param($costo_horas_disp);
		$this->var->add_param($horas_normales_efectivas);
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarResumenHorarioMes
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function EliminarResumenHorarioMes($id_resumen_horario_mes)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_RESHORMES_DEL'";
      
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
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
	 * Nombre de la función:	CargaResumenMarcas
	 * Propósito:				Permite ejecutar la función de cargado del resumen de marcas
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function CargaResumenMarcas($id_resumen_horario_mes,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_CARGA_RESUMEN_MARCAS'";
      
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_desde'");
		$this->var->add_param("'$fecha_hasta'");
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
	 * Nombre de la función:	ValidaResumen
	 * Propósito:				Permite ejecutar la función de validación de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		11-11-2010
	 */
	function ValidaResumen($id_resumen_horario_mes,$horas_disp,$horas_normales,$horas_extra,$horas_nocturnas)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_VALIDA_RES'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param("NULL");
		$this->var->add_param($horas_disp);
		$this->var->add_param($horas_normales);
		$this->var->add_param($horas_extra);
		$this->var->add_param($horas_nocturnas);
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
	 * Nombre de la función:	ValidaResumenTodos
	 * Propósito:				Permite ejecutar la función de validación de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		11-11-2010
	 */
	function ValidaResumenTodos($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_VALIDA_TODOS_RES'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_planilla);
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
	 * Nombre de la función:	CorrigeResumen
	 * Propósito:				Permite ejecutar la función de correccion de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		11-11-2010
	 */
	function CorrigeResumen($id_resumen_horario_mes,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_CORRIG_RES'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param($tipo);
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
	 * Nombre de la función:	ProrrateaHoras
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 * Descripción:             
	
	 */
	function ProrrateaHoras($id_resumen_horario_mes,$id_empleado_planilla,$horas_normales,$horas_extra,$horas_disp,$horas_nocturnas)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_PRORRATEA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param($id_empleado_planilla);
		$this->var->add_param($horas_disp);
		$this->var->add_param($horas_normales);
		$this->var->add_param($horas_extra);
		$this->var->add_param($horas_nocturnas);
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
	 * Nombre de la función:	ProrrateaHorasTodos
	 * Propósito:				Permite ejecutar la función de validación de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		11-11-2010
	 */
	function ProrrateaHorasTodos($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_PRORRATEA_TODOS_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_planilla);
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
	 * Nombre de la función:	ProrrateaOtrosHoras
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tkp_costo_columna_valor
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 * Descripción:             
	
	 */
	function ProrrateaOtrosHoras($id_resumen_horario_mes,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tkp_resumen_horario_mes_iud';
		$this->codigo_procedimiento = "'KP_PRORRATEA_OTRO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_resumen_horario_mes);
		$this->var->add_param($tipo);
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
       //echo $this->query; exit;
		return $res;
	}
	/**
	 * Nombre de la función:	ValidarResumenHorarioMes
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tkp_resumen_horario_mes
	 * Autor:				    Fernanda Prudencio Cardona
	 * Fecha de creación:		13-10-2010
	 */
	function ValidarResumenHorarioMes($operacion_sql,$id_resumen_horario_mes,$id_empleado_planilla,$horas_disp,$horas_normales,$horas_extra,$horas_nocturnas)
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
				//Validar $id_resumen_horario_mes - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_resumen_horario_mes");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_resumen_horario_mes", $id_resumen_horario_mes))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
			
			
				
				//Validar $id_empleado_planilla - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_empleado_planilla");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado_planilla", $id_empleado_planilla))
				{
					$this->salida = $valid->salida;
					return false;
				}

			//Validar $horas_disp - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("horas_disp");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "horas_disp", $horas_disp))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validar $horas_normales - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("horas_normales");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "horas_normales", $horas_normales))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar $horas_extras - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("horas_extra");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "horas_extra", $horas_extra))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar $horas_nocturnas - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("horas_nocturnas");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank("true");
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "horas_nocturnas", $horas_nocturnas))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			
			$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_resumen_horario_mes");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_resumen_horario_mes", $id_resumen_horario_mes))
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
	
}
?>