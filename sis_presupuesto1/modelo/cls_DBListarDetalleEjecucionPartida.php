<?php
/**
 * Nombre de la clase:	cls_DBDestino.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tpr_tpr_destino
 * Autor:				(autogenerado)
 * Fecha creación:		2008-07-04 08:54:28
 */

 
class cls_DBListarDetalleEjecucionPartida 
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
	function ListarRDEPComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO_SEL'";

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
		
		return $res;
	}
	
	//comprometido desde rendiciones
	function ListarRDEPComprometido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
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
		
		return $res;
	}
	//comprometidos desde contabilidad
	function ListarRDEPComprometido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO3_SEL'";

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
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//comprometidos desde adquisiciones
	function ListarRDEPComprometido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO4_SEL'";

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
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	function ListarRDEPComprometido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO5_SEL'";

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
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	function ListarRDEPComprometido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO6_SEL'";

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
		$this->var->add_def_cols('nro_documento','text');
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
		
		return $res;
	}
	
	//comprometido desde solicitudes de viatico, efectivo, fondo en avance y cajas 
	function ListarRDEPComprometidoT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDOT_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	//comprometido desde rendiciones
	function ListarRDEPComprometido2T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO2T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
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
		
		return $res;
	}
	//comprometidos desde contabilidad
	function ListarRDEPComprometido3T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO3T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//comprometidos desde adquisiciones
	function ListarRDEPComprometido4T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO4T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		echo $this->var->query; 
		exit ();
		}*/
		return $res;
	}
	function ListarRDEPComprometido5T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO5T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		
		return $res;
	}
	
	function ListarRDEPComprometido6T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO6T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		
		return $res;
	}
	
	function ListarRDEPComprometido7T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO7T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		
		return $res;
	}
	
	function ListarRDEPComprometido8T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_COMPROMETIDO8T_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
	/*if($_SESSION['ss_id_usuario']==131){
		echo $this->var->query; 
		exit ();
		}*/
		
		return $res;
	}
	
	//Revertido de solicitudes de viaticos, fondos en avanve y efectivo
	function ListarRDEPRevertido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
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
		
		return $res;
	}
	//Revertidos desde rendiciones de viaticos, fondos en avance y efectivo
	function ListarRDEPRevertido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO2_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
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
		
		return $res;
	}
	//revertidos desde contabilidad
	function ListarRDEPRevertido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO3_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//revertidos desde adquisiciones
	function ListarRDEPRevertido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO4_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//Revertidos desde adquisiciones con el id_partida_ejecucion_as
	function ListarRDEPRevertido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO5_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	function ListarRDEPRevertido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_REVERTIDO6_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
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
		
		return $res;
	}
	//Devengados desde solicitudes de viaticos, fondos en avance y efectivo
	function ListarRDEPDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_tts_caja_arqueo_sel';
		//$this->codigo_procedimiento = "'TS_ANEXO1_ARQUEO_SEL'";
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//if ($_SESSION['ss_id_usuario']==131){
		/*echo $this->var->query;
		exit ();}
		*/
		return $res;
	}
	//devengados desde rendiciones de viaticos, fondos en avance y efectivo
	function ListarRDEPDevengado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_tts_caja_arqueo_sel';
		//$this->codigo_procedimiento = "'TS_ANEXO1_ARQUEO_SEL'";
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO2_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	//devengados desde contabilidad
	function ListarRDEPDevengado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO3_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//devengados desde adquisiciones
	function ListarRDEPDevengado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO4_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//Devengados desde adquisiciones con el id_partida_ejecucion_as
	function ListarRDEPDevengado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO5_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	
	function ListarRDEPDevengado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO6_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	function ListarRDEPDevengado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO7_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	
	function ListarRDEPDevengado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_DEVENGADO8_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');	
		$this->var->add_def_cols('concepto','text');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');	
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if($_SESSION['ss_id_usuario']==131){
		echo $this->var->query;
		exit ();
		}*/
		
		return $res;
	}
	
	//Pagados desde solcitudes de viatico, fondos en avance y efectivo
	function ListarRDEPPagado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	//Pagados desde rendiciones de viaticos, fondos en avance y efectivo
	function ListarRDEPPagado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO2_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	//pagados desde contabilidad
	function ListarRDEPPagado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO3_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//pagado desde adquisiciones
	function ListarRDEPPagado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO4_SEL'";


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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
		$this->var->add_def_cols('fecha_eje','text');	
		$this->var->add_def_cols('importe','numeric');		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION['ss_id_usuario']==131)
		{
		   echo $this->var->query;
		   exit ();
         }*/     		   
		return $res;
	}
	//Pagado desde solcitudes de adquisiciones de la gestion anterior, 
	function ListarRDEPPagado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO5_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
		$this->var->add_def_cols('concepto','varchar');
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
		
		return $res;
	}
	//Pagado desde solcitudes de pagos devengados, 
	function ListarRDEPPagado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO6_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','text');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	//Pagado desde planillas de sueldos 
	function ListarRDEPPagado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO7_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','varchar');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','text');	
		$this->var->add_def_cols('motivo','varchar');
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
		
		return $res;
	}
	
	//Pagado otros
	function ListarRDEPPagado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";		
		$this->nombre_funcion = 'f_tpr_listar_det_eje_partida';
		$this->codigo_procedimiento = "'PR_PAGADO8_SEL'";

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
		$this->var->add_param("'$id_presupuesto'");//si
		$this->var->add_param("$id_partida");//si
		$this->var->add_param("'$fecha_ini'");//si		
		$this->var->add_param("'$fecha_fin'");//si		

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('sistema','varchar');
		$this->var->add_def_cols('nro_documento','integer');
		$this->var->add_def_cols('fecha_doc','text');	
		$this->var->add_def_cols('solicitante','varchar');	
		$this->var->add_def_cols('motivo','varchar');	
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
		
		return $res;
	}
	
}?>