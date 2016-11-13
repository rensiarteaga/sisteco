function ReporteDetalleCbte(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_detalle_cbte, v_id_gestion;
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_depto = new Ext.data.Store({proxy :new Ext.data.HttpProxy({url :direccion + '../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record :'ROWS',id :'id_depto',totalRecords :'100'}, [ 'id_depto', 'codigo_depto', 'nombre_depto', 'estado','id_subsistema', 'nombre_corto', 'nombre_largo' ]),
		baseParams:{m_id_subsistema :9}
	});
	
	var ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	var resultTplDepto = new Ext.Template('<div class="search-item">',
			'<b><i>{nombre_depto}</i></b>',
			'<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>', '</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_cuenta(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cuenta=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	ds_depto.load();
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_conta',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	vectorAtributos[1] = {
		validacion : {
			name :'fecha_ini',
			fieldLabel :'Fecha Inicio',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_ini',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[2] = {
		validacion : {
			name :'fecha_fin',
			fieldLabel :'Fecha Fin',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_fin',
		dateFormat :'m/d/Y',
		defecto :""
	};

	vectorAtributos[3] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_ini',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_ini'
	};

	vectorAtributos[4] = {
		validacion : {
			labelSeparator :'',
			name :'rep_fecha_fin',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'rep_fecha_fin'
	};
	  
	vectorAtributos[5]={
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
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	vectorAtributos[6]={
		validacion:{
			name:'sw_depto',
			fieldLabel:'Depto.',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar Depto.(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'deptos_ids',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_depto,	
			maestroValField:'nombre_depto',
			valueField: 'id_depto',			
			queryParam: 'filterValue_0',
			filterCol:'codigo_depto#nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo_depto'] +'\" ' +'<'+record['nombre_depto'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			grid_visible:true,
			grid_editable:true,
			renderer:render_id_depto,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:0,
 		form: true
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'sw_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar Cuenta(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			width:200,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'cuenta_ids',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cuenta,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cuenta,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			grid_visible:true,
			grid_editable:true,
			renderer:render_cuenta,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:0,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[10]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['xls','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_detalle_cbte = new DocsLayoutProceso(idContenedor);
	layout_detalle_cbte.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_detalle_cbte, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_conexionFailure = this.conexionFailure;
	var CM_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = CM_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[0].on('select',evento_parametro);
		componentes[1].on('change', evento_fecha_inicio);
		componentes[2].on('change', evento_fecha_fin);
		componentes[6].on('select',f_almacenar_sw_depto);
		componentes[8].on('select',f_almacenar_sw_cuenta);
		
		limpiar_componentes();
	}
	
	function limpiar_componentes(){
		componentes[6].setValue('todos');
		componentes[8].setValue('todos');
		
	 	CM_ocultarComponente(componentes[7]);
	 	componentes[7].allowBlank=true;
	 	componentes[7].setValue('');
		
		CM_ocultarComponente(componentes[9]);
		componentes[9].allowBlank=true;
		componentes[9].setValue('');
	}
	
	function evento_parametro( combo, record, index ){
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){
			var intGestion=componentes[0].store.getById(id).data.gestion_conta;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
			v_id_gestion = componentes[0].store.getById(id).data.id_gestion;
			
			//Aplica la validación en la fecha
			componentes[1].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[1].maxValue=dte_fecha_fin_valid;
			componentes[2].minValue=dte_fecha_ini_valid;
			componentes[2].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[1].setValue(dte_fecha_ini_valid);
			componentes[2].setValue(dte_fecha_fin_valid);

			limpiar_componentes();
		}
	}
	
	function evento_fecha_inicio(combo, record, index) {
		var fecha_inicio_val = componentes[1].getValue();
		componentes[2].minValue = fecha_inicio_val;
		componentes[3].setValue(formatDate(componentes[0].getValue()));

		limpiar_componentes();
	}
	
	function evento_fecha_fin(combo, record, index) {
		var fecha_fin_val = componentes[2].getValue();
		componentes[4].setValue(formatDate(componentes[1].getValue()));

		limpiar_componentes();
	}
	
	function f_almacenar_sw_depto( combo, record, index ){
		componentes[7].allowBlank=true;
		componentes[7].setValue('');
		CM_ocultarComponente(componentes[7]);
		
		if(record.data.ID=='seleccion'){
			CM_mostrarComponente(componentes[7]);
			componentes[7].allowBlank=false;
		}
	}
	
	function f_almacenar_sw_cuenta( combo, record, index ){
		g_fecha_ini = componentes[1].getValue()?componentes[1].getValue().dateFormat('m/d/Y'):'';
		g_fecha_fin = componentes[2].getValue()?componentes[2].getValue().dateFormat('m/d/Y'):'';
		
		componentes[9].allowBlank=true;
		componentes[9].setValue('');
		CM_ocultarComponente(componentes[9]);
		
		if(record.data.ID=='seleccion'){
			componentes[9].store.baseParams={id_gestion:v_id_gestion, id_depto:0, fecha_inicio:g_fecha_ini, fecha_final:g_fecha_fin,
						sw_cuenta:'multiple', sw_auxiliar:'', sw_partida:'', sw_epe:'', sw_uo:'', sw_ot:'',
						sw_estado_cbte:'1', sw_actualizacion:'si', sw_listado:'cuenta',
						id_cuenta_inicial:'', id_cuenta_final:'', id_auxiliar_inicial:'', id_auxiliar_final:'', id_partida_inicial:'', id_partida_final:'',
						id_epe_inicial:'', id_epe_final:'', id_uo_inicial:'', id_uo_final:'', id_ot_inicial:'', id_ot_final:''};
			componentes[9].modificado=true;
			CM_mostrarComponente(componentes[9]);
			componentes[9].allowBlank=false;
		}
	}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Detalle de Comprobantes" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../control/comprobante/ActionPDFDetalleCbte.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 490, 520 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ],
			submit:function (){
				g_id_parametro = componentes[0].getValue();
				g_id_moneda = componentes[5].getValue();
				g_fecha_ini = componentes[1].getValue()?componentes[1].getValue().dateFormat('m/d/Y'):'';
				g_fecha_fin = componentes[2].getValue()?componentes[2].getValue().dateFormat('m/d/Y'):'';
				g_id_deptos = componentes[7].getValue();
				g_id_cuentas = componentes[9].getValue();
				g_tipo_reporte = componentes[10].getValue();
				
				var data='&id_parametro='+g_id_parametro;
				data+='&id_moneda='+g_id_moneda;
				data+='&id_deptos='+g_id_deptos;
				data+='&fecha_ini='+g_fecha_ini;
				data+='&fecha_fin='+g_fecha_fin;
				data+='&id_cuentas='+g_id_cuentas;
				data+='&tipo_reporte='+g_tipo_reporte;
				
				if (g_id_parametro != ''){
					window.open(direccion+'../../../control/comprobante/reporte/ActionPDFDetalleCbteJasper.php?'+data)
				}
			}
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}