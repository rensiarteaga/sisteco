<?php
/**
 * Nombre de la Clase:	    CustomDBSeguridad
 * Propósito:				es la interfaz del modelo del Sistema de Seguridad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		21-08-2007
 * Autor:					Mercedes Zambrana Meneses
 *
 */
class rac_cls_CustomDBSeguridad
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
		include_once("cls_DBProcedimiento_db.php");
		

	}
	
	/**
	 * Nombre de la función:	ListarSubsistema
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
	function ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->ListarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema->salida;
		
		$this->query = $dbSubsistema->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarSubsistema
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
	function ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->ContarSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubsistema->salida;
		$this->query = $dbSubsistema->query;
		return $res;
	}	

	/**
	* Nombre de la función:	InsertarSubsistema
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
	function InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
	
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->InsertarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema->salida;
		$this->query = $dbSubsistema->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarSubsistema
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
	function ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->ModificarSubsistema($id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema->salida;
		$this->query = $dbSubsistema->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarSubsistema
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarSubsistema($id_subsistema)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->EliminarSubsistema($id_subsistema);
		$this->salida = $dbSubsistema->salida;
		$this->query = $dbSubsistema->query;
		return $res;
	}
	
	/* Nombre de la función:	ValidarSubsistema
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $operacion_sql
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
	function ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones)
	{
		$this->salida = "";
		$dbSubsistema = new cls_DBSubsistema($this->decodificar);
		$res = $dbSubsistema->ValidarSubsistema($operacion_sql,$id_subsistema,$nombre_corto,$nombre_largo,$descripcion,$version_desarrollo,$desarrolladores,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones);
		$this->salida = $dbSubsistema->salida;
		$this->query = $dbSubsistema->query;
		return $res;
	}
	//////////////////// FIN TRAMITE INSPECCION ////////////////////

	////////////////////////////  PERSONA  ////////////////////////
	/**
	 * Nombre de la función:	ListarPersona
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
	function ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->ListarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPersona->salida;
		
		$this->query = $dbPersona->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPersona
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
	function ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->ContarPersona($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPersona->salida;
		$this->query = $dbPersona->query;
		return $res;
	}	
	
	/**
	* Nombre de la función:	InsertarPersona
	* Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
 	* Autor:					Mercedes Zambrana Meneses
 	* Fecha de creación:		28-08-2007
 	*
 	*
 	* @param unknown_type $id_persona
 	* @param unknown_type $apellido_paterno
 	* @param unknown_type $apellido_paterno
 	* @param unknown_type $nombre
 	* @param unknown_type $fecha_nacimiento
 	* @param unknown_type $foto_persona
 	* @param unknown_type $doc_id
 	* @param unknown_type $genero
 	* @param unknown_type $casilla
 	* @param unknown_type $telefono1
 	* @param unknown_type $telefono2
 	* @param unknown_type $celular1
 	* @param unknown_type $celular2
 	* @param unknown_type $pag_web
 	* @param unknown_type $email1
 	* @param unknown_type $email2
 	* @param unknown_type $email3
 	* @param unknown_type $fecha_registro
 	* @param unknown_type $hora_registro
 	* @param unknown_type $fecha_ultima_modificacion
 	* @param unknown_type $hora_ultima_modificacion
 	* @param unknown_type $observaciones
 	* @param unknown_type $id_tipo_doc_identificacion
 	* @return unknown
 	*/
	function InsertarPersona($id_persona,$apellido_paterno,$apellido_paterno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->InsertarPersona($id_persona,$apellido_paterno,$apellido_paterno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona->salida;
		$this->query = $dbPersona->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPersona
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
	function ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->ModificarPersona($id_persona,$apellido_paterno,$apellido_materno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona->salida;
		$this->query = $dbPersona->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	EliminarPersona
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarPersona($id_persona)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->EliminarPersona($id_persona);
		$this->salida = $dbPersona->salida;
		$this->query = $dbPersona->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_persona
	 * @param unknown_type $apellido_paterno
	 * @param unknown_type $apellido_paterno
	 * @param unknown_type $nombre
	 * @param unknown_type $fecha_nacimiento
	 * @param unknown_type $foto_persona
	 * @param unknown_type $doc_id
	 * @param unknown_type $genero
	 * @param unknown_type $casilla
	 * @param unknown_type $telefono1
	 * @param unknown_type $telefono2
	 * @param unknown_type $celular1
	 * @param unknown_type $celular2
	 * @param unknown_type $pag_web
	 * @param unknown_type $email1
	 * @param unknown_type $email2
	 * @param unknown_type $email3
	 * @param unknown_type $fecha_registro
	 * @param unknown_type $hora_registro
	 * @param unknown_type $fecha_ultima_modificacion
	 * @param unknown_type $hora_ultima_modificacion
	 * @param unknown_type $observaciones
	 * @param unknown_type $id_tipo_doc_identificacion
	 * @return unknown
	 */
	function ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_paterno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion)
	{
		$this->salida = "";
		$dbPersona = new cls_DBPersona($this->decodificar);
		$res = $dbPersona->ValidarPersona($operacion_sql,$id_persona,$apellido_paterno,$apellido_paterno,$nombre,$fecha_nacimiento,$foto_persona,$doc_id,$genero,$casilla,$telefono1,$telefono2,$celular1,$celular2,$pag_web,$email1,$email2,$email3,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$observaciones,$id_tipo_doc_identificacion);
		$this->salida = $dbPersona->salida;
		$this->query = $dbPersona->query;
		return $res;
	}
	//////////////////// FIN PERSONA////////////////////

	
	
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
	function ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso->ListarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaproceso->salida;
		
		$this->query = $dbMetaproceso->query;
		return $res;
	}
	
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
	function ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso-> ContarMetaproceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaproceso->salida;
		$this->query = $dbMetaproceso->query;
		
		return $res;
	}	

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
	function InsertarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso->InsertarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
		$this->salida = $dbMetaproceso->salida;
		$this->query = $dbMetaproceso->query;
		return $res;
	}
	
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
	function ModificarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso->ModificarMetaproceso($id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
		$this->salida = $dbMetaproceso->salida;
		$this->query = $dbMetaproceso->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarMetaproceso
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		28-08-2007
	 *
	 * @param unknown_type $id_metaproceso
	 * @return unknown
	 */
	function EliminarMetaproceso($id_metaproceso)
	{
		$this->salida = "";
		$dbMetaproceso= new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso->EliminarMetaproceso($id_metaproceso);
		$this->salida = $dbMetaproceso->salida;
		$this->query = $dbMetaproceso->query;
		return $res;
	}
	
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
	function ValidarMetaproceso($operacion_sql,$id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono)
	{
		$this->salida = "";
		$dbMetaproceso = new cls_DBMetaproceso($this->decodificar);
		$res = $dbMetaproceso->ValidarMetaproceso($operacion_sql,$id_metaproceso,$nivel,$nombre,$codigo_procedimiento,$nombre_archivo,$ruta_archivo,$fecha_registro, $hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$descripcion, $visible,$habilitar_log,$orden_logico,$id_subsistema,$fk_id_metaproceso,$icono);
		$this->salida = $dbMetaproceso->salida;
		$this->query = $dbMetaproceso->query;
		return $res;
	}
	
	
	
	////////////////////////////  PREFERENCIA DETALLE ////////////////////////
	/**
	 * Nombre de la función:	ListarPreferenciaDetalle
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
	function ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle->ListarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaDetalle->salida;
		
		$this->query = $dbPreferenciaDetalle->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPreferenciaDetalle
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
	function ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle-> ContarPreferenciaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaDetalle->salida;
		$this->query = $dbPreferenciaDetalle->query;
		
		return $res;
	}	

	/**
	 * Nombre de la función:	InsertarPreferenciaDetalle
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_preferencia_detalle
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion_atributo
	 * @param unknown_type $id_preferencia
	 * @return unknown
	 */
	function InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle->InsertarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle->salida;
		$this->query = $dbPreferenciaDetalle->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPreferenciaDetalle
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_preferencia_detalle
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion_atributo
	 * @param unknown_type $id_preferencia
	 * @return unknown
	 */
	function ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle->ModificarPreferenciaDetalle($id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle->salida;
		$this->query = $dbPreferenciaDetalle->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarPreferenciaDetalle
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarPreferenciaDetalle($id_preferencia_detalle)
	{
		$this->salida = "";
		$dbPreferenciaDetalle= new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle->EliminarPreferenciaDetalle($id_preferencia_detalle);
		$this->salida = $dbPreferenciaDetalle->salida;
		$this->query = $dbPreferenciaDetalle->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarPreferenciaDetalle
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
	function ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia)
	{
		
		$this->salida = "";
		$dbPreferenciaDetalle = new cls_DBPreferenciaDetalle($this->decodificar);
		$res = $dbPreferenciaDetalle->ValidarPreferenciaDetalle($operacion_sql,$id_preferencia_detalle,$nombre_atributo,$valor_atributo,$descripcion_atributo,$id_preferencia);
		$this->salida = $dbPreferenciaDetalle->salida;
		$this->query = $dbPreferenciaDetalle->query;
		return $res;
	}
	
	
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
	function ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta->ListarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		return $res;
	}
	
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
	function ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta-> ContarMetaprocesoEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		
		return $res;
	}	

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
	 */
	function InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta->InsertarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		return $res;
	}
	
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
	function ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta->ModificarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarMetaprocesoEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta)
	{
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta= new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta->EliminarMetaprocesoEnvioAlerta($id_metaproceso_envio_alerta);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		return $res;
	}
	
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
	 */
	function ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso)
	{
		
		$this->salida = "";
		$dbMetaprocesoEnvioAlerta = new cls_DBMetaprocesoEnvioAlerta($this->decodificar);
		$res = $dbMetaprocesoEnvioAlerta->ValidarMetaprocesoEnvioAlerta($operacion_sql,$id_metaproceso_envio_alerta,$id_envio_alerta,$id_metaproceso);
		$this->salida = $dbMetaprocesoEnvioAlerta->salida;
		$this->query = $dbMetaprocesoEnvioAlerta->query;
		return $res;
	}
	
	
	
	
	
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
	
	
	
		////////////////////////////  PREFERENCIA  ////////////////////////
	/**
	 * Nombre de la función:	ListarPreferencia
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
	function ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia->ListarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarPreferencia
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
	function ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia-> ContarPreferencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		
		return $res;
	}	

	/**
	 * Nombre de la función:	InsertarPreferencia
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_preferencia_
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion_atributo
	 * @param unknown_type $id_preferencia
	 * @return unknown
	 */
	function InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia->InsertarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ModificarPreferencia
	 * Propósito:				Modificar registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 *
	 * @param unknown_type $id_preferencia_
	 * @param unknown_type $nombre_atributo
	 * @param unknown_type $valor_atributo
	 * @param unknown_type $descripcion_atributo
	 * @param unknown_type $id_preferencia
	 * @return unknown
	 */
	function ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia->ModificarPreferencia($id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarPreferencia
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarPreferencia($id_preferencia)
	{
		$this->salida = "";
		$dbPreferencia= new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia->EliminarPreferencia($id_preferencia);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ValidarPreferencia
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
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
	function ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo)
	{
		
		$this->salida = "";
		$dbPreferencia = new cls_DBPreferencia($this->decodificar);
		$res = $dbPreferencia->ValidarPreferencia($operacion_sql,$id_preferencia,$nombre_modulo,$descripcion_modulo);
		$this->salida = $dbPreferencia->salida;
		$this->query = $dbPreferencia->query;
		return $res;
	}
	
	
	
	////////////////////////////  USUARIO ASIGNACION ////////////////////////
	/**
	 * Nombre de la función:	ListarUsuarioAsignacion 
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
	function ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion->ListarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	ContarUsuarioAsignacion
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
	function ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion-> ContarUsuarioAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		
		return $res;
	}	

	/**
	 * Nombre de la función:	InsertarUsuarioAsignacion
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
	function InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion->InsertarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		return $res;
	}
	
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
	function ModificarUsuarioAsignacion($id_usuario_asignacion, $id_asignacion_estructura,$id_usuario)
	{
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion->ModificarUsuarioAsignacion($id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarUsuarioAsignacion
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarUsuarioAsignacion($id_usuario_asignacion)
	{
		$this->salida = "";
		$dbUsuarioAsignacion= new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion->EliminarUsuarioAsignacion($id_usuario_asignacion);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		return $res;
	}
	
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
	function ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion, $id_asignacion_estructura,$id_usuario)
	{
		
		$this->salida = "";
		$dbUsuarioAsignacion = new cls_DBUsuarioAsignacion($this->decodificar);
		$res = $dbUsuarioAsignacion->ValidarUsuarioAsignacion($operacion_sql,$id_usuario_asignacion,$id_asignacion_estructura,$id_usuario);
		$this->salida = $dbUsuarioAsignacion->salida;
		$this->query = $dbUsuarioAsignacion->query;
		return $res;
	}
	
	
	
	
	
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
	function ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta->ListarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		return $res;
	}
	
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
	function ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta-> ContarEnvioAlerta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		
		return $res;
	}	

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
	function InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta->InsertarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		return $res;
	}
	
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
	function ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta->ModificarEnvioAlerta($id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		return $res;
	}
	
	/**
	 * Nombre de la función:	eliminarEnvioAlerta
	 * Propósito:				Contar el total de registros desplegados en función de los parámetros de filtro
	 * Autor:					Mercedes Zambrana Meneses
	 * Fecha de creación:		30-08-2007
	 *
	 * @param unknown_type $id_subsistema
	 * @return unknown
	 */
	function EliminarEnvioAlerta($id_envio_alerta)
	{
		$this->salida = "";
		$dbEnvioAlerta= new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta->EliminarEnvioAlerta($id_envio_alerta);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		return $res;
	}
	
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
	function ValidarEnvioAlerta($operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		
		$this->salida = "";
		$dbEnvioAlerta = new cls_DBEnvioAlerta($this->decodificar);
		$res = $dbEnvioAlerta->ValidarEnvioAlerta(operacion_sql,$id_envio_alerta,$nombre_alerta,$prioridad,$titulo_mensaje,$mensaje,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbEnvioAlerta->salida;
		$this->query = $dbEnvioAlerta->query;
		return $res;
	}
	////////////////////////////  USUARIO ASIGNACION ////////////////////////
	/**
	 * Nombre de la función:	ListarUsuarioAsignacion 
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
	function ListarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->ListarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}
	
	function ContarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->ContarProcedimiento_db($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}	
	
	function InsertarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->InsertarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}
	
	function ModificarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->ModificarProcedimiento_db($codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}
	function EliminarProcedimiento_db($codigo_procedimiento)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->EliminarProcedimiento_db($codigo_procedimiento);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}
	function ValidarProcedimiento_db($operacion_sql,$codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema)
	{
		$this->salida = "";
		$dbProcedimiento_db= new cls_DBProcedimiento_db($this->decodificar);
		$res = $dbProcedimiento_db->ValidarProcedimiento_db($operacion_sql,$codigo_procedimiento,$nombre_funcion,$descripcion,$habilitar_log,$fecha_reg,$id_subsistema);
		$this->salida = $dbProcedimiento_db->salida;
		$this->query = $dbProcedimiento_db->query;
		return $res;
	}
	
	
}
?>