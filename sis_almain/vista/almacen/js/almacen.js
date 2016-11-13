/**
 * Nombre: pagina_almacen.js Propósito: pagina objeto principal Autor: Ruddy
 * Luján Bravo Fecha creación: 25-07-2013 16:53:59
 */
function PaginaAlmacen(idContenedor, direccion, paramConfig) {
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_almacen;

	// DATA STORE //
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/almacen/ActionListarAlmacen.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_almacen',
			totalRecords : 'TotalCount'
		}, [ 'id_almacen', 'id_lugar', 'id_depto', 'nombre_lugar',
				'nombre_depto', 'codigo', 'nombre', 'direccion', 'estado',
				'tipo_control', 'usuario_reg','demasia', {
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				} ]),
		remoteSort : true
	});
	ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros
			}
		};
	// Carga los datos en el DataStore.
	ds.load({
		params : {
			start : 0,
			limit : paramConfig.TamanoPagina,
			CantFiltros : paramConfig.CantFiltros
		}
	});

	var ds_lugar = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../../sis_seguridad/control/lugar/ActionListarLugar.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_lugar',
					totalRecords : 'TotalCount'
				}, [ 'id_lugar', 'nombre', 'cod_lugar' ])
			});
	// PARÁMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_almacen',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_almacen'
			},
			{
				validacion : {
					name : 'id_lugar',
					fieldLabel : 'Lugar',
					allowBlank : false,
					emptyText : 'Lugar...',
					desc : 'nombre_lugar',
					store : ds_lugar,
					valueField : 'id_lugar',
					displayField : 'nombre',
					queryParam : 'filterValue_0',
					filterCol : 'LUGARR.nombre',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 250,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2, // /caracteres mínimos
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'txt_id_lugar'
			},
			{
				validacion : {
					name : 'id_depto',
					fieldLabel : 'Departamento',
					allowBlank : false,
					emptyText : 'Departamentos...',
					desc : 'nombre_depto',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_parametros/control/depto/ActionListarDepartamento.php?almacenes=si'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_depto',
									totalRecords : 'TotalCount'
								}, [ 'id_depto', 'nombre_depto' ])
							}),
					valueField : 'id_depto',
					displayField : 'nombre_depto',
					queryParam : 'filterValue_0',
					filterCol : 'DEPTO.nombre_depto',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 380,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2, // /caracteres mínimos
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'txt_id_depto'
			},
			{
				validacion : {
					name : 'nombre_lugar',
					fieldLabel : 'Lugar',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'lug.nombre',
				form : false
			},
			{
				validacion : {
					name : 'nombre_depto',
					fieldLabel : 'Departamento',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'depto.nombre_depto',
				form : false
			},
			{
				validacion : {
					name : 'codigo',
					fieldLabel : 'Codigo',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true, // se muestra en el grid
					grid_editable : false,// es editable en el grid
					forceSelection : true,
					width_grid : 60, // ancho de columna en el grid
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo',
				filtro_1 : true,
				form : true,
				save_as : 'txt_codigo'
			},
			{
				validacion : {
					name : 'nombre',
					fieldLabel : 'Nombre',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true, // se muestra en el grid
					grid_editable : false,// es editable en el grid
					forceSelection : true,
					width_grid : 200, // ancho de columna en el grid
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.nombre',
				filtro_1 : true,
				form : true,
				save_as : 'txt_nombre'
			},
			{
				validacion : {
					name : 'direccion',
					fieldLabel : 'Direccion',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true, // se muestra en el grid
					grid_editable : false,// es editable en el grid
					forceSelection : true,
					width_grid : 150, // ancho de columna en el grid
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.direccion',
				filtro_1 : true,
				form : true,
				save_as : 'txt_direccion'
			},
			{//% demasia
				
				validacion : {
					name :'demasia',
					fieldLabel : '% Demasia.',
					allowBlank : true,
					allowNegative: false,
					allowDecimals: true,
					minValue : '0',
					maxValue : '100',
					align : 'center',
					//decimalPrecision : 2,
					//align : 'right',
					grid_visible : true,
					grid_editable : false,
					width_grid : 50,
					width:150
				},
				tipo : 'NumberField',
				filtro_0 : false,
				form : true,
				save_as : 'txt_demasia'
			},
			{
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : true,
					typeAhead : true,
					loadMask : false,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'nombre',
					align : 'center',
					lazyRender : true,
					forceSelection : false,
					grid_visible : true,
					
					grid_editable : false,
					width_grid : 55,
					width : 285,
					renderer : renderEstado
				},
				tipo : 'ComboBox',
				filtro_0 : false,
				filterColValue : 'al.estado',
				form : false,
				save_as : 'txt_estado'
			},
			{
				validacion : {
					name : 'tipo_control',
					fieldLabel : 'Tipo de control',
					emptyText : 'Tipo de control...',
					allowBlank : false,
					typeAhead : true,
					loadMask : false,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'fisico', 'Fisico' ],
								[ 'valorado', 'Valorado' ] ]
					}),
					valueField : 'valor',
					displayField : 'nombre',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 105,
					width : 285,
					renderer : renderTipo_control
				},
				tipo : 'ComboBox',
				filtro_0 : false,
				filterColValue : 'al.tipo_control',
				form : true,
				save_as : 'txt_tipo_control'
			},
			{
				validacion : {
					name : 'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'al.usuario_reg',
				form : false
			},
			{
				validacion : {
					name : 'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'al.fecha_reg',
				dateFormat : 'm-d-Y'
			}];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'almacen',
		grid_maestro : 'grid-'+idContenedor,
		urlHijo:'../../../sis_almain/vista/stock_item/stock_item.php'
			};
	layout_almacen = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_almacen.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_almacen, idContenedor);
	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
	var cm_getSelectionModel = this.getSelectionModel;
	var cm_conexionFailure = this.conexionFailure;
	var cm_eliminarSuccess = this.eliminarSucess;
	var cm_btnNew = this.btnNew;

	this.EnableSelect = function(selEvent, rowIndex, selectedRow) {
		cm_EnableSelect(selEvent, rowIndex, selectedRow);
		_CP.getPagina(layout_almacen.getIdContentHijo()).pagina.reload(selectedRow.data);
		_CP.getPagina(layout_almacen.getIdContentHijo()).pagina.desbloquearMenu();

		var btnActivarInactivarAlmacen = cm_getBoton('activarInactivarAlmacen-'
				+ idContenedor);
		btnActivarInactivarAlmacen.enable();

		if (selectedRow.data.estado == "inactivo") {
			btnActivarInactivarAlmacen.setText("Activar Almacen");
		}

		else if (selectedRow.data.estado == "activo") {
			btnActivarInactivarAlmacen.setText("Inactivar Almacen");
		}
		
		cm_getBoton('fases-'+ idContenedor).enable();;
	}

	function cargar_activar(resp) {
		alert('La activacion del almacen fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_inactivar(resp) {
		alert('La inactivacion de almacen fue exitosa');
		ClaseMadre_btnActualizar();
	}

	this.DeselectRow = function(n, n1) {
		cm_getBoton('activarInactivarAlmacen-' + idContenedor).disable();
		
		cm_getBoton('fases-'+ idContenedor).disable();
		cm_DeselectRow(n, n1);
	};
	
	this.btnNew = function() {
		ds_lugar.baseParams={
				filtro_lugar_almacenes:'si'	
		}
		cm_btnNew();
	}
	
	// ----------- DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu = {
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

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	}
	;
	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'activo') {
			estado = 'Activo';
		} else {
			estado = 'Inactivo';
		}
		return String.format('{0}', estado);
	}
	// funciones render
	function renderTipo_control(component, value, record) {
		var tipo_control;
		if (record.data['tipo_control'] == 'fisico') {
			tipo_control = 'Fisico';
		} else {
			tipo_control = 'Valorado';
		}
		return String.format('{0}', tipo_control);
	}
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/almacen/ActionEliminarAlmacen.php"
		},
		Save : {
			url : direccion
					+ "../../../control/almacen/ActionGuardarAlmacen.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/almacen/ActionGuardarAlmacen.php"
		},
		Formulario : {
			titulo : 'Registro de Almacenes',
			html_apply : "dlgInfo-" + idContenedor,
			width : 450,
			height : 350,
			columnas : [ '95%' ],
			closable : true
		}
	};

	// -------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();

	var cm_getBoton = this.getBoton;
	
	
	
	
	// Botones adicionales en el menu
	this.AdicionarBoton('../../../lib/imagenes/bricks.png','Fases/Subactividad', btnFases, false,'fases', 'Fases');
	
	this.AdicionarBoton('../../../lib/imagenes/user_add.png','Activar/Inactivar', btnActivarInactivarAlmacen, false,'activarInactivarAlmacen', 'Activa o Inactiva un Almacen');
	

	
	cm_getBoton('fases-' + idContenedor).disable();
	cm_getBoton('activarInactivarAlmacen-' + idContenedor).disable();
	

	function btnFases()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect == 1)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "m_id_almacen=" + SelectionsRecord.data.id_almacen;
			data = data+"&m_codigo="+SelectionsRecord.data.codigo;
			data = data+"&m_nombre="+SelectionsRecord.data.nombre;
			
			var ParamVentana={Ventana:{width:'60%',height:'70%'}};
			layout_almacen.loadWindows(direccion+'../../../../sis_almain/vista/fase/fase.php?'+data,'Clasificacion Items',ParamVentana);
		}
		else if(NumSelect > 1)
		{
			Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe tener seleccionado un almacen.'); 
		}
	}
	
	function successActivarInactivarAlmacen() {
		alert('entra al success');
	}

	function btnActivarInactivarAlmacen() {
		var sm = cm_getSelectionModel();

		var data = "id_almacen=" + sm.getSelected().data.id_almacen;
		console.log('data: ', data);
		Ext.Ajax
				.request({
					url : direccion
							+ "../../../control/almacen/ActionActivarInactivarAlmacen.php",
					params : data,
					method : 'POST',
					success : cm_eliminarSuccess,
					failure : cm_conexionFailure,
					timeout : 10000
				});
	}

	layout_almacen.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}