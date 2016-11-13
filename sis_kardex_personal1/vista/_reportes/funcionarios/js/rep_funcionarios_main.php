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
var elemento={pagina:new RepFuncionarios(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function RepFuncionarios(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var componentes=new Array();
	//var ContPes=1;
	//var layout_diagrama_uniorg,h_txt_gestion,h_txt_mes,ds_linea;
	// ------------------  PARÁMETROS --------------------------//
	/////DATA STORE////////////
var ds_lugar=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/lugar/ActionListarLugar.php?tipo_reporte_kard=funcionario'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords:'TotalCount'},['id_lugar','codigo','nombre'])
	});
var tplLugar=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','</div>');


	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Regionales',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Regionales...',
			name:'id_lugar',
			desc:'nombre',
			store:ds_lugar,
			valueField:'id_lugar',
			displayField:'nombre',
			queryParam:'filterValue_0',
			//filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:tplLugar,
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
		save_as:'id_lugar',
		tipo:'ComboBox'
	};
	
	
	
	
	vectorAtributos[1]={
		validacion:{
			name              :  'tipo_contrato',
			fieldLabel        : 'Tipo de Contrato',
			dataFields        :  ['cod', 'val'],
			data              :[['planta','Planta'],['consultor','Consultor'],['servicio','Servicio']],
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
	vectorAtributos[3]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['listado','Listado de Personal']
			,['relacion','Relación Contractual']
			]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'tipo_reporte'
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
		            url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosContrato.php',
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