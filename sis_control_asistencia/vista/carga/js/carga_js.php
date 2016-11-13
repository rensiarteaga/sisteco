
//<script>
function PaginaArchivo()
{
	var vectorAtributos = new Array;
	var ds;
	var fecha;

	//Configuración página
	paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:2,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false//indica si se tiene los 5 combos que la filtra la estructura programática
		
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/lectura_reloj/ActionListarLecturaReloj.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lectura_reloj',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_lectura_reloj',
		'codigo_empleado',
		{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},
		'hora',
		'tipo_movimiento',
		'desc_empleado'
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
	
	/////DATA STORE COMBOS////////////
	
/////DATA STORE COMBOS////////////
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','desc_empleado'])

	});


	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden historico_lectura//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_LecturaReloj= {
		validacion:{
			labelSeparator:'',
			name: 'id_lectura_reloj',
			//fieldLabel: 'Codigo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_reloj'
	}
	vectorAtributos[0] = paramId_LecturaReloj;
	
	///////// hidden codigo_empleado//////
	
	var paramCodEmpleado = {
		validacion:{
			name: 'codigo_empleado',
			//fieldLabel: 'Empleado',
			allowBlank: true,
			inputType:'hidden',
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			//vtype:"hora",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		save_as:'txt_codigo_empleado'
	}
	vectorAtributos[1] = paramCodEmpleado;
	
	///////// fecha /////////
	
	/*var paramFecha = {
		validacion:{
			name: 'fecha',
			//fieldLabel: 'Fecha',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 6],
			disabledDaysText: 'Día no válido',
			inputType:'hidden',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el grid
			disabled: false
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2] = paramFecha;*/
	
	/////////// txt hora //////
	var paramHora = {
		validacion:{
			name: 'hora',
		//	fieldLabel: 'Hora',
			allowBlank: true,
			maxLength:15,
			minLength:2,
			inputType:'hidden',
			selectOnFocus:true,
			//vtype:"alphaLatino",
			//vtype:"hora",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_hora'
	}
	vectorAtributos[2] = paramHora;
	
		///////// txt tipo_movimiento //////
	
	var paramTipoMovimiento = {
		validacion:{
			name: 'tipo_movimiento',
		//	fieldLabel: 'Tipo Movimiento',
			typeAhead: true,
			loadMask: true,
			allowBlank: true,
			inputType:'hidden',
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : Ext.lectura_relojCombo.tipo_movimiento // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'tipo_movimiento',
		save_as:'txt_tipo_movimiento'
	}
	vectorAtributos[3] = paramTipoMovimiento;
	
	///////// formulario //////
	
	var paramFormulario = {
		validacion:{
			name: 'txt_archivo',
			fieldLabel: 'Cargar Archivo',
			typeAhead: true,
			//vtype:"file",
			loadMask: true,
			inputType:'file',
			allowBlank: true,
			triggerAction: 'all',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el grid
		},
		tipo:'Field',
		filtro_0:true,
		filtro_1:true,
	
	}
	vectorAtributos[4] = paramFormulario;
	
		
	/////////////////////////////////////////////////////////////
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
		titulo_maestro:"Lectura Reloj",
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
	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnActualizar = this.btnActualizar;
    var getSelectionModel = this.getSelectionModel;

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	
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
		h_txt_fecha = ClaseMadre_getComponente('fecha');
		

	}
	
	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			
			url:"../../control/lectura_reloj/ActionEliminarLecturaReloj.php"
		},
		Save:{
			url:"../../control/carga/ActionGuardarArchivo.php"
		},
		ConfirmSave:{
			url:"../../control/carga/ActionGuardarArchivo.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:480,
			height:250,
			minWidth:150,
			minHeight:200,
			closable:true,
			upload:true
		}
	}
	
	
	function get_fecha_bd()
	{
		var postData;
		var hcallback =
		{
			success:  cargar_fecha_bd,
			failure:  ClaseMadre_conexionFailure,
			timeout:  100000//TIEMPO DE ESPERA PARA DAR FALLO
		};

		YAHOO.util.Connect.asyncRequest('POST', '../../../lib/lib_control/action/ActionObtenerFechaBD.php', hcallback, postData);
	}

	//Carga la fecha obtenida
	function cargar_fecha_bd(resp)
	{
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha.getValue()=="")
			{
				h_txt_fecha.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	}
	
	//sobrecarga

this.btnNew = function()
	{

		ClaseMadre_btnNew()
		get_fecha_bd()
	}


   //Abre la ventana de Componentes
	function btnCargar()
	{
		ClaseMadre_btnNew()
		get_fecha_bd()
		/*var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado

			var data = "maestro_id_lectura_reloj=" + SelectionsRecord.data.id_lectura_reloj;
			data = data + "&maestro_codigo_empleado=" + SelectionsRecord.data.codigo_empleado;
			data = data + "&maestro_fecha=" + SelectionsRecord.data.fecha;
			data = data + "&maestro_hora=" + SelectionsRecord.data.hora;
			data = data + "&maestro_tipo_movimiento=" + SelectionsRecord.data.tipo_movimiento;

			//Abre la pestaña del detalle
			Docs.loadTab('../lectura_procesada/lectura_procesada.php?'+data, "Procesar [" + SelectionsRecord.data.codigo + "]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}*/
	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Cargar Archivo<b>',btnCargar,true,'archivos','Cargar Archivo');
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
		iniciarEventosFormularios();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	
	
	this.mostrarFormulario();

}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaArchivo();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo