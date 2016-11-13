<?php
/**
 * Nombre de la Clase:	cls_DBTransaccionActualizacion
 * Propósito:			Permite ejecutar la funcionalidad de la tabla tct_transaccion_actualizacion
 * Autor:				Ana Maria Villegas Quispe
 * Fecha creación:		17/12/2010
 */
class cls_DBTransaccionActualizacion
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
	 * Nombre de la función:	ListarActualizacionDetalle
	 * Propósito:				Desplegar los registros de tct_actualizacion
	 * Autor:				    avq
	 * Fecha de creación:		15/12/2010
	 */
	function ListarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_actualizacion_sel';
		$this->codigo_procedimiento = "'CT_TRAACT_SEL'";

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
		$this->var->add_def_cols('id_transaccion_actualizacion','INTEGER'); 
 		$this->var->add_def_cols('id_transaccion',' INTEGER'); 
 		$this->var->add_def_cols('identificador',' INTEGER'); 
  		$this->var->add_def_cols('saldo',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('saldo_actualizado',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('id_actualizacion_detalle',' INTEGER'); 
  		$this->var->add_def_cols('importe_moneda_actualizacion',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('tipo_actualizacion',' VARCHAR'); 
  		$this->var->add_def_cols('tipo_cambio_inicial',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('tipo_cambio_final',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('diferencial_actualizacion',' NUMERIC(20,2)'); 
  		$this->var->add_def_cols('id_actualizacion_detalle_saldo',' INTEGER'); 
 		$this->var->add_def_cols('fecha','DATE'); 
		
		
		
		
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
	 * Nombre de la función:	ContarActualizacion
	 * Propósito:				Contar los registros de tct_actualizacion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-31 11:01:39
	 */
	function ContarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_actualizacion_sel';
		$this->codigo_procedimiento = "'CT_TRAACT_COUNT'";

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
		//echo $this->query;
		//exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	
}?>