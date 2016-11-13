<?php
/**
 * Nombre:		  	    detalle_partida_formulacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 *
 */
session_start();


			
			
		//	echo 'tipo_vista'.$tipo_vista.'    $nombre_regional'.$nombre_regional.'  $nombre_programa'.$nombre_programa;
		//	exit;



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


var maestro={		
	
			/*id_presupuesto:decodeURIComponent('<?php echo utf8_decode($id_presupuesto);?>'),
	     	nombre_financiador:decodeURIComponent('<?php echo utf8_decode($nombre_financiador);?>'),
	     	nombre_regional:decodeURIComponent('<?php echo utf8_decode($nombre_regional);?>'),
	     	nombre_programa:decodeURIComponent('<?php echo utf8_decode($nombre_programa);?>'),
	     	nombre_proyecto:decodeURIComponent('<?php echo utf8_decode($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURIComponent('<?php echo utf8_decode($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURIComponent('<?php echo utf8_decode($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURIComponent('<?php echo utf8_decode($tipo_pres);?>'),
			desc_moneda:decodeURIComponent('<?php echo utf8_decode($desc_moneda);?>'),
			id_moneda:decodeURIComponent('<?php echo utf8_decode($id_moneda);?>')*/
			
			/*id_presupuesto:'<?php echo utf8_decode($id_presupuesto);?>',
			id_parametro:'<?php echo utf8_decode($id_parametro);?>',
	     	nombre_financiador:'<?php echo utf8_decode($nombre_financiador);?>',
	     	nombre_regional:'<?php echo utf8_decode($nombre_regional);?>',
	     	nombre_programa:'<?php echo utf8_decode($nombre_programa);?>',
	     	nombre_proyecto:'<?php echo utf8_decode($nombre_proyecto);?>',
	     	nombre_actividad:'<?php echo utf8_decode($nombre_actividad);?>',
	     	desc_unidad_organizacional:'<?php echo utf8_decode($desc_unidad_organizacional);?>',
			tipo_pres:'<?php echo utf8_decode($tipo_pres);?>',
			desc_moneda:'<?php echo utf8_decode($desc_moneda);?>',
			id_moneda:'<?php echo utf8_decode($id_moneda);?>',
			tipo_vista:'<?php echo utf8_decode($tipo_vista);?>'*/
	
	
	

	
			
			id_presupuesto:decodeURI('<?php echo ($id_presupuesto);?>'),
			id_parametro:decodeURI('<?php echo ($id_parametro);?>'),
	     	nombre_financiador:decodeURI('<?php echo ($nombre_financiador);?>'),
	     	nombre_regional:decodeURI('<?php echo ($nombre_regional);?>'),
	     	nombre_programa:decodeURI('<?php echo ($nombre_programa);?>'),
	     	nombre_proyecto:decodeURI('<?php echo ($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURI('<?php echo ($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURI('<?php echo ($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURI('<?php echo ($tipo_pres);?>'),
			desc_moneda:decodeURI('<?php echo ($desc_moneda);?>'),
			id_moneda:decodeURI('<?php echo ($id_moneda);?>'),
			tipo_vista:decodeURI('<?php echo ($tipo_vista);?>')
			
			
			
		/*		id_presupuesto:'<?php echo ($id_presupuesto);?>',
			id_parametro:'<?php echo ($id_parametro);?>',
	     	nombre_financiador:'<?php echo ($nombre_financiador);?>',
	     	nombre_regional:'<?php echo ($nombre_regional);?>',
	     	nombre_programa:'<?php echo ($nombre_programa);?>',
	     	nombre_proyecto:'<?php echo ($nombre_proyecto);?>',
	     	nombre_actividad:'<?php echo ($nombre_actividad);?>',
	     	desc_unidad_organizacional:'<?php echo ($desc_unidad_organizacional);?>',
			tipo_pres:'<?php echo ($tipo_pres);?>',
			desc_moneda:'<?php echo ($desc_moneda);?>',
			id_moneda:'<?php echo ($id_moneda);?>',
			tipo_vista:'<?php echo ($tipo_vista);?>'*/
			
			
			
			/*id_presupuesto:decodeURIComponent('<?php echo utf8_decode($id_presupuesto);?>'),
	     	nombre_financiador:decodeURIComponent('<?php echo utf8_decode($nombre_financiador);?>'),
	     	nombre_regional:decodeURIComponent('<?php echo utf8_decode($nombre_regional);?>'),
	     	nombre_programa:decodeURIComponent('<?php echo utf8_decode($nombre_programa);?>'),
	     	nombre_proyecto:decodeURIComponent('<?php echo utf8_decode($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURIComponent('<?php echo utf8_decode($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURIComponent('<?php echo utf8_decode($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURIComponent('<?php echo utf8_decode($tipo_pres);?>'),
			desc_moneda:decodeURIComponent('<?php echo utf8_decode($desc_moneda);?>'),
			id_moneda:decodeURIComponent('<?php echo utf8_decode($id_moneda);?>')
			*/
			
};

 
idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_detalle_presupuesto_vigente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);