<?php
/**
 * Nombre de la Clase:	    CustomDBContabilidad
 * Propósito:				Interfaz del modelo del Sistema de Contabilidad
 * todos los metodos existentes pasan por aqui
 * Fecha de Creación:		02-10-2007
 * Autor:					Josè A. Mita Huanca
 *
 */
class cls_CustomDBcontabilidad
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBCuenta.php");
		include_once("cls_DBCuentaArb.php");
		include_once("cls_DBNivelCuenta.php");
		include_once("cls_DBParametro.php");
    	include_once("cls_DBAuxiliar.php");
        include_once("cls_DBCuentaAuxiliar.php");
        include_once("cls_DBOrdenTrabajo.php");
        include_once("cls_DBDocumento.php");
		include_once("cls_DBTransaccion.php");
		include_once("cls_DBComprobante.php");
		include_once("cls_DBCbteClase.php");
		include_once("cls_DBPeriodoSubsistema.php");
		include_once("cls_DBPeriodo.php");
		include_once("cls_DBGestionSubsistema.php");
		include_once("cls_DBGestion.php");
		include_once("cls_DBReporteEeff.php");
		include_once("cls_DBRubro.php");
		include_once("cls_DBRubroCuenta.php");
		include_once("cls_DBCuentaEjercicio.php");
	 

	include_once("cls_DBUsuarioAutorizado.php");
	include_once("cls_DBPlantillaCalculo.php");
	include_once("cls_DBPlantilla.php");
	}
	
	/// --------------------- tct_plantilla --------------------- ///

	function ListarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ListarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ContarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ContarPlantilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function InsertarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->InsertarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ModificarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ModificarPlantilla($id_plantilla,$tipo_plantilla,$nro_linea);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function EliminarPlantilla($id_plantilla)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla -> EliminarPlantilla($id_plantilla);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	function ValidarPlantilla($operacion_sql,$id_plantilla,$tipo_plantilla,$nro_linea)
	{
		$this->salida = "";
		$dbPlantilla = new cls_DBPlantilla($this->decodificar);
		$res = $dbPlantilla ->ValidarPlantilla($operacion_sql,$id_plantilla,$tipo_plantilla,$nro_linea);
		$this->salida = $dbPlantilla ->salida;
		$this->query = $dbPlantilla ->query;
		return $res;
	}
	
	/// --------------------- fin tct_plantilla --------------------- ///

	
	/// --------------------- tct_plantilla_calculo --------------------- ///

	function ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ListarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ContarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ContarPlantillaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function InsertarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->InsertarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ModificarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ModificarPlantillaCalculo($id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function EliminarPlantillaCalculo($id_plantilla_calculo)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo -> EliminarPlantillaCalculo($id_plantilla_calculo);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	function ValidarPlantillaCalculo($operacion_sql,$id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo)
	{
		$this->salida = "";
		$dbPlantillaCalculo = new cls_DBPlantillaCalculo($this->decodificar);
		$res = $dbPlantillaCalculo ->ValidarPlantillaCalculo($operacion_sql,$id_plantilla_calculo,$id_plantilla,$tipo_cuenta,$id_ejercicio,$debe_haber,$porcen_calculo);
		$this->salida = $dbPlantillaCalculo ->salida;
		$this->query = $dbPlantillaCalculo ->query;
		return $res;
	}
	
	/// --------------------- fin tct_plantilla_calculo --------------------- ///
	
	/// --------------------- tct_usuario_autorizado --------------------- ///

	function ListarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ListarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ContarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ContarAutorizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function InsertarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->InsertarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ModificarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ModificarAutorizacion($id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function EliminarAutorizacion($id_usuario_autorizado)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado -> EliminarAutorizacion($id_usuario_autorizado);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	function ValidarAutorizacion($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional)
	{
		$this->salida = "";
		$dbUsuarioAutorizado = new cls_DBUsuarioAutorizado($this->decodificar);
		$res = $dbUsuarioAutorizado ->ValidarAutorizacion($operacion_sql,$id_usuario_autorizado,$id_usuario,$id_unidad_organizacional);
		$this->salida = $dbUsuarioAutorizado ->salida;
		$this->query = $dbUsuarioAutorizado ->query;
		return $res;
	}
	
	/// --------------------- fin tct_usuario_autorizado --------------------- ///	

 
	
	/// --------------------- tct_cuenta_ejercicio --------------------- ///

	function ListarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ListarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ContarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ContarCuentaEjecricio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function InsertarCuentaEjecricio($id_ejercicio,$id_cuenta,$tipo_ejercicio)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->InsertarCuentaEjecricio($id_ejercicio,$id_cuenta,$tipo_ejercicio);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ModificarCuentaEjecricio($id_ejercicio,$id_cuenta,$tipo_ejercicio)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ModificarCuentaEjecricio($id_ejercicio,$id_cuenta,$tipo_ejercicio);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function EliminarCuentaEjecricio($id_ejercicio)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio -> EliminarCuentaEjecricio($id_ejercicio);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	function ValidarCuentaEjecricio($operacion_sql,$id_ejercicio,$id_cuenta,$tipo_ejercicio)
	{
		$this->salida = "";
		$dbCuentaEjercicio = new cls_DBCuentaEjercicio($this->decodificar);
		$res = $dbCuentaEjercicio ->ValidarCuentaEjecricio($operacion_sql,$id_ejercicio,$id_cuenta,$tipo_ejercicio);
		$this->salida = $dbCuentaEjercicio ->salida;
		$this->query = $dbCuentaEjercicio ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cuenta_ejercicio --------------------- ///

 
		

	 	
	/// --------------------- tct_parametro --------------------- ///

	function ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ListarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ContarParametro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->InsertarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ModificarParametro($id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function EliminarParametro($id_parametro)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro -> EliminarParametro($id_parametro);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ValidarParametro($operacion_sql,$id_parametro,$id_gestion,$cantidad_nivel,$estado_gestion,$gestion_conta,$porcen_iva,$porcen_it,$porcen_servicio,$porcen_bien,$porcen_remesa);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	/// --------------------- fin tct_parametro --------------------- ///	
	/// --------------------- tct_nivel_cuenta --------------------- ///

	function ListarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ListarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ContarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ContarNivelCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function InsertarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->InsertarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ModificarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ModificarNivelCuenta($id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function EliminarNivelCuenta($id_nivel_cuenta)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta -> EliminarNivelCuenta($id_nivel_cuenta);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	function ValidarNivelCuenta($operacion_sql,$id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel)
	{
		$this->salida = "";
		$dbNivelCuenta = new cls_DBNivelCuenta($this->decodificar);
		$res = $dbNivelCuenta ->ValidarNivelCuenta($operacion_sql,$id_nivel_cuenta,$id_parametro,$nivel,$dig_nivel);
		$this->salida = $dbNivelCuenta ->salida;
		$this->query = $dbNivelCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_nivel_cuenta --------------------- ///


	
	/// --------------------- tct_rubro_cuenta --------------------- ///

	function ListarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ListarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ContarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ContarRubroCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function InsertarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->InsertarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ModificarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ModificarRubroCuenta($id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function EliminarRubroCuenta($id_rubro_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta -> EliminarRubroCuenta($id_rubro_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	function ValidarRubroCuenta($operacion_sql,$id_rubro_cuenta,$id_rubro,$id_cuenta)
	{
		$this->salida = "";
		$dbRubroCuenta = new cls_DBRubroCuenta($this->decodificar);
		$res = $dbRubroCuenta ->ValidarRubroCuenta($operacion_sql,$id_rubro_cuenta,$id_rubro,$id_cuenta);
		$this->salida = $dbRubroCuenta ->salida;
		$this->query = $dbRubroCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_rubro_cuenta --------------------- ///
	
	/// --------------------- tct_rubro --------------------- ///

	function ListarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ListarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ContarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ContarRubro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function InsertarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->InsertarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ModificarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ModificarRubro($id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function EliminarRubro($id_rubro)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro -> EliminarRubro($id_rubro);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	function ValidarRubro($operacion_sql,$id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber)
	{
		$this->salida = "";
		$dbRubro = new cls_DBRubro($this->decodificar);
		$res = $dbRubro ->ValidarRubro($operacion_sql,$id_rubro,$nombre_rubro,$id_reporte_eeff,$fk_rubro,$sw_debe_haber);
		$this->salida = $dbRubro ->salida;
		$this->query = $dbRubro ->query;
		return $res;
	}
	
	/// --------------------- fin tct_rubro --------------------- ///
	
	/// --------------------- tct_reporte_eeff --------------------- ///

	function ListarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ListarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ContarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ContarEeff($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function InsertarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->InsertarEeff($id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ModificarEeff($id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ModificarEeff($id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function EliminarEeff($id_reporte_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff -> EliminarEeff($id_reporte_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	function ValidarEeff($operacion_sql,$id_reporte_eeff,$nombre_eeff)
	{
		$this->salida = "";
		$dbReporteEeff = new cls_DBReporteEeff($this->decodificar);
		$res = $dbReporteEeff ->ValidarEeff($operacion_sql,$id_reporte_eeff,$nombre_eeff);
		$this->salida = $dbReporteEeff ->salida;
		$this->query = $dbReporteEeff ->query;
		return $res;
	}
	
	/// --------------------- fin tct_reporte_eeff --------------------- ///


/// --------------------- tct_periodo_subsistema --------------------- ///

	function ListarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ListarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ContarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ContarPeriodoSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function InsertarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->InsertarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ModificarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ModificarPeriodoSubsistema($id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function EliminarPeriodoSubsistema($id_periodo_subsistema)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema -> EliminarPeriodoSubsistema($id_periodo_subsistema);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	function ValidarPeriodoSubsistema($operacion_sql,$id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo)
	{
		$this->salida = "";
		$dbPeriodoSubsistema = new cls_DBPeriodoSubsistema($this->decodificar);
		$res = $dbPeriodoSubsistema ->ValidarPeriodoSubsistema($operacion_sql,$id_periodo_subsistema,$id_periodo,$id_subsistema,$estado_periodo);
		$this->salida = $dbPeriodoSubsistema ->salida;
		$this->query = $dbPeriodoSubsistema ->query;
		return $res;
	}
	
	/// --------------------- fin tct_periodo_subsistema --------------------- ///
/// --------------------- tct_periodo --------------------- ///

	function ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ListarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ContarPeriodo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function InsertarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->InsertarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ModificarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ModificarPeriodo($id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function EliminarPeriodo($id_periodo)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo -> EliminarPeriodo($id_periodo);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	function ValidarPeriodo($operacion_sql,$id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral)
	{
		$this->salida = "";
		$dbPeriodo = new cls_DBPeriodo($this->decodificar);
		$res = $dbPeriodo ->ValidarPeriodo($operacion_sql,$id_periodo,$id_gestion,$periodo,$fecha_inicio,$fecha_final,$estado_peri_gral);
		$this->salida = $dbPeriodo ->salida;
		$this->query = $dbPeriodo ->query;
		return $res;
	}
	
	/// --------------------- fin tct_periodo --------------------- ///

/// --------------------- tct_gestion_subsistema --------------------- ///

	function ListarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ListarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ContarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ContarGestionSubsistema($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function InsertarGestionSubsistema($id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->InsertarGestionSubsistema($id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ModificarGestionSubsistema($id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ModificarGestionSubsistema($id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function EliminarGestionSubsistema($id_gestion_subsistema)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema -> EliminarGestionSubsistema($id_gestion_subsistema);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	function ValidarGestionSubsistema($operacion_sql,$id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion)
	{
		$this->salida = "";
		$dbGestionSubsistema = new cls_DBGestionSubsistema($this->decodificar);
		$res = $dbGestionSubsistema ->ValidarGestionSubsistema($operacion_sql,$id_gestion_subsistema,$id_gestion,$id_subsistema,$estado_gestion);
		$this->salida = $dbGestionSubsistema ->salida;
		$this->query = $dbGestionSubsistema ->query;
		return $res;
	}
	
	/// --------------------- fin tct_gestion_subsistema --------------------- ///

/// --------------------- tct_gestion --------------------- ///

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
	
	/// --------------------- fin tct_gestion --------------------- ///
 
 
	
	/// --------------------- tct_cbte_clase --------------------- ///

	function ListarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ListarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ContarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ContarCbteClase($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function InsertarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->InsertarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ModificarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ModificarCbteClase($id_clase_cbte,$desc_clase,$estado_clase,$id_documento);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function EliminarCbteClase($id_clase_cbte)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase -> EliminarCbteClase($id_clase_cbte);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	function ValidarCbteClase($operacion_sql,$id_clase_cbte,$desc_clase,$estado_clase,$id_documento)
	{
		$this->salida = "";
		$dbCbteClase = new cls_DBCbteClase($this->decodificar);
		$res = $dbCbteClase ->ValidarCbteClase($operacion_sql,$id_clase_cbte,$desc_clase,$estado_clase,$id_documento);
		$this->salida = $dbCbteClase ->salida;
		$this->query = $dbCbteClase ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cbte_clase --------------------- ///
	 
	/// --------------------- tct_transaccion --------------------- ///

	function ListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ListarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ContarRegistroTransacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function InsertarRegistroTransacion($id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->InsertarRegistroTransacion($id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ModificarRegistroTransacion($id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ModificarRegistroTransacion($id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function EliminarRegistroTransacion($id_transaccion)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion -> EliminarRegistroTransacion($id_transaccion);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	function ValidarRegistroTransacion($operacion_sql,$id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTransaccion = new cls_DBTransaccion($this->decodificar);
		$res = $dbTransaccion ->ValidarRegistroTransacion($operacion_sql,$id_transaccion,$id_comprobante,$id_fuente_financiamiento,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$id_cuenta,$id_partida,$id_auxiliar,$id_orden_trabajo,$id_oec,$concepto_tran,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTransaccion ->salida;
		$this->query = $dbTransaccion ->query;
		return $res;
	}
	
	/// --------------------- fin tct_transaccion --------------------- ///

	
	/// --------------------- tct_comprobante --------------------- ///

	function ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ListarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ContarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ContarRegistroComprobante($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function InsertarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->InsertarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ModificarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ModificarRegistroComprobante($id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function EliminarRegistroComprobante($id_comprobante)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante -> EliminarRegistroComprobante($id_comprobante);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	function ValidarRegistroComprobante($operacion_sql,$id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte)
	{
		$this->salida = "";
		$dbComprobante = new cls_DBComprobante($this->decodificar);
		$res = $dbComprobante ->ValidarRegistroComprobante($operacion_sql,$id_comprobante,$id_parametro,$nro_cbte, $momento_cbte,$fecha_cbte,$concepto_cbte,$glosa_cbte,$acreedor,$aprobacion,$conformidad,$pedido,$id_periodo_subsis,$id_moneda_reg,$id_usuario,$id_subsistema,$id_clase_cbte);
		$this->salida = $dbComprobante ->salida;
		$this->query = $dbComprobante ->query;
		return $res;
	}
	
	/// --------------------- fin tct_comprobante --------------------- ///
	
	
	/// --------------------- tct_documento --------------------- ///

	function ListarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ListarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ContarRegistroDocumento($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->InsertarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ModificarRegistroDocumento($id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function EliminarRegistroDocumento($id_documento)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento -> EliminarRegistroDocumento($id_documento);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ValidarRegistroDocumento($operacion_sql,$id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ValidarRegistroDocumento($operacion_sql,$id_documento,$id_transaccion,$tipo_documento,$nro_documento,$fecha_documento,$razon_social,$nro_nit,$nro_autorizacion,$codigo_control,$poliza_dui,$formulario,$tipo_retencion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	/// --------------------- fin tct_documento --------------------- ///
	
	
	/// --------------------- tct_cuenta --------------------- ///

	function ListarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuenta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ListarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuenField($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	
	function ListarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ListarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ContarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ContarCuentaEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function InsertarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->InsertarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ModificarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ModificarCuenta($id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function EliminarCuenta($id_cuenta)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta -> EliminarCuenta($id_cuenta);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	function ValidarCuenta($operacion_sql,$id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuenta = new cls_DBCuenta($this->decodificar);
		$res = $dbCuenta ->ValidarCuenta($operacion_sql,$id_cuenta,$nro_cuenta,$descripcion,$fecha_registro,$hora_registro,$fecha_ultima_modificacion,$hora_ultima_modificacion,$id_cuenta_padre);
		$this->salida = $dbCuenta ->salida;
		$this->query = $dbCuenta ->query;
		return $res;
	}
	
	/// --------------------- fin tct_cuenta --------------------- ///
   /// --------------------- tct_cuenta_arb --------------------- ///
   function ListarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ListarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$agrupador);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ListarCuentaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ListarCuentaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ContarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ContarCuentaArb($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function InsertarCuentaRaiz($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->InsertarCuentaRaiz($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function InsertarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->InsertarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function ModificarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->ModificarCuentaArb($id_cuenta,$nro_cuenta,$nombre_cuenta,$desc_cuenta,$nivel_cuenta,$tipo_cuenta,$sw_transaccional,$id_cuenta_padre,$id_parametro,$id_moneda);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	function EliminarCuentaArb($id_cuenta,$id_cuenta_padre)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->EliminarCuentaArb($id_cuenta,$id_cuenta_padre);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}				
	function EliminarCuentaRaiz($id_cuenta)
	{
		$this->salida = "";
		$dbCuentaArb = new cls_DBCuentaArb($this->decodificar);
		$res = $dbCuentaArb ->EliminarCuentaRaiz($id_cuenta);
		$this->salida = $dbCuentaArb ->salida;
		$this->query = $dbCuentaArb ->query;
		return $res;
	}
	/// --------------------- fin tct_cuenta_arb --------------------- ///
	
		/// --------------------- tct_auxiliar --------------------- ///

	function ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ListarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	function ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ContarAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}	
	function InsertarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->InsertarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function ModificarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ModificarAuxiliar($id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function EliminarAuxiliar($id_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar -> EliminarAuxiliar($id_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}
	
	function ValidarAuxiliar($operacion_sql,$id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar)
	{
		$this->salida = "";
		$dbAuxiliar = new cls_DBAuxiliar($this->decodificar);
		$res = $dbAuxiliar ->ValidarAuxiliar($operacion_sql,$id_auxiliar,$codigo_auxiliar,$nombre_auxiliar,$estado_auxiliar);
		$this->salida = $dbAuxiliar ->salida;
		$this->query = $dbAuxiliar ->query;
		return $res;
	}	
	/// --------------------- fin tct_auxiliar --------------------- ///
		/// --------------------- tct_cuenta_auxiliar --------------------- ///

	function ListarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ListarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	function ContarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ContarCuentaAuxiliar($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}	
	function InsertarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->InsertarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function ModificarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ModificarCuentaAuxiliar($id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function EliminarCuentaAuxiliar($id_cuenta_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar -> EliminarCuentaAuxiliar($id_cuenta_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}
	
	function ValidarCuentaAuxiliar($operacion_sql,$id_cuenta_auxiliar,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbCuentaAuxiliar = new cls_DBCuentaAuxiliar($this->decodificar);
		$res = $dbCuentaAuxiliar ->ValidarCuentaAuxiliar($operacion_sql,$id_cuenta_auxiliar,$id_cuenta,$id_auxiliar);
		$this->salida = $dbCuentaAuxiliar ->salida;
		$this->query = $dbCuentaAuxiliar ->query;
		return $res;
	}	
	/// --------------------- fin tct_auxiliar --------------------- ///	
	
	/// --------------------- tct_orden_trabajo --------------------- ///

	function ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ListarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ContarOrdenTrabajo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->InsertarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ModificarOrdenTrabajo($id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function EliminarOrdenTrabajo($id_orden_trabajo)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo -> EliminarOrdenTrabajo($id_orden_trabajo);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
	function ValidarOrdenTrabajo($operacion_sql,$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario)
	{
		$this->salida = "";
		$dbOrdenTrabajo = new cls_DBOrdenTrabajo($this->decodificar);
		$res = $dbOrdenTrabajo ->ValidarOrdenTrabajo($operacion_sql,$id_orden_trabajo,$desc_orden,$motivo_orden,$fecha_inicio,$fecha_final,$estado_orden,$id_usuario);
		$this->salida = $dbOrdenTrabajo ->salida;
		$this->query = $dbOrdenTrabajo ->query;
		return $res;
	}
	
}