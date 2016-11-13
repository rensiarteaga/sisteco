<?php
/**
 * Nombre de la clase:	cls_DBRepBalanceSS.php
 * Propósito:			Permite ejecutar  el listado de los documentos  de un comprobante de la tabla tct_cuenta
 * Autor:				Ana Maria villegas
 * Fecha creación:		2009-06-17 17:13:36
 */

 
class cls_DBRepCierreContable
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
	 * Nombre de la función:	ReporteCierreContable.
	 * Propósito:				Desplegar los registros de tct_cuenta
	 * Autor:				    Ana Maria
	 * Fecha de creación:		2009-06-17 17:13:36
	 */
	function  ReporteCierreContable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cierre_contable_sel';
		$this->codigo_procedimiento = "'CT_CIECONT_SEL'";

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
		$this->var->add_param("'$ids_deptos'");//ids_deptos
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        
        
    
  		$this->var->add_def_cols('id_comprobante',' INTEGER'); 
  		$this->var->add_def_cols('id_presupuesto',' INTEGER'); 
  		$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('importe_presupuesto',' NUMERIC'); 
  		$this->var->add_def_cols('importe_contabilida','NUMERIC');
  		$this->var->add_def_cols('diferencia','NUMERIC');
  		
  		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	   /*echo $this->query;
		exit();*/
		return $res;
	}
	function  ReporteDifPagadoDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_cierre_contable_sel';
		$this->codigo_procedimiento = "'CT_DIFDEVPAG_SEL'";

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
		$this->var->add_param("'$ids_deptos'");//ids_deptos
        $this->var->add_param("'$fecha_inicio'");//fecha_inicio
        $this->var->add_param("'$fecha_fin'");//fecha_fin
        
        
    
  		$this->var->add_def_cols('id_comprobante',' INTEGER'); 
  		$this->var->add_def_cols('pagado',' NUMERIC');
  		/*$this->var->add_def_cols('id_partida',' INTEGER'); 
  		$this->var->add_def_cols('importe_presupuesto',' NUMERIC'); 
  		$this->var->add_def_cols('importe_contabilida','NUMERIC');
  		$this->var->add_def_cols('diferencia','NUMERIC');*/
  		
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