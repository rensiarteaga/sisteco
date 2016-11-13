//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	echo "var sw_vista='$sw_vista';";
	?>
	var paramConfig={TiempoEspera:10000};
	var elemento={pagina:new pagina_repeje_consolida(idContenedor,direccion,paramConfig,sw_vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_repeje_consolida(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_repeje_consolida;
	var ContPes = 1;
	var vectorAtributos = new Array;
	
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	var g_admi;
	
	var comp_id_parametro, comp_id_tipo_pres, comp_fecha_ini, comp_fecha_fin, comp_id_moneda, comp_desc_moneda, comp_desc_gestion, comp_desc_tipo_pres, comp_desc_partida;
	var comp_sw_vista, comp_sw_ejecuta, comp_sw_filtro, comp_sw_mes, comp_sw_trim, comp_sw_nivel, comp_sw_impre, comp_sw_eplis, comp_sw_cplis, comp_id_partida;
	
	var comp_sw_ppto, comp_sw_cprog, comp_ids_ppto, comp_ids_cprog;
	var comp_sw_ep_fina, comp_sw_ep_regi, comp_sw_ep_prog, comp_sw_ep_proy, comp_sw_ep_acti, comp_sw_ep_uo;
	var comp_sw_cp_prog, comp_sw_cp_proy, comp_sw_cp_acti, comp_sw_cp_fuen, comp_sw_cp_orga;
	
	var comp_ids_ep_fina, comp_ids_ep_regi, comp_ids_ep_prog, comp_ids_ep_proy, comp_ids_ep_acti, comp_ids_ep_uo;
	var comp_ids_cp_prog, comp_ids_cp_proy, comp_ids_cp_acti, comp_ids_cp_fuen, comp_ids_cp_orga;
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
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
	var ds_cprog = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_fina = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_regi = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_prog = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_proy = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_acti = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_ep_uo = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_cp_prog = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_cp_proy = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_cp_acti = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_cp_fuen = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});
	var ds_cp_orga = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/rep_ejecuta/ActionListarDatos.php'}),
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
 	
	function render_cprog(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cprog = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_ep_fina(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_fina = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');

	function render_ep_regi(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_regi = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_ep_prog(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_prog = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_ep_proy(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_proy = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_ep_acti(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_acti = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_ep_uo(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ep_uo = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_cp_prog(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cp_prog = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_cp_proy(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cp_proy = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_cp_acti(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cp_acti = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_cp_fuen(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cp_fuen = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_cp_orga(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_cp_orga = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo_partida} {nombre_partida}</FONT><br>','</div>');
	
	/////////////////////////'<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>', '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>',
	// Definición de datos //
	/////////////////////////  ['13','Comparativo'],   ,['12','Mensual - Inversión']
	vectorAtributos[0]={
		validacion:{
			name: 'sw_ejecuta',
			fieldLabel:'Ejecución',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','A una fecha'],['2','Entre fechas'],['3','Fechas - Acumulado'],['4','Periodo - Acumulado'],
			                                                            ['10','Mensual - Partida'],['9','Por Partida a una fecha'],['11','Por Partida entre fechas'],
			                                                            ['5','Anual'],['6','Trimestral'],['7','Mensual'],['8','Mensual - Acumulado']]}),				
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
			name: 'sw_filtro',
			fieldLabel:'Consultar por',
			allowBlank:false,
			emptyText:'Sel...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','Presupuesto'],['2','Categoría Programática'],['3','Estructura Programática EPE'],['4','Categoría Programática Detallada']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',
		id_grupo:0,
		save_as:'sw_filtro'
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'sw_ppto',
			fieldLabel:'Opción',
			allowBlank:false,
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PPTO(s)']]}),
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
		id_grupo:8,
		save_as:'sw_ppto'
	};	

	vectorAtributos[5]={
		validacion:{
			name:'ids_ppto',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ppto,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ppto,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ppto,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:8,
 		form: true
	};
	
	vectorAtributos[6]={
		validacion:{
			name:'sw_cprog',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar CAT.PROG.(s)']]}),
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
		id_grupo:3,
		save_as:'sw_cprog'
	};	

	vectorAtributos[7]={
		validacion:{
			name:'ids_cprog',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cprog,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cprog,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cprog,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
 		form: true
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'sw_ep_fina',
			fieldLabel:'Financiador',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar FIN(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_fina'
	};	

	vectorAtributos[9]={
		validacion:{
			name:'ids_ep_fina',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_fina,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_fina,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_fina,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
	
	vectorAtributos[10]={
		validacion:{
			name:'sw_ep_regi',
			fieldLabel:'Regional',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar REG(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_regi'
	};	

	vectorAtributos[11]={
		validacion:{
			name:'ids_ep_regi',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_regi,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_regi,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_regi,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
	
	vectorAtributos[12]={
		validacion:{
			name:'sw_ep_prog',
			fieldLabel:'Programa',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROG(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_prog'
	};	

	vectorAtributos[13]={
		validacion:{
			name:'ids_ep_prog',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_prog,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_prog,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_prog,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
	
	vectorAtributos[14]={
		validacion:{
			name:'sw_ep_proy',
			fieldLabel:'Proyecto',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROY(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_proy'
	};	

	vectorAtributos[15]={
		validacion:{
			name:'ids_ep_proy',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_proy,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_proy,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_proy,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
				
	vectorAtributos[16]={
		validacion:{
			name:'sw_ep_acti',
			fieldLabel:'Actividad',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar ACT(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_acti'
	};	

	vectorAtributos[17]={
		validacion:{
			name:'ids_ep_acti',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_acti,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_acti,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_acti,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
					
	vectorAtributos[18]={
		validacion:{
			name:'sw_ep_uo',
			fieldLabel:'U.O.',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar U.O.(s)']]}),
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
		id_grupo:4,
		save_as:'sw_ep_uo'
	};	

	vectorAtributos[19]={
		validacion:{
			name:'ids_ep_uo',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ep_uo,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_ep_uo,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_ep_uo,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
 		form: true
	};
						
	vectorAtributos[20]={
		validacion:{
			name:'sw_cp_prog',
			fieldLabel:'Programa',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROG(s)']]}),
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
		id_grupo:5,
		save_as:'sw_cp_prog'
	};	

	vectorAtributos[21]={
		validacion:{
			name:'ids_cp_prog',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cp_prog,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cp_prog,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cp_prog,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
 		form: true
	};
	
	vectorAtributos[22]={
		validacion:{
			name:'sw_cp_proy',
			fieldLabel:'Proyecto',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar PROY(s)']]}),
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
		id_grupo:5,
		save_as:'sw_cp_proy'
	};	

	vectorAtributos[23]={
		validacion:{
			name:'ids_cp_proy',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cp_proy,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cp_proy,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cp_proy,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
 		form: true
	};

	vectorAtributos[24]={
		validacion:{
			name:'sw_cp_acti',
			fieldLabel:'Actividad',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar ACT(s)']]}),
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
		id_grupo:5,
		form: true,
		save_as:'sw_cp_acti'
	};	

	vectorAtributos[25]={
		validacion:{
			name:'ids_cp_acti',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cp_acti,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cp_acti,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cp_acti,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
 		form: true
	};

	vectorAtributos[26]={
		validacion:{
			name:'sw_cp_fuen',
			fieldLabel:'Fuente Fin.',
			allowBlank:false,
			align:'left',
			emptyText:'Sel...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar FUEN(s)']]}),
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
		id_grupo:5,
		form: true,
		save_as:'sw_cp_fuen'
	};	

	vectorAtributos[27]={
		validacion:{
			name:'ids_cp_fuen',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cp_fuen,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cp_fuen,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cp_fuen,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
 		form: true
	};
	
	vectorAtributos[28]={
		validacion:{
			name:'sw_cp_orga',
			fieldLabel:'Organismo Finan.',
			vtype:'texto',
			allowBlank:false,
			emptyText:'Sel...',
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todos','Todos ...'],['seleccion','Seleccionar ORG(s)']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			forceSelection:false,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:5,
		form: true,
		save_as:'sw_cp_orga'
	};	

	vectorAtributos[29]={
		validacion:{
			name:'ids_cp_orga',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_cp_orga,	
			maestroValField:'codigo_nombre',
			valueField: 'id_datos',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_cp_orga,				
			defValor:function(val,record){					
				var text = '\"'+ record['codigo'] +'\" ' +'<'+record['nombre'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:true,
			resizable:true,
			renderer:render_cp_orga,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
 		form: true
	};
	
	vectorAtributos[30]={
		validacion:{
			name: 'sw_nivel',
			fieldLabel:'Niveles',
			vtype:'texto',
			emptyText:'Nivel...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Todos los Niveles'],['2','Grupos y Partidas de Movimiento'],['3','Grupos de Partidas']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:6,			
		save_as:'sw_nivel'
	};

	vectorAtributos[31]={
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
		id_grupo:6,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};

	vectorAtributos[32]={
		validacion:{
			name: 'sw_impre',
			fieldLabel:'Impresión',
			vtype:'texto',
			emptyText:'Impresión...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','De Gestión - Seguimiento'],['2','De Reporte - Declaración']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:6,			
		save_as:'sw_impre'
	};

	vectorAtributos[33]={
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
		id_grupo:6,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[34] = {
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
	
	vectorAtributos[35] = {
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
	
	vectorAtributos[36]={
		validacion:{
			name: 'sw_mes',
			fieldLabel:'Mes:',
			vtype:'texto',
			emptyText:'Mes...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','ENERO'],['2','FEBRERO'],['3','MARZO'],['4','ABRIL'],['5','MAYO'],['6','JUNIO'],
			                                                            ['7','JULIO'],['8','AGOSTO'],['9','SEPTIEMBRE'],['10','OCTUBRE'],['11','NOVIEMBRE'],['12','DICIEMBRE']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:1,
		save_as:'sw_mes'
	};
	
	vectorAtributos[37]={
		validacion:{
			name: 'sw_trim',
			fieldLabel:'Trimestre:',
			vtype:'texto',
			emptyText:'Trimestre...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Enero - Febrero - Marzo'],['2','Abril - Mayo - Junio'],['3','Julio - Agosto - Septiembre'],['4','Octubre - Noviembre - Diciembre']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:1,
		save_as:'sw_trim'
	};
	
	vectorAtributos[38]={
		validacion:{
			name: 'sw_eplis',
			fieldLabel:'Listar por:',
			vtype:'texto',
			emptyText:'Listar...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['EP','Proyecto - Financiador EPE'],['FI','Financiador'],['RE','Regional'],['PR','Programa'],['PY','Proyecto'],['AC','Actividad'],['UO','Unidad Organizacional']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:4,
		save_as:'sw_eplis'
	};
	
	vectorAtributos[39]={
		validacion:{
			name: 'sw_cplis',
			fieldLabel:'Listar por:',
			vtype:'texto',
			emptyText:'Listar...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['PG','Programa'],['YE','Proyecto'],['AT','Actividad'],['FF','Fuente de Financiamiento'],['OF','Organismo Financiador']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			width:200		
		},
		tipo: 'ComboBox',		
		id_grupo:5,
		save_as:'sw_cplis'
	};
	
	vectorAtributos[40]={
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
			queryDelay:350,
			pageSize:20,
			minListWidth:350,
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
      		width:350		
		}, 
		tipo:'ComboBox',
		id_grupo:2,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};
	
	vectorAtributos[41] = {
		validacion : {
			labelSeparator :'',
			name :'sw_vista',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:7
	};
	
	vectorAtributos[42] = {
		validacion : {
			labelSeparator :'',
			name :'desc_moneda',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:7
	};
	
	vectorAtributos[43] = {
		validacion : {
			labelSeparator :'',
			name :'desc_gestion',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:7
	};
	
	vectorAtributos[44] = {
		validacion : {
			labelSeparator :'',
			name :'desc_tipo_pres',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:7
	};

	vectorAtributos[45] = {
		validacion : {
			labelSeparator :'',
			name :'desc_partida',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:7
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_repeje_consolida = new DocsLayoutProceso(idContenedor);
	layout_repeje_consolida.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_repeje_consolida, idContenedor);
	
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
		comp_sw_filtro = ClaseMadre_getComponente('sw_filtro');
		comp_sw_mes = ClaseMadre_getComponente('sw_mes');
		comp_sw_trim = ClaseMadre_getComponente('sw_trim');
		comp_sw_nivel = ClaseMadre_getComponente('sw_nivel');
		comp_sw_impre = ClaseMadre_getComponente('sw_impre');
		comp_sw_eplis = ClaseMadre_getComponente('sw_eplis');
		comp_sw_cplis = ClaseMadre_getComponente('sw_cplis');
		comp_id_partida = ClaseMadre_getComponente('id_partida');
		comp_desc_partida = ClaseMadre_getComponente('desc_partida');
		
		comp_sw_ppto = ClaseMadre_getComponente('sw_ppto');
		comp_sw_cprog = ClaseMadre_getComponente('sw_cprog');
		comp_sw_ep_fina = ClaseMadre_getComponente('sw_ep_fina');
		comp_sw_ep_regi = ClaseMadre_getComponente('sw_ep_regi');
		comp_sw_ep_prog = ClaseMadre_getComponente('sw_ep_prog');
		comp_sw_ep_proy = ClaseMadre_getComponente('sw_ep_proy');
		comp_sw_ep_acti = ClaseMadre_getComponente('sw_ep_acti');
		comp_sw_ep_uo = ClaseMadre_getComponente('sw_ep_uo');
		comp_sw_cp_prog = ClaseMadre_getComponente('sw_cp_prog');
		comp_sw_cp_proy = ClaseMadre_getComponente('sw_cp_proy');
		comp_sw_cp_acti = ClaseMadre_getComponente('sw_cp_acti');
		comp_sw_cp_fuen = ClaseMadre_getComponente('sw_cp_fuen');
		comp_sw_cp_orga = ClaseMadre_getComponente('sw_cp_orga');
		
		comp_ids_ppto = ClaseMadre_getComponente('ids_ppto');
		comp_ids_cprog = ClaseMadre_getComponente('ids_cprog');
		comp_ids_ep_fina = ClaseMadre_getComponente('ids_ep_fina');
		comp_ids_ep_regi = ClaseMadre_getComponente('ids_ep_regi');
		comp_ids_ep_prog = ClaseMadre_getComponente('ids_ep_prog');
		comp_ids_ep_proy = ClaseMadre_getComponente('ids_ep_proy');
		comp_ids_ep_acti = ClaseMadre_getComponente('ids_ep_acti');
		comp_ids_ep_uo = ClaseMadre_getComponente('ids_ep_uo');
		comp_ids_cp_prog = ClaseMadre_getComponente('ids_cp_prog');
		comp_ids_cp_proy = ClaseMadre_getComponente('ids_cp_proy');
		comp_ids_cp_acti = ClaseMadre_getComponente('ids_cp_acti');
		comp_ids_cp_fuen = ClaseMadre_getComponente('ids_cp_fuen');
		comp_ids_cp_orga = ClaseMadre_getComponente('ids_cp_orga');
		
		comp_id_parametro.on('select',f_evento_parametro);	
		comp_id_tipo_pres.on('select',f_evento_tipo_pres);	
		comp_fecha_ini.on('blur',f_evento_ini);		
		comp_id_moneda.on('select',f_evento_id_moneda);	
		comp_sw_filtro.on('select',f_evento_sw_filtro);
		comp_id_partida.on('select',f_evento_partida);
		
		comp_sw_ppto.on('select',f_evento_sw_ppto);
		comp_sw_cprog.on('select',f_evento_sw_cprog);
		comp_sw_ep_fina.on('select',f_evento_sw_ep_fina);
		comp_sw_ep_regi.on('select',f_evento_sw_ep_regi);
		comp_sw_ep_prog.on('select',f_evento_sw_ep_prog);
		comp_sw_ep_proy.on('select',f_evento_sw_ep_proy);
		comp_sw_ep_acti.on('select',f_evento_sw_ep_acti);
		comp_sw_ep_uo.on('select',f_evento_sw_ep_uo);
		comp_sw_cp_prog.on('select',f_evento_sw_cp_prog);
		comp_sw_cp_proy.on('select',f_evento_sw_cp_proy);
		comp_sw_cp_acti.on('select',f_evento_sw_cp_acti);
		comp_sw_cp_fuen.on('select',f_evento_sw_cp_fuen);
		comp_sw_cp_orga.on('select',f_evento_sw_cp_orga);
		
		comp_sw_ejecuta.on('select',f_evento_sw_ejecuta);
		
		comp_sw_vista.setValue(sw_vista);
		
		if(sw_vista == 'formular' || sw_vista == 'fasignar'){
			CM_ocultarComponente(comp_sw_ejecuta);
			comp_sw_ejecuta.allowBlank=true;
			comp_sw_ejecuta.setValue('');
			
			CM_ocultarComponente(comp_sw_impre);
			comp_sw_impre.allowBlank=true;
			comp_sw_impre.setValue('');
			
			comp_id_partida.allowBlank=true;
			comp_fecha_ini.allowBlank=true;
			comp_fecha_fin.allowBlank=true;
			comp_sw_mes.allowBlank=true;
			comp_sw_trim.allowBlank=true;
			comp_sw_impre.allowBlank=true;
			comp_sw_eplis.allowBlank=true;
			comp_sw_cplis.allowBlank=true;
		}
		
		if(sw_vista == 'formular'){g_admi = 'SI';}
		if(sw_vista == 'fasignar'){g_admi = 'NO';}
		if(sw_vista == 'ejecutar'){g_admi = 'SI';}
		if(sw_vista == 'easignar'){g_admi = 'NO';}
		
		CM_ocultarGrupo('Hidden');
		CM_ocultarGrupo('Periodo');
		CM_ocultarGrupo('Partida');
		
		limpiar_componentes();
	}
	
	function limpiar_componentes(){
		CM_ocultarGrupo('Presupuesto');
		CM_ocultarGrupo('Categoria Programatica');
		CM_ocultarGrupo('Estructura Programatica EPE');
		CM_ocultarGrupo('Categoria Programatica Detallada');
		
		comp_sw_ppto.allowBlank=true;
		comp_sw_cprog.allowBlank=true;
		comp_sw_ep_fina.allowBlank=true;
		comp_sw_ep_regi.allowBlank=true;
		comp_sw_ep_prog.allowBlank=true;
		comp_sw_ep_proy.allowBlank=true;
		comp_sw_ep_acti.allowBlank=true;
		comp_sw_ep_uo.allowBlank=true;
		comp_sw_cp_prog.allowBlank=true;
		comp_sw_cp_proy.allowBlank=true;
		comp_sw_cp_acti.allowBlank=true;
		comp_sw_cp_fuen.allowBlank=true;
		comp_sw_cp_orga.allowBlank=true;
		
		comp_sw_ppto.setValue('todos');
		comp_sw_cprog.setValue('todos');
		comp_sw_ep_fina.setValue('todos');
		comp_sw_ep_regi.setValue('todos');
		comp_sw_ep_prog.setValue('todos');
		comp_sw_ep_proy.setValue('todos');
		comp_sw_ep_acti.setValue('todos');
		comp_sw_ep_uo.setValue('todos');
		comp_sw_cp_prog.setValue('todos');
		comp_sw_cp_proy.setValue('todos');
		comp_sw_cp_acti.setValue('todos');
		comp_sw_cp_fuen.setValue('todos');
		comp_sw_cp_orga.setValue('todos');
		
		CM_ocultarComponente(comp_ids_ppto);
		CM_ocultarComponente(comp_ids_cprog);
		CM_ocultarComponente(comp_ids_ep_fina);
		CM_ocultarComponente(comp_ids_ep_regi);
		CM_ocultarComponente(comp_ids_ep_prog);
		CM_ocultarComponente(comp_ids_ep_proy);
		CM_ocultarComponente(comp_ids_ep_acti);
		CM_ocultarComponente(comp_ids_ep_uo);
		CM_ocultarComponente(comp_ids_cp_prog);
		CM_ocultarComponente(comp_ids_cp_proy);
		CM_ocultarComponente(comp_ids_cp_acti);
		CM_ocultarComponente(comp_ids_cp_fuen);
		CM_ocultarComponente(comp_ids_cp_orga);
		
		CM_ocultarComponente(comp_sw_eplis);
		CM_ocultarComponente(comp_sw_cplis);
		
		comp_ids_ppto.allowBlank=true;
		comp_ids_cprog.allowBlank=true;
		comp_ids_ep_fina.allowBlank=true;
		comp_ids_ep_regi.allowBlank=true;
		comp_ids_ep_prog.allowBlank=true;
		comp_ids_ep_proy.allowBlank=true;
		comp_ids_ep_acti.allowBlank=true;
		comp_ids_ep_uo.allowBlank=true;
		comp_ids_cp_prog.allowBlank=true;
		comp_ids_cp_proy.allowBlank=true;
		comp_ids_cp_acti.allowBlank=true;
		comp_ids_cp_fuen.allowBlank=true;
		comp_ids_cp_orga.allowBlank=true;
		
		comp_sw_eplis.allowBlank=true;
		comp_sw_cplis.allowBlank=true;
		
		comp_ids_ppto.setValue('');
		comp_ids_cprog.setValue('');
		comp_ids_ep_fina.setValue('');
		comp_ids_ep_regi.setValue('');
		comp_ids_ep_prog.setValue('');
		comp_ids_ep_proy.setValue('');
		comp_ids_ep_acti.setValue('');
		comp_ids_ep_uo.setValue('');
		comp_ids_cp_prog.setValue('');
		comp_ids_cp_proy.setValue('');
		comp_ids_cp_acti.setValue('');
		comp_ids_cp_fuen.setValue('');
		comp_ids_cp_orga.setValue('');
		
		comp_sw_eplis.setValue('');
		comp_sw_cplis.setValue('');
	}
	
	function f_evento_sw_ejecuta(combo, record, index){
		limpiar_componentes();
		
		CM_ocultarGrupo('Partida');
		comp_id_partida.allowBlank=true;
		comp_id_partida.setValue('');
		
		comp_id_parametro.setValue('');
		comp_id_tipo_pres.setValue('');
		comp_sw_filtro.setValue('');
		
		CM_ocultarComponente(comp_fecha_ini);
		CM_ocultarComponente(comp_fecha_fin);
		CM_ocultarComponente(comp_sw_mes);
		CM_ocultarComponente(comp_sw_trim);
		CM_ocultarComponente(comp_sw_nivel);
		CM_ocultarComponente(comp_sw_impre);
		CM_ocultarComponente(comp_sw_eplis);
		CM_ocultarComponente(comp_sw_cplis);
		
		comp_fecha_ini.allowBlank=true;
		comp_fecha_fin.allowBlank=true;
		comp_sw_mes.allowBlank=true;
		comp_sw_trim.allowBlank=true;
		comp_sw_nivel.allowBlank=true;
		comp_sw_impre.allowBlank=true;
		comp_sw_eplis.allowBlank=true;
		comp_sw_cplis.allowBlank=true;
		
		comp_fecha_ini.setValue('');
		comp_fecha_fin.setValue('');
		comp_sw_mes.setValue('');
		comp_sw_trim.setValue('');
		comp_sw_nivel.setValue('');
		comp_sw_impre.setValue('');
		comp_sw_eplis.setValue('');
		comp_sw_cplis.setValue('');
		
		CM_mostrarGrupo('Periodo');
		
		if (record.data.ID == '1'){
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_fin.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
			CM_mostrarComponente(comp_sw_impre);
			comp_sw_impre.allowBlank=false;
		}
		if (record.data.ID == '2'){
			CM_mostrarComponente(comp_fecha_ini);
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_ini.allowBlank=false;
			comp_fecha_fin.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
		}
		if (record.data.ID == '3'){
			CM_mostrarComponente(comp_fecha_ini);
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_ini.allowBlank=false;
			comp_fecha_fin.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
			CM_mostrarComponente(comp_sw_impre);
			comp_sw_impre.allowBlank=false;
		}
		if (record.data.ID == '4'){
			CM_mostrarComponente(comp_sw_mes);
			comp_sw_mes.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
			CM_mostrarComponente(comp_sw_impre);
			comp_sw_impre.allowBlank=false;
		}
		if (record.data.ID == '5'){
			CM_ocultarGrupo('Periodo');
		}
		if (record.data.ID == '6'){
			CM_mostrarComponente(comp_sw_trim);
			comp_sw_trim.allowBlank=false;
		}
		if (record.data.ID == '7'){
			CM_mostrarComponente(comp_sw_mes);
			comp_sw_mes.allowBlank=false;
		}
		if (record.data.ID == '8'){
			CM_mostrarComponente(comp_sw_mes);
			comp_sw_mes.allowBlank=false;
		}
		if (record.data.ID == '9'){
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_fin.allowBlank=false;
			comp_id_partida.allowBlank=false;
			
			CM_mostrarGrupo('Partida');
		}
		if (record.data.ID == '10'){
			CM_mostrarComponente(comp_sw_mes);
			comp_sw_mes.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
		}
		if (record.data.ID == '11'){
			CM_mostrarComponente(comp_fecha_ini);
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_ini.allowBlank=false;
			comp_fecha_fin.allowBlank=false;
			comp_id_partida.allowBlank=false;
			
			CM_mostrarGrupo('Partida');
		}
		/*if (record.data.ID == '12'){
			CM_mostrarComponente(comp_sw_mes);
			comp_sw_mes.allowBlank=false;
		}
		if (record.data.ID == '13'){
			CM_mostrarComponente(comp_fecha_ini);
			CM_mostrarComponente(comp_fecha_fin);
			comp_fecha_ini.allowBlank=false;
			comp_fecha_fin.allowBlank=false;
			CM_mostrarComponente(comp_sw_nivel);
			comp_sw_nivel.allowBlank=false;
		}*/
		
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
		
		if (comp_sw_ejecuta.getValue() == '9' || comp_sw_ejecuta.getValue() == '11'){
			comp_id_tipo_pres.store.baseParams = {m_id_parametro:comp_id_parametro.getValue(),m_incluir_dobles:'no'};
		}else{
			comp_id_tipo_pres.store.baseParams = {m_id_parametro:comp_id_parametro.getValue(),m_incluir_dobles:'si'};
		}
		comp_id_tipo_pres.modificado=true;
		comp_id_tipo_pres.setValue('');
		
		comp_id_partida.store.baseParams = {sw_vista_reporte:'rep_ejecucion_partida',rep_id_parametro:comp_id_parametro.getValue(),id_tipo_pres:5};
		comp_id_partida.modificado=true;
		comp_id_partida.setValue('');
		
		limpiar_componentes();
		comp_sw_filtro.setValue('');
		comp_desc_gestion.setValue(record.data.gestion_pres);
	}
	
	function f_evento_tipo_pres(combo, record, index){
		limpiar_componentes();
		comp_sw_filtro.setValue('');
		comp_id_partida.setValue('');
		comp_desc_tipo_pres.setValue(record.data.desc_tipo_pres);
		
		comp_id_partida.store.baseParams = {sw_vista_reporte:'rep_ejecucion_partida',rep_id_parametro:comp_id_parametro.getValue(),id_tipo_pres:comp_id_tipo_pres.getValue()};
		comp_id_partida.modificado=true;
		comp_id_partida.setValue('');
	}
	
	function f_evento_ini(comboData){comp_fecha_fin.minValue = comp_fecha_ini.getValue()}
	
	function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}
	
	function f_evento_partida(combo, record, index){comp_desc_partida.setValue(record.data.desc_par)}
	
	function f_evento_sw_filtro(combo, record, index){
		limpiar_componentes();
		
		if (record.data.ID == '1'){
			CM_mostrarGrupo('Presupuesto');
			comp_sw_ppto.allowBlank = false;
		}
		if (record.data.ID == '2'){
			CM_mostrarGrupo('Categoria Programatica');
			comp_sw_cprog.allowBlank = false;
		}
		if (record.data.ID == '3'){
			CM_mostrarGrupo('Estructura Programatica EPE');
			comp_sw_ep_fina.allowBlank = false;
			comp_sw_ep_regi.allowBlank = false;
			comp_sw_ep_prog.allowBlank = false;
			comp_sw_ep_proy.allowBlank = false;
			comp_sw_ep_acti.allowBlank = false;
			comp_sw_ep_uo.allowBlank = false;
			
			if (comp_sw_ejecuta.getValue() == '5' || comp_sw_ejecuta.getValue() == '6' || comp_sw_ejecuta.getValue() == '7' || comp_sw_ejecuta.getValue() == '8'){
				CM_mostrarComponente(comp_sw_eplis);
				comp_sw_eplis.allowBlank = false;
			}
		}
		if (record.data.ID == '4'){
			CM_mostrarGrupo('Categoria Programatica Detallada');
			comp_sw_cp_prog.allowBlank = false;
			comp_sw_cp_proy.allowBlank = false;
			comp_sw_cp_acti.allowBlank = false;
			comp_sw_cp_fuen.allowBlank = false;
			comp_sw_cp_orga.allowBlank = false;
			
			if (comp_sw_ejecuta.getValue() == '5' || comp_sw_ejecuta.getValue() == '6' || comp_sw_ejecuta.getValue() == '7' || comp_sw_ejecuta.getValue() == '8'){
				CM_mostrarComponente(comp_sw_cplis);
				comp_sw_cplis.allowBlank = false;
			}
		}
	}
	
	function f_evento_sw_ppto(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ppto);
			comp_ids_ppto.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ppto);
			comp_ids_ppto.allowBlank = true;
			comp_ids_ppto.setValue('');
		}
		comp_ids_ppto.modificado = true;
		comp_ids_ppto.store.baseParams = {sw_admi:g_admi,sw_listado:'ppto',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	
	function f_evento_sw_cprog(combo, record, index){
		if (record.data.ID == 'seleccion'){
			comp_ids_cprog.allowBlank = false;
			CM_mostrarComponente(comp_ids_cprog);
		}else{
			CM_ocultarComponente(comp_ids_cprog);
			comp_ids_cprog.allowBlank = true;
			comp_ids_cprog.setValue('');
		}
		comp_ids_cprog.modificado = true;
		comp_ids_cprog.store.baseParams = {sw_admi:g_admi,sw_listado:'cprog',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	
	function f_evento_sw_ep_fina(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_fina);
			comp_ids_ep_fina.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_fina);
			comp_ids_ep_fina.allowBlank = true;
			comp_ids_ep_fina.setValue('');
		}
		comp_ids_ep_fina.modificado = true;
		comp_ids_ep_fina.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_fina',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_ep_regi(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_regi);
			comp_ids_ep_regi.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_regi);
			comp_ids_ep_regi.allowBlank = true;
			comp_ids_ep_regi.setValue('');
		}
		comp_ids_ep_regi.modificado = true;
		comp_ids_ep_regi.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_regi',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_ep_prog(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_prog);
			comp_ids_ep_prog.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_prog);
			comp_ids_ep_prog.allowBlank = true;
			comp_ids_ep_prog.setValue('');
		}
		comp_ids_ep_prog.modificado=true;
		comp_ids_ep_prog.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_prog',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_ep_proy(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_proy);
			comp_ids_ep_proy.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_proy);
			comp_ids_ep_proy.allowBlank = true;
			comp_ids_ep_proy.setValue('');
		}
		comp_ids_ep_proy.modificado=true;
		comp_ids_ep_proy.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_proy',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_ep_acti(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_acti);
			comp_ids_ep_acti.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_acti);
			comp_ids_ep_acti.allowBlank = true;
			comp_ids_ep_acti.setValue('');
		}
		comp_ids_ep_acti.modificado=true;
		comp_ids_ep_acti.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_acti',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_ep_uo(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_ep_uo);
			comp_ids_ep_uo.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_ep_uo);
			comp_ids_ep_uo.allowBlank = true;
			comp_ids_ep_uo.setValue('');
		}
		comp_ids_ep_uo.modificado=true;
		comp_ids_ep_uo.store.baseParams = {sw_admi:g_admi,sw_listado:'ep_uo',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	
	function f_evento_sw_cp_prog(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_cp_prog);
			comp_ids_cp_prog.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_cp_prog);
			comp_ids_cp_prog.allowBlank = true;
			comp_ids_cp_prog.setValue('');
		}
		comp_ids_cp_prog.modificado=true;
		comp_ids_cp_prog.store.baseParams = {sw_admi:g_admi,sw_listado:'cp_prog',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_cp_proy(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_cp_proy);
			comp_ids_cp_proy.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_cp_proy);
			comp_ids_cp_proy.allowBlank = true;
			comp_ids_cp_proy.setValue('');
		}
		comp_ids_cp_proy.modificado=true;
		comp_ids_cp_proy.store.baseParams = {sw_admi:g_admi,sw_listado:'cp_proy',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_cp_acti(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_cp_acti);
			comp_ids_cp_acti.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_cp_acti);
			comp_ids_cp_acti.allowBlank = true;
			comp_ids_cp_acti.setValue('');
		}
		comp_ids_cp_acti.modificado=true;
		comp_ids_cp_acti.store.baseParams = {sw_admi:g_admi,sw_listado:'cp_acti',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_cp_fuen(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_cp_fuen);
			comp_ids_cp_fuen.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_cp_fuen);
			comp_ids_cp_fuen.allowBlank = true;
			comp_ids_cp_fuen.setValue('');
		}
		comp_ids_cp_fuen.modificado=true;
		comp_ids_cp_fuen.store.baseParams = {sw_admi:g_admi,sw_listado:'cp_fuen',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	function f_evento_sw_cp_orga(combo, record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(comp_ids_cp_orga);
			comp_ids_cp_orga.allowBlank = false;
		}else{
			CM_ocultarComponente(comp_ids_cp_orga);
			comp_ids_cp_orga.allowBlank = true;
			comp_ids_cp_orga.setValue('');
		}
		comp_ids_cp_orga.modificado=true;
		comp_ids_cp_orga.store.baseParams = {sw_admi:g_admi,sw_listado:'cp_orga',id_parametro:comp_id_parametro.getValue(), id_tipo_pres:comp_id_tipo_pres.getValue()};
	}
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "EJECUCION PRESUPUESTARIA" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :95,
			url :direccion + '../../../control/rep_ejecuta/reporte/ActionPDF_Repeje_Consolida_Jasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 400, 510 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Periodo', columna :0, id_grupo :1},
				{tituloGrupo :'Partida', columna :1, id_grupo :2},
				{tituloGrupo :'Categoria Programatica', columna :1, id_grupo :3},
				{tituloGrupo :'Estructura Programatica EPE', columna :1, id_grupo :4},
				{tituloGrupo :'Categoria Programatica Detallada', columna :1, id_grupo :5},
				{tituloGrupo :'Reporte', columna :0, id_grupo :6},
				{tituloGrupo :'Hidden', columna :0, id_grupo :7},
				{tituloGrupo :'Presupuesto', columna :1, id_grupo :8}
		]}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}