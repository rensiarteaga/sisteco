/**
 * Nombre:		  	    pagina_item_propuesto_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-08 16:04:02
 */
function pagina_item_propuesto(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_propuesto/ActionListarItemPropuesto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_item_propuesto',totalRecords:'TotalCount'
		},[		
				'id_item_propuesto',
		'codigo',
		'nombre',
		'descripcion',
		'costo_estimado',
		'observaciones',
		'nivel_convertido',
		'estado_registro',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_unidad_medida_base',
		'desc_unidad_medida_base',
		'id_proveedor',
		'desc_proveedor',
		'id_moneda',
		'desc_moneda',
		'desc_usuario',
		'id_usuario'

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

    var ds_unidad_medida_base = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords: 'TotalCount'},['id_unidad_medida_base','nombre','abreviatura','descripcion','observaciones','estado_registro','fecha_reg','id_tipo_unidad_medida'])
	});

    var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion'])
	});

	//FUNCIONES RENDER
	
		function render_id_unidad_medida_base(value, p, record){return String.format('{0}', record.data['desc_unidad_medida_base']);}
		var tpl_id_unidad_medida_base=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
		var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{id_proveedor}</i></b>','<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b><i>{id_persona}</i></b>','<br><FONT COLOR="#B5A642">{apellido_paterno}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_item_propuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_item_propuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_item_propuesto'
	};
// txt codigo
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.codigo',
		save_as:'txt_codigo'
	};
// txt nombre
	Atributos[2]={
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
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.nombre',
		save_as:'txt_nombre'
	};
// txt descripcion
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:300,
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
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.descripcion',
		save_as:'txt_descripcion'
	};
// txt costo_estimado
	Atributos[4]={
		validacion:{
			name:'costo_estimado',
			fieldLabel:'Costo Estimado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.costo_estimado',
		save_as:'txt_costo_estimado'
	};
// txt observaciones
	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:300,
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
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'IPROPU.observaciones',
		save_as:'txt_observaciones'
	};
// txt nivel_convertido
	Atributos[6]={
		validacion:{
			name:'nivel_convertido',
			fieldLabel:'Nivel Convertido',
			allowBlank:false,
			maxLength:1,
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
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.nivel_convertido',
		save_as:'txt_nivel_convertido'
	};
// txt estado_registro
	Atributos[7]={
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado Registro',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
// txt fecha_reg
	Atributos[8]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:8
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'IPROPU.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt id_unidad_medida_base
	Atributos[9]={
			validacion:{
			name:'id_unidad_medida_base',
			fieldLabel:'Unidad Medida',
			allowBlank:false,			
			emptyText:'Unidad Medida...',
			desc: 'desc_unidad_medida_base', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_medida_base,
			valueField: 'id_unidad_medida_base',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'UNMEDB.nombre#UNMEDB.descripcion',
			typeAhead:true,
			tpl:tpl_id_unidad_medida_base,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_medida_base,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:9
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNMEDB.nombre',
		save_as:'txt_id_unidad_medida_base'
	};
// txt id_proveedor
	Atributos[10]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:false,			
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'id_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PROVEE.id_proveedor#PROVEE.codigo#PROVEE.id_persona#PROVEE.id_institucion',
			typeAhead:true,
			tpl:tpl_id_proveedor,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PROVEE.id_proveedor',
		save_as:'txt_id_proveedor'
	};
// txt id_moneda
	Atributos[11]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda'
	};
// txt id_usuario
	Atributos[12]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:false,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'USUARI.id_persona#USUARI.apellido_paterno#USUARI.apellido_materno#USUARI.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:12
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'USUARI.id_persona',
		save_as:'txt_id_usuario'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'item_propuesto',grid_maestro:'grid-'+idContenedor};
	var layout_item_propuesto=new DocsLayoutMaestro(idContenedor);
	layout_item_propuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_item_propuesto,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/item_propuesto/ActionEliminarItemPropuesto.php'},
		Save:{url:direccion+'../../../control/item_propuesto/ActionGuardarItemPropuesto.php'},
		ConfirmSave:{url:direccion+'../../../control/item_propuesto/ActionGuardarItemPropuesto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'item_propuesto'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_item_propuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item_propuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}