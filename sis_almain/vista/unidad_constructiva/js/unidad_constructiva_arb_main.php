<?php
/**
 * Nombre:		  	    unidad_constructiva_arb_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				UNKNOW
 * Fecha creación:		08-08-2014
 *
 */
session_start();
?>
//<script>
function main(){
	 	<?php
			// obtenemos la ruta absoluta
			$host = $_SERVER['HTTP_HOST'];
			$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$dir = "http://$host$uri/";
			echo "\nvar direccion='$dir';";
			echo "var idContenedor='$idContenedor';";
			?>
	var fa=false;
	<?php
	
if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:fa};
var elemento={pagina:new pagina_unidad_constructiva_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_unidad_constructiva_arb(idContenedor, direccion, paramConfig){
	var DatosNodo = new Array('id', 'id_p', 'tipo');
	var DatosDefecto = {};
	var Dialog;
	var idAlmacen;
	
	
	var config = {
			titulo : 'Unidad Constructiva',
				area : 'south',
				urlHijo : '../../../sis_almain/vista/detalle_unidad_constructiva/detalle_unidad_constructiva.php'	
		};
	
	
	var Atributos = [ { 
		validacion : {
			labelSeparator : '',
			name : 'id_unidad_constructiva',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_unidad_constructiva'
	},
	{
		validacion : {
			labelSeparator : '',
			name : 'id_unidad_constructiva_fk',
			inputType : 'hidden'
		},
		tipo : 'Field',
		save_as : 'hidden_id_unidad_constructiva_fk'
	},
	{
		validacion : 
		{
			name :'orden',
			fieldLabel : 'Nro.(despues de)',
			allowBlank : true,
			allowNegative: false,
			allowDecimals: false,
			minValue : '0',
			//decimalPrecision : 2,
			align : 'center',
			grid_visible : true,
			grid_editable : false, 
			width_grid : 120,
			width:100
		},
		tipo : 'NumberField',
		//filtro_0 : true,
		//filterColValue : 'al.peso',
		form : true,
		save_as : 'txt_orden_uc'
	},
	{
		validacion : {
			name : 'codigo',
			fieldLabel : 'Codigo',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		save_as : 'txt_codigo'
	},
	{
		validacion : {
			name : 'nombre',
			fieldLabel : 'Nombre',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		save_as : 'txt_nombre'
	},
	{
		validacion : {
			name : 'descripcion',
			fieldLabel : 'Descripcion',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextArea',
		form : true,
		save_as : 'txt_descripcion'
	},
	{
		validacion : {
			name : 'observaciones',
			fieldLabel : 'Observaciones',
			allowBlank : false,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextArea',
		form : true,
		save_as : 'txt_observaciones'
	},
	{
		validacion : {
			name : 'cod_tramo',
			fieldLabel : 'Cod. Tramo',
			allowBlank : true,
			maxLength : 100,
			minLength : 0,
			selectOnFocus : true,
			vtype : 'texto',
			width : '100%',
			disabled : false
		},
		tipo : 'TextField',
		form : true,
		save_as : 'txt_cod_tramo'
	}
	/*,
	{
		validacion : {
			name : 'estado',
			fieldLabel : 'Estado',
			emptyText : 'Estado....', 
			allowBlank : false,
			typeAhead : true,
			loadMask : true,
			triggerAction : 'all',
			mode : "local",
			store : new Ext.data.SimpleStore({
				fields : [ 'value', 'display' ],
				data : [ [ 'activo', 'Activo' ], [ 'inactivo', 'Inactivo' ] ]
			}),
			valueField : 'value',
			displayField : 'activo',
			align : 'left',
			lazyRender : true,
			forceSelection : false,
			width : 250
		},
		//error?
		tipo : 'ComboBox',
		defecto:'activo',
		form : true,
		save_as : 'txt_estado'
	}*/
	];
	
	var layout_unidad_constructiva_arb = new DocsLayoutArb(idContenedor);
	layout_unidad_constructiva_arb.init(config);
	// Se hereda la clase vista Arbol
	this.pagina = PaginaArb;
	this.pagina(paramConfig, Atributos, layout_unidad_constructiva_arb, idContenedor,DatosNodo, DatosDefecto);
	
	// funciones heredadas
	var cm_getSelectionModel = this.getSm;
	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	var cm_ocultarFormulario = this.ocultarFormulario;
	var cm_btnActualizar = this.btnActualizar;
	var cm_EnableSelect = this.EnableSelect;
	
	var cm_btnEdit = this.btnEdit;
	var cm_mostrarComponente=this.mostrarComponente;
	var cm_ocultarComponente=this.ocultarComponente;
	var btnNewRaiz=this.btnNewRaiz;
	var cm_getBoton=this.getBoton;
	var btnEliminar=this.btnEliminar;
	

	
	// -------------- DEFINICION DE FUNCIONES PROPIAS --------------//

	this.EnableSelect = function(selObject, currentNode, lastNode) 
	{
		cm_EnableSelect(selObject, currentNode, lastNode);
		_CP.getPagina(layout_unidad_constructiva_arb.getIdContentHijo()).pagina.reload(currentNode.attributes);
		_CP.getPagina(layout_unidad_constructiva_arb.getIdContentHijo()).pagina.desbloquearMenu();
		
		//añadido 21-11-2014
		
		/*var valorNodo = currentNode.attributes.id_unidad_constructiva_fk;
		//var botonClasificacion = CM_getBoton('clasificacion-'+ idContenedor);
	
		//alert(nodoSeleccionado.attributes.id_unidad_constructiva_fk);
		if(valorNodo == '' || valorNodo == null || valorNodo == undefined)
			cm_getBoton('clasificacion-'+ idContenedor).disable();
		else if(valorNodo >= 0)
		{	
			cm_getBoton('clasificacion-'+ idContenedor).enable();
		}*/
	};
	
	this.btnNew = function() 
	{
		var selectedNode = cm_getSelectionModel().getSelectedNode();
		if (selectedNode == null || selectedNode == undefined) 
		{
			cm_btnNew();
		}
		else 
		{
			cm_btnNew();
			cm_getComponente('id_unidad_constructiva_fk').setValue(
					selectedNode.attributes.id_unidad_constructiva);
		}
		cm_mostrarComponente(cm_getComponente('orden'));
	}
	this.btnEliminar=function()
	{
		btnEliminar();
		cm_btnActualizar();
	};
	this.btnEdit=function()
	{
		cm_btnEdit();
		var selectedNode = cm_getSelectionModel().getSelectedNode();
		
		if( selectedNode.attributes.id_unidad_constructiva_fk == '' || selectedNode.attributes.id_unidad_constructiva_fk == undefined  )
		{
			cm_getComponente('orden').allowBlank=true;
			cm_ocultarComponente(cm_getComponente('orden'));
		}
		else
		{
			cm_mostrarComponente(cm_getComponente('orden'));
		}	
	}
	
	this.btnNewRaiz = function()
	{
		btnNewRaiz();
		cm_ocultarComponente(cm_getComponente('orden'));
	}
	
	this.guardarSuccess = function(httpResponse) {
		Ext.MessageBox.hide();
		cm_ocultarFormulario();
		if (httpResponse.argument.nodo == null) {
			cm_btnActualizar();
		} else if (httpResponse.argument.proc == "add") {
			httpResponse.argument.nodo.reload();
		} else if (httpResponse.argument.proc == "upd") {
			httpResponse.argument.nodo.parentNode.reload();
		} else if (httpResponse.argument.proc == "del") {
			httpResponse.argument.nodo.parentNode.reload();
		}
	} 
	 
	//DEFINICION DE LA BARRA DE MENU
	var paramMenu = {
			actualizar : {
				crear : true,
				separador : true
			},
			nuevoRaiz : {
				crear : true,
				separador : false,
				tip : 'Nueva Clasificacion Raiz',
				img : 'org_add.png'
			},
			nuevo : {
				crear : true,
				separador : true,
				tip : 'Nuevo',
				img : 'org_uni_add.png'
			},
			editar : {
				crear : true,
				separador : false,
				tip : 'Editar',
				img : 'org_edit.png'
			},
			eliminar : {
				crear : true,
				separador : false,
				tip : 'Eliminar', 
				img : 'org_uni_del.png'
			}
		};
	
	var paramFunciones = {
			Basicas : {
				url : direccion
						+ '../../../control/unidad_constructiva/ActionGuardarUnidadConstructivaArb.php',
				add_success : this.guardarSuccess,
				edit : this.btnEdit
			},
			Formulario : {
				height : 415,
				width : 480,
				minWidth : 150,
				minHeight : 200,
				closable : true,
				titulo : 'Unidad Constructiva'
			}, 
			Listar : {
				url : direccion
						+ '../../../control/unidad_constructiva/ActionListarUnidadConstructivaArb.php',
				baseParams : {},
				clearOnLoad : true,
				enableDD : false
			},
			Eliminar : {
				url : direccion
						+ "../../../control/unidad_constructiva/ActionEliminarUnidadConstructivaArb.php"
			}
		};
	 
	function btnClasificacion()
	{
		var selectedNode = cm_getSelectionModel().getSelectedNode();
		var selected=selectedNode.attributes.id_unidad_constructiva;
		
		if(selected != null && selected != undefined)//Verifica si hay filas seleccionadas
		{ 
			var data = "m_id_unidad_constructiva=" + selected;
			var ParamVentana={Ventana:{width:'70%',height:'80%'}}
			layout_det_unidad_constructiva.loadWindows(direccion+'../../../../sis_almain/vista/clasificacion_arb/clasificacion_arb_uc.php?'+data,'Clasificacion Items',ParamVentana)
			
			//Docs.loadTab('../caracteristicas/caracteristicas_det.php?'+data, "Caracterï¿½sticas por SubTipo ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe tener seleccionado  un nodo del arbol superior.');
		}
	}
	// Para manejo de eventos
	function iniciarEventosFormularios() 
	{
	}
	this.getLayout = function() {
		return layout_unidad_constructiva_arb.getLayout()
	};
	
	// Inicio de los componentes de la vista.
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.Init();
	this.iniciaFormulario();
	var cm_getBoton=this.getBoton;
	
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnClasificacion,true,'clasificacion','Clasificacion Items');
	//cm_getBoton('clasificacion-'+ idContenedor).disable();
	
	
	iniciarEventosFormularios();
	
	var treeLoader = this.getLoader();
	
	treeLoader.on("beforeload", function(treeL, node, a) {
		treeL.baseParams.tipo_nodo = node.attributes.tipo_nodo;
		treeL.baseParams.id_nodo = node.attributes.id;
		treeL.baseParams.id_unidad_constructiva = node.attributes.id_unidad_constructiva;
		treeL.baseParams.id_unidad_constructiva_fk = node.attributes.id_unidad_constructiva_fk;
	}, this);
	
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}