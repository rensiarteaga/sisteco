<?php
/**
 * Nombre:		  	    empleado_planilla_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-27 14:34:08
 *
 */
session_start();
?>
//<script>
function DinaMain(){
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
idContenedorPadre='<?php echo $idContenedorPadre;?>';


var maestro={id_planilla:<?php if($id_planilla) {echo $id_planilla;} else {echo '0';}?>,
		                 id_tipo_planilla:<?php if($id_tipo_planilla) {echo $id_tipo_planilla;} else {echo '0';}?>,
				         vista_doble:'<?php if($vista_doble=='si'){echo 'si';} else{echo 'no';}?>'};

  this.inicia_matriz = function (resp){

	
    var regreso = Ext.util.JSON.decode(resp.responseText);

   	var elemento= {  
                    idContenedor:idContenedor,
                    pagina: new pagina_empleado_planilla_matriz(idContenedor,direccion,paramConfig,idContenedorPadre,maestro,regreso.Atributos,regreso.defStore)};
   	if(resp.argument.rel){
	
   		_CP.setPaginaByIndice(elemento,resp.argument.rel);
   	}
   	else{
   		_CP.setPagina(elemento);
   	   	}
}

this.carga_menu = function(m,rel){

	if(m){

		 var datos=Ext.urlDecode(decodeURIComponent(m));
	     Ext.apply(maestro,datos);

		}

	/*-----loading----*/
_CP.loadingShow();


	Ext.Ajax.request({
		url:direccion+'../../../control/columna/ActionListarColumnaDinamica.php',	
		params: {id_tipo_planilla:maestro.id_tipo_planilla, id_planilla:maestro.id_planilla},
		method:'POST',
		success:  this.inicia_matriz,
		argument:{rel: rel},
		failure:  _CP.conexionFailure
	});
	
}
	this.carga_menu();			

}
Ext.onReady(DinaMain,DinaMain);