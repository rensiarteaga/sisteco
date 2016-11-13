<?php
/**
 * Nombre:		  	    caracteristica_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 09:57:27
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

<?if($m_id_solicitud_compra_det>0) {?>
var maestro={id_solicitud_compra_det:<?echo $m_id_solicitud_compra_det;?>,id_detalle:'<? echo $m_id_detalle;?>'}
<?}else{?>
    var maestro={id_solicitud_compra_det:<?php echo $m_id_solicitud_compra_det;?>,id_servicio_propuesto:<?php echo $m_id_servicio_propuesto;?>,id_item_propuesto:<?php echo $m_id_item_propuesto;?>,nombre:decodeURIComponent('<?php echo $m_nombre;?>'),descripcion:'<?php echo $m_descripcion;?>'};
    <?}?>
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_caracteristica_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);