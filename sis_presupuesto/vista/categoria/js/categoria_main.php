<?php 
/**
 * Nombre:		  	    categoria_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-04 08:54:27
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
var elemento={pagina:new pagina_categoria(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_categoria.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-04 08:54:27
 */
function pagina_categoria(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria/ActionListarCategoria.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_categoria',totalRecords:'TotalCount'
		},[		
		'id_categoria',
		'desc_categoria',
		'cod_categoria',
		'estado'
		]),remoteSort:true,baseParams:{vista:'categoria'}});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	function render_estado(value, p, record){
		
		if(record.get('estado')=='activo'){
			return String.format('{0}', 'Activo');
         
         } 
		else{
			return String.format('{0}', 'Inactivo');
		
			
		}
		
	}
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_categoria
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_categoria',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_categoria'
	};
	// txt desc_categoria
	Atributos[1]={
		validacion:{
			name:'cod_categoria',
			fieldLabel:'Código Categoría',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'85%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.cod_categoria',
		save_as:'cod_categoria'
	};
// txt desc_categoria
	Atributos[2]={
		validacion:{
			name:'desc_categoria',
			fieldLabel:'Descripción Categoría',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'85%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.desc_categoria',
		save_as:'desc_categoria'
	};
	Atributos[3]={
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				renderer:render_estado,
				disabled:false		
			},
			tipo: 'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CATEGO.estado',
			defecto:'activo'
			//id_grupo:1		
		};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Categoría Viajes',grid_maestro:'grid-'+idContenedor};
	var layout_categoria=new DocsLayoutMaestro(idContenedor);
	layout_categoria.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_categoria,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/categoria/ActionEliminarCategoria.php'},
		Save:{url:direccion+'../../../control/categoria/ActionGuardarCategoria.php'},
		ConfirmSave:{url:direccion+'../../../control/categoria/ActionGuardarCategoria.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Categoría Viajes'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_destino(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_categoria='+SelectionsRecord.data.id_categoria;
			data=data+'&m_desc_categoria='+SelectionsRecord.data.desc_categoria;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_categoria.loadWindows(direccion+'../../../../sis_presupuesto/vista/destino/destino.php?'+data,'Destinos de Viaje',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_categoria.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Detalle de destinos',btn_destino,true,'destino','Destinos de Viaje');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_categoria.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}