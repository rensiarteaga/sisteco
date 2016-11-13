/**
 * 	Nombre: detalle_unidad_constructiva.js
 *  Proposito: pagina objeto principal 
 *  Autor:  Unknow
 *  
 */
function PaginaDetalleUnidadConstructiva(idContenedor, direccion, paramConfig) 
{
	var sm;
	var vectorAtributos = new Array();
	var ds;
	var layout_item;
	var maestroData;
	//var maestro;
	
	ds = new Ext.data.Store({
		proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/detalle_unidad_constructiva/ActionListarDetalleUnidadConstructiva.php'
		}),
		reader : new Ext.data.XmlReader({
			record : 'ROWS',
			id : 'id_detalle_unidad_constructiva',
			totalRecords : 'TotalCount'
		}, [ 'id_detalle_unidad_constructiva', 'id_unidad_constructiva', 'desc_unidad_constructiva',
				'id_item', 'desc_item', 'id_unidad_medida', 'nombre_unidad',
				'cantidad', 'descripcion','estado_registro','orden' 
				, 'usuario_reg',
				{
					name : 'fecha_reg',
					type : 'date',
					dateFormat : 'd-m-Y'
				} ]),
		remoteSort : true
	});

		var ds_item= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords: 'TotalCount'},['id_item','nombre','codigo','descripcion','nombre_medida'])
		});
		function render_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
		var tpl_item=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	
	
	// PARÃ�METROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = [
			{
				validacion : {
					labelSeparator : '',
					name : 'id_detalle_unidad_constructiva',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_detalle_unidad_constructiva'
			},
			{
				validacion : {
					labelSeparator : '',
					name : 'id_unidad_constructiva',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_unidad_constructiva'
			},
			{
				validacion : 
				{
					name :'orden',
					fieldLabel : 'Nro.(despues de)',
					allowBlank : false,
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
				save_as : 'txt_orden_detuc'
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
						minChars : 1, ///caracteres mÃ¯Â¿Â½nimos requeridos para iniciar la busqueda
						triggerAction: 'all',
						renderer:render_item,
						grid_visible:true, // se muestra en el grid
						grid_editable:false, //es editable en el grid,
						width_grid:220, // ancho de columna en el gris
						width:250,
						tpl: tpl_item
			},
			tipo:'ComboBox',
			filtro_0:true,
			form: true,
			filterColValue:'it.codigo#it.nombre',
			save_as:'txt_id_item'	
			},
			{
				validacion : {
					name : 'nombre_unidad',
					fieldLabel : 'Unidad Medida',
					grid_visible : true, 
					grid_editable : false,
					width_grid : 50
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'uni.nombre',
				form : false
			},
			{
				validacion : {
					name :'cantidad',
					fieldLabel : 'Cantidad',
					allowBlank : true,
					allowNegative: false,
					allowDecimals: true,
					minValue : '0',
					//decimalPrecision : 2,
					align : 'center',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width:250
				},
				tipo : 'NumberField',
				filtro_0 : false,
				filterColValue : 'detunic.cantidad',
				form : true,
				save_as : 'txt_cantidad'
			},	
			{
				validacion: {
					name: 'descripcion',
					fieldLabel: 'Descripcion',
					allowBlank: false,
					maxLength:100,
					minLength:0,
					selectOnFocus:true,
					//vtype:"alphaLatino",
					vtype:"texto",
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:200, // ancho de columna en el grid
					disabled: false,
					//grid_indice:4,
					width:250
				},
				tipo: 'TextArea',
				form:true,
				save_as : 'txt_descripcion'
			},
			{
					validacion : {
						name : 'estado_registro',
						fieldLabel : 'Estado Registro',
						align : 'center',
						grid_visible : true,
						grid_editable : false,
						width_grid : 80
					},
					tipo : 'TextField',
					filtro_0 : false,
					//filterColValue : 'dem.usuario_reg',
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
		}];
	
	// ---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro : 'item',
		grid_maestro : 'grid-' + idContenedor
	};
	layout_det_unidad_constructiva = new DocsLayoutMaestro(idContenedor);
	layout_det_unidad_constructiva.init(config);

	this.pagina = Pagina;
	this.pagina(paramConfig, vectorAtributos, ds, layout_det_unidad_constructiva, idContenedor);

	var cm_btnNew = this.btnNew;
	var cm_getComponente = this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	
	this.reload = function(maestro) {
		maestroData = maestro;
		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				id_unidad_constructiva : maestro.id_unidad_constructiva
			}
		}; 
		//bloqueo de botones, cuando se selecciona un nodo
		/*if(maestroData.id_unidad_constructiva_fk=='' || maestroData.id_unidad_constructiva_fk==null || maestroData.id_unidad_constructiva_fk==undefined)
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
		}*/
		if(maestroData.tipo_rama == 'padre' || maestroData.tipo_rama == 'nodo')
		{
			//cm_getBoton("nuevo-" + idContenedor).hide();
			cm_getBoton("editar-" + idContenedor).hide();
			cm_getBoton("eliminar-" + idContenedor).hide();
			cm_getBoton("clasificacion-" + idContenedor).hide();
		}
		else
		{
			//cm_getBoton("nuevo-" + idContenedor).show();
			cm_getBoton("editar-" + idContenedor).show();
			cm_getBoton("eliminar-" + idContenedor).show();	
			cm_getBoton("clasificacion-" + idContenedor).show();
		}
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);
	};

	this.btnNew = function(event, target) {
		cm_btnNew(event, target);
		cm_getComponente("id_unidad_constructiva").setValue(maestroData.id_unidad_constructiva);
	}

	this.onResizePrimario = function() {
		layout_item.getLayout().layout();
	}
	// ----------- DEFINICIÃ“N DE LA BARRA DE MENÃš ----------- //
	var paramMenu = {
//		nuevo : {
//			crear : true,
//			separador : true
//		},
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

	function formatDate(value) {return value ? value.dateFormat('d/m/Y') : '';};

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
		
		return String.format('{0}', bajo_responsabilidad);
	}

	// ---------------------- DEFINICIÃ“N DE FUNCIONES -------------------------
	
	
	var paramFunciones = {
		btnEliminar : {
			url : direccion + "../../../control/detalle_unidad_constructiva/ActionEliminarDetalleUnidadConstructiva.php"
		},
		Save : {
			url : direccion + "../../../control/detalle_unidad_constructiva/ActionGuardarDetalleUnidadConstructiva.php"
		},
		ConfirmSave : {
			url : direccion + "../../../control/detalle_unidad_constructiva/ActionGuardarDetalleUnidadConstructiva.php"
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
	
	
	function btnClasificacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(maestroData.id_unidad_constructiva != '' || maestroData.id_unidad_constructiva != null)
		{
			var data = "m_id_unidad_constructiva=" +maestroData.id_unidad_constructiva;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_det_unidad_constructiva.loadWindows(direccion+'../../../../sis_almain/vista/clasificacion_arb/clasificacion_arb_uc.php?'+data,'Clasificacion Items',ParamVentana)
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe tener seleccionado un nodo del arbol.');
		}
		/*
		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{ 
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "m_id_unidad_constructiva=" + SelectionsRecord.data.id_unidad_constructiva;
			//data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;

			var ParamVentana={Ventana:{width:'70%',height:'80%'}}
			layout_det_unidad_constructiva.loadWindows(direccion+'../../../../sis_almain/vista/clasificacion_arb/clasificacion_arb_uc.php?'+data,'Clasificacion Items',ParamVentana)
			
			//Docs.loadTab('../caracteristicas/caracteristicas_det.php?'+data, "Caracterï¿½sticas por SubTipo ["+ SelectionsRecord.data.codigo +"]");
		}
		else
		{	
			Ext.MessageBox.alert('Estado', 'Debe tener seleccionado  un item.');
		}*/
	}
	
	// -------------- FIN DEFINICIÃ“N DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	//	Botones
	this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'',btnClasificacion,true,'clasificacion','Adicionar Items');
	
	
	this.iniciaFormulario();
	//this.bloquearMenu();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	
	cm_BloquearMenu();
	layout_det_unidad_constructiva.getLayout().addListener('layout', this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}