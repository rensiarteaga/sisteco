/**
 * Nombre:		  	    pagina_salida_detalle_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:09:50
 */
function pagina_salida_finalizada_detalle_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
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
		'cant_solicitada',
		'cant_entregada',
		'cant_consolidada',
		'id_item',
		'desc_item',
		'id_salida',
		'desc_salida'
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
//var dataMaestro=[['Salida',maestro.id_salida],['Estado Registro',maestro.estado_reg]];

	//var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	//dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Id Salida',maestro.id_salida],['Estado',maestro.estado_reg]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

    ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item',
			totalRecords: 'TotalCount'
		}, ['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','costo_almacen','stock_min','stock_total','observaciones','nivel_convertido','estado_item','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo'])
	});

  

	//FUNCIONES RENDER
	
			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item'])}
			function render_id_salida(value, p, record){return String.format('{0}', record.data['desc_salida'])};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_salida_detalle
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_salida_detalle',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_salida_detalle'
	};
	

// txt cant_solicitada
	vectorAtributos[1]= {
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
			grid_visible:true,
			align:'right',
			grid_editable:false,
			grid_indice:3,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
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
			grid_indice:4,
			grid_editable:false,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALDET.cant_entregada',
		save_as:'txt_cant_entregada'
	};
	
	// txt cant_solicitada
	vectorAtributos[3]= {
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
			align:'right',
			grid_visible:true,
			grid_indice:5,
			grid_editable:false,
			width_grid:110
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALDET.cant_consolidada',
		save_as:'txt_cant_consolidada'
	};
	
// txt id_item
	vectorAtributos[4]= {
			validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank:false,			
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
			grid_indice:2,
			grid_visible:true,
			grid_editable:false,
			width_grid:130 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEM.codigo',
		defecto: '',
		save_as:'txt_id_item'
	};
	
// txt id_salida
	vectorAtributos[5]= {
		validacion:{
			name:'id_salida',
			fieldLabel:'Pedido',
			allowBlank:false,			
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
			grid_indice:1,
			grid_editable:false,
			width_grid:300 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_salida,
		save_as:'txt_id_salida'
	};
	
	
		
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Finalizar Salida de Material (Maestro)',
		titulo_detalle:'Detalles de Salida de Material (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_salida_finalizada_detalle = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_salida_finalizada_detalle.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_finalizada_detalle,idContenedor);
	//var getSelectionModel=this.getSelectionModel;
	//var ClaseMadre_getComponente=this.getComponente;
	//var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	//var ClaseMadre_getGrid=this.getGrid;
	//var ClaseMadre_getFormulario=this.getFormulario;
	//var ClaseMadre_conexionFailure=this.conexionFailure;
	//var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	//var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//var CM_mostrarComponente=this.mostrarComponente;
	//var CM_ocultarComponente=this.ocultarComponente;
	//var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	//var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	//var ClaseMadre_btnEdit=this.btnEdit;
	//var ClaseMadre_btnEliminar = this.btnEliminar;
	//var ClaseMadre_btnActualizar = this.btnActualizar;
	
	var Cm_Destroy=this.Destroy;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ

	var paramMenu={actualizar:{crear:true,separador:false}};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
	Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
	ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'salida_detalle'}
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
		vectorAtributos[5].defecto=maestro.id_salida;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/salida_detalle/ActionEliminarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Save:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			ConfirmSave:{url:direccion+'../../../control/salida_detalle/ActionGuardarSalidaDetalle.php',parametros:'&m_id_salida='+maestro.id_salida},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Salida Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
	//para iniciar eventos en el formulario
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_salida_finalizada_detalle.getLayout()
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
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_salida_finalizada_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
	
}