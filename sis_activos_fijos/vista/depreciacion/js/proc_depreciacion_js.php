
//<script>
function ProcesoDepreciacion()
{	var vectorAtributos = new Array;
	//Configuración página
	paramConfig = {
		TiempoEspera:10000//tiempo de espera para dar fallo
	};
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja     //

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////
	ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'

		}, ['id_financiador','nombre_financiador','codigo_financiador'])

	})

	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	})

	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'

		}, ['id_programa','nombre_programa'])//,
	})

	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'

		}, ['id_proyecto','nombre_proyecto'])//,
	})


	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'

		}, ['id_actividad','nombre_actividad'])//,
	})

	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/tipo_activo/ActionListaTipoActivoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_tipo_activo','descripcion'])

	})

	ds_sub_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/sub_tipo_activo/ActionListaSubtipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'

		}, ['id_sub_tipo_activo','descripcion'])

	})

	/*ds_unidad_constructiva = new Ext.data.Store({
	// asigna url de donde se cargaran los datos

	proxy: new Ext.data.HttpProxy({url: '../../control/unidad_constructiva/ActionListaUnidadConstructiva.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
	record: 'ROWS',
	id: 'id_unidad_constructiva',
	totalRecords: 'TotalCount'

	}, ['id_unidad_constructiva','descripcion'])

	})*/

	ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/activo_fijo/ActionListaActivoFijo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'

		}, ['id_activo_fijo','descripcion','codigo'])

	})

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
		id_grupo:1
	}
	vectorAtributos[0] = paramMes_fin;

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
		id_grupo: 1
	}
	vectorAtributos[1] = paramGestion_fin;


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
			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			
			editable : true
		},
		id_grupo:0,
		save_as:'txt_id_financiador',
		//defecto:'%',
		tipo: 'ComboBox'
	}
	vectorAtributos[2] = paramId_financiador;


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
		id_grupo:0,
		save_as:'txt_id_regional',
		//defecto:'%',
		tipo: 'ComboBox'
	}
	vectorAtributos[3] = paramId_regional;


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
		id_grupo:0,
		save_as:'txt_id_programa',
		tipo: 'ComboBox'
	}
	vectorAtributos[4] = paramId_programa;

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
			fieldLabel: 'Sub Programa',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Sub Programa...',
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
		id_grupo:0,
		save_as:'txt_id_proyecto',
		tipo: 'ComboBox'
	}
	vectorAtributos[5] = paramId_proyecto;

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
		id_grupo:0,
		save_as:'txt_id_actividad',
		tipo: 'ComboBox'
	}
	vectorAtributos[6] = paramId_actividad;

	
	
	/////////// txt tipo_activo//////
	
	filterCols_tipo_activo= new Array();
	filterValues_tipo_activo= new Array();
	filterCols_tipo_activo[0] = 'FINAN.id_financiador';
	filterValues_tipo_activo[0] = '%';
	filterCols_tipo_activo[1] = 'REGIO.id_regional';
	filterValues_tipo_activo[1] = '%';
	filterCols_tipo_activo[2] = 'PROG.id_programa';
	filterValues_tipo_activo[2] = '%';
	filterCols_tipo_activo[3] = 'PROY.id_proyecto';
	filterValues_tipo_activo[3] = '%';
	filterCols_tipo_activo[4] = 'ACTI.id_actividad';
	filterValues_tipo_activo[4] = '%';
	var paramId_tipo_activo = {
		validacion:{
			fieldLabel: 'Tipo Activo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Tipo Activo...',
			name:'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc:'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo,
			valueField:'id_tipo_activo',
			displayField:'descripcion',
			queryParam:'filterValue_0',
			filterCols:filterCols_tipo_activo,
			filterValues:filterValues_tipo_activo,
			filterCol:'TIPO.descripcion',
			typeAhead:true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'maestro_id_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[7] = paramId_tipo_activo;

	filterCols_sub_tipo = new Array();
	filterValues_sub_tipo = new Array();
	filterCols_sub_tipo[0] = 'SUB.id_tipo_activo';
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
		id_grupo:1,
		save_as:'maestro_id_sub_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[8] = paramId_sub_tipo;

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
			queryParam: 'filterValue_0',
			filterCol:'af.descripcion#af.codigo',
			filterCols:filterCols_activo_fijo,
			filterValues:filterValues_activo_fijo,
			typeAhead: false,
			forceSelection: false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la búsqueda
			triggerAction: 'all',
			editable : true
		},
		id_grupo:1,
		save_as:'txt_id_activo_fijo',
		tipo: 'ComboBox'
	}
	vectorAtributos[9] = paramId_activo_fijo;
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Depreciaciones"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración
//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametros;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_procesoSuccess = this.procesoSuccess;
	var ClaseMadre_getComponente = this.getComponente;
	//var getSelectionModel = this.getSelectionModel;

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
        combo_mes_fin = ClaseMadre_getComponente('mes_fin');
        combo_gestion_fin = ClaseMadre_getComponente('gestion_fin');
        
		/*combo_financiador.setValue('Todos los Financiadores');
		combo_regional.setValue('Todas las Regionales');
		combo_programa.setValue('Todos los Programas');
		combo_proyecto.setValue('Todos los Proyectos');
		combo_actividad.setValue('Todas las Actividades');*/
		
		combo_financiador.setValue('%');
		combo_regional.setValue('%');
		combo_programa.setValue('%');
		combo_proyecto.setValue('%');
		combo_actividad.setValue('%');
		
		
		      

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
			combo_tipo.filterValues[0] =  id;
			combo_tipo.modificado = true;
			combo_regional.setValue('');
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');
		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			combo_tipo.filterValues[1] =  id;
			combo_tipo.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			combo_tipo.filterValues[2] =  id;
			combo_tipo.modificado = true;
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_tipo.filterValues[3] =  id;
			combo_tipo.modificado = true;
			combo_actividad.setValue('');

		};
       var onActividadSelect = function(e) {
			var id = combo_actividad.getValue()
			combo_tipo.filterValues[4] =  id;
			combo_tipo.modificado = true;
			};
		var onTipoSelect = function(e) {
			var id = combo_tipo.getValue()
			combo_sub_tipo.filterValues[0] =  id;
			combo_sub_tipo.modificado = true;
			combo_activo_fijo.filterValues[0] =  id;
			combo_activo_fijo.modificado = true;
				
			combo_sub_tipo.setValue('');
			combo_activo_fijo.setValue('');
		};

		var onSubtipoSelect = function(e) {
			var id = combo_sub_tipo.getValue()
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;
			combo_activo_fijo.setValue('');
		};

		var onActivoSelect = function(e) {
			var gestion = combo_gestion_fin.getValue();
			var mes = combo_mes_fin.getValue();
			if(gestion==''){
				combo_gestion_fin.modificado=true;
				combo_gestion_fin.setValue('');
			}
			if(mes==''){
				combo_mes_fin.modificado=true;
				combo_mes_fin.setValue('');
			}
			
		};
		
		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
		combo_tipo.on('select', onActividadSelect);
		combo_tipo.on('change', onActividadSelect);
		combo_tipo.on('select', onTipoSelect);
		combo_tipo.on('change', onTipoSelect);
		combo_sub_tipo.on('select', onSubtipoSelect);
		combo_sub_tipo.on('change', onSubtipoSelect);
		combo_activo_fijo.on('select', onActivoSelect);
		combo_activo_fijo.on('change', onActivoSelect);


		///para el manejo de gestion fin
		//combo_gestion_ini = ClaseMadre_getComponente('gestion_ini');
		//combo_gestion_fin = ClaseMadre_getComponente('gestion_fin');
		/*var on_gestion_ini_Select = function(e) {
			var valor = combo_gestion_ini.getValue()
			combo_gestion_fin.store.removeAll()
			
			for(var i= valor; i <= 2050; i ++)
			{
				var  params = new Array();
				params['v1'] = i;
				var aux = new Ext.data.Record(params);
				combo_gestion_fin.store.add(aux)
			}
			
			

		};*/
		//combo_gestion_ini.on('select', on_gestion_ini_Select);
	}


	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	
	function obtenerTitulo()
	{
		var vMes_fin = ClaseMadre_getComponente('mes_fin');
		var vGestion_fin = ClaseMadre_getComponente('gestion_fin');
		return 'Depreciación: ' + vMes_fin.getValue() + '/' + vGestion_fin.getValue();
	}
	
	//Se sobrecarga la función procesosuccess para desplegar en la pestaña nueva el detalle de la depreciación
	function procesoSuccess(resp)
	{
		var cod_temp;
		var postData;
		
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			cod_temp = root.getElementsByTagName('codigo_temp')[0].firstChild.nodeValue;
			postData = "codigo_temp="+cod_temp;
		}
		
		//alert(postData);
		//Docs.loadTab(Funcion_Formulario.url+'?'+postData, titulo);
		var vTitulo = obtenerTitulo();
		Docs.loadTab('../depreciacion_temp/depreciacion_temp.php?'+postData, vTitulo);
	}

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../control/depreciacion/ActionDepreciar.php',
			abrir_pestana:false, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			success:procesoSuccess,
			columnas:[300,300],
			grupos:[
			{
				tituloGrupo:'Estructura Programática',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Parámetros generales',
				columna:1,
				id_grupo:1
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
{
	obj_pagina = new ProcesoDepreciacion();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo