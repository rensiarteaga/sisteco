<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-12 16:30:26
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
		include_once("cls_DBAlmacenEp.php");

	}
	
	/// --------------------- tal_almacen_ep --------------------- ///

	function ListarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ListarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	function ContarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ContarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	function InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	function ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	function EliminarAlmacenEp($id_almacen_ep)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp -> EliminarAlmacenEp($id_almacen_ep);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	function ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_fina_regi_prog_proy_acti,$id_almacen);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	
	/// --------------------- fin tal_almacen_ep --------------------- ///
}