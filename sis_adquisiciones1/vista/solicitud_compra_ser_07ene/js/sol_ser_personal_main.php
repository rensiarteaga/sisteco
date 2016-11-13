<?php 
/**
 * Nombre:		  	    solicitud_compra_personal_main.php
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
    echo "id_usuario='$id_usuario';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var empleado={
	    	id_empleado:<?php echo $_SESSION['ss_id_empleado'];?>, nombre_empleado:'<?php echo $_SESSION['ss_nombre_empleado'];?>',paterno_empleado:'<?php echo $_SESSION["ss_paterno_empleado"];?>', materno_empleado:'<?php echo $_SESSION["ss_materno_empleado"];?>', id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,id_usuario:<?php echo $_SESSION['ss_id_usuario'];?>, nombre_usuario:_CP.getConfig().ss_nombre_usuario,lugar:"<?php echo $_SESSION['ss_nombre_lugar'];?>"}
var elemento={pagina:new pag_sol_ser_personal(idContenedor,direccion,empleado,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);


}
Ext.onReady(main,main);