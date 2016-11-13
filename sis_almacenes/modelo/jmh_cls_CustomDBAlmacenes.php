<?php
/**
 * Nombre de la Clase:	    CustomDBAlmacenes
 * Propósito:				Interfaz del modelo del Sistema de Almacenes
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		29-09-2007
 * Autor:					Josè A. Mita Huanca
 *
 */

class cls_CustomDBAlmacenes
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

		include_once("cls_DBKardexLogicoVista.php");
		include_once("cls_DBAlmacenVista.php");
		include_once("cls_DBAlmacenEpVista.php");
		include_once("DBTransferencia/cls_DBTransferencia.php");
	
	}		
	
	/// --------------------- val_kardex_logico --------------------- ////
	


	function ListarKardexLogicoVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{   
		$this->salida = "";
		$dbkardexVista = new cls_DBKardexLogicoVista($this->decodificar);
		$res = $dbkardexVista ->ListarKardexLogicoVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbkardexVista ->salida;
		$this->query = $dbkardexVista ->query;
		
		return $res;
	}
	
	function ContarKardexLogicoVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSalida = new cls_DBKardexLogicoVista($this->decodificar);
		$res = $dbSalida ->ContarKardexLogicoVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSalida ->salida;
		$this->query = $dbSalida ->query;
		return $res;
	}
	
	//////////***------------ val almacen vista -----------------------//////////////
	
	
	function ListarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{   
		$this->salida = "";
		$dbAlmacenVista = new cls_DBAlmacenVista($this->decodificar);
		$res = $dbAlmacenVista ->ListarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenVista ->salida;
		$this->query = $dbAlmacenVista ->query;
		return $res;
	}
	
	function ContarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenVista = new cls_DBAlmacenVista($this->decodificar);
		$res = $dbAlmacenVista ->ContarAlmacenVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenVista ->salida;
		$this->query = $dbAlmacenVista ->query;
		return $res;
	}

	//////////***------------ val almacen ep -----------------------//////////////
	
	
	function ListarAlmacenEpVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{   
		$this->salida = "";
		$dbAlmacenVista = new cls_DBAlmacenEpVista($this->decodificar);
		$res = $dbAlmacenVista ->ListarAlmacenEpVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenVista ->salida;
		$this->query = $dbAlmacenVista ->query;
		return $res;
	}
	
	function ContarAlmacenEpVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAlmacenVista = new cls_DBAlmacenEpVista($this->decodificar);
		$res = $dbAlmacenVista ->ContarAlmacenEpVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAlmacenVista ->salida;
		$this->query = $dbAlmacenVista ->query;
		return $res;
	}
	
	//////////////////////********* Db Transferencia
	
	function GuardarBajasPend($id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material)
	{	
		$this->salida = "";
		$dbBajaPend = new cls_DBTransferencia($this->decodificar);
		$res = $dbBajaPend ->GuardarBajasPend($id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material);
		$this->salida = $dbBajaPend ->salida;
		$this->query = $dbBajaPend ->query;
		return $res;
	}
	
	function ValidarTransferencia($operacion_sql,$id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material)
	{
		$this->salida = "";
		$dbTransferencia = new cls_DBTransferencia($this->decodificar);
		$res = $dbTransferencia ->ValidarTransferencia($operacion_sql,$id_transferencia,$motivo,$descripcion,$observaciones,$id_empleado,$id_almacen_logico,$id_motivo_ingreso_cuenta,$id_tipo_material);
		$this->salida = $dbTransferencia ->salida;
		$this->query = $dbTransferencia ->query;
		return $res;
	}
}
?>