/**
 * Nombre:		  	    pagina_unidad_organizacional_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 09:24:17
 */
function pagina_unidad_organizacional(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_unidad_organizacional',totalRecords:'TotalCount'
		},[		
				'id_unidad_organizacional',
		'nombre_unidad',
		'nombre_cargo',
		'centro',
		'cargo_individual',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_nivel_organizacional',
		'desc_nivel_organizacional',
		'estado_reg'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    var ds_nivel_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nivel_organizacional/ActionListarNivelOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_nivel_organizacional',totalRecords: 'TotalCount'},['id_nivel_organizacional','nombre_nivel','numero_nivel'])
	});

	//FUNCIONES RENDER
	
		function render_id_nivel_organizacional(value, p, record){return String.format('{0}', record.data['desc_nivel_organizacional']);}
		var tpl_id_nivel_organizacional=new Ext.Template('<div class="search-item">','<b><i>{}</i></b>','<br><FONT COLOR="#B5A642">{}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_unidad_organizacional
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_unidad_organizacional',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_unidad_organizacional'
	};
// txt nombre_unidad
	Atributos[1]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'nombre_unidad',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'txt_nombre_unidad'
	};
// txt nombre_cargo
	Atributos[2]={
		validacion:{
			name:'nombre_cargo',
			fieldLabel:'nombre_cargo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_cargo',
		save_as:'txt_nombre_cargo'
	};
// txt centro
	Atributos[3]={
		validacion:{
			name:'centro',
			fieldLabel:'centro',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:4
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.centro',
		save_as:'txt_centro'
	};
// txt cargo_individual
	Atributos[4]={
		validacion:{
			name:'cargo_individual',
			fieldLabel:'cargo_individual',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:5
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.cargo_individual',
		save_as:'txt_cargo_individual'
	};
// txt descripcion
	Atributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'descripcion',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:6
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.descripcion',
		save_as:'txt_descripcion'
	};
// txt fecha_reg
	Atributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'fecha_reg',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:7
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'UNIORG.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt id_nivel_organizacional
	Atributos[7]={
			validacion:{
			name:'id_nivel_organizacional',
			fieldLabel:'id_nivel_organizacional',
			allowBlank:false,			
			emptyText:'id_nivel_organizacional...',
			desc: 'desc_nivel_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_nivel_organizacional,
			valueField: 'id_nivel_organizacional',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'.',
			typeAhead:true,
			tpl:tpl_id_nivel_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_nivel_organizacional,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:8
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'.',
		save_as:'txt_id_nivel_organizacional'
	};
// txt estado_reg
	Atributos[8]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'estado_reg',
			allowBlank:false,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:9
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.estado_reg',
		save_as:'txt_estado_reg'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'unidad_organizacional',grid_maestro:'grid-'+idContenedor};
	var layout_unidad_organizacional=new DocsLayoutMaestro(idContenedor);
	layout_unidad_organizacional.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_unidad_organizacional,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/unidad_organizacional/ActionEliminarUnidadOrganizacional.php'},
		Save:{url:direccion+'../../../control/unidad_organizacional/ActionGuardarUnidadOrganizacional.php'},
		ConfirmSave:{url:direccion+'../../../control/unidad_organizacional/ActionGuardarUnidadOrganizacional.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'unidad_organizacional'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_unidad_organizacional.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_unidad_organizacional.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}