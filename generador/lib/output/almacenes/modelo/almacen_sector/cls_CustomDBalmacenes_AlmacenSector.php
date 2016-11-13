<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 16:17:02
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
		include_once("cls_DBAlmacenSector.php");

	}
	
	/// --------------------- tal_almacen_sector --------------------- ///

	function ListarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ListarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	function ContarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ContarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	function InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	function ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	function EliminarAlmacenSector($id_almacen_sector)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector -> EliminarAlmacenSector($id_almacen_sector);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	function ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}
	
	/// --------------------- fin tal_almacen_sector --------------------- ///
}