/**
 * Nombre:		  	    pagina_destino.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-04 08:54:28
 */
function pagina_destino(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/destino/ActionListarDestino.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_destino',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_destino',
		'importe_pasaje',
		'importe_hotel',
		'importe_viaticos',
		'id_categoria',
		'desc_categoria',
		'id_lugar',
		'desc_lugar',
		'id_moneda',
		'tipo_destino',
		'desc_moneda'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_categoria:maestro.id_categoria
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_categoria',maestro.id_categoria],['Descripción Categoria',maestro.desc_categoria]];
	
	
	
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
	{header:"Valor", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
	]);
	
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[
			['Descripción Categoría',maestro.desc_categoria]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
	
	
	
	//DATA STORE COMBOS

    var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria/ActionListarCategoria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria'])
	});

    var ds_lugar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords: 'TotalCount'},['id_lugar','fk_id_lugar','nivel','codigo','nombre','ubicacion','telefono1','telefono2','fax','observacion','sw_municipio'])
			,baseParams:{sw_municipio_combo:'si'}});
			

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
		var tpl_id_categoria=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_categoria}</FONT><br>','</div>');

		function render_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
		//var tpl_id_lugar=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{ubicacion}</FONT>','</div>');
		var tpl_id_lugar=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b> </b>{ubicacion}</FONT>','</div>');
		
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		//var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
		function renderTipoDestino(value, p, record)
		{
			if(value == 1)
			{return "Ciudad Tipo A"}
			if(value == 2)
			{return "Ciudad Tipo B"}
			if(value == 3)
			{return "Campo"}
			if(value == 4)
			{return "País Tipo A"}
			if(value == 5)
			{return "País Tipo B"}		
			return 'Otro';
		}
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_destino
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_destino',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_destino'
	};
	
// txt id_lugar
	Atributos[1]={
			validacion:{
			name:'id_lugar',
			fieldLabel:'Ciudad',
			allowBlank:true,			
			emptyText:'Ciudad...',
			desc: 'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre#LUGARR.ubicacion',
			typeAhead:true,
			tpl:tpl_id_lugar,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_lugar,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGARR.nombre',
		save_as:'id_lugar'
	};
	
	Atributos[2]={
		validacion:{
			name:'tipo_destino',
			fieldLabel:'Tipo Destino',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Ciudad Tipo A'],['2','Ciudad Tipo B'],['3','Campo'],['4','País Tipo A'],['5','País Tipo B']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderTipoDestino,
			lazyRender:true,
			forceSelection:true,
			width_grid:150,
			width:150,
			grid_visible:true,
			grid_editable:true, 
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		filterColValue:'DESTIN.tipo_destino'		
	};
// txt id_moneda
	Atributos[3]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	
	
// txt importe_pasaje
	Atributos[4]={
		validacion:{
			name:'importe_pasaje',
			fieldLabel:'Importe Pasaje',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'60%',
			disable:false,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DESTIN.importe_pasaje',
		save_as:'importe_pasaje'
	};
// txt importe_hotel
	Atributos[5]={
		validacion:{
			name:'importe_hotel',
			fieldLabel:'Importe Hotel',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'60%',
			disable:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DESTIN.importe_hotel',
		save_as:'importe_hotel'
	};
// txt importe_viaticos
	Atributos[6]={
		validacion:{
			name:'importe_viaticos',
			fieldLabel:'Importe Viatico',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'60%',
			disable:false,
			grid_indice:6		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DESTIN.importe_viaticos',
		save_as:'importe_viaticos'
	};
// txt id_categoria
	Atributos[7]={
		validacion:{
			name:'id_categoria',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_categoria,
		save_as:'id_categoria'
	};

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Categoría Viajes (Maestro)',titulo_detalle:'Destino (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_destino = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_destino.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_destino,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/destino/ActionEliminarDestino.php',parametros:'&m_id_categoria='+maestro.id_categoria},
	Save:{url:direccion+'../../../control/destino/ActionGuardarDestino.php',parametros:'&m_id_categoria='+maestro.id_categoria},
	ConfirmSave:{url:direccion+'../../../control/destino/ActionGuardarDestino.php',parametros:'&m_id_categoria='+maestro.id_categoria},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Destino'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_categoria=datos.m_id_categoria;
	maestro.desc_categoria=datos.m_desc_categoria;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_categoria:maestro.id_categoria
			}
		};
		this.btnActualizar();
		data_maestro=[['id_categoria',maestro.id_categoria],['Descripción Categoría',maestro.desc_categoria]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		var cmMaestro=new Ext.grid.ColumnModel([
		{header:"Atributo", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
		{header:"Valor", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
		]);
		
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[
			['Descripción Categoria',maestro.desc_categoria]]
		}),
		cm:cmMaestro
		});
		gridMaestro.render();

		
			
		Atributos[7].defecto=maestro.id_categoria;

		paramFunciones.btnEliminar.parametros='&m_id_categoria='+maestro.id_categoria;
		paramFunciones.Save.parametros='&m_id_categoria='+maestro.id_categoria;
		paramFunciones.ConfirmSave.parametros='&m_id_categoria='+maestro.id_categoria;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_destino.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_destino.getLayout().addListener('layout',this.onResize);
	layout_destino.getVentana(idContenedor).on('resize',function(){layout_destino.getLayout().layout()})
	
}