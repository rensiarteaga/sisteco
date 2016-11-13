<?php
/**
 * Nombre de la clase:	cls_DBCotizacionDet.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tad_tad_cotizacion_det
 * Autor:				(autogenerado)
 * Fecha creación:		2008-05-28 17:32:11
 */


class cls_DBCotizacionDet
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
	 * Nombre de la función:	ListarCotizacionDet
	 * Propósito:				Desplegar los registros de tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function ListarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_COTDET_SEL'";

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
		$this->var->add_def_cols('id_cotizacion_det','int4');
		/*$this->var->add_def_cols('tiempo_entrega','varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('garantia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('observado','varchar');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('desc_cotizacion','text');
		$this->var->add_def_cols('id_item_aprobado','int4');
		//$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('id_proceso_compra_det','int4');
		//$this->var->add_def_cols('desc_proceso_compra_det','text');
		$this->var->add_def_cols('estado_reg','varchar');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('item','varchar');
		$this->var->add_def_cols('cantidad_solicitada','numeric');
		//$this->var->add_def_cols('id_item','int4');
		$this->var->add_def_cols('cantidad_adjudicada','numeric');
		$this->var->add_def_cols('id_item_cotizado','int');
		//$this->var->add_def_cols('id_servicio_cotizado','int');
		$this->var->add_def_cols('nombre_cotizado','varchar');

		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('gru','varchar');
		$this->var->add_def_cols('subgrupo','varchar');
		$this->var->add_def_cols('id1','varchar');
		$this->var->add_def_cols('id2','varchar');
		$this->var->add_def_cols('id3','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('monto_aprobado','numeric');
		$this->var->add_def_cols('num_convocatoria','int4');
		$this->var->add_def_cols('id_antiguo','int4');
		$this->var->add_def_cols('id_adjudicacion','int4');*/


		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('cantidad_solicitada','numeric');
		$this->var->add_def_cols('id_item','int4');

		$this->var->add_def_cols('supergrupo','varchar');
		$this->var->add_def_cols('gru','varchar');
		$this->var->add_def_cols('subgrupo','varchar');
		$this->var->add_def_cols('id1','varchar');
		$this->var->add_def_cols('id2','varchar');
		$this->var->add_def_cols('id3','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('garantia','varchar');
		$this->var->add_def_cols('id_item_cotizado','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('tiempo_entrega','varchar');
		$this->var->add_def_cols('observado','varchar');
		$this->var->add_def_cols('item','varchar');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('nombre_cotizado','varchar');
		$this->var->add_def_cols('num_convocatoria','int4');
		$this->var->add_def_cols('id_item_aprobado','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('precio_moneda_cotizada','numeric');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('cant_adj','numeric');
		$this->var->add_def_cols('descripcion_item','varchar');
		$this->var->add_def_cols('registro_adjudicado','numeric');
		$this->var->add_def_cols('reg_cabecera','bigint');
		$this->var->add_def_cols('reformular','bigint');
		$this->var->add_def_cols('precio_cantidad','numeric');
		$this->var->add_def_cols('id_unidad_medida_base','int4');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('especificaciones_tecnicas','text');
		$this->var->add_def_cols('item_adjudicado_en_proceso','bigint');
		$this->var->add_def_cols('id_proceso_compra_det','int4');
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
	 * Nombre de la función:	ContarCotizacionDet
	 * Propósito:				Contar los registros de tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function ContarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_COTDET_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para  la ejecución de la función de la BD
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
	 * ListarCotizacionServDet
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

	function ListarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_COSEDE_SEL'"; //para listar detalles de cotizacion de servicios

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
		$this->var->add_def_cols('id_cotizacion_det','int4');
		//$this->var->add_def_cols('id_solicitud_compra_det','int4');
		$this->var->add_def_cols('servicio','varchar');
		$this->var->add_def_cols('cantidad_solicitada','numeric');
		$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('tipo_servicio','varchar');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('garantia','varchar');
		$this->var->add_def_cols('id_servicio_cotizado','int4');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('tiempo_entrega','varchar');
		$this->var->add_def_cols('observado','varchar');
		$this->var->add_def_cols('codigo','varchar');
		$this->var->add_def_cols('id_cotizacion','int4');
		$this->var->add_def_cols('nombre_cotizado','varchar');
		$this->var->add_def_cols('num_convocatoria','int4');
		$this->var->add_def_cols('id_tipo_servicio','int4');
		$this->var->add_def_cols('estado','varchar');
		$this->var->add_def_cols('id_proceso_compra','int4');
		$this->var->add_def_cols('precio_moneda_cotizada','numeric');
		$this->var->add_def_cols('desc_moneda','varchar');
		$this->var->add_def_cols('cant_adj','numeric');
		$this->var->add_def_cols('registro_adjudicado','numeric');
		$this->var->add_def_cols('reg_cabecera','bigint');
		$this->var->add_def_cols('reformular','bigint');
		$this->var->add_def_cols('precio_cantidad','numeric');
		$this->var->add_def_cols('id_unidad_medida_base','int4');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('especificaciones_tecnicas','text');
		$this->var->add_def_cols('item_adjudicado_en_proceso','bigint');
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




	function ContarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_COSEDE_COUNT'";

		$func = new cls_funciones();//Instancia de las funciones generales

		//Instancia la clase middle para  la ejecución de la función de la BD
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
	 * Nombre de la función:	InsertarCotizacionDet
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function InsertarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_iud';
		$this->codigo_procedimiento = "'AD_COTDET_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("'$tiempo_entrega'");
		$this->var->add_param($precio);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$garantia'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$observado'");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param($id_item_aprobado);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_item_cotizado
		$this->var->add_param("NULL");//id_servicio_cotizado
		$this->var->add_param("NULL");//id_sol_comp_det
		$this->var->add_param("NULL");//retencion

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarCotizacionDet
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function ModificarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado,$id_item_cotizado,$id_servicio_cotizado,$retencion)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_iud';
		$this->codigo_procedimiento = "'AD_COTDET_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param("'$tiempo_entrega'");
		$this->var->add_param($precio);
		$this->var->add_param($cantidad);
		$this->var->add_param("'$garantia'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$observado'");
		$this->var->add_param($id_cotizacion);
		$this->var->add_param($id_item_aprobado);
		$this->var->add_param($id_servicio);
		$this->var->add_param($id_proceso_compra_det);
		$this->var->add_param("'$estado_reg'");
		$this->var->add_param("'$estado'");
		$this->var->add_param("NULL");
		$this->var->add_param($id_item_cotizado);
		$this->var->add_param($id_servicio_cotizado);
		$this->var->add_param("NULL");//id_sol_comp_det
		$this->var->add_param($retencion);//retencion
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
//echo $this->query;
//exit;
		return $res;
	}

	/**
	 * Nombre de la función:	EliminarCotizacionDet
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function EliminarCotizacionDet($id_cotizacion_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_iud';
		$this->codigo_procedimiento = "'AD_COTDET_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_det);
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
		$this->var->add_param("NULL");//id_item_cotiz
		$this->var->add_param("NULL");//id_serv_cotiz
		$this->var->add_param("NULL");//id_sol_comp_det
		$this->var->add_param("NULL");//retencion
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}



	function ModificarCotizacionAdj($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_iud';
		$this->codigo_procedimiento = "'AD_COTADJ_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//precio
		$this->var->add_param("NULL");//cantidad
		$this->var->add_param("NULL");//garantia
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//observado
		$this->var->add_param($id_cotizacion);//id_cotizacion
		$this->var->add_param($id_item_aprobado);//id_item_aprob
		$this->var->add_param($id_servicio);//id_servicio
		$this->var->add_param($id_proceso_compra_det);//id_proceso_compra_det
		$this->var->add_param("NULL");//estado_reg
		$this->var->add_param("NULL");//estado
		$this->var->add_param("$cantidad_adjudicada");//cantidad_adjudicada
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//id_sol_comp_det
		$this->var->add_param("NULL");//retencion
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}



	function ModificarItseCotizado($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada,$id_item_cotizado,$id_servicio_cotizado,$cantidad,$precio,$tiempo_entrega,$garantia,$observaciones,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_iud';
		$this->codigo_procedimiento = "'AD_COISCO_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_cotizacion_det);
		$this->var->add_param("'$tiempo_entrega'");
		$this->var->add_param($precio);//precio
		$this->var->add_param($cantidad);//cantidad
		$this->var->add_param("'$garantia'");//garantia
		$this->var->add_param("'$observaciones'");//observaciones
		$this->var->add_param("NULL");//observado
		$this->var->add_param($id_cotizacion);//id_cotizacion
		$this->var->add_param($id_item_aprobado);//id_item_aprob
		$this->var->add_param($id_servicio);//id_servicio
		$this->var->add_param($id_proceso_compra_det);//id_proceso_compra_det
		$this->var->add_param("NULL");//estado_reg
		$this->var->add_param("NULL");//estado
		$this->var->add_param("$cantidad_adjudicada");//cantidad_adjudicada
		$this->var->add_param($id_item_cotizado);
		$this->var->add_param($id_servicio_cotizado);
		$this->var->add_param($id_solicitud_compra_det);
		$this->var->add_param("NULL");//retencion
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}







	/**
	 * Nombre de la función:	ListarCotizacionDet
	 * Propósito:				Desplegar los registros de tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_RECODE_SEL'";

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

	//	$this->var->add_def_cols('id_item_aprobado','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('nombre','text');
		
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
	 * Nombre de la función:	RepCotizacionDetServicio
	 * Propósito:				Desplegar los registros de tad_cotizacion_det
	 * Autor:				    Ana Maria villegas
	 * Fecha de creación:		2008-07-30 11:16:11
	 */
	function RepCotizacionDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_RECOSER_SEL'";

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

		//$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('nombre','text');
		//$this->var->add_def_cols('descripcion','varchar');

		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		/*echo $this->query;
		exit;
*/
		return $res;
	}
	/**
	 * Nombre de la función:	RepOrdenCompraDet
	 * Propósito:				Desplegar los registros de tad_cotizacion_det
	 * Autor:				    Ana Maria villegas
	 * Fecha de creación:		2008-07-30 11:16:11
	 */
	function RepOrdenCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_REORDE_SEL'";

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

		//$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('precio_total','numeric');

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
	 * Nombre de la función:	RepOrdenCompraDetServicio
	 * Propósito:				Desplegar los registros de tad_cotizacion_det
	 * Autor:				    Ana Maria villegas
	 * Fecha de creación:		2008-07-30 11:16:11
	 */
	function RepOrdenCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tad_cotizacion_det_sel';
		$this->codigo_procedimiento = "'AD_REORSER_SEL'";

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

		//$this->var->add_def_cols('id_servicio','int4');
		$this->var->add_def_cols('cantidad','numeric');
		$this->var->add_def_cols('abreviatura','varchar');
		$this->var->add_def_cols('nombre','text');
		$this->var->add_def_cols('precio','numeric');
		$this->var->add_def_cols('precio_total','numeric');

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
	 * Nombre de la función:	ValidarCotizacionDet
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tad_cotizacion_det
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2008-05-28 17:32:11
	 */
	function ValidarCotizacionDet($operacion_sql,$id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado)
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
				//Validar id_cotizacion_det - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_cotizacion_det");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion_det", $id_cotizacion_det))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar tiempo_entrega - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tiempo_entrega");
			$tipo_dato->set_MaxLength(50);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tiempo_entrega", $tiempo_entrega))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar precio - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("precio");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "precio", $precio))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar cantidad - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("cantidad");
			$tipo_dato->set_MaxLength(1179650);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "cantidad", $cantidad))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar garantia - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("garantia");
			$tipo_dato->set_MaxLength(300);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "garantia", $garantia))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(500);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observado - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observado");
			$tipo_dato->set_MaxLength(2);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observado", $observado))
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

			//Validar id_item_aprobado - tipo int4
			//			$tipo_dato->_reiniciar_valor();
			//			$tipo_dato->set_Columna("id_item_aprobado");
			//			$tipo_dato->set_MaxLength(10);
			//			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_item_aprobado", $id_item_aprobado))
			//			{
			//				$this->salida = $valid->salida;
			//				return false;
			//			}

			//Validar id_servicio - tipo int4
			//			$tipo_dato->_reiniciar_valor();
			//			$tipo_dato->set_Columna("id_servicio");
			//			$tipo_dato->set_MaxLength(10);
			//			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_servicio", $id_servicio))
			//			{
			//				$this->salida = $valid->salida;
			//				return false;
			//			}

			//Validar id_proceso_compra_det - tipo int4
			//			$tipo_dato->_reiniciar_valor();
			//			$tipo_dato->set_Columna("id_proceso_compra_det");
			//			$tipo_dato->set_MaxLength(10);
			//			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proceso_compra_det", $id_proceso_compra_det))
			//			{
			//				$this->salida = $valid->salida;
			//				return false;
			//			}

			//Validar estado_reg - tipo varchar
			//			$tipo_dato->_reiniciar_valor();
			//			$tipo_dato->set_Columna("estado_reg");
			//			$tipo_dato->set_MaxLength(30);
			//			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_reg", $estado_reg))
			//			{
			//				$this->salida = $valid->salida;
			//				return false;
			//			}
			//
			//			//Validar estado - tipo varchar
			//			$tipo_dato->_reiniciar_valor();
			//			$tipo_dato->set_Columna("estado");
			//			$tipo_dato->set_MaxLength(200);
			//			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado", $estado))
			//			{
			//				$this->salida = $valid->salida;
			//				return false;
			//			}

			//Validación de reglas de datos

			//Validar observado
			$check = array ("si","no");
			if(!in_array($observado,$check))
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación en columna 'observado': El valor no está dentro del dominio definido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarCotizacionDet";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}
			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_cotizacion_det - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_cotizacion_det");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_cotizacion_det", $id_cotizacion_det))
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