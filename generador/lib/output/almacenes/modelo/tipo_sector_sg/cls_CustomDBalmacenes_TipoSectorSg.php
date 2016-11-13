<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 16:16:51
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
		include_once("cls_DBTipoSectorSg.php");

	}
	
	/// --------------------- tal_tipo_sector_sg --------------------- ///

	function ListarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ListarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	function ContarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ContarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	function InsertarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->InsertarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	function ModificarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ModificarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	function EliminarTipoSectorSg($id_tal_tipo_sector_sg)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg -> EliminarTipoSectorSg($id_tal_tipo_sector_sg);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	function ValidarTipoSectorSg($operacion_sql,$id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ValidarTipoSectorSg($operacion_sql,$id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}
	
	/// --------------------- fin tal_tipo_sector_sg --------------------- ///
}