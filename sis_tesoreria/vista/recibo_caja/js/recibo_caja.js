/**
 * Nombre:		  	    pagina_recibo_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:07
 */
function pagina_recibo_caja(idContenedor,direccion,paramConfig,vista,id_cuenta_doc){
	var Atributos=new Array,sw=0;
	
	var maestro=new Array;
	var componentes=new Array;
	var fecha=new Date();
	var grid;
	var reporte; //reporte 0:sin reporte, reporte 1: vista previa, reporte 2: reporte oficial
	var cm;
	var vista2='solicitud_efectivo';
	var tipo_recibo;
	var id_cuenta;
	var datos_reporte;
	var tipo_recibo;
	
	var monedas_for=new Ext.form.MonedaField(
			{
				name:'importe',
				fieldLabel:'valor',	
				allowBlank:false,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,
				allowNegative:true,
				minValue:-1000000000000}	
			);

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarSolicitudViaticos2.php?tipo_cuenta_doc='+vista2}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cuenta_doc',totalRecords:'TotalCount'
		},[		
		'id_cuenta_doc',
		'id_presupuesto',
		'desc_presupuesto',
		'id_empleado',
		'desc_empleado',
		'id_proveedor',
		'desc_proveedor',
		'id_categoria',
		'desc_categoria',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'tipo_pago',
		'tipo_contrato',
		'id_usuario_rendicion',
		'desc_usuario',
		'estado',
		'nro_documento',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'motivo',
		'recorrido',
		'observaciones',
		'id_moneda',
		'desc_moneda',
		'id_depto',
		'desc_depto',
		'id_caja',
		'desc_caja',
		'id_cajero',
		'desc_cajero',
		'importe',
		'importe_entregado',
		'id_subsistema',
		'tipo_recibo',
		'solo_lectura',
		'fk_id_cuenta_doc',
		'rendicion',
		'tipo_cuenta_doc',
		'id_parametro',
		'desc_parametro',
		'codigo_caja',
		'nro_dias_para_rendir',
		'cant_rend_registradas',
		'cant_rend_finalizadas',
		'cant_rend_contabilizadas'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																																								'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																																								'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																																								'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																																								'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																																								]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
	
	  

    var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});
	
		
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
	
	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor','direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor'])
		});

	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
	
    function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
	

	//FUNCIONES RENDER
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
		
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

	function render_id_depto(value, p, record){
			
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_depto']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['desc_depto']+ '</span>');
			else
				return String.format('{0}', record.data['desc_depto']);
	}
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

	function render_id_caja(value, p, record){
			
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_caja']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
				
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['desc_caja']+ '</span>');
			
			else
				return String.format('{0}', record.data['desc_caja']);
	}
		
	var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

	function render_id_cajero(value, p, record){
			if(record.data.id_subsistema=='4')
				return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_cajero']+ '</span>');
			else if(record.data.fk_id_cuenta_doc!='' && record.data.fk_id_cuenta_doc!=undefined)
				return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['desc_cajero']+ '</span>');
			else
				return String.format('{0}', record.data['desc_cajero']);
	}
	
	var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
		
	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	//Función para el formato de los importes
	function formatoImporte(num){  
		 var cadena = ""; var aux;  
		 var cont = 1,m,k;  
		   
		 if(num<0) aux=1; else aux=0;  
		 num=num.toString();  
	   
		 for(m=num.length-1; m>=0; m--)
		 {
			 cadena = num.charAt(m) + cadena;  
			 if(num.charAt(m)!='.'){
			   
				 if(cont%3 == 0 && m >aux)  cadena = "," + cadena; else cadena = cadena;  
			   
				 if(cont== 3) cont = 1; else cont++;  
			 } 
			 else
			 {
				 cont = 1;
			 }
		 }  
		 return cadena;  
	}
	
	function render_saldo_solicitante(value, p, record)
	{
		var num=formatoImporte(value);
		if(value<0){
			return String.format('{0}', '<FONT COLOR="#FF0000"><b>'+num+'</b></FONT>');
		} else if(value>0){
			return String.format('{0}', '<FONT COLOR="#0000FF"><b>'+num+'</b></FONT>');
		} else{
			return String.format('{0}', '<b>'+num+'</b>');
		}
	}
	function renderEstadoNumero(value,p,record)
	{
		return String.format('{0}', '<span style="color:green;font-size:8pt;font-weight:bold;" title="Notas:">'+'Registradas: '+record.data['cant_rend_registradas']+'<br>'+'Finalizadas....: '+record.data['cant_rend_finalizadas']+'<br>'+'Contabilizadas: '+record.data['cant_rend_contabilizadas']+ "</span>");
		//return String.format('{0}', '<span style="color:brown;font-size:8pt;font-weight:bold;"  title="Notas: '+record.data['cant_rend_registradas']+'">'+record.data['cant_rend_finalizadas']+'<br>'+record.data['cant_rend_contabilizadas']+"</span>");
	}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_doc'
	};
	
	// txt id_parametro
	Atributos[1]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			grid_indice:1,  //para colocar el orden en el indice			
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:1
	};
	
	// txt id_depto
	Atributos[2]={
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
			onSelect:function(record){
				componentes[2].setValue(record.data.id_depto);
				componentes[2].collapse();
				componentes[11].reset();
				ds_caja.baseParams.m_id_depto=record.data.id_depto;
				componentes[11].modificado=true
				componentes[11].setDisabled(false);							
			},
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_depto',
		id_grupo:1
		
	};
	
// txt id_presupuesto
	Atributos[3]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:250,
			disabled:false,
			grid_indice:11		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:1
	};
// txt id_empleado
	Atributos[4]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:true,			
			emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
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
			grid_visible:false,
			width:250,
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:2
		
	};
	
	// txt id_empleado
	Atributos[5]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			emptyText:'Proveedor...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'nombre_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_proveedor,
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
			grid_visible:false,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_proveedor',
		id_grupo:2
	};

// txt estado
	Atributos[6]={
		validacion:{
			name: 'estado', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:11		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'estado'
	};
// txt nro_documento
	Atributos[7]={
		validacion:{
			name: 'nro_documento', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'No',
			grid_visible:true,
			grid_editable:false,
			width_grid:170,
			grid_indice:5		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'nro_documento',
	};
	
// txt fecha_reg
	Atributos[8]={
		validacion:{
			name: 'fecha_reg', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Fecha de Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:12,
			renderer:formatDate		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'fecha_reg',
	};
	
	// txt importe_regis
	Atributos[9]={
		validacion:{
			name:'importe',
			fieldLabel:'Importe Solicitado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			align:'right', 
			renderer: render_total,
			grid_indice:7		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true
	};
	
// txt motivo
	Atributos[10]={
		validacion:{
			name:'motivo',
			fieldLabel:'Concepto',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:230,
			width:'100%',
			disabled:false,
			grid_indice:10		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'motivo',
		id_grupo:2
	};
	
	Atributos[11]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			//emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			onSelect:function(record){
				componentes[11].setValue(record.data.id_caja);
				componentes[11].collapse();
				componentes[12].reset();
				ds_cajero.baseParams.m_id_caja=record.data.id_caja;
				ds_cajero.baseParams.estado='3';
				componentes[12].modificado=true	
				componentes[12].setDisabled(false);							
			},
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			disabled:true,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_caja',
		save_as:'id_caja',
		id_grupo:1
	};
// txt id_cajero
	Atributos[12]={
			validacion:{ 
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			//emptyText:'Cajero...',
			desc: 'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
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
			width_grid:200,
			width:250,
			disabled:true,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_cajero',
		save_as:'id_cajero',
		id_grupo:1
	};
	
	// txt importe_regis
	Atributos[13]={
		validacion:{
			name:'importe_entregado',
			fieldLabel:'Importe Entregado',
			allowBlank:false, 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			align:'right', 
			renderer: render_total,
			grid_indice:8		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,		
		id_grupo:3
	};
	
	
	 Atributos[14]={//==> se usa//30
			validacion: {
			name:'tipo_recibo',
			fieldLabel:'Tipo de Recibo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['provisorio','A nombre de Empleado'],['pago','A nombre de Proveedor']]}),
			valueField:'ID',
			displayField:'valor',
			onSelect:function(record){
				CM_getComponente('tipo_recibo').setValue(record.data.ID);
				CM_getComponente('tipo_recibo').collapse();
				if(CM_getComponente('tipo_recibo').getValue()=='provisorio'){//es para el empleado
				
					cm_mostrarComponente(componentes[4]);
					cm_ocultarComponente(componentes[5]);
					componentes[5].allowBlank=true;	
					componentes[4].allowBlank=false;
					componentes[5].reset();
				}else{
					cm_ocultarComponente(componentes[4]);
					cm_mostrarComponente(componentes[5]);
					componentes[5].allowBlank=false;	
				    componentes[4].allowBlank=true;
				    componentes[4].reset(); 
				}		
			},
			forceSelection:true,
			grid_visible:true,
			grid_indice:9,
			grid_editable:false,
			align:'center',
			width:180,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		defecto:'provisorio',
		id_grupo:1
	};
	
	Atributos[15]={
		validacion:{
			name:'desc_empleado',
			fieldLabel:'A nombre de',
			grid_visible:true,
			grid_editable:false,
			width_grid:230,
			grid_indice:6	
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'desc_empleado'
			
	};
	
	Atributos[16]={
		validacion:{
			name: 'fecha_sol', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Fecha de Entrega',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:12,
			renderer:formatDate		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'fecha_sol',
	};
	
	Atributos[17]={
				validacion:{
					name:'codigo_caja',
					fieldLabel:'Código Caja',
					allowBlank:true,
					maxLength:40,
					minLength:0,
					selectOnFocus:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:110,
					width:'100%',
					disabled:false,
					grid_indice:3					
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'codigo_caja',
				id_grupo:0
			};	
	Atributos[18]={////////
			validacion:{
				name:'nro_dias_para_rendir',
				fieldLabel:'Dias Para Rendir',
				allowBlank:true,	
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				align:'right',
				grid_indice:-3,
				renderer:render_saldo_solicitante
			},
			tipo:'Field',
			form:false
	};

		Atributos[19]={
			validacion:{
				name: 'cant_rendiciones', //indica la columna del store principal ds del que proviane la descripcion
				fieldLabel:'Cant. Rendiciones',
				allowBlank:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:110,
				grid_indice:-2,
				renderer:renderEstadoNumero	
			},
			tipo:'Field',
			filtro_0:true,
			filtro_1:true,
			form:false,		
			filterColValue:'CORRE.numero'
		};

		
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	
	
	//---------- INICIAMOS LAYOUT DETALLE
	
	if(vista=='recibo_caja')
		var config={titulo_maestro:'solicitud_efectivo',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/cuenta_doc_rendicion/rendicion_recibo_caja.php'};
	else
		var config={titulo_maestro:'solicitud_efectivo',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/cuenta_doc_rendicion/rendicion_recibo_rendido.php'};
		
	var layout_solicitud_viaticos2=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_solicitud_viaticos2.init(config);

	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_viaticos2,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var cm_mostrarComponente=this.mostrarComponente;
	var cm_ocultarComponente=this.ocultarComponente;
	var CM_getGrid=this.getGrid;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getFormulario=this.getFormulario;
	var CM_InitFunciones=this.InitFunciones;
	var CM_Save=this.Save;
	var CM_saveSuccess=this.saveSuccess;
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	if(vista=='recibo_caja')
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false}, 
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	else
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_doc/ActionEliminarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista2},
		Save:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista2,success:miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista2},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['95%'],width:'45%',minWidth:350,minHeight:400,closable:true,titulo:'solicitud_efectivo',
		
			grupos:[
			{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Vale',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Importe Entregado',
				columna:0,
				id_grupo:3
			}
			]
		}};
	
		
	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		
		//para iniciar eventos en el formulario
		for (var i=0;i<Atributos.length;i++)
		{
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		
				
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.bloquearMenu()
					}
		});
		componentes[1].on('select',evento_parametro);
			
	}
	function evento_parametro( combo, record, index )
	{		
			//Filtramos los presupuestos segun la gestion seleccionada
			componentes[3].store.baseParams={id_parametro:record.data.id_parametro};
			componentes[3].modificado=true;			
			componentes[3].setValue('');			
			componentes[3].setDisabled(false);												
 	}
	
	function miFuncionSuccess(resp)
	{		
		if(reporte==1)
		{	
			
			
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFReciboProvisionalFondosEfectivo.php?'+datos_reporte);
			CM_saveSuccess(resp);
		}
		else if(reporte==2)
		{	
								   
			

			switch (tipo_recibo){
				case 'provisorio':
				  window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionReciboProvisional.php?'+datos_reporte);
				  break;
				case 'pago':
				  window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionPagoCaja.php?'+datos_reporte);
				  break
				    
			}
				CM_saveSuccess(resp);			
		}
		else
		{
			
			CM_saveSuccess(resp);
		}
		reporte=0;
		
	}
	
		
		
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
		
		if(NumSelect!=0){
			var aux;
			var SelectionsRecord=sm.getSelected();
			aux={
					id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc,
					id_moneda:SelectionsRecord.data.id_moneda,
					importe:SelectionsRecord.data.importe,
					razon_social:''
				};
			Ext.apply(rec.data,aux);
		}			
		
		rec.data.tipo_cuenta_doc='rendicion_rendido';
		if(((rec.data.estado=='pagado'&&rec.data.tipo_recibo=='provisorio')||
			(rec.data.estado=='borrador'&&rec.data.tipo_recibo=='pago'))&&
			rec.data.id_subsistema!=4&&
			(rec.data.fk_id_cuenta_doc==''||rec.data.fk_id_cuenta_doc==undefined))
		{
			_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.desbloquearMenu()
		}
		else if(rec.data.id_subsistema==4)
		{
			rec.data.solo_lectura=3
			_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.bloquearMenu();
		}
		else{
			rec.data.solo_lectura=3
			_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.bloquearMenu();
		}
		_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.reload(rec.data);					
	}	
	
	this.btnNew=function(){
		paramFunciones.Save.parametros='&vista=solicitud_efectivo'+'&id_caja_0='+maestro.id_caja+'&accion=ninguna';
		CM_InitFunciones(paramFunciones);
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Importe Entregado');
		CM_mostrarGrupo('Datos Generales');
	    CM_mostrarGrupo('Datos Vale');
		componentes[11].setDisabled(true);	
		componentes[12].setDisabled(true);	
		componentes[4].allowBlank=false;
		componentes[13].allowBlank=true;
		cm_mostrarComponente(componentes[4]);
		cm_ocultarComponente(componentes[5]);
		CM_btnNew();
	}
	this.btnEdit=function(){
		paramFunciones.Save.parametros='&vista=solicitud_efectivo'+'&id_caja_0='+maestro.id_caja+'&accion=ninguna';		
		CM_InitFunciones(paramFunciones);
		validar_campos();
		CM_btnEdit();
	}
	
	function validar_campos(){
		
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Importe Entregado');
		CM_mostrarGrupo('Datos Generales');
	    CM_mostrarGrupo('Datos Vale');
	    componentes[13].allowBlank=true;
		
		if(NumSelect==1)
		{	
			componentes[11].setDisabled(false);	
			componentes[12].setDisabled(false);			
			if(SelectionsRecord.data.id_proveedor=='' || SelectionsRecord.data.id_proveedor==undefined){//es para el empleado
				
				cm_ocultarComponente(componentes[5]);
				componentes[5].allowBlank=true;	
				componentes[4].allowBlank=false;
				
				
				
			}
			else{
				
				cm_ocultarComponente(componentes[4]);
				componentes[5].allowBlank=false;	
			    componentes[4].allowBlank=true;
			    
			}
			
		}
		
		
	}
	
	function btn_reporte(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
	                
					  		
					var SelectionsRecord=sm.getSelected();
					var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
					   // data = data +'&estado='+ SelectionsRecord.data.estado;
					 if(reporte==2){
						data = data +'&estado=oficial';
					}else{
						 data = data +'&estado='+ SelectionsRecord.data.estado;
					}    
					   // alert (data);
					    
						window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFReciboProvisionalFondosEfectivo.php?'+data);
					
					}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
	
	function btn_pagar()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=pagar_provisorio';
			CM_InitFunciones(paramFunciones);
			
			datos_reporte='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
			datos_reporte = datos_reporte +'&estado='+ SelectionsRecord.data.estado;
			if((SelectionsRecord.data.fk_id_cuenta_doc=='' || SelectionsRecord.data.fk_id_cuenta_doc==undefined)  && SelectionsRecord.data.id_subsistema!='4'){
				reporte=0;
				
			}
			else{
				reporte=1;
				
			}
			
			
			CM_ocultarGrupo('Oculto');
			CM_mostrarGrupo('Importe Entregado');//mostrar
			CM_ocultarGrupo('Datos Generales');
		    CM_ocultarGrupo('Datos Vale');
		    componentes[13].setValue(SelectionsRecord.data.importe);		    
			SiBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			NoBlancosGrupo(3);
			if(SelectionsRecord.data.fk_id_cuenta_doc=='' || SelectionsRecord.data.fk_id_cuenta_doc==undefined)
				CM_btnEdit();
			else
				CM_Save();
			getDialog().buttons[0].enable();	
			
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
		
		
	}
			
	function btn_solicitud()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			//Impresión oficial del reporte de solicitud de pago
			reporte=2;
			Ext.Ajax.request({
				url:direccion+"../../../control/cuenta_doc/ActionEstadoViatico.php",
				method:'POST',
				params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc,accion:'solicitar_pago'},
				success:miSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});			
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_corregir()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1){
			reporte=0;		
			Ext.Ajax.request({
				url:direccion+"../../../control/cuenta_doc/ActionEstadoViatico.php",
				method:'POST',
				params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc,accion:'corregir_solicitud'},
				success:miSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});			
			
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	
	function miSuccess(resp)
	{
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			if(reporte==2 || reporte==1)
				btn_reporte();
					
			ClaseMadre_btnActualizar();
		}
		else
		{
			ClaseMadre_conexionFailure();
		}
		reporte=0;
	}		
	
	function btn_detalle_solicitud()
	{
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0)
				{
					var SelectionsRecord=sm.getSelected();
					var data='id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
					data=data+'&id_presupuesto='+SelectionsRecord.data.id_presupuesto;
					data=data+'&desc_presupuesto='+SelectionsRecord.data.desc_presupuesto;
					data=data+'&id_parametro='+SelectionsRecord.data.id_parametro;
					data=data+'&desc_parametro='+SelectionsRecord.data.desc_parametro;
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
					layout_solicitud_viaticos2.loadWindows(direccion+'../../../../sis_tesoreria/vista/detalle_viatico/detalle_recibo.php?'+data,'Detalle Solicitud',ParamVentana);
						
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
				}
	}
			
	
	function btn_finalizar()
	{
		
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
				datos_reporte='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
				datos_reporte = datos_reporte +'&estado='+ SelectionsRecord.data.estado;
				
				
				id_cuenta_doc =sm.getSelected().data.id_cuenta_doc;
				tipo_recibo=sm.getSelected().data.tipo_recibo;
				Ext.Ajax.request({
					url:direccion+"../../../control/cuenta_doc/ActionVerificarRendicionRecibo.php",
					success:cargar_respuesta,
					params:{'id_cuenta_doc':sm.getSelected().data.id_cuenta_doc},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un Vale.')
		}		
	}
	
		
	function cargar_respuesta(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			var mensaje='¿Está seguro de comprometer el importe de la rendición del recibo?';
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1')
			{
				mensaje='La rendición del recibo excede con ' + root.getElementsByTagName('monto')[0].firstChild.nodeValue + ' el valor del mismo. Se generará otro recibo por el valor indicado. ¿Desea Continuar?';
			}
			else 
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='-1')
			{
				mensaje='La rendición del recibo no completa el valor del mismo. Se generará una reposición por ' + root.getElementsByTagName('monto')[0].firstChild.nodeValue + ' . ¿Desea Continuar?';
			}
			else
			{
				mensaje='¿Esta seguro de comprometer el importe de la rendición del recibo?';
			}
			
			if(confirm(mensaje))
			{
				paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=finalizar';
				CM_InitFunciones(paramFunciones);
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				
				reporte=2;
				
				CM_Save();
			}						
		}
	}
	
	function btn_reporte2()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			
			var SelectionsRecord=sm.getSelected();
			var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
				//data = data +'&estado='+ SelectionsRecord.data.estado;
				 if(reporte==2){
						data = data +'&estado=oficial';
					}else{
						 data = data +'&estado='+ SelectionsRecord.data.estado;
					}
				
			switch (SelectionsRecord.data.tipo_recibo){
				case 'provisorio':
				  window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionReciboProvisional.php?'+data);
				  break;
				case 'pago':
				  window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionPagoCaja.php?'+data);
				  break
				    
			}
		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}
	
	function btn_reporte_estados()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		//var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
    	window.open(direccion+'../../../control/_reportes/estado_cuenta/ActionPDFEstadoSolEfe.php');
		
	}
	
	function SiBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	
	function NoBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_viaticos2.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				estado:vista
			}
		});
	if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de la solicitud',btn_detalle_solicitud,true,'detalle_solicitud','Detalle de Solicitud'); //tucrem
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Solicitud de Efectivo',btn_reporte,true,'imp_ejecucion','Solicitud');
	if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Solicitar Pago',btn_solicitud,true,'sol_pago','Solicitar Pago');
	if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Solicitud',btn_corregir,true,'cor_sol','Corregir Solicitud');
	if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Pago Provisorio',btn_pagar,true,'pagar','Pago Provisorio');
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Vista Previa de Rendicion',btn_reporte2,true,'imp_ejecucion2','Rendicion');
	if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar',btn_finalizar,true,'finalizar','Finalizar');
	
	//if(vista=='recibo_caja')
		this.AdicionarBoton('../../../lib/imagenes/print.gif','',btn_reporte_estados,true,'rep_estados','Reporte Estados Solicitudes Efectivos');
	
	function bloquearTodo(){
		CM_getBoton('imp_ejecucion-'+idContenedor).disable();
		CM_getBoton('imp_ejecucion2-'+idContenedor).disable();
		if(vista=='recibo_caja'){
			
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('detalle_solicitud-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion-'+idContenedor).disable();
			CM_getBoton('sol_pago-'+idContenedor).disable();
			CM_getBoton('cor_sol-'+idContenedor).disable();
			CM_getBoton('pagar-'+idContenedor).disable();
			CM_getBoton('imp_ejecucion2-'+idContenedor).disable();
			CM_getBoton('finalizar-'+idContenedor).disable();
		}
		
	}
	
	//var CM_getBoton=this.getBoton;
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		bloquearTodo();
		if(vista=='recibo_caja'){
			if(rec.data.estado=='borrador'){
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
				if(rec.data.tipo_recibo=='provisorio'){
					CM_getBoton('detalle_solicitud-'+idContenedor).enable();
				}
				if(rec.data.tipo_recibo!='provisorio' && rec.data.id_subsistema=='4'){
					CM_getBoton('eliminar-'+idContenedor).disable();
				}
			}
			if(rec.data.tipo_recibo=='provisorio'){
				CM_getBoton('imp_ejecucion-'+idContenedor).enable();
			}
			if(rec.data.tipo_recibo=='provisorio'&&rec.data.estado=='borrador'){
				CM_getBoton('sol_pago-'+idContenedor).enable();
			}
			if(rec.data.tipo_recibo=='provisorio'&&rec.data.estado=='pago_efectivo'
				&&rec.data.id_subsistema!='4'&&(rec.data.fk_id_cuenta_doc==''||rec.data.fk_id_cuenta_doc==undefined)){
				CM_getBoton('cor_sol-'+idContenedor).enable();
			}
			if(rec.data.estado=='pago_efectivo'){
				CM_getBoton('pagar-'+idContenedor).enable();
			}
			if((rec.data.estado=='pagado' && rec.data.tipo_recibo=='provisorio')||((rec.data.estado=='borrador' && rec.data.tipo_recibo=='pago'))){
				CM_getBoton('imp_ejecucion2-'+idContenedor).enable();
				CM_getBoton('finalizar-'+idContenedor).enable();
			}
			if(rec.data.tipo_recibo=='provisorio'&&rec.data.estado=='pago_efectivo'
				&&rec.data.id_subsistema!='4'&&(rec.data.fk_id_cuenta_doc!=''&&rec.data.fk_id_cuenta_doc!=undefined)){
				CM_getBoton('eliminar-'+idContenedor).enable();
			}
			/*if(rec.data.nro_dias_para_rendir < 0){
				CM_getBoton('pagar-'+idContenedor).disable();
			}*/
			
		}
		else{
			if(rec.data.tipo_recibo=='provisorio'){
				CM_getBoton('imp_ejecucion-'+idContenedor).enable();
				
				if(rec.data.fk_id_cuenta_doc==''||rec.data.fk_id_cuenta_doc==undefined)
					CM_getBoton('imp_ejecucion2-'+idContenedor).enable();
			}
			else{
				CM_getBoton('imp_ejecucion2-'+idContenedor).enable();
			}
					
		}
	}	
	
	
	ds_cajero.baseParams.estado=3;
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_viaticos2.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}