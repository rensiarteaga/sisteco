<?php
/**
 * Nombre de la clase:	cls_DBPlanPago.php
 * Prop�sito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_plan_pago
 * Autor:				(autogenerado)
 * Fecha creaci�n:		2008-05-28 17:32:18
 */

 
class cls_DBPlanPago
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
	 * Nombre de la funci�n:	ListarPlanPago
	 * Prop�sito:				Desplegar los registros de tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ListarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_PLAPAG_SEL'";

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
		$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definici�n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('cuota_a_pagar','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_pago','date');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_plan_pago','int4');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('nro_cuota','int4');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('pagado','numeric');
		$this->var->add_def_cols('falta_pagar','numeric');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('estado_vigente','varchar');//de la cotizacion
		$this->var->add_def_cols('num_pagos','int4');//de la cotizacion
		$this->var->add_def_cols('num_factura','int4');//
		$this->var->add_def_cols('observaciones','text');//
		$this->var->add_def_cols('boleta_garantia','varchar');//
		$this->var->add_def_cols('num_autoriza_factura','numeric');//
		$this->var->add_def_cols('cod_control_factura','varchar');//
		$this->var->add_def_cols('fecha_factura','date');//
		$this->var->add_def_cols('multas','numeric');//
		$this->var->add_def_cols('tipo_adq','text');//
		$this->var->add_def_cols('monto_original','numeric');//
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('obs_conta','text');//
		//RAC: aumentado estos campos que remplazan al campo de impuesto
		$this->var->add_def_cols('tipo_plantilla','int4');//
		$this->var->add_def_cols('desc_plantilla','varchar');//	
		$this->var->add_def_cols('id_avance','integer');
		$this->var->add_def_cols('avance','text');
		$this->var->add_def_cols('por_anticipo','numeric');
		$this->var->add_def_cols('por_retgar','numeric');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		//echo $this->query;
		//exit;
		return $res;
	}
	/**
	 * Nombre de la funci�n:	ListarPlanPago
	 * Prop�sito:				Desplegar los registros de tad_plan_pago
	 * Autor:				    Ana Maria Villegas Q.
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function RepPlanPagoCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_RPLAPC_SEL'";

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
		$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('tipo_entrega','varchar');
		$this->var->add_def_cols('fecha_entrega','date');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('precio_total_moneda_cotizada','numeric');
		
		
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
	 * Nombre de la funci�n:	ListarPlanPago
	 * Prop�sito:				Desplegar los registros de tad_plan_pago
	 * Autor:				    Ana Maria Villegas Q.
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ListarPlanPagoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_PLAREP_SEL'";

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
		$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('nro_cuota','int4');
		$this->var->add_def_cols('monto_a_pagar','numeric');
		$this->var->add_def_cols('fecha_pago','date');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('estado','varchar');
		
		
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
	 * Nombre de la funci�n:	ContarPlanPago
	 * Prop�sito:				Contar los registros de tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ContarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_PLAPAG_COUNT'";

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
		$this->var->add_param($func->iif($id_cotizacion== '',"NULL",$id_cotizacion));//id_cotizacion
		
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
	/**
	 * contarNumPagos
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @param unknown_type $id_cotizacion
	 * @return unknown
	 */
	function ContarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_NUMPAG_COUNT'";

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
		$this->var->add_param($func->iif($id_cotizacion== '',"NULL",$id_cotizacion));//id_cotizacion
		
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
	
	
	/**
	 * Nombre de la funci�n:	InsertarPlanPago
	 * Prop�sito:				Permite ejecutar la funci�n de inserci�n de la tabla tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function InsertarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$id_gestion,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		$this->codigo_procedimiento = "'AD_PLAPAG_INS'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$tipo_pago'");
		$this->var->add_param($nro_cuota);
		$this->var->add_param("'$fecha_pago'");
		$this->var->add_param($monto);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//observaciones
		
		
		$this->var->add_param("NULL");//("'$boleta_garantia'");
		$this->var->add_param("NULL");//($num_autoriza_factura);
		$this->var->add_param("NULL");//("'$cod_control_factura'");
		$this->var->add_param("NULL");//("'$fecha_factura'");
		$this->var->add_param("NULL");//($multas);
		$this->var->add_param(0);//pago_simplificado;
		$this->var->add_param("NULL");//impuestos;
		$this->var->add_param($id_gestion);//gestion;
		$this->var->add_param($id_avance);//avance;
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la funci�n:	ModificarPlanPago
	 * Prop�sito:				Permite ejecutar la funci�n de modificaci�n de la tabla tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ModificarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$fecha_pagado,$num_factura,$observaciones,$boleta_garantia,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$multas,$impuestos,$id_gestion,$id_avance)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		$this->codigo_procedimiento = "'AD_PLAPAG_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plan_pago);
		$this->var->add_param("'$tipo_pago'");
		$this->var->add_param($nro_cuota);
		$this->var->add_param("'$fecha_pago'");
		$this->var->add_param($monto);
		$this->var->add_param("'$estado'");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("'$fecha_pagado'");
		$this->var->add_param($num_factura);
		$this->var->add_param("'$observaciones'");
		
		$this->var->add_param("'$boleta_garantia'");
		$this->var->add_param($num_autoriza_factura);
		$this->var->add_param("'$cod_control_factura'");
		$this->var->add_param("'$fecha_factura'");
		$this->var->add_param($multas);
		$this->var->add_param(0);
		$this->var->add_param($impuestos);//impuestos;
		$this->var->add_param($id_gestion);//gestion;
		$this->var->add_param($id_avance);//avance;
		
		
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
	
	/**
	 * Nombre de la funci�n:	EliminarPlanPago
	 * Prop�sito:				Permite ejecutar la funci�n de eliminaci�n de la tabla tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function EliminarPlanPago($id_plan_pago)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		$this->codigo_procedimiento = "'AD_PLAPAG_DEL'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plan_pago);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//observaciones
$this->var->add_param("NULL");//("'$boleta_garantia'");
		$this->var->add_param("NULL");//($num_autoriza_factura);
		$this->var->add_param("NULL");//("'$cod_control_factura'");
		$this->var->add_param("NULL");//("'$fecha_factura'");
		$this->var->add_param("NULL");//($multas);
        $this->var->add_param("NULL");//pago_simplificado
        $this->var->add_param("NULL");//impuestos;
         $this->var->add_param("NULL");//id_gestion
         $this->var->add_param("NULL");//avance;
        
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	function ListarPlanPagoCuota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_PLACUO_SEL'";

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
		$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('monto_a_pagar','numeric');
		$this->var->add_def_cols('cuota_a_pagar','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('fecha_pago','date');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('id_plan_pago','int4');
		$this->var->add_def_cols('monto','numeric');
		$this->var->add_def_cols('nro_cuota','int4');
		$this->var->add_def_cols('tipo_pago','varchar');
		$this->var->add_def_cols('precio_total','numeric');
		$this->var->add_def_cols('pagado','numeric');
		$this->var->add_def_cols('falta_pagar','numeric');
		$this->var->add_def_cols('num_pagos','int4');
		$this->var->add_def_cols('fecha_pagado','date');
		$this->var->add_def_cols('fecha_reg_cotizacion','date');
		
		//$this->var->add_def_cols('impuestos','int4');
		
		//$this->var->add_def_cols('retencion_bien','numeric');
		//$this->var->add_def_cols('retencion_servicio','numeric');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
	
		return $res;
	}
	
	
	/**
	 * listarNumPagos
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @param unknown_type $id_cotizacion
	 * @return unknown
	 */
	function ListarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_sel';
		$this->codigo_procedimiento = "'AD_NUMPAG_SEL'";

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
		$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definici�n de columnas con sus tipos de datos
		$this->var->add_def_cols('num_pago','int4');
		
		//Ejecuta la funci�n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	
	function FinalizarPlanPago($id_plan_pago,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		$this->codigo_procedimiento = "'AD_FINPAG_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plan_pago);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//observaciones
        $this->var->add_param("NULL");//("'$boleta_garantia'");
		$this->var->add_param("NULL");//($num_autoriza_factura);
		$this->var->add_param("NULL");//("'$cod_control_factura'");
		$this->var->add_param("NULL");//("'$fecha_factura'");
		$this->var->add_param("NULL");//($multas);
		$this->var->add_param("NULL");//pago_simplif
		$this->var->add_param("NULL");//impuestos;
		$this->var->add_param("NULL");//id_gestion
		$this->var->add_param("NULL");//avance;


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
	/**
	 * Revertir Plan de Pago
	 *
	 * @param unknown_type $id_plan_pago
	 * @param unknown_type $id_cotizacion
	 * @return unknown
	 */
	function RevertirPlanPago($id_plan_pago,$id_cotizacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		$this->codigo_procedimiento = "'AD_REVPAG_UPD'";

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_plan_pago);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//observaciones
$this->var->add_param("NULL");//("'$boleta_garantia'");
		$this->var->add_param("NULL");//($num_autoriza_factura);
		$this->var->add_param("NULL");//("'$cod_control_factura'");
		$this->var->add_param("NULL");//("'$fecha_factura'");
		$this->var->add_param("NULL");//($multas);
		$this->var->add_param("NULL");//pago_simplif
		$this->var->add_param("NULL");//impuestos;
		$this->var->add_param("NULL");//id_gestion
		$this->var->add_param("NULL");//avance;
		

		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	/**
	 * Nombre de la funci�n:	ValidarPlanPago
	 * Prop�sito:				Permite ejecutar la validaci�n del lado del servidor de la tabla tad_plan_pago
	 * Autor:				    (autogenerado)
	 * Fecha de creaci�n:		2008-05-28 17:32:18
	 */
	function ValidarPlanPago($operacion_sql,$id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validaci�n por el tipo de operaci�n
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_plan_pago - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_plan_pago");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plan_pago", $id_plan_pago))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			

			//Validar nro_cuota - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cuota");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cuota", $nro_cuota))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_pago - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_pago");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_pago", $fecha_pago))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar monto - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("monto");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "monto", $monto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar id_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cotizacion");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion", $id_cotizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validaci�n exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_plan_pago - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_plan_pago");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_plan_pago", $id_plan_pago))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validaci�n exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	function FinalizarDefPagos($id_cotizacion,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_plan_pago_iud';
		if($tipo=='revertir'){
			$this->codigo_procedimiento = "'AD_REVCOT_UPD'";	
		}
		else{
			$this->codigo_procedimiento = "'AD_PLAFIN_UPD'";	
		}
		

		//Instancia la clase midlle para la ejecuci�n de la funci�n de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");//fecha_pagado
		$this->var->add_param("NULL");//num_factura
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//("'$boleta_garantia'");
		$this->var->add_param("NULL");//($num_autoriza_factura);
		$this->var->add_param("NULL");//("'$cod_control_factura'");
		$this->var->add_param("NULL");//("'$fecha_factura'");
		$this->var->add_param("NULL");//($multas);
		$this->var->add_param("NULL");//pago_simplificado;
		$this->var->add_param("NULL");//impuestos;
		$this->var->add_param("NULL");//impuestos;
		$this->var->add_param("NULL");//avance;
		
		//Ejecuta la funci�n
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la funci�n y retorna el resultado de la ejecuci�n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llam� a la funci�n de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
}?>