<?php 
/**
 * Nombre:		  	    eeff_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-02 11:34:33
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
var elemento={pagina:new pagina_eeff(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_eeff.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-02 11:34:33
 */
function pagina_eeff(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'
		},[		
				'id_reporte_eeff',
		'nombre_eeff'
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
	// Definición de datos //
	
	// hidden id_reporte_eeff
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_reporte_eeff',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_reporte_eeff'
	};
// txt nombre_eeff
	Atributos[1]={
		validacion:{
			name:'nombre_eeff',
			fieldLabel:'Reporte EEFF',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'REPOEF.nombre_eeff',
		save_as:'nombre_eeff'
	};

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'eeff',grid_maestro:'grid-'+idContenedor};
	var layout_eeff=new DocsLayoutMaestro(idContenedor);
	layout_eeff.init(config);

	// INICIAMOS HERENCIA //
	
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_eeff,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	
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
		btnEliminar:{url:direccion+'../../../control/reporte_eeff/ActionEliminarEeff.php'},
		Save:{url:direccion+'../../../control/reporte_eeff/ActionGuardarEeff.php'},
		ConfirmSave:{url:direccion+'../../../control/reporte_eeff/ActionGuardarEeff.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'eeff'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_rubro(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_reporte_eeff='+SelectionsRecord.data.id_reporte_eeff;
			data=data+'&m_nombre_eeff='+SelectionsRecord.data.nombre_eeff;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_eeff.loadWindows(direccion+'../../../../sis_contabilidad/vista/rubro/rubro.php?'+data,'Rubro',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_eeff.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Rubro',btn_rubro,true,'rubro','');
		//this.AdicionarBotonCalculadora('calculadora');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_eeff.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}