<?php 
/**
 * Nombre:		  	    documento_iva.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:55:38
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
	echo "var id='$id';";
	echo "var idSub='$idSub';";
//	echo "var vista='$vista';";
    ?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
TiempoEspera:_CP.getConfig().ss_tiempo_espera,
CantFiltros:1,
FiltroEstructura:false,
FiltroAvanzado:fa};
  var result = "";
  var pestana=_CP.getPestana(id);
  var maestro={
	        	vista:'<?php echo utf8_decode($vista);?>',
	        	sw_debito_credito:'<?php echo utf8_decode($sw_debito_credito);?>',
	        	titulo_doc_iva:'<?php echo utf8_decode($titulo_doc_iva);?>'
};
  elemento={pagina:new documento_iva(idContenedor,direccion,paramConfig,maestro),idContenedor:idContenedor};
}
Ext.onReady(main,main);