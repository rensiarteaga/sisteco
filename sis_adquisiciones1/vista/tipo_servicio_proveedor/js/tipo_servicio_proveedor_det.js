/**
 * Nombre:		  	    pagina_tipo_servicio_proveedor_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-06 11:12:13
 */
function pagina_tipo_servicio_proveedor_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_servicio_proveedor/ActionListarTipoServicioProveedor_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_servicio_proveedor',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_servicio_proveedor',
		'precio_ult',
		{name: 'fecha_ult_mod',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_tipo_servicio',
		'desc_tipo_servicio',
		'id_moneda',
		'desc_moneda',
		'id_servicio_propuesto',
		'desc_servicio_propuesto',
		'desc_proveedor',
		'id_proveedor',
		'observaciones'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_proveedor:maestro.id_proveedor
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['id_proveedor',maestro.id_proveedor],['codigo',maestro.id_proveedor],['Proveedor',maestro.nombre_proveedor]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    var ds_tipo_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_servicio/ActionListarTipoServicio.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_servicio',totalRecords:'TotalCount'},['id_tipo_servicio','nombre','descripcion','fecha_reg','id_tipo_adq'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_servicio_propuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio_propuesto/ActionListarServicioPropuesto.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio_propuesto',totalRecords:'TotalCount'},['id_servicio_propuesto','nombre','descripcion','fecha_reg','monto','id_proveedor','id_moneda'])
	});

	//FUNCIONES RENDER
	
	function render_id_tipo_servicio(value, p, record){return String.format('{0}', record.data['desc_tipo_servicio']);}
	var tpl_id_tipo_servicio=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	function render_id_servicio_propuesto(value, p, record){return String.format('{0}', record.data['desc_servicio_propuesto']);}
	var tpl_id_servicio_propuesto=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_servicio_proveedor
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_servicio_proveedor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_servicio_proveedor'
	};
// txt precio_ult
	Atributos[2]={
		validacion:{
			name:'precio_ult',
			fieldLabel:'Precio',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:80,
			align:'right'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'TISEPR.precio_ult',
		save_as:'txt_precio_ult'
	};
// txt fecha_ult_mod
	Atributos[4]={
		validacion:{
			name:'fecha_ult_mod',
			fieldLabel:'Fecha Ultima Actualización',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:155,
			disabled:false,
			align:'center'
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'TISEPR.fecha_ult_mod',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ult_mod'
	};

	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			
			width_grid:250
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'TISEPR.observaciones',
		save_as:'txt_observaciones'
	};
	
	// txt fecha_reg
	Atributos[6]={
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
			width_grid:100,
			disabled:true,
			align:'center'
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'TISEPR.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
// txt id_tipo_servicio
	Atributos[1]= {
			validacion: {
			name:'id_tipo_servicio',
			fieldLabel:'Tipo Servicio',
			allowBlank:false,			
			emptyText:'Tipo Servicio...',
			desc: 'desc_tipo_servicio', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_servicio,
			valueField: 'id_tipo_servicio',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPSER.descripcion#TIPSER.nombre',
			typeAhead:true,
			tpl:tpl_id_tipo_servicio,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_servicio,
			grid_visible:true,
			grid_editable:true,
			width_grid:180 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'TIPSER.descripcion',
		save_as:'txt_id_tipo_servicio'
	};
// txt id_moneda
	Atributos[3]= {
			validacion: {
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
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:130 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda'
	};
// txt id_servicio_propuesto
	Atributos[7]= {
			validacion: {
			name:'id_servicio_propuesto',
			fieldLabel:'Servicio Propuesto',
			allowBlank:false,			
			emptyText:'Servicio Propuesto...',
			desc: 'desc_servicio_propuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_servicio_propuesto,
			valueField: 'id_servicio_propuesto',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'SPROPU.descripcion#SPROPU.nombre',
			typeAhead:true,
			tpl:tpl_id_servicio_propuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			//width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_servicio_propuesto,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'SPROPU.descripcion',
		save_as:'txt_id_servicio_propuesto'
	};
// txt id_proveedor
	Atributos[8]={
		validacion:{
			name:'id_proveedor',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_proveedor,
		save_as:'txt_id_proveedor'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Proveedores (Maestro)',titulo_detalle:'Servicios (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_servicio_proveedor = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_servicio_proveedor.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tipo_servicio_proveedor,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tipo_servicio_proveedor/ActionEliminarTipoServicioProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	Save:{url:direccion+'../../../control/tipo_servicio_proveedor/ActionGuardarTipoServicioProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	ConfirmSave:{url:direccion+'../../../control/tipo_servicio_proveedor/ActionGuardarTipoServicioProveedor.php',parametros:'&m_id_proveedor='+maestro.id_proveedor},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'tipo_servicio_proveedor'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_proveedor=datos.m_id_proveedor;
	maestro.codigo=datos.m_codigo
	maestro.nombre_proveedor=datos.m_nombre_proveedor

		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proveedor:maestro.id_proveedor
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['id_proveedor',maestro.id_proveedor],['codigo',maestro.codigo],['Proveedor',maestro.nombre_proveedor]]);
		Atributos[7].defecto=maestro.id_proveedor;
		paramFunciones.btnEliminar.parametros='&m_id_proveedor='+maestro.id_proveedor;
		paramFunciones.Save.parametros='&m_id_proveedor='+maestro.id_proveedor;
		paramFunciones.ConfirmSave.parametros='&m_id_proveedor='+maestro.id_proveedor;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	this.btnNew=function(){
		CM_ocultarComponente(getComponente('id_servicio_propuesto'));
		getComponente('id_servicio_propuesto').allowBlank=true;
		CM_ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnNew();
	};
	
	this.btnEdit=function(){
		CM_ocultarComponente(getComponente('id_servicio_propuesto'));
		getComponente('id_servicio_propuesto').allowBlank=true;
		CM_mostrarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnEdit();
	};
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_servicio_proveedor.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_servicio_proveedor.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}