<?php
/**
 * Nombre:		  	    salida_detalle_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 09:38:41
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var maestro={id_salida:<?php echo $m_id_salida;?>,descripcion:'<?php echo $m_descripcion;?>',id_almacen_logico:'<?php echo $m_id_almacen_logico;?>'};
	var	elemento={idContenedor:idContenedor,pagina:new pagina_salida_pedido_detalle_emergencia(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);