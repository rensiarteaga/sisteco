<?php
/**
 * Nombre de la Clase:	    CustomDBContabilidad
 * Propósito:				Interfaz del modelo del Sistema de Contabilidad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		02-10-2007
 * Autor:					Josè A. Mita Huanca
 *
 */
class cls_CustomDBSigma
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{	
		include_once("cls_DBDeclaracion.php");
		include_once("cls_DBCabCbte.php");
		include_once("cls_DBCbteDet.php");
	}
	
	/// --------------------- tsi_declaracion --------------------- ///

	function ListarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ListarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ContarDeclaracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function InsertarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->InsertarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ModificarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ModificarDeclaracion($id_declaracion,$estado,$fecha_reg,$id_gestion,$id_empresa,$id_usuario,$id_periodo,$id_moneda);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function EliminarDeclaracion($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> EliminarDeclaracion($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function AnularDeclaracion($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> AnularDeclaracion($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function FinalDeclaracion($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> FinalDeclaracion($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function GenerarEjecucion($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> GenerarEjecucion($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function VerificarOEC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->VerificarOEC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function VerificarArchivos($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> VerificarArchivos($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ValidarEjecucion($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> ValidarEjecucion($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function DiferenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->DiferenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function DiferenciaContaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->DiferenciaContaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ValidarAcumulado($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> ValidarAcumulado($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function DiferenciaAcumulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->DiferenciaAcumulado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ValidarSigma($id_declaracion)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> ValidarSigma($id_declaracion);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function DiferenciaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->DiferenciaSigma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function DiferenciaSigmaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->DiferenciaSigmaPpto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ConsultaRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ConsultaRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ConsultaIDQuery($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida,$id_dato)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db ->ConsultaIDQuery($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_declaracion,$id_partida,$id_dato);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	///agregado en fecha 28 de marzo por Williams Escobar	
	//
	function GastoInversionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_exce)
	{
		$this->salida = "";
		$db = new cls_DBDeclaracion($this->decodificar);
		$res = $db -> GastoInversionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_exce);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	/// --------------------- Fin tsi_declaracion --------------------- ///
	
	/// --------------------- tsi_cab_cbte --------------------- ///
	function ListarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCabCbte($this->decodificar);
		$res = $db ->ListarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCabCbte($this->decodificar);
		$res = $db ->ContarCabCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	function InsertarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones)
	{
		$this->salida = "";
		$db = new cls_DBCabCbte($this->decodificar);
		$res = $db ->InsertarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	function ModificarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones)
	{
		$this->salida = "";
		$db = new cls_DBCabCbte($this->decodificar);
		$res = $db ->ModificarCabCbte($id_cab_cbte,$nro_cbte,$id_cbte,$compromiso,$devengado,$pagado,$operacion,$id_cbte_orig,$tipo_mov,$tipo_pago,$tipo,$id_declaracion,$observaciones);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	function EliminarCabCbte($id_cab_cbte)
	{
		$this->salida = "";
		$db = new cls_DBCabCbte($this->decodificar);
		$res = $db ->EliminarCabCbte($id_cab_cbte);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	/// --------------------- Fin tsi_cab_cbte --------------------- ///
	
	/// --------------------- tsi_cbte_det --------------------- ///
	function ListarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->ListarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->ContarCbteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	function InsertarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$id_transaccion,$modificado)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->InsertarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$id_transaccion,$modificado);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	function ModificarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$modificado)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->ModificarCbteDet($id_cbte_det,$tipo,$tipo_dato,$reportar,$ent_trf,$id_cab_cbte,$id_cuenta_bancaria,$id_partida,$id_presupuesto,$importe,$libreta,$cuenta_sigma,$modificado);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function EliminarCbteDet($id_cbte_det)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->EliminarCbteDet($id_cbte_det);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ListarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->ListarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBCbteDet($this->decodificar);
		$res = $db ->ContarTransac($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	/// --------------------- Fin tsi_cbte_det --------------------- ///
	
	/// --------------------- Generación de archivos --------------------- ///

	function ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarRECCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarGTOCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarGTOCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
		
	function ListarRECDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarRECDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
		
	function ListarRECANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarRECANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarGTODET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarGTODET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarGTOANX($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarMODCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarMODCAB($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarMODDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarMODDET($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarPPTINI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarPPTINI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarDIRADM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarDIRADM($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarAPEPRO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarAPEPRO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function ListarCONTRL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSigma = new cls_DBCabCbte($this->decodificar);
		$res = $dbSigma  ->ListarCONTRL($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	/// --------------------- Fin Generación de archivos --------------------- ///
	
	//--------- Reporte ejecución presupuestaria --------------

	/*function EjecucionGastoInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel='no'){
		$this->salida = "";
		$dbSigma = new cls_DBDeclaracion($this->decodificar);
		$res = $dbSigma->EjecucionGastoInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}*/
	
	function EjecucionGastoInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel='no'){
		$this->salida = "";
		$dbSigma = new cls_DBDeclaracion($this->decodificar);
		$res = $dbSigma->EjecucionGastoInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	function EjecucionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel='no'){
		$this->salida = "";
		$dbSigma = new cls_DBDeclaracion($this->decodificar);
		$res = $dbSigma->EjecucionRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$si_id_declaracion,$si_tipo_presupuesto,$sw_reporte_excel);
		$this->salida = $dbSigma ->salida;
		$this->query = $dbSigma ->query;
		return $res;
	}
	
	//----------------------- Fin ----------------
	
}