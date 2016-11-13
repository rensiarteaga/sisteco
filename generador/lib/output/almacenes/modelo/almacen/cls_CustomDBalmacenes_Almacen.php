<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 16:16:53
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
		include_once("cls_DBAlmacen.php");

	}
	
	/// --------------------- tal_almacen --------------------- ///

	function ListarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ListarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	function ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	function InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	function ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	function EliminarAlmacen($id_almacen)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen -> EliminarAlmacen($id_almacen);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	function ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}
	
	/// --------------------- fin tal_almacen --------------------- ///
}