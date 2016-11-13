<?php
/**
 * Nombre de la clase:	cls_DBComprobante.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_comprobante
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-16 17:55:36
 */

 
class cls_DBComprobante
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
	 * Nombre de la función:	ListarRegistroComprobante
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_REGCOM_SEL'";

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
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('nro_cbte','integer');
	 	$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('glosa_cbte','varchar');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('aprobacion','varchar');
		$this->var->add_def_cols('conformidad','varchar');
		$this->var->add_def_cols('pedido','varchar');
		$this->var->add_def_cols('id_periodo_subsis','integer');
		$this->var->add_def_cols('desc_periodo','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('id_cbte_clase','integer');
		$this->var->add_def_cols('desc_clases','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('titulo_cbte','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_final','date');
		$this->var->add_def_cols('id_moneda_cbte','integer');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('nombre_moneda_cbte','varchar');
		$this->var->add_def_cols('prioridad_moneda_cbte','integer');
		$this->var->add_def_cols('estado_cbte','numeric');
		$this->var->add_def_cols('fk_comprobante','integer');
		$this->var->add_def_cols('fk_desc_cbte','text');
		$this->var->add_def_cols('tipo_relacion','varchar');
		$this->var->add_def_cols('desc_cbte','text');
		$this->var->add_def_cols('sw_activo_fijo','varchar');
		$this->var->add_def_cols('cbtes_depen','bigint');
		$this->var->add_def_cols('variacion_tc','numeric');
		$this->var->add_def_cols('sw_bancariza','varchar');//ago2015
		$this->var->add_def_cols('sw_omite_fe','varchar');//oct2016
		//Ejecuta la función de consulta
		//$res = $this->var->criterio_funcion='0=0';
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	    //echo $this->query;exit();
		/*if ($_SESSION["ss_id_usuario"]==120){
			echo '---'. $this->query;
			exit;
		}*/
		
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ContarRegistroComprobante
	 * Propósito:				Contar los registros de tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ContarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_REGCOM_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

       /* if ($_SESSION["ss_id_usuario"]==131){
			echo $this->query;
			exit;
		}*/	
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	Reporte para Libro Diario Comprobante
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-11-5 8:36:36
	 * Fecha ultima de actualizacion: 28/07/2009
	 */
	function ReporteLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_RELICO_SEL'";

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
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','integer');
	 	$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('nombre_acreedor','varchar');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('desc_clase','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('cheque','text');
		$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('titulo_cbte','varchar');
		$this->var->add_def_cols('t_c','numeric');
		$this->var->add_def_cols('aprobacion','varchar');
		$this->var->add_def_cols('pedido','varchar');
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
	
		/**
	 * Nombre de la función:	ContarLibroDiario
	 * Propósito:				Contar los registros de tct_comprobante
	 * Autor:				    amvq
	 * Fecha de creación:		2008-12-4 17:55:36
	 */
	function ContarLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_RELICO_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

	/*echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}

    /**
	 * Nombre de la función:	ReporteComprobante
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-11-5 8:36:36
	 * Fecha de modificacion    2009-06-12
	 * 							02/02/2010
	 * 
	 */
	function ReporteComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_REPCOM_SEL'";

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
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','integer');
	 	$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('concepto_cbte','text');
		$this->var->add_def_cols('aprobacion','varchar');
		$this->var->add_def_cols('pedido','varchar');
		$this->var->add_def_cols('conformidad','varchar');
		$this->var->add_def_cols('nombre_clase_cbte','varchar');
		$this->var->add_def_cols('sum_total_literal','varchar');
		$this->var->add_def_cols('glosa','varchar');
		$this->var->add_def_cols('fecha','date');
		$this->var->add_def_cols('cod_depto','varchar');
		$this->var->add_def_cols('cheque','text');
		$this->var->add_def_cols('t_c','numeric');
		$this->var->add_def_cols('facturas','text');
		//$this->var->add_def_cols('nombre_encargado','text');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION["ss_id_usuario"]==120) {echo $this->query;
		 exit();}*/
		return $res;
	}
	 /**
	 * Nombre de la función:	GetFirmasComprobante
	 * Propósito:				Obtiene firmas dado el id del comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2009-07-9 
	 
	 * 
	 */
	function GetFirmasComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_get_firmas_cbte';
		$this->codigo_procedimiento = "'CT_GETFIRMA_SEL'";

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
		$this->var->add_param($id_comprobante);//id_actividad
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('desc_firma',' VARCHAR');
		$this->var->add_def_cols('nombre_completo',' TEXT');
		$this->var->add_def_cols('nombre_cargo',' VARCHAR');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
		
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//if ($_SESSION["ss_id_usuario"]==7) {echo $this->query;exit();}
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	Reporte para Libro Mayor la cabecera
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-11-5 8:36:36
	 * 
	 */
	function ReporteLibroMayor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_RELIMA_SEL'";

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
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','text');
		$this->var->add_def_cols('desc_cuenta','varchar');
	 	//$this->var->add_def_cols('nombre_auxiliar','varchar');
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
	
	/**
	 * Nombre de la función:	Reporte para Libro Mayor la cabecera 
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2009-5-6 11:21:36
	 */
/*	function ReporteLibroMayor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_sel';
		$this->codigo_procedimiento = "'CT_LIMAEN_SEL'";

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
	    $this->var->add_param($id_cuenta);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param($id_auxiliar);
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('desc_cuenta','varchar');
	  //Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		echo $this->query;
		exit();
		return $res;
	}*/
	
	/**
	 * Nombre de la función:	Reporte para Libro Mayor la cabecera por auxiliar
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    ana maria
	 * Fecha de creación:		2008-15-5 8:36:36
	 * Fecha de modificación:   27/08/09 
	 */
	function ReporteLibroMayorPorAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar, $id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_sel';
		$this->codigo_procedimiento = "'CT_LIMAEN_SEL'";

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
	    $this->var->add_param($id_cuenta);//id_cuenta
        $this->var->add_param($id_moneda);//id_moneda
        $this->var->add_param("'$fecha_inicio'");
        $this->var->add_param("'$fecha_fin'");
        $this->var->add_param($id_auxiliar);
        $this->var->add_param($id_depto);
        $this->var->add_param("'$cuenta_ini'");
        $this->var->add_param("'$cuenta_fin'");
        $this->var->add_param("'$por_rango'");
        $this->var->add_param($id_gestion);
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_cuenta','text');
		$this->var->add_def_cols('id_auxiliar','integer');
	 	$this->var->add_def_cols('nombre_auxiliar','text');
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
	/**
	 * Nombre de la función:	ContarRegistroLibroMayor
	 * Propósito:				Contar los registros de libro mayor
	 * Autor:				    amvq
	 * Fecha de creación:		2008-12-8 17:55:36
	 */
	function ContarReporteLibroMayor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_rep_sel';
		$this->codigo_procedimiento = "'CT_RELIMA_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	InsertarRegistroComprobante
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function InsertarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$fk_comprobante,$tipo_relacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_iud';
		$this->codigo_procedimiento = "'CT_REGCOM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($nro_cbte);
		$this->var->add_param($momento_cbte);
		$this->var->add_param("'$fecha_cbte'");
		$this->var->add_param("'$concepto_cbte'");
		$this->var->add_param("'$glosa_cbte'");
		$this->var->add_param("'$acreedor'");
		$this->var->add_param("'$aprobacion'");
		$this->var->add_param("'$conformidad'");
		$this->var->add_param("'$pedido'");
		$this->var->add_param($id_periodo_subsis);
		
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_clase_cbte);
		$this->var->add_param($sw_validacion);
		$this->var->add_param($id_depto);
		$this->var->add_param($fk_comprobante);
		$this->var->add_param($tipo_relacion);
 

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*echo "llega a insercion ".$this->query;
exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRegistroComprobante
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ModificarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_iud';
		$this->codigo_procedimiento = "'CT_REGCOM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_parametro);
		$this->var->add_param($nro_cbte);
		$this->var->add_param($momento_cbte);
		$this->var->add_param("'$fecha_cbte'");
		$this->var->add_param("'$concepto_cbte'");
		$this->var->add_param("'$glosa_cbte'");
		$this->var->add_param("'$acreedor'");
		$this->var->add_param("'$aprobacion'");
		$this->var->add_param("'$conformidad'");
		$this->var->add_param("'$pedido'");
		$this->var->add_param($id_periodo_subsis);
		
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_clase_cbte);
		$this->var->add_param($sw_validacion);
		$this->var->add_param($id_depto);
//		$this->var->add_param($fk_comprobante);
//		$this->var->add_param($tipo_relacion);
 
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query ; exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	GestionarAccionesComprobante
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function GestionarAccionesComprobante($accion, $id_coprobante)
	{
		 
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_comprobante_iud';
		if ($accion=='validacion' || $accion=='validacion_igualar') {
			$this->codigo_procedimiento = "'CT_VALIDA_ACC'";
		}else {
			$this->codigo_procedimiento = "'CT_ACCION_ACC'";
		}
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_coprobante);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$accion'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		
        /* if ($_SESSION['ss_id_usuario'])==120) { echo "GestionarRegistroComprobante ".$this->query;
         exit();}*/
		return $res;
	}	
	function InsertarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,$fk_comprobante,$tipo_relacion,$sw_activo_fijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_comprobante_iud';
		$this->codigo_procedimiento = "'CT_REGCOM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_parametro);
		$this->var->add_param($nro_cbte);
		$this->var->add_param($momento_cbte);
		$this->var->add_param("'$fecha_cbte'");
		$this->var->add_param("'$concepto_cbte'");
		$this->var->add_param("'$glosa_cbte'");
		$this->var->add_param("'$acreedor'");
		$this->var->add_param("'$aprobacion'");
		$this->var->add_param("'$conformidad'");
		$this->var->add_param("'$pedido'");
		$this->var->add_param($id_periodo_subsis);
		
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_clase_cbte);
		$this->var->add_param($sw_validacion);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_moneda_cbte);
		$this->var->add_param($tipo_cambio);
		$this->var->add_param("NULL");//id_usuario_mod
		$this->var->add_param($fk_comprobante);
		$this->var->add_param("'$tipo_relacion'");
		$this->var->add_param("'$sw_activo_fijo'");
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		 //echo "InsertarGestionarRegistroComprobante julio  ".$this->query;exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRegistroComprobante
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ModificarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,$fk_comprobante,$tipo_relacion,$sw_activo_fijo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_comprobante_iud';
		$this->codigo_procedimiento = "'CT_REGCOM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_parametro);
		$this->var->add_param($nro_cbte);
		$this->var->add_param($momento_cbte);
		$this->var->add_param("'$fecha_cbte'");
		$this->var->add_param("'$concepto_cbte'");
		$this->var->add_param("'$glosa_cbte'");
		$this->var->add_param("'$acreedor'");
		$this->var->add_param("'$aprobacion'");
		$this->var->add_param("'$conformidad'");
		$this->var->add_param("'$pedido'");
		$this->var->add_param($id_periodo_subsis);
		
		$this->var->add_param($id_subsistema);
		$this->var->add_param($id_clase_cbte);
		$this->var->add_param($sw_validacion);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_moneda_cbte);
		$this->var->add_param($tipo_cambio);
		$this->var->add_param("NULL");//id_usuario_mod
		$this->var->add_param($fk_comprobante);
		$this->var->add_param("'$tipo_relacion'");
		$this->var->add_param("'$sw_activo_fijo'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		//echo "mmodificar julio  ".$this->query;exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRegistroComprobante
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function EliminarRegistroComprobante($id_comprobante,$observacion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_comprobante_iud';
		$this->codigo_procedimiento = "'CT_REGCOM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observacion'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	function ListarComprobanteTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_COMTOTAL_SEL'";

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
	 
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
	 	$this->var->add_def_cols('importe_ejecucion','numeric');
		 
		//$res = $this->var->criterio_funcion='0=0';
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	   	//echo $this->query;exit();
		return $res;
	}
	/**
	 * Nombre de la función:	ListarDatosComprobante
	 * Propósito:				Desplegar información del comprobante
	 * Autor:				    Ana Maria Villegas Quispe
	 * Fecha de creaciónn:		2010-01-12 
	 */
	function ListarDatosComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_COMPLA_SEL'";

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
		//$this->var->add_param($func->iif($id_cotizacion == '',"NULL",$id_cotizacion));//id_cotizacion

		//Carga la definiciï¿½n de columnas con sus tipos de datos
		
		$this->var->add_def_cols('id_comprobante','int');
		$this->var->add_def_cols('id_clase_cbte','int');
		$this->var->add_def_cols('id_moneda','int');
		$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('titulo_cbte','varchar');
		$this->var->add_def_cols('simbolo','varchar');
		//Ejecuta la funciï¿½n de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la funciï¿½n y retorna el resultado de la ejecuciï¿½n
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamï¿½ a la funciï¿½n de postgres
		$this->query = $this->var->query;
		/*if ($_SESSION["ss_id_usuario"]==120){
		echo $this->query;
		exit;
		}*/
		return $res;
	}   
	function HabilitarComprobanteModificacion($id_comprobante,$id_usuario_mod,$justificacion_edicion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ct_habilitar_cbte_modificacion';
		$this->codigo_procedimiento = "'CT_CBTEVA_MOD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_usuario_mod);
		$this->var->add_param("'$justificacion_edicion'");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function MonedaComprobante($id_comprobante,$id_moneda_sola)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ct_habilitar_cbte_modificacion';
		$this->codigo_procedimiento = "'CT_CBTEMONE_MOD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_moneda_sola);
		$this->var->add_param("NULL");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function BorradorComprobante($id_comprobante,$id_usuario_mod)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ct_habilitar_cbte_modificacion';
		$this->codigo_procedimiento = "'CT_CBTEDEL_MOD'";
	
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_usuario_mod);
		$this->var->add_param("NULL");
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	/**
	 * Nombre de la función:	ListaComprobanteLog
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    RCM
	 * Fecha de creación:		23/04/2010
	 */
	function ListarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_CBTEMO_SEL'";

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
		$this->var->add_def_cols('id_comprobante_log','integer');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('id_parametro','integer');
		$this->var->add_def_cols('desc_parametro','numeric');
		$this->var->add_def_cols('nro_cbte','integer');
	 	$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('glosa_cbte','varchar');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('aprobacion','varchar');
		$this->var->add_def_cols('conformidad','varchar');
		$this->var->add_def_cols('pedido','varchar');
		$this->var->add_def_cols('id_periodo_subsis','integer');
		$this->var->add_def_cols('periodo_sub','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('desc_subsistema','varchar');
		$this->var->add_def_cols('id_cbte_clase','integer');
		$this->var->add_def_cols('desc_clases','varchar');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('id_gestion','integer');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('nombre_depto','varchar');
		$this->var->add_def_cols('titulo_cbte','varchar');
		$this->var->add_def_cols('fecha_inicio','date');
		$this->var->add_def_cols('fecha_final','date');
		$this->var->add_def_cols('id_moneda_cbte','integer');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('nombre_moneda_cbte','varchar');
		$this->var->add_def_cols('prioridad_moneda_cbte','integer');
		$this->var->add_def_cols('estado_cbte','numeric');
		//Ejecuta la función de consulta
		//$res = $this->var->criterio_funcion='0=0';
		/*echo $this->var->get_query_sel();
		exit;*/
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
/*	echo $this->query;
		exit();*/
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ContarComprobanteLog
	 * Propósito:				Contar los registros de tct_comprobante
	 * Autor:				    RCM
	 * Fecha de creación:		29/04/2010
	 */
	function ContarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_CBTEMO_COUNT'";

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
		$this->var->add_def_cols('total','bigint');

		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		if($res)
		{
			$this->salida = $this->var->salida[0][0];
		}

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

/*	echo $this->query;
		exit();*/		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	
	function ListarVariosCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_comprobante_sel';
		$this->codigo_procedimiento = "'CT_IMPCBT_SEL'";

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
		$this->var->add_def_cols('fecha_cbte','date');
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('id_clase_cbte','integer');
		$this->var->add_def_cols('id_moneda','integer');
		$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('titulo_cbte','varchar');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('nro_cbte','text');
		$this->var->add_def_cols('codigo_depto','varchar');
		$this->var->add_def_cols('tipo_cbte','text');
		$this->var->add_def_cols('nombre_archivo','text');
	 	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/* echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	DetalleCbte
	 * Propósito:				Desplegar los registros de tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function DetalleCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$id_deptos,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_detalle_cbte_sel';
		$this->codigo_procedimiento = "'CT_DETCBTE_SEL'";

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
		
		$this->var->add_param($id_parametro);
        $this->var->add_param($id_moneda);
        $this->var->add_param("'$id_deptos'");
        $this->var->add_param("'$fecha_ini'");
        $this->var->add_param("'$fecha_fin'");
        
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_comprobante','integer');
		$this->var->add_def_cols('nro_cbte','integer');
	 	$this->var->add_def_cols('momento_cbte','numeric');
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('glosa_cbte','varchar');
		$this->var->add_def_cols('acreedor','varchar');
		$this->var->add_def_cols('aprobacion','varchar');
		$this->var->add_def_cols('conformidad','varchar');
		$this->var->add_def_cols('pedido','varchar');
		$this->var->add_def_cols('id_subsistema','integer');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('id_cbte_clase','integer');
		$this->var->add_def_cols('fk_comprobante','integer');
		$this->var->add_def_cols('nro_cheque','text');
		$this->var->add_def_cols('origen','varchar');
		$this->var->add_def_cols('sw_activo_fijo','varchar');
		$this->var->add_def_cols('sw_actualizacion','varchar');
		$this->var->add_def_cols('depto','text');
		$this->var->add_def_cols('nombre_ep','text');
		$this->var->add_def_cols('desc_presupuesto','text');
		$this->var->add_def_cols('nombre_partida','text');
		$this->var->add_def_cols('nombre_cuenta','text');
		$this->var->add_def_cols('nombre_auxiliar','text');
		$this->var->add_def_cols('cuenta_sigma','varchar');
		$this->var->add_def_cols('nombre_ot','varchar');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('importe_gasto','numeric');
		$this->var->add_def_cols('importe_recurso','numeric');
		
		//Ejecuta la función de consulta
		//$res = $this->var->criterio_funcion='0=0';
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	    //echo $this->query;exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarRegistroComprobante
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_comprobante
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:55:36
	 */
	function ValidarRegistroComprobante($operacion_sql,$id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte, $sw_validacion,$id_depto)
	{
		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();
	
		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_comprobante - tipo integer
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_comprobante");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_parametro - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_parametro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_parametro", $id_parametro))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar id_parametro - tipo integer
		/*	$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}*/

			//Validar nro_cbte - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("nro_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			
			
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "nro_cbte", $nro_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

		 	//Validar momento_cbte - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("momento_cbte");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "momento_cbte", $momento_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validar momento_cbte - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("sw_validacion");
			$tipo_dato->set_MaxLength(65536);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "sw_validacion", $sw_validacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_cbte - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_cbte", $fecha_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar concepto_cbte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto_cbte");
			$tipo_dato->set_MaxLength(1500);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto_cbte", $concepto_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar glosa_cbte - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("glosa_cbte");
			$tipo_dato->set_MaxLength(1500);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "glosa_cbte", $glosa_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar acreedor - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("acreedor");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "acreedor", $acreedor))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar aprobacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("aprobacion");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "aprobacion", $aprobacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar conformidad - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("conformidad");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "conformidad", $conformidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar pedido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("pedido");
			$tipo_dato->set_MaxLength(150);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "pedido", $pedido))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_periodo_subsis - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_periodo_subsis");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_periodo_subsis", $id_periodo_subsis))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_subsistema - tipo integer 
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subsistema");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subsistema", $id_subsistema))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_documento_nro - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_clase_cbte");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_clase_cbte", $id_clase_cbte))
			{
				$this->salida = $valid->salida;
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_comprobante - tipo integer
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_comprobante");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
			{
				$this->salida = $valid->salida;
				return false;
			}
		
			//Validación exitosa
			return true;	
		}
		else
		{
			return false;
		}
	}
	
	//oct2016
	function MarcarCbteFE($id_comprobante,$accion)
	{
			
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_comprobante_iud';
		$this->codigo_procedimiento = "'CT_MARCAEF_UPD'";
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_comprobante);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$accion'");//para cuando sea parcial
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
	
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
	
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
	
	
		//Ejecuta la función
		$res = $this->var->exec_non_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		/*	exit;*/
	
		/* if ($_SESSION['ss_id_usuario'])==120) { echo "GestionarRegistroComprobante ".$this->query;
		 exit();}*/
		return $res;
	}
	
	
}?>