/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-28 17:32:15
*/
function pagina_plan_pago_serv(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg;
	var cantidad=0;
	var adj=0;
	var bandera=false;
	var  num_pago=0, maestro;
	
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
		'boleta_garantia','num_autoriza_factura','cod_control_factura',
		{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},'multas', 'cantidad_entregada','tipo_adq','pago_simplificado'

		]),remoteSort:true});

	//carga datos XML
//	ds.load({
//		params:{
//			start:0,
//			limit: paramConfig.TamanoPagina,
//			CantFiltros:paramConfig.CantFiltros,
//			m_id_cotizacion:maestro.id_cotizacion
//		}
//	});
		// DEFINICIÓN DATOS DEL MAESTRO

//		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
//		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

		
		//DATA STORE COMBOS
		

	//FUNCIONES RENDER
	
		///////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_cotizacion_det
		//en la posición 0 siempre esta la llave primaria

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
			grid_visible:true, 
			grid_indice:4,
			width_grid:75,
			grid_editable:true 
		},
		tipo:'ComboBox',
		filtro_0:true,
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
	
	
	// txt monto
	Atributos[3]={
		validacion:{
			name:'monto',
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
		filterColValue:'plapag.monto',
		save_as:'monto',
		id_grupo:1
	};
// txt fecha_pago
	Atributos[4]= {
		validacion:{
			name:'fecha_pago',
			fieldLabel:'Fecha Tentativa de Pago',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
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
	Atributos[5]={
		validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
//			store: new Ext.data.SimpleStore({
//				fields: ['ID','valor'],
//				data : Ext.plan_pago_combo.estado
//			}),
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
	Atributos[6]={
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
	Atributos[7]={
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
		id_grupo:1
	};
	
	
	Atributos[8]={
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
		id_grupo:1
		
	};
	
	
	Atributos[9]={
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
		id_grupo:1
	};
	
	Atributos[10]={
		validacion:{
			name:'num_pagos',
			fieldLabel:'Nº Pagos',
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
	
	
		Atributos[11]={
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
	
	Atributos[12]= {
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

	Atributos[13]={
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
	
	
	Atributos[14]={
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
	
	
	Atributos[15]={
		validacion:{
			name:'num_factura',
			fieldLabel:'Nº Factura/Recibo',
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
	
	
	Atributos[16]={
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
	
	Atributos[17]={
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
	
	Atributos[18]={
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
		id_grupo:3
	};
	
	Atributos[19]={//==> SI
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
		id_grupo:3 //1
	};
	
	
	Atributos[20]= {
		validacion:{
			name:'fecha_factura',
			fieldLabel:'Fecha Factura/Recibo',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
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
	
	Atributos[21]={
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
			disabled:false,
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
	
	
	Atributos[22]={
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
	
	Atributos[23]={
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
	//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		
		
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Detalle - Orden de Compra',grid_maestro:'grid-'+idContenedor};
	    layout_plan_pago_serv= new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_plan_pago_serv.init(config);

		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_plan_pago_serv,idContenedor);
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
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={
			nuevo:{crear:true,separador:true},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/plan_pago/ActionEliminarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[6]},
			Save:{url:direccion+'../../../control/plan_pago/ActionGuardarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[6], success:miSuccess},
			ConfirmSave:{url:direccion+'../../../control/plan_pago/ActionGuardarPlanPago.php',parametros:'&m_id_cotizacion='+Atributos[6]},
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
			}]}
		};

		
//		var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/cotizacion/ActionListarCotizacion.php?id_cotizacion='+maestro.id_cotizacion}),
//		  reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion',totalRecords: 'TotalCount'},['id_cotizacion',
//		  'forma_pago','num_cotizacion',
//		  'desc_proveedor','desc_tipo_categoria_adq','lugar_entrega'
//		  ])
//		});
//
//		ds_maestro.load({
//			params:{
//				start:0,
//				limit: paramConfig.TamanoPagina,
//				CantFiltros:paramConfig.CantFiltros,
//				m_id_cotizacion:maestro.id_cotizacion
//			},
//			callback:cargar_maestro
//		});
//
//		function cargar_maestro(){
//			data1=[['Nº Cotizacion',ds_maestro.getAt(0).get('num_cotizacion')],  ['Categoria',ds_maestro.getAt(0).get('desc_tipo_categoria_adq')],  
//			 ['Forma Pago',ds_maestro.getAt(0).get('forma_pago')],['Proveedor',ds_maestro.getAt(0).get('desc_proveedor')],   ['Lugar Entrega',ds_maestro.getAt(0).get('lugar_entrega')],  ['Moneda',maestro.desc_moneda]];
//			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
//		}
			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m){
                maestro=m;
                
//				var datos=Ext.urlDecode(decodeURIComponent(params));
//				maestro.id_cotizacion=datos.m_id_cotizacion;
//				maestro.observaciones=datos.m_observaciones;
//				maestro.num_proceso=datos.m_num_proceso;
//				maestro.desc_proveedor=datos.m_desc_proveedor;
//
//				maestro.estado_vigente=datos.m_estado_vigente;
//				maestro.num_pagos=datos.m_num_pagos;
//                maestro.factura_total=datos.m_factura_total;
//				ds_maestro.load({
//				params:{
//					start:0,
//					limit: paramConfig.TamanoPagina,
//					CantFiltros:paramConfig.CantFiltros,
//					id_cotizacion:maestro.id_cotizacion
//				},
//				callback:cargar_maestro
//				}); 
			
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_cotizacion:maestro.id_cotizacion
					}
				};
				this.btnActualizar();
				
				Atributos[23].defecto=maestro.id_proceso_compra;
				Atributos[6].defecto=maestro.id_cotizacion;
				paramFunciones.btnEliminar.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
				paramFunciones.Save.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
				paramFunciones.ConfirmSave.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
                iniciarEventosFormularios();
				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones)
			};

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				txt_monto=getComponente('monto');
				txt_precio=getComponente('precio_total');
				txt_falta_pagar=getComponente('falta_pagar');
				txt_num_pagos=getComponente('num_pagos');
				txt_fecha_pago=getComponente('fecha_pago');
				txt_fecha_pagado=getComponente('fecha_pagado');
				txt_tipo_pago=getComponente('tipo_pago');
				
			
				var verificarMonto=function(e){
					if(parseFloat(txt_monto.getValue())>parseFloat(txt_falta_pagar.getValue())){
						txt_monto.markInvalid('Monto a pagar no puede ser mayor a '+txt_falta_pagar.getValue());
					}
				}
				txt_monto.on('change',verificarMonto);
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
				txt_tipo_pago.on('select',onTipoPago);
				txt_tipo_pago.on('change',onTipoPago);
				
//				if(maestro.factura_total=='si'){
//			       gridG.getColumnModel().setHidden(6,true);
//				   gridG.getColumnModel().setHidden(7,true);
//				   gridG.getColumnModel().setHidden(8,true);
//				   gridG.getColumnModel().setHidden(9,true);
//				   gridG.getColumnModel().setHidden(10,true);
//				   
//				   getComponente('num_factura').allowBlank=true;
//				   getComponente('num_autoriza_factura').allowBlank=true;
//				   getComponente('fecha_factura').allowBlank=true;
//				   
//				   getComponente('fecha_factura').clearInvalid();
//				   getComponente('num_factura').clearInvalid();
//				   getComponente('num_autoriza_factura').clearInvalid();
//				}else{// en plan de pagos cada pago debe tener su factura
//				   gridG.getColumnModel().setHidden(6,false);
//				   gridG.getColumnModel().setHidden(7,false);
//				   gridG.getColumnModel().setHidden(8,false);
//				   gridG.getColumnModel().setHidden(9,false);
//				   gridG.getColumnModel().setHidden(10,false); 
//				   
//				   getComponente('num_factura').allowBlank=false;
//				   getComponente('num_autoriza_factura').allowBlank=false;
//				   getComponente('fecha_factura').allowBlank=false;
//				}
			}


			this.btnNew=function(){
				CM_ocultarGrupo('Oculto');
				CM_mostrarGrupo('Datos de Pago');
				CM_ocultarGrupo('Pagos');
				CM_ocultarGrupo('Datos Boleta de Garantia');
                //CM_ocultarGrupo('Datos Factura');
                if(maestro.impuestos='no'){
                    CM_ocultarComponente(getComponente('num_autoriza_factura'));
                    CM_ocultarComponente(getComponente('cod_control_factura'));
                }else{
                    CM_mostrarComponente(getComponente('num_autoriza_factura'));
                    CM_mostrarComponente(getComponente('cod_control_factura'));
                }
				getComponente('num_factura').allowBlank=true;
				getComponente('observaciones').allowBlank=true;
				getComponente('estado').disable();
				CM_ocultarComponente(getComponente('fecha_pagado'));
				getComponente('fecha_pagado').allowBlank=true;
				getComponente('fecha_pago').allowBlank=false;
				getComponente('fecha_pago').enable();

			    getComponente('tipo_pago').enable();
                getComponente('num_autoriza_factura').allowBlank=true;
                getComponente('fecha_factura').allowBlank=true;
                CM_ocultarComponente(getComponente('multas'));
                var dialog=getDialog();
			    dialog.buttons[0].setText('Guardar');
			    
				Ext.Ajax.request({
			   	url:direccion+"../../../control/plan_pago/ActionListarPlanPagoCuota.php?m_id_cotizacion="+maestro.id_cotizacion,
			    method:'GET',
			    success:verificar,
			    failure:Cm_conexionFailure,
			    timeout:100000000
			});
			
			
			function verificar(resp){
				
				
			Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
						
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  		get_fecha_adq();
				    	CM_btnNew();
				  		 if(parseFloat((root.getElementsByTagName('monto')[0].firstChild.nodeValue))>0 ){
		                      txt_fecha_pagado.setValue(root.getElementsByTagName('fecha_reg_cotizacion')[0].firstChild.nodeValue);
					          txt_fecha_pago.minValue=txt_fecha_pagado.getValue();
					          txt_fecha_pagado.setValue('');
				  		      
				  	  	   if((parseFloat(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue))>(parseFloat(root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue))){
				  	  	      
				  	  	   	      getComponente('monto').disable();
				  	  	   	      var Dialog= getDialog();
 								  Dialog.hide();
				  				  alert('Ya se completó la definición de cuotas a pagar');
				  				  
				  			}else{  
				  			    
				  	  	    	  getComponente('cuota_a_pagar').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
				  	  	    	 		getComponente('monto').enable();	  	  	    	  
				  	  	    	   if(parseFloat(getComponente('cuota_a_pagar').getValue())<=1){
				  	  	    	      getComponente('tipo_pago').enable();
				  	  	    	  }else{
				  	  	    	      getComponente('tipo_pago').disable();
				  	  	    	  }
				  	  	    	  var Dialog= getDialog();
 								  Dialog.show();}
				  	  		}
				  	  
				  	  		if((root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue)>(root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue) &&(parseFloat(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue)<=0)){
					  	  	   
				  	  		    getComponente('monto').disable();
				  	  			  var Dialog= getDialog();
 								  Dialog.hide();
				  	  		}
				  	 
				 	 
						getComponente('num_pagos').setValue(root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue);
				  		getComponente('nro_cuota').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
				  		
				  		getComponente('precio_total').setValue(root.getElementsByTagName('precio_total')[0].firstChild.nodeValue);
				  	  	getComponente('pagado').setValue(root.getElementsByTagName('pagado')[0].firstChild.nodeValue);
				  	  	getComponente('falta_pagar').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
 						if(parseFloat(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue)<parseFloat(root.getElementsByTagName('monto_a_pagar')[0].firstChild.nodeValue)){
				  	  		getComponente('monto').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
				  	  	}
 						else{
 							getComponente('monto').setValue(root.getElementsByTagName('monto_a_pagar')[0].firstChild.nodeValue);
 							
 						}
 						
 						if( (root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue)<=(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue) ){
 							getComponente('monto').disable();
 						}
 						
// 						txt_fecha_pagado.setValue(root.getElementsByTagName('fecha_reg_cotizacion')[0].firstChild.nodeValue)
//				  	
//				  	txt_fecha_pago.minValue=txt_fecha_pagado.getValue();
//				  	txt_fecha_pagado.setValue('');
				  	
 					}
				}
			}
		}
			
			
		function miSuccess(resp){
		    
		    CM_saveSuccess(resp);
            if(getComponente('estado').getValue()=='pagado'){
		          var data='m_id_plan_pago='+getComponente('id_plan_pago').getValue();
			      window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFSolicitudPago.php?'+data)	
            }
        
		}
			
	function get_fecha_adq(){
		Ext.Ajax.request({
			url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+maestro.id_empresa,
			method:'GET',
			success:cargar_fecha_adq,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}

	function cargar_fecha_adq(resp){
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
					//txt_fecha.minValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
					txt_fecha_pagado.setValue(root.getElementsByTagName('fecha_fin')[0].firstChild.nodeValue);
					//txt_fecha_pago.maxValue=txt_fecha_pagado.getValue();
					txt_fecha_pagado.setValue('');
			}
		}
	}

			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
				CM_ocultarGrupo('Oculto');
				CM_ocultarComponente(getComponente('fecha_pagado'));
				getComponente('monto').enable();
				var dialog=getDialog();
			    dialog.buttons[0].setText('Guardar');
				if(NumSelect>0){
					if(SelectionsRecord.data.estado=='pendiente'){
					    CM_ocultarGrupo('Pagos');
						getComponente('fecha_pago').enable();
						getComponente('num_factura').allowBlank=true;
				        getComponente('observaciones').allowBlank=true;
					}else{
					    CM_mostrarGrupo('Pagos');
						getComponente('fecha_pago').disable();
					}
				
			 		if(getComponente('estado').getValue()=='pendiente'){
			 			getComponente('estado').disable();
			 			//alert(SelectionsRecord.data.num_pagos+"***"+SelectionsRecord.data.nro_)
			 			//alert(getComponente('num_pagos').getValue()+" --- "+getComponente('nro_cuota').getValue());
			 			
			 			if(getComponente('num_pagos').getValue()==getComponente('nro_cuota').getValue()){
			 				getComponente('monto').disable();
			 			}else{
			 				getComponente('monto').enable();
			 			}
			 			//verificarEstado();
						CM_btnEdit();
				 	}else{
				 		getComponente('monto').disable();
						getComponente('estado').disable();
						CM_btnEdit();
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
				var SelectionsRecord=sm.getSelected();
				
				if(SelectionsRecord.data.estado!='pendiente'){
					alert('solo pagos pendientes pueden eliminarse');
				}else{
					CM_btnEliminar();
				}
			}
			
			
//			function verificarEstado(){
//				var sm=getSelectionModel();
//				var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
//				var SelectionsRecord=sm.getSelected();
//				
//				if(SelectionsRecord.data.estado=='pagado'){
//					if(getComponente('estado').getValue()=='pendiente'){
//						Ext.MessageBox.alert('','Erroorrrr!!');
//					}
//				}
//				
//			}
			
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
			
		function obtenerCuota(){
			Ext.Ajax.request({
			   url:direccion+"../../../control/plan_pago/ActionListarPlanPagoCuota.php?m_id_cotizacion="+maestro.id_cotizacion,
			   method:'GET',
			   success:verificar,
			   failure:Cm_conexionFailure,
			   timeout:100000000
			})
		}
		
		function verificar(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
						
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  		
				  	//if(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue<=root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue){
				  	  if(getComponente('monto').getValue()>0){}
				  	  else{	
				  		getComponente('cuota_a_pagar').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
				  	  }
				  		
				  	    getComponente('num_pagos').setValue(root.getElementsByTagName('num_pagos')[0].firstChild.nodeValue);
				  		getComponente('nro_cuota').setValue(root.getElementsByTagName('cuota_a_pagar')[0].firstChild.nodeValue);
				  		
				  		getComponente('precio_total').setValue(root.getElementsByTagName('precio_total')[0].firstChild.nodeValue);
				  	  	getComponente('pagado').setValue(root.getElementsByTagName('pagado')[0].firstChild.nodeValue);
				  	  	getComponente('falta_pagar').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
 						if(parseFloat(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue)<parseFloat(root.getElementsByTagName('monto_a_pagar')[0].firstChild.nodeValue)){
				  	  	 	
 							getComponente('monto').setValue(root.getElementsByTagName('falta_pagar')[0].firstChild.nodeValue);
 						}
 						else{
 							getComponente('monto').setValue(root.getElementsByTagName('monto_a_pagar')[0].firstChild.nodeValue);
 						}
 					}
				}
			}
		
			function btn_pagar(){
				CM_ocultarGrupo('Oculto');
				CM_mostrarGrupo('Pagos');
				CM_ocultarGrupo('Datos Boleta de Garantia');
				CM_ocultarGrupo('Datos Factura');
				this.btnActualizar;
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
				if(NumSelect!=0){
				    if(SelectionsRecord.data.estado!='anulado'){
				        getComponente('multas').maxValue=SelectionsRecord.data.monto;
				        CM_mostrarComponente(getComponente('multas'));
				        getComponente('tipo_pago').disable();
				        if(maestro.factura_total=='no'){
				             if(SelectionsRecord.data.tipo_pago=='normal'){
				                CM_mostrarGrupo('Datos Factura');
				                if(maestro.impuestos='no'){
				                    CM_ocultarComponente(getComponente('num_autoriza_factura'));    
				                    CM_ocultarComponente(getComponente('cod_control_factura'));
				                }else{
				                    CM_mostrarComponente(getComponente('num_autoriza_factura'));    
				                    CM_mostrarComponente(getComponente('cod_control_factura'));    
				                }
				                
				                   getComponente('num_factura').allowBlank=false;
                                   getComponente('boleta_garantia').allowBlank=true;
                                   CM_ocultarGrupo('Datos Boleta de Garantia');
                                   getComponente('boleta_garantia').clearInvalid();
                             }else{
                                 if(maestro.impuestos='no'){
				                    CM_ocultarComponente(getComponente('num_autoriza_factura'));    
				                    CM_ocultarComponente(getComponente('cod_control_factura'));
				                }else{
				                    CM_mostrarComponente(getComponente('num_autoriza_factura'));    
				                    CM_mostrarComponente(getComponente('cod_control_factura'));    
				                }
                                 
	 			                 CM_mostrarGrupo('Datos Boleta de Garantia');
				                 getComponente('num_factura').allowBlank=true;
                                 getComponente('num_autoriza_factura').allowBlank=true;
                                 getComponente('fecha_factura').allowBlank=true;
                                 CM_ocultarGrupo('Datos Factura');
                                 getComponente('num_factura').clearInvalid();
                                 getComponente('num_autoriza_factura').clearInvalid();
                                 getComponente('fecha_factura').clearInvalid();
				             }
                       }else{
                                if(maestro.impuestos='no'){
				                    CM_ocultarComponente(getComponente('num_autoriza_factura'));    
				                    CM_ocultarComponente(getComponente('cod_control_factura'));
				                }else{
				                    CM_mostrarComponente(getComponente('num_autoriza_factura'));    
				                    CM_mostrarComponente(getComponente('cod_control_factura'));    
				                }
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
						alert('El pago fué anulado')
					}
				}
				else{
					alert('Antes debe seleccionar un item.')
				}
			}


		
		function verificarNumPago(){
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
				
				var root=resp.responseXML.documentElement;
				var sm=getSelectionModel();
				var SelectionsRecord=sm.getSelected();
				var dialog=getDialog();
			    dialog.buttons[0].setText('Efectuar Pago');
			    getComponente('estado').disable();
				Ext.Ajax.request({
								url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
								method:'GET',
								success:function cargar_fecha_bd(resp1){
								
								if(resp1.responseXML != undefined && resp1.responseXML != null && resp1.responseXML.documentElement != null && resp1.responseXML.documentElement != undefined)
								{
									var root1 = resp1.responseXML.documentElement;
									    getComponente('fecha_pagado').setValue(root1.getElementsByTagName('fecha')[0].firstChild.nodeValue);
										
									    	//getComponente('fecha_pagado').maxValue=SelectionsRecord.data.fecha_pago;
								}
							},
								failure:Cm_conexionFailure,
								timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
							});


							
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
					getComponente('num_pago').setValue(root.getElementsByTagName('num_pago')[0].firstChild.nodeValue);
					//alert(SelectionsRecord.data.nro_cuota);
					if(SelectionsRecord.data.nro_cuota==parseFloat(getComponente('num_pago').getValue()+1)){
						getComponente('monto').disable();
							CM_mostrarComponente(getComponente('fecha_pagado'));
							getComponente('fecha_pago').disable();
							getComponente('fecha_pagado').allowBlank=false;
							getComponente('estado').setValue('devengado');
							getComponente('estado').disable();
							CM_mostrarComponente(getComponente('fecha_pagado'));
						    CM_btnEdit();

					}else{
						if(SelectionsRecord.data.estado!='devengado'){
							alert('El pago a efectuar deberia ser el '+parseFloat(getComponente('num_pago').getValue()+1));
						}else{
							alert('Ya se procedió con el pago');
						}
					}
				 }else{if(SelectionsRecord.data.nro_cuota ==1){
				            if(SelectionsRecord.data.tipo_pago=='normal'){
				                if(SelectionsRecord.data.tipo_adq=='Bien'){
				                    // if(SelectionsRecord.data.cantidad_entregada>0){
				 	                    pagar();
				                 //}else{
				                     alert('para efectuar el pago, es necesaria la entrega del total adjudicado');   
				                 //}
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
		    CM_mostrarComponente(getComponente('fecha_pagado'));
            getComponente('fecha_pago').disable();
            getComponente('fecha_pagado').allowBlank=false;
            getComponente('monto').disable();
            getComponente('estado').setValue('devengado');
            CM_btnEdit();
		  }
		  
	    this.EnableSelect=function(x,z,y){
		   enable(x,z,y)
	}
    	
		function salta(){ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar()}
		
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_plan_pago_serv.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Pagar',btn_pagar,true,'pagar','Pagar');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Provisional',btn_provisional,true,'provisional','Provisional');
			//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Anular',btn_anular,true,'anular','Anular Pago');
			var CM_getBoton=this.getBoton;
		    CM_getBoton('pagar-'+idContenedor).enable();
		    CM_getBoton('eliminar-'+idContenedor).enable();
		    function  enable(sel,row,selected){
		      var record=selected.data; 
			     if(selected&&record!=-1){
			          CM_getBoton('pagar-'+idContenedor).enable();
		              CM_getBoton('eliminar-'+idContenedor).enable();
			         if(record.estado=='devengado'){
			             CM_getBoton('pagar-'+idContenedor).disable();
			             CM_getBoton('eliminar-'+idContenedor).disable();			             
			         }else{
			             CM_getBoton('pagar-'+idContenedor).enable();
			             CM_getBoton('eliminar-'+idContenedor).enable();			             
			         }
			     }
			     enableSelect(sel,row,selected);
		    }
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_plan_pago_serv.getLayout().addListener('layout',this.onResize);
			
			layout_orden_compra_serv_det.getVentana().addListener('beforehide',salta);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}