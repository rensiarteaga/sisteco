<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 12:22:41
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
		include_once("cls_DBItemRemplazo.php");

	}
	
	/// --------------------- tal_item_remplazo --------------------- ///

	function ListarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo ->ListarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	function ContarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo ->ContarItemRemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	function InsertarItemRemplazo(	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo ->InsertarItemRemplazo(		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	function ModificarItemRemplazo(	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo ->ModificarItemRemplazo(		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	function EliminarItemRemplazo($)
	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo -> EliminarItemRemplazo($);
		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	function ValidarItemRemplazo($operacion_sql,	{
		$this->salida = "";
		$dbItemRemplazo = new cls_DBItemRemplazo($this->decodificar);
		$res = $dbItemRemplazo ->ValidarItemRemplazo($operacion_sql,		$this->salida = $dbItemRemplazo ->salida;
		$this->query = $dbItemRemplazo ->query;
		return $res;
	}
	
	/// --------------------- fin tal_item_remplazo --------------------- ///
}