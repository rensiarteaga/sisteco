<?php 
session_start();
?>
//<script>
var paginaArchivoFac;


function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
	echo "var idContenedor='$idContenedor';";
	
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
	//alert(idContenedor);
	
	var elemento={pagina:new pagina_preferencia(idContenedor,direccion,paramConfig),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

