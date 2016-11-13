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
	var elemento={pagina:new pagina_repestadisticos(idContenedor,direccion,paramConfig,sw_vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_repestadisticos(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_repestdisticos;
	var ContPes = 1;
	var vectorAtributos = new Array;
	
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	var g_admi;
	
	var comp_id_parametro, comp_id_tipo_pres, comp_fecha_ini, comp_fecha_fin, comp_id_moneda, comp_desc_moneda, comp_desc_gestion, comp_desc_tipo_pres, comp_desc_partida;
	var comp_sw_vista, comp_sw_ejecuta, comp_sw_filtro, comp_sw_mes, comp_sw_trim, comp_sw_nivel, comp_sw_impre, comp_sw_eplis, comp_sw_cplis, comp_id_partida;
	
	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
	});
	
	ds_parametro.load();
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro = new Ext.Template('<div class="search-item">','<b>{gestion_pres}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	

	/////////////////////////'<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>', '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>',
	// Definición de datos //
	/////////////////////////  ['13','Comparativo'],   ,['12','Mensual - Inversión']
	vectorAtributos[0]={
		validacion:{
			name: 'sw_ejecuta',
			fieldLabel:'Reporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Reporte 1'],['2','Reporte 2'],['3','Reporte 3'],['4','Reporte 4'],['5','Reporte 5'],['6','Reporte 6'],['7','Reporte 7'],['8','Reporte 8'],['9','Reporte 9'],['10','Reporte 10'],['11','Reporte 11'],['12','Reporte 12'],['13','Reporte 13']]}),				
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
	};

	vectorAtributos[3]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['CD','PDF ']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:2,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[4] = {
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
	
	vectorAtributos[5] = {
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

	vectorAtributos[6] = {
		validacion : {
			labelSeparator :'',
			name :'desc_moneda',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:3
	};
	
	vectorAtributos[7] = {
		validacion : {
			labelSeparator :'',
			name :'desc_gestion',
			inputType :'hidden'
		},
		tipo :'Field',
		id_grupo:3
	};
	
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_repestadisticos = new DocsLayoutProceso(idContenedor);
	layout_repestadisticos.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_repestadisticos, idContenedor);
	
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
		/*comp_sw_vista = ClaseMadre_getComponente('sw_vista');
		comp_sw_ejecuta = ClaseMadre_getComponente('sw_ejecuta');
		*/comp_id_parametro = ClaseMadre_getComponente('id_parametro');
		/*comp_id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');*/
		comp_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		comp_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		comp_id_moneda = ClaseMadre_getComponente('id_moneda');
		comp_desc_moneda = ClaseMadre_getComponente('desc_moneda');
		comp_desc_gestion = ClaseMadre_getComponente('desc_gestion');
	
		comp_id_parametro.on('select',f_evento_parametro);	
		
		comp_id_moneda.on('select',f_evento_id_moneda);	
		
		CM_ocultarGrupo('Hidden');
	
		//limpiar_componentes();
	}
	
	
	//}
	function f_evento_id_moneda(combo, record, index){comp_desc_moneda.setValue(record.data.nombre)}
	function f_evento_parametro(combo, record, index){
		comp_desc_gestion.setValue(record.data.gestion_pres)
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
			
		}
	
	function obtenerTitulo() {
		var titulo = "EJECUCION PRESUPUESTARIA" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :95,
			url :direccion + '../../../control/rep_estadisticas/reporte/ActionPDF_ReportesEstadisticos_Jasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 400, 510 ],
			grupos : [
				{tituloGrupo :'Datos Generales', columna :0, id_grupo :0},
				{tituloGrupo :'Periodo', columna :0, id_grupo :1},
				
				{tituloGrupo :'Reporte', columna :0, id_grupo :2},
				{tituloGrupo :'Hidden', columna :0, id_grupo :3}
				
		]}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}