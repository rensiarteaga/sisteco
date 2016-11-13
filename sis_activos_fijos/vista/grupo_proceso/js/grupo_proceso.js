/*** Nombre:		  	pagina_grupo_proceso.js
* Proposito: 			pagina objeto principal
* Autor:				Mercedes Zambrana MEneses
* Fecha creacion:		2010-07-07
*/
function pagina_grupo_proceso(idContenedor,direccion,paramConfig,usuario,estado_pagina){
	var Atributos=new Array,sw=0;
	var componentes=new Array
	//---DATA STORE
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/grupo_proceso/ActionListarGrupoProceso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_grupo_proceso',
			totalRecords: 'TotalCount'
		}, ['id_grupo_proceso',
		    'estado',
		    'descripcion',
		    'agrupador',
		    {name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		    {name: 'fecha_contabilizacion',type:'date',dateFormat:'Y-m-d'},
		    {name: 'fecha_devolucion',type:'date',dateFormat:'Y-m-d'},
		    'sw_prestamo',
		    'id_depto_org',
		    'desc_depto_ori',
		    'id_proceso',
		    'desc_proceso',
		    'id_depto_des',
		    'desc_depto_des',
		    'id_empleado_org',
		    'desc_empleado_ori',
		    'id_empleado_des',
		    'desc_empleado_des',
		    'id_presupuesto_org',
		    'desc_presupuesto_ori',
		    'id_presupuesto_des',
		    'desc_presupuesto_des',
		    'id_activo_fijo',
		    'desc_activo_fijo',
		    'codigo_proceso',
		    'sw_bien_responsabilidad',
		    'identificador',
		    'id_persona',
		    'custodio'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});


		var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','nombre_corto','nombre_largo'])
		});
	
		
		var ds_proceso= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/proceso/ActionListarProceso.php?sw_registrar=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proceso',totalRecords: 'TotalCount'},['id_proceso','codigo','descripcion'])
		});
		
		ds_activo_fijo_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy
	({url: direccion+'../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleadoActivos.php?deposito=no&band=1'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_activo_fijo_empleado',totalRecords: 'TotalCount'}, 
	['id_activo_fijo_empleado','estado','id_activo_fijo','id_empleado','desc_activo_fijo','desc_empleado','fecha_asig','descripcion_larga','codigo','id_empleado_anterior','desc_empleado_anterior'])});

		
		var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
		});
		
		var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
		});
		
		
		//mflores 22-09-11 para la asignacion por CUSTODIO
		var ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_persona',totalRecords: 'TotalCount'},['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','direccion','nro_registro','desc_per'])
	});

		function render_id_persona(value, p, record){return String.format('{0}', record.data['custodio']);}
	/*var tpl_id_persona=new Ext.Template('<div class="search-item">','{nombre} ','{apellido_paterno} ','{apellido_materno}','</div>');*/
		
	////////////////FUNCIONES RENDER ////////////

	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto_ori']);}
	function render_id_proceso(value, p, record){return String.format('{0}', record.data['codigo_proceso']);}
	function renderActivoFijoEmpleado(value, p, record){return String.format('{0}', record.data['desc_activo_fijo']);}
	function render_id_empleado_ori(value, p, record){return String.format('{0}', record.data['desc_empleado_ori']);}
	function render_id_empleado_des(value, p, record){return String.format('{0}', record.data['desc_empleado_des']);}
	function render_id_presupuesto_ori(value, p, record){return record.data['desc_presupuesto_ori'];}
	function render_id_presupuesto_des(value, p, record){return record.data['desc_presupuesto_des'];}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestion: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
	
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
		
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}','</div>');
	var tpl_id_proceso=new Ext.Template('<div class="search-item">','<b>{descripcion}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	
	var resultTplActivo=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>',
	'<br><FONT COLOR="#B5A642"><b>Descripcion: </b></FONT>{descripcion_larga}',
	'<br><FONT COLOR="#B5A642"><b>Resp./Custodio: </b></FONT>{desc_empleado}',
	'<br><FONT COLOR="#B5A642"><b>Estado: </b></FONT>{estado}',
	'<br><FONT COLOR="#B5A642"><b>ID Activo: </b></FONT>{id_activo_fijo}',
	'</div>');



	/////////////////////////
	// Definicion de datos //
	/////////////////////////


	//en la posicion 0 siempre tiene que estar la llave primaria
	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Identificador',
			labelSeparator:'',
			name: 'id_grupo_proceso',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false
		},
		tipo: 'Field'
	};
	
	
	Atributos[1]={
			validacion:{
				name:'id_depto_org',
				fieldLabel:'Departamento de AF',
				allowBlank:false,
				emptyText:'Departamento Activos Fijos...',
				desc: 'desc_depto_ori', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.nombre_depto',
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
				minChars:1, ///caracteres monimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:300,
				disabled:false,
				grid_indice:2
				
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:0
		};
	
	Atributos[2]={
		validacion:{
			name: 'fecha_contabilizacion',
			fieldLabel: 'Fecha Proceso',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			readOnly:true,
			//disabledDays: [0, 7],
			disabledDaysText: 'Dia no valido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			width:150,
			grid_indice:3
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'gru.fecha_contabilizacion',
		dateFormat:'m-d-Y', 
		id_grupo:0
	}
	
	
	Atributos[3] = {
		validacion:{
			fieldLabel: 'Proceso',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Proceso...',
			name: 'id_proceso',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'codigo_proceso',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_proceso,
			valueField: 'id_proceso',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'descripcion',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			width:300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_proceso,
			tpl:tpl_id_proceso,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,m	m	
			width_grid:200, // ancho de columna en el gris
			grid_indice:2
			
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'pro.descripcion',
		id_grupo:0
	};

	/////////// txt codigo//////
	Atributos[4] = {
		/////////// txt de = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripcion',
			allowBlank: false,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			disabled: false,
			grid_indice:4,
			width:300
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'gru.descripcion',
		id_grupo: 0
	};

	Atributos[5] = {
		validacion:{
			name: 'estado',
			fieldLabel: 'Estado',
			width_grid:120,
			grid_visible:true, // se muestra en el grid
			grid_indice:5,
			grid_editable:false //es editable en el grid
		},
		form:false,
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'gru.estado'
		
		
	};

	Atributos[6]={
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			format: 'd/m/Y', //formato para validacion
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			grid_indice:6
		},
		tipo:'DateField',
		dateFormat:'m-d-Y', 
		form:false		
	}

	

	Atributos[7] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field'
	};
	
	
	Atributos[8] = {
		validacion:{
			fieldLabel: 'Codigo de Activo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Codigo...',
			name: 'id_activo_fijo',
			desc: 'desc_activo_fijo',
			store: ds_activo_fijo_empleado,
			valueField:'id_activo_fijo_empleado',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'af.id_activo_fijo#af.codigo#af.descripcion',
			typeAhead: true,
			forceSelection: true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderActivoFijoEmpleado,
			tpl:resultTplActivo,
			triggerAction: 'all',
			typeAhead: false,
			selectOnFocus:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100,
			width:300,
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'afi.id_activo_fijo#afi.codigo#afi.descripcion',
		id_grupo:1
	};
	
	// txt id_empleado
	Atributos[9]={
			validacion:{
			name:'id_empleado_org',
			fieldLabel:'Responsable',
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_empleado_ori', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_ori,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EOR.nombre_completo',
		id_grupo:3		
	};
	
	// txt id_empleado
	Atributos[10]={
			validacion:{
			name:'id_empleado_des',
			fieldLabel:'Empleado Asignacion',
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_empleado_des', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado_des,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EDE.nombre_completo',
		id_grupo:2		
	};
	
	Atributos[11]={
			validacion:{
			name:'id_presupuesto_org',
			fieldLabel:'Origen',
			allowBlank:false,			
			emptyText:'Origen...',
			desc: 'desc_presupuesto_ori', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto_ori,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			disabled:false,
			grid_indice:10		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'POR.desc_presupuesto',
		id_grupo:4		
	};
	
	Atributos[12]={
			validacion:{
			name:'id_presupuesto_des',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Destino...',
			desc: 'desc_presupuesto_des', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto_des,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			disabled:false,
			grid_indice:11		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PDE.desc_presupuesto',
		id_grupo:4		
	};
	
	Atributos[13] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'codigo_proceso',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field'
	};
	
	Atributos[14]={
			validacion: {
			name:'sw_prestamo',
			fieldLabel:'Prestamo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:150,
			disabled:false,
			grid_indice:12		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'gru.sw_prestamo',
		defecto:'no',
		id_grupo:5		
	};
	Atributos[15] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'opcion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field'
	};
	
	Atributos[16]={
			validacion: {
			name: 'fecha_devolucion',
			fieldLabel: 'Fecha Devolucion',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			readOnly:true,
			//disabledDays: [0, 7],
			disabledDaysText: 'Dia no valido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			width:150,
			grid_indice:13
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'gru.fecha_devolucion',
		dateFormat:'m-d-Y', 
		id_grupo:5
	};
	
	//en la posicion 0 siempre tiene que estar la llave primaria 
	Atributos[17] = {
		validacion:{
			fieldLabel: 'Identificador',
			//labelSeparator:'',
			name: 'identificador',
			inputType:'hidden',
			grid_visible:true, // se muestra en el grid
			grid_editable:false,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'gru.id_grupo_proceso',
		form:false
	};
	
	// txt id_persona //mflores 22-09-11 para la asignacion por CUSTODIO
	Atributos[18]={
			validacion:{
			name:'id_persona',
			fieldLabel:'Custodio',
			allowBlank:true,			
			emptyText:'Persona...',
			desc: 'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			//tpl:tpl_id_persona,
			forceSelection:false,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_persona,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:false,
			grid_indice:13,
			confTrigguer:{
					url:direccion+'../../../../sis_seguridad/vista/persona/persona.php',
				    paramTri:'prueba:XXX',		
				    title:'Personas',
				    param:{width:800,height:800},
				    idContenedor:idContenedor,
				   // clase_vista:'pagina_persona'
				}		
		},
		tipo:'ComboTrigger',
		form: true,
		filtro_0:true,
		filterColValue:'per.apellido_paterno#per.apellido_materno#per.nombre',
		id_grupo:3
		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	if(estado_pagina=='borrador')
		var config={titulo_maestro:'Procesos de Activos Fijos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_grupo_proceso.php'};
	else if(estado_pagina=='en_prestamo')
		var config={titulo_maestro:'Procesos de Activos Fijos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_grupo_proceso_prestamo.php'};
	else
		var config={titulo_maestro:'Procesos de Activos Fijos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_grupo_proceso_no_borrador.php'};
		
	var layout_grupo_proceso=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_grupo_proceso.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////


	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_grupo_proceso,idContenedor);
	
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var CM_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_Save=this.Save;
	
	///////////////////////////////////
	// DEFINICION DE LA BARRA DE MENU//
	///////////////////////////////////
	
	if(estado_pagina=='borrador'){
		var paramMenu = {
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear :true,separador:false}
		};
	}
	else{
		var paramMenu = {
			actualizar:{crear :true,separador:false}
		};
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICION DE FUNCIONES ------------------------- //
	//  aqui se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/grupo_proceso/ActionEliminarGrupoProceso.php',parametros:'&estado=borrador'},
		Save:{url:direccion+'../../../control/grupo_proceso/ActionGuardarGrupoProceso.php',parametros:'&estado=borrador'},
		ConfirmSave:{url:direccion+'../../../control/grupo_proceso/ActionGuardarGrupoProceso.php',parametros:'&estado=borrador'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'80%',height:370,minWidth:150,minHeight:200,closable:true,
		columnas:['47%','47%'],//,'45%'],
		titulo:'Proceso Activos Fijos'
		,
		grupos:[
		{	tituloGrupo:'Datos Proceso',	columna:0,	id_grupo:0	},
		{	tituloGrupo:'Activo Fijo',columna:1,	id_grupo:1	},
		{	tituloGrupo:'Empleado Asignacion',columna:1,	id_grupo:2	},
		{	tituloGrupo:'Responsable',columna:1,	id_grupo:3	},
		{	tituloGrupo:'Transferencia',columna:1,	id_grupo:4	},
		{	tituloGrupo:'Prestamo',columna:1,	id_grupo:5	}
		
		]
		}};



		this.EnableSelect=function(sm,row,rec){
			_CP.getPagina(layout_grupo_proceso.getIdContentHijo()).pagina.desbloquearMenu();
			_CP.getPagina(layout_grupo_proceso.getIdContentHijo()).pagina.reload(rec.data);
			enable(sm,row,rec);
			
		}

		//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
		function iniciarEventosFormularios(){
			///////////////////////////
			ds_depto.baseParams={usuario:usuario,
			subsistema:'actif'};
			ds_depto.modificado=true;
			for (var i=0;i<Atributos.length;i++){
			
				componentes[i]=CM_getComponente(Atributos[i].validacion.name);
			}
				
			
			getSelectionModel().on('rowdeselect',function(){

				if(_CP.getPagina(layout_grupo_proceso.getIdContentHijo()).pagina.limpiarStore()){
					_CP.getPagina(layout_grupo_proceso.getIdContentHijo()).pagina.bloquearMenu()
				}
			})
			
			componentes[3].on('select',evento_proceso);
			componentes[2].on('change',evento_fecha);
			componentes[14].on('select',evento_prestamo);
			componentes[8].on('select',evento_activo)
		}
		
		function evento_fecha(campo){
			
			
			componentes[12].reset();
			componentes[11].reset();
			
			getGestion(campo.getValue().getFullYear());
			
		}
		function getGestion(anio){
					Ext.Ajax.request({
							url:direccion+"../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=plan_pago&sgte_gestion=no&anio="+anio,

						method:'GET',
						success:cargar_gestion,
						failure:Cm_conexionFailure,
						timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
					});
					
					
					Ext.MessageBox.show({
							title: 'Espere por favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Cargando Gestion del Proceso...</div>",
							width:150,
							height:200,
							closable:false
					});
		}
		function cargar_gestion(resp){
					Ext.MessageBox.hide();
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
                            
							CM_getComponente('id_gestion').setValue(root.getElementsByTagName('id_gestion')[0].firstChild.nodeValue);
							componentes[12].store.baseParams={id_gestion:CM_getComponente('id_gestion').getValue()};
							componentes[12].modificado=true;
							componentes[11].store.baseParams={id_gestion:CM_getComponente('id_gestion').getValue()};
							componentes[11].modificado=true;
														
						}else{
							CM_getComponente('id_gestion').setValue('');
						}
					}
				}
		
		
		function evento_proceso(combo, record, index ){
			if(componentes[2].getValue()=='' || componentes[2].getValue()==undefined){
				Ext.MessageBox.alert('Estado','Primero debe seleccionar la fecha del proceso');
				componentes[3].reset();
			}
			else{
				mostrarGruposPorProceso(record.data.codigo);
			}
		}
		
		function evento_prestamo(combo,record,index){
			if(record.data.sw_prestamo=='si')
				componentes[16].allowBlank=false;
			else
				componentes[16].allowBlank=true;
		}
		function evento_activo(combo, record, index ){
			componentes[9].setValue(record.data.id_empleado);
			componentes[9].setRawValue(record.data.desc_empleado);
		}
		
		
		function mostrarGruposPorProceso(codigo){
			var aux=new String(codigo);
			CM_ocultarGrupo('Activo Fijo');
			CM_ocultarGrupo('Empleado Asignacion');
			CM_ocultarGrupo('Responsable');
			CM_ocultarGrupo('Transferencia');
			CM_ocultarGrupo('Prestamo');
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(4);
			SiBlancosGrupo(5);
			var pos=aux.indexOf('-');
			if(pos>-1){
				componentes[13].setValue(aux.substring(0,pos-1));
				
			}
			else{
				componentes[13].setValue(codigo);
			}
			
			if(aux.substring(0,4)=='REVA' ||aux.substring(0,4)=='ALTA' || aux.substring(0,4)=='BAJA' || aux.substring(0,6)=='MEJACT'){
				
			}
			else if(aux.substring(0,5)=='REACT'){
				CM_mostrarGrupo('Activo Fijo');
				CM_mostrarGrupo('Empleado Asignacion');
				//NoBlancosGrupo(1);
				SiBlancosGrupo(1);
				NoBlancosGrupo(2);
			}
			else if(aux.substring(0,6)=='REAEMP'){
				CM_mostrarGrupo('Responsable');
				CM_ocultarComponente(componentes[18]);
				CM_mostrarGrupo('Empleado Asignacion');
				NoBlancosGrupo(3);
				NoBlancosGrupo(2);
			}
			else if(aux.substring(0,4)=='TRAN'){
				CM_mostrarGrupo('Transferencia');
				NoBlancosGrupo(4);
				
				
			}
			else if(aux.substring(0,4)=='ASIG'){
				CM_mostrarGrupo('Empleado Asignacion');
				CM_ocultarComponente(componentes[18]);
				CM_mostrarGrupo('Prestamo');
				NoBlancosGrupo(5);
				NoBlancosGrupo(2);
				
			}
			else if(aux.substring(0,5)=='DEVOL'){
				CM_mostrarGrupo('Responsable');
				CM_ocultarComponente(componentes[18]);
				NoBlancosGrupo(3);
				
			}
			else if(aux.substring(0,4)=='CUST'){
				CM_mostrarGrupo('Responsable');
				CM_mostrarComponente(componentes[9]);
				CM_mostrarComponente(componentes[18]);
				CM_mostrarGrupo('Prestamo');
				NoBlancosGrupo(5);
				SiBlancosGrupo(2);				
			}
			
			else if(aux.substring(0,6)=='DEVCUS'){
				CM_mostrarGrupo('Responsable');
				//CM_ocultarComponente(componentes[9]);
				CM_mostrarComponente(componentes[18]);
				CM_mostrarGrupo('Prestamo');
				NoBlancosGrupo(5);
				SiBlancosGrupo(2);	
				SiBlancosGrupo(3);			
			}
			
		}
		
		function get_depto_af(){
					Ext.Ajax.request({
							url:direccion+"../../../../sis_parametros/control/depto/ActionListarDepartamento.php?usuario="+usuario+'&subsistema=actif',

						method:'GET',
						success:cargar_depto_af,
						failure:Cm_conexionFailure,
						timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
					});
					
					
					Ext.MessageBox.show({
							title: 'Espere por favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Cargando Unidad...</div>",
							width:150,
							height:200,
							closable:false
					});
		}
		function cargar_depto_af(resp){
					Ext.MessageBox.hide();
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
                            
							CM_getComponente('id_depto_org').setValue(root.getElementsByTagName('id_depto')[0].firstChild.nodeValue);
							CM_getComponente('id_depto_org').setRawValue(root.getElementsByTagName('nombre_depto')[0].firstChild.nodeValue);
														
						}else{
							CM_getComponente('id_depto_org').setValue('');
						}
					}
				}
	
		
		this.btnNew=function(){ 
			
			CM_mostrarGrupo('Datos Proceso');
			CM_ocultarGrupo('Activo Fijo');
			CM_ocultarGrupo('Empleado Asignacion');
			CM_ocultarGrupo('Responsable');
			CM_ocultarGrupo('Transferencia');
			CM_ocultarGrupo('Prestamo');
			NoBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(4);
			SiBlancosGrupo(5);
			componentes[15].reset();
			componentes[16].allowBlank=true;
			/*if(SelectionsRecord.data.sw_prestamo=='si')
				componentes[16].allowBlank=false;
			    CM_mostrarComponente(CM_getComponente('fecha_devolucion'));
			else{
				componentes[16].allowBlank=true;
				CM_ocultarComponente(CM_getComponente('fecha_devolucion'));
			}*/
			
			CM_btnNew();
			CM_mostrarComponente(componentes[3]);
			get_depto_af();			
			
		}
		
		this.btnEdit=function(){ 
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
				
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				NoBlancosGrupo(0);
				CM_mostrarGrupo('Datos Proceso');
				
				mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
				if(SelectionsRecord.data.sw_prestamo=='si')
					componentes[16].allowBlank=false;				
				else
					componentes[16].allowBlank=true;			
				componentes[15].reset();
				CM_btnEdit();
				CM_ocultarComponente(componentes[3]);
			}else{
				alert('antes debe seleccionar un item');
			}
		}
		
		function btn_fin_grupo()
        {
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect=1){

			var SelectionsRecord=sm.getSelected();
			var aux=new String(SelectionsRecord.data.codigo_proceso);
			if(aux.substring(0,4)=='ALTA' || aux.substring(0,4)=='BAJA')
			{
				controlAsociacion(SelectionsRecord.data.id_grupo_proceso);
			}
			else
			{
				if(confirm("Esta seguro de finalizar el Proceso?"))
				{
					componentes[15].setValue('GRUFIN');
					mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
					CM_Save();
				}	
			}

			}
			else{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
			}

		}
			
		function btn_correccion(){
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect=1){

			var SelectionsRecord=sm.getSelected();
			if(estado_pagina=='en_prestamo')
				var accion='REVPRES';
			else if(estado_pagina=='pendiente')
				var accion='REVFIN'
			else
				var accion='REVAPRO'
			if(confirm("Esta seguro de finalizar el Proceso?")){
					componentes[15].setValue(accion);
					mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
					CM_Save();		
				}
			}
			else{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
			}
			
		}
		function btn_aprobar(){
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect=1){

			var SelectionsRecord=sm.getSelected();
			
			if(confirm("Esta seguro de aprobar el Proceso?")){

						componentes[15].setValue('GRUAPRO');
						mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
						CM_Save();	
					}
			}
			else{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
			}
		}
		function btn_devolucion(){
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			if(NumSelect=1){

			var SelectionsRecord=sm.getSelected();
			
			if(confirm("Esta seguro de registrar la devolucion de los activos del prestamo?")){

						componentes[15].setValue('FINPRES');
						mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
						CM_Save();	
					}
			}
			else{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
			}
			
		}
		function btn_reporte(){		
			var sm=getSelectionModel();				
			var NumSelect=sm.getCount();
					if(NumSelect==1){
						var SelectionsRecord=sm.getSelected();	
						var data='m_id_grupo_proceso='+SelectionsRecord.data.id_grupo_proceso;
						data=data+'&txt_desc_activo_fijo='+SelectionsRecord.data.desc_activo_fijo;
						data=data+'&txt_desc_depto_des='+SelectionsRecord.data.desc_depto_des;
						data=data+'&txt_desc_proceso='+SelectionsRecord.data.codigo_proceso;
						data=data+'&txt_desc_empleado_ori='+SelectionsRecord.data.desc_empleado_ori;
						data=data+'&txt_desc_empleado_des='+SelectionsRecord.data.desc_empleado_des;
						data=data+'&txt_sw_prestamo='+SelectionsRecord.data.sw_prestamo;
						data=data+'&txt_estado='+SelectionsRecord.data.estado;
						data=data+'&txt_descripcion='+SelectionsRecord.data.descripcion;
						data=data+'&txt_fecha_contabilizacion='+formatDate(SelectionsRecord.data.fecha_contabilizacion);
						data=data+'&txt_fecha_devolucion='+formatDate(SelectionsRecord.data.fecha_devolucion);
						data=data+'&custodio='+SelectionsRecord.data.custodio;
						data=data+'&txt_sw_devol_prestamo=no';
						
						window.open(direccion+'../../../../sis_activos_fijos/control/activo_fijo_proceso/ActionPDFListarActivoFijoProceso.php?'+data);					
					}
					else if(NumSelect>1) {
						Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
					}	
					else{
						Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
					}
		}
		
		function btn_reporte_devolucion(){		
			var sm=getSelectionModel();				
			var NumSelect=sm.getCount();
					if(NumSelect==1){
						var SelectionsRecord=sm.getSelected();	
						var data='m_id_grupo_proceso='+SelectionsRecord.data.id_grupo_proceso;
						data=data+'&txt_desc_activo_fijo='+SelectionsRecord.data.desc_activo_fijo;
						data=data+'&txt_desc_depto_des='+SelectionsRecord.data.desc_depto_des;
						data=data+'&txt_desc_proceso='+SelectionsRecord.data.codigo_proceso;
						data=data+'&txt_desc_empleado_ori='+SelectionsRecord.data.desc_empleado_ori;
						data=data+'&txt_desc_empleado_des='+SelectionsRecord.data.desc_empleado_des;
						data=data+'&txt_sw_prestamo='+SelectionsRecord.data.sw_prestamo;
						data=data+'&txt_estado='+SelectionsRecord.data.estado;
						data=data+'&txt_descripcion='+SelectionsRecord.data.descripcion;
						data=data+'&txt_fecha_contabilizacion='+formatDate(SelectionsRecord.data.fecha_contabilizacion);
						data=data+'&txt_fecha_devolucion='+formatDate(SelectionsRecord.data.fecha_devolucion);
						data=data+'&txt_sw_devol_prestamo=si';
						
						window.open(direccion+'../../../../sis_activos_fijos/control/activo_fijo_proceso/ActionPDFListarActivoFijoProceso.php?'+data);					
					}
					else if(NumSelect>1) {
						Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
					}	
					else{
						Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
					}
		}
		
		function btn_depreciacion_pdf(){		
			var sm=getSelectionModel();				
			var NumSelect=sm.getCount();
					if(NumSelect==1){
						var SelectionsRecord=sm.getSelected();
						var data='m_id_grupo_proceso='+SelectionsRecord.data.id_grupo_proceso;
						data=data+'&txt_fecha_contabilizacion='+formatDate(SelectionsRecord.data.fecha_contabilizacion);
						data=data+'&txt_descripcion='+SelectionsRecord.data.descripcion;
						window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionPDFActivoFijoDepreciacion.php?tipo_reporte=pdf&'+data);
					}
					else if(NumSelect>1) {
						Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
					}	
					else{
						Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
					}
		}
		
		function btn_depreciacion_exel(){		
			var sm=getSelectionModel();				
			var NumSelect=sm.getCount();
					if(NumSelect==1){
						var SelectionsRecord=sm.getSelected();
						var data='m_id_grupo_proceso='+SelectionsRecord.data.id_grupo_proceso;
						data=data+'&txt_fecha_contabilizacion='+formatDate(SelectionsRecord.data.fecha_contabilizacion);
						data=data+'&txt_descripcion='+SelectionsRecord.data.descripcion;
						window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/activo_fijo_depreciacion/ActionPDFActivoFijoDepreciacion.php?&'+data);					
					}
					else if(NumSelect>1) {
						Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
					}	
					else{
						Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
					}
		}
		
		function controlAsociacion(id_grupo_proceso)
		{
				Ext.MessageBox.hide();
				Ext.Ajax.request({
					url:direccion+"../../../control/activo_fijo_comprobantes/ActionListarActivoFijoComprobante.php",
					method:'POST',
					params:{control_asociacion:'si',cantidad_ids:'1',id_grupo_proceso:id_grupo_proceso},
					success:  controlAsociacionResp,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
		}

		function controlAsociacionResp(resp)
		{
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
			{
				var root = resp.responseXML.documentElement;

				if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue > 0)
				{

					if(confirm("Esta seguro de finalizar el Proceso?"))
					{
						componentes[15].setValue('GRUFIN');
						mostrarGruposPorProceso(SelectionsRecord.data.codigo_proceso);
						CM_Save();
					}
				}
				else
				{
					//alert('El Proceso no puede ser Finalizado, para finalizar el proceso\n debe Asociar las cuentas primeramente');
					Ext.MessageBox.alert('Error', 'Para finalizar el proceso :<n> '+SelectionsRecord.data.id_grupo_proceso+'  ('+SelectionsRecord.data.codigo_proceso+')</n></br> se deben asociar los activos fijos del mismo.');
				}
			}
		}
		
		function SiBlancosGrupo(grupo){
			for (var i=0;i<componentes.length;i++){
				
				if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=true;
			}
		}
		function NoBlancosGrupo(grupo){
			for (var i=0;i<componentes.length;i++){
				if(Atributos[i].id_grupo==grupo)
					componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
			}
		}
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_grupo_proceso.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		var CM_getBoton=this.getBoton;
		//InitBarraMenu(array DE PARAMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);
	
		//SOBRE CARGA DE FUNCIONES
		if(estado_pagina=='borrador'){
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Proceso',btn_fin_grupo,true,'fin_grupo','');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Formulario Asignacion/Transferencia/Devolucion',btn_reporte,true,'reporte','Formulario');
		}
		else if(estado_pagina=='pendiente'){
			this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Correccion',btn_correccion,true,'corregir_proceso','Correccion');
			this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Proceso',btn_aprobar,true,'aprobar_proceso','Aprobacion');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion PDF',btn_depreciacion_pdf,true,'reportePDF','ReportePDF');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion EXEL',btn_depreciacion_exel,true,'reporteXLS','ReporteEXEL');
		}
		else if(estado_pagina=='en_prestamo'){
			this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Correccion',btn_correccion,true,'corregir_proceso','Correccion');
			this.AdicionarBoton('../../../lib/imagenes/ok.png','Devolucion de prestamo',btn_devolucion,true,'devolucion_prestamo','Devolucion');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Formulario Prestamo',btn_reporte,true,'reporte','Formulario Prestamo');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Formulario Devolucion',btn_reporte_devolucion,true,'reporte_devolucion','Formulario Devolucion');
		}
		else if(estado_pagina=='aprobado'){
			this.AdicionarBoton('../../../lib/imagenes/det.ico','Revertir Aprobacion',btn_correccion,true,'revertir_aprobacion','Revertir Aprobacion');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion PDF',btn_depreciacion_pdf,true,'reportePDF','ReportePDF');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion EXEL',btn_depreciacion_exel,true,'reporteXLS','ReporteEXEL');
		}
		else if(estado_pagina=='finalizado'){
			this.AdicionarBoton('../../../lib/imagenes/report.png','Formulario Asignacion/Transferencia/Devolucion',btn_reporte,true,'reporte','Formulario');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Formulario Devolucion Prestamo',btn_reporte_devolucion,true,'reporte_devolucion','Form. Devolucion Prestamo');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion PDF',btn_depreciacion_pdf,true,'reportePDF','ReportePDF');
			this.AdicionarBoton('../../../lib/imagenes/report.png','Activo Fijo Depreciacion EXEL',btn_depreciacion_exel,true,'reporteXLS','ReporteEXEL');
		}
		function enable(sm,row,rec){
			CM_enableSelect(sm,row,rec);
			var aux=new String(rec.data['codigo_proceso']);
			if(estado_pagina=='finalizado' || estado_pagina=='en_prestamo'||  estado_pagina=='borrador')
			{
				//alert(aux.substring(0,5))
				
				if(aux.substring(0,6)=='REAEMP' || aux.substring(0,5)=='REACT' || aux.substring(0,4)=='ASIG' || aux.substring(0,5)=='DEVOL' || aux.substring(0,4)=='CUST' || aux.substring(0,6)=='DEVCUS')
				{
					
					CM_getBoton('reporte-'+idContenedor).enable();
				}
				else
				{
					CM_getBoton('reporte-'+idContenedor).disable();
				}
			}
			if(estado_pagina=='en_prestamo'||estado_pagina=='finalizado'){
				if(aux.substring(0,4)=='ASIG' && rec.data['sw_prestamo']=='si'){
					CM_getBoton('reporte_devolucion-'+idContenedor).enable();
				}
				else{
					CM_getBoton('reporte_devolucion-'+idContenedor).disable();
				}
			}
			if(estado_pagina=='finalizado'||estado_pagina=='aprobado')
			{
				if(aux.substring(0,5)=='DEPRE'){
					CM_getBoton('reportePDF-'+idContenedor).enable();
					CM_getBoton('reporteXLS-'+idContenedor).enable();
				}
				else{
					CM_getBoton('reportePDF-'+idContenedor).disable();
					CM_getBoton('reporteXLS-'+idContenedor).disable();
				}
			}
			
		}
		
		this.iniciaFormulario();
		iniciarEventosFormularios();

		layout_grupo_proceso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				estado:estado_pagina
			}
		});
}


