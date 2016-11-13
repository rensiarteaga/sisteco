/**
 * Nombre:		  	    pagina_empleado_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_empleado(idContenedor,direccion,paramConfig,tipo){
	var vectorAtributos=new Array;
	var ds,ds_persona;
	var elementos=new Array();
	var layout_empleado;
	var combo_persona,txt_codigo_empleado,txt_nombre_tipo_documento;
    var txt_doc_id,txt_email1;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	
	if(tipo=='sel_per'){
		ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado/ActionListarSelPersonal.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_persona',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'desc_persona',
		'doc_id',
		'id_tipo_doc_identificacion',
		'genero',
		'telefono1',
		'celular1',
		'email1',
		'direccion',
		'observaciones',
		'nro_registro',
		{name: 'fecha_nacimiento',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});
		
		
		 ds_tipo_doc_identificacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_doc_identificacion/ActionListarTipoDocIdentificacion.php'}),	reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_tipo_doc_identificacion',totalRecords: 'TotalCount'}, ['id_tipo_doc_identificacion','nombre_tipo_documento','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
		});
			function render_id_tipo_doc_identificacion(value, p, record){return String.format('{0}', record.data['desc_tipo_doc_identificacion']);}
	}else{
		ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado/ActionListarFuncionario.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado',
		'id_persona',
		'desc_persona',
		
		'nombre_cargo',
		'nombre_unidad_presupuesta',
		
		'codigo_empleado',
		'nombre_tipo_documento',
		'doc_id',
		'email1',		
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},		
		
		'nombre_cuenta',		
		'nombre_auxiliar','id_depto',
		'desc_depto','id_lugar_trabajo',
		'desc_lugar',
		{name: 'fecha_ingreso',type:'date',dateFormat:'Y-m-d'},	
		'antiguedad_ant','id_usuario_reg','id_escala_salarial','desc_usuario','desc_escala_salarial','compensa','marca','nivel_academico'
			
		]),remoteSort:true});
		
		
		
		//DATA STORE COMBOS
    var ds_persona=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php?txt_empleado_persona=1'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_tipo_doc_identificacion','desc_per'])
	});
    
	 var ds_depto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=kard'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto',
			totalRecords: 'TotalCount'
		}, ['id_depto','codigo_depto','nombre_depto','nombre_corto','nombre_largo','id_lugar','desc_lugar'])
	});
	
	var ds_lugar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php?sw_municipio_combo=si&subsis=kard'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, ['id_lugar','nombre','ubicacion'])
	});
	
	function render_id_persona(value,p,record){return String.format('{0}',record.data['desc_persona'])}	
	function render_id_depto(value,p,record){return String.format('{0}',record.data['desc_depto'])}	
	function render_id_lugar(value,p,record){return String.format('{0}',record.data['desc_lugar'])}	
	// Definición de datos //
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';}; 
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{codigo_depto}-{nombre_depto}<br>','<b><FONT COLOR="#B5A642">{desc_lugar}</FONT></b>','</div>');


	var ds_escala_salarial=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/escala_salarial/ActionListarEscalaSalarial.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_escala_salarial',
			totalRecords: 'TotalCount'
		}, ['id_escala_salarial','nombre','nivel'])
	});
	
	function render_id_escala(value,p,record){return String.format('{0}',record.data['desc_escala_salarial'])}	
	
}
	
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	
	
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
    function render_compensa_marca(value){
		if(value=='si'){value='Si'	}
		else{	value='No'		}
		return value
	}
	//FUNCIONES RENDER	
		
	
	if(tipo=='sel_per'){
		vectorAtributos[0]={
				validacion:{
					labelSeparator:'',
					name:'id_persona',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_persona'
			};
			
			vectorAtributos[1]={
				validacion:{
					name:'desc_persona',
					fieldLabel:'Persona',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					disabled:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:3
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'UNIORG.nombre_cargo'	
				filterColValue:'desc_persona'	
			};
			
			vectorAtributos[1] = param_apellido_paterno;
// txt apellido_materno
	var param_apellido_materno= {
		validacion:{
			name:'apellido_materno',
			fieldLabel:'Apellido Materno',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_materno',
		save_as:'txt_apellido_materno',
		id_grupo:0
	};
	vectorAtributos[2] = param_apellido_materno;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	vectorAtributos[3] = param_nombre;
// txt fecha_nacimiento
	var param_fecha_nacimiento= {
		validacion:{
			name:'fecha_nacimiento',
			fieldLabel:'Fecha Nacimiento',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.fecha_nacimiento',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_nacimiento',
		id_grupo:0
	};
	vectorAtributos[4] = param_fecha_nacimiento;
	
	var param_id_tipo_doc_identificacion= {
			validacion: {
			name:'id_tipo_doc_identificacion',
			fieldLabel:'Tipo de Documento de Identificación',
			allowBlank:false,			
			emptyText:'Documento de Identificación...',
			desc: 'desc_tipo_doc_identificacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_doc_identificacion,
			valueField: 'id_tipo_doc_identificacion',
			displayField: 'nombre_tipo_documento',
			queryParam: 'filterValue_0',
			filterCol:'TIDOID.nombre_tipo_documento',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_doc_identificacion,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIDOID.nombre_tipo_documento',
		defecto: '',
		save_as:'txt_id_tipo_doc_identificacion',
		id_grupo:1
	};
	vectorAtributos[6] = param_id_tipo_doc_identificacion;
	
	var param_genero= {
			validacion: {
			name:'genero',
			fieldLabel:'Genero',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.persona_combo.genero
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.genero',
		defecto:'varon',
		save_as:'txt_genero',
		id_grupo:0
	};
	vectorAtributos[7] = param_genero;
	
	
	var param_telefono1= {
		validacion:{
			name:'telefono1',
			fieldLabel:'Telefono 1',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.telefono1',
		save_as:'txt_telefono1',
		id_grupo:2
	};
	vectorAtributos[9] = param_telefono1;
	
	var param_celular1= {
		validacion:{
			name:'celular1',
			fieldLabel:'Celular 1',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.celular1',
		save_as:'txt_celular1',
		id_grupo:2
	};
	}else{
			vectorAtributos[0]={
				validacion:{
					labelSeparator:'',
					name:'id_empleado',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'hidden_id_empleado'
			};
			
			
			vectorAtributos[1]={
					validacion: {
					name:'id_depto',
					fieldLabel:'Departamento',
					allowBlank:false,			
					emptyText:'Departamento...',
					desc:'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_depto,
					valueField:'id_depto',
					displayField:'nombre_depto',
					filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
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
					renderer:render_id_depto,
					grid_visible:true,
					grid_editable:false,
					tpl:tpl_id_depto,
					locked:false,
					grid_indice:10,
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:true,   
				//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				filterColValue:'DEPTO.codigo_depto#DEPTO.nombre_depto',
				defecto: '',
				save_as:'id_depto'
			};
			
			// txt id_persona
			vectorAtributos[2]={
					validacion: {
					name:'id_persona',
					fieldLabel:'Persona',
					allowBlank:false,			
					//emptyText:'Funcionario...',
					desc:'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_persona,
					valueField:'id_persona',
					displayField:'desc_per',
					filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
					typeAhead:false,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:15,
					minListWidth:350,
					grow:true,
					width:'100%',
					resizable:true,
					confTrigguer:{
						url:direccion+'../../../../sis_seguridad/vista/persona/persona.php?tipo=empleado',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
				},
					queryParam:'filterValue_0',
					minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_persona,
					grid_visible:true,
					grid_editable:false,
					locked:true,
					grid_indice:2,
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboTrigger',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				filterColValue:'FUNCIO.desc_persona',
				defecto: '',
				save_as:'txt_id_persona'
			};
			
			// txt codigo_empleado
			vectorAtributos[3]={
				validacion:{
					name:'nombre_cargo',
					fieldLabel:'Nombre del Cargo',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					disabled:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:3
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'UNIORG.nombre_cargo'	
				filterColValue:'FUNCIO.nombre_cargo'	
			};
			
			// txt codigo_empleado
			vectorAtributos[4]={
				validacion:{
					name:'nombre_unidad_presupuesta',
					fieldLabel:'Unidad de Presupuesto',
					allowBlank:true,
					maxLength:20,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					disabled:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:4
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'nombre_unidad_presupuesta'
				filterColValue:'FUNCIO.nombre_unidad_presupuesta'		
			};
			
			// txt codigo_empleado
			vectorAtributos[5]={
				validacion:{
					name:'codigo_empleado',
					fieldLabel:'Código Funcionario',
					allowBlank:true,
					maxLength:20,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					locked:true,
					grid_indice:1,
					width_grid:49
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'EMPLEA.codigo_empleado',
				filterColValue:'FUNCIO.codigo_empleado',
				save_as:'txt_codigo_empleado'
			};
			
			// txt tipo_documento
			vectorAtributos[6]={
				validacion:{
					name:'nombre_tipo_documento',
					fieldLabel:'Tipo Documento',
					allowBlank:true,
					selectOnFocus:true,
					//vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:5
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'TDOCID.nombre_tipo_documento',
				filterColValue:'FUNCIO.nombre_tipo_documento',
				save_as:'txt_nombre_tipo_documento'
			};
			
			// txt doc_id
			vectorAtributos[7]={
				validacion:{
					name:'doc_id',
					fieldLabel:'Nº Documento',
					allowBlank:true,
					selectOnFocus:true,
					//vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:100,
					grid_indice:6
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'PERSON.doc_id',
				filterColValue:'FUNCIO.doc_id',
				save_as:'txt_doc_id'
			};
			
			// txt email1
			vectorAtributos[8]={
				validacion:{
					name:'email1',
					fieldLabel:'E-Mail',
					allowBlank:true,
					selectOnFocus:true,
					vtype:'email',
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					grid_indice:7,
					disabled:false
				},
				tipo:'TextField',
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'PERSON.email1',
				filterColValue:'FUNCIO.email1',
				save_as:'txt_email1'
			};	
			
			vectorAtributos[9]= {
				validacion: {
					name:'estado_reg',			
					fieldLabel:'Estado',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_estado_reg,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:100,
					grid_indice:8
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:false,
				filterColValue:'FUNCIO.estado_reg',
				save_as:'estado_reg'
			};
			
			vectorAtributos[10]= {	
				validacion:{
					name:'fecha_reg',
					fieldLabel:'Fecha Registro',
					allowBlank:true,
					format: 'd/m/Y', //formato para validacion
					minValue: '01/01/1900',
					disabledDaysText: 'Día no válido',
					grid_visible:true,
					grid_editable:false,
					grid_indice:9,
				    renderer: formatDate,
					width_grid:100
				},
				form:false,
				filtro_0:true,
				filtro_1:true,
				filterColValue:'FUNCIO.fecha_reg',
				tipo:'DateField',
				dateFormat:'m-d-Y',
				save_as:'txt_fecha_hasta'	
			};
			
			// txt cuenta
			vectorAtributos[11]={
				validacion:{
					name:'nombre_cuenta',
					fieldLabel:'Cuenta',
					allowBlank:true,
					selectOnFocus:true,
					//vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:150
				},
				tipo:'TextField',
				form:false,
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'CUENTA.nombre_cuenta'
				filterColValue:'FUNCIO.nombre_cuenta'		
			};
			
			// txt auxiliar
			vectorAtributos[12]={
				validacion:{
					name:'nombre_auxiliar',
					fieldLabel:'Auxiliar',
					allowBlank:true,
					selectOnFocus:true,
					//vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:150
				},
				tipo:'TextField',
				form:false,
				filtro_0:true,
				filtro_1:true,
				//filterColValue:'AUXILI.nombre_auxiliar'
				filterColValue:'FUNCIO.nombre_auxiliar'
			};
			
			vectorAtributos[13]={
					validacion: {
					name:'id_lugar_trabajo',
					fieldLabel:'Lugar de Trabajo',
					allowBlank:false,			
					emptyText:'Lugar Trabajo...',
					desc:'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_lugar,
					valueField:'id_lugar',
					displayField:'nombre',
					filterCol:'LUGARR.nombre',
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
					renderer:render_id_lugar,
					grid_visible:true,
					grid_editable:false,
					//tpl:tpl_id_lugar,
					locked:false,
					grid_indice:10,
					width_grid:230 // ancho de columna en el gris
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:true,   
				//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				filterColValue:'LUGAR.nombre',
				defecto: '',
				save_as:'id_lugar'
			};
			
			vectorAtributos[14]= {	
				validacion:{
					name:'fecha_ingreso',
					fieldLabel:'Fecha de Ingreso',
					allowBlank:true,
					format: 'd/m/Y', //formato para validacion
					minValue: '01/01/1900',
					disabledDaysText: 'Día no válido',
					grid_visible:true,
					grid_editable:false,
					grid_indice:10,
				    renderer: formatDate,
					width_grid:100
				},
				form:true,
				filtro_0:true,
				filtro_1:true,
				filterColValue:'FUNCIO.fecha_ingreso',
				tipo:'DateField',
				dateFormat:'m-d-Y',
				save_as:'fecha_ingreso'	
			};
			
			// antiguedad_ant
			vectorAtributos[15]={
					validacion:{
						name:'antiguedad_ant',
						fieldLabel:'Antiguedad Anterior (Meses)',
						allowBlank:true,
						align:'right',
						maxLength:50,
						minLength:0,
						selectOnFocus:true,
						allowDecimals:false,
						decimalPrecision:0,//para numeros float
						allowNegative:false,
						minValue:0,
						grid_visible:true,
						grid_editable:false,
						width_grid:100,
						grid_indice:11,
						width:'100%',
						disabled:false
					},
					tipo: 'NumberField',
					form: true,
					filtro_0:true,
					//id_grupo:2,
					filterColValue:'FUNCIO.antiguedad_ant'
				};
				
		vectorAtributos[16]={
			validacion: {
			name:'id_escala_salarial',
			fieldLabel:'Nivel',
			allowBlank:true	,			
			emptyText:'Nivel...',
			desc:'desc_escala_salarial', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_escala_salarial,
			valueField:'id_escala_salarial',
			displayField:'nivel',
			filterCol:'ESCSAL.nivel',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:70,
			pageSize:15,
			minListWidth:70,
			grow:true,
			width:'100%',
			renderer:render_id_escala,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			locked:true,
			grid_indice:2,
			width_grid:30 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:true,   
		//filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		filterColValue:'ESCSAL.nivel',
		defecto: '',
		save_as:'id_escala_salarial'
		};
		vectorAtributos[17]={
				validacion:{
					labelSeparator:'',
					name:'desc_usuario',
					inputType:'hidden',
					grid_visible:true, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'desc_usuario'
			};
			vectorAtributos[18]= {
				validacion: {
					name:'compensa',			
					fieldLabel:'Compensa',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_compensa_marca,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:100
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:false,
				filterColValue:'FUNCIO.estado_reg',
				save_as:'compensa'
			};
			vectorAtributos[19]= {
				validacion: {
					name:'marca',			
					fieldLabel:'Marca',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_compensa_marca,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:100
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:false,
				filterColValue:'FUNCIO.estado_reg',
				save_as:'marca'
			};
			
			/*
			vectorAtributos[20]= {
				validacion: {
					name:'nivel_academico',			
					fieldLabel:'Nivel Academico',
					allowBlank:false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',			
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					renderer:render_compensa_marca,
					forceSelection:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:100
				},
				tipo:'ComboBox',
				filtro_0:false,
				filtro_1:false,
				filterColValue:'FUNCIO.estado_reg',
				save_as:'marca'
			};
			
			*/
				
	}
	
	
	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	
	if(tipo=='curriculum'||tipo=='sel_per'){
		var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_trabajo/empleado_trabajo.php'};
	}else{
		if(tipo=='contrato'){
			var config={titulo_maestro:'Contrato',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/contrato/contrato.php'};
		}else{
			if(tipo=='compensacion'){
				var config={titulo_maestro:'Compensacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/compensacion/compensacion.php'};
			}
			else{
			    var config={titulo_maestro:'Empleado',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_cta/empleado_cta.php'};	
			}
			
		}
	}
	layout_empleado=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_empleado.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/empleado/ActionEliminarEmpleado.php'},
		Save:{url:direccion+'../../../control/empleado/ActionGuardarEmpleado.php'},
		ConfirmSave:{url:direccion+'../../../control/empleado/ActionGuardarEmpleado.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Funcionario'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_empleado_tpm_frppa()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_tpm_frppa/empleado_tpm_frppa_det.php?'+data,'Empleados Estructura Programática',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		if(tipo!='sel_per'){
			combo_persona=ClaseMadre_getComponente ('id_persona');
			txt_codigo_empleado=ClaseMadre_getComponente ('codigo_empleado');
	        txt_nombre_tipo_documento=ClaseMadre_getComponente ('nombre_tipo_documento');
        	txt_doc_id=ClaseMadre_getComponente ('doc_id');
	        txt_email1=ClaseMadre_getComponente ('email1');		
		}
			//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_empleado.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_empleado.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )	
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		
		_CP.getPagina(layout_empleado.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_empleado.getIdContentHijo()).pagina.desbloquearMenu();	
		
	}
	
	this.btnNew=function()
	{		
		CM_ocultarComponente(txt_nombre_tipo_documento);
		CM_ocultarComponente(txt_doc_id);
		//CM_ocultarComponente(txt_email1);
		ClaseMadre_btnNew()
	};
	
	this.btnEdit=function()
	{
		CM_ocultarComponente(txt_nombre_tipo_documento);
		CM_ocultarComponente(txt_doc_id);
		CM_mostrarComponente(txt_email1);
		ClaseMadre_btnEdit()
	};
	
	
	
	
	function btn_seguro()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_seguro/empleado_seguro.php?'+data,'Empleados - Seguro',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	
	
	function btn_afp()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_afp/empleado_afp.php?'+data,'Empleados - AFP',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	
	/*function btn_ctto()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../contrato/contrato.php?'+data,'Funcionario - Contrato',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}*/
	function btn_horario()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_horario/empleado_horario.php?'+data,'Horario - Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	
	
	function btn_cta_bancaria()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_cta_bancaria/empleado_cta_bancaria.php?'+data,'Cta Bancaria - Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_asigna_pago()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../parametro_costo_planilla/asigna_pago.php?'+data,'Asigna % Pago - Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	function btn_habilita_marcas()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../tarjeta/tarjeta.php?'+data,'Habilita Marcas - Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_bonos()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../descuento_bono/descuento_bono.php?'+data,'Bonos/Dsctos- Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	
	function btn_capacitacion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_capacitacion/empleado_capacitacion.php?'+data,'Capacitaciones- Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
		function btn_trabajo(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_trabajo/empleado_trabajo.php?'+data,'Trabajos - Empleado',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado.getLayout()
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
	var CM_getBoton=this.getBoton;
	
	
	if(tipo=='empleado'||tipo=='sel_per'||tipo=='contrato'){
		CM_getBoton('editar-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
		CM_getBoton('nuevo-'+idContenedor).enable();
		CM_getBoton('guardar-'+idContenedor).enable();
	}else{
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('nuevo-'+idContenedor).disable();
		CM_getBoton('guardar-'+idContenedor).disable();
	}
	if(tipo=='empleado'){
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignación de EP',btn_empleado_tpm_frppa,true,'empleado_tpm_frppa','Estructura Programática');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Horario',btn_horario,true,'horario','Horario');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cta Bancaria',btn_cta_bancaria,true,'cta_bancaria','Cta Bancaria');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignar % de Pago',btn_asigna_pago,true,'asigna_pago','Asignar % de Pago');
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Habilitar Funcionario para Marcar',btn_habilita_marcas,true,'habilita_marcas','Habilitar Marcas de Asistencia');
	}else{
		
		if(tipo=='contrato'){
			//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Seguros',btn_seguro,true,'seguro','Seguro');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','AFP\'s',btn_afp,true,'afp','AFP');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignaciones',btn_bonos,true,'bonos','Asignaciones');	
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Horario',btn_horario,true,'horario','Horario');	
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignación de EP',btn_empleado_tpm_frppa,true,'empleado_tpm_frppa','Estructura Programática');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cta Bancaria',btn_cta_bancaria,true,'cta_bancaria','Cta Bancaria');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Definir % de Pago',btn_asigna_pago,true,'asigna_pago','Definir % de Pago');
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Habilitar Funcionario para Marcar',btn_habilita_marcas,true,'habilita_marcas','Habilitar Marcas de Asistencia');
		}else{
			//es curriculum
			
			this.AdicionarBoton('../../../lib/imagenes/report.png','Capacitaciones',btn_capacitacion,true,'capacitacion','Capacitación');
		}
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}