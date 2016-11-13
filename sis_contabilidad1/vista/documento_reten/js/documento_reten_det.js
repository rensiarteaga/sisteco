/**
* Nombre:		  	    pagina_documento_iva.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function pagina_documento_reten_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var filtro;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'mes_01',
		fieldLabel:'Enero',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000	
	});
	
	//---DATA STORE
	 var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumentoReten.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'
		},[
		'desc_comprobante',
		'id_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'desc_plantilla',		
		'nro_documento',
		'razon_social',
		'importe_total',
		'importe_iue',
		'importe_it',
		'importe_credito',
		'importe_neto'
		]),remoteSort:true
	 });
	 
	//--RENDER
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	 
	//carga datos XML
	// txt desc_comprobate
	Atributos[0]={
		validacion:{
			name:'desc_comprobante',
			fieldLabel:'N° Cbte.',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'desc_comprobante',
		save_as:'desc_comprobante'
	};
	
	Atributos[1]={
		validacion:{
			name:'desc_plantilla',
			fieldLabel:'Retención',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:220, 
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PLAN.desc_plantilla',
		save_as:'desc_plantilla'
	};
	
	Atributos[2]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'DOC.razon_social',
		save_as:'razon_social'
	};
	
	Atributos[3]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha',
			allowBlank:false,
			align:'right',
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'DOC.fecha_documento',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_documento'
	};
	
	Atributos[4]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'N° Recibo',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:90,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOC.nro_documento',
		save_as:'nro_documento'
	};

	Atributos[5]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:false, 
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOCVAL.importe_total',
		save_as:'importe_avance'
	};

	Atributos[6]={
		validacion:{
			name:'importe_iue',
			fieldLabel:'Importe IUE',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_iue',
		save_as:'importe_iue'
	};
		
	Atributos[7]={
		validacion:{
			name:'importe_it',
			fieldLabel:'Importe IT',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_it',
		save_as:'importe_it'
	};
	
	Atributos[8]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'RC-IVA',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_credito',
		save_as:'importe_credito'
	};
	
	Atributos[9]={
		validacion:{
			name:'importe_neto',
			fieldLabel:'Importe Líquido',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_neto',
		save_as:'importe_neto'
	};

	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			fieldLabel:'ID Documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};
 
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro:'Documentos de Retención',
		grid_maestro:'grid-'+idContenedor
	};
    layout_documento_reten_det=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
    layout_documento_reten_det.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_documento_reten_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_saveSuccess=this.saveSuccess;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},	
		actualizar:{crear:true,separador:false}
	};
	
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/categoria/ActionEliminarDocumento.php"
		},
		Save:{
			url:direccion+"../../../control/documento/ActionGuardarDocumentoIva.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/documento/ActionGuardarDocumentoIva.php"
		},
		Formulario:{
			titulo:'Documentos de Retención',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'50%',
			minWidth:150,
			minHeight:100,
			columnas:['95%'],
			closable:true
		}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	this.reload=function(m){
		var datos=Ext.urlDecode(decodeURIComponent(m));
		maestro=datos;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_depto:maestro.id_depto,
				m_gestion:maestro.desc_gestion,
				m_periodo:maestro.id_periodo,
				m_id_moneda:maestro.id_moneda,
				sw_retencion:maestro.sw_retencion,
				por_comprobante:maestro.por_comprobante,
				toda_gestion:maestro.toda_gestion,
				sw_totales:maestro.sw_totales
			}
		};
		this.btnActualizar();
	};
	
	function iniciarEventosFormularios(){}
	
	function btn_reporte_jasper(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if (maestro.sw_totales == 'false'){
				window.open(direccion+'../../../control/documento/reporte/ActionPDFLibroRetenJasper.php?id_depto='+maestro.id_depto+'&id_periodo='+maestro.id_periodo+
				'&id_moneda='+maestro.id_moneda+'&id_usuario='+maestro.id_usuario+'&sw_retencion='+maestro.sw_retencion+
				'&desc_usuario='+maestro.desc_usuario+'&doc_id='+maestro.doc_id+'&desc_gestion='+maestro.desc_gestion+'&desc_periodo='+maestro.desc_periodo+
				'&por_comprobante='+maestro.por_comprobante+'&toda_gestion='+maestro.toda_gestion+'&tipo_reporte='+maestro.tipo_reporte);
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_documento_reten_det.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Libro de Retenciones (pdf, xls, doc)',btn_reporte_jasper,true,'reporte_libro_jasper','Reporte');
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_depto:maestro.id_depto,
			m_gestion:maestro.desc_gestion,
			m_periodo:maestro.id_periodo,
			m_id_moneda:maestro.id_moneda,
			sw_retencion:maestro.sw_retencion,
			por_comprobante:maestro.por_comprobante,
			toda_gestion:maestro.toda_gestion,
			sw_totales:maestro.sw_totales
		}
	});
	
	layout_documento_reten_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
