<?php
/**
 * Nombre de la clase:	cls_DBAdjudicacion.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_proceso_compra_det, solicitud_compra_det, grupo_sp_det, solicitud_proceso_compra
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-13 09:57:25
 */

 
class cls_DBAdjudicacion
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
	 * Nombre de la función:	ListarAdjudicacion
	 * Propósito:				Desplegar los registros de tad_cotizacion_det, proceso_compra_det, solicitud_compra_det, grupo_sp_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 09:57:25
	 */
	function ListarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_sel';
		
		if($id_item>0){
			$this->codigo_procedimiento = "'AD_ADJITE_SEL'";
		}else{
			$this->codigo_procedimiento = "'AD_ADJSER_SEL'";
		}

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
		
		$this->var->add_param($func->iif($id_cotizacion== '',"NULL","'$id_cotizacion'"));//id_cotizacion_det
		$this->var->add_param($func->iif($id_item== '',"NULL","'$id_item'"));//id_item
		$this->var->add_param($func->iif($id_servicio== '',"NULL","'$id_servicio'"));//id_servicio

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('cantidad_proceso','numeric');
		$this->var->add_def_cols('precio_ref_proceso','numeric');
		$this->var->add_def_cols('cantidad_solicitada','numeric');
		$this->var->add_def_cols('precio_ref_solicitado','numeric');
		$this->var->add_def_cols('cantidad_cotizada','numeric');
		$this->var->add_def_cols('precio_cotizado','numeric');
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('cantidad_adjudicada','numeric');
		$this->var->add_def_cols('item','varchar');
		$this->var->add_def_cols('reformular','varchar');
		$this->var->add_def_cols('id_cotizado','int4');
		$this->var->add_def_cols('monto_aprobado','numeric');
		$this->var->add_def_cols('id_adjudicacion','int4');
		$this->var->add_def_cols('adjudicado','int4');
		$this->var->add_def_cols('id_cotizacion_det','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('monto_ref_reformulado','numeric');
		$this->var->add_def_cols('periodo','integer');
		$this->var->add_def_cols('num_solicitud','integer');
		$this->var->add_def_cols('motivo_ref','text');
		$this->var->add_def_cols('total_adjudicado_por_detalle','numeric');
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
	 * Nombre de la función:	ContarCaracteristica
	 * Propósito:				Contar los registros de tad_caracteristica
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-13 09:57:25
	 */
	function ContarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_sel';
			
		if($id_item>0){
			$this->codigo_procedimiento = "'AD_ADJITE_COUNT'";
		}else{
			$this->codigo_procedimiento = "'AD_ADJSER_COUNT'";
		}


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
		
		$this->var->add_param($func->iif($id_cotizacion== '',"NULL","'$id_cotizacion'"));//id_cotizacion_det
		$this->var->add_param($func->iif($id_item== '',"NULL","'$id_item'"));//id_item
		$this->var->add_param($func->iif($id_servicio== '',"NULL","'$id_servicio'"));//id_servicio
		
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
	
	
	
	function InsertarReforAdj($id_cotizacion_det,$cantidad_adjudicada,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_solicitada,$monto_aprobado,$reformular,$bandera,$id_adjudicacion,$precio_cotizado,$retencion,$motivo_ref)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_iud';
		if($bandera =='true'){
			
		   $this->codigo_procedimiento = "'AD_ADJUDI_INS'";
		}
		else{
			
		   $this->codigo_procedimiento = "'AD_REFORM_INS'";
		}

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_adjudicacion);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param($cantidad_adjudicada);
		$this->var->add_param($id_item);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item_cotizado);
		$this->var->add_param($id_servicio_cotizado);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param($cantidad_solicitada);
		$this->var->add_param($monto_aprobado);
		$this->var->add_param($precio_cotizado);
		$this->var->add_param("'$reformular'");
		$this->var->add_param($retencion);
		$this->var->add_param("'$motivo_ref'");
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		

		return $res;
	}
	
	
	function AdjudicarDetalle($id_cotizacion,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_iud';
		if($id_item>0){
		   $this->codigo_procedimiento = "'AD_ADTOIT_INS'";
		}
		else{
		   $this->codigo_procedimiento = "'AD_ADTOSE_INS'";//adjudicacion total de servicios 
		}

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param("NULL");
		$this->var->add_param($id_item);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_item_cotizado);
		$this->var->add_param($id_servicio_cotizado);
		$this->var->add_param("NULL");//id_proceso_compra
		$this->var->add_param("NULL");//id_soldet
		$this->var->add_param("NULL");//cant_sol
		$this->var->add_param("NULL");//monto_aprobado
		$this->var->add_param("NULL");//precio_cotiza
		$this->var->add_param("NULL");//reformular
		$this->var->add_param("NULL");//retencion
		$this->var->add_param("NULL");//motivo_ref
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
//		echo $this->query;
//		exit;
		return $res;
	}
	function RepAdjudicacionProceso($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_rep_sel';
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,"");
        
    	$this->var->add_param($id_proceso_compra);//id_item
		$this->var->add_param(null);//id_item
		$this->var->add_param($tipo);//id_servicio

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('proceso', 'varchar');
		$this->var->add_def_cols('categoria','varchar');
		$this->var->add_def_cols('gestion','numeric');
		$this->var->add_def_cols('num_proceso','text');
		$this->var->add_def_cols('observaciones','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
	function RepAdjudicacionProveedores($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_rep_sel';
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,"");
        
    	$this->var->add_param($id_proceso_compra);//id_item
		$this->var->add_param(null);//id_item
		$this->var->add_param($tipo);//id_servicio

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_cotizacion', 'int4');
		$this->var->add_def_cols('proveedor', 'varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('moneda','varchar');
		$this->var->add_def_cols('num_adjudicacion','integer');
		$this->var->add_def_cols('fecha_adjudicacion','date');
		$this->var->add_def_cols('periodo','numeric');
		$this->var->add_def_cols('encargado_adj','text');
		$this->var->add_def_cols('justificacion_adj','text');
		$this->var->add_def_cols('observaciones_adjudicacion','text');
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
			//	echo $this->query; exit;
				return $res;
	}
	
	
	function RepAdjudicacionDet($id_cotizacion,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_adjudicacion_rep_sel';
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,"");
        
    	$this->var->add_param(null);//id_item
		$this->var->add_param($id_cotizacion);//id_item
		$this->var->add_param($tipo);//id_servicio

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('num_solicitud','text');
		$this->var->add_def_cols('item', 'text');
		$this->var->add_def_cols('partida','text');
		$this->var->add_def_cols('precio_adj', 'numeric');
		$this->var->add_def_cols('cantidad_adj','numeric');
		
		
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		return $res;
	}
	
	
//	
//	function ListarCotizacionAdjudicada($id_proceso_compra)
//	{
//		$this->salida = "";
//		$this->nombre_funcion = 'f_ad_cotizacion_adjudicada_sel';
//		
//		$func = new cls_funciones();//Instancia de las funciones generales
//		
//		//Instancia la clase middle para la ejecución de la función de la BD
//		$this->var = new cls_middle($this->nombre_funcion,"");
//        
//    	$this->var->add_param($id_proceso_compra);//id_item
//		
//		
//		$this->var->add_def_cols('id_cotizacion', 'integer');
//	
//		
//		//Ejecuta la función de consulta
//		$res = $this->var->exec_query_sss();
//
//		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
//		$this->salida = $this->var->salida;
//
//		//Obtiene la cadena con que se llamó a la función de postgres
//		$this->query = $this->var->query;
//		
//		return $res;
//	}
	
	
	function ListarCotizacionAdjudicada($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_ad_cotizacion_adjudicada_sel';
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,"");
        
    	$this->var->add_param($id_proceso_compra);//id_item
		$this->var->add_param("'$tipo'");//tipo

		
		$this->var->add_def_cols('id_cotizacion', 'integer');
	
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query_sss();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		echo $this->query;
//		exit;
		return $res;
	}

}?>