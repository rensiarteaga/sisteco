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
CantFiltros:2,
FiltroEstructura:false,
FiltroAvanzado:fa};
//alert(frame);

  var result = "";
  //var pestana=_CP.getSubPestana(id,idSub);
  var pestana=_CP.getPestana(id);
/*var obj=_CP.getSubPestana(id,idSub);
  for (var i in obj)
  {  result += "pestaña  " + "." + i + 
          " = " + obj[i] + "\n"
  alert(result);
  }*/
var maestro={
	        id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
			id_depto:'<?php echo utf8_decode( $m_id_depto) ;?>',
	     	fecha_inicio:'<?php echo utf8_decode($m_fecha_inicio);?>',
	     	fecha_fin:'<?php echo utf8_decode($m_fecha_fin);?>',
	     	nombre_depto:'<?php echo utf8_decode($m_nombre_depto);?>'
	     	
};
 
elemento={pagina:new pagina_libro_diario(idContenedor,direccion,paramConfig,maestro),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
//_CP.setPagina(elemento);



}

Ext.onReady(main,main);