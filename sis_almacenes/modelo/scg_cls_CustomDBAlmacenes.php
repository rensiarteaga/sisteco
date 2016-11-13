<?php
/**
 * Nombre de la Clase:	    CustomDBAlmacenes
 * Propósito:				Interfaz del modelo del Sistema de Almacenes
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		27-09-2007
 * Autor:					Susana Castro Guaman.
 *
 */
class cls_CustomDBalmacenes
{	var $salida = "";
	var $query = "";
	var $decodificar = false;
	function __construct()
	{	include_once("cls_DBInventario.php");
		include_once("cls_DBInventarioDet.php");
	}
	// --------------------- tal_inventario --------------------- ///
	function ListarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ListarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ContarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ContarInventario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	///////////////////////////////////////////////////
	function ListarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ListarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ContarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ContarInventarioResultado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ListarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ListarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ContarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ContarInventarioRevision($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}

	
	function ListarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ListarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ContarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ContarInventarioConclusion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	////////////////////////////////////////////////////
	
	function InsertarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{   $this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->InsertarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ModificarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ModificarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	////////////
	function IniciarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->IniciarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	/////////////////////
	function ReconteoInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ReconteoInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	////////////
	function RevisarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->RevisarInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	////////////
	function ConcluirInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ConcluirInventario($id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	
	/////////////////////
	function EliminarInventario($id_inventario)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario -> EliminarInventario($id_inventario);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ValidarInventario($operacion_sql,$id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero)
	{	$this->salida = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ValidarInventario($operacion_sql,$id_inventario,$observaciones,$fecha_inicio,$fecha_fin,$fecha_reg,$tipo_inventario,$id_almacen,$id_responsable_almacen,$id_almacen_ep,$id_almacen_logico,$estado,$id_almacenero);
		$this->salida = $dbInventario ->salida;
		$this->query = $dbInventario ->query;
		return $res;
	}
	function ActualizaFechaInventario($id_inventario)
	{	$this->inventario = "";
		$dbInventario = new cls_DBInventario($this->decodificar);
		$res = $dbInventario ->ActualizaFechaInventario($id_inventario);
		$this->inventario = $dbInventario ->inventario;
		$this->query = $dbInventario ->query;
		return $res;
	}
	/// --------------------- fin tal_inventario --------------------- ///
	/// --------------------- tal_inventario_det --------------------- ///
	function ListarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet ->ListarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		return $res;
	}
	function ContarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet ->ContarInventarioDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_inventario);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		return $res;
	}
	function InsertarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet ->InsertarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		
		return $res;
	}
	function ModificarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet ->ModificarInventarioDet($id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$estado_item,$id_item,$id_inventario,$id_supergrupo,$id_grupo,$id_subgrupo,$id_id1,$id_id2,$id_id3,$cantidad_contada_nuevo,$cantidad_contada_usado);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		return $res;
	}
	function EliminarInventarioDet($id_item,$id_inventario)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet -> EliminarInventarioDet($id_item,$id_inventario);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		return $res;
	}
		function ValidarInventarioDet($operacion_sql,$id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$id_item,$id_inventario)
	{	$this->salida = "";
		$dbInventarioDet = new cls_DBInventarioDet($this->decodificar);
		$res = $dbInventarioDet ->ValidarInventarioDet($operacion_sql,$id_inventario_det,$cantidad_estimada,$cantidad_contada,$fecha_conteo,$id_item,$id_inventario);
		$this->salida = $dbInventarioDet ->salida;
		$this->query = $dbInventarioDet ->query;
		return $res;
	}
	/// --------------------- fin tal_inventario_det --------------------- ///
}