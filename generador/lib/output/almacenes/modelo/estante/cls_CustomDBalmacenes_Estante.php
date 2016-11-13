<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 16:17:36
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
		include_once("cls_DBEstante.php");

	}
	
	/// --------------------- tal_estante --------------------- ///

	function ListarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ListarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	function ContarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ContarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	function InsertarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->InsertarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	function ModificarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ModificarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	function EliminarEstante($id_estante)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante -> EliminarEstante($id_estante);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	function ValidarEstante($operacion_sql,$id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ValidarEstante($operacion_sql,$id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}
	
	/// --------------------- fin tal_estante --------------------- ///
}