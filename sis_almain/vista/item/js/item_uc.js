/**
 * Nombre: pagina_item.js Propósito: pagina objeto principal Autor: Ruddy Luján
 * Bravo Fecha creación: 27-08-2013 16:53:59
 */
function PaginaItemUC(idContenedor, direccion, paramConfig) {
	var sm;
	var vectorAtributos = new Array();
	var componentes= new Array();  
	var seleccionados=new Array();
	var ds;
	var layout_item;
	var maestro;
	var maestroData;
	var sel;
	
	// DATA STORE //
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/item/ActionListarItemUC.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_item',
			totalRecords : 'TotalCount'
		}, [ 'id_item', 'id_clasificacion', 'id_unidad_medida',
				'codigo', 'nombre','codigo_fabrica','estado',
				'nombre_medida','peso','calidad','id_unidad_constructiva','seleccionado','cantidad_ituc',
				'usuario_reg', {
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				} ]),
		remoteSort : true
	});
	
	//function makeCheckBox(val){return '<input checked="" name="check[]" value=""+val+"" type="checkbox">';}
	function formatValida(value){if (value==1) return 'Si';else return 'No'};
	
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
			}
			,{
				validacion : {
					name : 'seleccionado',
					fieldLabel : 'Seleccionado',
					renderer : formatValida, 
					checked: false,
					//align:'center',
					selectOnFocus:true,
					grid_visible : true,
					grid_editable : true,
					width : 30
				},
				form : true,
				tipo : 'Checkbox',
				save_as : 'chk_seleccionado' 
			},
		/*	{
				validacion : 
				{
					name :'orden',
					fieldLabel : 'Nro.(despues de)',
					allowBlank : false,
					allowNegative: false,
					allowDecimals: false,
					minValue : '0',
					align : 'center',
					grid_visible : false,
					grid_editable : true, 
					width_grid : 120,
					width:100
				},
				tipo : 'NumberField',
				form : false
				//,save_as : 'txt_orden_detuc'
			},*/
			{
				validacion : 
				{
					name : 'cantidad_ituc',
					fieldLabel : 'Cantidad',
					allowBlank : false,
					allowNegative : false,
					allowDecimals : true,
					minValue : '0',
					// decimalPrecision : 2,
					align : 'center',
					grid_visible : true,
					grid_editable : true,
					width_grid : 100,
					width : 250
				},
				tipo : 'NumberField',
				filtro_0 : false,
				filterColValue : 'al.cantidad',
				form : true,
				save_as : 'txt_cantidad'
				
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
				form : false
				//,save_as : 'txt_codigo'
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
				form : false
				//save_as : 'txt_nombre'
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : false,
					align : 'left',
					grid_visible : false,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : false,
				filterColValue : 'al.descripcion',
				form : false
				//save_as : 'txt_descripcion'
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
	var cm_save=this.Save;
	
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;

	/*this.reload = function(maestro) 
	{
		maestroData = maestro;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_clasificacion : maestro.id_clasificacion
				,id_uc :maestro.id_unicons
				,otro:maestro.estado			
				}
		};
		this.btnActualizar();
	};*/
	
	this.reload=function(params) 
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//master.id_unidad_const=params.id_clasificacion_fk;
		
		maestroData = params;
	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_clasificacion : params.id_clasificacion,
				item_uc :	'si'
			
			} 
		};
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);
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
		guardar : {crear : true,separador : false},
		//editar : {crear : false,separador : false},
		actualizar : {crear : true,separador : false}
	};

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	};
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
	function renderBajo_responsabilidad(component, value, record) 
	{
		var bajo_responsabilidad;
		
		if (record.data['bajo_responsabilidad'] == 'activo_fijo') {
			bajo_responsabilidad = 'Activo Fijo';
		} 
		else if(record.data['bajo_responsabilidad'] == 'bien')
		{	bajo_responsabilidad = 'Bien Bajo Responsabilidad';}
		else if(record.data['bajo_responsabilidad'] == 'material')
		{	bajo_responsabilidad = 'Material';}
		else if(record.data['bajo_responsabilidad'] == 'repuesto')
			{bajo_responsabilidad = 'Respuesto';}
		else if(record.data['bajo_responsabilidad'] == 'material_construccion')
		{bajo_responsabilidad = 'Material Construccion';}
		
		return String.format('{0}', bajo_responsabilidad);
	}

	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	
	function iniciarEventosFormularios()
	{
	}
	
	var paramFunciones = {
		btnEliminar : {
			url : direccion + "../../../control/item/ActionEliminarItem.php"
		},
		Save : {
			url : direccion + "../../../control/detalle_unidad_constructiva/ActionGuardarItemUC.php"
		},
		ConfirmSave : {
			url : direccion + "../../../control/detalle_unidad_constructiva/ActionGuardarItemUC.php"
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
	this.iniciaFormulario();
	
	//this.bloquearMenu();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	
	cm_BloquearMenu();
	iniciarEventosFormularios();
	layout_item.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);

}