function pagina_repeje_detalle(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_repeje_detalle;
	var ContPes = 1;
	var vectorAtributos = new Array;
	
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	var g_admi;
	
	var comp_id_parametro, comp_id_tipo_pres, comp_fecha_ini, comp_fecha_fin, comp_id_moneda, comp_desc_moneda, comp_desc_gestion, comp_desc_tipo_pres;
	var comp_id_presupuesto, comp_desc_ppto, comp_id_partida, comp_desc_partida;
	
	// ------------------ PARÁMETROS --------------------------//
	/////DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	
	var ds_tipo_pres = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_ppto = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });
	
	ds_parametro.load();
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro = new Ext.Template('<div class="search-item">','<b>{gestion_pres}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_tipo_pres(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
	var tpl_id_tipo_pres = new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_ppto(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ppto = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo_partida} {nombre_partida}</FONT><br>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			name: 'sw_ejecuta',
			fieldLabel:'Ejecución',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Por Presupuesto'],['2','Por Partida']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:200
		},
		tipo: 'ComboBox',
		id_grupo:0,
		save_as:'sw_ejecuta'
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
			displayField: 'gestion_pres',
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
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	vectorAtributos[2]={
		validacion:{
			name:'id_tipo_pres',
			fieldLabel:'Presupuesto de',
			allowBlank:false,			
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres,
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
			renderer:render_id_tipo_pres,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	};

	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Presupuesto',
			allowBlank:false,
			emptyText:'Presupuesto...',
			name:'id_presupuesto',
			desc:'nombre',
			store:ds_ppto,
			valueField:'id_datos',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_ppto,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:10,
			minListWidth:380,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_ppto,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:2,
		filtro_0:false,
 		form: true,
 		save_as:'id_presupuesto'
	};	
	
	vectorAtributos[4]={
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
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		id_grupo:4,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};

	vectorAtributos[5]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['CD','PDF - c/Detalle Consulta'],['SD','PDF - s/Detalle Consulta'],['xls','XLS - Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:4,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[6] = {
		validacion : {
			name :'fecha_ini',
			fieldLabel :'Fecha Inicial:',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/2000',
			renderer :formatDate,
			disabled :false
		},
		id_grupo:1,
		tipo :'DateField',
		save_as :'fecha_ini',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[7] = {
		validacion : {
			name :'fecha_fin',
			fieldLabel :'Fecha Final:',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo:1,
		tipo :'DateField',
		save_as :'fecha_fin',
		dateFormat :'m/d/Y',
		defecto :""
	};

	vectorAtributos[8]={
		validacion:{
 			name:'id_partida',
			fieldLabel:'Partida/Rubro',
			allowBlank:false,			
			emptyText:'Partida... ',
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
			queryDelay:380,
			pageSize:20,
			minListWidth:380,
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
      		width:380		
		}, 
		tipo:'ComboBox',
		id_grupo:3,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};
	
	vectorAtributos[9] = {
		validacion : {
			labelSeparator :'',
			name :'desc_moneda',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[10] = {
		validacion : {
			labelSeparator :'',
			name :'desc_gestion',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[11] = {
		validacion : {
			labelSeparator :'',
			name :'desc_tipo_pres',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[12] = {
		validacion : {
			labelSeparator :'',
			name :'desc_partida',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[13] = {
		validacion : {
			labelSeparator :'',
			name :'desc_ppto',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	
	vectorAtributos[14] = {
		validacion : {
			labelSeparator :'',
			name :'sw_vista',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:5
	};
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_repeje_detalle = new DocsLayoutProceso(idContenedor);
	layout_repeje_detalle.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_repeje_detalle, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var getComponente=this.getComponente;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		comp_sw_vista = ClaseMadre_getComponente('sw_vista');
		comp_sw_ejecuta = ClaseMadre_getComponente('sw_ejecuta');
		comp_id_parametro = ClaseMadre_getComponente('id_parametro');
		comp_id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');
		comp_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		comp_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		comp_id_moneda = ClaseMadre_getComponente('id_moneda');
		comp_desc_moneda = ClaseMadre_getComponente('desc_moneda');
		comp_desc_gestion = ClaseMadre_getComponente('desc_gestion');
		comp_desc_tipo_pres = ClaseMadre_getComponente('desc_tipo_pres');
		
		comp_id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		comp_desc_ppto = ClaseMadre_getComponente('desc_ppto');
		
		comp_id_partida = ClaseMadre_getComponente('id_partida');
		comp_desc_partida = ClaseMadre_getComponente('desc_partida');
		
		comp_id_parametro.on('select',f_evento_parametro);	
		comp_id_tipo_pres.on('select',f_evento_tipo_pres);	
		comp_fecha_ini.on('blur',f_evento_ini);		
		comp_id_moneda.on('select',f_evento_id_moneda);	
		comp_id_presupuesto.on('select',f_evento_ppto);
		comp_id_partida.on('select',f_evento_partida);
		
		comp_sw_ejecuta.on('select',f_evento_sw_ejecuta);
		
		comp_sw_vista.setValue(sw_vista);
		
		g_admi = 'IN';
		
		CM_ocultarGrupo('Hidden');
		CM_ocultarGrupo('Partida');
	}
	
	function f_evento_sw_ejecuta(combo, record, index){
		CM_ocultarGrupo('Partida');
		comp_id_partida.allowBlank=true;
		comp_id_partida.setValue('');
		
		comp_id_parametro.setValue('');
		comp_id_tipo_pres.setValue('');
		
		if (record.data.ID == '1'){
			CM_ocultarGrupo('Partida');
		}
		if (record.data.ID == '2'){
			comp_id_partida.allowBlank=false;
			
			CM_mostrarGrupo('Partida');
		}
	}
	
	function f_evento_parametro(combo, record, index){	
		var intGestion = record.data.gestion_pres;
		var dte_fecha_ini_valid = new Date('01/01/'+intGestion+' 00:00:00');
		var dte_fecha_fin_valid = new Date('12/31/'+intGestion+' 00:00:00');
			
		//Aplica la validación en la fecha
		comp_fecha_ini.minValue = dte_fecha_ini_valid;
		comp_fecha_ini.maxValue = dte_fecha_fin_valid;
		comp_fecha_fin.minValue = dte_fecha_ini_valid;
		comp_fecha_fin.maxValue = dte_fecha_fin_valid;
			
		//Define un valor por defecto
		comp_fecha_ini.setValue(dte_fecha_ini_valid);
		comp_fecha_fin.setValue(dte_fecha_fin_valid);

		comp_id_tipo_pres.store.baseParams = {m_id_parametro:comp_id_parametro.getValue(),m_incluir_dobles:'no'};
		
		comp_id_tipo_pres.modificado=true;
		comp_id_tipo_pres.setValue('');

		comp_id_presupuesto.store.baseParams = {sw_admi:g_admi,sw_listado:'ppto',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:9};
		comp_id_presupuesto.modificado = true;
		comp_id_presupuesto.setValue('');
		
		comp_id_partida.store.baseParams = {sw_vista_reporte:'rep_ejecucion_partida',rep_id_parametro:comp_id_parametro.getValue(),id_tipo_pres:5};
		comp_id_partida.modificado=true;
		comp_id_partida.setValue('');
		
		comp_desc_gestion.setValue(record.data.gestion_pres);
	}
	
	function f_evento_tipo_pres(combo, record, index){
		comp_id_partida.setValue('');
		comp_desc_tipo_pres.setValue(record.data.desc_tipo_pres);
		
		comp_id_presupuesto.store.baseParams = {sw_admi:g_admi,sw_listado:'ppto',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
		comp_id_presupuesto.modificado = true;
		comp_id_presupuesto.setValue('');
		
		comp_id_partida.store.baseParams = {sw_vista_reporte:'rep_ejecucion_partida',rep_id_parametro:comp_id_parametro.getValue(),id_tipo_pres:comp_id_tipo_pres.getValue()};
		comp_id_partida.modificado=true;
		comp_id_partida.setValue('');
	}
	
	function f_evento_ini(comboData){comp_fecha_fin.minValue = comp_fecha_ini.getValue()}
	
	function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}

	function f_evento_ppto(combo, record, index){comp_desc_ppto.setValue(record.data.codigo_nombre)}
	
	function f_evento_partida(combo, record, index){comp_desc_partida.setValue(record.data.desc_par)}
	
	function obtenerTitulo() {
		var titulo = "EJECUCION PRESUPUESTARIA" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :95,
			url :direccion + '../../../control/rep_ejecuta/reporte/ActionPDF_Repeje_Detalle_Jasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 370, 510 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Periodo', columna :0, id_grupo :1},
				{tituloGrupo :'Presupuesto', columna :1, id_grupo :2},
				{tituloGrupo :'Partida', columna :1, id_grupo :3},
				{tituloGrupo :'Reporte', columna :0, id_grupo :4},
				{tituloGrupo :'Hidden', columna :0, id_grupo :5}
				
		]}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}