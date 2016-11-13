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
	var elemento={pagina:new pagina_eeff_mayor_global(idContenedor,direccion,paramConfig,vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_eeff_mayor_global(idContenedor, direccion, paramConfig, vista) {
	var vectorAtributos = new Array;
	var ContPes = 1;
	var layout_eeff_mayor_global;
	
	var g_tipo_reporte;
	
	var var_id_gestion, var_id_depto, var_fecha_inicio, var_fecha_final, var_id_moneda='';
	var var_desc_fecha_inicio='';	
	var var_desc_fecha_final='', var_tipo_pres='';
	

	
	var var_id_partida_inicial, var_id_partida_final;

	
	var comp_id_gestion, comp_id_depto, comp_fecha_inicio, comp_fecha_final, comp_id_moneda, comp_tipo_reporte;
	
	var comp_sw_partida, comp_sw_ppto;
	
	
	var comp_id_partida_inicial, comp_id_partida_final, comp_id_partida_multiple, tipo_pres;
	
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	/*var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
*/
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral','id_gestion'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=sci&todos=si&valor=0'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'no'}
	});
	
	
	var ds_componente_partida=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../control/eeff_mayor/ActionListarMayDat.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_maydat','codigo','nombre','codigo_nombre'])
	});


	var ds_ppto = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_presupuesto/control/rep_ejecuta/ActionListarDatos.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_maydat',totalRecords:'TotalCount'},['id_datos','codigo','nombre','codigo_nombre'])
	});

	

	ds_depto.load();
	var data_deptos=new Array();
	var indice=0;
	
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_pres}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	
	
	function render_componente_partida(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_componente_partida=new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');

		
	function render_tipo(value, p, record)
	{	if(value=='rango'){return 'RANGO';}
		if(value=='detalle'){return 'DETALLE';}
		if(value=='cabecera'){return 'CABECERA';}
		if(value=='ninguno'){return 'NINGUNO';}
	}

	function render_ppto(value, p, record){return String.format('{0}', record.data['codigo']+" - "+record.data['nombre'])};
	var tpl_ppto = new Ext.Template('<div class="search-item">','<b>- </b><FONT COLOR="#0000ff">{codigo}</FONT> - ','<FONT COLOR="#0000ff">{nombre}</FONT><br>','</div>');
 	
	
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
	
	
	
	
	
	
	vectorAtributos[7]={
		validacion:{
			name:'sw_partida',
			fieldLabel:'Opción',
			allowBlank:true,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['rango','RANGO'],['ninguno','NINGUNO']]}),
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
		form: false,
		save_as:'sw_partida'
	};
	
	vectorAtributos[8]={
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
		id_grupo:1,
		filtro_0:false,
 		form: true,
 		save_as:'id_partida_inicial'
	};	
	
	vectorAtributos[9]={
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
		id_grupo:1,
		filtro_0:false,
 		form: false,
 		save_as:'id_partida_final'
	};
	
	
	
	/*vectorAtributos[10]={
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
			id_grupo:1,
			filtro_0:false,
	 		form: true
		};
	
	if(vista=='mayor' || vista=='mayor_tc'){
		vectorAtributos[11]={
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
				                                                            ['xls','Excel']]}),
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
		vectorAtributos[11]={
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
	}*/
	
	vectorAtributos[10]={
			validacion:{
				name:'tipo_pres',
				fieldLabel:'Tipo Presupuesto',
				allowBlank:false,
				align:'left',
				emptyText:'Tipo Presupuesto',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['2','Gasto'],['3','Inversion']]}),
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
			save_as:'tipo_pres'
		};

	vectorAtributos[11]={
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
			id_grupo:1,
			save_as:'sw_ppto'
		};	
	vectorAtributos[12]={
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
			id_grupo:1,
			form: true
		};
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_eeff_mayor_global = new DocsLayoutProceso(idContenedor);
	layout_eeff_mayor_global.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_eeff_mayor_global, idContenedor);
	
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
		comp_id_moneda=ClaseMadre_getComponente('id_moneda');
		comp_sw_partida=ClaseMadre_getComponente('sw_partida');
		comp_id_partida_inicial=ClaseMadre_getComponente('id_partida_inicial');
		comp_id_partida_final=ClaseMadre_getComponente('id_partida_final');
		comp_ids_ppto = ClaseMadre_getComponente('ids_ppto');
		comp_sw_ppto=ClaseMadre_getComponente('sw_ppto');
		tipo_pres=ClaseMadre_getComponente('tipo_pres');
		comp_tipo_reporte=ClaseMadre_getComponente('tipo_reporte');
		comp_id_gestion.on('select',f_almacenar_gestion);	
		comp_id_depto.on('select',f_almacenar_depto);	
		comp_fecha_inicio.on('blur',f_almacenar_inicio);
		comp_fecha_final.on('blur',f_almacenar_final);	
		comp_id_moneda.on('select',f_almacenar_id_moneda);	
		comp_sw_partida.on('select',f_almacenar_sw_partida);	
		comp_id_partida_inicial.on('select',f_almacenar_partida_inicial);	
		comp_id_partida_final.on('select',f_almacenar_partida_final);	
		tipo_pres.on('select',f_almacenar_tipo_pres);	
		comp_sw_ppto.on('select',f_evento_sw_ppto);
		//comp_sw_ppto.on('select',f_evento_sw_ppto);
		limpiar_componentes();
	}
	
	function limpiar_componentes(){
		
		CM_ocultarComponente(comp_sw_partida);
		CM_ocultarComponente(comp_ids_ppto);
		//CM_ocultarComponente(comp_sw_ppto);
		comp_sw_partida.setValue('');
		comp_id_partida_inicial.allowBlank=true;
		comp_id_partida_inicial.setValue('');
		CM_ocultarComponente(comp_id_partida_final);
		comp_id_partida_final.allowBlank=true;
		comp_id_partida_final.setValue('');
		var_sw_partida='rango';
		comp_sw_ppto.setValue('todos');
		var_id_partida_inicial='';
		var_id_partida_final='';
		
		
	}
	
	function f_almacenar_gestion( combo, record, index ){
		var_id_gestion=record.data.id_gestion;
		var_desc_id_gestion=record.data.gestion_pres;
		
		var intGestion=record.data.gestion_pres;
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

	function f_almacenar_tipo_pres( combo, record, index ){ //alert("llega"+record.data.valor +'---'+record.data);
		var_id_tipo_pres=record.data.valor;
	
		// comp_ids_ppto.store.baseParams = {sw_admi:'SI',sw_listado:'ppto',id_parametro:comp_id_gestion.getValue(), id_tipo_pres:tipo_pres.getValue()};
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
		comp_ids_ppto.store.baseParams = {sw_admi:'SI',sw_listado:'ppto',id_parametro:comp_id_gestion.getValue(), id_tipo_pres:tipo_pres.getValue()};
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
		comp_ids_ppto.store.baseParams = {sw_admi:'SI',sw_listado:'ppto',id_parametro:comp_id_gestion.getValue(), id_tipo_pres:tipo_pres.getValue()};
	}
	
	function f_almacenar_depto( combo, record, index ){
		var_id_depto=record.data.id_depto;
		var_desc_depto=record.data.nombre_depto;
		limpiar_componentes();	

		var_desc_sw_partida='rango';
		var_sw_partida='rango';
		var_desc_id_partida_inicial='';
		var_desc_id_partida_final='';
		
			 comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:'ninguno', sw_auxiliar:'ninguno',
					 sw_partida:var_sw_partida, sw_epe:'ninguno',
					 sw_uo:'ninguno', sw_ot:'ninguno',
					 sw_estado_cbte:1, sw_actualizacion:'si', sw_listado:'partida',
					 
					 id_cuenta_inicial:'', id_cuenta_final:'',
					 id_auxiliar_inicial:'', id_auxiliar_final:'',
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:'', id_epe_final:'',
					 id_uo_inicial:'', id_uo_final:'',
					 id_ot_inicial:'', id_ot_final:''};




			 
		 	comp_id_partida_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_partida_inicial);
		//	CM_mostrarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=false;
			comp_id_partida_final.allowBlank=false;
		
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
	
	
	
	
	function f_almacenar_id_moneda( combo, record, index ){
		var_id_moneda=record.data.id_moneda;
		var_desc_moneda=record.data.simbolo;
		limpiar_componentes();
	}
	
	
	
	
	
	function f_almacenar_sw_partida( combo, record, index ){
		var_sw_partida=record.data.ID;
		var_desc_sw_partida=record.data.ID;
		var_desc_id_partida_inicial='';
		var_desc_id_partida_final='';
		
			 comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
					 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
					 
					 sw_cuenta:'ninguno', sw_auxiliar:'ninguno',
					 sw_partida:var_sw_partida, sw_epe:'ninguno',
					 sw_uo:'ninguno', sw_ot:'ninguno',
					 sw_estado_cbte:1, sw_actualizacion:'si', sw_listado:'partida',
					 
					 id_cuenta_inicial:'', id_cuenta_final:'',
					 id_auxiliar_inicial:'', id_auxiliar_final:'',
					 id_partida_inicial:var_id_partida_inicial, id_partida_final:var_id_partida_final,
					 id_epe_inicial:'', id_epe_final:'',
					 id_uo_inicial:'', id_uo_final:'',
					 id_ot_inicial:'', id_ot_final:''};




			 
		 	comp_id_partida_inicial.modificado=true;
		 	CM_mostrarComponente(comp_id_partida_inicial);
			CM_mostrarComponente(comp_id_partida_final);
			comp_id_partida_inicial.allowBlank=false;
			comp_id_partida_final.allowBlank=false;
		
	}
	
	
	function f_almacenar_partida_inicial( combo, record, index ){
		var_id_partida_inicial=record.data.id_maydat;
		var_desc_id_partida_inicial=record.data.codigo_nombre;
		
	


		
		comp_id_partida_final.modificado=true;
	}
	
	function f_almacenar_partida_final( combo, record, index ){
		var_id_partida_final=record.data.id_maydat;
		var_desc_id_partida_final=record.data.codigo_nombre; 
		
		comp_id_partida_inicial.store.baseParams={id_gestion:var_id_gestion, id_depto:var_id_depto,
				 fecha_inicio:var_fecha_inicio, fecha_final:var_fecha_final,
				 
				
				 sw_cuenta:'ninguno', sw_auxiliar:'ninguno',
				 sw_partida:var_sw_partida, sw_epe:'ninguno',
				 sw_uo:'ninguno', sw_ot:'ninguno',
				 sw_estado_cbte:1, sw_actualizacion:'si', sw_listado:'partida', 
				 
				
				 id_partida_inicial:var_id_partida_inicial, 
				 id_partida_final:var_id_partida_final};
		comp_id_partida_inicial.modificado=true;
	}

	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "DETALLE AUDITORIA" + ContPes;
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
				
				{tituloGrupo :'Presupuesto/Partida', columna :0, id_grupo :1}
				
				//{tituloGrupo :'Reporte', columna :1, id_grupo :7},
				],
			submit:function (){
				g_tipo_reporte = 5;
				
				
				
				//var_ids_partida = comp_id_partida_multiple.getValue();
				
				
				
				var data='id_gestion='+var_id_gestion;
				 data+='&id_depto='+var_id_depto;
				 
				 data+='&fecha_inicio='+var_fecha_inicio;
				 data+='&fecha_final='+var_fecha_final;
				 data+='&fecha_inicio_rep='+var_desc_fecha_inicio;
				 data+='&fecha_final_rep='+var_desc_fecha_final;
			
				 data+='&sw_partida='+var_sw_partida;
				
				 
				
				 data+='&id_partida_inicial='+var_id_partida_inicial;
				 data+='&id_partida_final='+var_id_partida_inicial;
				
				 data+='&id_moneda='+var_id_moneda;
				 data+='&desc_moneda='+var_desc_moneda;
				 data+='&desc_depto='+var_desc_depto;
				
				 //data+='&ids_partida='+var_ids_partida;
				
				 
				 data+='&tipo_reporte='+g_tipo_reporte;
				 data+='&desc_partida='+var_desc_id_partida_inicial;
				 data+='&sw_vista='+vista;
				 data+='&tipo_pres='+var_id_tipo_pres;
				 data+='&sw_ppto='+comp_sw_ppto.getValue();
				 data+='&ids_ppto='+comp_ids_ppto.getValue();
				if (var_id_depto != ''){
					window.open(direccion+'../../../../control/eeff_mayor/reporte/ActionPDFDetalleAuditJasper.php?'+data)
				}
			}
		}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario);
}