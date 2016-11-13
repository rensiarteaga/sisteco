/**
 * Nombre:		  	    pagina_aprobacion_solicitud.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-15 19:39:24
 */
function pagina_aprobacion_solicitud(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var data='';
	var observaciones;
	
	//---DATA STORE
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
		'observaciones',
		'localidad',
		'siguiente_estado',
		'tipo_adjudicacion',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'desc_empleado_tpm_frppa',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_cuenta',
		'desc_cuenta',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		{name: 'fecha_estado',type:'date',dateFormat:'Y-m-d'},
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','tipo_adq','num_solicitud','estado','numeracion_periodo','gestion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			filtro:"SEGSOL.siguiente_estado like 'aprobado'",
			vista:'aprobacion'
		}
	});
	//DATA STORE COMBOS

    var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre'])
	});

    var ds_empleado_tpm_frppa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_categoria_adq'])
	});

    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','id_cuenta_padre'])
	});

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

	//FUNCIONES RENDER
	
		function render_id_tipo_categoria_adq(value, p, record){return String.format('{0}', record.data['desc_tipo_categoria_adq']);}
		var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');

		function render_id_empleado_frppa_solicitante(value, p, record){return String.format('{0}', record.data['desc_empleado_tpm_frppa']);}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{id_empleado}</i></b>','<br><FONT COLOR="#B5A642">{id_fina_regi_prog_proy_acti}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_rpa(value, p, record){return String.format('{0}', record.data['desc_rpa']);}
		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{id_empleado_frppa}</i></b>','<br><FONT COLOR="#B5A642">{id_empleado_frppa}</FONT>','</div>');

		function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_solicitud_compra',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra'
	};
	
	
	Atributos[1]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'NºSolicitud',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:'30%',
			disable:false,
			grid_indice:2
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo',
		save_as:'num_solicitud'
	};
	
	
	// txt id_empleado_frppa_solicitante
	Atributos[2]={
		validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:3	
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre',
		id_grupo:0
	};
	
	
Atributos[3]={
		validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Centro',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:4
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		id_grupo:0
	};
	// txt id_moneda
	
Atributos[4]={
		validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:5
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:0
	};
	
	// txt localidad
	Atributos[5]={
		validacion:{
			name:'localidad',
			fieldLabel:'Localidad',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:6		
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'SEGSOL.localidad',
		save_as:'localidad'
	};
	
	Atributos[6]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo Adquisicion',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7
		},
		tipo: 'TextArea',
		form:false,
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		id_grupo:0
	};

	// txt id_rpa
	
Atributos[7]={
		validacion:{
			name:'desc_rpa',
			fieldLabel:'RPA',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:8
			
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'EMPLEP_8.apellido_paterno#EMPLEP_8.apellido_materno#EMPLEP_8.nombre',
		id_grupo:0
	};
	
	// txt tipo_adjudicacion
	Atributos[8]={
		validacion:{
			name:'tipo_adjudicacion',
			fieldLabel:'Adjudicación',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'40%',
			disable:false,
			grid_indice:9		
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'SEGSOL.tipo_adjudicacion',
		save_as:'tipo_adjudicacion'
	};
	
	// txt id_tipo_categoria_adq
	Atributos[9]={
		validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Tipo Categoria',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:10
			
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'TIPCAT.nombre',
		id_grupo:0
	};
	Atributos[10]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			width:'100%',
			disable:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'SEGSOL.gestion',
		id_grupo:0
	};
	
	
// txt observaciones
	Atributos[11]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11
		},
		tipo: 'TextArea',
		form:false,
		filtro_0:true,
		filterColValue:'ESTPRO.observaciones',
		save_as:'observaciones'
	};

// txt estado_vigente_solicitud
	Atributos[12]={
		validacion:{
			name:'siguiente_estado',
			fieldLabel:'Siguiente Estado',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'40%',
			disable:false,
			grid_indice:12		
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'SEGSOL.siguiente_estado',
		save_as:'siguiente_estado'
	};

//
//// txt id_cuenta
//	Atributos[9]={
//			validacion:{
//			name:'id_cuenta',
//			fieldLabel:'Cuenta',
//			allowBlank:false,			
//			emptyText:'Cuenta...',
//			desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
//			store:ds_cuenta,
//			valueField: 'id_cuenta',
//			displayField: 'nro_cuenta',
//			queryParam: 'filterValue_0',
//			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
//			typeAhead:true,
//			tpl:tpl_id_cuenta,
//			forceSelection:true,
//			mode:'remote',
//			queryDelay:250,
//			pageSize:100,
//			minListWidth:'80%',
//			grow:true,
//			resizable:true,
//			queryParam:'filterValue_0',
//			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
//			triggerAction:'all',
//			editable:true,
//			renderer:render_id_cuenta,
//			grid_visible:true,
//			grid_editable:false,
//			width_grid:120,
//			width:'80%',
//			disable:false,
//			grid_indice:8		
//		},
//		tipo:'ComboBox',
//		form: true,
//		filtro_0:true,
//		filterColValue:'CUENTA.nro_cuenta',
//		save_as:'id_cuenta'
//	};

// txt id_fina_regi_prog_proy_acti
	Atributos[13]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep'
		};
		
		// txt num_solicitud
	
	
	// txt localidad
	Atributos[14]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:14	
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'ESTCOM.nombre',
		save_as:'estado'
	};
	
	Atributos[15]= {
		validacion:{
			name:'fecha_estado',
			fieldLabel:'Fecha Inicio Estado',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:true,
			renderer: formatDate,
			width_grid:110,
			disabled:true,
			grid_indice:15
			
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'ESTPRO.fecha_estado',
		save_as:'fecha_estado',
		id_grupo:0
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'aprobacion_solicitud',grid_maestro:'grid-'+idContenedor};
	var layout_aprobacion_solicitud=new DocsLayoutMaestro(idContenedor);
	layout_aprobacion_solicitud.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_aprobacion_solicitud,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'aprobacion_solicitud'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	function btn_solicitud_compra_det(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
			data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.tipo_adq=='Bien'){
				layout_aprobacion_solicitud.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_solicitud_bien/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
			else{
				layout_aprobacion_solicitud.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_solicitud_servicio/detalle_seguimiento_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
		
layout_aprobacion_solicitud.getVentana().on('resize',function(){
			layout_aprobacion_solicitud.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	
	
	
	function btn_aprobar(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
		  	   Ext.MessageBox.show({
                   title: 'Observaciones de Aprobación',
                   msg: 'Ingrese las observaciones de aprobación:',
                   width:300,
                   buttons: Ext.MessageBox.OK,
                   multiline: true,
                   fn: getObservaciones
               });
			data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=aprobar';
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function btn_correccion(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			    Ext.MessageBox.show({
                title: 'Observaciones de Corrección',
                msg: 'Ingrese observaciones para corrección:',
                width:300,
                buttons: Ext.MessageBox.OK,
                multiline: true,
                fn: getObservaciones
           });
			data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=correccion';
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function getObservaciones(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones='+observaciones;
		data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	
	
	function btn_anular_solicitud(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			   data='cantidad_ids=1&hidden_id_solicitud_compra_0='+SelectionsRecord.data.id_solicitud_compra;
			     Ext.MessageBox.show({
                    title: 'Observaciones de Anulación',
                    msg: 'Ingrese observaciones de anulación:',
                    width:300,
                    buttons: Ext.MessageBox.OK,
                    multiline: true,
                    fn: getObservaciones1
                 });
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function getObservaciones1(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones_0='+observaciones;
		
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionAnularSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
		
		
	}
	
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_aprobacion_solicitud.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','Detalle');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'pedir_correccion','Corrección');
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Solicitud',btn_aprobar,true,'aprobar_solicitud','Aprobación');
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Solicitud',btn_anular_solicitud,true,'anular_solicitud','Anulación');			

	
	this.iniciaFormulario();
	layout_aprobacion_solicitud.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}