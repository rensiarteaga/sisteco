
//<script>
function PaginaActivoFijo()
{
	var vectorAtributos = new Array;
	var ds;

	//Configuración página
	paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:0,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		FormularioEstructura:false,//indica si se tiene el los 5 combos de la estructura programatica en los formulario para que sean incluidos en las modificaciiones e iliminaciones
		FiltroAvanzado:false
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/activo_fijo/ActionListaActivoFijo.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_activo_fijo',
		'codigo',
		'descripcion',
		'descripcion_larga',


		'id_financiador',
		'nombre_financiador',
		'id_regional',
		'nombre_regional',
		'id_programa',
		'nombre_programa',
		'id_proyecto',
		'nombre_proyecto',
		'id_actividad',
		'nombre_actividad'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria



	/////DATA STORE////////////
	ds_financiador = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'

		}, ['id_financiador','nombre_financiador','codigo_financiador'])

	})


	ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	})

	ds_programa = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'

		}, ['id_programa','nombre_programa'])//,
	})

	ds_proyecto = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'

		}, ['id_proyecto','nombre_proyecto'])//,
	})


	ds_actividad = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'

		}, ['id_actividad','nombre_actividad'])//,
	})




	////////////////FUNCIONES RENDER ////////////
	function renderFinanciador(value, p, record){return String.format('{0}', record.data['nombre_financiador']);}
	function renderRegional(value, p, record){return String.format('{0}', record.data['nombre_regional']);}
	function renderPrograma(value, p, record){return String.format('{0}', record.data['nombre_programa']);}
	function renderProyecto(value, p, record){return String.format('{0}', record.data['nombre_proyecto']);}
	function renderActividad(value, p, record){return String.format('{0}', record.data['nombre_actividad']);}


	var paramId_activo_fijo = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_activo_fijo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:true,
		save_as:'hidden_id_activo_fijo'
	}
	vectorAtributos[0] = paramId_activo_fijo;

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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderFinanciador,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_financiador'
	}
	vectorAtributos[1] = paramId_financiador;


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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderRegional,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_regional'
	}
	vectorAtributos[2] = paramId_regional;


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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderPrograma,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_programa'
	}
	vectorAtributos[3] = paramId_programa;

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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderProyecto,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_proyecto'
	}
	vectorAtributos[4] = paramId_proyecto;

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
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderActividad,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_actividad'
	}
	vectorAtributos[5] = paramId_actividad;



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
		titulo_maestro:"Estructura Programatica",
		grid_maestro:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	var ClaseMadre_mostrarFormulario= this.mostrarFormulario; //
	var ClaseMadre_ocultarFormulario = this.ocultarFormulario ; //
	var ClaseMadre_iniciaFormulario= this.iniciaFormulario; //
	var ClaseMadre_btnActualizar = this.btnActualizar; // para heredar de la clase madre la funcion btnEdit de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnEdit = this.btnEdit; // para heredar de la clase madre la funcion btnEdit de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnEliminar = this.btnEliminar; // para heredar de la clase madre la funcion btnEliminar de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_eliminarSucces = this.eliminarSucess; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_Save = this.Save; //
	var ClaseMadre_SaveAndOther = this.SaveAndOther; //
	var ClaseMadre_saveSuccess = this.SaveSuccess; // para heredar de la clase madre la funcion ConfirmSave de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_ConfirmSave = this.ConfirmSave; // para heredar de la clase madre la funcion ConfirmSave de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_ValidarCampos = this.ValidarCampos; // para heredar de la clase madre la funcion btnEdit de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_limpiarInvalidos = this.limpiarInvalidos; // para heredar de la clase madre la funcion btnEdit de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor

	var  ClaseMadre_getComponente = this.getComponente;



	var getSelectionModel = this.getSelectionModel;

	ds_financiador.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_regional.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_programa.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_proyecto.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	ds_actividad.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error


	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		//		guardar:{
		//			crear : false, //para ver si se creara el boton
		//			separador:false
		//		},
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


	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:"../../control/tipo_activo/ActionEliminaActivoFijo.php"
		},
		Save:{
			url:"../../control/tipo_activo/ActionSaveActivoFijo.php"
		},
		ConfirmSave:{
			url:"../../control/tipo_activo/ActionSaveActivoFijo.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:330,
			height:300,
			minWidth:150,
			minHeight:200,
			labelWidth: 75, //ancho del label
			closable:true,
			columnas:[280],
			grupos:[
			{
				tituloGrupo:'Estructura Programatica',
				columna:0,
				id_grupo:0
			}]
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');


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
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_actividad.setValue('');

		};




		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);



	}

	///////////////////////////////////////////////////////////////-////////////
	//----------------      FUNCION ENABLE SELECT       ----------------------//
	//Funcion que se llama al seleccionar una fila (para eliminar por ejemplo)//
	////////////////////////////////////////////////////////////////////////////
	///-- sobre cargo la funcion madre  enable select ////
	this.EnableSelect = function(selModel, row, selected)
	{
		var SelectionsRecord  = selModel.getSelected(); //es el primer registro selecionado
		if(selected && SelectionsRecord != -1)
		{
			hidden_id_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
			combo_financiador = ClaseMadre_getComponente('id_financiador');
			combo_regional = ClaseMadre_getComponente('id_regional');
			combo_programa = ClaseMadre_getComponente('id_programa');
			combo_proyecto = ClaseMadre_getComponente('id_proyecto');
			combo_actividad = ClaseMadre_getComponente('id_actividad');

			hidden_id_activo_fijo.setValue(SelectionsRecord.data['id_activo_fijo']);

			if(combo_financiador.store.getById(SelectionsRecord.data['id_financiador']) === undefined)
			{
				var  params = new Array();
				params[combo_financiador.valueField] = SelectionsRecord.data['id_financiador'];
				params[combo_financiador.displayField] = SelectionsRecord.data['nombre_financiador'];
				var aux = new Ext.data.Record(params,SelectionsRecord.data['id_financiador']);
				combo_financiador.store.add(aux)
			}

			combo_financiador.setValue(SelectionsRecord.data['id_financiador']);

			if(combo_regional.store.getById(SelectionsRecord.data['id_regional']) === undefined)
			{

				var  params = new Array();
				params[combo_regional.valueField] = SelectionsRecord.data['id_regional'];
				params[combo_regional.displayField] = SelectionsRecord.data['nombre_regional'];
				var aux = new Ext.data.Record(params,SelectionsRecord.data['id_regional']);
				combo_regional.store.add(aux)
			}
			combo_regional.setValue(SelectionsRecord.data['id_regional']);

			if(combo_programa.store.getById(SelectionsRecord.data['id_programa']) === undefined)
			{


				var  params = new Array();
				params[combo_programa.valueField] = SelectionsRecord.data['id_programa'];
				params[combo_programa.displayField] = SelectionsRecord.data['nombre_programa'];
				var aux = new Ext.data.Record(params,SelectionsRecord.data['id_programa']);
				combo_programa.store.add(aux)
			}
			combo_programa.setValue(SelectionsRecord.data['id_programa']);

			if(combo_proyecto.store.getById(SelectionsRecord.data['id_proyecto']) === undefined)
			{
				var  params = new Array();
				params[combo_proyecto.valueField] = SelectionsRecord.data['id_proyecto'];
				params[combo_proyecto.displayField] = SelectionsRecord.data['nombre_proyecto'];
				var aux = new Ext.data.Record(params,SelectionsRecord.data['id_proyecto']);
				combo_proyecto.store.add(aux)
			}
			combo_proyecto.setValue(SelectionsRecord.data['id_proyecto']);

			if(combo_actividad.store.getById(SelectionsRecord.data['id_actividad']) === undefined)
			{

				var  params = new Array();
				params[combo_actividad.valueField] = SelectionsRecord.data['id_actividad'];
				params[combo_actividad.displayField] = SelectionsRecord.data['nombre_actividad'];
				var aux = new Ext.data.Record(params,SelectionsRecord.data['id_actividad']);
				combo_actividad.store.add(aux)
			}
			combo_actividad.setValue(SelectionsRecord.data['id_actividad']);



			//------------ parametriza los valores iniciales para la estructura programatica ------------//

			//--actualiza el id de financiador --/
			combo_regional.filterValues[0] =  SelectionsRecord.data['id_financiador'];
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  SelectionsRecord.data['id_financiador'];
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  SelectionsRecord.data['id_financiador'];
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  SelectionsRecord.data['id_financiador'];
			combo_actividad.modificado = true;

			//--actualiza el id de regional--/
			combo_programa.filterValues[1] =  SelectionsRecord.data['id_regional'];
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  SelectionsRecord.data['id_regional'];
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  SelectionsRecord.data['id_regional'];
			combo_actividad.modificado = true;


			//--actualiza el id de programa--/
			combo_proyecto.filterValues[2] =  SelectionsRecord.data['id_programa'];
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  SelectionsRecord.data['id_programa'];
			combo_actividad.modificado = true;

			//--actualiza el id de proyecto--/
			combo_actividad.filterValues[3] =  SelectionsRecord.data['id_proyecto'];
			combo_actividad.modificado = true;



		}
	}
	
	this.Bloquear = function()
	{
					Ext.Msg.show({
					title: 'Estructura Programatica',
					msg: '<b>Seleccione un Activo<b>',
					minWidth:300,
					maxWidth :800,
					closable:false
					//buttons: Ext.Msg.OK
					//width: 300,
				});
	}


	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//


	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)

	this.iniciaFormulario();

	iniciarEventosFormularios()



}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaActivoFijo();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo