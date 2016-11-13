function pagina_clasificacion_arb(idContenedor, direccion, paramConfig) {
	var DatosNodo = new Array('id', 'id_p', 'tipo');
	var DatosDefecto = {};
	var Dialog;
	var idAlmacen;

	var config = {
		titulo : 'Ubicacion de almacenes',
		area : 'south',
		urlHijo : '../../../sis_almain/vista/item/item.php'
	};
	var Atributos = [ {
		validacion : {
			labelSeparator : '',
			name : 'id_clasificacion',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_clasificacion'
	}, {
		validacion : {
			labelSeparator : '',
			name : 'id_clasificacion_fk',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_clasificacion_fk'
	}, 
	{
		validacion : 
		{
			name :'orden',
			fieldLabel : 'Nro.(despues de)',
			allowBlank : true,
			allowNegative: false,
			allowDecimals: false,
			minValue : '0',
			//decimalPrecision : 2,
			align : 'center',
			grid_visible : true,
			grid_editable : false, 
			width_grid : 120,
			width:100
		},
		tipo : 'NumberField',
		//filtro_0 : true,
		//filterColValue : 'al.peso',
		form : true,
		save_as : 'txt_orden_clas'
	},
	{
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
			name : 'codigo_largo',
			fieldLabel : 'Codigo Largo',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFsocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : false
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
	}, 
	{
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
				fields : [ 'value', 'display' ],
				data : [ [ 'activo', 'Activo' ], [ 'inactivo', 'Inactivo' ] ]
			}),
			valueField : 'value',
			displayField : 'display',
			align : 'left',
			lazyRender : true,
			forceSelection : true,
			width : 250
		},
		form : true,
		tipo : 'ComboBox',
		save_as : 'txt_estado'
	},
	{
		validacion : {
			name : 'chk_demasia',
			fieldLabel : '% Demasia',
			emptyText : 'Estado....',
			allowBlank : true,
			width:20, 
			checked: false
			/*onClick: function(record){							
				if(this.getValue()){				
				}else{
					componentes[34].setValue(false);									
				}   
			}*/
		},
		form : true,
		tipo : 'Checkbox',
		save_as : 'chk_demasia' 
	} 
	];

	var layout_clasificacion_arb = new DocsLayoutArb(idContenedor);
	layout_clasificacion_arb.init(config);
	// Se hereda la clase vista Arbol
	this.pagina = PaginaArb;
	this.pagina(paramConfig, Atributos, layout_clasificacion_arb, idContenedor,
			DatosNodo, DatosDefecto);

	// funciones heredadas
	var cm_getSelectionModel = this.getSm;
	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	var cm_ocultarFormulario = this.ocultarFormulario;
	var cm_btnActualizar = this.btnActualizar;
	var cm_EnableSelect = this.EnableSelect;
	var cm_btnEdit = this.btnEdit;
	var getSelectionModel = this.getSelectionModel;
	
	var cm_mostrarComponente=this.mostrarComponente;
	var cm_ocultarComponente=this.ocultarComponente;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	

	// -------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//

	this.EnableSelect = function(selObject, currentNode, lastNode) {
		cm_EnableSelect(selObject, currentNode, lastNode);
		_CP.getPagina(layout_clasificacion_arb.getIdContentHijo()).pagina
				.reload(currentNode.attributes);
		_CP.getPagina(layout_clasificacion_arb.getIdContentHijo()).pagina
				.desbloquearMenu();
	};
	
	this.btnNew = function() {
		var selectedNode = cm_getSelectionModel().getSelectedNode();
		
		if (selectedNode == null || selectedNode == undefined ) //nodo es raiz
		{
			cm_btnNew();
		} 
		else 
		{
			cm_btnNew();
			cm_getComponente('id_clasificacion_fk').setValue(selectedNode.attributes.id_clasificacion);
		}
		cm_ocultarComponente(cm_getComponente('chk_demasia'));
		cm_mostrarComponente(cm_getComponente('orden'));
	}
	
	this.btnNewRaiz = function()
	{
		btnNewRaiz();
		cm_mostrarComponente(cm_getComponente('chk_demasia'));
		cm_ocultarComponente(cm_getComponente('orden'));
	}
	
	
	this.btnEliminar=function()
	{
		btnEliminar();
		cm_btnActualizar();
	};
	
	this.btnEdit=function()
	{
		
		cm_btnEdit();
		var selectedNode = cm_getSelectionModel().getSelectedNode();
		
		if(selectedNode.attributes.id_clasificacion_fk == null || selectedNode.attributes.id_clasificacion_fk=='' || selectedNode.attributes.id_clasificacion_fk == undefined)
		{
			cm_mostrarComponente(cm_getComponente('chk_demasia'));
			cm_ocultarComponente(cm_getComponente('orden'));
			
			if(selectedNode.attributes.sw_demasia == 'si')
			{
				cm_getComponente('chk_demasia').setValue(true);
			}
			else
			{
				cm_getComponente('chk_demasia').setValue(false);
			}	
		}
		else
		{
			cm_ocultarComponente(cm_getComponente('chk_demasia'));
			cm_mostrarComponente(cm_getComponente('orden'));
		}
	}
	
	
	this.guardarSuccess = function(httpResponse) {
		Ext.MessageBox.hide();
		cm_ocultarFormulario();
		if (httpResponse.argument.nodo == null) {
			cm_btnActualizar();
		} else if (httpResponse.argument.proc == "add") {
			httpResponse.argument.nodo.reload();
		} else if (httpResponse.argument.proc == "upd") {
			httpResponse.argument.nodo.parentNode.reload();
		} else if (httpResponse.argument.proc == "del") {
			httpResponse.argument.nodo.parentNode.reload();
		}
	}

	// //////////////////////////////////
	// DEFINICI�N DE LA BARRA DE MEN� //
	// //////////////////////////////////

	var paramMenu = {
		actualizar : {
			crear : true,
			separador : true
		},
		nuevoRaiz : {
			crear : true,
			separador : false,
			tip : 'Nueva Clasificacion Raiz',
			img : 'org_add.png'
		},
		nuevo : {
			crear : true,
			separador : true,
			tip : 'Nuevo',
			img : 'org_uni_add.png'
		},
		editar : {
			crear : true,
			separador : false,
			tip : 'Editar',
			img : 'org_edit.png'
		},
		eliminar : {
			crear : true,
			separador : false,
			tip : 'Eliminar',
			img : 'org_uni_del.png'
		}
	};

	var paramFunciones = {
		Basicas : {
			url : direccion
					+ '../../../control/clasificacion/ActionGuardarClasificacionArb.php',
			add_success : this.guardarSuccess,
			edit : this.btnEdit,
			esCopia : true
		},
		Formulario : {
			height : 415,
			width : 480,
			minWidth : 150,
			minHeight : 200,
			closable : true,
			titulo : 'Clasificacion'
		},
		Listar : {
			url : direccion
					+ '../../../control/clasificacion/ActionListarClasificacionArb.php',
			baseParams : {},
			clearOnLoad : true,
			enableDD : true
		},
		Eliminar : {
			url : direccion
					+ "../../../control/clasificacion/ActionEliminarClasificacionArb.php"
		}
	};

	// Para manejo de eventos
	function iniciarEventosFormularios() 
	{

	}
	this.getLayout = function() {
		return layout_clasificacion_arb.getLayout()
	};
	// Inicio de los componentes de la vista.
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.Init();
	this.iniciaFormulario();
//	iniciarEventosFormularios();
	
	var treeLoader = this.getLoader();
	treeLoader.on("beforeload", function(treeL, node, a) {
		treeL.baseParams.tipo_nodo = node.attributes.tipo_rama;
		treeL.baseParams.id_nodo = node.attributes.id;
		treeL.baseParams.id_clasificacion = node.attributes.id_clasificacion;
		treeL.baseParams.id_clasificacion_fk = node.attributes.id_clasificacion_fk;
	}, this);
	
	layout_clasificacion_arb.getLayout().addListener('layout',
			this.onResize);// aregla la forma en que se ve el grid dentro del
	
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);

}