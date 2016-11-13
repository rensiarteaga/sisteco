<?php
function crearArchivo_VistaMainHijo($direccion,$db,$table,$prefijo,$codigo,$meta,$datos_generales){
	$num_campos = sizeof($meta); //cantidad de columnas que tiene la tabla
	$fecha=date("Y-m-d H:i:s");
	$fp_handler=fopen("$direccion/".$table."_det_main.php","w+");
	//datos del padre
	$padre=$datos_generales["datos_abuelo"];

	$sql = "<?php 
/**
 * Nombre:		  	    ".$table."_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
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
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo \$_SESSION[\"ss_filtro_avanzado\"];?>};\n";
	
		
		$table_padre=$padre["nombre_tabla"];
		$prefijo_padre=$padre["prefijo"];
		$meta_padre=metadata($db,$prefijo_padre,$table_padre);
		$id_table_padre = $meta_padre[0]["campo"];
		$table_padre=$padre["nombre_tabla"];
		$aux = $meta_padre[0]["descripcion_tabla"];
		$descripcion_tabla_padre= decodificarForamto($aux);
		$sistema_padre=$descripcion_tabla_padre["sistema"];
			

	$sql.="var maestro={
	     	$id_table_padre:<?php echo \$m_$id_table_padre;?>,";
			
			//definicion de los datos del padre que seran transmitidos al hijo
			for($j=1;$j<=$descripcion_tabla_padre["num_dt"]-1;$j++){
					$sql.=$descripcion_tabla_padre["dt_$j"].":'<?php echo \$m_".$descripcion_tabla_padre["dt_$j"].";?>',";
				} 
			$sql.=$descripcion_tabla_padre["dt_$j"].":'<?php echo \$m_".$descripcion_tabla_padre["dt_$j"].";?>'};
idContenedorPadre='<?php echo \$idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_".$table."_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
}
Ext.onReady(main,main);";

	fwrite($fp_handler,$sql);
	fclose($fp_handler);
}
?>