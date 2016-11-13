<?php
/**
 * Nombre de la Clase:	    CustomDBAlmacenes
 * Propósito:				Interfaz del modelo del Sistema de Almacenes
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		27-09-2007
 * Autor:					Rensi Arteaga Copari
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
		//include_once("cls_DBFirmaAutorizadaAlmEp.php");
		include_once("DBSalida/cls_DBSalidaPedido.php");
		include_once("DBSalida/cls_DBSalidaPedidoDetalle.php");
		include_once("DBSalida/cls_DBSalidaDetalle.php");


		////----------------------------------------////
		include_once("DBSalida/cls_DBSalida.php");
	}

	/// --------------------- PARAMETROS ALMACEN --------------------- ///

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

	function InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->InsertarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
		$this->salida = $dbCodigoFabricante ->salida;
		$this->query = $dbCodigoFabricante ->query;
		return $res;
	}

	function ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ModificarCodigoFabricante($id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
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

	function ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item)
	{
		$this->salida = "";
		$dbCodigoFabricante = new cls_DBCodigoFabricante($this->decodificar);
		$res = $dbCodigoFabricante ->ValidarCodigoFabricante($operacion_sql,$id_codigo_fabricante,$codigo,$estado_registro,$nombre,$año,$descripcion,$observaciones,$fecha_reg,$id_item);
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
	function InsertarCaracteristicaItem($id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->InsertarCaracteristicaItem($id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
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
	function ModificarCaracteristicaItem($id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ModificarCaracteristicaItem($id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
		$this->salida = $dbCaracItem->salida;
		$this->query = $dbCaracItem->query;
		return $res;
	}
	function ValidarCaracteristicaItem($operacion_sql,$id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbCaracItem = new cls_DBCaracteristicaItem($this->decodificar);
		$res = $dbCaracItem ->ValidarCaracteristicaItem($operacion_sql,$id_caracteristica_item,$codigo,$valor,$observaciones,$fecha_reg,$id_item,$id_caracteristica,$id_unidad_medida_base);
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

	function InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->InsertarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
		$this->salida = $dbAlmacenSector ->salida;
		$this->query = $dbAlmacenSector ->query;
		return $res;
	}

	function ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ModificarAlmacenSector($id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
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

	function ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen)
	{
		$this->salida = "";
		$dbAlmacenSector = new cls_DBAlmacenSector($this->decodificar);
		$res = $dbAlmacenSector ->ValidarAlmacenSector($operacion_sql,$id_almacen_sector,$superficie,$altura,$via_fil,$via_col,$techado,$aire_acond,$fecha_reg,$id_tipo_sector,$id_almacen);
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

	function ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ContarAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->InsertarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
		$this->salida = $dbAlmacen ->salida;
		$this->query = $dbAlmacen ->query;
		return $res;
	}

	function ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ModificarAlmacen($id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
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

	function ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional)
	{
		$this->salida = "";
		$dbAlmacen = new cls_DBAlmacen($this->decodificar);
		$res = $dbAlmacen ->ValidarAlmacen($operacion_sql,$id_almacen,$codigo,$nombre,$descripcion,$direccion,$via_fil_max,$via_col_max,$bloquear,$cerrado,$nro_prest_pendientes,$nro_ing_no_finalizados,$nro_sal_no_finalizadas,$observaciones,$fecha_ultimo_inventario,$fecha_reg,$id_regional);
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

	function InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->InsertarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenEp ->salida;
		$this->query = $dbAlmacenEp ->query;
		return $res;
	}

	function ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ModificarAlmacenEp($id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenEp = new cls_DBAlmacenEp($this->decodificar);
		$res = $dbAlmacenEp ->ValidarAlmacenEp($operacion_sql,$id_almacen_ep,$descripcion,$observaciones,$fecha_reg,$id_almacen,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ContarAlmacenLogico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->InsertarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
		$this->salida = $dbAlmacenLogico ->salida;
		$this->query = $dbAlmacenLogico ->query;
		return $res;
	}

	function ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ModificarAlmacenLogico($id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
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

	function ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen)
	{
		$this->salida = "";
		$dbAlmacenLogico = new cls_DBAlmacenLogico($this->decodificar);
		$res = $dbAlmacenLogico ->ValidarAlmacenLogico($operacion_sql,$id_almacen_logico,$codigo,$bloqueado,$nombre,$descripcion,$estado_registro,$fecha_reg,$obsevaciones,$id_almacen_ep,$id_tipo_almacen);
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

	function InsertarTipoAlmacen($id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->InsertarTipoAlmacen($id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen);
		$this->salida = $dbTipoAlmacen ->salida;
		$this->query = $dbTipoAlmacen ->query;
		return $res;
	}

	function ModificarTipoAlmacen($id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ModificarTipoAlmacen($id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen);
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

	function ValidarTipoAlmacen($operacion_sql,$id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen)
	{
		$this->salida = "";
		$dbTipoAlmacen = new cls_DBTipoAlmacen($this->decodificar);
		$res = $dbTipoAlmacen ->ValidarTipoAlmacen($operacion_sql,$id_tipo_almacen,$descripcion,$observaciones,$tipo_almacen);
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

	function InsertarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->InsertarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso);
		$this->salida = $dbFirmaAutorizada ->salida;
		$this->query = $dbFirmaAutorizada ->query;
		return $res;
	}

	function ModificarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ModificarFirmaAutorizada($id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso);
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

	function ValidarFirmaAutorizada($operacion_sql,$id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso)
	{
		$this->salida = "";
		$dbFirmaAutorizada = new cls_DBFirmaAutorizada($this->decodificar);
		$res = $dbFirmaAutorizada ->ValidarFirmaAutorizada($operacion_sql,$id_firma_autorizada,$descripcion,$prioridad,$estado_reg,$observaciones,$fecha_reg,$id_empleado_frppa,$id_motivo_salida,$id_motivo_ingreso);
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

	function ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ContarMotivoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->InsertarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo);
		$this->salida = $dbMotivoIngreso ->salida;
		$this->query = $dbMotivoIngreso ->query;
		return $res;
	}

	function ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ModificarMotivoIngreso($id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo);
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

	function ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo)
	{
		$this->salida = "";
		$dbMotivoIngreso = new cls_DBMotivoIngreso($this->decodificar);
		$res = $dbMotivoIngreso ->ValidarMotivoIngreso($operacion_sql,$id_motivo_ingreso,$nombre,$descripcion,$estado_registro,$fecha_reg,$tipo);
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

	function InsertarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->InsertarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoIngresoCuenta ->salida;
		$this->query = $dbMotivoIngresoCuenta ->query;
		return $res;
	}

	function ModificarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ModificarMotivoIngresoCuenta($id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function ValidarMotivoIngresoCuenta($operacion_sql,$id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoIngresoCuenta = new cls_DBMotivoIngresoCuenta($this->decodificar);
		$res = $dbMotivoIngresoCuenta ->ValidarMotivoIngresoCuenta($operacion_sql,$id_motivo_ingreso_cuenta,$id_motivo_ingreso,$descripcion,$observaciones,$fecha_reg,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function ContarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ContarMotivoSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function InsertarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->InsertarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg);
		$this->salida = $dbMotivoSalida ->salida;
		$this->query = $dbMotivoSalida ->query;
		return $res;
	}

	function ModificarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ModificarMotivoSalida($id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg);
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

	function ValidarMotivoSalida($operacion_sql,$id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg)
	{
		$this->salida = "";
		$dbMotivoSalida = new cls_DBMotivoSalida($this->decodificar);
		$res = $dbMotivoSalida ->ValidarMotivoSalida($operacion_sql,$id_motivo_salida,$nombre,$descripcion,$estado_registro,$fecha_reg);
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

	function InsertarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->InsertarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMotivoSalidaCuenta ->salida;
		$this->query = $dbMotivoSalidaCuenta ->query;
		return $res;
	}

	function ModificarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ModificarMotivoSalidaCuenta($id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function ValidarMotivoSalidaCuenta($operacion_sql,$id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMotivoSalidaCuenta = new cls_DBMotivoSalidaCuenta($this->decodificar);
		$res = $dbMotivoSalidaCuenta ->ValidarMotivoSalidaCuenta($operacion_sql,$id_motivo_salida_cuenta,$descripcion,$id_motivo_salida,$id_cuenta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function InsertarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->InsertarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
		$this->salida = $dbParametroAlmacen ->salida;
		$this->query = $dbParametroAlmacen ->query;
		return $res;
	}

	function ModificarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta)
	{
		$this->salida = "";
		$dbParametroAlmacen = new cls_DBParametroAlmacen($this->decodificar);
		$res = $dbParametroAlmacen ->ModificarParametroAlmacen($id_parametro_almacen,$dias_reserva,$cierre,$gestion,$bloqueado,$actualizar,$observaciones,$id_cuenta);
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


	/// --------------------- tal_firma_autorizada_alm_ep --------------------- ///

	function ListarFirmaAutorizadaAlmEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp ->ListarFirmaAutorizadaAlmEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	function ContarFirmaAutorizadaAlmEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp ->ContarFirmaAutorizadaAlmEp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	function InsertarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp ->InsertarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	function ModificarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp ->ModificarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	function EliminarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp -> EliminarFirmaAutorizadaAlmEp($id_firma_autorizada_alm_ep);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	function ValidarFirmaAutorizadaAlmEp($operacion_sql,$id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep)
	{
		$this->salida = "";
		$dbFirmaAutorizadaAlmEp = new cls_DBFirmaAutorizadaAlmEp($this->decodificar);
		$res = $dbFirmaAutorizadaAlmEp ->ValidarFirmaAutorizadaAlmEp($operacion_sql,$id_firma_autorizada_alm_ep,$fecha_reg,$id_firma_autorizada,$id_almacen_ep);
		$this->salida = $dbFirmaAutorizadaAlmEp ->salida;
		$this->query = $dbFirmaAutorizadaAlmEp ->query;
		return $res;
	}

	/// --------------------- fin tal_firma_autorizada_alm_ep --------------------- ///

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
	function InsertarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbSubGrupo = new cls_DBSubGrupo($this->decodificar);
		$res = $dbSubGrupo ->InsertarSubGrupo($id_subgrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_material,$id_grupo,$id_supergrupo);
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
	function InsertarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->InsertarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function ModificarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->ModificarId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId1->salida;
		$this->query = $dbId1->query;
		return $res;
	}
	function CrearItemId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId1 = new cls_DBId1($this->decodificar);
		$res = $dbId1 ->CrearItemId1($id_id1,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ContarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->InsertarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
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
	function ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ModificarItem($id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
		$this->salida = $dbItem->salida;
		$this->query = $dbItem->query;
		return $res;
	}
	function ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre)
	{
		$this->salida = "";
		$dbItem = new cls_DBItem($this->decodificar);
		$res = $dbItem ->ValidarItem($operacion_sql,$id_item,$codigo,$descripcion,$precio_venta_almacen,$costo_estimado,$costo_almacen,$stock_min,$stock_total,$observaciones,$nivel_convertido,$estado_item,$estado_registro,$fecha_reg,$id_unidad_medida_base,$id_id3,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo,$nombre);
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
	function InsertarCaracteristica($id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->InsertarCaracteristica($id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
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
	function ModificarCaracteristica($id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ModificarCaracteristica($id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
		$this->salida = $dbCaracteristica->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function ValidarCaracteristica($operacion_sql,$id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ValidarCaracteristica($operacion_sql,$id_caracteristica,$codigo,$nombre,$tipo_dato,$descripcion,$id_tipo_unidad_medida,$id_tipo_caracteristica,$fecha_reg);
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
	function InsertarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->InsertarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function ModificarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->ModificarId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId2->salida;
		$this->query = $dbId2->query;
		return $res;
	}
	function CrearItemId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId2 = new cls_DBId2($this->decodificar);
		$res = $dbId2 ->CrearItemId2($id_id2,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function InsertarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->InsertarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function ModificarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->ModificarId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
		$this->salida = $dbId3->salida;
		$this->query = $dbId3->query;
		return $res;
	}
	function CrearItemId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo)
	{
		$this->salida = "";
		$dbId3 = new cls_DBId3($this->decodificar);
		$res = $dbId3 ->CrearItemId3($id_id3,$codigo,$nombre,$descripcion,$nivel_convertido,$convertido,$observaciones,$estado_registro,$fecha_reg,$id_id2,$id_id1,$id_subgrupo,$id_grupo,$id_supergrupo);
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
	function InsertarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$registro)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->InsertarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$registro);
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
	function ModificarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$registro)
	{
		$this->salida = "";
		$dbSuperGrupo = new cls_DBSuperGrupo($this->decodificar);
		$res = $dbSuperGrupo ->ModificarSuperGrupo($id_supergrupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$registro);
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
	function InsertarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo ->InsertarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function EliminarGrupo($id_grupo)
	{
		$this->salida = "";
		$dbGrupo = new cls_DBGrupo($this->decodificar);
		$res = $dbGrupo -> EliminarGrupo($id_grupo);
		$this->salida = $dbGrupo->salida;
		$this->query = $dbGrupo->query;
		return $res;
	}
	function ModificarGrupo($id_grupo,$codigo,$nombre,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_supergrupo)
	{
		$this->salida = "";
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

	/*********************************************************
	*
	*
	*
	*  				FUNCIONES AUMENTADAS
	*
	*
	*
	**********************************************************/


	/// --------------------- tal_salida --------------------- ///

	function ListarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ListarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	function ContarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ContarSalida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	function InsertarSalida($id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->InsertarSalida($id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	function ModificarSalida($id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ModificarSalida($id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	function EliminarSalida($id_salida)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida -> EliminarSalida($id_salida);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	function ValidarSalida($operacion_sql,$id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->ValidarSalida($operacion_sql,$id_salida,$codigo,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}

	/// --------------------- fin tal_salida --------------------- ///
	/// --------------------- tal_salida_detalle --------------------- ///

	function ListarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ListarSalidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function InsertarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->InsertarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}

	function ModificarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ModificarSalidaDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}

	function EliminarSalidaDetalle($id_salida_detalle)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle -> EliminarSalidaDetalle($id_salida_detalle);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}

	function ValidarSalidaDetalle($operacion_sql,$id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva)
	{
		$this->salida = "";
		$dbSalidaDetalle = new cls_DBSalidaDetalle($this->decodificar);
		$res = $dbSalidaDetalle ->ValidarSalidaDetalle($operacion_sql,$id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva);
		$this->salida = $dbSalidaDetalle ->salida;
		$this->query = $dbSalidaDetalle ->query;
		return $res;
	}

	/// --------------------- fin tal_salida_detalle --------------------- ///


	/********** AUMENTADAS RODRIGO ******************************/
	/// --------------------- salida pedido --------------------- ///

	function ListarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ListarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function ContarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ContarSalidaPedido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function InsertarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$tipo_pedido,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->InsertarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$tipo_pedido,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function ModificarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ModificarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia,$receptor,$id_tramo_subactividad,$id_tramo_unidad_constructiva,$observaciones,$fecha_borrador,$id_supervisor,$receptor_ci,$solicitante,$solicitante_ci,$num_contrato);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function EliminarSalidaPedido($id_salida)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed -> EliminarSalidaPedido($id_salida);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function FinalizarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->FinalizarSalidaPedido($id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$emergencia);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}
	
	function FinalizarSalidaUCProy($id_salida)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalida($this->decodificar);
		$res = $dbSalidaPed ->FinalizarSalidaUCProy($id_salida);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	function ValidarSalidaPedido($operacion_sql,$id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$tipo_pedido)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ValidarSalidaPedido($operacion_sql,$id_salida,$correlativo_sal,$correlativo_vale,$descripcion,$contabilizar,$contabilizado,$estado_salida,$estado_registro,$motivo_cancelacion,$id_responsable_almacen,$id_almacen_logico,$id_empleado,$id_firma_autorizada,$id_contratista,$id_tipo_material,$id_institucion,$id_subactividad,$id_motivo_salida_cuenta,$tipo_pedido);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	/// --------------------- fin salida pedido --------------------- ///

	/// --------------------- salida pedido detalle --------------------- ///

	function ListarSalidaPedidoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet ->ListarSalidaPedidoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	function ContarSalidaPedidoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet ->ContarSalidaPedidoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	function InsertarSalidaPedidoDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet ->InsertarSalidaPedidoDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	function ModificarSalidaPedidoDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet ->ModificarSalidaPedidoDetalle($id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	function EliminarSalidaPedidoDetalle($id_salida_detalle)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet -> EliminarSalidaPedidoDetalle($id_salida_detalle);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	function ValidarSalidaPedidoDetalle($operacion_sql,$id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedidoDetalle($this->decodificar);
		$res = $dbSalidaPedDet ->ValidarSalidaPedidoDetalle($operacion_sql,$id_salida_detalle,$costo,$costo_unitario,$precio_unitario,$cant_solicitada,$cant_entregada,$cant_consolidada,$descripcion,$observaciones,$fecha_solicitada,$fecha_entregada,$fecha_consolidada,$fecha_reg,$id_item,$id_salida,$id_unidad_constructiva,$estado_item);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}

	/// --------------------- fin salida pedido detalle --------------------- ///
	
	//Salidas Rápidas para Proyectos 02-04-2008 RCM
	function ListarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPedDet ->ListarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}
	
	function ContarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPedDet = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPedDet ->ContarSalidaProy($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPedDet ->salida;
		$this->query = $dbSalidaPedDet ->query;
		return $res;
	}
	//Fin Salidas Rápidas
	
	function PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->PedidoMaterialesUC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	function PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->PedidoMaterialesUCDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		/*echo "QUERY: ".$this->query;
		exit;*/
		
		return $res;
	}
	//ARV 13/02/2009
	function PedidoMaterialesSimplificado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->PedidoMaterialesSimplificado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	//ARV 16/02/2009
	function PedidoMaterialesSimplificadoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBSalida($this->decodificar);
		$res = $dbSalida ->PedidoMaterialesSimplificadoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	
	//RCM: 18/09/2008
	function ListarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ListarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}

	//RCM: 18/09/2008
	function ContarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalidaPed = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSalidaPed ->ContarSalidaPedidoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalidaPed ->salida;
		$this->query = $dbSalidaPed ->query;
		return $res;
	}
	
	//RCM: 19-12-2011
	function ModificarSalidasFinalizadas($id_salida,$descripcion,$observaciones,$num_contrato)
	{
		$this->salida = "";
		$dbSal = new cls_DBSalidaPedido($this->decodificar);
		$res = $dbSal ->ModificarSalidasFinalizadas($id_salida,$descripcion,$observaciones,$num_contrato);
		$this->salida = $dbSal ->salida;
		$this->query = $dbSal ->query;
		return $res;
	}

}
?>