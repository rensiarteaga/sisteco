<?php
/**
 * Nombre de la Clase:	    CustomDBContabilidad
 * Propósito:				Interfaz del modelo del Sistema de Contabilidad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		02-10-2007
 * Autor:					Josè A. Mita Huanca
 *
 */
class cls_CustomDBcobranza
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{	
		include_once("cls_DBSistemaDistribucion.php");
		include_once("cls_DBConceptoFactura.php");
		include_once("cls_DBSistemaDBL.php");
		include_once("cls_DBColumnaValor.php");
		include_once("cls_DBTipoFacturacionCobranza.php");
		include_once("cls_DBDatosEstructura.php");
		include_once("cls_DBEstadoProceso.php");
		include_once("cls_DBProcesoFacturacionCobranza.php");
	}
	//////////////////////////inicio sistema distribucion
	function InsertarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion)
	{
			$this->salida = "";
			$dbSistema = new cls_DBSistemaDistribucion($this->decodificar);
			$res = $dbSistema ->InsertarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function ModificarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBSistemaDistribucion($this->decodificar);
			$res = $dbSistema ->ModificarSistemadistribucion($id_sistema,$id_sistema_distribucion,$fecha_separacion ,$id_depto,$conexion,$nombre_sistema_distribucion,$id_gestion);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarSistemadistribucion($id_sistema)
	{
			$this->salida = "";
			$dbSistema = new cls_DBSistemaDistribucion($this->decodificar);
			$res = $dbSistema ->EliminarSistemadistribucion($id_sistema);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
  
	function ListarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDistribucion($this->decodificar);
		$res = $dbPlantilla ->ListarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDistribucion($this->decodificar);
		$res = $dbPlantilla ->ContarSistemaDistribucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////fin  sistema distribucion
	//////////////////////////inicio sistemaDBL
		function ListarSistemaDBL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ListarSistemaDBL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarSistemaDBL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ContarSistemaDBL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////fin sistemaDBL
	//////////////////////////inicio Lugar
	function ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////fin Lugar
	//////////////////////////inicio Categoria
	function ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBSistemaDBL($this->decodificar);
		$res = $dbPlantilla ->ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////fin Categoria
	//////////////////////////cls_DBConceptoFactura.php
	function InsertarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione)
	{
			$this->salida = "";
			$dbSistema = new cls_DBConceptoFactura($this->decodificar);
			$res = $dbSistema ->InsertarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function ModificarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBConceptoFactura($this->decodificar);
			$res = $dbSistema ->ModificarConceptoFactura($id_concepto_factura,$nombre_concepto,$tipo_concepto,$id_lugar,$nombre_lugar,$id_categoria_cliente,$nombre_categoria_cliente,$id_sistema_distribucione);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarConceptoFactura($id_concepto_factura)
	{
			$this->salida = "";
			$dbSistema = new cls_DBConceptoFactura($this->decodificar);
			$res = $dbSistema ->EliminarConceptoFactura($id_concepto_factura);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
	function ListarConceptoFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBConceptoFactura($this->decodificar);
		$res = $dbPlantilla ->ListarConceptoFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarConceptoFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBConceptoFactura($this->decodificar);
		$res = $dbPlantilla ->ContarConceptoFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////cls_DBConceptoFactura.php
	//////////////////////////INICIOcls_DBColumnaValor.php
	function InsertarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber)
	{
			$this->salida = "";
			$dbSistema = new cls_DBColumnaValor($this->decodificar);
			$res = $dbSistema ->InsertarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function ModificarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBColumnaValor($this->decodificar);
			$res = $dbSistema ->ModificarColumnaValor($id_columna_valor, $id_concepto_factura, $id_tipo_facturacion_cobranza, $id_cuenta, $id_partida, $id_auxiliar, $id_presupuesto, $sw_presto, $sw_fecha_separativa, $sw_estado, $id_usuario, $fecha_reg, $nombre_columna, $calculo_conta, $calculo_presto, $sw_debe_haber);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarColumnaValor($id_columna_valor)
	{
			$this->salida = "";
			$dbSistema = new cls_DBColumnaValor($this->decodificar);
			$res = $dbSistema ->EliminarColumnaValor($id_columna_valor);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
	function ListarColumnaValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBColumnaValor($this->decodificar);
		$res = $dbPlantilla ->ListarColumnaValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarColumnaValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBColumnaValor($this->decodificar);
		$res = $dbPlantilla ->ContarColumnaValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////FIN cls_DBColumnaValor.php
	//////////////////////////INICIO cls_DBTipoFacturacionCobranza
	function InsertarTipoFacturacionCobranza($id_tipo_facturacion_cobranza,$nombre_proceso,$sw_banco,$sw_periodo)
	{
			$this->salida = "";
			$dbSistema = new cls_DBTipoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->InsertarTipoFacturacionCobranza($id_tipo_facturacion_cobranza,$nombre_proceso,$sw_banco,$sw_periodo);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function ModificarTipoFacturacionCobranza($id_tipo_facturacion_cobranza,$nombre_proceso,$sw_banco,$sw_periodo)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBTipoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->ModificarTipoFacturacionCobranza($id_tipo_facturacion_cobranza,$nombre_proceso,$sw_banco,$sw_periodo);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarTipoFacturacionCobranza($id_tipo_facturacion_cobranza)
	{
			$this->salida = "";
			$dbSistema = new cls_DBTipoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->EliminarTipoFacturacionCobranza($id_tipo_facturacion_cobranza);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
	function ListarTipoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBTipoFacturacionCobranza($this->decodificar);
		$res = $dbPlantilla ->ListarTipoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarTipoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBTipoFacturacionCobranza($this->decodificar);
		$res = $dbPlantilla ->ContarTipoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////FIN cls_DBTipoFacturacionCobranza
    //////////////////////////INICIO cls_DBDatosEstructura
	function ListarDatosEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBDatosEstructura($this->decodificar);
		$res = $dbPlantilla ->ListarDatosEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarDatosEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBDatosEstructura($this->decodificar);
		$res = $dbPlantilla ->ContarDatosEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////FIN cls_DBDatosEstructura 
	//////////////////////////INICIO cls_EstadoProceso
	function CambioEstadoProceso($m_id_proceso_facturacion_cobranza, $accion,  $m_id_estado_proceso)
	{
			$this->salida = "";
			$dbSistema = new cls_DBEstadoProceso($this->decodificar);
			$res = $dbSistema ->CambioEstadoProceso($m_id_proceso_facturacion_cobranza, $accion,  $m_id_estado_proceso);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			
			return $res;
	}
	function InsertarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado)
	{
			$this->salida = "";
			$dbSistema = new cls_DBEstadoProceso($this->decodificar);
			$res = $dbSistema ->InsertarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			
			return $res;
	}
	function ModificarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBEstadoProceso($this->decodificar);
			$res = $dbSistema ->ModificarEstadoProceso($id_estado_proceso, $id_tipo_facturacion_cobranza,  $accion_anterior,  $accion_siguiente,  $prioridad,  $sw_dblink_anterior,  $sw_dblink_siguiente,$nombre_estado);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarEstadoProceso($id_estado_proceso)
	{
			$this->salida = "";
			$dbSistema = new cls_DBEstadoProceso($this->decodificar);
			$res = $dbSistema ->EliminarEstadoProceso($id_estado_proceso);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
	
	
	function ListarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbPlantilla ->ListarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbPlantilla ->ContarEstadoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////FIN cls_ContarEstadoProceso
	//////////////////////////INICIO cls_ProcesoFacturacionCobranza
	function InsertarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza)
	{
			$this->salida = "";
			$dbSistema = new cls_DBProcesoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->InsertarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			
			return $res;
	}
	function ModificarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza)
	{ 
			$this->salida = "";
			$dbSistema = new cls_DBProcesoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->ModificarProcesoFacturacionCobranza($id_sistema_distribucion, $id_periodo, $fecha_inicio, $fecha_final, $id_gestion, $gestion, $periodo, $desc_proceso, $id_proceso_facturacion_cobranza, $id_tipo_facturacion_cobranza);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema->query;
			return $res;
	}
	function EliminarProcesoFacturacionCobranza($id_sistema_distribucion)
	{
			$this->salida = "";
			$dbSistema = new cls_DBProcesoFacturacionCobranza($this->decodificar);
			$res = $dbSistema ->EliminarProcesoFacturacionCobranza($id_sistema_distribucion);
			$this->salida= $dbSistema->salida;
			$this->query = $dbSistema ->query;
			return $res;
	}	
	
	
	function ListarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBProcesoFacturacionCobranza($this->decodificar);
		$res = $dbPlantilla ->ListarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBProcesoFacturacionCobranza($this->decodificar);
		$res = $dbPlantilla ->ContarProcesoFacturacionCobranza($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////FIN cls_ContarProcesoFacturacionCobranza
	
	
}