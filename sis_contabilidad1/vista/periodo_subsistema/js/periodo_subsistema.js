/**
 * Nombre:		  	    pagina_periodo_subsistema.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:15
 */
function pagina_periodo_subsistema(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{ 
var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoSubsistema.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_periodo_subsistema',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_periodo_subsistema',
		'id_periodo',
		'desc_periodo',
		'estado_periodo',
		'nombre_largo'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_periodo',maestro.id_periodo],['gestion',maestro.desc_gestion],['Periodo',maestro.periodo]];
	
	//DATA STORE COMBOS

    var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','denominacion','gestion','periodo'])
	});

	//FUNCIONES RENDER
	
		function render_id_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
		var tpl_id_periodo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{denominacion}</FONT><br>','<FONT COLOR="#B5A642">{gestion}</FONT><br>','<FONT COLOR="#B5A642">{periodo}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_periodo_subsistema
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_periodo_subsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt id_periodo
	Atributos[1]={
		validacion:{
			name:'id_periodo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_periodo
	};
// txt estado_periodo
	Atributos[2]={
			validacion: {
			name:'estado_periodo',
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
			width_grid:80,
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSIS.estado_periodo',
		defecto:'abierto'
	};
// txt nombre_largo
	Atributos[3]={
		validacion:{
			name:'nombre_largo',
			fieldLabel:'Subsistema',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
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
	var config={titulo_maestro:'Periodo (Maestro)',titulo_detalle:'periodo_subsistema (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_periodo_subsistema = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_periodo_subsistema.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_periodo_subsistema,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={ guardar:{crear:true,separador:false},
					nuevo:{crear:true,separador:true},
					editar:{crear:true,separador:false},
					eliminar:{crear:true,separador:false},
					actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/periodo_subsistema/ActionEliminarPeriodoSubsistema.php',parametros:'&id_periodo='+maestro.id_periodo},
	Save:{url:direccion+'../../../control/periodo_subsistema/ActionGuardarPeriodoSubsistema.php',parametros:'&id_periodo='+maestro.id_periodo},
	ConfirmSave:{url:direccion+'../../../control/periodo_subsistema/ActionGuardarPeriodoSubsistema.php',parametros:'&id_periodo='+maestro.id_periodo},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'periodo_subsistema'}};
//DEFINICIONES PROPIAS
	
	
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_periodo:maestro.id_periodo
			}
		};
		this.btnActualizar();
		data_maestro=[['id_periodo',maestro.id_periodo],['gestion',maestro.desc_gestion],['Periodo',maestro.periodo]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_periodo;

		paramFunciones.btnEliminar.parametros='&id_periodo='+maestro.id_periodo;
		paramFunciones.Save.parametros='&id_periodo='+maestro.id_periodo;
		paramFunciones.ConfirmSave.parametros='&id_periodo='+maestro.id_periodo;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_periodo_subsistema.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_periodo:maestro.id_periodo
		}
	});
	
	//para agregar botones
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_periodo_subsistema.getLayout().addListener('layout',this.onResize);
	layout_periodo_subsistema.getVentana(idContenedor).on('resize',function(){layout_periodo_subsistema.getLayout().layout()})
	
}