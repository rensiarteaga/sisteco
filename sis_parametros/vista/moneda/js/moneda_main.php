<?php 
/**
 * Nombre:		  	    moneda_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_moneda(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_moneda_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 */
function pagina_moneda(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	
	
	
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/moneda/ActionListarMoneda.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_moneda',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_moneda',
			'nombre',
			'simbolo',
			'estado',
			'origen',
			'prioridad'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//Sirve para mostrar los datos en el grid	
	function renderPrioridad(value, p, record){
		if(value == 1)
		{return "Moneda Base"}
		if(value == 2)
		{return "Presupuestar y Contabilizar"}
		if(value == 3)
		{return "Contabilizar"}
		if(value == 4)
		{return "No Definida"}
		}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_moneda'
	};
	 
// txt nombre
	vectorAtributos[1]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	
// txt simbolo
	vectorAtributos[2]= {
		validacion:{
			name:'simbolo',
			fieldLabel:'Simbolo',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.simbolo',
		save_as:'txt_simbolo',
		id_grupo:0
	};
	
	// txt prioridad
	/*vectorAtributos[3]= {
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.prioridad',
		save_as:'txt_prioridad',
		id_grupo:1 
	};*/
	
	// txt prioridad
	vectorAtributos[3]={
		validacion: {
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:true,
			emptyText:'Prioridad...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Moneda Base'],['2','Presupuestar y Contabilizar'],['3','Contabilizar']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPrioridad,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			minListWidth:100,
			disable:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MONEDA.prioridad',
		defecto:1,
		save_as:'txt_prioridad',
		id_grupo:1 
	};		
	

// txt origen
	vectorAtributos[4]= {
			validacion: {
			name:'origen',
			fieldLabel:'Origen',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['Nacional','Nacional'],['Extranjera','Extranjera']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.origen',
		defecto:'nacional',
		save_as:'txt_origen',
		id_grupo:1
	};
	
// txt estado
	vectorAtributos[5]= {
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['Activo','Activo'],['Inactivo','Inactivo'],['Eliminado','Eliminado']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			disabled:true,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MONEDA.estado',
		defecto:'activo',
		save_as:'txt_estado',
		id_grupo:1
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'moneda',
		grid_maestro:'grid-'+idContenedor
	};
	layout_moneda=new DocsLayoutMaestro(idContenedor);
	layout_moneda.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_moneda,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/moneda/ActionEliminarMoneda.php'},
		Save:{url:direccion+'../../../control/moneda/ActionGuardarMoneda.php'},
		ConfirmSave:{url:direccion+'../../../control/moneda/ActionGuardarMoneda.php'},
		Formulario:{
			titulo:'Moneda',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'48%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Moneda',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Origen-Estado-Prioridad',
				columna:0,
				id_grupo:1
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_tipo_cambio(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
	      if(NumSelect!=0){
			  var SelectionsRecord=sm.getSelected();
			  var data='m_id_moneda='+SelectionsRecord.data.id_moneda;
			  data=data+'&m_nombre='+SelectionsRecord.data.nombre;
 			  var ParamVentana={ventana:{width:400,height:1000}}
			  layout_moneda.loadWindows(direccion+'../../../vista/tipo_cambio/tipo_cambio_det.php?'+data,'Tipo de Cambio',ParamVentana);
 			  layout_moneda.getVentana().on('resize',function(){
			  layout_moneda.getLayout().layout()
				})
			}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_moneda.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Tipo de Cambio',btn_tipo_cambio,true,'tipo_cambio','Tipo de Cambio');

	this.iniciaFormulario();
	layout_moneda.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}