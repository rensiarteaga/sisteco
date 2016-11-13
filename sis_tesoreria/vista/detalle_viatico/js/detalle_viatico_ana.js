/**
 * Nombre:		  	    pagina_detalle_viatico.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:09
 */
function pagina_detalle_viatico(idContenedor,direccion,paramConfig,vista,ms) 
//tipo se refiere a si es registro para el comprometido o para rendición. valores: 'comp','rendic'
//vista=> 'viatico','fa','efectivo'
{
	var maestro;
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var cm;
	var grid;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_det/ActionListarDetalleViatico.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_doc_det',
			totalRecords: 'TotalCount'

		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'cantidad',
		'tipo_transporte',
		'importe',
		'importe_entregado',
		'id_tipo_destino',
		'desc_tipo_destino',
		'id_cobertura',
		'desc_cobertura',
		'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'id_presupuesto',
		'desc_presupuesto',
		'observaciones',
		'entrega_importe',
		'nombre_item',
		'nombre_servicio',
		'id_solicitud_compra',
		'desc_conce_item_serv',
		'id_partida',
		'desc_partida',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_categoria',
		'desc_categoria',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},		
		
		'id_parametro',
		'desc_parametro',
		'cantidad_dias_ant'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
    var ds_tipo_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_destino/ActionListarTipoDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_destino',totalRecords: 'TotalCount'},['id_tipo_destino','descripcion','id_moneda','fecha_reg','id_usr_reg'])
	});

    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','descripcion']),baseParams:{nuevo:'si',via:'aereo'}});


   

     /*var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv' ]),
	baseParams:{sw_tesoro:1}
	}); id:'id_concepto_ingas', */
     
     var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php?'}),   //para filtrar solo los conceptos de viaticos sw_tesoro=3
	reader:new Ext.data.XmlReader({record:'ROWS',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv','desc_cuenta','desc_auxiliar' ])
	});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																																								'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																																								'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																																								'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ,
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																																								'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin']),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
    var ds_solicitud_compra=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/viatico/ActionListarSolicitudADQAvance.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra',totalRecords: 'TotalCount'},['id_solicitud_compra','precio_total','solicitante','desc_ep','numeracion_solicitud','desc_solicitud'])
	});
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });	
	
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
			['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','desc_cta2']) });
		  
 	var ds_auxiliar=new Ext.data.Store({	proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},
		['id_cuenta_auxiliar','id_cuenta','nombre_cuenta','id_auxiliar','nombre_auxiliar','codigo_auxiliar']),remoteSort:true});
 	
 	var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/categoria/ActionListarCategoria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria'])
 	});
	
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
	
	//FUNCIONES RENDER
	function render_id_tipo_destino(value, p, record){return String.format('{0}', record.data['desc_tipo_destino']);}
	var tpl_id_tipo_destino=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_conce_item_serv']);}		
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">',
	'<b>{desc_ingas_item_serv}</b><br>',
	'    Partida: <FONT COLOR="#B5A642">{desc_partida}</FONT>',
	'<br>Cuenta: <FONT COLOR="#B5A642">{desc_cuenta}</FONT>',
	'<br>Auxiliar: <FONT COLOR="#B50000">{desc_auxiliar}</FONT>',
	'</div>');
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
	'<b>{nombre_unidad}</b>',
	'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
	'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
	'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
	//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
	'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
	'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
	'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
	'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
	'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
	'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
	'</div>');
	
	var tpl_solicitud_compra=new Ext.Template('<div class="search-item">',
	'<b>Solicitud: </b><FONT COLOR="#B5A642">{numeracion_solicitud}</FONT><BR>',
	'<b>Solicitante: </b><FONT COLOR="#B5A642">{solicitante}</FONT><BR>',
	'<b>Monto Solicitud: </b><FONT COLOR="#B5A642">{precio_total}</FONT><BR>',
	'<b>Moneda: </b><FONT COLOR="#B5A642">Bolivianos</FONT><BR>',
	'<b>Código EP: </b><FONT COLOR="#B5A642">{desc_ep}</FONT>',		
	'</div>');
	
	
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','{desc_par}<br>','</div>');

	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','{nombre_cuenta}<br>','</div>');

	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','{nombre_auxiliar}<br>','</div>');
	
	function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
	var tpl_id_categoria=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria}</b></i><br>','</div>');
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc_det
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_cuenta_doc
	Atributos[1]={
		validacion:{
			name:'id_cuenta_doc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
	
	// txt id_parametro
	Atributos[2]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			//displayField: 'desc_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
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
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:1,  //para colocar el orden en el indice			
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres'		
	};
	
	Atributos[3]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
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
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PRESUP.desc_presupuesto',
		id_grupo:0
	};
	
	// txt id_concepto_ingas
	Atributos[4]={
		validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto',
			allowBlank:false,			
			//emptyText:'Concepto...',
			desc: 'desc_conce_item_serv', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas',
			queryParam: 'filterValue_0',
			filterCol:'CONING.desc_ingas',
			typeAhead:false,
			tpl:tpl_id_concepto_ingas,
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
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:true,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		id_grupo:0
	};
	
// txt cantidad
	Atributos[5]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false,
			grid_indice:2			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.cantidad',
		id_grupo:1
	};
// txt tipo_transporte
	Atributos[6]={
		validacion: {
			name:'tipo_transporte',
			fieldLabel:'Tipo de Transporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['ninguno','ninguno'],['aereo','aereo'],['terrestre','terrestre'],['fluvial','fluvial_maritimo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			disabled:false,
			grid_indice:3			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.tipo_transporte',
		defecto:'ninguno',
		id_grupo:3
	};
// txt importe
	Atributos[7]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe Solicitado',
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
			disabled:false,
			grid_indice:4			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.importe',
		id_grupo:1
	};
// txt id_tipo_destino
	Atributos[8]={
		validacion: {
			name:'via',
			fieldLabel:'Via',
			allowBlank:false,
			emptyText:'Via...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['aereo','Aereo'],['terrestre','Terrestre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer: renderSwHotel,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			minListWidth:100,
			disable:false
			//grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.via',
		defecto:'aereo',
		save_as:'via',
		id_grupo:2
	};	
	Atributos[9]={
		validacion:{
			name:'id_tipo_destino',
			fieldLabel:'Tipo de Destino',
			allowBlank:false,			
			emptyText:'Tipo de Destino...',
			desc: 'desc_tipo_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_destino,
			valueField: 'id_tipo_destino',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPDES.descripcion',
			typeAhead:true,
			tpl:tpl_id_tipo_destino,
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
			renderer:render_id_tipo_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:5			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPDES.descripcion',
		id_grupo:2
	};
// txt id_cobertura
	Atributos[10]={
		validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura',
			allowBlank:false,			
			emptyText:'Cobertura...',
			desc: 'desc_cobertura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,
			valueField: 'id_cobertura',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.descripcion',
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
			width_grid:90,
			width:'100%',
			disabled:false,
			grid_indice:6			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.descripcion',
		id_grupo:2
	};
// txt id_presupuesto
	Atributos[11]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:15		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.observaciones',
		id_grupo:1
	};
	
	Atributos[12]={
		validacion: {
			name:'entrega_importe',	
			fieldLabel:'Entregar importe al Solicitante',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			disabled:false,
			grid_indice:9			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDODE.entrega_importe',
		defecto:'si',
		id_grupo:0
	};
	
	Atributos[13]={
		validacion:{
			name:'id_solicitud',
			fieldLabel:'Solicitud',
			allowBlank:false,			
			emptyText:'Solicitud...',
			store:ds_solicitud_compra,
			valueField:'id_solicitud_compra',
			displayField:'desc_solicitud',
			queryParam:'filterValue_0',
			filterCol:'SOLADQ.num_solicitud#SOLADQ.periodo',
			typeAhead:true,
			tpl:tpl_solicitud_compra,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			triggerAction:'all',
			grid_visible:false,
			grid_editable:false,
			width:240,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_solicitud',
		id_grupo:4
	};
	
	Atributos[14]={
		validacion:{
			name:'importe_entregado',
			fieldLabel:'Importe Entregado',
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
			disabled:false,
			grid_indice:10			
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'CUDODE.importe'
	};
	
	Atributos[15]={
		validacion:{
			name:'id_partida',
			fieldLabel:'Partida Presupuestaria',
			allowBlank:true,
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			tpl:tpl_id_partida,
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
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida'
		
	};
	
	Atributos[16]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta Contable',
			allowBlank:true,
			desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cuenta',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			typeAhead:false,
			tpl:tpl_id_cuenta,
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
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta'
	
	};
		
	Atributos[17]={
		validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar Contable',
			allowBlank:true,
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'desc_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
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
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar'
		
	};
	
	Atributos[18]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			renderer: formatDate,
			disabledDaysText:'Día no válido',
			grid_indice:7
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini',
		id_grupo:2
	};
	
	Atributos[19]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			grid_visible:true,
			renderer: formatDate,
			disabledDaysText:'Día no válido',
			grid_indice:8
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin',
		id_grupo:2
	};
	
	Atributos[20]={
		validacion:{
			name:'cantidad_dias_ant',
			fieldLabel:'Días acumulados',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:8	
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false		
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud de Viáticos (Maestro)',titulo_detalle:'detalle_viatico (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_detalle_viatico = new DocsLayoutMaestro(idContenedor);
	layout_detalle_viatico.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_viatico,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getGrid=this.getGrid;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_InitFunciones=this.InitFunciones;
	var ClaseMadre_getComponente=this.getComponente;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	
	//DEFINICIÓN DE FUNCIONES
	var titulo;
	if(vista=='fa')
		titulo='Detalle de Solicitud'
	else
		titulo='Detalle de Viaticos'
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_doc_det/ActionEliminarDetalleViatico.php'},
		Save:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php'},
		ConfirmSave:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],width:'75%',minWidth:350,minHeight:400,	closable:true,titulo:titulo,
			grupos:[
			{
				tituloGrupo:'Datos Presupuesto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Generales',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Viatico',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Pasaje',
				columna:0,
				id_grupo:3
			},
			{
				tituloGrupo:'Datos Solicitud',
				columna:0,
				id_grupo:4
			}]
		}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		if(ms!=undefined){
			var datos=Ext.urlDecode(decodeURIComponent(m));
			maestro.id_cuenta_doc=datos.id_cuenta_doc;	
			maestro.id_presupuesto=datos.id_presupuesto;
			maestro.desc_presupuesto=datos.desc_presupuesto;
			maestro.id_parametro=datos.id_parametro;
			maestro.desc_parametro=datos.desc_parametro;
			maestro.id_categoria=datos.id_categoria;
			maestro.desc_categoria=datos.desc_categoria;
			maestro.fecha_sol=datos.fecha_sol;
			this.desbloquearMenu();
		} else{
			maestro=m;
		}
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_cuenta_doc:maestro.id_cuenta_doc
			}
		};
		this.btnActualizar();
		componentes[4].setDisabled(true);
		Atributos[1].defecto=maestro.id_cuenta_doc;
		paramFunciones.btnEliminar.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.Save.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.ConfirmSave.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		if(ms!=undefined && ms!='' ){
			maestro=ms;
			paramFunciones.btnEliminar.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
			paramFunciones.Save.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
			paramFunciones.ConfirmSave.parametros='&id_cuenta_doc='+maestro.id_cuenta_doc;
			CM_InitFunciones(paramFunciones);
			Atributos[1].defecto=maestro.id_cuenta_doc;
		}
		
		grid=CM_getGrid();
		cm=grid.getColumnModel();	
		
		for (var i=0;i<Atributos.length;i++){			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		componentes[3].on('select',filtrar_epe_concepto_ingas);
		
		if(vista=='viatico'){
			componentes[4].on('select',validarConcepto);
			componentes[10].on('select',obtenerImporte);
			componentes[5].on('blur',obtenerImporte);
			componentes[9].on('select',obtenerImporte);
			componentes[18].on('blur',obtenerImporte);
			componentes[19].on('blur',obtenerImporte);
			//alert(ClaseMadre_getComponente('id_cobertura'));
			ClaseMadre_getComponente('via').on('select',filtrar_cobertura);
		}else{
			tipoOtro();
			ocultarColumnas();
		}
		componentes[2].on('select',evento_parametro); //salta al seleccionar la gestion
	}
	
	function evento_parametro( combo, record, index ){		
			//Filtramos los presupuestos segun la gestion seleccionada
			componentes[3].store.baseParams={id_parametro:record.data.id_parametro};
			componentes[3].modificado=true;			
			componentes[3].setValue('');			
			componentes[3].setDisabled(false);												
 	}
 	
	function ocultarColumnas(){
		cm.setHidden(CM_getColumnNum('tipo_transporte'),true);
		cm.setHidden(CM_getColumnNum('id_tipo_destino'),true);
		cm.setHidden(CM_getColumnNum('id_cobertura'),true);
		cm.setHidden(CM_getColumnNum('importe_entregado'),true);
		cm.setHidden(CM_getColumnNum('entrega_importe'),true);
		cm.setHidden(CM_getColumnNum('fecha_ini'),true);
		cm.setHidden(CM_getColumnNum('fecha_fin'),true);						
		cm.setHidden(CM_getColumnNum('cantidad_dias_ant'),true);			
	}
	
	function filtrar_epe_concepto_ingas(combo,record, index){
		componentes[4].store.baseParams={};
		
		componentes[4].setValue();
		if(vista=='viatico')
			componentes[4].store.baseParams={sw_tesoro:3,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		else if(vista=='fa')
			componentes[4].store.baseParams={sw_tesoro:4,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		else if(vista=='efectivo')	
			componentes[4].store.baseParams={sw_tesoro:5,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		componentes[4].modificado=true;
		componentes[4].setDisabled(false);
		
	}
	function filtrar_cobertura(combo,record, index){
		//alert(record.data.ID);
		//componentes[10].setValue();
		ClaseMadre_getComponente('id_cobertura').store.baseParams={via:record.data.ID,nuevo:'si'};
	
		//componentes[8].store.baseParams={};
		//componentes[8].setValue();
		/*if(vista=='viatico')
			componentes[10].store.baseParams={sw_tesoro:3,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		else if(vista=='fa')
			componentes[4].store.baseParams={sw_tesoro:4,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};
		else if(vista=='efectivo')	
			componentes[4].store.baseParams={sw_tesoro:5,m_sw_rendicion:'no', m_id_presupuesto:record.data.id_presupuesto};*/
		componentes[10].modificado=true;
		componentes[10].setDisabled(false);
	}
	
	function validarConcepto(combo,record,index){
		var nombre_concepto;
		nombre_concepto=record.data.desc_ingas.toLowerCase();
		if(nombre_concepto.indexOf('hotel')!=-1){
			tipoOtro();
		}else if(nombre_concepto.indexOf('pasajes')!=-1){
			tipoPasaje();
		}else if(nombre_concepto.indexOf('viaticos')!=-1 || nombre_concepto.indexOf('viaticos')!=-1){
			tipoViatico('new');
		}else{
			tipoOtro();
		}
	}
	
	function obtenerImporte(combo,record,index){
		if(componentes[9].getValue()=='' || componentes[10].getValue()=='' || componentes[18].getValue()=='' || componentes[19].getValue()==''){
			
		}else{
			Ext.MessageBox.show({
							title: 'Cargando Importe...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Importe...</div>",
							width:150,
							height:200,
							closable:false
						});
						
			Ext.Ajax.request({
						url:direccion+"../../../control/cuenta_doc_det/ActionObtenerImporteViatico.php",
						success:cargar_respuesta,
						//params:{id_cobertura:componentes[8].getValue(),id_categoria:maestro.id_categoria,id_tipo_destino:componentes[7].getValue(),cantidad:componentes[4].getValue()},
						params:{id_cuenta_doc:maestro.id_cuenta_doc,id_cobertura:componentes[10].getValue(),
								id_tipo_destino:componentes[9].getValue(),fecha_ini:componentes[18].getValue().dateFormat('m-d-Y'),
								fecha_fin:componentes[19].getValue().dateFormat('m-d-Y')},
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
		}
	}
	
	function cargar_respuesta(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined){
			var root=resp.responseXML.documentElement;
			
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1'){
				componentes[7].setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
				componentes[5].setValue(root.getElementsByTagName('cantidad')[0].firstChild.nodeValue);
			}else{ 
			
				Ext.MessageBox.alert('Alerta','No se puede obtener el importe para la cobertura y categoría seleccionados. Por favor revise la parametrización');
			}								
		}
	}
	
	function tipoPasaje(){
		CM_mostrarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		CM_ocultarGrupo('Datos Solicitud');
		SiBlancosGrupo(2);
		NoBlancosGrupo(3);
		NoBlancosGrupo(1);
		SiBlancosGrupo(4);
		componentes[7].setDisabled(false);
		componentes[5].setDisabled(false);
	}
	
	function tipoViatico(tipo){
		CM_ocultarGrupo('Datos Pasaje');
		CM_mostrarGrupo('Datos Viatico');
		CM_ocultarGrupo('Datos Solicitud');
		SiBlancosGrupo(3);
		NoBlancosGrupo(2);
		NoBlancosGrupo(1);
		SiBlancosGrupo(4);
		componentes[7].setDisabled(true);
		componentes[5].setDisabled(true);
		if(tipo=='new'){
			componentes[7].reset();
			componentes[5].reset();
		}
	}
	
	function tipoOtro(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		CM_ocultarGrupo('Datos Solicitud');
		
		SiBlancosGrupo(3);
		SiBlancosGrupo(2);
		SiBlancosGrupo(4);
		
		componentes[11].allowBlank=false;
		componentes[7].setDisabled(false);
		componentes[5].setDisabled(false);
		
		if(vista=='efectivo'||vista=='fa'){
			CM_ocultarComp(componentes[12]);
		}
	}
	
	this.btnNew=function(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		CM_ocultarGrupo('Datos Solicitud');
		CM_mostrarGrupo('Datos Presupuesto');
		CM_mostrarGrupo('Datos Generales');
		NoBlancosGrupo(0);
		NoBlancosGrupo(1);
		CM_btnNew();
		
		//Se aumenta registro en combo de parametros para definir el valor por defecto del padre
		var params2 = new Array();
		params2['id_parametro'] = maestro.id_parametro;
		params2['gestion_pres'] = maestro.desc_parametro;
		var aux2 = new Ext.data.Record(params2);
		Atributos[2].validacion.store.add(aux2);
		componentes[2].setValue(maestro.id_parametro);		
		
		//se aumenta registro en combo de presupuesto para definir el valor por defecto del padre
		var  params = new Array();
		params['id_presupuesto'] = maestro.id_presupuesto;
		params['desc_presupuesto'] = maestro.desc_presupuesto;
		var aux = new Ext.data.Record(params);
		Atributos[3].validacion.store.add(aux);
		componentes[3].setValue(maestro.id_presupuesto);
		
		//poner filtro al presupuesto
		componentes[3].store.baseParams={id_parametro:maestro.id_parametro};
		componentes[3].modificado=true;			
		componentes[3].setDisabled(false);
		
				
		filtrar_epe_concepto_ingas('nada',aux,'nada');		
	}	
	
	this.btnEdit=function(){
		
		var nombre_concepto;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			CM_mostrarGrupo('Datos Presupuesto');
			CM_mostrarGrupo('Datos Generales');
			NoBlancosGrupo(0);
			NoBlancosGrupo(1);
			componentes[3].setDisabled(true);
			
			//Añadiendo filtros a combos y habilitandolos para poder ser modificados
			componentes[4].store.baseParams={};
			
			if(vista=='viatico')
				componentes[4].store.baseParams={sw_tesoro:3,m_sw_rendicion:'no', m_id_presupuesto:SelectionsRecord.data.id_presupuesto};
			else if(vista=='fa')
				componentes[4].store.baseParams={sw_tesoro:4,m_sw_rendicion:'no', m_id_presupuesto:SelectionsRecord.data.id_presupuesto};
			else if(vista=='efectivo')	
				componentes[4].store.baseParams={sw_tesoro:5,m_sw_rendicion:'no', m_id_presupuesto:SelectionsRecord.data.id_presupuesto};
			componentes[4].modificado=true;
			componentes[4].setDisabled(false);
			
			//poner filtro al presupuesto
			componentes[3].store.baseParams={id_parametro:SelectionsRecord.data.id_parametro};
			componentes[3].modificado=true;			
			componentes[3].setDisabled(false);
			
			nombre_concepto=SelectionsRecord.data.desc_concepto_ingas.toLowerCase();;
			
			if(nombre_concepto.indexOf('hotel')!=-1){
				
				tipoOtro();
			}
			else if(nombre_concepto.indexOf('pasajes')!=-1){
				
				tipoPasaje();
			}else if(nombre_concepto.indexOf('viaticos')!=-1 || nombre_concepto.indexOf('viaticos')!=-1){
				
				tipoViatico('edit');
			}else{
				
				tipoOtro();
			}
			CM_btnEdit();
		}
		else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
				
	}
	function btnSolicitud(){
		CM_ocultarGrupo('Datos Pasaje');
		CM_ocultarGrupo('Datos Viatico');
		CM_ocultarGrupo('Datos Generales');
		CM_ocultarGrupo('Datos Presupuesto');
		CM_mostrarGrupo('Datos Solicitud');
		SiBlancosGrupo(3);
		SiBlancosGrupo(2);
		SiBlancosGrupo(1);
		SiBlancosGrupo(0);
		NoBlancosGrupo(4);
		CM_btnNew();
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
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_viatico.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.iniciaFormulario();
	
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Insertar Solicitud',btnSolicitud,true,'solicitud','Insertar Solicitud');		
	iniciarEventosFormularios();
	
	function habilitarBotones(){
		CM_getBoton('editar-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
		CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('guardar-'+idContenedor).enable();
		CM_getBoton('actualizar-'+idContenedor).enable();	
	}
	
	//Función que oculta o muestra los campos en función de la vista
	function ocultarMostrarCampos(){
		if(vista=='efectivo'){
			//Oculta el campo entrega_importe
			CM_ocultarComp(componentes[11]);
			//Oculta el botón de inserción de solicitud
			CM_getBoton('solicitud-'+idContenedor).hide();
		} else if(vista=='viatico'){
			//Oculta el botón de inserción de solicitud
			CM_getBoton('solicitud-'+idContenedor).hide();
		}
	}
	
	ocultarMostrarCampos();
	
	if(ms!=undefined && ms!='' ){
		this.desbloquearMenu();
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_cuenta_doc:maestro.id_cuenta_doc
			}
		};
		this.btnActualizar();
	}
	else{
		this.bloquearMenu();
	}
	layout_detalle_viatico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	
}