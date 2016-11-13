<<<<<<< HEAD
/**
 * Nombre: pagina_item.js Propósito: pagina objeto principal Autor: Ruddy Luján
 * Bravo Fecha creación: 27-08-2013 16:53:59
 */
function PaginaItem(idContenedor, direccion, paramConfig) {
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_item;
	var maestroData;

	// DATA STORE //
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/item/ActionListarItem.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_item',
			totalRecords : 'TotalCount'
		}, [ 'id_item', 'id_clasificacion', 'id_unidad_medida',
				'nombre_clasificacion', 'nombre_medida', 'codigo', 'nombre',
				'descripcion', 'codigo_fabrica', 'num_por_clasificacion',
				'bajo_responsabilidad', 'estado', 'metodo_valoracion',
				'usuario_reg', {
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				} ]),
		remoteSort : true
	});

	// PARÁMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_item',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_item'
			},
			{
				validacion : {
					labelSeparator : '',
					name : 'id_clasificacion',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_clasificacion'
			},
			{
				validacion : {
					name : 'id_unidad_medida',
					fieldLabel : 'Unidad medida',
					allowBlank : false,
					emptyText : 'Unidad medida...',
					desc : 'nombre_medida',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_unidad_medida_base',
									totalRecords : 'TotalCount'
								}, [ 'id_unidad_medida_base', 'nombre' ])
							}),
					valueField : 'id_unidad_medida_base',
					displayField : 'nombre',
					queryParam : 'filterValue_0',
					filterCol : 'UNMEDB.nombre',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 380,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2,
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 30
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'hidden_id_unidad_medida'
			},
			{
				validacion : {
					name : 'nombre_clasificacion',
					fieldLabel : 'Claificacion',
					align : 'left',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'cla.nombre',
				form : false
			},
			{
				validacion : {
					name : 'nombre_medida',
					fieldLabel : 'Unidad medida',
					grid_visible : true,
					grid_editable : false,
					width_grid : 50
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'UNMEDB.nombre',
				form : false
			},
			{
				validacion : {
					name : 'codigo',
					fieldLabel : 'Codigo',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo',
				form : false,
				save_as : 'txt_codigo'
			},
			{
				validacion : {
					name : 'nombre',
					fieldLabel : 'Nombre',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.nombre',
				form : true,
				save_as : 'txt_nombre'
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'al.descripcion',
				form : true,
				save_as : 'txt_descripcion'
			},
			{
				validacion : {
					name : 'codigo_fabrica',
					fieldLabel : 'Codigo fabrica',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo_fabrica',
				form : true,
				save_as : 'txt_codigo_fabrica'
			},
			{
				validacion : {
					name : 'bajo_responsabilidad',
					fieldLabel : 'Bajo responsabilidad',
					emptyText : 'Bajo responsabilidad...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'si', 'Si' ], [ 'no', 'No' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285,
					renderer : renderBajo_responsabilidad
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'al.bajo_responsabilidad',
				form : true,
				save_as : 'txt_bajo_responsabilidad'
			},
			{
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 55,
					width : 285,
					renderer : renderEstado
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'al.estado',
				form : true,
				save_as : 'txt_estado'
			},
			{
				validacion : {
					name : 'metodo_valoracion',
					fieldLabel : 'Metodo valoracion',
					emptyText : 'Metodo valoracion...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'PP', 'PP' ], [ 'PEPS', 'PEPS' ],
								[ 'UEPS', 'UEPS' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285,
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'al.metodo_valoracion',
				form : true,
				save_as : 'txt_metodo_valoracion'
			},
			{
				validacion : {
					name :'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.usuario_reg',
				form : false
			},
			{
				validacion : {
					name :'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : true,
				filterColValue : 'al.fecha_reg',
				dateFormat : 'm-d-Y'
			}];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'item',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_item = new DocsLayoutMaestro(idContenedor);
	layout_item.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_item, idContenedor);

	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;

	this.reload = function(maestro) {
		maestroData = maestro;
=======
function PaginaItem(idContenedor, direccion, paramConfig)
{
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_item',totalRecords:'TotalCount'
		},[		
			'id_item',
			'id_clasificacion',	'nombre_clasificacion',
			'id_unidad_medida',	'nombre_medida',
			'usuario_reg',		'fecha_reg',
			'usuario_mod',		{
			name : 'fecha_mod',
			type : 'date',
			dateFormat : 'd-m-Y'
			},
			'codigo',			'nombre',
			'descripcion',		'codigo_fabrica',
			'num_por_clasificacion',	'bajo_responsabilidad',
			'estado',			'metodo_valoracion'	
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	var ds_unidad_medida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords: 'TotalCount'},['id_unidad_medida_base','nombre','abreviatura','descripcion'])
	});
	function render_unidad_medida(value, p, record){return String.format('{0}', record.data['nombre_medida']);}
	var tpl_unidad_medida=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{abreviatura} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	

	var ds_clasificacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/clasificacion/ActionListarClasificacion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_clasificacion',totalRecords: 'TotalCount'},['id_clasificacion','codigo','codigo_largo','nombre'])
	});
	function render_clasificacion(value, p, record){return String.format('{0}', record.data['nombre_clasificacion']);}
	var tpl_clasificacion=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{codigo_largo}</FONT>','</div>');

	
	function renderBajo_responsabilidad(component, value, record) {
		var bajo_responsabilidad;
		if (record.data['bajo_responsabilidad'] == 'si') {
			bajo_responsabilidad = 'Si';
		} else {
			bajo_responsabilidad = 'No';
		}
		return String.format('{0}', bajo_responsabilidad);
	}
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'activo') {
			estado = 'Activo';
		} else {
			estado = 'Inactivo';
		}
		return String.format('{0}', estado);
	}
	/////////////////////////
	// DefiniciÃ³n de datos //
	/////////////////////////
	
	// hidden id_param_gral
	//en la posiciÃ³n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_item',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		save_as:'hidden_id_item',
		filtro_0:false
		
	};
	Atributos[1]={
			
			validacion:{
				name:'id_clasificacion',
				fieldLabel:'Clasificacion',
				allowBlank:false,			
				emptyText:'Clasificacion...',
				desc: 'nombre_clasificacion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_clasificacion,
				valueField: 'id_clasificacion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'cla.nombre',
				typeAhead:true,
				tpl:tpl_clasificacion,
				forceSelection:true,
				mode:'remote',
				align : 'center',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_clasificacion,
				grid_visible:true,
				grid_editable:false,
				width_grid:285,
				width:285,
				disabled:false,
				grid_indice:6	
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filterColValue:'cla.nombre',
			save_as : 'hidden_id_clasificacion'
	};
// txt id_clasificacion 
	Atributos[2]={
			validacion:{
			name:'id_unidad_medida',
			fieldLabel:'Unid.Medida',
			allowBlank:false,			
			emptyText:'Unidad de Medida...',
			desc: 'nombre_medida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_medida,
			valueField: 'id_unidad_medida_base',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPMED.nombre',
			typeAhead:true,
			tpl:tpl_unidad_medida,
			forceSelection:true,
			mode:'remote',
			align : 'center',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_unidad_medida,
			grid_visible:true,
			grid_editable:false,
			width_grid:285,
			width:285,
			disabled:false,
			grid_indice:5	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'TIPMED.nombre',
		save_as : 'hidden_id_unidad_medida'
	};
	/*Atributos[3]={
			validacion : {
				name : 'nombre_clasificacion',
				fieldLabel : 'Clasificacion',
				align : 'left',
				grid_visible : false,
				grid_editable : false,
				width_grid : 100
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'cla.nombre',
			form : false
		}*/
	Atributos[3]={
			validacion : {
				name : 'nombre_medida',
				fieldLabel : 'Unidad medida',
				grid_visible : false,
				grid_editable : false,
				width_grid : 50
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'UNMEDB.nombre',
			form : false
	};
	Atributos[4]={
			validacion : {
				name : 'codigo',
				fieldLabel : 'Codigo',
				allowBlank : false,
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				grid_indice:2,
				width : 285
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'al.codigo',
			form : false,
			save_as : 'txt_codigo'
	};
	Atributos[5]={
			validacion : {
				name : 'nombre',
				fieldLabel : 'Nombre',
				allowBlank : false,
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200,
				grid_indice:1,
				width : 285
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'al.nombre',
			form : true,
			save_as : 'txt_nombre'
	};
	Atributos[6]={
			validacion : {
				name : 'descripcion',
				fieldLabel : 'Descripcion',
				allowBlank : true,
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 150,
				grid_indice:3,
				width : 285
			},
			tipo : 'TextArea',
			filtro_0 : true,
			filterColValue : 'al.descripcion',
			form : true,
			save_as : 'txt_descripcion'
	};
	Atributos[7]={
			validacion : {
				name : 'codigo_fabrica',
				fieldLabel : 'Codigo fabrica',
				allowBlank : true,
				align : 'center',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				grid_indice:4,
				width : 285
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'al.codigo_fabrica',
			form : true,
			save_as : 'txt_codigo_fabrica'
	};
	Atributos[8]={
			validacion : {
				name : 'bajo_responsabilidad',
				fieldLabel : 'Bajo Responsabilidad',
				emptyText : 'Bajo responsabilidad...',
				allowBlank : false,
				typeAhead : true,
				loadMask : true,
				triggerAction : 'all',
				mode : "local",
				store : new Ext.data.SimpleStore({
					fields : [ 'valor', 'nombre' ],
					data : [ [ 'si', 'Si' ], [ 'no', 'No' ] ]
				}),
				valueField : 'valor',
				displayField : 'valor',
				align : 'center',
				lazyRender : true,
				forceSelection : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 150,
				width : 150,
				renderer : renderBajo_responsabilidad
			},
			tipo : 'ComboBox',
			filtro_0 : true,
			filterColValue : 'al.bajo_responsabilidad',
			form : true,
			save_as : 'txt_bajo_responsabilidad'
	};
	Atributos[9]={
			validacion : {
				name : 'estado',
				fieldLabel : 'Estado',
				emptyText : 'Estado...',
				allowBlank : false,
				typeAhead : true,
				loadMask : true,
				triggerAction : 'all',
				mode : "local",
				store : new Ext.data.SimpleStore({
					fields : [ 'valor', 'nombre' ],
					data : [ [ 'activo', 'Activo' ],
							[ 'inactivo', 'Inactivo' ] ]
				}),
				valueField : 'valor',
				displayField : 'valor',
				align : 'center',
				lazyRender : true,
				forceSelection : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 55,
				width : 150,
				renderer : renderEstado
			},
			tipo : 'ComboBox',
			filtro_0 : true,
			filterColValue : 'al.estado',
			form : true,
			save_as : 'txt_estado'
	};
	Atributos[10]={
			validacion : {
				name : 'metodo_valoracion',
				fieldLabel : 'Metodo valoracion',
				emptyText : 'Metodo valoracion...',
				allowBlank : false,
				typeAhead : true,
				loadMask : true,
				triggerAction : 'all',
				mode : "local",
				store : new Ext.data.SimpleStore({
					fields : [ 'valor', 'nombre' ],
					data : [ [ 'PP', 'PP' ], [ 'PEPS', 'PEPS' ],
							[ 'UEPS', 'UEPS' ] ]
				}),
				valueField : 'valor',
				displayField : 'valor',
				align : 'center',
				lazyRender : true,
				forceSelection : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 150,
				width : 150,
			},
			tipo : 'ComboBox',
			filtro_0 : true,
			filterColValue : 'al.metodo_valoracion',
			form : true,
			save_as : 'txt_metodo_valoracion'
	};
	Atributos[11]={
			validacion : {
				name : 'usuario_mod',
				fieldLabel : 'Responsable Modificación',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'per2.nombre#per2.apellido_paterno#per2.apellido_materno',
			form : false
	};
	Atributos[12]={
		validacion : {
			name : 'fecha_mod',
			fieldLabel : 'Fecha Modificación',
			format : 'd/m/Y',
			minValue : '01/01/1900',
			grid_visible : true,
			grid_editable : false,
			renderer : formatDate,
			align : 'center',
			width_grid : 150
		},
		tipo : 'DateField',
		form : false,
		filtro_0 : true,
		filterColValue : 'al.fecha_mod',
		dateFormat : 'd-m-Y'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'item',grid_maestro:'grid-'+idContenedor};
	var layout_item=new DocsLayoutMaestro(idContenedor);
	layout_item.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_item,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	
	this.reload = function(m) {
		maestro = m;
>>>>>>> a5afe13a0081bb0c2f7d8fa68b61984216732d4b
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_clasificacion : maestro.id_clasificacion
			}
		};
		this.btnActualizar();
<<<<<<< HEAD
	};

	this.btnNew = function(event, target) {
		cm_btnNew(event, target);
		cm_getComponente("id_clasificacion").setValue(
				maestroData.id_clasificacion);
	}

	this.onResizePrimario = function() {
		layout_item.getLayout().layout();
	}
	// ----------- DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu = {
		nuevo : {
			crear : true,
			separador : true
		},
		editar : {
			crear : true,
			separador : false
		},
		eliminar : {
			crear : true,
			separador : false
		},
		actualizar : {
			crear : true,
			separador : false
		}
	};

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	}
	;

	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'activo') {
			estado = 'Activo';
		} else {
			estado = 'Inactivo';
		}
		return String.format('{0}', estado);
	}
	// funciones render
	function renderBajo_responsabilidad(component, value, record) {
		var bajo_responsabilidad;
		if (record.data['bajo_responsabilidad'] == 'si') {
			bajo_responsabilidad = 'Si';
		} else {
			bajo_responsabilidad = 'No';
		}
		return String.format('{0}', bajo_responsabilidad);
	}

	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion + "../../../control/item/ActionEliminarItem.php"
		},
		Save : {
			url : direccion + "../../../control/item/ActionGuardarItem.php"
		},
		ConfirmSave : {
			url : direccion + "../../../control/item/ActionGuardarItem.php"
		},
		Formulario : {
			titulo : 'Registro de Items',
			html_apply : "dlgInfo-" + idContenedor,
			width : 500,
			height : 420,
			columnas : [ '95%' ],
			closable : true
		}
	};

	// -------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.bloquearMenu();

	this.iniciaFormulario();

	layout_item.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);

=======
	}

	///////////////////////////////////
	// DEFINICIÃ“N DE LA BARRA DE MENÃš//
	///////////////////////////////////

	var paramMenu={
		//nuevo:{crear:false,separador:true},
		//editar:{crear:false,separador:false},
		//eliminar:{crear:false,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÃ“N DE FUNCIONES ------------------------- //
	//  aquÃ­ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/item/ActionEliminarItem.php'},
		Save:{url:direccion+'../../../control/item/ActionGuardarItem.php'},
		ConfirmSave:{url:direccion+'../../../control/item/ActionGuardarItem.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'param_gral'}};
	//-------------- DEFINICIÃ“N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaÃ±o
	this.getLayout=function(){return layout_item.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÃ?METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	/*
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});*/
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
>>>>>>> a5afe13a0081bb0c2f7d8fa68b61984216732d4b
}