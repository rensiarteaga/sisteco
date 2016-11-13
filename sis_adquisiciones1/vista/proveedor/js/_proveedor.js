/**
 * Nombre:		  	    pagina_proveedor_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 10:31:08
 */
function pagina_proveedor(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var ds_pais;
	var ds_ciudad;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proveedor',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_proveedor',
		'codigo',
		'observaciones',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_institucion',
		'desc_institucion',
		'desc_persona',
		'id_persona',
		'nombre_persona',
		'usuario',
		'contrasena',
		'confirmado',
		'nombre_pago','direccion_proveedor','telefono1_proveedor','telefono2_proveedor','mail_proveedor','fax_proveedor',
		
		'casilla_proveedor',
		'celular1_proveedor',
		'celular2_proveedor',
		'email2_proveedor',
		'pag_web_proveedor',
		'nombre_contacto',
		'direccion_contacto',
		'telefono_contacto',
		'email_contacto',
		'tipo_contacto',
		'id_contacto','con_contacto',
		'id_depto',
		'ciudad',
		'pais',
		'rubro',
		'rubro1',
		'rubro2'
		
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
    ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});
    ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_per'])
	});
	
	
	
	ds_contacto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'
		}, ['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','desc_per'])
	});
	
	
	ds_ciudad=new Ext.data.Store({		
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, [{name:'id_lugar',mapping: 'id_lugar'},
			{name:'nombre',mapping: 'nombre'},
			{name:'codigo',mapping: 'codigo'}])
	});
	
	ds_pais=new Ext.data.Store({		
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, [{name:'id_lugar',mapping: 'id_lugar'},
			{name:'nombre',mapping: 'nombre'},
			{name:'codigo',mapping: 'codigo'}])
	});
	
	
	//FUNCIONES RENDER
			function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
			function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_persona']);}
			function renderHaber(value, p, record){return String.format('{0}', record.data['nombre_cuenta']);}
			function renderCiudad(value, p, record){return String.format('{0}', record.data['ciudad'])}
			function renderPais(value, p, record){return String.format('{0}', record.data['pais'])}
			function render_id_contacto(value, p, record){return String.format('{0}', record.data['nombre_contacto']);}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_proveedor
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_proveedor',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
			
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'hidden_id_proveedor'
	};
	
// txt codigo
	vectorAtributos[1]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
	
		},
		tipo: 'TextField',
		filtro_0:true,
		defecto:' ',
		filtro_1:true,
		filterColValue:'PROVEE.codigo',
		save_as:'txt_codigo',
	    id_grupo:0
	};
	
		
	vectorAtributos[2]= {
			validacion: {
			name:'persona_institucion',
			fieldLabel:'Tipo Contratista',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.proveedor_combo.persona_institucion
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:110, // ancho de columna en el gris
			disabled:false
			
		},
		tipo:'ComboBox',
		filterColValue:'CONTRA.estado_registro',
		save_as:'txt_persona_institucion',
		id_grupo:1
	};

	
// txt id_institucion4
	vectorAtributos[3]= {
			validacion: {
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,			
			emptyText:'Institución...',
			name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:150,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:false,
			width_grid:150 // ancho de columna en el gris
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		defecto: '',
		save_as:'txt_id_institucion',
		id_grupo:1
	};
	
// txt id_persona5
	vectorAtributos[4]= {
			validacion: {
			name:'id_persona',
			fieldLabel:'Persona',
			allowBlank:true,			
			emptyText:'Persona...',
			name: 'id_persona',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_persona', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_persona,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
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
			renderer:render_id_persona,
			grid_visible:true,
			grid_editable:false,
			width_grid:180 // ancho de columna en el gris
			
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		defecto: '',
		id_grupo:1,
		save_as:'txt_id_persona'
	};
	
		
	// txt observaciones2
	vectorAtributos[5]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			width:'90%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
			
			
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};
	
// txt fecha_reg3
	vectorAtributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true
			
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg',
		id_grupo:0
	};
	
// txt usuario
	vectorAtributos[7]={
		validacion:{
			name:'usuario',
			fieldLabel:'usuario',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
			
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'PROVEE.usuario',
		save_as:'txt_usuario',
		id_grupo:2
	};
// txt contrasena
	vectorAtributos[8]={
		validacion:{
			name:'contrasena',
			fieldLabel:'contrasena',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100
			
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'PROVEE.contrasena',
		save_as:'txt_contrasena',
		id_grupo:2
	};
// txt confirmado
	vectorAtributos[9]={
			validacion: {
			name:'confirmado',
			fieldLabel:'confirmado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'PROVEE.confirmado',
		defecto:'si',
		save_as:'txt_confirmado',
		id_grupo:2
	};
	
	
	vectorAtributos[10]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'desc_persona',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
			
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
		
	};
	
	// txt nombre_pago
	vectorAtributos[11]= {
		validacion:{
			name:'nombre_pago',
			fieldLabel:'Nombre Pago',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:true,
			width_grid:200
			
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.nombre_pago',
		save_as:'txt_nombre_pago',
		id_grupo:1
	};
	
	
	
	vectorAtributos[12]= {
		validacion:{
			name:'direccion_proveedor',
			fieldLabel:'Direccion',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width:'90%',
			width_grid:100
	
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.direccion',
		save_as:'txt_direccion_proveedor',
	    id_grupo:4
	};
	
	vectorAtributos[13]= {
		validacion:{
			name:'telefono1_proveedor',
			fieldLabel:'Telefono 1',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.telefono1_proveedor',
		save_as:'txt_telefono1_proveedor',
	    id_grupo:4
	};
	
	vectorAtributos[14]= {
		validacion:{
			name:'telefono2_proveedor',
			fieldLabel:'Telefono 2',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.telefono2_proveedor',
		save_as:'txt_telefono2_proveedor',
	    id_grupo:4
	};
	
	
	vectorAtributos[15]= {
		validacion:{
			name:'fax_proveedor',
			fieldLabel:'Fax',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.fax_proveedor',
		save_as:'txt_fax_proveedor',
	    id_grupo:4
	};
	
	vectorAtributos[16]= {
		validacion:{
			name:'mail_proveedor',
			fieldLabel:'Email',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			width:'90%'
		},
		tipo: 'TextField',
		save_as:'txt_mail_proveedor',
		id_grupo:4
	};
	
	
	
	vectorAtributos[17]= {
		validacion:{
			name:'casilla_proveedor',
			fieldLabel:'Casilla',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.casilla_proveedor',
		save_as:'txt_casilla_proveedor',
	    id_grupo:4
	};
	
	
	vectorAtributos[18]= {
		validacion:{
			name:'celular1_proveedor',
			fieldLabel:'Nº Celular Principal',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.celular1_proveedor',
		save_as:'txt_celular1_proveedor',
	    id_grupo:4
	};
	
	vectorAtributos[19]= {
		validacion:{
			name:'celular2_proveedor',
			fieldLabel:'Nº Celular Alternativo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.celular2_proveedor',
		save_as:'txt_celular2_proveedor',
	    id_grupo:4
	};
	
	vectorAtributos[20]= {
		validacion:{
			name:'email2_proveedor',
			fieldLabel:'Email alternativo',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			width:'90%'
		},
		tipo: 'TextField',
		save_as:'txt_mail2_proveedor',
		id_grupo:4
	};
	
	vectorAtributos[21]= {
		validacion:{
			name:'pag_web_proveedor',
			fieldLabel:'Pag. Web',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.pag_web_proveedor',
		save_as:'txt_pag_web_proveedor',
	    id_grupo:4
	};
	
	
//	vectorAtributos[24]= {
//			validacion: {
//			name:'id_contacto',
//			fieldLabel:'Contacto',
//			allowBlank:true,			
//			emptyText:'Contacto...',
//			desc: 'nombre_contacto', //indica la columna del store principal ds del que proviane la descripcion
//			store:ds_contacto,
//			valueField: 'id_contacto',
//			displayField: 'desc_per',
//			queryParam: 'filterValue_0',
//			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
//			typeAhead:true,
//			forceSelection:true,
//			mode:'remote',
//			queryDelay:250,
//			pageSize:200,
//			minListWidth:350,
//			grow:true,
//			width:'100%',
//			//grow:true,
//			resizable:true,
//			queryParam:'filterValue_0',
//			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
//			triggerAction:'all',
//			editable:true,
//			renderer:render_id_contacto,
//			grid_visible:true,
//			grid_editable:false,
//			width_grid:180 // ancho de columna en el gris
//			
//		},
//		tipo:'ComboBox',
//		filtro_0:true,
//		filtro_1:true,
//		filterColValue:'PERSON1.apellido_paterno#PERSON1.apellido_materno#PERSON1.nombre',
//		id_grupo:5,
//		save_as:'id_contacto'
//	};
//	
	
	
	
	
	vectorAtributos[22]={
			validacion:{
			name:'id_contacto',
			fieldLabel:'Contacto',
			allowBlank:true,			
			emptyText:'Contacto...',
			desc: 'nombre_contacto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_contacto,
			valueField: 'id_persona',
			displayField: 'desc_per',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			typeAhead:true,
			
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
			renderer:render_id_contacto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:'80%',
			disable:false
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
		save_as:'id_contacto',
		id_grupo:5
	};
	
	
	vectorAtributos[23]= {
		validacion:{
			name:'direccion_contacto',
			fieldLabel:'Direccion del Contacto',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
	
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.direccion_contacto',
		save_as:'txt_direccion_contacto',
	    id_grupo:5
	};
	
	
	vectorAtributos[24]= {
		validacion:{
			name:'telefono_contacto',
			fieldLabel:'Telefono del Contacto',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
	
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.telefono_contacto',
		save_as:'txt_telefono_contacto',
	    id_grupo:5
	};
	
	
	
	vectorAtributos[25]= {
		validacion:{
			name:'email_contacto',
			fieldLabel:'Email del Contacto',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			width:'90%'
		},
		tipo: 'TextField',
		save_as:'txt_email_contacto',
		id_grupo:5		
	};
	
	
	vectorAtributos[26]= {
		validacion:{
			name:'tipo_contacto',
			fieldLabel:'Tipo de Contacto',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:'90%',
			grid_editable:true,
			width_grid:100	
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.tipo_contacto',
		save_as:'txt_tipo_contacto',
	    id_grupo:5
	};
	
	
	vectorAtributos[27]= {
			validacion: {
			name:'con_contacto',
			fieldLabel:'Tiene Contacto',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['si','si'],['no','no']]
				}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:110, // ancho de columna en el gris
			disabled:false
			
		},
		tipo:'ComboBox',
		filterColValue:'con_contacto',
		save_as:'txt_con_contacto',
		defecto:'no',
		id_grupo:1
	};
	
	
	vectorAtributos[28]={
		validacion:{
			fieldLabel: 'Pais',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Pais...',
			name: 'id_lugar',  
			desc: 'pais', 
			store:ds_pais,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead: true,   
			onSelect:function(record){
				componentes[28].reset();
				componentes[27].setValue(record.data.id_lugar);
				componentes[27].collapse();
				ds_ciudad.baseParams.padre=record.data.id_lugar;
				componentes[28].modificado=true;
			
			},
			forceSelection : true,
			mode: 'remote',
			queryDelay: 450,
			pageSize: 400,
			minListWidth : 350,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, 
			triggerAction: 'all',
			editable : true,
			renderer: renderPais,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:120 
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'pais.nombre',
		save_as:'id_pais',
		id_grupo:1
	};
	
	vectorAtributos[29]={
		validacion:{
			fieldLabel: 'Ciudad',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Zon...',
			name: 'id_depto',  
			desc: 'ciudad', 
			store:ds_ciudad,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 450,
			pageSize: 400,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, 
			triggerAction: 'all',
			editable : true,
			renderer: renderCiudad,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:200 
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'depto.nombre',
		save_as:'id_depto',
		id_grupo:1
	};
	
	vectorAtributos[30]={
		validacion:{
			name:'rubro',
			fieldLabel:'Rubro',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
			
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.rubro',
		save_as:'txt_rubro',
		id_grupo:1
	};
	
	vectorAtributos[31]={
		validacion:{
			name:'rubro1',
			fieldLabel:'Rubro 1',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
			
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.rubro1',
		save_as:'txt_rubro1',
		id_grupo:1
	};
	
	vectorAtributos[32]={
		validacion:{
			name:'rubro2',
			fieldLabel:'Rubro 2',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
			
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PROVEE.rubro2',
		save_as:'txt_rubro2',
		id_grupo:1
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
		titulo_maestro:'proveedor',
		grid_maestro:'grid-'+idContenedor
	};
	layout_proveedor=new DocsLayoutMaestro(idContenedor);
	layout_proveedor.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_proveedor,idContenedor);
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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
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
		btnEliminar:{url:direccion+'../../../control/proveedor/ActionEliminarProveedor.php'},
		Save:{url:direccion+'../../../control/proveedor/ActionGuardarProveedor.php'},
		ConfirmSave:{url:direccion+'../../../control/proveedor/ActionGuardarProveedor.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],
		
			
			grupos:[{
				tituloGrupo:'Invisible',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos de Proveedor',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Registro de Proveedor',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Cuenta Proveedor',
				columna:0,
				id_grupo:3
			},{
				tituloGrupo:'Datos de Ubicacion',
				columna:1,
				id_grupo:4
			},{
				tituloGrupo:'Datos del Contacto',
				columna:0,
				id_grupo:5
			}
			],width:'65%',minWidth:350,minHeight:400,closable:true,titulo:'Proveedor'}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		combo_persona_institucion= ClaseMadre_getComponente('persona_institucion');
		
		function persona_institucion(){
			if(combo_persona_institucion.getValue()=='persona'){
				CM_mostrarComponente(ClaseMadre_getComponente(vectorAtributos[4].validacion.name));
				ClaseMadre_getComponente(vectorAtributos[3].validacion.name).setValue('');
				CM_ocultarComponente(ClaseMadre_getComponente(vectorAtributos[3].validacion.name));
				ClaseMadre_getComponente('id_institucion').disable();
			    ClaseMadre_getComponente('id_persona').enable();
			}
			else{
				CM_mostrarComponente(ClaseMadre_getComponente(vectorAtributos[3].validacion.name));
				CM_ocultarComponente(ClaseMadre_getComponente(vectorAtributos[4].validacion.name));
				ClaseMadre_getComponente(vectorAtributos[4].validacion.name).setValue('');
				ClaseMadre_getComponente('id_institucion').enable();
			    ClaseMadre_getComponente('id_persona').disable();
			}
		}
				
		combo_persona_institucion.on('select',persona_institucion);
		combo_persona_institucion.on('change',persona_institucion);
		
		con_contacto=ClaseMadre_getComponente('con_contacto');
		codigo=ClaseMadre_getComponente('codigo');
		
		var onContacto=function(e){
		    if(con_contacto.getValue()=='si'){
		        CM_mostrarGrupo('Datos del Contacto');
		        ClaseMadre_getComponente('id_contacto').allowBlank=false;
		    }else{
		        CM_ocultarGrupo('Datos del Contacto');
		        ClaseMadre_getComponente('id_contacto').allowBlank=false;
		    }
		}
		
		con_contacto.on('select',onContacto);
		
		var onCodigo=function(e){
		     Ext.Ajax.request({
				url:direccion+"../../../control/proveedor/ActionListarProveedor.php?codigo_proveedor="+codigo.getValue(),
            	method:'GET',
				success:cargar_codigo,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
		
		
		function cargar_codigo(resp){
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
			  	alert("ya hay un proveedor registrado con ese codigo");
			  }
			}
		}	
		
		codigo.on('change',onCodigo);
		
		for(i=0;i<vectorAtributos.length-1;i++){
			
		componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		
		}
		
	}
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_proveedor.getLayout();
	};
	function iniciarProveedor()
	{	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		
		
	}
  this.btnNew = function(){	
  		CM_ocultarGrupo('Invisible');
		CM_ocultarGrupo('Registro de Proveedor');
		CM_ocultarGrupo('Cuenta Proveedor');
		CM_mostrarGrupo('Datos de Proveedor');
		CM_ocultarGrupo('Datos del Contacto');
		CM_ocultarComponente(ClaseMadre_getComponente('id_persona'));
		CM_ocultarComponente(ClaseMadre_getComponente('id_institucion'));
		ClaseMadre_getComponente('id_institucion').enable();
	    ClaseMadre_getComponente('id_persona').enable();
		ClaseMadre_getComponente('persona_institucion').allowBlank=false;
		
		var dialog=ClaseMadre_getDialog();
		 dialog.setContentSize('75%','65%');
		ClaseMadre_btnNew();
	}	
	
	 this.btnEdit = function(){	
	    var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			ClaseMadre_getComponente('id_contacto').allowBlank=true;
			ClaseMadre_getComponente('id_lugar').setRawValue(SelectionsRecord.data.pais);
			if(SelectionsRecord.data.id_persona>0){
			    ClaseMadre_getComponente('con_contacto').disable();
			    ClaseMadre_getComponente('id_persona').disable();
			    ClaseMadre_getComponente('id_institucion').enable();
			    
			    CM_ocultarGrupo('Datos del Contacto');
			}else{
			    CM_mostrarGrupo('Datos del Contacto');
			    ClaseMadre_getComponente('con_contacto').enable();
			    ClaseMadre_getComponente('id_institucion').disable();
			    ClaseMadre_getComponente('id_persona').enable();
			}
			if(SelectionsRecord.data.con_contacto=='si'){
			    ClaseMadre_getComponente('con_contacto').setValue('si');
			}else{
			    ClaseMadre_getComponente('con_contacto').setValue('no');
			}
			ClaseMadre_getComponente('persona_institucion').allowBlank=false;
				CM_ocultarGrupo('Invisible');
				CM_ocultarGrupo('Registro de Proveedor');
				CM_ocultarGrupo('Cuenta Proveedor');
				
				CM_mostrarGrupo('Datos de Proveedor');
				   if(SelectionsRecord.data.id_persona>0){//persona
						ClaseMadre_getComponente('persona_institucion').setValue('Persona');
						ClaseMadre_getComponente('id_institucion').disable();
						CM_mostrarComponente(ClaseMadre_getComponente('id_persona'));
						CM_ocultarComponente(ClaseMadre_getComponente('id_institucion'));
					}
					if(SelectionsRecord.data.id_institucion>0){//institucion
					    
					    if(SelectionsRecord.data.id_contacto>0){
					        CM_mostrarGrupo('Datos del Contacto');
					    }else{
					        CM_ocultarGrupo('Datos del Contacto');
					    }
					    ClaseMadre_getComponente('persona_institucion').setValue('Institución');
						ClaseMadre_getComponente('id_persona').disable();
						CM_ocultarComponente(ClaseMadre_getComponente('id_persona'));
						CM_mostrarComponente(ClaseMadre_getComponente('id_institucion'));
					}
	
	       var dialog=ClaseMadre_getDialog();
		   dialog.setContentSize('75%','65%');
		ClaseMadre_btnEdit();
		}
	}

	
	function btnItem(){
	    ClaseMadre_getComponente('persona_institucion').allowBlank=true;
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_proveedor='+SelectionsRecord.data.id_proveedor;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			if(SelectionsRecord.data.id_persona>0){
				data=data+'&m_nombre_proveedor='+SelectionsRecord.data.desc_persona;
			}
			if(SelectionsRecord.data.id_institucion>0){
				data=data+'&m_nombre_proveedor='+SelectionsRecord.data.desc_institucion;
			}

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_proveedor.loadWindows(direccion+'../../../../sis_adquisiciones/vista/item_proveedor/item_proveedor_det.php?'+data,'Productos',ParamVentana);
layout_proveedor.getVentana().on('resize',function(){
			layout_proveedor.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
		
	}
	
	function btnServicio(){
	    ClaseMadre_getComponente('persona_institucion').allowBlank=true;
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_proveedor='+SelectionsRecord.data.id_proveedor;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			if(SelectionsRecord.data.id_persona>0){
				data=data+'&m_nombre_proveedor='+SelectionsRecord.data.desc_persona;
			}
			if(SelectionsRecord.data.id_institucion>0){
				data=data+'&m_nombre_proveedor='+SelectionsRecord.data.desc_institucion;
			}
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_proveedor.loadWindows(direccion+'../../../../sis_adquisiciones/vista/servicio_proveedor/servicio_proveedor_det.php?'+data,'Servicios',ParamVentana);
			layout_proveedor.getVentana().on('resize',function(){
			layout_proveedor.getLayout().layout();
				})
		}
	   else{
		  Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	   }
	}
	
	

	
	
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				iniciarProveedor();
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				ds_pais.baseParams={nivel_padre:0};
				
				this.AdicionarBoton('../../../lib/imagenes/bricks.png','Items por Proveedor',btnItem,true, 'btnItem','Item');
				this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Servicios por Proveedor',btnServicio,true, 'btnServicio','Servicio');
				
				layout_proveedor.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}