/**
 * Nombre:		  	    pagina_programa_proyecto_actividad_main.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-11-06 16:42:14
 */
function pagina_programa_proyecto_actividad(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/programa_proyecto_actividad/ActionListarProgramaProyectoActividad.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_prog_proy_acti',
			'id_programa',
			'desc_programa',
			'id_proyecto',
			'desc_proyecto',
			'desc_actividad',
			'id_actividad',
			'desc_prog_proy_acti',
			'nombre_programa',
			'nombre_proyecto',
			'nombre_actividad',
			'cod_prog_proy_acti'
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

    ds_programa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/programa/ActionListarPrograma.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_programa',
			totalRecords: 'TotalCount'
		}, ['id_programa','codigo_programa','nombre_programa','descripcion_programa','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

    ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proyecto/ActionListarProyecto.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

    ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/actividad/ActionListarActividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'
		}, ['id_actividad','codigo_actividad','nombre_actividad','descripcion_actividad','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_programa(value, p, record){return String.format('{0}', record.data['nombre_programa']);}
			function render_id_proyecto(value, p, record){return String.format('{0}', record.data['nombre_proyecto']);}
			function render_id_actividad(value, p, record){return String.format('{0}', record.data['nombre_actividad']);}
			
			
			var tpl_id_programa=new Ext.Template('<div class="search-item">','<b><i>{codigo_programa}-{nombre_programa}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_programa}</FONT>','</div>');
			var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo_proyecto}-{nombre_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_proyecto}</FONT>','</div>');
			var tpl_id_actividad=new Ext.Template('<div class="search-item">','<b><i>{codigo_actividad}-{nombre_actividad}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_actividad}</FONT>','</div>');
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_prog_proy_acti',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_prog_proy_acti',
		id_grupo:0
	};
	
	vectorAtributos[1]= {
		validacion:{
			name:'cod_prog_proy_acti',
			fieldLabel:'Codigo',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'PROGRA.codigo_programa#PROYEC.codigo_proyecto#ACTIVI.codigo_actividad',
		id_grupo:2
	};
	 
// txt id_programa
	vectorAtributos[2]= {
			validacion: {
			name:'id_programa',
			fieldLabel:'Programa',
			allowBlank:false,			
			emptyText:'Programa...',
			desc: 'desc_programa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'PROGRA.descripcion_programa#PROGRA.codigo_programa#PROGRA.nombre_programa',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_programa,
			tpl:tpl_id_programa,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROGRA.nombre_programa#PROGRA.codigo_programa',
		defecto: '',
		save_as:'txt_id_programa',
		id_grupo:1
	};

	// txt id_proyecto
	vectorAtributos[3]= {
			validacion: {
			name:'id_proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,			
			emptyText:'Proyecto...',
			desc: 'desc_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'descripcion_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion_proyecto#PROYEC.codigo_proyecto#PROYEC.nombre_proyecto',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			tpl:tpl_id_proyecto,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROYEC.nombre_proyecto#PROYEC.codigo_proyecto',
		defecto: '',
		save_as:'txt_id_proyecto',
		id_grupo:1
	};
	
// txt id_actividad
	vectorAtributos[4] = {
			validacion: {
			name:'id_actividad',
			fieldLabel:'Actividad',
			allowBlank:false,			
			emptyText:'Actividad...',
			desc: 'desc_actividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_actividad,
			valueField: 'id_actividad',
			displayField: 'descripcion_actividad',
			queryParam: 'filterValue_0',
			filterCol:'ACTIVI.descripcion_actividad#ACTIVI.codigo_actividad#ACTIVI.nombre_actividad',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_actividad,
			renderer:render_id_actividad,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ACTIVI.nombre_actividad#ACTIVI.codigo_actividad',
		defecto: '',
		save_as:'txt_id_actividad',
		id_grupo:1
	};
	
	
	
	// desc_prog_proy_acti
	vectorAtributos[5]= {
		validacion:{
			name:'desc_prog_proy_acti',
			fieldLabel:'Prog/Proy/Act',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:300,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'PROGRA.nombre_programa#PROYEC.nombre_proyecto#ACTIVI.nombre_actividad',
		save_as:'txt_nombre_actividad',
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
		titulo_maestro:'Programa/Proyecto/Actividad',
		grid_maestro:'grid-'+idContenedor
	};
	layout_programa_proyecto_actividad=new DocsLayoutMaestro(idContenedor);
	layout_programa_proyecto_actividad.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_programa_proyecto_actividad,idContenedor);
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
	// DEFINICI�N DE LA BARRA DE MEN�//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/programa_proyecto_actividad/ActionEliminarProgramaProyectoActividad.php'},
		Save:{url:direccion+'../../../control/programa_proyecto_actividad/ActionGuardarProgramaProyectoActividad.php'},
		ConfirmSave:{url:direccion+'../../../control/programa_proyecto_actividad/ActionGuardarProgramaProyectoActividad.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'45%',
		width:'45%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'Programa/Proyecto/Actividad',
		grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0},
				{
				tituloGrupo:'Programa/Proyecto/Actividad',
				columna:0,
				id_grupo:1},
				{
				tituloGrupo:'Detalle Prog/Proy/Act',
				columna:0,
				id_grupo:2}
				]}};
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS ---//
	this.btnNew = function(){	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Programa/Proyecto/Actividad');
		CM_ocultarGrupo('Detalle Prog/Proy/Act');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		dialog.resizeTo('45%','45%');
		var SelectionsRecord  = sm.getSelected();
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Programa/Proyecto/Actividad');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function(){ 	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Programa/Proyecto/Actividad');
		CM_ocultarGrupo('Detalle Prog/Proy/Act');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		var SelectionsRecord  = sm.getSelected();
		CM_mostrarGrupo('Datos de Actividad');
		CM_mostrarGrupo('Programa/Proyecto/Actividad');
		ClaseMadre_btnEdit()
	};
	
	function InitPaginaProgramaProyectoActividad()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		var sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_programa_proyecto_actividad.getLayout()};
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

				//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				InitPaginaProgramaProyectoActividad();
				layout_programa_proyecto_actividad.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}