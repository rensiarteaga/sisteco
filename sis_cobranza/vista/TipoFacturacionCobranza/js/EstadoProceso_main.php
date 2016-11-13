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
				id_tipo_facturacion_cobranza:'<?php echo utf8_decode($id_tipo_facturacion_cobranza);?>',
				nombre_proceso:'<?php echo utf8_decode($nombre_proceso);?>',
				sw_periodo:'<?php echo utf8_decode($sw_periodo);?>',
				sw_banco:'<?php echo utf8_decode($sw_banco);?>'
};
var idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento;
elemento={idContenedor:idContenedor,pagina:new pagina_EstadoProceso(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);