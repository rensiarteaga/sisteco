/**
 * Nombre:		  	    pagina_ampliacion_fondos_avance.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
 */
function pagina_ampliacion_fondos_avance(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var g_sw_contabilizar,cmb_presupuesto,cmb_depto,cmb_caja,cmb_tipo_solicitud,txt_tipo_avance;
	var dialog;
	var cmb_empleado,cmb_moneda,txt_fecha_avance,txt_importe_avance,cmb_solicitud_compra,cmb_cajero,txt_fk_avance;
	
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance/ActionListarSolicitudFondos.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_avance',totalRecords:'TotalCount'
		},[		
		'id_avance',
		'id_empleado',		
		'desc_empleado',
		'tipo_avance',
		{name:'fecha_avance',type:'date',dateFormat:'Y-m-d'},
		'importe_avance',
		'estado_avance',
		'id_moneda',
		'nombre_moneda',
		'id_cheque',
		'nro_cheque',
		'id_documento',
		'nro_documento',
		'id_comprobante',
		'nro_comprobante',
		'fk_avance',
        'sw_contabilizar',
        'id_depto',
        'desc_depto',
        'id_caja',
        'desc_unidad_organizacional',
        'id_subsistema',
        'avance_solicitud',
        'id_cajero',
        'desc_cajero',
        'nro_avance',
        'concepto_avance',
        'observacion_conta',
        'id_depto_contabilidad',
        'nombre_depto'
		]),
		baseParams:{filtro_tipo_solicitud:'3'},
		remoteSort:true});
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_avance:maestro.id_avance
		}
	});
	
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[
	['Solicitante',maestro.desc_empleado],
	['Departamento',maestro.desc_depto],
	['Moneda',maestro.nombre_moneda]];
		//DATA STORE COMBOS
      var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
   var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?sw_reg_comp=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	var ds_depto_ep = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto_ep','id_depto','desc_depto','id_ep','desc_ep'])
	});
	var ds_depto_conta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_conta/ActionListarDepartamentoConta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_conta',totalRecords: 'TotalCount'},['id_depto_conta','id_depto','nombre_depto','desc_ep'])
	});
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/caja/ActionListarCaja.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','tipo_caja','id_unidad_organizacional','desc_unidad_organizacional','id_depto','nombre_depto'])
	});
	var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cajero/ActionListarCajero.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','id_empleado','desc_empleado','codigo_empleado_empleado','estado_cajero'])
	});
 	//FUNCIONES RENDER
		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{desc_persona}</I></B></FONT><br>','<FONT COLOR="#B5A642">Email:{email1}</FONT>','</div>');
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{nombre}</I></B></FONT><br>','<FONT COLOR="#B5A642">Simbolo:{simbolo}</FONT>','</div>');
		function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{desc_empleado}</I></B></FONT><br>','</div>');
	
	function renderEstado(value, p, record)
	{
		if(value == 1)
		{return "Pendiente"}
		if(value == 2)
		{return "Descargo"}
		if(value == 3)
		{return "Cerrado"}
		if(value == 4)
		{return "Cheque Emitido"}
		if(value == 5)
		{return "Solicitud Contabilizada"}
		if(value == 6)
		{return "Solicitud Validada"}
		if(value == 7)
		{return "Descargo Contabilizado"}
		if(value == 8)
		{return "Comprometido"}
		return 'Otro';
	}
	function render_id_depto_ep(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto_ep=new Ext.Template('<div class="search-item">',
		'<b>Departamento: </b><FONT COLOR="#B5A642">{desc_depto}</FONT><BR>',
		'<b>Código EP: </b><FONT COLOR="#B5A642">{desc_ep}</FONT>',		
		'</div>');
	function render_id_depto_conta(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto_conta=new Ext.Template('<div class="search-item">',
		'<b>Departamento: </b><FONT COLOR="#B5A642">{nombre_depto}</FONT><BR>',
		'<b>Código EP: </b><FONT COLOR="#B5A642">{desc_ep}</FONT>',		
		'</div>');
	function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_caja=new Ext.Template('<div class="search-item">',
		'<b>Caja: </b><FONT COLOR="#B5A642">{desc_unidad_organizacional}</FONT><BR>',
		'<b>Depto: </b><FONT COLOR="#B5A642">{nombre_depto}</FONT>',		
		'</div>');
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_viatico
// hidden id_avance
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_avance',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_avance'
	};
// txt id_empleado
	Atributos[1]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:true,			
			emptyText:'Empleado...',
			desc:'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto:maestro.id_empleado,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_empleado',
		id_grupo:1
	};	
    Atributos[2]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:true,			
			emptyText:'Departamento...',
			desc:'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto_ep,
			valueField:'id_depto',
			displayField:'desc_depto',
			queryParam:'filterValue_0',
			filterCol:'DEPTO.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto_ep,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto_ep,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		defecto:maestro.id_depto,
		filterColValue:'DEPTO.nombre_depto',
		save_as:'id_depto',
		id_grupo:0
	};
	Atributos[3]={
			validacion:{
			name:'id_depto_conta',
			fieldLabel:'Departamento Contabilidad',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc:'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto_conta,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol:'DEPCON.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto_conta,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto_conta,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'DEPCON.nombre_depto',
		save_as:'id_depto_contabilidad',
		id_grupo:0
	};
// txt tipo_avance
	Atributos[4]={
		validacion:{
			name:'tipo_avance',
			fieldLabel:'Tipo Avance',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false		
		},
		tipo:'NumberField',
		form:true,
		defecto:3,
		filtro_0:false,
		save_as:'tipo_avance',
		id_grupo:1
	};
// txt fecha_avance
	Atributos[5]= {
		validacion:{
			name:'fecha_avance',
			fieldLabel:'Fecha Avance',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			grid_indice:3		
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AVANCE.fecha_avance',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_avance',
		id_grupo:1
	};
// txt tipo_documento
	Atributos[6]={
		validacion:{
			name:'avance_solicitud',
			fieldLabel:'Fondo con Solicitud',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Si'],['2','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			disable:false,
			width:90
		},
		tipo:'ComboBox',
		defecto:2,
		filtro_0:true,
		save_as:'avance_solicitud',
		id_grupo:1
	};
// txt estado_avance
	Atributos[7]={
		validacion:{
			name:'estado_avance',
			fieldLabel:'Estado Solicitud',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','Valor'],data:[['1','Pendiente'],['2','Descargo'],['3','Cerrado'],['4','Cheque Emitído'],['5','Solicitud Contabilizada'],['6','Solicitud Validada']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true
		},
		tipo:'ComboBox',
		form:false,
		filtro_0:false,
		save_as:'estado_avance',
		defecto:1,
		id_grupo:1
	};	
	
// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc:'nombre_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:150,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form:true,
		defecto:maestro.id_moneda,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1
	};
	// txt importe_avance
	Atributos[9]={
		validacion:{
			name:'importe_avance',
			fieldLabel:'Importe Avance',
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
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:5		
		},
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'AVANCE.importe_avance',
		save_as:'importe_avance',
		id_grupo:1
	};
// txt id_cheque
	Atributos[10]={
			validacion:{
			name:'id_cheque',
			fieldLabel:'Número de Cheque',
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:false,
			grid_editable:false		
		},
		tipo:'Field',
		form:false,
		filtro_0:false,
		save_as:'id_cheque',
		id_grupo:1
	};
// txt id_documento
	Atributos[11]={
			validacion:{
			name:'id_documento',
			fieldLabel:'Documento',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:false,
		save_as:'id_documento',
		id_grupo:1
	};
// txt id_comprobante
	Atributos[12]={
			validacion:{
			name:'id_comprobante',
			fieldLabel:'Comprobante',
			allowBlank:true,			
			minChars:0, ///caracteres mínimos requeridos para iniciar la busqueda
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:true,
		filtro_0:false,
		save_as:'id_comprobante',
		id_grupo:2
	};
// txt fk_avance
	Atributos[13]={
			validacion:{
			labelSeparator:'',
			name:'fk_avance',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		defecto:maestro.id_avance,
		filtro_0:false,
		save_as:'fk_avance'
	};
	Atributos[14]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'Contabilizar',
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
		tipo:'NumberField',
		form:true,
		save_as:'sw_contabilizar',
		id_grupo:2
	};
	// txt tipo_documento
	Atributos[15]={
		validacion:{
			name:'tipo_solicitud',
			fieldLabel:'Entrega en',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Efectivo'],['2','Cheque']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			disable:false,
			width:150
		},
		tipo:'ComboBox',
		filtro_0:false,
		save_as:'tipo_solicitud',
		id_grupo:1
	};
	// txt id_depto
    var filterCols_caja=new Array();
	var filterValues_caja=new Array();
	filterCols_caja[0]='depto.id_depto';
	filterValues_caja[0]='%';
	Atributos[16]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:true,			
			emptyText:'Caja...',
			desc:'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField:'id_caja',
			displayField:'desc_unidad_organizacional',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			filterCols:filterCols_caja,
			filterValues:filterValues_caja,
			typeAhead:true,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_caja',
		id_grupo:1
	};
	var filterCols_cajero=new Array();
	var filterValues_cajero=new Array();
	filterCols_cajero[0]='CAJERO.id_caja';
	filterValues_cajero[0]='%';
	Atributos[17]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:true,			
			emptyText:'Cajero...',
			desc:'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField:'id_cajero',
			displayField:'desc_empleado',
			queryParam:'filterValue_0',
			filterCol:'PERSON_1.nombre#PERSON_1.apellido_paterno#PERSON_1.apellido_materno',
			filterCols:filterCols_cajero,
			filterValues:filterValues_cajero,
			typeAhead:true,
			tpl:tpl_id_cajero,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:250,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PERSON1.nombre#PERSON1.apellido_paterno#PERSON1.apellido_materno',
		save_as:'id_cajero',
		id_grupo:1
	};
		// txt tipo_avance
	Atributos[18]={
		validacion:{
			name:'nro_avance',
			fieldLabel:'Nro Avance',
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
			grid_indice:1		
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'AVANCE.nro_avance',
		save_as:'nro_avance',
		id_grupo:1
	};
		// txt tipo_avance
	Atributos[19]={
		validacion:{
			name:'concepto_avance',
			fieldLabel:'Concepto Avance',
			allowBlank:false,
			align:'left', 
			grid_visible:true,
			grid_editable:false,
			grid_indice:1		
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'AVANCE.concepto_avance',
		save_as:'concepto_avance',
		id_grupo:1
	};
	Atributos[20]={
		validacion:{
			name:'observacion_conta',
			fieldLabel:'Observación Contabilidad',
			allowBlank:true,
			align:'left', 
			grid_visible:true,
			grid_editable:false
		},
		tipo:'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'AVANCE.observacion_conta'		
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE

	var config={titulo_maestro:'Fondos en Avance (Maestro)',titulo_detalle:'Ampliación de Fondos en Avance (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_ampliacion_fondos_avance=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_ampliacion_fondos_avance.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_ampliacion_fondos_avance,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var Cm_getDialog=this.getDialog;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));//IMPORTANTE
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/avance/ActionEliminarSolicitudFondos.php',parametros:'&m_id_avance='+maestro.id_avance},
		Save:{url:direccion+'../../../control/avance/ActionGuardarSolicitudFondos.php',parametros:'&m_id_avance='+maestro.id_avance},
		ConfirmSave:{url:direccion+'../../../control/avance/ActionGuardarSolicitudFondos.php',parametros:'&m_id_avance='+maestro.id_avance},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:300,
			columnas:['95%'],
			grupos:[
			{tituloGrupo:'Departamento',columna:0,id_grupo:0},
			{tituloGrupo:'Datos',columna:0,id_grupo:1},
			{tituloGrupo:'Oculto',columna:0,id_grupo:2}],			
			width:520,
			minWidth:150,
			minHeight:200,	
			closable:true,
			titulo:'Ampliación de Solicitud de Fondos'}};	
	function MaestroJulio(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
	return html
	};			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_avance=datos.m_id_avance;
		maestro.id_empleado=datos.m_id_empleado;
		maestro.desc_empleado=datos.m_desc_empleado;
		maestro.id_depto=datos.m_id_depto;
		maestro.desc_depto=datos.m_desc_depto;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.nombre_moneda=datos.m_nombre_moneda;		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_avance:maestro.id_avance
			}
		};		
		Atributos[2].defecto=maestro.id_depto;
		Atributos[1].defecto=maestro.id_empleado;
		Atributos[8].defecto=maestro.id_moneda;
		Atributos[13].defecto=maestro.id_avance;
		this.btnActualizar();
		data_maestro=[['Solicitante',maestro.desc_empleado],
	                 ['Departamento',maestro.desc_depto],
	                 ['Moneda',maestro.nombre_moneda]];		
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		paramFunciones.btnEliminar.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.Save.parametros='&m_id_avance='+maestro.id_avance;
		paramFunciones.ConfirmSave.parametros='&m_id_avance='+maestro.id_avance;
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
//Para manejo de eventos
	this.EnableSelect=function(x,z,y){
				enable(x,z,y)	
			};
	
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario	
	     dialog=Cm_getDialog();	    
		g_sw_contabilizar= CM_getComponente('sw_contabilizar');
		cmb_depto=CM_getComponente('id_depto');
		cmb_caja=CM_getComponente('id_caja');
		cmb_tipo_solicitud=CM_getComponente('tipo_solicitud');
		cmb_empleado=CM_getComponente('id_empleado');
		cmb_moneda=CM_getComponente('id_moneda');
		txt_fecha_avance=CM_getComponente('fecha_avance');
		txt_importe_avance=CM_getComponente('importe_avance');
		txt_avance_solicitud=CM_getComponente('avance_solicitud');
		cmb_cajero=CM_getComponente('id_cajero');
		txt_tipo_avance=CM_getComponente('tipo_avance');
		txt_fk_avance=CM_getComponente('fk_avance');
	 	g_sw_contabilizar.setVisible(false);
	 	var onDepartamentoSelect=function(e){
			var id=cmb_depto.getValue();
			cmb_caja.setValue('');
			cmb_caja.allowBlank=true;
			cmb_caja.filterValues[0]=id;
			cmb_caja.modificado=true
		};
		var onTipoSolicitudSelect=function(e){
			var id=cmb_tipo_solicitud.getValue();
			cmb_caja.setValue('');
			if(id==1){
				CM_mostrarComponente(cmb_caja);
				CM_mostrarComponente(cmb_cajero);
				cmb_caja.allowBlank=false;
				cmb_cajero.allowBlank=false
			}
			if(id==2){
				CM_ocultarComponente(cmb_caja);
				CM_ocultarComponente(cmb_cajero);
				cmb_caja.allowBlank=true;
				cmb_cajero.allowBlank=true
			}			
		};	
		var onCajaSelect=function(e){
			var id=cmb_caja.getValue();
			cmb_cajero.setValue('');
			cmb_cajero.allowBlank=false;
			cmb_cajero.filterValues[0]=id;
			cmb_cajero.modificado=true
		};
		var onAvanceSolicitudSelect=function(e){
			var id=txt_avance_solicitud.getValue();
			if(id==1){
				cmb_moneda.setValue('');
				txt_importe_avance.setValue('');
				cmb_moneda.disable();
				txt_importe_avance.disable()
			}
			else{
				cmb_moneda.setValue('');
				txt_importe_avance.setValue('');
				cmb_moneda.enable();
				txt_importe_avance.enable()
			}
		};
		cmb_caja.on('select',onCajaSelect);
		cmb_depto.on('select',onDepartamentoSelect);
		cmb_tipo_solicitud.on('select',onTipoSolicitudSelect)
		txt_avance_solicitud.on('select',onAvanceSolicitudSelect)	
	}	
	function btn_emite_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
			if(NumSelect!=0){				
				if(SelectionsRecord.data.id_cheque!=''){
	               Ext.MessageBox.alert('Estado','Ya se emitió un cheque para la solicitud seleccionada.')				
				}
				else{				
					if(SelectionsRecord.data.importe_avance >0)
					{
		             	var data='m_nombre_tabla=tesoro.tts_avance';
					    data=data+'&m_nombre_campo=id_avance';
					    data=data+'&m_id_tabla='+SelectionsRecord.data.id_avance;
					    data=data+'&m_nombre_cheque='+SelectionsRecord.data.desc_empleado;
					    data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					    data=data+'&m_importe_cheque='+SelectionsRecord.data.importe_avance;
					    data=data+'&m_sw_cuenta_bancaria=true';
					    data=data+'&m_sw_nombre_cheque=false';
					    data=data+'&m_sw_moneda=false';
					    data=data+'&m_sw_importe_cheque=false';
					    data=data+'&m_id_avance='+SelectionsRecord.data.id_avance;
					    data=data+'&m_vista=1';
					    data=data+'&m_tipo_cheque=solicitud';
					    var ParamVentana={Ventana:{width:370,height:255}};
					    layout_ampliacion_fondos_avance.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
					}
					else
					{		 				
					    Ext.MessageBox.alert('Estado','El importe del Fondo en Avance debe ser mayor a 0')
					}			
				}				
			}
			else
			{
				Ext.MessageBox.alert('Estado','Debe seleccionar una solicitud.')
		    }
		}
	function btn_vale_caja(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.importe_avance >0){
				
			    var data='id_avance='+SelectionsRecord.data.id_avance;
			    data=data+'&id_empleado='+SelectionsRecord.data.id_empleado;			
			    data=data+'&importe_avance='+SelectionsRecord.data.importe_avance;
			    data=data+'&id_moneda='+SelectionsRecord.data.id_moneda;
			    data=data+'&id_caja='+SelectionsRecord.data.id_caja;			
			    data=data+'&id_cajero='+SelectionsRecord.data.id_cajero;
			    Ext.Ajax.request({url:direccion+"../../../control/avance/ActionGuardarValeAvance.php",
			    params:data,
			    success:vale_emitido,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			  // Ext.MessageBox.alert('Estado','Vale de Caja emitido con éxito');
			    ClaseMadre_btnActualizar()
			}
			else{
		        Ext.MessageBox.alert('Estado','El importe del Fondo en Avance debe ser mayor a 0')		
			}			
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
	    }
	    ClaseMadre_clearSelections()
	}
	function vale_emitido(resp){
		Ext.MessageBox.alert('Estado','Vale de Caja emitido con éxito');
	}
	function btn_imprimir_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
			if(NumSelect!=0){	
				if(SelectionsRecord.data.estado_avance==6){  
					if(SelectionsRecord.data.id_comprobante!=''){
						var data='m_id_moneda='+SelectionsRecord.data.id_moneda;
						data=data+'&m_id_cheque='+SelectionsRecord.data.id_cheque;
						data=data+'&m_estado_avance='+SelectionsRecord.data.estado_avance;
						data=data+'&m_id_avance='+SelectionsRecord.data.id_avance;									       
						window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);	
					    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFReciboEntrega.php?'+data)				                   	
					}
					else{	 				
					    Ext.MessageBox.alert('Estado','La solicitud seleccionada no esta contabilizada.')
					}
				}	
				else
				{	
					Ext.MessageBox.alert('Estado','Solo registros en estado Solicitud Validada')				
				}				
			}
			else
			{
				Ext.MessageBox.alert('Estado','Debe seleccionar una solicitud.')
		    }
		}
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.id_cheque!=''){
			   Ext.MessageBox.alert('Estado','No se puede editar la solicitud porque ya se emitió un cheque para la solicitud seleccionada.')
			}
			else{
				if(SelectionsRecord.data.id_caja >=1){
					cmb_tipo_solicitud.setValue(1);
					CM_mostrarComponente(cmb_caja);
					CM_mostrarComponente(cmb_cajero);
				    ClaseMadre_btnEdit()
				}
				else{
					cmb_tipo_solicitud.setValue(2);
					CM_ocultarComponente(cmb_caja);
					CM_ocultarComponente(cmb_cajero);
				    ClaseMadre_btnEdit()
				}
				
			}
		 }
		 else
		   {	
		   	 Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una solicitud.')
		   }
	 }
	 this.btnNew=function(){
          CM_ocultarComponente(cmb_caja);
          CM_ocultarGrupo('Departamento');
          CM_ocultarGrupo('Oculto');
          CM_ocultarComponente(cmb_empleado);		
		  CM_ocultarComponente(cmb_moneda);
		  CM_ocultarComponente(txt_tipo_avance);
		  CM_ocultarComponente(txt_avance_solicitud);
		  CM_mostrarComponente(txt_fecha_avance);
		  CM_mostrarComponente(txt_importe_avance);
		  CM_ocultarComponente(cmb_cajero);
           	ClaseMadre_btnNew()			 
	 }
	 
	 this.btnEliminar=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.id_cheque!=''){
			   Ext.MessageBox.alert('Estado','No se puede eliminar la solicitud porque ya se emitió un cheque para la solicitud seleccionada.')
			}
			else{
				ClaseMadre_btnEliminar()
			}
		 }
		 else
		   {	
		   	 Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una solicitud.')
		   }
	 }
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_ampliacion_fondos_avance.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Vale de Caja',btn_vale_caja,true,'vale_caja','Vale de Caja');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Contabilizar/Emitir Cheque',btn_emite_cheque,true,'cheque','Contabilizar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Inprimir Cheque',btn_imprimir_cheque,true,'imprimir_cheque','Imprimir Cheque');
	var CM_getBoton=this.getBoton;
			CM_getBoton('vale_caja-'+idContenedor).disable();
			CM_getBoton('cheque-'+idContenedor).disable();
			CM_getBoton('imprimir_cheque-'+idContenedor).disable();
			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
			        if(record.id_caja >=1){
			        	  CM_getBoton('vale_caja-'+idContenedor).enable();
			        	  CM_getBoton('cheque-'+idContenedor).disable();
			              CM_getBoton('imprimir_cheque-'+idContenedor).disable();					
			             }
			           else{
			           	  CM_getBoton('vale_caja-'+idContenedor).disable();
			           	  if(record.estado_avance==1){
			               	CM_getBoton('cheque-'+idContenedor).enable();
			               }
			               else{
			               	CM_getBoton('cheque-'+idContenedor).disable();
			               }
			               if(record.estado_avance==6){
			               		CM_getBoton('imprimir_cheque-'+idContenedor).enable();
			               	}
			               	else{
			               		CM_getBoton('imprimir_cheque-'+idContenedor).disable();
			               	}
			             }
					

				}
				enableSelect(sel,row,selected);				
			}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_ampliacion_fondos_avance.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}