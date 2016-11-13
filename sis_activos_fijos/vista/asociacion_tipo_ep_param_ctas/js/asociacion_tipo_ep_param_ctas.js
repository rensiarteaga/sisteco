/**
 * Nombre:		asociacion_tipo_ep_param_ctas.js  	  
 * Propósito: 	vista,parametrizacion de cuentas ACTIF-CONIN		
 * Autor:		Elmer Velasquez			
 * Fecha creación:		01/02/2013
 */

function ParametrizacionCtasActifConin(idContenedor,direccion,paramConfig)
{	
	var Atributos=new Array;
	//var combo_programa,combo_tension;
	var componentes= new Array(); 
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asociacion_tipo_ep_param_ctas/ActionListarTipoActivoCuenta.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_activo_cuenta',totalRecords:'TotalCount'
		},[		
		'id_tipo_activo_cuenta',
		'id_tipo_activo',
		'codigo_programa',
		'descripcion_programa',
		'cuenta_activo',
		'cuenta_dep_acumulada',
		'cuenta_gasto', 
		'cuenta_activo_auxiliar',
		'cuenta_dep_acumulada_auxiliar',
		'cuenta_gasto_auxiliar',  'tension',
		'descripcion',
		'nombre_cuenta_activo','nombre_cuenta_activo_auxiliar',
		'nombre_cuenta_dep_acumulada','nombre_cuenta_dep_acumulada_auxiliar',
		'nombre_cuenta_gasto','nombre_cuenta_gasto_auxiliar'
		]),remoteSort:true});
	//DATA STORE COMBOS
	var ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_activo/ActionListaTipoActivoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'	
		}, ['id_tipo_activo','descripcion'])
	
	});
	var ds_sub_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',	
			id: 'id_sub_tipo_activo',	
			totalRecords: 'TotalCount'
		}, ['id_sub_tipo_activo','descripcion'])
	}); 
	var ds_cta_activo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asociacion_tipo_ep_param_ctas/cuentas_contables_gestion/ActionListarCuentasContables.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
		['id_cuenta','nro_cuenta','nombre_cuenta'])});
	function render_id_cta_activo(value, p, record){return String.format('{0}', record.data['cuenta_activo'])};
	var tpl_cuenta_activo=new Ext.Template('<div class="search-item">','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');

	
	var ds_cta_depacum = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asociacion_tipo_ep_param_ctas/cuentas_contables_gestion/ActionListarCuentasContables.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
		['id_cuenta','nro_cuenta','nombre_cuenta'])});
	var tpl_cuenta_depacum=new Ext.Template('<div class="search-item">','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');

	
	var ds_cta_gasto = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/asociacion_tipo_ep_param_ctas/cuentas_contables_gestion/ActionListarCuentasContables.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
		['id_cuenta','nro_cuenta','nombre_cuenta'])});
	var tpl_cuenta_gasto=new Ext.Template('<div class="search-item">','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');
 
	
	
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
	var tpl_cta_aux=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');
	
	
	var ds_auxiliar_dep_acum = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
	
	var ds_auxiliar_cuenta_gasto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
	///////////////////////// 
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_activo_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false
	};
	Atributos[1]={
			validacion:{
				name: 'id_tipo_activo_cuenta',
				fieldLabel: 'Identificador',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 60,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:60, // ancho de columna en el gris
				grid_indice:1
			},
			form:false,
			tipo: 'Field',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,

		};
	Atributos[2]={
			validacion:{
				name: 'codigo_programa',
				fieldLabel: 'Codigo Programa',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 350,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				grid_indice:2,
				width_grid:60 // ancho de columna en el gris
			},
			form:false,
			tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true
		};
	Atributos[3]={
			validacion:{
				name: 'id_tipo_activo',
				fieldLabel: 'Tipo Activo',
				vtype:"texto",
				allowBlank: false,
				emptyText:'Tipo Activo...',
				displayField: 'descripcion',
				desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo,
				valueField: 'id_tipo_activo',
				queryParam: 'filterValue_0',
				filterCol:'tipo.descripcion',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:250,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',  
				editable:true,
				//vtype:"alphaLatino",	
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:110 ,// ancho de columna en el grid
				disabled:false
			},
			form:true,
			tipo: 'ComboBox',
			id_grupo:0,
			save_as:'id_tipo_activo'

		};
	/*Atributos[4]={
			validacion:{
				name: 'descripcion',
				fieldLabel: 'Descripcion',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 350,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:500 // ancho de columna en el gris
			},
			form:false,
			tipo: 'TextField',
			filtro_0:true,
			filtro_1:true,

		};*/
	Atributos[4]={
			validacion:{
				name: 'descripcion',
				fieldLabel: 'Descripcion',
				vtype:"texto",
				allowBlank: false,
				emptyText:'Tipo ...',
				displayField: 'descripcion',
				desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo,
				valueField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'tipo.descripcion',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:250,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',  
				editable:true,
				//vtype:"alphaLatino",	
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:110 ,// ancho de columna en el grid
				disabled:false
			},
			form:false,
			tipo: 'ComboBox',
			id_grupo:0,
			save_as:'descripcion_tipo_activo'

		};
	Atributos[5]={
			validacion: {
			name: 'descripcion_programa',
			fieldLabel: 'Programa',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			emptyText:'Programa...',
			store:new Ext.data.SimpleStore({fields:['id_programa','cod_programa'],data:[['GEN','Generacion'],['TRA', 'Transmision'],['DIST', 'Distribucion'],['ADM', 'Bienes de uso Administracion Central']]}),
			valueField:'cod_programa',
			displayField:'cod_programa',
			lazyRender:true,
			forceSelection:false,
			width_grid:100,
			width:250,
			grid_indice:3,
			grid_visible:true,			
			disabled:false
		},
		form:true,
		id_grupo:0,
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'descripcion_programa',
		defecto:' '
		};
	/*Atributos[5]={
			validacion:{
				name: 'id_tipo_activo',
				fieldLabel: 'Tipo Activo',
				vtype:"texto",
				allowBlank: false,
				emptyText:'Tipo Activo...',
				displayField: 'descripcion',
				desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo,
				valueField: 'id_tipo_activo',
				queryParam: 'filterValue_0',
				filterCol:'tipo.descripcion',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:250,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',  
				editable:true,
				//vtype:"alphaLatino",	
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:110 ,// ancho de columna en el grid
				disabled:false
			},
			form:true,
			tipo: 'ComboBox',
			id_grupo:0,
			save_as:'id_tipo_activo'

		};*/
	
	Atributos[6]={
		validacion:{
		fieldLabel:'Cuenta Activo',
		allowBlank:true,
		emptyText:'Cuenta Activo...',
		name:'cuenta_activo',
		desc:'cuenta_activo',
		store:ds_cta_activo,
		valueField:'id_cuenta',
		displayField:'nombre_cuenta',
		queryParam:'filterValue_0',
		filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
		tpl:tpl_cuenta_activo,
		typeAhead:false,
		forceSelection:false,
		allowPermit:true,
		mode:'remote',
		queryDelay:250,
		pageSize:10,
		minListWidth:'100%',
		grow:false,
		resizable:true,
		minChars:3,
		triggerAction:'all',
		//renderer:render_id_cta_activo,
		grid_visible:false,
		grid_editable:true,
		width:250,
		width_grid:250 // ancho de columna en el gris
	},
	tipo:'ComboBox',
	id_grupo:1,
	filtro_0:true,
	form: true,
	save_as:'cuenta_activo'	
	};
	Atributos[7]={
			validacion:{
			fieldLabel:'Codigo Activo Auxiliar',
			allowBlank:true,
			emptyText:'Codigo Activo Auxiliar',
			name:'cuenta_activo_auxiliar',
			desc:'cuenta_activo_auxiliar',
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			tpl:tpl_cta_aux,
			typeAhead:false,
			onSelect: function(record)
			{
				ClaseMadre_getComponente('cuenta_activo_auxiliar').setValue(record.data.id_auxiliar); 
				ClaseMadre_getComponente('aux_cuenta_activo').setValue(record.data.id_auxiliar); 
				ClaseMadre_getComponente('cuenta_activo_auxiliar').collapse();
			},
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			grid_visible:false,
			grid_editable:true,
			width:250,
			width_grid:250 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'desc_auxiliar',
		form: true,
		id_grupo:1,
		save_as:'hidden_aux_cta_activo'	
		};
	Atributos[8] = {
			validacion:{
				labelSeparator:'',
				name: 'aux_cuenta_activo',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false
			//save_as:'hidden_subtipo_activo'
		};
	
	Atributos[9]={
			validacion:{
			fieldLabel:'Cuenta Dep. Acumulada',
			allowBlank:true,
			emptyText:'Cuenta Depreciacion Acumulada...',
			name:'cuenta_dep_acumulada',
			desc:'cuenta_dep_acumulada',
			store:ds_cta_depacum,
			valueField:'id_cuenta',
			displayField:'nombre_cuenta',
			queryParam:'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			tpl:tpl_cuenta_depacum,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			//renderer:render_id_cta_activo,
			grid_visible:false,
			grid_editable:true,
			width:250,
			allowPermit:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		form: true,
		id_grupo:1,
		save_as:'cuenta_dep_acumulada'
		};
	Atributos[10]={
			validacion:{
			fieldLabel:'Codigo Dep.Acum. Auxiliar',
			allowBlank:true,
			emptyText:'Codigo Activo Auxiliar',
			name:'cuenta_dep_acumulada_auxiliar',
			desc:'cuenta_dep_acumulada_auxiliar',
			store:ds_auxiliar_dep_acum,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			tpl:tpl_cta_aux,
			typeAhead:false,
			onSelect: function(record)
			{
				ClaseMadre_getComponente('cuenta_dep_acumulada_auxiliar').setValue(record.data.id_auxiliar); 
				ClaseMadre_getComponente('aux_cta_dep_acumulada').setValue(record.data.id_auxiliar); 
				ClaseMadre_getComponente('cuenta_dep_acumulada_auxiliar').collapse();
			},
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			grid_visible:false,
			grid_editable:true,
			width:250,
			allowPermit:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'desc_auxiliar',
		form: true,
		id_grupo:1,
		save_as:'hidden_aux_cta_dep_acumulada'	
		};
		Atributos[11] = {
			validacion:{
				labelSeparator:'',
				name: 'aux_cta_dep_acumulada',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false
			//save_as:'hidden_subtipo_activo'
		};
		Atributos[12]={
				validacion:{
				fieldLabel:'Cuenta Gasto',
				allowBlank:true,
				emptyText:'Cuenta Gasto...',
				name:'cuenta_gasto',
				desc:'cuenta_gasto',
				store:ds_cta_gasto,
				valueField:'id_cuenta',
				displayField:'nombre_cuenta',
				queryParam:'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
				tpl:tpl_cuenta_gasto,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				//renderer:render_id_cta_activo,
				grid_visible:false,
				grid_editable:true,
				width:250,
				allowPermit:true,
				width_grid:250 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			form: true,
			id_grupo:1,
			save_as:'cuenta_gasto'
			};
		Atributos[13]={
				validacion:{
				fieldLabel:'Codigo Gasto Auxiliar',
				allowBlank:true,
				emptyText:'Codigo Gasto Auxiliar',
				name:'cuenta_gasto_auxiliar',
				desc:'cuenta_gasto_auxiliar',
				store:ds_auxiliar_cuenta_gasto,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam:'filterValue_0',
				filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				tpl:tpl_cta_aux,
				typeAhead:false,
				onSelect: function(record)
				{
					ClaseMadre_getComponente('cuenta_gasto_auxiliar').setValue(record.data.id_auxiliar); 
					ClaseMadre_getComponente('aux_cta_gasto').setValue(record.data.id_auxiliar); 
					ClaseMadre_getComponente('cuenta_gasto_auxiliar').collapse();
				},
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				grid_visible:false,
				grid_editable:false,
				width:250,
				allowPermit:true,
				width_grid:250 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'desc_auxiliar',
			form: true,
			id_grupo:1,
			save_as:'hidden_aux_cta_gasto'
			};
		Atributos[14] = {
				validacion:{
					labelSeparator:'',
					name: 'aux_cta_gasto',
					inputType:'hidden'
				},
				tipo: 'Field',
				filtro_0:false
				//save_as:'hidden_subtipo_activo'
			};
		
		Atributos[15] = {
				validacion: {
					name:'tension',
					fieldLabel: 'Tension',
					allowBlank:true,
					typeAhead:false,
					loadMask:true,
					triggerAction:'all',
					emptyText:'tension...',
					store:new Ext.data.SimpleStore({	fields:['cod_tension','desc_tension'],
														data:[
														      ['Alta','ALTA'],
														      ['Media', 'MEDIA'],
														      ['Baja', 'BAJA']
														       ]
													}),
					valueField:'cod_tension',
					displayField:'desc_tension',
					lazyRender:true,
					forceSelection:false,
					width_grid:100,
					triggerAction:'all',
					width:250,
					grid_visible:true,			
					disabled:false
					
				},
				form:true,
				id_grupo:0,
				tipo:'ComboBox',
				filtro_0:true,
				save_as:'id_tension1',
				defecto:' '
		
			};
		Atributos[16] = {
				validacion: {
					name:'tension_conductores',
					fieldLabel: 'Tension Conductores',
					allowBlank:true,
					typeAhead:false,
					loadMask:true,
					triggerAction:'all',
					emptyText:'tension conductores...',
					store:new Ext.data.SimpleStore({	fields:['cod_tension_conductores','desc_tension'],
														data:[
														      ['AltaBienAereo','Alta - Bienes en Produccion Aereo'],
														      ['AltaBienSub','Alta - Bienes en Produccion Subterraneo'],
														      ['MediaBienAereo','Media - Bienes en Produccion Aereo'],
														      ['MediaBienSub','Media - Bienes en Produccion Subterraneo'],
														      ['BajaBienAereo','Baja - Bienes en Produccion Aereo'],
														      ['BajaBienSubt','Baja - Bienes en Produccion Subterraneo']
														     ]
												    }),
					valueField:'cod_tension_conductores',
					displayField:'desc_tension',
					lazyRender:true,
					forceSelection:false,
					width_grid:100,
					triggerAction:'all',
					width:250,
					grid_visible:false,			
					disabled:true
					
				},
				form:true,
				id_grupo:0,
				tipo:'ComboBox',
				filtro_0:true,
				save_as:'id_tension2',
				defecto:' '
			};
		Atributos[17] = {
				validacion: {
					name:'tension_estructuras',
					fieldLabel: 'Tension Estructuras',
					allowBlank:true, 
					typeAhead:false,
					loadMask:true,
					triggerAction:'all',
					emptyText:'tension...',
					store:new Ext.data.SimpleStore({	fields:['cod_tension_estructuras','desc_tension'],
														data:[
														      ['AltaBien','Alta - Bienes en Produccion'],
														      ['AltaProp', 'Alta - Propiedad General'],
														      ['MediaBien', 'Media - Bienes en Produccion'],
														      ['MediaProp', 'Media - Propiedad General'],
														      ['BajaBien', 'Baja - Bienes en Produccion'],
														      ['BajaProp', 'Baja - Propiedad General']
														     ]
												    }),
					valueField:'cod_tension_estructuras',
					displayField:'desc_tension',
					lazyRender:true,
					forceSelection:false,
					width_grid:100,
					triggerAction:'all',
					width:250,
					grid_visible:false,			
					disabled:false
					
				},
				form:true,
				id_grupo:0,
				tipo:'ComboBox',
				filtro_0:true,
				save_as:'id_tension3',
				defecto:' '
			};
		Atributos[18]={
				validacion:{
					name: 'nombre_cuenta_activo',
					fieldLabel: 'Cuenta Activo',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:4,
					width_grid:350 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};
		Atributos[19]={
				validacion:{
					name: 'nombre_cuenta_activo_auxiliar',
					fieldLabel: 'Codigo Activo Auxiliar',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:5,
					width_grid:140 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};
		Atributos[20]={
				validacion:{
					name: 'nombre_cuenta_dep_acumulada',
					fieldLabel: 'Cuenta Dep. Acumulada',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:6,
					width_grid:400 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};
		Atributos[21]={
				validacion:{
					name: 'nombre_cuenta_dep_acumulada_auxiliar',
					fieldLabel: 'Codigo Dep. Acumulada Auxiliar',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:6,
					width_grid:140 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};
		Atributos[22]={
				validacion:{
					name: 'nombre_cuenta_gasto',
					fieldLabel: 'Cuenta Gasto',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:7,
					width_grid:350 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};
		Atributos[23]={
				validacion:{
					name: 'nombre_cuenta_gasto_auxiliar',
					fieldLabel: 'Codigo Gasto Auxiliar',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					width: 350,
					//vtype:"alphaLatino",
					vtype:"texto",		
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					grid_indice:7,
					width_grid:140 // ancho de columna en el gris
				},
				form:false,
				tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
				filtro_0:true,
				filtro_1:true
			};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'param_gral',grid_maestro:'grid-'+idContenedor};
	var layout_parametrizacion_cta_actifconin=new DocsLayoutMaestro(idContenedor);
	layout_parametrizacion_cta_actifconin.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametrizacion_cta_actifconin,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
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
		btnEliminar:{url:direccion+'../../../control/asociacion_tipo_ep_param_ctas/ActionEliminarTipoActivoCuenta.php'},
		Save:{url:direccion+'../../../control/asociacion_tipo_ep_param_ctas/ActionGuardarTipoActivoCuenta.php'},
		ConfirmSave:{url:direccion+'../../../control/asociacion_tipo_ep_param_ctas/ActionGuardarTipoActivoCuenta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:450,columnas:['90%'],
			grupos:[{tituloGrupo:'Descripcion',columna:0,id_grupo:0},
			        {tituloGrupo:'Cuentas',columna:0,id_grupo:1}],
			        
			width:'50%',
			minWidth:150,
			minHeight:200,	
			closable:true,
			titulo:'Parametrizacion Cunetas ACTIF-CONIN'
			//guardar:abrirVentana
			}
		};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	//para iniciar eventos en el formulario
		for(var i=0;i<Atributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}
		combo_cuenta_activo_aux = getComponente('cuenta_activo');
		function combo_id_cta_activo_OnSelect()
		{
			var id_cta_aux=combo_cuenta_activo_aux.getValue();
			componentes[7].store.baseParams={
											    m_id_cuenta:combo_cuenta_activo_aux.getValue(), 
												sw_reg_comp:'si'
											};
			componentes[7].modificado=true;
		}
		combo_cuenta_activo_aux.on('select',combo_id_cta_activo_OnSelect);
		combo_cuenta_activo_aux.on('change',combo_id_cta_activo_OnSelect);
		//combo dep acum
		combo_cuenta_dep_acum_aux=getComponente('cuenta_dep_acumulada');
		function combo_id_cta_depacum_OnSelect()
		{
			var id_cta_aux=combo_cuenta_dep_acum_aux.getValue();
			componentes[10].store.baseParams={
											    m_id_cuenta:combo_cuenta_dep_acum_aux.getValue(), 
												sw_reg_comp:'si',
												prueba:'si'
											};
			componentes[10].modificado=true;
		}
		combo_cuenta_dep_acum_aux.on('select',combo_id_cta_depacum_OnSelect);
		combo_cuenta_dep_acum_aux.on('change',combo_id_cta_depacum_OnSelect);
		//combo cta gasto
		combo_cuenta_gasto_aux=getComponente('cuenta_gasto');
		function combo_id_cta_gasto_OnSelect()
		{
			var id_cta_aux=combo_cuenta_gasto_aux.getValue();
			componentes[13].store.baseParams={
											    m_id_cuenta:combo_cuenta_gasto_aux.getValue(), 
												sw_reg_comp:'si',
												prueba:'no'
											};
			componentes[13].modificado=true;
		}
		combo_cuenta_gasto_aux.on('select',combo_id_cta_gasto_OnSelect);
		combo_cuenta_gasto_aux.on('change',combo_id_cta_gasto_OnSelect);
		
		//control evento combo programa
		
		  
		/*combo_tension=getComponente('tension');
		 * combo_programa=getComponente('descripcion_programa');
		combo_tension=getComponente('tension');
		function onProgramaSelect()
		{
			if(combo_programa.getValue()=='Distribucion' )
			{
				CM_mostrarComponente(combo_tension);
				combo_tension.enable();
				combo_tension.setValue('');
				combo_tension.modificado=true;
			}
			else{
				CM_ocultarComponente(combo_tension);
				combo_tension.disable();
			}
		}
		combo_programa.on('change',onProgramaSelect);
		combo_programa.on('select',onProgramaSelect);
		*/
		//combos conductores y acecesorios
		combo_tension_conductores=getComponente('tension_conductores');
		combo_tension=getComponente('tension');
		combo_prog_aux=getComponente('descripcion_programa');
		combo_tipo_activo=getComponente('id_tipo_activo');
		combo_tension_estructuras=getComponente('tension_estructuras');
	
		
		function onProgAuxSelect()
		{
			if(combo_prog_aux.getValue()=='Distribucion' )
			{
					if(combo_tipo_activo.getValue()=='2' || combo_tipo_activo.getValue()=='3')
					{
						CM_mostrarComponente(combo_tension_estructuras);
						combo_tension_estructuras.enable();
						combo_tension_estructuras.setValue('');
						combo_tension_estructuras.modificado=true;
						
						CM_ocultarComponente(combo_tension_conductores);
						combo_tension_conductores.setValue('');
						combo_tension_conductores.disable();
					
						CM_ocultarComponente(combo_tension);
						combo_tension.setValue('');
	 					combo_tension.disable();
					}
					else
					{
						if(combo_tipo_activo.getValue()=='31' )
						{
							CM_ocultarComponente(combo_tension);
							combo_tension.setValue('');
							combo_tension.disable();
							
							CM_ocultarComponente(combo_tension_estructuras);
							combo_tension_conductores.setValue('');
							combo_tension_conductores.disable();
							
							CM_mostrarComponente(combo_tension_conductores);
							combo_tension_conductores.enable();
							combo_tension_conductores.setValue('');
							combo_tension_conductores.modificado=true;
						}
						else
						{
							CM_mostrarComponente(combo_tension);
							combo_tension.enable();
							combo_tension.setValue('');
							combo_tension.modificado=true;
							
							CM_ocultarComponente(combo_tension_estructuras);
							combo_tension_estructuras.setValue('');
							combo_tension_estructuras.disable();
							
							CM_ocultarComponente(combo_tension_conductores);
							combo_tension_conductores.setValue('');
							combo_tension_conductores.disable();
						}
					}
						
			}
			else
			{
				CM_ocultarComponente(combo_tension);
				combo_tension.setValue('');
				combo_tension.disable();
				
				CM_ocultarComponente(combo_tension_estructuras);
				combo_tension_estructuras.setValue('');
				combo_tension_estructuras.disable();
				
				CM_ocultarComponente(combo_tension_conductores);
				combo_tension_conductores.setValue('');
				combo_tension_conductores.disable();
			}
		}
		
		combo_prog_aux.on('change',onProgAuxSelect);
		combo_prog_aux.on('select',onProgAuxSelect);
	}
	
	
	this.btnNew=function()
	{
		//alert(combo_programa.getValue());
		CM_ocultarComponente(combo_tension_conductores);
		combo_tension_conductores.setValue('');
	  	//combo_tension_conductores.enable();
	  	
		CM_ocultarComponente(combo_tension);
		combo_tension.setValue('');
	  	//combo_tension.enable();
	  	
	  	CM_ocultarComponente(combo_tension_estructuras);
	  	combo_tension_estructuras.setValue('');
	  	//combo_tension_estructuras.enable();
	  	
		ClaseMadre_btnNew()
		};	
	this.btnEdit=function()
	{
		combo_tension_conductores.setValue('');
		combo_tension.setValue('');
		combo_tension_estructuras.setValue('');
		var sm=getSelectionModel();
		if(getSelectionModel().getCount()>0)
		{
			var SelectionsRecord=sm.getSelected();
			var tension=SelectionsRecord.data.tension;
		
			if(tension=="null"  || tension=="" || tension=="undefined" )
			{
				
				CM_ocultarComponente(combo_tension_conductores);
			  	combo_tension_conductores.disable();
			  	
				CM_ocultarComponente(combo_tension);
			  	combo_tension.disable();
			  	
			  	CM_ocultarComponente(combo_tension_estructuras);
			  	combo_tension_estructuras.disable();
			  	
			}
			else
			{
				
				if( 
						(tension=="Alta") || 
						(tension=="Media")|| 
						(tension=="Baja")
					)
				{
					CM_ocultarComponente(combo_tension_conductores);
				  	combo_tension_conductores.disable();
				  	
				  	CM_mostrarComponente(combo_tension);
				  	combo_tension.setValue(tension);
				  	combo_tension.enable();
				  	
				  	CM_ocultarComponente(combo_tension_estructuras);
				  	combo_tension_estructuras.disable();
				  	
				}
				if( 
					(tension=="AltaBienAereo") || (tension=="AltaBienSub") || 
					(tension=="MediaBienAereo") || (tension=="MediaBienSub") ||
					(tension=="BajaBienAereo") || (tension=="BajaBienSubt")
	
					)
				{
					
					CM_mostrarComponente(combo_tension_conductores);
					combo_tension_conductores.setValue(tension);
				  	combo_tension_conductores.enable();
				  	
				  	CM_ocultarComponente(combo_tension);
				  	combo_tension.disable();
				  	
				  	CM_ocultarComponente(combo_tension_estructuras);
				  	combo_tension_estructuras.disable();
				}
				if(
						(tension=="AltaBien") || (tension=="AltaProp") ||
						(tension=="MediaBien") || (tension=="MediaProp") ||
						(tension=="BajaBien") || (tension=="BajaProp")
				   )
				{

					CM_ocultarComponente(combo_tension_conductores);
				  	combo_tension_conductores.disable();
				  	
				  	CM_ocultarComponente(combo_tension);
				  	combo_tension.disable();
				  	
				  	CM_mostrarComponente(combo_tension_estructuras);
				  	combo_tension_estructuras.setValue(tension);
				  	combo_tension_estructuras.enable();
				}
			}
			
		}
		ClaseMadre_btnEdit();
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_parametrizacion_cta_actifconin.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	this.iniciaFormulario();
	//InitRegistroTransaccion();
	iniciarEventosFormularios();
	layout_parametrizacion_cta_actifconin.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}