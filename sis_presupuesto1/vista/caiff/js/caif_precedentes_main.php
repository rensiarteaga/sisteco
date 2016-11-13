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
	var elemento={pagina:new pagina_caif_precedentes_main(idContenedor,direccion,paramConfig,sw_vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_caif_precedentes_main(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_caif_precedentes_main;
	var ContPes = 1;
	var vectorAtributos = new Array;
	var componentes= new Array(); 
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	var g_admi;
	
	var comp_id_parametro, comp_id_tipo_pres, comp_fecha_ini, comp_fecha_fin, comp_id_moneda, comp_desc_moneda, comp_desc_gestion, comp_desc_tipo_pres, comp_desc_partida;
	var comp_sw_vista, comp_sw_ejecuta, comp_sw_filtro, comp_sw_mes, comp_sw_trim, comp_sw_nivel, comp_sw_impre, comp_sw_eplis, comp_sw_cplis, comp_id_partida;
	
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion','estado_ges_gral'])
	});
	
	var ds_caif = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/caiff/ActionListarCaif.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caif',totalRecords: 'TotalCount'},['id_caif','desc_caif','codifo_caif','nombre_caif','sw_transaccional'])
	});

	var ds_partida_caif = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/caiff/ActionListarPartidaCaif.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_caif',totalRecords: 'TotalCount'},['id_partida_caif','codigo_partida','nombre_partida'])
	});
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	ds_gestion.load();
	var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_registro','fecha_final','estado_peri_gral'])});
			
	//FUNCIONES RENDER
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion = new Ext.Template('<div class="search-item">','<b>{gestion}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_caif(value, p, record){return String.format('{0}', record.data['desc_caif']);}
	var tpl_id_caif = new Ext.Template('<div class="search-item">','<b>{desc_caif}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_partida_caif(value, p, record){return String.format('{0}', record.data['codigo_partida']);}
	var tpl_id_partida_caif = new Ext.Template('<div class="search-item">','<b>{codigo_partida}-{nombre_partida}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
	var tpl_periodo=new Ext.Template('<div class="search-item">','<b><i>{periodo}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{estado_peri_gral}</FONT>','</div>');
	
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	

	/////////////////////////'<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>', '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>',
	// Definición de datos //
	/////////////////////////  ['13','Comparativo'],   ,['12','Mensual - Inversión']
	vectorAtributos[0]={
			validacion:{
				name:'reporte',
				fieldLabel:'Elegir el Reporte',
				vtype:'texto',
				emptyText:'Reporte...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['anual','ANUAL'],['mensual','MENSUAL']]}),
				valueField:'ID',
				displayField:'valor',
				forceSelection:true,
				width:200
			},
			tipo:'ComboBox',  
			id_grupo:0,
			save_as:'reporte'
		};
	vectorAtributos[1]={
			validacion:{
				name:'reporte_detalle',
				fieldLabel:'Detalle del Reporte',
				vtype:'texto',
				emptyText:'Detalle...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['caif_partidas','CAIF-PARTIDAS'],['partidas_cbtes','PARTIDAS-COMPROBANTES']]}),
				valueField:'ID',
				displayField:'valor',
				forceSelection:true,
				width:200
			},
			tipo:'ComboBox',  
			id_grupo:0,
			save_as:'reporte_detalle'
		};
	vectorAtributos[2]={
			validacion:{
				name:'tipo_caif',
				fieldLabel:'Tipo CAIF',
				vtype:'texto',
				emptyText:'Reporte...',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Recursos'],['2','Gastos']]}),
				valueField:'ID',
				displayField:'valor',
				forceSelection:true,
				width:200
			},
			tipo:'ComboBox',  
			id_grupo:0,
			save_as:'reporte'
		};
	
	vectorAtributos[3]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
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
			renderer:render_id_gestion,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		id_grupo:0,
		filterColValue:'GESTIO.gestion',
		save_as:'id_gestion'
	};
	vectorAtributos[4]={
			validacion:{
				name: 'sw_nivel',
				fieldLabel:'Niveles',
				vtype:'texto',
				emptyText:'Nivel...',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Todos los Niveles'],['2','Grupos y CAIF de Movimiento'],['3','Grupos y CAIF sin Movimiento'],['4','Grupos de CAIF']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				width:200		
			},
			tipo: 'ComboBox',		
			id_grupo:0,			
			save_as:'sw_nivel'
		};
	vectorAtributos[5]={
			validacion:{
				name:'id_caif',
				fieldLabel:'CAIF',
				allowBlank:false,			
				emptyText:'CAIF...',
				desc: 'desc_caif', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_caif,
				valueField: 'id_caif',
				displayField: 'desc_caif',
				queryParam: 'filterValue_0',
				filterCol:'CAIF.desc_caif',
				typeAhead:true,
				tpl:tpl_id_caif,
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
				renderer:render_id_caif,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:0,
			filterColValue:'CAIF.desc_caif',
			save_as:'id_caif'
		};
	vectorAtributos[6]={
			validacion:{
				name:'id_partida_caif',
				fieldLabel:'PARTIDA',
				allowBlank:false,			
				emptyText:'PARTIDA...',
				desc: 'codigo_partida', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_partida_caif,
				valueField: 'id_partida_caif',
				displayField: 'codigo_partida',
				queryParam: 'filterValue_0',
				filterCol:'PAR.codigo_partida',
				typeAhead:true,
				tpl:tpl_id_partida_caif,
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
				renderer:render_id_partida_caif,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:0,
			filterColValue:'PAR.codigo_partida',
			save_as:'id_partida_caif'
		};
	vectorAtributos[7]={
			validacion:{
				name:'id_periodo',
				fieldLabel:'Periodo',
				allowBlank:false,			
				emptyText:'Periodo...',
				desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
				store: ds_periodo,
				valueField: 'id_periodo',
				displayField: 'periodo',
				queryParam: 'filterValue_0',
				filterCol:'PERIOD.periodo,',
				typeAhead:true,
				align:'center',
				tpl: tpl_periodo,
				forceSelection:true,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mÃ¯Â¿Â½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer: render_periodo,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'id_periodo'
		};
	
	vectorAtributos[8]={
			validacion:{
					name:'fecha_inicio',
					fieldLabel:'Fecha Inicio',
					allowBlank:false,
					format : 'd/m/Y', // formato para validacion
					minValue : '01/01/1900',
					disabledDaysText: 'Dia no valido',
					grid_visible:true,
					grid_editable:false,
					renderer: formatDate,
					width_grid:85,
					disabled:false
			},
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'ca.fecha_inicio',
			dateFormat :'m/d/Y',
			defecto:'',
			save_as:'fecha_inicio',
				
		};
		
		// txt fecha_fin


		vectorAtributos[9]={
			validacion:{
					name:'fecha_fin',
					fieldLabel:'Fecha Fin',
					allowBlank:false,
					format : 'd/m/Y', // formato para validacion
					minValue : '01/01/1900',
					disabledDaysText: 'Dia no valido',
					grid_visible:true,
					grid_editable:false,
					renderer: formatDate,
					width_grid:85,
					disabled:false
			},
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'ca.fecha_fin',
			dateFormat :'m/d/Y',
			defecto:'',
			save_as:'fecha_fin',
				
		};
	
	
	
	vectorAtributos[10]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF '],['xls','EXCEL']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',  
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[11] = {
		validacion : {
			labelSeparator :'',
			name :'desc_gestion',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:0
	};
	
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"CAIF"
	};
	layout_caif_precedentes_main = new DocsLayoutProceso(idContenedor);
	layout_caif_precedentes_main.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_caif_precedentes_main, idContenedor);
	
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
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=getComponente(vectorAtributos[i].validacion.name);
		}
		comp_reporte = ClaseMadre_getComponente('reporte');
		comp_reporte_detalle = ClaseMadre_getComponente('reporte_detalle');
		comp_id_gestion = ClaseMadre_getComponente('id_gestion');
		comp_tipo_caif = ClaseMadre_getComponente('tipo_caif');
		comp_id_caif = ClaseMadre_getComponente('id_caif');
		comp_sw_nivel = ClaseMadre_getComponente('sw_nivel');
		comp_desc_gestion = ClaseMadre_getComponente('desc_gestion');
		cmb_periodo=ClaseMadre_getComponente('id_periodo');
		comp_fecha_ini = ClaseMadre_getComponente('fecha_inicio');
		comp_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		comp_id_partida_caif = ClaseMadre_getComponente('id_partida_caif');

		cmb_periodo.setDisabled(true);
		comp_id_caif.setDisabled(true);
		comp_sw_nivel.setDisabled(true);	
		comp_fecha_ini.setDisabled(true);	
		comp_fecha_fin.setDisabled(true);
		comp_id_partida_caif.setDisabled(true);
		comp_reporte_detalle.setDisabled(true);
		comp_tipo_caif.setDisabled(true);
		comp_id_gestion.setDisabled(true);

		comp_reporte.on('select',f_evento_reporte);
		comp_id_gestion.on('select',f_evento_gestion);	
		comp_sw_nivel.on('select',f_evento_sw_nivel);	
		comp_id_caif.on('select',f_evento_caif);
		comp_reporte_detalle.on('select',f_evento_reporte_detalle);
		comp_tipo_caif.on('select',f_evento_tipo_caif);
		CM_ocultarGrupo('Hidden');
	
		
	}

	function f_evento_reporte(combo,record,index)
	{   comp_reporte_detalle.setValue('');
	    comp_tipo_caif.setValue('');
	    comp_id_gestion.setValue('');
	    comp_sw_nivel.setValue('');
	    comp_id_caif.setValue('');
	    
		comp_reporte_detalle.setDisabled(false);
		comp_tipo_caif.setDisabled(true);
		comp_id_gestion.setDisabled(true);
		comp_sw_nivel.setDisabled(true);
		comp_id_caif.setDisabled(true);	
	}
	function f_evento_reporte_detalle(combo,record,index)
	{
		comp_tipo_caif.setDisabled(false);
		comp_id_gestion.setDisabled(true);
		comp_sw_nivel.setDisabled(true);
		comp_id_caif.setDisabled(true);	
	}
	function f_evento_tipo_caif(combo,record,index)
	{
		comp_id_gestion.setDisabled(false);
		comp_sw_nivel.setDisabled(true);
		comp_id_caif.setDisabled(true);	
	}
	function f_evento_gestion(combo, record, index){
		comp_desc_gestion.setValue(record.data.gestion)
		var id = comp_id_gestion.getValue();
		var intGestion=record.data.gestion;
		if (comp_reporte.getValue()=='anual'){
			
			cmb_periodo.setDisabled(true);	
			comp_fecha_ini.setDisabled(true);	
			comp_fecha_fin.setDisabled(true);	
			
			cmb_periodo.setValue('');	
			comp_fecha_ini.setValue('');
			comp_fecha_fin.setValue('');
			 var dte_fecha_ini_valid = new Date('01/01/'+intGestion);
			 var dte_fecha_fin_valid = new Date('12/31/'+intGestion);
        	
				//Define un valor por defecto
				comp_fecha_ini.setValue(dte_fecha_ini_valid);
				comp_fecha_fin.setValue(dte_fecha_fin_valid); 
		 
		}
		else
		{  
			cmb_periodo.setDisabled(false);	
			comp_fecha_ini.setDisabled(false);	
			comp_fecha_fin.setDisabled(false);	
		}
		    comp_sw_nivel.setDisabled(false);	
			componentes[2].store.baseParams={id_gestion:id};
			cmb_periodo.modificado = true;
		    cmb_periodo.setValue('');
	}
	function f_evento_sw_nivel(combo,record,index)
	{ 
		 var id = comp_id_gestion.getValue();
		 var tipo=comp_tipo_caif.getValue();
		 
		 
		 comp_id_caif.setDisabled(false);	
		 comp_id_caif.store.baseParams={id_gestion:id,tipo_caif:tipo,sw_nivel:comp_sw_nivel.getValue()};
		 comp_id_caif.modificado = true;
	     comp_id_caif.setValue('');
	}

	function f_evento_caif(combo,record,index)
	{ 
		 var id = comp_id_caif.getValue();
		 var reporte_detalle=comp_reporte_detalle.getValue();
		
		if (reporte_detalle=='partidas_cbtes'){
			 comp_id_partida_caif.setDisabled(false);	
			 comp_id_partida_caif.store.baseParams={id_caif:id};
			 comp_id_partida_caif.modificado = true;
		     comp_id_partida_caif.setValue('');
			}else{
			 comp_id_partida_caif.setDisabled(true);	
		}
	}

	function obtenerTitulo() {
		var titulo = "CAIF" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :95,
			url :direccion + '../../../control/caiff/ActionPDFCAIFReporte.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 400, 510 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0}
				
				
		]}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}