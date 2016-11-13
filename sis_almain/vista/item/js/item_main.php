<?php
session_start();
?>

var item;
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
var elemento={pagina:new PaginaItem(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: pagina_item.js Prop�sito: pagina objeto principal Autor: Ruddy Luj�n
 * Bravo Fecha creaci�n: 27-08-2013 16:53:59
 */
function PaginaItem(idContenedor, direccion, paramConfig) {
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_item;
	var maestroData;

	// DATA STORE //
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/item/ActionListarItem.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_item',
			totalRecords : 'TotalCount'
		}, [ 'id_item', 'id_clasificacion', 'id_unidad_medida',
				'nombre_clasificacion', 'nombre_medida', 'codigo', 'nombre',
				'descripcion', 'codigo_fabrica', 'num_por_clasificacion',
				'bajo_responsabilidad', 'estado', 'metodo_valoracion','peso','calidad','id_tipo_material','desc_tipo_material', 
				'usuario_reg', {
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				}]),
		remoteSort : true
	});
	
	function render_tipo_material(value, p, record){return String.format('{0}', record.data['desc_tipo_material']);}
	var tpl_tipo_material = new Ext.Template('<div class="search-item">','<b>{cod_tipo_material}</b><br>','<FONT COLOR="#0000FF">{nombre_tipo_material}</FONT></br>','</div>');
	
	// PAR�METROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_item',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_item'
			},
			{
				validacion : {
					labelSeparator : '',
					name : 'id_clasificacion',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_clasificacion'
			},
			{
				validacion : {
					name : 'id_unidad_medida',
					fieldLabel : 'Unidad medida',
					allowBlank : false,
					emptyText : 'Unidad medida...',
					desc : 'nombre_medida',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_unidad_medida_base',
									totalRecords : 'TotalCount'
								}, [ 'id_unidad_medida_base', 'nombre' ])
							}),
					valueField : 'id_unidad_medida_base',
					displayField : 'nombre',
					queryParam : 'filterValue_0',
					filterCol : 'UNMEDB.nombre',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 380,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2,
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 30
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'hidden_id_unidad_medida'
			},
			{
				validacion : {
					name : 'nombre_clasificacion',
					fieldLabel : 'Clasificacion',
					align : 'left',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'cla.nombre',
				form : false
			},
			{
				validacion : {
					name : 'codigo',
					fieldLabel : 'Codigo',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo',
				form : false,
				save_as : 'txt_codigo'
			},
			{
				validacion : {
					name : 'nombre',
					fieldLabel : 'Item',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 200,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.nombre',
				form : true,
				save_as : 'txt_nombre'
			},
			{
				validacion : {
					name : 'nombre_medida',
					fieldLabel : 'Unidad medida',
					grid_visible : true,
					grid_editable : false,
					width_grid : 50
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'UNMEDB.nombre',
				form : false
			},
			{
				validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : false,
				filterColValue : 'al.descripcion',
				form : true,
				save_as : 'txt_descripcion'
			},
			{
				validacion : {
					name : 'codigo_fabrica',
					fieldLabel : 'Codigo fabrica/No.Serial',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.codigo_fabrica',
				form : true,
				save_as : 'txt_codigo_fabrica'
			},
			{
				validacion : {
					name :'peso',
					fieldLabel : 'Peso Material (Kgr.)',
					allowBlank : true,
					allowNegative: false,
					allowDecimals: true,
					minValue : '0',
					decimalPrecision : 2,
					align : 'center',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width:285
				},
				tipo : 'NumberField',
				filtro_0 : true,
				filterColValue : 'al.peso',
				form : true,
				save_as : 'txt_peso_material'
			},
			{
				validacion : { 
					name : 'calidad',
					fieldLabel : 'Calidad Material',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'al.calidad',
				form : true,
				save_as : 'txt_calidad_material'
			},
			{
				validacion : {
					name : 'bajo_responsabilidad',
					fieldLabel : 'Tipo Item',
					emptyText : 'Bajo responsabilidad...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ 
						        [ 'activo_fijo', 'Activo Fijo' ]
								, [ 'bien', 'Bien Bajo Responsabilidad' ]
						        , [ 'material', 'Material' ]
						        , [ 'repuesto', 'Respuesto' ]
						        , [ 'material_construccion', 'Material de Construccion' ]
							   ]
					}),
					valueField : 'valor',
					displayField : 'nombre',
					align : 'center',
					lazyRender : true,
					forceSelection : false,
					grid_visible : false,
					grid_editable : false,
					width_grid : 150,
					width : 285,
					renderer : renderBajo_responsabilidad
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'al.bajo_responsabilidad',
				form : false,
				save_as : 'txt_bajo_responsabilidad'
			},
			{
				validacion:{
				name : 'id_tipo_material',
					fieldLabel : 'Tipo Item',
					allowBlank : false,
					emptyText : 'Tipo Material...',
					desc : 'desc_tipo_material',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_almain/control/tipo_material/ActionListarTipoMaterial.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_tipo_material',
									totalRecords : 'TotalCount'
								}, [ 'id_tipo_material', 'cod_tipo_material','nombre_tipo_material' ])
							}),
					valueField : 'id_tipo_material',
					displayField : 'nombre_tipo_material',
					queryParam : 'filterValue_0',
					filterCol : 'tip.nombre_tipo_material#tip.cod_tipo_material',
					typeAhead : false,
					forceSelection : true,
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 380,
					renderer: render_tipo_material,
					tpl: tpl_tipo_material,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2,
					triggerAction : 'all',
					grid_visible : true,
					grid_editable : true,
					width_grid : 150,
					width : 285
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'h_id_tipo_material'
			},
			{
				validacion : {
					name : 'metodo_valoracion',
					fieldLabel : 'Metodo valoracion',
					emptyText : 'Metodo valoracion...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'PP', 'PP' ], [ 'PEPS', 'PEPS' ],
								[ 'UEPS', 'UEPS' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285,
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				defecto:'PP',
				filterColValue : 'al.metodo_valoracion',
				form : true,
				save_as : 'txt_metodo_valoracion'
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
					width : 285,
					renderer : renderEstado
				},
				tipo : 'ComboBox',
				defecto:'activo',
				filtro_0 : false,
				filterColValue : 'al.estado',
				form : true,
				save_as : 'txt_estado'
			},
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
				filterColValue : 'al.usuario_reg',
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
					renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : false,
				filterColValue : 'al.fecha_reg',
				dateFormat : 'm-d-Y'
			}];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'item',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_item = new DocsLayoutMaestro(idContenedor);
	layout_item.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_item, idContenedor);

	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	
	
	

	this.reload = function(maestro) {
		maestroData = maestro;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_clasificacion : maestro.id_clasificacion
			}
		};
		
		//bloqueo de botones, cuando se selecciona un nodo
		/*
		if(maestroData.id_clasificacion_fk=='' || maestroData.id_clasificacion_fk==null || maestroData.id_clasificacion_fk==undefined)
		{
			//window.alert(maestroData.codigo);
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
			
			 
		}
		else
		{
			//window.alert(maestroData.text);
			cm_getBoton("nuevo-" + idContenedor).show();
			cm_getBoton("editar-" + idContenedor).show();
			cm_getBoton("eliminar-" + idContenedor).show();			
		}*/
		if(maestroData.tipo_rama=='padre' || maestroData.tipo_rama=='nodo' )
		{
			cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
		}
		else
		{
			cm_getBoton("nuevo-" + idContenedor).show();
			cm_getBoton("editar-" + idContenedor).show();
			cm_getBoton("eliminar-" + idContenedor).show();	
		}
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones)

	};

	this.btnNew = function(event, target) {
		cm_btnNew(event, target);
		cm_getComponente("id_clasificacion").setValue(
				maestroData.id_clasificacion);
	}

	this.onResizePrimario = function() {
		layout_item.getLayout().layout();
	}
	// ----------- DEFINICI�N DE LA BARRA DE MEN� ----------- //
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
		return value ? value.dateFormat('d/m/Y') : '';
	};

	// funciones render
	function renderEstado(component, value, record) {
		var estado;
		if (record.data['estado'] == 'activo') {
			estado = 'Activo';
		} else {
			estado = 'Inactivo';
		}
		return String.format('{0}', estado);
	}
	// funciones render
	function renderBajo_responsabilidad(component, value, record) 
	{
		var bajo_responsabilidad;
		
		if (record.data['bajo_responsabilidad'] == 'activo_fijo') {
			bajo_responsabilidad = 'Activo Fijo';
		} 
		else if(record.data['bajo_responsabilidad'] == 'bien')
		{	bajo_responsabilidad = 'Bien Bajo Responsabilidad';} 
		else if(record.data['bajo_responsabilidad'] == 'material')
		{	bajo_responsabilidad = 'Material';}
		else if(record.data['bajo_responsabilidad'] == 'repuesto')
			{bajo_responsabilidad = 'Respuesto';}
		else if(record.data['bajo_responsabilidad'] == 'material_construccion')
		{bajo_responsabilidad = 'Material de Construccion';}
		
		return String.format('{0}', bajo_responsabilidad);
	}

	// ---------------------- DEFINICI�N DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion + "../../../control/item/ActionEliminarItem.php"
		},
		Save : {
			url : direccion + "../../../control/item/ActionGuardarItem.php"
		},
		ConfirmSave : {
			url : direccion + "../../../control/item/ActionGuardarItem.php"
		},
		Formulario : {
			titulo : 'Registro de Items',
			html_apply : "dlgInfo-" + idContenedor,
			width : 500,
			height : 420,
			columnas : [ '95%' ],
			closable : true
		}
	};
	
	// -------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	
	cm_BloquearMenu();
	layout_item.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);

}