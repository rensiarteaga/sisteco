function pagina_tramo(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var vectorAtributos = new Array();
	var layout_tramo;
	var ds; 
	var maestroData;
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tramo/ActionListarTramo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tramo',
			totalRecords: 'TotalCount'}
		,[
		  	// define el mapeo de XML a las etiquetas (campos)
			'id_tramo',
			{name: 'descripcion', type: 'string'},
			'codigo',
			'observaciones',
			'estado',
			'usuario_reg',
			'fecha_reg'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	
	// PARAMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = 
	[
	      {
	    	  validacion : {
					labelSeparator : '',
					name : 'id_tramo',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_tramo'
	      },
	     {
	    	  validacion : {
					name : 'codigo',
					fieldLabel : 'Codigo Tramo',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'tram.codigo',
				form : true,
				save_as : 'txt_codigo'
	     },
	     {
	    	 validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'tram.descripcion',
				form : true,
				save_as : 'txt_descripcion'
	     },
	     {
	    	 validacion : {
					name : 'observaciones',
					fieldLabel : 'Observaciones',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : false,
				filterColValue : 'tram.observaciones',
				form : true,
				save_as : 'txt_observaciones'
	     },
	     {
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 55,
					width : 120
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tram.estado',
				defecto:'activo',
				form : true,
				save_as : 'txt_estado'
			},
			{
				validacion : {
					name :'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'tram.usuario_reg',
				form : false
			},
			{
				validacion : {
					name :'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					align : 'center',
					width_grid : 120
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : false,
				filterColValue : 'tram.fecha_reg',
				dateFormat : 'm-d-Y'
			}
	    
	      
	];

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	// ---------- Inicia Layout ---------------//

	var config={	titulo_maestro:' (Tramo)',
					grid_maestro:'grid-'+idContenedor,
				};

	layout_tramo =new DocsLayoutMaestro(idContenedor);
	layout_tramo.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tramo,idContenedor);

	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_btnEdit=this.btnEdit;
	var enableSelect=this.EnableSelect;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICION DE LA BARRA DE MENU----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
			 
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},

		actualizar:{
			crear :true,
			separador:false
		}

	};
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	};

	function btn_tramo_unidad_constructiva()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tramo='+SelectionsRecord.data.id_tramo;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
		
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_tramo.loadWindows(direccion+'../../../vista/tramo_unidad_constructiva/tramo_unidad_constructiva_det.php?'+data,'Relacion Tramos Unidades Constructivas',ParamVentana);
			layout_tramo.getVentana().on('resize',function(){
				layout_tramo.getLayout().layout();
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  	DEFINICION DE FUNCIONES ------------------------- //
	//  parametrizacion de las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para ell filtro

	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/tramo/ActionEliminarTramo.php'},
		Save:{url:direccion+'../../../control/tramo/ActionGuardarTramo.php'},
		ConfirmSave:{url:direccion+'../../../control/tramo/ActionGuardarTramo.php'},
		
		Formulario:{
			titulo : 'Registro de Tramo',
			html_apply : "dlgInfo-" + idContenedor,
			width : 500,
			height : 420,
			columnas : [ '95%' ],
			closable : true
		}
	};
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	}
	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		
	}
	this.btnEdit =function()
	{
		ClaseMadre_btnEdit();
		
	}
	/*
	this.EnableSelect=function(sm,row,rec)
	{
		enableSelect(sm,row,rec);

		_CP.getPagina(layout_tramo.getIdContentHijo()).pagina.desbloquearMenu();
		_CP.getPagina(layout_tramo.getIdContentHijo()).pagina.reload(rec.data);
				
	};
	*/

	//-------------- FIN DEFINICION DE FUNCIONES PROPIAS --------------//


	//-------------- FIN DEFINICION DE FUNCIONES PROPIAS --------------//
	this.getLayout=function(){return layout_tramo.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_tramo_unidad_constructiva,true,'tramo_unidad_constructiva','Relacion Tramos Unidades Constructivas');
	
	ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});
	
	this.iniciaFormulario();
	
	iniciarEventosFormularios();

	layout_tramo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}