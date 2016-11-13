/**
 * Nombre:		  	    pagina_categoria_prog_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 16:42:14
 */
function pagina_categoria_prog(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_prog/ActionListarCategoriaProg.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_categoria_prog',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_categoria_prog',
			'id_programa',
			'desc_programa',
			'id_proyecto',
			'desc_proyecto',			
			'id_actividad',
			'desc_actividad',
			'id_organismo_fin',
			'desc_organismo_fin',
			'id_fuente_financiamiento',
			'desc_fuente_financiamiento',
			'login',
			'fecha_reg',
			'id_parametro',
			'desc_parametro',
			'cod_categoria_prog', 
			'descripcion_cp',
			'estado',
			'usuario_mod',
			'fecha_mod',
			'codigo_sisin',
			'cant_presupuestos'
			
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
		}, ['id_programa','codigo','descripcion' ])
	});

    ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proyecto/ActionListarProyecto.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proyecto',
			totalRecords: 'TotalCount'
		}, ['id_proyecto','codigo','descripcion' ])
	});

    ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/actividad/ActionListarActividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_actividad',
			totalRecords: 'TotalCount'
		}, ['id_actividad','codigo','descripcion' ])
	});
	
	ds_organismo_fin = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/organismo_fin/ActionListarOrganismoFin.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_organismo_fin',
			totalRecords: 'TotalCount'
		}, ['id_organismo_fin','codigo','descripcion' ])
	});
	
	ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fuente_financiamiento',
			totalRecords: 'TotalCount'
		}, ['id_fuente_financiamiento','codigo_fuente','denominacion' ])
	});

	ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_parametro',
			totalRecords: 'TotalCount'
		}, ['id_parametro','gestion_pres' ])
	});
	
	//FUNCIONES RENDER
	
			function render_id_programa(value, p, record){return String.format('{0}', record.data['desc_programa']);}
			function render_id_proyecto(value, p, record){return String.format('{0}', record.data['desc_proyecto']);}
			function render_id_actividad(value, p, record){return String.format('{0}', record.data['desc_actividad']);}
			function render_id_organismo_fin(value, p, record){return String.format('{0}', record.data['desc_organismo_fin']);}
			function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['desc_fuente_financiamiento']);}
			function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
			
			
			var tpl_id_programa=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_actividad=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_organismo_fin=new Ext.Template('<div class="search-item">','<b><i>{codigo} - {descripcion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<b><i>{codigo_fuente} - {denominacion}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_categoria_prog',
			fieldLabel:'Identificador',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_categoria_prog',
		id_grupo:0
	};
	
	// txt id_parametro
	vectorAtributos[1] = {
			validacion: {
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Actividad...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres',
			typeAhead:false,
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
			tpl:tpl_id_parametro,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:true,
			width_grid:70 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PARAME.gestion_pres',
		defecto: '',
		save_as:'txt_id_parametro',
		id_grupo:1
	};
	
	vectorAtributos[2]= {
		validacion:{			
			name: 'cod_categoria_prog',
			fieldLabel:'Categoria Programatica',			
			grid_visible:true, 
			grid_editable:false,
			width:200,
			width_grid:200,
			disabled:true
		},
		tipo: 'TextField',
		filtro_0:false,
		id_grupo:1
	};
	
	vectorAtributos[3]= {
		validacion:{
			labelSeparator:'',
			name: 'cant_presupuestos',
			fieldLabel:'Cant. Presupuestos',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	vectorAtributos[4]= {
		validacion:{			
			name: 'codigo_sisin',
			fieldLabel:'Código SISIN',			
			grid_visible:true, 
			grid_editable:false,
			width:100,
			width_grid:110,
			disabled:true
		},
		tipo: 'TextField',
		filtro_0:false,
		id_grupo:0
	};
	 
// txt id_programa
	vectorAtributos[5]= {
			validacion: {
			name:'id_programa',
			fieldLabel:'Cod. Programa',
			allowBlank:false,			
			//emptyText:'Programa...',
			desc: 'desc_programa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROGRA.descripcion#PROGRA.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
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
		filterColValue:'PROGRA.descripcion#PROGRA.codigo',
		defecto: '',
		save_as:'txt_id_programa',
		id_grupo:1
	};

	// txt id_proyecto
	vectorAtributos[6]= {
			validacion: {
			name:'id_proyecto',
			fieldLabel:'Cod. Proyecto',
			allowBlank:false,			
			//emptyText:'Proyecto...',
			desc: 'desc_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion#PROYEC.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
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
		filterColValue:'PROYEC.descripcion#PROYEC.codigo',
		defecto: '',
		save_as:'txt_id_proyecto',
		id_grupo:1
	};
	
// txt id_actividad
	vectorAtributos[7] = {
			validacion: {
			name:'id_actividad',
			fieldLabel:'Cod. Actividad',
			allowBlank:false,			
			//emptyText:'Actividad...',
			desc: 'desc_actividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_actividad,
			valueField: 'id_actividad',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ACTIVI.descripcion#ACTIVI.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
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
		filterColValue:'ACTIVI.descripcion#ACTIVI.codigo',
		defecto: '',
		save_as:'txt_id_actividad',
		id_grupo:1
	};
	
		// txt id_actividad
	vectorAtributos[8] = {
			validacion: {
			name:'id_fuente_financiamiento',
			fieldLabel:'Cod. Fuente de Financiamiento',
			allowBlank:false,			
			//emptyText:'Fuente...',
			desc: 'desc_fuente_financiamiento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'codigo_fuente',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.descripcion#FUNFIN.codigo_fuente',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_fuente_financiamiento,
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'FUEFIN.denominacion#FUEFIN.codigo_fuente',
		defecto: '',
		save_as:'txt_id_fuente_financiamiento',
		id_grupo:1
	};
	
	// txt id_actividad
	vectorAtributos[9] = {
			validacion: {
			name:'id_organismo_fin',
			fieldLabel:'Cod. Organismo Financiador',
			allowBlank:false,			
			//emptyText:'Organismo...',
			desc: 'desc_organismo_fin', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_organismo_fin,
			valueField: 'id_organismo_fin',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ORGFIN.descripcion#ORGFIN.codigo',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:400,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_id_organismo_fin,
			renderer:render_id_organismo_fin,
			grid_visible:true,
			grid_editable:true,
			width_grid:250 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ORGFIN.descripcion#ORGFIN.codigo',
		defecto: '',
		save_as:'txt_id_organismo_fin',
		id_grupo:1
	};
	
	// txt descripcion
	vectorAtributos[10]={
		validacion:{
			name:'descripcion_cp',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CATPRO.descripcion',
		save_as:'txt_descripcion',
		id_grupo:1
	};	
	
	vectorAtributos[11]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado Registro',
			vtype:'texto',
			//emptyText:'Elija el Tipo...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATPRO.estado',
		save_as: 'txt_estado',
		id_grupo:1
	};
	
	vectorAtributos[12]={
		validacion:{
			name:'login',
			fieldLabel:'Usuario Registro',
			allowBlank:false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'USUARI.login'
	};	

	vectorAtributos[13]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'CATPRO.fecha_reg'
	};	
	
	vectorAtributos[14]={
		validacion:{
			name:'usuario_mod',
			fieldLabel:'Usuario Modificación',
			allowBlank:false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'USUARI2.login'
	};	

	vectorAtributos[15]={
		validacion:{
			name:'fecha_mod',
			fieldLabel:'Fecha Modificación',
			allowBlank:false,
			maxLength:3,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'CATPRO.fecha_mod'
		
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
		titulo_maestro:'Categoría Programática',
		grid_maestro:'grid-'+idContenedor
	};
	layout_categoria_prog=new DocsLayoutMaestro(idContenedor);
	layout_categoria_prog.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_categoria_prog,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/categoria_prog/ActionEliminarCategoriaProg.php'},
		Save:{url:direccion+'../../../control/categoria_prog/ActionGuardarCategoriaProg.php'},
		ConfirmSave:{url:direccion+'../../../control/categoria_prog/ActionGuardarCategoriaProg.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'65%',
		width:'45%',columnas:['95%'],
			minWidth:150,minHeight:200,	closable:true,titulo:'Categoria Programatica',
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
				
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS ---//
	this.btnNew = function()
	{	
		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Programa/Proyecto/Actividad');
		CM_ocultarGrupo('Detalle Prog/Proy/Act');
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		var sw=false;
		//dialog.resizeTo('45%','45%');
		var SelectionsRecord  = sm.getSelected();
		CM_ocultarGrupo('Invisible');
		CM_mostrarGrupo('Programa/Proyecto/Actividad');
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function()
	{ 	
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
	
	function InitPaginaCategoriaProg()
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
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_categoria_prog.getLayout()};
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
	InitPaginaCategoriaProg();
	
	//Adicionamos el combo de gestion	
	var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
			
	var gestion =new Ext.form.ComboBox(
	{
		store:ds_cmb_gestion,
		displayField:'gestion_pres',
		typeAhead:true,
		mode:'remote',
		triggerAction:'all',
		emptyText:'Gestión...',
		selectOnFocus:true,
		width:100,
		valueField:'id_gestion',
		tpl:tpl_gestion_cmb
	});
	
  	gestion.on('select',function (combo, record, index)
  	{
  		g_id_gestion=gestion.getValue();
	  	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});	
    });
    this.AdicionarBotonCombo(gestion,'gestion');
    //Fin adicion del combo de gestion
	
	layout_categoria_prog.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}