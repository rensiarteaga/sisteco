/**
 * Nombre:		  	    pagina_gestion_subsistema.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-12-01 16:05:16
 */
function pagina_gestion_subsistema(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
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
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_gestion',maestro.id_gestion],['Gestión',maestro.gestion],['empresa',maestro.desc_empresa]];
	
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
			fieldLabel:'ID',
			labelSeparator:'',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:true,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_gestion
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
			disabled:false,
			grid_indice:3		
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
			fieldLabel:'Subsistema',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			grid_indice:2		
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
	var layout_gestion_subsistema = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_gestion_subsistema.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_gestion_subsistema,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/gestion_subsistema/ActionEliminarGestionSubsistema.php',parametros:'&id_gestion='+maestro.id_gestion},
	Save:{url:direccion+'../../../control/gestion_subsistema/ActionGuardarGestionSubsistema.php',parametros:'&id_gestion='+maestro.id_gestion},
	ConfirmSave:{url:direccion+'../../../control/gestion_subsistema/ActionGuardarGestionSubsistema.php',parametros:'&id_gestion='+maestro.id_gestion},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'gestion_subsistema'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_gestion:maestro.id_gestion
			}
		};
		this.btnActualizar();
		data_maestro=[['id_gestion',maestro.id_gestion],['Gestión',maestro.gestion],['empresa',maestro.desc_empresa]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
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
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_gestion:maestro.id_gestion
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_gestion_subsistema.getLayout().addListener('layout',this.onResize);
	layout_gestion_subsistema.getVentana(idContenedor).on('resize',function(){layout_gestion_subsistema.getLayout().layout()})
	
}