/**
* Nombre:		  	    pagina_solicitud_compra_personal_main.js
* Prop�sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaci�n:		2008-05-09 09:11:12
*/


//modificar  el onSelect de solicitante para que cuando elija id_tipo_categoria filtre despues los RPAs en base a la categoria que eligi� y seguir modificando en la BD para que guarde!!
function pag_sol_bien_personal(idContenedor,direccion,empleado,paramConfig){
	var Atributos=new Array,sw=0;
	var data_ep;
	var txt_emp=0;
	
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
		'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional',
		'nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa',
		'codigo_proyecto','codigo_actividad',
		'id_tipo_adq',
		'desc_tipo_adq',
		'tipo_adq',
		'simbolo','id_frppa','observaciones_estado', 'tipo_cambio','id_parametro_adquisicion','id_periodo',
		'id_moneda_base','numeracion_periodo',
		'id_orden_trabajo','desc_orden','id_almacen_logico','desc_almacen_logico','desc_almacen','id_almacen','id_uo_gerencia'

		]),remoteSort:true});


		//DATA STORE COMBOS
		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});

		var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_empleado_responsable_proceso','desc_empleado_tpm_frppa','desc_categoria_adq','id_frppa'])
		});

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

        var ds_gestion_paradq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_adquisicion/ActionListarGestionParametroAdq.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_adquisicion',totalRecords: 'TotalCount'},['id_parametro_adquisicion','gestion','id_gestion'])
	   });
		
		//FUNCIONES RENDER
		function render_id_empleado_frppa_solicitante(value, p, record){return String.format('{0}', record.data['solicitante']);}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_rpa(value, p, record){return String.format('{0}', record.data['desc_rpa']);}
		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{desc_empleado_tpm_frppa}</i></b>','<br><FONT COLOR="#B5A642">{desc_categoria_adq}</FONT>','</div>');


		function render_id_tipo_adq(value, p, record){return String.format('{0}', record.data['desc_tipo_adq']);}
		var tpl_id_tipo_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo_adq}</FONT>','</div>');


		function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden']);}
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
		function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
		var tpl_id_almacen_logico=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
		var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
 
        function render_id_gestion_paradq(value, p, record){return String.format('{0}', record.data['gestion'])}
        var tpl_gestionParadq = new Ext.Template('<div class="search-item">','<b>{gestion}</b>','</div>');
       

		/////////////////////////
		// Definici�n de datos //
		/////////////////////////

		// hidden id_solicitud_compra
		//en la posici�n 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_solicitud_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_solicitud_compra',
			id_grupo:2
		};

		Atributos[1]={//37
			validacion:{
				name:'numeracion_periodo',
				fieldLabel:'Periodo/N� Sol.',
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
				grid_indice:2
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			filterColValue:'SOLADQ.periodo#SOLADQ.num_solicitud',
			save_as:'numeracion_periodo',
			id_grupo:0
		};


		Atributos[2]={
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

		Atributos[3]={
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
				grid_indice:3
			},
			tipo:'TextField',
			form:true,
			filtro_0:false,
			defecto:empleado.nombre_usuario,
			save_as:'solicitante',
			id_grupo:0
		};

		filterCols_centro=new Array();
		filterValues_centro=new Array();
		filterCols_centro[0]='EMPLEA.id_empleado';
		filterValues_centro[0]=empleado.id_empleado;




		Atributos[4]={
			validacion:{
				name:'desc_tipo_adq',
				fieldLabel:'Tipo Adquisicion',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'45%',
				disabled:true,
				grid_indice:4
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'tipo.nombre',
			save_as:'txt_desc_tipo_adq',
			id_grupo:1
		};

		

		// txt localidad
		Atributos[5]={
			validacion:{
				name:'localidad',
				fieldLabel:'Localidad',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'45%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'SOLADQ.localidad',
			save_as:'txt_localidad',
			id_grupo:0
		};

		// txt id_moneda
		Atributos[6]={
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
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:'80%',
				disable:false,
				grid_indice:6/**/
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'txt_id_moneda',
			id_grupo:3
		};

		Atributos[7]={
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
				grid_indice:7
			},
			tipo:'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'UNIORG.nombre_unidad',
			save_as:'txt_desc_unidad_organizacional',
			id_grupo:0
		};

		// txt id_empleado_frppa_pre_aprobacion
		Atributos[8]={
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
				grid_indice:8
			},
			tipo:'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON3.nombre#PERSON3.apellido_paterno#PERSON3.apellido_materno',
			save_as:'txt_id_empleado_frppa_pre_aprobacion',
			id_grupo:2
		};



		//txt id_empleado_frppa_aprobacion
		Atributos[9]={
			validacion:{
				name:'encargado_aprobacion',
				fieldLabel:'Encargado Aprobaci�n',
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
				grid_indice:9
			},
			tipo:'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON4.nombre#PERSON4.apellido_paterno#PERSON4.apellido_materno',
			save_as:'txt_id_empleado_frppa_aprobacion',
			id_grupo:2
		};




		Atributos[10]={
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
				grid_indice:10
			},
			tipo:'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON5.nombre#PERSON5.apellido_paterno#PERSON5.apellido_materno',
			save_as:'txt_id_empleado_frppa_gfa',
			id_grupo:2
		};


		// txt precio_total
		Atributos[11]={
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
				grid_indice:11
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.precio_total',
			save_as:'txt_precio_total',
			id_grupo:2
		};


		// txt observaciones
		Atributos[25]={//23
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones del Solicitante',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				
				grid_indice:12
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.observaciones',
			save_as:'txt_observaciones',
			id_grupo:3
		};

		
		

		
		Atributos[13]= {
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
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_orden_trabajo,
				grid_visible:true,
				grid_editable:false,
				grid_indice:11,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'OT.desc_orden',
			defecto: '',
			save_as:'id_orden_trabajo',
			id_grupo:3
		};

		Atributos[15]={//38
			validacion:{
				fieldLabel:'Almacen F�sico',
				allowBlank:false,
				emptyText:'Almacen F�sico...',
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
				disabled:false,
				renderer:render_id_almacen,
				grid_visible:false,
				grid_editable:false,
				grid_indice:14,
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

		Atributos[16]= {//39
			validacion: {
				name:'id_almacen_logico',
				fieldLabel:'Almac�n L�gico',
				allowBlank:false,
				emptyText:'Id Almac�n L�gico...',
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
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				disabled:false,
				renderer:render_id_almacen_logico,
				grid_visible:true,
				grid_editable:false,
				grid_indice:15,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'ALMLOG.codigo#ALMLOG.nombre',
			defecto: '',
			save_as:'id_almacen_logico',
			id_grupo:1
		};

		// txt fecha_reg
		Atributos[18]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'D�a no v�lido',
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
		Atributos[27]={
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




		// txt num_solicitud
		Atributos[22]={
			validacion:{
				name:'num_solicitud',
				fieldLabel:'N�Solicitud',
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
				grid_indice:16
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'SOLADQ.num_solicitud#SOLADQ.periodo',
			save_as:'txt_num_solicitud',
			id_grupo:2
		};


		// txt id_fina_regi_prog_proy_acti
		Atributos[19]={
			validacion:{
				pregarga:false,
				precargaAct:"../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEPempleado.php",
				fieldLabel:'Estructura Programatica',
				allowBlank:false,
				emptyText:'Estructura Program�tica',
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
				grid_indice:17,
				disabled:false,
				width:300
			},
			tipo:'epField',
			save_as:'txt_id_frppa',
			id_grupo:0
		};





		// txt estado_vigente_solicitud
		Atributos[20]={
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
				grid_indice:18
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.estado_vigente_solicitud',
			save_as:'txt_estado_vigente_solicitud',
			id_grupo:2
		};

		// txt estado_reg
		Atributos[21]={
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
				grid_indice:19
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.estado_reg',
			save_as:'txt_estado_reg',
			id_grupo:2
		};

		// txt modalidad
		Atributos[12]={
			validacion:{
				name:'modalidad',
				fieldLabel:'Modalidad',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['Nacional','Nacional'],['Internacional','Internacional']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_indice:20,
				width_grid:75,
				grid_editable:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto:'Nacional',
			filterColValue:'SOLADQ.modalidad',
			save_as:'txt_modalidad',
			id_grupo:2
			//id_grupo:3
		};

		// txt tipo_adjudicacion

		// txt id_solicitud_compra_ant
		Atributos[23]={//20
			validacion:{
				name:'id_solicitud_compra_ant',
				fieldLabel:'N� Sol. Anterior',
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
				grid_indice:21
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.id_solicitud_compra_ant',
			save_as:'txt_id_solicitud_compra_ant',
			id_grupo:2
		};



		Atributos[24]={//21
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



		Atributos[14]={
			validacion:{
				name:'tipo_adjudicacion',
				fieldLabel:'Tipo de Adjudicacion',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['total','total'],['lotes','lotes'],['item','item']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_indice:22,
				width_grid:75,
				grid_editable:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto:'total',
			filterColValue:'SOLADQ.tipo_adjudicacion',
			save_as:'txt_tipo_adjudicacion',
			id_grupo:1
		};



		// txt periodo
		Atributos[26]={//24
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
				grid_indice:23
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLADQ.periodo',
			save_as:'txt_periodo',
			id_grupo:1
		};
		


		// txt id_rpa
		Atributos[28]={//27
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
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_rpa,
				grid_visible:false,
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




		Atributos[29]={//28
			validacion:{
				name:'tipo_adq',
				fieldLabel:'Tipo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:26,
				width_grid:150
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_tipo',
			id_grupo:2
		};




		Atributos[30]={//32
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
				grid_indice:27
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			filterColValue:'ESTPRO.observaciones',
			save_as:'txt_observaciones_estado',
			id_grupo:3
		};



		Atributos[31]={//33
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

		Atributos[32]={//34
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
		Atributos[33]={//35
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

		Atributos[34]={//36
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

		Atributos[40]={//44
			validacion:{
				name:'fecha_venc',
				fieldLabel:'Fecha Venc.',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'D�a no v�lido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
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

		Atributos[41]={//28
			validacion:{
				name:'id_tipo_adq',
				fieldLabel:'Tipo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:26,
				width_grid:150
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'txt_id_tipo_adq',
			id_grupo:2
		};


		Atributos[42]={
			validacion:{
				labelSeparator:'',
				name: 'id_uo_gerencia',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_uo_gerencia',
			id_grupo:2
		};
		
		Atributos[43]={//23
			validacion:{
				name:'observaciones_estado',
				fieldLabel:'Observaciones del Estado',				
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:13
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
			
		};

		
		Atributos[17]={
			validacion:{
			name:'id_parametro_adquisicion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion_paradq,
			valueField: 'id_parametro_adquisicion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_gestionParadq,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion_paradq,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'80%',
			disable:false,
			grid_indice:7/**/
		},
		tipo:'ComboBox',
		form: true,
		//defecto:'Bolivianos',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'GESTIO.gestion',
		save_as:'txt_id_parametro_adquisicion',
		id_grupo:1
	};
	
	Atributos[44]={
		validacion:{
			labelSeparator:'',
			name: 'gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'txt_gestion',
		id_grupo:2
	};
	
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/solicitud_compra_bien/sol_compra_bien_det.php'};
		var layout_solbie=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_solbie.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_solbie,idContenedor);
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
		var cm_EnableSelect=this.EnableSelect;


		///////////////////////////////////
		// DEFINICI�N DE LA BARRA DE MEN�//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
		//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
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
			//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//


			//Para manejo de eventos
			function iniciarEventosFormularios(){
                
				ds_tipo_adq.baseParams={tipo_adq:'bien'};

				//para iniciar eventos en el formulario
				var txt_num_solicitud=getComponente('num_solicitud');//
				txt_fecha=getComponente('fecha_reg');
				txt_hora=getComponente('hora_reg');
				var txt_periodo=getComponente('periodo');//
				var txt_gestion=getComponente('id_parametro_adquisicion');//
				txt_localidad=getComponente('localidad');
				cmb_epI=getComponente('id_ep');
				var cmbTranscriptor=getComponente('id_usuario_transcriptor');//
				var cmbSolicitante=getComponente('id_empleado_frppa_solicitante');
				var cmbEPA=getComponente('id_empleado_frppa_pre_aprobacion');//
				var cmbEA=getComponente('id_empleado_frppa_aprobacion');//
				var cmbGFA=getComponente('id_empleado_frppa_gfa');//
				var cmbRPA=getComponente('id_rpa');//
				cmbMoneda=getComponente('id_moneda');
				var txt_id_tipo_adquisicion=getComponente('id_tipo_adq');
				var txt_fecha_venc=getComponente('fecha_venc');
				txt_id_moneda_base=getComponente('id_moneda_base');
				var combo_almacen=getComponente('id_almacen');
				var combo_almacen_logico=getComponente('id_almacen_logico');

				var onAlmacenSelect=function(e) {
					var id = combo_almacen.getValue();
					combo_almacen_logico.filterValues[0] =  id;
					var ep=cmb_epI.getValue();


					ds_almacen_logico.baseParams={
						id_uo:getComponente('id_uo_gerencia').getValue(),
						id_financiador:ep['id_financiador'],
						id_regional:ep['id_regional'],
						id_programa:ep['id_programa'],
						id_proyecto:ep['id_proyecto'],
						id_actividad:ep['id_actividad']

					}
					combo_almacen_logico.modificado = true;
					combo_almacen_logico.enable();//almacen logico
					combo_almacen_logico.setValue('');
					combo_almacen.modificado=true
				};

				combo_almacen.on('select',onAlmacenSelect);
				combo_almacen.on('change',onAlmacenSelect);

				

				cmb_epI.ep.setBaseParams({"id_empleado":empleado.id_empleado});
				cmb_epI.ep.modificado=true;
				cmb_epI.modificado=true;


				var onEPSelect=function(e){
					getComponente('id_almacen').setValue('');
					getComponente('id_almacen_logico').setValue('');
					txt_localidad.setValue('');
					
					//cmbUO.enable();
					txt_id_tipo_adquisicion.enable();
					var ep=cmb_epI.getValue();
					
					txt_localidad.setValue(ep['nombre_regional']);
					data_ep='id_fin='+ep['id_financiador']+'&id_reg='+ep['id_regional']+'&id_prog='+ep['id_programa']+'&id_proy='+ep['id_proyecto']+'&id_act='+ep['id_actividad'];

					
					ds_almacen.baseParams={
						id_financiador:ep['id_financiador'],
						id_regional:ep['id_regional'],
						id_programa:ep['id_programa'],
						id_proyecto:ep['id_proyecto'],
						id_actividad:ep['id_actividad']
					}

					
				}

				cmb_epI.on('select',onEPSelect);
				cmb_epI.on('change',onEPSelect);

				


				


				var onMonedaSelect=function(e){
					getMonedaPrincipal();
				}

				getComponente('id_moneda').on('select',onMonedaSelect);
				getComponente('id_moneda').on('change',onMonedaSelect);
				getComponente('fecha_reg').on('change',onMonedaSelect);

				

				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_solbie.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_solbie.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
				
		      var onGestion=function(c,r,i){
		          if(parseFloat(r.data.gestion)>0){
		              get_fecha_adq(r.data.gestion);
		          }
		      }
		      txt_gestion.on('select',onGestion);
			
			}


			function getMonedaPrincipal(){
			       Ext.MessageBox.show({
				       title: 'Cargando Tipo de Cambio...',
                	   msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Tipos de Cambio...</div>",
                	   width:150,
                	   height:200,
                	   closable:false
                	})
			    
			    
					Ext.Ajax.request({
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerMonedaPrincipal.php",
					method:'GET',
					success:cargar_moneda,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_moneda(resp){
				Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					txt_id_moneda_base.setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);

					if(getComponente('id_moneda').getValue()!=txt_id_moneda_base.getValue()){
						get_tipo_cambio(getComponente('id_moneda').getValue());
					}
					getComponente('id_moneda').clearInvalid();
					getDialog().buttons[0].show();
					getDialog().buttons[1].show();
					get_hora_bd();
				}
			}


			//funci�n para terminar la orden de ingreso
			function btn_fin_ped(){
				CM_ocultarGrupo('Origen Solicitud');
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();

					if(SelectionsRecord.data.estado_vigente_solicitud=='borrador'){
						var data=SelectionsRecord.data.id_solicitud_compra;

						if(confirm("�Est� seguro de terminar la Solicitud?")){
						    	Ext.MessageBox.show({
				                title: 'Espere por favor...',
                				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
                				width:150,
                				height:200,
                				closable:false
                			});
						    
						    Ext.Ajax.request({
								url:direccion+"../../../control/solicitud_compra/ActionGuardarSolicitudCompraFin.php?hidden_id_solicitud_compra_0="+data,
								method:'GET',
								success:terminado,
								failure:Cm_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							});

						}
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}


			function terminado(resp){
			    Ext.MessageBox.hide();
				
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('error')[0].firstChild.nodeValue)=='false'){
						ds.load({
							params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
								tipo:'personal',
								id_empleado:empleado.id_empleado,
								id_empresa:empleado.id_empresa,
								tipo_adq:'Bien'
							}
						});
					}
				}
			}



			function get_fecha_adq(gestion){
			    
				Ext.Ajax.request({
					
					url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+empleado.id_empresa+"&gestion="+gestion,
					method:'GET',
					success:cargar_fecha_adq,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			    
			}

			function cargar_fecha_adq(resp){
			    if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
						getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
						getComponente('fecha_reg').minValue=getComponente('fecha_reg').getValue();
						getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
						getComponente('fecha_reg').disable();
						if(root.getElementsByTagName('estado')[0].firstChild.nodeValue=='congelado'){
						  txt_hora.setValue('08:30:00');    
						}else{
						    get_hora_bd();
						}
						
                        getComponente('id_moneda').setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
                        getComponente('id_moneda').setRawValue(root.getElementsByTagName('nombre_moneda')[0].firstChild.nodeValue)
                        
                        getComponente('id_parametro_adquisicion').setValue(root.getElementsByTagName('id_parametro_adq')[0].firstChild.nodeValue);
                        getComponente('id_parametro_adquisicion').setRawValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
                        getComponente('gestion').setValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
	                   
					}else{
				        alert("No existe una gestion activa para Adquisiciones para "+getComponente('gestion').getValue());
				    }
				}
			}


			function get_fecha_bd(){
		    	Ext.MessageBox.show({
        				title: 'Cargando Datos de Fecha...',
        				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Fecha de Sistema...</div>",
        				width:150,
        				height:200,
        				closable:false
        			});
			    
				Ext.Ajax.request({
					url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
					method:'GET',
					success:cargar_fecha_bd,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

		function cargar_fecha_bd(resp){
		    Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
						getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
						getComponente('gestion').setValue(getComponente('fecha_reg').getValue().getFullYear());
				        get_fecha_adq(getComponente('gestion').getValue());
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
			    Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					txt_hora.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
				}
			}

			function get_tipo_cambio(moneda){
				Ext.Ajax.request({
					url:direccion+"../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambio.php?fecha_solicitud="+getComponente('fecha_reg').getValue().dateFormat('m-d-Y')+'&id_moneda='+moneda,
					method:'GET',
					success:cargar_tipo_cambio,
					failure:Cm_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_tipo_cambio(resp){
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue<1){
						getComponente('id_moneda').markInvalid("No existe tipo de cambio para la fecha seleccionada");
						getDialog().buttons[0].hide();
						getDialog().buttons[1].hide()
					}else{
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

				cmb_epI.ep.cargaEPprimaria({"id_empleado":empleado.id_empleado},carga_localidad);
				get_fecha_bd();
				get_bienes();
				getComponente('id_rpa').allowBlank=true;
                
				CM_btnNew();

			}

			function get_bienes(){
			    Ext.MessageBox.show({
				                title: 'Espere Por Favor...',
                				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Tipo de Adquisicion...</div>",
                				width:150,
                				height:200,
                				closable:false
                			});
			    
				Ext.Ajax.request({
					url:direccion+"../../../control/tipo_adq/ActionListarTipoAdq.php?tipo_adq=bien",
					method:'GET',
					success:cargar_tipo,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_tipo(resp){
			    Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
						getComponente('desc_tipo_adq').setValue(root.getElementsByTagName('nombre')[0].firstChild.nodeValue);
						getComponente('id_tipo_adq').setValue(root.getElementsByTagName('id_tipo_adq')[0].firstChild.nodeValue);
					}
				}
			}
			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_solbie.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_solbie.getIdContentHijo()).pagina.desbloquearMenu();
			}


			function carga_localidad(datos){
				if(datos['id_financiador']==undefined ||datos['id_financiador']==null||datos['id_financiador']==''){
					getComponente('id_ep').setValue('');
				}else{
					getComponente('localidad').setValue(datos['nombre_regional']);
                    onLocalidad();
				}
			}

            var onLocalidad=function(e){
						var ep= getComponente('id_ep').getValue();
						
						Ext.MessageBox.show({
				                title: 'Cargando Centro...',
                				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Centro...</div>",
                				width:150,
                				height:200,
                				closable:false
                			});
						
						Ext.Ajax.request({
							url:direccion+"../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarCentro.php?id_empleado="+empleado.id_empleado,
							method:'GET',
							success:cargar_centroSP,
							failure:Cm_conexionFailure,
							timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
						});
				}
			function cargar_centroSP(resp){
				    Ext.MessageBox.hide();
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
							getComponente('desc_unidad_organizacional').setValue(root.getElementsByTagName('centro')[0].firstChild.nodeValue);
							getComponente('id_unidad_organizacional').setValue(root.getElementsByTagName('id_unidad_organizacional')[0].firstChild.nodeValue);
							getComponente('id_uo_gerencia').setValue(root.getElementsByTagName('id_uo_gerencia')[0].firstChild.nodeValue);
						}
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
						CM_ocultarGrupo('Estructura Programatica');
						CM_ocultarGrupo('RPA');
						CM_mostrarGrupo('Origen Solicitud');
						CM_mostrarGrupo('Solicitud');
						CM_mostrarGrupo('Detalle Solicitud');
						getComponente('id_tipo_adq').enable();
						getComponente('id_rpa').allowBlank=true;
						getComponente('es_modificacion').setValue('modificacion');

						ds_almacen.baseParams={
							id_financiador:SelectionsRecord.data.id_financiador,
							id_regional:SelectionsRecord.data.id_regional,
							id_programa:SelectionsRecord.data.id_programa,
							id_proyecto:SelectionsRecord.data.id_proyecto,
							id_actividad:SelectionsRecord.data.id_actividad
						}
						getComponente('id_almacen_logico').filterValues[0]=SelectionsRecord.data.id_almacen;

						ds_almacen_logico.baseParams={
							id_uo:SelectionsRecord.data.id_uo_gerencia,
							id_financiador:SelectionsRecord.data.id_financiador,
							id_regional:SelectionsRecord.data.id_regional,
							id_programa:SelectionsRecord.data.id_programa,
							id_proyecto:SelectionsRecord.data.id_proyecto,
							id_actividad:SelectionsRecord.data.id_actividad
						}

						CM_btnEdit();
					}else{
						Ext.MessageBox.alert('Estado','Solo solicitudes en estado borrador');
					}
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}



			//para que los hijos puedan ajustarse al tama�o
			this.getLayout=function(){return layout_solbie.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar el Pedido',btn_fin_ped,true,'fin_ped','');


			this.iniciaFormulario();
			iniciarEventosFormularios();
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					tipo:'personal',
					id_empleado:empleado.id_empleado,
					id_empresa:empleado.id_empresa,
					tipo_adq:'Bien'
				}
			});

			layout_solbie.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}