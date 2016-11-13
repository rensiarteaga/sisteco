/**
 * Nombre:		  	    pagina_salida_detalle_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:09:50
 */
function pagina_salida_consolidada_detalle_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida_detalle/ActionListarSalidaDetalle_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_salida_detalle',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_salida_detalle',
		'costo',
		'costo_unitario',
		'precio_unitario',
		'cant_solicitada',
		'cant_entregada',
		'cant_consolidada',
		{name: 'fecha_solicitada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_entregada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_consolidada',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'id_salida',
		'desc_salida',
		'desc_unidad_constructiva',
		'id_unidad_constructiva',
		'emergencia'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_salida:maestro.id_salida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Salida',maestro.id_salida],['Estado',maestro.estado_reg]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_item',
			totalRecords: 'TotalCount'
		}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','costo_almacen','stock_min','stock_total','observaciones','nivel_convertido','estado_item','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
	});
    ds_unidad_constructiva=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_unidad_constructiva',
			totalRecords: 'TotalCount'
		}, ['id_unidad_constructiva','codigo','direccion','fecha_reg','id_tipo_unidad_constructiva','id_subactividad'])
	});
	//FUNCIONES RENDER	
			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item'])}
			function render_id_salida(value, p, record){return String.format('{0}', record.data['desc_salida'])};
	        function render_id_unidad_constructiva(value, p, record){return String.format('{0}', record.data['desc_unidad_constructiva'])};
	/////////////////////////
	// Definición de datos //
	/////////////////////////	
		// hidden id_salida_detalle
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_salida_detalle',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_salida_detalle'
	};
// txt cant_solicitada
	vectorAtributos[1]={
		validacion:{
			name:'cant_solicitada',
			fieldLabel:'Cantidad Solicitada',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			align:'right',
			width:'45%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:110
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'SALDET.cant_solicitada',
		save_as:'txt_cant_solicitada'
	};
	// txt cant_solicitada
	vectorAtributos[2]= {
		validacion:{
			name:'cant_entregada',
			fieldLabel:'Cantidad Entregada',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'SALDET.cant_entregada',
		save_as:'txt_cant_entregada'
	};
	// txt cant_devuelta
	vectorAtributos[3]= {
		validacion:{
			name:'cant_devuelta',
			fieldLabel:'Cantidad Devuelta',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:false,
			grid_editable:false,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:false,
		save_as:'txt_cant_devuelta'
	};
	// txt cant_consolidada
	vectorAtributos[4]= {
		validacion:{
			name:'cant_consolidada',
			fieldLabel:'Cantidad Consolidada',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			grid_indice:5,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'SALDET.cant_consolidada',
		save_as:'txt_cant_consolidada'
	};
// txt id_item
	vectorAtributos[5]= {
			validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank:true,			
			emptyText:'Item...',
			desc: 'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item,
			valueField: 'id_item',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ITEM.codigo#ITEM.nombre#ITEM.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_item,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:120 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ITEM.codigo',
		defecto: '',
		save_as:'txt_id_item'
	};
// txt id_salida
	vectorAtributos[6]= {
		validacion:{
			name:'id_salida',
			fieldLabel:'Pedido',
			allowBlank:true,			
			desc: 'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			queryParam: 'filterValue_0',
			filterCol:'ITEM.codigo#ITEM.nombre#ITEM.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_salida,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:500 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:true,
		defecto:maestro.id_salida,
		save_as:'txt_id_salida'
	};
// txt costo
	vectorAtributos[7]= {
		validacion:{
			name:'costo',
			fieldLabel:'Costo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.costo',
		save_as:'txt_costo'
	};
// txt costo_unitario
	vectorAtributos[8]= {
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Costo Unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.costo_unitario',
		save_as:'txt_costo_unitario'
	};
// txt precio_unitario
	vectorAtributos[9]= {
		validacion:{
			name:'precio_unitario',
			fieldLabel:'Precio Unitario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SALDET.precio_unitario',
		save_as:'txt_precio_unitario'
	};
	// txt fecha_solicitada
	vectorAtributos[10]={
		validacion:{
			name:'fecha_solicitada',
			fieldLabel:'Fecha Solicitada',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_solicitada',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_solicitada'
	};
// txt fecha_entregada
	vectorAtributos[11]={
		validacion:{
			name:'fecha_entregada',
			fieldLabel:'Fecha Entregada',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer:formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_entregado',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_entregada'
	};
// txt fecha_consolidada
	vectorAtributos[12]={
		validacion:{
			name:'fecha_consolidada',
			fieldLabel:'Fecha Consolidada',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer:formatDate,
			width_grid:100,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_consolidada',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_consolidada'
	};
// txt fecha_reg
	vectorAtributos[13]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer:formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SALDET.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// txt id_unidad_constructiva
	vectorAtributos[14]= {
			validacion:{
			name:'id_unidad_constructiva',
			fieldLabel:'Unidad Constructiva',
			allowBlank:true,			
			emptyText:'Unidad Constructiva...',
			desc:'desc_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_constructiva,
			valueField:'id_unidad_constructiva',
			displayField:'codigo',
			queryParam:'filterValue_0',
			filterCol:'UNICONS.codigo#UNICONS.direccion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_constructiva,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'UNICONS.codigo',
		defecto: '',
		save_as:'txt_id_unidad_constructiva'
	};
	vectorAtributos[15]={
			validacion:{
				name:'emergencia',
				fieldLabel:'Emergencia',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:true,
				align:'center',
				width_grid:100
			},
			tipo:'TextField',
			defecto:'Si',
			filterColValue:'SALIDA.emergencia',
			save_as:'txt_emergencia',
			id_grupo:0
		};
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Consolidar Pedido de Material (Maestro)',
		titulo_detalle:'Detalles de Consolidación de Material (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_salida_consolidada_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_salida_consolidada_detalle.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_consolidada_detalle,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	//var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	//var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	//var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	//var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	//var ClaseMadre_btnActualizar = this.btnActualizar;
	var Cm_Destroy=this.Destroy;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
	Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalleConsolidada.php',parametros:'&m_id_salida='+maestro.id_salida},
	ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalleConsolidada.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Detalle Consolidación de Salida'}
	}
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_salida=datos.m_id_salida;
		maestro.estado_reg=datos.m_estado_reg;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_salida:maestro.id_salida
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Id Salida',maestro.id_salida],['Estado',maestro.estado_reg]]);
		vectorAtributos[6].defecto=maestro.id_salida;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Salida Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	  function btn_cantidad_devuelta(){
	   	CM_ocultarTodosComponente();
	  	CM_mostrarComponente(componentes[0]);
	  	CM_mostrarComponente(componentes[1]);
	  	CM_mostrarComponente(componentes[2]);
	  	CM_mostrarComponente(componentes[3]);
	  	componentes[0].disable();
	  	componentes[1].disable();
	  	componentes[3].disable();
	  	componentes[2].setValue(componentes[3].getValue()-componentes[1].getValue());
	  	if(componentes[14].getValue()=='Si'){
	  		componentes[2].disable();
	  		componentes[3].disable()
	  	}else{
	  		componentes[2].enable()
	  	}
	  	CM_mostrarComponente(componentes[1]);
			if(componentes[3].getValue()<=componentes[1].getValue())
			{
				ClaseMadre_btnEdit()
			}
		else{
			Ext.MessageBox.alert('Cantidad a Consolidar', 'La cantidad a consolidar no puede ser mayor a la cantidad entregada')
		}
	  }
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{ 	
	  txt_cant_entregada = ClaseMadre_getComponente('cant_entregada');
	  txt_cant_devuelta = ClaseMadre_getComponente('cant_devuelta');
	  txt_cant_consolidada = ClaseMadre_getComponente('cant_consolidada');
	   function onDevueltoSelect () 
	  {
		  var devuelto=parseInt(txt_cant_devuelta.getValue());
		  var entregado=parseInt(txt_cant_entregada.getValue());
			if(devuelto>entregado)
			{
				Ext.MessageBox.alert('Cantidad a Devolver', 'La cantidad a devolver no puede ser mayor a la cantidad entregada')
			}
			else
			{
				var consolidado = entregado-devuelto;
				txt_cant_consolidada.setValue(consolidado)
			}	
	   }
		 txt_cant_devuelta.on('select', onDevueltoSelect);
		 txt_cant_devuelta.on('change', onDevueltoSelect)
		 txt_cant_consolidada.on('select', onDevueltoSelect);
		 txt_cant_consolidada.on('change', onDevueltoSelect)
	}
	function iniciarPaginaSalidaConsolidadaDetalle()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	} 
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_salida_consolidada_detalle.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.Destroy=function(){delete this.pagina;	Cm_Destroy()};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/pedido_remove.png','',btn_cantidad_devuelta,true,'Devolución de Material','Devolución de Material');
	this.iniciaFormulario();
	iniciarPaginaSalidaConsolidadaDetalle()
	iniciarEventosFormularios();
	layout_salida_consolidada_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}