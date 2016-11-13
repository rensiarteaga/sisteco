<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 10:07:20
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
		include_once("cls_DBTalTipoTransferencia.php");

	}
	
	/// --------------------- tal_tal_tipo_transferencia --------------------- ///

	function ListarTalTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia ->ListarTalTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	function ContarTalTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia ->ContarTalTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	function InsertarTalTipoTransferencia(	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia ->InsertarTalTipoTransferencia(		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	function ModificarTalTipoTransferencia(	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia ->ModificarTalTipoTransferencia(		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	function EliminarTalTipoTransferencia($)
	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia -> EliminarTalTipoTransferencia($);
		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	function ValidarTalTipoTransferencia($operacion_sql,	{
		$this->salida = "";
		$dbTalTipoTransferencia = new cls_DBTalTipoTransferencia($this->decodificar);
		$res = $dbTalTipoTransferencia ->ValidarTalTipoTransferencia($operacion_sql,		$this->salida = $dbTalTipoTransferencia ->salida;
		$this->query = $dbTalTipoTransferencia ->query;
		return $res;
	}
	
	/// --------------------- fin tal_tal_tipo_transferencia --------------------- ///
}