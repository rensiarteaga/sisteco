//<script>
<?php session_start(); ?>
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

/*var maestro={
	nro_orden_compra:'<?php echo $m_nro_orden_compra;?>',
	periodo:'<?php echo $m_periodo;?>',
    id_gestion:'<?php echo $m_id_gestion;?>',
    id_departamento:'<?php echo $m_id_departamento;?>', 
    id_tipo_adquisicion:'<?php echo $m_id_tipo_adquisicion;?>'
    }*/

var elemento={pagina:new pagina_listado_procesos(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);