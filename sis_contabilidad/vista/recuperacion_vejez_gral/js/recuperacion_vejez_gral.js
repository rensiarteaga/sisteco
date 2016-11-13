/**
 * Nombre:		  	    pagina_recuperacion_vejez_gral.js
 * Propósito: 			pagina objeto principal
 * Autor:				José Mita
 * Fecha creación:		2011-05-17 17:33:45
 */ 
function pagina_recuperacion_vejez_gral(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	var componentes=new Array();
	var grid;
	var sm;
	var dialog;
	var formulario;
	var NumSelect;
	
	//---DATA STORE 
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/recuperacion_vejez_gral/ActionListarRecuperacionVejezGral.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_archivo_control',totalRecords:'TotalCount'
		},[		
		'id_archivo_control',
		'id_factura',
		'nro_factura',
		'nro_autoriza',
		{name: 'fecha_envio',type:'date',dateFormat:'m-d-Y'},
		'nro_nit',
		'razon_social',
		'codigo_form',
		'numero_orden',
		'mes_per_fiscal',
		'anio_per_fiscal',
		{name: 'fecha_emision',type:'date',dateFormat:'m-d-Y'},
		'importe_factura',
		'cantidad_valor_solicitado',
		'nro_beneficiarios_directos',
		'nro_beneficiarios_indirectos',
		'cant_reg_beneficiarios',
		'importe_directo',
		'importe_indirecto',
		'importe_total',
		'cod_control',
		'estado'
		]),remoteSort:true});


	/////DATA STORE COMBOS////////////
	var ds_param=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_param',
			totalRecords:'TotalCount'
		}, ['id_param','ciudad'])
	});
	
		
	
	var ds_usr_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	
	var ds_regional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_facturacion/control/regional/ActionListarRegional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords: 'TotalCount'},['id_regional','nombre_regional','direccion','estado'])
	});
	
		
	//FUNCIONES RENDER
	
	function render_id_usr_reg(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['resp_registro']+ '</span>');}else{return String.format('{0}', record.data['resp_registro']);}}
	var tpl_id_usr_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

	function renderParam(value, p, record){return String.format('{0}', record.data['ciudad'])}
	
		
	var resultTpl=new Ext.Template('<div class="search-item">','<span>{desc_cliente} </span></br>','<tt> DocId:{doc_iden}</tt> ','<tt> Cuenta:{nro_cuenta}</tt> ','Medidor:{nroserie_med}<br/>','</div>');
	
	function render_id_regional(value, p, record){return String.format('{0}', record.data['desc_regional']);}
	var tpl_id_regional=new Ext.Template('<div class="search-item">','<b><i>{desc_regional}</b></i><br>','</div>');
			
	
	
	function render_tipo_recuperacion_vejez(value, p, record)
	{				
		if(value == 1)
		{return "recuperacion_vejez DIRECTO"}
		if(value == 2)
		{return "recuperacion_vejez CON DAÑOS A ARTEFACTOS"}		
		return 'OTRO';		
	}
	function render_estado(value, p, record)
	{	
		if(value == 5){return "Archivado"}
		if(value == 4){return "Finalizado"}
		if(value == 3){return "Generado"}
		if(value == 2){return "Factura"}
		if(value == 1){return "Registrado"}
		if(value == 0){return "Activo"}	
		return 'OTRO';		
	}
	function render_mes(value, p, record)
	{	
		if(value == 1)  
		{return "ENERO"}
		if(value == 2)
		{return "FEBRERO"}
		if(value == 3)
		{return "MARZO"}	
		if(value == 4)
		{return "ABRIL"}
		if(value == 5)
		{return "MAYO"}
		if(value == 6)
		{return "JUNIO"}
		if(value == 7)
		{return "JULIO"}
		if(value == 8)
		{return "AGOSTO"}
		if(value == 9)
		{return "SEPTIEMBRE"}
		if(value == 10)
		{return "OCTUBRE"}
		if(value == 11)
		{return "NOVIEMBRE"}
		if(value == 12)
		{return "DICIEMBRE"}
		return 'OTRO';		
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_recuperacion_vejez
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'', 
			name: 'id_archivo_control',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false		
	};
	
	Atributos[1]={
			validacion:{
				labelSeparator:'', 
				name: 'id_factura',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false		
		};
	
	// txt nro_factura
	Atributos[2]={
		validacion:{
			name:'nro_factura',
			fieldLabel:'Nro Factura',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: false,
		filtro_0:true,
		filterColValue:'fa.nro_factura',
		id_grupo:2	
	};
	// txt nro_autoriza
	Atributos[3]={
		validacion:{
			name:'nro_autoriza',
			fieldLabel:'Nro Autorización',
			allowBlank:true,
			align:'right', 
			maxLength:15,
			minLength:10,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: false,
		filtro_0:true,
		filterColValue:'ds.nro_autoriza',
		id_grupo:2		
	};
	
	// txt fecha_envio
	Atributos[4]={
		validacion:{
			name:'fecha_envio',
			fieldLabel:'Fecha envio documento',
			allowBlank:false,
			align:'center',
			format: 'd/m/Y', //formato para validacion
			//minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100		
		},
		tipo:'DateField',
		filtro_0:true,
		form:true,		
		filterColValue:'ac.fecha_envio',
		dateFormat:'m-d-Y',
		id_grupo:1
	};	
	
	// txt nro_autoriza
	Atributos[5]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'Nro NIT',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: false,
		filtro_0:true,
		filterColValue:'em.nro_nit',
		id_grupo:0		
	};
// txt hora_recuperacion_vejez
	Atributos[6]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Nombre Empresa',
			allowBlank:true,
			align:'center', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:70,
			disabled:false	
		},
		tipo: 'TextField',
		//form: true,
		filtro_0:false,		
		id_grupo:0
		
	};
		
	// txt codigo_form
	Atributos[7]={
		validacion:{
			name:'codigo_form',
			fieldLabel:'Código Formulario 200',
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
			width:'100%',
			disabled:true,
			show:200
			
		},
		tipo: 'NumberField',
		//form: true,
		defecto:200,
		filtro_0:true,
		filterColValue:'ac.codigo_form',
		id_grupo:1	
	};

	// txt numero_orden
	Atributos[8]={
		validacion:{
			name:'numero_orden',
			fieldLabel:'Número Orden F-200',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: true,
		filtro_0:true,
		filterColValue:'ac.numero_orden',
		id_grupo:1
	};


	// txt mes_per_fiscal
	Atributos[9]={
			validacion:{
		name:'mes_per_fiscal',
		fieldLabel:'Mes Periodo Fiscal',
		allowBlank:false,
		typeAhead:true,
		loadMask:true,
		triggerAction:'all',
		store: new Ext.data.SimpleStore({
			fields: ['id', 'valor'],
			data : [
			        ['1', 'Enero'],
			        ['2', 'Febrero'],
			        ['3', 'Marzo'],
			        ['4', 'Abril'],
			        ['5', 'Mayo'],
			        ['6', 'Junio'],
			        ['7', 'Julio'],
			        ['8', 'Agosto'],
			        ['9', 'Septiembre'],
			        ['10', 'Octubre'],
			        ['11', 'Noviembre'],
			        ['12', 'Diciembre']
			    ]// from states.js
		}),
		valueField:'id',
		displayField:'valor',
		lazyRender:true,
		forceSelection:true,
		renderer: render_mes,
		width_grid:170,
		width:300,
		grid_visible:true,
		grid_editable:false,
		disabled:false		
	},
	tipo:'ComboBox',
	form:true,
	id_grupo:1,
	filtro_0:false,
	filterColValue:'ac.mes_per_fiscal'	
	};
	// txt anio_per_fiscal
	Atributos[10]={
			validacion:{
		name:'anio_per_fiscal',
		fieldLabel:'Año Periodo Fiscal',
		allowBlank:false,
		typeAhead:true,
		loadMask:true,
		triggerAction:'all',
		store: new Ext.data.SimpleStore({
			fields: ['id', 'valor'],
			data : [
					['2010', '2010'],
			        ['2011', '2011'],
			        ['2012', '2012'],
			        ['2013', '2013'],
			        ['2014', '2014'],
			        ['2015', '2015'],
			        ['2016', '2016'],
			        ['2017', '2017'],
			        ['2018', '2018'],
			        ['2019', '2019'],
			        ['2020', '2020'],
			        ['2021', '2021'],
					['2022', '2022'],
					['2023', '2023'],
					['2024', '2024'],
					['2025', '2025']
			    ]// from states.js
		}),
		valueField:'id',
		displayField:'valor',
		lazyRender:true,
		forceSelection:true,
		width_grid:170,
		width:300,
		grid_visible:true,
		grid_editable:false,
		disabled:false		
	},
	tipo:'ComboBox',
	form:true,
	id_grupo:1,
	filtro_0:false,
	filterColValue:'ac.anio_per_fiscal'
	};
	
	// txt fecha_hora_consulta
	Atributos[11]={
		validacion:{
			name:'fecha_emision',
			fieldLabel:'Fecha Emisión',
			allowBlank:false,
			align:'center',
			format: 'd/m/Y', //formato para validacion
			//minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100		
		},
		tipo:'DateField',
		filtro_0:true,
		form:true,		
		filterColValue:'ac.fecha_factura',
		dateFormat:'m-d-Y',
		id_grupo:2
	};
	
	// txt importe_factura
	Atributos[12]={
		validacion:{
			name:'importe_factura',
			fieldLabel:'Importe Factura',
			allowBlank:true,
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'ac.importe_factura',
		id_grupo:2
	};

	// txt cantidad_valor_solicitado 
	Atributos[13]={
		validacion:{
			name:'cantidad_valor_solicitado',
			fieldLabel:'Cant. Valor Solicitado',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		defecto:1,
		filtro_0:true,
		filterColValue:'ac.cantidad_valor_solicitado',
		id_grupo:1	
	};

	// txt nro_beneficiarios_directos
	Atributos[14]={
		validacion:{
			name:'nro_beneficiarios_directos',
			fieldLabel:'Nro Benefic Directos ',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: true,
		filtro_0:true,
		filterColValue:'ac.nro_beneficiarios_directos',
		id_grupo:0
	};
	// txt nro_beneficiarios_indirectos
	Atributos[15]={
		validacion:{
			name:'nro_beneficiarios_indirectos',
			fieldLabel:'Nro Benefic Indirectos',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: true,
		filtro_0:true,
		filterColValue:'ac.nro_beneficiarios_indirectos',
		id_grupo:0		
	};
	
	// txt cant_reg_beneficiarios
	Atributos[16]={
		validacion:{
			name:'cant_reg_beneficiarios',
			fieldLabel:'Cant Beneficiarios',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: true,
		filtro_0:true,
		filterColValue:'ac.cant_reg_beneficiarios',
		id_grupo:0		
	};
	// txt importe_directo
	Atributos[17]={
		validacion:{
			name:'importe_directo',
			fieldLabel:'Importe Directo',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		//form: true,
		filtro_0:true,
		filterColValue:'ac.importe_directo',
		id_grupo:0		
	};
	// txt importe_directo
	Atributos[18]={
		validacion:{
			name:'importe_indirecto',
			fieldLabel:'Importe Indirecto',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ac.importe_indirecto',
		id_grupo:0		
	};
	// txt importe_total
	Atributos[19]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:true,
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ac.importe_total',
		id_grupo:0		
	};
// txt cod_control
	Atributos[20]={
		validacion:{
			name:'cod_control',
			fieldLabel:'Codigo Control',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'fa.cod_control',
		id_grupo:2		
	};
	// txt estado
	Atributos[21]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store: new Ext.data.SimpleStore({
				fields: ['id', 'valor'],
				data : [
				        ['0','ACTIVO'],
				        ['1','REGISTRADO'],
				        ['2','FINALIZADO']
				    ]// from states.js
			}), 
			valueField:'id',
			displayField:'valor',
			renderer: render_estado,
			lazyRender:true,
			width_grid:100,
			width:300,
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,
			disabled:false		
		},
		tipo:'ComboBox',
		form:false,
		id_grupo:1,
		filtro_0:false,
		filterColValue:'estado'		
	};
	
	Atributos[22] = { 
		validacion:{
			name: 'id_archivo_control',
			fieldLabel: 'Beneficiarios',
			selectOnFocus:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid: 135, 
			renderer:formatURL3
		},
		tipo: 'Field'
	};
	
	Atributos[23] = { 
		validacion:{
			name: 'id_archivo_control',
			fieldLabel: 'Archivo Control',
			selectOnFocus:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid: 135, 
			renderer:formatURL5
		},
		tipo: 'Field'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatURL3(val) { if(val!="")
	 {return '<a href="'+ direccion+"../../../control/recuperacion_vejez_gral/interface/beneficiarios_"+val+'.txt">'+'Beneficiarios'+'</a>';}}
	function formatURL5(val) { if(val!="")
	 {return '<a href="'+ direccion+"../../../control/recuperacion_vejez_gral/interface/control_"+val+'.txt">'+'Archivo Control'+'</a>';}}
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'recuperacion_vejez',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/detalle_beneficiarios_gral/detalle_beneficiarios_gral.php'};
	var layout_recuperacion_vejez_gral=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_recuperacion_vejez_gral.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_recuperacion_vejez_gral,idContenedor);
	
	var ClaseMadre_getComponente=this.getComponente;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	//--*--
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_saveSuccess=this.saveSuccess;
	
	var ClaseMadre_getGrid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var cm_EnableSelect=this.EnableSelect;
	////////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ //
	////////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/recuperacion_vejez_gral/ActionEliminarRecuperacionVejezGral.php'},
		Save:{url:direccion+'../../../control/recuperacion_vejez_gral/ActionGuardarRecuperacionVejezGral.php'},
		ConfirmSave:{url:direccion+'../../../control/recuperacion_vejez_gral/ActionGuardarRecuperacionVejezGral.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,columnas:['47%','47%'],
		grupos:[
		{tituloGrupo:'Oculto',columna:0,id_grupo:0},
		{tituloGrupo:'Datos Formulario 200',columna:0,id_grupo:1},
		{tituloGrupo:'Datos Factura',columna:0,id_grupo:2}
		],		
		height:500, //alto
		width:950,  //ancho
		//minWidth:150,
		//minHeight:200,	
		closable:true,
		titulo:'Datos Formulario 200'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		
	function btn_reporte_recuperacion_vejez()
	{		
		 sm=getSelectionModel();
		 NumSelect=sm.getCount(); //recupera la cantidad de filas selecionadas

		if(NumSelect !=0){//Verifica si hay filas seleccionadas
		
			/*if (componentes[25].getValue()=='0'){
			
				if (componentes[26].getValue() !='' || componentes[26].getValue() !=0){ //Tiene datos tecnicos registrados
				*/
					SelectionsRecord=sm.getSelected(); //es el primer registro selecionado
					data="hidden_id_recuperacion_vejez=" + SelectionsRecord.data.id_recuperacion_vejez;
					//data=data + "&hidden_id_tramite=" + componentes[2].getValue();
					
					//Abre la pestaña del detalle
					window.open(direccion+'../../../control/_reportes/recuperacion_vejez/ActionReporterecuperacion_vejez.php?'+data, "Reporte")
				/*}
				else{
					//Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Falta registrar DATOS TECNICOS del Tramite</b></span>');
					alert('Falta registrar DATOS TECNICOS del Trámite')
				}
			}
			else{
				//Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Sólo a Trámites en VERIFICACION <br> se emite FORMULARIO</b></span>');
				alert('Sólo a Trámites en VERIFICACION se emite FORMULARIO')
			}*/
		}
		else{
			//Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Antes debe seleccionar un Trámite.</b></span>');
			alert('Antes debe Seleccionar un recuperacion_vejez.')
		}
	}	
	
	function btn_reporte_formulario_recuperacion_vejez()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();	
			
			if(NumSelect!=0)
			{	
				var data="id_recuperacion_vejez=" + SelectionsRecord.data.id_recuperacion_vejez;	
				if(SelectionsRecord.data.tipo_recuperacion_vejez==2)
				{
					 //window.open(direccion+'../../../control/recuperacion_vejez/reporte/ActionPDFFormularioLibroQuejas.php?'+data);
				     window.open(direccion+'../../../control/recuperacion_vejez_gral/reporte/ActionPDFFormulariorecuperacion_vejezArtefactos.php?'+data);
				}else{
				     window.open(direccion+'../../../control/recuperacion_vejez_gral/reporte/ActionPDFFormulariorecuperacion_vejezDirecto.php?'+data);   			   	   
				}			
			}
			else
			{
				Ext.MessageBox.alert('Estado','Debe seleccionar una solicitud.')
		    }
	}
	
	function btn_emitir_factura()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_archivo_control='+SelectionsRecord.data.id_recuperacion_vejez;
			data=data+'&importe_total='+SelectionsRecord.data.importe_total;
			//data=data+'&respuesta='+SelectionsRecord.data.respuesta;
			
			var paramVentana={
					Ventana:{
						width:'60%',
			            height:'70%'
					}
				};
			layout_recuperacion_vejez.loadWindows(direccion+'../../factura/factura.php?'+data, "Emisión de Factura ["+ SelectionsRecord.data.id_nro_solicitud +"]",paramVentana);
			layout_recuperacion_vejez.getVentana().on('resize',function(){ layout_recuperacion_vejez.getLayout().layout();	} )								
				ClaseMadre_btnActualizar();
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btnBeneficiarios(){
		
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); 
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect != 0)
		{
			Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando ...</div>",
						width:150,
						height:200,
						closable:false
					});
			var data1 = "cantidad_ids=1&dt_id_archivo_control=" +SelectionsRecord.data.id_archivo_control+"&dt_mes_periodo="+SelectionsRecord.data.mes_per_fiscal+"&dt_anio_periodo="+SelectionsRecord.data.anio_per_fiscal;
					Ext.Ajax.request({
				  		url:direccion+"../../../control/recuperacion_vejez_gral/ActionGuardarBeneficiariosGral.php",
					  	params:data1,
						isUpload:false,
						success: successRegistrado,
						method:'POST',
						argument: {multi: false},
						//failure: esteFailureFac,
						failure:_CP.conexionFailure,
						timeout:  1000000000
				});
					
		}
		else{
			Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Antes debe seleccionar un registro.</b></span>');
		}	
	}	
	
	function successRegistrado(resp){
		Ext.MessageBox.hide();
		ClaseMadre_btnActualizar();
		//CM_saveSuccess(resp);	
		//Ext.MessageBox.alert('Estado','sussec');
	}
	
	function btnFinalizar(){
		
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); 
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect != 0)
		{
			Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando ...</div>",
						width:150,
						height:200,
						closable:false
					});
			var data1 = "cantidad_ids=1&dt_id_archivo_control=" +SelectionsRecord.data.id_archivo_control+"&dt_mes_periodo="+SelectionsRecord.data.mes_per_fiscal+"&dt_anio_periodo="+SelectionsRecord.data.anio_per_fiscal;
					Ext.Ajax.request({
				  		url:direccion+"../../../control/recuperacion_vejez_gral/ActionFinalizarFormularioGral.php",
					  	params:data1,
						isUpload:false,
						success: successFinalizado,
						method:'POST',
						argument: {multi: false},
						//failure: esteFailureFac,
						failure:_CP.conexionFailure,
						timeout:  1000000000
				});
					
		}
		else{
			Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Antes debe seleccionar un registro.</b></span>');
		}	
	}	
	
	function successFinalizado(resp){
		Ext.MessageBox.hide();
		ClaseMadre_btnActualizar();
		//CM_saveSuccess(resp);	
		//Ext.MessageBox.alert('Estado','sussec');
	}
	function btnGenerar(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); 
		var SelectionsRecord=sm.getSelected();

		if(NumSelect!=0){
			Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando ...</div>",
						width:150,
						height:200,
						closable:false
					});
			var data1 = "cantidad_ids=1&dt_id_archivo_control=" +SelectionsRecord.data.id_archivo_control+"&dt_mes_periodo="+SelectionsRecord.data.mes_per_fiscal+"&dt_anio_periodo="+SelectionsRecord.data.anio_per_fiscal;
					Ext.Ajax.request({
				  		url:direccion+"../../../control/recuperacion_vejez_gral/ActionGenerarBeneficiarios.php",
					  	params:data1,
						isUpload:false,
						success: successGenerado,
						method:'POST',
						argument: {multi: false},
						failure:_CP.conexionFailure,
						timeout:  100000000
				});
		}
		else{
			Ext.MessageBox.alert('...', '<span style="color:blue;font-size:8pt"><b>Antes debe seleccionar una Ruta.</b></span>');
		}	
				
	}
	function successGenerado(resp){
		Ext.MessageBox.hide();
		ClaseMadre_btnActualizar();
		//CM_saveSuccess(resp);	
		//Ext.MessageBox.alert('Estado','sussec');
	}
	function btnFactura(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); 
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
	    	var fecha_fin=new Date();
	    	//SiBlancosGrupo(1);
	    	CM_ocultarGrupo('Datos Formulario 200');
	    	CM_mostrarGrupo('Datos Factura');
	    	ClaseMadre_btnEdit();
	    	//componentes[19].setValue('finalizar_recepcion');
	    	//componentes[13].reset();
	    	
	    	
		}
		else{
			Ext.MessageBox.alert('Atención', 'Debe seleccionar un registro.');
		}
				
	}
	function btn_beneficiarios(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
			var data='id_archivo_control='+SelectionsRecord.data.id_archivo_control;
			    data=data+'&mes_per_fiscal='+render_mes(SelectionsRecord.data.mes_per_fiscal);
                data=data+'&anio_per_fiscal='+SelectionsRecord.data.anio_per_fiscal;
                data=data+'&tipo_reporte=contabilidad';
               // alert (data);
				window.open(direccion+'../../../control/detalle_beneficiario/ActionPDFDetalleBeneficiariosConsolidado.php?'+data);	
			}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_detalle_beneficiarios(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
			var data='id_archivo_control='+SelectionsRecord.data.id_archivo_control;
			    data=data+'&mes_per_fiscal='+render_mes(SelectionsRecord.data.mes_per_fiscal);
                data=data+'&anio_per_fiscal='+SelectionsRecord.data.anio_per_fiscal;
                data=data+'&tipo_reporte=contabilidad';
                data=data+'&sw_reporte=contabilidad';
                //alert (data);
				window.open(direccion+'../../../control/detalle_beneficiario/ActionPDFListarDetalleBeneficiarios.php?'+data);	
			}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		CM_ocultarGrupo('Oculto');
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
					
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}	

		//_CP.getPagina(layout_recuperacion_vejez.getIdContentHijo()).pagina.bloquearMenu()
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )		
				
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		enable(sm,row,rec);	
		datas_edit=rec.data;
		if(rec.data['estado']=='2')//es un recuperacion_vejez comercial
		{			
			_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.reload(rec.data);
			_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.bloquearMenu()			
		} else {
			_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.reload(rec.data);
			_CP.getPagina(layout_recuperacion_vejez_gral.getIdContentHijo()).pagina.desbloquearMenu()
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_recuperacion_vejez_gral.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
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
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Emitir Factura',btn_emitir_factura,true,'emitir_factura','Emitir Factura');
	this.AdicionarBoton("../../../lib/imagenes/list-proce.bmp",'Registro Beneficiarios',btnBeneficiarios,true, 'Registrar','Registrar Beneficiarios');
	this.AdicionarBoton("../../../lib/imagenes/list-proce.bmp",'Generar Archivos',btnGenerar,true, 'Generar','Generar Archivos');
	//this.AdicionarBoton("../../../lib/imagenes/list-proce.bmp",'Datos Factura',btnFactura,true, 'Factura','Datos Factura');
	this.AdicionarBoton("../../../lib/imagenes/list-proce.bmp",'Finalizar Formulario',btnFinalizar,true, 'Finalizar','Finalizar Formulario');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Detalle Beneficiarios',btn_detalle_beneficiarios,true,'det_beneficiarios','Detalle Beneficiarios'); 
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Consolidación Beneficiarios',btn_beneficiarios,true,'beneficiarios','Beneficiarios'); 
	//this.AdicionarBoton("../../../lib/imagenes/print.gif",'Formulario recuperacion_vejezs',btn_reporte_formulario_recuperacion_vejez,true, 'formulario_recuperacion_vejez','Formularios recuperacion_vejez');
	
	function  enable(sel,row,selected)
	{
		var record=selected.data;
		cm_EnableSelect(sel,row,selected)
		
		if(selected.data['estado']=='0')//es un recuperacion_vejez comercial
		{			
			CM_getBoton('Registrar-'+idContenedor).enable();
			CM_getBoton('Generar-'+idContenedor).disable();
			//CM_getBoton('Factura-'+idContenedor).disable();
			CM_getBoton('Finalizar-'+idContenedor).disable();
		}
		if(selected.data['estado']=='1')//es un recuperacion_vejez comercia
		{			
			CM_getBoton('Registrar-'+idContenedor).disable();
			CM_getBoton('Generar-'+idContenedor).enable();
			// CM_getBoton('Factura-'+idContenedor).enable();
			CM_getBoton('Finalizar-'+idContenedor).disable();
		}	
		if(selected.data['estado']=='2')//es un recuperacion_vejez comercial
		{			
			CM_getBoton('Registrar-'+idContenedor).disable();
			CM_getBoton('Generar-'+idContenedor).enable();
			//CM_getBoton('Factura-'+idContenedor).disable();
			CM_getBoton('Finalizar-'+idContenedor).disable();	
		}
		if(selected.data['estado']=='3')//es un recuperacion_vejez comercial
		{			
			CM_getBoton('Registrar-'+idContenedor).disable();
			CM_getBoton('Generar-'+idContenedor).disable();
			//CM_getBoton('Factura-'+idContenedor).disable();
			CM_getBoton('Finalizar-'+idContenedor).enable();	
		}
		if(selected.data['estado']=='4')//es un recuperacion_vejez comercial
		{			
			CM_getBoton('Registrar-'+idContenedor).disable();
			CM_getBoton('Generar-'+idContenedor).disable();
			//CM_getBoton('Factura-'+idContenedor).disable();
			CM_getBoton('Finalizar-'+idContenedor).disable();	
		}
		if(selected.data['estado']=='5')//es un recuperacion_vejez comercial
		{			
			CM_getBoton('Registrar-'+idContenedor).disable();
			CM_getBoton('Generar-'+idContenedor).disable();
			//CM_getBoton('Factura-'+idContenedor).disable();
			CM_getBoton('Finalizar-'+idContenedor).disable();	
		}
	}
	
	layout_recuperacion_vejez_gral.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}