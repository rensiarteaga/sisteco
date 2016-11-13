<?php
/**
 * Nombre de la Clase:	    CustomDB
 * Propósito:				Interfaz del modelo del Sistema de 
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-11 10:13:15
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDB
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DB.php");

	}
	
	/// --------------------- t_ --------------------- ///

	function Listar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db ->Listar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function Contar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db ->Contar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function Insertar(	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db ->Insertar(		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function Modificar(	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db ->Modificar(		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function Eliminar($)
	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db -> Eliminar($);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function Validar($operacion_sql,	{
		$this->salida = "";
		$db = new cls_DB($this->decodificar);
		$res = $db ->Validar($operacion_sql,		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	/// --------------------- fin t_ --------------------- ///
}