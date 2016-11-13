/**
 * Nombre:		  	    pagina_tipo_almacen_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 17:22:57
 */
function pagina_tipo_almacen(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_tipo_almacen;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_almacen/ActionListarTipoAlmacen.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_almacen',
			totalRecords:'TotalCount'
		},[
		'id_tipo_almacen',
		'descripcion',
		'nombre',
		'contabilizar'
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	// hidden id_tipo_almacen
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_almacen',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_almacen'
	};	
// txt descripcion
	vectorAtributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'TIPALM.descripcion',
		save_as:'txt_descripcion'
	};
// txt nombre
	vectorAtributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TIPALM.nombre',
		save_as:'txt_nombre'
	};
// txt contabilizar
	vectorAtributos[3]={
			validacion:{
			name:'contabilizar',
			fieldLabel:'Contabilizar',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.tipo_almacen_combo.contabilizar}),
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:75
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPALM.contabilizar',
		defecto:'si',
		save_as:'txt_contabilizar'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Tipo de Almacen',grid_maestro:'grid-'+idContenedor};
	layout_tipo_almacen=new DocsLayoutMaestro(idContenedor);
	layout_tipo_almacen.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_almacen,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_almacen/ActionEliminarTipoAlmacen.php'},
		Save:{url:direccion+'../../../control/tipo_almacen/ActionGuardarTipoAlmacen.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_almacen/ActionGuardarTipoAlmacen.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo de Almacen'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.getLayout=function(){return layout_tipo_almacen.getLayout()};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
    this.iniciaFormulario();
	layout_tipo_almacen.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}