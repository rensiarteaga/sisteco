<?php
/**
 * Nombre de la Clase:	    CustomDBComunidad
 * Propósito:				Es la interfaz del modelo del Sistema de Administracion de la comunidad de ENDE
 * Fecha de Creación:		14-05-2013
 * Autor:					Morgan Huascar Checa Lopez
 *
 */
class cls_CustomDBComunidad
{
	//variable que contiene la salida de la ejecuci?n de la funci?n
	//si la funci?n tuvo error (false), salida contendr? el mensaje de error
	//si la funci?n no tuvo error (true), salida contendr? el resultado, ya sea un conjunto de datos o un mensaje de confirmaci?n
	var $salida = "";

	//Variable que contedr? la cadena de llamada a las funciones postgres
	var $query = "";

	//Bandera que indica si los datos se decodificar?n o no
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBPublicaciones.php");
		include_once("cls_DBPensamientoDia.php");
		include_once("cls_DBSistemaInformatico.php");
		include_once("cls_DBNormativaInterna.php");
		include_once("cls_DBAvisosRRHH.php");
		include_once("cls_DBDetalleNormativa.php");
		include_once("cls_DBArchivoNormativa.php");
		include_once("cls_DBWebService.php");
	}
	
	/****************************Todo Pensamientos del día***************************************/

	function ListarPensamientoDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens = new cls_DBPensamiento($this->decodificar);
		$res = $dbPens ->ListarPensamientoDia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function ContarPensamiento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens= new cls_DBPensamiento($this->decodificar);
		$res = $dbPens->ContarPensamiento($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function EliminarPensamiento($id_pensamiento)
	{
		$this->salida = "";
		$dbPens = new cls_DBPensamiento($this->decodificar);
		$res = $dbPens ->EliminarPensamiento($id_pensamiento);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function InsertarPensamiento($id_pensamiento,$texto_pensamiento)
	{
		$this->salida = "";
		$dbPens = new cls_DBPensamiento($this->decodificar);
		$res = $dbPens ->InsertarPensamiento($id_pensamiento,$texto_pensamiento,$fecha_inicio, $fecha_fin);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function ModificarPensamiento($id_pensamiento,$texto_pensamiento)
	{
		$this->salida = "";
		$dbPens = new cls_DBPensamiento($this->decodificar);
		$res = $dbPens ->ModificarPensamiento($id_pensamiento,$texto_pensamiento);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	/****************************Fin Pensamientos del día****************************************/
	
	/****************************Todo Publicaciones**********************************************/
	
	function ListarPublicacionesAdministracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens = new cls_DBPublicacion($this->decodificar);
		$res = $dbPens ->ListarPublicacionesAdministracion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function ContarPublicacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens= new cls_DBPublicacion($this->decodificar);
		$res = $dbPens->ContarPublicacion($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function EliminarPublicacion($id_publicacion)
	{
		$this->salida = "";
		$dbPens = new cls_DBPublicacion($this->decodificar);
		$res = $dbPens ->EliminarPublicacion($id_publicacion);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function InsertarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo,$txt_archivo,$directorio_archivo)
	{
		$this->salida = "";
		$dbPens = new cls_DBPublicacion($this->decodificar);
		$res = $dbPens ->InsertarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo,$txt_archivo,$directorio_archivo);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function ModificarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo)
	{
		$this->salida = "";
		$dbPens = new cls_DBPublicacion($this->decodificar);
		$res = $dbPens ->ModificarPublicacion($id_publicacion,$nombre_publicacion,$descripcion_publicacion, $ruta_imagen, $ruta_archivo);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	/****************************Fin Publicaciones***********************************************/
	
	/****************************Todo Normativas Internas****************************************/
	
	function ListarNormativas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist = new cls_DBNormativaInterna($this->decodificar);
		$res = $dbSist ->ListarNormativas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function ContarNormativas($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist= new cls_DBNormativaInterna($this->decodificar);
		$res = $dbSist->ContarNormativas($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function EliminarNormativas($id_normativa)
	{
		$this->salida = "";
		$dbSist = new cls_DBNormativaInterna($this->decodificar);
		$res = $dbSist ->EliminarNormativas($id_normativa);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function InsertarNormativas($id_normativa,$nombre_normativa,$descripcion_normativa)
	{
		$this->salida = "";
		$dbSist = new cls_DBNormativaInterna($this->decodificar);
		$res = $dbSist ->InsertarNormativas($id_normativa,$nombre_normativa,$descripcion_normativa);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function ModificarNormativas($id_normativa,$nombre_normativa,$descripcion_normativa)
	{
		$this->salida = "";
		$dbSist = new cls_DBNormativaInterna($this->decodificar);
		$res = $dbSist ->ModificarNormativas($id_normativa,$nombre_normativa,$descripcion_normativa);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	/****************************Fin Normativas Internas*****************************************/
	
	/****************************Todo Sistemas Informaticos**************************************/
	
	function ListarSistemas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist = new cls_DBSistemaInformatico($this->decodificar);
		$res = $dbSist ->ListarSistemas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function ContarSistemas($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist= new cls_DBSistemaInformatico($this->decodificar);
		$res = $dbSist->ContarSistemas($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function EliminarSistemas($id_sistema_informatico)
	{
		$this->salida = "";
		$dbSist = new cls_DBSistemaInformatico($this->decodificar);
		$res = $dbSist ->EliminarSistemas($id_sistema_informatico);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function InsertarSistemas($id_sistema,$nombre_sistema,$enlace_sistema, $sistema)
	{
		$this->salida = "";
		$dbSist = new cls_DBSistemaInformatico($this->decodificar);
		$res = $dbSist ->InsertarSistemas($id_sistema,$nombre_sistema,$enlace_sistema, $sistema);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function ModificarSistemas($id_sistema,$nombre_sistema,$enlace_sistema, $sistema)
	{
		$this->salida = "";
		$dbSist = new cls_DBSistemaInformatico($this->decodificar);
		$res = $dbSist ->ModificarSistemas($id_sistema,$nombre_sistema,$enlace_sistema, $sistema);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	/****************************Fin Sistemas Informaticos***************************************/
	
	/**********************Todo Aviso RRHH ******************************************************/
	
	function ListarAvisoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens = new cls_DBAvisoRRHH($this->decodificar);
		$res = $dbPens ->ListarAvisoRRHH($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function ContarAvisoRRHH($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbPens= new cls_DBAvisoRRHH($this->decodificar);
		$res = $dbPens->ContarAvisoRRHH($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens->query;
		return $res;
	}
	
	function EliminarAvisoRRHH($id_aviso)
	{
		$this->salida = "";
		$dbPens = new cls_DBAvisoRRHH($this->decodificar);
		$res = $dbPens ->EliminarAvisoRRHH($id_aviso);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function InsertarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo)
	{
		$this->salida = "";
		$dbPens = new cls_DBAvisoRRHH($this->decodificar);
		$res = $dbPens ->InsertarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	function ModificarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo)
	{
		$this->salida = "";
		$dbPens = new cls_DBAvisoRRHH($this->decodificar);
		$res = $dbPens ->ModificarAvisoRRHH($id_aviso,$nombre_aviso,$descripcion_aviso,$ruta_archivo);
		$this->salida = $dbPens->salida;
		$this->query = $dbPens ->query;
		return $res;
	}
	
	/********************Fin Aviso RRHH **********************************************************/
	
	
	/****************************Todo Detalle Normativa****************************************/
	
	function ListarDetalleNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist = new cls_DBDetalleNormativa($this->decodificar);
		$res = $dbSist ->ListarDetalleNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function ContarDetalleNormativa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist= new cls_DBDetalleNormativa($this->decodificar);
		$res = $dbSist->ContarDetalleNormativa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function EliminarDetalleNormativa($id_detalle_normativa)
	{
		$this->salida = "";
		$dbSist = new cls_DBDetalleNormativa($this->decodificar);
		$res = $dbSist ->EliminarDetalleNormativa($id_detalle_normativa);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function InsertarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna)
	{
		$this->salida = "";
		$dbSist = new cls_DBDetalleNormativa($this->decodificar);
		$res = $dbSist ->InsertarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function ModificarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna)
	{
		$this->salida = "";
		$dbSist = new cls_DBDetalleNormativa($this->decodificar);
		$res = $dbSist ->ModificarDetalleNormativa($id_detalle_normativa, $nombre_subcategoria, $descripcion_subcategoria, $id_normativa_interna);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	/****************************Fin Detalle Normativa*****************************************/
	
	
	
	
	/****************************Todo Archivo Normativa****************************************/
	
	function ListarArchivoNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist = new cls_DBArchivoNormativa($this->decodificar);
		$res = $dbSist ->ListarArchivoNormativa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function ContarArchivoNormativa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist= new cls_DBArchivoNormativa($this->decodificar);
		$res = $dbSist->ContarArchivoNormativa($cant ,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist->query;
		return $res;
	}
	
	function EliminarArchivoNormativa($id_archivos_normativas)
	{
		$this->salida = "";
		$dbSist = new cls_DBArchivoNormativa($this->decodificar);
		$res = $dbSist ->EliminarArchivoNormativa($id_archivos_normativas);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function InsertarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo )
	{
		$this->salida = "";
		$dbSist = new cls_DBArchivoNormativa($this->decodificar);
		$res = $dbSist ->InsertarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo );
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	function ModificarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo )
	{
		$this->salida = "";
		$dbSist = new cls_DBArchivoNormativa($this->decodificar);
		$res = $dbSist ->ModificarArchivoNormativa($id_archivos_normativas, $nombre_archivo, $descripcion_archivo, $id_detalle_normativa,$ruta_archivo );
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
	
	/****************************Fin Archivo Normativa*****************************************/
	function ListarUsuarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro)
	{
		$this->salida = "";
		$dbSist = new cls_DBWebService($this->decodificar);
		$res = $dbSist ->ListarUsuarios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro);
		$this->salida = $dbSist->salida;
		$this->query = $dbSist ->query;
		return $res;
	}
}
?>