function pagina_eeff_division(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_eff_division, h_txt_gestion, h_txt_mes, ds_linea;
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
	
	var ds_reporte_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff'])
	});
	
	var ds_depto_div = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_div/ActionListarDepartamentoDiv.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_division',totalRecords: 'TotalCount'},['id_depto_division','id_depto','desc_depto','codigo_division','division','estado'])
		,baseParams:{id_depto:-1, sw_del:'no'}
    });
	
	ds_depto.load();
	ds_depto_div.load();
	var data_deptos=new Array();
	var indice=0;
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_reporte_eeff(value, p, record){return String.format('{0}', record.data['nombre_eeff']);}
	var tpl_id_reporte_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B50000">{nombre_depto}</FONT>','</div>');		
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			name:'id_reporte_eeff',
			fieldLabel:'Estado Financiero',
			allowBlank:false,			
			emptyText:'...',
			desc: 'nombre_eeff', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_reporte_eeff,
			valueField: 'id_reporte_eeff',
			displayField: 'nombre_eeff',
			queryParam: 'filterValue_0',
			filterCol:'nombre_eeff',
			typeAhead:false,
			tpl:tpl_id_reporte_eeff,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_reporte_eeff,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EFR.nombre_eeff',
		save_as:'id_reporte_eeff'
   };

	vectorAtributos[1]={
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
	
	vectorAtributos[2] = {
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
	
	vectorAtributos[3] = {
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
	
	vectorAtributos[4]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Depto.', 
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
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'id_depto'
	};

	vectorAtributos[5] = {
		validacion : {
			name :'id_depto_divs',
			fieldLabel :'División(s)',
			store:ds_depto_div,
			valueField :'id_depto_division',
			displayField :'division',
			width :150,
			height :150,
			allowBlank :false,
			width :300
		},
		tipo :'Multiselect',
		save_as :'id_depto_divs'
	};
		  
	vectorAtributos[6]={
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
	
	vectorAtributos[7]={
		validacion:{
			name:'eeff_actual',
			fieldLabel:'Actualización',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			//renderer:render_sino,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'eeff_actual'
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'eeff_nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			align:'center', 
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4'],['5','N - 5'],['6','N - 6'],['7','N - 7'],['8','N - 8']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			//renderer:render_sino,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'eeff_nivel'
	};
	
	vectorAtributos[9]={
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
	
	vectorAtributos[10] = {
		validacion : {
			labelSeparator :'',
			name :'eeff_depto',
			inputType :'hidden'
		},
		tipo :'Field'
	};
	
	vectorAtributos[11] = {
		validacion : {
			labelSeparator :'',
			name :'eeff_nombre',
			inputType :'hidden'
		},
		tipo :'Field'
	};
	
	vectorAtributos[12] = {
		validacion : {
			labelSeparator :'',
			name :'eeff_moneda',
			inputType :'hidden'
		},
		tipo :'Field'
	};
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_eeff_division = new DocsLayoutProceso(idContenedor);
	layout_eeff_division.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_eeff_division, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[0].on('select', evento_eeff);
		componentes[1].on('select', evento_parametro);		
		componentes[2].on('change', evento_fecha_inicio);
		componentes[4].on('select', evento_depto);
		componentes[6].on('select', evento_moneda);
	}
	
	function evento_parametro( combo, record, index ){
		//Validación de fechas
		var id = componentes[1].getValue();
		if(componentes[1].store.getById(id)!=undefined){
			var intGestion=componentes[1].store.getById(id).data.gestion_conta;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[2].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[2].maxValue=dte_fecha_fin_valid;
			componentes[3].minValue=dte_fecha_ini_valid;
			componentes[3].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[2].setValue(dte_fecha_ini_valid);
			componentes[3].setValue(dte_fecha_fin_valid);	
		}
	}

	function evento_fecha_inicio(combo, record, index) {
		var fecha_inicio_val = componentes[2].getValue();
		componentes[3].minValue = fecha_inicio_val;
	}
	
	function evento_depto(combo,record, index){
		g_id_depto = componentes[4].getValue();
		componentes[10].setValue(record.data.nombre_depto);
		
		ds_depto_div.baseParams={
				id_depto:g_id_depto, 
				sw_del:'no'
		}
		
		ds_depto_div.load();
	}
	
	function evento_eeff(combo,record, index){componentes[11].setValue(record.data.nombre_eeff)}
	
	function evento_moneda(combo,record, index){componentes[12].setValue(record.data.nombre)}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Estado Financiero Consolidado" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../control/eeff/reporte/ActionPDFEeffDivisionJasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 420, 520 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ]
	/*,
			submit:function (){
				g_id_reporte_eeff = componentes[0].getValue();
				g_id_parametro = componentes[1].getValue();
				g_fecha_ini = componentes[2].getValue()?componentes[2].getValue().dateFormat('m/d/Y'):'';
				g_fecha_fin = componentes[3].getValue()?componentes[3].getValue().dateFormat('m/d/Y'):'';
				g_id_depto = componentes[6].getValue();
				g_id_depto_divs = componentes[8].getValue();
				g_id_moneda = componentes[9].getValue();
				g_eeff_actual = componentes[10].getValue();
				g_eeff_nivel = componentes[11].getValue();
				g_tipo_reporte = componentes[12].getValue();
				
				var data='&id_reporte_eeff='+g_id_reporte_eeff
				data+='&id_parametro='+g_id_parametro;
				data+='&id_moneda='+g_id_moneda;
				data+='&id_depto='+g_id_depto;
				data+='&id_depto_divs='+g_id_depto_divs;
				data+='&fecha_ini='+g_fecha_ini;
				data+='&fecha_fin='+g_fecha_fin;
				data+='&eeff_actual='+g_eeff_actual;
				data+='&eeff_nivel='+g_eeff_nivel;
				data+='&tipo_reporte='+g_tipo_reporte;
				data+='&eeff_nombre='+txt_eeff_nombre;
				data+='&eeff_moneda='+txt_eeff_moneda;
				data+='&eeff_depto='+txt_eeff_depto;
				
				if (g_id_depto_divs != ''){
					window.open(direccion+'../../../control/eeff/reporte/ActionPDFEeffDivisionJasper.php?'+data)
				}
			}*/
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}