<?php
/**
 * Nombre de la Clase:	    CustomDBContabilidad
 * Propï¿½sito:				Interfaz del modelo del Sistema de Contabilidad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creaciï¿½n:		02-10-2007
 * Autor:					Josï¿½ A. Mita Huanca
 *
 */
class cls_CustomDBcontabilidad
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{	
		include_once("cls_DBCuenta.php");
		include_once("cls_DBCuentaArb.php");
		include_once("cls_DBNivelCuenta.php");
		include_once("cls_DBParametro.php");
		include_once("cls_DBAuxiliar.php");
    	include_once("cls_DBCuentaAuxiliar.php");
        include_once("cls_DBOrdenTrabajo.php");
        include_once("cls_DBDocumento.php");
		include_once("cls_DBTransaccion.php");
		include_once("cls_DBComprobante.php");
		include_once("cls_DBCbteClase.php");
		include_once("cls_DBPeriodoSubsistema.php");
		include_once("cls_DBPeriodo.php");
		include_once("cls_DBGestionSubsistema.php");
		include_once("cls_DBGestion.php");
		include_once("cls_DBReporteEeff.php");
		include_once("cls_DBRubro.php");
		include_once("cls_DBRubroCuenta.php");
		include_once("cls_DBCuentaEjercicio.php");
		include_once("cls_DBCheque.php");
		include_once("cls_DBAjusteAct.php");
		include_once("cls_DBEstadoCuenta.php");
		include_once("cls_DBUsuarioAutorizado.php");
		include_once("cls_DBPlantillaCalculo.php");
		include_once("cls_DBPlantilla.php");
		include_once("cls_DBlListarEEFF.php");
  		include_once("cls_DBENDESIS.php");
  		include_once("cls_DBRepDocumentos.php");
  		include_once("cls_DBLibroMayor.php");
  		include_once("cls_DBRepBalanceSS.php");
  		include_once("cls_DBPlanilla.php");
  		include_once("cls_DBConsultores.php");
  		include_once("cls_DBSigma.php");
  		include_once("cls_DBActualizacion.php");
  		include_once("cls_DBActualizacionDetalle.php");
  		include_once("cls_DBTransaccionActualizacion.php");
  		include_once ("cls_DBTransaccionValor.php");
  		include_once ("cls_DBDocCbteUsuario.php");
  		//williams Escobar
  		include_once ("cls_DBXlsCsv.php");
  		
  		include_once ("cls_DBCierreApertura.php");
  		include_once ("cls_DBRepConsEjec.php");
  		// - JMH -
		include_once("cls_DBArchivoControlGral.php");
		include_once("cls_DBDetalleBeneficiarioGral.php");
		include_once("cls_DBDetalleBeneficiario.php");
		
		include_once("cls_DBCuentaBancariz.php");
		include_once("cls_DBPlantillaBancariz.php");
	  	include_once("cls_DBPlantillaRel.php");	
	  	include_once("cls_DBBancarizacion.php");
	  	include_once("cls_DBBancarizacionDet.php");
	  	include_once("cls_DBRepCierreContable.php");
		include_once("cls_DBEeffCompara.php");
		include_once("cls_DBActualizarLibros.php");
		include_once("cls_DBCuentaSigma.php");
		include_once("cls_DBGestionFirma.php");
	}
	
	function TTSIntegracionRendicionCaja($id_caja,$id_caja_aux,$id_caja_auxiliar)
	{
		$this->salida = "";
		$dbendesis = new cls_DBENDESIS($this->decodificar);
		$res = $dbendesis ->TTSIntegracionRendicionCaja($id_caja,$id_caja_aux,$id_caja_auxiliar);
		$this->salida = $dbendesis->salida;
		$this->query = $dbendesis->query;
		return $res;
	}
	/// --------------------- tct_plantilla --------------------- ///

	
	/// --------------------- tct_plantilla --------------------- ///

	function ListarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ListarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ContarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ContarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function InsertarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->InsertarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ModificarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ModificarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function EliminarPlantilla($id_plantilla)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla -> EliminarPlantilla($id_plantilla);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ValidarPlantilla($operacion_sql,$id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ValidarPlantilla($operacion_sql,$id_plantilla,$tipo_plantilla,$nro_linea,$desc_plantilla,$tipo,$sw_tesoro,$sw_compro);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function CalculaSujetoLiquido($importe,$tipo_documento,$sw_sujeto_liquido)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->CalculaSujetoLiquido($importe,$tipo_documento,$sw_sujeto_liquido);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	/// --------------------- fin tct_plantilla --------------------- ///
	
	function listarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$fecha_inicial,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->listarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$fecha_inicial,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ContarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$fecha_inicial,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->ContarEEFFConsolidado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$fecha_inicial,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ListarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->ListarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ContarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->ContarEEFFPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function ContarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini,$sw_transaccional)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->ContarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini,$sw_transaccional);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function listarEEFFCuentaResultado($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->listarEEFFCuentaResultado($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	function listarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini,$sw_transaccional)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->listarEEFFCuenta($ct_id_parametro,$ct_id_moneda,$ct_ids_fuente_financiamiento,$ct_ids_u_o,$ct_ids_financiador,$ct_ids_regional,$ct_ids_programa,$ct_ids_proyecto,$ct_ids_actividad,$ct_fecha_eeff,$ct_nivel,$ct_id_cuenta,$pm_id_usuario, $id_depto,$id_rubro,$ct_fecha_eeff_ini,$sw_transaccional);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ListarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->ListarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->ContarEEFFBG($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_reporte_eeff,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$fecha_eeff,$nivel,$id_depto, $fecha_eeff_ini,$sw_actualizacion);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//---JMH
	function ListarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->ListarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ContarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbAuxiliar ->ContarSaldosBancariosPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_reporte_eeff,$ct_id_parametro,$ct_nivel,$id_periodos,$sw_transaccional);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query; 
		return $res;
	}
	//-- fin JMH
	
	/// --------------------- tct_plantilla_calculo --------------------- ///

	function ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ContarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ContarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function InsertarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion,$id_gestion)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->InsertarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion,$id_gestion);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ModificarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion,$id_gestion)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ModificarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$campo_doc,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion,$id_gestion);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function EliminarPlantillaCalculo($id_plantilla_calculo)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo -> EliminarPlantillaCalculo($id_plantilla_calculo);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ValidarPlantillaCalculo($operacion_sql,$id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ValidarPlantillaCalculo($operacion_sql,$id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo,$sw_porcentaje,$sw_rendicion,$sw_contabilizacion);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	} 
	
	/// --------------------- fin tct_plantilla_calculo --------------------- ///
	
	/// --------------------- tct_usuario_autorizado --------------------- ///

	function ListarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ListarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ContarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ContarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function InsertarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->InsertarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ModificarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ModificarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function EliminarAutorizacion($id_usuario_autorizado)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado -> EliminarAutorizacion($id_usuario_autorizado);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ValidarAutorizacion($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ValidarAutorizacion($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	/// --------------------- fin tct_usuario_autorizado --------------------- ///	

 
	
	/// --------------------- tct_cuenta_ejercicio --------------------- ///

	function ListarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ListarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ContarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ContarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function InsertarCuentaEjecricio($id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->InsertarCuentaEjecricio($id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ModificarCuentaEjecricio($id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ModificarCuentaEjecricio($id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function EliminarCuentaEjecricio($id_ejercicio)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio -> EliminarCuentaEjecricio($id_ejercicio);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ValidarCuentaEjecricio($operacion_sql,$id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ValidarCuentaEjecricio($operacion_sql,$id_ejercicio,$id_partida_cuenta,$tipo_ejercicio,$desc_ejercicio,$id_gestion,$id_auxiliar);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cuenta_ejercicio --------------------- ///

 	/// --------------------- tct_parametro --------------------- ///

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
	
	function InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_moneda,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional);
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
	
	function MigrarParametro($id_parametro)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> MigrarParametro($id_parametro);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ActualParametro($id_parametro)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> ActualParametro($id_parametro);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	/// --------------------- fin tct_parametro --------------------- ///	
	/// --------------------- tct_nivel_cuenta --------------------- ///

	function ListarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ListarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ContarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ContarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function InsertarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->InsertarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ModificarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ModificarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function EliminarNivelCuenta($id_nivel_cuenta)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta -> EliminarNivelCuenta($id_nivel_cuenta);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ValidarNivelCuenta($operacion_sql,$id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ValidarNivelCuenta($operacion_sql,$id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_nivel_cuenta --------------------- ///


	
	/// --------------------- tct_rubro_cuenta --------------------- ///

	function ListarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ListarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ContarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ContarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function InsertarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->InsertarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ModificarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ModificarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function EliminarRubroCuenta($id_rubro_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta -> EliminarRubroCuenta($id_rubro_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ValidarRubroCuenta($operacion_sql,$id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ValidarRubroCuenta($operacion_sql,$id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_rubro_cuenta --------------------- ///
	
	/// --------------------- tct_rubro --------------------- ///

	function ListarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ListarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ContarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ContarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function InsertarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->InsertarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ModificarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ModificarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function EliminarRubro($id_rubro)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro -> EliminarRubro($id_rubro);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ValidarRubro($operacion_sql,$id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ValidarRubro($operacion_sql,$id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber,$sw_arbol_cuenta);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	/// --------------------- fin tct_rubro --------------------- ///
	
	/// --------------------- tct_reporte_eeff --------------------- ///

	function ListarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ListarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ContarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ContarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function InsertarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->InsertarEeff($id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ModificarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ModificarEeff($id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function EliminarEeff($id_reporte_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff -> EliminarEeff($id_reporte_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ValidarEeff($operacion_sql,$id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ValidarEeff($operacion_sql,$id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	/// --------------------- fin tct_reporte_eeff --------------------- ///


/// --------------------- tct_periodo_subsistema --------------------- ///

	function ListarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ListarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ContarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ContarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function abrirCerrarPeriodoSubsistema($id_periodo_subsistema, $accion)
	{ 
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->abrirCerrarPeriodoSubsistema($id_periodo_subsistema, $accion);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}	
	function InsertarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->InsertarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ModificarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ModificarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function EliminarPeriodoSubsistema($id_periodo_subsistema)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema -> EliminarPeriodoSubsistema($id_periodo_subsistema);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ValidarPeriodoSubsistema($operacion_sql,$id_periodo_subsistema,$id_periodo,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ValidarPeriodoSubsistema($operacion_sql,$id_periodo_subsistema,$id_periodo,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ListarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ListarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ContarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ContarPeriodoGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	/// --------------------- fin tct_periodo_subsistema --------------------- ///
/// --------------------- tct_periodo --------------------- ///

	function ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function  CerrarPeriodo($id_gestion)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo -> CerrarPeriodo($id_gestion);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function  AbrirPeriodo($id_gestion)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo -> AbrirPeriodo($id_gestion);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ModificarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ModificarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function EliminarPeriodo($id_periodo)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo -> EliminarPeriodo($id_periodo);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ValidarPeriodo($operacion_sql,$id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ValidarPeriodo($operacion_sql,$id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	/// --------------------- fin tct_periodo --------------------- ///

	/// --------------------- tct_gestion_subsistema --------------------- ///
	function ListarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ListarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ContarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ContarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function InsertarGestionSubsistema($id_gestion_subsistema,$id_gestion,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->InsertarGestionSubsistema($id_gestion_subsistema,$id_gestion,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ModificarGestionSubsistema($id_gestion_subsistema,$id_gestion,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ModificarGestionSubsistema($id_gestion_subsistema,$id_gestion,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function EliminarGestionSubsistema($id_gestion_subsistema)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema -> EliminarGestionSubsistema($id_gestion_subsistema);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ValidarGestionSubsistema($operacion_sql,$id_gestion_subsistema,$id_gestion,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ValidarGestionSubsistema($operacion_sql,$id_gestion_subsistema,$id_gestion,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	/// --------------------- tct_gestion --------------------- ///
	function ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ContarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ContarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function InsertarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->InsertarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ModificarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ModificarGestion($id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function EliminarGestion($id_gestion)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion -> EliminarGestion($id_gestion);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ValidarGestion($operacion_sql,$id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ValidarGestion($operacion_sql,$id_gestion,$gestion,$estado_ges_gral,$id_empresa,$id_moneda_base,$estado_vigente);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
 
	
	/// --------------------- tct_cbte_clase --------------------- ///

	function ListarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ListarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ContarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ContarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function InsertarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->InsertarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ModificarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ModificarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function EliminarCbteClase($id_clase_cbte)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase -> EliminarCbteClase($id_clase_cbte);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ValidarCbteClase($operacion_sql,$id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ValidarCbteClase($operacion_sql,$id_clase_cbte,$desc_clase,$estado_clase,$id_documento,$titulo_cbte);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cbte_clase --------------------- ///
	 
	/// --------------------- tct_transaccion --------------------- ///
	function ListarGestionarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ListarGestionarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function MaxTCListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->MaxTCListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ContarRegistroTransacionAnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ContarRegistroTransacionAnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ListarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ListarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ContarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ContarTransaccionLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function InsertarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans,$importe_ejecucion )
	{
		
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->InsertarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans,$importe_ejecucion );
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ModificarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans ,$importe_ejecucion)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->ModificarRegistroTransacion($id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans ,$importe_ejecucion);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function InsertarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso){
		
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->InsertarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ModificarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->ModificarGestionarRegistroTransacion($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function EliminarRegistroTransacion($id_transaccion)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion -> EliminarRegistroTransacion($id_transaccion);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ValidarRegistroTransacion($operacion_sql,$id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans )
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ValidarRegistroTransacion($operacion_sql,$id_transaccion , $id_auxiliar , $id_comprobante , $id_cuenta , 
			$id_fuente_financiamiento , $id_moneda , $id_oec , $id_orden_trabajo , $id_partida , $id_plantilla  , $id_unidad_organizacional , 
			$importe_debe , $importe_haber , $tipo_Cambio , $tipo_cambio_origen , 
			$id_fina_regi_prog_proy_acti , $concepto_tran , $fecha_trans );
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ReporteLibroDiarioTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ReporteLibroDiarioTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ReporteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ReporteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
		{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	function ContarReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBTransaccion($this->decodificar);
		$res = $dbComprobante ->ContarReporteLibroMayorDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
	    $this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function ReporteLibroMayorDetalleAuxiliares($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
		{
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->ReporteLibroMayorDetalleAuxiliares($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
	
		$this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	function ReporteLibroMayorOT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
		{
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->ReporteLibroMayorOT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio,$fecha_fin,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
	
		$this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	
	//05082016
	function ReplicarRegistroTransacion($id_transaccion ,$cantidad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->ReplicarRegistroTransacion($id_transaccion ,$cantidad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	//oct2016
	function ModificarGestionarRegistroTransacionFE($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion->ModificarGestionarRegistroTransacionFE($id_transaccion,$concepto_tran,$id_auxiliar ,$id_comprobante,$id_oec,$id_orden_trabajo,$id_partida,$id_cuenta,$id_presupuesto,$importe_debe,$importe_haber,$importe_gasto,$importe_recurso);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	/// --------------------- fin tct_transaccion --------------------- ///

	
	/// --------------------- tct_comprobante --------------------- ///

	function ListarComprobanteTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ListarComprobanteTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}	function ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ContarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ContarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function GestionarAccionesComprobante($accion,$id_comprobante)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->GestionarAccionesComprobante($accion,$id_comprobante);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;  
		return $res;
	}
	function InsertarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,$fk_comprobante,$tipo_relacion,$sw_activo_fijo)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->InsertarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,$fk_comprobante,$tipo_relacion,$sw_activo_fijo);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ModificarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,	$fk_comprobante,$tipo_relacion,$sw_activo_fijo)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ModificarGestionarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto,$id_moneda_cbte,$tipo_cambio,	$fk_comprobante,$tipo_relacion,$sw_activo_fijo);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function InsertarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->InsertarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ModificarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ModificarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function EliminarRegistroComprobante($id_comprobante,$observacion)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante -> EliminarRegistroComprobante($id_comprobante,$observacion);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ValidarRegistroComprobante($operacion_sql,$id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ValidarRegistroComprobante($operacion_sql,$id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_usuario,$id_subsistema,$id_clase_cbte,$sw_validacion,$id_depto);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function ReporteLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ReporteLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function ContarLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ContarLibroDiarioComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ReporteComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ReporteComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ReporteLibroMayor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ReporteLibroMayor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ListarDatosComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante  = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante  ->ListarDatosComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante  ->salida;
		$this->query = $dbComprobante  ->query;
		return $res;
	}

	function ReporteLibroMayorPorAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_auxiliar, $id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ReporteLibroMayorPorAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$fecha_inicio_b,$fecha_fin_b,$id_auxiliar,$id_depto,$cuenta_ini,$cuenta_fin,$por_rango,$id_gestion);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ListarVariosCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ListarVariosCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}

	function DetalleCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$id_deptos,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->DetalleCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$id_deptos,$fecha_ini,$fecha_fin);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	
	//octubre2016
	function MarcarCbteFE($id_comprobante,$accion)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->MarcarCbteFE($id_comprobante,$accion);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	/// --------------------- fin tct_comprobante --------------------- ///
	
	
	/// --------------------- tct_documento --------------------- ///
	function ListarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	/////////////////////////////------DOCUMENTO IVA-------///////////////////////////////////////////////////////////
	function ActionListarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla)
		{
			$this->salida = "";
			$dbDocumento = new cls_DBDocumento($this->decodificar);
			$res = $dbDocumento ->ActionListarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla);
			$this->salida = $dbDocumento ->salida;
			$this->query = $dbDocumento ->query;
			return $res;
		}
	function  ContarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla)
	{
		$this->salida = "";
			$dbDocumento = new cls_DBDocumento($this->decodificar);
			$res = $dbDocumento ->ContarDocumentoRespaldo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_departamento,$id_gestion,$id_periodo,$id_moneda,$fecha_ini,$fecha_fin,$id_plantilla);
			$this->salida = $dbDocumento ->salida;
			$this->query = $dbDocumento ->query;
			return $res;
	}
	
	function ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ListarDocumentoReten($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_retencion,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumentoReten($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_retencion,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarDocumentoIva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ListarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ListarDocumentoRetenTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_retencion,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumentoRetenTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_retencion,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarDocumentoIvaTotal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ListarDocumentoImporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumentoImporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	///////////////////////////////------FIN DOC IVA-------///////////////////////////////////////////////////////
	function ListarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarDocsNit($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ListarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarDocsNitDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	///------FIN DOC NIT-------//
	
	function InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento
			//2016
			,$importe_descuento,$importe_exportaciones,$importe_ventas_gravadas_tasa_0
			,$ndc_fecha_documento_orig,$ndc_nro_autorizacion_factura_orig,$ndc_nro_documento_orig,$ndc_importe_total_orig
			)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento
				//2016
				,$importe_descuento,$importe_exportaciones,$importe_ventas_gravadas_tasa_0
				,$ndc_fecha_documento_orig,$ndc_nro_autorizacion_factura_orig,$ndc_nro_documento_orig,$ndc_importe_total_orig
				);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	function InsertarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo,$fecha_ini,$fecha_fin,$sw_viatico,$id_tipo_destino,$id_cobertura)
    {
    	$this->salida = "";
        $dbDocumento = new cls_DBDocumento($this->decodificar);
        $res = $dbDocumento ->InsertarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo,$fecha_ini,$fecha_fin,$sw_viatico,$id_tipo_destino,$id_cobertura);
        $this->salida = $dbDocumento ->salida;
        $this->query = $dbDocumento ->query;
        return $res;
    }
    function ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento
    		//2016
    		,$importe_descuento,$importe_exportaciones,$importe_ventas_gravadas_tasa_0
    		,$ndc_fecha_documento_orig,$ndc_nro_autorizacion_factura_orig,$ndc_nro_documento_orig,$ndc_importe_total_orig
    		)
    {
        $this->salida = "";
        $dbDocumento = new cls_DBDocumento($this->decodificar);
        $res = $dbDocumento ->ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion,$id_moneda,$importe_credito,$importe_debito,$importe_ice,$importe_it,$importe_iue,$importe_sujeto,$importe_total,$importe_no_gravado,$estado_documento
        		//2016
        		,$importe_descuento,$importe_exportaciones,$importe_ventas_gravadas_tasa_0
        		,$ndc_fecha_documento_orig,$ndc_nro_autorizacion_factura_orig,$ndc_nro_documento_orig,$ndc_importe_total_orig
        		);
        $this->salida = $dbDocumento ->salida;
        $this->query = $dbDocumento ->query;
        return $res;
    }
	function ModificarCabeceraDocumento($id_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui)
    {
        $this->salida = "";
        $dbDocumento = new cls_DBDocumento($this->decodificar);
        $res = $dbDocumento ->ModificarCabeceraDocumento($id_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui);
        $this->salida = $dbDocumento ->salida;
        $this->query = $dbDocumento ->query;
        return $res;
    }
    function ModificarDocsNit($id_documento,$nro_nit,$razon_social,$sw_lcv)
    {
    	$this->salida = "";
    	$dbDocumento = new cls_DBDocumento($this->decodificar);
    	$res = $dbDocumento ->ModificarDocsNit($id_documento,$nro_nit,$razon_social,$sw_lcv);
    	$this->salida = $dbDocumento ->salida;
    	$this->query = $dbDocumento ->query;
    	return $res;
    }
	function EliminarRegistroDocumento($id_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento -> EliminarRegistroDocumento($id_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ValidarRegistroDocumento($operacion_sql,$id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ValidarRegistroDocumento($operacion_sql,$id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	//RCM: 16/02/2009
	function EliminarDocumento($id_documento,$nombre_tabla,$nombre_campo,$id_tabla)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->EliminarDocumento($id_documento,$nombre_tabla,$nombre_campo,$id_tabla);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	//RCM: 18/02/2009
	function ModificarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ModificarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento,$id_plan_pago,$id_presupuesto,$id_concepto_ingas,$id_orden_trabajo);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	//RCM:22/05/2009
	function ValidarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ValidarDocumento($id_documento,$tipo_documento,$id_moneda,$importe_avance,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$nombre_tabla,$nombre_campo,$id_tabla,$importe_ice,$importe_exento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	/// --------------------- fin tct_documento --------------------- ///
	
	
	/// --------------------- tct_cuenta --------------------- ///

	function ListarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	function ListarPartidaCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarPartidaCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarPartidaCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarPartidaCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	function ListarCuentaAuxiliarSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuentaAuxiliarSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuentaAuxiliarSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuentaAuxiliarSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	
	
	function ListarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	
	function ListarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function InsertarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->InsertarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ModificarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ModificarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function EliminarCuenta($id_cuenta)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta -> EliminarCuenta($id_cuenta);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ValidarCuenta($operacion_sql,$id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ValidarCuenta($operacion_sql,$id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function RepCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->RepCuentas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cuenta --------------------- ///
   /// --------------------- tct_cuenta_arb --------------------- ///
   function ListarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ListarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ListarCuentaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ListarCuentaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ContarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ContarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function InsertarCuentaRaiz($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,$id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->InsertarCuentaRaiz($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,$id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
function InsertarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,
			                   $id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,
			                   $id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma,$id_partida_flu_debe,$id_partida_flu_haber,$sw_caif,$sw_siet)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->InsertarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,
			                   $id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,$cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,
			                   $id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,$nota_eeff,$id_cuenta_sigma,$id_partida_flu_debe,$id_partida_flu_haber,$sw_caif,$sw_siet);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ModificarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda,$sw_oec,$sw_aux,
			                    $cuenta_sigma,$sw_sigma,$id_cuenta_actualizacion,$id_auxiliar_actualizacion,$sw_sistema_actualizacion,$id_cuenta_dif,$id_auxiliar_dif,$cuenta_flujo_sigma,
			                    $nota_eeff,$id_cuenta_sigma,$id_partida_flu_debe,$id_partida_flu_haber,$sw_caif,$sw_siet)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ModificarCuentaArb($id_cuenta, $nro_cuenta, $nombre_cuenta, $desc_cuenta, $nivel_cuenta, $tipo_cuenta, $sw_transaccional, $id_cuenta_padre, $id_parametro, $id_moneda, $sw_oec, $sw_aux, $cuenta_sigma, $sw_sigma, $id_cuenta_actualizacion, $id_auxiliar_actualizacion, $sw_sistema_actualizacion, $id_cuenta_dif, $id_auxiliar_dif, $cuenta_flujo_sigma, $nota_eeff, $id_cuenta_sigma, $id_partida_flu_debe, $id_partida_flu_haber, $sw_caif, $sw_siet);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function EliminarCuentaArb($id_cuenta,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->EliminarCuentaArb($id_cuenta,$id_cuenta_padre);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}				
	function EliminarCuentaRaiz($id_cuenta)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->EliminarCuentaRaiz($id_cuenta);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	/// --------------------- fin tct_cuenta_arb --------------------- ///
	
	/// --------------------- tct_auxiliar --------------------- ///

	function ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}	
	function InsertarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->InsertarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function ModificarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ModificarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function EliminarAuxiliar($id_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar -> EliminarAuxiliar($id_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function ValidarAuxiliar($operacion_sql,$id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ValidarAuxiliar($operacion_sql,$id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}	
	function ReporteCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ReporteCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	/// --------------------- fin tct_auxiliar --------------------- ///
	
	/// --------------------- tct_cuenta_auxiliar --------------------- ///
	function ListarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ListarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	function ContarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ContarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}	
	function InsertarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->InsertarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function ModificarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ModificarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function EliminarCuentaAuxiliar($id_cuenta_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar -> EliminarCuentaAuxiliar($id_cuenta_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function ValidarCuentaAuxiliar($operacion_sql,$id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ValidarCuentaAuxiliar($operacion_sql,$id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}	
	/// --------------------- fin tct_cuenta_auxiliar --------------------- ///	
	
	/// --------------------- tct_cuenta_sigma --------------------- ///
	
	function ListarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma ->ListarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	function ContarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma ->ContarCuentaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	function InsertarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma ->InsertarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	
	function ModificarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma ->ModificarCuentaSigma($id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	
	function EliminarCuentaSigma($id_cuenta_sigma)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma -> EliminarCuentaSigma($id_cuenta_sigma);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	
	function ValidarCuentaSigma($operacion_sql,$id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma)
	{
		$this->salida = "";
		$dbCuentaSigma = new cls_DBCuentaSigma($this->decodificar);
		$res = $dbCuentaSigma ->ValidarCuentaSigma($operacion_sql,$id_cuenta_sigma,$nro_cuenta_sigma,$nombre_cuenta_sigma,$estado_cuenta_sigma);
		$this->salida = $dbCuentaSigma ->salida;
		$this->query = $dbCuentaSigma ->query;
		return $res;
	}
	/// --------------------- fin tct_cuenta_sigma --------------------- ///
	
	/// --------------------- tct_orden_trabajo --------------------- ///
	function ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
function InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa,$id_depto)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa,$id_depto);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa,$id_depto)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa,$id_depto);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function EliminarOrdenTrabajo($id_orden_trabajo)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo -> EliminarOrdenTrabajo($id_orden_trabajo);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ValidarOrdenTrabajo($operacion_sql,$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ValidarOrdenTrabajo($operacion_sql,$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario,$fecha_activa);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	/// --------------------- tct_cheque --------------------- ///
	
	function ListarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ContarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarChequeCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ModificarChequeAnula($id_cheque,$estado_cheque,$nombre_cheque,$observaciones_anulacion,$tipo_cheque,$id_cuenta_bancaria,$nro_cheque,$fecha,$nro_doc)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ModificarChequeAnula($id_cheque,$estado_cheque,$nombre_cheque,$observaciones_anulacion,$tipo_cheque,$id_cuenta_bancaria,$nro_cheque,$fecha,$nro_doc);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ListarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ContarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarCheque($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	function ListarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ContarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarLibretaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ListarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ContarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarLibretaBancariaAnulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta_bancaria,$id_moneda,$fecha_inicio,$fecha_fin,$m_sw_actualizacion);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function InsertarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->InsertarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	function ModificarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion,$estado_cheque)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ModificarChequeRegTra($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria,$tipo_cheque,$id_moneda,$importe_cheque,$tipo_cambio,$nro_transaccion,$estado_cheque);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ModificarCheque($id_cheque,$estado_cheque,$fecha_cobro,$nro_cheque,$fecha_cheque,$nombre_cheque)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ModificarCheque($id_cheque,$estado_cheque,$fecha_cobro,$nro_cheque,$fecha_cheque,$nombre_cheque);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
 
	function InsertarCheque($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria,$nombre_tabla,$nombre_campo,$id_tabla,$id_moneda,$importe_cheque,$cambio_estado,$tipo_cheque)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->InsertarCheque($id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria,$nombre_tabla,$nombre_campo,$id_tabla,$id_moneda,$importe_cheque,$cambio_estado,$tipo_cheque);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	function EliminarCheque($id_cheque)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque -> EliminarCheque($id_cheque);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ValidarCheque($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ValidarCheque($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$nro_deposito,$fecha_cheque,$nombre_cheque,$estado_cheque,$id_cuenta_bancaria);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	function ValidarChequeRegTra($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria)
	{
//		echo "llega que cagada"; exit();
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ValidarChequeRegTra($operacion_sql,$id_cheque,$id_transaccion,$nro_cheque,$nro_deposito,$fecha_cheque,$nombre_cheque,$id_cuenta_bancaria);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	//RCM: 11/02/2009
	function ListarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	//RCM: 11/02/2009
	function ContarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarChequeAnulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	//RCM: 11/02/2009
	function AnularCheque($id_cheque,$id_tabla,$tipo_cheque)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->AnularCheque($id_cheque,$id_tabla,$tipo_cheque);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	/****** agosto2016 *******/
	function SubirChequeCsv($id_transaccion,$id_cuenta_bancaria, $arr_temp0, $arr_temp1,$arr_temp2 ,$arr_temp3,$arr_temp4)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->SubirChequeCsv($id_transaccion, $id_cuenta_bancaria,$arr_temp0, $arr_temp1,$arr_temp2 ,$arr_temp3,$arr_temp4);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	/// --------------------- fin tct_cheque --------------------- ///
	
	//-------------------------Ajuste por Actualizaciï¿½n -----------////
//RCM: 04/12/2008
	function Ajustar($id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda)
	{
		$this->salida = "";
		$dbAju = new cls_DBAjusteAct($this->decodificar);
		$res = $dbAju ->Ajustar($id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda);
		$this->salida = $dbAju ->salida;
		$this->query = $dbAju ->query;
		return $res;
	}
	
	//RCM: 04/12/2008
	function ValidarAjustar($operacion_sql,$id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda)
	{
		$this->salida = "";
		$dbAju = new cls_DBAjusteAct($this->decodificar);
		$res = $dbAju ->ValidarAjustar($operacion_sql,$id_periodo_subsis,$fecha_fin,$id_depto,$fecha_ini,$id_moneda);
		$this->salida = $dbAju ->salida;
		$this->query = $dbAju ->query;
		return $res;
	}
	
	//JAMH 08/12/2008
	//-------------------------Estado Cuenta-------------------//
	
	function ListarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al)
	{
		$this->salida = "";
		$dbEstadoCuenta = new cls_DBEstadoCuenta($this->decodificar);
		$res = $dbEstadoCuenta ->ListarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
		$this->salida = $dbEstadoCuenta ->salida;
		$this->query = $dbEstadoCuenta ->query;
		return $res;
	}
	
	function ContarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al)
	{
		$this->salida = "";
		$dbEstadoCuenta = new cls_DBEstadoCuenta($this->decodificar);
		$res = $dbEstadoCuenta ->ContarEstadoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cuenta,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
		$this->salida = $dbEstadoCuenta ->salida;
		$this->query = $dbEstadoCuenta ->query;
		return $res;
	}
	//---------------------------------------------------------//
	//JAMH 16/12/2008
	//-------------------------Estado Auxiliar-------------------//
	
	function ListarEstadoAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_auxiliar,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al)
	{
		$this->salida = "";
		$dbEstadoAuxiliar = new cls_DBEstadoCuenta($this->decodificar);
		$res = $dbEstadoAuxiliar ->ListarEstadoAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_auxiliar,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
		$this->salida = $dbEstadoAuxiliar ->salida;
		$this->query = $dbEstadoAuxiliar ->query;
		return $res;
	}
	
	function ContarEstadoAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_auxiliar,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al)
	{
		$this->salida = "";
		$dbEstadoAuxiliar = new cls_DBEstadoCuenta($this->decodificar);
		$res = $dbEstadoAuxiliar ->ContarEstadoAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_auxiliar,$id_moneda,$id_ep,$id_uo,$fecha_del,$fecha_al);
		$this->salida = $dbEstadoAuxiliar ->salida;
		$this->query = $dbEstadoAuxiliar ->query;
		return $res;
	}
	//---------------------------------------------------------//
	
	
	/*AVQ 15-05-2009  Reporte Documentos Respaldo*/
	function ListarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda)
	{
		$this->salida = "";
		$dbRepDocumentoRespaldo = new cls_DBRepDocumentos($this->decodificar);
		$res = $dbRepDocumentoRespaldo ->ListarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda);
		$this->salida = $dbRepDocumentoRespaldo ->salida;
		$this->query = $dbRepDocumentoRespaldo ->query;
		return $res;
	}
	
	function ContarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda)
	{
		$this->salida = "";
		$dbRepDocumentoRespaldo = new cls_DBRepDocumentos($this->decodificar);
		$res = $dbRepDocumentoRespaldo ->ContarRepDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda);
		$this->salida = $dbRepDocumentoRespaldo ->salida;
		$this->query = $dbRepDocumentoRespaldo ->query;
		return $res;
	}
	function SumDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda)
	{
		$this->salida = "";
		$dbRepDocumentoRespaldo = new cls_DBRepDocumentos($this->decodificar);
		$res = $dbRepDocumentoRespaldo ->SumDocumentosDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante,$id_moneda);
		$this->salida = $dbRepDocumentoRespaldo ->salida;
		$this->query = $dbRepDocumentoRespaldo ->query;
		return $res;
	}
	/* AVQ  16/06/2009 Reporte Libro Mayor por Partida */
	function LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
    {
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->LibroMayorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto);
	    $this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	
	function LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
    {
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->LibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto);
	    $this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	
	function ContarLibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto)
    {
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->ContarLibroMayorPartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_partida,$id_moneda,$fecha_inicio,$fecha_fin,$id_presupuesto);
	    $this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	/// --------------------- tct_cuenta_auxiliar_vista --------------------- ///

	function ListarVCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ListarVCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	function ContarVCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ContarVCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	/* AVQ  17/06/2009 Reporte Balance Sumas y Saldos */
	
	function BalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin)
    {
		$this->salida = "";
		$dbBalanceSS = new cls_DBRepBalanceSS($this->decodificar);
		$res = $dbBalanceSS ->BalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin);
	    $this->salida = $dbBalanceSS ->salida;
		$this->query = $dbBalanceSS ->query;
		return $res;
	}
	function ContarBalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin)
    {
		$this->salida = "";
		$dbBalanceSS = new cls_DBRepBalanceSS($this->decodificar);
		$res = $dbBalanceSS ->ContarBalanceSSDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$id_moneda,$nivel,$fecha_fin);
	    $this->salida = $dbBalanceSS ->salida;
		$this->query = $dbBalanceSS ->query;
		return $res;
	}
	//avq reporte comprobante
	function ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda)
    {
		$this->salida = "";
		$dbRepComp = new cls_DBTransaccion($this->decodificar);
		$res = $dbRepComp ->ListarRepComprobanteTransaccion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$m_id_combrobante,$m_id_moneda);
	    $this->salida = $dbRepComp ->salida;
		$this->query = $dbRepComp ->query;
		return $res;
	}
	// get Firmas
	function GetFirmasComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante)
    {
		$this->salida = "";
		$dbRepComp = new cls_DBComprobante($this->decodificar);
		$res = $dbRepComp ->GetFirmasComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_comprobante);
	    $this->salida = $dbRepComp ->salida;
		$this->query = $dbRepComp ->query;
		return $res;
	}
	
	/**************PLANILLA **************/
	
	
	function ListarReporteCabeceraPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ListarReporteCabeceraPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	function ListarReporteDetallePlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ListarReporteDetallePlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla= new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->EliminarPlanilla($id_planilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function InsertarPlanillaDet($id_plan_pago,$id_cuenta_bancaria,$tipo_cheque,$tipo_plantilla,$fecha_factura,$num_factura,$por_anticipo,$por_retgar,$multas)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanillaDet($id_plan_pago,$id_cuenta_bancaria,$tipo_cheque,$tipo_plantilla,$fecha_factura,$num_factura,$por_anticipo,$por_retgar,$multas);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function EliminarPlanillaDet($id_planilla,$id_plan_pago)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->EliminarPlanillaDet($id_planilla,$id_plan_pago);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function InsertarPlanillaPago($id_planilla,$estado_reg)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanillaPago($id_planilla,$estado_reg);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function ImportarPlanilla($id_planilla,$id_plantilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ImportarPlanilla($id_planilla,$id_plantilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBConsultores($this->decodificar);
		$res = $dbCotizacion ->ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBConsultores($this->decodificar);
		$res = $dbCotizacion ->ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	/**************** fin planilla **************************/
	function ReporteValidacionLibroMayorBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto,$id_moneda,$fecha_inicio,$fecha_fin)
		{
		$this->salida = "";
		$dbLibroMayor = new cls_DBLibroMayor($this->decodificar);
		$res = $dbLibroMayor ->ReporteValidacionLibroMayorBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto,$id_moneda,$fecha_inicio,$fecha_fin);
		$this->salida = $dbLibroMayor ->salida;
		$this->query = $dbLibroMayor ->query;
		return $res;
	}
	function HabilitarComprobanteModificacion($id_comprobante,$id_usuario_mod,$justificacion_edicion)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->HabilitarComprobanteModificacion($id_comprobante,$id_usuario_mod,$justificacion_edicion);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function MonedaComprobante($id_comprobante,$id_moneda_sola)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->MonedaComprobante($id_comprobante,$id_moneda_sola);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function BorradorComprobante($id_comprobante,$id_usuario_mod)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->BorradorComprobante($id_comprobante,$id_usuario_mod);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	function ListarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ListarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ContarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ContarComprobanteLog($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	
	
	/**************** fin sigma **************************/

	function ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	
	function ListarGTOCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarGTOCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
		
	function ListarRECDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarRECDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
			
	function ListarRECANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarRECANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	
	function ListarGTODET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarGTODET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
  function ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBSigma($this->decodificar);
		$res = $dbSigma  ->ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}  
		/**************** Inicio libro mayor por epe, uo , ot, cuenta y auxilair **************************/
	function ContarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{	 
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ContarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	function ListarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{    
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ListarEstadoEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	function ContarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{	 
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ContarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	function ListarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{    
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ListarMayorEpeUoOtCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	function ContarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{	 
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ContarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	function ListarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion)
	{    
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ListarMayorComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	/**************** Fin libro mayor por epe, uo , ot, cuenta y auxilair **************************/
	
	function ListarCabLibroCompraVenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarCabLibroCompraVenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$periodo,$id_moneda,$sw_debito_credito,$id_depto,$tipo_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}	
	
	/******************* Actualizar **************/
	function ListarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar ->ListarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	function ContarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar ->ContarActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	function InsertarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar ->InsertarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	
	function ModificarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar ->ModificarActualizacion($id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	function  EliminarActualizacion($id_actualizacion)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar -> EliminarActualizacion($id_actualizacion);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	
	function  ValidarActualizacion($operacion_sql,$id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar -> ValidarActualizacion($operacion_sql,$id_actualizacion,$id_depto,$fecha,$descripcion,$fecha_reg,$id_usuario,$id_moneda,$id_comprobante);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	function ListarActualizacionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActualizarDet= new cls_DBActualizacionDetalle($this->decodificar);
		$res = $dbActualizarDet ->ListarActualizacionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActualizarDet->salida;
		$this->query = $dbActualizarDet ->query;
		return $res;
	}
	function ContarActualizacionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActualizarDet = new cls_DBActualizacionDetalle($this->decodificar);
		$res = $dbActualizarDet->ContarActualizacionDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActualizarDet->salida;
		$this->query = $dbActualizarDet->query;
		return $res;
	}
	
	function ListarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaActualizar= new cls_DBTransaccionActualizacion($this->decodificar);
		$res = $dbTransaActualizar ->ListarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaActualizar->salida;
		$this->query = $dbTransaActualizar ->query;
		return $res;
	}
	function ContarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaActualizar = new cls_DBTransaccionActualizacion($this->decodificar);
		$res = $dbTransaActualizar->ContarTransaccionActualizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaActualizar->salida;
		$this->query = $dbTransaActualizar->query;
		return $res;
	}
	function GenerarActualizacion($id_actualizacion, $sw_proce)
	{
		$this->salida = "";
		$dbActualizar = new cls_DBActualizacion($this->decodificar);
		$res = $dbActualizar ->GenerarActualizacion($id_actualizacion, $sw_proce);
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	
	/********************* fin actualizar *****/
	
	/*********************xls****************/
	function ImportarXls($campos,$id_adjunto)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->ImportarXls($campos,$id_adjunto);
		$this->salida = $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
	/********************* fin actualizar *****/
 /*********************xls****************/
	function ListarXls($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->ListarXls($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto);
		$this->salida = $dbXlsCsv->salida; 
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
	
	function ContarXls($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{  
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->ContarXls($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
	
	function InsertarXls($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original,$desc_persona)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->InsertarXls($id_adjunto,$nombre_doc,$observacion,$id_correspondencia,$nombre_arch,$extension,$nombre_original,$desc_persona);
		$this->salida = $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
	function EliminarXls($id_adjunto)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->EliminarXls($id_adjunto);
		$this->salida= $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
    //         ValidarXls($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$nombre_original);
	function ValidarXls($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$nombre_original)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->ValidarXls($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$nombre_original);
		$this->salida= $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	} 	
   function ExportarXls($excel,$nombre_file)
	{
		$this->salida = "";
		$dbXlsCsv = new cls_DBXlsCsv($this->decodificar);
		$res = $dbXlsCsv ->ExportarXls($excel,$nombre_file);
		$this->salida= $dbXlsCsv->salida;
		$this->query = $dbXlsCsv ->query;
		return $res;
	}
	/************FIN DE XLSACSV***********////
	 
	
///********** CLS_DBTRANSACCIONVALOR***///
	function ModificarTransaccionValor($id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber)
	{
		$this->salida = "";
		$dbTransValor = new cls_DBTransaccionValor($this->decodificar);
		$res = $dbTransValor ->ModificarTransaccionValor($id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber);
		$this->salida= $dbTransValor->salida;
		$this->query = $dbTransValor ->query;
		return $res;
	}
	function ValidarTransaccionValor($operacion_sql,$id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber)
	{
		$this->salida = "";
		$dbTransValor = new cls_DBTransaccionValor($this->decodificar);
		$res = $dbTransValor ->ValidarTransaccionValor($operacion_sql,$id_comprobante,$id_transaccion,$id_moneda,$importe_debe,$importe_haber);
		$this->salida= $dbTransValor->salida;
		$this->query = $dbTransValor ->query;
		return $res;
	}
	function ListarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda)
	{
			$this->salida = "";
			$dbTransValor = new cls_DBTransaccionValor($this->decodificar);
			$res = $dbTransValor ->ListarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda);
			$this->salida= $dbTransValor->salida;
			$this->query = $dbTransValor ->query;
			return $res;
	}
	
	function ContarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda)
	{
			$this->salida = "";
			$dbTransValor = new cls_DBTransaccionValor($this->decodificar);
			$res = $dbTransValor ->ContarTransValor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_comprobante,$id_transaccion,$id_moneda);
			$this->salida= $dbTransValor->salida;
			$this->query = $dbTransValor ->query;
			return $res;
	}
	//*****fin ******//
		//****cls_DBDocCbteUsuario.php****//
	function ListarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			$res = $dbDocCbteUsuario ->ListarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function ContarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			$res = $dbDocCbteUsuario ->ContarDocCbteUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function InsertarDocCbteUsuario($id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			$res = $dbDocCbteUsuario ->InsertarDocCbteUsuario($id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function ModificarDocCbteUsuario($id_doc_cbte_user,$id_documento   ,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion)
	{                               
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			
			$res = $dbDocCbteUsuario ->ModificarDocCbteUsuario($id_doc_cbte_user,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function EliminarDocCbteUsuario($id_doc_cbte_user)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			$res = $dbDocCbteUsuario ->EliminarDocCbteUsuario($id_doc_cbte_user);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function ValidarDocCbteUsuario($operacion_sql,$id_doc_cbte_user,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBDocCbteUsuario($this->decodificar);
			$res = $dbDocCbteUsuario ->ValidarDocCbteUsuario($operacion_sql,$id_doc_cbte_user,$id_documento,$id_clase_cbte,$id_usuario,$id_periodo_subsistema,$sw_validacion,$sw_edicion);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	
	//*****fin ******//
	////////////////////Cierre - Apertura /////////////////
	
	function ListarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff)
	{
			$this->salida = "";
			$dbCierreApertura = new cls_DBCierreApertura($this->decodificar);
			$res = $dbCierreApertura ->ListarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff);
			$this->salida= $dbCierreApertura->salida;
			$this->query = $dbCierreApertura ->query;
			return $res;
	}
	function ContarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff)
	{
			$this->salida = "";
			$dbCierreApertura = new cls_DBCierreApertura($this->decodificar);
			$res = $dbCierreApertura ->ContarCierreApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_volcar,$siguiente_gestion,$cta_dif,$sw_act,$dpto_conta,$g_actual,$g_nueva,$moneda,$eeff);
			$this->salida= $dbCierreApertura->salida;
			$this->query = $dbCierreApertura ->query;
			return $res;
	}
	function InsertarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBCierreApertura($this->decodificar);
			$res = $dbDocCbteUsuario ->InsertarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function ModificarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBCierreApertura($this->decodificar);
			$res = $dbDocCbteUsuario ->ModificarCierreApertura($ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function EliminarCierreApertura($id_cierre_apertura)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBCierreApertura($this->decodificar);
			$res = $dbDocCbteUsuario ->EliminarCierreApertura($id_cierre_apertura);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
	function ValidarCierreApertura($operacion_sql,$ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda)
	{
			$this->salida = "";
			$dbDocCbteUsuario = new cls_DBCierreApertura($this->decodificar);
			$res = $dbDocCbteUsuario ->ValidarCierreApertura($operacion_sql,$ct_id_cierre_apertura,$ct_id_comprobante,$ct_descripcion,$ct_nro_cbte,$ct_id_reporte_eeff,$ct_sw_volcar,$ct_sw_siguiente_gestion,$ct_id_cuenta_diferencia,$ct_sw_actualizacion,$ct_id_depto_conta,$ct_id_gestion_actual,$ct_id_gestion_nueva,$ct_sw_estado,$ct_id_moneda);
			$this->salida= $dbDocCbteUsuario->salida;
			$this->query = $dbDocCbteUsuario ->query;
			return $res;
	}
		function GenerarCbteCierreApertura($id_cierre_apertura )
	{
		$this->salida = "";
		$dbActualizar = new cls_DBCierreApertura($this->decodificar);
		$res = $dbActualizar ->GenerarCbteCierreApertura($id_cierre_apertura );
		$this->salida = $dbActualizar->salida;
		$this->query = $dbActualizar ->query;
		return $res;
	}
	//////////////////// Fin Cierre - Apertura /////////////////
	////////////////////consistencia_ejecucion
	function ListarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBRepConsEjec($this->decodificar);
		$res = $dbPlantilla ->ListarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}	
	
	function ContarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBRepConsEjec($this->decodificar);
		$res = $dbPlantilla ->ContarConsEjec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	//////////////////////////fin consistencica ejecucion
	
	
	/// --------------------- tfv_archivo_control --------------------- ///
	function ListarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ListarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ContarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ContarRecuperacionVejez($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	 
	function ListarArchivoControlGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ListarArchivoControlGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function InsertarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->InsertarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ModificarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ModificarRecuperacionVejez($id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function EliminarRecuperacionVejez($id_archivo_control)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo -> EliminarRecuperacionVejez($id_archivo_control);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ValidarRecuperacionVejez($operacion_sql,$id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ValidarRecuperacionVejez($operacion_sql,$id_archivo_control,$anio_per_fiscal,$cantidad_valor_solicitado,$codigo_form,$fecha_envio,$mes_per_fiscal,$numero_orden,$nro_factura,$nro_autoriza,$cod_control,$fecha_emision);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	function InsertarBeneficiarios($dt_id_archivo_control,$dt_mes_periodo,$dt_anio_periodo)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->InsertarBeneficiarios($dt_id_archivo_control,$dt_mes_periodo,$dt_anio_periodo);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ModificarFinalizarFormulario($dt_id_archivo_control,$dt_mes_periodo,$dt_anio_periodo)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBArchivoControlGral($this->decodificar);
		$res = $dbReclamo ->ModificarFinalizarFormulario($dt_id_archivo_control,$dt_mes_periodo,$dt_anio_periodo);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	/// --------------------- fin tfv_archivo_control --------------------- ///
	/// --------------------- tfv_detalle_beneficiario --------------------- ///
	function ListarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiarioGral($this->decodificar);
		$res = $dbReclamo ->ListarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ListarDetalleBeneficiariosGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiarioGral($this->decodificar);
		$res = $dbReclamo ->ListarDetalleBeneficiariosGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ContarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiarioGral($this->decodificar);
		$res = $dbReclamo ->ContarDetalleBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	function ModificarDetalleBeneficiario($id_beneficiario_vejez, $id_archivo_control, $estado)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiarioGral($this->decodificar);
		$res = $dbReclamo ->ModificarDetalleBeneficiario($id_beneficiario_vejez, $id_archivo_control, $estado);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ValidarDetalleBeneficiario($operacion_sql,$id_beneficiario_vejez, $id_archivo_control, $estado)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiarioGral($this->decodificar);
		$res = $dbReclamo ->ValidarDetalleBeneficiario($operacion_sql,$id_beneficiario_vejez, $id_archivo_control, $estado);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ListarDetalleBeneficiariosSumRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiario($this->decodificar);
		$res = $dbReclamo ->ListarDetalleBeneficiariosSumRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ListarDetalleBeneficiariosSCIRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiario($this->decodificar);
		$res = $dbReclamo ->ListarDetalleBeneficiariosSCIRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	
	function ListarDatosGeneralesBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReclamo = new cls_DBDetalleBeneficiario($this->decodificar);
		$res = $dbReclamo ->ListarDatosGeneralesBeneficiarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReclamo ->salida;
		$this->query = $dbReclamo ->query;
		return $res;
	}
	/// --------------------- fin tfv_detalle_beneficiario --------------------- ///	
	
	/// --------------------- tct_cuenta_bancariz --------------------- ///

	function ListarCuentaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz ->ListarCuentaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}
	function ContarCuentaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz ->ContarCuentaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}	
	function InsertarCuentaBancariz($id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz ->InsertarCuentaBancariz($id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}
	
	function ModificarCuentaBancariz($id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz ->ModificarCuentaBancariz($id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}
	
	function EliminarCuentaBancariz($id_cuenta_bancariz)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz -> EliminarCuentaBancariz($id_cuenta_bancariz);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}
	
	function ValidarCuentaBancariz($operacion_sql,$id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado)
	{
		$this->salida = "";
		$dbCuentaBancariz = new cls_DBCuentaBancariz($this->decodificar);
		$res = $dbCuentaBancariz ->ValidarCuentaBancariz($operacion_sql,$id_cuenta_bancariz,$id_parametro,$id_cuenta,$estado);
		$this->salida = $dbCuentaBancariz ->salida;
		$this->query = $dbCuentaBancariz ->query;
		return $res;
	}	
	
	/// --------------------- fin tct_cuenta_bancariz --------------------- ///
	
	/// --------------------- tct_plantilla_bancariz --------------------- ///

	function ListarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz ->ListarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}
	function ContarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz ->ContarPlantillaBancariz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}	
	function InsertarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz ->InsertarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}
	
	function ModificarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz ->ModificarPlantillaBancariz($id_plantilla_bancariz,$codigo,$descripcion);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}
	
	function EliminarPlantillaBancariz($id_plantilla_bancariz)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz -> EliminarPlantillaBancariz($id_plantilla_bancariz);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}
	
	function ValidarPlantillaBancariz($operacion_sql,$id_plantilla_bancariz,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbPlantillaBancariz = new cls_DBPlantillaBancariz($this->decodificar);
		$res = $dbPlantillaBancariz ->ValidarPlantillaBancariz($operacion_sql,$id_plantilla_bancariz,$codigo,$descripcion);
		$this->salida = $dbPlantillaBancariz ->salida;
		$this->query = $dbPlantillaBancariz ->query;
		return $res;
	}	
	
	/// --------------------- fin tct_plantilla_bancariz --------------------- ///
	/// --------------------- tct_plantilla_rel --------------------- ///

	function ListarPlantillaRel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel ->ListarPlantillaRel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}
	function ContarPlantillaRel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel ->ContarPlantillaRel($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}	
	function InsertarPlantillaRel($id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel ->InsertarPlantillaRel($id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}
	
	function ModificarPlantillaRel($id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel ->ModificarPlantillaRel($id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}
	
	function EliminarPlantillaRel($id_plantilla_rel)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel -> EliminarPlantillaRel($id_plantilla_rel);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}
	
	function ValidarPlantillaRel($operacion_sql,$id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado)
	{
		$this->salida = "";
		$dbPlantillaRel = new cls_DBPlantillaRel($this->decodificar);
		$res = $dbPlantillaRel ->ValidarPlantillaRel($operacion_sql,$id_plantilla_rel,$id_plantilla,$id_plantilla_bancariz,$estado);
		$this->salida = $dbPlantillaRel ->salida;
		$this->query = $dbPlantillaRel ->query;
		return $res;
	}	
	
	/// --------------------- fin tct_plantilla_rel --------------------- ///
	
	
	/// --------------------- tct_bancarizacion --------------------- ///

	function ListarBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion ->ListarBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	
	function ContarBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion ->ContarBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	
	function InsertarBancarizacion($id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado,$id_moneda,$id_deptos)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion ->InsertarBancarizacion($id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado,$id_moneda,$id_deptos);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	
	function ModificarBancarizacion($id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado,$id_moneda,$id_deptos)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion ->ModificarBancarizacion($id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado,$id_moneda,$id_deptos);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	
	function EliminarBancarizacion($id_bancarizacion)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion -> EliminarBancarizacion($id_bancarizacion);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	function GeneraDetalleBancarizacion($id_bancarizacion)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion -> GeneraDetalleBancarizacion($id_bancarizacion);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	function ValidarBancarizacion($operacion_sql,$id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado)
	{
		$this->salida = "";
		$dbBancarizacion = new cls_DBBancarizacion($this->decodificar);
		$res = $dbBancarizacion ->ValidarBancarizacion($operacion_sql,$id_bancarizacion,$fecha_ini,$fecha_fin,$observaciones,$estado);
		$this->salida = $dbBancarizacion ->salida;
		$this->query = $dbBancarizacion ->query;
		return $res;
	}
	
	/// --------------------- fin tct_bancarizacion --------------------- ///
	/// --------------------- tct_bancarizacion_det --------------------- ///

	function ListarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizaciondet = new cls_DBBancarizacionDet($this->decodificar);
		$res = $dbBancarizaciondet ->ListarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizaciondet ->salida;
		$this->query = $dbBancarizaciondet ->query;
		return $res;
	}
	
	function ContarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizaciondet = new cls_DBBancarizacionDet($this->decodificar);
		$res = $dbBancarizaciondet ->ContarBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizaciondet ->salida;
		$this->query = $dbBancarizaciondet ->query;
		return $res;
	}
	function RepBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizaciondet = new cls_DBBancarizacionDet($this->decodificar);
		$res = $dbBancarizaciondet ->RepBancarizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizaciondet ->salida;
		$this->query = $dbBancarizaciondet ->query;
		return $res;
	}
	function XlsBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbBancarizaciondet = new cls_DBBancarizacionDet($this->decodificar);
		$res = $dbBancarizaciondet ->XlsBancarizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbBancarizaciondet ->salida;
		$this->query = $dbBancarizaciondet ->query;
		return $res;
	}
	/// --------------------- fin tct_bancarizacion_det --------------------- ///
	function ListarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ListarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
	
	function ContarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCheque = new cls_DBCheque($this->decodificar);
		$res = $dbCheque ->ContarChequeReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCheque ->salida;
		$this->query = $dbCheque ->query;
		return $res;
	}
//añadido ana 19/11/2012 para el cierre contable
	function ReporteCierreContable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos,$fecha_inicio,$fecha_fin)
        {
        $this->salida = "";
        $dbRepCierreContable = new cls_DBRepCierreContable($this->decodificar);
        $res = $dbRepCierreContable ->ReporteCierreContable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos, $fecha_inicio,$fecha_fin);
        $this->salida = $dbRepCierreContable ->salida;
        $this->query = $dbRepCierreContable ->query;
        return $res;
    }
	function ReporteDifPagadoDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos,$fecha_inicio,$fecha_fin)
        {
        $this->salida = "";
        $dbRepCierreContable = new cls_DBRepCierreContable($this->decodificar);
        $res = $dbRepCierreContable ->ReporteDifPagadoDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ids_deptos, $fecha_inicio,$fecha_fin);
        $this->salida = $dbRepCierreContable ->salida;
        $this->query = $dbRepCierreContable ->query;
        return $res;
    }
	
	function ListarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->ListarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	function ContarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBlListarEEFFBG($this->decodificar);
		$res = $dbPlantilla ->ContarEstadoSumasySaldos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$ct_deptos,$ct_id_moneda,$ct_fecha,$ct_id_parametro,$ct_nivel,$ct_fecha_inicial,$sw_transaccional);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	/// --------------------- tct_eeff --------------------- ///

	function ListarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom ->ListarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function ContarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom ->ContarEeffCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function InsertarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom ->InsertarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function ModificarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom ->ModificarEeffCom($id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function EliminarEeffCom($id_eeff)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom -> EliminarEeffCom($id_eeff);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function ValidarEeffCom($operacion_sql,$id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel)
	{
		$this->salida = "";
		$dbEeffCom = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffCom ->ValidarEeffCom($operacion_sql,$id_eeff,$id_gestion_act,$id_gestion_ant,$eeff_texto,$id_reporte_eeff,$id_moneda,$eeff_actual,$eeff_fecran,$eeff_nivel);
		$this->salida = $dbEeffCom ->salida;
		$this->query = $dbEeffCom ->query;
		return $res;
	}
	
	function ListarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea ->ListarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function ContarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea ->ContarEeffLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function InsertarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea ->InsertarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function ModificarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea ->ModificarEeffLinea($id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function EliminarEeffLinea($id_eeff_linea)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea -> EliminarEeffLinea($id_eeff_linea);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function ValidarEeffLinea($operacion_sql,$id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t)
	{
		$this->salida = "";
		$dbEeffLinea = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffLinea ->ValidarEeffLinea($operacion_sql,$id_eeff_linea,$id_eeff,$id_cuenta_act,$id_cuenta_ant,$linea_dato,$linea_saldo,$linea_n,$linea_s,$id_eeff_nota,$linea_desope,$linea_b,$linea_nro,$linea_t);
		$this->salida = $dbEeffLinea ->salida;
		$this->query = $dbEeffLinea ->query;
		return $res;
	}
	
	function ListarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota ->ListarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function ContarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota ->ContarEeffNota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function InsertarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota ->InsertarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function ModificarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota ->ModificarEeffNota($id_eeff_nota,$id_eeff,$nota_nro,$nota_texto);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function EliminarEeffNota($id_eeff_nota)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota -> EliminarEeffNota($id_eeff_nota);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function ValidarEeffNota($operacion_sql,$id_eeff_nota,$id_eeff,$nota_nro,$nota_texto)
	{
		$this->salida = "";
		$dbEeffNota = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffNota ->ValidarEeffNota($operacion_sql,$id_eeff_nota,$id_eeff,$nota_nro,$nota_texto);
		$this->salida = $dbEeffNota ->salida;
		$this->query = $dbEeffNota ->query;
		return $res;
	}
	
	function ListarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera ->ListarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function ContarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera ->ContarEeffOpera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function InsertarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera ->InsertarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function ModificarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera ->ModificarEeffOpera($id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function EliminarEeffOpera($id_eeff_opera)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera -> EliminarEeffOpera($id_eeff_opera);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function ValidarEeffOpera($operacion_sql,$id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera)
	{
		$this->salida = "";
		$dbEeffOpera = new cls_DBEeffCompara($this->decodificar);
		$res = $dbEeffOpera ->ValidarEeffOpera($operacion_sql,$id_eeff_opera,$id_eeff_linea,$id_cuenta_act,$linea_opera);
		$this->salida = $dbEeffOpera ->salida;
		$this->query = $dbEeffOpera ->query;
		return $res;
	}
	
	function ListarGestionFirma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ListarGestionFirma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function ContarGestionFirma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ContarGestionFirma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function InsertarGestionFirma($id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->InsertarGestionFirma($id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function ModificarGestionFirma($id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ModificarGestionFirma($id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function EliminarGestionFirma($id_gestion_firma)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma -> EliminarGestionFirma($id_gestion_firma);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function ValidarGestionFirma($operacion_sql,$id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ValidarGestionFirma($operacion_sql,$id_gestion_firma,$id_gestion,$sw_firma,$id_empleado,$id_cargo,$mat_contador);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}

	function ListarCargos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ListarCargos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	
	function ContarCargos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionFirma = new cls_DBGestionFirma($this->decodificar);
		$res = $dbGestionFirma ->ContarCargos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionFirma ->salida;
		$this->query = $dbGestionFirma ->query;
		return $res;
	}
	/// --------------------- fin tct_eeff --------------------- ///
	
	function ActualizarLibros($id_transaccion,$subsistema,$gestion,$periodo)
    {
        $this->salida = "";
        $dbActualizarLibros = new cls_DBActualizarLibros($this->decodificar);
        $res = $dbActualizarLibros ->ActualizarLibros($id_transaccion,$subsistema,$gestion,$periodo);
        $this->salida = $dbActualizarLibros ->salida;
        $this->query = $dbActualizarLibros ->query;
        return $res;
    }
    function ActualizarLibrosCompras($id_transaccion,$subsistema,$gestion,$periodo)
    {
    	$this->salida = "";
    	$dbActualizarLibros = new cls_DBActualizarLibros($this->decodificar);
    	$res = $dbActualizarLibros->ActualizarLibrosCompras($id_transaccion,$subsistema,$gestion,$periodo);
    	$this->salida = $dbActualizarLibros ->salida;
    	$this->query = $dbActualizarLibros ->query;
    	return $res;
    }
    
	function ContarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden)
	{	 
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ContarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden)
	{    
		$this->salida = "";
		$dbSigma = new cls_DBLibroMayor($this->decodificar);
		$res = $dbSigma  ->ListarMayDat($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_depto,$fecha_inicio,$fecha_final,$sw_cuenta,$sw_auxiliar,$sw_partida,$sw_epe,$sw_uo,$sw_ot,$id_cuenta_inicial,$id_cuenta_final,$id_auxiliar_inicial,$id_auxiliar_final,$id_partida_inicial,$id_partida_final,$id_epe_inicial,$id_epe_final,$id_uo_inicial,$id_uo_final,$id_ot_inicial,$id_ot_final,$sw_estado_cbte,$sw_listado,$id_moneda,$sw_actualizacion,$sw_orden);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
}