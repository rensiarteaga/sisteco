function pagina_planilla_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;
	
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/planilla/ActionListarConsultores.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cotizacion',totalRecords:'TotalCount'
		},[
		'id_cotizacion',
		'desc_proveedor',
		'num_os',
		'codigo_proceso',
		'observaciones','num_sol','prox_pago',
		{name: 'fecha_prox_pago',type:'date',dateFormat:'Y-m-d'},'id_planilla','nro_contrato','id_plan_pago','monto',
		{name: 'fecha_pagado',type:'date',dateFormat:'Y-m-d'},
		'tipo_plantilla','num_factura',
		{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},
		'desc_plantilla','id_moneda',
		'nit','desc_moneda','tipo','id_documento',
		'por_anticipo',
		'por_retgar',
		'multas',
		'id_cuenta_bancaria',
		'cuenta_bancaria',
		'tipo_cheque',
		'monto_a_pagar',
		'nro_cuenta_proveedor'
		]),remoteSort:true
	});

	var ds_consultor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/planilla/ActionListarConsultores.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion',totalRecords: 'TotalCount'},['id_cotizacion','desc_proveedor','num_os','codigo_proceso','prox_pago','id_plan_pago','por_anticipo','por_retgar'])});
	
	var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','desc_plantilla'])});

	//FUNCIONES RENDER
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
		['id_cuenta_bancaria','id_institucion','desc_institucion'
		,'id_cuenta','desc_cuenta','id_auxiliar'
		,'desc_auxiliar','nro_cheque','estado_cuenta'
		,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
		]),baseParams:{m_sw_combo:'combo'}});			
		
	function render_transaccion(value, p, record){	
		if(value=='transferencia'){return 'TRANSFERENCIA';}
		if(value=='cheque'){return 'CHEQUE';}		
		}	
		
	function render_id_cuenta_bancaria(value, p, record){rf = ds_cuenta_bancaria.getById(value);
		if(rf!=null){record.data['cuenta_bancaria'] =rf.data['nro_cuenta_banco'];}
			return String.format('{0}', record.data['cuenta_bancaria']);
		}
	
	var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">',
		'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>',
		'</div>');
	
	function render_consultor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	var tpl_consultor=new Ext.Template('<div class="search-item">','<b><i>Proceso: {codigo_proceso}</i></b>','<br><FONT COLOR="#B5A642"><b>Nï¿½ OS: </b>{num_os}</FONT>','<br><b><i>Consultor:{desc_proveedor}</i></b>','<br><FONT COLOR="#B5A642"><b>Nï¿½ Pago: </b>{prox_pago}</FONT>','</div>');

	function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b>{desc_plantilla}</b>','</div>');

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
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
			name:'id_cotizacion',
			fieldLabel:'Consultor',
			allowBlank:false,
			emptyText:'Consultor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_consultor,
			valueField: 'id_cotizacion',
			displayField: 'desc_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'prov.desc_proveedor#PLA.nro_cuota#p.codigo_proceso',
			typeAhead:false,
			tpl:tpl_consultor,
			forceSelection:true,
			mode:'remote',
			queryDelay:120,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_consultor,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:300,
			disabled:true,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'prov.desc_proveedor'
	};
	
	Atributos[2]={
		validacion:{
			labelSeparator:'',
			name: 'id_planilla',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name: 'num_os',
			fieldLabel:'Orden Servicio',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
		
	};
	
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name: 'codigo_proceso',
			fieldLabel:'Proceso',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name: 'nro_contrato',
			fieldLabel:'Nº Contrato',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			align:'left'
		},
		tipo: 'Field',
		form:false,
		filtro_0:false			
	};

	Atributos[6]={
		validacion:{
			name: 'prox_pago',
			fieldLabel:'Nº Pago',
			//inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			align:'right',
			disabled:true,
			width:100
		},
		tipo: 'TextField',
		filtro_0:false,
		form:true,	
	};
			
	Atributos[7]={
		validacion:{
			labelSeparator:'',
			name: 'monto',
			fieldLabel:'Importe Pago',
			inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			align:'right'
		},
		tipo: 'Field',
		form:false,
		filtro_0:false	
	};
	
	 Atributos[8]= {
		validacion:{
			name:'fecha_pagado',
			fieldLabel:'Fecha de Pago',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			width:100
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PLANIL.fecha_planilla',
		dateFormat:'m-d-Y',
		defecto:''
	};
	
	var fCol=new Array();
	var fVal=new Array();
	fCol[0]='PLANT.sw_compro';
	fVal[0]='1';
	
	Atributos[9]={
		validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Documento',
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
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_tipo_plantilla,
			grid_visible:true,
			grid_editable:false,
			disabled:false,
			width_grid:100,
			width:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PLANPA.tipo_plantilla'
	};
	
	Atributos[10]={
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
			disabled:false,
			width:100
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'plapag.num_factura'	
	};
	 
	Atributos[11]= {
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
			width_grid:85,
			disabled:false,
			width:100
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'PLANIL.fecha_planilla',
		dateFormat:'m-d-Y',
		defecto:''
	};

	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	Atributos[13]={
		validacion:{
			name:'por_anticipo',
			fieldLabel:'% Adelanto',
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
			disabled:true,
			width:150,
			align:'right'
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'plapag.por_anticipo'
	};
	
	Atributos[14]={
		validacion:{
			name:'por_retgar',
			fieldLabel:'% Garantia',
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
			disabled:false,
			width:150,
			align:'right'
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'plapag.por_retgar'
		};
 
	Atributos[15]={
		validacion:{
			name:'multas',
			fieldLabel:'Monto Multa',
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
			disabled:false,
			width:150,
			renderer: render_total,
			align:'right'
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'plapag.multas'
	};
	// txt id_cuenta_bancaria 
	Atributos[16]={
		validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,			
			emptyText:'Cuenta Bancaria...',
			desc: 'cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA_8.nro_cuenta#CUENTA_8.descripcion##CUEBAN_8.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};

	Atributos[17]={
		validacion:{
			name:'tipo_cheque',
			fieldLabel:'Transacción',
			allowBlank:true,
			align:'left', 
			emptyText:'Transacci...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['transferencia','TRANSFERENCIA'],['cheque','CHEQUE']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_transaccion,
			grid_editable:true,
			width_grid:100,
			minListWidth:200,
			width:150,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'tipo_cheque'
	};

	Atributos[18]={
		validacion:{
			name:'monto_a_pagar',
			fieldLabel:'Monto a Pagar',
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
			disabled:false,
			width:202,
			renderer: render_total,
			align:'right'
		},
		tipo: 'NumberField',
		form: false,
		defecto:0,
		filtro_0:true,
		filterColValue:'plapag.monto_a_pagar'
	};
	
	Atributos[19]={
		validacion:{
			name:'nro_cuenta_proveedor',
			fieldLabel:'Cuenta Proveedor',
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
			disabled:false,
			width:202
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'proCtaBco.nro_cuenta_proveedor'
	};

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Detalle - Planilla',grid_maestro:'grid-'+idContenedor};
	layout_planilla_det= new DocsLayoutMaestro(idContenedor);
	layout_planilla_det.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_planilla_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={editar:{crear:true,separador:false},
					guardar:{crear:true,separador:true},
					actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIï¿½N DE FUNCIONES
	 var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/planilla/ActionEliminarPlanillaDet.php'},
		Save:{url:direccion+'../../../control/planilla/ActionGuardarPlanillaDet.php'},
		ConfirmSave:{url:direccion+'../../../control/planilla/ActionGuardarPlanillaDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:430,width:500,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Detalle de Pagos',
			grupos:[{
				tituloGrupo:'Datos de Pago',
					columna:0,
					id_grupo:0
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
				en_planilla:'si',
				m_id_planilla:maestro.id_planilla
			}
		};
		
		this.btnActualizar();
		
		ds_consultor.baseParams={
			m_id_planilla:maestro.id_planilla,
			m_id_depto_tesoro:maestro.id_depto_tesoro
		}
		
		Atributos[2].defecto=maestro.id_planilla;
		
		paramFunciones.btnEliminar.parametros='&m_id_planilla='+maestro.id_planilla+'&m_id_depto_tesoro='+maestro.id_depto_tesoro;
		paramFunciones.ConfirmSave.parametros='&m_id_planilla='+maestro.id_planilla+'&m_id_depto_tesoro='+maestro.id_depto_tesoro;
		paramFunciones.Save.parametros='&m_id_planilla='+maestro.id_planilla;
	 
		this.InitFunciones(paramFunciones)
	};

	ds.lastOptions={
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			en_planilla:'si'
	}};
	 
	function btn_doc_editar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){		
			var SelectionsRecord=sm.getSelected();
			var data='m_nombre_tabla=compro.tad_plan_pago';
			data=data+'&m_nombre_campo=id_plan_pago';
			data=data+'&m_id_plan_pago='+SelectionsRecord.data.id_plan_pago;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			
			if(SelectionsRecord.data.id_documento>0){
				data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
				data=data+'&m_nuevo=no';
			}else{
				data=data+'&m_id_documento=0';
				data=data+'&m_nuevo=si';
			}
			
			data=data+'&m_importe='+SelectionsRecord.data.monto;
			data=data+'&m_tipo_documento='+SelectionsRecord.data.tipo_plantilla;
			data=data+'&m_nit='+SelectionsRecord.data.nit;
			data=data+'&m_razon_social='+SelectionsRecord.data.desc_proveedor;
			data=data+'&m_compro=si';
			data=data+'&m_desc_plantilla='+SelectionsRecord.data.desc_plantilla;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_tipo='+SelectionsRecord.data.tipo;
			data=data+'&m_tipo_doc_fijo=si';
			data=data+'&id_plan_pago='+SelectionsRecord.data_id_plan_pago;
			
			var ParamVentana={Ventana:{width:900,height:400}};
			layout_planilla_det.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
		}
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_planilla_det.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	//para agregar botones

	this.AdicionarBoton('../../../lib/imagenes/copy.png','<b>Editar</b>',btn_doc_editar,false,'documento','Datos de Documento');

	layout_planilla_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}