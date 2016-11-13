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

//var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
var paramConfig={TamanoPagina:100,
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
			id_cuenta:'<?php echo utf8_decode( $m_id_cuenta) ;?>',
			nro_cuenta:'<?php echo utf8_decode( $m_nro_cuenta) ;?>',
	     	nombre_cuenta:'<?php echo utf8_decode($m_nombre_cuenta);?>',
	     	desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
	     	fecha_inicio:'<?php echo utf8_decode($m_fecha_inicio);?>',
	     	fecha_fin:'<?php echo utf8_decode($m_fecha_fin);?>',
	     	id_depto:'<?php echo utf8_decode($m_id_depto);?>',
	     	nombre_depto:'<?php echo utf8_decode($m_nombre_depto);?>',
	     	cuenta_ini:'<?php echo utf8_decode( $m_cuenta_ini) ;?>',
	     	cuenta_fin:'<?php echo utf8_decode( $m_cuenta_fin) ;?>',
	     	por_rango:'<?php echo utf8_decode( $m_por_rango) ;?>',
	     	id_gestion:'<?php echo utf8_decode( $m_id_gestion) ;?>'
};

 idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new paginaLibroMayor(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}

Ext.onReady(main,main);