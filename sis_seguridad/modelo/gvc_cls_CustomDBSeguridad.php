<?php
/**
**********************************************************
Nombre de la Clase:	    gvc_cls_CustomDBSeguridad
Propósito:				es la interfaz del modelo del modulo de seguridad
                        todos los metodos existentes pasan por aqui
Fecha de Creación:		31 - 08 - 2007
Versión:				1.0.0
Autor:					Grover Velasquez Colque
**********************************************************
*/
class gvc_cls_CustomDBSeguridad
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
		include_once("../../../lib/lib_modelo/cls_middle.php");

		include_once("cls_DBHistClave.php");
		include_once("cls_DBUsuarioLugar.php");
        include_once("cls_DBAsignacionEstructuraTpmFrppa.php");
		include_once("cls_DBRegistroEvento.php");

	}

	///////////////////// HistClave /////////////////////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_hist_clave
	 * @param unknown_type $id_usuario
	 * @param unknown_type $fecha_cambio
	 * @param unknown_type $hora_cambio
	 * @param unknown_type $contrasenia_anterior
	 * @return unknown
	 */
	function InsertarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->InsertarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_hist_clave
	 * @param unknown_type $id_usuario
	 * @param unknown_type $fecha_cambio
	 * @param unknown_type $hora_cambio
	 * @param unknown_type $contrasenia_anterior
	 * @return unknown
	 */
	function ModificarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ModificarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_hist_clave
	 * @return unknown
	 */
	function EliminarHistClave($id_hist_clave)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave -> EliminarHistClave($id_concepto);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_hist_clave
	 * @param unknown_type $id_usuario
	 * @param unknown_type $fecha_cambio
	 * @param unknown_type $hora_cambio
	 * @param unknown_type $contrasenia_anterior
	 * @return unknown
	 */
	function ValidarHistClave($operacion_sql, $id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ValidarHistClave($operacion_sql, $id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
		$this->salida = $dbHistClave->salida;
		$this->query = $dbHistClave->query;
		return $res;
	}

	///////////////////// FIN HistClave /////////////////////

	//////////////////// Usuario Lugar ////////////////////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_lugar
	 * @param unknown_type $id_lugar
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function InsertarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->InsertarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_lugar
	 * @param unknown_type $id_lugar
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function ModificarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ModificarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_lugar
	 * @return unknown
	 */
	function EliminarUsuarioLugar($id_usuario_lugar)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar -> EliminarUsuarioLugar($id_usuario_lugar);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_usuario_lugar
	 * @param unknown_type $id_lugar
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function ValidarUsuarioLugar($operacion_sql, $id_usuario_lugar, $id_lugar, $id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ValidarUsuarioLugar($operacion_sql, $id_usuario_lugar, $id_lugar, $id_usuario);
		$this->salida = $dbUsuarioLugar->salida;
		$this->query = $dbUsuarioLugar->query;
		return $res;
	}
	//////////////////// FIN UsuarioLugar ////////////////////

	//////////////////// Asignacion Estructura Tpm Frppa ////////////////////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_asignacion_estructura_frppa
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $id_asignacion_estructura
	 * @param unknown_type $editar
	 * @return unknown
	 */
	function InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_asignacion_estructura_frppa
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $id_asignacion_estructura
	 * @param unknown_type $editar
	 * @return unknown
	 */
	function ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_asignacion_estructura_frppa
	 * @return unknown
	 */
	function EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa -> EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_asignacion_estructura_frppa
	 * @param unknown_type $id_fina_regi_prog_proy_acti
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $id_asignacion_estructura
	 * @param unknown_type $editar
	 * @return unknown
	 */
	function ValidarAsignacionEstructuraTpmFrppa($operacion_sql, $id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ValidarAsignacionEstructuraTpmFrppa($operacion_sql, $id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
		return $res;
	}
	//////////////////// FIN Asignacion Estructura Tpm Frppa ////////////////////

	//////////////////// Registro Evento ////////////////////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortcol
	 * @param unknown_type $sortdir
	 * @param unknown_type $criterio_filtro
	 * @param unknown_type $id_financiador
	 * @param unknown_type $id_regional
	 * @param unknown_type $id_programa
	 * @param unknown_type $id_proyecto
	 * @param unknown_type $id_actividad
	 * @return unknown
	 */
	function ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}
	/*function InsertarRegistroEvento($id_concepto, $id_cuenta, $id_param, $desc_concepto, $importe_concepto, $sw_tipo)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->InsertarRegistroEvento($id_concepto, $id_cuenta, $id_param, $desc_concepto, $importe_concepto, $sw_tipo);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}
	function ModificarRegistroEvento($id_concepto, $id_cuenta, $id_param, $desc_concepto, $importe_concepto, $sw_tipo)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ModificarRegistroEvento($id_concepto, $id_cuenta, $id_param, $desc_concepto, $importe_concepto, $sw_tipo);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}*/
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_registro_eventos
	 * @return unknown
	 */
	function EliminarRegistroEvento($id_registro_eventos)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento -> EliminarRegistroEvento($id_registro_eventos);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_registro_eventos
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_subsistema
	 * @param unknown_type $id_lugar
	 * @param unknown_type $fecha
	 * @param unknown_type $hora
	 * @param unknown_type $numero_error
	 * @param unknown_type $descripcion
	 * @param unknown_type $ip_origen
	 * @param unknown_type $log_error
	 * @param unknown_type $codigo_procedimiento
	 * @param unknown_type $mac_maquina
	 * @param unknown_type $proc_almacenado
	 * @return unknown
	 */
	function ValidarRegistroEvento($operacion_sql, $id_registro_eventos, $id_usuario, $id_subsistema, $id_lugar, $fecha, $hora, $numero_error, $descripcion, $ip_origen, $log_error, $codigo_procedimiento, $mac_maquina, $proc_almacenado)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ValidarRegistroEvento($operacion_sql, $id_registro_eventos, $id_usuario, $id_subsistema, $id_lugar, $fecha, $hora, $numero_error, $descripcion, $ip_origen, $log_error, $codigo_procedimiento, $mac_maquina, $proc_almacenado);
		$this->salida = $dbRegistroEvento->salida;
		$this->query = $dbRegistroEvento->query;
		return $res;
	}
	//////////////////// FIN Registro Evento ////////////////////

}//fin Custom

?>