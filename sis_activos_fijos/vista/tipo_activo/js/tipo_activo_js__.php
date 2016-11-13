
//<script>
function PaginaTipoActivo()
{
	var vectorAtributos = new Array;
	var ds;
	var sw=0;

	//Configuración página
	var paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		FiltroAvanzado:true//indica si se tiene los 5 combos que la filtra la estructura programática
	};

	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creación del Data Store

	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	?>

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/tipo_activo/ActionListaTipoActivo.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_tipo_activo',
		'codigo',
		'descripcion',
		'flag_depreciacion',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado',
		'id_metodo_depreciacion',
		'desc_metodo_depreciacion'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////DATA STORE COMBOS////////////
	ds_metodo_depreciacion = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/metodo_depreciacion/ActionListaMetodoDepreciacion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metodo_depreciacion',
			totalRecords: 'TotalCount'

		}, ['id_metodo_depreciacion','descripcion'])

	});

	////////////////FUNCIONES RENDER ////////////
	function renderMetodoDepreciacion(value, p, record){return String.format('{0}', record.data['desc_metodo_depreciacion']);}

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_tipo_activo = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_activo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_activo'
	}
	vectorAtributos[0] = paramId_tipo_activo;

	/////////// txt codigo//////
	var paramCodigo = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:2,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_codigo'
	}
	vectorAtributos[1] = paramCodigo;

	/////////// txt descripcion//////
	var paramDescripcion = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: 300,
			grow: true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:260 // ancho de columna en el gris
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'tip.descripcion',
		save_as:'txt_descripcion'
	}
	vectorAtributos[2] = paramDescripcion;

	/////////// combo flag_depreciacion//////

	var paramFlag_depreciacion = {
		validacion: {
			name: 'flag_depreciacion',
			fieldLabel: 'Depreciable',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['valor', 'flag_depreciacion'],
				data : Ext.tipo_activoCombo.flag_depreciacion // from states.js
			}),
			valueField:'valor',
			displayField:'flag_depreciacion',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:70 // ancho de columna en el grid
		},

		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		defecto: 'si',
		save_as:'txt_flag_depreciacion'

	}
	vectorAtributos[3] = paramFlag_depreciacion;

	/////////// combo estado//////

	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : Ext.tipo_activoCombo.estado // from states.js
			}),
			valueField:'ID',
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
		defecto: 'activo',
		save_as:'txt_estado'
	}
	vectorAtributos[4] = paramEstado;

	/////////// hidden_id_metodo_depreciacion//////

	var paramId_metodo_depreciacion = {
		validacion:{
			fieldLabel: 'Método Depreciación',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Método depreciación...',
			name: 'id_metodo_depreciacion',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_metodo_depreciacion', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_metodo_depreciacion,
			valueField: 'id_metodo_depreciacion',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'descripcion',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderMetodoDepreciacion,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		defecto: '1',
		save_as:'hidden_id_metodo_depreciacion'
	}
	vectorAtributos[5] = paramId_metodo_depreciacion;


	/////////// fecha_reg//////
	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:85, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[6] = paramFecha_reg;



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
		titulo_maestro:"Tipos de Activos Fijos",
		grid_maestro:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	
	//alert(this.SaveAndOther);
	var ClaseMadre_SaveAndOther = this.SaveAndOther; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor


	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
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


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	//datos necesarios para el filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:"../../control/tipo_activo/ActionEliminaTipoActivo.php"
		},
		Save:{
			url:"../../control/tipo_activo/ActionSaveTipoActivo.php"
		},
		ConfirmSave:{
			url:"../../control/tipo_activo/ActionSaveTipoActivo.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true
		}
	}


	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		combo_flag_depreciacion = ClaseMadre_getComponente('flag_depreciacion');
		combo_metodo_depreciacion = ClaseMadre_getComponente('id_metodo_depreciacion');
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		h_txt_codigo = ClaseMadre_getComponente('codigo');

		//Verifica si se escogió 'No depreciable'
		function opcion_deprec()
		{

			if(combo_flag_depreciacion.getValue() == 'si')
			{
				combo_metodo_depreciacion.allowBlank = false;
				combo_metodo_depreciacion.enable();
			}
			else
			{
				combo_metodo_depreciacion.allowBlank = true;////true
				combo_metodo_depreciacion.disable();
				combo_metodo_depreciacion.setValue('');

			}
		}


		//Define los eventos de los componentes para ejecutar acciones
		combo_flag_depreciacion.on('change',opcion_deprec);
		combo_flag_depreciacion.on('select',opcion_deprec);
	}

	//Obtiene la fecha de la base de datos
	function get_fecha_bd()
	{
		var postData;
		postData = "";
		var hcallback =
		{
			success:  cargar_fecha_bd,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};
		YAHOO.util.Connect.asyncRequest('POST', '../../../lib/lib_control/action/ActionObtenerFechaBD.php', hcallback, postData);
	}
	function cargar_fecha_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}

	//sobrecarga


	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		get_fecha_bd();
		
		if (sw==0)
		{
			//Carga el valor por defecto al método de Depreciación Lineal
			var  params = new Array();
			params['id_metodo_depreciacion'] = 1;
			params['descripcion'] = 'Depreciación Lineal';
			var aux = new Ext.data.Record(params,1);
			combo_metodo_depreciacion.store.add(aux)
			combo_metodo_depreciacion.setValue(1);
			sw=1;
		}	
		
		
		
	}

	this.SaveAndOther = function()
	{
		alert ("sobrecarga");
		ClaseMadre_SaveAndOther();
		get_fecha_bd();
	}



	//Abre la ventana de Subtipos de Activos
	function btnSubtipos()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado

			var data = "maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
			data = data + "&maestro_flag_depreciacion=" + SelectionsRecord.data.flag_depreciacion;
			
			//Abre la pestaña del detalle
			Docs.loadTab('../sub_tipo_activo/sub_tipo_activo_det.php?'+data, "Subtipos de Activos Fijos ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//Abre la ventana de TipoActivoProceso
	function btnTipoActivoProceso()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado

			var data = "maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;

			//Abre la pestaña del detalle
			Docs.loadTab('../tipo_activo_proceso/tipo_activo_proceso_det.php?'+data, "Procesos/Cuentas Contables ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//Abre la ventana de Características
	function btnCaracteristicas()
	{
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado

			var data = "maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;

			//Abre la pestaña del detalle
			Docs.loadTab('../caracteristicas/caracteristicas_det.php?'+data, "Características por Tipo ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//


	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnSubtipos,true, 'subtipos','Subtipos de Activos Fijos');
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnTipoActivoProceso,true, 'procesos_cuentas', 'Procesos/Cuentas contables');
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnCaracteristicas,true,'caracteristicas','Características por Tipo');

	this.iniciaFormulario();

	iniciarEventosFormularios();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	//layout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	//innerLayout.addListener('regionresized',this.onResize);//aregla la forma en que se ve el grid dentro del layout




}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaTipoActivo();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo
