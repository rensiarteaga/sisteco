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
var elemento={pagina:new PaginaDetalleSolicitud(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: detalle_movimiento.js Autor: Ruddy Limbert Lujan Bravo Fecha
 * creación: 09-09-2013
 */
function PaginaDetalleSolicitud(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array();
	var componentes= new Array();  
	var ds;
	var layout_detalle_solicitud;
	var maestro;

	var combo_item;
	var txt_unidad_medida;
	// DATA STORE //
	ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/detalle_solicitud/ActionListarDetalleSolicitud.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_detalle_solicitud',
					totalRecords : 'TotalCount'
				}, [ 'id_detalle_solicitud','id_solicitud_salida','id_item',
						'nombre_item','desc_item','cantidad',
						'cantidad_solicitada', 'tipo_saldo', 'usuario_reg',
						{
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y h:i:s a'
						},'id_unidad_medida_base','nombre_medida']),
				remoteSort : true
			});

	
	var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion','cantidad','nombre_medida','reservados'])
	});
	function render_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_item=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT>','<br>Cantidad : <FONT COLOR="#0000ff">{cantidad}</FONT>','<br>Reservados: <FONT COLOR="#0000ff">{reservados}</FONT>','</div>');

	
	// PARÁMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_detalle_solicitud',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_detalle_solicitud'
			},
			{
				validacion : {
					labelSeparator : '',
					name : 'id_solicitud_salida',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_solicitud_salida'
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
							filterCol:'al.nombre#al.codigo',
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
							renderer:render_item,
							grid_visible:true, // se muestra en el grid
							grid_editable:false, //es editable en el grid,
							width_grid:200, // ancho de columna en el gris
							width:285,
							tpl: tpl_item,
							grid_indice:1
				},
				tipo:'ComboBox',
				id_grupo:0,
				filtro_0:true,
				form: true,
				filterColValue:'itm.codigo#itm.nombre',
				save_as:'txt_id_item'
			},
			{
				validacion : {
					name : 'cantidad',
					fieldLabel : 'Cantidad',
					allowBlank : false,
					align : 'right',
					grid_visible : true,
					grid_editable : false,
					width_grid : 80,
					grid_indice:3,
					width : 285
				},
				tipo : 'NumberField',
				filtro_0 : false,
				filterColValue : 'dem.cantidad',
				form : true,
				save_as : 'txt_cantidad'
			},
			{
				validacion : {
					name : 'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'des.usuario_reg',
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
					width_grid : 130
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'des.fecha_reg',
				dateFormat : 'm-d-Y'
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
					width:285,
					locked:false
				},
				tipo: 'TextField',
				form:true,
				filtro_0:true,
				filtro_1:true,
				filterColValue:'um.nombre',	
			}
			,
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
					width_grid:120, // ancho de columna en el gris
					disabled: false,
					grid_indice:2,
					width:285
				},
				tipo: 'TextField',
				form:false
		}];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'detalle solicitud',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_detalle_solicitud = new DocsLayoutMaestro(idContenedor);
	layout_detalle_solicitud.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_detalle_solicitud,
			idContenedor);

	// herencia de metodos
	var CM_getComponente = this.getComponente;
	var CM_btnNew = this.btnNew;
	var CM_btnEdit = this.btnEdit;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	var cm_conexionFailure = this.conexionFailure;
	var cm_btnActualizar = this.btnActualizar;
	
	//filtro cantidad items en una solicitud
	this.btnNew	=	function()
	{
		CM_btnNew();
		var cmbItem=CM_getComponente('id_item');
		cmbItem.store.baseParams = {
			 filtro_solicitud:'si'
			,id_almacen: maestro.id_almacen 
		};
	}

	this.btnEdit = function()
	{	
		CM_btnEdit()
		var cmbItem=CM_getComponente('id_item');
		cmbItem.store.baseParams = {
			 filtro_solicitud:'si'
			,id_almacen: maestro.id_almacen 
		};
	}
	
	this.reload = function(m) 
	{
		maestro = m;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_solicitud_salida : maestro.id_solicitud_salida
			}
		};
		vectorAtributos[1].defecto = maestro.id_solicitud_salida;
		if (maestro.estado == "finalizado") 
		{
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		} 
		else if (maestro.estado == "borrador") {
			cm_getBoton("nuevo-" + idContenedor).show();
			cm_getBoton("editar-" + idContenedor).show();
			cm_getBoton("eliminar-" + idContenedor).show();
		}
		/*if (maestro.id_solicitud_salida != null
				&& maestro.id_solicitud_salida != ''
				&& maestro.id_solicitud_salida != 'undefined') 
		{
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		}*/

		else if (maestro.estado == "pendiente_aprobacion" || maestro.estado =='pendiente_entrega' || maestro.estado =='entregado')  
		{
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		}
		this.btnActualizar();
	}
	// ----------- DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	var paramMenu = {
		nuevo : {
			crear : true,
			separador : true
		},
		editar : {
			crear : true,
			separador : false
		},
		eliminar : {
			crear : true,
			separador : false
		},
		actualizar : {
			crear : true,
			separador : false
		}
	};

	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	}
	;
	// funciones render
	
	// ---------------------- DEFINICIÓN DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionEliminarDetalleSolicitud.php"
		},
		Save : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionGuardarDetalleSolicitud.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/detalle_solicitud/ActionGuardarDetalleSolicitud.php"
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
		combo_item=CM_getComponente('id_item');
		txt_unidad_medida=CM_getComponente('nombre_medida');

		var cantidad =  CM_getComponente('');
		
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
			
		}
		combo_item.on('select', onComboItemSelect);
		combo_item.on('change', onComboItemSelect);
	}
	
	
	// -------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;

	cm_BloquearMenu();

	CM_getComponente('cantidad').on('blur',controlStockMinimo,this);

	function controlStockMinimo(record)
	{
		var cant = CM_getComponente('cantidad').getValue();
		var item = CM_getComponente('id_item').getValue();

		Ext.Ajax.request({
			url:direccion+"../../../lib/ActionControlStockMinimo.php",
			method:'POST',
			params:{	id_almacen : maestro.id_almacen,
						id_item : item
					},
			success: mensajesStockMinimo,
			failure:cm_conexionFailure,
			timeout:100000000	
		});
	}

	function mensajesStockMinimo(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;

			if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue > 0)
			{
				var existencias_item = root.getElementsByTagName('cantidad_disponible')[0].firstChild.nodeValue;
				var stock_minimo_item = root.getElementsByTagName('stock_minimo')[0].firstChild.nodeValue;

				var cantidad_solicitada =  CM_getComponente('cantidad').getValue();

				var saldo = (new Number(existencias_item)  - new Number(cantidad_solicitada));

				if(saldo < 0)
				{
					Ext.MessageBox.show({
						title: 'Verificando Solicitud Item...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Las existencias del item en el almacen son insuficientes con respecto a la cantidad solicitada </br>Existencias Item :"+existencias_item+"</br> Cantidad Solicitada :"+cantidad_solicitada+"</div>",
						width:300,
						height:200,
						closable:true
					});
				} 	 

				else if(saldo < new Number(stock_minimo_item))
				{
					Ext.MessageBox.show({
						title: 'Procesando...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>El item solicitado en el almacen reduce al m&iacute;nimo el stock permitido en el almacen </br> Existencias Item :"+existencias_item+"</br> Cantidad Solicitada :"+cantidad_solicitada+"</br>Stock M&iacute;nimo Item Almacen :"+stock_minimo_item+"</div>",
						width:300,
						height:200,
						closable:true
					});
				}
			}
		}
	}
	
	iniciarEventosFormularios();
	layout_detalle_solicitud.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}