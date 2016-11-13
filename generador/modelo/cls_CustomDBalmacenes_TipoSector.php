<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 12:10:00
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
		include_once("cls_DBTipoSector.php");

	}
	
	/// --------------------- tal_tipo_sector --------------------- ///

	function ListarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ListarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	function ContarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ContarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	function InsertarTipoSector($id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->InsertarTipoSector($id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	function ModificarTipoSector($id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ModificarTipoSector($id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	function EliminarTipoSector($id_tipo_sector)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector -> EliminarTipoSector($id_tipo_sector);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	function ValidarTipoSector($operacion_sql,$id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ValidarTipoSector($operacion_sql,$id_tipo_sector,$codigo,$estado,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}
	
	/// --------------------- fin tal_tipo_sector --------------------- ///
}