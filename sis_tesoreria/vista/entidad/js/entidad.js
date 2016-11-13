/**
 * Nombre:		  	    pagina_entidad.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-03-16 16:16:15
 */
function pagina_entidad(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/entidad/ActionListarEntidad.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_entidad',totalRecords:'TotalCount'
		},[		
		'id_entidad',
		'id_institucion',
		'desc_institucion',
		'id_parametro',
		'gestion_tesoro',
		'tipo_entidad'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	
	/////DATA STORE COMBOS////////////
	ds_institucion=new Ext.data.Store({
	
  	 proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'

		}, ['id_institucion','nombre'])

	});
	ds_param=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/parametro/ActionListarParametro.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_tesoro'])
	});

	//FUNCIONES RENDER
	function renderInstitucion(value, p, record){return String.format('{0}', record.data['desc_institucion'])}
	function renderParametro(value, p, record){return String.format('{0}', record.data['gestion_tesoro'])}
	
	
	
	function renderTipoEntidad(value, p, record)
	{
		if(value == 1)
		{return "Transporte Aéreo"}
		if(value == 2)
		{return "Transporte Terrestre"}		
		if(value == 3)
		{return "Transporte Fluvial"}
		if(value == 4)
		{return "Ninguno"}	
		return 'Otro';
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_entidad
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_entidad',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};


	
//param id parametros 
	Atributos[1]={
		validacion:{
			fieldLabel: 'Gestión',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Gestión...',
			name: 'id_parametro',     
			desc: 'gestion_tesoro', 
			store:ds_param,
			valueField: 'id_parametro',
			displayField: 'gestion_tesoro',
			filterCol:'PARAME.gestion_tesoro',
			typeAhead: true,
			forceSelection: true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth: 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, 
			triggerAction: 'all',
			editable: true,
			renderer: renderParametro,
			grid_visible:true, 
			grid_editable:true, 
			width_grid:150 
		},
		tipo: 'ComboBox',
		filtro_0:false,
		filterColValue:'PARAME.gestion_tesoro',		
		save_as:'id_parametro'
	};
	
	//param id entidad financiera
	Atributos[2]={
		validacion:{
			fieldLabel: 'Institución',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Nombre Institución...',
			name: 'id_institucion',     
			desc: 'nombre', 
			store:ds_institucion,
			selectOnFocus:true,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 300,
			minListWidth : 300,
			resizable: true,
			minChars : 1, 
			triggerAction: 'all',
			editable : true,
			renderer: renderInstitucion,
			grid_visible:true, 
			grid_editable:true, 
			width_grid:250 
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'INSTIT.nombre',		
		save_as:'id_institucion'
	};	
	
	// txt sw_cheque
	Atributos[3]={
		validacion:{
			name:'tipo_entidad',
			fieldLabel:'Tipo de Entidad',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Transporte Aéreo'],['2','Transporte Terrestre'],['3','Transporte Fluvial'],['4','Ninguno']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoEntidad,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:150,
			grid_visible:true,			
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,		
		filtro_0:false,
		filterColValue:'ENTIDA.tipo_entidad'		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Entidad',grid_maestro:'grid-'+idContenedor};
	var layout_entidad=new DocsLayoutMaestro(idContenedor);
	layout_entidad.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_entidad,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/entidad/ActionEliminarEntidad.php'},
		Save:{url:direccion+'../../../control/entidad/ActionGuardarEntidad.php'},
		ConfirmSave:{url:direccion+'../../../control/entidad/ActionGuardarEntidad.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Entidad'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_entidad.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_entidad.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}