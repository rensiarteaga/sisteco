/**
 * Nombre:		  	    pagina_tipo_transferencia_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-02 11:12:19
 */
function pagina_tipo_transferencia(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds,layout_tipo_transferencia;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_transferencia/ActionListarTipoTransferencia.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_transferencia',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_transferencia',
		'nombre',
		'descripcion',
		'observaciones',
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
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_transferencia
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_tipo_transferencia',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_transferencia'
	};
	// txt nombre
	vectorAtributos[1] = {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_nombre'
	};
	// txt descripcion
	vectorAtributos[2] = {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_descripcion'
	};
	// txt observaciones
	vectorAtributos[3] = {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		save_as:'txt_observaciones'
	};
	// txt fecha_reg
	vectorAtributos[4] = {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	
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
		titulo_maestro:'tipo_transferencia',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tipo_transferencia = new DocsLayoutMaestro(idContenedor);
	layout_tipo_transferencia.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_transferencia,idContenedor);
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
			url:direccion+'../../../control/tipo_transferencia/ActionEliminarTipoTransferencia.php'
		},
		Save:{
			url:direccion+'../../../control/tipo_transferencia/ActionGuardarTipoTransferencia.php'
		},
		ConfirmSave:{
			url:direccion+'../../../control/tipo_transferencia/ActionGuardarTipoTransferencia.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:480,
			height:340,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo: 'Tipo Transferencia'
		}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	this.btnNew=function(){	
		ClaseMadre_btnNew();
		get_fecha_bd();
	};
	  function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	};
	function cargar_fecha_bd(resp){   
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(componentes[4].getValue()==""){
				componentes[4].setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		}
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		sm=getSelectionModel()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_activo.getLayout()
	};
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
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
    layout_tipo_transferencia.getLayout().addListener('layout',this.onResize)
}