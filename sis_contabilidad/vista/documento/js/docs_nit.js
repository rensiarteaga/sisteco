/**
* Nombre:		  	    pagina_docs_nit.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_docs_nit(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	
	var dialog;
	var habilita_hijo='si';
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocsNit.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'nro_reg',totalRecords:'TotalCount'
		},[
			'nro_nit'
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
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
	//en la posición 0 siempre esta la llave primaria

   Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'nro_reg',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:300,
			disabled:false
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'nro_nit',
		id_grupo:0
	};
	
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'EEFF',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/documento/docs_nit_det.php'};
    layout_nit=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_nit.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_nit,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/docs_nit/ActionEliminarEeffCom.php'},
		Save:{url:direccion+'../../../control/docs_nit/ActionGuardarNit.php'},
		ConfirmSave:{url:direccion+'../../../control/docs_nit/ActionGuardarNit.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:480,minWidth:150,minHeight:200,closable:true,titulo:'EEFF Comparativo',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		dialog=Cm_getDialog();
		getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_nit.getIdContentHijo()).pagina.limpiarStore()){}
		})
	}
	
	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_nit.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_nit.getIdContentHijo()).pagina.bloquearMenu();
	    _CP.getPagina(layout_nit.getIdContentHijo()).pagina.desbloquearMenu();
	    
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();
	    _CP.getPagina(idContenedor).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_nit.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_nit.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
