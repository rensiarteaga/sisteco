function pagina_af_caracteristicas(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){

	var Atributos=new Array;
	var ds;

	
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creación del Data Store

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/activo_fijo_caracteristicas/ActionListaActivoFijoCaracteristicas.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_caracteristicas',
			totalRecords: 'TotalCount'

		}, ['id_activo_fijo_caracteristicas',
		// define el mapeo de XML a las etiqutas (campos)
		'descripcion',
		'id_caracteristica',
		'id_activo_fijo', 
		'desc_caracteristicas',
		'desc_activo_fijo'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	
	ds_caracteristicas = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/caracteristicas/ActionListaCaracteristicas.php?maestro_id_tipo_activo='+maestro.id_tipo_activo}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_caracteristica',
			totalRecords: 'TotalCount'

		}, ['id_caracteristica','descripcion'])

	});


	function renderCaracteristicas(value, p, record){return String.format('{0}', record.data['desc_caracteristicas']);}

	
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

	Atributos[0] ={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo_caracteristicas',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:200

		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_activo_fijo_caracteristicas'
	};

	/////////// txt descripcion//////
	Atributos[2] ={
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filterColValue:'afc.descripcion',
		save_as:'txt_descripcion'
	};


	///////////////////////

	Atributos[1] ={
		validacion:{
			fieldLabel: 'Caracteristicas',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Caracteristicas...',
			name: 'id_caracteristica',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_caracteristicas', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_caracteristicas,
			valueField: 'id_caracteristica',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'descripcion',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderCaracteristicas,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_caracteristica'
	};


	Atributos[3] ={
		validacion:{
			name: 'id_activo_fijo',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo',
		defecto: maestro.id_activo_fijo
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Subtipo de Activo Fijo (Maestro)",
		titulo_detalle:"Caracteristicas por Subtipo (Detalle)",
		grid_maestro:'grid-'+idContenedor
	};
	var layout_af_caracteristicas= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_af_caracteristicas.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_af_caracteristicas,idContenedor);
var EstehtmlMaestro=this.htmlMaestro;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
			},

		actualizar:{
			crear :true,
			separador:false
		}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	//datos necesarios para ell filtro
	//parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			
			url:direccion+'../../../control/activo_fijo_caracteristicas/ActionEliminaActivoFijoCaracteristicas.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		
		Save:{
			url:direccion+'../../../control/activo_fijo_caracteristicas/ActionSaveActivoFijoCaracteristicas.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		ConfirmSave:{
			url:direccion+'../../../control/activo_fijo_caracteristicas/ActionSaveActivoFijoCaracteristicas.php',parametros:'&hidden_id_activo_fijo='+maestro.id_activo_fijo},
		
		Formulario:{
			html_apply:"dlgInfo",
			width:520,
			height:190,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[480],
			grupos:[
			{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	}

var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/activo_fijo/ActionListaActivoFijo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_activo_fijo',totalRecords: 'TotalCount'},['id_activo_fijo',
		'codigo',
		'descripcion',
		'descripcion_larga'
		])
	});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_activo_fijo:maestro.id_activo_fijo

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
		
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Cod. Activo Fijo',ds_maestro.getAt(0).get('codigo')],['Descripcion',ds_maestro.getAt(0).get('descripcion')],['Descripcion Larga',ds_maestro.getAt(0).get('descripcion_larga')]]));
		}
		
		
		this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_tipo_activo=datos.maestro_id_tipo_activo;
		maestro.id_activo_fijo=datos.maestro_id_activo_fijo;
		maestro.codigo=datos.maestro_codigo;
		maestro.descripcion=datos.maestro_descripcion;
		maestro.descripcion_larga=datos.maestro_descripcion_larga;
		
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					maestro_id_activo_fijo:maestro.id_activo_fijo

				},
				callback:cargar_maestro
			});
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_activo_fijo:maestro.id_activo_fijo
				
			}
		};
		this.btnActualizar();
		
	
		Atributos[2].defecto=maestro.id_subtipo_activo;
		paramFunciones.btnEliminar.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
		paramFunciones.Save.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
		paramFunciones.ConfirmSave.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
		this.InitFunciones(paramFunciones)
	};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.getLayout=function(){return layout_af_caracteristicas.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

	

		//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: maestro.id_activo_fijo
			}
	});
	this.iniciaFormulario();
layout_af_caracteristicas.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
			
	
}

