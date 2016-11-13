<?php
/**
 * Nombre de la clase:	cls_DBCorrespondencia.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tfl_tfl_correspondencia
 * Autor:				(autogenerado)
 * Fecha creación:		2011-02-11 10:52:58
 */

 
class cls_DBCorrespondencia
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
	
	function SubirArchivoCorrespondencia($id_correspondencia,$url_archivo,$extension,$accion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_iud';
		if($accion=='admin_upload')
			$this->codigo_procedimiento = "'FL_SUARCHADM_UPD'";
		else
			$this->codigo_procedimiento = "'FL_SUARCH_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correspondencia);
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
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param_array("NULL");//id_correspondencia_asociada
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarCorrespondenciaEnviada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro){
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estat_sel';
		$this->codigo_procedimiento = "'FL_CORENV_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cant_tipo','int4');
		$this->var->add_def_cols('tipo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarCorrespondenciaRecibida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro){
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estat_sel';
		$this->codigo_procedimiento = "'FL_CORREC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cant_tipo','int4');
		$this->var->add_def_cols('tipo','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarDocumentoEnviado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro){
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estat_sel';
		$this->codigo_procedimiento = "'FL_DOCENV_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cant_doc','int4');
		$this->var->add_def_cols('documento','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ListarDocumentoRecibido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro){
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_estat_sel';
		$this->codigo_procedimiento = "'FL_DOCREC_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('cant_doc','int4');
		$this->var->add_def_cols('documento','varchar');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}

	function ListarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_circuito_sel';
		$this->codigo_procedimiento = "'FL_CORRCIR_SEL'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($id_correspondencia);
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_corr_origen','int4');
		$this->var->add_def_cols('numero_origen','varchar');
		$this->var->add_def_cols('url_archivo_origen','varchar');
		$this->var->add_def_cols('desc_empleado_origen','text');
		$this->var->add_def_cols('desc_instit_origen','varchar');
		$this->var->add_def_cols('desc_persona_origen','text');
		$this->var->add_def_cols('desc_unidad_origen','varchar');
		$this->var->add_def_cols('fecha_origen','date');
		$this->var->add_def_cols('nivel_origen','int4');
		$this->var->add_def_cols('id_corr_destino','int4');
		$this->var->add_def_cols('numero_destino','varchar');
		$this->var->add_def_cols('url_archivo_destino','varchar');
		$this->var->add_def_cols('desc_empleado_destino','text');
		$this->var->add_def_cols('desc_instit_destino','varchar');
		$this->var->add_def_cols('desc_persona_destino','text');
		$this->var->add_def_cols('desc_unidad_destino','varchar');
		$this->var->add_def_cols('fecha_destino','date');
		$this->var->add_def_cols('nivel_destino','int4');
		
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		return $res;
	}
	
	function ContarCorrespondenciaCircuito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_circuito_sel';
		$this->codigo_procedimiento = "'FL_CORRCIR_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";
		
		$this->var->add_param($id_correspondencia);
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
	 * Nombre de la función:	ListarCorrespondencia
	 * Propósito:				Desplegar los registros de tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function ListarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_sel';
		
		if($vista=='recibido' || $vista=='recibido_archivado')
			$this->codigo_procedimiento = "'FL_CORREC_SEL'";
		elseif ($vista=='externo_recibido'||$vista=='externo_derivado'||$vista=='detalle_externo')
			$this->codigo_procedimiento = "'FL_CORRECEX_SEL'";
		elseif($vista=='enviado')
			$this->codigo_procedimiento = "'FL_CORENV_SEL'";
		elseif ($vista=='detalle')
			$this->codigo_procedimiento = "'FL_CORDET_SEL'";
		elseif($vista=='administracion')
			$this->codigo_procedimiento = "'FL_CORADM_SEL'";
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
		$this->var->add_param("NULL");

	
		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('id_depto','int4');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('id_documento','int4');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_uo','integer');
		$this->var->add_def_cols('desc_uo','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_persona','int4');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('referencia','text');
		$this->var->add_def_cols('fecha_origen','date');
		$this->var->add_def_cols('fecha_destino','date');
		$this->var->add_def_cols('hora_destino','time');
		$this->var->add_def_cols('desc_usuario','text');
		$this->var->add_def_cols('fecha_reg','text');
		$this->var->add_def_cols('id_tipo_accion','integer');
		$this->var->add_def_cols('nombre_tipo_accion','varchar');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('url_archivo','varchar');
		$this->var->add_def_cols('empleado_remitente','varchar');
		$this->var->add_def_cols('uo_remitente','varchar');
		$this->var->add_def_cols('id_correspondencia_fk','integer');
		$this->var->add_def_cols('padre','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('mensaje','text');
		$this->var->add_def_cols('acciones','varchar');
		$this->var->add_def_cols('observaciones','text');
		$this->var->add_def_cols('observaciones_estado','text');
		$this->var->add_def_cols('derivado','varchar');
		$this->var->add_def_cols('dias_derivado','integer');
		$this->var->add_def_cols('fecha_derivado','varchar');
		$this->var->add_def_cols('cite','varchar');
		$this->var->add_def_cols('ver','integer');
		$this->var->add_def_cols('id_nivel_seguridad','integer');
		$this->var->add_def_cols('desc_nivel_seguridad','varchar');
		$this->var->add_def_cols('nivel_prioridad','varchar');
		$this->var->add_def_cols('fecha_max_res','date');
		$this->var->add_def_cols('sw_responsable','varchar');
		
		if ($vista=='enviado' || $vista=='administracion'){
		  $this->var->add_def_cols('id_correspondencia_asociada','integer[]');
		  $this->var->add_def_cols('asociadas','text');
		}

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
	 * Nombre de la función:	ListarCorrespondencia
	 * Propósito:				Desplegar los registros de tfl_correspondencia
	 * Autor:				    Rensi Arteaga cOPARI
	 * Fecha de creación:		2011-02-27 10:52:58
	 */
	function ListarCorrespondenciaMail($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_sel';
		$this->codigo_procedimiento = "'FL_CORRESMAIL_SEL'";
		

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
		$this->var->add_param("NULL");

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('tipo','varchar');
		$this->var->add_def_cols('desc_depto','varchar');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('desc_documento','varchar');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('desc_uo_origen','varchar');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('desc_persona','text');
		$this->var->add_def_cols('referencia','text');
	    $this->var->add_def_cols('desc_empleado_des','text');
		$this->var->add_def_cols('email1','varchar');
		$this->var->add_def_cols('mensaje','text');
		$this->var->add_def_cols('nombre_accion','varchar');
		$this->var->add_def_cols('sw_responsable','varchar');
		$this->var->add_def_cols('fecha_max_res','text');
		$this->var->add_def_cols('prioridad','varchar');
		
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
	 * Nombre de la función:	ListarCorrespondenciaPDF
	 * Propósito:				Desplegar los registros de tfl_correspondencia
	 * Autor:				    Silvia Ximena Ortiz Fernández
	 * Fecha de creación:		2011-03-01
	 */
	function ListarCorrespondenciaPDF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_sel';
		$this->codigo_procedimiento = "'FL_CORREC_REP'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";

		//Carga los parámetros específicos de la estructura programática
		$this->var->add_param($func->iif($id_financiador == '','NULL',$id_financiador));//id_financiador
		$this->var->add_param($func->iif($id_regional == '','NULL',$id_regional));//id_regional
		$this->var->add_param($func->iif($id_programa == '','NULL',$id_programa));//id_programa
		$this->var->add_param($func->iif($id_proyecto == '','NULL',$id_proyecto));//id_proyecto
		$this->var->add_param($func->iif($id_actividad == '','NULL',$id_actividad));//id_actividad
		$this->var->add_param($func->iif($id_correspondencia == '','NULL',$id_correspondencia));//id_correspondencia
		

		//Carga la definición de columnas con sus tipos de datos
		//$this->var->add_def_cols('id_correspondencia','int4');
		$this->var->add_def_cols('numero','varchar');
		$this->var->add_def_cols('fecha_destino','text');
		$this->var->add_def_cols('hora_destino','time');
		$this->var->add_def_cols('documento','varchar');

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
	 * Nombre de la función:	ContarCorrespondencia
	 * Propósito:				Contar los registros de tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function ContarCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_sel';

		if($vista=='recibido' || $vista=='recibido_archivado')
			$this->codigo_procedimiento = "'FL_CORREC_COUNT'";
		elseif ($vista=='externo_recibido'||$vista=='externo_derivado'||$vista=='detalle_externo')
			$this->codigo_procedimiento = "'FL_CORRECEX_COUNT'";
		else if($vista=='enviado')
			$this->codigo_procedimiento = "'FL_CORENV_COUNT'";
		elseif ($vista=='detalle')
			$this->codigo_procedimiento = "'FL_CORDET_COUNT'";
		elseif($vista=='administracion')
			$this->codigo_procedimiento = "'FL_CORADM_COUNT'";
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
		$this->var->add_param("NULL");

		
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
	 * Nombre de la función:	InsertarCorrespondencia
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function InsertarCorrespondencia($id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$id_correspondencia_asociada,$id_nivel_seguridad)
	{
		
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_iud';
		
		if($accion_proceso=='nuevo_recibido')
			$this->codigo_procedimiento = "'FL_CORREC_INS'";
		else if($accion_proceso=='nuevo_enviado')
			$this->codigo_procedimiento = "'FL_CORENV_INS'";
		elseif ($accion_proceso=='nuevo_detalle')
			$this->codigo_procedimiento = "'FL_CORDET_INS'";
		elseif ($accion_proceso=='nuevo_administracion')
			$this->codigo_procedimiento = "'FL_CORADM_INS'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($id_depto);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_uo);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$referencia'");
		$this->var->add_param("'$fecha_origen'");
		$this->var->add_param("'$fecha_destino'");
		$this->var->add_param("'$hora_destino'");
		$this->var->add_param($id_tipo_accion);
		$this->var->add_param("'".stripslashes($empleados)."'");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$nuevo'");
		$this->var->add_param("'$mensaje'");
		$this->var->add_param("'$accion_proceso'");
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		$this->var->add_param($id_correspondencia_fk);
		$this->var->add_param("'$acciones'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$observaciones_estado'");
		$this->var->add_param("'$cite'");
		$this->var->add_param("$id_nivel_seguridad");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		if(isset($id_correspondencia_asociada)){
		$this->var->add_param_array($id_correspondencia_asociada);
		}
		else{
			$this->var->add_param_array("NULL");//id_correspondencia_asociada
		}
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//		var_dump($this->query);
		//echo $this->query;
		//exit;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarCorrespondencia
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function ModificarCorrespondencia($id_correspondencia,$id_depto,$id_documento,$id_empleado,$id_uo,$id_institucion,$id_persona,$referencia,$fecha_origen,$fecha_destino,$hora_destino,$id_tipo_accion,$empleados,$tipo,$nuevo,$mensaje,$accion_proceso,$url_archivo,$extension,$id_correspondencia_fk,$acciones,$observaciones,$observaciones_estado,$cite,$id_nivel_seguridad,$nivel_prioridad,$fecha_max_res,$id_correspondencia_asociada)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_iud';
		
		if($accion_proceso=='modificar_recibido')
			$this->codigo_procedimiento = "'FL_CORREC_UPD'";
		else if($accion_proceso=='modificar_enviado')
			$this->codigo_procedimiento = "'FL_CORENV_UPD'";
		elseif ($accion_proceso=='modificar_detalle')
			$this->codigo_procedimiento = "'FL_CORDET_UPD'";
		elseif ($accion_proceso=='modificar_administracion')
			$this->codigo_procedimiento = "'FL_CORADM_UPD'";
		elseif ($accion_proceso=='finalizar_recepcion')
			$this->codigo_procedimiento = "'FL_CORRECFIN_UPD'";
		elseif ($accion_proceso=='reenviar')
			$this->codigo_procedimiento = "'FL_CORDERV_UPD'";
		elseif ($accion_proceso=='finalizar_reenvio')
			$this->codigo_procedimiento = "'FL_CORFINDERV_UPD'";
		elseif ($accion_proceso=='finalizar_envio')
			$this->codigo_procedimiento = "'FL_CORENVFIN_UPD'";
		elseif ($accion_proceso=='registrar_recepcion')
			$this->codigo_procedimiento = "'FL_CORRECREG_UPD'";
		elseif($accion_proceso=='corregir_registro')
			$this->codigo_procedimiento = "'FL_CORRECCOR_UPD'";
		elseif($accion_proceso=='corregir_enviado')
			$this->codigo_procedimiento = "'FL_CORRECENV_UPD'";
		elseif($accion_proceso=='archivar')
			$this->codigo_procedimiento = "'FL_CORREARC_UPD'";
		elseif($accion_proceso=='cambiar_fecha')
			$this->codigo_procedimiento = "'FL_CORFEC_UPD'";
		elseif($accion_proceso=='revertir_envio')
			$this->codigo_procedimiento = "'FL_CORANU_UPD'";
		elseif($accion_proceso=='desarchivar')
			$this->codigo_procedimiento = "'FL_CORDESARC_UPD'";
		
			
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correspondencia);
		$this->var->add_param($id_depto);
		$this->var->add_param($id_documento);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_uo);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_persona);
		$this->var->add_param("'$referencia'");
		$this->var->add_param("'$fecha_origen'");
		$this->var->add_param("'$fecha_destino'");
		$this->var->add_param("'$hora_destino'");
		$this->var->add_param($id_tipo_accion);
		$this->var->add_param("'".stripslashes($empleados)."'");
		$this->var->add_param("'$tipo'");
		$this->var->add_param("'$nuevo'");
		$this->var->add_param("'$mensaje'");
		$this->var->add_param("'$accion_proceso'");
		$this->var->add_param("'$url_archivo'");
		$this->var->add_param("'$extension'");
		$this->var->add_param($id_correspondencia_fk);
		$this->var->add_param("'$acciones'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$observaciones_estado'");
		$this->var->add_param("'$cite'");
		$this->var->add_param("$id_nivel_seguridad");
		$this->var->add_param("'$nivel_prioridad'");
		$this->var->add_param("'$fecha_max_res'");
        if($accion=='modificar_enviado' && isset($id_correspondencia_asociada)){
		    $this->var->add_param_array($id_correspondencia_asociada);
		}
		else{
			$this->var->add_param_array("NULL");//id_correspondencia_asociada
		}
		
		
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;*/
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarCorrespondencia
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function EliminarCorrespondencia($id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_iud';
		$this->codigo_procedimiento = "'FL_CORRES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correspondencia);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param_array("NULL");//id_correspondencia_asociada
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	/**
	 * Nombre de la función:	MarcarResponsable
	 * Propósito:				Permite definir un responsable para la posible respuesta de la correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function MarcarResponsable($id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_correspondencia_iud';
		$this->codigo_procedimiento = "'FL_MARRES_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_correspondencia);
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
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param_array("NULL");//id_correspondencia_asociada
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	
	function PlanillaCorrespondencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia,$var)
	{
		//echo $var; exit;
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_plantilla_correspondencia';
		$this->codigo_procedimiento = "'FL_PLAN_CORR'";
		
		$func = new cls_funciones();	//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";		
		$this->var->add_param($id_correspondencia);
		$this->var->add_param($var);

		if($var == 1)
		{
			//Carga la definición de columnas con sus tipos de datos
			$this->var->add_def_cols('nombre_cargo','varchar');
			$this->var->add_def_cols('empleado','text');
			$this->var->add_def_cols('estado','varchar');
			$this->var->add_def_cols('nivel_academico','varchar');
		}
		else 
		{
			//Carga la definición de columnas con sus tipos de datos
			$this->var->add_def_cols('institucion','varchar');
			$this->var->add_def_cols('nombre','varchar');
			$this->var->add_def_cols('apellido_paterno','varchar');
			$this->var->add_def_cols('apellido_materno','varchar');
			$this->var->add_def_cols('estado','varchar');
		}
				
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;
	}
	
	function CargoEmpleadoRem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_obtener_cargo_emp_remit';
		$this->codigo_procedimiento = "'FL_CARGO_EMPREM'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";		
		$this->var->add_param($id_empleado);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre_cargo','varchar');
		$this->var->add_def_cols('nivel_academico','varchar');
						
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;
	}
	
	function TipoDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_documento)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_obtener_tipo_doc';
		$this->codigo_procedimiento = "'FL_TIPDOC'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";		
		$this->var->add_param($id_documento);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('codigo','varchar');
						
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo $this->query; exit;
		
		return $res;
	}
	
	function AccionesCorr($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_correspondencia)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tfl_plantilla_corr_acciones';
		$this->codigo_procedimiento = "'FL_PLAN_CORACC'";
		
		$func = new cls_funciones();//Instancia de las funciones generales
		
		//Instancia la clase middle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento);

		//Carga los parámetros del filtro
		$this->var->cant = $cant;
		$this->var->puntero = $puntero;
		$this->var->sortcol = "'$sortcol'";
		$this->var->sortdir = "'$sortdir'";
		$this->var->criterio_filtro = "'$criterio_filtro'";		
		$this->var->add_param($id_correspondencia);

		//Carga la definición de columnas con sus tipos de datos
		$this->var->add_def_cols('nombre','varchar');
						
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
	 * Nombre de la función:	ValidarCorrespondencia
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tfl_correspondencia
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2011-02-11 10:52:58
	 */
	function ValidarCorrespondencia($operacion_sql,$id_correspondencia,$id_depto,$id_documento,$id_empleado_origen,$id_uo_origen,$id_institucion,$id_persona,$referencia,$fecha_origen,$hora_origen,$fecha_destino,$hora_destino,$observaciones,$observaciones_estado,$mensaje)
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
				//Validar id_correspondencia - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_correspondencia");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_correspondencia", $id_correspondencia))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar id_depto - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_depto");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_depto", $id_depto))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_documento - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_documento");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_documento", $id_documento))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar id_institucion - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_institucion");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_institucion", $id_institucion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_persona - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_persona");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_persona", $id_persona))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar referencia - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("referencia");
			$tipo_dato->set_MaxLength(800);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "referencia", $referencia))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar referencia - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(800);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar referencia - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones_estado");
			$tipo_dato->set_MaxLength(800);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones_estado", $observaciones_estado))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar referencia - tipo text
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("mensaje");
			$tipo_dato->set_MaxLength(800);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "mensaje", $mensaje))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar fecha_origen - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_origen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_origen", $fecha_origen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validar fecha_destino - tipo date
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("fecha_destino");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoDate(), "fecha_destino", $fecha_destino))
			{
				$this->salida = $valid->salida;
				return false;
			}

			

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_correspondencia - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_correspondencia");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_correspondencia", $id_correspondencia))
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