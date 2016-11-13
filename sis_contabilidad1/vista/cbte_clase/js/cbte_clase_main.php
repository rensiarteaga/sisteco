<?php 
/**
 * Nombre:		  	    cbte_clase_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-18 09:21:11
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
var elemento={pagina:new pagina_cbte_clase(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_cbte_clase.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-18 09:21:11
 */
function pagina_cbte_clase(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_clase_cbte',totalRecords:'TotalCount'
		},[		
				'id_clase_cbte',
		'desc_clase',
		'estado_clase',
		'id_documento',
		'desc_documento',
		'titulo_cbte'
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

    var ds_documento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/documento/ActionListarDocumento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_documento',totalRecords: 'TotalCount'},['id_documento','codigo','descripcion','documento','prefijo','sufijo','estado','id_subsistema'])
	});

	//FUNCIONES RENDER
	
	function render_id_documento(value, p, record){return String.format('{0}', record.data['desc_documento']);}
	var tpl_id_documento=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{descripcion}</FONT><br>','<FONT COLOR="#B5A642">{documento}</FONT>','</div>');

	function render_estado_clase(value){
		if(value==1){value='Activo' }
		if(value==2){value='Inactivo' }
		
		return value
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_clase_cbte
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_clase_cbte',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_clase_cbte'
	};
// txt desc_clase
	Atributos[1]={
		validacion:{
			name:'desc_clase',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CBCLAS.desc_clase',
		save_as:'desc_clase'
	};
// txt id_documento
	Atributos[2]={
			validacion:{
			name:'id_documento',
			fieldLabel:'Documento',
			allowBlank:false,			
			emptyText:'Documento...',
			desc: 'desc_documento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_documento,
			valueField: 'id_documento',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'DOCUME.descripcion#DOCUME.documento',
			typeAhead:false,
			tpl:tpl_id_documento,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_documento,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.descripcion',
		save_as:'id_documento'
	};
// txt estado_clase
	Atributos[3]={
		validacion:{
			name:'estado_clase',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Activo'],['2','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_clase,
			grid_editable:false,
			forceSelection:true,
			width:80
		},
		tipo:'ComboBox',
		save_as:'estado_clase',
		defecto:'1'
	};
// txt estado_clase
	Atributos[4]={
		validacion:{
			name:'titulo_cbte',
			fieldLabel:'Titulo Comprobante',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			/*triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.cbte_clase_combo.estado_clase}),
			valueField:'id',
			displayField:'valor',*/
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_clase,
			grid_editable:false,
			forceSelection:true,
			width:200,
			width_grid:200
		},
		tipo:'TextField',
		save_as:'titulo_cbte'
		//defecto:'1'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'cbte_clase',grid_maestro:'grid-'+idContenedor};
	var layout_cbte_clase=new DocsLayoutMaestro(idContenedor);
	layout_cbte_clase.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cbte_clase,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/cbte_clase/ActionEliminarCbteClase.php'},
		Save:{url:direccion+'../../../control/cbte_clase/ActionGuardarCbteClase.php'},
		ConfirmSave:{url:direccion+'../../../control/cbte_clase/ActionGuardarCbteClase.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'cbte_clase'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cbte_clase.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cbte_clase.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}