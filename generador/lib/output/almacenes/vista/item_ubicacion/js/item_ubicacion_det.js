/**
 * Nombre:		  	    pagina_item_ubicacion_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-11 16:18:39
 */
function pagina_item_ubicacion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_ubicacion/ActionListarItemUbicacion_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item_ubicacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_item_ubicacion',
		'nivel',
		'descripcion',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'desc_estante',
		'id_estante'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_estante:maestro.id_estante
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
var dataMaestro=[['Id Estante',maestro.id_estante],['Codigo',maestro.codigo],['Estado Registro',maestro.descripcion]];

	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
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
	
			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_item_ubicacion
	//en la posición 0 siempre esta la llave primaria

	var param_id_item_ubicacion = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_item_ubicacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_item_ubicacion'
	};
	vectorAtributos[0] = param_id_item_ubicacion;
// txt nivel
	var param_nivel= {
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEUBI.nivel',
		save_as:'txt_nivel'
	};
	vectorAtributos[1] = param_nivel;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEUBI.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[2] = param_descripcion;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'observaciones',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEUBI.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[3] = param_observaciones;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEUBI.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[4] = param_fecha_reg;
// txt id_item
	var param_id_item= {
			validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank:false,			
			emptyText:'Item...',
			name: 'id_item',     //indica la columna del store principal ds del que proviane el id
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
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ITEM.codigo',
		defecto: '',
		save_as:'txt_id_item'
	};
	vectorAtributos[5] = param_id_item;
// txt id_estante
	var param_id_estante= {
		validacion:{
			name:'id_estante',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_estante,
		save_as:'txt_id_estante'
	};
	vectorAtributos[6] = param_id_estante;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Estantería (Maestro)',
		titulo_detalle:'Ubicación de Items (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_item_ubicacion = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_item_ubicacion.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_item_ubicacion,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;

	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/item_ubicacion/ActionEliminarItemUbicacion.php'},
	Save:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php'},
	ConfirmSave:{url:direccion+'../../../control/item_ubicacion/ActionGuardarItemUbicacion.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,width:480,height:340,minWidth:150,minHeight:200,closable:true,titulo: 'item_ubicacion'}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_item_ubicacion.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_item_ubicacion.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}