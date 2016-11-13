/**
 * Nombre:		  	    pagina_solicitud_compra_personal_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 09:11:12
 */



//modificar  el onSelect de solicitante para que cuando elija id_tipo_categoria filtre despues los RPAs en base a la categoria que eligió y seguir modificando en la BD para que guarde!!
function pagina_solicitud_compra_personal(idContenedor,direccion,empleado,paramConfig){
	var Atributos=new Array,sw=0;
	var data_ep;
	
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra/ActionListarSolicitudCompra.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'precio_total',
		'observaciones',
		{name: 'fecha_venc',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'hora_reg',
		'localidad',
		'num_solicitud',
		'estado_reg',
		'estado_vigente_solicitud',
		'tipo_adjudicacion',
		'modalidad',
		'id_solicitud_compra_ant',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'solicitante',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_usuario_transcriptor',
		'transcriptor',
		
		
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_empleado_frppa_pre_aprobacion',
		'encargado_pre_aprobacion',
		'id_empleado_frppa_aprobacion',
		'encargado_aprobacion',
		'id_empleado_frppa_gfa',
		'gfa',
		'codigo_sicoes',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_solicitud_sis',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
'id_tipo_adq',
'desc_tipo_adq',
'tipo_adq',
'simbolo','id_frppa','observaciones_estado', 'tipo_cambio','id_parametro_adquisicion','id_periodo','id_moneda_base','numeracion_periodo',
'id_orden_trabajo','desc_orden','id_almacen_logico','desc_almacen_logico','desc_almacen','id_almacen'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo:'personal',
			id_empleado:empleado.id_empleado,
			id_empresa:empleado.id_empresa
		}
	});
	//DATA STORE COMBOS
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_empleado_responsable_proceso','desc_empleado_tpm_frppa','desc_categoria_adq','id_frppa'])
	});

    
  /*  var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarCentro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','centro'])
	});*/

       	
	var ds_tipo_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_adq/ActionListarTipoAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_adq',totalRecords: 'TotalCount'},['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion','fecha_reg'])
	});
	
	var ds_orden_trabajo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario','desc_usuario'])
	});
	
	
	ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almacenes/control/almacen_logico/ActionListarAlmacenLogicoFisEPM.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_logico',
			totalRecords: 'TotalCount'
		}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])
	});

	
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_almacenes/control/almacen/ActionListarAlmacenEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'idalmacen',totalRecords:'TotalCount'}, ['id_almacen','nombre','descripcion'])});
	
	
	//FUNCIONES RENDER

	
		function render_id_empleado_frppa_solicitante(value, p, record){return String.format('{0}', record.data['solicitante']);}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_rpa(value, p, record){return String.format('{0}', record.data['desc_rpa']);}
		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{desc_empleado_tpm_frppa}</i></b>','<br><FONT COLOR="#B5A642">{desc_categoria_adq}</FONT>','</div>');

		
		
//		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
//		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{id_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{centro}</FONT>','</div>');

				
		function render_id_tipo_adq(value, p, record){return String.format('{0}', record.data['desc_tipo_adq']);}
		var tpl_id_tipo_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo_adq}</FONT>','</div>');


		function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden']);}		
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
		function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
		var tpl_id_almacen_logico=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');
		
		function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
		var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
		
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
		save_as:'hidden_id_solicitud_compra',
		id_grupo:2
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_empleado_frppa_solicitante',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:empleado.id_empleado,
		save_as:'id_empleado_frppa_solicitante',
		id_grupo:2
	};
	
	Atributos[2]={
		validacion:{
			name:'solicitante',
			fieldLabel:'Solicitante',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'text',
			grid_visible:true,
			grid_editable:false,
			width_grid:72,
			width:'80%',
			disabled:true,
			grid_indice:2
		},
		tipo:'TextField',
		form:true,
		filtro_0:false,
		save_as:'solicitante',
		defecto:empleado.nombre_usuario,
		id_grupo:0
	};
	
	filterCols_centro=new Array();
	filterValues_centro=new Array();
	filterCols_centro[0]='EMPLEA.id_empleado';
	filterValues_centro[0]=empleado.id_empleado;
	
	
	// txt num_solicitud
	Atributos[3]={
		validacion:{
			name:'num_solicitud',
			fieldLabel:'NºSolicitud',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:false,
			grid_editable:false,
			width_grid:70,
			width:'30%',
			disable:false,
			grid_indice:1 
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLADQ.num_solicitud#SOLADQ.periodo',
		save_as:'txt_num_solicitud',
		id_grupo:2
	};
	
	
	// txt id_fina_regi_prog_proy_acti
	Atributos[4]={
		validacion:{
			pregarga:false,
			precargaAct:"../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEPempleado.php",
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			actFin:'../../../sis_parametros/control/financiador/ActionListaFinanciadorEmpleadoEP.php',
			bpFin:{'id_empleado':empleado.id_empleado},
			actReg:'../../../sis_parametros/control/regional/ActionListaRegionalEmpleadoEP.php',
			bpReg:{'id_empleado':empleado.id_empleado},
			actProg:'../../../sis_parametros/control/programa/ActionListaProgramaEmpleadoEP.php',
			bpProg:{'id_empleado':empleado.id_empleado},
			actProy:'../../../sis_parametros/control/proyecto/ActionListaProyectoEmpleadoEP.php',
			bpProy:{'id_empleado':empleado.id_empleado},
			actAct:'../../../sis_parametros/control/actividad/ActionListaActividadEmpleadoEP.php',
			bpAct:{'id_empleado':empleado.id_empleado},
			name:'id_ep',
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:false,
			grid_editable:false,
			grid_indice:22,
			disabled:false,
			width:300
		},
		tipo:'epField',
		save_as:'txt_id_frppa',
		id_grupo:0
	};
	
	
	
		
	// txt fecha_reg
	Atributos[5]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:80,
			disabled:true

		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLADQ.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:1
	};
	
	
// txt hora_reg
	Atributos[6]={
		validacion:{
			name:'hora_reg',
			fieldLabel:'Hora',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:72,
			width:'40%',
			disabled:true
			
		},
		tipo:'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'SOLADQ.hora_reg',
		save_as:'txt_hora_reg',
		id_grupo:1
	};
	
	// txt localidad
	Atributos[7]={
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
			disabled:true,
			grid_indice:7
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLADQ.localidad',
		save_as:'txt_localidad',
		id_grupo:0
	};
	
	

	
	// txt id_unidad_organizacional
	/*Atributos[8]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Centro Autorizador',
			allowBlank:false,			
			emptyText:'Centro...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'centro',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.id_unidad_organizacional#UNIORG.nombre_centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			filterCols:filterCols_centro,
			filterValues:filterValues_centro,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disabled:true,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'txt_id_unidad_organizacional_',
		id_grupo:0
	};
	*/Atributos[8]={
		validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Centro Autorizador',
			allowBlank:true,
			maxLength:120,
			minLength:0,	
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			width:'80%',
			disabled:true,
			grid_indice:12
		},
		tipo:'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'txt_desc_unidad_organizacional',
		id_grupo:0
	};
	

	
	// txt id_empleado_frppa_pre_aprobacion
	Atributos[9]={
		validacion:{
			name:'encargado_pre_aprobacion',
			fieldLabel:'Encargado Pre Aprobacion',
			allowBlank:true,
			maxLength:120,
			minLength:0,	
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			width:'80%',
			disabled:true,
			grid_indice:12
		},
		tipo:'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON3.nombre#PERSON3.apellido_paterno#PERSON3.apellido_materno',
		save_as:'txt_id_empleado_frppa_pre_aprobacion',
		id_grupo:2
	};
	
	
	
//txt id_empleado_frppa_aprobacion
	Atributos[10]={
		validacion:{
			name:'encargado_aprobacion',
			fieldLabel:'Encargado Aprobación',
			allowBlank:true,
			maxLength:160,
			minLength:0,
			desc: 'encargado_aprobacion', //indica la columna del store principal ds del que proviane la descripcion
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			width:'80%',
			disabled:true,
			grid_indice:13
		},
		tipo:'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON4.nombre#PERSON4.apellido_paterno#PERSON4.apellido_materno',
		save_as:'txt_id_empleado_frppa_aprobacion',
		id_grupo:2
	};



	
	Atributos[11]={
		validacion:{
			name:'gfa',
			fieldLabel:'GFA',
			allowBlank:true,
			maxLength:160,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:160,
			width:'80%',
			disabled:true,
			grid_indice:15
		},
		tipo:'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON5.nombre#PERSON5.apellido_paterno#PERSON5.apellido_materno',
		save_as:'txt_id_empleado_frppa_gfa',
		id_grupo:2
	};
	
	// txt estado_vigente_solicitud
	Atributos[12]={
		validacion:{
			name:'estado_vigente_solicitud',
			fieldLabel:'Estado Sol.',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:10,
			width:'40%',
			disable:false,
			grid_indice:19
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLADQ.estado_vigente_solicitud',
		save_as:'txt_estado_vigente_solicitud',
		id_grupo:2
	};
	
	// txt estado_reg
	Atributos[13]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado Reg',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'40%',
			disable:false,
			grid_indice:21
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLADQ.estado_reg',
		save_as:'txt_estado_reg',
		id_grupo:2
	};
	
	// txt modalidad
	Atributos[14]={
			validacion: {
			name:'modalidad',
			fieldLabel:'Modalidad',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Nacional','Nacional'],['Internacional','Internacional']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'40%',
			disable:false,
			grid_indice:5/**/
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SOLADQ.modalidad',
		defecto:'Nacional',
		save_as:'txt_modalidad',
		id_grupo:3
	};
	
	// txt tipo_adjudicacion
	
	Atributos[15]= {
			validacion: {
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,			
			emptyText:'OT...',
			name: 'id_orden_trabajo',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_orden', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_orden_trabajo,
			valueField: 'id_orden_trabajo',
			displayField: 'desc_orden',
			queryParam: 'filterValue_0',
			filterCol:'ORDTRA.desc_orden',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			tpl:tpl_id_orden_trabajo,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:false,
			grid_indice:21,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'OT.desc_orden',
		defecto: '',
		save_as:'id_orden_trabajo',
		id_grupo:3
	};
	
	
	Atributos[16]={//22
			validacion:{
			name:'id_tipo_adq',
			fieldLabel:'Tipo de Adquisicion',
			allowBlank:false,			
			emptyText:'Tipo Adquisicion...',
			desc: 'desc_tipo_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_adq,
			valueField: 'id_tipo_adq',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPADQ.nombre',
			typeAhead:true,
			tpl:tpl_id_tipo_adq,
			forceSelection:true,
			onSelect:function(record){
				
				getComponente('id_tipo_adq').setValue(record.data.id_tipo_adq); 
				getComponente('tipo_adq').setValue(record.data.tipo_adq);  
				
				if(getComponente('tipo_adq').getValue()=='Bien'){
					CM_mostrarComponente(getComponente('id_almacen'));
					CM_mostrarComponente(getComponente('id_almacen_logico'));
					var epP=getComponente('id_ep').getValue();
					ds_almacen.baseParams={id_financiador:epP['id_financiador'],
											id_regional:epP['id_regional'],
											id_programa:epP['id_programa'],
											id_proyecto:epP['id_proyecto'],
											id_actividad:epP['id_actividad'],
					};
					getComponente('id_almacen').enable();
					getComponente('id_almacen').allowBlank=false;
					getComponente('id_almacen_logico').allowBlank=false;
				}else{
					getComponente('id_almacen_logico').setValue('');
					getComponente('id_almacen').setValue('');
					CM_ocultarComponente(getComponente('id_almacen_logico'));
					CM_ocultarComponente(getComponente('id_almacen'));
					getComponente('id_almacen_logico').disable();
					getComponente('id_almacen_logico').allowBlank=true;
					getComponente('id_almacen').allowBlank=true;
					
					getComponente('id_almacen_logico').reset();
					getComponente('id_almacen').reset();
				}
				getComponente('id_tipo_adq').collapse();
			},
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_adq,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disabled:true,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'tipo.nombre',
		save_as:'txt_id_tipo_adq',
		id_grupo:1
	};
	
	
	
	// txt precio_total
	Atributos[17]={
		validacion:{
			name:'precio_total',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:70,
			width:'40%',
			align:'right',
			disable:false,
			grid_indice:18
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLADQ.precio_total',
		save_as:'txt_precio_total',
		id_grupo:2
	};
	
	
	// txt id_moneda
	Atributos[18]={
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
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'80%',
			disable:false,
			grid_indice:7/**/
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'txt_id_moneda',
		id_grupo:3
	};
	
	

	
// txt id_solicitud_compra_ant
	Atributos[19]={//20
		validacion:{
			name:'id_solicitud_compra_ant',
			fieldLabel:'Nº Sol. Anterior',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'30%',
			disable:true,
			grid_indice:23
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLADQ.id_solicitud_compra_ant',
		save_as:'txt_id_solicitud_compra_ant',
		id_grupo:2
	};

	




	
	/*Atributos[21]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Tipo Categoria Solicitud',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			//store:ds_tipo_categoria_adq,			
			valueField: 'id_tipo_categoria_adq',
			displayField: 'desc_tipo_categoria_adq',
			desc: 'desc_tipo_categoria_adq',
			renderer:render_id_tipo_categoria_adq,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:true,
			grid_indice:24
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'ADPCAT.nombre',
		save_as:'txt_id_tipo_categoria_adq',
		id_grupo:2
	};*/
	
	Atributos[20]={//21
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_tipo_categoria_adq',
		id_grupo:2
	};
	
	
	Atributos[21]={
		validacion: {
			name:'tipo_adjudicacion',
			fieldLabel:'Tipo de Adjudicacion',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['total','total'],['lotes','lotes'],['item','item']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'40%',
			disabled:false,
			grid_indice:6/**/
		},
		tipo: 'ComboBox',
		form:true,
		filtro_0:true,
		defecto:'total',
		filterColValue:'SOLADQ.tipo_adjudicacion',
		save_as:'txt_tipo_adjudicacion',
		id_grupo:1
	};
	
	
		
// txt observaciones
	Atributos[22]={//23
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
			grid_indice:19
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'SOLADQ.observaciones',
		save_as:'txt_observaciones',
		id_grupo:3
	};

	
// txt periodo
	Atributos[23]={//24
		validacion:{
			name:'periodo',
			fieldLabel:'Periodo',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:70,
			align:'right',
			width:'30%',
			disable:false,
			grid_indice:16
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'SOLADQ.periodo',
		save_as:'txt_periodo',
		id_grupo:1
	};
// txt gestion
	Atributos[24]={//25
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
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
			grid_indice:1
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:false,
		filterColValue:'SOLADQ.gestion',
		save_as:'txt_gestion',
		id_grupo:1
	};
// txt num_solicitud_sis
//	Atributos[26]={
//		validacion:{
//			name:'num_solicitud_sis',
//			fieldLabel:'Nº Sol. Sist.',
//			allowBlank:true,
//			maxLength:50,
//			minLength:0,
//			selectOnFocus:true,
//			allowDecimals:false,
//			decimalPrecision:2,//para numeros float
//			allowNegative:false,
//			minValue:0,
//			vtype:'texto',
//			grid_visible:false,
//			grid_editable:false,
//			width_grid:70,
//			width:'30%',
//			disable:false,
//			grid_indice:27
//		},
//		tipo: 'NumberField',
//		form: true,
//		filtro_0:false,
//		filterColValue:'SOLADQ.num_solicitud_sis',
//		save_as:'txt_num_solicitud_sis',
//		id_grupo:2
//	};
	
	
	
// txt id_rpa
	Atributos[25]={//27
			validacion:{
			name:'id_rpa',
			fieldLabel:'RPA',
			allowBlank:true,			
			emptyText:'RPA...',
			desc: 'desc_rpa', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rpa,
			valueField: 'id_rpa',
			displayField: 'desc_empleado_tpm_frppa',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			typeAhead:true,
			tpl:tpl_id_rpa,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_rpa,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			grid_indice:14
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		defecto:'',
		filterColValue:'PERSON5.nombre#PERSON5.apellido_paterno#PERSON5.apellido_materno',
		save_as:'txt_id_rpa',
		id_grupo:4
	};
	
	
	
	
	Atributos[26]={//28
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,   
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_tipo',
		id_grupo:2
	};
	
	
	/*Atributos[27]={//29
		validacion:{
			name:'id_financiador',
			fieldLabel:'financiador',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_financiador',
		id_grupo:2
	};
	
	
	Atributos[28]={//30
		validacion:{
			name:'id_regional',
			fieldLabel:'regional',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_regional',
		id_grupo:2
	};
	
	Atributos[29]={//31
	
		validacion:{
			name:'id_programa',
			fieldLabel:'programa',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_programa',
		id_grupo:2
	};

	
	Atributos[30]={//32
		validacion:{
			name:'id_proyecto',
			fieldLabel:'proyecto',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_proyecto',
		id_grupo:2
	};
	
	Atributos[31]={//33
		validacion:{
			name:'id_actividad',
			fieldLabel:'actividad',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_actividad',
		id_grupo:2
	};
	*/
	
	/**********///desde aqui modificar como solicitud_compra.js
	
	Atributos[27]={//32
		validacion:{
			name:'observaciones_estado',
			fieldLabel:'Observaciones por Estado',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:28
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:false,
		filterColValue:'ESTPRO.observaciones',
		save_as:'txt_observaciones_estado',
		id_grupo:3
	};
	
	
//	Atributos[35]={//
//		validacion:{
//			name:'tipo_cambio',
//			fieldLabel:'tipo_cambio',
//			grid_visible:false,
//			grid_editable:false,
//			disabled:true
//			
//		},
//		tipo:'Field',
//		filtro_0:false,
//		save_as:'tipo_cambio',
//		id_grupo:2
//	};
	Atributos[28]={//33
		validacion:{
			labelSeparator:'',
			name: 'id_frppa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_frppa1',
		id_grupo:3
	};
	
	Atributos[29]={//34
		validacion:{
			name:'id_empresa',
			labelSeparator:'',
			grid_visible:false,
			inputType:'hidden',
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_empresa',
		defecto:empleado.id_empresa,
		id_grupo:3
		
	};
	
	
	// txt id_empleado_frppa_transcriptor
	Atributos[30]={//35
			validacion:{
			labelSeparator:'',
			name: 'id_usuario_transcriptor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:empleado.id_usuario,
		save_as:'txt_id_usuario_transcriptor',
		id_grupo:2
	};
	
	Atributos[31]={//36
		validacion:{
			labelSeparator:'',
			name: 'id_moneda_base',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_moneda_base',
		id_grupo:0
	};
	
	Atributos[32]={//47
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Periodo/Nº Sol.',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:65,
			align:'right',
			
			width:'40%',
			disabled:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'SOLADQ.periodo#SOLADQ.num_solicitud',
		save_as:'numeracion_periodo',
		id_grupo:0
	};
	
	Atributos[33]={//38
		validacion:{
			fieldLabel:'Almacen Físico',
			allowBlank:true,
			emptyText:'Almacen Físico...',
			name:'id_almacen',
			desc:'desc_almacen',
			store:ds_almacen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			disabled:true,
			renderer:render_id_almacen,
			grid_visible:false,
			grid_editable:false,
			grid_indice:21,
			width_grid:140
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'id_almacen',
		id_grupo:1
	};

	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='%';
	
	Atributos[34]= {//39
			validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:true,			
			emptyText:'Id Almacén Lógico...',
			name: 'id_almacen_logico', //indica la columna del store principal ds del que proviane el id
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
			tpl:tpl_id_almacen_logico,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			disabled:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:21,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre',
		defecto: '',
		save_as:'id_almacen_logico',
		id_grupo:1
	};
	
	
	Atributos[35]={//40
		validacion:{
			labelSeparator:'',
			name: 'id_empleado_frppa_pre_aprobacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_empleado_frppa_pre_aprobacion',
		id_grupo:3
	};
	
		
	Atributos[36]={//41
		validacion:{
			labelSeparator:'',
			name: 'id_empleado_frppa_aprobacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_empleado_frppa_aprobacion',
		id_grupo:3
	};
	
		
	Atributos[37]={//42
		validacion:{
			labelSeparator:'',
			name: 'id_empleado_frppa_gfa',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_empleado_frppa_gfa',
		id_grupo:3
	};
	
	Atributos[38]={//43
		validacion:{
			labelSeparator:'',
			name: 'es_modificacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'es_modificacion',
		id_grupo:2
	};
	
	Atributos[39]={//44
		validacion:{
			labelSeparator:'',
			name: 'id_unidad_organizacional',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_id_unidad_organizacional',
		id_grupo:2
	};
	
	
	// txt fecha_venc
	Atributos[40]= {
		validacion:{
			name:'fecha_venc',
			fieldLabel:'Fecha Venc.',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:22
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'SOLADQ.fecha_venc',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_venc',
		id_grupo:2
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor};
	var layout_solicitud_compra_personal=new DocsLayoutMaestro(idContenedor);
	layout_solicitud_compra_personal.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_compra_personal,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;

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
		btnEliminar:{url:direccion+'../../../control/solicitud_compra/ActionEliminarSolicitudCompra.php'},
		Save:{url:direccion+'../../../control/solicitud_compra/ActionGuardarSolicitudCompra.php'},
		ConfirmSave:{url:direccion+'../../../control/solicitud_compra/ActionGuardarSolicitudCompra.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],
		grupos:[
		{
			tituloGrupo:'Origen Solicitud',
			columna:0,
			id_grupo:1
		},{
			tituloGrupo:'Solicitud',
			columna:0,
			id_grupo:0
		},{
			tituloGrupo:'Oculto',
			columna:1,
			id_grupo:3
		},
		{
			tituloGrupo:'Detalle Solicitud',
			columna:1,
			id_grupo:2
		},
		{
			tituloGrupo:'RPA',
			columna:1,
			id_grupo:4
		}
		],
		width:'75%',minWidth:350,minHeight:400,closable:true,titulo:'Solicitud de Compra'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_solicitud_compra_det(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_localidad='+SelectionsRecord.data.localidad;
			data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
			data=data+'&m_solicitante='+SelectionsRecord.data.solicitante;
			data=data+'&m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
			data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
			data=data+'&m_simbolo='+SelectionsRecord.data.simbolo;
			data=data+'&m_fecha_reg='+SelectionsRecord.data.fecha_reg.dateFormat('d-m-Y');
			data=data+'&m_tipo_cambio='+SelectionsRecord.data.tipo_cambio;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;


			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.estado_vigente_solicitud=='borrador'){
				if(SelectionsRecord.data.tipo_adq=='Bien'){
			layout_solicitud_compra_personal.loadWindows(direccion+'../../../../sis_adquisiciones/vista/solicitud_compra_det/solicitud_compra_item_det.php?'+data,'Detalle de Solicitud',ParamVentana);
			}else{
				layout_solicitud_compra_personal.loadWindows(direccion+'../../../../sis_adquisiciones/vista/solicitud_compra_det/solicitud_compra_serv_det.php?'+data,'Detalle de Solicitud',ParamVentana);
			}
			
			layout_solicitud_compra_personal.getVentana().on('resize',function(){
			layout_solicitud_compra_personal.getLayout().layout();
				})
			}else{
				Ext.MessageBox.alert('Estado', 'Solo Solicitudes en estado borrador pueden continuar accediendo a detalle');
			}
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	
	function btn_reporte_solicitud_compra(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			
			var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			
			window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitud.php?'+data)	
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	    getComponente('id_ep').reset();
		txt_num_solicitud=getComponente('num_solicitud');//
		txt_fecha=getComponente('fecha_reg');
		txt_hora=getComponente('hora_reg');
		txt_periodo=getComponente('periodo');//
		txt_gestion=getComponente('gestion');//
		txt_localidad=getComponente('localidad');
		cmb_ep=getComponente('id_ep');
		//cmbUO=getComponente('id_unidad_organizacional');
		cmbTranscriptor=getComponente('id_usuario_transcriptor');//
		cmbSolicitante=getComponente('id_empleado_frppa_solicitante');
		cmbEPA=getComponente('id_empleado_frppa_pre_aprobacion');//
		cmbEA=getComponente('id_empleado_frppa_aprobacion');//
		cmbGFA=getComponente('id_empleado_frppa_gfa');//
		cmbRPA=getComponente('id_rpa');//
		cmbMoneda=getComponente('id_moneda');
//		txt_id_fin=getComponente('id_financiador');
//		txt_id_reg=getComponente('id_regional');
//		txt_id_prog=getComponente('id_programa');
//		txt_id_proy=getComponente('id_proyecto');
//		txt_id_act=getComponente('id_actividad');
		txt_id_tipo_adquisicion=getComponente('id_tipo_adq');
		
		txt_fecha_venc=getComponente('fecha_venc');
		txt_id_moneda_base=getComponente('id_moneda_base');
		combo_almacen=getComponente('id_almacen');
		combo_almacen_logico=getComponente('id_almacen_logico');
		var onAlmacenSelectP=function(e) {
			var id = combo_almacen.getValue();
			combo_almacen_logico.filterValues[0] =  id;
			
			var ep1=getComponente('id_ep');
			ds_almacen_logico.baseParams={
			    id_financiador:ep1['id_financiador'],
			    id_regional:ep1['id_regional'],
			    id_programa:ep1['id_programa'],
			    id_proyecto:ep1['id_proyecto'],
			    id_actividad:ep1['id_actividad']
			}
			combo_almacen_logico.modificado = true;
			combo_almacen_logico.enable();//almacen logico
			combo_almacen_logico.setValue('');
			combo_almacen.modificado=true
		};
		combo_almacen.on('select',onAlmacenSelectP);
		combo_almacen.on('change',onAlmacenSelectP);
	  
		//getGrid().getColumnModel().setHidden(17,true);//monto total
		getGrid().getColumnModel().setHidden(10,true);//RPA
		
		
		
		var onEPSelectP=function(e){
		    getComponente('id_almacen').setValue('');
		    getComponente('id_almacen_logico').setValue('');
			getComponente('localidad').setValue('');
			getComponente('desc_unidad_organizacional').setValue('');
			//getComponente('id_financiador').setValue('');
			//cmbUO.enable();
			txt_id_tipo_adquisicion.enable();
			
			var ep_=cmb_ep.getValue();
			
			
			getComponente('localidad').setValue(ep_['nombre_regional']);
			data_ep='id_fin='+ep_['id_financiador']+'&id_reg='+ep_['id_regional']+'&id_prog='+ep_['id_programa']+'&id_proy='+ep_['id_proyecto']+'&id_act='+ep_['id_actividad'];
//			getComponente('id_financiador').setValue(ep['id_financiador']);
//			getComponente('id_regional').setValue(ep['id_regional']);
//			getComponente('id_programa').setValue(ep['id_programa']);
//			getComponente('id_proyecto').setValue(ep['id_proyecto']);
//			getComponente('id_actividad').setValue(ep['id_actividad']);
			if(getComponente('desc_unidad_organizacional').getValue()==''){
				onLocalidadP();
			}
			
			ds_almacen.baseParams={
					id_financiador:ep_['id_financiador'],
												 id_regional:ep_['id_regional'],
												 id_programa:ep_['id_programa'],
												 id_proyecto:ep_['id_proyecto'],
												 id_actividad:ep_['id_actividad']
				}
		}
		cmb_ep.on('select',onEPSelectP);
		cmb_ep.on('change',onEPSelectP);
		
		var onLocalidadP=function(e){
		    
			if(getComponente('localidad').getValue()!=''&& getComponente('localidad').getValue()!=undefined && getComponente('localidad').getValue()!=null && getComponente('desc_unidad_organizacional').getValue()==''){
				//llamar a funcion para llenar el centro
				var epp=getComponente('id_ep').getValue();
				
				Ext.Ajax.request({
				url:direccion+"../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarCentro.php?id_empleado="+empleado.id_empleado+"&id_financiador="+epp['id_financiador']
				+"&id_regional="+epp['id_regional']+"&id_programa="+epp['id_programa']+"&id_proyecto="+epp['id_proyecto']+"&id_actividad="+epp['id_actividad'],
				method:'GET',
				success:cargar_centroP,
				failure:Cm_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
					
			}
		}
		
		
		function cargar_centroP(resp){
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
			  	
			  	getComponente('desc_unidad_organizacional').setValue(root.getElementsByTagName('centro')[0].firstChild.nodeValue);
			  	getComponente('id_unidad_organizacional').setValue(root.getElementsByTagName('id_unidad_organizacional')[0].firstChild.nodeValue);
			  	 
			  }
			}
		}		
			
		
		var onMonedaSelectP=function(e){
			getMonedaPrincipal();
		}
		
		getComponente('id_moneda').on('select',onMonedaSelectP);
		getComponente('id_moneda').on('change',onMonedaSelectP);
		getComponente('fecha_reg').on('change',onMonedaSelectP);
		
		var onRPAP=function(e){
			//getDialog().buttons[0].disable();
		  	if(cmbRPA.getValue()>0){
		  		
				getDialog().buttons[0].enable();
			}else{
				//getDialog().buttons[0].disable();
			}
		}
		cmbRPA.on('valid',onRPAP);
	}
	
	
	
	function getMonedaPrincipal(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerMonedaPrincipal.php",
			method:'GET',
			success:cargar_moneda,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_moneda(resp){
		//Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
				txt_id_moneda_base.setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
				if(getComponente('id_moneda').getValue()!=txt_id_moneda_base.getValue()){
				  get_tipo_cambio();
			}
				getComponente('id_moneda').clearInvalid();
				getDialog().buttons[0].show();
				getDialog().buttons[1].show();
				get_hora_bd();
			}
	}
	
	
	//función para terminar la orden de ingreso
	function btn_fin_ped(){
		CM_ocultarGrupo('Origen Solicitud');
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.estado_vigente_solicitud=='borrador'){
			  	var data=SelectionsRecord.data.id_solicitud_compra;
			   		if(confirm("¿Está seguro de terminar la Solicitud?")){
						 Ext.Ajax.request({
						 url:direccion+"../../../control/solicitud_compra/ActionGuardarSolicitudCompraFin.php?hidden_id_solicitud_compra_0="+data,
						 method:'GET',
						 success:terminadoP,
						 failure:Cm_conexionFailure,
						 timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						})
					}	
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	
	
	function terminadoP(resp){
		ds_rpa.load(); 
	    /*getComponente('es_modificacion').setValue('');
		CM_mostrarGrupo('RPA');
		CM_ocultarGrupo('Oculto');
		//CM_ocultarGrupo('Origen Solicitud');
		CM_ocultarGrupo('Estructura Programatica');
		CM_ocultarGrupo('Solicitud');
		CM_ocultarGrupo('Detalle Solicitud');
		//CM_ocultarGrupo('Datos Sicoes');
		getComponente('id_rpa').allowBlank=false;
		
		
		
		if(getComponente('id_tipo_categoria_adq').getValue()>0){
			
			 	ds_rpa.baseParams={
				id_frppa:getComponente('id_frppa').getValue(), id_tipo_categoria_adq:getComponente('id_tipo_categoria_adq').getValue()
				};
				ds_rpa.load(); 
				CM_mostrarComponente(getComponente('id_tipo_categoria_adq'));	
				CM_btnEdit();	
				
		}else{
			
			//Ext.MessageBox.hide();
			  if(resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue!=''){
				getComponente('id_tipo_categoria_adq').setValue(resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
				ds_rpa.baseParams={
				id_frppa:getComponente('id_frppa').getValue(), id_tipo_categoria_adq:getComponente('id_tipo_categoria_adq').getValue()
				};
				ds_rpa.load(); 
				CM_mostrarComponente(getComponente('id_tipo_categoria_adq'));
				CM_btnEdit();
			}
		}*/
	}
	
	
	
	function get_fecha_adq()
	{
		Ext.Ajax.request({
			//url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php",
			method:'GET',
			success:cargar_fecha_adq,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_fecha_adq(resp){
		//Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0)
			{
				getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
				getComponente('fecha_reg').minValue=getComponente('fecha_reg').getValue();
				getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				getComponente('fecha_reg').disable();
				txt_hora.setValue('08:30:00');
				
			}
		}
	}
	
	
	function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_fecha_bd(resp)
	{
		//Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('fecha')[0].firstChild.nodeValue > getComponente('fecha_reg').getValue()){
				
				txt_hora.setValue('08:30:00');
			}else{
				getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				get_hora_bd();
			}
		}
	}
	
	
	
	function get_hora_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
			method:'GET',
			success:cargar_hora_bd,
			failure:Cm_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_hora_bd(resp){
			//Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				   txt_hora.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				   if(txt_hora.getValue()==''){
				       alert("esta entrando aqui");
				       return;
				       txt_hora.setValue('08:30:00');
				   }
				}
			}
		
	function get_tipo_cambio()
		{
		Ext.Ajax.request({
			url:direccion+"../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambio.php?fecha_solicitud="+getComponente('fecha_reg').getValue().dateFormat('m-d-Y'),
			method:'GET',
			success:cargar_tipo_cambio,
			failure:Cm_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	 	function cargar_tipo_cambio(resp)
		{
			//Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				
				    if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue<1){
				    	getComponente('id_moneda').markInvalid("No existe tipo de cambio para la fecha seleccionada");
				    	getDialog().buttons[0].hide();
				     	getDialog().buttons[1].hide()
				   	}
				   	else{
				   		
				   		getComponente('id_moneda').clearInvalid();
				   		getDialog().buttons[0].show();
				   		getDialog().buttons[1].show();
				   	}
				   
				}
			}
			
			
			
	this.btnNew=function(){
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('RPA');
		CM_mostrarGrupo('Origen Solicitud');
		CM_mostrarGrupo('Solicitud');
		CM_mostrarGrupo('Detalle Solicitud');
		getComponente('id_ep').setValue('');
		
		obtEmpleado();
		cmb_ep.ep.cargaEPprimaria({"id_empleado":empleado.id_empleado},carga_localidad);
		get_fecha_adq();
		getComponente('id_rpa').allowBlank=true;
		//getComponente('id_ep').disable();
		//getComponente('id_unidad_organizacional').disable();
		CM_ocultarComponente(getComponente('id_almacen'));
		CM_ocultarComponente(getComponente('id_almacen_logico'));
		getComponente('id_almacen_logico').allowBlank=true;
		getComponente('id_almacen').allowBlank=true;
			
		CM_btnNew();
		
	}
	function carga_localidad(datos){
	    
	   if(datos['id_financiador']==undefined ||datos['id_financiador']==null||datos['id_financiador']==''){
		        getComponente('id_ep').setValue('');   
			    }else{
				    getComponente('localidad').setValue(datos['nombre_regional']); 
				   
			    }	
		}
	
	
	
	function obtEmpleado(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionEmpleadoLogueado.php",
			method:'GET',
			success:ter,
			failure:Cm_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		})
	}
	//recupera nombre e id de empleado y llena el formulario
	function ter(resp){
		var root = resp.responseXML.documentElement;
		if(root.getElementsByTagName('id_empleado')[0]!==undefined){
			id_emp = root.getElementsByTagName('id_empleado')[0].firstChild.nodeValue;
			if(id_emp!="null"){
				
				//getComponente('id_empleado_frppa_solicitante').setValue(id_emp);
				var empleado=root.getElementsByTagName('nombre')[0].firstChild.nodeValue;
				empleado=empleado+" "+ root.getElementsByTagName('paterno')[0].firstChild.nodeValue;
				empleado=empleado+" " +root.getElementsByTagName('materno')[0].firstChild.nodeValue;
				getComponente('solicitante').setValue(empleado);
				
			}
			else{
				alert("Solamentes usuarios registrados como empleados pueden hacer solicitudes");
				//dialog.hide()
			}
		}
		else{
			alert("Ocurrió un error en la petición de verificación de usuario")
		}
	}
	
	
	this.btnEdit=function(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		  var SelectionsRecord=sm.getSelected();
				if(SelectionsRecord.data.estado_vigente_solicitud=='borrador'){
					CM_ocultarGrupo('Oculto');
					//CM_ocultarGrupo('Datos Sicoes');
					CM_ocultarGrupo('Estructura Programatica');
					CM_ocultarGrupo('RPA');
					CM_mostrarGrupo('Origen Solicitud');
					CM_mostrarGrupo('Solicitud');
					CM_mostrarGrupo('Detalle Solicitud');
					getComponente('fecha_reg').enable();
					getComponente('id_tipo_adq').enable();
					getComponente('id_rpa').allowBlank=true;
					if(SelectionsRecord.data.tipo_adq=='Bien'){
						CM_mostrarComponente(getComponente('id_almacen'));
						CM_mostrarComponente(getComponente('id_almacen_logico'));
					}else{
						CM_ocultarComponente(getComponente('id_almacen'));
						CM_ocultarComponente(getComponente('id_almacen_logico'));
					}
					getComponente('es_modificacion').setValue('modificacion');
					CM_btnEdit();
				}else{
		   			Ext.MessageBox.alert('Estado','Solo solicitudes en estado borrador');
				}
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
		//Cm_btnActualizar;
	}
	

    
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_compra_personal.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','');
		this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Solicitud Compra',btn_reporte_solicitud_compra,true,'reporte_solicitud_compra','');
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar el Pedido',btn_fin_ped,true,'fin_ped','');
		
		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//ds_empleado_tpm_frppa_solicitante.baseParams={solicitud_compra:'si'};  // para adicionar un criterio filtro en el listado de empleado, que deben tener una asignacion='activo' y un estado_reg='activo'
	layout_solicitud_compra_personal.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

		
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}