/**
 * Nombre:		  	    pagina_metaproceso_det.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-10-26 16:42:31
 */
function pagina_metaproceso_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_metaproceso',
		'id_subsistema',
		'desc_subsistema',
		'fk_id_metaproceso',
		'desc_metaproceso',
		'nivel',
		'nombre',
		'codigo_procedimiento',
		'nombre_achivo',
		'ruta_archivo',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'descripcion',
		'visible',
		'habilitar_log',
		'orden_logico',
		'icono',
		'nombre_tabla',
		'prefijo',
		'codigo_base',
		'tipo_vista',
		'con_ep',
		'con_interfaz',
		'num_datos_hijo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_subsistema:maestro.id_subsistema
		}
	});
	
	// DEFINICI�N DATOS DEL MAESTRO
//var dataMaestro=[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripci�n',maestro.descripcion]];

	//var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_metaproceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso_det.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'
		}, ['id_metaproceso','id_subsistema','fk_id_metaproceso','nivel','nombre','codigo_procedimiento','nombre_achivo','ruta_archivo','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion','visible','habilitar_log','orden_logico','icono','nombre_tabla','prefijo','codigo_base','tipo_vista','con_ep','con_interfaz','num_datos_hijo'])
	});

	//FUNCIONES RENDER
	
			function render_fk_id_metaproceso(value, p, record){return String.format('{0}', record.data['desc_metaproceso']);};
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_metaproceso
	//en la posici�n 0 siempre esta la llave primaria

	var param_id_metaproceso = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_metaproceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_metaproceso'
	};
	vectorAtributos[0] = param_id_metaproceso;
// txt id_subsistema
	var param_id_subsistema= {
		validacion:{
			name:'id_subsistema',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_subsistema,
		save_as:'txt_id_subsistema'
	};
	vectorAtributos[1] = param_id_subsistema;
// txt fk_id_metaproceso
	var param_fk_id_metaproceso= {
			validacion: {
			name:'fk_id_metaproceso',
			fieldLabel:'Metaproceso Padre',
			allowBlank:false,			
			emptyText:'Metaproceso Padre...',
			desc: 'desc_metaproceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_metaproceso,
			valueField: 'id_metaproceso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'METPRO.nombre#METPRO.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_fk_id_metaproceso,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre',
		defecto: '',
		save_as:'txt_fk_id_metaproceso',
		id_grupo:0
	};
	vectorAtributos[2] = param_fk_id_metaproceso;
// txt nivel
	var param_nivel= {
		validacion:{
			name:'nivel',
			fieldLabel:'nivel',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'70%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nivel',
		save_as:'txt_nivel',
		id_grupo:1
	};
	vectorAtributos[3] = param_nivel;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	vectorAtributos[4] = param_nombre;
// txt codigo_procedimiento
	var param_codigo_procedimiento= {
		validacion:{
			name:'codigo_procedimiento',
			fieldLabel:'Codigo Proc',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'70%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.codigo_procedimiento',
		save_as:'txt_codigo_procedimiento',
		id_grupo:0
	};
	vectorAtributos[5] = param_codigo_procedimiento;
// txt nombre_achivo
	var param_nombre_achivo= {
		validacion:{
			name:'nombre_achivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid: 100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre_achivo',
		save_as:'txt_nombre_achivo',
		id_grupo:2
	};
	vectorAtributos[6] = param_nombre_achivo;
// txt ruta_archivo
	var param_ruta_archivo= {
		validacion:{
			name:'ruta_archivo',
			fieldLabel:'Ruta Archivo',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.ruta_archivo',
		save_as:'txt_ruta_archivo',
		id_grupo:2
	};
	vectorAtributos[7] = param_ruta_archivo;
// txt fecha_registro
	var param_fecha_registro= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Reg',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:3
	};
	vectorAtributos[8] = param_fecha_registro;
// txt hora_registro
	var param_hora_registro= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:3
	};
	vectorAtributos[9] = param_hora_registro;
// txt fecha_ultima_modificacion
	var param_fecha_ultima_modificacion= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Modificacion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:100,
			disabled:true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:4
	};
	vectorAtributos[10] = param_fecha_ultima_modificacion;
// txt hora_ultima_modificacion
	var param_hora_ultima_modificacion= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Modificacion',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:4
	};
	vectorAtributos[11] = param_hora_ultima_modificacion;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.descripcion',
		save_as:'txt_descripcion',
		id_grupo:0
	};
	vectorAtributos[12] = param_descripcion;
// txt visible
	var param_visible= {
			validacion: {
			name:'visible',
			fieldLabel:'Visible',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.visible
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60
			 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.visible',
		defecto:'si',
		save_as:'txt_visible',
		id_grupo:1
	};
	vectorAtributos[13] = param_visible;
// txt habilitar_log
	var param_habilitar_log= {
			validacion: {
			name:'habilitar_log',
			fieldLabel:'Habilitar Log',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.habilitar_log
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.habilitar_log',
		defecto:'si',
		save_as:'txt_habilitar_log',
		id_grupo:0
	};
	vectorAtributos[14] = param_habilitar_log;
// txt orden_logico
	var param_orden_logico= {
		validacion:{
			name:'orden_logico',
			fieldLabel:'Orden Logico',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.orden_logico',
		save_as:'txt_orden_logico',
		id_grupo:1
	};
	vectorAtributos[15] = param_orden_logico;
// txt icono
	var param_icono= {
		validacion:{
			name:'icono',
			fieldLabel:'Icono',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.icono',
		save_as:'txt_icono',
		id_grupo:1
	};
	vectorAtributos[16] = param_icono;
// txt nombre_tabla
	var param_nombre_tabla= {
		validacion:{
			name:'nombre_tabla',
			fieldLabel:'Nombre de la Tabla',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre_tabla',
		save_as:'txt_nombre_tabla',
		id_grupo:0
	};
	vectorAtributos[17] = param_nombre_tabla;
// txt prefijo
	var param_prefijo= {
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.prefijo',
		save_as:'txt_prefijo',
		id_grupo:0
	};
	vectorAtributos[18] = param_prefijo;
// txt codigo_base
	var param_codigo_base= {
		validacion:{
			name:'codigo_base',
			fieldLabel:'Codigo Base',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.codigo_base',
		save_as:'txt_codigo_base',
		id_grupo:0
	};
	vectorAtributos[19] = param_codigo_base;
// txt tipo_vista
	var param_tipo_vista= {
			validacion: {
			name:'tipo_vista',
			fieldLabel:'Tipo Vista',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.tipo_vista
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.tipo_vista',
		defecto:'padre',
		save_as:'txt_tipo_vista',
		id_grupo:1
	};
	vectorAtributos[20] = param_tipo_vista;
// txt con_ep
	var param_con_ep= {
			validacion: {
			name:'con_ep',
			fieldLabel:'Con EP',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.con_ep
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.con_ep',
		defecto:'si',
		save_as:'txt_con_ep',
		id_grupo:1
	};
	vectorAtributos[21] = param_con_ep;
// txt con_interfaz
	var param_con_interfaz= {
			validacion: {
			name:'con_interfaz',
			fieldLabel:'Con Interfaz',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.con_interfaz
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.con_interfaz',
		defecto:'si',
		save_as:'txt_con_interfaz',
		id_grupo:1
	};
	vectorAtributos[22] = param_con_interfaz;
// txt num_datos_hijo
	var param_num_datos_hijo= {
		validacion:{
			name:'num_datos_hijo',
			fieldLabel:'Numero datos de Hijo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.num_datos_hijo',
		save_as:'txt_num_datos_hijo',
		id_grupo:1
	};
	vectorAtributos[23] = param_num_datos_hijo;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Subsistema (Maestro)',
		titulo_detalle:'Metaproceso (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_metaproceso = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_metaproceso.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_metaproceso,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICI�N DE LA BARRA DE MEN�
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICI�N DE FUNCIONES
	//aqu� se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/metaproceso/ActionEliminarMetaproceso.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
	Save:{url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
	ConfirmSave:{url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php'},
	Formulario:{
			titulo:'Metaproceso',
			html_apply:"dlgInfo-"+idContenedor,
			width:'60%',
			height:'60%',
			minWidth:200,
			minHeight:150,
			columnas:[400,400],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos Logicos',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Vista',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Archivo',
				columna:1,
				id_grupo:2
			},
			
			{
				tituloGrupo:'Hora y Fecha Registro',
				columna:0,
				id_grupo:3
			},
			{
				tituloGrupo:'Hora y Fecha Modificacion',
				columna:0,
				id_grupo:4
			}
			]
		}
	};
	
	
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_subsistema=datos.m_id_subsistema;
		maestro.nombre_corto=datos.m_nombre_corto;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_subsistema:maestro.id_subsistema
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripcion',maestro.descripcion]]);
		vectorAtributos[1].defecto=maestro.id_usuario;
		var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/metaproceso/ActionEliminarMetaproceso.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
		Save:{url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php',parametros:'&m_id_subsistema='+maestro.id_subsistema},
		ConfirmSave:{url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php'},
		Formulario:{
			titulo:'Metaproceso',
			html_apply:"dlgInfo-"+idContenedor,
			width:'60%',
			height:'60%',
			minWidth:200,
			minHeight:150,
			columnas:[400,400],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos Lgicos',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Vista',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Archivo',
				columna:1,
				id_grupo:2
			},
			
			{
				tituloGrupo:'Hora y Fecha Registro',
				columna:0,
				id_grupo:3
			},
			{
				tituloGrupo:'Hora y Fecha Modificacion',
				columna:0,
				id_grupo:4
			}
			]
		}
	};
		this.InitFunciones(paramFunciones)
	};

	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
  this.btnNew = function()
	{
		//dialog.resizeTo('50%','70%');
		CM_mostrarGrupo('Datos Logicos');
		CM_mostrarGrupo('Datos Vista');
		CM_mostrarGrupo('Datos Archivo');
		CM_mostrarGrupo('Hora y Fecha Registro');
		CM_ocultarGrupo('Hora y Fecha Modificacion');
		ds_metaproceso.baseParams={m_id_subsistema:maestro.id_subsistema};
		get_fecha_bd();
		get_hora_bd();
		
		ClaseMadre_btnNew();
		
	};
	
	 this.btnEdit = function()
	{
		//dialog.resizeTo('50%','70%');
		CM_mostrarGrupo('Datos Logicos');
		CM_mostrarGrupo('Datos Vista');
		CM_mostrarGrupo('Datos Archivo');
		CM_ocultarGrupo('Hora y Fecha Registro');
		CM_mostrarGrupo('Hora y Fecha Modificacion');
		ds_metaproceso.baseParams={m_id_subsistema:maestro.id_subsistema};
		get_fecha_bd();
		get_hora_bd();
		ClaseMadre_btnEdit();
		
	};
    function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}
	function cargar_fecha_bd(resp)
	{   
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(componentes[8].getValue()=="")
			{
				componentes[8].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		   	componentes[10].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			
		}
	}
		function get_hora_bd()
		{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
			method:'GET',
			success:cargar_hora_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_hora_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
			if(componentes[9].getValue()==""){
					componentes[9].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				}
				componentes[11].setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
			}
		}
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	//para iniciar eventos en el formulario
	for(i=0;i<vectorAtributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();

	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){
		return layout_metaproceso.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_metaproceso.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}