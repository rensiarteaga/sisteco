<?php
/**
 * Nombre de la Clase:	    CustomDBTesoro
 * Propï¿½sito:				Interfaz del modelo del Sistema de sis_tesoreria
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creaciï¿½n:		2008-07-02 17:16:25
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBTesoreria{
	var $salida = "";
	var $query = "";
	var $decodificar = false;
	
	function __construct(){
		include_once("cls_DBNivelOec.php");
		include_once("cls_DBParametro.php");
		include_once("cls_DBOecArb.php");
		include_once("cls_DBCuentaBancaria.php");
		include_once("cls_DBDosifica.php");
		include_once("cls_DBAvance.php");
		include_once("cls_DBCaja.php");
		include_once("cls_DBCajaArqueo.php");
		include_once("cls_DBCajaRegis.php");
		include_once("cls_DBCorteArqueo.php");
	    include_once("cls_DBFacturaRecibo.php");
	    include_once("cls_DBDevengado.php");
	    include_once("cls_DBDevengadoDetalle.php");
	    include_once("cls_DBCarta.php");
	    include_once("cls_DBCartaDocs.php");
	    include_once("cls_DBViatico.php");
	    include_once("cls_DBCajero.php");
	    include_once("cls_DBCorteMoneda.php");
	    include_once("cls_DBViaticoRinde.php");
        include_once("cls_DBAvanceDetalle.php");
        include_once("cls_DBDevengadoDcto.php");
        include_once("cls_DBEntidad.php");
        include_once("cls_DBViaticoCalculo.php");
        include_once("cls_DBRendicionCuentas.php");	
        include_once("cls_DBCuentaDoc.php");
        include_once("cls_DBCuentaDocDet.php");
        include_once("cls_DBCategoriaTipoDestino.php");
        include_once("cls_DBTipoDestino.php");
        include_once("cls_DBCuentaDocRendicionCab.php");
        include_once("cls_DBCuentaDocRendicion.php");
        include_once("cls_DBAdmCheque.php");
        include_once("cls_DBDevPasaje.php");
        include_once("cls_DBDevengadoConcepto.php");
        include_once("cls_DBEstadoRendiciones.php");
        include_once("cls_DBViaPasaje.php");
        include_once("cls_DBRepReciboPago.php");
        include_once("cls_DBRepSolicitudEfectivo.php");
	}
	
/// ---------------------  tts_nivel_oec --------------------- ///
	function ListarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec ->ListarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}

	function ContarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec ->ContarNivelOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}

	function InsertarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec ->InsertarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}

	function ModificarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec ->ModificarNivelOec($id_nivel_oec,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}

	function EliminarNivelOec($id_nivel_oec)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec -> EliminarNivelOec($id_nivel_oec);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}

	function ValidarNivelOec($operacion_sql,$id_nivel_oec,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelOec = new cls_DBNivelOec($this->decodificar);
		$res = $dbNivelOec ->ValidarNivelOec($operacion_sql,$id_nivel_oec,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelOec ->salida;
		$this->query = $dbNivelOec ->query;
		return $res;
	}
	/// --------------------- fin tts_nivel_oec --------------------- ///
	/// ---------------------  tts_parametro --------------------- ///
	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro,$max_sol_pendientes_viatico,$max_sol_pendientes_fa,$sw_descuento_viaticos,$dias_aplica_descuento,$porcentaje_descuento,$max_sol_pendientes_efe,$sw_detiene,$fecha_del,$fecha_al,$fecha_fin_viaje,$fecha_fin_viaje_al);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function EliminarParametro($id_parametro)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> EliminarParametro($id_parametro);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_tesoro);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	/// --------------------- fin tts_parametro --------------------- ///
	/// ---------------------  tts_oec --------------------- ///
	function ListarOecRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ListarOecRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function ListarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ListarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function ContarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ContarOecArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}
    function ListarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ListarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function ContarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ContarOecField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}
	function InsertarOecRaiz($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->InsertarOecRaiz($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function InsertarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec -> InsertarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}
	function ModificarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->ModificarOecArb($id_oec,$nro_oec,$nombre_oec,$desc_oec,$nivel_oec,$tipo_oec,$sw_transaccional,$id_oec_padre,$id_parametro);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function EliminarOecArb($id_oec,$id_oec_padre)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec ->EliminarOecArb($id_oec,$id_oec_padre);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	function EliminarOecRaiz($id_oec)
	{
		$this->salida = "";
		$dbOec = new cls_DBOecArb($this->decodificar);
		$res = $dbOec -> EliminarOecRaiz($id_oec);
		$this->salida = $dbOec ->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

	/// --------------------- fin tts_oec --------------------- ///
	/// --------------------- tts_cuenta_bancaria --------------------- ///

	function ListarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria ->ListarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	function ContarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria ->ContarCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	function InsertarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria ->InsertarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	function ModificarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria ->ModificarCuentaBancaria($id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	function EliminarCuentaBancaria($id_cuenta_bancaria)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria -> EliminarCuentaBancaria($id_cuenta_bancaria);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	function ValidarCuentaBancaria($operacion_sql,$id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro)
	{
		$this->salida = "";
		$dbCuentaBancaria = new cls_DBCuentaBancaria($this->decodificar);
		$res = $dbCuentaBancaria ->ValidarCuentaBancaria($operacion_sql,$id_cuenta_bancaria,$id_institucion,$id_cuenta,$auxiliar,$nro_cheque,$estado_cuenta,$nro_cuenta_banco,$id_parametro);
		$this->salida = $dbCuentaBancaria ->salida;
		$this->query = $dbCuentaBancaria ->query;
		return $res;
	}
	
	/// --------------------- fin tts_cuenta_bancaria --------------------- ///

	/// --------------------- tts_dosifica --------------------- ///

	function ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ListarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	function ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ContarDosifica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	function InsertarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->InsertarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	function ModificarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ModificarDosifica($id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	function EliminarDosifica($id_dosifica)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica -> EliminarDosifica($id_dosifica);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	function ValidarDosifica($operacion_sql,$id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica)
	{
		$this->salida = "";
		$dbDosifica = new cls_DBDosifica($this->decodificar);
		$res = $dbDosifica ->ValidarDosifica($operacion_sql,$id_dosifica,$fecha_vence,$llave_activar,$nro_autoriza,$nro_inicial,$nro_final,$estado_dosifica);
		$this->salida = $dbDosifica ->salida;
		$this->query = $dbDosifica ->query;
		return $res;
	}
	
	/// --------------------- fin tts_dosifica --------------------- ///
	
	/// --------------------- tts_avance --------------------- ///

	function ListarSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ContarSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContarSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ListarSolicitudAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarSolicitudAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ContarSolicitudAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContarSolicitudAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ListarSolicitudADQAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarSolicitudADQAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ContarSolicitudADQAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContarSolicitudADQAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ListarAvanceSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBAvance($this->decodificar);
		$res = $dbSolicitudCompra ->ListarAvanceSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	function ContarAvanceSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBAvance($this->decodificar);
		$res = $dbSolicitudCompra ->ContarAvanceSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	function InsertarAvanceSolicitud($id_avance,$id_solicitud)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->InsertarAvanceSolicitud($id_avance,$id_solicitud);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function EliminarAvanceSolicitud($id_avance,$id_solicitud)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->EliminarAvanceSolicitud($id_avance,$id_solicitud);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ContabilizarFondoAvance($id_avance,$id_empleado,$id_moneda)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContabilizarFondoAvance($id_avance,$id_empleado,$id_moneda);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ListarDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ContarDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContarDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function AnularDescargo($id_avance,$id_plan_pago)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->AnularDescargo($id_avance,$id_plan_pago);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ListarReporteDescargoCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarReporteDescargoCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ListarReporteDescargoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarReporteDescargoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ListarReporteDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarReporteDescargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ListarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ListarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ContarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ContarDescargoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function InsertarSolicitudFondos($id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$concepto_avance,$observacion_avance)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->InsertarSolicitudFondos($id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$concepto_avance,$observacion_avance);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ModificarSolicitudFondos($id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$concepto_avance,$observacion_avance)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ModificarSolicitudFondos($id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$concepto_avance,$observacion_avance);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function InsertarDescargo($id_avance,$id_unidad_organizacional,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_presupuesto,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$fecha_ini_rendicion,$fecha_fin_rendicion)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->InsertarDescargo($id_avance,$id_unidad_organizacional,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_presupuesto,$id_depto,$id_caja,$avance_solicitud,$id_cajero,$nro_avance,$fecha_ini_rendicion,$fecha_fin_rendicion);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ModificarDescargo($id_avance,$fecha_avance,$nro_avance,$fecha_ini_rendicion,$fecha_fin_rendicion)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ModificarDescargo($id_avance,$fecha_avance,$nro_avance,$fecha_ini_rendicion,$fecha_fin_rendicion);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}	
	function EliminarSolicitudFondos($id_avance)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance -> EliminarSolicitudFondos($id_avance);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function EliminarDescargoDetalle($id_avance)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance -> EliminarDescargoDetalle($id_avance);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ChequeEmitido($id_avance,$estado_avance)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ChequeEmitido($id_avance,$estado_avance);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function InsertarValeAvance($id_avance,$tipo,$id_empleado,$importe_avance,$id_moneda,$id_caja,$id_cajero)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->InsertarValeAvance($id_avance,$tipo,$id_empleado,$importe_avance,$id_moneda,$id_caja,$id_cajero);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}	
	function ValidarSolicitudFondos($operacion_sql,$id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$id_cajero)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ValidarSolicitudFondos($operacion_sql,$id_avance,$id_empleado,$tipo_avance,$fecha_avance,$importe_avance,$estado_avance,$id_moneda,$id_cheque,$id_documento,$id_comprobante,$fk_avance,$id_depto,$id_caja,$id_cajero);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ReporteCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ReporteCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ReporteReciboFondoAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ReporteReciboFondoAvance($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ModificarDescargoDetalle($id_avance,$id_usuario_aprueba)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ModificarDescargoDetalle($id_avance,$id_usuario_aprueba);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function ComproContaDescargo($id_avance,$id_moneda)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->ComproContaDescargo($id_avance,$id_moneda);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function FinalizaPendienteAvance($id_avance,$tipo)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->FinalizaPendienteAvance($id_avance,$tipo);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	function AprobarDocumentoDescargo($id_avance,$id_usuario_aprueba)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance ->AprobarDocumentoDescargo($id_avance,$id_usuario_aprueba);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	/// --------------------- fin tts_avance --------------------- ///
	
	/// --------------------- tts_caja_arqueo --------------------- ///

	function ListarArqueo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo ->ListarArqueo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	function ContarArqueo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo ->ContarArqueo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	function InsertarArqueo($id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo ->InsertarArqueo($id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	function ModificarArqueo($id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo ->ModificarArqueo($id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	function EliminarArqueo($id_caja_arqueo)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo -> EliminarArqueo($id_caja_arqueo);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	function ValidarArqueo($operacion_sql,$id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo)
	{
		$this->salida = "";
		$dbCajaArqueo = new cls_DBCajaArqueo($this->decodificar);
		$res = $dbCajaArqueo ->ValidarArqueo($operacion_sql,$id_caja_arqueo,$id_caja,$id_cajero,$fecha_arqueo,$sw_resultado,$obs_arqueo);
		$this->salida = $dbCajaArqueo ->salida;
		$this->query = $dbCajaArqueo ->query;
		return $res;
	}
	
	/// --------------------- fin tts_caja_arqueo --------------------- ///
	/// --------------------- tts_caja_regis --------------------- ///

	/// --------------------- tts_caja_regis --------------------- ///

	function ListarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ContarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ContarReposicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function InsertarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis, $nro_documento ,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->InsertarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis,$nro_documento ,$fecha_ini,$fecha_fin);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ModificarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$tipo_regis,$fecha_regis,$importe_regis,$id_cheque,$estado_regis,$nro_documento ,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ModificarReposicionCaja($id_caja_regis,$id_caja,$id_cajero,$tipo_regis,$fecha_regis,$importe_regis,$id_cheque,$estado_regis,$nro_documento ,$fecha_ini,$fecha_fin);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function EliminarReposicionCaja($id_caja_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis -> EliminarReposicionCaja($id_caja_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ValidarReposicionCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ValidarReposicionCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$fecha_regis,$importe_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarReporteValeCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteValeCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarReporteRendicionEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteRendicionEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarReporteRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarReporteRendicionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteRendicionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ContarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ContarValesCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function InsertarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$concepto_regis,$id_proveedor)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->InsertarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$concepto_regis,$id_proveedor);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ModificarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$estado_regis,$importe_entregado,$concepto_regis,$id_proveedor)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ModificarValesCaja($id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis,$estado_regis,$importe_entregado,$concepto_regis,$id_proveedor);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function EliminarValesCaja($id_caja_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis -> EliminarValesCaja($id_caja_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ValidarValesCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ValidarValesCaja($operacion_sql,$id_caja_regis,$id_caja,$id_cajero,$id_empleado,$importe_regis,$fecha_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function VerificarRendicionVale($id_caja_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->VerificarRendicionVale($id_caja_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	//jmh 08/04/2009
	function ListarReporteRendicionHeader($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteRendicionHeader($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	function ListarReporteRendicionReposicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarReporteRendicionReposicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	/// --------------------- tts_caja_regis --------------------- ///

	function ListarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ListarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ListarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ContarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ContarRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ContarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ContarRendicionesPendientes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function InsertarRendiciones($id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fk_id_caja_regis,$concepto_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->InsertarRendiciones($id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fk_id_caja_regis,$concepto_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ModificarRendiciones($id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$concepto_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ModificarRendiciones($id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$concepto_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ModificarRendicionesFin($id_caja_regis,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$concepto_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ModificarRendicionesFin($id_caja_regis,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$concepto_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ModificarRendicionesPendientes($fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_cotizacion)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ModificarRendicionesPendientes($fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_cotizacion);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function EliminarRendiciones($id_caja_regis)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis -> EliminarRendiciones($id_caja_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function MarcarRendiciones($id_caja_regis)
	{
		
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis -> MarcarRendiciones($id_caja_regis);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	function ValidarRendiciones($operacion_sql,$id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajaRegis = new cls_DBCajaRegis($this->decodificar);
		$res = $dbCajaRegis ->ValidarRendiciones($operacion_sql,$id_caja_regis,$id_cajero,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_concepto_ingas,$importe_regis,$tipo_documento,$fecha_documento,$nro_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajaRegis ->salida;
		$this->query = $dbCajaRegis ->query;
		return $res;
	}
	
	
	/// --------------------- fin tts_caja_regis --------------------- ///
	/// --------------------- tts_corte_arqueo --------------------- ///

		/// --------------------- tts_corte_arqueo --------------------- ///

	function ListarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo ->ListarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	function ContarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo ->ContarDetalleCortes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	function InsertarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo ->InsertarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	function ModificarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo ->ModificarDetalleCortes($id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	function EliminarDetalleCortes($id_corte_arqueo)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo -> EliminarDetalleCortes($id_corte_arqueo);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	function ValidarDetalleCortes($operacion_sql,$id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte)
	{
		$this->salida = "";
		$dbCorteArqueo = new cls_DBCorteArqueo($this->decodificar);
		$res = $dbCorteArqueo ->ValidarDetalleCortes($operacion_sql,$id_corte_arqueo,$id_caja_arqueo,$id_corte,$cantidad_corte);
		$this->salida = $dbCorteArqueo ->salida;
		$this->query = $dbCorteArqueo ->query;
		return $res;
	}
	
	/// --------------------- fin tts_corte_arqueo --------------------- ///
	/// --------------------- tts_factura_recibo --------------------- ///

	function ListarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ListarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ContarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ContarEmisionFactura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function InsertarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->InsertarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ModificarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ModificarEmisionFactura($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function EliminarEmisionFactura($id_factura_recibo)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo -> EliminarEmisionFactura($id_factura_recibo);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ValidarEmisionFactura($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ValidarEmisionFactura($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$nro_nit,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ListarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ListarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ContarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ContarEmisionRecibo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function InsertarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->InsertarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ModificarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ModificarEmisionRecibo($id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function EliminarEmisionRecibo($id_factura_recibo)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo -> EliminarEmisionRecibo($id_factura_recibo);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	function ValidarEmisionRecibo($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFacturaRecibo = new cls_DBFacturaRecibo($this->decodificar);
		$res = $dbFacturaRecibo ->ValidarEmisionRecibo($operacion_sql,$id_factura_recibo,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cajero,$id_concepto_ingas,$id_moneda,$importe_factura,$nro_deposito,$fecha_deposito,$razon_social,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFacturaRecibo ->salida;
		$this->query = $dbFacturaRecibo ->query;
		return $res;
	}
	
	/// --------------------- fin tts_factura_recibo --------------------- ///
	/// --------------------- tts_carta --------------------- ///

	function ListarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->ListarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	
	function ContarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->ContarCartaRegistro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	
	function InsertarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->InsertarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	function ModificarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->ModificarCartaRegistro($id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	/////////////////////////////////////////////////////////
	function InsertarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta)
	{	$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->InsertarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	
	function ModificarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->ModificarCartaAmortizacionDetalle($id_carta,$fecha_inicio,$importe_pagado,$fk_carta);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	////////////////////////////////////////////////
	
	function EliminarCartaRegistro($id_carta)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta -> EliminarCartaRegistro($id_carta);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	
	function ValidarCartaRegistro($operacion_sql,$id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCarta = new cls_DBCarta($this->decodificar);
		$res = $dbCarta ->ValidarCartaRegistro($operacion_sql,$id_carta,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_moneda,$clase_carta,$tipo_carta,$estado_carta,$id_cuenta_bancaria,$id_institucion,$id_proveedor,$fecha_inicio,$fecha_vence,$obs_carta,$importe_carta,$importe_pagado,$id_cheque,$id_comprobante,$fk_carta,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCarta ->salida;
		$this->query = $dbCarta ->query;
		return $res;
	}
	
	/// --------------------- fin tts_carta --------------------- ///
	/// --------------------- tts_carta_docs --------------------- ///

	function ListarCartaDocs($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs ->ListarCartaDocs($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	function ContarCartaDocs($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs ->ContarCartaDocs($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	function InsertarCartaDocs($id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs ->InsertarCartaDocs($id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	function ModificarCartaDocs($id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs ->ModificarCartaDocs($id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	function EliminarCartaDocs($id_carta_docs)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs -> EliminarCartaDocs($id_carta_docs);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	function ValidarCartaDocs($operacion_sql,$id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta)
	{
		$this->salida = "";
		$dbCartaDocs = new cls_DBCartaDocs($this->decodificar);
		$res = $dbCartaDocs ->ValidarCartaDocs($operacion_sql,$id_carta_docs,$id_carta,$descri_docs,$fecha_presenta,$sw_presenta);
		$this->salida = $dbCartaDocs ->salida;
		$this->query = $dbCartaDocs ->query;
		return $res;
	}
	
	/// --------------------- fin tts_carta_docs --------------------- ///
	/// --------------------- tts_devengado --------------------- ///

	function ListarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ListarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function ContarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ContarDevengarServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
function InsertarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$entrega_doc,$tipo_plantilla,$id_caja)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->InsertarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$entrega_doc,$tipo_plantilla,$id_caja);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function ModificarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$entrega_doc,$tipo_plantilla,$id_caja)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ModificarDevengarServicios($id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado,$observaciones,$id_depto,$fecha_devengado,$tipo_desembolso,$id_cajero,$id_emp_recep_caja,$id_periodo_subsistema,$entrega_doc,$tipo_plantilla,$id_caja);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function EliminarDevengarServicios($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> EliminarDevengarServicios($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function ValidarDevengarServicios($operacion_sql,$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ValidarDevengarServicios($operacion_sql,$id_devengado,$id_concepto_ingas,$id_moneda,$importe_devengado,$estado_devengado,$id_proveedor,$tipo_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 23/10/2008
	function ObtenerSaldoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ObtenerSaldoDev($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function GenerarPago($fk_devengado,$importe_pagado,$fecha_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> GenerarPago($fk_devengado,$importe_pagado,$fecha_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 13/11/2008
	function ObtenerTotalProrrateado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ObtenerTotalProrrateado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 19/11/2008
	function ModificarPago($id_devengado,$importe_pagado,$fecha_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ModificarPago($id_devengado,$importe_pagado,$fecha_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 19/11/2008
	function EliminarPago($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> EliminarPago($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 04/12/2008
	function VerificarRegistroDocumento($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> VerificarRegistroDocumento($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 10/12/2008
	function ExisteDocumento($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ExisteDocumento($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 09/02/2009
	function FinalizarDevengado($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> FinalizarDevengado($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 10/02/2009
	function FinalizarDevengadoPagado($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> FinalizarDevengadoPagado($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 12/02/2009
	function ObtenerSaldoPag($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ObtenerSaldoPag($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 05/03/2009
	function ReporteDevengadoServiciosFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ReporteDevengadoServiciosFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 11/03/2009
	function ListarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ListarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 11/03/2009
	function ContarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ContarAprobacionProrrateo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 24/04/2009
	function ContabilizarDevengado($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ContabilizarDevengado($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 27/04/2009
	function FinalizarPago($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> FinalizarPago($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 08/05/2009
	function VerificaImporteDocumento($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> VerificaImporteDocumento($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 08/05/2009
	function ContabilizarDevengadoRegulariz($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ContabilizarDevengadoRegulariz($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 13/07/2009
	function GenerarValeCaja($id_devengado)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> GenerarValeCaja($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	//JMH 16/11/2009
	function ModificarPagoRegulariza($id_devengado, $importe_pagado, $fecha_devengado,$tipo_documento,$tipo_documento_regularizado) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ModificarPagoRegulariza($id_devengado, $importe_pagado, $fecha_devengado,$tipo_documento,$tipo_documento_regularizado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
//JMH 18/11/2009
	function ObtenerProrrateoDevengado($id_devengado) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ObtenerProrrateoDevengado($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 23/11/2009
	function FinalizarSolicitudDevengado($id_devengado,$id_empleado) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> FinalizarSolicitudDevengado($id_devengado,$id_empleado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 23/11/2009
	function RegistrarDesemDevengado($id_devengado,$tipo_pago,$tipo_plantilla,$id_cuenta_bancaria) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> RegistrarDesemDevengado($id_devengado,$tipo_pago,$tipo_plantilla,$id_cuenta_bancaria);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 24/11/2009
	function VerificarDevengadoPadrePago($id_devengado) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> VerificarDevengadoPadrePago($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 25/11/2009
	function ContabilizarPago($id_devengado,$tipo_plantilla,$id_cuenta_bancaria)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> ContabilizarPago($id_devengado,$tipo_plantilla,$id_cuenta_bancaria);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 28/11/2009
	function RegularizarPago($id_devengado,$tipo_plantilla)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> RegularizarPago($id_devengado,$tipo_plantilla);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	//RCM: 12/01/2010
	function CorregirSolicitudDevengado($id_devengado) 
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado -> CorregirSolicitudDevengado($id_devengado);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function ReciboPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ReciboPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	function ReciboPagoDetalleDescuentos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengado = new cls_DBDevengado($this->decodificar);
		$res = $dbDevengado ->ReciboPagoDetalleDescuentos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengado ->salida;
		$this->query = $dbDevengado ->query;
		return $res;
	}
	
	/// --------------------- fin tts_devengado --------------------- ///
	/// --------------------- tts_devengado_detalle --------------------- ///

	function ListarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle ->ListarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	function ContarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle ->ContarDevengadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	function InsertarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle ->InsertarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	function ModificarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle ->ModificarDevengadoDetalle($id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	function EliminarDevengadoDetalle($id_devengado_detalle)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle -> EliminarDevengadoDetalle($id_devengado_detalle);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	function ValidarDevengadoDetalle($operacion_sql,$id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$porc_monto)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle ->ValidarDevengadoDetalle($operacion_sql,$id_devengado_detalle,$id_devengado,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$porcentaje_devengado,$importe_devengado,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$porc_monto);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	//RCM: 27/10/2008
	function AjustarDevengadoDetalle($id_devengado)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle -> AjustarDevengadoDetalle($id_devengado);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	//RCM: 10/03/2009
	function AprobarDevengadoDetalle($id_devengado_detalle,$aprobacion)
	{
		$this->salida = "";
		$dbDevengadoDetalle = new cls_DBDevengadoDetalle($this->decodificar);
		$res = $dbDevengadoDetalle -> AprobarDevengadoDetalle($id_devengado_detalle,$aprobacion);
		$this->salida = $dbDevengadoDetalle ->salida;
		$this->query = $dbDevengadoDetalle ->query;
		return $res;
	}
	
	/// --------------------- fin tts_devengado_detalle --------------------- ///
	
	/// --------------------- tts_viatico --------------------- ///
//jos 25/03/2009
	function ListarReporteRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarReporteRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ListarReporteViaticoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarReporteViaticoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ListarNombreGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViatico ->ListarNombreGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ListarRendicionViaticosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViatico ->ListarRendicionViaticosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	//fin jos
	function ListarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	//fin jos
	function ListarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ListarReporteSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarReporteSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}	
		
	function ListarMontosViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_destino,$cobertura,$id_moneda)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ListarMontosViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_destino,$cobertura,$id_moneda);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ContarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ContarSolicitudViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ContarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ContarPagoViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function InsertarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
						$id_empleado,$id_categoria,$id_moneda,
						$id_cuenta_bancaria,$nombre_cheque,						
						$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
						$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
						$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
						$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
						$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
						$id_responsable_rendicion,$id_autorizacion,$id_aprobacion)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->InsertarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
						$id_empleado,$id_categoria,$id_moneda,
						$id_cuenta_bancaria,$nombre_cheque,						
						$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
						$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
						$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
						$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
						$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
						$id_responsable_rendicion,$id_autorizacion,$id_aprobacion);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ModificarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
						$id_empleado,$id_categoria,$id_moneda,
						$id_cuenta_bancaria,$nombre_cheque,						
						$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
						$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
						$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
						$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
						$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
						$id_responsable_rendicion,$id_autorizacion,$id_aprobacion)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ModificarSolicitudViaticos($id_viatico,$id_unidad_organizacional,
						$id_empleado,$id_categoria,$id_moneda,
						$id_cuenta_bancaria,$nombre_cheque,						
						$estado_viatico,$fecha_solicitud,$num_solicitud,$detalle_viaticos,
						$motivo_viaje,$detalle_otros,$sw_retencion,$tipo_pago,
						$id_caja, $id_cajero, $importe_regis,$tipo_actualizacion,
						$tipo_viatico,$fk_viatico,$observacion,$fecha_inicio,$fecha_fin,
						$numero_deposito,$id_depto,$obs_viatico,$id_presupuesto,
						$id_responsable_rendicion,$id_autorizacion,$id_aprobacion);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function VerificarSaldoViatico($id_viatico)
	{
		$this->salida = "";
		$dbViatico = new cls_DBCajaRegis($this->decodificar);
		$res = $dbViatico ->VerificarSaldoViatico($id_viatico);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function EliminarSolicitudViaticos($id_viatico)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico -> EliminarSolicitudViaticos($id_viatico);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	
	function ValidarSolicitudViaticos($operacion_sql,$id_viatico,$id_unidad_organizacional,
							$id_empleado,$id_categoria,$id_moneda,
							$id_cuenta_bancaria,$nombre_cheque)
	{
		$this->salida = "";
		$dbViatico = new cls_DBViatico($this->decodificar);
		$res = $dbViatico ->ValidarSolicitudViaticos($operacion_sql,$id_viatico,$id_unidad_organizacional,
							$id_empleado,$id_categoria,$id_moneda,
							$id_cuenta_bancaria,$nombre_cheque);
		$this->salida = $dbViatico ->salida;
		$this->query = $dbViatico ->query;
		return $res;
	}
	/// --------------------- fin tts_viatico --------------------- ///
	
	/// --------------------- tts_caja --------------------- ///
	function ListarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ListarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ContarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ContarCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function InsertarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->InsertarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ModificarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ModificarCaja($id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti,$codigo_caja,$id_depto,$id_responsable_caja);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function EliminarCaja($id_caja)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja -> EliminarCaja($id_caja);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ValidarCaja($operacion_sql,$id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ValidarCaja($operacion_sql,$id_caja,$tipo_caja,$id_unidad_organizacional,$id_moneda,$id_dosifica,$fecha_inicio,$fecha_cierre,$sw_factura,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nro_recibo,$estado_caja,$id_partida_cuenta,$id_auxiliar,$id_fina_regi_prog_proy_acti);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ListarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ListarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ContarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ContarAperturaCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function ModificarAperturaCaja($id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre,$nro_vale,$nro_rinde,$nro_recibo)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ModificarAperturaCaja($id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre,$nro_vale,$nro_rinde,$nro_recibo);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	function EliminarAperturaCaja($id_caja)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja -> EliminarAperturaCaja($id_caja);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
		
	function ValidarAperturaCaja($operacion_sql,$id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre)
	{
		$this->salida = "";
		$dbCaja = new cls_DBCaja($this->decodificar);
		$res = $dbCaja ->ValidarAperturaCaja($operacion_sql,$id_caja,$fecha_inicio,$importe_maximo,$porcentaje_compra,$porcentaje_rinde,$nombre);
		$this->salida = $dbCaja ->salida;
		$this->query = $dbCaja ->query;
		return $res;
	}
	
	
	/// --------------------- fin tts_caja --------------------- ///
		/// --------------------- tts_cajero --------------------- ///

	function ListarCajero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->ListarCajero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	function ContarCajero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->ContarCajero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	function InsertarCajero($id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->InsertarCajero($id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	function ModificarCajero($id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->ModificarCajero($id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	
	function ModificarCajeroBotton($id_cajero)
	{	$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->ModificarCajeroBotton($id_cajero);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	function EliminarCajero($id_cajero)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero -> EliminarCajero($id_cajero);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	function ValidarCajero($operacion_sql,$id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja)
	{
		$this->salida = "";
		$dbCajero = new cls_DBCajero($this->decodificar);
		$res = $dbCajero ->ValidarCajero($operacion_sql,$id_cajero,$id_empleado,$fecha_inicio,$fecha_final,$estado_cajero,$id_caja);
		$this->salida = $dbCajero ->salida;
		$this->query = $dbCajero ->query;
		return $res;
	}
	
	/// --------------------- fin tts_cajero --------------------- ///
	
	/// --------------------- tts_corte_moneda --------------------- ///

	function ListarCorteMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda ->ListarCorteMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	function ContarCorteMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda ->ContarCorteMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	function InsertarCorteMoneda($id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda ->InsertarCorteMoneda($id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	function ModificarCorteMoneda($id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda ->ModificarCorteMoneda($id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	function EliminarCorteMoneda($id_corte)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda -> EliminarCorteMoneda($id_corte);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	function ValidarCorteMoneda($operacion_sql,$id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte)
	{
		$this->salida = "";
		$dbCorteMoneda = new cls_DBCorteMoneda($this->decodificar);
		$res = $dbCorteMoneda ->ValidarCorteMoneda($operacion_sql,$id_corte,$id_moneda,$descri_corte,$importe_valor,$tipo_corte);
		$this->salida = $dbCorteMoneda ->salida;
		$this->query = $dbCorteMoneda ->query;
		return $res;
	}
	
	/// --------------------- fin tts_corte_moneda --------------------- ///
	
	/// --------------------- tts_viatico_rinde --------------------- ///

	function ListarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde ->ListarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	function ContarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde ->ContarRendicionViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	function InsertarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descricion)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde ->InsertarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descricion);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	function ModificarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descricion)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde ->ModificarRendicionViaticos($id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_presupuesto,$id_transaccion,$id_partida_ejecucion,$estado_rendicion,$descricion);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	function EliminarRendicionViaticos($id_viatico_rinde)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde -> EliminarRendicionViaticos($id_viatico_rinde);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	function ValidarRendicionViaticos($operacion_sql,$id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control)
	{
		$this->salida = "";
		$dbViaticoRinde = new cls_DBViaticoRinde($this->decodificar);
		$res = $dbViaticoRinde ->ValidarRendicionViaticos($operacion_sql,$id_viatico_rinde,$id_viatico,$id_concepto_ingas,$importe_rendicion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control);
		$this->salida = $dbViaticoRinde ->salida;
		$this->query = $dbViaticoRinde ->query;
		return $res;
	}
	
	/// --------------------- fin tts_viatico_rinde --------------------- ///
	/// ---------------------  tts_avance_detalle --------------------- ///
	function ListarAvanceDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->ListarAvanceDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}

	function ContarAvanceDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->ContarAvanceDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}

	function InsertarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida,$id_presupuesto)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->InsertarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida,$id_presupuesto);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}

	function ModificarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida,$id_presupuesto)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->ModificarAvanceDetalle($id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle,$sw_valida,$id_presupuesto);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}

	function EliminarAvanceDetalle($id_avance_detalle)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle -> EliminarAvanceDetalle($id_avance_detalle);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}
    function AprobarAvanceDetalle($id_avance_detalle,$id_avance,$sw_valida)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->AprobarAvanceDetalle($id_avance_detalle,$id_avance,$sw_valida);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}
	function ValidarAvanceDetalle($operacion_sql,$id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle)
	{
		$this->salida = "";
		$dbAvanceDetalle = new cls_DBAvanceDetalle($this->decodificar);
		$res = $dbAvanceDetalle ->ValidarAvanceDetalle($operacion_sql,$id_avance_detalle,$id_avance,$id_concepto_ingas,$importe_detalle,$observa_detalle);
		$this->salida = $dbAvanceDetalle ->salida;
		$this->query = $dbAvanceDetalle ->query;
		return $res;
	}
	/// --------------------- fin tts_nivel_oec --------------------- ///
	
	/// ---------------------  tts_devengado_dcto --------------------- ///
	function ListarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto ->ListarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}

	function ContarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto ->ContarDevengadoDcto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}

	function InsertarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto ->InsertarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}

	function ModificarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto ->ModificarDevengadoDcto($id_devengado_dcto,$id_devengado,$tipo_documento,$importe_doc,$id_moneda,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$estado_documento);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}

	function EliminarDevengadoDcto($id_devengado_dcto)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto -> EliminarDevengadoDcto($id_devengado_dcto);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}
	
	function RegularizarProformasDevengado($id_devengado_dcto,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$importe,$id_moneda)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto -> RegularizarProformasDevengado($id_devengado_dcto,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$importe,$id_moneda);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}
	
	function ObtenerTipoDocumentoAdq($id_cotizacion,$id_plan_pago)
	{
		$this->salida = "";
		$dbDevDcto = new cls_DBDevengadoDcto($this->decodificar);
		$res = $dbDevDcto -> ObtenerTipoDocumentoAdq($id_cotizacion,$id_plan_pago);
		$this->salida = $dbDevDcto ->salida;
		$this->query = $dbDevDcto ->query;
		return $res;
	}

	/// --------------------- fin tts_devengado_dcto --------------------- ///
	
	/// --------------------- tts_entidad --------------------- ///

	function ListarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad ->ListarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	function ContarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad ->ContarEntidad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	function InsertarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad ->InsertarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	function ModificarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad ->ModificarEntidad($id_entidad,$id_institucion,$id_parametro,$tipo_entidad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	function EliminarEntidad($id_entidad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad -> EliminarEntidad($id_entidad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	function ValidarEntidad($operacion_sql,$id_entidad,$id_institucion,$id_parametro,$tipo_entidad)
	{
		$this->salida = "";
		$dbEntidad = new cls_DBEntidad($this->decodificar);
		$res = $dbEntidad ->ValidarEntidad($operacion_sql,$id_entidad,$id_institucion,$id_parametro,$tipo_entidad);
		$this->salida = $dbEntidad ->salida;
		$this->query = $dbEntidad ->query;
		return $res;
	}
	
	/// --------------------- fin tts_entidad --------------------- ///
	
	/// --------------------- tts_viatico_calculo --------------------- ///

	function ListarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo ->ListarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	function ContarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo ->ContarViaticoCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	function InsertarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo ->InsertarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	function ModificarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo ->ModificarViaticoCalculo($id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_transporte,$importe_retencion,$tipo_registro,$detalle_viaticos,$detalle_otros,$tipo_viaje);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	function EliminarViaticoCalculo($id_viatico_calculo)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo -> EliminarViaticoCalculo($id_viatico_calculo);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	function ValidarViaticoCalculo($operacion_sql,$id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje)
	{
		$this->salida = "";
		$dbViaticoCalculo = new cls_DBViaticoCalculo($this->decodificar);
		$res = $dbViaticoCalculo ->ValidarViaticoCalculo($operacion_sql,$id_viatico_calculo,$id_viatico,$id_origen,$id_destino,$id_cobertura,$id_entidad,$fecha_inicio,$fecha_final,$nro_dias,$importe_pasaje,$importe_viatico,$importe_hotel,$importe_otros,$total_pasaje,$total_viaticos,$total_hotel,$total_general,$tipo_viaje);
		$this->salida = $dbViaticoCalculo ->salida;
		$this->query = $dbViaticoCalculo ->query;
		return $res;
	}
	
	/// --------------------- fin tts_viatico_calculo --------------------- ///
	// reporte Rendicion cuenta
	function CabeRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->CabeRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function DetalleRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->DetalleRendicionCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	//rendicion cuenta viaticos
	function CabeRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->CabeRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function DetalleRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->DetalleRendicionCuentasViaticos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	//rendicion cuenta cajas
	function CabeRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->CabeRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function DetalleRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_caja_regis)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->DetalleRendicionCuentasCajas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_caja_regis);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function CabeRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->CabeRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		
		
		return $res;
	}
	function DetalleRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->DetalleRendicionCuentaDoc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_avance);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function DetalleRendicionCuentaDoc2($id_caja,$fecha_ini,$fecha_fin,$tipo_rendicion)
	{
		
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		
		$res = $dbRendicionCuenta ->DetalleRendicionCuentaDoc2($id_caja,$fecha_ini,$fecha_fin,$tipo_rendicion);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function ListarReporteCabRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->ListarReporteCabRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function ListarReporteDetSolicitudesAmpliaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->ListarReporteDetSolicitudesAmpliaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function ListarReporteDetRendicionesAnteriores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->ListarReporteDetRendicionesAnteriores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	function ListarReporteDetRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc)
	{
		$this->salida = "";
		$dbRendicionCuenta = new cls_DBRendicionCuentas($this->decodificar);
		$res = $dbRendicionCuenta ->ListarReporteDetRendicionVerificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_doc);
		$this->salida = $dbRendicionCuenta ->salida;
		$this->query = $dbRendicionCuenta ->query;
		return $res;
	}
	
	/*******************fin rendicion de cuentas ************************/
	/* avq */
	function ListarRepSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance->ListarRepSolicitudFondos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}
	
	function ListarCheques_x_Planilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAvance = new cls_DBAvance($this->decodificar);
		$res = $dbAvance->ListarCheques_x_Planilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAvance ->salida;
		$this->query = $dbAvance ->query;
		return $res;
	}



	
		

	
	
	/// --------------------- tts_cuenta_doc --------------------- ///

	function ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function VerificarRendicionRecibo($id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->VerificarRendicionRecibo($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ContarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ContarSolicitudViaticos2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ContarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ContarDatosTesorero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function InsertarSolicitudViaticos2($id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha,$fa_solicitud,$vista,$id_caja,$id_cajero,$id_proveedor,$id_autorizacion,$nombre_cheque,$tipo_rendicion)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->InsertarSolicitudViaticos2($id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha,$fa_solicitud,$vista,$id_caja,$id_cajero,$id_proveedor,$id_autorizacion,$nombre_cheque,$tipo_rendicion);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ModificarSolicitudViaticos2($id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha,$fa_solicitud,$vista,$id_caja,$id_cajero,$accion,$id_proveedor,$importe_entregado,$id_cuenta_bancaria,$id_autorizacion,$nombre_cheque,$tipo_rendicion)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ModificarSolicitudViaticos2($id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones,$fk_id_cuenta_doc,$id_moneda,$fecha,$fa_solicitud,$vista,$id_caja,$id_cajero,$accion,$id_proveedor,$importe_entregado,$id_cuenta_bancaria,$id_autorizacion,$nombre_cheque,$tipo_rendicion);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function EliminarSolicitudViaticos2($id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc -> EliminarSolicitudViaticos2($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ValidarSolicitudViaticos2($operacion_sql,$id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ValidarSolicitudViaticos2($operacion_sql,$id_cuenta_doc,$id_depto,$id_presupuesto,$id_empleado,$id_categoria,$fecha_ini,$fecha_fin,$tipo_pago,$tipo_contrato,$id_usuario_rendicion,$motivo,$recorrido,$observaciones);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ListarCuentaDocRendicionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc ->ListarCuentaDocRendicionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ContarCuentaDocRendicionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc ->ContarCuentaDocRendicionCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function InsertarCuentaDocRendicionCab($fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$tipo_cuenta_doc,$fecha_sol,$tipo_contrato)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc ->InsertarCuentaDocRendicionCab($fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$tipo_cuenta_doc,$fecha_sol,$tipo_contrato);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ModificarCuentaDocRendicionCab($id_cuenta_doc,$fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$fecha_sol,$id_autorizacion,$tipo_contrato)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc ->ModificarCuentaDocRendicionCab($id_cuenta_doc,$fecha_ini,$fecha_fin,$observaciones,$fk_id_cuenta_doc,$fecha_sol,$id_autorizacion,$tipo_contrato);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function EliminarCuentaDocRendicionCab($id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc -> EliminarCuentaDocRendicionCab($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ValidarCuentaDocRendicionCab($operacion_sql,$id_cuenta_doc,$fecha_ini,$fecha_fin,$nro_documento,$fk_id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicionCab($this->decodificar);
		$res = $dbCuentaDoc ->ValidarCuentaDocRendicionCab($operacion_sql,$id_cuenta_doc,$fecha_ini,$fecha_fin,$nro_documento,$fk_id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function CambiarEstadoCuentaDoc($id_cuenta_doc,$accion,$id_caja,$id_cajero,$id_cuenta_bancaria,$nombre_cheque)
	{
		
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc -> CambiarEstadoCuentaDoc($id_cuenta_doc,$accion,$id_caja,$id_cajero,$id_cuenta_bancaria,$nombre_cheque);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function FinalizarRendiciones($id_cuenta_doc)
	{
		
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc -> FinalizarRendiciones($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function MarcarRendiciones2($id_cuenta_doc)
	{
		
		$this->salida = "";
		$dbCuentaDocRendicion = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDocRendicion -> MarcarRendiciones($id_cuenta_doc);
		$this->salida = $dbCuentaDocRendicion ->salida;
		$this->query = $dbCuentaDocRendicion ->query;
		return $res;
	}
	
	function ModificarDocumentoCuentaDocRendicion($id_cuenta_doc_rendicion,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_orden_trabajo,$fecha_ini,$fecha_fin,$importe_retencion){
		$this->salida = "";
		$dbCuentaDocRendicion = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDocRendicion -> ModificarDocumentoCuentaDocRendicion($id_cuenta_doc_rendicion,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$id_orden_trabajo,$fecha_ini,$fecha_fin,$importe_retencion);
		$this->salida = $dbCuentaDocRendicion ->salida;
		$this->query = $dbCuentaDocRendicion ->query;
		return $res;
	}
	
	function RegistrarDatosFinalizacion($id_cuenta_doc,$tipo_pago_fin,$id_cuenta_bancaria_fin,$id_caja_fin,$id_cajero_fin,$nro_deposito)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc -> RegistrarDatosFinalizacion($id_cuenta_doc,$tipo_pago_fin,$id_cuenta_bancaria_fin,$id_caja_fin,$id_cajero_fin,$nro_deposito);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ObtenerDatosProveedor($nit)
	{		
		$this->salida = "";
		$dbCuentaDocRendicion = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDocRendicion -> ObtenerDatosProveedor($nit);
		$this->salida = $dbCuentaDocRendicion ->salida;
		$this->query = $dbCuentaDocRendicion ->query;
		return $res;
	}
	
	function FinalizarCuentaDoc($id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc -> FinalizarCuentaDoc($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	/// --------------------- fin tts_cuenta_doc --------------------- ///
	/// --------------------- tts_cuenta_doc_det --------------------- ///

	function ListarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->ListarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function ContarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->ContarDetalleViatico($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function ListarImportesTotalesRendicionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->ListarImportesTotalesRendicionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function InsertarDetalleViatico($id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->InsertarDetalleViatico($id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function ModificarDetalleViatico($id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->ModificarDetalleViatico($id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto,$observaciones,$id_cuenta_doc_rendicion,$id_orden_trabajo,$id_solicitud,$entrega_importe,$id_categoria,$fecha_ini,$fecha_fin);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function EliminarDetalleViatico($id_cuenta_doc_det)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet -> EliminarDetalleViatico($id_cuenta_doc_det);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	function ObtenerImporteViatico($id_categoria,$id_cobertura,$id_tipo_destino,$cantidad,$fecha,$fecha_ini,$fecha_fin,$id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet -> ObtenerImporteViatico($id_categoria,$id_cobertura,$id_tipo_destino,$cantidad,$fecha,$fecha_ini,$fecha_fin,$id_cuenta_doc);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	function ValidarDetalleViatico($operacion_sql,$id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto)
	{
		$this->salida = "";
		$dbCuentaDocDet = new cls_DBCuentaDocDet($this->decodificar);
		$res = $dbCuentaDocDet ->ValidarDetalleViatico($operacion_sql,$id_cuenta_doc_det,$id_cuenta_doc,$cantidad,$tipo_transporte,$importe,$id_tipo_destino,$id_cobertura,$id_concepto_ingas,$id_presupuesto);
		$this->salida = $dbCuentaDocDet ->salida;
		$this->query = $dbCuentaDocDet ->query;
		return $res;
	}
	
	/// --------------------- fin tts_cuenta_doc_det --------------------- ///
	
	/// --------------------- tts_categoria_tipo_destino --------------------- ///

	function ListarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino ->ListarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	function ContarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino ->ContarCategoriaTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	function InsertarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino ->InsertarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	function ModificarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino ->ModificarCategoriaTipoDestino($id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	function EliminarCategoriaTipoDestino($id_categoria_tipo_destino)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino -> EliminarCategoriaTipoDestino($id_categoria_tipo_destino);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	function ValidarCategoriaTipoDestino($operacion_sql,$id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel)
	{
		$this->salida = "";
		$dbCategoriaTipoDestino = new cls_DBCategoriaTipoDestino($this->decodificar);
		$res = $dbCategoriaTipoDestino ->ValidarCategoriaTipoDestino($operacion_sql,$id_categoria_tipo_destino,$id_categoria,$id_tipo_destino,$importe_viatico,$tipo_hotel);
		$this->salida = $dbCategoriaTipoDestino ->salida;
		$this->query = $dbCategoriaTipoDestino ->query;
		return $res;
	}
	
	/// --------------------- fin tts_categoria_tipo_destino --------------------- ///
	
	/// --------------------- tts_tipo_destino --------------------- ///

	function ListarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino ->ListarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
	function ContarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino ->ContarTipoDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
function InsertarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino ->InsertarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
	function ModificarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino ->ModificarTipoDestino($id_tipo_destino,$codigo,$descripcion,$id_moneda,$tipo_destino,$estado);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
	
	function EliminarTipoDestino($id_tipo_destino)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino -> EliminarTipoDestino($id_tipo_destino);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
	function ValidarTipoDestino($operacion_sql,$id_tipo_destino,$codigo,$descripcion,$id_moneda)
	{
		$this->salida = "";
		$dbTipoDestino = new cls_DBTipoDestino($this->decodificar);
		$res = $dbTipoDestino ->ValidarTipoDestino($operacion_sql,$id_tipo_destino,$codigo,$descripcion,$id_moneda);
		$this->salida = $dbTipoDestino ->salida;
		$this->query = $dbTipoDestino ->query;
		return $res;
	}
	
	/// --------------------- fin tts_tipo_destino --------------------- ///
	
	/// --------------------- tts_cuenta_doc_rendicion --------------------- ///
	function ListarCuentaDocRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDoc ->ListarCuentaDocRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ContarCuentaDocRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDoc ->ContarCuentaDocRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarImportesTotalesRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDocRendicion($this->decodificar);
		$res = $dbCuentaDoc ->ListarImportesTotalesRendicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	///	 --------------------- fin tts_cuenta_doc_rendicion --------------------- ///
	
	function ListarSolicitudViajes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarSolicitudViajes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ListarSolicitudViajesDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarSolicitudViajesDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ListarSolicitudFondosCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarSolicitudFondosCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarReciboProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarReciboProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarCabeceraRendicionPagoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarCabeceraRendicionPagoCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	
	function ListarDetalleRendicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarDetalleRendicionCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarReciboCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarReciboCaja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ListarRendicionProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarRendicionProvisionalFondosEfectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	//ListarReciboProvisionalDetalle
	function ListarReciboProvisionalDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarReciboProvisionalDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	//// ------------------------- adm_cheque ---------------------------------------------///
	//RCM: 09/10/2009
	function ListarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db=new cls_DBAdmCheque($this->decodificar);
		$res = $db->ListarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db->salida;
		$this->query = $db->query;
		return $res;
	}
	
	//RCM: 09/10/2009
	function ContarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBAdmCheque($this->decodificar);
		$res = $db ->ContarAdmCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	//RCM: 10/10/2009
	function FinImpresionCheque($tipo,$tipo_especifico,$id){
		$this->salida = "";
		$db = new cls_DBAdmCheque($this->decodificar);
		$res = $db -> FinImpresionCheque($tipo,$tipo_especifico,$id);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	//// ------------------------- fin adm_cheque -----------------------------------------///
	
	/// --------------------- dev_pasaje --------------------- ///
	///*
	function ListarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje ->ListarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		
		return $res;
	}
	
	function ContarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje ->ContarDevPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function InsertarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje ->InsertarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function ModificarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje ->ModificarDevPasaje($id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function EliminarDevPasaje($id_cuenta_doc_det)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje -> EliminarDevPasaje($id_cuenta_doc_det);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function SelectDevPasaje($id_cuenta_doc_det,$sw_select)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje -> SelectDevPasaje($id_cuenta_doc_det,$sw_select);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function ProceDevPasaje($id_depto)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje -> ProceDevPasaje($id_depto);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	
	function ValidarDevPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$dbDevPasaje = new cls_DBDevPasaje($this->decodificar);
		$res = $dbDevPasaje ->ValidarDevPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones);
		$this->salida = $dbDevPasaje ->salida;
		$this->query = $dbDevPasaje ->query;
		return $res;
	}
	//*/
	/// --------------------- fin dev_pasaje --------------------- ///
	
	/// --------------------- via_pasaje --------------------- ///
	function ListarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaPasaje = new cls_DBViaPasaje($this->decodificar);
		$res = $dbViaPasaje ->ListarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaPasaje ->salida;
		$this->query = $dbViaPasaje ->query;
		return $res;
	}
	
	function ContarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbViaPasaje = new cls_DBViaPasaje($this->decodificar);
		$res = $dbViaPasaje ->ContarViaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbViaPasaje ->salida;
		$this->query = $dbViaPasaje ->query;
		return $res;
	}
	
	function ModificarViaPasaje($id_cuenta_doc_det,$importe_confirma,$nota_debito,$pasaje_utilizado,$pasaje_nro,$pasaje_fecha,$id_presupuesto,$tipo,$pasaje_credito,$pasaje_cobar,$pasaje_orden)
	{
		$this->salida = "";
		$dbViaPasaje = new cls_DBViaPasaje($this->decodificar);
		$res = $dbViaPasaje ->ModificarViaPasaje($id_cuenta_doc_det,$importe_confirma,$nota_debito,$pasaje_utilizado,$pasaje_nro,$pasaje_fecha,$id_presupuesto,$tipo,$pasaje_credito,$pasaje_cobar,$pasaje_orden);
		$this->salida = $dbViaPasaje ->salida;
		$this->query = $dbViaPasaje ->query;
		return $res;
	}
	
	
	function ValidarViaPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones)
	{
		$this->salida = "";
		$dbViaPasaje = new cls_DBViaPasaje($this->decodificar);
		$res = $dbViaPasaje ->ValidarViaPasaje($operacion_sql,$id_cuenta_doc_det,$id_presupuesto,$sw_select,$desc_presupuesto,$fecha_ini,$importe,$observaciones);
		$this->salida = $dbViaPasaje ->salida;
		$this->query = $dbViaPasaje ->query;
		return $res;
	}
	/// --------------------- fin via_pasaje --------------------- ///
	
	
	
	
	/// --------------------- tts_devengado_concepto --------------------- ///

	function ListarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto ->ListarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}
	
	function ContarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto ->ContarDevengadoConcepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}
	
	function InsertarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto ->InsertarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}
	
	function ModificarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto ->ModificarDevengadoConcepto($id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}
	
	function EliminarDevengadoConcepto($id_devengado_concepto)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto -> EliminarDevengadoConcepto($id_devengado_concepto);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}
	
	function ValidarDevengadoConcepto($operacion_sql,$id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe)
	{
		$this->salida = "";
		$dbDevengadoConcepto = new cls_DBDevengadoConcepto($this->decodificar);
		$res = $dbDevengadoConcepto ->ValidarDevengadoConcepto($operacion_sql,$id_devengado_concepto,$id_devengado,$id_concepto_ingas,$descripcion,$importe);
		$this->salida = $dbDevengadoConcepto ->salida;
		$this->query = $dbDevengadoConcepto ->query;
		return $res;
	}	
	/// --------------------- Fin tts_devengado_concepto --------------------- ///
	
	//-----------estado_
	function ListarReporteEstadoSolicitudes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_solicitud,$fecha_ini,$fecha_fin,$tipo_solicitud)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarReporteEstadoSolicitudes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_solicitud,$fecha_ini,$fecha_fin,$tipo_solicitud);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarReporteEstadoRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_rendicion,$fecha_ini,$fecha_fin,$tipo_solicitud)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarReporteEstadoRendiciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$estado_rendicion,$fecha_ini,$fecha_fin,$tipo_solicitud);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarReporteEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarReporteEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarReporteEstadoCuentaExcel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarReporteEstadoCuentaExcel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_depto,$id_empleado,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarEmpleadosDepartamento($id_depto,$fecha_desde,$fecha_hasta,$estado)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarEmpleadosDepartamento($id_depto,$fecha_desde,$fecha_hasta,$estado);
		$this->salida = $dbParametro->salida;
		$this->query = $dbParametro->query;
		return $res;
	}
	
	///Rendicion documento 
	function ListarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ListarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function ContarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->ContarDetalleRendicionDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function CorregirRecibo($id_cuenta_doc)
	{
		$this->salida = "";
		$dbCuentaDoc = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbCuentaDoc ->CorregirRecibo($id_cuenta_doc);
		$this->salida = $dbCuentaDoc ->salida;
		$this->query = $dbCuentaDoc ->query;
		return $res;
	}
	function RepReciboPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRepReciboPago = new cls_DBRepReciboPago($this->decodificar);
		$res = $dbRepReciboPago ->RepReciboPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRepReciboPago ->salida;
		$this->query = $dbRepReciboPago ->query;
		return $res;
	}
	function RepReciboPagoMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRepReciboPago = new cls_DBRepReciboPago($this->decodificar);
		$res = $dbRepReciboPago ->RepReciboPagoMes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRepReciboPago ->salida;
		$this->query = $dbRepReciboPago ->query;
		return $res;
	}
	function RepReciboPagoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRepReciboPago = new cls_DBRepReciboPago($this->decodificar);
		$res = $dbRepReciboPago ->RepReciboPagoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRepReciboPago ->salida;
		$this->query = $dbRepReciboPago ->query;
		return $res;
	}
	/*Añadido por AVQ.
	 * Para estados de soliditudes en efectivo
	 *  */
	
	function ListarRepEstSolicitudEfectivos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado)
	{
		$this->salida = "";
		$dbParametro = new cls_DBEstadoRendiciones($this->decodificar);
		$res = $dbParametro ->ListarRepEstSolicitudEfectivos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista,$estado);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarSolicitudAutorizar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado)
	{
		$this->salida = "";
		$dbParametro = new cls_DBCuentaDoc($this->decodificar);
		$res = $dbParametro ->ListarSolicitudAutorizar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad,$tipo_cuenta_doc,$estado);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function RepFondoRotatorio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_caja,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$dbRepSolicitudEfectivo = new cls_DBRepSolicitudEfectivo($this->decodificar);
		$res = $dbRepSolicitudEfectivo ->RepFondoRotatorio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_caja,$fecha_inicio,$fecha_fin);
		$this->salida = $dbRepSolicitudEfectivo ->salida;
		$this->query = $dbRepSolicitudEfectivo ->query;
		return $res;
	}
	function RepImpViaticoo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$dbRepSolicitudEfectivo = new cls_DBRepSolicitudEfectivo($this->decodificar);
		$res = $dbRepSolicitudEfectivo ->RepImpViaticoo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin);
		$this->salida = $dbRepSolicitudEfectivo ->salida;
		$this->query = $dbRepSolicitudEfectivo ->query;
		return $res;
	}
	function RepImpViaticoDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$dbRepSolicitudEfectivo = new cls_DBRepSolicitudEfectivo($this->decodificar);
		$res = $dbRepSolicitudEfectivo ->RepImpViaticoDias($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_empleado,$fecha_inicio,$fecha_fin);
		$this->salida = $dbRepSolicitudEfectivo ->salida;
		$this->query = $dbRepSolicitudEfectivo ->query;
		return $res;
	}
}
