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
var elemento={pagina:new ReporteValLibroMayorBancaria(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function ReporteValLibroMayorBancaria(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	var ContPes=1;
	var layout_lib_may_ban,h_txt_gestion,h_txt_mes,ds_linea;
	
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});

	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});	
				
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
	
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_depto,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			width:380,
			editable:true
		},
		id_grupo:0,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	
	///////// fecha_ini /////////
	vectorAtributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicial',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	
	///////// fecha_fin /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Final',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	
	vectorAtributos[3]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_ini',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'rep_fecha_ini'
	};
	
	vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'rep_fecha_fin',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'rep_fecha_fin'
	};
	
	vectorAtributos[5]={
		validacion:{
			labelSeparator:'',
			name:'nombre_departamento',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_departamento'
	};
	 
	vectorAtributos[6]={
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
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
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
	
	vectorAtributos[7]={
		validacion:{
			labelSeparator:'',
			name:'nombre_moneda',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'nombre_moneda'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	
	var config={titulo_maestro:"ValidacionLibroMayorBancaria"};
	layout_lib_may_ban=new DocsLayoutProceso(idContenedor);
	layout_lib_may_ban.init(config);
	
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_lib_may_ban,idContenedor);
    
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	
	//ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){			
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		componentes[0].on('select',evento_departamento);	//tipo_pres	
		componentes[1].on('change',evento_fecha_inicio);	//
		componentes[2].on('change',evento_fecha_fin);	//
		componentes[6].on('select',evento_moneda);	//
	}
	
	function evento_fecha_inicio(combo,record,index) {
		var fecha_inicio_val=componentes[1].getValue();
		componentes[2].minValue=fecha_inicio_val;
		componentes[3].setValue(formatDate(componentes[1].getValue()));
	}
	
	function  evento_fecha_fin(combo,record,index) {
		var fecha_fin_val=componentes[2].getValue();
		componentes[4].setValue(formatDate(componentes[2].getValue()));	
	}
	
	function evento_departamento( combo, record, index ){
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[5].setValue(record.data.codigo_depto+'-'+record.data.nombre_depto);
	}
	
	function evento_moneda( combo, record, index ){
		//Se añade los valores a los campos hidden para mandar la descripción al pdf
		componentes[7].setValue(record.data.nombre);
	}
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Validacion Libro Mayor Bancaria "+ContPes;
		ContPes ++;
		return titulo
	}
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:78,
			labelWidth:80,
			url:direccion+'../../../../../sis_contabilidad/control/_reportes/validacion_libro_mayor_bancaria/ActionPDFValidacionLibroMayorBancaria.php',
		    abrir_pestana:true,
		    titulo_pestana:obtenerTitulo,
		    fileUpload:false,columnas:[490,420],
			grupos:[{tituloGrupo:'Datos para el Reporte',
			        columna:0,
			        id_grupo:0
			}],
			parametros:''}
	};
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}