/**
* Nombre:		  	    pagina_documento_iva.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function pagina_documento_iva_compras(idContenedor,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var filtro;
	
	var monedas_for=new Ext.form.MonedaField(
		{
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
		minValue:-1000000000000}	
	);
	//alert (maestro.vista);
	//---DATA STORE
	 var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumentoIva.php?sw_debito_credito='+maestro.sw_debito_credito+''}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'
		},[
		'desc_comprobante',
		'id_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'nro_nit',		
		'nro_documento',
		'nro_autorizacion',
		'codigo_control',
		'razon_social',
		'importe_total',
		'importe_ice',
		'importe_no_gravado',
		'importe_sujeto',
		'importe_credito',
		'importe_debito'
		]),remoteSort:true});		
		
		//carga datos XML
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_moneda:maestro.id_moneda,
		m_id_depto:maestro.id_depto,
		m_gestion:maestro.gestion,
		m_periodo:maestro.periodo,
		m_desc_usuario:maestro.desc_usuario
		}});

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
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
			name:'nro_nit',
			fieldLabel:'N° NIT',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100, 
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOC.nro_nit',
		save_as:'nro_nit'
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
			width_grid:200,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'DOC.razon_social',
		save_as:'razon_social'
	};
	
		Atributos[3]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'N° Factura/Poliza',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOC.nro_documento',
		save_as:'nro_documento'
	};
		Atributos[4]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'N° Autorización',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOC.nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	Atributos[5]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fec. Factura',
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

	Atributos[6]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Total Factura',
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
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOCVAL.importe_total',
		save_as:'importe_avance'
	};

	Atributos[7]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'Importe ICE',
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
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_ice',
		save_as:'importe_ice'
	};
		Atributos[8]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe Excento',
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
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_no_gravado',
		save_as:'importe_exento'
	};
	Atributos[9]={
		validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Neto',
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
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_sujeto',
		save_as:'importe_sujeto'
	};
	
	if (maestro.vista=='ventas'){
		Atributos[10]={
			validacion:{
				name:'importe_debito',
				fieldLabel:'Débito Fiscal',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			filterColValue:'DOCVAL.importe_debito',
			save_as:'importe_debito'
		};
		
	}else {
		Atributos[10]={
			validacion:{
				name:'importe_credito',
				fieldLabel:'Crédito Fiscal',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			filterColValue:'DOCVAL.importe_credito',
			save_as:'importe_credito'
		};
	}
	
	Atributos[11]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'DOC.codigo_control',
		save_as:'codigo_control'
	};
	

	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
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
		titulo_maestro:'Documentos IVA',
		grid_maestro:'grid-'+idContenedor
	};
    layout_documento_iva_compras=new DocsLayoutMaestro(idContenedor);
	layout_documento_iva_compras.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_documento_iva_compras,idContenedor);
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
			titulo:'Documentos Libro IVA',
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
	function mostrarActual(resp)
	{
		if(g_comprobante=='')
		{	//alert ("llega a new ");
			ds.load({
				params:{
					start:0,
					limit:paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_sw_maximo:'si'
				}
			})
		}
		else
		{
			//alert ("llega a edit ");
			ds.load({
				params:{
					start:0,
					limit:paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_comprobante:g_comprobante
										
					
				}
			});
		}
		CM_saveSuccess(resp);
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_moneda:maestro.id_moneda,
            	m_gestion:maestro.gestion,
                m_periodo:maestro.periodo,
                m_desc_periodo:maestro.desc_periodo,
                vista:maestro.vista
                
			}
		};
		alert (maestro.vista);
		this.btnActualizar();
	};
	
	function iniciarEventosFormularios(){
		getSelectionModel().on('rowdeselect');
	}
	
	function btn_reporte_libro_compras(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
       	window.open(direccion+'../../../control/documento/reporte/ActionPDFLibroComprasA.php?id_moneda='+maestro.id_moneda+'&txt_gestion='+maestro.gestion+'&txt_desc_moneda='+maestro.desc_moneda+'&m_periodo='+maestro.periodo+'&sw_debito_credito='+maestro.sw_debito_credito+'&id_depto='+maestro.id_depto+'&codigo_depto='+maestro.codigo_depto+'&desc_periodo='+maestro.desc_periodo+'&desc_usuario='+maestro.desc_usuario+'&vista_reporte='+maestro.vista)
       
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_documento_iva_compras.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro de Compras',btn_reporte_libro_compras,true,'reporte_libro_compras','');
	layout_documento_iva_compras.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
