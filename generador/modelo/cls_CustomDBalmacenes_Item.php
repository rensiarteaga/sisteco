<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-04 15:51:04
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
		include_once("cls_DBItem.php");

	}
	
	/// --------------------- tal_item --------------------- ///

	function ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function EliminarItem($id_item)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem -> EliminarItem($id_item);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	/// --------------------- fin tal_item --------------------- ///
}