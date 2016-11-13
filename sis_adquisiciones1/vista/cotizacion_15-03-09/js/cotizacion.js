/**
 * Nombre:		  	    pagina_cotizacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-28 17:32:05
 */
function pagina_cotizacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var cmbProveedor;
	var componentes=new Array();
	var num_cotizaciones=0;
	var on=0;
	var nombre_boton;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion/ActionListarCotizacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_cotizacion',
		{name: 'fecha_venc',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'impuestos',
		'garantia',
		'lugar_entrega',
		'forma_pago',
		'tiempo_validez_oferta',
		{name: 'fecha_entrega',type:'date',dateFormat:'Y-m-d'},
		'tipo_entrega',
		'observaciones',
		'id_proceso_compra',
		'desc_proceso_compra',
		'id_moneda',
		'desc_moneda',
		'id_proveedor',
		'desc_proveedor',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'precio_total_moneda_cotizada',
		'figura_acta',
		'num_factura',
		'num_orden_compra',
		'estado_vigente',
		'estado_reg',
		'nombre_pago',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_orden_compra_sis',
		'num_cotizacion',
		{name: 'fecha_orden_compra',type:'date',dateFormat:'Y-m-d'},
		'direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor',
		{name: 'fecha_cotizacion',type:'date',dateFormat:'Y-m-d'},'num_detalle_cotizado',
		'precio_total','id_moneda_base','numeracion_periodo','num_detalle_cotizado_gral', 'num_detalle_adjudicado_gral',
		'factura_total','num_autoriza_factura','cod_control_factura',{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'}
		
		]),remoteSort:true});

	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
	
	//DATA STORE COMBOS

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor','direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor'])
	,baseParams:{tipo_adq:maestro.tipo_adq, id_proceso_compra:maestro.id_proceso_compra}});

	
	//FUNCIONES RENDER
		
	function render_id_moneda(value, p, record){ if(record.data.id_moneda!=''){return String.format('{0}', record.data['desc_moneda']);}else{
			var cadena='falta definir';
			return '<span style="color:red;font-size:8pt">' +cadena + '</span>';	
		}
	}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{simbolo}</FONT>','</div>');

	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cotizacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_cotizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cotizacion'
	};
	
	
	// txt id_proceso_compra  ==> deberia ser fiel
	Atributos[1]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_proceso_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:maestro.id_proceso_compra,
		save_as:'id_proceso_compra'
	};
	
	
	// txt id_tipo_categoria_adq  ==> field
	Atributos[2]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_categoria_adq,
		save_as:'id_tipo_categoria_adq'
	};
	
	
	
	// txt num_cotizacion
	Atributos[3]={//==> SI
		validacion:{
			name:'num_cotizacion',
			fieldLabel:'Nº Cotizacion ',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:80,
			width:'40%',
			disabled:true,
			grid_indice:2	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		defecto:maestro.num_cotizacion,
		filterColValue:'COTIZA.num_cotizacion#COTIZA.periodo',
		save_as:'num_cotizacion',
		id_grupo:1  //1
	};
	
	
	
	// txt id_proveedor  ==> proveedor (puede escoger)
	Atributos[4]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:false,			
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'nombre_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_proveedor,
			onSelect: function(record){getComponente('id_proveedor').setValue(record.data.id_proveedor); 
				getComponente('direccion_proveedor').setValue(record.data.direccion_proveedor);getComponente('direccion_proveedor').disable();
				getComponente('mail_proveedor').setValue(record.data.mail_proveedor);getComponente('mail_proveedor').disable();
				getComponente('telefono1_proveedor').setValue(record.data.telefono1_proveedor);getComponente('telefono1_proveedor').disable();
				getComponente('telefono2_proveedor').setValue(record.data.telefono2_proveedor);getComponente('telefono2_proveedor').disable();
				getComponente('fax_proveedor').setValue(record.data.fax_proveedor);getComponente('fax_proveedor').disable();
				getComponente('id_proveedor').collapse(); },
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:false,
			width_grid:75,
			width:'100%',
			disable:false,
			grid_indice:3	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_15.apellido_paterno#PERSON_15.apellido_materno#PERSON_15.nombre#INSTIT.nombre',
		save_as:'id_proveedor',
		id_grupo:2
	};
	
	
	
	
	
	// txt fecha_validez_oferta ==> se usa
	Atributos[5]= {
		validacion:{
			name:'tiempo_validez_oferta',
			fieldLabel:'Validez Oferta',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:95,
			width:'60%',
			disable:false,
			grid_indice:10//,
			//renderer:validez_oferta
		},
		tipo: 'TextField',
		form: true,
		defecto:0,
		filtro_0:false,
		filterColValue:'COTIZA.tiempo_validez_oferta',
		save_as:'tiempo_validez_oferta',
		id_grupo:5
	};
	
	// txt id_moneda  ==> se va a escoger
	Atributos[6]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			//editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:9
		},
		tipo:'ComboBox',
		form: true,
		defecto:maestro.id_moneda,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_monedas',
		id_grupo:4  //1
	};
	
	

	
	


	// txt tipo_entrega  ==> se usa
	Atributos[7]={
		validacion:{
			name:'tipo_entrega',
			fieldLabel:'Tiempo Entrega',
			allowBlank:true,
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:9,
			renderer:tipo_entrega
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.tipo_entrega',
		save_as:'tipo_entrega',
		id_grupo:3
	};

	// txt fecha_entrega ==> se usa
	Atributos[8]= {
		validacion:{
			name:'fecha_entrega',
			fieldLabel:'Fecha Entrega Propuesta',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate1,
			width_grid:90,
			disabled:false,
			grid_indice:11
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_entrega',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_entrega',
		id_grupo:3
	};
	
	
	// txt forma_pago ==se usa
	Atributos[9]={
		validacion:{
			name:'forma_pago',
			fieldLabel:'Forma de Pago',
			allowBlank:true,
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:95,
			width:'100%',
			disable:false,
			grid_indice:12//,
			//renderer:forma_pago_
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.forma_pago',
		save_as:'forma_pago',
		id_grupo:4
	};

	
	// txt impuestos
	Atributos[10]={//==> se usa
			validacion: {
			name:'impuestos',
			fieldLabel:'Impuesto',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:12,
			renderer:impuesto	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.impuestos',
		defecto:'si',
		save_as:'impuestos',
		id_grupo:4
	};
	

// txt garantia
	Atributos[11]={//==> SI
		validacion:{
			name:'garantia',
			fieldLabel:'Garantia',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:95,
			width:'100%',
			disable:false,
			grid_indice:11//,
			//renderer:garantia
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		defecto:' ',
		filterColValue:'COTIZA.garantia',
		save_as:'garantia',
		id_grupo:5
	};

	
	// txt figura_acta
	Atributos[12]={//==>SI
		validacion:{
			name:'figura_acta',
			fieldLabel:'Figura en Acta',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			renderer:formatBoolean,
			grid_indice:14		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.figura_acta',
		save_as:'figura_acta',
		id_grupo:0
	};


	
// txt fecha_venc
	Atributos[13]= {//==>SI
		validacion:{
			name:'fecha_venc',
			fieldLabel:'Fecha Max. Entrega Propuestas',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:14
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_venc',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_venc',
		id_grupo:1  //1
	};
	
	// txt lugar_entrega ==> se usa
	Atributos[14]={
		validacion:{
			name:'lugar_entrega',
			fieldLabel:'Lugar de Entrega',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'60%',
			disabled:false,
			grid_indice:17
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'COTIZA.lugar_entrega',
		save_as:'lugar_entrega',
		id_grupo:1  //1
	};
		
	
// txt fecha_reg
	Atributos[15]= {//==>SI
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate1,
			width_grid:85,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'COTIZA.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg',
		id_grupo:0
	};



// txt estado_vigente
	Atributos[27]={//==>SI
		validacion:{
			name:'estado_vigente',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.estado_vigente',
		save_as:'estado_vigente',
		id_grupo:0
	};
// txt estado_reg
	Atributos[17]={//==> SI
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado Reg',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.estado_reg',
		save_as:'estado_reg',
		defecto:'activo',
		id_grupo:0
	};

// txt observaciones
	Atributos[18]={//==>SI
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:60
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		defecto:maestro.lugar_entrega,
		filterColValue:'COTIZA.observaciones',
		save_as:'observaciones',
		defecto:'-',
		id_grupo:0  //1
	};

	
	
	Atributos[19]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'num_proceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:maestro.num_proceso,
		save_as:'num_proceso'
	};
	
	
	
	/*************/
	
	Atributos[20]={
		validacion:{
			name:'direccion_proveedor',
			fieldLabel:'Direccion',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:3		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'direccion_proveedor',
		id_grupo:2
	};

//	
	Atributos[21]={
		validacion:{
			name:'mail_proveedor',
			fieldLabel:'Email',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:4		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'mail_proveedor',
		id_grupo:2
	};
//	
//	
//	
	Atributos[22]={
		validacion:{
			name:'telefono1_proveedor',
			fieldLabel:'Telef. 1',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:5		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'telefono1_proveedor',
		id_grupo:2
	};
	
	
	Atributos[23]={
		validacion:{
			name:'telefono2_proveedor',
			fieldLabel:'Telef. 2',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:6		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'telefono2_proveedor',
		id_grupo:2
	};
	
	
	Atributos[24]={
		validacion:{
			name:'fax_proveedor',
			fieldLabel:'Fax',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'fax_proveedor',
		id_grupo:2
	};
	
	
//	
	Atributos[25]= {
		validacion:{
			name:'fecha_cotizacion',
			fieldLabel:'Fecha Cotización',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:105,
			disabled:false,
			grid_indice:8
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_cotizacion',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_cotizacion',
		id_grupo:3
	};
//	
//	
	Atributos[26]={
		validacion:{//==>NO
			name:'num_detalle_cotizado',
			fieldLabel:'num_detalle_cotizado',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'num_detalle_cotizado',
		filtro_0:false,
		id_grupo:0
	};
	
	
	Atributos[16]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Periodo/NºCot.',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			align:'right',
			width:'40%',
			disabled:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		filterColValue:'COTIZA.num_cotizacion#COTIZA.periodo',
		save_as:'numeracion_periodo',
		id_grupo:0
	};
	
	
	Atributos[28]={
		validacion:{//==>NO
			name:'num_detalle_cotizado_gral',
			fieldLabel:'num_detalle_cotizado_gral',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		save_as:'num_detalle_cotizado_gral',
		id_grupo:0
	};
	
	
	Atributos[29]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda_base',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_moneda_base',
		id_grupo:0
	};
	
	// txt precio_total ==> no es necesario
	Atributos[30]={
		validacion:{
			name:'precio_total',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:85,
			width:'100%',
			disabled:false,
			align:'right',
			renderer:precio,
			grid_indice:9
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.precio_total',
		save_as:'precio_total',
		id_grupo:3
	};
	Atributos[31]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'desc_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'desc_moneda'
	};
	
	
	Atributos[32]={//==> se usa
			validacion: {
			name:'factura_total',
			fieldLabel:'Factura por el Total',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:13,
			renderer:factura_total
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.factura_total',
		defecto:'si',
		save_as:'factura_total',
		id_grupo:0
	};
	
	Atributos[33]={
		validacion:{//==>NO
			name:'num_autoriza_factura',
			fieldLabel:'Nº de Autorización',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:105,
			width:'100%',
			disabled:false,
			grid_indice:14,
			renderer:factura_total	
		},
		tipo: 'NumberField',
		form: true,
		save_as:'num_autoriza_factura',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[34]={//==> SI
		validacion:{
			name:'cod_control_factura',
			fieldLabel:'Codigo de Control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:90,
			width:'40%',
			disabled:false,
			grid_indice:15,
			renderer:factura_total
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		save_as:'cod_control_factura',
		id_grupo:0 //1
	};
	
	
	Atributos[35]= {
		validacion:{
			name:'fecha_factura',
			fieldLabel:'Fecha de Factura',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate1,
			width_grid:97,
			disabled:false,
			grid_indice:16
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_factura',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_factura',
		id_grupo:0
	};
	
	Atributos[36]={//==> SI
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:80,
			width:'40%',
			disabled:true,
			grid_indice:1	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'COTIZA.gestion',
		save_as:'gestion',
		id_grupo:1  //1
	};
	
	//----------- FUNCIONES RENDER
	
	

	
	function formatDate(value){
		if(value==''){
			return '<span style="color:red;font-size:8pt">falta_definir</span>';}
		else{
			return value?value.dateFormat('d/m/Y'):''
		}
	}
	
	function formatDate1(value){
		return value?value.dateFormat('d/m/Y'):''
	}
	
	function formatBoolean(value,p,record){
		if(value=='true'){
			return 'si';
		}else{
				return '<span style="color:red;font-size:8pt">no</span>'
			}
		}
		
	function factura_total(value,p,record){
	    if(value=='pendiente'){
	        return '<span style="color:red;font-size:8pt">pendiente</span>'
	    }else{
	        return value;
	    }
	    
	}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:' (Maestro)',titulo_detalle:'Cotizaciones (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_cotizacion = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cotizacion.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_cotizacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnDelete=this.btnEliminar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_saveSuccess=this.saveSuccess;
	var CM_mostrarComponente=this.mostrarComponente;
	var getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var enableSelect=this.EnableSelect;
	var selModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:true},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cotizacion/ActionEliminarCotizacion.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
	Save:{url:direccion+'../../../control/cotizacion/ActionGuardarCotizacion.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
	ConfirmSave:{url:direccion+'../../../control/cotizacion/ActionGuardarCotizacion.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:'38%',minWidth:550,minHeight:200,	closable:true,titulo:'cotizacion',
	grupos:[{
			tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
		},{
			tituloGrupo:'Cotizacion',
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Datos Proveedor',
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Datos Entrega Pedido',
			columna:0,
			id_grupo:3
		},
		{
			tituloGrupo:'Pago',
			columna:0,
			id_grupo:4
		},
		{
			tituloGrupo:'Datos Oferta',
			columna:0,
			id_grupo:5
		}
	]}};
	
	
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proceso_compra/ActionListarProcesoCompra.php?id_proceso_compra='+maestro.id_proceso_compra}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proceso_compra',totalRecords: 'TotalCount'},['id_proceso_compra',
		'num_proceso','codigo_proceso',
		'observaciones','desc_moneda','desc_tipo_adq'
		])
		});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proceso_compra:maestro.id_proceso_compra

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			var data1=[['Nº Proceso',ds_maestro.getAt(0).get('num_proceso')],  ['Cod. Proceso',ds_maestro.getAt(0).get('codigo_proceso')],   ['Moneda',ds_maestro.getAt(0).get('desc_moneda')],   ['Descripcion',ds_maestro.getAt(0).get('observaciones')], ['Tipo Adquisicion',ds_maestro.getAt(0).get('desc_tipo_adq')]];
	        Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));

		}
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		this.btnActualizar;
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_proceso_compra=datos.m_id_proceso_compra;
		maestro.codigo_procedo=datos.m_codigo_proceso;
		maestro.num_proceso=datos.m_num_proceso;
		maestro.tipo_adq=datos.m_tipo_adq;
		maestro.id_tipo_categoria_adq=datos.m_id_tipo_categoria_adq;
		maestro.lugar_entrega=datos.m_lugar_entrega;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.num_cotizacion=datos.m_num_cotizacion;
		maestro.id_moneda_base=datos.m_id_moneda_base;
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_proceso_compra:maestro.id_proceso_compra

				},
				callback:cargar_maestro
			});
			
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proceso_compra:maestro.id_proceso_compra
			}
		};
		cmbProveedor.store.baseParams.id_proceso_compra=maestro.id_proceso_compra;
		cmbProveedor.store.baseParams.tipo_adq=maestro.tipo_adq;
		
		this.btnActualizar();
		iniciarEventosFormularios();
		
		//gridMaestro.getDataSource().removeAll();

		//gridMaestro.getDataSource().loadData([['Nº Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
		Atributos[1].defecto=maestro.id_proceso_compra;		
		paramFunciones.btnEliminar.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra;
		paramFunciones.Save.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra;
		paramFunciones.ConfirmSave.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra;
		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones);
	};
	
	function btn_anular_cotizacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
			var dialog=getDialog();
			dialog.buttons[0].setText('Anular Cotizacion');
			dialog.buttons[0].enable();
			var msj='';
			if(maestro.ejecutado=='si'){ msj='El presupuesto ya fue revertido para esta solicitud, al anular esta cotizacion, el presupuesto restante tambien será revertido.\n';}
            else{msj='';}
			   if(confirm(msj+"Esta seguro de anular la cotizacion?")){
			    
				    var data="cantidad_ids=1&id_cotizacion="+SelectionsRecord.data.id_cotizacion+'&anular=1';
					Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionTerminarCotizacion.php",
					params:data,
					method:'POST',
					failure:CM_conexionFailure,
					success:exito,
					timeout:100000000
					});	
			}
		}
		else{
		  alert('Antes debe seleccionar un item.')
	   }
	   this.btnActualizar;
    }

    function exito(resp){
		  if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				if(root.getElementsByTagName('error')[0].firstChild.nodeValue=='false'){
					alert('Anulacion completada');		
					ds.load({
                		params:{
                			start:0,
                			limit: paramConfig.TamanoPagina,
                			CantFiltros:paramConfig.CantFiltros,
                			m_id_proceso_compra:maestro.id_proceso_compra
                		}
                	});
				}
			}
		}

	
	
	function validez_oferta(val,cell,record,row,colum,store){
	     if(record.data.id_proveedor>0){
			  var texto='falta_definir';
				if(record.data.tiempo_validez_oferta==""){
				    record.set('tiempo_validez_oferta',texto);  
					return record.get('tiempo_validez_oferta');
	        	}else{
	        		if(record.data.tiempo_validez_oferta=='falta_definir'){
	        			return '<span style="color:red;font-size:8pt">' + val + '</span>';
	        		}else{
	        	  	return val;
	        		}
	        	  	
	            }
	     }
	};
	
	function tipo_entrega(val,cell,record,row,colum,store){
	     if(record.data.id_proveedor>0){
			  var texto="falta_definir";
				if(val==""){
	        	   record.set('tipo_entrega',texto);
	        		  return record.get('tipo_entrega');
	        	}else{if(record.data.tipo_entrega=='falta_definir'){
	        			return '<span style="color:red;font-size:8pt">' + val + '</span>';
	        		}else{
	        	  	return val;
	        		}
	            }
	     }
	};
	
	
	function precio(val,cell,record,row,colum,store){
		if(record.data.id_proveedor>0){
			  var texto="falta_definir";
				if(val==0){
	        	    return '<span style="color:red;font-size:8pt">' + texto + '</span>';
	        	}else{
	        	  	return val;
	        	}
	     }
	}
	
	
	function forma_pago_(val,cell,record,row,colum,store){
	     if(record.data.id_proveedor>0){
	     	   if(record.data.forma_pago=='falta_definir'){
	        			return '<span style="color:red;font-size:8pt">' + val + '</span>';
	           }else{
					return val;
	           }
	     }
	}
	     
	function garantia(val,cell,record,row,colum,store){	
	    if(record.data.id_proveedor>0){
	     	if(record.data.garantia=='falta_definir'){
	        	return '<span style="color:red;font-size:8pt">' + val + '</span>';
	        }else{
	     		return val;
	        }
		}
	}
	     	

	     	
	
	
	function impuesto(val,cell,record,row,colum,store){
	     if(record.data.id_proveedor>0){
			  var texto="si";
				if(val==""){
	        	   record.set('impuesto',texto);
	        		  return record.get('impuesto');
	        	}else{
	        	  	return val;
	            }
	     }
	};
	
	function btn_cotizacion_det(){
		this.btnActualizar;
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
			data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
			data=data+'&m_num_proceso='+maestro.num_proceso;
			data=data+'&m_desc_proveedor='+SelectionsRecord.data.desc_proveedor;
			data=data+'&m_estado_vigente='+SelectionsRecord.data.estado_vigente;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;
			data=data+'&m_id_proveedor='+SelectionsRecord.data.id_proveedor;
			
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			if(SelectionsRecord.data.estado_vigente!='finalizado'){
				if(SelectionsRecord.data.estado_vigente=='orden_compra' || SelectionsRecord.data.estado_vigente=='en_pago'){alert('El registro esta en '+SelectionsRecord.data.estado_vigente);}
				else{//alert(SelectionsRecord.data.forma_pago);
					if( SelectionsRecord.data.tiempo_validez_oferta!='' && SelectionsRecord.data.precio_total>0 && SelectionsRecord.data.fecha_cotizacion!='' && SelectionsRecord.data.tipo_entrega!='falta_definir' && SelectionsRecord.data.id_moneda>0){
			   		   //if(SelectionsRecord.data.estado_vigente!='cotizado' &&SelectionsRecord.data.estado_vigente!='adjudicado'){ //descomentar esta linea porque es necesaria esta verificacion
						if(maestro.tipo_adq=='Bien'){
				 				layout_cotizacion.loadWindows(direccion+'../../../../sis_adquisiciones/vista/cotizacion_det/cotizacion_det.php?'+data,'Detalle de Cotizaciones',ParamVentana);
						}else{
								layout_cotizacion.loadWindows(direccion+'../../../../sis_adquisiciones/vista/cotizacion_det/cotizacion_serv_det.php?'+data,'Detalle de Cotizaciones',ParamVentana);
						}
							layout_cotizacion.getVentana().on('resize',function(){
							layout_cotizacion.getLayout().layout();})
		/*}else{
			Ext.MessageBox.alert('Estado', 'Ya no se puede acceder a cotizar detalles, el el registro de cotizaciones ya fué finalizado');
		}*/
				}else{
					alert('Primero se debe registrar información de la propuesta marcada con rojo en la grilla');
				}
			
				}
			}else{
				alert('Solo cotizaciones no finalizadas')
			}
		}
		else{
			alert('Antes debe seleccionar un item.')
			}
	}

	
		this.btnNew=function(){
			this.btnActualizar;
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Datos Entrega Pedido');
			CM_ocultarGrupo('Datos Oferta');
			CM_ocultarGrupo('Pago');
			CM_mostrarGrupo('Cotizacion');
			CM_mostrarGrupo('Datos Proveedor');
			CM_mostrarComponente(getComponente('lugar_entrega'));
		    CM_mostrarComponente(getComponente('fecha_venc'));
			
			getComponente('forma_pago').allowBlank=true;
			getComponente('tiempo_validez_oferta').allowBlank=true;
			getComponente('garantia').allowBlank=true;
			getComponente('fecha_venc').allowBlank=true;
			getComponente('tipo_entrega').allowBlank=true;
			getComponente('fecha_cotizacion').allowBlank=true;
			var dialog=getDialog();
			dialog.buttons[0].setText('Guardar');
			//CM_ocultarGrupo('Cotizacion');
			on=0;
			get_fecha_adq();
			verificarCotizacion();
			getComponente('id_proveedor').modificado=true;
			CM_btnNew();
		}
		
		this.btnEdit=function(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Datos Entrega Pedido');
			CM_ocultarGrupo('Datos Oferta');
			CM_ocultarGrupo('Pago');
			CM_mostrarGrupo('Cotizacion');
			CM_mostrarGrupo('Datos Proveedor');
			var dialog=getDialog();
			dialog.buttons[0].setText('Guardar');
			if(NumSelect!=0){
			    var SelectionsRecord=sm.getSelected();
			      if(SelectionsRecord.data.estado_vigente=='pendiente' || SelectionsRecord.data.estado_vigente=='invitado'){
				        CM_ocultarGrupo('Oculto');
				        CM_ocultarGrupo('Datos Entrega Pedido');
				        CM_ocultarGrupo('Datos Oferta');
				        CM_ocultarGrupo('Pago');
				        CM_mostrarComponente(getComponente('lugar_entrega'));
				        CM_mostrarComponente(getComponente('fecha_venc'));
				        if(SelectionsRecord.data.num_detalle_cotizado_gral>0){
				            getComponente('lugar_entrega').disable();
				            getComponente('fecha_venc').disable();
				        }else{
				            getComponente('lugar_entrega').enable();
				            getComponente('fecha_venc').enable();
				        }
				            if(SelectionsRecord.data.estado_vigente!='cotizado'){
					             getComponente('id_proveedor').enable();
				                 CM_btnEdit();
				            }else{
					             getComponente('id_proveedor').disable();
				                 CM_btnEdit();
				            }
			      }else{
			          alert('No es posible editar el registro, ya se finalizó la cotización');
			      }
			}else{
				alert('Antes debe seleccionar un item');
			}
		}
		
		this.btnEliminar=function(){
		    
		    var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){
			   var SelectionsRecord=sm.getSelected();
			      if(SelectionsRecord.data.estado_vigente=='pendiente'||SelectionsRecord.data.estado_vigente=='aperturado'||SelectionsRecord.data.estado_vigente=='invitado'){
				      CM_btnDelete();
			     }else{
				      alert('No es posible eliminar el registro, ya se procedió con las cotizaciones');
			     }
		     }
		}
		
		
		
		
		function verificarCotizacion(){
			
			Ext.Ajax.request({
			   url:direccion+"../../../control/cotizacion/ActionListarCotizacion.php?m_id_proceso_compra="+maestro.id_proceso_compra,
			   method:'GET',
			   success:verificar,
			   failure:CM_conexionFailure,
			   timeout:100000000
			})
		}
		
		function verificar(resp){
			
			//Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				num_cotizaciones=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				
				get_fecha_adq();
				if(on==0){
					
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  	
				  	 CM_ocultarComponente(getComponente('fecha_venc'));
				  	 getComponente('fecha_venc').disable();
				  	 getComponente('fecha_venc').allowBlank=true;
				  	 getComponente('lugar_entrega').setValue(root.getElementsByTagName('lugar_entrega')[0].firstChild.nodeValue);
				  	 getComponente('lugar_entrega').disable();
				  }else{
				  	 CM_mostrarComponente(getComponente('fecha_venc'));
				  	 getComponente('lugar_entrega').setValue('');
				  	 getComponente('lugar_entrega').enable();
				  	 getComponente('lugar_entrega').allowBlank=false;
				  	 getComponente('fecha_venc').enable();
				  }
				}
				
			}
		}
		
		
		
		
//		function cell(g, f, c,e){
//		
//			if(c==7){
//				Ext.Ajax.request({
//				//url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
//				url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+maestro.id_empresa,
//				method:'GET',
//				success:cargar_fecha_adq,
//				failure:CM_conexionFailure,
//				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
//				});
//			}
//			
//			
//			
//		}
		
		
		function btn_fin_propuestas(){
			this.btnActualizar;
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){
				
				var SelectionsRecord=sm.getSelected();
				
					if(SelectionsRecord.data.estado_vigente=='aperturado' ||SelectionsRecord.data.estado_vigente=='invitado'|| (SelectionsRecord.data.estado_vigente=='pendiente' && SelectionsRecord.data.precio_total>0)){
					 if(maestro.tipo_adq=='Bien'){
						Ext.Ajax.request({
						   url:direccion+"../../../control/cotizacion_det/ActionListarCotizacionDet.php?m_id_cotizacion="+SelectionsRecord.data.id_cotizacion+"&m_cantidad=1&id_proveedor="+SelectionsRecord.data.id_proveedor,
						   method:'GET',
						   success:verificar_det,
						   failure:CM_conexionFailure,
						   timeout:100000000
						})
					}else{
						Ext.Ajax.request({
						   url:direccion+"../../../control/cotizacion_det/ActionListarCotizacionServDet.php?m_id_cotizacion="+SelectionsRecord.data.id_cotizacion+"&m_cantidad=1&id_proveedor="+SelectionsRecord.data.id_proveedor,
						   method:'GET',
						   success:verificar_det,
						   failure:CM_conexionFailure,
						   timeout:100000000
						})
					  }
				}
				
				else{
					if(SelectionsRecord.data.estado_vigente=='cotizado')
						alert('Ya se finalizó el registro de propuestas por cotizaciones')
					else
					    alert('El registro está '+SelectionsRecord.data.estado_vigente);
					}

		   }else{
				alert('Antes debe seleccionar un item')
			}
		}
		
		function verificar_det(resp){
			//Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				num_cotizaciones=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				var sm=getSelectionModel();
				var SelectionsRecord=sm.getSelected();
				if(confirm("Hay "+num_cotizaciones+" detalle(s) cotizado(s) registrado(s)  ¿Está seguro de terminar la Solicitud?")){
						var data="cantidad_ids=1&id_cotizacion="+SelectionsRecord.data.id_cotizacion;
						Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionTerminarCotizacion.php",
						params:data,
						method:'POST',
						failure:CM_conexionFailure,
						success:exitoF,
						timeout:100000000});	
						num_cotizaciones=0;
						
					}
				this.btnActualizar;
				}
			}
		
		function exitoF(resp){
		  if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				if(root.getElementsByTagName('error')[0].firstChild.nodeValue=='false'){
					alert('Finalizacion exitosa');		
					ds.load({
                		params:{
                			start:0,
                			limit: paramConfig.TamanoPagina,
                			CantFiltros:paramConfig.CantFiltros,
                			m_id_proceso_compra:maestro.id_proceso_compra
                		}
                	});
				}
			}
		}
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		txt_id_moneda_base=getComponente('id_moneda_base');
		txt_fecha=getComponente('fecha_cotizacion');
		txt_fecha_entrega=getComponente('fecha_entrega');
		txt_fecha_venc=getComponente('fecha_venc');
		cmbMoneda=getComponente('id_moneda');
		cmbProveedor=getComponente('id_proveedor');
		getGrid().getColumnModel().setEditable(4,true);
	 	num_cotizaciones=0;
	 	on=0;
	 	
	 	
	 	var onMonedaSelect=function(g,r,c,e){

	 	    if(c==4){
	 	        if(getSelectionModel().getSelected().data.num_detalle_cotizado>0){
	 					getGrid().getColumnModel().setEditable(4,false);
	 			}else{ 
	 				if(getSelectionModel().getSelected().data.fecha_cotizacion==''){
	 				  // getGrid().getColumnModel().setEditable(7,false); 	
	 				   alert('Antes debe definir la fecha de cotizacion');
	 				}else{
	 				    
	 				 	getGrid().getColumnModel().setEditable(4,true);
	 				}
	 			}
	 		}
		}
	 	
		var onFecha=function(g,r,c,e){
		 	if(c==3){
              CM_getBoton('guardar-'+idContenedor).enable();			    
				if(getSelectionModel().getSelected().data.fecha==""){
				}else{
	     			if(getSelectionModel().getSelected().data.num_detalle_cotizado>0){
	     				getGrid().getColumnModel().setEditable(4,false);
	     			}else{
	     				getGrid().getColumnModel().setEditable(4,true);
	       				//getMonedaPrincipal();
			   		   }
	     		}
			}
		}
		
		
		var onMonedaEdit=function(e){
			    if(e.column==4){
			    	if(e.value>0){
			    		getMonedaPrincipal();
			    	}
			    }
		}
			
	 	var grid=getGrid();
	 	//grid.on('validateedit',onMonedaSelect);
	 	grid.on('afteredit',onMonedaEdit);
	 	grid.on('cellclick',onMonedaSelect);
	 	grid.on('afteredit',onFecha);
	 	grid.on('cellclick',onFecha);
		
	 	var onFactura=function(e){
	 	    if(e.column==12){
	 	        if(e.value=='si'){
	 	            e.record.set('num_autoriza_factura','pendiente');
	 	            e.record.set('cod_control_factura','pendiente');
	 	            getGrid().getColumnModel().setEditable(13,true);
	 	            getGrid().getColumnModel().setEditable(14,true);
	 	            getGrid().getColumnModel().setEditable(15,true);
	 	        }else{
	 	            e.record.set('num_autoriza_factura','');
	 	            e.record.set('cod_control_factura','');
	 	            e.record.set('fecha_factura','');
	 	            getGrid().getColumnModel().setEditable(13,false);
	 	            getGrid().getColumnModel().setEditable(14,false);
	 	            getGrid().getColumnModel().setEditable(15,false);
	 	        }
	 	    }
	 	}
	 	grid.on('afteredit',onFactura);
	 	
	 	
	}
	
	function getMonedaPrincipal()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerMonedaPrincipal.php",
			method:'GET',
			success:cargar_moneda,
			failure:CM_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_moneda(resp){
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();
				txt_id_moneda_base.setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
				if(SelectionsRecord.data.id_moneda>0){
					if(SelectionsRecord.data.num_detalle_cotizado>0){
					    getGrid().getColumnModel().setEditable(4,false);
					}else{
						
						getGrid().getColumnModel().setEditable(4,true);
					}
					CM_getBoton('guardar-'+idContenedor).enable();
					
					if(SelectionsRecord.data.id_moneda!=txt_id_moneda_base.getValue()){
				  			
							get_tipo_cambio(SelectionsRecord.data.id_moneda);
				  		}
					}
			}
	}
	
	 
	 
	function get_tipo_cambio(moneda){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
			
		
		Ext.Ajax.request({
			url:direccion+"../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambio.php?fecha_solicitud="+SelectionsRecord.data.fecha_cotizacion.dateFormat('m-d-Y')+'&id_moneda='+moneda,
			method:'GET',
			success:cargar_tipo_cambio,
			failure:CM_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_tipo_cambio(resp){
			//Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				
				    if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue>0){
				     	CM_getBoton('guardar-'+idContenedor).enable();
				   		  if(getSelectionModel().getSelected().data.num_detalle_cotizado>0) {
				   		      getGrid().getColumnModel().setEditable(4,false);
				   		  }else{
							 getGrid().getColumnModel().setEditable(4,true);}	     	
				    	}
				   	else{
				   		 alert('No existe tipo de cambio para la fecha seleccionada');
				   		 CM_getBoton('guardar-'+idContenedor).disable();
					}
				 }
			}
	
	
	function get_fecha_adq()
	{
		Ext.Ajax.request({
			//url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+maestro.id_empresa,
			method:'GET',
			success:cargar_fecha_adq,
			failure:CM_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_fecha_adq(resp){
	    
		//Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
					//txt_fecha.minValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
					
					txt_fecha.setValue(root.getElementsByTagName('fecha_fin')[0].firstChild.nodeValue);
					txt_fecha.maxValue=txt_fecha.getValue();
					txt_fecha_entrega.maxValue=txt_fecha.getValue();
					txt_fecha_venc.maxValue=txt_fecha.getValue();
					txt_fecha.setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
					
					txt_fecha.minValue=txt_fecha.getValue();
					txt_fecha_entrega.minValue=txt_fecha.getValue();
					txt_fecha_venc.minValue=txt_fecha.getValue();
					txt_fecha.setValue('');
					getComponente('fecha_entrega').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					
				}
		}
	}		
			
			
			
	this.EnableSelect=function(x,z,y){
		   enable(x,z,y)
	}
	
			//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cotizacion.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	
	this.InitBarraMenu(paramMenu);	
	
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular',btn_anular_cotizacion,true,'anular','Anular Cotizacion');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Cotizaciones',btn_cotizacion_det,true,'cotizacion_det','Registrar Detalle');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Reg.Propuestas',btn_fin_propuestas,true,'fin_propuestas','Finalizar Reg.Cotizaciones');
	var CM_getBoton=this.getBoton;
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	function  enable(sel,row,selected){
		var record=selected.data; 
			if(selected&&record!=-1){
				CM_getBoton('anular-'+idContenedor).enable();
	            CM_getBoton('cotizacion_det-'+idContenedor).enable();
	           CM_getBoton('fin_propuestas-'+idContenedor).enable();
				if(record.fecha_cotizacion==""){
					getGrid().getColumnModel().setEditable(4,false);
				}else{
					getGrid().getColumnModel().setEditable(4,true);
				}
				if(record.estado_vigente=='anulado'){
				    CM_getBoton('cotizacion_det-'+idContenedor).disable();
					CM_getBoton('fin_propuestas-'+idContenedor).disable();
					CM_getBoton('anular-'+idContenedor).disable();
				}else{
				  
				   /* if(record.estado_vigente=='en_pago' ){
				        CM_getBoton('anular-'+idContenedor).disable();
				        
				    }else{*/
				        //CM_getBoton('cotizacion_det-'+idContenedor).disable();
				        //CM_getBoton('fin_propuestas-'+idContenedor).disable();
				        if(record.estado_vigente=='cotizado'||record.estado_vigente=='adjudicado'||record.estado_vigente=='finalizado'||record.estado_vigente=='orden_compra' || record.estado_vigente=='en_pago'){
        					   CM_getBoton('cotizacion_det-'+idContenedor).disable();
        					   CM_getBoton('fin_propuestas-'+idContenedor).disable();
				        }else{
        					CM_getBoton('cotizacion_det-'+idContenedor).enable();
        					CM_getBoton('fin_propuestas-'+idContenedor).enable();
        						if(record.tipo_entrega=='' || record.tipo_entrega==undefined){
        					 		CM_getBoton('cotizacion_det-'+idContenedor).disable();
        					 		CM_getBoton('fin_propuestas-'+idContenedor).disable();
        						}else{
        							if(record.num_detalle_cotizado_gral>0){
        					 			CM_getBoton('cotizacion_det-'+idContenedor).enable();
        					 			CM_getBoton('fin_propuestas-'+idContenedor).enable();
        							}else{
        								CM_getBoton('cotizacion_det-'+idContenedor).enable();
        								CM_getBoton('fin_propuestas-'+idContenedor).disable();
        							}
        						}
    				        }
				       //}
				  }
			}

			enableSelect(sel,row,selected);
		}
	
	this.iniciaFormulario();	
	iniciarEventosFormularios();
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_proceso_compra:maestro.id_proceso_compra
		}
	});
	layout_cotizacion.getLayout().addListener('layout',this.onResize);
	layout_proceso_compra.getVentana().addListener('beforehide',salta);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
