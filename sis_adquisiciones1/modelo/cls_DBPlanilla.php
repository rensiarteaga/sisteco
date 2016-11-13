<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_planilla
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-05-28 17:32:18
 */

 
class cls_DBPlanilla
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
	 * Nombre de la funci�n:	ListarPlanilla
	 * Prop�sito:				Desplegar los registros de tad_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_sel';
		$this->codigo_procedimiento = "'AD_PLANIL_SEL'";

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
		

		//Carga la definici�n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('id_planilla','int4');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('fecha_planilla','date');		
		$this->var->add_def_cols('id_depto_tesoro','int4');
		$this->var->add_def_cols('id_gestion','int4');
		$this->var->add_def_cols('id_periodo','int4');		
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('periodo','varchar');
		$this->var->add_def_cols('depto_tesoro','text');
		$this->var->add_def_cols('tiene_pagos','bigint');
		$this->var->add_def_cols('plantilla','varchar');
		$this->var->add_def_cols('desc_plantilla','text');
		$this->var->add_def_cols('total_pagos_con_doc','bigint');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('prov_sin_cta','varchar');
		$this->var->add_def_cols('periodo_rep','numeric');
		$this->var->add_def_cols('cod_depto_rep','varchar');
		
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
	
	
	/**
	 * Nombre de la funci�n:	ContarPlanilla
	 * Prop�sito:				Contar los registros de tad_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_sel';
		$this->codigo_procedimiento = "'AD_PLANIL_COUNT'";

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
	
		//Retorna el resultado de la ejecuci�n
		return $res;
	}
	
	
	
	function InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLANIL_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_depto_tesoro);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("'$plantilla'");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("'$descripcion'");//$descripcion
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		//$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	
	function ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLANIL_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_depto_tesoro);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("'$plantilla'");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLANIL_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	function InsertarPlanillaDet($id_planilla,$id_plan_pago,$tipo_plantilla,$fecha_pagado,$num_factura,$fecha_factura,$por_anticipo,$por_retgar,$multas,$obs_descuentos)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLADET_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$fecha_planilla'");
		$this->var->add_param($id_gestion);
		$this->var->add_param($id_periodo);
		$this->var->add_param($id_depto_tesoro);
		$this->var->add_param($id_cotizacion);
		$this->var->add_param($id_plan_pago);
		
		$this->var->add_param("'$fecha_pagado'");
		$this->var->add_param($tipo_plantilla);
		$this->var->add_param($num_factura);
		$this->var->add_param("'$fecha_factura'");
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param($por_anticipo);
		$this->var->add_param($por_retgar);
		$this->var->add_param($multas);
		$this->var->add_param("'$obs_descuentos'");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
		function EliminarPlanillaDet($id_planilla,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLADET_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_plan_pago);
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	function InsertarPlanillaPago($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLANIL_PAG'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param("NULL");//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function ImportarPlanilla($id_planilla,$id_plantilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_IMPPLA_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//("'$fecha_planilla'");
		$this->var->add_param("NULL");//($id_gestion);
		$this->var->add_param("NULL");//($id_periodo);
		$this->var->add_param("NULL");//($id_depto_tesoro);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param($id_plantilla);//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_cuenta_bancaria;
		$this->var->add_param("NULL");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	function DefinirCuentaTransaccion($id_planilla,$id_cuenta_bancaria,$tipo_cheque)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_planilla_iud';
		$this->codigo_procedimiento = "'AD_CTADET_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_planilla);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//("'$fecha_planilla'");
		$this->var->add_param("NULL");//($id_gestion);
		$this->var->add_param("NULL");//($id_periodo);
		$this->var->add_param("NULL");//($id_depto_tesoro);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");//tipo_plantilla
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//fecha_factura
		$this->var->add_param("NULL");//plantilla
		$this->var->add_param($id_plantilla);//id_plantilla
		
		$this->var->add_param("NULL");//por_anticipo
		$this->var->add_param("NULL");//($por_retgar);
		$this->var->add_param("NULL");//multas;
		$this->var->add_param("NULL");
		$this->var->add_param("$id_cuenta_bancaria");//id_cuenta_bancaria;
		$this->var->add_param("'$tipo_cheque'");//tipo_cheque;
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
}?>