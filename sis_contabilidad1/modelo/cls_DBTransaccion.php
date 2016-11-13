<?php
/**
 * Nombre de la clase:	cls_DBTransaccion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tct_tct_transaccion
 * Autor:				(autogenerado)
 * Fecha creación:		2008-09-16 17:57:07
 */

 
class cls_DBTransaccion
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
	 * Nombre de la función:	ListarRegistroTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 * Fecha de modificacion:   2009/06/09
	 */
	function ListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_REGTRA_SEL'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_transaccion','INTEGER');//0
		$this->var->add_def_cols('id_comprobante','INTEGER');//1
		$this->var->add_def_cols('desc_comprobante','VARCHAR');//2
		$this->var->add_def_cols('id_fuente_financiamiento','INTEGER');//3
		$this->var->add_def_cols('desc_fuente_financiamiento','varchar');//4
		$this->var->add_def_cols('id_fina_regi_prog_proy_acti','INTEGER');//5
		$this->var->add_def_cols('epe','text');//6
		$this->var->add_def_cols('id_unidad_organizacional','INTEGER');//7
		$this->var->add_def_cols('desc_unidad_organizacional','varchar');//8
		$this->var->add_def_cols('id_cuenta','INTEGER');//9
		$this->var->add_def_cols('desc_cuenta','text');//10
		$this->var->add_def_cols('id_partida','INTEGER');//11
		$this->var->add_def_cols('desc_partida','text');//12
		$this->var->add_def_cols('id_auxiliar','INTEGER');//13
		$this->var->add_def_cols('desc_auxiliar','VARCHAR');//14
		$this->var->add_def_cols('id_orden_trabajo','INTEGER');//15
		$this->var->add_def_cols('desc_orden_trabajo','varchar');//16
		$this->var->add_def_cols('id_oec','INTEGER');//17
		$this->var->add_def_cols('nombre_oec','varchar');//18
		$this->var->add_def_cols('concepto_tran','varchar');//19
		$this->var->add_def_cols('id_moneda','integer');//20
		$this->var->add_def_cols('desc_moneda','varchar');//21
		$this->var->add_def_cols('fecha_trans','date');//22
		$this->var->add_def_cols('tipo_cambio','numeric');//23
		$this->var->add_def_cols('importe_debe','numeric');//24
		$this->var->add_def_cols('importe_haber','numeric');//25
		$this->var->add_def_cols('id_presupuesto','integer');//26
		$this->var->add_def_cols('tipo_pres','numeric');//27
		$this->var->add_def_cols('sw_aux','numeric');//28
		$this->var->add_def_cols('sw_oec','numeric');//29
		$this->var->add_def_cols('sw_de_ha','numeric');//30
		$this->var->add_def_cols('nro_cuenta','varchar');//31
		$this->var->add_def_cols('importe_ejecucion','numeric');//32
		$this->var->add_def_cols('codigo_uniorg','text');//33
		$this->var->add_def_cols('cod_desc_auxiliar','text');//34
		$this->var->add_def_cols('nom_moneda_sel','varchar');//35
		$this->var->add_def_cols('importe_haber_cs','numeric');//36
		$this->var->add_def_cols('importe_debe_cs','numeric');//37
		$this->var->add_def_cols('simbolo_moneda_cs','varchar');//38
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;
		
		return $res;
	}	
	/**
	 * Nombre de la función:	ListarGestionarRegistroTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 * Fecha de modificacion:   2009/06/09
	 */
	function ListarGestionarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{    
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_REGTRA_SEL2'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_transaccion','INTEGER');//0
		$this->var->add_def_cols('id_comprobante','INTEGER');//1
		$this->var->add_def_cols('desc_comprobante','VARCHAR');//2
		$this->var->add_def_cols('id_partida_cuenta','BIGINT');//3
		$this->var->add_def_cols('desc_partida_cuenta','TEXT');//4
		$this->var->add_def_cols('id_auxiliar','INTEGER');//5
		$this->var->add_def_cols('desc_auxiliar','text');//6
		$this->var->add_def_cols('id_orden_trabajo','INTEGER');//7
		$this->var->add_def_cols('desc_orden_trabajo','varchar');//8
		$this->var->add_def_cols('id_oec','INTEGER');//9
		$this->var->add_def_cols('nombre_oec','varchar');//10
		$this->var->add_def_cols('concepto_tran','varchar');//10
		$this->var->add_def_cols('importe_debe','numeric');//11
		$this->var->add_def_cols('importe_haber','numeric');//12
		$this->var->add_def_cols('importe_gasto','numeric');//13
		$this->var->add_def_cols('importe_recurso','numeric');//14
		$this->var->add_def_cols('id_presupuesto','integer');//15
		$this->var->add_def_cols('desc_presupuesto','TEXT');//16
		$this->var->add_def_cols('tipo_pres','VARCHAR');//17
		$this->var->add_def_cols('sw_aux','numeric');//18
		$this->var->add_def_cols('sw_oec','numeric');//19
		$this->var->add_def_cols('sw_de_ha','numeric');//20
		$this->var->add_def_cols('id_partida','INTEGER');//21
		$this->var->add_def_cols('id_cuenta','INTEGER');//22
		$this->var->add_def_cols('id_moneda','INTEGER');//23
		$this->var->add_def_cols('nombre','varchar');//24
		$this->var->add_def_cols('sw_rega','numeric');//25
		$this->var->add_def_cols('disponibilidad','numeric');//26
		$this->var->add_def_cols('importe_gasto_flujo','numeric');//27
		$this->var->add_def_cols('importe_recurso_flujo','numeric');//28
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query;
		//exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarRepComprobanteTransaccion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		2009-07-14 
	 * Fecha ultima de modificación: 22/07/2009
	 */
	function ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_rep_cbte_transaccion';
		$this->codigo_procedimiento = "'CT_REPCBTETRA_SEL'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
		
        $this->var->add_def_cols('id_transaccion',' integer');//0
        $this->var->add_def_cols('codigo_uniorg',' text');//1
        $this->var->add_def_cols('desc_cuenta',' text');//2
        $this->var->add_def_cols('desc_auxiliar',' text'); //3
        $this->var->add_def_cols('importe_ejecucion_s',' numeric');//4
        $this->var->add_def_cols('moneda_simbolo_cs',' varchar');//5
        $this->var->add_def_cols('importe_debe_cs',' numeric (18,2)');//6
        $this->var->add_def_cols('importe_haber_cs',' numeric (18,2)');//7
        $this->var->add_def_cols('moneda_simbolo_s',' varchar');//8
        $this->var->add_def_cols('importe_debe_s ',' numeric (18,2)');//9
        $this->var->add_def_cols('importe_haber_s',' numeric (18,2)'); //10
        $this->var->add_def_cols('concepto_tra',' varchar'); //11
        $this->var->add_def_cols('orden_trabajo',' varchar'); //12
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/* if ($_SESSION["ss_id_usuario"]==120) {echo $this->query;
		exit();}*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarRegistroTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		2008-09-16 17:57:07
	 * Fecha de modificacion:   2009/07/14
	 */
	function MaxTCListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_RETRMA_SEL'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('maximo_tipo_cambio','numeric');
		
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
	 * Nombre de la función:	ContarRegistroTransacion
	 * Propósito:				Contar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ContarRegistroTransacionAnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_REGTRA_ANT_COUNT'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
		
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
		 //echo $this->query; exit; 
		//Retorna el resultado de la ejecución
		return $res;
	}
	/**
	 * Nombre de la función:	ContarRegistroTransacion
	 * Propósito:				Contar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_REGTRA_COUNT'";

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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
		
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
		//echo $this->query;
		//exit; 
		//Retorna el resultado de la ejecución
		return $res;
	}

	/**
	 * Nombre de la función:	ReporteLibroDiarioTransaccion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    ana maria v q
	 * Fecha de creación:		2008-11-16 17:57:07
	 */
	function ReporteLibroDiarioTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_RETRLI_SEL'";

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
		$this->var->add_param('null');//id_actividad
		$this->var->add_param('null');//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_ep','text');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_cuenta','varchar');
		$this->var->add_def_cols('codigo_partida','text');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('nombre_auxiliar','varchar');
		$this->var->add_def_cols('concepto_tran','varchar');
		
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
	
	/**
	 * Nombre de la función:	ReporteTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		2008-09-20 17:57:07
	 */
	function ReporteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_REPTRA_SEL'";

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
	    $this->var->add_param('null');//id_actividad
		$this->var->add_param('null');//id_actividad
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo_ep','text');//0
		$this->var->add_def_cols('nombre_unidad','varchar');//1
		$this->var->add_def_cols('nombre_cuenta','varchar');//2
		$this->var->add_def_cols('codigo_cuenta_auxiliar','text');//3
		$this->var->add_def_cols('importe_debe','numeric');//4
		$this->var->add_def_cols('importe_haber','numeric');//5
		$this->var->add_def_cols('nombre_auxiliar','varchar');//6
		$this->var->add_def_cols('id_moneda','integer');//7
	//	$this->var->add_def_cols('sum_total','numeric');
		
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
	/**
	 * Nombre de la función:	ReporteTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    avq
	 * Fecha de creación:		2008-09-20 17:57:07
	 */
	function ReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_sel';
		$this->codigo_procedimiento = "'CT_LIMADE_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
//echo "(Reporte) id_gestion:".$id_gestion;
//exit;
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
		$this->var->add_def_cols('fecha_cbte','text');
		$this->var->add_def_cols('prefijo','varchar');
		$this->var->add_def_cols('nro_cbte','integer');
		$this->var->add_def_cols('concepto_cbte','varchar');
		$this->var->add_def_cols('tipo_cambio','numeric');
		$this->var->add_def_cols('importe_debe','numeric');
		$this->var->add_def_cols('importe_haber','numeric');
		$this->var->add_def_cols('saldo','numeric');
		$this->var->add_def_cols('id_cuenta','integer');
		//$this->var->add_def_cols('id_auxiliar','integer');
		$this->var->add_def_cols('desc_cuenta','text');
		//$this->var->add_def_cols('desc_auxiliar','text');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*	echo $this->query;
		exit;*/
		return $res;
	}
	
	
	/**
	 * Nombre de la función:	ContarRegistroLibroMayor
	 * Propósito:				Contar los registros de libro mayor
	 * Autor:				    amvq
	 * Fecha de creación:		2008-12-8 17:55:36
	 */
	function ContarReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_libro_mayor_sel';
		$this->codigo_procedimiento = "'CT_LIMADE_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
//echo "(Contar Reporte) id_gestion:".$id_gestion;
//exit;
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

	  /* echo $this->query;
		exit();*/
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	ListarGestionarRegistroTransacion
	 * Propósito:				Desplegar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 * Fecha de modificacion:   2009/06/09
	 */
	function ListarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_TRANLOG_SEL'";
	
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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_transaccion','INTEGER');//0
		$this->var->add_def_cols('desc_presupuesto','text');//1
		$this->var->add_def_cols('desc_partida_cuenta','text');//2
		$this->var->add_def_cols('desc_auxiliar','text');//3
		$this->var->add_def_cols('desc_orden_trabajo','varchar');//4
		$this->var->add_def_cols('concepto_tran','varchar');//5
		$this->var->add_def_cols('importe_debe','numeric');//6
		$this->var->add_def_cols('importe_haber','numeric');//7
		$this->var->add_def_cols('importe_gasto','numeric');//8
		$this->var->add_def_cols('importe_recurso','numeric');//9
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();
	
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
	
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	
		//echo $this->query; exit;
		
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarRegistroTransacion
	 * Propósito:				Contar los registros de tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ContarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_sel';
		$this->codigo_procedimiento = "'CT_TRANLOG_COUNT'";
	
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
		$this->var->add_param($m_id_combrobante);
		$this->var->add_param($m_id_moneda);
	
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
		//echo $this->query;
		//exit;
		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarRegistroTransacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function InsertarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_transaccion_iud';
		$this->codigo_procedimiento = "'CT_REGTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		
		$this->var->add_param("NULL");
		$this->var->add_param("'$concepto_tran'");
		$this->var->add_param("$id_auxiliar");
		$this->var->add_param("$id_comprobante");
		$this->var->add_param("$id_oec");
		$this->var->add_param("$id_orden_trabajo");
			
		$this->var->add_param("$id_partida");
		$this->var->add_param("$id_cuenta");
	 	
		//	$this->var->add_param("$id_partida_cuenta");
		$this->var->add_param("$id_presupuesto");
		$this->var->add_param("$importe_debe");
		$this->var->add_param("$importe_haber");
		$this->var->add_param("$importe_gasto");
		$this->var->add_param("$importe_recurso");
  		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
 		//echo $this->query;exit();
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRegistroTransacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ModificarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_gestionar_transaccion_iud';
		$this->codigo_procedimiento = "'CT_REGTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transaccion);
		$this->var->add_param("'$concepto_tran'");
		$this->var->add_param("$id_auxiliar");
		$this->var->add_param("$id_comprobante");
		$this->var->add_param("$id_oec");
		$this->var->add_param("$id_orden_trabajo");
		
		$this->var->add_param("$id_partida");
		$this->var->add_param("$id_cuenta");
	 
		//$this->var->add_param("$id_partida_cuenta");
		$this->var->add_param("$id_presupuesto");
		$this->var->add_param("$importe_debe");
		$this->var->add_param("$importe_haber");
		$this->var->add_param("$importe_gasto");
		$this->var->add_param("$importe_recurso");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarRegistroTransacion
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function InsertarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans , $importe_ejecucion )
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_iud';
		$this->codigo_procedimiento = "'CT_REGTRA_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
 
		$this->var->add_param("NULL");
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_fuente_financiamiento);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_partida);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param($id_oec);
		$this->var->add_param("'$concepto_tran'");
		$this->var->add_param("$id_fina_regi_prog_proy_acti");
		 
		$this->var->add_param($importe_debe);
		$this->var->add_param($importe_haber);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_trans'");
		$this->var->add_param($tipo_Cambio);
		$this->var->add_param("'$tipo_cambio_origen'");
		$this->var->add_param("$importe_ejecucion");
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
	/*echo $this->query;
	exit();*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarRegistroTransacion
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ModificarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans ,$importe_ejecucion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_iud';
		$this->codigo_procedimiento = "'CT_REGTRA_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transaccion);
		$this->var->add_param($id_comprobante);
		$this->var->add_param($id_fuente_financiamiento);
		$this->var->add_param($id_unidad_organizacional);
		$this->var->add_param($id_cuenta);
		$this->var->add_param($id_partida);
		$this->var->add_param($id_auxiliar);
		$this->var->add_param($id_orden_trabajo);
		$this->var->add_param($id_oec);
		$this->var->add_param("'$concepto_tran'");
		$this->var->add_param("$id_fina_regi_prog_proy_acti");
		$this->var->add_param($importe_debe);
		$this->var->add_param($importe_haber);
		$this->var->add_param($id_moneda);
		$this->var->add_param("'$fecha_trans'");
		$this->var->add_param($tipo_Cambio);
		$this->var->add_param("'$tipo_cambio_origen'");
		$this->var->add_param("$importe_ejecucion");
			
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarRegistroTransacion
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function EliminarRegistroTransacion($id_transaccion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tct_transaccion_iud';
		$this->codigo_procedimiento = "'CT_REGTRA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_transaccion);
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
	 * Nombre de la función:	ValidarRegistroTransacion
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tct_transaccion
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-09-16 17:57:07
	 */
	function ValidarRegistroTransacion($operacion_sql,$id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans )
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
				//Validar id_transaccion - tipo INTEGER
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_transaccion");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion", $id_transaccion))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}
 
			//Validar id_comprobante - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_comprobante");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_comprobante", $id_comprobante))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_fuente_financiamiento - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_fuente_financiamiento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_fuente_financiamiento", $id_fuente_financiamiento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_unidad_organizacional - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_unidad_organizacional");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_unidad_organizacional", $id_unidad_organizacional))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_cuenta - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cuenta");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cuenta", $id_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_partida - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_partida");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_partida", $id_partida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_auxiliar - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_auxiliar");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_auxiliar", $id_auxiliar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_orden_trabajo - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_orden_trabajo");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_orden_trabajo", $id_orden_trabajo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_oec - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_oec");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_oec", $id_oec))
			{
				$this->salida = $valid->salida;
				return false;
			}

				//Validar id_oec - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_moneda");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_moneda",  $id_moneda))
			{
				$this->salida = $valid->salida;
				return false;
			}
			/*//Validar concepto_tran - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("concepto_tran");
			$tipo_dato->set_MaxLength(10000);
			$tipo_dato->set_AllowBlank(true);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "concepto_tran", $concepto_tran))
			{
				$this->salida = $valid->salida;
				return false;
			}//*/
		                
			
						//Validar estado_pres - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_debe");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(65536);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_debe",$importe_debe))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("importe_haber");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(65536);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "importe_haber",$importe_haber))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_transaccion - tipo INTEGER
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_transaccion");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_transaccion", $id_transaccion))
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
}?>