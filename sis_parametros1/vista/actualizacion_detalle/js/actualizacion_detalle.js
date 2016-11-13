/**
* Nombre:		  	    pagina_act_det.js
* Propósito: 			pagina objeto principal
* Autor:				Avillegas
* Fecha creación:		15/12/2010
*/
function pag_act_det(idContenedor,direccion,paramConfig,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/actualizacion_detalle/ActionListarActualizacionDetalle.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actualizacion_detalle',
			totalRecords: 'TotalCount'
		}, [
			// define el mapeo de XML a las etiquetas (campos)
			'id_actualizacion_detalle',
			'desc_presupuesto',
			'cuenta',
			'auxiliar',
			'desc_orden',
			'cuenta_actualizacion',
			'auxiliar_actualizacion',
			'moneda',
			'saldo_moneda',
			'saldo_anterior',
			'diferencial_actualizacion',
			'valor_actualizado'
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
			name: 'id_actualizacion_detalle',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_actualizacion_detalle'
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'Presupuesto',
			name:'desc_presupuesto',
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'desc_presupuesto'
	};
	
	Atributos[2]={
		validacion:{
			fieldLabel:'Cuenta',
			name:'cuenta',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'cuenta'
	};	
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Auxiliar',
			name:'auxiliar',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
			
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'auxiliar'
	};	
	
	Atributos[4]={
		validacion:{
			fieldLabel:'O.T.',
			name:'desc_orden',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'desc_orden'
	};	
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Cta.Actualización',
			name:'cuenta_actualizacion',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'cuenta_actualizacion'
	};	
	
	Atributos[6]={
		validacion:{
			fieldLabel:'Aux.Actualización',
			name:'auxiliar_actualizacion',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'auxiliar_actualizacion'
	};
	
	Atributos[7]={
		validacion:{
			fieldLabel:'Moneda',
			name:'moneda',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo:'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'moneda',
	};	
	
	Atributos[8]={
		validacion:{
			name:'saldo_moneda',
			fieldLabel:'Saldo Moneda',
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
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'saldo_moneda' 
	};	
	
	Atributos[9]={
		validacion:{
			name:'saldo_anterior',
			fieldLabel:'Saldo Anterior',
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
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'saldo_anterior'
		 
	};	
	Atributos[10]={
		validacion:{
			name:'diferencial_actualizacion',
			fieldLabel:'Diferencial',
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
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'diferencial_actualizacion'
	};	
	
	Atributos[11]={
		validacion:{
			name:'valor_actualizado',
			fieldLabel:'Valor Actualizado',
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
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'valor_actualizado'
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
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Detalle de Cotización',
	}};
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
	    maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_actualizacion:maestro.id_actualizacion,
				m_id_moneda:g_id_moneda
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_actualizacion;
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
					m_id_actualizacion:maestro.id_actualizacion,
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
	
	//para agregar botones
	function btn_detalle_transaccion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_actualizacion_detalle='+SelectionsRecord.data.id_actualizacion_detalle;
			
			var ParamVentana={Ventana:{width:1100,height:380}}
				layout_act.loadWindows(direccion+'../../../../sis_parametros/vista/transaccion_actualizacion/transaccion_actualizacion.php?idSub=Actualización Detalle Trnsacción&'+data,'Transaccion Actualizacion',ParamVentana);
				layout_act.getVentana().on('resize',function(){
					layout_act.getLayout().layout();
				})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	
	this.AdicionarBotonCombo(monedas,'monedas');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Detalle de la Transacción',btn_detalle_transaccion,true,'detalle_transaccion','Detalle Transacción');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_act.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
