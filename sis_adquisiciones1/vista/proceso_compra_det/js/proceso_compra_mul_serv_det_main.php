<?php
/**
 * Nombre:		  	    proceso_compra_mul_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		2008-05-20 17:42:42
 *
 */
session_start();
?>
//<script>
var pProServMul;
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

	
	pProServMul= new pagina_proceso_compra_mul_serv_det(idContenedor,direccion,paramConfig);
var elemento={idContenedor:idContenedor,pagina:pProServMul};
_CP.setPagina(elemento)
}
Ext.onReady(main,main);