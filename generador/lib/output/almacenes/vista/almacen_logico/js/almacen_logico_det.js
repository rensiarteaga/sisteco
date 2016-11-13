/**
 * Nombre:		  	    pagina_almacen_logico_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-12 16:30:46
 */
function pagina_almacen_logico_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogico_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_logico',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_almacen_logico',
		'codigo',
		'bloqueado',
		'nombre',
		'descripcion',
		'estado_registro',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'obsevaciones',
		'id_almacen_ep',
		'desc_almacen_ep',
		'desc_tipo_almacen',
		'id_tipo_almacen'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_almacen_ep:maestro.id_almacen_ep
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
var dataMaestro=[['Id Almacen EP',maestro.id_almacen_ep],['Descripción',maestro.descripcion],['Observaciones',maestro.observaciones]];

	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_tipo_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../Almacenes/control/tipo_almacen/ActionListarTipoAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_almacen',
			totalRecords: 'TotalCount'
		}, ['id_tipo_almacen','descripcion','observaciones','tipo_almacen'])
	});

	//FUNCIONES RENDER
	
			function render_id_tipo_almacen(value, p, record){return String.format('{0}', record.data['desc_tipo_almacen']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_almacen_logico
	//en la posición 0 siempre esta la llave primaria

	var param_id_almacen_logico = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_almacen_logico',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_logico'
	};
	vectorAtributos[0] = param_id_almacen_logico;
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
		filterColValue:'ALMLOG.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[1] = param_codigo;
// txt bloqueado
	var param_bloqueado= {
			validacion: {
			name:'bloqueado',
			fieldLabel:'Bloqueado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.almacen_logico_combo.bloqueado
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
		filterColValue:'ALMLOG.bloqueado',
		defecto:'si',
		save_as:'txt_bloqueado'
	};
	vectorAtributos[2] = param_bloqueado;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
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
		filterColValue:'ALMLOG.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[3] = param_nombre;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
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
		filterColValue:'ALMLOG.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[4] = param_descripcion;
// txt estado_registro
	var param_estado_registro= {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado Registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.almacen_logico_combo.estado_registro
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
		filterColValue:'ALMLOG.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	vectorAtributos[5] = param_estado_registro;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fehca Registro',
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
		filterColValue:'ALMLOG.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[6] = param_fecha_reg;
// txt obsevaciones
	var param_obsevaciones= {
		validacion:{
			name:'obsevaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:100,
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
		filterColValue:'ALMLOG.obsevaciones',
		save_as:'txt_obsevaciones'
	};
	vectorAtributos[7] = param_obsevaciones;
// txt id_almacen_ep
	var param_id_almacen_ep= {
		validacion:{
			name:'id_almacen_ep',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_almacen_ep,
		save_as:'txt_id_almacen_ep'
	};
	vectorAtributos[8] = param_id_almacen_ep;
// txt id_tipo_almacen
	var param_id_tipo_almacen= {
			validacion: {
			name:'id_tipo_almacen',
			fieldLabel:'Tipo Almacen',
			allowBlank:false,			
			emptyText:'Tipo Almacen...',
			name: 'id_tipo_almacen',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_tipo_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_almacen,
			valueField: 'id_tipo_almacen',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPALM.descripcion#TIPALM.observaciones',
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
			renderer:render_id_tipo_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPALM.descripcion',
		defecto: '',
		save_as:'txt_id_tipo_almacen'
	};
	vectorAtributos[9] = param_id_tipo_almacen;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Actividad de Almacenes (Maestro)',
		titulo_detalle:'Almacenes Lógicos (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_almacen_logico = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_almacen_logico.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen_logico,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/almacen_logico/ActionEliminarAlmacenLogico.php'},
	Save:{url:direccion+'../../../control/almacen_logico/ActionGuardarAlmacenLogico.php'},
	ConfirmSave:{url:direccion+'../../../control/almacen_logico/ActionGuardarAlmacenLogico.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'almacen_logico'}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_almacen_logico.getLayout();
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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_almacen_logico.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}