/**
* Nombre:		  	    pagina_inventario_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-31 16:33:20
*/
function pagina_inventario_det_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds,combo_supergrupo,combo_grupo,combo_subgrupo,combo_id1,combo_id2,combo_id3,combo_item;
	var elementos=new Array();
	var componentes=new Array();
	var idItem;
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
			]),remoteSort:true
	});
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
	ds_supergrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/supergrupo/ActionListarSuperGrupoAlmacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_supergrupo',totalRecords:'TotalCount'},['id_supergrupo','nombre'])});
	ds_grupo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/grupo/ActionListarGrupoAlmacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_grupo',totalRecords:'TotalCount'},['id_grupo','nombre'])});
	ds_subgrupo=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/subgrupo/ActionListarSubGrupoAlmacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subgrupo',totalRecords:'TotalCount'},['id_subgrupo','nombre'])});
	ds_id1=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/id1/ActionListarId1Almacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id: 'id_id1',totalRecords:'TotalCount'},['id_id1','nombre'])});
	ds_id2=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id2/ActionListarId2Almacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id2',totalRecords:'TotalCount'},['id_id2','nombre'])});
	ds_id3=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/id3/ActionListarId3Almacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_id3',totalRecords:'TotalCount'},['id_id3','nombre'])});
	ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/item/ActionListarItemAlmacen.php?id_almacen='+maestro.id_almacen}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','nombre'])});
   //FUNCIONES RENDER
	function renderId3(value, p, record){return String.format('{0}', record.data['desc_id3']);}
	function renderId2(value, p, record){return String.format('{0}', record.data['desc_id2']);}
	function renderId1(value, p, record){return String.format('{0}', record.data['desc_id1']);}
	function renderSubgrupo(value, p, record){return String.format('{0}', record.data['desc_subgrupo']);}
	function renderGrupo(value, p, record){return String.format('{0}', record.data['desc_grupo']);}
	function renderSupergrupo(value, p, record){return String.format('{0}', record.data['desc_supergrupo']);}
	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	// hidden id_inventario_det
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[8] = {
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
	filterCols_super_grupo[0]='supgru.estado_registro';
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
			filterCol:'supgru.nombre',
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
			width_grid:100, // ancho de columna en el grid
			grid_indice:0
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'supgru.nombre',
		save_as:'hidden_id_supergrupo',
		id_grupo:0
	};
	filterCols_grupo=new Array();
	filterValues_grupo=new Array();
	filterCols_grupo[0]='supgru.id_supergrupo';
	filterValues_grupo[0]='%';
	filterCols_grupo[1]='g.estado_registro';
	filterValues_grupo[1]='activo';
	filterCols_grupo[2]='ALMACE.id_almacen';
	filterValues_grupo[2]=maestro.id_almacen;
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
			filterCol:'g.nombre',
			filterCols:filterCols_grupo,
			filterValues:filterValues_grupo,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderGrupo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			grid_indice:1
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'gru.nombre',
		save_as:'hidden_id_grupo',
		id_grupo:0
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
			filterCol:'sub.nombre',
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
			renderer: renderSubgrupo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			grid_indice:2
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'sub.nombre',
		save_as:'hidden_id_subgrupo',
		id_grupo:0
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
			filterCol:'id1.nombre',
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
			width_grid:100, // ancho de columna en el grid
			grid_indice:3
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id1.nombre',
		save_as:'hidden_id_id1',
		id_grupo:0
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
			filterCol:'id2.nombre',
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
			width_grid:100,
			grid_indice:4 // ancho de columna en el grid
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id2.nombre',
		save_as:'hidden_id_id2',
		id_grupo:0
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
			filterCol:'id3.nombre',
			filterCols:filterCols_id3,
			filterValues:filterValues_id3,
			typeAhead: true,
			forceSelection : false,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderId3,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:100, // ancho de columna en el grid
			grid_indice:5		
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'id3.nombre',
		save_as:'hidden_id_id3',
		id_grupo:0
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
	vectorAtributos[0]={
		validacion: {
			name:'id_item',
			fieldLabel:'Item',
			allowBlank: true,
			emptyText:'Id Item...',
			desc:'desc_item', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item,
			valueField:'id_item',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
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
			width_grid:100,// ancho de columna en el gris
			grid_indice:6
		},
		tipo:'ComboBox',
		filtro_0:true,
		grid_indice:7, 
		filterColValue:'ITEM.nombre',
		save_as:'hidden_id_item',
		id_grupo:1
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Inventario de Materiales (Maestro)',
		titulo_detalle:'Inventario Detalle (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};layout_inventario_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
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
	if (maestro.tipo_inventario=='total')
	{var paramMenu={
		actualizar:{crear:true,separador:false}	}
	}
	else
	{var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}	}
	}
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/inventario_det/ActionEliminarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		Save:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		ConfirmSave:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,grupos:[{tituloGrupo:'Clasificacion',columna:0,id_grupo:0},{tituloGrupo:'Item',columna:0,id_grupo:1}],width:480,minWidth:150,minHeight:200,closable:true,titulo:'Inventario Detalle'}
	};
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
				m_id_inventario:maestro.id_inventario }
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Inventario',maestro.id_inventario],['Tipo Inventario',maestro.tipo_inventario],['Observaciones',maestro.observaciones]]);
		vectorAtributos[1].defecto=maestro.id_inventario;
		var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/inventario_det/ActionEliminarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		Save:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		ConfirmSave:{url:direccion+'../../../control/inventario_det/ActionGuardarInventarioDet.php',parametros:'&m_id_inventario='+maestro.id_inventario},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,grupos:[{tituloGrupo:'Clasificacion',columna:0,id_grupo:0},{tituloGrupo:'Item',columna:0,id_grupo:1}],width:480,minWidth:150,minHeight:200,closable:true,titulo:'Inventario Detalle'}
		};
		this.InitFunciones(paramFunciones)
	};
//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	/////////Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_supergrupo = ClaseMadre_getComponente('id_supergrupo');
		combo_grupo = ClaseMadre_getComponente('id_grupo');
		combo_subgrupo = ClaseMadre_getComponente('id_subgrupo');
		combo_id1 = ClaseMadre_getComponente('id_id1');
		combo_id2 = ClaseMadre_getComponente('id_id2');
		combo_id3 = ClaseMadre_getComponente('id_id3');
		combo_item =ClaseMadre_getComponente('id_item');
	var onSuperGrupoSelect = function(e) {
		    combo_grupo.enable();
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
			combo_item.modificado = true;
			//Carga el valor por defecto de grupo
			var  params1=new Array();
			params1['id_grupo']='%';
			params1['nombre']='todos';
			var aux1=new Ext.data.Record(params1,'%');
			combo_grupo.store.add(aux1);
			combo_grupo.setValue('%');
			//Carga el valor por defecto del subgrupo
			var  params0=new Array();
			params0['id_subgrupo']='%';
			params0['nombre']='todos';
			var aux0=new Ext.data.Record(params0,'%');
			combo_subgrupo.store.add(aux0);
			combo_subgrupo.setValue('%');
			//Carga el valor por defecto de Id1
			var  params2=new Array();
			params2['id_id1']='%';
			params2['nombre']='todos';
			var aux2=new Ext.data.Record(params2,'%');
			combo_id1.store.add(aux2);
			combo_id1.setValue('%');
			//Carga el valor por defecto de Id2
			var  params3=new Array();
			params3['id_id2']='%';
			params3['nombre']='todos';
			var aux3=new Ext.data.Record(params3,'%');
			combo_id2.store.add(aux3);
			combo_id2.setValue('%');
			//Carga el valor por defecto de Id3
			var  params4=new Array();
			params4['id_id3']='%';
			params4['nombre']='todos';
			var aux4=new Ext.data.Record(params4,'%');
			combo_id3.store.add(aux4);
			combo_id3.setValue('%');
			//Carga el valor por defecto de Id2
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
		};
		var onGrupoSelect = function(e) {
			 combo_subgrupo.enable();
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
			combo_item.modificado = true;
			//Carga el valor por defecto del subgrupo
			var  params0=new Array();
			params0['id_subgrupo']='%';
			params0['nombre']='todos';
			var aux0=new Ext.data.Record(params0,'%');
			combo_subgrupo.store.add(aux0);
			combo_subgrupo.setValue('%');
			//Carga el valor por defecto de Id1
			var  params2=new Array();
			params2['id_id1']='%';
			params2['nombre']='todos';
			var aux2=new Ext.data.Record(params2,'%');
			combo_id1.store.add(aux2);
			combo_id1.setValue('%');
			//Carga el valor por defecto de Id2
			var  params3=new Array();
			params3['id_id2']='%';
			params3['nombre']='todos';
			var aux3=new Ext.data.Record(params3,'%');
			combo_id2.store.add(aux3);
			combo_id2.setValue('%');
			//Carga el valor por defecto de Id3
			var  params4=new Array();
			params4['id_id3']='%';
			params4['nombre']='todos';
			var aux4=new Ext.data.Record(params4,'%');
			combo_id3.store.add(aux4);
			combo_id3.setValue('%');
			//Carga el valor por defecto de Id2
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
		};
		var onSubGrupoSelect = function(e) {
			 combo_id1.enable();
			var id = combo_subgrupo.getValue()
			combo_id1.filterValues[2] =  id;
			combo_id1.modificado = true;
			combo_id2.filterValues[2] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[2] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[2] =  id;
			combo_item.modificado = true;
			//Carga el valor por defecto de Id1
			var  params2=new Array();
			params2['id_id1']='%';
			params2['nombre']='todos';
			var aux2=new Ext.data.Record(params2,'%');
			combo_id1.store.add(aux2);
			combo_id1.setValue('%');
			//Carga el valor por defecto de Id2
			var  params3=new Array();
			params3['id_id2']='%';
			params3['nombre']='todos';
			var aux3=new Ext.data.Record(params3,'%');
			combo_id2.store.add(aux3);
			combo_id2.setValue('%');
			//Carga el valor por defecto de Id3
			var  params4=new Array();
			params4['id_id3']='%';
			params4['nombre']='todos';
			var aux4=new Ext.data.Record(params4,'%');
			combo_id3.store.add(aux4);
			combo_id3.setValue('%');
			//Carga el valor por defecto de Id2
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
		};
		var onId1Select = function(e) {
			 combo_id2.enable();
			var id = combo_id1.getValue()
			combo_id2.filterValues[3] =  id;
			combo_id2.modificado = true;
			combo_id3.filterValues[3] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[3] =  id;
			combo_item.modificado = true;
			//Carga el valor por defecto de Id2
			var  params3=new Array();
			params3['id_id2']='%';
			params3['nombre']='todos';
			var aux3=new Ext.data.Record(params3,'%');
			combo_id2.store.add(aux3);
			combo_id2.setValue('%');
			//Carga el valor por defecto de Id3
			var  params4=new Array();
			params4['id_id3']='%';
			params4['nombre']='todos';
			var aux4=new Ext.data.Record(params4,'%');
			combo_id3.store.add(aux4);
			combo_id3.setValue('%');
			//Carga el valor por defecto de Id2
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
		};
		var onId2Select = function(e) {
			 combo_id3.enable();
			var id = combo_id2.getValue()
			combo_id3.filterValues[4] =  id;
			combo_id3.modificado = true;
			combo_item.filterValues[4] =  id;
			combo_item.modificado = true;
			//Carga el valor por defecto de Id3
			var  params4=new Array();
			params4['id_id3']='%';
			params4['nombre']='todos';
			var aux4=new Ext.data.Record(params4,'%');
			combo_id3.store.add(aux4);
			combo_id3.setValue('%');
			//Carga el valor por defecto de Item
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
		};
		var onId3Select = function(e) {
			 combo_item.enable();
			var id = combo_id3.getValue()
			combo_item.filterValues[5] =  id;
			combo_item.modificado = true;
			//Carga el valor por defecto de Item
			var  params5=new Array();
			params5['id_item']='%';
			params5['nombre']='todos';
			var aux5=new Ext.data.Record(params5,'%');
			combo_item.store.add(aux5);
			combo_item.setValue('%')
			};
		var onItemSelect = function(e) {
			 var id=combo_item.getValue();
			combo_item.setValue(id)
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
		combo_id3.on('change', onId3Select);
		combo_item.on('select', onItemSelect);
		combo_item.on('change', onItemSelect)
	}
	this.btnNew = function()
	{	ds_supergrupo.load();
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		combo_id3.disable();
		combo_item.disable();
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		ds_supergrupo.load();
		combo_grupo.disable();
		combo_subgrupo.disable();
		combo_id1.disable();
		combo_id2.disable();
		combo_id3.disable();
		combo_item.disable();
		ClaseMadre_btnNew()
		};
		//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_inventario_det.getLayout();
	};
//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]}
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