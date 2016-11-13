<?php
session_start();
?>

var almacen;
//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

	//
	var fa;
	<?php
	if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaTipoMovimiento(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: tipo_movimiento.js Autor: Ariel Ayaviri Omonte Fecha creaci�n:
 * 26-07-2013 Modificaciones :Ruddy Lujan Bravo 01-10-2013
 */

function PaginaTipoMovimiento(idContenedor, direccion, paramConfig) {
	var vectorAtributos = new Array();
	var ds;
	var layout_tipo_movimiento;

	// DATA STORE //
	ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/tipo_movimiento/ActionListarTipoMovimiento.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_tipo_movimiento',
					totalRecords : 'TotalCount'
				}, [ 'id_tipo_movimiento', 'id_documento', 'codigo_documento',
						'descripcion_documento', 'tipo', 'requiere_aprobacion','documento',
						'usuario_reg', {
							name : 'fecha_reg',
							type : 'date',
							dateFormat : 'd-m-Y'
						} ]),
				remoteSort : true
			});

	// Carga los datos en el DataStore.
	ds.load({
		params : {
			start : 0,
			limit : paramConfig.TamanoPagina,
			CantFiltros : paramConfig.CantFiltros
		}
	});

	// PAR�METROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_tipo_movimiento',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'hidden_id_tipo_movimiento'
			},
			{
				validacion : {
					name : 'id_documento',
					fieldLabel : 'Documento',
					allowBlank : false,
					emptyText : 'Documento...',
					desc : 'descripcion_documento',
					store : new Ext.data.Store(
							{
								proxy : new Ext.data.HttpProxy(
										{
											url : direccion
													+ '../../../../sis_parametros/control/documento/ActionListarDocumento.php'
										}),
								reader : new Ext.data.XmlReader({
									record : 'ROWS',
									id : 'id_documento',
									totalRecords : 'TotalCount'
								}, [ 'id_documento', 'codigo','documento','descripcion' ]),
								baseParams : {
									filterCol_1 : "SUBSIS.nombre_corto",
									filterValue_1 : 'ALMA'
								}
							}),
					valueField : 'id_documento',
					displayField : 'documento',
					queryParam : 'filterValue_0',
					filterCol : 'docume.codigo#docume.descripcion',
					typeAhead : false,
					forceSelection : true,
					tpl : new Ext.Template('<div class="search-item">',
							'<b>{codigo}</b>',
							'<br><FONT COLOR="#B5A642">{documento}</FONT>',
							'</div>'),
					mode : 'remote',
					queryDelay : 250,
					pageSize : 10,
					minListWidth : 450,
					width : 285,
					resizable : false,
					queryParam : 'filterValue_0',
					minChars : 2, // /caracteres m�nimos
					triggerAction : 'all',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100,
					CantFiltros : 2
				},
				tipo : 'ComboBox',
				form : true,
				save_as : 'txt_id_documento'
			},
			{
				validacion : {
					name : 'codigo_documento',
					fieldLabel : 'Codigo',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'doc.codigo',
				form : false
			},
			{
				validacion : {
					name : 'documento',
					fieldLabel : 'Documento',
					grid_visible : true,
					grid_editable : false,
					width_grid : 250
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'doc.documento',
				form : false
			},
			{
				validacion : {
					name : 'tipo',
					fieldLabel : 'Tipo',
					emptyText : 'Tipo...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'tipo' ],
						data : [ [ 'ingreso', 'Ingreso' ],
								[ 'salida', 'Salida' ],['solicitud','Solicitud Material']
								//a�adido 29/07/2014
								,['transpaso_ingreso','Transferencia Ingreso'],['transpaso_salida','Transferencia Salida']
								,['devolucion','Devolucion']
								//añadido 23/07/2015
								,['ingreso_proyecto','Ingreso Proyectos'],['salida_proyecto','Entrega Material']
								,['salida_uc','Salida Unidad Constructiva']
								]
					}),
					valueField : 'valor',
					displayField : 'tipo',
					align : 'left',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 80,
					width : 285,
					renderer : renderTipo
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tip.tipo',
				form : true,
				save_as : 'txt_tipo'
			},
			{
				validacion : {
					name : 'requiere_aprobacion',
					fieldLabel : 'Requiere aprobacion',
					align : 'center',
					emptyText : 'Requiere aprobacion...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'requiere_aprobacion' ],
						data : [ [ 'si', 'Si' ], [ 'no', 'No' ] ]
					}),
					valueField : 'valor',
					displayField : 'requiere_aprobacion',
					align : 'left',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 130,
					width : 285,
					renderer : renderaprobacion
				},
				tipo : 'ComboBox',
				filtro_0 : true,
				filterColValue : 'tip.requiere_aprobacion',
				form : true,
				save_as : 'txt_requiere_aprobacion'
			},
			{
				validacion : {
					name : 'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'tip.usuario_reg',
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
					width_grid : 120
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'tip.fecha_reg',
				dateFormat : 'd-m-Y'
			}];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'almacen',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_tipo_movimiento = new DocsLayoutMaestro(idContenedor);
	layout_tipo_movimiento.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_tipo_movimiento,
			idContenedor);

	var cm_EnableSelect = this.EnableSelect;
	
	
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
	}
	;

	// funciones render
	function renderTipo(component, value, record) {
		var tipo;
		if (record.data['tipo'] == 'ingreso')
		{
			tipo = 'Ingreso';
		} 
		else if(record.data['tipo'] == 'salida') 
		{
			tipo = 'Salida';
		}
		else if(record.data['tipo'] == 'solicitud') 
		{
			tipo = 'Solicitud Material'
		}
		else if(record.data['tipo'] == 'transpaso_ingreso') 
		{ 	tipo = 'Transferencia Ingreso'	}
		else if(record.data['tipo'] == 'transpaso_salida')
		{	tipo = 'Transferencia Salida'	}
		else if(record.data['tipo'] == 'devolucion')
		{	tipo = 'Devolucion'	}
		else if(record.data['tipo'] == 'ingreso_proyecto')
		{	tipo = 'Ingreso  Material (Proyecto)'	}
		else if(record.data['tipo'] == 'salida_proyecto')
		{	tipo = 'Entrega  Material (Proyecto)'	}
		else if(record.data['tipo'] == 'salida_uc')
		{	tipo = 'Salida Unidades Constructivas'	}
		
		
		return String.format('{0}', tipo);
	}

	function renderaprobacion(component, value, record) {
		var requiere_aprobacion;
		if (record.data['requiere_aprobacion'] == 'si') { 
			requiere_aprobacion = 'Si';
		} else {
			requiere_aprobacion = 'No';
		}
		return String.format('{0}', requiere_aprobacion);
	}
	// ---------------------- DEFINICI�N DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/tipo_movimiento/ActionEliminarTipoMovimiento.php"
		},
		Save : {
			url : direccion
					+ "../../../control/tipo_movimiento/ActionGuardarTipoMovimiento.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/tipo_movimiento/ActionGuardarTipoMovimiento.php"
		},
		Formulario : {
			titulo : 'Registro de Tipo Movimiento',
			html_apply : "dlgInfo-" + idContenedor,
			width : 450,
			height : 250,
			columnas : [ '95%' ],
			closable : true
		}
	};

	// -------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	this.iniciaFormulario();
	
	var cm_getBoton = this.getBoton;

	layout_tipo_movimiento.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);

}