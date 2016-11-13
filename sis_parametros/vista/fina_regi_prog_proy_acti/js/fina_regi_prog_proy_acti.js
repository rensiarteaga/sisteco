/**
 * Nombre:		  	    pagina_fina_regi_prog_proy_acti_main.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2007-11-07 11:54:21
 */
function pagina_fina_regi_prog_proy_acti(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var cmbPrograma,cmbProyecto,cmbActividad;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fina_regi_prog_proy_acti/ActionListarFinaRegiProgProyActi.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fina_regi_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_fina_regi_prog_proy_acti',
			'id_prog_proy_acti',
			'desc_prog_proy_acti',
			'id_regional',
			'desc_regional',
			'desc_financiador',
			'id_financiador',
			'codigo_ep',
			'nombre_programa',
			'nombre_proyecto',
			'nombre_actividad',
			'id_programa',
			'id_proyecto',
			'id_actividad',
			'presup_relacionados'
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

	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_financiador',totalRecords:'TotalCount'},['id_financiador','nombre_financiador'])});
	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/regional/ActionListaRegionalEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','nombre_regional'])});
	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa/ActionListarPrograma.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_programa',totalRecords:'TotalCount'},['id_programa','nombre_programa','codigo_programa','descripcion_programa'])});
	ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa_proyecto_actividad/ActionListarProgramaProyectoActividad.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords:'TotalCount'},['id_prog_proy_acti','id_proyecto','nombre_proyecto','codigo_proyecto','descripcion_proyecto'])});
	ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa_proyecto_actividad/ActionListarProgramaProyectoActividad.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actividad',totalRecords:'TotalCount'},['id_prog_proy_acti','id_actividad','nombre_actividad','codigo_actividad','descripcion_actividad'])});
	
    ds_programa_proyecto_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/programa_proyecto_actividad/ActionListarProgramaProyectoActividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_prog_proy_acti',
			totalRecords: 'TotalCount'
		}, ['id_prog_proy_acti','id_programa','id_proyecto','id_actividad','desc_prog_proy_acti'])
	});

    ds_regional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/regional/ActionListarRegional.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'
		}, ['id_regional','codigo_regional','nombre_regional','descripcion_regional','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

    ds_financiador = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/financiador/ActionListarFinanciador.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_financiador',
			totalRecords: 'TotalCount'
		}, ['id_financiador','codigo_financiador','nombre_financiador','descripcion_financiador','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	
	/*ds_programa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/programa/ActionListarPrograma.php'}),
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
	});*/

	//FUNCIONES RENDER
	
	function renderFinanciador(value,p,record){return String.format('{0}',record.data['desc_financiador']);}
	function renderRegional(value,p,record){return String.format('{0}',record.data['desc_regional']);}
	function renderPrograma(value,p,record){return String.format('{0}',record.data['desc_programa']);}
	function renderProyecto(value,p,record){return String.format('{0}',record.data['desc_proyecto']);}
	function renderActividad(value,p,record){return String.format('{0}',record.data['desc_actividad']);}
	function render_id_programa(value, p, record){return String.format('{0}', record.data['nombre_programa']);}
	function render_id_proyecto(value, p, record){return String.format('{0}', record.data['nombre_proyecto']);}
	function render_id_actividad(value, p, record){return String.format('{0}', record.data['nombre_actividad']);}
			
	function render_id_prog_proy_acti(value, p, record){return String.format('{0}', record.data['desc_prog_proy_acti']);}
	function render_id_regional(value, p, record){return String.format('{0}', record.data['desc_regional']);}
	function render_id_financiador(value, p, record){return String.format('{0}', record.data['desc_financiador']);}

	var tpl_id_financiador=new Ext.Template('<div class="search-item">','<b><i>{codigo_financiador}-{nombre_financiador}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_financiador}</FONT>','</div>');
	var tpl_id_regional=new Ext.Template('<div class="search-item">','<b><i>{codigo_regional}-{nombre_regional}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_regional}</FONT>','</div>');
	var tpl_id_programa=new Ext.Template('<div class="search-item">','<b><i>{codigo_programa}-{nombre_programa}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_programa}</FONT>','</div>');
	var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<b><i>{codigo_proyecto}-{nombre_proyecto}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_proyecto}</FONT>','</div>');
	var tpl_id_actividad=new Ext.Template('<div class="search-item">','<b><i>{codigo_actividad}-{nombre_actividad}</i></b>','<br><FONT COLOR="#B5A642">{descripcion_actividad}</FONT>','</div>');
	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			name: 'id_fina_regi_prog_proy_acti',
			fieldLabel:'ID EP',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			align: 'right',
			width_grid:60
		},
		tipo: 'Field',
		form: false,
		filtro_0:false,
		save_as:'hidden_id_fina_regi_prog_proy_acti'
	};
	
	vectorAtributos[1]= {
		validacion:{
			name:'codigo_ep',
			fieldLabel:'EP',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'FINANC.codigo_financiador#REGION.codigo_regional#PROGRA.codigo_programa#PROYEC.codigo_proyecto#ACTIVI.codigo_actividad',
		id_grupo:2
	};
	 
	// txt id_financiador
	vectorAtributos[2]= {
			validacion: {
			name:'id_financiador',
			fieldLabel:'Financiador',
			allowBlank:false,			
			emptyText:'Financiador...',
			desc: 'desc_financiador', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_financiador,
			valueField: 'id_financiador',
			displayField: 'nombre_financiador',
			queryParam: 'filterValue_0',
			filterCol:'FINANC.descripcion_financiador#FINANC.codigo_financiador#FINANC.nombre_financiador',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_financiador,
			grid_visible:true,
			grid_editable:true,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_financiador
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'FINANC.nombre_financiador#FINANC.codigo_financiador',
		defecto: '',
		save_as:'txt_id_financiador'
	};
	
// txt id_regional
	vectorAtributos[3]= {
			validacion: {
			name:'id_regional',
			fieldLabel:'Regional',
			allowBlank:false,			
			emptyText:'Regional...',
			desc: 'desc_regional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'REGION.descripcion_regional#REGION.codigo_regional#REGION.nombre_regional',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_regional,
			grid_visible:true,
			grid_editable:true,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_regional
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGION.nombre_regional#REGION.codigo_regional',
		defecto: '',
		save_as:'txt_id_regional'
	};
	
	
// txt id_financiador
	vectorAtributos[4]= {
			validacion: {
			name:'id_programa',
			fieldLabel:'Programa',
			allowBlank:false,			
			emptyText:'Programa...',
			desc: 'nombre_programa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_programa,
			valueField: 'id_programa',
			displayField: 'nombre_programa',
			queryParam: 'filterValue_0',
			filterCol:'PROGRA.descripcion_programa#PROGRA.codigo_programa#PROGRA.nombre_programa',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_programa,
			grid_visible:true,
			grid_editable:true,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_programa
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'PROGRA.nombre_programa#PROGRA.codigo_programa',
		defecto: '',
		save_as:'txt_id_programa'
	};
	
	filterCols_proyecto=new Array();
	filterValues_proyecto=new Array();
	filterCols_proyecto[0]='PGPYAC.id_programa';
	filterValues_proyecto[0]='x';
	vectorAtributos[5]= {
			validacion: {
			name:'id_proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,			
			emptyText:'Subprograma/ Proyecto...',
			desc: 'nombre_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'nombre_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion_proyecto#PROYEC.codigo_proyecto#PROYEC.nombre_proyecto',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			grid_visible:true,
			grid_editable:true,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_proyecto,
			filterCols:filterCols_proyecto,
			filterValues:filterValues_proyecto
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'PROYEC.nombre_proyecto#PROYEC.codigo_proyecto',
		defecto: '',
		save_as:'txt_id_proyecto'
	};
	
	filterCols_actividad=new Array();
	filterValues_actividad=new Array();
	filterCols_actividad[0]='PGPYAC.id_programa';
	filterValues_actividad[0]='x';
	filterCols_actividad[1]='PGPYAC.id_proyecto';
	filterValues_actividad[1]='x';
	vectorAtributos[6]= {
			validacion: {
			name:'id_actividad',
			fieldLabel:'Actividad',
			allowBlank:false,			
			emptyText:'Actividad...',
			desc: 'nombre_actividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_actividad,
			valueField: 'id_actividad',
			displayField: 'nombre_actividad',
			queryParam: 'filterValue_0',
			filterCol:'ACTIVI.descripcion_actividad#ACTIVI.codigo_actividad#ACTIVI.nombre_actividad',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			minChars:0, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_actividad,
			grid_visible:true,
			grid_editable:true,
			width_grid:200, // ancho de columna en el gris
			tpl:tpl_id_actividad,
			filterCols:filterCols_actividad,
			filterValues:filterValues_actividad
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ACTIVI.nombre_actividad#ACTIVI.codigo_actividad',
		defecto: '',
		save_as:'txt_id_actividad'
	};
	
	vectorAtributos[7]= {
		validacion:{
			name:'presup_relacionados',
			fieldLabel:'Cantidad Presupuestos',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			align:'center'
		},
		form:false,
		tipo: 'Field',
		filtro_0:false,
		filtro_1:false
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
		titulo_maestro:'fina_regi_prog_proy_acti',
		grid_maestro:'grid-'+idContenedor
	};
	layout_fina_regi_prog_proy_acti=new DocsLayoutMaestroEP(idContenedor);
	layout_fina_regi_prog_proy_acti.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_fina_regi_prog_proy_acti,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var Cm_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/fina_regi_prog_proy_acti/ActionEliminarFinaRegiProgProyActi.php'},
		Save:{url:direccion+'../../../control/fina_regi_prog_proy_acti/ActionGuardarFinaRegiProgProyActi.php'},
		ConfirmSave:{url:direccion+'../../../control/fina_regi_prog_proy_acti/ActionGuardarFinaRegiProgProyActi.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
			columnas:['97%'],
			grupos:[
			{
				tituloGrupo:'Registro Estructura Programï¿½tica',
				columna:0,
				id_grupo:0}
			],width:'40%',
			height:'40%',
			minWidth:150,minHeight:200,
			closable:true,
			titulo:'Estructura Programï¿½tica'}};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		cmbPrograma=Cm_getComponente('id_programa');
		cmbProyecto=Cm_getComponente('id_proyecto');
		cmbActividad=Cm_getComponente('id_actividad');
		
		//Inicializa el baseparams
		cmbProyecto.store.baseParams={id_programa:'x'};
		cmbProyecto.store.baseParams={id_programa:'x',id_proyecto:'x'};
		
		var onProgramaSelect=function(e){
			var idProg=cmbPrograma.getValue();
			
			cmbProyecto.filterValues[0]=idProg;
			cmbProyecto.modificado=true;
			cmbProyecto.setValue('');
			
			cmbActividad.modificado=true;
			cmbActividad.setValue('');
		}
		
		var onProyectoSelect=function(e){
			var idProg=cmbPrograma.getValue();
			var idProy=cmbProyecto.getValue();
			
			cmbActividad.filterValues[0]=idProg;
			cmbActividad.filterValues[1]=idProy;
			cmbActividad.modificado=true;
			cmbActividad.setValue('');
		}
		cmbPrograma.on('select',onProgramaSelect);
		cmbPrograma.on('change',onProgramaSelect);
		cmbProyecto.on('select',onProyectoSelect);
		cmbProyecto.on('change',onProyectoSelect);
	}

	function btn_epeinv(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_epe='+SelectionsRecord.data.id_fina_regi_prog_proy_acti;
			data=data+'&codigo_epe='+SelectionsRecord.data.codigo_ep;
			data=data+'&desc_epe='+SelectionsRecord.data.desc_financiador+ ' / ' +SelectionsRecord.data.nombre_proyecto;

			var ParamVentana={Ventana:{width:600,height:400}}
			layout_fina_regi_prog_proy_acti.loadWindows(direccion+'../../../../sis_parametros/vista/epe_inv/epe_inv.php?'+data,'Inversión',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_fina_regi_prog_proy_acti.getLayout()};
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

	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Inversión Financiador/Proyecto',btn_epeinv,true,'epe_inv','Inversión');
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_fina_regi_prog_proy_acti.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}