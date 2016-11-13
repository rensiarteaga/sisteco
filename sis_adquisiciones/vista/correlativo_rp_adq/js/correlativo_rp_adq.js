/**
 * Nombre:		  	    pagina_correlativo_rp_adq.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-08 09:53:38
 */
function pagina_correlativo_rp_adq(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/correlativo_rp/ActionListarCorrelativoRp.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_correlativo_rp',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_correlativo_rp',
		'nro_doc_siguiente',
		'nro_doc_actual',
		'id_documento',
		'desc_documento',
		'id_empresa',
		'desc_empresa',
		'id_periodo',
		'desc_periodo',
		'id_proyecto',
		'desc_proyecto',
		'id_regional',
		'desc_regional'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion_subsistema:maestro.id_gestion_subsistema,
			m_nombre_corto:maestro.nombre_corto
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	/*var data_maestro=[['ID Documento',maestro.id_documento],['Descripción',maestro.descripcion],['Documento',maestro.documento]];*/
	
	//DATA STORE COMBOS

    var ds_documento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_documento',totalRecords: 'TotalCount'},['id_documento','codigo','descripcion','documento','prefijo','sufijo','estado','id_subsistema'])
	});

    var ds_empresa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/empresa/ActionListarEmpresa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empresa',totalRecords: 'TotalCount'},['id_empresa','razon_social','denominacion','nro_nit','codigo'])
	});

    var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo/ActionListarPeriodo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','id_gestion','periodo','fecha_inicio','fecha_final','estado_peri_gral'])
	});

    var ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proyecto/ActionListarProyecto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords: 'TotalCount'},['id_proyecto','codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

    var ds_regional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/regional/ActionListarRegional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords: 'TotalCount'},['id_regional','codigo_regional','nombre_regional','descripcion_regional','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
		function render_id_documento(value, p, record){return String.format('{0}', record.data['desc_documento']);}
		var tpl_id_documento=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{descripcion}</FONT><br>','<FONT COLOR="#B5A642">{documento}</FONT>','</div>');

		function render_id_empresa(value, p, record){return String.format('{0}', record.data['desc_empresa']);}
		var tpl_id_empresa=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}
		var tpl_id_periodo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_proyecto(value, p, record){return String.format('{0}', record.data['desc_proyecto']);}
		var tpl_id_proyecto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{descripcion_proyecto}</FONT><br>','<FONT COLOR="#B5A642">{codigo_proyecto}</FONT>','</div>');

		function render_id_regional(value, p, record){return String.format('{0}', record.data['desc_regional']);}
		var tpl_id_regional=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_regional}</FONT><br>','<FONT COLOR="#B5A642">{nombre_regional}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_correlativo_rp
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_correlativo_rp',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_correlativo_rp'
	};
// txt nro_doc_siguiente
	Atributos[1]={
		validacion:{
			name:'nro_doc_siguiente',
			fieldLabel:'Nro. Siguiente',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disable:false,
			grid_indice:2,
			align:'right'		
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'CORLRP.nro_doc_siguiente',
		save_as:'nro_doc_siguiente'
	};
// txt nro_doc_actual
	Atributos[2]={
		validacion:{
			name:'nro_doc_actual',
			fieldLabel:'Nro Actual',
			allowBlank:false,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disable:false,
			grid_indice:3,
			align:'right'				
		},
		tipo:'Field',
		filtro_0:true,
		form:true,		
		filterColValue:'CORLRP.nro_doc_actual',
		save_as:'nro_doc_actual'
	};
// txt id_documento
	Atributos[3]={
		validacion:{
			name:'desc_documento',
			fieldLabel:'Documento',
			desc: 'desc_documento',
		    displayField: '',
		    vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			disabled:false,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'DOCUME.descripcion',
		//defecto:maestro.id_documento,
		save_as:'id_documento'
	};
// txt id_empresa
	Atributos[4]={
			validacion:{
			name:'id_empresa',
			fieldLabel:'ID de la Empresa',
			allowBlank:false,			
			emptyText:'ID de la Empresa...',
			desc: 'desc_empresa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empresa,
			valueField: 'id_empresa',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'.',
			typeAhead:true,
			tpl:tpl_id_empresa,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empresa,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'.',
		save_as:'id_empresa'
	};
// txt id_periodo
	Atributos[5]={
			validacion:{
			name:'id_periodo',
			fieldLabel:'Periodo',
			allowBlank:false,			
			emptyText:'ID del Periodo...',
			desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_periodo,
			valueField: 'id_periodo',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'.',
			typeAhead:true,
			tpl:tpl_id_periodo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:150,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_periodo,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:'100%',
			disabled:false,
			grid_indice:4,
			align:'right'				
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERIOD.periodo',
		save_as:'id_periodo'
	};
// txt id_proyecto
	Atributos[6]={
			validacion:{
			name:'id_proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,			
			emptyText:'ID del Proyecto...',
			desc: 'desc_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField: 'id_proyecto',
			displayField: 'descripcion_proyecto',
			queryParam: 'filterValue_0',
			filterCol:'PROYEC.descripcion_proyecto#PROYEC.codigo_proyecto',
			typeAhead:true,
			tpl:tpl_id_proyecto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:150,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_proyecto,
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PROYEC.descripcion_proyecto',
		save_as:'id_proyecto'
	};
// txt id_regional
	Atributos[7]={
			validacion:{
			name:'id_regional',
			fieldLabel:'Regional',
			allowBlank:false,			
			emptyText:'ID de la Regional...',
			desc: 'desc_regional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_regional,
			valueField: 'id_regional',
			displayField: 'nombre_regional',
			queryParam: 'filterValue_0',
			filterCol:'REGION.codigo_regional#REGION.nombre_regional',
			typeAhead:true,
			tpl:tpl_id_regional,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_regional,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'REGION.codigo_regional',
		save_as:'id_regional'
	};

	/*Atributos[8]={
		validacion:{
			name:'id_gestion_subsistema',
			fieldLabel:'Gestion Subsistema',
			desc: 'id_gestion_subsistema',
		    displayField: '',
		    vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:300,
			disabled:false,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false,
		//filterColValue:'DOCUME.descripcion',
		//defecto:maestro.id_documento,
		save_as:'id_gestion_subsistema'
	};*/
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Documento (Maestro)',titulo_detalle:'correlativo_rp (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_correlativo_rp = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_correlativo_rp.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_correlativo_rp,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/correlativo_rp/ActionEliminarCorrelativoRp.php',parametros:'&m_id_documento='+maestro.id_documento},
	Save:{url:direccion+'../../../control/correlativo_rp/ActionGuardarCorrelativoRp.php',parametros:'&m_id_documento='+maestro.id_documento},
	ConfirmSave:{url:direccion+'../../../control/correlativo_rp/ActionGuardarCorrelativoRp.php',parametros:'&m_id_documento='+maestro.id_documento},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'correlativo_rp'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	maestro.id_gestion_subsistema=datos.m_id_gestion_subsistema;	
	maestro.id_documento=datos.m_id_documento;
    maestro.descripcion=datos.m_descripcion;
   maestro.documento=datos.m_documento;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion_subsistema:maestro.id_gestion_subsistema,
				m_nombre_corto:maestro.nombre_corto
			}
		};
		this.btnActualizar();
		data_maestro=[['ID Gestion Subsistema',maestro.id_gestion_subsistema]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		//Atributos[8].defecto=maestro.id_gestion_subsistema;

		/*paramFunciones.btnEliminar.parametros='&m_id_documento='+maestro.id_documento;
		paramFunciones.Save.parametros='&m_id_documento='+maestro.id_documento;
		paramFunciones.ConfirmSave.parametros='&m_id_documento='+maestro.id_documento;
*/		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_correlativo_rp.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
//	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_correlativo_rp.getLayout().addListener('layout',this.onResize);
	layout_correlativo_rp.getVentana(idContenedor).on('resize',function(){layout_correlativo_rp.getLayout().layout()})
	
}