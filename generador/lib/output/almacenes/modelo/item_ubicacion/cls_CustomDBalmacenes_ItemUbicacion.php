<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 16:18:27
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
		include_once("cls_DBItemUbicacion.php");

	}
	
	/// --------------------- tal_item_ubicacion --------------------- ///

	function ListarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ListarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	function ContarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ContarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	function InsertarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->InsertarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	function ModificarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ModificarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	function EliminarItemUbicacion($id_item_ubicacion)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion -> EliminarItemUbicacion($id_item_ubicacion);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	function ValidarItemUbicacion($operacion_sql,$id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ValidarItemUbicacion($operacion_sql,$id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}
	
	/// --------------------- fin tal_item_ubicacion --------------------- ///
}