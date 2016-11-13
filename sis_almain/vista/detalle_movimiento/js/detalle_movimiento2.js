/**
 * Nombre:		 	stock_item.js  	  
 * Proposito: 		vista tal_stock_item		
 * Autor:			UNKNOW			
 * Fecha creacion:	30-05-2014
 */
 
function PaginaDetalleMovimiento(idContenedor,direccion,paramConfig)
{	 
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_detalle_movimiento;
	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/detalle_movimiento/ActionListarDetalleMovimiento.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_detalle_movimiento',
					totalRecords : 'TotalCount'
				}, [ 'id_detalle_movimiento', 'id_movimiento', 'id_item',
						'codigo_movimiento', 'nombre_item', 'cantidad',
						'cantidad_solicitada', 'tipo_saldo', 'usuario_reg','desc_item',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						} ]),
				remoteSort : true
			});
	//DATA STORE COMBOS
	
	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion'])
	});
	function render_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_item=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	
	var ds_almacen= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/almacen/ActionListarAlmacen.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_almacen','nombre','codigo','direccion'])
	});
	function render_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	var tpl_almacen=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{direccion}</FONT>','</div>');
	
	
	///////////////////////// 
	// Definicion de datos //
	/////////////////////////
	//en la posici�n 0 siempre esta la llave primaria

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_detalle_movimiento',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_detalle_movimiento'
	};
	vectorAtributos[1]={
			validacion : {
				labelSeparator : '',
				name : 'id_movimiento',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			form : true,
			save_as : 'hidden_id_movimiento'
		};
	vectorAtributos[2]={
		validacion:{
		fieldLabel: 'Item',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Item...',
				name: 'id_item',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_item', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_item,
				valueField: 'id_item',
				displayField: 'nombre',//campo del store q se mostrara
				queryParam: 'filterValue_0',
				filterCol:'ITM.codigo',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				renderer:render_item,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:200, // ancho de columna en el gris
				width:285,
				tpl: tpl_item,
				grid_indice:1
	},
	tipo:'ComboBox',
	id_grupo:0,
	filtro_0:false,
	form: true,
	save_as:'txt_id_item'	
	};
	vectorAtributos[3]={
			validacion : {
				name : 'cantidad',
				fieldLabel : 'Cantidad',
				allowBlank : false,
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 80,
				width : 285
			},
			tipo : 'NumberField',
			filtro_0 : true,
			filterColValue : 'dem.cantidad',
			form : true,
			save_as : 'txt_cantidad'			
	};
	vectorAtributos[4]={
			validacion : {
				name : 'cantidad_solicitada',
				fieldLabel : 'Cantidad Solicitada',
				allowBlank : false,
				align : 'left',
				grid_visible : false,
				grid_editable : false,
				width_grid : 100,
				width : 285
			},
			tipo : 'NumberField',
			filtro_0 : true,
			filterColValue : 'dem.cantidad_solicitada',
			form : false,
			save_as : 'txt_cantidad_solicitada'
	};
	vectorAtributos[5]={
			validacion : {
				name : 'tipo_saldo',
				fieldLabel : 'Tipo Saldo',
				emptyText : 'Tipo de saldo...',
				allowBlank : false,
				typeAhead : true,
				loadMask : false,
				triggerAction : 'all',
				mode : "local",
				store : new Ext.data.SimpleStore({
					fields : [ 'valor', 'tipo_saldo' ],
					data : [ [ 'por_entregar', 'Por entregar' ],
							[ 'rechazado', 'Rechazado' ] ]
				}),
				valueField : 'valor',
				displayField : 'tipo_saldo',
				align : 'center',
				lazyRender : true,
				forceSelection : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 75,
				width : 285,
				renderer : renderTipoSaldo
			},
			tipo : 'ComboBox',
			filtro_0 : true,
			filterColValue : 'dem.tipo_saldo',
			form : true,
			save_as : 'txt_tipo_saldo'
	};
	vectorAtributos[6]={
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 190
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'dem.usuario_reg',
			form : false
		};
	vectorAtributos[7]={
		validacion : {
			name : 'fecha_reg',
			fieldLabel : 'Fecha Registro',
			format : 'd/m/Y',
			minValue : '01/01/1900',
			grid_visible : true,
			grid_editable : false,
			renderer : formatDate,
			align : 'center',
			width_grid : 150
		},
		tipo : 'DateField',
		form : false,
		filtro_0 : true,
		filterColValue : 'dem.fecha_reg',
		dateFormat : 'd-m-Y'
	};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
		layout_detalle_movimiento = new DocsLayoutMaestro(idContenedor);
		layout_detalle_movimiento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		this.pagina = Pagina;
		this.pagina(paramConfig, vectorAtributos, ds, layout_detalle_movimiento,
				idContenedor);
	// herencia de metodos
		var CM_getComponente = this.getComponente;
		var CM_btnNew = this.btnNew;
		var CM_btnEdit = this.btnEdit;
		var CM_ocultarComponente = this.ocultarComponente;
		var CM_mostrarComponente = this.mostrarComponente;
		var cm_getComponente = this.getComponente;
		this.btnEdit = function()
		{
			CM_btnEdit();
			var comboTipoSaldo = CM_getComponente("tipo_saldo");
			var txtCantidadSolicitada = cm_getComponente("cantidad_solicitada");
			comboTipoSaldo.disable();
			CM_ocultarComponente(comboTipoSaldo);
			if (maestro.id_solicitud_salida != undefined
				&& maestro.id_solicitud_salida != ''
				&& maestro.id_solicitud_salida != null) {
				CM_getComponente("id_item").disable();
				CM_mostrarComponente(txtCantidadSolicitada);
				CM_getComponente("cantidad_solicitada").disable();
				var txtCantidadSolicitada = CM_getComponente("cantidad_solicitada");
				var txtCantidad = CM_getComponente("cantidad");
			if (txtCantidad.getValue() < txtCantidadSolicitada.getValue()) {
				CM_mostrarComponente(comboTipoSaldo);
				comboTipoSaldo.enable();
			}
		} else {
			CM_getComponente("id_item").enable();
			CM_getComponente("cantidad_solicitada").disable();
			CM_ocultarComponente(txtCantidadSolicitada);
		}
	}
	this.btnNew = function() {
			CM_btnNew();
			var comboTipoSaldo = CM_getComponente("tipo_saldo");
			var txtCantidadSolicitada = CM_getComponente("cantidad_solicitada");
			comboTipoSaldo.disable();
			CM_ocultarComponente(comboTipoSaldo);
			CM_getComponente("id_item").enable();
			CM_ocultarComponente(txtCantidadSolicitada);
		}
	
		this.reload = function(m) {
			maestro = m;
			ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_movimiento : maestro.id_movimiento
				}
			};
			vectorAtributos[1].defecto = maestro.id_movimiento;
			if (maestro.estado == "finalizado") {
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("editar-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			} else if (maestro.estado == "borrador") {
				cm_getBoton("nuevo-" + idContenedor).show();
				cm_getBoton("editar-" + idContenedor).show();
				cm_getBoton("eliminar-" + idContenedor).show();
			}
			if (maestro.id_solicitud_salida != null
					&& maestro.id_solicitud_salida != ''
					&& maestro.id_solicitud_salida != 'undefined') {
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			}

			else if (maestro.estado == "proceso_aprobacion") {
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("editar-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			}
			this.btnActualizar();
		}
	var paramMenu={
			nuevo:{		crear:true
				   		,separador:true
				   },
			editar:{
						crear:true 
						,separador:false
					},
			eliminar:{
						crear:true
						,separador:false
						},
			actualizar:{
						crear:true
						,separador:false
						}
		};
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	// funciones render
	function renderTipoSaldo(component, value, record) {
		var tipo_saldo;
		if (record.data['tipo_saldo'] == 'por_entregar') {
			tipo_saldo = 'Por entregar';
		} else {
			tipo_saldo = 'Rechazado';
		}
		return String.format('{0}', tipo_saldo);
	}
	//datos necesarios para el filtro
	var paramFunciones = {
			btnEliminar : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionEliminarDetalleMovimiento.php"
			},
			Save : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionGuardarDetalleMovimiento.php"
			},
			ConfirmSave : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionGuardarDetalleMovimiento.php"
			},
			Formulario : {
				titulo : 'Registro de Detalle Movimiento',
				html_apply : "dlgInfo-" + idContenedor,
				width : 450,
				height : 250,
				columnas : [ '95%' ],
				closable : true
			}
		};;
	
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_detalle_movimiento.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	
	// --- Eventos adicionales de la vista
	var cbxTipoSaldo = cm_getComponente("tipo_saldo");
	cbxTipoSaldo.enable();

	var txtCantidad = cm_getComponente("cantidad");
	txtCantidad.on("change", cantidadChange, this);

	function cantidadChange(field, newValue, oldValue) {
		if (maestro.id_solicitud_salida != null
				&& maestro.id_solicitud_salida != undefined
				&& maestro.id_solicitud_salida != "") {
			var txtCantidadSolicitada = cm_getComponente("cantidad_solicitada");
			var cmbTipoSaldo = cm_getComponente("tipo_saldo");

			if (newValue < txtCantidadSolicitada.getValue()) {
				CM_mostrarComponente(cmbTipoSaldo);
				cmbTipoSaldo.enable();
			} else if (newValue == txtCantidadSolicitada.getValue()) {
				CM_ocultarComponente(cmbTipoSaldo);
				cmbTipoSaldo.disable();
			} else {
				field.setValue(oldValue);

			}
		}
	} 
	cbxTipoSaldo.modificado = true;
	
	//iniciarEventosFormularios();
	layout_detalle_movimiento.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}