<?php
session_start();
?>

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
var elemento={pagina:new PaginaTipoMaterial(idContenedor,direccion,paramConfig),idContenedor:'<?echo $idContenedor;?>'};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre: detalle_movimiento.js Autor: Ruddy Limbert Lujan Bravo Fecha
 * creaci�n: 09-09-2013
 */
function PaginaTipoMaterial(idContenedor, direccion, paramConfig) 
{
	var vectorAtributos = new Array();
	var componentes= new Array();  
	var ds;
	var layout_tipo_material;
	var maestro;

	var combo_item;
	var txt_unidad_medida;
	// DATA STORE //
	ds = new Ext.data.Store(
			{
				proxy : new Ext.data.HttpProxy(
						{
							url : direccion
									+ '../../../control/tipo_material/ActionListarTipoMaterial.php'
						}),
				reader : new Ext.data.XmlReader({
					record : 'ROWS',
					id : 'id_tipo_material',
					totalRecords : 'TotalCount'
				}, [ 'id_tipo_material','cod_tipo_material','nombre_tipo_material',
						'desc_tipo_material','usuario_reg',
						{
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				}
				 ]),
				remoteSort : true
			});

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
					name : 'id_tipo_material',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				form : true,
				save_as : 'h_id_tipo_material'
			},
			{
				validacion: {
					name: 'cod_tipo_material',
					fieldLabel: 'Codigo',
					allowBlank: false,
					maxLength:20,
					minLength:0,
					selectOnFocus:true,
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
				filterColValue:'tip.codigo',
				save_as:'txt_codigo_tipo'		
			},
			{
				validacion: {
					name: 'nombre_tipo_material',
					fieldLabel: 'Nombre',
					allowBlank: false,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
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
				filterColValue:'tip.nombre_tipo_material',
				save_as:'txt_nombre_tipo'	
			},
			{
				validacion : {
					name : 'desc_tipo_material',
					fieldLabel : 'Descripcion',
					allowBlank : true,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					valueField : 'valor',
					displayField : 'valor',
					align : 'left',
					lazyRender : true,
					grid_visible : true, // se muestra en el grid
					grid_editable : false,// es editable en el grid
					forceSelection : true,
					width_grid : 200, // ancho de columna en el grid
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'al.observaciones',
				filtro_1 : true,
				form : true,
				save_as : 'txt_desc_tipo'
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
					width_grid : 130
				},
				tipo : 'DateField',
				form : false,
				filtro_0 : false,
				filterColValue : 'tip.fecha_reg',
				dateFormat : 'm-d-Y'
			}
		];
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'detalle solicitud',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_tipo_material = new DocsLayoutMaestro(idContenedor);
	layout_tipo_material.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_tipo_material,
			idContenedor);

	// herencia de metodos
	var CM_getComponente = this.getComponente;
	var CM_btnNew = this.btnNew;
	var CM_btnEdit = this.btnEdit;
	var CM_ocultarComponente = this.ocultarComponente;
	var CM_mostrarComponente = this.mostrarComponente;
	
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
		return value ? value.dateFormat('d/m/Y h:i:s a') : '';
	};
	// funciones render
	
	// ---------------------- DEFINICI�N DE FUNCIONES -------------------------
	var paramFunciones = {
		btnEliminar : {
			url : direccion
					+ "../../../control/tipo_material/ActionEliminarTipoMaterial.php"
		},
		Save : {
			url : direccion
					+ "../../../control/tipo_material/ActionGuardarTipoMaterial.php"
		},
		ConfirmSave : {
			url : direccion
					+ "../../../control/tipo_material/ActionGuardarTipoMaterial.php"
		},
		Formulario : {
			titulo : 'Registro Tipo Materiales',
			html_apply : "dlgInfo-" + idContenedor,
			width : 550,
			height : 250,
			columnas : [ '95%' ],
			closable : true
		}
	};
	
	function iniciarEventosFormularios()
	{
	}
	
	
	// -------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;


	iniciarEventosFormularios();
	layout_tipo_material.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',
			this.onResizePrimario);
}