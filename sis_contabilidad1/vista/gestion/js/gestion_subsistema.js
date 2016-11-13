/**
 * Nombre:		  	    pagina_gestion_subsistema.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:16
 */
function pagina_gestion_subsistema(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion_subsistema/ActionListarGestionSubsistema.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_gestion_subsistema',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_gestion_subsistema',
		'id_gestion',
		'desc_gestion',
		'estado_gestion',
		'nombre_largo'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//DATA STORE COMBOS

    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','denominacion','gestion'])
	});

	//FUNCIONES RENDER
	
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{denominacion}</FONT><br>','<FONT COLOR="#B5A642">{gestion}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_gestion_subsistema
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion_subsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_gestion
	Atributos[1]={
		validacion:{
			name:'id_gestion',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};
// txt estado_gestion
	Atributos[2]={
			validacion: {
			name:'estado_gestion',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['abierto','abierto'],['cerrado','cerrado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'center',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESSIS.estado_gestion',
		defecto:'abierto'
	};
// txt nombre_largo
	Atributos[3]={
		validacion:{
			name:'nombre_largo',
			fieldLabel:'Sistema',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			grid_indice:1		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'SUBSIS.nombre_largo',
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Gestión (Maestro)',titulo_detalle:'gestion_subsistema (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_gestion_subsistema = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_gestion_subsistema.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_gestion_subsistema,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/gestion_subsistema/ActionEliminarGestionSubsistema.php'},
	Save:{url:direccion+'../../../control/gestion_subsistema/ActionGuardarGestionSubsistema.php'},
	ConfirmSave:{url:direccion+'../../../control/gestion_subsistema/ActionGuardarGestionSubsistema.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'gestion_subsistema'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_gestion:maestro.id_gestion
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_gestion;

		paramFunciones.btnEliminar.parametros='&id_gestion='+maestro.id_gestion;
		paramFunciones.Save.parametros='&id_gestion='+maestro.id_gestion;
		paramFunciones.ConfirmSave.parametros='&id_gestion='+maestro.id_gestion;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_gestion_subsistema.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_gestion_subsistema.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}