/**
 * Nombre:		  	    pagina_orden_compra_det.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-05-28 17:32:05
 */
function pagina_orden_compra_tasa(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var num_cotizaciones=0;
	var on=0;
	var pagina="";
	var bloquear='no';
	var componentes=new Array;
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
		'categoria','num_pagos','precio_total_moneda_cotizada','todo_pagado','falta_anular','precio_total_adjudicado','numeracion_periodo','id_auxiliar','pago_completado','factura_total','num_autoriza_factura','cod_control_factura',{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},'numeracion_oc','precio_total_adjudicado_con_impuestos','justificacion_adjudicacion','tipo_pago','id_caja','caja','id_cajero','cajero','avance','id_depto_tesoro','depto_tesoro','cant_pagos_def','habilita_otra_gestion','tipo_documento','desc_documento','por_adelanto','por_retgar','estado_adelanto','estado_retgar','avance_habilitado','monto_adelanto','monto_adelanto_moneda_cotizada','nro_contrato','con_contrato','total_dcto_anticipo',
		{name: 'fecha_ini_ctto',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_ctto',type:'date',dateFormat:'Y-m-d'},
		'estado_devengado'
		]),remoteSort:true});

	//carga datos XML
	
	// DEFINICIï¿½N DATOS DEL MAESTRO


	
	//DATA STORE COMBOS

 
	
		var ds_depto_tesoro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?tesoro=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto'])
		});
		
		function render_id_depto_tesoro(value, p, record){return String.format('{0}', record.data['depto_tesoro']);}
		var tpl_id_depto_tesoro=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto} </b></i>,<br><FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');
		
		
		var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','desc_plantilla'])});
        function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_documento']);}
		var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','</div>');

			
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_cotizacion
	//en la posiciï¿½n 0 siempre esta la llave primaria
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
	
	 Atributos[2]={//==> se usa//30
			validacion: {
			name:'tipo_pago',
			fieldLabel:'Tipo de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['devengado','Cheque'],['transferencia','Transferencia Bancaria']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:80,
			grid_indice:8,
			width:180,
			disabled:false,
			renderer:tipo_pago
		},
		tipo:'ComboBox',
		form: true,
		defecto:'devengado',
		save_as:'tipo_pago',
		id_grupo:1
	};
	
	
	Atributos[3]={//9
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
		id_grupo:1
	};	
	
	
	Atributos[4]={//31
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
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
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
			id_grupo:1
		};
	
	Atributos[5]={//==> SI
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
			width:'90%',
			disabled:true,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_15.apellido_paterno#PERSON_15.apellido_materno#PERSON_15.nombre#INSTIT.nombre',
		save_as:'id_proveedor',
		id_grupo:2  //1
	};
	
	// txt fecha_validez_oferta ==> se usa
	Atributos[6]= {
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
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:3
	};
	
	
	Atributos[7]={//==> SI
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
			width:'100%',
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
	Atributos[8]={
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
		id_grupo:3
	};


   

	// txt lugar_entrega ==> se usa
	Atributos[9]={//14
		validacion:{
			name:'lugar_entrega',
			fieldLabel:'Lugar de Entrega',
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
			grid_indice:14
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		
		filterColValue:'COTIZA.lugar_entrega',
		save_as:'lugar_entrega',
		id_grupo:3  //1
		
	};
	
	
// txt estado_vigente
	Atributos[10]={//==>SI//16
		validacion:{
			name:'estado_vigente',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:2	
		},
		tipo: 'TextField',
		form: false
	};


	
	Atributos[11]={//18
		validacion:{
			name:'desc_proveedor',
			fieldLabel:'Nombre Pago',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:85,
			width:'90%',
			disabled:false,
			grid_indice:17		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'nombre_pago',
		save_as:'nombre_pago',
		id_grupo:2
	};
	
	Atributos[12]={//26
		validacion:{
			name:'numeracion_oc',
			fieldLabel:'Orden Compra',
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			align:'right',
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: false
	};
	Atributos[13]={//27
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
		id_grupo:3
	};
	// txt observaciones
	Atributos[14]={//==>SI//29
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
		id_grupo:3  //1
	};

// txt forma_pago ==se usa
	
	
	//todo_pagado==> permitirï¿½ finalizar el plan de pagos
	Atributos[15]={//32
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
	
	
	Atributos[16]={//33
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
	
		
	Atributos[17]={//35
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Periodo/No Cot.',
			grid_visible:true,
			grid_editable:false,
			width_grid:85,
			align:'right',
			grid_indice:2
		},
		tipo: 'TextField',
		form:false
	};
	
	Atributos[18]={//==> SI//42
		validacion:{
			name:'por_adelanto',
			fieldLabel:'% Adelanto',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:9,//para numeros float
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
	
	
	Atributos[19]={//==> SI//42
		validacion:{
			name:'por_retgar',
			fieldLabel:'% Retención por Garantia',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
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
	
	Atributos[20]={//==> SI//42
		validacion:{
			name:'monto_adelanto_moneda_cotizada',
			fieldLabel:'Monto de Adelanto',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
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
			grid_indice:18
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		id_grupo:4  //1
	};
	
	
	Atributos[21]={//40
			validacion:{
				name:'estado_adelanto',
				fieldLabel:'Estado Adelanto',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
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
		
		
		
		Atributos[22]={//40
			validacion:{
				name:'estado_retgar',
				fieldLabel:'Estado RetGar',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
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
		
	Atributos[23]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'factura_total',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	Atributos[24]={//==> se usa//30
			validacion: {
			name:'con_contrato',
			fieldLabel:'Contrato',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:80,
			grid_indice:8,
			width:150,
			disabled:false

		},
		tipo:'ComboBox',
		form: true,
		defecto:'no',
		save_as:'con_contrato',
		id_grupo:5
	};
	
	Atributos[25]= {
		validacion:{
			name:'nro_contrato',
			fieldLabel:'Nº contrato',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'70%',
			disabled:false,
			grid_indice:6
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		id_grupo:5
	};
	
		
	Atributos[26]= {//39
		validacion:{
			name:'fecha_ini_ctto',
			fieldLabel:'Inicio Servicio',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:97,
			disabled:false,
			width:163
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_ini_ctto',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_ini_ctto',
		id_grupo:5
	};
	
	
	Atributos[27]= {//39
		validacion:{
			name:'fecha_fin_ctto',
			fieldLabel:'Fin Servicio',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:97,
			disabled:false,
			width:163
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_fin_ctto',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_fin_ctto',
		id_grupo:5
	};

	Atributos[28]= {//39
		validacion:{
			name:'plan_pago',
			fieldLabel:'Pago Variable',
			allowBlank:false,
			grid_visible:false,
			disabled:true,
			width:120
		},
		form:true,
		tipo:'Field',
		id_grupo:6
	};
	
	Atributos[29]= {//39
		validacion:{
			name:'importe_devengar',
			fieldLabel:'Importe a Devengar',
			allowBlank:false,
			grid_visible:false,
			disabled:true,
			width:120
		},
		form:true,
		tipo:'Field',
		id_grupo:6
	};
	
	Atributos[30]= {//39
		validacion:{
			name:'gestion',
			fieldLabel:'Gestion Devengado',
			allowBlank:false,
			grid_visible:false,
			disabled:true,
			width:120
		},
		form:true,
		tipo:'Field',
		id_grupo:6
	};
	
	Atributos[31]= {//39
		validacion:{
			name:'moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			grid_visible:false,
			disabled:true,
			width:120
		},
		form:true,
		tipo:'Field',
		id_grupo:6
	};
	
	
	
	Atributos[32]= {//39
		validacion:{
			name:'fecha_devengado',
			fieldLabel:'Fecha de devengado',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			disabled:false,
			width:163
		},
		form:true,
		tipo:'DateField',
		dateFormat:'m-d-Y',
		id_grupo:6
	};
	
	Atributos[33]={//==>SI//29
		validacion:{
			name:'observaciones_devengado',
			fieldLabel:'Observaciones Devengado',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:6  //1
	};
	
	Atributos[34]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_gestion'
	};
	
	var fCol=new Array();
		var fVal=new Array();
		fCol[0]='PLANT.sw_compro';
		fVal[0]='1';




		Atributos[35]={
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
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_tipo_plantilla,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				//width:'30%',
				grid_indice:13
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PLANTI.desc_plantilla',
			id_grupo:7
		};
		
		Atributos[36]={//==> SI//36
		validacion:{
			name:'num_factura',
			fieldLabel:'Nº Factura',
			allowBlank:false,
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
			width:'80%',
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.num_factura',
		save_as:'num_factura',
		id_grupo:7  //1
	};
	
	Atributos[37]= {//39
		validacion:{
			name:'fecha_orden_compra',
			fieldLabel:'Fecha Orden Compra',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:97,
			disabled:false,
			grid_indice:16,
			width:163
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_orden_compra',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_orden_compra',
		id_grupo:3
	};
	
	Atributos[38]={
			validacion:{
				name:'justificacion_adjudicacion',
				fieldLabel:'Justificación Orden Compra',
				allowBlank:false,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:14
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			
			save_as:'justificacion_adjudicacion',
			id_grupo:3 //1
		};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
			
	function tipo_pago(val,cell,record,row,colum,store){
					  
					if(val=='devengado')
					   return 'Cheque';
					else
					   return 'Transferencia Bancaria';	
					    
					
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Orden de Compra',grid_maestro:'grid-'+idContenedor, urlHijo:'../../../sis_adquisiciones/vista/plan_pago/plan_pago_tasa.php'};
	
	var layout_orden_compra_det= new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout_orden_compra_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_orden_compra_det,idContenedor);
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
	var CM_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	
	
//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
	
	actualizar:{crear:true,separador:false}};
//DEFINICIï¿½N DE FUNCIONES
	
	var paramFunciones={
	Save:{url:direccion+'../../../control/cotizacion/ActionGuardarCotizacionOrdenCompra.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
	
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:370,width:680,minWidth:450,minHeight:230,	closable:true,titulo:'Orden compra',columnas:['47%','47%'],
	grupos:[{
			tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
		},{
			tituloGrupo:'Definición de Pago',
			columna:0,
			id_grupo:1
		},
		{
			tituloGrupo:'Proveedor',
			columna:0,
			id_grupo:2
		},
		{
			tituloGrupo:'Orden de Compra',
			columna:1,
			id_grupo:3
		},{
			tituloGrupo:'Retenciones',
			columna:1,
			id_grupo:4
		},{
			tituloGrupo:'Contrato',
			columna:0,
			id_grupo:5
		},{
			tituloGrupo:'Datos Devengado',
			columna:1,
			id_grupo:6
		},{
			tituloGrupo:'Factura',
			columna:0,
			id_grupo:7
		}
		
	]}};
	
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
		maestro.avance=datos.m_avance;
		

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_proceso_compra:maestro.id_proceso_compra,
				adjudicacion:'si'
			}
		};
		
		_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.limpiarStore()
		this.btnActualizar();
		
		iniciarEventosFormularios();

		
		Atributos[1].defecto=maestro.id_proceso_compra;		
		
		paramFunciones.Save.parametros='&m_id_proceso_compra='+maestro.id_proceso_compra
		this.iniciarEventosFormularios;
		this.InitFunciones(paramFunciones);
		
	};
	
	function btn_det_eje()
	{
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0)
				{
					var SelectionsRecord=sm.getSelected();
					var data='id='+SelectionsRecord.data.id_cotizacion;
					data=data+'&vista=devengado_fin';
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
					layout_orden_compra_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_ejecucion/detalle_ejecucion_dev_fin.php?'+data,'Detalle Ejecucion',ParamVentana);
						
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
				}
	}
	
	
	
	
	
function btn_orden_compra(){
	
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0){
			CM_getFormulario().url=direccion+'../../../control/cotizacion/ActionGuardarCotizacionOrdenCompra.php';
			if(parseFloat(SelectionsRecord.data.id_auxiliar)>0){
					ds_depto_tesoro.baseParams={
						estado:2,id_cotizacion:SelectionsRecord.data.id_cotizacion
					}
					
					
					//FER-MOD-AD-07 (23/04/2010)
					getComponente('fecha_orden_compra').setValue('01/01/'+SelectionsRecord.data.gestion);
					getComponente('fecha_orden_compra').minValue=getComponente('fecha_orden_compra').getValue();
					getComponente('fecha_orden_compra').setValue(new Date());
					getComponente('fecha_orden_compra').maxValue=getComponente('fecha_orden_compra').getValue();
					if(SelectionsRecord.data.fecha_orden_compra !=null || SelectionsRecord.data.fecha_orden_compra !=undefined){
						getComponente('fecha_orden_compra').setValue(SelectionsRecord.data.fecha_orden_compra);
					}else{
						getComponente('fecha_orden_compra').setValue('');
					}
					getComponente('fecha_orden_compra').allowBlank=false;
					
					cambiar_tipo('orden_compra');
					getComponente('id_depto_tesoro').modificado=true;
					getComponente('factura_total').setValue('no');
					CM_btnEdit();
    				var dialog=CM_dialog();
    				dialog.buttons[0].setText('Guardar Datos');
    				dialog.buttons[0].enable();
    			
    			
			}else{
			    Ext.MessageBox.alert('Estado','El proveedor necesita tener una cuenta-auxiliar asociada para que se emita la Orden de Compra correspondiente');
			}
		}else{
		  Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	    }
	this.btnActualizar;
}

function btn_devengar(){
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{				
				Ext.Ajax.request({
					url:direccion+"../../../control/cotizacion/ActionVerificarDevengado.php",
					success:cargar_respuesta,
					params:{'id_cotizacion':sm.getSelected().data.id_cotizacion},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un Vale.')
		}		
		
		
	}
	
	function cargar_respuesta(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			var mensaje='¿Está seguro de comprometer el importe de la rendición del recibo?';
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='-1')
			{
				Ext.MessageBox.alert('Estado',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue)
			}
			else 
			{
				//aqui se define el control al que se llamara
				CM_getFormulario().url=direccion+'../../../control/plan_pago/ActionRegistrarDevengado.php';
				cambiar_tipo('devengar_cotizacion');
				componentes[29].setValue(root.getElementsByTagName('importe')[0].firstChild.nodeValue);
				componentes[30].setValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
				componentes[31].setValue(root.getElementsByTagName('moneda')[0].firstChild.nodeValue);
				componentes[28].setValue(root.getElementsByTagName('tipo')[0].firstChild.nodeValue);
				componentes[34].setValue(root.getElementsByTagName('id_gestion')[0].firstChild.nodeValue);
				CM_btnEdit();
    			var dialog=CM_dialog();
    			dialog.buttons[0].setText('Devengar Saldo');
    			dialog.buttons[0].enable();				
			}						
		}
	}
	
	function cambiar_tipo(tipo){
		
		if(tipo=='orden_compra'){
			
			SiBlancosTodos();
			NoBlancosGrupo(1);
			NoBlancosGrupo(2);
			NoBlancosGrupo(3);
			NoBlancosGrupo(4);
			NoBlancosGrupo(5);
						
			CM_mostrarGrupo('Retenciones');
			CM_mostrarGrupo('Definición de Pago');
			CM_mostrarGrupo('Proveedor');
			CM_mostrarGrupo('Orden de Compra');
			CM_mostrarGrupo('Contrato');
			CM_ocultarGrupo('Datos Devengado');
			CM_ocultarGrupo('Factura');
		}
		else if(tipo=='devengar_cotizacion')
		{
			
			SiBlancosTodos();
			NoBlancosGrupo(6);
			NoBlancosGrupo(7);
						
			CM_mostrarGrupo('Factura');
			CM_ocultarGrupo('Retenciones');
			CM_ocultarGrupo('Definición de Pago');
			CM_ocultarGrupo('Proveedor');
			CM_ocultarGrupo('Orden de Compra');
			CM_mostrarGrupo('Datos Devengado');
			CM_ocultarGrupo('Contrato');
					
		}
				
	}


function btn_adelanto(){
				
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
					if(NumSelect!=0){
							var data1='cantidad_ids=1'+'&id_cotizacion='+SelectionsRecord.data.id_cotizacion+'&m_id_proceso_compra='+maestro.id_proceso_compra;
							Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionPagarAdelanto.php",
							params:data1,
							method:'POST',
							failure:CM_conexionFailure,
							success:revertido,
							timeout:100000000});


					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
			}
	



			
	function btn_almacenes(){
	
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
            var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
           
			window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFIngresos1.php?'+data)	
				//validar que antes de poder ingresar a Plan de PAgos, se deba realizar el registro de ingreso de material
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
		}
	}	
			
			
				
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name);
			
		}
		CM_ocultarGrupo('Oculto');
		getComponente('observaciones').setValue('');
	 	getSelectionModel().on('rowdeselect',function(){
						if(_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.limpiarStore()){
							if(bloquear=='si'){
							   _CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.bloquearMenu();
							}else{
								_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.desbloquearMenu();
							}
						}
					})

		var onPorAdelanto=function(e,n,o){ 
			if(n>100){
				alert('El porcentaje de anticipo no puede ser mayor a 100');
				getComponente('monto_adelanto_moneda_cotizada').setValue(o);
			}else{
				getComponente('monto_adelanto_moneda_cotizada').setValue(getComponente('precio_total_adjudicado_con_impuestos').getValue()*n/100);
			}
		}
		
		var onAdelanto=function(e,n,o){
			if(n>getComponente('precio_total_adjudicado_con_impuestos').getValue()){
				alert('El monto del anticipo no puede superar el total adjudicado');
				getComponente('por_adelanto').setValue(0);
			}else{
				getComponente('por_adelanto').setValue(n*100/getComponente('precio_total_adjudicado_con_impuestos').getValue());
			}
		}
	
		getComponente('por_adelanto').on('change',onPorAdelanto);
		getComponente('monto_adelanto_moneda_cotizada').on('change',onAdelanto);	
	}
	
	function SiBlancosTodos(){
		for (var i=0;i<componentes.length;i++){
			if (Atributos[i].form!=false){
				componentes[i].allowBlank=true;
			}
			
		}
	}
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	function resetGrupo(grupo)
	{
			for (var i=0;i<componentes.length;i++){
				if(Atributos[i].id_grupo==grupo)
					componentes[i].reset();
			}		
	}
	
	this.EnableSelect=function(x,z,y){
		_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.reload(y.data);
		//_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.desbloquearMenu();
		enable(x,z,y);
	}
	
	
	
	
			
	function btn_revertir(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		this.btnActualizar;
		
		if(NumSelect!=0){
		    if(confirm('Está seguro de revertir la Adjudicaciónn?')){
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
	
	
		function btn_orden_compra_rep(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect>0){
		    var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
			pagina=direccion+'../../../control/cotizacion/reporte/ActionPDFOrdenCompra.php?'+data;
			window.open(pagina);
		}else{
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
	
	
	function btn_fin_serv(){
				
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
					if(NumSelect!=0){ //alert(SelectionsRecord.data.todo_pagado+"----"+SelectionsRecord.data.precio_total_adjudicado_con_impuestos);
//						if(SelectionsRecord.data.id_cotizacion=3715){
//							alert(SelectionsRecord.data.todo_pagado+"----"+SelectionsRecord.data.precio_total_adjudicado_con_impuestos);
//						}
						 if(parseFloat(SelectionsRecord.data.todo_pagado)>0){
							
									var data1='cantidad_ids=1'+'&id_cotizacion='+SelectionsRecord.data.id_cotizacion+'&fin=1';
									Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionTerminarCotizacion.php",
									params:data1,
									method:'POST',
									failure:CM_conexionFailure,
									success:revertido,
									timeout:100000000});		
								
							}else{
								alert("Aún no se pagó nada, puede emplear otra via de finalizacion");
							}
							


					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
	}
	
	function btn_anticipo(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect>0){
		  var data='id_cotizacion_rep_anticipo='+SelectionsRecord.data.id_cotizacion;
			pagina=direccion+'../../../control/cotizacion/reporte/ActionPDFAnticipo.php?'+data;
			window.open(pagina);
			}else
		{
		    Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	    }
	}
	
	
	/*nov2014*/
	function btn_reporte_cotizacion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
			var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
			window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFCotizacion_x_Proveedor.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_orden_compra_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	    
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Invitación Directa',btn_reporte_cotizacion,true,'reporte_cotizacion','I.Directa');
	    this.AdicionarBoton('../../../lib/imagenes/print.gif','Nota Adjudicación',btn_resolucion_adjudicacion,true,'resolucion_adjudicacion','Adjudicación');	
	    this.AdicionarBoton('../../../lib/imagenes/detalle.png','Datos Compra',btn_orden_compra,true,'orden_compra','Datos Compra');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Rep Orden Compra',btn_orden_compra_rep,true,'orden_compra_rep','OC');
	    this.AdicionarBoton('../../../lib/imagenes/volver.png','Revertir OC',btn_revertir,true,'revertir','Rev. Adjudicación');
	    this.AdicionarBoton('../../../lib/imagenes/book_next.png','Pagar Adelanto',btn_adelanto,true,'adelanto','Pagar Adelanto');
	    this.AdicionarBoton('../../../lib/imagenes/a_table.png','Devengar',btn_devengar,true,'devengar','Devengar Saldo');
	    this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Ejecución',btn_det_eje,true,'det_eje','Detalle Ejecución');
	    this.AdicionarBoton('../../../lib/imagenes/book_next.png','Fin Cotización',btn_fin_serv,true,'fin_serv','Finalizar Cotización');
     	this.AdicionarBoton('../../../lib/imagenes/print.gif','Anticipo',btn_anticipo,true,'anticipo','Sol.Anticipo');
			
		var CM_getBoton=this.getBoton;
		CM_getBoton('orden_compra-'+idContenedor).enable();
		//CM_getBoton('orden_compra_rep-'+idContenedor).disable();
		CM_getBoton('revertir-'+idContenedor).enable();
		CM_getBoton('det_eje-'+idContenedor).enable();
		
		function  enable(sel,row,selected){
		    var record=selected.data;
		    if(selected&&record!=-1){
				CM_getBoton('adelanto-'+idContenedor).enable();					
				
			    CM_getBoton('revertir-'+idContenedor).enable();
			    CM_getBoton('devengar-'+idContenedor).enable();	
			    CM_getBoton('anticipo-'+idContenedor).disable();
			    	
			    if((record.estado_vigente=='en_pago')){
			    	CM_getBoton('adelanto-'+idContenedor).disable();
					bloquear='no';
					CM_getBoton('orden_compra-'+idContenedor).disable();
					CM_getBoton('revertir-'+idContenedor).disable();
			    }
			    else{
			    	if(record.estado_vigente=='orden_compra'){
			    		if(parseFloat(record.por_adelanto)>0 || parseFloat(record.monto_adelanto)>0){
			    			CM_getBoton('anticipo-'+idContenedor).enable();
						 
			    			CM_getBoton('adelanto-'+idContenedor).enable();	
			    			if(record.estado_adelanto=='pendiente'){
			    				CM_getBoton('adelanto-'+idContenedor).enable();	
			    				bloquear='si';
			    			}else{
			    				CM_getBoton('adelanto-'+idContenedor).disable();
			    				
			    				bloquear='no';
			    			}
			    		}else{
			    			CM_getBoton('adelanto-'+idContenedor).disable();	
			    			CM_getBoton('anticipo-'+idContenedor).disable();
			    			bloquear='no';
			    		}
			    	}
			    	else{
			    		CM_getBoton('adelanto-'+idContenedor).disable();
			    		bloquear='si';
			    		CM_getBoton('devengar-'+idContenedor).disable();
			    	}
			    	CM_getBoton('orden_compra-'+idContenedor).enable();
					CM_getBoton('revertir-'+idContenedor).enable();	
			    	
			    }
			    if(record.estado_devengado=='pendiente'){
			    	bloquear='si';
			    }
			    
			    if(bloquear=='si')
						_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.bloquearMenu();
				else		
						_CP.getPagina(layout_orden_compra_det.getIdContentHijo()).pagina.desbloquearMenu();
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
			m_id_proceso_compra:maestro.id_proceso_compra,
			adjudicacion:'si'
		}
	});
	layout_orden_compra_det.getLayout().addListener('layout',this.onResize);
	layout_orden_compra_det.getVentana().addListener('beforehide',salta);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}