/**
 * Nombre:		  	    pagina_registro_comprobante.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:55:38
 */
function pagina_registro_comprobante(idContenedor,direccion,paramConfig,sw_vista){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var g_subsistema;
	var filtro;	
	var componentes=new Array();
	
	var comp_id_parametro;
	var comp_id_periodo_subsis;
	var comp_fecha_cbte;
	var comp_id_cbte_clase;
	var  cont_dia='CONTABLE DIARIO';
	var  cont_pre_dia='CONTABLE PRESUPUESTARIO DIARIO';
	var  cont_caja ='CONTABLE CAJA';
	var  cont_pre_caja ='CONTABLE PRESUPUESTARIO CAJA';
	var  cont_pago= 'CONTABLE PAGO';
	var  cont_pre_pago='CONTABLE PRESUPUESTARIO PAGO';
	var  pre='PRESUPUESTARIO';
	var datas_edit;
	var sw_editar;
	var g_id_moneda; 
	var g_simbolo;
	var g_observacion='';
	 
	//---DATA STORE
	this.setMoneda=function(id_moneda,simbolo){g_id_moneda=id_moneda;g_simbolo=simbolo};
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarRegistroComprobante.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[	'id_comprobante',
			'id_parametro',
			'desc_parametro',
			'nro_cbte',
			'momento_cbte',
			{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
			'concepto_cbte',
			'glosa_cbte',
			'acreedor',
			'aprobacion',
			'conformidad',
			'pedido',
			'id_periodo_subsis',
			'desc_periodo',
			'id_usuario',
			'desc_usuario', 
			'id_subsistema',
			'desc_subsistema',
			'id_cbte_clase',
			'desc_clase',
			'id_moneda',
			'desc_moneda',
			'id_gestion',
			'nombre_depto',
			'id_depto',
			'titulo_cbte'
		]),baseParams:{m_sw_vista:sw_vista},remoteSort:true});
		
		
	//carga datos XML
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
	//DATA STORE COMBOS

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',
			id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
			'cantidad_nivel','estado_gestion']),
			baseParams:{m_estado:2}
    });
 
/************/ 
		var ds_periodo_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
				reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema','id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','estado_periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'nombre_largo'])});	
		var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
					reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['PERSON_15.apellido_paterno','PERSON_15.apellido_materno','PERSON_15.nombre'])});
		var ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','codigo'])});

						
		var ds_cbte_clase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
				reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'},[	'id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento']),
				baseParams:{m_sw_vista:sw_vista}
		});
		var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
			});
	
//FUNCIONES RENDER
		function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{PERSON_15.apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.nombre}</FONT>','</div>');
		function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
		var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<b>Código:</b><FONT COLOR="#B5A642">{codigo}</FONT>','<b>Subsistema:</b><FONT COLOR="#B5A642">{nombre_corto}</FONT>','</div>');
		function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clase']);}
		var tpl_id_cbte_clase=new Ext.Template('<div class="search-item">','<b>Calse Cbte: </b><FONT COLOR="#B5A642">{desc_clase}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_clase}</FONT>','</div>');
		function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['desc_periodo']);}
		var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Subsistema: </b><FONT COLOR="#B5A642">{nombre_largo}</FONT><br>','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo}</FONT>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','</div>');
		function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
		
	function render_momento(value, p, record)
	{	if(value==0){return 'Contable';}
		if(value==1){return 'Devengado de Recursos';}
		if(value==2){return 'Recurso Percibido';	}
		if(value==3){return 'Devengado de Gasto o Inversión';}
		if(value==4){return 'Pagado de Gasto o Inversión';}
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	 Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		id_grupo:0,
		filtro_0:false,
		save_as:'id_comprobante'
	};
		Atributos[1]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Identificador',
			name: 'id_comprobante',
			allowBlank:true,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form: false,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'COMPRO.id_comprobante'         
		 
		//
		
	};
// txt id_parametro
	Atributos[2]={
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
			minListWidth:'100%',
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
			width:'100%',
			disabled:false,
			grid_indice:1	
			
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		//filtro_0:true,
		//filterColValue:'PARAM.gestion_conta',
		save_as:'id_parametro'
	};
	
		Atributos[3]={
			validacion:{
			name:'id_periodo_subsis',
			fieldLabel:'Periodo Subsistema',
			allowBlank:false,			
			emptyText:'Periodo Subsistema...',
			desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo_subsistema ,
			valueField: 'id_periodo_subsistema',
			displayField: 'desc_periodo',
			queryParam: 'filterValue_0',
			filterCol:'PERSIS.desc_periodo',
			typeAhead:true,
			tpl:tpl_id_periodo_subsistema,
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
			renderer:render_id_periodo_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		//filtro_0:true,
		//filterColValue:'PERSUB.estado_periodo',
		id_grupo:1,
		save_as:'id_periodo_subsis'
	};

// txt fecha_cbte
	Atributos[4]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha Registro',
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
		filterColValue:'COMPRO.fecha_cbte',
		dateFormat:'m-d-Y',
		id_grupo:1,
		defecto:new Date(),
		save_as:'fecha_cbte'
	};
	
	
// txt nro_cbte
	Atributos[5]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Número',
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		defecto:0,
		form: false,
		id_grupo:0,
		filtro_0:true,
		filterColValue:'COMPRO.nro_cbte',
		save_as:'nro_cbte'
	};
	
// txt id_subsistema
	Atributos[6]={
			validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:true,			
			emptyText:'Subsistema...',
			desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.codigo#SUBSIS.nombre_corto',
			typeAhead:true,
			tpl:tpl_id_subsistema,
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
			renderer:render_id_subsistema,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:9,
		id_grupo:1,
		filterColValue:'SUBSIS.codigo',
		save_as:'id_subsistema'
	};

 // txt id_documento_nro
	Atributos[7]={
			validacion:{
			name:'id_cbte_clase',
			fieldLabel:'Comprobante de',
			allowBlank:false,			
			emptyText:'Comprobante de...',
			desc: 'desc_clase', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cbte_clase,
			valueField: 'id_clase_cbte',
			displayField: 'desc_clase',
			queryParam: 'filterValue_0',
			filterCol:'CBCLAS.desc_clase',
			typeAhead:true,
			tpl:tpl_id_cbte_clase,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:5,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cbte_clase,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:2,
		filterColValue:'CBCLAS.desc_clase',
		save_as:'id_clase_cbte'
	};

	Atributos[8]={
		validacion:{
			name:'momento_cbte',
			fieldLabel:'Momento',
			allowBlank:false,
			align:'left', 
			emptyText:'Momento...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['0','Contable'],['1','Devengado de Recursos '],	['2','Recurso Percibido'],['3','Devengado de Gasto o Inversión'],['4','Pagado de Gasto o Inversión']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_momento,
			grid_editable:false,
			width_grid:200,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:2,
		save_as:'momento_cbte'
	};


// txt acreedor
	Atributos[9]={
		validacion:{
			name:'acreedor',
			fieldLabel:'Acreedor',
			allowBlank:true,
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
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'COMPRO.acreedor',
		save_as:'acreedor'
	};
// txt aprobacion
	Atributos[10]={
		validacion:{
			name:'aprobacion',
			fieldLabel:'Aprobación',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'COMPRO.aprobacion',
		save_as:'aprobacion'
	};
// txt conformidad
	Atributos[11]={
		validacion:{
			name:'conformidad',
			fieldLabel:'Conformidad',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'COMPRO.conformidad',
		save_as:'conformidad'
	};
// txt pedido
	Atributos[12]={
		validacion:{
			name:'pedido',
			fieldLabel:'Pedido',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:3,
		filterColValue:'COMPRO.pedido',
		save_as:'pedido'
	};
	



// txt concepto_cbte
Atributos[13]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Concepto',
			allowBlank:false,
			maxLength:1500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		id_grupo:4,
		filterColValue:'COMPRO.concepto_cbte',
		save_as:'concepto_cbte'
	};
// txt glosa_cbte
	Atributos[14]={
		validacion:{
			name:'glosa_cbte',
			fieldLabel:'Observación',
			allowBlank:true,
			maxLength:1500,
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
		id_grupo:4,
		filterColValue:'COMPRO.glosa_cbte',
		save_as:'glosa_cbte'
	};
		Atributos[15]={
		validacion:{
			name:'sw_validacion',
			fieldLabel:'sw_validacion',
			allowBlank:false,
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
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		defecto:0,
		form: true ,
		id_grupo:0,
 		save_as:'sw_validacion'
	};
	//id_depto
		Atributos[16]={
				validacion:{
					name:'id_depto',
					fieldLabel:'Departamento Contable',
					//allowBlank:false,
					allowBlank:true,
					emptyText:'Departamento...',
					desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_depto,
					valueField: 'id_depto',
					displayField: 'nombre_depto',
					queryParam: 'filterValue_0',
					filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
					typeAhead:false,
					tpl:tpl_id_depto,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:100,
					minListWidth:'80%',
				//	onSelect:function(record){},
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_depto,
					grid_visible:true,
					grid_editable:false,
					width_grid:220,
					width:'80%',
					disabled:false,
					grid_indice:4
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filtro_1:true,
				filterColValue:'dep.nombre_depto',
				save_as:'id_depto',
				id_grupo:2
			};
		
		Atributos[17]={
		validacion:{
			name:'desc_usuario',
			fieldLabel:'Usuario',
			allowBlank:true,
			maxLength:1500,
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
		id_grupo:0,
		 
		 
	};	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={titulo_maestro:'registro_comprobante',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/registro_transaccion/registro_transaccion.php'};
	var layout_registro_comprobante=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_registro_comprobante.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_registro_comprobante,idContenedor);
		//herencia
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_btnNew=this.btnNew;
		var CM_saveSuccess=this.saveSuccess;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_btnEdit =this.btnEdit;
		var btnEliminar =this.btnEliminar;
		var ClaseMadre_save=this.Save;
	 	var ClaseMadre_conexionFailure=this.conexionFailure
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	if ( sw_vista=='presupuesto'){var paramMenu={actualizar:{crear:true,separador:false}};}
	if (sw_vista=='validacion'){var paramMenu={eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};}
	if (sw_vista=='validacionGenerados'){var paramMenu={eliminar:{crear:true,separador:false},editar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};}
	
	if (sw_vista=='contablePresupuestario'||sw_vista=='contable'){var paramMenu={nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};}

	 function getSubsistema(id_subsistema)
	 {
if(id_subsistema==1){return 'ENDESIS';}
if(id_subsistema==2){return 'ACTIF';}
if(id_subsistema==3){return 'ALMIN';}
if(id_subsistema==4){return 'COMPRO';}
if(id_subsistema==5){return 'KARD';}
if(id_subsistema==6){return 'SSS';}
if(id_subsistema==7){return 'PARAM';}
if(id_subsistema==9){return 'SCI';}
if(id_subsistema==10){return 'FACTUR';}
if(id_subsistema==11){return 'PRESTO';}
if(id_subsistema==12){return 'TESORO';}
if(id_subsistema==13){return 'SIPOA';}
if(id_subsistema==14){return 'PLANS';}
if(id_subsistema==15){return 'CASIS';}
if(id_subsistema==16){return 'CORREO';}
if(id_subsistema==17){return 'CATALOG';}
if(id_subsistema==18){return 'SELPER';}
if(id_subsistema==19){return 'SEGPRO';}
if(id_subsistema==20){return 'SEGTRA';}
if(id_subsistema==23){return 'KARDEX';}
if(id_subsistema==24){return 'GESTEL';}
if(id_subsistema==26){return 'PSPRO';}
} 
	 function observacion_eliminar (btn, text){
	 	if(btn=='ok'){g_observacion=text;	
		var postData="cantidad_ids="+1;
			
		postData=postData+'&id_comprobante_0='+getSelectionModel().getSelected().data.id_comprobante;
		postData=postData+'&observacion_0='+text;
		
	 			Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
						width:150,
						height:200,
						closable:false
					});
					 
					Ext.Ajax.request({
						url:direccion+'../../../control/comprobante/ActionEliminarRegistroComprobante.php',
						params: postData,
						method:'POST',
						success: eliminarSucess,
						failure: function (resp ){Ext.MessageBox.hide();
								ContenedorPrincipal.conexionFailure(resp);
							//alert("Error al eliminar el comprobante id:"+getSelectionModel().getSelected().data.id_comprobante);
							},
						timeout:  100//TIEMPO DE ESPERA PARA DAR FALLO
					});
		
		
		//alert("llega aqui ");
	 	} 
	 
	 }
	 /*********************************************************************************/
	 function  eliminarSucess(resp){
		Ext.MessageBox.hide();//ocultamos el loading
		if(resp.responseXML&&resp.responseXML.documentElement){
			var root = resp.responseXML.documentElement;//recuperamos el resultado en formato XML
			var tc = root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
			Ext.mensajes.msg('Eliminación Exitosa', 'Se tienen "{0}" registros.', tc);
			var total_registros=new Number(tc);
			var total_paginas=Math.ceil(total_registros / paramConfig.TamanoPagina);
			//var paginaData=paging.getPageData();//los datos de la pagina
			//var pagina=paginaData.activePage; //recupera el numero de pagina
			//var puntero=0;
			//if(pagina>total_paginas){
				//pagina=pagina-1
			//}
			//if(pagina>1){puntero=(pagina-1)*configuracion.TamanoPagina}
			//para hacer que orden se mantenga
			//ds.lastOptions.params.start=puntero;
			//ds.load(ds.lastOptions);
			btn_todos();
			ds.rejectChanges();////vacia el vector de records modificados
			//sm.clearSelections()

			// ----------- registro  de eventos ----------//
			origen=undefined;
			if(root.getElementsByTagName('origen')[0]!= undefined){
				origen=root.getElementsByTagName('origen')[0].firstChild.nodeValue
			}
			parametros_mensaje={
				origen:origen,
				mensaje:root.getElementsByTagName('mensaje')[0].firstChild.nodeValue,
				tiempo_resp: root.getElementsByTagName('tiempo_resp')[0].firstChild.nodeValue,
				TotalCount:root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue
			};
		
		
		}
		else{
			//conexionFailure(resp)
			ContenedorPrincipal.conexionFailure(resp);
		}
	
	}
	 /*********************************************************************************/
if( sw_vista=='validacionGenerados'){
	 this.btnEliminar=function(){
	   var sm=getSelectionModel();
	    	var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		if(NumSelect==1){
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var sw=false;
			var confirmar;
			if(cont>0){//Para verificar si existen modificaciones hechas
				if(confirm('Tiene registros pendientes sin guardar que se perderan, desea continuar?')){
					sw=true
				}
			}
			else{
				sw=true
			}
			if(sw){
				Ext.MessageBox.prompt('Inserta la Observacion:', "Una ves eliminado el Comprobante 'No podra ser recuperado y revertira los procesos del subsitema "+getSubsistema(g_subsistema)+"' Esta seguro de Continuar ",observacion_eliminar)	
			}
		}
	
		
		if(NumSelect==0){
			Ext.MessageBox.alert('Estado', 'Seleccione un item primero.')
		}
		if(NumSelect>1){
			Ext.MessageBox.alert('Estado', 'Selecione un solo registro a la ves.')
		}}}  
		
	this.btnNew=function(){
		comp_id_parametro.store.baseParams={m_estado:2};
		comp_id_parametro.modificado=true;
		//desactivar();
		g_comprobante='';
		//CM_ocultarComponente(componentes[5]);
		ClaseMadre_btnNew();	
	};
	
	this.btnEdit=function(){
		activar();
	datas_edit=getSelectionModel().getSelected().data;
	
	/********************/
		ds_parametro.load
		({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_parametro:datas_edit.id_parametro
				},
			callback: function(){
				comp_id_parametro.store.baseParams={m_estado:2};
    			comp_id_parametro.modificado=true;
				ds_periodo_subsistema.baseParams={};
				ds_periodo_subsistema.load({
					params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_periodo_subsis:datas_edit.id_periodo_subsis
						},
						callback: function(){
					
							comp_fecha_cbte.minValue= ds_periodo_subsistema.getAt(0).data['fecha_inicio'];
							comp_fecha_cbte.maxValue=ds_periodo_subsistema.getAt(0).data['fecha_final'];
						 
								if(datas_edit.desc_clase==cont_dia||datas_edit.desc_clase==cont_caja||datas_edit.desc_clase==cont_pago||datas_edit.desc_clase==pre){
								componentes[8].store.proxy =new Ext.data.MemoryProxy( [['0','Diario']]);
								}
								else if(datas_edit.desc_clase==cont_pre_dia){	
								componentes[8].store.proxy = new Ext.data.MemoryProxy([['1','Devengado de Recursos '],['3','Devengado de Gasto o Inversión ']]);
								}	
								else if(datas_edit.desc_clase==cont_pre_caja ){      
								componentes[8].store.proxy = new Ext.data.MemoryProxy([['1','Devengado de Recursos '],['2','Recurso Percibido']]);
								}
								else if(datas_edit.desc_clase==cont_pre_pago)
								{
								componentes[8].store.proxy = new Ext.data.MemoryProxy([['3','Devengado de Gasto o Inversión '],['4','Pagado de Gasto o Inversión']]);
								}else{alert ("Error en Parametros de la Vista")}
								componentes[8].store.load();	
								comp_id_periodo_subsis.store.baseParams={m_sw_reg_comp:'si',m_id_gestion: ds_parametro.getAt(0).data['id_gestion'],m_id_subsistema:9,m_estado_periodo:'abierto'};
								comp_id_periodo_subsis.modificado=true;
							
								
							
						}
				});		
			}
		});
	 
		
	
	
	
	
	
	/*********************/
	CM_ocultarComponente(componentes[6]);
	ClaseMadre_btnEdit();
	
	};
	function mostrarActual(resp)
	{if(g_comprobante=='')
		{		 
		ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_sw_maximo:'si'
				}
			})	
		
		}
		else{
				if(sw_vista!='validacion'||sw_vista!='validacionGenerados'){	
				ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_comprobante:datas_edit.id_comprobante}});
				_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(datas_edit,'no',padre);
				}
				else{ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});}
		
		}
	
		sw_editar='si';
	if(sw_vista!='validacion'||sw_vista!='validacionGenerados'){
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.desbloquearMenu();
	}
	
	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
	if(componentes[15].getValue()=='1' ||componentes[15].getValue()=='2') 
	{
		btn_todos();
	}
	if(componentes[15].getValue()=='1' ||componentes[15].getValue()=='2') 
	{
			var data='m_id_comprobante='+g_comprobante;
				  data=data+'&m_id_moneda='+g_id_moneda;
				  data=data+'&m_simbolo='+g_simbolo;
				  data=data+'&m_desc_clases='+g_titulo;
				  data=data+'&m_momento_cbte='+g_cbte;
				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
		btn_todos();
	}
	CM_saveSuccess(resp);
//	alert('llega a qui222');
	}
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/comprobante/ActionEliminarRegistroComprobante.php'},
		Save:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php',
		params:{id_subsistema:9},
		success:mostrarActual
		},
		ConfirmSave:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:400,width:480,minWidth:150,minHeight:200,columnas:['95%'],
			grupos:[
			{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
			{tituloGrupo:'Periodo:',columna:0,id_grupo:1},
			{tituloGrupo:'Comprobante:',columna:0,id_grupo:2},
			{tituloGrupo:'Preguntar:',columna:0,id_grupo:3},
			{tituloGrupo:'Glosa:',columna:0,id_grupo:4}
			],
			closable:true,
			titulo:'Registro Comprobante'}			
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//getSelectionModel().on('rowdeselect',function(){_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.bloquearMenu();});
	getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.bloquearMenu();
						_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.getBoton('monedas-'+layout_registro_comprobante.getIdContentHijo()).enable();
						
					}
				})
	getSelectionModel().on('rowselect',function(){
					if(_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.bloquearMenu();
						_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.getBoton('monedas-'+layout_registro_comprobante.getIdContentHijo()).enable();
						
					}
				})
				
	}
	function InitRegistroComprobante()
		{
	 	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
 	for(i=0;i<Atributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}
	comp_id_parametro=ClaseMadre_getComponente('id_parametro');
	comp_id_periodo_subsis=ClaseMadre_getComponente('id_periodo_subsis');
	comp_fecha_cbte=ClaseMadre_getComponente('fecha_cbte');
	comp_id_cbte_clase=ClaseMadre_getComponente('id_cbte_clase');
	
	comp_id_parametro.on('select',f_filtrar_periodo);
	comp_id_periodo_subsis.on('select',f_filtrar_fecha);
	comp_fecha_cbte.on('blur',f_filtrar_comprobante);
	comp_id_cbte_clase.on('select',f_filtrar_momento);
	
	};
	function desactivar(){
		
		comp_id_periodo_subsis.setDisabled(true);
		comp_fecha_cbte.setDisabled(true);
		comp_id_cbte_clase.setDisabled(true);
		
		componentes[8].setDisabled(true);
		componentes[9].setDisabled(true);
		componentes[10].setDisabled(true);
		componentes[11].setDisabled(true);
		componentes[12].setDisabled(true);
		componentes[13].setDisabled(true);
		componentes[14].setDisabled(true);
	}
	function activar(){
		
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setDisabled(false);
		comp_id_cbte_clase.setDisabled(false);
		
		componentes[8].setDisabled(false);
		componentes[9].setDisabled(false);
		componentes[10].setDisabled(false);
		componentes[11].setDisabled(false);
		componentes[12].setDisabled(false);
		componentes[13].setDisabled(false);
		componentes[14].setDisabled(false);
	}
	function f_filtrar_periodo( combo, record, index ){
		comp_id_periodo_subsis.store.baseParams={m_sw_reg_comp:'si',m_id_gestion: record.data.id_gestion,m_id_subsistema:9,m_estado_periodo:'abierto'};
		comp_id_periodo_subsis.modificado=true;
		desactivar();
		comp_id_periodo_subsis.setValue('');
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setValue(new Date());
		comp_id_cbte_clase.setValue('');
		componentes[8].setValue('');
		
		componentes[9].setDisabled(false);
		componentes[10].setDisabled(false);
		componentes[11].setDisabled(false);
		componentes[12].setDisabled(false);
		componentes[13].setDisabled(false);
		componentes[14].setDisabled(false);
	}
	function f_filtrar_fecha( combo, record, index ){
		comp_fecha_cbte.minValue= record.data.fecha_inicio;comp_fecha_cbte.maxValue=record.data.fecha_final;
		
		desactivar();
		comp_fecha_cbte.setValue(new Date());
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setDisabled(false);
		comp_id_cbte_clase.setValue('');
		componentes[8].setValue('');
		
		componentes[9].setDisabled(false);
		componentes[10].setDisabled(false);
		componentes[11].setDisabled(false);
		componentes[12].setDisabled(false);
		componentes[13].setDisabled(false);
		componentes[14].setDisabled(false);
		
		comp_fecha_cbte.setDisabled(false);
	
	}
	function f_filtrar_comprobante(comboData){
		
	desactivar();
		comp_id_cbte_clase.setValue('');
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setDisabled(false);
		comp_id_cbte_clase.setDisabled(false);
		componentes[8].setValue('');
	
		componentes[9].setDisabled(false);
		componentes[10].setDisabled(false);
		componentes[11].setDisabled(false);
		componentes[12].setDisabled(false);
		componentes[13].setDisabled(false);
		componentes[14].setDisabled(false);
	}
	function f_filtrar_momento( combo, record, index ){
		
	if(record.data.desc_clase==cont_dia||record.data.desc_clase==cont_caja||record.data.desc_clase==cont_pago||record.data.desc_clase==pre)
	{
	componentes[8].store.proxy =new Ext.data.MemoryProxy( [['0','Diario']]);
	componentes[8].store.load();
	componentes[8].setValue(0);
	componentes[8].setDisabled(false);
	f_mostrar( combo, record, index );
	}
	if(record.data.desc_clase==cont_pre_dia)
	{	
	componentes[8].setValue('');
	componentes[8].store.proxy = new Ext.data.MemoryProxy([['1','Devengado de Recursos '],['3','Devengado de Gasto o Inversión '],['4','Pagado de Gasto o Inversión']]);
	componentes[8].setDisabled(false);
	}	
	if(record.data.desc_clase==cont_pre_caja )
	{      
	componentes[8].setValue('');
	componentes[8].store.proxy = new Ext.data.MemoryProxy([['1','Devengado de Recursos '],['2','Recurso Percibido']]);
	componentes[8].setDisabled(false);
	}
	if(record.data.desc_clase==cont_pre_pago)
	{
	componentes[8].setValue('');
	componentes[8].store.proxy = new Ext.data.MemoryProxy([['3','Devengado de Gasto o Inversión '],['4','Pagado de Gasto o Inversión']]);
	componentes[8].setDisabled(false);
	}
	componentes[8].store.load();
	activar();
	}
	function f_mostrar( combo, record, index ){
	
		componentes[9].setDisabled(false);
		componentes[10].setDisabled(false);
		componentes[11].setDisabled(false);
		componentes[12].setDisabled(false);
		componentes[13].setDisabled(false);
		componentes[14].setDisabled(false);
		
	}
	
	function btn_todos(){
	
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			}
			});
	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.bloquearMenu();
	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.getBoton('monedas-'+layout_registro_comprobante.getIdContentHijo()).enable();
	datas_edit.id_comprobante=0;
	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(datas_edit,'no',padre);
	sw_editar='no';
	}
	function btn_editar_transaccion(){
		
		var NumSelect = getSelectionModel().getCount();//recupera la cantidad de filas selecionadas
		
		if(NumSelect!=0){
			datas_edit=getSelectionModel().getSelected().data;
		ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_comprobante:datas_edit.id_comprobante
				
			}
			}
			
			);
	 _CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(datas_edit,'si',padre);
	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.desbloquearMenu();	
			
		}else {Ext.MessageBox.alert('Estado', 'Seleccione un item primero.');}
	}
	
	
	this.EnableSelect=function(sm,row,rec){
		
				cm_EnableSelect(sm,row,rec);
			 	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(rec.data,'no',padre);
				//_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.desbloquearMenu();
				if(sw_editar=='no'){
				_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.bloquearMenu();
				_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.getBoton('monedas-'+layout_registro_comprobante.getIdContentHijo()).enable();
				}
			
				g_comprobante=rec.data.id_comprobante;
				g_subsistema=rec.data.id_subsistema;
				g_titulo=rec.data.titulo_cbte;
				g_cbte=rec.data.momento_cbte;
				
	
	}

function cargar_grilla(store,rec,options ) 
	{
			//	cm_EnableSelect(sm,row,rec);
			 	_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(store.data,'no',padre);
				_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.desbloquearMenu();
			g_comprobante=store.data.id_comprobante;
	}	
	function btn_reporte_comprobante(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
				  data=data+'&m_id_moneda='+g_id_moneda;
				  data=data+'&m_simbolo='+g_simbolo;
				  data=data+'&m_desc_clases='+SelectionsRecord.data.titulo_cbte;
				  data=data+'&m_momento_cbte='+SelectionsRecord.data.momento_cbte;
				
				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}	
		function btn_documento_respaldo(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();
				var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
				  data=data+'&m_id_moneda='+g_id_moneda;
				  data=data+'&m_simbolo_moneda='+g_simbolo;
				  data=data+'&m_desc_clases='+SelectionsRecord.data.desc_clase;
				  data=data+'&m_acreedor='+SelectionsRecord.data.acreedor;
				  data=data+'&m_pedido='+SelectionsRecord.data.pedido;
				  data=data+'&m_concepto_cbte='+SelectionsRecord.data.concepto_cbte;
				  data=data+'&m_conformidad='+SelectionsRecord.data.conformidad;
				  data=data+'&m_aprobacion='+SelectionsRecord.data.aprobacion;
				
				//window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_registro_comprobante.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_comprobante/documentos_respaldo.php?'+data,'Documentos de Respaldo',ParamVentana);
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
	function btn_validar(){
		
			
			var sm=getSelectionModel();
			
			var NumSelect=sm.getCount();
			
			if(NumSelect!=0){
				datas_edit=sm.getSelected().data;
				Ext.MessageBox.confirm("Atención","Esta seguro de Validar Comprobante?",function(btn){if(btn=='yes'){ 
				componentes[15].setValue('1');
				//	 alert('llega a validacion');
			 	//  ClaseMadre_btnEdit();
			 	 ClaseMadre_save();	
				} });		
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
			}
		}
	function btn_validar_igualar(){

			var sm=getSelectionModel();
			
			var NumSelect=sm.getCount();

			if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
				Ext.MessageBox.confirm("Atención","Esta seguro de Validar e Igualar  Comprobante?",
			function(btn){if(btn=='yes'){
			componentes[15].setValue('2');
			 ClaseMadre_save();
			
			
			} });		
				
				
	 
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
			}
		}
	function btn_reporte_libro_diario(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			//if(NumSelect!=0){

			//	var SelectionsRecord=sm.getSelected();
				//var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;

				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroDiario.php')

			
			/*else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}*/
		}	
	function btn_reporte_libro_mayor(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
		
				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayor.php')

		}		
			
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_registro_comprobante.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitRegistroComprobante();

if(sw_vista=='validacion'||sw_vista=='validacionGenerados'){
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Todos',btn_todos,true,'todos','Todos');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Validar Comprobante',btn_validar,true,'validar_comprobante','Validar Comprobante');
 	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Validar e Igualar Comprobante',btn_validar_igualar,true,'validar_comprobante','Validar e Igualar Comprobante');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
 	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Documento de Respaldo ',btn_documento_respaldo,true,'documento_respaldo','');
 /*	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Mayor',btn_reporte_libro_mayor,true,'reporte_libro_mayor','');
*/
}	
if (sw_vista=='presupuesto'){ 
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Todos',btn_todos,true,'todos','Todos');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
/* 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Mayor',btn_reporte_libro_mayor,true,'reporte_libro_mayor','');
*/}	
if (sw_vista=='contablePresupuestario'||sw_vista=='contable')
{
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Todos',btn_todos,true,'todos','Todos');
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Editar Transacción',btn_editar_transaccion,true,'todos','Editar Transacción');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
 /*	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
 	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libro Mayor',btn_reporte_libro_mayor,true,'reporte_libro_mayor','');
*/
}
 		
	padre=this;
	CM_ocultarGrupo('Oculto:');
	//CM_mostrarGrupo('Oculto:');
	
	layout_registro_comprobante.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}
