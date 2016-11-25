<?php
/**
 * Nombre de la clase:	cls_DBSalida.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_salida
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-25 15:07:58
 */

class cls_DBSalidaPedido
{
	var $salida;
	var $query;
	var $var;
	var $nombre_funcion;
	var $codigo_procedimiento;
	var $decodificar;

	function __construct()	{
		$this->decodificar=$decodificar;
	}

	/**
	 * Nombre de la función:	ListarSalida
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ListarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PEDIDO_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','varchar');
		$this->var->add_def_cols('correlativo_vale','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('desc_almacen','varchar');
		
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		
		$this->var->add_def_cols('id_financiador','int4');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('id_programa','int4');
		$this->var->add_def_cols('id_proyecto','int4');
		$this->var->add_def_cols('id_actividad','int4');
		
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('receptor','varchar');
		$this->var->add_def_cols('id_tramo_subactividad','integer');
		$this->var->add_def_cols('id_tramo_unidad_constructiva','integer');
		$this->var->add_def_cols('desc_tramo','varchar');
		$this->var->add_def_cols('desc_unidad_cons','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('id_supervisor','integer');
		$this->var->add_def_cols('receptor_ci','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('solicitante_ci','varchar');
		$this->var->add_def_cols('num_contrato','varchar');
		$this->var->add_def_cols('nombre_superv','text');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('id_motivo_salida','integer');
		$this->var->add_def_cols('id_almacen','integer');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
	

		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalida
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PEDIDO_COUNT'";

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
	 * Nombre de la función:	InsertarSalida
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function InsertarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$tipo_pedido,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_PEDIDO_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param($correlativo_sal);
		$this->var->add_param($correlativo_vale);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$contabilizar'");//5
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$motivo_cancelacion'");
		$this->var->add_param($id_responsable_almacen);//10
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_tipo_material);//15
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_subactividad);
		$this->var->add_param($id_motivo_salida_cuenta);
		$this->var->add_param("'$emergencia'");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("'$tipo_pedido'");
		$this->var->add_param("'$receptor'");
		$this->var->add_param($id_tramo_subactividad);
		$this->var->add_param($id_tramo_unidad_constructiva);
		$this->var->add_param("'$fecha_borrador'");//25
		$this->var->add_param("$id_supervisor");
		$this->var->add_param("'$receptor_ci'");
		$this->var->add_param("'$solicitante'");
		$this->var->add_param("'$solicitante_ci'");
		$this->var->add_param("'$num_contrato'");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarSalida
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ModificarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_PEDIDO_UPD'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param($correlativo_sal);
		$this->var->add_param($correlativo_vale);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$motivo_cancelacion'");
		$this->var->add_param($id_responsable_almacen);//10
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_tipo_material);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_subactividad);
		$this->var->add_param($id_motivo_salida_cuenta);
		$this->var->add_param("'$emergencia'");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("NULL");//tipo_pedido
		$this->var->add_param("'$receptor'");//receptor
		$this->var->add_param($id_tramo_subactividad);//id_tramo_subactividad
		$this->var->add_param($id_tramo_unidad_constructiva);//id_tramo_unidad_constructiva
		$this->var->add_param("'$fecha_borrador'");//fecha_borrador
		$this->var->add_param("$id_supervisor");
		$this->var->add_param("'$receptor_ci'");
		$this->var->add_param("'$solicitante'");
		$this->var->add_param("'$solicitante_ci'");
		$this->var->add_param("'$num_contrato'");//30
		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	EliminarSalida
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function EliminarSalidaPedido($id_salida)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_SALIDA_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//5
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//15
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20  //observaciones
		$this->var->add_param("NULL");//tipo_pedido
		$this->var->add_param("NULL");//receptor
		$this->var->add_param("NULL");//id_tramo_subactividad
		$this->var->add_param("NULL");//id_tramo_unidad_constructiva
		$this->var->add_param("NULL");//25
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	FinalizarSalidaPedido
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function FinalizarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_PEDIDO_FIN'";
		
		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param($correlativo_sal);
		$this->var->add_param($correlativo_vale);
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("'$contabilizar'");
		$this->var->add_param("'$contabilizado'");
		$this->var->add_param("'$estado_salida'");
		$this->var->add_param("'$estado_registro'");
		$this->var->add_param("'$motivo_cancelacion'");
		$this->var->add_param($id_responsable_almacen);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param($id_empleado);
		$this->var->add_param($id_firma_autorizada);
		$this->var->add_param($id_contratista);
		$this->var->add_param($id_tipo_material);
		$this->var->add_param($id_institucion);
		$this->var->add_param($id_subactividad);
		$this->var->add_param($id_motivo_salida_cuenta);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//observaciones
		$this->var->add_param("NULL");//tipo_pedido
		$this->var->add_param("NULL");//receptor
		$this->var->add_param("NULL");//id_tramo_subactividad
		$this->var->add_param("NULL");//id_tramo_unidad_constructiva
		$this->var->add_param("NULL");//25
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}
	
	//Salidas Rápidas para Proyectos 02-04-2008 RCM
	/**
	 * Nombre de la función:	ListarSalida
	 * Propósito:				Desplegar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ListarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALIPR_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','text');
		$this->var->add_def_cols('correlativo_vale','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');//13
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('desc_almacen','varchar');
		
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		
		$this->var->add_def_cols('id_financiador','int4');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('id_programa','int4');
		$this->var->add_def_cols('id_proyecto','int4');
		$this->var->add_def_cols('id_actividad','int4');
		
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('receptor','varchar');
		
		$this->var->add_def_cols('receptor_ci','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('solicitante_ci','varchar');
		
		$this->var->add_def_cols('id_tramo_subactividad','integer');
		$this->var->add_def_cols('id_tramo_unidad_constructiva','integer');
		$this->var->add_def_cols('desc_tramo','varchar');
		$this->var->add_def_cols('desc_unidad_cons','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('num_contrato','varchar');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('id_motivo_salida','integer');
		$this->var->add_def_cols('id_almacen','integer');
		$this->var->add_def_cols('id_supervisor','integer');
		$this->var->add_def_cols('nombre_superv','text');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query:".$this->query;
		//exit;
		
		return $res;
	}

	/**
	 * Nombre de la función:	ContarSalida
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ContarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_SALIPR_COUNT'";

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
//Fin salidas rápidas

/**
	 * Nombre de la función:	ListarSalidasFinalizadas
	 * Propósito:				Desplegar los registros de tal_salida 
	 * Autor:				    RCM
	 * Fecha de creación:		18/09/2008
	 */
	function ListarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PEDFIN_SEL'";

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
		$this->var->add_def_cols('id_salida','int4');
		$this->var->add_def_cols('correlativo_sal','text');
		$this->var->add_def_cols('correlativo_vale','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_salida','varchar');
		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('motivo_cancelacion','varchar');
		$this->var->add_def_cols('id_responsable_almacen','int4');
		
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','text');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_tipo_material','int4');
		
		$this->var->add_def_cols('desc_tipo_material','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_subactividad','int4');
		$this->var->add_def_cols('desc_subactividad','varchar');
		$this->var->add_def_cols('id_motivo_salida_cuenta','integer');
		$this->var->add_def_cols('desc_motivo_salida_cuenta','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_salida','varchar');
		$this->var->add_def_cols('desc_almacen','varchar');
		
		$this->var->add_def_cols('nombre_financiador','varchar');
		$this->var->add_def_cols('nombre_regional','varchar');
		$this->var->add_def_cols('nombre_programa','varchar');
		$this->var->add_def_cols('nombre_proyecto','varchar');
		$this->var->add_def_cols('nombre_actividad','varchar');
		
		$this->var->add_def_cols('id_financiador','int4');
		$this->var->add_def_cols('id_regional','int4');
		$this->var->add_def_cols('id_programa','int4');
		$this->var->add_def_cols('id_proyecto','int4');
		$this->var->add_def_cols('id_actividad','int4');
		
		$this->var->add_def_cols('codigo_financiador','varchar');
		$this->var->add_def_cols('codigo_regional','varchar');
		$this->var->add_def_cols('codigo_programa','varchar');
		$this->var->add_def_cols('codigo_proyecto','varchar');
		$this->var->add_def_cols('codigo_actividad','varchar');
		$this->var->add_def_cols('emergencia','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('tipo_pedido','varchar');
		$this->var->add_def_cols('receptor','varchar');
		$this->var->add_def_cols('id_tramo_subactividad','integer');
		$this->var->add_def_cols('id_tramo_unidad_constructiva','integer');
		$this->var->add_def_cols('desc_tramo','varchar');
		$this->var->add_def_cols('desc_unidad_cons','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('id_supervisor','integer');
		$this->var->add_def_cols('receptor_ci','varchar');
		$this->var->add_def_cols('solicitante','varchar');
		$this->var->add_def_cols('solicitante_ci','varchar');
		$this->var->add_def_cols('num_contrato','varchar');
		$this->var->add_def_cols('nombre_superv','text');
		$this->var->add_def_cols('gestion','varchar');
		$this->var->add_def_cols('sw_faltante_tuc','varchar');
	
		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		//echo "query: ".$this->query;
		//exit;
	
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSalida
	 * Propósito:				Contar los registros de tal_salida
	 * Autor:				    RCM
	 * Fecha de creación:		18/09/2008
	 */
	function ContarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_sel';
		$this->codigo_procedimiento = "'AL_PEDFIN_COUNT'";

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
	 * Nombre de la función:	ModificarSalidasFinalizadas
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ModificarSalidasFinalizadas($id_salida,$descripcion,$observaciones,$num_contrato)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_salida_iud';
		$this->codigo_procedimiento = "'AL_MOSAFI_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_salida);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param("NULL");//5
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//15
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$observaciones'");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//25
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$num_contrato'");//30

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ValidarSalida
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_salida
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-25 15:07:58
	 */
	function ValidarSalidaPedido($operacion_sql,$id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$tipo_pedido)
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
				//Validar id_salida - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_salida");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
				{
					$this->salida = $valid->salida;
					return false;
				}
			}

			//Validar correlativo_sal - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_sal");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "correlativo_sal", $correlativo_sal))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar correlativo_vale - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("correlativo_vale");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "correlativo_vale", $correlativo_vale))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar descripcion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("descripcion");
			$tipo_dato->set_MaxLength(200);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "descripcion", $descripcion))
			{
				$this->salida = $valid->salida;
				return false;
			}

			
			//Validar contabilizar - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("contabilizar");
			$tipo_dato->set_MaxLength(2);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "contabilizar", $contabilizar))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_salida - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_salida");
			$tipo_dato->set_MaxLength(18);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_salida", $estado_salida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar estado_registro - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("estado_registro");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "estado_registro", $estado_registro))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar motivo_cancelacion - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("motivo_cancelacion");
			$tipo_dato->set_MaxLength(100);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "motivo_cancelacion", $motivo_cancelacion))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			//Validar id_responsable_almacen - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_responsable_almacen");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_responsable_almacen", $id_responsable_almacen))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_empleado - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_empleado");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_empleado", $id_empleado))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_firma_autorizada - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_firma_autorizada");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_firma_autorizada", $id_firma_autorizada))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_contratista - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_contratista");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_contratista", $id_contratista))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_tipo_material - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_tipo_material");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_tipo_material", $id_tipo_material))
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

			//Validar id_subactividad - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_subactividad");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_subactividad", $id_subactividad))
			{
				$this->salida = $valid->salida;
				return false;
			}
			
			
			//Validar tipo pedido - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("tipo_pedido");
			$tipo_dato->set_MaxLength(30);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "tipo_pedido", $tipo_pedido))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación de reglas de datos

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_salida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='fin')
		{
			//Validar id_salida - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_salida");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_salida", $id_salida))
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