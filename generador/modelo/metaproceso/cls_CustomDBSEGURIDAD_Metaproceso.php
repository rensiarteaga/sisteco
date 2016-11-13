<?php
/**
 * Nombre de la Clase:	    CustomDBseguridad
 * Propósito:				Interfaz del modelo del Sistema de seguridad
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-10 12:08:15
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBseguridad
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBMetaproceso.php");

	}
	
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
}