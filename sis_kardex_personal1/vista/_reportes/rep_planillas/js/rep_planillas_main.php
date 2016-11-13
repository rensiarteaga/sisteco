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
var elemento={pagina:new RepPlanilla(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function RepPlanilla(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	//var ContPes=1;
	//var layout_diagrama_uniorg,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
	
	
var ds_planilla=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/planilla/ActionListarPlanilla.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_planilla',totalRecords:'TotalCount'},['id_planilla','desc_tipo_planilla','resumen_periodo','numero','observaciones'])
	});
var tplPlanilla=new Ext.Template('<div class="search-item">','<b><i>{numero}</i></b><br>{observaciones}<br><b>{resumen_periodo}</b>','</div>');


	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Planillas',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Planillas...',
			name:'id_planilla',
			desc:'numero',
			store:ds_planilla,
			valueField:'id_planilla',
			displayField:'numero',
			queryParam:'filterValue_0',
			//filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:tplPlanilla,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			width:200
		},
		id_grupo:0,
		save_as:'id_planilla',
		tipo:'ComboBox'
	};
	
	
	
	
	/*vectorAtributos[1]={
		validacion:{
			name              :  'tipo_contrato',
			fieldLabel        : 'Tipo de Contrato',
			dataFields        :  ['cod', 'val'],
			data              :  Ext.repFuncionariosCombo.tipo_contrato,
// new Ext.data.SimpleStore({fields:['ID','valor'],data:[['planta','Planta'],['consultor','Consultoría'],['servicio','Servicio']]}), //Ext.proc_existenciasCombo.estado,
			valueField        :  'cod',
			displayField      :  'val',
			width             :  150,
			height            :  150,
			allowBlank        :  false,
			width:200
		},
		tipo:'Multiselect',
		save_as:'tipo_contrato'
		
	};
	
	vectorAtributos[2]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Hasta la Fecha',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false,
			width:200
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	
/*	vectorAtributos[3]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false,
			width:200
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	*/
	vectorAtributos[1]={
		validacion:{
			name:'reporte',
			fieldLabel:'Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['desc','Reporte Descuentos de Atrasos'],['det','Detalle Personal Planta']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'reporte'
	};
	vectorAtributos[2]={
		validacion:{
			name:'formato_reporte',
			fieldLabel:'Formato Reporte',
			vtype:'texto',
			emptyText:'Elija el Formato del Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF'],['excel','EXCEL']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'formato_reporte'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Datos de Consulta"};
	layout_rep_funcionarios=new DocsLayoutProceso(idContenedor);
	layout_rep_funcionarios.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_funcionarios,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	//ds_proveedor.addListener('loadexception',ClaseMadre_conexionFailure);
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{			
				
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
			
	}
	
	
	
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Datos de consulta "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		            url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosDescAtrasos.php',
		            abrir_pestana:true,
		            titulo_pestana:obtenerTitulo,
		            fileUpload:false,columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos para el reporte de Funcionarios',
			        		 columna:0,
			        		 id_grupo:0
			        		}
			        		],
			        parametros:''}
	};
	   
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}