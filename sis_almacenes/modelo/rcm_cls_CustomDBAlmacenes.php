<?php

class cls_CustomDBAlmacenes
{

	function __construct()
	{
		// include de todas las clases
		include_once("DBIngreso/cls_DBIngreso.php");
		include_once("DBIngreso/cls_DBIngresoDetalle.php");
		include_once("DBIngreso/cls_DBOrdenIngresoSol.php");
		include_once("DBIngreso/cls_DBOrdenIngresoSolDet.php");
		include_once("DBIngreso/cls_DBOrdenIngresoAprob.php");
		include_once("DBIngreso/cls_DBOrdenIngresoAprobDet.php");
		include_once("DBIngreso/cls_DBIngresoPend.php");
		include_once("DBIngreso/cls_DBIngresoVal.php");
		include_once("DBIngreso/cls_DBIngresoFin.php");
		include_once("DBTipoUnidadConstructiva/cls_DBTipoUnidadConstructiva.php");
		include_once("cls_DBTipoUnidadConsReemp.php");
		include_once("cls_DBOrdenSalidaUCDetalle.php");
		include_once("cls_DBDetalleSalidaUC.php");
		include_once("DBIngreso/cls_DBIngresoProy.php");
		include_once("DBSalida/cls_DBSalida.php");
	}

	/// --------------------- tal_ingreso --------------------- ///

	function ListarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso ->ListarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso ->ContarIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function InsertarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso ->InsertarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ModificarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso ->ModificarIngreso($id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function EliminarIngreso($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso -> EliminarIngreso($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarIngreso($operacion_sql,$id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngreso($this->decodificar);
		$res = $dbIngreso ->ValidarIngreso($operacion_sql,$id_ingreso,$correlativo_ord_ing,$correlativo_ing,$descripcion,$costo_unitario,$costo_total,$contabilizar,$contabilizado,$estado_ingreso,$estado_registro,$cod_inf_tec,$resumen_inf_tec,$fecha_borrador,$fecha_pendiente,$fecha_aprobado_rechazado,$fecha_ing_fisico,$fecha_ing_valorado,$fecha_finalizado_cancelado,$fecha_reg,$id_responsable_almacen,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_firma_autorizada,$id_institucion);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	/// --------------------- fin tal_ingreso --------------------- ///

	/// --------------------- tal_ingreso_detalle --------------------- ///

	function ListarIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle ->ListarIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ContarIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle ->ContarIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function InsertarIngresoDetalle($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle ->InsertarIngresoDetalle($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ModificarIngresoDetalle($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle ->ModificarIngresoDetalle($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function EliminarIngresoDetalle($id_ingreso_detalle)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle -> EliminarIngresoDetalle($id_ingreso_detalle);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ValidarIngresoDetalle($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngresoDetalle ->ValidarIngresoDetalle($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	/// --------------------- fin tal_ingreso_detalle --------------------- ///


	/// --------------------- orden_ingreso_sol --------------------- ///

	function ListarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->ListarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->ContarOrdenIngresoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function InsertarOrdenIngresoSol($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->InsertarOrdenIngresoSol($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function InsertarOrdenIngresoProy($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura,$txt_tipo_costeo)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->InsertarOrdenIngresoProy($descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura,$txt_tipo_costeo);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ModificarOrdenIngresoSol($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->ModificarOrdenIngresoSol($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ModificarIngresoProy($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura,$txt_tipo_costeo)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->ModificarIngresoProy($id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones,$num_factura,$fecha_factura,$responsable,$fecha_finalizado_cancelado,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui,$monto_tot_factura,$txt_tipo_costeo);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	//RCM: 29/07/2008
	function ValoracionIngreso($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoProy($this->decodificar);
		$res = $dbIngreso ->ValoracionIngreso($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}
	
	//RCM: 17/10/2008
	//Registra los datos de la valoraci�n
	function InsertarValoracionIngreso($id_ingreso,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui, $monto_tot_factura, $tipo_costeo)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoProy($this->decodificar);
		$res = $dbIngreso ->InsertarValoracionIngreso($id_ingreso,$importacion,$flete,$seguro,$gastos_alm,$gastos_aduana,$iva,$rep_form,$peso_neto,$id_moneda_import,$id_moneda_nacionaliz,$dui, $monto_tot_factura, $tipo_costeo);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function EliminarOrdenIngresoSol($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso -> EliminarOrdenIngresoSol($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function FinalizarOrdenIngresoSol($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->FinalizarOrdenIngresoSol($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarOrdenIngresoSol($operacion_sql,$tipo_orden_ingreso,$id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoSol($this->decodificar);
		$res = $dbIngreso ->ValidarOrdenIngresoSol($operacion_sql,$tipo_orden_ingreso,$id_ingreso,$descripcion,$costo_total,$id_proveedor,$id_contratista,$id_empleado,$id_almacen_logico,$id_institucion,$id_motivo_ingreso_cuenta,$orden_compra,$observaciones);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	/// --------------------- fin orden_ingreso_sol --------------------- ///

	/// --------------------- orden_ingreso_sol_det --------------------- ///

	function ListarOrdenIngresoSolDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->ListarOrdenIngresoSolDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ContarOrdenIngresoSolDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->ContarOrdenIngresoSolDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function InsertarOrdenIngresoSolDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->InsertarOrdenIngresoSolDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item, $estado_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	//RCM: 01/08/2008
	function InsertarIngresoProyDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->InsertarIngresoProyDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item, $estado_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ModificarOrdenIngresoSolDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->ModificarOrdenIngresoSolDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	//RCM: 01/08/2008
	function ModificarIngresoProyDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->ModificarIngresoProyDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item,$estado_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function EliminarOrdenIngresoSolDet($id_ingreso_detalle)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle -> EliminarOrdenIngresoSolDet($id_ingreso_detalle);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ValidarOrdenIngresoSolDet($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item, $estado_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoSolDet($this->decodificar);
		$res = $dbIngresoDetalle ->ValidarOrdenIngresoSolDet($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item, $estado_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	/// --------------------- fin orden_ingreso_sol_det --------------------- ///

	/// --------------------- orden_ingreso_aprob --------------------- ///

	function ListarOrdenIngresoAprob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->ListarOrdenIngresoAprob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarOrdenIngresoAprob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->ContarOrdenIngresoAprob($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function AprobarOrdenIngreso($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->AprobarOrdenIngreso($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function RechazarOrdenIngreso($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->RechazarOrdenIngreso($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function CorregirOrdenIngreso($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->CorregirOrdenIngreso($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarOrdenIngresoAprob($operacion_sql,$id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBOrdenIngresoAprob($this->decodificar);
		$res = $dbIngreso ->ValidarOrdenIngresoAprob($operacion_sql,$id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	/// --------------------- fin orden_ingreso_aprob --------------------- ///

	/// --------------------- orden_ingreso_aprob_det --------------------- ///

	function ListarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle ->ListarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ContarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle ->ContarOrdenIngresoAprobDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function InsertarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle ->InsertarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ModificarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle ->ModificarOrdenIngresoAprobDet($id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function EliminarOrdenIngresoAprobDet($id_ingreso_detalle)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle -> EliminarOrdenIngresoAprobDet($id_ingreso_detalle);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	function ValidarOrdenIngresoAprobDet($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item)
	{
		$this->salida = "";
		$dbIngresoDetalle = new cls_DBOrdenIngresoAprobDet($this->decodificar);
		$res = $dbIngresoDetalle ->ValidarOrdenIngresoAprobDet($operacion_sql,$id_ingreso_detalle,$cantidad,$costo,$precio_venta,$costo_unitario,$precio_venta_unitario,$observaciones,$fecha_reg,$id_ingreso,$id_item);
		$this->salida = $dbIngresoDetalle ->salida;
		$this->query = $dbIngresoDetalle ->query;
		return $res;
	}

	/// --------------------- fin orden_ingreso_aprob_det --------------------- ///

	/// --------------------- ingreso_pend --------------------- ///

	function ListarIngresoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoPend($this->decodificar);
		$res = $dbIngreso ->ListarIngresoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarIngresoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoPend($this->decodificar);
		$res = $dbIngreso ->ContarIngresoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ConfirmarIngresoPend($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoPend($this->decodificar);
		$res = $dbIngreso ->ConfirmarIngresoPend($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarIngresoPend($operacion_sql,$id_ingreso,$observaciones)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoPend($this->decodificar);
		$res = $dbIngreso ->ValidarIngresoPend($operacion_sql,$id_ingreso,$observaciones);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	/// --------------------- ingreso_val --------------------- ///

	function ListarIngresoVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoVal($this->decodificar);
		$res = $dbIngreso ->ListarIngresoVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarIngresoVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoVal($this->decodificar);
		$res = $dbIngreso ->ContarIngresoVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function FinalizarIngresoVal($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoVal($this->decodificar);
		$res = $dbIngreso ->FinalizarIngresoVal($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarIngresoVal($operacion_sql,$id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoVal($this->decodificar);
		$res = $dbIngreso ->ValidarIngresoVal($operacion_sql,$id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	/// --------------------- fin ingreso_val --------------------- ///

	/// --------------------- ingreso_fin --------------------- ///

	function ListarIngresoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoFin($this->decodificar);
		$res = $dbIngreso ->ListarIngresoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ContarIngresoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoFin($this->decodificar);
		$res = $dbIngreso ->ContarIngresoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function FinalizarIngresoFin($id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoFin($this->decodificar);
		$res = $dbIngreso ->FinalizarIngresoFin($id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	function ValidarIngresoFin($operacion_sql,$id_ingreso)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoFin($this->decodificar);
		$res = $dbIngreso ->ValidarIngresoFin($operacion_sql,$id_ingreso);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}
	/// --------------------- fin ingreso_fin --------------------- ///

	/// ----- anular ingreso -------//////

	function AnularIngreso($id_ingreso,$observaciones)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoPend($this->decodificar);
		$res = $dbIngreso ->AnularIngreso($id_ingreso,$observaciones);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}


	/////
	///// TIPOS DE UNIDADES CONSTRUCTIVAS
	/////
	/////
	function ListarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ContarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ContarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarTipoUnidadConstructivaAgrupador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructivaAgrupador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ContarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ContarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ContarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ContarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ContarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ContarTipoUnidadConstructivaReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarTipoUnidadConstructivaAgrupador($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarTipoUnidadConstructivaAgrupador($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarTipoUnidadConstructiva($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarTipoUnidadConstructiva($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$estado);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ModificarTipoUnidadConstructiva($id,$codigo,$nombre,$tipo,$descripcion,$observaciones,$estado)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ModificarTipoUnidadConstructiva($id,$codigo,$nombre,$tipo,$descripcion,$observaciones,$estado);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarTipoUnidadConstructiva($id,$id_padre)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->EliminarTipoUnidadConstructiva($id,$id_padre);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarTipoUnidadConstructivaArb($id)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructivaArb($this->decodificar);
		$res = $dbTuc ->EliminarTipoUnidadConstructivaArb($id);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ModificarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ModificarComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarComposicion($id,$id_padre)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->EliminarComposicion($id,$id_padre);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$estado)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$estado);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ModificarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$id_padre_nuevo)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarTucComposicion($id,$id_padre,$tipo,$codigo,$nombre,$descripcion,$observaciones,$cantidad,$opcional,$id_padre_nuevo);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ValidarTipoUnidadConstructiva($operacion_sql,$id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ValidarTipoUnidadConstructiva($operacion_sql,$id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->InsertarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ModificarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ModificarComponente($id,$id_padre,$tipo,$descripcion,$cantidad,$considerar_repeticion);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarComponente($id,$id_padre)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->EliminarComponente($id,$id_padre);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function DragAndDropRaiz($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->DragAndDropRaiz($id,$id_padre,$id_padre_nuevo);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function DragAndDropRama($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->DragAndDropRama($id,$id_padre,$id_padre_nuevo);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function DragAndDropItem($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->DragAndDropItem($id,$id_padre,$id_padre_nuevo);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function FinalizarTUC($id)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->FinalizarTUC($id);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function DesbloquearTUC($id)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->DesbloquearTUC($id);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarTipoUnidadConstructivaBasurero($id)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->EliminarTipoUnidadConstructivaBasurero($id);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function EliminarTipoUnidadConstructivaAgrupador($id)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->EliminarTipoUnidadConstructivaAgrupador($id);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function CopiarTipoUnidadConstructiva($id,$id_padre,$id_padre_nuevo,$cantidad,$opcional)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->CopiarTipoUnidadConstructiva($id,$id_padre,$id_padre_nuevo,$cantidad,$opcional);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}
	function ListarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ListarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}

	function ContarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ContarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}

	///// ---------------------------------- tal_orden_salida_uc_detalle --------------------------------------/////

	function ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;


		return $res;
	}

	function ContarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ContarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ListarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ListarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle);
		//$res = $dbOrdSalUCDet ->ListarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;

		return $res;
	}

	function ContarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ContarOrdenSalidaUCDetalleRamas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_raiz,$id_orden_salida_uc_detalle);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ListarOrdenSalidaUCDetalleItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbTuc = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbTuc ->ListarOrdenSalidaUCDetalleItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function ListarOrdenSalidaUCDetalleItemEntregados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbTuc = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbTuc ->ListarOrdenSalidaUCDetalleItemEntregados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_orden_salida_uc_detalle);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	function InsertarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$repeticion)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->InsertarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$repeticion);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function InsertarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$id_item)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->InsertarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad,$id_item);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ModificarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$cantidad,$repeticion)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ModificarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$id_tipo_unidad_constructiva,$cantidad,$repeticion);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ModificarOrdenSalidaUCDetalleRama($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$cantidad,$id_composicion_tuc)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ModificarOrdenSalidaUCDetalleRama($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$cantidad,$id_composicion_tuc);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ModificarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$cantidad,$id_item)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ModificarOrdenSalidaUCDetalleItem($id_orden_salida_uc_detalle,$descripcion,$observaciones,$cantidad,$id_item);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ReemplazarRamaOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_composicion_tuc,$cantidad,$observaciones)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ReemplazarRamaOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_composicion_tuc,$cantidad,$observaciones);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function EliminarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet -> EliminarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}



	function insertarTucTpmPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->insertarTucTpmPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function insertarItemTpmPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->insertarItemTpmPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}


	function ValidarOrdenSalidaUCDetalle($operacion_sql,$id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ValidarOrdenSalidaUCDetalle($operacion_sql,$id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}


	function verificarPedidoTucTmp($id_salida,$id_almacen_logico)
	{
		//echo "LLEGA AQUI"; exit;
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->verificarPedidoTucTmp($id_salida,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function verificarPedidoTucInt($id_salida,$id_almacen_logico)
	{
		//echo "LLEGA AQUI"; exit;
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->verificarPedidoTucInt($id_salida,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function VerificarReservarPedidoTucInt($id_salida)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->VerificarReservarPedidoTucInt($id_salida);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function insertarTucIntPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->insertarTucIntPedido($id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_salida,$cantidad,$repeticion,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function insertarItemIntPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->insertarItemIntPedido($id_orden_salida_uc_detalle,$id_item,$id_salida,$cantidad,$repeticion,$id_almacen_logico);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function EliminarOrdenSalidaUCDetalleTmp($id_salida)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->EliminarOrdenSalidaUCDetalleTmp($id_salida);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}


	function EliminarOrdenSalidaUCDetalleInt($id_salida)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->EliminarOrdenSalidaUCDetalleInt($id_salida);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function EliminarVerifReservInt($id_salida)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->EliminarVerifReservInt($id_salida);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}


	function modificarSalidaTipoEntrega($id_salida,$tipo_entrega)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->modificarSalidaTipoEntrega($id_salida,$tipo_entrega);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}





	///// ---------------------------------- fin tal_orden_salida_uc_detalle --------------------------------------/////

	//// ----------------------------------- tal_detalle_salida_uc -------------------------------------------------////
	function InsertarDetalleSalidaUC($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBDetalleSalidaUC($this->decodificar);
		$res = $dbDetSalUC -> InsertarDetalleSalidaUC($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	function ModificarDetalleSalidaUC($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBDetalleSalidaUC($this->decodificar);
		$res = $dbDetSalUC -> ModificarDetalleSalidaUC($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	function EliminarDetalleSalidaUC($id_detalle_salida_uc)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBDetalleSalidaUC($this->decodificar);
		$res = $dbDetSalUC -> EliminarDetalleSalidaUC($id_detalle_salida_uc);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	function VolverOriginal($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBDetalleSalidaUC($this->decodificar);
		$res = $dbDetSalUC -> VolverOriginal($id_detalle_salida_uc,$cantidad,$observaciones,$id_orden_salida_uc_detalle,$id_tipo_unidad_constructiva,$id_modulo_uc,$id_composicion_tuc,$id_tipo_unidad_constructiva_orig);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	//Ingresos para Proyectos 02-04-2008 RCM
	function ListarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBIngresoProy($this->decodificar);
		$res = $dbDetSalUC -> ListarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	function ContarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDetSalUC = new cls_DBIngresoProy($this->decodificar);
		$res = $dbDetSalUC -> ContarIngresoProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetSalUC ->salida;
		$this->query = $dbDetSalUC ->query;
		return $res;
	}

	function FinalizarIngresoProy($id_ingreso)
	{
		$this->salida = "";
		$dbIngProy = new cls_DBIngresoProy($this->decodificar);
		$res = $dbIngProy -> FinalizarIngresoProy($id_ingreso);
		$this->salida = $dbIngProy ->salida;
		$this->query = $dbIngProy ->query;
		return $res;
	}

	//RCM: 13/06/2008 aumentado en San Borja
	function NotaIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoProy($this->decodificar);
		$res = $dbIngreso ->NotaIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	//RCM: 25/06/2008 aumentado en Cbba retorno de San Borja
	function ListarIngresoDetalleReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngreso ->ListarIngresoDetalleReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}
	
	//ARV: 20/02/2009 aumentado en Cbba retorno de San Borja
		
	function ListarResumenIngresoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)//,$id_parametro_almacen,$fecha_desde,$fecha_hasta,$id_almacen,$id_almacen_logico)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngreso ->ListarResumenIngresoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);//,$id_parametro_almacen,$fecha_desde,$fecha_hasta,$id_almacen,$id_almacen_logico);
		$this->salida = $dbIngreso->salida;
		$this->query = $dbIngreso->query;
		return $res;
	}
	

	//RCM: 15/07/2008 aumentado para reporte de existencias por contratista y UC
	function ObtenerIngresoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbIngreso = new cls_DBIngresoDetalle($this->decodificar);
		$res = $dbIngreso ->ObtenerIngresoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbIngreso ->salida;
		$this->query = $dbIngreso ->query;
		return $res;
	}

	//RCM: 17/07/2008
	function ListarExistenciaItemUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarExistenciaItemUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}
	
	//RCM: 14/08/2008
	function ListarExistenciaItemUCRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarExistenciaItemUCRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	//RCM: 18/07/2008
	function ListarSalidaUCOrigen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarSalidaUCOrigen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}

	//RCM: 18/07/2008
	function ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTuc = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTuc ->ListarTipoUCPadre($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_tipo_unidad_constructiva);
		$this->salida = $dbTuc ->salida;
		$this->query = $dbTuc ->query;
		return $res;
	}
	
	//RCM: 01/09/2008
	function DiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSal = new cls_DBSalida($this->decodificar);
		$res = $dbSal ->DiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSal ->salida;
		$this->query = $dbSal ->query;
		return $res;
	}
	
	//RCM: 01/09/2008
	function DiarioSalidaAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSal = new cls_DBSalida($this->decodificar);
		$res = $dbSal ->DiarioSalidaAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSal ->salida;
		$this->query = $dbSal ->query;
		return $res;
	}
	
	


}
?>