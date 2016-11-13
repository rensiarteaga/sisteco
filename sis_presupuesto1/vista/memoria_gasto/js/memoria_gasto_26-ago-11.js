/**
 * Nombre:		  	    pagina_memoria_gasto.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:20
 */
function pagina_memoria_gasto(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var sw_filtro;
	var dialog;
	
	var tipoDeCambio;
	var importe_concepto;
	var importe_final;
	
	var miGrid;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/mem_inversion_gasto/ActionListarMemoriaGasto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_mem_inversion_gasto',
			totalRecords: 'TotalCount'
			}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_mem_inversion_gasto',
			'cantidad',
			'costo_unitario',
			'periodo_pres',
			'tipo_mem',
			'id_memoria_calculo',
			'id_moneda',
			'desc_moneda',
			'total_general'
		]),remoteSort:true});
		
	// Definición de datos //
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//DATA STORE COMBOS
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});

	//FUNCIONES RENDER	
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	
	function renderPeriodo(value, p, record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}
		else
		{return "T O T A L :"}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_mem_inversion_gasto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_inversion_gasto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_inversion_gasto'
	};
	
// txt estado_gral
	Atributos[1]={
		validacion: {
			name:'tipo_insercion',
			fieldLabel:'Tipo inserción',
			allowBlank:false,
			emptyText:'Tipo ...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','En un mes especifico'],['2','En los doce meses']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:200,
			disable:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMSER.periodo_pres',
		defecto:1,
		save_as:'tipo_insercion'
	};	
	
// txt periodo_pres
	Atributos[2]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:false,
			emptyText:'Periodo...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			minListWidth:100,
			disable:false
			//grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.periodo_pres',
		defecto:1,
		save_as:'periodo_pres'
	};		
	
// txt cantidad
	Atributos[3]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			decimalPrecision:0,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		defecto:0,
		filterColValue:'MEMING.cantidad',
		save_as:'cantidad'
	};
// txt costo_unitario
	Atributos[4]={
		validacion:{
			name:'costo_unitario',
			fieldLabel:'Costo Unitario',
			allowBlank:false,
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
			//renderer: renderSeparadorDeMil,
			width_grid:150,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		defecto:0,
		filterColValue:'MEMING.costo_unitario',
		save_as:'costo_unitario'
	};

// txt tipo_mem
	Atributos[5]={
		validacion:{
			name:'tipo_mem',
			fieldLabel:'Tipo Memoria',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'MEMING.tipo_mem',
		save_as:'tipo_mem'
	};
// txt id_memoria_calculo
	Atributos[6]={
		validacion:{
			name:'id_memoria_calculo',
			fieldLabel:'Memoria',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'60%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		//defecto:maestro.id_memoria_calculo,
		filterColValue:'MEMING.id_memoria_calculo',
		save_as:'id_memoria_calculo'
	};
	
// txt total_general
	Atributos[7]={
		validacion:{
			name:'total_general',
			fieldLabel:'Costo Mensual',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:150,
			width:'50%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.total_general',
		save_as:'total_general'
	};
	
// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
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
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//defecto:maestro.id_moneda,
		filterColValue:'MONEDA.nombre',
		id_grupo:1,
		save_as:'id_moneda'
	};	

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria de Cálculo (Maestro)',titulo_detalle:'Memoria de Gastos x Item (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_gasto = new DocsLayoutMaestro(idContenedor);
	layout_memoria_gasto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_gasto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_Save=this.Save;
	var ClaseMadre_getDialog=this.getDialog;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_grid=this.getGrid;
	

	
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/mem_inversion_gasto/ActionEliminarMemoriaGasto.php'},//parametros:'&m_id_memoria_calculo='+maestro.id_memoria_calculo},
	Save:{url:direccion+'../../../control/mem_inversion_gasto/ActionGuardarMemoriaGasto.php'},//parametros:'&m_id_memoria_calculo='+maestro.id_memoria_calculo},
	ConfirmSave:{url:direccion+'../../../control/mem_inversion_gasto/ActionGuardarMemoriaGasto.php'},//parametros:'&m_id_memoria_calculo='+maestro.id_memoria_calculo},
	Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:300,
		width:480,
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Memoria de Gastos x Item',
		guardar:filtro,
		grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Filtrar',
				columna:0,
				id_grupo:1
			}]
	}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		
		maestro=m;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo
			}
		};
		
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};
		prueba.setValue(maestro.id_moneda);
			
		this.btnActualizar();		
		
		Atributos[6].defecto=maestro.id_memoria_calculo;
		Atributos[8].defecto=maestro.id_moneda;
		CM_mostrarComponente(h_periodo_pres);
		
		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		var CM_getBoton=this.getBoton;
		this.InitFunciones(paramFunciones);
		
		if(maestro.tipo_vista==2)
		{
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
		}
		else
		{
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
		}	
	};
	
	this.btnNew=function(){
		sw_filtro="false";		
		
		//En esta parte obtenemos el importe del concepto de ingreso o gasto
		importe_concepto=maestro.costo_estimado;
		
		//Si la moneda en la que se presupuesta es la moneda base
		if(maestro.id_moneda==1)
		{
			importe_final=importe_concepto;	
		}
		//Si la moneda del presupuesto es diferente a la moneda base
		else
		{			
			tipoDeCambio=maestro.tipo_cambio;
			importe_final = importe_concepto / tipoDeCambio;
			
			if(importe_final>=0)
			{importe_final=importe_final}
			else
			{importe_final=0;}		
		}
		Atributos[4].defecto=importe_final;	
		
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		ClaseMadre_btnNew();		
	};
	
	this.Save=function(){		
			
		ClaseMadre_Save()			
	};	
		
	function filtro()
	{	if (sw_filtro=="true")
		{	
			ds.baseParams={valor_filtro:parseFloat(h_id_moneda.getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});
			dialog.hide();
		}
		else
		{
			ClaseMadre_save();
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		dialog=ClaseMadre_getDialog();
		h_id_moneda=ClaseMadre_getComponente('id_moneda');//texto
		h_cantidad=ClaseMadre_getComponente('cantidad');//texto
		h_costo_unitario=ClaseMadre_getComponente('costo_unitario');//texto
		h_total_general=ClaseMadre_getComponente('total_general');//texto
		h_tipo_mem=ClaseMadre_getComponente('tipo_mem');//texto
		h_id_memoria_calculo=ClaseMadre_getComponente('id_memoria_calculo');//texto
		h_tipo_insercion=ClaseMadre_getComponente('tipo_insercion');//texto
		h_periodo_pres=ClaseMadre_getComponente('periodo_pres');//texto
		
		CM_ocultarComponente(h_tipo_mem);
		CM_ocultarComponente(h_id_memoria_calculo);
		CM_mostrarComponente(h_periodo_pres);
		Atributos[5].defecto=1;	//Tipo memoria por defecto es gasto
		Atributos[1].defecto=1;	//Tipo memoria por defecto es gasto
		
		function costoTotal(){
			var multiplicacion;			
			multiplicacion=parseFloat(h_cantidad.getValue()) * parseFloat(h_costo_unitario.getValue());
			h_total_general.setValue(multiplicacion)
		}		
		
		h_cantidad.on('blur', costoTotal);
		h_costo_unitario.on('blur', costoTotal);
		
		//h_cantidad.afteredit	
						
		function insercion(){
			//Insercion en un mes especifico
			if(h_tipo_insercion.getValue()=='1')
			{
				CM_mostrarComponente(h_periodo_pres);
			}
			else //Insercion en los doce meses 
			{				
				CM_ocultarComponente(h_periodo_pres);
			}
		}
		h_tipo_insercion.on('change',insercion);	
		h_tipo_insercion.on('select',insercion);
	}

	var prueba=new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			editable:false,			
			tpl:tpl_id_moneda			
	});
	
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	
	prueba.on('select',	function(){				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});			
	});	
	
	/*function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}*/

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_gasto.getLayout()};
	
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-proce.bmp','Cambia la Moneda para Consultar los Importes',btn_moneda_datos,true,'moneda_datos','Moneda de Consulta');
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_gasto.getLayout().addListener('layout',this.onResize);
	layout_memoria_gasto.getVentana(idContenedor).on('resize',function(){layout_memoria_gasto.getLayout().layout()});
	
	//layout_memoria_gasto.getVentana().addListener('beforehide',salta)
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}