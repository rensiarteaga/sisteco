<?php 
/**
 * Nombre:		  	    formulacion_presupuesto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:14
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var prestoConfig=
{s_tipo_pres:'<?php echo $s_tipo_pres;?>',
tipo_vista:'<?php echo $tipo_vista;?>',
estado_gral:'<?php echo $estado_gral;?>',
sw_colectivo:'<?php echo $sw_colectivo;?>',
sw_usuario:'<?php echo $sw_usuario;?>'};

 

var elemento={pagina:new pagina_presupuesto_vigente(idContenedor,direccion,paramConfig,prestoConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);