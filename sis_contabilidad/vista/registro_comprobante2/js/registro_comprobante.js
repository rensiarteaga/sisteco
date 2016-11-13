/**
* Nombre:		  	    pagina_registro_comprobante.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		2008-09-16 17:55:38
*/
function pagina_registro_comprobante(idContenedor,direccion,paramConfig , sw_vista){
	var	g_limit='';
	var	g_CantFiltros='';
	var	g_ids_depto='';
	var	g_depto='';
	var Atributos=new Array(),sw=0;
	var g_comprobante;
	var g_subsistema;
	var filtro;
	
	var comp_id_parametro, comp_id_periodo_subsis, comp_fecha_cbte, comp_id_moneda_cbte, comp_id_tipo_cambio, comp_tipo_cambio, comp_nro_cbte;
	var	comp_id_cbte_clase, comp_momento_cbte, comp_id_depto, comp_id_subsistema;
	var	comp_acreedor, comp_aprobacion, comp_conformidad, comp_pedido, comp_concepto_cbte, comp_glosa_cbte;
	var	comp_id_usuario_mod, comp_justificacion_edicion, comp_id_moneda_sola;
	var	comp_fk_comprobante, comp_tipo_relacion;
	
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
	var g_id_subsistem_contabilidad=9;
	var g_fecha_inicio=new Date();
	var g_fecha_fin=new Date();
	var g_fecha_fin=new Date();
	var g_depen;
	
	var padre;
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
		'titulo_cbte',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
		'id_moneda_cbte',
		'tipo_cambio',
		'nombre_moneda_cbte',
		'prioridad_moneda_cbte',
		'estado_cbte',
		'id_usuario_mod',
		'fk_comprobante',
		'fk_desc_cbte',
		'tipo_relacion',
		'desc_cbte',
		'sw_activo_fijo',
		'cbtes_depen'
		]),

		baseParams:{m_sw_vista:sw_vista},
		remoteSort:true});

	var ds_cbte = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarRegistroComprobante.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'},['id_comprobante','id_parametro','desc_parametro','nro_cbte','momento_cbte',{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},'concepto_cbte','glosa_cbte','acreedor','aprobacion','conformidad','pedido','id_periodo_subsis','desc_periodo','id_usuario','desc_usuario','id_subsistema','desc_subsistema','id_cbte_clase','desc_clase','id_moneda','desc_moneda','id_gestion','nombre_depto','id_depto','titulo_cbte',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'id_moneda_cbte','tipo_cambio','nombre_moneda_cbte','prioridad_moneda_cbte','estado_cbte','id_usuario_mod','fk_comprobante','desc_cbte','tipo_relacion'])});
	var tpl_fk_id_cbte=new Ext.Template('<div class="search-item">',
										'<b>Nro.: </b><FONT COLOR="#0000ff">{nro_cbte}</FONT>',
										'<br><b>Fecha: </b><FONT COLOR="#0000ff">{fecha_cbte}</FONT>',
										'<br><b>Concepto: </b><FONT COLOR="#0000ff">{concepto_cbte}</FONT>',
										'<br><b>Glosa: </b><FONT COLOR="#0000ff">{glosa_cbte}</FONT>',
										'<br><b>Acreedor: </b><FONT COLOR="#0000ff">{acreedor}</FONT>',
										'<br><b>Aprobacion: </b><FONT COLOR="#0000ff">{aprobacion}</FONT>',
										'<br><b>Conformidad: </b><FONT COLOR="#0000ff">{conformidad}</FONT>',
										'<br><b>Pedido: </b><FONT COLOR="#0000ff">{pedido}</FONT>','</div>');
	
	function render_fk_cbte(value, p, record){return String.format('{0}', record.data['fk_desc_cbte']);}

	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2, m_vigente:'si'}
		});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{sw_reg_comp:'si'}});
		
	var ds_tipo_cambioOCV = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambioOCV.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_tipo_cambio',totalRecords: 'TotalCount'},['id_tipo_cambio',{name: 'tc_origen', type: 'string'},{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},'tipo_cambio','id_moneda','desc_tc','des_moneda'])});
		
	var ds_periodo_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'},['id_periodo_subsistema','id_periodo','periodo','desc_periodo','id_subsistema','desc_subsistema','estado_periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'nombre_largo'])});
		
	var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['PERSON_15.apellido_paterno','PERSON_15.apellido_materno','PERSON_15.nombre'])});
		
	var ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','codigo'])});

	var ds_cbte_clase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'},[	'id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento']),
		baseParams:{m_:0}
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});

	//RCM
	var ds_usuario_mod = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuarioVista.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','login','nombre_completo','observaciones'])});
	//FIN RCM

	//FUNCIONES RENDER
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestion: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','</div>');
	
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{PERSON_15.apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{PERSON_15.nombre}</FONT>','</div>');
	
	function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
	var tpl_id_subsistema=new Ext.Template('<div class="search-item">','<b>Codigo:</b><FONT COLOR="#B5A642">{codigo}</FONT>','<b>Subsistema:</b><FONT COLOR="#B5A642">{nombre_corto}</FONT>','</div>');
	
	function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clase']);}
	var tpl_id_cbte_clase=new Ext.Template('<div class="search-item">','<b>{desc_clase}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['desc_periodo']);}
	var tpl_id_periodo_subsistema=new Ext.Template('<div class="search-item">','<b>Periodo: </b><FONT COLOR="#B5A642">{desc_periodo}</FONT>','<b> - </b><FONT COLOR="#B5A642">{estado_periodo}</FONT>','<br></b><FONT COLOR="#B5A642">{nombre_largo}</FONT><br>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda_cbte']);}
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<b><FONT COLOR="#B5A642"><b> - </b>{simbolo}</FONT>','</div>');

	function render_id_tipo_cambioOCV(value, p, record){rf = ds_tipo_cambioOCV.getById(value);
	if(rf!=null){record.data['id_tipo_cambio'] =rf.data['id_tipo_cambio'];record.data['desc_tc'] =rf.data['tipo_cambio'];}
	return String.format('{0}',record.data['desc_tc'])}
	var tpl_id_tipo_cambioOCV=new Ext.Template('<div class="search-item">','<b><i>{desc_tc}</i></b>', '</div>');

	var ds_depto_menu = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?m_id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),remoteSort:true});

	//RCM
	var tpl_id_usuario_mod=new Ext.Template('<div class="search-item">','{nombre_completo}','</div>');
	function render_id_usuario_mod(value, p, record){return String.format('{0}', record.data['desc_usuario_mod']);}
	//FIN RCM

	function render_momento(value, p, record)
	{	if(value==0){return 'Contable';}
		if(value==1||value==3){return 'Devengado';}
		if(value==4){return 'Pagado o Percibido';}
		if(value==5){return 'Reversion Devengado';}
		if(value==6){return 'Reversion Pagado o Percibido';	}
		if(value==7){return 'Ajustar Devengado';	}
		if(value==8){return 'Ajustar Pagado o Percibido';	}
	}	
	function render_sw_activo_fijo(value, p, record)
	{	if(value=='si'){return 'SI';}
		if(value=='no'){return 'NO';}
	}
	
	function render_tipo_relacion(value, p, record)
	{	if(value=='pagado_del_devengado'){return 'Pagado del Devengado';}
		if(value=='pagado_del_devengado_y_ajuste'){return 'Pagado del Devengado y Ajuste';}
		if(value=='ajuste'){return 'Ajuste';}
		if(value=='dependiente'){return 'Dependiente';}
	}
	
	function render_cbtes_depen(value,cell,record,row,colum,store){
		if(store.getAt(row).data['cbtes_depen'] > 0){
		return  '<span style="color:red;">' + value +'</span>'}	
		if(store.getAt(row).data['cbtes_depen'] == 0){return  value }
	 
	}	
	/////////////////////////
	// Definicion de datos //
	/////////////////////////
	config_depto={nombre:'Depto',descripcion:'codigo_depto',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};

	//en la posicion 0 siempre esta la llave primaria
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
			width_grid:80,
			width:'100%',
			renderer: render_cbtes_depen,
			disabled:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form: false,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMPRO.id_comprobante'
	};
	
	// txt id_parametro
	Atributos[2]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestion',
			allowBlank:false,
			emptyText:'Gestion...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_conta',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			align:'center',
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:150,
			disabled:false,
			grid_indice:3

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
			fieldLabel:'Periodo SubSistema',
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
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_periodo_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:150,
			disabled:false,
			grid_indice:4
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
			align:'center',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:90,
			disabled:false
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMPRO.fecha_cbte',
		dateFormat:'m-d-Y',
		id_grupo:1,
		defecto:new Date(),
		save_as:'fecha_cbte'
	};
	// txt nro_cbte
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Numero',
			name: 'nro_cbte',
			allowBlank:true,
			allowDecimals:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disabled:true,
			grid_indice:2
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
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
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
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
		filtro_1:true,
		defecto:g_id_subsistem_contabilidad,
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
			queryDelay:280,
			pageSize:5,
			minListWidth:280,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cbte_clase,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:280,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
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
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['0','Contable'],['1','Devengado'],['4','Pagado o Percibido'],['5','Reversion Devengado'],['6','Reversion Pagado o Percibido'],['7','Ajustar Devengado'],['8','Ajustar Pagado o Percibido']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_momento,
			grid_editable:false,
			width_grid:120,
			minListWidth:200,
			width:200,
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
			width_grid:250,
			width:'100%',
			disabled:false
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filtro_1:true,
		id_grupo:3,
		filterColValue:'COMPRO.acreedor',
		save_as:'acreedor'
	};
	// txt aprobacion
	Atributos[10]={
		validacion:{
			name:'aprobacion',
			fieldLabel:'Aprobacion',
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
		filtro_1:true,
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
		filtro_1:true,
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
		filtro_1:true,
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
			width_grid:200,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filtro_1:true,
		id_grupo:4,
		filterColValue:'COMPRO.concepto_cbte',
		save_as:'concepto_cbte'
	};
	// txt glosa_cbte
	Atributos[14]={
		validacion:{
			name:'glosa_cbte',
			fieldLabel:'Observacion',
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
		filtro_1:true,
		id_grupo:4,
		filterColValue:'COMPRO.glosa_cbte',
		save_as:'glosa_cbte'
	};

	//id_depto
	Atributos[15]={
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
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:280,
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

	Atributos[16]={
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
			width_grid:120,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		//filtro_0:true,
		//filtro_1:true,
		id_grupo:0
	};
	
	Atributos[17]={
		validacion:{
			name:'id_moneda_cbte',
			fieldLabel:'Moneda',
			allowBlank:true,
			emptyText:'Moneda...',
			desc: 'nombre_moneda_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:105,
			width:150,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		defecto:1,
		filterColValue:'monedacbte.nombre',
		id_grupo:1,
		save_as:'id_moneda_cbte'
	};
	
	Atributos[18]={
		validacion:{
			name:'id_tipo_cambio',
			fieldLabel:'T/C Origen',
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
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_cambioOCV,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:280,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:1,
		filtro_0:false
	};
	Atributos[19]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo Cambio',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:10,//para numeros float
			allowNegative:false,
			allowMil:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer:render_moneda_16,
			width_grid:80,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'COMPRO.tipo_cambio',
		save_as:'tipo_cambio'
	};

	Atributos[20]={
		validacion:{
			name:'id_usuario_mod',
			fieldLabel:'Responsable de Modificación',
			allowBlank:true,
			emptyText:'Nombre...',
			store:ds_usuario_mod,
			valueField:'id_usuario',
			displayField:'nombre_completo',
			queryParam:'filterValue_0',
			filterCol:'nombre_completo',
			typeAhead:false,
			tpl:tpl_id_usuario_mod,
			forceSelection:false,
			mode:'remote',
			queryDelay:280,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:280
		},
		form: true,
		tipo:'ComboBox',
		id_grupo:5
	};

	Atributos[21]={
		validacion:{
			name:'estado_cbte',
			fieldLabel:'Estado',
			width_grid:50,
			grid_editable:false,
			grid_visible:true
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
	
	Atributos[22]={
		validacion:{
			name:'justificacion_edicion',
			fieldLabel:'Justificación',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		id_grupo:5,
		form: true,
	};
	 
	Atributos[23]={
		validacion:{
			name:'fk_comprobante',
			fieldLabel:'Ajuste o Devengado',
			allowBlank:true,
			emptyText:'Ajuste...',
			desc: 'fk_desc_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cbte,
			valueField: 'id_comprobante',
			displayField: 'desc_cbte',
			queryParam: 'filterValue_0',
			filterCol:'COMPRO.nro_cbte#COMPRO.momento_cbte#COMPRO.fecha_cbte#COMPRO.concepto_cbte#COMPRO.glosa_cbte#COMPRO.acreedor#COMPRO.aprobacion#COMPRO.conformidad#COMPRO.pedido',
			typeAhead:false,
			tpl:tpl_fk_id_cbte,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_fk_cbte,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:280,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
 		filterColValue:'compro.fk_comprobante',
		id_grupo:6,
		save_as:'fk_comprobante'
	};
	
	Atributos[24]={
		validacion:{
			name:'tipo_relacion',
			fieldLabel:'Tipo Relacion',
			allowBlank:true,
			align:'left',
			emptyText:'Tipo Relaci...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['pagado_del_devengado','pagado_del_devengado'],['pagado_del_devengado_y_ajuste','pagado_del_devengado_y_ajuste'],['ajuste','ajuste']]}),
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_tipo_relacion,
			grid_editable:false,
			width_grid:100,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:6,
		save_as:'tipo_relacion'
	};
	
	Atributos[25]={
		validacion:{
			name:'sw_activo_fijo',
			fieldLabel:'Activo Fijo',
			allowBlank:true,
			align:'left',
			emptyText:'Activo Fijo...',
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
			grid_visible:true,
			renderer:render_sw_activo_fijo,
			grid_editable:false,
			width_grid:100,
			minListWidth:200,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
	 	filterColValue:'compro.sw_activo_fijo',
		id_grupo:2,
		save_as:'sw_activo_fijo'
	}; 
	
	Atributos[26]={
		validacion:{
			labelSeparator:'',
			name: 'cbtes_depen',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		id_grupo:0,
		filtro_0:false,
		save_as:'cbtes_depen'
	};

	Atributos[27]={
		validacion:{
			name:'id_moneda_sola',
			fieldLabel:'Gabar SOLO en',
			allowBlank:true,
			emptyText:'Moneda...',
			desc: 'nombre_moneda_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:false,
			width_grid:105,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filtro_1:false,
		defecto:1,
		filterColValue:'monedacbte.nombre',
		id_grupo:7,
		save_as:'id_moneda_sola'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'registro_comprobante',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/registro_transaccion2/registro_transaccion.php?idSub='+decodeURI('Transaccion Detalle')+'&'};
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
	var CM_btnNew=this.btnNew;
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
	var CM_btnEdit =this.btnEdit;
	var ClaseMadre_Eliminar =this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_conexionFailure=this.conexionFailure
	var CM_getFormulario=this.getFormulario;

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////
	//guardar:{crear:false,separador:false},
	if(sw_vista=='gestionar_cbte'){
		var paramMenu={nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	}
	if(sw_vista=='libro_diario'){
		var paramMenu={actualizar:{crear:true,separador:false}};
	}
	if(sw_vista=='editar_cbte'){
		var paramMenu={ editar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	}
	//Obtiene los Atributos en array de componentes
	//alert('Atributos:'+Atributos.length)
	
	function getSubsistema(id_subsistema)
	{	if(id_subsistema==1){return 'ENDESIS';}
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
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Eliminando...</div>",
			width:150,
			height:200,
			closable:false
		});
		Ext.Ajax.request({
			url:direccion+'../../../control/comprobante/ActionGestionarEliminarRegistroComprobante.php',
			params: postData,
			method:'POST',
			success: eliminarSucess,
			failure: function (resp ){Ext.MessageBox.hide();
			ContenedorPrincipal.conexionFailure(resp);
			//alert("Error al eliminar el comprobante id:"+getSelectionModel().getSelected().data.id_comprobante);
			},
			timeout:  100//TIEMPO DE ESPERA PARA DAR FALLO
		});
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
		}

	}

	function  eliminarSucess(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement){
			var root = resp.responseXML.documentElement;//recuperamos el resultado en formato XML
			var tc = root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
			Ext.mensajes.msg('Eliminacion Exitosa', 'Se tienen "{0}" registros.', tc);
			var total_registros=new Number(tc);
			var total_paginas=Math.ceil(total_registros / paramConfig.TamanoPagina);
			ds.rejectChanges();
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
			_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
			ClaseMadre_btnActualizar();
		}else{
			//conexionFailure(resp)
			ContenedorPrincipal.conexionFailure(resp);
		}
	}
	
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
			}else{
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
		}
	}
	
	this.btnNew=function(){
		resetComponentes();
		datas_edit='';
		comp_id_parametro.store.baseParams={m_estado:2,m_vigente:'si'};
		comp_id_parametro.modificado=true;
		activar();
		desactivar_nuevo();
		g_comprobante='';
		CM_ocultarComponente(comp_id_subsistema);
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
		
		CM_btnNew();
	};

	this.btnEdit=function(){
		if(getSelectionModel().getCount()>0){
			resetComponentes();
			activar();
			datas_edit=getSelectionModel().getSelected().data;
			
			if (datas_edit.id_subsistema!=g_id_subsistem_contabilidad &&  datas_edit.nro_cbte=='' ){
				desactivar_campos_cbte_generados();
			}
			if (datas_edit.nro_cbte!='' ){
				desactivar_campos_cbte_validados_modificacion();
			}

			comp_fecha_cbte.minValue=datas_edit.fecha_inicio;
			comp_fecha_cbte.maxValue=datas_edit.fecha_final;
			comp_id_periodo_subsis.store.baseParams={m_sw_reg_comp:'si',m_id_gestion:datas_edit.id_gestion,m_id_subsistema:g_id_subsistem_contabilidad,m_estado_periodo:'abierto'};
			comp_id_moneda_cbte.setValue(datas_edit.id_moneda_cbte);
			comp_id_periodo_subsis.modificado=true;
			
			comp_fk_comprobante.store.baseParams={sw_reg_comp:'si',m_id_depto:datas_edit.id_depto};
			
			comp_fk_comprobante.modificado=true;
			comp_momento_cbte.store.load();
			
			CM_ocultarComponente(comp_id_subsistema);
			
			_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
			
			CM_btnEdit();
		} else{
			Ext.MessageBox.alert('Estado','Seleccione un Item primero.');
		}
	};

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/comprobante/ActionGestionarEliminarRegistroComprobante.php'},
		Save:{url:direccion+'../../../control/comprobante/ActionGestionarRegistroComprobante.php',
			params:{id_subsistema:g_id_subsistem_contabilidad}
		},
		ConfirmSave:{url:direccion+'../../../control/comprobante/ActionGuardarRegistroComprobante.php'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:400,width:480,minWidth:150,minHeight:200,columnas:['95%'],
			grupos:[
			{tituloGrupo:'Oculto:',columna:0,id_grupo:0},
			{tituloGrupo:'Periodo:',columna:0,id_grupo:1},
			{tituloGrupo:'Comprobante:',columna:0,id_grupo:2},
			{tituloGrupo:'Respaldo:',columna:0,id_grupo:3},
			{tituloGrupo:'Glosa:',columna:0,id_grupo:4},
			{tituloGrupo:'Usuario Autorizado:',columna:0,id_grupo:5},
			{tituloGrupo:'Relacionar:',columna:0,id_grupo:6},
			{tituloGrupo:'Moneda:',columna:0,id_grupo:6}
			],
			closable:true,
			titulo:'Registro Comprobante'}
	};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos

	function InitRegistroComprobante(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();

		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		//recuperar los componentes
		comp_id_parametro=ClaseMadre_getComponente('id_parametro');
		comp_id_periodo_subsis=ClaseMadre_getComponente('id_periodo_subsis');
		comp_fecha_cbte=ClaseMadre_getComponente('fecha_cbte');
		comp_id_moneda_cbte=ClaseMadre_getComponente('id_moneda_cbte');
		comp_id_tipo_cambio=ClaseMadre_getComponente('id_tipo_cambio');
		comp_tipo_cambio=ClaseMadre_getComponente('tipo_cambio');
		comp_nro_cbte=ClaseMadre_getComponente('nro_cbte');

		comp_id_cbte_clase=ClaseMadre_getComponente('id_cbte_clase');
		comp_momento_cbte=ClaseMadre_getComponente('momento_cbte');
		comp_id_depto=ClaseMadre_getComponente('id_depto');
		comp_id_subsistema=ClaseMadre_getComponente('id_subsistema');

		comp_acreedor=ClaseMadre_getComponente('acreedor');
		comp_aprobacion=ClaseMadre_getComponente('aprobacion');
		comp_conformidad=ClaseMadre_getComponente('conformidad');
		comp_pedido=ClaseMadre_getComponente('pedido');
		comp_concepto_cbte=ClaseMadre_getComponente('concepto_cbte');
		comp_glosa_cbte=ClaseMadre_getComponente('glosa_cbte');

		comp_id_usuario_mod=ClaseMadre_getComponente('id_usuario_mod');
		comp_justificacion_edicion=ClaseMadre_getComponente('justificacion_edicion');
		
		comp_fk_comprobante=ClaseMadre_getComponente('fk_comprobante');
		comp_tipo_relacion=ClaseMadre_getComponente('tipo_relacion');

		comp_id_moneda_sola=ClaseMadre_getComponente('id_moneda_sola');
		
		comp_id_parametro.on('select',f_filtrar_periodo);
		comp_id_periodo_subsis.on('select',f_filtrar_fecha);
		comp_fecha_cbte.on('blur',f_filtrar_moneda);
		comp_id_moneda_cbte.on('select',f_filtrar_tipo_cambio);
		comp_id_tipo_cambio.on('select',f_filtrar_tipo_cambio_valor);
		comp_id_cbte_clase.on('select',f_filtrar_momento);
		
		comp_id_depto.on('select',f_filtrar_ajuste_pagado);
		
		getSelectionModel().on('rowselect',	function( SM,rowIndex){
			datas_edit=SM.getSelected().data;
			var_rowIndex=rowIndex;})

	};
	this.btnActualizar= function (){
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
		ClaseMadre_btnActualizar();
	}
	// funciones de desactivar
	function desactivar_campos_cbte_validados_modificacion(){
		comp_id_parametro.setDisabled(true);
		comp_id_periodo_subsis.setDisabled(true);
		
		comp_fecha_cbte.setDisabled(false);
		comp_nro_cbte.setDisabled(false);
		CM_mostrarComponente(comp_nro_cbte);
		
		comp_id_moneda_cbte.setDisabled(true);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);

		comp_id_cbte_clase.setDisabled(true);
		comp_momento_cbte.setDisabled(true);
		comp_id_depto.setDisabled(false);
		comp_id_subsistema.setDisabled(true);
		comp_fk_comprobante.setDisabled(true);
		comp_tipo_relacion.setDisabled(true);
	}
	
	function desactivar_campos_cbte_generados(){
		comp_id_cbte_clase.setDisabled(true);
		comp_momento_cbte.setDisabled(true);
		comp_id_depto.setDisabled(true);
		comp_id_moneda_cbte.setDisabled(true);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);
		comp_fk_comprobante.setDisabled(true);
		comp_tipo_relacion.setDisabled(true);
	}
	
	function desactivar_nuevo(){
		comp_id_periodo_subsis.setDisabled(true);
		comp_fecha_cbte.setDisabled(true);
		comp_id_moneda_cbte.setDisabled(true);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);
		comp_momento_cbte.setDisabled(true);
	}
	//funciones de activar datos
	function desactivar_reiniciar_periodo_sci(){
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setDisabled(true);
		comp_id_moneda_cbte.setDisabled(true);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);

		comp_id_periodo_subsis.setValue('');
		comp_fecha_cbte.setValue('');
		comp_id_moneda_cbte.setValue('');
		comp_id_tipo_cambio.setValue('');
		comp_tipo_cambio.setValue('');
	}
	
	function desactivar_reiniciar_fecha_sci(){
		comp_fecha_cbte.setDisabled(false);
		comp_id_moneda_cbte.setDisabled(true);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);

		comp_fecha_cbte.setValue('');
		comp_id_moneda_cbte.setValue('');
		comp_id_tipo_cambio.setValue('');
		comp_tipo_cambio.setValue('');
	}
	
	function desactivar_reiniciar_moneda_sci(){
		comp_id_moneda_cbte.setDisabled(false);
		comp_id_tipo_cambio.setDisabled(true);
		comp_tipo_cambio.setDisabled(true);

		comp_id_moneda_cbte.setValue('');
		comp_id_tipo_cambio.setValue('');
		comp_tipo_cambio.setValue('');
	}
	
	function desactivar_reiniciar_moneda_otros(prioridad){
		if(prioridad!=1){
			comp_id_tipo_cambio.setDisabled(false);
			comp_tipo_cambio.setDisabled(true);

			comp_id_tipo_cambio.setValue('');
			comp_tipo_cambio.setValue('');
		}
		if(prioridad==1){
			comp_id_tipo_cambio.setDisabled(true);
			comp_tipo_cambio.setDisabled(true);

			comp_id_tipo_cambio.setValue('');
			comp_tipo_cambio.setValue('');
		}
	}
	
	function desactivar_reiniciar_tipo_cambio_sci(prioridad){
		if(prioridad!=1){
			comp_id_tipo_cambio.setDisabled(false);
			comp_tipo_cambio.setDisabled(true);

			comp_id_tipo_cambio.setValue('');
			comp_tipo_cambio.setValue('');
		}
		if(prioridad==1){
			comp_id_tipo_cambio.setDisabled(true);
			comp_tipo_cambio.setDisabled(true);

			comp_id_tipo_cambio.setValue('');
			comp_tipo_cambio.setValue('');
		}
	}

	function activar(){
		comp_id_parametro.setDisabled(false);
		comp_id_periodo_subsis.setDisabled(false);
		comp_fecha_cbte.setDisabled(false);
		comp_id_moneda_cbte.setDisabled(false);
		comp_id_tipo_cambio.setDisabled(false);
		comp_tipo_cambio.setDisabled(false);
		comp_id_cbte_clase.setDisabled(false);
		comp_momento_cbte.setDisabled(false);
		comp_id_depto.setDisabled(false);
		comp_id_subsistema.setDisabled(false);
		comp_acreedor.setDisabled(false);
		comp_aprobacion.setDisabled(false);
		comp_conformidad.setDisabled(false);
		comp_pedido.setDisabled(false);
		comp_concepto_cbte.setDisabled(false);
		comp_glosa_cbte.setDisabled(false);
		//comp_sw_validacion.setDisabled(false);
	}
	
	function f_filtrar_periodo( combo, record, index ){
		comp_id_periodo_subsis.store.baseParams={m_sw_reg_comp:'si',m_id_gestion: record.data.id_gestion,m_id_subsistema:g_id_subsistem_contabilidad,m_estado_periodo:'abierto'};
		comp_id_periodo_subsis.modificado=true;
		//opcion cuando el comprobnate es de sci
		if(datas_edit=='' ||(datas_edit!='' &&datas_edit.id_subsistema==9)){
			desactivar_reiniciar_periodo_sci();
		}
		//editar comprobantes generados
		if(datas_edit!='' &&datas_edit.id_subsistema!=9){}
	}
	
	function f_filtrar_fecha( combo, record, index ){
		comp_fecha_cbte.minValue= record.data.fecha_inicio;
		comp_fecha_cbte.maxValue=record.data.fecha_final;
		if(datas_edit=='' ||(datas_edit!='' &&datas_edit.id_subsistema==9)){
			desactivar_reiniciar_fecha_sci();
		}
		if(datas_edit!='' &&datas_edit.id_subsistema!=9){
		}
	}
	
	function f_filtrar_moneda(comboData){
		if(datas_edit=='' ||(datas_edit!='' &&datas_edit.id_subsistema==9)){
			desactivar_reiniciar_moneda_sci(); 
		}
		if(datas_edit!='' &&datas_edit.id_subsistema!=9){
			if 	( datas_edit.prioridad_moneda_cbte!=1){
				var fecha =comp_fecha_cbte.getValue()?comp_fecha_cbte.getValue().dateFormat('m/d/Y'):'';
				comp_id_tipo_cambio.store.baseParams={sw_reg_comp:'si',m_id_moneda:datas_edit.id_moneda_cbte,m_fecha:fecha};
				comp_id_tipo_cambio.modificado=true;

				desactivar_reiniciar_moneda_otros(datas_edit.prioridad_moneda_cbte);
			}
		}
	}
	
	function f_filtrar_tipo_cambio(combo, record, index ){
		var fecha =comp_fecha_cbte.getValue()?comp_fecha_cbte.getValue().dateFormat('m/d/Y'):'';
		comp_id_tipo_cambio.store.baseParams={sw_reg_comp:'si',m_id_moneda:record.data.id_moneda,m_fecha:fecha};
		comp_id_tipo_cambio.modificado=true;
		if(datas_edit=='' ||(datas_edit!='' &&datas_edit.id_subsistema==9)){

			desactivar_reiniciar_tipo_cambio_sci(record.data.prioridad);
		}
		if(datas_edit!='' &&datas_edit.id_subsistema!=9){
		}
	}
	
	function f_filtrar_tipo_cambio_valor(combo, record, index ){
		if(record.data.id_tipo_cambio==0){
			comp_tipo_cambio.setDisabled(false);
			comp_tipo_cambio.setValue('');
		}
		if(record.data.id_tipo_cambio!=0){
			comp_tipo_cambio.setDisabled(true);
			comp_tipo_cambio.setValue(record.data.tipo_cambio);
		}
	}
	
	function f_filtrar_ajuste_pagado( combo, record, index ){
		comp_fk_comprobante.setValue('');
		comp_fk_comprobante.store.baseParams={sw_reg_comp:'si',m_id_depto:record.data.id_depto};
		comp_fk_comprobante.modificado=true;
	}
	
	function f_filtrar_momento( combo, record, index ){
		comp_momento_cbte.store.load();
		comp_momento_cbte.setValue(0);
		comp_momento_cbte.setDisabled(false);
		f_mostrar( combo, record, index );
	}
	
	function f_mostrar( combo, record, index ){
		comp_acreedor.setDisabled(false);
		comp_aprobacion.setDisabled(false);
		comp_conformidad.setDisabled(false);
		comp_pedido.setDisabled(false);
		comp_concepto_cbte.setDisabled(false);
		comp_glosa_cbte.setDisabled(false);
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.reload(rec.data,'no');
		edit_cbte= rec.data;
		g_comprobante=rec.data.id_comprobante;
		g_subsistema=rec.data.id_subsistema;
		g_titulo=rec.data.titulo_cbte;
		g_cbte=rec.data.momento_cbte;
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

	//RCM 22/04/2010
	function ocultar_mostrar_grupos(habilitar){
		//FalTA REDEFINIR LOS DATOS OBLIGATORIOS U OPCIONALES
		if(habilitar=='mod' || habilitar=='del'){
			//Redireccionamiento del action para habilitar el comprobante para modificacion
			if(habilitar=='mod'){
				CM_getFormulario().url=direccion+'../../../control/comprobante/ActionHabilitarComprobanteModificacion.php';
			}else{
				CM_getFormulario().url=direccion+'../../../control/comprobante/ActionBorradorComprobante.php';
			}
			//Muesta el grupo para registro del usuario autorizado para modificar el comprobante
			CM_mostrarGrupo('Usuario Autorizado:');
			//Oculta los otros grupos
			CM_ocultarGrupo('Periodo:');
			CM_ocultarGrupo('Comprobante:');
			CM_ocultarGrupo('Respaldo:');
			CM_ocultarGrupo('Glosa:');
			CM_ocultarGrupo('Relacionar:');
			CM_ocultarGrupo('Moneda:');
			//Define como obligatorio el grupo mostrado
			allowBlankGrupo(5,false);
			//Define como opcional los grupos no mostrados
			allowBlankGrupo(1,true);
			allowBlankGrupo(2,true);
			allowBlankGrupo(3,true);
			allowBlankGrupo(4,true);
			allowBlankGrupo(6,true);
			allowBlankGrupo(7,true);
			
			comp_id_usuario_mod.store.baseParams={sw_reg_comp:'si', m_id_depto:edit_cbte.id_depto};
			comp_id_usuario_mod.modificado=true;
		} 
		if(habilitar=='mone'){
			//Redireccionamiento del action para habilitar el comprobante para modificacion
			CM_getFormulario().url=direccion+'../../../control/comprobante/ActionMonedaComprobante.php';
			//Muesta el grupo para registro de moneda para modificar el comprobante
			CM_mostrarGrupo('Moneda:');
			//Oculta los otros grupos
			CM_ocultarGrupo('Periodo:');
			CM_ocultarGrupo('Comprobante:');
			CM_ocultarGrupo('Respaldo:');
			CM_ocultarGrupo('Glosa:');
			CM_ocultarGrupo('Relacionar:');
			CM_ocultarGrupo('Usuario Autorizado:');
			//Define como obligatorio el grupo mostrado
			allowBlankGrupo(7,false);
			//Define como opcional los grupos no mostrados
			allowBlankGrupo(1,true);
			allowBlankGrupo(2,true);
			allowBlankGrupo(3,true);
			allowBlankGrupo(4,true);
			allowBlankGrupo(6,true);
			allowBlankGrupo(5,true);
		} 
		if(habilitar!='mod' && habilitar!='mone' && habilitar!='del'){
			//Redireccionamiento del action para almacenar los datos
			CM_getFormulario().url=direccion+'../../../control/comprobante/ActionGestionarRegistroComprobante.php';
			//Oculta el grupo para registro del usuario autorizado para modificar el comprobante
			CM_ocultarGrupo('Usuario Autorizado:');
			CM_ocultarGrupo('Moneda:');
			//Muesta los otros grupos para registro normal del comprobante
			CM_mostrarGrupo('Periodo:');
			CM_mostrarGrupo('Comprobante:');
			CM_mostrarGrupo('Respaldo:');
			CM_mostrarGrupo('Glosa:');
			CM_mostrarGrupo('Relacionar');
			
			//comp_id_usuario_mod.allowBlank=true;
			allowBlankGrupo(1,false);
			allowBlankGrupo(2,false);
			allowBlankGrupo(3,false);
			allowBlankGrupo(4,false);
			allowBlankGrupo(5,true);
			allowBlankGrupo(6,true);
			allowBlankGrupo(7,true);
			comp_glosa_cbte.allowBlank=true;
		}
	}
	//reinicia los valores del formulario al del atributo
	function resetComponentes(){ //p_grupo es el indice del grupo, p_allowBlank es cadena (true, false)
		for (var i=0;i<Atributos.length;i++){
				if(Atributos[i].form==true){ 
					ClaseMadre_getComponente(Atributos[i].validacion.name).allowBlank=Atributos[i].validacion.allowBlank;
					ClaseMadre_getComponente(Atributos[i].validacion.name).setDisabled(Atributos[i].validacion.disabled);
				}
			}
			CM_ocultarGrupo('Usuario Autorizado:');
			CM_ocultarGrupo('Moneda:');
			CM_ocultarComponente(comp_nro_cbte);
	}
	//Coloca al grupo (p_grupo(1,2...)) que permita vacio o no (p_allowBlank {TRUE, FALSE})
	function allowBlankGrupo(p_grupo,p_allowBlank){ //p_grupo es el ï¿½ndice del grupo, p_allowBlank es cadena (true, false)
		for (var i=0;i<Atributos.length;i++){
			//alert(i+" i llega  "+p_grupo+" atributo s"+Atributos[i].id_grupo);
			if(Atributos[i].id_grupo==p_grupo && Atributos[i].form==true){ 
				ClaseMadre_getComponente(Atributos[i].validacion.name).allowBlank=p_allowBlank;
			}
		}
	}

	function btn_hab_cbte_mod(){
		ocultar_mostrar_grupos('mod');
		CM_btnEdit();
	}

	function btn_moneda_cbte(){
		ocultar_mostrar_grupos('mone');
		CM_btnEdit();
	}
	
	function btn_borrador_mod(){
		ocultar_mostrar_grupos('del');
		CM_btnEdit();
	}
	//FIN RCM
	function btn_reporte_libro_diario(){
		if(g_id_moneda==undefined){
			g_id_moneda=1;
			g_simbolo='Bs'
		}

		var data='start=0';
		data+='&fecha_inicio='+g_fecha_inicio;
		data+='&id_moneda='+g_id_moneda;
		data+='&fecha_fin='+g_fecha_fin;
		data=data+'&m_simbolo='+g_simbolo;
		data=data+'&m_nombre_depto='+g_depto;
		data=data+'&m_id_depto='+g_ids_depto;
		//	 alert (data);
		window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroDiario.php?'+data)
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
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function clase_actualiza(resp){
		ClaseMadre_btnActualizar();
	}

	function mostrar_respuesta(resp){
		Ext.MessageBox.confirm("Validacion",resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue+"\n Imprimir comprobante?\n",
		function(btn){
			ds.baseParams={
					//start:0,
					limit: g_limit,
					CantFiltros:paramConfig.CantFiltros,
					m_ids_depto:g_ids_depto,
					m_fecha_inicio:g_fecha_inicio,
					m_fecha_fin:g_fecha_fin,
					m_sw_vista:sw_vista
				};
			ds.load({params:{//start:0,
							limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
					m_ids_depto:g_ids_depto,
					m_fecha_inicio:g_fecha_inicio,
					m_fecha_fin:g_fecha_fin,
					m_sw_vista:sw_vista
			}});
			
			if(btn=='yes'){
				Ext.MessageBox.hide();
				var data='m_id_comprobante='+g_comprobante;
				data=data+'&m_id_moneda='+g_id_moneda;
				data=data+'&m_simbolo='+g_simbolo;
				data=data+'&m_desc_clases='+g_titulo;
				data=data+'&m_momento_cbte='+g_cbte;

				window.open(direccion+'../../../control/comprobante/reporte/ActionPDFComprobante.php?'+data)
				
				if (g_depen != 0){
					mensaje="El Comprobante: " + g_comprobante + " tiene: - "+g_depen+" - Cbte(s) Paralelo(s)";
					Ext.MessageBox.alert("Validacion ", mensaje);
				}
			}else{
				if (g_depen != 0){
					mensaje="El Comprobante: " + g_comprobante + " tiene: - "+g_depen+" - Cbte(s) Paralelo(s)";
					Ext.MessageBox.alert("Validacion ", mensaje);
				}
			}
		});
		_CP.getPagina(layout_registro_comprobante.getIdContentHijo()).pagina.limpiarStore();
	}

	function btn_validar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			g_depen=datas_edit.cbtes_depen;

			Ext.MessageBox.confirm("Atencion","Esta seguro de Validar Comprobante?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Validando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Validando comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'validacion',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});

			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}

	function btn_validar_igualar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			g_depen=datas_edit.cbtes_depen;
			
			datas_edit=sm.getSelected().data;
			
			Ext.MessageBox.confirm("Atencion ","Esta seguro de Validar e Igualar Comprobante?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Validando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Validando e Igualando  comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'validacion_igualar',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_fin_edicion(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			g_depen=datas_edit.cbtes_depen;
	
			Ext.MessageBox.confirm("Atencion","Esta seguro cambiar a estado validado?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Cambiando de estado al  comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cambiando a estado Validado...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'fin_edicion',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});

			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_fin_edicion_igualar(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			g_depen=datas_edit.cbtes_depen;
	
			Ext.MessageBox.confirm("Atencion","Esta seguro cambiar a estado validado e igualar ?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Cambiando de estado e igualando el  comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cambiando a estado Validado...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'fin_edicion_igulando',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_revertir(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			Ext.MessageBox.confirm("Atencion","Esta seguro de revertir comprobnate?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Validando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>  Revirtiendo  comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'revertir',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}

	function btn_duplicar(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
		
			Ext.MessageBox.confirm("Atencion","Esta seguro de Duplicar Comprobante?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Validando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Duplicando Comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'duplicar',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_cambiar_clase(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			
				Ext.MessageBox.confirm("Atencion","Esta seguro de Cambiar el Comprobante de Pago/Caja a Diario ?",function(btn){if(btn=='yes'){
					Ext.Ajax.request({
						url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
						success:clase_actualiza,
						params:{accion:'cambiar_clase',id_comprobante:datas_edit.id_comprobante},
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
				} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_cambio_estado(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
			
			Ext.MessageBox.confirm("Atencion","Esta seguro de Cambiar de Estado?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Editando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cambiando Estado Comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionBorradorComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'cambio_estado',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}
	
	function btn_fecha(){
		var sm=getSelectionModel();
		//var filas=ds.getModifiedRecords();
		//var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			datas_edit=sm.getSelected().data;
			g_comprobante=datas_edit.id_comprobante;
			g_id_moneda=g_id_moneda;
			g_simbolo=g_simbolo;
			g_titulo=datas_edit.titulo_cbte;
			g_cbte=datas_edit.momento_cbte;
	
			Ext.MessageBox.confirm("Atencion","Esta seguro de Actualizar fecha comprobantes no validados?",function(btn){if(btn=='yes'){
				Ext.MessageBox.show({
					title: 'Validando comprobante...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Actualizando fechas comprobante...</div>",
					width:150,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/comprobante/ActionGestionarAccionesComprobante.php",
					success:mostrar_respuesta,
					params:{accion:'actualizar_fecha',id_comprobante:datas_edit.id_comprobante},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});
			} });
			sm.clearSelections();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Comprobante.');
		}
	}

	function btn_log_cbte(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_comprobante='+SelectionsRecord.data.id_comprobante;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_registro_comprobante.loadWindows(direccion+'../../../../sis_contabilidad/vista/registro_comprobante2/comprobante_log.php?'+data,'Log de modificaciones',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro');
		}
	}
	
	var fecha_inicio=	new Ext.form.DateField({
		name:'inicio',
		fieldLabel:'Inicio',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Dia no valido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});
	
	var fecha_fin=	new Ext.form.DateField({
		name:'fin',
		fieldLabel:'Fin',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Dia no valido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_registro_comprobante.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	//	iniciarEventosFormularios();deldocs
	InitRegistroComprobante();

	fecha_inicio.on('change',function (){g_fecha_inicio=fecha_inicio.getValue()?fecha_inicio.getValue().dateFormat('m/d/Y'):'';	menuBotones()});
	fecha_fin.on('change',function (){g_fecha_fin=fecha_fin.getValue()?fecha_fin.getValue().dateFormat('m/d/Y'):'';	menuBotones()});

	if(sw_vista=='libro_diario'){
		this.AdicionarBoton('../../../lib/imagenes/cross.gif','Ajustar Comprobante',btn_revertir,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/copy.png','Duplicar Comprobante',btn_duplicar,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/moneda.png','Grabar el Cbte. en UNA Moneda',btn_moneda_cbte,true,'mone_cbte','');
		this.AdicionarBoton('../../../lib/imagenes/book_previous.png','Habilitar para Modificación',btn_hab_cbte_mod,true,'modificar_cbte','');
		this.AdicionarBoton('../../../lib/imagenes/draft_33.png','Cambiar Comprobante a Borrador',btn_borrador_mod,true,'borrador_cbte','');
		this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Documentos de Respaldo ',btn_documento_respaldo,true,'documento_respaldo','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
		this.AdicionarBoton('../../../lib/imagenes/book.gif','Libro Diario',btn_reporte_libro_diario,true,'reporte_libro_diario','');
		this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Log de Edición',btn_log_cbte,true,'log_cbte','');
		this.AdicionarBotonCombo(fecha_inicio,'Inicio');
		this.AdicionarBotonCombo(fecha_fin,'Fin');
	}
	if(sw_vista=='gestionar_cbte'){
		this.AdicionarBoton('../../../lib/imagenes/tab_edit.png','Cambiar Comprobante de Pago/Caja a Diario',btn_cambiar_clase,true,'cambiar_comprobante','');
		this.AdicionarBoton('../../../lib/imagenes/terminar.png','Validar Comprobante',btn_validar,true,'validar_comprobante','');
		this.AdicionarBoton('../../../lib/imagenes/terminar_iguala.png','Validar e Igualar Comprobante',btn_validar_igualar,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Documentos de Respaldo ',btn_documento_respaldo,true,'documento_respaldo','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
		this.AdicionarBoton('../../../lib/imagenes/cross.gif','Ajustar Comprobante',btn_revertir,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/copy.png','Duplicar Comprobante',btn_duplicar,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/act.png','Actualizar Fechas',btn_fecha,true,'__');
		this.AdicionarBotonCombo(fecha_inicio,'Inicio');
		this.AdicionarBotonCombo(fecha_fin,'Fin');
	}
	//RCM
	if(sw_vista=='editar_cbte'){
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Edición',btn_fin_edicion,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/book_next_iguala.png','Finalizar Edición e Igualar',btn_fin_edicion_igualar,true,'__');
		this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Documentos de Respaldo ',btn_documento_respaldo,true,'documento_respaldo','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Comprobante',btn_reporte_comprobante,true,'reporte_comprobante','');
		this.AdicionarBotonCombo(fecha_inicio,'Inicio');
		this.AdicionarBotonCombo(fecha_fin,'Fin');
	}
	//FIN RCM
	
	CM_AdicionarMenuBoton=this.AdicionarMenuBoton;
	CM_getBotonMenuBotonNombre=this.getBotonMenuBotonNombre;
	CM_getMenuBoton=this.getMenuBoton;

	function menuBotones(){
		g_limit= paramConfig.TamanoPagina;
		g_CantFiltros=paramConfig.CantFiltros;
		g_ids_depto=CM_getMenuBoton('Depto-'+idContenedor).menuBoton.getSelecion();
		g_depto=CM_getMenuBoton('Depto-'+idContenedor).menuBoton.getSeleccionadosDesc();
		
		ds.baseParams={
			//start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			m_ids_depto:g_ids_depto,
			m_fecha_inicio:g_fecha_inicio,
			m_fecha_fin:g_fecha_fin,
			m_sw_vista:sw_vista
		};
	}

	ds_depto_menu.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
		},
		callback: function(){CM_AdicionarMenuBoton(ds_depto_menu,config_depto);},
		scope:this
	} );

	CM_ocultarGrupo('Oculto:');

	layout_registro_comprobante.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	//carga datos XML
	ds.load({params:{start:0,
					limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
}
