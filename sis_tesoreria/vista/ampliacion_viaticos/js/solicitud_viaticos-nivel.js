/**
 * Nombre:		  	    pagina_solicitud_viaticos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
 */
function pagina_solicitud_viaticos(idContenedor,direccion,paramConfig){
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
		'id_financiador','id_regional',
		'id_programa','id_proyecto',
		'id_actividad','nombre_financiador',
		'nombre_regional','nombre_programa',
		'nombre_proyecto','nombre_actividad',
		'codigo_financiador','codigo_regional',
		'codigo_programa','codigo_proyecto',
		'id_fina_regi_prog_proy_acti',
		'codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_empleado',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'desc_empleado',
		'id_categoria',
		'desc_categoria',
		'id_destino',
		'nombre_lugar',
		'desc_destino',
		'nro_dias',
		'id_cobertura',
		'desc_cobertura',
		'id_moneda',
		'desc_moneda',
		'importe_pasaje',
		'importe_viatico',
		'total_viatico',
		'importe_hotel',
		'total_hotel',
		'importe_otros',
		'total_otros',
		'id_concepto_pasaje',
		'total_general',
		'desc_ingas_concepto_pasaje',
		'desc_concepto_pasaje',
		'id_concepto_viatico',		
		'desc_ingas_concepto_viatico',
		'desc_concepto_viatico',
		{name: 'fecha_inicio',type:'date',dateFormat:'m-d-Y'},
		{name: 'fecha_final',type:'date',dateFormat:'m-d-Y'}, //Y-m-d
		'hora_inicio',
		'hora_final',
		'id_cuenta_bancaria', 
		'nombre_institucion',
		'nro_cuenta_banco_cuenta_bancaria',
		'desc_cuenta_bancaria',
		'nombre_cheque',
		'estado_viatico',
		{name: 'fecha_solicitud',type:'date',dateFormat:'m-d-Y'},
		'num_solicitud',
		'id_origen',
		'lugar_origen',
		'detalle_viaticos',
		'motivo_viaje',
		'id_entidad',
		'nombre_entidad',
		'tipo_viaje',
		'detalle_otros',
		'sw_retencion',
		'sw_cheque',
		'id_cheque',
		'id_comprobante',
		'id_caja',
		'desc_caja',
        'id_cajero',
        'desc_cajero',
        'importe_regis',
        'concepto_regis',
		'sw_contabilizar'
		
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado'])
	});

    var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/categoria/ActionListarCategoria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria'])
	});

    var ds_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar'])
	});

    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','sw_dias'])
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
	
	var ds_origen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_destino','desc_lugar'])
	});
	
	var ds_entidad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/entidad/ActionListarEntidad.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords: 'TotalCount'},['id_entidad','desc_institucion'])
	});

	 var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','desc_caja','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
    
	//FUNCIONES RENDER
	
		function render_id_unidad_organizacional(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_unidad_organizacional']+ '</span>');}else{return String.format('{0}', record.data['desc_unidad_organizacional']);}}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');

		function render_id_empleado(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_empleado']+ '</span>');}else{return String.format('{0}', record.data['desc_empleado']);}}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

		function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
		var tpl_id_categoria=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria}</b></i><br>','</div>');

		function render_id_destino(value, p, record){return String.format('{0}', record.data['desc_destino']);}
		var tpl_id_destino=new Ext.Template('<div class="search-item">','<b><i>{desc_lugar}</b></i>','</div>');
		
		function render_id_origen(value, p, record){return String.format('{0}', record.data['lugar_origen']);}
		var tpl_id_origen=new Ext.Template('<div class="search-item">','<b><i>{desc_lugar}</b></i>','</div>');

		function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
		var tpl_id_cobertura=new Ext.Template('<div class="search-item">','<b><i>{porcentaje}</b></i><br>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i><br>','</div>');

		function render_id_concepto_pasaje(value, p, record){return String.format('{0}', record.data['desc_concepto_pasaje']);}
		var tpl_id_concepto_pasaje=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_concepto_viatico(value, p, record){return String.format('{0}', record.data['desc_concepto_viatico']);}
		var tpl_id_concepto_viatico=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i><br>','<FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT>','</div>');

		function render_id_entidad(value, p, record){return String.format('{0}', record.data['nombre_entidad']);}
		var tpl_id_entidad=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i>','</div>');
		
		function render_id_caja(value, p, record){if(record.get('id_subsistema')!=''){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_caja']+ '</span>');}else{return String.format('{0}', record.data['desc_caja']);}}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){if(record.get('id_subsistema')!=''){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_cajero']+ '</span>');}else{return String.format('{0}', record.data['desc_cajero']);}}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
			
		function render_num_solicitud(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['num_solicitud']+ '</span>');}else{return String.format('{0}', record.data['num_solicitud']);}}
		//function render_unidad_organizacional(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['num_solicitud']+ '</span>');}else{return String.format('{0}', record.data['num_solicitud']);}}
		
	function renderEstado(value, p, record)
	{
		if(value == 1)
		{return "Pendiente"}
		if(value == 2)
		{return "Descargo"}
		if(value == 3)
		{return "Cerrado"}
		return 'Otro';
	}
	
	function renderTipoViaje(value, p, record)
	{
		if(value == 1)
		{return "Aéreo"}
		if(value == 2)
		{return "Terrestre"}		
		return 'Otro';
	}
	
	function renderRetencion(value, p, record)
	{
		if(value == 1)
		{return "Si"}
		if(value == 2)
		{return "No"}		
		return 'Otro';
	}
	
	function renderCheque(value, p, record)
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
// txt id_fina_regi_prog_proy_acti
	Atributos[1]={
		validacion:{
			fieldLabel:'Estructura Programática',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:0
		};
// txt id_unidad_organizacional
	Atributos[2]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
		id_grupo:0
	};
// txt id_empleado
	Atributos[3]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:false,			
			emptyText:'Empleado...',
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
		filterColValue:'PERSON_3.apellido_paterno#PERSON_3.apellido_materno#PERSON_3.nombre',
		save_as:'id_empleado',
			id_grupo:0
	};
// txt id_categoria
	Atributos[4]={
			validacion:{
			name:'id_categoria',
			fieldLabel:'Categoría',
			allowBlank:false,			
			emptyText:'Categoría...',
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
			onSelect:function(record){componentes[4].setValue(record.data.id_categoria);componentes[4].collapse();ds_origen.baseParams={m_id_categoria:record.data.id_categoria};ds_origen.load();componentes[5].reset();ds_destino.baseParams={m_id_categoria:record.data.id_categoria};ds_destino.load();componentes[6].reset();},
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.desc_categoria',
		save_as:'id_categoria',
			id_grupo:2
	};
	
	// txt id_destino
	Atributos[5]={
			validacion:{
			name:'id_origen',
			fieldLabel:'Origen',
			allowBlank:false,			
			emptyText:'Origen...',
			desc: 'lugar_origen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_origen,			
			valueField: 'id_destino',
			displayField: 'desc_lugar',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR2.nombre',
			typeAhead:true,
			tpl:tpl_id_origen,
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
			renderer:render_id_origen,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			grid_indice:6,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGARR2.nombre',
		save_as:'id_origen',
		id_grupo:2
	};
	
// txt id_destino
	Atributos[6]={
			validacion:{
			name:'id_destino',
			fieldLabel:'Destino',
			allowBlank:false,			
			emptyText:'Destino...',
			desc: 'desc_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_destino,
			valueField: 'id_destino',
			displayField: 'desc_lugar',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead:true,
			tpl:tpl_id_destino,
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
			renderer:render_id_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGARR_5.nombre',
		save_as:'id_destino',
			id_grupo:2
	};
// 
// txt id_cobertura
	Atributos[7]={
			validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura',
			allowBlank:false,			
			emptyText:'Cobertura...',
			desc: 'desc_cobertura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,
			valueField: 'id_cobertura',
			displayField: 'porcentaje',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.porcentaje',
			onSelect:function(record){componentes[7].setValue(record.data.id_cobertura);componentes[7].collapse();if(record.data.sw_hotel==2){componentes[13].setDisabled(true)}else{componentes[13].setDisabled(false)} validarDias();},
			typeAhead:true,
			tpl:tpl_id_cobertura,
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
			renderer:render_id_cobertura,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.porcentaje',
		save_as:'id_cobertura',
		id_grupo:2
	};
	
	// txt fecha_inicio
	Atributos[8]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Salida',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:10		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio',
			id_grupo:2
	};
	
// txt id_moneda
	Atributos[9]={
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
			onSelect:function(record){if(valida_datos()){componentes[9].setValue(record.data.id_moneda);componentes[9].collapse();get_importes();}else{componentes[9].collapse();Ext.MessageBox.alert('Estado', 'Inserte los campos anteriores primero');}},
			width_grid:80,
			width:'100%',
			disabled:false,
			grid_indice:23		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
			id_grupo:3
	};
// txt importe_pasaje
	Atributos[10]={
		validacion:{
			name:'importe_pasaje',
			fieldLabel:'Importe Pasaje',
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
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:16		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIATIC.importe_pasaje',
		save_as:'importe_pasaje',
			id_grupo:3
	};
// txt importe_viatico
	Atributos[11]={
		validacion:{
			name:'importe_viatico',
			fieldLabel:'Importe Viático',
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
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:17		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIATIC.importe_viatico',
		save_as:'importe_viatico',
			id_grupo:3
	};
// txt total_viatico
	Atributos[12]={
		validacion:{
			name:'total_viatico',
			fieldLabel:'Total Viático',
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
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:18		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIATIC.total_viatico',
		save_as:'total_viatico',
			id_grupo:3
	};
// txt importe_hotel
	Atributos[13]={
		validacion:{
			name:'importe_hotel',
			fieldLabel:'Importe Hotel',
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
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:19		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		
		filterColValue:'VIATIC.importe_hotel',
		save_as:'importe_hotel',
			id_grupo:3
	};
// txt total_hotel
	Atributos[14]={
		validacion:{
			name:'total_hotel',
			fieldLabel:'Total Hotel',
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
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:20		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		
		filterColValue:'VIATIC.total_hotel',
		save_as:'total_hotel',
			id_grupo:3
	};
// txt importe_otros
	Atributos[15]={
		validacion:{
			name:'importe_otros',
			fieldLabel:'Otros Importes',
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
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:21		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		
		filterColValue:'VIATIC.importe_otros',
		save_as:'importe_otros',
			id_grupo:3
	};
// txt total_otros
	Atributos[16]={
		validacion:{
			name:'total_general',
			fieldLabel:'Total General',
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
			width_grid:100,
			width:'100%',
			disabled:true,
			grid_indice:22		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIATIC.total_otros',
		
		save_as:'total_general',
			id_grupo:3
	};
// txt id_concepto_pasaje
	Atributos[17]={
			validacion:{
			name:'id_concepto_pasaje',
			fieldLabel:'Concepto Pasaje',
			allowBlank:false,			
			emptyText:'Concepto Pasaje...',
			desc: 'desc_concepto_pasaje', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida#CONING.desc_ingas',
			typeAhead:true,
			tpl:tpl_id_concepto_pasaje,
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
			renderer:render_id_concepto_pasaje,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:24		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID_16.desc_partida#CONING_16.desc_ingas',
		save_as:'id_concepto_pasaje',
			id_grupo:1
	};
// txt id_concepto_viatico
	Atributos[18]={
			validacion:{
			name:'id_concepto_viatico',
			fieldLabel:'Concepto Viático',
			allowBlank:false,			
			emptyText:'Concepto Viático...',
			desc: 'desc_concepto_viatico', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida#CONING.desc_ingas',
			typeAhead:true,
			tpl:tpl_id_concepto_viatico,
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
			renderer:render_id_concepto_viatico,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:25		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID_17.desc_partida#CONING_17.desc_ingas',
		save_as:'id_concepto_viatico',
			id_grupo:1
	};
	
	
// txt fecha_final
	Atributos[19]= {
		validacion:{
			name:'fecha_final',
			fieldLabel:'Fecha Retorno',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:11		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'VIATIC.fecha_final',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_final',
			id_grupo:2
	};
	
//	txt nro_dias
	Atributos[20]={
		validacion:{
			name:'nro_dias',
			fieldLabel:'Nº de Días',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:true,
			grid_indice:12		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIATIC.nro_dias',
		save_as:'nro_dias',
			id_grupo:2
	};
	
// txt id_cuenta_bancaria
	Atributos[21]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
			emptyText:'Cuenta Bancaria...',
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
			width:'100%',
			disabled:false,
			grid_indice:28		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT_0.nombre#CUEBAN_0.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:4
		
	};
// txt nombre_cheque
	Atributos[22]={
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
			id_grupo:4
	};
	
	Atributos[23]={
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'tipo'
	};
	
	// txt estado_avance
	Atributos[24]={
		validacion:{
			name:'estado_viatico',
			fieldLabel:'Estado Viático',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Pendiente'],['2','Viático'],['3','Cerrado']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_indice:26,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		id_grupo:5,
		filterColValue:'VIATIC.estado_viatico'		
	};
	
	//hora de inspeccion
	Atributos[25]={
		validacion:{
			name: 'hora_inicio',
			fieldLabel: 'Hora Salida',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'center',
			width: 50,
			grid_visible:false, 
			grid_editable:false, 
			width_grid:110, 
			vtype:'time'
		},
		tipo: 'TextField',
		filtro_0:true,	
		save_as:'hora_inicio',
		id_grupo:2
	};
	
	//hora de inspeccion
	Atributos[26]={
		validacion:{
			name: 'hora_final',
			fieldLabel: 'Hora Retorno',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'center',
			width: 50,
			grid_visible:false, 
			grid_editable:false, 
			width_grid:110, 
			vtype:'time'
		},
		tipo: 'TextField',
		filtro_0:false,		
		save_as:'hora_final',
		id_grupo:2
	};	
	
	// txt fecha_inicio
	Atributos[27]= {
		validacion:{
			name:'fecha_solicitud',
			fieldLabel:'Fecha Solicitud',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
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
		id_grupo:0
	};
	
	// txt justificacion
	Atributos[28]={
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
		id_grupo:0,
		filtro_0:true,
		filterColValue:'VIATIC.num_solicitud',
		save_as:'num_solicitud'
	};
	
	
	
	// txt justificacion
	Atributos[29]={
		validacion:{
			name:'detalle_viaticos',
			fieldLabel:'Detalle Viáticos',
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
		filtro_0:true,
		filterColValue:'VIATIC.detalle_viaticos',
		save_as:'detalle_viaticos'
	};
	
	// txt justificacion
	Atributos[30]={
		validacion:{
			name:'motivo_viaje',
			fieldLabel:'Motivo Viaje',
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
		filterColValue:'VIATIC.motivo_viaje',
		save_as:'motivo_viaje'
	};
	
	// txt estado_avance
	Atributos[31]={
		validacion:{
			name:'tipo_viaje',
			fieldLabel:'Tipo Viaje',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Aéreo'],['2','Terrestre']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoViaje,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_indice:14,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		id_grupo:2,
		filtro_0:false,
		filterColValue:'VIATIC.tipo_viaje'		
	};
	
	// txt id_destino
	Atributos[32]={
			validacion:{
			name:'id_entidad',
			fieldLabel:'Empresa',
			allowBlank:false,			
			emptyText:'Empresa...',
			desc: 'nombre_entidad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_entidad,
			valueField: 'id_entidad',
			displayField: 'desc_institucion',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_entidad,
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
			renderer:render_id_entidad,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:15		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		save_as:'id_entidad',
		id_grupo:2
	};	
	
	// txt justificacion
	Atributos[33]={
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
		id_grupo:3,
		filtro_0:true,
		filterColValue:'VIATIC.detalle_otros',
		save_as:'detalle_otros'
	};
	
	// txt estado_avance
	Atributos[34]={
		validacion:{
			name:'sw_retencion',
			fieldLabel:'Retención',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Si'],['2','No']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderRetencion,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_indice:13,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'VIATIC.sw_retencion'		
	};
	
	// txt sw_cheque
	Atributos[35]={
		validacion:{
			name:'sw_cheque',
			fieldLabel:'Tipo de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Cheque'],['2','Efectivo']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderCheque,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_indice:27,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'VIATIC.sw_cheque'		
	};

	Atributos[36]={
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
	Atributos[37]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:true,			
			emptyText:'Caja...',
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
				componentes[37].setValue(record.data.id_caja);
				componentes[37].collapse();
				componentes[38].clearValue();
				ds_cajero.baseParams.m_id_caja=record.data.id_caja;
				componentes[38].modificado=true							
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
		filtro_0:true,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
		save_as:'id_caja',
		id_grupo:6
	};
// txt id_cajero
	Atributos[38]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:true,			
			emptyText:'Cajero...',
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
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:30		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:6	
	};
// txt id_empleado
	Atributos[39]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			emptyText:'id_empleado...',
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
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:true,
			grid_indice:31		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_2.nombre_completo#PROVEE.desc_proveedor',
		save_as:'id_empleado_vale',
		id_grupo:6	
	};
// txt importe_regis
	Atributos[40]={
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
		id_grupo:6	
	};
	// txt nombre_unidad
	Atributos[41]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Concepto Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			disabled:true,
			grid_indice:32	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis',
		save_as:'concepto_regis',
		id_grupo:6			
	};
	
	Atributos[42]={
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
		id_grupo:5
	};
	
	Atributos[43]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_comprobante'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud de Viáticos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/solicitud_viaticos/rendicion_viaticos.php'};
	var layout_solicitud_viaticos=new DocsLayoutMaestroDetalleEP(idContenedor);
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
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'70%',columnas:['45%','45%'],
		grupos:[
		{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},
		{tituloGrupo:'Conceptos',columna:0,id_grupo:1},
		{tituloGrupo:'Datos Viaje',columna:0,id_grupo:2},
		{tituloGrupo:'Importes Viático',columna:1,id_grupo:3},
		{tituloGrupo:'Datos Cheque',columna:0,id_grupo:4},
		{tituloGrupo:'Oculto',columna:1,id_grupo:5},
		{tituloGrupo:'Datos Vale',columna:0,id_grupo:6}
		],
		width:'95%',
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
	 	g_sw_contabilizar.setVisible(false);
		
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		componentes[8].on('change',fechas);//fecha_ini
		componentes[19].on('change',fechas);
		componentes[4].on('change',resetComponentes);
		componentes[5].on('change',resetComponentes);
		componentes[6].on('change',resetComponentes);
		componentes[7].on('change',resetComponentes);
		
		
		componentes[11].on('change',totalViatico);
		componentes[13].on('change',totalHotel);
		componentes[15].on('change',totalGeneral);
		componentes[20].on('change',validarDias);	

		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_solicitud_viaticos.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_solicitud_viaticos.getIdContentHijo()).pagina.bloquearMenu()
					}
				})		
	}
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
				enable(sm,row,rec);
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_solicitud_viaticos.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_solicitud_viaticos.getIdContentHijo()).pagina.desbloquearMenu();
	}
	
	/*function btnContabilizar(){
 		
		g_sw_contabilizar.setValue('1');
		ClaseMadre_save();
		//CM_btnEdit();
		g_sw_contabilizar.setValue('0');
	}	*/
	
	function btnContabilizar(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			
			if(SelectionsRecord.data.id_comprobante!='')
			{		
				Ext.MessageBox.alert('Estado','La solicitud seleccionada ya esta contabilizada.')			
			}
			else
			{	
				var sw=false;
				if(confirm('Esta seguro de contabilizar la solicitud?'))
						{sw=true}
				if(sw){				
					g_sw_contabilizar.setValue('1');
					ClaseMadre_save();
					//CM_btnEdit();
					g_sw_contabilizar.setValue('0');
				}	
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una solicitud.')
	    }	
	}
	
	function valida_datos(){
		var res=true
		for (var i=1;i<8;i++){
			
			if(componentes[i].getValue()==''){
				res=false;				
			}
		}
		if(componentes[17].getValue()==''){
				res=false;				
		}
		if(componentes[18].getValue()==''){
				res=false;				
		}
		if(componentes[19].getValue()==''){
				res=false;		
		}
		return res;
	}
	
	function validarDias(){
		var recordCobertura;
		if(componentes[7].getValue()!=''){
			if(componentes[20].getValue()!=''){
				recordCobertura=ds_cobertura.getById(componentes[7].getValue());
				
				if(recordCobertura.data.sw_dias==1 && componentes[20].getValue()>1){
					Ext.MessageBox.alert('Estado', 'La cobertura seleccionada solo permite viajes de un solo día.\nLa fecha final sera Eliminada');
					componentes[19].reset();
					componentes[20].reset();
				}			
			}			
		}
	}
	
	function fechas(){
		if((componentes[8].getValue()=='' || componentes[8].getValue()==undefined)||(componentes[19].getValue()=='' || componentes[19].getValue()==undefined))
		{
			componentes[8].maxValue=componentes[19].getValue();
			componentes[19].minValue=componentes[8].getValue();
			
					
		}
		else{
			componentes[8].maxValue=componentes[19].getValue();
			componentes[19].minValue=componentes[8].getValue();
			var fecha1=new Date(componentes[8].getValue());
			var fecha2=new Date(componentes[19].getValue());
			var dias=(fecha2-fecha1)/86400000;
			componentes[20].setValue(dias+1);
			validarDias();
		}
		resetComponentes();		
	}	
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	function miFuncionSuccess(resp){
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
		CM_mostrarGrupo('Conceptos');
		CM_mostrarGrupo('Datos Viaje');
		CM_mostrarGrupo('Importes Viático');
		CM_ocultarGrupo('Oculto');
		componentes[8].minValue=null;
		componentes[8].maxValue=null;
		SiBlancosGrupo(4);
		NoBlancosGrupo(0);
		NoBlancosGrupo(1);
		NoBlancosGrupo(2);
		NoBlancosGrupo(3);
		SiBlancosGrupo(6);
		CM_btnNew();		
	}
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(SelectionsRecord.data.estado_viatico==1)
		{
			CM_ocultarGrupo('Datos Cheque');
			
			CM_mostrarGrupo('Datos Generales');
			CM_mostrarGrupo('Conceptos');
			CM_mostrarGrupo('Datos Viaje');
			CM_mostrarGrupo('Importes Viático');
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Datos Vale');
			
			SiBlancosGrupo(4);
			NoBlancosGrupo(0);
			NoBlancosGrupo(1);
			NoBlancosGrupo(2);
			NoBlancosGrupo(3);
			SiBlancosGrupo(6);
			componentes[23].setValue('1');
			CM_btnEdit();
		}
		else
		{
			 Ext.MessageBox.alert('Estado','Solo viáticos en estado PENDIENTE pueden ser editados')
		}			
	}
	
	function btn_cheque(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		/*var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();*/
		
		if(NumSelect!=0)
		{		
			CM_mostrarGrupo('Datos Cheque');
			
			CM_ocultarGrupo('Datos Generales');
			CM_ocultarGrupo('Conceptos');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Importes Viático');
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Datos Vale');
			
			NoBlancosGrupo(4);
			SiBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(6);
			componentes[23].setValue('2');
			
				
			CM_btnEdit();
			 
			//data=datax="hidden_id_nro_tramite=" + componentes[0].getValue();
			//pagina=direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data;	
			//window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }			
	}
	
	function btn_imprime_cheque()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
		    var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;   	   			   	   
		    window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data)				
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.')
		} 
	}
	
	/*function btn_emitir_cheque(resp)
	{				
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
			/*var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.id_cheque!='')
			{
               Ext.MessageBox.alert('Estado','Ya se emitió un cheque para el registro seleccionado.')				
			}
			else
			{
 				var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
			    data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			    				
				alert(data);	        	
	        	window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);	
			}			
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	}*/
	
	function btn_pago()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{	
			switch (SelectionsRecord.data.sw_cheque)
			{
				case '1':
					btn_cheque(sm,filas,cont,NumSelect,SelectionsRecord);
				break;
				case '2':
					btn_vale(sm,filas,cont,NumSelect,SelectionsRecord);
				break;
				default: Ext.MessageBox.alert('Estado','No hay esa forma de pago.'); 
			}
		}
	}	
	
	/**
	La emision de vale 
	*/
	function btn_vale(sm,filas,cont,NumSelect,SelectionsRecord)
	{
		/*var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();*/
		
		if(NumSelect!=0)
		{		
			CM_mostrarGrupo('Datos Vale');
			
			CM_ocultarGrupo('Datos Cheque');
			CM_ocultarGrupo('Datos Generales');
			CM_ocultarGrupo('Conceptos');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Importes Viático');
			CM_ocultarGrupo('Oculto');
			
			/*CM_mostrarGrupo('Datos Cheque');
			CM_mostrarGrupo('Datos Generales');
			CM_mostrarGrupo('Conceptos');
			CM_mostrarGrupo('Datos Viaje');
			CM_mostrarGrupo('Importes Viático');
			CM_mostrarGrupo('Oculto');*/
			
			NoBlancosGrupo(6);
			SiBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(4);
			componentes[23].setValue('4');
			var data='&m_id_cheque='+SelectionsRecord.data.id_cheque;
				data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
				
			componentes[39].disable();	
			componentes[40].setValue(parseFloat(componentes[12].getValue())+parseFloat(componentes[14].getValue())+parseFloat(componentes[15].getValue()));
			componentes[41].setValue(componentes[33].getValue()+',  '+componentes[29].getValue());
			CM_btnEdit();
			 
			//data=datax="hidden_id_nro_tramite=" + componentes[0].getValue();
			//var data = "id_caja_regis=" +id_vale;
			//window.open(direccion+'../../../control/caja_regis/Reportes/ActionReporteValeCaja.php?'+data)
			
			//pagina=direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data;	
			//window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }			
	}
	
	function btn_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		//alert (SelectionsRecord.data.id_fina_regi_prog_proy_acti);
		if(NumSelect!=0)
		{
			/*if(SelectionsRecord.data.total==0){
				Ext.MessageBox.alert('...', 'La Partida seleccionada no tiene Memorias de Cálculo.')
			}
			else{*/
					
		    var data='&id_viatico='+SelectionsRecord.data.id_viatico+'&id_fina_regi_prog_proy_acti='+SelectionsRecord.data.id_fina_regi_prog_proy_acti+'&id_unidad_organizacional='+SelectionsRecord.data.id_unidad_organizacional;		   	   			   	   
		    window.open(direccion+'../../../control/_reportes/viatico/ActionReporteRendicionViatico.php?'+data)				
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function btn_solicitud()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			/*if(SelectionsRecord.data.total==0){
				Ext.MessageBox.alert('...', 'La Partida seleccionada no tiene Memorias de Cálculo.')
			}
			else{*/
					
		    var data='&id_viatico='+SelectionsRecord.data.id_viatico;		   	   			   	   
		    window.open(direccion+'../../../control/_reportes/viatico/ActionSolicitudViatico.php?'+data)				
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function resetComponentes(){
		componentes[9].reset();
		for(var i=10;i<17;i++){
			componentes[i].reset();
			componentes[i].setValue('0');
		}
	}
	
	function get_importes(){
		var data="id_destino="+componentes[6].getValue();
		data=data+"&cobertura="+componentes[7].getValue();
		data=data+"&id_moneda="+componentes[9].getValue();
		
		Ext.Ajax.request({
			url:direccion+"../../../control/viatico/ActionListarMontoViatico.php?"+data,
			method:'GET',
			success:cargar_importes,
			failure:conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		})
	}
	function conexionFailure(resp1,resp2,resp3,resp4){
		resetComponentes();
		ClaseMadre_conexionFailure(resp1,resp2,resp3,resp4);
	}
	
	function cargar_importes(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			
			
				componentes[10].setValue(root.getElementsByTagName('importe_pasaje')[0].firstChild.nodeValue);
				//alert(root.getElementsByTagName('importe_viatico')[0].firstChild.nodeValue);
				componentes[11].setValue(root.getElementsByTagName('importe_viaticos')[0].firstChild.nodeValue);
				componentes[13].setValue(root.getElementsByTagName('importe_hotel')[0].firstChild.nodeValue)
				componentes[11].fireEvent('change');
				componentes[13].fireEvent('change');		
		}
	}
	function totalViatico(){
		componentes[12].setValue((Math.round(parseFloat(componentes[11].getValue())*parseFloat(componentes[20].getValue())*100))/100);
		totalGeneral();
	}
	function totalHotel(){
		componentes[14].setValue((Math.round(parseFloat(componentes[13].getValue())*(parseFloat(componentes[20].getValue())-1)*100))/100);
		totalGeneral();
		
	}
	function totalGeneral(){
		
		componentes[16].setValue(parseFloat(componentes[12].getValue())+parseFloat(componentes[14].getValue())+parseFloat(componentes[15].getValue())+parseFloat(componentes[10].getValue()));
		
	}
	
	function btn_ejecutar(){
			
			var sm=getSelectionModel(), NumSelect=sm.getCount();
			if(NumSelect==1)
			{
				if(componentes[24].getValue()==2)	//estado viatico = DESCARGO
				{
					var sm=getSelectionModel();
					id_vale =sm.getSelected().data.id_caja_regis;
					cargar_respuesta();						
				}
				else
				{
					Ext.MessageBox.alert('...', 'Solo viaticos en estado DESCARGO pueden ser finalizados.');
				}	
			}
			else{
				Ext.MessageBox.alert('...','Antes debe seleccionar un registro.')
			}		
	}	
		
	function cargar_respuesta(){		
			
		var mensaje='¿Está seguro de finalizar el descargo del viático?';
			
		if(confirm(mensaje))
		{
			componentes[23].setValue(3);
			componentes[24].setValue(3);	//Estado Avance = cerrado	
			
			SiBlancosGrupo(4);
			SiBlancosGrupo(6);			
			
			ClaseMadre_save();
			//alert("llega despues");			
		}			
	}
	

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
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la solicitud de viaticos',btn_solicitud,true,'imp_ejecucion','Solicitud');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Emitir Cheque',btn_cheque,true,'emitir_cheque','Emisión de Cheque');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Emitir Vale',btn_vale,true,'emitir_vale','Emisión de Vale');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Emitir Pago',btn_pago,true,'emitir_pago','Emisión de Pago');
	this.AdicionarBoton("../../../lib/imagenes/det.ico",'Contabilizar',btnContabilizar,true, 'Contabilizar','Contabilizar');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Comprometer presupuesto',btn_ejecutar,true,'comprometer_viatico','Comprometer'); //tucrem
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Cheque',btn_imprime_cheque,true,'impresion_cheque','Cheque');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la rendición de viáticos',btn_rendicion,true,'rendicion_viaticos','Rendición');
	//this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Viatico',btn_finalizar,true,'fin_viatico','Finalizar'); //tucrem
		
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		//texto = rec.data['concepto_regis'].substring(0,7);
		if(rec.data['id_cheque']!='' || rec.data['id_caja']!='' ){
					
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('emitir_pago-'+idContenedor).disable();
				}
				else{
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('emitir_pago-'+idContenedor).enable();
				}
		if(rec.data['id_cheque']!=''){
					CM_getBoton('impresion_cheque-'+idContenedor).enable();
				}
				else{
					CM_getBoton('impresion_cheque-'+idContenedor).disable();
				}				
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_viaticos.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}