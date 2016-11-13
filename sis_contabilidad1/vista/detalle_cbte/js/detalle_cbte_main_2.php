//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
	var paramConfig={TiempoEspera:10000};
	var elemento={pagina:new ReporteDetalleCbte(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/*function ReporteDetalleCbte(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_detalle_cbte, h_txt_gestion, h_txt_mes, ds_linea;
	var	g_fecha_fin=new Date();
	var g_fecha_ini=new Date();
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_comboPresupuesto:'si'}
		});
	
	var ds_depto = new Ext.data.Store({proxy :new Ext.data.HttpProxy({url :direccion + '../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record :'ROWS',id :'id_depto',totalRecords :'100'}, [ 'id_depto', 'codigo_depto', 'nombre_depto', 'estado','id_subsistema', 'nombre_corto', 'nombre_largo' ]),
		baseParams:{m_id_subsistema :9}
		});
	
	ds_depto.load();
	var data_deptos=new Array();
	var indice=0;
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	var resultTplDepto = new Ext.Template('<div class="search-item">',
			'<b><i>{nombre_depto}</i></b>',
			'<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>', '</div>');

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
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	
	vectorAtributos[1] = {
		validacion : {
			name :'fecha_ini',
			fieldLabel :'Fecha Inicio',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_ini',
		dateFormat :'m/d/Y',
		defecto :""
	};
	
	vectorAtributos[2] = {
		validacion : {
			name :'fecha_fin',
			fieldLabel :'Fecha Fin',
			allowBlank :false,
			format :'d/m/Y',
			minValue :'01/01/1900',
			renderer :formatDate,
			disabled :false
		},
		id_grupo :0,
		tipo :'DateField',
		save_as :'fecha_fin',
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
	
	vectorAtributos[5] = {
		validacion : {
			labelSeparator :'',
			name :'nombre_departamento',
			inputType :'hidden',
			grid_visible :false,
			grid_editable :false
		},
		tipo :'Field',
		filtro_0 :false,
		save_as :'nombre_departamento'
	};

	vectorAtributos[6] = {
		validacion : {
			name :'departamento',
			fieldLabel :'Deptos.',
			store:ds_depto,
			valueField :'id_depto',
			displayField :'nombre_depto',
			width :150,
			height :150,
			allowBlank :false,
			width :300
		},
		tipo :'Multiselect',
		save_as :'deptos_ids'
	};
		  
	vectorAtributos[7]={
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
	
	vectorAtributos[8]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['xls','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_detalle_cbte = new DocsLayoutProceso(idContenedor);
	layout_detalle_cbte.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_detalle_cbte, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[0].on('select',evento_parametro);		//parametro	
		componentes[1].on('change', evento_fecha_inicio); //
		componentes[2].on('change', evento_fecha_fin); //
	}
	
	function evento_parametro( combo, record, index ){
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){
			var intGestion=componentes[0].store.getById(id).data.gestion_conta;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[1].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[1].maxValue=dte_fecha_fin_valid;
			componentes[2].minValue=dte_fecha_ini_valid;
			componentes[2].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[1].setValue(dte_fecha_ini_valid);
			componentes[2].setValue(dte_fecha_fin_valid);	
		}
	}

	function evento_fecha_inicio(combo, record, index) {
		var fecha_inicio_val = componentes[1].getValue();
		componentes[2].minValue = fecha_inicio_val;
		componentes[3].setValue(formatDate(componentes[0].getValue()));
	}
	
	function evento_fecha_fin(combo, record, index) {
		var fecha_fin_val = componentes[2].getValue();
		componentes[4].setValue(formatDate(componentes[1].getValue()));
	}

	function evento_departamento(combo, record, index) {
		// Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[5].setValue(record.data.codigo_depto + '-'
				+ record.data.nombre_depto);
	}

	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Detalle de Comprobantes" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {
			labelWidth :75,
			url :direccion + '../../../control/comprobante/ActionPDFDetalleCbte.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 420, 420 ],
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ],
			submit:function (){
				g_id_parametro = componentes[0].getValue();
				g_id_moneda = componentes[7].getValue();
				g_fecha_ini = componentes[1].getValue()?componentes[1].getValue().dateFormat('m/d/Y'):'';
				g_fecha_fin = componentes[2].getValue()?componentes[2].getValue().dateFormat('m/d/Y'):'';
				//g_fecha_ini = componentes[1].getValue();
				//g_fecha_fin = componentes[2].getValue();
				g_id_deptos = componentes[6].getValue();
				g_tipo_reporte = componentes[8].getValue();
				
				var data='&id_parametro='+g_id_parametro;
				data+='&id_moneda='+g_id_moneda;
				data+='&id_deptos='+g_id_deptos;
				data+='&fecha_ini='+g_fecha_ini;
				data+='&fecha_fin='+g_fecha_fin;
				data+='&tipo_reporte='+g_tipo_reporte;
				
				if (g_id_deptos != ''){
					window.open(direccion+'../../../control/comprobante/reporte/ActionPDFDetalleCbteJasper.php?'+data)
				}
			}
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}*/