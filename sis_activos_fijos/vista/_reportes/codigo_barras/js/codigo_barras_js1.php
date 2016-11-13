
//<script>
function GenerarReporteCodigoBarras()
{	var vectorAtributos = new Array;
	//Configuración página
	paramConfig = {
	TiempoEspera:10000//tiempo de espera para dar fallo
	};
 // ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
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

		}, ['id_regional','nombre_regional'])
	})

	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'

		}, ['id_programa','nombre_programa'])
	})

	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'

		}, ['id_proyecto','nombre_proyecto'])
	})


	///////para el grupo de activo
	ds_tipo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
		proxy: new Ext.data.HttpProxy({url: '../../../control/tipo_activo/ActionListaTipoActivo.php?origen=filtro'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',	id: 'id_tipo_activo',	totalRecords: 'TotalCount'
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
			record: 'ROWS',id: 'id_activo_fijo',totalRecords: 'TotalCount'
		}, ['id_activo_fijo','codigo','descripcion'])
	})
	
	//Define las columnas a desplegar
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
		save_as:'txt_id_financiador',
		tipo: 'ComboBox'
	}
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
		save_as:'txt_id_regional',
		tipo: 'ComboBox'
	}
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
		save_as:'txt_id_programa',
		tipo: 'ComboBox'
	}
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
		save_as:'txt_id_proyecto',
		tipo: 'ComboBox'
	}
	vectorAtributos[3] = paramId_proyecto;
	
	
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
	vectorAtributos[4] = paramId_tipo_activo;

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
	vectorAtributos[5] = paramId_sub_tipo;
	//////////////////////////////////////
	filterCols_activo_fijo = new Array();
	filterValues_activo_fijo = new Array();
	filterCols_activo_fijo[0] = 'SUB.id_tipo_activo';
	filterValues_activo_fijo[0] = '%';
	filterCols_activo_fijo[1] = 'AF.id_sub_tipo_activo';
	filterValues_activo_fijo[1] = '%';
		
	var paramId_activo_fijo = {
		validacion:{
			fieldLabel: 'Activo Fijo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Activo Fijo...',
			name: 'id_activo_fijo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'descripcion', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_activo_fijo,
			valueField: 'id_activo_fijo',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'AF.codigo',
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
			minChars : 0, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			width: 200
		},
		id_grupo:1,
		save_as:'txt_id_activo_fijo',
		tipo: 'ComboBox'
	}
	vectorAtributos[6] = paramId_activo_fijo;
	////////////////////////////////////
	
	var paramTamano = {
		validacion: {
			name: 'tamano',
			fieldLabel: 'Tamaño',
			emptyText:'Tamaño...',
			typeAhead: true,
			allowBlank: false,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'Valor'],
				data : Ext.CodigoBarrasCombo.tamano // from states.js
			}),
			valueField:'Valor',
			displayField:'ID',
			lazyRender:true,
			forceSelection:true
		},
		id_grupo:1,
		tipo:'ComboBox',
		defecto: 'Mediano',
		save_as:'txt_tamano'
	}
	vectorAtributos[7] = paramTamano;
//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Codigo de Barras de los Activos Fijos"
	};
	Docs.init(config); //s
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;

	ds_regional.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_sub_tipo.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_activo_fijo.addListener('loadexception',  ClaseMadre_conexionFailure); //
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

function iniciarEventosFormularios()
	{	combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');
		combo_tipo_activo = ClaseMadre_getComponente('id_tipo_activo');
		combo_sub_tipo_activo = ClaseMadre_getComponente('id_sub_tipo_activo');
		combo_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
		combo_tamano = ClaseMadre_getComponente('tamano');
		combo_tamano.setValue('Mediano');
		
/////////////////////////////////////////////////////////////////////////////////////////
      	/*var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_regional.setValue('');
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_proyecto.setValue('');
		};
		
				
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue();
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_proyecto.setValue('');
						
		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue();
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_proyecto.setValue('');
			
			
		};
		var onTipoActivoSelect = function(e) {
			var id = combo_tipo_activo.getValue()
			combo_sub_tipo_activo.filterValues[0] =  id;
			combo_sub_tipo_activo.modificado = true;
			combo_sub_tipo_activo.setValue('');
			combo_activo_fijo.filterValues[0] =  id;
			combo_activo_fijo.modificado = true;
			combo_activo_fijo.setValue('');
			
			
		};
		var onSubTipoActivoSelect = function(e) {
			var id = combo_sub_tipo_activo.getValue()
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;
			combo_activo_fijo.setValue('');
		};
*/
		var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			
			
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
			
			
		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
		
			
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
		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			
						
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_proyecto'] = '%';
			params2['nombre_proyecto'] = 'Todos los Proyectos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_proyecto.store.add(aux2)
			combo_proyecto.setValue('%');			
			///////
		};   

		var onTipoActivoSelect = function(e) {
			var id = combo_tipo_activo.getValue()
			combo_sub_tipo_activo.filterValues[0] =  id;
			combo_sub_tipo_activo.modificado = true;
			combo_activo_fijo.filterValues[0] =  id;
			combo_activo_fijo.modificado = true;
		
			
			//Carga el valor por defecto del programa
			var  params1 = new Array();
			params1['id_sub_tipo_activo'] = '%';
			params1['descripcion'] = 'Todos los Sub Tipos';
			var aux1 = new Ext.data.Record(params1,'%');
			combo_sub_tipo_activo.store.add(aux1)
			combo_sub_tipo_activo.setValue('%');
			///////			
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');			
			///////
		};
		var onSubTipoActivoSelect = function(e) {
			var id = combo_sub_tipo_activo.getValue()
			combo_activo_fijo.filterValues[1] =  id;
			combo_activo_fijo.modificado = true;
			
						
			//Carga el valor por defecto del proyecto
			var  params2 = new Array();
			params2['id_activo_fijo'] = '%';
			params2['codigo'] = 'Todos los Activos';
			var aux2 = new Ext.data.Record(params2,'%');
			combo_activo_fijo.store.add(aux2)
			combo_activo_fijo.setValue('%');			
			///////
		};     		
			
		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_tipo_activo.on('select', onTipoActivoSelect);
		combo_tipo_activo.on('change', onTipoActivoSelect);
		combo_sub_tipo_activo.on('select', onSubTipoActivoSelect);
		combo_sub_tipo_activo.on('change', onSubTipoActivoSelect);
	}

	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Codigo Barras ";
		return titulo;
	}
///////////////////////////////////////////////////////////////////////////////////////////////
//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../../control/_reportes/codigo_barras/ActionRptCodigoBarras.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{	tituloGrupo:'Estructura Programatica', columna:0, id_grupo:0 },
			{	tituloGrupo:'Activo Fijo', columna:0, id_grupo:1	}
			
		],
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
{	obj_pagina = new GenerarReporteCodigoBarras(); }
YAHOO.util.Event.on(window, 'load', main); //arranca todo