function pagina_ubicacion_arb(idContenedor, direccion, paramConfig) {
	var DatosNodo = new Array('id', 'id_p', 'tipo');
	var DatosDefecto = {};
	var Dialog;
	var idAlmacen;

	var config = {
		titulo : 'Ubicacion de almacenes'
	};
	// ---DATA STORE
	var ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/almacen/ActionListarAlmacen.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_almacen',
			totalRecords : 'TotalCount'
		}, [ 'id_cliente', 'nombre', ]),
		remoteSort : true
	});

	var ds_almacen = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/almacen/ActionListarAlmacen.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_almacen',
			totalRecords : 'TotalCount'
		}, [ 'id_almacen', 'codigo', 'nombre' ])
	});

	var TaskLocation = Ext.data.Record.create([ {
		name : "id_almacen"
	}, {
		name : "codigo"
	}, {
		name : "nombre"
	} ]);

	var cbxSisAlma = new Ext.form.ComboBox({
		store : ds_almacen,
		fieldLabel : 'Almacen',
		displayField : 'nombre',
		typeAhead : true,
		loadMask : true,
		mode : 'remote',
		triggerAction : 'all',
		emptyText : 'Almacen...',
		selectOnFocus : true,
		queryParam : 'filterValue_0',
		filterCol : 'al.nombre',
		width : 180,
		valueField : 'id_almacen',
	});

	var Atributos = [ {

		validacion : {
			labelSeparator : '',
			name : 'id_ubicacion',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_ubicacion'
	}, {
		validacion : {
			labelSeparator : '',
			name : 'id_ubicacion_fk',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_ubicacion_fk'
	}, {
		validacion : {
			labelSeparator : '',
			name : 'id_almacen',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_almacen'
	}, {
		validacion : {
			name : 'codigo',
			fieldLabel : 'Codigo',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		save_as : 'txt_codigo'
	}, {
		validacion : {
			name : 'nombre',
			fieldLabel : 'Nombre',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		save_as : 'txt_nombre'
	}, {
		validacion : {
			name : 'estado',
			fieldLabel : 'Estado',
			emptyText : 'Estado....',
			allowBlank : false,
			typeAhead : true,
			loadMask : true,
			triggerAction : 'all',
			mode : "local",
			store : new Ext.data.SimpleStore({
				fields : [ 'valor', 'nombre' ],
				data : [ [ 'activo', 'Activo' ],
						[ 'inactivo', 'Inactivo' ] ]
			}),
			valueField : 'valor',
			displayField : 'nombre',
			align : 'left',
			lazyRender : true,
			forceSelection : true,
			width : 250
		},
		form : true,
		tipo : 'ComboBox',
		save_as : 'txt_estado'
	} ];

	function formatDate(value) {return value ? value.dateFormat('d/m/Y') : '';};
	
	var layout_ubicacion_arb = new DocsLayoutArb(idContenedor);
	layout_ubicacion_arb.init(config);
	// Se hereda la clase vista Arbol
	this.pagina = PaginaArb;
	this.pagina(paramConfig, Atributos, layout_ubicacion_arb,idContenedor, DatosNodo, DatosDefecto);

	// funciones heredadas
	var getSm = this.getSm;
	var cm_btnEdit = this.btnEdit;
	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	var cm_ocultarFormulario = this.ocultarFormulario;
	var cm_getDialog = this.getDialog;
	var cm_btnEliminar = this.btnEliminar;
	var scope = this;

	var ClaseMadre_getComponente = this.getComponente;
	var getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel;

	var ClaseMadre_btnNew = this.btnNew;
	var ClaseMadre_btnEdit = this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var btnNewRaiz=this.btnNewRaiz;
	// --*--
	var ClaseMadre_getDialog = this.getDialog;
	var ClaseMadre_save = this.Save;
	var ClaseMadre_getGrid = this.getGrid;
	var ClaseMadre_getFormulario = this.getFormulario;

	var ClaseMadre_getGrid = this.getGrid;
	var CM_ocultarGrupo = this.ocultarGrupo;
	var CM_mostrarGrupo = this.mostrarGrupo;
	var cm_EnableSelect = this.EnableSelect;
	// //////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ //
	// //////////////////////////////////
	var paramMenu = {
		actualizar : {
			crear : true,
			separador : false
		}
	};
	// datos necesarios para el filtro
	var paramFunciones = {
		Formulario : {
			html_apply : 'dlgInfo-' + idContenedor,
			columnas : [ '47%', '47%' ],
			grupos : [ {
				tituloGrupo : 'Oculto',
				columna : 0,
				id_grupo : 0
			}, {
				tituloGrupo : 'Almacen',
				columna : 0,
				id_grupo : 1
			} ],
			height : 500, // alto
			width : 950, // ancho
			closable : true,
			titulo : 'Insertar Almacen'
		}
	};
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	// Para manejo de eventos
	function iniciarEventosFormularios() 
	{
		
		CM_ocultarGrupo('Oculto');

		grid = ClaseMadre_getGrid();
		dialog = ClaseMadre_getDialog();
		sm = getSelectionModel();
		formulario = ClaseMadre_getFormulario();

		for ( var i = 0; i < Atributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		getSelectionModel().on('rowdeselect',
				function() {
					if (_CP.getPagina(layout_ubicacion_arb.getIdContentHijo()).pagina.limpiarStore())
					{
						_CP.getPagina(layout_ubicacion_arb.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
	}

	cbxSisAlma.on('select', function(combo, record, index) 
							{
									cm_DesbloquearMenu();
									idAlmacen = cbxSisAlma.getValue();
									treeLoader.baseParams.id_almacen = idAlmacen;
									ClaseMadre_btnActualizar();
									combo.modificado = true;
							}
	);

	ds_almacen.on('load', function(store, records, options) {
		ds_almacen.commitChanges();
	}, this);

	g_tipo = cbxSisAlma.getValue();
	ds.baseParams.id_almacen = idAlmacen;
	this.btnNew = function()
	{
		var selectedNode = getSm().getSelectedNode();
		if (selectedNode == null || selectedNode == undefined)
		{
			cm_btnNew();
			cm_getComponente('id_almacen').setValue(idAlmacen);
		} 
		else 
		{
			cm_btnNew();
			cm_getComponente('id_ubicacion_fk').setValue(selectedNode.attributes.id_ubicacion);
			cm_getComponente('id_almacen').setValue(idAlmacen);
		}
	}
	this.btnNewRaiz = function()
	{
		btnNewRaiz();
		cm_getComponente('id_almacen').setValue(idAlmacen);
	}
	
	this.guardarSuccess = function(httpResponse)
	{
		Ext.MessageBox.hide();
		cm_ocultarFormulario();
		if (httpResponse.argument.nodo == null) {
			ClaseMadre_btnActualizar();
		}	
		else if (httpResponse.argument.proc == "add") {
			httpResponse.argument.nodo.reload();
		} else if (httpResponse.argument.proc == "upd") {
			httpResponse.argument.nodo.parentNode.reload();
		} else if (httpResponse.argument.proc == "del") {
			httpResponse.argument.nodo.parentNode.reload();
		}
	}

	var paramMenu = {
		actualizar : {
			crear : true
		},
		nuevoRaiz : {
			crear : true,
			separador : false,
			tip : 'Nueva Ubicacion Raiz',
			img : 'tuc+.png'
		},
		nuevo : {
			crear : true,
			separador : false,
			tip : 'Nuevo',
			img : 'raiz+.png'
		},
		editar : {
			crear : true,
			separador : false,
			tip : 'Editar',
			img : 'etucr.png'
		},
		eliminar : {
			crear : true,
			separador : false,
			tip : 'Eliminar',
			img : 'tucr-.png'
		}
	};
	var paramFunciones = {
		Basicas : {
			url : direccion
					+ '../../../control/ubicacion/ActionGuardarUbicacionArb.php',
			add_success : this.guardarSuccess,
			edit : this.btnEdit,
			esCopia : true
		},
		Formulario : {
			height : 415,
			width : 480,
			minWidth : 150,
			minHeight : 200,
			closable : true
		},
		Listar : {
			url : direccion
					+ '../../../control/ubicacion/ActionListarUbicacionArb.php',
			baseParams : {},
			clearOnLoad : true,
			enableDD : true
		},
		Eliminar : {
			url : direccion
					+ "../../../control/ubicacion/ActionEliminarUbicacionArb.php"
		}
	};
		
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.Init();
	this.iniciaFormulario();
	
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	
	cm_BloquearMenu();
	
	
	this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');
	

	var treeLoader = this.getLoader();
	treeLoader
			.on(
					"beforeload",
					function(treeL, node, a) {
						treeL.baseParams.tipo_nodo = node.attributes.tipo_nodo;
						treeL.baseParams.id_nodo = node.attributes.id;
						treeL.baseParams.id_ubicacion = node.attributes.id_ubicacion;
					}, this);

	var cmGetBoton = this.getBoton;
	
	layout_ubicacion_arb.getLayout().addListener('layout',
			this.onResize);// aregla la forma en que se ve el grid dentro del
	// layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}