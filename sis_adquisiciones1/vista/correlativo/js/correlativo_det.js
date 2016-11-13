/**
 * Nombre:		  	    pagina_correlativo_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 11:30:56
 */
function pagina_correlativo_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/correlativo/ActionListarCorrelativo_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_correlativo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_correlativo',
		'valor_actual',
		'valor_siguiente',
		'incremento',
		'id_parametro_adquisicion',
		'desc_parametro_adquisicion',
		'id_documento',
		'desc_documento',
		'prefijo',
		'sufijo',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_parametro_adquisicion:maestro.id_parametro_adquisicion
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['ID Parametro Adquisición',maestro.id_parametro_adquisicion],['Fecha',maestro.fecha],['Gestion',maestro.gestion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    var ds_documento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumento.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_documento',totalRecords:'TotalCount'},['id_documento','codigo','descripcion'])
	});

	//FUNCIONES RENDER
	
	function render_id_documento(value, p, record){return String.format('{0}', record.data['desc_documento']);}
	var tpl_id_documento=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
;
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_correlativo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_correlativo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_correlativo'
	};
	// txt id_fina_regi_prog_proy_acti
	Atributos[1]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};
		// txt id_documento
	Atributos[2]={
			validacion:{
			name:'id_documento',
			fieldLabel:'ID Documento',
			allowBlank:true,			
			emptyText:'ID Documento...',
			desc: 'desc_documento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_documento,
			valueField: 'id_documento',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'DOCUME.codigo#DOCUME.descripcion',
			typeAhead:true,
			tpl:tpl_id_documento,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_documento,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			disable:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo',
		save_as:'txt_id_documento'
	};
// txt prefijo
	Atributos[3]={
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:true,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:50,
			width:'20%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CORADQ.prefijo',
		save_as:'txt_prefijo'
	};
// txt sufijo
	Atributos[4]={
		validacion:{
			name:'sufijo',
			fieldLabel:'Sufijo',
			allowBlank:true,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:50,
			width:'20%',
			disable:false,
			grid_indice:4
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CORADQ.sufijo',
		save_as:'txt_sufijo'
	};
// txt incremento
	Atributos[5]={
		validacion:{
			name:'incremento',
			fieldLabel:'Incremento',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:80,
			width:'20%',
			disable:false,
			grid_indice:5
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CORADQ.incremento',
		save_as:'txt_incremento'
	};
// txt valor_actual
	Atributos[6]={
		validacion:{
			name:'valor_actual',
			fieldLabel:'Valor Actual',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'20%',
			disable:false,
			grid_indice:6
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CORADQ.valor_actual',
		save_as:'txt_valor_actual'
	};
// txt valor_siguiente
	Atributos[7]={
		validacion:{
			name:'valor_siguiente',
			fieldLabel:'Valor Siguiente',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'20%',
			disable:false,
			grid_indice:7
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CORADQ.valor_siguiente',
		save_as:'txt_valor_siguiente'
	};

// txt id_parametro_adquisicion
	Atributos[8]={
		validacion:{
			name:'id_parametro_adquisicion',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_parametro_adquisicion,
		save_as:'txt_id_parametro_adquisicion'
	};


	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetros de Adquisiciones (Maestro)',titulo_detalle:'Secuenciales Adquisición (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_correlativo = new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_correlativo.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_correlativo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/correlativo/ActionEliminarCorrelativo.php',parametros:'&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion},
	Save:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion},
	ConfirmSave:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'correlativo'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_parametro_adquisicion=datos.m_id_parametro_adquisicion;
maestro.fecha=datos.m_fecha

		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_parametro_adquisicion:maestro.id_parametro_adquisicion
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['ID Parametro Adquisición',maestro.id_parametro_adquisicion],['Fecha',maestro.fecha],['Gestion',maestro.gestion]]);
		
		paramFunciones.btnEliminar.parametros='&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion;
		paramFunciones.Save.parametros='&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion;
		paramFunciones.ConfirmSave.parametros='&m_id_parametro_adquisicion='+maestro.id_parametro_adquisicion;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_correlativo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_correlativo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}