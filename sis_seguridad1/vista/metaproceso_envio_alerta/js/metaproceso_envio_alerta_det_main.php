<?php
/**
 * Nombre:		  	    metaproceso_envio_alerta_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 09:09:28
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
	var fa;
	<?php
	if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	     	id_envio_alerta:<?php echo $m_id_envio_alerta;?>,nombre_alerta:'<?php echo $m_nombre_alerta;?>',titulo_mensaje:'<?php echo $m_titulo_mensaje;?>',mensaje:'<?php echo $m_mensaje;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_metaproceso_envio_alerta_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);