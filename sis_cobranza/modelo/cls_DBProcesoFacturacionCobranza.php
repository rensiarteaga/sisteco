<?php
/**
 * Nombre de la Clase:	cls_DBProcesoFacturacionCobranza.php.php
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_actualizacion
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		13/12/2010
 */
class cls_DBProcesoFacturacionCobranza
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
	function InsertarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_proceso_facturacion_cobranza_iud';
		$this->codigo_procedimiento = "'CT_PROCES_INS'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$id_sistema_distribucion'");
		$this->var->add_param("$id_periodo");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param("$id_gestion");
		$this->var->add_param("'$desc_proceso'");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_tipo_facturacion_cobranza");

		 
		
		
		

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
	function ModificarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza)
	{
		 
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_proceso_facturacion_cobranza_iud';
		$this->codigo_procedimiento = "'CT_PROCES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("'$id_sistema_distribucion'");
		$this->var->add_param("$id_periodo");
		$this->var->add_param("'$fecha_inicio'");
		$this->var->add_param("'$fecha_final'");
		$this->var->add_param("$id_gestion");
		$this->var->add_param("'$desc_proceso'");
		$this->var->add_param("$id_proceso_facturacion_cobranza");
		$this->var->add_param("$id_tipo_facturacion_cobranza");

		
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
	function EliminarProcesoFacturacionCobranza($id_sistema_distribucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_proceso_facturacion_cobranza_iud';
		$this->codigo_procedimiento = "'CT_PROCES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("$id_sistema_distribucion");
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
	 * Nombre de la función:	ListarProcesoFacturacionCobranza
	 * Propósito:				Desplegar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		
	 */
	function ListarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_proceso_facturacion_cobranza_sel';
		$this->codigo_procedimiento = "'CB_PROCES_SEL'";

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
		$this->var->add_def_cols('id_proceso_facturacion_cobranza','integer');
		$this->var->add_def_cols('id_sistema_distribucion','varchar');
		$this->var->add_def_cols('nombre_sistema_distribucion','varchar');
		$this->var->add_def_cols('id_periodo','integer');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_final','date');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','integer');
		$this->var->add_def_cols('periodo','integer');
		$this->var->add_def_cols('desc_proceso','varchar');
		$this->var->add_def_cols('id_tipo_facturacion_cobranza','integer');
		$this->var->add_def_cols('nombre_proceso','varchar');
		$this->var->add_def_cols('prioridad','integer');
		$this->var->add_def_cols('nombre_estado','varchar');
		$this->var->add_def_cols('id_estado_proceso','integer');


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
	 * Nombre de la función:	ContarProcesoFacturacionCobranza
	 * Propósito:				Contar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'cobra.f_tcb_proceso_facturacion_cobranza_sel';
		$this->codigo_procedimiento = "'CB_PROCES_COUNT'";

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