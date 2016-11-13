/**
 * Nombre:		  	    pagina_unidad_organizacional_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 09:24:17
 */
function pagina_nivel_organizacional(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nivel_organizacional/ActionListarNivelOrganizacional.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_nivel_organizacional',totalRecords:'TotalCount'
		},[		
		'id_nivel_organizacional',
		'nombre_nivel',
		'numero_nivel'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	// hidden id_nivel_organizacional
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_nivel_organizacional',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_nivel_organizacional'
	};
// txt nombre_nivel
	Atributos[1]={
		validacion:{
			name:'nombre_nivel',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%',
			disable:false
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'NIVORG.nombre_nivel',
		save_as:'txt_nombre_nivel'
	};
// txt nombre_cargo
	Atributos[2]={
		validacion:{
			name:'numero_nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:false,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false
			},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'UNIORG.nombre_cargo',
		save_as:'txt_numero_nivel'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Nivel Organizacional',grid_maestro:'grid-'+idContenedor};
	var layout_nivel_organizacional=new DocsLayoutMaestro(idContenedor);
	layout_nivel_organizacional.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_nivel_organizacional,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/nivel_organizacional/ActionEliminarNivelOrganizacional.php'},
		Save:{url:direccion+'../../../control/nivel_organizacional/ActionGuardarNivelOrganizacional.php'},
		ConfirmSave:{url:direccion+'../../../control/nivel_organizacional/ActionGuardarNivelOrganizacional.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:300,minWidth:150,minHeight:200,closable:true,titulo:'Nivel Organizacional'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_nivel_organizacional.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	layout_nivel_organizacional.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}