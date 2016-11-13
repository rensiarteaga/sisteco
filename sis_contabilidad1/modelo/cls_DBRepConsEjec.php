<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBRepConsEjec
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
	 * Nombre de la función:	ListarDestino
	 * Propósito:				Desplegar los registros de tpr_destino
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-07-04 08:54:28
	 */
	
	function ContarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cons_ejec';
		$this->codigo_procedimiento = "'CONSEJEC_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
		
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		//Carga los parámetros del filtro
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		$this->var->add_def_cols('TOTAL','BIGINT');
		
		//Ejecuta la función de consulta
		//Ejecuta la función de consultaecj
		$res = $this->var->exec_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	//echo $this->query;exit;
	
		return $res;
	}
	function ListarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cons_ejec';
		$this->codigo_procedimiento = "'CONSEJEC_SEL'";

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
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','TEXT');
		$this->var->add_def_cols('concepto_cbte','VARCHAR');
		//$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('nro_cuenta','VARCHAR');
		$this->var->add_def_cols('nombre_cuenta','VARCHAR');
		$this->var->add_def_cols('codigo_partida','VARCHAR');
		$this->var->add_def_cols('nombre_partida','VARCHAR');
		$this->var->add_def_cols('codigo_auxiliar','VARCHAR');
		$this->var->add_def_cols('nombre_auxiliar','VARCHAR');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('importe_gasto','numeric');
		$this->var->add_def_cols('importe_recurso','numeric');
		$this->var->add_def_cols('momento_cbte','numeric');
		
 
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;exit();
		return $res;
	}
	
	
	
}?>