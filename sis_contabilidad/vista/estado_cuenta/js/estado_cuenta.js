function pagina_estado_cuenta(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_estado_cuenta, h_txt_gestion, h_txt_mes, ds_linea;
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	
	var g_tipo_reporte;
	var g_sw_orden;
	
	var var_id_gestion;	
	var var_id_depto;
	var var_fecha_inicio;
	var var_fecha_final;
	var var_desc_fecha_inicio='';	
	var var_desc_fecha_final='';
	
	var var_sw_cuenta;
	var var_sw_auxiliar;
	var var_sw_partida;
	var var_sw_epe;
	var var_sw_uo;
	var var_sw_ot;
	
	var var_id_cuenta_inicial;
	var var_id_cuenta_final;
	var var_id_auxiliar_inicial;
	var var_id_auxiliar_final;
	var var_id_partida_inicial;
	var var_id_partida_final;
	var var_id_epe_inicial;
	var var_id_epe_final;
	var var_id_uo_inicial;
	var var_id_uo_final;
	var var_id_ot_inicial;
	var var_id_ot_final;
	
	var var_estado_cbte;
	var var_sw_actualizacion='';	
	var var_id_moneda='';	
	
	var comp_id_gestion;	
	var comp_id_depto;
	var comp_fecha_inicio;
	var comp_fecha_final;
	var comp_estado_cbte;
	var comp_sw_actualizacion;
	var comp_id_moneda;
	var comp_sw_cuenta;
	var comp_sw_auxiliar;
	var comp_sw_epe;
	var comp_sw_uo;
	var comp_sw_ot;
	var comp_id_cuenta_inicial;
	var comp_id_cuenta_final;
	var comp_id_auxiliar_inicial;
	var comp_id_auxiliar_final;
	var comp_id_partida_inicial;
	var comp_id_partida_final;
	var comp_id_epe_inicial;
	var comp_id_epe_final;
	var comp_id_uo_inicial;
	var comp_id_uo_final;
	var comp_id_ot_inicial;
	var comp_id_ot_final;
	
	var comp_sw_orden;
	var comp_tipo_reporte;
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_componete_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componete_auxiliar=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});
	
	var ds_componete_partida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componete_epe=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componete_uo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componete_ot=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	ds_depto.load();
	var data_deptos=new Array();
	var indice=0;
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_componente_cuenta(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_cuenta=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	function render_componente_auxiliar(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_auxiliar=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_componente_partida(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_partida=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');

	function render_componente_epe(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_epe=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_componente_uo(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_uo=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_componente_ot(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_ot=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_tipo(value, p, record)
	{	if(value=='rango'){return 'RANGO';}
		if(value=='detalle'){return 'DETALLE';}
		if(value=='cabecera'){return 'CABECERA';}
		if(value=='ninguno'){return 'NINGUNO';}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_conta',
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
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_conta',
		save_as:'id_parametro'
	};
	
	vectorAtributos[1] = {
		validacion : {
			name :'fecha_inicio',
			fieldLabel :'Fecha Inicial',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_inicio',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[2] = {
		validacion : {
			name :'fecha_final',
			fieldLabel :'Fecha Final',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_final',
		dateFormat :'m/d/Y',
		defecto :""
	};

	vectorAtributos[3] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_ini',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_ini'
	};

	vectorAtributos[4] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_fin',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_fin'
	};
	
	vectorAtributos[5]={
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
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	vectorAtributos[6]={
		validacion:{
			name:'sw_actualizacion',
			fieldLabel:'Actualización',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			//renderer:render_sino,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'sw_actualizacion'
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'estado_cbte',
			fieldLabel:'Cbtes.',
			allowBlank:false,
			align:'left',
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','VALIDADO'],['2','BORRADOR'],['3','EDICION']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width_grid:200,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		defecto:1,
		form: true,
		save_as:'estado_cbte'
	};	
	
	vectorAtributos[8]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Depto.',
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
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:false,
			width_grid:220,
			width:380,
			disabled:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_depto',
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'sw_cuenta',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:1,
		form: true,
		save_as:'sw_cuenta'
	};
	
	vectorAtributos[10]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'Cuenta Inicial...',
			name:'id_cuenta_inicial',
			desc:'nombre',
			store:ds_componete_cuenta,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_cuenta,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_cuenta,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:1,
		filtro_0:false,
 		form: true,
 		save_as:'id_cuenta_inicial'
	};	
	
	vectorAtributos[11]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'Cuenta final...',
			name:'id_cuenta_final',
			desc:'nombre',
			store:ds_componete_cuenta,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_cuenta,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_cuenta,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:1,
		filtro_0:false,
		form: true,
		save_as:'id_cuenta_final'
	};	
	
	vectorAtributos[12]={
		validacion:{
			name:'sw_auxiliar',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		form: true,
		save_as:'sw_auxiliar'
	};
	
	vectorAtributos[13]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'Auxiliar Inicial...',
			name:'id_auxiliar_inicial',
			desc:'nombre',
			store:ds_componete_auxiliar,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_auxiliar,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_auxiliar,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:3,
		filtro_0:false,
 		form: true,
 		save_as:'id_auxiliar_inicial'
	};	
	
	vectorAtributos[14]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'Auxliar final...',
			name:'id_auxiliar_final',
			desc:'nombre',
			store:ds_componete_auxiliar,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_auxiliar,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_auxiliar,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:3,
		filtro_0:false,
 		form: true,
 		save_as:'id_auxiliar_final'
	};
	
	vectorAtributos[15]={
		validacion:{
			name:'sw_partida',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:2,
		form: true,
		save_as:'sw_partida'
	};
	
	vectorAtributos[16]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'Partida Inicial...',
			name:'id_partida_inicial',
			desc:'nombre',
			store:ds_componete_partida,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_partida,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_partida,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:2,
		filtro_0:false,
 		form: true,
 		save_as:'id_partida_inicial'
	};	
	
	vectorAtributos[17]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'Partida final...',
			name:'id_partida_final',
			desc:'nombre',
			store:ds_componete_partida,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_partida,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_partida,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:2,
		filtro_0:false,
 		form: true,
 		save_as:'id_partida_final'
	};
	
	vectorAtributos[18]={
		validacion:{
			name:'sw_epe',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:4,
		form: true,
		save_as:'sw_epe'
	};
	
	vectorAtributos[19]={
		validacion:{
			name:'id_epe_inicial',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componete_epe,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_epe,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
					//record['codigo'];
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			grid_visible:true,
			grid_editable:true,
			renderer:render_componente_epe,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
		filtro_0:false,
 		form: true
	};
	
	/*vectorAtributos[19]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'EPE Inicial...',
			name:'id_epe_inicial',
			desc:'nombre',
			store:ds_componete_epe,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_epe,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_epe,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:4,
		filtro_0:false,
 		form: true,
 		save_as:'id_epe_inicial'
	};*/	
	
	vectorAtributos[20]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'EPE final...',
			name:'id_epe_final',
			desc:'nombre',
			store:ds_componete_epe,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_epe,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_epe,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:4,
		filtro_0:false,
 		form: true,
 		save_as:'id_epe_final'
	};	
	
	vectorAtributos[21]={
		validacion:{
			name:'sw_uo',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:5,
		form: true,
		save_as:'sw_uo'
	};
	
	vectorAtributos[22]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'UO Inicial...',
			name:'id_uo_inicial',
			desc:'nombre',
			store:ds_componete_uo,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_uo,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_uo,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:5,
		filtro_0:false,
 		form: true,
 		save_as:'id_uo_inicial'
	};	
	
	vectorAtributos[23]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'UO final...',
			name:'id_uo_final',
			desc:'nombre',
			store:ds_componete_uo,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_uo,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_uo,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:5,
		filtro_0:false,
 		form: true,
 		save_as:'id_uo_final'
	};
	
	vectorAtributos[24]={
		validacion:{
			name:'sw_ot',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['detalle','DETALLE'],['cabecera','CABECERA'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:100,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:6,
		form: true,
		save_as:'sw_ot'
	};
	
	vectorAtributos[25]={
		validacion:{
			fieldLabel:'Inicial',
			allowBlank:true,
			emptyText:'OT Inicial...',
			name:'id_ot_inicial',
			desc:'nombre',
			store:ds_componete_ot,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_ot,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_ot,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:6,
		filtro_0:false,
 		form: true,
 		save_as:'id_ot_inicial'
	};	
	
	vectorAtributos[26]={
		validacion:{
			fieldLabel:'Final',
			allowBlank:true,
			emptyText:'OT final...',
			name:'id_ot_final',
			desc:'nombre',
			store:ds_componete_ot,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_ot,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:5,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_ot,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:6,
		filtro_0:false,
 		form: true,
 		save_as:'id_ot_final'
	};
	
	vectorAtributos[27]={
		validacion:{
			name:'sw_orden',
			fieldLabel:'Orden',
			vtype:'texto',
			emptyText:'Orden...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['A','CtaParAux - EpUoOt'],['B','EpUoOt - CtaParAux']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:7,
		save_as:'sw_orden'
	};
	
	vectorAtributos[28]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf1','PDF - Contable'],['pdf2','PDF - Presupuestario'],
			                                                            ['pdf3','PDF - Contable / Presupuestario'],['xls','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:7,
		save_as:'tipo_reporte'
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_estado_cuenta = new DocsLayoutProceso(idContenedor);
	layout_estado_cuenta.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_estado_cuenta, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var getComponente=this.getComponente;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		comp_id_gestion=ClaseMadre_getComponente('id_parametro');
		comp_id_depto=ClaseMadre_getComponente('id_depto');
		comp_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		comp_fecha_final=ClaseMadre_getComponente('fecha_final');
		comp_estado_cbte=ClaseMadre_getComponente('estado_cbte');
		comp_sw_actualizacion=ClaseMadre_getComponente('sw_actualizacion');
		comp_id_moneda=ClaseMadre_getComponente('id_moneda');
			
		comp_sw_cuenta=ClaseMadre_getComponente('sw_cuenta');
		comp_sw_auxiliar=ClaseMadre_getComponente('sw_auxiliar');
		comp_sw_partida=ClaseMadre_getComponente('sw_partida');
		comp_sw_epe=ClaseMadre_getComponente('sw_epe');
		comp_sw_uo=ClaseMadre_getComponente('sw_uo');
		comp_sw_ot=ClaseMadre_getComponente('sw_ot');
		
		comp_id_cuenta_inicial=ClaseMadre_getComponente('id_cuenta_inicial');
		comp_id_cuenta_final=ClaseMadre_getComponente('id_cuenta_final');
		
		comp_id_auxiliar_inicial=ClaseMadre_getComponente('id_auxiliar_inicial');
		comp_id_auxiliar_final=ClaseMadre_getComponente('id_auxiliar_final');
		
		comp_id_partida_inicial=ClaseMadre_getComponente('id_partida_inicial');
		comp_id_partida_final=ClaseMadre_getComponente('id_partida_final');
		
		comp_id_epe_inicial=ClaseMadre_getComponente('id_epe_inicial');
		comp_id_epe_final=ClaseMadre_getComponente('id_epe_final');
	
		comp_id_uo_inicial=ClaseMadre_getComponente('id_uo_inicial');
		comp_id_uo_final=ClaseMadre_getComponente('id_uo_final');
		
		comp_id_ot_inicial=ClaseMadre_getComponente('id_ot_inicial');
		comp_id_ot_final=ClaseMadre_getComponente('id_ot_final');
		
		comp_sw_orden=ClaseMadre_getComponente('sw_orden');
		comp_tipo_reporte=ClaseMadre_getComponente('tipo_reporte');
		
		comp_id_gestion.on('select',f_almacenar_gestion);	
		comp_id_depto.on('select',f_almacenar_depto);	
		comp_fecha_inicio.on('blur',f_almacenar_inicio);
		comp_fecha_final.on('blur',f_almacenar_final);	
		comp_estado_cbte.on('select',f_almacenar_estado_cbte);	
		comp_sw_actualizacion.on('select',f_almacenar_sw_actualizacion);	
		comp_id_moneda.on('select',f_almacenar_id_moneda);	
				
		comp_sw_cuenta.on('select',f_almacenar_sw_cuenta);	
		comp_id_cuenta_inicial.on('select',f_almacenar_cuenta_inicial);	
		comp_id_cuenta_final.on('select',f_almacenar_cuenta_final);	
		
		comp_sw_auxiliar.on('select',f_almacenar_sw_auxiliar);	
		comp_id_auxiliar_inicial.on('select',f_almacenar_auxiliar_inicial);	
		comp_id_auxiliar_final.on('select',f_almacenar_auxiliar_final);
		
		comp_sw_partida.on('select',f_almacenar_sw_partida);	
		comp_id_partida_inicial.on('select',f_almacenar_partida_inicial);	
		comp_id_partida_final.on('select',f_almacenar_partida_final);	
		
		comp_sw_epe.on('select',f_almacenar_sw_epe);	
		comp_id_epe_inicial.on('select',f_almacenar_epe_inicial);	
		comp_id_epe_final.on('select',f_almacenar_epe_final);	
		
		comp_sw_uo.on('select',f_almacenar_sw_uo);	
		comp_id_uo_inicial.on('select',f_almacenar_uo_inicial);	
		comp_id_uo_final.on('select',f_almacenar_uo_final);	
		
		comp_sw_ot.on('select',f_almacenar_sw_ot);	
		comp_id_ot_inicial.on('select',f_almacenar_ot_inicial);	
		comp_id_ot_final.on('select',f_almacenar_ot_final);
	}
	
	function limpiar_EPE_UO_OT_Cta_Aux(){
		comp_sw_cuenta.setValue('');
		comp_sw_auxiliar.setValue('');
		comp_sw_partida.setValue('');
		comp_sw_epe.setValue('');
		comp_sw_uo.setValue('');
		comp_sw_ot.setValue('');
		
	 	CM_ocultarComponente(comp_id_cuenta_inicial);
	 	comp_id_cuenta_inicial.setValue('');
		comp_id_cuenta_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_cuenta_final);
		comp_id_cuenta_final.setValue('');
		comp_id_cuenta_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_auxiliar_inicial);
		comp_id_auxiliar_inicial.setValue('');
		comp_id_auxiliar_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_auxiliar_final);
		comp_id_auxiliar_final.setValue('');
		comp_id_auxiliar_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_partida_inicial);
		comp_id_partida_inicial.setValue('');
		comp_id_partida_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_partida_final);
		comp_id_partida_final.setValue('');
		comp_id_partida_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_epe_inicial);
		comp_id_epe_inicial.setValue('');
		comp_id_epe_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_epe_final);
		comp_id_epe_final.setValue('');
		comp_id_epe_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_uo_inicial);
		comp_id_uo_inicial.setValue('');
		comp_id_uo_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_uo_final);
		comp_id_uo_final.setValue('');
		comp_id_uo_final.allowBlank=true;
		
		CM_ocultarComponente(comp_id_ot_inicial);
		comp_id_ot_inicial.setValue('');
		comp_id_ot_inicial.allowBlank=true;
		
		CM_ocultarComponente(comp_id_ot_final);
		comp_id_ot_final.setValue('');
		comp_id_ot_final.allowBlank=true;
		
		var_sw_cuenta='';
		var_sw_auxiliar='';
		var_sw_partida='';
		var_sw_epe='';
		var_sw_uo='';
		var_sw_ot='';
		var_id_cuenta_inicial='';
		var_id_cuenta_final='';
		var_id_auxiliar_inicial='';
		var_id_auxiliar_final='';
		var_id_partida_inicial='';
		var_id_partida_final='';
		var_id_epe_inicial='';
		var_id_epe_final='';
		var_id_uo_inicial='';
		var_id_uo_final='';
		var_id_ot_inicial='';
		var_id_ot_final=''; 
	}
	
	function f_almacenar_gestion( combo, record, index ){
		var_id_gestion=record.data.id_gestion;
		var_desc_id_gestion=record.data.gestion_conta;
		
		var intGestion=record.data.gestion_conta;
		var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
		var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
			
		//Aplica la validación en la fecha
		comp_fecha_inicio.minValue=dte_fecha_ini_valid;
		comp_fecha_inicio.maxValue=dte_fecha_fin_valid;
		comp_fecha_final.minValue=dte_fecha_ini_valid;
		comp_fecha_final.maxValue=dte_fecha_fin_valid;
			
		//Define un valor por defecto
		comp_fecha_inicio.setValue(dte_fecha_ini_valid);
		comp_fecha_final.setValue(dte_fecha_fin_valid);	
		
		var fecha =comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('m/d/Y'):'';
		var_fecha_inicio=fecha;
		var_desc_fecha_inicio=comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('d/m/Y'):'';
		
		fecha =comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('m/d/Y'):'';
		var_fecha_final=fecha;
		var_desc_fecha_final=comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('d/m/Y'):'';
		
		limpiar_EPE_UO_OT_Cta_Aux();
	}
	
	function f_almacenar_depto( combo, record, index ){
		var_id_depto=record.data.id_depto;
		var_desc_id_depto=record.data.nombre_depto;
		limpiar_EPE_UO_OT_Cta_Aux();	
	}
	
	function f_almacenar_inicio(comboData){
		var fecha =comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('m/d/Y'):'';
		var_fecha_inicio=fecha;
		var_desc_fecha_inicio=comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('d/m/Y'):'';
		var fecha_inicio_val = comp_fecha_inicio.getValue();
		comp_fecha_final.minValue = fecha_inicio_val;	
		limpiar_EPE_UO_OT_Cta_Aux();
	}
	
	function f_almacenar_final(comboData){
		var fecha =comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('m/d/Y'):'';
		var_fecha_final=fecha;
		var_desc_fecha_final=comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('d/m/Y'):'';
		limpiar_EPE_UO_OT_Cta_Aux();
	}
	
	function f_almacenar_estado_cbte( combo, record, index ){
		var_estado_cbte=record.data.ID;	
		var_desc_estado_cbte=record.data.ID;
		limpiar_EPE_UO_OT_Cta_Aux();
	}
	function f_almacenar_sw_actualizacion( combo, record, index ){
		var_sw_actualizacion=record.data.ID;
		var_desc_sw_actualizacion=record.data.ID;
		limpiar_EPE_UO_OT_Cta_Aux();	
	}
	
	function f_almacenar_id_moneda( combo, record, index ){
		var_id_moneda=record.data.id_moneda;
		var_desc_moneda=record.data.simbolo;
		limpiar_EPE_UO_OT_Cta_Aux();
	}
	
	function f_almacenar_sw_cuenta( combo, record, index ){
		var_sw_cuenta=record.data.ID;
		var_desc_sw_cuenta=record.data.ID;
		var_desc_id_cuenta_inicial='';
		var_desc_id_cuenta_final='';
		
		if(var_sw_cuenta=='rango'){
			 comp_id_cuenta_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'cuenta',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_cuenta_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_cuenta_inicial);
			CM_mostrarComponente(comp_id_cuenta_final);
			comp_id_cuenta_inicial.allowBlank=false;
			comp_id_cuenta_final.allowBlank=false;	
		}else{
			CM_ocultarComponente(comp_id_cuenta_inicial);
			CM_ocultarComponente(comp_id_cuenta_final);
			comp_id_cuenta_inicial.setValue('');
			var_id_cuenta_inicial='';
			comp_id_cuenta_final.setValue('');
			var_id_cuenta_final='';
			comp_id_cuenta_inicial.allowBlank=true;
			comp_id_cuenta_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_auxiliar( combo, record, index ){
		var_sw_auxiliar=record.data.ID;
		
		var_desc_sw_auxiliar=record.data.ID;
		var_desc_id_auxiliar_inicial='';
		var_desc_id_auxiliar_final='';
		
		if(var_sw_auxiliar=='rango'){
			 comp_id_auxiliar_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'auxiliar',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_auxiliar_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_auxiliar_inicial);
			CM_mostrarComponente(comp_id_auxiliar_final);
			comp_id_auxiliar_inicial.allowBlank=false;
			comp_id_auxiliar_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_auxiliar_inicial);
			CM_ocultarComponente(comp_id_auxiliar_final);
			comp_id_auxiliar_inicial.setValue('');
			var_id_auxiliar_inicial='';
			comp_id_auxiliar_final.setValue('');
			var_id_auxiliar_final='';
			comp_id_auxiliar_inicial.allowBlank=true;
			comp_id_auxiliar_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_partida( combo, record, index ){
		var_sw_partida=record.data.ID;
		
		var_desc_sw_partida=record.data.ID;
		var_desc_id_partida_inicial='';
		var_desc_id_partida_final='';
		
		if(var_sw_partida=='rango'){
			 comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'partida',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_partida_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_partida_inicial);
			CM_mostrarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=false;
			comp_id_partida_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_partida_inicial);
			CM_ocultarComponente(comp_id_partida_final);
			comp_id_partida_inicial.setValue('');
			var_id_partida_inicial='';
			comp_id_partida_final.setValue('');
			var_id_partida_final='';
			comp_id_partida_inicial.allowBlank=true;
			comp_id_partida_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_epe( combo, record, index ){
		var_sw_epe=record.data.ID;
		
		var_desc_sw_epe=record.data.ID;
		var_desc_id_epe_inicial='';
		var_desc_id_epe_final='';
		
		if(var_sw_epe=='rango'){
			 comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'epe',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_epe_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_epe_inicial);
			CM_mostrarComponente(comp_id_epe_final);
			comp_id_epe_inicial.allowBlank=false;
			comp_id_epe_final.allowBlank=false;		
		}else{
			CM_ocultarComponente(comp_id_epe_inicial);
			CM_ocultarComponente(comp_id_epe_final);
			comp_id_epe_inicial.setValue('');
			var_id_epe_inicial='';
			comp_id_epe_final.setValue('');
			var_id_epe_final='';
			comp_id_epe_inicial.allowBlank=true;
			comp_id_epe_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_uo( combo, record, index ){
		var_sw_uo=record.data.ID;
		
		var_desc_sw_uo=record.data.ID;
		var_desc_id_uo_inicial='';
		var_desc_id_uo_final='';
		
		if(var_sw_uo=='rango'){
			 comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'uo',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_uo_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_uo_inicial);
			CM_mostrarComponente(comp_id_uo_final);
			comp_id_uo_inicial.allowBlank=false;
			comp_id_uo_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_uo_inicial);
			CM_ocultarComponente(comp_id_uo_final);
			comp_id_uo_inicial.setValue('');
			var_id_uo_inicial='';
			comp_id_uo_final.setValue('');
			var_id_uo_final='';
			comp_id_uo_inicial.allowBlank=true;
			comp_id_uo_final.allowBlank=true;
		}
	}
	
	function f_almacenar_sw_ot( combo, record, index ){
		var_sw_ot=record.data.ID;
		
		var_desc_sw_ot=record.data.ID;
		var_desc_id_ot_inicial='';
		var_desc_id_ot_final='';

		if(var_sw_ot=='rango'){
			 comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'ot',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		 	comp_id_ot_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_ot_inicial);
			CM_mostrarComponente(comp_id_ot_final);
			comp_id_ot_inicial.allowBlank=false;
			comp_id_ot_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_ot_inicial);
			CM_ocultarComponente(comp_id_ot_final);
			comp_id_ot_inicial.setValue('');
			var_id_ot_inicial='';
			comp_id_ot_final.setValue('');
			var_id_ot_final='';
			comp_id_ot_inicial.allowBlank=true;
			comp_id_ot_final.allowBlank=true;
		}
	}
	
	function f_almacenar_cuenta_inicial( combo, record, index ){
		var_id_cuenta_inicial=record.data.id_maydat;
		var_desc_id_cuenta_inicial=record.data.codigo_nombre;
		
		comp_id_cuenta_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'cuenta',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 //id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_cuenta_final.modificado=true;										
	}
	
	function f_almacenar_cuenta_final( combo, record, index ){
		var_id_cuenta_final=record.data.id_maydat;
		var_desc_id_cuenta_final=record.data.codigo_nombre;
		
		comp_id_cuenta_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'cuenta',
												 
												 //id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_cuenta_inicial.modificado=true;
	}

	function f_almacenar_auxiliar_inicial( combo, record, index ){
		var_id_auxiliar_inicial=record.data.id_maydat;
		var_desc_id_auxiliar_inicial=record.data.codigo_nombre;
		
		comp_id_auxiliar_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'auxiliar',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 //id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_auxiliar_final.modificado=true;										
	}
	
	function f_almacenar_auxiliar_final( combo, record, index ){
		var_id_auxiliar_final=record.data.id_maydat;
		var_desc_id_auxiliar_final=record.data.codigo_nombre; 
		
		comp_id_auxiliar_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'auxiliar',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 //id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_auxiliar_inicial.modificado=true;											
	}
	
	function f_almacenar_partida_inicial( combo, record, index ){
		var_id_partida_inicial=record.data.id_maydat;
		var_desc_id_partida_inicial=record.data.codigo_nombre;
		
		comp_id_partida_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'partida',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 //id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_partida_final.modificado=true;										
	}
	
	function f_almacenar_partida_final( combo, record, index ){
		var_id_partida_final=record.data.id_maydat;
		var_desc_id_partida_final=record.data.codigo_nombre; 
		
		comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'partida',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 //id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_partida_inicial.modificado=true;											
	}
	
	function f_almacenar_epe_inicial( combo, record, index ){
		var_id_epe_inicial=record.data.id_maydat;	
		
		var_desc_id_epe_inicial=record.data.codigo_nombre;
		alert(record.data.id_epe_inicial);
		comp_id_epe_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'epe',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 //id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_epe_final.modificado=true;										
	}
	
	function f_almacenar_epe_final( combo, record, index ){
		var_id_epe_final=record.data.id_maydat;
		var_desc_id_epe_final=record.data.codigo_nombre;
		
		comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'epe',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 //id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_epe_inicial.modificado=true;											
	}

	function f_almacenar_uo_inicial( combo, record, index ){
		var_id_uo_inicial=record.data.id_maydat;
		var_desc_id_uo_inicial=record.data.codigo_nombre;
		
		comp_id_uo_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'uo',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 //id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_uo_final.modificado=true;										
	}
	
	function f_almacenar_uo_final( combo, record, index ){
		var_id_uo_final=record.data.id_maydat;
		var_desc_id_uo_final=record.data.codigo_nombre;
		
		comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'uo',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 //id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_uo_inicial.modificado=true;											
	}

	function f_almacenar_ot_inicial( combo, record, index ){
		var_id_ot_inicial=record.data.id_maydat;
		var_desc_id_ot_inicial=record.data.codigo_nombre;
		
		comp_id_ot_final.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'ot',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 id_ot_inicial:var_id_ot_inicial,
												 //id_ot_final:var_id_ot_final,
												 };
		comp_id_ot_final.modificado=true;										
	}
	
	function f_almacenar_ot_final( combo, record, index ){
		var_id_ot_final=record.data.id_maydat;	
		var_desc_id_ot_final=record.data.codigo_nombre;
		
		comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion,
												 id_depto:var_id_depto,
												 fecha_inicio:var_fecha_inicio,
												 fecha_final:var_fecha_final,
												 
												 sw_cuenta:var_sw_cuenta,
												 sw_auxiliar:var_sw_auxiliar,
												 sw_partida:var_sw_partida,
												 sw_epe:var_sw_epe,
												 sw_uo:var_sw_uo,
												 sw_ot:var_sw_ot,

												 sw_estado_cbte:var_estado_cbte,
												 sw_actualizacion:var_sw_actualizacion,
												 sw_listado:'ot',
												 
												 id_cuenta_inicial:var_id_cuenta_inicial,
												 id_cuenta_final:var_id_cuenta_final,
												 
												 id_auxiliar_inicial:var_id_auxiliar_inicial,
												 id_auxiliar_final:var_id_auxiliar_final,
												 
												 id_partida_inicial:var_id_partida_inicial,
												 id_partida_final:var_id_partida_final,
												 
												 id_epe_inicial:var_id_epe_inicial,
												 id_epe_final:var_id_epe_final,
												 
												 id_uo_inicial:var_id_uo_inicial,
												 id_uo_final:var_id_uo_final,
												 
												 //id_ot_inicial:var_id_ot_inicial,
												 id_ot_final:var_id_ot_final};
		comp_id_ot_inicial.modificado=true;											
	}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "LIBRO MAYOR DE CUENTAS" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../control/eeff/ActionListarEEFFConsolidado.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 490, 490 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Cuenta', columna :0, id_grupo :1},
				{tituloGrupo :'Partida', columna :0, id_grupo :2},
				{tituloGrupo :'Auxiliar', columna :0, id_grupo :3},
				{tituloGrupo :'E.P.E.', columna :1, id_grupo :4},
				{tituloGrupo :'U.O.', columna :1, id_grupo :5},
				{tituloGrupo :'O.T.', columna :1, id_grupo :6},
				{tituloGrupo :'Reporte', columna :1, id_grupo :7},
				],
			submit:function (){
				g_tipo_reporte = comp_tipo_reporte.getValue();
				g_sw_orden = comp_sw_orden.getValue();
				
				var data='id_gestion='+var_id_gestion;
				 data+='&id_depto='+var_id_depto;
				 
				 data+='&fecha_inicio='+var_fecha_inicio;
				 data+='&fecha_final='+var_fecha_final;
				 data+='&fecha_inicio_rep='+var_desc_fecha_inicio;
				 data+='&fecha_final_rep='+var_desc_fecha_final;
				 
				 data+='&sw_cuenta='+var_sw_cuenta;
				 data+='&sw_auxiliar='+var_sw_auxiliar;
				 data+='&sw_partida='+var_sw_partida;
				 data+='&sw_epe='+var_sw_epe;
				 data+='&sw_uo='+var_sw_uo;
				 data+='&sw_ot='+var_sw_ot;
				 
				 data+='&id_cuenta_inicial='+var_id_cuenta_inicial;
				 data+='&id_cuenta_final='+var_id_cuenta_final;
				 data+='&id_auxiliar_inicial='+var_id_auxiliar_inicial;
				 data+='&id_auxiliar_final='+var_id_auxiliar_final;
				 data+='&id_partida_inicial='+var_id_partida_inicial;
				 data+='&id_partida_final='+var_id_partida_final;
				 data+='&id_epe_inicial='+var_id_epe_inicial;
				 data+='&id_epe_final='+var_id_epe_final;
				 data+='&id_uo_inicial='+var_id_uo_inicial;
				 data+='&id_uo_final='+var_id_uo_final;
				 data+='&id_ot_inicial='+var_id_ot_inicial;
				 data+='&id_ot_final='+var_id_ot_final;
				 data+='&sw_estado_cbte='+var_estado_cbte;
				 data+='&sw_actualizacion='+var_sw_actualizacion;
				 data+='&id_moneda='+var_id_moneda;
				 data+='&desc_moneda='+var_desc_moneda;
				 
				 data+='&tipo_reporte='+g_tipo_reporte;
				 data+='&sw_orden='+g_sw_orden;
				 alert(comp_id_epe_inicial.getValue());
				if (var_id_depto != ''){
					window.open(direccion+'../../../control/eeff_mayor/reporte/ActionPDFEeffCuentaJasper.php?'+data)
				}
			}
		}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}