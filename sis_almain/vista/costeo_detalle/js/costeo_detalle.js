/**
 * Nombre:		  	    pagina_costeo_detalle.js
 * Prop�sito: 		pagina objeto principal
 * Autor:				UNKNOW
 * Fecha creacion:		12-05-2015
 */
function pagina_costeo_detalle(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var combo_uc;
	var layout_costeo_det;
	var maestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/costeo_detalle/ActionListarCosteoDetalle.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_costeo_detalle',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_costeo_detalle',
		'valor_costo',
		'id_costeo','desc_costeo',
		'id_costo','desc_costo','estado','usuario_reg','fecha_reg'

		]),remoteSort:true}); 
	
		var ds_costo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/costo/ActionListarCosto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_costo',totalRecords: 'TotalCount'},['id_costo','codigo_costo','desc_costo','estado'])
		});
		function render_costo(value, p, record){return String.format('{0}', record.data['desc_costo']);}
		var tpl_costo=new Ext.Template('<div class="search-item">','{codigo_costo}<br>','<FONT COLOR="#B5A642">{desc_costo}</FONT>','</div>');


		function renderEstado(component, value, record) {
			var estado;
			if (record.data['estado'] == 'activo') {
				estado = 'Activo';
			} else {
				estado = 'Inactivo';
			}
			return String.format('{0}', estado);
		}
	// DEFINICION DATOS DEL MAESTRO

	//DATA STORE COMBOS
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	vectorAtributos = 
		[
		 	{
		 		validacion:
		 		{
					labelSeparator:'',
					name: 'id_costeo_detalle',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'h_id_costeo_det'
		 	},
		 	{
				validacion : {
					labelSeparator : '',
					name : 'id_costeo',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'h_id_costeo'
			},
		 	{
		 		validacion:{
					fieldLabel: 'Costos',
							allowBlank: false,
							vtype:"texto",
							emptyText:'Costos relacionados...',
							name: 'id_costo',     //indica la columna del store principal "ds" del que proviane el id
							desc: 'desc_costo', //indica la columna del store principal "ds" del que proviane la descripcion
							store:ds_costo,
							valueField: 'id_costo',
							displayField: 'codigo_costo',//campo del store q se mostrara
							queryParam: 'filterValue_0',
							filterCol:'cos.codigo_costo#cos.desc_costo',
							typeAhead: false,
							forceSelection : true,
							mode: 'remote',
							queryDelay: 50,
							pageSize: 10,
							minListWidth : 300,
							resizable: true,
							queryParam: 'filterValue_0',
							minChars : 1, ///caracteres m�nimos requeridos para iniciar la busqueda
							triggerAction: 'all',
							renderer:render_costo,
							grid_visible:true, // se muestra en el grid
							grid_editable:false, //es editable en el grid,
							width_grid:220, // ancho de columna en el gris
							width:250,
							tpl: tpl_costo
					},
					tipo:'ComboBox',
					filtro_0:true,
					form: true,
					filterColValue:'cos.estado#cos.descripcion', 
					save_as:'h_id_costo'
		 	},
		 	{
				validacion : {
					name :'valor_costo',
					fieldLabel : 'Valor',
					allowBlank : true,
					allowNegative: false,
					allowDecimals: true,
					minValue : '0',
					decimalPrecision : 2,
					align : 'center',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width:250
				},
				tipo : 'NumberField',
				filtro_0 : true,
				filterColValue : 'al.peso',
				form : true,
				save_as : 'txt_valor_costo'
			},
			{
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : true,
					typeAhead : true,
					loadMask : false,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'nombre',
					align : 'center',
					lazyRender : true,
					forceSelection : false,
					grid_visible : true,
					
					grid_editable : false,
					width_grid : 55,
					width : 250,
					renderer : renderEstado
				},
				tipo : 'ComboBox',
				filtro_0 : false,
				defecto:'activo',
				filterColValue : 'al.estado',
				form : true,
				save_as : 'txt_estado'
			},
			{
				validacion : {
					name : 'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					//renderer : formatDate,
					align : 'center',
					width_grid : 150
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'fatram.fecha_reg',
				dateFormat : 'd-m-Y'
			}
			
		 
		];

	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:' Detalle Costeo ',
		grid_maestro:'grid-'+idContenedor
	};
	layout_costeo_det = new DocsLayoutMaestro(idContenedor);
	layout_costeo_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_costeo_det,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_btnActualizar = this.btnActualizar;
	//-------- DEFINICI�N DE LA BARRA DE MEN�
	
	this.btnNew =function()
	{
		ClaseMadre_btnNew();
		ClaseMadre_getComponente('id_costeo').setValue(maestro.id_costeo);
	}
	
	
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	this.reload = function(m)
	{
		maestro = m;
		ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					m_id_costeo: maestro.id_costeo
				}};
		ClaseMadre_getComponente('id_costeo').setValue(maestro.id_costeo);
		
		paramFunciones.btnEliminar.parametros='&id_costeo='+maestro.id_costeo;
		paramFunciones.Save.parametros='&id_costeo='+maestro.id_costeo;
		paramFunciones.ConfirmSave.parametros='&id_costeo='+maestro.id_costeo;
		this.InitFunciones(paramFunciones)
		cm_btnActualizar();
	}

	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/costeo_detalle/ActionEliminarCosteoDetalle.php'},
	Save:{url:direccion+'../../../control/costeo_detalle/ActionGuardarCosteoDetalle.php'},
	ConfirmSave:{url:direccion+'../../../control/costeo_detalle/ActionGuardarCosteoDetalle.php'},
	Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:340,width:480,
					minWidth:150,minHeight:200,closable:true,titulo: 'Relacion Costeo/Costos'
				}
	}		
	
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	

	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_costeo_det.getLayout();};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	

	iniciarEventosFormularios();
	layout_costeo_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}