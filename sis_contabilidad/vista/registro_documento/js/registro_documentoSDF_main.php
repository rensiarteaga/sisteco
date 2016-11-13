<?php
/**
 * Nombre:		  	    registro_documento_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
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

var maestro={
	id_transaccion:<?php echo $m_id_transaccion;?>,
	desc_comprobante:'<?php echo ($m_desc_comprobante);?>',
	concepto_tran:'<?php echo ($m_concepto_tran);?>',
	desc_cuenta:'<?php echo ($m_desc_cuenta);?>',
	desc_auxiliar:'<?php echo ($m_desc_auxiliar);?>',
	desc_partida:'<?php echo ($m_desc_partida);?>',
	id_moneda:<?php echo ($m_id_moneda);?>,
	desc_moneda:'<?php echo ($m_desc_moneda);?>',
	id_parametro:<?php echo ($m_id_parametro);?>,
	importe_debe:<?php echo ($m_importe_debe);?>,
	importe_haber:<?php echo($m_importe_haber);?>

};

var idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento;
elemento={idContenedor:idContenedor,pagina:new pagina_registro_documentoCCf(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};


//else { elemento={idContenedor:idContenedor,pagina:new pagina_registro_documento(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};}

_CP.setPagina(elemento);
}
Ext.onReady(main,main);