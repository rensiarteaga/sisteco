/**
 * Nombre: pagina_proyecto.js Propósito: pagina objeto principal Autor: Grover
 * Velasquez Colque Fecha creación: 2008-07-15 10:55:06
 */
function pagina_proyecto(idContenedor, direccion, paramConfig) {
	var Atributos = new Array, sw = 0;

	// ---DATA STORE
	var ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/proyecto/ActionListarProyecto.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_proyecto',
			totalRecords : 'TotalCount'
		}, [ 'id_proyecto', 'codigo', 'descripcion', 'sigla', 'usuario_reg',
				'fecha_reg', 'codigo_sisin', 'cant_proyectos',
				'sector_economico', 'subsector_economico', 'activ_eco',
				'departamento', 'provincia', 'seccion_mun', 'sisin', 'pnd'

		]),
		remoteSort : true
	});

	// carga datos XML
	ds.load({
		params : {
			start : 0,
			limit : paramConfig.TamanoPagina,
			CantFiltros : paramConfig.CantFiltros
		}
	});
	// DATA STORE COMBOS

	// FUNCIONES RENDER

	// ///////////////////////
	// Definición de datos //
	// ///////////////////////
	Atributos = [ {
		validacion : {
			labelSeparator : '',
			name : 'id_proyecto',
			inputType : 'hidden',
			grid_visible : false,
			grid_editable : false
		},
		tipo : 'Field',
		filtro_0 : false,
		save_as : 'id_proyecto'
	}, {
		validacion : {
			name : 'codigo',
			fieldLabel : 'Código',
			allowBlank : false,
			maxLength : 4,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '50%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.codigo',
		save_as : 'codigo'
	}, {
		validacion : {
			name : 'sigla',
			fieldLabel : 'Sigla',
			allowBlank : true,
			maxLength : 50,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : true,
			width_grid : 150,
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.sigla',
		save_as : 'sigla'
	}, {
		validacion : {
			name : 'descripcion',
			fieldLabel : 'Descripción',
			allowBlank : true,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : true,
			width_grid : 400,
			width : '100%',
			disabled : false
		},
		tipo : 'TextArea',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.descripcion',
		save_as : 'descripcion'
	}, {
		validacion : {
			name : 'codigo_sisin',
			fieldLabel : 'Código SISIN',
			allowBlank : true,
			maxLength : 20,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.codigo_sisin',
		save_as : 'codigo_sisin'
	}, {
		validacion : {
			name : 'sector_economico',
			fieldLabel : 'Sector Económico',
			allowBlank : true,
			maxLength : 2,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.sector_economico',
		save_as : 'sector_economico'
	}, {
		validacion : {
			name : 'subsector_economico',
			fieldLabel : 'Subsector Económico',
			allowBlank : true,
			maxLength : 1,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.subsector_economico',
		save_as : 'subsector_economico'
	}, {
		validacion : {
			name : 'activ_eco',
			fieldLabel : 'Activ. Eco',
			allowBlank : true,
			maxLength : 2,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.activ_eco',
		save_as : 'activ_eco'
	}, {
		validacion : {
			name : 'departamento',
			fieldLabel : 'Departamento',
			allowBlank : true,
			maxLength : 2,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.departamento',
		save_as : 'departamento'
	}, {
		validacion : {
			name : 'provincia',
			fieldLabel : 'Provincia',
			allowBlank : true,
			maxLength : 2,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.provincia',
		save_as : 'provincia'
	}, {
		validacion : {
			name : 'seccion_mun',
			fieldLabel : 'Sección Municipal',
			allowBlank : true,
			maxLength : 2,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.seccion_mun',
		save_as : 'seccion_mun'
	}, {
		validacion : {
			name : 'sisin',
			fieldLabel : 'SISIN',
			allowBlank : true,
			maxLength : 20,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : false,
			grid_editable : false,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.sisin',
		save_as : 'sisin'
	}, {
		validacion : {
			name : 'pnd',
			fieldLabel : 'PND',
			allowBlank : true,
			maxLength : 20,
			minLength : 0,
			selectOnFocus : true,
			grid_visible : true,
			grid_editable : true,
			width_grid : 100,
			width : '100%'
		},
		tipo : 'TextField',
		form : true,
		filtro_0 : true,
		filterColValue : 'PROYEC.pnd',
		save_as : 'pnd'
	}, {
		validacion : {
			labelSeparator : '',
			name : 'cant_proyectos',
			fieldLabel : 'Cant. Proyectos',
			inputType : 'hidden',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100
		},
		tipo : 'Field',
		form : false,
		filtro_0 : false,
		id_grupo : 0
	}, {
		validacion : {
			name : 'usuario_reg',
			fieldLabel : 'Usuario Registro',
			allowBlank : false,
			maxLength : 3,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : false,
			width_grid : 150,
			width : '50%',
			disabled : false
		},
		tipo : 'TextField',
		form : false,
		filtro_0 : true,
		filterColValue : 'USUARI.login',
		save_as : 'usuario_reg'
	}, {
		validacion : {
			name : 'fecha_reg',
			fieldLabel : 'Fecha Registro',
			allowBlank : false,
			maxLength : 3,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			grid_visible : true,
			grid_editable : false,
			width_grid : 150,
			width : '50%',
			disabled : false
		},
		tipo : 'TextField',
		form : false,
		filtro_0 : true,
		filterColValue : 'PROYEC.fecha_reg',
		save_as : 'fecha_reg'
	},  ];

	// ////////////////////////////////////////////////////////////
	// ---------- FUNCIONES RENDER ---------------//
	// ////////////////////////////////////////////////////////////
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	;

	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'Proyecto',
		grid_maestro : 'grid-' + idContenedor
	};
	var layout_proyecto = new DocsLayoutMaestro(idContenedor);
	layout_proyecto.init(config);

	// //////////////////////
	// INICIAMOS HERENCIA //
	// //////////////////////

	this.pagina = Pagina;
	// -- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE
	// ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig, Atributos, ds, layout_proyecto, idContenedor);
	var getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel;

	// /////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	// /////////////////////////////////

	var paramMenu = {
		guardar : {
			crear : true,
			separador : false
		},
		nuevo : {
			crear : true,
			separador : true
		},
		editar : {
			crear : true,
			separador : false
		},
		eliminar : {
			crear : true,
			separador : false
		},
		actualizar : {
			crear : true,
			separador : false
		}
	};

	// ////////////////////////////////////////////////////////////////////////////
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	// //
	// aquí se parametrizan las funciones que se ejecutan en la clase madre //
	// ////////////////////////////////////////////////////////////////////////////

	// datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ '../../../control/proyecto/ActionEliminarProyecto.php'
		},
		Save : {
			url : direccion
					+ '../../../control/proyecto/ActionGuardarProyecto.php'
		},
		ConfirmSave : {
			url : direccion
					+ '../../../control/proyecto/ActionGuardarProyecto.php'
		},
		Formulario : {
			html_apply : 'dlgInfo-' + idContenedor,
			height : 400,
			width : 480,
			minWidth : 150,
			minHeight : 200,
			closable : true,
			titulo : 'Proyecto'
		}
	};
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	// Para manejo de eventos
	function iniciarEventosFormularios() {
		// para iniciar eventos en el formulario
	}

	// para que los hijos puedan ajustarse al tamaño
	this.getLayout = function() {
		return layout_proyecto.getLayout()
	};
	this.Init(); // iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	// InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	// para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_proyecto.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}