/**
 * Nombre:		  	    pagina_metaproceso_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-10 12:08:21
 */
function pagina_metaproceso(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_metaproceso',
		'id_subsistema',
		'desc_subsistema',
		'fk_id_metaproceso',
		'desc_metaproceso',
		'nivel',
		'nombre',
		'codigo_procedimiento',
		'nombre_achivo',
		'ruta_archivo',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		'fecha_ultima_modificacion',
		'hora_ultima_modificacion',
		'descripcion',
		'visible',
		'habilitar_log',
		'orden_logico',
		'icono',
		'nombre_tabla',
		'prefijo',
		'codigo_base',
		'tipo_vista',
		'con_ep',
		'con_interfaz',
		'num_datos_hijo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, ['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones'])
	});

    ds_metaproceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'
		}, ['id_metaproceso','id_subsistema','fk_id_metaproceso','nivel','nombre','codigo_procedimiento','nombre_achivo','ruta_archivo','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion','visible','habilitar_log','orden_logico','icono','nombre_tabla','prefijo','codigo_base','tipo_vista','con_ep','con_interfaz','num_datos_hijo'])
	});

	//FUNCIONES RENDER
	
			function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
			function render_fk_id_metaproceso(value, p, record){return String.format('{0}', record.data['desc_metaproceso']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_metaproceso
	//en la posición 0 siempre esta la llave primaria

	var param_id_metaproceso = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_metaproceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_metaproceso'
	};
	vectorAtributos[0] = param_id_metaproceso;
// txt id_subsistema
	var param_id_subsistema= {
			validacion: {
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,
			
			
			emptyText:'Subsistema...',
			name: 'id_subsistema',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto#SUBSIS.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_corto',
		defecto: '',
		save_as:'txt_id_subsistema'
	};
	vectorAtributos[1] = param_id_subsistema;
// txt fk_id_metaproceso
	var param_fk_id_metaproceso= {
			validacion: {
			name:'fk_id_metaproceso',
			fieldLabel:'Metaproceso Padre',
			allowBlank:false,
			
			
			emptyText:'Metaproceso Padre...',
			name: 'fk_id_metaproceso',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_metaproceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_metaproceso,
			valueField: 'id_metaproceso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'METPRO.nombre#METPRO.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_fk_id_metaproceso,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO_2.nombre',
		defecto: '',
		save_as:'txt_fk_id_metaproceso'
	};
	vectorAtributos[2] = param_fk_id_metaproceso;
// txt nivel
	var param_nivel= {
		validacion:{
			name:'nivel',
			fieldLabel:'nivel',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nivel',
		save_as:'txt_nivel'
	};
	vectorAtributos[3] = param_nivel;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[4] = param_nombre;
// txt codigo_procedimiento
	var param_codigo_procedimiento= {
		validacion:{
			name:'codigo_procedimiento',
			fieldLabel:'Codigo Proc',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.codigo_procedimiento',
		save_as:'txt_codigo_procedimiento'
	};
	vectorAtributos[5] = param_codigo_procedimiento;
// txt nombre_achivo
	var param_nombre_achivo= {
		validacion:{
			name:'nombre_achivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre_achivo',
		save_as:'txt_nombre_achivo'
	};
	vectorAtributos[6] = param_nombre_achivo;
// txt ruta_archivo
	var param_ruta_archivo= {
		validacion:{
			name:'ruta_archivo',
			fieldLabel:'Ruta Archivo',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.ruta_archivo',
		save_as:'txt_ruta_archivo'
	};
	vectorAtributos[7] = param_ruta_archivo;
// txt fecha_registro
	var param_fecha_registro= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Reg',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro'
	};
	vectorAtributos[8] = param_fecha_registro;
// txt hora_registro
	var param_hora_registro= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.hora_registro',
		save_as:'txt_hora_registro'
	};
	vectorAtributos[9] = param_hora_registro;
// txt fecha_ultima_modificacion
	var param_fecha_ultima_modificacion= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Modificación',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.fecha_ultima_modificacion',
		save_as:'txt_fecha_ultima_modificacion'
	};
	vectorAtributos[10] = param_fecha_ultima_modificacion;
// txt hora_ultima_modificacion
	var param_hora_ultima_modificacion= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Modificación',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion'
	};
	vectorAtributos[11] = param_hora_ultima_modificacion;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[12] = param_descripcion;
// txt visible
	var param_visible= {
			validacion: {
			name:'visible',
			fieldLabel:'Visible',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.visible
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.visible',
		defecto:'si',
		save_as:'txt_visible'
	};
	vectorAtributos[13] = param_visible;
// txt habilitar_log
	var param_habilitar_log= {
			validacion: {
			name:'habilitar_log',
			fieldLabel:'Habilitar Log',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.habilitar_log
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.habilitar_log',
		defecto:'si',
		save_as:'txt_habilitar_log'
	};
	vectorAtributos[14] = param_habilitar_log;
// txt orden_logico
	var param_orden_logico= {
		validacion:{
			name:'orden_logico',
			fieldLabel:'Orden Lógico',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.orden_logico',
		save_as:'txt_orden_logico'
	};
	vectorAtributos[15] = param_orden_logico;
// txt icono
	var param_icono= {
		validacion:{
			name:'icono',
			fieldLabel:'Icono',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.icono',
		save_as:'txt_icono'
	};
	vectorAtributos[16] = param_icono;
// txt nombre_tabla
	var param_nombre_tabla= {
		validacion:{
			name:'nombre_tabla',
			fieldLabel:'Nombre de la Tabla',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre_tabla',
		save_as:'txt_nombre_tabla'
	};
	vectorAtributos[17] = param_nombre_tabla;
// txt prefijo
	var param_prefijo= {
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.prefijo',
		save_as:'txt_prefijo'
	};
	vectorAtributos[18] = param_prefijo;
// txt codigo_base
	var param_codigo_base= {
		validacion:{
			name:'codigo_base',
			fieldLabel:'Codigo Base',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.codigo_base',
		save_as:'txt_codigo_base'
	};
	vectorAtributos[19] = param_codigo_base;
// txt tipo_vista
	var param_tipo_vista= {
			validacion: {
			name:'tipo_vista',
			fieldLabel:'Tipo Vista',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.tipo_vista
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.tipo_vista',
		defecto:'padre',
		save_as:'txt_tipo_vista'
	};
	vectorAtributos[20] = param_tipo_vista;
// txt con_ep
	var param_con_ep= {
			validacion: {
			name:'con_ep',
			fieldLabel:'Con EP',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.con_ep
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.con_ep',
		defecto:'si',
		save_as:'txt_con_ep'
	};
	vectorAtributos[21] = param_con_ep;
// txt con_interfaz
	var param_con_interfaz= {
			validacion: {
			name:'con_interfaz',
			fieldLabel:'Con Interfaz',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.metaproceso_combo.con_interfaz
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.con_interfaz',
		defecto:'si',
		save_as:'txt_con_interfaz'
	};
	vectorAtributos[22] = param_con_interfaz;
// txt num_datos_hijo
	var param_num_datos_hijo= {
		validacion:{
			name:'num_datos_hijo',
			fieldLabel:'Numero datos de Hijo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.num_datos_hijo',
		save_as:'txt_num_datos_hijo'
	};
	vectorAtributos[23] = param_num_datos_hijo;

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'metaproceso',
		grid_maestro:'grid-'+idContenedor
	};
	layout_metaproceso = new DocsLayoutMaestro(idContenedor);
	layout_metaproceso.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_metaproceso,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

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
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+'../../../control/metaproceso/ActionEliminarMetaproceso.php'
		},
		Save:{
			url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/metaproceso/ActionGuardarMetaproceso.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'metaproceso'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_activo.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btnSubtipos,true, 'subtipos','Subtipos de Activos Fijos');
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_metaproceso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}