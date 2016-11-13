function pagina_papeleta_pago_sup(idContenedor,direccion,empleado,paramConfig)
{
	var vectorAtributos = new Array;
	var ContPes = 1;
	var cmp_fecha_ini;
	var	cmp_fecha_fin;
	 var cmp_tipo_reporte,cmp_id_empleado,cmp_nombre_usuario;
	 var ds_planilla,ds_empleado;
	 var layout_rep_papeleta_pago;
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////
	
	var ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarFuncionario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','desc_persona','nombre_cargo'])
	});
    var ds_planilla=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/planilla/ActionListarPlanilla.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_planilla',totalRecords:'TotalCount'},['id_planilla','gestion','periodo_lite','resumen_periodo'])
	});
	var tpl_planilla=new Ext.Template('<div class="search-item">','GESTION: {gestion}<br>','<b><FONT COLOR="#B5A642">PERIODO: {periodo_lite}</FONT></b>','</div>');
	var tpl_empleado=new Ext.Template('<div class="search-item">','{desc_persona}</b>','</div>');
	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////
	//Define las columnas a desplegar
	/////////// txt codigo//////
	
		vectorAtributos[0]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'id_empleado',
			desc:'desc_persona',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'FUNCIO.desc_persona', 
			typeAhead:false,
			forceSelection:true,
			tpl:tpl_empleado,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			width:300
		},
		id_grupo:1,
		save_as:'txt_id_empleado',
		tipo:'ComboBox'
	};
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Periodo',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gestión - Periodo...',
			name:'id_planilla',
			desc:'gestion',
			store:ds_planilla,
			valueField:'id_planilla',
			displayField:'resumen_periodo', 
			typeAhead:false,
			forceSelection:true,
			tpl:tpl_planilla,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			width:300
		},
		id_grupo:0,
		save_as:'txt_id_planilla',
		tipo:'ComboBox'
	};
	
	
	
 
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Papeleta de Pago"
	};
	layout_rep_papeleta_pago=new DocsLayoutProceso(idContenedor);
	layout_rep_papeleta_pago.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_papeleta_pago,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../control/planilla/papeleta_pago.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Papeleta de Pago',
			fileUpload:false,
			columnas:['40%','40%'],			
			grupos:[
			{
				tituloGrupo:'Elija la Gestión y Periodo',
				columna:0,
				id_grupo:0
			},
			
			{
				tituloGrupo:'Funcionario',
				columna:1,
				id_grupo:1
			}
			],
			parametros:'',
			
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){			 			
		
		cmp_id_empleado = ClaseMadre_getComponente('id_empleado');
		
		
		
		
	}

	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
