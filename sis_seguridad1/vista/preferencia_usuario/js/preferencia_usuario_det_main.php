<?php
/**
 * Nombre:		  	    preferencia_usuario_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-29 15:55:31
 *
 */
session_start();
?>
//<script>
var pagina_preferencia_usuario_det;

	function main(){
	 	<?php
	 
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
	     	id_usuario:<?php echo $m_id_usuario;?>,id_persona:'<?php echo $m_id_persona;?>',apellido_paterno:'<?php echo $m_apellido_paterno;?>',apellido_materno:'<?php echo $m_apellido_materno;?>',nombre:'<?php echo $m_nombre;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_preferencia_usuario_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);