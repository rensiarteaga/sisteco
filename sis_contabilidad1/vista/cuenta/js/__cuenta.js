/**
 * Nombre:		  	    pagina_cuenta_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 11:01:41
 */
function pagina_cuenta(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_cuenta',
		'desc_cuenta',
		'nro_cuenta',
		'descripcion',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'id_cuenta_padre'

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

    ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta',
			totalRecords: 'TotalCount'
		}, ['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','id_cuenta_padre'])
	});

	//FUNCIONES RENDER
	
			function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta
	//en la posición 0 siempre esta la llave primaria

	var param_id_cuenta = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_cuenta'
	};
	vectorAtributos[0] = param_id_cuenta;
	
// txt nro_cuenta
	var param_nro_cuenta= {
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'Cuenta',
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
		filterColValue:'CUENTA.nro_cuenta',
		save_as:'txt_nro_cuenta'
	};
	vectorAtributos[1] = param_nro_cuenta;
//txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
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
		filterColValue:'CUENTA.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[2] = param_descripcion;
// txt fecha_registro
	var param_fecha_registro= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Registro',
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
		filterColValue:'CUENTA.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro'
	};
	vectorAtributos[3] = param_fecha_registro;
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
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CUENTA.hora_registro',
		save_as:'txt_hora_registro'
	};
	vectorAtributos[4] = param_hora_registro;
// txt fecha_ultima_modificacion
	var param_fecha_ultima_modificacion= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Mod',
			allowBlank:true,
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
		filterColValue:'CUENTA.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion'
	};
	vectorAtributos[5] = param_fecha_ultima_modificacion;
// txt hora_ultima_modificacion
	var param_hora_ultima_modificacion= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Mod',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CUENTA.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion'
	};
	vectorAtributos[6] = param_hora_ultima_modificacion;
// txt id_cuenta_padre
	var param_id_cuenta_padre= {
		validacion:{
			name:'id_cuenta_padre',
			fieldLabel:'Cuenta Padre',
			allowBlank:true,
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
		filterColValue:'CUENTA.id_cuenta_padre',
		save_as:'txt_id_cuenta_padre'
	};
	vectorAtributos[7] = param_id_cuenta_padre;

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
		titulo_maestro:'cuenta',
		grid_maestro:'grid-'+idContenedor
	};
	layout_cuenta=new DocsLayoutMaestro(idContenedor);
	layout_cuenta.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_cuenta,idContenedor);
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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/cuenta/ActionEliminarCuenta.php'},
		Save:{url:direccion+'../../../control/cuenta/ActionGuardarCuenta.php'},
		ConfirmSave:{url:direccion+'../../../control/cuenta/ActionGuardarCuenta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,
			minWidth:150,minHeight:200,	closable:true,titulo:'cuenta'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_plan_cuenta(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			window.open(direccion+'../../../control/cuenta/reporte/ActionPDFListaCuentas.php')
       }
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cuenta.getLayout();};
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
                this.AdicionarBoton('../../../lib/imagenes/print.gif','Plan de Cuentas',btn_plan_cuenta,true,'plan de cuenta','');
		
				layout_cuenta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}