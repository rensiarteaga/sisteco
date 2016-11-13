<?php
/**
 * Nombre de la Clase:	    CustomDBsistema_telefonico
 * Propósito:				Interfaz del modelo del Sistema de sistema_telefonico
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2008-01-17 15:14:26
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBSistemaTelefonico
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBGerencia.php");
		include_once("cls_DBTipoLlamada.php");
		include_once("cls_DBLinea.php");
		include_once("cls_DBLlamada.php");

		
		//2016
		include_once("cls_DBEquipo.php");
		include_once("cls_DBPlanLlamada.php");
		include_once("cls_DBAsignacionEquipo.php");
		include_once("cls_DBServicioAdicional.php");
		include_once("cls_DBComponente.php");
	}
	
	/// --------------------- tst_gerencia --------------------- ///

	function ListarGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->ListarGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	function ContarGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->ContarGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	function GerenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->GerenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	function NombreRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->NombreRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	function InsertarGerencia($id_gerencia,$nombre_gerencia,$descripcion,$codigo)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->InsertarGerencia($id_gerencia,$nombre_gerencia,$descripcion,$codigo);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	function ModificarGerencia($id_gerencia,$nombre_gerencia,$descripcion,$codigo)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->ModificarGerencia($id_gerencia,$nombre_gerencia,$descripcion,$codigo);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	function EliminarGerencia($id_gerencia)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia -> EliminarGerencia($id_gerencia);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	function ValidarGerencia($operacion_sql,$id_gerencia,$nombre_gerencia,$descripcion,$codigo)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->ValidarGerencia($operacion_sql,$id_gerencia,$nombre_gerencia,$descripcion,$codigo);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	//2016}
	function GerenciaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGerencia = new cls_DBGerencia($this->decodificar);
		$res = $dbGerencia ->GerenciaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGerencia ->salida;
		$this->query = $dbGerencia ->query;
		return $res;
	}
	
	/// --------------------- fin tst_gerencia --------------------- ///
		/// --------------------- tst_tipo_llamada --------------------- ///

	function ListarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada ->ListarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	function ContarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada ->ContarTipoLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	function InsertarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada ->InsertarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	function ModificarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada ->ModificarTipoLlamada($id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	function EliminarTipoLlamada($id_tipo_llamada)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada -> EliminarTipoLlamada($id_tipo_llamada);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	function ValidarTipoLlamada($operacion_sql,$id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion)
	{
		$this->salida = "";
		$dbTipoLlamada = new cls_DBTipoLlamada($this->decodificar);
		$res = $dbTipoLlamada ->ValidarTipoLlamada($operacion_sql,$id_tipo_llamada,$nombre_tipo_llamada,$costo_minuto,$descripcion);
		$this->salida = $dbTipoLlamada ->salida;
		$this->query = $dbTipoLlamada ->query;
		return $res;
	}
	
	/// --------------------- fin tst_tipo_llamada --------------------- ///
	/// --------------------- tst_linea --------------------- ///

	function ListarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ListarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	function ContarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ContarLinea($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	function ListarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ListarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	function ContarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ContarLineaDis($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	function InsertarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin,$sim_card)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->InsertarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin,$sim_card);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	function ModificarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin,$sim_card)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ModificarLinea($id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones,$estado_reg,$fecha_ini,$fecha_fin,$sim_card);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	function EliminarLinea($id_linea)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea -> EliminarLinea($id_linea);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	function ValidarLinea($operacion_sql,$id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones)
	{
		$this->salida = "";
		$dbLinea = new cls_DBLinea($this->decodificar);
		$res = $dbLinea ->ValidarLinea($operacion_sql,$id_linea,$empresa,$puerto_linea,$numero_telefono,$id_tipo_llamada,$costo_segundo,$tiempo_espera,$observaciones);
		$this->salida = $dbLinea ->salida;
		$this->query = $dbLinea ->query;
		return $res;
	}
	
	/// --------------------- fin tst_linea --------------------- ///
	/// --------------------- tst_llamada --------------------- ///

	function ListarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ListarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	
	function ContarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ContarLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	function ListarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ListarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	
	function ContarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ContarNumero($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	function ListarNombreLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$linea)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ListarNombreLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$linea);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	function InsertarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->InsertarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	function ModificarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ModificarLlamada($id_llamada,$fecha_llamada,$hora_llamada,$numero_interno,$numero_marcado,$duracion_llamada,$transferido,$saliente,$linea,$pwd_usuario);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
	function ProcesarArchivo($nombre)
	{
		$this->salida = "";
		$dbLlamada = new cls_DBLlamada($this->decodificar);
		$res = $dbLlamada ->ProcesarArchivo($nombre);
		$this->salida = $dbLlamada ->salida;
		$this->query = $dbLlamada ->query;
		return $res;
	}
		
	/// --------------------- fin tst_llamada --------------------- ///
	
	
	
	/***********2016***********/
	/// --------------------- tst_equipo --------------------- ///
	
	function ListarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEquipo = new cls_DBEquipo($this->decodificar);
		$res = $dbEquipo ->ListarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEquipo ->salida;
		$this->query = $dbEquipo ->query;
		return $res;
	}
	
	function ContarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEquipo = new cls_DBEquipo($this->decodificar);
		$res = $dbEquipo ->ContarEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEquipo ->salida;
		$this->query = $dbEquipo ->query;
		return $res;
	}
	
	
		function InsertarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
	{
		$this->salida = "";
		$dbEquipo = new cls_DBEquipo($this->decodificar);
		$res = $dbEquipo ->InsertarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei);
		$this->salida = $dbEquipo ->salida;
		$this->query = $dbEquipo ->query;
		return $res;
	}
	function ModificarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
	{
		$this->salida = "";
		$dbEquipo = new cls_DBEquipo($this->decodificar);
		$res = $dbEquipo ->ModificarEquipo($id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei);
		$this->salida = $dbEquipo ->salida;
		$this->query = $dbEquipo ->query;
		return $res;
	}
	
	function ValidarEquipo($operacion_sql,$id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei)
	{
		$this->salida = "";
		$dbEquipo = new cls_DBEquipo($this->decodificar);
		$res = $dbEquipo ->ValidarEquipo($operacion_sql,$id_equipo, $modelo,$marca, $fecha_ingreso, $estado_reg, $observaciones,$imei);
		$this->salida = $dbEquipo ->salida;
		$this->query = $dbEquipo ->query;
		return $res;
	}
	
	/// --------------------- fin tst_equipo --------------------- ///
	
	/// --------------------- tst_plan_llamada --------------------- ///
	
	function ListarPlanLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanLlamada = new cls_DBPlanLlamada($this->decodificar);
		$res = $dbPlanLlamada ->ListarPlanLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanLlamada ->salida;
		$this->query = $dbPlanLlamada ->query;
		return $res;
	}
	
	function ContarPlanLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanLlamada = new cls_DBPlanLlamada($this->decodificar);
		$res = $dbPlanLlamada ->ContarPlanLlamada($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanLlamada ->salida;
		$this->query = $dbPlanLlamada ->query;
		return $res;
	}
	
	
	function InsertarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win,$fecha_ini, $fecha_fin)
	{
		$this->salida = "";
		$dbPlanLlamada = new cls_DBPlanLlamada($this->decodificar);
		$res = $dbPlanLlamada ->InsertarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win,$fecha_ini, $fecha_fin);
		$this->salida = $dbPlanLlamada ->salida;
		$this->query = $dbPlanLlamada ->query;
		return $res;
	}
	function ModificarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win, $estado_reg,$fecha_ini, $fecha_fin)
	{
		$this->salida = "";
		$dbPlanLlamada = new cls_DBPlanLlamada($this->decodificar);
		$res = $dbPlanLlamada ->ModificarPlanLlamada($id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win, $estado_reg,$fecha_ini, $fecha_fin);
		$this->salida = $dbPlanLlamada ->salida;
		$this->query = $dbPlanLlamada ->query;
		return $res;
	}
	
	function ValidarPlanLlamada($operacion_sql,$id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win)
	{
		$this->salida = "";
		$dbPlanLlamada = new cls_DBPlanLlamada($this->decodificar);
		$res = $dbPlanLlamada ->ValidarPlanLlamada($operacion_sql,$id_plan_llamada, $nombre,$descripcion,$monto_llamada,$monto_datos,$tarifa_win);
		$this->salida = $dbPlanLlamada ->salida;
		$this->query = $dbPlanLlamada ->query;
		return $res;
	}
	
	/// --------------------- fin tst_plan_llamada --------------------- ///
	
	
	/// --------------------- tst_asignacion_equipo --------------------- ///
	function ListarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->ListarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	function ContarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->ContarAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	
	function InsertarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg, $fecha_reg,$fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion)
	{ 
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->InsertarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg, $fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	function ModificarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg, $fecha_reg, $fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion)
	{
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->ModificarAsignacionEquipo($id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg, $fecha_ini,$fecha_fin,$id_componente,$id_linea,$tipo_asignacion);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	function ValidarAsignacionEquipo($operacion_sql,$id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg, $fecha_reg, $fecha_ini,$fecha_fin)
	{
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->ValidarAsignacionEquipo($operacion_sql,$id_asignacion_equipo, $id_equipo,$id_plan_llamada,$id_empleado,$id_correspondencia,$estado_reg,$fecha_reg, $fecha_ini,$fecha_fin);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	function ListarRepAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
	
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->ListarRepAsignacionEquipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	function EliminarAsignacionEquipo($id_asignacion_equipo)
	{
		$this->salida = "";
		$dbAsignacionEquipo = new cls_DBAsignacionEquipo($this->decodificar);
		$res = $dbAsignacionEquipo ->EliminarAsignacionEquipo($id_asignacion_equipo);
		$this->salida = $dbAsignacionEquipo ->salida;
		$this->query = $dbAsignacionEquipo ->query;
		return $res;
	}
	
	
	/// --------------------- fin tst_asignacion_equipo --------------------- ///
	
	/// --------------------- tst_servicio_adicional --------------------- ///
	function ListarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->ListarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	
	function ContarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->ContarServicioAdicional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	
	
	function InsertarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->InsertarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	function ModificarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->ModificarServicioAdicional($id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	
	function ValidarServicioAdicional($operacion_sql,$id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->ValidarServicioAdicional($operacion_sql,$id_servicio_adicional,$id_asignacion_equipo , $fecha_ini ,$estado_reg , $importe_servicio , $detalle ,  $id_correspondencia ,  $fecha_fin);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	
	function EliminarServicioAdicional($id_servicio_adicional)
	{
		$this->salida = "";
		$dbServicioAdicional = new cls_DBServicioAdicional($this->decodificar);
		$res = $dbServicioAdicional ->EliminarServicioAdicional($id_servicio_adicional);
		$this->salida = $dbServicioAdicional ->salida;
		$this->query = $dbServicioAdicional ->query;
		return $res;
	}
	
	/// --------------------- fin tst_asignacion_equipo --------------------- ///
	
	
	/// --------------------- tst_componente --------------------- ///
	function ListarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ListarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	
	function InsertarComponente($id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->InsertarComponente($id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	function ModificarComponente($id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ModificarComponente($id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function EliminarComponente($id_componente)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->EliminarComponente($id_componente);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function ValidarComponente($operacion_sql,$id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ValidarComponente($operacion_sql,$id_componente, $imei,$sim_card, $fecha_ini,$fecha_fin, $estado_reg);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
}