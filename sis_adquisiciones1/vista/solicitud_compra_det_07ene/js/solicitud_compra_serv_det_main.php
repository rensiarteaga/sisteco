<?php
/**
 * Nombre:		  	    solicitud_compra_serv_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_solicitud_compra:<?php echo $m_id_solicitud_compra;?>,num_solicitud:<?php echo $m_num_solicitud;?>, localidad:'<?php echo $m_localidad;?>',solicitante:'<?php echo $m_solicitante;?>',id_tipo_adq:'<?php echo $m_id_tipo_adq;?>',tipo_adq:'<?echo$m_tipo_adq;?>',simbolo:'<?echo$m_simbolo;?>',fecha_reg:'<?echo $m_fecha_reg;?>',tipo_cambio:'<?echo $m_tipo_cambio;?>',id_moneda:'<?echo $m_id_moneda;?>',id_moneda_base:'<?echo $m_id_moneda_base;?>',id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,avance:'<?echo $m_avance;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_solicitud_compra_serv_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);