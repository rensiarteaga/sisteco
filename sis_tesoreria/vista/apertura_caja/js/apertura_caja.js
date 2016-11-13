/**
 * Nombre:		  	    pagina_apertura_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 08:22:08
 */
function pagina_apertura_caja(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var g_sw_contabilizar;
	
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
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarAperturaCaja.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja',totalRecords:'TotalCount'
		},[		
		'id_caja',
		'tipo_caja',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		'importe_maximo',
		'porcentaje_compra',
		'porcentaje_rinde',
		'estado_caja',
		'nombre_unidad',
		'nombre',
		'nro_recibo',
		'nro_vale',
		'nro_rinde',
		'sw_contabilizar'
		//'id_comprobante'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	function renderEstado(value, p, record){
		if(value == 1){return "Abierto"}
		if(value == 2){return "Cerrado"}
	}	
	
	function renderTipo(value, p, record){
		if(value == 1){return "Caja"}
		if(value == 2){return "Caja Chica"}
		if(value == 3){return "Fondo Rotatorio"}
	}	
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja',
			fieldLabel:'ID',
			inputType:'hidden',
			align:'right',
			width_grid:60,
			grid_indice:1,
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja'
	};
// txt tipo_caja
	Atributos[1]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo Caja',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Caja'],['2','Caja Chica'],['3','Fondo Rotatorio']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			minListWidth:'100%',
			disable:false,
			grid_indice:2,
			renderer:renderTipo	
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		defecto:'1',
		save_as:'tipo_caja'
	};
	
// txt fecha_inicio
	Atributos[2]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha de Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:90,
			disabled:false,
			grid_indice:5		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJA.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio'
	};
// txt importe_maximo
	Atributos[3]={
		validacion:{
			name:'importe_maximo',
			fieldLabel:'Importe Máximo',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			renderer: render_total,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false,
			grid_indice:6	
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.importe_maximo',
		save_as:'importe_maximo'
	};
	// txt porcentaje_compra
	Atributos[4]={
		validacion:{
			name:'porcentaje_compra',
			fieldLabel:'% Compra',
			allowBlank:false,
			align:'right', 
			maxValue:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false,
			grid_indice:7		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_compra',
		save_as:'porcentaje_compra'
	};
	// txt porcentaje_rinde
	Atributos[5]={
		validacion:{
			name:'porcentaje_rinde',
			fieldLabel:'% Rendicion',
			allowBlank:false,
			align:'right', 
			maxValue:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false,
			grid_indice:7		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_rinde',
		save_as:'porcentaje_rinde'
	};
	// txt estado_caja
	Atributos[6]={
		validacion:{
			name:'estado_caja',
			fieldLabel:'Estado Caja',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Abierto'],['2','Cerrado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:8,
			renderer:renderEstado		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		defecto:'1',
		filterColValue:'CAJA.estado_caja',
		save_as:'estado_caja'
	};
	
// txt nombre_unidad
	Atributos[7]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'nombre_unidad'
	};

	Atributos[8]={
		validacion:{
			name:'nombre',
			fieldLabel:'Moneda',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'MONEDA.nombre',
		save_as:'nombre'
	};
	
	Atributos[9]={
		validacion:{
			name:'nro_recibo',
			fieldLabel:'Nro Recibo',
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
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.nro_recibo',
		save_as:'nro_recibo'
	};
	
	Atributos[10]={
		validacion:{
			name:'nro_vale',
			fieldLabel:'Nro Vale',
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
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.nro_vale',
		save_as:'nro_vale'
	};
	
	Atributos[11]={
		validacion:{
			name:'nro_rinde',
			fieldLabel:'Nro Rendición',
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
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.nro_rinde',
		save_as:'nro_rinde'
	};
	
	Atributos[12]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'sw_contabilizar'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Apertura Caja',grid_maestro:'grid-'+idContenedor};
	var layout_apertura_caja=new DocsLayoutMaestro(idContenedor);
	layout_apertura_caja.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_apertura_caja,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_enableSelect=this.EnableSelect;
	var ClaseMadre_save=this.Save;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja/ActionEliminarAperturaCaja.php'},
		Save:{url:direccion+'../../../control/caja/ActionGuardarAperturaCaja.php'},
		ConfirmSave:{url:direccion+'../../../control/caja/ActionGuardarAperturaCaja.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Apertura Caja'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	 	g_sw_contabilizar= ClaseMadre_getComponente('sw_contabilizar');
	 	g_sw_contabilizar.setVisible(false);
	}
	
	function btnAperturar(){
		CM_btnEdit();	
	}		
	
	function btnContabilizar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			if(SelectionsRecord.data.fecha_inicio!=''){	
				var sw=false;
				if(confirm('Esta seguro de contabilizar la caja?'))
						{sw=true}
				if(sw){		
					g_sw_contabilizar.setValue('1');
					ClaseMadre_save();
					//CM_btnEdit();
					g_sw_contabilizar.setValue('0');
				}				
			}else{	
				Ext.MessageBox.alert('Estado','La caja seleccionada no esta inicializada.')
			}	
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una solicitud.')
	    }	
	}
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_apertura_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'Inicializar Caja',btnAperturar,true, 'Abrir_Caja','Abrir Caja');
	//this.AdicionarBoton("../../../lib/imagenes/det.ico",'Contabilizar',btnContabilizar,true, 'Contabilizar_Caja','Contabilizar Caja');
	
	var CM_getBoton=this.getBoton;
	CM_getBoton('Abrir_Caja-'+idContenedor).enable();			
	
	function  enable(sel,row,selected){			
		var record=selected.data;
		
		if(selected&&record!=-1){ 
		   if(record.estado_caja=='1'){
		       	CM_getBoton('Abrir_Caja-'+idContenedor).disable();
	       }else{
	       		CM_getBoton('Abrir_Caja-'+idContenedor).enable();
	       }
		}
		CM_enableSelect(sel,row,selected);				
	}	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_apertura_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}