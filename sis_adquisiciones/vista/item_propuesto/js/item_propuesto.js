/**
 * Nombre:		  	    pagina_item_propuesto_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 09:56:20
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
		'nombre',
		'descripcion',
		'costo_estimado',
		'observaciones',
		'estado_reg',
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
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion','desc_usuario'])
	});

	//FUNCIONES RENDER
	
		function render_id_unidad_medida_base(value, p, record){return String.format('{0}', record.data['desc_unidad_medida_base']);}
		var tpl_id_unidad_medida_base=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
		var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{simbolo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b><i>{login}</i></b>','<br><FONT COLOR="#B5A642">{desc_usuario}</FONT>','</div>');

	
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
		save_as:'hidden_id_item_propuesto',
		id_grupo:0
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.nombre',
		save_as:'txt_nombre',
		id_grupo:1
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.descripcion',
		save_as:'txt_descripcion',
		id_grupo:1
	};
// txt costo_estimado
	Atributos[3]={
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
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.costo_estimado',
		save_as:'txt_costo_estimado',
		id_grupo:3
	};
// txt observaciones
	Atributos[4]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:12
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'IPROPU.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};
// txt estado_reg
	Atributos[5]={
			validacion: {
			name:'estado_reg',
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
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:6
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'IPROPU.estado_reg',
		defecto:'activo',
		save_as:'txt_estado_reg',
		id_grupo:2
	};
// txt fecha_reg
	Atributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:7
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'IPROPU.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:1
	};
// txt id_unidad_medida_base
	Atributos[7]={
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
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_medida_base,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disable:false,
			grid_indice:8
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNMEDB.nombre',
		save_as:'txt_id_unidad_medida_base',
		id_grupo:1
	};
// txt id_proveedor
	Atributos[8]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:true,			
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'nombre_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre#PROVEE.codigo',
			typeAhead:true,
			tpl:tpl_id_proveedor,
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
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			width:'100%',
			disable:false,
			grid_indice:9
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON1.apellido_paterno#PERSON1.apellido_materno#PERSON1.nombre#INSTIT1.nombre#PROVEE.codigo',
		save_as:'txt_id_proveedor',
		id_grupo:1
	};
// txt id_moneda
	Atributos[9]={
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
			filterCol:'MONEDA.simbolo#MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
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
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disable:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda',
		id_grupo:3
	};
// txt id_usuario
	Atributos[10]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:false,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
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
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			width:'100%',
			disable:false,
			grid_indice:11
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_10.apellido_paterno#PERSON_10.apellido_materno#PERSON_10.nombre',
		save_as:'txt_id_usuario',
		form:false
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
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	
	function btnCaracteristicas(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra_det=-1';
			data=data+'&m_id_servicio_propuesto=-1';
			data=data+'&m_id_item_propuesto='+SelectionsRecord.data.id_item_propuesto;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_item_propuesto.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Características Servicio',ParamVentana);
layout_item_propuesto.getVentana().on('resize',function(){
			layout_item_propuesto.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
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
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'item_propuesto',grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Datos Item Propuesto',columna:0,id_grupo:1},{tituloGrupo:'Estado del Registro',columna:0,id_grupo:2},{tituloGrupo:'Costo',columna:0,id_grupo:3}]}}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	
	this.btnEdit =function(){
		CM_ocultarGrupo('Datos');
		CM_mostrarGrupo('Datos Item Propuesto');
		CM_mostrarGrupo('Estado del Registro');
		CM_mostrarGrupo('Costo');
		CM_btnEdit();
	}
	
	this.btnNew =function(){
		CM_ocultarGrupo('Datos');
		CM_mostrarGrupo('Datos Item Propuesto');
		CM_ocultarGrupo('Estado del Registro');
		CM_mostrarGrupo('Costo');
		CM_btnNew();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_item_propuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'',btnCaracteristicas,true, 'Características del Item','Características');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item_propuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}