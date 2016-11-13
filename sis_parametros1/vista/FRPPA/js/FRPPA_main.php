<?php 
/**
 * Nombre:		  	    FRPPA_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 11:34:02
 *
 */
session_start();
?>
//<script>
//var paginaFRPPA;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:0,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	    	id_asignacion_estructura:'<?php echo $m_id_asignacion_estructura;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={pagina:new pagina_FRPPA(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
