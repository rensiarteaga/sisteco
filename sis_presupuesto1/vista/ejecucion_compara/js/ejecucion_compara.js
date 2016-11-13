function pagina_ejecucion_compara(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_ejecucion_compara, g_id_depto=0, g_id_parametro=0, g_id_tipo_press=-1;
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_depto = new Ext.data.Store({proxy :new Ext.data.HttpProxy({url :direccion + '../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record :'ROWS',id :'id_depto',totalRecords :'100'}, [ 'id_depto', 'codigo_depto', 'nombre_depto', 'estado','id_subsistema', 'nombre_corto', 'nombre_largo']),
		baseParams:{m_id_subsistema:9}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuestoVar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','cod_categoria_prog','codigo_sisin','estado_pres']),
		baseParams:{m_id_parametro:0, m_id_depto:0}
	});
	
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});

	ds_depto.load();
	ds_presupuesto.load();
	
	var data_deptos=new Array();
	var indice=0;
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b></b>{desc_estado_gral}</FONT>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B50000">{nombre_depto}</FONT>','</div>');		
	
	function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
	var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión ...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
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
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false
		},
		id_grupo :0,
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
			name:'id_depto',
			fieldLabel:'Departamento', 
			vtype:'texto',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:400,
			disable:false		
		},
		id_grupo:0,
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'id_depto'
	};
	
	vectorAtributos[6]={
		validacion:{
			name:'id_tipo_pres',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_pres_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	}; 
	
	vectorAtributos[7] = {
		validacion : {
			labelSeparator :'',
			name :'nombre_presupuesto',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'nombre_presupuesto'
	};

	vectorAtributos[8] = {
		validacion : {
			name :'presupuesto',
			fieldLabel :'Presupuesto(s)',
			store:ds_presupuesto,
			valueField :'id_presupuesto',
			displayField :'desc_presupuesto',
			height :200,
			allowBlank :false,
			width :600
		},
		tipo :'Multiselect',
		save_as :'ppto_ids'
	};
		  
	vectorAtributos[9]={
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
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
		id_grupo:0,
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	vectorAtributos[10]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF'],['xls','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:100
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
	layout_ejecucion_compara = new DocsLayoutProceso(idContenedor);
	layout_ejecucion_compara.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_ejecucion_compara, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[0].on('select', evento_parametro);		
		componentes[1].on('change', evento_fecha_inicio);
		componentes[2].on('change', evento_fecha_fin);
		componentes[5].on('select', evento_depto);
		componentes[6].on('select', evento_tipo_pres);
		componentes[9].on('select', evento_moneda);
	}
	
	function evento_parametro( combo, record, index ){
		//Validación de fechas
		var id = componentes[0].getValue();
		g_id_parametro = componentes[0].getValue();
		
		if(componentes[0].store.getById(id)!=undefined){
			var intGestion=componentes[0].store.getById(id).data.gestion_pres;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[1].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[1].maxValue=dte_fecha_fin_valid;
			componentes[2].minValue=dte_fecha_ini_valid;
			componentes[2].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[1].setValue(dte_fecha_ini_valid);
			componentes[2].setValue(dte_fecha_fin_valid);	
		}
		
		componentes[6].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'no'};
		componentes[6].modificado=true;
		componentes[6].setValue('');
		
		ds_presupuesto.baseParams={
				m_id_parametro:g_id_parametro,
				m_id_depto:g_id_depto,
				m_id_tipo_pres: g_id_tipo_pres
		}
		
		ds_presupuesto.load();
	}

	function evento_fecha_inicio(combo, record, index) {
		var fecha_inicio_val = componentes[1].getValue();
		componentes[2].minValue = fecha_inicio_val;
		componentes[3].setValue(formatDate(componentes[0].getValue()));
	}
	
	function evento_fecha_fin(combo, record, index) {
		var fecha_fin_val = componentes[2].getValue();
		componentes[4].setValue(formatDate(componentes[1].getValue()));
	}
	
	function evento_depto(combo,record, index){
		g_id_depto = componentes[5].getValue();
		txt_ejec_depto = record.data.nombre_depto;
		
		ds_presupuesto.baseParams={
				m_id_parametro:g_id_parametro,
				m_id_depto:g_id_depto,
				m_id_tipo_pres: g_id_tipo_pres
		}
		
		ds_presupuesto.load();
	}
	
	function evento_tipo_pres(combo,record, index){
		g_id_tipo_pres = componentes[6].getValue();
		
		ds_presupuesto.baseParams={
				m_id_parametro:g_id_parametro,
				m_id_depto:g_id_depto,
				m_id_tipo_pres: g_id_tipo_pres
		}
		
		ds_presupuesto.load();
	}
	
	function evento_moneda(combo,record, index){txt_ejec_moneda = record.data.nombre}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Ejecución Comparativa" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :85,
			url :direccion + '../../../control/ejecucion/ActionListarEjecucion.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 720, 720 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ],
			submit:function (){
				g_id_parametro = componentes[0].getValue();
				g_fecha_ini = componentes[1].getValue()?componentes[1].getValue().dateFormat('m/d/Y'):'';
				g_fecha_fin = componentes[2].getValue()?componentes[2].getValue().dateFormat('m/d/Y'):'';
				g_id_depto = componentes[5].getValue();
				g_id_pptos = componentes[8].getValue();
				g_id_moneda = componentes[9].getValue();
				g_tipo_reporte = componentes[10].getValue();
				
				var data='&id_parametro='+g_id_parametro
				data+='&id_moneda='+g_id_moneda;
				data+='&id_depto='+g_id_depto;
				data+='&id_pptos='+g_id_pptos;
				data+='&fecha_ini='+g_fecha_ini;
				data+='&fecha_fin='+g_fecha_fin;
				data+='&tipo_reporte='+g_tipo_reporte;
				data+='&ejec_moneda='+txt_ejec_moneda;
				data+='&ejec_depto='+txt_ejec_depto;
				
				if (g_id_pptos != ''){
					window.open(direccion+'../../../control/ejecucion/reporte/ActionPDFEjecComparaJasper.php?'+data)
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