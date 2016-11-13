<?php
/**
 * Nombre de la Clase:	    CustomDBKardexPersonal
 * Prop�sito:				Es la interfaz del modelo del Sistema de Kardex de Personal
 * todos los metodos existentes pasan por aqui
 * Fecha de Creaci�n:		21-06-2007
 * Autor:					Rodrigo Chumacero Moscoso
 *
 */
class cls_CustomDBKardexPersonal
{
	//variable que contiene la salida de la ejecuci�n de la funci�n
	//si la funci�n tuvo error (false), salida contendr� el mensaje de error
	//si la funci�n no tuvo error (true), salida contendr� el resultado, ya sea un conjunto de datos o un mensaje de confirmaci�n
	var $salida = "";

	//Variable que contedr� la cadena de llamada a las funciones postgres
	var $query = "";

	//Bandera que indica si los datos se decodificar�n o no
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBEmpleado.php");
		include_once("cls_DBEmpleadoCta.php");
		include_once("cls_DBEmpleadoTpmFrppa.php");
		include_once("cls_DBEmpleadoExtension.php");
		include_once("cls_DBUnidadOrganizacional.php");
		include_once("cls_DBUnidadOrganizacionalArb.php");
		include_once("cls_DBNivelOrganizacional.php");
		include_once("cls_DBHistoricoAsignacion.php"); 
		include_once("cls_DBEmpleadoHorario.php");
		include_once("cls_DBHorario.php");
		include_once("cls_DBTipoHorario.php");
		
		include_once("cls_DBEmpleadoTrabajo.php");
		include_once("cls_DBTipoCapacitacion.php");
		include_once("cls_DBEmpleadoCapacitacion.php");
	//	include_once("cls_DBParametroCuentaAuxiliar.php");
	}

	/////////////// EMPLEADO/////////////////////
	function ListarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado->salida;
		$this->query = $dbEmpleado->query;
		return $res;
	}
	function ContarListaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado= new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarListaEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado->salida;
		$this->query = $dbEmpleado->query;
		return $res;
	}

	//Listado de Empleado para usar en reportes

	function ListarEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado->salida;
		$this->query = $dbEmpleado->query;
		return $res;
	}
	function ContarListaEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado= new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarListaEmpleadoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado->salida;
		$this->query = $dbEmpleado->query;
		return $res;
	}

	/////////////   FIN EMPLEADO /////////////////////////////

	///////////////////////////////////////////////////////////////////
	//////////////�LTIMA VERSI�N EMPLEADO (AUTOGENERADO)///////////////
	///////////////////////////////////////////////////////////////////


	/// --------------------- tkp_empleado --------------------- ///

	function ListarEmpleado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleado_($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ListarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ListarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ListarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	function ContarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarEmpleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ContarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarFuncionario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ContarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarEmpleadoGerencia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ContarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarEmpleadoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	function ListarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	function ContarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarEmpleadoUsuarioEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	
	function InsertarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->InsertarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	function ModificarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ModificarEmpleado($id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg,$id_depto,$id_lugar,$fecha_ingreso,$antiguedad_ant,$id_escala_salarial);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	function EliminarEmpleado($id_empleado)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado -> EliminarEmpleado($id_empleado);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	function ValidarEmpleado($operacion_sql,$id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ValidarEmpleado($operacion_sql,$id_empleado,$id_persona,$codigo_empleado,$id_cuenta,$id_auxiliar,$estado_reg,$fecha_reg);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	
	function ListarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ListarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	
	
	function ContarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->ContarEmpleados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}
	
	function InsertarEmpleadoSuplente($id_empleado,$id_empleado_suplente,$subsis,$vista)
	{
		$this->salida = "";
		$dbEmpleado = new cls_DBEmpleado($this->decodificar);
		$res = $dbEmpleado ->InsertarEmpleadoSuplente($id_empleado,$id_empleado_suplente,$subsis,$vista);
		$this->salida = $dbEmpleado ->salida;
		$this->query = $dbEmpleado ->query;
		return $res;
	}

	
	/// --------------------- fin tkp_empleado --------------------- ///


	////////////// FIN EMPLEADO////////////////////////////



	/// --------------------- tkp_empleado_tpm_frppa --------------------- ///

	function ListarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ListarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function ContarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ContarEmpleadoTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function InsertarEmpleadoTpmFrppa($id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->InsertarEmpleadoTpmFrppa($id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function ModificarEmpleadoTpmFrppa($id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ModificarEmpleadoTpmFrppa($id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function EliminarEmpleadoTpmFrppa($id_empleado_frppa)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa -> EliminarEmpleadoTpmFrppa($id_empleado_frppa);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	
	function ListarEmpleadoUsuarioTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ListarEmpleadoUsuarioTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function ContarEmpleadoUsuarioTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ContarEmpleadoUsuarioTpmFrppa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	function ValidarEmpleadoTpmFrppa($operacion_sql,$id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoTpmFrppa = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEmpleadoTpmFrppa ->ValidarEmpleadoTpmFrppa($operacion_sql,$id_empleado_frppa,$id_empleado,$fecha_registro,$hora_ingreso,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$estado_reg);
		$this->salida = $dbEmpleadoTpmFrppa ->salida;
		$this->query = $dbEmpleadoTpmFrppa ->query;
		return $res;
	}

	
		
	function ListarEPempleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeEmpleado= new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEpeEmpleado->ListarEPempleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeEmpleado->salida;
		$this->query = $dbEpeEmpleado->query;
		return $res;
	}
	
	
	function ContarEPempleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEpeEmpleado = new cls_DBEmpleadoTpmFrppa($this->decodificar);
		$res = $dbEpeEmpleado->ContarEPempleado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEpeEmpleado->salida;
		$this->query = $dbEpeEmpleado->query;
		return $res;
	}
	
	
	
	/// --------------------- fin tkp_empleado_tpm_frppa --------------------- ///
	/// --------------------- tkp_empleado_extension --------------------- ///

	function ListarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ListarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	function ContarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ContarEmpleadoExtension($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	function ListarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ListarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	function ContarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ContarEmpleadoExtensionGerente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	function InsertarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->InsertarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	function ModificarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ModificarEmpleadoExtension($id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	function EliminarEmpleadoExtension($id_empleado_extension)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension -> EliminarEmpleadoExtension($id_empleado_extension);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	function ValidarEmpleadoExtension($operacion_sql,$id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado)
	{
		$this->salida = "";
		$dbEmpleadoExtension = new cls_DBEmpleadoExtension($this->decodificar);
		$res = $dbEmpleadoExtension ->ValidarEmpleadoExtension($operacion_sql,$id_empleado_extension,$codigo_telefonico,$id_empleado,$id_gerencia,$estado);
		$this->salida = $dbEmpleadoExtension ->salida;
		$this->query = $dbEmpleadoExtension ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_empleado_extension --------------------- ///
	
	
	/// --------------------- tkp_unidad_organizacional --------------------- ///

	function ListarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ListarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function ContarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ContarUnidadOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	
	function ListarUnidadOrganizacionalCentro($id_empleado,$id_ep)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ListarUnidadOrganizacionalCentro($id_empleado,$id_ep);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function InsertarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->InsertarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function ModificarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ModificarUnidadOrganizacional($id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function EliminarUnidadOrganizacional($id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional -> EliminarUnidadOrganizacional($id_unidad_organizacional);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function ValidarUnidadOrganizacional($operacion_sql,$id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ValidarUnidadOrganizacional($operacion_sql,$id_unidad_organizacional,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$fecha_reg,$id_nivel_organizacional,$estado_reg);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function FiltrarOrganigramaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->FiltrarOrganigramaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$v_id);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	//RCM: 03/02/2009
	function ListarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ListarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	//RCM: 03/02/2009
	function ContarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacional($this->decodificar);
		$res = $dbUnidadOrganizacional ->ContarUnidadOrganizacionalEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_unidad_organizacional --------------------- ///
	/// --------------------- tkp_unidad_organizacional_arb --------------------- ///
	
	function ListarUnidadOrganizacionalRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->ListarUnidadOrganizacionalRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function ListarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->ListarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function ContarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->ContarUnidadOrganizacionalArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function InsertarUnidadOrganizacionalRaiz($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->InsertarUnidadOrganizacionalRaiz($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	
	function InsertarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->InsertarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function ModificarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->ModificarUnidadOrganizacionalArb($id,$id_padre,$relacion,$observaciones,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$id_padre_nuevo,$estado_reg,$importe_max_apro,$importe_max_pre,$sw_presto);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function EliminarUnidadOrganizacionalArb($id,$id_padre)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->EliminarUnidadOrganizacionalArb($id,$id_padre);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function EliminarUnidadOrganizacionalRaiz($id)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->EliminarUnidadOrganizacionalRaiz($id);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function DragAndDrop($id,$id_padre,$id_padre_nuevo)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->DragAndDrop($id,$id_padre,$id_padre_nuevo);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	function ValidarUnidadOrganizacionalArb($id,$id_padre,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$estado_reg)
	{
		$this->salida = "";
		$dbUnidadOrganizacional = new cls_DBUnidadOrganizacionalArb($this->decodificar);
		$res = $dbUnidadOrganizacional ->ValidarUnidadOrganizacionalArb($id,$id_padre,$nombre_unidad,$nombre_cargo,$centro,$cargo_individual,$descripcion,$id_nivel_organizacional,$estado_reg);
		$this->salida = $dbUnidadOrganizacional ->salida;
		$this->query = $dbUnidadOrganizacional ->query;
		return $res;
	}
	/// --------------------- fin tkp_unidad_organizacional_arb --------------------- ///

	/// --------------------- tkp_nivel_organizacional --------------------- ///

	function ListarNivelOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional ->ListarNivelOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	function ContarNivelOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional ->ContarNivelOrganizacional($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	function InsertarNivelOrganizacional($id_nivel_organizacional,$nombre_nivel,$numero_nivel)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional ->InsertarNivelOrganizacional($id_nivel_organizacional,$nombre_nivel,$numero_nivel);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	function ModificarNivelOrganizacional($id_nivel_organizacional,$nombre_nivel,$numero_nivel)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional ->ModificarNivelOrganizacional($id_nivel_organizacional,$nombre_nivel,$numero_nivel);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	function EliminarNivelOrganizacional($id_nivel_organizacional)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional -> EliminarNivelOrganizacional($id_nivel_organizacional);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	function ValidarNivelOrganizacional($operacion_sql,$id_nivel_organizacional,$nombre_nivel,$numero_nivel)
	{
		$this->salida = "";
		$dbNivelOrganizacional = new cls_DBNivelOrganizacional($this->decodificar);
		$res = $dbNivelOrganizacional ->ValidarNivelOrganizacional($operacion_sql,$id_nivel_organizacional,$nombre_nivel,$numero_nivel);
		$this->salida = $dbNivelOrganizacional ->salida;
		$this->query = $dbNivelOrganizacional ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_nivel_organizacional --------------------- ///
		/// --------------------- tkp_historico_asignacion --------------------- ///

	function ListarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion ->ListarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	function ContarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion ->ContarHistoricoAsignacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	function InsertarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion ->InsertarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	function ModificarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion ->ModificarHistoricoAsignacion($id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion,$id_empleado_suplente);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	function EliminarHistoricoAsignacion($id_historico_asignacion)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion -> EliminarHistoricoAsignacion($id_historico_asignacion);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	function ValidarHistoricoAsignacion($operacion_sql,$id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion)
	{
		$this->salida = "";
		$dbHistoricoAsignacion = new cls_DBHistoricoAsignacion($this->decodificar);
		$res = $dbHistoricoAsignacion ->ValidarHistoricoAsignacion($operacion_sql,$id_historico_asignacion,$fecha_asignacion,$estado,$id_unidad_organizacional,$id_empleado,$fecha_finalizacion);
		$this->salida = $dbHistoricoAsignacion ->salida;
		$this->query = $dbHistoricoAsignacion ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_historico_asignacion --------------------- ///
	
		/// --------------------- tkp_horario --------------------- ///

	function ListarHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario ->ListarHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	function ContarListaHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario ->ContarListaHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	function InsertarHorario($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario ->InsertarHorario($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	function ModificarHorario($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario ->ModificarHorario($id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente,$estado_reg);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	function EliminarHorario($id_horario)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario -> EliminarHorario($id_horario);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	function ValidarHorario($operacion_sql,$id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente)
	{
		$this->salida = "";
		$dbHorario = new cls_DBHorario($this->decodificar);
		$res = $dbHorario ->ValidarHorario($operacion_sql,$id_horario,$id_tipo_horario,$id_vacacion,$fecha_inicio,$fecha_fin,$numero_periodo,$horas_por_dia,$hora_ini_p1,$hora_fin_p1,$hora_ini_p2,$hora_fin_p2,$tipo_periodo,$observaciones,$repite_anualmente);
		$this->salida = $dbHorario ->salida;
		$this->query = $dbHorario ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_horario --------------------- ///
	
	/// --------------------- tkp_tipo_horario --------------------- ///

	function ListarTipoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario ->ListarTipoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	function ContarListaTipoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario ->ContarListaTipoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	function InsertarTipoHorario($id_tipo_horario,$codigo,$nombre)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario ->InsertarTipoHorario($id_tipo_horario,$codigo,$nombre);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	function ModificarTipoHorario($id_tipo_horario,$codigo,$nombre)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario ->ModificarTipoHorario($id_tipo_horario,$codigo,$nombre);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	function EliminarTipoHorario($id_tipo_horario)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario -> EliminarTipoHorario($id_tipo_horario);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	function ValidarTipoHorario($operacion_sql,$id_tipo_horario,$codigo,$nombre)
	{
		$this->salida = "";
		$dbTipoHorario = new cls_DBTipoHorario($this->decodificar);
		$res = $dbTipoHorario ->ValidarTipoHorario($operacion_sql,$id_tipo_horario,$codigo,$nombre);
		$this->salida = $dbTipoHorario ->salida;
		$this->query = $dbTipoHorario ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_tipo_horario --------------------- ///
	
	/*********************************Empleado Horario************************************/
	
	function ListarEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoHorario = new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario ->ListarEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario->query;
		return $res;
	}
	function ContarListaEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoHorario= new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario->ContarListaEmpleadoHorario($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario->query;
		return $res;
	}
	

	function InsertarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_horario,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoHorario = new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario ->InsertarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_horario,$estado_reg);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario ->query;
		return $res;
	}

	function ModificarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_horario,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoHorario = new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario ->ModificarEmpleadoHorario($id_empleado_horario,$id_empleado,$id_horario,$estado_reg);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario ->query;
		return $res;
	}

	function EliminarEmpleadoHorario($id_empleado_horario)
	{
		$this->salida = "";
		$dbEmpleadoHorario = new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario ->EliminarEmpleadoHorario($id_empleado_horario);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario ->query;
		return $res;
	}

	function ValidarEmpleadoHorario($operacion_sql,$id_empleado_horario,$id_empleado,$id_horario,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoHorario = new cls_DBEmpleadoHorario($this->decodificar);
		$res = $dbEmpleadoHorario ->ValidarEmpleadoHorario($operacion_sql,$id_empleado_horario,$id_empleado,$id_horario,$estado_reg);
		$this->salida = $dbEmpleadoHorario->salida;
		$this->query = $dbEmpleadoHorario ->query;
		return $res;
	}
	/*******************************Fin Empleado Horario************************************/
	/// --------------------- tkp_empleado_cta --------------------- ///
	function ListarEmpleadoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta ->ListarEmpleadoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}
	function ContarEmpleadoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta ->ContarEmpleadoCta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}
	function InsertarEmpleadoCta($id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta ->InsertarEmpleadoCta($id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}

	function ModificarEmpleadoCta($id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta ->ModificarEmpleadoCta($id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}

	function EliminarEmpleadoCta($id_empleado_cta)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta -> EliminarEmpleadoCta($id_empleado_cta);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}

	function ValidarEmpleadoCta($operacion_sql,$id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg)
	{
		$this->salida = "";
		$dbEmpleadoCta = new cls_DBEmpleadoCta($this->decodificar);
		$res = $dbEmpleadoCta ->ValidarEmpleadoCta($operacion_sql,$id_empleado_cta,$id_empleado,$id_gestion,$id_cuenta,$id_auxiliar,$estado_reg);
		$this->salida = $dbEmpleadoCta ->salida;
		$this->query = $dbEmpleadoCta ->query;
		return $res;
	}
	/// --------------------- fin tkp_empleado_cta --------------------- ///
	
	
	/********************************* EmpleadoTrabajo ************************************/
	
	function ListarEmpleadoTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo = new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo ->ListarEmpleadoTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo->query;
		return $res;
	}
	function ContarEmpleadoTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo= new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo->ContarEmpleadoTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo->query;
		return $res;
	}
	

	function InsertarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo = new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo ->InsertarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo ->query;
		return $res;
	}

	function ModificarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo = new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo ->ModificarEmpleadoTrabajo($id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$id_persona);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo ->query;
		return $res;
	}

	function EliminarEmpleadoTrabajo($id_empleado_trabajo)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo = new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo ->EliminarEmpleadoTrabajo($id_empleado_trabajo);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo ->query;
		return $res;
	}

	function ValidarEmpleadoTrabajo($operacion_sql,$id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado)
	{
		$this->salida = "";
		$dbEmpleadoTrabajo = new cls_DBEmpleadoTrabajo($this->decodificar);
		$res = $dbEmpleadoTrabajo ->ValidarEmpleadoTrabajo($operacion_sql,$id_empleado_trabajo,$descripcion,$id_institucion,$tipo_institucion,$cargo,$fecha_ini,$fecha_fin,$id_empleado);
		$this->salida = $dbEmpleadoTrabajo->salida;
		$this->query = $dbEmpleadoTrabajo ->query;
		return $res;
	}
	
	/********************************* Capacitacion ************************************/
	
	function ListarTipoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCapacitacion = new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion ->ListarTipoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion->query;
		return $res;
	}
	function ContarTipoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCapacitacion= new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion->ContarTipoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion->query;
		return $res;
	}
	

	function InsertarTipoCapacitacion($id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg)
	{
		$this->salida = "";
		$dbCapacitacion = new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion ->InsertarTipoCapacitacion($id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion ->query;
		return $res;
	}

	function ModificarTipoCapacitacion($id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg)
	{
		$this->salida = "";
		$dbCapacitacion = new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion ->ModificarTipoCapacitacion($id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion ->query;
		return $res;
	}

	function EliminarTipoCapacitacion($id_tipo_capacitacion)
	{
		$this->salida = "";
		$dbCapacitacion = new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion ->EliminarTipoCapacitacion($id_tipo_capacitacion);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion ->query;
		return $res;
	}

	function ValidarTipoCapacitacion($operacion_sql,$id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg)
	{
		$this->salida = "";
		$dbCapacitacion = new cls_DBTipoCapacitacion($this->decodificar);
		$res = $dbCapacitacion ->ValidarTipoCapacitacion($operacion_sql,$id_tipo_capacitacion,$nombre,$descripcion,$fecha_reg,$estado_reg);
		$this->salida = $dbCapacitacion->salida;
		$this->query = $dbCapacitacion ->query;
		return $res;
	}
	
	/***********************************Empleado Capacitacion************************************/
	
	function ListarEmpleadoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion = new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion ->ListarEmpleadoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion->query;
		return $res;
	}
	function ContarEmpleadoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion= new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion->ContarEmpleadoCapacitacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion->query;
		return $res;
	}
	

	function InsertarEmpleadoCapacitacion($id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$ano_graduacion,$id_persona)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion = new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion ->InsertarEmpleadoCapacitacion($id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$ano_graduacion,$id_persona);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion ->query;
		return $res;
	}

	function ModificarEmpleadoCapacitacion($id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$ano_graduacion,$id_persona)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion = new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion ->ModificarEmpleadoCapacitacion($id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado,$nombre_institucion,$direccion_institucion,$ano_graduacion,$id_persona);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion ->query;
		return $res;
	}

	function EliminarEmpleadoCapacitacion($id_empleado_capacitacion)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion = new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion ->EliminarEmpleadoCapacitacion($id_empleado_capacitacion);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion ->query;
		return $res;
	}

	function ValidarEmpleadoCapacitacion($operacion_sql,$id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado)
	{
		$this->salida = "";
		$dbEmpleadoCapacitacion = new cls_DBEmpleadoCapacitacion($this->decodificar);
		$res = $dbEmpleadoCapacitacion ->ValidarEmpleadoCapacitacion($operacion_sql,$id_empleado_capacitacion, $id_capacitacion,$descripcion,$id_institucion,$tipo_capacitacion,$financiado,$fecha_ini,$fecha_fin,$id_empleado);
		$this->salida = $dbEmpleadoCapacitacion->salida;
		$this->query = $dbEmpleadoCapacitacion ->query;
		return $res;
	}
		/*/// --------------------- tkp_parametro_cuenta_auxiliar --------------------- ///

	function ListarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar ->ListarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	function ContarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar ->ContarParametroCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	function InsertarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar ->InsertarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	function ModificarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar ->ModificarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	function EliminarParametroCuentaAuxiliar($id_parametro_cuenta_auxiliar)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar -> EliminarParametroCuentaAuxiliar($id_horario);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	function ValidarParametroCuentaAuxiliar($operacion_sql,$id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo)
	{
		$this->salida = "";
		$dbParametroCuentaAuxiliar = new cls_DBParametroCuentaAuxiliar($this->decodificar);
		$res = $dbParametroCuentaAuxiliar ->ValidarParametroCuentaAuxiliar($operacion_sql,$id_parametro_cuenta_auxiliar,$id_cuenta,$id_auxiliar,$id_gestion,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_columna_tipo,$id_orden_trabajo);
		$this->salida = $dbParametroCuentaAuxiliar ->salida;
		$this->query = $dbParametroCuentaAuxiliar ->query;
		return $res;
	}
	
	/// --------------------- fin tkp_parametro_cuenta_auxiliar --------------------- ///*/
	
}
?>