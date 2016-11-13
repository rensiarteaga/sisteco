<?php
/**
 * Nombre de la Clase:	    CustomDBsis_presupuesto
 * Propósito:				Interfaz del modelo del Sistema de sis_presupuesto
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2008-07-02 17:16:25
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBPresupuesto
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBNivelPartida.php");
		include_once("cls_DBParametro.php");
		include_once("cls_DBConceptoIngas.php");
		include_once("cls_DBCategoria.php");
		include_once("cls_DBDestino.php");
		include_once("cls_DBCobertura.php");
		include_once("cls_DBPartida.php");
		include_once("cls_DBMemInversionGasto.php");
		include_once("cls_DBMemRrhh.php");
		include_once("cls_DBMemServicio.php");
		include_once("cls_DBMemViaje.php");
		include_once("cls_DBMemoriaCalculo.php");
		include_once("cls_DBPartidaPresupuesto.php");
		include_once("cls_DBPresupuesto.php");
		
	}
	
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
	
	function InsertarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->InsertarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	function ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ModificarParametro($id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles);
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
	
	function ValidarParametro($operacion_sql,$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles)
	{
		$this->salida = "";
		$dbParametro = new cls_DBParametro($this->decodificar);
		$res = $dbParametro ->ValidarParametro($operacion_sql,$id_parametro,$gestion_pres,$estado_gral,$cod_institucional,$porcentaje_sobregiro,$cantidad_niveles);
		$this->salida = $dbParametro ->salida;
		$this->query = $dbParametro ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_parametro --------------------- ///
	
	/// --------------------- tpr_concepto_ingas --------------------- ///

	function ListarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ListarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function ContarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ContarConceptoIngas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function InsertarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->InsertarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function ModificarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ModificarConceptoIngas($id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function EliminarConceptoIngas($id_concepto_ingas)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas -> EliminarConceptoIngas($id_concepto_ingas);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	function ValidarConceptoIngas($operacion_sql,$id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida)
	{
		$this->salida = "";
		$dbConceptoIngas = new cls_DBConceptoIngas($this->decodificar);
		$res = $dbConceptoIngas ->ValidarConceptoIngas($operacion_sql,$id_concepto_ingas,$desc_ingas,$id_moneda,$id_partida);
		$this->salida = $dbConceptoIngas ->salida;
		$this->query = $dbConceptoIngas ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_concepto_ingas --------------------- ///
	
	function ListarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ListarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	function ContarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ContarNivelPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	function InsertarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->InsertarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	function ModificarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ModificarNivelPartida($id_nivel_partida,$nivel,$dig_nivel,$id_parametro);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	function EliminarNivelPartida($id_nivel_partida)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida -> EliminarNivelPartida($id_nivel_partida);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	function ValidarNivelPartida($operacion_sql,$id_nivel_partida,$nivel,$dig_nivel,$id_parametro)
	{
		$this->salida = "";
		$dbNivelPartida = new cls_DBNivelPartida($this->decodificar);
		$res = $dbNivelPartida ->ValidarNivelPartida($operacion_sql,$id_nivel_partida,$nivel,$dig_nivel,$id_parametro);
		$this->salida = $dbNivelPartida ->salida;
		$this->query = $dbNivelPartida ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_nivel_partida --------------------- ///

	
	/// --------------------- Inicio categoria --------------------- ///
	function ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ListarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	function ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ContarCategoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	function InsertarCategoria($id_categoria,$desc_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->InsertarCategoria($id_categoria,$desc_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	function ModificarCategoria($id_categoria,$desc_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ModificarCategoria($id_categoria,$desc_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	function EliminarCategoria($id_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria -> EliminarCategoria($id_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	function ValidarCategoria($operacion_sql,$id_categoria,$desc_categoria)
	{
		$this->salida = "";
		$dbCategoria = new cls_DBCategoria($this->decodificar);
		$res = $dbCategoria ->ValidarCategoria($operacion_sql,$id_categoria,$desc_categoria);
		$this->salida = $dbCategoria ->salida;
		$this->query = $dbCategoria ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_categoria --------------------- ///

	function ListarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ListarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	function ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ContarDestino($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	function InsertarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->InsertarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	function ModificarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ModificarDestino($id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	function EliminarDestino($id_destino)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino -> EliminarDestino($id_destino);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	function ValidarDestino($operacion_sql,$id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda)
	{
		$this->salida = "";
		$dbDestino = new cls_DBDestino($this->decodificar);
		$res = $dbDestino ->ValidarDestino($operacion_sql,$id_destino,$importe_pasaje,$importe_hotel,$importe_viaticos,$id_categoria,$id_lugar,$id_moneda);
		$this->salida = $dbDestino ->salida;
		$this->query = $dbDestino ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_destino --------------------- ///
	
	/// --------------------- tpr_partida --------------------- ///

	function ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ListarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	function ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ContarPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	function InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->InsertarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	function ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ModificarPartida($id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	function EliminarPartida($id_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida -> EliminarPartida($id_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	function ValidarPartida($operacion_sql,$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida)
	{
		$this->salida = "";
		$dbPartida = new cls_DBPartida($this->decodificar);
		$res = $dbPartida ->ValidarPartida($operacion_sql,$id_partida,$codigo_partida,$nombre_partida,$nivel_partida,$sw_transaccional,$tipo_partida,$id_parametro,$id_partida_padre,$tipo_memoria,$desc_partida);
		$this->salida = $dbPartida ->salida;
		$this->query = $dbPartida ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_partida --------------------- ///
	
	


/// --------------------- tpr_mem_inversion_gasto --------------------- ///

	function ListarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ListarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ContarMemoriaGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function InsertarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->InsertarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function ModificarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ModificarMemoriaGasto($id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function EliminarMemoriaGasto($id_mem_inversion_gasto)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto -> EliminarMemoriaGasto($id_mem_inversion_gasto);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	function ValidarMemoriaGasto($operacion_sql,$id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemInversionGasto = new cls_DBMemInversionGasto($this->decodificar);
		$res = $dbMemInversionGasto ->ValidarMemoriaGasto($operacion_sql,$id_mem_inversion_gasto,$cantidad,$costo_unitario,$periodo_pres,$tipo_mem,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemInversionGasto ->salida;
		$this->query = $dbMemInversionGasto ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_mem_inversion_gasto --------------------- ///
	
	/// --------------------- tpr_mem_rrhh --------------------- ///

	function ListarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ListarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	function ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ContarRrhhGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	function InsertarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->InsertarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	function ModificarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ModificarRrhhGasto($id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	function EliminarRrhhGasto($id_mem_rrhh)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh -> EliminarRrhhGasto($id_mem_rrhh);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	function ValidarRrhhGasto($operacion_sql,$id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemRrhh = new cls_DBMemRrhh($this->decodificar);
		$res = $dbMemRrhh ->ValidarRrhhGasto($operacion_sql,$id_mem_rrhh,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemRrhh ->salida;
		$this->query = $dbMemRrhh ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_mem_rrhh --------------------- ///
	
	/// --------------------- tpr_mem_servicio --------------------- ///

	function ListarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ListarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function ContarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ContarServicioGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function InsertarServicioGasto($id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->InsertarServicioGasto($id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function ModificarServicioGasto($id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ModificarServicioGasto($id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function EliminarServicioGasto($id_mem_servicio)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio -> EliminarServicioGasto($id_mem_servicio);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	function ValidarServicioGasto($operacion_sql,$id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda)
	{
		$this->salida = "";
		$dbMemServicio = new cls_DBMemServicio($this->decodificar);
		$res = $dbMemServicio ->ValidarServicioGasto($operacion_sql,$id_mem_servicio,$costo_mensual,$periodo_pres,$id_memoria_calculo,$id_moneda);
		$this->salida = $dbMemServicio ->salida;
		$this->query = $dbMemServicio ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_mem_servicio --------------------- ///
		/// --------------------- tpr_mem_viaje --------------------- ///

	function ListarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ListarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	function ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ContarViajeGasto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	function InsertarViajeGasto($id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->InsertarViajeGasto($id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	function ModificarViajeGasto($id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ModificarViajeGasto($id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	function EliminarViajeGasto($id_mem_viaje)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje -> EliminarViajeGasto($id_mem_viaje);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	function ValidarViajeGasto($operacion_sql,$id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo)
	{
		$this->salida = "";
		$dbMemViaje = new cls_DBMemViaje($this->decodificar);
		$res = $dbMemViaje ->ValidarViajeGasto($operacion_sql,$id_mem_viaje,$id_destino,$id_cobertura,$nro_dias,$importe_viaticos,$total_viaticos,$importe_hotel,$total_hotel,$importe_pasajes,$importe_otros,$total_general,$id_moneda,$periodo_pres,$id_memoria_calculo);
		$this->salida = $dbMemViaje ->salida;
		$this->query = $dbMemViaje ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_mem_viaje --------------------- ///
	
	/// --------------------- tpr_memoria_calculo --------------------- ///

	function ListarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ListarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function ContarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ContarMemoriaCalculo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function InsertarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->InsertarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function ModificarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ModificarMemoriaCalculo($id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function EliminarMemoriaCalculo($id_memoria_calculo)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo -> EliminarMemoriaCalculo($id_memoria_calculo);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	function ValidarMemoriaCalculo($operacion_sql,$id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbMemoriaCalculo = new cls_DBMemoriaCalculo($this->decodificar);
		$res = $dbMemoriaCalculo ->ValidarMemoriaCalculo($operacion_sql,$id_memoria_calculo,$id_concepto_ingas,$justificacion,$tipo_detalle,$id_partida_presupuesto);
		$this->salida = $dbMemoriaCalculo ->salida;
		$this->query = $dbMemoriaCalculo ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_memoria_calculo --------------------- ///
	
	/// --------------------- tpr_partida_presupuesto --------------------- ///

	function ListarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ListarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	function ContarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ContarDetalleParidaFormulacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	function InsertarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->InsertarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	function ModificarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ModificarDetalleParidaFormulacion($id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	function EliminarDetalleParidaFormulacion($id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto -> EliminarDetalleParidaFormulacion($id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	function ValidarDetalleParidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto)
	{
		$this->salida = "";
		$dbPartidaPresupuesto = new cls_DBPartidaPresupuesto($this->decodificar);
		$res = $dbPartidaPresupuesto ->ValidarDetalleParidaFormulacion($operacion_sql,$id_partida_presupuesto,$codigo_formulario,$fecha_elaboracion,$id_partida,$id_presupuesto,$id_partida_detalle,$mes_01,$mes_02,$mes_03,$mes_04,$mes_05,$mes_06,$mes_07,$mes_08,$mes_09,$mes_10,$mes_11,$mes_12,$id_partida_presupuesto);
		$this->salida = $dbPartidaPresupuesto ->salida;
		$this->query = $dbPartidaPresupuesto ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_partida_presupuesto --------------------- ///
	
	/// --------------------- tpr_presupuesto --------------------- ///

	function ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ListarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ContarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ContarFormulacionPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function InsertarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->InsertarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ModificarFormulacionPresupuesto($id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function EliminarFormulacionPresupuesto($id_presupuesto)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto -> EliminarFormulacionPresupuesto($id_presupuesto);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	function ValidarFormulacionPresupuesto($operacion_sql,$id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres)
	{
		$this->salida = "";
		$dbPresupuesto = new cls_DBPresupuesto($this->decodificar);
		$res = $dbPresupuesto ->ValidarFormulacionPresupuesto($operacion_sql,$id_presupuesto,$tipo_pres,$estado_pres,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_unidad_organizacional,$id_fuente_financiamiento,$id_parametro,$estado_pres,$gestion_pres);
		$this->salida = $dbPresupuesto ->salida;
		$this->query = $dbPresupuesto ->query;
		return $res;
	}
	
	/// --------------------- fin tpr_presupuesto --------------------- ///
	
	
}