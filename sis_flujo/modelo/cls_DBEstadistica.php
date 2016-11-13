<?php
/**
 * Nombre de la clase:	cls_DBEstadistica.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_accion
 * Autor:				Silvia Ximena Ortiz Fernández
 * Fecha creación:		2010-12-27 15:36:51
 */

 
/*
* Se deben poner en comentario las funcion de selección
* No se ha realizado ningún cambio sobre esta clase.
*
* */

class cls_DBEstadistica
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
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasExternasGlob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESEXTGLOB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('total_recibidas','bigint');
		$this->var->add_def_cols('total_recepcionadas','bigint');
		$this->var->add_def_cols('total_finalizadas','bigint');
		$this->var->add_def_cols('total_finalizadas_respaldo','bigint');
		$this->var->add_def_cols('total_finalizadas_sin_respaldo','bigint');
		$this->var->add_def_cols('total_finalizadas_plazo','bigint');
		$this->var->add_def_cols('total_finalizadas_no_plazo','bigint');
		$this->var->add_def_cols('total_finalizadas_alta','bigint');
		$this->var->add_def_cols('total_finalizadas_media','bigint');
		$this->var->add_def_cols('total_finalizadas_baja','bigint');
		$this->var->add_def_cols('promedio_retraso_finalizadas','numeric');
		$this->var->add_def_cols('total_no_finalizadas','bigint');
		$this->var->add_def_cols('total_no_finalizadas_alta','bigint');
		$this->var->add_def_cols('total_no_finalizadas_media','bigint');
		$this->var->add_def_cols('total_no_finalizadas_baja','bigint');
		$this->var->add_def_cols('promedio_retraso_no_finalizadas','numeric');
		$this->var->add_def_cols('promedio_retraso_total','numeric');
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}	
	
	/**
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasExternasDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESEXTDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('numero','varchar');//25
		$this->var->add_def_cols('referencia','text');//25
		$this->var->add_def_cols('origen','varchar');//30
		$this->var->add_def_cols('empleado','text');//30
		$this->var->add_def_cols('nivel_prioridad','varchar');//15
		$this->var->add_def_cols('fecha_reg','text');//20
		$this->var->add_def_cols('estado','varchar');//20
		$this->var->add_def_cols('fecha_destino','text');//15
		$this->var->add_def_cols('fecha_max_res','text');//15
		$this->var->add_def_cols('fecha_fin','text');//15
		$this->var->add_def_cols('dias_retraso','integer');//15
		$this->var->add_def_cols('respuestas','varchar');//50
			

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}	
	
	/**
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasEnviadasGlob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESENVGLOB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_unidad','varchar');//25
		$this->var->add_def_cols('tipo_correspondencia','varchar');//30
		$this->var->add_def_cols('codigo_documento','varchar');//30
		$this->var->add_def_cols('nombre_documento','varchar');//15
		$this->var->add_def_cols('total_emitida','bigint');//20
		$this->var->add_def_cols('total_borrador','bigint');//20
		$this->var->add_def_cols('total_enviado','bigint');//20
		$this->var->add_def_cols('total_anulado','bigint');//20
		$this->var->add_def_cols('total_con_archivo','bigint');//20
		$this->var->add_def_cols('total_sin_archivo','bigint');//20
		$this->var->add_def_cols('total_asociados','bigint');//20
		$this->var->add_def_cols('promedio_retraso_envio','numeric');//20
					

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}	
	
	/**
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasEnviadasDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESENVDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('empleado','text');//30
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo_correspondencia','varchar');//25
		$this->var->add_def_cols('total_emitida','bigint');//20
		$this->var->add_def_cols('total_borrador','bigint');//20
		$this->var->add_def_cols('total_enviado','bigint');//20
		$this->var->add_def_cols('total_anulado','bigint');//20
		$this->var->add_def_cols('total_con_archivo','bigint');//20
		$this->var->add_def_cols('total_sin_archivo','bigint');//20
		$this->var->add_def_cols('total_asociados','bigint');//20
		$this->var->add_def_cols('promedio_retraso_envio','numeric');//20
					

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}

	/**
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasRecibidasGlob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESRECGLOB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('nombre_unidad','varchar');//30
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total_recibido','bigint');//20
		$this->var->add_def_cols('total_no_recepcionado','bigint');//20
		$this->var->add_def_cols('total_recepcionado','bigint');//20
		$this->var->add_def_cols('total_archivado','bigint');//20
		$this->var->add_def_cols('promedio_dias_recepcion','numeric');//20
		$this->var->add_def_cols('promedio_dias_arhivo','numeric');//20
					

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ListarAccion
	 * Propósito:				Desplegar los registros de tfl_accion
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2010-12-27 15:36:51
	 */
	
	function ListarEstadisticasRecibidasDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estadistica_sel';
		$this->codigo_procedimiento = "'FL_ESRECDET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_def_cols('empleado','text');//30
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('total_recibido','bigint');//20
		$this->var->add_def_cols('total_no_recepcionado','bigint');//20
		$this->var->add_def_cols('total_recepcionado','bigint');//20
		$this->var->add_def_cols('total_archivado','bigint');//20
		$this->var->add_def_cols('promedio_dias_recepcion','numeric');//20
		$this->var->add_def_cols('promedio_dias_arhivo','numeric');//20
					

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit();*/
		return $res;
	}
	
}?>
