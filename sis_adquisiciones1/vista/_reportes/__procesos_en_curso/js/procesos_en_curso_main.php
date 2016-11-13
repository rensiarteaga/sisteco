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
	/*echo $_SESSION['ss_id_empleado'];
exit;*/
	?>

var paramConfig={TiempoEspera:10000};

var empleado={
	id_empleado:<?php echo $_SESSION['ss_id_empleado'];?>,
	 nombre_empleado:'<?php echo $_SESSION['ss_nombre_empleado'];?>',
    paterno_empleado:'<?php echo $_SESSION["ss_paterno_empleado"];?>',
    materno_empleado:'<?php echo $_SESSION["ss_materno_empleado"];?>', 
    id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,
    id_usuario:<?php echo $_SESSION['ss_id_usuario'];?>,
    nombre_usuario:_CP.getConfig().ss_nombre_usuario,
    lugar:"<?php echo $_SESSION['ss_nombre_lugar'];?>"
    }

var elemento={pagina:new pagina_procesos_en_curso(idContenedor,direccion,empleado,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);