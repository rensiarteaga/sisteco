<?php
/**
 * Nombre de la Clase:	cls_DBEstadoProceso.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_actualizacion
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		13/12/2010
 */
class cls_DBEstadoProceso
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
	 * Nombre de la función:	InsertarSistemadistribucion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function CambioEstadoProceso($m_id_proceso_facturacion_cobranza, $accion,  $m_id_estado_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_cambio_estado_proceso_pro';
		$this->codigo_procedimiento = "'CT_CAMBEST_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$m_id_proceso_facturacion_cobranza");
		$this->var->add_param("$m_id_estado_proceso");
		$this->var->add_param("'$accion'");
	 
	 	//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}/**
	 * Nombre de la función:	InsertarSistemadistribucion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function InsertarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_estado_proceso_iud';
		$this->codigo_procedimiento = "'CT_ESTPRO_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_facturacion_cobranza");
		$this->var->add_param("'$accion_anterior'");
		$this->var->add_param("'$accion_siguiente'");
		$this->var->add_param("$prioridad");
		$this->var->add_param("'$sw_dblink_anterior'");
		$this->var->add_param("'$sw_dblink_siguiente'");
		$this->var->add_param("'$nombre_estado'");
		 
		
		
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarAuxiliar
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ModificarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado)
	{
		 
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_estado_proceso_iud';
		$this->codigo_procedimiento = "'CT_ESTPRO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_estado_proceso");
		$this->var->add_param("$id_tipo_facturacion_cobranza");
		$this->var->add_param("'$accion_anterior'");
		$this->var->add_param("'$accion_siguiente'");
		$this->var->add_param("$prioridad");
		$this->var->add_param("'$sw_dblink_anterior'");
		$this->var->add_param("'$sw_dblink_siguiente'");
		$this->var->add_param("'$nombre_estado'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarAuxiliar
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_auxiliar
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function EliminarEstadoProceso($id_estado_proceso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_estado_proceso_iud';
		$this->codigo_procedimiento = "'CT_ESTPRO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_estado_proceso);
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
	 * Nombre de la función:	ListarEstadoProceso
	 * Propósito:				Desplegar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		
	 */
	function ListarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_estado_proceso_sel';
		$this->codigo_procedimiento = "'CB_ESTPRO_SEL'";

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
		$this->var->add_def_cols('id_estado_proceso','integer');
		$this->var->add_def_cols('id_tipo_facturacion_cobranza','integer');
		$this->var->add_def_cols('nombre_proceso','varchar');
		$this->var->add_def_cols('accion_anterior','text');
		$this->var->add_def_cols('accion_siguiente','text');
		$this->var->add_def_cols('prioridad','integer');
		$this->var->add_def_cols('sw_dblink_anterior','varchar');
		$this->var->add_def_cols('sw_dblink_siguiente','varchar');
		$this->var->add_def_cols('nombre_estado','varchar');

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
	
	/**
	 * Nombre de la función:	ContarEstadoProceso
	 * Propósito:				Contar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_estado_proceso_sel';
		$this->codigo_procedimiento = "'CB_ESTPRO_COUNT'";

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
	
	
}?>