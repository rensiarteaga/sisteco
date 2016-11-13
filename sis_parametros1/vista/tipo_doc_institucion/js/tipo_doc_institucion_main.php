<?php 
/**
 * Nombre:		  	    tipo_doc_institucion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
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
var elemento={pagina:new pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_tipo_doc_institucion_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
 */
function pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_doc_institucion/ActionListarTipoDocInstitucion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_doc_institucion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_doc_institucion',
		'nombre_tipo_doc',
		'observacion'

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
	
	// hidden id_tipo_doc_institucion
	//en la posición 0 siempre esta la llave primaria

	var param_id_tipo_doc_institucion = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_doc_institucion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_doc_institucion'
	};
	vectorAtributos[0] = param_id_tipo_doc_institucion;
// txt nombre_tipo_doc
	var param_nombre_tipo_doc= {
		validacion:{
			name:'nombre_tipo_doc',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIDOINS.nombre_tipo_doc',
		save_as:'txt_nombre_tipo_doc',
		id_grupo:0
	};
	vectorAtributos[1] = param_nombre_tipo_doc;
// txt observacion
	var param_observacion= {
		validacion:{
			name:'observacion',
			fieldLabel:'Observación',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIDOINS.observacion',
		save_as:'txt_observacion',
		id_grupo:0
	};
	vectorAtributos[2] = param_observacion;

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'tipo_doc_institucion',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tipo_doc_institucion=new DocsLayoutMaestro(idContenedor);
	layout_tipo_doc_institucion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_doc_institucion,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/tipo_doc_institucion/ActionEliminarTipoDocInstitucion.php'},
		Save:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		Formulario:{
			titulo:'Tipo de Documentacion de Institución',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'40%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Documentación de Institución',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_doc_institucion.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_tipo_doc_institucion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}