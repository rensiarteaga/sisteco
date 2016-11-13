/**
 * Nombre:		  	    publicaciones.js
 * Propósito: 			pagina objeto principal
 * Autor:				Morgan Huascar Checa Lopez
 * Fecha creación:		14/05/2013
 */
function pagina_publicacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/publicaciones/ActionListarPublicacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_publicacion',totalRecords:'TotalCount'
		},[		
		'id_publicacion',
		'nombre_publicacion',
		'descripcion_publicacion',
		'pub_ruta_imagen',
		'pub_ruta_archivo',
		{name: 'pub_fecha_registro',
		 type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});

	//FUNCIONES RENDER
	function rutaEnlace(val) { if(val!="")

	{return '<a href="'+ direccion+"../../../../../comunidadEnde/vista/archivos/publicaciones/"+val+'" target = "_blank">'+val+'</a>';}}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna_tipo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_publicacion',
			//fieldLabel: 'ID PUBLICACION',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
	},
	tipo: 'Field',
	filtro_0:false
		
	};
	
	// txt nombre
	Atributos[1]={
		validacion:{
			name:'nombre_publicacion',
			fieldLabel:'NOMBRE PUBLICACION',
			allowBlank:false,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PUB.nombre_publicacion'
		
	};

// txt nombre
	Atributos[2]={
		validacion:{
			name:'descripcion_publicacion',
			fieldLabel:'DESCRIPCION PUBLICACION',
			allowBlank:false,
			maxLength:700,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:550,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PUB.descripcion_publicacion'
		
	};
	
	Atributos[3]= {
			validacion: {
				name:'pub_ruta_imagen',			
				fieldLabel:'IMAGEN',
				//lazyRender:true,
				//inputType:'file',
				inputType:'hidden',
				maxLength:250,
				//renderer:render_estado_reg,
				//forceSelection:true,
				grid_visible:false,
				grid_editable:false,
				width_grid:100
				
			},
			tipo:'Field',
			form: true,
			save_as:'txt_imagen'
			//filtro_0:true,		
			//filterColValue:'TOB.estado_reg'		
		};
	
	Atributos[4]= {
		validacion: {
			name:'pub_ruta_archivo',			
			fieldLabel:'ARCHIVO',
			//llowBlank:false,
			lazyRender:true,
			inputType:'file',
			maxLength:250,
			renderer:rutaEnlace,
			//forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
			
		},
		tipo:'Field',
		form: true,
		save_as:'txt_archivo'
		//filtro_0:true,		
		//filterColValue:'TOB.estado_reg'		
	};
	
// txt fecha_reg
	Atributos[5]= {
		validacion:{
			name:'pub_fecha_registro',
			fieldLabel:'FECHA REGISTRO',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:120,
			disabled:false		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PUB.pub_fecha_registro',
		dateFormat:'d-m-Y',
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
		btnEliminar:{url:direccion+'../../../control/publicaciones/ActionEliminarPublicacion.php'},
		Save:{url:direccion+'../../../control/publicaciones/ActionGuardarPublicacion.php'},
		ConfirmSave:{url:direccion+'../../../control/publicaciones/ActionGuardarPublicacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor, height:300, width:480,minWidth:150,minHeight:200, fileUpload:true, upload:true,	closable:true,titulo:'Publicaciones'}};
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