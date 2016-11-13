/**
 * Nombre:		  	    pagina_responsable_almacen_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-12 15:53:20
 */
function pagina_responsable_almacen(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/responsable_almacen/ActionListarResponsableAlmacen.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_responsable_almacen',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_responsable_almacen',
		'estado',
		'cargo',
		{name: 'fecha_asignacion',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		'id_almacen',
		'desc_almacen',
		'desc_empleado',
		'id_empleado'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'
		}, ['id_almacen','codigo','nombre','descripcion','direccion','via_fil_max','via_col_max','bloqueado','bloquear','cerrado','nro_prest_pendientes','nro_ing_no_finalizados','nro_sal_no_finalizadas','observaciones','fecha_ultimo_inventario','fecha_reg','id_regional'])
	});

    ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex/control/empleado/ActionListarEmpleado.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'
		}, ['id_empleado','id_persona','codigo_empleado'])
	});

	//FUNCIONES RENDER
	
			function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
			function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_responsable_almacen
	//en la posición 0 siempre esta la llave primaria

	var param_id_responsable_almacen = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_responsable_almacen',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_responsable_almacen'
	};
	vectorAtributos[0] = param_id_responsable_almacen;
// txt estado
	var param_estado= {
			validacion: {
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.responsable_almacen_combo.estado
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.estado',
		defecto:'activo',
		save_as:'txt_estado'
	};
	vectorAtributos[1] = param_estado;
// txt cargo
	var param_cargo= {
			validacion: {
			name:'cargo',
			fieldLabel:'Cargo',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.responsable_almacen_combo.cargo
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.cargo',
		defecto:'Jefe de Almacen',
		save_as:'txt_cargo'
	};
	vectorAtributos[2] = param_cargo;
// txt fecha_asignacion
	var param_fecha_asignacion= {
		validacion:{
			name:'fecha_asignacion',
			fieldLabel:'Fecha de Asignación',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.fecha_asignacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_asignacion'
	};
	vectorAtributos[3] = param_fecha_asignacion;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[4] = param_fecha_reg;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[5] = param_observaciones;
// txt id_almacen
	var param_id_almacen= {
			validacion: {
			name:'id_almacen',
			fieldLabel:'Almacen',
			allowBlank:false,			
			emptyText:'Almacen...',
			name: 'id_almacen',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.codigo#ALMACE.nombre#ALMACE.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.codigo',
		defecto: '',
		save_as:'txt_id_almacen'
	};
	vectorAtributos[6] = param_id_almacen;
// txt id_empleado
	var param_id_empleado= {
			validacion: {
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:false,			
			emptyText:'Empleado...',
			name: 'id_empleado',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.id_persona',
		defecto: '',
		save_as:'txt_id_empleado'
	};
	vectorAtributos[7] = param_id_empleado;

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'responsable_almacen',
		grid_maestro:'grid-'+idContenedor
	};
	layout_responsable_almacen = new DocsLayoutMaestro(idContenedor);
	layout_responsable_almacen.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_responsable_almacen,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

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
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+'../../../control/responsable_almacen/ActionEliminarResponsableAlmacen.php'
		},
		Save:{
			url:direccion+'../../../control/responsable_almacen/ActionGuardarResponsableAlmacen.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/responsable_almacen/ActionGuardarResponsableAlmacen.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'responsable_almacen'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_responsable_almacen.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_responsable_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}