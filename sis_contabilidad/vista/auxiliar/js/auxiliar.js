/**
 * Nombre:		  	    pagina_cuenta_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 11:01:41
 */
function pagina_auxiliar(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_auxiliar',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_auxiliar',
		'codigo_auxiliar',
		'nombre_auxiliar',
		'estado_auxiliar'		
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	function render_estado_auxiliar(value){
		if(value==1){value='Activo' }
		if(value==2){value='Inactivo' }
		
		return value
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_auxiliar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_auxiliar'
	};
// txt nro_cuenta
	vectorAtributos[1]={
		validacion:{
			name:'codigo_auxiliar',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'AUXILI.codigo_auxiliar',
		save_as:'txt_codigo_auxiliar'
	};
	 // txt descripcion
	vectorAtributos[2]={
		validacion:{
			name:'nombre_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			width:'100%',
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'AUXILI.nombre_auxiliar',
		save_as:'txt_nombre_auxiliar'
	};
	 // txt estado
	vectorAtributos[3]={
		validacion:{
			name:'estado_auxiliar',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Activo'],['2','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_auxiliar,
			grid_editable:false,
			forceSelection:true,
			width:80
		},
		tipo:'ComboBox',
		save_as:'txt_estado_auxiliar',
		defecto:'1'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	var config={titulo_maestro:'Auxiliar',grid_maestro:'grid-'+idContenedor};
	var layout_auxiliar=new DocsLayoutMaestro(idContenedor);
	layout_auxiliar.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_auxiliar,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/auxiliar/ActionEliminarAuxiliar.php'},
		Save:{url:direccion+'../../../control/auxiliar/ActionGuardarAuxiliar.php'},
		ConfirmSave:{url:direccion+'../../../control/auxiliar/ActionGuardarAuxiliar.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Auxiliar'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_auxiliar.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	
	function btn_reporte(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				//g_gestion=gestion_combo.getValue();
				//if(NumSelect!=0){
				//	var SelectionsRecord=sm.getSelected();
					//var data='&txt_gestion='+gestion_combo.getValue();
													//control/_reportes/relacionar_cuenta_partida/PDFTipoServicioCuentaPartida.php
					window.open(direccion+'../../../control/auxiliar/ActionReporteAuxiliar.php')	;		
	}	
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Auxiliar',btn_reporte,true,'ver_reporte','Reporte');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_auxiliar.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}