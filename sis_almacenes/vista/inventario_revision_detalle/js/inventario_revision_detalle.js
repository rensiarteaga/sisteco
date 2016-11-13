/**
 * Nombre:		  	    pagina_inventario_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-31 16:33:20
 */
function pagina_inventario_revision_detalle(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	var vectorAtributos=new Array;
	var ds,combo_supergrupo,combo_grupo,combo_subgrupo,combo_id1,combo_id2,combo_id3,combo_item,txt_nuevo,txt_usado,txt_total;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
		//  DATA STORE //
		ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/inventario_det/ActionListarInventarioDet_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_inventario_det',
		totalRecords: 'TotalCount'}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_inventario_det',
		{name: 'fecha_conteo',type:'date',dateFormat:'Y-m-d'},
		'id_inventario',
		'estado_item',
		'id_item',
		'desc_item',
		'id_inventario',
		'desc_inventario',
		'desc_supergrupo',
		'desc_grupo',
		'desc_subgrupo',
		'desc_id1',
		'desc_id2',
		'desc_id3',
		'desc_unidad_medida_base',
		'nuevo',
		'usado',
		'total',
		'cantidad_contada_nuevo',
		'cantidad_contada_usado',
		'cantidad_contada_total'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_inventario:maestro.id_inventario
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
 	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Inventario',maestro.id_inventario],['Tipo de Inventario',maestro.tipo_inventario],['Observaciones',maestro.observaciones]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_supergrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre'])});
	ds_grupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre'])});
	ds_subgrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupo.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre'])});
	ds_id1=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/id1/ActionListarId1.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id: 'id_id1',totalRecords:'TotalCount'},['id_id1','nombre'])});
	ds_id2=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id2/ActionListarId2.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre'])});
	ds_id3=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id3/ActionListarId3.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre'])});
	ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/item/ActionListarItem.php?origen=filtro'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','nombre'])});
	//FUNCIONES RENDER
	        function renderId3(value, p, record){return String.format('{0}', record.data['desc_id3']);}
	        function renderId2(value, p, record){return String.format('{0}', record.data['desc_id2']);}
	        function renderId1(value, p, record){return String.format('{0}', record.data['desc_id1']);}
	        function renderSubgrupo(value, p, record){return String.format('{0}', record.data['desc_subgrupo']);}
	        function renderGrupo(value, p, record){return String.format('{0}', record.data['desc_grupo']);}
	        function renderSupergrupo(value, p, record){return String.format('{0}', record.data['desc_supergrupo']);}
            function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	//function render_id_responsable_almacen(value, p, record){return String.format('{0}', record.data['desc_responsable_almacen']);};
    // hidden id_inventario_det
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_inventario_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_inventario_det'
	};
	// txt id_inventario
	vectorAtributos[1]={
		validacion:{
			name:'id_inventario',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_inventario,
		save_as:'txt_id_inventario'
	};
	filterCols_super_grupo=new Array();
	filterValues_super_grupo=new Array();
	filterCols_super_grupo[0]='estado_registro';
	filterValues_super_grupo[0]='activo';
    vectorAtributos[2]={
		validacion:{
			fieldLabel: 'Super Grupo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Super Grupo...',
			name: 'id_supergrupo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_supergrupo', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_supergrupo,
			valueField: 'id_supergrupo',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			filterCols:filterCols_super_grupo,
			filterValues:filterValues_super_grupo,
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderSupergrupo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'supgru.nombre',
		save_as:'hidden_id_supergrupo'
	};
	filterCols_grupo=new Array();
	filterValues_grupo=new Array();
	filterCols_grupo[0]='supgru.id_supergrupo';
	filterValues_grupo[0]='%';
	filterCols_grupo[1]='g.estado_registro';
	filterValues_grupo[1]='activo';
	////////// hidden id_grupo //////
		vectorAtributos[3]={
		validacion:{
			fieldLabel: 'Grupo',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Grupo...',
			name: 'id_grupo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_grupo', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_grupo,
			valueField: 'id_grupo',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			filterCols:filterCols_grupo,
			filterValues:filterValues_grupo,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderGrupo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'gru.nombre',
		save_as:'hidden_id_grupo'
	};
 	filterCols_subgrupo=new Array();
	filterValues_subgrupo=new Array();
	filterCols_subgrupo[0]='supgru.id_supergrupo';
	filterValues_subgrupo[0]='%';
	filterCols_subgrupo[1]='g.id_grupo';
	filterValues_subgrupo[1]='%';
	filterCols_subgrupo[2]='sub.estado_registro';
	filterValues_subgrupo[2]='activo';
	/////////// hidden id_subgrupo //////
	vectorAtributos[4]={
		validacion:{
			fieldLabel: 'Sub Grupo',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Sub Grupo...',
			name: 'id_subgrupo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_subgrupo', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_subgrupo,
			valueField: 'id_subgrupo',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			filterCols:filterCols_subgrupo,
			filterValues:filterValues_subgrupo,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderSubgrupo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'sub.nombre',
		save_as:'hidden_id_subgrupo'
	};
	filterCols_id1=new Array();
	filterValues_id1=new Array();
	filterCols_id1[0]='supgru.id_supergrupo';
	filterValues_id1[0]='%';
	filterCols_id1[1]='g.id_grupo';
	filterValues_id1[1]='%';
	filterCols_id1[2]='sub.id_subgrupo';
	filterValues_id1[2]='%';
	filterCols_id1[3]='id1.estado_registro';
	filterValues_id1[3]='activo';
	/////////// hidden id_id1 //////
	vectorAtributos[5]={
		validacion:{
			fieldLabel: 'Identificador 1',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Identificador 1...',
			name: 'id_id1',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_id1', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_id1,
			valueField: 'id_id1',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			filterCols:filterCols_id1,
			filterValues:filterValues_id1,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderId1,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id1.nombre',
		save_as:'hidden_id_id1'
	};
	filterCols_id2=new Array();
	filterValues_id2=new Array();
	filterCols_id2[0]='supgru.id_supergrupo';
	filterValues_id2[0]='%';
	filterCols_id2[1]='g.id_grupo';
	filterValues_id2[1]='%';
	filterCols_id2[2]='sub.id_subgrupo';
	filterValues_id2[2]='%';
	filterCols_id2[3]='id1.id_id1';
	filterValues_id2[3]='%';
	filterCols_id2[4]='id2.estado_registro';
	filterValues_id2[4]='activo';
	/////////// hidden id_id2 //////
		vectorAtributos[6]={
		validacion:{
			fieldLabel: 'Identificador 2',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Identificador 2...',
			name: 'id_id2',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_id2', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_id2,
			valueField: 'id_id2',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			filterCols:filterCols_id2,
			filterValues:filterValues_id2,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderId2,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id2.nombre',
		save_as:'hidden_id_id2'
	};
	filterCols_id3=new Array();
	filterValues_id3=new Array();
	filterCols_id3[0]='supgru.id_supergrupo';
	filterValues_id3[0]='%';
	filterCols_id3[1]='g.id_grupo';
	filterValues_id3[1]='%';
	filterCols_id3[2]='sub.id_subgrupo';
	filterValues_id3[2]='%';
	filterCols_id3[3]='id1.id_id1';
	filterValues_id3[3]='%';
	filterCols_id3[4]='id2.id_id2';
	filterValues_id3[4]='%';
	filterCols_id3[5]='id3.estado_registro';
	filterValues_id3[5]='activo';
	/////////// hidden id_id3 //////
	vectorAtributos[7]={
		validacion:{
			fieldLabel: 'Identificador 3',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Identificador 3...',
			name: 'id_id3',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_id3', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_id3,
			valueField: 'id_id3',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			filterCols:filterCols_id3,
			filterValues:filterValues_id3,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderId3,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id3.nombre',
		save_as:'hidden_id_id3'
	};
	filterCols_item=new Array();
	filterValues_item=new Array();
	filterCols_item[0]='supgru.id_supergrupo';
	filterValues_item[0]='%';
	filterCols_item[1]='g.id_grupo';
	filterValues_item[1]='%';
	filterCols_item[2]='sub.id_subgrupo';
	filterValues_item[2]='%';
	filterCols_item[3]='id1.id_id1';
	filterValues_item[3]='%';
	filterCols_item[4]='id2.id_id2';
	filterValues_item[4]='%';
	filterCols_item[5]='id3.id_id3';
	filterValues_item[5]='%';
	filterCols_item[6]='ite.estado_registro';
	filterValues_item[6]='activo';
	// txt id_item
	vectorAtributos[8]={
			validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank: true,			
			emptyText:'Id Item...',
			desc: 'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item,
			valueField: 'id_item',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ITEM.codigo#ITEM.nombre#ITEM.descripcion',
			filterCols:filterCols_item,
			filterValues:filterValues_item,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			renderer:render_id_item,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ITEM.nombre',
		defecto: '',
		save_as:'txt_id_item'
	};
	 // txt unidad_medida
	vectorAtributos[9]={
		validacion:{
			name:'desc_unidad_medida_base',
			fieldLabel:'Unidad de Medida',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120
		},
		tipo: 'TextField',
		filtro_0:true,
			filterColValue:'UMB.nombre',
		save_as:'txt_nombre'
	};
	/// txt cantidad_nuevo
	vectorAtributos[10]={
		validacion:{
			name:'nuevo',
			fieldLabel:'Cantidad de Nuevos',
			allowBlank:true,
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
			width_grid:130
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'INVDET.nuevo',
		save_as:'txt_nuevo'
	};
	/// txt cantidad_usado
	vectorAtributos[11]={
		validacion:{
			name:'usado',
			fieldLabel:'Cantidad de Usados',
			allowBlank:true,
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
			width_grid:130
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'INVDET.usado',
		save_as:'txt_usado'
	};
	 /// txt cantidad_total
	vectorAtributos[12]={
		validacion:{
			name:'total',
			fieldLabel:'Cantidad Total',
			allowBlank:true,
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
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'INVDET.total',
		save_as:'txt_total'
	};
	 /// txt cantidad_nuevo
		vectorAtributos[13]={
		validacion:{
			name:'cantidad_contada_nuevo',
			fieldLabel:'Contados Nuevos',
			allowBlank:true,
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
			renderer: cantidad_contada_nuevo,
			width_grid:130
		},
		tipo: 'NumberField',
		filtro_0:true,
		save_as:'txt_cantidad_contada_nuevo'
	};
 	/// txt cantidad_usado
		vectorAtributos[14]={
		validacion:{
			name:'cantidad_contada_usado',
			fieldLabel:'Contados Usados',
			allowBlank:true,
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
			renderer: cantidad_contada_usado,
			width_grid:130
		},
		tipo: 'NumberField',
		filtro_0:true,
		save_as:'txt_cantidad_contada_usado'
	};
	/// txt cantidad_total
	vectorAtributos[15]={
		validacion:{
			name:'cantidad_contada_total',
			fieldLabel:'Total Contados',
			allowBlank:true,
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
			renderer: cantidad_contada_total,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		save_as:'txt_total'
	};
	/// txt fecha_conteo
	vectorAtributos[16]={
		validacion:{
			name:'fecha_conteo',
			fieldLabel:'Fecha del Conteo',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INVDET.fecha_conteo',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_conteo'
	};
	 	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Inventario en Revision (Maestro)',
		titulo_detalle:'Detalle de Inventarios Revisados (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_inventario_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_inventario_det.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_inventario_det,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/inventario_det/ActionEliminarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
	Save:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioResultadoDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
	ConfirmSave:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioResultadoDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Inventario Detalle'}
	}	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_inventario=datos.m_id_inventario;
		maestro.tipo_inventario=datos.m_tipo_inventario;
		maestro.observaciones= datos.m_observaciones;		
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_inventario:maestro.id_inventario
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Inventario',maestro.id_inventario],['Tipo Inventario',maestro.tipo_inventario],['Observaciones',maestro.observaciones]]);
		vectorAtributos[1].defecto=maestro.id_inventario;
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/inventario_det/ActionEliminarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
			Save:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioResultadoDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
			ConfirmSave:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioResultadoDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo: 'Inventario Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
	function iniciarEventosFormularios(){
		combo_supergrupo = ClaseMadre_getComponente('id_supergrupo');
		combo_grupo = ClaseMadre_getComponente('id_grupo');
		combo_subgrupo = ClaseMadre_getComponente('id_subgrupo');
		combo_id1 = ClaseMadre_getComponente('id_id1');
		combo_id2 = ClaseMadre_getComponente('id_id2');
		combo_id3 = ClaseMadre_getComponente('id_id3');
		combo_item = ClaseMadre_getComponente('id_item');
		txt_nuevo = ClaseMadre_getComponente('nuevo');
		txt_usado = ClaseMadre_getComponente('usado');
		txt_total = ClaseMadre_getComponente('total');
	  var onSuperGrupoSelect = function(e) {
			var id = combo_supergrupo.getValue()
			combo_grupo.filterValues[0] =  id;
			combo_grupo.modificado = true;
			combo_subgrupo.filterValues[0] =  id;
			combo_subgrupo.modificado = true;
			combo_id1.filterValues[0] =  id;
			combo_id1.modificado = true;
			combo_id2.filterValues[0] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[0] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[0] =  id;
			combo_item.modificado = true
			};
		var onGrupoSelect = function(e) {
			var id = combo_grupo.getValue()
			combo_subgrupo.filterValues[1] =  id;
			combo_subgrupo.modificado = true;
			combo_id1.filterValues[1] =  id;
			combo_id1.modificado = true;
			combo_id2.filterValues[1] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[1] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[1] =  id;
			combo_item.modificado = true
			};
		var onSubGrupoSelect = function(e) {
			var id = combo_subgrupo.getValue()
			combo_id1.filterValues[2] =  id;
			combo_id1.modificado = true;
			combo_id2.filterValues[2] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[2] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[2] =  id;
			combo_item.modificado = true
			};
		var onId1Select = function(e) {
			var id = combo_id1.getValue()
			combo_id2.filterValues[3] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[3] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[3] =  id;
			combo_item.modificado = true;
			};
		var onId2Select = function(e) {
			var id = combo_id2.getValue()
			combo_id3.filterValues[4] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[4] =  id;
			combo_item.modificado = true
			};
		var onId3Select = function(e) {
			var id = combo_id3.getValue()
			combo_item.filterValues[5] =  id;
			combo_item.modificado = true
			};
		combo_supergrupo.on('select', onSuperGrupoSelect);
		combo_supergrupo.on('change', onSuperGrupoSelect);
		combo_grupo.on('select', onGrupoSelect);
		combo_grupo.on('change', onGrupoSelect);
		combo_subgrupo.on('select', onSubGrupoSelect);
		combo_subgrupo.on('change', onSubGrupoSelect);
		combo_id1.on('select', onId1Select);
		combo_id1.on('change', onId1Select);
		combo_id2.on('select', onId2Select);
		combo_id2.on('change', onId2Select);
		combo_id3.on('select', onId3Select);
		combo_id3.on('change', onId3Select)
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_inventario_det.getLayout()
	};
////Inportante 	
	function cantidad_contada_nuevo(val,a,b){
	   var txt_nuevo = ClaseMadre_getComponente('nuevo');	
	   var nuevo= b.data['nuevo']//txt_nuevo.getValue();
	   	if(val != nuevo)
		  { return '<span style="color:red;">' + val + '</span>'}
            return val
        }
    function cantidad_contada_usado(val,a,b){
	   var txt_usado = ClaseMadre_getComponente('usado');	
	   var usado= b.data['usado']
	    	if(val != usado)
		  { return '<span style="color:red;">' + val + '</span>'}
            return val
        } 
       function cantidad_contada_total(val,a,b){
	   var txt_total = ClaseMadre_getComponente('total');	
	   var total= b.data['total']
	    	if(val != total)
		  { return '<span style="color:red;">' + val + '</span>'}
            return val
        } 
    //para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]	}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_inventario_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}