/**
 * Nombre:		  	    sistemasInformaticos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Morgan Huascar Checa Lopez
 * Fecha creación:		14/05/2013
 */
function pagina_tipo_obligacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sistemas_informaticos/ActionListarSistemaInformatico.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_sistema_informatico',totalRecords:'TotalCount'
		},[		
		'id_sistema_informatico',
		'nombre_sistema_informatico',
		'enlace_sistema',
		'sistema',
		{name: 'sis_fecha_registro',
			 type:'date',dateFormat:'Y-m-d'},
		]),remoteSort:true});

	//FUNCIONES RENDER
	function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else if(value=='inactivo'){value='Inactivo'	}
		return value
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna_tipo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_sistema_informatico',
			inputType:'hidden',
			//fieldLabel:'ID SISTEMA',
			grid_visible:true, 
			width_grid:200,
			grid_editable:false
		},
		tipo: 'Field',
		//form:false,
		filtro_0:false
		
	};
	
	// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre_sistema_informatico',
			fieldLabel:'NOMBRE SISTEMA',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SIST.nombre_sistema_informatico'
		
	};
	
	// txt nombre
	Atributos[2]={
		validacion:{
			name:'enlace_sistema',
			fieldLabel:'ENLACE ',
			allowBlank:false,
			maxLength:350,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:350,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SIST.enlace_sistema'
		
	};
	
	Atributos[3]= {
			validacion:{
				name:'sis_fecha_registro',
				fieldLabel:'FECHA REGISTRO',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:120,
				disabled:false		
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SIST.sis_fecha_registro',
			dateFormat:'d/m/Y',
			defecto:''
			
		};
	
	Atributos[4] = {
			validacion: {
				name: 'sistema',
				fieldLabel: 'SISTEMA',
				allowBlank: false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['1', 'SI'],['2','NO']]
				}),
				valueField:'valor',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto: 'SI',
			save_as:'txt_sistema'
		}

	
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'columna_tipo',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_obligacion=new DocsLayoutMaestro(idContenedor);
	layout_tipo_obligacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_obligacion,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/sistemas_informaticos/ActionEliminarSistemaInformatico.php'},
		Save:{url:direccion+'../../../control/sistemas_informaticos/ActionGuardarSistemaInformatico.php'},
		ConfirmSave:{url:direccion+'../../../control/sistemas_informaticos/ActionGuardarSistemaInformatico.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'SISTEMAS INFORMATICOS'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_obligacion.getLayout()};
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
	layout_tipo_obligacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}