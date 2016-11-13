/*** Nombre:		  	    pagina_tipo_adq.js
* Propósito: 			pagina objeto principal
* Autor:				
* Fecha creación:		2010-08-23 11:47:21
*/
function pagina_sub_tipo_activo_cuenta(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sub_tipo_activo_cuenta/ActionListarSubTipoActivoCuenta.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_sub_tipo_activo_cuenta',totalRecords:'TotalCount'
		},[		
		'id_sub_tipo_activo_cuenta',
		'id_sub_tipo_activo',
		'estado_reg',
		'id_usuario_reg',
		'desc_usuario',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_proceso',
		'desc_proceso',
		'id_gestion',
		'gestion',
		'id_presupuesto',
		'desc_estructura',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},'id_cuenta2','id_auxiliar2','desc_cuenta2','desc_auxiliar2','id_fina_regi_prog_proy_acti','desc_epe',
		'id_tipo_activo','desc_tipo_activo','desc_sub_tipo_activo','nivel'

		]),remoteSort:true});

		//STORE COMBOS


		var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta'])
	}); 
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
	});
	var ds_proceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/proceso/ActionListaProceso.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proceso',totalRecords:'TotalCount'},['id_proceso','descripcion','codigo'])
	});
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion'])
	});

	
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])
	
	});
	
	var ds_cuenta2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta'])
	}); 
	var ds_auxiliar2 = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
	});
	
	var ds_tipo_activo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/tipo_activo/ActionListaTipoActivo.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_activo',totalRecords:'TotalCount'},['id_tipo_activo','descripcion','codigo'])
	});
	
	var ds_sub_tipo_activo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_sub_tipo_activo',totalRecords:'TotalCount'},['id_sub_tipo_activo','descripcion','codigo'])
	});

		////////////////FUNCIONES RENDER ////////////
		function render_id_estructura(value, p, record){return String.format('{0}', record.data['desc_estructura']);}
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	//var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	function render_id_proceso(value, p, record){return String.format('{0}', record.data['desc_proceso']);}
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_id_cuenta2(value, p, record){return String.format('{0}', record.data['desc_cuenta2']);}
	function render_id_auxiliar2(value, p, record){return String.format('{0}', record.data['desc_auxiliar2']);}
	
	function render_id_tipo_activo(value, p, record){return String.format('{0}', record.data['desc_tipo_activo']);}
	function render_id_sub_tipo_activo(value, p, record){return String.format('{0}', record.data['desc_sub_tipo_activo']);}
	

	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_cuenta}</FONT>','</div>'); 
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b><i>{codigo_auxiliar}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_auxiliar}</FONT>','</div>');
	var tpl_id_proceso=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>',' - ','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  <FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br> <b><FONT COLOR="#B5A642">{desc_presupuesto}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
 
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");
		

	var tpl_id_cuenta2=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_cuenta}</FONT>','</div>'); 
	var tpl_id_auxiliar2=new Ext.Template('<div class="search-item">','<b><i>{codigo_auxiliar}</i></b>',' - ','<FONT COLOR="#B5A642">{nombre_auxiliar}</FONT>','</div>');
	
	var tpl_id_tipo_activo=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	var tpl_id_sub_tipo_activo=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
		//FUNCIONES RENDER


		/////////////////////////
		// Definición de datos //
		/////////////////////////

Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_sub_tipo_activo_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_sub_tipo_activo_cuenta'
	};
	
	
	
	Atributos[1]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestion',
				allowBlank:true,
				emptyText:'Gestion...',
				desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField:'id_gestion',
				displayField:'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:false,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_gestion',
			id_grupo:0  //1
		};
	Atributos[2]={
			validacion:{
				name:'id_proceso',
				fieldLabel:'Proceso',
				allowBlank:true,
				emptyText:'Proceso...',
				desc: 'desc_proceso', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_proceso,
				valueField:'id_proceso',
				displayField:'codigo',
				queryParam: 'filterValue_0',
				filterCol:'PRO.codigo#PRO.descripcion',
				typeAhead:false,
				tpl:tpl_id_proceso,
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
				renderer:render_id_proceso,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'PROCES.codigo#PROCES.descripcion',
			save_as:'id_proceso',
			id_grupo:0  //1
		};
		Atributos[3]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'EP....',
			desc:'desc_estructura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_epe',
			queryParam:'filterValue_0',
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
			renderer:render_id_estructura,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			width_grid:150,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			disabled:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form:true,
		filterColValue:'ESTPRO.desc_epe',
		filtro_0:true,
		save_as:'id_presupuesto',
		id_grupo:2
	};
	
	
	
	Atributos[4]={
			validacion:{
				name:'id_cuenta',
				fieldLabel:'Cuenta',
				allowBlank:true,
				emptyText:'Cuenta...',
				desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cuenta,
				valueField:'id_cuenta',
				displayField:'nombre_cuenta',
				queryParam: 'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
				typeAhead:false,
				tpl:tpl_id_cuenta,
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
				renderer:render_id_cuenta,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			save_as:'id_cuenta',
			id_grupo:1  //1
		};
		
		
		Atributos[5]={
			validacion:{
				name:'id_auxiliar',
				fieldLabel:'Auxiliar',
				allowBlank:true,
				emptyText:'Auxiliar...',
				desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_auxiliar,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam: 'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				tpl:tpl_id_auxiliar,
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
				renderer:render_id_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			save_as:'id_auxiliar',
			id_grupo:1  //1
		};
		
		
		Atributos[6]={
			validacion:{
				name:'id_cuenta2',
				fieldLabel:'Cuenta2',
				allowBlank:true,
				emptyText:'Cuenta...',
				desc: 'desc_cuenta2', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cuenta2,
				valueField:'id_cuenta',
				displayField:'nombre_cuenta',
				queryParam: 'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
				typeAhead:false,
				tpl:tpl_id_cuenta2,
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
				renderer:render_id_cuenta2,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:5
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			save_as:'id_cuenta2',
			id_grupo:1  //1
		};
		
		
		Atributos[7]={
			validacion:{
				name:'id_auxiliar2',
				fieldLabel:'Auxiliar2',
				allowBlank:true,
				emptyText:'Auxiliar...',
				desc: 'desc_auxiliar2', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_auxiliar2,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam: 'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				tpl:tpl_id_auxiliar2,
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
				renderer:render_id_auxiliar2,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:6
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			save_as:'id_auxiliar2',
			id_grupo:1  //1
		};
		
	Atributos[8]={
			validacion:{
				name:'id_usuario_reg',
				fieldLabel:'Usuario',
				allowBlank:true,
				emptyText:'Usuario...',
				desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
				valueField:'id_usuario',
				displayField:'desc_usuario',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				//renderer:render_id_usuario,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:7
			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			save_as:'id_usuario_reg'
			
		};
	
	
		
		
		
	
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'EP',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			width:'100%'
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'id_fina_regi_prog_proy_acti',
		id_grupo:2
	};
	
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:false,
			grid_editable:false,
			width:'100%',
			disabled:true
		},
		tipo:'TextField',
		filtro_0:false,
		save_as:'id_unidad_organizacional',
		id_grupo:2
	};



	Atributos[11]={
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['tipo','Tipo Activo'],['subtipo','Sub Tipo Activo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:50,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:160,
			disable:true,
			grid_indice:9
		},
		tipo: 'ComboBox',
		defecto:'tipo',
		form: true,
		filtro_0:true,
		filterColValue:'SUTIAC.nivel',
		save_as:'nivel',
		id_grupo:0
	};
	
	Atributos[12]={
			validacion:{
				name:'id_tipo_activo',
				fieldLabel:'Tipo Activo',
				allowBlank:true,
				emptyText:'Tipo Activo...',
				desc: 'desc_tipo_activo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo_activo,
				valueField:'id_tipo_activo',
				displayField:'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'TIP.codigo#TIP.descripcion',
				typeAhead:false,
				tpl:tpl_id_tipo_activo,
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
				renderer:render_id_tipo_activo,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'TIPACT.codigo#TIPACT.descripcion',
			save_as:'id_tipo_activo',
			id_grupo:0  //1
		};
		
		Atributos[13]={
			validacion:{
				name:'id_sub_tipo_activo',
				fieldLabel:'Sub Tipo Activo',
				allowBlank:true,
				emptyText:'Sub Tipo Activo...',
				desc: 'desc_sub_tipo_activo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_sub_tipo_activo,
				valueField:'id_sub_tipo_activo',
				displayField:'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'SUB.codigo#SUB.descripcion',
				typeAhead:false,
				tpl:tpl_id_sub_tipo_activo,
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
				renderer:render_id_sub_tipo_activo,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			//defecto:d_moneda,
			filtro_0:true,
			filterColValue:'SUBTIP.codigo#SUBTIP.descripcion',
			save_as:'id_sub_tipo_activo',
			id_grupo:0  //1
		};
		
		// txt fecha_reg
	Atributos[14]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:8
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SUTIAC.fecha_reg',
		dateFormat:'m-d-Y',
		id_grupo:0  
	};
	
		// txt estado
	Atributos[15]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:true,
			maxLength:10,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:80,
			disable:true,
			grid_indice:9
		},
		tipo: 'ComboBox',
		defecto:'activo',
		form: false,
		filtro_0:true,
		filterColValue:'SUTIAC.estado_reg',
		save_as:'estado_reg'
	};
	
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Relación Cta-Auxiliar',grid_maestro:'grid-'+idContenedor};
		var layout_sub_tipo_activo_cuenta=new DocsLayoutMaestro(idContenedor);
		layout_sub_tipo_activo_cuenta.init(config);
		
		
		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_sub_tipo_activo_cuenta,idContenedor);
		var CM_ocultarComponente=this.ocultarComponente;
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
		var CM_btnEdit=this.btnEdit;
		var Cm_conexionFailure=this.conexionFailure;
		
		var CM_mostrarComponente=this.mostrarComponente;
		var ClaseMadre_btnActualizar=this.btnActualizar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_enableSelect=this.EnableSelect;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////




		var paramMenu = {
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear :true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////


		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionEliminarSubTipoActivoCuenta.php'},
	Save:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionGuardarSubTipoActivoCuenta.php'},
	ConfirmSave:{url:direccion+'../../../control/sub_tipo_activo_cuenta/ActionGuardarSubTipoActivoCuenta.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'55%',columnas:['47%','47%'],
			grupos:[
			{
				tituloGrupo:'Datos de Parametrizacion',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos Cuenta-Auxiliar',
				columna:1,
				id_grupo:1
			},{
				tituloGrupo:'Datos Presupuesto',
				columna:0,
				id_grupo:2
			}
			],
			width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Relación Cta-Auxiliar'}};
			
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



			//Para manejo de eventos
		function iniciarEventosFormularios(){ 
			h_nivel=getComponente('nivel');
			combo_tipo=getComponente('id_tipo_activo');		
			combo_gestion=getComponente('id_gestion');
			combo_ppto=getComponente('id_presupuesto');
			combo_cuenta=getComponente('id_cuenta');
			id_unidad_organizacional=getComponente('id_unidad_organizacional');
			id_fina_regi_prog_proy_acti=getComponente('id_fina_regi_prog_proy_acti');
			combo_auxiliar=getComponente('id_auxiliar');
			combo_auxiliar2=getComponente('id_auxiliar2');
			combo_cuenta2=getComponente('id_cuenta2');
			
			var onNivel=function(e){
				if(e.value=='tipo'){
					CM_ocultarComponente(getComponente('id_sub_tipo_activo'));
				}else{
					CM_mostrarComponente(getComponente('id_sub_tipo_activo'));
				}
			}
			h_nivel.on('change',onNivel);
			h_nivel.on('select',onNivel);
		
				
			var onTipo=function(e){
					ds_sub_tipo_activo.baseParams={
						m_id_tipo_activo:e.value
					}
			}
			getComponente('id_sub_tipo_activo').modificado=true;
			combo_tipo.on('select',onTipo);	
			combo_tipo.on('change',onTipo);	
				
				
			var onGestion=function(e){
				ds_presupuesto.baseParams={
					id_gestion:e.value
				};
				
				ds_cuenta.baseParams={
					m_id_gestion:e.value
				};
					
				ds_cuenta2.baseParams={
					m_id_gestion:e.value
				};
				getComponente('id_cuenta').enable();
				getComponente('id_cuenta2').enable();
				getComponente('id_presupuesto').modificado=true;
				getComponente('id_cuenta').modificado=true;
				getComponente('id_cuenta2').modificado=true;
			}
			combo_gestion.on('select',onGestion);
				
			var onPpto=function(e){
				var id_ep=combo_ppto.getValue();
				id_fina_regi_prog_proy_acti.setValue(combo_ppto.store.getById(id_ep).data.id_fina_regi_prog_proy_acti);
				id_unidad_organizacional.setValue(combo_ppto.store.getById(id_ep).data.id_unidad_organizacional);
				id_unidad_organizacional.setRawValue(combo_ppto.store.getById(id_ep).data.nombre_unidad);				
				id_fina_regi_prog_proy_acti.setRawValue(combo_ppto.store.getById(id_ep).data.desc_epe);
			}
			combo_ppto.on('select',onPpto);
				
				
			var onCuentaSelect =function(e){
				combo_auxiliar.setValue('');
				var id_cuenta = combo_cuenta.getValue();
				if(id_cuenta!=undefined){
					ds_auxiliar.baseParams=({"cuenta":id_cuenta})
					combo_auxiliar.enable();
					combo_auxiliar.modificado=true;
				}
			};
		
			var onCuenta2Select =function(e){
				combo_auxiliar2.setValue('');
				var id_cuenta2 = combo_cuenta2.getValue();
				if(id_cuenta2!=undefined){
					ds_auxiliar2.baseParams=({"cuenta":id_cuenta2})
					combo_auxiliar2.enable();
					combo_auxiliar2.modificado=true;
				}
			};
			combo_cuenta.on('select',onCuentaSelect);
			combo_cuenta2.on('select',onCuenta2Select);
		
		}


			this.btnNew = function(){ 
				CM_btnNew();
				CM_ocultarComponente(getComponente('id_sub_tipo_activo'));
			}
			
			this.btnEdit = function(){ 
				CM_btnEdit();
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					
					getComponente('id_fina_regi_prog_proy_acti').setValue(SelectionsRecord.data.id_fina_regi_prog_proy_acti);
					getComponente('id_fina_regi_prog_proy_acti').setRawValue(SelectionsRecord.data.desc_estructura);
					getComponente('id_unidad_organizacional').setValue(SelectionsRecord.data.id_unidad_organizacional);
					getComponente('id_unidad_organizacional').setRawValue(SelectionsRecord.data.desc_unidad_organizacional);
					if(SelectionsRecord.data.nivel=='tipo'){
						CM_ocultarComponente(getComponente('id_sub_tipo_activo'));
					}else{
						CM_mostrarComponente(getComponente('id_sub_tipo_activo'));
					}
				}
			}
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_sub_tipo_activo_cuenta.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);



			//SOBRE CARGA DE FUNCIONES


	       function  enable(sel,row,selected){
				var record=selected.data; 			
				CM_enableSelect(sel,row,selected)
			}	


			this.iniciaFormulario();
			iniciarEventosFormularios();

			layout_sub_tipo_activo_cuenta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);


			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});

}


