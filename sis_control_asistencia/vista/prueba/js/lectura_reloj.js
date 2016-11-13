function PaginaLecturaReloj(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var fecha;
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	ds=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lectura_reloj/ActionListarLecturaReloj.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_lectura_reloj',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name:'descripcion', type:'string'},
		'id_lectura_reloj',
		'codigo_empleado',
		{name:'fecha', type:'date', dateFormat:'Y-m-d'},
		'hora',
		'tipo_movimiento',
		'observaciones',
		'turno'
		]),
		remoteSort:true // metodo de ordenacion remoto
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
	ds_empleado=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/lectura_reloj/ActionListarDistintoLecturaReloj.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			totalRecords:'TotalCount'
		}, ['codigo_empleado'])
	});
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['codigo_empleado']);}
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////
    /////////// hidden id_lectura_reloj //////
	//en la posición 0 siempre tiene que estar la llave primaria
	var paramId_LecturaReloj= {
		validacion:{
			labelSeparator:'',
			name:'id_lectura_reloj',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_reloj'
	}
	vectorAtributos[0] = paramId_LecturaReloj;
	///////// txt codigo_empleado//////
	var paramCod_Empleado = {
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Empleado...',
			name:'codigo_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc:'codigo_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField:'codigo_empleado',
			displayField:'codigo_empleado',
			queryParam:'filterValue_0',
			filterCol:'codigo_empleado',
			typeAhead:true,
			forceSelection :true,
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
			width_grid:135,  // ancho de columna en el gris
			grid_indice:0
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_codigo_empleado'
	}
	vectorAtributos[1] = paramCod_Empleado;
	///////// fecha /////////
	var paramFecha = {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false,
			grid_indice:1
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2] = paramFecha;
   /////////// txt observaciones //////
	var paramObservaciones = {
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			typeAhead: true,
			loadMask: true,
			allowBlank: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : [
				        ['Vacacion', 'Vacacion'], 
				        ['Comision de Viaje', 'Comision de Viaje'],
					    ['Comision Sindical', 'Comision Sindical'],
					    ['Baja Medica', 'Baja Medica'],
					    ['Capacitacion', 'Capacitacion'],
				        ['Otro', 'Otro'],
				        ['Ninguna', 'Ninguna']                        
				    ]; // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			grid_indice:4 
		},
		tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'observaciones',
		save_as:'txt_observaciones',
		defecto:""
	}
	vectorAtributos[3] = paramObservaciones;
	/////////// txt turno //////
	var paramTurno = {
		validacion:{
			name: 'turno',
			fieldLabel: 'Turno',
			typeAhead: true,
			loadMask: true,
			allowBlank: true,
			triggerAction: 'all',
			disabled: true,
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data :[
				        ['Mañana', 'Mañana'],
				        ['Tarde', 'Tarde'],
				        ['Jornada Completa', 'Jornada Completa']                
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			grid_indice:5
		},
		tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
		filtro_0:false,
		filtro_1:false,
		filtro_2:false,
		filterColValue:'turno',
		save_as:'txt_turno',
		defecto:""
	}
	vectorAtributos[4] = paramTurno;
	/////////// txt hora //////
	var paramHora = {
		validacion:{
			name: 'hora',
			fieldLabel: 'Hora',
			emptyText:'Hora...',
			allowBlank: true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled: false,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:2 
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		save_as:'txt_hora',
		defecto:""
	}
	vectorAtributos[5] = paramHora;
   ///////// txt tipo_movimiento //////
	var paramTipoMovimiento = {
		validacion:{
			name: 'tipo_movimiento',
			fieldLabel: 'Tipo Movimiento',
			typeAhead: true,
			emptyText:'Movimiento...',
			loadMask: true,
			allowBlank: true,
			disabled: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data :  [
				         ['Entrada', 'Entrada'],
				         ['Salida', 'Salida']        
				     ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			//forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			grid_indice:3
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'tipo_movimiento',
		save_as:'txt_tipo_movimiento',
		defecto:""
	}
	vectorAtributos[6] = paramTipoMovimiento;

//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////
    /////////// hidden id_lectura_reloj //////
	//en la posición 0 siempre tiene que estar la llave primaria
	var paramarchivo={
		validacion:{
			name:'txt_archivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			inputType:'file'		
		},
		id_grupo:0,
		tipo:'Field',
		save_as:'txt_archivo'	
	};
	vectorAtributos[7]=paramarchivo;
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
		titulo_maestro:"Depuración de Registros de Marcas",
		grid_maestro:"grid-"+idContenedor
	};
	layout_lectura_reloj = new DocsLayoutMaestro(idContenedor);
	layout_lectura_reloj.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_lectura_reloj,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo="Lectura de Marcas "+ContPes;
		ContPes ++;
		return titulo;
	}	
	function retorno(){
	    alert('llega');
		Ext.MessageBox.hide();//ocultamos el loading
		Ext.MessageBox.alert('Estado', 'Subió el archivo con exito')
		/*var ParamVentana={Ventana:{width:'90%',height:'70%'}}
		layout_rep_carga.loadWindows(direccion+'../../../vista/lectura_reloj/lectura_reloj.php',"Depuración de Registros de Marcas",ParamVentana)	*/
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/lectura_reloj/ActionEliminarLecturaReloj.php"
		},
		Save:{
			url:direccion+'../../../../sis_control_asistencia/control/carga/ActionGuardarArchivo.php'
		},
		ConfirmSave:{
			url:direccion+"../../../control/lectura_reloj/ActionGuardarLecturaReloj.php"
		},
		Formulario:{
			labelWidth:75, //ancho del label
			//url:direccion+'../../../../sis_control_asistencia/control/carga/ActionGuardarArchivo.php',
			abrir_pestana:false, //abrir pestana
			titulo_pestana:obtenerTitulo,
			argument:'',
			//navegador_pestana:false,
			fileUpload:true,
			success:retorno,
		    parametros:''
		}
	}
//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	//iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
