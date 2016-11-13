/**
 * Nombre:		  	    pagina_motivo_ingreso_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-11 12:14:40
 */
function pagina_motivo_ingreso(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngreso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_motivo_ingreso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_motivo_ingreso',
		'nombre',
		'descripcion',
		'estado_registro',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'desc_cuenta',
		'id_cuenta'

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

    ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_Contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta',
			totalRecords: 'TotalCount'
		}, ['id_cuenta','cod_cuenta','descripcion','moneda','debe_bs','haber_bs','debe_us','haber_us','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_motivo_ingreso
	//en la posición 0 siempre esta la llave primaria

	var param_id_motivo_ingreso = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_motivo_ingreso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_motivo_ingreso'
	};
	vectorAtributos[0] = param_id_motivo_ingreso;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:70,
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
		filterColValue:'MOTING.nombre',
		save_as:'txt_nombre'
	};
	vectorAtributos[1] = param_nombre;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
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
		filterColValue:'MOTING.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[2] = param_descripcion;
// txt estado_registro
	var param_estado_registro= {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.motivo_ingreso_combo.estado_registro
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
		filterColValue:'MOTING.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	vectorAtributos[3] = param_estado_registro;
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
		filterColValue:'MOTING.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[4] = param_fecha_reg;
// txt id_cuenta
	var param_id_cuenta= {
			validacion: {
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			name: 'id_cuenta',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.',
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
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CUENTA.',
		defecto: '',
		save_as:'txt_id_cuenta'
	};
	vectorAtributos[5] = param_id_cuenta;

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
		titulo_maestro:'motivo_ingreso',
		grid_maestro:'grid-'+idContenedor
	};
	layout_motivo_ingreso = new DocsLayoutMaestro(idContenedor);
	layout_motivo_ingreso.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_motivo_ingreso,idContenedor);
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
			url:direccion+'../../../control/motivo_ingreso/ActionEliminarMotivoIngreso.php'
		},
		Save:{
			url:direccion+'../../../control/motivo_ingreso/ActionGuardarMotivoIngreso.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/motivo_ingreso/ActionGuardarMotivoIngreso.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'motivo_ingreso'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_motivo_ingreso.getLayout();
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

				layout_motivo_ingreso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}