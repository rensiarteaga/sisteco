/**
 * Nombre:		  	    pagina_almacen_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-11 16:16:55
 */
function pagina_almacen(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_almacen',
		'codigo',
		'nombre',
		'descripcion',
		'direccion',
		'via_fil_max',
		'via_col_max',
		'bloqueado',
		'bloquear',
		'cerrado',
		'nro_prest_pendientes',
		'nro_ing_no_finalizados',
		'nro_sal_no_finalizadas',
		'observaciones',
		{name: 'fecha_ultimo_inventario',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_regional',
		'id_regional'

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

    ds_regional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListarRegional.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'
		}, ['id_regional','codigo_regional','nombre_regional','descripcion_regional','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_regional(value, p, record){return String.format('{0}', record.data['desc_regional']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_almacen
	//en la posición 0 siempre esta la llave primaria

	var param_id_almacen = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_almacen',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen'
	};
	vectorAtributos[0] = param_id_almacen;
// txt codigo
	var param_codigo= {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[1] = param_codigo;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[2] = param_nombre;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[3] = param_descripcion;
// txt direccion
	var param_direccion= {
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.direccion',
		save_as:'txt_direccion'
	};
	vectorAtributos[4] = param_direccion;
// txt via_fil_max
	var param_via_fil_max= {
		validacion:{
			name:'via_fil_max',
			fieldLabel:'Cantidad de Filas Maximas',
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
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.via_fil_max',
		save_as:'txt_via_fil_max'
	};
	vectorAtributos[5] = param_via_fil_max;
// txt via_col_max
	var param_via_col_max= {
		validacion:{
			name:'via_col_max',
			fieldLabel:'Cantidad de Columnas Maximas',
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
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.via_col_max',
		save_as:'txt_via_col_max'
	};
	vectorAtributos[6] = param_via_col_max;
// txt bloqueado
	var param_bloqueado= {
			validacion: {
			name:'bloqueado',
			fieldLabel:'Boqueado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.almacen_combo.bloqueado
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.bloqueado',
		defecto:'si',
		save_as:'txt_bloqueado'
	};
	vectorAtributos[7] = param_bloqueado;
// txt bloquear
	var param_bloquear= {
			validacion: {
			name:'bloquear',
			fieldLabel:'Boquear',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.almacen_combo.bloquear
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.bloquear',
		defecto:'si',
		save_as:'txt_bloquear'
	};
	vectorAtributos[8] = param_bloquear;
// txt cerrado
	var param_cerrado= {
			validacion: {
			name:'cerrado',
			fieldLabel:'Cerrado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.almacen_combo.cerrado
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.cerrado',
		defecto:'si',
		save_as:'txt_cerrado'
	};
	vectorAtributos[9] = param_cerrado;
// txt nro_prest_pendientes
	var param_nro_prest_pendientes= {
		validacion:{
			name:'nro_prest_pendientes',
			fieldLabel:'Cant. Prestamos Pendientes ',
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
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.nro_prest_pendientes',
		save_as:'txt_nro_prest_pendientes'
	};
	vectorAtributos[10] = param_nro_prest_pendientes;
// txt nro_ing_no_finalizados
	var param_nro_ing_no_finalizados= {
		validacion:{
			name:'nro_ing_no_finalizados',
			fieldLabel:'Cantidad de Ing no Realizados ',
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
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.nro_ing_no_finalizados',
		save_as:'txt_nro_ing_no_finalizados'
	};
	vectorAtributos[11] = param_nro_ing_no_finalizados;
// txt nro_sal_no_finalizadas
	var param_nro_sal_no_finalizadas= {
		validacion:{
			name:'nro_sal_no_finalizadas',
			fieldLabel:'Cant. Salidad no Finalizadas',
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
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.nro_sal_no_finalizadas',
		save_as:'txt_nro_sal_no_finalizadas'
	};
	vectorAtributos[12] = param_nro_sal_no_finalizadas;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[13] = param_observaciones;
// txt fecha_ultimo_inventario
	var param_fecha_ultimo_inventario= {
		validacion:{
			name:'fecha_ultimo_inventario',
			fieldLabel:'Fecha Reg de Ultimo Inventarios',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.fecha_ultimo_inventario',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultimo_inventario'
	};
	vectorAtributos[14] = param_fecha_ultimo_inventario;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[15] = param_fecha_reg;
// txt id_regional
	var param_id_regional= {
			validacion: {
			name:'id_regional',
			fieldLabel:'Regional',
			allowBlank:false,			
			emptyText:'Regional...',
			name: 'id_regional',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_regional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'codigo_regional',
			queryParam: 'filterValue_0',
			filterCol:'REGION.codigo_regional#REGION.descripcion_regional',
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
			renderer:render_id_regional,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'REGION.codigo_regional',
		defecto: '',
		save_as:'txt_id_regional'
	};
	vectorAtributos[16] = param_id_regional;

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
		titulo_maestro:'almacen',
		grid_maestro:'grid-'+idContenedor
	};
	layout_almacen = new DocsLayoutMaestro(idContenedor);
	layout_almacen.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen,idContenedor);
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
			url:direccion+'../../../control/almacen/ActionEliminarAlmacen.php'
		},
		Save:{
			url:direccion+'../../../control/almacen/ActionGuardarAlmacen.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/almacen/ActionGuardarAlmacen.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'almacen'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_almacen.getLayout();
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
				
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}