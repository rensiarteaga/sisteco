/**
 * Nombre:		  	    pagina_tipo_cambio.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-14 18:05:58
 */
function pagina_tipo_cambio(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/param_tcam/ActionListarTipoCambio.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_param_tcam',totalRecords:'TotalCount'
		},[		
		'id_param_tcam',
		'id_parametro',
		'desc_parametro',
		'id_moneda_int',
		'desc_moneda',
		'tipo_cambio'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_parametro:maestro.id_parametro
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO
	//---------------------------------------------------------
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	//Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[
	['id_parametro',maestro.id_parametro],
	['Gestión Presupuesto',maestro.gestion_pres],
	['Estado',maestro.estado_gral]];
	
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
	{header:"Valor", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
	]);
			
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[
			['Gestión Presupuesto',maestro.gestion_pres],
			['Estado',renderEstado(maestro.estado_gral)]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
		
	//DATA STORE COMBOS
    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','desc_estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','cod_formulario_gasto','cod_formulario_recurso','id_gestion'])
	});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMonedas.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{desc_estado_gral}</FONT>','</div>');

	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderEstado(value, p, record){
		if(value == 1)
		{return  "Formulación"}
		if(value == 2)
		{return  "Anteproyecto"}
		if(value == 3)
		{return "Aprobado"}}
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_param_tcam
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_param_tcam',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_param_tcam'
	};
	
// txt id_parametro
	Atributos[1]={
		validacion:{
			name:'id_parametro',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_parametro,
		save_as:'id_parametro'
	};	
	
// txt id_moneda
	Atributos[2]={
			validacion:{
			name:'id_moneda_int',
			fieldLabel:'Moneda',
			allowBlank:false,			
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
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'PARTCA.id_moneda_int',
		save_as:'id_moneda_int'
	};	
	
// txt tipo_cambio
	Atributos[3]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo de Cambio',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:6,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:80,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTCA.tipo_cambio',
		save_as:'tipo_cambio'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetros por Gestión (Maestro)',titulo_detalle:'Tipo Cambio (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_cambio = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_tipo_cambio.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
		
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_tipo_cambio,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/param_tcam/ActionEliminarTipoCambio.php'},
		Save:{url:direccion+'../../../control/param_tcam/ActionGuardarTipoCambio.php'},
		ConfirmSave:{url:direccion+'../../../control/param_tcam/ActionGuardarTipoCambio.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo de Cambio'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_parametro=datos.m_id_parametro;
	maestro.gestion_pres=datos.m_gestion_pres;
	maestro.estado_gral=datos.m_estado_gral;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_parametro:maestro.id_parametro
			}
		};
		this.btnActualizar();
		data_maestro=[['id_parametro',maestro.id_parametro],['Gestión Presupuesto',maestro.gestion_pres],['Estado',maestro.estado_gral]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		
		var cmMaestro=new Ext.grid.ColumnModel([
		{header:" ", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
		{header:" ", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
		]);
				
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
			ds:new Ext.data.SimpleStore({
				fields:['atributo','valor'],
				data:[
				['Gestión Presupuesto',maestro.gestion_pres],
				['Estado',renderEstado(maestro.estado_gral)]]
			}),
			cm:cmMaestro
		});
		gridMaestro.render();
		Atributos[1].defecto=maestro.id_parametro;

		paramFunciones.btnEliminar.parametros='&m_id_parametro='+maestro.id_parametro;
		paramFunciones.Save.parametros='&m_id_parametro='+maestro.id_parametro;
		paramFunciones.ConfirmSave.parametros='&m_id_parametro='+maestro.id_parametro;
		this.InitFunciones(paramFunciones)
	};
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_cambio.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_cambio.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}