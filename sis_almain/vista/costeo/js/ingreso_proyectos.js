function PaginaIngresoProyectos(idContenedor,direccion,paramConfig)
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
									+ '../../../control/costeo/ActionListarIngresos.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_ingresos',
					totalRecords : 'TotalCount'
				}, [ 	'id_ingresos', 'id_movimiento_proyecto', 'desc_mov_proy',
						'id_costeo', 'desc_costeo','seleccionado','fecha_ingreso','peso_neto'
					]),
				remoteSort : true
			});
	//DATA STORE COMBOS
	
	var ds_proyecto= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/movimiento_proyecto/ActionListarMovimientoProyecto.php?filtro_costeo=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_movimiento_proyecto',totalRecords: 'TotalCount'},['id_movimiento_proyecto','origen_ingreso','concepto_ingreso','estado','codigo'])
	});
	function render_proyecto(value, p, record){return String.format('{0}', record.data['desc_mov_proy']);}
	var tpl_proyecto=new Ext.Template('<div class="search-item">','{codigo}<br>','<FONT COLOR="#B5A642">{concepto_ingreso}</FONT>','</div>');
	
	function formatValida(value){if (value=='si') return 'Si';else return 'No'};
	///////////////////////// 
	// Definicion de datos // 
	/////////////////////////
	//en la posiciï¿½n 0 siempre esta la llave primaria

	vectorAtributos = [
	 {
		validacion:{
			labelSeparator:'',
			name: 'id_ingresos',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_ingresos'
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
			form : true,
			save_as : 'hidden_id_costeo'
	},
	{
		validacion : {
			name : 'seleccionado',
			fieldLabel : 'Seleccionado',
			renderer : formatValida, 
			checked: false,
			//align:'center',
			selectOnFocus:true,
			grid_visible : true,
			grid_editable : true,
			grid_indice:1,
			width : 30
		},
		form : true,
		tipo : 'Checkbox',
		save_as : 'chk_seleccionado' 
	},
	{
		validacion:{
		fieldLabel: 'Proyecto',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Proyecto...',
				name: 'id_movimiento_proyecto',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_mov_proy', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_proyecto,
				valueField: 'id_movimiento_proyecto',
				displayField: 'concepto_ingreso',//campo del store q se mostrara
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
				minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				renderer:render_proyecto,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:220, // ancho de columna en el gris
				width:250,
				tpl: tpl_proyecto,
				grid_indice:2
		},
		tipo:'ComboBox',
		filtro_0:true,
		form: true,
		filterColValue:'tram.codigo#tram.descripcion', 
		save_as:'hidden_id_mov_proyecto'	
	},
	{
		validacion : {
			name :'peso_neto',
			fieldLabel : 'Peso Neto.',
			allowBlank : true,
			align : 'right',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'mov.peso_neto',
		form : false
	},
	{

		validacion : {
			name : 'fecha_ingreso',
			fieldLabel : 'Fecha Ingreso Movimiento',
			allowBlank : true,
			format : 'd/m/Y', // formato para validacion
			minValue : '01/01/1900',
			disabledDaysText : 'Dia no Valido',
			grid_visible : true,
			grid_editable : false,
			//renderer : formatDate,
			width_grid : 110,
			disabled : false, 
			align : 'center',
			width : '50%'
		},
		form : false,
		tipo : 'DateField',
		filtro_0 : false,
		filterColValue : 'mov.fecha_ingreso',
		dateFormat : 'm-d-Y'
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
	
	var cm_getSelectionModel = this.getSelectionModel;
			
	this.reload = function(m) 
	{
		maestro = m;
		ds.lastOptions = 
		{
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_costeo : maestro.id_costeo
				}
		};
		CM_getComponente('id_costeo').defecto=maestro.id_costeo;
		paramFunciones.btnEliminar.parametros='&id_costeo='+maestro.id_costeo;
		paramFunciones.Save.parametros='&id_costeo='+maestro.id_costeo;
		paramFunciones.ConfirmSave.parametros='&id_costeo='+maestro.id_costeo;
		this.InitFunciones(paramFunciones)
		
		this.btnActualizar();
	}
	this.btnEdit = function()
	{ 
		var sm=cm_getSelectionModel();
		var SelectionsRecord=sm.getSelected();	
		
			CM_btnEdit();
			ds_proyecto.baseParams.id_almacen=maestro.id_almacen;
			CM_getComponente('id_costeo').setValue(maestro.id_costeo);
			
			//añadido 12-05-2015
			CM_mostrarComponente(cm_getComponente('seleccionado'));
			
		
		if(SelectionsRecord.data.seleccionado == "si")
			cm_getComponente('seleccionado').setValue(true);
		else
			cm_getComponente('seleccionado').setValue(false);
			
	}
	
	this.btnNew = function() 
	{
		CM_btnNew();
		ds_proyecto.baseParams.id_almacen=maestro.id_almacen;
		CM_getComponente('id_costeo').setValue(maestro.id_costeo);
		
		//añadido 12-05-2015
		CM_ocultarComponente(cm_getComponente('seleccionado'));
	}
		
	var paramMenu={
			guardar : {crear : true,separador : false},
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
				url : direccion+ "../../../control/costeo/ActionEliminarIngresoProyecto.php"
			},
			Save : {url : direccion+ "../../../control/costeo/ActionGuardarIngresoProyecto.php"
			},
			ConfirmSave : {url : direccion+ "../../../control/costeo/ActionGuardarIngresoProyecto.php"
			},
			Formulario : {
				titulo : 'Registro Ingreso Proyecto',
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
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}