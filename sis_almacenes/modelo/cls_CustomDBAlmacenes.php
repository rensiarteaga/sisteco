<?php
/**
 * Nombre de la Clase:	    CustomDBAlmacenes
 * Propósito:				Interfaz del modelo del Sistema de Almacenes
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		27-09-2007
 * Autor:					Rodrigo Chumacero Moscoso
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

	////include("rac_cls_CustomDBAlmacenes.php");

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
		include_once("cls_DBKardexLogico.php");
		include_once("DBTransferencia/cls_DBTransferencia.php");
		include_once("DBTransferencia/cls_DBTransferenciaDet.php");
		include_once("cls_DBActualizacionValor.php");
		include_once("cls_DBOrdenSalidaUCDetalle.php");
		include_once("cls_DBItemArchivo.php");
		include_once("cls_DBTramo.php");
		include_once("cls_DBTramoSubactividad.php");
		include_once("cls_DBTramoUnidadConstructiva.php");

		include_once("cls_DBUnidadConstructiva.php");
		include_once("cls_DBSupervisor.php");
		include_once("cls_DBItemCuentaPartida.php");
		include_once("cls_DBKardexItem.php");
		include_once("cls_DBMaterialEntregado.php");
		include_once("cls_DBValoracion.php");
		include_once("cls_DBParametroAlmacenLogico.php");
		include_once("cls_DBPedidoTucInt.php");
	}



	//// --------------------- PARAMETROS ALMACEN --------------------- ///

	function ListarParametrosAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm ->ListarParametrosAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	function ContarParametrosAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm ->ContarParametrosAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	function InsertarParametrosAlmacen($id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm ->InsertarParametrosAlmacen($id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	function EliminarParametrosAlmacen($id_parametros_almacen)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm -> EliminarParametrosAlmacen($id_parametros_almacen);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	function ModificarParametrosAlmacen($id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm ->ModificarParametrosAlmacen($id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	function ValidarParametrosAlmacen($operacion_sql,$id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParamAlm = new cls_DBParametrosAlmacen($this->decodificar);
		$res = $dbParamAlm ->ValidarParametrosAlmacen($operacion_sql,$id_parametros_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
		$this->salida = $dbParamAlm->salida;
		$this->query = $dbParamAlm->query;
		return $res;
	}
	/// --------------------- FIN PARAMETROS ALMACEN --------------------- ///

	/// --------------------- tal_tipo_sector --------------------- ///

	function ListarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ListarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	function ContarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ContarTipoSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	function InsertarTipoSector($id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->InsertarTipoSector($id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	function ModificarTipoSector($id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ModificarTipoSector($id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	function EliminarTipoSector($id_tipo_sector)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector -> EliminarTipoSector($id_tipo_sector);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	function ValidarTipoSector($operacion_sql,$id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoSector = new cls_DBTipoSector($this->decodificar);
		$res = $dbTipoSector ->ValidarTipoSector($operacion_sql,$id_tipo_sector,$codigo,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbTipoSector ->salida;
		$this->query = $dbTipoSector ->query;
		return $res;
	}

	/// --------------------- fin tal_tipo_sector --------------------- ///


	/// --------------------- tal_tipo_transferencia --------------------- ///

	function ListarTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia ->ListarTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}

	function ContarTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia ->ContarTipoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}

	function InsertarTipoTransferencia($id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia ->InsertarTipoTransferencia($id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}

	function ModificarTipoTransferencia($id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia ->ModificarTipoTransferencia($id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}

	function EliminarTipoTransferencia($id_tipo_transferencia)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia -> EliminarTipoTransferencia($id_tipo_transferencia);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}

	function ValidarTipoTransferencia($operacion_sql,$id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoTransferencia = new cls_DBTipoTransferencia($this->decodificar);
		$res = $dbTipoTransferencia ->ValidarTipoTransferencia($operacion_sql,$id_tipo_transferencia,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoTransferencia ->salida;
		$this->query = $dbTipoTransferencia ->query;
		return $res;
	}
	
	
	/// --------------------- fin tal_tipo_transferencia --------------------- ///


	/// --------------------- tal_codigo_fabricante --------------------- ///

	function ListarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ListarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function ContarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ContarCodigoFabricante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function EliminarCodigoFabricante($id_codigo_fabricante)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante -> EliminarCodigoFabricante($id_codigo_fabricante);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$anio,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	/// --------------------- fin tal_codigo_fabricante --------------------- ///
	/// --------------------- tal_item_reemplazo (generadooooo) --------------------- ///

	function ListarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ListarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	function ContarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ContarItemReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	function InsertarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->InsertarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	function ModificarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ModificarItemReemplazo($id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	function EliminarItemReemplazo($id_item_reemplazo)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo -> EliminarItemReemplazo($id_item_reemplazo);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	function ValidarItemReemplazo($operacion_sql,$id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante)
	{
		$this->salida = "";
		$dbItemReemplazo = new cls_DBItemReemplazo($this->decodificar);
		$res = $dbItemReemplazo ->ValidarItemReemplazo($operacion_sql,$id_item_reemplazo,$descripcion,$observaciones,$fecha_reg,$id_item,$id_item_reemplazante);
		$this->salida = $dbItemReemplazo ->salida;
		$this->query = $dbItemReemplazo ->query;
		return $res;
	}

	/// --------------------- fin tal_item_reemplazo (generadooooo) --------------------- ///

	function ListarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ListarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function ContarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ContarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function InsertarCaracteristicaItem($id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->InsertarCaracteristicaItem($id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function EliminarCaracteristicaItem($id_caracteristica_item)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem -> EliminarCaracteristicaItem($id_caracteristica_item);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function ModificarCaracteristicaItem($id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ModificarCaracteristicaItem($id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function ValidarCaracteristicaItem($operacion_sql,$id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ValidarCaracteristicaItem($operacion_sql,$id_caracteristica_item,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	/// --------------------- FIN CARACTERISTICA ITEM--------------------- ///

	/// --------------------- tal_tipo_sector_sg --------------------- ///

	function ListarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ListarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	function ContarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ContarTipoSectorSg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	function InsertarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->InsertarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	function ModificarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ModificarTipoSectorSg($id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	function EliminarTipoSectorSg($id_tal_tipo_sector_sg)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg -> EliminarTipoSectorSg($id_tal_tipo_sector_sg);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	function ValidarTipoSectorSg($operacion_sql,$id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo)
	{
		$this->salida = "";
		$dbTipoSectorSg = new cls_DBTipoSectorSg($this->decodificar);
		$res = $dbTipoSectorSg ->ValidarTipoSectorSg($operacion_sql,$id_tal_tipo_sector_sg,$id_tipo_sector,$id_supergrupo);
		$this->salida = $dbTipoSectorSg ->salida;
		$this->query = $dbTipoSectorSg ->query;
		return $res;
	}

	/// --------------------- fin tal_tipo_sector_sg --------------------- ///

	/// --------------------- tal_almacen_sector --------------------- ///

	function ListarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ListarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function ContarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ContarAlmacenSector($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function EliminarAlmacenSector($id_almacen_sector)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector -> EliminarAlmacenSector($id_almacen_sector);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen,$codigo);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	/// --------------------- fin tal_almacen_sector --------------------- ///

	/// --------------------- tal_estante --------------------- ///

	function ListarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ListarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ContarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ContarEstante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function InsertarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->InsertarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ModificarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ModificarEstante($id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function EliminarEstante($id_estante)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante -> EliminarEstante($id_estante);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ValidarEstante($operacion_sql,$id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector)
	{
		$this->salida = "";
		$dbEstante = new cls_DBEstante($this->decodificar);
		$res = $dbEstante ->ValidarEstante($operacion_sql,$id_estante,$codigo,$descripcion,$nivel_max,$via_fil,$via_col,$estado_registro,$fecha_reg,$id_almacen_sector);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	/// --------------------- fin tal_estante --------------------- ///

	/// --------------------- tal_item_ubicacion --------------------- ///

	function ListarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ListarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	function ContarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ContarItemUbicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	function InsertarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->InsertarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	function ModificarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ModificarItemUbicacion($id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	function EliminarItemUbicacion($id_item_ubicacion)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion -> EliminarItemUbicacion($id_item_ubicacion);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	function ValidarItemUbicacion($operacion_sql,$id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante)
	{
		$this->salida = "";
		$dbItemUbicacion = new cls_DBItemUbicacion($this->decodificar);
		$res = $dbItemUbicacion ->ValidarItemUbicacion($operacion_sql,$id_item_ubicacion,$nivel,$descripcion,$observaciones,$fecha_reg,$id_item,$id_estante);
		$this->salida = $dbItemUbicacion ->salida;
		$this->query = $dbItemUbicacion ->query;
		return $res;
	}

	/// --------------------- fin tal_item_ubicacion --------------------- ///

	/// --------------------- tal_almacen --------------------- ///

	function ListarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ListarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ListarAlmacenFisicoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ListarAlmacenEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}


	function ContarAlmacenFisicoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ContarAlmacenEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ModificarAlmacenBloqueo($id_almacen,$codigo,$nombre,$bloqueado)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ModificarAlmacenBloqueo($id_almacen,$codigo,$nombre,$bloqueado);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function EliminarAlmacen($id_almacen)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen -> EliminarAlmacen($id_almacen);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloqueado,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional,$superficie_m2);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	/// --------------------- fin tal_almacen --------------------- ///

	/// --------------------- tal_almacen_ep --------------------- ///

	function ListarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ListarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function ContarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ContarAlmacenEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}
	/////////////
	function ListarEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ListarEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function ContarEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ContarEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	///////////
	function InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function EliminarAlmacenEp($id_almacen_ep)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp -> EliminarAlmacenEp($id_almacen_ep);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$bloqueado,$cerrado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	/// --------------------- fin tal_almacen_ep --------------------- ///
	/// --------------------- tal_almacen_logico --------------------- ///

	function ListarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ListarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ListarAlmacenLogicoFisEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ListarAlmacenLogicoFisEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ListarAlmacenLogicoFisEpM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ListarAlmacenLogicoFisEpM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ContarAlmacenLogicoFisEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ContarAlmacenLogicoFisEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ContarAlmacenLogicoFisEpM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ContarAlmacenLogicoFisEPM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional,$txt_costeo_obligatorio)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional,$txt_costeo_obligatorio);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional,$txt_costeo_obligatorio)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado,$id_unidad_organizacional,$txt_costeo_obligatorio);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}
	function EliminarAlmacenLogico($id_almacen_logico)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico -> EliminarAlmacenLogico($id_almacen_logico);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen,$cerrado);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	/// --------------------- fin tal_almacen_logico --------------------- ///

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
	function ListarEmpleadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ListarEmpleadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen);
		$this->salida = $dbResponsableAlmacen ->salida;
		$this->query = $dbResponsableAlmacen ->query;
		return $res;
	}

	function ContarEmpleadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen)
	{
		$this->salida = "";
		$dbResponsableAlmacen = new cls_DBResponsableAlmacen($this->decodificar);
		$res = $dbResponsableAlmacen ->ContarEmpleadoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_almacen);
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

	/// --------------------- tal_tipo_almacen --------------------- ///

	function ListarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ListarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function ContarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ContarTipoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function InsertarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->InsertarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function ModificarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ModificarTipoAlmacen($id_tipo_almacen,$descripcion,$nombre,$contabilizar);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function EliminarTipoAlmacen($id_tipo_almacen)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen -> EliminarTipoAlmacen($id_tipo_almacen);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function ValidarTipoAlmacen($operacion_sql,$id_tipo_almacen,$descripcion,$nombre,$contabilizar)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ValidarTipoAlmacen($operacion_sql,$id_tipo_almacen,$descripcion,$nombre,$contabilizar);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	/// --------------------- fin tal_tipo_almacen --------------------- ///
	/// --------------------- tal_firma_autorizada --------------------- ///

	function ListarFirmaAutorizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ListarFirmaAutorizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function ContarFirmaAutorizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ContarFirmaAutorizada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function InsertarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->InsertarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function ModificarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ModificarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function EliminarFirmaAutorizada($id_firma_autorizada)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada -> EliminarFirmaAutorizada($id_firma_autorizada);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}
	function InsertarFirmaAutorizadaEP($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->InsertarFirmaAutorizadaEP($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function ModificarFirmaAutorizadaEP($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ModificarFirmaAutorizadaEP($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function EliminarFirmaAutorizadaEP($id_firma_autorizada)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada -> EliminarFirmaAutorizadaEP($id_firma_autorizada);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}
	function ValidarFirmaAutorizada($operacion_sql,$id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ValidarFirmaAutorizada($operacion_sql,$id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	/// --------------------- fin tal_firma_autorizada --------------------- ///

	/// --------------------- tal_motivo_ingreso --------------------- ///

	function ListarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ListarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ListarMotivoIngresoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ListarMotivoIngresoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ContarMotivoIngresoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ContarMotivoIngresoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function EliminarMotivoIngreso($id_motivo_ingreso)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso -> EliminarMotivoIngreso($id_motivo_ingreso);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo,$tipo);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	/// --------------------- fin tal_motivo_ingreso --------------------- ///

	/// --------------------- tal_motivo_ingreso_cuenta --------------------- ///

	function ListarMotivoIngresoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ListarMotivoIngresoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function ContarMotivoIngresoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ContarMotivoIngresoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function InsertarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->InsertarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function ModificarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ModificarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function EliminarMotivoIngresoCuenta($id_motivo_ingreso_cuenta)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta -> EliminarMotivoIngresoCuenta($id_motivo_ingreso_cuenta);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function ValidarMotivoIngresoCuenta($operacion_sql,$id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ValidarMotivoIngresoCuenta($operacion_sql,$id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	/// --------------------- fin tal_motivo_ingreso_cuenta --------------------- ///


	/// --------------------- tal_motivo_salida --------------------- ///

	function ListarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ListarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ListarMotivoSalidaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ListarMotivoSalidaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ContarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ContarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ContarMotivoSalidaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ContarMotivoSalidaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function InsertarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->InsertarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ModificarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ModificarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function EliminarMotivoSalida($id_motivo_salida)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida -> EliminarMotivoSalida($id_motivo_salida);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ValidarMotivoSalida($operacion_sql,$id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ValidarMotivoSalida($operacion_sql,$id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg,$codigo);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	/// --------------------- fin tal_motivo_salida --------------------- ///

	/// --------------------- tal_motivo_salida_cuenta --------------------- ///

	function ListarMotivoSalidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ListarMotivoSalidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function ContarMotivoSalidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ContarMotivoSalidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function InsertarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->InsertarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function ModificarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ModificarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function EliminarMotivoSalidaCuenta($id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta -> EliminarMotivoSalidaCuenta($id_motivo_salida_cuenta);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function ValidarMotivoSalidaCuenta($operacion_sql,$id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ValidarMotivoSalidaCuenta($operacion_sql,$id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_reg);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	/// --------------------- fin tal_motivo_salida_cuenta --------------------- ///

	/*
	/// --------------------- tal_correlativo --------------------- ///

	function ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo ->ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	function ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo ->ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	function InsertarCorrelativo($id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo ->InsertarCorrelativo($id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	function ModificarCorrelativo($id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo ->ModificarCorrelativo($id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	function EliminarCorrelativo($id_correlativo)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo -> EliminarCorrelativo($id_correlativo);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	function ValidarCorrelativo($operacion_sql,$id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
	$this->salida = "";
	$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
	$res = $dbCorrelativo ->ValidarCorrelativo($operacion_sql,$id_correlativo,$codigo,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
	$this->salida = $dbCorrelativo ->salida;
	$this->query = $dbCorrelativo ->query;
	return $res;
	}

	/// --------------------- fin tal_correlativo --------------------- ///*/

	/// --------------------- tal_parametro_almacen --------------------- ///

	function ListarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->ListarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function ContarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->ContarParametroAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function InsertarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->InsertarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function ModificarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->ModificarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta,$demasia_porc);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function EliminarParametroAlmacen($id_parametro_almacen)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen -> EliminarParametroAlmacen($id_parametro_almacen);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function ValidarParametroAlmacen($operacion_sql,$id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->ValidarParametroAlmacen($operacion_sql,$id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	/// --------------------- fin tal_parametro_almacen --------------------- ///

	/// --------------------- SUBGRUPO --------------------- ///

	function ListarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ListarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function ContarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ContarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	///////////////////////////////////////////////////////////////////////
	function ListarSubGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ListarSubGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function ContarSubGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ContarSubGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}


	function ListarSubGrupoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ListarSubGrupoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function ContarSubGrupoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ContarSubGrupoItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}

	function CrearItem($hidden_id_subgrupo,$txt_codigo,$txt_nombre,$txt_descripcion,$txt_observaciones,$txt_estado_registro,$txt_fecha_reg,$hidden_id_tipo_material,$hidden_id_grupo,$hidden_id_supergrupo,$txt_nivel_convertido,$txt_convertido,$txt_id_unidad_medida_base,$txt_costo_estimado,$txt_precio_estimado,$txt_stock_min)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->CrearItem($hidden_id_subgrupo,$txt_codigo,$txt_nombre,$txt_descripcion,$txt_observaciones,$txt_estado_registro,$txt_fecha_reg,$hidden_id_tipo_material,$hidden_id_grupo,$hidden_id_supergrupo,$txt_nivel_convertido,$txt_convertido,$txt_id_unidad_medida_base,$txt_costo_estimado,$txt_precio_estimado,$txt_stock_min);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	//////////////////////////////////////////////////////////////////////


	function InsertarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo,$registro)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->InsertarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo,$registro);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function EliminarSubGrupo($id_subgrupo)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo -> EliminarSubGrupo($id_subgrupo);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function ModificarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ModificarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	function ValidarSubGrupo($operacion_sql,$id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->ValidarSubGrupo($operacion_sql,$id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo);
		$this->salida = $dbSubGrupo->salida;
		$this->query = $dbSubGrupo->query;
		return $res;
	}
	/// --------------------- FIN SUBGRUPO --------------------- ///

	/// --------------------- ID1 --------------------- ///

	function ListarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ListarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function ContarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ContarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	/////////////////////////////////////////////////////////////
	function ListarId1Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ListarId1Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function ContarId1Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ContarId1Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	////////////////////////////////////////////////////////////
	function InsertarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->InsertarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function EliminarId1($id_id1)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 -> EliminarId1($id_id1);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function ModificarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ModificarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function CrearItemId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->CrearItemId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function ValidarId1($operacion_sql,$id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ValidarId1($operacion_sql,$id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	/// --------------------- FIN ID1 --------------------- ///

	/// --------------------- TIPO MATERIAL --------------------- ///

	function ListarTipoMaterial($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial ->ListarTipoMaterial($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function ContarTipoMaterial($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial ->ContarTipoMaterial($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function InsertarTipoMaterial($id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial ->InsertarTipoMaterial($id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function EliminarTipoMaterial($id_tipo_material)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial -> EliminarTipoMaterial($id_tipo_material);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function ModificarTipoMaterial($id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial ->ModificarTipoMaterial($id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	function ValidarTipoMaterial($operacion_sql,$id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoMaterial = new cls_DBTipoMaterial($this->decodificar);
		$res = $dbTipoMaterial ->ValidarTipoMaterial($operacion_sql,$id_tipo_material,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoMaterial->salida;
		$this->query = $dbTipoMaterial->query;
		return $res;
	}
	/// --------------------- FIN TIPO MATERIAL --------------------- ///

	/// --------------------- ITEM --------------------- ///

	function ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ListarItemFiltrado($criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem -> ListarItemFiltrado($criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}

	/////LISTA ITEMS PARA REPORTE arv

	function ListarItemReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItemReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}

	/////////////////////////////////////////////////////////////
	function ListarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ContarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItemAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	////////////////////////////////////////////////////////////

	function ListarItemKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItemKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ListarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ListarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ContarItemKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItemKardex($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ContarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItemSal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux,$registro)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux,$registro);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function EliminarItem($id_item)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem -> EliminarItem($id_item);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ActivarInactivarItem($id_item)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ActivarInactivarItem($id_item);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$stock_min,$observaciones,$nivel_convertido,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre,$peso_kg,$mat_bajo_responsabilidad,$calidad,$descripcion_aux);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	/// --------------------- FIN ITEM --------------------- ///

	/// --------------------- TIPO CARACTERISTICA --------------------- ///

	function ListarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->ListarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	function ContarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->ContarTipoCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	function InsertarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->InsertarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	function EliminarTipoCaracteristica($id_tipo_caracteristica)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->EliminarTipoCaracteristica($id_tipo_caracteristica);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	function ModificarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->ModificarTipoCaracteristica($id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	function ValidarTipoCaracteristica($operacion_sql,$id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoCaracteristica = new cls_DBTipoCaracteristica($this->decodificar);
		$res = $dbTipoCaracteristica ->ValidarTipoCaracteristica($operacion_sql,$id_tipo_caracteristica,$codigo,$descripcion,$fecha_reg);
		$this->salida = $dbTipoCaracteristica->salida;
		$this->query = $dbTipoCaracteristica->query;
		return $res;
	}
	/// --------------------- FIN TIPO CARACTERISTICA --------------------- ///

	/// --------------------- TIPO CARACTERISTICA --------------------- ///

	function ListarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ListarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function InsertarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->InsertarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function EliminarCaracteristica($id_caracteristica)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->EliminarCaracteristica($id_caracteristica);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function ModificarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ModificarCaracteristica($id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function ValidarCaracteristica($operacion_sql,$id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ValidarCaracteristica($operacion_sql,$id_caracteristica,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	/// --------------------- FIN CARACTERISTICA --------------------- ///

	/// --------------------- ID2 --------------------- ///

	function ListarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ListarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function ContarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ContarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	///////////////////////////////////////////////////////////////////////
	function ListarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ListarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function ContarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ContarId2Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	//////////////////////////////////////////////////////////////////////

	function InsertarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->InsertarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function EliminarId2($id_id2)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 -> EliminarId2($id_id2);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function ModificarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ModificarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function CrearItemId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->CrearItemId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function ValidarId2($operacion_sql,$id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ValidarId2($operacion_sql,$id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	/// --------------------- FIN Identificadores Id2 --------------------- ///

	/// --------------------- ID3 --------------------- ///

	function ListarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ListarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function ContarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ContarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	///////////////////////////////////////////////////////////////////////
	function ListarId3Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ListarId3Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function ContarId3Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ContarId3Almacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	//////////////////////////////////////////////////////////////////////

	function InsertarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->InsertarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min,$registro);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function EliminarId3($id_id3)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 -> EliminarId3($id_id3);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function ModificarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ModificarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function CrearItemId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->CrearItemId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$id_unidad_medida_base,$costo_estimado,$precio_estimado,$stock_min);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function ValidarId3($operacion_sql,$id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ValidarId3($operacion_sql,$id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	/// --------------------- FIN Identificadores Id3 --------------------- ///

	/// --------------------- CORRELATIVOS --------------------- ///

	function ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel ->ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	function ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel ->ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	function InsertarCorrelativo($id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel ->InsertarCorrelativo($id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	function EliminarCorrelativo($id_correlativo)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel -> EliminarCorrelativo($id_correlativo);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	function ModificarCorrelativo($id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel ->ModificarCorrelativo($id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	function ValidarCorrelativo($operacion_sql,$id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen)
	{
		$this->salida = "";
		$dbCorrel = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrel ->ValidarCorrelativo($operacion_sql,$id_correlativo,$tabla,$prefijo,$sufijo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_almacen);
		$this->salida = $dbCorrel->salida;
		$this->query = $dbCorrel->query;
		return $res;
	}
	/// --------------------- FIN CORRELATIVOS --------------------- ///

	/// --------------------- SUPER GRUPO --------------------- ///
	function ListarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ListarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function ContarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ContarSuperGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function ListarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ListarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function ContarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ContarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function InsertarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia,$registro)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->InsertarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia,$registro);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function EliminarSuperGrupo($id_supergrupo)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo -> EliminarSuperGrupo($id_supergrupo);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function ModificarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ModificarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$demasia);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	function ValidarSuperGrupo($operacion_sql,$id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ValidarSuperGrupo($operacion_sql,$id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg);
		$this->salida = $dbSuperGrupo->salida;
		$this->query = $dbSuperGrupo->query;
		return $res;
	}
	/// --------------------- FIN SUPER GRUPO --------------------- ///

	/// --------------------- GRUPO --------------------- ///

	function ListarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->ListarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function ContarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->ContarGrupoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function ListarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->ListarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function ContarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->ContarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}

	function InsertarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo,$registro)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->InsertarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo,$registro);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function EliminarGrupo($id_grupo)
	{	$this->salida = "";
	$dbGrupo = new cls_DBGrupo($this->decodificar);
	$res = $dbGrupo -> EliminarGrupo($id_grupo);
	$this->salida = $dbGrupo->salida;
	$this->query = $dbGrupo->query;
	return $res;
	}
	function ModificarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
	{	$this->salida = "";
	$dbGrupo = new cls_DBGrupo($this->decodificar);
	$res = $dbGrupo ->ModificarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo);
	$this->salida = $dbGrupo->salida;
	$this->query = $dbGrupo->query;
	return $res;
	}
	function ValidarGrupo($operacion_sql,$id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->ValidarGrupo($operacion_sql,$id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	/// --------------------- FIN GRUPO --------------------- ///
	/// --------------------- tal_kardex_logico --------------------- ///

	function ListarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico ->ListarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function ContarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico ->ContarKardexLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function InsertarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico ->InsertarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function ModificarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico ->ModificarKardexLogico($id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function EliminarKardexLogico($id_kardex_logico)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico -> EliminarKardexLogico($id_kardex_logico);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function ValidarKardexLogico($operacion_sql,$id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKardexLogico ->ValidarKardexLogico($operacion_sql,$id_kardex_logico,$estado_item,$stock_minimo,$cantidad,$costo_unitario,$costo_total,$fecha_reg,$id_item,$id_almacen_logico,$reservado);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	/// --------------------- fin tal_kardex_logico --------------------- ///

	/// --------------------- tal_transferencia --------------------- ///

	function ListarTransfBorrador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransfBorrador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ListarTransfPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransfPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ListarTransfSeguimiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransfSeguimiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ListarTransfPrestamoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransfPrestamoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ListarTransfPrestamoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransfPrestamoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ContarTransfPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarTransfPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ContarTransfBorrador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarTransfBorrador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ContarTransfSeguimiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarTransfSeguimiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ContarTransfPrestamoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarTransfPrestamoPend($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ContarTransfPrestamoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarTransfPrestamoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function InsertarTransfBorrador($id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta,$tipo_transferencia,$importe_abierto)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->InsertarTransfBorrador($id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta,$tipo_transferencia,$importe_abierto);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ModificarTransfBorrador($id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta,$tipo_transferencia,$importe_abierto)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ModificarTransfBorrador($id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta,$tipo_transferencia,$importe_abierto);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function EliminarTransfBorrador($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> EliminarTransfBorrador($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function FinalizarTransfBorrador($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> FinalizarTransfBorrador($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function AprobarTransfPendiente($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> AprobarTransfPendiente($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function RechazarTransfPendiente($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> RechazarTransfPendiente($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function FinalizarTransfPrestamoDev($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> FinalizarTransfPrestamoDev($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	function ValidarTransferencia($operacion_sql,$id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ValidarTransferencia($operacion_sql,$id_transferencia,$prestamo,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_almacen_logico_destino,$id_motivo_ingreso_cuenta,$id_tipo_material,$id_motivo_salida_cuenta);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}
	
	function GenerarTransferenciaDevolucion($id_tipo_transferencia)
	{
		$this->salida = "";
		$db = new cls_DBTransferencia($this->decodificar);
		$res = $db -> GenerarTransferenciaDevolucion($id_tipo_transferencia);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	


	/// --------------------- fin tal_transferencia --------------------- ///

	/// --------------------- tal_transferencia_det --------------------- ///

	function ListarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet ->ListarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;

		return $res;
	}

	function ContarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet ->ContarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;
		return $res;
	}

	function InsertarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet ->InsertarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;
		return $res;
	}

	function ModificarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet ->ModificarTransferenciaDet($id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;
		return $res;
	}

	function EliminarTransferenciaDet($id_transferencia_det)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet -> EliminarTransferenciaDet($id_transferencia_det);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;
		return $res;
	}

	function ValidarTransferenciaDet($operacion_sql,$id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbTransferenciaDet = new cls_DBTransferenciaDet($this->decodificar);
		$res = $dbTransferenciaDet ->ValidarTransferenciaDet($operacion_sql,$id_transferencia_det,$cantidad,$estado_item,$costo,$costo_unitario,$precio_unitario,$fecha_reg,$id_item,$id_transferencia,$id_unidad_constructiva);
		$this->salida = $dbTransferenciaDet ->salida;
		$this->query = $dbTransferenciaDet ->query;
		return $res;
	}

	/// --------------------- fin tal_transferencia_det --------------------- ///

	///------------------------Actualizacion de Valor-------------------------///
	function ActualizacionValor($id_almacen,$id_almacen_logico,$fecha)
	{
		$this->salida = "";
		$dbActualizacionValor = new cls_DBActualizacionValor($this->decodificar);
		$res = $dbActualizacionValor ->ActualizacionValor($id_almacen,$id_almacen_logico,$fecha);
		$this->salida = $dbActualizacionValor->salida;
		$this->query = $dbActualizacionValor->query;

		return $res;
	}

	function AjusteInventario($id_ep,$id_almacen,$id_almacen_logico,$tipo_ajuste,$id_item,$cantidad,$estado_item)
	{
		$this->salida = "";
		$dbActualizacionValor = new cls_DBActualizacionValor($this->decodificar);
		$res = $dbActualizacionValor ->AjusteInventario($id_ep,$id_almacen,$id_almacen_logico,$tipo_ajuste,$id_item,$cantidad,$estado_item);
		$this->salida = $dbActualizacionValor->salida;
		$this->query = $dbActualizacionValor->query;

		return $res;
	}
	///------------------------fin Actualizacion de Valor-------------------------///

	//PROCESO DE BAJA DE MATERIAL

	function GuardarBajasPend($id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material)
	{
		$this->salida = "";
		$dbBajaPend = new cls_DBTransferencia($this->decodificar);
		$res = $dbBajaPend ->GuardarBajasPend($id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material);
		$this->salida = $dbBajaPend ->salida;
		$this->query = $dbBajaPend ->query;
		return $res;
	}
	function FinalizarBajasBorrador($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> FinalizarBajasBorrador($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}
	function ContarBajasPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ContarBajasPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}
	function ListarBajasPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarBajasPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}
	function AprobarBajasPendiente($id_transferencia)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia -> AprobarBajasPendiente($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}

	///// ---------------------------------- tal_orden_salida_uc_detalle --------------------------------------/////

	function ListarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ListarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;

		return $res;
	}

	function ContarOrdenSalidaUCDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ContarTransferenciaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function InsertarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->InsertarTransferenciaDet($id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ModificarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ModificarTransferenciaDet($id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function EliminarOrdenSalidaUCDetalle($id_orden_salida_uc_detalle)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet -> EliminarTransferenciaDet($id_orden_salida_uc_detalle);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	function ValidarOrdenSalidaUCDetalle($operacion_sql,$id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad)
	{
		$this->salida = "";
		$dbOrdSalUCDet = new cls_DBOrdenSalidaUCDetalle($this->decodificar);
		$res = $dbOrdSalUCDet ->ValidarTransferenciaDet($operacion_sql,$id_orden_salida_uc_detalle,$descripcion,$observaciones,$fecha_reg,$id_tipo_unidad_constructiva,$id_salida,$id_unidad_constructiva,$cantidad);
		$this->salida = $dbOrdSalUCDet ->salida;
		$this->query = $dbOrdSalUCDet ->query;
		return $res;
	}

	///// ---------------------------------- fin tal_orden_salida_uc_detalle --------------------------------------/////

	//// ------------------------------------ tal_item_archivo ----------------------------------------------/////
	function ListarItemArchivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemArchivo = new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo->ListarItemArchivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemArchivo->salida;
		$this->query = $dbItemArchivo->query;
		return $res;
	}

	function ContarItemArchivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemArchivo = new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo->ContarItemArchivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemArchivo->salida;
		$this->query = $dbItemArchivo->query;
		return $res;
	}

	function InsertarItemArchivo($id_item_archivo,$descripcion,$tipo,$archivo,$extension,$fecha_reg, $id_item)
	{
		$this->salida = "";
		$dbItemArchivo = new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo ->InsertarItemArchivo($id_item_archivo,$descripcion,$tipo,$archivo,$extension,$fecha_reg,$id_item);
		$this->salida = $dbItemArchivo ->salida;
		$this->query = $dbItemArchivo ->query;
		return $res;
	}

	function ModificarItemArchivo($id_item_archivo,$descripcion,$tipo,$archivo,$extension,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbItemArchivo = new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo->ModificarItemArchivo($id_item_archivo,$descripcion,$tipo,$archivo,$extension,$fecha_reg,$id_item);
		$this->salida = $dbItemArchivo ->salida;
		$this->query = $dbItemArchivo ->query;
		return $res;
	}

	function EliminarItemArchivo($id_item_archivo)
	{
		$this->salida = "";
		$dbItemArchivo= new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo-> EliminarItemArchivo($id_item_archivo);
		$this->salida = $dbItemArchivo->salida;
		$this->query = $dbItemArchivo->query;
		return $res;
	}

	function ValidarItemArchivo($operacion_sql,$id_item_archivo,$descripcion,$tipo,$archivo,$extension,$id_item)
	{
		$this->salida = "";
		$dbItemArchivo= new cls_DBItemArchivo($this->decodificar);
		$res = $dbItemArchivo->ValidarItemArchivo($operacion_sql,$id_item_archivo,$descripcion,$tipo,$archivo,$extension,$id_item);
		$this->salida = $dbItemArchivo->salida;
		$this->query = $dbItemArchivo->query;
		return $res;
	}
	//// ------------------------------------ fin tal_item_archivo ----------------------------------------------/////

	/// --------------------- tal_tramo --------------------- ///

	function ListarTramo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo ->ListarTramo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	function ContarTramo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo ->ContarTramo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	function InsertarTramo($id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo ->InsertarTramo($id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	function ModificarTramo($id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo ->ModificarTramo($id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	function EliminarTramo($id_tramo)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo -> EliminarTramo($id_tramo);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	function ValidarTramo($operacion_sql,$id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTramo = new cls_DBTramo($this->decodificar);
		$res = $dbTramo ->ValidarTramo($operacion_sql,$id_tramo,$codigo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTramo ->salida;
		$this->query = $dbTramo ->query;
		return $res;
	}

	/// --------------------- fin tal_tramo --------------------- ///

	/// --------------------- tal_tramo_subactividad --------------------- ///

	function ListarTramoSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad ->ListarTramoSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	function ContarTramoSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad ->ContarTramoSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	function InsertarTramoSubactividad($id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad ->InsertarTramoSubactividad($id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	function ModificarTramoSubactividad($id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad ->ModificarTramoSubactividad($id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	function EliminarTramoSubactividad($id_tramo_subactividad)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad -> EliminarTramoSubactividad($id_tramo_subactividad);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	function ValidarTramoSubactividad($operacion_sql,$id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo)
	{
		$this->salida = "";
		$dbTramoSubactividad = new cls_DBTramoSubactividad($this->decodificar);
		$res = $dbTramoSubactividad ->ValidarTramoSubactividad($operacion_sql,$id_tramo_subactividad,$fecha_reg,$id_subactividad,$id_tramo);
		$this->salida = $dbTramoSubactividad ->salida;
		$this->query = $dbTramoSubactividad ->query;
		return $res;
	}

	/// --------------------- fin tal_tramo_subactividad --------------------- ///

	/// --------------------- tal_tramo_unidad_constructiva --------------------- ///

	function ListarTramoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva ->ListarTramoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	function ContarTramoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva ->ContarTramoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	function InsertarTramoUnidadConstructiva($id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva ->InsertarTramoUnidadConstructiva($id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	function ModificarTramoUnidadConstructiva($id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva ->ModificarTramoUnidadConstructiva($id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	function EliminarTramoUnidadConstructiva($id_tramo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva -> EliminarTramoUnidadConstructiva($id_tramo_unidad_constructiva);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	function ValidarTramoUnidadConstructiva($operacion_sql,$id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo)
	{
		$this->salida = "";
		$dbTramoUnidadConstructiva = new cls_DBTramoUnidadConstructiva($this->decodificar);
		$res = $dbTramoUnidadConstructiva ->ValidarTramoUnidadConstructiva($operacion_sql,$id_tramo_unidad_constructiva,$fecha_reg,$id_unidad_constructiva,$id_tramo);
		$this->salida = $dbTramoUnidadConstructiva ->salida;
		$this->query = $dbTramoUnidadConstructiva ->query;
		return $res;
	}

	/// --------------------- fin tal_tramo_unidad_constructiva --------------------- ///

	/// --------------------- tal_unidad_constructiva --------------------- ///

	function ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva ->ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	function ContarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva ->ContarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	function InsertarUnidadConstructiva($id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva ->InsertarUnidadConstructiva($id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	function ModificarUnidadConstructiva($id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva ->ModificarUnidadConstructiva($id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	function EliminarUnidadConstructiva($id_unidad_constructiva)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva -> EliminarUnidadConstructiva($id_unidad_constructiva);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	function ValidarUnidadConstructiva($operacion_sql,$id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad)
	{
		$this->salida = "";
		$dbUnidadConstructiva = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadConstructiva ->ValidarUnidadConstructiva($operacion_sql,$id_unidad_constructiva,$codigo,$fecha_reg,$id_tipo_unidad_constructiva,$id_subactividad);
		$this->salida = $dbUnidadConstructiva ->salida;
		$this->query = $dbUnidadConstructiva ->query;
		return $res;
	}

	/// --------------------- fin tal_unidad_constructiva --------------------- ///


	/// --------------------- tal_supervisor --------------------- ///

	function ListarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante ->ListarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ContarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante ->ContarSupervisor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function InsertarSupervisor($id_supervisor,$id_persona,$fecha_reg)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante ->InsertarSupervisor($id_supervisor,$id_persona,$fecha_reg);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ModificarSupervisor($id_supervisor,$id_persona,$fecha_reg)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante ->ModificarSupervisor($id_supervisor,$id_persona,$fecha_reg);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function EliminarSupervisor($id_supervisor)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante -> EliminarSupervisor($id_supervisor);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}

	function ValidarSupervisor($operacion_sql,$id_supervisor,$id_persona,$fecha_reg)
	{
		$this->salida = "";
		$dbEstante = new cls_DBSupervisor($this->decodificar);
		$res = $dbEstante ->ValidarSupervisor($operacion_sql,$id_supervisor,$id_persona,$fecha_reg);
		$this->salida = $dbEstante ->salida;
		$this->query = $dbEstante ->query;
		return $res;
	}



	/// --------------------- fin tal_supervisor --------------------- ///
	//RCM: 18/08/2008
	function ListarKardexItemIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarKardexItemIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 18/08/2008
	function ListarKardexItemSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarKardexItemSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 23/10/2008
	function ListarKardexItemSaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarKardexItemSaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 25/08/2008
	function ListarParteDiarioIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarParteDiarioIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 27/08/2008
	function ListarParteDiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarParteDiarioSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 14/10/2008
	function ListarExistencias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$condiciones)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarExistencias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$condiciones);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	//RCM: 24/12/2008
	function ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$fecha_desde,$fecha_hasta,$id_almacen,$id_almacen_logico)
	{
		$this->salida = "";
		$dbKarLog = new cls_DBKardexLogico($this->decodificar);
		$res = $dbKarLog ->ListarParteDiario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$fecha_desde,$fecha_hasta,$id_almacen,$id_almacen_logico);
		$this->salida = $dbKarLog->salida;
		$this->query = $dbKarLog->query;
		return $res;
	}

	/// --------------------- tal_item_cuenta_partida --------------------- ///
	function ListarItemCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->ListarItemCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}

	function ContarItemCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->ContarItemCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}

	function InsertarItemCuentaPartida($id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->InsertarItemCuentaPartida($id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}

	function ModificarItemCuentaPartida($id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->ModificarItemCuentaPartida($id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}

	function EliminarItemCuentaPartida($id_item_cuenta_partida)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida -> EliminarItemCuentaPartida($id_item_cuenta_partida);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}

	function ValidarItemCuentaPartida($operacion_sql,$id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->ValidarItemCuentaPartida($operacion_sql,$id_item_cuenta_partida,$nivel,$id_material,$id_cuenta,$id_partida,$id_gestion,$id_cuenta_gasto,$id_presupuesto,$id_auxiliar_activo,$id_auxiliar_gasto);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}
	function ListarNivel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemCuentaPartida = new cls_DBItemCuentaPartida($this->decodificar);
		$res = $dbItemCuentaPartida ->ListarNivel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemCuentaPartida ->salida;
		$this->query = $dbItemCuentaPartida ->query;
		return $res;
	}
	/// --------------------- fin tal_item_cuenta_partida --------------------- ///


	//AVQ: 12/01/2009
	function ReporteMaterialEntregadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbMaterialEntregado = new cls_DBMaterialEntregado($this->decodificar);
		$res = $dbMaterialEntregado ->ReporteMaterialEntregadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbMaterialEntregado ->salida;
		$this->query = $dbMaterialEntregado ->query;
		return $res;
	}
	function ReporteEntregadoUnidadConsDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMaterialEntregado = new cls_DBMaterialEntregado($this->decodificar);
		$res = $dbMaterialEntregado ->ReporteEntregadoUnidadConsDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMaterialEntregado ->salida;
		$this->query = $dbMaterialEntregado ->query;
		return $res;
	}
	function  ReporteMaterialEntregadoTramoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMaterialEntregado = new cls_DBMaterialEntregado($this->decodificar);
		$res = $dbMaterialEntregado -> ReporteMaterialEntregadoTramoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMaterialEntregado ->salida;
		$this->query = $dbMaterialEntregado ->query;
		return $res;
	}

	function  ReporteKardexItemDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$id_fina_regi_prog_proy_acti,$id_almacen_logico,$id_almacen,$id_item,$fecha_desde,$fecha_hasta)
	{
		$this->salida = "";
		$dbMaterialEntregado = new cls_DBKardexItem($this->decodificar);
		$res = $dbMaterialEntregado -> ReporteKardexItemDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$id_fina_regi_prog_proy_acti,$id_almacen_logico,$id_almacen,$id_item,$fecha_desde,$fecha_hasta);
		$this->salida = $dbMaterialEntregado ->salida;
		$this->query = $dbMaterialEntregado ->query;
		return $res;
	}
	
	//RCM: 31/03/2009
	function  ReporteValoracionSaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$id_ep,$id_almacen,$id_almacen_logico,$fecha)
	{
		$this->salida = "";
		$db = new cls_DBValoracion($this->decodificar);
		$res = $db -> ReporteValoracionSaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro_almacen,$id_ep,$id_almacen,$id_almacen_logico,$fecha);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	
	/// --------------------- tal_parametro_almacen_logico --------------------- ///

	function ListarParametroAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBParametroAlmacenLogico($this->decodificar);
		$res = $dbKardexLogico ->ListarParametroAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}

	function ContarParametroAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbKardexLogico = new cls_DBParametroAlmacenLogico($this->decodificar);
		$res = $dbKardexLogico ->ContarParametroAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbKardexLogico ->salida;
		$this->query = $dbKardexLogico ->query;
		return $res;
	}
	
	function CerrarGestionLogica($id_parametro_almacen_logico)
	{
		$this->salida = "";
		$db = new cls_DBParametroAlmacenLogico($this->decodificar);
		$res = $db -> CerrarGestionLogica($id_parametro_almacen_logico);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function RevalorarGestionLogica($id_parametro_almacen_logico)
	{
		$this->salida = "";
		$db = new cls_DBParametroAlmacenLogico($this->decodificar);
		$res = $db -> RevalorarGestionLogica($id_parametro_almacen_logico);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	/// --------------------- FIN tal_parametro_almacen_logico --------------------- ///
	
	/// --------------------- tal_pedido_tuc_int --------------------- ///
	
	function ListarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBPedidoTucInt($this->decodificar);
		$res = $db ->ListarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db->salida;
		$this->query = $db->query;
		return $res;
	}
	
	function ContarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBPedidoTucInt($this->decodificar);
		$res = $db ->ContarPedidoTucInt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db->salida;
		$this->query = $db->query;
		return $res;
	}
	function ActionAutorizaPedido($id_pedido_tuc_int)
	{
		
	    $this->salida = "";
		$db = new cls_DBPedidoTucInt($this->decodificar);
		$res = $db ->ActionAutorizaPedido($id_pedido_tuc_int);
		$this->salida = $db->salida;
		$this->query = $db->query;
		return $res;
	}
	
	function GenerarSalidaPendiente($id_salida)
	{
		
	    $this->salida = "";
		$db = new cls_DBPedidoTucInt($this->decodificar);
		$res = $db ->GenerarSalidaPendiente($id_salida);
		$this->salida = $db->salida;
		$this->query = $db->query;
		return $res;
	}
	
	
	/// --------------------- FIN tal_pedido_tuc_int --------------------- ///
	
	
}?>