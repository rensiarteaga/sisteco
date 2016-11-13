<?php 
/**
 * Nombre:		  	    inventario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-30 18:41:53
 *
 */
session_start();
?>
//<script>
function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_inventario_conclusion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_inventario_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-30 18:41:53
 */
function pagina_inventario_conclusion(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var ds,combo_almacen,combo_almacen_ep,combo_almacen_logico,combo_responsable_almacen,combo_almacenero,txt_fecha_reg;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	//  DATA STORE //
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/inventario/ActionListarInventarioConclusion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_inventario',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_inventario',
		'observaciones',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'tipo_inventario',
		'id_almacen',
		'desc_almacen',
		'id_responsable_almacen',
		'desc_responsable_almacen',
		'id_almacen_ep',
		'desc_almacen_ep',
		'desc_almacen_logico',
		'id_almacen_logico',
		'estado',
		'id_almacenero',
		'desc_almacenero'
		]),remoteSort:true});
//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros	}
	});
	//DATA STORE COMBOS
    ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen',
			totalRecords: 'TotalCount'
		}, ['id_almacen','codigo','nombre','descripcion','direccion','via_fil_max','via_col_max','bloqueado','cerrado','nro_prest_pendientes','nro_ing_no_finalizados','nro_sal_no_finalizadas','observaciones','fecha_ultimo_inventario','fecha_reg','id_regional'])
	});
    ds_responsable_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/responsable_almacen/ActionListarResponsableAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_responsable_almacen',
			totalRecords: 'TotalCount'
		}, ['id_responsable_almacen','estado','cargo','fecha_asignacion','fecha_reg','observaciones','id_almacen','id_empleado'])
	});
	ds_almacenero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/responsable_almacen/ActionListarResponsableAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_responsable_almacen',
			totalRecords: 'TotalCount'
		}, ['id_responsable_almacen','estado','cargo','fecha_asignacion','fecha_reg','observaciones','id_almacen','id_empleado'])
	}); 
    ds_almacen_ep = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_ep/ActionListarAlmacenEp.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_ep',
			totalRecords: 'TotalCount'
		}, ['id_almacen_ep','descripcion','observaciones','fecha_reg','id_almacen','bloqueado','cerrado','id_fina_regi_prog_proy_acti'])
	});
    ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogico.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_logico',
			totalRecords: 'TotalCount'
		}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen','cerrado'])
	});
	//FUNCIONES RENDER
			function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
			function render_id_responsable_almacen(value, p, record){return String.format('{0}', record.data['desc_responsable_almacen']);}
			function render_id_almacenero(value, p, record){return String.format('{0}', record.data['desc_almacenero']);}		
			function render_id_almacen_ep(value, p, record){return String.format('{0}', record.data['desc_almacen_ep']);}
			function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
			var resultTplResponsableAlmacen=new Ext.Template(
	        '<div class="search-item">',
	        '<b><i>{cargo}</i></b>',
	        '<br><FONT COLOR="#B5A642"><b>Nombre: </b>{nombre_completo}</FONT>',
	         '</div>'
	         );
	// Definición de datos //
	// hidden id_inventario
	//en la posición 0 siempre esta la llave primaria
vectorAtributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_inventario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_inventario'
	};
	// txt id_almacen
    filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	filterCols_almacen[0]='bloqueado';
	filterValues_almacen[0]='si';
	vectorAtributos[1]={
			validacion: {
			name:'id_almacen',
			fieldLabel:'Almacen',
			allowBlank:false,			
			emptyText:'Id Almacen...',
			desc: 'desc_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.codigo#ALMACE.descripcion',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
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
		    renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.nombre',
		defecto: '',
		save_as:'txt_id_almacen'
	};
	// txt id_almacen_ep
    filterCols_almacen_ep=new Array();
	filterValues_almacen_ep=new Array();
	filterCols_almacen_ep[0]='ALMACE.id_almacen';
	filterValues_almacen_ep[0]='%';
	filterCols_almacen_ep[1]='ALMAEP.bloqueado';
	filterValues_almacen_ep[1]='si';
	vectorAtributos[2]={
			validacion: {
			name:'id_almacen_ep',
			fieldLabel:'Almacen EP',
			allowBlank:true,			
			emptyText:'Id Almacen EP...',
			desc: 'desc_almacen_ep', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_ep,
			valueField: 'id_almacen_ep',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'ALMAEP.descripcion#ALMAEP.observaciones',
			filterCols:filterCols_almacen_ep,
			filterValues:filterValues_almacen_ep,
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
			renderer:render_id_almacen_ep,
			grid_visible:false,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMAEP.descripcion',
		defecto: '',
		save_as:'txt_id_almacen_ep'
	};
	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[1]='ALMAEP.id_almacen_ep';
	filterValues_almacen_logico[1]='%';
	filterCols_almacen_logico[2]='ALMLOG.bloqueado';
	filterValues_almacen_logico[2]='si';
	vectorAtributos[3]={
			validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacen Logico',
			allowBlank:true,			
			emptyText:'Id Almacen Logico...',
			desc: 'desc_almacen_logico', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
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
			renderer:render_id_almacen_logico,
			grid_visible:false,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
		defecto: '',
		save_as:'txt_id_almacen_logico'
	};
	// txt id_responsable_almacen
	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	filterCols_almacen[0]='RESALM.id_almacen';
	filterValues_almacen[0]='%';
	vectorAtributos[4]={
			validacion: {
			name:'id_responsable_almacen',
			fieldLabel:'Encaragado del Inventario',
			allowBlank:false,			
			emptyText:'Id Responsable...',
			desc: 'desc_responsable_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_responsable_almacen,
			valueField: 'id_responsable_almacen',
			displayField: 'nombre_completo',
			queryParam: 'filterValue_0',
			filterCol:'RESALM.cargo',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
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
			renderer:render_id_responsable_almacen,
			grid_visible:true,
			grid_editable:false,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'RESALM.cargo#PER.nombre#PER.apellido_paterno#PER.apellido_materno',
		defecto: '',
		save_as:'txt_id_responsable_almacen'
	};
	 // txt id_responsable_almacen
	filterCols_almacen1=new Array();
	filterValues_almacen1=new Array();
	filterCols_almacen1[0]='RESALM.id_almacen';
	filterValues_almacen1[0]='%';
	vectorAtributos[5]={
			validacion: {
			name:'id_almacenero',
			fieldLabel:'Responsable del Conteo',
			allowBlank:false,			
			emptyText:'Id Almacenero...',
			desc: 'desc_almacenero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacenero,
			valueField: 'id_responsable_almacen',
			displayField: 'nombre_completo',
			queryParam: 'filterValue_0',
			filterCol:'RESALM1.cargo',
			filterCols:filterCols_almacen1,
			filterValues:filterValues_almacen1,
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
			renderer:render_id_almacenero,
			grid_visible:true,
			grid_editable:false,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'RESALM1.cargo#PER1.nombre#PER.apellido_paterno#PER.apellido_materno',
		defecto: '',
		save_as:'txt_id_almacenero'
	};
	/////////// txt tipo_inventario //////
	vectorAtributos[6]={
		validacion: {
			name: 'tipo_inventario',
			fieldLabel: 'Tipo de Inventario',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields:['id', 'valor'],data:Ext.inventarioCombo.tipo}),
			store: new Ext.data.SimpleStore({fields:['id', 'valor'],data:[
			                                                      		['total', 'total'],        
			                                                            ['parcial', 'parcial']
			                                                            
			                                                    ]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:110, // ancho de columna en el grid
			width:65
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'INVENT.tipo_inventario',
		save_as:'txt_tipo_inventario',
		defecto:"total"
	};
	/////////// txt tipo_inventario //////
	vectorAtributos[7]={
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields:['id', 'valor'],data:Ext.inventarioCombo.estado}),
			store: new Ext.data.SimpleStore({fields:['id', 'valor'],data:[['Borrador','Borrador'],['Proceso','Proceso'],['Concluido','Concluido'],['Revision','Revision'],['Reconteo','Reconteo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:110, // ancho de columna en el grid
			width:65
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'INVENT.estado',
		save_as:'txt_estado',
		defecto:"Conclusion"
	};
	// txt observaciones
	vectorAtributos[8]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:false,
		filterColValue:'INVENT.observaciones',
		save_as:'txt_observaciones'
	};
	// txt fecha_inicio
	vectorAtributos[9]={
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha de Inicio del Inventario',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:180,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'INVENT.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_inicio'
	};
	// txt fecha_fin
	vectorAtributos[10]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Finalizacion del Inventario',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:180,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'INVENT.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_fin'
	};
	// txt fecha_reg
	vectorAtributos[11]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'INVENT.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	var config = {	titulo_maestro:'Inventario',
		grid_maestro:'grid-'+idContenedor
	};
	layout_inventario=new DocsLayoutMaestro(idContenedor);
	layout_inventario.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_inventario,idContenedor);
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
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/inventario/ActionEliminarInventario.php'},
		Save:{url:direccion+'../../../control/inventario/ActionGuardarInventario.php'},
		ConfirmSave:{url:direccion+'../../../control/inventario/ActionGuardarInventario.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'60%',
		width:'50%',
		minWidth:150,
		minHeight:200,
		closable:true,titulo:'Inventario'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_inventario_det(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_inventario='+SelectionsRecord.data.id_inventario;
			data=data+'&m_tipo_inventario='+SelectionsRecord.data.tipo_inventario;
			data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
			var ParamVentana={Ventana:{width:'85%',height:'65%'}}
			layout_inventario.loadWindows(direccion+'../../../vista/inventario_conclusion_detalle/inventario_conclusion_detalle.php?'+data,'Inventario Detalle',ParamVentana);
layout_inventario.getVentana().on('resize',function(){
			layout_inventario.getLayout().layout();
				})	}
	else
	{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_almacen = ClaseMadre_getComponente('id_almacen');
		combo_almacen_ep = ClaseMadre_getComponente('id_almacen_ep');
		combo_almacen_logico = ClaseMadre_getComponente('id_almacen_logico');
		combo_responsable_almacen=ClaseMadre_getComponente('id_responsable_almacen');
		combo_almacenero=ClaseMadre_getComponente('id_almacenero');
		txt_fecha_reg=ClaseMadre_getComponente('fecha_reg');
		    var onAlmacenSelect = function(e) {
			var id = combo_almacen.getValue()
			combo_almacen_ep.filterValues[0] =  id;
			combo_almacen_ep.modificado = true;
			combo_responsable_almacen.filterValues[0]=id;	
			combo_responsable_almacen.modificado = true;
			combo_almacenero.filterValues[0]=id;		
			combo_almacenero.modificado = true
			};
		var onAlmacenEpSelect = function(e) {
			var id = combo_almacen_ep.getValue()
			combo_almacen_logico.filterValues[0] =  id;
			combo_almacen_logico.modificado = true
			};
		combo_almacen.on('select', onAlmacenSelect);
		combo_almacen.on('change', onAlmacenSelect);
		combo_almacen_ep.on('select', onAlmacenEpSelect);
		combo_almacen_ep.on('change', onAlmacenEpSelect)
		}
	function iniciarPaginaInventario()
	{	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
		componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name)
		}
	}
  this.btnNew = function()
	{   CM_ocultarComponente(combo_almacen_ep);
	    CM_ocultarComponente(combo_almacen_logico);
		CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnNew()}	
  this.btnEdit = function()
	{    CM_ocultarComponente(combo_almacen_ep);
	     CM_ocultarComponente(combo_almacen_logico);
		 CM_ocultarComponente(txt_fecha_reg);
		ClaseMadre_btnEdit()}	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_inventario.getLayout()};
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
		//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
		        this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_inventario_det,true,'inventario_det','Inventario Detalle');
		        this.iniciaFormulario();
				iniciarEventosFormularios();
				layout_inventario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}