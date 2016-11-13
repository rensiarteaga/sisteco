
//<script>

function GenerarReporteAsignacionActivoFijo()
{  var vectorAtributos = new Array;
   var lov_empleado;
   var ContPes = 1;
   
	//Configuración página
	paramConfig = {
		TiempoEspera:10000//tiempo de espera para dar fallo
	};
	
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','id_persona','desc_nombrecompleto'])

	});
	////////////////FUNCIONES RENDER ////////////
	function render_empleado(value, p, record){return String.format('{0}', record.data['empleado']);}
	// Definición de todos los tipos de datos que se maneja    //
	/////////// hidden id_tipo_activo//////
		
	
	var paramId_empleado = {
		validacion:{
			fieldLabel: 'Funcionario',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Funcionario...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'EMP.id_persona#EMP.codigo_empleado#PER.nombre#PER.apellido_paterno#PER.apellido_materno',
			typeAhead: false,
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
			renderer: render_empleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			width:280
		},
		id_grupo:0,
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
	}
	vectorAtributos[0] = paramId_empleado;
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Parámetros Responsable Activos Fijos"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{	lov_empleado = ClaseMadre_getComponente('des_empleado');

			
	}
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
		
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('mes_ini');
		//return combo_financiador.getValue();
		var titulo = "Rep. Asignación Activos Fijos"+ ContPes;
		ContPes ++;
		return titulo;
	}

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../../control/_reportes/activo_fijo_asignacion/ActionPDFActivoFijoAsigancion.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[400,400],
			grupos:[
			{	tituloGrupo:'Funcionario',
				columna:0,
				id_grupo:0
			}],
			parametros: ''
		}
	}
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
}

var obj_pagina;
function main ()
{	obj_pagina = new GenerarReporteAsignacionActivoFijo();
}
YAHOO.util.Event.on(window, 'load', main); //arranca todo