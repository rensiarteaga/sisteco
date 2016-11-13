
//<script>
function ProcesoDepreciacion()
{

	var vectorAtributos = new Array;
	var ContPes = 1;

	//Configuración página
	paramConfig = {
		TiempoEspera:10000//tiempo de espera para dar fallo
	};


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria



	/////DATA STORE////////////
	ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'

		}, ['id_financiador','nombre_financiador','codigo_financiador'])

	})


	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	})

	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'

		}, ['id_programa','nombre_programa'])//,
	})

	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'

		}, ['id_proyecto','nombre_proyecto'])//,
	})


	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'

		}, ['id_actividad','nombre_actividad'])//,
	})

	///////para el grupo de activo
	
	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../../control/tipo_activo/ActionListaTipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_tipo_activo','descripcion'])

	})

	ds_sub_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_sub_tipo_activo','codigo','descripcion'])

	})



	ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../../control/activo_fijo/ActionListaActivoFijo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'

		}, ['id_activo_fijo','codigo','descripcion'])

	})

	//Define las columnas a desplegar
	////////// txt periodico//////
	var paramPeriodico = {
		validacion: {
			name: 'periodico',
			fieldLabel: 'Período',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['est','desc'],
				data : Ext.proc_depreciacionCombo.periodico
			}),
			valueField:'est',
			displayField:'desc',
			lazyRender: true,
			mode : 'local',
			forceSelection: true,
			grid_visible: true,
			grid_editable: true,
			width_grid: 65,
			width : 120,
			minChars:0
		},
		tipo:'ComboBox',
		save_as:'txt_periodico',
		id_grupo:0
	}
	vectorAtributos[0] = paramPeriodico;


	////////// txt mes_ini//////
var paramMes_ini = {
		validacion: {
			name: 'mes_ini',
			fieldLabel: 'Mes inicio',
			allowBlank: false,
			typeAhead: false,
			lazyRender: true,
			forceSelection: true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['mes', 'nombre'],
				data : Ext.proc_depreciacionCombo.meses
			}),
			valueField:'mes',
			displayField:'nombre',
			width: 120,
			minChars : 0
		},
		tipo:'ComboBox',
		save_as:'txt_mes_ini',
		id_grupo:0
	}
	vectorAtributos[1] = paramMes_ini;

	////////// txt gestion_ini//////
	var paramGestion_ini = {
		validacion:{
			name: 'gestion_ini',
			fieldLabel: 'Año inicio',
			allowBlank: false,
			maxLength:4,
			minLength:4,
			//selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1980,
			maxValue: 2050,
			minText: 'La fecha debe ser mayor a 1900',
			maxText: 'La fecha debe ser menor a 2050',
			nanText : 'Fecha no válida',
			minLengthText :'La fecha debe estar en formato yyyy',
			maxLengthText :'La fecha debe estar en formato yyyy',
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 80,
			typeAhead: false,
			//editable:true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['v1'],
				data : Ext.proc_depreciacionCombo.anos
			}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			forceSelection:true
		},
		tipo: 'ComboBox',
		save_as:'txt_gestion_ini',
		id_grupo: 0
	}
	vectorAtributos[2] = paramGestion_ini;



	////////// txt mes_ini//////
	var paramMes_fin = {
		validacion: {
			name: 'mes_fin',
			fieldLabel: 'Mes finalización',
			allowBlank: false,
			typeAhead: false,
			lazyRender:true,
			forceSelection:true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['mes', 'nombre'],
				data : Ext.proc_depreciacionCombo.meses
			}),
			valueField:'mes',
			displayField:'nombre',
			width_grid:65, // ancho de columna en el grid
			width: 120,
			minChars : 0
		},
		tipo:'ComboBox',
		save_as:'txt_mes_fin',
		id_grupo:0
	}
	vectorAtributos[3] = paramMes_fin;

	////////// txt gestion_ini//////
	var paramGestion_fin = {
		validacion:{
			name: 'gestion_fin',
			fieldLabel: 'Año finalización',
			allowBlank: false,
			maxLength:4,
			minLength:4,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1900,
			maxValue: 2050,
			minText: 'La fecha debe ser mayor a 1900',
			maxText: 'La fecha debe ser menor a 2050',
			nanText : 'Fecha no válida',
			minLengthText :'La fecha debe estar en formato yyyy',
			maxLengthText :'La fecha debe estar en formato yyyy',
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 80,

			typeAhead: false,
			//editable:true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['v1'],
				data : Ext.proc_depreciacionCombo.anos
			}),
			valueField:'v1',
			displayField:'v1',
			lazyRender:true,
			forceSelection:true

		},
		tipo: 'ComboBox',
		save_as:'txt_gestion_fin',
		id_grupo: 0
	}
	vectorAtributos[4] = paramGestion_fin;


	/////////// txt codigo//////
	var paramId_financiador = {
		validacion:{
			fieldLabel: 'Financiador',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Financiador...',
			name: 'id_financiador',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_financiador', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_financiador,
			valueField: 'id_financiador',
			displayField: 'nombre_financiador',
			queryParam: 'filterValue_0',
			filterCol:'nombre_financiador',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:2,
		save_as:'txt_id_financiador',
		tipo: 'ComboBox'
	}
	vectorAtributos[5] = paramId_financiador;


	filterCols_regional = new Array();
	filterValues_regional = new Array();
	filterCols_regional[0] = 'frppa.id_financiador';
	filterValues_regional[0] = '%';

	var paramId_regional = {
		validacion:{
			fieldLabel: 'Regional',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Regional...',
			name: 'id_regional',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_regional', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'nombre_regional',
			filterCols:filterCols_regional,
			filterValues:filterValues_regional,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:2,
		save_as:'txt_id_regional',
		tipo: 'ComboBox'
	}
	vectorAtributos[6] = paramId_regional;


	filterCols_programa= new Array();
	filterValues_programa= new Array();
	filterCols_programa[0] = 'frppa.id_financiador';
	filterValues_programa[0] = '%';
	filterCols_programa[1] = 'frppa.id_regional';
	filterValues_programa[1] = '%';

	var paramId_programa= {
		validacion:{
			fieldLabel: 'Programa',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Programa...',
			name: 'id_programa',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_programa', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'nombre_programa',
			filterCols:filterCols_programa,
			filterValues:filterValues_programa,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:2,
		save_as:'txt_id_programa',
		tipo: 'ComboBox'
	}
	vectorAtributos[7] = paramId_programa;

	filterCols_proyecto= new Array();
	filterValues_proyecto= new Array();
	filterCols_proyecto[0] = 'frppa.id_financiador';
	filterValues_proyecto[0] = '%';
	filterCols_proyecto[1] = 'frppa.id_regional';
	filterValues_proyecto[1] = '%';
	filterCols_proyecto[2] = 'ppa.id_programa';
	filterValues_proyecto[2] = '%';


	var paramId_proyecto= {
		validacion:{
			fieldLabel: 'Proyecto',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Proyecto...',
			name: 'id_proyecto',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_proyecto', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'nombre_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'nombre_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:2,
		save_as:'txt_id_proyecto',
		tipo: 'ComboBox'
	}
	vectorAtributos[8] = paramId_proyecto;

	filterCols_actividad= new Array();
	filterValues_actividad= new Array();
	filterCols_actividad[0] = 'frppa.id_financiador';
	filterValues_actividad[0] = '%';
	filterCols_actividad[1] = 'frppa.id_regional';
	filterValues_actividad[1] = '%';
	filterCols_actividad[2] = 'ppa.id_programa';
	filterValues_actividad[2] = '%';
	filterCols_actividad[3] = 'ppa.id_proyecto';
	filterValues_actividad[3] = '%';


	var paramId_actividad= {
		validacion:{
			fieldLabel: 'Actividad',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Actividad...',
			name: 'id_actividad',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'nombre_actividad', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_actividad ,
			valueField: 'id_actividad',
			displayField: 'nombre_actividad',
			queryParam: 'filterValue_0',
			filterCol:'nombre_actividad',
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad,
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:2,
		save_as:'txt_id_actividad',
		tipo: 'ComboBox'
	}
	vectorAtributos[9] = paramId_actividad;

	/////////// txt tipo_activo//////
	var paramId_tipo_activo = {
		validacion:{
			fieldLabel: 'Tipo Activo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Tipo Activo...',
			name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'tip.descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:1,
		save_as:'txt_id_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[10] = paramId_tipo_activo;

	filterCols_sub_tipo = new Array();
	filterValues_sub_tipo = new Array();
	filterCols_sub_tipo[0] = 'sub.id_tipo_activo';
	filterValues_sub_tipo[0] = '%';

	var paramId_sub_tipo = {
		validacion:{
			fieldLabel: 'Subtipo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Subtipo...',
			name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_sub_tipo,
			valueField: 'id_sub_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'sub.descripcion',
			filterCols:filterCols_sub_tipo,
			filterValues:filterValues_sub_tipo,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:1,
		save_as:'txt_id_sub_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[11] = paramId_sub_tipo;



	/*filterCols_activo_fijo = new Array();
	filterValues_activo_fijo = new Array();
	filterCols_activo_fijo[0] = 'af.id_sub_tipo_activo';
	filterValues_activo_fijo[0] = '%';*/

	filterCols_activo_fijo = new Array();
	filterValues_activo_fijo = new Array();
	filterCols_activo_fijo[0] = 'TIP.id_tipo_activo';
	filterValues_activo_fijo[0] = '%';
	filterCols_activo_fijo[1] = 'SUB.id_sub_tipo_activo';
	filterValues_activo_fijo[1] = '%';
	var paramId_activo_fijo = {
		validacion:{
			fieldLabel: 'Activo Fijo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Activo Fijo...',
			name: 'id_activo_fijo',     //indica la columna del store principal "ds" del que proviene el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_activo_fijo,
			valueField: 'id_activo_fijo',
			displayField: 'codigo',
			//displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'af.codigo',
			filterCols:filterCols_activo_fijo,
			filterValues:filterValues_activo_fijo,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:1,
		save_as:'txt_id_activo_fijo',
		tipo: 'ComboBox'
	}
	vectorAtributos[12] = paramId_activo_fijo;


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Depreciaciones"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;


	ds_financiador.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_regional.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_programa.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_proyecto.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_actividad.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_sub_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//ds_unidad_constructiva.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_activo_fijo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');
		combo_tipo = ClaseMadre_getComponente('id_tipo_activo');
		combo_sub_tipo = ClaseMadre_getComponente('id_sub_tipo_activo');
		//combo_unidad_constructiva = ClaseMadre_getComponente('id_unidad_constructiva');
		combo_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');


		var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0);
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params1 = new Array();
			params1['id_regional'] = '%';
			params1['nombre_regional'] = 'Todos las Regionales';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_regional.store.add(aux1);
			combo_regional.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');
			///////
			//combo_regional.setValue('');
			//combo_programa.setValue('');
			//combo_proyecto.setValue('');
			//combo_actividad.setValue('');

		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue();
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			var  params1 = new Array();
			
			
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params0 = new Array();
			params0['id_programa'] = '%';
			params0['nombre_programa'] = 'Todos los Programas';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_programa.store.add(aux0);
			combo_programa.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');

		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue();
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2);
			combo_proyecto.setValue('%');
			///////
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');
		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue();
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3);
			combo_actividad.setValue('%');

		};

		var onTipoSelect = function(e) {
			var id = combo_tipo.getValue();
			combo_sub_tipo.filterValues[0] =  id;
			combo_sub_tipo.modificado = true;
			combo_activo_fijo.filterValues[0] =  id;
			combo_activo_fijo.modificado = true;
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params1 = new Array();
			params1['id_sub_tipo_activo'] = '%';
			params1['descripcion'] = 'Todos los Subtipos de Activos';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_sub_tipo.store.add(aux1);
			combo_sub_tipo.setValue('%');
			///////
			
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos Fijos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');
			///////
		};

		var onSubtipoSelect = function(e) {
			var id = combo_sub_tipo.getValue();
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;
			
			//Carga el valor por defecto a la moneda principal como Bolivianos
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos Fijos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');
			///////
			//combo_activo_fijo.setValue('%');
		};

		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
		combo_tipo.on('select', onTipoSelect);
		combo_tipo.on('change', onTipoSelect);
		combo_sub_tipo.on('select', onSubtipoSelect);
		combo_sub_tipo.on('change', onSubtipoSelect);


		///para el manejo de gestion fin
		combo_gestion_ini = ClaseMadre_getComponente('gestion_ini');
		combo_gestion_fin = ClaseMadre_getComponente('gestion_fin');
		combo_mes_ini = ClaseMadre_getComponente('mes_ini');
		combo_mes_fin = ClaseMadre_getComponente('mes_fin');
		var on_gestion_ini_Select = function(e) {
			var valor = combo_gestion_ini.getValue();
			combo_gestion_fin.store.removeAll()
			for(var i= valor; i <= 2050; i ++)
			{
				var  params = new Array();
				params['v1'] = i;
				var aux = new Ext.data.Record(params);
				combo_gestion_fin.store.add(aux);
			}
		};
		combo_gestion_ini.on('select', on_gestion_ini_Select);

		combo_periodico = ClaseMadre_getComponente('periodico');

		var on_periodico_Select = function(e) {
			var valor = combo_periodico.getValue();
		
			if(valor == 'Si')
			{
				combo_gestion_ini.enable();
				combo_gestion_fin.enable();
				combo_mes_ini.enable();
				combo_mes_fin.enable();
			}
			else
			{
				combo_gestion_ini.disable();
				combo_gestion_fin.disable();
				combo_mes_ini.disable();
				combo_mes_fin.disable();
			}
		};
		
		combo_periodico.on('select', on_periodico_Select);
		
		combo_periodico.setValue('No');
		combo_gestion_ini.disable();
		combo_gestion_fin.disable();
		combo_mes_ini.disable();
		combo_mes_fin.disable();
	}


	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Rep. Depreciacion "+ ContPes;
		ContPes ++;
		return titulo;
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../../control/_reportes/depreciacion/ActionRptDepreciacion.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Periodo',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Activo Fijo',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Estructura Programática',
				columna:1,
				id_grupo:2
			}],
			parametros: ''
		}
	}
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)

	this.iniciaFormulario();
	iniciarEventosFormularios();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
}
var obj_pagina;
function main ()
{	obj_pagina = new ProcesoDepreciacion(); }
YAHOO.util.Event.on(window, 'load', main); //arranca todo