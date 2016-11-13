<?php 
/**
 * Nombre:		  	    proceso_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-10-13 17:05:17
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
    echo "var usuario='$usuario';"
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_proceso(idContenedor,direccion,paramConfig, usuario),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_proceso.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-10-13 17:05:17
 */
function pagina_proceso(idContenedor,direccion,paramConfig,usuario){
	//alert("llega js");
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso/ActionListarProceso.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_proceso',totalRecords:'TotalCount'
		},[		
				'id_proceso',
		'descripcion',
		'codigo',
		'sw_aprobar',
		'sw_contabilizar',
		'sw_registrar',
		'sw_bien_responsabilidad'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_proceso
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_proceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt descripcion
	Atributos[1]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:100,
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'descripcion'
		 
	};
// txt codigo
	Atributos[2]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'codigo'
		
	};
// txt sw_aprobar
	Atributos[3]={
			validacion: {
			name:'sw_aprobar',
			fieldLabel:'Se aprueba',
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
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		defecto:'si'
	};
	
	// txt sw_contabilizar
	Atributos[4]={
			validacion: {
			name:'sw_contabilizar',
			fieldLabel:'Se contabiliza',
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
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		defecto:'si'
	};
	
	// txt sw_contabilizar
	Atributos[5]={
			validacion: {
			name:'sw_registrar',
			fieldLabel:'Se registra',
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
			disabled:false,
			grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		defecto:'si'
	};
	
	// txt sw_bien_responsabilidad
	Atributos[6]={
			validacion: {
			name:'sw_bien_responsabilidad',
			fieldLabel:'Bienes bajo resp.',
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
			disabled:false,
			grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		defecto:'si'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'proceso',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/proceso_tipo_cuenta/proceso_tipo_cuenta.php'};
	var layout_proceso=new DocsLayoutMaestroDeatalle(idContenedor);
	
	layout_proceso.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_proceso,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_enableSelect=this.EnableSelect;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodo=this.ocultarTodosComponente
	var CM_mostrarTodo=this.motrarTodosComponente;
	var getFormulario=this.getFormulario;
	
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
		btnEliminar:{url:direccion+'../../../control/proceso/ActionEliminarProceso.php'},
		Save:{url:direccion+'../../../control/proceso/ActionGuardarProceso.php'},
		ConfirmSave:{url:direccion+'../../../control/proceso/ActionGuardarProceso.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso'}};
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
		_CP.getPagina(layout_proceso.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_proceso.getIdContentHijo()).pagina.desbloquearMenu();

	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	//alert(idContenedor);
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_proceso.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	function enable(sel,row,selected){
		var record=selected.data;
		CM_enableSelect(sel,row,selected)
	}
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_proceso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
}

