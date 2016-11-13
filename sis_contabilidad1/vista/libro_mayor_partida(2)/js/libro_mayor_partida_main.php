<?php 
/**
 * Nombre:		  	    libro_mayor_main.php
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
	//echo "sadf".$m_nro_cuenta;
//exit

    ?>
var fa=false;

<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
TiempoEspera:_CP.getConfig().ss_tiempo_espera,
CantFiltros:1,
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
			id_partida:'<?php echo utf8_decode( $m_id_partida) ;?>',
			codigo_partida:'<?php echo utf8_decode( $m_codigo_partida) ;?>',
	     	nombre_partida:'<?php echo utf8_decode($m_nombre_partida);?>',
	     	desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
	     	fecha_inicio:'<?php echo utf8_decode($m_fecha_inicio);?>',
	     	fecha_fin:'<?php echo utf8_decode($m_fecha_fin);?>',
	     	desc_depto:'<?php echo utf8_decode($m_desc_depto);?>',
	     	id_depto:'<?php echo utf8_decode($m_id_depto);?>',
	     	id_fina_regi_prog_proy_acti:'<?php echo utf8_decode($m_id_fina_regi_prog_proy_acti);?>',
	     	desc_ep:'<?php echo utf8_decode($m_desc_ep);?>',
	     	id_presupuesto:'<?php echo utf8_decode($m_id_presupuesto);?>',
	     	desc_presupuesto:'<?php echo utf8_decode($m_desc_presupuesto);?>'
};

 idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new paginaLibroMayorPartida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}

Ext.onReady(main,main);