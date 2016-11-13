//<script>
function GenerarReporteTransferenciaActivosFijos()
{	var vectorAtributos = new Array;
    var ContPes = 1;
	//Configuración página
	paramConfig = {
		TiempoEspera:10000//tiempo de espera para dar fallo
	};

	//// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
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

	
	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../../control/tipo_activo/ActionListaTipoActivoEP.php?origen=filtro'}),
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
			record: 'ROWS',	id: 'id_sub_tipo_activo',	totalRecords: 'TotalCount'
		}, ['id_sub_tipo_activo','descripcion'])
	})
	
	ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos

		proxy: new Ext.data.HttpProxy({url: '../../../control/activo_fijo/ActionListaActivoFijo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'

		}, ['id_activo_fijo','descripcion','codigo'])

	})
	
	ds_unidad_organizacional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../control/unidad_organizacional/ActionListaUnidadOrganizacional.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_organizacional',
			totalRecords: 'TotalCount'
		}, ['id_unidad_organizacional','descripcion'])

	});


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
		id_grupo:0,
		save_as:'hidden_id_financiador',
		tipo: 'ComboBox'
	}
	//vectorAtributos[4] = paramId_financiador;
	vectorAtributos[0] = paramId_financiador;

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
		save_as:'hidden_id_regional',
		tipo: 'ComboBox'
	}
	//vectorAtributos[5] = paramId_regional;
	vectorAtributos[1] = paramId_regional;

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
		save_as:'hidden_id_programa',
		tipo: 'ComboBox'
	}
	//vectorAtributos[6] = paramId_programa;
	vectorAtributos[2] = paramId_programa;
	
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
		id_grupo:0,
		save_as:'hidden_id_proyecto',
		tipo: 'ComboBox'
	}
	//vectorAtributos[7] = paramId_proyecto;
	vectorAtributos[3] = paramId_proyecto;
	
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
		save_as:'hidden_id_actividad',
		tipo: 'ComboBox'
	}
	vectorAtributos[4] = paramId_actividad;
	
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
			name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'tip.descripcion',
			filterCols:filterCols_tipo_activo,
			filterValues:filterValues_tipo_activo,
			typeAhead: true,
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
		save_as:'hidden_id_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[5] = paramId_tipo_activo;
	
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
		save_as:'hidden_id_sub_tipo_activo',
		tipo: 'ComboBox'
	}
	vectorAtributos[6] = paramId_sub_tipo;
	
	
	
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
			filterCol:'af.descripcion',
			filterCols:filterCols_activo_fijo,
			filterValues:filterValues_activo_fijo,
			typeAhead: true,
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
		save_as:'hidden_id_activo_fijo',
		tipo: 'ComboBox'
	}
	vectorAtributos[7] = paramId_activo_fijo;
	
	/////////// hidden_id_unidad_organizacional//////
	var paramId_unidad_organizacional = {
		validacion:{
			fieldLabel: 'Unidad Organizacional',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Unidad Organizacional...',
			name: 'id_unidad_organizacional',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_unidad_organizacional', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'descripcion',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 200,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			//renderer: renderUnidadOrganizacional,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width:200,
			width_grid:200 // ancho de columna en el gris
		},
		    id_grupo:1,
		    tipo: 'ComboBox',
			save_as:'hidden_id_unidad_organizacional'
	}
	vectorAtributos[8] = paramId_unidad_organizacional;
	
	
		
////////// txt fecha_compra//////
var paramFecha_asig1 = {
	validacion:{
		name: 'fecha_asig',
		fieldLabel: 'Fecha de Compra (Inicio)',
		allowBlank: false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/1900',
		//disabledDays: [0, 7],
		disabledDaysText: 'Día no válido',
		grid_visible:true, // se muestra en el grid
		grid_editable:true, //es editable en el grid,
		renderer: formatDate,
		width_grid:120 // ancho de columna en el gris
		
	},
	tipo: 'DateField',
	filtro_1:true,
	save_as:'txt_fecha_asig1',
	dateFormat:'m-d-Y', //formato de fecha que envía para guardar
	defecto:"", // valor por default para este campo
	id_grupo:1
}
vectorAtributos[9] = paramFecha_asig1;
////////// txt fecha_compra//////
var paramFecha_asig2 = {
	validacion:{
		name: 'fecha_asig',
		fieldLabel: 'Fecha Asig (Fin)',
		allowBlank: false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/1900',
		//disabledDays: [0, 7],
		disabledDaysText: 'Día no válido',
		grid_visible:true, // se muestra en el grid
		grid_editable:true, //es editable en el grid,
		renderer: formatDate,
		width_grid:120 // ancho de columna en el gris
		
	},
	tipo: 'DateField',
	filtro_1:true,
	save_as:'txt_fecha_asig2',
	dateFormat:'m-d-Y', //formato de fecha que envía para guardar
	defecto:"", // valor por default para este campo
	id_grupo:1
}
vectorAtributos[10] = paramFecha_asig2;
	
	 //---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ----------            FUNCIONES RENDER    ---------------//
function formatDate(value){
	return value ? value.dateFormat('d/m/Y') : '';
};

	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Parámetros Para Transferencia de Activos "
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//---------         INICIAMOS HERENCIA           -----------//
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
	ds_sub_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); 
	ds_activo_fijo.addListener('loadexception',  ClaseMadre_conexionFailure); 
	ds_unidad_organizacional.addListener('loadexception',  ClaseMadre_conexionFailure);
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
		combo_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
		combo_unidad_organizacional = ClaseMadre_getComponente('id_unidad_organizacional');
		
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
			
			//Carga el valor por defecto de la regional
			var  params0 = new Array();
			params0['id_regional'] = '%';
			params0['nombre_regional'] = 'Todos las Regionales';
			var aux0 = new Ext.data.Record(params0,'%');
			combo_regional.store.add(aux0)
			combo_regional.setValue('%');
			///////			
			//Carga el valor por defecto del programa
			var  params1 = new Array();
			params1['id_programa'] = '%';
			params1['nombre_programa'] = 'Todos los Programas';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_programa.store.add(aux1)
			combo_programa.setValue('%');
			///////			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	
			
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
			
			//Carga el valor por defecto del programa
			var  params1 = new Array();
			params1['id_programa'] = '%';
			params1['nombre_programa'] = 'Todos los Programas';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_programa.store.add(aux1)
			combo_programa.setValue('%');
			///////			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	


		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			combo_tipo.filterValues[2] =  id;
			combo_tipo.modificado = true;
			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	


		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_tipo.filterValues[3] =  id;
			combo_tipo.modificado = true;
			
			//Carga el valor por defecto de la actividad
			var  params3 = new Array();
			params3['id_actividad'] = '%';
			params3['nombre_actividad'] = 'Todos las Actividades';
			var aux3 = new Ext.data.Record(params3,'%');
			combo_actividad.store.add(aux3)
			combo_actividad.setValue('%');	
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
					
		};
		
		var onSubtipoSelect = function(e) {
			var id = combo_sub_tipo.getValue()
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;
			combo_activo_fijo.setValue('');
		};
		
		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
	    combo_actividad.on('select', onActividadSelect);
		combo_actividad.on('change', onActividadSelect);
		combo_tipo.on('select', onTipoSelect);
		combo_tipo.on('change', onTipoSelect);
		combo_sub_tipo.on('select', onSubtipoSelect);
		combo_sub_tipo.on('change', onSubtipoSelect);
	

	}
///------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('mes_ini');
		//return combo_financiador.getValue();
		var titulo = "Reporte Transferencia de Activos Fijos "+ ContPes;
		ContPes ++;
		return titulo;
	}

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../../control/_reportes/activo_fijo_transferencia/ActionPDFActivoFijoTransferencia.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[380,380],
			grupos:[
			{
				tituloGrupo:'Estructura Programática',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Ingreso de Filtros para el Reporte',
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
{	//obj_proceso = new ProcesoDepreciacion();
	obj_pagina = new GenerarReporteTransferenciaActivosFijos();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo