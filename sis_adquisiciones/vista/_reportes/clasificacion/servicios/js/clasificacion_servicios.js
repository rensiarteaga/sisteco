/**
 * Nombre:		  	    pagina_clasificacion_servicios.js
 * Propósito: 			pagina objeto principal
 * Autor:				JoSé Mita
 * Fecha creación:		20-05-2008 
 */
function pagina_clasificacion_servicios(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var combo_tipo_adq;
	var datax;
	 ds_tipo_adq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/tipo_adq/ActionListarTipoAdq.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_adq',
			totalRecords: 'TotalCount'
		}, ['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion'])
	});
	function renderSupergrupo(value, p, record){return String.format('{0}', record.data['nombre']);}
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	var param_id_tipo_adq={
		validacion:{
			fieldLabel:'Tipo de Adquisición',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Adquisición...',
			name:'id_tipo_adq',
			desc:'nombre',
			store:ds_tipo_adq,
			valueField:'id_tipo_adq',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:renderSupergrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		save_as:'txt_id_tipo_adq',
		tipo:'ComboBox',
		id_grupo:0
	};
	vectorAtributos[0] = param_id_tipo_adq;
	filterCols_grupo=new Array();
	filterValues_grupo=new Array();
	filterCols_grupo[0]='TIPADQ.id_tipo_adq';
	filterValues_grupo[0]='%';
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
	var config={
		titulo_maestro:'Clasificación de Servicios'
	};
	layout_clasificacion_servicios=new DocsLayoutProceso(idContenedor);
	layout_clasificacion_servicios.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_clasificacion_servicios,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
    var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_submit = this.submit;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	function obtenerTitulo()
	{
		var titulo = "Clasificación de Servicios";
		return titulo;
	}
	//datos necesarios para el filtro
	var paramFunciones = {
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../../control/_reportes/clasificacion_servicios/ActionClasificacionServicios.php?'+datax,
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:true,
		width:'60%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Clasificacion de Servicios',
		grupos:[{
			tituloGrupo:'Clasificación de Servicios',
			columna: 0,
			id_grupo:0
		}
		]}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de evento
		function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		combo_tipo_adq= ClaseMadre_getComponente('id_tipo_adq');
		};
		function clasificacion(){
		    datax = "txt_id_tipo_adq=" + combo_tipo_adq.getValue();	
		 }
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_clasificacion_servicios.getLayout();};
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
				this.InitFunciones(paramFunciones);
				//para agregar botones
				this.iniciaFormulario();
				iniciarEventosFormularios();
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}