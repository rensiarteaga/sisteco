<?php
/**
 * Nombre:		  	    proceso_compra_mul_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-20 17:42:42
 *
 */
session_start();
?>
//<script>
var pProItemMul;
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
var maestro={
	id_proceso_compra:<?php echo $m_id_proceso_compra;?>,
	codigo_proceso:decodeURIComponent('<?php echo $m_codigo_proceso;?>'),
	desc_moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>'),
	desc_tipo_adq:decodeURIComponent('<?php echo $m_desc_tipo_adq;?>'),
	id_moneda:<?php echo $m_id_moneda;?>,}
	idContenedorPadre='<?php echo $idContenedorPadre;?>';

	pProItemMul=new p_proceso_compra_mul_item_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
	var elemento={idContenedor:idContenedor,pagina:pProItemMul};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);