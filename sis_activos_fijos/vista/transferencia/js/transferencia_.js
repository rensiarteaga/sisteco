//<script>
function PaginaTransferencia()
{
	var vectorAtributos = new Array;
	var ds;
	var v_id_activo_fijo_empleado,cmb_id_activo_fijo;

	//Configuración página
	var paramConfig = {
		TamanoPagina:20, //para definir el tamaño de la página
		TiempoEspera:10000,//tiempo de espera para dar fallo
		CantFiltros:1,//indica la cantidad de filtros que se tendrán
		FiltroEstructura:false,//indica si se tiene los 5 combos que la filtra la estructura programática
		//FormularioEstructura:true,//indica si se tiene el los 5 combos de la estructura programatica en los formulario para que sean incluidos en las modificaciiones e iliminaciones
		FiltroAvanzado:true,
		grid_html:'ext-grid'
	};
	
	//  DATA STORE      		//
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
		}, 
		[
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'id_activo_fijo_empleado',
		'estado',
		'id_activo_fijo',
		'id_empleado',
		'desc_activo_fijo',
		'desc_empleado',
		{name: 'fecha_asig', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'descripcion_larga',
		'codigo',
		'id_empleado_anterior',
		'desc_empleado_anterior'
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
	ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: '../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_empleado',totalRecords: 'TotalCount'}, ['id_empleado','desc_nombrecompleto'])});
	ds_activo_fijo_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy
	({url: '../../control/activo_fijo_empleado/ActionListaActivoFijoEmpleadoActivos.php'}),
	reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_activo_fijo_empleado',totalRecords: 'TotalCount'}, 
	['id_activo_fijo_empleado','estado','id_activo_fijo','id_empleado','desc_activo_fijo','desc_empleado','fecha_asig','descripcion_larga','codigo','id_empleado_anterior','desc_empleado_anterior'])});

	var resultTplActivo=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642"><b>Descripción: </b>{descripcion_larga}</FONT>','<br><FONT COLOR="#B5A642"><b>Responsable: </b>{desc_empleado}</FONT>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado}</FONT>','</div>');

	////////////////FUNCIONES RENDER ////////////
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function renderActivoFijoEmpleado(value, p, record){return String.format('{0}', record.data['codigo']);}
	function renderEmpleadoAnt(value, p, record){return String.format('{0}', record.data['desc_empleado_anterior']);}
	function renderDescActivoFijo(value, p, record){return String.format('{0}', record.data['desc_activo_fijo']);}
	function renderDescripcionLarga(value, p, record){return String.format('{0}', record.data['descripcion_larga']);}

	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //

	var paramId_activo_fijo_empleado = {
		validacion:{
			labelSeparator:'',
			name: 'id_activo_fijo_empleado',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_activo_fijo_empleado'
	}
	vectorAtributos[0] = paramId_activo_fijo_empleado;

	/////////// txt Id_activo_fijo///////*
	var paramId_activo_fijo = {
		validacion:{
			fieldLabel: 'Codigo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Codigo...',
			name: 'id_activo_fijo',
			desc: 'desc_tipo_activo',
			store: ds_activo_fijo_empleado,
			valueField:'id_activo_fijo_empleado',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'af.codigo',
			typeAhead: true,
			forceSelection: true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderActivoFijoEmpleado,
			tpl:resultTplActivo,
			triggerAction: 'all',
			typeAhead: true,
			selectOnFocus:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100
		},
		id_grupo: 0,
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'af.codigo',
		save_as:'hidden_id_activo_fijo'
		
	}
	vectorAtributos[1] = paramId_activo_fijo;

	var paramDesc_activo_fijo = {
		validacion: {
			name:'desc_activo_fijo',
			fieldLabel:'Denominación',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderDescActivoFijo,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		form:false,
		tipo:'Field',
		filtro_0:true,
		//filterColValue:'desc_activo_fijo'
		filterColValue:'af.descripcion'
		
	}
	vectorAtributos[2] = paramDesc_activo_fijo;

	var paramDescripcion_larga = {
		validacion: {
			name:'descripcion_larga',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderDescripcionLarga,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'af.descripcion_larga'
		
	}
	vectorAtributos[3] = paramDescripcion_larga;

	var paramId_empleado_anterior = {
		validacion: {
			name:'id_empleado_anterior',
			fieldLabel:'Funcionario Origen',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			renderer:renderEmpleadoAnt,
			width:'95%',
			disabled: true
		},
		id_grupo: 1,
		form:false,
		tipo:'Field',
		filtro_0:false,
		filterColValue:'id_emplempleado_anterior'
				
	}
	vectorAtributos[4] = paramId_empleado_anterior;

	/////////// hidden_id_empleado//////
	var paramId_empleado = {
		validacion:{
			fieldLabel: 'Funcionario Destino',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Empleado...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField:'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'apellido_paterno',
			//filterCol:'apellido_paterno',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderEmpleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:250
		},
        id_grupo: 0,
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
		
	}
	vectorAtributos[5] = paramId_empleado;

	////////// txt estado//////
	var paramEstado = {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['id', 'desc'],
				data : Ext.trasferenciaCombo.estado // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65,
			disabled: true
		},
		id_grupo: 1,
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'afe.estado',
		save_as:'txt_estado',
		defecto:'activo'
		
	}
	vectorAtributos[6] = paramEstado;

	var paramFecha_asig = {
		validacion:{
			name: 'fecha_asig',
			fieldLabel: 'Fecha Transferencia',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80
		},
		id_grupo: 0,
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'afe.fecha_asig',
		save_as:'txt_fecha_asig',
		dateFormat:'m-d-Y'
		
	}
	vectorAtributos[7] = paramFecha_asig;

	var paramFecha_reg = {
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:80, // ancho de columna en el gris
			disabled: true
		},
		id_grupo: 1,
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'afe.fecha_reg',
		save_as:'txt_fecha_reg',
		dateFormat:'m-d-Y'
		}
	vectorAtributos[8] = paramFecha_reg;
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Transferencia",
		grid_maestro:"ext-grid"
	};
	Docs.init(config); //se manda como parámetro el vector de configuración
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds);
	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //

	var paramMenu = {
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		eliminar: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		actualizar:{
			crear :true,
			separador:false
		}
				
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	function iniciarEventosFormularios()
	{	v_id_activo_fijo_empleado = ClaseMadre_getComponente('id_activo_fijo_empleado');
	    cmb_id_activo_fijo = ClaseMadre_getComponente('id_activo_fijo');
        txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
        txt_desc_activo_fijo=ClaseMadre_getComponente('desc_activo_fijo');
	 	txt_descripcion_larga=ClaseMadre_getComponente('descripcion_larga');
	 	txt_id_empleado_anterior=ClaseMadre_getComponente('id_empleado_anterior');
	    
        
		var onActivoFijoModif = function(e) {
			var id = cmb_id_activo_fijo.getValue();
			if(cmb_id_activo_fijo.store.getById(id)!=undefined){
				v_id_activo_fijo_empleado.setValue(cmb_id_activo_fijo.store.getById(id).data.id_activo_fijo_empleado);
				txt_id_empleado_anterior.setValue(cmb_id_activo_fijo.store.getById(id).data.desc_empleado);
				txt_descripcion_larga.setValue(cmb_id_activo_fijo.store.getById(id).data.descripcion_larga);
				txt_desc_activo_fijo.setValue(cmb_id_activo_fijo.store.getById(id).data.desc_activo_fijo);
				
			}
		};

		cmb_id_activo_fijo.on('select',onActivoFijoModif);
		cmb_id_activo_fijo.on('change',onActivoFijoModif);
	}
	//datos necesarios para ell filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{	url:"../../control/activo_fijo_empleado/ActionEliminaTransferencia.php"
		},
		Save:{
			url:"../../control/activo_fijo_empleado/ActionTransfiereActivos.php"
		},
		/*Formulario:{
			html_apply:"dlgInfo",
			width:490,
			height:370,
			minWidth:150,
			minHeight:200,
			closable:true
		}*/
		Formulario:{
			html_apply:"dlgInfo",
			width:400,
			height:450,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[300,300],
			grupos:[
			{
				tituloGrupo:'Información general',
				columna:0,
				id_grupo:0
			},
			
			{	tituloGrupo:'Datos vigentes del Activo Fijo',
				columna:0,
				id_grupo:1
			}
			
			]
		}
			
	}

	function btnRepTransferencia()
	{	var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro seleccionado
			if(SelectionsRecord.data.estado=='activo') {
				data = "codigo=" + SelectionsRecord.data.codigo;
				data = data + "&estado=" + SelectionsRecord.data.estado;
				data = data + "&descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
				data = data + "&id_empleado_anterior=" + SelectionsRecord.data.id_empleado_anterior;
				data = data + "&id_empleado=" + SelectionsRecord.data.id_empleado;
				data = data + "&fecha_asig=" + formatDate(SelectionsRecord.data.fecha_asig);
				//alert('pasa fecha');
				Docs.loadTab('../../control/_reportes/activo_fijo_transferencia_vista/ActionPDFActivoFijoTransferenciaVista.php?'+data, "Form. Transferencia ["+ SelectionsRecord.data.id_activo_fijo_empleado +"]");
			}else
			{	Ext.MessageBox.alert('Estado', 'El Estado es Inactivo.');		}
		}

		else
		{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');		}
	}

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Form. Transferencia<b>',btnRepTransferencia,true,'Generar','Form. Transferencia');
	this.iniciaFormulario();
	innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	iniciarEventosFormularios();
}
var obj_pagina;
function main ()
{	obj_pagina = new PaginaTransferencia();
}
YAHOO.util.Event.on(window, 'load', main); //arranca todo