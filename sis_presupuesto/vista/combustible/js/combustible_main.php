<?php 
/**
 * Nombre:		  	    combustible_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-04 11:21:47
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
var elemento={pagina:new pagina_combustible(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_combustible.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-04 11:21:47
 */
function pagina_combustible(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/combustible/ActionListarCombustible.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_combustible',totalRecords:'TotalCount'
		},[		
		'id_combustible',
		'id_parametro',
		'desc_parametro',
		'id_moneda',
		'desc_moneda',
		'consumo_preferencial',
		'precio_preferencial',
		'descripcion',
		'precio_mercado'])	,remoteSort:true}); //,baseParams:{id_parametro: null}

	
	//DATA STORE COMBOS

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','desc_estado_gral','cod_institucional','porcentaje_sobregiro','niveles_recurso','cod_formulario_gasto','cod_formulario_recurso','id_gestion','niveles_gasto'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		//var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion_pres}</FONT><br>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');
		//var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		//var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_combustible
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_combustible',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_combustible'
	};
	
// txt descripcion
	Atributos[1]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'COMBUS.descripcion',
		save_as:'descripcion'
	};	
	
// txt id_parametro
	Atributos[2]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
// txt id_moneda
	Atributos[3]={
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
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
// txt consumo_preferencial
	Atributos[4]={
		validacion:{
			name:'consumo_preferencial',
			fieldLabel:'Consumo Preferencial',
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
			width_grid:170,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'COMBUS.consumo_preferencial',
		save_as:'consumo_preferencial'
	};
// txt precio_preferencial
	Atributos[5]={
		validacion:{
			name:'precio_preferencial',
			fieldLabel:'Precio Preferencial',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:4,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:170,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'COMBUS.precio_preferencial',
		save_as:'precio_preferencial'
	};
	// txt precio_preferencial
	Atributos[6]={
		validacion:{
			name:'precio_mercado',
			fieldLabel:'Precio Mercado',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:4,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:170,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'COMBUS.precio_mercado',
		save_as:'precio_mercado'
	};
// txt descripcion
	Atributos[1]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'COMBUS.descripcion',
		save_as:'descripcion'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Combustible',grid_maestro:'grid-'+idContenedor};
	var layout_combustible=new DocsLayoutMaestro(idContenedor);
	layout_combustible.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_combustible,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/combustible/ActionEliminarCombustible.php'},
		Save:{url:direccion+'../../../control/combustible/ActionGuardarCombustible.php'},
		ConfirmSave:{url:direccion+'../../../control/combustible/ActionGuardarCombustible.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Combustible o Lubricante'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_combustible.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_combustible.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}