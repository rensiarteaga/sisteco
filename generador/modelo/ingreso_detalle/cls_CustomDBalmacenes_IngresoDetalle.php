<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-04 15:53:15
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBalmacenes
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBIngresoDetalle.php");

	}
	
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
}