<?php
/**
 * Nombre:		  	    tipo_unidad_cons_reemp_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Anacleto Rojas
 * Fecha creación:		2007-11-07 
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:fa
};
var maestro={
	id_padre:'<?php echo $maestro_id_padre;?>',
	id_unidad_organizacional:'<?php echo $maestro_id_unidad_organizacional;?>',
	nombre_cargo:'<?php echo $maestro_nombre_cargo;?>',
	nombre_unidad:'<?php echo $maestro_nombre_unidad;?>',
	cargo_individual:'<?php echo $maestro_cargo_individual;?>'
};
var elemento={idContenedor:idContenedor,pagina:new pagina_historico_asignacion_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);