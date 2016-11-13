<?php 
/**
 * Nombre:		  	    seguimiento_solicitud_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
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
    echo "var tipo='$tipo';";
    echo "var id_empleado=$id_empleado;";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_verificacion_presupuestaria_bien(idContenedor,direccion,paramConfig,tipo,id_empleado),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);