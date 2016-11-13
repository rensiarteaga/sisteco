/*** Nombre:		  	pagina_aprobacion_proceso.js
* Propósito: 			pagina objeto principal
* Autor:				Mercedes Zambrana MEneses
* Fecha creación:		2010-07-20
*/
function pagina_aprobacion_proceso(idContenedor,direccion,paramConfig,usuario){
	var Atributos=new Array,sw=0;
	var data='';
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
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_org',
			'id_proceso',
			'descripcion_proceso',
			'descripcion', 
			
			'estado', 
			'id_tipo_activo',
			'descripcion_tipo', 
			'id_sub_tipo_activo',
			'descripcion_sub_tipo',
			'id_fina_regi_prog_proy_acti_org',
			'desc_epe_org', 
			'id_unidad_organizacional_org',
			'desc_epe_des',
			
			'agrupador', 
			'id_depto_des',
			'depto_origen',
			'depto_destino','desc_unidad_organizacional_org','desc_unidad_organizacional_des','id_gestion','gestion',
			{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
			'codigo_financiador',
			'codigo_regional',
			'codigo_programa','codigo_proyecto','codigo_actividad',
			'codigo_financiador_des',
			'codigo_regional_des',
			'codigo_programa_des','codigo_proyecto_des','codigo_actividad_des','codigo_proceso','desc_proceso','cant_af_proceso',
			{name: 'fecha_contabilizacion', type: 'date', dateFormat: 'Y-m-d'},
		]),
		remoteSort: true // metodo de ordenacion remoto
	});



	/////////////////////////
	// Definición de datos //
	/////////////////////////


	//en la posición 0 siempre tiene que estar la llave primaria
	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_grupo_proceso',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_grupo_proceso'
	};
	
	Atributos[2]={
		validacion:{
			name: 'fecha_contabilizacion',
			fieldLabel: 'Fecha Contabilización',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled: false,
			width:150,
			grid_indice:31
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'gr.fecha_contabilizacion',
		filtro_1:true,
		save_as:'fecha_contabilizacion',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"", // valor por default para este campo
		id_grupo:0
	}
	
	
	
	Atributos[3] = {
		validacion:{
			fieldLabel: 'Proceso',
			vtype:"texto",
			name: 'desc_proceso',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};

	
	Atributos[1] = {
		validacion:{
			fieldLabel: 'Unidad AF Origen',
			vtype:"texto",
			name: 'depto_origen',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
	/*Atributos[1]={
			validacion:{
				name:'id_depto_org',
				fieldLabel:'Unidad AF Origen',
				allowBlank:false,
				emptyText:'Unidad Activos Fijos...',
				desc: 'depto_origen', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:220,
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
				width:250,
				disabled:false,
				grid_indice:5
				
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'DEP.nombre',
			save_as:'id_depto_org',
			id_grupo:0
		};*/
	
	Atributos[4] = {
		validacion:{
			fieldLabel: 'Unidad AF Destino',
			vtype:"texto",
			name: 'depto_destino',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
		
		
	/*	Atributos[4]={
			validacion:{
				name:'id_depto_des',
				fieldLabel:'Unidad AF Destino',
				allowBlank:true,
				emptyText:'Unidad Activos Fijos...',
				desc: 'depto_destino', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:220,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto_destino,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:7
				
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'DEP.nombre',
			save_as:'id_depto_des',
			id_grupo:2
		};*/
	
	Atributos[5] = {
		validacion:{
			fieldLabel: 'EP Origen',
			vtype:"texto",
			name: 'desc_epe_org',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
		
	/*Atributos[5]={
			validacion:{
				name:'id_fina_regi_prog_proy_acti_org',
				fieldLabel:'EP Origen',
				allowBlank:true,
				emptyText:'EP Origen...',
				desc: 'desc_epe_org', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_ep_origen,
				valueField: 'id_fina_regi_prog_proy_acti',
				displayField: 'desc_ep',
				queryParam: 'filterValue_0',
				filterCol:'financ.nombre_financiador#region.nombre_regional#progra.nombre_programa#proyec.nombre_proyecto#activi.nombre_actividad',
				typeAhead:false,
				tpl:tpl_id_ep_origen,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:220,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_ep_origen,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:5
				
			},
			tipo:'ComboBox',
			form:true,
			filtro_0:true,			
		//	filterColValue:'FINANC.codigo_financiador#FINANC.nombre_financiador#REGION.codigo_regional#REGION.nombre_regional#PROGRA.codigo_programa#PROGRA.nombre_programa#PROYEC.codigo_proyecto#PROYEC.nombre_proyecto#ACTIVI.codigo_actividad#ACTIVI.nombre_actividad',
		filterColValue:'eporg.desc_epe#eporg.codigo_financiador#eporg.codigo_regional#eporg.codigo_programa#eporg.codigo_proyecto#eporg.codigo_actividad',
			save_as:'id_frppa_org',
			id_grupo:1
		};*/
	
		
	Atributos[6] = {
		validacion:{
			fieldLabel: 'EP Destino',
			vtype:"texto",
			name: 'desc_epe_des',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};		
		
	/*Atributos[6]={
			validacion:{
				name:'id_fina_regi_prog_proy_acti_des',
				fieldLabel:'EP Destino',
				allowBlank:true,
				emptyText:'EP Destino...',
				desc: 'desc_epe_des', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_ep_destino,
				valueField: 'id_fina_regi_prog_proy_acti',
				displayField: 'desc_frppa',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_ep_destino,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:220,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_ep_destino,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:7
				
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:false,
			filterColValue:'epdes.desc_epe',
			save_as:'id_frppa_des',
			id_grupo:2
		};*/
	
	Atributos[7] = {
		validacion:{
			fieldLabel: 'UO Origen',
			vtype:"texto",
			name: 'desc_unidad_organizacional_org',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
		
		
	/*Atributos[7]= {
		validacion:{
			fieldLabel: 'UO Origen',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Unidad Organizacional...',
			name: 'id_unidad_organizacional_org',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_unidad_organizacional_org',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'nombre_unidad',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 200,
			width:250,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_unidad_organizacional,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			//grid_indice:3
			grid_indice:5
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'id_uo_org',
		form:true,
		filterColValue:'uoorg.nombre_unidad',
		id_grupo:1
	}*/
	
	Atributos[8] = {
		validacion:{
			fieldLabel: 'UO Destino',
			vtype:"texto",
			name: 'desc_unidad_organizacional_des',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};

	
	/*Atributos[8]= {
		validacion:{
			fieldLabel: 'UO Destino',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Unidad Organizacional...',
			name: 'id_unidad_organizacional_des',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_unidad_organizacional_des',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_unidad_organizacional_destino,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'nombre_unidad',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 200,
			width:250,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_unidad_organizacional_destino,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			//grid_indice:3
			grid_indice:7
		},
		tipo: 'ComboBox',
		form:true,
		filtro_0:true,
		save_as:'id_uo_des',
		filterColValue:'uodes.nombre_unidad',
		id_grupo:2
	}*/
	
	
	Atributos[9] = {
		validacion:{
			fieldLabel: 'Agrupador',
			vtype:"texto",
			name: 'agrupador',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
	/*Atributos[9]={
		validacion: {
			name: 'agrupador',
			fieldLabel: 'Agrupador',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields:['id', 'desc'],
				data:[['tipo','Tipo AF'],['subtipo', 'Subtipo AF'],['individual','Individual']] // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65, // ancho de columna en el gris
			width:150,
			grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'gr.agrupador',
		filtro_1:true,
		save_as:'agrupador',
		defecto:'individual',
		id_grupo:0
	}*/
	
	Atributos[10] = {
		validacion:{
			fieldLabel: 'Tipo Af',
			vtype:"texto",
			name: 'descripcion_tipo',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
		/////////// hidden_id_tipo_activo//////
	/*Atributos[10] = {
		validacion:{
			fieldLabel: 'Tipo AF',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Tipo de Activo...',
			name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion_tipo',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo_activo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'codigo',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderTipoActivo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_tipo,
			grid_indice:3
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'id_tipo_activo',
		filterColValue:'TA.descripcion',
		id_grupo:0
	};


	filterCols_sub_tipo_activo = new Array();
	filterValues_sub_tipo_activo= new Array();
	filterCols_sub_tipo_activo[0] = 'tip.id_tipo_activo';
	filterValues_sub_tipo_activo[0] = '%';*/
	/////////// txt sub_tipo_activo//////
	
	Atributos[11] = {
		validacion:{
			fieldLabel: 'Subtipo AF',
			vtype:"texto",
			name: 'descripcion_sub_tipo',     //indica la columna del store principal "ds" del que proviane el id
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el gris
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_proceso',
		id_grupo:0
	};
	/*Atributos[11] = {
		validacion:{
			fieldLabel: 'Subtipo AF',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Subtipo...',
			name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion_sub_tipo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_sub_tipo_activo,
			valueField: 'id_sub_tipo_activo',//'id_sub_tipo_activo',
			displayField: 'descripcion',//'codigo',
			queryParam: 'filterValue_0',
			filterCol:'sub.codigo',
			filterCols:filterCols_sub_tipo_activo,
			filterValues:filterValues_sub_tipo_activo,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderSubtipoActivo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl:tpl_id_subtipo,
			grid_indice:4
		},
		tipo: 'ComboBox',
		save_as:'id_sub_tipo_activo',
		id_grupo:0
	};

	*/
	//proceso, descripcion agrupador
	/////////// txt codigo//////
	Atributos[12] = {
		/////////// txt de = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripcion',
			allowBlank: false,
			
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			disabled: false,
			grid_indice:1,
			width:200,
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'gr.descripcion',
		filtro_1:true,
		save_as:'descripcion',
		id_grupo: 0
	};



	Atributos[13]={
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled: true,
			width:200,
			grid_indice:31
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'gr.fecha_reg',
		filtro_1:true,
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"", // valor por default para este campo
		id_grupo:0
	}


//	 txt flag_revaloriz//////
//	Atributos[16]={
//		validacion: {
//			name: 'flag_revaloriz',
//			fieldLabel: 'Revalorizado',
//			typeAhead: true,
//			loadMask: true,
//			triggerAction: 'all',
//			store: new Ext.data.SimpleStore({
//				fields: ['si', 'no'],
//				data : [['si', 'Si'],['no', 'No']] // from states.js
//			}),
//			valueField:'si',
//			displayField:'no',
//			lazyRender:true,
//			forceSelection:true,
//			grid_visible:true, // se muestra en el grid
//			grid_editable:true, //es editable en el grid,
//			width_grid:70, // ancho de columna en el grid
//			width: '85%',
//			disabled: true,
//			width:200,
//			grid_indice:11
//		},
//		tipo:'ComboBox',
//		filtro_0:true,
//		filterColValue:'AF.flag_revaloriz',
//		filtro_1:true,
//		save_as:'txt_flag_revaloriz',
//		defecto: 'no',
//		id_grupo:0
//	}
	Atributos[14] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'estado',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'estado'
	};

	Atributos[15] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_gestion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_gestion'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Procesos de Activos Fijos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_grupo_proceso.php'};
	var layout_aprobacion_proceso=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_aprobacion_proceso.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////


	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_aprobacion_proceso,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var CM_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_enableSelect=this.EnableSelect;
	var CM_mostrarComponente=this.mostrarComponente;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu = {
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear :true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/grupo_proceso/ActionEliminarGrupoProceso.php'},
		Save:{url:direccion+'../../../control/grupo_proceso/ActionGuardarGrupoProceso.php'},
		ConfirmSave:{url:direccion+'../../../control/grupo_proceso/ActionGuardarGrupoProceso.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'45%',height:370,minWidth:150,minHeight:200,closable:true,
		columnas:['97%'],//,'45%'],
		titulo:'Proceso Activos Fijos'
		,
		grupos:[
		{	tituloGrupo:'Datos Proceso',	columna:0,	id_grupo:0	}/*,
		{	tituloGrupo:'Origen',columna:0,	id_grupo:1	},
		{	tituloGrupo:'Destino',columna:0,	id_grupo:2	}*/
		
		]
		}};



		this.EnableSelect=function(x,z,y){
			enable(x,z,y);
			_CP.getPagina(layout_aprobacion_proceso.getIdContentHijo()).pagina.reload(y.data);
			_CP.getPagina(layout_aprobacion_proceso.getIdContentHijo()).pagina.bloquearMenu();
			
		}

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function iniciarEventosFormularios(){
			///////////////////////////
			getSelectionModel().on('rowdeselect',function(){

				if(_CP.getPagina(layout_aprobacion_proceso.getIdContentHijo()).pagina.limpiarStore()){
					_CP.getPagina(layout_aprobacion_proceso.getIdContentHijo()).pagina.bloquearMenu()
				}
			})
		}
		
		function btn_aprobar(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();

					
						Ext.MessageBox.show({
							title: '<span style="font-size:13pt"> PROCESO '+SelectionsRecord.data.desc_proceso +'</span>' ,
							msg: 'Ingrese las observaciones de aprobación:',
							width:400,
							buttons: Ext.MessageBox.OK,
							multiline: true,
							fn: getObservaciones

						});
						
						data='id_grupo_proceso_0='+SelectionsRecord.data.id_grupo_proceso;
						data=data+'&opcion=aprobar';
					
				}

				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

			function btn_correccion(){
				data='';
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					Ext.MessageBox.show({
						title: '<span style="font-size:13pt"> PROCESO '+SelectionsRecord.data.desc_proceso +'</span>' ,
						msg: 'Ingrese observaciones para corrección:',
						width:300,
						buttons: Ext.MessageBox.OK,
						multiline: true,
						fn: getObservacionesC

					});
					data='id_grupo_proceso_0='+SelectionsRecord.data.id_grupo_proceso;
					data=data+'&opcion=corregir';
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function getObservaciones(btn,text){
				if(btn!='cancel'){
					observaciones=text;
					data=data+'&observaciones='+observaciones;
					data=data+"&filtro=gr.estado like 'pendiente'";
					Ext.Ajax.request({
						url:direccion+"../../../control/grupo_proceso/ActionGuardarGrupoProceso.php?"+data,
						method:'GET',
						success:esteSuccess,
						failure:Cm_conexionFailure,
						timeout:100000000
					});}
			}
			function getObservacionesC(btn,text){
				if(btn!='cancel'){
					observaciones=text;

					data=data+'&observaciones='+observaciones;
					data=data+"&filtro=gr.estado like 'pendiente'";

					Ext.Ajax.request({
						url:direccion+"../../../control/grupo_proceso/ActionGuardarGrupoProceso.php?"+data,
						method:'GET',
						success:esteSuccessC,
						failure:Cm_conexionFailure,
						timeout:100000000
					});}
			}


			function esteSuccess(resp){

				if(resp.responseXML&&resp.responseXML.documentElement){
					ClaseMadre_btnActualizar();
				}
				else{
					Cm_conexionFailure();
				}
			}
			function esteSuccessC(resp){
				if(resp.responseXML&&resp.responseXML.documentElement){

					ClaseMadre_btnActualizar();
				}
				else{
					Cm_conexionFailure();
				}
			}
	
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_aprobacion_proceso.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);

	
		//SOBRE CARGA DE FUNCIONES


		function enable(sel,row,selected){
			var record=selected.data;
			CM_enableSelect(sel,row,selected)
		}

		this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Proceso',btn_aprobar,true,'aprobar_proceso','Aprobación');
		this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'corregir_proceso','Corrección');
		
		this.iniciaFormulario();
		iniciarEventosFormularios();

		layout_aprobacion_proceso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);


		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				estado:'pendiente'
			}
		});

}


