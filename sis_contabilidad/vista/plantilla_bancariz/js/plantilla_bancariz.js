/**
 * Nombre:		  	    pagina_plantilla_bancariz.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-15 18:14:35
 */
function pagina_plantilla_bancariz(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	  
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla_bancariz/ActionListarPlantillaBancariz.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_plantilla_bancariz',totalRecords:'TotalCount'
		},[		
		'id_plantilla_bancariz',
		'codigo',
		'descripcion',
		'id_usuario_reg',
		'login',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});

	
	//DATA STORE COMBOS

	
	//FUNCIONES RENDER
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_plantilla_bancariz
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_plantilla_bancariz',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_plantilla_bancariz'
	};

// txt cantidad_nivel
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		tipo:'TextField',
		save_as:'txt_codigo'
	};
 // txt cantidad_nivel
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:150
		},
		tipo:'TextArea',
		save_as:'txt_descripcion'
	};
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'id_usuario_reg',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_reg'
	};
	Atributos[4]={
		validacion:{
			name:'login',
			fieldLabel:'Usuario Reg',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			grid_visible:true,
			grid_editable:false,
			width:100
		},
		form:false,
		tipo:'TextField'
	};
// txt fecha_fin 
	Atributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		form:false,
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'plantilla_bancariz',grid_maestro:'grid-'+idContenedor};
	var layout_plantilla_bancariz=new DocsLayoutMaestro(idContenedor);
	layout_plantilla_bancariz.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_plantilla_bancariz,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/plantilla_bancariz/ActionEliminarPlantillaBancariz.php'},
		Save:{url:direccion+'../../../control/plantilla_bancariz/ActionGuardarPlantillaBancariz.php'},
		ConfirmSave:{url:direccion+'../../../control/plantilla_bancariz/ActionGuardarPlantillaBancariz.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:350,minWidth:150,minHeight:200,	closable:true,titulo:'plantilla_bancariz'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_plantilla_bancariz.getLayout()};
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
	layout_plantilla_bancariz.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}