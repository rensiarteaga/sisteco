
//<script>
function PaginaHistoricoLectura()
{
	var vectorAtributos = new Array;
	var ds;

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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/historico_lectura/ActionListarHistoricoLectura.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_historico_lectura',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_historico_lectura',
		'hora',
		'tipo_movimiento',
		'id_lectura_procesada',
		'desc_lectura'
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
	ds_lectura = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/lectura_procesada/ActionListarLecturaProcesada.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lectura_procesada',
			totalRecords: 'TotalCount'

		}, ['id_lectura_procesada','observaciones'])

	});


	function renderLectura(value, p, record){return String.format('{0}', record.data['desc_lectura']);}


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden historico_lectura//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_HistoricoLectura= {
		validacion:{
			labelSeparator:'',
			name: 'id_historico_lectura',
			//fieldLabel: 'Codigo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_historico_lectura'
	}
	vectorAtributos[0] = paramId_HistoricoLectura;

	/////////// txt hora //////
	var paramHora = {
		validacion:{
			name: 'hora',
			fieldLabel: 'Hora',
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
		save_as:'txt_hora'
	}
	vectorAtributos[1] = paramHora;
	
	///////// txt tipo_movimiento //////
	
	var paramTipoMovimiento = {
		validacion:{
			name: 'tipo_movimiento',
			fieldLabel: 'Tipo Movimiento',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : [
				                                    ['entrada', 'Entrada'],
				                                    ['salida', 'Salida']
				                                    
				                                ]// from states.js
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
		save_as:'txt_tipo_movimiento'
	}
	vectorAtributos[2] = paramTipoMovimiento;
	
	
	///////// hidden id_grupo_horario//////
	
	var paramIdLecturaProcesada = {
		validacion:{
			fieldLabel: 'Lectura Procesada',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Lectura...',
			name: 'id_lectura_procesada',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_lectura', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_lectura,
			valueField: 'id_lectura_procesada',
			displayField: 'observaciones',
			queryParam: 'filterValue_0',
			filterCol:'observaciones',
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
			renderer: renderLectura,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_lectura_procesada'
	}
	vectorAtributos[3] = paramIdLecturaProcesada;
	
	
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
		titulo_maestro:"Lectura",
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
			
			url:"../../control/historico_lectura/ActionEliminarHistoricoLectura.php"
		},
		Save:{
			url:"../../control/historico_lectura/ActionGuardarHistoricoLectura.php"
		},
		ConfirmSave:{
			url:"../../control/historico_lectura/ActionGuardarHistoricoLectura.php"
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

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

}


var obj_pagina;
function main ()
{
	obj_pagina = new PaginaHistoricoLectura();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo