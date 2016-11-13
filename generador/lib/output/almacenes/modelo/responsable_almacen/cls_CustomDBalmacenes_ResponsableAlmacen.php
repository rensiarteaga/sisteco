<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-12 15:53:18
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
		include_once("cls_DBResponsableAlmacen.php");

	}
	
	/// --------------------- tal_responsable_almacen --------------------- ///

	function ListarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ListarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	function ContarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ContarResponsableAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	function InsertarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->InsertarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	function ModificarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ModificarResponsableAlmacen($id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	function EliminarResponsableAlmacen($id_responsable_almacen)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen -> EliminarResponsableAlmacen($id_responsable_almacen);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	function ValidarResponsableAlmacen($operacion_sql,$id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ValidarResponsableAlmacen($operacion_sql,$id_responsable_almacen,$estado,$cargo,$fecha_asignacion,$fecha_reg,$observaciones,$id_almacen,$id_empleado);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}
	
	/// --------------------- fin tal_responsable_almacen --------------------- ///
}