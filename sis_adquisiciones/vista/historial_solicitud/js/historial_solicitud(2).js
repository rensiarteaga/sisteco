/**
 * Nombre:		  	    pagina_historial_solicitud.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-23 09:20:50
 */
function pagina_historial_solicitud(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_proceso/ActionListarHistorialSolicitud.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_estado_proceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_estado_proceso',
		'estado_reg',
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		'id_estado_compra_categoria_adq',
		'id_solicitud_compra',
		'tipo_estado',
		'proceso',
		'cotizacion'
		

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_solicitud_compra:maestro.id_solicitud_compra
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['id_solicitud_compra',maestro.id_solicitud_compra],['Solicitante',maestro.desc_empleado_tpm_frppa],['Moneda',maestro.desc_moneda],['Centro',maestro.desc_unidad_organizacional]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    var ds_estado_compra_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_compra_categoria_adq/ActionListarEstadoCompraCategoriaAdq.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_estado_compra_categoria_adq',totalRecords:'TotalCount'},['id_estado_compra_categoria_adq','dias_min','dias_max','orden','id_estado_compra','id_tipo_categoria_adq'])
	});

    var ds_proceso_compra = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompra.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'},['id_proceso_compra','observaciones','codigo_proceso','fecha_reg','estado_vigente','id_tipo_categoria_adq','id_moneda','num_cotizacion','num_proceso','siguiente_estado','periodo','gestion','num_cotizacion_sis','num_proceso_sis','fecha_proc','id_tipo_adq'])
	});

    var ds_cotizacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion/ActionListarCotizacion.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion',totalRecords:'TotalCount'},['id_cotizacion','fecha_venc','fecha_reg','estado_cotizacion','impuestos','garantia','lugar_entrega','forma_pago','fecha_validez_oferta','fecha_entrega','fecha_limite','tipo_entrega','observaciones','id_proceso_compra','id_moneda','id_proveedor','id_tipo_categoria_adq','precio_total','figura_acta','num_factura','num_orden_compra','estado_vigente','estado_reg','nombre_pago','siguiente_estado','periodo','gestion','num_orden_compra_sis','num_cotizacion','num_cotizacion_sis'])
	});

	//FUNCIONES RENDER
	
	function render_id_estado_compra_categoria_adq(value, p, record){return String.format('{0}', record.data['desc_estado_compra_categoria_adq']);}
	var tpl_id_estado_compra_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{orden}</i></b>','<br><FONT COLOR="#B5A642">{orden}</FONT>','</div>');

	function render_id_proceso_compra(value, p, record){return String.format('{0}', record.data['desc_proceso_compra']);}
	var tpl_id_proceso_compra=new Ext.Template('<div class="search-item">','<b><i>{id_tipo_categoria_adq}</i></b>','<br><FONT COLOR="#B5A642">{codigo_proceso}</FONT>','</div>');

	function render_id_cotizacion(value, p, record){return String.format('{0}', record.data['desc_cotizacion']);}
	var tpl_id_cotizacion=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{observaciones}</FONT>','</div>');
;
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_estado_proceso
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_estado_proceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_estado_proceso'
	};
// txt estado_reg
	Atributos[1]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'estado_reg',
		save_as:'estado_reg'
	};
// txt fecha_fin
	Atributos[2]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin'
	};
// txt fecha_ini
	Atributos[3]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:5		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini'
	};
// txt observaciones
	Atributos[4]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disable:false,
			grid_indice:7		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'observaciones',
		save_as:'observaciones'
	};
// txt id_estado_compra_categoria_adq
	Atributos[5]={
		validacion:{
			name:'id_estado_compra_categoria_adq',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_estado_compra_categoria_adq'
	};
// txt id_solicitud_compra
	Atributos[6]={
		validacion:{
			name:'id_solicitud_compra',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_solicitud_compra,
		save_as:'id_solicitud_compra'
	};
	
	Atributos[7]={
		validacion:{
			name:'tipo_estado',
			fieldLabel:'Tipo Estado',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'estado_reg',
		save_as:'tipo_estado'
	};
	
	Atributos[1]={
		validacion:{
			name:'proceso',
			fieldLabel:'Proceso',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'proceso',
		save_as:'proceso'
	};
	
	Atributos[1]={
		validacion:{
			name:'cotizacion',
			fieldLabel:'Cotización',
			allowBlank:false,
			maxLength:20,
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
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'cotizacion',
		save_as:'cotizacion'
	};
	
	


	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro)',titulo_detalle:'Historial Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_historial_solicitud = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_historial_solicitud.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_historial_solicitud,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_solicitud_compra=datos.m_id_solicitud_compra;


maestro.desc_empleado_tpm_frppa=datos.m_desc_empleado_tpm_frppa
maestro.desc_moneda=datos.m_desc_moneda

maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra
			}
		};
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['id_solicitud_compra',maestro.id_solicitud_compra],['observaciones',maestro.id_tipo_adq],['localidad',maestro.num_solicitud],['Solicitante',maestro.desc_empleado_tpm_frppa],['Moneda',maestro.desc_moneda],['Estructura Programatica',maestro.desc_fina_regi_prog_proy_acti],['Centro',maestro.desc_unidad_organizacional],['id_moneda',maestro.num_solicitud_sis]]);
		
		
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_historial_solicitud.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_historial_solicitud.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}