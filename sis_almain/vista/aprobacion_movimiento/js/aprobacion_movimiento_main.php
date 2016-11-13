<?php
session_start();
?>

var aprobacion_movimiento;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		?>
	//
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaAprobacion_Movimiento(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: pagina_Aprobacion_Movimiento.js Propósito: pagina objeto principal Autor: Ruddy
 * Luján Bravo Fecha creación: 07-10-2013 16:53:59
 */
function PaginaAprobacion_Movimiento(idContenedor, direccion, paramConfig) {
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_aprobacion_movimiento;
	var idAlmacen;
	var nombreVista = "aprobacion_movimiento";
	// DATA STORE //
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/movimiento/ActionListarMovimiento.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_movimiento',
			totalRecords : 'TotalCount'
		}, [ 'id_movimiento', 'id_tipo_movimiento', 'id_almacen', 'codigo',
				'descripcion_tipo', 'nombre_tipo', 'fecha_movimiento',
				'descripcion', 'observaciones', 'estado', 'usuario_reg',
				'usuario_mod', {
					name : 'fecha_mod',
					type : 'date',
					dateFormat : 'd-m-Y'
				}, {
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				}, {
					name : 'fecha_movimiento',
					type : 'date',
					dateFormat : 'd-m-Y'
				}, {
					name : 'fecha_finalizacion',
					type : 'date',
					dateFormat : 'd-m-Y'
				} ]),
		remoteSort : true
	});
	// Carga los datos en el DataStore.
	ds.load({
		params : {
			start : 0,
			limit : paramConfig.TamanoPagina,
			CantFiltros : paramConfig.CantFiltros,
			nombreVista : "aprobacion_movimiento"
		}
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
	
	// PARÁMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_movimiento',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_movimiento'
			},			
			{
				validacion : {
					name : 'nombre_tipo',
					fieldLabel : 'Tipo Generico',
					emptyText : 'Tipo Genérico...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode: "local",
					desc : 'nombre_tipo',
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'tipo' ],
						data : [ [ 'ingreso', 'Ingreso' ],
								[ 'salida', 'Salida' ] ]
					}),
					valueField : 'valor',
					displayField : 'tipo',
					align : 'left',
					lazyRender : true,
					forceSelection : true,
					grid_visible : false,
					grid_editable : false,
					width_grid : 100,
					width : 285
					
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tip.tipo',
				form : true
			},
			
			
			{
				validacion : {
					name : 'id_tipo_movimiento',
					fieldLabel : 'Tipo movimiento',
					allowBlank : false,
					emptyText : 'Tipo Movimiento...',
					desc : 'descripcion_tipo',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_almain/control/tipo_movimiento/ActionListarTipoMovimiento.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_tipo_movimiento',
									totalRecords : 'TotalCount'
								}, [ 'id_tipo_movimiento',
										'descripcion_documento' ])
							}),
					valueField : 'id_tipo_movimiento',
					displayField : 'descripcion_documento',
					queryParam : 'filterValue_0',
					filterCol : 'tip.tipo',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 380,
					width : 280,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2,
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 150,
					CantFiltros: 2
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'hidden_id_tipo_movimiento'
			},			
			{
				validacion : {
					name : 'descripcion_tipo',
					fieldLabel : 'Tipo Movimiento',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200,
					width : 320
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'doc.descripcion',
				form : false
			},
			{
				validacion : {
					name : 'nombre_tipo',
					fieldLabel : 'Tipo Generico',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'tip.tipo',
				form : false
			},
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
					grid_visible : true,
					grid_editable : false,
					forceSelection : true,
					width_grid : 60,
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
					name : 'fecha_movimiento',
					fieldLabel : 'Fecha Movimiento',
					allowBlank : false,
					format : 'd/m/Y', // formato para validacion
					minValue : '01/01/1900',
					disabledDaysText : 'Día no válido',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					width_grid : 110,
					disabled : false,
					align : 'center',
					width : '50%'
				},
				form : true,
				tipo : 'DateField',
				filtro_0 : true,
				filterColValue : 'al.fecha_movimiento',
				dateFormat : 'm-d-Y',
				save_as : 'txt_fecha_movimiento'
			},
			{
				validacion : {
					name : 'fecha_finalizacion',
					fieldLabel : 'Fecha Finalización',
					allowBlank : false,
					format : 'd/m/Y',
					minValue : '01/01/1900',
					disabledDaysText : 'Día no válido',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					width_grid : 115,
					disabled : false,
					align : 'center',
					width : '50%'
				},
				form : false,
				tipo : 'DateField',
				filtro_0 : true,
				filterColValue : 'al.fecha_finalizacion',
				dateFormat : 'm-d-Y',
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					forceSelection : true,
					width_grid : 200,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'al.descripcion',
				filtro_1 : true,
				form : true,
				save_as : 'txt_descripcion'
			},
			{
				validacion : {
					name : 'observaciones',
					fieldLabel : 'Observaciones',
					allowBlank : true,
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
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'al.observaciones',
				filtro_1 : true,
				form : true,
				save_as : 'txt_observaciones'
			},
			{
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					align : 'left',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 130,
					renderer : renderEstado
					
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.estado',
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
				filterColValue : 'per.nombre#per.apellido_paterno#per.apellido_materno',
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
					width_grid : 95
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : true,
				filterColValue : 'al.fecha_reg',
				dateFormat : 'm-d-Y'
			},
			{
				validacion : {
					name : 'usuario_mod',
					fieldLabel : 'Responsable Modificación',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'per2.nombre#per2.apellido_paterno#per2.apellido_materno',
				form : false
			}, {
				validacion : {
					name : 'fecha_mod',
					fieldLabel : 'Fecha Modificación',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					align : 'center',
					width_grid : 116
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : true,
				filterColValue : 'al.fecha_mod',
				dateFormat : 'm-d-Y'
			} ];

	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'Aprobacion de Movimientos',
		grid_maestro : 'grid-' + idContenedor,
		urlHijo : '../../../sis_almain/vista/detalle_movimiento/detalle_movimiento.php'
	};
	
	layout_aprobacion_movimiento = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_aprobacion_movimiento.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_aprobacion_movimiento, idContenedor);
	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
	var cm_getSelectionModel = this.getSelectionModel;
	var cm_conexionFailure = this.conexionFailure;
	var cm_eliminarSuccess = this.eliminarSucess;
	var cm_btnActualizar = this.btnActualizar;
	var cm_btnNew = this.btnNew;
	var cm_btnEdit = this.btnEdit;
	var cm_getComponente = this.getComponente;
	var cm_btnEliminar = this.btnEliminar;
	var cm_BloquearMenu = this.BloquearMenu;
	

	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	ds_almacen.on('load', function(store, records, options) {
		ds_almacen.commitChanges();

	}, this);
	ds.baseParams.id_almacen = idAlmacen;

	this.EnableSelect = function(selEvent, rowIndex, selectedRow) {
		cm_EnableSelect(selEvent, rowIndex, selectedRow);
		_CP.getPagina(layout_aprobacion_movimiento.getIdContentHijo()).pagina
				.reload(selectedRow.data);
		_CP.getPagina(layout_aprobacion_movimiento.getIdContentHijo()).pagina
				.desbloquearMenu();
				
		var btnFinalizarMovimiento = cm_getBoton('FinalizarMovimiento-'+ idContenedor);
		btnFinalizarMovimiento.enable();
		
		if (selectedRow.data.estado == "proceso_aprobacion") {
		} else if (selectedRow.data.estado == "finalizado") {
			cm_DesbloquearMenu();
		}
		var btnRechazarMovimiento = cm_getBoton('RechazarMovimiento-'
				+ idContenedor);
		btnRechazarMovimiento.enable();

		if (selectedRow.data.estado == "proceso_aprobacion") {
		} else if (selectedRow.data.estado == "borrador") {

			cm_DesbloquearMenu();
		}
	}

	this.DeselectRow = function(n, n1) {
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout_aprobacion_movimiento.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout_aprobacion_movimiento.getIdContentHijo()).pagina.bloquearMenu();
	};
	// ----------- DEFINICIÓN DE LA BARRA DE MENÚ ----------- //

	var paramMenu = {
		actualizar : {
			crear : true,
			separador : false
		}
	};

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'proceso_aprobacion') {
			estado = 'Proceso aprobacion';
		}
		return String.format('{0}', estado);
	}
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/movimiento/ActionEliminarMovimiento.php"
		},
		Save : {
			url : direccion
					+ "../../../control/movimiento/ActionGuardarMovimiento.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/movimiento/ActionGuardarMovimiento.php"
		},
		Formulario : {
			titulo : 'Aprobacion de Movimientos',
			html_apply : "dlgInfo-" + idContenedor,
			width : 460,
			height : 380,
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

	this.AdicionarBoton('../../../lib/imagenes/terminar.png',
			'Finalizar Movimiento', btnFinalizarMovimiento, false,
			'FinalizarMovimiento', 'Finalizar');
	cm_getBoton('FinalizarMovimiento-' + idContenedor).disable();

	function successFinalizarMovimiento() {
		alert('entra al success');
	}
	function btnFinalizarMovimiento() {
		var sm = cm_getSelectionModel();
		Ext.MessageBox
				.confirm(
						'Atención',
						'Esta seguro de finalizar el movimiento seleccionada?',
						function(btn) {
							if (btn == 'yes') {
								var data = "id_movimiento="
										+ sm.getSelected().data.id_movimiento;
								Ext.Ajax
										.request({
											url : direccion
													+ "../../../control/movimiento/ActionFinalizarMovimientoClick.php",
											params : data,
											method : 'POST',
											success : cm_eliminarSuccess,
											failure : cm_conexionFailure,
											timeout : 10000
										});
							}
						});
	}

	this.AdicionarBoton('../../../lib/imagenes/volver.png',
			'Rechazar Movimiento', btnRechazarMovimiento, false,
			'RechazarMovimiento', 'Rechazar');
	cm_getBoton('RechazarMovimiento-' + idContenedor).disable();

	function successRechazarMovimiento() {
		alert('entra al success');
	}
	function btnRechazarMovimiento() {
		var sm = cm_getSelectionModel();
		Ext.MessageBox
				.confirm(
						'Atención',
						'Esta seguro de rechazar el movimiento seleccionada?',
						function(btn) {
							if (btn == 'yes') {
								var data = "id_movimiento="
										+ sm.getSelected().data.id_movimiento;
								Ext.Ajax
										.request({
											url : direccion
													+ "../../../control/movimiento/ActionRechazarMovimientoClick.php",
											params : data,
											method : 'POST',
											success : cm_eliminarSuccess,
											failure : cm_conexionFailure,
											timeout : 10000
										});
							}
						});
	}
	layout_aprobacion_movimiento.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}