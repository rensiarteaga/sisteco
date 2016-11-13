/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		2008-05-28 17:32:15
*/


function pagina_plan_pago_tasa(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg;
	var cantidad=0;
	var adj=0;
	var bandera=false;
	var  num_pago=0, maestro;
	var retencion_original;

	
	var cant_pagosI;
	var id_cotizacionI;
	var txt_precio,txt_falta_pagar,	txt_num_pagos,txt_fecha_pago,txt_fecha_pagado,txt_tipo_pago,txt_gestion,txt_tipo_plantilla,txt_monto_original;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plan_pago/ActionListarPlanPago.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_plan_pago',totalRecords:'TotalCount'
		},[
		'id_plan_pago',
		'tipo_pago',
		'nro_cuota',
		{name: 'fecha_pago',type:'date',dateFormat:'Y-m-d'},
		'monto',
		'estado',
		'desc_cotizacion',
		'id_cotizacion','precio_total','monto_a_pagar','cuota_a_pagar','pagado','falta_pagar', 'num_pagos',{name: 'fecha_pagado',type:'date',dateFormat:'Y-m-d'},'estado_vigente','num_factura','observaciones',
		'boleta_garantia','num_autoriza_factura','cod_control_factura','id_gestion','gestion','obs_conta',
		{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},'multas', 'cantidad_entregada','tipo_adq','pago_simplificado','impuestos','monto_original','retencion_bien','tipo_plantilla','desc_plantilla','id_avance','avance','por_anticipo','por_retgar','retencion'

		]),remoteSort:true});

		var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','desc_plantilla'])});

		var ds_avance = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/avance/ActionListarSolicitudFondos.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_avance',totalRecords: 'TotalCount'},['id_avance','nro_avance','concepto_avance','desc_empleado'])});

		//FUNCIONES RENDER


		var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])});

		function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');

		function render_avance(value, p, record){return String.format('{0}', record.data['avance']);}
		var tpl_id_avance=new Ext.Template('<div class="search-item">',
		'<span>{nro_avance}  </span></br>','<tt> Concepto:{concepto_avance}</tt> ','Solicitante:{desc_empleado}<br/>',
		'</div>');


		function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
		var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','</div>');


		///////////////////////
		// Definiciï¿½n de datos //
		/////////////////////////

		// hidden id_cotizacion_det
		//en la posiciï¿½n 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_plan_pago',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_plan_pago'
		};
		// txt tipo_pago
		Atributos[1]={
			validacion:{
				name:'tipo_pago',
				fieldLabel:'Tipo de Pago',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:Ext.plan_pago_combo.tipo_pago
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			form:false,
			defecto:'normal',
			filterColValue:'plapag.tipo_pago',
			save_as:'tipo_pago',
			id_grupo:1
		};

		// txt nro_cuota
		Atributos[2]={
			validacion:{
				name:'nro_cuota',
				fieldLabel:'Cuota',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:45,
				width:'60%',
				disabled:true,
				grid_indice:1
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'plapag.nro_cuota',
			save_as:'nro_cuota',
			id_grupo:1
		};


		Atributos[3]={
			validacion:{
				name:'monto_original',
				fieldLabel:'Monto',
				allowBlank:false,
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
				width_grid:55,
				width:'60%',
				disabled:false,
				grid_indice:2
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'plapag.monto_original',
			save_as:'monto_original',
			id_grupo:1
		};


		Atributos[4]={
			validacion:{
				name:'retencion_bien',
				fieldLabel:'Retención',
				allowBlank:false,
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
				width_grid:55,
				width:'60%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			save_as:'retencion_bien',
			id_grupo:1
		};


		// txt monto
		Atributos[5]={
			validacion:{
				name:'monto',
				fieldLabel:'Liquido Pagable',
				allowBlank:false,
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
				width_grid:55,
				width:'60%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'plapag.monto',
			id_grupo:1
		};
		// txt fecha_pago
		Atributos[6]= {
			validacion:{
				name:'fecha_pago',
				fieldLabel:'Fecha Tentativa de Pago',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Dï¿½a no vï¿½lido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				width:'60%',
				disabled:false,
				grid_indice:4
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'plapag.fecha_pago',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_pago',
			id_grupo:1
		};

		// txt estado
		Atributos[7]={
			validacion: {
				name:'estado',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:65, // ancho de columna en el gris
				disabled:false,
				width:'60%',
				grid_indice:3
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			defecto:'pendiente',
			filterColValue:'plapag.estado',
			save_as:'estado',
			id_grupo:1
		};

		// txt id_cotizacion
		Atributos[8]={
			validacion:{
				labelSeparator:'',
				name: 'id_cotizacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cotizacion',

			id_grupo:1
		};

		// txtprecio_total
		Atributos[9]={
			validacion:{
				name:'precio_total',
				fieldLabel:'Precio Total',
				allowBlank:false,
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
				width_grid:80,
				width:'60%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',

			filtro_0:true,
			filterColValue:'cotiza.precio_total',
			save_as:'precio_total',
			id_grupo:5
		};


		Atributos[10]={
			validacion:{
				name:'pagado',
				fieldLabel:'Pagado',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'60%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',
			filtro_0:false,
			id_grupo:5

		};


		Atributos[11]={
			validacion:{
				name:'falta_pagar',
				fieldLabel:'Falta Pagar',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'60%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',
			filtro_0:false,
			id_grupo:5
		};

		Atributos[12]={
			validacion:{
				name:'num_pagos',
				fieldLabel:'Nï¿½ Pagos',
				allowBlank:false,
				maxLength:18,
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
				width:'60%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};


		Atributos[13]={
			validacion:{
				name:'cuota_a_pagar',
				fieldLabel:'Cuota a pagar',
				allowBlank:false,
				maxLength:18,
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
				width:'60%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',
			filtro_0:false,
			id_grupo:0
		};

		Atributos[14]= {
			validacion:{
				name:'fecha_pagado',
				fieldLabel:'Fecha de Pago',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false,
				width:'60%',
				grid_indice:6
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'plapag.fecha_pagado',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_pagado',
			id_grupo:2
		};

		Atributos[15]={
			validacion:{
				name:'num_pago',
				fieldLabel:'Nº Pago',
				allowBlank:false,
				maxLength:18,
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
				width:'45%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'NumberField',
			filtro_0:false,
			id_grupo:0
		};


		Atributos[16]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Cotizacion',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'45%',
				disable:false,
				grid_indice:3
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			id_grupo:0
		};

	


		var fCol=new Array();
		var fVal=new Array();
		fCol[0]='PLANT.sw_compro';
		fVal[0]='1';




		Atributos[17]={
			validacion:{
				name:'tipo_plantilla',
				fieldLabel:'Tipo Documento',
				allowBlank:false,
				emptyText:'Documento...',
				desc: 'desc_plantilla',
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
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_tipo_plantilla,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				grid_indice:13
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PLANPA.tipo_plantilla',
			id_grupo:3
		};


		Atributos[18]={
			validacion:{
				name:'num_factura',
				fieldLabel:'Nº Documento',
				allowBlank:true,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:85,
				width:'60%',
				disabled:false,
				grid_indice:7
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'plapag.num_factura',
			save_as:'num_factura',
			id_grupo:3
		};


		Atributos[19]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:50000,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false,
				grid_indice:11
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			id_grupo:2
		};

		Atributos[20]={
			validacion:{
				name:'boleta_garantia',
				fieldLabel:'Boleta de Garantia',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:105,
				width:'100%',
				disable:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			id_grupo:4
		};

		Atributos[21]={
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
				grid_editable:false,
				width_grid:110,
				width:'60%',
				disabled:false,
				grid_indice:8
			},
			tipo: 'NumberField',
			form: true,
			save_as:'num_autoriza_factura',
			filtro_0:false,
			id_grupo:0
		};

		Atributos[22]={//==> SI
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
				grid_editable:false,
				width_grid:110,
				width:'60%',
				disabled:false,
				grid_indice:9
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			save_as:'cod_control_factura',
			id_grupo:0 //1
		};


		Atributos[23]= {
			validacion:{
				name:'fecha_factura',
				fieldLabel:'Fecha Documento',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Dï¿½a no vï¿½lido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:97,
				disabled:false,
				grid_indice:10
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

		Atributos[24]={
			validacion:{
				name:'multas',
				fieldLabel:'Multas',
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
				width_grid:55,
				width:'30%',
				disabled:true,
				grid_indice:11
			},
			tipo: 'NumberField',
			form: true,
			defecto:0,
			filtro_0:false,
			filterColValue:'plapag.multas',
			save_as:'multas',
			id_grupo:1
		};


		Atributos[25]={
			validacion:{
				labelSeparator:'',
				name: 'pago_simplificado',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:0,
			save_as:'pago_simplificado'
		};

		Atributos[26]={
			validacion:{
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:0,
			save_as:'id_proceso_compra'
		};

		Atributos[27]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestión',
				allowBlank:false,
				emptyText:'Gestión...',
				desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField: 'id_gestion',
				displayField: 'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:true,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_gestion',
			id_grupo:1
		};

		Atributos[28]={
			validacion:{
				name:'obs_conta',
				label: 'Observaciones Contabilidad',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'plapag.obs_conta',
			form:false,
			save_as:'obs_conta'
		};
				
		Atributos[29]={
			validacion:{
				name:'id_avance',
				fieldLabel:'Fondo en Avance',
				allowBlank:false,
				emptyText:'Fondo...',
				desc: 'avance', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_avance,
				valueField: 'id_avance',
				displayField: 'concepto_avance',
				queryParam: 'filterValue_0',
				filterCol:'AVANCE.concepto_avance,AVANCE.nro_avance',
				typeAhead:true,
				tpl:tpl_id_avance,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_avance,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'50%',
				disabled:false,
				grid_indice:6
			},
			tipo:'ComboBox',
			form: true,
			save_as:'id_avance',
			id_grupo:6
		};
		
		Atributos[30]={
			validacion:{
				name:'por_anticipo',
				fieldLabel: '% Anticipo',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'plapag.por_anticipo',
			form:true,
			save_as:'por_anticipo',
			id_grupo:2
			
		};

		
		Atributos[31]={
			validacion:{
				name:'por_retgar',
				fieldLabel: '% Garantia',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'plapag.por_retgar',
			form:true,
			save_as:'por_retgar',
			id_grupo:2
		};


		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Detalle - Orden de Compra',grid_maestro:'grid-'+idContenedor};
		var layout_plan_pago= new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_plan_pago.init(config);

		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_plan_pago,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var CM_btnEliminar=this.btnEliminar;
		var CM_saveSuccess=this.saveSuccess;
		var getDialog=this.getDialog;
		var EstehtmlMaestro=this.htmlMaestro;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		//DEFINICIï¿½N DE LA BARRA DE MENï¿½
		var paramMenu={
			nuevo:{crear:true,separador:true},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		//DEFINICIï¿½N DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/plan_pago/ActionEliminarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[8]},
			Save:{url:direccion+'../../../control/plan_pago/ActionGuardarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[8], success:miSuccess},
			ConfirmSave:{url:direccion+'../../../control/plan_pago/ActionGuardarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[8]},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:450,width:780,minWidth:'25%',minHeight:222,columnas:['47%','47%'],	closable:true,titulo:'Detalle de Pagos',
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos de Pago',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Pagos',
				columna:1,
				id_grupo:2
			},{
				tituloGrupo:'Datos Factura',
				columna:1,
				id_grupo:3
			},{
				tituloGrupo:'Datos Boleta de Garantia',
				columna:1,
				id_grupo:4
			},
			{
				tituloGrupo:'Total a Pagar',
				columna:1,
				id_grupo:5
			},
			{
				tituloGrupo:'Fondos en Avance',
				columna:1,
				id_grupo:6
			}]}
		};


		//-------------- Sobrecarga de funciones --------------------//
		this.reload=function(m){
			maestro=m;
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_cotizacion:maestro.id_cotizacion
				}
			};
			this.btnActualizar();
			id_cotizacionI=maestro.id_cotizacion;
			Atributos[26].defecto=maestro.id_proceso_compra;
			Atributos[8].defecto=maestro.id_cotizacion;
			Atributos[17].defecto=maestro.tipo_documento;
			Atributos[18].defecto=maestro.num_factura;
			ds_gestion.baseParams={
				tipo_vista:'plan_pago',
				sgte_gestion:maestro.habilita_otra_gestion
			}
			paramFunciones.btnEliminar.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
			paramFunciones.Save.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
			paramFunciones.ConfirmSave.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
			//iniciarEventosFormularios();
			this.iniciarEventosFormularios;
			this.InitFunciones(paramFunciones)
		};

		//Para manejo de eventos
		function iniciarEventosFormularios(){

			//para iniciar eventos en el formulario
			var txt_monto=getComponente('monto');

			txt_precio=getComponente('precio_total');
			txt_falta_pagar=getComponente('falta_pagar');
			txt_num_pagos=getComponente('num_pagos');
			txt_fecha_pago=getComponente('fecha_pago');
			txt_fecha_pagado=getComponente('fecha_pagado');
			txt_tipo_pago=getComponente('tipo_pago');
			txt_gestion=getComponente('id_gestion');
			txt_tipo_plantilla=getComponente('tipo_plantilla');
			txt_monto_original=getComponente('monto_original');


			//rac: comentamos momentanemamente esta funcion y su llamada


			var calcularRetencion=function(x){
				
				Ext.Ajax.request({
					url:direccion+"../../../../sis_contabilidad/control/plantilla/ActionCalculaSujetoLiquido.php",
					params:{ "importe":txt_monto_original.getValue(),
					         "tipo_documento":x.getValue(),
					         "sw_sujeto_liquido":2},
					method:'GET',
					success:calcularRetencionSuccess,
					failure:Cm_conexionFailure,
					timeout:100000000
				})
			}

			var calcularRetencionSuccess=function(resp){

			
				var regreso = Ext.util.JSON.decode(resp.responseText)
		        var retencion = getComponente('monto_original').getValue() - regreso.importe;
				getComponente('retencion_bien').setValue(retencion);
				getComponente('monto').setValue(regreso.importe);
			}




			//txt_monto_original.on('change',verificarMonto);
			//txt_monto.on('change',verificarMonto);



			txt_tipo_plantilla.on('change',calcularRetencion);
			

			gridG=getGrid();


			var onTipoPago=function(e){
				if(maestro.factura_total=='no'){
					if(e.value=='normal'){
						CM_ocultarGrupo('Datos Boleta de Garantia');
						CM_mostrarGrupo('Datos Factura');
						getComponente('num_factura').allowBlank=false;
						getComponente('num_autoriza_factura').allowBlank=true;
						getComponente('fecha_factura').allowBlank=false;
						getComponente('boleta_garantia').allowBlank=true;

						getComponente('boleta_garantia').clearInvalid();
					}else{
						CM_mostrarGrupo('Datos Boleta de Garantia');
						CM_ocultarGrupo('Datos Factura');
						getComponente('num_factura').allowBlank=true;
						getComponente('num_autoriza_factura').allowBlank=true;
						getComponente('fecha_factura').allowBlank=true;
						getComponente('boleta_garantia').allowBlank=false;

						getComponente('fecha_factura').clearInvalid();
						getComponente('num_factura').clearInvalid();
						getComponente('num_autoriza_factura').clearInvalid();

					}
				}else{
					CM_ocultarGrupo('Datos Factura');
					CM_ocultarGrupo('Datos Boleta de Garantia');
					getComponente('fecha_factura').clearInvalid();
					getComponente('num_factura').clearInvalid();
					getComponente('num_autoriza_factura').clearInvalid();
					getComponente('boleta_garantia').clearInvalid();
				}
			}
			//txt_tipo_pago.on('select',onTipoPago);
			//txt_tipo_pago.on('change',onTipoPago);


		}



		this.btnNew=function(){
			if(maestro.estado_adelanto=='pagado'||maestro.estado_adelanto=='no'){	
				CM_btnNew();
	
				CM_ocultarGrupo('Oculto');
	
				CM_mostrarGrupo('Datos de Pago');
				CM_mostrarGrupo('Total a Pagar');
				CM_ocultarGrupo('Pagos');
				CM_ocultarGrupo('Datos Boleta de Garantia');
				CM_ocultarGrupo('Datos Factura');
				CM_ocultarGrupo('Fondos en Avance');
	
				getComponente('num_factura').allowBlank=true;
				getComponente('id_avance').allowBlank=true;
				getComponente('por_anticipo').allowBlank=true;
				getComponente('por_retgar').allowBlank=true;
	
				getComponente('observaciones').allowBlank=true;
	
				txt_tipo_plantilla.disable();
	
				getComponente('estado').disable();
	
				CM_ocultarComponente(getComponente('fecha_pagado'));
				CM_ocultarComponente(getComponente('por_retgar'));
				CM_ocultarComponente(getComponente('por_anticipo'));
	
				getComponente('fecha_pagado').allowBlank=true;
	
				getComponente('fecha_pago').allowBlank=false;
				getComponente('fecha_pago').enable();
	
				
				getComponente('num_autoriza_factura').allowBlank=true;
				getComponente('fecha_factura').allowBlank=true;
				getComponente('id_gestion').enable();
				
				//RAC:para ver desbloque ar el boton en cada new
				txt_monto_original.enable();
				
				CM_ocultarComponente(getComponente('multas'));
				var dialog=getDialog();
				dialog.buttons[0].setText('Guardar');
	
				_CP.loadingShow();
				
				Ext.Ajax.request({
					url:direccion+"../../../control/plan_pago/ActionListarPlanPagoCuota.php?m_id_cotizacion="+maestro.id_cotizacion,
					method:'GET',
					success:verificar,
					failure:Cm_conexionFailure,
					timeout:100000000
				});
	
	
				
			}
			else{
				alert('El adelanto debe estar pagado para realizar nuevos pagos');
				
			}
		}
		
		function verificar(resp){
					Ext.MessageBox.hide();
					if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
						var root=resp.responseXML.documentElement;
	
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
							get_fecha_adq();
							CM_btnNew();
							
	
								txt_fecha_pagado.setValue(root.getElementsByTagName('fecha_reg_cotizacion')[0].firstChild.nodeValue);
								txt_fecha_pago.minValue=txt_fecha_pagado.getValue();
								txt_fecha_pagado.setValue('');
	
								if(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue=='0'||root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue=='0.00'||root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue=='0.00000000'){
	
									getComponente('monto_original').disable();
									getDialog().hide();
									alert('Ya se completó el total a pagar');
	
								}
								else{
									getComponente('cuota_a_pagar').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
	
									
									var Dialog= getDialog();
									Dialog.show();
								}
							
	
							getComponente('nro_cuota').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
							getComponente('precio_total').setValue(root.getElementsByTagName('precio_total')[0].firstChild.nodeValue);
							getComponente('pagado').setValue(root.getElementsByTagName('pagado')[0].firstChild.nodeValue);
							getComponente('falta_pagar').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
							
							getComponente('monto_original').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
								//RAC:Se quitan los campos de impuestos, y retenciones de bien u servicios
	
							getComponente('monto').setValue(getComponente('monto_original').getValue());
							getComponente('retencion_bien').setValue(0);
	
						}
					}
				}


		function miSuccess(resp){

			CM_saveSuccess(resp);
			if(getComponente('estado').getValue()=='pagado'){
				var data='m_id_plan_pago='+getComponente('id_plan_pago').getValue();
				window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFSolicitudPago.php?'+data)
			}
			salta();
		}

		function btn_provisional(){
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect>0){
				var data='m_id_plan_pago='+getComponente('id_plan_pago').getValue();
				window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFSolicitudPago.php?'+data)
			}
			else{
				alert('Antes debe seleccionar un item');
			}
		}

		function get_fecha_adq(){
			_CP.loadingShow('Cargando Fecha ...');
			
			
			Ext.Ajax.request({
				url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+maestro.id_empresa,
				method:'GET',
				success:cargar_fecha_adq,
				failure:Cm_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

		function cargar_fecha_adq(resp){
			  Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
					txt_fecha_pagado.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
					txt_fecha_pagado.setValue('');
				}
			}
		}


	

	
		function btn_pagar(){
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Total a Pagar');
			CM_mostrarGrupo('Pagos');
			CM_ocultarGrupo('Datos Boleta de Garantia');
			
			//CM_ocultarGrupo('Datos Factura');
			getComponente('id_gestion').disable();
			txt_tipo_plantilla.enable();
			
			
			this.btnActualizar;
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();

			if(NumSelect!=0){
				if(SelectionsRecord.data.estado!='anulado'){
					retencion_original=SelectionsRecord.data.retencion_bien;

					
					getComponente('multas').maxValue=SelectionsRecord.data.monto;
					CM_mostrarComponente(getComponente('multas'));
					
					if(maestro.tipo_pago=='avance' && (SelectionsRecord.data.id_avance=='' || SelectionsRecord.data.id_avance==undefined)){
						CM_mostrarGrupo('Fondos en Avance');
						getComponente('id_avance').allowBlank=false;
						getComponente('id_avance').modificado=true;
						ds_avance.baseParams={
							tipo:'plan_pago',id_cotizacion:maestro.id_cotizacion,id_depto:maestro.id_depto_tesoro
						}	
					}
					else{
						CM_ocultarGrupo('Fondos en Avance');
						getComponente('id_avance').allowBlank=true;	
					}
					

					if(maestro.factura_total=='no'){
						
							CM_mostrarGrupo('Datos Factura');
							getComponente('num_factura').allowBlank=false;
							getComponente('num_autoriza_factura').allowBlank=true;
							getComponente('boleta_garantia').allowBlank=true;
							CM_ocultarGrupo('Datos Boleta de Garantia');
							getComponente('boleta_garantia').clearInvalid();
						
					}else{
					    getComponente('tipo_plantilla').setValue(maestro.tipo_documento);
					    getComponente('num_factura').setValue(maestro.num_factura);
					    getComponente('fecha_factura').setValue(maestro.fecha_factura);
						CM_ocultarGrupo('Datos Boleta de Garantia');
						CM_ocultarGrupo('Datos Factura');
						getComponente('num_factura').allowBlank=true;
						getComponente('num_autoriza_factura').allowBlank=true;
						getComponente('fecha_factura').allowBlank=true;
						getComponente('boleta_garantia').clearInvalid();
					}
					
					
					

					getComponente('observaciones').allowBlank=true;
					verificarNumPago();
				}
				else{
					alert('El pago fue anulado')
				}
			}
			else{
				alert('Antes debe seleccionar un item.')
			}
		}





		function verificarNumPago(){
			
			_CP.loadingShow('Verificando Nï¿½mero de Pago');
			
			
			Ext.Ajax.request({
				url:direccion+"../../../control/plan_pago/ActionListarNumPagos.php?m_id_cotizacion="+maestro.id_cotizacion,
				method:'GET',
				success:verificarPago,
				failure:Cm_conexionFailure,
				timeout:100000000
			})
		}

		function verificarPago(resp){
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){


				//rac: comentado por que elcampo se eliminara
				//cmbImpuesto.setValue(0);
				
                Ext.MessageBox.hide();

				var root=resp.responseXML.documentElement;
				var sm=getSelectionModel();
				var SelectionsRecord=sm.getSelected();
				var dialog=getDialog();
				dialog.buttons[0].setText('Efectuar Pago');
				getComponente('estado').disable();
				
					_CP.loadingShow('Obteniendo Fecha...');
					
					
				Ext.Ajax.request({
					
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					method:'GET',
					success:function cargar_fecha_bd(resp1){
						
					  Ext.MessageBox.hide();

						if(resp1.responseXML != undefined && resp1.responseXML != null && resp1.responseXML.documentElement != null && resp1.responseXML.documentElement != undefined)
						{
							var root1 = resp1.responseXML.documentElement;
							getComponente('fecha_pagado').setValue(root1.getElementsByTagName('fecha')[0].firstChild.nodeValue);
						}
					},
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});



				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
					
					getComponente('num_pago').setValue(root.getElementsByTagName('num_pago')[0].firstChild.nodeValue);

					if(SelectionsRecord.data.nro_cuota==parseFloat(getComponente('num_pago').getValue()+1)){
						
						getComponente('monto_original').disable();
						CM_mostrarComponente(getComponente('fecha_pagado'));
						getComponente('fecha_pago').disable();
						getComponente('fecha_pagado').allowBlank=false;
						getComponente('estado').setValue('devengado');
						getComponente('estado').disable();
						CM_mostrarComponente(getComponente('fecha_pagado'));
						pagar();
						

					}else{
						if(SelectionsRecord.data.estado!='devengado'){
							alert('El pago a efectuar deberia ser el '+parseFloat(getComponente('num_pago').getValue()+1));
						}else{
							alert('Ya se procediï¿½ con el pago');
						}
					}
				}else{if(parseFloat(SelectionsRecord.data.nro_cuota)==1){
					if(SelectionsRecord.data.tipo_pago=='normal'){
						if(SelectionsRecord.data.tipo_adq=='Bien'){

							pagar();

							alert('para efectuar el pago, es necesaria la entrega del total adjudicado');

						}else{
							pagar();
						}
					}else{
						pagar();
					}
				}else{
					alert('El pago a efectuar deberia ser el 1');
				}
				}
			}
		}
		
		function pagar(){
			
			if (maestro.estado_adelanto!='no'){
											   
				   CM_mostrarComponente(getComponente('por_anticipo'));
				   getComponente('por_anticipo').setValue(maestro.por_adelanto);
				   getComponente('por_anticipo').allowBlank=false;
				  
			}
			else{
				CM_ocultarComponente(getComponente('por_anticipo'));
				getComponente('por_anticipo').allowBlank=true;
				
			}
			if (maestro.estado_retgar!='no'){
					
				   CM_mostrarComponente(getComponente('por_retgar'));
				   getComponente('por_retgar').setValue(maestro.por_retgar);
				   getComponente('por_retgar').allowBlank=false;
						  
			}
			else{
				CM_ocultarComponente(getComponente('por_retgar'));
				getComponente('por_retgar').allowBlank=true;
				
			}
			CM_mostrarComponente(getComponente('fecha_pagado'));
			getComponente('fecha_pago').disable();
			getComponente('fecha_pagado').allowBlank=false;
			getComponente('monto_original').disable();
			getComponente('estado').setValue('devengado');
			CM_btnEdit();
		}

	


		this.EnableSelect=function(x,z,y){
			enable(x,z,y)
		}

		function salta(){ _CP.getPagina(idContenedorPadre).pagina.btnActualizar();

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cotizacion:maestro.id_cotizacion
			}
		};
		}

		//para que los hijos puedan ajustarse al tamaï¿½o
		this.getLayout=function(){return layout_plan_pago.getLayout()};
		//para el manejo de hijos

		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		//para agregar botones
		
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Pagar',btn_pagar,true,'pagar','Pagar');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Provisional',btn_provisional,true,'provisional','Provisional');
		

		var CM_getBoton=this.getBoton;
		CM_getBoton('pagar-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
		CM_getBoton('provisional-'+idContenedor).enable();
		function  enable(sel,row,selected){
			var record=selected.data;
			if(selected&&record!=-1){

							
				if(record.estado=='pendiente'){
					if (maestro.estado_adelanto=='pendiente'){
						   CM_getBoton('pagar-'+idContenedor).disable();
					}
					else{
						CM_getBoton('pagar-'+idContenedor).enable();
					}
					CM_getBoton('eliminar-'+idContenedor).enable();
					CM_getBoton('provisional-'+idContenedor).disable();
				}
				else{
					CM_getBoton('pagar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('provisional-'+idContenedor).enable();
					
				}
								
			}
			enableSelect(sel,row,selected);
		}
		this.iniciaFormulario();
		iniciarEventosFormularios();


		layout_plan_pago.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}