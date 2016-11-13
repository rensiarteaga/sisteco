<?php
/**
 * Nombre de la Clase:	    CustomDBalmacenes
 * Propósito:				Interfaz del modelo del Sistema de almacenes
 * 							todos los metodos existentes pasan por aqui
 * Fecha de Creación:		2007-10-30 17:22:18
 * Autor:					(autogenerado)
 *
 */
class cls_CustomDBalmacenes
{
	var $salida = "";
	var $query = "";
	var $decodificar = false;

	function __construct()
	{
		include_once("cls_DBTipoUnidadConstructiva.php");
		include_once("cls_DBComposicionTuc.php");
		include_once("cls_DBTipoUnidadConsReemp.php");
		include_once("cls_DBComponente.php");
		include_once("cls_DBFirmaAutorizadaTransf.php");

	}
	
/// --------------------- tal_tipo_unidad_constructiva --------------------- ///

	function ListarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ListarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function ContarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ContarTipoUnidadConstructiva($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	

	/*************           ARBOLES      ***********************/
	function ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ListarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function ContarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ContarTipoUnidadConstructivaRaiz($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	function ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ListarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function ContarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ContarTipoUnidadConstructivaRama($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	
	function ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ListarTipoUnidadConstructivaItem($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad,$raiz);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	/***************************************************************************************/
	
	
	function InsertarTipoUnidadConstructiva($id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->InsertarTipoUnidadConstructiva($id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function ModificarTipoUnidadConstructiva($id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ModificarTipoUnidadConstructiva($id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function EliminarTipoUnidadConstructiva($id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva -> EliminarTipoUnidadConstructiva($id_tipo_unidad_constructiva);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	function ValidarTipoUnidadConstructiva($operacion_sql,$id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg)
	{
		$this->salida = "";
		$dbTipoUnidadConstructiva = new cls_DBTipoUnidadConstructiva($this->decodificar);
		$res = $dbTipoUnidadConstructiva ->ValidarTipoUnidadConstructiva($operacion_sql,$id_tipo_unidad_constructiva,$codigo,$nombre,$tipo,$descripcion,$observaciones,$fecha_reg);
		$this->salida = $dbTipoUnidadConstructiva ->salida;
		$this->query = $dbTipoUnidadConstructiva ->query;
		return $res;
	}
	
	/// --------------------- fin tal_tipo_unidad_constructiva --------------------- ///

	
	/// --------------------- tal_composicion_tuc --------------------- ///

	function ListarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc ->ListarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	function ContarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc ->ContarComposicionTuc($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	function InsertarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc ->InsertarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	function ModificarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc ->ModificarComposicionTuc($id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	function EliminarComposicionTuc($id_composicion_tuc)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc -> EliminarComposicionTuc($id_composicion_tuc);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	function ValidarComposicionTuc($operacion_sql,$id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComposicionTuc = new cls_DBComposicionTuc($this->decodificar);
		$res = $dbComposicionTuc ->ValidarComposicionTuc($operacion_sql,$id_composicion_tuc,$cantidad,$opcional,$fecha_reg,$id_tuc_hijo,$id_tipo_unidad_constructiva);
		$this->salida = $dbComposicionTuc ->salida;
		$this->query = $dbComposicionTuc ->query;
		return $res;
	}
	
	/// --------------------- fin tal_composicion_tuc --------------------- ///
	
	
	/// --------------------- tal_tipo_unidad_cons_reemp --------------------- ///

	function ListarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ListarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ContarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ContarTipoUnidadConsReemp($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function InsertarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->InsertarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ModificarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ModificarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function EliminarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp -> EliminarTipoUnidadConsReemp($id_tipo_unidad_cons_reemp);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ValidarTipoUnidadConsReemp($operacion_sql,$id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ValidarTipoUnidadConsReemp($operacion_sql,$id_tipo_unidad_cons_reemp,$descripcion,$id_tipo_unidad_constructiva,$id_composicion_tuc);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ListarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ListarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ContarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ContarTipoUnidadConsReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ListarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ListarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	function ContarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbTipoUnidadConsReemp = new cls_DBTipoUnidadConsReemp($this->decodificar);
		$res = $dbTipoUnidadConsReemp ->ContarTUCReemplazo($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbTipoUnidadConsReemp ->salida;
		$this->query = $dbTipoUnidadConsReemp ->query;
		return $res;
	}
	
	
	/// --------------------- fin tal_tipo_unidad_cons_reemp --------------------- ///

	
	/// --------------------- tal_componente --------------------- ///

	function ListarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ListarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ContarComponente($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function InsertarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->InsertarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function ModificarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ModificarComponente($id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	function EliminarComponente($id_componente){
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente -> EliminarComponente($id_componente);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	function EliminarComponenteItemTUC($id_tipo_unidad_constructiva,$id_item){
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente -> EliminarComponenteItemTUC($id_tipo_unidad_constructiva,$id_item);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	
	function ValidarComponente($operacion_sql,$id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva)
	{
		$this->salida = "";
		$dbComponente = new cls_DBComponente($this->decodificar);
		$res = $dbComponente ->ValidarComponente($operacion_sql,$id_componente,$cantidad,$estado_registro,$cosiderar_repeticion,$fecha_reg,$descripcion,$id_item,$id_tipo_unidad_constructiva);
		$this->salida = $dbComponente ->salida;
		$this->query = $dbComponente ->query;
		return $res;
	}
	
	/// --------------------- fin tal_componente --------------------- ///
	
	/// --------------------- tal_firma_autorizada_transf --------------------- ///

	function ListarFirmaAutorizadaTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf ->ListarFirmaAutorizadaTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	function ContarFirmaAutorizadaTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf ->ContarFirmaAutorizadaTransf($cant,$puntero,$sortcol,$sortdir,$criterio_filtro,$id_financiador,$id_regional,$id_programa,$id_proyecto,$id_actividad);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	function InsertarFirmaAutorizadaTransf($id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf ->InsertarFirmaAutorizadaTransf($id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	function ModificarFirmaAutorizadaTransf($id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf ->ModificarFirmaAutorizadaTransf($id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	function EliminarFirmaAutorizadaTransf($id_firma_autorizada_transf)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf -> EliminarFirmaAutorizadaTransf($id_firma_autorizada_transf);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	function ValidarFirmaAutorizadaTransf($operacion_sql,$id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta)
	{
		$this->salida = "";
		$dbFirmaAutorizadaTransf = new cls_DBFirmaAutorizadaTransf($this->decodificar);
		$res = $dbFirmaAutorizadaTransf ->ValidarFirmaAutorizadaTransf($operacion_sql,$id_firma_autorizada_transf,$estado_registro,$fecha_registro,$id_empleado,$id_motivo_ingreso_cuenta,$id_motivo_salida_cuenta);
		$this->salida = $dbFirmaAutorizadaTransf ->salida;
		$this->query = $dbFirmaAutorizadaTransf ->query;
		return $res;
	}
	
	/// --------------------- fin tal_firma_autorizada_transf --------------------- ///
	
}