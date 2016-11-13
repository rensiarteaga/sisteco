
//<script>
function PaginaActivoFijoEmpleado()
{
	var vectorAtributos = new Array;
	var ds;

	//Configuración Página
	paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
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
		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleado.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo_empleado',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-d-m'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'id_activo_fijo_empleado',
		'estado',
		'id_activo_fijo',
		'id_empleado',
		'des_activo_fijo_empleado',
		'des_empleado'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_activo_fijo: $("maestro_id_activo_fijo").value
		}
	});

	//////////////////////////////////////////////////////////////
	//        DEFINICIÓN DATOS DEL MAESTRO                     //
	//////////////////////////////////////////////////////////////

	////////// INICIA MAESTRO ///////////////////////
	var dataMaestro = [
	['ID',$("maestro_id_activo_fijo").value],
	['Descripcion',$("maestro_descripcion").value],
	['Descripcion Larga',$("maestro_descripcion_larga").value]
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
			{header: "Atributo", width:100, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
			{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
		]);
		
		function negrita(value){
            return '<span style="color:red;font-size:10pt"><b>' + value + '<b></span>';
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

	/////////// hidden id_activo_fijo_empleado//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_activo_fijo_empleado = {
		validacion:{
			labelSeparator:'',
			name: 'id_activo_fijo_empleado',
			inputType:'hidden',
			grid_visible:true, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:true,
		save_as:'hidden_id_activo_fijo_empleado'
	}
	vectorAtributos[0] = paramId_activo_fijo_empleado;


	/////////// txt Desc_activo_fijo//////
	var paramDesc_activo_fijo_empleado= {
		validacion:{
			name: 'id_empleado',
			fieldLabel: 'ID del empleado',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid

			url:'../../control/activo_fijo/ActionListaActivoFijo.php', //direccion para generar el STORE
			title:'Empleados',   //título que va en el GRID
			datos: [
			{
				dataIndex: "id_empleado",//id_activo_fijo", /// modificar con el de activo_fijo
				header: "ID",
				width: 50
			},
			{
				dataIndex: "codigo", /// modificar con el de activo_fijo
				header: "Código",
				width: 50
			},
			{
				dataIndex: "descripcion",
				header: "Descripción",
				width: 120
			},
			{
				dataIndex: "descripcion_larga", /// modificar con el de activo_fijo
				header: "descripcion_larga",
				width: 50
			}
			],
			pageSize: 10,
			indice_id:0//id donde se agarrara el valor devuelto
		},
		tipo: 'LovTriggerField',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_des_activo_fijo_empleado',
		//id_grupo: 0
	}
	vectorAtributos[1] = paramDesc_activo_fijo_empleado;
	
	
	
	

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
				data : Ext.empleadoCombo.estado // from states.js
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
		filterColValue:'afe.estado',
		save_as:'txt_estado'

	}
	vectorAtributos[2] = paramEstado;

	
	
	
	var paramId_activo_fijo = {
		validacion:{
			name: 'id_activo_fijo',
			//fieldLabel: 'Id Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:true, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_activo_fijo',
		defecto: $("maestro_id_activo_fijo").value
	}
	vectorAtributos[3] = paramId_activo_fijo;

	
	
	///////////////txt id_empleado///////////
	var paramId_empleado = {
		validacion:{
			name: 'id_empleado',
			//fieldLabel: 'Id Activo',
			inputType:"hidden",
			labelSeparator:'',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_empleado',
		//defecto: $("maestro_id_empleado").value
	}
	vectorAtributos[4] = paramId_empleado;

	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha_reg',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900&',
			//disabledDays: [0, 7],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[5] = paramFecha_reg;



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
		titulo_maestro:" Activo Fijo Maestro",
		titulo_detalle:"Empleado Activos Fijos",
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
			url:"../../control/activo_fijo_empleado/ActionEliminaActivoFijoEmpleado.php"
		},
		Save:{
			url:"../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		ConfirmSave:{
			url:"../../control/activo_fijo_empleado/ActionSaveActivoFijoEmpleado.php"
		},
		Formulario:{
			html_apply:"dlgInfo",
			width:450,
			height:250,
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
	
	obj_pagina = new PaginaActivoFijoEmpleado();
	
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo