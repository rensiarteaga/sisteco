<?php
/**
 * Nombre:		  	    tipo_unidad_cons_reemp_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Anacleto Rojas
 * Fecha creación:		2007-11-07 
 *
 */
session_start();
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:fa
};

var maestro={
	id_composicion_tuc:'<?php echo $maestro_id_composicion_tuc;?>',
	id_tipo_unidad_constructiva:'<?php echo $maestro_id_tipo_unidad_constructiva;?>',
	codigo:'<?php echo $maestro_codigo;?>',
	nombre:'<?php echo $maestro_nombre;?>'
};

var elemento={idContenedor:idContenedor,pagina:new pagina_tipo_unidad_cons_reemp_det(idContenedor,direccion,paramConfig,maestro,'<?php echo $idContenedorPadre;?>')};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_tipo_unidad_cons_reemp_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Anacleto Rojas
 * Fecha creación:		2007-11-07 
 */
function pagina_tipo_unidad_cons_reemp_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{   var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConsReemplazo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_cons_reemp',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_tipo_unidad_cons_reemp',
		'descripcion',
		'id_tipo_unidad_constructiva',
		'desc_tipo_unidad_constructiva',
		'desc_nombre',
		'id_composicion_tuc'
	    
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_composicion_tuc:maestro.id_composicion_tuc
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([
	{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
	{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}
	]);
	
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';
	}
	function italic(value){
		return '<i>'+value+'</i>';
	}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['ID',maestro.id_composicion_tuc],['Código',maestro.codigo],['Nombre',maestro.nombre]]}),cm:cmMaestro});
	gridMaestro.render();
	
	
	//DATA STORE COMBOS
	
	ds_unidad_cons_reemp = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTipoUnidadConsBloq.php'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_tipo_unidad_constructiva',
				totalRecords: 'TotalCount'

			}, ['id_tipo_unidad_constructiva','codigo','nombre','tipo','descripcion','observaciones','fecha_reg'])
		});
	
	var resultTpl = new Ext.Template(
		'<div class="search-item">',
		'<b><i>{codigo}</i></b>',
		'<b><br><i>{nombre}</i></b>',
		'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
		'</div>'
		);
	
	//FUNCIONES RENDER
	function render_id_tipo_unidad_constructiva(value, p, record){return String.format('{0}', record.data['nombre']);};
	function render_reemplazo(value, p, record){return String.format('{0}', record.data['desc_tipo_unidad_constructiva']);};
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_unidad_cons_reemp
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_unidad_cons_reemp',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_unidad_cons_reemp'
	};
	
	// txt id_tipo_unidad_constructiva_reemplazo
	vectorAtributos[1]= {
		validacion:{
				fieldLabel:'Codigo Unidad',
				allowBlank:false,
				emptyText:'Nombre TUC Reemp...',
				name:'id_tipo_unidad_constructiva_reemplazo',
				desc: 'desc_tipo_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_unidad_cons_reemp,
				valueField: 'id_tipo_unidad_constructiva',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'TIPOUC.nombre#TIPOUC.codigo#TIPOUC.descripcion',
				tpl:resultTpl,
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:15,
				minListWidth:450,
				grow:false,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_reemplazo,
				grid_visible:true,
				grid_editable:true,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			//defecto:maestro.id_tipo_unidad_constructiva,
			save_as:'txt_id_tipo_unidad_constructiva_reemplazo'
	};
	
	
	// txt id_tipo_unidad_constructiva
	vectorAtributos[2]= {
		validacion:{
			name:'id_tipo_unidad_constructiva',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		//defecto:maestro.id_tipo_unidad_constructiva,
		save_as:'txt_id_tipo_unidad_constructiva'
	};
	
		
	/////////// txt desc_nombre //////
	vectorAtributos[3] = {
		validacion: {
			name: 'desc_nombre',
			fieldLabel: 'Nombre',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:170 // ancho de columna en el grid
						
		},
		form:false,
		tipo: 'Field',
		filtro_0:false

	};
	
// txt descripcion
	vectorAtributos[4]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TUCREEM.descripcion',
		save_as:'txt_descripcion'
	};
	
	vectorAtributos[5]= {
		validacion:{
			name:'id_composicion_tuc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_composicion_tuc,
		save_as:'txt_id_composicion_tuc'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Tipos de Unidades Constructivas (Maestro)',
		titulo_detalle:'Tipo Unidad Constructiva Reemplazo (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tipo_unidad_cons_reemp = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_unidad_cons_reemp.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_unidad_cons_reemp,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionEliminarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		Save:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionGuardarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		ConfirmSave:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionGuardarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'450',height:'250',closable:true,titulo:'Tipo Unidad Constructiva Reemplazo'}
	};
				//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_composicion_tuc=datos.maestro_id_composicion_tuc;
		maestro.id_tipo_unidad_constructiva=datos.maestro_id_tipo_unidad_constructiva;
		maestro.codigo=datos.maestro_codigo;
		maestro.nombre=datos.maestro_nombre;
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_composicion_tuc:maestro.id_composicion_tuc
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['ID',maestro.id_composicion_tuc],['Código',maestro.codigo],['Nombre',maestro.nombre]]);
		vectorAtributos[5].defecto=maestro.id_composicion_tuc;
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionEliminarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		Save:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionGuardarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		ConfirmSave:{url:direccion+'../../../control/tipo_unidad_cons_reemp/ActionGuardarTipoUnidadConsReemp.php',parametros:'&id_composicion_tuc='+maestro.id_composicion_tuc},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'450',height:'250',closable:true,titulo:'Tipo Unidad Constructiva Reemplazo'}
	};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario

		txt_id_tipo_unidad_constructiva = ClaseMadre_getComponente ('id_tipo_unidad_constructiva');

		combo_id_unidad_reemplazo =	ClaseMadre_getComponente ('id_tipo_unidad_constructiva_reemplazo');

		var onIdReemplazoSelect = function(e) {
			var reemp = combo_id_unidad_reemplazo.getValue();
			var id = txt_id_tipo_unidad_constructiva.getValue();
			if(reemp==id){
				combo_id_unidad_reemplazo.setValue('');
				Ext.MessageBox.alert('Error!!!!!!','El Tipo de Unidad Reemplazante  no puede ser igual a la que quiere remplazar')
			}
		};
		combo_id_unidad_reemplazo.on('select', onIdReemplazoSelect);
		combo_id_unidad_reemplazo.on('change', onIdReemplazoSelect)
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_unidad_cons_reemp.getLayout()
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	
	function iniciaPaginaReemplazo()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciaPaginaReemplazo();
	iniciarEventosFormularios();
	layout_tipo_unidad_cons_reemp.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}