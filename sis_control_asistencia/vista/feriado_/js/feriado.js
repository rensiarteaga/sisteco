function PaginaFeriado(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var fecha;
	var h_txt_fecha;
	var ds_empleado;
	//  DATA STORE      		//
	ds=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/feriado/ActionListarFeriado.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_feriados',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_feriados',
		{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},
		'motivo'
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
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/sueldo/ActionListarEmpleado.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			totalRecords:'TotalCount'
		}, ['codigo_empleado'])
	});
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['codigo_empleado']);}
	/////////// hidden id_feriado//////
	//en la posición 0 siempre tiene que estar la llave primaria

	var paramId_Feriado= {
		validacion:{
			labelSeparator:'',
			name: 'id_feriados',
			//fieldLabel: 'Codigo',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_feriados'
	}
	vectorAtributos[0] = paramId_Feriado;
	
	///////// fecha /////////
	
	var paramFecha = {
		validacion:{
			name: 'fecha',
			fieldLabel: 'Fecha Feriado',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDays: [0, 6],
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el grid
			disabled: false
		},
		tipo: 'DateField',
		filtro_0:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFecha;

	/////////// txt motivo //////
	var paramMotivo = {
		validacion:{
			name: 'motivo',
			fieldLabel: 'Motivo Feriado',
			allowBlank: true,
			maxLength:50,
			minLength:2,
			selectOnFocus:true,		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120 // ancho de columna en el gris
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		save_as:'txt_motivo'
	}
	vectorAtributos[2] = paramMotivo;
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config = {
		titulo_maestro:"Feriado",
		grid_maestro:"grid-"+idContenedor
	};
	layout_feriado = new DocsLayoutMaestro(idContenedor);
	layout_feriado.init(config);
	// INICIAMOS HERENCIA //
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_feriado,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;
	var paramFunciones = {
		btnEliminar:{
			url:direccion+"../../../control/feriado/ActionEliminarFeriado.php"
		},
		Save:{
			url:direccion+"../../../control/feriado/ActionGuardarFeriado.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/feriado/ActionGuardarFeriado.php"
		},
		
	Formulario:{
			html_apply:"dlgInfo"+idContenedor,
			width:'38%',
			height:'27%',
			minWidth:150,
			minHeight:200,
			labelWidth: 75, 
			closable:true
		}
	};
	function get_fecha_bd()
	{
	  var postData;
	  
			Ext.Ajax.request({
					url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
					params:postData,
					method:'POST',
					success:cargar_fecha_bd,
					failure: ClaseMadre_conexionFailure,
					//argument:Funcion_ConfirmSave.argument,
					timeout:paramConfig.TiempoEspera
				});
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
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
	  h_txt_fecha = ClaseMadre_getComponente('fecha');
	}
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);

	//Se agrega el botón para el acceso al detalle (SubTipo de Activos)
	this.iniciaFormulario();
	iniciarEventosFormularios()

	layout_feriado.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}