function pagina_repeje_inversion(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_repeje_inversion;
	var ContPes = 1;
	var vectorAtributos = new Array;
	
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	var g_admi;
	
	var comp_id_parametro, comp_id_tipo_pres, comp_fecha_ini, comp_fecha_fin, comp_id_moneda, comp_desc_moneda, comp_desc_gestion, comp_desc_tipo_pres, comp_desc_partida;
	var comp_sw_vista, comp_sw_ejecuta, comp_sw_filtro, comp_sw_mes, comp_sw_trim, comp_sw_nivel, comp_sw_impre, comp_sw_eplis, comp_sw_cplis, comp_id_partida;
	
	var comp_sw_ppto, comp_sw_cprog, comp_ids_ppto, comp_ids_cprog;
	var comp_sw_ep_fina, comp_sw_ep_regi, comp_sw_ep_prog, comp_sw_ep_proy, comp_sw_ep_acti, comp_sw_ep_uo;
	var comp_sw_cp_prog, comp_sw_cp_proy, comp_sw_cp_acti, comp_sw_cp_fuen, comp_sw_cp_orga;
	
	var comp_ids_ep_fina, comp_ids_ep_regi, comp_ids_ep_prog, comp_ids_ep_proy, comp_ids_ep_acti, comp_ids_ep_uo;
	var comp_ids_cp_prog, comp_ids_cp_proy, comp_ids_cp_acti, comp_ids_cp_fuen, comp_ids_cp_orga;
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_ppto = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});

	var ds_ep_fina = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_prog = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_proy = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_acti = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_uo = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	
	ds_parametro.load();
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro = new Ext.Template('<div class="search-item">','<b>{gestion_pres}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_ppto(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ppto = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	function render_ep_fina(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_fina = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');

	function render_ep_prog(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_prog = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_ep_proy(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_proy = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_ep_acti(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_acti = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_ep_uo(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_uo = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			name: 'sw_ejecuta',
			fieldLabel:'Ejecución',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Acumulada - Gestiones'],['2','Acumulada - Vigente'],['3','Proyecto - Mensual'],
			                                                            ['4','Proyecto - Resumen'],['5','Fuente Finan. - Mensual'],['6','Fuente Finan. - Resumen'],
			                                                            ['7','Anual - Proyecto'],['8','Anual - Fuente Finan.'],['9','Anual - Resumen']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:0,			
		save_as:'sw_ejecuta'
	};
	
	vectorAtributos[1]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_parametro,
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
			renderer:render_id_parametro,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	vectorAtributos[2]={
		validacion:{
			name: 'sw_filtro',
			fieldLabel:'Consultar por',
			allowBlank:false,
			emptyText:'Sel...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','Presupuesto'],['2','Proyecto']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',
		id_grupo:0,
		save_as:'sw_filtro'
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'sw_ppto',
			fieldLabel:'Opción',
			allowBlank:false,
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PPTO(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:2,
		save_as:'sw_ppto'
	};	

	vectorAtributos[4]={
		validacion:{
			name:'ids_ppto',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ppto,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ppto,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ppto,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:2,
 		form: true
	};

	vectorAtributos[5]={
		validacion:{
			name:'sw_ep_fina',
			fieldLabel:'Financiador',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar FIN(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		save_as:'sw_ep_fina'
	};	

	vectorAtributos[6]={
		validacion:{
			name:'ids_ep_fina',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_fina,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_fina,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_fina,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'sw_ep_prog',
			fieldLabel:'Programa',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROG(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		save_as:'sw_ep_prog'
	};	

	vectorAtributos[8]={
		validacion:{
			name:'ids_ep_prog',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_prog,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_prog,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_prog,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'sw_ep_proy',
			fieldLabel:'Proyecto',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROY(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		save_as:'sw_ep_proy'
	};	

	vectorAtributos[10]={
		validacion:{
			name:'ids_ep_proy',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_proy,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_proy,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_proy,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
	
	vectorAtributos[11]={
		validacion:{
			name:'sw_ep_acti',
			fieldLabel:'Actividad',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar ACT(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		save_as:'sw_ep_acti'
	};	

	vectorAtributos[12]={
		validacion:{
			name:'ids_ep_acti',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_acti,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_acti,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_acti,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
					
	vectorAtributos[13]={
		validacion:{
			name:'sw_ep_uo',
			fieldLabel:'U.O.',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar U.O.(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		save_as:'sw_ep_uo'
	};	

	vectorAtributos[14]={
		validacion:{
			name:'ids_ep_uo',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_uo,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_uo,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_uo,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
	
	vectorAtributos[15]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		id_grupo:4,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	vectorAtributos[16]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['CD','PDF - c/Detalle Consulta'],['SD','PDF - s/Detalle Consulta']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:4,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[17] = {
		validacion : {
			name :'fecha_fin',
			fieldLabel :'Fecha Final:',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo:1,
		tipo :'DateField',
		save_as :'fecha_fin',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[18] = {
		validacion : {
			labelSeparator :'',
			name :'desc_moneda',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[19] = {
		validacion : {
			labelSeparator :'',
			name :'desc_gestion',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[20] = {
		validacion : {
			labelSeparator :'',
			name :'sw_vista',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_repeje_inversion = new DocsLayoutProceso(idContenedor);
	layout_repeje_inversion.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_repeje_inversion, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_conexionFailure = this.conexionFailure;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var CM_getComponente=this.getComponente;
	var CM_getSelectionModel=this.getSelectionModel;
	var CM_htmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		comp_sw_vista = CM_getComponente('sw_vista');
		comp_sw_ejecuta = CM_getComponente('sw_ejecuta');
		comp_id_parametro = CM_getComponente('id_parametro');
		comp_fecha_fin = CM_getComponente('fecha_fin');
		comp_id_moneda = CM_getComponente('id_moneda');
		comp_desc_moneda = CM_getComponente('desc_moneda');
		comp_desc_gestion = CM_getComponente('desc_gestion');
		comp_sw_filtro = CM_getComponente('sw_filtro');
		
		comp_sw_ppto = CM_getComponente('sw_ppto');
		comp_sw_ep_fina = CM_getComponente('sw_ep_fina');
		comp_sw_ep_prog = CM_getComponente('sw_ep_prog');
		comp_sw_ep_proy = CM_getComponente('sw_ep_proy');
		comp_sw_ep_acti = CM_getComponente('sw_ep_acti');
		comp_sw_ep_uo = CM_getComponente('sw_ep_uo');
		
		comp_ids_ppto = CM_getComponente('ids_ppto');
		comp_ids_ep_fina = CM_getComponente('ids_ep_fina');
		comp_ids_ep_prog = CM_getComponente('ids_ep_prog');
		comp_ids_ep_proy = CM_getComponente('ids_ep_proy');
		comp_ids_ep_acti = CM_getComponente('ids_ep_acti');
		comp_ids_ep_uo = CM_getComponente('ids_ep_uo');
		
		comp_id_parametro.on('select',f_evento_parametro);	
		comp_id_moneda.on('select',f_evento_id_moneda);	
		comp_sw_filtro.on('select',f_evento_sw_filtro);
		
		comp_sw_ppto.on('select',f_evento_sw_ppto);
		comp_sw_ep_fina.on('select',f_evento_sw_ep_fina);
		comp_sw_ep_prog.on('select',f_evento_sw_ep_prog);
		comp_sw_ep_proy.on('select',f_evento_sw_ep_proy);
		comp_sw_ep_acti.on('select',f_evento_sw_ep_acti);
		comp_sw_ep_uo.on('select',f_evento_sw_ep_uo);
	
		comp_sw_ejecuta.on('select',f_evento_sw_ejecuta);
		
		comp_sw_vista.setValue(sw_vista);
		
		CM_ocultarGrupo('Hidden');
		
		g_admi = 'IN';
		
		limpiar_componentes();
	}
	
	function limpiar_componentes(){
		CM_ocultarGrupo('Presupuesto');
		CM_ocultarGrupo('Proyecto');
		
		comp_sw_ppto.allowBlank=true;
		comp_sw_ep_proy.allowBlank=true;
		comp_sw_ep_fina.allowBlank=true;
		comp_sw_ep_prog.allowBlank=true;
		comp_sw_ep_proy.allowBlank=true;
		comp_sw_ep_acti.allowBlank=true;
		comp_sw_ep_uo.allowBlank=true;
		
		comp_sw_ppto.setValue('todos');
		comp_sw_ep_proy.setValue('todos');
		comp_sw_ep_fina.setValue('todos');
		comp_sw_ep_prog.setValue('todos');
		comp_sw_ep_proy.setValue('todos');
		comp_sw_ep_acti.setValue('todos');
		comp_sw_ep_uo.setValue('todos');
		
		CM_ocultarComponente(comp_ids_ppto);
		CM_ocultarComponente(comp_ids_ep_fina);
		CM_ocultarComponente(comp_ids_ep_prog);
		CM_ocultarComponente(comp_ids_ep_proy);
		CM_ocultarComponente(comp_ids_ep_acti);
		CM_ocultarComponente(comp_ids_ep_uo);
		
		comp_ids_ppto.allowBlank=true;
		comp_ids_ep_fina.allowBlank=true;
		comp_ids_ep_prog.allowBlank=true;
		comp_ids_ep_proy.allowBlank=true;
		comp_ids_ep_acti.allowBlank=true;
		comp_ids_ep_uo.allowBlank=true;
		
		comp_ids_ppto.setValue('');
		comp_ids_ep_fina.setValue('');
		comp_ids_ep_prog.setValue('');
		comp_ids_ep_proy.setValue('');
		comp_ids_ep_acti.setValue('');
		comp_ids_ep_uo.setValue('');
	}
	
	function f_evento_sw_ejecuta(combo, record, index){
		limpiar_componentes();
		
		comp_id_parametro.setValue('');
		comp_sw_filtro.setValue('');
		
		comp_fecha_fin.allowBlank=true;
		comp_fecha_fin.setValue('');
	}
	
	function f_evento_parametro(combo, record, index){	
		var intGestion = record.data.gestion_pres;
		var dte_fecha_ini_valid = new Date('01/01/'+intGestion+' 00:00:00');
		var dte_fecha_fin_valid = new Date('12/31/'+intGestion+' 00:00:00');
			
		//Aplica la validación en la fecha
		comp_fecha_fin.minValue = dte_fecha_ini_valid;
		comp_fecha_fin.maxValue = dte_fecha_fin_valid;
			
		//Define un valor por defecto
		comp_fecha_fin.setValue(dte_fecha_fin_valid);
		
		limpiar_componentes();
		comp_sw_filtro.setValue('');
		comp_desc_gestion.setValue(record.data.gestion_pres);
	}
	
	function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}
	
	function f_evento_sw_filtro(combo, record, index){
		limpiar_componentes();
		
		if (record.data.ID == '1'){
			CM_mostrarGrupo('Presupuesto');
			comp_sw_ppto.allowBlank = false;
		}
		if (record.data.ID == '2'){
			CM_mostrarGrupo('Proyecto');
			comp_sw_ep_proy.allowBlank = false;
		}
	}
	
	function f_evento_sw_ppto(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ppto);
			comp_ids_ppto.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ppto);
			comp_ids_ppto.allowBlank = true;
			comp_ids_ppto.setValue('');
		}
		comp_ids_ppto.modificado = true;
		comp_ids_ppto.store.baseParams = {sw_admi:g_admi,sw_listado:'ppto',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	function f_evento_sw_ep_fina(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_fina);
			comp_ids_ep_fina.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_fina);
			comp_ids_ep_fina.allowBlank = true;
			comp_ids_ep_fina.setValue('');
		}
		comp_ids_ep_fina.modificado = true;
		comp_ids_ep_fina.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_fina',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	function f_evento_sw_ep_prog(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_prog);
			comp_ids_ep_prog.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_prog);
			comp_ids_ep_prog.allowBlank = true;
			comp_ids_ep_prog.setValue('');
		}
		comp_ids_ep_prog.modificado=true;
		comp_ids_ep_prog.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_prog',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	function f_evento_sw_ep_proy(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_proy);
			comp_ids_ep_proy.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_proy);
			comp_ids_ep_proy.allowBlank = true;
			comp_ids_ep_proy.setValue('');
		}
		comp_ids_ep_proy.modificado=true;
		comp_ids_ep_proy.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_proy',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	function f_evento_sw_ep_acti(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_acti);
			comp_ids_ep_acti.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_acti);
			comp_ids_ep_acti.allowBlank = true;
			comp_ids_ep_acti.setValue('');
		}
		comp_ids_ep_acti.modificado=true;
		comp_ids_ep_acti.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_acti',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	function f_evento_sw_ep_uo(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_uo);
			comp_ids_ep_uo.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_uo);
			comp_ids_ep_uo.allowBlank = true;
			comp_ids_ep_uo.setValue('');
		}
		comp_ids_ep_uo.modificado=true;
		comp_ids_ep_uo.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_uo',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:3};
	}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "EJECUCION PRESUPUESTARIA INVERSION" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :95,
			url :direccion + '../../../control/rep_ejecuta/reporte/ActionPDF_Repeje_Inversion_Jasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 400, 510 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Periodo', columna :0, id_grupo :1},
				{tituloGrupo :'Presupuesto', columna :1, id_grupo :2},
				{tituloGrupo :'Proyecto', columna :1, id_grupo :3},
				{tituloGrupo :'Reporte', columna :0, id_grupo :4},
				{tituloGrupo :'Hidden', columna :0, id_grupo :5}
		]}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}