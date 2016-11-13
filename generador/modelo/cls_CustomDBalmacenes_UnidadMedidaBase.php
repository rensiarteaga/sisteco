<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 15:20:45
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
		include_once("cls_DBUnidadMedidaBase.php");

	}
	
	/// --------------------- tpm_unidad_medida_base --------------------- ///

	function ListarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ListarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ContarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ContarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function InsertarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->InsertarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ModificarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ModificarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function EliminarUnidadMedidaBase($id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase -> EliminarUnidadMedidaBase($id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ValidarUnidadMedidaBase($operacion_sql,$id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ValidarUnidadMedidaBase($operacion_sql,$id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_unidad_medida_base --------------------- ///
}