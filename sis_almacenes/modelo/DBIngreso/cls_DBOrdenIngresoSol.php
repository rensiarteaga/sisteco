<?php
/**
 * Nombre de la clase:	cls_DBOrdenIngresoSol.php
 * Propósito:			Permite ejecutar toda la funcionalidad de la tabla tal_tal_ingreso
 * Autor:				(autogenerado)
 * Fecha creación:		2007-10-18 18:11:11
 */

class cls_DBOrdenIngresoSol
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
	 * Nombre de la función:	ListarIngreso
	 * Propósito:				Desplegar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ListarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_OINSOL_SEL'";

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
		$this->var->add_def_cols('id_ingreso','int4');
		$this->var->add_def_cols('correlativo_ord_ing','varchar');
		$this->var->add_def_cols('correlativo_ing','varchar');
		$this->var->add_def_cols('descripcion','varchar');
		$this->var->add_def_cols('costo_total','numeric');
		$this->var->add_def_cols('contabilizar','varchar');
		$this->var->add_def_cols('contabilizado','varchar');
		$this->var->add_def_cols('estado_ingreso','varchar');

		$this->var->add_def_cols('estado_registro','varchar');
		$this->var->add_def_cols('cod_inf_tec','varchar');
		$this->var->add_def_cols('resumen_inf_tec','varchar');
		$this->var->add_def_cols('fecha_borrador','date');
		$this->var->add_def_cols('fecha_pendiente','date');
		$this->var->add_def_cols('fecha_aprobado_rechazado','date');
		$this->var->add_def_cols('fecha_ing_fisico','date');
		$this->var->add_def_cols('fecha_ing_valorado','date');
		$this->var->add_def_cols('fecha_finalizado_cancelado','date');
		$this->var->add_def_cols('fecha_reg','date');

		$this->var->add_def_cols('id_responsable_almacen','int4');
		$this->var->add_def_cols('desc_responsable_almacen','varchar');
		$this->var->add_def_cols('id_proveedor','int4');
		$this->var->add_def_cols('desc_proveedor','varchar');
		$this->var->add_def_cols('id_contratista','int4');
		$this->var->add_def_cols('desc_contratista','varchar');
		$this->var->add_def_cols('id_empleado','int4');
		$this->var->add_def_cols('desc_empleado','text');
		$this->var->add_def_cols('id_almacen_logico','int4');
		$this->var->add_def_cols('desc_almacen_logico','varchar');

		$this->var->add_def_cols('id_firma_autorizada','int4');
		$this->var->add_def_cols('desc_firma_autorizada','varchar');
		$this->var->add_def_cols('id_institucion','int4');
		$this->var->add_def_cols('desc_institucion','varchar');
		$this->var->add_def_cols('id_motivo_ingreso_cuenta','int4');
		$this->var->add_def_cols('desc_motivo_ingreso_cuenta','varchar');
		$this->var->add_def_cols('nombre_proveedor','varchar');
		$this->var->add_def_cols('nombre_contratista','varchar');
		$this->var->add_def_cols('nro_cuenta','varchar');
		$this->var->add_def_cols('desc_motivo_ingreso','varchar');

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

		$this->var->add_def_cols('orden_compra','varchar');
		$this->var->add_def_cols('observaciones','varchar');
		$this->var->add_def_cols('id_usuario','integer');
		$this->var->add_def_cols('contabilizar_tipo_almacen','varchar');


		//Ejecuta la función de consulta
		$res = $this->var->exec_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		//echo "sql:".$this->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ContarIngreso
	 * Propósito:				Contar los registros de tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ContarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_sel';
		$this->codigo_procedimiento = "'AL_OINSOL_COUNT'";

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
	 * Nombre de la función:	InsertarIngreso
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function InsertarOrdenIngresoSol($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_OINSOL_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor=='' ? 'NULL' : $id_proveedor);//20
		$this->var->add_param($id_contratista=='' ? 'NULL' : $id_contratista);
		$this->var->add_param($id_empleado=='' ? 'NULL' : $id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion=='' ? 'NULL' : $id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("'$orden_compra'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

/*		print("<pre>");
		print_r($this->salida);
		print( "</pre>");*/

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;

		return $res;
	}

	/**
	 * Nombre de la función:	ModificarIngreso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function ModificarOrdenIngresoSol($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_OINSOL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_ingreso");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor=='' ? 'NULL' : $id_proveedor);//20
		$this->var->add_param($id_contratista=='' ? 'NULL' : $id_contratista);
		$this->var->add_param($id_empleado=='' ? 'NULL' : $id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion=='' ? 'NULL' : $id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("'$orden_compra'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	EliminarIngreso
	 * Propósito:				Permite ejecutar la función de eliminación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function EliminarOrdenIngresoSol($id_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_INGRES_DEL'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	FinalizarOrdenIngresoSol
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function FinalizarOrdenIngresoSol($id_ingreso)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_OINSOL_FIN'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param($id_ingreso);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//10
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//20
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//30
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");//40
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
	 * Nombre de la función:	InsertarOrdenIngresoProy
	 * Propósito:				Permite ejecutar la función de inserción de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 18:11:11
	 */
	function InsertarOrdenIngresoProy($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_OIPROY_INS'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_finalizado_cancelado'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor=='' ? 'NULL' : $id_proveedor);//20
		$this->var->add_param($id_contratista=='' ? 'NULL' : $id_contratista);
		$this->var->add_param($id_empleado=='' ? 'NULL' : $id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion=='' ? 'NULL' : $id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("'$orden_compra'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$num_factura'");
		$this->var->add_param("'$fecha_factura'");//30
		$this->var->add_param("'$responsable'");
		$this->var->add_param("$importacion");
		$this->var->add_param("$flete");
		$this->var->add_param("$seguro");
		$this->var->add_param("$gastos_alm");
		$this->var->add_param("$gastos_aduana");
		$this->var->add_param("$iva");
		$this->var->add_param("$rep_form");
		$this->var->add_param("$peso_neto");
		$this->var->add_param("$id_moneda_import");//40
		$this->var->add_param("$id_moneda_nacionaliz");
		$this->var->add_param("'$dui'");
		$this->var->add_param("$monto_tot_factura");
		$this->var->add_param("NULL");

		//Ejecuta la función
		$res = $this->var->exec_non_query();

		//Obtiene el array de salida de la función y retorna el resultado de la ejecución
		$this->salida = $this->var->salida;

		//Obtiene la cadena con que se llamó a la función de postgres
		$this->query = $this->var->query;
		
		/*echo "query: ".$this->query;
		exit;*/

		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarIngreso
	 * Propósito:				Permite ejecutar la función de modificación de la tabla tal_ingreso
	 * Autor:				    RCM San Borja
	 * Fecha de creación:		13/06/2008
	 */
	function ModificarIngresoProy($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura)
	{
		$this->salida = "";
		$this->nombre_funcion = 'f_tal_ingreso_iud';
		$this->codigo_procedimiento = "'AL_OINSOL_UPD'";

		//Instancia la clase midlle para la ejecución de la función de la BD
		$this->var = new cls_middle($this->nombre_funcion,$this->codigo_procedimiento,$this->decodificar);
		$this->var->add_param("$id_ingreso");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$descripcion'");
		$this->var->add_param($costo_total);
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$cod_inf_tec'");//10
		$this->var->add_param("'$resumen_inf_tec'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param("'$fecha_finalizado_cancelado'");
		$this->var->add_param("NULL");
		$this->var->add_param("NULL");
		$this->var->add_param($id_proveedor=='' ? 'NULL' : $id_proveedor);//20
		$this->var->add_param($id_contratista=='' ? 'NULL' : $id_contratista);
		$this->var->add_param($id_empleado=='' ? 'NULL' : $id_empleado);
		$this->var->add_param($id_almacen_logico);
		$this->var->add_param("NULL");
		$this->var->add_param($id_institucion=='' ? 'NULL' : $id_institucion);
		$this->var->add_param($id_motivo_ingreso_cuenta);
		$this->var->add_param("'$orden_compra'");
		$this->var->add_param("'$observaciones'");
		$this->var->add_param("'$num_factura'");
		$this->var->add_param("'$fecha_factura'");//30
		$this->var->add_param("'$responsable'");
		$this->var->add_param("$importacion");
		$this->var->add_param("$flete");
		$this->var->add_param("$seguro");
		$this->var->add_param("$gastos_alm");
		$this->var->add_param("$gastos_aduana");
		$this->var->add_param("$iva");
		$this->var->add_param("$rep_form");
		$this->var->add_param("$peso_neto");
		$this->var->add_param("$id_moneda_import");//40
		$this->var->add_param("$id_moneda_nacionaliz");
		$this->var->add_param("'$dui'");
		$this->var->add_param("$monto_tot_factura");
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
	 * Nombre de la función:	ValidarIngreso
	 * Propósito:				Permite ejecutar la validación del lado del servidor de la tabla tal_ingreso
	 * Autor:				    (autogenerado)
	 * Fecha de creación:		2007-10-18 20:48:41
	 */
	function ValidarOrdenIngresoSol($operacion_sql,$tipo_orden_ingreso,$id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		//orden_tipo_ingreso: (Compra Local, Importacion, etc.)

		$this->salida = "";
		$valid = new cls_validacion_serv();

		//Clase para validar el tipo de dato
		$tipo_dato = new cls_define_tipo_dato();

		//Ejecuta la validación por el tipo de operación
		if($operacion_sql=='insert' || $operacion_sql=='update')
		{
			if($operacion_sql == 'update')
			{
				//Validar id_ingreso - tipo int4
				$tipo_dato->_reiniciar_valor();
				$tipo_dato->set_MaxLength(10);
				$tipo_dato->set_Columna("id_ingreso");

				if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
				{
					$this->salida = $valid->salida;
					return false;
				}
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

			//Validar costo_total - tipo numeric
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("costo_total");
			$tipo_dato->set_MaxLength(1179650);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoReal(), "costo_total", $costo_total))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_proveedor - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_proveedor");
			$tipo_dato->set_MaxLength(10);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_proveedor", $id_proveedor))
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

			//Validar id_almacen_logico - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_almacen_logico");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_almacen_logico", $id_almacen_logico))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar id_motivo_ingreso_cuenta - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_motivo_ingreso_cuenta");
			$tipo_dato->set_MaxLength(10);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_motivo_ingreso_cuenta", $id_motivo_ingreso_cuenta))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar orden_compra - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("orden_compra");
			$tipo_dato->set_MaxLength(20);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "orden_compra", $orden_compra))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validar observaciones - tipo varchar
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("observaciones");
			$tipo_dato->set_MaxLength(300);
			$tipo_dato->set_AllowBlank(false);
			if(!$valid->verifica_dato($tipo_dato->TipoDatoText(), "observaciones", $observaciones))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//DEPENDIENDO DEL TIPO DE INGRESO; VERIFICA QUE SU ORIGEN ESTÉ PRESENTE
			
			if($tipo_orden_ingreso=='Compra local')
			{
				if($id_empleado=="" && $id_proveedor=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Importacion')
			{
				if($id_empleado=="" && $id_proveedor=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Extraordinario')
			{
				if($id_institucion=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='Devolucion')
			{
				if($id_empleado=="" && $id_contratista=="")
				{
					$this->salida[0] = "f";
					$this->salida[1] = "Error de validación: Debe introducirse el Origen de la Orden de Ingreso";
					$this->salida[2] = "ORIGEN = $this->nombre_archivo";
					$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
					$this->salida[4] = "NIVEL = 3";
					return false;
				}
			}
			elseif($tipo_orden_ingreso=='General')
			{
				//Es el caso de que sea la vista de orden de compra general
			}
			else
			{
				$this->salida[0] = "f";
				$this->salida[1] = "Error de validación: El Tipo de Orden Ingreso no es válido";
				$this->salida[2] = "ORIGEN = $this->nombre_archivo";
				$this->salida[3] = "PROC = ValidarOrdenIngresoSol";
				$this->salida[4] = "NIVEL = 3";
				return false;
			}


			//Validación de reglas de datos

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='delete')
		{
			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
			{
				$this->salida = $valid->salida;
				return false;
			}

			//Validación exitosa
			return true;
		}
		elseif ($operacion_sql=='fin')
		{
			//Validar id_ingreso - tipo int4
			$tipo_dato->_reiniciar_valor();
			$tipo_dato->set_Columna("id_ingreso");

			if(!$valid->verifica_dato($tipo_dato->TipoDatoInteger(), "id_ingreso", $id_ingreso))
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