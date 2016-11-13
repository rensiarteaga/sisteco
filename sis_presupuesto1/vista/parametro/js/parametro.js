/**
 * Nombre:		  	    pagina_parametro.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-02 22:12:49
 */
function pagina_parametro(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'
		},[		
				'id_parametro',
		'gestion_pres',
		'estado_gral',
		'cod_institucional',
		'porcentaje_sobregiro',
		'niveles_recurso',
		'niveles_gasto',
		'cod_formulario_gasto',
		'cod_formulario_recurso',
		'id_gestion',
		'desc_gestion',
		'mod_inversion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//DATA STORE COMBOS
    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});

	//FUNCIONES RENDER
	
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
		//var tpl_id_gestion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion}</FONT><br>','</div>');
		//var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');
	
	////////////////FUNCIONES RENDER ////////////
	function renderEstado(value, p, record){
		if(value == 1){return "1. Formulación"}
		if(value == 2){return "2. Verificación Previa"}
		if(value == 3){return "3. Revisión Final"}
		if(value == 4){return "4. Anteproyecto"}
		if(value == 5){return "5. Aprobado"}
		if(value == 6){return "6. Cerrado"}
	}
	
	function renderInversion(value, p, record){
		if(value == "si"){return "Permitir Traspasos"}
		if(value == "no"){return "Restringir Traspasos"}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_parametro
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_parametro',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_parametro'
	};

	Atributos[1]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			emptyText:'Gestión...',
			desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			onSelect:function(record){componentes[1].setValue(record.data.id_gestion);componentes[9].setValue(record.data.gestion);componentes[1].collapse();},
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false,
			grid_indice:1
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.id_gestion',
		save_as:'id_gestion'
	}; 	

// txt estado_gral
	Atributos[2]={
			validacion: {
			name:'estado_gral',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Formulación'],['2','Anteproyecto'],['3','Aprobado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderEstado,	//aumentado 
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			minListWidth:100,
			disabled:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.estado_gral',
		defecto:1,
		save_as:'estado_gral'
	};
															
// txt cod_institucional
	Atributos[3]={
		validacion:{
			name:'cod_institucional',
			fieldLabel:'Código Institucional',
			allowBlank:false,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.cod_institucional',
		save_as:'cod_institucional'
	};
// txt porcentaje_sobregiro
	Atributos[4]={
		validacion:{
			name:'porcentaje_sobregiro',
			fieldLabel:'% de Sobregiro',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			maxValue:100,
			align:'right',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:60,
			disabled:false,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		defecto:0,
		filterColValue:'PARAMP.porcentaje_sobregiro',
		save_as:'porcentaje_sobregiro'
	};
// txt niveles_recurso
	Atributos[5]={
		validacion:{
			name:'niveles_recurso',
			fieldLabel:'Niveles Recurso',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:2,
			maxValue:10,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'right',
			width:60,
			disabled:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.niveles_recurso',
		save_as:'niveles_recurso'
	};
// txt niveles_recurso
	Atributos[6]={
		validacion:{
			name:'niveles_gasto',
			fieldLabel:'Niveles Gasto',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:2,
			maxValue:10,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'right',
			width:60,
			disabled:false,
			grid_indice:6		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.niveles_gasto',
		save_as:'niveles_gasto'
	};
// txt cod_institucional
	Atributos[7]={
		validacion:{
			name:'cod_formulario_gasto',
			fieldLabel:'Código Formulario Gasto',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.cod_formulario_gasto',
		save_as:'cod_formulario_gasto'
	};
// txt cod_institucional
	Atributos[8]={
		validacion:{
			name:'cod_formulario_recurso',
			fieldLabel:'Código Formulario Recurso',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'100%',
			disable:false,
			grid_indice:8		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.cod_formulario_recurso',
		save_as:'cod_formulario_recurso'
	};

// txt gestion_pres
	Atributos[9]={
		validacion:{
			name:'gestion_pres',
			fieldLabel:'Gestión Presupuesto',
			allowBlank:true,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:180,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'gestion_pres'
	};	

	// txt mod_inversion
	Atributos[10]={
		validacion: {
			name:'mod_inversion',
			fieldLabel:'Ppto. Inversión',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Permitir Traspasos'],['no','Restringir Traspasos']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderInversion,	//aumentado 
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			minListWidth:100,
			disabled:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		defecto:'no',
		form: true,
		filtro_0:false,
		filterColValue:'PARAMP.mod_inversion',
		save_as:'mod_inversion'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetro',grid_maestro:'grid-'+idContenedor};
	var layout_parametro=new DocsLayoutMaestro(idContenedor);
	layout_parametro.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_parametro,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},		
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro/ActionEliminarParametro.php'},
		Save:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Parámetro'}};
	
	this.btnNew=function()
	{
		Atributos[4].defecto=0;
		CM_ocultarComponente(componentes[2]);
		CM_ocultarComponente(componentes[9]);
								
		ClaseMadre_btnNew();		
	};
		
	function InitPaginaParametro()
	{				
		for(i=0;i<Atributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}		
	}
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_digitos_nivel_recursos(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro='+SelectionsRecord.data.id_parametro;
			data=data+'&m_gestion_pres='+SelectionsRecord.data.gestion_pres;
			data=data+'&m_estado_gral='+SelectionsRecord.data.estado_gral;
			data=data+'&m_tipo_nivel='+1;			

			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_parametro.loadWindows(direccion+'../../../../sis_presupuesto/vista/nivel_partida/nivel_partida.php?'+data,'Niveles',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}	
	
	function btn_digitos_nivel_gasto(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_parametro='+SelectionsRecord.data.id_parametro;
			data=data+'&m_gestion_pres='+SelectionsRecord.data.gestion_pres;
			data=data+'&m_estado_gral='+SelectionsRecord.data.estado_gral;
			data=data+'&m_tipo_nivel='+2;				

			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_parametro.loadWindows(direccion+'../../../../sis_presupuesto/vista/nivel_partida/nivel_partida.php?'+data,'Niveles',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_tipo_cambio()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
				
			var data='m_id_parametro='+SelectionsRecord.data.id_parametro;
			data=data+'&m_gestion_pres='+SelectionsRecord.data.gestion_pres;
			data=data+'&m_estado_gral='+SelectionsRecord.data.estado_gral;

			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_parametro.loadWindows(direccion+'../../../../sis_presupuesto/vista/tipo_cambio/tipo_cambio.php?'+data,'Tipo de Cambio',ParamVentana);

		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_migrar() 
	{       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1) 
		{
			if(confirm('Esta seguro de Migrar los clasificadores, presupuestos y conceptos de gasto de la gestión anterior a la actual?'))
					{sw=true}
			if(sw)
			{
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_0=" + SelectionsRecord.data.id_parametro+"&estado_gral_0=1&cantidad_ids=1&accion=migrar";
				Ext.Ajax.request({url:direccion+"../../../control/parametro/ActionGuardarParametro.php",
				params:data,
				method:'POST',
				success:cargar_migracion,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}		
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion.');
		}
	}
	
	function btn_aprobar()
	{       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1)
		{
			if(confirm('Esta seguro de Aprobar la gestión de presupuestos, desea continuar?'))
					{sw=true}
			if(sw)
			{
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_0=" + SelectionsRecord.data.id_parametro+"&estado_gral_0=5&cantidad_ids=1&accion=aprobar";
				Ext.Ajax.request({url:direccion+"../../../control/parametro/ActionGuardarParametro.php",
				params:data,
				method:'POST',
				success:cargar_aprobado,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}		
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion.');
		}
	}
	
	function btn_cerrar()
	{       
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var sw=false;
		
		if(NumSelect==1)
		{
			if(confirm('Esta seguro de  Cerrar la gestión de presupuestos, desea continuar?'))
					{sw=true}
			if(sw)
			{
				var SelectionsRecord =sm.getSelected();
				var data="id_parametro_0=" + SelectionsRecord.data.id_parametro+"&estado_gral_0=6&cantidad_ids=1&accion=cerrar";
				Ext.Ajax.request({url:direccion+"../../../control/parametro/ActionGuardarParametro.php",
				params:data,
				method:'POST',
				success:cargar_cerrado,
				failure:ClaseMadre_conexionFailure,
				timeout:1000000000});
			}
		}		
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar una sola gestion.');
		}
	}
	
	function cargar_aprobado(resp)
	{
		alert('La aprobación de la gestion de presupuestos fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_cerrado(resp)
	{
		alert('El cerrado de la gestion de presupuestos fue exitosa');
		ClaseMadre_btnActualizar();
	}
	function cargar_migracion(resp)
	{
		alert('La migracion de los clasificadores, presupuestos y conceptos de gasto de la gestion anterior a la nueva fue exitosa');
		ClaseMadre_btnActualizar();
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario		
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_parametro.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Niveles del Clasificador de Recursos',btn_digitos_nivel_recursos,true,'nivel_partida','Niveles Recursos');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Niveles del Clasificador de Gastos',btn_digitos_nivel_gasto,true,'nivel_partida','Niveles Gasto');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Tipos de Cambio para Presupuestar',btn_tipo_cambio,true,'param_tcam','Tipos de Cambio');
	
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Permite migrar los clasificadores y los presupuestos de la gestion anterior a la nueva',btn_migrar,true,'migrar','Migrar del anterior');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Aprobar todos los presupuestos de la Gestión y habilitarlos para ejecucion',btn_aprobar,true,'aprobado','Aprobar');
    this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cerrar la Gestión Presupuestaria para bloquear la ejecucion presupuestaria en la siguiente gestion',btn_cerrar,true,'cerrado','Cerrar');
	
	this.iniciaFormulario(); 
	InitPaginaParametro();
	iniciarEventosFormularios();
	layout_parametro.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}