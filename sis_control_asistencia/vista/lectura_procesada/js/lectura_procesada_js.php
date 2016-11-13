
//<script>
function PaginaLecturaProcesada()
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/lectura_procesada/ActionListarLecturaProcesada.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lectura_procesada',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_lectura_procesada',
		'fecha',
		'horas_trabajadas',
		'horas_no_trab_con_permiso',
		'horas_no_trab_sin_permiso',
		'horas_extras',
		'tipo_permiso',
		'aprobado',
		'especial',
		'total_horas_trabajadas',
		'observaciones',
		'id_empleado',
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

	/////////// hidden lectura_procesada//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_LecturaProcesada= {
		validacion:{
			labelSeparator:'',
			name: 'id_lectura_procesada',
			//fieldLabel: 'Codigo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_procesada'
	}
	vectorAtributos[0] = paramId_LecturaProcesada;
	
	///////// fecha /////////
	
	var paramFecha = {
		validacion:{
			name: 'fecha',
			fieldLabel: 'Fecha',
			allowBlank: true,
			selectOnFocus:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			//renderer: formatDate,
			width_grid:120, // ancho de columna en el grid
			//disabled: false
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_fecha',
		
		//defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFecha;

	/////////// txt horas_trabajadas //////
	var paramHorasTrabajadas = {
		validacion:{
			name: 'horas_trabajadas',
			fieldLabel: 'Horas Trabajadas',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_horas_trabajadas'
	}
	vectorAtributos[2] = paramHorasTrabajadas;
	
	///////// txt horas_no_trab_con_permiso //////
	
	var paramHorasNoTrabconPermiso = {
		validacion:{
			name: 'horas_no_trab_con_permiso',
			fieldLabel: 'Horas no Trabajadas con Permiso',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_horas_no_trab_con_permiso'
	}
	vectorAtributos[3] = paramHorasNoTrabconPermiso;
	
	///////// txt horas_no_trab_sin_permiso //////
	
	var paramHorasNoTrabsinPermiso = {
		validacion:{
			name: 'horas_no_trab_sin_permiso',
			fieldLabel: 'Horas no Trabajadas sin Permiso',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_horas_no_trab_sin_permiso'
	}
	vectorAtributos[4] = paramHorasNoTrabsinPermiso;
	
	///////// txt horas_extras //////
	
	var paramHorasExtras = {
		validacion:{
			name: 'horas_extras',
			fieldLabel: 'Horas Extras',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_horas_extras'
	}
	vectorAtributos[5] = paramHorasExtras;
	
	///////// txt tipo_permiso //////
	
	var paramTipoPermiso = {
		validacion:{
			name: 'tipo_permiso',
			fieldLabel: 'Tipo Permiso',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_tipo_permiso'
	}
	vectorAtributos[6] = paramTipoPermiso;
	
	///////// txt aprobado //////
	
	var paramAprobado = {
		validacion:{
			name: 'aprobado',
			fieldLabel: 'Aprobado',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : [
				        ['si', 'Si'],
				        ['no', 'No']
				        
				    ] // from states.js
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
		filterColValue:'aprobado',
		save_as:'txt_aprobado'
	}
	vectorAtributos[7] = paramAprobado;
	
	///////// txt especial //////
	
	var paramEspecial = {
		validacion:{
			name: 'especial',
			fieldLabel: 'Caso Especial',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_especial'
	}
	vectorAtributos[8] = paramEspecial;
	
	///////// txt total_horas_trabajadas //////
	
	var paramTotalHorasTrab = {
		validacion:{
			name: 'total_horas_trabajadas',
			fieldLabel: 'Total Horas Trabajadas',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_total_horas_trabajadas'
	}
	vectorAtributos[9] = paramTotalHorasTrab;
	
	///////// txt observaciones //////
	
	var paramObservaciones = {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_observaciones'
	}
	vectorAtributos[10] = paramObservaciones;
	
	///////// hidden id_empleado//////
	
	var paramIdEmpleado = {
		validacion:{
			fieldLabel: 'Empleado',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Empleado...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_empleado,
			valueField: 'id_empleado',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
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
			renderer: renderEmpleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
	}
	vectorAtributos[11] = paramIdEmpleado;
	
	
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
		titulo_maestro:"Feriado",
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
			
			url:"../../control/lectura_procesada/ActionEliminarLecturaProcesada.php"
		},
		Save:{
			url:"../../control/lectura_procesada/ActionGuardarLecturaProcesada.php"
		},
		ConfirmSave:{
			url:"../../control/lectura_procesada/ActionGuardarLecturaProcesada.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:480,
			height:250,
			minWidth:150,
			minHeight:200,
			closable:true
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




	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//this.iniciaFormulario();
	iniciarEventosFormularios();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaLecturaProcesada();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo