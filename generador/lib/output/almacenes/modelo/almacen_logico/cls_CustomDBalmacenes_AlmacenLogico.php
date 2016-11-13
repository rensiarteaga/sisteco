<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-12 16:30:41
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
		include_once("cls_DBAlmacenLogico.php");

	}
	
	/// --------------------- tal_almacen_logico --------------------- ///

	function ListarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ListarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	function ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	function InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	function ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	function EliminarAlmacenLogico($id_almacen_logico)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico -> EliminarAlmacenLogico($id_almacen_logico);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	function ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	
	/// --------------------- fin tal_almacen_logico --------------------- ///
}