/**
 * Nombre:		  	    pagina_sucursal_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-24 18:28:46
 */
function pagina_sucursal(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sucursal/ActionListarSucursal.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sucursal',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_sucursal',
			'nombre',
			'razon_social',
			'nit',
			'direccion',
			'proyecto',
			'usuario_reg',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}
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
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_sucursal',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_sucursal',
		id_grupo:0
	};
	 
// txt codigo
	vectorAtributos[1]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Sucursal',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUCURS.nombre',
		save_as:'txt_nombre',
		id_grupo:1
	};

// txt descripcion
	vectorAtributos[2]= {
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUCURS.razon_social',
		save_as:'txt_razon_social',
		id_grupo:1
	};
	
// txt observaciones
	vectorAtributos[3]= {
		validacion:{
			name:'nit',
			fieldLabel:'NIT',
			allowBlank:false,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width:'50%',
			width_grid:80
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUCURS.nit',
		save_as:'txt_nit',
		id_grupo:1
	};
	
// txt direccion
	vectorAtributos[4]= {
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:false,
			maxLength:70,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'100%',
			grid_editable:true,
			width_grid:250
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUCURS.direccion',
		save_as:'txt_direccion',
		id_grupo:1
	};
	
// txt descripcion
	vectorAtributos[5]= {
		validacion:{
			name:'proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUCURS.proyecto',
		save_as:'txt_proyecto',
		id_grupo:1
	};
	
// txt observaciones
	vectorAtributos[6]= {
		validacion:{
			name:'usuario_reg',
			fieldLabel:'Registrado por',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width:'100%',
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'SUCURS.usuario_reg',
		save_as:'txt_usuario_reg',
		id_grupo:0
	};
	
// txt fecha_reg
	vectorAtributos[7]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			width:'150%',
			disabled:true
		},
		tipo:'DateField',
		form: false,
		filtro_0:false,
		filtro_1:false,
		filterColValue:'SUCURS.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:2
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'sucursal',
		grid_maestro:'grid-'+idContenedor
	};
	layout_sucursal=new DocsLayoutMaestro(idContenedor);
	layout_sucursal.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_sucursal,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
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
		btnEliminar:{url:direccion+'../../../control/sucursal/ActionEliminarSucursal.php'},
		Save:{url:direccion+'../../../control/sucursal/ActionGuardarSucursal.php'},
		ConfirmSave:{url:direccion+'../../../control/sucursal/ActionGuardarSucursal.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'35%',
		width:'30%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'Sucursal',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Datos de Sucursal',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Datos de Registro',
				columna:0,
				id_grupo:2}
				]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//h_txt_fecha_registro= ClaseMadre_getComponente('fecha_reg')
	}

	function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			})
	}

 	function cargar_fecha_bd(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			//h_txt_fecha_registro.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			//h_txt_fecha_registro.disable(true)
		}
	}
		
	this.btnNew = function(){	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Sucursal');
		CM_ocultarGrupo('Datos de Registro');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		dialog.resizeTo('45%','55%');
		var SelectionsRecord  = sm.getSelected();
		//get_fecha_bd();
		CM_mostrarGrupo('Datos de Sucursal');
		ClaseMadre_btnNew()	
	};
	
	this.btnEdit=function(){ 	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Datos de Sucursal');;
		CM_ocultarGrupo('Datos de Registro');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		dialog.resizeTo('45%','55%');	
		CM_mostrarGrupo('Datos de Sucursal');
		//get_fecha_bd();
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaSucursal(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		var sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_sucursal.getLayout()};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSucursal();
	layout_sucursal.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}