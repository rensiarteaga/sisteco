<?php
/**
 * Nombre de la Clase:	    CustomDBadquisiciones
 * Propósito:				Interfaz del modelo del Sistema de adquisiciones
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-16 18:56:28
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBadquisiciones
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBProveedor.php");

	}
	
	/// --------------------- tad_proveedor --------------------- ///

	function ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function InsertarProveedor($id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->InsertarProveedor($id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ModificarProveedor($id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ModificarProveedor($id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function EliminarProveedor($id_proveedor)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor -> EliminarProveedor($id_proveedor);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ValidarProveedor($operacion_sql,$id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ValidarProveedor($operacion_sql,$id_proveedor,$nombre,$descripcion,$telefono_ref,$observaciones,$fecha_reg);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	/// --------------------- fin tad_proveedor --------------------- ///
}