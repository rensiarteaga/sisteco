<?php
session_start();
?>
//<script>
var detalle_movimiento;

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
var elemento={pagina:new PaginaDetalleMovimiento(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		 	detalle_movimientop.js  	  
 * Proposito: 		vista tal_detalle_movimiento		
 * Autor:			UNKNOW			
 * Fecha creacion:	30-05-2014
 */
 
function PaginaDetalleMovimiento(idContenedor,direccion,paramConfig)
{	 
	var vectorAtributos=new Array;  
	var componentes= new Array();  
	var maestro;
	var layout_detalle_movimiento;
	var cm,vista_grid,grid; 
	var combo_item;
	var combo_valorizados;
	var txt_unidad_medida;

	
	//---DATA STORE      
	 var ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/detalle_movimiento/ActionListarDetalleMovimiento.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_detalle_movimiento',
					totalRecords : 'TotalCount'
				}, [ 'id_detalle_movimiento', 'id_movimiento', 'id_item','id_item_valoracion',
						'codigo_movimiento', 'nombre_item', 'cantidad',
						'cantidad_solicitada', 'tipo_saldo', 'usuario_reg','desc_item','desc_item2',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						},'id_unidad_medida_base', 'nombre_medida','costo_unitario','costo_valorado','costo_total']),
				remoteSort : true
			});

	//DATA STORE COMBOS
	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion','nombre_medida'])});
	function render_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_item=new Ext.Template('<div class="search-item">','<i><b>{nombre}</b></i></br>',' <b>C&oacute;digo : </b><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	

	var ds_valorizados = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItemsValorizados.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','id_item_valoracion','cantidad','unidad_medida','nombre_item','desc_item'])});
	function render_valorizados(value, p, record){return String.format('{0}', record.data['desc_item2']);}
	var tpl_valorizados=new Ext.Template('<div class="search-item">','<b>{nombre_item}</b><br>','<FONT COLOR="#B5A642">{desc_item} </FONT></br>','<FONT COLOR="#0000FF">Cantidad:&nbsp&nbsp</FONT>{cantidad}','</div>');
	
	
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
			name: 'id_detalle_movimiento',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false,
		save_as : 'hidden_id_detalle_movimiento'
	},
	{
			validacion : {
				labelSeparator : '',
				name : 'id_movimiento',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			form : true,
			save_as : 'hidden_id_movimiento'
		},
		{
			validacion:{
				fieldLabel: 'Items.',
						allowBlank: true, 
						vtype:"texto",
						emptyText:'Items valorizados...',
						name:'id_item_valoracion',     //indica la columna del store principal "ds" del que proviane el id
						desc:'desc_item2', //indica la columna del store principal "ds" del que proviane la descripcion
						store: ds_valorizados,
						valueField:'id_item',
						displayField:'nombre_item',//campo del store q se mostrara
						queryParam:'filterValue_0',
						filterCol:'ite.nombre#ite.codigo',
						typeAhead:false,
						forceSelection :true,
						mode:'remote',
						queryDelay:50,
						pageSize:10,
						minListWidth :300,
						resizable:true,
						queryParam:'filterValue_0',
						minChars : 1, ///caracteres m�nimos requeridos para iniciar la busqueda
						triggerAction: 'all',
						renderer: render_valorizados,
						grid_visible:false, // se muestra en el grid
						grid_editable:false, //es editable en el grid,
						width_grid:220, // ancho de columna en el gris
						width:250,
						tpl: tpl_valorizados
			},
			tipo:'ComboBox',
			form: true,
			save_as:'txt_id_item_val'
		},
		{
		validacion:{
		fieldLabel: 'Item',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Item...',
				name: 'id_item',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_item', //indica la columna del store principal "ds" del que proviane la descripcion
				store: ds_item,
				valueField: 'id_item',
				displayField: 'nombre',//campo del store q se mostrara
				queryParam: 'filterValue_0',
				filterCol:'al.nombre#al.codigo',
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
			name :'cantidad_solicitada',
			fieldLabel : 'Cantidad Solicitada.',
			allowBlank : true,
			//allowNegative: false,
			//allowDecimals: true,
			//minValue : '0',
			//decimalPrecision : 2,
			align : 'right',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100,
			grid_indice:3,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'dem.cantidad_solicitada',
		form : true,
		save_as : 'txt_cantidad_solicitada'
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
				name : 'tipo_saldo',
				fieldLabel : 'Tipo Saldo',
				emptyText : 'Tipo de saldo...',
				allowBlank : true,
				typeAhead : true,
				loadMask : false,
				triggerAction : 'all',
				mode : "local",
				store : new Ext.data.SimpleStore({
					fields : [ 'valor', 'tipo_saldo' ],
					data : [ [ 'por_entregar', 'Por entregar' ],
							[ 'rechazado', 'Rechazado' ] ]
				}),
				valueField : 'valor',
				displayField : 'tipo_saldo',
				align : 'center',
				lazyRender : true,
				forceSelection : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 75,
				width:250,
				renderer : renderTipoSaldo
			},
			tipo : 'ComboBox',
			filtro_0 : false,
			filterColValue : 'dem.tipo_saldo',
			form : true,
			save_as : 'txt_tipo_saldo'
	},
	{
		validacion : {
			name :'costo_unitario',
			fieldLabel : 'Costo Unitario.',
			allowBlank : false,
			allowNegative: false,
			allowDecimals: true,
			minValue : '0',
			decimalPrecision : 2,
			align : 'right',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100,
			grid_indice:4,
			//locked:true,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'dem.costo_unitario',
		form : true,
		save_as : 'txt_costo_unitario'
	},
	{
		validacion : {
			name :'costo_total',
			fieldLabel : 'Costo Total.',
			allowBlank : false,
			allowNegative: false,
			allowDecimals: true,
			minValue : '0',
			decimalPrecision : 2,
			align : 'right',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100,
			grid_indice:5,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'dem.costo_total',
		form : true,
		save_as : 'txt_costo_total'
	},
	{
		validacion : {
			name :'costo_valorado',
			fieldLabel : 'Costo Valorado.',
			allowBlank : true,
			allowNegative: false,
			allowDecimals: true,
			minValue : '0',
			decimalPrecision : 2,
			align : 'right',
			grid_visible : true,
			grid_editable : false,
			width_grid : 100,
			grid_indice:6,
			width:250
		},
		tipo : 'NumberField',
		filtro_0 : false,
		filterColValue : 'dem.costo_valorado',
		form : false
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
			filtro_0:true
	}
	];
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
			titulo_maestro : 'detalle movimiento',
			grid_maestro : 'grid-' + idContenedor
		};
		layout_detalle_movimiento = new DocsLayoutMaestro(idContenedor);
		layout_detalle_movimiento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		this.pagina = Pagina;
		this.pagina(paramConfig, vectorAtributos, ds, layout_detalle_movimiento,
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

			//filtro items stock
			ds_item.baseParams={filtro_stock:'si',id_almacen:maestro.id_almacen};
		
			
			var comboTipoSaldo = CM_getComponente("tipo_saldo");
			var txtCantidadSolicitada = CM_getComponente("cantidad_solicitada");
			comboTipoSaldo.disable();
			CM_ocultarComponente(comboTipoSaldo);

			CM_mostrarComponente(CM_getComponente('id_item'));
 			CM_mostrarComponente(CM_getComponente('nombre_medida'));
 			CM_ocultarComponente(CM_getComponente('id_item_valoracion'));

			
			if (maestro.id_solicitud_salida != undefined && maestro.id_solicitud_salida != '' && maestro.id_solicitud_salida != null) 
			{
				CM_getComponente("id_item").disable();
				CM_mostrarComponente(txtCantidadSolicitada);
							
				var txtCantidadSolicitada = CM_getComponente("cantidad_solicitada");   
				var txtCantidad = CM_getComponente("cantidad");
				
				txtCantidadSolicitada.disable();
				txtCantidad.enable();
				
				
				var costo_tot = CM_getComponente("costo_total");
				CM_ocultarComponente(costo_tot);
				costo_tot.allowBlank=true;
				
				CM_ocultarComponente(CM_getComponente("costo_unitario"));
				CM_getComponente("costo_unitario").allowBlank=true;
				
				/*if (	txtCantidad.getValue() < txtCantidadSolicitada.getValue()	)
				{
					CM_mostrarComponente(comboTipoSaldo);
					comboTipoSaldo.enable();
				}*/
			
			} 
			else 
			{
				CM_getComponente("id_item").enable();
				CM_getComponente("cantidad_solicitada").disable();
				CM_getComponente("cantidad").enable()
				CM_ocultarComponente(txtCantidadSolicitada);
				
				CM_getComponente("tipo_saldo").setValue('entregado');
				
				if (maestro.nombre_tipo == 'salida')
				{
					var costo_tot = CM_getComponente("costo_total");
					CM_ocultarComponente(costo_tot);
					costo_tot.allowBlank=true;
					
					CM_ocultarComponente(CM_getComponente("costo_unitario"));
					CM_getComponente("costo_unitario").allowBlank=true;
				}
				else if (maestro.nombre_tipo == 'ingreso' )
				{
					var costo_tot = CM_getComponente("costo_total");
					CM_mostrarComponente(costo_tot);
					costo_tot.allowBlank=false;
					
					CM_getComponente("costo_unitario").allowBlank=true;
					CM_ocultarComponente(CM_getComponente("costo_unitario"));
				
				}
				else if (maestro.nombre_tipo == 'transpaso_ingreso')
				{
					CM_getComponente("id_item").disable();
					CM_getComponente("costo_unitario").allowBlank=true;
					CM_ocultarComponente(CM_getComponente("costo_unitario"));
					
					var costo_tot = CM_getComponente("costo_total");
					CM_mostrarComponente(costo_tot);
					costo_tot.allowBlank=false;
				}
				else if(maestro.nombre_tipo == 'salida' || maestro.nombre_tipo == 'transpaso_salida')
				{
					ds_valorizados.baseParams={filtro_stock:'si',id_almacen:maestro.id_almacen	};
					CM_mostrarComponente(CM_getComponente('id_item_valoracion'));
					CM_getComponente('id_item_valoracion').allowBlank=true;
					
					var item_id = CM_getComponente("id_item");
					CM_ocultarComponente(item_id);
					item_id.allowBlank=true;
				}
			}
		}
	this.btnNew = function() {
			CM_btnNew();

			//filtro items stock
			ds_item.baseParams={filtro_stock:'si',id_almacen:maestro.id_almacen};
			
			
			var comboTipoSaldo = CM_getComponente("tipo_saldo");
			var txtCantidadSolicitada = CM_getComponente("cantidad_solicitada");
			comboTipoSaldo.disable();
			CM_ocultarComponente(comboTipoSaldo);
			CM_getComponente("id_item").enable();
			CM_ocultarComponente(txtCantidadSolicitada);
			
			var costo_tot = CM_getComponente("costo_total");
			var costo_uni = CM_getComponente("costo_unitario");

 			CM_mostrarComponente(CM_getComponente('id_item'));
 			CM_mostrarComponente(CM_getComponente('nombre_medida'));
 			CM_ocultarComponente(CM_getComponente('id_item_valoracion'));
			
			if (maestro.nombre_tipo == 'salida' || maestro.nombre_tipo == 'transpaso_salida' || maestro.nombre_tipo == 'solicitud')
			{
				CM_ocultarComponente(costo_tot);
				costo_tot.allowBlank=true;
				costo_tot.setValue(0); 
				
				CM_ocultarComponente(costo_uni);
				costo_uni.allowBlank=true;
				costo_uni.setValue(0); 

				//a�adido 18/08/2015
 				if(maestro.nombre_tipo =='salida' || maestro.nombre_tipo == 'transpaso_salida')
 				{
 					ds_valorizados.baseParams={filtro_stock:'si',id_almacen:maestro.id_almacen	};
					CM_mostrarComponente(CM_getComponente('id_item_valoracion'));
					CM_getComponente('id_item_valoracion').allowBlank=true;
					
					var item_id = CM_getComponente("id_item");
					CM_ocultarComponente(item_id);
					item_id.allowBlank=true;					
 				}
			}
			else if(maestro.nombre_tipo == 'ingreso' || maestro.nombre_tipo == 'transpaso_ingreso' || maestro.nombre_tipo == 'devolucion') 
			{
				if(maestro.nombre_tipo == 'devolucion')
				{
					costo_tot.setValue(0);
					
					CM_mostrarComponente(costo_tot);
					costo_tot.allowBlank=true;

					CM_ocultarComponente(costo_uni);
					costo_uni.allowBlank=true;
					costo_uni.setValue(0)
				}
				else
				{	
					CM_mostrarComponente(costo_tot);
					costo_tot.allowBlank=false;
					
					CM_ocultarComponente(costo_uni);
					costo_uni.allowBlank=true;
					costo_uni.setValue(0);
				} 				
			}
			
		}
	
		this.reload = function(m) 
		{
			maestro = m;
			ds.lastOptions = {
				params : {
					start : 0,
					limit : paramConfig.TamanoPagina,
					CantFiltros : paramConfig.CantFiltros,
					id_movimiento : maestro.id_movimiento
					,tipo_control :maestro.tipo_control
					,tipo_mov:maestro.nombre_tipo
				}
			};
			vectorAtributos[1].defecto = maestro.id_movimiento;
			if (maestro.estado == "finalizado" || maestro.estado == "valorado")
			{
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("editar-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			} 
			else if (maestro.estado == "borrador") 
			{
				cm_getBoton("nuevo-" + idContenedor).show();
				cm_getBoton("editar-" + idContenedor).show();
				cm_getBoton("eliminar-" + idContenedor).show();
				
				//si tipo_movimiento=='transpaso_ingreso' no permite a�adir nuevo items
				if(maestro.nombre_tipo == 'transpaso_ingreso')
				{
					cm_getBoton("nuevo-" + idContenedor).hide();
					cm_getBoton("eliminar-" + idContenedor).hide();	
				}
				
				
			}
			else if (maestro.estado == "pendiente_aprobacion")
			{
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("editar-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
			}
			
			
			if (	maestro.id_solicitud_salida != null
					&& maestro.id_solicitud_salida != ''
					&& maestro.id_solicitud_salida != 'undefined') 
			{
				cm_getBoton("nuevo-" + idContenedor).hide();
				cm_getBoton("eliminar-" + idContenedor).hide();
				
				hideColumns([	[CM_getColumnNum('tipo_saldo'),false],
				             	[CM_getColumnNum('cantidad_solicitada'),false]
								,[CM_getColumnNum('costo_unitario'),true]
								,[CM_getColumnNum('costo_valorado'),true]
								,[CM_getColumnNum('costo_total'),true]
							]);  
			}
			else
			{
				hideColumns([	[CM_getColumnNum('tipo_saldo'),true],
				             	[CM_getColumnNum('cantidad_solicitada'),true]
				             	]);
				if (maestro.nombre_tipo == 'ingreso' || maestro.nombre_tipo == 'transpaso_ingreso' || maestro.nombre_tipo == 'devolucion')
				{
					hideColumns([	[CM_getColumnNum('costo_unitario'),false]
									,[CM_getColumnNum('costo_valorado'),false]
									,[CM_getColumnNum('costo_total'),false]
					             	]);
				}
				else
				{
					hideColumns([	[CM_getColumnNum('costo_unitario'),true]
					,[CM_getColumnNum('costo_valorado'),true]
					,[CM_getColumnNum('costo_total'),true]]);
				}
				
			}
						
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
	function renderTipoSaldo(component, value, record) {
		var tipo_saldo;
		if (record.data['tipo_saldo'] == 'por_entregar') {
			tipo_saldo = 'Por entregar';
		} 
		else if(record.data['tipo_saldo'] == 'entregado'){tipo_saldo='Entregado';}
		else {
			tipo_saldo = 'Rechazado';
		}
		return String.format('{0}', tipo_saldo);
	}
	//datos necesarios para el filtro
	var paramFunciones = {
			btnEliminar : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionEliminarDetalleMovimiento.php"
			},
			Save : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionGuardarDetalleMovimiento.php"
			},
			ConfirmSave : {
				url : direccion
						+ "../../../control/detalle_movimiento/ActionGuardarDetalleMovimiento.php"
			},
			Formulario : {
				titulo : 'Registro de Detalle Movimiento',
				html_apply : "dlgInfo-" + idContenedor,
				width : 518,
				height : 319,
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
		combo_valorizados = CM_getComponente('id_item_valoracion');	
		
		for(var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=CM_getComponente(vectorAtributos[i].validacion.name);
		}
	
		txt_unidad_medida.disable();
		var onComboItemSelect=function(e)
		{
			var id_item=combo_item.store.getById(combo_item.getValue());
				if (id_item)
				{
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
		}
		combo_item.on('select', onComboItemSelect);
		combo_item.on('change', onComboItemSelect);		 

 		
	  	var onComboItemValorizadoSelect=function(e)
		{
 			var id=combo_valorizados.store.getById(combo_valorizados.getValue());

 			if(id)
 			{
 				var medida = id.data.unidad_medida;
 				if (medida != undefined)
 					txt_unidad_medida.setValue(medida);
 				else txt_unidad_medida.setValue('');
 	 		}
 			
		}
 		combo_valorizados.on('select', onComboItemValorizadoSelect);
 		combo_valorizados.on('change', onComboItemValorizadoSelect);		
	}
	
	function hideColumns(colIndexes)
	{
			cm.totalWidth = null;
			for(var i=0;i<colIndexes.length;i++)
			{
				cm.config[colIndexes[i][0]].hidden = colIndexes[i][1];
		        var cid = vista_grid.getColumnId(colIndexes[i][0]);
		        
		        if(colIndexes[i][1]){
		        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "none");
		        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "none");
		        }
		        else{
		        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "");
		        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "");
		        }
		        
			}
	        if(Ext.isSafari){
	            vista_grid.updateHeaders();
	        }
	        vista_grid.updateSplitters();
	        vista_grid.layout();
	    }	
		
	//-------------- DEFINICION DE FUNCIONES PROPIAS --------------//
	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_detalle_movimiento.getLayout()};
	this.Init(); //iniciamos la clase madre 
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();
	
	// --- Eventos adicionales de la vista
	var cbxTipoSaldo = cm_getComponente("tipo_saldo");
	cbxTipoSaldo.enable();

	var txtCantidad = cm_getComponente("cantidad");
	txtCantidad.on("change",cantidadChange,this);

	function cantidadChange(field,newValue,oldValue) 
	{
		var txtCantidadSolicitada = cm_getComponente("cantidad_solicitada");
		var txtCantidad= cm_getComponente("cantidad");
		
		var cant_sol = txtCantidadSolicitada.getValue();
		var cant = txtCantidad.getValue();
		
		if (maestro.id_solicitud_salida != null && maestro.id_solicitud_salida != undefined && maestro.id_solicitud_salida != "") 
		{
			
			if (	Number(newValue) < Number(cant_sol)		)
			{
				CM_mostrarComponente(cbxTipoSaldo);
				cbxTipoSaldo.allowBlank=false;
				cbxTipoSaldo.setValue('');
				cbxTipoSaldo.enable();
			}
			else if (Number(newValue) == Number(cant_sol)	) 
			{
						CM_ocultarComponente(cbxTipoSaldo);
						cbxTipoSaldo.allowBlank=true;
						cbxTipoSaldo.setValue('entregado');
						cbxTipoSaldo.disable();
			} else 
			{
				field.setValue(cant_sol);
				CM_ocultarComponente(cbxTipoSaldo);
				cbxTipoSaldo.allowBlank=true;
				cbxTipoSaldo.setValue('entregado');
				cbxTipoSaldo.disable();
			}
		}
	} 
	cbxTipoSaldo.modificado = true;
	iniciarEventosFormularios();
	layout_detalle_movimiento.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}