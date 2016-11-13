<?php
/**
 * Nombre de la Clase:	    CustomDBseguridad
 * Propósito:				Interfaz del modelo del Sistema de seguridad
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-10 11:02:01
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBseguridad
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBSubsistema.php");

	}
	
	/// --------------------- tsg_subsistema --------------------- ///

	function ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function EliminarSubsistema($id_subsistema)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema -> EliminarSubsistema($id_subsistema);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_subsistema --------------------- ///
}