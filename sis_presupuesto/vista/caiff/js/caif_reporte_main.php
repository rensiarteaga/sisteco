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
	var elemento={pagina:new pagina_caif_reporte_main(idContenedor,direccion,paramConfig,sw_vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_caif_reporte_main(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_caif_reporte_main;
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
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['anual','ANUAL'],['mensual','MENSUAL'],['fechas','FECHAS']]}),
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
	vectorAtributos[2]={
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
	
	vectorAtributos[3]={
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


		vectorAtributos[4]={
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
		
	/*vectorAtributos[2]={
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
		id_grupo:2,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};*/
	vectorAtributos[5]={
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
	vectorAtributos[6]={
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
	
	vectorAtributos[7] = {
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
	layout_caif_reporte_main = new DocsLayoutProceso(idContenedor);
	layout_caif_reporte_main.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_caif_reporte_main, idContenedor);
	
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
		comp_id_gestion = ClaseMadre_getComponente('id_gestion');
		comp_desc_gestion = ClaseMadre_getComponente('desc_gestion');
		cmb_periodo=ClaseMadre_getComponente('id_periodo');
              comp_fecha_ini = ClaseMadre_getComponente('fecha_inicio');
		comp_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		comp_id_gestion.on('select',f_evento_gestion);	
		
		CM_ocultarGrupo('Hidden');
	
		
	}
	
	//}
	//function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}
	function f_evento_gestion(combo, record, index){
		comp_desc_gestion.setValue(record.data.gestion)
		var id = comp_id_gestion.getValue();
		
		//cmb_periodo.filterValues[0]=id_gestion;
		componentes[2].store.baseParams={id_gestion:id};
		cmb_periodo.modificado = true;
		cmb_periodo.setValue('');
		var intGestion = record.data.gestion;
		
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