<?php 
/**
 * Nombre:		  	    plan_pago_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-28 17:32:19
 *
 */
session_start();
?>
//<script>
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
var tipoP={<?php echo "$tipoP";?>};
var maestro={id_cotizacion:<?php echo $m_id_cotizacion;?>,observaciones:'<?php echo $m_observaciones;?>',num_proceso:'<?php echo $m_num_proceso;?>',desc_proveedor:'<?php echo $m_desc_proveedor;?>',estado_vigente:'<?php echo $m_estado_vigente;?>',moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>'),num_pagos:<?php echo $m_num_pagos;?>,id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,factura_total:'<?php echo $m_factura_total;?>',desc_moneda:'<?php echo $m_desc_moneda;?>',tipo_plantilla:'<?php echo $m_tipo_plantilla;?>'};
var idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_plan_pago(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

