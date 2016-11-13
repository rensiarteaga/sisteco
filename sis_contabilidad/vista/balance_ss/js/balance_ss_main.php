<?php
/**
 * Nombre:		  	    balance_ss.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				AVQ
 * Fecha creación:		2009-06-18 15:32:06
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
var paramConfig={TamanoPagina:1000,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
			tipo_pres:'<?php echo utf8_decode( $tipo_pres) ;?>',
	     	id_parametro:'<?php echo utf8_decode($id_parametro);?>',
	     	id_moneda:'1',
	     	desc_moneda:'Bolivianos',
	     	gestion_pres:'<?php echo utf8_decode($gestion_pres);?>',
	     	desc_pres:'<?php echo utf8_decode($desc_pres);?>',
	     	sw_vista:'<?php echo utf8_decode($sw_vista);?>',
	     	desc_estado_gral:'<?php echo utf8_decode($desc_estado_gral);?>'
	     	
};
 
 
idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new paginaBalanceSS(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);