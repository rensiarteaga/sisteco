//<script>
function PaginaSubtipoActivo()
{
	var vectorAtributos = new Array;
	var ds;
	var fecha;

	//Configuración Página
	paramConfig = {
		TamanoPagina:15, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false//indica si se tiene los 5 combos que la filtra la estructura programática
		//FiltroAvanzado:true
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
		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_sub_tipo_activo',
		'codigo',
		'descripcion',
		'vida_util',
		'tasa_depreciacion',
		'ini_correlativo',
		'correlativo_act',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'estado',
		'id_tipo_activo',
		'desc_tipo_activo',
		'id_auxiliar_tmp',
		'desc_auxiliar'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_tipo_activo: $("maestro_id_tipo_activo").value
		}
	});
	/*
	ds.lastOptions = new Array();
	ds.lastOptions.params = {
	start:0,
	limit:10,
	CantFiltros:2
	}
	*/
	
	ds_auxiliar = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../control/auxiliar/ActionListaAuxiliarCom.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id',
			totalRecords: 'TotalCount'

		}, ['id','id_auxiliar','descrip','operativo','transac','valido','grupo','desc_auxiliar'])

	});

	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}


	//////////////////////////////////////////////////////////////
	//        DEFINICIÓN DATOS DEL MAESTRO                     //
	//////////////////////////////////////////////////////////////

	////////// INICIA MAESTRO ///////////////////////
	var dataMaestro = [
	//['ID',$("maestro_id_tipo_activo").value],
	['Código Tipo de Activo',$("maestro_codigo").value],
	['Descripción',$("maestro_descripcion").value],
	['Depreciable',$("maestro_flag_depreciacion").value]
	];

	var dsMaestro = new Ext.data.Store({
		proxy: new Ext.data.MemoryProxy(dataMaestro),
		reader: new Ext.data.ArrayReader({id: 0}, [
		{name: 'atributo'},
		{name: 'valor'}

		])
	});
	dsMaestro.load();

	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);

	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>' + value + '<i>';
	}

	// create the Grid
	var gridMaestro = new Ext.grid.Grid('maestro', {
		ds: dsMaestro,
		cm: cmMaestro
	});

	gridMaestro.render();


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_sub_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_sub_tipo_activo = {
		validacion:{
			labelSeparator:'',
			name: 'id_sub_tipo_activo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_sub_tipo_activo'
	}
	vectorAtributos[0] = paramId_sub_tipo_activo;

	/////////// txt codigo//////
	var paramCodigo = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:3,
			minLength:3,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sub.codigo',//  XX.descripcion
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
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:300, // ancho de columna en el gris
			width: 220
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'sub.descripcion',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_descripcion'
	}
	vectorAtributos[2] = paramDescripcion;

	/////////// txt vida_util//////
	var paramVida_util = {
		validacion:{
			name: 'vida_util',
			fieldLabel: 'Vida útil (meses)',
			allowBlank: false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 1,
			minText:3,
			len:3,
			validationDelay:3,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:90 // ancho de columna en el gris

		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'vida_util',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_vida_util'
	}
	vectorAtributos[3] = paramVida_util;

	/////////// txt tasa_depreciacion//////
	var paramTasa_depreciacion = {
		validacion:{
			name: 'tasa_depreciacion',
			fieldLabel: '% Tasa depreciación (mensual)',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:160, // ancho de columna en el gris
			disabled: true,
			width: 60
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'tasa_depreciacion',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_tasa_depreciacion'
	}
	vectorAtributos[4] = paramTasa_depreciacion;

	/////////// txt ini_correlativo//////
	var paramIni_correlativo = {
		validacion:{
			name: 'ini_correlativo',
			fieldLabel: 'Inicio Correlativo',
			allowBlank: false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'ini_correlativo',//  XX.descripcion
		filtro_1:true,
		defecto:1,
		save_as:'txt_ini_correlativo'
	}
	vectorAtributos[5] = paramIni_correlativo;

	/////////// txt correlativo_act//////
	var paramCorrelativo_act = {
		validacion:{
			name: 'correlativo_act',
			fieldLabel: 'Correlativo Actual',
			allowBlank: false,
			maxLength:6,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'correlativo_act',//  XX.descripcion
		filtro_1:true,
		defecto:1,
		save_as:'txt_correlativo_act'
	}
	vectorAtributos[6] = paramCorrelativo_act;

	///////////////txt id_tipo_activo///////////
	var paramId_tipo_activo = {
		validacion:{
			name: 'id_tipo_activo',
			//fieldLabel: 'Id Tipo Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'txt_id_tipo_activo',
		defecto: $("maestro_id_tipo_activo").value
	}
	vectorAtributos[7] = paramId_tipo_activo;

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
				fields: ['activo', 'inactivo', 'eliminado'],
				data : Ext.sub_tipo_activoCombo.estado // from states.js
			}),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:70 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.estado',
		defecto:'activo',
		save_as:'txt_estado'

	}
	vectorAtributos[8] = paramEstado;

	/////////// fecha_reg//////
	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDays: [0, 6],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:85, // ancho de columna en el grid
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto: '' // valor por default para este campo
	};
	vectorAtributos[9] = paramFecha_reg;
	
	/////////// txt_id_auxiliar//////
	var paramId_auxiliar_tmp = {
		validacion:{
			fieldLabel: 'Auxiliar',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Auxiliar...',
			name: 'id_auxiliar_tmp',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_auxiliar',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id',
			displayField: 'desc_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'id_auxiliar',
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
			renderer: renderAuxiliar,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'txt_id_auxiliar_tmp',
		filterColValue:'descrip'
	}
	vectorAtributos[10] = paramId_auxiliar_tmp;




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
		titulo_maestro:"Tipo de Activo Fijo (Maestro)",
		titulo_detalle:"Subtipos de Activos Fijos (Detalle)",
		grid_maestro:"maestro",
		grid_detalle:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);

	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnEdit = this.btnEdit;


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


	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_ini_correlativo = ClaseMadre_getComponente('ini_correlativo');
		h_txt_correlativo_act = ClaseMadre_getComponente('correlativo_act');
		h_txt_codigo = ClaseMadre_getComponente('codigo');
		h_txt_fecha_reg = ClaseMadre_getComponente('fecha_reg');
		h_txt_vida_util = ClaseMadre_getComponente('vida_util');
		h_txt_tasa_depreciacion = ClaseMadre_getComponente('tasa_depreciacion');

		//Copia el mismo valor de ini_correlativo a correlativo_act
		function copiar_ini_correlativo(resp)
		{
			h_txt_correlativo_act.setValue(h_txt_ini_correlativo.getValue());
		}


		//Calcula la tasa de depreciación en función de la vida útil introducida
		function calcular_tasa_dep()
		{
			if(h_txt_vida_util.getValue() != undefined && h_txt_vida_util.getValue() != null)
			{
				if(h_txt_vida_util.getValue() != "")
				{
					h_txt_tasa_depreciacion.setValue(redondear(100/h_txt_vida_util.getValue(),2));
				}
				else
				{
					h_txt_tasa_depreciacion.setValue("");
				}
			}
			else
			{
				h_txt_tasa_depreciacion.setValue("");
			}
		}

		//Define los eventos de los componentes para ejecutar acciones
		//h_txt_codigo.on('valid', get_fecha_bd);
		h_txt_ini_correlativo.on('change',copiar_ini_correlativo);
		h_txt_vida_util.on('valid',calcular_tasa_dep);
	}




	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:"../../control/sub_tipo_activo/ActionEliminaSubtipoActivo.php"
		},
		Save:{
			url:"../../control/sub_tipo_activo/ActionSaveSubtipoActivo.php"
		},
		ConfirmSave:{
			url:"../../control/sub_tipo_activo/ActionSaveSubtipoActivo.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:400,
			height:430,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[350],
			grupos:[
			{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	}


	//Función que obtiene la fecha de la base de datos

	function get_fecha_bd()
	{
		var hcallback =
		{
			success:  cargar_fecha_bd,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};

		YAHOO.util.Connect.asyncRequest('GET', '../../../lib/lib_control/action/ActionObtenerFechaBD.php', hcallback);
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()=="")
			{
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}
	
	function subtip_deprec()
	{
		if($("maestro_flag_depreciacion").value == "no")
		{
			h_txt_vida_util.allowBlank = true;
			h_txt_vida_util.setValue("");
			h_txt_vida_util.disable();
		}
		else
		{
			h_txt_vida_util.allowBlank = false;
			h_txt_vida_util.enable();
		}
	}

	//sobrecarga


	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		get_fecha_bd();
		subtip_deprec();
	}
	
	this.btnEdit = function()
	{
		ClaseMadre_btnEdit();
		subtip_deprec();
	}


	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
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
			data = data + "&maestro_id_sub_tipo_activo=" + SelectionsRecord.data.id_sub_tipo_activo;

			//Abre la pestaña del detalle
			Docs.loadTab('../caracteristicas/caracteristicas_det.php?'+data, "Características por SubTipo ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnCaracteristicas,true,'caracteristicas','Características por Subtipo');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();

	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	
	



}


var obj_pagina;
function main ()
{
	//Carga la página
	obj_pagina = new PaginaSubtipoActivo();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo