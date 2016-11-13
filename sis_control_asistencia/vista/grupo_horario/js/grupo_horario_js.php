
//<script>
function PaginaGrupoHorario()
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

		proxy: new Ext.data.HttpProxy({url: '<?php echo $dir?>../../../control/grupo_horario/ActionListarGrupoHorario.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_grupo_horario',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_grupo_horario',
		'nombre_horario',
		'acronimo_horario',
		'descripcion'
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

	/////////// hidden grupo_horario//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_GrupoHorario= {
		validacion:{
			labelSeparator:'',
			name: 'id_grupo_horario',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_grupo_horario'
	}
	vectorAtributos[0] = paramId_GrupoHorario;

	/////////// txt nombre horario//////
	var paramNombreHorario = {
		validacion:{
			name: 'nombre_horario',
			fieldLabel: 'Nombre Horario',
			allowBlank: false,
			maxLength:20,
			minLength:2,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_nombre_horario'
	}
	vectorAtributos[1] = paramNombreHorario;
	
	///////// txt acronimo horario//////
	
	var paramAcronimoHorario = {
		validacion:{
			name: 'acronimo_horario',
			fieldLabel: 'Acronimo Horario',
			allowBlank: false,
			maxLength:10,
			minLength:2,
			selectOnFocus:true,
			vtype:"texto",		//alphanum
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'acronimo_horario',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_acronimo_horario'
	}
	vectorAtributos[2] = paramAcronimoHorario;
	
	
	/////////// txt descripcion//////
	var paramDescripcion = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripcion',
			allowBlank: true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:300 // ancho de columna en el gris
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'descripcion',//  XX.descripcion     
		filtro_1:true,
		save_as:'txt_descripcion'
	}
	vectorAtributos[3] = paramDescripcion;
	
	
	
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
		titulo_maestro:"Grupo de Horario",
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
			
			url:"../../control/grupo_horario/ActionEliminarGrupoHorario.php"
		},
		Save:{
			url:"../../control/grupo_horario/ActionGuardarGrupoHorario.php"
		},
		ConfirmSave:{
			url:"../../control/grupo_horario/ActionGuardarGrupoHorario.php"
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
	obj_pagina = new PaginaGrupoHorario();
}

YAHOO.util.Event.on(window, 'load', main); //arranca todo