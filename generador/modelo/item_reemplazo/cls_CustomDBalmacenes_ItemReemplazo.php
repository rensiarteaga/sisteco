<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 21:10:27
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
		include_once("cls_DBItemReemplazo.php");

	}
	
	/// --------------------- tal_item_reemplazo --------------------- ///

	function ListarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ListarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	function ContarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ContarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	function InsertarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->InsertarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	function ModificarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ModificarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	function EliminarItemReemplazo($id_item_reemplazo)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo -> EliminarItemReemplazo($id_item_reemplazo);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	function ValidarItemReemplazo($operacion_sql,$id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ValidarItemReemplazo($operacion_sql,$id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}
	
	/// --------------------- fin tal_item_reemplazo --------------------- ///
}