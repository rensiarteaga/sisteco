/**
 * Nombre:		  	    pagina_registro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:09
 */
function pagina_registro_transaccion(idContenedor,direccion,paramConfig,idContenedorPadre){
	//variables de eventos 
	var	var_id_transaccion;
	var	var_id_comprobante;
	var	var_id_presupuesto;
	var	var_id_orden_trabajo;
	var	var_id_partida_cuenta;
	var	var_id_auxiliar;
	var	var_id_oec;
	var	var_concepto_tran;
	var	var_importe_debe;
	var	var_importe_haber;
	var	var_importe_gasto;
	var	var_importe_recurso;
	var	var_id_cuenta;
	var	var_id_partida;
	var Atributos=new Array;
	var componentes=new Array();
	var componentes_grid=new Array();
	//variables para filtrar
 
	var sw_filtrar=' ';
	sw_ingreso=' ';
	//variables de clase madre
	var dialog;
	var data='';
	var grid;
	var var_record;
	var var_rowIndex;
	
	// clase de comprobante
	var  cont_dia='Contable Diario';
	var  cont_pre_dia='Contable Presupuestario Diario';
	var  cont_caja ='Contable Caja';
	var  cont_pre_caja ='Contable Presupuestario Caja';
	var  cont_pago= 'Contable Pago';
	var  cont_pre_pago='Contable Presupuestario Pago';
	var  pre='Presupuestario';
	// variables de funcionamiento
	var var_id_gestion='';	
	var var_id_fuente_financiamiento;
	var var_id_unidad_organizacional;
	var var_id_epe;
	var var_tipo_pres;
	var var_id_moneda;
	var var_fecha;
	var var_sw_tipo_cambio=true;
	var var_id_parametro_conta='';
	var var_id_depto_conta='';
	var var_fecha_trans;
	var g_id_moneda;
	var g_desc_moneda;
	var maestro={id_parametro:0,id_comprobante:0,id_moneda_reg:0};	

	var Trasaccion = Ext.data.Record.create([		
		'id_transaccion',
		'id_comprobante','desc_comprobante',
		'id_partida_cuenta','desc_partida_cuenta',
		'id_cuenta', 'desc_cuenta',
		'id_partida','desc_partida',
	 	'id_auxiliar','desc_auxiliar',
		'id_orden_trabajo','desc_orden_trabajo',
		'id_oec','nombre_oec',
		'concepto_tran',
		'id_moneda','desc_moneda',
		'importe_debe','importe_haber',
		'importe_gasto','importe_recurso',
		'id_presupuesto','desc_presupuesto',
		'tipo_pres',
		'sw_aux',
		'sw_oec',
		'sw_deha',
		'id_moneda',
		'id_nombre',
		'sw_rega',
		'disponibilidad'
		]); 
 
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarGestionarRegistroTransacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_transaccion',totalRecords:'TotalCount'
		},Trasaccion),remoteSort:true});
	
	//DATA STORE COMBOS
	var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarCuentaPartida.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_cuenta','id_partida','partida_cuenta','sw_deha','sw_rega', 'id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida','id_gestion','id_moneda','desc_moneda','sw_movimiento'])});
	function render_id_partida_cuenta(value, p, record){return String.format('{0}', record.data['desc_partida_cuenta'])};
	var tpl_id_partida_cuenta=new Ext.Template('<div class="search-item">','<b>Partida: </b><FONT COLOR="#B50000">{codigo_partida}</FONT> - ','<FONT COLOR="#B50000">{nombre_partida}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');
	
	var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarComprobante.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},['id_comprobante','id_parametro','nro_cbte','clase_cbte','tipo_cbte','momento_cbte','fecha_cbte','concepto_cbte','glosa_cbte','acreedor','aprobacion','conformidad','pedido','id_periodo_subsis','id_moneda_reg','id_usuario','id_subsistema','id_documento_nro'])});
	var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla'])});
	var ds_epe = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuarioSCI.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','id_financiador','codigo_financiador','nombre_financiador','id_regional','codigo_regional','nombre_regional','id_programa','codigo_programa','nombre_programa','id_proyecto','codigo_proyecto','nombre_proyecto','id_actividad','codigo_actividad','nombre_actividad','desc_epe']),	baseParams:{sw_reg_comp:'si'}});
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])});
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[		
		'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
	});

	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
		['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
		'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
		'sw_oec','sw_aux'
    ])});
    var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
    var ds_orden_trabajo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/orden_trabajo/ActionListarOrdenTrabajo.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario'])});
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{sw_reg_comp:'si'}});
	
    var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla'])});
    
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres','estado_pres','id_fuente_financiamiento','nombre_fuente_financiamiento',
																									'id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','nombre_financiador', 
																									'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad','id_parametro','gestion_pres',
																									'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																									'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin' 
																									])});
	var ds_tipo_cambioOCV = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambioOCV.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_tipo_cambio',totalRecords: 'TotalCount'},['id_tipo_cambio',{name: 'tc_origen', type: 'string'},{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},'tipo_cambio','id_moneda','desc_tc','des_moneda'])}); 
	
	var ds_oec = new Ext.data.Store({proxy: new Ext.data.HttpProxy({
		url: direccion+'../../../../sis_tesoreria/control/oec/ActionListarOecField.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_oec',totalRecords: 'TotalCount'},['id_oec','desc_oec', 'nro_oec','nombre_oec','sw_transaccional'])}); 

	//FUNCIONES RENDER	
	function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
	function render_id_orden_trabajo(value, p, record){return String.format('{0}',record.data['desc_orden_trabajo'])}
	function render_id_auxiliar(value, p, record){return String.format('{0}',record.data['desc_auxiliar'])}
	function render_id_oec(value, p, record){return String.format('{0}', record.data['nombre_oec']);}
	function render_id_moneda(value, p, record){return String.format('{0}',record.data['desc_moneda'])}
	function render_moneda_16(value,cell,record,row,colum,store){
	 	if(record.data['disponibilidad'] == 1){
		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
 	}
   function render_moneda_17(value,cell,record,row,colum,store){
	 	if(record.data['disponibilidad'] == 1){
		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
 	}
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
	function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}

	var tpl_id_comprobante=new Ext.Template('<div class="search-item">','<FONT COLOR="#0000ff">{desc_comprobante}</FONT><br>','</div>');
	var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_fuente}</FONT><br>','<b>Fuente Financiamiento: </b><FONT COLOR="#0000ff">{denominacion}</FONT>','</div>');
	var tpl_id_epe=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>','<br><FONT  SIZE="1" COLOR="#0000ff">{nombre_financiador}</FONT>','<br><FONT  SIZE="1" COLOR="#0000ff">{nombre_regional}</FONT>','<br><FONT  SIZE="1" COLOR="#0000ff">{nombre_programa}</FONT>','<br><FONT  SIZE="1" COLOR="#0000ff">{nombre_proyecto}</FONT>','<br><FONT  SIZE="1" COLOR="#0000ff">{nombre_actividad}</FONT>','</div>');
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>Unidad: </b><FONT COLOR="#0000ff">{nombre_unidad}</FONT><br>','<b>Centro: </b><FONT COLOR="#0000ff">{centro}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#0000ff"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var tpl_id_tipo_cambioOCV=new Ext.Template('<div class="search-item">','<b><i>{desc_tc}</i></b>', '</div>');
	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<b>Tipo: </b><FONT COLOR="#0000ff">{tipo_plantilla}</FONT> ><b> Plantilla: </b><FONT COLOR="#0000ff">{desc_plantilla}</FONT>','<br>','</div>');
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_par}</FONT><br>','<b>Código</b><FONT COLOR="#0000ff">{codigo_partida}</FONT><br>','<b>Partida</b><FONT COLOR="#0000ff">{nombre_partida}</FONT><br>','</div>');
 	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_cta2}</FONT><br>','<b>Número: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>'); 
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');
	var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>Orden Trabajo: </b><FONT COLOR="#0000ff">{desc_orden}</FONT><br>','<b>Motivo: </b><FONT COLOR="#0000ff">{motivo_orden}</FONT>','</div>');
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b>OEC: </b><FONT COLOR="#0000ff">{nombre_oec}</FONT><br>','</div>');
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b><i>{nombre_unidad}</i></b>',
		'<br><b>Gestión: </b> <FONT COLOR="#0000ff">{gestion_pres} </FONT> ',
		'<br>   Tipo Presupuesto: </b> <FONT COLOR="#B50000">{tipo_pres} </FONT> ',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#0000ff">{nombre_fuente_financiamiento}</FONT>',		
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#0000ff">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_actividad}</FONT>',
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
	
	Atributos[0]={
		validacion:{labelSeparator:'',
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
	
	Atributos[1]={
		validacion:{
			name:'id_comprobante',
			fieldLabel:'Comprobante',
			allowBlank:false,emptyText:'Comprobante...',
			desc: 'desc_comprobante',store:ds_comprobante,
			valueField: 'id_comprobante',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'id_comprobante',
			typeAhead:false,
			tpl:tpl_id_comprobante,
			forceSelection:false,
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
		filterColValue:'id_comprobante',
		save_as:'id_comprobante'
	};
	// txt id_presupuesto
	Atributos[2]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.desc_presupuesto#PRESUP.desc_epe#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:false,
			mode:'remote',
			queryDelay:450,
			pageSize:10,
			minListWidth:450,
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
			width:450,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'desc_presupuesto'
		 
	};
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Partida - Cuenta',
			allowBlank:false,
			emptyText:'Partida Cuenta...',
			name:'id_partida_cuenta',
			desc:'desc_partida_cuenta',
			store:ds_partida_cuenta,
			valueField:'id_partida_cuenta',
			displayField:'partida_cuenta',
			queryParam:'filterValue_0',
			filterCol:'nro_cuenta#nombre_cuenta#codigo_partida#nombre_partida#partida_cuenta',
			tpl:tpl_id_partida_cuenta,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:450,
			pageSize:10,
			minListWidth:450,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_id_partida_cuenta,
			grid_visible:true,
			grid_editable:false,
			width:450,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
	    id_grupo:2,
		form: true,
 		filterColValue:'desc_partida_cuenta',
  		save_as:'id_partida_cuenta'
	};

	// txt id_auxiliar
	Atributos[4]={
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
			filterCol:' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			tpl:tpl_id_auxiliar,
			forceSelection:false,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'desc_auxiliar',
		save_as:'id_auxiliar'
	};

 	Atributos[5]={
		validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden Trabajo',
			allowBlank:true,			
			emptyText:'Orden de Trabajo...',
			desc: 'desc_orden_trabajo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_orden_trabajo,
			valueField: 'id_orden_trabajo',
			displayField: 'desc_orden',
			queryParam: 'filterValue_0',
			filterCol:'ORDTRA.id_orden_trabajo#ORDTRA.desc_orden#ORDTRA.motivo_orden',
			typeAhead:false,
			tpl:tpl_id_orden_trabajo,
			forceSelection:false,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:false,
			boxReady:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'desc_orden_trabajo',
		save_as:'id_orden_trabajo'
	};
 
	Atributos[6]={
		validacion:{
			name:'id_oec',
			fieldLabel:'OEC',
			allowBlank:true,			
			emptyText:'OEC...',
			desc: 'nombre_oec', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_oec,
			valueField: 'id_oec',
			displayField: 'desc_oec',
			queryParam: 'filterValue_0',
			filterCol: 'nro_oec#nombre_oec',
			typeAhead:false,
			tpl:tpl_id_oec,
			forceSelection:false,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_oec,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'nombre_oec',
		save_as:'id_oec'
	};	

 	Atributos[7]= {
		validacion:{
			name:'concepto_tran',
			fieldLabel:'Glosa',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:450
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		id_grupo:4,
		filterColValue:'concepto_tran',
		save_as:'concepto_tran'
	};

	// txt total_general
	Atributos[8]={
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
			renderer:render_moneda_16,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		id_grupo:5,
		//defecto:'45,123,489.15',
		filtro_0:true,
		filterColValue:'importe_debe',
		save_as:'importe_debe'
	};
	
	Atributos[9]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
			allowBlank:true,
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
			renderer:render_moneda_17,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'importe_haber',
		save_as:'importe_haber'
	};
	
	Atributos[10]={
		validacion:{
			name:'importe_gasto',
			fieldLabel:'Importe gasto',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			renderer:render_moneda_17,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'importe_gasto',
		save_as:'importe_gasto'
	};
	
	Atributos[11]={
		validacion:{
			name:'importe_recurso',
			fieldLabel:'Importe Recurso',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			renderer:render_moneda_17,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'importe_recurso',
		save_as:'importe_recurso'
	};
	
	 Atributos[12]={
		validacion:{
			name:'id_partida',
			fieldLabel:'Partida',
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
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'',
		save_as:'id_partida'
	};  
	
	 Atributos[13]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
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
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'',
		save_as:'id_cuenta'
	}; 
	 
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Registro de Comprobante (Maestro)',titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_transacion=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_registro_transacion.init(config);	

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_registro_transacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false},excel:{crear:true,separador:false}};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/transaccion/ActionEliminarRegistroTransacion.php'},
		Save:{url:direccion+'../../../control/transaccion/ActionGestionarGuardarRegistroTransacion.php'},
		ConfirmSave:{url:direccion+'../../../control/transaccion/ActionGestionarGuardarRegistroTransacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,columnas:['95%'],
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura',columna:0,id_grupo:1},{tituloGrupo:'Partida-Cuenta',columna:0,id_grupo:2},{tituloGrupo:'Orden de Trabajo',columna:0,id_grupo:3},{tituloGrupo:'Transacción',columna:0,id_grupo:4},{tituloGrupo:'Importes',columna:0,id_grupo:5},{tituloGrupo:'Documento',columna:0,id_grupo:6}],
		width:650,
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Registro de Transacción'
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params,sw_editar){
		_CP.getPagina(idContenedorPadre).pagina.setMoneda(params.id_moneda,'Bs');
		monedas.setValue(params.id_moneda_cbte);
		maestro=params;
	   	paramFunciones.btnEliminar.parametros='&m_id_combrobante='+maestro.id_comprobante+'&m_id_moneda='+maestro.id_moneda;
		paramFunciones.Save.parametros='&m_id_combrobante='+maestro.id_comprobante;
		paramFunciones.ConfirmSave.parametros='&m_id_combrobante='+maestro.id_comprobante;
		this.InitFunciones(paramFunciones);
		var_id_comprobante.setValue(maestro.id_comprobante); 
		
		ds.lastOptions={params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_combrobante:params.id_comprobante,
						m_id_moneda:params.id_moneda_cbte
		}};
						
	   	this.btnActualizar();
	   	
	   	var_id_presupuesto.store.baseParams={sw_reg_comp:'si',m_id_parametro_conta:maestro.id_parametro ,m_id_depto:maestro.id_depto,m_momento: maestro.momento_cbte,m_nro_cbte:maestro.nro_cbte ,m_id_subsistema:maestro.id_subsistema};
		var_id_presupuesto.modificado=true;
		this.desbloquearMenu();
		if (maestro.estado_cbte==1 ){
				 this.bloquearMenu();
				 this.getBoton('monedas-'+idContenedor).enable();
				// this.getBoton('excel-'+idContenedor).enable();
		}
		this.getBotonNombre('Reporte Excel').enable();
	};
	
	function desbloquear_nuevo(){ 
		var_id_transaccion.setDisabled(false);
		var_id_comprobante.setDisabled(false);
		var_id_presupuesto.setDisabled(false);
		var_id_orden_trabajo.setDisabled(false);
		
		var_id_partida_cuenta.setDisabled(true);
		
		var_id_partida_cuenta.setValue('');
		var_id_partida.setValue('');
		var_id_cuenta.setValue('');
		
		var_id_auxiliar.setDisabled(true);
		
		var_id_oec.setDisabled(false);
		var_concepto_tran.setDisabled(false);
		var_importe_debe.setDisabled(true);
		var_importe_haber.setDisabled(true);
		var_importe_gasto.setDisabled(true);
		var_importe_recurso.setDisabled(true);
	}
	
	function bloquear_editar_subsitemas(){
		var_id_transaccion.setDisabled(true);
		var_id_comprobante.setDisabled(true);
		var_id_presupuesto.setDisabled(true);
		var_id_orden_trabajo.setDisabled(false);
		var_id_partida_cuenta.setDisabled(false);
		var_id_auxiliar.setDisabled(false);
		var_id_oec.setDisabled(false);
		var_concepto_tran.setDisabled(false);
		var_importe_debe.setDisabled(true);
		var_importe_haber.setDisabled(true);
		var_importe_gasto.setDisabled(true);
		var_importe_recurso.setDisabled(true);
	}
	
	function bloquear_editar_sci(){
		var_id_transaccion.setDisabled(true);
		var_id_comprobante.setDisabled(true);
		var_id_presupuesto.setDisabled(false);
		var_id_orden_trabajo.setDisabled(false);
		var_id_partida_cuenta.setDisabled(false);
		var_id_auxiliar.setDisabled(false);
		var_id_oec.setDisabled(false);
		var_concepto_tran.setDisabled(false);
	}
	
	function btn_registro_documento(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			
			var SelectionsRecord=sm.getSelected(); 
	    	var data='m_id_transaccion='+SelectionsRecord.data.id_transaccion;
			//data+='&m_desc_comprobante='+escape(SelectionsRecord.data.desc_comprobante);
			data+='&m_desc_comprobante='+SelectionsRecord.data.desc_comprobante;
			data+='&m_concepto_tran='+SelectionsRecord.data.concepto_tran;
			data+='&m_desc_cuenta='+SelectionsRecord.data.desc_partida_cuenta;
			data+='&m_desc_auxiliar='+SelectionsRecord.data.desc_auxiliar;
			data+='&m_desc_partida='+SelectionsRecord.data.desc_partida;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data+='&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data+='&m_id_parametro='+maestro.id_parametro;
			data+='&m_importe_debe='+SelectionsRecord.data.importe_debe;
			data+='&m_importe_haber='+SelectionsRecord.data.importe_haber;
			var ParamVentana={Ventana:{width:'70%',height:'70%'}}
			layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoCCF.php?'+data,'Documentos',ParamVentana);
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_registro_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0&&SelectionsRecord.data.id_transaccion!=0){
	    	data='m_id_transaccion='+SelectionsRecord.data.id_transaccion;
			data+='&m_desc_comprobante='+SelectionsRecord.data.desc_comprobante;
			data+='&m_concepto_tran='+SelectionsRecord.data.concepto_tran;
			data+='&m_desc_cuenta='+SelectionsRecord.data.desc_partida_cuenta;
			data+='&m_desc_auxiliar='+SelectionsRecord.data.desc_auxiliar;
			data+='&m_desc_partida='+SelectionsRecord.data.desc_partida;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data+='&m_id_cuenta='+SelectionsRecord.data.id_cuenta;
			data+='&m_id_auxiliar='+SelectionsRecord.data.id_auxiliar;
			data+='&m_desc_moneda='+SelectionsRecord.data.nombre;
			data+='&m_importe_debe='+SelectionsRecord.data.importe_debe;
			data+='&m_importe_haber='+SelectionsRecord.data.importe_haber;
			data+='&m_fecha_trans='+(maestro.fecha_cbte?maestro.fecha_cbte.dateFormat('d/m/Y'):'');
			 		 
			var ParamVentana={Ventana:{width:'70%',height:'70%'}}
			layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/cheque/cheque.php?'+data,'Documentos',ParamVentana);			
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item ya registrado');
		}
	}
	//Funcion que realiza el cambio del importe Haber - Debe
	function btn_transaccion_valor(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		if(NumSelect!=0&&SelectionsRecord.data.id_transaccion!=0){ 
			var SelectionsRecord=sm.getSelected();
	    	data='m_id_transaccion='+SelectionsRecord.data.id_transaccion;
	    	data+='&m_concepto_tran='+SelectionsRecord.data.concepto_tran;
			data+='&m_id_comprobante='+SelectionsRecord.data.id_comprobante;
			data+='&m_desc_comprobante='+SelectionsRecord.data.desc_comprobante;		
			
			var ParamVentana={Ventana:{width:'65%',height:'55%'}}
			layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/transaccion_valor/transaccion_valor.php?'+data,'TransaccionValor',ParamVentana);			
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item ya registrado');
		}			
	};	
	
	function InitRegistroTransaccion(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();

		var_id_transaccion=ClaseMadre_getComponente('id_transaccion');
		var_id_comprobante=ClaseMadre_getComponente('id_comprobante');
		var_id_presupuesto=ClaseMadre_getComponente('id_presupuesto');
		var_id_orden_trabajo=ClaseMadre_getComponente('id_orden_trabajo');
		var_id_partida_cuenta=ClaseMadre_getComponente('id_partida_cuenta');
		var_id_auxiliar=ClaseMadre_getComponente('id_auxiliar');
		var_id_oec=ClaseMadre_getComponente('id_oec');
		var_concepto_tran=ClaseMadre_getComponente('concepto_tran');
		var_importe_debe=ClaseMadre_getComponente('importe_debe');
		var_importe_haber=ClaseMadre_getComponente('importe_haber');
		var_importe_gasto=ClaseMadre_getComponente('importe_gasto');
		var_importe_recurso=ClaseMadre_getComponente('importe_recurso');
		var_id_partida=ClaseMadre_getComponente('id_partida');
		var_id_cuenta=ClaseMadre_getComponente('id_cuenta');
		var_id_presupuesto.on('select',f_filtrar_partida);	
		var_id_partida_cuenta.on('select',f_filtrar_auxiliar);	
		var_importe_debe.on('change',f_de_ha);
		var_importe_haber.on('change',f_ha_de);
		var_importe_gasto.on('change',f_ga_re);
		var_importe_recurso.on('change',f_re_ga);
		var_id_orden_trabajo.on('blur',f_vaciar_dato);
		
		getSelectionModel().on('rowselect',	function( SM,rowIndex){var_record=SM.getSelected().data; var_rowIndex=rowIndex;})
 	};
	
	this.btnNew=function(){
		ocultarGrupos();
		CM_mostrarGrupo('Estructura');
		CM_mostrarGrupo('Orden de Trabajo');
		CM_mostrarGrupo('Partida-Cuenta');
		CM_mostrarGrupo('Transacción');
		CM_mostrarGrupo('Importes');
		var_id_comprobante.setDisabled(true);
		ClaseMadre_btnNew();
		desbloquear_nuevo();
		var_id_comprobante.setValue(maestro.id_comprobante);
	};
	
	this.btnEdit=function(){
		ocultarGrupos();
	 	CM_mostrarGrupo('Estructura');
		CM_mostrarGrupo('Orden de Trabajo');
		CM_mostrarGrupo('Partida-Cuenta');
		CM_mostrarGrupo('Transacción');
		CM_mostrarGrupo('Importes');
		var_id_comprobante.setDisabled(true);

		if (monedas.getValue()!=maestro.id_moneda_cbte){
			alert("La moneda de registro tiene que ser igual a la moneda de listado "+monedas.getValue()+" - "+maestro.id_moneda_cbte);
			
 		}else{
 			//determina los listados de los combos 
 			if (maestro.nro_cbte=='' && maestro.id_subsistema==9){
 				var_id_presupuesto.store.baseParams={sw_reg_comp:'si',m_id_parametro_conta:maestro.id_parametro ,m_id_depto:maestro.id_depto,m_momento: maestro.momento_cbte,m_nro_cbte:maestro.nro_cbte ,m_id_subsistema:maestro.id_subsistema };
				var_id_presupuesto.modificado=true;
				
				var_id_partida_cuenta.store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_record.id_presupuesto,m_momneto:maestro.momento_cbte };	
				var_id_partida_cuenta.modificado=true;	 
				
				var_id_auxiliar.store.baseParams={sw_reg_comp:'si',m_id_cuenta:var_record.id_cuenta};
				var_id_auxiliar.modificado=true;	
 			}
 			if (maestro.nro_cbte=='' && maestro.id_subsistema!=9){
 				var_id_presupuesto.store.baseParams={sw_reg_comp:'si',m_id_parametro_conta:maestro.id_parametro ,m_id_depto:maestro.id_depto,m_momento: maestro.momento_cbte,m_nro_cbte:maestro.nro_cbte ,m_id_subsistema:maestro.id_subsistema,m_id_presupuesto:var_record.id_presupuesto };
				var_id_presupuesto.modificado=true;
 				
				var_id_partida_cuenta.store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_record.id_presupuesto,m_momneto:maestro.momento_cbte ,m_id_partida:var_record.id_partida };	
				var_id_partida_cuenta.modificado=true;	 
				
				var_id_auxiliar.store.baseParams={sw_reg_comp:'si',m_id_cuenta:var_record.id_cuenta};
				var_id_auxiliar.modificado=true;		
 			}
 			if (maestro.nro_cbte!=''){
 				var_id_presupuesto.store.baseParams={sw_reg_comp:'si',m_id_parametro_conta:maestro.id_parametro ,m_id_depto:maestro.id_depto,m_momento: maestro.momento_cbte,m_nro_cbte:maestro.nro_cbte ,m_id_subsistema:maestro.id_subsistema,m_id_presupuesto:var_record.id_presupuesto };
				var_id_presupuesto.modificado=true;
 				
				var_id_partida_cuenta.store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_record.id_presupuesto,m_momneto:maestro.momento_cbte ,m_id_partida:var_record.id_partida };	
				var_id_partida_cuenta.modificado=true;	 
				
				var_id_auxiliar.store.baseParams={sw_reg_comp:'si',m_id_cuenta:var_record.id_cuenta};
				var_id_auxiliar.modificado=true;
 			}
 			//Inicializa los campos de los importes
			var_importe_gasto.setDisabled(false);
			var_importe_recurso.setDisabled(false);
			var_importe_debe.setDisabled(false);
			var_importe_haber.setDisabled(false);
 			//bloquea o activa los campos de importes
 			if( maestro.nro_cbte==''  && (maestro.momento_cbte==1 || maestro.momento_cbte==4)){
 				if (var_record.sw_deha==2){
 					var_importe_debe.setDisabled(true);
 					var_importe_haber.setDisabled(false);
 				}
 				if (var_record.sw_deha==1){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(true);
 				}
 				if (var_record.sw_rega==1){
 					var_importe_gasto.setDisabled(true);
 					var_importe_recurso.setDisabled(false);
 				}
 				if (var_record.sw_rega==2){
 					var_importe_gasto.setDisabled(false);
 					var_importe_recurso.setDisabled(true);
 				}
 			}
 			if(maestro.nro_cbte=='' && (maestro.momento_cbte==5 ||maestro.momento_cbte==6)){
 				if (var_record.sw_deha==2){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(true);
 				}
 				if (var_record.sw_deha==1){
 					var_importe_debe.setDisabled(true);
 					var_importe_haber.setDisabled(false);
 				}
 				if (var_record.sw_rega==1){
 					var_importe_gasto.setDisabled(false);
 					var_importe_recurso.setDisabled(true);
 				}
 				if (var_record.sw_rega==2){
 					var_importe_gasto.setDisabled(true);
 					var_importe_recurso.setDisabled(false);
 				}
 				if(maestro.nro_cbte!='' ){
 					var_importe_gasto.setDisabled(true);
 					var_importe_recurso.setDisabled(true);
 				}
 			}
 			if(maestro.nro_cbte==''  && maestro.momento_cbte==0){
 				if(var_record.sw_deha==''){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(false);
 				}
 				if (var_record.sw_deha==1){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(true);
 				}
 				if (var_record.sw_deha==2){
 					var_importe_debe.setDisabled(true);
 					var_importe_haber.setDisabled(false);
 				}
 					var_importe_recurso.setDisabled(true);
 					var_importe_gasto.setDisabled(true);
 			}
 			if(maestro.nro_cbte!='' || maestro.id_subsistema!=9 ){
 				var_importe_recurso.setDisabled(true);
 				var_importe_gasto.setDisabled(true);
 				if(var_record.sw_deha==''){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(false);
 				}
 				if (var_record.sw_deha==2){
 					var_importe_debe.setDisabled(true);
 					var_importe_haber.setDisabled(false);
 				}
 				if (var_record.sw_deha==1){
 					var_importe_debe.setDisabled(false);
 					var_importe_haber.setDisabled(true);
 				}
 			}
			ClaseMadre_btnEdit();
		}
	} 
	
	function f_de_ha(elemento, nuevo, antiguo){var_importe_haber.setValue('')}
	function f_ha_de(elemento, nuevo, antiguo){var_importe_debe.setValue('')}
	function f_ga_re(elemento, nuevo, antiguo){var_importe_recurso.setValue('')}
	function f_re_ga(elemento, nuevo, antiguo){var_importe_gasto.setValue('')}
	
	function f_vaciar_dato(elemento){ 
		if (elemento.el.getValue()===elemento.emptyText){
			elemento.setValue('');
		}
	}
	
	function f_filtrar_partida( combo, record, index ){
		var_id_partida_cuenta.setValue('');
		var_id_partida.setValue('');
		var_id_cuenta.setValue('');
		var_id_auxiliar.setValue('');
		var_id_partida_cuenta.setDisabled(false);
		var_id_auxiliar.setDisabled(true);
	 	var_id_partida_cuenta.store.baseParams={sw_reg_comp:'si',m_id_presupuesto:record.data.id_presupuesto,m_momneto:maestro.momento_cbte };	
		var_id_partida_cuenta.modificado=true;	 
	}
	
	function f_filtrar_auxiliar( combo, record, index ){
		var_id_partida.setValue(record.data.id_partida);
		var_id_cuenta.setValue(record.data.id_cuenta);
		var_id_auxiliar.setValue('');
		var_id_auxiliar.setDisabled(false);
		var_id_auxiliar.store.baseParams={sw_reg_comp:'si',m_id_cuenta:record.data.id_cuenta};
		var_id_auxiliar.modificado=true;	
		
		//el comprobante no esta validado  y (el momento presupuestario es devengado  o  pagado)	
		if( maestro.nro_cbte==''  && (maestro.momento_cbte==1 || maestro.momento_cbte==4)){
			if (record.data.sw_deha==2){
				var_importe_debe.setDisabled(true);
				var_importe_haber.setDisabled(false);
			}
			if (record.data.sw_deha==1){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(true);
			}
			if (record.data.sw_rega==1){
				var_importe_gasto.setDisabled(true);
				var_importe_recurso.setDisabled(false);
			}
			if (record.data.sw_rega==2){
				var_importe_gasto.setDisabled(false);
				var_importe_recurso.setDisabled(true);
			}
		}
		//el comprobante no esta validado  y (el momento presupuestario es reversion devengado  o reversion pagado)	
		if(maestro.nro_cbte=='' && (maestro.momento_cbte==5 ||maestro.momento_cbte==6)){
			if (record.data.sw_deha==2){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(true);
			}
			if (record.data.sw_deha==1){
				var_importe_debe.setDisabled(true);
				var_importe_haber.setDisabled(false);
			}
			if (record.data.sw_rega==1){
				var_importe_gasto.setDisabled(false);
				var_importe_recurso.setDisabled(true);
			}
			if (record.data.sw_rega==2){
				var_importe_gasto.setDisabled(true);
				var_importe_recurso.setDisabled(false);
			}
			if(maestro.nro_cbte!='' ){
				var_importe_gasto.setDisabled(true);
				var_importe_recurso.setDisabled(true);
			}
		}	
		//el comprobante no esta validado  y (el momento presupuestario es ajuste devengado  o ajuste pagado)	
		if(maestro.nro_cbte=='' && (maestro.momento_cbte==7 ||maestro.momento_cbte==8)){
			var_importe_debe.setDisabled(false);
			var_importe_haber.setDisabled(false);
			var_importe_gasto.setDisabled(false);
			var_importe_recurso.setDisabled(false);
		}
		//el comprobante no esta validado  y (el momento presupuestario es contable)	
		if(maestro.nro_cbte==''  && maestro.momento_cbte==0){
			if (record.data.sw_deha==1){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(true);
			}
			if (record.data.sw_deha==2){
				var_importe_debe.setDisabled(true);
				var_importe_haber.setDisabled(false);
			}
			if (record.data.sw_deha==''){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(false);
			}
			var_importe_recurso.setDisabled(true);
			var_importe_gasto.setDisabled(true);
		}
		//el comprobante esta validado  y el comprobante no es de contabilidad
		if(maestro.nro_cbte!='' || maestro.id_subsistema!=9 ){
			var_importe_recurso.setDisabled(true);
			var_importe_gasto.setDisabled(true);
			if(record.data.sw_deha==''){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(false);
			}
			if (record.data.sw_deha==2){
				var_importe_debe.setDisabled(true);
				var_importe_haber.setDisabled(false);
			}
			if (record.data.sw_deha==1){
				var_importe_debe.setDisabled(false);
				var_importe_haber.setDisabled(true);
			}
		}
		if (record.data.sw_movimiento==2){
			var_importe_recurso.setDisabled(true);
			var_importe_gasto.setDisabled(true);
		}
	}
	
	this.getLayout=function(){return layout_registro_transacion.getLayout()};
	function ocultarGrupos(){
		CM_ocultarGrupo('Datos');
		CM_ocultarGrupo('Estructura');
		CM_ocultarGrupo('Orden de Trabajo');
		CM_ocultarGrupo('Partida');
		CM_ocultarGrupo('Partida-Cuenta');
		CM_ocultarGrupo('Transacción');
		CM_ocultarGrupo('Importes');
		CM_ocultarGrupo('Documento');
	}
	
	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
	});
	
 	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#0000ff"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var monedas =new Ext.form.ComboBox({
		store: ds_moneda_consulta,
		displayField:'nombre',
		typeAhead: true,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'Seleccionar moneda...',
		selectOnFocus:true,
		width:135,
		valueField: 'id_moneda',
		tpl:tpl_id_moneda_reg
	});
	
	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	
	monedas.on('select',
	function (combo, record, index){
		g_id_moneda=monedas.getValue();
		g_desc_moneda=record.data['simbolo'];
		_CP.getPagina(idContenedorPadre).pagina.setMoneda(g_id_moneda,g_desc_moneda);
		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_combrobante:maestro.id_comprobante,
				m_id_moneda:record.data.id_moneda
				},
			callback : function (){}
		});	
	});
	
	//Para manejo de eventos
	function btn_calculadora(){}
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.getLayout=function(){return layout_registro_transacion.getLayout()};
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Documentos',btn_registro_documento,true,'registro_documento','Documento');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Cheques',btn_registro_cheque,true,'registro_cheque','Cheque');
    this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Cambios Importe',btn_transaccion_valor,true,'Cambios_Importe','Cambios Importe');
	this.AdicionarBotonCombo(monedas,'monedas');
	//this.AdicionarBoton('','Calculadora',btn_calculadora,true,'Caluladora','Calculadora');
	this.iniciaFormulario();
	this.bloquearMenu();	
	InitRegistroTransaccion();
	layout_registro_transacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}