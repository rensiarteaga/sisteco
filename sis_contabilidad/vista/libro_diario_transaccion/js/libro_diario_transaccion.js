/**
 * Nombre:		  	    pagina_registro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:09
 */
function pagina_libro_diario_transaccion(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var tituloM,maestro;
	var sw_filtro=' ';
	var dialog;
	var data='';
	var  cont_dia='Contable Diario';
	var  cont_pre_dia='Contable Presupuestario Diario';
	var  cont_caja ='Contable Caja';
	var  cont_pre_caja ='Contable Presupuestario Caja';
	var  cont_pago= 'Contable Pago';
	var  cont_pre_pago='Contable Presupuestario Pago';
	var  pre='Presupuestario';
	var  paginaPadre;
	


//var maestro;	
var componentes=new Array();
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarRegistroTransacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_transaccion',totalRecords:'TotalCount'
		},[		
		'id_transaccion',
		'id_comprobante',
		'desc_comprobante',
		'id_fuente_financiamiento',
		'desc_fuente_financiamiento',
		'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'epe',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_cuenta',
		'desc_cuenta',
		'id_partida',
		'desc_partida',
		'id_auxiliar',
		'desc_auxiliar',
		'id_orden_trabajo',
		'desc_orden_trabajo',
		'id_oec',
		'nombre_oec',
		'concepto_tran',
		'id_moneda',
		'desc_moneda',
		'importe_debe',
		'importe_haber',
		]),remoteSort:true});
		
		/*ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	    m_id_moneda:maestro.id_moneda,
	    m_tipo_vista:'libro_diario_transaccion'}});*/
	//DATA STORE COMBOS

    var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarComprobante.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},['id_comprobante','id_parametro','nro_cbte','clase_cbte','tipo_cbte','momento_cbte','fecha_cbte','concepto_cbte','glosa_cbte','acreedor','aprobacion','conformidad','pedido','id_periodo_subsis','id_moneda_reg','id_usuario','id_subsistema','id_documento_nro'])
	});

    var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla'])
	});

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion'])
	});

/*    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento','id_concepto_colectivo'])
	});*/

    var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});

    var ds_orden_trabajo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario'])
	});
 
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla'])
	});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
	baseParams:{sw_combo_presupuesto:'si'}
	});

	//FUNCIONES RENDER	
	
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	function render_moneda_12(c ){return componentes[14].formatMoneda(c);}
	function render_moneda_13(c ){return componentes[15].formatMoneda(c);}
	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<b>Tipo: </b><FONT COLOR="#B5A642">{tipo_plantilla}</FONT> <b>Plantilla: </b><FONT COLOR="#B5A642">{desc_plantilla}</FONT>','<br>','</div>');
 
 
	
		function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
		var tpl_id_comprobante=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_comprobante}</FONT><br>','</div>');

		function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['desc_fuente_financiamiento']);}
		var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_fuente}</FONT><br>','<b>Fuente Financiamiento: </b><FONT COLOR="#B5A642">{denominacion}</FONT>','</div>');

		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>Unidad: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<b>Centro: </b><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_partida}</FONT><br>','</div>');

		function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
		
		var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#B5A642">{nombre_auxiliar}</FONT><br>','</div>');

		function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden_trabajo']);}
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>Orden Trabajo: </b><FONT COLOR="#B5A642">{desc_orden}</FONT><br>','<b>Motivo: </b><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
		
		function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}

		function render_id_oec(value, p, record){return String.format('{0}', record.data['nombre_oec']);}
		
		
		

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	/*function renderDebe(value, p, record){return String.format('{0}', record.data['debe']);}
	function renderHaber(value, p, record){return String.format('{0}', record.data['haber']);}
	function renderRecurso(value, p, record){return String.format('{0}', record.data['recurso']);}
	function renderGasto(value, p, record){return String.format('{0}', record.data['gasto']);}*/
	
	// hidden id_transaccion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_transaccion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_transaccion'
	};
// txt id_comprobante
	Atributos[1]={
			validacion:{
			name:'id_comprobante',
			fieldLabel:'Comprobante',
			allowBlank:false,			
			emptyText:'Comprobante...',
			desc: 'desc_comprobante', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_comprobante,
			valueField: 'id_comprobante',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'COMPRO.',
			typeAhead:true,
			tpl:tpl_id_comprobante,
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
			renderer:render_id_comprobante,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:0,		
		filterColValue:'COMPRO.',
		save_as:'id_comprobante'
	};
// txt id_fuente_financiamiento
	Atributos[2]={
			validacion:{
			name:'id_fuente_financiamiento',
			fieldLabel:'Fuente Financiamiento',
			allowBlank:false,			
			emptyText:'Fuente Financiamiento...',
			desc: 'desc_fuente_financiamiento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'denominacion',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.codigo_fuente#FUNFIN.denominacion',
			typeAhead:true,
			tpl:tpl_id_fuente_financiamiento,
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
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'FUNFIN.codigo_fuente',
		save_as:'id_fuente_financiamiento'
	};
// txt id_fina_regi_prog_proy_acti
	Atributos[3]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:false,
			grid_editable:false,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};

// txt epe
	Atributos[4]={
		validacion:{
			name:'epe',
			fieldLabel:'Estructura Programatica',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'epe',
		save_as:'epe'
	};
		
// txt id_unidad_organizacional
	Atributos[5]={
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
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
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
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
// txt id_orden_trabajo
	Atributos[6]={
			validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,			
			emptyText:'Orden de Trabajo...',
			desc: 'desc_orden_trabajo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_orden_trabajo,
			valueField: 'id_orden_trabajo',
			displayField: 'desc_orden',
			queryParam: 'filterValue_0',
			filterCol:'ORDTRA.id_orden_trabajo#ORDTRA.desc_orden#ORDTRA.motivo_orden',
			typeAhead:true,
			tpl:tpl_id_orden_trabajo,
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
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'ORDTRA.id_orden_trabajo',
		save_as:'id_orden_trabajo'
	};
	
	Atributos[7]={
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida Ingreso',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_partida,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		form:true,
		id_grupo:3,
		tipo:'LovPartida',
		save_as:'id_partida'
	};
	Atributos[8]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			fieldLabel:'Cuenta',
			//tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_cuenta,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovCuenta',
		id_grupo:4,
		save_as:'id_cuenta'
	};

// txt id_auxiliar
	Atributos[9]={
			validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'.',
			typeAhead:true,
			tpl:tpl_id_auxiliar,
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
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:4,
		filterColValue:'.',
		save_as:'id_auxiliar'
	};
	Atributos[10]={
		validacion:{
			name:'id_oec',
			desc:'nombre_oec',
			fieldLabel:'OEC',
			//tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_oec,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovOec',
		id_grupo:4,
		save_as:'id_oec'
	};
	
// txt id_moneda
	Atributos[11]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:1,
		filterColValue:'MONEDA.nombre',
		id_grupo:5,
		save_as:'id_moneda'
	};
	// txt fecha_cbte
	Atributos[12]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha Transacción',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			//maxValue: '30/11/2008',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		id_grupo:5,
		filterColValue:'TRANSA.fecha_cbte',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_cbte'
	};
	
	
// txt concepto_tran
	Atributos[13]={
		validacion:{
			name:'concepto_tran',
			fieldLabel:'Concepto',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'TRANSC.concepto_tran',
		save_as:'concepto_tran'
	};
	
	// txt total_general
	Atributos[14]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			allowMil:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer:render_moneda_12,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		id_grupo:6,
		//defecto:'45,123,489.15',
		filtro_0:true,
		filterColValue:'traval.importe_debe',
		save_as:'importe_debe'
	};
	
	Atributos[15]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:3,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			renderer:render_moneda_13,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:6,
		filterColValue:'traval.importe_haber',
		save_as:'importe_haber'
	};
 	// txt id_moneda 
 	Atributos[16]={
			validacion:{
			name:'id_plantilla',
			fieldLabel:'Documento',
			allowBlank:true,			
			emptyText:'Documento...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_plantilla,
			valueField: 'tipo_plantilla',
			displayField: 'desc_plantilla',
			queryParam: 'filterValue_0',
			filterCol:' PLANT.tipo_plantilla#PLANT.desc_plantilla',
			typeAhead:true,
			tpl:tpl_id_plantilla,
			forceSelection:true,
			mode:'remote',
			onSelect: function(record){
			data=data+"&m_tipo_plantilla="+record.data.tipo_plantilla+"&m_desc_plantilla="+record.data.desc_plantilla;
			componentes[16].setValue(record.data.tipo_plantilla);
			componentes[16].collapse();
			},
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_plantilla,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//defecto:maestro.id_moneda,
		filterColValue:'MONEDA.nombre',
		id_grupo:7,
		save_as:'id_plantilla'
	};	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'Registro Transacción',grid_maestro:'grid-'+idContenedor};
	
	var config={titulo_maestro:'Comprobante (Maestro)',titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var layout_registro_transacion=new DocsLayoutMaestro(idContenedor);
		
	layout_registro_transacion.init(config);	
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_registro_transacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_conexionFailure=this.conexionFailure
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
	var paramMenu={	
		actualizar:{crear:true,separador:false}};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/transaccion/ActionEliminarRegistroTransacion.php'},
		Save:{url:direccion+'../../../control/transaccion/ActionGuardarRegistroTransacion.php'},
		ConfirmSave:{url:direccion+'../../../control/transaccion/ActionGuardarRegistroTransacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],
		grupos:
		[
		{tituloGrupo:'Datos',columna:0,id_grupo:0},
		{tituloGrupo:'Estructura',columna:0,id_grupo:1},
		{tituloGrupo:'Orden de Trabajo',columna:0,id_grupo:2},
		{tituloGrupo:'Partida',columna:0,id_grupo:3},
		{tituloGrupo:'Cuenta',columna:0,id_grupo:4},
		{tituloGrupo:'Transacción',columna:0,id_grupo:5},
		{tituloGrupo:'Importes',columna:0,id_grupo:6},
		{tituloGrupo:'Documento',columna:0,id_grupo:7}
		],
		width:'50%',
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Registro Transacción'
		//guardar:abrirVentana
		}
		
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	/*** reload ***/
   this.reload=function(m,Padre){
	alert("reload llega");	
   	maestro=m;
	paginaPadre=Padre;
   	paginaPadre.setMoneda(m.id_moneda,'Bs');
   	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	
	ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_combrobante:maestro.id_comprobante,
						m_id_moneda:maestro.id_moneda_reg
					}
				};
				Atributos[14].defecto=maestro.id_moneda_reg;
				this.btnActualizar();
				Atributos[1].defecto=maestro.id_combrobante;
				this.InitFunciones(paramFunciones)
			};

monedas.on('select',
		function (combo, record, index){
			g_id_moneda=monedas.getValue();
		 g_desc_moneda=record.data['simbolo'];
		 paginaPadre.setMoneda(g_id_moneda,g_desc_moneda);
			
			ds.load({
				params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_combrobante:maestro.id_comprobante,
						m_id_moneda:record.data.id_moneda
						},
				callback : function ()
						{
							
						}
			});			
		});			
	function InitRegistroTransaccion()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}
				
	};
	
	this.getLayout=function(){return layout_registro_transacion.getLayout()};


/**********************************************************************************/	
	this.Init(); //iniciamos la clase madre
	
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitRegistroTransaccion();
	layout_registro_transacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}