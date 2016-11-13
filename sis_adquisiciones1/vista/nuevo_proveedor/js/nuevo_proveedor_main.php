//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={//TiempoEspera:10000

/*TamanoPagina:_CP.getConfig().ss_tam_pag,
	TiempoEspera:_CP.getConfig().ss_tiempo_espera,
	CantFiltros:1,
	FiltroEstructura:false*/
};
var elemento={pagina:new PaginaNuevoProveedor(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
//_CP.setPagina(elemento);
}
Ext.onReady(main,main);