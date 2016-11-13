<?php 
/**
 * Nombre:		  	    parametro_almacen_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Rensi Arteaga Copari
 * Fecha creación:		2007-10-18 15:38:46
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
	    echo "var idContenedor='".$_GET["idContenedor"]."';";
	?>	

var elemento={
	pagina:new _usuario(idContenedor)

};

elemento.pagina.init()


}
Ext.onReady(main,main);