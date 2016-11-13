/**
 * Nombre:		  	    pagina_gestion_subsistema.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2008-12-01 16:05:16
 */
function paginaBancarizacionDet(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var ds;
	var elementos=new Array();
	var maestro=new Array();
	var componentes=new Array;
	var dialog;
	var form;
	var layout_bancarizacion_det;
	
	var monedas_for=new Ext.form.MonedaField(
			{
				name:'importe',
				fieldLabel:'valor',	
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
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/bancarizacion_det/ActionListarBancarizacionDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_bancarizacion_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_bancarizacion_det',
		'id_bancarizacion',
		'tipo_operacion',
		'modalidad',
		'id_comprobante_dev',
		'comprobante_dev',
		'id_comprobante_pago',
		'comprobante_pago',
		'id_transaccion_pago',
		'concepto_tran',
		'id_transac_valor_pago',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_usuario_reg',
		'login',
		'id_documento',
		'desc_documento',
		'id_subsistema',
		'nombre_corto',
		'id_depto',
		'nombre_depto',
		'importe_debe',
		'importe_haber',
		'origen', 
		'acumulado'
		]),remoteSort:true});
	
	//FUNCIONES RENDER
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	// DEFINICI�N DATOS DEL MAESTRO
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_gestion_subsistema
	//en la posici�n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_bancarizacion_det',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};
// txt id_bancarizacion
	Atributos[1]={
		validacion:{
			name:'id_bancarizacion',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_bancarizacion
	};
// txt tipo_operacion
	Atributos[2]={
		validacion:{
			name:'tipo_operacion',
			fieldLabel:'Tipo Operacion',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,		
		filterColValue:'BANCDET.tipo_operacion',
	};
// txt modalidad
	Atributos[3]={
		validacion:{
			name:'modalidad',
			fieldLabel:'Modalidad',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'BANCDET.modalidad',
	};		
// txt id_comprobante_dev
	Atributos[4]={
		validacion:{
			name:'id_comprobante_dev',
			labelSeparator:'',
			fieldLabel:'ID Cbte Dev',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};

// txt comprobante_dev
	Atributos[5]={
		validacion:{
			name:'comprobante_dev',
			fieldLabel:'Comprobante Dev',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'COMDEV.concepto_cbte',
	};
// txt id_comprobante_pago
	Atributos[6]={
		validacion:{
			name:'id_comprobante_pago',
			labelSeparator:'',
			fieldLabel:'ID Cbte Pago',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};

// txt comprobante_pago
	Atributos[7]={
		validacion:{
			name:'comprobante_pago',
			fieldLabel:'Comprobante Pago',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'COMPAG.concepto_cbte',
	};
// txt id_transaccion_pago
	Atributos[8]={
		validacion:{
			name:'id_transaccion_pago',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};

// txt concepto_tran
	Atributos[9]={
		validacion:{
			name:'concepto_tran',
			fieldLabel:'Transaccion Pago',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TRANSAC.concepto_tran',
	};					
// txt id_transac_valor_pago
	Atributos[10]={
		validacion:{
			name:'id_transac_valor_pago',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};
// txt id_documento
	Atributos[11]={
		validacion:{
			name:'id_documento',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};

// txt desc_documento
	Atributos[12]={
		validacion:{
			name:'desc_documento',
			fieldLabel:'Documento',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento#DOCUME.razon_social',
	};	
// txt id_subsistema
	Atributos[13]={
		validacion:{
			name:'id_subsistema',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};
// txt nombre_corto
	Atributos[14]={
		validacion:{
			name:'nombre_corto',
			fieldLabel:'Susbistema',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'SUBSIS.nombre_corto',
	};	
// txt id_depto
	Atributos[15]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};
// txt nombre_corto
	Atributos[16]={
		validacion:{
			name:'nombre_depto',
			fieldLabel:'Departamento',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto',
	};			
// txt importe_debe
	Atributos[17]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:false
	};
// txt importe_haber
	Atributos[18]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:false
	};
	// txt acumulado
	Atributos[19]={
		validacion:{
			name:'acumulado',
			fieldLabel:'Importe Acumulado',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:false
	};
	// txt origen
	Atributos[20]={
		validacion:{
			name:'origen',
			fieldLabel:'Origen',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'BANCDET.origen'
	};
						
	// txt fecha_documento
	Atributos[21]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			disabled:false		
		},
		form:false,
		tipo:'DateField',
		filtro_0:false,
		dateFormat:'m-d-Y'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Bancarizacion (Maestro)',titulo_detalle:'Detalle Bancarizacion (Detalle)',grid_maestro:'grid-'+idContenedor};
		
	layout_bancarizacion_det=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_bancarizacion_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_bancarizacion_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={actualizar:{crear:true,separador:false}};

	//DEFINICION DE FUNCIONES
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:295,	//alto
		width:400,	
		closable:true,
		titulo:'Detalle Bancarizacion'}
	};	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_bancarizacion:maestro.id_bancarizacion
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_bancarizacion;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_bancarizacion_det.getLayout()};
	//para el manejo de hijos
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_bancarizacion_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
	
}