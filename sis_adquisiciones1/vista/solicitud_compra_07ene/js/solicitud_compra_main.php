<?php 
/**
 * Nombre:		  	    solicitud_compra_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 09:11:12
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
    //echo "id_usuario='$id_usuario';";
    
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:2,FiltroEstructura:true,FiltroAvanzado:fa};
var usuario={
	    	id_usuario:<?php echo $_SESSION['ss_id_usuario'];?>,id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,id_empleado:<?php echo $_SESSION['ss_id_empleado'];?>,lugar:"<?php echo $_SESSION['ss_nombre_lugar'];?>"}
var elemento={pagina:new pagina_solicitud_compra(idContenedor,direccion,usuario,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);


}
Ext.onReady(main,main);