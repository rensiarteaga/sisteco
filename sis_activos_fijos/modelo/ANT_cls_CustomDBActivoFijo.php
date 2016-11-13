<?php
/**
 * Nombre de la Clase:	    CustomDBActivosFijos
 * Propósito:				es la interfaz del modelo del Sistema de Activos Fijos
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		01-06-2007
 * Autor:					
 *
 */
class cls_CustomDBActivoFijo
{	//variable que contiene la salida de la ejecución de la función
	//si la función tuvo error (false), salida contendrá el mensaje de error
	//si la función no tuvo error (true), salida contendrá el resultado, ya sea un conjunto de datos o un mensaje de confirmación
	var $salida = "";

	//Variable que contedrá la cadena de llamada a las funciones postgres
	var $query = "";

	//Bandera que indica si los datos se decodificarán o no
	var $decodificar = false;

	function __construct()
	{	
			include_once("cls_DBGrupoProceso.php");
			include_once("cls_DBActivoFijo.php");
			include_once("cls_DBActivoFijoCaracteristicas.php");
			include_once("cls_DBActivoFijoCompCaract.php");
			include_once("cls_DBActivoFijoEmpleado.php");
			include_once("cls_DBActivoFijoComponentes.php");
			include_once("cls_DBActivoFijoProceso.php");
		//	include_once("cls_DBActivoFijoTiempoProd.php");
			include_once("cls_DBCaracteristicas.php");
			include_once("cls_DBDepreciacion.php");
		    include_once("cls_DBMetodoDepreciacion.php");
			include_once("cls_DBProceso.php");
			include_once("cls_DBProcesoMotivo.php");
			include_once("cls_DBReparacion.php");
			include_once("cls_DBSubtipoActivo.php");
			include_once("cls_DBTipoActivo.php");
		//	include_once("cls_DBTipoActivoProceso.php");
		//	include_once("cls_DBUnidadConstructiva.php");
			include_once("cls_DBActivoFijoTpmFrppa.php");
			include_once("cls_DBDepreciacionTemp.php");
		    include_once("cls_DBEstadoFuncional.php");
		    include_once("cls_DBTransferencia.php");
		//	include_once("cls_DBResponsableAF.php");
		//	include_once("cls_DBCargo.php");
		//	include_once("cls_DBUnidadOrganizacional.php");
		//	include_once("cls_DBEmpleadoCargoUnidadOrganizacional.php");
			include_once("cls_DBParamGral.php");
		//	include_once("cls_DBAuxiliar.php");
			 include_once("cls_DBSubTipoActivoCuenta.php");
			 include_once("cls_DBGrupoDepreciacion.php");
			 include_once("cls_DBProceso.php");
			 include_once("cls_DBTipoCuenta.php");
			 include_once("cls_DBProcesoTipoCuenta.php");
			 include_once("cls_DBTipoCuentaCuenta.php");
			 include_once("cls_DBActivoFijoReporte.php");
			 include_once("cls_DBDeposito.php");
			 //include_once("cls_DBDetalleActivoFijoReporte.php");
			 
			
	}
	/////////////// UNIDAD CONSTRUCTIVA/////////////////////
	function ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadCons = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons ->ListarUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}
	function ContarListaUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadCons= new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons ->ContarListaUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}
	function CrearUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado)
	{
		$this->salida = "";
		$dbUnidadCons = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons ->CrearUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}
	function EliminarUnidadConstructiva($id_unidad_constructiva)
	{
		$this->salida = "";
		$dbUnidadCons = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons -> EliminarUnidadConstructiva($id_unidad_constructiva);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}
	function ModificarUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado)
	{
		$this->salida = "";
		$dbUnidadCons = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons ->ModificarUnidadConstructiva($id_unidad_constructiva, $descripcion, $fecha_reg, $estado);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}
	function ValidarUnidadConstructiva($operacion_sql,$id_unidad_constructiva, $descripcion, $fecha_reg, $estado)
	{
		$this->salida = "";
		$dbUnidadCons = new cls_DBUnidadConstructiva($this->decodificar);
		$res = $dbUnidadCons ->ValidarUnidadConstructiva($operacion_sql,$id_unidad_constructiva, $descripcion, $fecha_reg, $estado);
		$this->salida = $dbUnidadCons->salida;
		$this->query = $dbUnidadCons->query;
		return $res;
	}

	/////////////   FIN  UNIDAD CONSTRUCTIVA /////////////////////////////


	/////////////   MÉTODO DEPRECIACIÓN /////////////////////////////

	function ListarMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbMetodoDepreciacion = new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion -> ListarMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetodoDepreciacion->salida;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}
	function ContarListaMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbMetodoDepreciacion= new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion->ContarListaMetodoDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetodoDepreciacion->salida;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}
	function CrearMetodoDepreciacion($descripcion,$id_metodo_depreciacion)
	{
		$this->salida="";
		$this->query = "";
		$dbMetodoDepreciacion = new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion ->CrearMetodoDepreciacion($descripcion,$id_metodo_depreciacion);
		$this->salida = $dbMetodoDepreciacion ->salida ;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}
	function EliminarMetodoDepreciacion($id_metodo_depreciacion)
	{
		$this->salida= "";
		$this->query = "";
		$dbMetodoDepreciacion = new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion ->EliminarMetodoDepreciacion($id_metodo_depreciacion);
		$this->salida = $dbMetodoDepreciacion ->salida;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}
	function ModificarMetodoDepreciacion($descripcion,$id_metodo_depreciacion)
	{
		$this->salida="";
		$this->query = "";
		$dbMetodoDepreciacion = new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion ->ModificarMetodoDepreciacion($descripcion,$id_metodo_depreciacion);
		$this->salida = $dbMetodoDepreciacion->salida;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}
	function ValidarMetodoDepreciacion($operacion_sql,$id_metodo_depreciacion,$descripcion)
	{
		$this->salida = "";
		$this->query = "";
		$dbMetodoDepreciacion = new cls_DBMetodoDepreciacion($this->decodificar);
		$res = $dbMetodoDepreciacion ->ValidarMetodoDepreciacion($operacion_sql,$id_metodo_depreciacion,$descripcion);
		$this->salida = $dbMetodoDepreciacion->salida;
		$this->query = $dbMetodoDepreciacion->query;
		return $res;
	}

	/////////////// FIN MÉTODOS DEPRECIACIÓN/////////////////////

	/////////////   MÉTODO PARAMETROS GENERALES /////////////////////////////

	function ListarParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral -> ListarParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamGral->salida;
		$this->query = $dbParamGral->query;
		return $res;
	}
	function ContarListaParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$dbParamGral= new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral->ContarListaParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamGral->salida;
		$this->query = $dbParamGral->query;
		return $res;
	} 
function ContarParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral ->ContarParamGral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParamGral ->salida;
		$this->query = $dbParamGral ->query;
		return $res;
	}
	
	function InsertarParamGral($id_moneda,$id_gestion,$decimales_actualiz)
	{
		$this->salida = "";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral ->InsertarParamGral($id_moneda,$id_gestion,$decimales_actualiz);
		$this->salida = $dbParamGral ->salida;
		$this->query = $dbParamGral ->query;
		return $res;
	}
	
	function ModificarParamGral($id_param_gral,$id_moneda,$id_gestion,$decimales_actualiz)
	{
		$this->salida = "";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral ->ModificarParamGral($id_param_gral,$id_moneda,$id_gestion,$decimales_actualiz);
		$this->salida = $dbParamGral ->salida;
		$this->query = $dbParamGral ->query;
		return $res;
	}
	
	function EliminarParamGral($id_param_gral)
	{
		$this->salida = "";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral -> EliminarParamGral($id_param_gral);
		$this->salida = $dbParamGral ->salida;
		$this->query = $dbParamGral ->query;
		return $res;
	}
	
	function ValidarParamGral($operacion_sql,$id_param_gral,$id_moneda,$id_gestion,$decimales_actualiz)
	{
		$this->salida = "";
		$dbParamGral = new cls_DBParamGral($this->decodificar);
		$res = $dbParamGral ->ValidarParamGral($operacion_sql,$id_param_gral,$id_moneda,$id_gestion,$decimales_actualiz);
		$this->salida = $dbParamGral ->salida;
		$this->query = $dbParamGral ->query;
		return $res;
	}

	/////////////// FIN PARAM GRAL/////////////////////


	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////// ESTADO FUNCIONAL /////////////////////////////

	function ListarEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida=" ";
	$this->query = "";
	$dbEstadoFuncional = new cls_DBEstadoFuncional($this->decodificar);
	$res = $dbEstadoFuncional -> ListarEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbEstadoFuncional->salida;
	$this->query = $dbEstadoFuncional->query;
	return $res;
	}
	function ContarListaEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbEstadoFuncional= new cls_DBEstadoFuncional($this->decodificar);
		$res = $dbEstadoFuncional->ContarListaEstadoFuncional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoFuncional->salida;
		$this->query = $dbEstadoFuncional->query;
		return $res;
	}
	function CrearEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado)
	{	$this->salida="";
	$this->query = "";
	$dbEstadoFuncional = new cls_DBEstadoFuncional($this->decodificar);
	$res = $dbEstadoFuncional ->CrearEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado);
	$this->salida = $dbEstadoFuncional ->salida ;
	$this->query = $dbEstadoFuncional->query;
	return $res;
	}
	function EliminarEstadoFuncional($id_estado_funcional)
	{
		$this->salida= "";
		$this->query = "";
		$dbEstadoFuncional = new cls_DBEstadoFuncional($this->decodificar);
		$res = $dbEstadoFuncional ->EliminarEstadoFuncional($id_estado_funcional);
		$this->salida = $dbEstadoFuncional ->salida;
		$this->query = $dbEstadoFuncional ->query;
		return $res;
	}
	function ModificarEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado)
	{
		$this->salida="";
		$this->query = "";
		$dbEstadoFuncional = new cls_DBEstadoFuncional($this->decodificar);
		$res = $dbEstadoFuncional ->ModificarEstadoFuncional($id_estado_funcional,$codigo,$descripcion,$estado);
		$this->salida = $dbEstadoFuncional->salida;
		$this->query = $dbEstadoFuncional->query;
		return $res;
	}
	function ValidarEstadoFuncional($operacion_sql,$id_estado_funcional,$codigo,$descripcion,$estado)
	{
		$this->salida = "";
		$this->query = "";
		$dbEstadoFuncional = new cls_DBEstadoFuncional($this->decodificar);
		$res = $dbEstadoFuncional ->ValidarEstadoFuncional($operacion_sql,$id_estado_funcional,$codigo,$descripcion,$estado);
		$this->salida = $dbEstadoFuncional->salida;
		$this->query = $dbEstadoFuncional->query;
		return $res;
	}

	/////////////// FIN ESTADO FUNCIONAL/////////////////////

	/////////////// TIPO ACTIVO/////////////////////

	function ListarTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ListarTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	function ContarListaTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo= new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ContarListaTipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	/*************************************************************************************************/
	function ListarTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ListarTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	function ContarListaTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo= new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ContarListaTipoActivoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}


	/*****************************************************************************************************/

	function CrearTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->CrearTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	function EliminarTipoActivo($id_tipo_activo)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo -> EliminarTipoActivo($id_tipo_activo);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	function ModificarTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ModificarTipoActivo($id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}
	function ValidarTipoActivo($operacion_sql, $id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivo = new cls_DBTipoActivo($this->decodificar);
		$res = $dbTipoActivo ->ValidarTipoActivo($operacion_sql, $id_tipo_activo, $codigo, $descripcion, $flag_depreciacion, $fecha_reg, $estado, $id_metodo_depreciacion);
		$this->salida = $dbTipoActivo->salida;
		$this->query = $dbTipoActivo->query;
		return $res;
	}

	/////////////   FIN  TIPO ACTIVO /////////////////////////////

	/////////////   PROCESO MOTIVO /////////////////////////////

	function ListarProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$dbProcesoMotivo = new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo -> ListarProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoMotivo->salida;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}
	function ContarListaProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$dbProcesoMotivo= new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo ->ContarListaPaginadaProcesoMotivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoMotivo->salida;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}
	function CrearProcesoMotivo($descripcion,$id_motivo,$id_proceso)
	{
		$this->salida=" ";
		$dbProcesoMotivo = new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo->CrearProcesoMotivo($descripcion,$id_motivo,$id_proceso);
		$this->salida = $dbProcesoMotivo ->salida ;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}
	function EliminarProcesoMotivo($id_motivo)
	{
		$this->salida= " ";
		$dbProcesoMotivo = new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo ->EliminarProcesoMotivo($id_motivo);
		$this->salida = $dbProcesoMotivo ->salida;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}
	function ModificarProcesoMotivo($descripcion,$id_motivo,$id_proceso)
	{
		$this->salida="";
		$dbProcesoMotivo = new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo ->ModificarProcesoMotivo($descripcion,$id_motivo,$id_proceso);
		$this->salida = $dbProcesoMotivo->salida;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}
	function ValidarProcesoMotivo($operacion_sql,$id_motivo,$descripcion,$id_proceso)
	{
		$this->salida = "";
		$dbProcesoMotivo = new cls_DBProcesoMotivo($this->decodificar);
		$res = $dbProcesoMotivo ->ValidarProcesoMotivo($operacion_sql,$id_motivo,$descripcion,$id_proceso);
		$this->salida = $dbProcesoMotivo->salida;
		$this->query = $dbProcesoMotivo->query;
		return $res;
	}

	/////////////// FIN PROCESO MOTIVO/////////////////////

	/////////////// TIPO ACTIVO PROCESO/////////////////////

	function ListarTipoActivoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso = new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso ->ListarTipoActivoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;
	}
	function ContarListaTipoActivoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso= new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso ->ContarListaTipoActivoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;
	}
	function CrearTipoActivoProceso($id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso = new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso ->CrearTipoActivoProceso($id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;
	}
	function EliminarTipoActivoProceso($id_tipo_activo_proceso)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso = new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso -> EliminarTipoActivoProceso($id_tipo_activo_proceso);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;
	}
	function ModificarTipoActivoProceso($id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso = new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso ->ModificarTipoActivoProceso($id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;
	}
	function ValidarTipoActivoProceso($operacion_sql, $id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoActivoProceso = new cls_DBTipoActivoProceso($this->decodificar);
		$res = $dbTipoActivoProceso ->ValidarTipoActivoProceso($operacion_sql, $id_tipo_activo_proceso, $tipo, $id_tipo_activo, $id_proceso, $id_auxiliar);
		$this->salida = $dbTipoActivoProceso->salida;
		$this->query = $dbTipoActivoProceso->query;
		return $res;

	}

	/////////////   FIN  TIPO ACTIVO PROCESO/////////////////////////////

	///////////////  ACTIVO FIJO COMPONENTES CARACTERISTICAS/////////////////////

	function ListarActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract = new cls_DBActivoFijoCompCaract($this->decodificar);
		$res = $dbActivoFijoCompCaract ->ListarActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;
		return $res;
	}
	function ContarListaActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract= new cls_DBActivoFijoCompCaract($this->decodificar);
		$res = $dbActivoFijoCompCaract->ContarListaActivoFijoCompCaract($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;
		return $res;
	}
	function CrearActivoFijoCompCaract($id_activo_fijo_comp_caract, $descripcion, $id_caracteristica, $id_componente)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract = new cls_DBActivoFijoCompCaract($this->decodificar);
		///////////////////////////////////////
		$res = $dbActivoFijoCompCaract->CrearActivoFijoCompCaract($id_activo_fijo_comp_caract, $descripcion, $id_caracteristica, $id_componente);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;
		return $res;
	}
	function EliminarActivoFijoCompCaract($id_activo_fijo_comp_caract)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract = new cls_DBActivoFijoCompCaract($this->decodificar);
		$res = $dbActivoFijoCompCaract -> EliminarActivoFijoCompCaract($id_activo_fijo_comp_caract);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;
		return $res;
	}
	function ModificarActivoFijoCompCaract($id_activo_fijo_comp_caract, $descripcion, $id_caracteristica, $id_componente)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract= new cls_DBActivoFijoCompCaract($this->decodificar);
		$res = $dbActivoFijoCompCaract ->ModificarActivoFijoCompCaract($id_activo_fijo_comp_caract, $descripcion, $id_caracteristica, $id_componente);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;

		return $res;
	}
	function ValidarActivoFijoCompCaract($operacion_sql, $id_activo_fijo_comp_caract, $descripcion, $id_caracteristica, $id_componente)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCompCaract= new cls_DBActivoFijoCompCaract($this->decodificar);
		$res = $dbActivoFijoCompCaract->ValidarActivoFijoCompCaract($operacion_sql, $id_activo_fijo_comp_caract,$descripcion,$id_caracteristica,$id_componente);
		$this->salida = $dbActivoFijoCompCaract->salida;
		$this->query = $dbActivoFijoCompCaract->query;
		return $res;
	}
	/////////////   FIN ACTIVO FIJO COMPONENTES CARACTERISTICAS/////////////////////////////

	/////////////////////CUADRO ACTIVO FIJO/////////////////////////////////
	function ListarCuadro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarCuadro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}

	function ListarCuadroEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarCuadroEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_inicio,$fecha_fin);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	/////////////////////////////ACTIVO FIJO ESTADO/////////////////////////////////////////////////////////////
	function ListarActivoFijoEstado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarActivoFijoEstado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ListarActivoFijoEstadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarActivoFijoEstadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ListarActivoFijoEstadoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarActivoFijoEstadoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ListarActivoFijoEstadoEPEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarActivoFijoEstadoEPEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}

	////////////////////////////////////// ACTIVO FIJO/////////////////////////////////////////////////////////
	function ListarActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ListarActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijo= new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ContarListaActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function CrearActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
	//$id_frppa,$id_unidad_organizacional,
	$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto)
	{	
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->CrearActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
		//$id_frppa, $id_unidad_organizacional,
		$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function EliminarActivoFijo($id_activo_fijo)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo -> EliminarActivoFijo($id_activo_fijo);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ModificarActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
	//$id_frppa,$id_unidad_organizacional,
	$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto)
	{ 
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ModificarActivoFijo($id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$id_depto,$id_cotizacion,$id_cotizacion_det,$origen,
		//$id_frppa,$id_unidad_organizacional,
		$id_presupuesto,$id_lugar,$id_gestion,$id_solicitud_compra,$clonacion,$id_clon,$id_deposito,$tipo_af_bien,$proyecto);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	function ValidarActivoFijo($operacion_sql, $id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$fecha_alta,$id_deposito)
	{ 
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo ->ValidarActivoFijo($operacion_sql, $id_activo_fijo, $codigo, $descripcion, $descripcion_larga, $vida_util_original, $vida_util_restante, $tasa_depreciacion, $fecha_ultima_deprec, $depreciacion_acum_ant, $depreciacion_acum, $depreciacion_periodo, $flag_revaloriz, $valor_rescate, $fecha_compra, $monto_compra_mon_orig, $monto_compra, $monto_actual, $con_garantia, $num_poliza_garantia, $fecha_fin_gar, $fecha_reg, $foto_activo, $num_factura, $tipo_cambio, $estado, $observaciones, $id_sub_tipo_activo, $id_institucion, $id_moneda, $id_moneda_original, $id_unidad_constructiva, $fecha_ini_dep, $ubicacion_fisica, $orden_compra, $id_estado_funcional,$monto_compra_2,$monto_actual_2,$depreciacion_acum_2,$depreciacion_acum_ant_2,$depreciacion_periodo_2,$vida_util_2,$vida_util_restante_2,$fecha_alta,$id_deposito);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	//05ago10
	function ClonarActivoFijo($id_activo_fijo,$cant_clones)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo -> ClonarActivoFijo($id_activo_fijo,$cant_clones);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	
	function CodificarActivo($id_activo_fijo)
	{
		$this->salida = "";
		$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
		$res = $dbActivoFijo -> CodificarActivo($id_activo_fijo);
		$this->salida = $dbActivoFijo->salida;
		$this->query = $dbActivoFijo->query;
		return $res;
	}
	
	
	/////////////   FIN  ACTIVO FIJO /////////////////////////////
	/////////////// DEPRECIACION/////////////////////
	function ContarListaDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepreciacion= new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ContarListaDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;
		return $res;
	}
	function CrearDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->CrearDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;
		return $res;
	}
	function EliminarDepreciacion($id_depreciacion)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion -> EliminarDepreciacion($id_depreciacion);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;
		return $res;
	}
	function ModificarDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ModificarDepreciacion($id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;
		return $res;
	}
	function ValidarDepreciacion($operacion_sql, $id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ValidarDepreciacion($operacion_sql, $id_depreciacion, $fecha_desde, $fecha_hasta, $monto_vigente_ant, $monto_vigente, $vida_util, $tipo_cambio_ini, $tipo_cambio_fin, $depreciacion_acum_ant, $depreciacion, $nuevo_monto, $fecha_reg, $estado, $depreciacion_acum, $id_activo_fijo, $id_moneda);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;
		return $res;
	}
	//function Depreciar($fecha_fin, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo, $codigo_temp)
	function Depreciar($fecha_fin, $id_depto, $codigo_temp) //financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo,
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->Depreciar($fecha_fin, $id_depto, $codigo_temp);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;

		return $res;
	}
	
	/// --------------------- taf_depreciacion --------------------- ///

	function ListarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ListarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	function ContarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ContarDepreciacion2Det($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	function InsertarDepreciacion2Det($id_depreciacion,$id_grupo_depreciacion)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->InsertarDepreciacion2Det($id_depreciacion,$id_grupo_depreciacion);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	function ModificarDepreciacion2Det($id_depreciacion,$id_grupo_depreciacion)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ModificarDepreciacion2Det($id_depreciacion,$id_grupo_depreciacion);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	function EliminarDepreciacion2Det($id_depreciacion)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion -> EliminarDepreciacion2Det($id_depreciacion);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	function ValidarDepreciacion2Det($operacion_sql,$id_depreciacion,$id_grupo_depreciacion)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ValidarDepreciacion2Det($operacion_sql,$id_depreciacion,$id_grupo_depreciacion);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}
	
	/// --------------------- fin taf_depreciacion --------------------- ///
	

	////////////////////////////depreciacion_inversa///////////////////////////////////////////////////////
	function DepreciarInv($fecha_fin, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo, $codigo_temp)
	{
		$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->DepreciarInv($fecha_fin, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad, $id_tipo_activo, $id_sub_tipo_activo, $id_activo_fijo, $codigo_temp);
		$this->salida = $dbDepreciacion->salida;
		$this->query = $dbDepreciacion->query;

		return $res;
	}

	/////////////////////////////////////////////////////////////////////////////////


	/////////////   FIN  DEPRECIACION /////////////////////////////


	/////////////// REPARACION/////////////////////

	function ListarReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReparacion = new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion->ListarReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}
	function ContarListaReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReparacion= new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion->ContarListaReparacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}
	function InsertarReparacion($id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion)
	{
		$this->salida = "";
		$dbReparacion= new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion->InsertarReparacion($id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}
	function EliminarReparacion($id_reparacion)
	{
		$this->salida = "";
		$dbReparacion= new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion-> EliminarReparacion($id_reparacion);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}
	function ModificarReparacion($id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion)
	{
		$this->salida = "";
		$dbReparacion= new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion->ModificarReparacion($id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}
	function ValidarReparacion($operacion_sql, $id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion)
	{
		$this->salida = "";
		$dbReparacion = new cls_DBReparacion($this->decodificar);
		$res = $dbReparacion->ValidarReparacion($operacion_sql, $id_reparacion,$fecha_desde,$fecha_hasta,$problema,$fecha_reg,$observaciones,$estado,$id_activo_fijo,$id_persona,$id_institucion);
		$this->salida = $dbReparacion->salida;
		$this->query = $dbReparacion->query;
		return $res;
	}

	/////////////   FIN  REPARACION /////////////////////////////

	
	///////////////////////////////////////////////////////////////////////
	function ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso->ListarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	
	function ListarActivoFijoProcesoSubTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso->ListarActivoFijoProcesoSubTipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	///////////////////////////////////////////////////////////////////////


	function ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoProceso= new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ContarActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	function CrearActivoFijoProceso(
	/*$id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,$comprobante_id,$aplicado,$estado,$fecha_reg,$fecha_aprobacion,$fecha_aplicacion,$id_activo_fijo,$id_proceso,$id_motivo, $descripcion, $documentacion, $fecha_proceso*/
	$id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,
	$fecha_reg,
	$estado,$id_activo_fijo,$id_proceso,$id_motivo, $aplicado,$fecha_aprobacion,$fecha_aplicacion,$descripcion,$documentacion,$fecha_proceso,$id_cta_org,$id_aux_org,$id_cta_des, $id_aux_des,$id_transaccion,$id_grupo_proceso,$id_ppto_org, $id_ppto_des
	)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->CrearActivoFijoProceso($id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,
	$fecha_reg,
	$estado,$id_activo_fijo,$id_proceso,$id_motivo, $aplicado,$fecha_aprobacion,$fecha_aplicacion,$descripcion,$documentacion,$fecha_proceso,$id_cta_org,$id_aux_org,$id_cta_des, $id_aux_des,$id_transaccion,$id_grupo_proceso,$id_ppto_org, $id_ppto_des);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	function EliminarActivoFijoProceso($id_activo_fijo_proceso)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso -> EliminarActivoFijoProceso($id_activo_fijo_proceso);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	function ModificarActivoFijoProceso($id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,
	$fecha_reg,
	$estado,$id_activo_fijo,$id_proceso,$id_motivo, $aplicado,$fecha_aprobacion,$fecha_aplicacion,$descripcion,$documentacion,$fecha_proceso,$id_cta_org,$id_aux_org,$id_cta_des, $id_aux_des,$id_transaccion,$id_grupo_proceso,$id_ppto_org, $id_ppto_des)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ModificarActivoFijoProceso($id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,
	$fecha_reg,
	$estado,$id_activo_fijo,$id_proceso,$id_motivo, $aplicado,$fecha_aprobacion,$fecha_aplicacion,$descripcion,$documentacion,$fecha_proceso,$id_cta_org,$id_aux_org,$id_cta_des, $id_aux_des,$id_transaccion,$id_grupo_proceso,$id_ppto_org, $id_ppto_des);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	function ValidarActivoFijoProceso($operacion_sql,$id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,$comprobante_id,$aplicado,$estado,$fecha_reg,$fecha_aprobacion,$fecha_aplicacion,$id_activo_fijo,$id_proceso,$id_motivo, $descripcion, $documentacion, $fecha_proceso)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ValidarActivoFijoProceso($operacion_sql, $id_activo_fijo_proceso,$monto_vigente_anterior,$monto_vigente_actual,$vida_util_anterior,$vida_util_actual,$comprobante_id,$aplicado,$estado,$fecha_reg,$fecha_aprobacion,$fecha_aplicacion,$id_activo_fijo,$id_proceso,$id_motivo, $descripcion, $documentacion, $fecha_proceso);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	//---------------SXOF-----------14/01/2010
	function ListarPDFActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ListarPDFActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso ->salida;
		$this->query = $dbActivoFijoProceso ->query;
		return $res;
	}
	
	//---------------SXOF-----------24/01/2010
	function ListarDetalleActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbDetalleActivoFijoReporte = new cls_DBDetalleActivoFijoReporte($this->decodificar);
		$res = $dbDetalleActivoFijoReporte ->ListarDetalleActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetalleActivoFijoReporte ->salida;
		$this->query = $dbDetalleActivoFijoReporte ->query;
		return $res;
	}
	
	//---------------SXOF-----------24/01/2010
	function ListarDetalleActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbDetalleActivoFijoReporte = new cls_DBDetalleActivoFijoReporte($this->decodificar);
		$res = $dbDetalleActivoFijoReporte ->ListarDetalleActivoFijoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetalleActivoFijoReporte ->salida;
		$this->query = $dbDetalleActivoFijoReporte ->query;
		return $res;
	}
	
	/*function AprobarProcesos($id_activo_fijo_proceso,$estado)
	{
	$this->salida = "";
	$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
	$res = $dbActivoFijoProceso ->AprobarProcesos($id_activo_fijo_proceso,$estado);
	$this->salida = $dbActivoFijoProceso->salida;
	$this->query = $dbActivoFijoProceso->query;
	return $res;
	}
	function AplicarAprobacionProcesos()
	{
	$this->salida = "";
	$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
	$res = $dbActivoFijoProceso -> AplicarAprobacionProcesos();
	$this->salida = $dbActivoFijoProceso->salida;
	$this->query = $dbActivoFijoProceso->query;
	return $res;
	}*/

	function AprobarAplicarAprobacionProcesos($id_activo_fijo_proceso,$estado)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->AprobarAplicarAprobacionProcesos($id_activo_fijo_proceso,$estado);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	
	
	
	
	
	/**********AFGrupoProceso************/
	
	function ListarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso->ListarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}

	
		function ContarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoProceso= new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ContarActivoFijoGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	
	
	function InsertarActivoFijoGrupoProceso($id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->InsertarActivoFijoGrupoProceso($id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	
	
	function ModificarActivoFijoGrupoProceso($id_activo_fijo_proceso,$id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->ModificarActivoFijoGrupoProceso($id_activo_fijo_proceso,$id_grupo_proceso,$id_activo_fijo,$monto_revalorizacion,$vida_util_revalorizacion,$fecha_ini_dep,$observaciones);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	
	
	function EliminarActivoFijoGrupoProceso($id_activo_fijo_proceso)
	{
		$this->salida = "";
		$dbActivoFijoProceso = new cls_DBActivoFijoProceso($this->decodificar);
		$res = $dbActivoFijoProceso ->EliminarActivoFijoGrupoProceso($id_activo_fijo_proceso);
		$this->salida = $dbActivoFijoProceso->salida;
		$this->query = $dbActivoFijoProceso->query;
		return $res;
	}
	/////////////   FIN  ACTIVO FIJO PROCESO/////////////////////////////



	/////////////// PROCESO/////////////////////
	/// --------------------- taf_proceso --------------------- ///

	function ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ContarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ContarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function InsertarProceso($descripcion,$codigo,$sw_aprobar,$sw_contabilizar,$sw_registrar,$sw_bien_responsabilidad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->InsertarProceso($descripcion,$codigo,$sw_aprobar,$sw_contabilizar,$sw_registrar,$sw_bien_responsabilidad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ModificarProceso($id_proceso,$descripcion,$codigo,$sw_aprobar,$sw_contabilizar,$sw_registrar,$sw_bien_responsabilidad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ModificarProceso($id_proceso,$descripcion,$codigo,$sw_aprobar,$sw_contabilizar,$sw_registrar,$sw_bien_responsabilidad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function EliminarProceso($id_proceso)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso -> EliminarProceso($id_proceso);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ValidarProceso($operacion_sql,$id_proceso,$descripcion,$codigo)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ValidarProceso($operacion_sql,$id_proceso,$descripcion,$codigo);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	/// --------------------- fin taf_proceso --------------------- ///
	
/*
	function ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ListarProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
	function ContarListaProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso= new cls_DBProceso($this->decodificar);
		$res = $dbProceso->ContarListaProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
	function CrearProceso($id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->CrearProceso($id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
	function EliminarProceso($id_proceso)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso -> EliminarProceso($id_proceso);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
	function ModificarProceso($id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ModificarProceso($id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
	function ValidarProceso($operacion_sql, $id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProceso($this->decodificar);
		$res = $dbProceso ->ValidarProceso($operacion_sql, $id_proceso, $descripcion, $flag_comprobante, $tipo_comprobante);
		$this->salida = $dbProceso->salida;
		$this->query = $dbProceso->query;
		return $res;
	}
*/
	/////////////   FIN  PROCESO /////////////////////////////


	/////////////// CARACTERISTICAS/////////////////////

	function ListarCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristicas = new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas ->ListarCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}
	function ContarListaCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristicas= new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas ->ContarListaCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}
	function CrearCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo)
	{
		$this->salida = "";
		$dbCaracteristicas = new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas ->CrearCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}
	function EliminarCaracteristicas($id_caracteristica)
	{
		$this->salida = "";
		$dbCaracteristicas = new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas -> EliminarCaracteristicas($id_caracteristica);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}
	function ModificarCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo)
	{
		$this->salida = "";
		$dbCaracteristicas = new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas ->ModificarCaracteristicas($id_caracteristica, $descripcion, $id_subtipo_activo);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}
	function ValidarCaracteristicas($operacion_sql, $id_caracteristica, $descripcion, $id_subtipo_activo)
	{
		$this->salida = "";
		$dbCaracteristicas = new cls_DBCaracteristicas($this->decodificar);
		$res = $dbCaracteristicas ->ValidarCaracteristicas($operacion_sql, $id_caracteristica, $descripcion, $id_subtipo_activo);
		$this->salida = $dbCaracteristicas->salida;
		$this->query = $dbCaracteristicas->query;
		return $res;
	}

	/////////////   FIN  CARACTERISTICAS /////////////////////////////


	/////////////// ACTIVO FIJO EMPLEADO/////////////////////

	function ListarActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ListarActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	////////////////////////////////////////////////////////////////////////////////
	function ListarActivoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ListarActivoTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}

	////////////////////////////////////////////////////////////////////////////////
	function ListarActivoTransferenciaVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ListarActivoTransferenciaVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	/////////////////////////////////////////////////////////////////////////////////////
	function ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado= new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ContarListaActivoFijoEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	function CrearActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->CrearActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	function EliminarActivoFijoEmpleado($id_activo_fijo_empleado)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado -> EliminarActivoFijoEmpleado($id_activo_fijo_empleado);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	function ModificarActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ModificarActivoFijoEmpleado($id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}

	function TransferirActivoFijoEmpleado($id_activo_fijo_empleado,$id_empleado_destino,$fecha_asig,$id_transferencia)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado->TransferirActivoFijoEmpleado($id_activo_fijo_empleado,$id_empleado_destino,$fecha_asig,$id_transferencia);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	function ValidarActivoFijoEmpleado($operacion_sql, $id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ValidarActivoFijoEmpleado($operacion_sql, $id_activo_fijo_empleado, $fecha_reg, $estado, $id_activo_fijo, $id_empleado, $fecha_asig);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	
	//RCM:31/10/2008
	function EliminarTransferencia($id_activo_fijo_empleado)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado->EliminarTransferencia($id_activo_fijo_empleado);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}

	/////////////  FIN ACTIVO FIJO EMPLEADO /////////////////////////////

	///////////////  ACTIVO FIJO CARACTERISTICAS /////////////////////

	function ListarActivoFijoCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas = new cls_DBActivoFijoCaracteristicas($this->decodificar);
		$res = $dbActivoFijoCaracteristicas ->ListarActivoFijoCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	function ContarListaActivoFijoCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas= new cls_DBActivoFijoCaracteristicas($this->decodificar);
		$res = $dbActivoFijoCaracteristicas->ContarListaActivoFijoCaracteristicas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	function CrearActivoFijoCaracteristicas($id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas = new cls_DBActivoFijoCaracteristicas($this->decodificar);
		///////////////////////////////////////
		$res = $dbActivoFijoCaracteristicas->CrearActivoFijoCaracteristicas($id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	function EliminarActivoFijoCaracteristicas($id_activo_fijo_caracteristicas)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas = new cls_DBActivoFijoCaracteristicas($this->decodificar);
		$res = $dbActivoFijoCaracteristicas ->EliminarActivoFijoCaracteristicas($id_activo_fijo_caracteristicas);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	function ModificarActivoFijoCaracteristicas($id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas= new cls_DBActivoFijoCaracteristicas($this->decodificar);
		$res = $dbActivoFijoCaracteristicas ->ModificarActivoFijoCaracteristicas($id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	function ValidarActivoFijoCaracteristicas($operacion_sql, $id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoCaracteristicas= new cls_DBActivoFijoCaracteristicas($this->decodificar);
		$res = $dbActivoFijoCaracteristicas->ValidarActivoFijoCaracteristicas($operacion_sql, $id_activo_fijo_caracteristicas, $descripcion, $id_caracteristica, $id_activo_fijo);
		$this->salida = $dbActivoFijoCaracteristicas->salida;
		$this->query = $dbActivoFijoCaracteristicas->query;
		return $res;
	}
	/////////////   FIN ACTIVO FIJO CARACTERISTICAS /////////////////////////////

	/////////////// ACTIVO FIJO COMPONENTES/////////////////////

	function ListarActivoFijoComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->ListarActivoFijoComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function ContarListaActivoFijoComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes= new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->ContarListaActivoFijoComponentes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function CrearActivoFijoComponentes($id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->CrearActivoFijoComponentes($id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function EliminarActivoFijoComponentes($id_componente)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes -> EliminarActivoFijoComponentes($id_componente);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function ModificarActivoFijoComponentes($id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->ModificarActivoFijoComponentes($id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function TransferirComponente($id_componente, $id_activo_fijo, $id_activo_fijo_destino)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->TransferirComponente($id_componente, $id_activo_fijo, $id_activo_fijo_destino);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}
	function ValidarActivoFijoComponentes($operacion_sql, $id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoComponentes = new cls_DBActivoFijoComponentes($this->decodificar);
		$res = $dbActivoFijoComponentes ->ValidarActivoFijoComponentes($operacion_sql, $id_componente, $codigo, $descripcion, $fecha_reg, $estado_funcional, $estado, $id_activo_fijo);
		$this->salida = $dbActivoFijoComponentes->salida;
		$this->query = $dbActivoFijoComponentes->query;
		return $res;
	}

	/////////////   ACTIVO FIJO COMPONENTES /////////////////////////////


	/////////////// ACTIVO FIJO TIEMPO PROD/////////////////////

	function ListarActivoFijoTiempoProd($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd = new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd ->ListarActivoFijoTiempoProd($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}
	function ContarListaActivoFijoTiempoProd($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd= new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd ->ContarListaActivoFijoTiempoProd($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}
	function CrearActivoFijoTiempoProd($id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd = new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd ->CrearActivoFijoTiempoProd($id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}
	function EliminarActivoFijoTiempoProd($id_activo_fijo_tiempo_prod)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd = new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd -> EliminarActivoFijoTiempoProd($id_activo_fijo_tiempo_prod);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}
	function ModificarActivoFijoTiempoProd($id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd = new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd ->ModificarActivoFijoTiempoProd($id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}
	function ValidarActivoFijoTiempoProd($operacion_sql, $id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo)
	{
		$this->salida = "";
		$dbActivoFijoTiempoProd = new cls_DBActivoFijoTiempoProd($this->decodificar);
		$res = $dbActivoFijoTiempoProd->ValidarActivoFijoTiempoProd($operacion_sql, $id_activo_fijo_tiempo_prod, $fecha_ini, $fecha_fin, $produccion, $fecha_reg, $id_activo_fijo);
		$this->salida = $dbActivoFijoTiempoProd->salida;
		$this->query = $dbActivoFijoTiempoProd->query;
		return $res;
	}

	/////////////   FIN  ACTIVO FIJO TIEMPO PROD /////////////////////////////



	/////////////// SUBTIPO ACTIVO/////////////////////

	function ListarSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo = new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo ->ListarSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}
	function ContarListaSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo= new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo ->ContarListaSubtipoActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}
	function CrearSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo = new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo ->CrearSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}
	function EliminarSubtipoActivo($id_sub_tipo_activo)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo = new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo -> EliminarSubtipoActivo($id_sub_tipo_activo);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}
	function ModificarSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo = new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo ->ModificarSubtipoActivo($id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}
	function ValidarSubtipoActivo($operacion_sql, $id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo)
	{
		$this->salida = "";
		$this->query = "";
		$dbSubtipoActivo = new cls_DBSubtipoActivo($this->decodificar);
		$res = $dbSubtipoActivo ->ValidarSubtipoActivo($operacion_sql, $id_sub_tipo_activo, $codigo, $descripcion, $vida_util, $tasa_depreciacion, $ini_correlativo, $correlativo_act, $fecha_reg, $estado, $id_tipo_activo);
		$this->salida = $dbSubtipoActivo->salida;
		$this->query = $dbSubtipoActivo->query;
		return $res;
	}

	/////////////   FIN SUB TIPO ACTIVO /////////////////////////////


	/////////////// ACTIVO FIJO TPM_FRPPA/////////////////////

	function ListarActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ListarActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	function ContarListaActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa= new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ContarListaActivoFijoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	function CrearActivoFijoTpmFrppa($id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->CrearActivoFijoTpmFrppa($id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	function EliminarActivoFijoTpmFrppa($id_activo_fijo_frppa)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa->EliminarActivoFijoTpmFrppa($id_activo_fijo_frppa);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	function ModificarActivoFijoTpmFrppa($id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ModificarActivoFijoTpmFrppa($id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;

	}
	function ValidarActivoFijoTpmFrppa($operacion_sql, $id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ValidarActivoFijoTpmFrppa($operacion_sql, $id_activo_fijo_frppa, $estado, $fecha_reg, $id_activo_fijo, $id_financiador, $id_regional, $id_programa, $id_proyecto, $id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	
	function ListarEPActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa = new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ListarEPActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}
	
	function ContarEPActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$this->query = "";
		$dbActivoFijoTpmFrppa= new cls_DBActivoFijoTpmFrppa($this->decodificar);
		$res = $dbActivoFijoTpmFrppa ->ContarEPActivoFijo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoTpmFrppa->salida;
		$this->query = $dbActivoFijoTpmFrppa->query;
		return $res;
	}

	/////////////   FIN ACTIVO FIJO TPM_FRPPA /////////////////////////////

	/////////////// DEPRECIACION TEMP/////////////////////

	function ListarDepreciacionTemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_grupo_depreciacion)
	{
		/*		echo "codigo_temp->".$codigo_temp;
		exit;*/
		$this->salida = "";
		$this->query = "";
		$dbDepTemp = new cls_DBDepreciacionTemp($this->decodificar);
		$res = $dbDepTemp ->ListarDepreciacionTemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_grupo_depreciacion);
		$this->salida = $dbDepTemp->salida;
		$this->query = $dbDepTemp->query;
		return $res;
	}
	function ContarListaDepreciacionTemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_grupo_depreciacion)
	{
		$this->salida = "";
		$this->query = "";
		$dbDepTemp= new cls_DBDepreciacionTemp($this->decodificar);
		$res = $dbDepTemp ->ContarListaDepreciacionTemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_grupo_depreciacion);
		$this->salida = $dbDepTemp->salida;
		$this->query = $dbDepTemp->query;
		return $res;
	}
	////////////////////////////////CODIGO DE BARRAS ssssuuuuu//////////////////
	function ListarCodigoBarras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
	$res = $dbActivoFijo ->ListarCodigoBarras($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbActivoFijo->salida;
	$this->query = $dbActivoFijo->query;
	return $res;
	}

	////////////////////////////////Reporte Detalle de Activos Fijos ssssuuuuu//////////////////
	function ListarActivoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
	$dbActivoFijo = new cls_DBActivoFijo($this->decodificar);
	$res = $dbActivoFijo ->ListarActivoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbActivoFijo->salida;
	$this->query = $dbActivoFijo->query;

	return $res;
	}

	/////////////////////// RESPONSABLE AF
	function ListarResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF = new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF ->ListarResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;
	}
	function ContarResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF= new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF ->ContarResponsableAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;
	}
	function InsertarResponsableAF($id_responsable_af,$id_empleado,$estado,$fecha_reg)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF = new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF ->InsertarResponsableAF($id_responsable_af,$id_empleado,$estado,$fecha_reg);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;
	}
	function EliminarResponsableAF($id_responsable_af)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF = new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF->EliminarResponsableAF($id_responsable_af);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;
	}
	function ModificarResponsableAF($id_responsable_af,$id_empleado,$estado,$fecha_reg)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF = new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF ->ModificarResponsableAF($id_responsable_af,$id_empleado,$estado,$fecha_reg);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;

	}
	function ValidarResponsableAF($operacion_sql, $id_responsable_af,$id_empleado,$estado,$fecha_reg)
	{
		$this->salida = "";
		$this->query = "";
		$dbRespAF = new cls_DBResponsableAF($this->decodificar);
		$res = $dbRespAF ->ValidarResponsableAF($operacion_sql, $id_responsable_af,$id_empleado,$estado,$fecha_reg);
		$this->salida = $dbRespAF->salida;
		$this->query = $dbRespAF->query;
		return $res;
	}

	/////////////   MÉTODO CARGO /////////////////////////////

	function ListarCargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbCargo = new cls_DBCargo($this->decodificar);
		$res = $dbCargo -> ListarCargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	function ContarListaCargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo= new cls_DBCargo($this->decodificar);
		$res = $dbCargo->ContarListaCargo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	function CrearCargo($id_cargo,$descripcion)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo= new cls_DBCargo($this->decodificar);
		$res = $dbCargo ->CrearCargo($id_cargo,$descripcion);
		$this->salida = $dbCargo ->salida ;
		$this->query = $dbCargo->query;
		return $res;
	}
	function EliminarCargo($id_cargo)
	{
		$this->salida= "";
		$this->query = "";
		$dbCargo = new cls_DBCargo($this->decodificar);
		$res = $dbCargo ->EliminarCargo($id_cargo);
		$this->salida = $dbCargo ->salida;
		$this->query = $dbCargo->query;
		return $res;
	}

	function ModificarCargo($id_cargo,$descripcion)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo = new cls_DBCargo($this->decodificar);
		$res = $dbCargo ->ModificarCargo($id_cargo,$descripcion);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	function ValidarCargo($operacion_sql,$id_cargo,$descripcion)
	{
		$this->salida = "";
		$this->query = "";
		$dbCargo = new cls_DBCargo($this->decodificar);
		$res = $dbCargo ->ValidarCargo($operacion_sql,$id_cargo,$descripcion);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	/////////////// FIN CARGO/////////////////////

	/////////////   MÉTODO UNIDAD ORGANIZACIONAL/////////////////////////////

	function ListarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional -> ListarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional->salida;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}
	function ContarListaUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbUnidadOrganizacional= new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional->ContarListaUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional->salida;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}
	function CrearUnidadOrganizacional($id_unidad_organizacional,$descripcion,$codigo)
	{
		$this->salida="";
		$this->query = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->CrearUnidadOrganizacional($id_unidad_organizacional,$descripcion,$codigo);
		$this->salida = $dbUnidadOrganizacional ->salida ;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}
	function EliminarUnidadOrganizacional($id_unidad_organizacional)
	{
		$this->salida= "";
		$this->query = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->EliminarUnidadOrganizacional($id_unidad_organizacional);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}
	function ModificarUnidadOrganizacional($id_unidad_organizacional,$descripcion,$codigo)
	{
		$this->salida="";
		$this->query = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ModificarUnidadOrganizacional($id_unidad_organizacional,$descripcion,$codigo);
		$this->salida = $dbUnidadOrganizacional->salida;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}
	function ValidarUnidadOrganizacional($operacion_sql,$id_unidad_organizacional,$descripcion,$codigo)
	{
		$this->salida = "";
		$this->query = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ValidarUnidadOrganizacional($operacion_sql,$id_unidad_organizacional,$descripcion,$codigo);
		$this->salida = $dbUnidadOrganizacional->salida;
		$this->query = $dbUnidadOrganizacional->query;
		return $res;
	}

	/////////////// FIN UNIDAD_ORGANIZACIONAL/////////////////////


	/////////////   MÉTODO EMPLEADO CARGO UNIDAD ORGANIZACIONAL/////////////////////////////

	function ListarEmpleadoCargoUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional = new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional -> ListarEmpleadoCargoUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional->salida;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}
	function ContarListaEmpleadoCargoUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional= new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional->ContarListaEmpleadoCargoUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional->salida;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}
	function CrearEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional)
	{
		$this->salida="";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional = new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional ->CrearEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional ->salida ;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}
	function EliminarEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional)
	{
		$this->salida= "";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional = new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional->EliminarEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional ->salida;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}
	function ModificarEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional)
	{
		$this->salida="";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional = new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional ->ModificarEmpleadoCargoUnidadOrganizacional($id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional->salida;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}
	function ValidarEmpleadoCargoUnidadOrganizacional($operacion_sql,$id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional)
	{
		$this->salida = "";
		$this->query = "";
		$dbEmpleadoCargoUnidadOrganizacional = new cls_DBEmpleadoCargoUnidadOrganizacional($this->decodificar);
		$res = $dbEmpleadoCargoUnidadOrganizacional ->ValidarEmpleadoCargoUnidadOrganizacional($operacion_sql,$id_empleado_cargo_unidad_organizacional,$id_empleado,$id_cargo,$id_unidad_organizacional);
		$this->salida = $dbEmpleadoCargoUnidadOrganizacional->salida;
		$this->query = $dbEmpleadoCargoUnidadOrganizacional->query;
		return $res;
	}

	/////////////// FIN EMPLEADO CARGO UNIDAD_ORGANIZACIONAL/////////////////////

	/////////////   AUXILIAR /////////////////////////////

	function ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbCargo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo -> ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}

	function ListarAuxiliarCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbCargo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo -> ListarAuxiliarCom($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}

	function ContarListaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo= new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo->ContarListaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	function CrearAuxiliar($id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo= new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo ->CrearAuxiliar($id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo);
		$this->salida = $dbCargo ->salida ;
		$this->query = $dbCargo->query;
		return $res;
	}
	function EliminarAuxiliar($id)
	{
		$this->salida= "";
		$this->query = "";
		$dbCargo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo ->EliminarAuxiliar($id);
		$this->salida = $dbCargo ->salida;
		$this->query = $dbCargo->query;
		return $res;
	}

	function ModificarAuxiliar($id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo)
	{
		$this->salida="";
		$this->query = "";
		$dbCargo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo ->ModificarAuxiliar($id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	function ValidarAuxiliar($operacion_sql,$id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo)
	{
		$this->salida = "";
		$this->query = "";
		$dbCargo = new cls_DBAuxiliar($this->decodificar);
		$res = $dbCargo ->ValidarAuxiliar($operacion_sql,$id,$id_auxiliar,$descrip,$operativo,$transac,$valido,$grupo);
		$this->salida = $dbCargo->salida;
		$this->query = $dbCargo->query;
		return $res;
	}
	/////////////// FIN AUXILIAR/////////////////////

	//REPORTE CUADRO ACTIVOS FIJOS
	//RCM: 29/20/2008
	function ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarCuadroActivoFijoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}
	
	//RCM: 09/03/2009
	function ListarCuadroActivoFijoContaAcum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarCuadroActivoFijoContaAcum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$fecha_desde,$fecha_hasta);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}
	
	////////////////////////////////////////////
	
	//28-11/2008
	function ListarAsignacionResponsableActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ListarAsignacionResponsableActivo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	function ListarAsignacionResponsable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActivoFijoEmpleado = new cls_DBActivoFijoEmpleado($this->decodificar);
		$res = $dbActivoFijoEmpleado ->ListarAsignacionResponsable($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActivoFijoEmpleado->salida;
		$this->query = $dbActivoFijoEmpleado->query;
		return $res;
	}
	
		//RCM: 19/03/2009
	function ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}
	
	//RCM: 19/03/2009
	function ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}
	
	//GVC: 27/07/2010
	/*function ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarDetalleDepreciacionPri($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}
	
	//GVC: 27/07/2010
	function ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti)
	{
		$this->salida=" ";
		$this->query = "";
		$dbAF = new cls_DBActivoFijo($this->decodificar);
		$res = $dbAF -> ListarDetalleDepreciacionSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_fina_regi_prog_proy_acti);
		$this->salida = $dbAF->salida;
		$this->query = $dbAF->query;
		return $res;
	}*/
	
	//Transferencia////////////////////////////////////////////
	
	//28-11/2008
	function ListarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ListarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia->salida;
		$this->query = $dbTransferencia->query;
		return $res;
	}
	function ContarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida="";
		$this->query = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia->ContarTransferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransferencia->salida;
		$this->query = $dbTransferencia->query;
		return $res;
	}
	function CrearTransferencia($id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado)
	{
		$this->salida="";
		$this->query = "";
		$dbTransferencia= new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->CrearTransferencia($id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado);
		$this->salida = $dbTransferencia ->salida ;
		$this->query = $dbTransferencia->query;
		return $res;
	}
	function EliminarTransferenciaEmpleado($id_transferencia)
	{
		$this->salida= "";
		$this->query = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->EliminarTransferenciaEmpleado($id_transferencia);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia->query;
		return $res;
	}

	function ModificarTransferenciaEmpleado($id_transferencia,$id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado)
	{
		$this->salida="";
		$this->query = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ModificarTransferenciaEmpleado($id_transferencia,$id_empleado_origen,$id_empleado_destino,$fecha_transferencia,$estado);
		$this->salida = $dbTransferencia->salida;
		$this->query = $dbTransferencia->query;
		return $res;
	}

	
	/* grupo proceso*/
//28-11/2008
	function ListarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupoProceso= new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso->ListarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoProceso->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	function ContarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{ 
		$this->salida="";
		$this->query = "";
		$dbGrupoProceso = new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso->ContarGrupoProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoProceso->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	function InsertarGrupoProceso($id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion)
	{
		$this->salida="";
		$this->query = "";
		$dbGrupoProceso= new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso ->InsertarGrupoProceso($id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion);
		$this->salida = $dbGrupoProceso ->salida ;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	function EliminarGrupoProceso($id_grupo_proceso)
	{
		$this->salida= "";
		$this->query = "";
		$dbGrupoProceso = new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso ->EliminarGrupoProceso($id_grupo_proceso);
		$this->salida = $dbGrupoProceso ->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	
	function AccionesGrupoProceso($id_grupo_proceso,$accion)
	{
		$this->salida= "";
		$this->query = "";
		$dbGrupoProceso = new cls_DBGrupoProceso($this->decodificar);
		
		$res = $dbGrupoProceso ->AccionesGrupoProceso($id_grupo_proceso,$accion);
		$this->salida = $dbGrupoProceso ->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}

	function ModificarGrupoProceso($id_grupo_proceso,$id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion)
	{
		$this->salida="";
		$this->query = "";
		$dbGrupoProceso = new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso ->ModificarGrupoProceso($id_grupo_proceso,$id_depto_org,$id_proceso,$descripcion,$id_gestion,
													$fecha_contabilizacion,$id_activo_fijo,$id_empleado_org,
													$id_empleado_des,$id_presupuesto_org,$id_presupuesto_des,$codigo_proceso,$sw_prestamo,$fecha_devolucion);
		$this->salida = $dbGrupoProceso->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	
		function FinalizarGrupoProceso($id_grupo_proceso,$opcion)
	{
		$this->salida="";
		$this->query = "";
		$dbGrupoProceso = new cls_DBGrupoProceso($this->decodificar);
		$res = $dbGrupoProceso ->FinalizarGrupoProceso($id_grupo_proceso,$opcion);
		$this->salida = $dbGrupoProceso->salida;
		$this->query = $dbGrupoProceso->query;
		return $res;
	}
	
	
	//--------------------- taf_sub_tipo_activo_cuenta --------------------- ///

	function ListarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->ListarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;
	}
	
	function ContarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->ContarSubTipoActivoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;
	}
	
	function InsertarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->InsertarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;
	}
	
	function ModificarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->ModificarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto,$id_cuenta2,$id_auxiliar2,$id_tipo_activo,$nivel);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;;
	}
	
	function EliminarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->EliminarSubTipoActivoCuenta($id_sub_tipo_activo_cuenta);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;
	}
	
	function ValidarSubTipoActivoCuenta($operacion_sql,$id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto)
	{
		$this->salida = "";
		$dbSubTipoActivoCuenta = new cls_DBSubTipoActivoCuenta($this->decodificar);
		$res = $dbSubTipoActivoCuenta ->ValidarSubTipoActivoCuenta($operacion_sql,$id_sub_tipo_activo_cuenta,$id_sub_tipo_activo,$estado_reg,$fecha_reg,$id_usuario_reg,$id_cuenta,$id_auxiliar,$id_proceso,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_presupuesto);
		$this->salida = $dbSubTipoActivoCuenta ->salida;
		$this->query = $dbSubTipoActivoCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tad_servicio_propuesto --------------------- ///
	
	/// --------------------- taf_grupo_depreciacion --------------------- ///

	function ListarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion ->ListarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	function ContarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion ->ContarDepreciacion2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	function InsertarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$proyecto)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion ->InsertarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$proyecto);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	function ModificarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$fecha_fin,$codigo_temp,$proyecto)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion ->ModificarDepreciacion2($id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2,$fecha_fin,$codigo_temp,$proyecto);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	function EliminarDepreciacion2($id_grupo_depreciacion)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion -> EliminarDepreciacion2($id_grupo_depreciacion);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	function ValidarDepreciacion2($operacion_sql,$id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2)
	{
		$this->salida = "";
		$dbGrupoDepreciacion = new cls_DBGrupoDepreciacion($this->decodificar);
		$res = $dbGrupoDepreciacion ->ValidarDepreciacion2($operacion_sql,$id_grupo_depreciacion,$ano_fin,$mes_fin,$id_depto,$estado,$id_usuario_reg,$fecha_reg,$id_usuario_reg2);
		$this->salida = $dbGrupoDepreciacion ->salida;
		$this->query = $dbGrupoDepreciacion ->query;
		return $res;
	}
	
	/// --------------------- fin taf_grupo_depreciacion --------------------- ///
	
	/// --------------------- taf_tipo_cuenta --------------------- ///

	function ListarTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta ->ListarTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function ContarTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta ->ContarTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function InsertarTipoCuenta($id_tipo_cuenta,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta ->InsertarTipoCuenta($id_tipo_cuenta,$codigo,$descripcion);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function ModificarTipoCuenta($id_tipo_cuenta,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta ->ModificarTipoCuenta($id_tipo_cuenta,$codigo,$descripcion);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function EliminarTipoCuenta($id_tipo_cuenta)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta -> EliminarTipoCuenta($id_tipo_cuenta);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function ValidarTipoCuenta($operacion_sql,$id_tipo_cuenta,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuenta($this->decodificar);
		$res = $dbTipoCuenta ->ValidarTipoCuenta($operacion_sql,$id_tipo_cuenta,$codigo,$descripcion);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin taf_tipo_cuenta --------------------- ///
	
		/////////////// PROCESO TIPO CUNETA/////////////////////
	/// --------------------- taf_proceso_tipo_cuenta --------------------- ///

	function ListarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso ->ListarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ContarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso ->ContarProcesoTipoCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function InsertarProcesoTipoCuenta($txt_des_proceso,$hidden_id_proceso,$debe_haber)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso ->InsertarProcesoTipoCuenta($txt_des_proceso,$hidden_id_proceso,$debe_haber);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ModificarProcesoTipoCuenta($hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso,$debe_haber)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso ->ModificarProcesoTipoCuenta($hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso,$debe_haber);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function EliminarProcesoTipoCuenta($hidden_id_proceso_tipo_cuenta)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso -> EliminarProcesoTipoCuenta($hidden_id_proceso_tipo_cuenta);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ValidarProcesoTipoCuenta($operacion_sql,$hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso)
	{
		$this->salida = "";
		$dbProceso = new cls_DBProcesoTipoCuenta($this->decodificar);
		$res = $dbProceso ->ValidarProcesoTipoCuenta($operacion_sql,$hidden_id_proceso_tipo_cuenta,$txt_des_proceso,$hidden_id_proceso);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	/// --------------------- fin taf_proceso --------------------- ///
	
	/// --------------------- taf_tipo_cuenta_cuenta --------------------- ///

	function ListarTipoCuentaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_p,$id_tipo_cuenta)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBTipoCuentaCuenta($this->decodificar);
		$res = $dbTipoCuenta ->ListarTipoCuentaCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_gestion,$id_p,$id_tipo_cuenta);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	
	function InsertarTipoCuentaCuenta($id_p,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbProceso = new cls_DBTipoCuentaCuenta($this->decodificar);
		$res = $dbProceso ->InsertarTipoCuentaCuenta($id_p,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	
	function ModificarTipoCuentaCuenta($id,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbProceso = new cls_DBTipoCuentaCuenta($this->decodificar);
		$res = $dbProceso ->ModificarTipoCuentaCuenta($id,$id_tipo_cuenta,$id_gestion,$id_presupuesto,$id_tipo_activo,$id_sub_tipo_activo,$id_cuenta,$id_auxiliar);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
	function EliminarTipoCuentaCuenta($id)
	{
		$this->salida = "";
		$dbProceso = new cls_DBTipoCuentaCuenta($this->decodificar);
		$res = $dbProceso -> EliminarTipoCuentaCuenta($id);
		$this->salida = $dbProceso ->salida;
		$this->query = $dbProceso ->query;
		return $res;
	}
		//Añadido por Silvia Ximena Ortiz Fernández
		/// --------------------- taf_activo_fijo_empleado_empleado_detalle --------------------- ///

	function ListarActivoFijoEmpleadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCuenta = new cls_DBActivoFijoReporte($this->decodificar);
		$res = $dbTipoCuenta ->ListarActivoFijoEmpleadoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCuenta ->salida;
		$this->query = $dbTipoCuenta ->query;
		return $res;
	}
	////////////------------taf-deposito-------------------///////
	function ListarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->ListarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	} 
	function ContarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->ContarDeposito($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	} 
	function InsertarDeposito($nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->InsertarDeposito($nombre_deposito,$id_empleado_responsable,$id_depto_af);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	}
	function ModificarDeposito($id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->ModificarDeposito($id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	} 
	function EliminarDeposito($id_deposito)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->EliminarDeposito($id_deposito);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	}  
	function ValidarDeposito($operacion_sql,$id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af)
	{
		$this->salida = "";
		$dbDeposito = new cls_DBDeposito($this->decodificar);
		$res = $dbDeposito ->ValidarDeposito($operacion_sql,$id_deposito,$nombre_deposito,$id_empleado_responsable,$id_depto_af);
		$this->salida = $dbDeposito ->salida;
		$this->query = $dbDeposito ->query;
		return $res;	
	}

	function ListarDepreciacionRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDepreciacion ->ListarDepreciacionRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepreciacion ->salida;
		$this->query = $dbDepreciacion ->query;
		return $res;
	}	
	
	function ReporteDetalleDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbDetDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDetDepreciacion ->ReporteDetalleDepreciacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetDepreciacion ->salida;
		$this->query = $dbDetDepreciacion ->query;
		return $res;
	}	
	
	function SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	$this->salida = "";
		$dbDetDepreciacion = new cls_DBDepreciacion($this->decodificar);
		$res = $dbDetDepreciacion ->SumaDatosDetDep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetDepreciacion ->salida;
		$this->query = $dbDetDepreciacion ->query;
		return $res;
	}
}
?>