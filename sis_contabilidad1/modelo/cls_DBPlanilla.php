<?php
/**
 * Nombre de la clase:	cls_DBPlanilla.php
 * Propï¿½sito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_planilla
 * Autor:				(autogenerado)
 * Fecha creaciï¿½n:		2008-05-28 17:32:18
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
	
function ListarReporteCabeceraPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
	 
	 
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_planilla';
		$this->codigo_procedimiento = "'CT_REPPLACAB_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('descripcion','TEXT');
		$this->var->add_def_cols('nombre','VARCHAR');
		$this->var->add_def_cols('nro_cuenta_banco','VARCHAR');
		$this->var->add_def_cols('id_cuenta_bancaria','integer');
	
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}	
function ListarReporteDetallePlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
	 
	 
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_reporte_planilla';
		$this->codigo_procedimiento = "'CT_REPPLADET_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
 
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('desc_proveedor','TEXT');
		$this->var->add_def_cols('monto_a_pagar','NUMERIC');
		$this->var->add_def_cols('nombre','VARCHAR');
		$this->var->add_def_cols('nro_cuenta_banco','VARCHAR');
	
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ListarPlanilla
	 * Propósito:				Desplegar los registros de tad_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:18
	 */
	
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_sel';
		$this->codigo_procedimiento = "'CT_PLANIL_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
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
		
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPlanilla
	 * Propósito:				Contar los registros de tad_planilla
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:18
	 */
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_sel';
		$this->codigo_procedimiento = "'CT_PLANIL_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parï¿½metros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parï¿½metros especï¿½ficos de la estructura programï¿½tica
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		
		//Carga la definiciï¿½n de columnas con sus tipos de datos
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n
		$this->salida = $this->var->salida;

		//Si la ejecuciï¿½n fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
	
		//Retorna el resultado de la ejecuciï¿½n
		return $res;
	}
	
	function InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'CT_PLANIL_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
	function ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'AD_PLANIL_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		//echo $this->query."editar" ; exit();
		return $res;
	}
	
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'CT_PLANIL_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function InsertarPlanillaDet($id_plan_pago,$id_cuenta_bancaria,$tipo_cheque,$tipo_plantilla,$fecha_factura,$num_factura,$por_anticipo,$por_retgar,$multas)
	{ 
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_cuenta_bancaria_iud';
		$this->codigo_procedimiento = "'AD_PLAPAG_CTABCO_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plan_pago);
		$this->var->add_param($id_cuenta_bancaria);//$id_cuenta_bancaria
		$this->var->add_param("'$tipo_cheque'");//$tipo_cheque
		$this->var->add_param("$tipo_plantilla");//$tipo_plantilla
		$this->var->add_param("'$fecha_factura'");//$fecha_factura
		$this->var->add_param("$num_factura");//$num_factura
		$this->var->add_param("$por_anticipo");//por_anticipo
		$this->var->add_param("$por_retgar");//por_retgar
		$this->var->add_param("$multas");//multas
		 
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
/*echo $this->query."insertreas" ; exit();
exit;*/
		return $res;
	}
	
	function EliminarPlanillaDet($id_planilla,$id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'CT_PLADET_DEL'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
/*echo $this->query;
exit;*/
		return $res;
	}
	
	function InsertarPlanillaPago($id_planilla,$estado_reg)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'CT_PLANIL_UPD'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		$this->var->add_param("'$estado_reg'");//($por_retgar);
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ImportarPlanilla($id_planilla,$id_plantilla)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_planilla_iud';
		$this->codigo_procedimiento = "'CT_IMPPLA_INS'";

		//Instancia la clase midlle para la ejecuciï¿½n de la funciï¿½n de la BD
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
		//Ejecuta la funciï¿½n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}
	
}?>