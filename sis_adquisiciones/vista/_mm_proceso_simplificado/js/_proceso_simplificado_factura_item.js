/**
* Nombre:		  	    pagina_proceso_adjudicacion_Det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-28 17:32:05
*/
function pag_proc_simplif_item(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var num_cotizaciones=0;
	var on=0;
	var mensaje;
	/////////////////
	//  DATA STORE //
	/////////////////

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion/ActionListarCotizacion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cotizacion',
		{name: 'fecha_venc',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'tipo_documento',
		'desc_documento',
		'garantia',
		'lugar_entrega',
		'forma_pago',
		'tiempo_validez_oferta',
		{name: 'fecha_entrega',type:'date',dateFormat:'Y-m-d'},
		'tipo_entrega',
		'observaciones',
		'id_proceso_compra',
		'desc_proceso_compra',
		'id_moneda',
		'desc_moneda',
		'id_proveedor',
		'desc_proveedor',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'precio_total_moneda_cotizada',
		'figura_acta',
		'num_factura',
		'num_orden_compra',
		'estado_vigente',
		'estado_reg',
		'nombre_pago',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_orden_compra_sis',
		'num_cotizacion',
		{name: 'fecha_orden_compra',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},
		'direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor',
		{name: 'fecha_cotizacion',type:'date',dateFormat:'Y-m-d'},'num_detalle_cotizado',
		'precio_total','id_moneda_base','numeracion_periodo','num_detalle_cotizado_gral', 'num_detalle_adjudicado_gral','se_adjudica','num_detalle_adjudicado','cantidad_sol','tipo_documento','precio_total_adjudicado','cod_control_factura','num_autoriza_factura','id_empleado_adjudicacion','empleado_adjudicacion'


		]),remoteSort:true});
	var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','desc_plantilla'])});
		
		var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor','direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor','id_cuenta','id_auxiliar'])
		,baseParams:{tipo_adq:maestro.tipo_adq, id_proceso_compra:maestro.id_proceso_compra}});

		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});
		
		function render_id_moneda(value, p, record){ if(record.data.id_moneda!=''){
		      if(record.modified){
		          return String.format('{0}',ds_moneda.getById(value).data.nombre);
		      }
		      else{
		          return String.format('{0}', record.data['desc_moneda']);
		      }
		   }
		}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{simbolo}</FONT>','</div>');

		function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
		var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');

		function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_documento']);}
		var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','</div>');

		
		
		
		  var ds_empleado= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id', 'email'])
	});
	
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['empleado_adjudicacion']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');

		
		var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/caja/ActionListarCaja.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
		});

		var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cajero/ActionListarCajero.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
		});

		function render_id_caja(value, p, record){return String.format('{0}', record.data['caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
		
		
		////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_cotizacion
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_cotizacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cotizacion'
		};

		//txt id_proceso_compra   ==> deberia ser fiel
		Atributos[1]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:maestro.id_proceso_compra,
			save_as:'id_proceso_compra'
		};

		//txt id_tipo_categoria_adq  ==> field
		Atributos[2]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				fieldLabel:'Categoria',
				name: 'desc_tipo_categoria_adq',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				width_grid:150,
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'desc_tipo_categoria_adq'
		};


		//txt num_cotizacion
//		Atributos[3]={//==> SI
//			validacion:{
//				name:'num_cotizacion',
//				fieldLabel:'Nº Cotizacion ',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:2,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:80,
//				width:'40%',
//				disabled:true,
//				grid_indice:2
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:true,
//			defecto:maestro.num_cotizacion,
//			filterColValue:'COTIZA.num_cotizacion#COTIZA.periodo',
//			save_as:'num_cotizacion',
//			id_grupo:1  //1
//		};


		Atributos[3]={
			validacion:{
				name:'id_proveedor',
				fieldLabel:'Proveedor',
				allowBlank:false,
				emptyText:'Proveedor...',
				desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_proveedor,
				valueField: 'id_proveedor',
				displayField: 'nombre_proveedor',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
				typeAhead:false,
				tpl:tpl_id_proveedor,
				onSelect: function(record){getComponente('id_proveedor').setValue(record.data.id_proveedor);
				getComponente('direccion_proveedor').setValue(record.data.direccion_proveedor);getComponente('direccion_proveedor').disable();
				getComponente('mail_proveedor').setValue(record.data.mail_proveedor);getComponente('mail_proveedor').disable();
				getComponente('telefono1_proveedor').setValue(record.data.telefono1_proveedor);getComponente('telefono1_proveedor').disable();
				getComponente('telefono2_proveedor').setValue(record.data.telefono2_proveedor);getComponente('telefono2_proveedor').disable();
				getComponente('fax_proveedor').setValue(record.data.fax_proveedor);getComponente('fax_proveedor').disable();
				getComponente('id_proveedor').collapse(); },
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_proveedor,
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:'100%',
				disabled:false,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON_15.apellido_paterno#PERSON_15.apellido_materno#PERSON_15.nombre#INSTIT.nombre',
			save_as:'id_proveedor',
			id_grupo:1
		};

		//txt fecha_validez_oferta ==> se usa
//		Atributos[5]= {
//			validacion:{
//				name:'tiempo_validez_oferta',
//				fieldLabel:'Validez Oferta',
//				allowBlank:true,
//				maxLength:3,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:0,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:100,
//				width:'60%',
//				disable:false,
//				grid_indice:8
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'COTIZA.tiempo_validez_oferta',
//			save_as:'tiempo_validez_oferta',
//			id_grupo:5
//		};

		//txt id_moneda  ==> se va a escoger
		Atributos[4]={
			validacion:{
				name:'id_moneda',
				fieldLabel:'Moneda',
				allowBlank:false,
				emptyText:'Moneda...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField:'id_moneda',
				displayField:'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:true,
				tpl:tpl_id_moneda,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				//editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false,
				grid_indice:9
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda',
			id_grupo:1  //1
		};


		//txt tipo_entrega  ==> se usa
//		Atributos[7]={
//			validacion:{
//				name:'tipo_entrega',
//				fieldLabel:'Tiempo Entrega',
//				allowBlank:true,
//				maxLength:120,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disabled:false,
//				grid_indice:9
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'COTIZA.tipo_entrega',
//			save_as:'tipo_entrega',
//			id_grupo:3
//		};

		//txt fecha_entrega ==> se usa
//		Atributos[8]= {
//			validacion:{
//				name:'fecha_entrega',
//				fieldLabel:'Fecha Entrega',
//				allowBlank:true,
//				format: 'd/m/Y', //formato para validacion
//				minValue: '01/01/1900',
//				disabledDaysText: 'Día no válido',
//				grid_visible:true,
//				grid_editable:false,
//				renderer: formatDate,
//				width_grid:85,
//				disabled:false,
//				grid_indice:10
//			},
//			form:false,
//			tipo:'DateField',
//			filtro_0:false,
//			filterColValue:'COTIZA.fecha_entrega',
//			dateFormat:'m-d-Y',
//			defecto:' ',
//			save_as:'fecha_entrega',
//			id_grupo:3
//		};


		//txt forma_pago ==se usa
		Atributos[5]={
			validacion:{
				name:'forma_pago',
				fieldLabel:'Forma de Pago',
				allowBlank:true,
				maxLength:120,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:11
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'COTIZA.forma_pago',
			save_as:'forma_pago',
			id_grupo:3
		};


		//txt impuestos
//	Atributos[6]={
//			validacion:{
//				//fieldLabel: 'Id',
//				labelSeparator:'',
//				name: 'impuestos',
//				inputType:'hidden',
//				grid_visible:false,
//				grid_editable:false
//			},
//			tipo: 'Field',
//			filtro_0:false,
//			defecto:1,
//			save_as:'impuestos'
//		};
		


		// txt garantia
		Atributos[7]={//==> SI
			validacion:{
				name:'garantia',
				fieldLabel:'Garantia',
				allowBlank:true,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:13
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'COTIZA.garantia',
			save_as:'garantia',
			id_grupo:1
		};


		// txt figura_acta
//		Atributos[12]={//==>SI
//			validacion:{
//				name:'se_adjudica',
//				fieldLabel:'Se adjudica',
//				allowBlank:true,
//				maxLength:10,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:60,
//				width:'100%',
//				disable:false,
//				renderer:formatBoolean,
//				grid_indice:2
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'COTIZA.se_adjudica',
//			save_as:'se_adjudica',
//			id_grupo:0
//		};



//		 txt fecha_venc
//		Atributos[13]= {//==>SI
//			validacion:{
//				name:'fecha_venc',
//				fieldLabel:'Fecha Vencimiento',
//				allowBlank:false,
//				format: 'd/m/Y', //formato para validacion
//				minValue: '01/01/1900',
//				disabledDaysText: 'Día no válido',
//				grid_visible:false,
//				grid_editable:false,
//				renderer: formatDate,
//				width_grid:85,
//				disabled:false		,
//				grid_indice:40
//			},
//			form:false,
//			tipo:'DateField',
//			filtro_0:false,
//			filterColValue:'COTIZA.fecha_venc',
//			dateFormat:'m-d-Y',
//			defecto:'',
//			save_as:'fecha_venc',
//			id_grupo:1  //1
//		};

		// txt lugar_entrega ==> se usa
//		Atributos[14]={
//			validacion:{
//				name:'lugar_entrega',
//				fieldLabel:'Lugar de Entrega',
//				allowBlank:true,
//				maxLength:300,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:100,
//				width:'60%',
//				disabled:false,
//				grid_indice:14
//			},
//			tipo: 'TextArea',
//			form: false,
//			filtro_0:true,
//
//			filterColValue:'COTIZA.lugar_entrega',
//			save_as:'lugar_entrega',
//			id_grupo:1  //1
//
//		};



		// txt fecha_reg
//		Atributos[15]= {//==>SI
//			validacion:{
//				name:'fecha_reg',
//				fieldLabel:'Fecha registro',
//				allowBlank:true,
//				format: 'd/m/Y', //formato para validacion
//				minValue: '01/01/1900',
//				disabledDaysText: 'Día no válido',
//				grid_visible:true,
//				grid_editable:false,
//				renderer: formatDate,
//				width_grid:85,
//				disabled:true
//			},
//			form:false,
//			tipo:'DateField',
//			filtro_0:true,
//			filterColValue:'COTIZA.fecha_reg',
//			dateFormat:'m-d-Y',
//			defecto:'',
//			save_as:'fecha_reg',
//			id_grupo:0
//		};



		// txt estado_vigente
//		Atributos[16]={//==>SI
//			validacion:{
//				name:'estado_vigente',
//				fieldLabel:'Estado',
//				allowBlank:true,
//				maxLength:30,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				renderer:formatAdjudicado,
//				disable:false,
//				grid_indice:2
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'COTIZA.estado_vigente',
//			save_as:'estado_vigente',
//			id_grupo:0
//		};
		// txt estado_reg
//		Atributos[17]={//==> SI
//			validacion:{
//				name:'estado_reg',
//				fieldLabel:'Estado Reg',
//				allowBlank:false,
//				maxLength:30,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disable:false
//			},
//			tipo: 'TextField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'COTIZA.estado_reg',
//			save_as:'estado_reg',
//			defecto:'activo',
//			id_grupo:0
//		};

		// txt observaciones
		Atributos[8]={//==>SI
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:60
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			defecto:maestro.lugar_entrega,
			filterColValue:'COTIZA.observaciones',
			save_as:'observaciones',
			defecto:'-',
			id_grupo:0  //1
		};



//		Atributos[19]={
//			validacion:{
//				//fieldLabel: 'Id',
//				labelSeparator:'',
//				name: 'num_proceso',
//				inputType:'hidden',
//				grid_visible:false,
//				grid_editable:false
//			},
//			tipo: 'Field',
//			filtro_0:false,
//			defecto:maestro.num_proceso,
//			save_as:'num_proceso'
//		};



		/*************/

		Atributos[9]={
			validacion:{
				name:'direccion_proveedor',
				fieldLabel:'Direccion',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:3
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'',
			id_grupo:1
		};


		Atributos[10]={
			validacion:{
				name:'mail_proveedor',
				fieldLabel:'Email',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:4
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'',
			id_grupo:1
		};



		Atributos[11]={
			validacion:{
				name:'telefono1_proveedor',
				fieldLabel:'Telef. 1',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:50,
				width:'100%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'',
			id_grupo:1
		};


		Atributos[12]={
			validacion:{
				name:'telefono2_proveedor',
				fieldLabel:'Telef. 2',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:50,
				width:'100%',
				disabled:true,
				grid_indice:6
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'',
			id_grupo:1
		};


		Atributos[13]={
			validacion:{
				name:'fax_proveedor',
				fieldLabel:'Fax',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:65,
				width:'100%',
				disabled:true,
				grid_indice:7
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'',
			save_as:'',
			id_grupo:1
		};



//		Atributos[25]= {
//			validacion:{
//				name:'fecha_cotizacion',
//				fieldLabel:'Fecha Cotizacion',
//				allowBlank:true,
//				format: 'd/m/Y', //formato para validacion
//				minValue: '01/01/1900',
//				disabledDaysText: 'Día no válido',
//				grid_visible:true,
//				grid_editable:false,
//				renderer: formatDate,
//				width_grid:85,
//				disabled:false,
//				grid_indice:10
//			},
//			form:false,
//			tipo:'DateField',
//			filtro_0:false,
//			filterColValue:'COTIZA.fecha_cotizacion',
//			dateFormat:'m-d-Y',
//			defecto:' ',
//			save_as:'fecha_cotizacion',
//			id_grupo:3
//		};


//		Atributos[26]={
//			validacion:{//==>NO
//				name:'num_detalle_cotizado',
//				fieldLabel:'num_detalle_cotizado',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:0,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disable:false
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:false,
//			id_grupo:0
//		};
//
//
//		Atributos[27]={
//			validacion:{
//				name:'numeracion_periodo',
//				fieldLabel:'Periodo/Nº Sol.',
//				allowBlank:true,
//				maxLength:30,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:true,
//				grid_editable:false,
//				width_grid:65,
//				align:'right',
//				width:'40%',
//				disable:false,
//				grid_indice:2
//			},
//			tipo: 'TextField',
//			form:false,
//			filtro_0:false,
//			filterColValue_0:'COTIZA.num_cotizacion#COTIZA.periodo',
//			save_as:'numeracion_periodo',
//			id_grupo:0
//		};
//
//
//		Atributos[28]={
//			validacion:{//==>NO
//				name:'num_detalle_cotizado_gral',
//				fieldLabel:'num_detalle_cotizado_gral',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:0,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disable:false
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:false,
//			id_grupo:0
//		};


		Atributos[14]={
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


		Atributos[15]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Precio Total',
				name: 'precio_total_adjudicado',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				//renderer:render_decimales,
				disabled:true,
				allowDecimals:true,
			    decimalPrecision:2,//para numeros float
			    allowNegative:false,
			    allowMil:true,
			    maxLength:50,
			    grid_indice:7,
			    width_grid:80,
				align:'right'
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
		    defecto:maestro.monto_proceso,
			filterColValue:'COTIZA.precio_total',
			save_as:'precio_total_adjudicado',
			id_grupo:3
		};
		
		Atributos[16]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				align:'right',
				width:'40%',
				disabled:true,
				grid_indice:1
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'
		};
			var fCol=new Array();
		var fVal=new Array();
		fCol[0]='PLANT.sw_compro';
		fVal[0]='1';
	
	Atributos[6]={
			validacion:{
				name:'tipo_documento',
				fieldLabel:'Tipo Documento',
				allowBlank:false,
				emptyText:'Documento...',
				desc: 'desc_documento',
				store:ds_tipo_plantilla,
				valueField: 'tipo_plantilla',
				displayField: 'desc_plantilla',
				queryParam: 'filterValue_0',
				filterCol:'PLANT.tipo_plantilla#PLANT.desc_plantilla',
				filterCols:fCol,
				filterValues:fVal,
				typeAhead:true,
				tpl:tpl_tipo_plantilla,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_tipo_plantilla,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				grid_indice:13
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'impuestos',
			filterColValue:'PLANTI.desc_plantilla',
			id_grupo:2
		};
		
	Atributos[17]={//==> SI
		validacion:{
			name:'num_factura',
			fieldLabel:'Nº Documento',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'70%',
			disabled:false,
			grid_indice:5
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTIZA.num_factura',
		save_as:'num_factura',
		id_grupo:2  //1
	};
		
	
	Atributos[18]={
		validacion:{//==>NO
			name:'num_autoriza_factura',
			fieldLabel:'Nº de Autorización',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:105,
			width:'70%',
			disabled:false,
			grid_indice:14
			
		},
		tipo: 'NumberField',
		form: true,
		save_as:'num_autoriza_factura',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[19]={//==> SI
		validacion:{
			name:'cod_control_factura',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:90,
			width:'70%',
			disabled:false,
			grid_indice:15
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		save_as:'cod_control_factura',
		id_grupo:0 //1
	};
	
	
	Atributos[20]= {
		validacion:{
			name:'fecha_factura',
			fieldLabel:'Fecha Factura/Recibo',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:97,
			disabled:false,
			grid_indice:16
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'COTIZA.fecha_factura',
		dateFormat:'m-d-Y',
		defecto:' ',
		save_as:'fecha_factura',
		id_grupo:2
	};
	
		Atributos[21]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_tipo_categoria_adq',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:maestro.id_tipo_categoria_adq,
			save_as:'id_tipo_categoria_adq'
		};
		
		
		Atributos[22]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				fieldLabel:'Periodo/NºCot.',
				name: 'numeracion_periodo',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				grid_indice:2,
				align:'right',
				width_grid:85
			},
			tipo: 'Field',
			filtro_0:true,
			
			filterColValue:'COTIZA.num_cotizacion#COTIZA.periodo',
			defecto:maestro.num_cotizacion,
			save_as:'num_cotizacion'
		};
	
		Atributos[23]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'fin',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'fin'
		};
		
		
		Atributos[24]={
			validacion:{
			name:'id_empleado_adjudicacion',
			fieldLabel:'Responsable de Adjudicación',
			allowBlank:true,			
			emptyText:'Responsable de Adjudicación...',
			desc: 'empleado_adjudicacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEA.id_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			typeAhead:false,
			tpl:tpl_id_empleado,
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
			renderer:render_id_empleado,
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
		filterColValue:'PER.nombre#PER.apellido_paterno#PER.apellido_materno',
		save_as:'id_empleado_adjudicacion',
		id_grupo:4
	};
	
	
	Atributos[25]={
			validacion:{
				name:'id_caja',
				fieldLabel:'Caja',
				allowBlank:true,
				emptyText:'Caja...',
				desc: 'caja', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_caja,
				valueField: 'id_caja',
				displayField: 'desc_unidad_organizacional',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
				typeAhead:true,
				tpl:tpl_id_caja,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_caja,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
			save_as:'id_caja',
			id_grupo:3
		};
		// txt id_cajero
		Atributos[26]={
			validacion:{
				name:'id_cajero',
				fieldLabel:'Cajero',
				allowBlank:true,
				emptyText:'Cajero...',
				desc: 'cajero', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cajero,
				valueField: 'id_cajero',
				displayField: 'desc_empleado',
				queryParam: 'filterValue_0',
				filterCol:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre',
				typeAhead:true,
				tpl:tpl_id_cajero,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_cajero,
				grid_visible:true,
				grid_editable:false,
				width_grid:130,
				width:'100%',
				disabled:false

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre#EMPLEA_1.codigo_empleado',
			save_as:'id_cajero',
			id_grupo:3
		};
	
	
		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		function formatBoolean(value){
			if(value=='true'){return 'si';}
			else{
				return 'no';
			}
		}

		function formatAdjudicado(val,cell,record,row,colum,store){
			if((record.data.num_detalle_adjudicado_gral<record.data.cantidad_sol) &&(record.data.se_adjudica=='si' ||record.data.se_adjudica=='true')){
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}else{
				return val;
			}
		};


		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Proceso de Adjudicacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_simplif_fact_det/proceso_simplif_fact_det_item.php'};
		lay_proc_simplif_item=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		lay_proc_simplif_item.init(config);




		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,lay_proc_simplif_item,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_btnDelete=this.btnDelete;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_conexionFailure=this.conexionFailure;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var getDialog=this.getDialog;
		var EstehtmlMaestro=this.htmlMaestro;
		var enableSelect=this.EnableSelect;
		var CM_saveSuccess=this.saveSuccess;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={
            guardar:{crear:true,separador:true},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../../sis_adquisiciones/control/cotizacion/ActionEliminarCotizacion.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra},
			Save:{url:direccion+'../../../../sis_adquisiciones/control/cotizacion/ActionGuardarCotizacionDir.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra,success:finalizado},
			ConfirmSave:{url:direccion+'../../../../sis_adquisiciones/control/cotizacion/ActionGuardarCotizacionDir.php',parametros:'&m_id_proceso_compra='+maestro.id_proceso_compra,success:finalizado},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'65%',width:'45%',minWidth:150,minHeight:'45%',	closable:true,titulo:'cotizacion',columnas:['90%'],
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Proveedor',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos del Pago',
				columna:0,
				id_grupo:2
			},{
				tituloGrupo:'Caja de Pago',
				columna:0,
				id_grupo:3
			},
			{
				tituloGrupo:'Responsable de Adjudicación',
				columna:0,
				id_grupo:4
			}
			]}};



			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_proceso_compra=datos.m_id_proceso_compra;
				maestro.codigo_proceso=datos.m_codigo_proceso;
				maestro.num_proceso=datos.m_num_proceso;
				maestro.tipo_adq=datos.m_tipo_adq;
				maestro.id_tipo_categoria_adq=datos.m_id_tipo_categoria_adq;
				maestro.lugar_entrega=datos.m_lugar_entrega;
				maestro.id_moneda=datos.m_id_moneda;
				maestro.desc_moneda=datos.m_desc_moneda;
				maestro.num_cotizacion=datos.m_num_cotizacion;
				maestro.id_moneda_base=datos.m_id_moneda_base;
				maestro.tipo_recibo=datos.m_tipo_recibo;

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_proceso_compra:maestro.id_proceso_compra
						
					}
				};
				_CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.limpiarStore();<br>
				_CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.bloquearMenu();
				this.btnActualizar();
				iniciarEventosFormularios();


				Atributos[1].defecto=maestro.id_proceso_compra;
				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones);

			};

			function btn_nota(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				CM_ocultarGrupo('Datos Proveedor');
			    CM_ocultarGrupo('Datos del Pago');
			    CM_ocultarGrupo('Oculto');
			    CM_mostrarGrupo('Caja de Pago');
			   
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					window.open(direccion+'../../../control/adjudicacion/ActionPDFAdjudicacion.php?m_id_cotizacion='+SelectionsRecord.data.id_cotizacion);
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			
			function btn_fin_adjud(){
				this.btnActualizar;
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
				    
					var SelectionsRecord=sm.getSelected();
					if(SelectionsRecord.data.estado_vigente!='finalizado'){
							if(SelectionsRecord.data.num_detalle_adjudicado>0){
								cmb_id_caja.modificado=true;
								
								ds_caja.baseParams={
									estado:2,id_cotizacion:SelectionsRecord.data.id_cotizacion
								}
                                var mensaje_precio='<span style="color:blue;font-size:16pt;font:bold">'+SelectionsRecord.data.precio_total_adjudicado +" "+SelectionsRecord.data.desc_moneda +'</span>' ;
							   

			                        Ext.Msg.show({
				                    title: 'MENSAJE',
				                    msg: 'La rendición es por '+ mensaje_precio + ' Desea continuar?',
				                    minWidth:400,
				                    maxWidth :600,
				                    buttons: Ext.Msg.OKCANCEL,
				                    fn: Resultado
				                    
				                    });
			                  
								
							}else{
								Ext.MessageBox.alert('Estado', 'No se adjudicó ningun detalle aún')
							}
					}else{
						Ext.MessageBox.alert('Estado', 'La adjudicación para la cotización ya fué finalizada')
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

            function Resultado(btn,text){
                  if(btn!='cancel'){
				    getComponente('fin').setValue(1);
                     CM_mostrarGrupo('Responsable de Adjudicación');
                     CM_ocultarGrupo('Datos Proveedor');
                     CM_ocultarGrupo('Oculto');
                     
                    if(maestro.tipo_recibo=='pago'){
                        
        			    CM_mostrarGrupo('Datos del Pago');
        			    CM_mostrarGrupo('Caja de Pago');
        			    getComponente('tipo_documento').allowBlank=false;
                        getComponente('num_factura').allowBlank=false;
        			    CM_btnEdit();
                    }else{
                        
                        CM_ocultarGrupo('Datos del Pago');
        			    CM_ocultarGrupo('Caja de Pago');
        			    getComponente('tipo_documento').allowBlank=true;
                        getComponente('num_factura').allowBlank=true;
        			    CM_btnEdit();
                    }                        			   


				}
            }
                
			function finalizado(resp){
				if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
					var root=resp.responseXML.documentElement;

					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
						CM_saveSuccess(resp);
					    if(getComponente('fin')>0){
						  alert('Finalizacion exitosa de registro de factura');
					    if(maestro.tipo_recibo!='pago'){
						  
						  						ds.load({
							params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
								m_id_proceso_compra:maestro.id_proceso_compra,
								directo:'si'
							}
						 });
                        }
							}
					}
				}
			}

			
			

       
			//Para manejo de eventos
			function iniciarEventosFormularios(){
			  mensaje='';
				txt_id_moneda_base=getComponente('id_moneda_base');
				//para iniciar eventos en el formulario
				txt_fecha=getComponente('fecha_cotizacion');
				cmbMoneda=getComponente('id_moneda');
				//ds_proveedor.baseParams={tipo_adq:maestro.tipo_adq, id_proceso_compra:maestro.id_proceso_compra};
				num_cotizaciones=0;
				on=0;
				
				CM_getBoton('finalizar_adjudicacion_dir-'+idContenedor).disable();
				
			//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.limpiarStore()){
					   _CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.bloquearMenu();
					}
				})
				cmb_id_caja=getComponente('id_caja');
				cmb_id_cajero=getComponente('id_cajero');
				
				var onCaja=function(e){
					cmb_id_cajero.reset();
					cmb_id_cajero.modificado=true;
					ds_cajero.baseParams={m_id_caja:cmb_id_caja.getValue()};
				}
				cmb_id_caja.on('select',onCaja);
				cmb_id_caja.on('change',onCaja);
				
				CM_getBoton('finalizar_adjudicacion_dir-'+idContenedor).disable();
				
			}
			
			
			this.btnNew=function(){
			    CM_mostrarGrupo('Datos Proveedor');
			    CM_ocultarGrupo('Oculto');
			    CM_ocultarGrupo('Caja de Pago');
			    CM_ocultarGrupo('Responsable de Adjudicación');
			    CM_ocultarGrupo('Datos del Pago');
			     
			    if(maestro.tipo_recibo=='pago'){
			         CM_ocultarGrupo('Datos del Pago');
			         getComponente('tipo_documento').allowBlank=true;
			         getComponente('num_factura').allowBlank=true;
			         getComponente('fecha_factura').allowBlank=true;
    			}else{
			         CM_mostrarGrupo('Datos del Pago');
			         getComponente('tipo_documento').allowBlank=false;
			         getComponente('num_factura').allowBlank=false;
			         getComponente('fecha_factura').allowBlank=false;
    			}
			    getComponente('id_proveedor').enable();
			    getComponente('id_moneda').enable();
			    getComponente('fin').setValue(0);
			    getComponente('tipo_documento').enable();   
			    if(parseFloat(getComponente('precio_total_adjudicado'))>0.0){
                    
			    }else{
			        getComponente('precio_total_adjudicado').setValue(maestro.monto_proceso);
			    }
			   
			    CM_btnNew();
			}
			
			this.btnEdit=function(){
			    var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				if(NumSelect!=0){
					getComponente('fin').setValue(0);
					if(parseFloat(SelectionsRecord.data.precio_total_adjudicado)>0.0){
                    }else{
			            getComponente('precio_total_adjudicado').setValue(maestro.monto_proceso);
			        }
			         CM_mostrarGrupo('Datos Proveedor');
			       
			       CM_ocultarGrupo('Oculto');
			       CM_ocultarGrupo('Caja de Pago');
			       CM_ocultarGrupo('Responsable de Adjudicación')
			       
			       if(maestro.tipo_recibo=='pago'){
			         CM_ocultarGrupo('Datos del Pago');
			         getComponente('tipo_documento').allowBlank=true;
			         getComponente('num_factura').allowBlank=true;
			         getComponente('fecha_factura').allowBlank=true;
    				}else{
			         CM_mostrarGrupo('Datos del Pago');
			         getComponente('tipo_documento').allowBlank=false;
			         getComponente('num_factura').allowBlank=false;
			         getComponente('fecha_factura').allowBlank=false;
    				}
			        if(parseFloat(SelectionsRecord.data.num_detalle_cotizado)>0){
                        
        			    getComponente('id_moneda').disable();
        			    //getComponente('tipo_documento').disable();    
        			    getComponente('tipo_documento').disable();    
                    }else{
                        
			            getComponente('id_moneda').enable();
			            //getComponente('tipo_documento').enable();
			            getComponente('tipo_documento').enable();    
                    }
                    /*if(parseFloat(SelectionsRecord.data.impuestos)>1){
                         CM_ocultarComponente(getComponente('num_autoriza_factura'));
			             CM_ocultarComponente(getComponente('cod_control_factura'));
                    }else{
                         CM_mostrarComponente(getComponente('num_autoriza_factura'));
			             CM_mostrarComponente(getComponente('cod_control_factura'));
                    }*/
                    
			        CM_btnEdit();
				}else{
				    Ext.messageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}

			this.EnableSelect=function(sm,row,rec){
				_CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(lay_proc_simplif_item.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm,row,rec);
			}

			function salta(){
				ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
			}
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return lay_proc_simplif_item.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

		
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Rendición',btn_fin_adjud,true,'finalizar_adjudicacion_dir','Rendición');
            
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Nota de Adjudicación',btn_nota,true,'nota','Nota de Adjudicación');
			var CM_getBoton=this.getBoton;


			function  enable(sel,row,selected){
        		var record=selected.data; 
        			if(selected&&record!=-1){
        			   
        			     if(parseFloat(record.num_detalle_adjudicado)>0&&record.estado_vigente!='en_pago'){
        			         CM_getBoton('finalizar_adjudicacion_dir-'+idContenedor).enable();
        			          
        			         
        			     }else{
        			         CM_getBoton('finalizar_adjudicacion_dir-'+idContenedor).disable();
        			         
        			     }
        			}
        			enableSelect(sel,row,selected);
        	}


			this.iniciaFormulario();

			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_proceso_compra:maestro.id_proceso_compra,
					directo:'si'
				}
			});

			iniciarEventosFormularios();
			lay_proc_simplif_item.getLayout().addListener('layout',this.onResize);
			lay_proc_simplif_item.getVentana().addListener('beforehide',salta);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}