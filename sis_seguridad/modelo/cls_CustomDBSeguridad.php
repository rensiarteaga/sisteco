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
		include_once(dirname(__FILE__)."../../../lib/lib_modelo/cls_middle.php");

		include_once("cls_DBUsuario.php");
		include_once("cls_DBParametroGeneral.php");
		//include_once("cls_DBLugar.php");
		include_once("cls_DBPermiso.php");
		//include_once("cls_DBPersona.php");
		//include_once("cls_DBSubsistema.php");

		//MZM
		include_once("cls_DBSubsistema.php");
		include_once("cls_DBPersona.php");
		//include_once("cls_DBPersona.php");
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

		//FERH
		include_once("cls_DBTareaPendiente.php");
		
		include_once("cls_DBDescTabla.php");
		include_once("cls_DBRelacion.php");
		
		include_once("cls_DBTabla.php");
		include_once("cls_DBCampo.php");
		//FIN FERH
		
		include_once("cls_DBSesion.php");
		
		include_once("cls_DBNivelSeguridad.php");

	}

	


	
	function CrearLog ($id_usuario,$modulo,$proceso, $fecha,$hora,$accion, $ip_origen)
	{
		$dbLog = new DBLog();
		$res = $dbLog -> CrearLog ($id_usuario,$modulo,$proceso, $fecha,$hora,$accion, $ip_origen);
		return $res;
	}

	
	function VerificaPermiso($rol,$modulo,$proceso,$operacion)
	{
		$dbPermiso = new DBPermiso();
		$resultado = $dbPermiso -> VerificaPermiso($rol,$modulo,$proceso,$operacion);
		return $resultado;
	}
	
	function ListaPermiso($usuario,$id_rol,$ip_origen,$mac_maquina)
	{
		$this->salida = "";
		$dbPermiso = new cls_DBPermiso();
		$res = $dbPermiso -> ListaPermiso($usuario,$id_rol,$ip_origen,$mac_maquina);
		//$res = $dbPermiso -> ListaPermiso($usuario,$ip_origen,$mac_maquina);
		$this->salida = $dbPermiso->salida;
		return $res;
	}
	
	function ListaPermisoArb($usuario,$id_rol,$ip_origen,$mac_maquina,$nivel,$meta)
	{
		$this->salida = "";
		$dbPermiso = new cls_DBPermiso();
		$res = $dbPermiso -> ListaPermisoArb($usuario,$id_rol,$ip_origen,$mac_maquina,$nivel,$meta);
		//$res = $dbPermiso -> ListaPermiso($usuario,$ip_origen,$mac_maquina);
		$this->salida = $dbPermiso->salida;
		return $res;
	}
	
	function  CrearPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  CrearPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra);
		return $permisos;
	}
	
	function EliminaPermiso($id_rol,$id_modulo,$id_proceso)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso -> EliminaPermiso($id_rol,$id_modulo,$id_proceso);
		return $permisos;
	}
	
	function   ModificaPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra,$pk_id_proceso,$pk_id_modulo)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  ModificaPermiso ($id_rol,$id_proceso,$id_modulo,$insertar,$eliminar,$modificar,$ver,$extra,$pk_id_proceso,$pk_id_modulo);
		return $permisos;
	}
	
	function CuentaPermisosDelRol($id_rol)
	{
		$dbPermiso = new DBPermiso();
		$permisos = $dbPermiso ->  CuentaPermisosDelRol($id_rol);
		return $permisos;
	}

	////// FIN PERMISOSª///////////


	
	function CrearRol ($nombre,$nivel=0,$obs)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> CrearRol ($nombre,$nivel,$obs);
		return $res;
	}
	
	function CuentaListaPaginadaRol()
	{
		$dbRol = new DBRol();
		$res = $dbRol -> CuentaListaPaginadaRol();
		return $res;
	}
	
	function ListaPaginadaRol($cant,$puntero)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaPaginadaRol($cant,$puntero);
		return $res;
	}
	
	function EliminaRol ($id_rol)
	{
		$dbRol = new DBRol();
		$res = $dbRol -> EliminaRol ($id_rol);
		return $res;
	}
	
	function ModificaRol($id_rol,$nombre,$nivel,$obs)
	{
		$dbRol = new DBRol();
		$res = $dbRol ->  ModificaRol($id_rol,$nombre,$nivel,$obs);
		return $res;
	}

	function ListaRol()
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaRol();
		return $res;
	}
	
	function  ListaParametrizadaRol($cant=-1,$puntero=0,$sortCol="id",$sortDir="asc",$filterCol="nombre",$filterValue="")
	{
		$dbRol = new DBRol();
		$res = $dbRol -> ListaParametrizadaRol($cant,$puntero,$sortCol,$sortDir,$filterCol,$filterValue);
		return $res;
	}
	///////////// FIN ROLES /////////////////////////////


	/////////////// MODULOS /////////////////////
	
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

	function InsertarPersonaFoto($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$expedicion)
	{
			$this->salida = "";
			$dbPersona = new cls_DBPersona($this->decodificar);
			$res = $dbPersona->InsertarPersonaFoto($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$expedicion);
			$this->salida = $dbPersona->salida;
			$this->query = $dbPersona->query;
			return $res;
	}
	
	function ListarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ListarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	
	function ContarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta-> ContarUsuarioEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;

		return $res;
	}

	
	function InsertarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->InsertarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	
	function ModificarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ModificarUsuarioEnvioAlerta($id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	
	function EliminarUsuarioEnvioAlerta($id_usuario_envio_alerta)
	{
		$this->salida = "";
		$dbUsuarioEnvioAlerta= new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->EliminarUsuarioEnvioAlerta($id_usuario_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}

	
	function ValidarUsuarioEnvioAlerta($operacion_sql,$id_usuario_envio_alerta,$id_usuario,$id_envio_alerta)
	{

		$this->salida = "";
		$dbUsuarioEnvioAlerta = new cls_DBUsuarioEnvioAlerta($this->decodificar);
		$res = $dbUsuarioEnvioAlerta->ValidarUsuarioEnvioAlerta($operacion_sql,$id_usuario_envio_alerta,$id_usuario,$id_envio_alerta);
		$this->salida = $dbUsuarioEnvioAlerta->salida;
		$this->query = $dbUsuarioEnvioAlerta->query;
		return $res;
	}
	function ListarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ListarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}

	function ContarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ContarUsuarioVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	//////////////////////////// FIN ENVIO ALERTA A USUARIO ////////////////////////

	/*********************************/	
	function ListarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeUsuario = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbEpeUsuario ->ListarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeUsuario ->salida;
		$this->query = $dbEpeUsuario ->query;
		return $res;
	}
		
	function ContarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeUsuario = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbEpeUsuario ->ContarEPUsuarioSCI($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeUsuario ->salida;
		$this->query = $dbEpeUsuario ->query;
		return $res;
	}
	/***************************/

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
	
	function ListarLugarArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugarArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	
	function ListarLugarRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugarRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}
	
	function ListarLugarHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugarHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
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
	function ListarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}

	function ContarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ContarLugarMunicipio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}

	function InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municipio,$sw_impuesto,$prioridad_kard,$sigla_sigma)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municipio,$sw_impuesto,$prioridad_kard,$sigla_sigma);
		$this->salida = $dbLugar ->salida;
		$this->query = $dbLugar ->query;
		return $res;
	}

	function ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municpio,$sw_impuesto,$prioridad_kard,$sigla_sigma)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion,$sw_municpio,$sw_impuesto,$prioridad_kard,$sigla_sigma);
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
	
	function DropLugarHoja($id_lugar,$fk_id_lugar,$tipo)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->DropLugarHoja($id_lugar,$fk_id_lugar,$tipo);
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
	
	//RCM: 28/07/2008
	function ListarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$filtro_funcion='')
	{
		$this->salida = "";
		$dbEpeUsuario = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbEpeUsuario ->ListarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$filtro_funcion);
		$this->salida = $dbEpeUsuario ->salida;
		$this->query = $dbEpeUsuario ->query;
		return $res;
	}
	
	//RCM: 28/07/2008
	function ContarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeUsuario = new cls_DBAsignacionEstructura($this->decodificar);
		$res = $dbEpeUsuario ->ContarEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeUsuario ->salida;
		$this->query = $dbEpeUsuario ->query;
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

	
	function VerificaUsuario($usuario,$contrasenia,$ip_origen,$mac_maquina)
	{
		$this->salida = "";

		$dbUsuario = new cls_DBUsuario();
		$res = $dbUsuario -> VerificaUsuario($usuario,$contrasenia,$ip_origen,$mac_maquina);
		$this->salida = $dbUsuario->salida;
		return $res;
	}
	

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
		function ListarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ListarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}		
	function ContarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ContarUsuarioEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	
	function InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->InsertarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	function SincronizarEPUsuarioEmpleado($id_usuario){
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->SincronizarEPUsuarioEmpleado($id_usuario);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	

	function ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ModificarUsuario($id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$fecha_expiracion,$autentificacion,$id_nivel_seguridad);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}

	function ModificarUsuarioPref($id_usuario,$contrasenia,$contrasenia_nueva,$contrasenia_nueva_rep,$estilo_usuario,$autentificacion)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ModificarUsuarioPref($id_usuario,$contrasenia,$contrasenia_nueva,$contrasenia_nueva_rep,$estilo_usuario,$autentificacion);
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

	function ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$autentificacion)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario ->ValidarUsuario($operacion_sql,$id_usuario,$id_persona,$login,$contrasenia,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_usuario,$estilo_usuario,$filtro_avanzado,$autentificacion);
		$this->salida = $dbUsuario ->salida;
		$this->query = $dbUsuario ->query;
		return $res;
	}
	
	
	//26-11-2013
	function InactivarUsuario($id_usuario,$fecha_inactivacion)
	{
		$this->salida = "";
		$dbUsuario = new cls_DBUsuario($this->decodificar);
		$res = $dbUsuario->InactivarUsuario($id_usuario, $fecha_inactivacion);
		$this->salida = $dbUsuario->salida;
		$this->query = $dbUsuario->query;
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

	function InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario
	//,$descripcion
	)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->InsertarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario
		//$descripcion
		);
		$this->salida = $dbUsuarioRol ->salida;
		$this->query = $dbUsuarioRol ->query;
		return $res;
	}

	function ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario
	//$descripcion, $estado_reg
	)
	{
		$this->salida = "";
		$dbUsuarioRol = new cls_DBUsuarioRol($this->decodificar);
		$res = $dbUsuarioRol ->ModificarUsuarioRol($id_usuario_rol,$id_rol,$id_usuario
		//$desccripcion, $estado_reg
		);
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

	function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$codigo,$codigo_procedimiento)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$codigo,$codigo_procedimiento);
		$this->salida = $dbSubsistema ->salida;
		$this->query = $dbSubsistema ->query;
		return $res;
	}

	function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$codigo,$codigo_procedimiento)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema ->ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_reg,$hora_reg,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$codigo,$codigo_procedimiento);
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
  function ListarPersonaFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ListarPersonaFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
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

	function InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion
			//24.04.2014
			,$apellido_casada, $libreta_militar,$num_complementario_doc_identif
			)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->InsertarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion
				//24.04.2014
				,$apellido_casada, $libreta_militar,$num_complementario_doc_identif
				);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}

	function ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion
			//24.04.2014
			,$apellido_casada, $libreta_militar,$num_complementario_doc_identif
			)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion
				//24.04.2014
				,$apellido_casada, $libreta_militar,$num_complementario_doc_identif
				);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}

	function ModificarPersonaEmpleado($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona ->ModificarPersonaEmpleado($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion,$direccion,$nro_registro,$nombre_foto,$numero,$extension,$expedicion);
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
	
	########################################## MFLORES
	
	function SubirFoto($id_persona, $txt_foto_persona, $nombre_foto, $numero, $extension, $id_empleado, $vista_per)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona -> SubirFoto($id_persona, $txt_foto_persona, $nombre_foto, $numero, $extension, $id_empleado, $vista_per);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function SeleccionarFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona -> SeleccionarFoto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	function SeleccionarIdsPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona -> SeleccionarIdsPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_persona);
		$this->salida = $dbPersona ->salida;
		$this->query = $dbPersona ->query;
		return $res;
	}
	
	########################################## MFLORES

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
	
		/// --------------------- tsg_metaproceso --------------------- ///

	function ListarMetaprocesoArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$nodo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$nodo);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	

	/**********************************************************/
	
	function ListarMetaprocesoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ListarMetaprocesoRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ListarMetaprocesoHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoHoja($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	function ListarMetaprocesoRaizAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRaizAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ListarMetaprocesoRamaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoRamaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	function ListarMetaprocesoHojaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ListarMetaprocesoHojaAsignado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	///////////////////////////////////////////////////////////////
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

	function InsertarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->InsertarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo);
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
	
	function ModificarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->ModificarMetaprocesoArb($id_metaproceso,$id_subsistema,$fk_id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_achivo,$ruta_archivo,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion,$visible,$habilitar_log,$orden_logico,$icono,$nombre_tabla,$prefijo,$codigo_base,$tipo_vista,$con_ep,$con_interfaz,$num_datos_hijo);
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
	
	///------------------------  metaproceso_db ------------------------///
	function ListarMetaprocesoDB_arb($sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso -> ListarMetaprocesoDB_arb($sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz,$id_rol);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	function InsertarMetaprocesoDBArb($id_metaproceso,$codigo_procedimiento)
	{ 
		
		
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso ->InsertarMetaprocesoDBArb($id_metaproceso,$codigo_procedimiento);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	 
	 
	function EliminarMetaprocesoDB($id_metaproceso_db)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso -> EliminarMetaprocesoDB($id_metaproceso_db);
		$this->salida = $dbMetaproceso ->salida;
		$this->query = $dbMetaproceso ->query;
		return $res;
	}
	
	
	
	/// --------------------- tsg_tipo_doc_identificacion --------------------- ///

	function ListarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion ->ListarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	function ContarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion ->ContarTipoDocIdentificacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	function InsertarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion ->InsertarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	function ModificarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion ->ModificarTipoDocIdentificacion($id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	function EliminarTipoDocIdentificacion($id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion -> EliminarTipoDocIdentificacion($id_tipo_doc_identificacion);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	function ValidarTipoDocIdentificacion($operacion_sql,$id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbTipoDocIdentificacion = new cls_DBTipoDocIdentificacion($this->decodificar);
		$res = $dbTipoDocIdentificacion ->ValidarTipoDocIdentificacion($operacion_sql,$id_tipo_doc_identificacion,$nombre_tipo_documento,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbTipoDocIdentificacion ->salida;
		$this->query = $dbTipoDocIdentificacion ->query;
		return $res;
	}

	/// --------------------- fin tsg_tipo_doc_identificacion --------------------- //
	/// --------------------- tsg_rol --------------------- ///

	function ListarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol ->ListarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}
	
	function ListarRolArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario)
	{
		$this->salida = "";
		$dbRol= new cls_DBRol($this->decodificar);
		$res = $dbRol ->ListarRolArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_usuario);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol->query;
		return $res;
	}
	

	function ContarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol ->ContarRol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}

	function InsertarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol ->InsertarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}

	function ModificarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol ->ModificarRol($id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}

	function EliminarRol($id_rol)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol -> EliminarRol($id_rol);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}

	function ValidarRol($operacion_sql,$id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion)
	{
		$this->salida = "";
		$dbRol = new cls_DBRol($this->decodificar);
		$res = $dbRol ->ValidarRol($operacion_sql,$id_rol,$nombre,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion);
		$this->salida = $dbRol ->salida;
		$this->query = $dbRol ->query;
		return $res;
	}

	/// --------------------- fin tsg_rol --------------------- ///
	/// --------------------- tsg_rol_metaproceso --------------------- ///

	function ListarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ListarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}
	
	function ListarUsuarioRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ListarUsuarioRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	function ContarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ContarRolMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	function InsertarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->InsertarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	function ModificarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ModificarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	function EliminarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso -> EliminarRolMetaproceso($id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	function ValidarRolMetaproceso($operacion_sql,$id_rol_metaproceso,$id_rol,$id_metaproceso)
	{
		$this->salida = "";
		$dbRolMetaproceso = new cls_DBRolMetaproceso($this->decodificar);
		$res = $dbRolMetaproceso ->ValidarRolMetaproceso($operacion_sql,$id_rol_metaproceso,$id_rol,$id_metaproceso);
		$this->salida = $dbRolMetaproceso ->salida;
		$this->query = $dbRolMetaproceso ->query;
		return $res;
	}

	/// --------------------- fin tsg_rol_metaproceso --------------------- ///

	/// --------------------- tsg_tarea_pendiente --------------------- ///

	function ListarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente ->ListarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	function ContarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente ->ContarTareaPendiente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	function InsertarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente ->InsertarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	function ModificarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente ->ModificarTareaPendiente($id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	function EliminarTareaPendiente($id_tarea_pendiente)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente -> EliminarTareaPendiente($id_tarea_pendiente);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	function ValidarTareaPendiente($operacion_sql,$id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg)
	{
		$this->salida = "";
		$dbTareaPendiente = new cls_DBTareaPendiente($this->decodificar);
		$res = $dbTareaPendiente ->ValidarTareaPendiente($operacion_sql,$id_tarea_pendiente,$id_usuario,$id_subsistema,$tarea,$descripcion,$enlace,$estado,$fecha_concluido_anulado,$fecha_reg);
		$this->salida = $dbTareaPendiente ->salida;
		$this->query = $dbTareaPendiente ->query;
		return $res;
	}

	/// --------------------- fin tsg_tarea_pendiente --------------------- ///
	
	//--------------------------cls_DBDescTabla-------------------------------/////////
	function ListarDescCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tabla)
	{
		$this->salida = "";
		$dbDescTabla = new cls_DBDescTabla($this->decodificar);
		$res = $dbDescTabla ->ListarDescCol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$tabla);
		$this->salida = $dbDescTabla ->salida;
		$this->query = $dbDescTabla ->query;
		return $res;
	}
	
	function InsertarDescCol($tabla,$campo,$cadena_desc)
	{
		$this->salida = "";
		$dbDescTabla= new cls_DBDescTabla($this->decodificar);
		$res = $dbDescTabla->InsertarDescCol($tabla,$campo,$cadena_desc);
		$this->salida = $dbDescTabla->salida;
		$this->query = $dbDescTabla->query;
		return $res;
	}
	
	function InsertarDescTabla($tabla,$cadena_desc)
	{
		$this->salida = "";
		$dbDescTabla= new cls_DBDescTabla($this->decodificar);
		$res = $dbDescTabla->InsertarDescTabla($tabla,$cadena_desc);
		$this->salida = $dbDescTabla->salida;
		$this->query = $dbDescTabla->query;
		return $res;
	}
	
	/// --------------------- tsg_relacion --------------------- ///

	function ListarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion ->ListarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	function ContarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion ->ContarRelacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$esquema);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	function InsertarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion ->InsertarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	function ModificarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion,$esquema)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion ->ModificarRelacion($id_relacion,$nombre,$codigo,$titulo,$descripcion,$esquema);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	function EliminarRelacion($id_relacion)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion -> EliminarRelacion($id_relacion);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	function ValidarRelacion($operacion_sql,$id_relacion,$nombre,$codigo,$titulo,$descripcion)
	{
		$this->salida = "";
		$dbRelacion = new cls_DBRelacion($this->decodificar);
		$res = $dbRelacion ->ValidarRelacion($operacion_sql,$id_relacion,$nombre,$codigo,$titulo,$descripcion);
		$this->salida = $dbRelacion ->salida;
		$this->query = $dbRelacion ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_relacion --------------------- ///
	
	/// --------------------- tsg_tabla --------------------- ///

	function ListarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla ->ListarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	function ContarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla ->ContarTabla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	function InsertarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla ->InsertarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	function ModificarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla ->ModificarTabla($id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	function EliminarTabla($id_tabla)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla -> EliminarTabla($id_tabla);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	function ValidarTabla($operacion_sql,$id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla)
	{
		$this->salida = "";
		$dbTabla = new cls_DBTabla($this->decodificar);
		$res = $dbTabla ->ValidarTabla($operacion_sql,$id_tabla,$nombre,$observaciones,$id_metaproceso,$fk_id_tabla);
		$this->salida = $dbTabla ->salida;
		$this->query = $dbTabla ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_tabla --------------------- ///
	
	/// --------------------- tsg_campo --------------------- ///

	function ListarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo ->ListarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	function ContarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo ->ContarCampo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	function InsertarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo ->InsertarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	function ModificarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo ->ModificarCampo($id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo,$grid_indice);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	function EliminarCampo($id_campo)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo -> EliminarCampo($id_campo);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	function ValidarCampo($operacion_sql,$id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo)
	{
		$this->salida = "";
		$dbCampo = new cls_DBCampo($this->decodificar);
		$res = $dbCampo ->ValidarCampo($operacion_sql,$id_campo,$nombre,$id_tabla,$funcion_grupo,$label,$width_reporte,$funcion,$casting,$filtro,$filtro_grupo,$formulario,$grupo,$dato_descriptivo);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
	/// --------------------- fin tsg_campo --------------------- ///
	
		
	    // --------------------- tsg_sesion --------------------- ///
    
    
    
    	
	function InsertarSesion($id_sesion,$variable,$ip,$fecha_reg,$id_usuario,$estado,$hora_act,$hora_desc)
	{
		$this->salida = "";
		$dbCampo = new cls_DBSesion($this->decodificar);
		$res = $dbCampo -> InsertarSesion($id_sesion,$variable,$ip,$fecha_reg,$id_usuario,$estado,$hora_act,$hora_desc);
		$this->salida = $dbCampo ->salida;
		$this->query = $dbCampo ->query;
		return $res;
	}
	
		
// --------------------- fin tsg_sesion --------------------- ///

// --------------------- MODIFICAR CLAVE --------------------- //
	function ValidarClave($id_usuario,$contrasenia_ant,$contrasenia_nueva,$confirmacion,$estilo,$filtro_avanzado,$mod_contrasenia,$autentificacion)
	{
		$this->salida = "";
		$dbclave = new cls_DBUsuario($this->decodificar);
		$res = $dbclave -> ValidarClave($id_usuario,$contrasenia_ant,$contrasenia_nueva,$confirmacion,$estilo,$filtro_avanzado,$mod_contrasenia,$autentificacion);
		$this->salida = $dbclave ->salida;
		$this->query = $dbclave ->query;
		return $res;
	}	
	
	//--------------------- FIN MODIFICAR CLAVE --------------------- //
    
	
	
	///--------------------NIVEL DE SEGURIDAD-----------------//
	// --------------------- inicio  --------------------- ///
	
	function ListarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> ListarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	
	function ContarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> ContarNivelSeguridad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	
	function InsertarNivelSeguridad($codigo,$nombre_nivel,$prioridad)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> InsertarNivelSeguridad($codigo,$nombre_nivel,$prioridad);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	
	function ModificarNivelSeguridad($id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> ModificarNivelSeguridad($id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	
	function EliminarNivelSeguridad($id_nivel_seguridad)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> EliminarNivelSeguridad($id_nivel_seguridad);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	
	function ValidarNivelSeguridad($operacion_sql,$id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad)
	{
		$this->salida = "";
		$dbnivelseg = new cls_DBNivelSeguridad($this->decodificar);
		$res = $dbnivelseg -> ValidarNivelSeguridad($operacion_sql,$id_nivel_seguridad,$codigo,$nombre_nivel,$prioridad);
		$this->salida = $dbnivelseg ->salida;
		$this->query = $dbnivelseg ->query;
		return $res;	
	}
	//------------------FIN NIVEL DE SEGURIDAD----------------//
	
		
}
?>