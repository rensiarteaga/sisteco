<?php
/**
 * Nombre de la clase:	cls_DBRepUOSol.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_solicitud_compra
 * Autor:				Ana Maria
 * Fecha creación:		15/02/2011
 */

 
class cls_DBRepProcesosEnCurso
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
	/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    avillegas
	 * Fecha de creación:		16/02/2011
	 */
	function ListarRepProcesosEnCursoCabPres($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rep_procesos_en_curso_sel';
		$this->codigo_procedimiento = "'AD_PROCURCAB_REP'";

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
		$this->var->add_param("'$id_presupuesto'");//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		
		$this->var->add_def_cols('id_presupuesto','integer');
        $this->var->add_def_cols('tipo_pres','varchar');
        $this->var->add_def_cols('desc_presupuesto','text');
        $this->var->add_def_cols('nombre_unidad','varchar');
        $this->var->add_def_cols('nombre_financiador','varchar');
        $this->var->add_def_cols('nombre_regional','varchar');
        $this->var->add_def_cols('nombre_programa','varchar');
        $this->var->add_def_cols('nombre_proyecto','varchar');
        $this->var->add_def_cols('nombre_actividad','varchar');
		
			
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    avillegas
	 * Fecha de creación:		015/02/2011
	 */
	function ListarRepProcesosEnCurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_rep_procesos_en_curso_sel';
		$this->codigo_procedimiento = "'AD_PROCUR_REP'";

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
		$this->var->add_def_cols('id_presupuesto','varchar');
        $this->var->add_def_cols('id_unidad_organizacional','varchar');
        $this->var->add_def_cols('id_partida','varchar');
        $this->var->add_def_cols('id_gestion','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_doc','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('monto_comprometido',' numeric'); 
		$this->var->add_def_cols('monto_adjudicado',' numeric');
		$this->var->add_def_cols('monto_devengado',' NUMERIC');
		$this->var->add_def_cols('saldo_x_revertir',' NUMERIC');
		$this->var->add_def_cols('monto_pagado',' NUMERIC');
		$this->var->add_def_cols('saldo_x_devengar',' NUMERIC');
		$this->var->add_def_cols('saldo_x_pagar',' NUMERIC');
		
			
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
		
}?>
