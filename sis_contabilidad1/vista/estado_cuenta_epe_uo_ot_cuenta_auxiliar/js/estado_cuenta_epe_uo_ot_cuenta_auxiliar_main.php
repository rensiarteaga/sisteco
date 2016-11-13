<?php
/**
 * Nombre:		  	    detalle_partida_formulacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
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
	    echo "var idSub='$idSub';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:30,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:3,FiltroEstructura:false,FiltroAvanzado:fa,idSub:idSub};
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
var elemento={idContenedor:idContenedor,pagina:new paginaEstadoCuentaEpeUoOtCuentaAuxiliar(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);