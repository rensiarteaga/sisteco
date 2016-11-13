<?php 
/**
 * Nombre:		  	    empleado_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
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
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){
	echo 'fa='.$_SESSION["ss_filtro_avanzado"].';'; 
	}?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:2,FiltroEstructura:false,FiltroAvanzado:fa, tipo:tipo}; 
var elemento={pagina:new pagina_empleado(idContenedor,direccion,paramConfig,tipo),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);