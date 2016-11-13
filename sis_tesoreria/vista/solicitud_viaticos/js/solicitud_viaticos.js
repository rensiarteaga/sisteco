/**
 * Nombre:		  	    pagina_solicitud_viaticos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
 */
function pagina_solicitud_viaticos(idContenedor,direccion,paramConfig)
{
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
		'id_presupuesto',
		'desc_presupuesto',
		
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
        'obs_viatico',
		'sw_contabilizar',
		'tipo_viatico',
		'fk_viatico',
		'observacion',
		'saldo_viatico',
		'numero_deposito',
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
		baseParams:{filtro_tipo_viatico:'1',filtro_tipo_vista:'1'},
		remoteSort:true});

	
	//DATA STORE COMBOS

    /*var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg']),
			baseParams:{m_sw_presupuesto:'si'}
	});*/
	
	/*var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo'])
	});	*/
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])//,
	//baseParams:{m_nombre_vista:'rendicion_viaticos',m_id_uo:1,sw_inv_gasto:'si'}
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
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
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}  //Para mostrar solamente las moneda de Bolivianos y Dolares
	});    
	
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','desc_institucion','nro_cuenta_banco'])
	});	
	
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords:- 'TotalCount'},['id_caja','desc_moneda','desc_caja','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado']),
			baseParams:{estado:'3'}
    });
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:- 'TotalCount'},['id_depto','nombre_depto','codigo_depto','estado'])
	});
    
	//FUNCIONES RENDER
	
		/*function render_id_unidad_organizacional(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_unidad_organizacional']+ '</span>');}else{return String.format('{0}', record.data['desc_unidad_organizacional']);}}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</b></i>','</div>');
*/
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
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_responsable_rendicion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_responsable_rendicion']+ '</span>');}else{return String.format('{0}', record.data['desc_responsable_rendicion']);}}
		var tpl_id_responsable_rendicion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_autorizacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_autorizacion']+ '</span>');}else{return String.format('{0}', record.data['desc_autorizacion']);}}
		var tpl_id_autorizacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		function render_id_aprobacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_aprobacion']+ '</span>');}else{return String.format('{0}', record.data['desc_aprobacion']);}}
		var tpl_id_aprobacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado
		
		function render_id_usr_reg(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['resp_registro']+ '</span>');}else{return String.format('{0}', record.data['resp_registro']);}}
		var tpl_id_usr_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado
		
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
		if(value == 1)
		{return "Con Retención, Personal Contrato"}
		if(value == 2)
		{return "Sin Retención, Personal Contrato"}
		if(value == 3)
		{return "Sin Retención, Personal Planta"}		
		return 'Otro';		
	}
	
	function renderTipoPago(value, p, record)
	{
		if(value == 1)
		{return "Cheque"}
		if(value == 2)
		{return "Efectivo"}	
		if(value == 3)
		{return "Sin Pago - Sin Rendición"}	
		if(value == 4)
		{return "Sin Pago - Con Rendición"}	
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

	Atributos[1]={		//28
		validacion:{
			name:'saldo_viatico',
			fieldLabel:'Saldo Viático',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:true,
			//minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,	
		id_grupo:4,
		filterColValue:'saldo_viatico'		
	};
		
// txt id_empleado
	Atributos[2]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Solicitante', //Empleado
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
			width_grid:220,
			width:250,
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_empleado',
		id_grupo:1
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
			width:250,
			disabled:false,
			grid_indice:9		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.desc_categoria',
		save_as:'id_categoria',
		id_grupo:1
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
			width:250,
			disabled:false,
			grid_indice:23		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1
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
		id_grupo:4		
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
		save_as:'fk_viatico',		
		id_grupo:4
	};
	
	
// txt id_cuenta_bancaria
	Atributos[7]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
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
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false,
			grid_indice:28		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre#CUEBAN.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:2		
	};
	
// txt nombre_cheque
	Atributos[8]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre Cheque',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:29		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CHEQUE.nombre_cheque',
		save_as:'nombre_cheque',
		id_grupo:2
	};	
	
	
	// txt estado_avance
	Atributos[9]={
		validacion:{
			name:'estado_viatico',
			fieldLabel:'Estado Viático',
			allowBlank:false,
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
												  ['11','Rendición Validada'],
												  ['15','Finalización Parcial'],
												  ['12','Finalización Contabilizada'],
												  ['13','Finalización Validada'],
												  ['14','Finalización por Caja'],
												  ['16','Solicitud Anulada'],
												  ['17','Con Rendición Descargo'],
												  ['18','Con Rendición Contabilizada'],
												  ['19','Con Rendición Validada']
												  
												  ]}),		
		
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_indice:3,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,			
		//save_as:'estado_viatico',
		id_grupo:4,//3
		filterColValue:'VIATIC.estado_viatico'		
	};	
	
	// txt fecha_solicitud
	Atributos[10]= {
		validacion:{
			name:'fecha_solicitud',
			fieldLabel:'Fecha Solicitud',
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
		defecto:'',
		save_as:'fecha_solicitud',
		id_grupo:1
	}; 
	
	// txt justificacion
	Atributos[11]={
		validacion:{
			name:'num_solicitud',
			fieldLabel:'Nº de Solicitud',
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
		id_grupo:1,
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
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:4,
		filtro_0:true,
		filterColValue:'VIATIC.detalle_viaticos',
		save_as:'detalle_viaticos'
	};
	
	// txt justificacion
	Atributos[13]={
		validacion:{
			name:'motivo_viaje',
			fieldLabel:'Motivo del Viaje',
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
		id_grupo:1,
		filtro_0:true,
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
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:4,
		filtro_0:false,
		filterColValue:'VIATIC.detalle_otros',
		save_as:'detalle_otros'
	};	
	
	// txt tipo de pago
	Atributos[15]={
		validacion:{
			name:'tipo_pago',
			fieldLabel:'Tipo de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Cheque'],['2','Efectivo'],['3','Sin Pago - Sin Rendición'],['4','Sin Pago - Con Rendición']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoPago,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:180,
			grid_visible:true,
			grid_indice:27,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:1,
		filtro_0:false,
		filterColValue:'VIATIC.tipo_pago'		
	};
	
	// txt estado_avance
	Atributos[16]={
		validacion:{
			name:'sw_retencion',
			fieldLabel:'Tipo Retención',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Con Retención, Personal Contrato'],['2','Sin Retención, Personal Contrato'],['3','Sin Retención, Personal Planta']]}), // ['1','Si'],['2','No']
			valueField:'id',
			displayField:'valor',
			renderer: renderRetencion,
			lazyRender:true,
			forceSelection:true,
			width_grid:170,
			width:250,
			grid_visible:true,
			grid_indice:13,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:1,
		filtro_0:false,
		filterColValue:'VIATIC.sw_retencion'		
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
			width_grid:150,
			width:250,
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
		save_as:'id_caja',
		id_grupo:3
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
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			width:250,
			disabled:false,
			grid_indice:30		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:3	
	};
	
// txt id_empleado
	Atributos[20]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			//emptyText:'Empleado...',
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
			width:250,
			disabled:true,
			grid_indice:31		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_2.nombre_completo#PROVEE.desc_proveedor',
		save_as:'id_empleado_vale',
		id_grupo:4//3	
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
		filtro_0:true,
		filterColValue:'CAJREG.importe_regis',
		save_as:'importe_regis',
		id_grupo:4//3	
	};
	
	// txt nombre_unidad
	Atributos[22]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Concepto Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:true,
			grid_indice:32	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis',
		save_as:'concepto_regis',
		id_grupo:4//3			
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
		id_grupo:4
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
	
		/*if($tipo_actualizacion == 1)	
		{			$this->codigo_procedimiento = "'TS_SOLVIA_UPD'";		}	
		else if($tipo_actualizacion == 2)
		{			$this->codigo_procedimiento = "'TS_CHEVIA_UPD'"; 		}
		else if($tipo_actualizacion == 3)
		{			$this->codigo_procedimiento = "'TS_VIAFIN_UPD'"; 		}
		else if($tipo_actualizacion == 4)
		{			$this->codigo_procedimiento = "'TS_VALVIA_UPD'"; 		}
		else if($tipo_actualizacion == 5)
		{			$this->codigo_procedimiento = "'TS_CONCLUIRVIA_UPD'"; 		}
		*/	
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
			name:'obs_viatico',
			fieldLabel:'Observaciones',
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
		id_grupo:1,		
		save_as:'obs_viatico'
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
		id_grupo:4,		
		save_as:'observacion'
	};
	
	Atributos[28]={		//29
		validacion:{
			name:'numero_deposito',
			fieldLabel:'Número Depósito',
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
		save_as:'numero_deposito',		
		id_grupo:5		
	};	
	
	// txt id_depto
	Atributos[29]={		//30
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
			filterCol:'DEPTO.nombre_depto',		//para buscar en el formulario
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
			width_grid:200,
			width:250,
			disabled:false,
			grid_indice:23		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto',	//para buscar en la grilla
		save_as:'id_depto',
		id_grupo:0
	};
	
	// txt id_unidad_organizacional
	Atributos[30]={		//1
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,	
			desc:'desc_unidad_organizacional', //que es lo que se muestra en la grilla
			store:ds_presupuesto,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',		//que es lo que se muestra en el formulario
			queryParam:'filterValue_0',
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
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',
		save_as:'id_unidad_organizacional',
		id_grupo:0
	};
	
	Atributos[31]={		//1
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,	
			desc:'desc_presupuesto', //que es lo que se muestra en la grilla
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',		//que es lo que se muestra en el formulario
			queryParam:'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad', //con estos campos filtramos en el formulario
			typeAhead:false,
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
			grid_visible:false,
			grid_editable:false,
			width_grid:300,
			width:250,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',  // cone estos campos filtramos en la grilla
		save_as:'id_presupuesto',
		id_grupo:4
	};	
	
	// responsable de registro
	Atributos[32]={
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
		id_grupo:4	//grupo oculto
	};
	
	// txt id_empleado
	Atributos[33]={
			validacion:{
			name:'id_responsable_rendicion',
			fieldLabel:'Responsable Rendición', //Empleado
			allowBlank:true,			
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
			grid_visible:true,
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
		id_grupo:6
	};
	
	// txt id_empleado
	Atributos[34]={
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
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON4.apellido_paterno#PERSON4.apellido_materno#PERSON4.nombre',
		save_as:'id_autorizacion',
		id_grupo:1
	};
	
	// txt id_empleado
	Atributos[35]={
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
		id_grupo:4
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={titulo_maestro:'Solicitud de Viáticos',grid_maestro:'grid-'+idContenedor};
	var layout_solicitud_viaticos=new DocsLayoutMaestro(idContenedor);
	layout_solicitud_viaticos.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_viaticos,idContenedor);
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
		{tituloGrupo:'Departamento',columna:0,id_grupo:0},
		{tituloGrupo:'Datos Generales',columna:0,id_grupo:1},		
		{tituloGrupo:'Datos Cheque',columna:0,id_grupo:2},
		{tituloGrupo:'Datos Vale',columna:0,id_grupo:3},
		{tituloGrupo:'Oculto',columna:0,id_grupo:4},
		{tituloGrupo:'Depósito',columna:0,id_grupo:5},
		{tituloGrupo:'Asignar Responsable Rendición',columna:0,id_grupo:6}		
		],
		height:'80%',	//altura	
		width:'50%',	//anchura	
		minWidth:150,
		minHeight:200,	
		closable:true,
		abrir_pestana:true,		
		titulo:'Solicitud de Viáticos'}};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		g_sw_contabilizar= CM_getComponente('sw_contabilizar');
		g_tipo_viatico= CM_getComponente('tipo_viatico');
		g_estado_viatico= CM_getComponente('estado_viatico');
		
		for (var i=0;i<Atributos.length;i++)
		{			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}

		componentes[29].on('select',evento_departamento);   //cuando selecciono un departamento salta el evento
		componentes[30].on('select',evento_unidad_organizacional);   //cuando selecciono un departamento salta el evento		
	}	
	
	function evento_departamento( combo, record, index )
	{	
		//filtramos las UOs por departamento y por EP	
		componentes[30].reset();
		componentes[31].reset();
		componentes[30].store.baseParams={sw_inv_gasto:'si',id_depto:record.data.id_depto};			//,id_parametro:record.data.id_parametro
		componentes[30].modificado=true;										
 	}
 	
 	function evento_unidad_organizacional( combo, record, index )
	{	
		//filtramos las UOs por departamento y por EP	
		//componentes[31].reset();
		//componentes[31].store.baseParams={m_nombre_vista:'rendicion_viaticos',m_id_uo:record.data.id_unidad_organizacional,sw_inv_gasto:'si'};		
		componentes[31].modificado=true;

		componentes[31].setValue(record.data.id_presupuesto);	
 	}
	
	this.EnableSelect=function(sm,row,rec)
	{
			datas_edit=rec.data;
			enable(sm,row,rec);			
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
		for (var i=0;i<componentes.length;i++){
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
		CM_mostrarGrupo('Departamento');	
		CM_mostrarGrupo('Datos Generales');	
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Depósito');
		CM_ocultarGrupo('Asignar Responsable Rendición');

		componentes[20].enable();										//a orden de 	
		
		NoBlancosGrupo(0);
		NoBlancosGrupo(1);		
		SiBlancosGrupo(2);		
		SiBlancosGrupo(3);
		SiBlancosGrupo(4);		
		
		CM_btnNew();
		componentes[5].setValue('1');	//tipo_viatico		
		componentes[9].setValue('0');	//estado_viatico				
	}
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{		
			if(SelectionsRecord.data.estado_viatico==0 || SelectionsRecord.data.estado_viatico==1)
			{
				CM_ocultarGrupo('Datos Cheque');
				CM_mostrarGrupo('Departamento');			
				CM_mostrarGrupo('Datos Generales');			
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Datos Vale');
				CM_ocultarGrupo('Depósito');
				CM_ocultarGrupo('Asignar Responsable Rendición');
				
				NoBlancosGrupo(0);
				NoBlancosGrupo(1);
				SiBlancosGrupo(2);						
				SiBlancosGrupo(3);
				
				componentes[25].setValue('1');	//tipo_actualizacion
				CM_btnEdit();
			}
			else
			{
				 Ext.MessageBox.alert('Estado','Solo viáticos en estado VERIFICACIÓN o CALCULO pueden ser editados')
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}				
	}
	
	this.btnEliminar = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
		
			if(SelectionsRecord.data.estado_viatico==0)
			{
				CM_btnEliminar();
			}
			else
			{
				Ext.MessageBox.alert('Estado','Solo viáticos en estado VERIFICACIÓN pueden ser eliminados');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}	
	}
	
	//registramos los importes
	function btn_calcular()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		//alert("El valoar del componente 9 es: "+componentes[9].getValue());
		if(NumSelect!=0)
		{
			//if(componentes[9].getValue() ==0 ||componentes[9].getValue() == 1 )	//estado viatico = Calculo
			if(SelectionsRecord.data.estado_viatico == 0 || SelectionsRecord.data.estado_viatico == 1) //estado viatico = Calculo
			{
				var data='m_id_viatico='+SelectionsRecord.data.id_viatico;
				data=data+'&m_desc_empleado='+SelectionsRecord.data.desc_empleado;
				data=data+'&m_id_categoria='+SelectionsRecord.data.id_categoria;
				data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
				data=data+'&m_sw_retencion='+SelectionsRecord.data.sw_retencion;
				data=data+'&m_detalle_otros='+SelectionsRecord.data.detalle_otros;
	
				var ParamVentana={Ventana:{width:'80%',height:'80%'}}
				layout_solicitud_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/viatico_calculo/viatico_calculo.php?'+data,'Cálculo de Viáticos',ParamVentana);
				//layout_solicitud_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/agrupador_rendicion_viaticos/rendicion_viaticos.php?'+data,'Cálculo de Viáticos',ParamVentana);
			}	
			else
			{
				Ext.MessageBox.alert('Estado','Solo viáticos en estado VERIFICACIÓN o CÁLCULO pueden realizar calculos.');	
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}	
	
	//imprimimos la solicitud de viatico
	function btn_solicitud()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{			
			//if(componentes[12].getValue()!= 'null' and componentes[12].getValue()!= "undefined" and componentes[12].getValue()!='')	//estado viatico = Calculo
			if(SelectionsRecord.data.estado_viatico > 0 && SelectionsRecord.data.estado_viatico < 4)	//estado viatico mayor a Verificación y menor a solcitu contabilizada 
			{					
			    var data='&id_viatico='+SelectionsRecord.data.id_viatico;		   	   			   	   
			    window.open(direccion+'../../../control/_reportes/viatico/ActionSolicitudViatico.php?'+data);				
			}
			else
			{
				Ext.MessageBox.alert('Atención', 'Solo viáticos en estado CALCULO o PAGO EFECTIVO pueden imprimir la solicitud');	
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	//generamos el pago
	function btn_pago()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			//if(componentes[9].getValue() == 1 )	//estado viatico = Calculo
			if(SelectionsRecord.data.estado_viatico == 1) //estado viatico = Calculo
			{
				switch (SelectionsRecord.data.tipo_pago)
				{
					//cheque
					case '1':
						btn_cheque(sm,filas,cont,NumSelect,SelectionsRecord);					
					break;
					//efectivo
					case '2':
						btn_vale(sm,filas,cont,NumSelect,SelectionsRecord);
					break;
					//sin pago - sin rendicion
					case '3':
						btn_sin_pago(sm,filas,cont,NumSelect,SelectionsRecord);
					break;
					//sin pago - con rendicion
					case '4':
						btn_sin_pago_con_rendicion(sm,filas,cont,NumSelect,SelectionsRecord);
					break;
					default: Ext.MessageBox.alert('Atención','No existe la forma de pago seleccionada.'); 
				}
			}	
			else
			{
				Ext.MessageBox.alert('Estado','Solo viáticos en estado CÁLCULO pueden emitir pagos.');	
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}			
	}	
	
	//registramos cuenta bancaria para el cheque	
	function btn_cheque(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
				CM_ocultarGrupo('Departamento');
				CM_mostrarGrupo('Datos Cheque');			
				CM_ocultarGrupo('Datos Generales');			
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Datos Vale');
				CM_ocultarGrupo('Depósito');
				CM_ocultarGrupo('Asignar Responsable Rendición');
				
				/*CM_mostrarGrupo('Departamento');
				CM_mostrarGrupo('Datos Cheque');			
				CM_mostrarGrupo('Datos Generales');			
				CM_mostrarGrupo('Oculto');
				CM_mostrarGrupo('Datos Vale');
				CM_mostrarGrupo('Depósito');*/		
				
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);			
				NoBlancosGrupo(2); //Datos Cheque no permite blancos
				SiBlancosGrupo(3);
				
				componentes[25].setValue('2');	//tipo_actualizacion
				componentes[9].setValue('4');	//estado_viatico = Solicitud contabilizada		
				componentes[8].setValue(SelectionsRecord.data.desc_empleado);	//nombre_cheque
					
				CM_btnEdit();
				//ClaseMadre_save();
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar un registro.')
	    }			
	}
		
	/**
		Seleccionamos caja y cajero para la emision de vale 
	*/
	function btn_vale(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
				CM_ocultarGrupo('Departamento');
				CM_mostrarGrupo('Datos Vale');			
				CM_ocultarGrupo('Datos Cheque');
				CM_ocultarGrupo('Datos Generales');			
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Depósito');
				CM_ocultarGrupo('Asignar Responsable Rendición');		
								
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);			
				SiBlancosGrupo(2);
				NoBlancosGrupo(3);	//datos vale no permite campos en blanco
				
				componentes[25].setValue('4');		//tipo_actualizacion
				componentes[9].setValue('3');	//estado_viatico = Pago Efectivo
				
				var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					
				componentes[18].store.baseParams={m_id_depto:componentes[29].getValue()};
				componentes[18].modificado=true;	
					
				componentes[20].disable();																//id_empleado
				componentes[21].setValue(0);						//importe_regis 
				componentes[22].setValue(componentes[14].getValue()+',  '+componentes[12].getValue());	//concepto_vale
				CM_btnEdit();				
		}
		else
		{
			Ext.MessageBox.alert('Antención','Antes debe seleccionar un registro.')
	    }			
	}	
	
	function btn_sin_pago(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			if(SelectionsRecord.data.estado_viatico == 1)	//estado viatico = Calculo
			{
				var sw=false;
				if(confirm('La solicitud no requiere generar pago y será finalizada. \nEsta seguro de Concluir la solicitud?'))
				{
					sw=true
				}
				if(sw)	//confirma la finalizacion del viatico
				{	
					SiBlancosGrupo(2); //Permitimos que el grupo Datos Cheque esten en blanco				
					componentes[25].setValue('5');	//tipo_actualizacion = TS_CONCLUIRVIA_UPD		
					componentes[9].setValue('7');		//Estado viatico = Concluido
					//CM_btnEdit();
					ClaseMadre_save();
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado CALCULO pueden ser finalizados.');
			}				
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar un registro.')
	    }			
	}
	
	function btn_sin_pago_con_rendicion(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			if(SelectionsRecord.data.estado_viatico == 1)	//estado viatico = Calculo
			{
				var sw=false;
				if(confirm('La solicitud cambiará a estado Pendiente de Rendición. \nEsta seguro de continuar?'))
				{
					sw=true
				}
				if(sw)	//confirma la finalizacion del viatico
				{	
					/*SiBlancosGrupo(2); //Permitimos que el grupo Datos Cheque esten en blanco				
					componentes[25].setValue('5');	//tipo_actualizacion = TS_CONCLUIRVIA_UPD		
					componentes[9].setValue('7');		//Estado viatico = Concluido
					//CM_btnEdit();
					ClaseMadre_save();*/
					
					SiBlancosGrupo(2); //Permitimos que el grupo Datos Cheque esten en blanco		
					componentes[25].setValue('1');	//tipo_actualizacion = solo cambiamos el estado
					componentes[9].setValue(6);		//Estado viatico = Pendiente Rendición	
					//CM_btnEdit();
					ClaseMadre_save();
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado CALCULO pueden cambiar a estado Pendiente de Rendición.');
			}				
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar un registro.')
	    }			
	}
	
	
	/*function btnContabilizar()
	{		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
			if(componentes[9].getValue()==2)	//estado viatico = PAGO CHEQUE
			{			
				if(SelectionsRecord.data.id_comprobante!='')
				{		
					Ext.MessageBox.alert('Atención','La solicitud seleccionada ya esta contabilizada.')			
				}
				else
				{	
					var sw=false;
					if(confirm('Esta seguro de contabilizar la solicitud?'))
							{sw=true}
					if(sw){				
						g_sw_contabilizar.setValue('1');
						//componentes[9].setValue(4);	//Estado viatico = Solicitud Contabilizada por la base
						ClaseMadre_save();
						//CM_btnEdit();
						g_sw_contabilizar.setValue('0');
					}	
				}	
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado PAGO CHEQUE pueden ser contabilizados.');	
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención','Antes debe seleccionar una solicitud.')
	    }	
	}*/
	
	
	/*function btn_imprime_cheque()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			if(componentes[9].getValue()==5 || componentes[9].getValue()==6)	//estado viatico = Solicitud Validada o pendiente de rendicion
			{	
			    var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;   	   			   	   
			    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
			    
			    componentes[25].setValue('1');		//tipo_actualizacion
			    componentes[9].setValue(6);	//Estado viatico = Solicitud pendiente de rendicion
				ClaseMadre_save();				
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado SOLICITUD VALIDADA o PENDIENTE RENDICIÓN pueden imprimir cheques.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}*/
	
	//registramos la rendicion de viaticos
	function btn_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			if(SelectionsRecord.data.estado_viatico==6 || SelectionsRecord.data.estado_viatico==17 || SelectionsRecord.data.estado_viatico==18 || SelectionsRecord.data.estado_viatico==19)	//estado viatico = Pendiente de rendicion
			{			
				var data='m_id_viatico='+SelectionsRecord.data.id_viatico;
				data=data+'&m_desc_empleado='+SelectionsRecord.data.desc_empleado;
				data=data+'&m_id_categoria='+SelectionsRecord.data.id_categoria;
				data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
				
				data=data+'&m_id_unidad_organizacional='+SelectionsRecord.data.id_unidad_organizacional;
				data=data+'&m_id_empleado='+SelectionsRecord.data.id_empleado;
				data=data+'&m_sw_retencion='+SelectionsRecord.data.sw_retencion;
				data=data+'&m_tipo_pago='+SelectionsRecord.data.tipo_pago;
				data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
				data=data+'&m_motivo_viaje='+SelectionsRecord.data.motivo_viaje;									
	
				var ParamVentana={Ventana:{width:'90%',height:'90%'}}
				layout_solicitud_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/agrupador_rendicion_viaticos/agrupador_rendicion_viaticos.php?'+data,'Rendición de Viáticos',ParamVentana);
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
	}
	
	//registramos la ampliacion
	function btn_ampliacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			if(SelectionsRecord.data.estado_viatico==6 || SelectionsRecord.data.estado_viatico==17 || SelectionsRecord.data.estado_viatico==18 || SelectionsRecord.data.estado_viatico==19)	//estado viatico = Pendiente de rendicion
			{		
				var data='m_id_viatico='+SelectionsRecord.data.id_viatico;
				data=data+'&m_desc_empleado='+SelectionsRecord.data.desc_empleado;
				data=data+'&m_id_categoria='+SelectionsRecord.data.id_categoria;
				data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
				
				data=data+'&m_id_unidad_organizacional='+SelectionsRecord.data.id_unidad_organizacional;
				data=data+'&m_id_empleado='+SelectionsRecord.data.id_empleado;
				data=data+'&m_sw_retencion='+SelectionsRecord.data.sw_retencion;
				data=data+'&m_tipo_pago='+SelectionsRecord.data.tipo_pago;
				data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
	
				var ParamVentana={Ventana:{width:'90%',height:'90%'}}
				layout_solicitud_viaticos.loadWindows(direccion+'../../../../sis_tesoreria/vista/ampliacion_viaticos/ampliacion_viaticos.php?'+data,'Ampliación de Viáticos',ParamVentana);
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
	}		
		
	//cambiamos de estado a 15=finalizacon parcial
	function btn_finalizar_parcialmente()
	{			
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();

		if(NumSelect==1)
		{
			if(SelectionsRecord.data.estado_viatico==6 || SelectionsRecord.data.estado_viatico==19)	//estado viatico = Pendiente de Rendicion o Con Rendicion Validada
			{
				var sw=false;
				if(confirm('Esta seguro de finalizar parcialmente la solicitud?'))
				{
					sw=true
				}
				if(sw)	//confirma la finalizacion del viatico
				{
					componentes[25].setValue('1');	//tipo_actualizacion = solo cambiamos el estado
					componentes[9].setValue(15);		//Estado viatico = Finalización Parcial	
					//CM_btnEdit();
					ClaseMadre_save();
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado PENDIENTE RENDICION pueden ser finalizados parcialmente.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');				
		}
	}	
	
	function btn_asignar_rendicion()
	{			
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
				CM_ocultarGrupo('Departamento');
				CM_ocultarGrupo('Datos Vale');			
				CM_ocultarGrupo('Datos Cheque');
				CM_ocultarGrupo('Datos Generales');			
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Depósito');
				CM_mostrarGrupo('Asignar Responsable Rendición');		
								
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);			
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);	//datos vale no permite campos en blanco
				SiBlancosGrupo(4);
				NoBlancosGrupo(6);
				
				componentes[25].setValue('4');		//tipo_actualizacion
				componentes[9].setValue('3');	//estado_viatico = Pago Efectivo
				
				var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					
				componentes[18].store.baseParams={m_id_depto:componentes[29].getValue()};
				componentes[18].modificado=true;	
					
				componentes[20].disable();																//id_empleado
				componentes[21].setValue(0);						//importe_regis 
				componentes[22].setValue(componentes[14].getValue()+',  '+componentes[12].getValue());	//concepto_vale
				CM_btnEdit();				
		}
		else
		{
			Ext.MessageBox.alert('Antención','Antes debe seleccionar un registro.')
	    }			
	}
	
	function btn_anular()
	{			
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1)
		{
			if(SelectionsRecord.data.estado_viatico==1 || SelectionsRecord.data.estado_viatico==6)	//estado viatico: Calculo o Pendiente de Rendicion
			{
				var sw=false;
				if(confirm('Esta seguro de anular la solicitud?'))
				{
					sw=true
				}
				if(sw)	//confirma la finalizacion del viatico
				{
					componentes[25].setValue('1');	//tipo_actualizacion = solo cambiamos el estado
					componentes[9].setValue(16);		//Estado viatico = Anulado
					CM_btnEdit();
					//ClaseMadre_save();
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado PENDIENTE RENDICION pueden ser anulados.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');				
		}
	}
	
	/*
	//finalizamos el viatico y calculamos saldos a favor o en contra del empleado
	function btn_finalizar()
	{			
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		var saldoViaticos=componentes[28].getValue();	//(+) saldo a favor de ENDE  (-) saldo a favor del empleado			
		//var saldoViaticos=1100;
		
		if(NumSelect==1)
		{
			if(componentes[9].getValue()==15)	//estado viatico = Finalizacion Parcial
			{
				var sw=false;
				if(confirm('Esta seguro de finalizar la solicitud?'))
				{
					sw=true
				}
				if(sw)	//confirma la finalizacion del viatico
				{
				
					if(saldoViaticos==0)	//no existe saldo ni a favor ni en contra del empleado
					{							
						componentes[25].setValue('5');	//tipo_actualizacion		
						componentes[9].setValue(7);		//Estado viatico = Concluido
						ClaseMadre_save();					
					}
					else if(saldoViaticos <= -1000)	//saldo a favor del empleado, pago con cheque
					{
						//Generamos formulario para registro de datos del cheque
						
						//Ext.MessageBox.alert('Saldo a favor del empleado', 'Saldo de rendición de viáticos a favor del empleado mayor a 1000, registre los datos del cheque', prueba);	
						alert('Saldo de rendición de viáticos a favor del empleado mayor a 1000, registre los datos del cheque');	
												
						CM_mostrarGrupo('Datos Cheque');			
						CM_ocultarGrupo('Datos Generales');			
						CM_ocultarGrupo('Oculto');
						CM_ocultarGrupo('Datos Vale');	
						CM_ocultarGrupo('Depósito');		
						
						SiBlancosGrupo(1);			
						NoBlancosGrupo(2);	//datos del cheque no pueden estar en blanco
						SiBlancosGrupo(3);
						
						componentes[7].setValue('');
						componentes[25].setValue('2');	//tipo_actualizacion para llamar al metaproceso del cheque
						//componentes[9].setValue('12');	//estado_viatico = finalizacion contabilizada		
						componentes[8].setValue(SelectionsRecord.data.desc_empleado);	//nombre_cheque
							
						CM_btnEdit();					
					}
					else if(saldoViaticos < 0 && saldoViaticos > -1000)	//saldo a favor del empleado, pago en efectivo con vale
					{
						//Generamos formulario para registrar datos del vale de caja
						
						//Ext.MessageBox.alert('Saldo a favor del empleado', 'Saldo de rendición de viáticos a favor del empleado menor a 1000, registre los datos del vale de caja');
						alert('Saldo de rendición de viáticos a favor del empleado menor a 1000, registre los datos del vale de caja');
						
						CM_mostrarGrupo('Datos Vale');			
						CM_ocultarGrupo('Datos Cheque');
						CM_ocultarGrupo('Datos Generales');			
						CM_ocultarGrupo('Oculto');
						CM_ocultarGrupo('Depósito');			
						
						NoBlancosGrupo(3);
						SiBlancosGrupo(1);			
						SiBlancosGrupo(2);
						
						componentes[25].setValue('4');		//tipo_actualizacion
						componentes[9].setValue('14');		//estado_viatico = Finalizacion por caja
						//componentes[21].setValue(saldoViaticos);	//importe_regis para el vale de caja						
							
						componentes[20].disable();										//id_empleado
						componentes[21].setValue(parseFloat(saldoViaticos * -1));			//importe_regis
						componentes[22].setValue('Vale generado automaticamente desde Solicitud de Viáticos; la rendición tuvo un saldo a favor del empleado al finalizar la solicitud de viáticos');	//concepto_regis
						CM_btnEdit();	
					}
					else if(saldoViaticos > 0)	//saldo a favor de la empresa
					{
						//generar formulario para registro de deposito
						
						//Ext.MessageBox.alert('Saldo a favor de la empresa', 'Saldo de rendición de viáticos a favor de la empresa, registre el deposito bancario del empleado');
						alert( 'Saldo de rendición de viáticos a favor de la empresa, registre el deposito bancario del empleado');
						CM_mostrarGrupo('Datos Cheque');			
						CM_ocultarGrupo('Datos Generales');			
						CM_ocultarGrupo('Oculto');
						CM_ocultarGrupo('Datos Vale');
						CM_mostrarGrupo('Depósito');			
						
						SiBlancosGrupo(1);			
						NoBlancosGrupo(2);
						SiBlancosGrupo(3);
						
						componentes[7].setValue('');
						componentes[25].setValue('2');	//tipo_actualizacion
						//componentes[9].setValue('12');	//estado_viatico = Pago Cheque		
						componentes[8].setValue(SelectionsRecord.data.desc_empleado);	//nombre_cheque						
							
						CM_btnEdit();
					}
				}				
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado FINALIZACION PARCIAL pueden ser finalizados.');
			}	
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}		
	}*/
	
	//impmimos el cheque por la finalizacion
	/*function btn_imprime_cheque_fin()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			if(componentes[9].getValue()==13 && componentes[28].getValue() < -1000)	//estado viatico = Finalizacion Validada  Y EL SALDO ES A FAVOR DEL EMPLEADO Y CON CHEQUE
			{	
			    var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;   	   			   	   
			    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
			    
			    componentes[25].setValue('1');		//tipo_actualizacion
			    componentes[9].setValue(7);	//Estado viatico = Concluido
				ClaseMadre_save();				
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Solo viáticos en estado FINALIZACION VALIDADA y SALDO A FAVOR DEL EMPLEADO pueden imprimir cheques.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}*/
	
	/*function evento_tipo_pago()
	{
		if(componentes[15].getValue()==2)
		{
			componentes[16].setValue(3);//total_viatico
			componentes[16].setDisabled(true);		
		}
		else
		{
			componentes[16].reset();//total_viatico
			componentes[16].setDisabled(false);
		}	
	}	*/
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_viaticos.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	var CM_getBoton=this.getBoton;
	
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Calcular Importe de Viáticos',btn_calcular,true,'calcular','Calcular');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Solicitud de Viáticos',btn_solicitud,true,'imp_ejecucion','Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Emitir Pago de Viáticos',btn_pago,true,'emitir_pago','Generar Pago');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Registrar Ampliación',btn_ampliacion,true,'ampliacion','Ampliación');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Registrar Rendiciones',btn_rendicion,true,'rendicion','Rendición');
	
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Viático',btn_finalizar_parcialmente,true,'fin_parcial_viatico','Finalizar Parcialmente'); //tucrem
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignar Rendición',btn_asignar_rendicion,true,'asignar_rendicion','Asignar Rendición');
	//this.AdicionarBoton('../../../lib/imagenes/cross.gif','Anular',btn_anular,true,'anular','Anular');
	
	//alert("llega disa");
	CM_getBoton('nuevo-'+idContenedor).enable();
	CM_getBoton('editar-'+idContenedor).enable();
	CM_getBoton('eliminar-'+idContenedor).enable();
	CM_getBoton('calcular-'+idContenedor).disable();
	CM_getBoton('imp_ejecucion-'+idContenedor).disable();
	CM_getBoton('emitir_pago-'+idContenedor).disable();	
	CM_getBoton('rendicion-'+idContenedor).disable();
	CM_getBoton('ampliacion-'+idContenedor).disable();
	CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
	//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
	//CM_getBoton('anular-'+idContenedor).disable();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);			
		
		if(rec.data['estado_viatico']=='0')//verificacion
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('calcular-'+idContenedor).enable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();
		}
		if(rec.data['estado_viatico']=='1')//calculo
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).enable();
			CM_getBoton('imp_ejecucion-'+idContenedor).enable();
			CM_getBoton('emitir_pago-'+idContenedor).enable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();			
		}
		/*if(rec.data['estado_viatico']=='2')//pago cheque
		{
			//alert("llega disa");
		//	CM_getBoton('calcular-'+idContenedor).disable();
		//	CM_getBoton('imp_ejecucion-'+idContenedor).disable();
		//	CM_getBoton('emitir_pago-'+idContenedor).disable();
			//CM_getBoton('impresion_cheque-'+idContenedor).disable();
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			CM_getBoton('fin_viatico-'+idContenedor).disable();
			CM_getBoton('impresion_cheque_fin-'+idContenedor).disable();			
		}*/
		if(rec.data['estado_viatico']=='3')//pago efectivo
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();			
		}
		if(rec.data['estado_viatico']=='4')//solicitud contabilizada
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();			
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();			
		}
		if(rec.data['estado_viatico']=='5')//solicitud Validada
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();
		}
		if(rec.data['estado_viatico']=='6' || rec.data['estado_viatico']=='17' || rec.data['estado_viatico']=='18' || rec.data['estado_viatico']=='19')//pendiente rendicion
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).enable();
			CM_getBoton('ampliacion-'+idContenedor).enable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).enable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();						
		}
		if(rec.data['estado_viatico']=='7')//concluido
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();			
		}
		if(rec.data['estado_viatico']=='16')//solicitud anulada
		{
			//alert("llega disa");
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('calcular-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('emitir_pago-'+idContenedor).disable();			
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).disable();
			//CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			//CM_getBoton('anular-'+idContenedor).disable();			
		}
		
		/*else
		{
			CM_getBoton('calcular-'+idContenedor).enable();
			CM_getBoton('imp_ejecucion-'+idContenedor).enable();
			CM_getBoton('emitir_pago-'+idContenedor).enable();
			CM_getBoton('impresion_cheque-'+idContenedor).enable();
			CM_getBoton('rendicion-'+idContenedor).enable();
			CM_getBoton('ampliacion-'+idContenedor).enable();
			CM_getBoton('fin_parcial_viatico-'+idContenedor).enable();
			CM_getBoton('fin_viatico-'+idContenedor).enable();
			CM_getBoton('impresion_cheque_fin-'+idContenedor).enable();
			CM_getBoton('asignar_rendicion-'+idContenedor).disable();
			CM_getBoton('anular-'+idContenedor).disable();
			
		}*/					
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_viaticos.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}