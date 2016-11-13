<?php
/**
 * Nombre de la Clase:	    CustomDBFactur
 * Propósito:				es la interfaz del modelo del Sistema de Facturación
 * Fecha de Creación:		2014.05
 * Autor:					Telma Soliz López
 *
 */
class cls_CustomDBFactur
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
	// - TSL -
		include_once("cls_DBDosifica.php");
		include_once("cls_DBCliente.php");
		include_once("cls_DBClieCta.php");
		include_once("cls_DBFactura.php");
		include_once("cls_DBFacturaDet.php");
		include_once("cls_DBNdc.php");
		include_once("cls_DBNdcDet.php");
	}
	// - TSL -
	// - DOSIFICA -
	function ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
		return true;
	}
	function ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
	}
	function InsertarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->InsertarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
	}
	function ModificarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ModificarDosifica($hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
	}
	function EliminarDosifica($id_dosifica)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica -> EliminarDosifica($id_dosifica);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
	}
	function ValidarDosifica($operacion_sql,$hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ValidarDosifica($operacion_sql,$hidden_id_dosifica,$txt_tipo_fac,$txt_nro_autoriza,$txt_fecha_vence,$txt_clave_activa,$txt_sw_debito,$txt_nro_inicial,$txt_nro_actual,$txt_actividad,$txt_leyenda,$txt_estado);
		$this->salida = $dbDosifica->salida;
		$this->query = $dbDosifica->query;
		return $res;
	}
	// - FIN DOSIFICA -
	
	// - CLIENTE -
	function ListarCliente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente ->ListarCliente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
		return true;
	}
	function ContarCliente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente ->ContarCliente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
	}
	function InsertarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente ->InsertarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
	}
	function ModificarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente ->ModificarCliente($id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
	}
	function EliminarCliente($id_cliente)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente -> EliminarCliente($id_cliente);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
	}
	function ValidarCliente($operacion_sql, $id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact)
	{
		$this->salida = "";
		$dbCliente = new cls_DBCliente($this->decodificar);
		$res = $dbCliente ->ValidarCliente($operacion_sql, $id_cliente, $razon_social, $nro_nit, $direccion, $telefono, $repre_legal, $docid_legal, $nomb_fact);
		$this->salida = $dbCliente->salida;
		$this->query = $dbCliente->query;
		return $res;
	}
	// - FIN CLIENTE -
	
	// - CLIENTE - CTA -
	function ListarClieCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta ->ListarClieCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
		return true;
	}
	function ContarClieCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta ->ContarClieCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
	}
	function InsertarClieCta($id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta ->InsertarClieCta($id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
	}
	function ModificarClieCta($id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta ->ModificarClieCta($id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
	}
	function EliminarClieCta($id_clie_cta)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta -> EliminarClieCta($id_clie_cta);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
	}
	function ValidarClieCta($operacion_sql, $id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar)
	{
		$this->salida = "";
		$dbClieCta = new cls_DBClieCta($this->decodificar);
		$res = $dbClieCta ->ValidarClieCta($operacion_sql, $id_clie_cta, $id_cliente, $id_gestion, $id_cuenta, $id_auxiliar);
		$this->salida = $dbClieCta->salida;
		$this->query = $dbClieCta->query;
		return $res;
	}
	// - FIN CLIENTE - CTA -
	
	// - FACTURA -
	function ListarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ListarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
		return true;
	}
	function ContarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ContarFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function InsertarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->InsertarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function ModificarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ModificarFactura($id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function EditarFactura($id_factura, $fac_concepto)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->EditarFactura($id_factura, $fac_concepto);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function EliminarFactura($id_factura)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura -> EliminarFactura($id_factura);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function ValidarFactura($operacion_sql, $id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ValidarFactura($operacion_sql, $id_factura, $id_gestion, $id_cliente, $id_dosifica, $id_moneda, $id_depto, $fac_tcambio, $fac_fecha, $fac_concepto, $fac_formula);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function ListarTCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ListarTCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function ProcesarFactura($accion,$id_factura)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura -> ProcesarFactura($accion,$id_factura);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
	}
	function ListarFacturaQR($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFactura = new cls_DBFactura($this->decodificar);
		$res = $dbFactura ->ListarFacturaQR($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFactura->salida;
		$this->query = $dbFactura->query;
		return $res;
		return true;
	}
	// - FIN FACTURA -
	
	// - FACTURA-DET -
	function ListarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->ListarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
		return true;
	}
	function ContarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->ContarFacturaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	function InsertarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->InsertarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	function ModificarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->ModificarFacturaDet($id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	function EditarFacturaDet($id_factura_det, $id_factura, $fac_obsdesc)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->EditarFacturaDet($id_factura_det, $id_factura, $fac_obsdesc);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	function EliminarFacturaDet($id_factura_det)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet -> EliminarFacturaDet($id_factura_det);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	function ValidarFacturaDet($operacion_sql, $id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc)
	{
		$this->salida = "";
		$dbFacturaDet = new cls_DBFacturaDet($this->decodificar);
		$res = $dbFacturaDet ->ValidarFacturaDet($operacion_sql, $id_factura_det, $id_factura, $id_presupuesto, $id_ppto_gasto, $id_concepto_ingas, $fac_importe, $fac_descuento, $fac_obsdesc);
		$this->salida = $dbFacturaDet->salida;
		$this->query = $dbFacturaDet->query;
		return $res;
	}
	// - FIN FACTURA-DET -
	// - NDC -
	function ListarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->ListarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
		return true;
	}
	function ContarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->ContarNdc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	function InsertarNdc($id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->InsertarNdc($id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	function ModificarNdc($id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->ModificarNdc($id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	function EliminarNdc($id_factura)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc -> EliminarNdc($id_factura);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	function ValidarNdc($operacion_sql, $id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->ValidarNdc($operacion_sql, $id_ndc, $id_gestion, $id_factura, $id_dosifica, $ndc_fecha, $ndc_concepto, $ndc_formula);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	function ProcesarNdc($accion,$id_ndc)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc -> ProcesarNdc($accion,$id_ndc);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
	}
	// - FIN NDC-
	// - NDC-DET -
	function ListarNdcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->ListarNdcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
		return true;
	}
	function ContarNdcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->ContarNdcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	function InsertarNdcDet($id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->InsertarNdcDet($id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	function ModificarNdcDet($id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->ModificarNdcDet($id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	function EditarNdcDet($id_ndc_det, $ndc_obsdet)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->EditarNdcDet($id_ndc_det, $ndc_obsdet);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	function EliminarNdcDet($id_ndc_det)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet -> EliminarNdcDet($id_ndc_det);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	function ValidarNdcDet($operacion_sql, $id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet)
	{
		$this->salida = "";
		$dbNdcDet = new cls_DBNdcDet($this->decodificar);
		$res = $dbNdcDet ->ValidarNdcDet($operacion_sql, $id_ndc_det, $id_ndc, $id_factura_det, $ndc_importe, $ndc_obsdet);
		$this->salida = $dbNdcDet->salida;
		$this->query = $dbNdcDet->query;
		return $res;
	}
	// - FIN NDC-DET -
       function ListarNdcQR($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNdc = new cls_DBNdc($this->decodificar);
		$res = $dbNdc ->ListarNdcQR($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNdc->salida;
		$this->query = $dbNdc->query;
		return $res;
		return true;
	}
}?>