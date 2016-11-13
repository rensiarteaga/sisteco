/**
 * Nombre:		  	    pagina_agrupador_rendicion_viaticos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
 */
function pagina_agrupador_rendicion_viaticos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var pagina="";
	var g_sw_contabilizar;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/viatico/ActionListarSolicitudViaticos.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_viatico',totalRecords:'TotalCount'
		},[		
		'id_viatico',		
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_empleado',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'desc_empleado',
		'id_categoria',
		'desc_categoria',		
		'id_moneda',
		'desc_moneda',					
		'id_cuenta_bancaria', 
		'nombre_institucion',
		'nro_cuenta_banco_cuenta_bancaria',
		'desc_cuenta_bancaria',
		'nombre_cheque',
		'estado_viatico',
		{name: 'fecha_solicitud',type:'date',dateFormat:'m-d-Y'},
		'num_solicitud',		
		'detalle_viaticos',
		'motivo_viaje',		
		'detalle_otros',
		'sw_retencion',
		'tipo_pago',
		'id_cheque',
		'id_comprobante',
		'id_caja',
		'desc_caja',
        'id_cajero',
        'desc_cajero',
        'importe_regis',
        'concepto_regis',
        'total_general',
		'sw_contabilizar',
		'tipo_viatico',
		'fk_viatico',
		'observacion',
		{name: 'fecha_inicio',type:'date',dateFormat:'m-d-Y'},
		{name: 'fecha_fin',type:'date',dateFormat:'m-d-Y'},
		'id_depto',
		'nombre_depto',
		'resp_registro',
		
		'id_responsable_rendicion',
		'desc_responsable_rendicion',
		'id_autorizacion',
		'desc_autorizacion',
		'id_aprobacion',
		'desc_aprobacion'		
			
		]),
		baseParams:{filtro_tipo_viatico:'3'},
		remoteSort:true});
		
		//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_viatico:maestro.id_viatico
		}
	});
	
	
	//DATA STORE COMBOS

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])//,
	//baseParams:{m_nombre_vista:'rendicion_viaticos',m_id_uo:1,sw_inv_gasto:'si'}
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado'])
	});

	var ds_usr_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	
	var ds_id_responsable_rendicion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	
	var ds_id_autorizacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	var ds_id_aprobacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	
    var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/categoria/ActionListarCategoria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria'])
	});
    
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?sw_tesoro=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv' ])
	});
	
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','desc_institucion','nro_cuenta_banco'])
	});	
	
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords:- 'TotalCount'},['id_caja','desc_moneda','desc_caja','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:- 'TotalCount'},['id_depto','nombre_depto','codigo_depto','estado'])
	});
    
	//FUNCIONES RENDER
	
		function render_id_unidad_organizacional(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_unidad_organizacional']+ '</span>');}else{return String.format('{0}', record.data['desc_unidad_organizacional']);}}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');

		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B5A642">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',		
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
		
		function render_id_empleado(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_empleado']+ '</span>');}else{return String.format('{0}', record.data['desc_empleado']);}}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

		function render_id_usr_reg(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['resp_registro']+ '</span>');}else{return String.format('{0}', record.data['resp_registro']);}}
		var tpl_id_usr_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_responsable_rendicion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_responsable_rendicion']+ '</span>');}else{return String.format('{0}', record.data['desc_responsable_rendicion']);}}
		var tpl_id_responsable_rendicion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_autorizacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_autorizacion']+ '</span>');}else{return String.format('{0}', record.data['desc_autorizacion']);}}
		var tpl_id_autorizacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_aprobacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_aprobacion']+ '</span>');}else{return String.format('{0}', record.data['desc_aprobacion']);}}
		var tpl_id_aprobacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado
					
		function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
		var tpl_id_categoria=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria}</b></i><br>','</div>');
		
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i><br>','</div>');

		function render_id_concepto_pasaje(value, p, record){return String.format('{0}', record.data['desc_concepto_pasaje']);}
		var tpl_id_concepto_pasaje=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_concepto_viatico(value, p, record){return String.format('{0}', record.data['desc_concepto_viatico']);}
		var tpl_id_concepto_viatico=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i><br>','<FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT>','</div>');
	
		function render_id_caja(value, p, record){if(record.get('id_subsistema')!=''){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_caja']+ '</span>');}else{return String.format('{0}', record.data['desc_caja']);}}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){if(record.get('id_subsistema')!=''){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_cajero']+ '</span>');}else{return String.format('{0}', record.data['desc_cajero']);}}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
			
		function render_num_solicitud(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['num_solicitud']+ '</span>');}else{return String.format('{0}', record.data['num_solicitud']);}}
		//function render_unidad_organizacional(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['num_solicitud']+ '</span>');}else{return String.format('{0}', record.data['num_solicitud']);}}
		
		function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</b></i><br>','</div>');
		
		
	function renderEstado(value, p, record)
	{
		if(value == 0)
		{return "Verificación"}
		if(value == 1)
		{return "Cálculo"}
		if(value == 2)
		//{return "Rendición Registrada"}
		{return "Pago Cheque"}
		if(value == 3)
		{return "Pago Efectivo"}
		if(value == 4)
		{return "Solicitud Contabilizada"}
		if(value == 5)
		{return "Solicitud Validada"}
		if(value == 6)
		{return "Pendiente Rendición"}
		if(value == 7)
		{return "Concluido"}
		
		if(value == 8)
		{return "Descargo"}
		if(value == 9)
		{return "Comprometido"}
		if(value == 10)
		{return "Rendición Contabilizada"}		
		if(value == 11)
		{return "Rendición Validada"}
		
		if(value == 15)
		{return "Finalización Parcial"}
		if(value == 12)
		{return "Finalización Contabilizada"}
		if(value == 13)
		{return "Finalización Validada"}
		if(value == 14)
		{return "Finalización Por Caja"}
		if(value == 16)
		{return "Solicitud Anulada"}
		
		if(value == 17)
		{return "Con Rendición Descargo"}
		if(value == 18)
		{return "Con Rendición Contabilizada"}
		if(value == 19)
		{return "Con Rendición Validada"}
		return 'Otro';
	}
	
	function renderRetencion(value, p, record)
	{
		/*if(value == 1)
		{return "Si"}
		if(value == 2)
		{return "No"}		
		return 'Otro';*/
		
		if(value == 1)
		{return "Con Retención P. Contrato"}
		if(value == 2)
		{return "Sin Retención P. Contrato"}
		if(value == 2)
		{return "Sin Retención P. Planta"}		
		return 'Otro';
	}
	
	function renderTipoPago(value, p, record)
	{
		if(value == 1)
		{return "Cheque"}
		if(value == 2)
		{return "Efectivo"}		
		return 'Otro';
	}
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_viatico
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_viatico',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_viatico'
	};

// txt id_unidad_organizacional
	Atributos[1]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
			typeAhead:true,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:250,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:maestro.id_unidad_organizacional,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',
		save_as:'id_unidad_organizacional',
		id_grupo:4	//3
	};
	
// txt id_empleado
	Atributos[2]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Solicitante',
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:maestro.id_empleado,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_empleado',
		id_grupo:3
	};
	
// txt id_categoria
	Atributos[3]={
			validacion:{
			name:'id_categoria',
			fieldLabel:'Categoría',
			allowBlank:false,			
			//emptyText:'Categoría...',
			desc: 'desc_categoria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria,
			valueField: 'id_categoria',
			displayField: 'desc_categoria',
			queryParam: 'filterValue_0',
			filterCol:'CATEGO.desc_categoria',
			typeAhead:true,
			tpl:tpl_id_categoria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:maestro.id_categoria,
		filterColValue:'CATEGO.desc_categoria',
		save_as:'id_categoria',
		id_grupo:3
	};	
	
// txt id_moneda
	Atributos[4]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			//onSelect:function(record){if(valida_datos()){componentes[9].setValue(record.data.id_moneda);componentes[9].collapse();get_importes();}else{componentes[9].collapse();Ext.MessageBox.alert('Estado', 'Inserte los campos anteriores primero');}},
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:23		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:maestro.id_moneda,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:3
	};
	
	Atributos[5]={
		validacion:{
			name:'tipo_viatico',
			fieldLabel:'Tipo Viático',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'tipo_viatico',
		defecto:3,	//tipo_viatico   =  rendicion
		id_grupo:3		
	};	
	
	Atributos[6]={
		validacion:{
			name:'fk_viatico',
			fieldLabel:'Fk Viático',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'Field',
		form: true,
		defecto:maestro.id_viatico,
		save_as:'fk_viatico',		
		id_grupo:3
	};
	
	
// txt id_cuenta_bancaria
	Atributos[7]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,			
			//emptyText:'Cuenta Bancaria...',
			desc: 'desc_cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#CUEBAN.nro_cuenta_banco',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta_bancaria,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:28		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'INSTIT_0.nombre#CUEBAN_0.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:1		
	};
	
// txt nombre_cheque
	Atributos[8]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre Cheque',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:29		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'CHEQUE.nombre_cheque',
		save_as:'nombre_cheque',
		id_grupo:1
	};	
	
	
	// txt estado_viatico
	Atributos[9]={
		validacion:{
			name:'estado_viatico',
			fieldLabel:'Estado Rendición',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],
											data:[['0','Verificación'],
												  ['1','Cálculo'],
												  ['2','Pago Cheque'],
												  ['3','Pago Efectivo'],
												  ['4','Solicitud Contabilizada'],
												  ['5','Solicitud Validada'],
												  ['6','Pendiente Rendición'],
												  ['7','Concluido'],
												  ['8','Descargo'],
												  ['9','Comprometido'],
												  ['10','Rendición Contabilizada'],
												  ['11','Rendición Validada']
												  ]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:180,
			grid_visible:true,
			grid_indice:3,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,	
		defecto:8,	
		save_as:'estado_viatico',
		filterColValue:'VIATIC.estado_viatico',
		id_grupo:3		
	};	
	
	// txt fecha_rendicion
	Atributos[10]= {
		validacion:{
			name:'fecha_solicitud',
			fieldLabel:'Fecha Rendición',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false//,
			//grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_solicitud',
		dateFormat:'m-d-Y',
		//defecto:'',
		save_as:'fecha_solicitud',
		id_grupo:0
	}; 
	
	// txt numero de rendición
	Atributos[11]={
		validacion:{
			name:'num_solicitud',
			fieldLabel:'Nº de Rendición',
			allowBlank:false,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			renderer:render_num_solicitud,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:1,
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'VIATIC.num_solicitud',
		save_as:'num_solicitud'
	};	
	
	// txt justificacion
	Atributos[12]={
		validacion:{
			name:'detalle_viaticos',
			fieldLabel:'Detalle Viáticos',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:3,
		filtro_0:false,
		filterColValue:'VIATIC.detalle_viaticos',
		save_as:'detalle_viaticos'
	};
	
	// txt justificacion
	Atributos[13]={
		validacion:{
			name:'motivo_viaje',
			fieldLabel:'Concepto', //motivo viaje
			allowBlank:false,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			grid_indice:5,
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:true,
		defecto:maestro.motivo_viaje,
		filterColValue:'VIATIC.motivo_viaje',
		save_as:'motivo_viaje'
	};	
	
	// txt detalle otros
	Atributos[14]={
		validacion:{
			name:'detalle_otros',
			fieldLabel:'Detalle Otros',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:3,
		filtro_0:false,
		filterColValue:'VIATIC.detalle_otros',
		save_as:'detalle_otros'
	};
	
	// txt estado_avance
	Atributos[15]={
		validacion:{
			name:'sw_retencion',
			fieldLabel:'Tipo Retención',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Con Retención P. Contrato'],['2','Sin Retención P. Contrato'],['3','Sin Retención P. Planta']]}), // ['1','Si'],['2','No']
			valueField:'id',
			displayField:'valor',
			renderer: renderRetencion,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:false,
			grid_indice:13,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:3,
		defecto:maestro.sw_retencion,
		filtro_0:false,
		filterColValue:'VIATIC.sw_retencion'		
	};
	
	// txt sw_cheque
	Atributos[16]={
		validacion:{
			name:'tipo_pago',
			fieldLabel:'Tipo de Pago',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Cheque'],['2','Efectivo']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoPago,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:150,
			grid_visible:false,
			grid_indice:27,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:3,
		defecto:maestro.tipo_pago,
		filtro_0:false,
		filterColValue:'VIATIC.tipo_pago'		
	};

	Atributos[17]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};
	
	// txt id_caja
	Atributos[18]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:true,			
			//emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			onSelect:function(record){
				componentes[18].setValue(record.data.id_caja);
				componentes[18].collapse();
				componentes[19].clearValue();
				ds_cajero.baseParams.m_id_caja=record.data.id_caja;
				componentes[19].modificado=true							
			},
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
		save_as:'id_caja',
		id_grupo:2
	};
	
// txt id_cajero
	Atributos[19]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:true,			
			//emptyText:'Cajero...',
			desc: 'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_cajero,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:30		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:2	
	};
	
// txt id_empleado
	Atributos[20]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			//emptyText:'Empleado',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:true,
			grid_indice:31		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'EMPLEA_2.nombre_completo#PROVEE.desc_proveedor',
		save_as:'id_empleado_vale',
		id_grupo:2	
	};
	
// txt importe_regis
	Atributos[21]={
		validacion:{
			name:'importe_regis',
			fieldLabel:'Importe Registro',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'CAJREG.importe_regis',
		save_as:'importe_regis',
		id_grupo:2	
	};
	
	// txt nombre_unidad
	Atributos[22]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Concepto Vale',
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			disabled:true,
			grid_indice:32	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'CAJREG.concepto_regis',
		save_as:'concepto_regis',
		id_grupo:2			
	};
	
	Atributos[23]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'Contabilizar',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'sw_contabilizar',
		id_grupo:3
	};
	
	Atributos[24]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			fieldLabel:'Id Comprobante',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:80
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'VIATIC.id_comprobante',  // con estos campos filtramos en la tabla
		save_as:'id_comprobante'
	};
	
	Atributos[25]={
		validacion:{
			labelSeparator:'',
			name: 'tipo_actualizacion',	//para diferenciar cual de los metaprocesos del modelo seleccionar
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'tipo_actualizacion'
	};
	
	Atributos[26]={
		validacion:{
			labelSeparator:'',
			name: 'total_general',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};		
	
	Atributos[27]={
		validacion:{
			name:'observacion',
			fieldLabel:'Motivo Rechazo Contabilidad',
			allowBlank:true,
			maxLength:400,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:3,		
		save_as:'observacion'
	};
	
	// txt fecha_inicio
	Atributos[28]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicial',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false//,
			//grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio',
		id_grupo:0
	}; 
	
	// txt fecha_fin
	Atributos[29]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Final',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false//,
			//grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin',
		id_grupo:0
	}; 
	
	// txt id_depto
	Atributos[30]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento Tesorería',
			allowBlank:false,			
			//emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			//onSelect:function(record){if(valida_datos()){componentes[9].setValue(record.data.id_moneda);componentes[9].collapse();get_importes();}else{componentes[9].collapse();Ext.MessageBox.alert('Estado', 'Inserte los campos anteriores primero');}},
			width_grid:250,
			width:250,
			disabled:false,
			grid_indice:23		
		},
		tipo:'ComboBox',
		form: true,
		defecto:maestro.id_depto,
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto',
		save_as:'id_depto',
		id_grupo:3
	};
	
	// responsable de registro
	Atributos[31]={
			validacion:{
			name:'id_usr_reg',
			fieldLabel:'Responsable Registro', //Empleado
			allowBlank:true,		
			desc: 'resp_registro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usr_reg,
			valueField: 'id_usr_reg',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre', //busqueda en el formulario
			typeAhead:true,
			tpl:tpl_id_usr_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usr_reg,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false
			//grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre', //busqueda en la tabla		
		id_grupo:3	//grupo oculto
	};
	
	// txt id_empleado
	Atributos[32]={
			validacion:{
			name:'id_responsable_rendicion',
			fieldLabel:'Responsable Rendición', //Empleado
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_responsable_rendicion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_responsable_rendicion,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON3.apellido_paterno#PERSON3.apellido_materno#PERSON3.nombre',
			typeAhead:true,
			tpl:tpl_id_responsable_rendicion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_responsable_rendicion,
			grid_visible:false,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON3.apellido_paterno#PERSON3.apellido_materno#PERSON3.nombre',
		save_as:'id_responsable_rendicion',
		id_grupo:3
	};
	
	// txt id_empleado
	Atributos[33]={
			validacion:{
			name:'id_autorizacion',
			fieldLabel:'Firma Autorización', //Empleado
			allowBlank:true,			
			//emptyText:'Empleado...',
			desc: 'desc_autorizacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_autorizacion,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_autorizacion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_autorizacion,
			grid_visible:false,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'PERSON4.apellido_paterno#PERSON4.apellido_materno#PERSON4.nombre',
		save_as:'id_autorizacion',
		id_grupo:3
	};
	
	// txt id_empleado
	Atributos[34]={
			validacion:{
			name:'id_aprobacion',
			fieldLabel:'Firma Aprobación', //Aprobacion
			allowBlank:true,			
			//emptyText:'Empleado...',
			desc: 'desc_aprobacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_aprobacion,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_aprobacion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_aprobacion,
			grid_visible:false,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'PERSON5.apellido_paterno#PERSON5.apellido_materno#PERSON5.nombre',
		save_as:'id_aprobacion',
		id_grupo:3
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Agrupador Rendición de Viáticos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/agrupador_rendicion_viaticos/rendicion_viaticos.php'};
	var layout_agrupador_rendicion_viaticos=new DocsLayoutMaestroDeatalle(idContenedor);	
	layout_agrupador_rendicion_viaticos.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_agrupador_rendicion_viaticos,idContenedor);
	
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var cm_EnableSelect=this.EnableSelect;
	
	var ClaseMadre_save=this.Save;	
	var CM_saveSuccess=this.saveSuccess;
	var CM_getBoton=this.getBoton;		

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/viatico/ActionEliminarSolicitudViaticos.php'},
		Save:{	url:direccion+'../../../control/viatico/ActionGuardarSolicitudViaticos.php',
				success:miFuncionSuccess	},
		ConfirmSave:{url:direccion+'../../../control/viatico/ActionGuardarSolicitudViaticos.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,columnas:['95%'],
		grupos:[
		{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},		
		{tituloGrupo:'Datos Cheque',columna:0,id_grupo:1},
		{tituloGrupo:'Datos Vale',columna:0,id_grupo:2},
		{tituloGrupo:'Oculto',columna:0,id_grupo:3},	
		{tituloGrupo:'Unidad Organizacional',columna:0,id_grupo:4}		
		],		
		width:'40%',		//	anchura
		height:'50%',		//  altura
		minWidth:150,
		minHeight:200,	
		closable:true,
		abrir_pestana:true,		
		titulo:'Rendición de Viáticos'}};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_viatico=datos.m_id_viatico;
		maestro.desc_empleado=datos.m_desc_empleado;
		maestro.id_categoria=datos.m_id_categoria;
		maestro.desc_categoria=datos.m_desc_categoria;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.desc_moneda=datos.m_desc_moneda;
		
		maestro.id_unidad_organizacional=datos.m_id_unidad_organizacional;
		maestro.id_empleado=datos.m_id_empleado;		
		maestro.sw_retencion=datos.m_sw_retencion;
		maestro.tipo_pago=datos.m_tipo_pago;
		maestro.id_depto=datos.m_id_depto;
		maestro.motivo_viaje=datos.m_motivo_viaje;
		

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_viatico:maestro.id_viatico
			}
		};		
		
		
		
		_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.limpiarStore()
		this.btnActualizar();
		/*var data_maestro=[	['Empleado',maestro.desc_empleado],
							['Categoría',maestro.desc_categoria],
							['Moneda',maestro.desc_moneda]	];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));*/
		
		Atributos[6].defecto=maestro.id_viatico;
		Atributos[1].defecto=maestro.id_unidad_organizacional;
		Atributos[2].defecto=maestro.id_empleado;
		Atributos[3].defecto=maestro.id_categoria;
		Atributos[4].defecto=maestro.id_moneda;
		Atributos[15].defecto=maestro.sw_retencion;
		Atributos[16].defecto=maestro.tipo_pago;
		Atributos[30].defecto=maestro.id_depto;
		Atributos[13].defecto=maestro.motivo_viaje; //concepto de la rendicion
		
		componentes[28].reset();
		componentes[29].reset();				

		paramFunciones.btnEliminar.parametros='&m_id_viatico='+maestro.id_viatico;
		paramFunciones.Save.parametros='&m_id_viatico='+maestro.id_viatico;
		paramFunciones.ConfirmSave.parametros='&m_id_viatico='+maestro.id_viatico;
		this.InitFunciones(paramFunciones)
	};
	

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		g_sw_contabilizar= CM_getComponente('sw_contabilizar');
	 	//g_sw_contabilizar.setVisible(false);
		
		for (var i=0;i<Atributos.length;i++)
		{			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}	

		//componentes[28].on('change',fechas);		//fecha_inicial
		//componentes[29].on('change',fechas);		//fecha_final			

		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )	
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
			datas_edit=rec.data;
			enable(sm,row,rec);	
			_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.reload(rec.data);
			//_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.desbloquearMenu();
				
			if(rec.data['estado_viatico']=='8')  //si el estado del registro seleccionado es descargo
			{
				_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.desbloquearMenu();
			}
			else
			{
				_CP.getPagina(layout_agrupador_rendicion_viaticos.getIdContentHijo()).pagina.bloquearMenu();
			}	
	}	
	
	function SiBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	
	function NoBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++)
		{
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	function miFuncionSuccess(resp)
	{
		if(pagina=="")
		{
			CM_saveSuccess(resp);
		}
		else
		{
			window.open(pagina, "Cheque");
			pagina="";
			CM_saveSuccess(resp);
		}
	}
	
	this.btnNew = function()
	{
		CM_ocultarGrupo('Datos Cheque');
		CM_ocultarGrupo('Datos Vale');
		
		CM_mostrarGrupo('Datos Generales');	
		CM_ocultarGrupo('Oculto');	
		CM_ocultarGrupo('Unidad Organizacional');	
		
		NoBlancosGrupo(0);		
		SiBlancosGrupo(1);		
		SiBlancosGrupo(2);
		SiBlancosGrupo(3);
		
		
		CM_btnNew();
		componentes[5].setValue('3');	//tipo_viatico
		componentes[9].setValue('8');	//estado_viatico				
	}
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(SelectionsRecord.data.estado_viatico==8)
		{
			CM_ocultarGrupo('Datos Cheque');			
			CM_mostrarGrupo('Datos Generales');
			
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Datos Vale');
			CM_mostrarGrupo('Unidad Organizacional');
			
			/*CM_mostrarGrupo('Datos Cheque');			
			CM_mostrarGrupo('Datos Generales');
			
			CM_mostrarGrupo('Oculto');
			CM_mostrarGrupo('Datos Vale');*/
			
			NoBlancosGrupo(0);	
			SiBlancosGrupo(1);					
			SiBlancosGrupo(2);
			
			componentes[25].setValue('1');	//tipo_actualizacion
			componentes[5].setValue(3);	//tipo_viatico
			componentes[9].setValue(8);	//estado_viatico
			CM_btnEdit();
		}
		else
		{
			 Ext.MessageBox.alert('Estado','Solo viáticos en estado DESCARGO pueden ser editados')
		}			
	}
	
	this.btnEliminar = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(SelectionsRecord.data.estado_viatico==8)
		{
			CM_btnEliminar();
		}
		else
		{
			Ext.MessageBox.alert('Estado','Solo rendiciones en estado DESCARGO pueden ser eliminados');
		}
	}
		
	function btn_reporte_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		//alert (SelectionsRecord.data.id_fina_regi_prog_proy_acti);
		if(NumSelect!=0)
		{
			
			var data='&id_viatico='+SelectionsRecord.data.id_viatico;		   	   			   	   
			    data=data+'&tipo_vista=viatico';	
			  //  alert (data);   	   			   	   
			    window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)	
			//window.open(direccion+'../../../control/_reportes/viatico/ActionReporteRendicionViatico.php?'+data)	
		   // window.open(direccion+'../../../control/_reportes/viatico/ActionReporteRendicionViatico.php?'+data)				
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}	
	
	function btn_comprometer()
	{			
		var sm=getSelectionModel(), NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			if(componentes[9].getValue()==8)	//estado viatico = DESCARGO
			{
				var sm=getSelectionModel();
				id_vale =sm.getSelected().data.id_caja_regis;
				cargar_respuesta();						
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo rendiciones en estado DESCARGO pueden ser comprometidos.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar un registro.')
		}		
	}
		
	function cargar_respuesta()
	{				
		var mensaje='¿Está seguro de comprometer la rendición?';
			
		if(confirm(mensaje))
		{
			componentes[25].setValue(3);	//tipo_actualizacion = 
			componentes[9].setValue(9);	//Estado viatico = cerrado	
			
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);			
			
			ClaseMadre_save();
			//alert("llega despues");	
			//CM_btnEdit();		
		}			
	}
	
	function btn_contabilizar()
	{		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
			if(componentes[9].getValue()==9)	//estado viatico = Comprometido
			{			
				if(SelectionsRecord.data.id_comprobante!='')
				{		
					Ext.MessageBox.alert('Atención','La rendición seleccionada ya esta contabilizada.')			
				}
				else
				{	
					var sw=false;
					if(confirm('Esta seguro de contabilizar la rendición?'))
							{sw=true}
					if(sw){				
						g_sw_contabilizar.setValue('2');//Para contabilizar las rendiciones	
						componentes[9].setValue(10);	//Estado viatico = Solicitud Contabilizada
						ClaseMadre_save();
						//CM_btnEdit();
						g_sw_contabilizar.setValue('0');
					}	
				}	
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo rendiciones en estado COMPROMETIDO pueden ser contabilizadas.');	
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar una rendición.')
	    }	
	}
	
	/*function btn_imprime_cheque()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			if(componentes[9].getValue()==5)	//estado viatico = Solicitud Validada
			{	
			    var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;   	   			   	   
			    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data)				
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado SOLICITUD VALIDADA pueden imprimir cheques.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}*/
	
	/*function btn_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			if(componentes[9].getValue()==6)	//estado viatico = Pendiente de rendicion
			{			
				var data='m_id_viatico='+SelectionsRecord.data.id_viatico;
				data=data+'&m_desc_empleado='+SelectionsRecord.data.desc_empleado;
				data=data+'&m_id_categoria='+SelectionsRecord.data.id_categoria;
				data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
	
				var ParamVentana={Ventana:{width:'80%',height:'80%'}}
				layout_agrupador_rendicion_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/agrupador_rendicion_viaticos/agrupador_rendicion_viaticos.php?'+data,'Rendición de Viáticos',ParamVentana);
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado PENDIENTE RENDICION pueden tener rendiciones.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}*/
	
	/*function btn_ampliacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			if(componentes[9].getValue()==6)	//estado viatico = Pendiente de rendicion
			{		
				var data='m_id_viatico='+SelectionsRecord.data.id_viatico;
				data=data+'&m_desc_empleado='+SelectionsRecord.data.desc_empleado;
				data=data+'&m_id_categoria='+SelectionsRecord.data.id_categoria;
				data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
	
				var ParamVentana={Ventana:{width:'80%',height:'80%'}}
				layout_agrupador_rendicion_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/ampliacion_viaticos/ampliacion_viaticos.php?'+data,'Ampliación de Viáticos',ParamVentana);
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado PENDIENTE RENDICION pueden tener ampliaciones.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.'); 
		}
	}	*/
	
	

	/*function fechas()
	{
		if((componentes[28].getValue()=='' || componentes[28].getValue()==undefined)||(componentes[29].getValue()=='' || componentes[29].getValue()==undefined))
		{
			//componentes[28].maxValue=componentes[29].getValue();		//fecha inicial
			componentes[29].minValue=componentes[28].getValue();		//fecha final
		}
		else
		{
			//componentes[28].maxValue=componentes[29].getValue();		//fecha inicial
			componentes[29].minValue=componentes[28].getValue();		//fecha final						
		}				
	}*/
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_agrupador_rendicion_viaticos.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	var CM_getBoton=this.getBoton;	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Comprometer Rendición',btn_comprometer,true,'comprometer','Comprometer'); //tucrem
	this.AdicionarBoton("../../../lib/imagenes/det.ico",'Contabilizar Rendición',btn_contabilizar,true, 'contabilizar','Contabilizar');	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir la rendición de viáticos',btn_reporte_rendicion,true,'reporte_rendicion','Rendición');
	
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('comprometer-'+idContenedor).disable();
	CM_getBoton('contabilizar-'+idContenedor).disable();
	CM_getBoton('reporte_rendicion-'+idContenedor).disable();
		
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data['estado_viatico']=='8')//descargo
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('comprometer-'+idContenedor).enable();
			CM_getBoton('contabilizar-'+idContenedor).disable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();							
		}
		if(rec.data['estado_viatico']=='9')//comprometido
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('comprometer-'+idContenedor).disable();
			CM_getBoton('contabilizar-'+idContenedor).enable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();							
		}
		if(rec.data['estado_viatico']=='10')//rendicion contabilizada
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('comprometer-'+idContenedor).disable();
			CM_getBoton('contabilizar-'+idContenedor).disable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();							
		}
		if(rec.data['estado_viatico']=='11')//rendicion validada
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('comprometer-'+idContenedor).disable();
			CM_getBoton('contabilizar-'+idContenedor).disable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();							
		}		
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_agrupador_rendicion_viaticos.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}