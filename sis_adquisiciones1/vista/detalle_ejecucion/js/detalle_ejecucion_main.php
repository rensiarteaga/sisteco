<?php 
/**
 * Nombre:		  	    recibo_caja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Grover Velasquez Colque
 * Fecha creación:		2009-10-27 11:50:07
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
    echo "var m_vista='$vista';";
    echo "var m_id=$id;";
	?>
var fa=false;
var m={vista:m_vista,id:m_id};
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_detalle_ejecucion(idContenedor,direccion,paramConfig,m),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);