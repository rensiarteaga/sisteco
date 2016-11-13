<?php
/**
**********************************************************
Nombre de la Clase:	    CustomDBSeguridad
Propósito:				es la interfaz del modelo del modulo de seguridad
                        todos los metodos existentes pasan por aqui
Fecha de Creación:		18 - 09 - 07
Versión:				1.0.0
Autor:					Veimar Soliz Poveda
**********************************************************
*/
class cls_CustomDBSeguridad
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

		include_once("cls_DBUsuario.php");
		include_once("cls_DBParametroGeneral.php");
		//include_once("cls_DBLugar.php");
		include_once("cls_DBPermiso.php");
		//include_once("cls_DBPersona.php");
		//include_once("cls_DBSubsistema.php");

		//MZM
		include_once("cls_DBSubsistema.php");
		include_once("cls_DBPersona.php");
		include_once("cls_DBTipoDocIdentificacion.php");
		include_once("cls_DBMetaproceso.php");
		include_once("cls_DBPreferenciaDetalle.php");
		include_once("cls_DBUsuarioEnvioAlerta.php");
		include_once("cls_DBMetaprocesoEnvioAlerta.php");
		include_once("cls_DBRol.php");
		include_once("cls_DBPreferencia.php");
		include_once("cls_DBUsuarioAsignacion.php");
		include_once("cls_DBEnvioAlerta.php");
		//FIN MZM

		//JGL
		include_once("cls_DBLugar.php");
		include_once("cls_DBRolMetaproceso.php");
		include_once("cls_DBPreferenciaUsuario.php");
		//FIN JGL

		//GVC
		include_once("cls_DBHistClave.php");
		include_once("cls_DBUsuarioLugar.php");
		include_once("cls_DBAsignacionEstructuraTpmFrppa.php");
		include_once("cls_DBRegistroEvento.php");
		//FIN GVC

		//ARV
		//include_once("cls_DBUsuario.php");
		include_once("cls_DBUsuarioRol.php");
		//include_once("cls_DBParametroGeneral.php");
		include_once ("cls_DBAsignacionEstructura.php");
		//include_once("cls_DBPermiso.php");
		//FIN ARV

	}

	/////////////// USUARIOS /////////////////////
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $usuario
	 * @param unknown_type $contrasenia
	 * @param unknown_type $ip_origen
	 * @param unknown_type $mac_maquina
	 * @return unknown
	 */
//	function VerificaUsuario($usuario,$contrasenia,$ip_origen,$mac_maquina)
//	{
//		$this->salida = "";
//
//		$dbUsuario = new cls_DBUsuario();
//		$res = $dbUsuario -> VerificaUsuario($usuario,$contrasenia,$ip_origen,$mac_maquina);
//		$this->salida = $dbUsuario->salida;
//		return $res;
//	}

	//*********************************************************************

	/**
	 * 
	 *
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
//	function EliminarUsuario ($id_usuario)
//	{
//
//		$this->salida = "";
//		$dbUsuario= new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario -> EliminarUsuario($id_usuario);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_persona
	 * @param unknown_type $login
	 * @param unknown_type $contrasenia
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modicficacion
	 * @param unknown_type $estado_usuario
	 * @param unknown_type $estilo_usuario
	 * @param unknown_type $filtro_avanzado
	 * @return unknown
	 */
//	function InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modicficacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
//	{
//		$this->salida = "";
//		$dbUsuario = new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario->InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modicficacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//
//
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $id_persona
//	 * @param unknown_type $login
//	 * @param unknown_type $contrasenia
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modicficacion
//	 * @param unknown_type $estado_usuario
//	 * @param unknown_type $estilo_usuario
//	 * @param unknown_type $filtro_avanzado
//	 * @return unknown
//	 */
//	function ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modicficacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
//	{
//		$this->salida = "";
//		$dbUsuario= new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario->ModificarParametroGeneral($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modicficacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuario= new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario->ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuario= new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario->ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $id_persona
//	 * @param unknown_type $login
//	 * @param unknown_type $contrasenia
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $estado_usuario
//	 * @param unknown_type $estilo_usuario
//	 * @param unknown_type $filtro_avanzado
//	 * @return unknown
//	 */
//	function ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
//	{
//		$this->salida = "";
//		$dbUsuario= new cls_DBUsuario($this->decodificar);
//		$res = $dbUsuario ->ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
//		$this->salida = $dbUsuario->salida;
//		$this->query = $dbUsuario->query;
//		return $res;
//	}
//
//	///////////// FIN USUARIOS /////////////////////////////


	///////// LOG ///////////////
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario
	 * @param unknown_type $modulo
	 * @param unknown_type $proceso
	 * @param unknown_type $fecha
	 * @param unknown_type $hora
	 * @param unknown_type $accion
	 * @param unknown_type $ip_origen
	 * @return unknown
	 */
	function CrearLog ($id_usuario,$modulo,$proceso, $fecha,$hora,$accion, $ip_origen)
	{
		$dbLog = new DBLog();
		$res = $dbLog -> CrearLog ($id_usuario,$modulo,$proceso, $fecha,$hora,$accion, $ip_origen);
		return $res;
	}

	///////// FIN LOG ///////////

	///////////PERMISOS////////////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $rol
	 * @param unknown_type $modulo
	 * @param unknown_type $proceso
	 * @param unknown_type $operacion
	 * @return unknown
	 */
	function VerificaPermiso($rol,$modulo,$proceso,$operacion)
	{
		$dbPermiso = new DBPermiso();
		$resultado = $dbPermiso -> VerificaPermiso($rol,$modulo,$proceso,$operacion);
		return $resultado;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $rol
	 * @return unknown
	 */
	function ListaPermiso($usuario,$id_rol,$ip_origen,$mac_maquina)
	{
		$this->salida = "";
		$dbPermiso = new cls_DBPermiso();
		$res = $dbPermiso -> ListaPermiso($usuario,$id_rol,$ip_origen,$mac_maquina);
		//$res = $dbPermiso -> ListaPermiso($usuario,$ip_origen,$mac_maquina);
		$this->salida = $dbPermiso->salida;
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_proceso
	 * @param unknown_type $id_modulo
	 * @param unknown_type $insertar
	 * @param unknown_type $eliminar
	 * @param unknown_type $modificar
	 * @param unknown_type $ver
	 * @param unknown_type $extra
	 * @return unknown
	 */
	function  CrearPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  CrearPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra);
		return $permisos;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_modulo
	 * @param unknown_type $id_proceso
	 * @return unknown
	 */
	function EliminaPermiso($id_rol,$id_modulo,$id_proceso)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso -> EliminaPermiso($id_rol,$id_modulo,$id_proceso);
		return $permisos;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_proceso
	 * @param unknown_type $id_modulo
	 * @param unknown_type $insertar
	 * @param unknown_type $eliminar
	 * @param unknown_type $modificar
	 * @param unknown_type $ver
	 * @param unknown_type $extra
	 * @param unknown_type $pk_id_proceso
	 * @param unknown_type $pk_id_modulo
	 * @return unknown
	 */
	function   ModificaPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra,$pk_id_proceso,$pk_id_modulo)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  ModificaPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra,$pk_id_proceso,$pk_id_modulo);
		return $permisos;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @return unknown
	 */
	function CuentaPermisosDelRol($id_rol)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  CuentaPermisosDelRol($id_rol);
		return $permisos;
	}

	////// FIN PERMISOSª///////////


	/////////////// ROLES /////////////////////
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $nombre
	 * @param unknown_type $nivel
	 * @param unknown_type $obs
	 * @return unknown
	 */
	function CrearRol ($nombre,$nivel=0,$obs)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> CrearRol ($nombre,$nivel,$obs);
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function CuentaListaPaginadaRol()
	{
		$dbRol = new DBRol();
		$res = $dbRol -> CuentaListaPaginadaRol();
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @return unknown
	 */
	function ListaPaginadaRol($cant,$puntero)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaPaginadaRol($cant,$puntero);
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @return unknown
	 */
	function EliminaRol ($id_rol)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> EliminaRol ($id_rol);
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $nombre
	 * @param unknown_type $nivel
	 * @param unknown_type $obs
	 * @return unknown
	 */
	function ModificaRol($id_rol,$nombre,$nivel,$obs)
	{
		$dbRol = new DBRol();
		$res = $dbRol ->  ModificaRol($id_rol,$nombre,$nivel,$obs);
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function ListaRol()
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaRol();
		return $res;
	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cant
	 * @param unknown_type $puntero
	 * @param unknown_type $sortCol
	 * @param unknown_type $sortDir
	 * @param unknown_type $filterCol
	 * @param unknown_type $filterValue
	 * @return unknown
	 */
	function  ListaParametrizadaRol($cant=-1,$puntero=0,$sortCol="id",$sortDir="asc",$filterCol="nombre",$filterValue="")
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaParametrizadaRol($cant,$puntero,$sortCol,$sortDir,$filterCol,$filterValue);
		return $res;
	}
	///////////// FIN ROLES /////////////////////////////


	/////////////// MODULOS /////////////////////
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function ListaModulo()
	{
		$dbModulo = new DBModulo();
		$res = $dbModulo -> ListaModulo();
		return $res;
	}

	///////////// FIN MODULOS/////////////////////////////

	/////////////// PROCESO /////////////////////
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function ListaProceso()
	{
		$dbProceso = new DBproceso();
		$res = $dbProceso -> ListaProceso();
		return $res;
	}

	/////////////   FIN  PROCESO  /////////////////////////////


//	/   PARAMETRO GENERAL /////////////////////////////
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbParametroGral= new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral->ListarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbParametroGral= new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral->ContarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_parametros_generales
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion
//	 * @return unknown
//	 */
//	function InsertarParametroGeneral($id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion)
//	{
//		$this->salida = "";
//		$dbParametroGral = new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral->InsertarParametroGeneral($id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_parametros_generales
//	 * @return unknown
//	 */
//	function EliminarParametroGeneral($id_parametros_generales)
//	{
//		$this->salida = "";
//		$dbParametroGral= new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral -> EliminarParametroGeneral($id_parametros_generales);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_parametros_generales
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion
//	 * @return unknown
//	 */
//	function ModificarParametroGeneral($id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion)
//	{
//		$this->salida = "";
//		$dbParametroGral= new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral->ModificarParametroGeneral($id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_parametros_generales
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion
//	 * @return unknown
//	 */
//	function ValidarParametroGeneral($operacion_sql, $id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion)
//	{
//		$this->salida = "";
//		$dbParametroGral= new cls_DBParametroGeneral($this->decodificar);
//		$res = $dbParametroGral ->ValidarParametroGeneral($operacion_sql, $id_parametros_generales,$nombre_atributo,$valor_atributo,$descripcion);
//		$this->salida = $dbParametroGral->salida;
//		$this->query = $dbParametroGral->query;
//		return $res;
//	}
//
//	/   FIN  PARAMETRO GENERAL /////////////////////////////


	//////////////MZM/////////////////////////////////////

	
//	 SUBSISTEMA //////////////////////////
//	/**
//	 * Nombre de la función:	ListarSubsistema
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	/*function ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbSubsistema->salida;
//
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//
//	/**
//	 * Nombre de la función:	ContarSubsistema
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	/*function ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbSubsistema->salida;
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//
//	/**
//	* Nombre de la función:	InsertarSubsistema
// 	* Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	* Autor:					Mercedes Zambrana Meneses
// 	* Fecha de creación:		28-08-2007
// 	*
// 	*
// 	* @param unknown_type $id_subsistema
// 	* @param unknown_type $nombre_corto
// 	* @param unknown_type $nombre_largo
//	* @param unknown_type $descripcion
//	* @param unknown_type $version_desarrollo
//	* @param unknown_type $desarrolladores
//	* @param unknown_type $fecha_registro
// 	* @param unknown_type $hora_registro
//	* @param unknown_type $fecha_ultima_modificacion
// 	* @param unknown_type $hora_ultima_modificacion
// 	* @param unknown_type $observaciones
// 	* @return unknown
// 	*/
//	/*function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
//	{
//
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
//		$this->salida = $dbSubsistema->salida;
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//
//	/**
//	 * Nombre de la función:	ModificarSubsistema
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @param unknown_type $nombre_corto
//	 * @param unknown_type $nombre_largo
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $version_desarrollo
//	 * @param unknown_type $desarrolladores
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $observaciones
//	 * @return unknown
//	 */
//	/*function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
//	{
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
//		$this->salida = $dbSubsistema->salida;
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//
//	/**
//	 * Nombre de la función:	EliminarSubsistema
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @return unknown
//	 */
//	/*function EliminarSubsistema($id_subsistema)
//	{
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->EliminarSubsistema($id_subsistema);
//		$this->salida = $dbSubsistema->salida;
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//
//	/** Nombre de la función:	ValidarSubsistema
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_subsistema
//	 * @param unknown_type $nombre_corto
//	 * @param unknown_type $nombre_largo
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $version_desarrollo
//	 * @param unknown_type $desarrolladores
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $observaciones
//	 * @return unknown
//	 */
//	/*function ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
//	{
//		$this->salida = "";
//		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
//		$res = $dbSubsistema->ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
//		$this->salida = $dbSubsistema->salida;
//		$this->query = $dbSubsistema->query;
//		return $res;
//	}*/
//	 FIN SUBSISTEMAS ////////////////////

//	/ PERSONA  ////////////////////////
//	/**
//	 * Nombre de la función:	ListarPersona
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPersona->salida;
//
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ContarPersona
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPersona->salida;
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//
//	/**
//	* Nombre de la función:	InsertarPersona
//	* Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
// 	* Autor:					Mercedes Zambrana Meneses
// 	* Fecha de creación:		28-08-2007
// 	*
// 	*
// 	* @param unknown_type $id_persona
// 	* @param unknown_type $apellido_paterno
// 	* @param unknown_type $apellido_paterno
// 	* @param unknown_type $nombre
// 	* @param unknown_type $fecha_nacimiento
// 	* @param unknown_type $foto_persona
// 	* @param unknown_type $doc_id
// 	* @param unknown_type $genero
// 	* @param unknown_type $casilla
// 	* @param unknown_type $telefono1
// 	* @param unknown_type $telefono2
// 	* @param unknown_type $celular1
// 	* @param unknown_type $celular2
// 	* @param unknown_type $pag_web
// 	* @param unknown_type $email1
// 	* @param unknown_type $email2
// 	* @param unknown_type $email3
// 	* @param unknown_type $fecha_registro
// 	* @param unknown_type $hora_registro
// 	* @param unknown_type $fecha_ultima_modificacion
// 	* @param unknown_type $hora_ultima_modificacion
// 	* @param unknown_type $observaciones
// 	* @param unknown_type $id_tipo_doc_identificacion
// 	* @return unknown
// 	*/
//	function InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
//		$this->salida = $dbPersona->salida;
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ModificarPersona
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @param unknown_type $nombre_corto
//	 * @param unknown_type $nombre_largo
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $version_desarrollo
//	 * @param unknown_type $desarrolladores
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $observaciones
//	 * @return unknown
//	 */
//	function ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
//		$this->salida = $dbPersona->salida;
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	EliminarPersona
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		28-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @return unknown
//	 */
//	function EliminarPersona($id_persona)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->EliminarPersona($id_persona);
//		$this->salida = $dbPersona->salida;
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_persona
//	 * @param unknown_type $apellido_paterno
//	 * @param unknown_type $apellido_paterno
//	 * @param unknown_type $nombre
//	 * @param unknown_type $fecha_nacimiento
//	 * @param unknown_type $foto_persona
//	 * @param unknown_type $doc_id
//	 * @param unknown_type $genero
//	 * @param unknown_type $casilla
//	 * @param unknown_type $telefono1
//	 * @param unknown_type $telefono2
//	 * @param unknown_type $celular1
//	 * @param unknown_type $celular2
//	 * @param unknown_type $pag_web
//	 * @param unknown_type $email1
//	 * @param unknown_type $email2
//	 * @param unknown_type $email3
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $observaciones
//	 * @param unknown_type $id_tipo_doc_identificacion
//	 * @return unknown
//	 */
//	function ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
//	{
//		$this->salida = "";
//		$dbPersona = new cls_DBPersona($this->decodificar);
//		$res = $dbPersona->ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
//		$this->salida = $dbPersona->salida;
//		$this->query = $dbPersona->query;
//		return $res;
//	}
//	/ FIN PERSONA////////////////////


	////////////////////////////  TIPO DOC IDENTIFICACION  ////////////////////////
	/**
	 * Nombre de la función:	ListarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
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
	function ListarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion->ListarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocIdentificacion->salida;

		$this->query = $dbTipoDocIdentificacion->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
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
	function ContarTipoDocIdetificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion-> ContarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocIdentificacion->salida;
		$this->query = $dbTipoDocIdentificacion->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 *
	 * @param unknown_type $id_tipo_doc_identificacion
	 * @param unknown_type $nombre_tipo_documento
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @return unknown
	 */
	function InsertarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion->InsertarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion->salida;
		$this->query = $dbTipoDocIdentificacion->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 *
	 * @param unknown_type $id_subsistema
	 * @param unknown_type $nombre_corto
	 * @param unknown_type $nombre_largo
	 * @param unknown_type $descripcion
	 * @param unknown_type $version_desarrollo
	 * @param unknown_type $desarrolladores
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $observaciones
	 * @return unknown
	 */
	function ModificarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion->ModificarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion->salida;
		$this->query = $dbTipoDocIdentificacion->query;
		return $res;
	}

	/**
	 * Nombre de la función:	eliminarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarTipoDocIdentificacion($id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion= new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion->EliminarTipoDocIdentificacion($id_tipo_doc_identificacion);
		$this->salida = $dbTipoDocIdentificacion->salida;
		$this->query = $dbTipoDocIdentificacion->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_doc_identificacion
	 * @param unknown_type $nombre_tipo_documento
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @return unknown
	 */
	function ValidarTipoDocIdentificacion($operacion_sql,$id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion->ValidarTipoDocIdentificacion($operacion_sql,$id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion->salida;
		$this->query = $dbTipoDocIdentificacion->query;
		return $res;
	}
	///////////////////////////  FIN TIPO DOC IDENTIFICACION //////////////////////////


	////////////////////////////  METAPROCESO ////////////////////////
	/**
	 * Nombre de la función:	ListarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		29-08-2007
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
	/*function ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso->ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbMetaproceso->salida;

	$this->query = $dbMetaproceso->query;
	return $res;
	}*/

	/**
	 * Nombre de la función:	ContarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
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
	/*function ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso-> ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida = $dbMetaproceso->salida;
	$this->query = $dbMetaproceso->query;

	return $res;
	}*/

	/**
	 * Nombre de la función:	InsertarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		29-08-2007
	 *
	 * @param unknown_type $id_metaproceso
	 * @param unknown_type $nivel
	 * @param unknown_type $nombre
	 * @param unknown_type $codigo_procedimiento
	 * @param unknown_type $nombre_archivo
	 * @param unknown_type $ruta_archivo
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $descripcion
	 * @param unknown_type $visible
	 * @param unknown_type $habilitar_log
	 * @param unknown_type $orden_logico
	 * @param unknown_type $id_subsistema
	 * @param unknown_type $fk_id_metaproceso
	 * @return unknown
	 */
	/*function InsertarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
	$this->salida = "";
	$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso->InsertarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
	$this->salida = $dbMetaproceso->salida;
	$this->query = $dbMetaproceso->query;
	return $res;
	}*/

	/**
	 * Nombre de la función:	ModificarTipoDocIdentificacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $id_metaproceso
	 * @param unknown_type $nivel
	 * @param unknown_type $nombre
	 * @param unknown_type $codigo_procedimiento
	 * @param unknown_type $nombre_archivo
	 * @param unknown_type $ruta_archivo
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $descripcion
	 * @param unknown_type $visible
	 * @param unknown_type $habilitar_log
	 * @param unknown_type $orden_logico
	 * @param unknown_type $id_subsistema
	 * @param unknown_type $fk_id_metaproceso
	 * @return unknown
	 */
	/*function ModificarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
	$this->salida = "";
	$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso->ModificarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
	$this->salida = $dbMetaproceso->salida;
	$this->query = $dbMetaproceso->query;
	return $res;
	}*/

	/**
	 * Nombre de la función:	eliminarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $id_metaproceso
	 * @return unknown
	 */
	/*function EliminarMetaproceso($id_metaproceso)
	{
	$this->salida = "";
	$dbMetaproceso= new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso->EliminarMetaproceso($id_metaproceso);
	$this->salida = $dbMetaproceso->salida;
	$this->query = $dbMetaproceso->query;
	return $res;
	}*/

	/**
	 * Nombre de la función:	ValidarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		29-08-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_tipo_doc_identificacion
	 * @param unknown_type $nombre_tipo_documento
	 * @param unknown_type $descripcion
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @return unknown
	 */
	/*function ValidarMetaproceso($operacion_sql,$id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
	$this->salida = "";
	$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
	$res = $dbMetaproceso->ValidarMetaproceso($operacion_sql,$id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
	$this->salida = $dbMetaproceso->salida;
	$this->query = $dbMetaproceso->query;
	return $res;
	}*/
	/////////////////////////// FIN METAPROCESO ///////////////////////


//	  PREFERENCIA DETALLE ////////////////////////
//	/**
//	 * Nombre de la función:	ListarPreferenciaDetalle
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle->ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferenciaDetalle->salida;
//
//		$this->query = $dbPreferenciaDetalle->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ContarPreferenciaDetalle
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle-> ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferenciaDetalle->salida;
//		$this->query = $dbPreferenciaDetalle->query;
//
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	InsertarPreferenciaDetalle
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $id_preferencia_detalle
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion_atributo
//	 * @param unknown_type $id_preferencia
//	 * @return unknown
//	 */
//	function InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
//	{
//		$this->salida = "";
//		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle->InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
//		$this->salida = $dbPreferenciaDetalle->salida;
//		$this->query = $dbPreferenciaDetalle->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ModificarPreferenciaDetalle
//	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_preferencia_detalle
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion_atributo
//	 * @param unknown_type $id_preferencia
//	 * @return unknown
//	 */
//	function ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
//	{
//		$this->salida = "";
//		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle->ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
//		$this->salida = $dbPreferenciaDetalle->salida;
//		$this->query = $dbPreferenciaDetalle->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	eliminarPreferenciaDetalle
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @return unknown
//	 */
//	function EliminarPreferenciaDetalle($id_preferencia_detalle)
//	{
//		$this->salida = "";
//		$dbPreferenciaDetalle= new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle->EliminarPreferenciaDetalle($id_preferencia_detalle);
//		$this->salida = $dbPreferenciaDetalle->salida;
//		$this->query = $dbPreferenciaDetalle->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ValidarPreferenciaDetalle
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_tipo_doc_identificacion
//	 * @param unknown_type $nombre_tipo_documento
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @return unknown
//	 */
//	function ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
//	{
//
//		$this->salida = "";
//		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
//		$res = $dbPreferenciaDetalle->ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
//		$this->salida = $dbPreferenciaDetalle->salida;
//		$this->query = $dbPreferenciaDetalle->query;
//		return $res;
//	}
//	 FIN PREFERENCIA DETALLE ////////////////////////

	//////////////////////////// ENVIO ALERTA A USUARIO ////////////////////////
	/**
	 * Nombre de la función:	ListarUsuarioEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
	function ListarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ListarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarUsuarioEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
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
	function ContarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta-> ContarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarUsuarioEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_usuario_envio_alerta
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
	function InsertarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->InsertarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarUsuarioEnvioAlerta
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_usuario_envio_alerta
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
	function ModificarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ModificarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	/**
	 * Nombre de la función:	eliminarUsuarioEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarUsuarioEnvioAlerta($id_usuario_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta= new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->EliminarUsuarioEnvioAlerta($id_usuario_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarUsuarioEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_usuario_envio_alerta
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
	function ValidarUsuarioEnvioAlerta($operacion_sql,$id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{

		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ValidarUsuarioEnvioAlerta($operacion_sql,$id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}
	//////////////////////////// FIN ENVIO ALERTA A USUARIO ////////////////////////

	//////////////////////////// ENVIO ALERTA A METAPROCESO ////////////////////////
	/**
	 * Nombre de la función:	ListarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
//	function ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta->ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	ContarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
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
//	function ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta-> ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//
//		return $res;
//	}

	/**
	 * Nombre de la función:	InsertarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_Metaproceso_envio_alerta
	 * @param unknown_type $id_Metaproceso
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
//	 */
//	function InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
//	{
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta->InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	ModificarMetaprocesoEnvioAlerta
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_Metaproceso_envio_alerta
	 * @param unknown_type $id_Metaproceso
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
//	{
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta->ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	eliminarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
//	function EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta)
//	{
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta= new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta->EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//		return $res;
//	}
//
	/**
	 * Nombre de la función:	ValidarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_Metaproceso_envio_alerta
	 * @param unknown_type $id_Metaproceso
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
//	 */
//	function ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
//	{
//
//		$this->salida = "";
//		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
//		$res = $dbMetaprocesoEnvioAlerta->ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
//		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
//		$this->query = $dbMetaprocesoEnvioAlerta->query;
//		return $res;
//	}
//	//////////////////////////// FIN ENVIO ALERTA A METAPROCESO ////////////////////////

	//////////////////////////// ROL ////////////////////////
	/**
	 * Nombre de la función:	ListarRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
	function ListarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol->ListarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ContarRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
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
	function ContarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol-> ContarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;

		return $res;
	}

	/**
	 * Nombre de la función:	InsertarRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $nombre
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function InsertarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol->InsertarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ModificarRol
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_rol
	 * @param unknown_type $nombre
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function ModificarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol->ModificarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;
		return $res;
	}

	/**
	 * Nombre de la función:	eliminarRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_rol
	 * @return unknown
	 */
	function EliminarRol($id_rol)
	{
		$this->salida = "";
		$dbRol= new cls_DBRol($this->decodificar);
		$res = $dbRol->EliminarRol($id_rol);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;
		return $res;
	}

	/**
	 * Nombre de la función:	ValidarRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_rol
	 * @param unknown_type $nombre
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $descripcion
	 * @return unknown
	 */
	function ValidarRol($operacion_sql,$id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{

		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol->ValidarRol($operacion_sql,$id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol->salida;
		$this->query = $dbRol->query;
		return $res;
	}
	//////////////////////////// FIN ROL ////////////////////////

//	  PREFERENCIA  ////////////////////////
//	/**
//	 * Nombre de la función:	ListarPreferencia
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia->ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ContarPreferencia
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia-> ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	InsertarPreferencia
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $id_preferencia_
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion_atributo
//	 * @param unknown_type $id_preferencia
//	 * @return unknown
//	 */
//	function InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
//	{
//		$this->salida = "";
//		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia->InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ModificarPreferencia
//	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_preferencia_
//	 * @param unknown_type $nombre_atributo
//	 * @param unknown_type $valor_atributo
//	 * @param unknown_type $descripcion_atributo
//	 * @param unknown_type $id_preferencia
//	 * @return unknown
//	 */
//	function ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
//	{
//		$this->salida = "";
//		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia->ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	eliminarPreferencia
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $id_subsistema
//	 * @return unknown
//	 */
//	function EliminarPreferencia($id_preferencia)
//	{
//		$this->salida = "";
//		$dbPreferencia= new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia->EliminarPreferencia($id_preferencia);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ValidarPreferencia
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_tipo_doc_identificacion
//	 * @param unknown_type $nombre_tipo_documento
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @return unknown
//	 */
//	function ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo)
//	{
//
//		$this->salida = "";
//		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
//		$res = $dbPreferencia->ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo);
//		$this->salida = $dbPreferencia->salida;
//		$this->query = $dbPreferencia->query;
//		return $res;
//	}
//	 FIN PREFERENCIA  ////////////////////////


	////////////////////////  USUARIO ASIGNACION ////////////////////////
	/**
//	 * Nombre de la función:	ListarUsuarioAsignacion 
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion->ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ContarUsuarioAsignacion
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion-> ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	InsertarUsuarioAsignacion
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Mercedes Zambrana Meneses
//	 * Fecha de creación:		30-08-2007
//	 *
//	 *
//	 * @param unknown_type $id_usuario_envio_alerta
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $id_envio_alerta
//	 * @return unknown
//	 */
//	function InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion->InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//		return $res;
//	}
//
	/**
	 * Nombre de la función:	ModificarUsuarioAsignacion
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_usuario_envio_alerta
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function ModificarUsuarioAsignacion($id_usuario_asignacion, $id_asignacion_estructura,$id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion->ModificarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//		return $res;
//	}
//
	/**
	 * Nombre de la función:	eliminarUsuarioAsignacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
//	function EliminarUsuarioAsignacion($id_usuario_asignacion)
//	{
//		$this->salida = "";
//		$dbUsuarioAsignacion= new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion->EliminarUsuarioAsignacion($id_usuario_asignacion);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//		return $res;
//	}
//
	/**
	 * Nombre de la función:	ValidarUsuarioAsignacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_usuario_envio_alerta
	 * @param unknown_type $id_usuario
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion, $id_asignacion_estructura,$id_usuario)
//	{
//
//		$this->salida = "";
//		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
//		$res = $dbUsuarioAsignacion->ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
//		$this->salida = $dbUsuarioAsignacion->salida;
//		$this->query = $dbUsuarioAsignacion->query;
//		return $res;
//	}
	////////////////////////// FIN USUARIO ASIGNACION ////////////////////////

	//////////////////////////// ENVIO ALERTA ////////////////////////
	/**
	 * Nombre de la función:	ListarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
//	function ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta->ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//		return $res;
//	}
//
	/**
	 * Nombre de la función:	ContarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
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
//	function ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta-> ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//
//		return $res;
//	}

	/**
	 * Nombre de la función:	InsertarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_envio_alerta
	 * @param unknown_type $id_
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta->InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	ModificarEnvioAlerta
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_envio_alerta
	 * @param unknown_type $id_
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta->ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	eliminarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
//	function EliminarEnvioAlerta($id_envio_alerta)
//	{
//		$this->salida = "";
//		$dbEnvioAlerta= new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta->EliminarEnvioAlerta($id_envio_alerta);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//		return $res;
//	}

	/**
	 * Nombre de la función:	ValidarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_envio_alerta
	 * @param unknown_type $id_
	 * @param unknown_type $id_envio_alerta
	 * @return unknown
	 */
//	function ValidarEnvioAlerta($operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
//	{
//
//		$this->salida = "";
//		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
//		$res = $dbEnvioAlerta->ValidarEnvioAlerta(operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
//		$this->salida = $dbEnvioAlerta->salida;
//		$this->query = $dbEnvioAlerta->query;
//		return $res;
//	}
	//////////////////////////// FIN ENVIO ALERTA ////////////////////////

	///////////////////// FIN MZM ///////////////////////////


///*	//////////  JGL   ////////////////////////////
//
//	/*/////////////// LUGAR /////////////////////
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar ->ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//		return true;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar ->ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $fk_id_lugar
//	 * @param unknown_type $nivel
//	 * @param unknown_type $codigo
//	 * @param unknown_type $nombre
//	 * @param unknown_type $ubicacion
//	 * @param unknown_type $telefono1
//	 * @param unknown_type $telefono2
//	 * @param unknown_type $fax
//	 * @param unknown_type $observacion
//	 * @return unknown
//	 */
//	function InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar ->InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_lugar
//	 * @return unknown
//	 */
//	function EliminarLugar($id_lugar)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar -> EliminarLugar($id_lugar);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//
//
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $fk_id_lugar
//	 * @param unknown_type $nivel
//	 * @param unknown_type $codigo
//	 * @param unknown_type $nombre
//	 * @param unknown_type $ubicacion
//	 * @param unknown_type $telefono1
//	 * @param unknown_type $telefono2
//	 * @param unknown_type $fax
//	 * @param unknown_type $observacion
//	 * @return unknown
//	 */
//	function ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar ->ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $fk_id_lugar
//	 * @param unknown_type $nivel
//	 * @param unknown_type $codigo
//	 * @param unknown_type $nombre
//	 * @param unknown_type $ubicacion
//	 * @param unknown_type $telefono1
//	 * @param unknown_type $telefono2
//	 * @param unknown_type $fax
//	 * @param unknown_type $observacion
//	 * @return unknown
//	 */
//	function ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
//	{
//		$this->salida = "";
//		$dbLugar = new cls_DBLugar($this->decodificar);
//		$res = $dbLugar ->ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
//		$res = $dbLugar ->ValidarLugar($operacion_sql,$id_lugar,$id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
//		$this->salida = $dbLugar->salida;
//		$this->query = $dbLugar->query;
//		return $res;
//	}
//	///   FIN LUGAR /////////////////////////////*/*/


	/////////////// ROL METAPROCESO /////////////////////
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
	function ListarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ListarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;
		return true;
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
	function ContarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ContarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol_metaproceso
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_metaproceso
	 * @return unknown
	 */
	function InsertarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->InsertarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol_metaproceso
	 * @return unknown
	 */
	function EliminarRolMetaproceso($id_rol_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso -> EliminarRolMetaproceso($id_rol_metaproceso);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;


	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_rol_metaproceso
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_metaproceso
	 * @return unknown
	 */
	function ModificarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ModificarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;
	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_rol_metaproceso
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_metaproceso
	 * @return unknown
	 */
	function ValidarRolMetaproceso($operacion_sql,$id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ValidarRolMetaproceso($operacion_sql,$id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso->salida;
		$this->query = $dbRolMetaproceso->query;
		return $res;
	}
	/////////////   FIN ROL METAPROCESO /////////////////////////////


//	/ PREFERENCIA USUARIO /////////////////////
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario ->ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//		return true;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario ->ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_preferencia_usuario
//	 * @param unknown_type $id_preferencia
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario ->InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_preferencia_usuario
//	 * @return unknown
//	 */
//	function EliminarPreferenciaUsuario($id_preferencia_usuario)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario -> EliminarPreferenciaUsuario($id_preferencia_usuario);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//
//
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_preferencia_usuario
//	 * @param unknown_type $id_preferencia
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario ->ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_preferencia_usuario
//	 * @param unknown_type $id_preferencia
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario)
//	{
//		$this->salida = "";
//		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
//		$res = $dbPreferenciaUsuario ->ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario);
//		$this->salida = $dbPreferenciaUsuario->salida;
//		$this->query = $dbPreferenciaUsuario->query;
//		return $res;
//	}
//	   FIN PREFERENCIA USUARIO /////////////////////////////

	///////////////////// FIN JGL ///////////////////////////


	/////////////////////// GVC /////////////////////////////

	///////////////////// HistClave /////////////////////

//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave ->ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave ->ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_hist_clave
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $fecha_cambio
//	 * @param unknown_type $hora_cambio
//	 * @param unknown_type $contrasenia_anterior
//	 * @return unknown
//	 */
//	function InsertarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave ->InsertarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}

//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_hist_clave
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $fecha_cambio
//	 * @param unknown_type $hora_cambio
//	 * @param unknown_type $contrasenia_anterior
//	 * @return unknown
//	 */
//	function ModificarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave ->ModificarHistClave($id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_hist_clave
//	 * @return unknown
//	 */
//	function EliminarHistClave($id_hist_clave)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave -> EliminarHistClave($id_concepto);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_hist_clave
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $fecha_cambio
//	 * @param unknown_type $hora_cambio
//	 * @param unknown_type $contrasenia_anterior
//	 * @return unknown
//	 */
//	function ValidarHistClave($operacion_sql, $id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior)
//	{
//		$this->salida = "";
//		$dbHistClave = new cls_DBHistClave($this->decodificar);
//		$res = $dbHistClave ->ValidarHistClave($operacion_sql, $id_hist_clave, $id_usuario, $fecha_cambio, $hora_cambio, $contrasenia_anterior);
//		$this->salida = $dbHistClave->salida;
//		$this->query = $dbHistClave->query;
//		return $res;
//	}
//
//	///////////////////// FIN HistClave /////////////////////

	//////////////////// Usuario Lugar ////////////////////

//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar ->ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar ->ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_usuario_lugar
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function InsertarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar ->InsertarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_usuario_lugar
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function ModificarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar ->ModificarUsuarioLugar($id_usuario_lugar, $id_lugar, $id_usuario);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_usuario_lugar
//	 * @return unknown
//	 */
//	function EliminarUsuarioLugar($id_usuario_lugar)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar -> EliminarUsuarioLugar($id_usuario_lugar);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_usuario_lugar
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $id_usuario
//	 * @return unknown
//	 */
//	function ValidarUsuarioLugar($operacion_sql, $id_usuario_lugar, $id_lugar, $id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
//		$res = $dbUsuarioLugar ->ValidarUsuarioLugar($operacion_sql, $id_usuario_lugar, $id_lugar, $id_usuario);
//		$this->salida = $dbUsuarioLugar->salida;
//		$this->query = $dbUsuarioLugar->query;
//		return $res;
//	}
//	//////////////////// FIN UsuarioLugar ////////////////////

	////////// Asignacion Estructura Tpm Frppa ////////////////////

//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa ->ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}

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
//	function ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa ->ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}

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
//	function InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa ->InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}

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
//	function ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa ->ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}
//
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_asignacion_estructura_frppa
	 * @return unknown
	 */
//	function EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa -> EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}

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
//	function ValidarAsignacionEstructuraTpmFrppa($operacion_sql, $id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
//		$res = $dbAsignacionEstructuraTpmFrppa ->ValidarAsignacionEstructuraTpmFrppa($operacion_sql, $id_asignacion_estructura_frppa, $id_fina_regi_prog_proy_acti, $fecha_registro, $hora_registro, $id_asignacion_estructura, $editar);
//		$this->salida = $dbAsignacionEstructuraTpmFrppa->salida;
//		$this->query = $dbAsignacionEstructuraTpmFrppa->query;
//		return $res;
//	}
	////////// FIN Asignacion Estructura Tpm Frppa ////////////////////

//	 Registro Evento ////////////////////
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
//		$res = $dbRegistroEvento ->ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbRegistroEvento->salida;
//		$this->query = $dbRegistroEvento->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $cant
//	 * @param unknown_type $puntero
//	 * @param unknown_type $sortcol
//	 * @param unknown_type $sortdir
//	 * @param unknown_type $criterio_filtro
//	 * @param unknown_type $id_financiador
//	 * @param unknown_type $id_regional
//	 * @param unknown_type $id_programa
//	 * @param unknown_type $id_proyecto
//	 * @param unknown_type $id_actividad
//	 * @return unknown
//	 */
//	function ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
//		$res = $dbRegistroEvento ->ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbRegistroEvento->salida;
//		$this->query = $dbRegistroEvento->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $id_registro_eventos
//	 * @return unknown
//	 */
//	function EliminarRegistroEvento($id_registro_eventos)
//	{
//		$this->salida = "";
//		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
//		$res = $dbRegistroEvento -> EliminarRegistroEvento($id_registro_eventos);
//		$this->salida = $dbRegistroEvento->salida;
//		$this->query = $dbRegistroEvento->query;
//		return $res;
//	}
//
//	/**
//	 * Enter description here...
//	 *
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_registro_eventos
//	 * @param unknown_type $id_usuario
//	 * @param unknown_type $id_subsistema
//	 * @param unknown_type $id_lugar
//	 * @param unknown_type $fecha
//	 * @param unknown_type $hora
//	 * @param unknown_type $numero_error
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $ip_origen
//	 * @param unknown_type $log_error
//	 * @param unknown_type $codigo_procedimiento
//	 * @param unknown_type $mac_maquina
//	 * @param unknown_type $proc_almacenado
//	 * @return unknown
//	 */
//	function ValidarRegistroEvento($operacion_sql, $id_registro_eventos, $id_usuario, $id_subsistema, $id_lugar, $fecha, $hora, $numero_error, $descripcion, $ip_origen, $log_error, $codigo_procedimiento, $mac_maquina, $proc_almacenado)
//	{
//		$this->salida = "";
//		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
//		$res = $dbRegistroEvento ->ValidarRegistroEvento($operacion_sql, $id_registro_eventos, $id_usuario, $id_subsistema, $id_lugar, $fecha, $hora, $numero_error, $descripcion, $ip_origen, $log_error, $codigo_procedimiento, $mac_maquina, $proc_almacenado);
//		$this->salida = $dbRegistroEvento->salida;
//		$this->query = $dbRegistroEvento->query;
//		return $res;
//	}
	//////////////// FIN Registro Evento ////////////////////


	/////////////////////// FIN GVC /////////////////////////////



	////////////////////// ARV /////////////////////////////////


	////////////////////////////  USUARIO ROL ////////////////////////
	/**
	 * Nombre de la función:	ListarUsuarioRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Anacleto Rojas Veizaga
	 * Fecha de creación:		30-08-2007
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
//	 */
//	function ListarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
//		$res = $dbUsuarioRol->ListarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//		return $res;
//	}
	/**
	 * Nombre de la función:	ContarUsuarioRol
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Anacleto Rojas Veizaga
	 * Fecha de creación:		30-08-2007
	 *
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
//	function ContarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
//		$res = $dbUsuarioRol-> ContarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//
//		return $res;
//	}
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_rol
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
//	function InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioRol = new cls_DBMetaproceso($this->decodificar);
//		$res = $dbUsuarioRol->InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//		return $res;
//	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_rol
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
//	function ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
//		$res = $dbUsuarioRol->ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//		return $res;
//	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_usuario_rol
	 * @return unknown
	 */
//	function EliminarUsuarioRol($id_usuario_rol)
//	{
//		$this->salida = "";
//		$dbUsuarioRol= new cls_DBUsuarioRol($this->decodificar);
//		$res = $dbUsuarioRol->EliminarUsuarioRol($id_usuario_rol);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//		return $res;
//	}

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_usuario_rol
	 * @param unknown_type $id_rol
	 * @param unknown_type $id_usuario
	 * @return unknown
//	 */
//	function ValidarUsuarioRol($operacion_sql,$id_usuario_rol,$id_rol,$id_usuario)
//	{
//		$this->salida = "";
//		$dbUsuarioRol = new cls_DBMetaproceso($this->decodificar);
//		$res = $dbUsuarioRol->ValidarUsuarioRol($operacion_sql,$id_usuario_rol,$id_rol,$id_usuario);
//		$this->salida = $dbUsuarioRol->salida;
//		$this->query = $dbUsuarioRol->query;
//		return $res;
//	}

	//////////////////////////// FIN USUARIO ROL ////////////////////////


//	/**
//	 * Nombre de la función:	InsertarAsignacionEstructura
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Anacleto Rojas Veizaga
//	 * Fecha de creación:		03-09-2007
//	 *
//	
//	 */
//	function InsertarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
//		$res = $dbAsignacionEstructura->InsertarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
//		$this->salida = $dbAsignacionEstructura->salida;
//		$this->query = $dbAsignacionEstructura->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ModificarAsignacionEstructura
//	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
//	 * Autor:					Anacleto Rojas veizaga
//	 * Fecha de creación:		03-09-2007
//	 *
//	 * @param unknown_type $id_asignacion_estructura
//	 * @param unknown_type $nombre
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $validar_estructura
//	 * @return unknown
//	 */
//	function ModificarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
//		$res = $dbAsignacionEstructura->ModificarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
//		$this->salida = $dbAsignacionEstructura->salida;
//		$this->query = $dbAsignacionEstructura->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	eliminarAsignacionEstructura
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Anacleto Rojas Veizaga
//	 * Fecha de creación:		03-09-2007
//	 * @param unknown_type $id_asignacion_estructura
//	 * @return unknown
//	 */
//	function EliminarAsignacionEstructura($id_asignacion_estructura)
//	{
//		$this->salida = "";
//		$dbAsignacionEstructura= new cls_DBAsignacionEstructura($this->decodificar);
//		$res = $dbAsignacionEstructura->EliminarAsignacionEstructura($id_asignacion_estructura);
//		$this->salida = $dbAsignacionEstructura->salida;
//		$this->query = $dbAsignacionEstructura->query;
//		return $res;
//	}
//
//	/**
//	 * Nombre de la función:	ValidarAsignacionEstructura
//	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
//	 * Autor:					Anacleto Rojas Veizaga
//	 * Fecha de creación:		03-09-2007
//	
//	 * @param unknown_type $operacion_sql
//	 * @param unknown_type $id_asignacion_estructura
//	 * @param unknown_type $nombre
//	 * @param unknown_type $descripcion
//	 * @param unknown_type $fecha_registro
//	 * @param unknown_type $hora_registro
//	 * @param unknown_type $fecha_ultima_modificacion
//	 * @param unknown_type $hora_ultima_modificacion
//	 * @param unknown_type $validar_estructura
//	 * @return unknown
//	 */
//	function ValidarAsignacionEstructura($operacion_sql,$id_asignacion_estructura, $nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
//	{
//
//		$this->salida = "";
//		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
//		$res = $dbAsignacionEstructura->ValidarAsignacionEstructura($operacion_sql,$id_asignacion_estructura, $nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
//		$this->salida = $dbAsignacionEstructura->salida;
//		$this->query = $dbAsignacionEstructura->query;
//		return $res;
//	}
//
//	////////////////////////////  	FIN ASIGNACION ESTRUCTURA ////////////////////////
//
//
//	///////////////////// FIN ARV //////////////////////////////
/// --------------------- tsg_metaproceso --------------------- ///

	function ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function InsertarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->InsertarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ModificarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ModificarMetaproceso($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function EliminarMetaproceso($id_metaproceso)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso -> EliminarMetaproceso($id_metaproceso);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ValidarMetaproceso($operacion_sql,$id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ValidarMetaproceso($operacion_sql,$id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_metaproceso --------------------- ///
	
	
		/// --------------------- tsg_lugar --------------------- ///

	function ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function EliminarLugar($id_lugar)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar -> EliminarLugar($id_lugar);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_lugar --------------------- ///
	
		
	
	/// --------------------- tsg_asignacion_estructura --------------------- ///

	function ListarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura ->ListarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	function ContarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura ->ContarAsignacionEstructura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	function InsertarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura ->InsertarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	function ModificarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura ->ModificarAsignacionEstructura($id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	function EliminarAsignacionEstructura($id_asignacion_estructura)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura -> EliminarAsignacionEstructura($id_asignacion_estructura);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	function ValidarAsignacionEstructura($operacion_sql,$id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura)
	{
		$this->salida = "";
		$dbAsignacionEstructura = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbAsignacionEstructura ->ValidarAsignacionEstructura($operacion_sql,$id_asignacion_estructura,$nombre,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$validar_estructura);
		$this->salida = $dbAsignacionEstructura ->salida;
		$this->query = $dbAsignacionEstructura ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_asignacion_estructura --------------------- ///

/// --------------------- tsg_asignacion_estructura_tpm_frppa --------------------- ///

	function ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ListarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	function ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ContarAsignacionEstructuraTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	function InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->InsertarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	function ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ModificarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	function EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa -> EliminarAsignacionEstructuraTpmFrppa($id_asignacion_estructura_frppa);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	function ValidarAsignacionEstructuraTpmFrppa($operacion_sql,$id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAsignacionEstructuraTpmFrppa = new cls_DBAsignacionEstructuraTpmFrppa($this->decodificar);
		$res = $dbAsignacionEstructuraTpmFrppa ->ValidarAsignacionEstructuraTpmFrppa($operacion_sql,$id_asignacion_estructura_frppa,$fecha_registro,$hora_registro,$id_asignacion_estructura,$editar,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAsignacionEstructuraTpmFrppa ->salida;
		$this->query = $dbAsignacionEstructuraTpmFrppa ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_asignacion_estructura_tpm_frppa --------------------- ///

/// --------------------- tsg_envio_alerta --------------------- ///

	function ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta ->ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	function ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta ->ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	function InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta ->InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	function ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta ->ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	function EliminarEnvioAlerta($id_envio_alerta)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta -> EliminarEnvioAlerta($id_envio_alerta);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	function ValidarEnvioAlerta($operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta ->ValidarEnvioAlerta($operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta ->salida;
		$this->query = $dbEnvioAlerta ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_envio_alerta --------------------- ///
	
	/// --------------------- tsg_metaproceso_envio_alerta --------------------- ///

	function ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta ->ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	function ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta ->ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	function InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta ->InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	function ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta ->ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	function EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta -> EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	function ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta ->ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta ->salida;
		$this->query = $dbMetaprocesoEnvioAlerta ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_metaproceso_envio_alerta --------------------- ///
	
	/// --------------------- tsg_usuario --------------------- ///

	function ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ListarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ContarUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function EliminarUsuario($id_usuario)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario -> EliminarUsuario($id_usuario);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_usuario --------------------- ///
	
	
	/// --------------------- tsg_usuario_rol --------------------- ///

	function ListarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->ListarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	function ContarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->ContarUsuarioRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	function InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	function ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	function EliminarUsuarioRol($id_usuario_rol)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol -> EliminarUsuarioRol($id_usuario_rol);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	function ValidarUsuarioRol($operacion_sql,$id_usuario_rol,$id_rol,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->ValidarUsuarioRol($operacion_sql,$id_usuario_rol,$id_rol,$id_usuario);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_usuario_rol --------------------- ///
	/// --------------------- tsg_parametro_general --------------------- ///

	function ListarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral ->ListarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	function ContarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral ->ContarParametroGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	function InsertarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral ->InsertarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	function ModificarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral ->ModificarParametroGeneral($id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	function EliminarParametroGeneral($id_parametro_general)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral -> EliminarParametroGeneral($id_parametro_general);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	function ValidarParametroGeneral($operacion_sql,$id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion)
	{
		$this->salida = "";
		$dbParametroGeneral = new cls_DBParametroGeneral($this->decodificar);
		$res = $dbParametroGeneral ->ValidarParametroGeneral($operacion_sql,$id_parametro_general,$nombre_atributo,$valor_atributo,$descripcion);
		$this->salida = $dbParametroGeneral ->salida;
		$this->query = $dbParametroGeneral ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_parametro_general --------------------- ///
	
	/// --------------------- tsg_usuario_lugar --------------------- ///

	function ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ListarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	function ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ContarUsuarioLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	function InsertarUsuarioLugar($id_usuario_lugar,$id_lugar,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->InsertarUsuarioLugar($id_usuario_lugar,$id_lugar,$id_usuario);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	function ModificarUsuarioLugar($id_usuario_lugar,$id_lugar,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ModificarUsuarioLugar($id_usuario_lugar,$id_lugar,$id_usuario);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	function EliminarUsuarioLugar($id_usuario_lugar)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar -> EliminarUsuarioLugar($id_usuario_lugar);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	function ValidarUsuarioLugar($operacion_sql,$id_usuario_lugar,$id_lugar,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioLugar = new cls_DBUsuarioLugar($this->decodificar);
		$res = $dbUsuarioLugar ->ValidarUsuarioLugar($operacion_sql,$id_usuario_lugar,$id_lugar,$id_usuario);
		$this->salida = $dbUsuarioLugar ->salida;
		$this->query = $dbUsuarioLugar ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_usuario_lugar --------------------- ///
	
	
	/// --------------------- tsg_usuario_asignacion --------------------- ///

	function ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion ->ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	function ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion ->ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	function InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion ->InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	function ModificarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion ->ModificarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	function EliminarUsuarioAsignacion($id_usuario_asignacion)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion -> EliminarUsuarioAsignacion($id_usuario_asignacion);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	function ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion,$id_asignacion_estructura,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion ->ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion ->salida;
		$this->query = $dbUsuarioAsignacion ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_usuario_asignacion --------------------- ///
	/// --------------------- tsg_registro_evento --------------------- ///

	function ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ListarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	function ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ContarRegistroEvento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	function InsertarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->InsertarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	function ModificarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ModificarRegistroEvento($id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	function EliminarRegistroEvento($id_registro_eventos)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento -> EliminarRegistroEvento($id_registro_eventos);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	function ValidarRegistroEvento($operacion_sql,$id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina)
	{
		$this->salida = "";
		$dbRegistroEvento = new cls_DBRegistroEvento($this->decodificar);
		$res = $dbRegistroEvento ->ValidarRegistroEvento($operacion_sql,$id_registro_eventos,$id_usuario,$id_subsistema,$id_lugar,$fecha,$hora,$numero_error,$descripcion,$ip_origen,$log_error,$codigo_procedimiento,$proc_almacenado,$mac_maquina);
		$this->salida = $dbRegistroEvento ->salida;
		$this->query = $dbRegistroEvento ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_registro_evento --------------------- ///
	/// --------------------- tsg_subsistema --------------------- ///

	function ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function EliminarSubsistema($id_subsistema)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema -> EliminarSubsistema($id_subsistema);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	function ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_subsistema --------------------- ///
	
	/// --------------------- tsg_persona --------------------- ///

	function ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function EliminarPersona($id_persona)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona -> EliminarPersona($id_persona);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_persona --------------------- ///
	
	/// --------------------- tsg_hist_clave --------------------- ///

	function ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ListarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	function ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ContarHistClave($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	function InsertarHistClave($id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->InsertarHistClave($id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	function ModificarHistClave($id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ModificarHistClave($id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	function EliminarHistClave($id_hist_clave)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave -> EliminarHistClave($id_hist_clave);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	function ValidarHistClave($operacion_sql,$id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior)
	{
		$this->salida = "";
		$dbHistClave = new cls_DBHistClave($this->decodificar);
		$res = $dbHistClave ->ValidarHistClave($operacion_sql,$id_hist_clave,$id_usuario,$fecha_cambio,$hora_cambio,$contrasenia_anterior);
		$this->salida = $dbHistClave ->salida;
		$this->query = $dbHistClave ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_hist_clave --------------------- ///
	/// --------------------- tsg_preferencia --------------------- ///

	function ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia ->ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	function ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia ->ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	function InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia ->InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	function ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia ->ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	function EliminarPreferencia($id_preferencia)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia -> EliminarPreferencia($id_preferencia);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	function ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia ->ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia ->salida;
		$this->query = $dbPreferencia ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_preferencia --------------------- ///
	/// --------------------- tsg_preferencia_usuario --------------------- ///

	function ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	function ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	function InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	function ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	function EliminarPreferenciaUsuario($id_preferencia_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario -> EliminarPreferenciaUsuario($id_preferencia_usuario);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	function ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario ->salida;
		$this->query = $dbPreferenciaUsuario ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_preferencia_usuario --------------------- ///
		/// --------------------- tsg_preferencia_detalle --------------------- ///

	function ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle ->ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	function ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle ->ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	function InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle ->InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	function ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle ->ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	function EliminarPreferenciaDetalle($id_preferencia_detalle)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle -> EliminarPreferenciaDetalle($id_preferencia_detalle);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	function ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle ->ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle ->salida;
		$this->query = $dbPreferenciaDetalle ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_preferencia_detalle --------------------- ///

}
?>