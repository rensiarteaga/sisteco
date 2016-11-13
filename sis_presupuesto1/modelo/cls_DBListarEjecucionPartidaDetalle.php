<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBListarEjecucionPartidaDetalle 
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
	
	//comprometido desde solicitudes de viatico, efectivo, fondo en avance y cajas 
	function ListarDetallePartidaComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_presupuesto,$id_partida)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_detalle_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDODET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		//$this->var->add_param("$tipo_pres");//si
	//	$this->var->add_param("$id_parametro");//si
		//$this->var->add_param("$id_moneda");//si
		$this->var->add_param("$id_presupuesto");//si
		$this->var->add_param("$id_partida");//si
		/*$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si*/		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('estado_pres','text');
		$this->var->add_def_cols('importe_ejecucion','numeric');
		$this->var->add_def_cols('fecha_com_eje','date');	
		$this->var->add_def_cols('concepto','text');	
		

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->var->query;
		exit ();*/
		
		return $res;
	}
	
	
	
}?>