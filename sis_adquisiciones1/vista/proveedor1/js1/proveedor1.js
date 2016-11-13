/**
 * Nombre:		  	    pagina_proveedor_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-02 08:53:51
 */
function pagina_proveedor(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_proveedor',totalRecords:'TotalCount'
		},[		
				'id_proveedor',
		'codigo',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'usuario',
		'contrasena',
		'confirmado',
		'nombre_pago',
		'id_persona',
		'id_institucion'

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
	//ds_persona=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_seguridad/control/persona/ActionListarPersona.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_persona',totalRecords:'TotalCount'},['id_financiador','nombre_financiador'])});
	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_proveedor
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_proveedor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_proveedor'
	};
// txt codigo
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.codigo',
		save_as:'txt_codigo'
	};
// txt observaciones
	Atributos[2]={
		validacion:{
			name:'observaciones',
			fieldLabel:'observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'PROVEE.observaciones',
		save_as:'txt_observaciones'
	};
// txt fecha_reg
	Atributos[3]= {
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
			disabled:true
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PROVEE.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt usuario
	Atributos[4]={
		validacion:{
			name:'usuario',
			fieldLabel:'usuario',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.usuario',
		save_as:'txt_usuario'
	};
// txt contrasena
	Atributos[5]={
		validacion:{
			name:'contrasena',
			fieldLabel:'contrasena',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.contrasena',
		save_as:'txt_contrasena'
	};
// txt confirmado
	Atributos[6]={
			validacion: {
			name:'confirmado',
			fieldLabel:'confirmado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PROVEE.confirmado',
		defecto:'si',
		save_as:'txt_confirmado'
	};
// txt nombre_pago
	Atributos[7]={
		validacion:{
			name:'nombre_pago',
			fieldLabel:'nombre_pago',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.nombre_pago',
		save_as:'txt_nombre_pago'
	};
// txt id_persona
	Atributos[8]={
		validacion:{
			name:'id_persona',
			fieldLabel:'id_persona',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'PROVEE.id_persona',
		save_as:'txt_id_persona'
	};
// txt id_institucion
	Atributos[9]={
		validacion:{
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'PROVEE.id_institucion',
		save_as:'txt_id_institucion'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'proveedor',grid_maestro:'grid-'+idContenedor};
	var layout_proveedor=new DocsLayoutMaestro(idContenedor);
	layout_proveedor.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////


	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_proveedor,idContenedor);
	var getComponente=this.getComponente;


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
		btnEliminar:{url:direccion+'../../../control/proveedor/ActionEliminarProveedor.php'},
		Save:{url:direccion+'../../../control/proveedor/ActionGuardarProveedor.php'},
		ConfirmSave:{url:direccion+'../../../control/proveedor/ActionGuardarProveedor.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proveedor'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_item_proveedor(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_proveedor='+SelectionsRecord.data.id_proveedor;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_usuario='+SelectionsRecord.data.usuario;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_id_institucion='+SelectionsRecord.data.id_institucion;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_proveedor.loadWindows(direccion+'../../../sis_adquisiciones/vista/item_proveedor/item_proveedor_det.php?'+data,'Productos',ParamVentana);
layout_proveedor.getVentana().on('resize',function(){
			layout_proveedor.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	function btn_tipo_servicio_proveedor(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_proveedor='+SelectionsRecord.data.id_proveedor;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_usuario='+SelectionsRecord.data.usuario;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_id_institucion='+SelectionsRecord.data.id_institucion;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_proveedor.loadWindows(direccion+'../../../sis_adquisiciones/vista/tipo_servicio_proveedor/tipo_servicio_proveedor_det.php?'+data,'Servicios',ParamVentana);
layout_proveedor.getVentana().on('resize',function(){
			layout_proveedor.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_proveedor.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Productos',btn_item_proveedor,true,'item_proveedor','');

		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Servicios',btn_tipo_servicio_proveedor,true,'tipo_servicio_proveedor','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_proveedor.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}