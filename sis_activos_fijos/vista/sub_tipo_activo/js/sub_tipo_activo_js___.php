//<script>
function PaginaSubtipoActivo()
{
	var vectorAtributos = new Array;
	var ds;

	//Configuración Página
	var paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		//FormularioEstructura:true,//indica si se tiene el los 5 combos de la estructura programatica en los formulario para que sean incluidos en las modificaciiones e iliminaciones
		FiltroAvanzado:true,
		grid_html:'ext-grid'
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
			CantFiltros:paramConfig.CantFiltros
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
		proxy: new Ext.data.HttpProxy({url: '../../control/auxiliar/ActionListaAuxiliar.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_auxiliar',
			totalRecords: 'TotalCount'

		}, ['id_auxiliar','descrip','operativo','transac','valido','grupo'])

	});

	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}

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
		filtro_0:true,
		save_as:'hidden_id_sub_tipo_activo'
	}
	vectorAtributos[0] = paramId_sub_tipo_activo;

	/////////// txt codigo//////
	var paramCodigo = {
		validacion:{
			name: 'codigo',
			fieldLabel: 'Código',
			allowBlank: false,
			maxLength:4,
			minLength:4,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
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
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
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
			fieldLabel: 'Vida útil',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
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
			fieldLabel: 'Tasa depreciación',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			maxValue: 1,
			decimalPrecision : 2,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'NumberField',
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
			maxLength:6,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'ini_correlativo',//  XX.descripcion
		filtro_1:true,
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
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			disabled: true
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'correlativo_act',//  XX.descripcion
		filtro_1:true,
		save_as:'txt_correlativo_act'
	}
	vectorAtributos[6] = paramCorrelativo_act;

	///////////////txt id_tipo_activo///////////
	var paramId_tipo_activo = {
		validacion:{
			name: 'id_tipo_activo',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'txt_id_tipo_activo'
	}
	vectorAtributos[7] = paramId_tipo_activo;


	/////////////txt desc_tipo_activo
	var paramDesc_tipo_activo = {
		validacion:{
			name: 'desc_tipo_activo',
			fieldLabel: 'Tipo Activo',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris

			url:'../../control/tipo_activo/ActionListaTipoActivo.php', //direccion para generar el STORE
			title:'Tipos de Activos',   //titulo que va en el GRID
			datos: [
			{
				dataIndex: "id_tipo_activo",
				header: "ID",
				width: 50
			},
			{
				dataIndex: "codigo",
				header: "Código",
				width: 120
			},
			{
				dataIndex: "descripcion",
				header: "Descripción",
				width: 120
			},
			{
				dataIndex: "flag_depreciacion",
				header: "Depreciable",
				width: 120
			},
			{
				dataIndex: "fecha_reg",
				header: "Fecha de registro",
				width: 120
			},
			{
				dataIndex: "estado",
				header: "Estado",
				width: 120
			},
			{
				dataIndex: "desc_metodo_depreciacion",
				header: "Método de Depreciación",
				width: 120
			},
			{
				dataIndex: "desc_moneda",
				header: "Moneda",
				width: 120
			}
			],

			pageSize: 10,
			indice_id: 7


		},
		tipo: 'LovTriggerField',
		filtro_0:true,
		filterColValue:'tip.descripcion',
		filtro_1:true,
		save_as:'txt_desc_tipo_activo'
	}
	vectorAtributos[8] = paramDesc_tipo_activo;


	/////////// combo estado//////
	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
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
			width_grid:120 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.estado',
		save_as:'txt_estado'

	}
	vectorAtributos[9] = paramEstado;

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
			width_grid:120, // ancho de columna en el grid
			disabled: true
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'sub.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[10] = paramFecha_reg;

	/////////// txt_id_auxiliar//////
	var paramId_auxiliar = {
		validacion:{
			fieldLabel: 'Auxiliar',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Auxiliar...',
			name: 'id_auxiliar',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_auxiliar',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'descrip',
			queryParam: 'filterValue_0',
			filterCol:'descrip',
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
			width_grid:200, // ancho de columna en el gris
			//grid_indice:3
			grid_indice:13
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'txt_id_auxiliar_tmp',
		filterColValue:'aux.descrip'
	}
	vectorAtributos[11] = paramId_auxiliar;
	

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
		titulo_maestro:"Subtipos de Activos",
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
			width:360,
			height:500,
			minWidth:150,
			minHeight:200,
			closable:true
		}
	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();


}


var obj_pagina;
function main ()

{

	obj_pagina = new PaginaSubtipoActivo();

}

YAHOO.util.Event.on(window, 'load', main); //arranca todo