function GenerarReporteResumenMensualDescuentos(idContenedor,direccion,paramConfig)
{

	var vectorAtributos = new Array;
	var ContPes = 1;
	var h_txt_fecha_ini;
	var	h_txt_fecha_fin;
	var	h_txt_mes;
   	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////

///////// fecha_ini /////////
	var paramFechaIni = {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDays:[0, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'txt_fecha_ini',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[0] = paramFechaIni;
	///////// fecha /////////
	var paramFechaFin = {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDays:[0, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:1,
		tipo:'DateField',
		save_as:'txt_fecha_fin',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFechaFin;
	
/////////// txt mes //////
	var paramMes = {
		validacion:{
			name: 'mes',
			fieldLabel: 'Mes',
			typeAhead: true,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : [
				        ['Enero', 'Enero'],
				        ['Febrero', 'Febrero'],        
				        ['Marzo', 'Marzo'],
				        ['Abril', 'Abril'],        
				        ['Mayo', 'Mayo'],
				        ['Junio', 'Junio'],        
				        ['Julio', 'Julio'],
				        ['Agosto', 'Agosto'],
				        ['Septiembre', 'Septiembre'],
				        ['Octubre', 'Octubre'],        
				        ['Noviembre', 'Noviembre'],
				        ['Diciembre', 'Diciembre']                
				        ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:140 // ancho de columna en el grid
			
		},
		id_grupo:2,
		tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
		save_as:'txt_mes',
		defecto:""
	}
	vectorAtributos[2] = paramMes;
	
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
		titulo_maestro:"Resumen Mensual de Descuentos"
	};
	layout_rep_resumen_mensual_descuentos=new DocsLayoutProceso(idContenedor);
	layout_rep_resumen_mensual_descuentos.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
    this.pagina(paramConfig,vectorAtributos,layout_rep_resumen_mensual_descuentos,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;


	//ds_empleado.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

   function get_fecha(fecha)
	{
		var fecha = new Date(fecha);
		var dia;
		var mes;
		var anio;
		var fecha_res;

		dia = fecha.getDate();
		mes = fecha.getMonth() + 1;
		anio = fecha.getFullYear();
        
		fecha_res = dia + "/" + mes + "/" + anio;
		return fecha_res;
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		h_txt_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		h_txt_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		h_txt_mes = ClaseMadre_getComponente('mes');
		var $mes = new Date();
		$mes = $mes.getMonth();
		if($mes==0)
		{
			h_txt_mes.setValue('Diciembre')	
		}
		if($mes==1)
		{
			h_txt_mes.setValue('Enero')	
		}
		if($mes==2)
		{
			h_txt_mes.setValue('Febrero')	
		}
		if($mes==3)
		{
			h_txt_mes.setValue('Marzo')	
		}
		if($mes==4)
		{
			h_txt_mes.setValue('Abril')	
		}
		if($mes==5)
		{
			h_txt_mes.setValue('Mayo')	
		}
		if($mes==6)
		{
			h_txt_mes.setValue('Junio')	
		}
		if($mes==7)
		{
			h_txt_mes.setValue('Julio')	
		}
		if($mes==8)
		{
			h_txt_mes.setValue('Agosto')	
		}
		if($mes==9)
		{
			h_txt_mes.setValue('Septiembre')	
		}
		if($mes==10)
		{
			h_txt_mes.setValue('Octubre')	
		}
		if($mes==11)
		{
			h_txt_mes.setValue('Noviembre')	
		}
		
		$mes=$mes+1;
		var $primera_fecha = new Date();
		$primera_fecha ='01/'+$mes+'/'+$primera_fecha.getFullYear();
		h_txt_fecha_ini.setValue($primera_fecha);
		var $fecha_actual = new Date();
		$fecha_actual =$fecha_actual.getDate()+'/'+$mes+'/'+$fecha_actual.getFullYear();
		h_txt_fecha_fin.setValue($fecha_actual);			
		}
	

	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Resumen Mensual de Descuentos "+ ContPes;
		ContPes ++;
		return titulo;
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../../../sis_control_asistencia/control/_reportes/resumen_mensual_descuentos/ResumenMensualDescuento.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Fecha Inicio',
				columna:0,				
				id_grupo:0
			},
			{
				tituloGrupo:'Fecha Fin',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Mes de Descuento',
				columna:1,
				id_grupo:2
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
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}