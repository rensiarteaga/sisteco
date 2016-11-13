<?php
/**
 * Nombre:		  	    solicitud_proceso_compra_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-19 15:28:40
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};

var maestro={
	 id_proceso_compra:<?php echo $m_id_proceso_compra;?>,
	 id_tipo_categoria_adq:'<?php echo $m_id_tipo_categoria_adq;?>',
	 codigo_proceso:'<?php echo $m_codigo_proceso;?>',
	 id_moneda:'<?php echo $m_id_moneda;?>',
	 id_tipo_adq:'<?php echo $m_id_tipo_adq;?>',
	 desc_moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>'),
	 desc_tipo_adq:decodeURIComponent('<?php echo $m_desc_tipo_adq;?>'),
	 gestion:'<?php echo $m_gestion;?>',
	 id_gestion:<?php echo $m_id_gestion;?>,
	 id_parametro_adquisicion:<?php echo $m_id_parametro_adquisicion;?>,
	 id_depto:<?php echo $m_id_depto;?>,
	 norma:'<?php echo $m_norma;?>'
};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pag_sol_pro_serv(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);