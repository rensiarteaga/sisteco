//<script>
function GenerarReporteAsignacionActivoFijo()
{  var vectorAtributos = new Array;
   var lov_empleado;
	//Configuración página
	paramConfig = {
		TiempoEspera:10000//tiempo de espera para dar fallo
	};
	// Definición de todos los tipos de datos que se maneja    //
	/////////// hidden id_tipo_activo//////
	/////DATA STORE////////////
	/////////// txt Id_empleado//////
	var paramId_empleado = {
		validacion:{
			name: 'id_empleado',
			labelSeparator:'',
			inputType:"hidden"
		},
		tipo: 'Field',
		save_as:'hidden_id_empleado'
	}
	vectorAtributos[0] = paramId_empleado;
	/////////// txt Desc del empleado//////
	var paramDesc_empleado= {
		validacion:{
			name: 'des_empleado',
			fieldLabel: 'Empleado',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid

			url:'../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php?origen=filtro', //direccion para generar el STORE
			title:'Empleados',   //título que va en el GRID
			datos: [
			{	dataIndex: "id_empleado", /// modificar con el de activo_fijo
				filterColValue: "EMP.id_empleado",
				header: "ID",
				width: 50
			},
			{	dataIndex: "nombre", /// modificar con el de activo_fijo
				filterColValue:"per.nombre",
				header: "Nombre",
				width: 50
			},
			{	dataIndex: "apellido_paterno",
				filterColValue:"per.apellido_paterno",
				header: "Paterno",
				width: 120
			},
			{	dataIndex: "apellido_materno", /// modificar con el de activo_fijo
				filterColValue:"per.apellido_materno",
				header: "Materno",
				width: 150
			}
			],
			pageSize: 10,
			indice_id:0
		},
		tipo: 'LovTriggerField',
		id_grupo:0,
		save_as:'txt_des_empleado'
	}
	vectorAtributos[1] = paramDesc_empleado;
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
		var lov_empleado = ClaseMadre_getComponente('des_empleado');
		var aux = lov_empleado.lov.recuperar_valoresSelecionados();
		
		return aux["nombre"] + " " +aux["apellido_paterno"] + " " + aux["apellido_materno"];
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			url:'../../../control/_reportes/responsable_activo_fijo/ActionRptResponsableActivoFijo.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[280,280],
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