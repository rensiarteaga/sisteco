/**
* Nombre:		  	    pagina_log_det.js
* Propósito: 			pagina objeto principal
* Autor:				Avillegas
* Fecha creación:		15/12/2010
*/
function pag_log_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var g_id_moneda;
	
	var monedas_for=new Ext.form.MonedaField({
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarTransaccionLog.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transaccion',
			totalRecords: 'TotalCount'
		}, [
			// define el mapeo de XML a las etiquetas (campos)
			'id_transaccion',
			'desc_presupuesto',
			'desc_partida_cuenta',
			'desc_auxiliar',
			'desc_orden_trabajo',
			'concepto_tran',
			'importe_debe',
			'importe_haber',
			'importe_gasto',
			'importe_recurso'
		]),remoteSort:true});
	
	//FUNCIONES RENDER
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_cotizacion_det
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transaccion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'Presupuesto',
			name:'desc_presupuesto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo:'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'desc_presupuesto'
	};
	
	Atributos[2]={
		validacion:{
			fieldLabel:'Cuenta - Partida',
			name:'desc_partida_cuenta',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo:'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'desc_partida_cuenta'
	};	
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Auxiliar',
			name:'desc_auxiliar',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filterColValue:'desc_auxiliar'
	};	
	
	Atributos[4]={
		validacion:{
			fieldLabel:'O.T.',
			name:'desc_orden_trabajo',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filterColValue:'desc_orden_trabajo'
	};	
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Concepto',
			name:'concepto_tran',
			grid_visible:true,
			grid_editable:false,
			width_grid:220
		},
		tipo:'Field',
		form:false,
		filtro_0:false,
		filterColValue:'concepto_tran'
	};	
	
	Atributos[6]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Debe',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			renderer: render_total,
			disabled:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		filterColValue:'importe_debe' 
	};	
	
	Atributos[7]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Haber',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			renderer: render_total,
			disabled:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		filterColValue:'importe_haber'
		 
	};	
	Atributos[8]={
		validacion:{
			name:'importe_gasto',
			fieldLabel:'Gasto',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			renderer: render_total,
			disabled:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		filterColValue:'importe_gasto'
	};	
	
	Atributos[9]={
		validacion:{
			name:'importe_recurso',
			fieldLabel:'Recurso',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:100,
			renderer: render_total,
			disabled:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:true,
		filterColValue:'importe_recurso',
		id_grupo:0
	};
  
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cotizaciones ',grid_maestro:'grid-'+idContenedor};
	var layout_act= new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_act.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_act,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var enableSelect=this.EnableSelect;
	var EstehtmlMaestro=this.htmlMaestro;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={			
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:true}
	};
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Detalle de log',grupos:[{
			tituloGrupo:'Datos de Actualización',
			columna:0,
			id_grupo:0}]
	}};
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
	    maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_combrobante:maestro.id_comprobante_log,
				m_id_moneda:g_id_moneda
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_comprobante_log;
		
		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
	}
	
	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
	});
	 
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#0000ff"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	var monedas =new Ext.form.ComboBox({
		store: ds_moneda_consulta,
		displayField:'nombre',
		typeAhead: true,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'Seleccionar moneda...',
		selectOnFocus:true,
		width:135,
		valueField: 'id_moneda',
		//  renderer:render_id_moneda
		tpl:tpl_id_moneda_reg
		
	});

	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	
	monedas.on('select',
		function (combo, record, index){
			g_id_moneda=record.data.id_moneda;
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_combrobante:maestro.id_comprobante_log,
					m_id_moneda:record.data.id_moneda
				},
			callback : function (){}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_act.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBotonCombo(monedas,'monedas');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_act.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
