/**
 * Nombre:		  	    pagina_registro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:09
 */
function pagina_registro_transaccion(idContenedor,direccion,paramConfig,idContenedorPadre){
	//variables de eventos 
	var Atributos=new Array;
	var componentes=new Array();
	var componentes_grid=new Array();
	//variables para filtrar
	var sw_filtro=' ';
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
	var var_id_presupuesto;
	var var_id_partida;
	var var_id_cuenta;
	var var_id_moneda;
	var var_fecha;
	var var_sw_tipo_cambio=true;
	var var_id_parametro_conta='';
	var var_id_depto_conta='';
	var var_fecha_trans;
	var paginaPadre;
	var g_id_moneda;
	var g_desc_moneda;
	var maestro={id_parametro:0,id_comprobante:0,id_moneda_reg:0};	

  var Trasaccion = Ext.data.Record.create([		
		'id_transaccion',
		'id_comprobante','desc_comprobante',
		'id_fuente_financiamiento','desc_fuente_financiamiento',
		'id_fina_regi_prog_proy_acti','epe',
		'id_unidad_organizacional','desc_unidad_organizacional',
		'id_cuenta','desc_cuenta',
		'id_partida','desc_partida',
		'id_auxiliar','desc_auxiliar',
		'id_orden_trabajo','desc_orden_trabajo',
		'id_oec','nombre_oec',
		'concepto_tran',
		'id_moneda','desc_moneda',
		{name: 'fecha_trans', type: 'date', dateFormat: 'Y-m-d'},'tipo_cambio',
		'importe_debe','importe_haber',
		'importe_ejecucion',
		'id_tipo_cambio',
		'id_presupuesto',
		'tipo_pres',
		'sw_aux',
		'sw_oec',
		'sw_de_ha'
		]); 

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarRegistroTransacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_transaccion',totalRecords:'TotalCount'
		},Trasaccion),remoteSort:true});
		 
		
		
	//DATA STORE COMBOS

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
	//documento    
    var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla'])});
	//ds auxiliares
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_presupuesto',totalRecords:'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','gestion_pres'])});
	var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarPartidaCuenta.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_debe','debe','id_haber','haber','id_recurso','recurso','id_gasto','gasto','sw_deha','sw_rega','id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida'])});
	var ds_tipo_cambioOCV = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambioOCV.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_tipo_cambio',totalRecords: 'TotalCount'},['id_tipo_cambio',{name: 'tc_origen', type: 'string'},{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},'tipo_cambio','id_moneda','desc_tc','des_moneda'])}); 
	
	var ds_oec = new Ext.data.Store({proxy: new Ext.data.HttpProxy({
		url: direccion+'../../../../sis_tesoreria/control/oec/ActionListarOecField.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_oec',totalRecords: 'TotalCount'},['id_oec','desc_oec', 'nro_oec','nombre_oec','sw_transaccional'])}); 
 

		
	//FUNCIONES RENDER	
	function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
	function render_id_epe(value, p, record){rf = ds_epe.getById(value);if(rf!=null){record.data['id_fina_regi_prog_proy_acti'] =rf.data['id_fina_regi_prog_proy_acti'];record.data['epe'] =rf.data['desc_epe'];};return String.format('{0}',record.data['epe'])}
	function render_id_fuente_financiamiento(value, p, record){rf = ds_fuente_financiamiento.getById(value);if(rf!=null){record.data['id_fuente_financiamiento'] =rf.data['id_fuente_financiamiento'];record.data['desc_fuente_financiamiento'] =rf.data['denominacion'];};return String.format('{0}',record.data['desc_fuente_financiamiento'])}
	function render_id_unidad_organizacional(value, p, record){rf = ds_unidad_organizacional.getById(value);if(rf!=null){record.data['id_unidad_organizacional'] =rf.data['id_unidad_organizacional'];record.data['desc_unidad_organizacional'] =rf.data['nombre_unidad'];};return String.format('{0}',record.data['desc_unidad_organizacional'])}
	function render_id_orden_trabajo(value, p, record){rf = ds_orden_trabajo.getById(value);if(rf!=null){record.data['id_orden_trabajo'] =rf.data['id_orden_trabajo'];record.data['desc_orden_trabajo'] =rf.data['desc_orden'];};return String.format('{0}',record.data['desc_orden_trabajo'])}
		 
 	function render_id_partida(value, p, record){
	rf = ds_partida.getById(value);
		if(rf!=null){record.data['id_partida'] =rf.data['id_partida'];record.data['desc_partida'] =rf.data['desc_par'];}
		return String.format('{0}',record.data['desc_partida']) 
	} 

	function render_id_cuenta(value, p, record){rf = ds_cuenta.getById(value);
	if(rf!=null){record.data['id_cuenta'] =rf.data['id_cuenta'];record.data['desc_cuenta'] =rf.data['desc_cta2'];}
		return String.format('{0}',record.data['desc_cuenta'])}

	
	function render_id_auxiliar(value, p, record){rf = ds_auxiliar.getById(value);
	if(rf!=null){record.data['id_auxiliar'] =rf.data['id_auxiliar'];record.data['desc_auxiliar'] =rf.data['nombre_auxiliar'];}
		return String.format('{0}',record.data['desc_auxiliar'])}

	 	 

	function render_id_oec(value, p, record){rf = componentes_grid[9].store.getById(value);
	if(rf!=null){record.data['id_oec'] =rf.data['id_oec'];record.data['nombre_oec'] =rf.data['desc_oec'];}
		return String.format('{0}',record.data['nombre_oec'])}
	
	
	
	function render_id_moneda(value, p, record){rf = ds_moneda.getById(value);	 
	if(rf!=null){record.data['id_moneda'] =rf.data['id_moneda'];record.data['desc_moneda'] =rf.data['nombre'];}
		return String.format('{0}',record.data['desc_moneda'])}
		
	function render_id_tipo_cambioOCV(value, p, record){rf = ds_tipo_cambioOCV.getById(value);	 
	if(rf!=null){record.data['id_tipo_cambio'] =rf.data['id_tipo_cambio'];record.data['desc_tc'] =rf.data['tipo_cambio'];}
		return String.format('{0}',record.data['desc_tc'])}
		
		
		//return String.format('{0}', record.data['desc_tc']);}

	function render_moneda_16(c){return componentes[15].formatMoneda(c);}
	function render_moneda_17(c){return componentes[16].formatMoneda(c);}
	
	function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	
	
	var tpl_id_comprobante=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_comprobante}</FONT><br>','</div>');
	var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_fuente}</FONT><br>','<b>Fuente Financiamiento: </b><FONT COLOR="#B5A642">{denominacion}</FONT>','</div>');
	var tpl_id_epe=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_financiador}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_regional}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_programa}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_proyecto}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_actividad}</FONT>','</div>');
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>Unidad: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<b>Centro: </b><FONT COLOR="#B5A642">{centro}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var tpl_id_tipo_cambioOCV=new Ext.Template('<div class="search-item">','<b><i>{desc_tc}</i></b>', '</div>');
	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<b>Tipo: </b><FONT COLOR="#B5A642">{tipo_plantilla}</FONT> ><b> Plantilla: </b><FONT COLOR="#B5A642">{desc_plantilla}</FONT>','<br>','</div>');
 	
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_par}</FONT><br>','<b>Código</b><FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<b>Partida</b><FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');
 	
 	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_cta2}</FONT><br>','<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{nombre_cuenta}</FONT><br>','</div>'); 
 
	
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#B5A642">{nombre_auxiliar}</FONT><br>','</div>');
	var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b>Orden Trabajo: </b><FONT COLOR="#B5A642">{desc_orden}</FONT><br>','<b>Motivo: </b><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
 
	
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b>OEC: </b><FONT COLOR="#B5A642">{nombre_oec}</FONT><br>','</div>');


	
		

	Atributos[0]={
		validacion:{labelSeparator:'',name: 'id_transaccion',inputType:'hidden',grid_visible:false, grid_editable:false},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_transaccion'
	};
	Atributos[1]={
			validacion:{
			name:'id_comprobante',fieldLabel:'Comprobante',allowBlank:false,emptyText:'Comprobante...',
			desc: 'desc_comprobante',store:ds_comprobante,
			valueField: 'id_comprobante',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'COMPRO.',
			typeAhead:false,
			tpl:tpl_id_comprobante,
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
			desc: 'desc_fuente_financiamiento', 		
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'denominacion',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.codigo_fuente#FUNFIN.denominacion',
			typeAhead:false,//auto completar
			triggerAction:'all',
			tpl:tpl_id_fuente_financiamiento,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_fuente_financiamiento,
 			grid_visible:true,
 	 		grid_editable:true,
			width_grid:200,
			 lazyRender:true,
      
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
 
//http://cincel.ende.bo/endesis_desarrollo_prueba/sis_seguridad/control/asignacion_estructura/ActionListarEPusuario.php.XML.php?CantFiltros=1&filterAvanzado_0=false&filterCol_0=FINANC.nombre_financiador%23REGION.nombre_regional%23PROGRA.nombre_programa%23PROYEC.nombre_proyecto%23ACTIVI.nombre_actividad&filterValue_0=&limit=10&m_id_fuente_financiamiento=10&start=0&sw_reg_comp=si
/************************/
	Atributos[3]={
			validacion:{
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'Estructura Programàtica...',
			desc: 'epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_epe,
			valueField: 'id_fina_regi_prog_proy_acti',
			displayField: 'desc_epe',
			queryParam: 'filterValue_0',
			filterCol:'FRPPA.desc_epe#FRPPA.nombre_financiador#FRPPA.nombre_regional#FRPPA.nombre_programa#FRPPA.nombre_proyecto#FRPPA.nombre_actividad',
			typeAhead:false,
			tpl:tpl_id_epe,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_epe,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'epe',
		save_as:'id_fina_regi_prog_proy_acti'
	};
 
/***************************/
// txt id_unidad_organizacional
	Atributos[4]={
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
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:true,
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
	Atributos[5]={
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
			typeAhead:false,
			tpl:tpl_id_orden_trabajo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:true,
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
	
/*	Atributos[6]={
		validacion:{
			name:'id_partida',
			desc:'desc_partida',
			fieldLabel:'Partida ',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
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
	};	*/
// txt id_partida
	Atributos[6]={
			validacion:{
 			name:'id_partida',
			fieldLabel:'Partida',
			allowBlank:false,			
			emptyText:'Partida...',
			desc: 'desc_partida', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_partida,
 			grid_visible:true,
 			grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:'100%',
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'PARTID.id_partida',
		save_as:'id_partida'
	};
	/*Atributos[7]={
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
			grid_editable:true,
			renderer:render_id_cuenta,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovCuenta',
		id_grupo:3,
		save_as:'id_cuenta'
	};*/
	////id_partida////
	Atributos[7]={
			validacion:{
 			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'desc_cuenta', 		
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta,
 			grid_visible:true,
 	 		grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:'100%',
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'cuenta.id_cuenta',
		save_as:'id_cuenta'
	};
// txt id_auxiliar
	Atributos[8]={
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
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'.',
		save_as:'id_auxiliar'
	};

/*	Atributos[9]={
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
			grid_editable:true,
			renderer:render_id_oec,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovOec',
		id_grupo:3,
		save_as:'id_oec'
	};*/
 

	Atributos[9]={
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
			renderer:render_id_oec,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'oec.id_oec',
		save_as:'id_oec'
	};	
// txt id_moneda
	Atributos[10]={
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
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:1,
		filterColValue:'MONEDA.nombre',
		id_grupo:4,
		save_as:'id_moneda'
	};
	// txt fecha_trans
	Atributos[11]= {
		validacion:{
			name:'fecha_trans',
			fieldLabel:'Fecha Transacción',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			//maxValue: '30/11/2008',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		id_grupo:4,
		filterColValue:'TRANSA.fecha_trans',
		dateFormat:'m-d-Y',
		defecto:'2001/01/31',
		save_as:'fecha_trans'
	};
	
	Atributos[12]={
			validacion:{
			name:'id_tipo_cambio',
			fieldLabel:'T/C Origén',
			allowBlank:true,			
			emptyText:'T/C...',
			desc: 'desc_tc', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_cambioOCV,
			valueField: 'tc_origen',
			displayField: 'desc_tc',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_tipo_cambioOCV,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_cambioOCV,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:1,
		filterColValue:'TIPOCA.fecha',
		id_grupo:4,
		save_as:'tipo_cambio_origen'
	};
	
		Atributos[13]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'T/C',
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
			
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		id_grupo:4,
		filterColValue:'tctra.tipo_Cambio',
		save_as:'tipo_Cambio'
	};
 	Atributos[14]= {
		validacion:{
			name:'concepto_tran',
			fieldLabel:'Glosa Transacción',
			allowBlank:false,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:250
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		id_grupo:4,
		filterColValue:'TRANSAC.concepto_tran',
		save_as:'concepto_tran'
	};

		// txt total_general
	Atributos[15]={
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
			grid_editable:true,
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
		filterColValue:'traval.importe_debe',
		save_as:'importe_debe'
	};
	Atributos[16]={
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
			renderer:render_moneda_17,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'traval.importe_haber',
		save_as:'importe_haber'
	};
	// txt id_moneda 
	Atributos[17]={
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
			typeAhead:false,
				tpl:tpl_id_plantilla,
			forceSelection:true,
			mode:'remote',
			onSelect: function(record){
			data=data+"&m_tipo_plantilla="+record.data.tipo_plantilla+"&m_desc_plantilla="+record.data.desc_plantilla;//+"&m_id_moneda="+maestro.id_moneda;
			componentes[17].setValue(record.data.tipo_plantilla);
			componentes[17].collapse();
			},
			queryDelay:200,
			pageSize:10,
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
		id_grupo:6,
		save_as:'id_plantilla'
	};	
Atributos[18]={
		validacion:{
			name:'importe_ejecucion',
			fieldLabel:'Importe Ejecución',
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
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:true,
		id_grupo:5,
		filterColValue:'traval.importe_ejecucion',
		save_as:'importe_ejecucion'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Registro de Comprobante (Maestro)',titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
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
	var ClaseMadre_conexionFailure=this.conexionFailure
	/*********modificacion para editar**************/
	/****************************/
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};

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
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura',columna:0,id_grupo:1},{tituloGrupo:'Orden de Trabajo',columna:0,id_grupo:2},{tituloGrupo:'Partida-Cuenta',columna:0,id_grupo:3},{tituloGrupo:'Transacción',columna:0,id_grupo:4},{tituloGrupo:'Importes',columna:0,id_grupo:5},{tituloGrupo:'Documento',columna:0,id_grupo:6}],
		width:'50%',
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Registro Transacción',
		guardar:abrirVentana
		}
		
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params,sw_editar,Padre){
	paginaPadre=Padre;
   	paginaPadre.setMoneda(params.id_moneda,'Bs');
	//CM_getBoton('guardar-'+idContenedor).enable();var CM_getBoton=this.getBoton;
	//momento_cbte
	//activa el editor de la grilla 
	var_id_parametro_conta=params.id_parametro;
	var_id_depto_conta=params.id_depto;
	if(sw_editar!='si')for(i=0;i<14;i++)this.getGrid().colModel.setEditable( i,false );
	if(sw_editar=='si')for(i=0;i<14;i++)this.getGrid().colModel.setEditable( i,true );
	//cambia el nombre al boton moneda		
 	this.getBotonNombre('monedas').setValue(params.id_moneda);	
 	//acion dependiente de mometo_cbte
	
	if(params.momento_cbte==0){
		//ocultando de la grilla
		this.getGrid().colModel.setHidden(this.getColumnNum('id_fuente_financiamiento'),true);
		this.getGrid().colModel.setHidden(this.getColumnNum('id_partida'),true);
		//ocultando del formulario
		CM_ocultarComponente(componentes[2]);
		CM_ocultarComponente(componentes[6]);
		//permitiendo nulos
		componentes[2].allowBlank=true;
		componentes_grid[2].allowBlank=true;
		componentes[6].allowBlank=true;
		componentes_grid[6].allowBlank=true;
		
		sw_filtrar='no';
	
	};
	if(params.momento_cbte==1||params.momento_cbte==2){
		this.getGrid().colModel.setHidden(this.getColumnNum('id_fuente_financiamiento'),false);
		this.getGrid().colModel.setHidden(this.getColumnNum('id_partida'),false);
		CM_mostrarComponente(componentes[2]);
		CM_mostrarComponente(componentes[6]);
		//this.getGrid().colModel.setColumnHeader(this.getColumnNum('id_partida'),'Partida Ingreso');
		componentes[2].allowBlank=false;
		componentes_grid[2].allowBlank=false;
		componentes[6].allowBlank=false;
		componentes_grid[6].allowBlank=false;
		sw_filtrar='si';sw_ingreso='si';
	
	};
	if(params.momento_cbte==3||params.momento_cbte==4){
		this.getGrid().colModel.setHidden(this.getColumnNum('id_fuente_financiamiento'),false);
		this.getGrid().colModel.setHidden(this.getColumnNum('id_partida'),false);
		CM_mostrarComponente(componentes[2]);
		CM_mostrarComponente(componentes[6]);
		//this.getGrid().colModel.setColumnHeader(this.getColumnNum('id_partida'),'Partida Gasto');
		componentes[2].allowBlank=false;
		componentes_grid[2].allowBlank=false;
		componentes[6].allowBlank=false;
		componentes_grid[6].allowBlank=false;
		sw_filtrar='si';sw_ingreso='no';
	
	};
	
	componentes[2].store.baseParams={};
	componentes_grid[2].store.baseParams={};
	componentes[2].store.baseParams={m_id_parametro:params.id_parametro,sw_reg_comp:'si',m_sw_ingreso:sw_ingreso};
	componentes_grid[2].store.baseParams={m_id_parametro:params.id_parametro,sw_reg_comp:'si',m_sw_ingreso:sw_ingreso,m_id_depto:params.id_depto};
    componentes[2].modificado=true;
    componentes_grid[2].modificado=true;
	
	maestro=params;
	var_id_gestion=params.id_gestion;
	if(sw_editar!='si'){
		ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_combrobante:maestro.id_comprobante,
						m_id_moneda:maestro.id_moneda
					}
				};
		this.btnActualizar();}
	
				
				
				Atributos[15].defecto=maestro.id_moneda_reg;
				Atributos[1].defecto=maestro.id_combrobante;
				paramFunciones.btnEliminar.parametros='&m_id_combrobante='+maestro.id_comprobante+'&m_id_moneda='+maestro.id_moneda;
				paramFunciones.Save.parametros='&m_id_combrobante='+maestro.id_comprobante;
				paramFunciones.ConfirmSave.parametros='&m_id_combrobante='+maestro.id_comprobante;
				this.InitFunciones(paramFunciones);
				componentes[1].setValue(maestro.id_comprobante); 
				//componentes_grid[1].setValue(maestro.id_comprobante); 
//rtestrigción de la fecha 
 //componentes[12]minValue=params.fecha_cbte;
			componentes[11].maxValue=params.fecha_cbte;			
			componentes_grid[11].maxValue=params.fecha_cbte;	
			var_fecha_trans=params.fecha_cbte;
	
				
	};	

	
			
	function btn_registro_documento(){
		
		ocultarGrupos();
		CM_mostrarGrupo('Documento');	
		componentes[17].setDisabled(false);
		 var sm=getSelectionModel();
		 var filas=ds.getModifiedRecords();
		 var cont=filas.length;
		 var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
	    	data='m_id_transaccion='+SelectionsRecord.data.id_transaccion;
			data+='&m_desc_comprobante='+SelectionsRecord.data.desc_comprobante;
			data+='&m_concepto_tran='+SelectionsRecord.data.concepto_tran;
			data+='&m_desc_cuenta='+SelectionsRecord.data.desc_cuenta;
			data+='&m_desc_auxiliar='+SelectionsRecord.data.desc_auxiliar;
			data+='&m_desc_partida='+SelectionsRecord.data.desc_partida;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data+='&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data+='&m_id_parametro='+maestro.id_parametro;
			data+='&m_importe_debe='+SelectionsRecord.data.importe_debe;
			data+='&m_importe_haber='+SelectionsRecord.data.importe_haber;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoCCF.php?'+data,'Documentos',ParamVentana);
			sm.clearSelections();
			}
		else
		{
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
			data+='&m_desc_cuenta='+SelectionsRecord.data.desc_cuenta;
			data+='&m_desc_auxiliar='+SelectionsRecord.data.desc_auxiliar;
			data+='&m_desc_partida='+SelectionsRecord.data.desc_partida;
			data+='&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data+='&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data+='&m_importe_debe='+SelectionsRecord.data.importe_debe;
			data+='&m_importe_haber='+SelectionsRecord.data.importe_haber;
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/cheque/cheque.php?'+data,'Documentos',ParamVentana);			
			sm.clearSelections();
			}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item ya registrado');
		}
		
	
	}
	function btn_nuevo_grid(){
	  if(ds.getAt(0)==undefined ||ds.getAt(0).data.id_fina_regi_prog_proy_acti!=0){ 
	  	var p = new Trasaccion({
		id_transaccion:0,
		id_comprobante:maestro.id_comprobante,
		desc_comprobante:'Ninguno',
		id_fuente_financiamiento:0,
		desc_fuente_financiamiento:'Ninguno',
		id_fina_regi_prog_proy_acti:0,
		epe:'Ninguno',
		id_unidad_organizacional:0,
		desc_unidad_organizacional:'Ninguno',
		id_cuenta:0,
		desc_cuenta:'Ninguno',
		id_partida:0,
		desc_partida:'Ninguno',
		id_auxiliar:0,
		desc_auxiliar:'Ninguno',
		id_orden_trabajo:0,
		desc_orden_trabajo:'Ninguno',
		id_oec:0,
		nombre_oec:'Ninguno',
		concepto_tran:'Ninguno',
		id_moneda:0,
		desc_moneda:'Ninguno',
		fecha_trans:var_fecha_trans,
		tipo_cambio:'',
		importe_debe:'',
		importe_haber:'',
		importe_ejecucion:'',
		id_presupuesto:0,
		tipo_pres:0,
		sw_aux:0,
		sw_oec:0,
		sw_de_ha:0		
		}) ;
        ds.insert(0,  p);
		var_record=p;}
		var_record=ds.getAt(0);
	  //grid.startEditing(0, 0);
	  getSelectionModel().clearSelections();
	  getSelectionModel().selectRow(0);

	}
	//para que los hijos puedan ajustarse al tamaño
	
	
	
	function abrirVentana(){
		if ( sw_filtro=="abrir"){ 
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(componentes[17].getValue()==1){layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoCCF.php?'+data,'Documentos',ParamVentana);}
			if(componentes[17].getValue()==15){layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoCCF.php?'+data,'Documentos',ParamVentana);}
			if(componentes[17].getValue()==2){layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoSCF.php?'+data,'Documentos',ParamVentana);}
			if(componentes[17].getValue()==3){layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoCDF.php?'+data,'Documentos',ParamVentana);}
			if(componentes[17].getValue()==4){layout_registro_transacion.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_documento/registro_documentoSDF.php?'+data,'Documentos',ParamVentana);}
			dialog.hide();
		}
		 if (sw_filtro=="true"){ 	
			ds.baseParams={m_id_moneda: componentes[15].getValue(),filtro:1};	
			ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_combrobante:maestro.id_comprobante,
						m_id_moneda:componentes[15].getValue()
					}
				};
			dialog.hide();
		}
		 if(sw_filtro=="insert"){ClaseMadre_save();}
		
	 
 
	}
	
 
	function InitRegistroTransaccion()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<Atributos.length;i++){
		componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		componentes_grid[i]=ClaseMadre_getComponenteGrid(Atributos[i].validacion.name);
		}
		cm=grid.getColumnModel();
		//alert(cm[2].header);
		
	componentes[2].on('select',f_filtrar_epe);			
	componentes_grid[2].on('beforeselect',f_filtrar_epe_grid);	
			
	componentes[3].on('select',f_filtar_uo);			
	componentes_grid[3].on('beforeselect',f_filtar_uo_grid);	
		
	componentes[4].on('select',f_filtrar_partida);		
	componentes_grid[4].on('beforeselect',f_filtrar_partida_grid);		
		
	componentes[6].on('select',f_filtrar_cuenta);			
	componentes_grid[6].on('beforeselect',f_filtrar_cuenta_grid);
				
	componentes[7].on('select',f_filtrar_auxiliar);			
	componentes_grid[7].on('beforeselect',f_filtrar_auxiliar_grid);		
		
	componentes[10].on('select',f_filtrar_tc_moneda);			
	componentes_grid[10].on('beforeselect',f_filtrar_tc_moneda_grid);		
		
	componentes[11].on('change',f_filtrar_tc_fecha);			
	componentes_grid[11].on('change',f_filtrar_tc_fecha_grid);			
	//componentes_grid[11].on('blur',f_filtrar_tc_fecha_grid);			
	
	componentes[12].on('select',f_filtrar_moneda_convenio);			
	componentes_grid[12].on('beforeselect',f_filtrar_moneda_convenio_grid);			
	
	componentes[15].on('change',f_de_ha);
	componentes_grid[15].on('change',f_de_ha_grid);
	
	componentes[16].on('change',f_ha_de);
	componentes_grid[16].on('change',f_ha_de_grid);
 	};
	function limpiar_campos(posI,postF){for(i=posI;i<=postF;i++)if(componentes[i]!=undefined )componentes[i].setValue('');}
	function limpiar_campos_grid(inicial, finnal){if(inicial<=3&&3<= finnal){var_record.data.id_fina_regi_prog_proy_acti='';var_record.data.epe=''; }if(inicial<=4&&4<= finnal){var_record.data.id_unidad_organizacional='';var_record.data.desc_unidad_organizacional='';}if(inicial<=5&&5<= finnal){var_record.data.id_partida='';var_record.data.desc_partida='';}if(inicial<=6&&6<= finnal){var_record.data.id_cuenta='';var_record.data.desc_cuenta='';}if(inicial<=7&&7<= finnal){var_record.data.id_auxiliar='';var_record.data.desc_auxiliar='';}if(inicial<=8&&8<= finnal){var_record.data.id_orden_trabajo='';var_record.data.desc_orden_trabajo='';}if(inicial<=9&&9<= finnal){var_record.data.id_oec='';var_record.data.nombre_oec='';}if(inicial<=10&&10<= finnal){var_record.data.concepto_tran='';}if(inicial<=11&&11<= finnal){var_record.data.id_moneda='';var_record.data.desc_moneda='';}if(inicial<=12&&12<= finnal){var_record.data.fecha_trans=''}if(inicial<=13&&13<= finnal){var_record.data.tipo_cambio=''}if(inicial<=14&&14<= finnal){var_record.data.importe_debe=''}if(inicial<=15&&15<= finnal){var_record.data.importe_haber=''}}
	function desactivar(posI,postF){for(i=posI;i<=postF;i++)if(componentes[i]!=undefined)componentes[i].setDisabled(true);}
	function desactivar_grid(posI,postF){for(i=posI;i<=postF;i++)if(componentes_grid[i]!=undefined)componentes_grid[i].setDisabled(true);}
	function activar_grid(posI,postF){for(i=posI;i<=postF;i++)if(componentes_grid[i]!=undefined)componentes_grid[i].setDisabled(false);}
	
	function activar(posI,postF){for(i=posI;i<=postF;i++)if(componentes[i]!=undefined)componentes[i].setDisabled(false);}
 	
	this.btnNew=function(){
		sw_filtro="insert";
		ocultarGrupos();
		if(sw_filtrar=='si'){desactivar(3,17)}else{desactivar(4,17)}
		CM_mostrarGrupo('Estructura');
		CM_mostrarGrupo('Orden de Trabajo');
		CM_mostrarGrupo('Partida-Cuenta');
		CM_mostrarGrupo('Transacción');
		CM_mostrarGrupo('Importes');
		componentes[1].setDisabled(true);
		ClaseMadre_btnNew();	
		componentes[1].setValue(maestro.id_comprobante);
		
	};
	this.btnEdit=function(){
		sw_filtro="insert";
		//sw_filtrar=='si'
		ocultarGrupos();
		if (monedas.getValue()!=var_id_moneda){
		alert("La moneda de registro tiene que ser igual a la moneda de listado "+monedas.getValue()+" - "+var_id_moneda);
		
 		}
		else if(sw_filtrar=='si'){activar(3,17);
		
		CM_mostrarGrupo('Estructura');
		CM_mostrarGrupo('Orden de Trabajo');
		CM_mostrarGrupo('Partida-Cuenta');
		CM_mostrarGrupo('Transacción');
		CM_mostrarGrupo('Importes');
		componentes[1].setDisabled(true);
		var_id_moneda=var_record.data.id_moneda;
		var_id_cuenta=var_record.data.id_cuenta;
		var_id_partida=var_record.data.id_partida;
		var_id_presupuesto= var_record.data.id_presupuesto ;
		var_id_epe=var_record.data.id_fina_regi_prog_proy_acti;
		var_id_fuente_financiamiento=var_record.data.id_fuente_financiamiento;
		var_tipo_pres= var_record.data.tipo_pres;		
		componentes[10].setDisabled(false);	
		componentes[8].allowBlank=true;
		componentes[3].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_record.data.id_fuente_financiamiento,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta};
		componentes[3].modificado=true;
		componentes[4].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_record.data.id_fuente_financiamiento,m_id_fina_regi_prog_proy_acti:var_record.data.id_fina_regi_prog_proy_acti,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta};
		componentes[4].modificado=true;
		componentes[6].store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_record.data.id_presupuesto,m_id_gestion:var_id_gestion};	
		componentes[6].modificado=true;	
		componentes[7].store.baseParams={sw_reg_comp:'si',m_id_partida:var_record.data.id_partida};
		componentes[7].modificado=true;				 				
		componentes[8].store.baseParams={sw_reg_comp:'si',cuenta:var_record.data.id_cuenta};
		componentes[8].modificado=true;	
		if(var_record.data.sw_aux==1){componentes[8].allowBlank=false;componentes[8].setDisabled(false)};
		if(var_record.data.sw_aux==2){componentes[8].allowBlank=true;componentes[8].setDisabled(true);componentes[8].setValue('')};		
		if(var_record.data.sw_oec==1){componentes[9].allowBlank=false;	componentes[9].setDisabled(false)};
		if(var_record.data.sw_oec==2){componentes[9].allowBlank=true;componentes[9].setDisabled(true);componentes[9].setValue('')};
		if(var_record.data.sw_deha==1){componentes[16].setValue('');componentes[16].setDisabled(true);componentes[15].setDisabled(false)};
		if(var_record.data.sw_deha==2){componentes[15].setValue('');componentes[15].setDisabled(true);componentes[16].setDisabled(false);};
		ClaseMadre_btnEdit();		
			}else{
				CM_mostrarGrupo('Estructura');
				CM_mostrarGrupo('Orden de Trabajo');
				CM_mostrarGrupo('Partida-Cuenta');
				CM_mostrarGrupo('Transacción');
				CM_mostrarGrupo('Importes');
				//alert ("llega");
				activar(4,17);
				ClaseMadre_btnEdit();	
			}
	};
			
	//
		
		
	
	function f_filtrar_epe( combo, record, index ){
				if(sw_filtrar=='si'){
				 componentes[3].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:record.data.id_fuente_financiamiento,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta,m_sw_ingreso:sw_ingreso};
				 componentes[3].modificado=true;
				 var_id_fuente_financiamiento=record.data.id_fuente_financiamiento;
				 limpiar_campos(3,17);
				 desactivar(3,17)
				 componentes[3].setDisabled(false);
				}
				if(sw_filtrar=='no'){
					componentes[3].store.baseParams={};
					componentes[3].modificado=true;
					var_id_fuente_financiamiento='';
					 limpiar_campos(3,17);
				 	 desactivar(3,17)
					componentes[3].setDisabled(false);
				}
 	}	
	function f_filtrar_epe_grid( combo, record, index ){
				
				if(sw_filtrar=='si'){
				 componentes_grid[3].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:record.data.id_fuente_financiamiento,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta,m_sw_ingreso:sw_ingreso};
				 componentes_grid[3].modificado=true;
				 var_id_fuente_financiamiento=record.data.id_fuente_financiamiento;
				 limpiar_campos_grid(3,15);
				 desactivar_grid(3,17)
				 componentes_grid[3].setDisabled(false);
				}
				if(sw_filtrar=='no'){
					componentes_grid[3].store.baseParams={};
					componentes_grid[3].modificado=true;
					var_id_fuente_financiamiento='';
					limpiar_campos_grid(3,15);
				 	desactivar_grid(3,17)
					componentes_grid[3].setDisabled(false);
				}
 	}			

 
	function f_filtar_uo( combo, record, index ){
				
	 			if(sw_filtrar=='si'){
				 componentes[4].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_id_fuente_financiamiento,m_id_fina_regi_prog_proy_acti:record.data.id_fina_regi_prog_proy_acti,m_id_parametro_conta:var_id_parametro_conta,m_sw_ingreso:sw_ingreso};
				 var_id_epe=record.data.id_fina_regi_prog_proy_acti;
				 componentes[4].modificado=true;
				 limpiar_campos(5,17);
				 desactivar(5,17)
				 componentes[4].setDisabled(false);
	 			 }
	 			 if(sw_filtrar=='no'){
	 			 	componentes[4].store.baseParams={m_sw_presupuesto:'si'};
					componentes[4].modificado=true;
					var_id_epe='';
					limpiar_campos(5,17);
					desactivar(5,17)
				 	componentes[4].setDisabled(false);
				}
		
	}
	function f_filtar_uo_grid( combo, record, index ){
				
	 			if(sw_filtrar=='si'){
				 componentes_grid[4].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_id_fuente_financiamiento,m_id_fina_regi_prog_proy_acti:record.data.id_fina_regi_prog_proy_acti,m_id_parametro_conta:var_id_parametro_conta,m_sw_ingreso:sw_ingreso};
				 var_id_epe=record.data.id_fina_regi_prog_proy_acti;
				 componentes_grid[4].modificado=true;
				 limpiar_campos_grid(5,17);
				 desactivar_grid(5,17)
				 componentes_grid[4].setDisabled(false);
	 			 }
	 			 if(sw_filtrar=='no'){
					componentes[4].store.baseParams={m_sw_presupuesto:'si'};
					componentes_grid[4].modificado=true;
					var_id_epe='';
					limpiar_campos_grid(5,17);
					desactivar_grid(5,17)
				 	componentes_grid[4].setDisabled(false);
				}
		
	}
	function f_filtrar_partida( combo, record, index ){
			if(sw_filtrar=='si'){
			 ds_presupuesto.load({
								params:{
									sw_reg_comp:'si',
									m_id_fuente_financiamiento:var_id_fuente_financiamiento,
									m_id_unidad_organizacional: record.data.id_unidad_organizacional,
									m_id_gestion:var_id_gestion,
									m_id_epe: var_id_epe,
									m_sw_ingreso:sw_ingreso
									
									},
									callback: function(){
									var_tipo_pres= ds_presupuesto.getAt(0).data['tipo_pres'];
									var_id_presupuesto= ds_presupuesto.getAt(0).data['id_presupuesto'];
									componentes[6].store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_id_presupuesto,m_id_gestion:var_id_gestion,};	
						 				componentes[6].modificado=true;
						 				limpiar_campos(6,17);
										 desactivar(6,17)
										 componentes[5].setDisabled(false);
										 componentes[6].setDisabled(false);
										}
			 				});
			 	 
			}
			if(sw_filtrar=='no'){
				 componentes[6].store.baseParams={}	;
				 componentes[6].modificado=true;
				 componentes[7].store.baseParams={sw_transaccional:1,id_gestion:var_id_gestion}	;
				 componentes[7].modificado=true;
				 limpiar_campos(6,17);
				 desactivar(6,17)
				 componentes[5].setDisabled(false);
				 componentes[6].setDisabled(false);
				 componentes[7].setDisabled(false);
			}
	}
function f_filtrar_partida_grid( combo, record, index ){
			if(sw_filtrar=='si'){
			 ds_presupuesto.load({
								params:{
									sw_reg_comp:'si',
									m_id_fuente_financiamiento:var_id_fuente_financiamiento,
									m_id_unidad_organizacional: record.data.id_unidad_organizacional,
									m_id_gestion:var_id_gestion,
									m_id_epe: var_id_epe,
									m_sw_ingreso:sw_ingreso          
									},
									callback: function(){
									var_tipo_pres= ds_presupuesto.getAt(0).data['tipo_pres'];
									var_id_presupuesto= ds_presupuesto.getAt(0).data['id_presupuesto'];
									componentes_grid[6].store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_id_presupuesto,m_id_gestion:var_id_gestion};	
					 				componentes_grid[6].modificado=true;
									}
			 				});
			 				limpiar_campos_grid(6,17);
							desactivar_grid(6,17)
			 				componentes_grid[5].setDisabled(false);
							componentes_grid[6].setDisabled(false);
			 	 
			}
			if(sw_filtrar=='no'){
				
				
				 componentes_grid[6].store.baseParams={ }	;
				 componentes_grid[6].modificado=true;
				 componentes_grid[7].store.baseParams={sw_transaccional:1,id_gestion:var_id_gestion};
				 componentes_grid[7].modificado=true;
				 limpiar_campos_grid(6,17);
				 desactivar_grid(6,17)
				 componentes_grid[5].setDisabled(false);
				 componentes_grid[6].setDisabled(false);
				 componentes_grid[7].setDisabled(false);
			}
			
	}
	function f_filtrar_cuenta( combo, record, index ){
		if(sw_filtrar=='si'){
			componentes[7].store.baseParams={sw_reg_comp:'si',m_id_partida:record.data.id_partida};
			componentes[7].modificado=true;			
			var_id_partida=record.data.id_partida;
						
			limpiar_campos(8,17);
			desactivar(8,17)
			componentes[7].setDisabled(false);
		}
		if(sw_filtrar=='no'){
				componentes[7].store.baseParams={sw_reg_comp:'si' };
			componentes[7].modificado=true;			
			limpiar_campos(8,17);
			desactivar(8,17)
			componentes[7].setDisabled(false);
		}
	
	}
	function f_filtrar_cuenta_grid( combo, record, index ){
		if(sw_filtrar=='si'){
			componentes_grid[7].store.baseParams={sw_reg_comp:'si',m_id_partida:record.data.id_partida};
			componentes_grid[7].modificado=true;			
			var_id_partida=record.data.id_partida;
			limpiar_campos_grid(8,17);
			desactivar_grid(8,17)
			componentes_grid[7].setDisabled(false);
		}
		if(sw_filtrar=='no'){
				componentes_grid[7].store.baseParams={ };
			componentes_grid[7].modificado=true;			
			limpiar_campos_grid(8,17);
			desactivar_grid(8,17)
			componentes_grid[7].setDisabled(false);
		}
	
	}
	
	function f_filtrar_auxiliar( combo, record, index ){
			
			if(sw_filtrar=='si'){
			
			componentes[8].store.baseParams={sw_reg_comp:'si',cuenta:record.data.id_cuenta};
			componentes[8].modificado=true;	
		 	
			if(record.data.sw_aux==1){componentes[8].allowBlank=false;
									componentes[8].setDisabled(false);
									
									};
			if(record.data.sw_aux==2){componentes[8].allowBlank=true;
								 	componentes[8].setDisabled(true);
									componentes[8].setValue('');
									
									};		
			if(record.data.sw_oec==1){componentes[9].allowBlank=false;
									componentes[9].setDisabled(false);};
			if(record.data.sw_oec==2){componentes[9].allowBlank=true;
									componentes[9].setDisabled(true);
									componentes[9].setValue('');
									};
			
			componentes[10].setDisabled(false);	
			var_id_cuenta=record.data.id_cuenta;
			ds_partida_cuenta.load({
								params:{
									sw_reg_comp:'si',
									m_id_partida:var_id_partida,
									m_id_cuenta:var_id_cuenta
									},
									callback: function(){
										var_sw_deha =ds_partida_cuenta.getAt(0).data['sw_deha'];
									  if(var_sw_deha ==1){
									  	componentes[16].setValue('');
									  	componentes[16].setDisabled(true);
									  	componentes[15].setDisabled(false);
									  }
									  if(var_sw_deha ==2){
									  	componentes[15].setValue('');
									  	componentes[15].setDisabled(true);
									  	componentes[16].setDisabled(false);
									  }
									}
								
										
			 				});}
		if(sw_filtrar=='no'){
			
			componentes[8].store.baseParams={sw_reg_comp:'si',cuenta:record.data.id_cuenta};
			componentes[8].modificado=true;	
		 	
			if(record.data.sw_aux==1){componentes[8].allowBlank=false;
									componentes[8].setDisabled(false);};
			if(record.data.sw_aux==2){componentes[8].allowBlank=true;
									componentes[8].setDisabled(true);
									componentes[8].setValue('');
									};		
			if(record.data.sw_oec==1){componentes[9].allowBlank=false;
									componentes[9].setDisabled(false);};
			if(record.data.sw_oec==2){componentes[9].allowBlank=true;
									componentes[9].setDisabled(true);
									componentes[9].setValue('');
									};
			componentes[10].setDisabled(false);	
			componentes[15].setDisabled(false);	
			componentes[16].setDisabled(false);								
			
		}
	}
	
	function f_filtrar_auxiliar_grid( combo, record, index ){
		
		
			if(sw_filtrar=='si'){
				
			componentes_grid[8].store.baseParams={sw_reg_comp:'si',cuenta:record.data.id_cuenta};
			componentes_grid[8].modificado=true;	
		 	
			if(record.data.sw_aux==1){componentes_grid[8].allowBlank=false;
									componentes_grid[8].setDisabled(false);};
			if(record.data.sw_aux==2){componentes_grid[8].allowBlank=true;
									 componentes_grid[8].setDisabled(false);
									componentes_grid[8].setValue('');
									};		
			if(record.data.sw_oec==1){componentes_grid[9].allowBlank=false;
									componentes_grid[9].setDisabled(false);};
			if(record.data.sw_oec==2){componentes_grid[9].allowBlank=true;
									componentes_grid[9].setDisabled(false);
									componentes_grid[9].setValue('');
									};
			
			componentes_grid[10].setDisabled(false);	
			var_id_cuenta=record.data.id_cuenta;
			ds_partida_cuenta.load({
								params:{
									sw_reg_comp:'si',
									m_id_partida:var_id_partida,
									m_id_cuenta:var_id_cuenta
									},
									callback: function(){
										var_sw_deha =ds_partida_cuenta.getAt(0).data['sw_deha'];
										
									  if(var_sw_deha ==1){
									  	componentes_grid[16].setValue('');
									  	componentes_grid[16].setDisabled(true);
									  	componentes_grid[15].setDisabled(false);
									  }
									  if(var_sw_deha ==2){
									  	componentes_grid[15].setValue('');
									  	componentes_grid[15].setDisabled(false);
									  	componentes_grid[16].setDisabled(false);
									  }
									}
								
										
			 				});}
		if(sw_filtrar=='no'){
			
			componentes_grid[8].store.baseParams={sw_reg_comp:'si',cuenta:record.data.id_cuenta};
			componentes_grid[8].modificado=true;	
		 	
			if(record.data.sw_aux==1){componentes_grid[8].allowBlank=false;
									componentes_grid[8].setDisabled(false);};
			if(record.data.sw_aux==2){componentes_grid[8].allowBlank=true;
									componentes_grid[8].setDisabled(false);
									componentes_grid[8].setValue('');
									};		
			if(record.data.sw_oec==1){componentes_grid[9].allowBlank=false;
									componentes_grid[9].setDisabled(false);};
			if(record.data.sw_oec==2){componentes_grid[9].allowBlank=true;
									componentes_grid[9].setDisabled(false);
									componentes_grid[9].setValue('');
									};
			componentes_grid[10].setDisabled(false);	
			componentes_grid[15].setDisabled(false);	
			componentes_grid[16].setDisabled(false);								
			
		}
		
	}
	function f_filtrar_tc_moneda( combo, record, index )
	{ 
		var_sw_tipo_cambio=true;
		var_id_moneda=record.data.id_moneda;
		limpiar_campos(12,17);
		if(record.data.prioridad==1){
			var_sw_tipo_cambio=false;
			componentes[12].setDisabled(true);	
			componentes[13].setDisabled(true);	
		}
		desactivar(13,14)
		componentes[11].setDisabled(false);	
		componentes[14].setDisabled(false);			
		
	
	}
	function f_filtrar_tc_moneda_grid( combo, record, index )
	{ 
		var_sw_tipo_cambio=true;
		var_id_moneda=record.data.id_moneda;
		limpiar_campos_grid(12,17);
		if(record.data.prioridad==1){
			var_sw_tipo_cambio=false;
			
		
		}
		desactivar_grid(13,14)
		componentes_grid[11].setDisabled(false);	
		componentes_grid[12].setDisabled(false);	
		componentes_grid[13].setDisabled(false);	
		
		componentes_grid[14].setDisabled(false);	
		
	
	}
	
	function f_filtrar_tc_fecha( combo, nuevo, antiguo )
	{
		 //var_sw_tipo_cambio=true;
		//alert(var_sw_tipo_cambio);
		if(var_sw_tipo_cambio){
		//alert(nuevo);
		var_fecha= nuevo?nuevo.dateFormat('m/d/Y'):'';
		componentes[12].store.baseParams={sw_reg_comp:'si',m_id_moneda:var_id_moneda,m_fecha:var_fecha};
		componentes[12].allowBlank=false;
		componentes[13].allowBlank=false;	
		componentes[12].setDisabled(false);	
		componentes[12].modificado=true;
		} else
		{
		limpiar_campos(13,17);
		desactivar(13,14)
		componentes[12].allowBlank=true;	
		componentes[13].allowBlank=true;	
		componentes[14].setDisabled(false);	
		}
	}
 
	function f_filtrar_tc_fecha_grid( combo, nuevo, antiguo )
	{
		var_fecha= nuevo?nuevo.dateFormat('m/d/Y'):'';
		
		componentes_grid[12].store.baseParams={sw_reg_comp:'si',m_id_moneda:var_id_moneda,m_fecha:var_fecha};
		if(var_sw_tipo_cambio){
		
		var_fecha= nuevo?nuevo.dateFormat('m/d/Y'):'';
		//componentes_grid[12].store.baseParams={sw_reg_comp:'si',m_id_moneda:var_id_moneda,m_fecha:var_fecha};
		componentes_grid[12].store.baseParams={sw_reg_comp:'si',m_id_moneda:var_id_moneda,m_fecha:var_fecha};
		componentes_grid[12].allowBlank=false;
		componentes_grid[13].allowBlank=false;	
		componentes_grid[12].setDisabled(false);	
		componentes_grid[12].modificado=true;
		} else
		{
		limpiar_campos_grid(13,17);
		desactivar_grid(13,14)
		componentes_grid[12].allowBlank=true;	
		componentes_grid[13].allowBlank=true;	
		componentes_grid[14].setDisabled(false);	
		}
		componentes_grid[12].setDisabled(false);	
	}
	function f_filtrar_moneda_convenio( combo, record, index )
	{
		
		if(record.data.id_tipo_cambio==0)
		{
		
		componentes[13].setDisabled(false);	
		componentes[13].allowBlank=false;	
		}else{
			
		componentes[13].setDisabled(true);	
		componentes[13].allowBlank=true;		
		componentes[13].setValue('');		
		}
	
	
	}
	function f_filtrar_moneda_convenio_grid( combo, record, index )
	{
		
		if(record.data.id_tipo_cambio==0)
		{
		
		componentes_grid[13].setDisabled(false);	
		componentes_grid[13].allowBlank=false;	
		}else{
		componentes_grid[13].setDisabled(true);	
		componentes_grid[13].allowBlank=true;		
		componentes_grid[13].setValue('');		
		}
	componentes_grid[13].setDisabled(false);	
		componentes_grid[13].allowBlank=false;	
	
	}

	
	function f_de_ha(){componentes[16].setValue('')}
	function f_ha_de(){componentes[15].setValue('')}
	
	function f_de_ha_grid(){
		
		componentes_grid[16].setValue('');
		/*if( ds.getAt(0).data.id_fina_regi_prog_proy_acti!=0){
            var p = new Trasaccion({
		id_transaccion:0,
		id_comprobante:maestro.id_comprobante,
		desc_comprobante:'Ninguno',
		id_fuente_financiamiento:0,
		desc_fuente_financiamiento:'Ninguno',
		id_fina_regi_prog_proy_acti:0,
		epe:'Ninguno',
		id_unidad_organizacional:0,
		desc_unidad_organizacional:'Ninguno',
		id_cuenta:0,
		desc_cuenta:'Ninguno',
		id_partida:0,
		desc_partida:'Ninguno',
		id_auxiliar:0,
		desc_auxiliar:'Ninguno',
		id_orden_trabajo:0,
		desc_orden_trabajo:'Ninguno',
		id_oec:0,
		nombre_oec:'Ninguno',
		concepto_tran:'Ninguno',
		id_moneda:0,
		desc_moneda:'Ninguno',
		fecha_trans:var_fecha_trans,
		tipo_cambio:'',
		importe_debe:'',
		importe_haber:'',
		importe_ejecucion:'',
		id_presupuesto:0,
		tipo_pres:0,
		sw_aux:0,
		sw_oec:0,
		sw_de_ha:0		
		}) ;
          ds.insert(0,  p);
         }
         getSelectionModel().clearSelections();
         grid.startEditing(0, 0);
         getSelectionModel().selectRow(0);*/
         

}
	function f_ha_de_grid(){
		//	grid.stopEditing();
			//var id_transaccion= var_record.data.id_transaccion;
		componentes_grid[15].setValue('');	
	/*	 	if( ds.getAt(0).data.id_fina_regi_prog_proy_acti!=0){
            var p =  new Trasaccion({
		id_transaccion:0,
		id_comprobante:maestro.id_comprobante,
		desc_comprobante:'Ninguno',
		id_fuente_financiamiento:0,
		desc_fuente_financiamiento:'Ninguno',
		id_fina_regi_prog_proy_acti:0,
		epe:'Ninguno',
		id_unidad_organizacional:0,
		desc_unidad_organizacional:'Ninguno',
		id_cuenta:0,
		desc_cuenta:'Ninguno',
		id_partida:0,
		desc_partida:'Ninguno',
		id_auxiliar:0,
		desc_auxiliar:'Ninguno',
		id_orden_trabajo:0,
		desc_orden_trabajo:'Ninguno',
		id_oec:0,
		nombre_oec:'Ninguno',
		concepto_tran:'Ninguno',
		id_moneda:0,
		desc_moneda:'Ninguno',
		fecha_trans:var_fecha_trans,
		tipo_cambio:'',
		importe_debe:'',
		importe_haber:'',
		importe_ejecucion:'',
		id_presupuesto:0,
		tipo_pres:0,
		sw_aux:0,
		sw_oec:0,
		sw_de_ha:0		
		}) ;
          ds.insert(0,  p);
         }
         getSelectionModel().clearSelections();
          grid.startEditing(0, 0);
         getSelectionModel().selectRow(0);*/
            
	}
	this.getLayout=function(){return layout_registro_transacion.getLayout()};
function ocultarGrupos()
{
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
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
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
			//  renderer:render_id_moneda
			tpl:tpl_id_moneda_reg
			
		});

		ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
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
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	getSelectionModel().on('rowselect',function( SM,rowIndex){	sw_filtro="insert";
																
															
		//if(sw_filtrar=='no'){ClaseMadre_getGrid().startEditing(rowIndex,1)}
		
																
		var_record=SM.getSelected();
		var_rowIndex=rowIndex;
		var_id_moneda=var_record.data.id_moneda;
		if(var_record.data.id_transaccion!=0&&sw_filtrar=='si')
		{
		var_id_moneda=var_record.data.id_moneda;
		var_id_cuenta=var_record.data.id_cuenta;
		var_id_partida=var_record.data.id_partida;
		var_id_presupuesto= var_record.data.id_presupuesto ;
		var_id_epe=var_record.data.id_fina_regi_prog_proy_acti;
		var_id_fuente_financiamiento=var_record.data.id_fuente_financiamiento;
		var_tipo_pres= var_record.data.tipo_pres;		
		componentes_grid[10].setDisabled(false);	
		componentes_grid[3].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_record.data.id_fuente_financiamiento,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta};
		componentes_grid[3].modificado=true;
		componentes_grid[4].store.baseParams={sw_reg_comp:'si',m_id_fuente_financiamiento:var_record.data.id_fuente_financiamiento,m_id_fina_regi_prog_proy_acti:var_record.data.id_fina_regi_prog_proy_acti,m_id_parametro_conta:var_id_parametro_conta,m_id_depto:var_id_depto_conta};
		componentes_grid[4].modificado=true;
		componentes_grid[6].store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_record.data.id_presupuesto,m_id_gestion:var_id_gestion};	
		componentes_grid[6].modificado=true;	
		componentes_grid[7].store.baseParams={sw_reg_comp:'si',m_id_partida:var_record.data.id_partida};
		componentes_grid[7].modificado=true;				 				
		componentes_grid[8].store.baseParams={sw_reg_comp:'si',cuenta:var_record.data.id_cuenta};
		componentes_grid[8].modificado=true;	
		if(var_record.data.sw_aux==1){componentes_grid[8].allowBlank=false;componentes_grid[8].setDisabled(false)};
		if(var_record.data.sw_aux==2){componentes_grid[8].allowBlank=true;componentes_grid[8].setDisabled(true);componentes_grid[8].setValue('')};		
		if(var_record.data.sw_oec==1){componentes_grid[9].allowBlank=false;	componentes_grid[9].setDisabled(false)};
		if(var_record.data.sw_oec==2){componentes_grid[9].allowBlank=true;componentes_grid[9].setDisabled(true);componentes_grid[9].setValue('')};
		if(var_record.data.sw_de_ha==1){componentes_grid[16].setValue('');componentes_grid[16].setDisabled(true);componentes_grid[15].setDisabled(false)};
		if(var_record.data.sw_de_ha==2){componentes_grid[15].setValue('');componentes_grid[15].setDisabled(true);componentes_grid[16].setDisabled(false);};
		activar_grid(1,17);
		}})
	
	}
/**********************************************************************************/	
function btn_calculadora(){}
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	this.getLayout=function(){return layout_registro_transacion.getLayout()};
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Nuevo',btn_nuevo_grid,true,'nuevo_grid','Nuevo');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Documentos',btn_registro_documento,true,'registro_documento','Documento');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cheques',btn_registro_cheque,true,'registro_cheque','Cheque');
	this.AdicionarBotonCombo(monedas,'monedas');
	//this.AdicionarBoton('','Calculadora',btn_calculadora,true,'Caluladora','Calculadora');
	this.iniciaFormulario();
	this.bloquearMenu();	
	iniciarEventosFormularios();
	InitRegistroTransaccion();
	
	layout_registro_transacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

    ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

    
}