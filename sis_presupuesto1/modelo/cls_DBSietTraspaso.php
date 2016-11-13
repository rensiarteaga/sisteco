<?php
/**
 * Nombre de la clase:	cls_DBSietTraspaso.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tsi_siet_partida
 * Autor:				A.V.Q.
 * Fecha creación:		2015-11-12
 */

 
class cls_DBSietTraspaso
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
	 * Nombre de la función:	ListarSietPartida
	 * Propósito:				Desplegar los registros de tsi_siet_partida
	 * Autor:				    a.v.q.
	 * Fecha de creación:		2015-11-12
	 */
	function ListarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_traspaso_sel';
		$this->codigo_procedimiento = "'PR_SITRASP_SEL'";

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
		$this->var->add_def_cols('id_siet_traspaso','INTEGER');
		$this->var->add_def_cols('id_siet_declara','INTEGER');
		$this->var->add_def_cols('id_siet_cbte_origen','INTEGER');
		$this->var->add_def_cols('id_siet_cbte_destino','INTEGER');
		$this->var->add_def_cols('nro_cbte_origen','varchar');
		$this->var->add_def_cols('nro_cbte_destino','varchar');
		$this->var->add_def_cols('id_cuenta_bancaria_origen','INTEGER');
		$this->var->add_def_cols('id_cuenta_bancaria_destino','INTEGER');
		$this->var->add_def_cols('nro_cuenta_bancaria_origen','varchar');
		$this->var->add_def_cols('nro_cuenta_bancaria_destino','varchar');
		$this->var->add_def_cols('importe_origen','numeric');
		$this->var->add_def_cols('importe_destino','numeric');
		$this->var->add_def_cols('id_cbte','integer');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSietPartida
	 * Propósito:				Contar los registros de tsi_siet_partida
	 * Autor:				    a.v.q
	 * Fecha de creación:		01/11/2015
	 */
	function ContarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_traspaso_sel';
		$this->codigo_procedimiento = "'PR_SITRASP_COUNT'";

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
	 * Nombre de la función:	GenerarSietTraspaso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsi_siet_traspaso
	 * Autor:				    avq
	 * Fecha de creación:		01/11/2015
	 */
	function GenerarSietTraspaso($id_siet_declara)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_traspaso_iud';
		$this->codigo_procedimiento = "'PR_SIGENTRAS_INS'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_siet_declara);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSietTraspaso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tsi_siet_traspaso
	 * Autor:				    avq
	 * Fecha de creación:		01/11/2015
	 */
	function EliminarSietTraspaso($id_siet_traspaso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tpr_siet_traspaso_iud';
		$this->codigo_procedimiento = "'PR_SITRASP_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_siet_traspaso);
		$this->var->add_param("NULL");
		/*$this->var->add_param("NULL");
		$this->var->add_param("NULL"); //descripcion*/
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
}	
?>
