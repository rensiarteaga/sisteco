<?php
/**
 * Nombre de la Clase:	    CustomDBparametros
 * Propósito:				Interfaz del modelo del Sistema de parametros
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-03 20:46:20
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
		include_once("cls_DBTipoUnidadMedida.php");

	}
	
	/// --------------------- tpm_tipo_unidad_medida --------------------- ///

	function ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ContarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ContarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function InsertarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->InsertarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ModificarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ModificarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function EliminarTipoUnidadMedida($id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida -> EliminarTipoUnidadMedida($id_tipo_unidad_medida);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ValidarTipoUnidadMedida($operacion_sql,$id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ValidarTipoUnidadMedida($operacion_sql,$id_tipo_unidad_medida,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_tipo_unidad_medida --------------------- ///
}