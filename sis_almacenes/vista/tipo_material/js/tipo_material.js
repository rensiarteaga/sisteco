function PaginaTipoMaterial(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
		//  DATA STORE //
		ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_material/ActionListarTipoMaterial.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_material',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		{name:'descripcion',type:'string'},
		'id_tipo_material',
		'nombre',
		'descripcion',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'}
		]),
		remoteSort:true // metodo de ordenacion remoto
	});
	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	/////////// hidden id_tipo_material //////
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_material',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_material'
	};
	/////////// txt nombre //////
	vectorAtributos[1] = {
		validacion:{
			name: 'nombre',
			fieldLabel: 'Nombre',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			width: '100%',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:130 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_nombre'
	};
	/////////// txt descripcion //////
	vectorAtributos[2] = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:200,
			minLength:1,
			selectOnFocus:true,
			width: '100%',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_descripcion'
	};
	/////////// txt observaciones //////
	vectorAtributos[3] = {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:100,
			minLength:1,
			selectOnFocus:true,
			width: '100%',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:250 // ancho de columna en el gris
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_observaciones'
	};
	/////////// txt fecha_reg //////
	vectorAtributos[4] = {
			validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			renderer:formatDate,
			width_grid:100, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" 
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Tipo Material",
		grid_maestro:"grid-"+idContenedor
	};
	layout_tipo_material = new DocsLayoutMaestro(idContenedor);
	layout_tipo_material.init(config);


	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_material,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;

	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

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
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+"../../../control/tipo_material/ActionEliminarTipoMaterial.php"
		},
		Save:{
			url:direccion+"../../../control/tipo_material/ActionGuardarTipoMaterial.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/tipo_material/ActionGuardarTipoMaterial.php"
		},
		
	Formulario:{
			html_apply:"dlgInfo"+idContenedor,
			width:'40%',
			height:'50%',
			minWidth:100,
			minHeight:100,
			labelWidth: 80, //ancho del label
			closable:true,
			titulo: "Tipo de Material"
			}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function iniciarPaginaTipoMaterial()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}
	
this.btnNew = function()
	{
		CM_ocultarComponente(componentes[3]);
		ClaseMadre_btnNew();
	}
this.btnEdit = function()
	{
		CM_ocultarComponente(componentes[3]);
		ClaseMadre_btnEdit();
	}

	
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//Se agrega el botón para el acceso al detalle (SuperTipo de Activos)
	this.iniciaFormulario();
	iniciarPaginaTipoMaterial();

	layout_tipo_material.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}