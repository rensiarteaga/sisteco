<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 20:07:12
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
		include_once("cls_DBMotivoIngreso.php");

	}
	
	/// --------------------- tal_motivo_ingreso --------------------- ///

	function ListarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ListarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	function ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	function InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	function ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	function EliminarMotivoIngreso($id_motivo_ingreso)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso -> EliminarMotivoIngreso($id_motivo_ingreso);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	function ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$id_cuenta);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}
	
	/// --------------------- fin tal_motivo_ingreso --------------------- ///
}