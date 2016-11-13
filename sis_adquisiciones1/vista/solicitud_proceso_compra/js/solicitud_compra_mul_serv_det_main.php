<?php
/**
 * Nombre:		  	    solicitud_compra_serv_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		2008-05-16 09:53:33
 *
 */
session_start();
?>
//<script>
var pSolServMul;
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
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	pSolServMul=new p_sco_mul_serv_det(idContenedor,direccion,paramConfig,idContenedorPadre);
	var elemento={idContenedor:idContenedor,pagina:pSolServMul};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);
