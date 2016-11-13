<?php
/**
 * Nombre de la Clase:	    CustomDBAlmacenes
 * Propósito:				Interfaz del modelo del Sistema de Almacenes
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		26-10-2007
 * Autor:					Fernando Prudencio cardona
 *
 */
class cls_CustomDBAlmacenes
{
	//variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida = "";

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query = "";

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;
	

	function __construct()
	{
		
		include_once("cls_DBSuperGrupo.php");
		include_once("cls_DBGrupo.php");
		include_once("cls_DBSubGrupo.php");
		include_once("cls_DBId1.php");
		include_once("cls_DBId2.php");
		include_once("cls_DBId3.php");
		include_once("cls_DBItem.php");
		include_once("cls_DBTipoSector.php");
		include_once("cls_DBTipoTransferencia.php");
		include_once("cls_DBCodigoFabricante.php");
		include_once("cls_DBItemReemplazo.php");
		include_once("cls_DBCaracteristicaItem.php");
		include_once("cls_DBTipoSectorSg.php");
		include_once("cls_DBAlmacenSector.php");
		include_once("cls_DBEstante.php");
		include_once("cls_DBItemUbicacion.php");
		include_once("cls_DBAlmacen.php");
		include_once("cls_DBAlmacenEp.php");
		include_once("cls_DBAlmacenLogico.php");
		include_once("cls_DBResponsableAlmacen.php");
		include_once("cls_DBTipoAlmacen.php");
		include_once("cls_DBFirmaAutorizada.php");
		include_once("cls_DBTipoMaterial.php");
		include_once("cls_DBTipoCaracteristica.php");
		include_once("cls_DBCaracteristica.php");
		include_once("cls_DBMotivoIngreso.php");
		include_once("cls_DBMotivoIngresoCuenta.php");
		include_once("cls_DBMotivoSalida.php");
		include_once("cls_DBMotivoSalidaCuenta.php");
		include_once("cls_DBParametroAlmacen.php");
		include_once("cls_DBCorrelativo.php");
		include_once("cls_DBCierreAlmacen.php");
		include_once("cls_DBAperturaAlmacen.php");
		include_once("cls_DBAlmacenGestion.php");
		////----------------------------------------////
		include_once("DBSalida/cls_DBSalida.php");
		include_once("DBSalida/cls_DBSalidaDetalle.php");
	}		
	
	/// --------------------- tal_salida --------------------- ////

	
	function ListarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ListarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	function ContarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ContarSalidaAprobacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function ListarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ListarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	function ContarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ContarSalidaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function ListarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ListarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	function ContarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ContarSalidaFinalizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function ListarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ListarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	function ContarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ContarSalidaConsolidada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function ModificarSalidaPendiente($id_salida,$estado_salida,$estado_registro)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ModificarSalidaPendiente($id_salida,$estado_salida,$estado_registro);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function AprobarSalida($id_salida,$obs)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->AprobarSalida($id_salida,$obs);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function FinalizarSalida($id_salida)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->FinalizarSalida($id_salida);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function FinalizarSalidaProy($id_salida)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->FinalizarSalidaProy($id_salida);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function RechazarSalida($id_salida,$obs)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->RechazarSalida($id_salida,$obs);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function CorreccionSalida($id_salida,$obs)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->CorreccionSalida($id_salida,$obs);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	function ConsolidarSalida($id_salida)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ConsolidarSalida($id_salida);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	/// --------------------- fin tal_salida --------------------- ///
/// --------------------- tal_salida_detalle --------------------- ///

		
	function ModificarSalidaDetallePendiente($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ModificarSalidaDetallePendiente($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}
	function ModificarSalidaDetalleConsolidada($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ModificarSalidaDetalleConsolidada($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}
		function ContarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ContarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}
	
	
	/// --------------------- fin tal_salida_detalle --------------------- ///
	/// --------------------- cierre_almacen --------------------- ///	
 function CierreAlmacenMensual($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$dbCierreAlm = new cls_DBCierreAlmacen($this->decodificar);
		$res = $dbCierreAlm ->CierreAlmacenMensual($id_almacen,$fecha_cierre);
		$this->salida = $dbCierreAlm ->salida;
		$this->query = $dbCierreAlm ->query;
		return $res;
	}
function CierreAlmacenGestion($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$dbCierreAlm = new cls_DBCierreAlmacen($this->decodificar);
		$res = $dbCierreAlm ->CierreAlmacenGestion($id_almacen,$fecha_cierre);
		$this->salida = $dbCierreAlm ->salida;
		$this->query = $dbCierreAlm ->query;
		return $res;
	}
function CierreAlmacenDefinitivo($id_almacen,$fecha_cierre)
	{
		$this->salida = "";
		$dbCierreAlm = new cls_DBCierreAlmacen($this->decodificar);
		$res = $dbCierreAlm ->CierreAlmacenDefinitivo($id_almacen,$fecha_cierre);
		$this->salida = $dbCierreAlm ->salida;
		$this->query = $dbCierreAlm ->query;
		return $res;
	}		
	/// --------------------- fin cierre_almacen --------------------- ///
	/// --------------------- apertura_almacen --------------------- ///	
 function AperturaAlmacenGestion($id_almacen,$fecha_apertura)
	{
		$this->salida = "";
		$dbAperturaAlm = new cls_DBAperturaAlmacen($this->decodificar);
		$res = $dbAperturaAlm ->AperturaAlmacenGestion($id_almacen,$fecha_apertura);
		$this->salida = $dbAperturaAlm ->salida;
		$this->query = $dbAperturaAlm ->query;
		return $res;
	}
	/// --------------------- fin apertura_almacen --------------------- ///
/// --------------------- almacen_gestion --------------------- ///	
  function ListarAlmacenGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen)
	{
		$this->salida = "";
		$dbAlmGes = new cls_DBAlmacenGestion($this->decodificar);
		$res = $dbAlmGes ->ListarAlmacenGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen);
		$this->salida = $dbAlmGes ->salida;
		$this->query = $dbAlmGes ->query;
		return $res;
	}
 function ContarAlmacenGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen)
	{
		$this->salida = "";
		$dbAlmGes = new cls_DBAlmacenGestion($this->decodificar);
		$res = $dbAlmGes ->ContarAlmacenGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen);
		$this->salida = $dbAlmGes ->salida;
		$this->query = $dbAlmGes ->query;
		return $res;
	}	
	/// --------------------- fin almacen_gestion --------------------- ///
}
?>