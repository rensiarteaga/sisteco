/**
* Nombre:		  	    pagina_devengar_pasaje.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:59:44
*/
function pagina_devengar_pasaje(idContenedor,direccion,paramConfig,tipoFormDev){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var g_id_gestion;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'numero',
		fieldLabel:'No.',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0}	
	); 

	//tipoFormDev-> dev, pag, detpag, fin

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado_detalle/ActionListarDevPasaje.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cuenta_doc_det',totalRecords:'TotalCount'
		},['id_cuenta_doc_det',
		'sw_select',
		'pasaje_orden',
		'nota_debito',
		'importe',
		'pasaje_cobrar',
		'pasaje_credito',
		'importe_total',
		'partida',
		'desc_presupuesto',
		'pasaje_nro',
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'recorrido',
		'res_pago',
		'res_dev',
		'nro_documento'
		]),remoteSort:true
	});
	
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},
			['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_vigente:'si'}}); 
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?tesoro=1&usuario=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});
	
	//FUNCIONES RENDER
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)		 
	}
	
	function render_id_depto(value, p, record){
		return String.format('{0}', record.data['desc_depto']);
	}
	
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');
//return monedas_for.formatMoneda(value)
	function render_total(value,cell,record,row,colum,store){
		if(store.getAt(row).data['id_cuenta_doc_det'] == 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(store.getAt(row).data['id_cuenta_doc_det'] > 0){
			if(store.getAt(row).data['sw_select'] == 1){
				return  '<span style="color:blue;">' +monedas_for.formatMoneda(value)+'</span>'}	
				if(store.getAt(row).data['sw_select'] != 1){return monedas_for.formatMoneda(value)}
		}
	}
	
	function render_total_txt(value,cell,record,row,colum,store){
		if(store.getAt(row).data['id_cuenta_doc_det'] == 0){
		return  '<span style="color:red;">' +value+ '</span>'}	
		if(store.getAt(row).data['id_cuenta_doc_det'] > 0){
			if(store.getAt(row).data['sw_select'] == 1){
				return  '<span style="color:blue;">' +value+ '</span>'}	
				if(store.getAt(row).data['sw_select'] != 1){return value}
		}
	}
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	function formatValida(value){
		if (value==1) return 'Si';
		else return 'No'
	};

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado
	//en la posición 0 siempre esta la llave primaria


	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_det',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'Pagar',
			name:'sw_select',
			checked:false,
			renderer:formatValida,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60
		},
		tipo:'Checkbox',
		form:true
	};

	Atributos[2]={
		validacion:{
			fieldLabel:'Partida',
			name: 'partida',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'partida',
		form:false
	};
	
	Atributos[3]={
		validacion:{
			fieldLabel:'Nº Orden',
			name: 'pasaje_orden',
			grid_visible:false,
			grid_editable:false,
			width_grid:60
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[4]={
		validacion:{
			fieldLabel:'Nota(s) Débito',
			name: 'nota_debito',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:true,
		form:false
	};

	Atributos[5]={
		validacion:{
			fieldLabel:'Nro. de Boleto(s)',
			name: 'pasaje_nro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:true,
		form:false
	};
	
	Atributos[6]={
		validacion:{
			fieldLabel:'Importe',
			name: 'importe',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			renderer: render_total
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false
	};

	Atributos[7]={
		validacion:{
			fieldLabel:'Por Cobrar',
			name: 'pasaje_cobrar',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			renderer: render_total
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false
	};

	Atributos[8]={
		validacion:{
			fieldLabel:'Sin Credito',
			name: 'pasaje_credito',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			renderer: render_total
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false
	};

	Atributos[9]={
		validacion:{
			fieldLabel:'Importe Total',
			name: 'importe_total',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			renderer: render_total
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:false
	};

	Atributos[10]={
		validacion:{
			fieldLabel:'Solicitud de Viaje',
			name: 'nro_documento',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			renderer: render_total_txt
		},
		tipo:'Field',
		filtro_0:true,
		form:false,
		filterColValue:'nro_documento',
	};
	
	Atributos[11]={
		validacion:{
			fieldLabel:'Presupuesto',
			name: 'desc_presupuesto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'PRESUP.desc_presupuesto',
		form:false
	};
	
	Atributos[12]={
		validacion:{
			fieldLabel:'Fecha Solicitud',
			name: 'fecha_sol',
			align:'center',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			renderer: formatDate
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[13]={
		validacion:{
			fieldLabel:'Ruta',
			name: 'recorrido',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[14]={
		validacion:{
			fieldLabel:'Reportado por',
			name: 'res_pago',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'USUA.nombre_completo',
		form:false
	};

	Atributos[15]={
		validacion:{
			fieldLabel:'Responsable',
			name: 'res_dev',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
		
	// txt id_depto
	Atributos[16]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Tesorería',
			allowBlank:false,			
			emptyText:'Departamento de Tesorería...',
			desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'codigo_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:true,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:250,
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Devengar Pasajes',grid_maestro:'grid-'+idContenedor};
	var layout_devengar_pasaje=new DocsLayoutMaestro(idContenedor);
	layout_devengar_pasaje.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_devengar_pasaje,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_save=this.Save;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnActualizar = this.btnActualizar;
	var CM_conexionFailure = this.conexionFailure
	var CM_ocultarComp=this.ocultarComponente;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false},
		guardar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		ConfirmSave:{url:direccion+'../../../control/devengado_detalle/ActionDevPasajeSel.php'},
		Save:{url:direccion+'../../../control/devengado_detalle/ActionDevPasajePro.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:420,minWidth:150,minHeight:200,	closable:true,titulo:'Pasajes a Devengar'}
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	}
	
	function InitPaginaDevPasaje(){
		for(var i=0; i<Atributos.length; i++){	
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		CM_ocultarComp(componentes[1]);
	}
	
	var gestion = new Ext.form.ComboBox({
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_gestion',
			tpl:tpl_gestion
		});

	gestion.on('select',function (combo, record, index){
		g_id_gestion = gestion.getValue();
		ds.baseParams = {m_gestion:g_id_gestion};
	
  		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_gestion:g_id_gestion
		}});
  	});

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengar_pasaje.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	//para agregar botones
	function btnPagaPasaje(){
		CM_btnNew();
	}
	
	function btn_RepPasaje() {
		var sm = getSelectionModel();
		if(sm.getCount()!=0){
			var id_cuenta_doc_det = sm.getSelected().data.id_cuenta_doc_det;
			window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionPasajeDev_Jasper.php?id_cuenta_doc_det='+id_cuenta_doc_det)
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	this.AdicionarBotonCombo(gestion,'gestion');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Detalle de Pagos Confirmados',btn_RepPasaje,false,'reporte','Reporte Detalle');
	this.AdicionarBoton("../../../lib/imagenes/a_table_gear.png",'Pagar Pasajes',btnPagaPasaje,true, 'pasaje','Pagar Pasajes');
	
	this.iniciaFormulario();
	InitPaginaDevPasaje();
	iniciarEventosFormularios();
	
	layout_devengar_pasaje.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}