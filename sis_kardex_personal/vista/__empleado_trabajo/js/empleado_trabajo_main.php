<?php 
/**
 * Nombre:		  	    empleado_trabajo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		02-09-2010
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
	    echo "var busqueda='$busqueda';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){
	echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var elemento={idContenedor:idContenedor,pagina:new pagina_empleado_trabajo(idContenedor,direccion,paramConfig,busqueda)};
_CP.setPagina(elemento);

}
Ext.onReady(main,main);