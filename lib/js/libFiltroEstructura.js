//////////////////////////////////////////////////////////////////////////
//------------- FUNCION INIT FILTRO ESTRUCURA PROGRAMATICA -------------//
//				         inicia la estructura programtica			    //
//////////////////////////////////////////////////////////////////////////


function FiltroEstructuraProgramatica(contenedor_filtro){
	this.Init_FiltroEstructura=function(dataStore,conexionFailure,btnActualizar){
	var tb = new Ext.Toolbar(contenedor_filtro); //tag html html donde se colocara el filtro
	// add a combobox to the toolbar
	var ds_financiador = new Ext.data.Store({
	// asigna url de donde se cargaran los datos
	proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
	record: 'ROWS',
	id: 'id_financiador',
	totalRecords: 'TotalCount'
	}, ['id_financiador','nombre_financiador','codigo_financiador'])//,
	})
	ds_financiador.addListener('loadexception', conexionFailure); //se recibe un error
	var ds_regional = new Ext.data.Store({
	proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/regional/ActionListaRegionalEP.php?origen=filtro'}),
	reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_regional',
				totalRecords: 'TotalCount'
			}, ['id_regional','nombre_regional'])//,
		})
		ds_regional.addListener('loadexception', conexionFailure); //se recibe un error
		var ds_programa = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/programa/ActionListaProgramaEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_programa',
				totalRecords: 'TotalCount'
			}, ['id_programa','nombre_programa'])//,
		})
		ds_programa.addListener('loadexception', conexionFailure); //se recibe un error
		var ds_proyecto = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_proyecto',
				totalRecords: 'TotalCount'
			}, ['id_proyecto','nombre_proyecto'])//,
		})
		ds_proyecto.addListener('loadexception', conexionFailure); //se recibe un error
		var ds_actividad = new Ext.data.Store({
			proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/actividad/ActionListaActividadEP.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_actividad',
				totalRecords: 'TotalCount'

			}, ['id_actividad','nombre_actividad'])//,
		})
		ds_actividad.addListener('loadexception', conexionFailure); //se recibe un error
		var combo_financiador = new Ext.form.ComboBox({
			emptyText:'Financiador...',
			name: 'filtro_id_history',
			store:ds_financiador,
			valueField: 'id_financiador',
			displayField: 'nombre_financiador',
			queryParam: 'filterValue_0',
			filterCol:'nombre_financiador',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true
		});

		filterCols_regional = new Array();
		filterValues_regional = new Array();
		filterCols_regional[0] = 'frppa.id_financiador';
		filterValues_regional[0] = '%';

		var combo_regional= new Ext.form.ComboBox({
			emptyText:'Regional...',
			name: 'filtro_id_regional',
			store: ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'nombre_regional',
			filterCols:filterCols_regional,
			filterValues:filterValues_regional,
			typeAhead: false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			forceSelection : true,
			editable : true
		});

		filterCols_programa= new Array();
		filterValues_programa= new Array();
		filterCols_programa[0] = 'frppa.id_financiador';
		filterValues_programa[0] = '%';
		filterCols_programa[1] = 'frppa.id_regional';
		filterValues_programa[1] = '%';

		var combo_programa= new Ext.form.ComboBox({
			emptyText:'Programa...',
			name: 'filtro_id_programa',
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'nombre_programa',
			filterCols:filterCols_programa,
			filterValues:filterValues_programa,
			typeAhead: false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			forceSelection : true,
			editable : true
		});

		filterCols_proyecto= new Array();
		filterValues_proyecto= new Array();
		filterCols_proyecto[0] = 'frppa.id_financiador';
		filterValues_proyecto[0] = '%';
		filterCols_proyecto[1] = 'frppa.id_regional';
		filterValues_proyecto[1] = '%';
		filterCols_proyecto[2] = 'PGPYAC.id_programa';
		filterValues_proyecto[2] = '%';


		var combo_proyecto= new Ext.form.ComboBox({
			emptyText:'Proyecto...',
			name: 'filtro_id_proyecto',
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'nombre_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'nombre_proyecto',
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto,
			typeAhead: false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			forceSelection : true,
			editable : true
		});


		filterCols_actividad= new Array();
		filterValues_actividad= new Array();
		filterCols_actividad[0] = 'frppa.id_financiador';
		filterValues_actividad[0] = '%';
		filterCols_actividad[1] = 'frppa.id_regional';
		filterValues_actividad[1] = '%';
		filterCols_actividad[2] = 'PGPYAC.id_programa';
		filterValues_actividad[2] = '%';
		filterCols_actividad[3] = 'PGPYAC.id_proyecto';
		filterValues_actividad[3] = '%';



		var combo_actividad = new Ext.form.ComboBox({
			emptyText:'Actividad...',
			name: 'filtro_id_actividad',
			store:ds_actividad,
			valueField: 'id_actividad',
			displayField: 'nombre_actividad',
			queryParam: 'filterValue_0',
			filterCol:'nombre_actividad',
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad,
			typeAhead: false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			forceSelection : true,
			editable : true
		});

		tb.addField(combo_financiador);
		tb.addField(combo_regional);
		tb.addField(combo_programa);
		tb.addField(combo_proyecto);
		tb.addField(combo_actividad);


		//para los eventos eventos
		function ActualizarEP()
		{

			hidden_ep_id_financiador=combo_financiador.getValue();
			hidden_ep_id_regional=combo_regional.getValue();
			hidden_ep_id_programa=combo_programa.getValue();
			hidden_ep_id_proyecto=combo_proyecto.getValue();
			hidden_ep_id_actividad=combo_actividad.getValue();
			if(hidden_ep_id_financiador=='')
			hidden_ep_id_financiador='%';
			if(hidden_ep_id_regional=='')
			hidden_ep_id_regional='%';
			if(hidden_ep_id_programa=='')
			hidden_ep_id_programa='%';
			if(hidden_ep_id_proyecto=='')
			hidden_ep_id_proyecto='%';
			if(hidden_ep_id_actividad=='')
			hidden_ep_id_actividad='%';
			dataStore.lastOptions.params.hidden_ep_id_financiador = hidden_ep_id_financiador;
			dataStore.lastOptions.params.hidden_ep_id_regional= hidden_ep_id_regional;
			dataStore.lastOptions.params.hidden_ep_id_programa= hidden_ep_id_programa;
			dataStore.lastOptions.params.hidden_ep_id_proyecto= hidden_ep_id_proyecto;
			dataStore.lastOptions.params.hidden_ep_id_actividad= hidden_ep_id_actividad;
			dataStore.lastOptions.params.start=0;
			btnActualizar();

		}

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
			if(combo_regional.getValue()!=''){combo_regional.setValue('%')};
			if(combo_programa.getValue()!=''){combo_programa.setValue('%')};
			if(combo_proyecto.getValue()!=''){combo_proyecto.setValue('%')};
			if(combo_actividad.getValue()!=''){combo_actividad.setValue('%')};
			ActualizarEP()

		};

		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			if(combo_programa.getValue()!=''){combo_programa.setValue('%')};
			if(combo_proyecto.getValue()!=''){combo_proyecto.setValue('%')};
			if(combo_actividad.getValue()!=''){combo_actividad.setValue('%')};
			ActualizarEP()
		};

		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			if(combo_proyecto.getValue()!=''){combo_proyecto.setValue('%')};
			if(combo_actividad.getValue()!=''){combo_actividad.setValue('%')};
			ActualizarEP()

		};
		var onProyectoSelect = function(e) {

			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			if(combo_actividad.getValue()!=''){combo_actividad.setValue('%')};
			ActualizarEP()

		};
		var onActividadSelect = function(e) {
			ActualizarEP();
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
	}
}
