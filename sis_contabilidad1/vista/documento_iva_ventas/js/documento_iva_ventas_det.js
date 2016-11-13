/**
* Nombre:		  	    pagina_documento_iva.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function pagina_documento_iva_ventas_det(idContenedor,direccion,paramConfig,maestro){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var filtro;
	
	//---DATA STORE
	    var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumentoIva.php?sw_debito_credito=2'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'',totalRecords:'TotalCount'
		},[
		'desc_comprobante',
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
		'importe_debito',
		
		]),remoteSort:true});
		//carga datos XML
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_moneda:maestro.id_moneda,
		m_fecha_inicio:maestro.fecha_inicio,
		m_fecha_fin:maestro.fecha_fin,
		m_id_depto:maestro.id_depto
		}});
	 
    	// txt desc_comprobate
		Atributos[0]={
			validacion:{
				name:'desc_comprobante',
				fieldLabel:'Comprobante',
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
				fieldLabel:'Nro de NIT Cliente',
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
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOC.razon_social',
			save_as:'razon_social'
		};
		Atributos[3]={
			validacion:{
				name:'nro_documento',
				fieldLabel:'Nro de Factura',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOC.nro_documento',
			save_as:'nro_documento'
		};
		
		Atributos[4]= {
			validacion:{
				name:'nro_tramite',
				fieldLabel:'Número Tramite ',
				allowBlank:false,
				align:'right',
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'DOC.fecha_documento',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_documento'
		};
		
		
		
		Atributos[5]= {
			validacion:{
				name:'fecha_documento',
				fieldLabel:'Fecha Factura',
				allowBlank:false,
				align:'right',
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			tipo:'DateField',
			filtro_0:true,
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOCVAL.importe_total',
			save_as:'importe_total'
		};
		Atributos[7]={
			validacion:{
				name:'importe_ice',
				fieldLabel:'Total I.C.E.',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOCVAL.importe_no_gravado',
			save_as:'importe_no_gravado'
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOCVAL.importe_sujeto',
			save_as:'importe_sujeto'
		};
		Atributos[10]={
			validacion:{
				name:'importe_debito',
				fieldLabel:'Debito Fiscal IVA',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'DOCVAL.importe_debito',
			save_as:'importe_debito'
		}
		
		Atributos[11]={
			validacion:{
				name:'sw_factura',
				fieldLabel:'Factura Valida o Anulada',
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
				width_grid:100,
				width:100,
				disabled:true
			},
			tipo: 'TextField'
			//filtro_0:true,
			//filterColValue:'DOCVAL.importe_debito',
			//save_as:'importe_debito'
		};
		
		Atributos[12]={
			validacion:{
				name:'codigo_control',
				fieldLabel:'Código de control',
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
			filterColValue:'DOC.codigo_control',
			save_as:'codigo_control'
		};

     
		// ----------            FUNCIONES RENDER    ---------------//
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		//---------- INICIAMOS LAYOUT DETALLE
		var config = {
		titulo_maestro:'cuenta',
		grid_maestro:'grid-'+idContenedor
	};
	    layout_documento_iva_ventas_det=new DocsLayoutMaestro(idContenedor);
		layout_documento_iva_ventas_det.init(config);
	
		// INICIAMOS HERENCIA //
		this.pagina=Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_documento_iva_ventas_det,idContenedor);
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
				actualizar:{crear:true,separador:false}
		};
    	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		function mostrarActual(resp)
		{
 		if(g_comprobante=='')
			{	alert ("llega a new ");
				ds.load({
					params:{
						start:0,
						limit:paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_sw_maximo:'si'
					}
				})
			}
			else{
				alert ("llega a edit ");
				ds.load({
					params:{
						start:0,
						limit:paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_comprobante:g_comprobante
											
						
					}
				});}
			CM_saveSuccess(resp);
		}
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//Para manejo de eventos
		this.reload=function(m){
				maestro=m;
               // alert (maestro.id_avance);
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_moneda:maestro.id_moneda,
	                	m_fecha_inicio:maestro.fecha_inicio,
		                m_fecha_fin:maestro.fecha_fin
					}
				};
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
			window.open(direccion+'../../../control/documento/reporte/ActionPDFLibroCompras.php?id_moneda='+maestro.id_moneda+'&txt_desc_moneda='+maestro.desc_moneda+'&txt_fecha_inicio='+maestro.fecha_inicio+'&txt_fecha_fin='+maestro.fecha_fin+'&sw_debito_credito=2&id_depto='+maestro.id_depto+'&codigo_depto='+maestro.codigo_depto);
		}
    	//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_documento_iva_ventas_det.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.iniciaFormulario();
		iniciarEventosFormularios();
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro de Compras',btn_reporte_libro_compras,true,'reporte_libro_compras','');
		layout_documento_iva_ventas_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
