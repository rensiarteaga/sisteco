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
var paramConfig={TiempoEspera:10000};
var maestro={ id_cotizacion:'<?php echo $m_id_cotizacion;?>',
				precio_total_adjudicado:'<?php echo $m_precio_total_adjudicado;?>',
				total_aa:'<?php echo $m_total_aa;?>',
				total_as:'<?php echo $m_total_as;?>'
              
             };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new PagoAS(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);