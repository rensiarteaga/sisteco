/**
 * Nombre:		  	    pagina_horario_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_horario(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,ds_tipo_horario,ds_vacacion;
	var elementos=new Array();
	var layout_horario;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/horario/ActionListarHorario.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_horario',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_horario',
		'id_tipo_horario',
		'nombre_tipo_horario',		
		'id_vacacion',
		'id_categoria_vacacion',		
		'nombre_cat_vacacion',
		{name:'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'numero_periodo',
		'horas_por_dia',
		'hora_ini_p1',		
		'hora_fin_p1',
		'hora_ini_p2',		
		'hora_fin_p2',
		'tipo_periodo',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},	
		'observaciones',
		'repite_anualmente',
		'estado_reg'
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
    ds_tipo_horario=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/tipo_horario/ActionListarTipoHorario.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_horario',
			totalRecords: 'TotalCount'
		},['id_tipo_horario','codigo','nombre','fecha_reg'])
	});
    ds_vacacion=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/vacacion/ActionListarVacacion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_vacacion',
			totalRecords: 'TotalCount'
		},['id_vacacion','id_empleado','id_persona','desc_persona','id_categoria_vacacion','desc_cat_vacacion','total_dias','id_gestion'])
	});    
	//FUNCIONES RENDER	
	function render_id_tipo_horario(value,p,record){return String.format('{0}',record.data['nombre_tipo_horario'])}	
	function render_id_vacacion(value,p,record){return String.format('{0}',record.data['nombre_cat_vacacion'])}	
	// Definición de datos //		
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_horario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_horario'
	};
	
	// txt id_tipo_horario
	vectorAtributos[1]={
			validacion: {
			name:'id_tipo_horario',
			fieldLabel:'Tipo Horario',
			allowBlank:false,			
			desc:'nombre_tipo_horario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_horario,
			valueField:'id_tipo_horario',
			displayField:'nombre',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_horario,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPHOR.nombre',
		defecto:'',
		save_as:'hidden_id_tipo_horario'
	};
	// txt id_vacacion
	vectorAtributos[2]={
		validacion:{
			labelSeparator:'',
			name:'id_vacacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_vacacion'
	};
	// txt fecha_inicio
	vectorAtributos[3]= {	
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100
		},
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.fecha_inicio',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_inicio'	
	};
	// txt fecha_inicio
	vectorAtributos[4]= {	
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100
		},
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.fecha_fin',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_fin'	
	};
	// txt numero_periodo
	vectorAtributos[5]={
		validacion:{
			name:'numero_periodo',
			fieldLabel:'Periodo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.numero_periodo',	
		save_as:'txt_numero_periodo'
	};
	
	// txt horas_por_dia
	vectorAtributos[6]={
		validacion:{
			name:'horas_por_dia',
			fieldLabel:'Horas por Día',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			locked:false,
			width_grid:60
		},
		tipo:'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.horas_por_dia',
		save_as:'txt_horas_por_dia'
	};
	
	// txt hora_ini_p1
	vectorAtributos[7]={
		validacion:{
			name:'hora_ini_p1',
			fieldLabel:'Hora Inicio P1',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.hora_ini_p1',
		save_as:'txt_hora_ini_p1'
	};
	// txt hora_fin_p1
	vectorAtributos[8]={
		validacion:{
			name:'hora_fin_p1',
			fieldLabel:'Hora Fin P1',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.hora_fin_p1',
		save_as:'txt_hora_fin_p1'
	};
	// txt hora_ini_p1
	vectorAtributos[9]={
		validacion:{
			name:'hora_ini_p2',
			fieldLabel:'Hora Inicio P2',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.hora_ini_p2',
		save_as:'txt_hora_ini_p2'
	};
	// txt hora_fin_p1
	vectorAtributos[10]={
		validacion:{
			name:'hora_fin_p2',
			fieldLabel:'Hora Fin P2',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.hora_fin_p2',
		save_as:'txt_hora_fin_p2'
	};
	// txt tipo_periodo
	vectorAtributos[11]={
		validacion:{
			name:'tipo_periodo',			
			fieldLabel:'Tipo Periodo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['manana_tarde','Mañana y Tarde'],['manana','Mañana'],['tarde','Tarde'],['noche','Noche']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_tipo_periodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:100			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.tipo_periodo',
		save_as:'txt_tipo_periodo'
	};
	vectorAtributos[12]= {	
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100
		},
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.fecha_reg',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_reg'	
	};
	vectorAtributos[13]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:150
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.observaciones',
		save_as:'txt_observaciones'
	};		
	vectorAtributos[14]= {
		validacion: {
			name:'repite_anualmente',			
			fieldLabel:'Repite',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_repite_anualmente,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.repite_anualmente',
		save_as:'txt_repite_anualmente'
	};
	vectorAtributos[15]= {
		validacion: {
			name:'estado_reg',			
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['borrador','Borrador'],['validado','Validado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.estado_reg',
		save_as:'txt_estado_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	function render_repite_anualmente(value){
		if(value=='si'){value='Si'	}
		else{	value='No'		}
		return value
	}
	function render_tipo_periodo(value){
		if(value=='manana_tarde'){value='Mañana y Tarde'	}
		else{if (value=='manana'){
			value='Mañana'
		}
		else{if (value=='tarde'){
			value='Tarde'
		}
		else{
			value='Noche'
		}
		}
		}
		return value
	}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Tipo de Horario',grid_maestro:'grid-'+idContenedor};
	var layout_horario=new DocsLayoutMaestro(idContenedor);
	layout_horario.init(config);
	
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_horario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/horario/ActionEliminarHorario.php'},
		Save:{url:direccion+'../../../control/horario/ActionGuardarHorario.php'},
		ConfirmSave:{url:direccion+'../../../control/horario/ActionGuardarHorario.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Horario'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//Para manejo de eventos
		
	this.btnNew=function()
	{				
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function()
	{
		ClaseMadre_btnEdit()
	};	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_horario.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
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
	this.iniciaFormulario();
	layout_horario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}