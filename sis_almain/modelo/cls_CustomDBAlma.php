<?php
/**
 * Nombre de la Clase:	    CustomDBAlma
 * Proposito:				
 * Fecha de Creacion:		24-07-2013
 * Autor:					Ariel Ayaviri Omonte
 * 							Ruddy Lujan Bravo
 */
class cls_CustomDBAlma {
	// variable que contiene la salida de la ejecuci�n de la funci�n
	// si la funcion tuvo error (false), salida contendr� el mensaje de error
	// si la funcion no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida = "";
	
	// Variable que contedr� la cadena de llamada a las funciones postgres
	var $query = "";
	
	// Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;
	function __construct() {
		// Se deben incluir los DAOs de correspondientes a las tablas.
		include_once ("cls_DBAlmacen.php");
		include_once ("cls_DBTipoMovimiento.php");
		include_once ("cls_DBUbicacion.php");
		include_once ("cls_DBClasificacion.php");
		include_once ("cls_DBItem.php");
		include_once ("cls_DBMovimiento.php");
		include_once ("cls_DBDetalleMovimiento.php");
		include_once ("cls_DBSolicitudSalida.php");
		include_once ("cls_DBDetalleSolicitud.php");
		include_once ("cls_DBStockItem.php");
		include_once ("cls_DBReportes.php");	
		include_once ("cls_DBUnidadConstructiva.php");
		include_once ("cls_DBDetalleUnidadConstructiva.php");
		include_once ("cls_DBMovimientoProyecto.php");
		include_once ("cls_DBMovimientoProyectoDet.php");
		include_once ("cls_DBFase.php");
		include_once ("cls_DBTramo.php");
		include_once ("cls_DBFaseTramo.php");
		include_once ("cls_DBTramoUnidadConstructiva.php");
		include_once ("cls_DBSalidaUnidadConstructiva.php");
		include_once ("cls_DBSalidaUnidadConstructivaDet.php");
		include_once ("cls_DBCosteo.php");//05-05-2015
		include_once ("cls_DBIngresos.php");//05-05-2015
		include_once ("cls_DBCosto.php");//05-05-2015
		include_once ("cls_DBCosteoDetalle.php");//05-05-2015
		include_once ("cls_DBTipoMaterial.php");
		
		include_once ("cls_DBUbicacionItemDetalle.php");
		
	}
	// ///////////////cls_DBAlmacen.php////////////////////
	function ControlTipoAlmacen($id_almacen)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ControlTipoAlmacen($id_almacen);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function ContarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ContarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function ListarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ListarAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function ValidarAlmacen($operacion_sql, $id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ValidarAlmacen($operacion_sql, $id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function InsertarAlmacen($id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->InsertarAlmacen($id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function ModificarAlmacen($id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ModificarAlmacen($id_almacen, $id_lugar, $id_depto, $codigo, $nombre, $direccion, $estado, $tipo_control,$demasia);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function EliminarAlmacen($id_almacen) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->EliminarAlmacen($id_almacen);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	function ActivarInactivarAlmacen($id_almacen) {
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen->ActivarInactivarAlmacen($id_almacen);
		$this->salida = $dbAlmacen->salida;
		$this->query = $dbAlmacen->query;
		return $res;
	}
	// ////////////////////cls_DBTipoMovimiento.php//////////////////////////////
	function ListarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->ListarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	function ContarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->ContarTipoMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	function InsertarTipoMovimiento($id_documento, $tipo, $requiere_aprobacion) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->InsertarTipoMovimiento($id_documento, $tipo, $requiere_aprobacion);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	function ModificarTipoMovimiento($id_tipo_movimiento, $id_documento, $tipo, $requiere_aprobacion) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->ModificarTipoMovimiento($id_tipo_movimiento, $id_documento, $tipo, $requiere_aprobacion);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	function EliminarTipoMovimiento($id_tipo_movimiento) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->EliminarTipoMovimiento($id_tipo_movimiento);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	function ValidarTipoMovimiento($operacion_sql, $id_tipo_movimiento, $id_documento, $tipo, $requiere_aprobacion) {
		$this->salida = "";
		$dbTipoMovimiento = new cls_DBTipoMovimiento($this->decodificar);
		$res = $dbTipoMovimiento->ValidarTipoMovimiento($operacion_sql, $id_tipo_movimiento, $id_documento, $tipo, $requiere_aprobacion);
		$this->salida = $dbTipoMovimiento->salida;
		$this->query = $dbTipoMovimiento->query;
		return $res;
	}
	// /////////////////Cls_Ubicacion.php///////////////////////////
	function ContarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->ContarUbicacionArbn($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	function ListarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad) {
		$this->salida = "";
			
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->ListarUbicacionArb($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	function ValidarUbicacionArb($operacion_sql, $id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->ValidarUbicacionArb($operacion_sql, $id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	function InsertarUbicacionArb($id_ubicacion_fk, $id_almacen, $codigo, $nombre, $estado) {
		$this->salida = "";
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->InsertarUbicacionArb($id_ubicacion_fk, $id_almacen, $codigo, $nombre, $estado);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	function ModificarUbicacionArb($id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->ModificarUbicacionArb($id_ubicacion, $id_almacen, $id_ubicacion_fk, $codigo, $nombre, $estado);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	function EliminarUbicacionArb($id_ubicacion) {
		$this->salida = "";
		$dbUbicacion = new cls_DBUbicacion($this->decodificar);
		$res = $dbUbicacion->EliminarUbicacionArb($id_ubicacion);
		$this->salida = $dbUbicacion->salida;
		$this->query = $dbUbicacion->query;
		return $res;
	}
	// /////////////////cls_DBClasificacion.php///////////////////////////
	function ContarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->ContarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	
	function ListarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad) {
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->ListarClasificacion($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $hidden_ep_id_financiador, $hidden_ep_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	function ValidarClasificacion($operacion_sql, $id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado) {
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->ValidarClasificacion($operacion_sql, $id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	function InsertarClasificacion($id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden) {
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->InsertarClasificacion($id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	function ModificarClasificacion($id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden) {
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->ModificarClasificacion($id_clasificacion, $id_clasificacion_fk, $codigo, $nombre, $estado,$demasia,$orden);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	function EliminarClasificacion($id_clasificacion) {
		$this->salida = "";
		$dbClasificacion = new cls_DBClasificacion($this->decodificar);
		$res = $dbClasificacion->EliminarClasificacion($id_clasificacion);
		$this->salida = $dbClasificacion->salida;
		$this->query = $dbClasificacion->query;
		return $res;
	}
	// ///////////////cls_DBItem.php////////////////////
	function ContarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ContarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ListarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ListarItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ValidarItem($operacion_sql, $id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ValidarItem($operacion_sql, $id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function InsertarItem($id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->InsertarItem($id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ModificarItem($id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ModificarItem($id_item, $id_clasificacion, $id_unidad_medida, $nombre, $descripcion, $codigo_fabrica, $bajo_responsabilidad, $estado, $metodo_valoracion,$peso,$calidad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function EliminarItem($id_item) {
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->EliminarItem($id_item);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	// ///////////////////////cls_DBMovimiento.php//////////////////////////////////////
	function ContarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ContarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function ListarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ListarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function ValidarMovimiento($operacion_sql, $id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ValidarMovimiento($operacion_sql, $id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function InsertarMovimiento($id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->InsertarMovimiento($id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function ModificarMovimiento($id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ModificarMovimiento($id_movimiento, $id_tipo_movimiento, $id_almacen, $id_solicitud_salida, $codigo, $fecha_movimiento, $descripcion, $observaciones,$almacen_destino,$movimiento_origen,$nro_compra);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function EliminarMovimiento($id_movimiento) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->EliminarMovimiento($id_movimiento);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function FinalizarMovimiento($id_movimiento) {
		$this->salida = "";
		$dbFinalizarMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbFinalizarMovimiento->FinalizarMovimiento($id_movimiento);
		$this->salida = $dbFinalizarMovimiento->salida;
		$this->query = $dbFinalizarMovimiento->query;
		return $res;
	}
	function ContarFinalizarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ContarFinalizarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function RechazarMovimiento($id_movimiento) {
		$this->salida = "";
		$dbRechazarMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbRechazarMovimiento->RechazarMovimiento($id_movimiento);
		$this->salida = $dbRechazarMovimiento->salida;
		$this->query = $dbRechazarMovimiento->query;
		return $res;
	}
	function ContarRechazarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->ContarRechazarMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	function FinalizarEnviarMovimiento($id_movimiento) {
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->FinalizarEnviarMovimiento($id_movimiento);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	// ////////////////////cls_DBDetalleMovimiento.php//////////////////////////////
	function ListarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->ListarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	function ContarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->ContarDetalleMovimiento($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	function InsertarDetalleMovimiento($id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->InsertarDetalleMovimiento($id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	function ModificarDetalleMovimiento($id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->ModificarDetalleMovimiento($id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo,$costo_unitario,$costo_total);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	function EliminarDetalleMovimiento($id_detalle_movimiento) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->EliminarDetalleMovimiento($id_detalle_movimiento);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	function ValidarDetalleMovimiento($operacion_sql, $id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo) {
		$this->salida = "";
		$dbDetalleMovimiento = new cls_DBDetalleMovimiento($this->decodificar);
		$res = $dbDetalleMovimiento->ValidarDetalleMovimiento($operacion_sql, $id_detalle_movimiento, $id_movimiento, $id_item, $cantidad, $cantidad_solicitada, $tipo_saldo);
		$this->salida = $dbDetalleMovimiento->salida;
		$this->query = $dbDetalleMovimiento->query;
		return $res;
	}
	
	// ---------------------cls_DBSolicitudSalida.php------------//
	
	function ObtenerFechaUltimaSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ObtenerFechaUltimaSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	
	function ListarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ListarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function ContarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ContarSolicitudSalida($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function InsertarSolicitudSalida($id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->InsertarSolicitudSalida($id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function ModificarSolicitudSalida($id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ModificarSolicitudSalida($id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function EliminarSolicitudSalida($id_solicitud_salida) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->EliminarSolicitudSalida($id_solicitud_salida);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function ValidarSolicitudSalida($operacion_sql, $id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ValidarSolicitudSalida($operacion_sql, $id_solicitud_salida, $id_almacen, $id_unidad_organizacional, $id_empleado, $id_aprobador, $fecha_solicitud, $descripcion);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function EnviarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$dbEnviarSolicitud = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbEnviarSolicitud->EnviarSolicitud($id_solicitud_salida);
		$this->salida = $dbEnviarSolicitud->salida;
		$this->query = $dbEnviarSolicitud->query;
		return $res;
	}
	function AprobarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$dbAprobarSolicitud = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbAprobarSolicitud->AprobarSolicitud($id_solicitud_salida);
		$this->salida = $dbAprobarSolicitud->salida;
		$this->query = $dbAprobarSolicitud->query;
		return $res;
	}
	function ContarAprobarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ContarAprobarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	function RechazarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$dbRechazarSolicitud = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbRechazarSolicitud->RechazarSolicitud($id_solicitud_salida);
		$this->salida = $dbRechazarSolicitud->salida;
		$this->query = $dbRechazarSolicitud->query;
		return $res;
	}
	function ContarRechazarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ContarRechazarSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	
	function ProcesarSolicitud($id_solicitud_salida) {
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->ProcesarSolicitud($id_solicitud_salida);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	// ////////////////////cls_DBDetalleSolicitud.php//////////////////////////////
	function ListarDetalleSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->ListarDetalleSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	function ContarDetalleSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->ContarDetalleSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	function InsertarDetalleSolicitud($id_solicitud_salida, $id_item, $cantidad) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->InsertarDetalleSolicitud($id_solicitud_salida, $id_item, $cantidad);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	function ModificarDetalleSolicitud($id_detalle_solicitud, $id_solicitud_salida, $id_item, $cantidad) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->ModificarDetalleSolicitud($id_detalle_solicitud, $id_solicitud_salida, $id_item, $cantidad);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	function EliminarDetalleSolicitud($id_detalle_solicitud) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->EliminarDetalleSolicitud($id_detalle_solicitud);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	function ValidarDetalleSolicitud($operacion_sql, $id_detalle_solicitud, $id_solicitud_salida, $id_item, $cantidad) {
		$this->salida = "";
		$dbDetalleSolicitud = new cls_DBDetalleSolicitud($this->decodificar);
		$res = $dbDetalleSolicitud->ValidarDetalleSolicitud($operacion_sql, $id_detalle_solicitud, $id_solicitud_salida, $id_item, $cantidad);
		$this->salida = $dbDetalleSolicitud->salida;
		$this->query = $dbDetalleSolicitud->query;
		return $res;
	}
	//aniadido 30-05-2014 cls_DBStockItem
	function ContarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->ContarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	function ListarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->ListarStockItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	function ValidarStockItem($operacion_sql, $id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->ValidarStockItem($operacion_sql, $id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	function InsertarStockItem($id_almacen, $id_item, $stock_minimo, $stock_maximo)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->InsertarStockItem($id_almacen, $id_item, $stock_minimo, $stock_maximo);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	function ModificarStockItem($id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->ModificarStockItem($id_stock_item, $id_almacen, $id_item, $stock_minimo, $stock_maximo);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	function EliminarStockItem($hidden_id_stock_item)
	{
		$this->salida = "";
		$dbStockItem = new cls_DBStockItem($this->decodificar);
		$res = $dbStockItem->EliminarStockItem($hidden_id_stock_item);
		$this->salida = $dbStockItem->salida;
		$this->query = $dbStockItem->query;
		return $res;
	}
	//cls_DBMovimiento 09062014
	function AccionesMovimiento($id_movimiento,$tipo_movmiento,$aprobacion,$accion_movimiento)
	{
		$this->salida = "";
		$dbMovimiento = new cls_DBMovimiento($this->decodificar);
		$res = $dbMovimiento->AccionesMovimiento($id_movimiento,$tipo_movmiento,$aprobacion,$accion_movimiento);
		$this->salida = $dbMovimiento->salida;
		$this->query = $dbMovimiento->query;
		return $res;
	}
	//cls_DBSolicitudSalida 16062014
	function AccionesSolicitud($id_solicitud_salida,$accion_solicitud)
	{
		$this->salida = "";
		$dbSolicitudSalida = new cls_DBSolicitudSalida($this->decodificar);
		$res = $dbSolicitudSalida->AccionesSolicitud($id_solicitud_salida,$accion_solicitud);
		$this->salida = $dbSolicitudSalida->salida;
		$this->query = $dbSolicitudSalida->query;
		return $res;
	}
	//reportes
	function ListarDatosEncargadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ListarDatosEncargadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	
	function ListarMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ListarMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function  ListarMovimientoReporteSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ListarMovimientoReporteSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ListarReporteSolicitudSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ListarReporteSolicitudSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ListarPieMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";  
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ListarPieMovimientoReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ReporteControlExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteControlExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
		
	//cls_DBUnidadConstructiva
	function ListarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query;
		return $res;
	}
	function InsertarUnidadConstructivaArb($id_unidad_constructiva_fk,$codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->InsertarUnidadConstructivaArb($id_unidad_constructiva_fk,$codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query;
		return $res;
	}
	
	function ModificarUnidadConstructivaArb($id_unidad_constructiva,$id_unidad_constructiva_fk, $codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->ModificarUnidadConstructivaArb($id_unidad_constructiva,$id_unidad_constructiva_fk, $codigo,$nombre,$descripcion,$observaciones,$estado,$orden,$cod_tramo);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query; 
		return $res;
	}
	function EliminarUnidadConstructivaArb($id_unidad_constructiva)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->EliminarUnidadConstructivaArb($id_unidad_constructiva);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query;
		return $res;
	}
	function ContarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{ 
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->ContarUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query;
		return $res;
	}
	function ListarUnidadConstructivaTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva->ListarUnidadConstructivaTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbUnidadConstructiva->salida;
		$this->query = $dbUnidadConstructiva->query;
		return $res;
	}
	//cls_DBDetalleUnidadConstructiva
	function CountDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->CountDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad); 
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	
	function ListarDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = ""; 
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->ListarDetalleUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	function ValidarDestalleUnidadConstructiva($sql, $id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->ValidarDestalleUnidadConstructiva($sql, $id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	function InsertarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion,$orden_duc)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->InsertarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion,$orden_duc);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	function ModificarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion,$orden_duc)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->ModificarDetalleUnidadConstructiva($id_detalle_unidad_constructiva, $id_unidad_constructiva, $id_item, $cantidad, $descripcion,$orden_duc);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	function EliminarDetalleUnidadConstructiva($id_detalle_unidad_constructiva)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->EliminarDetalleUnidadConstructiva($id_detalle_unidad_constructiva);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	//a�adido 23-10-2014 moviemiento de proyectos
	function ContarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->ContarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	function ListarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = ""; 
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->ListarMovimientoProyecto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	function ValidarMovimientoProyecto($sql, $id_movimiento_proyecto, $almacen,$fecha_ingreso, $concepto_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->ValidarMovimientoProyecto($sql, $id_movimiento_proyecto, $almacen,$fecha_ingreso, $concepto_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	function InsertarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato,$peso_neto)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->InsertarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato,$peso_neto);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	function ModificarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->ModificarMovimientoProyecto($id_movimiento_proyecto, $almacen,$tipo_mov , $concepto_ingreso, $fecha_ingreso, $origen_ingreso, $proveedor, $contratista,$empleado,$institucion,$observaciones,$entregado_por,$nota_remision,$nro_contrato);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res; 
	}
	function EliminarMovimientoProyecto($id_movimiento_proyecto)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->EliminarMovimientoProyecto($id_movimiento_proyecto);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	function FinalizarMovimientoProyecto($id_movimiento_proy)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->FinalizarMovimientoProyecto($id_movimiento_proy);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	//a�adido 10/07/2015
	function CorregirMovimientoProyectoIngreso($id_movimiento_proyecto)
	{
		$this->salida = "";
		$dbMovimientoProyecto = new cls_DBMovimientoProyecto($this->decodificar);
		$res = $dbMovimientoProyecto->CorregirMovimientoProyectoIngreso($id_movimiento_proyecto);
		$this->salida = $dbMovimientoProyecto->salida;
		$this->query = $dbMovimientoProyecto->query;
		return $res;
	}
	
	
	function ContarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ContarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function ListarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ListarMovimientoProyectoDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function ValidarMovimientoProyectoDet($sql, $id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ValidarMovimientoProyectoDet($sql, $id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function InsertarMovimientoProyectoDet($id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->InsertarMovimientoProyectoDet($id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function ModificarMovimientoProyectoDet($id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ModificarMovimientoProyectoDet($id_mov_proy_det, $id_mov_proy, $id_item, $cantidad, $unidad,$costo_unitario);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function EliminarMovimientoProyectoDet($id_mov_proy_det)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->EliminarMovimientoProyectoDet($id_mov_proy_det); 
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	function ProcesarArchivo($file,$id_proy,$ruta)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ProcesarArchivo($file,$id_proy,$ruta);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	//a�adido 12-05-2015
	function ProcesarArchivoItemsProyecto($file,$id_proy,$ruta)
	{
		$this->salida = "";
		$dbMovimientoProyectoDet = new cls_DBMovimientoProyectoDet($this->decodificar);
		$res = $dbMovimientoProyectoDet->ProcesarArchivoItemsProyecto($file,$id_proy,$ruta);
		$this->salida = $dbMovimientoProyectoDet->salida;
		$this->query = $dbMovimientoProyectoDet->query;
		return $res;
	}
	
	
	function InsertarDetalleUnidadConstructivaItem($id_unidad_constructiva,$id_item,$cantidad)
	{
		$this->salida = "";
		$dbDetalleUnidadConstructiva = new cls_DBDetalleUnidadConstructiva($this->decodificar);
		$res = $dbDetalleUnidadConstructiva->InsertarDetalleUnidadConstructivaItem($id_unidad_constructiva,$id_item,$cantidad);
		$this->salida = $dbDetalleUnidadConstructiva->salida;
		$this->query = $dbDetalleUnidadConstructiva->query;
		return $res;
	}
	
	function ContarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ContarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ListarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ListarItemUC($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ContarFase($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->ContarFase($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	function ListarFase($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->ListarFase($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	function ValidarFase($sql,$id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->ValidarFase($sql,$id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	function InsertarFase($id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase, $sw_tramo,$estado_fase)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->InsertarFase($id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase, $sw_tramo,$estado_fase);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	function ModificarFase($id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase, $sw_tramo,$estado_fase)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->ModificarFase($id_fase, $id_almacen, $cod_fase, $desc_fase, $obs_fase, $sw_tramo,$estado_fase);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	function EliminarFase($id_fase)
	{
		$this->salida = "";
		$dbFase = new cls_DBFase($this->decodificar);
		$res = $dbFase->EliminarFase($id_fase);
		$this->salida = $dbFase->salida;
		$this->query = $dbFase->query;
		return $res;
	}
	//tramo
	function ContarTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo->ContarTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	function ListarTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo->ListarTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	function ValidarTramo($sql,$id_tramo,$cod_tramo,$desc_tramo,$obs_tramo,$estado_tramo)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo->ValidarTramo($sql,$id_tramo,$cod_tramo,$desc_tramo,$obs_tramo,$estado_tramo);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	function InsertarTramo($id_tramo, $cod_tramo, $desc_tramo, $obs_tramo, $estado_tramo)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo->InsertarTramo($id_tramo, $cod_tramo, $desc_tramo, $obs_tramo, $estado_tramo);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	function ModificarTramo($id_tramo, $cod_tramo, $desc_tramo, $obs_tramo, $estado_tramo)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo->ModificarTramo($id_tramo, $cod_tramo, $desc_tramo, $obs_tramo, $estado_tramo);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	
	function EliminarTramo($id_tramo)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo-> EliminarTramo($id_tramo);
		$this->salida = $dbTramo->salida;
		$this->query = $dbTramo->query;
		return $res;
	}
	//fase-tramo
	function ContarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->ContarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	function ListarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->ListarFaseTramo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	function ValidarFaseTramo($sql,$id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->ValidarFaseTramo($sql,$id_fase_tramo,$id_fase, $id_tramo, $estado);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	function InsertarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->InsertarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	function ModificarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->ModificarFaseTramo($id_fase_tramo, $id_fase, $id_tramo, $estado);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	function EliminarFaseTramo($id_fase_tramo)
	{
		$this->salida = "";
		$dbTramoFase = new cls_DBFaseTramo($this->decodificar);
		$res = $dbTramoFase->EliminarFaseTramo($id_fase_tramo);
		$this->salida = $dbTramoFase->salida;
		$this->query = $dbTramoFase->query;
		return $res;
	}
	//tramo-_unidad_constructiva
	function ContarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->ContarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}
	function ListarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->ListarTramoUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}
	function ValidarTramoUC($sql,$id_tramo_uc,$id_tramo, $id_uc,$estado)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->ValidarTramoUC($sql,$id_tramo_uc,$id_tramo, $id_uc,$estado);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}	
	function InsertarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->InsertarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}
	function ModificarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->ModificarTramoUC($id_tramo_uc, $id_tramo, $id_uc, $estado);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}
	function EliminarTramoUC($id_tramo_uc)
	{
		$this->salida = "";
		$dbTramoUC = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUC->EliminarTramoUC($id_tramo_uc);
		$this->salida = $dbTramoUC->salida;
		$this->query = $dbTramoUC->query;
		return $res;
	}
	//cls_DBSalidaUnidadConstructiva
	function ContarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->ContarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	function ListarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->ListarSalidaUnidadConstructiva($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	
	function ValidarSalidaUC($sql, $id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal,$observaciones
							,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor
							,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{

		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->ValidarSalidaUC($sql, $id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal,$observaciones
							,$origen_sal,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor
							,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	
	function InsertarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
							,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->InsertarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
							,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	function ModificarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
							,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->ModificarSalidaUC($id_salida_uc, $id_almacen, $num_contrato, $fecha_sal, $concepto_sal, $observaciones,$origen_sal
							,$id_proveedor,$id_contratista,$id_empleado,$id_institucion,$id_fase,$id_tramo,$id_uc,$supervisor,$ci_supervisor,$receptor,$ci_receptor,$solicitante,$ci_solicitante);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	function EliminarSalidaUC($id_salida_uc)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->EliminarSalidaUC($id_salida_uc);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	function ProcesarMovimientoSalidaProyecto($id_salida_uc,$accion)
	{
		$this->salida = "";
		$dbSalidaUC = new cls_DBSalidaUnidadConstructiva($this->decodificar);
		$res = $dbSalidaUC->ProcesarMovimientoSalidaProyecto($id_salida_uc,$accion);
		$this->salida = $dbSalidaUC->salida;
		$this->query = $dbSalidaUC->query;
		return $res;
	}
	
	//salida_uc_detalle
	function ContarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ContarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function ListarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ListarSalidaUCDet($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function ValidarSalidaUCDet($sql,$id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet-> ValidarSalidaUCDet($sql,$id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function InsertarSalidaUCDet($id_salida_uc_det, $is_salida_uc, $id_uc, $cantidad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->InsertarSalidaUCDet($id_salida_uc_det, $is_salida_uc, $id_uc, $cantidad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function ModificarSalidaUCDet($id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ModificarSalidaUCDet($id_salida_uc_det, $id_salida_uc, $id_uc, $cantidad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function EliminarSalidaUCDet($id_salida_uc_det)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->EliminarSalidaUCDet($id_salida_uc_det);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	//alma.tal_salida_uc_detalle_item
	function ContarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ContarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function ListarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ListarSalidaUCDetItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	function ModificarSalidaUCDetItem($id_salida_uc_det_item, $demasia)
	{
		$this->salida = "";
		$dbSalidaUCDet = new cls_DBSalidaUnidadConstructivaDet($this->decodificar);
		$res = $dbSalidaUCDet->ModificarSalidaUCDetItem($id_salida_uc_det_item, $demasia);
		$this->salida = $dbSalidaUCDet->salida;
		$this->query = $dbSalidaUCDet->query;
		return $res;
	}
	//tal_costeo
	function ContarCosteo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->ContarCosteo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	function ListarCosteo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->ListarCosteo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	function InsertarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->InsertarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res; 
	}
	function ModificarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->ModificarCosteo($id_costeo, $descripcion, $fecha_ingreso, $fecha_salida, $id_almacen,$id_mov_proy,$tipo_costeo);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	function EliminarCosteo($id_costeo)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->EliminarCosteo($id_costeo);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	function CostearIngresos($id_costeo,$tipo_costeo)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->CostearIngresos($id_costeo,$tipo_costeo);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	//a�adido 10/07/2015
	function CorregirCosteo($id_costeo,$estado_costeo)
	{
		$this->salida = "";
		$dbCosteo = new cls_DBCosteo($this->decodificar);
		$res = $dbCosteo->CorregirCosteo($id_costeo,$estado_costeo);
		$this->salida = $dbCosteo->salida;
		$this->query = $dbCosteo->query;
		return $res;
	}
	
	
	//fin tal_costeo
	//inicio tal_ingresos
	function ContarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbIngresos = new cls_DBIngresos($this->decodificar);
		$res = $dbIngresos->ContarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbIngresos->salida;
		$this->query = $dbIngresos->query;
		return $res;
	}
	function ListarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbIngresos = new cls_DBIngresos($this->decodificar);
		$res = $dbIngresos->ListarIngresosFinalizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbIngresos->salida;
		$this->query = $dbIngresos->query;
		return $res;
	}
	function InsertarIngresosFinalizadoso($id_ingresos, $id_costeo, $id_mov_proyecto,$seleccionado)
	{
		$this->salida = "";
		$dbIngresos = new cls_DBIngresos($this->decodificar);
		$res = $dbIngresos->InsertarIngresosFinalizadoso($id_ingresos, $id_costeo, $id_mov_proyecto,$seleccionado);
		$this->salida = $dbIngresos->salida;
		$this->query = $dbIngresos->query;
		return $res;
	}
	function ModificarIngresosFinalizados($id_ingresos, $id_costeo, $id_mov_proyecto, $seleccionado)
	{
		$this->salida = "";
		$dbIngresos = new cls_DBIngresos($this->decodificar);
		$res = $dbIngresos->ModificarIngresosFinalizados($id_ingresos, $id_costeo, $id_mov_proyecto, $seleccionado);
		$this->salida = $dbIngresos->salida;
		$this->query = $dbIngresos->query;
		return $res;
	}
	function EliminarIngresosFinalizados($hidden_id_ingresos)
	{
		$this->salida = "";
		$dbIngresos = new cls_DBIngresos($this->decodificar);
		$res = $dbIngresos->EliminarIngresosFinalizados($hidden_id_ingresos);
		$this->salida = $dbIngresos->salida;
		$this->query = $dbIngresos->query;
		return $res;
	}
	//fin tal_ingresos
	
	//inicio tal_costo
	function ContarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosto = new cls_DBCosto($this->decodificar);
		$res = $dbCosto->ContarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosto->salida;
		$this->query = $dbCosto->query;
		return $res;
	}
	function ListarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosto = new cls_DBCosto($this->decodificar);
		$res = $dbCosto->ListarCosto($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosto->salida;
		$this->query = $dbCosto->query;
		return $res;
	}
	function InsertarCosto($id_costo, $cod_costo, $desc_costo, $estado)
	{
		$this->salida = "";
		$dbCosto = new cls_DBCosto($this->decodificar);
		$res = $dbCosto->InsertarCosto($id_costo, $cod_costo, $desc_costo, $estado);
		$this->salida = $dbCosto->salida;
		$this->query = $dbCosto->query;
		return $res;
	}
	function ModificarCosto($id_costo, $cod_costo, $desc_costo, $estado)
	{
		$this->salida = "";
		$dbCosto = new cls_DBCosto($this->decodificar);
		$res = $dbCosto->ModificarCosto($id_costo, $cod_costo, $desc_costo, $estado);
		$this->salida = $dbCosto->salida;
		$this->query = $dbCosto->query;
		return $res;
	}
	function EliminarCosto($id_costo)
	{
		$this->salida = "";
		$dbCosto = new cls_DBCosto($this->decodificar);
		$res = $dbCosto->EliminarCosto($id_costo);
		$this->salida = $dbCosto->salida;
		$this->query = $dbCosto->query;
		return $res;
	}
	//fin tal_costo
	//inicio tal_costeo_detalle
	function ContarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosteoDetalle = new cls_DBCosteoDetalle($this->decodificar);
		$res = $dbCosteoDetalle->ContarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosteoDetalle->salida;
		$this->query = $dbCosteoDetalle->query;
		return $res;
	}
	function ListarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbCosteoDetalle = new cls_DBCosteoDetalle($this->decodificar);
		$res = $dbCosteoDetalle->ListarCosteoDetalle($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbCosteoDetalle->salida;
		$this->query = $dbCosteoDetalle->query;
		return $res;
	}
	function InsertarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado)
	{
		$this->salida = "";
		$dbCosteoDetalle = new cls_DBCosteoDetalle($this->decodificar);
		$res = $dbCosteoDetalle->InsertarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado);
		$this->salida = $dbCosteoDetalle->salida;
		$this->query = $dbCosteoDetalle->query;
		return $res;
	}
	function ModificarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado)
	{
		$this->salida = "";
		$dbCosteoDetalle = new cls_DBCosteoDetalle($this->decodificar);
		$res = $dbCosteoDetalle->ModificarCostoDetalle($id_costeo_det, $id_costeo, $id_costo, $valor_costo,$estado);
		$this->salida = $dbCosteoDetalle->salida;
		$this->query = $dbCosteoDetalle->query;
		return $res;
	}
	function EliminarCosteoDetalle($id_costeo_det)
	{
		$this->salida = "";
		$dbCosteoDetalle = new cls_DBCosteoDetalle($this->decodificar);
		$res = $dbCosteoDetalle->EliminarCosteoDetalle($id_costeo_det);
		$this->salida = $dbCosteoDetalle->salida;
		$this->query = $dbCosteoDetalle->query;
		return $res;
	}
	
	function ReporteClasificacionItems($cant, $puntero, $sortdir, $sortcol, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteClasificacionItems($cant, $puntero, $sortdir, $sortcol, $criterio_filtro);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	//fin tal_costeo_detalle
	
	function ReporteTipoMovimientos($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteTipoMovimientos($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ReporteTipoMovimientosSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteTipoMovimientosSolicitud($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ReporteSalidasGeneral( $cant, $puntero, $sortcol, $sortdir, $criterio_filtro )
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteSalidasGeneral( $cant, $puntero, $sortcol, $sortdir, $criterio_filtro );
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ContarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ContarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ListarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->ListarItemsValorizados($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ReporteKardexItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteKardexItem( $cant, $puntero, $sortcol, $sortdir, $criterio_filtro );
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	function ReporteExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro)
	{
		$this->salida = "";
		$dbReporte = new cls_DBReportes($this->decodificar);
		$res = $dbReporte->ReporteExistenciasAlmacen($cant, $puntero, $sortcol, $sortdir, $criterio_filtro);
		$this->salida = $dbReporte->salida;
		$this->query = $dbReporte->query;
		return $res;
	}
	
	//Tipo Material
	function ContarTipoMaterial($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial->ContarTipoMaterial($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	
	function ListarTipoMaterial($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial->ListarTipoMaterial($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function InsertarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial->InsertarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function ModificarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial->ModificarTipoMaterial($id_tipo_material, $codigo, $desc_tipo, $nombre_tipo);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function EliminarTipoMaterial($id_tipo_material)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial->EliminarTipoMaterial($id_tipo_material);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function AgregarModificarTipoMaterial($id_item,$id_tipo_material)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->AgregarModificarTipoMaterial($id_item,$id_tipo_material);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function AgregarRegistroTipoMaterial($id_tipo_material)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem->AgregarRegistroTipoMaterial($id_tipo_material);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function InsertarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->InsertarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	function InsertarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->InsertarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function InsertarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->InsertarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function ListarUbicacionItemRaices($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->ListarUbicacionItemRaices($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function ListarUbicacionItemRamaNodo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->ListarUbicacionItemRamaNodo($cant, $puntero, $sortcol, $sortdir, $criterio_filtro,$hidden_id_financiadora,$hidden_id_regional, $hidden_ep_id_programa, $hidden_ep_id_proyecto, $hidden_ep_id_actividad,$id_alma,$nodo,$id_item);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	function EliminarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->EliminarUbicacionItemRaiz($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	function EliminarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->EliminarUbicacionItemNodo($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function EliminarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->EliminarUbicacionItemRama($id_ubicacion,$id_item,$id_almacen);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function ContarOrdenUbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->ContarOrdenUbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	function ListarOrdenbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->ListarOrdenbicacionItem($cant, $puntero, $sortcol, $sortdir, $criterio_filtro, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
	
	function EditarOrdenUbicacion($id_ubicacion_item,$id_almacen,$id_item,$maxing,$maxsal,$orden_actual,$orden_anterior)
	{
		$this->salida = "";
		$dbUbicacionItemDetalle = new cls_DBUbicacionItemDetalle($this->decodificar);
		$res = $dbUbicacionItemDetalle->EditarOrdenUbicacion($id_ubicacion_item,$id_almacen,$id_item,$maxing,$maxsal,$orden_actual,$orden_anterior);
		$this->salida = $dbUbicacionItemDetalle->salida;
		$this->query = $dbUbicacionItemDetalle->query;
		return $res;
	}
	
}
?>