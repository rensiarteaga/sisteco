/**
 * Nombre:		  	    pagina_tramo_unidad_constructiva.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				UNKNOW
 * Fecha creacion:		15-12-2014
 */
function pagina_tramo_unidad_constructiva(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var combo_uc;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tramo_unidad_constructiva/ActionListarTramoUnidadConstructiva.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tramo_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_tramo_unidad_constructiva',
		'fecha_reg',
		'estado','usuario_reg',
		'id_unidad_constructiva','desc_uc','id_tramo',
		'desc_tramo',
		'codigo'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tramo:maestro.id_tramo
		}
	});
	// DEFINICION DATOS DEL MAESTRO


	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id.Tramo',maestro.id_tramo],['Codigo',maestro.codigo],['Descripcion',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

	var filtro ='filtro_tramo=si'+' &id_tramo='+maestro.id_tramo;
	
    var ds_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php?'+filtro}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_unidad_constructiva','desc_unidad_constructiva','codigo','nombre','descripcion'])
	});

	//FUNCIONES RENDER
	
	function render_id_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_uc']);};
	var tpl_unidad_constructiva=new Ext.Template('<div class="search-item">','<strong>{nombre} - {codigo}</strong></br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_tramo_unidad_constructiva
	//en la posicion 0 siempre esta la llave primaria
	
	vectorAtributos = 
		[
		 	{
		 		validacion:
		 		{
					labelSeparator:'',
					name: 'id_tramo_unidad_constructiva',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'hidden_id_tramo_unidad_constructiva'
		 	},
		 	{
		 		validacion: 
		 		{
					name:'id_unidad_constructiva',
					fieldLabel:'Unidad Constructiva',
					allowBlank:false,			
					emptyText:'Unidad Constructiva...',
					desc: 'desc_uc', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_unidad_constructiva,
					valueField: 'id_unidad_constructiva',
					displayField: 'desc_unidad_constructiva',
					queryParam: 'filterValue_0',
					filterCol:'UNICON.codigo#UNICON.direccion',
					typeAhead:true,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:100,
					minListWidth:450,
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_unidad_constructiva,
					grid_visible:true,
					grid_editable:true,
					tpl: tpl_unidad_constructiva,
					width : 220,
					width_grid:100 // ancho de columna en el gris
				},
				tipo:'ComboBox',
				filtro_0:true,
				filtro_1:true,
				filterColValue:'UNICON.codigo',
				defecto: '',
				save_as:'txt_id_unidad_constructiva'
		 	},
		 	{
		 		validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 55,
					width : 120
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tram.estado',
				defecto:'activo',
				form : true,
				save_as : 'txt_estado'
		 	},
//		 	{
//				validacion:{
//					labelSeparator:'',
//					name: 'id_tramo'
//					grid_visible:false, // se muestra en el grid
//					grid_editable:false,
//					},
//				tipo: 'Field',
//				form:false
//			},
		 	{
				validacion : {
					name :'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'tram.usuario_reg',
				form : false
			},
			{
				validacion : {
					name :'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					//renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : false,
				filterColValue : 'tram.fecha_reg',
				dateFormat : 'm-d-Y'
		  }
		];

	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Tramos (Maestro)',
		titulo_detalle:'Relacion Tramos Unidades Constructivas (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_tramo_unidad_constructiva = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tramo_unidad_constructiva.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_tramo_unidad_constructiva,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICI�N DE LA BARRA DE MEN�
	
	this.btnNew =function()
	{
		ClaseMadre_btnNew();
	}
	
	
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionEliminarTramoUnidadConstructiva.php',parametros:'&m_id_tramo='+maestro.id_tramo},
	Save:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionGuardarTramoUnidadConstructiva.php',parametros:'&m_id_tramo='+maestro.id_tramo},
	ConfirmSave:{url:direccion+'../../../control/tramo_unidad_constructiva/ActionGuardarTramoUnidadConstructiva.php'},
	Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:340,width:480,
					minWidth:150,minHeight:200,closable:true,titulo: 'Tramo Unidad Constructiva'
				}
	}

	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tramo=datos.m_id_tramo;
		maestro.codigo=datos.m_codigo;
		maestro.descripcion=datos.m_descripcion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tramo:maestro.id_tramo
			}
		});
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id.Tramo',maestro.id_tramo],['Codigo',maestro.codigo],['Descripcion',maestro.descripcion]]);
		paramFunciones.btnEliminar.parametros='&m_id_tramo='+maestro.id_tramo;
		paramFunciones.Save.parametros='&m_id_tramo='+maestro.id_tramo;
		paramFunciones.ConfirmSave.parametros='&m_id_tramo='+maestro.id_tramo;
		
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	

	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){
		return layout_tramo_unidad_constructiva.getLayout();
	};



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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tramo_unidad_constructiva.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}