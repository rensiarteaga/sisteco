<?php
session_start();
?>

var movimiento;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		echo "var mov_estado='$mov_estado';";
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
var elemento={pagina:new PaginaMovimiento(idContenedor,direccion,paramConfig,mov_estado),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: pagina_movimiento.js
 * Proposito: pagina objeto principal  
 * Autor: Ruddy Lujan Bravo 
 * Fecha creacion: 06-09-2013 16:53:59
 */
function PaginaMovimiento(idContenedor, direccion, paramConfig,mov_estado) {
	var sm;
	var vectorAtributos = new Array();
	var componentes= new Array();  
	var ds;
	var layout_movimiento;
	var idAlmacen;
	var comboTipoMov;
	var tipoControl;

	
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
		}, [ 'id_movimiento', 'id_tipo_movimiento', 'id_solicitud_salida',
				'id_almacen', 'codigo', 'descripcion_tipo', 'nombre_tipo',
				'requiere_aprobacion', 'fecha_movimiento', 'descripcion',
				'observaciones', 'estado', 'valorizado','usuario_reg','id_almacen_trans','desc_almacen', 'id_movimiento_fk','almacen_destino','nro_compra','tipo_control',
				{
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
	
	ds.lastOptions = {
		params : {
			start : 0,
			limit : paramConfig.TamanoPagina,
			CantFiltros : paramConfig.CantFiltros
		}
	};

	var ds_almacen = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion
					+ '../../../control/almacen/ActionListarAlmacen.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_almacen',
			totalRecords : 'TotalCount'
		}, [ 'id_almacen', 'codigo', 'nombre','direccion','tipo_control' ])
	});

	//ds_almacen_destino
	function render_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	var tpl_almacen=new Ext.Template('<div class="search-item">','<b>{nombre}</b></br>','<b>C&oacute;digo  :</b>&nbsp&nbsp<FONT COLOR="#B5A642">{codigo}</FONT></br>','<b>Direcci&oacute;n  :</b>&nbsp&nbsp<FONT COLOR="#B5A642">{direccion}</FONT>','</div>');
	
	
	function render_doc(value, p, record){return String.format('{0}', record.data['descripcion_tipo']);}
	var tpl_doc=new Ext.Template('<div class="search-item">','<b><i>{documento}</i></b></br>','<b>C&oacute;digo :  </b><FONT COLOR="#B5A642">{codigo_documento}</FONT></br>','<b>Tipo:	</b>&nbsp&nbsp<FONT COLOR="#B5A642">{tipo}</FONT></br>','<b>Aprobacion: <b>&nbsp&nbsp<FONT COLOR="#B5A642">{requiere_aprobacion}</FONT>','</div>');

	
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

	cbxSisAlma.on('select', function(combo, record, index) {
		cm_DesbloquearMenu();
		idAlmacen = cbxSisAlma.getValue();
		tipoControl = cbxSisAlma.store.getById( cbxSisAlma.getValue()).data.tipo_control;
		
		ds.baseParams.id_almacen = idAlmacen;
		ds.baseParams.tipo_control = tipoControl;
		cm_btnActualizar();
		combo.modificado = true;
	});
	// PARAMETROS DEL FORMULARIO Y EL GRID//
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
				save_as : 'hidden_id_movimiento'
			},
			{
				validacion:{
					fieldLabel: 'Identificador',
					name: 'id_movimiento',
					grid_visible:true, // se muestra en el grid
					grid_editable:false,
					align:'center',
					grid_indice:1
				},
				tipo:'Field',
				filtro_0:true,
				filterColValue:'al.id_movimiento',
				form:false
			},
			{
				validacion : {
					name : 'nombre_tipo',
					fieldLabel : 'Movimiento',
					emptyText : 'Movimiento...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					desc : 'nombre_tipo',
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre_tipo' ],
						data : [
						        	[ 'ingreso', 'Ingreso' ],
						        	[ 'salida', 'Salida' ]
						        	//,['transpaso_ingreso','Transpaso Ingreso']
						        	,['transpaso_salida','Transferencia']
								]
					}),
					valueField : 'valor',
					displayField : 'nombre_tipo',
					align : 'left',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 95,
					width : 285,
					renderer : renderNombreTipo

				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tip.tipo',
				form : true
			},
			{
				validacion : {
					name : 'codigo',
					fieldLabel : 'Nro. Documento',
					allowBlank : true,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					forceSelection : false,
					width_grid : 220,
					grid_indice:2,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo',
				form : false,
				save_as : 'txt_codigo'
			}
			,
			{
				validacion : {
					name : 'id_tipo_movimiento',
					fieldLabel : 'Documento',
					allowBlank : false,
					emptyText : 'Documento...',
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
										'descripcion_documento','codigo_documento',
										'tipo','requiere_aprobacion','documento' ])
							}),
					valueField : 'id_tipo_movimiento',
					displayField : 'descripcion_documento',
					queryParam : 'filterValue_0',
					filterCol : 'tip.tipo',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					renderer:render_doc,
					pageSize : 10,
					minListWidth : 380,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2,
					tpl:tpl_doc,
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 200,
					grid_indice:3,
					CantFiltros : 2
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'hidden_id_tipo_movimiento'
			},
			{
				validacion : {
					name : 'descripcion_tipo',
					fieldLabel : 'Documento',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250,
					grid_indice:4,	
					width : 320
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'doc.descripcion',
				form : false
			},
			{
				validacion : {
					name : 'requiere_aprobacion',
					fieldLabel : 'Requiere aprobacion',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 120,
					width : 285,
					renderer : renderaprobacion
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'tip.requiere_aprobacion',
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
					fieldLabel : "Nro. Solicitud", 
					labelSeparator : '',
					name : 'id_solicitud_salida',
					inputType : 'hidden',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 80
					//,renderer : renderSolicitudSalida
				},
				tipo : 'Field',
				form : false,
				filtro_0 : false,
				save_as : 'hidden_id_solicitud_salida'
			},
			{
				validacion : {
					name : 'fecha_movimiento',
					fieldLabel : 'Fecha Movimiento',
					allowBlank : false,
					format : 'd/m/Y', // formato para validacion
					minValue : '01/01/1900',
					disabledDaysText : 'Dia no Valido',
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
				validacion:{
					fieldLabel: 'Almacen Destino :', 
							allowBlank: true,
							vtype:"texto",
							emptyText:'Almacen Destino...',
							name: 'id_almacen_trans',     //indica la columna del store principal "ds" del que proviane el id
							desc: 'desc_almacen', //indica la columna del store principal "ds" del que proviane la descripcion
							store: ds_almacen,
							valueField: 'id_almacen',
							displayField: 'nombre',//campo del store q se mostrara
							queryParam: 'filterValue_0',
							filterCol : 'al.nombre',
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
							renderer:render_almacen,
							grid_visible:false, // se muestra en el grid
							grid_editable:false, //es editable en el grid,
							width_grid:220, // ancho de columna en el gris
							width : 180,
							tpl: tpl_almacen
				},
				tipo:'ComboBox',
				filtro_0:false,
				form: true,
				save_as:'txt_id_almacen_destino'
			},
			{
				validacion : {
					name : 'fecha_finalizacion',
					fieldLabel : 'Fecha Finalizacion',
					allowBlank : false,
					format : 'd/m/Y',
					minValue : '01/01/1900',
					disabledDaysText : 'Dia no Valido',
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
					name : 'nro_compra',
					fieldLabel : 'Orden de Compra',
					allowBlank : true,
					align : 'center',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 130,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : false,
				form : true,
				save_as:'txt_nro_compra'
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : true,
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
					name : 'almacen_destino',
					fieldLabel : 'Almacen Destino',
					align : 'left',
					lazyRender : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 120,

				},
				tipo : 'TextField',
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
					width_grid : 95
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : false,
				filterColValue : 'al.fecha_reg',
				dateFormat : 'm-d-Y'
			},
			{
				validacion:{
					labelSeparator:'',
					name: 'id_movimiento_fk',
					inputType:'hidden',
					grid_visible:false, // se muestra en el grid 
					grid_editable:false
				},
				tipo:'Field'
			},
			//helpers de la finalizacion del movimiento
			{
				validacion:{
					labelSeparator:'',
					name: 'txt_tipo_movimiento',
					inputType:'hidden',
					grid_visible:false, // se muestra en el grid
					grid_editable:false //es editable en el grid
				},
				tipo: 'Field'
			},
			{
				validacion:{
					labelSeparator:'',
					name: 'txt_aprobacion',
					inputType:'hidden',
					grid_visible:false, // se muestra en el grid
					grid_editable:false //es editable en el grid
				},
				tipo: 'Field'
			},
			{
				validacion:{
					labelSeparator:'',
					name: 'txt_accion',
					inputType:'hidden',
					grid_visible:false, // se muestra en el grid
					grid_editable:false //es editable en el grid
				},
				tipo: 'Field'
			}];

	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'movimiento',
		grid_maestro : 'grid-' + idContenedor,
		urlHijo : '../../../sis_almain/vista/detalle_movimiento/detalle_movimiento.php'};
	layout_movimiento = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_movimiento.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_movimiento,
			idContenedor);
	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
	var cm_getSelectionModel = this.getSelectionModel;
	var cm_conexionFailure = this.conexionFailure;
	var cm_btnActualizar = this.btnActualizar;
	var cm_btnNew = this.btnNew;
	var cm_btnEdit = this.btnEdit;
	var cm_getComponente = this.getComponente;
	var cm_btnEliminar = this.btnEliminar;
	var cm_eliminarSuccess = this.eliminarSucess;
	var cm_Save=this.Save;
	var cm_ocultarComponente = this.ocultarComponente;
	var cm_mostrarComponente = this.mostrarComponente;
	var cm_getBoton=this.getBoton;
	// -------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	ds_almacen.on('load', function(store, records, options) {ds_almacen.commitChanges();}, this);
	ds.baseParams.id_almacen = idAlmacen;
	//control de la vista movimiento el estado del movimiento que se envia
	if(mov_estado != '')
	{
			ds.baseParams.estado_movimiento = mov_estado;
	}
	
	this.btnNew = function() 
	{
		cm_btnNew();
		cm_getComponente('id_almacen').setValue(idAlmacen);
		cm_getComponente('id_tipo_movimiento').disable();
		
		cm_getComponente('txt_accion').setValue('');


		cm_getComponente('nombre_tipo').enable();
		cm_getComponente('id_tipo_movimiento').enable();
		cm_getComponente('fecha_movimiento').enable();
		
		//a�adido 28/07/2015
		get_fecha_db(); 
	}

	this.btnEdit = function() 
	{
		cm_btnEdit();
		cm_getComponente('txt_accion').setValue('');
		cm_getComponente('id_tipo_movimiento').enable(); 
		var tipo_generico = cm_getComponente('nombre_tipo').getValue();

		cm_getComponente('id_tipo_movimiento').store.baseParams = {
			filterCol_1 : "tip.tipo",
			filterValue_1 : tipo_generico
		};

		cm_getComponente('id_tipo_movimiento').modificado = true; 
		
		//ocultar fecha cuando el movimento en ingreso
		var sm=cm_getSelectionModel();
		var SelectionsRecord=sm.getSelected();	
		cm_getComponente('fecha_movimiento').allowBlank=true;
		
		
		if(SelectionsRecord.data.nombre_tipo == "ingreso") 
		{
			//cm_ocultarComponente(cm_getComponente('fecha_movimiento'));
			//cm_getComponente('fecha_movimiento').allowBlank=true;

			cm_mostrarComponente(cm_getComponente('fecha_movimiento'));
			cm_getComponente('fecha_movimiento').allowBlank=false;
			
			cm_ocultarComponente(cm_getComponente('id_almacen_trans'));
			cm_getComponente('id_almacen_trans').allowBlank=true;

			cm_mostrarComponente(cm_getComponente('nro_compra'));
			cm_getComponente('nro_compra').allowBlank=false;
		}
		else if(SelectionsRecord.data.nombre_tipo == "transpaso_salida")
		{
			cm_mostrarComponente(cm_getComponente('id_almacen_trans'));
			cm_getComponente('id_almacen_trans').allowBlank=false;

			cm_getComponente('nro_compra').setValue('');
		}
		else
		{
			cm_ocultarComponente(cm_getComponente('id_almacen_trans'));
			cm_getComponente('id_almacen_trans').allowBlank=true;
			
			cm_mostrarComponente(cm_getComponente('fecha_movimiento'));
			cm_getComponente('fecha_movimiento').allowBlank=false;

			cm_ocultarComponente(cm_getComponente('nro_compra'));
			cm_getComponente('nro_compra').allowBlank=true;
			cm_getComponente('nro_compra').setValue('');
		}
		
		//bloqueo de edicion si tipo_movimiento=transpaso_ingreso
		if (SelectionsRecord.data.nombre_tipo == "transpaso_ingreso") 
		{
			cm_getComponente('nombre_tipo').disable();
			cm_getComponente('id_tipo_movimiento').disable();
			cm_getComponente('fecha_movimiento').disable();
		}
		else
		{
			cm_getComponente('nombre_tipo').enable();
			cm_getComponente('id_tipo_movimiento').enable();
			cm_getComponente('fecha_movimiento').enable();
		}
		
		
	}
	this.EnableSelect = function(selEvent, rowIndex, selectedRow) 
	{
		cm_EnableSelect(selEvent, rowIndex, selectedRow);

		
		_CP.getPagina(layout_movimiento.getIdContentHijo()).pagina.reload(selectedRow.data);
		_CP.getPagina(layout_movimiento.getIdContentHijo()).pagina.desbloquearMenu();
		 
		if (mov_estado == "borrador") 
		{
			var btnFinalizarEnviarMovimiento = cm_getBoton('FinalizarEnviarMovimiento-'+ idContenedor);
			btnFinalizarEnviarMovimiento.enable();

			var btnFinalizarEntrega = cm_getBoton('FinalizarEntrega-'+ idContenedor);
			btnFinalizarEntrega.enable();
			

			cm_getBoton('nuevo-' + idContenedor).enable();
			cm_getBoton('editar-' + idContenedor).enable();
			cm_getBoton('eliminar-' + idContenedor).enable();
			
			if (selectedRow.data.requiere_aprobacion == "si" && (selectedRow.data.id_solicitud_salida == null || selectedRow.data.id_solicitud_salida=='')) 
			{
				
				btnFinalizarEnviarMovimiento.setText("Enviar Aprobacion");
				btnFinalizarEntrega.hide();
				btnFinalizarEnviarMovimiento.show();
			}

			else if (selectedRow.data.requiere_aprobacion == "no" && (selectedRow.data.id_solicitud_salida == null || selectedRow.data.id_solicitud_salida=='') )
			{
				btnFinalizarEnviarMovimiento.setText("Finalizar");
				btnFinalizarEntrega.hide();
				btnFinalizarEnviarMovimiento.show();
			}
			//a�adido 27062014 control boton de finalizacion de entrega
			else if(selectedRow.data.id_solicitud_salida > 0 && (selectedRow.data.requiere_aprobacion=='si' || selectedRow.data.requiere_aprobacion=='no' ) ) 
			{
				btnFinalizarEntrega.show();
				btnFinalizarEnviarMovimiento.hide();

				cm_getBoton('editar-' + idContenedor).disable();
				cm_getBoton('eliminar-' + idContenedor).disable();
			} 
			//control para q un tipo_movimiento='transpaso_ingreso' no pueda ser eliminado
			if(selectedRow.data.nombre_tipo == 'transpaso_ingreso')
			{
				cm_getBoton('eliminar-' + idContenedor).disable();
			}
			
		}
		else
		{ 
			if(mov_estado == "finalizado")
			{
				if (selectedRow.data.estado == "valorado")
				{
					cm_getBoton('valorizacion-' + idContenedor).enable();
					cm_getBoton('reportePDF-' + idContenedor).disable();
					cm_getBoton('corregir_movimiento-' + idContenedor).enable();
				}
				else
				{
					cm_getBoton('valorizacion-' + idContenedor).disable();
					cm_getBoton('reportePDF-' + idContenedor).enable();
					cm_getBoton('corregir_movimiento-' + idContenedor).disable();
				}	
			} 
		}
	}

	function cargar_activar(resp) {
		alert('La finalizacion del movimiento fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_inactivar(resp) {
		alert('El envio del movimiento fue exitosa');
		ClaseMadre_btnActualizar();
	}

	this.DeselectRow = function(n, n1)
	{
		//cm_getBoton('FinalizarEnviarMovimiento-' + idContenedor).disable();
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout_movimiento.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout_movimiento.getIdContentHijo()).pagina.bloquearMenu();
	};
	// ----------- DEFINICION DE LA BARRA DE MENU� ----------- //
	if(mov_estado == 'borrador')
	{	
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
	}
	else
	{
		var paramMenu = {
				actualizar:{
					crear :true,
					separador:false
				}
			};
	}

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	};

	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'pendiente_aprobacion') {
			estado = 'Pendiente';
		} else if (record.data['estado'] == 'borrador') {
			estado = 'Borrador';
		} else if (record.data['estado'] == 'finalizado') {
			estado = 'Finalizado';
		}else if (record.data['estado'] == 'valorado') {
			estado = 'Valorado';
		}
		return String.format('{0}', estado);
	}

	function renderSolicitudSalida(component, cell, record) {
		var renderResult;
		if (record.data["id_solicitud_salida"] != null
				&& record.data["id_solicitud_salida"] != ''
				&& record.data["id_solicitud_salida"] != undefined) {
			renderResult = 'Si';
		} else {
			renderResult = 'No';
		}
		return String.format('{0}', renderResult);
	}

	function renderNombreTipo(component, value, record) {
		var nombre_tipo;
		if (record.data['nombre_tipo'] == 'ingreso' ) {
			nombre_tipo = 'Ingreso';
		} else if(record.data['nombre_tipo'] == 'salida' || record.data['nombre_tipo'] == 'solicitud') {
			nombre_tipo = 'Salida';
		}
		else if (record.data['nombre_tipo'] == 'devolucion')
			nombre_tipo = 'Devoluci�n';
		/* else if(record.data['nombre_tipo'] == '') {
				nombre_tipo = ';
			}*/
		 else if(	(record.data['nombre_tipo'] == 'transpaso_salida') ||	(record.data['nombre_tipo'] == 'transpaso_ingreso') ) {
				nombre_tipo = 'Transferencia';
			}
		return String.format('{0}', nombre_tipo);
	}

	function renderaprobacion(component, value, record) {
		var requiere_aprobacion;
		if (record.data['requiere_aprobacion'] == 'si') {
			requiere_aprobacion = 'Si';
		} else {
			requiere_aprobacion = 'No';
		}
		return String.format('{0}', requiere_aprobacion);
	}
	// ---------------------- DEFINICION DE FUNCIONES -------------------------
	var paramFunciones = { 
		btnEliminar : {
			url : direccion
					+ "../../../control/movimiento/ActionEliminarMovimiento.php"
		},
		Save : {
			url : direccion
					+ "../../../control/movimiento/ActionGuardarMovimiento.php",parametros:'&estado='+mov_estado
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/movimiento/ActionGuardarMovimiento.php"
		},
		Formulario : {
			titulo : 'Registro de Movimientos',
			html_apply : "dlgInfo-" + idContenedor,
			width : 460,
			height : 380,
			columnas : ['95%'],
			closable : true
		}
	};
	
	function iniciarEventosFormularios()
	{
		//ocultar fecha cuando el movimento en ingreso
		comboTipoMov =  cm_getComponente('nombre_tipo');
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=cm_getComponente(vectorAtributos[i].validacion.name);
		}
		
		var onComboTipoMovimientoSelect=function(e)
		{
			var tipo = cm_getComponente('nombre_tipo').getValue();
			cm_getComponente('nro_compra').allowBlank=true;
			cm_getComponente('nro_compra').setValue('');
			
			if(tipo =='ingreso')
			{
				cm_ocultarComponente(cm_getComponente('id_almacen_trans'));
				cm_getComponente('id_almacen_trans').allowBlank=true;
				
				//cm_ocultarComponente(cm_getComponente('fecha_movimiento'));
				//cm_getComponente('fecha_movimiento').allowBlank=true;
				
				cm_getComponente('id_tipo_movimiento').setValue('');

				//a�adido 24/07/2015
				cm_mostrarComponente(cm_getComponente('nro_compra'));
				cm_getComponente('nro_compra').allowBlank=false;
				
				cm_mostrarComponente(cm_getComponente('fecha_movimiento'));
				cm_getComponente('fecha_movimiento').allowBlank=false;			
			}
			else if(tipo =='salida')
			{
				cm_ocultarComponente(cm_getComponente('id_almacen_trans'));
				cm_getComponente('id_almacen_trans').allowBlank=true;
				
				cm_mostrarComponente(cm_getComponente('fecha_movimiento'));
				cm_getComponente('fecha_movimiento').allowBlank=false;
				
				cm_getComponente('nro_compra').setValue('');

				//a�adido 24/07/2015
				cm_ocultarComponente(cm_getComponente('nro_compra'));

				cm_getComponente('id_tipo_movimiento').setValue('');
			}
			else if(tipo =='transpaso_salida')
			{ 
				cm_mostrarComponente(cm_getComponente('fecha_movimiento'));
				cm_getComponente('fecha_movimiento').allowBlank=false;
				//hacer visible el combo de almacen destino
				cm_mostrarComponente(cm_getComponente('id_almacen_trans'));
				cm_getComponente('id_almacen_trans').allowBlank=false;
				
				cm_getComponente('id_tipo_movimiento').setValue('');
				cm_getComponente('nro_compra').setValue('');

				//a�adido 24/07/2015
				cm_ocultarComponente(cm_getComponente('nro_compra'));
			}
			else if(tipo =='transpaso_ingreso')
			{
				cm_ocultarComponente(cm_getComponente('id_almacen_trans'));
				cm_getComponente('id_almacen_trans').allowBlank=true;

				//a�adido 24/07/2015
				cm_ocultarComponente(cm_getComponente('nro_compra'));
				cm_getComponente('nro_compra').setValue('');
			}
		}
		comboTipoMov.on('select', onComboTipoMovimientoSelect);
		comboTipoMov.on('change', onComboTipoMovimientoSelect);
		
		
	}
	
	// -------------- FIN DEFINCION DE FUNCIONES PROPIAS --------------//

	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();

	this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');

	if (mov_estado == "borrador")
	{
			// Botones adicionales en el menu
			this.AdicionarBoton('../../../lib/imagenes/ok.png', 'Finalizar/Enviar',btnFinalizarEnviarMovimiento, false, 'FinalizarEnviarMovimiento','Finalizar');
			cm_getBoton('FinalizarEnviarMovimiento-' + idContenedor).disable();
			
			//boton de finalizacion de entrega de una solicitud
			this.AdicionarBoton('../../../lib/imagenes/ok.png', 'FinalizarEntrega',btnFinalizarEntrega, false, 'FinalizarEntrega','Finalizar Entrega');
			cm_getBoton('FinalizarEntrega-' + idContenedor).disable();
			
	}
	else if (mov_estado == "pendiente_aprobacion")
	{
		this.AdicionarBoton('../../../lib/imagenes/cancel.png','Solicitar Correccion',btn_correccion,false,'corregir_movimiento','Correccion');
		this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Movimiento',btn_aprobacion,false,'aprobar_movimiento','Aprobacion');
		
		cm_getBoton('corregir_movimiento-' + idContenedor).disable();
		cm_getBoton('aprobar_movimiento-' + idContenedor).disable();
		
	}
	else if(mov_estado == "finalizado")
	{
		this.AdicionarBoton('../../../lib/imagenes/report.png','Movimientos Finalizados',btn_reporte_movfin,true,'reportePDF','ReportePDF');
		this.AdicionarBoton('../../../lib/imagenes/item.png','Valorizacion',btn_valorizar,true,'valorizacion','Valorar Movimiento');
		this.AdicionarBoton('../../../lib/imagenes/cancel.png','Corregir Movimiento',btn_corregir_movimiento,false,'corregir_movimiento','Corregir Movimiento');
		cm_getBoton('reportePDF-' + idContenedor).disable(); 
		cm_getBoton('valorizacion-' + idContenedor).disable();
		cm_getBoton('corregir_movimiento-' + idContenedor).disable();
	}
	
	//correccion de la valoracion de un movimiento
	function btn_corregir_movimiento()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de corregir la valoracionn del movimiento seleccionado ?"))
			{
			
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Corrigiendo movimiento...</div>",
					width:300,
					height:200,
					closable:false
				}); 
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento/ActionGuardarMovimiento.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_movimiento:SelectionsRecord.data.id_movimiento
								,accion_solicitud:'corregir_movimiento'
							},
					success:esteSuccessValorizacion,
					failure:cm_conexionFailure,
					timeout:100000000
				});
				
				/*
				cm_Save();
				*/
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	//valorizacionn de movimientos
	function btn_valorizar()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en el movimiento seleccionado ?"))
			{
			
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Valorizando movimiento...</div>",
					width:300,
					height:200,
					closable:false
				}); 
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento/ActionGuardarMovimiento.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_movimiento:SelectionsRecord.data.id_movimiento
								,accion_solicitud:'valorizar_movimiento'
							},
					success:esteSuccessValorizacion,
					failure:cm_conexionFailure,
					timeout:100000000
				});
				
				/*
				cm_Save();
				*/
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	//reporte de movimientos finalizados
	function btn_reporte_movfin()
	{
		//Finalizacion por el solicitante
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect == 1)
		{
			var data='m_id_movimiento='+SelectionsRecord.data.id_movimiento;
			data = data +'&id_solicitud_salida='+ SelectionsRecord.data.id_solicitud_salida;
			data = data +'&movimiento='+ SelectionsRecord.data.nombre_tipo;
			window.open(direccion+'../../../../sis_almain/control/_reportes/movimientos/ActionPDFMovimientos.php?tipo_reporte=pdf&'+data);
		} 
		else
		{
			Ext.MessageBox.alert('Atencion', 'Antes debe seleccionar un solo registro.');
		}
	}
	//finalizacion de entrega
	function btnFinalizarEntrega()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en el movimiento seleccionado ?"))
			{
				cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
			
				cm_getComponente('txt_accion').setValue('finalizar_entrega');
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando codigo...</div>",
					width:300,
					height:200,
					closable:false
				}); 
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento/ActionGuardarMovimiento.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_movimiento:SelectionsRecord.data.id_movimiento
								,tipo_movimiento:sm.getSelected().data.nombre_tipo
								,aprobacion:sm.getSelected().data.requiere_aprobacion
								,accion_solicitud:'finalizar_entrega'
								,reporte:'si'
							},
					success:esteSuccessSolicitud,
					failure:cm_conexionFailure,
					timeout:100000000
				});
				
				/*
				cm_Save();
				*/
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	function esteSuccessValorizacion(resp)
	{
		Ext.MessageBox.hide();
		if(! resp.responseXML&&resp.responseXML.documentElement)
		{
			cm_conexionFailure();
		}
		else
		{
			cm_btnActualizar();
		}
	}
	function esteSuccessSolicitud(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			btn_reporte_movfin()
			cm_btnActualizar();
		}
		else
		{
			cm_conexionFailure();
		}
	}
	function esteSuccess(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			btn_reporte_movfin()
			cm_btnActualizar();
		}
		else
		{
			cm_conexionFailure();
		}
	}
	
	//boton de correcion de un movimiento con estado='pendiente_aprobacion'
	function btn_correccion()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en el movimiento seleccionado ?"))
			{
				cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
				cm_getComponente('txt_accion').setValue('corregir_pendiente');
				
				cm_Save();
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	function btn_aprobacion()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
			if(confirm("Esta seguro de ejecutar la accion en el movimiento seleccionado ?"))
			{
				cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
			
				cm_getComponente('txt_accion').setValue('finalizar_pendiente');
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando codigo del movimiento...</div>",
					width:300,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento/ActionGuardarMovimiento.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_movimiento:SelectionsRecord.data.id_movimiento
								,tipo_movimiento:sm.getSelected().data.nombre_tipo
								,aprobacion:sm.getSelected().data.requiere_aprobacion
								,accion_solicitud:'finalizar_pendiente'
								,reporte:'si'
							},
					success:esteSuccess,
					failure:cm_conexionFailure,
					timeout:100000000
				});
				
				/*cm_Save();
				
				btn_reporte_movfin();
				cm_btnActualizar(); */
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Debe seleccionar un solo registro.')
		}
	}
	
	function btnFinalizarEnviarMovimiento() 
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		var aux = sm.getSelected().data.id_solicitud_salida;
		var cod = sm.getSelected().data.codigo;
		var aprobacion = sm.getSelected().data.requiere_aprobacion;
		
		if(NumSelect==1)
		{
			
			if(confirm("Esta seguro de ejecutar la accion en el movimiento seleccionado ?"))
			{
				cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
			
				cm_getComponente('txt_accion').setValue('finalizar_borrador');
				
				/*if(aux > 0)
				{
					//el movimiento no  se genero de una solicitud o no requiere aprobacion
					
				}*/
				
				if(aprobacion == 'no')
				{
						Ext.MessageBox.show({
							title: 'Procesando...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando codigo...</div>",
							width:300,
							height:200,
							closable:false
						});
						
						Ext.Ajax.request({
							url:direccion+"../../../control/movimiento/ActionGuardarMovimiento.php",
							method:'POST',
							params:{	cantidad_ids:'1'
										,id_movimiento:SelectionsRecord.data.id_movimiento
										,tipo_movimiento:sm.getSelected().data.nombre_tipo
										,aprobacion:sm.getSelected().data.requiere_aprobacion
										,accion_solicitud:'finalizar_borrador'
										,reporte:'si'
									},
							success:esteSuccess,
							failure:cm_conexionFailure,
							timeout:100000000
						});
				}
				else
				{ 
					cm_Save();
				}
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}

	function get_fecha_db(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}  

	function cargar_fecha_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0)
			{
				var fecha = root.getElementsByTagName('fecha')[0].firstChild.nodeValue;	
				cm_getComponente('fecha_movimiento').setValue(fecha);				
			}
		}
	}

	// --- Eventos adicionales de la vista
	cm_getComponente("nombre_tipo").on("select", tipoGenericoSelect, this);

	function tipoGenericoSelect(combo, record, index) {
		var tipo_generico = combo.getValue();
		var cbxIdTipoMovimiento = cm_getComponente("id_tipo_movimiento");
		cbxIdTipoMovimiento.enable();
		cbxIdTipoMovimiento.store.baseParams = {
			filterCol_1 : "tip.tipo",
			filterValue_1 : tipo_generico,
			ingreso_gral:'si'
		};
		cbxIdTipoMovimiento.modificado = true;
	}
	
	iniciarEventosFormularios();
	
	layout_movimiento.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}