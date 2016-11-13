/**
 * Nombre:		  	    pagina_memoria_recurso.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-11 09:20:34
 */
function pagina_memoria_recurso(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var sw_filtro;
	var dialog;
	
	var tipoDeCambio;
	var importe_concepto;
	var importe_final;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/mem_ingreso/ActionListarRecurso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_mem_ingreso',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_mem_ingreso',
			'periodo_pres',
			'id_memoria_calculo',
			'desc_memoria_calculo',
			'id_moneda',
			'desc_moneda',
			'total_general'
		]),remoteSort:true});
		
	/*ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1}		

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_memoria_calculo:maestro.id_memoria_calculo			
		}
	});
	
	function tabular(n)
	{ 
		if (n>=0)	
		{	
			return "  "+tabular(n-1)
		}
		else return "  "
	}*/
	// DEFINICIÓN DATOS DEL MAESTRO
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	/*var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(40-maestro.tipo_pres.length)],['Presupuestar en',maestro.desc_moneda+tabular(50-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa],
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
	*/
	//DATA STORE COMBOS
    /*var ds_memoria_calculo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_memoria_calculo',totalRecords: 'TotalCount'},['id_memoria_calculo','justificacion','tipo_detalle','id_concepto_ingas','id_partida_presupuesto'])
	});*/

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});

	//FUNCIONES RENDER
	
	function render_id_memoria_calculo(value, p, record){return String.format('{0}', record.data['desc_memoria_calculo']);}
	var tpl_id_memoria_calculo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{justificacion}</FONT><br>','</div>');

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
	
	// hidden id_mem_ingreso
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_ingreso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_ingreso'
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
			allowBlank:true,
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
			width_grid:150,
			minListWidth:100,
			disable:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.periodo_pres',
		//defecto:1,
		id_grupo:0,
		save_as:'periodo_pres'
	};			

	// txt id_memoria_calculo
	Atributos[3]={
		validacion:{
			name:'id_memoria_calculo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		//defecto:maestro.id_memoria_calculo,
		id_grupo:0,
		save_as:'id_memoria_calculo'
	};
	
	// txt total_general
	Atributos[4]={
		validacion:{
			name:'total_general',
			fieldLabel:'Importe Mensual',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:150,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMING.total_general',
		id_grupo:0,
		save_as:'total_general'
	};
	
// txt id_moneda
	Atributos[5]={
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
		filterColValue:'MONEDA.nombre',
		//defecto:maestro.id_moneda,
		id_grupo:1,
		save_as:'id_moneda'
	};

	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria Calculo (Maestro)',titulo_detalle:'Memoria de Recursos (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var layout_memoria_recurso = new DocsLayoutMaestro(idContenedor);
	layout_memoria_recurso.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_recurso,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_Save=this.Save;
	var ClaseMadre_getDialog=this.getDialog;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

		
	//DEFINICIÓN DE FUNCIONES
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/mem_ingreso/ActionEliminarRecurso.php'},
	Save:{url:direccion+'../../../control/mem_ingreso/ActionGuardarRecurso.php'},
	ConfirmSave:{url:direccion+'../../../control/mem_ingreso/ActionGuardarRecurso.php'},
	Formulario:{
		titulo:'Memoria de Recursos',
		html_apply:'dlgInfo-'+idContenedor,
		height:250,
		width:480,
		minWidth:150,
		minHeight:200,	
		closable:true,
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
		}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		
		maestro=m;
		//var datos=Ext.urlDecode(decodeURIComponent(unescape(params)));
		/*maestro.id_memoria_calculo=datos.m_id_memoria_calculo;	
		
		maestro.tipo_pres=datos.m_tipo_pres;	//Recargamos el valor del concepto
		maestro.desc_moneda=datos.m_desc_moneda;	//Recargamos el valor de la moneda
		maestro.id_moneda=datos.m_id_moneda;	//Recargamos el id de la moneda
		
		maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
		maestro.nombre_programa=datos.m_nombre_programa;
		maestro.nombre_regional=datos.m_nombre_regional;
		maestro.nombre_proyecto=datos.m_nombre_proyecto;
		maestro.nombre_financiador=datos.m_nombre_financiador;
		maestro.nombre_actividad=datos.m_nombre_actividad;
		maestro.tipo_vista=datos.m_tipo_vista;*/
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo
			}
		};
		prueba.setValue(maestro.id_moneda);
		
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1}	
		this.btnActualizar();
		
		/*data_maestro=[ ['Presupuesto de',maestro.tipo_pres+tabular(40-maestro.tipo_pres.length)],['Presupuestar en',maestro.desc_moneda+tabular(50-maestro.desc_moneda.length)],
					   ['Unidad',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa],
					   ['Regional',maestro.nombre_regional ],['Subprograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];*/
		
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[3].defecto=maestro.id_memoria_calculo;
		Atributos[5].defecto=maestro.id_moneda;

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
		if(maestro.id_moneda==1)		//Si la moneda en la que se presupuesta es la moneda base
		{
			importe_final=importe_concepto;	
		}
		else							//Si la moneda del presupuesto es diferente a la moneda base
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
		h_tipo_insercion=ClaseMadre_getComponente('tipo_insercion');//texto
		h_periodo_pres=ClaseMadre_getComponente('periodo_pres');//texto
		
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
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_recurso.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto
	/*var CM_getBoton=this.getBoton;
		
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
	}*/	
//Fin codigo de bloqueo de botones
	
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-proce.bmp','Cambia la Moneda para Consultar los Importes',btn_moneda_datos,true,'moneda_datos','Moneda de Consulta');
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_recurso.getLayout().addListener('layout',this.onResize);
	layout_memoria_recurso.getVentana(idContenedor).on('resize',function(){layout_memoria_recurso.getLayout().layout()});

	//layout_memoria_recurso.getVentana().addListener('beforehide',salta)
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}