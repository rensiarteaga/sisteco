<?php
/**
 * Nombre:		  	    empleado_planilla_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2010-08-27 14:34:08
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
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var maestro={id_planilla:<?php if($id_planilla) {echo $id_planilla;} else {echo '0';}?>,vista_doble:'<?php if($vista_doble=='si'){echo 'si';} else{echo 'no';}?>'};

var elemento={idContenedor:idContenedor,pagina:new pagina_columna_partida_ejecucion(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);