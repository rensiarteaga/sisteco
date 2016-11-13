//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	echo "var vista='$vista';";
	?>
	var paramConfig={TiempoEspera:10000};
	var elemento={pagina:new pagina_eeff_mayor_cta(idContenedor,direccion,paramConfig,vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_eeff_mayor_cta(idContenedor, direccion, paramConfig, vista) {
	var vectorAtributos = new Array;
	var ContPes = 1;
	var layout_eeff_mayor_cta;
	
	var g_tipo_reporte, g_sw_orden;
	
	var var_id_gestion, var_id_depto, var_fecha_inicio, var_fecha_final, var_estado_cbte, var_sw_actualizacion='', var_id_moneda='';
	var var_desc_fecha_inicio='';	
	var var_desc_fecha_final='';
	
	var var_sw_cuenta, var_sw_auxiliar, var_sw_partida, var_sw_epe, var_sw_uo, var_sw_ot;
	
	var var_id_cuenta_inicial, var_id_cuenta_final, var_id_auxiliar_inicial, var_id_auxiliar_final, var_id_partida_inicial, var_id_partida_final;
	var var_id_epe_inicial, var_id_epe_final, var_id_uo_inicial, var_id_uo_final, var_id_ot_inicial, var_id_ot_final;
	
	var comp_id_gestion, comp_id_depto, comp_fecha_inicio, comp_fecha_final, comp_estado_cbte;
	var comp_sw_actualizacion, comp_id_moneda, comp_sw_orden, comp_tipo_reporte, comp_tipo_cambio;
	
	var comp_sw_cuenta, comp_sw_auxiliar, comp_sw_partida, comp_sw_epe, comp_sw_uo, comp_sw_ot;
	
	var comp_id_cuenta_inicial, comp_id_cuenta_final, comp_id_cuenta_multiple;
	var comp_id_auxiliar_inicial, comp_id_auxiliar_final, comp_id_auxiliar_multiple;
	var comp_id_partida_inicial, comp_id_partida_final, comp_id_partida_multiple;
	var comp_id_epe_inicial, comp_id_epe_final, comp_id_epe_multiple;
	var comp_id_uo_inicial, comp_id_uo_final, comp_id_uo_multiple;
	var comp_id_ot_inicial, comp_id_ot_final, comp_id_ot_multiple;
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'no'}
	});
	
	var ds_componente_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componente_auxiliar=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});
	
	var ds_componente_partida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componente_epe=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componente_uo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	var ds_componente_ot=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});

	ds_depto.load();
	var data_deptos=new Array();
	var indice=0;
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_componente_cuenta(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_cuenta=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	function render_componente_auxiliar(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_auxiliar=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_componente_partida(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_partida=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');

	function render_componente_epe(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_epe=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_componente_uo(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_uo=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 
	function render_componente_ot(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_ot=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
	
	function render_tipo(value, p, record)
	{	if(value=='rango'){return 'RANGO';}
		if(value=='detalle'){return 'DETALLE';}
		if(value=='cabecera'){return 'CABECERA';}
		if(value=='ninguno'){return 'NINGUNO';}
	}
	
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
		filterColValue:'PARAMP.gestion_conta',
		save_as:'id_parametro'
	};
	
	vectorAtributos[1] = {
		validacion : {
			name :'fecha_inicio',
			fieldLabel :'Fecha Inicial',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_inicio',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[2] = {
		validacion : {
			name :'fecha_final',
			fieldLabel :'Fecha Final',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_final',
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
			name:'sw_actualizacion',
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
		save_as:'sw_actualizacion'
	};
	
	vectorAtributos[7]={
		validacion:{
			name:'estado_cbte',
			fieldLabel:'Cbtes.',
			allowBlank:false,
			align:'left',
			emptyText:'...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','VALIDADO'],['2','BORRADOR'],['3','EDICION']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width_grid:200,
			minListWidth:100,
			width:100,
			disabled:false
		},
		tipo:'ComboBox',
		defecto:1,
		form: true,
		save_as:'estado_cbte'
	};	
	
	vectorAtributos[8]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Depto.',
			allowBlank:false,
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:false,
			mode:'remote',
			queryDelay:380,
			pageSize:10,
			minListWidth:380,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:false,
			width_grid:220,
			width:380,
			disabled:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_depto',
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'sw_cuenta',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:1,
		form: true,
		save_as:'sw_cuenta'
	};
	
	vectorAtributos[10]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'Cuenta Inicial...',
			name:'id_cuenta_inicial',
			desc:'nombre',
			store:ds_componente_cuenta,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_cuenta,
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
			renderer:render_componente_cuenta,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:1,
		filtro_0:false,
 		form: true,
 		save_as:'id_cuenta_inicial'
	};	
	
	vectorAtributos[11]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'Cuenta final...',
			name:'id_cuenta_final',
			desc:'nombre',
			store:ds_componente_cuenta,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_cuenta,
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
			renderer:render_componente_cuenta,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:1,
		filtro_0:false,
		form: true,
		save_as:'id_cuenta_final'
	};	

	vectorAtributos[12]={
		validacion:{
			name:'id_cuenta_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_cuenta,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_cuenta,				
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
			renderer:render_componente_cuenta,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:1,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[13]={
		validacion:{
			name:'sw_auxiliar',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:3,
		form: true,
		save_as:'sw_auxiliar'
	};
	
	vectorAtributos[14]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'Auxiliar Inicial...',
			name:'id_auxiliar_inicial',
			desc:'nombre',
			store:ds_componente_auxiliar,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_auxiliar,
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
			renderer:render_componente_auxiliar,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:3,
		filtro_0:false,
 		form: true,
 		save_as:'id_auxiliar_inicial'
	};	
	
	vectorAtributos[15]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'Auxliar final...',
			name:'id_auxiliar_final',
			desc:'nombre',
			store:ds_componente_auxiliar,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_auxiliar,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_auxiliar,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:3,
		filtro_0:false,
 		form: true,
 		save_as:'id_auxiliar_final'
	};
	
	vectorAtributos[16]={
		validacion:{
			name:'id_auxiliar_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_auxiliar,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_auxiliar,				
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
			renderer:render_componente_auxiliar,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:3,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[17]={
		validacion:{
			name:'sw_partida',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:2,
		form: true,
		save_as:'sw_partida'
	};
	
	vectorAtributos[18]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'Partida Inicial...',
			name:'id_partida_inicial',
			desc:'nombre',
			store:ds_componente_partida,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_partida,
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
			renderer:render_componente_partida,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:2,
		filtro_0:false,
 		form: true,
 		save_as:'id_partida_inicial'
	};	
	
	vectorAtributos[19]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'Partida final...',
			name:'id_partida_final',
			desc:'nombre',
			store:ds_componente_partida,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_partida,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_componente_partida,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:2,
		filtro_0:false,
 		form: true,
 		save_as:'id_partida_final'
	};
	
	vectorAtributos[20]={
		validacion:{
			name:'id_partida_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_partida,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_partida,				
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
			renderer:render_componente_partida,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:2,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[21]={
		validacion:{
			name:'sw_epe',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:4,
		form: true,
		save_as:'sw_epe'
	};
	
	vectorAtributos[22]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'EPE Inicial...',
			name:'id_epe_inicial',
			desc:'nombre',
			store:ds_componente_epe,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_epe,
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
			renderer:render_componente_epe,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:4,
		filtro_0:false,
 		form: true,
 		save_as:'id_epe_inicial'
	};	
	
	vectorAtributos[23]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'EPE final...',
			name:'id_epe_final',
			desc:'nombre',
			store:ds_componente_epe,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_epe,
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
			renderer:render_componente_epe,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:4,
		filtro_0:false,
 		form: true,
 		save_as:'id_epe_final'
	};	
	
	vectorAtributos[24]={
		validacion:{
			name:'id_epe_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_epe,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_epe,				
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
			renderer:render_componente_epe,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:4,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[25]={
		validacion:{
			name:'sw_uo',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:5,
		form: true,
		save_as:'sw_uo'
	};
	
	vectorAtributos[26]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'UO Inicial...',
			name:'id_uo_inicial',
			desc:'nombre',
			store:ds_componente_uo,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_uo,
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
			renderer:render_componente_uo,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:5,
		filtro_0:false,
 		form: true,
 		save_as:'id_uo_inicial'
	};	
	
	vectorAtributos[27]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'UO final...',
			name:'id_uo_final',
			desc:'nombre',
			store:ds_componente_uo,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_uo,
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
			renderer:render_componente_uo,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:5,
		filtro_0:false,
 		form: true,
 		save_as:'id_uo_final'
	};
	
	vectorAtributos[28]={
		validacion:{
			name:'id_uo_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_uo,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_uo,				
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
			renderer:render_componente_uo,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:5,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[29]={
		validacion:{
			name:'sw_ot',
			fieldLabel:'Opción',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['cabecera','CABECERA'],['rango','RANGO'],['multiple','MULTIPLE'],['detalle','DETALLE'],['multideta','DETALLE MULTIPLE'],['ninguno','NINGUNO']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width:150,
			minListWidth:100,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:6,
		form: true,
		save_as:'sw_ot'
	};
	
	vectorAtributos[30]={
		validacion:{
			fieldLabel:'Inicial:',
			allowBlank:true,
			emptyText:'OT Inicial...',
			name:'id_ot_inicial',
			desc:'nombre',
			store:ds_componente_ot,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_ot,
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
			renderer:render_componente_ot,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:6,
		filtro_0:false,
 		form: true,
 		save_as:'id_ot_inicial'
	};	
	
	vectorAtributos[31]={
		validacion:{
			fieldLabel:'Final:',
			allowBlank:true,
			emptyText:'OT final...',
			name:'id_ot_final',
			desc:'nombre',
			store:ds_componente_ot,
			valueField:'id_maydat',
			displayField:'codigo_nombre',
			queryParam:'filterValue_0',
			filterCol:'codigo#nombre',
			tpl:tpl_componente_ot,
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
			renderer:render_componente_ot,
			grid_visible:false,
			grid_editable:false,
			width:380,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		id_grupo:6,
		filtro_0:false,
 		form: true,
 		save_as:'id_ot_final'
	};
	
	vectorAtributos[32]={
		validacion:{
			name:'id_ot_multiple',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_componente_ot,	
			maestroValField:'codigo_nombre',
			valueField: 'id_maydat',			
			queryParam: 'filterValue_0',
			filterCol:'codigo#nombre',
			typeAhead:false,
			tpl:tpl_componente_uo,				
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
			renderer:render_componente_ot,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:380,
		    width_grid:150
		},
		tipo:'ComboMultiple2',
		id_grupo:6,
		filtro_0:false,
 		form: true
	};
	
	vectorAtributos[33]={
		validacion:{
			name:'sw_orden',
			fieldLabel:'Orden',
			vtype:'texto',
			emptyText:'Orden...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['A','CtaParAux - EpUoOt'],['B','EpUoOt - CtaParAux']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:250
		},
		tipo:'ComboBox',
		id_grupo:7,
		save_as:'sw_orden'
	};
	
	if(vista=='mayor' || vista=='mayor_tc'){
		vectorAtributos[34]={
			validacion:{
				name:'tipo_reporte',
				fieldLabel:'Formato',
				vtype:'texto',
				emptyText:'Formato...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf1','PDF - Detallado Contable'],['pdf2','PDF - Simple Contable'],
				                                                            ['pdf3','PDF - Detallado Contable/Presupuestario'],['pdf4','PDF - Simple Contable/Presupuestario'],
				                                                            ['pdf5','PDF - Detallado Presupuestario'],['pdf6','PDF - Simple Presupuestario'],
				                                                            ['pdf7','PDF - Simple Contable s/Fecha n/Página'],['xls','Excel']]}),
				valueField:'ID',
				displayField:'valor',
				forceSelection:true,
				width:250
			},
			tipo:'ComboBox',
			id_grupo:7,
			save_as:'tipo_reporte'
		};
	}else{
		vectorAtributos[34]={
			validacion:{
				name:'tipo_reporte',
				fieldLabel:'Formato',
				vtype:'texto',
				emptyText:'Formato...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf1','PDF - Contable'],['pdf2','PDF - Presupuestario'],
				                                                            ['pdf3','PDF - Contable/Presupuestario'],['xls','Excel']]}),
				valueField:'ID',
				displayField:'valor',
				forceSelection:true,
				width:250
			},
			tipo:'ComboBox',
			id_grupo:7,
			save_as:'tipo_reporte'
		};
	}
	
	vectorAtributos[35]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Página Inicial',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			allowMil:true,
			minValue:0,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		id_grupo:7,
		save_as:'tipo_cambio'
	};
		
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_eeff_mayor_cta = new DocsLayoutProceso(idContenedor);
	layout_eeff_mayor_cta.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_eeff_mayor_cta, idContenedor);
	
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
		comp_id_gestion=ClaseMadre_getComponente('id_parametro');
		comp_id_depto=ClaseMadre_getComponente('id_depto');
		comp_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		comp_fecha_final=ClaseMadre_getComponente('fecha_final');
		comp_estado_cbte=ClaseMadre_getComponente('estado_cbte');
		comp_sw_actualizacion=ClaseMadre_getComponente('sw_actualizacion');
		comp_id_moneda=ClaseMadre_getComponente('id_moneda');
		comp_tipo_cambio=ClaseMadre_getComponente('tipo_cambio');
		
		comp_sw_cuenta=ClaseMadre_getComponente('sw_cuenta');
		comp_sw_auxiliar=ClaseMadre_getComponente('sw_auxiliar');
		comp_sw_partida=ClaseMadre_getComponente('sw_partida');
		comp_sw_epe=ClaseMadre_getComponente('sw_epe');
		comp_sw_uo=ClaseMadre_getComponente('sw_uo');
		comp_sw_ot=ClaseMadre_getComponente('sw_ot');
		
		comp_id_cuenta_inicial=ClaseMadre_getComponente('id_cuenta_inicial');
		comp_id_cuenta_final=ClaseMadre_getComponente('id_cuenta_final');
		comp_id_cuenta_multiple=ClaseMadre_getComponente('id_cuenta_multiple');
		
		comp_id_auxiliar_inicial=ClaseMadre_getComponente('id_auxiliar_inicial');
		comp_id_auxiliar_final=ClaseMadre_getComponente('id_auxiliar_final');
		comp_id_auxiliar_multiple=ClaseMadre_getComponente('id_auxiliar_multiple');
		
		comp_id_partida_inicial=ClaseMadre_getComponente('id_partida_inicial');
		comp_id_partida_final=ClaseMadre_getComponente('id_partida_final');
		comp_id_partida_multiple=ClaseMadre_getComponente('id_partida_multiple');
		
		comp_id_epe_inicial=ClaseMadre_getComponente('id_epe_inicial');
		comp_id_epe_final=ClaseMadre_getComponente('id_epe_final');
		comp_id_epe_multiple=ClaseMadre_getComponente('id_epe_multiple');
	
		comp_id_uo_inicial=ClaseMadre_getComponente('id_uo_inicial');
		comp_id_uo_final=ClaseMadre_getComponente('id_uo_final');
		comp_id_uo_multiple=ClaseMadre_getComponente('id_uo_multiple');
		
		comp_id_ot_inicial=ClaseMadre_getComponente('id_ot_inicial');
		comp_id_ot_final=ClaseMadre_getComponente('id_ot_final');
		comp_id_ot_multiple=ClaseMadre_getComponente('id_ot_multiple');
		
		comp_sw_orden=ClaseMadre_getComponente('sw_orden');
		comp_tipo_reporte=ClaseMadre_getComponente('tipo_reporte');
		
		comp_id_gestion.on('select',f_almacenar_gestion);	
		comp_id_depto.on('select',f_almacenar_depto);	
		comp_fecha_inicio.on('blur',f_almacenar_inicio);
		comp_fecha_final.on('blur',f_almacenar_final);	
		comp_estado_cbte.on('select',f_almacenar_estado_cbte);	
		comp_sw_actualizacion.on('select',f_almacenar_sw_actualizacion);	
		comp_id_moneda.on('select',f_almacenar_id_moneda);	
				
		comp_sw_cuenta.on('select',f_almacenar_sw_cuenta);	
		comp_id_cuenta_inicial.on('select',f_almacenar_cuenta_inicial);	
		comp_id_cuenta_final.on('select',f_almacenar_cuenta_final);	
		
		comp_sw_auxiliar.on('select',f_almacenar_sw_auxiliar);	
		comp_id_auxiliar_inicial.on('select',f_almacenar_auxiliar_inicial);	
		comp_id_auxiliar_final.on('select',f_almacenar_auxiliar_final);
		
		comp_sw_partida.on('select',f_almacenar_sw_partida);	
		comp_id_partida_inicial.on('select',f_almacenar_partida_inicial);	
		comp_id_partida_final.on('select',f_almacenar_partida_final);	
		
		comp_sw_epe.on('select',f_almacenar_sw_epe);	
		comp_id_epe_inicial.on('select',f_almacenar_epe_inicial);	
		comp_id_epe_final.on('select',f_almacenar_epe_final);	
		
		comp_sw_uo.on('select',f_almacenar_sw_uo);	
		comp_id_uo_inicial.on('select',f_almacenar_uo_inicial);	
		comp_id_uo_final.on('select',f_almacenar_uo_final);	
		
		comp_sw_ot.on('select',f_almacenar_sw_ot);	
		comp_id_ot_inicial.on('select',f_almacenar_ot_inicial);	
		comp_id_ot_final.on('select',f_almacenar_ot_final);

		comp_tipo_reporte.on('select',f_almacenar_tipo_reporte);
		
		CM_ocultarComponente(comp_tipo_cambio);
		comp_tipo_cambio.allowBlank=true;
		
		if(vista=='mayor_tc'){
			CM_ocultarComponente(comp_id_moneda);
			CM_ocultarComponente(comp_estado_cbte);
			CM_ocultarComponente(comp_sw_actualizacion);
			CM_mostrarComponente(comp_tipo_cambio);
			
			comp_id_moneda.setValue('10');
			comp_estado_cbte.setValue('1');
			comp_sw_actualizacion.setValue('si');
			comp_tipo_cambio.setValue('');
			comp_tipo_cambio.allowBlank=false;
			var_id_moneda=10;
			var_desc_moneda='Dólares Americanos';
			var_estado_cbte='1';	
			var_sw_actualizacion='si';
		}
		
		limpiar_componentes();
	}
	function f_almacenar_tipo_reporte( combo, record, index ){
		g_tipo_reporte=record.data.ID;
		if(g_tipo_reporte=='pdf7'){
			CM_mostrarComponente(comp_tipo_cambio);
			comp_tipo_cambio.setValue('');
			comp_tipo_cambio.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_tipo_cambio);
			comp_tipo_cambio.setValue('');
			comp_tipo_cambio.allowBlank=true;
		}
	}
	function limpiar_componentes(){
		comp_sw_cuenta.setValue('');
		comp_sw_auxiliar.setValue('');
		comp_sw_partida.setValue('');
		comp_sw_epe.setValue('');
		comp_sw_uo.setValue('');
		comp_sw_ot.setValue('');
		
	 	CM_ocultarComponente(comp_id_cuenta_inicial);
	 	comp_id_cuenta_inicial.allowBlank=true;
		comp_id_cuenta_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_cuenta_final);
		comp_id_cuenta_final.allowBlank=true;
		comp_id_cuenta_final.setValue('');
		
		CM_ocultarComponente(comp_id_cuenta_multiple);
		comp_id_cuenta_multiple.allowBlank=true;
		comp_id_cuenta_multiple.setValue('');
		
		CM_ocultarComponente(comp_id_auxiliar_inicial);
		comp_id_auxiliar_inicial.allowBlank=true;
		comp_id_auxiliar_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_auxiliar_final);
		comp_id_auxiliar_final.allowBlank=true;
		comp_id_auxiliar_final.setValue('');
		
		CM_ocultarComponente(comp_id_auxiliar_multiple);
		comp_id_auxiliar_multiple.allowBlank=true;
		comp_id_auxiliar_multiple.setValue('');
		
		CM_ocultarComponente(comp_id_partida_inicial);
		comp_id_partida_inicial.allowBlank=true;
		comp_id_partida_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_partida_final);
		comp_id_partida_final.allowBlank=true;
		comp_id_partida_final.setValue('');
		
		CM_ocultarComponente(comp_id_partida_multiple);
		comp_id_partida_multiple.allowBlank=true;
		comp_id_partida_multiple.setValue('');
		
		CM_ocultarComponente(comp_id_epe_inicial);
		comp_id_epe_inicial.allowBlank=true;
		comp_id_epe_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_epe_final);
		comp_id_epe_final.allowBlank=true;
		comp_id_epe_final.setValue('');
		
		CM_ocultarComponente(comp_id_epe_multiple);
		comp_id_epe_multiple.allowBlank=true;
		comp_id_epe_multiple.setValue('');
		
		CM_ocultarComponente(comp_id_uo_inicial);
		comp_id_uo_inicial.allowBlank=true;
		comp_id_uo_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_uo_final);
		comp_id_uo_final.allowBlank=true;
		comp_id_uo_final.setValue('');
		
		CM_ocultarComponente(comp_id_uo_multiple);
		comp_id_uo_multiple.allowBlank=true;
		comp_id_uo_multiple.setValue('');
		
		CM_ocultarComponente(comp_id_ot_inicial);
		comp_id_ot_inicial.allowBlank=true;
		comp_id_ot_inicial.setValue('');
		
		CM_ocultarComponente(comp_id_ot_final);
		comp_id_ot_final.allowBlank=true;
		comp_id_ot_final.setValue('');
		
		CM_ocultarComponente(comp_id_ot_multiple);
		comp_id_ot_multiple.allowBlank=true;
		comp_id_ot_multiple.setValue('');
		
		var_sw_cuenta='';
		var_sw_auxiliar='';
		var_sw_partida='';
		var_sw_epe='';
		var_sw_uo='';
		var_sw_ot='';
		var_id_cuenta_inicial='';
		var_id_cuenta_final='';
		var_id_auxiliar_inicial='';
		var_id_auxiliar_final='';
		var_id_partida_inicial='';
		var_id_partida_final='';
		var_id_epe_inicial='';
		var_id_epe_final='';
		var_id_uo_inicial='';
		var_id_uo_final='';
		var_id_ot_inicial='';
		var_id_ot_final=''; 
	}
	
	function f_almacenar_gestion( combo, record, index ){
		var_id_gestion=record.data.id_gestion;
		var_desc_id_gestion=record.data.gestion_conta;
		
		var intGestion=record.data.gestion_conta;
		var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
		var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
			
		//Aplica la validación en la fecha
		comp_fecha_inicio.minValue=dte_fecha_ini_valid;
		comp_fecha_inicio.maxValue=dte_fecha_fin_valid;
		comp_fecha_final.minValue=dte_fecha_ini_valid;
		comp_fecha_final.maxValue=dte_fecha_fin_valid;
			
		//Define un valor por defecto
		comp_fecha_inicio.setValue(dte_fecha_ini_valid);
		comp_fecha_final.setValue(dte_fecha_fin_valid);	
		
		var fecha =comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('m/d/Y'):'';
		var_fecha_inicio=fecha;
		var_desc_fecha_inicio=comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('d/m/Y'):'';
		
		fecha =comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('m/d/Y'):'';
		var_fecha_final=fecha;
		var_desc_fecha_final=comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('d/m/Y'):'';
		
		limpiar_componentes();
	}
	
	function f_almacenar_depto( combo, record, index ){
		var_id_depto=record.data.id_depto;
		var_desc_depto=record.data.nombre_depto;
		limpiar_componentes();	
	}
	
	function f_almacenar_inicio(comboData){
		var fecha =comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('m/d/Y'):'';
		var_fecha_inicio=fecha;
		var_desc_fecha_inicio=comp_fecha_inicio.getValue()?comp_fecha_inicio.getValue().dateFormat('d/m/Y'):'';
		var fecha_inicio_val = comp_fecha_inicio.getValue();
		comp_fecha_final.minValue = fecha_inicio_val;	
		limpiar_componentes();
	}
	
	function f_almacenar_final(comboData){
		var fecha =comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('m/d/Y'):'';
		var_fecha_final=fecha;
		var_desc_fecha_final=comp_fecha_final.getValue()?comp_fecha_final.getValue().dateFormat('d/m/Y'):'';
		limpiar_componentes();
	}
	
	function f_almacenar_estado_cbte( combo, record, index ){
		var_estado_cbte=record.data.ID;	
		var_desc_estado_cbte=record.data.ID;
		limpiar_componentes();
	}
	function f_almacenar_sw_actualizacion( combo, record, index ){
		var_sw_actualizacion=record.data.ID;
		var_desc_sw_actualizacion=record.data.ID;
		limpiar_componentes();	
	}
	
	function f_almacenar_id_moneda( combo, record, index ){
		var_id_moneda=record.data.id_moneda;
		var_desc_moneda=record.data.simbolo;
		limpiar_componentes();
	}
	
	function f_almacenar_sw_cuenta( combo, record, index ){
		var_sw_cuenta=record.data.ID;
		var_desc_sw_cuenta=record.data.ID;
		var_desc_id_cuenta_inicial='';
		var_desc_id_cuenta_final='';
		
		comp_id_cuenta_multiple.allowBlank=true;
		comp_id_cuenta_multiple.setValue('');
		CM_ocultarComponente(comp_id_cuenta_multiple);
		
		if(var_sw_cuenta=='rango'){
			 comp_id_cuenta_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'cuenta',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_cuenta_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_cuenta_inicial);
			CM_mostrarComponente(comp_id_cuenta_final);
			comp_id_cuenta_inicial.allowBlank=false;
			comp_id_cuenta_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_cuenta_inicial);
			CM_ocultarComponente(comp_id_cuenta_final);
			comp_id_cuenta_inicial.allowBlank=true;
			comp_id_cuenta_final.allowBlank=true;
			comp_id_cuenta_inicial.setValue('');
			var_id_cuenta_inicial='';
			comp_id_cuenta_final.setValue('');
			var_id_cuenta_final='';
			
			if(var_sw_cuenta=='multiple' || var_sw_cuenta=='multideta'){
				comp_id_cuenta_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'cuenta',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_cuenta_multiple.modificado=true;
				CM_mostrarComponente(comp_id_cuenta_multiple);
				comp_id_cuenta_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_sw_auxiliar( combo, record, index ){
		var_sw_auxiliar=record.data.ID;
		var_desc_sw_auxiliar=record.data.ID;
		var_desc_id_auxiliar_inicial='';
		var_desc_id_auxiliar_final='';
		
		comp_id_auxiliar_multiple.allowBlank=true;
		comp_id_auxiliar_multiple.setValue('');
		CM_ocultarComponente(comp_id_auxiliar_multiple);
		
		if(var_sw_auxiliar=='rango'){
			 comp_id_auxiliar_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'auxiliar',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_auxiliar_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_auxiliar_inicial);
			CM_mostrarComponente(comp_id_auxiliar_final);
			comp_id_auxiliar_inicial.allowBlank=false;
			comp_id_auxiliar_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_auxiliar_inicial);
			CM_ocultarComponente(comp_id_auxiliar_final);
			comp_id_auxiliar_inicial.allowBlank=true;
			comp_id_auxiliar_final.allowBlank=true;
			comp_id_auxiliar_inicial.setValue('');
			var_id_auxiliar_inicial='';
			comp_id_auxiliar_final.setValue('');
			var_id_auxiliar_final='';
			
			if(var_sw_auxiliar=='multiple' || var_sw_auxiliar=='multideta'){
				comp_id_auxiliar_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'auxiliar',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_auxiliar_multiple.modificado=true;
				CM_mostrarComponente(comp_id_auxiliar_multiple);
				comp_id_auxiliar_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_sw_partida( combo, record, index ){
		var_sw_partida=record.data.ID;
		var_desc_sw_partida=record.data.ID;
		var_desc_id_partida_inicial='';
		var_desc_id_partida_final='';
		
		comp_id_partida_multiple.allowBlank=true;
		comp_id_partida_multiple.setValue('');
		CM_ocultarComponente(comp_id_partida_multiple);
		
		if(var_sw_partida=='rango'){
			 comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'partida',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_partida_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_partida_inicial);
			CM_mostrarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=false;
			comp_id_partida_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_partida_inicial);
			CM_ocultarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=true;
			comp_id_partida_final.allowBlank=true;
			comp_id_partida_inicial.setValue('');
			var_id_partida_inicial='';
			comp_id_partida_final.setValue('');
			var_id_partida_final='';
			
			if(var_sw_partida=='multiple' || var_sw_partida=='multideta'){
				comp_id_partida_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'partida',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_partida_multiple.modificado=true;
				CM_mostrarComponente(comp_id_partida_multiple);
				comp_id_partida_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_sw_epe( combo, record, index ){
		var_sw_epe=record.data.ID;
		var_desc_sw_epe=record.data.ID;
		var_desc_id_epe_inicial='';
		var_desc_id_epe_final='';
		
		comp_id_epe_multiple.allowBlank=true;
		comp_id_epe_multiple.setValue('');
		CM_ocultarComponente(comp_id_epe_multiple);
		
		if(var_sw_epe=='rango'){
			comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'epe',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_epe_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_epe_inicial);
			CM_mostrarComponente(comp_id_epe_final);
			CM_ocultarComponente(comp_id_epe_multiple);
			comp_id_epe_inicial.allowBlank=false;
			comp_id_epe_final.allowBlank=false;	
		}else{
			CM_ocultarComponente(comp_id_epe_inicial);
			CM_ocultarComponente(comp_id_epe_final);
			comp_id_epe_inicial.allowBlank=true;
			comp_id_epe_final.allowBlank=true;
			comp_id_epe_inicial.setValue('');
			var_id_epe_inicial='';
			comp_id_epe_final.setValue('');
			var_id_epe_final='';
			
			if(var_sw_epe=='multiple' || var_sw_epe=='multideta'){
				comp_id_epe_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'epe',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_epe_multiple.modificado=true;
				CM_mostrarComponente(comp_id_epe_multiple);
				comp_id_epe_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_sw_uo( combo, record, index ){
		var_sw_uo=record.data.ID;
		var_desc_sw_uo=record.data.ID;
		var_desc_id_uo_inicial='';
		var_desc_id_uo_final='';
		
		comp_id_uo_multiple.allowBlank=true;
		comp_id_uo_multiple.setValue('');
		CM_ocultarComponente(comp_id_uo_multiple);
		
		if(var_sw_uo=='rango'){
			comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'uo',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_uo_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_uo_inicial);
			CM_mostrarComponente(comp_id_uo_final);
			CM_ocultarComponente(comp_id_uo_multiple);
			comp_id_uo_inicial.allowBlank=false;
			comp_id_uo_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_uo_inicial);
			CM_ocultarComponente(comp_id_uo_final);
			comp_id_uo_inicial.allowBlank=true;
			comp_id_uo_final.allowBlank=true;
			comp_id_uo_inicial.setValue('');
			var_id_uo_inicial='';
			comp_id_uo_final.setValue('');
			var_id_uo_final='';
			
			if(var_sw_uo=='multiple' || var_sw_uo=='multideta'){
				comp_id_uo_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'uo',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_uo_multiple.modificado=true;
				CM_mostrarComponente(comp_id_uo_multiple);
				comp_id_uo_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_sw_ot( combo, record, index ){
		var_sw_ot=record.data.ID;
		var_desc_sw_ot=record.data.ID;
		var_desc_id_ot_inicial='';
		var_desc_id_ot_final='';
		
		comp_id_ot_multiple.allowBlank=true;
		comp_id_ot_multiple.setValue('');
		CM_ocultarComponente(comp_id_ot_multiple);

		if(var_sw_ot=='rango'){
			comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
					 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
					 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
					 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'ot',
					 
					 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
					 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
					 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
					 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		 	comp_id_ot_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_ot_inicial);
			CM_mostrarComponente(comp_id_ot_final);
			CM_ocultarComponente(comp_id_ot_multiple);
			comp_id_ot_inicial.allowBlank=false;
			comp_id_ot_final.allowBlank=false;
		}else{
			CM_ocultarComponente(comp_id_ot_inicial);
			CM_ocultarComponente(comp_id_ot_final);
			comp_id_ot_inicial.setValue('');
			comp_id_ot_inicial.allowBlank=true;
			comp_id_ot_final.allowBlank=true;
			var_id_ot_inicial='';
			comp_id_ot_final.setValue('');
			var_id_ot_final='';
			
			if(var_sw_ot=='multiple' || var_sw_ot=='multideta'){
				comp_id_ot_multiple.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
						 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
						 
						 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
						 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
						 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
						 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'ot',
						 
						 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
						 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
						 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
						 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
						 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
						 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
				comp_id_ot_multiple.modificado=true;
				CM_mostrarComponente(comp_id_ot_multiple);
				comp_id_ot_multiple.allowBlank=false;
			}
		}
	}
	
	function f_almacenar_cuenta_inicial( combo, record, index ){
		var_id_cuenta_inicial=record.data.id_maydat;
		var_desc_id_cuenta_inicial=record.data.codigo_nombre;
		
		comp_id_cuenta_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'cuenta',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, 
				 //id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_cuenta_final.modificado=true;
	}
	
	function f_almacenar_cuenta_final( combo, record, index ){
		var_id_cuenta_final=record.data.id_maydat;
		var_desc_id_cuenta_final=record.data.codigo_nombre;
		
		comp_id_cuenta_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'cuenta',
				 
				 //id_cuenta_inicial:var_id_cuenta_inicial, 
				 id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_cuenta_inicial.modificado=true;
	}

	function f_almacenar_auxiliar_inicial( combo, record, index ){
		var_id_auxiliar_inicial=record.data.id_maydat;
		var_desc_id_auxiliar_inicial=record.data.codigo_nombre;
		
		comp_id_auxiliar_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'auxiliar',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, 
				 //id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_auxiliar_final.modificado=true;
	}
	
	function f_almacenar_auxiliar_final( combo, record, index ){
		var_id_auxiliar_final=record.data.id_maydat;
		var_desc_id_auxiliar_final=record.data.codigo_nombre; 
		
		comp_id_auxiliar_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'auxiliar',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 //id_auxiliar_inicial:var_id_auxiliar_inicial, 
				 id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_auxiliar_inicial.modificado=true;
	}
	
	function f_almacenar_partida_inicial( combo, record, index ){
		var_id_partida_inicial=record.data.id_maydat;
		var_desc_id_partida_inicial=record.data.codigo_nombre;
		
		comp_id_partida_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'partida',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, 
				 //id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_partida_final.modificado=true;
	}
	
	function f_almacenar_partida_final( combo, record, index ){
		var_id_partida_final=record.data.id_maydat;
		var_desc_id_partida_final=record.data.codigo_nombre; 
		
		comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'partida',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 //id_partida_inicial:var_id_partida_inicial, 
				 id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_partida_inicial.modificado=true;
	}
	
	function f_almacenar_epe_inicial( combo, record, index ){
		var_id_epe_inicial=record.data.id_maydat;	
		var_desc_id_epe_inicial=record.data.codigo_nombre;
		
		comp_id_epe_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'epe',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial,
				 //id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_epe_final.modificado=true;
	}
	
	function f_almacenar_epe_final( combo, record, index ){
		var_id_epe_final=record.data.id_maydat;
		var_desc_id_epe_final=record.data.codigo_nombre;
		
		comp_id_epe_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'epe',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 //id_epe_inicial:var_id_epe_inicial,
				 id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_epe_inicial.modificado=true;
	}

	function f_almacenar_uo_inicial( combo, record, index ){
		var_id_uo_inicial=record.data.id_maydat;
		var_desc_id_uo_inicial=record.data.codigo_nombre;
		
		comp_id_uo_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'uo',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, 
				 //id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_uo_final.modificado=true;
	}
	
	function f_almacenar_uo_final( combo, record, index ){
		var_id_uo_final=record.data.id_maydat;
		var_desc_id_uo_final=record.data.codigo_nombre;
		
		comp_id_uo_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'uo',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 //id_uo_inicial:var_id_uo_inicial, 
				 id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, id_ot_final:var_id_ot_final};
		comp_id_uo_inicial.modificado=true;
	}

	function f_almacenar_ot_inicial( combo, record, index ){
		var_id_ot_inicial=record.data.id_maydat;
		var_desc_id_ot_inicial=record.data.codigo_nombre;
		
		comp_id_ot_final.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'ot',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 id_ot_inicial:var_id_ot_inicial, 
				 //id_ot_final:var_id_ot_final
				 };
		comp_id_ot_final.modificado=true;
	}
	
	function f_almacenar_ot_final( combo, record, index ){
		var_id_ot_final=record.data.id_maydat;	
		var_desc_id_ot_final=record.data.codigo_nombre;
		
		comp_id_ot_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				 sw_cuenta:var_sw_cuenta, sw_auxiliar:var_sw_auxiliar,
				 sw_partida:var_sw_partida, sw_epe:var_sw_epe,
				 sw_uo:var_sw_uo, sw_ot:var_sw_ot,
				 sw_estado_cbte:var_estado_cbte, sw_actualizacion:var_sw_actualizacion, sw_listado:'ot',
				 
				 id_cuenta_inicial:var_id_cuenta_inicial, id_cuenta_final:var_id_cuenta_final,
				 id_auxiliar_inicial:var_id_auxiliar_inicial, id_auxiliar_final:var_id_auxiliar_final,
				 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
				 id_epe_inicial:var_id_epe_inicial, id_epe_final:var_id_epe_final,
				 id_uo_inicial:var_id_uo_inicial, id_uo_final:var_id_uo_final,
				 //id_ot_inicial:var_id_ot_inicial, 
				 id_ot_final:var_id_ot_final};
		comp_id_ot_inicial.modificado=true;
	}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "LIBRO MAYOR DE CUENTAS" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../control/eeff/ActionListarEEFFConsolidado.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 490, 490 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Cuenta', columna :0, id_grupo :1},
				{tituloGrupo :'Partida', columna :0, id_grupo :2},
				{tituloGrupo :'Auxiliar', columna :0, id_grupo :3},
				{tituloGrupo :'E.P.E.', columna :1, id_grupo :4},
				{tituloGrupo :'U.O.', columna :1, id_grupo :5},
				{tituloGrupo :'O.T.', columna :1, id_grupo :6},
				{tituloGrupo :'Reporte', columna :1, id_grupo :7},
				],
			submit:function (){
				g_tipo_reporte = comp_tipo_reporte.getValue();
				g_sw_orden = comp_sw_orden.getValue();
				
				var_ids_cuenta = comp_id_cuenta_multiple.getValue();
				var_ids_partida = comp_id_partida_multiple.getValue();
				var_ids_auxiliar = comp_id_auxiliar_multiple.getValue();
				var_ids_epe = comp_id_epe_multiple.getValue();
				var_ids_uo = comp_id_uo_multiple.getValue();
				var_ids_ot = comp_id_ot_multiple.getValue();
				var_tipo_cambio = comp_tipo_cambio.getValue();
				
				var data='id_gestion='+var_id_gestion;
				 data+='&id_depto='+var_id_depto;
				 
				 data+='&fecha_inicio='+var_fecha_inicio;
				 data+='&fecha_final='+var_fecha_final;
				 data+='&fecha_inicio_rep='+var_desc_fecha_inicio;
				 data+='&fecha_final_rep='+var_desc_fecha_final;
				 
				 data+='&sw_cuenta='+var_sw_cuenta;
				 data+='&sw_auxiliar='+var_sw_auxiliar;
				 data+='&sw_partida='+var_sw_partida;
				 data+='&sw_epe='+var_sw_epe;
				 data+='&sw_uo='+var_sw_uo;
				 data+='&sw_ot='+var_sw_ot;
				 
				 data+='&id_cuenta_inicial='+var_id_cuenta_inicial;
				 data+='&id_cuenta_final='+var_id_cuenta_final;
				 data+='&id_auxiliar_inicial='+var_id_auxiliar_inicial;
				 data+='&id_auxiliar_final='+var_id_auxiliar_final;
				 data+='&id_partida_inicial='+var_id_partida_inicial;
				 data+='&id_partida_final='+var_id_partida_final;
				 data+='&id_epe_inicial='+var_id_epe_inicial;
				 data+='&id_epe_final='+var_id_epe_final;
				 data+='&id_uo_inicial='+var_id_uo_inicial;
				 data+='&id_uo_final='+var_id_uo_final;
				 data+='&id_ot_inicial='+var_id_ot_inicial;
				 data+='&id_ot_final='+var_id_ot_final;
				 data+='&sw_estado_cbte='+var_estado_cbte;
				 data+='&sw_actualizacion='+var_sw_actualizacion;
				 data+='&id_moneda='+var_id_moneda;
				 data+='&desc_moneda='+var_desc_moneda;
				 data+='&desc_depto='+var_desc_depto;
				 data+='&ids_cuenta='+var_ids_cuenta;
				 data+='&ids_partida='+var_ids_partida;
				 data+='&ids_auxiliar='+var_ids_auxiliar;
				 data+='&ids_epe='+var_ids_epe;
				 data+='&ids_uo='+var_ids_uo;
				 data+='&ids_ot='+var_ids_ot;
				 
				 data+='&tipo_reporte='+g_tipo_reporte;
				 data+='&tipo_cambio='+var_tipo_cambio;
				 data+='&sw_orden='+g_sw_orden;
				 data+='&sw_vista='+vista;
				 
				if (var_id_depto != ''){
					window.open(direccion+'../../../control/eeff_mayor/reporte/ActionPDFEeffMayorJasper.php?'+data)
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