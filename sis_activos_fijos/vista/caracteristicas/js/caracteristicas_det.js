//<script>
function pagina_caracteristicas(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){

	var Atributos=new Array;
	var ds;

	
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	// creación del Data Store

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url:direccion+ '../../../control/caracteristicas/ActionListaCaracteristicas.php'}),

		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_caracteristica',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		{name: 'descripcion', type: 'string'},
		'id_caracteristica',
		'descripcion', 
		'id_subtipo_activo',
		'desc_subtipo_activo'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	
	
	// DEFINICIÓN DATOS DEL MAESTRO

	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
			var data_maestro=[ ['Cod. Subtipo Activo ',maestro.codigo+ "                          "],['',''],['Subtipo Activo',maestro.descripcion]]; 
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_caracteristica',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
			
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_caracteristica'
	};
	

	/////////// txt descripcion//////
	Atributos[1]={
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Descripción',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			width: 350,
			//vtype:"alphaLatino",
			vtype:"texto",		
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:500 // ancho de columna en el gris
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filtro_1:true,
		filterColValue:'car.descripcion',
		save_as:'txt_descripcion'
	};
	
	
	/////////// txt id_tipo_activo//////
	Atributos[2]={
		validacion:{
			name: 'id_subtipo_activo',
			fieldLabel: '',
			inputType:'hidden',
			labelSeparator:'',
			vtype:"hidden",
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		save_as:'hidden_id_subtipo_activo',
		defecto: maestro.id_subtipo_activo
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


	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Subtipo de Activo Fijo (Maestro)",
		titulo_detalle:"Caracteristicas por Subtipo (Detalle)",
		grid_maestro:'grid-'+idContenedor
	};
	var layout_caracteristicas= new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_caracteristicas.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caracteristicas,idContenedor);
var EstehtmlMaestro=this.htmlMaestro;
var CM_btnNew=this.btnNew;
var dialog= this.getFormulario;
var getSelectionModel=this.getSelectionModel;
var getGrid=this.getGrid;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
			},

		actualizar:{
			crear :true,
			separador:false
		}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////


	//datos necesarios para ell filtro
	//parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			
			url:direccion+"../../../control/caracteristicas/ActionEliminaCaracteristicas.php"
		},
		Save:{
			url:direccion+"../../../control/caracteristicas/ActionSaveCaracteristicas.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/caracteristicas/ActionSaveCaracteristicas.php"
		},
		Formulario:{titulo:'Formulario de Caracteristicas',
			html_apply:"dlgInfo",
			width:520,
			height:190,
			minWidth:150,
			minHeight:200,
			closable:true,
			columnas:[480],
			grupos:[
			{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	}
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
//
//var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
//		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_sub_tipo_activo',totalRecords: 'TotalCount'},['id_sub_tipo_activo',
//		'codigo',
//		'descripcion',
//		'vida_util',
//		'tasa_depreciacion',
//		'ini_correlativo',
//		'correlativo_act',
//		'fecha_reg',
//		'estado',
//		'id_tipo_activo','desc_tipo_activo', 'id_auxiliar_tmp','desc_auxiliar'
//		])
//	});
//
//		ds_maestro.load({
//			params:{
//				start:0,
//				limit: paramConfig.TamanoPagina,
//				CantFiltros:paramConfig.CantFiltros,
//				m_id_subtipo_activo:maestro.id_subtipo_activo
//
//			},
//			callback:cargar_maestro
//		});
//
//		function cargar_maestro(){
//		
//			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Cod. Subtipo Activo',ds_maestro.getAt(0).get('codigo')],['Sub Tipo Activo',ds_maestro.getAt(0).get('descripcion')],['Vida util',ds_maestro.getAt(0).get('vida_util')]]));
//		}
		
	
	
		this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_subtipo_activo=datos.m_id_subtipo_activo;
		maestro.codigo=datos.m_codigo;
		maestro.descripcion=datos.m_descripcion;
		maestro.vida_util=datos.m_vida_util;
		maestro.id_tipo_activo=datos.m_id_tipo_activo;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_subtipo_activo:maestro.id_subtipo_activo
				
			}
		};
		this.btnActualizar();
		data_maestro=[ ['Cod. Subtipo Activo ',maestro.codigo+ "                          "],['',''],['Subtipo Activo',maestro.descripcion]]; 
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[2].defecto=maestro.id_subtipo_activo;
		paramFunciones.btnEliminar.parametros='&hidden_id_subtipo_activo='+maestro.id_subtipo_activo;
		paramFunciones.Save.parametros='&hidden_id_subtipo_activo='+maestro.id_subtipo_activo;
		paramFunciones.ConfirmSave.parametros='&hidden_id_subtipo_activo='+maestro.id_subtipo_activo;
		
		this.InitFunciones(paramFunciones)
	};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.getLayout=function(){return layout_caracteristicas.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//innerLayout.addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

	this.iniciaFormulario();

		//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_sub_tipo_activo: maestro.id_subtipo_activo
			}
	});
	
layout_caracteristicas.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
			
	
}

