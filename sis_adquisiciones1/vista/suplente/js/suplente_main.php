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
var maestro={ id_empleado:'<?php echo $m_id_empleado;?>',
				subsis:'<?php echo $m_subsis;?>',
				vista:'<?php echo $m_vista;?>',
				id_rol:'<?php echo $m_id_rol;?>',
				nom_usuario:'<?php echo $m_nom_usuario?>'
              };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new Suplente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);