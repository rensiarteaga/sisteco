<?php 
/**
 * Nombre:		  	    siet_carga_excel_main.php
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
var elemento={pagina:new pagina_carga_excel(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_carga_excel(idContenedor, direccion, paramConfig, sw_vista) {
	var layout_carga_excel;
	var ContPes = 1;
	var vectorAtributos = new Array;
	var componentes=new Array();
	

	
	// ------------------ PARÁMETROS --------------------------//
	// ///DATA STORE////////////
	

	/////////////////////////
	// Definición de datos //
	/////////////////////////  
	vectorAtributos[0]={
			validacion: {
				name:'subida',
				fieldLabel:'Subir',
				allowBlank:true,
				emptyText:'...',
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['extracto_bancario','Extracto Bancario'],['partidas','Partidas'],['oec','OEC']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
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
			filterColValue:'subida',
			save_as:'subida',
			id_grupo:0 
		};
	
	vectorAtributos[1]= {
			validacion:{
				name: 'txt_archivo',
				fieldLabel: 'Cargar Archivo',
				loadMask: true,
				inputType:'file'
					},
			tipo:'Field',
			save_as:'txt_archivo'	
		};
			
	
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	// --------- INICIAMOS LAYOUT MAESTRO -----------//
	var config = {
		titulo_maestro :"Presupuesto"
	};
	layout_extracto_bancario = new DocsLayoutProceso(idContenedor);
	layout_extracto_bancario.init(config);
	
	// --------- INICIAMOS HERENCIA -----------//
	this.pagina = BaseParametrosReporte;
	this.pagina(paramConfig, vectorAtributos, layout_carga_excel, idContenedor);
	
	// --------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure;
	var getComponente=this.getComponente;
	var CM_getDialog=this.getDialog;
	var CM_formulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	
	// -------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios() {
		subida=ClaseMadre_getComponente('subida');
	}
	function obtenerTitulo() {
		var titulo = "CARGA EXCEL" + ContPes;
		ContPes++;
		return titulo
	}
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------

	var paramFunciones = {
			Formulario:{
				labelWidth: 75, //ancho del label
				url:direccion+"../../../control/interfaz_siet/ActionSubirExcelArchivo.php",
				abrir_pestana:false, //abrir pestana
				titulo_pestana:'Datos para Subir Archivo Excel',
				argument:'',
				fileUpload:true,
				columnas:['70%'],
				
				grupos:[
				{	tituloGrupo:'Datos para Subir Archivo Excel',
					columna:0,
					id_grupo:0
				}
				],
				parametros: ''
	
				
			}
		}
	
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout', this.onResizePrimario)
}