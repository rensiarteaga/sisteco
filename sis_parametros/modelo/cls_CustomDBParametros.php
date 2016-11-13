<?php
/*
**********************************************************
Nombre de la Clase:	    CustomDBParametros
Prop�sito:				es la interfaz del modelo del Sistema de Par�metros
todos los metodos existentes pasan por aqui
Fecha de Creaci�n:		04-06-2007
Versi�n:				1.0.0
Autor:					Rodrigo Chumacero Moscoso
**********************************************************
*/
/**
 * contiene todas las funcionalidades del m�dulo de seguridad
 *
 */
class cls_CustomDBParametros
{
	//variable que contiene la salida de la ejecuci�n de la funci�n
	//si la funci�n tuvo error (false), salida contendr� el mensaje de error
	//si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida = "";

	//Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBFinanciador.php");
		include_once("cls_DBRegional.php");
		include_once("cls_DBPrograma.php");
		include_once("cls_DBProyecto.php");
		include_once("cls_DBActividad.php");
		include_once("cls_DBMoneda.php");
		include_once("cls_DBMedida.php");
		include_once("cls_DBTipoCambio.php");
		include_once("cls_DBInstitucion.php");
		include_once("cls_DBProgramaProyectoActividad.php");
		include_once("cls_DBFinaRegiProgProyActi.php");
		include_once("cls_DBTipoUnidadMedida.php");
		include_once("cls_DBUnidadMedidaBase.php");
		include_once("cls_DBUnidadMedidaSec.php");
		include_once("cls_DBContratista.php");
		include_once("cls_DBSubactividad.php");
		include_once("cls_DBTipoDocInstitucion.php");
		include_once("cls_DBDocumento.php");
		include_once("cls_DBGestion.php");
		include_once("cls_DBCorrelativoGeneral.php");
		include_once("cls_DBCorrelativoRp.php");
		include_once("cls_DBEmpresa.php");
		
		include_once("cls_DBDepto.php");
		include_once("cls_DBDeptoEp.php");
		include_once("cls_DBDeptoUsuario.php");
		include_once("cls_DBDeptoFirmaAutoriz.php");
		include_once("cls_DBPeriodo.php");
		include_once("cls_DBDeptoConta.php");
		include_once("cls_DBDeptoUO.php");	
		include_once("cls_DBDeptoDiv.php");
		include_once("cls_DBConfigAprobador.php");
		include_once("cls_DBSucursal.php");
		
		include_once("cls_DBFecha.php");
		include_once("cls_DBEpeInv.php");
	} 
	
	/// --------------------- tpm_empresa --------------------- ///

	function ListarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa ->ListarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	function ContarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa ->ContarEmpresa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	function InsertarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa ->InsertarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	function ModificarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa ->ModificarEmpresa($id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	function EliminarEmpresa($id_empresa)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa -> EliminarEmpresa($id_empresa);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	function ValidarEmpresa($operacion_sql,$id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm)
	{
		$this->salida = "";
		$dbEmpresa = new cls_DBEmpresa($this->decodificar);
		$res = $dbEmpresa ->ValidarEmpresa($operacion_sql,$id_empresa,$razon_social,$denominacion,$nro_nit,$codigo,$finalidad,$dir_adm);
		$this->salida = $dbEmpresa ->salida;
		$this->query = $dbEmpresa ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_empresa --------------------- ///
	
	/////////////// FINANCIADOR/////////////////////

//	function ListarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador ->ListarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}
//	function ContarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbFinanciador= new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador ->  ContarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}
	
//	function InsertarFinanciador($id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador ->InsertarFinanciador($id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}
//	function EliminarFinanciador($id_financiador)
//	{
//		$this->salida = "";
//		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador -> EliminarFinanciador($id_financiador);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}
//	function ModificarFinanciador($id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador ->ModificarFinanciador($id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}
//	function ValidarFinanciador($operacion_sql,$id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
//		$res = $dbFinanciador ->ValidarFinanciador($operacion_sql,$id_financiador, $codigo_financiador, $nombre_financiador, $descripcion_financiador, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbFinanciador->salida;
//		return $res;
//	}

	/////////////   FIN  FINANCIADOR /////////////////////////////

	/////////////// REGIONAL///////////////////////

//	function ListarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbRegional = new cls_DBRegional($this->decodificar);
//		$res = $dbRegional ->ListarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}
//
//
//	function ContarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbRegional= new cls_DBRegional($this->decodificar);
//		$res = $dbRegional ->  ContarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}

	
//	function InsertarRegional($id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbRegional = new cls_DBRegional($this->decodificar);
//		$res = $dbRegional ->InsertarRegional($id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}
//	function EliminarRegional($id_regional)
//	{
//		$this->salida = "";
//		$dbRegional = new cls_DBRegional($this->decodificar);
//		$res = $dbRegional -> EliminarRegional($id_regional);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}
//	function ModificarRegional($id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbRegional = new cls_DBRegional($this->decodificar);
//		$res = $dbRegional ->ModificarRegional($id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}
//	function ValidarRegional($operacion_sql,$id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbRegional = new cls_DBRegional($this->decodificar);
//		$res = $dbRegional ->ValidarRegional($operacion_sql,$id_regional, $codigo_regional, $nombre_regional, $descripcion_regional, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbRegional->salida;
//		return $res;
//	}

	/////////////   FIN  REGIONAL /////////////////////////////

	/////////////// PROGRAMA/////////////////////

//	function ListarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPrograma = new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma ->ListarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}
//
//	////////////////////////////77777
//	function ContarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbPrograma= new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma ->  ContarPrograma($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}
//	//////////////////////////////////7

	
//	function InsertarPrograma($id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbPrograma = new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma ->InsertarPrograma($id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}
//	function EliminarPrograma($id_programa)
//	{
//		$this->salida = "";
//		$dbPrograma = new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma -> EliminarPrograma($id_programa);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}
//	function ModificarPrograma($id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbPrograma = new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma ->ModificarPrograma($id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}
//	function ValidarPrograma($operacion_sql,$id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbPrograma = new cls_DBPrograma($this->decodificar);
//		$res = $dbPrograma ->ValidarPrograma($operacion_sql,$id_programa, $codigo_programa, $nombre_programa, $descripcion_programa, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbPrograma->salida;
//		return $res;
//	}

	/////////////   FIN  PROGRAMA /////////////////////////////

	/////////////// PROYECTO/////////////////////

//	function ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbProyecto = new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto ->ListarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}
//
//
//	function ContarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbProyecto= new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto ->  ContarProyecto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}
	
//	function InsertarProyecto($id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbProyecto = new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto ->InsertarProyecto($id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}
//	function EliminarProyecto($id_proyecto)
//	{
//		$this->salida = "";
//		$dbProyecto = new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto -> EliminarProyecto($id_proyecto);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}
//	function ModificarProyecto($id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbProyecto = new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto ->ModificarProyecto($id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}
//	function ValidarProyecto($operacion_sql,$id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbProyecto = new cls_DBProyecto($this->decodificar);
//		$res = $dbProyecto ->ValidarProyecto($operacion_sql,$id_proyecto, $codigo_proyecto, $nombre_proyecto, $descripcion_proyecto, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbProyecto->salida;
//		return $res;
//	}

	/////////////   FIN  PROYECTO /////////////////////////////

	/////////////// ACTIVIDAD/////////////////////

//	function ListarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbActividad = new cls_DBActividad($this->decodificar);
//		$res = $dbActividad ->ListarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
//	function ContarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$dbActividad= new cls_DBActividad($this->decodificar);
//		$res = $dbActividad ->  ContarActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
	
//	function InsertarActividad($id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbActividad = new cls_DBActividad($this->decodificar);
//		$res = $dbActividad ->InsertarActividad($id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
//	function EliminarActividad($id_actividad)
//	{
//		$this->salida = "";
//		$dbActividad = new cls_DBActividad($this->decodificar);
//		$res = $dbActividad -> EliminarActividad($id_actividad);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
//	function ModificarActividad($id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbActividad = new cls_DBActividad($this->decodificar);
//		$res = $dbActividad ->ModificarActividad($id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
//	function ValidarActividad($operacion_sql,$id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion)
//	{
//		$this->salida = "";
//		$dbActividad = new cls_DBActividad($this->decodificar);
//		$res = $dbActividad ->ValidarActividad($operacion_sql,$id_actividad, $codigo_actividad, $nombre_actividad, $descripcion_actividad, $fecha_registro, $hora_registro, $fecha_ultima_modificacion, $hora_ultima_modificacion);
//		$this->salida = $dbActividad->salida;
//		return $res;
//	}
//
	/////////////   FIN  ACTIVIDAD /////////////////////////////

	/////////////// MONEDA/////////////////////
/*
	function ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function ContarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda= new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ContarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function InsertarMoneda($id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->InsertarMoneda($id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function EliminarMoneda($id_moneda)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda -> EliminarMoneda($id_moneda);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function ModificarMoneda($id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ModificarMoneda($id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function ValidarMoneda($operacion_sql, $id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ValidarMoneda($operacion_sql, $id_moneda, $nombre, $simbolo, $estado, $origen, $prioridad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
	function ObtenerMonedaPrincipal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ObtenerMonedaPrincipal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMoneda->salida;
		$this->query = $dbMoneda->query;
		return $res;
	}
*/
	/////////////   FIN  MONEDA /////////////////////////////

	/////////////// MEDIDA/////////////////////

	function ListarMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMedida = new cls_DBMedida($this->decodificar);
		$res = $dbMedida ->ListarMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMedida->salida;
		$this->query = $dbMedida->query;
		return $res;
	}
	function ContarListaMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbMedida= new cls_DBMedida($this->decodificar);
		$res = $dbMedida ->ContarListaMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMedida->salida;
		$this->query = $dbMedida->query;
		return $res;
	}

	/////////////   FIN  MEDIDA /////////////////////////////

	/////////////// TIPO CAMBIO/////////////////////

/*	function ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio->ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio->ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function InsertarTipoCambio($id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio->InsertarTipoCambio($id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function EliminarTipoCambio($id_tipo_cambio)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio -> EliminarTipoCambio($id_tipo_cambio);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function ModificarTipoCambio($id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio->ModificarTipoCambio($id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function ValidarTipoCambio($operacion_sql, $id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ValidarTipoCambio($operacion_sql, $id_tipo_cambio,$fecha,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}

	function ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
*/
	/////////////   FIN  TIPO CAMBIO /////////////////////////////

	/////////////// INSTITUCI�N/////////////////////

	/*function ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}


	function ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbInstitucion= new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}
	function InsertarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion)
	{
		$this->salida = "";
		$this->query = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion->InsertarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}
	function EliminarInstitucion($id_institucion)
	{
		$this->salida = "";
		$this->query = "";
		$dbInstitucion= new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion -> EliminarInstitucion($id_institucion);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}
	function ModificarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion)
	{
		$this->salida = "";
		$this->query = "";
		$dbInstitucion= new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion->ModificarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}
	function ValidarInstitucion($operacion_sql, $id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion)
	{
		$this->salida = "";
		$this->query = "";
		$dbInstitucion= new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ValidarInstitucion($operacion_sql, $id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1, $celular2,$fax,$email1,$email2,$pg_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion);
		$this->salida = $dbInstitucion->salida;
		$this->query = $dbInstitucion->query;
		return $res;
	}
*/

	/***********************************************************************/
	/////////////// ProgramaProyectoActividad/////////////////////

//	function ListarProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi= new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi->ListarProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//
//		return $res;
//	}
//	function ContarProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi= new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi->ContarProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//		return $res;
//	}
//	function InsertarProgProyActi($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi = new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi->InsertarProgProyActi($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//		return $res;
//	}
//	function EliminarProgProyActi($id_prog_proy_acti)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi= new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi -> EliminarProgProyActi($id_prog_proy_acti);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//		return $res;
//	}
//	function ModificarProgProyActi($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi= new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi->ModificarProgProyActi($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//		return $res;
//	}
//	function ValidarProgProyActi($operacion_sql, $id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbProgProyActi= new cls_DBProgProyActi($this->decodificar);
//		$res = $dbProgProyActi ->ValidarProgProyActi($operacion_sql, $id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbProgProyActi->salida;
//		$this->query = $dbProgProyActi->query;
//		return $res;
//	}
//
	/***********************************************************************/
	/////////////// FinanciadorRegionalProgramaProyectoActividad/////////////////////

//	function ListarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi= new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi->ListarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//
//		return $res;
//	}
//	function ContarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi= new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi->ContarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//		return $res;
//	}
//	function InsertarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_financiador,$id_regional)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi->InsertarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_financiador,$id_regional);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//		return $res;
//	}
//	function EliminarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi= new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi ->EliminarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//		return $res;
//	}
//	function ModificarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_financiador,$id_regional)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi= new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi->ModificarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_financiador,$id_regional);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//		return $res;
//	}
//	function ValidarFinaRegiProgProyActi($operacion_sql, $id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_financiador,$id_regional)
//	{
//		$this->salida = "";
//		$this->query = "";
//		$dbFinaRegiProgProyActi= new cls_DBFinaRegiProgProyActi($this->decodificar);
//		$res = $dbFinaRegiProgProyActi ->ValidarFinaRegiProgProyActi($operacion_sql,$id_fina_regi_prog_proy_acti, $id_prog_proy_acti,$id_financiador,$id_regional);
//		$this->salida = $dbFinaRegiProgProyActi->salida;
//		$this->query = $dbFinaRegiProgProyActi->query;
//		return $res;
//	}

	/////////////// Tipo Unidad de Medida////////////////////
	/*
	function ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM= new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $dbTUM->  ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida=$dbTUM-> salida;
	$this->query=$dbTUM->query;

	return $res;
	}
	function ContarListaTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM= new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $dbTUM -> ContarListaTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
	$this->salida=$dbTUM->salida;
	$this->query = $dbTUM->query;
	return $res;
	}
	function CrearTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observacion,$estado_registro,$fecha_reg)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM = new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $dbTUM -> CrearTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observacion,$estado_registro,$fecha_reg);
	$this->salida = $dbTUM->salida;
	$this->query = $dbTUM->query;
	return $res;
	}
	function EliminarTipoUnidadMedida($id_tipo_unidad_medida)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM= new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $TUM -> EliminarTipoUnidadMedida($id_tipo_unidad_medida);
	$this->salida = $dbTUM->salida;
	$this->query = $dbTUM -> query;
	return $res;
	}
	function  ModificarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observacion,$estado_resgistro,$fecha_reg)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM= new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $dbTUM-> ModificarTipoUnidadMedida($id_tipo_unidad_medida,$descripcion,$observacion,$estado_resgistro,$fecha_reg);
	$this->salida = $dbTUM->salida;
	$this->query = $dbTUM->query;
	return $res;
	}
	function ValidarTipoUnidadMedida($operacion_sql, $id_tipo_unidad_medida,$descripcion,$observacion,$estado_registro,$fecha_reg)
	{
	$this->salida = "";
	$this->query = "";
	$dbTUM= new cls_DBTipoUnidadMedida($this->decodificar);
	$res = $dbTUM->ValidarTipoUnidadMedida($operacion_sql, $id_tipo_unidad_medida,$descripcion,$observacion,$estado_registro,$fecha_reg);
	$this->salida = $dbTUM->salida;
	$this->query = $dbTUM->query;
	return $res;
	}
	*/

	/// --------------------- tpm_tipo_unidad_medida --------------------- ///

	function ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ListarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ContarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ContarTipoUnidadMedida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function InsertarTipoUnidadMedida($id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->InsertarTipoUnidadMedida($id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ModificarTipoUnidadMedida($id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ModificarTipoUnidadMedida($id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function EliminarTipoUnidadMedida($id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida -> EliminarTipoUnidadMedida($id_tipo_unidad_medida);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	function ValidarTipoUnidadMedida($operacion_sql,$id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadMedida = new cls_DBTipoUnidadMedida($this->decodificar);
		$res = $dbTipoUnidadMedida ->ValidarTipoUnidadMedida($operacion_sql,$id_tipo_unidad_medida,$nombre,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadMedida ->salida;
		$this->query = $dbTipoUnidadMedida ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_tipo_unidad_medida --------------------- ///
	
	/// --------------------- tpm_unidad_medida_base --------------------- ///

	function ListarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ListarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ContarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ContarUnidadMedidaBase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function InsertarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->InsertarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ModificarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ModificarUnidadMedidaBase($id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function EliminarUnidadMedidaBase($id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase -> EliminarUnidadMedidaBase($id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	function ValidarUnidadMedidaBase($operacion_sql,$id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida)
	{
		$this->salida = "";
		$dbUnidadMedidaBase = new cls_DBUnidadMedidaBase($this->decodificar);
		$res = $dbUnidadMedidaBase ->ValidarUnidadMedidaBase($operacion_sql,$id_unidad_medida_base,$nombre,$abreviatura,$descripcion,$observaciones,$estado_registro,$fecha_reg,$id_tipo_unidad_medida);
		$this->salida = $dbUnidadMedidaBase ->salida;
		$this->query = $dbUnidadMedidaBase ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_unidad_medida_base --------------------- ///
	
	/// --------------------- tpm_unidad_medida_sec --------------------- ///

	function ListarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ListarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ContarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ContarUnidadMedidaSec($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function InsertarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->InsertarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ModificarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ModificarUnidadMedidaSec($id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function EliminarUnidadMedidaSec($id_unidad_medida_sec)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec -> EliminarUnidadMedidaSec($id_unidad_medida_sec);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	function ValidarUnidadMedidaSec($operacion_sql,$id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbUnidadMedidaSec = new cls_DBUnidadMedidaSec($this->decodificar);
		$res = $dbUnidadMedidaSec ->ValidarUnidadMedidaSec($operacion_sql,$id_unidad_medida_sec,$nombre,$abreviatura,$factor_conv,$descripcion,$observaciones,$fecha_reg,$id_unidad_medida_base);
		$this->salida = $dbUnidadMedidaSec ->salida;
		$this->query = $dbUnidadMedidaSec ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_unidad_medida_sec --------------------- ///
	
	/// --------------------- tpm_contratista --------------------- ///

/*	function ListarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ListarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}

	function ContarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ContarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}

	function InsertarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->InsertarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}

	function ModificarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ModificarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}

	function EliminarContratista($id_contratista)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista -> EliminarContratista($id_contratista);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}

	function ValidarContratista($operacion_sql,$id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ValidarContratista($operacion_sql,$id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
*/
	/// --------------------- fin tpm_contratista --------------------- ///
	/// --------------------- tpm_subactividad --------------------- ///

	function ListarSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad ->ListarSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	function ContarSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad ->ContarSubactividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	function InsertarSubactividad($id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad ->InsertarSubactividad($id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	function ModificarSubactividad($id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad ->ModificarSubactividad($id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	function EliminarSubactividad($id_subactividad)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad -> EliminarSubactividad($id_subactividad);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	function ValidarSubactividad($operacion_sql,$id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti)
	{
		$this->salida = "";
		$dbSubactividad = new cls_DBSubactividad($this->decodificar);
		$res = $dbSubactividad ->ValidarSubactividad($operacion_sql,$id_subactividad,$codigo,$direccion,$descripcion,$observaciones,$fecha_reg,$id_prog_proy_acti);
		$this->salida = $dbSubactividad ->salida;
		$this->query = $dbSubactividad ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_subactividad --------------------- ///

	/// --------------------- tpm_actividad --------------------- ///

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
	
	function InsertarActividad($id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->InsertarActividad($id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ModificarActividad($id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ModificarActividad($id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
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
	
	function ValidarActividad($operacion_sql,$id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ValidarActividad($operacion_sql,$id_actividad,$codigo_actividad,$nombre_actividad,$descripcion_actividad,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	function ListarActividadEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ListarActividadEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad->salida;
		return $res;
	}
	function ContarActividadEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad= new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ContarActividadEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad->salida;
		return $res;
	}
	function ListarActividadEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ListarActividadEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad->salida;
		return $res;
	}
	function ContarActividadEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad= new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ContarActividadEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad->salida;
		return $res;
	}
	/// --------------------- fin tpm_actividad --------------------- ///
	
	/// --------------------- tpm_financiador --------------------- ///

	function ListarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ListarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function ContarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ContarFinanciador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function InsertarFinanciador($id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->InsertarFinanciador($id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function ModificarFinanciador($id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ModificarFinanciador($id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function EliminarFinanciador($id_financiador)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador -> EliminarFinanciador($id_financiador);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function ValidarFinanciador($operacion_sql,$id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ValidarFinanciador($operacion_sql,$id_financiador,$codigo_financiador,$nombre_financiador,$descripcion_financiador,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbFinanciador ->salida;
		$this->query = $dbFinanciador ->query;
		return $res;
	}
	
	function ListarFinanciadorEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ListarFinanciadorEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador->salida;
		return $res;
	}
	function ContarFinanciadorEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador= new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ContarFinanciadorEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador->salida;
		return $res;
	}
	
	function ListarFinanciadorEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador = new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ListarFinanciadorEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador->salida;
		return $res;
	}
	function ContarFinanciadorEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinanciador= new cls_DBFinanciador($this->decodificar);
		$res = $dbFinanciador ->ContarFinanciadorEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinanciador->salida;
		return $res;
	}
	/// --------------------- fin tpm_financiador --------------------- ///
	
	
	/// --------------------- tpm_programa --------------------- ///

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
	
	function InsertarPrograma($id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->InsertarPrograma($id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}
	
	function ModificarPrograma($id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ModificarPrograma($id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
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
	
	function ValidarPrograma($operacion_sql,$id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ValidarPrograma($operacion_sql,$id_programa,$codigo_programa,$nombre_programa,$descripcion_programa,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbPrograma ->salida;
		$this->query = $dbPrograma ->query;
		return $res;
	}
	function ListarProgramaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ListarProgramaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma->salida;
		return $res;
	}
	function ContarProgramaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma= new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->  ContarProgramaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma->salida;
		return $res;
	}
		
	function ListarProgramaEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma = new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->ListarProgramaEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma->salida;
		return $res;
	}
	function ContarProgramaEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPrograma= new cls_DBPrograma($this->decodificar);
		$res = $dbPrograma ->  ContarProgramaEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrograma->salida;
		return $res;
	}
	
	/// --------------------- fin tpm_programa --------------------- ///
	
	
	/// --------------------- tpm_proyecto --------------------- ///

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
	
	function InsertarProyecto($id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$nombre_corto,$codigo_sisin,$fase_proyecto,$tipo_estudio,$id_persona,$id_proyecto_cat_prog)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->InsertarProyecto($id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$nombre_corto,$codigo_sisin,$fase_proyecto,$tipo_estudio,$id_persona,$id_proyecto_cat_prog);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}
	
	function ModificarProyecto($id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$nombre_corto,$codigo_sisin,$fase_proyecto,$tipo_estudio,$id_persona,$id_proyecto_cat_prog)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ModificarProyecto($id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$nombre_corto,$codigo_sisin,$fase_proyecto,$tipo_estudio,$id_persona,$id_proyecto_cat_prog);
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
	
	function ValidarProyecto($operacion_sql,$id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ValidarProyecto($operacion_sql,$id_proyecto,$codigo_proyecto,$nombre_proyecto,$descripcion_proyecto,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbProyecto ->salida;
		$this->query = $dbProyecto ->query;
		return $res;
	}
	
	function ListarProyectoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ListarProyectoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto->salida;
		return $res;
	}
	function ContarProyectoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto= new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->  ContarProyectoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto->salida;
		return $res;
	}
	
	function ListarProyectoEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto = new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->ListarProyectoEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto->salida;
		return $res;
	}
	function ContarProyectoEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProyecto= new cls_DBProyecto($this->decodificar);
		$res = $dbProyecto ->  ContarProyectoEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProyecto->salida;
		return $res;
	}
	/// --------------------- fin tpm_proyecto --------------------- ///
	
	/// --------------------- tpm_regional --------------------- ///

	function ListarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ListarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function ContarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ContarRegional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function InsertarRegional($id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->InsertarRegional($id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function ModificarRegional($id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ModificarRegional($id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function EliminarRegional($id_regional)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional -> EliminarRegional($id_regional);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function ValidarRegional($operacion_sql,$id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ValidarRegional($operacion_sql,$id_regional,$codigo_regional,$nombre_regional,$descripcion_regional,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion);
		$this->salida = $dbRegional ->salida;
		$this->query = $dbRegional ->query;
		return $res;
	}
	
	function ListarRegionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ListarRegionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional->salida;
		return $res;
	}
	function ContarRegionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional= new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->  ContarRegionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional->salida;
		return $res;
	}
	
	function ListarRegionalEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional = new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->ListarRegionalEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional->salida;
		return $res;
	}
	function ContarRegionalEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRegional= new cls_DBRegional($this->decodificar);
		$res = $dbRegional ->  ContarRegionalEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRegional->salida;
		return $res;
	}
	/// --------------------- fin tpm_regional --------------------- ///
	
	/// --------------------- tpm_programa_proyecto_actividad --------------------- ///

	function ListarProgramaProyectoActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad ->ListarProgramaProyectoActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	function ContarProgramaProyectoActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad ->ContarProgramaProyectoActividad($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	function InsertarProgramaProyectoActividad($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad ->InsertarProgramaProyectoActividad($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	function ModificarProgramaProyectoActividad($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad ->ModificarProgramaProyectoActividad($id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	function EliminarProgramaProyectoActividad($id_prog_proy_acti)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad -> EliminarProgramaProyectoActividad($id_prog_proy_acti);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	function ValidarProgramaProyectoActividad($operacion_sql,$id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProgramaProyectoActividad = new cls_DBProgramaProyectoActividad($this->decodificar);
		$res = $dbProgramaProyectoActividad ->ValidarProgramaProyectoActividad($operacion_sql,$id_prog_proy_acti,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProgramaProyectoActividad ->salida;
		$this->query = $dbProgramaProyectoActividad ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_programa_proyecto_actividad --------------------- ///
	/*ana */
	/// --------------------- tpm_fina_regi_prog_proy_acti --------------------- ///

	function ListarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->ListarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function ListarFinaRegiProgProyActiUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->ListarFinaRegiProgProyActiUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function ContarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->ContarFinaRegiProgProyActi($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function InsertarFinaRegiProgProyActi($id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->InsertarFinaRegiProgProyActi($id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function ModificarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->ModificarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function EliminarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi -> EliminarFinaRegiProgProyActi($id_fina_regi_prog_proy_acti);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	function ValidarFinaRegiProgProyActi($operacion_sql,$id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador)
	{
		$this->salida = "";
		$dbFinaRegiProgProyActi = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbFinaRegiProgProyActi ->ValidarFinaRegiProgProyActi($operacion_sql,$id_fina_regi_prog_proy_acti,$id_prog_proy_acti,$id_regional,$id_financiador);
		$this->salida = $dbFinaRegiProgProyActi ->salida;
		$this->query = $dbFinaRegiProgProyActi ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_fina_regi_prog_proy_acti --------------------- ///
		/// --------------------- tpm_moneda --------------------- ///

	function ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ListarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	function ContarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ContarMoneda($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	function InsertarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->InsertarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	function ModificarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ModificarMoneda($id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	function EliminarMoneda($id_moneda)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda -> EliminarMoneda($id_moneda);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	function ValidarMoneda($operacion_sql,$id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad)
	{
		$this->salida = "";
		$dbMoneda = new cls_DBMoneda($this->decodificar);
		$res = $dbMoneda ->ValidarMoneda($operacion_sql,$id_moneda,$nombre,$simbolo,$estado,$origen,$prioridad);
		$this->salida = $dbMoneda ->salida;
		$this->query = $dbMoneda ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_moneda --------------------- ///
		/// --------------------- tpm_tipo_cambio --------------------- ///

	function ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ListarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ContarTipoCambio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	function ListarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ListarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function ContarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ContarTipoCambioOCV($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function InsertarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->InsertarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function ModificarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ModificarTipoCambio($id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function EliminarTipoCambio($id_tipo_cambio)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio -> EliminarTipoCambio($id_tipo_cambio);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	function ValidarTipoCambio($operacion_sql,$id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda)
	{
		$this->salida = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ValidarTipoCambio($operacion_sql,$id_tipo_cambio,$fecha,$hora,$oficial,$compra,$venta,$observaciones,$estado,$id_moneda);
		$this->salida = $dbTipoCambio ->salida;
		$this->query = $dbTipoCambio ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_tipo_cambio --------------------- ///
	/// --------------------- tpm_tipo_doc_institucion --------------------- ///

	function ListarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion ->ListarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	function ContarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion ->ContarTipoDocInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	function InsertarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion ->InsertarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	function ModificarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion ->ModificarTipoDocInstitucion($id_tipo_doc_institucion,$nombre_tipo_doc,$observacion);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	function EliminarTipoDocInstitucion($id_tipo_doc_institucion)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion -> EliminarTipoDocInstitucion($id_tipo_doc_institucion);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	function ValidarTipoDocInstitucion($operacion_sql,$id_tipo_doc_institucion,$nombre_tipo_doc,$observacion)
	{
		$this->salida = "";
		$dbTipoDocInstitucion = new cls_DBTipoDocInstitucion($this->decodificar);
		$res = $dbTipoDocInstitucion ->ValidarTipoDocInstitucion($operacion_sql,$id_tipo_doc_institucion,$nombre_tipo_doc,$observacion);
		$this->salida = $dbTipoDocInstitucion ->salida;
		$this->query = $dbTipoDocInstitucion ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_tipo_doc_institucion --------------------- ///
	/// --------------------- tpm_institucion --------------------- ///

	function ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ListarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	function ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ContarInstitucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	function InsertarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->InsertarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	function ModificarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ModificarInstitucion($id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion,$codigo);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	function EliminarInstitucion($id_institucion)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion -> EliminarInstitucion($id_institucion);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	function ValidarInstitucion($operacion_sql,$id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion)
	{
		$this->salida = "";
		$dbInstitucion = new cls_DBInstitucion($this->decodificar);
		$res = $dbInstitucion ->ValidarInstitucion($operacion_sql,$id_institucion,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$observaciones,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$estado_institucion,$id_persona,$direccion,$id_tipo_doc_institucion);
		$this->salida = $dbInstitucion ->salida;
		$this->query = $dbInstitucion ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_institucion --------------------- ///
		/// --------------------- tpm_contratista --------------------- ///

	function ListarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ListarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	
	function ContarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ContarContratista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	
	function InsertarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->InsertarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	
	function ModificarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ModificarContratista($id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	
	function EliminarContratista($id_contratista)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista -> EliminarContratista($id_contratista);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	
	function ValidarContratista($operacion_sql,$id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbContratista = new cls_DBContratista($this->decodificar);
		$res = $dbContratista ->ValidarContratista($operacion_sql,$id_contratista,$codigo,$observaciones,$estado_registro,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbContratista ->salida;
		$this->query = $dbContratista ->query;
		return $res;
	}
	/// --------------------- fin tpm_contratista --------------------- ///
	
	/// --------------------- tpm_documento --------------------- ///
	function ListarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function InsertarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->InsertarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ModificarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ModificarDocumento($id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema,$num_firma,$tipo_numeracion,$id_tipo_proceso,$tipo);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function EliminarDocumento($id_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento -> EliminarDocumento($id_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ValidarDocumento($operacion_sql,$id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ValidarDocumento($operacion_sql,$id_documento,$codigo,$descripcion,$documento,$prefijo,$sufijo,$estado,$id_subsistema, $num_firma);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}	
	/// --------------------- fin tpm_documento --------------------- ///
	
	/// --------------------- tpm_gestion --------------------- ///

	function ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ListarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ContarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ContarGestion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function InsertarGestion($id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->InsertarGestion($id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ModificarGestion($id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ModificarGestion($id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function EliminarGestion($id_gestion)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion -> EliminarGestion($id_gestion);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	function ValidarGestion($operacion_sql,$id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral)
	{
		$this->salida = "";
		$dbGestion = new cls_DBGestion($this->decodificar);
		$res = $dbGestion ->ValidarGestion($operacion_sql,$id_gestion,$id_empresa,$id_moneda_base,$gestion,$estado_ges_gral);
		$this->salida = $dbGestion ->salida;
		$this->query = $dbGestion ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_gestion --------------------- ///
	/// --------------------- tpm_correlativo_general --------------------- ///

	function ListarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral ->ListarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	function ContarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral ->ContarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	function InsertarCorrelativoGeneral($id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral ->InsertarCorrelativoGeneral($id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	function ModificarCorrelativoGeneral($id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral ->ModificarCorrelativoGeneral($id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	function EliminarCorrelativoGeneral($id_correlativo_general)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral -> EliminarCorrelativoGeneral($id_correlativo_general);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	function ValidarCorrelativoGeneral($operacion_sql,$id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo)
	{
		$this->salida = "";
		$dbCorrelativoGeneral = new cls_DBCorrelativoGeneral($this->decodificar);
		$res = $dbCorrelativoGeneral ->ValidarCorrelativoGeneral($operacion_sql,$id_correlativo_general,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo);
		$this->salida = $dbCorrelativoGeneral ->salida;
		$this->query = $dbCorrelativoGeneral ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_correlativo_general --------------------- ///
	/// --------------------- tpm_correlativo_rp --------------------- ///

	function ListarCorrelativoRp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp ->ListarCorrelativoRp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	function ContarCorrelativoRp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp ->ContarCorrelativoRp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	function InsertarCorrelativoRp($id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp ->InsertarCorrelativoRp($id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	function ModificarCorrelativoRp($id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp ->ModificarCorrelativoRp($id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	function EliminarCorrelativoRp($id_correlativo_rp)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp -> EliminarCorrelativoRp($id_correlativo_rp);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	function ValidarCorrelativoRp($operacion_sql,$id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional)
	{
		$this->salida = "";
		$dbCorrelativoRp = new cls_DBCorrelativoRp($this->decodificar);
		$res = $dbCorrelativoRp ->ValidarCorrelativoRp($operacion_sql,$id_correlativo_rp,$nro_doc_siguiente,$nro_doc_actual,$id_documento,$id_empresa,$id_periodo,$id_proyecto,$id_regional);
		$this->salida = $dbCorrelativoRp ->salida;
		$this->query = $dbCorrelativoRp ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_correlativo_rp --------------------- ///
	
	
	
	
	/// --------------------- tpm_depto --------------------- ///

	function ListarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ListarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	function ContarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ContarDepartamento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	function InsertarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema,$id_lugar,$id_tipo_proceso,$codificacion)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->InsertarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema,$id_lugar,$id_tipo_proceso,$codificacion);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	function ModificarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema,$id_lugar,$id_tipo_proceso,$codificacion)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ModificarDepartamento($id_depto,$codigo_depto,$nombre_depto,$estado,$id_subsistema,$id_lugar,$id_tipo_proceso,$codificacion);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	function EliminarDepartamento($id_depto)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto -> EliminarDepartamento($id_depto);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	function ValidarDepartamento($operacion_sql,$id_depto,$codigo_depto,$nombre_depto,$estado)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ValidarDepartamento($operacion_sql,$id_depto,$codigo_depto,$nombre_depto,$estado);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	/// --------------------- fin tpm_depto --------------------- ///	
	
	/// --------------------- tpm_depto_ep --------------------- ///	
	//RCM: 10/03/2009
	function ListarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ListarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	
	//RCM: 10/03/2009
	function ContarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDepto = new cls_DBDepto($this->decodificar);
		$res = $dbDepto ->ContarDepartamentoEPUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDepto ->salida;
		$this->query = $dbDepto ->query;
		return $res;
	}
	

	function ListarDepartamentoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ListarDepartamentoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function ContarDepartamentoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ContarDepartamentoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function InsertarDepartamentoEP($id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->InsertarDepartamentoEP($id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function ModificarDepartamentoEP($id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ModificarDepartamentoEP($id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function EliminarDepartamentoEP($id_depto_ep)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp -> EliminarDepartamentoEP($id_depto_ep);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function ValidarDepartamentoEP($operacion_sql,$id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ValidarDepartamentoEP($operacion_sql,$id_depto_ep,$id_depto,$id_ep,$estado,$id_depto_division);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function ListarDepartamentoEPFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ListarDepartamentoEPFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	
	function ContarDepartamentoEPFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoEp = new cls_DBDeptoEp($this->decodificar);
		$res = $dbDeptoEp ->ContarDepartamentoEPFA($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoEp ->salida;
		$this->query = $dbDeptoEp ->query;
		return $res;
	}
	/// --------------------- fin tpm_depto_ep --------------------- ///
	
	/// --------------------- tpm_depto_usuario --------------------- ///

	function ListarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario ->ListarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	function ContarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario ->ContarDepartamentoUsuario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	function InsertarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario ->InsertarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	function ModificarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario ->ModificarDepartamentoUsuario($id_depto_usuario,$id_depto,$id_usuario,$estado,$cargo);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	function EliminarDepartamentoUsuario($id_depto_usuario)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario -> EliminarDepartamentoUsuario($id_depto_usuario);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	function ValidarDepartamentoUsuario($operacion_sql,$id_depto_usuario,$id_depto,$id_usuario,$estado)
	{
		$this->salida = "";
		$dbDeptoUsuario = new cls_DBDeptoUsuario($this->decodificar);
		$res = $dbDeptoUsuario ->ValidarDepartamentoUsuario($operacion_sql,$id_depto_usuario,$id_depto,$id_usuario,$estado);
		$this->salida = $dbDeptoUsuario ->salida;
		$this->query = $dbDeptoUsuario ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_depto_usuario --------------------- ///
	
	
	//RCM: 26/03/2009
	function ObtenerIdEp($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEP = new cls_DBFinaRegiProgProyActi($this->decodificar);
		$res = $dbEP -> ObtenerIdEp($id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEP ->salida;
		$this->query = $dbEP ->query;
		return $res;
	}
	
	//RCM: 02/04/2009
	/// --------------------- tpm_depto_firma_autoriz --------------------- ///

	function ListarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db ->ListarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db ->ContarDeptoFirmaAutoriz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function InsertarDeptoFirmaAutoriz($importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db ->InsertarDeptoFirmaAutoriz($importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ModificarDeptoFirmaAutoriz($id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db ->ModificarDeptoFirmaAutoriz($id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$sw_obliga,$desc_firma,$fecha_reg);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function EliminarDeptoFirmaAutoriz($id_depto_firma_autoriz)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db -> EliminarDeptoFirmaAutoriz($id_depto_firma_autoriz);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ValidarDeptoFirmaAutoriz($operacion_sql,$id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$fecha_reg,$sw_obliga,$desc_firma)
	{
		$this->salida = "";
		$db = new cls_DBDeptoFirmaAutoriz($this->decodificar);
		$res = $db ->ValidarDeptoFirmaAutoriz($operacion_sql,$id_depto_firma_autoriz,$importe_min,$importe_max,$prioridad,$id_depto,$id_documento,$id_empleado,$id_moneda,$estado_reg,$fecha_reg,$sw_obliga,$desc_firma);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	/// --------------------- fin tpm_depto_firma_autoriz --------------------- ///
	
	/* periodo */
	
		function ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBPeriodo($this->decodificar);
		$res = $db ->ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	
	function ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$db = new cls_DBPeriodo($this->decodificar);
		$res = $db ->ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $db ->salida;
		$this->query = $db ->query;
		return $res;
	}
	/*AVQ 17/06/2009 */
	/// --------------------- tpm_depto_conta --------------------- ///

	/// --------------------- tpm_depto_conta --------------------- ///

	function ListarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta ->ListarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	
	function ContarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta ->ContarDepartamentoConta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	
	function InsertarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta ->InsertarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	
	function ModificarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta ->ModificarDepartamentoConta($id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	
	function EliminarDepartamentoConta($id_depto_conta)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta -> EliminarDepartamentoConta($id_depto_conta);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	
	function ValidarDepartamentoConta($operacion_sql,$id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal)
	{
		$this->salida = "";
		$dbDeptoConta = new cls_DBDeptoConta($this->decodificar);
		$res = $dbDeptoConta ->ValidarDepartamentoConta($operacion_sql,$id_depto_conta,$id_depto,$id_presupuesto,$sw_central,$sw_estado,$id_cuenta_auxiliar,$sw_rendicion,$sw_documento,$id_depto_tesoro,$id_depto_conta_central,$id_partida_sueldos,$id_cuenta_auxiliar_sueldos,$id_sucursal);
		$this->salida = $dbDeptoConta ->salida;
		$this->query = $dbDeptoConta ->query;
		return $res;
	}
	

	function ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio= new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ConvertirMonto($fecha, $monto, $id_moneda1, $id_moneda2, $tipo);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	function ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo)
	{
		$this->salida = "";
		$this->query = "";
		$dbTipoCambio = new cls_DBTipoCambio($this->decodificar);
		$res = $dbTipoCambio ->ObtenerTipoCambio($fecha, $id_moneda1, $id_moneda2, $tipo);
		$this->salida = $dbTipoCambio->salida;
		$this->query = $dbTipoCambio->query;
		return $res;
	}
	//Agregado el 24/04/2011 aayaviri
	/// --------------------- tpm_depto_uo --------------------- ///
	function ListarDepartamentoUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO ->ListarDepartamentoUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	
	function ContarDepartamentoUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO ->ContarDepartamentoUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	
	function InsertarDepartamentoUO($id_depto,$id_unidad_organizacional,$estado)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO ->InsertarDepartamentoUO($id_depto,$id_unidad_organizacional,$estado);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	
	function ModificarDepartamentoUO($id_depto_uo,$id_depto,$id_unidad_organizacional,$estado)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO ->ModificarDepartamentoUO($id_depto_uo,$id_depto,$id_unidad_organizacional,$estado);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	
	function EliminarDepartamentoUO($id_depto_uo)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO -> EliminarDepartamentoUO($id_depto_uo);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	
	function ValidarDepartamentoUO($operacion_sql,$id_depto_uo,$id_depto,$id_unidad_organizacional,$estado)
	{
		$this->salida = "";
		$dbDeptoUO = new cls_DBDeptoUO($this->decodificar);
		$res = $dbDeptoUO ->ValidarDepartamentoUO($operacion_sql,$id_depto_uo,$id_depto,$id_unidad_organizacional,$estado);
		$this->salida = $dbDeptoUO ->salida;
		$this->query = $dbDeptoUO ->query;
		return $res;
	}
	/// --------------------- fin tpm_depto_uo --------------------- ///
	
	function ListarDepartamentoDiv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv ->ListarDepartamentoDiv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	function ContarDepartamentoDiv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv ->ContarDepartamentoDiv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	function InsertarDepartamentoDiv($id_depto,$codigo_division,$division,$estado)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv ->InsertarDepartamentoDiv($id_depto,$codigo_division,$division,$estado);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	function ModificarDepartamentoDiv($id_depto_division,$id_depto,$codigo_division,$division,$estado)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv ->ModificarDepartamentoDiv($id_depto_division,$id_depto,$codigo_division,$division,$estado);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	function EliminarDepartamentoDiv($id_depto_division)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv -> EliminarDepartamentoDiv($id_depto_division);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	function ValidarDepartamentoDiv($operacion_sql,$id_depto_division,$id_depto,$codigo_division,$division,$estado)
	{
		$this->salida = "";
		$dbDeptoDiv = new cls_DBDeptoDiv($this->decodificar);
		$res = $dbDeptoDiv ->ValidarDepartamentoDiv($operacion_sql,$id_depto_division,$id_depto,$codigo_division,$division,$estado);
		$this->salida = $dbDeptoDiv ->salida;
		$this->query = $dbDeptoDiv ->query;
		return $res;
	}
	
	//-------------------------------------------------------------------
	function ListarFinanciadorDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBFinanciador($this->decodificar);
		$res = $dbActividad ->ListarFinanciadorDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ContarFinanciadorDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBFinanciador($this->decodificar);
		$res = $dbActividad ->ListarFinanciadorDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ListarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBRegional($this->decodificar);
		$res = $dbActividad ->ListarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ContarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBRegional($this->decodificar);
		$res = $dbActividad ->ContarRegionalDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ListarProgramaDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBPrograma($this->decodificar);
		$res = $dbActividad ->ListarProgramaDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ContarProgramaDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBPrograma($this->decodificar);
		$res = $dbActividad ->ContarProgramaDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ListarProyectoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBProyecto($this->decodificar);
		$res = $dbActividad ->ListarProyectoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ContarProyectoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBProyecto($this->decodificar);
		$res = $dbActividad ->ContarProyectoDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ListarActividadDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ListarActividadDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	
	function ContarActividadDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbActividad = new cls_DBActividad($this->decodificar);
		$res = $dbActividad ->ContarActividadDepto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbActividad ->salida;
		$this->query = $dbActividad ->query;
		return $res;
	}
	/// --------------------- tpm_config_aprobador --------------------- ///
	function ListarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro ->ListarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}

	function ContarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro ->ContarConfigAprobador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}

	function InsertarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro ->InsertarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}

	function ModificarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro ->ModificarConfigAprobador($id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad,$estado,$fecha_expiracion);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}

	function EliminarConfigAprobador($id_config_aprobador)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro -> EliminarConfigAprobador($id_config_aprobador);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}

	function ValidarConfigAprobador($operacion_sql,$id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad)
	{
		$this->salida = "";
		$dbConfigApro = new cls_DBConfigAprobador($this->decodificar);
		$res = $dbConfigApro ->ValidarConfigAprobador($operacion_sql,$id_config_aprobador,$id_gestion,$id_presupuesto,$id_uo,$concepto,$min_monto,$max_monto,$id_empleado,$prioridad);
		$this->salida = $dbConfigApro ->salida;
		$this->query = $dbConfigApro ->query;
		return $res;
	}
	/// --------------------- fin tpm_ConfigAprobador --------------------- ///
	
	/// --------------------- tpm_sucursal --------------------- ///
	function ListarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal ->ListarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	
	function ContarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal ->ContarSucursal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	
	function InsertarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal ->InsertarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	
	function ModificarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal ->ModificarSucursal($id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	
	function EliminarSucursal($id_sucursal)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal -> EliminarSucursal($id_sucursal);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	
	function ValidarSucursal($operacion_sql,$id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto)
	{
		$this->salida = "";
		$dbSucursal = new cls_DBSucursal($this->decodificar);
		$res = $dbSucursal ->ValidarSucursal($operacion_sql,$id_sucursal,$nombre,$razon_social,$nit,$direccion,$proyecto);
		$this->salida = $dbSucursal ->salida;
		$this->query = $dbSucursal ->query;
		return $res;
	}
	/// --------------------- fin tpm_sucursal --------------------- ///
	
	//////////////////// FECHA ////////////////////
	function ListarFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha ->ListarFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	function ContarFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha ->ContarFecha($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	function InsertarFecha($id_fecha, $fecha, $tipo_fecha, $desc_fecha,$id_lugar)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha ->InsertarFecha($id_fecha, $fecha, $tipo_fecha, $desc_fecha,$id_lugar);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	function ModificarFecha($id_fecha, $fecha, $tipo_fecha, $desc_fecha,$id_lugar)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha ->ModificarFecha($id_fecha, $fecha, $tipo_fecha, $desc_fecha,$id_lugar);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	function EliminarFecha($id_fecha)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha -> EliminarFecha($id_fecha);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	function ValidarFecha($operacion_sql, $id_fecha, $fecha, $tipo_fecha, $desc_fecha)
	{
		$this->salida = "";
		$dbFecha = new cls_DBFecha($this->decodificar);
		$res = $dbFecha ->ValidarFecha($operacion_sql, $id_fecha, $id_param, $fecha, $tipo_fecha, $desc_fecha);
		$this->salida = $dbFecha->salida;
		$this->query = $dbFecha->query;
		return $res;
	}
	//////////////////// FIN FECHA ////////////////////
	
	//////////////////// EPE_INV ///////////////////
	function ListarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv ->ListarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	
	function ContarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv ->ContarEpeInv($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	
	function InsertarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv ->InsertarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	
	function ModificarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv ->ModificarEpeInv($id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	
	function EliminarEpeInv($id_epe_inv)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv -> EliminarEpeInv($id_epe_inv);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	
	function ValidarEpeInv($operacion_sql,$id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv)
	{
		$this->salida = "";
		$dbEpeInv = new cls_DBEpeInv($this->decodificar);
		$res = $dbEpeInv ->ValidarEpeInv($operacion_sql,$id_epe_inv,$id_epe,$id_gestion,$id_moneda,$importe_inv);
		$this->salida = $dbEpeInv ->salida;
		$this->query = $dbEpeInv ->query;
		return $res;
	}
	//////////////////// FIN EPE_INV ///////////////////
}?>