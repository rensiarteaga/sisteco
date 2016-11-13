/**
* Nombre:		  	    pagina_devengar_servicios.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:59:44
*/
function pagina_devengar_servicios(idContenedor,direccion,paramConfig,tipoFormDev){
	var Atributos=new Array,sw=0;
	var v_importe_devengado;
	var btn_pagos_efect,cmbDepto,cmbMoneda,cmbPeriodoSubsis,dteFechaDeveng,cmbTipoPlantilla,cmbEntregaDoc,cmbCueBan,cmbTipoPago,cmbConceptoIngas,txtImporteDevengado;
	var tipoFormDev=tipoFormDev;
	var cmbConcepGasto;
	var datos_pago;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'valor',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000}	
	);
	
	//tipoFormDev-> dev, pag, detpag, fin

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado/ActionListarDevengarServicios.php?tipoFormDev='+tipoFormDev}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_devengado',totalRecords:'TotalCount'
		},[
		'id_devengado',
		'id_parametro',
		'gestion_pres',
		'id_concepto_ingas',
		'id_moneda',
		'importe_devengado',
		'importe_pagado',
		'importe_saldo',
		'estado_devengado',
		'fk_devengado',
		'id_proveedor',
		'id_cheque',
		'id_comprobante',
		'tipo_devengado',
		{name: 'fecha_devengado',type:'date',dateFormat:'Y-m-d'},
		'desc_concepto_ingas',
		'desc_moneda',
		'desc_proveedor',
		'desc_tipo_devengado',
		'desc_estado_devengado',
		'tot_importe_det',
		'tot_porcentaje_det',
		'id_cotizacion',
		'nivel_documento',
		'observaciones',
		'id_depto',
		'nombre_depto',
		'id_empleado',
		'desc_empleado',
		'nit',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_periodo_subsistema',
		'tipo_gen_pago',
		'obs_contabilidad',
		'tipo_desembolso',
		'id_cajero',
		'cajero',
		'id_caja',
		'desc_caja',
		'id_emp_recep_caja',
		'desc_emp_recep_caja',
		'id_periodo_subsistema',
		'desc_periodo_subsistema',
		'entrega_doc',
		'tipo_plantilla',
		'desc_tipo_plantilla',
		'tipo_pago',
		'tipo_plantilla_pago',
		'desc_tipo_plantilla_pago',
		'id_cuenta_bancaria',
		'sw_pago_comprometido',
		'sw_solo_devengado',
		'id_comprobante_reg',
		'importe_otros_con',
		'importe_total',
		'correl'
		]),remoteSort:true
	});

	//DATA STORE COMBOS
	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?sw_tesoro=6'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_ingas','desc_ingas_item_serv','gestion_pres','desc_partida'])
	});

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedorVista2.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor','codigo','desc_proveedor'])
	});

	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});

	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional','codigo_caja','desc_caja'])
	});

	var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
	
	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_empleado',totalRecords: 'TotalCount'}, ['id_empleado','id_persona','codigo_empleado','desc_persona'])
	});
	
	var ds_periodo_subsistema = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema','id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','desc_periodo_subsistema','estado_periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'nombre_largo','gestion']),
		baseParams: {tesoro:1,m_id_subsistema:12,m_estado_periodo:'abierto'}
	});
	
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro'])
		});
	
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco','gestion']),
    	baseParams:{m_sw_combo:'combo'}
    });
    
    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
 
	//FUNCIONES RENDER
	function render_id_concepto_ingas(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+record.data['desc_concepto_ingas']+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){	return String.format('{0}', '<span style="color:red">'+record.data['desc_concepto_ingas']+'</span>');}else{	return String.format('{0}', record.data['desc_concepto_ingas']);}}
	function render_id_proveedor(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+record.data['desc_proveedor']+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['desc_proveedor']+'</span>');}else{return String.format('{0}', record.data['desc_proveedor']);}}
	function render_fecha_devengado(value, p, record){var aux=value?value.dateFormat('d/m/Y'):'';if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+aux+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+aux+'</span>');}else{return String.format('{0}', aux);}}
	function render_id_moneda(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+record.data['desc_moneda']+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['desc_moneda']+'</span>');}else{return String.format('{0}', record.data['desc_moneda']);}}
	function render_estado_devengado(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+record.data['desc_estado_devengado']+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['desc_estado_devengado']+'</span>');}else{return String.format('{0}', record.data['desc_estado_devengado']);}}
	function render_tipo_devengado(value, p, record){if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['desc_tipo_devengado']+'</span>');}else{return String.format('{0}', record.data['desc_tipo_devengado']);}}
	function render_id_depto(value, p, record){if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+record.data['nombre_depto']+'</span>');}else{return String.format('{0}', record.data['nombre_depto']);}}
	function render_tipo_desembolso(value,p,record){if(value==1){return 'Cheque';}else if(value==2){return 'Caja';}else if(value==3){return  'Transferencia Bancaria'}}
	function render_caja(value,p,record){return String.format('{0}',record.data['desc_caja']);}
	function render_cajero(value,p,record){return String.format('{0}',record.data['cajero']);}
	function render_id_emp_recep_caja(value, p, record){return String.format('{0}', record.data['desc_emp_recep_caja']);}
	function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_periodo_subsistema']);}
	function render_entrega_doc(value,p,record){if(value=='ant_pago'){return 'Antes del pago';}else if(value=='post_pago'){return 'Posterior al pago';}}
	function render_tipo_plantilla(value,p,record){return String.format('{0}',record.data['desc_tipo_plantilla']);};
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['gestion_pres']);}
		
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b>Concepto: </b><FONT COLOR="#8E2323">{desc_ingas_item_serv}</FONT>','<br><b>Partida: </b><FONT COLOR="#B5A642">{desc_partida}</FONT>','<br><b>Gestion: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b>{simbolo}</b><br>','<FONT COLOR="#B5A642">{nombre}</FONT>','</div>');
	var tpl_id_proveedor=new Ext.Template('<div class="search-item">','{desc_proveedor}','</div>');
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b>{codigo_depto}</b><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');
	var tpl_id_caja=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_caja}</FONT><br>','<b>UO: </b><FONT COLOR="#B5A642">{desc_unidad_organizacional}</FONT>','<br><b>Moneda: </b><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');
	var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b>{apellido_paterno_persona} {apellido_materno_persona} {nombre_persona}</b>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
	var tpl_id_emp_recep_caja=new Ext.Template('<div class="search-item">','<b>{codigo_empleado}</b>','<br><FONT COLOR="#B5A642">{desc_persona}</FONT>','</div>');
	var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT><br>','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo_subsistema}</FONT>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','</div>');
	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><b><i><b>Gestión: </b>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');

	function render_porcentaje_devengado(value, p, record){var v_porc_dev=record.data['tot_porcentaje_det']!='' ? record.data['tot_porcentaje_det']+'%':record.data['tot_porcentaje_det'];if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+v_porc_dev+'</span>');}else{return String.format('{0}', v_porc_dev);}}
	
	function render_importe_devengado(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+monedas_for.formatMoneda(record.data['importe_devengado'])+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+monedas_for.formatMoneda(record.data['importe_devengado'])+'</span>');}else{return String.format('{0}', monedas_for.formatMoneda(record.data['importe_devengado']));}}
	function render_importe_pagado(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+monedas_for.formatMoneda(record.data['importe_pagado'])+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+monedas_for.formatMoneda(record.data['importe_pagado'])+'</span>');}else{return String.format('{0}', monedas_for.formatMoneda(record.data['importe_pagado']));}}
	function render_importe_saldo(value, p, record){if(record.data['id_cotizacion']!=''){return String.format('{0}', '<span style="color:blue">'+monedas_for.formatMoneda(record.data['importe_saldo'])+'</span>');}if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+monedas_for.formatMoneda(record.data['importe_saldo'])+'</span>');}else{return String.format('{0}', monedas_for.formatMoneda(record.data['importe_saldo']));}}
	function render_importe_prorrateado(value, p, record){if(record.data['estado_devengado']==1||record.data['estado_devengado']==2){return String.format('{0}', '<span style="color:red">'+monedas_for.formatMoneda(record.data['tot_importe_det'])+'</span>');}else{return String.format('{0}', monedas_for.formatMoneda(record.data['tot_importe_det']));}}
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');
	function render_id_empleado(value, p, record){	  return String.format('{0}', record.data['desc_empleado']);}
	/////////////////////////
	// Definicion de datos //
	/////////////////////////

	// hidden id_devengado
	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado',
		id_grupo:0
	};
	
	Atributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			desc: 'gestion_pres', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			align:'center',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:50,  //para colocar el orden en el indice			
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_parametro',
		id_grupo:0		
	};
	
	// txt id_concepto_ingas
	Atributos[2]={
		validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto Gasto',
			allowBlank:false,
			emptyText:'Concepto Gasto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas#PARTID.codigo_partida#PARTID.nombre_partida#PARAME.gestion_pres',
			typeAhead:false,
			tpl:tpl_id_concepto_ingas,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_concepto_ingas',
		save_as:'id_concepto_ingas',
		id_grupo:0
	};

	// txt id_proveedor
	Atributos[3]={
		validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:false,
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'desc_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PROVEE.codigo#PROVEE.desc_proveedor',
			typeAhead:false,
			tpl:tpl_id_proveedor,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			width:300,
			disabled:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_proveedor',
		save_as:'id_proveedor',
		id_grupo:0
	};
	
	// txt id_moneda
	Atributos[4]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			tpl:tpl_id_moneda,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:250,
			disabled:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_moneda',
		save_as:'id_moneda',
		id_grupo:0
	};

	// txt importe_devengado
	Atributos[5]={
		validacion:{
			name:'importe_devengado',
			fieldLabel:'Importe Válido C.F.',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer:render_importe_devengado,
			width_grid:120,
			width:'50%',
			disabled:false,
			grid_indice:5,
			validator:function val_num(value){if(value<=0){return false;}else{return true;}},
			invalidText:'El valor debe ser mayor a cero'
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_devengado',
		save_as:'importe_devengado',
		id_grupo:0
	};

	// txt tipo_devengado
	Atributos[6]={
		validacion:{
			name:'tipo_devengado',
			fieldLabel:'Tipo Devengado',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			renderer:render_tipo_devengado,
			disabled:false,
			grid_indice:7
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'desc_tipo_devengado',
		save_as:'tipo_devengado',
		id_grupo:0
	};

	// txt estado_devengado
	Atributos[7]={
		validacion:{
			name:'estado_devengado',
			fieldLabel:'Estado',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'50%',
			disabled:false,
			grid_indice:8,
			renderer:render_estado_devengado
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'desc_estado_devengado',
		save_as:'estado_devengado',
		id_grupo:0
	};

	// txt tot_importe_det
	if(tipoFormDev=='dev'){
		boolMostrar=true;
	}
	else{
		boolMostrar=false;
	}

	Atributos[8]={
		validacion:{
			name:'tot_importe_det',
			fieldLabel:'Prorrateo',
			align:'right',
			//grid_visible:tipoFormDev=='dev' ? true:false,
			grid_visible:boolMostrar,
			grid_editable:false,
			width_grid:100,
			grid_indice:9,
			renderer:render_importe_prorrateado
		},
		tipo: 'Field',
		form: false,
		save_as:'tot_importe_det',
		id_grupo:0
	};

	Atributos[9]={
		validacion:{
			name:'tot_porcentaje_det',
			fieldLabel:'% Prorrateo',
			align:'right',
			//grid_visible:tipoFormDev=='dev' ? true:false,
			grid_visible:boolMostrar,
			grid_editable:false,
			width_grid:80,
			grid_indice:10,
			renderer:render_porcentaje_devengado
		},
		tipo: 'Field',
		form: false,
		save_as:'tot_porcentaje_det',
		id_grupo:0
	};

	// txt importe_pagado
	if(tipoFormDev=='pag'||tipoFormDev=='fin'||tipoFormDev=='desc'){
		boolMostrar=true;
	}
	else{
		boolMostrar=false;
	}
	Atributos[10]={
		validacion:{
			name:'importe_pagado',
			fieldLabel:'Pagado',
			align:'right',
			//grid_visible:tipoFormDev=='pag' ? true:false,
			grid_visible:boolMostrar,
			grid_editable:false,
			renderer:render_importe_pagado,
			width_grid:140,
			grid_indice:9
		},
		tipo: 'Field',
		form: false,
		save_as:'importe_pagado',
		id_grupo:0
	};

	// txt importe_saldo
	Atributos[11]={
		validacion:{
			name:'importe_saldo',
			fieldLabel:'Saldo',
			align:'right',
			//grid_visible:tipoFormDev=='pag' ? true:false,
			grid_visible:boolMostrar,
			renderer:render_importe_saldo,
			grid_editable:false,
			width_grid:140,
			grid_indice:9
		},
		tipo: 'Field',
		form: false,
		save_as:'importe_saldo',
		id_grupo:0
	};

	// txt tipo_documento
	Atributos[12]={
		validacion:{
			name:'nivel_documento',
			fieldLabel:'Documento Registrado',
			//grid_visible:tipoFormDev=='pag' ? true:false,
			grid_visible:boolMostrar,
			grid_editable:false,
			width_grid:140,
			grid_indice:10
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'nivel_documento',
		save_as:'nivel_documento',
		id_grupo:0
	};

	filterCols_depto=new Array();
	filterValues_depto=new Array();
	filterCols_depto[0]='DEPTO.id_subsistema';
	filterValues_depto[0]='12';
	// txt Departamento
	Atributos[13]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			filterCols:filterCols_depto,
			filterValues:filterValues_depto,
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			width:300,
			disabled:false,
			grid_indice:12
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_depto',
		save_as:'id_depto',
		id_grupo:0
	};
	
	Atributos[14]={
		validacion:{
			name:'id_periodo_subsistema',
			fieldLabel:'Periodo',
			allowBlank:false,			
			emptyText:'Periodo...',
			desc: 'desc_periodo_subsistema', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo_subsistema ,
			valueField: 'id_periodo_subsistema',
			displayField: 'desc_periodo_subsistema',
			queryParam: 'filterValue_0',
			filterCol:'PERIOD.periodo#GESTIO.gestion',
			tpl:tpl_id_periodo_subsistema,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_periodo_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		save_as:'id_periodo_subsistema',
		id_grupo:0
	};
	
	Atributos[15]= {
		validacion:{
			name:'fecha_devengado',
			fieldLabel:'Fecha',
			grid_visible:true,
			grid_editable:false,
			//renderer: formatDate,
			renderer: render_fecha_devengado,
			width_grid:85,
			allowBlank:false,
			grid_indice:1
		},
		tipo:'DateField',
		form:true,
		filtro_0:true,
		filterColValue:'fecha_devengado',
		dateFormat:'m-d-Y',
		save_as:'fecha_devengado',
		id_grupo:0
	};

	// txt observaciones
	Atributos[16]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Glosa Pago',
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:'100%',
			//disabled:false,
			grid_indice:10,
			allowBlank:false
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'observaciones',
		save_as:'observaciones',
		id_grupo:0
	};

	Atributos[18]={
		validacion:{
			name:'nit',
			fieldLabel:'NIT',
			grid_visible:false,
			grid_editable:false,
		},
		tipo: 'Field',
		form: false,
		save_as:'nit',
		id_grupo:0
	};

	Atributos[19]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		save_as:'id_comprobante',
		id_grupo:0
	};

	Atributos[20]={
		validacion:{
			fieldLabel:'Observaciones Contabilidad',
			name: 'obs_contabilidad',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			grid_indice:15
		},
		tipo: 'Field',
		filtro_0:false,
		form: false,
		save_as:'obs_contabilidad',
		id_grupo:0
	};
	
	Atributos[21]= {
		validacion:{
			name:'tipo_desembolso',
			fieldLabel:'Desembolso por',
			emptyText:'Tipo Desembolso',
			allowBlank:false,
			typeAhead: false,
			lazyRender: true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['atributo', 'valor'],
				data: [['1','Cheque'],['2','Caja'],['3','Transferencia Bancaria']]
			}),
			valueField:'atributo',
			displayField:'valor',
			width: 150,
			minChars : 0,
			grid_visible:true,
			renderer:render_tipo_desembolso,
			grid_indice:16
		},
		tipo:'ComboBox',
		save_as:'tipo_desembolso',
		id_grupo:0
	};

	fCols_caja=new Array();
	fValues_caja=new Array();
	fCols_caja[0]='DEPTO.id_depto';
	fValues_caja[0]='x';
	fCols_caja[1]='MONEDA.id_moneda';
	fValues_caja[1]='x';
	Atributos[22]={
		validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:true,
			emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_caja',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
			tpl:tpl_id_caja,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			filterCols:fCols_caja,
			filterValues:fValues_caja,
			renderer:render_caja,
			grid_indice:17
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre#UNIORG.nombre_unidad',
		id_grupo:2
	};

	// txt id_cajero
	fCols_cajero=new Array();
	fValues_cajero=new Array();
	fCols_cajero[0]='CAJERO.id_caja';
	fValues_cajero[0]='x';
	Atributos[23]={
		validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:true,
			emptyText:'Cajero...',
			desc: 'cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre',
			typeAhead:false,
			tpl:tpl_id_cajero,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			disabled:false,
			width:300,
			filterCols:fCols_cajero,
			filterValues:fValues_cajero,
			renderer:render_cajero,
			grid_indice:18
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre#EMPLEA_1.codigo_empleado',
		id_grupo:2
	};

	Atributos[24] = {
		validacion: {
			name:'id_emp_recep_caja',
			fieldLabel:'Receptor Caja',
			allowBlank:true,
			emptyText:'Funcionario...',
			desc: 'desc_emp_recep_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno#EMPLEA.codigo_empleado',
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_emp_recep_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_emp_recep_caja,
			grid_indice:19
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'EMPLEA.id_persona',
		id_grupo:2
	};
	
	Atributos[25]={
		validacion:{
			name:'tipo_pago',
			fieldLabel:'Tipo Pago',
			emptyText:'Tipo Pago...',
			allowBlank:false,
			typeAhead: false,
			lazyRender: true,
			mode: 'local',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['atributo', 'valor'],
				data: [['pago','Pago adelantado'],['devengado','Devengado']]
			}),
			valueField:'atributo',
			displayField:'valor',
			width: 150,
			minChars : 0,
			grid_visible:true,
			grid_indice:20
		},
		tipo:'ComboBox',
		id_grupo:1
	};
	
	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='PLANT.sw_tesoro';
	filterValues[0]='1';
	Atributos[26]={
		validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Tipo Documento',
			allowBlank:true,
			emptyText:'Tipo Documento...',
			store:ds_plantilla,
			desc:'desc_tipo_plantilla',
			valueField:'tipo_plantilla',
			displayField:'desc_plantilla',
			queryParam:'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			filterCols:filterCols,
			filterValues:filterValues,
			grid_visible:true,
			grid_editable:false,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:300,
			renderer:render_tipo_plantilla,
			grid_indice:21
		},
		tipo:'ComboBox',
		save_as:'tipo_plantilla',
		id_grupo:1
	};
	
	Atributos[27]={
		validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,
			emptyText:'Cuenta...',
			store:ds_cuenta_bancaria,
			valueField:'id_cuenta_bancaria',
			displayField:'nro_cuenta_banco',
			queryParam:'filterValue_0',
			filterCol:'INSTIT.nombre#CUENTA.nro_cuenta#AUXILI.codigo_auxiliar#CUEBAN.nro_cuenta_banco',
			typeAhead:false,
			tpl:tpl_cuenta_bancaria,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:3
	};
	
	Atributos[28]={
		validacion:{
			name: 'importe_otros_con',
			fieldLabel:'Importe No Válido C.F.',
			align:'right',
			renderer: render_total,
			grid_visible:true,
			grid_indice:6,
			width_grid:130
		},
		tipo: 'Field',
		filtro_0:false,
		form: false
	};
	
	Atributos[29]={
		validacion:{
			name: 'importe_total',
			fieldLabel:'Total a Pagar',
			align:'right',
			renderer: render_total,
			grid_visible:true,
			grid_indice:7
		},
		tipo: 'Field',
		filtro_0:false,
		form: false
	};
	
	Atributos[30]={
		validacion:{
			name: 'correl',
			fieldLabel:'Nro.Doc.',
			grid_visible:true,
			grid_indice:-1
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'correl',
		form: false
	};
		
	//28/11/2013 - RE-SABS
	Atributos[17]={
		validacion:{
			name:'id_empleado',
			fieldLabel:'Firma Autorizada',
			allowBlank:false,
			emptyText:'Aprobador...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEA.id_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			typeAhead:false,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
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
		filtro_1:true,
		filterColValue:'emp_solicitante.nombre#emp_solicitante.apellido_paterno#emp_solicitante.apellido_materno',
		save_as:'id_empleado_aprobacion',
		id_grupo:4
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config=new Array;
	if(tipoFormDev=='pag'||tipoFormDev=='fin'){
		config={titulo_maestro:'Registro de Pagos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/devengar_servicios/devengar_pagar_det.php'};
	} else{
		config={titulo_maestro:'Registro de Pagos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/devengado_detalle/devengado_detalle.php'};
	}
	var layout_devengar_servicios=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_devengar_servicios.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_devengar_servicios,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_htmlMaestro=this.htmlMaestro;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnActualizar = this.btnActualizar;
	var CM_mostrarFormulario = this.mostrarFormulario;
	var CM_ocultarFormulario = this.ocultarFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_conexionFailure = this.conexionFailure;
	var CM_save=this.Save;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_deselectRow=this.DeselectRow;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_getFormulario=this.getFormulario;
	var CM_ocultarFormulario=this.ocultarFormulario;
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var v_guardar=true;v_nuevo=true,v_editar=true,v_eliminar=true,v_actualizar=true;

	if(tipoFormDev=='pag'||tipoFormDev=='fin'||tipoFormDev=='aprob'||tipoFormDev=='desc'){
		var paramMenu={
			actualizar:{crear:v_actualizar,separador:false}
		};
	}else{
		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
	}

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado/ActionEliminarDevengarServicios.php'},
		Save:{url:direccion+'../../../control/devengado/ActionGuardarDevengarServicios.php'},
		ConfirmSave:{url:direccion+'../../../control/devengado/ActionGuardarDevengarServicios.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Devengar Servicios',
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Tipo Pago',columna:0,id_grupo:1},{tituloGrupo:'Datos Caja',columna:0,id_grupo:2},{tituloGrupo:'Cuenta Bancaria',columna:0,id_grupo:3},{tituloGrupo:'Autorizacion',columna:0,id_grupo:4}]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_devengado_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_devengado='+SelectionsRecord.data.id_devengado;
			data=data+'&desc_concepto_ingas='+SelectionsRecord.data.desc_concepto_ingas;
			data=data+'&desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&importe_devengado='+SelectionsRecord.data.importe_devengado;
			data=data+'&tipo_devengado='+SelectionsRecord.data.desc_tipo_devengado;
			data=data+'&estado_devengado='+SelectionsRecord.data.desc_estado_devengado;
			data=data+'&tipoFormDev='+tipoFormDev;
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_devengar_servicios.loadWindows(direccion+'../../../../sis_tesoreria/vista/devengado_detalle/devengado_detalle.php?'+data,'Detalle Devengado',ParamVentana);

		} else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}

	//Evento sobrecargado del EnableSelect
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
		var aux={tipoFormDev:tipoFormDev};
		Ext.apply(aux,y.data);
		_CP.getPagina(layout_devengar_servicios.getIdContentHijo()).pagina.reload(aux);
		_CP.getPagina(layout_devengar_servicios.getIdContentHijo()).pagina.desbloquearMenu();
	}

	//Evento sobrecargado al deseleccionar una fila
	this.DeselectRow=function(x,z){
		if(tipoFormDev=='dev'){
			CM_getBoton('fin_dev-'+idContenedor).disable();
			CM_getBoton('con_dev-'+idContenedor).disable();
			CM_getBoton('reimp_dev-'+idContenedor).disable();
		}else if(tipoFormDev=='pag'){
			CM_getBoton('pag_ef-'+idContenedor).disable();
			CM_getBoton('docs-'+idContenedor).hide();
		}
	}

	this.btnActualizar=function(){
		var sm=getSelectionModel();
		var sw=sm.getCount();
		CM_btnActualizar();
	}

	//Evento al Seleccionar una fila
	function enable(sel,row,selected){
		//Habilita o deshabilita los botones dependiendo del tipo de la vista
		var record=selected.data;
		//alert('estado devengado:'+record.estado_devengado);
		if(selected&&record!=-1){ //reg_desem, fin_sol
			if(tipoFormDev=='dev'){
				if(record.estado_devengado==1||record.estado_devengado==2){
					//POR PRORRATEAR|POR AJUSTAR Se deshabilita la opción de Contabilización y Finalización
					CM_getBoton('fin_dev-'+idContenedor).disable();
					CM_getBoton('con_dev-'+idContenedor).disable();
					CM_getBoton('fin_sol-'+idContenedor).disable();
					CM_getBoton('reg_desem-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
				}else if(record.estado_devengado==3){
					//PRORRATEADO:Se habilita la opción de Contabilización
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
					CM_getBoton('reg_desem-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).disable();
					if(record.tipo_desembolso==1||record.tipo_desembolso==3){ //Cheque o Transferencia
						CM_getBoton('fin_sol-'+idContenedor).enable();
						CM_getBoton('con_dev-'+idContenedor).disable();
						CM_getBoton('fin_dev-'+idContenedor).disable();
					} else if(record.tipo_desembolso==2){
						CM_getBoton('fin_sol-'+idContenedor).enable();
						CM_getBoton('con_dev-'+idContenedor).disable();
						CM_getBoton('fin_dev-'+idContenedor).disable();
					} 
				}else if(record.estado_devengado==8){
					//VALIDADO:Se habilita la opción de Finalización
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('con_dev-'+idContenedor).disable();
					CM_getBoton('reg_desem-'+idContenedor).disable();
					CM_getBoton('fin_sol-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).enable();
					if(record.tipo_pago=='pago'){
						CM_getBoton('fin_dev-'+idContenedor).enable();
					}else {
						CM_getBoton('fin_dev-'+idContenedor).enable();
					}
				}else if(record.estado_devengado==7){
					//EN CONTABILIDAD: Está en Contabilización esperando la validación del comprobante
					//Se deshabilitan todas las opciones
					CM_getBoton('fin_dev-'+idContenedor).disable();
					CM_getBoton('con_dev-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('fin_sol-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).enable();
					CM_getBoton('reg_desem-'+idContenedor).disable();
				} else if(record.estado_devengado==14){
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).enable();
					if(record.tipo_desembolso==1||record.tipo_desembolso==3){
						CM_getBoton('fin_dev-'+idContenedor).disable();
						CM_getBoton('con_dev-'+idContenedor).enable();
						CM_getBoton('fin_sol-'+idContenedor).disable();
						CM_getBoton('reg_desem-'+idContenedor).enable();
					} else{
						CM_getBoton('fin_dev-'+idContenedor).disable();
						CM_getBoton('con_dev-'+idContenedor).disable();
						CM_getBoton('fin_sol-'+idContenedor).disable();
						CM_getBoton('reg_desem-'+idContenedor).disable();
					}
				} else if(record.estado_devengado==16){
					if(record.tipo_pago=='pago'){
						CM_getBoton('fin_dev-'+idContenedor).enable();
						CM_getBoton('editar-'+idContenedor).disable();
						CM_getBoton('eliminar-'+idContenedor).disable();
						CM_getBoton('con_dev-'+idContenedor).disable();
						CM_getBoton('reg_desem-'+idContenedor).disable();
						CM_getBoton('fin_sol-'+idContenedor).disable();
						CM_getBoton('reimp_dev-'+idContenedor).enable();
					} 
				} else if(record.estado_devengado==15){
					CM_getBoton('fin_dev-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('con_dev-'+idContenedor).disable();
					CM_getBoton('reg_desem-'+idContenedor).disable();
					CM_getBoton('fin_sol-'+idContenedor).disable();
					CM_getBoton('reimp_dev-'+idContenedor).enable();
				}
			}else if(tipoFormDev=='pag'){
				if(record.estado_devengado==7){
					CM_getBoton('pag_ef-'+idContenedor).disable();
					CM_getBoton('docs-'+idContenedor).hide();
				}else{
					CM_getBoton('pag_ef-'+idContenedor).enable();
					CM_getBoton('docs-'+idContenedor).hide();
				}
			}
			
			//RCM: opcion para bloquear boton de correccion de solicitud
			if(record.estado_devengado==14){
				CM_getBoton('cor_sol-'+idContenedor).enable();
			} else{
				CM_getBoton('cor_sol-'+idContenedor).disable();
			}
		}
		CM_enableSelect(sel,row,selected);
	}

	function btn_devengado_dcto(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_devengado='+SelectionsRecord.data.id_devengado;
			data=data+'&m_desc_concepto_ingas='+SelectionsRecord.data.desc_concepto_ingas;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_importe_devengado='+SelectionsRecord.data.importe_devengado;
			data=data+'&m_tipo_devengado='+SelectionsRecord.data.desc_tipo_devengado;
			data=data+'&m_estado_devengado='+SelectionsRecord.data.desc_estado_devengado;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&tipoFormDev='+tipoFormDev;
			data=data+'&m_nit='+SelectionsRecord.data.nit;
			data=data+'&m_razon_social='+SelectionsRecord.data.desc_proveedor;
			data=data+'&m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;

			//Verifica si se podrï¿½ o no modificar el Tipo de Documento
			if(SelectionsRecord.data.id_cotizacion!=''){
				data=data+'&m_tipo_doc_fijo=si';
			}else{
				data=data+'&m_tipo_doc_fijo=';
			}
			var ParamVentana={Ventana:{width:'80%',height:'60%'}}
			layout_devengar_servicios.loadWindows(direccion+'../../../../sis_tesoreria/vista/devengado_dcto/devengado_dcto.php?'+data,'Detalle Devengado',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}

	function btn_fin_dev(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			if(confirm('¿Está seguro de Finalizar el Registro?')){
				var id_devengado=sm.getSelected().data.id_devengado;
				Ext.Ajax.request({
					url:direccion+'../../../../sis_tesoreria/control/devengado/ActionFinalizarDevengado.php?id_devengado='+id_devengado,
					method:'POST',
					success:exito_fin,
					failure:ClaseMadre_conexionFailure,
					timeout:100000
				})
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}

	function exito_fin(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			CM_btnActualizar()
		}
	}

	function btn_rep() {
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			var id_devengado=sm.getSelected().data.id_devengado;
			window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionDevengadoSolicitudFin.php?id_devengado='+id_devengado)
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}

	function btn_fin_dev_pag(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			if(confirm('¿Está seguro de Finalizar el Pago?')){
				var id_devengado=sm.getSelected().data.id_devengado;
				Ext.Ajax.request({
					url:direccion+'../../../../sis_tesoreria/control/devengado/ActionFinalizarDevengadoPagado.php?id_devengado='+id_devengado,
					method:'POST',
					success:exito_fin_pag,
					timeout:100000
				})
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}

	function exito_fin_pag(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			//RCM: 02-09-2009
			//Se aumenta la generación del reporte de solicitud del pago
			var sm=getSelectionModel();
			var id_devengado=sm.getSelected().data.id_devengado;
			var tipo_desembolso=sm.getSelected().data.tipo_desembolso;
			//Imprime el reporte
			window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionDevengadoSolicitudFin.php?id_devengado='+id_devengado)
			//Fin RCM
			//Actualiza los datos
			CM_btnActualizar()
		}
	}

	this.btnEdit = function(){
		//Restituye los valores originales para almacenar los datos
		CM_getFormulario().url=direccion+'../../../control/devengado/ActionGuardarDevengarServicios.php?';
		
		Ext.MessageBox.hide();//ocultamos el loading
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			var id_devengado=sm.getSelected().data.id_devengado;
			Ext.Ajax.request({
				url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarModificacionDevengado.php?id_devengado='+id_devengado,
				method:'POST',
				success:exito_edit,
				failure:ClaseMadre_conexionFailure,
				timeout:100000
			})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	//RCM 06/01/2010: Funcion que bloquea o desbloquea los campos cuando se trata de pagos de importes ya comprometidos
	function desBloqPagComprometidos(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(SelectionsRecord.data.sw_pago_comprometido=='si'){
			//Bloquea componentes
			cmbConceptoIngas.disable();
			cmbMoneda.disable();
			txtImporteDevengado.disable();
			cmbDepto.disable();
		} else{
			//Desbloquea componentes
			cmbConceptoIngas.enable();
			cmbMoneda.enable();
			txtImporteDevengado.enable();
			cmbDepto.enable();
		}
		CM_getFormulario().submit();
	}

				
	function exito_edit(resp){
		var root = resp.responseXML.documentElement;
		var v_tot = root.getElementsByTagName('total_importe')[0].firstChild.nodeValue;
		//alert('tot: '+v_tot);
		if(v_tot>0){
			if(confirm("El Prorrateo ya fue registrado. Si modifica el Importe, todo el prorrateo será eliminado.\n\n ¿Está seguro de continuar?")){
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				if(SelectionsRecord.data.tipo_desembolso==2){
					//Cajas: muestra y oculta los grupos correspondientes
					CM_mostrarGrupo('Datos Caja');
					CM_mostrarGrupo('Datos');
					CM_ocultarGrupo('Tipo Pago')
					CM_ocultarGrupo('Cuenta Bancaria');
					CM_ocultarGrupo('Autorizacion');
					getComponente('id_empleado').allowBlank=true;
					//Define datos opcionales y obligatorios según corresponda
					cmbCaja.allowBlank=false;
					cmbCajero.allowBlank=false;
					cmbEmpCaja.allowBlank=false;
					cmbTipoPago.allowBlank=true;
					cmbTipoPlantilla.allowBlank=true;

					//Carga los datos para filtrar los datos de cajas
					fValues_caja[0]=SelectionsRecord.data.id_depto;
					fValues_caja[1]=SelectionsRecord.data.id_moneda;
					fValues_cajero[0]=SelectionsRecord.data.id_caja;
				} else{
					// Cheque o Transferencia Bancaria: Verifica si el tipo de pago es 'pago' o 'devengado'
					//Muestra y oculta los grupos correspondientes
					CM_mostrarGrupo('Tipo Pago');
					CM_mostrarGrupo('Datos');
					CM_ocultarGrupo('Datos Caja');
					CM_ocultarGrupo('Cuenta Bancaria');
					CM_ocultarGrupo('Autorizacion');
					getComponente('id_empleado').allowBlank=true;
					//Verifica el tipo de pago para esconder o no el tipo de documento
					if(sm.getSelected().data.tipo_pago=='devengado'){
						//Muestra y define como obligatorio el Tipo de Documento
						CM_mostrarComp(cmbTipoPlantilla);
						cmbTipoPlantilla.allowBlank=false;
					} else{
						//OCulta y define como opcional el Tipo de Documento
						cmbTipoPlantilla.allowBlank=true;
					}
					//Definción de datos obligatorios y opcionales
					cmbCaja.allowBlank=true;
					cmbCajero.allowBlank=true;
					cmbEmpCaja.allowBlank=true;
					cmbTipoPago.allowBlank=false;
					cmbTipoPlantilla.allowBlank=false;
					
					fValues_caja[0]=SelectionsRecord.data.id_depto;
					fValues_caja[1]=SelectionsRecord.data.id_moneda;
				}
				//RCM 06/01/2010: se aumenta la validacion para bloquear campos cuando sea pago de importes ya comprometidos en tesoreria
				desBloqPagComprometidos();
				CM_btnEdit();
			}
		}else {
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();
			var SelectionsRecord=sm.getSelected();

			if(SelectionsRecord.data.tipo_desembolso==2){
				//Cajas: muestra y oculta los grupos correspondientes
				CM_mostrarGrupo('Datos Caja');
				CM_mostrarGrupo('Datos');
				CM_ocultarGrupo('Tipo Pago')
				CM_ocultarGrupo('Cuenta Bancaria');
				CM_ocultarGrupo('Autorizacion');
				getComponente('id_empleado').allowBlank=true;
				//Define datos opcionales y obligatorios según corresponda
				cmbCaja.allowBlank=false;
				cmbCajero.allowBlank=false;
				cmbEmpCaja.allowBlank=false;
				cmbTipoPago.allowBlank=true;
				cmbTipoPlantilla.allowBlank=true;

				//Carga los datos para filtrar los datos de cajas
				fValues_caja[0]=SelectionsRecord.data.id_depto;
				fValues_caja[1]=SelectionsRecord.data.id_moneda;
				fValues_cajero[0]=SelectionsRecord.data.id_caja;
			} else{
				// Cheque o Transferencia Bancaria: Verifica si el tipo de pago es 'pago' o 'devengado'
				//Muestra y oculta los grupos correspondientes
				CM_mostrarGrupo('Tipo Pago');
				CM_mostrarGrupo('Datos');
				CM_ocultarGrupo('Datos Caja');
				CM_ocultarGrupo('Cuenta Bancaria');
				CM_ocultarGrupo('Autorizacion');
				getComponente('id_empleado').allowBlank=true;
				//Verifica el tipo de pago para esconder o no el tipo de documento
				if(sm.getSelected().data.tipo_pago=='devengado'){
					//Muestra y define como obligatorio el Tipo de Documento
					CM_mostrarComp(cmbTipoPlantilla);
					cmbTipoPlantilla.allowBlank=false;
				} else{
					//OCulta y define como opcional el Tipo de Documento
					cmbTipoPlantilla.allowBlank=true;
				}
				//Definción de datos obligatorios y opcionales
				cmbCaja.allowBlank=true;
				cmbCajero.allowBlank=true;
				cmbEmpCaja.allowBlank=true;
				cmbTipoPago.allowBlank=false;
				cmbTipoPlantilla.allowBlank=false;
			}
			//RCM 06/01/2010: se aumenta la validacion para bloquear campos cuando sea pago de importes ya comprometidos en tesoreria
			desBloqPagComprometidos();
			CM_btnEdit();
		}
	}

	function btn_det_pagos(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_devengado='+SelectionsRecord.data.id_devengado;
			data=data+'&m_desc_concepto_ingas='+SelectionsRecord.data.desc_concepto_ingas;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_importe_devengado='+SelectionsRecord.data.importe_devengado;
			data=data+'&m_importe_pagado='+SelectionsRecord.data.importe_pagado;
			data=data+'&m_importe_saldo='+SelectionsRecord.data.importe_saldo;
			data=data+'&m_tipo_devengado='+SelectionsRecord.data.desc_tipo_devengado;
			data=data+'&m_estado_devengado='+SelectionsRecord.data.desc_estado_devengado;
			data=data+'&m_desc_proveedor='+SelectionsRecord.data.desc_proveedor;
			data=data+'&tipoFormDev='+tipoFormDev;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_tipo_desembolso='+SelectionsRecord.data.tipo_desembolso;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_devengar_servicios.loadWindows(direccion+'../../../../sis_tesoreria/vista/devengar_servicios/devengar_pagar_det.php?'+data,'Detalle Pagos',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//this.getFormulario().addButton('Guardar Pago',GuardarTipoPago);
		//Captura los elementos del formulario
		v_importe_devengado=getComponente("importe_devengado");
		btn_pagos_efect = CM_getBoton('pagos_efect-'+idContenedor);
		cmbDepto=getComponente('id_depto');
		cmbMoneda=getComponente('id_moneda');
		cmbCaja=getComponente('id_caja');
		cmbCajero=getComponente('id_cajero');
		cmbTipoDesembolso=getComponente('tipo_desembolso');
		cmbEmpCaja=getComponente('id_emp_recep_caja');
		cmbPeriodoSubsis=getComponente('id_periodo_subsistema');
		dteFechaDeveng=getComponente('fecha_devengado');
		cmbEntregaDoc=getComponente('entrega_doc');
		cmbTipoPlantilla=getComponente('tipo_plantilla');
		cmbTipoPago=getComponente('tipo_pago');
		cmbCueBan=getComponente('id_cuenta_bancaria');
		cmbConceptoIngas=getComponente('id_concepto_ingas');
		txtImporteDevengado=getComponente('importe_devengado');
		cmbParametro=getComponente('id_parametro');
		cmbProveedor=getComponente('id_proveedor');
		
		//Definición de Formato inicial de los Componentes
		v_importe_devengado.getEl().setStyle("text-align","right");
		
		//Define id_gestion a un valor no encontrado para que no despliegue ningún concepto ano ser que escoja primeramente gestión
		cmbConceptoIngas.store.baseParams={id_gestion:-1};
		cmbProveedor.store.baseParams={id_gestion:-1};
		cmbPeriodoSubsis.store.baseParams={tesoro:1,m_id_subsistema:12,m_estado_periodo:'abierto',id_gestion:-1};

		//Se oculta los datos de Caja
		CM_ocultarGrupo('Tipo Pago');
		CM_ocultarGrupo('Datos Caja');
		CM_ocultarGrupo('Cuenta Bancaria');
		CM_ocultarGrupo('Autorizacion');
		getComponente('id_empleado').allowBlank=true;
		CM_ocultarComp(cmbTipoPlantilla);

		//Funciones de Eventos
		var f_cambio_depto = function(e) {
			var id = cmbDepto.getValue();
			if(id=='') id='x';
			cmbCaja.filterValues[0]=id;
			cmbCaja.setValue('');
			cmbCaja.modificado=true
		};

		var f_cambio_moneda = function(e) {
			var id = cmbMoneda.getValue();
			if(id=='') id='x';
			cmbCaja.filterValues[1]=id;
			cmbCaja.setValue('');
			cmbCaja.modificado=true
		};

		var f_cambio_caja = function(e) {
			var id = cmbCaja.getValue();
			if(id=='') id='x';
			cmbCajero.filterValues[0]=id;
			cmbCajero.setValue('');
			cmbCajero.modificado=true
		};

		var f_datos_caja = function(e){
			var id = cmbTipoDesembolso.getValue();
			if(id==2){
				//Cajas; muestra los datos del Cajas  y oculta los otros para cheque
				CM_mostrarGrupo('Datos Caja');
				CM_ocultarGrupo('Tipo Pago');
				CM_ocultarGrupo('Autorizacion');
				getComponente('id_empleado').allowBlank=true;
				//Define como obligatorios los datos de caja y como opcionales los de cheque
				cmbCaja.allowBlank=false;
				cmbCajero.allowBlank=false;
				cmbEmpCaja.allowBlank=false;
				cmbTipoPago.allowBlank=true;
				cmbTipoPlantilla.allowBlank=true;
				
				fValues_caja[0]=cmbDepto.getValue();
				fValues_caja[1]=cmbMoneda.getValue();
			} else{
				//Cheques; ocultar combos caja y cajero y definirlos como opcionales
				CM_ocultarGrupo('Datos Caja');
				CM_mostrarGrupo('Tipo Pago');
				CM_ocultarGrupo('Autorizacion');
				getComponente('id_empleado').allowBlank=true;
				CM_ocultarComp(cmbTipoPlantilla);
			
				//Define como opcionales
				cmbCaja.allowBlank=true;
				cmbCajero.allowBlank=true;
				cmbEmpCaja.allowBlank=true;
				cmbTipoPago.allowBlank=false;
				cmbTipoPlantilla.allowBlank=true;
			}
		};
		
		var f_validar_fecha = function(e){
			var id = cmbPeriodoSubsis.getValue();
			var regPerSub,fechaIni,fechaFin;
			if(id!=''){
				regPerSub = cmbPeriodoSubsis.store.getById(id);
				fechaIni=regPerSub.data.fecha_inicio;
				fechaFin=regPerSub.data.fecha_final;
				
				dteFechaDeveng.minValue=fechaIni;
				dteFechaDeveng.maxValue=fechaFin;
				dteFechaDeveng.setValue(fechaIni);
			}
		};

		var f_tipo_pago = function(e){
			var id = cmbTipoPago.getValue();
			if(id=='pago'){
				CM_ocultarComp(cmbTipoPlantilla);
				cmbTipoPlantilla.allowBlank=true;

			} else{
				CM_mostrarComp(cmbTipoPlantilla);
				cmbTipoPlantilla.allowBlank=false;
			}
		};
		
		//Definición de Eventos de los Componentes
		cmbDepto.on('change',f_cambio_depto);
		cmbMoneda.on('change',f_cambio_moneda);
		cmbCaja.on('change',f_cambio_caja);
		cmbCaja.on('select',f_cambio_caja);
		cmbTipoDesembolso.on('change',f_datos_caja);
		cmbTipoDesembolso.on('select',f_datos_caja);
		cmbPeriodoSubsis.on('change',f_validar_fecha);
		cmbPeriodoSubsis.on('select',f_validar_fecha);
		cmbTipoPago.on('change',f_tipo_pago);
		cmbTipoPago.on('select',f_tipo_pago);
		cmbParametro.on('select',evento_parametro); //salta al seleccionar la gestion

		//evento de deselecion de una linea de grid
		getSelectionModel().on('rowdeselect',function(){
			if(_CP.getPagina(layout_devengar_servicios.getIdContentHijo()).pagina.limpiarStore()){
				_CP.getPagina(layout_devengar_servicios.getIdContentHijo()).pagina.bloquearMenu()
			}
		})
	}
	
	function evento_parametro( combo, record, index ){		
		//Filtramos los presupuestos segun la gestion seleccionada
		cmbConceptoIngas.store.baseParams={sw_tesoro:6,id_gestion:record.data.id_gestion};
		cmbConceptoIngas.modificado=true;			
		cmbConceptoIngas.setValue('');			
		cmbConceptoIngas.setDisabled(false);						
		
		cmbProveedor.store.baseParams={id_gestion:record.data.id_gestion};
		cmbProveedor.modificado=true;			
		cmbProveedor.setValue('');			
		cmbProveedor.setDisabled(false);
		
		cmbPeriodoSubsis.store.baseParams={tesoro:1,m_id_subsistema:12,m_estado_periodo:'abierto',id_gestion:record.data.id_gestion};
		cmbPeriodoSubsis.modificado=true;			
		cmbPeriodoSubsis.setValue('');			
		cmbPeriodoSubsis.setDisabled(false);
 	}

	function f_contabilizar() {
		var sm=getSelectionModel();
		if(sm.getCount()!=0) {
			var id_devengado=sm.getSelected().data.id_devengado;
			//alert('id_devengado:'+id_devengado);
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionObtenerAprobacionProrrateo.php?id_devengado='+id_devengado,
						method:'POST',
						//success:Ext.MessageBox.alert("alerta","entra"),
						success:verifAprobPro,
						//failure:ClaseMadre_conexionFailure,
						timeout:100000
					})
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	function btnContabilizar(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			if(confirm('¿Está seguro de Contabilizar?')){
				if(tipoFormDev=='dev'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionContabilizarDevengado.php?id_devengado='+id_devengado,
						method:'POST',
						success:exito_cont,
						timeout:100000
					})
				}else if(tipoFormDev=='desc'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarImporteDocumento.php?id_devengado='+id_devengado,
						method:'POST',
						success:f_exito_cont_regulariz,
						failure:CM_conexionFailure,
						timeout:100000
					})
				}else{
					alert('No se puede contabilizar en esta opción');
				}
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	function verifAprobPro(resp){
		//Verifiación de acción a realizar
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			//alert("llegaassss");
			
			if(root.getElementsByTagName('aprobado')[0].firstChild.nodeValue=='1'){
				//alert('Prorrateo aprobado');
				btnContabilizar();
			}else{ 
				alert('Prorrateo NO aprobado');
			}
		}
	}
	
	function GuardarTipoPago(){
		//if(sm.getCount()!=0){
			if(confirm('¿Está seguro de Contabilizar?')){
				if(tipoFormDev=='dev'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionContabilizarDevengado.php?id_devengado='+id_devengado,
						method:'POST',
						success:exito_cont,
						timeout:100000
					})
				}else if(tipoFormDev=='desc'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarImporteDocumento.php?id_devengado='+id_devengado,
						method:'POST',
						success:f_exito_cont_regulariz,
						failure:CM_conexionFailure,
						timeout:100000
					})
				}else{
					alert('No se puede contabilizar en esta opción');
				}
			}
	}
	
	function pago(){
		var ParamVentana={Ventana:{width:370,height:255}};
		layout_devengar_servicios.loadWindows(direccion+'../../../../sis_contabilidad/vista/emite_cheque/emite_cheque.php?'+datos_pago,'Cheques',ParamVentana)
	}
	
	function devengado(){
		CM_mostrarGrupo('Datos Caja');
	}

	function btnContabilizar_anterior(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			if(confirm('¿Está seguro de Contabilizar?')){
				if(tipoFormDev=='dev'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionContabilizarDevengado.php?id_devengado='+id_devengado,
						method:'POST',
						success:exito_cont,
						timeout:100000
					})
				}else if(tipoFormDev=='desc'){
					var id_devengado=sm.getSelected().data.id_devengado;
					Ext.Ajax.request({
						url:direccion+'../../../../sis_tesoreria/control/devengado/ActionVerificarImporteDocumento.php?id_devengado='+id_devengado,
						method:'POST',
						success:f_exito_cont_regulariz,
						failure:CM_conexionFailure,
						timeout:100000
					})
				}else{
					alert('No se puede contabilizar en esta opción');
				}
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	function exito_cont(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			CM_btnActualizar()
		}
	}

	function f_exito_cont_regulariz(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var v_existe_doc = root.getElementsByTagName('existe')[0].firstChild.nodeValue;

		if(v_existe_doc == 0){
			Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: previamente debe registrar el/los Documento(s) de respaldo');
		}else if(v_existe_doc == 1){
			var sm=getSelectionModel();
			var id_devengado=sm.getSelected().data.id_devengado;
			Ext.Ajax.request({
				url:direccion+'../../../../sis_tesoreria/control/devengado/ActionContabilizarDevengadoRegulariz.php?id_devengado='+id_devengado,
				method:'POST',
				success:f_exito_regulariz,
				timeout:100000
			})
			Ext.MessageBox.alert('Estado', 'Generando el Comprobante Contable');
		}else if(v_existe_doc == 2){
			Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: debe completar los datos del(os) Documento(s)');
		}else if(v_existe_doc == 3){
			Ext.MessageBox.alert('Estado', 'No es posible Contabilizar el Pago: El total de los documentos registrados no cubre con el pago');
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			//Imprime el reporte
			/*var sm=getSelectionModel();
			var id_devengado=sm.getSelected().data.id_devengado;
			window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionDevengadoSolicitudFin.php?id_devengado='+id_devengado)*/
			CM_btnActualizar()
		}
	}

	function f_exito_regulariz(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			CM_btnActualizar()
		}
	}
	
	function btn_fin_sol(){
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		if(sm.getCount()!=0) {
			var id_devengado=sm.getSelected().data.id_devengado;
			//alert('id_devengado:'+id_devengado);
			if(confirm('¿Está seguro de Finalizar la Solicitud?')){
				CM_getFormulario().success=fun_finaliza_sol;
				CM_getFormulario().failure=ClaseMadre_conexionFailure;
				CM_getFormulario().timeout=100000;
				CM_ocultarGrupo('Cuenta Bancaria');
				
				// Oculta los demás grupos
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Datos Caja');
				CM_ocultarGrupo('Tipo Pago');
				CM_mostrarGrupo('Autorizacion');
				
				if(SelectionsRecord.data.tipo_desembolso==2){
					cmbTipoPago.allowBlank=true;
				}else{
					cmbTipoPago.allowBlank=false;
				}
				
				
				ds_empleado.modificado=true;
				ds_empleado.baseParams={
					autorizacion:'si',
					tipo:'devengados',
					monto_total:SelectionsRecord.data.importe_devengado,
					id_parametro:SelectionsRecord.data.id_parametro,
					id_empleado:0
				}
				ds_empleado.modificado=true;
				CM_getFormulario().url=direccion+'../../../../sis_tesoreria/control/devengado/ActionFinalizarSolicitudDevengado.php';
				CM_btnEdit();
				Ext.MessageBox.hide();
				getComponente('id_parametro').setValue(SelectionsRecord.data.id_parametro);
				getComponente('id_parametro').setRawValue(SelectionsRecord.data.id_parametro);
				getComponente('id_parametro').allowBlank=true;
			}
		} else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
		
	}
	
	function fun_finaliza_sol(resp){ 
		Ext.MessageBox.hide();
	    CM_ocultarFormulario();
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		if(sm.getCount()!=0) {
			var id_devengado=sm.getSelected().data.id_devengado;
			var root = resp.responseXML.documentElement;
			var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
			if(error=='1'){
				Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
				return;
			} else {
				Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
				
				//Impresión del reporte
				window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionDevengadoSolicitudFin.php?id_devengado='+id_devengado)
			}
			CM_btnActualizar();	
		}
	}
	
	function btnRegDatosDesem(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();

		if(NumSelect==1){
			// Define temporalmente el Action para el registro de los datos para el desembolso
			CM_getFormulario().url=direccion+'../../../control/devengado/ActionRegistrarDesemDevengado.php';
			
			//Verifica si pide o no la cuenta bancaria para el cheque
			if(SelectionsRecord.data.tipo_pago=='pago'){
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_mostrarGrupo('Cuenta Bancaria');
				
				// Oculta los demás grupos
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Datos Caja');
				CM_ocultarGrupo('Tipo Pago');
				CM_ocultarGrupo('Autorizacion');
				//Define como obligatorio y opcional los datos correspondientes
				cmbTipoPlantilla.allowBlank=true;
				cmbTipoPago.allowBlank=true;
				cmbCueBan.allowBlank=false;
				cmbParametro.allowBlank=true;

				// Llamamos a la función sobrecarga del Edit
				CM_btnEdit();
			} else{
				Ext.MessageBox.alert('Información','Proceda directamente con la Finalización de la Solicitud.');
				return;
			}
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}

	
	
	this.btnNew = function(){
		//Restituye los valores originales para almacenar los datos
		CM_getFormulario().url=direccion+'../../../control/devengado/ActionGuardarDevengarServicios.php?';
		
		//Esconde y muestra los grupos correspondientes
		CM_mostrarGrupo('Datos');
		CM_ocultarGrupo('Tipo Pago');
		CM_ocultarGrupo('Cuenta Bancaria');
		CM_ocultarGrupo('Datos Caja');
		CM_ocultarGrupo('Autorizacion');
		getComponente('id_empleado').allowBlank=true;
		cmbTipoPlantilla.allowBlank=true;
		CM_ocultarComp(cmbTipoPlantilla);
		
		//Desbloquea componentes
		cmbConceptoIngas.enable();
		cmbMoneda.enable();
		txtImporteDevengado.enable();
		cmbDepto.enable();
		ds_empleado.modificado=true;
		ds_empleado.baseParams={
				autorizacion:'no'
			}
		ds_empleado.modificado=true;
		//Ejecución función de inserción
		CM_btnNew();
	}
	
	function btn_cor_sol(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(confirm('¿Está seguro de Corregir la Solicitud?')){
				Ext.MessageBox.show({
					title: 'Procesando solicitud',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Enviando registro a estado anterior y revirtiendo Presupuesto...</div>",
					width:300,
					height:200,
					closable:false
				});
				var SelectionsRecord=sm.getSelected();
				//Llamda asincrona para ejecutar la correcion de la solicitud
				Ext.Ajax.request({
					url:direccion+'../../../../sis_tesoreria/control/devengado/ActionCorregirSolicitudDevengado.php',
					method:'POST',
					params:{cantidad_ids:'1',id_devengado:SelectionsRecord.data.id_devengado},
					success: function(resp){
						Ext.MessageBox.hide();
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
						
						CM_btnActualizar();
					},
					failure:ClaseMadre_conexionFailure,
					timeout:100000
				})
			}
		} else{
			Ext.MessageBox.alert('Correccion de Solicitud','Seleccione el registro para la correccion y vuelva a presionar el boton.');
		}
	}
	
	function btn_otros_gastos(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_devengado='+SelectionsRecord.data.id_devengado;
			data=data+'&m_desc_concepto_ingas='+SelectionsRecord.data.desc_concepto_ingas;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_importe_devengado='+SelectionsRecord.data.importe_devengado;
			data=data+'&m_tipo_devengado='+SelectionsRecord.data.desc_tipo_devengado;
			data=data+'&m_estado_devengado='+SelectionsRecord.data.desc_estado_devengado;
			data=data+'&tipoFormDev='+tipoFormDev;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_devengar_servicios.loadWindows(direccion+'../../../../sis_tesoreria/vista/devengado_concepto/devengado_concepto.php?'+data,'Otros Conceptos Gasto',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengar_servicios.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//Crea los botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Prorrateo',btn_devengado_detalle,false,'dev_det','Prorrateo');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Registro de Facturas y/o Recibos',btn_devengado_dcto,false,'docs','Facturas/Recibos');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Pagos',btn_det_pagos,false,'pag_ef','Pagos');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Solicitud',btn_fin_sol,false,'fin_sol','Finalizar Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/book_previous.png','Corregir Solicitud',btn_cor_sol,false,'cor_sol','Corregir Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Datos Desembolso',btnRegDatosDesem,false,'reg_desem','Datos Desembolso');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Enviar a Contabilidad',btnContabilizar,false, 'con_dev','Enviar a Contabilidad');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar',btn_fin_dev,false,'fin_dev','Finalizar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Impresión de Solicitud de Pago',btn_rep,false,'reimp_dev','Impresión Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Otros Conceptos Gasto',btn_otros_gastos,false,'otro_gasto','Otros Conceptos Gasto');

	var CM_getBoton=this.getBoton;
	//Oculta definitivamente el botón de registro de facturas
	CM_getBoton('docs-'+idContenedor).hide();
	
	CM_getBoton('cor_sol-'+idContenedor).disable();
	//para agregar botones
	if(tipoFormDev=='dev'){
		//Deshabilita de inicio el botón de Registro de Pagos, de Documentos y de Finalización
		CM_getBoton('dev_det-'+idContenedor).hide();
		CM_getBoton('con_dev-'+idContenedor).disable();
		CM_getBoton('fin_dev-'+idContenedor).disable();
		CM_getBoton('fin_sol-'+idContenedor).disable();
		CM_getBoton('reg_desem-'+idContenedor).disable();

		//Oculta los botones que no se utilizaran
		CM_getBoton('docs-'+idContenedor).hide();
		CM_getBoton('pag_ef-'+idContenedor).hide();
		//CM_getBoton('reimp_dev-'+idContenedor).hide();
		
	}else if(tipoFormDev=='pag'){
		//Deshabilita de inicio el botón de Registro de Pagos, de Documentos y de Finalización
		CM_getBoton('dev_det-'+idContenedor).enable();
		CM_getBoton('docs-'+idContenedor).hide();
		CM_getBoton('pag_ef-'+idContenedor).hide();

		//Oculta los botones que no se utilizaran
		CM_getBoton('con_dev-'+idContenedor).hide();
		CM_getBoton('fin_dev-'+idContenedor).hide();
		CM_getBoton('reimp_dev-'+idContenedor).hide();
		CM_getBoton('fin_sol-'+idContenedor).hide();
		CM_getBoton('reg_desem-'+idContenedor).hide();

	}else if(tipoFormDev=='fin'){
		//Oculta los botones que no se utilizaran
		CM_getBoton('pag_ef-'+idContenedor).hide();
		CM_getBoton('con_dev-'+idContenedor).hide();
		CM_getBoton('fin_dev-'+idContenedor).hide();
		CM_getBoton('fin_sol-'+idContenedor).hide();
		CM_getBoton('reg_desem-'+idContenedor).hide();

	}else if(tipoFormDev=='aprob'){
		//Oculta los botones que no se utilizaran
		CM_getBoton('con_dev-'+idContenedor).hide();
		CM_getBoton('fin_dev-'+idContenedor).hide();
		CM_getBoton('docs-'+idContenedor).hide();
		CM_getBoton('pag_ef-'+idContenedor).hide();
		CM_getBoton('reimp_dev-'+idContenedor).hide();
		CM_getBoton('fin_sol-'+idContenedor).hide();
		CM_getBoton('reg_desem-'+idContenedor).hide();

	}else if(tipoFormDev=='desc'){
		//Oculta los botones que no se utilizaran
		CM_getBoton('fin_dev-'+idContenedor).hide();
		CM_getBoton('reimp_dev-'+idContenedor).hide();
	}

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_devengar_servicios.getLayout().addListener('layout',this.onResize);//arregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
