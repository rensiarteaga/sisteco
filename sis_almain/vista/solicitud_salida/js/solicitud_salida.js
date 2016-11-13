/**
 * Nombre: solicitud_salida.js Autor: Ariel Ayaviri Omonte
 * 									  Ruddy Lujan Bravo 
 * Fecha creacion: 26-07-2013
 * Fecha  mod: 02.10.2013
 */

function PaginaSolicitudSalida(idContenedor, direccion, paramConfig,sol_estado) {
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_solicitud_salida;
	var idAlmacen;
	// DATA STORE //
	ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion+ '../../../control/solicitud_salida/ActionListarSolicitudSalida.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_solicitud_salida',
					totalRecords : 'TotalCount'
				}, [ 'id_solicitud_salida', 'id_almacen',
						'id_unidad_organizacional', 'uo_empleado',
						'id_empleado', 'nombre_empleado', 'cargo_empleado',
						'id_aprobador', 'uo_aprobador', 'nombre_aprobador',
						'cargo_empleado', 'id_aprobador', 'uo_aprobador',
						'nombre_aprobador', 'descripcion', 'estado',
						'usuario_reg', 'codigo',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						}, {
							name : 'fecha_solicitud',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
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
			url : direccion+ '../../../control/almacen/ActionListarAlmacen.php'}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_almacen',
			totalRecords : 'TotalCount'
		}, [ 'id_almacen', 'codigo', 'nombre' ])
	});

	var TaskLocation = Ext.data.Record.create([ {name : "id_almacen"}, {name : "codigo"}, {name : "nombre"} ]);
	
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
		valueField : 'id_almacen'});
	
	cbxSisAlma.on('select', function(combo, record, index) {
		cm_DesbloquearMenu();
		idAlmacen = cbxSisAlma.getValue();
		ds.baseParams.id_almacen = idAlmacen;
		cm_btnActualizar();
		combo.modificado = true;
	});

	// PARAMETRO DEL FORMULARIO Y EL GRID
	vectorAtributos = [
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
				validacion:{
					fieldLabel: 'Identificador',
					name: 'id_solicitud_salida',
					grid_visible:true, // se muestra en el grid
					grid_editable:false,
					align:'center',
					grid_indice:1
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'sol.id_solicitud_salida',
			form:false
		},
		{
			validacion : {
				name : 'estado',
				fieldLabel : 'Etapa',
				grid_visible : true,
				align:'center',
				grid_editable : false,
				width_grid : 130,
				renderer : renderEstado
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'sol.estado',
			form : false
		},
		{
			validacion : {
				name : 'codigo',
				fieldLabel : 'Num. Documento',
				allowBlank : true,
				typeAhead : true,
				loadMask : true,
				triggerAction : 'all',
				valueField : 'valor',
				displayField : 'valor',
				align : 'center',
				lazyRender : true,
				grid_visible : true,
				grid_editable : false,
				forceSelection : false,
				width_grid : 200,
				width : 285
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'sol.codigo',
			filtro_1 : false,
			form : false,
			save_as : 'txt_codigo'
		}
		,
			{
				validacion : {
					labelSeparator : '',
					name : 'id_almacen',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				defecto : 1,
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_almacen'
			},
			{
				validacion : {
					name : 'id_unidad_organizacional',
					fieldLabel : 'Unidad Organizacional',
					allowBlank : true,
					emptyText : 'Unidad Organizacional...',
					desc : 'uo_empleado',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_documento',
									totalRecords : 'TotalCount'
								}, [ 'id_unidad_organizacional',
										'nombre_unidad' ])
							}),
					valueField : 'id_unidad_organizacional',
					displayField : 'nombre_unidad',
					queryParam : 'filterValue_0',
					filterCol : 'uniorg.nombre_unidad',
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
					width_grid : 200
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'hidden_id_unidad_organizacional'
			},
			{
				validacion : {
					name : 'uo_empleado',
					fieldLabel : 'Unidad Organizacional',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 280
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'uo.nombre_unidad',
				form : false
			},
			{
				validacion : {
					name : 'id_empleado',
					fieldLabel : 'Empleado',
					//allowBlank : false,
					allowBlank : true,
					emptyText : 'Empleado...',
					desc : 'nombre_empleado',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_empleado',
									totalRecords : 'TotalCount'
								}, [ 'id_empleado', 'desc_persona' ])
							}),
					valueField : 'id_empleado',
					displayField : 'desc_persona',
					queryParam : 'filterValue_0',
					filterCol : 'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
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
				save_as : 'hidden_id_empleado'
			},
			{
				validacion : {
					name : 'nombre_empleado',
					fieldLabel : 'Solicitante',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'peremp.nombre#peremp.apellido_paterno#peremp.apellido_materno',
				form : false
			},
			{
				validacion : {
					name : 'cargo_empleado',
					fieldLabel : 'Cargo Solicitante',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'sol.cargo_empleado',
				form : false
			},
			{
				validacion : {
					name : 'id_aprobador',
					fieldLabel : 'Aprobador',
					allowBlank : true,
					emptyText : 'Aprobador...',
					desc : 'nombre_aprobador',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_parametros/control/config_aprobador/ActionListarConfigAprobador.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_config_aprobador',
									totalRecords : 'TotalCount'
								}, [ 'id_config_aprobador', 'id_empleado',
										'nombre_completo' ])
							}),
					valueField : 'id_config_aprobador',
					displayField : 'nombre_completo',
					queryParam : 'filterValue_0',
					filterCol : 'EMPLEA.nombre_completo',
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
				save_as : 'hidden_id_aprobador'
			},
			{
				validacion : {
					name : 'nombre_aprobador',
					fieldLabel : 'Aprobador',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'peremp2.nombre#peremp2.apellido_paterno#peremp2.apellido_materno',
				form : false
			},
			{
				validacion : {
					name : 'uo_aprobador',
					fieldLabel : 'U.O. Aprobador',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'uo2.nombre_unidad',
				form : false
			},
			{

				validacion : {
					name : 'fecha_solicitud',
					fieldLabel : 'Fecha Solicitud',
					allowBlank : false,
					format : 'd/m/Y',
					minValue : '01/01/1900',
					disabledDaysText : 'DÃ­a no vÃ¡lido',
					grid_visible : true,
					grid_editable : false,
					renderer : formatDate,
					width_grid : 150,
					disabled : false,
					align : 'center',
					width : '50%'
				},
				form : true,
				tipo : 'DateField',
				filtro_0 : true,
				filterColValue : 'sol.fecha_solicitud',
				dateFormat : 'm-d-Y',
				save_as : 'txt_fecha_solicitud'
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : false,
					typeAhead : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'sol.descripcion',
				form : true,
				save_as : 'txt_descripcion'
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
				filterColValue : 'sol.usuario_reg',
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
					width_grid : 150
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'sol.fecha_reg',
				dateFormat : 'm-d-Y'
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
		titulo_maestro : 'solicitud salida',
		grid_maestro : 'grid-' + idContenedor,
		urlHijo : '../../../sis_almain/vista/detalle_solicitud/detalle_solicitud.php'
	};
	layout_solicitud_salida = new DocsLayoutMaestroDeatalle(idContenedor);
	layout_solicitud_salida.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_solicitud_salida,
			idContenedor);
	var cm_EnableSelect = this.EnableSelect;
	var cm_DeselectRow = this.DeselectRow;
	var cm_getSelectionModel = this.getSelectionModel;
	var cm_conexionFailure = this.conexionFailure;
	var cm_eliminarSuccess = this.eliminarSucess;
	var cm_btnActualizar = this.btnActualizar;
	var cm_btnNew = this.btnNew;
	var cm_getcomponente = this.getComponente;
	var cm_btnEliminar = this.btnEliminar;
	var cm_Save=this.Save;
	var cm_getBoton = this.getBoton;

	
	
	ds_almacen.on('load', function(store, records, options) {
		ds_almacen.commitChanges();}, this);
	ds.baseParams.id_almacen = idAlmacen;
	
	if ( sol_estado != '')
	{
		ds.baseParams.estado_solicitud = sol_estado;
	}

	this.btnNew = function() 
	{
		cm_btnNew();
		cm_getComponente('id_almacen').setValue(idAlmacen);
		
		cm_getComponente('txt_accion').setValue('');
		
	}
	
	this.EnableSelect = function(selEvent, rowIndex, selectedRow) 
	{
		cm_EnableSelect(selEvent, rowIndex, selectedRow);
		
		//var btnEnviarSolicitud = cm_getBoton('EnviarSolicitud-' + idContenedor);
		//btnEnviarSolicitud.enable();
		
		if (sol_estado == 'borrador')
		{
			
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
			.reload(selectedRow.data);
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
					.desbloquearMenu();
			
			cm_DesbloquearMenu();
		}
		else if(sol_estado == 'pendiente_aprobacion' || sol_estado == 'proceso_entrega' || sol_estado == 'entregado')
		{
			
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
			.reload(selectedRow.data);
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
					.desbloquearMenu();
			
			cm_DesbloquearMenu();
		}

		/*else if(sol_estado == 'proceso_entrega')
		{
			
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
			.reload(selectedRow.data);
			_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
					.desbloquearMenu();
			
			cm_DesbloquearMenu();
		
		}*/
		//deshabilitar el boton procesar_entrega para que no se creen varios movimientos
		if (selectedRow.data.estado == "proceso_entrega")
		{
			cm_getBoton('procesar_entrega-' + idContenedor).disable();
		}
	}

	this.DeselectRow = function(n, n1) {
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
				.limpiarStore();
		_CP.getPagina(layout_solicitud_salida.getIdContentHijo()).pagina
				.bloquearMenu();
	};
	// ----------- DEFINICIÃ“N DE LA BARRA DE MENÃš ----------- //
	if(sol_estado == 'borrador')
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
	else if(sol_estado == 'pendiente_aprobacion' || sol_estado == 'proceso_entrega' || sol_estado == 'entregado' )
	{
		var paramMenu = {
				actualizar : {
					crear : true,
					separador : false
				}
			};
	}
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	}
	;
	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'pendiente_aprobacion') {
			estado = 'Pendiente aprobacion';
		} else if (record.data['estado'] == 'borrador') {
			estado = 'Borrador';
		} else if (record.data['estado'] == 'pendiente_entrega') {
			estado = 'Pendiente entrega';
		} else if (record.data['estado'] == 'entregado') {
			estado = 'Entregado';
		} else if (record.data['estado'] == 'proceso_entrega') {
			estado = 'Proceso entrega';
		}
		return String.format('{0}', estado);
	}
	// ---------------------- DEFINICIÃ“N DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/solicitud_salida/ActionEliminarSolicitudSalida.php"
		},
		Save : {
			url : direccion
					+ "../../../control/solicitud_salida/ActionGuardarSolicitudSalida.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/solicitud_salida/ActionGuardarSolicitudSalida.php"
		},
		Formulario : {
			titulo : 'Solicitud de Salida',
			html_apply : "dlgInfo-" + idContenedor,
			width : 470,
			height : 350,
			columnas : [ '95%' ],
			closable : true
		}
	};

	// -------------- FIN DEFINICION DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	var cm_getComponente = this.getComponente;
	
	cm_BloquearMenu();
	this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');

	// Botones adicionales en el menu
	if (sol_estado == "borrador")
	{
			// Botones adicionales en el menu
		this.AdicionarBoton('../../../lib/imagenes/ok.png','Enviar Solicitud', btnEnviarSolicitud, false,'EnviarSolicitud', 'Enviar Solicitud');
		cm_getBoton('EnviarSolicitud-' + idContenedor).disable();
	}
	else if (sol_estado == "pendiente_aprobacion")
	{
		this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Correccion',btn_correccion,false,'corregir_solicitud','Correccion');
		this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Solicitud',btn_aprobacion,false,'aprobar_solicitud','Aprobacion');
		cm_getBoton('corregir_solicitud-' + idContenedor).disable();
		cm_getBoton('aprobar_solicitud-' + idContenedor).disable();
	}
	else if (sol_estado == 'proceso_entrega')
	{
		this.AdicionarBoton('../../../lib/imagenes/ok.png','Procesar Solicitud',btn_procesar_entrega,false,'procesar_entrega','Procesar Solicitud');
		//this.AdicionarBoton('../../../lib/imagenes/report.png','Movimientos Finalizados',btn_reporte_solic,true,'reportePDF','ReportePDF');
		
		cm_getBoton('procesar_entrega-' + idContenedor).disable();
		//cm_getBoton('reportePDF-' + idContenedor).disable();
	}
	else if (sol_estado == 'entregado')
	{
		this.AdicionarBoton('../../../lib/imagenes/report.png','Movimientos Finalizados',btn_reporte_solic,true,'reportePDF','ReportePDF');
		cm_getBoton('reportePDF-' + idContenedor).disable();
	}
	
	
	function esteSuccess(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			btn_reporte_solic();
			cm_btnActualizar();
		}
		else
		{
			cm_conexionFailure();
		}
	}
	
	
	//reporte
	function btn_reporte_solic()
	{
		var sm=cm_getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect == 1)
		{
			var data='m_id_solicitud='+SelectionsRecord.data.id_solicitud_salida;
			//data = data +'&id_solicitud_salida='+ SelectionsRecord.data.id_solicitud_salida;
			window.open(direccion+'../../../../sis_almain/control/_reportes/solicitud_salida/ActionPDFSolicitudSalida.php?tipo_reporte=pdf&'+data);
		} 
		else
		{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		}
	}
	
	function btn_procesar_entrega()
	{
		var sm=cm_getSelectionModel(); 
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en la solicitud seleccionada ?"))
			{	
				cm_getComponente('txt_accion').setValue('procesar_solicitud');
				
				cm_Save();
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	
	
	function btn_correccion()
	{
		var sm=cm_getSelectionModel(); 
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en la solicitud seleccionada ?"))
			{
				//cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				//cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
			
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
			
			if(confirm("Esta seguro de ejecutar la accion en la solicitud seleccionada ?"))
			{					
				cm_getComponente('txt_accion').setValue('finalizar_pendiente');
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando codigo solicitud...</div>",
					width:300,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/solicitud_salida/ActionGuardarSolicitudSalida.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_solicitud_salida:SelectionsRecord.data.id_solicitud_salida
								,accion_solicitud:'finalizar_pendiente'
								,reporte:'si'
							},
					success:esteSuccess,
					failure:cm_conexionFailure,
					timeout:100000000
				});
				
				/*cm_Save();
				
				btn_reporte_solic();
				cm_btnActualizar(); */
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Debe seleccionar un solo registro.')
		}
	}
	
	function btnEnviarSolicitud() 
	{
		var sm=cm_getSelectionModel(); 
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de ejecutar la accion en la solicitud seleccionada ?"))
			{
				//cm_getComponente('txt_tipo_movimiento').setValue(sm.getSelected().data.nombre_tipo);
				//cm_getComponente('txt_aprobacion').setValue(sm.getSelected().data.requiere_aprobacion);
			
				cm_getComponente('txt_accion').setValue('finalizar_borrador');
				
				cm_Save();
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}

	layout_solicitud_salida.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}