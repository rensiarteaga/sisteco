/**
 * Nombre:		  	    pagina_solicitud_viaticos2.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2009-10-27 11:50:07
 */
function pagina_solicitud_viaticos2(idContenedor,direccion,paramConfig,vista,id_cuenta_doc){
	var Atributos=new Array,sw=0;
	
	var maestro=new Array;
	var componentes=new Array;
	var fecha=new Date();
	var grid;
	var reporte; //reporte 0:sin reporte, reporte 1: vista previa, reporte 2: reporte oficial
	var cm;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarSolicitudViaticos2.php?tipo_cuenta_doc='+vista}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cuenta_doc',totalRecords:'TotalCount'
		},[		
		'id_cuenta_doc',
		'id_presupuesto',
		'desc_presupuesto',
		'id_empleado',
		'desc_empleado',
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
		'saldo_solicitante',
		'tipo_pago_fin',
		'id_cuenta_bancaria',
		'id_cuenta_bancaria_fin',
		'id_caja_fin',
		'id_cajero_fin',
		'nro_deposito',
		'desc_cuenta_bancaria_fin',
		'desc_caja_fin',
		'desc_cajero_fin',
		
		'resp_registro',
		'id_autorizacion',
		'desc_autorizacion',
		'nombre_cheque'
		
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});

    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});

    var ds_categoria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/categoria/ActionListarCategoria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords: 'TotalCount'},['id_categoria','desc_categoria','cod_categoria'])
	});

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','nombre','apellido_paterno','apellido_materno','desc_persona'])
	});

    var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});
	
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
    
    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco'])
    });

    var ds_usr_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
    
    var ds_id_autorizacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});
	
	//FUNCIONES RENDER
	
		function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gesti�n: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B5A642">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
		
		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

		function render_id_categoria(value, p, record){return String.format('{0}', record.data['desc_categoria']);}
		var tpl_id_categoria=new Ext.Template('<div class="search-item">','{desc_categoria}<br>','</div>');

		function render_id_usuario_rendicion(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		var tpl_id_usuario_rendicion=new Ext.Template('<div class="search-item">','{desc_persona}<br>','</div>');

		function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');

	
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{simbolo}</FONT>','</div>');
		
		function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
		
		var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro. Cuenta: </b>{nro_cuenta_banco}</FONT>','</div>');
		
		function render_id_usr_reg(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['resp_registro']+ '</span>');}else{return String.format('{0}', record.data['resp_registro']);}}
		var tpl_id_usr_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado
		
		function render_id_autorizacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_autorizacion']+ '</span>');}else{return String.format('{0}', record.data['desc_autorizacion']);}}
		var tpl_id_autorizacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado

		
		//Funci�n para el formato de los importes
		function formatoImporte(num){  
			 var cadena = ""; var aux;  
			 var cont = 1,m,k;  
			   
			 if(num<0) aux=1; else aux=0;  
			 num=num.toString();  
		   
			 for(m=num.length-1; m>=0; m--){
				 cadena = num.charAt(m) + cadena;  
				 if(num.charAt(m)!='.'){
				   
					 if(cont%3 == 0 && m >aux)  cadena = "," + cadena; else cadena = cadena;  
				   
					 if(cont== 3) cont = 1; else cont++;  
				 } else{
					 cont = 1;
				 }
			 }  
			 return cadena;  
		}
		
		function render_saldo_solicitante(value, p, record){
			var num=formatoImporte(value);
			if(value<0){
				return String.format('{0}', '<FONT COLOR="#FF0000"><b>'+num+'</b></FONT>');
			} else if(value>0){
				return String.format('{0}', '<FONT COLOR="#0000FF"><b>'+num+'</b></FONT>');
			} else{
				return String.format('{0}', '<b>'+num+'</b>');
			}
		}
		

	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc
	//en la posici�n 0 siempre esta la llave primaria

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
	
	// txt id_depto
	Atributos[1]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Tesorer�a',
			allowBlank:false,			
			emptyText:'Departamento de Tesorer�a...',
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
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
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
		filterColValue:'DEPTO.codigo_depto#DEPTO.nombre_depto',
		id_grupo:0
		
	};
	
// txt id_presupuesto
	Atributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto....',
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
		
	};
// txt id_empleado
	Atributos[3]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:false,			
			emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			onSelect: function(record){ if(vista!='solicitud_efectivo'){  componentes[29].setValue(record.data.desc_persona)  ;} componentes[3].setValue(record.data.id_empleado);componentes[3].collapse(); },
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'EMPLEA_2.nombre_completo#EMPLEA_2.codigo_empleado',
		id_grupo:0
		
	};
// txt id_categoria
	Atributos[4]={
			validacion:{
			name:'id_categoria',
			fieldLabel:'Categor�a',
			allowBlank:false,			
			emptyText:'Categor�a...',
			desc: 'desc_categoria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria,
			valueField: 'id_categoria',
			displayField: 'desc_categoria',
			queryParam: 'filterValue_0',
			filterCol:'CATEGO.desc_categoria',
			typeAhead:true,
			tpl:tpl_id_categoria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, //caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CATEGO.desc_categoria',
		id_grupo:4
		
	};
// txt fecha_ini
	Atributos[5]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:6
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:3
		
	};
// txt fecha_fin
	Atributos[6]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:7		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:3
		
	};
// txt tipo_pago
	Atributos[7]={
		validacion:{
			name:'tipo_pago',
			fieldLabel:'Forma de Pago',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','cheque'],['efectivo','efectivo'],['deposito','deposito']]}),
			valueField:'ID',
			displayField:'valor',
			onSelect:function(record){
								componentes[7].setValue(record.data.ID);
								componentes[7].collapse();
								if(record.data.ID=='efectivo'){
									//Oculta y fija el valor opcional al nro_deposito
									CM_ocultarComp(componentes[29]);
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=true;
								} else if(record.data.ID=='cheque'){
									//Oculta y fija el valor opcional al nro_deposito
									CM_mostrarComp(componentes[29]);
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=false;
				
								} else if(record.data.ID=='deposito'){
									//Oculta y fija el valor opcional al nro_deposito
									CM_ocultarComp(componentes[29]);
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=true;
								}  					
				},
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			disabled:false,
			grid_indice:8		
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.tipo_pago',
		defecto:'cheque',
		id_grupo:1		
	};
// txt tipo_contrato
	Atributos[8]={
			validacion: {
			name:'tipo_contrato',
			fieldLabel:'Personal de',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['planta','planta'],['contrato','contrato']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			disabled:false,
			grid_indice:9		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.tipo_contrato',
		defecto:'planta',
		id_grupo:4		
	};
// txt id_usuario_rendicion
	Atributos[9]={
			validacion:{
			name:'id_usuario_rendicion',
			fieldLabel:'Usuario Rendici�n',
			allowBlank:true,			
			emptyText:'Usuario Rendici�n...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_rendicion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_rendicion,
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:11		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_8.apellido_paterno#PERSON_8.apellido_materno#PERSON_8.nombre',
		id_grupo:2		
	};
// txt estado
	Atributos[10]={
		validacion:{
			name: 'estado', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:10		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CUDOC.estado',
	};
// txt nro_documento
	Atributos[11]={
		validacion:{
			name: 'nro_documento', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'No',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:2		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CUDOC.nro_documento',
	};
// txt fecha_reg
	Atributos[12]={
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
		filterColValue:'CUDOC.fecha_reg',
	};
// txt motivo
	Atributos[13]={
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:13		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.motivo',
		id_grupo:0
		
	};
// txt recorrido
	Atributos[14]={
		validacion:{
			name:'recorrido',
			fieldLabel:'Recorrido',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:14		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.recorrido',
		id_grupo:3
		
	};
// txt observaciones
	Atributos[15]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:15		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.observaciones',
		id_grupo:1
		
	};
	Atributos[16]= {
		validacion:{
			name:'fecha_sol',
			fieldLabel:'Fecha de Solicitud',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:7		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_sol',
		dateFormat:'m-d-Y',
		//defecto:fecha.dateFormat('d/m/Y'),
		id_grupo:1
		
	};
	
	Atributos[17]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
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
			onSelect:function(record){
				
				
				componentes[17].setValue(record.data.id_caja);
				componentes[17].collapse();
				componentes[18].reset();
				ds_cajero.baseParams.m_id_caja=record.data.id_caja;
				componentes[18].modificado=true							
			},
			
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
		save_as:'id_caja',
		id_grupo:5
	};
// txt id_cajero
	Atributos[18]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			emptyText:'Cajero...',
			desc: 'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:5
	};
	
	Atributos[19]={////////
			validacion:{
				name:'saldo_solicitante',
				fieldLabel:'Saldo Solicitante',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				align:'right',
				grid_indice:-1,
				renderer:render_saldo_solicitante
			},
			tipo:'Field',
			form:false,
			filtro_0:true
		};
		
	// responsable de registro
	Atributos[20]={
			validacion:{
			name:'id_usr_reg',
			fieldLabel:'Responsable Registro', //Empleado
			allowBlank:true,		
			desc: 'resp_registro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usr_reg,
			valueField: 'id_usr_reg',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre', //busqueda en el formulario
			typeAhead:true,
			tpl:tpl_id_usr_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usr_reg,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false
			//grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre', //busqueda en la tabla		
		id_grupo:3	//grupo oculto
	};

	// txt id_empleado
	Atributos[21]={
			validacion:{
			name:'id_autorizacion',
			fieldLabel:'Firma Autorizaci�n', //Empleado de la gerencia que autoriza los viajes
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_autorizacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_autorizacion,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_autorizacion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_autorizacion,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON4.apellido_paterno#PERSON4.apellido_materno#PERSON4.nombre',
		//save_as:'id_autorizacion',
		id_grupo:3
	};
	
	if(vista!='solicitud_efectivo'){	
	// txt id_moneda
		Atributos[22]={
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
				disabled:false,
				grid_indice:5/**/
			},
			tipo:'ComboBox',
			form: true,
			//defecto:'Bolivianos',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda',
			id_grupo:0
		};
		
		Atributos[23]={
				validacion:{
					name:'id_cuenta_bancaria',
					fieldLabel:'Cuenta Bancaria',
					allowBlank:false,
					emptyText:'Cuenta...',
					store:ds_cuenta_bancaria,
					valueField:'id_cuenta_bancaria',
					displayField:'nro_cuenta_banco',
					queryParam:'filterValue_0',
					filterCol:'CUEBAN.id_cuenta_bancaria',
					typeAhead:false,
					tpl:tpl_cuenta_bancaria,
					forceSelection:false,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					width:200
				},
				tipo:'ComboBox',
				save_as:'id_cuenta_bancaria',
				id_grupo:6
			};
		
		//
		Atributos[24]={
				validacion:{
					name:'tipo_pago_fin',
					fieldLabel:'Forma de Pago Saldo',
					allowBlank:false,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','cheque'],['efectivo','efectivo'],['deposito','deposito']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					grid_visible:true,
					grid_editable:false,
					width_grid:120,
					disabled:false,
					onSelect:function(record){
								componentes[24].setValue(record.data.ID);
								componentes[24].collapse();
								if(record.data.ID=='efectivo'){
									CM_mostrarGrupo('Datos Finalizaci�n Efectivo');
									CM_ocultarGrupo('Datos Finalizaci�n');
									SiBlancosGrupo(8);
									NoBlancosGrupo(9);
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=true;
								} else if(record.data.ID=='cheque'){
									CM_mostrarGrupo('Datos Finalizaci�n');
									CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
									SiBlancosGrupo(9);
									NoBlancosGrupo(8);
									//Oculta y fija el valor opcional al nro_deposito
									CM_ocultarComp(componentes[26]);
									componentes[26].allowBlank=true;
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=false;
				
								} else if(record.data.ID=='deposito'){
									CM_mostrarGrupo('Datos Finalizaci�n');
									CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
									CM_mostrarComp(componentes[26]);
									SiBlancosGrupo(9);
									NoBlancosGrupo(8);
									//Nombre cheque permite en blanco
									componentes[29].allowBlank=true;
								}  
					}
				},
				tipo: 'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'CUDOC.tipo_pago_fin',
				defecto:'cheque',
				id_grupo:7
				
			};
		
		Atributos[25]={
				validacion:{
					name:'id_cuenta_bancaria_fin',
					fieldLabel:'Cuenta Bancaria Fin.',
					allowBlank:false,
					emptyText:'Cuenta...',
					desc:'desc_cuenta_bancaria_fin',
					store:ds_cuenta_bancaria,
					valueField:'id_cuenta_bancaria',
					displayField:'nro_cuenta_banco',
					queryParam:'filterValue_0',
					filterCol:'CUEBAN.id_cuenta_bancaria',
					typeAhead:false,
					tpl:tpl_cuenta_bancaria,
					forceSelection:false,
					mode:'remote',
					queryDelay:250,
					pageSize:10,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					minChars:1, // /caracteres m�nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					width:200
				},
				tipo:'ComboBox',
				id_grupo:8
			};
		
		Atributos[26]={
				validacion:{
					name:'nro_deposito',
					fieldLabel:'N�mero Dep�sito',
					allowBlank:true,
					maxLength:40,
					minLength:0,
					selectOnFocus:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:130,
					width:'100%',
					disabled:false		
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'CUDOC.nro_deposito',
				id_grupo:8
				
			};
		
		Atributos[27]={
				validacion:{
				name:'id_caja_fin',
				fieldLabel:'Caja Fin.',
				allowBlank:false,			
				emptyText:'Caja...',
				desc: 'desc_caja_fin', //indica la columna del store principal ds del que proviane la descripcion
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
				onSelect:function(record){
					
					componentes[27].setValue(record.data.id_caja);
					componentes[27].collapse();
					componentes[28].reset();
					ds_cajero.baseParams.m_id_caja=record.data.id_caja;
					componentes[28].modificado=true							
				},
				
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
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
			id_grupo:9
		};
	// txt id_cajero
		Atributos[28]={
				validacion:{
				name:'id_cajero_fin',
				fieldLabel:'Cajero Fin.',
				allowBlank:false,			
				emptyText:'Cajero...',
				desc: 'desc_cajero_fin', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cajero,
				valueField: 'id_cajero',
				displayField: 'desc_empleado',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
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
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
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
			filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
			id_grupo:9
		};
		//
		Atributos[29]={
				validacion:{
					name:'nombre_cheque',
					fieldLabel:'Nombre Cheque',
					allowBlank:true,
					maxLength:70,
					minLength:0,
					selectOnFocus:true,
					grid_visible:true,
					grid_editable:true,
					width_grid:130,
					width:'100%',
					disabled:false		
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'CUDOC.nombre_cheque',
				id_grupo:1
				
			};
		
	}
	
	if(vista=='solicitud_avance'){	
		Atributos[30]={
			validacion:{
				name:'fa_solicitud',
				fieldLabel:'Fondo con Solicitud',
				allowBlank:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				disable:false,
				width:90
			},
			tipo:'ComboBox',
			defecto:'no',
			filtro_0:true,
			id_grupo:0
		};
	}
	
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	var titulo;
	if(vista=='solicitud_viatico'){
		titulo='Solicitud de Viaticos';
	}
	else if(vista=='ampliacion_viatico'){
		titulo='Ampliacion de Viaticos';
	}
	else if(vista=='solicitud_avance'){
		titulo='Solicitud de Fondo en Avance';
	}
	else if(vista=='ampliacion_avance'){
		titulo='Ampliacion de Fondo en Avance';
	}
	else if(vista=='solicitud efectivo'){
		titulo='Solicitud de Efectivo';
	}
	
	//---------- INICIAMOS LAYOUT DETALLE
	if(vista=='solicitud_viatico' || vista=='ampliacion_viatico'){
		var config={titulo_maestro:titulo,grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/detalle_viatico/detalle_viatico.php'};
	}
	else if(vista=='solicitud_efectivo'){
		var config={titulo_maestro:titulo,grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/detalle_viatico/detalle_efe.php'};
	}
	else
	{
		var config={titulo_maestro:titulo,grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/detalle_viatico/detalle_fa.php'};
	}
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
	var CM_getGrid=this.getGrid;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getFormulario=this.getFormulario;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	

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
		btnEliminar:{url:direccion+'../../../control/cuenta_doc/ActionEliminarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista},
		Save:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista},
		ConfirmSave:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php',parametros:'&fk_id_cuenta_doc='+id_cuenta_doc+'&vista='+vista},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],width:'65%',minWidth:350,minHeight:400,	closable:true,titulo:titulo,
		
			grupos:[
			{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Usuario Rendicion',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Datos Viaje',
				columna:1,
				id_grupo:3
			},
			{
				tituloGrupo:'Datos Viatico',
				columna:0,
				id_grupo:4
			},
			{
				tituloGrupo:'Datos Caja',
				columna:0,
				id_grupo:5
			},
			{
				tituloGrupo:'Datos Cuenta Bancaria',
				columna:0,
				id_grupo:6
			},
			{
				tituloGrupo:'Tipo Pago Finalizaci�n',
				columna:0,
				id_grupo:7
			},
			{
				tituloGrupo:'Datos Finalizaci�n',
				columna:0,
				id_grupo:8
			},
			{
				tituloGrupo:'Datos Finalizaci�n Efectivo',
				columna:0,
				id_grupo:9
			}]
		}};
	
		
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		if(vista='ampliacion_viatico'){	
			var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_cuenta_doc=datos.id_cuenta_doc;
			
			
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_cuenta_doc:maestro.id_cuenta_doc
					
				}
			};
			
			
			this.btnActualizar();
			
			iniciarEventosFormularios();
	
			
					
			paramFunciones.Save.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc+'&vista='+vista;
			paramFunciones.ConfirmSave.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc+'&vista='+vista;
			paramFunciones.btnEliminar.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc+'&vista='+vista;
			
			this.iniciarEventosFormularios;
			this.InitFunciones(paramFunciones);
			reporte=0;
		}
		
	};
		
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
	
	function DesplegarGruposPorTipoVista(){
		//Despliegue de grupos de acuerdo al tipo de vista
		if(vista=='solicitud_viatico'){
			CM_mostrarGrupo('Datos Generales');
			CM_mostrarGrupo('Datos Viaje');
			CM_mostrarGrupo('Datos');
			CM_mostrarGrupo('Datos Viatico');
			CM_ocultarGrupo('Usuario Rendicion');
			
			NoBlancosGrupo(0);
			NoBlancosGrupo(1);
			NoBlancosGrupo(3);
			NoBlancosGrupo(4);
			SiBlancosGrupo(2);
			ocultarColumnas('viatico');
			CM_ocultarGrupo('Datos Caja');
			CM_getBoton('cont_sol_pago-'+idContenedor).show();
			
		}
		else if(vista=='ampliacion_viatico'){
			CM_ocultarGrupo('Datos Generales');
			CM_ocultarGrupo('Datos Viatico');
			CM_mostrarGrupo('Datos Viaje');
			CM_mostrarGrupo('Datos');
			CM_ocultarGrupo('Usuario Rendicion');

			NoBlancosGrupo(1);
			NoBlancosGrupo(3);
			SiBlancosGrupo(0);
			SiBlancosGrupo(2);
			SiBlancosGrupo(4);
			ocultarColumnas('viatico');
			CM_ocultarGrupo('Datos Caja');
			CM_getBoton('cont_sol_pago-'+idContenedor).show();
			
		}
		else if(vista=='solicitud_avance')
		{
			CM_mostrarGrupo('Datos Generales');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Datos Viatico');
			CM_mostrarGrupo('Datos');
			CM_ocultarGrupo('Usuario Rendicion');

			NoBlancosGrupo(0);
			NoBlancosGrupo(1);
			SiBlancosGrupo(3);
			SiBlancosGrupo(2);
			SiBlancosGrupo(4);
			ocultarColumnas('avance');
			CM_ocultarGrupo('Datos Caja');
			CM_getBoton('cont_sol_pago-'+idContenedor).show();
			
		}
		else if(vista=='ampliacion_avance')
		{
			CM_ocultarGrupo('Datos Generales');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Datos Viatico');
			CM_mostrarGrupo('Datos');
			CM_ocultarGrupo('Usuario Rendicion');

			SiBlancosGrupo(3);
			NoBlancosGrupo(1);
			SiBlancosGrupo(0);
			SiBlancosGrupo(2);
			SiBlancosGrupo(4);
			ocultarColumnas('avance');
			CM_ocultarGrupo('Datos Caja');
			CM_getBoton('cont_sol_pago-'+idContenedor).show();
			
		}
		else if(vista=='solicitud_efectivo'){
			CM_mostrarGrupo('Datos Generales');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Datos Viatico');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Usuario Rendicion');

			NoBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(3);
			SiBlancosGrupo(2);
			SiBlancosGrupo(4);
			ocultarColumnas('efectivo');
			componentes[1].on('select',validarCaja);
			CM_mostrarGrupo('Datos Caja');
			CM_getBoton('cont_sol_pago-'+idContenedor).hide();
			CM_getBoton('cue_dep-'+idContenedor).hide();
			CM_getBoton('rend_fin-'+idContenedor).hide();
			CM_getBoton('sol_fin-'+idContenedor).hide();
		}
		
		//Ocultar los grupos de los datos de desembolso para cualquier caso de la vista
		CM_ocultarGrupo('Datos Cuenta Bancaria');
		CM_ocultarGrupo('Tipo Pago Finalizaci�n');
		CM_ocultarGrupo('Datos Finalizaci�n');
		CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
		
		//Definir como valores opcionales los grupos de datos de desembolso
		SiBlancosGrupo(5);
		SiBlancosGrupo(6);
		SiBlancosGrupo(7);
		SiBlancosGrupo(8);
		SiBlancosGrupo(9);
	}

	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	grid=CM_getGrid();
		cm=grid.getColumnModel();	
		maestro.id_cuenta_doc=id_cuenta_doc;
		//para iniciar eventos en el formulario
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		
		CM_ocultarComp(componentes[20]);
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.bloquearMenu()
					}
		});
		grid.on('beforeedit',validarEdicion);
		reporte=0;
		
		DesplegarGruposPorTipoVista();
		

		var limitarFechaFin = function(){
			//Ext.MessageBox.alert('Lanzando evento','Cambio de la fecha: '+componentes[5].getValue());
			
			/*var fecha_ini=new date(componentes[5].getValue());
			var fecha_fin=new date(componentes[6].getValue());
			
			if(fecha_fin!=''){
				if(fecha_fin<fecha_ini){
					componentes[6].setValue('');
				}
			}*/
			componentes[6].setValue('');
			componentes[6].reset();
			componentes[6].minValue=componentes[5].getValue();
		};
		
		componentes[5].on('blur',limitarFechaFin);
	
	}
	
	function ocultarColumnas(tipo)
	{
		if(tipo!='viatico'){
			//alert(CM_getColumnNum('id_categoria'));
			cm.setHidden(CM_getColumnNum('id_categoria'),true);
			cm.setHidden(CM_getColumnNum('fecha_ini'),true);
			cm.setHidden(CM_getColumnNum('fecha_fin'),true);
			cm.setHidden(CM_getColumnNum('tipo_contrato'),true);
			cm.setHidden(CM_getColumnNum('recorrido'),true);
			if(tipo=='efectivo'){
				cm.setHidden(CM_getColumnNum('observaciones'),true);
				cm.setHidden(CM_getColumnNum('fecha_sol'),true);
				cm.setHidden(CM_getColumnNum('tipo_pago'),true);
				cm.setHidden(CM_getColumnNum('id_usuario_rendicion'),true);
				cm.setHidden(CM_getColumnNum('saldo_solicitante'),true);
			}
		}			
	}
	
	function validarCaja(combo,record, index)
	{
		componentes[1].setValue(record.data.id_depto);
		componentes[1].collapse();
		componentes[17].reset();
		ds_caja.baseParams.m_id_depto=record.data.id_depto;
		componentes[17].modificado=true	
	}
	
	function validarEdicion(o){
		if(o.field=='id_usuario_rendicion'){
			return true;
		}
		else{
			if(o.record.data.estado=='borrador'||o.record.data.estado=='solicitud_pago'||o.record.data.estado=='conta_pago'){
				return true;
			}
			else{
				alert('No puede modificar una solicitud en estado: '+o.record.data.estado);
				return false;
			}
		}
	}
	
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		
				datas_edit=rec.data;
				if(rec.data.estado=='borrador'){
					_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.desbloquearMenu()
				}
				_CP.getPagina(layout_solicitud_viaticos2.getIdContentHijo()).pagina.reload(rec.data);
				
					
	}	
	
	function btnRendicion(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();

					var data='id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
					data=data+'&observacion='+SelectionsRecord.data.motivo;
					

					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
					layout_solicitud_viaticos2.loadWindows(direccion+'../../../../sis_tesoreria/vista/cuenta_doc_rendicion_cab/cuenta_doc_rendicion_cab.php?'+data,'Rendicion de Vi�tico',ParamVentana);
						
						
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
	function btnAmpliacion(){
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			if(NumSelect!=0){

				var SelectionsRecord=sm.getSelected();

				var data='id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
				
				if(vista=='solicitud_viatico')
					data=data+'&vista=ampliacion_viatico';
				else
					data=data+'&vista=ampliacion_avance';

				var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
				layout_solicitud_viaticos2.loadWindows(direccion+'../../../../sis_tesoreria/vista/solicitud_viaticos2/ampliacion.php?'+data,'Ampliaciones',ParamVentana);
						
						
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
	}
	
	this.btnNew = function(){
		//Restituye los valores originales para almacenar los datos
		CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php?';
		
		//Esconde y muestra los grupos correspondientes
		DesplegarGruposPorTipoVista();
		
		//Ejecuci�n funci�n de inserci�n
		CM_btnNew();
	}
	
	this.btnEdit = function(){
		//Restituye los valores originales para almacenar los datos
		CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php?';
		
		//Esconde y muestra los grupos correspondientes
		DesplegarGruposPorTipoVista();
		
		//Ejecuta funci�n de Edici�n
		CM_btnEdit();
	}
	
	function btn_cont_sol_pag(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			// Define el Action para el cambio de estado del registro temporalmente
			CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionContabilizarSolPag.php?accion=contabilizar_sol_pago';
		
			// Verificaci�n del tipo de pago para habilitar la ventana para
			// introducci�n de los datos faltantes
			if(SelectionsRecord.data.tipo_pago=='cheque'){
				// Despliega el grupo de los datos de la cuenta bancaria
				CM_mostrarGrupo('Datos Cuenta Bancaria');
			
				// Oculta los dem�s grupos
				CM_ocultarGrupo('Datos Generales');
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Usuario Rendicion');
				CM_ocultarGrupo('Datos Viaje');
				CM_ocultarGrupo('Datos Viatico');
				CM_ocultarGrupo('Datos Caja');
				
				//Nombre cheque permite en blanco
				componentes[29].allowBlank=false;
			
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				SiBlancosGrupo(4);
				SiBlancosGrupo(5);
				NoBlancosGrupo(6);				
				
				// Llamamos a la funci�n sobrecarga del Edit
				CM_btnEdit();
			
			} else if(SelectionsRecord.data.tipo_pago=='efectivo'){
				// Despliega el grupo de los datos del cajero
				CM_mostrarGrupo('Datos Caja');
			
				// Oculta los dem�s grupos
				CM_ocultarGrupo('Datos Generales');
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Usuario Rendicion');
				CM_ocultarGrupo('Datos Viaje');
				CM_ocultarGrupo('Datos Viatico');
				CM_ocultarGrupo('Datos Cuenta Bancaria');				
			
				// Define como opcionales todos los campos de los grupos no
				// visibles, y como obligatorios el grupo visible
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				SiBlancosGrupo(3);
				SiBlancosGrupo(4);
				NoBlancosGrupo(5);
				SiBlancosGrupo(6);				

				// Llamamos a la funci�n sobrecarga del Edit
				CM_btnEdit();
			
			}
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_solicitud(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			//Impresi�n oficial del reporte de solicitud de pago
			reporte=2;
			Ext.Ajax.request({
				url:direccion+"../../../control/cuenta_doc/ActionEstadoViatico.php",
				method:'POST',
				params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc,accion:'solicitar_pago'},
				success:esteSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});			
			
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_corregir(){
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
				success:esteSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});			
			
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_fin(){
		//Finalizaci�n definitiva
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1){
			if(confirm('�Est� seguro de Finalizar el registro?')){
				Ext.Ajax.request({
					url:direccion+"../../../control/cuenta_doc/ActionFinalizarCuentaDoc.php",
					method:'POST',
					params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc},
					success:esteSuccess,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});			
			}
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_fin_rend(){
		//Finalizaci�n por el solicitante
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1){
			if(confirm('�Est� seguro de Terminar todas las Rendiciones?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Finalizando la Solicitud...</div>",
					width:300,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/cuenta_doc/ActionFinalizarRendiciones.php",
					method:'POST',
					params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc},
					success:esteSuccess,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});			
			}
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btn_cue_dep(){
		//Registro de cuenta bancaria cuando el saldo es a favor del solicitante, y cuenta bancaria y dep�sito cuando el saldo es a favor de la empresa
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			//Verifica si el saldo es distinto de cero, si es cero no permite hacer el registro
			var aux=parseFloat(SelectionsRecord.data.saldo_solicitante);
			if(aux==0){
				Ext.MessageBox.alert('Operaci�n no permitida','El saldo es cero. Proceda directamente con la Finalizaci�n.');
				return;
			}
			
			// Define el Action para el cambio de estado del registro temporalmente
			CM_getFormulario().url=direccion+'../../../control/cuenta_doc/ActionRegistrarCuentaDepositoFin.php';
			
			// Despliega el grupo de los datos de la cuenta bancaria
			CM_mostrarGrupo('Tipo Pago Finalizaci�n');
			
			// Oculta los dem�s grupos
			CM_ocultarGrupo('Datos Cuenta Bancaria');
			CM_ocultarGrupo('Datos Generales');
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Usuario Rendicion');
			CM_ocultarGrupo('Datos Viaje');
			CM_ocultarGrupo('Datos Viatico');
			CM_ocultarGrupo('Datos Caja');
			CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
			CM_ocultarGrupo('Datos Finalizaci�n');
		
			// Define como opcionales todos los campos de los grupos no
			// visibles, y como obligatorios el grupo visible
			SiBlancosGrupo(0);
			SiBlancosGrupo(1);
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(4);
			SiBlancosGrupo(5);
			SiBlancosGrupo(6);
			NoBlancosGrupo(7);
			SiBlancosGrupo(8);
			SiBlancosGrupo(9);
			
			//Verifica si se ha llenado ya el tipo_pago_fin para mostrar los datos
			var strTipoPagoFin=SelectionsRecord.data.tipo_pago_fin;
			
			if(strTipoPagoFin!=''){
				if(strTipoPagoFin=='efectivo'){
					CM_mostrarGrupo('Datos Finalizaci�n Efectivo');
					CM_ocultarGrupo('Datos Finalizaci�n');
					SiBlancosGrupo(8);
					NoBlancosGrupo(9);
				}else if(strTipoPagoFin=='cheque'){
					CM_mostrarGrupo('Datos Finalizaci�n');
					CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
					SiBlancosGrupo(9);
					NoBlancosGrupo(8);
					//Oculta y fija el valor opcional al nro_deposito
					CM_ocultarComp(componentes[26]);
					componentes[26].allowBlank=true;
				} else if(strTipoPagoFin=='deposito'){
					CM_mostrarGrupo('Datos Finalizaci�n');
					CM_ocultarGrupo('Datos Finalizaci�n Efectivo');
					CM_mostrarComp(componentes[26]);
					SiBlancosGrupo(9);
					NoBlancosGrupo(8);
				}
			}
			
			//Verifica el saldo del solicitante para desplegar una alerta
			var saldoSolic=parseFloat(SelectionsRecord.data.saldo_solicitante);
			if(saldoSolic<0){
				alert('Saldo a favor de la Empresa: '+saldoSolic*(-1));
			} else if(saldoSolic>0){
				alert('Saldo a favor del Solicitante: '+saldoSolic);
			} else{
				alert('No hay saldo');
				return;
			}

			// Llamamos a la funci�n sobrecarga del Edit
			CM_btnEdit();
			
		} else{
			Ext.MessageBox.alert('Atenci�n', 'Antes debe seleccionar un registro.');
		}
		
	}
	
	
	function esteSuccess(resp){
		Ext.MessageBox.hide();
				if(resp.responseXML&&resp.responseXML.documentElement){
					if(reporte==2 || reporte==1)
						btn_reporte();
					
					ClaseMadre_btnActualizar();
				}
				else{
					ClaseMadre_conexionFailure();
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
					if(reporte==2){
						data = data +'&estado=oficial';
					}else{
						 data = data +'&estado='+ SelectionsRecord.data.estado;
					}
					  				    
					switch (vista)
					{
						case 'solicitud_viatico': 
						 	window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolViaje.php?'+data);
						 	 break;
						case 'solicitud_avance':
						 	window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolicitudFondos.php?'+data)
						 	 break;
						case 'ampliacion_viatico':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolViaje.php?'+data);
							break;
						case 'ampliacion_avance':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFSolicitudFondos.php?'+data);
							break;
						case 'solicitud_efectivo':
							window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFReciboProvisionalFondosEfectivo.php?'+data);
							break;							
						 	
					}
				
					}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	 
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_solicitud_viaticos2.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	if(vista=='ampliacion_viatico'){
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_cuenta_doc:id_cuenta_doc
			}
		});
	}
	else{
	//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});
	}
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Solicitud de Vi�ticos',btn_reporte,true,'imp_ejecucion','Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Solicitar Pago',btn_solicitud,true,'sol_pago','Solicitar Pago');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Contabilizar Pago',btn_cont_sol_pag,false,'cont_sol_pago','Contabilizar Pago');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir Solicitud',btn_corregir,true,'cor_sol','Corregir Solicitud');
	if(vista=='solicitud_viatico'||vista=='solicitud_avance'){
		//para agregar botones
		
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Rendiciones',btnRendicion,true,'rendicion','Rendiciones'); //tucrem
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Ampliaciones',btnAmpliacion,true,'ampliacion','Ampliaciones'); //tucrem
	}
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Terminar Rendiciones',btn_fin_rend,false,'rend_fin','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Registrar Cuenta Bancaria/Dep�sito',btn_cue_dep,false,'cue_dep','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar',btn_fin,false,'sol_fin','');
	
	
	
	function bloquearbotones(tipo){
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('sol_pago-'+idContenedor).disable();
		CM_getBoton('cor_sol-'+idContenedor).disable();
		CM_getBoton('imp_ejecucion-'+idContenedor).disable();
		CM_getBoton('cont_sol_pago-'+idContenedor).disable();
		CM_getBoton('rend_fin-'+idContenedor).disable();
		CM_getBoton('sol_fin-'+idContenedor).disable();
		CM_getBoton('cue_dep-'+idContenedor).disable();
				
		if(tipo=='solicitud' && vista!='solicitud_efectivo'){
			CM_getBoton('rendicion-'+idContenedor).disable();
			CM_getBoton('ampliacion-'+idContenedor).disable();
		}
	}
	
	
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		if(maestro.id_cuenta_doc!=0)
			bloquearbotones('ampliacion');
		else
			bloquearbotones('solicitud');
			
			if(rec.data['estado']=='borrador'){
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
				CM_getBoton('sol_pago-'+idContenedor).enable();
				CM_getBoton('imp_ejecucion-'+idContenedor).enable();
				
				
			}
			else if((vista!='solicitud_efectivo' && rec.data['estado']=='solicitud_pago')||(vista=='solicitud_efectivo' && rec.data['estado']=='pago_efectivo')){
				
				CM_getBoton('cor_sol-'+idContenedor).enable();
				CM_getBoton('cont_sol_pago-'+idContenedor).enable();
				
			}
		
		if(maestro.id_cuenta_doc==0){//es una solicitud
			if(rec.data['estado']=='pagado'){
				if(vista!='solicitud_efectivo'){
					CM_getBoton('rendicion-'+idContenedor).enable();
					CM_getBoton('ampliacion-'+idContenedor).enable();
					CM_getBoton('rend_fin-'+idContenedor).enable();
				}
			} else if(rec.data['estado']=='en_finaliz'){
				CM_getBoton('sol_fin-'+idContenedor).enable();
				CM_getBoton('cue_dep-'+idContenedor).enable();
			}
		}		
	}
	if(vista=='solicitud_efectivo')
		ds_cajero.baseParams.estado=3;
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_viaticos2.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}