<?php
/**
 * Nombre de la clase:	cls_DBPrestacionServicios.php
 * Propósito:			Permite ejecutar toda la funcionalidad para el reporte Prestación de Servicios
 * Autor:				AVQ
 * Fecha creación:		05/03/2010
 */

 
class cls_DBPrestacionServicios
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
	 * Nombre de la función:	ListarPrestacionServicios
	 * Propósito:				Desplegar los registros para el reporte prestación de servicios
	 * Autor:				    avq
	 * Fecha de creación:		08/03/2010
	 */
	function ListarPrestacionServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_prestacion_servicio_sel';
		$this->codigo_procedimiento = "'AD_PRESER_SEL'";

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
		 $this->var->add_def_cols('num_sol','VARCHAR'); 
 		 $this->var->add_def_cols('desc_proveedor','TEXT'); 
  		$this->var->add_def_cols('doc_id','VARCHAR'); 
		$this->var->add_def_cols('servicio','VARCHAR'); 
  		$this->var->add_def_cols('uo','TEXT'); 
  		$this->var->add_def_cols('nro_contrato','varchar'); 
  		$this->var->add_def_cols('orden_servicio','TEXT'); 
  		$this->var->add_def_cols('tipo_entrega','VARCHAR'); 
  		$this->var->add_def_cols('fecha_ini_ctto','DATE'); 
  		$this->var->add_def_cols('fecha_fin_ctto','DATE'); 
  		$this->var->add_def_cols('remuneracion_mes','numeric'); 
  		$this->var->add_def_cols('estado_vigente','VARCHAR'); 
  		$this->var->add_def_cols('id_periodo','INTEGER'); 
  		$this->var->add_def_cols('num_orden_compra','INTEGER');
		

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
	
	
	
}?>