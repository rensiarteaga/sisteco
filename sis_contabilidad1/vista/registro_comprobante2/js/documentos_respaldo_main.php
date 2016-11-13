<?php 
/**
 * Nombre:		  	    documentos_respaldo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				AVQ
 * Fecha creación:		2009-05- 11:32:38
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
	//echo "sadf".$m_nro_cuenta;
//exit

    ?>
var fa=false;

<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
TiempoEspera:_CP.getConfig().ss_tiempo_espera,
CantFiltros:2,
FiltroEstructura:false,
FiltroAvanzado:fa};


  var result = "";
  //var pestana=_CP.getSubPestana(id,idSub);
  var pestana=_CP.getPestana(id);

var maestro={
	        id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
			id_comprobante:'<?php echo utf8_decode( $m_id_comprobante) ;?>',
			desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
			acreedor:'<?php echo utf8_decode($m_acreedor);?>', 
	     	pedido:'<?php echo utf8_decode($m_pedido);?>', 
	     	concepto_cbte:'<?php echo utf8_decode($m_concepto_cbte);?>', 
	     	conformidad:'<?php echo utf8_decode($m_conformidad);?>', 
	     	aprobacion:'<?php echo utf8_decode($m_aprobacion);?>', 
	     	simbolo_moneda:'<?php echo utf8_decode($m_simbolo_moneda);?>' 
};

 idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new paginaDocumentosRespaldo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}

Ext.onReady(main,main);