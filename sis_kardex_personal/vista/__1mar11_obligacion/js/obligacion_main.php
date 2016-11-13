<?php 
/**
 * Nombre:		  	    afp_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_planilla:<?php echo $id_planilla;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={pagina:new pagina_obligacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);


}
Ext.onReady(main,main);