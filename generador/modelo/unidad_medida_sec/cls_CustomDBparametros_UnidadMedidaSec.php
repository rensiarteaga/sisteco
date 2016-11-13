<?php
/**
 * Nombre de la Clase:	    CustomDBparametros
 * Propósito:				Interfaz del modelo del Sistema de parametros
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-04 10:38:44
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBparametros
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBUnidadMedidaSec.php");

	}
	
	/// --------------------- tpm_unidad_medida_sec --------------------- ///

	function ListarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ListarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ContarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ContarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function InsertarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->InsertarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ModificarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ModificarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function EliminarUnidadMedidaSec($id_unidad_medida_sec)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec -> EliminarUnidadMedidaSec($id_unidad_medida_sec);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ValidarUnidadMedidaSec($operacion_sql,$id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ValidarUnidadMedidaSec($operacion_sql,$id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_unidad_medida_sec --------------------- ///
}