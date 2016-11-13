
//<script>
function PaginaReparacion()
{
	var vectorAtributos = new Array;
	var ds;
	var id_activo_fijo;
	//var id_tipo_activo;

	//Configuración página
	var paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		//FormularioEstructura:true,//indica si se tiene el los 5 combos de la estructura programatica en los formulario para que sean incluidos en las modificaciiones e iliminaciones
		FiltroAvanzado:true,
		grid_html:'ext-grid'

	//Configuración página
	/*paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false//indica si se tiene los 5 combos que la filtra la estructura programática*/
	};

	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creación del Data Store

	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	?>


	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/reparacion/ActionListaReparacion.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_reparacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'descripcion', type: 'string'},
		'id_reparacion',
		{name: 'fecha_desde', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		{name: 'fecha_hasta', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'problema', 
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'observaciones',
		'estado',
		'id_activo_fijo',
		'id_persona',
		'id_institucion',
		'des_activo_fijo',
		'des_persona',
		'des_institucion'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: $("maestro_id_activo_fijo").value
		}
	});


	/////DATA STORE COMBOS////////////
	ds_persona = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_seguridad/control/persona/ActionListaPersona.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'

		}, ['id_persona','desc_completonombre'])

	});
	
	
	ds_institucion = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/institucion/ActionListaInstitucion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'

		}, ['id_institucion','nombre'])

	});
	////////////////FUNCIONES RENDER ////////////
	function renderPersona(value, p, record){return String.format('{0}', record.data['des_persona']);}
	function renderInstitucion(value, p, record){return String.format('{0}', record.data['des_institucion']);}
	

	//function renderCaracteristicas(value, p, record){return String.format('{0}', record.data['desc_caracteristicas']);}


	////////// INICIA MAESTRO ///////////////////////
	var dataMaestro = [
	//['ID',$("maestro_id_activo_fijo").value],
	['Código Activo Fijo',$("maestro_codigo").value],
	['Descripción',$("maestro_descripcion").value],
	['Descripción larga',$("maestro_descripcion_larga").value]
	];

	var dsMaestro = new Ext.data.Store({
		proxy: new Ext.data.MemoryProxy(dataMaestro),
		reader: new Ext.data.ArrayReader({id: 0}, [
		{name: 'atributo'},
		{name: 'valor'}

		])
	});
	dsMaestro.load();

	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);

	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>' + value + '</i>';
	}

	// create the Grid
	var gridMaestro = new Ext.grid.Grid('maestro', {
		ds: dsMaestro,
		cm: cmMaestro
	});

	gridMaestro.render();


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_reparacion = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_reparacion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:200

		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_reparacion'
	}
	vectorAtributos[0] = paramId_reparacion;
	
	
	var paramFecha_desde = {
		validacion:{
			name: 'fecha_desde',
			fieldLabel: 'Fecha Inicio',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_desde',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFecha_desde;
	
	
	var paramFecha_hasta = {
		validacion:{
			name: 'fecha_hasta',
			fieldLabel: 'Fecha Fin',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:70 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_hasta',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2] = paramFecha_hasta;

	var paramProblema = {
		validacion:{
			name: 'problema',
			fieldLabel: 'Problema',
			allowBlank: false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_problema'
	}
	vectorAtributos[3] = paramProblema;
	
	
	
	
	var paramObservaciones= {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.observaciones',
		save_as:'txt_observaciones'
	}
	vectorAtributos[4] = paramObservaciones;
	
	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['activo', 'inactivo', 'eliminado'],
				data : Ext.reparacionCombo.estado // from states.js
			}),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'rep.estado',
		save_as:'txt_estado'
	}
	vectorAtributos[5] = paramEstado;

	/*******/
	var paramId_activo_fijo= {
		validacion:{
			name: 'id_activo_fijo',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo',
		defecto: $("maestro_id_activo_fijo").value
	}
	vectorAtributos[6] = paramId_activo_fijo;
	
	

///////////////////////
	
		
	
	var paramId_persona = {
		validacion:{
			fieldLabel: 'persona',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Persona...',
			name: 'id_persona',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'des_persona', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField:'desc_completonombre',
			queryParam: 'filterValue_0',
			filterCol:'genero',
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
			editable : true,
			renderer: renderPersona,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		
		tipo: 'ComboBox',
		save_as:'hidden_id_persona'
	}
	vectorAtributos[7] = paramId_persona;
				
	var paramId_institucion= {
		validacion:{
			fieldLabel: 'Institucion',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Institucion...',
			name: 'id_institucion',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'des_institucion', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
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
			renderer: renderInstitucion,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_institucion'
	}
	vectorAtributos[8] = paramId_institucion;
	
	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'rep.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[9] = paramFecha_reg;


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Activo Fijo Maestro",
		titulo_detalle:"Reparacion de Activos Fijos",
		grid_maestro:"maestro",
		grid_detalle:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);
	
	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor

	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},

		actualizar:{
			crear :true,
			separador:false
		}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	function iniciarEventosFormularios()
	{
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		combo_persona = ClaseMadre_getComponente('id_persona');
		combo_institucion = ClaseMadre_getComponente('id_institucion');
		
		function limpia_institucion()
		{
			if(combo_persona.getValue() != "")
			{
				combo_institucion.setValue("");
			}
			
		}
		
		function limpia_persona()
		{
			if(combo_institucion.getValue() != "")
			{
				combo_persona.setValue("");
			}
			
		}
		
		combo_persona.on('valid',limpia_institucion);
		combo_institucion.on('valid',limpia_persona);
	}


	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{

			url:"../../control/reparacion/ActionEliminaReparacion.php"
		},
		Save:{
			url:"../../control/reparacion/ActionSaveReparacion.php"
		},
		ConfirmSave:{
			url:"../../control/reparacion/ActionSaveReparacion.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:480,
			height:400,
			minWidth:150,
			minHeight:200,
			closable:true
		}
	}
	
	function get_fecha_bd()
	{
		var postData;
		var hcallback =
		{
			success:  cargar_fecha_bd,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};

		YAHOO.util.Connect.asyncRequest('POST', '../../../lib/lib_control/action/ActionObtenerFechaBD.php', hcallback, postData);
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}

	//sobrecarga


	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		get_fecha_bd();
	}
	
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout


}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaReparacion();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo