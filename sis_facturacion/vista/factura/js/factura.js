function pagina_factura(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	
	var dialog;
	var habilita_hijo='si';
	
	var comp_id_gestion, g_id_gestion, comp_id_moneda, comp_fac_tcambio, comp_fac_fecha;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'importe',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0
	}); 
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/factura/ActionListarFactura.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_factura',totalRecords:'TotalCount'
		},[
		'id_factura',
		'id_gestion', 
        'id_cliente', 
        'id_dosifica',
        'nro_autoriza',
        'id_moneda', 
        'simbolo',
        'id_depto',
        'nombre_depto',
        'fac_nombre', 
        'fac_nronit', 
        'fac_tcambio',
		{name: 'fac_fecha',type:'date',dateFormat:'Y-m-d'},
        'fac_concepto', 
        'fac_importe', 
        'fac_numero', 
        'fac_control', 
        'fac_formula',		
        'fac_estado_vig',
		'usuario_reg',
		'fecha_reg'
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:-1
		}
	});
	
	/*FUNCIONES RENDER*/
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}
	}); 
	
	var ds_cliente = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cliente/ActionListarCliente.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cliente',totalRecords:'TotalCount'},[
		'id_cliente','razon_social','nro_nit','direccion','telefono','repre_legal','docid_legal','nomb_fact','usuario_reg','fecha_reg'])
	});
	
	var ds_dosifica = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/dosifica/ActionListarDosifica.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_dosifica',totalRecords:'TotalCount'},[
		'id_dosifica','tipo_fac','nro_autoriza','fecha_vence','clave_activa','sw_debito','nro_inicial','nro_actual','estado','usuario_reg','fecha_reg']),
		baseParams:{sw_tipo_fac:1, sw_estado:1}
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
	
	/*FUNCIONES RENDER*/
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
  	
	function render_id_cliente(value, p, record){return String.format('{0}', record.data['fac_nombre']);}
	var tpl_id_cliente=new Ext.Template('<div class="search-item">','<b>{razon_social}</b><FONT COLOR="#B5A642"><br> NIT: </b>{nro_nit}</FONT><br>','</div>');
	
	function render_id_dosifica(value, p, record){return String.format('{0}', record.data['nro_autoriza']);}
	var tpl_id_dosifica=new Ext.Template('<div class="search-item">','<b><i>{nro_autoriza}</i></b>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['simbolo']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function renderFormatNumber(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_factura',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[2]={
		validacion:{
 			name:'id_cliente',
			fieldLabel:'Cliente',
			allowBlank:false,			
			emptyText:'Cliente...',
			desc: 'fac_nombre', 		
			store:ds_cliente,
			valueField: 'id_cliente',
			displayField: 'nomb_fact',
			queryParam: 'filterValue_0',
			filterCol:'CLIE.razon_social#CLIE.nomb_fact#CLIE.nro_nit',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cliente,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cliente,
 			grid_visible:false,
 	 		grid_editable:false,
			width_grid:350,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0
	};

	Atributos[3]={
		validacion:{
			name:'fac_estado_vig',
			fieldLabel:'Etapa',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		id_grupo:0
	};
	   
	Atributos[4]={
		validacion:{
			name:'fac_nronit',
			fieldLabel:'NIT',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'FAC.fac_nronit',
		id_grupo:0
	};
		
	Atributos[5]={
		validacion:{
			name:'fac_nombre',
			fieldLabel:'Razon Social',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'FAC.fac_nombre',
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
 			name:'id_dosifica',
			fieldLabel:'Dosificación',
			allowBlank:false,			
			emptyText:'Dosificación...',
			desc: 'nro_autoriza', 		
			store:ds_dosifica,
			valueField: 'id_dosifica',
			displayField: 'nro_autoriza',
			queryParam: 'filterValue_0',
			filterCol:'DOS.nro_autoriza',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_dosifica,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_dosifica,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:150,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0
	};

	Atributos[7]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Contable',
			allowBlank:false,
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DPTO.nombre_depto',
		id_grupo:0
	};
   
	Atributos[8]={
		validacion:{
			name:'fac_numero',
			fieldLabel:'Nº Factura',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'FAC.fac_numero',
		id_grupo:0
	};
		
	Atributos[9]={
		validacion:{
			name:'fac_control',
			fieldLabel:'Código Control',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'FAC.fac_control',
		id_grupo:0
	};
	
	Atributos[10] = {
		validacion : {
			name :'fac_fecha',
			fieldLabel :'Fecha',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/2014',
			renderer :formatDate,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			disabled :false
		},
		id_grupo:0,
		tipo:'DateField',
		dateFormat:'m/d/Y',
		defecto:""
	};

	Atributos[11]={
		validacion:{
			name:'fac_concepto',
			fieldLabel:'Concepto',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:false
		},
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'FAC.fac_concepto',
		id_grupo:0
	};
	
	Atributos[12]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'simbolo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'simbolo',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[13]={
		validacion:{
			name:'fac_tcambio',
			fieldLabel:'Tipo Cambio',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:10,//para numeros float
			allowNegative:false,
			allowMil:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:100,
			disabled:false
		},
		tipo:'NumberField',
		form:true,
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[14]={
		validacion:{
			name:'fac_importe',
			fieldLabel:'Importe Total',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			renderer: renderFormatNumber
		},
		tipo:'NumberField',
		form:false,
		filtro_1:false,
		id_grupo:1
	};
	
	Atributos[15]={
		validacion:{
			name:'fac_formula',
			fieldLabel:'ID Cbte.',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'FAC.fac_formula',
		id_grupo:1
	};
	
	Atributos[16]={
		validacion:{			
			name:'usuario_reg',
			fieldLabel:'Responsable Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.usuario_reg'
	};
	
	Atributos[17]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:110		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.fecha_reg'
	};
	
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Factura',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_facturacion/vista/factura/factura_det.php'};
    layout_factura = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_factura.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_factura,idContenedor);
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	var CM_getComponente = this.getComponente;
	var CM_getSelectionModel = this.getSelectionModel;
	var CM_saveSuccess = this.saveSuccess;
	var CM_conexionFailure = this.conexionFailure;
	var CM_btnEdit = this.btnEdit;
	var CM_btnNew = this.btnNew;
	var CM_btnEliminar = this.btnEliminar;
	var CM_btnActualizar = this.btnActualizar;
	var CM_getDialog = this.getDialog;
	var CM_getBoton = this.getBoton;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	var CM_mostrarGrupo = this.mostrarGrupo;
	var CM_ocultarGrupo = this.ocultarGrupo;
	var CM_EnableSelect = this.EnableSelect;
	var CM_DeselectRow = this.DeselectRow;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/factura/ActionEliminarFactura.php'},
		Save:{url:direccion+'../../../control/factura/ActionGuardarFactura.php'},
		ConfirmSave:{url:direccion+'../../../control/factura/ActionGuardarFactura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:350,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Facturar',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		dialog = CM_getDialog();
		CM_getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_factura.getIdContentHijo()).pagina.limpiarStore()){}
		})
		
		comp_id_gestion = CM_getComponente('id_gestion');
		comp_id_moneda = CM_getComponente('id_moneda');
		comp_fac_tcambio = CM_getComponente('fac_tcambio');
		comp_fac_fecha = CM_getComponente('fac_fecha');
		
		comp_id_moneda.on('select', sel_tcambio);
	}
	
	this.btnNew = function(){
		CM_btnNew();
		
		comp_id_gestion.setValue(g_id_gestion);
	}
	
	function sel_tcambio(combo, record, index){
		if (record.data['prioridad']==1){
			comp_fac_tcambio.setValue(1);
			CM_ocultarComponente(comp_fac_tcambio);
		}else{
			CM_mostrarComponente(comp_fac_tcambio);
			
			if (comp_fac_fecha.getValue() != ''){
				Ext.MessageBox.show({
							title: 'Tipo de Cambio ...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Tipo de Cambio Oficial...</div>",
							width:150,
							height:200,
							closable:false
						});
		
				Ext.Ajax.request({
						url:direccion+"../../../control/factura/ActionListarTCambio.php",
						success:val_tcambio,
						params:{m_id_moneda:comp_id_moneda.getValue(), m_fecha:comp_fac_fecha.getValue().dateFormat('m-d-Y')},
						failure:CM_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
			}
		}
	}

	function val_tcambio(resp){
		Ext.MessageBox.hide();
		
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined){
			var root=resp.responseXML.documentElement;
			
			if( root.getElementsByTagName('respuesta')[0]!=undefined &&root.getElementsByTagName('respuesta')[0].firstChild!=null &&root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1'){
				comp_fac_tcambio.setValue(root.getElementsByTagName('oficial')[0].firstChild.nodeValue);
			}else{
				comp_fac_tcambio.setValue('');
			}
		}
	}
	
	function btn_devfac(){
		var sm = CM_getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount();
		var SelRecord = sm.getSelected();
		
		if(NumSelect!=0){
			if(confirm('¿Está seguro de Contabilizar el DEVENGADO de la Factura?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Devengando...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Impresión oficial del reporte de solicitud de pago
				reporte=2;
				Ext.Ajax.request({
					url:direccion+"../../../control/factura/ActionProcesFactura.php",
					method:'POST',
					params:{cantidad_ids:'1',id_factura:SelRecord.data.id_factura,accion:'devengar'},
					success:prg_prores,
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function prg_prores(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement){
			CM_btnActualizar();
		}else{
			CM_conexionFailure();
		}
	}
	
	function btn_repfac(){
		var sm = CM_getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount();
		var SelRecord = sm.getSelected();
		
		if(NumSelect!=0){
			if(confirm('¿Está seguro de EMITIR la Factura?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Devengando...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Impresión oficial del reporte de solicitud de pago
				reporte=2;
				Ext.Ajax.request({
					url:direccion+"../../../control/factura/ActionProcesFactura.php",
					method:'POST',
					params:{cantidad_ids:'1',id_factura:SelRecord.data.id_factura,accion:'emitir'},
					success:prg_emifac,
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function prg_emifac(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement){
			prg_repfac();
			CM_btnActualizar();
		}else{
			CM_conexionFailure();
		}
	}
	
	function btn_nulfac(resp){
		var sm = CM_getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount();
		var SelRecord = sm.getSelected();
		
		if(NumSelect!=0){
			if(confirm('¿Está seguro de ANULAR la Factura?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Anulando...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Impresión oficial del reporte de solicitud de pago
				reporte=2;
				Ext.Ajax.request({
					url:direccion+"../../../control/factura/ActionProcesFactura.php",
					method:'POST',
					params:{cantidad_ids:'1',id_factura:SelRecord.data.id_factura,accion:'anular'},
					success:prg_prores,
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_revfac(resp){
		var sm = CM_getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount();
		var SelRecord = sm.getSelected();
		
		if(NumSelect!=0){
			if(confirm('¿Está seguro de REVERTIR la Factura?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Revirtiendo...</div>",
					width:300,
					height:200,
					closable:false
				});
				//Impresión oficial del reporte de solicitud de pago
				reporte=2;
				Ext.Ajax.request({
					url:direccion+"../../../control/factura/ActionProcesFactura.php",
					method:'POST',
					params:{cantidad_ids:'1',id_factura:SelRecord.data.id_factura,accion:'revertir'},
					success:prg_prores,
					failure:CM_conexionFailure,
					timeout:100000000
				});
			}
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function prg_repfac(){
		var sm = CM_getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount();
		var SelRecord = sm.getSelected();
		
		if(NumSelect!=0){	
			var SelectionsRecord=sm.getSelected();
			var data='&id_factura='+SelectionsRecord.data.id_factura
			data+='&id_gestion='+SelectionsRecord.data.id_gestion;
			data+='&sw_rep='+1;
			window.open(direccion+'../../../../sis_facturacion/control/factura/reporte/ActionFacturaJasper.php?'+data);
		}else{	
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.EnableSelect=function(sm,row,rec){
		//acciones hijo
		_CP.getPagina(layout_factura.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_factura.getIdContentHijo()).pagina.desbloquearMenu();
		
		//acciones padre	
		CM_EnableSelect(sm,row,rec);
		
		_CP.getPagina(idContenedor).pagina.desbloquearMenu();
		
		var btn_devfac = CM_getBoton('fac_dev-'+ idContenedor);
		var btn_repfac = CM_getBoton('fac_rep-'+ idContenedor);
		var btn_impfac = CM_getBoton('fac_imp-'+ idContenedor);
		var btn_nulfac = CM_getBoton('fac_nul-'+ idContenedor);
		var btn_revfac = CM_getBoton('fac_rev-'+ idContenedor);
		
		if(rec.data['fac_estado_vig']=='Registro'){
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			
			btn_devfac.enable();
			btn_repfac.disable();
			btn_impfac.enable();
			btn_nulfac.disable();
			btn_revfac.disable();
		}
		if(rec.data['fac_estado_vig']=='Validar_Devengado'){
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			
			btn_devfac.disable();
			btn_repfac.disable();
			btn_impfac.disable();
			btn_nulfac.disable();
			btn_revfac.disable();
			_CP.getPagina(layout_factura.getIdContentHijo()).pagina.bloquearMenu();
		}
		if(rec.data['fac_estado_vig']=='Emitir_Factura'){
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			
			btn_devfac.disable();
			btn_repfac.enable();
			btn_impfac.disable();
			btn_nulfac.enable();
			btn_revfac.enable();
			_CP.getPagina(layout_factura.getIdContentHijo()).pagina.bloquearMenu();
		}
		if(rec.data['fac_estado_vig']=='Facturado'){
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			
			btn_devfac.disable();
			btn_repfac.disable();
			btn_impfac.enable();
			btn_nulfac.enable();
			btn_revfac.enable();
			_CP.getPagina(layout_factura.getIdContentHijo()).pagina.bloquearMenu();
		}
		if(rec.data['fac_estado_vig']=='Anulado'){
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			
			btn_devfac.disable();
			btn_repfac.disable();
			btn_impfac.enable();
			btn_nulfac.disable();
			btn_revfac.disable();
			_CP.getPagina(layout_factura.getIdContentHijo()).pagina.bloquearMenu();
		}
	}
	
	this.DeselectRow = function(n, n1) {
		CM_DeselectRow(n, n1);
		_CP.getPagina(layout_factura.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout_factura.getIdContentHijo()).pagina.bloquearMenu();
	};
	
	var gestion = new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'gestion',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_gestion',
		tpl:tpl_gestion
	});

	gestion.on('select',function (combo, record, index){
		g_id_gestion = gestion.getValue();
		comp_id_gestion.setValue(gestion.getValue());
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:gestion.getValue()
			}
		});
	});
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_factura.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBotonCombo(gestion,'gestion');
	
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Generar Comprobante de Devengado',btn_devfac,true,'fac_dev','Devengar');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Emitir la Factura',btn_repfac,true,'fac_rep','Facturar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emitir la Factura',prg_repfac,true,'fac_imp','Imprimir');
	this.AdicionarBoton('../../../lib/imagenes/pick-btnrev.png','Revertir la Factura',btn_revfac,true,'fac_rev','Revertir');
	this.AdicionarBoton('../../../lib/imagenes/gtuc/images/grid/drop-no.gif','Anular la Factura',btn_nulfac,true,'fac_nul','Anular');
	
	var CM_getBoton = this.getBoton;
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_factura.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}