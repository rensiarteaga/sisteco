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
	var elemento={pagina:new pagina_eeff_bancaria(idContenedor,direccion,paramConfig,vista),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_eeff_bancaria(idContenedor, direccion, paramConfig, vista) {
	var vectorAtributos = new Array;
	var componentes = new Array();
	var ContPes = 1;
	var layout_eff_bancaria, h_txt_gestion, h_txt_mes, ds_linea;
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
	
	var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo/ActionListarPeriodo.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_periodo',totalRecords: 'TotalCount'}, 
				['id_periodo','id_gestion','desc_gestion','periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'estado_peri_gral','desc_periodo']),remoteSort:true
	});
	
	var ds_ctaban = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_cuenta_bancaria',totalRecords:'TotalCount'},
				['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','id_auxiliar','desc_auxiliar','nro_cheque','estado_cuenta','nro_cuenta_banco','id_moneda','nombre_moneda','id_parametro','gestion']),remoteSort:true
	});	

	var indice=0;
	
	/*FUNCIONES RENDER*/
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>{gestion_conta}</b><FONT COLOR="#B5A642"></FONT><br>','</div>');
	
	function render_id_ctaban(value,p,record){return String.format('{0}', record.data['desc_auxiliar']);}	
	var tpl_id_ctaban=new Ext.Template('<div class="search-item">','<b><i>{desc_auxiliar}</i></b>','<br><FONT COLOR="#B5A642">{desc_institucion}-{nro_cuenta_banco}</FONT>','</div>');
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
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
			queryDelay:200,
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
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};

	vectorAtributos[1] = {
		validacion : {
			name :'periodo',
			fieldLabel :'Periodo(s)',
			store:ds_periodo,
			valueField :'id_periodo',
			displayField :'desc_periodo',
			allowBlank :false,
			height :150,
			width :200
		},
		tipo :'Multiselect',
		save_as :'ids_periodo'
	};
	
	vectorAtributos[2]={
		validacion:{
			name:'sw_ctaban',
			fieldLabel:'Cta. Bancaria',
			allowBlank:false,
			align:'left',
			emptyText:'Ran...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['todo','TODOS'],['seleccion','SELECIONAR']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			minListWidth:100,
			width:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'sw_ctaban'
	};
	
	vectorAtributos[3]={
		validacion:{
			name:'ids_ctaban',
			fieldLabel:'Seleccionar:',
			allowBlank:true,
			store:ds_ctaban,	
			maestroValField:'desc_auxiliar',
			valueField: 'id_cuenta_bancaria',			
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar#INSTIT.nombre',
			typeAhead:false,
			tpl:tpl_id_ctaban,				
			defValor:function(val,record){					
				var text = '<'+ record['desc_auxiliar'] +'>';
				return text;				
			},							
			mode:'remote',
			queryDelay:350,
			pageSize:10,
			minListWidth:200,
			renderer:render_id_ctaban,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction:'all',
		    width:400
		},
		tipo:'ComboMultiple2',
 		form: true
	};
		  
	vectorAtributos[4]={
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
			queryDelay:200,
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
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Formato',
			vtype:'texto',
			emptyText:'Formato...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF'],['xls','Excel']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[6] = {
		validacion : {
			labelSeparator :'',
			name :'eeff_moneda',
			inputType :'hidden'
		},
		tipo :'Field'
	};
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Detalle de Comprobantes"
	};
	layout_eeff_bancaria = new DocsLayoutProceso(idContenedor);
	layout_eeff_bancaria.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_eeff_bancaria, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		for ( var i = 0; i < vectorAtributos.length; i++) {
			componentes[i] = ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[0].on('select', evento_parametro);
		componentes[2].on('select', evento_ctaban);
		componentes[4].on('select', evento_moneda);
		
		CM_ocultarComponente(componentes[3]);
		componentes[3].setValue('');
		componentes[3].allowBlank = true;
	}
	
	function evento_parametro( combo, record, index ){
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!= undefined){
			var id_gestion=componentes[0].store.getById(id).data.id_gestion;
			
			ds_periodo.baseParams={
				id_gestion:id_gestion
			}
			ds_periodo.load();
			
			ds_ctaban.baseParams={
				m_id_gestion:id_gestion
			}
			ds_ctaban.load();
			componentes[3].setValue('');
		}
	}
	
	function evento_ctaban(combo,record, index){
		if (record.data.ID == 'seleccion'){
			CM_mostrarComponente(componentes[3]);
			componentes[3].allowBlank = false;
		}else{
			CM_ocultarComponente(componentes[3]);
			componentes[3].setValue('');
			componentes[3].allowBlank = true;
		}
	}
	
	function evento_moneda(combo,record, index){componentes[6].setValue(record.data.nombre)}
	
	// ------ sobrecargo la clase madre obtenerTitulo para las
	// pestanas-----------------//
	function obtenerTitulo() {
		var titulo = "Saldos Bancarios" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		Formulario : {html_apply:'dlgInfo-'+idContenedor,
			labelWidth :75,
			url :direccion + '../../../control/eeff/reporte/ActionPDFEeffBancariaJasper.php',
			abrir_pestana :true,
			titulo_pestana :obtenerTitulo,
			fileUpload :false,
			columnas : [ 510, 350 ],
			minWidth:150, minHeight:200, closable:true, titulo:'Saldos Bancarios',
			grupos : [ {
				tituloGrupo :'Datos para el Reporte',
				columna :0,
				id_grupo :0
			} ]
		}
	};

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}