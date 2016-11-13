/**
 * Nombre:		  	    pagina_orden_compra_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-28 17:32:05
 */
function pagina_orden_compra_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var num_cotizaciones=0;
	var on=0;
	var pagina="";
	
	var fin_rev=0; //bandera para finalizar o revertir pagos, para finalizar fin_rev=1, para revertir fin_rev=2
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
		'precio_total_adjudicado',
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
		{name: 'fecha_cotizacion',type:'date',dateFormat:'Y-m-d'},
		'categoria','num_pagos','precio_total_moneda_cotizada','todo_pagado','falta_anular','precio_total_adjudicado','numeracion_periodo','id_auxiliar','pago_completado','factura_total','num_autoriza_factura','cod_control_factura',{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},'numeracion_oc','precio_total_adjudicado_con_impuestos','justificacion_adjudicacion','tipo_pago','id_caja','caja','id_cajero','cajero','id_depto_tesoro','depto_tesoro','avance',
		'cant_pagos_def','habilita_otra_gestion','por_adelanto','por_retgar','estado_adelanto','estado_retgar','tipo_documento','desc_documento'
		]),remoteSort:true});

	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO

//	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
//		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
//	
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/caja/ActionListarCaja.php?estado=1&id_proceso_compra='+maestro.id_proceso_compra}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
		});

		var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cajero/ActionListarCajero.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
		});

		function render_id_caja(value, p, record){return String.format('{0}', record.data['caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
		
		
		
		var ds_depto_tesoro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?tesoro=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto'])
		});
		
		function render_id_depto_tesoro(value, p, record){return String.format('{0}', record.data['depto_tesoro']);}
		
		
        var tpl_id_depto_tesoro=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto} </b></i>,<br><FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');
		function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_documento']);}
	
        
        
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
	
	
	
	// txt id_proceso_compra   ==> deberia ser fiel
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
			disabled:true
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		defecto:maestro.num_cotizacion,
		filterColValue:'COTIZA.num_cotizacion#COTIZA.periodo',
		save_as:'num_cotizacion',
		id_grupo:0  //1
	};
	
	
	
	Atributos[4]={//==> SI
		validacion:{
			name:'desc_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_15.apellido_paterno#PERSON_15.apellido_materno#PERSON_15.nombre#INSTIT.nombre',
		save_as:'id_proveedor',
		id_grupo:1  //1
	};
	
	
	
	// txt fecha_validez_oferta ==> se usa
	Atributos[5]= {
		validacion:{
			name:'precio_total_adjudicado_con_impuestos',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:95,
			width:'100%',
			disabled:true,
			grid_indice:8
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:1
	};
	
	Atributos[6]={//==> SI
		validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'40%',
			disabled:true,
			grid_indice:5
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		defecto:maestro.num_cotizacion,
		filterColValue:'MONEDA.nombre',
		save_as:'id_monedas',
		id_grupo:0  //1
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
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.tipo_entrega',
		save_as:'tipo_entrega',
		id_grupo:0
	};

	// txt fecha_entrega ==> se usa
	Atributos[8]= {
		validacion:{
			name:'fecha_entrega',
			fieldLabel:'Fecha de Entrega',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			width:170,
			grid_indice:10		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_entrega',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_entrega',
		id_grupo:1
	};
	
	Atributos[9]={//==> se usa//30
			validacion: {
			name:'tipo_pago',
			fieldLabel:'Tipo de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['caja','Pago por Caja'],['devengado','Pagos Devengados'],['avance','Cuenta Documentada']]}),
			valueField:'ID',
			displayField:'valor',
			
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:80,
			width:180,
			
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.tipo_pago',
		defecto:'devengado',
		save_as:'tipo_pago',
		id_grupo:2
	};
	

	
	// txt impuestos
	/*Atributos[10]={//==> se usa
			validacion: {
			name:'impuestos',
			fieldLabel:'Impuesto',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[[1,'Factura c/ IVA'],[2,'Factura s/ IVA'],[3,'Recibo sin Retencion'],[4,'Recibo Retencion Bienes'],[5,'Recibo Retencion Servicios']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			align:'center',
			grid_editable:false,
			width_grid:80,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:12,
			renderer:impuesto,
			width:180
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.impuestos',
		defecto:1,
		save_as:'impuestos',
		id_grupo:0
	};*/

	var fCol=new Array();
		var fVal=new Array();
		fCol[0]='PLANT.sw_compro';
		fVal[0]='1';




		Atributos[10]={
			validacion:{
				name:'tipo_documento',
				fieldLabel:'Tipo Documento',
				allowBlank:false,
				emptyText:'Documento...',
				desc: 'desc_documento',
				store:ds_tipo_plantilla,
				valueField: 'tipo_plantilla',
				displayField: 'desc_plantilla',
				queryParam: 'filterValue_0',
				filterCol:'PLANT.tipo_plantilla#PLANT.desc_plantilla',
				filterCols:fCol,
				filterValues:fVal,
				typeAhead:true,
				tpl:tpl_tipo_plantilla,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_tipo_plantilla,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				grid_indice:12
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PLANPA.tipo_plantilla',
			id_grupo:0
		};

	
	

	// txt garantia
	Atributos[11]={//==> SI
		validacion:{
			name:'garantia',
			fieldLabel:'Garantia',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:13	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.garantia',
		save_as:'garantia',
		id_grupo:0
	};

	
//	 txt figura_acta
//	Atributos[12]={//==>SI
//		validacion:{
//			name:'figura_acta',
//			fieldLabel:'Figura en Acta',
//			allowBlank:true,
//			maxLength:10,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:100,
//			width:'100%',
//			disable:false,
//			grid_indice:16		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'COTIZA.figura_acta',
//		save_as:'figura_acta',
//		id_grupo:0
//	};


//	 txt fecha_venc
//	Atributos[13]= {//==>SI
//		validacion:{
//			name:'fecha_venc',
//			fieldLabel:'Fecha Vencimiento',
//			allowBlank:false,
//			format: 'd/m/Y', //formato para validacion
//			minValue: '01/01/1900',
//			disabledDaysText: 'Día no válido',
//			grid_visible:true,
//			grid_editable:false,
//			renderer: formatDate,
//			width_grid:85,
//			disabled:false		,
//			grid_indice:40
//		},
//		form:true,
//		tipo:'DateField',
//		filtro_0:false,
//		filterColValue:'COTIZA.fecha_venc',
//		dateFormat:'m-d-Y',
//		defecto:'',
//		save_as:'fecha_venc',
//		id_grupo:0  //1
//	};
//	
	// txt lugar_entrega ==> se usa
	Atributos[12]={//14
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
			width:'100%',
			disabled:false,
			grid_indice:14
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		
		filterColValue:'COTIZA.lugar_entrega',
		save_as:'lugar_entrega',
		id_grupo:1  //1
		
	};
	
	
// txt fecha_reg
	Atributos[13]= {//==>SI//15
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
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
	Atributos[14]={//==>SI//16
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
	Atributos[15]={//==> SI//17
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


Atributos[16]={//18
		validacion:{
			name:'desc_proveedor',
			fieldLabel:'Nombre Pago',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			width:'90%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'nombre_pago',
		save_as:'nombre_pago',
		id_grupo:3
	};
	
	
	
//	Atributos[19]={
//		validacion:{
//			name:'num_proceso',
//			fieldLabel:'Nº Pedido',
//			allowBlank:true,
//			maxLength:30,
//			minLength:0,
//			selectOnFocus:true,
//			displayField: maestro.num_proceso,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:100,
//			width:'100%',
//			disabled:false,
//			grid_indice:1		
//		},
//		tipo: 'TextField',
//		filtro_0:false,
//		defecto:maestro.num_proceso,
//		save_as:'num_proceso'
//	};
	
	
	
	/*************/
	
//	Atributos[20]={
//		validacion:{
//			name:'direccion_proveedor',
//			fieldLabel:'Direccion',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:100,
//			width:'100%',
//			disabled:true,
//			grid_indice:3		
//		},
//		tipo: 'TextArea',
//		form: true,
//		filtro_0:false,
//		filterColValue:'',
//		save_as:'',
//		id_grupo:0
//	};
//
//	
//	Atributos[21]={
//		validacion:{
//			name:'mail_proveedor',
//			fieldLabel:'Email',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:100,
//			width:'100%',
//			disabled:true,
//			grid_indice:4		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'',
//		save_as:'',
//		id_grupo:0
//	};
//	
//	
//	
//	Atributos[22]={
//		validacion:{
//			name:'telefono1_proveedor',
//			fieldLabel:'Telef. 1',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:85,
//			width:'100%',
//			disabled:true,
//			grid_indice:5		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'',
//		save_as:'',
//		id_grupo:0
//	};
//	
//	
//	Atributos[23]={
//		validacion:{
//			name:'telefono2_proveedor',
//			fieldLabel:'Telef. 2',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:85,
//			width:'100%',
//			disabled:true,
//			grid_indice:6		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'',
//		save_as:'',
//		id_grupo:0
//	};
//	
//	
//	Atributos[24]={
//		validacion:{
//			name:'fax_proveedor',
//			fieldLabel:'Fax',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:85,
//			width:'100%',
//			disabled:true,
//			grid_indice:7		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'',
//		save_as:'',
//		id_grupo:0
//	};
	
	
	
//	Atributos[25]= {
//		validacion:{
//			name:'fecha_cotizacion',
//			fieldLabel:'Fecha de Cotizacion',
//			allowBlank:true,
//			format: 'd/m/Y', //formato para validacion
//			minValue: '01/01/1900',
//			disabledDaysText: 'Día no válido',
//			grid_visible:false,
//			grid_editable:false,
//			renderer: formatDate,
//			width_grid:85,
//			disabled:false,
//			grid_indice:10		
//		},
//		form:true,
//		tipo:'DateField',
//		filtro_0:false,
//		filterColValue:'COTIZA.fecha_cotizacion',
//		dateFormat:'m-d-Y',
//		defecto:' ',
//		save_as:'fecha_cotizacion',
//		id_grupo:0
//	};
	
	
	Atributos[17]={//26
		validacion:{
			name:'numeracion_oc',
			fieldLabel:'Orden Compra',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		defecto:1,
		filtro_0:false,
		filterColValue:'num_orden_compra',
		save_as:'num_orden_compra',
		id_grupo:0
	};
	
	Atributos[18]={//27
		validacion:{
			name:'categoria',
			fieldLabel:'Modalidad',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:1		
		},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'categoria',
		id_grupo:1
	};
	
//	Atributos[28]={
//		validacion:{
//			name:'num_orden_compra_sis',
//			fieldLabel:'OC Sis',
//			allowBlank:true,
//			maxLength:100,
//			minLength:0,
//			selectOnFocus:true,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:85,
//			width:'100%',
//			disabled:false,
//			grid_indice:7		
//		},
//		tipo: 'TextField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'num_orden_compra_sis',
//		save_as:'',
//		id_grupo:0
//	};
//	
	
	
	
	
	// txt observaciones
	Atributos[19]={//==>SI//29
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
			disabled:false,
			grid_indice:60
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		defecto:maestro.lugar_entrega,
		filterColValue:'COTIZA.observaciones',
		save_as:'observaciones',
		defecto:'-',
		id_grupo:1  //1
	};
	
	
// txt forma_pago ==se usa
	Atributos[20]={
		validacion:{
			name:'forma_pago',
			fieldLabel:'Forma de Pago',
			allowBlank:true,
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'90%',
			disable:false,
			grid_indice:11	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.forma_pago',
		save_as:'forma_pago',
		id_grupo:2
	};	
	
	
	
	Atributos[21]= {//31
		validacion:{
			name:'precio_total_moneda_cotizada',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:95,
			width:'100%',
			disable:false,
			grid_indice:8
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.precio_total_moneda_cotizada',
		save_as:'precio_total_moneda_cotizada',
		id_grupo:0
	};
	
	
	//todo_pagado==> permitirá finalizar el plan de pagos
	Atributos[22]={//32
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'todo_pagado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'todo_pagado'
	};
	
	
	Atributos[23]={//33
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'falta_anular',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'falta_anular'
	};
	
	
	
	Atributos[24]={//34
		validacion:{
			name:'factura_total',
			fieldLabel:'Factura por el Total',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID', 'valor'],
				data:Ext.orden_compra_combo.factura_total
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, 
			grid_indice:13,
			width_grid:110,
			width:180,
			grid_editable:false 
		},
		tipo:'ComboBox',
		filtro_0:false,
		defecto:'no',
		save_as:'factura_total',
		id_grupo:3
	};
	
	Atributos[25]={//35
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
			width_grid:85,
			align:'right',
			width:'40%',
			disabled:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form:true,
		filtro_0:false,
		filterColValue_0:'COTIZA.num_cotizacion#COTIZA.periodo',
		save_as:'numeracion_periodo',
		id_grupo:0
	};
	
	
	
	
	
	Atributos[26]={//==> SI//36
		validacion:{
			name:'num_factura',
			fieldLabel:'Nº Factura',
			allowBlank:true,
			maxLength:150,
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
			width:'70%',
			disabled:false,
			grid_indice:11
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.num_factura',
		save_as:'num_factura',
		id_grupo:3 //1
	};
	
	Atributos[27]={//37
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
			grid_visible:false,
			grid_editable:true,
			width_grid:105,
			width:'70%',
			disabled:false,
			grid_indice:14
			
		},
		tipo: 'NumberField',
		form: true,
		save_as:'num_autoriza_factura',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[28]={//==> SI//38
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
			grid_visible:false,
			grid_editable:true,
			width_grid:90,
			width:'70%',
			disabled:false,
			grid_indice:15
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		save_as:'cod_control_factura',
		id_grupo:0 //1
	};
	
	
	Atributos[29]= {//29
		validacion:{
			name:'fecha_factura',
			fieldLabel:'Fecha de Factura',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
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
		id_grupo:3
	};
	
	Atributos[30]={//40
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				align:'right',
				width:'40%',
				disabled:true,
				grid_indice:1
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'
			
		};
		
		
		
		Atributos[31]={//41
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'justificacion_adjudicacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'justificacion_adjudicacion'
		};

		
		// txt num_pagos
	
Atributos[32]={//31
			validacion:{
				name:'id_depto_tesoro',
				fieldLabel:'Departamento de Tesoreria',
				allowBlank:true,
				emptyText:'Depto Tesoreria...',
				desc: 'depto_tesoro', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto_tesoro,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO_TESORO.codigo_depto#DEPTO_TESORO.nombre_depto',
				typeAhead:true,
				tpl:tpl_id_depto_tesoro,
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
				renderer:render_id_depto_tesoro,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:180,
				disabled:false

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'DEPTO.nombre_depto#DEPTO.codigo_depto',
			save_as:'id_depto_tesoro',
			id_grupo:2
		};
	
	Atributos[33]={//42
			validacion:{
				name:'id_caja',
				fieldLabel:'Caja',
				allowBlank:true,
				emptyText:'Caja...',
				desc: 'caja', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_caja,
				valueField: 'id_caja',
				displayField: 'desc_unidad_organizacional',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
				typeAhead:true,
				tpl:tpl_id_caja,
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
				renderer:render_id_caja,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:180,
				disabled:true

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
			save_as:'id_caja',
			id_grupo:2
		};
		// txt id_cajero
		Atributos[34]={//43
			validacion:{
				name:'id_cajero',
				fieldLabel:'Cajero',
				allowBlank:true,
				emptyText:'Cajero...',
				desc: 'cajero', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cajero,
				valueField: 'id_cajero',
				displayField: 'desc_empleado',
				queryParam: 'filterValue_0',
				filterCol:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre',
				typeAhead:true,
				tpl:tpl_id_cajero,
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
				renderer:render_id_cajero,
				grid_visible:true,
				grid_editable:false,
				width_grid:130,
				width:180,
				disabled:true

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre#EMPLEA_1.codigo_empleado',
			save_as:'id_cajero',
			id_grupo:2
		};
		
		
		Atributos[35]={//==> SI//44
		validacion:{
			name:'num_pagos',
			fieldLabel:'Nº Pagos',
			allowBlank:true,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:1,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'right',
			width:'90%',
			disabled:false,
			grid_indice:15
		},
		tipo: 'NumberField',
		form: true,
		defecto:1,
		filtro_0:false,
		filterColValue:'COTIZA.num_pagos',
		save_as:'num_pagos',
		id_grupo:2  //1
	};
	
	
	
		Atributos[36]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'finalizado',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			defecto:0,
			filtro_0:false,
			save_as:'justificacion_adjudicacion'
		};
		
		Atributos[37]={//==> SI//42
		validacion:{
			name:'por_adelanto',
			fieldLabel:'% Adelanto',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width_grid:100,
			width:'90%',
			disabled:false,
			grid_indice:16
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:false,
		filterColValue:'COTIZA.por_adelanto',
		save_as:'por_adelanto',
		id_grupo:4  //1
	};
	
	
	Atributos[38]={//==> SI//42
		validacion:{
			name:'por_retgar',
			fieldLabel:'% Retencion por Garantia',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width_grid:100,
			width:'90%',
			disabled:false,
			grid_indice:17
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:false,
		filterColValue:'COTIZA.por_retgar',
		save_as:'por_retgar',
		id_grupo:4  //1
	};
	
	
	Atributos[39]={//40
			validacion:{
				name:'estado_adelanto',
				fieldLabel:'Estado Adelanto',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:55,
				align:'right',
				width:'100%',
				disabled:true
				
			},
			tipo: 'TextField',
			filtro_0:false,
			filterColValue:'COTIZA.estado_adelanto',
			id_grupo:0
			
		};
		
		
		
		Atributos[40]={//40
			validacion:{
				name:'estado_retgar',
				fieldLabel:'Estado RetGar',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:55,
				align:'right',
				width:'100%',
				disabled:true
				
			},
			tipo: 'TextField',
			filtro_0:false,
			filterColValue:'COTIZA.estado_retgar',
			id_grupo:0
		};
		
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

//	function impuesto(val,cell,record,row,colum,store){
//					if(val==1){
//					  return 'Factura c/ IVA';	
//					}
//					if(val==2){
//						return 'Factura s/IVA';
//					}
//					if(val==3){
//						return 'Recibo sin retencion';
//					}
//					if(val==4){
//						return 'Recibo con retencion Bien';
//					}else{
//						return 'Recibo con retencion Servicio';
//					}
//			};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Orden de Servicios',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/plan_pago/plan_pago_serv.php'};
	layout_orden_compra_serv_det = new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout_orden_compra_serv_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_orden_compra_serv_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnDelete=this.btnDelete;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_dialog= this.getDialog;
	var CM_saveSuccess=this.saveSuccess;
	var enableSelect=this.EnableSelect;
	var EstehtmlMaestro=this.htmlMaestro;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={//guardar:{crear:true,separador:false},
	
	actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	Save:{url:direccion+'../../../control/cotizacion/ActionGuardarCotizacionOrdenCompra.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:680,minWidth:450,minHeight:200,	closable:true,titulo:'Detalle - Orden de compra',columnas:['47%','47%'],
	grupos:[{
			tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
		},{
			tituloGrupo:'Orden de Compra',
			columna:1,
			id_grupo:1
		},{
			tituloGrupo:'Definición de Pago',
			columna:0,
			id_grupo:2
		},{
			tituloGrupo:'Proveedor',
			columna:0,
			id_grupo:3
		}{
			tituloGrupo:'Retenciones',
			columna:1,
			id_grupo:4
		}
		
	]}};
	
//	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proceso_compra/ActionListarProcesoCompra.php?id_proceso_compra='+maestro.id_proceso_compra}),
//		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proceso_compra',totalRecords: 'TotalCount'},['id_proceso_compra',
//		'num_proceso','codigo_proceso',
//		'observaciones','desc_moneda','desc_tipo_adq'
//		])
//		});
//
//		ds_maestro.load({
//			params:{
//				start:0,
//				limit: paramConfig.TamanoPagina,
//				CantFiltros:paramConfig.CantFiltros,
//				id_proceso_compra:maestro.id_proceso_compra
//			},
//			callback:cargar_maestro
//		});
//
//		function cargar_maestro(){
//			data1=[['Nº Proceso',ds_maestro.getAt(0).get('num_proceso')],  ['Cod. Proceso',ds_maestro.getAt(0).get('codigo_proceso')],   ['Moneda',ds_maestro.getAt(0).get('desc_moneda')],   ['Descripcion',ds_maestro.getAt(0).get('observaciones')], ['Tipo Adquisicion',ds_maestro.getAt(0).get('desc_tipo_adq')],  ];
//            Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
//		}
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
	
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
		maestro.factura_total=datos.m_factura_total;
//		ds_maestro.load({
//				params:{
//					start:0,
//					limit: paramConfig.TamanoPagina,
//					CantFiltros:paramConfig.CantFiltros,
//					id_proceso_compra:maestro.id_proceso_compra
//				},
//				callback:cargar_maestro
//			});
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proceso_compra:maestro.id_proceso_compra,
				adjudicacion:'si'
			}
		};
		
		_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.limpiarStore()
		this.btnActualizar();
		
		iniciarEventosFormularios();
		Atributos[1].defecto=maestro.id_proceso_compra;		
		paramFunciones.Save.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra
		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones);
		
	};
	
	
	
	
	function btn_anular_cotizacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
			var dialog=CM_dialog();
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
		  Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	   }
	   this.btnActualizar;
    }

    function exito(resp){
		  if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				if(root.getElementsByTagName('error')[0].firstChild.nodeValue=='false'){
					Ext.MessageBox.alert('Estado','Anulacion completada');		
					ds.load({
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							m_id_proceso_compra:maestro.id_proceso_compra,
							adjudicacion:'si'
						}
					});
				}
			}
		}

	

    function btn_orden_compra(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
		     if(SelectionsRecord.data.id_auxiliar>0){ 
		    
		  	    CM_ocultarGrupo('Oculto');
    			CM_mostrarGrupo('Orden de Compra');
    			CM_mostrarGrupo('Retenciones');
    			CM_ocultarComponente(getComponente('id_depto_tesoro'));
    			
    			cmbDepto.modificado=true;
					ds_depto_tesoro.baseParams={
						estado:2,id_cotizacion:SelectionsRecord.data.id_cotizacion
					}
    			if(SelectionsRecord.data.avance=='si'){
    			    
    			   CM_ocultarComponente(getComponente('id_caja'));
	               CM_ocultarComponente(getComponente('id_cajero'));
	               CM_ocultarComponente(getComponente('id_depto_tesoro'));
	               getComponente('id_caja').allowBlank=true;
	               getComponente('id_cajero').allowBlank=true;
	               getComponente('id_depto_tesoro').allowBlank=true;
    			   getComponente('tipo_pago').setValue('avance');
    			   getComponente('num_pagos').setValue(1);
    			   getComponente('num_pagos').disable();
    			   getComponente('tipo_pago').disable();
    			   CM_ocultarComponente(getComponente('forma_pago')); 
    			}else{
    			    CM_mostrarComponente(getComponente('id_depto_tesoro'));
    			    getComponente('id_depto_tesoro').allowBlank=false;
    			    getComponente('tipo_pago').enable();
    			  if(SelectionsRecord.data.tipo_pago=='caja'){
    			    CM_mostrarComponente(getComponente('id_caja'));
    			    CM_mostrarComponente(getComponente('id_cajero'));
    			    CM_ocultarComponente(getComponente('forma_pago'));
    			    
    			  }else{
    			    
    			    getComponente('id_caja').allowBlank=true;
    			    getComponente('id_cajero').allowBlank=true;
    			    CM_ocultarComponente(getComponente('id_caja'));
    			    CM_ocultarComponente(getComponente('id_cajero'));
    			    
                     if(SelectionsRecord.data.tipo_pago=='avance'){
                         getComponente('tipo_pago').reset();
                         CM_ocultarComponente(getComponente('forma_pago'));
                         getComponente('num_pagos').disable();
                     }
    			    }
    			}
    			

    			if(SelectionsRecord.data.factura_total=='no'){
    			     
    			     CM_ocultarComponente(getComponente('num_factura'));
    			     CM_ocultarComponente(getComponente('fecha_factura'));
    			     getComponente('num_factura').allowBlank=true;
    			     getComponente('fecha_factura').allowBlank=true;
    			     getComponente('num_factura').clearInvalid();
    			     getComponente('fecha_factura').clearInvalid();
    			}else{
    			     
    			     CM_mostrarComponente(getComponente('num_factura'));
    			     CM_mostrarComponente(getComponente('fecha_factura'));
    			     getComponente('num_factura').allowBlank=false;
    			     getComponente('fecha_factura').allowBlank=false;
    			}
    			
    			CM_btnEdit();
    			var dialog=CM_dialog();
    			dialog.buttons[0].setText('Guardar Datos');
    			dialog.buttons[0].enable();
		     }else{
			    Ext.MessageBox.alert('Estado','El proveedor necesita tener una cuenta-auxiliar asociada para que se emita la Orden de Compra correspondiente');
			}
		}
		else{
		  Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	   }
	   this.btnActualizar;
    }



	function btn_orden_compra_rep(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
			var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
			pagina=direccion+'../../../control/cotizacion/reporte/ActionPDFOrdenCompra.php?'+data;
			window.open(pagina)	;
		}
		else{
		  Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	   }
	}

			
			
	function btn_plan_pago(){
		this.btnActualizar;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		  var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.estado_vigente!='finalizado'){
			  if(SelectionsRecord.data.estado_vigente=='orden_compra' || SelectionsRecord.data.estado_vigente=='en_pago'){
				var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
				data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
				data =data+'&m_num_pagos='+SelectionsRecord.data.num_pagos;
				data =data+'&m_factura_total='+SelectionsRecord.data.factura_total;
				data =data+'&m_desc_moneda='+maestro.desc_moneda;
				data =data+'&m_tipo_documento='+maestro.tipo_documento;
				var ParamVentana={Ventana:{width:'90%',height:'70%'}};
				layout_orden_compra_serv_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/plan_pago/plan_pago.php?'+data,'Plan de Pagos',ParamVentana);
				layout_orden_compra_serv_det.getVentana().on('resize',function(){
					layout_orden_compra_serv_det.getLayout().layout();
				})
			  }else{
				Ext.MessageBox.alert('Estado', 'Solo cotizaciones con orden de compra pueden definir Plan de Pagos')
			  }
			}else{
				Ext.MessageBox.alert('Estado','Solo registros que no esten finalizados');
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
			}
		}
		
		function btn_plan_pago_rep(){
			//var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue();
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
						window.open(direccion+'../../../control/plan_pago/reporte/ActionPDFPlanPago1.php?'+data)	
					}
            	else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
				}
			}
			
		
	
			
     	function btn_finalizar(){
     		
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Orden de Compra');
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
				if(NumSelect!=0){
					if(SelectionsRecord.data.estado_vigente!='finalizado'){
					   if(confirm("Esta seguro de finalizar los pagos?")){
					 	 if(parseFloat(SelectionsRecord.data.todo_pagado)>=parseFloat(SelectionsRecord.data.precio_total_adjudicado_con_impuestos)){//todas las cuotas fueron pagadas==> si es posible finalizar
				 		 	getComponente('finalizado').setValue(1);
							CM_btnEdit();
					 	 }else{
							Ext.MessageBox.alert('Estado','Tiene pagos pendientes');
						}
					}
				}else{
						Ext.MessageBox.alert('Estado', 'Ya se realizó la finalizacion de pagos');
					 }
				}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
			}
     	}
			
			
			
//			function finalizado(resp){
//				if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
//				var root=resp.responseXML.documentElement;
//						
//				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
//				  	
//				  	 if(fin_rev==1){
//				  		  	Ext.MessageBox.alert('Estado','Finalizacion satisfactoria');
//				  		  	
//				  		   
//				  	 }
//				  	 if(fin_rev==2){
//				  	 	Ext.MessageBox.alert('Estado','Pago revertido satisfactoriamente');
//				  	 }
//				  	 ds.load({
//						params:{
//							start:0,
//							limit: paramConfig.TamanoPagina,
//							CantFiltros:paramConfig.CantFiltros,
//							m_id_proceso_compra:maestro.id_proceso_compra,
//							adjudicacion:'si'
//						}
//					});
//				  }
//				}
//			}
			
			

//		function btn_solicitud_pago(){
//			
//			//var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue();
//				var sm=getSelectionModel();
//				var NumSelect=sm.getCount();
//				if(NumSelect!=0){
//					var SelectionsRecord=sm.getSelected();
//					var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
//						window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFSolicitudPago.php?'+data)	
//						}
//				else{
//					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
//				}
//		}
			//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		getComponente('observaciones').setValue('');
	    getComponente('num_pagos').minValue=1;
	    txt_factura_total= getComponente('factura_total');
	    txt_tipo_pago=getComponente('tipo_pago');
	    CM_ocultarComponente(getComponente('id_caja'));
	    CM_ocultarComponente(getComponente('id_cajero'));
	    
	    cmbDepto=getComponente('id_depto_tesoro');
	    txt_factura_total.on('select', onFacturaS);
	txt_tipo_pago.on('select',onTipoPago);
	
	var onFacturaS=function(e){
		
	    if(e.value=='si'){
	        CM_mostrarComponente(getComponente('num_factura'));
	        //CM_mostrarComponente(getComponente('num_autoriza_factura'));
	        //CM_mostrarComponente(getComponente('cod_control_factura'));
	        CM_mostrarComponente(getComponente('fecha_factura'));
	        getComponente('num_factura').allowBlank=true;
	        //getComponente('num_autoriza_factura').allowBlank=true;
	        getComponente('tipo_documento').allowBlank=false;
	        getComponente('num_factura').allowBlank=false;
	        getComponente('fecha_factura').allowBlank=false;
	    }else{
	        CM_ocultarComponente(getComponente('num_factura'));
	        CM_ocultarComponente(getComponente('fecha_factura'));
	        getComponente('num_factura').allowBlank=true;
	        getComponente('tipo_documento').allowBlank=true;
	        getComponente('fecha_factura').allowBlank=true;
	        getComponente('num_factura').clearInvalid();
	        getComponente('fecha_factura').clearInvalid();
	        
	    }
	    
	    
	    
	}
	
	var onTipoPago=function(e){
	    getComponente('num_pagos').allowBlank=false;
	    getComponente('num_pagos').setValue(1);
	    if(e.value=='caja'){
	        cmbDepto.modificado=true;
	        CM_ocultarComponente(getComponente('forma_pago'));
	        CM_mostrarComponente(getComponente('id_caja'));
	        CM_mostrarComponente(getComponente('id_cajero'));
	        CM_mostrarComponente(getComponente('id_depto_tesoro'));
	        getComponente('num_pagos').disable();
	        getComponente('id_caja').allowBlank=false;
	        getComponente('id_cajero').allowBlank=false;
	        getComponente('id_depto_tesoro').allowBlank=false;
	    }else{
   	        CM_ocultarComponente(getComponente('id_caja'));
	        CM_ocultarComponente(getComponente('id_cajero'));
	       
	        getComponente('id_caja').allowBlank=true;
	        getComponente('id_cajero').allowBlank=true;
	        getComponente('id_depto_tesoro').allowBlank=true;
	        getComponente('id_caja').reset();
	        getComponente('id_cajero').reset();
	        getComponente('id_depto_tesoro').reset();
	        
            if(e.value=='avance'){
                if(getComponente('avance')=='si'){
                    CM_ocultarComponente(getComponente('forma_pago'));
                     CM_ocultarComponente(getComponente('id_depto_tesoro'));
	                getComponente('num_pagos').disable();
	               
                }else{
                    CM_mostrarComponente(getComponente('id_depto_tesoro'));
                    CM_mostrarComponente(getComponente('forma_pago'));
	                getComponente('num_pagos').enable();
	                getComponente('tipo_pago').setValue('');
	                CM_ocultarComponente(getComponente('forma_pago'));
	                getComponente('num_pagos').disable();
                }
            }else{
               CM_mostrarComponente(getComponente('forma_pago'));
	           getComponente('num_pagos').enable();
            }
	    }
	}
	            cmb_id_caja=getComponente('id_caja');
				cmb_id_cajero=getComponente('id_cajero');
				
				var onCaja=function(e){
				    if(getComponente('id_caja').getValue()>0){
				        getComponente('id_cajero').enable();
				    }
					cmb_id_cajero.reset();
					cmb_id_cajero.modificado=true;
					ds_cajero.baseParams={m_id_caja:cmb_id_caja.getValue()};
				}
				cmb_id_caja.on('select',onCaja);
				cmb_id_caja.on('change',onCaja);
				
	
	
	
	
	var onDepto=function(e){
	    cmb_id_caja.reset();
	    cmb_id_caja.modificado=true;
	    ds_caja.baseParams={m_id_depto:cmbDepto.getValue()};
	    cmb_id_caja.enable();
	}
	
	cmbDepto.on('change',onDepto);
		cmbDepto.on('select',onDepto);	
	
	
    	getSelectionModel().on('rowdeselect',function(){
    		if(_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.limpiarStore()){
    			_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.bloquearMenu();
    		}
    	})
	
	}
		
	this.EnableSelect=function(x,z,y){
		_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.desbloquearMenu();
		enable(x,z,y);
	}
					
	
    function btn_revertir(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		this.btnActualizar;
		if(NumSelect!=0){
		    if(confirm('Está seguro de revertir la Adjudicación?')){
			  var SelectionsRecord=sm.getSelected();
			  fin_rev=2;
			//if(SelectionsRecord.data.)
			   	var data='cantidad_ids=1'+'&id_cotizacion='+SelectionsRecord.data.id_cotizacion+'&id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
							Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionRevertirAdjudicacion.php",
							params:data,
							method:'POST',
							failure:CM_conexionFailure,
							success:revertido,
							timeout:100000000});
					
				}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}			
	
	function revertido(resp){
	    if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
						
				  if(root.getElementsByTagName('error')[0].firstChild.nodeValue=='false'){
				      alert(root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
				  }
				   ds.load({
						params:{
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							m_id_proceso_compra:maestro.id_proceso_compra,
							adjudicacion:'si'
						}
					});
	    }
	    
	}
	
	function btn_resolucion_adjudicacion(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
					if(NumSelect!=0){

                        window.open(direccion+'../../../control/adjudicacion/ActionPDFAdjudicacion.php?m_id_cotizacion='+SelectionsRecord.data.id_cotizacion);

					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
			}
	
    
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_orden_compra_serv_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	    this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular',btn_anular_cotizacion,true,'anular','Anular Cotización');
	    this.AdicionarBoton('../../../lib/imagenes/print.gif','Nota de Adjudicacion',btn_resolucion_adjudicacion,true,'resolucion_adjudicacion','Nota de Adjudicación');	
	    this.AdicionarBoton('../../../lib/imagenes/detalle.png','Datos Compra',btn_orden_compra,true,'orden_compra','Datos Compra');
		//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Plan de Pagos',btn_plan_pago,true,'plan_pago','Plan de Pagos');
	    this.AdicionarBoton('../../../lib/imagenes/volver.png','Revertir OC',btn_revertir,true,'revertir','Revertir Adjudicación');
			
	    this.AdicionarBoton('../../../lib/imagenes/print.gif','Rep Orden Compra',btn_orden_compra_rep,true,'orden_compra_rep','OC');
	    this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Plan de Pagos',btn_plan_pago_rep,true,'plan_pago_rep','Cronograma de Pagos');
        
		
		
        //this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar',btn_finalizar,true,'finalizar','Finalizar Compra');		
        
		var CM_getBoton=this.getBoton;
		CM_getBoton('orden_compra-'+idContenedor).enable();
		
		CM_getBoton('orden_compra_rep-'+idContenedor).disable();
		CM_getBoton('plan_pago_rep-'+idContenedor).disable();
		
		CM_getBoton('anular-'+idContenedor).enable();
		CM_getBoton('revertir-'+idContenedor).enable();
		//CM_getBoton('fin_pagos-'+idContenedor).enable();
		function  enable(sel,row,selected){
			var record=selected.data; 
			if(selected&&record!=-1){
			    CM_getBoton('revertir-'+idContenedor).enable();
				CM_getBoton('anular-'+idContenedor).enable();
//				if(parseFloat(record.cant_pagos_def)==parseFloat(record.num_pagos)){
//			        CM_getBoton('fin_pagos-'+idContenedor).enable();
//			    }else{
//			        CM_getBoton('fin_pagos-'+idContenedor).disable();
//			    }
				
			    	if((record.estado_vigente=='en_pago')||(record.estado_vigente=='formulacion_pp')){
						    //_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.desbloquearMenu();
						    CM_getBoton('orden_compra-'+idContenedor).disable();
							CM_getBoton('orden_compra_rep-'+idContenedor).enable();
							CM_getBoton('plan_pago_rep-'+idContenedor).enable();
							CM_getBoton('revertir-'+idContenedor).disable();
							CM_getBoton('anular-'+idContenedor).disable();
						}else{
							if(record.estado_vigente=='finalizado'){
							    CM_getBoton('orden_compra-'+idContenedor).disable();
								//_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.bloquearMenu();
								CM_getBoton('orden_compra_rep-'+idContenedor).enable();
								CM_getBoton('plan_pago_rep-'+idContenedor).enable();
								CM_getBoton('revertir-'+idContenedor).disable();
							}else{//OC
								  	if(record.num_pagos>0 && record.estado_vigente!='anulado'){
        								    CM_getBoton('orden_compra-'+idContenedor).enable();
        								    CM_getBoton('revertir-'+idContenedor).enable();
									        CM_getBoton('orden_compra_rep-'+idContenedor).enable();
								            CM_getBoton('plan_pago_rep-'+idContenedor).disable();
									        //_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.desbloquearMenu();
								   }else{
								   	 if(record.estado_vigente=='cotizado' || record.estado_vigente=='invitado' ||record.estado_vigente=='anulado'||record.estado_vigente=='aperturado'){                       CM_getBoton('revertir-'+idContenedor).disable();
								   	        CM_getBoton('orden_compra-'+idContenedor).disable();
    										CM_getBoton('orden_compra_rep-'+idContenedor).disable();
								   	        CM_getBoton('plan_pago_rep-'+idContenedor).disable();
								   	    if(record.estado_vigente=='anulado'){
											CM_getBoton('orden_compra-'+idContenedor).disable();
                							CM_getBoton('orden_compra_rep-'+idContenedor).disable();
                							//_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.bloquearMenu();
                							CM_getBoton('plan_pago_rep-'+idContenedor).disable();
                							
								   	    }else{
                   			   			   	///si se añade el boton para eliminar cotizaciones==> se deberá habilitar solo en esta parte
                   			   			   	//CM_getBoton('anular-'+idContenedor).enable();
								   	    }
									}else{
									      	  if(record.estado_vigente=='adjudicado'){
                   			   			            CM_getBoton('orden_compra-'+idContenedor).enable();
            										CM_getBoton('orden_compra_rep-'+idContenedor).disable();
            										CM_getBoton('plan_pago_rep-'+idContenedor).disable();
            										CM_getBoton('revertir-'+idContenedor).enable();
            										//_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.bloquearMenu();
            				
               			   			            }else{//alert("entra");
               			   			                //_CP.getPagina(layout_orden_compra_serv_det.getIdContentHijo()).pagina.bloquearMenu();
 						                            CM_getBoton('orden_compra-'+idContenedor).enable();
								                    CM_getBoton('revertir-'+idContenedor).enable();
            										CM_getBoton('orden_compra_rep-'+idContenedor).enable();
            										CM_getBoton('plan_pago_rep-'+idContenedor).disable();
            						            }
               			   			        }
               			   			}
							}
						}
				     
			}

			enableSelect(sel,row,selected);
		}
	
	
   ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_proceso_compra:maestro.id_proceso_compra,
			adjudicacion:'si'
		}
	});
        
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_orden_compra_serv_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}