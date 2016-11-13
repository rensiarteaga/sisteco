/**
 * Nombre:		 	PaginaDetalleFaseTramo  	  
 * Proposito: 		vista tal_fase_tramo		
 * Autor:			UNKNOW			
 * Fecha creacion:	09-12-2014
 */
 
function PaginaDetalleFaseTramo(idContenedor,direccion,paramConfig)
{	 
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_fase_tramo;
	var cm,vista_grid,grid; 
	var combo_item;
	var txt_unidad_medida;
	
	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/fase_tramo/ActionListarFaseTramo.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_fase_tramo',
					totalRecords : 'TotalCount'
				}, [ 	'id_fase_tramo', 'id_fase', 'desc_fase',
						'id_tramo', 'desc_tramo','estado',
						'usuario_reg','fecha_reg'
						
				]),
				remoteSort : true
			});
	//DATA STORE COMBOS
	
	var ds_tramo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/tramo/ActionListarTramo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tramo',totalRecords: 'TotalCount'},['id_tramo','codigo','descripcion','estado'])
	});
	function render_tramo(value, p, record){return String.format('{0}', record.data['desc_tramo']);}
	var tpl_tramo=new Ext.Template('<div class="search-item">','{codigo}<br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	
	///////////////////////// 
	// Definicion de datos // 
	/////////////////////////
	//en la posici�n 0 siempre esta la llave primaria

	vectorAtributos = [
	 {
		validacion:{
			labelSeparator:'',
			name: 'id_fase_tramo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_fase_tramo'
	},
	{
			validacion : {
				labelSeparator : '',
				name : 'id_fase',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			form : true,
			save_as : 'hidden_id_fase'
	},
	{
		validacion:{
		fieldLabel: 'Tramo',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Tramo...',
				name: 'id_tramo',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_tramo', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_tramo,
				valueField: 'id_tramo',
				displayField: 'codigo',//campo del store q se mostrara
				queryParam: 'filterValue_0',
				filterCol:'tram.codigo',
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
				renderer:render_tramo,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:220, // ancho de columna en el gris
				width:250,
				tpl: tpl_tramo,
				grid_indice:1
		},
		tipo:'ComboBox',
		filtro_0:true,
		form: true,
		filterColValue:'tram.codigo#tram.descripcion',
		save_as:'hidden_id_tramo'	
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
			width : 250
			//renderer : renderEstado
		},
		tipo : 'ComboBox',
		filtro_0 : false,
		filterColValue : 'fatram.estado',
		form : true,
		save_as : 'txt_estado'
	},
	{
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 190
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'fatram.usuario_reg',
			form : false
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
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
		layout_fase_tramo = new DocsLayoutMaestro(idContenedor);
		layout_fase_tramo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		this.pagina = Pagina;
		this.pagina(paramConfig, vectorAtributos, ds, layout_fase_tramo,idContenedor);
	// herencia de metodos
		var CM_getComponente = this.getComponente;
		var CM_btnNew = this.btnNew;
		var CM_btnEdit = this.btnEdit;
		var CM_ocultarComponente = this.ocultarComponente;
		var CM_mostrarComponente = this.mostrarComponente;
		var cm_getComponente = this.getComponente;
		var CM_getColumnModel=this.getColumnModel;
		var CM_getColumnNum=this.getColumnNum;
		
		
		this.btnEdit = function()
		{ 
			CM_btnEdit();
		}
		this.btnNew = function() 
		{
			CM_btnNew();
			cm_getComponente('id_fase').setValue(maestro.id_fase);
		}
	
		this.reload = function(m) 
		{
			maestro = m;
			ds.lastOptions = 
			{
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_fase : maestro.id_fase
				}
			};
			
			if(maestro.sw_tramo == 'no')
			{
				cm_BloquearMenu();
			}	
			else
			{
				cm_DesbloquearMenu();
			}
			
			this.btnActualizar();
		}
		
		
	var paramMenu={
			nuevo:{		crear:true,separador:false	},
			editar:{	crear:true ,separador:false},
			eliminar:{	crear:true,separador:false},
			actualizar:{crear:true,separador:false}
			};
	function formatDate(value) 
	{
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	
	//datos necesarios para el filtro
	var paramFunciones = 
	{
			btnEliminar : {
				url : direccion+ "../../../control/fase_tramo/ActionEliminarFaseTramo.php"
			},
			Save : {url : direccion+ "../../../control/fase_tramo/ActionGuardarFaseTramo.php"
			},
			ConfirmSave : {url : direccion+ "../../../control/fase_tramo/ActionGuardarFaseTramo.php"
			},
			Formulario : {
				titulo : 'Registro Fase Tramo',
				html_apply : "dlgInfo-" + idContenedor,
				width : 450,
				height : 250,
				columnas : [ '95%' ],
				closable : true
			}
	};
	
	function iniciarEventosFormularios()
	{
	}
	
		
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	this.getLayout=function(){return layout_fase_tramo.getLayout()};
	this.Init(); //iniciamos la clase madre 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	
	iniciarEventosFormularios();
	layout_fase_tramo.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}