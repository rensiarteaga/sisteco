/**
 * Nombre:		  	    pagina_nivel_oec.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-02 22:29:51
 */
function pagina_nivel_oec(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/nivel_oec/ActionListarNivelOec.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_nivel_oec',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_nivel_oec',
		'id_parametro',
		'desc_parametro',
		'nivel',
		'dig_nivel'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit:paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_parametro:maestro.id_parametro,
			m_gestion_tesoro:maestro.gestion_tesoro,
			m_estado_gestion:maestro.estado_gestion
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
	['Gestión Tesoreria',maestro.gestion_tesoro],
	['Estado',renderEstado(maestro.estado_gestion)]];
	
	
//----------------------------------------------------------	
	
	var cmMaestro=new Ext.grid.ColumnModel([
	{header:"Atributo", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
	{header:"Valor", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
	]);
			
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[
			['Gestión Tesoreria',maestro.gestion_tesoro],
			['Estado',renderEstado(maestro.estado_gestion)]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
//----------------------------------------------------------	
	
	//DATA STORE COMBOS

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});

	//FUNCIONES RENDER
	
		function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion_pres}</FONT><br>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');

		function renderEstado(value, p, record){
		if(value == 1)
		{return  "Formulación"}
		if(value == 2)
		{return  "Anteproyecto"}
		if(value == 3)
		{return  "Aprobado"}}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_nivel_oec
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_nivel_oec',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_nivel_oec'
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
// txt nivel
	Atributos[2]={
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			align:'right',
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:50,
			disabled:true,
			grid_indice:1		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'NIVOEC.nivel',
		save_as:'nivel'
	};
// txt dig_nivel
	Atributos[3]={
		validacion:{
			name:'dig_nivel',
			fieldLabel:'Dígitos por Nivel',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			align:'right',
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:1,
			maxValue:10,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:50,
			disabled:false,
			grid_indice:2		
		},
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'NIVOEC.dig_nivel',
		save_as:'dig_nivel'
	};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetro (Maestro)',titulo_detalle:'Niveles (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_nivel_oec = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_nivel_oec.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_nivel_oec,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},editar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};

	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/nivel_oec/ActionEliminarNivelOec.php',parametros:'&m_id_parametro='+maestro.id_parametro},
	Save:{url:direccion+'../../../control/nivel_oec/ActionGuardarNivelOec.php',parametros:'&m_id_parametro='+maestro.id_parametro},
	ConfirmSave:{url:direccion+'../../../control/nivel_oec/ActionGuardarNivelOec.php',parametros:'&m_id_parametro='+maestro.id_parametro},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:300,minWidth:150,minHeight:200,	closable:true,titulo:'Dígitos por Nivel'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_parametro=datos.m_id_parametro;
	maestro.gestion_tesoro=datos.m_gestion_tesoro;
	maestro.estado_gestion=datos.m_estado_gestion;
	ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_parametro:maestro.id_parametro,
				m_gestion_tesoro:maestro.gestion_tesoro,
			    m_estado_gestion:maestro.estado_gestion
			}
		};
		this.btnActualizar();
		data_maestro=[['id_parametro',maestro.id_parametro],['Gestión Tesoreria',maestro.gestion_tesoro],['Estado',maestro.estado_gestion]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));		
		var cmMaestro=new Ext.grid.ColumnModel([
		{header:" ", width:150, sortable:false, renderer:negrita,locked:false, dataIndex:'atributo'},
		{header:" ", width:300, sortable:false,renderer:italic, locked:false,dataIndex:'valor'}
		]);
				
		var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
			ds:new Ext.data.SimpleStore({
				fields:['atributo','valor'],
				data:[
				['Gestión Tesoreria',maestro.gestion_tesoro],
				['Estado',renderEstado(maestro.estado_gestion)]]
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
	this.getLayout=function(){return layout_nivel_oec.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_nivel_oec.getLayout().addListener('layout',this.onResize);
	layout_nivel_oec.getVentana(idContenedor).on('resize',function(){layout_nivel_oec.getLayout().layout()})	
}