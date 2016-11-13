<?php 
/**
 * Nombre:		  	    estado_compra_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 18:25:28
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_estado_compra(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_estado_compra_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 18:34:04
 */
function pagina_estado_compra(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_compra/ActionListarEstadoCompra.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_estado_compra',totalRecords:'TotalCount'
		},[		
				'id_estado_compra',
		'descripcion',
		'proceso_sistema',
		'cronometrable',
		'nombre',
		'tiempo_estimado'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_estado_compra
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_estado_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_estado_compra'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250,
			width:'100%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.descripcion',
		save_as:'txt_descripcion'
	};
// txt proceso_sistema
	Atributos[3]={
			validacion: {
			name:'proceso_sistema',
			fieldLabel:'Proceso de Sistema',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:125,
			minListWidth:100,
			disable:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.proceso_sistema',
		defecto:'si',
		save_as:'txt_proceso_sistema'
	};
// txt cronometrable
	Atributos[4]={
			validacion: {
			name:'cronometrable',
			fieldLabel:'Cronometrable',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			align:'center',
			disable:false,
			grid_indice:5
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.cronometrable',
		defecto:'si',
		save_as:'txt_cronometrable'
	};
// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.nombre',
		save_as:'txt_nombre'
	};
// txt tiempo_estimado
	Atributos[5]={
		validacion:{
			name:'tiempo_estimado',
			fieldLabel:'Tiempo Estimado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:105,
			align:'right',
			width:'100%',
			disable:false,
			grid_indice:6
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.tiempo_estimado',
		save_as:'txt_tiempo_estimado'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'estado_compra',grid_maestro:'grid-'+idContenedor};
	var layout_estado_compra=new DocsLayoutMaestro(idContenedor);
	layout_estado_compra.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_estado_compra,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/estado_compra/ActionEliminarEstadoCompra.php'},
		Save:{url:direccion+'../../../control/estado_compra/ActionGuardarEstadoCompra.php'},
		ConfirmSave:{url:direccion+'../../../control/estado_compra/ActionGuardarEstadoCompra.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Estados de Compra'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_estado_compra.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_estado_compra.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}