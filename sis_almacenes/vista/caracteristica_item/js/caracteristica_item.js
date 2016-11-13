function PaginaCaracteristicaItem(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	var txt_id_caracteristica_item,txt_id_tipo_caracteristica,txt_id_caracteristica, txt_valor, txt_valor_date,txt_valor_integer, txt_valor_decimal, txt_valor_varchar, combo_tipoCaracteristica,combo_caracteristica,txt_tipo_unid_med_base,cmb_id_unidad_medida_base;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caracteristica_item/ActionListarCaracteristicaItem.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_caracteristica_item',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'codigo', type: 'string'},
		'id_caracteristica_item',
		'valor',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'id_caracteristica',
		'id_unidad_medida_base',
		'id_tipo_unidad_medida',
		'desc_item',
		'desc_caracteristica',
		'desc_unidad_medida_base',
		'desc_tipo_caracteristica'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			maestro_id_item:maestro.id_item
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO//
	var cmMaestro = new Ext.grid.ColumnModel([
	{header: "Atributo", width:150, sortable: false, renderer: negrita,locked:false, dataIndex: 'atributo'},
	{header: "Valor", width: 300, sortable: false,renderer: italic, locked:false,dataIndex: 'valor'}
	]);

	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>' + value + '</b></span>';
	}
	function italic(value){
		return '<i>'+value+'</i>';
	}
	// create the Grid
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		//ds:dsMaestro,
		ds:new Ext.data.SimpleStore({
			fields: ['atributo','valor'],
			data :[['ID',maestro.id_item],
			['Item',maestro.nombre],
			['Descripción',maestro.descripcion]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
	/////DATA STORE COMBOS////////////
	ds_item=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item/ActionListarItem.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id: 'id_item',
			totalRecords:'TotalCount'
		}, ['id_item','nombre'])
	});
	ds_tipo_caracteristica=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_caracteristica/ActionListarTipoCaracteristica.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id: 'id_tipo_caracteristica',
			totalRecords:'TotalCount'
		}, ['id_tipo_caracteristica','descripcion'])
	});

	ds_caracteristica=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caracteristica/ActionListarCaracteristica.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',
		id: 'id_caracteristica',
		totalRecords:'TotalCount'
		}, ['id_caracteristica','nombre','tipo_dato','id_tipo_unidad_medida'])
	});

	ds_unidadmedidabase=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id: 'id_unidad_medida_base',
			totalRecords:'TotalCount'
		}, ['id_unidad_medida_base','nombre'])
	});

	function renderItem(value, p, record){return String.format('{0}', record.data['desc_item']);}
	function renderTipoCaracteristica(value, p, record){return String.format('{0}', record.data['desc_tipo_caracteristica']);}
	function renderCaracteristica(value, p, record){return String.format('{0}', record.data['desc_caracteristica']);}
	function renderUnidadMedidaBase(value, p, record){return String.format('{0}', record.data['desc_unidad_medida_base']);}

	// Definición de datos //

	vectorAtributos[0] ={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_caracteristica_item',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_caracteristica_item',
		id_grupo:0
	};
	/*filterCols_TipoCaracteristica=new Array();
	filterValues_TipoCaracteristica=new Array();
	filterCols_TipoCaracteristica[0]='TIPCAR.id_tipo_caracteristica';
	filterValues_TipoCaracteristica[0]='%';*/
	//tipo_caracteristica
	vectorAtributos[1]={
		validacion:{
			fieldLabel: 'Tipo de Característica',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Tipo de Caracteristica...',
			name: 'id_tipo_caracteristica',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_tipo_caracteristica', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_tipo_caracteristica,
			valueField:'id_tipo_caracteristica',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPCAR.descripcion',
			/*filterCols:filterCols_TipoCaracteristica,
			filterValues:filterValues_TipoCaracteristica,*/
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
			renderer: renderTipoCaracteristica,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:180, // ancho de columna en el grid
			width:300
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'TIPCAR.descripcion',
		save_as:'txt_id_tipo_caracteristica',
		id_grupo:1
	};
	filterCols_caracteristica=new Array();
	filterValues_caracteristica=new Array();
	filterCols_caracteristica[0]='CAR.id_tipo_caracteristica';
	filterValues_caracteristica[0]='x';
	vectorAtributos[2]={
		validacion:{
			name: 'id_caracteristica',
			fieldLabel: 'Característica',
			allowBlank: false,
			emptyText:'Característica...',
			desc: 'desc_caracteristica',
			store:ds_caracteristica,
			valueField: 'id_caracteristica',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'CAR.nombre',
			filterCols:filterCols_caracteristica,
			filterValues:filterValues_caracteristica,
			typeAhead: true,
			forceSelection: true,
			/*onSelect: function(record){txt_id_caracteristica_item.setValue(record.data.id_caracteristica);txt_id_tipo_caracteristica.setValue(record.data.tipo_dato);txt_id_caracteristica.setValue(record.data.id_tipo_unidad_medida);unidad_medida();tipo_dato();txt_id_caracteristica_item.collapse();},
			onChange: function(record){txt_id_caracteristica_item.setValue(record.data.id_caracteristica);txt_id_tipo_caracteristica.setValue(record.data.tipo_dato);txt_id_caracteristica.setValue(record.data.id_tipo_unidad_medida);unidad_medida();tipo_dato();txt_id_caracteristica_item.collapse();},*/
			//onSelect: function(record){unidad_medida();tipo_dato()},
			//onChange: function(record){unidad_medida();tipo_dato()},
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth: 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars: 1,
			triggerAction: 'all',
			editable: true,
			renderer: renderCaracteristica,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:300
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'CAR.nombre',
		save_as:'txt_id_caracteristica',
		id_grupo:1
	};

	vectorAtributos[3]= {
		validacion:{
			name:'valor',
			labelSeparator:'',
			fieldLabel:'Valor ',
			allowBlank:true,
			maxLength:1200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			disabled:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
		},
		tipo: 'TextField',
		filtro_0:true,
		save_as:'txt_valor',
		id_grupo:3
	};
	vectorAtributos[4]={
		validacion:{
			name:'id_tipo_unidad_medida',
			labelSeparator:'',
			fieldLabel:'Valor X',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			disabled:true,
			grid_editable:false,
			width_grid:100,
			id_grupo:0
		},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_tipo_unid_med_base',
		id_grupo:0
	};
	filterCols_unidad_medida_base=new Array();
	filterValues_unidad_medida_base=new Array();
	filterCols_unidad_medida_base[0]='UNMEDB.id_tipo_unidad_medida';
	filterValues_unidad_medida_base[0]='%';
	/////////// hidden_id_unidad_medida_base //////
	vectorAtributos[5]={
		validacion:{
			fieldLabel: 'Unidad Medida Base',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Unidad Medida Base...',
			name: 'id_unidad_medida_base',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_unidad_medida_base', //indica la columna del store principal "ds" del que proviene la descripcion
			store:ds_unidadmedidabase,
			valueField: 'id_unidad_medida_base',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'UNMEDB.nombre',
			filterCols:filterCols_unidad_medida_base,
			filterValues:filterValues_unidad_medida_base,
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
			editable : true,
			renderer: renderUnidadMedidaBase,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:130, // ancho de columna en el grid
			width:300
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'umb.nombre',
		save_as:'txt_id_unidad_medida_base',
		id_grupo:2
	};
	// txt valor
	vectorAtributos[6]= {
		validacion:{
			name:'valor_date',
			fieldLabel:'Valor (fecha)',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			dataType:'fecha',
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_valor_date',
		id_grupo:3
	};
	vectorAtributos[7]= {
		validacion:{
			name:'valor_integer',
			fieldLabel:'Valor Entero',
			allowBlank:true,
			maxLength:1200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			allowDecimals:false,
			grid_editable:false,
			width_grid:60
		},
		tipo: 'NumberField',
		filtro_0:false,
		save_as:'txt_valor_integer',
		id_grupo:3
	};
	vectorAtributos[8]={
		validacion:{
			name:'valor_decimal',
			fieldLabel:'Valor Decimal',
			allowBlank:true,
			maxLength:1200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			allowDecimals:true,
			width_grid:60
		},
		tipo: 'NumberField',
		filtro_0:false,
		save_as:'txt_valor_decimal',
		id_grupo:3
	};
	vectorAtributos[9]={
		validacion:{
			name:'valor_varchar',
			fieldLabel:'Valor Texto',
			allowBlank:true,
			maxLength:1200,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:60,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:false,
		save_as:'txt_valor_varchar',
		id_grupo:3
	};
	// txt observaciones
	vectorAtributos[10]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'caraci.observaciones',
		save_as:'txt_observaciones',
		id_grupo:4
	};
	/////////// hidden id_item //////
	vectorAtributos[11]={
		validacion:{
			name:'nombre',
			labelSeparator:'',
			inputType:'hidden',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			disabled:true,
			grid_editable:false,
			width_grid:100,
			id_grupo:0
		},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_id_item',
		defecto:maestro.id_item
	};
	// txt fecha_reg
	vectorAtributos[12]= {
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
			width_grid:95,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'caraci.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:0
	};
	vectorAtributos[13]={
		validacion:{
			name:'tipo_valor',
			labelSeparator:'',
			inputType:'hidden',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			disabled:true,
			grid_editable:false,
			width_grid:100,
			id_grupo:0
		},
		tipo: 'TextField',
		filtro_0:false,
		save_as:'txt_tipo_valor',
		id_grupo:0
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	var config={
		titulo_maestro:"Item (Maestro)",
		titulo_detalle:"Características del Item (Detalle)"
	};
	layout_caracteristica_item = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_caracteristica_item.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_caracteristica_item,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
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
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//datos necesarios para el filtro
	parametrosFiltro = '&filterValue_0='+ds.lastOptions.params.filterValue_0+'&filterCol_0='+ds.lastOptions.params.filterCol_0;
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/caracteristica_item/ActionEliminarCaracteristicaItem.php'
		},
		Save:{url:direccion+'../../../control/caracteristica_item/ActionGuardarCaracteristicaItem.php'
		},
		ConfirmSave:{url:direccion+'../../../control/caracteristica_item/ActionGuardarCaracteristicaItem.php'
		},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			width:'45%',height:'58%',minWidth:150,minHeight:200,closable:true,columnas:['95%'],titulo: 'Caracteristica Item',grupos:[
			{tituloGrupo:'Oculto',columna:0,	id_grupo:0
			},
			{ 	tituloGrupo:'Caracteristicas de Item',
			columna:0,id_grupo:1
			},
			{ tituloGrupo:'Unidad Medida Base',columna:0,	id_grupo:2
			},
			{ 	tituloGrupo:'Valor de Caracteristica',columna:0,id_grupo:3	},
			{ 	tituloGrupo:'Observaciones',columna:0,id_grupo:4
			}]
		}
	};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				maestro_id_item:datos.maestro_id_item
			}
		});
		gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([
		['ID',datos.maestro_id_item],
		['Item',datos.maestro_nombre],
		['Descripción',datos.maestro_descripcion]
		]);
		vectorAtributos[11].defecto=datos.maestro_id_item;
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		combo_tipoCaracteristica=ClaseMadre_getComponente('id_tipo_caracteristica');
		combo_caracteristica=ClaseMadre_getComponente('id_caracteristica');

		txt_valor=ClaseMadre_getComponente('valor');
		txt_valor_date=ClaseMadre_getComponente('valor_date');
		txt_valor_integer=ClaseMadre_getComponente('valor_integer');
		txt_valor_decimal=ClaseMadre_getComponente('valor_decimal');
		txt_valor_varchar=ClaseMadre_getComponente('valor_varchar');
		
		txt_tipo_unid_med_base=ClaseMadre_getComponente('id_tipo_unidad_medida');
		txt_id_caracteristica_item=ClaseMadre_getComponente('id_caracteristica_item');
		txt_id_tipo_caracteristica=ClaseMadre_getComponente('id_tipo_caracteristica');
		txt_id_caracteristica=ClaseMadre_getComponente('id_caracteristica');
		cmb_id_unidad_medida_base=ClaseMadre_getComponente('id_unidad_medida_base');

		var onTipoCaracteristicaSelect=function(e) {
			var id=combo_tipoCaracteristica.getValue();
			combo_caracteristica.setValue("");
			combo_caracteristica.filterValues[0]=id;
			combo_caracteristica.modificado=true;
		};
		var onCaracteristicaSelect=function(e) {
			unidad_medida();
			tipo_dato();
		};
		combo_tipoCaracteristica.on('select', onTipoCaracteristicaSelect);
		combo_tipoCaracteristica.on('change', onTipoCaracteristicaSelect);
		combo_caracteristica.on('select', onCaracteristicaSelect);
		combo_caracteristica.on('change', onCaracteristicaSelect);
	}
	
	function tipo_dato(){
		var aux,valor;
		aux=combo_caracteristica.store.getById(combo_caracteristica.getValue()).data;
		valor=aux['tipo_dato'];
		
		//CM_ocultarComponente(txt_valor);//date
		CM_ocultarComponente(txt_valor_date);//date
		CM_ocultarComponente(txt_valor_integer);//integer
		CM_ocultarComponente(txt_valor_decimal);//decimal
		CM_ocultarComponente(txt_valor_varchar);//varchar
		if(valor=='Decimal'){
			CM_mostrarComponente(txt_valor_decimal);
			CM_ocultarComponente(txt_valor_date);//date
			CM_ocultarComponente(txt_valor_integer);//integer
			CM_ocultarComponente(txt_valor_varchar);//varchar
			txt_valor_decimal.allowBlank=false;
			txt_valor_date.allowBlank=true;
			txt_valor_integer.allowBlank=true;
			txt_valor_varchar.allowBlank=true;
		}else{
			if(valor=='Entero'){
				CM_mostrarComponente(txt_valor_integer);
				CM_ocultarComponente(txt_valor_decimal);
				CM_ocultarComponente(txt_valor_date);//date
				CM_ocultarComponente(txt_valor_varchar);//varchar
				txt_valor_integer.allowBlank=false;
				txt_valor_date.allowBlank=true;
				txt_valor_decimal.allowBlank=true;
				txt_valor_varchar.allowBlank=true;
			}else{
				if(valor=='Texto'){
					CM_mostrarComponente(txt_valor_varchar);
					CM_ocultarComponente(txt_valor_integer);
					CM_ocultarComponente(txt_valor_decimal);
					CM_ocultarComponente(txt_valor_date);//date
					txt_valor_varchar.allowBlank=false;
					txt_valor_date.allowBlank=true;
					txt_valor_integer.allowBlank=true;
					txt_valor_decimal.allowBlank=true;
				}
				else{
					if(valor=='Fecha'){
						CM_mostrarComponente(txt_valor_date);
						CM_ocultarComponente(txt_valor_integer);
						CM_ocultarComponente(txt_valor_decimal);
						CM_ocultarComponente(txt_valor_varchar);
						txt_valor_date.allowBlank=false;
						txt_valor_decimal.allowBlank=true;
						txt_valor_integer.allowBlank=true;
						txt_valor_varchar.allowBlank=true
					}
				}
			}
		}

	}
	function unidad_medida(){
		
		if(txt_tipo_unid_med_base.getValue()!= "" || txt_tipo_unid_med_base.getValue()!= null){
						
			//no nulo
			cmb_id_unidad_medida_base.filterValues[0]=txt_tipo_unid_med_base.getValue();
			cmb_id_unidad_medida_base.modificado=true;
			CM_mostrarGrupo('Unidad Medida Base');
		}
		else{
			CM_ocultarGrupo('Unidad Medida Base');
			
			
		}
	}
	this.btnNew = function(){	
		
	CM_ocultarGrupo('Oculto');
	//CM_ocultarGrupo('Unidad Medida Base');
	CM_mostrarGrupo('Unidad Medida Base');
	CM_ocultarComponente(txt_valor_date);//date
	CM_ocultarComponente(txt_valor_integer);//integer
	CM_ocultarComponente(txt_valor_decimal);//decimal
	CM_ocultarComponente(txt_valor);//decimal
	CM_mostrarComponente(txt_valor_varchar);//decimal
	ClaseMadre_btnNew()
	};
	this.btnEdit = function(){
		
	CM_ocultarComponente(txt_valor_date);//date
	CM_ocultarComponente(txt_valor_integer);//integer
	CM_ocultarComponente(txt_valor_decimal);//decimal
	CM_ocultarComponente(txt_valor_varchar);//decimal
	CM_mostrarGrupo('Unidad Medida Base');
	CM_ocultarGrupo('Oculto');
	//CM_ocultarComponente(txt_valor_varchar);
	CM_mostrarComponente(txt_valor);
	CM_mostrarComponente(txt_valor_varchar);
		
	ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_caracteristica_item.getLayout()
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
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btnSubtipos,true, 'subtipos','Subtipos de Activos Fijos');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caracteristica_item.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}