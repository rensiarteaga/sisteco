<?php
/**
 * Nombre de la Clase:	    CustomDBsis_presupuesto
 * Propï¿½sito:				Interfaz del modelo del Sistema de sis_presupuesto
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creaciï¿½n:		2008-07-02 17:16:25
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBPresupuesto{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct(){
		include_once("cls_DBNivelPartida.php");
		include_once("cls_DBParametro.php");
		include_once("cls_DBConceptoCta.php");
		include_once("cls_DBConceptoIngas.php");
		include_once("cls_DBCategoria.php");
		include_once("cls_DBDestino.php");
		include_once("cls_DBCobertura.php");
		include_once("cls_DBPartida.php");
		include_once("cls_DBPartidaCuenta.php");
		include_once("cls_DBMemInversionGasto.php");
		include_once("cls_DBMemRrhh.php");
		include_once("cls_DBMemServicio.php");
		include_once("cls_DBMemViaje.php");
		include_once("cls_DBMemoriaCalculo.php");
		include_once("cls_DBPartidaPresupuesto.php");
		include_once("cls_DBPresupuesto.php");
		include_once("cls_DBFuenteFinanciamiento.php");
		include_once("cls_DBMemIngreso.php");
		//include_once("cls_DBRolMetaproceso.php");
		include_once("cls_DBPartidaArb.php");
		include_once("cls_DBlListarConsolidacionPartida.php");
		include_once("cls_DBParamTcam.php");
		include_once("cls_DBConceptoColectivo.php");
		include_once("cls_DBUsuarioAutorizado.php");
		include_once("cls_DBMemPasaje.php");
		include_once("cls_DBEstadoAutorizado.php");
		include_once("cls_DBlListarEjecucionPartida.php");
		include_once("cls_DBCombustible.php");
		include_once("cls_DBMemCombustible.php");
		include_once("cls_DBPartidaTraspaso.php");
		include_once("cls_DBListarEjecucionInstitucional.php");
		include_once("cls_DBListarDetalleEjecucionPartida.php");
		include_once("cls_DBModificacion.php");
		include_once("cls_DBPartidaModificacion.php");
		
		include_once("cls_DBEstadisticas.php");	
		include_once("cls_DBTipoPresGestion.php");
		include_once("cls_DBEjecucionFisica.php");
		
		include_once("cls_DBActividad.php");
		include_once("cls_DBPrograma.php");
		include_once("cls_DBProyecto.php");
		include_once("cls_DBOrganismoFin.php");
		include_once("cls_DBCategoriaProg.php");
		include_once("cls_DBAdjunto.php");
		include_once("cls_DBListarEjecucionPartidaDetalle.php");
		include_once("cls_DBVerificarPresto.php");
		include_once("cls_DBRepEjecuta.php");
		
		include_once("cls_DBSietDeclara.php");
		include_once("cls_DBSietCbte.php");
		include_once("cls_DBSietCbtePartida.php");
		include_once("cls_DBExtractoBancario.php");
		include_once("cls_DBCaiff.php");
		include_once("cls_DBSietTraspaso.php");
		include_once("cls_DBOec.php");
              include_once("cls_DBSietEntidadTransf.php");
		
		
	}
	
	/// --------------------- tpr_estado_autorizado --------------------- ///

	function ListarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado ->ListarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	function ContarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado ->ContarEstadoAutorizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	function InsertarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado ->InsertarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	function ModificarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado ->ModificarEstadoAutorizado($id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	function EliminarEstadoAutorizado($id_estado_autorizado)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado -> EliminarEstadoAutorizado($id_estado_autorizado);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	function ValidarEstadoAutorizado($operacion_sql,$id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado)
	{
		$this->salida = "";
		$dbEstadoAutorizado = new cls_DBEstadoAutorizado($this->decodificar);
		$res = $dbEstadoAutorizado ->ValidarEstadoAutorizado($operacion_sql,$id_estado_autorizado,$id_usuario_autorizado,$id_concepto_colectivo,$estado_autorizado);
		$this->salida = $dbEstadoAutorizado ->salida;
		$this->query = $dbEstadoAutorizado ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_estado_autorizado --------------------- ///
	
	
	
	/// --------------------- tpr_mem_pasaje --------------------- ///

	function ListarMemoriaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje ->ListarMemoriaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	function ContarMemoriaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje ->ContarMemoriaPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	function InsertarMemoriaPasaje($id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria,$nro_personas)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje ->InsertarMemoriaPasaje($id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria,$nro_personas);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	function ModificarMemoriaPasaje($id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje ->ModificarMemoriaPasaje($id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	function EliminarMemoriaPasaje($id_mem_pasaje)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje -> EliminarMemoriaPasaje($id_mem_pasaje);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	function ValidarMemoriaPasaje($operacion_sql,$id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria,$nro_personas)
	{
		$this->salida = "";
		$dbMemPasaje = new cls_DBMemPasaje($this->decodificar);
		$res = $dbMemPasaje ->ValidarMemoriaPasaje($operacion_sql,$id_mem_pasaje,$id_destino,$id_moneda,$periodo_pres,$total_general,$id_memoria_calculo,$id_categoria,$nro_personas);
		$this->salida = $dbMemPasaje ->salida;
		$this->query = $dbMemPasaje ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_mem_pasaje --------------------- ///
	
	/// --------------------- tpr_usuario_autorizado --------------------- ///

	function ListarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ListarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ContarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ContarAutorizacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function InsertarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->InsertarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ModificarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ModificarAutorizacionPresupuesto($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional,$sw_responsable,$estado);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function EliminarAutorizacionPresupuesto($id_usuario_autorizado)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado -> EliminarAutorizacionPresupuesto($id_usuario_autorizado);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ValidarAutorizacionPresupuesto($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ValidarAutorizacionPresupuesto($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	//RCM: 23/10/2009
	function ListarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ListarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	//RCM: 23/10/2009
	function ContarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ContarUsuarioAutorizadoPresup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_usuario_autorizado --------------------- ///
	/// --------------------- tpr_concepto_colectivo --------------------- ///

	function ListarPresupuestoColectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo ->ListarPresupuestoColectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	
	function ContarPresupuestoColectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo ->ContarPresupuestoColectivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	
	function InsertarPresupuestoColectivo($id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo ->InsertarPresupuestoColectivo($id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	
	function ModificarPresupuestoColectivo($id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo ->ModificarPresupuestoColectivo($id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	function AprobarParametro($id_parametro,$estado_gral)
	{
		$this->salida = ""; 
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> AprobarParametro($id_parametro,$estado_gral);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function CerrarParametro($id_parametro,$estado_gral)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> CerrarParametro($id_parametro,$estado_gral);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function MigrarParametro($id_parametro,$estado_gral)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> MigrarParametro($id_parametro,$estado_gral);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function EliminarPresupuestoColectivo($id_concepto_colectivo)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo -> EliminarPresupuestoColectivo($id_concepto_colectivo);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	
	function ValidarPresupuestoColectivo($operacion_sql,$id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario)
	{
		$this->salida = "";
		$dbConceptoColectivo = new cls_DBConceptoColectivo($this->decodificar);
		$res = $dbConceptoColectivo ->ValidarPresupuestoColectivo($operacion_sql,$id_concepto_colectivo,$desc_colectivo,$estado_colectivo,$id_usuario);
		$this->salida = $dbConceptoColectivo ->salida;
		$this->query = $dbConceptoColectivo ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_concepto_colectivo --------------------- ///
	/*****cls_DBlListarConsolidacionPartida.php******/
	function ListarConsiliacionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$id_categoria_prog,$filtro_niveles)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarConsolidacionPartida($this->decodificar);
		$res = $dbParametro ->ListarConsiliacionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$id_categoria_prog,$filtro_niveles);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ContarConsiliacionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarConsolidacionPartida($this->decodificar);
		$res = $dbParametro ->ContarConsiliacionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	/***************/
		
	/*****cls_DBlListarejecutarPartida.php******/
	function ListarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ContarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ContarConsistenciaEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$fecha_fin,$fecha_ini,$ids_presupuesto,$ids_depto, $id_moneda);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_fin,$fecha_ini,$id_categoria_prog,$filtro_niveles)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_fin,$fecha_ini,$id_categoria_prog,$filtro_niveles);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarTotalEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarTotalEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_fin,$fecha_ini);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ContarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ContarEjecucionPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarEjecucionPartida_x_Fechas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarEjecucionPartida_x_Fechas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$id_concepto_colectivo,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ContarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ContarEjecucionPartidaFech($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$fecha_fin,$fecha_ini);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	//********************************************
	
	function ListarRDEPComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}	
	function ListarRDEPComprometido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarRDEPComprometidoT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometidoT($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}	
	function ListarRDEPComprometido2T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido2T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido3T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido3T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido4T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido4T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido5T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido5T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido6T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido6T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido7T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido7T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPComprometido8T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPComprometido8T($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarRDEPRevertido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPRevertido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPRevertido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPRevertido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPRevertido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPRevertido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPRevertido6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarRDEPDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPDevengado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPDevengado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ListarRDEPPagado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado4($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado5($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado6($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado7($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	function ListarRDEPPagado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarDetalleEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarRDEPPagado8($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$id_presupuesto,$id_partida,$fecha_ini,$fecha_fin);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	/***************/	
	
	
	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
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

	function InsertarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->InsertarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	function ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);
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

	function ValidarParametro($operacion_sql,$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ValidarParametro($operacion_sql,$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$niveles_recurso,$niveles_gasto,$cod_formulario_gasto,$cod_formulario_recurso,$id_gestion,$mod_inversion);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}

	/// --------------------- fin tpr_parametro --------------------- ///

	/// --------------------- tpr_concepto_ingas --------------------- ///

	function ListarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ListarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function ListarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ListarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	function ContarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ContarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function ContarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ContarConceptoPartidaCuentaAux($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	function InsertarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->InsertarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	function ModificarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ModificarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$id_oec,$estado);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	function EliminarConceptoIngas($id_concepto_ingas)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas -> EliminarConceptoIngas($id_concepto_ingas);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	function ValidarConceptoIngas($operacion_sql,$id_concepto_ingas,$desc_ingas,$id_partida,$id_item,$id_servicio,$sw_tesoro,$estado)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ValidarConceptoIngas($operacion_sql,$id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida,$id_item,$id_servicio,$sw_tesoro,$estado);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}

	/// --------------------- fin tpr_concepto_ingas --------------------- ///
	
	/// --------------------- tpr_concepto_cta --------------------- ///

	function ListarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta ->ListarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	function ContarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta ->ContarConceptoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	function InsertarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional,$id_auxiliar)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta ->InsertarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional,$id_auxiliar);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	function ModificarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional,$id_auxiliar)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta ->ModificarConceptoCta($id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional,$id_auxiliar);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	function EliminarConceptoCta($id_concepto_cta)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta -> EliminarConceptoCta($id_concepto_cta);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	function ValidarConceptoCta($operacion_sql,$id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbConceptoCta = new cls_DBConceptoCta($this->decodificar);
		$res = $dbConceptoCta ->ValidarConceptoCta($operacion_sql,$id_concepto_cta,$id_concepto_ingas,$id_cuenta,$id_unidad_organizacional);
		$this->salida = $dbConceptoCta ->salida;
		$this->query = $dbConceptoCta ->query;
		return $res;
	}

	/// --------------------- fin tpr_concepto_cta --------------------- ///

	/// --------------------- inicio tpr_nivel_partida --------------------- ///
	function ListarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ListarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	function ContarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ContarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	function InsertarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->InsertarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	function ModificarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ModificarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	function EliminarNivelPartida($id_nivel_partida)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida -> EliminarNivelPartida($id_nivel_partida);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	function ValidarNivelPartida($operacion_sql,$id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ValidarNivelPartida($operacion_sql,$id_nivel_partida,$nivel,$dig_nivel,$id_parametro,$tipo_nivel);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}

	/// --------------------- fin tpr_nivel_partida --------------------- ///


	/// --------------------- Inicio categoria --------------------- ///
	function ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	function ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	function InsertarCategoria($id_categoria,$desc_categoria,$cod_categoria,$estado)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->InsertarCategoria($id_categoria,$desc_categoria,$cod_categoria,$estado);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	function ModificarCategoria($id_categoria,$desc_categoria,$cod_categoria,$estado)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ModificarCategoria($id_categoria,$desc_categoria,$cod_categoria,$estado);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	function EliminarCategoria($id_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria -> EliminarCategoria($id_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	function ValidarCategoria($operacion_sql,$id_categoria,$desc_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ValidarCategoria($operacion_sql,$id_categoria,$desc_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}

	/// --------------------- fin tpr_categoria --------------------- ///

	function ListarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_moneda)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ListarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_moneda);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	function ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	function InsertarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->InsertarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	function ModificarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ModificarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda,$tipo_destino);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	function EliminarDestino($id_destino)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino -> EliminarDestino($id_destino);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	function ValidarDestino($operacion_sql,$id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ValidarDestino($operacion_sql,$id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}

	/// --------------------- fin tpr_destino --------------------- ///

	/// --------------------- tpr_cobertura --------------------- ///

	function ListarCobertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura ->ListarCobertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}

	function ContarCobertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura ->ContarCobertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}

	function InsertarCobertura($id_cobertura,$porcentaje,$sw_hotel,$descripcion,$via)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura ->InsertarCobertura($id_cobertura,$porcentaje,$sw_hotel,$descripcion,$via);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}

	function ModificarCobertura($id_cobertura,$porcentaje,$sw_hotel,$descripcion,$via)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura ->ModificarCobertura($id_cobertura,$porcentaje,$sw_hotel,$descripcion,$via);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}
	
	function EliminarCobertura($id_cobertura)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura -> EliminarCobertura($id_cobertura);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}

	function ValidarCobertura($operacion_sql,$id_cobertura,$porcentaje,$sw_hotel)
	{
		$this->salida = "";
		$dbCobertura = new cls_DBCobertura($this->decodificar);
		$res = $dbCobertura ->ValidarCobertura($operacion_sql,$id_cobertura,$porcentaje,$sw_hotel);
		$this->salida = $dbCobertura ->salida;
		$this->query = $dbCobertura ->query;
		return $res;
	}

	/// --------------------- fin tpr_cobertura --------------------- ///

	/// --------------------- tpr_partida --------------------- ///

	function ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	function ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarParField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarParField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarParField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarParField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarParFieldGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarParFieldGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarParFieldGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarParFieldGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarParFieldCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarParFieldCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarParFieldCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarParFieldCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarServField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarServField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarServField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarServField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
/////////////////////////////	
	function ListarRepMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepGralMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	/*function ListarCabMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}*/
	function SumaCostoMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
//////////////////////////	
function ListarRepMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepGralMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarCabMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaInversion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
//////////////////////////	
	function ListarRepMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ContarRepGralMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarCabMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaCalculoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
//////////////////////////	
	function ListarRepMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ContarRepGralMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ListarCabMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaCalculoOtros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
//////////////////////////	
	function ListarRepMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepGralMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ListarCabMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaCalculoIngreso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
//////////////////////////	
	function ListarRepMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ListarRepGralMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ContarRepGralMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ListarCabMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaCalculoViaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
//////////////////////////	
	function ListarRepMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ListarRepGralMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarRepGralMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function ContarRepGralMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarRepGralMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}	
	function ListarCabMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	function SumaCostoMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->SumaCostoMemoriaCalculoPasaje($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
//////////////////////////			
	function InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	function ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	function EliminarPartida($id_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida -> EliminarPartida($id_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	function ValidarPartida($operacion_sql,$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ValidarPartida($operacion_sql,$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	/// --------------------- fin tpr_partida --------------------- ///

	/// --------------------- tpr_partida_cuenta --------------------- ///
	
	function ListarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ListarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function ContarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ContarCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function ListarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ListarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function ContarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ContarPartidaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}
	function InsertarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->InsertarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function ModificarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ModificarPartidaCuenta($id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function EliminarPartidaCuenta($id_partida_cuenta)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta -> EliminarPartidaCuenta($id_partida_cuenta);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	function ValidarPartidaCuenta($operacion_sql,$id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega)
	{
		$this->salida = "";
		$dbPartidaCuenta = new cls_DBPartidaCuenta($this->decodificar);
		$res = $dbPartidaCuenta ->ValidarPartidaCuenta($operacion_sql,$id_partida_cuenta,$sw_deha,$id_partida,$id_cuenta,$id_parametro,$sw_rega);
		$this->salida = $dbPartidaCuenta ->salida;
		$this->query = $dbPartidaCuenta ->query;
		return $res;
	}

	/// --------------------- fin tpr_partida --------------------- ///



	/// --------------------- tpr_mem_inversion_gasto --------------------- ///

	function ListarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ListarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function ListarCabMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = ""; 
		$dbPartida = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbPartida ->ListarCabMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}

	function ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}

	function InsertarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->InsertarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}

	function ModificarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ModificarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}

	function EliminarMemoriaGasto($id_mem_inversion_gasto)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto -> EliminarMemoriaGasto($id_mem_inversion_gasto);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}

	function ValidarMemoriaGasto($operacion_sql,$id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ValidarMemoriaGasto($operacion_sql,$id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda,$total_general);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}

	/// --------------------- fin tpr_mem_inversion_gasto --------------------- ///

	/// --------------------- tpr_mem_rrhh --------------------- ///

	function ListarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ListarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	function ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	function InsertarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->InsertarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	function ModificarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ModificarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	function EliminarRrhhGasto($id_mem_rrhh)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh -> EliminarRrhhGasto($id_mem_rrhh);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	function ValidarRrhhGasto($operacion_sql,$id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ValidarRrhhGasto($operacion_sql,$id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}

	/// --------------------- fin tpr_mem_rrhh --------------------- ///

	/// --------------------- tpr_mem_servicio --------------------- ///

	function ListarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ListarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function ListarGrillaMemCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio -> ListarGrillaMemCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}

	function ContarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ContarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function ListarRepMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ListarRepMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function ListarRepGralMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ListarRepGralMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function ContarRepMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ContarRepMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function ContarRepGralMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ContarRepGralMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function ListarCabMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ListarCabMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function SumaCostoMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->SumaCostoMemoriaServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	function InsertarServicioGasto($id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->InsertarServicioGasto($id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda,$tipo_insercion);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}

	function ModificarServicioGasto($id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ModificarServicioGasto($id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda,$tipo_insercion);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}

	function EliminarServicioGasto($id_mem_servicio)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio -> EliminarServicioGasto($id_mem_servicio);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}

	function ValidarServicioGasto($operacion_sql,$id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ValidarServicioGasto($operacion_sql,$id_mem_servicio,$total_general,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}

	/// --------------------- fin tpr_mem_servicio --------------------- ///

	/// --------------------- tpr_mem_viaje --------------------- ///

	function ListarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ListarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	function ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	function InsertarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->InsertarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	function ModificarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ModificarViajeGasto($id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	function EliminarViajeGasto($id_mem_viaje)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje -> EliminarViajeGasto($id_mem_viaje);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	function ValidarViajeGasto($operacion_sql,$id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ValidarViajeGasto($operacion_sql,$id_mem_viaje,$nro_dias,$importe_viaticos,$importe_hotel,$importe_otros,$periodo_pres,$id_moneda,$id_cobertura,$id_memoria_calculo,$total_viaticos,$total_hotel,$total_general,$id_mem_pasaje);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}

	/// --------------------- fin tpr_mem_viaje --------------------- ///

	/// --------------------- tpr_memoria_calculo --------------------- ///

	function ListarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ListarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	function ListarCabeceraMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ListarCabeceraMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function ContarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ContarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	function InsertarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto,$id_moneda)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->InsertarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto,$id_moneda);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	function ModificarMemoriaCalculo($id_memoria_calculo, $id_concepto_ingas,$justificacion,$id_partida_presupuesto,$tipo_detalle,$id_moneda)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ModificarMemoriaCalculo($id_memoria_calculo, $id_concepto_ingas,$justificacion,$id_partida_presupuesto,$tipo_detalle,$id_moneda);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	function EliminarMemoriaCalculo($id_memoria_calculo)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo -> EliminarMemoriaCalculo($id_memoria_calculo);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	function ValidarMemoriaCalculo($operacion_sql,$id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto,$id_moneda)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ValidarMemoriaCalculo($operacion_sql,$id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto,$id_moneda);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}

	/// --------------------- fin tpr_memoria_calculo --------------------- ///

	/// --------------------- tpr_partida_presupuesto --------------------- ///

	function ListarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ListarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function ContarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ContarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function InsertarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->InsertarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function ModificarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ModificarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function EliminarDetalleParidaFormulacion($id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto -> EliminarDetalleParidaFormulacion($id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function ValidarDetalleParidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ValidarDetalleParidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	/// --------------------- fin tpr_partida_presupuesto --------------------- ///


	/// --------------------- tpr_presupuesto --------------------- ///

	function ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	function ContarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ListarPresupuestoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarPresupuestoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	function ContarPresupuestoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarPresupuestoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	function ListarComboPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarComboPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	function ContarComboPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarComboPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ListarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ContarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarPresupuestoSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ListarPresupuestoVar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarPresupuestoVar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	function ContarPresupuestoVar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarPresupuestoVar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function InsertarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
			//jun2015
			,$obliga_ot
			)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->InsertarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
				//jun2015
				,$obliga_ot
				);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
 	function InsertarPresupuestoColectivoPartida($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_concepto_colectivo,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto->InsertarPresupuestoColectivoPartida($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_concepto_colectivo,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	} 
	
	function InsertarFormulacionPresupuestoPlantilla($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
			//jun2015
			,$obliga_ot
			)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->InsertarFormulacionPresupuestoPlantilla($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
				//jun2015
				,$obliga_ot
				);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	//function ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro )
	function ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
			//jun2015
			,$obliga_ot
			)								
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		//$res = $dbPresupuesto ->ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro );
		$res = $dbPresupuesto ->ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$cod_fin,$cod_prg,$cod_proy,$cod_act,$id_categoria_prog
				//
				,$obliga_ot
				);
		
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	function EliminarFormulacionPresupuesto($id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto -> EliminarFormulacionPresupuesto($id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
											
	function ValidarFormulacionPresupuesto($operacion_sql,$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro ,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ValidarFormulacionPresupuesto($operacion_sql,$id_presupuesto,$tipo_pres,$estado_pres,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}	
	function ValidarCambiarEstado($id_presupuesto,$estado_pres)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ValidarCambiarEstado($id_presupuesto,$estado_pres);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ModificarEstado($id_presupuesto, $estado_pres)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ModificarEstado($id_presupuesto, $estado_pres);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function RevertirPasaje($id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->RevertirPasaje($id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	/// --------------------- fin tpr_presupuesto --------------------- ///
	
	/// --------------------- presupuesto_vigente -MFLORES- 29-07-11 --------------------- ///
	
	function PresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->PresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}	
	
	function DetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto -> DetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}	
	
	function ContarDetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarDetallePresupuestoVigente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_presupuesto,$id_partida,$id_moneda,$id_partida_modificacion,$id_partida_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}	
	
	function InsertarPartidaDetalleModificacion($id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->InsertarPartidaDetalleModificacion($id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ModificarPartidaDetalleModificacion($id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ModificarPartidaDetalleModificacion($id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ValidarPartidaDetalleModificacion($operacion_sql,$id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ValidarPartidaDetalleModificacion($operacion_sql,$id_partida_detalle_modificacion,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda,$id_partida_modificacion,$id_partida,$id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ContarPresupuestoVigenteSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarPresupuestoVigenteSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ListarPresupuestoVigenteSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarPresupuestoVigenteSuma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function CambiarEstadoPresupuesto($id_presupuesto,$accion)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->CambiarEstadoPresupuesto($id_presupuesto,$accion);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}

	/// --------------------- fin presupuesto_vigente --------------------- ///


	/// --------------------- tpr_fuente_financiamiento --------------------- ///

	function ListarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento ->ListarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	function ContarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento ->ContarFuenteFinanciamiento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	function InsertarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento ->InsertarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	function ModificarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento ->ModificarFuenteFinanciamiento($id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	function EliminarFuenteFinanciamiento($id_fuente_financiamiento)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento -> EliminarFuenteFinanciamiento($id_fuente_financiamiento);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	function ValidarFuenteFinanciamiento($operacion_sql,$id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbFuenteFinanciamiento = new cls_DBFuenteFinanciamiento($this->decodificar);
		$res = $dbFuenteFinanciamiento ->ValidarFuenteFinanciamiento($operacion_sql,$id_fuente_financiamiento,$codigo_fuente,$denominacion,$descripcion,$sigla);
		$this->salida = $dbFuenteFinanciamiento ->salida;
		$this->query = $dbFuenteFinanciamiento ->query;
		return $res;
	}

	/// --------------------- fin tpr_fuente_financiamiento --------------------- ///
	
	/// --------------------- tpr_actividad --------------------- ///

	function ListarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ListarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	function ContarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ContarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	function InsertarActividad($id_actividad,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->InsertarActividad($id_actividad,$codigo,$descripcion,$sigla);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	function ModificarActividad($id_actividad,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ModificarActividad($id_actividad,$codigo,$descripcion,$sigla);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	function EliminarActividad($id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad -> EliminarActividad($id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	function ValidarActividad($operacion_sql,$id_actividad,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ValidarActividad($operacion_sql,$id_actividad,$codigo,$descripcion,$sigla);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}

	/// --------------------- fin tpr_actividad --------------------- ///
	
	/// --------------------- tpr_programa --------------------- ///

	function ListarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ListarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	function ContarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ContarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	function InsertarPrograma($id_programa,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->InsertarPrograma($id_programa,$codigo,$descripcion,$sigla);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	function ModificarPrograma($id_programa,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ModificarPrograma($id_programa,$codigo,$descripcion,$sigla);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	function EliminarPrograma($id_programa)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma -> EliminarPrograma($id_programa);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	function ValidarPrograma($operacion_sql,$id_programa,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ValidarPrograma($operacion_sql,$id_programa,$codigo,$descripcion,$sigla);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}

	/// --------------------- fin tpr_programa --------------------- ///
	
	/// --------------------- tpr_proyecto --------------------- ///

	function ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	function ContarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ContarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	function InsertarProyecto($id_proyecto,$codigo,$descripcion,$sigla,$codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->InsertarProyecto($id_proyecto,$codigo,$descripcion,$sigla,$codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	function ModificarProyecto($id_proyecto,$codigo,$descripcion,$sigla,$codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ModificarProyecto($id_proyecto,$codigo,$descripcion,$sigla,$codigo_sisin, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	function EliminarProyecto($id_proyecto)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto -> EliminarProyecto($id_proyecto);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	function ValidarProyecto($operacion_sql,$id_proyecto,$codigo,$descripcion,$sigla, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ValidarProyecto($operacion_sql,$id_proyecto,$codigo,$descripcion,$sigla, $sector_economico, $subsector_economico, $activ_eco, $departamento, $provincia, $seccion_mun, $sisin, $pnd);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}

	/// --------------------- fin tpr_proyecto --------------------- ///
	
	/// --------------------- tpr_organismo_fin --------------------- ///

	function ListarOrganismoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin ->ListarOrganismoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	function ContarOrganismoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin ->ContarOrganismoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	function InsertarOrganismoFin($id_organismo_fin,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin ->InsertarOrganismoFin($id_organismo_fin,$codigo,$descripcion,$sigla);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	function ModificarOrganismoFin($id_organismo_fin,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin ->ModificarOrganismoFin($id_organismo_fin,$codigo,$descripcion,$sigla);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	function EliminarOrganismoFin($id_organismo_fin)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin -> EliminarOrganismoFin($id_organismo_fin);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	function ValidarOrganismoFin($operacion_sql,$id_organismo_fin,$codigo,$descripcion,$sigla)
	{
		$this->salida = "";
		$dbOrganismoFin = new cls_DBOrganismoFin($this->decodificar);
		$res = $dbOrganismoFin ->ValidarOrganismoFin($operacion_sql,$id_organismo_fin,$codigo,$descripcion,$sigla);
		$this->salida = $dbOrganismoFin ->salida;
		$this->query = $dbOrganismoFin ->query;
		return $res;
	}

	/// --------------------- fin tpr_organismo_fin --------------------- ///
	
/// --------------------- tpr_categoria_prog --------------------- ///

	function ListarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg ->ListarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	function ContarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg ->ContarCategoriaProg($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	function InsertarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg ->InsertarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	function ModificarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg ->ModificarCategoriaProg($id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro,$descripcion,$estado);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	function EliminarCategoriaProg($id_categoria_prog)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg -> EliminarCategoriaProg($id_categoria_prog);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	function ValidarCategoriaProg($operacion_sql,$id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro)
	{
		$this->salida = "";
		$dbCategoriaProg = new cls_DBCategoriaProg($this->decodificar);
		$res = $dbCategoriaProg ->ValidarCategoriaProg($operacion_sql,$id_categoria_prog,$id_programa,$id_proyecto,$id_actividad,$id_organismo_fin,$id_fuente_financiamiento,$id_parametro);
		$this->salida = $dbCategoriaProg ->salida;
		$this->query = $dbCategoriaProg ->query;
		return $res;
	}
	
	/// --------------------- tpr_partida_presupuesto --------------------- ///

	function ListarDetallePartidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ListarDetallePartidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
											
	function ContarDetallePartidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ContarDetallePartidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);

		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function InsertarDetallePartidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->InsertarDetallePartidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}


	function InsertarPartidaPresupuestoAsignacion($id_partida_presupuesto, $codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->InsertarPartidaPresupuestoAsignacion($id_partida_presupuesto, $codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	function ModificarDetallePartidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ModificarDetallePartidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function EliminarDetallePartidaFormulacion($id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto -> EliminarDetallePartidaFormulacion($id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	function  EliminarDetallePartidaAsignacion($id_partida,$id_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->  EliminarDetallePartidaAsignacion($id_partida,$id_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	function ValidarDetallePartidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ValidarDetallePartidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total,$id_partida_presupuesto,$id_moneda);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	function ValidarDetallePartidaAsignacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto)
	{
		 
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ValidarDetallePartidaAsignacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}

	/// --------------------- fin tpr_partida_presupuesto --------------------- ///


	/// --------------------- tpr_mem_ingreso --------------------- ///

	function ListarRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso ->ListarRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	function ContarRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso ->ContarRecurso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	function InsertarRecurso($id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso ->InsertarRecurso($id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	function ModificarRecurso($id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso ->ModificarRecurso($id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general,$tipo_insercion);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	function EliminarRecurso($id_mem_ingreso)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso -> EliminarRecurso($id_mem_ingreso);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	function ValidarRecurso($operacion_sql,$id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general)
	{
		$this->salida = "";
		$dbMemIngreso = new cls_DBMemIngreso($this->decodificar);
		$res = $dbMemIngreso ->ValidarRecurso($operacion_sql,$id_mem_ingreso,$periodo_pres,$id_memoria_calculo,$id_moneda,$total_general);
		$this->salida = $dbMemIngreso ->salida;
		$this->query = $dbMemIngreso ->query;
		return $res;
	}

	/// --------------------- fin tpr_mem_ingreso --------------------- ///


	/**********************************************************/
	/**************ASignacion del Partidas Presupuestarias***********************/
	function ListarDetallePartidaAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarDetallePartidaAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;

		return $res;
	}

	function ListarDetallePartidaAsignacionRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_presupuesto)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarDetallePartidaAsignacionRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_presupuesto);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}

	function ListarMetaprocesoHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	function ListarMetaprocesoRaizAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRaizAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}

	function ListarMetaprocesoRamaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRamaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}

	function ListarMetaprocesoHojaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBPartidaArb($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoHojaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	/// --------------------- PARTIDA ARB --------------------- ///

	function ListarPartidaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->ListarPartidaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador,$gestion);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function ListarPartidaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->ListarPartidaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function ListarPartidaIngresoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->ListarPartidaIngresoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$gestion);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function ContarPartidaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->ContarPartidaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$gestion);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function InsertarPartidaRaiz($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->InsertarPartidaRaiz($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function InsertarPartidaArb($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->InsertarPartidaArb($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function ModificarPartidaArb($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->ModificarPartidaArb($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida,$sw_movimiento,$id_concepto_colectivo,$id_oec_sigma,$ent_trf,$cod_ascii,$cod_excel,$cod_trans);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function EliminarPartidaArb($id_partida,$id_partida_padre)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb -> EliminarPartidaArb($id_partida,$id_partida_padre);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	function EliminarPartidaRaiz($id_partida)
	{
		$this->salida = "";
		$dbPartidaArb = new cls_DBPartidaArb($this->decodificar);
		$res = $dbPartidaArb ->EliminarPartidaRaiz($id_partida);
		$this->salida = $dbPartidaArb ->salida;
		$this->query = $dbPartidaArb ->query;
		return $res;
	}
	/// --------------------- FIN PARTIDA ARB --------------------- ///
	
	/// --------------------- tpr_param_tcam --------------------- ///

	function ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam ->ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	function ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam ->ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	function InsertarTipoCambio($id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam ->InsertarTipoCambio($id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	function ModificarTipoCambio($id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam ->ModificarTipoCambio($id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	function EliminarTipoCambio($id_param_tcam)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam -> EliminarTipoCambio($id_param_tcam);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	function ValidarTipoCambio($operacion_sql,$id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio)
	{
		$this->salida = "";
		$dbParamTcam = new cls_DBParamTcam($this->decodificar);
		$res = $dbParamTcam ->ValidarTipoCambio($operacion_sql,$id_param_tcam,$id_parametro,$id_moneda_int,$tipo_cambio);
		$this->salida = $dbParamTcam ->salida;
		$this->query = $dbParamTcam ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_param_tcam --------------------- ///
	
	/// --------------------- tpr_combustible --------------------- ///

	function ListarCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible ->ListarCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}
	
	function ContarCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible ->ContarCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}
	
	function InsertarCombustible($id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible ->InsertarCombustible($id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}
	
	function ModificarCombustible($id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible ->ModificarCombustible($id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}
	
	function EliminarCombustible($id_combustible)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible -> EliminarCombustible($id_combustible);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}
	
	function ValidarCombustible($operacion_sql,$id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado)
	{
		$this->salida = "";
		$dbCombustible = new cls_DBCombustible($this->decodificar);
		$res = $dbCombustible ->ValidarCombustible($operacion_sql,$id_combustible,$id_parametro,$id_moneda,$consumo_preferencial,$precio_preferencial,$descripcion,$precio_mercado);
		$this->salida = $dbCombustible ->salida;
		$this->query = $dbCombustible ->query;
		return $res;
	}	
	/// --------------------- fin tpr_combustible --------------------- ///
	
	/// --------------------- tpr_mem_combustible --------------------- ///
	function ListarMemoriaCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible ->ListarMemoriaCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}
	
	function ContarMemoriaCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible ->ContarMemoriaCombustible($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}
	
	function InsertarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible ->InsertarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}
	
	function ModificarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible ->ModificarMemoriaCombustible($id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general,$tipo_insercion);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}
	
	function EliminarMemoriaCombustible($id_mem_combustible)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible -> EliminarMemoriaCombustible($id_mem_combustible);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}
	
	function ValidarMemoriaCombustible($operacion_sql,$id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general)
	{
		$this->salida = "";
		$dbMemCombustible = new cls_DBMemCombustible($this->decodificar);
		$res = $dbMemCombustible ->ValidarMemoriaCombustible($operacion_sql,$id_mem_combustible,$id_memoria_calculo,$id_moneda,$id_combustible,$periodo_pres,$cantidad_combustible,$cantidad_preferencial,$precio_preferencial,$cantidad_mercado,$precio_mercado,$costo_preferencial,$costo_mercado,$costo_total,$porcentaje,$total_general);
		$this->salida = $dbMemCombustible ->salida;
		$this->query = $dbMemCombustible ->query;
		return $res;
	}	
	/// --------------------- fin tpr_mem_combustible --------------------- ///
	
	/// --------------------- tpr_partida_traspaso --------------------- ///

	function ListarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ListarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ListarReporteTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarReporteTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ListarReporteIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarReporteIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ContarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ContarPartidaTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ContarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ContarPartidaIncremento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function InsertarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->InsertarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ModificarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ModificarPartidaTraspaso($id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion,$id_parametro,$tipo_pres,$id_partida_origen,$id_partida_destino,$id_presupuesto_origen,$id_presupuesto_destino,$tipo_traspaso);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}	
	function ModificarPartidaTraspasoConcluido($id_partida_traspaso,$fecha_conclusion)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ModificarPartidaTraspasoConcluido($id_partida_traspaso,$fecha_conclusion);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function EliminarPartidaTraspaso($id_partida_traspaso)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso -> EliminarPartidaTraspaso($id_partida_traspaso);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ValidarPartidaTraspaso($operacion_sql,$id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ValidarPartidaTraspaso($operacion_sql,$id_partida_traspaso,$id_partida_presupuesto_origen,$id_partida_presupuesto_destino,$id_partida_ejecucion_origen,$id_partida_ejecucion_destino,$id_usu_autorizado_origen,$id_usu_autorizado_destino,$id_usu_autorizado_registro,$id_moneda,$importe_traspaso,$estado_traspaso,$fecha_traspaso,$fecha_conclusion,$justificacion);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function CambiarEstadoPartidaTraspaso($id_partida_traspaso,$accion)
	{		
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso -> CambiarEstadoPartidaTraspaso($id_partida_traspaso,$accion);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ListarResumenTraspasosAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarResumenTraspasosAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	function ListarDetalleTraspasosPorFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso,$id_presupuesto_destino,$id_uo_destino,$id_proyecto_destino)
	{
		$this->salida = "";
		$dbPartidaTraspaso = new cls_DBPartidaTraspaso($this->decodificar);
		$res = $dbPartidaTraspaso ->ListarDetalleTraspasosPorFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$tipo_traspaso,$id_presupuesto_destino,$id_uo_destino,$id_proyecto_destino);
		$this->salida = $dbPartidaTraspaso ->salida;
		$this->query = $dbPartidaTraspaso ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_partida_traspaso --------------------- ///
	
	function ListarEjecucionPorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_fin,$fecha_ini,$tipo_pres,$id_moneda,$id_categoria_prog)
	{
		$this->salida = "";
		$dbParametro = new cls_DBlListarEjecucionPartida($this->decodificar);
		$res = $dbParametro ->ListarEjecucionPorPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_fin,$fecha_ini,$tipo_pres,$id_moneda,$id_categoria_prog);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	/*function ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini,$id_presupuesto)
	{
		$this->salida = "";
		$dblistarEjecucionInstitucional = new cls_DBListarEjecucionInstitucional($this->decodificar);
		$res = $dblistarEjecucionInstitucional ->ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$tipo_pres ,$id_parametro,$id_moneda,$ids_fuente_financiamiento,$ids_u_o,$ids_financiador,$ids_regional,$ids_programa,$ids_proyecto,$ids_actividad,$sw_vista,$ids_concepto_colectivo,$fecha_fin,$fecha_ini,$id_presupuesto);
		$this->salida = $dblistarEjecucionInstitucional ->salida;
		$this->query = $dblistarEjecucionInstitucional ->query;
		return $res;
	}*/
	function ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_moneda,$fecha_fin,$fecha_ini,$id_presupuesto)
	{
		$this->salida = "";
		$dblistarEjecucionInstitucional = new cls_DBListarEjecucionInstitucional($this->decodificar);
		$res = $dblistarEjecucionInstitucional ->ListarEjecucionInstitucional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_moneda,$fecha_fin,$fecha_ini,$id_presupuesto);
		$this->salida = $dblistarEjecucionInstitucional ->salida;
		$this->query = $dblistarEjecucionInstitucional ->query;
		return $res;
	}
	function ListarEjecucionInstitucionalPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_presupuesto)
	{
		$this->salida = "";
		$dblistarEjecucionInstitucional = new cls_DBListarEjecucionInstitucional($this->decodificar);
		$res = $dblistarEjecucionInstitucional ->ListarEjecucionInstitucionalPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$tipo_pres ,$id_parametro,$id_presupuesto);
		$this->salida = $dblistarEjecucionInstitucional ->salida;
		$this->query = $dblistarEjecucionInstitucional ->query;
		return $res;
	}
	
	/// --------------------- tpr_modificacion --------------------- ///

	function ListarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->ListarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function ContarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->ContarModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function InsertarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->InsertarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function ModificarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->ModificarModificacion($id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function ModificarModificacionSigma($id_modificacion,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->ModificarModificacionSigma($id_modificacion,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function EliminarModificacion($id_modificacion)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion -> EliminarModificacion($id_modificacion);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function ValidarModificacion($operacion_sql,$id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha)
	{
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion ->ValidarModificacion($operacion_sql,$id_modificacion,$id_parametro,$tipo_modificacion,$justificacion,$tipo_presupuesto,$nro_modificacion,$estado_modificacion,$fecha_regis,$fecha_conclusion,$id_usuario_reg,$id_periodo,$docmod_tipo,$docmod_nro,$docmod_fecha,$docdis_tipo,$docdis_nro,$docdis_fecha);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	function CambiarEstadoModificacion($id_modificacion,$accion,$tipo_modificacion)
	{		
		$this->salida = "";
		$dbModificacion = new cls_DBModificacion($this->decodificar);
		$res = $dbModificacion -> CambiarEstadoModificacion($id_modificacion,$accion,$tipo_modificacion);
		$this->salida = $dbModificacion ->salida;
		$this->query = $dbModificacion ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_modificacion --------------------- ///
	
	/// --------------------- tpr_partida_modificacion --------------------- ///

	function ListarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion ->ListarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	function ContarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion ->ContarPartidaModificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	function InsertarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion ->InsertarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	function ModificarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion ->ModificarPartidaModificacion($id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg,$id_partida,$id_presupuesto,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$total);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	function EliminarPartidaModificacion($id_partida_modificacion)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion -> EliminarPartidaModificacion($id_partida_modificacion);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	function ValidarPartidaModificacion($operacion_sql,$id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg)
	{
		$this->salida = "";
		$dbPartidaModificacion = new cls_DBPartidaModificacion($this->decodificar);
		$res = $dbPartidaModificacion ->ValidarPartidaModificacion($operacion_sql,$id_partida_modificacion,$id_modificacion,$id_partida_presupuesto,$id_usuario_autorizado,$id_partida_ejecucion,$tipo_modificacion,$id_moneda,$importe,$estado,$id_usuario_reg,$fecha_reg);
		$this->salida = $dbPartidaModificacion ->salida;
		$this->query = $dbPartidaModificacion ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_partida_modificacion --------------------- ///
	
	//estadisticas
	function ListarEstadisticasSistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_subsistema,$id_usuario,$gestion)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEstadisticasSistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_subsistema,$id_usuario,$gestion);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}
	function ListarEstadisticasUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_subsistema,$id_usuario,$gestion)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEstadisticasUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_subsistema,$id_usuario,$gestion);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}	
	
	function ListarEjecucionTrimestral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEjecucionTrimestral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res; 
	}	
	function ListarEjecucionMatrizProyectos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEjecucionMatrizProyectos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}		
	
	function ListarEjecucionMensual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEjecucionMensual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}
	function ListarEjecucionMensualAcumulada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEjecucionMensualAcumulada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}
	function ListarEjecucionFisicaFinanciera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog)
	{
		$this->salida = "";
		$dbEstadisticas = new cls_DBEstadisticas($this->decodificar);
		$res = $dbEstadisticas ->ListarEjecucionFisicaFinanciera($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_parametro,$fecha_ini,$fecha_fin,$tipo_pres1,$id_moneda,$filtro,$id_presupuesto,$id_uo,$id_categoria_prog);
		$this->salida = $dbEstadisticas ->salida;
		$this->query = $dbEstadisticas ->query;
		return $res;
	}
	//fin estadisticas	
	
	// Tipo_presupuesto_gestion
	function ListarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoPresGestion = new cls_DBTipoPresGestion($this->decodificar);
		$res = $dbTipoPresGestion ->ListarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoPresGestion ->salida;
		$this->query = $dbTipoPresGestion ->query;
		return $res;
	}
	
	function ContarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoPresGestion = new cls_DBTipoPresGestion($this->decodificar);
		$res = $dbTipoPresGestion ->ContarTipoPresGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoPresGestion ->salida;
		$this->query = $dbTipoPresGestion ->query;
		return $res;
	}
	
	//
	/// --------------------- Inicio ejecucion_fisica --------------------- ///
	function ListarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEjecucionFisica= new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->ListarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}
	
	

	function ContarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->ContarEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}
	
	function ListarReporteEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->ListarReporteEjecucionFisica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}	

	function InsertarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->InsertarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}

	function ModificarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->ModificarEjecucionFisica($id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado,$justificacion_fisica,$justificacion_financiera,$acciones_fisica,$acciones_financiera,$problemas_fisica,$tiempo_solucion);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}

	function EliminarEjecucionFisica($id_ejecucion_fisica)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica -> EliminarEjecucionFisica($id_ejecucion_fisica);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}

	function ValidarEjecucionFisica($operacion_sql,$id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado)
	{
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica ->ValidarEjecucionFisica($operacion_sql,$id_ejecucion_fisica,$id_parametro,$id_proyecto,$periodo_pres,$porcentaje_ejecucion,$estado);
		$this->salida = $dbEjecucionFisica ->salida;
		$this->query = $dbEjecucionFisica ->query;
		return $res;
	}
	function CambiarEstadoEjecucionFisica($id_ejecucion_fisica,$accion)
	{		
		$this->salida = "";
		$dbEjecucionFisica = new cls_DBEjecucionFisica($this->decodificar);
		$res = $dbEjecucionFisica -> CambiarEstadoEjecucionFisica($id_ejecucion_fisica,$accion);
		$this->salida = $dbEjecucionFisica -> salida;
		$this->query = $dbEjecucionFisica -> query;
		return $res;
	}
	//------------------- fin tfl_Adjunto ------------------\\
	
	function ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_proyecto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ListarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto,$id_proyecto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_proyecto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ContarAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_proyecto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_proyecto,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$desc_persona,$tamano_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> InsertarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_proyecto,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$desc_persona,$tamano_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_proyecto,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$tamano_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ModificarAdjunto($id_adjunto,$nombre_doc,$observacion,$id_proyecto,$tipo_adjunto,$nombre_arch,$extension,$nombre_original,$tamano_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ModificarAdjuntoGrilla($id_adjunto,$nombre_doc,$observacion,$id_proyecto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ModificarAdjuntoGrilla($id_adjunto,$nombre_doc,$observacion,$id_proyecto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function EliminarAdjunto($id_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> EliminarAdjunto($id_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function ValidarAdjunto($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$id_proyecto,$nombre_arch,$extension)	
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> ValidarAdjunto($operacion_sql,$id_adjunto,$nombre_doc,$observacion,$id_proyecto,$nombre_arch,$extension);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;	
	}
	
	function SelIdAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto)
	{
		$this->salida = "";
		$dbflujo = new cls_DBAdjunto($this->decodificar);
		$res = $dbflujo -> SelIdAdjunto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_adjunto);
		$this->salida = $dbflujo ->salida;
		$this->query = $dbflujo ->query;
		return $res;
	}
	function ListarDetallePartidaComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_presupuesto,$id_partida)
	         
	{
		$this->salida = "";
		$dbParametro = new cls_DBListarEjecucionPartidaDetalle($this->decodificar);
		$res = $dbParametro ->ListarDetallePartidaComprometido($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad ,$id_presupuesto,$id_partida);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}	
	//Añadido por Ana Maria Villegas
	function VerificarPresUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$id_usuario)
	{
		$this->salida = "";
		$dbVerificarPresto = new cls_DBVerificarPresto($this->decodificar);
		$res = $dbVerificarPresto -> VerificarPresUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto,$id_usuario);
		$this->salida = $dbVerificarPresto ->salida;
		$this->query = $dbVerificarPresto ->query;
		return $res;
	}
	function VerificarDepUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto)
	{
		$this->salida = "";
		$dbVerificarPresto = new cls_DBVerificarPresto($this->decodificar);
		$res = $dbVerificarPresto -> VerificarDepUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_depto);
		$this->salida = $dbVerificarPresto ->salida;
		$this->query = $dbVerificarPresto ->query;
		return $res;
	}
	function VerificarDepEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto)
	{
		$this->salida = "";
		$dbVerificarPresto = new cls_DBVerificarPresto($this->decodificar);
		$res = $dbVerificarPresto -> VerificarDepEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_presupuesto);
		$this->salida = $dbVerificarPresto ->salida;
		$this->query = $dbVerificarPresto ->query;
		return $res;
	}
	//Reportes a Irport
	function ListarDatos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_admi,$sw_listado,$id_parametro,$ids_tipo)
	{
		$this->salida = "";
		$dbDatos = new cls_DBRepEjecuta($this->decodificar);
		$res = $dbDatos ->ListarDatos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_admi,$sw_listado,$id_parametro,$ids_tipo);
		$this->salida = $dbDatos ->salida;
		$this->query = $dbDatos ->query;
		return $res;
	}
	
	function ContarDatos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_admi,$sw_listado,$id_parametro,$ids_tipo)
	{
		$this->salida = "";
		$dbDatos = new cls_DBRepEjecuta($this->decodificar);
		$res = $dbDatos ->ContarDatos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$sw_admi,$sw_listado,$id_parametro,$ids_tipo);
		$this->salida = $dbDatos ->salida;
		$this->query = $dbDatos ->query;
		return $res;
	}
	
	/**************************************************Vista de CAIFF*************************************/
	function ContarCaiff($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->ContarCaiff($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	
	function ListarCaiff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->ListarCaiff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$hidden_ep_id_financiador,$hidden_ep_id_regional,$hidden_ep_id_programa,$hidden_ep_id_proyecto,$hidden_ep_id_actividad);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	
	function ValidarCaiff($sql,$id_caiff,$id_gestion,$id_periodo,$descripcion)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->ValidarCaiff($sql,$id_caiff,$id_gestion,$id_periodo,$descripcion);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	
	function InsertarCaiff($id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->InsertarCaiff($id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function ModificarCaiff($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->ModificarCaiff($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function EliminarCaiff($id_caiff)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->EliminarCaiff($id_caiff);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	
	function MigrarSP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->MigrarSP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function MigrarCP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->MigrarCP($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function Validar_1($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->Validar_1($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function Validar_2($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->Validar_2($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	function Validar_3($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->Validar_3($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
       function Validar_4($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado)
	{
		$this->salida = "";
		$dbCaiff = new cls_DBCaiff($this->decodificar);
		$res = $dbCaiff ->Validar_4($id_caiff,$id_gestion,$id_periodo,$descripcion,$fecha_ini,$fecha_fin,$estado);
		$this->salida = $dbCaiff ->salida;
		$this->query = $dbCaiff ->query;
		return $res;
	}
	/**************************************************FIN Vista CAIFF*************************************/
	
	function ListarSietDeclara($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ListarSietDeclara($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function ContarSietDeclara($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ContarSietDeclara($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	
	
	function InsertarSietDeclara($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->InsertarSietDeclara($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function ModificarSietDeclaraFinalizar($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ModificarSietDeclaraFinalizar($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function ModificarSietDeclara($id_siet_declara,$gestion,$periodo,$tipo_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ModificarSietDeclara($id_siet_declara,$gestion,$periodo,$tipo_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function EliminarSietDeclara($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->EliminarSietDeclara($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function ValidarSietDeclara($operacion_sql,$id_siet_declara,$gestion,$periodo)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ValidarSietDeclara($operacion_sql,$id_siet_declara,$gestion,$periodo);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function InsertarSietCbtesPartidas($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietCbtePartida ->InsertarSietCbtesPartidas($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	function InsertarSietCbtesPartidasRecurso($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietCbtePartida ->InsertarSietCbtesPartidasRecurso($id_siet_declara,$id_gestion,$id_periodo,$tipo_declara);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	/// --------------------- tsi_siet_cbte --------------------- ///
	
	function ListarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ListarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	function ContarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ContarSietCbte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	
	
	
	function InsertarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$importe)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->InsertarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$importe);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	function ModificarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ModificarSietCbte($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}

	
	function EliminarSietCbte($id_siet_cbte)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->EliminarSietCbte($id_siet_cbte);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	function ValidarSietCbte($operacion_sql,$id_siet_cbte,$id_siet_declara,$id_cbte,$id_subsistema)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ValidarSietCbte($operacion_sql,$id_siet_cbte,$id_siet_declara,$id_cbte,$id_subsistema);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	/// --------------------- tsi_siet_cbte_partida --------------------- ///
	
	function ListarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->ListarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietCbtePartida->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	function ContarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->ContarSietCbtePartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	
	
	function InsertarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->InsertarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	function ModificarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->ModificarSietCbtePartida($id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe,$id_oec,$id_siet_ent_ua_transf);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	function EliminarSietCbtePartida($id_siet_cbte_partida)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->EliminarSietCbtePartida($id_siet_cbte_partida);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	function ValidarSietCbtePartida($operacion_sql,$id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->ValidarSietCbtePartida($operacion_sql,$id_siet_cbte_partida,$id_siet_cbte,$id_partida,$importe);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	function InsertarSietCbtePartidaExcel($id_siet_cbte,$importe,$codigo_partida,$codigo_oec,$codigo_partida_siet,$codigo_oec_siet)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->InsertarSietCbtePartidaExcel($id_siet_cbte,$importe,$codigo_partida,$codigo_oec,$codigo_partida_siet,$codigo_oec_siet);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	/// --------------------- tts_extracto_bancario --------------------- ///
	
	function ListarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->ListarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbExtractoBancario->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	
	function ContarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->ContarExtractoBancario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	
	
	
	function InsertarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$fecha_movimiento,$agencia,$descripcion,$nro_documento,$monto,$tipo_importe,$sub_tipo_importe,$id_parametro,$id_periodo)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->InsertarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$fecha_movimiento,$agencia,$descripcion,$nro_documento,$monto,$tipo_importe,$sub_tipo_importe,$id_parametro,$id_periodo);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	
	function ModificarExtractoBancario($id_extracto_bancario,$sub_tipo_importe,$observaciones,$id_cbte,$monto)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->ModificarExtractoBancario($id_extracto_bancario,$sub_tipo_importe,$observaciones,$id_cbte,$monto);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	
	function EliminarExtractoBancario($id_extracto_bancario)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->EliminarExtractoBancario($id_extracto_bancario);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	
	function DefinirTransferencias($id_cuenta_bancaria,$id_parametro,$id_periodo)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->DefinirTransferencias($id_cuenta_bancaria,$id_parametro,$id_periodo);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}

       function ListarSietDeclaraRepTxt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ListarSietDeclaraRepTxt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function ListarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ListarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	function ContarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ContarComprobantesFaltantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
function ValidarSiNo($id_siet_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ValidarSiNo($id_siet_declara);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
/*********************SIET TRASPASOS ************/
	function ListarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTraspaso = new cls_DBSietTraspaso($this->decodificar);
		$res = $dbTraspaso ->ListarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTraspaso ->salida;
		$this->query = $dbTraspaso ->query;
		return $res;
	}	
	function ContarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTraspaso = new cls_DBSietTraspaso($this->decodificar);
		$res = $dbTraspaso ->ContarSietTraspaso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTraspaso ->salida;
		$this->query = $dbTraspaso ->query;
		return $res;
	}	
	function EliminarSietTraspaso($id_siet_traspaso)
	{
		$this->salida = "";
		$dbTraspaso = new cls_DBSietTraspaso($this->decodificar);
		$res = $dbTraspaso ->EliminarSietTraspaso($id_siet_traspaso);
		$this->salida = $dbTraspaso ->salida;
		$this->query = $dbTraspaso ->query;
		return $res;
	}
       function GenerarSietTraspaso($id_siet_declara)
	{
		$this->salida = "";
		$dbTraspaso = new cls_DBSietTraspaso($this->decodificar);
		$res = $dbTraspaso ->GenerarSietTraspaso($id_siet_declara);
		$this->salida = $dbTraspaso ->salida;
		$this->query = $dbTraspaso ->query;
		return $res;
	}
       function ExtraerFAdeFR($id_siet_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ExtraerFAdeFR($id_siet_declara);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}

       function RepExcelCbtesSinPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelCbtesSinPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}

	function GenerarBackupEB($id_periodo)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->GenerarBackupEB($id_periodo);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}
	function SubirBackupEB($id_periodo)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->SubirBackupEB($id_periodo);
		$this->salida = $dbExtractoBancario ->salida;
		$this->query = $dbExtractoBancario ->query;
		return $res;
	}

       function GenerarSietPartidas($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->GenerarSietPartidas($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function GenerarSietOecs($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->GenerarSietOecs($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
       function ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOec = new cls_DBOec($this->decodificar);
		$res = $dbOec ->ListarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOec->salida;
		$this->query = $dbOec ->query;
		return $res;
	}
	
	function ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOec = new cls_DBOec($this->decodificar);
		$res = $dbOec ->ContarOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOec->salida;
		$this->query = $dbOec ->query;
		return $res;
	}

       function RepExcelSeguimientoFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelSeguimientoFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function InsertarSietCbteReversion($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$sw_reversion)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->InsertarSietCbteReversion($id_siet_cbte,$id_siet_declara,$id_extracto_bancario,$sw_ingresa_declaracion,$sw_fa,$sw_reversion);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}

	function UnirFAenFR($id_siet_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->UnirFAenFR($id_siet_declara);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
       function RepExcelReportesSietGastos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelReportesSietGastos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function RepExcelReportesSietGastosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelReportesSietGastosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function RepExcelReportesSietRecursos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelReportesSietRecursos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	function RepExcelReportesSietRecursosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelReportesSietRecursosDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function RepExcelReportesSietTraspasos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelReportesSietTraspasos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
       function ModificarSietDeclaraGenNros($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ModificarSietDeclaraGenNros($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
       function RepExcelPartidasSinOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelPartidasSinOec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
	
	function RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,$id_siet_cbte)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->RepExcelFondosAvanceAnual($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_siet_declara,$id_siet_cbte);
		$this->salida = $dbSietDeclara->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
     
       function ListarSietEntidadTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietEntidadTransf = new cls_DBSietEntidadTransf($this->decodificar);
		$res = $dbSietEntidadTransf ->ListarSietEntidadTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietEntidadTransf->salida;
		$this->query = $dbSietEntidadTransf ->query;
		return $res;
	}
	function ContarSietEntidadTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSietEntidadTransf = new cls_DBSietEntidadTransf($this->decodificar);
		$res = $dbSietEntidadTransf ->ContarSietEntidadTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSietEntidadTransf->salida;
		$this->query = $dbSietEntidadTransf ->query;
		return $res;
	}
      function InsertarSietCbteIdCbteRep($id_siet_cbte,$id_siet_declara,$id_cbte_ant_rev)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->InsertarSietCbteIdCbteRep($id_siet_cbte,$id_siet_declara,$id_cbte_ant_rev);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}

	
	function InsertarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->InsertarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	function ModificarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ModificarSietCbteNuevo($id_siet_declara,$id_siet_cbte,$importe,$id_cuenta_bancaria,$glosa,$id_cuenta_doc,$estado);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	function ListarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ListarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	function ContarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->ContarSietCbteNuevo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tipo_declara);
		$this->salida = $dbSietCbte->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	//archivo incluido por sast REQ09092016162159 
	function InsertarSietCbteOecExcel($id_siet_cbte_partida,$importe,$codigo_oec,$codigo_oec_siet)
	{
		$this->salida = "";
		$dbSietCbtePartida = new cls_DBSietCbtePartida($this->decodificar);
		$res = $dbSietCbtePartida ->InsertarSietCbteOecExcel($id_siet_cbte_partida,$importe,$codigo_oec,$codigo_oec_siet);
		$this->salida = $dbSietCbtePartida ->salida;
		$this->query = $dbSietCbtePartida ->query;
		return $res;
	}
	
	function InsertarSietCbteReversionExcel($id_siet_cbte)
	{
		$this->salida = "";
		$dbSietCbte = new cls_DBSietCbte($this->decodificar);
		$res = $dbSietCbte ->InsertarSietCbteReversionExcel($id_siet_cbte);
		$this->salida = $dbSietCbte ->salida;
		$this->query = $dbSietCbte ->query;
		return $res;
	}
	
	function ActualizarAsociarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$monto,$tipo_importe,$id_parametro,$id_periodo,$id_siet_cbte)
	{
		$this->salida = "";
		$dbExtractoBancario = new cls_DBExtractoBancario($this->decodificar);
		$res = $dbExtractoBancario ->ActualizarAsociarExtractoBancario($id_extracto_bancario,$id_cuenta_bancaria,$monto,$tipo_importe,$id_parametro,$id_periodo,$id_siet_cbte);
		$this->salida = $dbExtractoBancario->salida;
		$this->query = $dbExtractoBancario->query;
		return $res;
	}
	//FAS12: 25102016
	function ModificarSietDuplicados($id_siet_declara)
	{
		$this->salida = "";
		$dbSietDeclara = new cls_DBSietDeclara($this->decodificar);
		$res = $dbSietDeclara ->ModificarSietDuplicados($id_siet_declara);
		$this->salida = $dbSietDeclara ->salida;
		$this->query = $dbSietDeclara ->query;
		return $res;
	}
}