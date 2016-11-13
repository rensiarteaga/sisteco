<?php
/**
 * Nombre de la clase:	cls_DBCotizacion.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_cotizacion
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-05-28 16:58:40
 */
 
class cls_DBConsultores
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;
	
	function __construct(){
		$this->decodificar=$decodificar;
	}
	
	/**
	 * Listado de consultores para la vista de planilla_det..
	*/

	function ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_consultores_sel';
		$this->codigo_procedimiento = "'CT_CONSUL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($en_planilla == '',"'%'","'$en_planilla'"));//id_actividad

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('desc_proveedor','text');
		$this->var->add_def_cols('num_os','text');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('num_sol','varchar');
		$this->var->add_def_cols('prox_pago','int4');
		$this->var->add_def_cols('fecha_prox_pago','date');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('id_plan_pago','int4');
		
		
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('tipo_plantilla','int4');
		$this->var->add_def_cols('num_factura','bigint');//10ago12 por modificacion en tabla tad_cotizacion, tad_plan_pago
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('desc_plantilla','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('nit','varchar');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('tipo','numeric');
		$this->var->add_def_cols('id_documento','integer');
		$this->var->add_def_cols('por_anticipo','numeric');
		$this->var->add_def_cols('por_retgar','numeric');
		$this->var->add_def_cols('multas','numeric');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
		$this->var->add_def_cols('cuenta_bancaria','text');
		$this->var->add_def_cols('tipo_cheque','varchar');
		$this->var->add_def_cols('monto_a_pagar','numeric');
		$this->var->add_def_cols('nro_cuenta_proveedor','varchar');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
 		/*echo $this->query;
 		exit;*/
		return $res;
	}
	
	function ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_consultores_sel';
		$this->codigo_procedimiento = "'CT_CONSUL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los par�metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los par�metros espec�ficos de la estructura program�tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		$this->var->add_param($func->iif($en_planilla == '',"'%'","'$en_planilla'"));//id_actividad

		
		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n
		$this->salida = $this->var->salida;

		//Si la ejecuci�n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;

		//Retorna el resultado de la ejecuci�n
		return $res;
	}
}?>