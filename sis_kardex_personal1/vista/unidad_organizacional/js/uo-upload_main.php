//<script>
<?php session_start(); ?>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var maestro={
		id_unidad_organizacional:<?php echo $id_unidad_organizacional;?>
		}
var idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={
	pagina:new pagina_uo_upload(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),
	idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);