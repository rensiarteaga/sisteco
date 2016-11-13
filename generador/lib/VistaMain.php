<?php
function crearArchivo_VistaMain($direccion,$table,$prefijo,$codigo,$meta){



	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table."_main.php","w+");

	$sql = "<?php 
/**
 * Nombre:		  	    ".$table."_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		$fecha
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		\$host  = \$_SERVER['HTTP_HOST'];
		\$uri  = rtrim(dirname(\$_SERVER['PHP_SELF']), '/\\\');
		\$dir = \"http://\$host\$uri/\";
		echo \"\\nvar direccion='\$dir';\";
	    echo \"var idContenedor='\$idContenedor';\";
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo \$_SESSION[\"ss_filtro_avanzado\"];?>};
var elemento={pagina:new pagina_$table(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>