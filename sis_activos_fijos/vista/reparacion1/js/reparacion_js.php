
//<script>
function PaginaReparacion()
{
	var vectorAtributos = new Array;
	var ds;

	//Configuración página
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/reparacion/ActionListaReparacion.php'}),

		
		
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_reparacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'descripcion', type: 'string'},
		'id_reparacion',
		{name: 'fecha_desde', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		{name: 'fecha_hasta', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'problema', 
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'observaciones',
		'estado',
		'id_activo_fijo',
		'id_persona',
		'id_institucion',
		'des_activo_fijo',
		'des_persona',
		'des_institucion'
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

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_reparacion = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_reparacion',
			inputType:'hidden',
			grid_visible:true, // se muestra en el grid
			grid_editable:false //es editable en el grid
			
		},
		tipo: 'Field',
		filtro_0:true,
		save_as:'hidden_id_reparacion'
	}
	vectorAtributos[0] = paramId_reparacion;

	
	
	var paramFecha_desde = {
		validacion:{
			name: 'fecha_desde',
			fieldLabel: 'Fecha Inicio',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:90 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_desde',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFecha_desde;
	
	
	var paramFecha_hasta = {
		validacion:{
			name: 'fecha_hasta',
			fieldLabel: 'Fecha Fin',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			renderer: formatDate,
			width_grid:70 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_hasta',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2] = paramFecha_hasta;

	var paramProblema = {
		validacion:{
			name: 'problema',
			fieldLabel: 'Problema',
			allowBlank: false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_problema'
	}
	vectorAtributos[3] = paramProblema;
	
	
	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha Registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80, // ancho de columna en el gris
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
	vectorAtributos[4] = paramFecha_reg;
	
	var paramObservaciones= {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200 // ancho de columna en el gris
		},
		tipo: 'TextArea',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_observaciones'
	}
	vectorAtributos[5] = paramObservaciones;
	
	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['activo', 'inactivo', 'eliminado'],
				data : Ext.reparacionCombo.estado // from states.js
			}),
			valueField:'activo',
			displayField:'inactivo',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:50 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_estado'
	}
	vectorAtributos[6] = paramEstado;

	/*******/
	var paramId_activo_fijo= {
		validacion:{
			name: 'id_activo_fijo',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo'
	}
	vectorAtributos[7] = paramId_activo_fijo;
	
	var paramDesc_activo_fijo= {
		validacion:{
			name: 'des_activo_fijo',
			fieldLabel: 'Activo Fijo',
			allowBlank: false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid

			url:'../../control/activo_fijo/ActionListaActivoFijo.php', //direccion para generar el STORE
			title:'Activos Fijos',   //titulo que va en el GRID
			datos: [
			{
				dataIndex: "id_activo_fijo",
				header: "ID",
				width: 50
			},
			{
				dataIndex: "descripcion",
				header: "Nombre",
				width: 120
			}
			],

			pageSize: 10,
			indice_id:7


		},
		tipo: 'LovTriggerField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_des_activo_fijo'
	}
	vectorAtributos[8] = paramDesc_activo_fijo;

///////////////////////
	
	var paramId_persona= {
		validacion:{
			name: 'id_persona',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid,
			
		},
		tipo: 'Field',
		save_as:'hidden_id_persona'
	}
	vectorAtributos[9] = paramId_persona;
	
	var paramDesc_persona = {
		validacion:{
			name: 'des_persona',
			fieldLabel: 'Persona',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:80, // ancho de columna en el gris

			url:'../../control/metodo_depreciacion/ActionListaMetodoDepreciacion.php',//proceso/ActionListaProceso.php', //direccion para generar el STORE
			title:'Procesos',   //titulo que va en el GRID
			datos: [
			{
				dataIndex: "id_metodo_depreciacion",
				header: "ID",
				width: 50
			},
			{
				dataIndex: "descripcion",
				header: "Nombre",
				width: 120
			}
			],

			pageSize: 10,
			indice_id:9


		},
		tipo: 'LovTriggerField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_des_persona'
	}
	vectorAtributos[10] = paramDesc_persona;
	
	
	
		var paramId_institucion= {
		validacion:{
			name: 'id_institucion',
			labelSeparator:'',
			inputType:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid,
			
		},
		tipo: 'Field',
		save_as:'hidden_id_institucion'
	}
	vectorAtributos[11] = paramId_institucion;
	
	var paramDesc_institucion= {
		validacion:{
			name: 'des_institucion',
			fieldLabel: 'Institucion',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:80, // ancho de columna en el gris

			url:'../../control/metodo_depreciacion/ActionListaMetodoDepreciacion.php',//proceso/ActionListaProceso.php', //direccion para generar el STORE
			title:'Procesos',   //titulo que va en el GRID
			datos: [
			{
				dataIndex: "id_metodo_depreciacion",
				header: "ID",
				width: 50
			},
			{
				dataIndex: "descripcion",
				header: "Nombre",
				width: 120
			}
			],

			pageSize: 10,
			indice_id:11


		},
		tipo: 'LovTriggerField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_des_institucion'
	}
	vectorAtributos[12] = paramDesc_institucion;
	
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
		titulo_maestro:"Reparacion de Activo Fijo",
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
			
			url:"../../control/reparacion/ActionEliminaReparacion.php"
		},
		Save:{
			url:"../../control/reparacion/ActionSaveReparacion.php"
		},
		ConfirmSave:{
			url:"../../control/reparacion/ActionSaveReparacion.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:450,
			height:480,
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
	obj_pagina = new PaginaReparacion();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo





