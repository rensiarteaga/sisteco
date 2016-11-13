<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 19:30:59
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
		include_once("cls_DBCodigoFabricante.php");

	}
	
	/// --------------------- tal_codigo_fabricante --------------------- ///

	function ListarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ListarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	function ContarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ContarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	function InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	function ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	function EliminarCodigoFabricante($id_codigo_fabricante)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante -> EliminarCodigoFabricante($id_codigo_fabricante);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	function ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}
	
	/// --------------------- fin tal_codigo_fabricante --------------------- ///
}