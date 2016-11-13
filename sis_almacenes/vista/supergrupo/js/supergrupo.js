function PaginaSuperGrupo(idContenedor,direccion,paramConfig)
{	
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_supergrupo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_supergrupo',
		'codigo',
		'nombre',
		'descripcion',
		'observaciones',
		'estado_registro',
		{name:'fecha_reg', type:'date', dateFormat: 'Y-m-d'},
		'demasia',
		'registro'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			registro:paramConfig.registro
		}
	});

	/////DATA STORE COMBOS////////////

	/////////// hidden id_supergrupo //////
	//en la posición 0 siempre tiene que estar la llave primaria

	vectorAtributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_supergrupo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_supergrupo'
	};

	vectorAtributos[1] = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:5,
			minLength:1,
			selectOnFocus:true,
			width: 50,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_codigo'
	};

	vectorAtributos[2] = {
		validacion:{
			name: 'nombre',
			fieldLabel: 'Supergrupo',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width: '60%',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:180 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_nombre'
	};

	vectorAtributos[3] = {
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
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_descripcion'
	};

	vectorAtributos[4] = {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:500,
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
		save_as:'txt_observaciones'
	};

	vectorAtributos[5] = {
		validacion: {
			name: 'estado_registro',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : Ext.supergrupoCombo.estado}),
			store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : [['activo', 'activo'],['inactivo', 'inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50, // ancho de columna en el grid
			width:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_estado_registro',
		defecto:"activo"
	};

	vectorAtributos[6] = {
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
			width_grid:90, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:""
	};

	vectorAtributos[7] = {
		validacion: {
			name: 'demasia',
			fieldLabel: 'Con Demasía',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
		//	store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : Ext.supergrupoCombo.demasia}),
			store: new Ext.data.SimpleStore({fields: ['id', 'valor'],data : [['si', 'Si'],['no', 'No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:80, // ancho de columna en el grid
			width:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_demasia',
		defecto:"no"
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
		titulo_maestro:"Super Grupo",
		grid_maestro:"grid-"+idContenedor
	};
	layout_supergrupo = new DocsLayoutMaestro(idContenedor);
	layout_supergrupo.init(config);


	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_supergrupo,idContenedor);

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
			url:direccion+"../../../control/supergrupo/ActionEliminarSuperGrupo.php"
		},
		Save:{
			url:direccion+"../../../control/supergrupo/ActionGuardarSuperGrupo.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/supergrupo/ActionGuardarSuperGrupo.php"
		},

		Formulario:{
			guardar:overloadSave,
			html_apply:"dlgInfo"+idContenedor,
			width:'40%',
			height:'65%',
			minWidth:100,
			minHeight:100,
			labelWidth: 80, //ancho del label
			closable:true,
			titulo: 'Super Grupo'
		}
	};

	function iniciarEventosFormularios()
	{
		txt_nombre = ClaseMadre_getComponente('nombre');
		txt_descripcion=ClaseMadre_getComponente('descripcion');
		var CopiarDescrip=function(e)
		{
			if(txt_nombre.getValue()!='')
			{
				if(txt_descripcion.getValue()=='')
				{
					txt_descripcion.setValue(txt_nombre.getValue());
				}
			}
		}
		txt_nombre.on('blur',CopiarDescrip);
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarPaginaSuperGrupo()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){

			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}
	this.btnNew = function(){
		CM_ocultarComponente(componentes[5]);
		ClaseMadre_btnNew();
	}
	this.btnEdit = function()
	{	CM_ocultarComponente(componentes[5]);
	ClaseMadre_btnEdit();
	}
	function overloadSave(a,b){
		arr={registro:paramConfig.registro};
		ClaseMadre_save(a,b,arr);
	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//Se agrega el botón para el acceso al detalle (SuperTipo de Activos)
	this.iniciaFormulario();
	iniciarEventosFormularios();
	iniciarPaginaSuperGrupo();

	layout_supergrupo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
	//ds.lastOptions.params.push("registro:1")
	
}