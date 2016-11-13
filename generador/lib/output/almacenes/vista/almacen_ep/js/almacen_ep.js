/**
 * Nombre:		  	    pagina_almacen_ep_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-12 16:30:30
 */
function pagina_almacen_ep(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_ep/ActionListarAlmacenEp.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_ep',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_almacen_ep',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_fina_regi_prog_proy_acti',
		'desc_fina_regi_prog_proy_acti',
		'desc_almacen',
		'id_almacen'

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

    ds_fina_regi_prog_proy_acti = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActi.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fina_regi_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, ['id_fina_regi_prog_proy_acti','id_prog_proy_acti','id_regional','id_financiador'])
	});

    ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'
		}, ['id_almacen','codigo','nombre','descripcion','direccion','via_fil_max','via_col_max','bloqueado','bloquear','cerrado','nro_prest_pendientes','nro_ing_no_finalizados','nro_sal_no_finalizadas','observaciones','fecha_ultimo_inventario','fecha_reg','id_regional'])
	});

	//FUNCIONES RENDER
	
			function render_id_fina_regi_prog_proy_acti(value, p, record){return String.format('{0}', record.data['desc_fina_regi_prog_proy_acti']);}
			function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_almacen_ep
	//en la posición 0 siempre esta la llave primaria

	var param_id_almacen_ep = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_almacen_ep',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_almacen_ep'
	};
	vectorAtributos[0] = param_id_almacen_ep;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
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
		filterColValue:'ALMAEP.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[1] = param_descripcion;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
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
		filterColValue:'ALMAEP.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[2] = param_observaciones;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
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
		filterColValue:'ALMAEP.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[3] = param_fecha_reg;
// txt id_fina_regi_prog_proy_acti
	var param_id_fina_regi_prog_proy_acti= {
			validacion: {
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'EP',
			allowBlank:false,			
			emptyText:'EP...',
			name: 'id_fina_regi_prog_proy_acti',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_fina_regi_prog_proy_acti', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fina_regi_prog_proy_acti,
			valueField: 'id_fina_regi_prog_proy_acti',
			displayField: 'id_prog_proy_acti',
			queryParam: 'filterValue_0',
			filterCol:'FRPPA.id_prog_proy_acti',
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
			renderer:render_id_fina_regi_prog_proy_acti,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'FRPPA.id_prog_proy_acti',
		defecto: '',
		save_as:'txt_id_fina_regi_prog_proy_acti'
	};
	vectorAtributos[4] = param_id_fina_regi_prog_proy_acti;
// txt id_almacen
	var param_id_almacen= {
			validacion: {
			name:'id_almacen',
			fieldLabel:'Almacen',
			allowBlank:false,			
			emptyText:'Almacen...',
			name: 'id_almacen',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.codigo#ALMACE.nombre#ALMACE.descripcion',
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
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.codigo',
		defecto: '',
		save_as:'txt_id_almacen'
	};
	vectorAtributos[5] = param_id_almacen;

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
		titulo_maestro:'almacen_ep',
		grid_maestro:'grid-'+idContenedor
	};
	layout_almacen_ep = new DocsLayoutMaestro(idContenedor);
	layout_almacen_ep.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_almacen_ep,idContenedor);
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
			url:direccion+'../../../control/almacen_ep/ActionEliminarAlmacenEp.php'
		},
		Save:{
			url:direccion+'../../../control/almacen_ep/ActionGuardarAlmacenEp.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/almacen_ep/ActionGuardarAlmacenEp.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'almacen_ep'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_almacen_logico(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_almacen_ep='+SelectionsRecord.data.id_almacen_ep;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;

			var ParamVentana={ventan:{width:'90%',height:'70%'}}
			layout_almacen_ep.loadWindows(direccion+'../../almacen_logico/almacen_logico_det.php?'+data,'Almacenes Lógicos',ParamVentana);
layout_almacen_ep.getVentana().on('resize',function(){
			layout_almacen_ep.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_almacen_ep.getLayout();
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
				
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_almacen_logico,true,'almacen_logico','Almacenes Lógicos');

				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_almacen_ep.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}