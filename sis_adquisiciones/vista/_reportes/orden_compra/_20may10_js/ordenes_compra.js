function ReporteOrdenCompra(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_rep_orden_compra,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
var ds_proveedor=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','mail_proveedor','telefono1_proveedor','desc_insti_per'])
	});
var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si&oc=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),
	baseParams:{m_sw_rendicion:'no',sw_inv_gasto:'si'}
	});
var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});	
var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	
var resultTplProv=new Ext.Template('<div class="search-item">','<b><i>{desc_insti_per}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo}</FONT>','<br><FONT COLOR="#B5A642">Email:{mail_proveedor}</FONT>','<br><FONT COLOR="#B5A642">Teléfono:{telefono1_proveedor}</FONT>','</div>');
var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');
	/////////// txt gerencia//////
	vectorAtributos[0]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo de Adquisición',
			vtype:'texto',
			emptyText:'Tipo de Adquisición...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['Todos'],['Bien'],['Servicio']]}),
			valueField:'valor',
			displayField:'valor',
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_adquisicion'
	};
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	// txt id_unidad_organizacional
	vectorAtributos[2]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc:'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
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
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_unidad_organizacional',
		id_grupo:0
	};
	//combo presupuesto	
     vectorAtributos[3]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_fina_regi_prog_proy_acti',
			displayField:'desc_epe',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200,
			disabled:false	
		},
		tipo:'ComboBox',
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_ep',
		id_grupo:0
	};
	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Proveedor',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Proveedor...',
			name:'desc_insti_per',
			desc:'desc_insti_per',
			store:ds_proveedor,
			valueField:'id_proveedor',
			displayField:'desc_insti_per',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplProv,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'proveedor',
		tipo:'ComboBox'
	};
///////// fecha_ini /////////
	vectorAtributos[5]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	///////// fecha /////////
	vectorAtributos[6]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Ordenes de Compra"};
	layout_rep_orden_compra=new DocsLayoutProceso(idContenedor);
	layout_rep_orden_compra.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_orden_compra,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
				
	}
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Ordenes de Compra "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,url:direccion+'../../../../../sis_adquisiciones/control/_reportes/orden_compra/ActionPDFOrdenCompra.php',abrir_pestana:true,titulo_pestana:obtenerTitulo,fileUpload:false,columnas:[420,280],
			        grupos:[{tituloGrupo:'Datos de Orden de Compra',columna:0,id_grupo:0}],parametros:''}
	};
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}