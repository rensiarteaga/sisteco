<?php
session_start();
?>

var detalle_movimiento;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		?>

	//
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaDetalleMovimientoProyecto(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		 	movimiento_proyecto_det.js  	  
 * Proposito: 		vista tal_movimiento_proyecto_det		
 * Autor:			UNKNOW			
 * Fecha creacion:	27-10-2014
 */
 
function PaginaDetalleMovimientoProyecto(idContenedor,direccion,paramConfig)
{	 
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_detalle_movimiento_proyecto_det;
	var cm,vista_grid,grid;  
	var combo_item;
	var txt_unidad_medida;

	 
	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/movimiento_proyecto_det/ActionListarMovimientoProyectoDet.php'
						}),
				reader : new Ext.data.XmlReader({ 
					record : 'ROWS',
					id : 'id_proyecto_mov_det',
					totalRecords : 'TotalCount'
				}, [ 'id_proyecto_mov_det', 'id_movimiento_proyecto', 'cantidad',
						'unidad_medida', 'id_item', 'desc_item',
						'id_unidad_medida_base', 'nombre_medida', 'usuario_reg','costo_unitario',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						}]),
				remoteSort : true
			});
	//DATA STORE COMBOS
	
	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion','nombre_medida'])
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

	vectorAtributos = [
	 {
		validacion:{
			labelSeparator:'',
			name: 'id_proyecto_mov_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_mov_proy_det'
	},
	{
			validacion : {
				labelSeparator : '',
				name : 'id_movimiento_proyecto',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			form : true,
			save_as : 'hidden_id_movimiento_proyecto'
		},
	{
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
				filterCol:'itm.nombre_item',
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
				grid_editable:false, //es editable en el grid,
				width_grid:220, // ancho de columna en el gris
				width:250,
				tpl: tpl_item,
				grid_indice:1
	},
	tipo:'ComboBox',
	filtro_0:true,
	form: true,
	filterColValue:'itm.codigo#itm.nombre',
	save_as:'txt_id_item'	
	},
	{
			validacion: {
				name: 'nombre_medida',
				fieldLabel: 'Unidad Medida',
				allowBlank: false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:100, // ancho de columna en el grid
				disabled: false,
				grid_indice:2,
				width:250,
				locked:true
			},
			tipo: 'TextField',
			form:true
	},
	{
			validacion : {
				name : 'cantidad',
				fieldLabel : 'Cantidad',
				allowBlank : false,
				align : 'right',
				allowNegative: false,
				allowDecimals: true,
				minValue : '0',
				decimalPrecision : 2,
				grid_visible : true,
				grid_editable : false,
				width_grid : 80,
				grid_indice:4,
				width:250
			},
			tipo : 'NumberField',
			filtro_0 : false,
			filterColValue : 'dem.cantidad',
			form : true,
			save_as : 'txt_cantidad'			
	},
	{
		validacion : {
			name : 'costo_unitario',
			fieldLabel : 'Precio Unitario',
			allowBlank : true,
			align : 'right',
			allowNegative: false,
			allowDecimals: true,
			minValue : '0',
			decimalPrecision : 2,
			grid_visible : true,
			grid_editable : false,
			width_grid : 80,
			grid_indice:4,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'movdet.costo_unitario',
		form : true,
		save_as : 'txt_costo_unitario'	
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
			filterColValue : 'dem.usuario_reg',
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
			renderer : formatDate,
			align : 'center',
			width_grid : 150
		},
		tipo : 'DateField',
		form : false,
		filtro_0 : false,
		filterColValue : 'dem.fecha_reg',
		dateFormat : 'd-m-Y'
	},
	{
			validacion: {
				name: 'nombre_medida',
				fieldLabel: 'Unidad Medida',
				allowBlank: false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				//vtype:"alphaLatino",
				vtype:"texto",
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:120, // ancho de columna en el gris
				disabled: false,
				grid_indice:2,
				width:285
			},
			tipo: 'TextField',
			form:false,
			filterColValue:'um.nombre',
			save_as:'txt_unidad_medida',
			filtro_0:true
	}
	];
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
	layout_detalle_movimiento_proyecto_det = new DocsLayoutMaestro(idContenedor);
	layout_detalle_movimiento_proyecto_det.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		this.pagina = Pagina;
		this.pagina(paramConfig, vectorAtributos, ds, layout_detalle_movimiento_proyecto_det,
				idContenedor);
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
		
			
	}
	
		this.reload = function(m) 
		{
			maestro = m;
			ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_movimiento_proyecto: maestro.id_movimiento_proyecto
				}
			};
			vectorAtributos[1].defecto = maestro.id_movimiento_proyecto;
			/*if (maestro.estado == "finalizado" || maestro.estado == "valorado")
			{
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("editar-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			} */
			
			
			this.btnActualizar();
		}
		
		
	var paramMenu={
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
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	// funciones render

	//datos necesarios para el filtro
	var paramFunciones = {
			btnEliminar : {
				url : direccion
						+ "../../../control/movimiento_proyecto_det/ActionEliminarMovimientoProyectoDet.php"
			},
			Save : {
				url : direccion
						+ "../../../control/movimiento_proyecto_det/ActionGuardarMovimientoProyectoDet.php"
			},
			ConfirmSave : {
				url : direccion
						+ "../../../control/movimiento_proyecto_det/ActionGuardarMovimientoProyectoDet.php"
			},
			Formulario : {
				titulo : 'Registro de Detalle Movimiento',
				html_apply : "dlgInfo-" + idContenedor,
				width : 450,
				height : 250,
				columnas : [ '95%' ],
				closable : true
			}
		};
	
	
	
	function iniciarEventosFormularios()
	{
		cm=CM_getColumnModel();
		grid=getGrid();
		vista_grid=grid.getView();
		
		combo_item=CM_getComponente('id_item');
		txt_unidad_medida=CM_getComponente('nombre_medida');
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=CM_getComponente(vectorAtributos[i].validacion.name);
		}
		

		txt_unidad_medida.disable();
		var onComboItemSelect=function(e)
		{
			var id_item=combo_item.store.getById(combo_item.getValue());
			var desc_medida=id_item.data.nombre_medida;
			
			if(desc_medida!=undefined)
			{
				txt_unidad_medida.setValue(desc_medida);
			}
			else
			{
				txt_unidad_medida.setValue('');	
				//cod_tipo_activo='';
			}
			
		}
		combo_item.on('select', onComboItemSelect);
		combo_item.on('change', onComboItemSelect);
		
		
	}
	
		
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_detalle_movimiento_proyecto_det.getLayout()};
	this.Init(); //iniciamos la clase madre 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	
	iniciarEventosFormularios();
	layout_detalle_movimiento_proyecto_det.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}