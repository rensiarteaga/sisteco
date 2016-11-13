function PaginaItemCuentaPartida(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_item_cuenta_partida;
	var elementos=new Array();
	var sw=0;
	var combo_supergrupo,combo_grupo,combo_subgrupo,combo_id1;
	var combo_id2,combo_id3,combo_nivel,txt_descripcion,combo_gestion,combo_cuenta,combo_partida;
	var combo_cuenta_gasto,combo_auxiliar_activo,combo_auxiliar_gasto;
	var g_gestion, data='';
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/item_cuenta_partida/ActionListarItemCuentaPartida.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item_cuenta_partida',totalRecords:'TotalCount'},
		['id_item_cuenta_partida',
		'nivel',
		'id_gral',
		'id_supergrupo',
		'nombre_supergrupo',
		'id_grupo',
		'nombre_grupo',
		'id_subgrupo',
		'nombre_subgrupo',
		'id_id1',
		'nombre_id1',
		'id_id2',
		'nombre_id2',
		'id_id3',
		'nombre_id3',
		'desc_item_cuenta_partida',
		'id_cuenta',
		'nombre_cuenta',
		'id_partida',
		'nombre_partida',
		'id_gestion',
		'gestion',
		'id_cuenta_gasto',
		'desc_cuenta_gasto',
		'id_presupuesto',
		'desc_presupuesto',
		'id_auxiliar_activo',
		'desc_auxiliar_activo',
		'id_auxiliar_gasto',
		'desc_auxiliar_gasto','detalle_usado'
		]),
		remoteSort:true
	});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	/////DATA STORE COMBOS////////////
	var ds_gestion=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?estado=abierto'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});
	var ds_supergrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre','codigo'])
	});
	var ds_grupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre','codigo'])
	});
	var ds_subgrupo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre','codigo'])
	});
	var ds_id1=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id1/ActionListarId1.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id1',totalRecords:'TotalCount'},['id_id1','nombre','codigo'])
	});
	var ds_id2=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id2/ActionListarId2.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre','codigo'])
	});
	var ds_id3=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id3/ActionListarId3.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre','codigo'])
	});
	var ds_cuenta_auxiliar=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_auxiliar',totalRecords:'TotalCount'},['id_cuenta_auxiliar','id_auxiliar','nombre_auxiliar','codigo_auxiliar'])
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','desc_presupuesto','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti',
																																										'id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro',
																																										'desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador',
																																										'nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional',
																																										'codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla',
																																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																										'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
	});	
	////////////////FUNCIONES RENDER ////////////
	function renderId3(value,p,record){return String.format('{0}',record.data['nombre_id3'])}
	function renderId2(value,p,record){return String.format('{0}',record.data['nombre_id2'])}
	function renderId1(value,p,record){return String.format('{0}',record.data['nombre_id1'])}
	function renderSubgrupo(value,p,record){return String.format('{0}',record.data['nombre_subg'])}
	function renderGrupo(value,p,record){return String.format('{0}',record.data['nombre_grupo'])}
	function renderSupergrupo(value,p,record){return String.format('{0}',record.data['nombre_supg'])}
	function renderPartida(value,p,record){return String.format('{0}',record.data['nombre_partida'])}
	function renderCuenta(value,p,record){return String.format('{0}',record.data['nombre_cuenta'])}
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function renderCuentaGasto(value,p,record){return String.format('{0}',record.data['desc_cuenta_gasto'])}
	function renderUnidadOrganizacional(value,p,record){return String.format('{0}',record.data['desc_unidad'])}
	function render_AuxiliarActivo(value, p, record){return String.format('{0}', record.data['desc_auxiliar_activo']);}
	function render_AuxiliarGasto(value, p, record){return String.format('{0}', record.data['desc_auxiliar_gasto']);}
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	
	
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
																		'<br><b>Gestion: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>',
																		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
																		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
																		'</div>');	

	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var resultTplSupGru=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplSubGrupo=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplId1=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplId2=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplId3=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo}</FONT>','</div>');
	var resultTplCuentaAuxiliar=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo: </b>{codigo_auxiliar}</FONT>','</div>');
	var tpl_UnidadOrganizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','</div>');
	
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_item_cuenta_partida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_item_cuenta_partida'
	};
	// txt id_gestion
	vectorAtributos[1]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc:'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField:'id_gestion',
			displayField:'gestion',
			queryParam:'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'65%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'65%',
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'GESTION.gestion',
		save_as:'txt_id_gestion'
	};
	vectorAtributos[2]={
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Super Grupo'],['2','Grupo'],['3','Sub Grupo'],['4','Identificador 1'],['5','Identificador 2'],['6','Identificador 3']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			renderer:formatNivel,
			grid_visible:true,
			grid_editable:false,
			width_grid:100			
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ICUPAR.nivel',
		save_as:'txt_nivel'
	};
	vectorAtributos[3]={
		validacion:{
			name:'desc_item_cuenta_partida',
			fieldLabel:'Descripcion',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
			},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'SUPGRU.nombre#GRUPO.nombre#SUBGRU.nombre#ID1.nombre#ID2.nombre#ID3.nombre',
		save_as:'txt_desc_item_cuenta_partida'
	};
	vectorAtributos[4]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'txt_id_presupuesto'
	};
	vectorAtributos[5]={
		validacion:{
			name:'id_partida',
			desc:'nombre_partida',
			fieldLabel:'Partida',
			tipo:'gasto',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderPartida,
			width_grid:310,
			width:300,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovPartida',
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida#PARTID.codigo_partida',
		save_as:'txt_id_partida'
	};
	var filterCols_cuenta_activo=new Array();
	var filterValues_cuenta_activo=new Array();
	filterCols_cuenta_activo[0]='PARCUE.id_partida';
	filterValues_cuenta_activo[0]='%';
	vectorAtributos[6]={
		validacion:{
			name:'id_cuenta',
			desc:'nombre_cuenta',
			fieldLabel:'Cuenta de Activo',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			filterCols:filterCols_cuenta_activo,
			filterValues:filterValues_cuenta_activo,
			renderer:renderCuenta,
			width_grid:300,
			width:300,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovCuenta',
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta#CUENTA.nro_cuenta',
		save_as:'txt_id_cuenta'
	};
	var filterCols_auxiliar_activo=new Array();
	var filterValues_auxiliar_activo=new Array();
	filterCols_auxiliar_activo[0]='CUEAUX.id_cuenta';
	filterValues_auxiliar_activo[0]='%';
	vectorAtributos[7]={
		validacion:{
			fieldLabel:'Auxiliar de Activo',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Auxiliar de Activo...',
			name:'id_auxiliar_activo',
			desc:'desc_auxiliar_activo',
			store:ds_cuenta_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			filterCol:'AUXILI.nombre_auxiliar#AUXILI.codigo_auxiliar',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplCuentaAuxiliar,
			mode:'remote',
			filterCols:filterCols_auxiliar_activo,
			filterValues:filterValues_auxiliar_activo,
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:render_AuxiliarActivo,
			grid_visible:true,
			grid_editable:false,
			width:300
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AUXACT.nombre_auxiliar#AUXACT.codigo_auxiliar',
		save_as:'txt_id_auxiliar_activo'
	};
	var filterCols_cuenta_gasto=new Array();
	var filterValues_cuenta_gasto=new Array();
	filterCols_cuenta_gasto[0]='PARCUE.id_partida';
	filterValues_cuenta_gasto[0]='%';
	vectorAtributos[8]={
		validacion:{
			name:'id_cuenta_gasto',
			desc:'desc_cuenta_gasto',
			fieldLabel:'Cuenta de Gasto',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			filterCols:filterCols_cuenta_gasto,
			filterValues:filterValues_cuenta_gasto,
			renderer:renderCuentaGasto,
			width_grid:300,
			width:300,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovCuenta',
		filtro_0:true,
		filterColValue:'CUENGA.nombre_cuenta#CUENGA.nro_cuenta',
		save_as:'txt_id_cuenta_gasto'
	};
	var filterCols_auxiliar_gasto=new Array();
	var filterValues_auxiliar_gasto=new Array();
	filterCols_auxiliar_gasto[0]='CUEAUX.id_cuenta';
	filterValues_auxiliar_gasto[0]='%';
	vectorAtributos[9]={
		validacion:{
			fieldLabel:'Auxiliar de Gasto',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Auxiliar de Gasto...',
			name:'id_auxiliar_gasto',
			desc:'desc_auxiliar_gasto',
			store:ds_cuenta_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			filterCol:'AUXILI.nombre_auxiliar#AUXILI.codigo_auxiliar',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplCuentaAuxiliar,
			mode:'remote',
			filterCols:filterCols_auxiliar_gasto,
			filterValues:filterValues_auxiliar_gasto,
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:render_AuxiliarGasto,
			grid_visible:true,
			grid_editable:false,
			width:300
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AUXGAS.nombre_auxiliar#AUXGAS.codigo_auxiliar',
		save_as:'txt_id_auxiliar_gasto'
	};
	var filterCols_super_grupo=new Array();
	var filterValues_super_grupo=new Array();
	filterCols_super_grupo[0]='estado_registro';
	filterValues_super_grupo[0]='activo';
	vectorAtributos[10]={
		validacion:{
			fieldLabel:'Super Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Super Grupo...',
			name:'id_supergrupo',
			sortCol:'supgru.nombre',
			desc:'nombre_supg',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			filterCol:'supgru.nombre#supgru.codigo',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSupGru,
			mode:'remote',
			filterCols:filterCols_super_grupo,
			filterValues:filterValues_super_grupo,
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderSupergrupo,
			grid_visible:false,
			grid_editable:false,
			width:250
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'supgru.nombre#supgru.codigo',
		save_as:'txt_id_supergrupo'
	};
	var filterCols_grupo=new Array();
	var filterValues_grupo=new Array();
	filterCols_grupo[0]='supgru.id_supergrupo';
	filterValues_grupo[0]='%';
	filterCols_grupo[1]='g.estado_registro';
	filterValues_grupo[1]='activo';
	vectorAtributos[11]={
		validacion:{
			fieldLabel:'Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Grupo...',
			name:'id_grupo',
			desc:'nombre_grupo',
			store:ds_grupo,
			valueField:'id_grupo',
			displayField:'nombre',
			filterCol:'g.nombre#g.codigo',
			filterCols:filterCols_grupo,
			filterValues:filterValues_grupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderGrupo,
			grid_visible:false,
			grid_editable:false,
			width:250
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'g.nombre#g.codigo',
		save_as:'txt_id_grupo'
	};
	var filterCols_subgrupo=new Array();
	var filterValues_subgrupo=new Array();
	filterCols_subgrupo[0]='supgru.id_supergrupo';
	filterValues_subgrupo[0]='%';
	filterCols_subgrupo[1]='g.id_grupo';
	filterValues_subgrupo[1]='%';
	filterCols_subgrupo[2]='sub.estado_registro';
	filterValues_subgrupo[2]='activo';
	vectorAtributos[12]={
		validacion:{
			fieldLabel:'Sub Grupo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Sub Grupo...',
			name:'id_subgrupo',
			desc:'nombre_subg',
			store:ds_subgrupo,
			valueField:'id_subgrupo',
			displayField:'nombre',
			filterCol:'sub.nombre#sub.codigo',
			filterCols:filterCols_subgrupo,
			filterValues:filterValues_subgrupo,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplSubGrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderSubgrupo,
			grid_visible:false,
			grid_editable:false,
			width:250
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'sub.nombre#sub.codigo',
		save_as:'txt_id_subgrupo'
	};
	var filterCols_id1=new Array();
	var filterValues_id1=new Array();
	filterCols_id1[0]='supgru.id_supergrupo';
	filterValues_id1[0]='%';
	filterCols_id1[1]='g.id_grupo';
	filterValues_id1[1]='%';
	filterCols_id1[2]='sub.id_subgrupo';
	filterValues_id1[2]='%';
	filterCols_id1[3]='id1.estado_registro';
	filterValues_id1[3]='activo';
	vectorAtributos[13]={
		validacion:{
			fieldLabel:'Identificador 1',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 1...',
			name:'id_id1',
			desc:'nombre_id1',
			store:ds_id1,
			valueField:'id_id1',
			displayField:'nombre',
			filterCol:'id1.nombre#id1.codigo',
			filterCols:filterCols_id1,
			filterValues:filterValues_id1,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId1,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderId1,
			grid_visible:false,
			grid_editable:false,
			width:250
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'id1.nombre#id1.codigo',
		save_as:'txt_id_id1'
	};
	var filterCols_id2=new Array();
	var filterValues_id2=new Array();
	filterCols_id2[0]='supgru.id_supergrupo';
	filterValues_id2[0]='%';
	filterCols_id2[1]='g.id_grupo';
	filterValues_id2[1]='%';
	filterCols_id2[2]='sub.id_subgrupo';
	filterValues_id2[2]='%';
	filterCols_id2[3]='id1.id_id1';
	filterValues_id2[3]='%';
	filterCols_id2[4]='id2.estado_registro';
	filterValues_id2[4]='activo';
	vectorAtributos[14]={
		validacion:{
			fieldLabel:'Identificador 2',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 2...',
			name:'id_id2',
			desc:'nombre_id2',
			store:ds_id2,
			valueField:'id_id2',
			displayField:'nombre',
			filterCol:'id2.nombre#id2.codigo',
			filterCols:filterCols_id2,
			filterValues:filterValues_id2,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId2,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderId2,
			grid_visible:false,
			grid_editable:false,
			width:250
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'id2.nombre#id2.codigo',
		save_as:'txt_id_id2'
	};
	var filterCols_id3=new Array();
	var filterValues_id3=new Array();
	filterCols_id3[0]='supgru.id_supergrupo';
	filterValues_id3[0]='%';
	filterCols_id3[1]='g.id_grupo';
	filterValues_id3[1]='%';
	filterCols_id3[2]='sub.id_subgrupo';
	filterValues_id3[2]='%';
	filterCols_id3[3]='id1.id_id1';
	filterValues_id3[3]='%';
	filterCols_id3[4]='id2.id_id2';
	filterValues_id3[4]='%';
	filterCols_id3[5]='id3.estado_registro';
	filterValues_id3[5]='activo';
	vectorAtributos[15]={
		validacion:{
			fieldLabel:'Identificador 3',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Identificador 3...',
			name:'id_id3',
			desc:'nombre_id3',
			store:ds_id3,
			valueField:'id_id3',
			displayField:'nombre',
			filterCol:'id3.nombre#id3.codigo',
			filterCols:filterCols_id3,
			filterValues:filterValues_id3,
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplId3,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:250,
			resizable:true,
			queryParam:'filterValue_0',
			grow:false,
			minChars:3,
			triggerAction:'all',
			editable:true,
			renderer:renderId3,
			grid_visible:false,
			grid_editable:false,
			width:250
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'id3.nombre#id3.codigo',
		save_as:'txt_id_id3'
	};	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	function formatNivel(value){
		if(value==1) value='Super Grupo';
		if(value==2) value='Grupo';
		if(value==3) value='Sub Grupo';
		if(value==4) value='Identificador 1';
		if(value==5) value='Identificador 2';
		if(value==6) value='Identificador 3';
	return value	
		
	}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config={titulo_maestro:"Items",grid_maestro:"grid-"+idContenedor};
	layout_item_cuenta_partida=new DocsLayoutMaestro(idContenedor);
	layout_item_cuenta_partida.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_item_cuenta_partida,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_btnEliminar=this.btnEliminar;
	var Cm_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	// -----------   DEFINICI�N DE LA BARRA DE MEN� ----------- //
	var paramMenu={nuevo:{crear:true,separador:true},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+"../../../control/item_cuenta_partida/ActionEliminarItemCuentaPartida.php"},
		Save:{url:direccion+"../../../control/item_cuenta_partida/ActionGuardarItemCuentaPartida.php"},
		ConfirmSave:{url:direccion+"../../../control/item_cuenta_partida/ActionGuardarItemCuentaPartida.php"},
		Formulario:{html_apply:"dlgInfo"+idContenedor,width:500,height:450,minWidth:150,minHeight:200,labelWidth:75,closable:true,titulo:'Relacionador Item - Cuenta - Partida'}
	};
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_supergrupo=ClaseMadre_getComponente('id_supergrupo');
		combo_grupo=ClaseMadre_getComponente('id_grupo');
		combo_subgrupo=ClaseMadre_getComponente('id_subgrupo');
		combo_id1=ClaseMadre_getComponente('id_id1');
		combo_id2=ClaseMadre_getComponente('id_id2');
		combo_id3=ClaseMadre_getComponente('id_id3');
		combo_nivel=ClaseMadre_getComponente('nivel');
		txt_descripcion=ClaseMadre_getComponente('desc_item_cuenta_partida');
		combo_gestion=ClaseMadre_getComponente('id_gestion');			
        combo_cuenta=ClaseMadre_getComponente('id_cuenta');	
        combo_cuenta_gasto=ClaseMadre_getComponente('id_cuenta_gasto');
        combo_auxiliar_activo=ClaseMadre_getComponente('id_auxiliar_activo');
        combo_auxiliar_gasto=ClaseMadre_getComponente('id_auxiliar_gasto');
        combo_partida=ClaseMadre_getComponente('id_partida');	
		var onSuperGrupoSelect=function(e){
			var id=combo_supergrupo.getValue();
			combo_grupo.filterValues[0]=id;
			combo_grupo.modificado=true;
			combo_subgrupo.filterValues[0]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[0]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[0]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[0]=id;
			combo_id3.modificado=true;
			combo_grupo.enable();
			combo_subgrupo.enable();
			combo_id1.enable();
			combo_id2.enable();
			combo_id3.enable();
			combo_grupo.setValue('');
			combo_subgrupo.setValue('');
			combo_id1.setValue('');
			combo_id2.setValue('');
			combo_id3.setValue('')
		};
		var onGrupoSelect=function(e){
			var id=combo_grupo.getValue();
			combo_subgrupo.filterValues[1]=id;
			combo_subgrupo.modificado=true;
			combo_id1.filterValues[1]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[1]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[1]=id;
			combo_id3.modificado=true;
			combo_subgrupo.setValue('');
			combo_id1.setValue('');
			combo_id2.setValue('');
			combo_id3.setValue('')
		};
		var onSubGrupoSelect=function(e){
			var id = combo_subgrupo.getValue();
			combo_id1.filterValues[2]=id;
			combo_id1.modificado=true;
			combo_id2.filterValues[2]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[2]=id;
			combo_id3.modificado=true;
			combo_id1.setValue('');
			combo_id2.setValue('');
			combo_id3.setValue('')
		};
		var onId1Select=function(e){
			var id=combo_id1.getValue();
			combo_id2.filterValues[3]=id;
			combo_id2.modificado=true;
			combo_id3.filterValues[3]=id;
			combo_id3.modificado=true;
			combo_id2.setValue('');
			combo_id3.setValue('')
		};
		var onId2Select=function(e){
			var id=combo_id2.getValue();
			combo_id3.filterValues[4]=id;
			combo_id3.modificado=true;
			combo_id3.setValue('');
		};
		var OnNivelSelect=function(e){
			var id=combo_nivel.getValue();
			if(id==1){
				combo_supergrupo.enable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_ocultarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=true;
				CM_ocultarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=true;
				CM_ocultarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=true;
				CM_ocultarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=true;
				CM_ocultarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=true
			}
			if(id==2){
				combo_supergrupo.enable();
				combo_grupo.disable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_mostrarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=false;
				CM_ocultarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=true;
				CM_ocultarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=true;
				CM_ocultarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=true;
				CM_ocultarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=true
		    }
		    if(id==3){
				combo_supergrupo.enable();
				combo_grupo.disable();
				combo_subgrupo.disable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_mostrarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=false;
				CM_mostrarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=false;
				CM_ocultarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=true;
				CM_ocultarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=true;
				CM_ocultarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=true
		    }
		   if(id==4){
				combo_supergrupo.enable();
				combo_grupo.disable();
				combo_subgrupo.disable();
				combo_id1.disable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_mostrarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=false;
				CM_mostrarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=false;
				CM_mostrarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=false;
				CM_ocultarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=true;
				CM_ocultarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=true
		    }
		   if(id==5){
				combo_supergrupo.enable();
				combo_grupo.disable();
				combo_subgrupo.disable();
				combo_id1.disable();
				combo_id2.disable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_mostrarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=false;
				CM_mostrarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=false;
				CM_mostrarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=false;
				CM_mostrarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=false;
				CM_ocultarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=true
		    }
		    if(id==6){
				combo_supergrupo.enable();
				combo_grupo.disable();
				combo_subgrupo.disable();
				combo_id1.disable();
				combo_id2.disable();
				combo_id3.disable();
				CM_mostrarComponente(combo_supergrupo);
				combo_supergrupo.setValue('');
				combo_supergrupo.allowBlank=false;
				CM_mostrarComponente(combo_grupo);
				combo_grupo.setValue('');
				combo_grupo.allowBlank=false;
				CM_mostrarComponente(combo_subgrupo);
				combo_subgrupo.setValue('');
				combo_subgrupo.allowBlank=false;
				CM_mostrarComponente(combo_id1);
				combo_id1.setValue('');
				combo_id1.allowBlank=false;
				CM_mostrarComponente(combo_id2);
				combo_id2.setValue('');
				combo_id2.allowBlank=false;
				CM_mostrarComponente(combo_id3);
				combo_id3.setValue('');
				combo_id3.allowBlank=false
		    }  
		};
		 var onGestion=function(e){
	    	var id=combo_gestion.getValue();
	      /*  combo_cuenta.CambiaGestion(combo_gestion.getValue());
	        combo_cuenta.modificado=true;
	        combo_cuenta.setValue('');
	        combo_cuenta_gasto.CambiaGestion(combo_gestion.getValue());
	        combo_cuenta_gasto.modificado=true;
	        combo_cuenta_gasto.setValue('');	*/        
	        combo_partida.store.baseParams={m_id_gestion:id};
			combo_partida.modificado=true;
			combo_partida.setValue('');
			
			ClaseMadre_getComponente('id_presupuesto').enable();
			ClaseMadre_getComponente('id_presupuesto').setValue('');
			ClaseMadre_getComponente('id_presupuesto').reset();
			ds_presupuesto.baseParams={sw_inv_gasto:'si', m_id_gestion:id};
			ClaseMadre_getComponente('id_presupuesto').modificado=true;
	    };
	    var onCuenta=function(e){
			var id=combo_cuenta.getValue();
			combo_auxiliar_activo.filterValues[0]=id;
			combo_auxiliar_activo.modificado=true;
			combo_auxiliar_activo.setValue('');
		};
		var onCuentaGasto=function(e){
			var id=combo_cuenta_gasto.getValue();
			combo_auxiliar_gasto.filterValues[0]=id;
			combo_auxiliar_gasto.modificado=true;
			combo_auxiliar_gasto.setValue('');
		};
		var onPartida=function(e){
	    	var id=combo_partida.getValue();
			combo_cuenta.filterValues[0]=id;
			combo_cuenta.modificado=true;
			combo_cuenta.setValue('');
			combo_cuenta_gasto.filterValues[0]=id;
			combo_cuenta_gasto.modificado=true;
			combo_cuenta_gasto.setValue('');
	    };
		combo_supergrupo.on('select',onSuperGrupoSelect);
		combo_supergrupo.on('change',onSuperGrupoSelect);
		combo_grupo.on('select',onGrupoSelect);
		combo_grupo.on('change',onGrupoSelect);
		combo_subgrupo.on('select',onSubGrupoSelect);
		combo_subgrupo.on('change',onSubGrupoSelect);
		combo_id1.on('select',onId1Select);
		combo_id1.on('change',onId1Select);
		combo_id2.on('select',onId2Select);
		combo_id2.on('change',onId2Select);
		combo_nivel.on('select',OnNivelSelect);
		combo_nivel.on('change',OnNivelSelect);
		combo_gestion.on('select',onGestion);
	    combo_gestion.on('change',onGestion);
	    combo_cuenta.on('select',onCuenta);
		combo_cuenta.on('change',onCuenta);
		combo_cuenta_gasto.on('select',onCuentaGasto);
		combo_cuenta_gasto.on('change',onCuentaGasto);
		combo_partida.on('select',onPartida);
		combo_partida.on('change',onPartida)
	}
	this.btnNew=function(){ data='';
		combo_nivel.store.reload();
		CM_ocultarComponente(combo_supergrupo);
		CM_ocultarComponente(combo_grupo);
		CM_ocultarComponente(combo_subgrupo);
		CM_ocultarComponente(combo_id1);
		CM_ocultarComponente(combo_id2);
		CM_ocultarComponente(combo_id3);
		CM_ocultarComponente(txt_descripcion);
		combo_supergrupo.disable();
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		combo_id3.disable();
		ClaseMadre_getComponente('id_presupuesto').disable();
		ClaseMadre_btnNew()
	};
	
	this.btnEliminar=function(){
		data='';
	    var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		   var SelectionsRecord=sm.getSelected();
	   	 if(SelectionsRecord.data.detalle_usado!=''){
	   	 	
	   	 	data='hidden_id_item_cuenta_partida_0='+SelectionsRecord.data.id_item_cuenta_partida;
	   	 	Ext.MessageBox.show({
           title: 'NOTA',
           msg: 'Existen registros asociados a esta parametrizacion <br />'+SelectionsRecord.data.detalle_usado+'<br />Desea Continua?',
           width:305,
           buttons: Ext.MessageBox.YESNO,
           fn: getObservaciones,
           icon:Ext.MessageBox.QUESTION
       });
	   	 }else{
	   	  	
	      CM_btnEliminar();
	   	 }
		   
		}else{
		    Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	 function getObservaciones(btn,text){
		if(btn!='no'){
			
		   
			Ext.Ajax.request({
			url:direccion+"../../../control/item_cuenta_partida/ActionEliminarItemCuentaPartida.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:Cm_conexionFailure,
			timeout:100000000
		});
	}
	 }
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			Cm_conexionFailure();
		}
	}

	this.getLayout=function(){
		return layout_item_cuenta_partida.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	

	/*var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral']),
		baseParams:{estado:'activo'}
		});
	var tpl_gestion_reg=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{estado_ges_gral}</FONT>','</div>');
	*/
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	var tpl_gestion_reg=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var gestion_combo =new Ext.form.ComboBox({
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar gestion...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_gestion',
			tpl:tpl_gestion_reg
		});

	ds_gestion.load({params:{start:0,limit: 1000000}});
	
	gestion_combo.on('select',
		function (combo, record, index){
			g_gestion=gestion_combo.getValue();

			ds.load({
				params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_gestion:g_gestion
						},
				callback : function (){}
			});			
		});
	
	function btn_reporte(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				var data='&txt_gestion='+gestion_combo.getValue();
				window.open(direccion+'../../../control/_reportes/relacionar_cuenta_partida/ActionReporteRelacionarCuentaPartida.php?'+data)	;		
	}
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBotonCombo(gestion_combo,'gestiones');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte  Cuenta Partida',btn_reporte,true,'ver_presol','Reporte');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item_cuenta_partida.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}