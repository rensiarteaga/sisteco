/**
 * Nombre:		  	    pagina_factores_kardex.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
 */
function pagina_factores_kardex(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/factores_kardex/ActionListarFactoresKardex.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_factores_kardex',totalRecords:'TotalCount'
		},[		
				'id_factores_kardex','codigo',
			'nombre','valor',
		'estado_reg','descripcion'
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
			name: 'id_factores_kardex',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'fackar.codigo'
		
	};
	
// txt nombre
	Atributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'fackar.nombre'
		
	};

	Atributos[3]={
		validacion:{
			name:'valor',
			fieldLabel:'Valor',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:4,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%'
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'fackar.valor'
	};
	
	Atributos[4]= {
		validacion: {
			name:'estado_reg',			
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		filterColValue:'fackar.estado_reg'		
	};
	
	
	Atributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'fackar.descripcion'
		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Factores Kardex',grid_maestro:'grid-'+idContenedor};
	var layout_factores_kardex=new DocsLayoutMaestro(idContenedor);
	layout_factores_kardex.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_factores_kardex,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/factores_kardex/ActionEliminarFactoresKardex.php'},
		Save:{url:direccion+'../../../control/factores_kardex/ActionGuardarFactoresKardex.php'},
		ConfirmSave:{url:direccion+'../../../control/factores_kardex/ActionGuardarFactoresKardex.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'AFP'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_factores_kardex.getLayout()};
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
	layout_factores_kardex.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}