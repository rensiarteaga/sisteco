
//<script>
function PaginaHorario()
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/horario/ActionListarHorario.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_codigo_horario',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_codigo_horario',
		'entra_lunes',
		'sale_lunes',
		'entra_martes',
		'sale_martes',
		'entra_miercoles',
		'sale_miercoles',
		'entra_jueves',
		'sale_jueves',
		'entra_viernes',
		'sale_viernes',
		'entra_sabado',
		'sale_sabado',
		'entra_domingo',
		'sale_domingo',
		'min_tolerancia_entra',
		'hora_extra_lunes',
		'hora_extra_martes',
		'hora_extra_miercoles',
		'hora_extra_jueves',
		'hora_extra_viernes',
		'hora_extra_sabado',
		'hora_extra_domingo',
		'id_grupo_horario',
		'desc_horario'
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
	ds_horario = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: '../../control/grupo_horario/ActionListarGrupoHorario.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_grupo_horario',
			totalRecords: 'TotalCount'

		}, ['id_grupo_horario','nombre_horario'])

	});


	function renderHorario(value, p, record){return String.format('{0}', record.data['desc_horario']);}


	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden grupo_horario//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_CodigoHorario= {
		validacion:{
			labelSeparator:'',
			name: 'id_codigo_horario',
			//fieldLabel: 'Codigo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_codigo_horario'
	}
	vectorAtributos[0] = paramId_CodigoHorario;

	/////////// txt entra_lunes//////
	var paramEntraLunes = {
		validacion:{
			name: 'entra_lunes',
			fieldLabel: 'Entrada Lunes',
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
		save_as:'txt_entra_lunes'
	}
	vectorAtributos[1] = paramEntraLunes;
	
	///////// txt sale_lunes//////
	
	var paramSaleLunes = {
		validacion:{
			name: 'sale_lunes',
			fieldLabel: 'Salida Lunes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_lunes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_lunes'
	}
	vectorAtributos[2] = paramSaleLunes;
	
	
	/////////// txt entra_martes//////
	var paramEntraMartes = {
		validacion:{
			name: 'entra_martes',
			fieldLabel: 'Entrada Martes',
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
		save_as:'txt_entra_martes'
	}
	vectorAtributos[3] = paramEntraMartes;
	
	///////// txt sale_martes//////
	
	var paramSaleMartes = {
		validacion:{
			name: 'sale_martes',
			fieldLabel: 'Salida Martes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_martes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_martes'
	}
	vectorAtributos[4] = paramSaleMartes;
	
	/////////// txt entra_miercoles//////
	var paramEntraMiercoles = {
		validacion:{
			name: 'entra_miercoles',
			fieldLabel: 'Entrada Miercoles',
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
		save_as:'txt_entra_miercoles'
	}
	vectorAtributos[5] = paramEntraMiercoles;
	
	///////// txt sale_miercoles//////
	
	var paramSaleMiercoles = {
		validacion:{
			name: 'sale_miercoles',
			fieldLabel: 'Salida Miercoles',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_miercoles',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_miercoles'
	}
	vectorAtributos[6] = paramSaleMiercoles;
	
	/////////// txt entra_jueves//////
	var paramEntraJueves = {
		validacion:{
			name: 'entra_jueves',
			fieldLabel: 'Entrada Jueves',
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
		save_as:'txt_entra_jueves'
	}
	vectorAtributos[7] = paramEntraJueves;
	
	///////// txt sale_jueves//////
	
	var paramSaleJueves = {
		validacion:{
			name: 'sale_jueves',
			fieldLabel: 'Salida Jueves',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_jueves',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_jueves'
	}
	vectorAtributos[8] = paramSaleJueves;
	
	/////////// txt entra_viernes//////
	var paramEntraViernes = {
		validacion:{
			name: 'entra_viernes',
			fieldLabel: 'Entrada Viernes',
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
		save_as:'txt_entra_viernes'
	}
	vectorAtributos[9] = paramEntraViernes;
	
	///////// txt sale_viernes//////
	
	var paramSaleViernes = {
		validacion:{
			name: 'sale_viernes',
			fieldLabel: 'Salida Viernes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_viernes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_viernes'
	}
	vectorAtributos[10] = paramSaleViernes;
	
	/////////// txt entra_sabado//////
	var paramEntraSabado = {
		validacion:{
			name: 'entra_sabado',
			fieldLabel: 'Entrada Sabado',
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
		save_as:'txt_entra_sabado'
	}
	vectorAtributos[11] = paramEntraSabado;
	
	///////// txt sale_sabado//////
	
	var paramSaleSabado = {
		validacion:{
			name: 'sale_sabado',
			fieldLabel: 'Salida Sabado',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_sabado',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_sabado'
	}
	vectorAtributos[12] = paramSaleSabado;
	
	/////////// txt entra_domingo//////
	var paramEntraDomingo = {
		validacion:{
			name: 'entra_domingo',
			fieldLabel: 'Entrada Domingo',
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
		save_as:'txt_entra_domingo'
	}
	vectorAtributos[13] = paramEntraDomingo;
	
	///////// txt sale_domingo//////
	
	var paramSaleDomingo = {
		validacion:{
			name: 'sale_domingo',
			fieldLabel: 'Salida Domingo',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sale_domingo',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_sale_domingo'
	}
	vectorAtributos[14] = paramSaleDomingo;
	
	/////////// txt min_tolerancia_entra //////
	var paramMinTolerancia = {
		validacion:{
			name: 'min_tolerancia_entra',
			fieldLabel: 'Minutos de Tolerancia',
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
		save_as:'txt_tolerancia_entra'
	}
	vectorAtributos[15] = paramMinTolerancia;
	
	///////// txt hora_extra_lunes//////
	
	var paramHoraExtraLunes = {
		validacion:{
			name: 'hora_extra_lunes',
			fieldLabel: 'Horas Extra Lunes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_lunes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_lunes'
	}
	vectorAtributos[16] = paramHoraExtraLunes;
	
	///////// txt hora_extra_martes//////
	
	var paramHoraExtraMartes = {
		validacion:{
			name: 'hora_extra_martes',
			fieldLabel: 'Horas Extra Martes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_martes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_martes'
	}
	vectorAtributos[17] = paramHoraExtraMartes;
	
	///////// txt hora_extra_miercoles//////
	
	var paramHoraExtraMiercoles = {
		validacion:{
			name: 'hora_extra_miercoles',
			fieldLabel: 'Horas Extra Miercoles',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_miercoles',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_miercoles'
	}
	vectorAtributos[18] = paramHoraExtraMartes;
	
	///////// txt hora_extra_jueves//////
	
	var paramHoraExtraJueves = {
		validacion:{
			name: 'hora_extra_jueves',
			fieldLabel: 'Horas Extra Jueves',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_jueves',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_jueves'
	}
	vectorAtributos[19] = paramHoraExtraJueves;
	
	///////// txt hora_extra_viernes//////
	
	var paramHoraExtraViernes = {
		validacion:{
			name: 'hora_extra_viernes',
			fieldLabel: 'Horas Extra Viernes',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_viernes',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_viernes'
	}
	vectorAtributos[20] = paramHoraExtraViernes;
	
	///////// txt hora_extra_sabado //////
	
	var paramHoraExtraSabado = {
		validacion:{
			name: 'hora_extra_sabado',
			fieldLabel: 'Horas Extra Sabado',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_sabado',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_sabado'
	}
	vectorAtributos[21] = paramHoraExtraSabado;
	
	///////// txt hora_extra_domingo//////
	
	var paramHoraExtraDomingo = {
		validacion:{
			name: 'hora_extra_domingo',
			fieldLabel: 'Horas Extra Domingo',
			allowBlank: true,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'hora_extra_domingo',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_hora_extra_domingo'
	}
	vectorAtributos[22] = paramHoraExtraDomingo;
	
	///////// hidden id_grupo_horario//////
	
	var paramIdGrupoHorario = {
		validacion:{
			fieldLabel: 'Grupo Horario',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Horario...',
			name: 'id_grupo_horario',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_horario', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_horario,
			valueField: 'id_grupo_horario',
			displayField: 'nombre_horario',
			queryParam: 'filterValue_0',
			filterCol:'nombre_horario',
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
			renderer: renderHorario,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'ComboBox',
		save_as:'hidden_id_grupo_horario'
	}
	vectorAtributos[23] = paramIdGrupoHorario;
	
	
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
		titulo_maestro:"Horario",
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
			
			url:"../../control/horario/ActionEliminarHorario.php"
		},
		Save:{
			url:"../../control/horario/ActionGuardarHorario.php"
		},
		ConfirmSave:{
			url:"../../control/horario/ActionGuardarHorario.php"
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
	obj_pagina = new PaginaHorario();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo