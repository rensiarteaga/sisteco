/**
 * Nombre:		  	    pensamientoDelDia.js
 * Propósito: 			pagina objeto principal
 * Autor:				Morgan Huascar Checa Lopez
 * Fecha creación:		14/05/2013
 */
function pagina_pensamiento(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/pensamiento_del_dia/ActionListarPensamientoDia.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_pensamiento_dia',totalRecords:'TotalCount'
		},[		
		'id_pensamiento_dia',
		'texto_pensamiento',
		{name: 'fecha_colocado_pensamiento',
		 type:'date',dateFormat:'Y-m-d'},
		 {name: 'fecha_fin',
			 type:'date',dateFormat:'Y-m-d'}
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
			name: 'id_pensamiento_dia',
			inputType:'hidden',
			//fieldLabel:'ID PENSAMIENTO',
			grid_visible:true, 
			width_grid:200,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
	
	// txt nombre
	Atributos[1]={
		validacion:{
			name:'texto_pensamiento',
			fieldLabel:'PENSAMIENTO',
			allowBlank:false,
			maxLength:600,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:500,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PENS.texto_pensamiento'
		
	};

	Atributos[2]= {
		validacion:{
			name:'fecha_colocado_pensamiento',
			fieldLabel:'FECHA REGISTRO',
			allowBlank:false,
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
		filterColValue:'PENS.fecha_colocado_pensamiento',
		dateFormat:'d/m/Y',
		defecto:''
		
	};
	
	Atributos[3]= {
			validacion:{
				name:'fecha_fin',
				fieldLabel:'FECHA LIMITE',
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
			filterColValue:'PENS.fecha_fin',
			dateFormat:'d/m/Y',
			defecto:''
			
		};
	

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
		btnEliminar:{url:direccion+'../../../control/pensamiento_del_dia/ActionEliminarPensamientoDia.php'},
		Save:{url:direccion+'../../../control/pensamiento_del_dia/ActionGuardarPensamientoDia.php'},
		ConfirmSave:{url:direccion+'../../../control/pensamiento_del_dia/ActionGuardarPensamientoDia.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Pensamiento del Día'}};
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
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_obligacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}