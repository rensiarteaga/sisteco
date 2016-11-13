<?php
/**
 * Nombre de la clase:	cls_DBProcesoCompra.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_proceso_compra
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		2008-05-13 18:03:04
 */

 
class cls_DBProcesoCompra
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
	 * Nombre de la función:	ListarProcesoCompra
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	
	
	function ListarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{

		
	    $this->salida = "";
		//$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->nombre_funcion = 'f_tad_lista_procesos';
		$this->codigo_procedimiento = "'AD_PROCOM_SEL'";

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
		/*$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad*/
		
		$this->var->add_param($func->iif($criterio_filtro == '',"'0=0'","'$criterio_filtro'"));//
		$this->var->add_param($_SESSION["ss_id_usuario"]);//
		$this->var->add_param("'$sortcol'");//
		$this->var->add_param($cant);//
			$this->var->add_param($puntero);//
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('desc_categoria_adq','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('num_proceso','int4');
		$this->var->add_def_cols('siguiente_estado','varchar');
		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('fecha_proc','date');//
		$this->var->add_def_cols('id_tipo_adq','int4');
		$this->var->add_def_cols('desc_tipo_adq','varchar');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('id_proceso_compra_ant','integer');
		$this->var->add_def_cols('num_convocatoria','integer');
		//$this->var->add_def_cols('num_proceso_sis','integer');
		//$this->var->add_def_cols('num_cotizacion_sis','integer');
		$this->var->add_def_cols('id_cotizacion','integer');
		$this->var->add_def_cols('id_moneda_base','integer');
		$this->var->add_def_cols('proceso_cotizado','integer');
		$this->var->add_def_cols('proceso_adjudicado','integer');
		$this->var->add_def_cols('ejecutado','varchar');
		$this->var->add_def_cols('observaciones_acta','varchar');
		
		$this->var->add_def_cols('cantidad_sol','bigint');
		$this->var->add_def_cols('cant_se_adjudica','bigint');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('avance','varchar');
		$this->var->add_def_cols('pago_variable','varchar');
		$this->var->add_def_cols('sgte_gestion','int4');
		$this->var->add_def_cols('con_ppto_sgte_gestion','int4');
		$this->var->add_def_cols('gestion_ppto','int4');
		
		
		$this->var->add_def_cols('usuario_reg','text');
		$this->var->add_def_cols('hora_reg','time');
		$this->var->add_def_cols('es_item','integer');
		
		//$res = $this->var->exec_query();
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//        echo $this->query;
//        exit;
   	   /* if($_SESSION["ss_id_usuario"]==120){
	        echo $this->query;
	        exit;
	     }*/
		return $res;
	}
	
//	function ListarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//	    $this->salida = "";
//		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
//		$this->codigo_procedimiento = "'AD_PROCOM_SEL'";
//
//		$func = new cls_funciones();//Instancia de las funciones generales
//		
//		//Instancia la clase middle para la ejecución de la función de la BD
//		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);
//
//		//Carga los parámetros del filtro
//		$this->var->cant = $cant;
//		$this->var->puntero = $puntero;
//		$this->var->sortcol = "'$sortcol'";
//		$this->var->sortdir = "'$sortdir'";
//		$this->var->criterio_filtro = "'$criterio_filtro'";
//
//		//Carga los parámetros específicos de la estructura programática
//		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
//		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
//		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
//		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
//		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad
//
//		//Carga la definición de columnas con sus tipos de datos
//		$this->var->add_def_cols('id_proceso_compra','int4');
//		$this->var->add_def_cols('observaciones','varchar');
//		$this->var->add_def_cols('codigo_proceso','varchar');
//		$this->var->add_def_cols('fecha_reg','date');
//		$this->var->add_def_cols('estado_vigente','varchar');
//		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
//		$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');
//		$this->var->add_def_cols('id_categoria_adq','int4');
//		$this->var->add_def_cols('desc_categoria_adq','varchar');
//		$this->var->add_def_cols('id_moneda','int4');
//		$this->var->add_def_cols('desc_moneda','varchar');
//		$this->var->add_def_cols('num_cotizacion','int4');
//		$this->var->add_def_cols('num_proceso','int4');
//		$this->var->add_def_cols('siguiente_estado','varchar');
//		$this->var->add_def_cols('periodo','int4');
//		$this->var->add_def_cols('gestion','int4');
//		$this->var->add_def_cols('fecha_proc','date');
//		$this->var->add_def_cols('id_tipo_adq','int4');
//		$this->var->add_def_cols('desc_tipo_adq','varchar');
//		$this->var->add_def_cols('tipo_adq','varchar');
//		$this->var->add_def_cols('lugar_entrega','varchar');
//		$this->var->add_def_cols('id_proceso_compra_ant','integer');
//		$this->var->add_def_cols('num_convocatoria','integer');
//		//$this->var->add_def_cols('num_proceso_sis','integer');
//		//$this->var->add_def_cols('num_cotizacion_sis','integer');
//		$this->var->add_def_cols('id_cotizacion','integer');
//		$this->var->add_def_cols('id_moneda_base','integer');
//		$this->var->add_def_cols('proceso_cotizado','integer');
//		$this->var->add_def_cols('proceso_adjudicado','integer');
//		$this->var->add_def_cols('ejecutado','varchar');
//		$this->var->add_def_cols('observaciones_acta','text');
//		$this->var->add_def_cols('cantidad_sol','bigint');
//		$this->var->add_def_cols('cant_se_adjudica','bigint');
//		$this->var->add_def_cols('num_sol_por_proc','varchar');
//		$this->var->add_def_cols('id_depto','int4');
//		$this->var->add_def_cols('avance','varchar');
//		$this->var->add_def_cols('pago_variable','varchar');
//		$this->var->add_def_cols('sgte_gestion','bigint');
//		$this->var->add_def_cols('con_ppto_sgte_gestion','bigint');
//		$this->var->add_def_cols('gestion_ppto','numeric');
//		//Ejecuta la función de consulta
//		
//		$res = $this->var->exec_query();
//
//		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
//		$this->salida = $this->var->salida;
//
//		//Obtiene la cadena con que se llamó a la función de postgres
//		$this->query = $this->var->query;
//      /*  echo $this->query;
//        exit;*/
//		return $res;
//	}
	
	/**
	 * Nombre de la función:	ContarProcesoCompra
	 * Propósito:				Contar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ContarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PROCOM_COUNT'";

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
//echo $this->salida;
//exit;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function VerificarDatosReversion($criterio_filtro)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_VEREVAR_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = 0;
		$this->var->puntero = 0;
		$this->var->sortcol = "'0'";
		$this->var->sortdir = "'0'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('comp_pg','numeric');
		$this->var->add_def_cols('eje_pg','numeric');
		$this->var->add_def_cols('comp_sg','numeric');
		$this->var->add_def_cols('eje_sg','numeric');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función
		$this->salida = $this->var->salida;

		//Si la ejecución fue satisfactoria modifica la salida para que solo devuelva el total de la consulta
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//Retorna el resultado de la ejecución
		return $res;
	}
	
		/**
	 * Nombre de la función:	ListarProcesoCompraMul
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ListarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PROCOMUL_SEL'";

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
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('desc_categoria_adq','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('num_proceso','int4');
		$this->var->add_def_cols('siguiente_estado','varchar');
		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('fecha_proc','date');
		$this->var->add_def_cols('id_tipo_adq','int4');
		$this->var->add_def_cols('desc_tipo_adq','varchar');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('id_proceso_compra_ant','integer');
		$this->var->add_def_cols('num_convocatoria','integer');
		$this->var->add_def_cols('id_parametro_adquisicion','integer');
		$this->var->add_def_cols('id_periodo','integer');
		$this->var->add_def_cols('norma','varchar');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('pago_variable','varchar');
		
		$this->var->add_def_cols('desc_depto','text');//adicionado 26sep11: un usr tiene mas de un depto de compro
		$this->var->add_def_cols('es_item','integer'); //jun2015
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	 /**
	 * Nombre de la función:	ListarProcesoCompraMul
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
			
			
	
	function ContarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PROCOMUL_COUNT'";

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
		
	

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	/**
	 * Nombre de la función:	InsertarProcesoCompra
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function InsertarProcesoCompra($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$lugar_entrega)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOM_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$codigo_proceso'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($id_moneda);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($num_proceso);
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function RevPresVariable($id_proceso_compra,$importe_rev_aa,$importe_rev_as)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_REVPREVAR_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param($importe_rev_aa);//importe_revertir_aa
		$this->var->add_param($importe_rev_as);//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/*function InsertarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOMUL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$codigo_proceso'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($id_moneda);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($num_proceso);
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param($fecha_proc);
		$this->var->add_param($id_tipo_adq);
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param($id_parametro_adquisicion);//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("'$norma'");//$norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}*/
	
	function InsertarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOMUL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$codigo_proceso'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($id_moneda);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($num_proceso);
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param("'$fecha_proc'");
		$this->var->add_param($id_tipo_adq);
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param($id_parametro_adquisicion);//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("'$norma'");//$norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("'$pago_variable'");//pago_variable
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;
		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query; 
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarProcesoCompra
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ModificarProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOM_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
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
		//$this->var->add_param($id_tipo_adq);
		$this->var->add_param("NULL");
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarProcesoCompra
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ModificarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOMUL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$codigo_proceso'");
		$this->var->add_param("'$fecha_reg'");
		$this->var->add_param("'$estado_vigente'");
		$this->var->add_param($id_tipo_categoria_adq);
		$this->var->add_param($id_moneda);
		$this->var->add_param($num_cotizacion);
		$this->var->add_param($num_proceso);
		$this->var->add_param("'$siguiente_estado'");
		$this->var->add_param($periodo);
		$this->var->add_param($gestion);
		$this->var->add_param("'$fecha_proc'");
		$this->var->add_param($id_tipo_adq);
		$this->var->add_param("'$lugar_entrega'");
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param($id_parametro_adquisicion);//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("'$norma'");//$norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("'$pago_variable'");//pago_variable
		
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarProcesoCompra
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function EliminarProcesoCompra($id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOM_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
		/**
	 * Nombre de la función:	EliminarProcesoCompra
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function EliminarProcesoCompraMul($id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_PROCOMUL_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param("NULL");//fecha_proc
		$this->var->add_param("NULL");//id_tipo_adq
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function AnularProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_ANUPRO_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function IniciarProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_FINDEFPRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
		/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function IniciarProcesoCompraSim($id_proceso_compra,$observaciones,$id_comprador,$tipo_recibo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_FINDEFPROSIM'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param($id_comprador);//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("'$tipo_recibo'");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
		
	/**
	 *se utiliza para verificar si un proceso ya inicio una nueva convocatoria
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function VerificarSiguienteConvocatoria($id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_VERICONV'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
		/**
	 *se utiliza para iniciar una nueva convocatoria
	 * 
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function NuevaConvocatoria($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_NUECONV'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("'$observaciones'");
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 *se utiliza para finaliza un proceso de compra
	 * 
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function FinalizarProcesoCompra($id_proceso_compra){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_FINPRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
		/**
	 *se utiliza para finaliza un proceso de compra
	 * 
	 *
	 * @param unknown_type $id_proceso_compra
	 * @return unknown
	 */
	function RevertirPresupuestoProceso($id_proceso_compra){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_REVPRE_PRO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param($_SESSION["ss_id_empresa"]);//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
		/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ListarRepProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REPROC_SEL'";

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
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('nombre','varchar');
		$this->var->add_def_cols('nombre_moneda','varchar');
		$this->var->add_def_cols('num_proceso','text');
	//	$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('num_convocatoria','int4');
		$this->var->add_def_cols('tipo_adq','varchar');
	//	$this->var->add_def_cols('moneda','varchar');
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
	/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    Ana maria villegas	 
	 * Fecha de creación:		2008-05-13 18:03:04
 	 * Fecha ultima de modificación: 03/06/2009
 	 */
	function ListarRepProcesoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REPRDE_SEL'";

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
		$this->var->add_def_cols('id_proceso_compra_det','integer');
		$this->var->add_def_cols('id_item','integer');
		$this->var->add_def_cols('id_servicio','integer');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('abreviatura','varchar');
		
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

		/**funciones para el reporte lista de compras
	 * Nombre de la función:	ListarProcesoRep
	 * Propósito:				Desplegar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ListarRepProcesoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REPRDS_SEL'";

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
		$this->var->add_def_cols('num_solicitud','text');
		$this->var->add_def_cols('nombre_unidad','varchar');
		$this->var->add_def_cols('nombre_solicitante','text');
		$this->var->add_def_cols('cantidad_solicitada','numeric');
		$this->var->add_def_cols('precio_unitario','numeric');
		$this->var->add_def_cols('monto_aprobadol','numeric');
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
	 * Nombre de la función:	ValidarProcesoCompra
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ValidarProcesoCompra($operacion_sql,$id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis)
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
				//Validar id_proceso_compra - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_proceso_compra");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra", $id_proceso_compra))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(25000);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar codigo_proceso - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("codigo_proceso");
			$tipo_dato->set_MaxLength(20);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "codigo_proceso", $codigo_proceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar fecha_reg - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_reg");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_reg", $fecha_reg))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_vigente - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_vigente");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_vigente", $estado_vigente))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_categoria_adq - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_categoria_adq");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_categoria_adq", $id_tipo_categoria_adq))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar num_cotizacion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("num_cotizacion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "num_cotizacion", $num_cotizacion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar num_proceso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("num_proceso");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "num_proceso", $num_proceso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar siguiente_estado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("siguiente_estado");
			$tipo_dato->set_MaxLength(18);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "siguiente_estado", $siguiente_estado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar periodo - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("periodo");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "periodo", $periodo))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar gestion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("gestion");
			$tipo_dato->set_AllowBlank(false);
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "gestion", $gestion))
			{
				$this->salida = $valid->salida;
				return false;
			}


			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_proceso_compra - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proceso_compra");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra", $id_proceso_compra))
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
	
	/**
	 * Reporte: Memorandum de jsutificacion de nueva convocatoria
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
	 * @return unknown
	 */
	function RepNuevaConvocatoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REPNCONV_SEL'";

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
		$this->var->add_def_cols('codigo','text');
		$this->var->add_def_cols('num_convocatoria_sig','int');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('num_convocatoria','int');
		$this->var->add_def_cols('num_proceso','text');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('gestion','integer');
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	
	function RepEvaluacionPropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REEVPR_SEL'";

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
		
		$this->var->add_def_cols('codigo_proceso','text');
		$this->var->add_def_cols('num_convocatoria','integer');
		$this->var->add_def_cols('fecha_literal','text');
		$this->var->add_def_cols('descripcion','text');
		$this->var->add_def_cols('num_proceso','text');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('gestion','integer');
		
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
//		return $res;
	}
	
	function RepEvaluacionPropuestaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_EVPRDE_SEL'";

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
		$this->var->add_def_cols('proveedor','text');
		$this->var->add_def_cols('monto_literal','text');
		
		
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	
	function RepProveedores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_rep_sel';
		$this->codigo_procedimiento = "'AD_REPPRO_SEL'";

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
		$this->var->add_def_cols('proveedor','text');
			
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	/*
	function ListarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_lista_procesos_dir';
		$this->codigo_procedimiento = "'AD_PRODIR_SEL'";

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

		$this->var->add_param($func->iif($criterio_filtro == '',"'0=0'","'$criterio_filtro'"));//
		$this->var->add_param($_SESSION["ss_id_usuario"]);//
		$this->var->add_param("'$sortcol'");//
		$this->var->add_param($cant);//
		$this->var->add_param($puntero);//

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('num_proceso','int4');

		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('fecha_proc','date');
		$this->var->add_def_cols('id_tipo_adq','int4');

		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('id_comprador','integer');
		$this->var->add_def_cols('comprador','text');
		$this->var->add_def_cols('monto_proceso','numeric');
		$this->var->add_def_cols('cantidad_cotizaciones','bigint');
		$this->var->add_def_cols('cantidad_rendiciones','bigint');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('tipo_recibo','varchar');
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		//$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('no_adjudicado','varchar');
		$this->var->add_def_cols('id_cuenta_doc','integer');
		$this->var->add_def_cols('id_tipo_categoria_adq','integer');
		$this->var->add_def_cols('hora_reg','time');
		$this->var->add_def_cols('usuario_reg','text');
		//Ejecuta la función de consulta
//		$res = $this->var->exec_query();
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo  $this->query;
//exit;
		return $res;
	}
	*/
	function ListarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		//$this->nombre_funcion = 'f_tad_proceso_compra_sel';
			$this->nombre_funcion = 'f_tad_lista_procesos_dir';
		$this->codigo_procedimiento = "'AD_PRODIR_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		
		$this->var->add_param($func->iif($criterio_filtro == '',"'0=0'","'$criterio_filtro'"));//
		$this->var->add_param($_SESSION["ss_id_usuario"]);//
		$this->var->add_param("'$sortcol'");//
		$this->var->add_param($cant);//
		$this->var->add_param($puntero);//
		

		//Carga los parámetros específicos de la estructura programática
		/*$this->var->add_param($func->iif($id_financiador == '',"'%'","'$id_financiador'"));//id_financiador
		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad*/

		//Carga la definición de columnas con sus tipos de datos
		/*$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_tipo_categoria_adq','int4');
		$this->var->add_def_cols('desc_tipo_categoria_adq','varchar');
		$this->var->add_def_cols('id_categoria_adq','int4');
		$this->var->add_def_cols('desc_categoria_adq','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('num_proceso','int4');
		$this->var->add_def_cols('siguiente_estado','varchar');
		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('fecha_proc','date');
		$this->var->add_def_cols('id_tipo_adq','int4');
		$this->var->add_def_cols('desc_tipo_adq','varchar');
		$this->var->add_def_cols('tipo_adq','varchar');
		$this->var->add_def_cols('lugar_entrega','varchar');
		$this->var->add_def_cols('id_proceso_compra_ant','integer');
		$this->var->add_def_cols('num_convocatoria','integer');
	
		$this->var->add_def_cols('id_cotizacion','integer');
		$this->var->add_def_cols('id_moneda_base','integer');
		$this->var->add_def_cols('proceso_cotizado','integer');
		$this->var->add_def_cols('proceso_adjudicado','integer');
		$this->var->add_def_cols('ejecutado','varchar');
		$this->var->add_def_cols('observaciones_acta','text');
		$this->var->add_def_cols('cantidad_sol','bigint');
		$this->var->add_def_cols('cant_se_adjudica','bigint');
		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('id_comprador','integer');
		$this->var->add_def_cols('comprador','text');
		$this->var->add_def_cols('monto_proceso','numeric');
		$this->var->add_def_cols('cantidad_cotizaciones','bigint');
		$this->var->add_def_cols('cantidad_rendiciones','bigint');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('tipo_recibo','varchar');
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('no_adjudicado','varchar');
		$this->var->add_def_cols('id_cuenta_doc','integer');
		*/
		
		
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('fecha_reg','date');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('num_cotizacion','int4');
		$this->var->add_def_cols('num_proceso','int4');

		$this->var->add_def_cols('periodo','int4');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('fecha_proc','date');
		$this->var->add_def_cols('id_tipo_adq','int4');

		$this->var->add_def_cols('id_caja','integer');
		$this->var->add_def_cols('caja','varchar');
		$this->var->add_def_cols('id_cajero','integer');
		$this->var->add_def_cols('cajero','text');
		$this->var->add_def_cols('id_comprador','integer');
		$this->var->add_def_cols('comprador','text');
		$this->var->add_def_cols('monto_proceso','numeric');
		$this->var->add_def_cols('cantidad_cotizaciones','bigint');
		$this->var->add_def_cols('cantidad_rendiciones','bigint');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('tipo_recibo','varchar');
		$this->var->add_def_cols('id_caja_regis','int4');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		//$this->var->add_def_cols('id_depto','integer');
		$this->var->add_def_cols('no_adjudicado','varchar');
		$this->var->add_def_cols('id_cuenta_doc','integer');
		$this->var->add_def_cols('id_tipo_categoria_adq','integer');
		$this->var->add_def_cols('hora_reg','time');
		$this->var->add_def_cols('usuario_reg','text');
		//oct2015
		$this->var->add_def_cols('es_item','integer');
		
		//Ejecuta la función de consulta
		//$res = $this->var->exec_query();
$res = $this->var->exec_query_sss();
		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo  $this->query;
//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProcesoCompra
	 * Propósito:				Contar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ContarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PRODIR_COUNT'";

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

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	function InsertarValeProcesoCompra($id_proceso_compra,$id_caja,$id_cajero,$id_comprador)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_dir_iud';
		$this->codigo_procedimiento = "'AD_PROVAL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param($id_caja);
		$this->var->add_param($id_cajero);
		$this->var->add_param($id_comprador);
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	function FinalizarProcesoCompraDir($id_proceso_compra,$id_empresa){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_dir_iud';
		$this->codigo_procedimiento = "'AD_PRODIR_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_empresa);
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	
	
	function ListarSolicitantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_solicitante_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_SOLICPRO_SEL'";

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
		$this->var->add_param($id_proceso_compra);//id_actividad

		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	
	
	function ListarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
	    $this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_fin_sel';
		$this->codigo_procedimiento = "'AD_PROFIN_SEL'";

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
		$this->var->add_param($id_proceso_compra);//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		
		
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('proveedor','text');
		$this->var->add_def_cols('impuestos','int4');
		$this->var->add_def_cols('num_factura','bigint');
		$this->var->add_def_cols('fecha_factura','date');
		$this->var->add_def_cols('cantidad_sol','numeric');
		$this->var->add_def_cols('cant_total','numeric');
		$this->var->add_def_cols('id_moneda','int4');
		$this->var->add_def_cols('simbolo','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarProcesoCompra
	 * Propósito:				Contar los registros de tad_proceso_compra
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 18:03:04
	 */
	function ContarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_fin_sel';
		$this->codigo_procedimiento = "'AD_PROFIN_COUNT'";

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
        $this->var->add_param($id_proceso_compra);//id_actividad
		
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
//echo $this->salida;
//exit;

		//Retorna el resultado de la ejecución
		return $res;
	}
	
	
	
	
	function ListarComprometido($id_proceso_compra)
	{
	    $this->salida = "";
		$this->nombre_funcion = 'f_ad_importes_sgte_gestion_sel';
		$this->codigo_procedimiento = "NULL";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
//		$this->var->cant = $cant;
//		$this->var->puntero = $puntero;
//		$this->var->sortcol = "'$sortcol'";
//		$this->var->sortdir = "'$sortdir'";
//		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($id_proceso_compra);//id_financiador
//		$this->var->add_param($func->iif($id_regional == '',"'%'","'$id_regional'"));//id_regional
//		$this->var->add_param($func->iif($id_programa == '',"'%'","'$id_programa'"));//id_programa
//		$this->var->add_param($func->iif($id_proyecto == '',"'%'","'$id_proyecto'"));//id_proyecto
//		$this->var->add_param($func->iif($id_actividad == '',"'%'","'$id_actividad'"));//id_actividad

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('precio_referencial_total_as','numeric');
		$this->var->add_def_cols('id_partida_sgte','int4');
		$this->var->add_def_cols('id_partida_actual','int4');
		$this->var->add_def_cols('desc_partida_sgte','text');
		$this->var->add_def_cols('desc_partida_actual','text');
		//Ejecuta la función de consulta
		
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
      /*  echo $this->query;
        exit;*/
		return $res;
	}

	
	function ComprometerPresupuesto($id_proceso_compra){
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_iud';
		$this->codigo_procedimiento = "'AD_COMPPTO'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_proceso_compra);
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
		$this->var->add_param("NULL");//id_empresa
		$this->var->add_param("NULL");//id_comprador
		$this->var->add_param("NULL");//id_parametro_adquisicion
		$this->var->add_param("NULL");//tipo_recibo
		$this->var->add_param("NULL");//norma
		$this->var->add_param("NULL");//importe_revertir_aa
		$this->var->add_param("NULL");//importe_revertir_as
		$this->var->add_param("NULL");//pago_variable
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	function ListarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{

		
	    $this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PROFINALIZ_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
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
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('codigo_proceso','varchar');
		$this->var->add_def_cols('proveedor','text');
		$this->var->add_def_cols('total_adj','numeric');
		$this->var->add_def_cols('nro_contrato','varchar');
		$this->var->add_def_cols('estado_vigente','varchar');
		$this->var->add_def_cols('orden_compra','text');
		$this->var->add_def_cols('num_sol_por_proc','varchar');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('gestion','int4');
		$this->var->add_def_cols('id_periodo_oc','int4');//
		$this->var->add_def_cols('num_oc','int4');
		$this->var->add_def_cols('id_cotizacion','integer');
		$this->var->add_def_cols('estado_proceso','varchar');
		$this->var->add_def_cols('por_adelanto','numeric');
		$this->var->add_def_cols('depto','varchar');
		//$res = $this->var->exec_query();
		$res = $this->var->exec_query();


		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//        echo $this->query;
//        exit;
		return $res;
	}

	function ContarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_proceso_compra_sel';
		$this->codigo_procedimiento = "'AD_PROFINALIZ_COUNT'";

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

		//Retorna el resultado de la ejecución
		return $res;
	}
	
}?>
