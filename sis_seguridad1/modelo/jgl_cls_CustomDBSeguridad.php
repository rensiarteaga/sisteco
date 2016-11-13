<?php
/**
 * Nombre de la Clase:	    CustomDBFactur
 * Propósito:				es la interfaz del modelo del Sistema de Facturación
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		20-08-2007
 * Autor:					Julio Guarachi López
 *
 */
class jgl_cls_CustomDBSeguridad
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
		include_once("cls_DBLugar.php");
		include_once("cls_DBRolMetaproceso.php");
		include_once("cls_DBPreferenciaUsuario.php");
		
	}

	/////////////// LUGAR /////////////////////

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
	function ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ListarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
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
	function ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ContarLugar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_lugar
	 * @param unknown_type $fk_id_lugar
	 * @param unknown_type $nivel
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $ubicacion
	 * @param unknown_type $telefono1
	 * @param unknown_type $telefono2
	 * @param unknown_type $fax
	 * @param unknown_type $observacion
	 * @return unknown
	 */
	function InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->InsertarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_lugar
	 * @return unknown
	 */
	function EliminarLugar($id_lugar)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar -> EliminarLugar($id_lugar);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
		return $res;
	
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_lugar
	 * @param unknown_type $fk_id_lugar
	 * @param unknown_type $nivel
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $ubicacion
	 * @param unknown_type $telefono1
	 * @param unknown_type $telefono2
	 * @param unknown_type $fax
	 * @param unknown_type $observacion
	 * @return unknown
	 */
	function ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ModificarLugar($id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_lugar
	 * @param unknown_type $fk_id_lugar
	 * @param unknown_type $nivel
	 * @param unknown_type $codigo
	 * @param unknown_type $nombre
	 * @param unknown_type $ubicacion
	 * @param unknown_type $telefono1
	 * @param unknown_type $telefono2
	 * @param unknown_type $fax
	 * @param unknown_type $observacion
	 * @return unknown
	 */
	function ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion)
	{
		$this->salida = "";
		$dbLugar = new cls_DBLugar($this->decodificar);
		$res = $dbLugar ->ValidarLugar($operacion_sql,$id_lugar,$fk_id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		//$res = $dbLugar ->ValidarLugar($operacion_sql,$id_lugar,$id_lugar,$nivel,$codigo,$nombre,$ubicacion,$telefono1,$telefono2,$fax,$observacion);
		$this->salida = $dbLugar->salida;
		$this->query = $dbLugar->query;
		return $res;
	}
	/////////////   FIN LUGAR /////////////////////////////


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

	
	
	/////////////// PREFERENCIA USUARIO /////////////////////

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
	function ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ListarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
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
	function ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ContarPreferenciaUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_preferencia_usuario
	 * @param unknown_type $id_preferencia
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->InsertarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_preferencia_usuario
	 * @return unknown
	 */
	function EliminarPreferenciaUsuario($id_preferencia_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario -> EliminarPreferenciaUsuario($id_preferencia_usuario);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
		return $res;
	
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $id_preferencia_usuario
	 * @param unknown_type $id_preferencia
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ModificarPreferenciaUsuario($id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
		return $res;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $operacion_sql
	 * @param unknown_type $id_preferencia_usuario
	 * @param unknown_type $id_preferencia
	 * @param unknown_type $id_usuario
	 * @return unknown
	 */
	function ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario)
	{
		$this->salida = "";
		$dbPreferenciaUsuario = new cls_DBPreferenciaUsuario($this->decodificar);
		$res = $dbPreferenciaUsuario ->ValidarPreferenciaUsuario($operacion_sql,$id_preferencia_usuario,$id_preferencia,$id_usuario);
		$this->salida = $dbPreferenciaUsuario->salida;
		$this->query = $dbPreferenciaUsuario->query;
		return $res;
	}
	/////////////   FIN PREFERENCIA USUARIO /////////////////////////////

	
}?>