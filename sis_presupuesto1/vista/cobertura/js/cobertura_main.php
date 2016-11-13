<?php 
/**
 * Nombre:		  	    cobertura_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-04 09:53:09
 *
 */
session_start();
?>
//<script>
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
var elemento={pagina:new pagina_cobertura(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_cobertura.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-04 09:53:09
 */
function pagina_cobertura(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cobertura/ActionListarCobertura.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cobertura',totalRecords:'TotalCount'
		},[		
		'id_cobertura',
		'porcentaje',
		'sw_hotel',
		'descripcion',
		'via'
		
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
	
	function renderSwHotel(value, p, record){
		if(value == 1)
		{return "SI"}
		if(value == 2)
		{return "NO"}};
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cobertura
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cobertura',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cobertura'
	};
// txt porcentaje
	Atributos[1]={
		validacion:{
			name:'porcentaje',
			fieldLabel:'Porcentaje (%)',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.porcentaje',
		save_as:'porcentaje'
	};
// txt sw_hotel
	Atributos[2]={
		validacion: {
			name:'sw_hotel',
			fieldLabel:'Hotel',
			allowBlank:false,
			emptyText:'Hotel...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','SI'],['2','NO']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderSwHotel,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			minListWidth:100,
			disable:false
			//grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DESTIN.sw_hotel',
		defecto:1,
		save_as:'sw_hotel'
	};	
	
	// txt desc_categoria
	Atributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción Porcentaje',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'85%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.descripcion',
		save_as:'descripcion'
	};
	Atributos[4]={
			validacion: {
				name:'via',
				fieldLabel:'Via',
				allowBlank:false,
				emptyText:'Via...',
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['aereo','Aereo'],['terrestre','Terrestre']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				//renderer: renderSwHotel,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				minListWidth:100,
				disable:false
				//grid_indice:2
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'COBERT.via',
			defecto:1,
			save_as:'via'
		};	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'cobertura',grid_maestro:'grid-'+idContenedor};
	var layout_cobertura=new DocsLayoutMaestro(idContenedor);
	layout_cobertura.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cobertura,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/cobertura/ActionEliminarCobertura.php'},
		Save:{url:direccion+'../../../control/cobertura/ActionGuardarCobertura.php'},
		ConfirmSave:{url:direccion+'../../../control/cobertura/ActionGuardarCobertura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Cobertura'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cobertura.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cobertura.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}