function ReporteMemoriaCalculo(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var componentes=new Array();
	var id_moneda , id_parametro, id_presupuesto, id_partida, id_tipo_presupuesto, f_f,e_p_e,u_o;
		
	var	g_CantFiltros='';
	var	g_tipo_pres='';
	var	g_id_parametro='';
	var	g_id_moneda='';
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';
	var	g_sw_vista='';
	var	g_ids_concepto_colectivo='';
 	
	var g_colectivo='';
	var g_desc_moneda='';
	var g_desc_pres='';
	var g_desc_estado_gral='';
	var g_gestion_pres='';
	
	var g_id_presupuesto='';
	var g_id_tipo_pres='';	
	var g_id_partida='';
	var g_formato_reporte='';
	var g_tipo_memoria='';	
	var g_memoria='';	
	var g_cod_partida='';
	var g_desc_partida='';
	
	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_fuente_financiamiento='';
	
	var cod_fuente_financiamiento='';
	var cod_organismo_fin='';
	var cod_programa='';
	var cod_proyecto='';
	var cod_actividad='';
	
	var g_filtro = '';
	
	
	//DATA STORE 		
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
			});
			
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','desc_presupuesto','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti',
																											'id_unidad_organizacional','desc_unidad_organizacional','id_fuente_financiamiento','denominacion','id_parametro',
																											'desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador',
																											'nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional',
																											'codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla',
																											'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																											'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'])
	});	
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/partida/ActionListarPartida.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });
	
	//DATA STORE COMBOS

    ds_programa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/programa/ActionListarPrograma.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'
		}, ['id_programa','codigo','descripcion' ])
	});

    ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/proyecto/ActionListarProyecto.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','codigo','descripcion' ])
	});

    ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/actividad/ActionListarActividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'
		}, ['id_actividad','codigo','descripcion' ])
	});
	
	ds_organismo_fin = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/organismo_fin/ActionListarOrganismoFin.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_organismo_fin',
			totalRecords: 'TotalCount'
		}, ['id_organismo_fin','codigo','descripcion' ])
	});
	
	ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fuente_financiamiento',
			totalRecords: 'TotalCount'
		}, ['id_fuente_financiamiento','codigo_fuente','denominacion' ])
	});

	//FUNCIONES RENDER
	
			function render_id_programa(value, p, record){return String.format('{0}', record.data['desc_programa']);}
			function render_id_proyecto(value, p, record){return String.format('{0}', record.data['desc_proyecto']);}
			function render_id_actividad(value, p, record){return String.format('{0}', record.data['desc_actividad']);}
			function render_id_organismo_fin(value, p, record){return String.format('{0}', record.data['desc_organismo_fin']);}
			function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['desc_fuente_financiamiento']);}
			
			
			var tpl_id_programa=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_actividad=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_organismo_fin=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b><i>{codigo_fuente} - {denominacion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

    
    function renderTipoPresupuesto(value, p, record)
		{						
			if(value == 1)
			{return "Recurso"}
			if(value == 2)
			{return "Gasto"}
			if(value == 3)
			{return "Inversi�n"}
			if(value == 4)
			{return "PNO - Recurso"}
			if(value == 5)
			{return "PNO - Gasto"}
			if(value == 6)
			{return "PNO - Inversi�n"}
			
			return '';
		}	
		
		function renderPeriodo(value, p, record)
		{
			if(value == 1) {return "Enero"}
			if(value == 2) {return "Febrero"}
			if(value == 3) {return "Marzo"}
			if(value == 4) {return "Abril"}
			if(value == 5) {return "Mayo"}
			if(value == 6) {return "Junio"}
			if(value == 7) {return "Julio"}
			if(value == 8) {return "Agosto"}
			if(value == 9) {return "Septiembre"}
			if(value == 10){return "Octubre"}
			if(value == 11){return "noviembre"}
			if(value == 12){return "Diciembre"}
			if(value == 13){return "Gesti�n"}
		}
		
		function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
						
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gesti�n: </b>{desc_parametro}</FONT>','</div>');
				
		
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
																													
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{codigo_partida} - {nombre_partida}</FONT></b><br>',
	                                                                  '<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>',
	                                                                  '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>','</div>');																																																																					
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestion',
			allowBlank:false,			
			//emptyText:'Parame...',
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
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
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
	
	vectorAtributos[1]={
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
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
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
	
	vectorAtributos[2]=
	{
			validacion:{
				name: 'filtro',
				fieldLabel:'Filtrar por',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Presupuesto'],['2','Categoria Programatica']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opci�n...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,
		};
	
	// txt id_programa
	vectorAtributos[3]= {
			validacion: {
			name:'id_programa',
			fieldLabel:'Cod. Programa',
			allowBlank:false,			
			//emptyText:'Programa...',
			desc: 'desc_programa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROGRA.descripcion#PROGRA.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, //caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_programa,
			tpl:tpl_id_programa,
			grid_visible:true,
			grid_editable:true,
			width:200,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROGRA.descripcion#PROGRA.codigo',
		defecto: '',
		save_as:'txt_id_programa'
		//id_grupo:1
	};

	// txt id_proyecto
	vectorAtributos[4]= {
			validacion: {
			name:'id_proyecto',
			fieldLabel:'Cod. Proyecto',
			allowBlank:false,			
			//emptyText:'Proyecto...',
			desc: 'desc_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion#PROYEC.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			tpl:tpl_id_proyecto,
			grid_visible:true,
			grid_editable:true,
			width:200,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROYEC.descripcion#PROYEC.codigo',
		defecto: '',
		save_as:'txt_id_proyecto'
		//id_grupo:1
	};
	
// txt id_actividad
	vectorAtributos[5] = {
			validacion: {
			name:'id_actividad',
			fieldLabel:'Cod. Actividad',
			allowBlank:false,			
			//emptyText:'Actividad...',
			desc: 'desc_actividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_actividad,
			valueField: 'id_actividad',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ACTIVI.descripcion#ACTIVI.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_actividad,
			renderer:render_id_actividad,
			grid_visible:true,
			grid_editable:true,
			width:200,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ACTIVI.descripcion#ACTIVI.codigo',
		defecto: '',
		save_as:'txt_id_actividad'
		//id_grupo:1
	};
	
	// txt id_actividad
	vectorAtributos[6] = {
			validacion: {
			name:'id_organismo_fin',
			fieldLabel:'Cod. Organismo Financiador',
			allowBlank:false,			
			//emptyText:'Organismo...',
			desc: 'desc_organismo_fin', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_organismo_fin,
			valueField: 'id_organismo_fin',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ORGFIN.descripcion#ORGFIN.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_organismo_fin,
			renderer:render_id_organismo_fin,
			grid_visible:true,
			grid_editable:true,
			width:200,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ORGFIN.descripcion#ORGFIN.codigo',
		defecto: '',
		save_as:'txt_id_organismo_fin'
		//id_grupo:1
	};
	
	// txt id_actividad
	vectorAtributos[7] = {
			validacion: {
			name:'id_fuente_financiamiento',
			fieldLabel:'Cod. Fuente de Financiamiento',
			allowBlank:false,			
			//emptyText:'Fuente...',
			desc: 'desc_fuente_financiamiento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'codigo_fuente',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.descripcion#FUNFIN.codigo_fuente',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_fuente_financiamiento,
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:true,
			width:200,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'FUNFIN.denominacion#FUNFIN.codigo_fuente',
		defecto: '',
		save_as:'txt_id_fuente_financiamiento'
		//id_grupo:1
	};
	
	
	vectorAtributos[8]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			//emptyText:'Presupue...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',				
			typeAhead:true,			
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, //caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,		
		filterColValue:'UNIORG.nombre_unidad#FUNFIN.denominacion#FINANC.nombre_financiador#REGION.nombre_regional#PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'id_presupuesto'
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'sub_programa',
			fieldLabel:'Proyecto',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:true,					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false				
	};
	
	vectorAtributos[10]={
			validacion:{
 			name:'id_partida',
			fieldLabel:'Partida ',
			allowBlank:false,			
			//emptyText:'Partida ',
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
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			//renderer:render_id_partida_origen,
 			grid_visible:true,
 			grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:250,
			disabled:false,
			grid_indice:9		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//id_grupo:2,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};	
	
	vectorAtributos[11]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width:200,			
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto: '1',
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 
	
	vectorAtributos[12]={
		validacion:{
			labelSeparator:'',
			name:'gestion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'gestion'
	};	
		
	vectorAtributos[13]=
	{
			validacion:{
				name: 'tipo_reporte',
				fieldLabel:'Tipo de Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','General'],['2','Periodo']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opci�n...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			save_as:'tipo_memoria'
		};
	
		
	vectorAtributos[14]=
	{
			validacion:{
				name: 'formato_reporte',
				fieldLabel:'Formato Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF'],['2','Excel']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opci�n...',
				width:200		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:0,
			defecto:'PDF',
			save_as:'formato_reporte'
		};
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:" Memoria de Calculo por Partida"
	};
	layout_ejecucion_reporte=new DocsLayoutProceso(idContenedor);
	layout_ejecucion_reporte.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ejecucion_reporte,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecucion Presupuestaria',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
				{
					tituloGrupo:'Filtros para Reporte Memoria Calculo',
					columna:0,
					id_grupo:0
				}			
			],

			submit:function ()
			{					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestion esta vacio ";}; 
				if(id_tipo_presupuesto.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio ";};
				//if(id_presupuesto.getValue()==""){mensaje+=" El campo Presupuesto esta vacio";};
				if(id_partida.getValue()==""){mensaje+=" El campo Partida esta vacio ";};
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio ";};
								
				if(mensaje=="")
				{					
					//mensaje="mem:"+g_tipo_memoria+" fil:"+g_filtro+" rep:"+g_tipo_reporte+" pre:";
					//Ext.MessageBox.alert(mensaje);
					
					var data='&id_presupuesto='+g_id_presupuesto;
				       data+='&tipo_pres='+g_id_tipo_pres;
					   data+='&nombre_fuente_financiamiento='+g_fuente_financiamiento;
			 	       data+='&nombre_financiador='+g_financiador;
				   	   data+='&nombre_regional='+g_regional;
			 	   	   data+='&nombre_programa='+g_programa;
			 	   	   data+='&nombre_proyecto='+g_proyecto;
			 	       data+='&nombre_actividad='+g_actividad;
			 	   	   data+='&desc_unidad_organizacional='+g_unidad_organizacional;
			 	   	   data+='&tipo_memoria='+g_tipo_memoria;			
				   	   data+='&id_partida='+g_id_partida;
				   	   data+='&id_moneda='+g_id_moneda;
				   	   data+='&tipo_reporte='+g_tipo_reporte;		
				   	   data+='&desc_partida='+g_desc_partida;
				   	   data+='&gestion_pres='+g_gestion_pres;		
				   	   data+='&desc_moneda='+g_desc_moneda;	
				   	   data+='&cod_fuente_fin='+cod_fuente_financiamiento;	
				   	   data+='&organismo='+cod_organismo_fin;	
				   	   data+='&programa='+cod_programa;	
				   	   data+='&proyecto='+cod_proyecto;	
				   	   data+='&actividad='+cod_actividad;
				   	   data+='&formato_reporte='+g_formato_reporte;
				   	   data+='&filtro='+g_filtro;
					
					//memoria gasto=2 rev
					if(g_tipo_memoria==2){
					
				   	   window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoGasto.php?'+data)	
				     }
				    else
				    {
				    	//memoria recursos humanos=6 rev
				    	if(g_tipo_memoria==6){			   
					       
					   	   window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoRRHH.php?'+data)	
					     }
					    else{
						   //memoria otros=8 rev
					    	if(g_tipo_memoria==8){		
	
						   	   window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoOtros.php?'+data)	
						     }
						    else{
						    	//memoria servicios	7 rev
							   if(g_tipo_memoria==7){
							   	
								   	window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoServicio.php?'+data);		
							   }
							   else{
								   //memoria recursos 1
								   if(g_tipo_memoria==1){
								   	  
							   	      window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoIngreso.php?'+data)
								   }
								   else{
									   //memoria pasaje 4
									   if(g_tipo_memoria==4){
									   	  
								   	      window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoPasaje.php?'+data)
									   }
									   else{
										   //memoria viaje 5
										   if(g_tipo_memoria==5){
										   	  
									   	      window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoViaje.php?'+data)
										   }
										   else{
										   		//memoria de inversion 3 rev
										   		if(g_tipo_memoria==3){
											       	   	   
											   	   window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoInversion.php?'+data)	
											     }
										   		else{
										   	   		//memoria de combustibles 9
										   			if(g_tipo_memoria==9){
											       			   
											   	   		window.open(direccion+'../../../../control/_reportes/memoria_calculo/MemoriaCalculoCombustible.php?'+data)	
											     	} 
										   			else{
										   	   				Ext.MessageBox.alert('...', 'Solo partidas de ingreso, inversion, gasto, recursos humanos, servicios, viajes, pasajes, combustibles y otros.')
										   			}
										   		}
										   }	
									   }
								   }
							   }					    	
						    }
				    	}			    	
				    }					
				}
				else
				{
					Ext.MessageBox.alert(mensaje);
				}			
			}
		}
	};

	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_presupuesto = ClaseMadre_getComponente('id_tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		sub_programa = ClaseMadre_getComponente('sub_programa');
		id_partida = ClaseMadre_getComponente('id_partida');	
		id_moneda = ClaseMadre_getComponente('id_moneda');		
		gestion=ClaseMadre_getComponente('gestion');
		cmbGestion=ClaseMadre_getComponente('id_parametro');
		cmp_filtro=ClaseMadre_getComponente('filtro');
		cmp_fuente_fin=ClaseMadre_getComponente('id_fuente_financiamiento');
		cmp_organismo=ClaseMadre_getComponente('id_organismo_fin');
		cmp_programa=ClaseMadre_getComponente('id_programa');
		cmp_proyecto=ClaseMadre_getComponente('id_proyecto');
		cmp_actividad=ClaseMadre_getComponente('id_actividad');

		CM_ocultarComponente(cmp_fuente_fin);
		CM_ocultarComponente(cmp_organismo);
		CM_ocultarComponente(cmp_programa);
		CM_ocultarComponente(cmp_proyecto);
		CM_ocultarComponente(cmp_actividad);	
		CM_ocultarComponente(id_presupuesto);
		CM_ocultarComponente(sub_programa);
					
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		var onGestionSelect = function(e) 
		{
			var id = cmbGestion.getValue();
			if(cmbGestion.store.getById(id)!=undefined)
			{
				intGestion=cmbGestion.store.getById(id).data.gestion_pres;
			}
		};		
		
		cmbGestion.on('select',onGestionSelect);
		componentes[0].on('select',evento_parametro);		//parametro		
		componentes[1].on('select',evento_tipo_presupuesto);	//tipo_pres	
		componentes[2].on('select',evento_filtro);	//tipo_pres	
		
		componentes[3].on('select',evento_programa);	//programa
		componentes[4].on('select',evento_proyecto);	//proyecto
		componentes[5].on('select',evento_actividad);	//actividad
		componentes[6].on('select',evento_organismo_fin);	//organismo_fin
		componentes[7].on('select',evento_fuente_financiamiento);	//fuente_financiamiento
		
		componentes[8].on('select',evento_presupuesto);		//presupuesto
		componentes[10].on('select',evento_partida);		//partida
		componentes[11].on('select',evento_moneda);		//moneda
		componentes[13].on('select',evento_tipo_reporte);		//tipo reporte
		componentes[14].on('select',evento_formato_reporte);		//formato reporte
	}
	
	function evento_parametro( combo, record, index )
	{
		g_id_parametro=record.data.id_parametro;		
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'no'};
		componentes[1].modificado=true;
		componentes[1].setValue('');
		
		componentes[3].store.baseParams={m_id_parametro:componentes[0].getValue()};
		componentes[3].allowBlank = true;
		componentes[3].modificado=true;
		componentes[3].setValue('');
		
		componentes[4].allowBlank = true;
		componentes[4].modificado=true;
		componentes[4].setValue('');
		
		componentes[5].allowBlank = true;
		componentes[5].modificado=true;
		componentes[5].setValue('');
		
		componentes[6].allowBlank = true;
		componentes[6].modificado=true;
		componentes[6].setValue('');
		
		componentes[7].allowBlank = true;
		componentes[7].modificado=true;
		componentes[7].setValue('');
		
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		g_id_tipo_pres=componentes[1].getValue();		
		g_desc_pres=renderTipoPresupuesto(g_id_tipo_pres, '', '');		
		
		componentes[2].modificado=true;			
		componentes[2].setValue('');		
	}
	
	function evento_filtro( combo, record, index )
	{
		g_filtro = componentes[2].getValue();
		
		g_id_presupuesto='';
		g_regional='';
		g_financiador='';
		g_programa='';
		g_proyecto='';
		g_actividad='';
		g_unidad_organizacional='';
		g_fuente_financiamiento='';
		
		cod_fuente_financiamiento='';
		cod_organismo_fin='';
		cod_programa='';
		cod_proyecto='';
		cod_actividad='';
		
		if(record.data.id == '1')
		{
			CM_ocultarComponente(cmp_fuente_fin);
			CM_ocultarComponente(cmp_organismo);
			CM_ocultarComponente(cmp_programa);
			CM_ocultarComponente(cmp_proyecto);
			CM_ocultarComponente(cmp_actividad);
			
			CM_mostrarComponente(id_presupuesto);
			CM_mostrarComponente(sub_programa);			
			
			
			
			componentes[3].allowBlank = true;
			componentes[3].modificado = true;			
			componentes[3].setValue('');
			
			componentes[4].allowBlank = true;
			componentes[4].modificado=true;			
			componentes[4].setValue('');
			
			componentes[5].allowBlank = true;
			componentes[5].modificado=true;			
			componentes[5].setValue('');
			
			componentes[6].allowBlank = true;
			componentes[6].modificado=true;			
			componentes[6].setValue('');
			
			componentes[7].allowBlank = true;
			componentes[7].modificado=true;			
			componentes[7].setValue('');	

			componentes[8].store.baseParams={sw_reporte_ejecucion:'si',m_id_parametro:componentes[0].getValue(),m_id_tipo_pres:componentes[1].getValue()};  			
			componentes[8].allowBlank = false;
			componentes[8].modificado=true;			
			componentes[8].setValue('');			
			
			componentes[9].modificado = true;			
			componentes[9].setValue('');
		}
		else
		{
			CM_mostrarComponente(cmp_fuente_fin);
			CM_mostrarComponente(cmp_organismo);
			CM_mostrarComponente(cmp_programa);
			CM_mostrarComponente(cmp_proyecto);
			CM_mostrarComponente(cmp_actividad);			
			
			CM_ocultarComponente(id_presupuesto);
			CM_ocultarComponente(sub_programa);		
			
			componentes[3].modificado=true;			
			componentes[3].setValue('');
			componentes[3].allowBlank = false;
			
			componentes[4].modificado=true;			
			componentes[4].setValue('');
			componentes[4].allowBlank = false;
			
			componentes[5].modificado=true;			
			componentes[5].setValue('');
			componentes[5].allowBlank = false;
			
			componentes[6].modificado=true;			
			componentes[6].setValue('');
			componentes[6].allowBlank = false;
			
			
			componentes[7].modificado=true;			
			componentes[7].setValue('');	
			componentes[7].allowBlank = false;
			
			componentes[8].allowBlank = true;	
			componentes[8].modificado=true;			
			componentes[8].setValue('');
			
			componentes[10].store.baseParams={sw_traspaso:'si',m_id_presupuesto:'%',m_id_tipo_pres:g_id_tipo_pres,m_id_parametro:g_id_parametro};		
		}				
	}
	
	function evento_presupuesto( combo, record, index )	
	{		
		g_id_presupuesto = componentes[8].getValue();
		g_ids_fuente_financiamiento=record.data.id_fuente_financiamiento;
		g_ids_u_o=record.data.id_unidad_organizacional;
		g_ids_financiador=g_proyecto=record.data.id_financiador;
		g_ids_regional=record.data.id_regional;
		g_ids_programa=record.data.id_programa;
		g_ids_proyecto=record.data.id_proyecto;
		g_ids_actividad=record.data.id_actividad;	
			 	
	 	g_regional=record.data.nombre_regional;
	 	g_financiador=record.data.nombre_financiador;
	 	g_programa=record.data.nombre_programa;
	 	g_proyecto=record.data.nombre_proyecto;
	 	g_actividad=record.data.nombre_actividad;
	 	g_unidad_organizacional=record.data.desc_unidad_organizacional;
	 	g_fuente_financiamiento=record.data.denominacion;
	 	g_CantFiltros=1;		
		
		componentes[9].setValue(g_proyecto);	//sub_progama
		
		componentes[10].store.baseParams={sw_traspaso:'si',m_id_presupuesto:record.data.id_presupuesto,m_id_tipo_pres:g_id_tipo_pres,m_id_parametro:g_id_parametro};
		componentes[10].modificado=true;		
		componentes[10].setValue('');			//partida
		componentes[10].setDisabled(false);			
	}
	
	function evento_partida( combo, record, index )
	{		
		g_id_partida=record.data.id_partida;
		g_desc_partida=record.data.desc_par;
		g_cod_partida = record.data.codigo_partida;
		g_tipo_memoria=record.data.tipo_memoria;	
	}
	
	function evento_programa( combo, record, index )
	{
		cod_programa=record.data.codigo;	
	 	g_programa=record.data.codigo + '-' + record.data.descripcion;
	 	
		componentes[4].store.baseParams={m_id_parametro:componentes[0].getValue(),m_id_programa:componentes[3].getValue()};
		componentes[4].modificado=true;
		componentes[4].setValue('');
		
		componentes[5].modificado=true;
		componentes[5].setValue('');
		
		componentes[6].modificado=true;
		componentes[6].setValue('');
		
		componentes[7].modificado=true;
		componentes[7].setValue('');
	}
	
	function evento_proyecto( combo, record, index )
	{
		cod_proyecto=record.data.codigo;	
		g_proyecto=record.data.codigo + '-' + record.data.descripcion;
	 	
		componentes[5].store.baseParams={m_id_parametro:componentes[0].getValue(),m_id_programa:componentes[3].getValue(),m_id_proyecto:componentes[4].getValue()};
		componentes[5].modificado=true;
		componentes[5].setValue('');
		
		componentes[6].modificado=true;
		componentes[6].setValue('');
		
		componentes[7].modificado=true;
		componentes[7].setValue('');
	}
	
	function evento_actividad( combo, record, index )
	{
		cod_actividad=record.data.codigo;	
		g_actividad=record.data.codigo + '-' + record.data.descripcion;
		
		componentes[6].store.baseParams={m_id_parametro:componentes[0].getValue(),m_id_programa:componentes[3].getValue(),m_id_proyecto:componentes[4].getValue(),m_id_actividad:componentes[5].getValue()};
		componentes[6].modificado=true;
		componentes[6].setValue('');
		
		componentes[7].modificado=true;
		componentes[7].setValue('');
	}
	
	function evento_organismo_fin( combo, record, index )
	{
		cod_organismo_fin=record.data.codigo;		
		g_financiador=record.data.codigo + '-' + record.data.descripcion;
	 	
		componentes[7].store.baseParams={m_id_parametro:componentes[0].getValue(),m_id_programa:componentes[3].getValue(),m_id_proyecto:componentes[4].getValue(),m_id_actividad:componentes[5].getValue(),m_id_organismo_fin:componentes[6].getValue()};
		componentes[7].modificado=true;
		componentes[7].setValue('');
	}
	
	function evento_fuente_financiamiento( combo, record, index )
	{
		cod_fuente_financiamiento=record.data.codigo_fuente;
		g_fuente_financiamiento=record.data.denominacion;			
	}
	
	
	function evento_moneda( combo, record, index )
	{
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;	
	}	
	
	function evento_tipo_reporte( combo, record, index )
	{
		g_tipo_reporte=record.data.valor;
	}
	
	function evento_formato_reporte( combo, record, index )
	{
		g_formato_reporte = record.data.id;	
	}
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el bot�n para la generaci�n del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
