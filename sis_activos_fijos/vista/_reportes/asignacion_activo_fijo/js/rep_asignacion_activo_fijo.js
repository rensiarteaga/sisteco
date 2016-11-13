/**
 * Nombre:		  	    GenerarReporteAsignacionActivoFijo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Grover Velasquez Colque
 * Fecha creación:		15/07/2010
 */
function GenerarReporteAsignacionActivoFijo(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();

	var datax;
   //proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListaEmpleado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado','id_persona','desc_nombrecompleto'])

	});
	////////////////FUNCIONES RENDER ////////////
	function render_empleado(value, p, record){return String.format('{0}', record.data['empleado']);}
	// Definición de todos los tipos de datos que se maneja    //
	
	
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria	
		
	vectorAtributos[0] = {
		validacion:{
			fieldLabel: 'Funcionario',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Funcionario...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'EMP.id_persona#EMP.codigo_empleado#PER.nombre#PER.apellido_paterno#PER.apellido_materno',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: render_empleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			width:280
		},
		id_grupo:0,
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
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
	var config={
		titulo_maestro:'Parámetros Responsable Activos Fijos'
		
	};
	layout_rep_asignacion_activo_fijo=new DocsLayoutProceso(idContenedor);
	layout_rep_asignacion_activo_fijo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_asignacion_activo_fijo,idContenedor);
	
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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{		
		var titulo = "Rep. Asignación Activos Fijos";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		//url:direccion+'../../../../control/_reportes/item/ActionPDFReporteItemsProveedor.php?'+datax,
		url:direccion+'../../../../control/_reportes/activo_fijo_asignacion/ActionPDFActivoFijoAsigancion.php',
					
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Rep. Asignación Activos Fijos',
		
		grupos:[
			{
				tituloGrupo:'Funcionario',
				columna:0,
				id_grupo:0
			}
		]}
	
	};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

	function iniciarEventosFormularios()
	{	
		lov_empleado = ClaseMadre_getComponente('des_empleado');			
	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			//alert('Entra');
			if(vectorAtributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
		
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
				componentes[i].allowBlank=vectorAtributos[i].validacion.allowBlank;
		}
	}
	
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rep_asignacion_activo_fijo.getLayout();};
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
				//this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				
				
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}