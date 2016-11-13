/**
 * Nombre:		  	    pagina_subsistema_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-10 11:02:01
 */
function pagina_subsistema(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_subsistema',
		'nombre_corto',
		'nombre_largo',
		'descripcion',
		'version_desarrollo',
		'desarrolladores',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'hora_reg',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'observaciones',

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

	//FUNCIONES RENDER
	;
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_subsistema
	//en la posición 0 siempre esta la llave primaria

	var param_id_subsistema = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_subsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_subsistema'
	};
	vectorAtributos[0] = param_id_subsistema;
// txt nombre_corto
	var param_nombre_corto= {
		validacion:{
			name:'nombre_corto',
			fieldLabel:'nombre_corto',
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
		filterColValue:'SUBSIS.nombre_corto',
		save_as:'txt_nombre_corto'
	};
	vectorAtributos[1] = param_nombre_corto;
// txt nombre_largo
	var param_nombre_largo= {
		validacion:{
			name:'nombre_largo',
			fieldLabel:'nombre_largo',
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
		filterColValue:'SUBSIS.nombre_largo',
		save_as:'txt_nombre_largo'
	};
	vectorAtributos[2] = param_nombre_largo;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'descripcion',
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
		filterColValue:'SUBSIS.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[3] = param_descripcion;
// txt version_desarrollo
	var param_version_desarrollo= {
		validacion:{
			name:'version_desarrollo',
			fieldLabel:'version_desarrollo',
			allowBlank:false,
			maxLength:20,
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
		filterColValue:'SUBSIS.version_desarrollo',
		save_as:'txt_version_desarrollo'
	};
	vectorAtributos[4] = param_version_desarrollo;
// txt desarrolladores
	var param_desarrolladores= {
		validacion:{
			name:'desarrolladores',
			fieldLabel:'desarrolladores',
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
		filterColValue:'SUBSIS.desarrolladores',
		save_as:'txt_desarrolladores'
	};
	vectorAtributos[5] = param_desarrolladores;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'fecha_reg',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[6] = param_fecha_reg;
// txt hora_reg
	var param_hora_reg= {
		validacion:{
			name:'hora_reg',
			fieldLabel:'Hora Reg',
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
		filterColValue:'SUBSIS.hora_reg',
		save_as:'txt_hora_reg'
	};
	vectorAtributos[7] = param_hora_reg;
// txt fecha_ultima_modificacion
	var param_fecha_ultima_modificacion= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Mod',
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
		filterColValue:'SUBSIS.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion'
	};
	vectorAtributos[8] = param_fecha_ultima_modificacion;
// txt hora_ultima_modificacion
	var param_hora_ultima_modificacion= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Ultima Mod',
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
		filterColValue:'SUBSIS.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion'
	};
	vectorAtributos[9] = param_hora_ultima_modificacion;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'observaciones',
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
		filterColValue:'SUBSIS.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[10] = param_observaciones;

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
		titulo_maestro:'subsistema',
		grid_maestro:'grid-'+idContenedor
	};
	layout_subsistema = new DocsLayoutMaestro(idContenedor);
	layout_subsistema.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_subsistema,idContenedor);
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
			url:direccion+'../../../control/subsistema/ActionEliminarSubsistema.php'
		},
		Save:{
			url:direccion+'../../../control/subsistema/ActionGuardarSubsistema.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/subsistema/ActionGuardarSubsistema.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'subsistema'
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

				layout_subsistema.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}