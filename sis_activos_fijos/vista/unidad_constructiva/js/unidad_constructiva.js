/**
 * Nombre:		  	    unidad_constructiva.js
 * PropÃƒÂ³sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciÃƒÂ³n:		29/07/2013
 */
function pagina_unidad_constructiva(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var h_txt_fecha_reg;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}), 
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_unidad_constructiva',totalRecords:'TotalCount'
		},[		
		'id_unidad_constructiva',
		'descripcion',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},
		'estado'
		]),remoteSort:true});


	
	/////////////////////////
	// DefiniciÃƒÂ³n de datos //
	/////////////////////////
	
	// hidden id_param_gral
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_unidad_constructiva',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	Atributos[1]={
		validacion: {
			name: 'descripcion',
			fieldLabel: 'Descripcion',
			allowBlank: false,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:300, // ancho de columna en el grid
			disabled: false,
			grid_indice:1,
			width:200,
			locked:false
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UC.descripcion',
		id_grupo: 0,
		save_as:'txt_descripcion'
	};
	
	Atributos[2] = {
			validacion: {
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['activo', 'activo'],['inactivo','inactivo']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto: 'activo',
			save_as:'txt_estado'
		}

/////////// fecha_reg//////
	Atributos[3] = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:95, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true, 
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envia para guardar
		defecto:"" // valor por default para este campo
	};


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Unidad Constructiva',grid_maestro:'grid-'+idContenedor};
	var layout_param_gral=new DocsLayoutMaestro(idContenedor);
	layout_param_gral.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_param_gral,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;

	///////////////////////////////////
	// DEFINICIÃƒâ€œN DE LA BARRA DE MENÃƒÅ¡//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	function get_fecha_bd()
	{

		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:  cargar_fecha_bd,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}

	function cargar_fecha_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}

	
	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		get_fecha_bd();

	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÃƒâ€œN DE FUNCIONES ------------------------- //
	//  aquÃƒÂ­ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/unidad_constructiva/ActionEliminarUnidadConstructiva.php'},
		Save:{url:direccion+'../../../control/unidad_constructiva/ActionGuardarUnidadConstructiva.php'},
		ConfirmSave:{url:direccion+'../../../control/unidad_constructiva/ActionGuardarUnidadConstructiva.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Unidad Constructiva'}};
	//-------------- DEFINICIÃƒâ€œN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		h_txt_fecha_reg = getComponente('fecha_reg');
	}

	//para que los hijos puedan ajustarse al tamaÃƒÂ±o
	this.getLayout=function(){return layout_param_gral.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÃƒÂ�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
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
	layout_param_gral.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}