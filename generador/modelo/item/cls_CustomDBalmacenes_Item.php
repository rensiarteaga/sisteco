<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-08 16:59:49
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
	
	function InsertarItem(	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->InsertarItem(		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function ModificarItem(	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ModificarItem(		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function EliminarItem($)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem -> EliminarItem($);
		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	function ValidarItem($operacion_sql,	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ValidarItem($operacion_sql,		$this->salida = $dbItem ->salida;
		$this->query = $dbItem ->query;
		return $res;
	}
	
	/// --------------------- fin tal_item --------------------- ///
}