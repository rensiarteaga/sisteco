<?php 
/**
 * Nombre:		  	    libro_diario_main.php
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
	        id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
			fecha_inicio:'<?php echo utf8_decode($m_fecha_inicio);?>',
	     	fecha_fin:'<?php echo utf8_decode($m_fecha_fin);?>',
	     	desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
	     	id_depto:'<?php echo utf8_decode($m_id_depto);?>',
	     	codigo_depto:'<?php echo utf8_decode($m_codigo_depto);?>'
};
elemento={pagina:new pagina_documento_iva_ventas_det(idContenedor,direccion,paramConfig,maestro),idContenedor:idContenedor};
}
Ext.onReady(main,main);