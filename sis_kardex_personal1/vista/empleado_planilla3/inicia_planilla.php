<?php header("content-type: text/javascript; charset=ISO-8859-15");?>
<script>
console.log('se ejecuta el dina  script')
function DinaMainPla(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){

	console.log('se ejecuta el dina  ini')
	
	this.inicia_matriz = function (resp){

		var regreso = Ext.util.JSON.decode(resp.responseText);
		var elemento= {
			idContenedor:idContenedor,
			pagina: new pagina_empleado_planilla_matriz(idContenedor,direccion,paramConfig,maestro,idContenedorPadre,regreso.Atributos,regreso.defStore)};
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
			url:direccion+'../../../sis_kardex_personal/control/columna/ActionListarColumnaDinamica.php',
			params: {id_tipo_planilla:maestro.id_tipo_planilla, id_planilla:maestro.id_planilla},
			method:'POST',
			success:  this.inicia_matriz,
			argument:{rel: rel},
			failure:  _CP.conexionFailure
		});

	}
	this.carga_menu();
	
	console.log('se ejecuta el dina')

}
</script>