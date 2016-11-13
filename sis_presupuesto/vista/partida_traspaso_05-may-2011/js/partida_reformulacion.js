/**
 * Nombre:		  	    pagina_partida_reformulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-02-04 19:45:09
 */
function pagina_partida_reformulacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();	
	var g_id_parametro;
	var concluir='no';
	var	g_id_gestion;	
	
	var monedas_for=new Ext.form.MonedaField(
	{
		name:'mes_01',
		fieldLabel:'Enero',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:0}	
	);
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_traspaso/ActionListarPartidaTraspaso.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_partida_traspaso',totalRecords:'TotalCount'
		},[		
		'id_partida_traspaso',
		'id_partida_presupuesto_origen',
		'id_partida_presupuesto_destino',
		'id_partida_ejecucion_origen',
		'id_partida_ejecucion_destino',
		'id_usu_autorizado_origen',
		'desc_usuario_origen',
		'id_usu_autorizado_destino',
		'desc_usuario_destino',
		'id_usu_autorizado_registro',
		'desc_usuario_registro',
		'id_moneda',
		'desc_moneda',
		'importe_traspaso',
		'estado_traspaso',
		{name: 'fecha_traspaso',type:'date',dateFormat:'Y-m-d'},
		'fecha_conclusion',
		'justificacion',
		'id_parametro',
		'desc_parametro',
		'tipo_pres',
		
		'id_partida_origen',
		'desc_partida_origen',
		'id_partida_destino',
		'desc_partida_destino',
				
		'id_presupuesto_origen',
		'desc_presupuesto_origen',
		'id_presupuesto_destino',
		'desc_presupuesto_destino',
		'tipo_traspaso'			
		
		]),
		baseParams:{filtro_reformulacion:'si'},
		remoteSort:true});

	
	//DATA STORE COMBOS
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});
	
	var ds_usuario_autorizado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),
			baseParams:{sw_responsable:'si'}
	});	
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla'])
	});	
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });
	
	
	//FUNCIONES RENDER
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_usuario_origen(value, p, record){return String.format('{0}', record.data['desc_usuario_origen']);}
	function render_id_usuario_destino(value, p, record){return String.format('{0}', record.data['desc_usuario_destino']);}
	function render_id_usuario_registro(value, p, record){return String.format('{0}', record.data['desc_usuario_registro']);}
	var tpl_id_usuario_autorizado=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b>','<br><FONT COLOR="#B5A642"><b>Unidad Org.: </b>{desc_unidad_organizacional}</FONT>','</div>');
	
	function render_id_partida_origen(value, p, record){return String.format('{0}', record.data['desc_partida_origen']);}
	function render_id_partida_destino(value, p, record){return String.format('{0}', record.data['desc_partida_destino']);}
	//var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida + nombre_partida}</FONT><br>','</div>');
	//var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_par}</FONT><br>','<b>Código</b><FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<b>Partida</b><FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{desc_par}</i></b>','</div>');

	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_gral}</FONT>','</div>');
	

	function render_id_presupuesto_origen(value, p, record){return String.format('{0}', record.data['desc_presupuesto_origen']);}
	function render_id_presupuesto_destino(value, p, record){return String.format('{0}', record.data['desc_presupuesto_destino']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>',
																													'<br><FONT COLOR="#0000CC"><b>Tipo: </b>{sigla}</FONT>','</div>');
																												
	
																													
	function renderEstado(value, p, record)
	{
		if(value == 1)
		{return "Verificación"}
		if(value == 2)
		{return "Concluido"}
		if(value == 3)
		{return "Autorización"}
		if(value == 4)
		{return "Aprobado"}
		if(value == 5)
		{return "Autorización - Origen"}
		if(value == 6)
		{return "Autorización - Destino"}
		if(value == 7)
		{return "Rechazado"}
		return 'Otro';
	}
	
	function renderTipoPresupuesto(value, p, record)
	{
		if(value == 1)
		{return "Recurso"}
		if(value == 2)
		{return "Gasto"}
		if(value == 3)
		{return "Inversión"}
		if(value == 4)
		{return "PNO - Recurso"}
		if(value == 5)
		{return "PNO - Gasto"}
		if(value == 6)
		{return "PNO - Inversión"}
		
		return '';
	}
	
	function renderTipoTraspaso(value, p, record)
	{
		if(value == 1)
		{return "Traspaso"}
		if(value == 2)
		{return "Reformulación"}
		if(value == 3)
		{return "Otros"}
		return '';
	}
	
	function render_moneda(value)
	{
		if(value == 1){return "Bolivianos"}
		if(value == 2){return "Dólares Americanos"}
		if(value == 3){return "Unidad de Fomento a la Vivienda"}
		if(value == 4){return "Otros"}
	}
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
			return monedas_for.formatMoneda(value)		 
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_traspaso
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_traspaso',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_traspaso'
	};
// txt id_partida_presupuesto_origen
	Atributos[1]={
		validacion:{
			name:'id_partida_presupuesto_origen',
			fieldLabel:'Partida Presupuesto Origen',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PARTRA.id_partida_presupuesto_origen'		
	};
	
// txt id_partida_presupuesto_destino
	Atributos[2]={
		validacion:{
			name:'id_partida_presupuesto_destino',
			fieldLabel:'Partida Presupuesto Destino',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PARTRA.id_partida_presupuesto_destino'		
	};
	
// txt id_partida_ejecucion_origen
	Atributos[3]={
		validacion:{
			name:'id_partida_ejecucion_origen',
			fieldLabel:'id_partida_ejecucion_origen',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:2,
		filterColValue:'PARTRA.id_partida_ejecucion_origen'		
	};
	
// txt id_partida_ejecucion_destino
	Atributos[4]={
		validacion:{
			name:'id_partida_ejecucion_destino',
			fieldLabel:'id_partida_ejecucion_destino',
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
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:3,
		filterColValue:'PARTRA.id_partida_ejecucion_destino'		
	};
	
	Atributos[5] = {
		validacion: {
			name:'estado_traspaso',			
			fieldLabel:'Estado Reformulación',
			vtype:'texto',
			emptyText:'Estado Trasp...',
			allowBlank: true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.partida_traspaso_combo.estado // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderEstado,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150, // ancho de columna en el gris
			width:150,
			grid_indice:5
		},
		tipo:'ComboBox',
		form: true,	
		filtro_0:false,		
		id_grupo:0,
		save_as:'estado_traspaso',
		filterColValue:'PARTRA.estado_traspaso'		
	};
	
	// txt id_parametro
	Atributos[6]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
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
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			grid_indice:1,  //para colocar el orden en el indice
			//form_indice:1,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:1,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	// txt id_usuario
		Atributos[7]={
			validacion:{
			name:'id_usu_autorizado_origen',
			fieldLabel:'Responsable - Origen',
			allowBlank:false,			
			emptyText:'Usuario autorizado ori...',
			desc: 'desc_usuario_origen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_autorizado,
			valueField: 'id_usuario_autorizado',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#UNIORG.nombre_unidad',
			typeAhead:true,			
			tpl:tpl_id_usuario_autorizado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_origen,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			grid_indice:7,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usu_autorizado_origen'
	};	
	
	
	Atributos[8]={
			validacion:{
			name:'id_presupuesto_origen',
			fieldLabel:'Presupuesto - Origen',
			allowBlank:false,			
			emptyText:'Presupuesto ori...',
			desc: 'desc_presupuesto_origen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
			//filterCols:filterCols_presupuesto_origen,
			//filterValues:filterValues_presupuesto_origen,
			typeAhead:true,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto_origen,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:400,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',
		save_as:'id_presupuesto_origen'
	};	
	
	Atributos[9]={
			validacion:{
 			name:'id_partida_origen',
			fieldLabel:'Partida - Origen',
			allowBlank:false,			
			emptyText:'Partida ori...',
			desc: 'desc_partida_origen', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:3,
			editable:true,
			renderer:render_id_partida_origen,
 			grid_visible:true,
 			grid_editable:false,
			width_grid:200,
			lazyRender:true,
      		width:300,
			disabled:false,
			grid_indice:9		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida_origen'
	};	
	
	// txt importe_traspaso
	Atributos[10]={
		validacion:{
			name:'importe_traspaso',
			fieldLabel:'Importe Reformulación',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:true,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:110,
			width:200,
			disabled:false
					
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		id_grupo:1,
		save_as:'importe_traspaso',
		filterColValue:'PARTRA.importe_traspaso'		
	};	
	
	// txt id_moneda
	Atributos[11]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Mon...',
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:200,
			disable:false,
			grid_indice:11					
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:1,		
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	
		
	// txt id_usuario
		Atributos[12]={
			validacion:{
			name:'id_usu_autorizado_destino',
			fieldLabel:'Responsable - Destino',
			allowBlank:false,			
			emptyText:'Usuario autorizado dest...',
			desc: 'desc_usuario_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_autorizado,
			valueField: 'id_usuario_autorizado',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_usuario_autorizado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			//grid_indice:3,
			disabled:false,
			grid_indice:12		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre',
		save_as:'id_usu_autorizado_destino'
	};
	
	// txt id_presupuesto
	Atributos[13]={
			validacion:{
			name:'id_presupuesto_destino',
			fieldLabel:'Presupuesto - Destino',
			allowBlank:false,			
			emptyText:'Presupuesto dest...',
			desc: 'desc_presupuesto_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',//desc_presupuesto_destino  desc_unidad_organizacional
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
			typeAhead:true,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:400,
			disabled:false,
			grid_indice:13		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'UNIORG2.nombre_unidad#PROYEC2.nombre_proyecto',
		save_as:'id_presupuesto_destino'
	};		
	
	Atributos[14]={
		validacion:{
			name:'id_partida_destino',
			desc:'desc_partida_destino',
			fieldLabel:'Partida - Destino',
			allowBlank:true,
			valueField: 'id_partida',
			tipo:'ingreso',//determina el action a llamar
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			//vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_partida_destino,
			width_grid:200,			
			width:300,
			pageSize:10,
			direccion:direccion,
			grid_indice:14
		},
		tipo:'LovPartida',
		form: true,
		filtro_0:false,
		id_grupo:3,		
		save_as:'id_partida_destino'
	};
	
	Atributos[15]={
		validacion:{
			name:'id_partida_destino_gasto',
			desc:'desc_partida_destino',
			fieldLabel:'Partida - Destino.',
			allowBlank:true,
			valueField: 'id_partida',
			tipo:'gasto',//determina el action a llamar
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			//vtype:"texto",
			grid_visible:false,
			grid_editable:false,
			renderer:render_id_partida_destino,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovPartida',
		form: true,
		filtro_0:false,
		id_grupo:3
		//save_as:'id_partida_destino'
	};	
	
	// txt fecha_conclusion
	Atributos[16]={
		validacion:{
			name:'fecha_conclusion',
			fieldLabel:'Fecha Conclusión',
			grid_visible:true,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,	
		id_grupo:0,	
		filterColValue:'PARTRA.fecha_conclusion'
	};
	
	// txt id_usuario
		Atributos[17]={
			validacion:{
			name:'id_usu_autorizado_registro',
			fieldLabel:'Responsable Registro',
			allowBlank:true,			
			emptyText:'Usuario registro...',
			desc: 'desc_usuario_registro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_autorizado,
			valueField: 'id_usuario_autorizado',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_autorizado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_registro,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false,
			grid_indice:17		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PERSON3.apellido_paterno#PERSON3.apellido_materno#PERSON3.nombre',
		save_as:'id_usu_autorizado_registro'
	};
		

// txt justificacion
	Atributos[18]={
		validacion:{
			name:'justificacion',
			fieldLabel:'Justificación',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:18		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		id_grupo:1,
		save_as:'justificacion',
		filterColValue:'PARTRA.justificacion'		
	};		
	
	Atributos[19] = {
		validacion: {
			name:'tipo_pres',			
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,			
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.partida_traspaso_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			width:200
		},
		tipo:'ComboBox',
		filtro_0:false,		
		form: true,
		save_as:'tipo_pres',
		filterColValue:'PRESUP.tipo_pres',
		id_grupo:1
	};	
	
	// txt fecha_traspaso
	Atributos[20]= {
		validacion:{
			name:'fecha_traspaso',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:20		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARTRA.fecha_traspaso',
		dateFormat:'m-d-Y',
		id_grupo:0,
		save_as:'fecha_traspaso'
		//defecto:''		
	};
	
	Atributos[21]={
		validacion:{
			name:'importe_traspaso',
			fieldLabel:'Importe Traspaso',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: renderSeparadorDeMil,
			width_grid:110,
			width:'50%',
			disabled:false,
			grid_indice:10		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:0		
	};	
	
	Atributos[22] = {
		validacion: {
			name:'tipo_traspaso',			
			fieldLabel:'Tipo',
			vtype:'texto',
			//emptyText:'Tipo Traspaso...',
			allowBlank: false,
			typeAhead: true,			
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.partida_traspaso_combo.tipo_traspaso // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoTraspaso,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			disabled:true,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:false,		
		form: true,
		save_as:'tipo_traspaso',
		filterColValue:'tipo_traspaso',
		defecto:2,
		id_grupo:1
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Reformulaciones',grid_maestro:'grid-'+idContenedor};
	var layout_partida_reformulacion=new DocsLayoutMaestro(idContenedor);
	layout_partida_reformulacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_partida_reformulacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;	
	
	var ClaseMadre_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var cm_EnableSelect=this.EnableSelect;
	
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
		btnEliminar:{url:direccion+'../../../control/partida_traspaso/ActionEliminarPartidaTraspaso.php'},
		Save:{url:direccion+'../../../control/partida_traspaso/ActionGuardarPartidaTraspaso.php'},
		ConfirmSave:{url:direccion+'../../../control/partida_traspaso/ActionGuardarPartidaTraspaso.php'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:'70%',	//y
			width:'50%',	//x
			minWidth:150,
			minHeight:200,	
			//columnas:['47%','47%'],
			closable:true,
			titulo:'Reformulaciones',
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Origen',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Destino',
				columna:0,
				id_grupo:3
			}]
		}
	};
	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.btnNew=function()
	{
		concluir='no';
	   	CM_ocultarGrupo('Oculto');
	   	CM_ocultarComponente(componentes[15]);
	   	
	   	componentes[19].setDisabled(true);
		componentes[7].setDisabled(true);
		componentes[8].setDisabled(true);
		componentes[9].setDisabled(true);
		componentes[12].setDisabled(true);
		componentes[13].setDisabled(true);
		componentes[14].setDisabled(true);
		componentes[15].setDisabled(true);		
		
	   	ClaseMadre_btnNew();
    }
    
    this.btnEdit=function()
    {	
    	concluir='no';	
		if(componentes[5].getValue()=='1' || componentes[5].getValue()=='7') //estado traspaso
		{	
			CM_ocultarGrupo('Oculto');
			
			CM_mostrarComponente(componentes[14]);
			CM_ocultarComponente(componentes[15]);
			
			/*if(componentes[19].getValue()==1)
			{
				CM_mostrarComponente(componentes[14]);
				CM_ocultarComponente(componentes[15]);
			}
			else
			{
				CM_ocultarComponente(componentes[14]);
				CM_mostrarComponente(componentes[15]);
			}*/
			
			componentes[19].setDisabled(false);
			componentes[7].setDisabled(false);
			componentes[8].setDisabled(false);
			componentes[9].setDisabled(false);
			componentes[12].setDisabled(false);
			componentes[13].setDisabled(false);
			componentes[14].setDisabled(false);
			componentes[15].setDisabled(false);					
			ClaseMadre_btnEdit();			
		}
		else
		{			
			Ext.MessageBox.alert('...', 'Solo reformulaciones en estado VERIFICACION o RECHAZADO pueden ser modificados.');
		}
	}
    
    this.btnEliminar=function()
    {		
		if(componentes[5].getValue()=='1' || componentes[5].getValue()=='7') //estado traspaso
		{
			ClaseMadre_btnEliminar()
		}
		else
		{				
			Ext.MessageBox.alert('...', 'Solo reformulaciones en estado VERIFICACION o RECHAZADO pueden ser eliminados.');
		}
	}
	
	/*this.Save=function()
    {	
    	if(concluir=='si')
    	{
    		ClaseMadre_save();
    		alert('llega al if');
    	}
    	else
    	{
    		
			if(componentes[19].getValue()==1) //tipo_presupuesto
			{
				ClaseMadre_save();
			}    	
			else
			{		
				componentes[14].setValue( componentes[15].getValue() );
				ClaseMadre_save();
			}
			alert('llega al else');
    	}
	}   */	
	
    
    function InitPaginaPartidaReformulacion()
    {						
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}	

		
		componentes[6].on('select',evento_parametro);
		componentes[19].on('select',evento_tipo_presupuesto);		

		componentes[7].on('select',evento_usuario_origen);
		componentes[12].on('select',evento_usuario_destino);
		
		componentes[8].on('select',evento_presupuesto_origen);
		componentes[13].on('select',evento_presupuesto_destino);	

		componentes[15].on('select',evento_partida_destino_gasto);
		componentes[15].on('change',evento_partida_destino_gasto);	
	}	

	
	
	function evento_parametro( combo, record, index )
	{				
			componentes[8].modificado=true;
			componentes[13].modificado=true;
			
			componentes[14].store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:record.data.id_gestion};
			componentes[14].modificado=true;
			
			componentes[15].store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:record.data.id_gestion};
			componentes[15].modificado=true;
			
			componentes[19].setValue('');
			componentes[7].setValue('');
			componentes[8].setValue('');
			componentes[9].setValue('');
			componentes[12].setValue('');
			componentes[13].setValue('');
			componentes[14].setValue('');
			componentes[15].setValue('');
			
			componentes[19].setDisabled(false);
			componentes[7].setDisabled(true);
			componentes[8].setDisabled(true);
			componentes[9].setDisabled(true);
			componentes[12].setDisabled(true);
			componentes[13].setDisabled(true);
			componentes[14].setDisabled(true);	
			componentes[15].setDisabled(true);										
 	}
 	
 	function evento_tipo_presupuesto( combo, record, index )
	{				
			componentes[8].modificado=true;
			componentes[13].modificado=true;
			
			if(componentes[19].getValue()=='1')
			{
				CM_mostrarComponente(componentes[14]);
				CM_ocultarComponente(componentes[15]);
				componentes[14].allowBlank=false;
				componentes[15].allowBlank=true;
			}
			else
			{
				CM_ocultarComponente(componentes[14]);
				CM_mostrarComponente(componentes[15]);
				componentes[14].allowBlank=true;
				componentes[15].allowBlank=false;
			}
			
			componentes[7].setValue('');
			componentes[8].setValue('');
			componentes[9].setValue('');
			componentes[12].setValue('');
			componentes[13].setValue('');
			componentes[14].setValue('');
			componentes[15].setValue('');
			
			componentes[7].setDisabled(false);
			componentes[8].setDisabled(true);
			componentes[9].setDisabled(true);
			componentes[12].setDisabled(false);
			componentes[13].setDisabled(true);
			componentes[14].setDisabled(true);
			componentes[15].setDisabled(true);													
 	}
    
	function evento_usuario_origen( combo, record, index )
	{				
			componentes[8].store.baseParams={sw_traspaso:'si',m_id_parametro:componentes[6].getValue(),m_tipo_pres:componentes[19].getValue(),m_id_unidad_organizacional:record.data.id_unidad_organizacional};
			componentes[8].modificado=true;

			componentes[8].setValue('');
			componentes[9].setValue('');
			componentes[8].setDisabled(false);	 
			componentes[9].setDisabled(true);			
 	}	
 	
 	function evento_presupuesto_origen( combo, record, index )
	{
			componentes[9].store.baseParams={sw_traspaso:'si',m_id_presupuesto:record.data.id_presupuesto};
			componentes[9].modificado=true;		
			componentes[9].setValue('');
			componentes[9].setDisabled(false);			
 	}
 	
 	function evento_usuario_destino( combo, record, index )
	{
			componentes[13].store.baseParams={sw_traspaso:'si',m_id_parametro:componentes[6].getValue(),m_id_unidad_organizacional:record.data.id_unidad_organizacional,m_tipo_pres:componentes[19].getValue()};  //,m_tipo_pres:componentes[19].getValue()  //para quitarle que filtre por tipo de presupuesto
			componentes[13].modificado=true;
			
			componentes[13].setValue('');
			componentes[14].setValue('');
			componentes[15].setValue('');
			componentes[13].setDisabled(false);	 
			componentes[14].setDisabled(true);
			componentes[15].setDisabled(true);	
 	}
 	
 	function evento_presupuesto_destino( combo, record, index )
	{
			//componentes[14].store.baseParams={sw_traspaso:'si',m_id_presupuesto:record.data.id_presupuesto};
			componentes[14].modificado=true;
			componentes[14].setValue('');
			componentes[14].setDisabled(false);

			componentes[15].modificado=true;
			componentes[15].setValue('');
			componentes[15].setDisabled(false);		
 	}
 	
 	function evento_partida_destino_gasto( combo, record, index )
	{
			componentes[14].setValue( componentes[15].getValue() );		
 	}
		
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		//para iniciar eventos en el formulario
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var datas_edit=rec.data;
		enable(sm,row,rec);			
	}
	
	function prueba(prueba)
	{
		alert(prueba);			
	}	
		
	function btn_autorizacion_traspaso()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{			
			if(componentes[5].getValue()==1 || componentes[5].getValue()==7)	//estado traspaso
			{
				var sw=false;
				if(confirm('Esta seguro de enviar para AUTORIZACIÓN la reformulación?'))
						{sw=true}
				if(sw)
				{
					var concluir='no';
					
					if(componentes[7].getValue() == componentes[12].getValue()) //usuario origen = al usuario destino
					{	
						componentes[5].setValue(3);	//estado traspaso es autorización	
					}		
					else
					{
						componentes[5].setValue(5); //estado autorizacion origen
					}
					ClaseMadre_save();									
				}				
			}
			else
			{
				Ext.MessageBox.alert('...', 'Solo reformulaciones en estado VERIFICACION o RECHAZADO pueden ser enviados para autorización.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}	

	function btn_concluir_traspaso()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{			
			if(componentes[5].getValue()==4)	//estado traspaso
			{
				/*var sw=false;
				if(confirm('Esta seguro de CONCLUIR la reformulación?'))
						{sw=true}
				if(sw)
				{*/
					var concluir='si';
					componentes[5].setValue(2);	//estado traspaso el estado esta en concluido			
						
					//ClaseMadre_btnEdit();
					ClaseMadre_save();		
					
					/*var SelectionsRecord=sm.getSelected();			
	 				var data='id_partida_traspaso='+SelectionsRecord.data.id_partida_traspaso; 
	 				data=data+'&reformulacion=no';
					window.open(direccion+'../../../control/_reportes/partida_traspaso/PartidaTraspaso.php?'+data, "Traspaso");			
				}*/				
			}
			else
			{
				Ext.MessageBox.alert('...', 'Solo reformulaciones en estado APROBADO pueden ser concluidos.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}

	/*function btn_reporte_traspaso()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			if(componentes[5].getValue()==2)	//estado traspaso concluido
			{
				var SelectionsRecord=sm.getSelected();			
	 			var data='id_partida_traspaso='+SelectionsRecord.data.id_partida_traspaso;
	 			data=data+'&reformulacion=si'; 
				window.open(direccion+'../../../control/_reportes/partida_traspaso/PartidaTraspaso.php?'+data, "Reformulación");	
			}
			else
			{
				Ext.MessageBox.alert('...', 'Solo reformulaciones en estado CONCLUIDO pueden ser impresos.');
			}			
		}
		else
		{
			Ext.MessageBox.alert('...','Antes debe seleccionar un registro.')
		}
	}*/

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_partida_reformulacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/tucrem.png','Autorización Reformulación',btn_autorizacion_traspaso,true,'autorizacion_traspaso','Enviar Para Autorización');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Concluir Reformulación',btn_concluir_traspaso,true,'concluir_traspaso','Concluir Reformulación');
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Reporte Reformulación',btn_reporte_traspaso,true,'reporte_traspaso','Imprimir Reporte');
	
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
	CM_getBoton('concluir_traspaso-'+idContenedor).disable();	
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);		
		
		
		if(rec.data['estado_traspaso']=='1')//Verificación
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).enable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}
		if(rec.data['estado_traspaso']=='2')//Concluido
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
			
		}
		if(rec.data['estado_traspaso']=='3')//Autorización
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}
		if(rec.data['estado_traspaso']=='4')//Aprobado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('concluir_traspaso-'+idContenedor).enable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}
		if(rec.data['estado_traspaso']=='5')//Autorización - Origen
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}
		if(rec.data['estado_traspaso']=='6')//Autorización - Destino
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).disable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}	
		if(rec.data['estado_traspaso']=='7')//Rechazado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('autorizacion_traspaso-'+idContenedor).enable();
			CM_getBoton('concluir_traspaso-'+idContenedor).disable();
			//CM_getBoton('reporte_traspaso-'+idContenedor).disable();
		}				
	}
	
	this.iniciaFormulario();
	InitPaginaPartidaReformulacion();
	iniciarEventosFormularios();
	
	//Adicionamos el combo de gestion	
	var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
		
	
	var gestion =new Ext.form.ComboBox({
			store:ds_cmb_gestion,
			displayField:'gestion_pres',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Gestión...',
			selectOnFocus:true,
			width:100,
			valueField:'id_gestion',
			tpl:tpl_gestion_cmb
	});
	
  	gestion.on('select',function (combo, record, index)
  	{
  		g_id_gestion=gestion.getValue();
	  	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});	
    });
    this.AdicionarBotonCombo(gestion,'gestion');
    //Fin adicion del combo de gestion
	
	layout_partida_reformulacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}