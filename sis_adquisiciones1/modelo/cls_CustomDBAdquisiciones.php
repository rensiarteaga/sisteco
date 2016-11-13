<?php
/**
 * Nombre de la Clase:	    CustomDBadquisiciones
 * Prop�sito:				Interfaz del modelo del Sistema de adquisiciones
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creaci�n:		2007-10-17 10:31:03
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBAdquisiciones
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBProveedor.php");
		include_once("cls_DBItemProveedor.php");
		include_once("cls_DBParametroAdquisicion.php");
		include_once("cls_DBCategoriaAdq.php");
		include_once("cls_DBTipoCategoriaAdq.php");
		include_once("cls_DBEstadoCompra.php");
		include_once("cls_DBEstadoCompraCategoriaAdq.php");
		include_once("cls_DBServicioProveedor.php");
		include_once("cls_DBTipoAdq.php");
		include_once("cls_DBTipoServicio.php");
		include_once("cls_DBServicioPropuesto.php");
		include_once("cls_DBItemPropuesto.php");
		include_once("cls_DBCorrelativo.php");
		include_once("cls_DBRpa.php");
		include_once("cls_DBCaracteristica.php");
		include_once("cls_DBDocumento.php");
        include_once("cls_DBServicio.php");
		include_once("cls_DBProveedorCuentaAuxiliar.php");
       // include_once("cls_DBRepPlanilla.php");
	    /*Procesos*/
		include_once("cls_DBSolicitudCompra.php");
		include_once("cls_DBSolicitudCompraDet.php");
		include_once("cls_DBProcesoCompra.php");
		include_once("cls_DBProcesoCompraDet.php");
		include_once("cls_DBSolicitudProcesoCompra.php");
		include_once("cls_DBEstadoProceso.php");
		include_once("cls_DBCotizacion.php");
		include_once("cls_DBCotizacionDet.php");
		include_once("cls_DBPlanPago.php");
		include_once("cls_DBGrupoSpDet.php");
		
		
		/*Adjudicacion*/
		include_once("cls_DBAdjudicacion.php");
		include_once("cls_DBComprador.php");
		include_once("cls_DBTipoServicioCuentaPartida.php");
		
		include_once("cls_DBDetallePropuesta.php");
		include_once("cls_DBCuadroComparativo.php");
		include_once("cls_DBReporteUOSol.php");
		include_once("cls_DBRepSolicitudesTiemposEstados.php");
		include_once("cls_DBPlanilla.php");
		include_once("cls_DBProveedorCuentaBancaria.php");
		include_once("cls_DBPartidaVobo.php");
		include_once("cls_DBPrestacionServicios.php");
		include_once("cls_DBDetalleEjecucion.php");
		include_once("cls_DBRepSolicitudCompra.php");
		
	}
	
	/// --------------------- tad_proveedor --------------------- ///

	function ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ListarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ContarProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
		
function InsertarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion){
    				$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->InsertarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;			
    						}

	function ModificarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion){
    				$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ModificarProveedor($id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona,$nombre_pago,
							$usuario,$contrasena,$confirmado,$id_cuenta,$id_auxiliar,$nombre_pago,$direccion_proveedor,$telefono1_proveedor,$telefono2_proveedor,
							$mail_proveedor,$fax_proveedor,$casilla_proveedor,$celular1_proveedor,$celular2_proveedor,$email2_proveedor,$pag_web_proveedor,
    						$nombre_contacto,$direccion_contacto,$telefono_contacto,$email_contacto,$tipo_contacto,$id_contacto,$con_contacto,$id_depto,
    						$rubro,$rubro1,$rubro2,$tipo,$paterno,$materno,$nombre,$id_rubro,$id_documento,$doc_id,$nombre_institucion);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;			
    						}
	
	function EliminarProveedor($id_proveedor)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor -> EliminarProveedor($id_proveedor);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ValidarProveedor($operacion_sql,$id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ValidarProveedor($operacion_sql,$id_proveedor,$codigo,$observaciones,$fecha_reg,$id_institucion,$id_persona);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
//		function InsertarNuevoProveedor($codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c,$tipo_proveedor,$con_contacto,$id_cuenta,$id_auxiliar,$direccion_ins,$direccion_p,$direccion_c,$id_depto,$rubro,$rubro1,$rubro2)
//	{
//		$this->salida = "";
//		$dbProveedor = new cls_DBProveedor($this->decodificar);
//		$res = $dbProveedor ->InsertarNuevoProveedor($codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c,$tipo_proveedor,$con_contacto,$id_cuenta,$id_auxiliar,$direccion_ins,$direccion_p,$direccion_c,$id_depto,$rubro,$rubro1,$rubro2);
//		$this->salida = $dbProveedor ->salida;
//		$this->query = $dbProveedor ->query;
//		return $res;
//	} 
	
	/**/
	
	function InsertarNuevoProveedor($tipo_proveedor,$id_depto,	$id_rubro,$nombre_ins,$direccion_ins,$id_tipo_doc_institucion,
	$doc_id,$con_contacto,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$rubro1,$rubro2,$tipo,$apellido_paterno,
	$apellido_materno,$nombre_p,$id_tipo_doc_identificacion,$doc_id_p,$direccion_p,$apellido_paterno_c,$apellido_materno_c,$nombre_c,
	$telefono1_c,$celular1_c,$email1_c,$tipo_contacto,$direccion_c
	,$nombre_pago,$codigo
	)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->InsertarNuevoProveedor(
		$tipo_proveedor,$id_depto,	$id_rubro,$nombre_ins,$direccion_ins,$id_tipo_doc_institucion,
	$doc_id,$con_contacto,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$rubro1,$rubro2,$tipo,$apellido_paterno,
	$apellido_materno,$nombre_p,$id_tipo_doc_identificacion,$doc_id_p,$direccion_p,$apellido_paterno_c,$apellido_materno_c,$nombre_c,
	$telefono1_c,$celular1_c,$email1_c,$tipo_contacto,$direccion_c
	,$nombre_pago,$codigo
	);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	/**/
	
	function ValidarNuevoProveedor($operacion_sql,$codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ValidarNuevoProveedor($operacion_sql,$codigo,$observaciones,$nombre_pago,$doc_id,$nombre,$casilla,$telefono1,$telefono2,$celular1,$celular2,$fax,$email1,$email2,$pag_web,$id_tipo_doc_institucion,$apellido_paterno,$apellido_materno,$nombre_p,$doc_id_p,$casilla_p,$telefono1_p,$telefono2_p,$celular1_p,$celular2_p,$pag_web_p,$email1_p,$email2_p,$id_tipo_doc_identificacion,$tipo_contacto,$apellido_paterno_c,$apellido_materno_c,$nombre_c,$telefono1_c,$celular1_c,$celular2_c,$email1_c,$email2_c);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	
	function ModificarProveedorCuenta($id_proveedor,$id_cuenta,$id_auxiliar)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ModificarProveedorCuenta($id_proveedor,$id_cuenta,$id_auxiliar);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	//-----------------------------------02Jun10---------------------------------------FER Proveedores
	function ListarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ListarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ContarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ContarRubros($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	/// --------------------- fin tad_proveedor --------------------- ///
	
	
	/// --------------------- tad_proveedor_cuenta_bancaria --------------------- ///

	function ListarProveedorCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedorCuentaBancaria = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaBancaria ->ListarProveedorCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	function ContarProveedorCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedorCuentaBancaria = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaBancaria ->ContarProveedorCuentaBancaria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	function InsertarProveedorCuentaBancaria($id_proveedor,$id_institucion,$nro_cuenta,$estado_reg)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->InsertarProveedorCuentaBancaria($id_proveedor,$id_institucion,$nro_cuenta,$estado_reg);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	function ModificarProveedorCuentaBancaria($id_proveedor_cuenta_bancaria,$id_proveedor,$id_institucion,$nro_cuenta,$estado_reg)
	{
		$this->salida = "";
		$dbProveedorCuentaBancaria = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaBancaria ->ModificarProveedorCuentaBancaria($id_proveedor_cuenta_bancaria,$id_proveedor,$id_institucion,$nro_cuenta,$estado_reg);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	function EliminarProveedorCuentaBancaria($id_proveedor_cuenta_bancaria)
	{
		$this->salida = "";
		$dbProveedorCuentaBancaria = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaBancaria -> EliminarProveedorCuentaBancaria($id_proveedor_cuenta_bancaria);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	function ValidarProveedorCuentaBancaria($operacion_sql,$id_proveedor_cuenta_bancaria,$id_proveedor,$id_institucion,$nro_cuenta,$estado_reg)
	{
		$this->salida = "";
		$dbProveedorCuentaBancaria = new cls_DBProveedorCuentaBancaria($this->decodificar);
		$res = $dbProveedorCuentaBancaria ->ValidarProveedorCuentaBancaria($operacion_sql,$id_proveedor_cuenta_bancaria,$id_proveedor,$id_institucion,$nro_cuenta,$estado_reg);
		$this->salida = $dbProveedorCuentaBancaria ->salida;
		$this->query = $dbProveedorCuentaBancaria ->query;
		return $res;
	}
	
	
	
	
	/// --------------------- tad_item_proveedor --------------------- ///

	function ListarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ContarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ContarItemProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	
	function InsertarItemProveedor($id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->InsertarItemProveedor($id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ModificarItemProveedor($id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ModificarItemProveedor($id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_item_propuesto,$id_proveedor);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function EliminarItemProveedor($id_item_proveedor)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor-> EliminarItemProveedor($id_item_proveedor);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
										//$hidden_id_item_proveedor, $txt_precio_ult,$txt_fecha_ult_mod,$txt_fecha_reg,$txt_observaciones,$txt_id_item,$txt_id_moneda,$txt_id_item_propuesto,$txt_id_proveedor);
	function ValidarItemProveedor($operacion_sql,$id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_proveedor)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ValidarItemProveedor($operacion_sql,$id_item_proveedor,$precio,$fecha_ult_mod,$fecha_reg,$observaciones,$id_item,$id_moneda,$id_proveedor);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	
	function ListarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ListarSuperGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	} 
	
	function ListarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ListarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarSubGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ListarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ListarId1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ListarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ListarId2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ListarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ListarId3($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	function ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor ->ListarItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	/// --------------------- fin tad_item_proveedor --------------------- ///
	
	/// --------------------- tad_parametro_adquisicion --------------------- ///

	function ListarParametroAdquisicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ListarParametroAdquisicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function ContarParametroAdquisicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ContarParametroAdquisicion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function InsertarParametroAdquisicion($id_empresa)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->InsertarParametroAdquisicion($id_empresa);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function ModificarParametroAdquisicion($id_parametro_adquisicion,$estado,$fecha,$id_gestion_subsistema)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ModificarParametroAdquisicion($id_parametro_adquisicion,$estado,$fecha,$id_gestion_subsistema);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function ModificarParametroAdquisicionEstado($id_parametro_adquisicion,$estado,$fecha)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ModificarParametroAdquisicionEstado($id_parametro_adquisicion,$estado,$fecha);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	function EliminarParametroAdquisicion($id_parametro_adquisicion)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion -> EliminarParametroAdquisicion($id_parametro_adquisicion);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function ValidarParametroAdquisicion($operacion_sql,$id_parametro_adquisicion,$estado,$fecha,$id_gestion_subsistema)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ValidarParametroAdquisicion($operacion_sql,$id_parametro_adquisicion,$estado,$fecha,$id_gestion_subsistema);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	
	function obtenerNumDoc($tipo_doc,$tipo_adq){
		
		$this->salida="";
		$dbParametroAdquisicion= new cls_DBParametroAdquisicion($this->decodificar);
		$res=$dbParametroAdquisicion->obtenerNumDoc($tipo_doc,$tipo_adq);
		$this->salida=$dbParametroAdquisicion->salida;
		$this->query=$dbParametroAdquisicion->query;
		return $res;
	}
	
	function ListarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ListarCorrelativoGeneral($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	
	function ListarGestionParametroAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion ->ListarGestionParametroAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	function ContarGestionParametroAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbParametroAdquisicion = new cls_DBParametroAdquisicion($this->decodificar);
		$res = $dbParametroAdquisicion-> ContarGestionParametroAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbParametroAdquisicion ->salida;
		$this->query = $dbParametroAdquisicion ->query;
		return $res;
	}
	
	/// --------------------- fin tad_parametro_adquisicion --------------------- ///
/// --------------------- tad_categoria_adq --------------------- ///

	function ListarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq ->ListarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function ContarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq ->ContarCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function InsertarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq ->InsertarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function ModificarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq ->ModificarCategoriaAdq($id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto,$doc_respaldo);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function EliminarCategoriaAdq($id_categoria_adq)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq -> EliminarCategoriaAdq($id_categoria_adq);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function ValidarCategoriaAdq($operacion_sql,$id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq ->ValidarCategoriaAdq($operacion_sql,$id_categoria_adq,$nombre,$observaciones,$descripcion,$fecha_reg,$precio_min,$precio_max,$id_moneda,$norma,$simplificada,$defecto);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	function ClonarCategoriaAdq($id_categoria_adq)
	{
		$this->salida = "";
		$dbCategoriaAdq = new cls_DBCategoriaAdq($this->decodificar);
		$res = $dbCategoriaAdq -> ClonarCategoriaAdq($id_categoria_adq);
		$this->salida = $dbCategoriaAdq ->salida;
		$this->query = $dbCategoriaAdq ->query;
		return $res;
	}
	
	/// --------------------- fin tad_categoria_adq --------------------- ///
	
	
	/// --------------------- tad_estado_compra_categoria_adq --------------------- ///

	function ListarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq ->ListarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	function ContarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq ->ContarEstadoCompraCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	function InsertarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq ->InsertarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	function ModificarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq ->ModificarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	function EliminarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq -> EliminarEstadoCompraCategoriaAdq($id_estado_compra_categoria_adq);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	function ValidarEstadoCompraCategoriaAdq($operacion_sql,$id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq)
	{
		$this->salida = "";
		$dbEstadoCompraCategoriaAdq = new cls_DBEstadoCompraCategoriaAdq($this->decodificar);
		$res = $dbEstadoCompraCategoriaAdq ->ValidarEstadoCompraCategoriaAdq($operacion_sql,$id_estado_compra_categoria_adq,$dias_min,$dias_max,$orden,$id_estado_compra,$id_tipo_categoria_adq);
		$this->salida = $dbEstadoCompraCategoriaAdq ->salida;
		$this->query = $dbEstadoCompraCategoriaAdq ->query;
		return $res;
	}
	
	/// --------------------- fin tad_estado_compra_categoria_adq --------------------- ///
/// --------------------- tad_tipo_categoria_adq --------------------- ///

	function ListarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq ->ListarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	function ContarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq ->ContarTipoCategoriaAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	function InsertarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq ->InsertarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	function ModificarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq ->ModificarTipoCategoriaAdq($id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	function EliminarTipoCategoriaAdq($id_tipo_categoria_adq)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq -> EliminarTipoCategoriaAdq($id_tipo_categoria_adq);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	function ValidarTipoCategoriaAdq($operacion_sql,$id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre)
	{
		$this->salida = "";
		$dbTipoCategoriaAdq = new cls_DBTipoCategoriaAdq($this->decodificar);
		$res = $dbTipoCategoriaAdq ->ValidarTipoCategoriaAdq($operacion_sql,$id_tipo_categoria_adq,$fecha_reg,$id_categoria_adq,$estado_categoria,$tipo,$nombre);
		$this->salida = $dbTipoCategoriaAdq ->salida;
		$this->query = $dbTipoCategoriaAdq ->query;
		return $res;
	}
	
	/// --------------------- fin tad_tipo_categoria_adq --------------------- ///
	
	
/// --------------------- tad_estado_compra --------------------- ///

	function ListarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra ->ListarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	function ContarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra ->ContarEstadoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	function InsertarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra ->InsertarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	function ModificarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra ->ModificarEstadoCompra($id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	function EliminarEstadoCompra($id_estado_compra)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra -> EliminarEstadoCompra($id_estado_compra);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	function ValidarEstadoCompra($operacion_sql,$id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado)
	{
		$this->salida = "";
		$dbEstadoCompra = new cls_DBEstadoCompra($this->decodificar);
		$res = $dbEstadoCompra ->ValidarEstadoCompra($operacion_sql,$id_estado_compra,$descripcion,$proceso_sistema,$cronometrable,$nombre,$tiempo_estimado);
		$this->salida = $dbEstadoCompra ->salida;
		$this->query = $dbEstadoCompra ->query;
		return $res;
	}
	
	/// --------------------- fin tad_estado_compra --------------------- ///	
	
	
	
	
	
	/// --------------------- tad_servicio_proveedor --------------------- ///

	function ListarServicioProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor ->ListarServicioProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	function ContarServicioProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor ->ContarServicioProveedor($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	function InsertarServicioProveedor($id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor ->InsertarServicioProveedor($id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	function ModificarServicioProveedor($id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor ->ModificarServicioProveedor($id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	function EliminarServicioProveedor($id_servicio_proveedor)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor -> EliminarServicioProveedor($id_servicio_proveedor);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	function ValidarServicioProveedor($operacion_sql,$id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones)
	{
		$this->salida = "";
		$dbServicioProveedor = new cls_DBServicioProveedor($this->decodificar);
		$res = $dbServicioProveedor ->ValidarServicioProveedor($operacion_sql,$id_servicio_proveedor,$precio_ult,$fecha_ult_mod,$fecha_reg,$id_servicio,$id_moneda,$id_servicio_propuesto,$id_proveedor,$observaciones);
		$this->salida = $dbServicioProveedor ->salida;
		$this->query = $dbServicioProveedor ->query;
		return $res;
	}
	
	/// --------------------- fin tad_servicio_proveedor --------------------- ///
	
	/// --------------------- tad_tipo_adq --------------------- ///

	function ListarTipoAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq ->ListarTipoAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	function ContarTipoAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq ->ContarTipoAdq($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	function InsertarTipoAdq($id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq ->InsertarTipoAdq($id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	function ModificarTipoAdq($id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq ->ModificarTipoAdq($id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	function EliminarTipoAdq($id_tipo_adq)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq -> EliminarTipoAdq($id_tipo_adq);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	function ValidarTipoAdq($operacion_sql,$id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoAdq = new cls_DBTipoAdq($this->decodificar);
		$res = $dbTipoAdq ->ValidarTipoAdq($operacion_sql,$id_tipo_adq,$nombre,$observaciones,$tipo_adq,$descripcion,$fecha_reg,$codigo,$estado);
		$this->salida = $dbTipoAdq ->salida;
		$this->query = $dbTipoAdq ->query;
		return $res;
	}
	
	/// --------------------- fin tad_tipo_adq --------------------- ///
	/// --------------------- tad_tipo_servicio --------------------- ///

	function ListarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio ->ListarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	function ContarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio ->ContarTipoServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	function InsertarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio ->InsertarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	function ModificarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio ->ModificarTipoServicio($id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	function EliminarTipoServicio($id_tipo_servicio)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio -> EliminarTipoServicio($id_tipo_servicio);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	function ValidarTipoServicio($operacion_sql,$id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado)
	{
		$this->salida = "";
		$dbTipoServicio = new cls_DBTipoServicio($this->decodificar);
		$res = $dbTipoServicio ->ValidarTipoServicio($operacion_sql,$id_tipo_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_adq,$codigo,$estado);
		$this->salida = $dbTipoServicio ->salida;
		$this->query = $dbTipoServicio ->query;
		return $res;
	}
	
	/// --------------------- fin tad_tipo_servicio --------------------- ///
	/// --------------------- tad_servicio_propuesto --------------------- ///

	function ListarServicioPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto ->ListarServicioPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	function ContarServicioPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto ->ContarServicioPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	function InsertarServicioPropuesto($id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto ->InsertarServicioPropuesto($id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	function ModificarServicioPropuesto($id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto ->ModificarServicioPropuesto($id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	function EliminarServicioPropuesto($id_servicio_propuesto)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto -> EliminarServicioPropuesto($id_servicio_propuesto);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	function ValidarServicioPropuesto($operacion_sql,$id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda)
	{
		$this->salida = "";
		$dbServicioPropuesto = new cls_DBServicioPropuesto($this->decodificar);
		$res = $dbServicioPropuesto ->ValidarServicioPropuesto($operacion_sql,$id_servicio_propuesto,$nombre,$descripcion,$fecha_reg,$monto,$id_proveedor,$id_moneda);
		$this->salida = $dbServicioPropuesto ->salida;
		$this->query = $dbServicioPropuesto ->query;
		return $res;
	}
	
	/// --------------------- fin tad_servicio_propuesto --------------------- ///
	
	/// --------------------- tad_caracteristica --------------------- ///

	function ListarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ListarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ListarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item)
	{
		$this->salida = "";
		$dbCaracteristica= new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica->ListarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica->query;
		return $res;
	}
	function ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ContarCaracteristica($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ContarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ContarCaracteristicaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_item);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function InsertarCaracteristica($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->InsertarCaracteristica($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ModificarCaracteristica($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ModificarCaracteristica($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function EliminarCaracteristica($id_caracteristica)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica -> EliminarCaracteristica($id_caracteristica);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ValidarCaracteristica($operacion_sql,$id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ValidarCaracteristica($operacion_sql,$id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ListarCaracteristicaSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ListarCaracteristicaSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ContarCaracteristicaSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ContarCaracteristicaSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function InsertarCaracteristicaSeguimientoSolicitud($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->InsertarCaracteristicaSeguimientoSolicitud($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ModificarCaracteristicaSeguimientoSolicitud($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ModificarCaracteristicaSeguimientoSolicitud($id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function EliminarCaracteristicaSeguimientoSolicitud($id_caracteristica)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica -> EliminarCaracteristicaSeguimientoSolicitud($id_caracteristica);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	function ValidarCaracteristicaSeguimientoSolicitud($operacion_sql,$id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto)
	{
		$this->salida = "";
		$dbCaracteristica = new cls_DBCaracteristica($this->decodificar);
		$res = $dbCaracteristica ->ValidarCaracteristicaSeguimientoSolicitud($operacion_sql,$id_caracteristica,$caracteristica,$descripcion,$fecha_reg,$id_solicitud_compra_det,$id_item_propuesto,$id_servicio_propuesto);
		$this->salida = $dbCaracteristica ->salida;
		$this->query = $dbCaracteristica ->query;
		return $res;
	}
	
	/// --------------------- fin tad_caracteristica --------------------- ///
	
	/// --------------------- tad_item_propuesto --------------------- ///

	/// --------------------- tad_item_propuesto --------------------- ///

	function ListarItemPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto ->ListarItemPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	function ContarItemPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto ->ContarItemPropuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	function InsertarItemPropuesto($id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto ->InsertarItemPropuesto($id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	function ModificarItemPropuesto($id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto ->ModificarItemPropuesto($id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	function EliminarItemPropuesto($id_item_propuesto)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto -> EliminarItemPropuesto($id_item_propuesto);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	function ValidarItemPropuesto($operacion_sql,$id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario)
	{
		$this->salida = "";
		$dbItemPropuesto = new cls_DBItemPropuesto($this->decodificar);
		$res = $dbItemPropuesto ->ValidarItemPropuesto($operacion_sql,$id_item_propuesto,$nombre,$descripcion,$costo_estimado,$observaciones,$estado_reg,$fecha_reg,$id_unidad_medida_base,$id_proveedor,$id_moneda,$id_usuario);
		$this->salida = $dbItemPropuesto ->salida;
		$this->query = $dbItemPropuesto ->query;
		return $res;
	}
	
	/// --------------------- fin tad_item_propuesto --------------------- ///
	
	/// --------------------- tad_correlativo --------------------- ///

	function ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo ->ListarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	function ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo ->ContarCorrelativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	function InsertarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo ->InsertarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	function ModificarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo ->ModificarCorrelativo($id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	function EliminarCorrelativo($id_correlativo)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo -> EliminarCorrelativo($id_correlativo);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	function ValidarCorrelativo($operacion_sql,$id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCorrelativo = new cls_DBCorrelativo($this->decodificar);
		$res = $dbCorrelativo ->ValidarCorrelativo($operacion_sql,$id_correlativo,$valor_actual,$valor_siguiente,$incremento,$id_parametro_adquisicion,$id_documento,$prefijo,$sufijo,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCorrelativo ->salida;
		$this->query = $dbCorrelativo ->query;
		return $res;
	}
	
	/// --------------------- fin tad_correlativo --------------------- ///
	
	
	/// --------------------- tad_rpa --------------------- ///

	function ListarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa ->ListarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	function ContarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa ->ContarRpa($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	function InsertarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa ->InsertarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	function ModificarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa ->ModificarRpa($id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	function EliminarRpa($id_rpa)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa -> EliminarRpa($id_rpa);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	function ValidarRpa($operacion_sql,$id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq)
	{
		$this->salida = "";
		$dbRpa = new cls_DBRpa($this->decodificar);
		$res = $dbRpa ->ValidarRpa($operacion_sql,$id_rpa,$fecha_reg,$estado,$id_empleado_frppa,$id_categoria_adq);
		$this->salida = $dbRpa ->salida;
		$this->query = $dbRpa ->query;
		return $res;
	}
	
	/// --------------------- fin tad_rpa --------------------- ///
/// --------------------- tad_solicitud_compra --------------------- ///

	function ListarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ContarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ContarSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ListarSolicitudCompraTer($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa,$id_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarSolicitudCompraTer($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa,$id_proceso_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ContarSolicitudCompraTer($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa,$id_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ContarSolicitudCompraTer($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa,$id_proceso_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function InsertarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_frppa_aprobacion, $id_empleado_frppa_gfa, $periodo, $gestion, $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$id_correspondencia)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->InsertarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_frppa_aprobacion, $id_empleado_frppa_gfa, $periodo, $gestion, $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$id_correspondencia);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ModificarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_frppa_aprobacion, $id_empleado_frppa_gfa,  $periodo, $gestion, $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$id_correspondencia)
	{//
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ModificarSolicitudCompra($id_solicitud_compra, $precio_total, $observaciones, $fecha_venc, $fecha_reg, $hora_reg, $localidad, $num_solicitud, $estado_reg, $estado_vigente_solicitud, $tipo_adjudicacion, $modalidad,  $id_tipo_categoria_adq, $id_empleado_frppa_solicitante, $id_moneda, $id_rpa, $id_empleado_frppa_transcriptor,  $id_unidad_organizacional, $id_empleado_frppa_pre_aprobacion, $id_empleado_frppa_aprobacion, $id_empleado_frppa_gfa,  $periodo, $gestion, $id_presupuesto,$id_tipo_adq,$id_empresa,$id_orden_trabajo,$id_almacen_logico,$id_uo_gerencia,$id_depto,$proveedores_propuestos,$comite_calificacion,$comite_recepcion,$avance,$id_correspondencia);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	
	function  ModificarModalidadCompra($id_solicitud_compra,$id_tipo_categoria_adq,$permite_agrupar)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra -> ModificarModalidadCompra($id_solicitud_compra,$id_tipo_categoria_adq,$permite_agrupar);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function ModificarSolicitudCompraRPA($id_solicitud_compra,$id_rpa,$comite_calificacion,$id_tipo_categoria_adq,$id_empleado_aprobacion)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ModificarSolicitudCompraRPA($id_solicitud_compra,$id_rpa,$comite_calificacion,$id_tipo_categoria_adq,$id_empleado_aprobacion);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	
	function EliminarSolicitudCompra($id_solicitud_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra -> EliminarSolicitudCompra($id_solicitud_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ValidarSolicitudCompra($operacion_sql,$id_solicitud_compra,$precio_total,$observaciones,$fecha_venc,$fecha_reg,$hora_reg,$localidad,$num_solicitud,$estado_reg,$estado_vigente_solicitud,$tipo_adjudicacion,$modalidad,$id_solicitud_compra_ant,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_empleado_frppa_transcriptor,$id_unidad_organizacional,$id_empleado_frppa_pre_aprobacion,$id_empleado_frppa_aprobacion,$id_empleado_frppa_gfa,$periodo,$gestion,$id_presupuesto)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ValidarSolicitudCompra($operacion_sql,$id_solicitud_compra,$precio_total,$observaciones,$fecha_venc,$fecha_reg,$hora_reg,$localidad,$num_solicitud,$estado_reg,$estado_vigente_solicitud,$tipo_adjudicacion,$modalidad,$id_solicitud_compra_ant,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_empleado_frppa_transcriptor,$id_unidad_organizacional,$id_empleado_frppa_pre_aprobacion,$id_empleado_frppa_aprobacion,$id_empleado_frppa_gfa,$periodo,$gestion,$id_presupuesto);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function ListarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ContarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ContarSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$vista);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	
	function ModificarSeguimientoSolicitud($id_solicitud_compra,$operacion,$observaciones)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ModificarSeguimientoSolicitud($id_solicitud_compra,$operacion,$observaciones);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function AnularSolicitud($id_solicitud_compra,$observaciones)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra -> AnularSolicitud($id_solicitud_compra,$observaciones);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	function ValidarSeguimientoSolicitud($operacion_sql,$id_solicitud_compra,$observaciones,$localidad,$estado_vigente_solicitud,$tipo_adjudicacion,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_unidad_organizacional,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ValidarSeguimientoSolicitud($operacion_sql,$id_solicitud_compra,$observaciones,$localidad,$estado_vigente_solicitud,$tipo_adjudicacion,$id_tipo_categoria_adq,$id_empleado_frppa_solicitante,$id_moneda,$id_rpa,$id_unidad_organizacional,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	
	function FinalizarSolicitudCompra($id_solicitud_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->FinalizarSolicitudCompra($id_solicitud_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	function ListarRepSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarRepSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	function ListarRepVerificacionCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarRepVerificacionCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	function ListarCompraRapida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarCompraRapida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function VerificarDetalleProceso($id_solicitud_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->VerificarDetalleProceso($id_solicitud_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function ContarCompraRapida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ContarCompraRapida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_empresa);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function ModificarCompraRapida($id_solicitud_compra,$codigo_proceso,$observaciones_proceso,$id_empresa,$pago_variable,$fecha_reg)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ModificarCompraRapida($id_solicitud_compra,$codigo_proceso,$observaciones_proceso,$id_empresa,$pago_variable,$fecha_reg);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
	
	function ModificarCompraRapidaSimplificada($id_solicitud_compra,$codigo_proceso,$observaciones_proceso,$id_empresa,$id_comprador,$tipo_recibo,$fecha_reg)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ModificarCompraRapidaSimplificada($id_solicitud_compra,$codigo_proceso,$observaciones_proceso,$id_empresa,$id_comprador,$tipo_recibo,$fecha_reg);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	
		//9ago11
	function ContarTotalSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_solicitud_compra)
	{
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ContarTotalSolicitudCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_solicitud_compra);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}
	/// --------------------- fin tad_solicitud_compra --------------------- ///
	
	/// --------------------- tad_solicitud_compra_det --------------------- ///

	function ListarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ListarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ContarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ContarSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ListarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ListarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ContarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ContarSolicitudCompraDetGrup($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function InsertarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->InsertarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ModificarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ModificarSolicitudCompraDet($id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad,$especificaciones_tecnicas,$almacenable,$id_empresa,$id_unidad_medida_base,$precio_total_as);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function EliminarSolicitudCompraDet($id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet -> EliminarSolicitudCompraDet($id_solicitud_compra_det);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function AnularSolicitudCompraDet($id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet -> AnularSolicitudCompraDet($id_solicitud_compra_det);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ValidarSolicitudCompraDet($operacion_sql,$id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ValidarSolicitudCompraDet($operacion_sql,$id_solicitud_compra_det,$id_item_antiguo,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado,$mat_bajo_responsabilidad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ListarDetalleSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ListarDetalleSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ContarDetalleSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ContarDetalleSeguimientoSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function InsertarDetalleSeguimientoSolicitud($id_solicitud_compra_det,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->InsertarDetalleSeguimientoSolicitud($id_solicitud_compra_det,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ModificarDetalleSeguimientoSolicitud($id_solicitud_compra_det,$partida_presupuestaria,$pac_verificado,$monto_aprobado)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ModificarDetalleSeguimientoSolicitud($id_solicitud_compra_det,$partida_presupuestaria,$pac_verificado,$monto_aprobado);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function AprobarVerificacionReformulacion($id_solicitud_compra_det,$reformular)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->AprobarVerificacionReformulacion($id_solicitud_compra_det,$reformular);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function EliminarDetalleSeguimientoSolicitud($id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet -> EliminarDetalleSeguimientoSolicitud($id_solicitud_compra_det);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ValidarDetalleSeguimientoSolicitud($operacion_sql,$id_solicitud_compra_det,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ValidarDetalleSeguimientoSolicitud($operacion_sql,$id_solicitud_compra_det,$cantidad,$precio_referencial_estimado,$fecha_reg,$fecha_inicio_serv,$fecha_fin_serv,$descripcion,$partida_presupuestaria,$estado_reg,$pac_verificado,$id_solicitud_compra,$id_servicio,$id_item,$monto_aprobado);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function ReporteSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ReporteSolicitudCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function ReporteSolicitudCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ReporteSolicitudCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function AprobarRefCompraDet($id_solicitud_compra_det,$reformular,$monto_reformulado,$motivo_ref,$monto_ref_reformulado_as)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->AprobarRefCompraDet($id_solicitud_compra_det,$reformular,$monto_reformulado,$motivo_ref,$monto_ref_reformulado_as);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function ReporteVerificacionBien($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ReporteVerificacionBien($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	function ReporteVerificacionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ReporteVerificacionServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	function ReportePartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudCompraDet = new cls_DBSolicitudCompraDet($this->decodificar);
		$res = $dbSolicitudCompraDet ->ReportePartidaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompraDet ->salida;
		$this->query = $dbSolicitudCompraDet ->query;
		return $res;
	}
	
	
	/// --------------------- fin tad_solicitud_compra_det --------------------- ///
		/// --------------------- tad_documento --------------------- ///

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
	
	function InsertarDocumento($id_documento,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->InsertarDocumento($id_documento,$codigo,$descripcion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	function ModificarDocumento($id_documento,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ModificarDocumento($id_documento,$codigo,$descripcion);
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
	
	function ValidarDocumento($operacion_sql,$id_documento,$codigo,$descripcion)
	{
		$this->salida = "";
		$dbDocumento = new cls_DBDocumento($this->decodificar);
		$res = $dbDocumento ->ValidarDocumento($operacion_sql,$id_documento,$codigo,$descripcion);
		$this->salida = $dbDocumento ->salida;
		$this->query = $dbDocumento ->query;
		return $res;
	}
	
	/// --------------------- fin tad_documento --------------------- ///
		/// --------------------- tad_proceso_compra --------------------- ///
 
	function ListarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ContarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ContarProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function VerificarDatosReversion($criterio_filtro)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->VerificarDatosReversion($criterio_filtro);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ListarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ContarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ContarProcesoCompraMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function InsertarProcesoCompra($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$numero_cotizacion,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$lugar_entrega)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->InsertarProcesoCompra($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$numero_cotizacion,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$lugar_entrega);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function InsertarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> InsertarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	
	function ModificarProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ModificarProcesoCompra($id_proceso_compra,$observaciones);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ModificarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ModificarProcesoCompraMul($id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis,$fecha_proc,$id_tipo_adq,$lugar_entrega,$id_parametro_adquisicion,$norma,$pago_variable);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	
	function EliminarProcesoCompra($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> EliminarProcesoCompra($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	function EliminarProcesoCompraMul($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> EliminarProcesoCompraMul($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	


	
	function ValidarProcesoCompra($operacion_sql,$id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ValidarProcesoCompra ($operacion_sql,$id_proceso_compra,$observaciones,$codigo_proceso,$fecha_reg,$estado_vigente,$id_tipo_categoria_adq,$id_moneda,$num_cotizacion,$num_proceso,$siguiente_estado,$periodo,$gestion,$num_cotizacion_sis,$num_proceso_sis);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function AnularProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> AnularProcesoCompra($id_proceso_compra,$observaciones);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	function RevPresVariable($id_proceso_compra,$importe_rev_aa,$importe_rev_as)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> RevPresVariable($id_proceso_compra,$importe_rev_aa,$importe_rev_as);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
		
	function IniciarProcesoCompra($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> IniciarProcesoCompra($id_proceso_compra,$observaciones);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	
	function IniciarProcesoCompraSim($id_proceso_compra,$observaciones,$id_comprador,$tipo_recibo)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> IniciarProcesoCompraSim($id_proceso_compra,$observaciones,$id_comprador,$tipo_recibo);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
			
	function VerificarSiguienteConvocatoria($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> VerificarSiguienteConvocatoria($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
				
	function NuevaConvocatoria($id_proceso_compra,$observaciones)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> NuevaConvocatoria($id_proceso_compra,$observaciones);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function FinalizarProcesoCompra($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> FinalizarProcesoCompra($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ListarRepProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarRepProceso($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	function ListarRepProcesoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarRepProcesoDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	function ListarRepProcesoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarRepProcesoSol($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function RevertirPresupuestoProceso($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra -> RevertirPresupuestoProceso($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function RepNuevaConvocatoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra= new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra->RepNuevaConvocatoria($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra->salida;
		$this->query = $dbProcesoCompra->query;
		return $res;
	}
	
	
	function RepEvaluacionPropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra= new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra->RepEvaluacionPropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra->salida;
		$this->query = $dbProcesoCompra->query;
		return $res;
	}
	
	function RepEvaluacionPropuestaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra= new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra->RepEvaluacionPropuestaDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra->salida;
		$this->query = $dbProcesoCompra->query;
		return $res;
	}
	
	function RepProveedores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra= new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra->RepProveedores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra->salida;
		$this->query = $dbProcesoCompra->query;
		return $res;
	}
	
	function ListarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ContarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ContarProcesoCompraDir($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function InsertarValeProcesoCompra($id_proceso_compra,$id_caja,$id_cajero,$id_comprador)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->InsertarValeProcesoCompra($id_proceso_compra,$id_caja,$id_cajero,$id_comprador);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function FinalizarProcesoCompraDir($id_proceso_compra,$id_empresa)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->FinalizarProcesoCompraDir($id_proceso_compra,$id_empresa);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ListarComprometido($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarComprometido($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ComprometerPresupuesto($id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ComprometerPresupuesto($id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function ListarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ContarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ContarProcesoFinalizado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	/// --------------------- fin tad_proceso_compra --------------------- ///
/// --------------------- tad_proceso_compra_det --------------------- ///

	function ListarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ListarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function ContarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ContarProcesoCompraMulDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}

	function ListarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ListarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function ContarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ContarProcesoCompraMulIteDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
		function ListarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ListarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function ContarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ContarProcesoCompraMulSerDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function VerificarInsertarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->VerificarInsertarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function AgrupaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->AgrupaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	
	
	function InsertaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->InsertaProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg,$id_solicitud_compra_det);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	
	
	function ModificarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ModificarProcesoCompraMulDet($id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function EliminarProcesoCompraMulDet($id_solicitud_compra_det,$id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet -> EliminarProcesoCompraMulDet($id_solicitud_compra_det,$id_proceso_compra);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	function ValidarProcesoCompraMulDet($operacion_sql,$id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg)
	{
		$this->salida = "";
		$dbProcesoCompraDet = new cls_DBProcesoCompraDet($this->decodificar);
		$res = $dbProcesoCompraDet ->ValidarProcesoCompraMulDet($operacion_sql,$id_proceso_compra_det,$id_servicio,$id_item,$cantidad,$precio_referencial_total,$id_proceso_compra,$estado_reg);
		$this->salida = $dbProcesoCompraDet ->salida;
		$this->query = $dbProcesoCompraDet ->query;
		return $res;
	}
	
	/// --------------------- fin tad_proceso_compra_det --------------------- ///
	
	/// --------------------- tad_servicio --------------------- ///

	function ListarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio ->ListarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	function ContarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio ->ContarServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	function InsertarServicio($id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$continuo,$estado)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio ->InsertarServicio($id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$continuo,$estado);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	function ModificarServicio($id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$continuo,$estado)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio ->ModificarServicio($id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$continuo,$estado);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	function EliminarServicio($id_servicio)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio -> EliminarServicio($id_servicio);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	function ValidarServicio($operacion_sql,$id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$estado)
	{
		$this->salida = "";
		$dbServicio = new cls_DBServicio($this->decodificar);
		$res = $dbServicio ->ValidarServicio($operacion_sql,$id_servicio,$nombre,$descripcion,$fecha_reg,$id_tipo_servicio,$codigo,$estado);
		$this->salida = $dbServicio ->salida;
		$this->query = $dbServicio ->query;
		return $res;
	}
	
	/// --------------------- fin tad_servicio --------------------- ///
	
	/// --------------------- tad_solicitud_proceso_compra --------------------- ///

	function ListarSolicitudProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra ->ListarSolicitudProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	function ContarSolicitudProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra ->ContarSolicitudProcesoCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	function InsertarSolicitudProcesoCompra($id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra ->InsertarSolicitudProcesoCompra($id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	function ModificarSolicitudProcesoCompra($id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra ->ModificarSolicitudProcesoCompra($id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	function EliminarSolicitudProcesoCompra($id_solicitud_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra -> EliminarSolicitudProcesoCompra($id_solicitud_proceso_compra);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	function ValidarSolicitudProcesoCompra($operacion_sql,$id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra)
	{
		$this->salida = "";
		$dbSolicitudProcesoCompra = new cls_DBSolicitudProcesoCompra($this->decodificar);
		$res = $dbSolicitudProcesoCompra ->ValidarSolicitudProcesoCompra($operacion_sql,$id_solicitud_proceso_compra,$fecha_reg,$id_solicitud_compra,$id_proceso_compra);
		$this->salida = $dbSolicitudProcesoCompra ->salida;
		$this->query = $dbSolicitudProcesoCompra ->query;
		return $res;
	}
	
	/// --------------------- fin tad_solicitud_proceso_compra --------------------- ///
	
	/// --------------------- tad_estado_proceso --------------------- ///

	function ListarHistorialSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ListarHistorialSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	
	function ContarHistorialSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ContarHistorialSolicitud($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	
		function ListarHistorialSolPro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ListarHistorialSolPro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	
	function ContarHistorialSolPro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ContarHistorialSolPro($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	
	function ListarHistorialReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ListarHistorialReporte($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	function ListarHistorialGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbEstadoProceso = new cls_DBEstadoProceso($this->decodificar);
		$res = $dbEstadoProceso ->ListarHistorialGrupo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbEstadoProceso ->salida;
		$this->query = $dbEstadoProceso ->query;
		return $res;
	}
	
	
	
	
	
	/// --------------------- tad_cotizacion --------------------- ///

	function ListarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	
	function ListarAperturaOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarAperturaOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ListarCabeceraApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarCabeceraApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ContarCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ListarListaOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> ListarListaOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
function ListarListaOCDetallado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> ListarListaOCDetallado($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ListarNumeroOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> ListarNumeroOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function InsertarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra,$id_empresa,$retencion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->InsertarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra,$id_empresa,$retencion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ModificarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra,$id_empresa,$fecha_cotizacion,$retencion){
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarCotizacion($id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra,$id_empresa,$fecha_cotizacion,$retencion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function EliminarCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> EliminarCotizacion($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function TerminarCotizacion($id_cotizacion,$retencion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> TerminarCotizacion($id_cotizacion,$retencion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	
	
	function ModificarEstadoCotizacion($id_proceso_compra,$id_cotizacion,$figura_acta,$observaciones_acta)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> ModificarEstadoCotizacion($id_proceso_compra,$id_cotizacion,$figura_acta,$observaciones_acta);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ListarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ContarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ContarOCCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ValidarCotizacion($operacion_sql,$id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ValidarCotizacion($operacion_sql,$id_cotizacion,$fecha_venc,$fecha_reg,$impuestos,$garantia,$lugar_entrega,$forma_pago,$tiempo_validez_oferta,$fecha_entrega,$tipo_entrega,$observaciones,$id_proceso_compra,$id_moneda,$id_proveedor,$id_tipo_categoria_adq,$precio_total,$figura_acta,$num_factura,$num_orden_compra,$estado_vigente,$estado_reg,$nombre_pago,$siguiente_estado,$periodo,$gestion,$num_orden_compra_sis,$num_cotizacion,$fecha_orden_compra);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
//	function ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	function ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ReporteCotizacionSC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteCotizacionSC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ReporteOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepCabCuaComparativo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ReporteCotizacion1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteCotizacion1($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function RepCuaComServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepCuaComServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ModificarCotizacionProp($id_cotizacion,$impuestos, $garantia, $lugar_entrega, $forma_pago, $tiempo_validez_oferta, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, $precio_total, $figura_acta, $num_cotizacion,$fecha_cotizacion,$id_empresa,$fecha_recepcion_propuestas,$factura_total,$num_autoriza_factura,$cod_control_factura,$fecha_factura)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarCotizacionProp($id_cotizacion,$impuestos, $garantia, $lugar_entrega, $forma_pago, $tiempo_validez_oferta, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, $precio_total, $figura_acta, $num_cotizacion,$fecha_cotizacion,$id_empresa,$fecha_recepcion_propuestas,$factura_total,$num_autoriza_factura,$cod_control_factura,$fecha_factura);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ModificarCotizacionOrdenCompra($id_cotizacion, $lugar_entrega, $forma_pago, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra,$num_pagos,$fecha_orden_compra,$id_empresa,$factura_total,$num_factura,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$tipo_pago,$id_caja,$id_cajero,$id_depto_tesoro,$tipo_plantilla,$por_adelanto,$por_retgar,$nro_contrato,$monto_adelanto_moneda_cotizada,$fecha_ini_ctto, $fecha_fin_ctto)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarCotizacionOrdenCompra($id_cotizacion, $lugar_entrega, $forma_pago, $fecha_entrega, $tipo_entrega, $observaciones, $id_proceso_compra,$num_pagos,$fecha_orden_compra,$id_empresa,$factura_total,$num_factura,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$tipo_pago,$id_caja,$id_cajero,$id_depto_tesoro,$tipo_plantilla,$por_adelanto,$por_retgar,$nro_contrato,$monto_adelanto_moneda_cotizada,$fecha_ini_ctto,$fecha_fin_ctto);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function FinalizarCotizacionAdj($id_cotizacion,$fecha_adjudicacion,$id_proceso_compra,$estado_vigente,$id_empleado_adjudicacion,$justificacion_adjudicacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->FinalizarCotizacionAdj($id_cotizacion,$fecha_adjudicacion,$id_proceso_compra,$estado_vigente,$id_empleado_adjudicacion,$justificacion_adjudicacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function RepProveedoresCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepProveedoresCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepItemCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepItemCotizacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepTotalItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepTotalItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepPlazoCot($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepPlazoCot($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
		
	
	function RepLugarEnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepLugarEnt($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepFormaPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepFormaPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function RepTiemVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepTiemVal($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function RepGarantia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepGarantia($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepObservaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepObservaciones($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RepActaApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepActaApertura($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function AdjudicarTodo($id_cotizacion){
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->AdjudicarTodo($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RevertirAdjudicacion($id_cotizacion,$id_proceso_compra){
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RevertirAdjudicacion($id_cotizacion,$id_proceso_compra);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function CambiarEstadoCot($id_cotizacion,$observaciones,$id_proceso_compra,$estado_vigente)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->CambiarEstadoCot($id_cotizacion,$observaciones,$id_proceso_compra,$estado_vigente);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function InsertarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero){
		
	    $this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->InsertarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ModificarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero){
		
	    $this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarCotizacionDir($id_cotizacion, $impuestos, $forma_pago,$observaciones, $id_proceso_compra, $id_moneda, $id_proveedor, $id_tipo_categoria_adq, 
			$precio_total,$num_factura, $nombre_pago,$periodo, $gestion,$num_cotizacion,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$id_empresa,$retencion,$tipo_documento,$id_caja,$id_cajero);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function FinalizarCotizacionDir($id_cotizacion,$retencion,$id_empresa,$num_factura,$fecha_factura,$id_caja,$id_cajero,$impuestos,$precio_total,$id_responsable_adjudicacion,$fecha_adjudicacion,$observaciones){
	    $this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->FinalizarCotizacionDir($id_cotizacion,$retencion,$id_empresa,$num_factura,$fecha_factura,$id_caja,$id_cajero,$impuestos,$precio_total,$id_responsable_adjudicacion,$fecha_adjudicacion,$observaciones);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ModificarRecomendacion($id_cotizacion,$justificacion_adjudicacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarRecomendacion($id_cotizacion,$justificacion_adjudicacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
    
	
	function PagarAdelanto($id_cotizacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->PagarAdelanto($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	function ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ListarConsultoresPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarConsultoresPresupuesto($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	   
	
	function ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ContarConsultores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$en_planilla);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
		function FinalizarCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> FinalizarCotizacion($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ModificarDatosServ($id_cotizacion,$nro_contrato,$fecha_ini_ctto,$fecha_fin_ctto)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ModificarDatosServ($id_cotizacion,$nro_contrato,$fecha_ini_ctto,$fecha_fin_ctto);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function VerificarDevengado($id_cotizacion)
	{
		
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->VerificarDevengado($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	
		
	function RepSolicitudAnticipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago){
		$this->salida="";
		$dbCotizacion= new cls_DBCotizacion($this->decodificar);
		$res=$dbCotizacion->RepSolicitudAnticipo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago);
		$this->salida=$dbCotizacion->salida;
		$this->query=$dbCotizacion->query;
		return $res;
	}
	
	
	function RepSolicitudAnticipoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago){
		$this->salida="";
		$dbCotizacion= new cls_DBCotizacion($this->decodificar);
		$res=$dbCotizacion->RepSolicitudAnticipoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago);
		$this->salida=$dbCotizacion->salida;
		$this->query=$dbCotizacion->query;
		return $res;
	}
	
	
	
	/****Reporte Detalle General de OC por importe y partida : 03/11/011****/
	function ListarDetalleGeneralOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida="";
		$dbCotizacion= new cls_DBCotizacion($this->decodificar);
		$res=$dbCotizacion->ListarDetalleGeneralOC($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida=$dbCotizacion->salida;
		$this->query=$dbCotizacion->query;
		return $res;
	}
	
	/*-------------------------------------fin cotizacion----------------------------------------*/
	
	
	
	/******EMPIEZA EL REPORTE DE INGRESO A ALMACEN *****/
	function ReporteIngresoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteIngresoAlmacen($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function ReporteIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ReporteIngresoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function IngresoDetSum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->IngresoDetSum($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function AnularCotizacion($id_cotizacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->AnularCotizacion($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	//Reporte para Solicitud de Pago a Proveedor
	function RepSolicitudPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepSolicitudPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function RepSolicitudPagoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RepSolicitudPagoDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_plan_pago);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function RevertirRendicion($id_cotizacion)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->RevertirRendicion($id_cotizacion);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	/// --------------------- fin tad_cotizacion --------------------- ///
	
	/// --------------------- tad_cotizacion_det --------------------- ///

	function ListarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ListarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	function ContarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ContarCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	
	
	function ListarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ListarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	function ContarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ContarCotizacionServDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	
	function InsertarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->InsertarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	function ModificarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado,$id_item_cotizado,$id_servicio_cotizado,$retencion)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ModificarCotizacionDet($id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado,$id_item_cotizado,$id_servicio_cotizado,$retencion);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	
	function ModificarCotizacionAdj($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ModificarCotizacionAdj($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	
	function ModificarItseCotizado($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada,$id_item_cotizado,$id_servicio_cotizado,$cantidad,$precio,$tiempo_entrega,$garantia,$observaciones,$id_solicitud_compra_det)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ModificarItseCotizado($id_cotizacion_det,$id_cotizacion, $id_item_aprobado,$id_servicio,$id_proceso_compra_det,$cantidad_adjudicada,$id_item_cotizado,$id_servicio_cotizado,$cantidad,$precio,$tiempo_entrega,$garantia,$observaciones,$id_solicitud_compra_det);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	
	function EliminarCotizacionDet($id_cotizacion_det)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet -> EliminarCotizacionDet($id_cotizacion_det);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	
	function ValidarCotizacionDet($operacion_sql,$id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->ValidarCotizacionDet($operacion_sql,$id_cotizacion_det,$tiempo_entrega,$precio,$cantidad,$garantia,$observaciones,$observado,$id_cotizacion,$id_item_aprobado,$id_servicio,$id_proceso_compra_det,$estado_reg,$estado);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
//	function RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	function RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->RepCotizacionDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	function RepCotizacionDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->RepCotizacionDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	function RepOrdenCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->RepOrdenCompraDetServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	function RepOrdenCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacionDet = new cls_DBCotizacionDet($this->decodificar);
		$res = $dbCotizacionDet ->RepOrdenCompraDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacionDet ->salida;
		$this->query = $dbCotizacionDet ->query;
		return $res;
	}
	/// --------------------- fin tad_cotizacion_det --------------------- ///
	
		/// --------------------- tad_plan_pago --------------------- ///

	function ListarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ListarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ListarPlanPagoCuota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ListarPlanPagoCuota($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ListarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ListarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ContarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ContarPlanPago($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ContarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ContarNumPagos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function InsertarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->InsertarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ModificarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$fecha_pagado,$num_factura,$observaciones,$boleta_garantia,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$multas,$impuestos,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar,$descuento_anticipo,$monto_no_pagado,$fecha_devengado,$accion,$descuentos,$obs_descuentos)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ModificarPlanPago($id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion,$fecha_pagado,$num_factura,$observaciones,$boleta_garantia,$num_autoriza_factura,$cod_control_factura,$fecha_factura,$multas,$impuestos,$id_gestion,$id_cuenta_doc,$por_anticipo,$por_retgar,$descuento_anticipo,$monto_no_pagado,$fecha_devengado,$accion,$descuentos,$obs_descuentos);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function EliminarPlanPago($id_plan_pago)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago -> EliminarPlanPago($id_plan_pago);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res; 
	}
	
	function ValidarPlanPago($operacion_sql,$id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ValidarPlanPago($operacion_sql,$id_plan_pago,$tipo_pago,$nro_cuota,$fecha_pago,$monto,$estado,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	function ListarPlanPagoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ListarPlanPagoRep($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	function RepPlanPagoCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->RepPlanPagoCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	function FinalizarPlanPago($id_plan_pago,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->FinalizarPlanPago($id_plan_pago,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	
	function RevertirPlanPago($id_plan_pago,$id_cotizacion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->RevertirPlanPago($id_plan_pago,$id_cotizacion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function FinalizarDefPagos($id_cotizacion,$tipo)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->FinalizarDefPagos($id_cotizacion,$tipo);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function ModificarPagoAS($id_cotizacion,$total_aa,$total_as)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->ModificarPagoAS($id_cotizacion,$total_aa,$total_as);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	function RegistrarDevengado($id_cotizacion, $tipo_documento, $num_factura, $fecha_factura, $observaciones_devengado, $fecha_devengado, $importe_devengar,$id_gestion)
	{
		$this->salida = "";
		$dbPlanPago = new cls_DBPlanPago($this->decodificar);
		$res = $dbPlanPago ->RegistrarDevengado($id_cotizacion, $tipo_documento, $num_factura, $fecha_factura, $observaciones_devengado, $fecha_devengado, $importe_devengar,$id_gestion);
		$this->salida = $dbPlanPago ->salida;
		$this->query = $dbPlanPago ->query;
		return $res;
	}
	
	
	
	/// --------------------- fin tad_plan_pago --------------------- ///
	/// --------------------- tad_grupo_sp_det --------------------- ///

	function ListarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupoSpDet = new cls_DBGrupoSpDet($this->decodificar);
		$res = $dbGrupoSpDet ->ListarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoSpDet ->salida;
		$this->query = $dbGrupoSpDet ->query;
		return $res;
	}
	
	function ContarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbGrupoSpDet = new cls_DBGrupoSpDet($this->decodificar);
		$res = $dbGrupoSpDet ->ContarGrupoProcComMul($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbGrupoSpDet ->salida;
		$this->query = $dbGrupoSpDet ->query;
		return $res;
	}
	
		function ListarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio)
	{
		$this->salida = "";
		$dbGrupoSpDet = new cls_DBGrupoSpDet($this->decodificar);
		$res = $dbGrupoSpDet ->ListarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);
		$this->salida = $dbGrupoSpDet ->salida;
		$this->query = $dbGrupoSpDet ->query;
		return $res;
	}
	
	function ContarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio)
	{
		$this->salida = "";
		$dbGrupoSpDet = new cls_DBGrupoSpDet($this->decodificar);
		$res = $dbGrupoSpDet ->ContarGrupoProcDet($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra,$id_item,$id_servicio);
		$this->salida = $dbGrupoSpDet ->salida;
		$this->query = $dbGrupoSpDet ->query;
		return $res;
	}
	
	
	
	/// --------------------- fin tad_grupo_sp_det --------------------- ///
	
	
	///----------------------------------adjudicacion-----------------------------//
function ListarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->ListarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	function ContarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->ContarAdjudicacion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_cotizacion,$id_item,$id_servicio);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	function InsertarReforAdj($id_cotizacion_det,$cantidad_adjudicada,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_solicitada,$monto_aprobado,$reformular,$bandera,$id_adjudicacion,$precio_cotizado,$retencion,$motivo_ref)
	{ 
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		
		$res = $dbAdjudicacion->InsertarReforAdj($id_cotizacion_det,$cantidad_adjudicada,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado,$id_proceso_compra_det,$id_solicitud_compra_det,$cantidad_solicitada,$monto_aprobado,$reformular,$bandera,$id_adjudicacion,$precio_cotizado,$retencion,$motivo_ref);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	function AdjudicarDetalle($id_cotizacion,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->AdjudicarDetalle($id_cotizacion,$id_item,$id_servicio,$id_item_cotizado,$id_servicio_cotizado);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	
	function RepAdjudicacionProceso($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->RepAdjudicacionProceso($id_proceso_compra,$tipo);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	function RepSolicitudProceso($id_proceso_compra,$id_solicitud_compra,$tipo)//08-enero-2010
	{
		$this->salida = "";
		$dbSolicitudCompra= new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra->RepSolicitudProceso($id_proceso_compra,$id_solicitud_compra,$tipo);
		$this->salida = $dbSolicitudCompra->salida;
		$this->query = $dbSolicitudCompra->query;
		return $res;
	}
	
	
	
	function RepPartidaProceso($id_proceso_compra,$id_solicitud_compra,$tipo)//08-enero-2010
	{ 
		$this->salida = "";
		$dbSolicitudCompra= new cls_DBSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra->RepPartidaProceso($id_proceso_compra,$id_solicitud_compra,$tipo);
		$this->salida = $dbSolicitudCompra->salida;
		$this->query = $dbSolicitudCompra->query;
		return $res;
	}
	
	
	function RepAdjudicacionProveedores($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->RepAdjudicacionProveedores($id_proceso_compra,$tipo);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	
	function RepAdjudicacionDet($id_cotizacion,$tipo)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->RepAdjudicacionDet($id_cotizacion,$tipo);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
		return $res;
	}
	
	function ListarCotizacionAdjudicada($id_proceso_compra,$tipo)
	{
		$this->salida = "";
		$dbAdjudicacion= new cls_DBAdjudicacion($this->decodificar);
		$res = $dbAdjudicacion->ListarCotizacionAdjudicada($id_proceso_compra,$tipo);
		$this->salida = $dbAdjudicacion->salida;
		$this->query = $dbAdjudicacion->query;
//		echo $this->query;
//		exit;
		return $res;
	}
	/// --------------------- fin adjudicacion --------------------- ///	
	
	/// --------------------- vad_proveedor --------------------- ///

	function ListarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ListarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ContarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ContarProveedorVista($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ListarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ListarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	function ContarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedor = new cls_DBProveedor($this->decodificar);
		$res = $dbProveedor ->ContarProveedorVista2($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedor ->salida;
		$this->query = $dbProveedor ->query;
		return $res;
	}
	
	/// --------------------- tad_comprador --------------------- ///

	function ListarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador ->ListarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	function ContarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador ->ContarComprador($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	function InsertarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador ->InsertarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	function ModificarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador ->ModificarComprador($id_comprador,$id_empleado,$fecha_asignacion,$estado,$id_depto);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	function EliminarComprador($id_comprador)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador -> EliminarComprador($id_comprador);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	function ValidarComprador($operacion_sql,$id_comprador,$id_empleado,$fecha_asignacion,$estado)
	{
		$this->salida = "";
		$dbComprador = new cls_DBComprador($this->decodificar);
		$res = $dbComprador ->ValidarComprador($operacion_sql,$id_comprador,$id_empleado,$fecha_asignacion,$estado);
		$this->salida = $dbComprador ->salida;
		$this->query = $dbComprador ->query;
		return $res;
	}
	
	/// --------------------- fin tad_comprador --------------------- ///
	
	/// --------------------- tad_tipo_servicio_cuenta_partida --------------------- ///
	function ListarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida ->ListarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	
	function ContarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida ->ContarTipoServicioCuentaPartida($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	
	function InsertarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida ->InsertarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	
	function ModificarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida ->ModificarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_servicio,$id_auxiliar,$id_presupuesto);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	
	function EliminarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida -> EliminarTipoServicioCuentaPartida($id_tipo_servicio_cuenta_partida);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	
	function ValidarTipoServicioCuentaPartida($operacion_sql,$id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_tipo_servicio)
	{
		$this->salida = "";
		$dbTipoServicioCuentaPartida = new cls_DBTipoServicioCuentaPartida($this->decodificar);
		$res = $dbTipoServicioCuentaPartida ->ValidarTipoServicioCuentaPartida($operacion_sql,$id_tipo_servicio_cuenta_partida,$id_cuenta,$id_partida,$id_gestion,$gestion,$fecha_reg,$id_tipo_servicio);
		$this->salida = $dbTipoServicioCuentaPartida ->salida;
		$this->query = $dbTipoServicioCuentaPartida ->query;
		return $res;
	}
	/// --------------------- fin tad_tipo_servicio_cuenta_partida --------------------- ///
	
	/// --------------------- tad_proveedor_cuenta_auxiliar --------------------- ///

	function ListarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->ListarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	function ContarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->ContarProveedorCuentaDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	function InsertarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->InsertarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	function ModificarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->ModificarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$tipo,$id_cuenta_anticipo,$id_cuenta_garantia,$id_cuenta_descuento,$id_cuenta_multa);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	function EliminarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar -> EliminarProveedorCuentaDetalle($id_proveedor_cuenta_auxiliar);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	function ValidarProveedorCuentaDetalle($operacion_sql,$id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$id_cuenta_anticipo,$id_cuenta_garantia)
	{
		$this->salida = "";
		$dbProveedorCuentaAuxiliar = new cls_DBProveedorCuentaAuxiliar($this->decodificar);
		$res = $dbProveedorCuentaAuxiliar ->ValidarProveedorCuentaDetalle($operacion_sql,$id_proveedor_cuenta_auxiliar,$id_proveedor,$id_cuenta,$id_auxiliar,$id_gestion,$id_cuenta_anticipo,$id_cuenta_garantia);
		$this->salida = $dbProveedorCuentaAuxiliar ->salida;
		$this->query = $dbProveedorCuentaAuxiliar ->query;
		return $res;
	}
	
	
	function ListarSolicitantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarSolicitantes($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	
	function ListarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ListarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	function ContarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra)
	{
		$this->salida = "";
		$dbProcesoCompra = new cls_DBProcesoCompra($this->decodificar);
		$res = $dbProcesoCompra ->ContarSolicitudProcesoFin($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_proceso_compra);
		$this->salida = $dbProcesoCompra ->salida;
		$this->query = $dbProcesoCompra ->query;
		return $res;
	}
	
	/// --------------------- tad_detalle_propuesta --------------------- ///
	function ListarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta ->ListarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function ContarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta ->ContarDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function InsertarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta ->InsertarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function ModificarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta ->ModificarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado,$estado,$garantia,$observaciones,$id_unidad_medida_base);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function EliminarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta -> EliminarDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function SelecAdjDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta -> SelecAdjDetallePropuesta($id_detalle_propuesta,$id_cotizacion_det);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
	function ValidarDetallePropuesta($operacion_sql,$id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado)
	{
		$this->salida = "";
		$dbDetallePropuesta = new cls_DBDetallePropuesta($this->decodificar);
		$res = $dbDetallePropuesta ->ValidarDetallePropuesta($operacion_sql,$id_detalle_propuesta,$id_cotizacion_det,$id_item,$id_servicio,$precio,$cantidad,$nombre,$descripcion,$fecha_reg,$id_item_solicitado,$id_servicio_solicitado);
		$this->salida = $dbDetallePropuesta ->salida;
		$this->query = $dbDetallePropuesta ->query;
		return $res;
	}
	
		/// --------------------- tcuadro_comparativo --------------------- ///
 
	function ListarCCItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)	{
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCProveedores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCProveedores($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCProveedoresOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCProveedoresOfertas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCProveedoresDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCProveedoresDetallePropuesta($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)	{
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCProveedoresServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCProveedoresServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	function ListarCCProveedoresDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbCuadroComparativo = new cls_DBCuadroComparativo($this->decodificar);
		$res = $dbCuadroComparativo ->ListarCCProveedoresDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCuadroComparativo ->salida;
		$this->query = $dbCuadroComparativo ->query;
		return $res;
	}
	//reporte de solicitudes por unidades organizacionales
	
	function ListarUOCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbReporteUOSol = new cls_DBReporteUOSol($this->decodificar);
		$res = $dbReporteUOSol ->ListarUOCab($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteUOSol ->salida;
		$this->query = $dbReporteUOSol ->query;
		return $res;
	}
	function ListarUOItems($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbReporteUOSol = new cls_DBReporteUOSol($this->decodificar);
		$res = $dbReporteUOSol ->ListarUOItems($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteUOSol ->salida;
		$this->query = $dbReporteUOSol ->query;
		return $res;
	}
	function ListarUOServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbReporteUOSol = new cls_DBReporteUOSol($this->decodificar);
		$res = $dbReporteUOSol ->ListarUOServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteUOSol ->salida;
		$this->query = $dbReporteUOSol ->query;
		return $res;
	}
	
	function ListarUOPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad){
		$this->salida = "";
		$dbReporteUOSol = new cls_DBReporteUOSol($this->decodificar);
		$res = $dbReporteUOSol ->ListarUOPartidas($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbReporteUOSol ->salida;
		$this->query = $dbReporteUOSol ->query;
		return $res;
	}
	
	
	function ListarNumSolEPUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> ListarNumSolEPUO($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	function GetIdCotOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion -> GetIdCotOrdenCompra($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	/*Reporte solicitudes estados tiempos */
	function ListarSolEstadosTiemposDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq)
	{
		$this->salida = "";
		$dbRepSolicitudesTiemposEstados = new cls_DBRepSolicitudesTiemposEstados($this->decodificar);
		$res = $dbRepSolicitudesTiemposEstados -> ListarSolEstadosTiemposDetalle($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq);
		$this->salida = $dbRepSolicitudesTiemposEstados ->salida;
		$this->query = $dbRepSolicitudesTiemposEstados ->query;
		return $res;
	}
	
	
	
	function ListarSolicitudesEstadosTiempos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq)
	{
		$this->salida = "";
		$dbRepSolicitudesTiemposEstados = new cls_DBRepSolicitudesTiemposEstados($this->decodificar);
		$res = $dbRepSolicitudesTiemposEstados -> ListarSolicitudesEstadosTiempos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq);
		$this->salida = $dbRepSolicitudesTiemposEstados ->salida;
		$this->query = $dbRepSolicitudesTiemposEstados ->query;
		return $res;
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**************PLANILLA **************/
	
	
	function ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ListarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPlanilla= new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ContarPlanilla($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPlanilla->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ModificarPlanilla($id_planilla,$observaciones,$fecha_planilla,$id_gestion,$id_periodo,$id_depto_tesoro,$plantilla,$descripcion);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function EliminarPlanilla($id_planilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->EliminarPlanilla($id_planilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function InsertarPlanillaDet($id_planilla,$id_plan_pago,$tipo_plantilla,$fecha_pagado,$num_factura,$fecha_factura,$por_anticipo,$por_retgar,$multas,$obs_descuentos)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanillaDet($id_planilla,$id_plan_pago,$tipo_plantilla,$fecha_pagado,$num_factura,$fecha_factura,$por_anticipo,$por_retgar,$multas,$obs_descuentos);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function EliminarPlanillaDet($id_planilla,$id_plan_pago)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->EliminarPlanillaDet($id_planilla,$id_plan_pago);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function InsertarPlanillaPago($id_planilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->InsertarPlanillaPago($id_planilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	function ImportarPlanilla($id_planilla,$id_plantilla)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->ImportarPlanilla($id_planilla,$id_plantilla);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	function DefinirCuentaTransaccion($id_planilla,$id_cuenta_bancaria,$tipo_cheque)
	{
		$this->salida = "";
		$dbPlanilla = new cls_DBPlanilla($this->decodificar);
		$res = $dbPlanilla ->DefinirCuentaTransaccion($id_planilla,$id_cuenta_bancaria,$tipo_cheque);
		$this->salida = $dbPlanilla ->salida;
		$this->query = $dbPlanilla ->query;
		return $res;
	}
	
	
	
	
	
		/*******************************************************************/
	function ListarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRepSolicitudesTiemposEstados = new cls_DBRepSolicitudesTiemposEstados($this->decodificar);
		$res = $dbRepSolicitudesTiemposEstados -> ListarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRepSolicitudesTiemposEstados ->salida;
		$this->query = $dbRepSolicitudesTiemposEstados ->query;
		return $res;
	}
	
	
	function ContarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbRepSolicitudesTiemposEstados = new cls_DBRepSolicitudesTiemposEstados($this->decodificar);
		$res = $dbRepSolicitudesTiemposEstados -> ContarPrestoEP($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbRepSolicitudesTiemposEstados ->salida;
		$this->query = $dbRepSolicitudesTiemposEstados ->query;
		return $res;
	}
	/*** Reporte Lista Items *******/
	function ListarItemCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarItemCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	function ListarProveedoresItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarProveedoresItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	function ListarServiciosCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarServiciosCaracteristicasCostos($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	function ListarProveedoresServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbItemProveedor = new cls_DBItemProveedor($this->decodificar);
		$res = $dbItemProveedor->ListarProveedoresServicio($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbItemProveedor->salida;
		$this->query = $dbItemProveedor->query;
		return $res;
	}
	
	/**Partida Vobo**/
	function ListarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->ListarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function ContarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo ->ContarPartidaVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function InsertarPartidaVobo($id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->InsertarPartidaVobo($id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function ModificarPartidaVobo($id_partida_vobo,$id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->ModificarPartidaVobo($id_partida_vobo,$id_partida,$id_parametro_adquisicion,$estado_reg,$id_vobo_detalle);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function EliminarPartidaVobo($id_partida_vobo)
	{
		$this->salida = "";
		$dbPartidaVobo = new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->EliminarPartidaVobo($id_partida_vobo);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo->query;
		return $res;
	}
	
	
	/*DETALLE VOBO**/
	
	function ListarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->ListarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function ContarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo ->ContarDetalleVobo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function InsertarDetalleVobo($id_depto,$id_empleado,$id_partida_vobo,$estado_reg)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->InsertarDetalleVobo($id_depto,$id_empleado,$id_partida_vobo,$estado_reg);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function ModificarDetalleVobo($id_detalle_vobo,$id_depto,$id_empleado,$id_partida_vobo,$estado_reg)
	{
		$this->salida = "";
		$dbPartidaVobo= new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->ModificarDetalleVobo($id_detalle_vobo,$id_depto,$id_empleado,$id_partida_vobo,$estado_reg);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo ->query;
		return $res;
	}
	
	function EliminarDetalleVobo($id_detalle_vobo)
	{
		$this->salida = "";
		$dbPartidaVobo = new cls_DBPartidaVobo($this->decodificar);
		$res = $dbPartidaVobo->EliminarDetalleVobo($id_detalle_vobo);
		$this->salida = $dbPartidaVobo->salida;
		$this->query = $dbPartidaVobo->query;
		return $res;
	}
	
		/////////////// PRESTACION DE SERVICIOS //////////
	function ListarPrestacionServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		
		$this->salida = "";
		$dbPrestacionServicios = new cls_DBPrestacionServicios($this->decodificar);
		
		$res = $dbPrestacionServicios ->ListarPrestacionServicios($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbPrestacionServicios ->salida;
		$this->query = $dbPrestacionServicios ->query;
		return $res;
	}
	
	
	/////////////// detalle ejecucion //////////
	function ListarDetalleEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id,$estado)
	{
		
		$this->salida = "";
		$dbDetalleEjecucion = new cls_DBDetalleEjecucion($this->decodificar);
		
		$res = $dbDetalleEjecucion ->ListarDetalleEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id,$estado);
		$this->salida = $dbDetalleEjecucion ->salida;
		$this->query = $dbDetalleEjecucion ->query;
		return $res;
	}
	
	function ContarDetalleEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id,$estado)
	{
		
		$this->salida = "";
		$dbDetalleEjecucion = new cls_DBDetalleEjecucion($this->decodificar);
		
		$res = $dbDetalleEjecucion ->ContarDetalleEjecucion($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id,$estado);
		$this->salida = $dbDetalleEjecucion ->salida;
		$this->query = $dbDetalleEjecucion ->query;
		return $res;
	}
	
	function ModificarDetalleEjecucion($id_solicitud_compra_det,$id_partida_ejecucion,$id_adjudicacion,$saldo,$importe_eje_rev,$vista,$id)
	{
		$this->salida = "";
		$dbDetalleEjecucion = new cls_DBDetalleEjecucion($this->decodificar);
		$res = $dbDetalleEjecucion->ModificarDetalleEjecucion($id_solicitud_compra_det,$id_partida_ejecucion,$id_adjudicacion,$saldo,$importe_eje_rev,$vista,$id);
		$this->salida = $dbDetalleEjecucion->salida;
		$this->query = $dbDetalleEjecucion ->query;
		return $res;
	}
	
	
	/*para Activos Fijos*/
	function ListarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ListarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	function ContarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbCotizacion = new cls_DBCotizacion($this->decodificar);
		$res = $dbCotizacion ->ContarCotizacionAF($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbCotizacion ->salida;
		$this->query = $dbCotizacion ->query;
		return $res;
	}
	
	
	
	//6062011
	function ListarSolicitudesEstadosTiemposMon($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq)
	{
		$this->salida = "";
		$dbRepSolicitudesTiemposEstados = new cls_DBRepSolicitudesTiemposEstados($this->decodificar);
		$res = $dbRepSolicitudesTiemposEstados->ListarSolicitudesEstadosTiemposMon($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$id_fina_regi_prog_proy_acti,$id_unidad_organizacional,$fecha_ini,$fecha_fin,$tipo_adq);
		$this->salida = $dbRepSolicitudesTiemposEstados->salida;
		$this->query = $dbRepSolicitudesTiemposEstados->query;
		return $res;
	}
	
	function ListarDevengadosNoPagados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{	
		$this->salida = "";
		$dbSolicitudCompra = new cls_DBRepSolicitudCompra($this->decodificar);
		$res = $dbSolicitudCompra ->ListarDevengadosNoPagados($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbSolicitudCompra ->salida;
		$this->query = $dbSolicitudCompra ->query;
		return $res;
	}

	
}