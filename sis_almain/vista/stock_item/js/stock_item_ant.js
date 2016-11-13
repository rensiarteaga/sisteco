/**
 * Nombre:		 	stock_item.js  	  
 * Proposito: 		vista tal_stock_item		
 * Autor:			UNKNOW			
 * Fecha creacion:	30-05-2014
 */
 
function PaginaStockItem(idContenedor,direccion,paramConfig)
{	 
	var Atributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var maestroData;
	//---DATA STORE      
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/stock_item/ActionListarStockItem.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_stock_item',totalRecords:'TotalCount'
		},[		
		'id_stock_item',
		'id_item',
		'desc_item',
		'id_almacen',
		'desc_almacen', 
		'minimo',
		'maximo',
		'usuario_reg',{
			name : 'fecha_reg',
			type : 'date',
			dateFormat : 'd-m-Y'
		}
		]),remoteSort:true});
	//DATA STORE COMBOS
	
	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion'])
	});
	function render_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_item=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	
	var ds_almacen= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/almacen/ActionListarAlmacen.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_almacen','nombre','codigo','direccion'])
	});
	function render_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	var tpl_almacen=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{direccion}</FONT>','</div>');
	
	
	///////////////////////// 
	// Definicion de datos //
	/////////////////////////
	//en la posici�n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_stock_item',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_stock_item'
	};
	Atributos[1]={
			validacion : {
				labelSeparator : '',
				name : 'id_almacen',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			save_as : 'hidden_id_almacen'
	};
	Atributos[2]={
		validacion:{
		fieldLabel: 'Item',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Item...',
				name: 'id_item',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_item', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_item,
				valueField: 'id_item',
				displayField: 'nombre',//campo del store q se mostrara
				queryParam: 'filterValue_0',
				filterCol:'IT.codigo',
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
				renderer:render_item,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:200, // ancho de columna en el gris
				width:285,
				tpl: tpl_item,
				grid_indice:1
	},
	tipo:'ComboBox',
	id_grupo:0,
	filtro_0:false,
	form: true,
	save_as:'txt_id_item'	
	};
	Atributos[3]={
			validacion:{
			fieldLabel: 'Almacen',
					allowBlank: false,
					vtype:"texto",
					emptyText:'Almacen...',
					name: 'id_almacen',     //indica la columna del store principal "ds" del que proviane el id
					desc: 'desc_almacen',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
					store:ds_almacen,
					valueField: 'id_almacen',
					displayField: 'nombre',
					queryParam: 'filterValue_0',
					filterCol:'al.id_almacen',
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
					renderer:render_almacen,
					grid_visible:false, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:200, // ancho de columna en el gris
					width:285,
					tpl: tpl_almacen,
					grid_indice:2
		},
		tipo:'ComboBox',
		id_grupo:0,
		filtro_0:false,
		form: false,
		save_as:'txt_id_almacen'	
		};
	Atributos[4]={
			validacion : {
				name : 'minimo',
				fieldLabel : 'Stock Minimo',
				allowBlank : false,
				selectOnFocus:true,
				allowDecimals: true,
				allowNegative: false,
				decimalPrecision : 2,
				vtype:"texto",
				minValue : '0',
				round : false,
				align : 'center',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width : 250
			},
			tipo : 'NumberField',
			filtro_0 : true,
			filterColValue : 'stock.minimo',
			form : true,
			save_as : 'txt_minimo'
			
	};
	Atributos[5]={
			validacion : {
				name : 'maximo',
				fieldLabel : 'Stock Maximo',
				allowBlank : false,
				selectOnFocus:true,
				allowNegative: false,
				minValue : '0',
				round : false,
				allowDecimals: true,
				decimalPrecision : 2,
				vtype:"texto",
				align : 'center',
				grid_visible : true,
				grid_editable : false,
				width_grid : 100,
				width : 250
			},
			tipo : 'NumberField',
			filtro_0 : true,
			filterColValue : 'stock.maximo',
			form : true,
			save_as : 'txt_maximo'
			
	};
	Atributos[6]={
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'stock.usuario_reg',
			form : false
	};
	Atributos[7]={
		validacion : {
			name : 'fecha_reg',
			fieldLabel : 'Fecha Registro',
			format : 'd/m/Y',
			minValue : '01/01/1900',
			grid_visible : true,
			grid_editable : false,
			renderer : formatDate,
			align : 'center',
			width_grid : 150
		},
		tipo : 'DateField',
		form : false,
		filtro_0 : true,
		filterColValue : 'stock.fecha_reg',
		dateFormat : 'd-m-Y'
	};
	
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Stock_Item'
				,grid_maestro:'grid-'+idContenedor};
	var layout_stock_item=new DocsLayoutMaestro(idContenedor);
	layout_stock_item.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_stock_item,idContenedor);
	
	// herencia de metodos
	var CM_getComponente = this.getComponente;
	var CM_btnNew = this.btnNew;
	var CM_btnEdit = this.btnEdit;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	var cm_getComponente = this.getComponente;
	
	
	this.reload = function(m) {
		maestro = m;
		maestroData = m;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_almacen : maestro.id_almacen
			}
		};
		this.btnActualizar();
	};
	this.btnNew = function(event, target) {
		CM_btnNew(event, target);
		cm_getComponente("id_almacen").setValue(
		maestroData.id_clasificacion);
	}

	this.onResizePrimario = function() {
		layout_stock_item.getLayout().layout();
	}
	var paramMenu={
			guardar:{	crear:true
						,separador:false},
			nuevo:{		crear:true
				   		,separador:true
				   },
			editar:{
						crear:true 
						,separador:false
					},
			eliminar:{
						crear:true
						,separador:false
						},
			actualizar:{
						crear:true
						,separador:false
						}
		};
	
	
	
	//datos necesarios para el filtro
	var paramFunciones={ 
		btnEliminar:{url:direccion+'../../../control/stock_item/ActionEliminarStockItem.php'},
		Save:{url:direccion+'../../../control/stock_item/ActionGuardarStockItem.php'},
		ConfirmSave:{url:direccion+'../../../control/stock_item/ActionGuardarStockItem.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:450,columnas:['90%'],
			grupos:[
			        //{tituloGrupo:'Descripcion',columna:0,id_grupo:0},
			        {tituloGrupo:'Stock Item',columna:0,id_grupo:0}
			        ],
			width:'50%',
			minWidth:150,
			minHeight:200,	
			closable:true,
			titulo:' Stock Item '
			//guardar:abrirVentana
			}
		};
	
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	}
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_stock_item.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	
	iniciarEventosFormularios();
	layout_stock_item.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}