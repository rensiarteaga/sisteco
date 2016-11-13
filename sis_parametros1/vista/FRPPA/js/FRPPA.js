/**
 * Nombre:		  	    pagina_FRPPA_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 11:34:02
 */
function pagina_FRPPA(idContenedor,direccion,paramConfig, maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var grid;
	var dialog;
	var formulario;
	var componentes=new Array();
	var bandera=0;
	/////////////////
	//  DATA STORE //
	/////////////////

	//FUNCIONES RENDER
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActi.php?m_id_asignacion_estructura='+maestro.id_asignacion_estructura}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fina_regi_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_fina_regi_prog_proy_acti',
			'desc_frppa'
			]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_asignacion_estructura:maestro.id_asignacion_estructura
		}
	});
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_fina_regi_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_fina_regi_prog_proy_acti',
		id_grupo:0
	};
	 
// txt nombre
	vectorAtributos[1]= {
		validacion:{
			name:'desc_frppa',
			fieldLabel:'FRPPA',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:500,
			vtype:"texto",
			width:'65%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'FRPPA.nombre',
		save_as:'txt_desc_frppa',
		id_grupo:1
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
		titulo_maestro:'FRPPA',
		grid_maestro:'grid-'+idContenedor
	};
	layout_frppa=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_frppa.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_frppa,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_saveSuccess= this.saveSuccess;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}*/
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/asignacion_estructura/ActionEliminarAsignacionEstructura.php'},
		Save:{url:direccion+'../../../control/asignacion_estructura/ActionGuardarAsignacionEstructura.php'},
		ConfirmSave:{url:direccion+'../../../control/asignacion_estructura/ActionGuardarAsignacionEstructura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:30,
		width:50,
			minWidth:30,minHeight:50,	closable:true,titulo:'Asignación de Estructura',
			columnas:['50%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos de Estructura a Asignar',
				columna:0,
				id_grupo:1
			}
			]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function miFuncionSuccess(resp){
		if(bandera=1){
			CM_saveSuccess(resp);
			get_fecha_bd();
			get_hora_bd();
			bandera=0;
		}else{
			CM_saveSuccess(resp);
		}
	}
	

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		h_txt_fecha_registro = ClaseMadre_getComponente('fecha_registro');
		h_txt_fecha_ultima_modificacion = ClaseMadre_getComponente('fecha_ultima_modificacion1');
		h_txt_hora_registro = ClaseMadre_getComponente('hora_registro');
		h_txt_hora_ultima_modificacion = ClaseMadre_getComponente('hora_ultima_modificacion1')
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_asignacion_estructura.getLayout();};
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
				layout_frppa.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)

}