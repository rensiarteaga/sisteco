<?php
/**
 * Nombre:		  	    cotizacion_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-28 17:32:14
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
var maestro={id_cotizacion:<?php echo $m_id_cotizacion;?>,observaciones:'<?php echo $m_observaciones;?>',num_proceso:'<?php echo $m_num_proceso;?>',desc_proveedor:'<?php echo $m_desc_proveedor;?>',estado_vigente:'<?php echo $m_estado_vigente;?>',moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>'),id_moneda:'<?php echo $m_id_moneda;?>',id_moneda_base:'<?php echo $m_id_moneda_base;?>',id_proveedor:'<?php echo $m_id_proveedor;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_cotizacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);