<?php 
/**
 * Nombre:		  	 	ubicacion_fisica_main.php
 * Proposito: 			pagina que arranca la configuracion de la vista
 * Autor:				unknow
 * Fecha creacion:		05/08/2013		
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:false};
	var elemento={pagina:new pagina_ubicacion_fisica(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);



/**
 * Nombre:		  	    ubicacion.js 
 * PropÃ³sito: 		pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creacion:		05/08/213
 */
function pagina_ubicacion_fisica(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ubicacion/ActionListarUbicacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_ubicacion',totalRecords:'TotalCount'
		},[		
		'id_ubicacion',
		'id_lugar','codigo','ubicacion','estado',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},'desc_lugar'
		]),remoteSort:true});
	
	/////////////////////////
	// definicion de datos //
	/////////////////////////
	
	var ds_lugar= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php?filtro_nivel=3'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_lugar',totalRecords: 'TotalCount'}, ['id_lugar','codigo','nombre','desc_lugar'])
		});
	function render_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
	var tpl_id_lugar=new Ext.Template('<div class="search-item">','<b>{nombre}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	
	// hidden id_param_gral
	//en la posicion 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_ubicacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	Atributos[1]={
			validacion: {
				name: 'desc_lugar',
				fieldLabel: 'Lugar',
				allowBlank: false,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:120, // ancho de columna en el grid
				disabled: false,
				grid_indice:1,
				width:200,
				locked:false
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			filtro_1:false
		};
	Atributos[2] = {
			validacion:{
				fieldLabel: 'Lugar',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Lugar...',
				name: 'id_lugar',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_lugar',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_lugar,
				valueField: 'id_lugar',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'LUGARR.nombre',
				//typeAhead: true,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				renderer: render_id_lugar,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:200, // ancho de columna en el gris
				width:200,
				tpl: tpl_id_lugar,
				grid_indice:2
			},
			tipo: 'ComboBox',
			form:true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'lug.codigo#lug.nombre',
			save_as:'txt_id_lugar'
			
		};
	Atributos[3]={
			validacion: {
				name: 'codigo',
				fieldLabel: 'Codigo',
				allowBlank: false,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:120, // ancho de columna en el grid
				disabled: false,
				grid_indice:3,
				width:200,
				locked:false
			},
			tipo: 'TextField',
			form:true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'UBI.codigo',
			save_as:'txt_codigo'
		};
	Atributos[4]={
			validacion: {
				name: 'ubicacion',
				fieldLabel: 'Ubicacion',
				allowBlank: false,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:300, // ancho de columna en el grid
				disabled: false,
				grid_indice:4,
				width:200,
				locked:false
			},
			tipo: 'TextArea',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'',
			save_as:'txt_ubicacion'
		};
	Atributos[5] = {
			validacion: {
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['activo', 'activo'],['inactivo','inactivo']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				grid_indice:5,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto: 'activo',
			save_as:'txt_estado'
		};
	Atributos[6] = {
			validacion:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha Registro',
				allowBlank: false,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Dia no Valido',
				grid_visible:false, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				renderer: formatDate,
				width_grid:95, // ancho de columna en el gris
				disabled: false,
				grid_indice:6,
			},
			tipo: 'DateField',
			form:false,
			filtro_0:true,
			filtro_1:true,
			filtro_2:true, 
			save_as:'txt_fecha_reg',
			dateFormat:'m-d-Y', //formato de fecha que envÃ­a para guardar
			defecto:"" // valor por default para este campo
		};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Ubicacion Fisica',grid_maestro:'grid-'+idContenedor};
	var layout_param_gral=new DocsLayoutMaestro(idContenedor);
	layout_param_gral.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_param_gral,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;

	///////////////////////////////////
	// DEFINICION DE LA BARRA DE MENU//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICION DE FUNCIONES ------------------------- //
	//   se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ubicacion/ActionEliminarUbicacion.php'},
		Save:{url:direccion+'../../../control/ubicacion/ActionGuardarUbicacion.php'},
		ConfirmSave:{url:direccion+'../../../control/ubicacion/ActionGuardarUbicacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Ubicacion Fisica'}};
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		
	}

	//para que los hijos puedan ajustarse al tamaÃ±o
	this.getLayout=function(){return layout_param_gral.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARAMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
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
	layout_param_gral.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}