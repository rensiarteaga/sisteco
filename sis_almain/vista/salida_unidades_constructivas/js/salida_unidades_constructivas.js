/**
* Nombre:		  	    salida_unidades_constructivas.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		27-10-2014
*/
function PaginaSalidaUnidadesConstructivas(idContenedor,direccion,paramConfig,salida_estado)
{
	var vectorAtributos=new Array;
	var componentes=new Array();
	var idAlmacen;
	var ds;
	var sw=0;
	
	var combo_solicitante,combo_proveedor,combo_contratista,combo_empleado;
	var combo_institucion,combo_motivo_ingreso,combo_motivo_ingreso_cuenta,cmb_ep;
	var combo_fase,combo_tramo,combo_uc;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos 
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida_unidades_constructivas/ActionListarSalidaUnidadesConstructivas.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_salida_uc',
			totalRecords: 'TotalCount'

		}, [
		    'id_salida_uc','id_almacen'
		    ,'desc_almacen','id_contratista','desc_contratista'
		    ,'id_proveedor','desc_proveedor','id_institucion','desc_institucion','id_empleado','desc_empleado'
		    ,'id_fase','desc_fase','id_tramo','desc_tramo','id_unidad_constructiva','desc_uc','nro_contrato'
		    ,{name:'fecha_salida',type:'date',dateFormat:'d-m-Y'},
		    ,'concepto_salida','observaciones','supervisor','ci_supervisor','receptor','ci_receptor','solicitante','ci_solicitante'
		    ,'usuario_reg',
		    {
				name : 'fecha_reg',
				type : 'date',
				dateFormat : 'd-m-Y'
			}
		    ,'origen_salida'
		]),remoteSort:true
	});
	
	ds.lastOptions = {
			params : {  
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros
			}
		};

		var ds_almacen = new Ext.data.Store({
			proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/almacen/ActionListarAlmacen.php'}),
			reader : new Ext.data.XmlReader
			({
				record : 'ROWS',
				id : 'id_almacen',
				totalRecords : 'TotalCount'
			}, [ 'id_almacen', 'codigo', 'nombre' ]) 
		});

		
		//ds_almacen
		function render_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
		var tpl_almacen=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{direccion}</FONT>','</div>');
		
	
		var TaskLocation = Ext.data.Record.create([ {
			name : "id_almacen"
		}, {
			name : "codigo"
		}, {
			name : "nombre"
		} ]); 
		
		var cbxSisAlma = new Ext.form.ComboBox({
			store : ds_almacen,
			fieldLabel : 'Almacen',
			displayField : 'nombre',
			typeAhead : true,
			loadMask : true,
			mode : 'remote',
			triggerAction : 'all',
			emptyText : 'Almacen...',
			selectOnFocus : true,
			queryParam : 'filterValue_0',
			filterCol : 'al.nombre',
			width : 180,
			valueField : 'id_almacen'
		});
		
		cbxSisAlma.on('select', function(combo, record, index) {
			cm_DesbloquearMenu();
			idAlmacen = cbxSisAlma.getValue();
			ds.baseParams.m_id_almacen = idAlmacen;
			cm_btnActualizar();
			combo.modificado = true;
			
			ds_fase.baseParams.id_almacen_fase = idAlmacen;
		});
		
	//DATA STORE COMBOS
	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proveedor',totalRecords: 'TotalCount'}, ['id_proveedor','codigo','observaciones','fecha_reg','id_institucion','id_persona','desc_persona','nombre_proveedor'])});
	var ds_contratista = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/contratista/ActionListarContratista.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_contratista',totalRecords: 'TotalCount'}, ['id_contratista','codigo','observaciones','estado_registro','fecha_reg','id_institucion','id_persona','nombre_contratista','pagina_web','email','direccion'])});

	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleadoEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_empleado',
		totalRecords: 'TotalCount'
	}, ['id_empleado','id_persona','codigo_empleado','desc_persona'])});

	var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_institucion',totalRecords: 'TotalCount'}, ['id_institucion','direccion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])});
	
	//id_fase,id_tramo,id_unidad_constructiva
	var ds_fase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fase/ActionListarFase.php'}),
				  reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_fase',totalRecords: 'TotalCount'}, ['id_fase','descripcion','codigo','observaciones','sw_tramo','id_almacen'])}); 
	var ds_tramo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fase_tramo/ActionListarFaseTramo.php'}),
		  reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_fase_tramo',totalRecords: 'TotalCount'}, ['id_fase_tramo','id_fase','id_tramo','desc_fase','desc_tramo'])});
	var ds_uc = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tramo_unidad_constructiva/ActionListarTramoUnidadConstructiva.php'}),
		  reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_tramo_unidad_constructiva',totalRecords: 'TotalCount'}, ['id_tramo_unidad_constructiva','id_unidad_constructiva','id_tramo','codigo','desc_tramo','desc_uc'])});
		
	
	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista']);}
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	
	//id_fase,id_tramo,id_unidad_constructiva
	function render_id_fase(value, p, record){return String.format('{0}', record.data['desc_fase']);}
	function render_id_tramo(value, p, record){return String.format('{0}', record.data['desc_tramo']);}
	function render_id_uc(value, p, record){return String.format('{0}', record.data['desc_uc']);}
	
    function render_observaciones(value, p, record){return String.format('<b><font color="#FF0000">{0}</font></b>', record.data['observaciones'])}
	//TEMPLATE COMBOS
	
	var resultTplProveedor = new Ext.Template('<div class="search-item">','<b>{codigo}</b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	var resultTplContratista = new Ext.Template('<div class="search-item">','<b>{nombre_contratista}</b>','<br><FONT COLOR="#B5A642">{codigo}','<br>{email}','<br>{direccion}</FONT>','</div>');
	var resultTplInstitucion = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{email1}','<br>{pag_web}','<br>{direccion}</FONT>','</div>');
	var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b>{codigo_empleado}</b>','<br><FONT COLOR="#B5A642">{desc_persona}</FONT>','</div>');
	
	//id_fase,id_tramo,id_unidad_constructiva
	var tpl_fase = new Ext.Template('<div class="search-item">','<b>{codigo}</b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var tpl_tramo = new Ext.Template('<div class="search-item">','<b>{desc_tramo}</b>','</div>');
	var tpl_uc = new Ext.Template('<div class="search-item">','<b>{desc_uc}</b>','</div>');
	
	/////////////////////////
	// Definicion de datos //
	/////////////////////////
	vectorAtributos = [
	                   
		{
			validacion : {
				labelSeparator : '',
				name : 'id_salida_uc',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0:false,
			save_as : 'hidden_id_salida_uc'
		},
		{
			validacion : {
				labelSeparator : '',
				name : 'id_almacen',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			save_as : 'hidden_id_almacen'
		},
		{
			validacion : {
				name : 'nro_contrato',
				fieldLabel : 'N� Contrato',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width:300,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'suc.nro_contrato',
			form : true,
			save_as : 'txt_nro_contrato',
			id_grupo:0
		},
		{
			validacion:{
				name:'fecha_salida',
				fieldLabel:'Fecha Salida',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Dia no valido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false 
			},
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'suc.fecha_salida',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_sal',
			id_grupo:1
		},
		{
			validacion:{
				name:'concepto_salida', 
				fieldLabel:'Concepto Salida',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				width:'100%',
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:130
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'suc.concepto_salida',
			save_as:'txt_concepto_salida',
			id_grupo:1
		},
		{
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				disabled:false,
				renderer:render_observaciones,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%'
			},
			form:true,
			tipo:'TextArea',
			filtro_0:true,
			filterColValue:'suc.observaciones',
			save_as:'txt_observaciones',
			id_grupo:1
		},
		{
			validacion: {
				name:'origen_salida',
				fieldLabel:'Origen',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data :[
					       	['contratista','Contratista'],
					       	['proveedor','Proveedor'],
					       	['empleado','Funcionario'],
					       	['institucion','Institucion']
						]
				}), 
				mode:'local',
				valueField:'ID',
				displayField:'valor',  
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width:300,
				width_grid:80 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			form:true,
			filterColValue:'suc.origen_salida',
			save_as:'txt_origen_salida',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_proveedor',
				fieldLabel:'Proveedor',
				allowBlank:true,
				emptyText:'Proveedor...',
				name: 'id_proveedor',
				desc: 'desc_proveedor',
				store:ds_proveedor,
				valueField: 'id_proveedor',
				displayField: 'nombre_proveedor',
				queryParam: 'filterValue_0',
				filterCol:'PROVEE.codigo#PROVEE.observaciones',
				tpl: resultTplProveedor,
				typeAhead:true,
				forceSelection:true,
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
				editable:true,
				renderer:render_id_proveedor,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'prov.codigo',
			defecto: '',
			save_as:'txt_id_proveedor',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_contratista',
				fieldLabel:'Contratista',
				allowBlank:true,
				emptyText:'Contratista...',
				name: 'id_contratista',
				desc: 'desc_contratista',
				store:ds_contratista,
				valueField: 'id_contratista',
				displayField: 'nombre_contratista',
				queryParam: 'filterValue_0',
				filterCol:'CONTRA.codigo#INSTIT.nombre#INSTIT.pag_web#INSTIT.email1#INSTIT.direccion#PERSON.pag_web#INSTIT.email1',
				tpl: resultTplContratista,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:300,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_contratista,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'cont.codigo', 
			defecto: '',
			save_as:'txt_id_contratista',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_empleado',
				fieldLabel:'Funcionario',
				allowBlank:true,
				emptyText:'Funcionario...',
				name: 'id_empleado',
				desc: 'desc_empleado',
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField: 'desc_persona',
				queryParam: 'filterValue_0',
				filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				tpl: resultTplEmpleado,
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
				renderer:render_id_empleado,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'emp.id_persona',
			defecto: '',
			save_as:'txt_id_empleado',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_institucion',
				fieldLabel:'Institucion',
				allowBlank:true,
				emptyText:'Institucion...',
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
				width_grid:100,
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'ins.nombre',
			defecto: '',
			save_as:'txt_id_institucion',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_fase',
				fieldLabel:'Fase',
				allowBlank:false,
				emptyText:'Fase...',
				name: 'id_fase',
				desc: 'desc_fase',
				store:ds_fase,
				valueField: 'id_fase',
				displayField: 'codigo',
				queryParam: 'filterValue_0',
				filterCol:'fa.descripcion#fa.codigo',
				tpl: tpl_fase,
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
				renderer:render_id_fase,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'suc.id_fase',
			defecto: '',
			save_as:'txt_id_fase',
			id_grupo:2
		},
		{
			validacion: {
				name:'id_tramo',
				fieldLabel:'Tramo',
				allowBlank:true,
				emptyText:'Tramo...',
				name: 'id_tramo',
				desc: 'desc_tramo',
				store:ds_tramo,
				valueField: 'id_tramo',
				displayField: 'desc_tramo',
				queryParam: 'filterValue_0',
				filterCol:'tram.codigo#tram.descripcion',
				tpl: tpl_tramo,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				onSelect: function(record)
				{
					cm_getComponente('id_tramo').setValue(record.data.id_tramo); 
					cm_getComponente('aux_id_fase').setValue(record.data.fase); 
					cm_getComponente('id_tramo').collapse();
				},
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
				renderer:render_id_tramo,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'suc.id_tramo',
			defecto: '',
			save_as:'txt_id_tramo',
			id_grupo:2
		},
		{
			validacion:{
				labelSeparator:'',
				name: 'aux_id_fase',
				inputType:'hidden'
				},
			tipo: 'Field'				
		},
		{
			validacion: {
				name:'id_unidad_constructiva',
				fieldLabel:'Unidad Constructiva',
				allowBlank:true,
				emptyText:'UnidadConstructiva...',
				name: 'id_unidad_constructiva',
				desc: 'desc_uc',
				store:ds_uc,
				valueField: 'id_unidad_constructiva',
				displayField: 'desc_uc',
				queryParam: 'filterValue_0',
				filterCol:'',
				tpl: tpl_uc,
				typeAhead:true,
				onSelect: function(record)
				{
					cm_getComponente('id_unidad_constructiva').setValue(record.data.id_unidad_constructiva); 
					cm_getComponente('aux_id_tramo').setValue(record.data.id_tramo); 
					cm_getComponente('id_unidad_constructiva').collapse();
				},
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
				renderer:render_id_uc,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'suc.id_unidad_constructiva',
			defecto: '',
			save_as:'txt_id_uc',
			id_grupo:2
		},
		{
			validacion:{
				labelSeparator:'',
				name: 'aux_id_tramo',
				inputType:'hidden'
				},
			tipo: 'Field'				
		},
		{
			validacion : {
				name : 'supervisor',
				fieldLabel : 'Supervisor',
				align : 'left',
				grid_visible : true,
				width:300,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.supervisor',
			form : true,
			save_as : 'txt_supervisor',
			id_grupo:2
		},
		{
			validacion : {
				name : 'ci_supervisor',
				fieldLabel : 'CI Supervisor',
				align : 'left',
				width:300,
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.ci_supervisor',
			form : true,
			save_as : 'txt_ci_supervisor',
			id_grupo:2
		},
		{
			validacion : {
				name : 'receptor',
				fieldLabel : 'Receptor',
				align : 'left',
				width:300,
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.receptor',
			save_as : 'txt_receptor',
			form : true,
			id_grupo:2
		},
		{
			validacion : {
				name : 'ci_receptor',
				fieldLabel : 'CI Receptor',
				align : 'left',
				width:300,
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.ci_receptor',
			form : true,
			save_as : 'txt_ci_receptor',
			id_grupo:2
		},
		{
			validacion : {
				name : 'solicitante',
				fieldLabel : 'Solicitante',
				align : 'left',
				width:300,
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.solicitante',
			form : true,
			save_as : 'txt_solicitante',
			id_grupo:2
		},
		{
			validacion : {
				name : 'ci_solicitante',
				fieldLabel : 'CI Solicitante',
				align : 'left',
				width:300,
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'suc.ci_solicitante',
			form : true,
			save_as : 'txt_ci_solicitante',
			id_grupo:2
		},
		{
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'movpr.usuario_reg',
			form : false
		},
		{
			validacion : {
				name : 'fecha_reg',
				fieldLabel : 'Fecha Registro',
				format : 'd/m/Y',
				minValue : '01/01/1900',
				grid_visible : true,
				grid_editable : false,
				renderer : formatDate,
				align : 'center',
				width_grid : 95
			},
			tipo : 'TextField',
			form : false,
			filtro_0 : false,
			filterColValue : 'movpr.fecha_reg',
			dateFormat : 'm-d-Y'
		}
	    ];

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Ingreso Proyectos',
		grid_maestro:'grid-'+idContenedor,
		urlHijo : '../../../sis_almain/vista/movimiento_proyecto/movimiento_proyecto_det.php'
	};
	layout_salida_uc=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_salida_uc.init(config); 

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_uc,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var cm_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var cm_btnActualizar = this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var cm_EnableSelect=this.EnableSelect; 
	var cm_DeselectRow = this.DeselectRow;

	
	ds_almacen.on('load', function(store, records, options) {ds_almacen.commitChanges();}, this);
	ds.baseParams.id_almacen = idAlmacen;
	
	this.btnNew = function()
	{
		
		ClaseMadre_btnNew();
		cm_getComponente('id_almacen').setValue(idAlmacen);
		
		CM_mostrarComponente(cm_getComponente('id_contratista'));//contratista
		CM_ocultarComponente(cm_getComponente('id_proveedor'));//proveedor
		CM_ocultarComponente(cm_getComponente('id_empleado'));//funcionario
		CM_ocultarComponente(cm_getComponente('id_institucion'))//institucion
		
		
	}

	//Sobrecarga del edit, para desplegar el origen del ingreso
	this.btnEdit = function()
	{
		ClaseMadre_btnEdit();
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect != 0)
		{
			var SelectionsRecord=sm.getSelected();
			
			if(SelectionsRecord.data.id_contratista!='')
			{
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_contratista')); 
			}
			else if(SelectionsRecord.data.id_proveedor!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_proveedor'));
			}
			else if(SelectionsRecord.data.id_empleado!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_empleado'));
			}
			else if(SelectionsRecord.data.id_institucion!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_mostrarComponente(cm_getComponente('id_institucion'));
			}
		}
		cm_btnActualizar();
	}

	this.EnableSelect = function(selEvent, rowIndex, selectedRow) 
	{
		cm_EnableSelect(selEvent, rowIndex, selectedRow);

		_CP.getPagina(layout_salida_uc.getIdContentHijo()).pagina.reload(selectedRow.data);
		_CP.getPagina(layout_salida_uc.getIdContentHijo()).pagina.desbloquearMenu();
	}
	this.DeselectRow = function(n, n1)
	{
		//cm_getBoton('FinalizarEnviarMovimiento-' + idContenedor).disable();
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout_salida_uc.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout_salida_uc.getIdContentHijo()).pagina.bloquearMenu();
	};

	var paramMenu={
		nuevo:{crear:true,separador:false},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICION DE FUNCIONES ------------------------- //
	
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/salida_unidades_constructivas/ActionEliminarMovimientoProyecto.php'},
		Save:{url:direccion+'../../../control/salida_unidades_constructivas/ActionGuardarSalidaUnidadesConstructivas.php'},
		ConfirmSave:{url:direccion+'../../../control/salida_unidades_constructivas/ActionGuardarMovimientoProyecto.php'},
		Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',
		columnas:['96%'],
		closable : true,
		grupos:[
				{tituloGrupo:'Origen Orden Salida',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Pedido',columna:0,id_grupo:1},
				{tituloGrupo:'Seguimiento',columna:0,id_grupo:2},

				],
				minWidth:150,minHeight:200,	closable:true,titulo:'Salida por Unidades Constructivas'}
	}; 

	
	function iniciarEventosFormularios()
	{
		combo_solicitante = cm_getComponente('origen_salida');
		combo_proveedor = cm_getComponente('id_proveedor');
		combo_contratista = cm_getComponente('id_contratista');
		combo_empleado = cm_getComponente('id_empleado');
		combo_institucion = cm_getComponente('id_institucion');
				
		var onSolicitanteSelect = function(e) {
			var valor = combo_solicitante.getValue();
			if(valor == 'contratista'){
				CM_mostrarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_contratista').allowBlank=false;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if (valor == 'proveedor'){
				CM_mostrarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_proveedor').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if(valor == 'empleado'){
				CM_mostrarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_empleado').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if(valor == 'institucion'){
				CM_mostrarComponente(cm_getComponente('id_institucion'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'))
				
				cm_getComponente('id_institucion').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;

			}
		};
		
		var onSolicitanteChange = function(e) {
			var valor = combo_solicitante.getValue();
			if(valor == 'contratista'){
				combo_proveedor.setValue('');
				combo_empleado.setValue('');
				combo_institucion.setValue('')

			}else if (valor == 'proveedor'){
				combo_contratista.setValue('');
				combo_empleado.setValue('');
				combo_institucion.setValue('')

			}else if(valor == 'empleado'){
				combo_proveedor.setValue('');
				combo_contratista.setValue('');
				combo_institucion.setValue('')

			}else if(valor == 'institucion'){
				combo_proveedor.setValue('');
				combo_empleado.setValue('');
				combo_contratista.setValue('')
			}
		};
		
		
		combo_fase = cm_getComponente('id_fase');
		combo_tramo = cm_getComponente('id_tramo');
		combo_uc =  cm_getComponente('id_unidad_constructiva');
		

		var onFaseSelect = function(e)
		{
			combo_tramo.setValue('');
			cm_getComponente('id_tramo').store.baseParams={
			    m_id_fase:combo_fase.getValue()
			};
			cm_getComponente('id_tramo').modificado=true;
		};
		
		combo_fase.on('change',onFaseSelect);
		combo_fase.on('select',onFaseSelect);
		
		var onTramoSelect = function(e)
		{
			combo_uc.setValue('');
			cm_getComponente('id_unidad_constructiva').store.baseParams={m_id_tramo:combo_tramo.getValue()};
			cm_getComponente('id_unidad_constructiva').modificado=true;
		};
		
		combo_tramo.on('change',onTramoSelect);
		combo_tramo.on('select',onTramoSelect);	  
		
		combo_solicitante.on('select',onSolicitanteSelect);
		combo_solicitante.on('change',onSolicitanteSelect);
		
		combo_proveedor.on('change',onSolicitanteChange);
		combo_contratista.on('change',onSolicitanteChange);
		combo_institucion.on('change',onSolicitanteChange);
		combo_empleado.on('change',onSolicitanteChange);
		
	
				
	}
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu; 
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	 
	cm_BloquearMenu();
	
	this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');
 
	
	iniciarEventosFormularios();
	
	layout_salida_uc.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}