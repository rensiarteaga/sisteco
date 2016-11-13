/**
 * Nombre:		  	    pagina_solicitud_fondos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 10:39:24
 */
function pagina_solicitud_fondos(idContenedor,direccion,empleado,paramConfig){
	var Atributos=new Array,sw=0;
	var g_sw_contabilizar,cmb_presupuesto,cmb_depto,cmb_caja,cmb_tipo_solicitud,cmb_estado_avance;
	var dialog;
	var cmb_empleado,cmb_moneda,txt_fecha_avance,txt_importe_avance,cmb_solicitud_compra,cmb_cajero;
	var marcas_html,div_dlgFrm,dlgFrm,cp_caja,cp_cajero,txt_caja,txt_cajero;
	var dev_id_avance,dev_id_empleado,dev_importe,dev_id_moneda;
	var sw=0;
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance/ActionListarSolicitudFondos.php?solicitud_caja=si'}),
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
        'saldo',
        'nro_avance',
        'concepto_avance',
        'observacion_avance',
        'observacion_conta',
        'id_usr_reg'
		]),
		baseParams:{filtro_tipo_solicitud:'2'},
		remoteSort:true});
		
	//DATA STORE COMBOS
      var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id','email1'])
	});
   var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?sw_reg_comp=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	var ds_depto_usu = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php?avance=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto_ep','id_depto','desc_depto','id_ep','desc_ep'])
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
	
	function renderEstado(value, p, record){
		if(value == 1)
		{return "Pendiente"}
		if(value == 2)
		{return "Descargo"}
		if(value == 3)
		{return "Finalizado Validado"}
		if(value == 4)
		{return "Fondo Entregado"}
		if(value == 5)
		{return "Solicitud Contabilizada"}
		if(value == 6)
		{return "Solicitud Validada"}
		if(value == 7)
		{return "Descargo Contabilizado"}
		if(value == 8)
		{return "Descargo Validado"}
		if(value == 9)
		{return "Vale Caja"}
		if(value == 10)
		{return "Finalizado por Caja"}
		if(value == 11)
		{return "Finalización Contabilizada"}
		if(value == 12)
		{return "Finalización Devolución Cheque"}
		if(value == 13)
		{return "Finalización Pendiente"}
		return 'Otro';
	}
	function render_id_depto_usu(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto_usu=new Ext.Template('<div class="search-item">',
		'<b>Departamento: </b><FONT COLOR="#B5A642">{desc_depto}</FONT><BR>',
		'<b>EP: </b><FONT COLOR="#B5A642">{desc_ep}</FONT>',		
		'</div>');
	function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_caja=new Ext.Template('<div class="search-item">',
		'<b>Caja: </b><FONT COLOR="#B5A642">{desc_unidad_organizacional}</FONT><BR>',
		'<b>Depto: </b><FONT COLOR="#B5A642">{nombre_depto}</FONT>',		
		'</div>');
	
	// Definición de datos //
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
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_empleado',
		id_grupo:1
	};
  /*var filterCols_depto=new Array();
  var filterValues_depto=new Array();
  filterCols_depto[0]='DEPEP.id_usuario';
  filterValues_depto[0]=empleado.id_usuario;*/		
  Atributos[2]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc:'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto_usu,
			valueField:'id_depto',
			displayField:'desc_depto',
			queryParam:'filterValue_0',
			filterCol:'DEPTO.nombre_depto',
			/*filterCols:filterCols_depto,
			filterValues:filterValues_depto,*/
			typeAhead:true,
			tpl:tpl_id_depto_usu,
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
			renderer:render_id_depto_usu,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			grid_indice:1		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto',
		save_as:'id_depto',
		id_grupo:0
	};
// txt tipo_avance
	Atributos[3]={
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
		form:false,
		filtro_0:false,
		save_as:'tipo_avance',
		id_grupo:1
	};
// txt fecha_avance
	Atributos[4]= {
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
	Atributos[5]={
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
		filtro_0:true,
		save_as:'avance_solicitud',
		id_grupo:1
	};
// txt estado_avance
	Atributos[6]={
		validacion:{
			name:'estado_avance',
			fieldLabel:'Estado Solicitud',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','Valor'],data:[['1','Pendiente'],['2','Descargo'],['3','Cerrado'],['4','Fondo Entregado'],['5','Solicitud Contabilizada'],['6','Solicitud Validada']]}),
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
		filtro_0:false,
		save_as:'estado_avance',
		defecto:1,
		id_grupo:1
	};	
	
// txt id_moneda
	Atributos[7]={
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
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1
	};
	// txt importe_avance
	Atributos[8]={
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
	Atributos[9]={
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
	Atributos[10]={
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
	Atributos[11]={
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
	Atributos[12]={
			validacion:{
			labelSeparator:'',
			name:'fk_avance',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'fk_avance'
	};
	Atributos[13]={
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
	Atributos[14]={
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
			disabled:true,
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
	Atributos[15]={
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
			width:250		
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
	Atributos[16]={
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
			width:250		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PERSON1.nombre#PERSON1.apellido_paterno#PERSON1.apellido_materno',
		save_as:'id_cajero',
		id_grupo:1
	};
	// txt tipo_avance
	Atributos[17]={
		validacion:{
			name:'nro_avance',
			fieldLabel:'Nro Avance',
			allowBlank:false,
			align:'left', 
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1		
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'AVANCE.nro_avance',
		save_as:'nro_avance',
		id_grupo:1
	};
		// txt tipo_avance
	Atributos[18]={
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
	Atributos[19]={
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
	Atributos[20]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false		
		},
		tipo:'NumberField',
		form:false,
		save_as:'saldo'
	};
	Atributos[21]={
		validacion:{
			name:'observacion_avance',
			fieldLabel:'Observaciones',
			allowBlank:true,
			align:'left', 
			grid_visible:true,
			grid_editable:false,
			grid_indice:1		
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'AVANCE.observacion_avance',
		save_as:'observacion_avance',
		id_grupo:1
	};	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'solicitud_fondos',grid_maestro:'grid-'+idContenedor};
	var layout_solicitud_fondos=new DocsLayoutMaestroEP(idContenedor);
	layout_solicitud_fondos.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_fondos,idContenedor);
	var getSelectionModel=this.getSelectionModel;
    var ClaseMadre_btnActualizar=this.btnActualizar;
    var ClaseMadre_btnEdit=this.btnEdit;
    var ClaseMadre_btnEliminar=this.btnEliminar;
    var ClaseMadre_btnNew=this.btnNew;
    var ClaseMadre_save=this.Save;
    var ClaseMadre_conexionFailure=this.conexionFailure;
    var CM_getComponente=this.getComponente;
    var Cm_getDialog=this.getDialog;
    var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
    var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/avance/ActionEliminarSolicitudFondos.php'},
		Save:{url:direccion+'../../../control/avance/ActionGuardarSolicitudFondos.php'},
		ConfirmSave:{url:direccion+'../../../control/avance/ActionGuardarSolicitudFondos.php'},
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
			titulo:'Solicitud de Fondos'}};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	this.EnableSelect=function(x,z,y){
				enable(x,z,y)	
			}
	
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
		cmb_estado_avance=CM_getComponente('estado_avance');
		g_sw_contabilizar.setVisible(false);
	 	var onCajaSelect=function(e){
			var id=cp_caja.getValue();
			cp_cajero.setValue('');
			cp_cajero.allowBlank=false;
			cp_cajero.filterValues[0]=id;
			cp_cajero.modificado=true
		};
		cp_caja.on('select',onCajaSelect)
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
					    layout_solicitud_fondos.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
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


	function fondo_contabilizado(resp){
		Ext.MessageBox.alert('Estado','Comprobante emitido exitosamente');
	}
	function vale_emitido(resp){
		Ext.MessageBox.alert('Estado','Se generó un vale para devolución en caja');
	}
	function btn_fin_solicitud(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.saldo!=''){
				if(SelectionsRecord.data.saldo < 0){
					if(SelectionsRecord.data.saldo < -1000){
						alert ('Saldo a favor del Solicitante mayor a 1000 seleccione cuenta para emisión de cheque');
						var importe=SelectionsRecord.data.saldo*(-1);
						var data='m_nombre_tabla=tesoro.tts_avance';
					    data=data+'&m_nombre_campo=id_avance';
					    data=data+'&m_id_tabla='+SelectionsRecord.data.id_avance;
					    data=data+'&m_nombre_cheque='+SelectionsRecord.data.desc_empleado;
					    data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					    data=data+'&m_importe_cheque='+importe;
					    data=data+'&m_sw_cuenta_bancaria=true';
					    data=data+'&m_sw_nombre_cheque=false';
					    data=data+'&m_sw_moneda=false';
					    data=data+'&m_sw_importe_cheque=false';
					    data=data+'&m_id_avance='+SelectionsRecord.data.id_avance;
					    data=data+'&m_vista=1';
					    data=data+'&m_tipo_cheque=finaliza';
					    var ParamVentana={Ventana:{width:370,height:255}};
					    layout_solicitud_fondos.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
					}
					else{
						alert ('Saldo a favor del Solicitante menor o igual a 1000 seleccione caja y cajero para devolución');
						var importe=SelectionsRecord.data.saldo*(-1);
						dev_id_avance=SelectionsRecord.data.id_avance;
			             dev_id_empleado=SelectionsRecord.data.id_empleado;			
			             dev_importe=importe;
			             dev_id_moneda=SelectionsRecord.data.id_moneda;
				         dlgFrm.show()		           
					}
				}
				if(SelectionsRecord.data.saldo > 0){					
					alert ('Saldo a favor de la Empresa seleccione cuenta bancaria para efectuar un depósito');
						var importe=SelectionsRecord.data.saldo;
						var data='m_nombre_tabla=tesoro.tts_avance';
					    data=data+'&m_nombre_campo=id_avance';
					    data=data+'&m_id_tabla='+SelectionsRecord.data.id_avance;
					    data=data+'&m_nombre_cheque='+SelectionsRecord.data.desc_empleado;
					    data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					    data=data+'&m_importe_cheque='+importe;
					    data=data+'&m_sw_cuenta_bancaria=true';
					    data=data+'&m_id_avance='+SelectionsRecord.data.id_avance;
					    data=data+'&m_vista=1';
					    data=data+'&m_tipo_cheque=deposito';
					    var ParamVentana={Ventana:{width:370,height:255}};
					    layout_solicitud_fondos.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+data,'Cheques',ParamVentana)
					
				}
				if (SelectionsRecord.data.saldo==0){
					var data='id_avance='+SelectionsRecord.data.id_avance;
				        data=data+'&tipo=2';
				        Ext.Ajax.request({url:direccion+"../../../control/avance/ActionFinalizaPendiente.php",
			    		params:data,
			   			success:finaliza_fondo,
			    		method:'POST',
			    		failure:ClaseMadre_conexionFailure,
			    		timeout:100000});
			    		ClaseMadre_btnActualizar()		
				}			   
			}
			else{
		        Ext.MessageBox.alert('Estado','No se pudo finalizar la solicitud debido a que no se emitió ningun cheque')		
			}			
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar una solicitud.')
	    }
	    ClaseMadre_clearSelections()
	}
	function finaliza_fondo(resp){
		Ext.MessageBox.alert('Estado','Solicitud Finalizada exitosamente');
	}
	function btn_imprimir_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
			if(NumSelect!=0){	
				if(SelectionsRecord.data.estado_avance==6 || SelectionsRecord.data.estado_avance==12){  
					if(SelectionsRecord.data.id_comprobante!=''){
						var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					    data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					    data=data+'&m_id_avance='+SelectionsRecord.data.id_avance;
					    data=data+'&m_estado_avance='+SelectionsRecord.data.estado_avance;   	   			   	   
			            window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
			            window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFReciboEntrega.php?'+data)
					}
					else{	 				
					    Ext.MessageBox.alert('Estado','La solicitud seleccionada no esta validada.')
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


	function crearDialogCaja(){
		marcas_html="<div class='x-dlg-hd'>"+'Devolución por Caja'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:150
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:150,
			width:380,
			height:215			
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);
		dlgFrm.addButton('Generar Vale',genera_devolucion);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		cp_caja=new Ext.form.ComboBox({
			name:'id_caja_0',
			fieldLabel:'Caja',
			allowBlank:false,
			emptyText:'Caja...',
			store:ds_caja,
			filterCol:'UNIORG.nombre_unidad',
			queryParam:'filterValue_0',
			valueField:'id_caja',
			displayField:'desc_unidad_organizacional',
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_caja,
			triggerAction:'all',
			minChars:1,
			mode:'remote',
			width:'60%'
		});
		var filterC_cajero=new Array();
	    var filterV_cajero=new Array();
	        filterC_cajero[0]='CAJERO.id_caja';
	        filterV_cajero[0]='%';
		cp_cajero=new Ext.form.ComboBox({
			name:'id_cajero_0',
			fieldLabel:'Cajero',
			allowBlank:false,
			emptyText:'Cajero...',
			store:ds_cajero,
			filterCol:'PERSON_1.nombre#PERSON_1.apellido_paterno#PERSON_1.apellido_materno',
			queryParam:'filterValue_0',
			filterCols:filterC_cajero,
			filterValues:filterV_cajero,
			valueField:'id_cajero',
			displayField:'desc_empleado',
			typeAhead:true,
			forceSelection:false,
			tpl:tpl_id_cajero,
			triggerAction:'all',
			minChars:1,
			mode:'remote',
			width:'60%'
		});		
		Formulario.fieldset({legend:'Seleccionar Caja/Cajero'},cp_caja,cp_cajero);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	function genera_devolucion(){		
			var sm=getSelectionModel();
			txt_caja=cp_caja.getValue();
			txt_cajero=cp_cajero.getValue();
			dlgFrm.hide();
			var data='id_avance='+dev_id_avance;
			    data=data+'&id_empleado='+dev_id_empleado;			
			    data=data+'&importe_avance='+dev_importe;
			    data=data+'&id_moneda='+dev_id_moneda;
			    data=data+'&id_caja='+txt_caja;			
			    data=data+'&id_cajero='+txt_cajero;
			    data=data+'&tipo=2';
			    Ext.Ajax.request({url:direccion+"../../../control/avance/ActionGuardarValeAvance.php",
			    params:data,
			    success:vale_emitido,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			    ClaseMadre_btnActualizar()
		
		ClaseMadre_clearSelections()
	}		

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_fondos.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Cheque',btn_imprimir_cheque,true,'imprimir_cheque','Cheque');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Fondos',btn_fin_solicitud,true,'fin_fondos','Finalizar');	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Cheque',btn_imprimir_cheque,true,'cheque_devolucion','Cheque para Devolución');
	var CM_getBoton=this.getBoton;
			CM_getBoton('imprimir_cheque-'+idContenedor).disable();
			CM_getBoton('fin_fondos-'+idContenedor).disable();
			CM_getBoton('cheque_devolucion-'+idContenedor).disable();
			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
			        CM_getBoton('imprimir_cheque-'+idContenedor).disable();
			        CM_getBoton('fin_fondos-'+idContenedor).disable();
					  	  	if(record.estado_avance==6){
			               		CM_getBoton('imprimir_cheque-'+idContenedor).enable();
			               	}
			               	else{
			               		CM_getBoton('imprimir_cheque-'+idContenedor).disable();
			               	}
			               	if(record.saldo!='' && record.estado_avance==13){
			               		CM_getBoton('fin_fondos-'+idContenedor).enable();
			               	}
			               	else{
			               		CM_getBoton('fin_fondos-'+idContenedor).disable();
			               	}
			               	if(record.estado_avance==12){
			               		CM_getBoton('cheque_devolucion-'+idContenedor).enable();
			               	}
			               	else{
			               		CM_getBoton('cheque_devolucion-'+idContenedor).disable();
			               	}
				}
				enableSelect(sel,row,selected);				
			}
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	this.iniciaFormulario();
	crearDialogCaja();
	iniciarEventosFormularios();
	layout_solicitud_fondos.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}