/**
* Nombre:		  	    pagina_tra_act.js
* Propósito: 			pagina objeto principal
* Autor:				avq
* Fecha creación:		17/12/2010
*/
function pag_tra_act(idContenedor,direccion,paramConfig,idContenedorPadre,maestro)
{
	var Atributos=new Array,sw=0;

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
	//alert(maestro.id_actualizacion_detalle);
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/transaccion_actualizacion/ActionListarTransaccionActualizacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transaccion_actualizacion',
			//id:'id_item',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_transaccion_actualizacion',
 		'id_transaccion',
 		'identificador',
  		'saldo',
  		'saldo_actualizado',
  		'id_actualizacion_detalle',
  		'importe_moneda_actualizacion',
  		'tipo_actualizacion',
  		'tipo_cambio_inicial',
  		'tipo_cambio_final',
  		'diferencial_actualizacion',
  		'id_actualizacion_detalle_saldo',
 		{name: 'fecha',type:'date',dateFormat:'Y-m-d'}
	]),remoteSort:true});
	
	//FUNCIONES RENDER
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	//DATA STORE COMBOS
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_actualizacion_detalle:maestro.id_actualizacion_detalle
		}
	});
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_cotizacion_det
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transaccion_actualizacion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'ID',
			name:'id_comprobante',
			grid_visible:false,
			grid_editable:false,
			width_grid:20,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false
	};
	
	Atributos[2]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'fecha',
	};
	
	Atributos[3]={
		validacion:{
			name:'importe_moneda_actualizacion',
			fieldLabel:'Importe Moneda',
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
			width_grid:150,
			renderer: render_total,
			disabled:false	
		},
		tipo: 'NumberField',
		filtro_0:false
	};
	
	Atributos[4]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
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
			renderer: render_total,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:false
	};

	Atributos[5]={
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
			width_grid:180,
			width:100,
			disabled:false	
		},
		tipo: 'NumberField',
		filtro_0:false
	};	
	
	Atributos[6]={
		validacion:{
			name:'saldo_actualizado',
			fieldLabel:'Saldo Actualizado',
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
			width_grid:180,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:false
	};
	
	Atributos[7]={
		validacion:{
			name:'tipo_cambio_inicial',
			fieldLabel:'TC Inicial',
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
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:false
	};	
	
	Atributos[8]={
		validacion:{
			name:'tipo_cambio_final',
			fieldLabel:'TC Final',
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
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:false
	};	
	
	Atributos[9]={
		validacion:{
			name:'tipo_actualizacion',
			fieldLabel:'Actualización',
			allowBlank:true,
			align:'center', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:false
	};	
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Actualizaciones Detalle ',titulo_detalle:'Transacciones Actualización',grid_maestro:'grid-'+idContenedor};
	var layout_transaccion= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_transaccion.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_transaccion,idContenedor);
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
		excel:{crear:true,separador:false}
	};
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Detalle de Cotización',
	}};
 
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/actualizacion_detalle/ActionListarActualizacionDetalle.php?id_actualizacion_detalle='+maestro.id_actualizacion_detalle+'&vista=hijo'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actualizacion_detalle',totalRecords: 'TotalCount'},['id_actualizacion_detalle',
	    'desc_presupuesto',
		'cuenta',
		'auxiliar',
		'desc_orden',
		'cuenta_actualizacion',
		'auxiliar_actualizacion',
		])
	});
	
	ds_maestro.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_actualizacion_detalle:maestro.id_actualizacion_detalle
		},
		callback:cargar_maestro
	});

	function cargar_maestro(){
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Presupuesto',ds_maestro.getAt(0).get('desc_presupuesto')],['Cuenta',ds_maestro.getAt(0).get('cuenta')],['Auxiliar',ds_maestro.getAt(0).get('auxiliar')],['Orden Trabajo',ds_maestro.getAt(0).get('desc_orden')],['Cuenta Actualizada',ds_maestro.getAt(0).get('cuenta_actualizacion')],['Auxiliar Actualizacion',ds_maestro.getAt(0).get('auxiliar_actualizacion')]]));
	}

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		var datos= Ext.urlDecode(decodeURIComponent(m));
		maestro.id_actualizacion_detalle=datos.id_actualizacion_detalle;
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_actualizacion_detalle:maestro.id_actualizacion_detalle,
				vista:'hijo'
			},
			callback:cargar_maestro
		});
	
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_actualizacion_detalle:maestro.id_actualizacion_detalle
			}
		});
		Atributos[1].defecto=maestro.id_actualizacion_detalle;
		this.InitFunciones(paramFunciones)
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_transaccion.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_transaccion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
