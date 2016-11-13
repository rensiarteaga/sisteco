/**
 * Nombre: detalle_solicitud.js Autor: Ruddy Limbert Lujan Bravo Fecha creación:
 * 18-09-2013
 */

function PaginaDetalleSolicitud(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array();
	var ds;
	var layout_detalle_solicitud;

	// DATA STORE //
	ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/detalle_solicitud/ActionListarDetalleSolicitud.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_detalle_solicitud',
					totalRecords : 'TotalCount'
				}, [ 'id_detalle_solicitud', 'id_solicitud_salida', 'id_item',
						'nombre_item', 'cantidad', 'usuario_reg',
						, {
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						},'id_unidad_medida_base','nombre_medida' ]),
				remoteSort : true
			});

	// PARÁMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_detalle_solicitud',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_detalle_solicitud'
			},
			{
				validacion : {
					labelSeparator : '',
					name : 'id_solicitud_salida',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_solicitud_salida'
			},
			{
				validacion : {
					name : 'id_item',
					fieldLabel : 'Item',
					allowBlank : false,
					emptyText : 'Item...',
					desc : 'nombre_item',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_almain/control/item/ActionListarItem.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_item',
									totalRecords : 'TotalCount'
								}, [ 'id_item', 'nombre' ])
							}),
					valueField : 'id_item',
					displayField : 'nombre',
					queryParam : 'filterValue_0',
					filterCol : 'al.nombre',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 450,
					width : 285,
					resizable : false,
					minChars : 2,
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'txt_id_item'
			},
			{
				validacion : {
					name : 'cantidad',
					fieldLabel : 'Cantidad',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 225
				},
				tipo : 'NumberField',
				filtro_0 : true,
				filterColValue : 'des.cantidad',
				form : true,
				save_as : 'txt_cantidad'
			},
			{
				validacion : {
					name : 'nombre_item',
					fieldLabel : 'Nombre del Item',
					grid_visible : true,
					grid_editable : false,
					width_grid : 350
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'itm.nombre',
				form : false
			},
			{
				validacion : {
					name : 'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'des.usuario_reg',
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
					width_grid : 135
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : true,
				filterColValue : 'des.fecha_reg',
				dateFormat : 'm-d-Y'
			},];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'detalle solicitud',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_detalle_solicitud = new DocsLayoutMaestro(idContenedor);
	layout_detalle_solicitud.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_detalle_solicitud,
			idContenedor);

	// herencia de metodos
	var CM_getComponente = this.getComponente;

	this.reload = function(m) {
		maestro = m;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_solicitud_salida : maestro.id_solicitud_salida
			}
		};
		vectorAtributos[1].defecto = maestro.id_solicitud_salida;

		if (maestro.estado == "borrador") {
			cm_getBoton("nuevo-" + idContenedor).show();
			cm_getBoton("editar-" + idContenedor).show();
			cm_getBoton("eliminar-" + idContenedor).show();
		} else if (maestro.estado == "pendiente_entrega") {
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		} else if (maestro.estado == "pendiente_aprobacion") {
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		} else if (maestro.estado == "proceso_entrega") {
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		}
		this.btnActualizar();
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
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	}
	;
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionEliminarDetalleSolicitud.php"
		},
		Save : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionGuardarDetalleSolicitud.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionGuardarDetalleSolicitud.php"
		},
		Formulario : {
			titulo : 'Registro de Detalle Solicitud',
			html_apply : "dlgInfo-" + idContenedor,
			width : 440,
			height : 225,
			columnas : [ '95%' ],
			closable : true
		}
	};
	// -------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();

	layout_detalle_solicitud.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}