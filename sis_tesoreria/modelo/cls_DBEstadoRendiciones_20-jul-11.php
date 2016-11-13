<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBEstadoRendiciones
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
	
	function ListarReporteEstadoSolicitudes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_solicitud,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tts_estado_rendiciones_sel';
		$this->codigo_procedimiento = "'PR_EST_SOLI_SEL'";

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
		
		$this->var->add_param("$id_depto");//si
		$this->var->add_param("'$estado_solicitud'");//si		
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo','text');	
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('periodo','text');	
		$this->var->add_def_cols('elaborado_por','text');	
		$this->var->add_def_cols('tiempo_dias','integer');		
		$this->var->add_def_cols('observaciones','varchar');
		

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
	
	//comprometido desde solicitudes de viatico, efectivo, fondo en avance y cajas 
	function ListarReporteEstadoRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_rendicion,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tts_estado_rendiciones_sel';
		$this->codigo_procedimiento = "'PR_EST_REND_SEL'";

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
		
		$this->var->add_param("$id_depto");//si
		$this->var->add_param("'$estado_rendicion'");//si		
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo','text');	
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('periodo','text');	
		$this->var->add_def_cols('elaborado_por','text');	
			
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('estado_comp','varchar');
		$this->var->add_def_cols('id_comprobante2','integer');
		$this->var->add_def_cols('nro_cbte2','integer');				
		$this->var->add_def_cols('estado_comp2','varchar');

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
	
	function ListarReporteEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tts_estado_cuenta_sel';
		$this->codigo_procedimiento = "'PR_EST_CUENTA_SEL'";

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
		
		$this->var->add_param("$id_depto");//si
		$this->var->add_param("$id_empleado");//si		
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si	
		$this->var->add_param("'$estado'");//si	

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('tipo','text');	
		$this->var->add_def_cols('fecha_doc','text');		
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','varchar');		
		$this->var->add_def_cols('estado','varchar');
		
		$this->var->add_def_cols('importe_entregado','numeric');	
		$this->var->add_def_cols('numero_rendicion','varchar');		
		$this->var->add_def_cols('estado_rendicion','varchar');
		$this->var->add_def_cols('importe_rendicion','numeric');	
		$this->var->add_def_cols('id_comprobante_rendicion','integer');
		
		$this->var->add_def_cols('saldo_empleado','numeric');	
		$this->var->add_def_cols('saldo_ende','numeric');

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
	
	function ListarEmpleadosDepartamento($id_depto,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_tfv_reporte_clientes_ruta_sel';
		//$this->codigo_procedimiento = "'FV_REPCLIRU_SEL'";
		
		$this->nombre_funcion = 'f_tts_estado_cuenta_sel';
		$this->codigo_procedimiento = "'PR_EMPL_DEPTO_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		//Carga los parámetros del filtro
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		/*$this->var->cant = 1000;
		$this->var->puntero = 0;
		$this->var->sortcol = "''";
		$this->var->sortdir = "''";
		$this->var->criterio_filtro = "'0=0'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param("$id_depto");//id_parametro
		$this->var->add_param("$id_empleado");//id_parametro
		$this->var->add_param("'$fecha_desde'");//id_ruta		
		
		$this->var->add_param("'$fecha_hasta'");//id_gestion
		$this->var->add_param("'$estado'");//id_periodo	*/	
		
		
		
		//Carga los parámetros del filtro
		$this->var->cant = 100; //$cant;
		$this->var->puntero = 0; //$puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
		
		$this->var->add_param("$id_depto");//si
		$this->var->add_param("$id_empleado");//si		
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si	
		$this->var->add_param("'$estado'");//si	
		

		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_cliente','bigint');		
		
		$this->var->add_def_cols('id_empleado','integer');
				
		
		//Ejecuta la función de consulta
		 $res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->query;
		exit();*/
	
		return $res;
	}
	
	//comprometido desde rendiciones
	/*function ListarRDEPComprometido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO2_SEL'";

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
		$this->var->add_param("$tipo_pres");//si
		$this->var->add_param("$id_parametro");//si
		$this->var->add_param("$id_moneda");//si
		$this->var->add_param("$id_presupuesto");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo $this->var->query;
		exit ();*/
		
		/*return $res;
	}*/
	
	
}?>