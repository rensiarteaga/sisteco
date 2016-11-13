/**
* Nombre:		  	    pagina_orden_ingreso_sol.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-17 12:31:23
*/
function pagina_orden_ingreso_sol_extra(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var componentes=new Array();
	var data_ep;
	var ds;
	var elementos=new Array();
	var sw=0;
	var tipo_ord='Extraordinario';

	var combo_almacen,combo_almacen_logico,combo_solicitante,combo_institucion,combo_motivo_ingreso,combo_motivo_ingreso_cuenta,cmb_ep;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ingreso/ActionListarOrdenIngresoSol.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_ingreso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_ingreso',
		'descripcion',
		'costo_total',
		'estado_ingreso',
		'cod_inf_tec',
		'resumen_inf_tec',
		{name: 'fecha_borrador',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_proveedor',
		'desc_proveedor',
		'id_contratista',
		'desc_contratista',
		'id_empleado',
		'desc_empleado',
		'id_almacen_logico',
		'desc_almacen_logico',
		'id_institucion',
		'desc_institucion',
		'id_motivo_ingreso_cuenta',
		'desc_motivo_ingreso_cuenta',
		'nombre_proveedor',
		'nombre_contratista',
		'nro_cuenta',
		'desc_motivo_ingreso',
		'desc_almacen',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'orden_compra',
		'observaciones',
		'id_usuario',
		'contabilizar_tipo_almacen'
		]),remoteSort:true
	});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo:tipo_ord
		}
	});

	//DATA STORE COMBOS

	ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'idalmacen',
		totalRecords: 'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEPM.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen_logico',
		totalRecords: 'TotalCount'
	}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])
	});

	ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_institucion',
		totalRecords: 'TotalCount'
	}, ['id_institucion','direccion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});

	ds_motivo_ingreso_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso_cuenta/ActionListarMotivoIngresoCuenta.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_ingreso_cuenta',
		totalRecords: 'TotalCount'
	}, ['id_motivo_ingreso_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
	});

	ds_motivo_ingreso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngresoEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_ingreso',
		totalRecords: 'TotalCount'
	}, ['id_motivo_ingreso','nombre','descripcion','fecha_reg'])
	});


	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	function render_id_motivo_ingreso_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso_cuenta']);}
	function render_id_motivo_ingreso(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso']);}

	//Template combo
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	var resultTplInstitucion = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{email1}','<br>{pag_web}','<br>{direccion}</FONT>','</div>');
	var resultTplMotivoIngreso = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplMotivoIngresoCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_ingreso',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_ingreso'
	};

	filterCols_almacen=new Array();
	filterValues_almacen=new Array();
	//txt almacen
	vectorAtributos[1]= {
		validacion: {
			name:'id_almacen',
			fieldLabel:'Almacén Físico',
			allowBlank:true,
			emptyText:'Almacén Físico...',
			name: 'id_almacen',
			desc: 'desc_almacen',
			store:ds_almacen,
			valueField: 'id_almacen',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			filterCols:filterCols_almacen,
			filterValues:filterValues_almacen,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,//'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMACE.nombre',
		defecto: '',
		save_as:'txt_id_almacen',
		id_grupo:3
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';

	vectorAtributos[2]= {
		validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:false,
			emptyText:'Almacén Lógico...',
			name: 'id_almacen_logico',
			desc: 'desc_almacen_logico',
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMLOG.nombre',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:3
	};

	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			width:'100%',
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:3,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'INGRES.descripcion',
		save_as:'txt_descripcion',
		id_grupo:4
	};

	vectorAtributos[4]= {
		validacion:{
			name:'costo_total',
			fieldLabel:'Costo total',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:10,
			width_grid:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.costo_total',
		save_as:'txt_costo_total',
		id_grupo:4
	};

	vectorAtributos[5]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			width:'100%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:12,
			width_grid:100
		},
		tipo:'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'INGRES.observaciones',
		save_as:'txt_observaciones',
		id_grupo:4
	};

	vectorAtributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:13,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:4
	};

	vectorAtributos[7]= {
		validacion: {
			name:'solicitante',
			fieldLabel:'Solicitante',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.orden_ingreso_sol_combo.solicitante_extra}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['institucion','Institucion']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:60
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'',
		defecto:'Institucion',
		save_as:'',
		id_grupo:1
	};

	vectorAtributos[8]= {
		validacion: {
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,
			emptyText:'Institución...',
			name: 'id_institucion',
			desc: 'desc_institucion',
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.pag_web#INSTIT.email1#INSTIT.direccion',
			tpl: resultTplInstitucion,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:false,
			grid_indice:7,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		defecto: '',
		save_as:'txt_id_institucion',
		id_grupo:1
	};

	filterCols_motivo_ingreso=new Array();
	filterValues_motivo_ingreso=new Array();
	filterCols_motivo_ingreso[0]='MOTING.tipo'
	filterValues_motivo_ingreso[0]=tipo_ord

	vectorAtributos[9]= {
		validacion: {
			fieldLabel:'Motivo ingreso',
			allowBlank:true,
			emptyText:'Motivo Ingreso ...',
			name: 'id_motivo_ingreso',
			desc: 'desc_motivo_ingreso',
			store:ds_motivo_ingreso,
			valueField: 'id_motivo_ingreso',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MOTING.descripcion',
			tpl:resultTplMotivoIngreso,
			filterCols:filterCols_motivo_ingreso,
			filterValues:filterValues_motivo_ingreso,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_ingreso,
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MOTING.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_ingreso',
		id_grupo:2
	};

	filterCols_motivo_ingreso_cuenta=new Array();
	filterValues_motivo_ingreso_cuenta=new Array();
	filterCols_motivo_ingreso_cuenta[0]='MOTING.id_motivo_ingreso';
	filterValues_motivo_ingreso_cuenta[0]='x';

	vectorAtributos[10]={
		validacion: {
			name:'id_motivo_ingreso_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,
			emptyText:'Cuenta ...',
			name: 'id_motivo_ingreso_cuenta',
			desc: 'desc_motivo_ingreso_cuenta',
			store:ds_motivo_ingreso_cuenta,
			valueField: 'id_motivo_ingreso_cuenta',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MINGCU.descripcion',
			tpl:resultTplMotivoIngresoCuenta,
			filterCols:filterCols_motivo_ingreso_cuenta,
			filterValues:filterValues_motivo_ingreso_cuenta,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:350,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_ingreso_cuenta,
			grid_visible:true,
			grid_editable:false,
			grid_indice:5,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MOINCU.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_ingreso_cuenta',
		id_grupo:2
	};

	vectorAtributos[11]= {
		validacion:{
			fieldLabel: 'EP',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_visible:false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:14,
			width:350
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:0
	}

	vectorAtributos[12]={
		validacion:{
			name:'contabilizar_tipo_almacen',
			fieldLabel:'Contabilizar Tipo Almacen',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			grid_indice:10,
			align:'center',
			width_grid:100
		},
		tipo:'Field',
		save_as:'txt_contabilizar_tipo_almacen',
		id_grupo:0
	};

	vectorAtributos[13]={
		validacion:{
			name:'desc_almacen_logico',
			fieldLabel:'Desc Almacen Logico',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			grid_indice:10,
			align:'center',
			width_grid:100
		},
		tipo:'Field',
		save_as:'txt_desc_almacen_logico',
		id_grupo:0
	};

	vectorAtributos[14]={
		validacion:{
			name:'desc_almacen',
			fieldLabel:'Desc Almacen',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			grid_indice:10,
			align:'center',
			width_grid:100
		},
		tipo:'Field',
		save_as:'txt_desc_almacen',
		id_grupo:0
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Orden Ingreso - Extraordinario',
		grid_maestro:'grid-'+idContenedor
	};
	layout_orden_ingreso_sol=new DocsLayoutMaestro(idContenedor);
	layout_orden_ingreso_sol.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_orden_ingreso_sol,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;

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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/ingreso/ActionEliminarIngreso.php',parametros:'&tipo='+tipo_ord},
		Save:{url:direccion+'../../../control/ingreso/ActionGuardarOrdenIngresoSol.php',parametros:'&tipo='+tipo_ord},
		ConfirmSave:{url:direccion+'../../../control/ingreso/ActionGuardarOrdenIngresoSol.php',parametros:'&tipo='+tipo_ord},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',columnas:['96%'],
		grupos:[{tituloGrupo:'Estructura Programática',columna:0,id_grupo:0},
		{tituloGrupo:'Origen Orden Ingreso',columna:0,id_grupo:1},
		{tituloGrupo:'Motivo de Ingreso',columna:0,id_grupo:2},
		{tituloGrupo:'Almacén',columna:0,id_grupo:3},
		{tituloGrupo:'Datos ingreso',columna:0,id_grupo:4}
		],minWidth:150,minHeight:200,	closable:true,titulo:'Orden Ingreso - Devolución'}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.btnNew = function()
	{
		//Muestra el solicitante por defecto : empleado
		CM_ocultarComponente(componentes[12]);
		CM_ocultarComponente(componentes[13]);
		CM_ocultarComponente(componentes[14]);
		ClaseMadre_btnNew();
	};

	function btn_orden_ingreso_sol_det(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();

		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_ingreso='+SelectionsRecord.data.id_ingreso;
			data=data+'&m_almacen_fisico='+SelectionsRecord.data.desc_almacen;
			data=data+'&m_almacen_logico='+SelectionsRecord.data.desc_almacen_logico;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_contabilizar_tipo_almacen='+SelectionsRecord.data.contabilizar_tipo_almacen;
			var ParamVentana={Ventana:{width:'70%',height:'60%'}}
			layout_orden_ingreso_sol.loadWindows(direccion+'../../../vista/orden_ingreso_sol_det/orden_ingreso_sol_det.php?'+data,'Detalle Orden Ingreso',ParamVentana);
			layout_orden_ingreso_sol.getVentana().on('resize',function(){
				layout_orden_ingreso_sol.getLayout().layout()
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	//función para terminar la orden de ingreso
	function btn_fin_ord_ing()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();

		if(NumSelect!=0)
		{
			if(confirm("¿Está seguro de terminar la Solicitud de Orden de Ingreso?"))
			{
				var SelectionsRecord=sm.getSelected();
				var data=SelectionsRecord.data.id_ingreso
				Ext.Ajax.request({
					url:direccion+"../../../control/ingreso/ActionGuardarOrdenIngresoSolFin.php?tipo="+tipo_ord + "&hidden_id_ingreso_0="+data,
					method:'GET',
					success:terminado,
					failure:ClaseMadre_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}


	function terminado(resp)
	{
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Finalización satisfactoria de la Solicitud Orden de Ingreso.<br>');
		ClaseMadre_btnActualizar()
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_almacen = ClaseMadre_getComponente('id_almacen');
		combo_almacen_logico = ClaseMadre_getComponente('id_almacen_logico');
		combo_solicitante = ClaseMadre_getComponente('solicitante');
		combo_institucion = ClaseMadre_getComponente('id_institucion');
		combo_motivo_ingreso = ClaseMadre_getComponente('id_motivo_ingreso');
		combo_motivo_ingreso_cuenta = ClaseMadre_getComponente('id_motivo_ingreso_cuenta');
		cmb_ep=ClaseMadre_getComponente('id_ep');

		var onMotivoIngresoSelect = function(e) {
			var id = combo_motivo_ingreso.getValue();
			combo_motivo_ingreso_cuenta.filterValues[0] =  id;
			combo_motivo_ingreso_cuenta.modificado = true;
			combo_motivo_ingreso_cuenta.setValue('');
			combo_motivo_ingreso.modificado=true
		};

		var onAlmacenSelect = function(e) {
			var id = combo_almacen.getValue();
			if(id=='') id='x';
			combo_almacen_logico.filterValues[0] =  id;
			combo_almacen_logico.modificado = true;
			combo_almacen_logico.setValue('');
			combo_almacen.modificado=true
		};

		var onSolicitanteSelect = function(e) {
			var valor = combo_solicitante.getValue();
			if(valor == 'institucion'){
				CM_mostrarComponente(componentes[8])//institucion
			}
		};



		var onEpSelect = function(e){
			var ep=cmb_ep.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			combo_almacen.setValue('');
			combo_almacen_logico.setValue('');
			combo_motivo_ingreso.setValue('');
			combo_motivo_ingreso_cuenta.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			combo_almacen.modificado=true;
			combo_almacen_logico.modificado=true;
			combo_motivo_ingreso.modificado=true;
			combo_motivo_ingreso_cuenta.modificado=true
		};

		combo_almacen.on('select',onAlmacenSelect);
		combo_almacen.on('change',onAlmacenSelect);
		combo_solicitante.on('select',onSolicitanteSelect);
		combo_solicitante.on('change',onSolicitanteSelect);
		combo_institucion.on('change',onSolicitanteSelect);
		combo_motivo_ingreso.on('select',onMotivoIngresoSelect);
		combo_motivo_ingreso.on('change',onMotivoIngresoSelect);
		cmb_ep.on('change',onEpSelect)
	}

	//Sobrecarga del edit, para desplegar el origen del ingreso
	this.btnEdit = function(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect!=0)
		{ 	CM_ocultarComponente(componentes[12]);
		CM_ocultarComponente(componentes[13]);
		CM_ocultarComponente(componentes[14]);
		var SelectionsRecord=sm.getSelected();

		if(SelectionsRecord.data.id_institucion!='')
		{
			combo_solicitante.setValue('Institucion');
			CM_mostrarComponente(componentes[8]);//institución
		}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

		ClaseMadre_btnEdit()
	};

	function actualizar_ds_combos(){
		//actualiza el data store de almacén y almacén lógico en función de la EP seleccionada
		var datos=Ext.urlDecode(decodeURIComponent(data_ep)); 	
		Ext.apply(combo_almacen.store.baseParams,datos);
		Ext.apply(combo_almacen_logico.store.baseParams,datos);
		Ext.apply(combo_motivo_ingreso.store.baseParams,datos);
		Ext.apply(combo_motivo_ingreso_cuenta.baseParams,datos)	
	}

	//Obtener los componentes del formulario
	function InitPaginaIngresoSolicitud()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		CM_ocultarComponente(componentes[4]);//Costo total
		CM_ocultarComponente(componentes[6])//Fecha reg
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_orden_ingreso_sol.getLayout();
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
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);

	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de la Solicitud de Ingreso',btn_orden_ingreso_sol_det,true,'orden_ingreso_sol_det','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Terminar la Solicitud',btn_fin_ord_ing,false,'fin_sol','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaIngresoSolicitud();
	layout_orden_ingreso_sol.getLayout().addListener('layout',this.onResize);//arregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}