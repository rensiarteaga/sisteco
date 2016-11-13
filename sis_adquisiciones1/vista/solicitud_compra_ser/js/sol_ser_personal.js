/**
* Nombre:		  	    pagina_solicitud_compra_personal_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-09 09:11:12
*/



//modificar  el onSelect de solicitante para que cuando elija id_tipo_categoria filtre despues los RPAs en base a la categoria que eligió y seguir modificando en la BD para que guarde!!
function pag_sol_ser_personal(idContenedor,direccion,empleado,paramConfig){
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
		'tiene_presupuesto',
		'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_tipo_adq',
		'desc_tipo_adq',
		'tipo_adq',
		'simbolo','id_frppa','observaciones_estado', 'tipo_cambio','id_parametro_adquisicion','id_periodo','id_moneda_base','numeracion_periodo',
		'id_orden_trabajo','desc_orden','id_uo_gerencia','id_empleado','id_depto','desc_depto','proveedores_propuestos','comite_calificacion','comite_recepcion','avance','id_avance','nro_avance',
		'id_correspondencia','id_presupuesto','desc_presupuesto','correspondencia_asociada','id_gestion'

		]),remoteSort:true});

		//carga datos XML
		
		//DATA STORE COMBOS
		var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php?estado=activo'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
		});

	

		var ds_tipo_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_adq/ActionListarTipoAdq.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_adq',totalRecords: 'TotalCount'},['id_tipo_adq','nombre','observaciones','tipo_adq','descripcion','fecha_reg'])
		});

		var ds_orden_trabajo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario','desc_usuario'])
		});

		var ds_gestion_paradq= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_adquisicion/ActionListarGestionParametroAdq.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_adquisicion',totalRecords: 'TotalCount'},['id_parametro_adquisicion','gestion','id_gestion'])
		});

		var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto_ep','id_depto','desc_depto','estado','desc_ep'])
		});
		
		
		//9ago11
		var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
																																								'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
																																								'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																								'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																																								]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});

var ds_correspondencia = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_flujo/control/correspondencia/ActionListarCorrespondencia.php?sol=1&vista=enviado&tipo=interna'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_correspondencia',totalRecords: 'TotalCount'},['id_correspondencia','numero','desc_empleado','desc_documento','referencia'])
	});
	
	var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php?tipo=sol'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre','desc_categoria_adq','doc_respaldo'])
	});
	
	
	var ds_empleado_aprobador = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','id_persona','desc_persona','codigo_empleado','nombre_tipo_documento','doc_id', 'email'])
		});
		
		
		//FUNCIONES RENDER


		function render_id_empleado_frppa_solicitante(value, p, record){return String.format('{0}', record.data['solicitante']);}
		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

		

		function render_id_tipo_adq(value, p, record){if(record.get('tiene_presupuesto')=='0'){return '<b>'+record.data['desc_tipo_adq']+'</b>' } else{return String.format('{0}', record.data['desc_tipo_adq']);}}
		var tpl_id_tipo_adq=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{tipo_adq}</FONT>','</div>');


		function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden']);}
		var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');

		function render_id_gestion_paradq(value, p, record){return String.format('{0}', record.data['gestion'])}
		var tpl_gestionParadq = new Ext.Template('<div class="search-item">','<b>{gestion}</b>','</div>');
		function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_ep}</FONT><br>','{desc_depto}','</div>');


		function negrita(val,cell,record,row,colum,store){

			if(record.get('tiene_presupuesto')=='0'){
				return '<b>' + val + '</b>';
			}
			else
			{
				if(record.get('estado_vigente_solicitud')=='aprobado'){
				  return '<span style="color:green;font-size:8pt">' + val + '</span>';	
				}else{
					return val;					
				}
				
				
				
			}
		}

//9ago11
		function render_id_correspondencia(value, p, record){return String.format('{0}', record.data['correspondencia_asociada']);}
		var tpl_id_correspondencia=new Ext.Template('<div class="search-item">','<b>{desc_documento} -','{numero}</b>','<br><FONT COLOR="#B5A642">{desc_empleado}</FONT>','<br>{referencia}','</div>');
		
		
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

		
		function render_id_tipo_categoria_adq(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_tipo_categoria_adq']+ '</span>';}else {
				if(record.get('estado_vigente_solicitud')=='aprobado'){
				  return '<span style="color:green;font-size:8pt">' + record.data['desc_tipo_categoria_adq'] + '</span>';	
				}else{
					return record.data['desc_tipo_categoria_adq'];}
				}}
		var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria_adq}</i></b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');

		
		function render_id_empleado_aprobador(value, p, record){if(record.get('tiene_presupuesto')=='0'){return '<b>'+record.data['solicitante']+'</b>' } else{
				if(record.get('estado_vigente_solicitud')=='aprobado'){
				  return '<span style="color:green;font-size:8pt">' + record.data['encargado_aprobacion'] + '</span>';	
				}else{
			  	  return String.format('{0}', record.data['encargado_aprobacion']);
				}
			}}
		var tpl_id_empleado_aprobador=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','<br><FONT COLOR="#B5A642">{doc_id}</FONT>','</div>');


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
			save_as:'id_solicitud_compra',
			id_grupo:2
		};

		
		Atributos[1]={//37
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
				width_grid:75,
				align:'right',

				width:'40%',
				disabled:false,
				grid_indice:1,
				renderer:negrita
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'SOLADQ.periodo#SOLADQ.num_solicitud',
			save_as:'numeracion_periodo',
			id_grupo:0
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
				grid_visible:false,
				grid_editable:false,
				width_grid:72,
				width:'80%',
				disabled:true,
				grid_indice:3
			},
			tipo:'TextField',
			form:true,
			defecto:empleado.nombre_usuario,
			filtro_0:false,
			save_as:'solicitante',
			id_grupo:0
		};

		filterCols_centro=new Array();
		filterValues_centro=new Array();
		filterCols_centro[0]='EMPLEA.id_empleado';
		filterValues_centro[0]=empleado.id_empleado;

		Atributos[3]={//22
			validacion:{
				name:'id_tipo_adq',
				fieldLabel:'Tipo de Adquisición',
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
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:5
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'tipo.nombre',
			save_as:'id_tipo_adq',
			id_grupo:1
		};

		// txt localidad
		Atributos[4]={
			validacion:{
				name:'localidad',
				fieldLabel:'Localidad',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'80%',
				disabled:true,
				grid_indice:5
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			defecto:empleado.lugar,
			filterColValue:'SOLADQ.localidad',
			save_as:'localidad',
			id_grupo:0
		};

		// txt id_moneda
		Atributos[5]={
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
				disabled:false,
				grid_indice:4/**/
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda',
			id_grupo:3
		};


		Atributos[6]={
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
				width_grid:180,
				width:'80%',
				disabled:true,
				grid_indice:3,
				renderer:negrita
			},
			tipo:'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'UNIORG.nombre_unidad',
			save_as:'desc_unidad_organizacional',
			id_grupo:0
		};


		
		
		Atributos[7]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.id_presupuesto#CATPRO.cod_categoria_prog',
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
			onSelect:function(record){
				
				getComponente('localidad').setValue(record.data.nombre_regional);
				getComponente('id_presupuesto').setValue(record.data.id_presupuesto);
				getComponente('id_unidad_organizacional').setValue(record.data.id_unidad_organizacional);
				
				
				
				getComponente('id_depto').setValue('');
				
				getComponente('id_depto').enable();
					   Ext.Ajax.request({
    						url:direccion+"../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php?id_ep="+record.data.id_fina_regi_prog_proy_acti+"&subsistema=compro",
    						method:'GET',
    						success:cargar_depto_compra,
    						failure:Cm_conexionFailure,
    						timeout:100000000//TIEMPO DE ESPERA PARA DAcargar_depR FALLO
					   });
				
				ds_depto.baseParams={id_ep:record.data.id_fina_regi_prog_proy_acti,subsistema:'compro'};
				getComponente('id_tipo_adq').enable();
				
				getComponente('id_presupuesto').collapse()
			},
			
			
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:250,
			disabled:true,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0		
	};
		

		// txt id_empleado_frppa_pre_aprobacion
		/*Atributos[8]={
			validacion:{
				name:'encargado_pre_aprobacion',
				fieldLabel:'Encargado Pre Aprobacion',
				allowBlank:true,
				maxLength:120,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:160,
				width:'80%',
				disabled:true,
				grid_indice:8
			},
			tipo:'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PERSON3.nombre#PERSON3.apellido_paterno#PERSON3.apellido_materno',
			save_as:'txt_id_empleado_frppa_pre_aprobacion',
			id_grupo:2
		};



		//txt id_empleado_frppa_aprobacion
		Atributos[9]={
			validacion:{
				name:'encargado_aprobacion',
				fieldLabel:'Encargado Aprobación',
				allowBlank:true,
				maxLength:160,
				minLength:0,
				desc: 'encargado_aprobacion', //indica la columna del store principal ds del que proviane la descripcion
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:160,
				width:'80%',
				disabled:true,
				grid_indice:9
			},
			tipo:'TextField',
			form: false,
			filtro_0:false,
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
				grid_visible:false,
				grid_editable:false,
				width_grid:160,
				width:'80%',
				disabled:true,
				grid_indice:10
			},
			tipo:'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PERSON5.nombre#PERSON5.apellido_paterno#PERSON5.apellido_materno',
			save_as:'txt_id_empleado_frppa_gfa',
			id_grupo:2
		};
*/

		// txt precio_total
		Atributos[8]={
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
				disabled:false,
				grid_indice:11
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.precio_total',
			save_as:'precio_total',
			id_grupo:2
		};
		// txt observaciones
		Atributos[9]={//23
			validacion:{
				name:'observaciones',
				fieldLabel:'Justificación/ Observaciones del Pedido',
				allowBlank:false,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:170,
				width:'100%',
				disabled:false,
				grid_indice:5
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.observaciones',
			save_as:'observaciones',
			id_grupo:3
		};


		Atributos[10]= {
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
				grid_indice:11,
				width_grid:100 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:false,
			filterColValue:'OT.desc_orden',
			defecto: '',
			save_as:'id_orden_trabajo',
			id_grupo:3
		};


		// txt fecha_reg
		Atributos[11]= {
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
				grid_indice:12,
				disabled:true,
				width:120

			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLADQ.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg',
			id_grupo:1
		};


		// txt hora_reg
		Atributos[12]={
			validacion:{
				name:'hora_reg',
				fieldLabel:'Hora',
				allowBlank:true,
				maxLength:8,
				minLength:0,
				selectOnFocus:true,
				vtype:'time',
				grid_visible:true,
				grid_editable:false,
				width_grid:72,
				width:120,
				grid_indice:13,
				disabled:true

			},
			tipo:'TextField',
			form:true,
			filtro_0:true,
			filterColValue:'SOLADQ.hora_reg',
			save_as:'hora_reg',
			id_grupo:3
		};

		// txt num_solicitud
		/*Atributos[16]={
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
				disabled:false,
				grid_indice:16
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLADQ.num_solicitud#SOLADQ.periodo',
			save_as:'txt_num_solicitud',
			id_grupo:2
		};*/


		// txt id_fina_regi_prog_proy_acti
		/*Atributos[17]={
			validacion:{
				pregarga:false,
				precargaAct:"../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEPempleado.php",
				fieldLabel:'Estructura Programatica',
				allowBlank:false,
				emptyText:'Estructura Programática',
				actFin:'../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php',
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
				grid_visible:false,
				grid_editable:false,
				grid_indice:17,
				disabled:false,
				width:250
			},
			tipo:'epField',
			save_as:'txt_id_frppa',
			id_grupo:0
		};*/



		// txt estado_vigente_solicitud
		Atributos[13]={
			validacion:{
				name:'estado_vigente_solicitud',
				fieldLabel:'Estado Sol.',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'40%',
				disabled:false,
				grid_indice:4
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLADQ.estado_vigente_solicitud',
			save_as:'estado_vigente_solicitud',
			id_grupo:2
		};

		// txt estado_reg
		Atributos[14]={
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
				disabled:false,
				grid_indice:19
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			filterColValue:'SOLADQ.estado_reg',
			save_as:'estado_reg',
			id_grupo:2
		};

		// txt modalidad
		Atributos[15]={
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
				grid_visible:false,
				grid_indice:20,
				width_grid:75,
				grid_editable:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto:'Nacional',
			filterColValue:'SOLADQ.modalidad',
			save_as:'modalidad',
			id_grupo:2
			//id_grupo:3
		};

		// txt tipo_adjudicacion



		Atributos[16]={
			validacion:{
				name:'tipo_adjudicacion',
				fieldLabel:'Adjudicación',
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
				grid_indice:7,
				width_grid:75,
				grid_editable:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			defecto:'total',
			filterColValue:'SOLADQ.tipo_adjudicacion',
			save_as:'tipo_adjudicacion',
			id_grupo:1
		};


		// txt fecha_venc
		/*Atributos[22]= {
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
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'SOLADQ.fecha_venc',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_venc',
			id_grupo:2
		};*/


		// txt id_solicitud_compra_ant
		/*Atributos[23]={//20
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
				disabled:true,
				grid_indice:23
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLADQ.id_solicitud_compra_ant',
			save_as:'txt_id_solicitud_compra_ant',
			id_grupo:2
		};
*/


		/*Atributos[24]={//21
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
		};*/


		// txt periodo
		Atributos[17]={//24
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
				disabled:false,
				grid_indice:25
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLADQ.periodo',
			save_as:'periodo',
			id_grupo:1
		};

		// txt gestion
		Atributos[18]={
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
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion_paradq,
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:'80%',
				disabled:false

			},
			tipo:'ComboBox',
			form: true,
			//defecto:'Bolivianos',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'SOLADQ.gestion',
			save_as:'id_parametro_adquisicion',
			id_grupo:1
		};



		// txt id_rpa
	/*	Atributos[27]={//27
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
				grid_visible:false,
				grid_editable:false,
				width_grid:120,
				width:'80%',
				grid_indice:27
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			defecto:'',
			filterColValue:'PERSON5.nombre#PERSON5.apellido_paterno#PERSON5.apellido_materno',
			save_as:'txt_id_rpa',
			id_grupo:4
		};*/




		Atributos[19]={//28
			validacion:{
				name:'tipo_adq',
				fieldLabel:'Tipo',
				grid_visible:false,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:28,
				width_grid:150
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'tipo',
			id_grupo:2
		};


		Atributos[20]={//32
			validacion:{
				name:'observaciones_estado',
				fieldLabel:'Observaciones por Estado',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:170,
				width:'100%',
				disabled:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			filterColValue:'ESTPRO.observaciones',
			save_as:'observaciones_estado',
			id_grupo:3
		};


/*
		Atributos[30]={//33
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
		};*/

		Atributos[21]={//34
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
		Atributos[22]={//35
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
			save_as:'id_usuario_transcriptor',
			id_grupo:2
		};

		Atributos[23]={//36
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





	/*	Atributos[34]={//38
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
		};*/


			//txt id_empleado_frppa_aprobacion
		Atributos[24]={
			validacion:{
				name:'id_empleado_frppa_aprobacion',
				fieldLabel:'Aprobador',
				allowBlank:false,
				emptyText:'Aprobador...',
				desc: 'encargado_aprobacion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_empleado_aprobador,
				valueField: 'id_empleado',
				displayField: 'desc_persona',
				queryParam: 'filterValue_0',
				filterCol:'EMPLEA.id_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				typeAhead:false,
				tpl:tpl_id_empleado_aprobador,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_empleado_aprobador,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:2
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'emp_solicitante.nombre#emp_solicitante.apellido_paterno#emp_solicitante.apellido_materno',
			save_as:'id_empleado_aprobacion',
			id_grupo:4
		};

		/*Atributos[36]={//40
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
		};*/

		Atributos[25]={//41
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

		Atributos[26]={//42
			validacion:{
				labelSeparator:'',
				name: 'id_unidad_organizacional',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_unidad_organizacional',
			id_grupo:2
		};

		Atributos[27]={
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

		/*Atributos[40]={//23
			validacion:{
				name:'observaciones_estado',
				fieldLabel:'Observaciones del Estado',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				grid_indice:13
			},
			tipo: 'Field',
			form: false,
			filtro_0:false

		};*/

		Atributos[28]={
			validacion:{
				labelSeparator:'',
				name: 'gestion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'gestion',
			id_grupo:2
		};


		Atributos[29]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Responsable de Compra',
				allowBlank:false,
				emptyText:'Responsable de Compra...',
				desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'desc_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
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
				renderer:render_id_depto,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:5
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'DEP.nombre',
			save_as:'id_depto',
			id_grupo:0
		};


		Atributos[30]={//44
			validacion:{
				name:'proveedores_propuestos',
				fieldLabel:'Proveedores Propuestos',
				allowBlank:true,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:120,
				width:'100%',
				disabled:false,
				grid_indice:8

			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'SOLADQ.proveedores_propuestos',
			save_as:'proveedores_propuestos',
			id_grupo:3
		};

		Atributos[31]={//45
			validacion:{
				name:'comite_calificacion',
				fieldLabel:'Comité de Calificación',
				allowBlank:true,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:9

			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'SOLADQ.comite_calificacion',
			save_as:'comite_calificacion',
			id_grupo:4
		};


		Atributos[32]={//46
			validacion:{
				name:'comite_recepcion',
				fieldLabel:'Comité de Recepción',
				allowBlank:true,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:10

			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'SOLADQ.comite_recepcion',
			save_as:'comite_recepcion',
			id_grupo:3
		};
		
		Atributos[33]={
			validacion:{
				name:'avance',
				fieldLabel:'Fondo en Avance',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['si','si'],['no','no']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				width:250,
				width_grid:75,
				grid_editable:false
			},
			tipo:'ComboBox',
			defecto:'no',
			form:true
			
			
		};

	Atributos[34]={
			validacion:{
				name:'id_correspondencia',
				fieldLabel:'Correspondencia Asociada',
				allowBlank:true,
				store:ds_correspondencia,	
				maestroValField:'correspondencia_asociada',
				valueField: 'id_correspondencia',
				//displayField: 'desc_persona',				
				queryParam: 'filterValue_0',
				filterCol:'CORRE.numero#EMPLE.nombre_completo#CORRE.referencia#DOCUME.documento',
				typeAhead:false,
				tpl:tpl_id_correspondencia,				
				defValor:function(val,record){					
					var text = record['numero']+' -> '+record['referencia'];
					return text;				
				},							
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				grid_visible:true,
				grid_editable:false,
				renderer:render_id_correspondencia,
				queryParam:'filterValue_0',
				minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
			    width:'85%',
			    width_grid:150
			},
			tipo:'ComboMultiple2',
			form: true,
			filtro_0:false,
			filtro_1:false
			,id_grupo:4
			
	};
	
	Atributos[35]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Categoria',
			allowBlank:false,			
			emptyText:'Categoria...',
			desc: 'desc_tipo_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_categoria_adq,
			valueField: 'id_tipo_categoria_adq',
			displayField: 'desc_categoria_adq',
			queryParam: 'filterValue_0',
			filterCol:'CATADQ.nombre',
			typeAhead:true,
			tpl:tpl_id_tipo_categoria_adq,
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
			renderer:render_id_tipo_categoria_adq,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'80%',
			disabled:false,
			grid_indice:7/**/
		},
		tipo:'ComboBox',
		form: true,
		//defecto:'Bolivianos',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CATADQ.nombre',
		save_as:'id_tipo_categoria_adq',
		id_grupo:4
	};
	
	Atributos[36]={
			validacion:{
				labelSeparator:'',
				name: 'id_empleado',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:empleado.id_empleado,
			save_as:'id_emp',
			id_grupo:2
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Solicitud de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/solicitud_compra_ser/sol_compra_serv_det.php'};
		var layout_solser=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_solser.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_solser,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_mostrarComponente= this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;


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
				tituloGrupo:'Doc. Respaldo',
				columna:1,
				id_grupo:4
			}
			],
			width:'75%',minWidth:350,minHeight:400,closable:true,titulo:'Solicitud de Compra'}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				ds_tipo_adq.baseParams={tipo_adq:'servicio'};
				//para iniciar eventos en el formulario
				txt_num_solicitud=getComponente('num_solicitud');//
				txt_fecha=getComponente('fecha_reg');
				txt_hora=getComponente('hora_reg');
				txt_periodo=getComponente('periodo');//
				txt_gestion=getComponente('id_parametro_adquisicion');//
				txt_localidad=getComponente('localidad');
				//cmb_epS=getComponente('id_ep');
				//cmbUO=getComponente('id_unidad_organizacional');
				var cmbTranscriptor=getComponente('id_usuario_transcriptor');//
				var cmbSolicitante=getComponente('id_empleado_frppa_solicitante');
				var cmbEPA=getComponente('id_empleado_frppa_pre_aprobacion');//
				var cmbEA=getComponente('id_empleado_frppa_aprobacion');//
				var cmbGFA=getComponente('id_empleado_frppa_gfa');//
				//var cmbRPA=getComponente('id_rpa');//
				cmbMoneda=getComponente('id_moneda');
				var txt_id_tipo_adquisicion=getComponente('id_tipo_adq');
				var txt_fecha_venc=getComponente('fecha_venc');
				txt_id_moneda_base=getComponente('id_moneda_base');
				var cmb_categoria=getComponente('id_tipo_categoria_adq');



				/*cmb_epS.ep.setBaseParams({"id_empleado":empleado.id_empleado});
				cmb_epS.ep.modificado=true;
				cmb_epS.modificado=true;*/

				/*var onEPSelect=function(e){
					ds_depto.modificado=true;
					//getComponente('desc_unidad_organizacional').setValue('');
					txt_id_tipo_adquisicion.enable();
					var ep=cmb_epS.getValue();
					//getComponente('localidad').setValue(ep['nombre_regional']);

					data_ep='id_fin='+ep['id_financiador']+'&id_reg='+ep['id_regional']+'&id_prog='+ep['id_programa']+'&id_proy='+ep['id_proyecto']+'&id_act='+ep['id_actividad'];
					ds_depto.baseParams={id_ep:ep['id_fina_regi_prog_proy_acti'],subsistema:'compro'};
					getComponente('id_depto').enable();
					getComponente('id_depto').setValue('');
					ds_depto.modificado=true;
					ds_depto.baseParams={id_ep:ep['id_fina_regi_prog_proy_acti'],subsistema:'compro'};

					if(ep['id_fina_regi_prog_proy_acti']>0){onLocalidad();}
					
					Ext.Ajax.request({
						url:direccion+"../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php?id_ep="+ep['id_fina_regi_prog_proy_acti']+"&subsistema=compro",

						method:'GET',
						success:cargar_depto_compra,
						failure:Cm_conexionFailure,
						timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
					});

					function cargar_depto_compra(resp){
						Ext.MessageBox.hide();
						if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
							var root = resp.responseXML.documentElement;
							if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){

								getComponente('id_depto').setValue(root.getElementsByTagName('id_depto')[0].firstChild.nodeValue);
								getComponente('id_depto').setRawValue(root.getElementsByTagName('desc_depto')[0].firstChild.nodeValue);
								getComponente('id_depto').modificado=true;
							}else{
								getComponente('id_depto').reset();
							}
						}
					}


				};


				cmb_epS.on('change',onEPSelect);*/



				var onMonedaSelect=function(e){
					get_tipo_cambio(e.value);
				}

				getComponente('id_moneda').on('select',onMonedaSelect);
				getComponente('id_moneda').on('change',onMonedaSelect);
				txt_fecha.on('change',onMonedaSelect);

				/*var onRPA=function(e){

					if(cmbRPA.getValue()>0){
						getDialog().buttons[0].enable();
					}
				}
				cmbRPA.on('valid',onRPA);*/
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_solser.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_solser.getIdContentHijo()).pagina.bloquearMenu()
					}
				})

				var onGestion=function(c,r,i){
					if(parseFloat(r.data.gestion)>0){
						get_fecha_adq(r.data.gestion);
					}
				}
				txt_gestion.on('select',onGestion);
				
				
				
				var onCategoria=function(c,r,i){
					if(r.data.doc_respaldo=='si'){
						CM_mostrarComponente(getComponente('comite_calificacion'));
						getComponente('comite_calificacion').allowBlank=false;
						getComponente('id_correspondencia').allowBlank=false;
					}else{
						CM_ocultarComponente(getComponente('comite_calificacion'));
						getComponente('id_correspondencia').allowBlank=true;
						getComponente('id_correspondencia').reset();
						getComponente('comite_calificacion').allowBlank=true;
						getComponente('comite_calificacion').reset();
					}
				}
				
				cmb_categoria.on ('select',onCategoria);
				

			}

			
				function cargar_depto_compra(resp){
						Ext.MessageBox.hide();
						if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
							var root = resp.responseXML.documentElement;
							if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){

								getComponente('id_depto').setValue(root.getElementsByTagName('id_depto')[0].firstChild.nodeValue);
								getComponente('id_depto').setRawValue(root.getElementsByTagName('desc_depto')[0].firstChild.nodeValue);
								getComponente('id_depto').modificado=true;
							}else{
								getComponente('id_depto').reset();
							}
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
						
						Ext.Ajax.request({
								url:direccion+"../../../control/solicitud_compra/ActionObtenerTotalSolicitudCompra.php?id_solicitud_compra="+data,
								method:'GET',
								success:cant_total,
								failure:Cm_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							})
					
					}

				}

				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}


			function cant_total(resp){
             	
             	var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				var data=SelectionsRecord.data.id_solicitud_compra;
							var root = resp.responseXML.documentElement;
							    CM_mostrarGrupo('Origen Solicitud');
								CM_mostrarGrupo('Doc. Respaldo');
								CM_ocultarGrupo('Oculto');
								CM_ocultarGrupo('Solicitud');
						
								CM_ocultarGrupo('Detalle Solicitud');
								
							
							if((root.getElementsByTagName('doc_respaldo')[0].firstChild.nodeValue)!='si'){
								
								 
								 getComponente('id_correspondencia').setValue('');
								  getComponente('id_empleado_frppa_aprobacion').allowBlank=false;
								 getComponente('id_correspondencia').reset();
								 getComponente('id_correspondencia').allowBlank=true;
								 getComponente('comite_calificacion').setValue('');
								 getComponente('comite_calificacion').reset();
								 getComponente('comite_calificacion').allowBlank=true;
								// CM_ocultarComponente(getComponente('id_correspondencia'));
								 CM_ocultarComponente(getComponente('comite_calificacion'));
							}else{
								
								 if(root.getElementsByTagName('correspondencia')[0].firstChild.nodeValue=='si'){
								 	getComponente('id_correspondencia').allowBlank=false;
								 }else{
								 	getComponente('id_correspondencia').allowBlank=true;
								 }
								 
								 getComponente('comite_calificacion').allowBlank=false;
								 CM_mostrarComponente(getComponente('id_correspondencia'));
								 CM_mostrarComponente(getComponente('comite_calificacion'));
							}
								
							if(root.getElementsByTagName('cambiar_aprobador')[0].firstChild.nodeValue=='si'){
								CM_mostrarComponente(getComponente('id_empleado_frppa_aprobacion'));
								getComponente('id_empleado_frppa_aprobacion').setValue('');
								getComponente('id_empleado_frppa_aprobacion').allowBlank=false;
								ds_empleado_aprobador.modificado=true;
								ds_empleado_aprobador.baseParams={
									autorizacion:'si',
									tipo:'solicitud_compra',
									id_presupuesto:SelectionsRecord.data.id_presupuesto,
									id_empleado:SelectionsRecord.data.id_empleado,
									monto_total:root.getElementsByTagName('monto_total')[0].firstChild.nodeValue
								}
								ds_empleado_aprobador.modificado=true;
								getComponente('id_empleado_frppa_aprobacion').modificado=true;
								
							}else{
								CM_ocultarComponente(getComponente('id_empleado_frppa_aprobacion'));
							}
								
								getComponente('id_presupuesto').disable();
								getComponente('id_depto').disable();
								getComponente('avance').disable();
								getComponente('es_modificacion').setValue('');
								getComponente('id_tipo_categoria_adq').setValue(root.getElementsByTagName('id_tipo_categoria')[0].firstChild.nodeValue);
								getComponente('id_tipo_categoria_adq').setRawValue(root.getElementsByTagName('nombre_categoria')[0].firstChild.nodeValue);
								CM_btnEdit();
								
							 
							
			}



			function get_fecha_adq(gestion)
			{
				Ext.Ajax.request({
					url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+empleado.id_empresa+"&m_gestion="+gestion,
					method:'GET',
					success:cargar_fecha_adq,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_fecha_adq(resp){
				Ext.MessageBox.hide();
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;
					if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
						txt_fecha.setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
						txt_fecha.minValue=txt_fecha.getValue();
						txt_fecha.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
						txt_fecha.disable();
						if(root.getElementsByTagName('estado')[0].firstChild.nodeValue=='congelado'){
							txt_hora.setValue('08:30:00');
						}//else{
							//get_hora_bd();
						//}
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

//
//			function get_hora_bd(){
//				Ext.Ajax.request({
//					url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
//					method:'GET',
//					success:cargar_hora_bd,
//					failure:Cm_conexionFailure,
//					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
//				});
//			}
//
//			function cargar_hora_bd(resp){
//				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
//					var root = resp.responseXML.documentElement;
//					txt_hora.setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue)
//				}
//			}
//
			function get_tipo_cambio(moneda){
				Ext.Ajax.request({
					url:direccion+"../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambio.php?fecha_solicitud="+txt_fecha.getValue().dateFormat('m-d-Y')+'&id_moneda='+moneda,
					method:'GET',
					success:cargar_tipo_cambio,
					failure:Cm_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			}

			function cargar_tipo_cambio(resp){
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
					var root = resp.responseXML.documentElement;

					if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue<1 &&(getComponente('id_moneda').getValue()!=getComponente('id_moneda_base').getValue())){
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
				CM_ocultarGrupo('Doc. Respaldo');
				CM_mostrarGrupo('Origen Solicitud');
				CM_mostrarGrupo('Solicitud');
				CM_mostrarGrupo('Detalle Solicitud');
				//getComponente('id_ep').setValue('');
                
				//cmb_epS.ep.cargaEPprimaria({"id_empleado":empleado.id_empleado},carga_localidad);//24/04/2009
                //cmb_epS.ep.cargaEPprimaria({"id_empleado":empleado.id_empleado});
				//getComponente('id_rpa').allowBlank=true;
				getComponente('fecha_reg').disable();
				getComponente('id_parametro_adquisicion').enable();
				
				
				getComponente('solicitante').setRawValue(empleado.nombre_usuario);
				getComponente('id_empleado').setValue(empleado.id_empleado);
				getComponente('id_unidad_organizacional').setValue('');
				
				Ext.Ajax.request({
								url:direccion+"../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarCentro.php?id_empleado="+empleado.id_empleado,
		
								method:'GET',
								success:cargar_centro,
								failure:Cm_conexionFailure,
								timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
							});
				
				getComponente('id_empleado_frppa_aprobacion').allowBlank=true;
				getComponente('id_tipo_categoria_adq').allowBlank=true;
				getComponente('id_correspondencia').allowBlank=true;
				getComponente('comite_calificacion').allowBlank=true;
				
				CM_btnNew();
			}



			this.EnableSelect=function(sm,row,rec){
				//cm_EnableSelect(sm,row,rec);
			
				
				
				
					_CP.getPagina(layout_solser.getIdContentHijo()).pagina.reload(rec.data);
					_CP.getPagina(layout_solser.getIdContentHijo()).pagina.desbloquearMenu();
			
					enable(sm,row,rec);
				
			}


			/*function carga_localidad(datos){

				if(datos['id_financiador']==undefined ||datos['id_financiador']==null||datos['id_financiador']==''){

					getComponente('id_ep').setValue('');

				}else{
					//getComponente('localidad').setValue(datos['nombre_regional']);
					
					onLocalidad();
				}
			}*/

			/*var onLocalidad=function(e){
				//llamar a funcion para llenar el centro
				var ep=getComponente('id_ep').getValue();
				getComponente('id_depto').enable();
				ds_depto.baseParams={id_ep:ep['id_fina_regi_prog_proy_acti'],subsistema:'compro'};

if(ep['id_fina_regi_prog_proy_acti']>0){
				Ext.Ajax.request({
					url:direccion+"../../../../sis_parametros/control/depto_ep/ActionListarDepartamentoEP.php?id_ep="+ep['id_fina_regi_prog_proy_acti']+'&subsistema=compro',

					method:'GET',
					success:cargar_depto_compra_serv,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});

				var cargar_depto_compra_serv=function(resp){
					Ext.MessageBox.hide();
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){

							getComponente('id_depto').setValue(root.getElementsByTagName('id_depto')[0].firstChild.nodeValue);
							getComponente('id_depto').setRawValue(root.getElementsByTagName('desc_depto')[0].firstChild.nodeValue);

						}else{
							getComponente('id_depto').reset();
						}
					}
				}

	if(parseFloat(ep['id_fina_regi_prog_proy_acti'])>0){
				Ext.MessageBox.show({
					title: 'Cargando Centro...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Centro...</div>",
					width:150,
					height:200,
					closable:false
				});
            
				Ext.Ajax.request({
					url:direccion+"../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarCentro.php?id_empleado="+empleado.id_empleado+"&id_ep="+ep['id_fina_regi_prog_proy_acti'],
					method:'GET',
					success:cargar_centro,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
                });
        
	}  
            
}
            
		}*/


			function cargar_centro(resp){
					Ext.MessageBox.hide();
					if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
                            getComponente('id_unidad_organizacional').setValue(root.getElementsByTagName('id_uo_ppto')[0].firstChild.nodeValue);
							getComponente('desc_unidad_organizacional').setValue(root.getElementsByTagName('centro')[0].firstChild.nodeValue);
							
							getComponente('id_uo_gerencia').setValue(root.getElementsByTagName('id_unidad_organizacional_aprueba')[0].firstChild.nodeValue);
							
							
							getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
							getComponente('gestion').setValue(getComponente('fecha_reg').getValue().getFullYear());
							
							//getComponente('id_tipo_adq').setValue(root.getElementsByTagName('id_tipo_adq')[0].firstChild.nodeValue);
							
							
							getComponente('id_presupuesto').reset();
							getComponente('id_presupuesto').enable();
							getComponente('id_depto').reset();
							getComponente('id_depto').disable();
						
							
							ds_presupuesto.modificado=true;
							ds_presupuesto.baseParams={
								m_nombre_vista:'rendicion_viaticos1',
								m_id_uo:getComponente('id_unidad_organizacional').getValue(),
								m_id_solicitante:empleado.id_empleado,
								id_gestion:root.getElementsByTagName('id_gestion')[0].firstChild.nodeValue
							}
							getComponente('id_presupuesto').modificado=true;
							
							
							if((root.getElementsByTagName('total_adq')[0].firstChild.nodeValue)>0){
						
							getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
							getComponente('fecha_reg').minValue=getComponente('fecha_reg').getValue();
							getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
							getComponente('fecha_reg').disable();
							getComponente('hora_reg').setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
							getComponente('id_moneda').setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
							getComponente('id_moneda').setRawValue(root.getElementsByTagName('nombre_moneda')[0].firstChild.nodeValue)
							getComponente('id_parametro_adquisicion').setValue(root.getElementsByTagName('id_parametro_adq')[0].firstChild.nodeValue);
							getComponente('id_parametro_adquisicion').setRawValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
							getComponente('gestion').setValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
							getComponente('id_moneda_base').setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);

						}else{
							alert("No existe una gestion activa para Adquisiciones para "+getComponente('gestion').getValue());
						}
							
							
						}else{
							alert("El solicitante no pertenece a ninguna Unidad Organizacional, asociada a la EP, es necesaria dicha asignacion para continuar con su solicitud");
							
							getComponente('id_unidad_organizacional').setValue('');
							getComponente('id_uo_gerencia').setValue('');
							getComponente('id_depto').setValue('');
							
							//getComponente('localidad').reset();
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
						getComponente('fecha_reg').disable();
						getComponente('id_parametro_adquisicion').disable();
						getComponente('id_depto').enable();
						CM_ocultarGrupo('Oculto');
						CM_ocultarGrupo('Estructura Programatica');
						CM_ocultarGrupo('Doc. Respaldo');
						CM_mostrarGrupo('Origen Solicitud');
						CM_mostrarGrupo('Solicitud');
						CM_mostrarGrupo('Detalle Solicitud');
						
						getComponente('id_tipo_adq').enable();
						
						getComponente('es_modificacion').setValue('modificacion');
						
						getComponente('id_empleado_frppa_aprobacion').allowBlank=true;
						getComponente('id_correspondencia').allowBlank=true;
						getComponente('comite_calificacion').allowBlank=true;
						getComponente('id_tipo_categoria_adq').allowBlank=true;
						getComponente('id_presupuesto').enable(); //alert('llega a habilitar...');
						ds_presupuesto.baseParams={
								m_nombre_vista:'rendicion_viaticos1',
								m_id_uo:SelectionsRecord.data.id_unidad_organizacional,
								m_id_solicitante:SelectionsRecord.data.id_empleado_frppa_solicitante,
								id_gestion:SelectionsRecord.data.id_gestion
							}
						ds_presupuesto.modificado=true;
						
						ds_depto.baseParams={id_ep:SelectionsRecord.data.id_frppa,subsistema:'compro'};
						ds_depto.modificado=true;
						
						CM_btnEdit();
					}else{
						Ext.MessageBox.alert('Estado','Solo solicitudes en estado borrador');
					}
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}

			function btn_verificar(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
					if(SelectionsRecord.data.estado_vigente_solicitud=='aprobado'){
						data=data+'&tipo_repo=1';
					}
					window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data)

				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}



			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_solser.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Vista Previa Solicitud',btn_verificar,true,'ver_presol','Verificar');
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar el Pedido',btn_fin_ped,true,'fin_ped','');

			var CM_getBoton=this.getBoton;
			
			
			function  enable(sel,row,selected){
				var record=selected.data;
				
				if(selected&&record!=-1){
					if (record.estado_vigente_solicitud=='borrador'){
						
						
						CM_getBoton('fin_ped-'+idContenedor).enable();
						CM_getBoton('eliminar-'+idContenedor).enable();
						CM_getBoton('editar-'+idContenedor).enable();
						CM_getBoton('guardar-'+idContenedor).enable();
						_CP.getPagina(layout_solser.getIdContentHijo()).pagina.desbloquearMenu()
					}else{
						
						
						CM_getBoton('fin_ped-'+idContenedor).disable();
						CM_getBoton('eliminar-'+idContenedor).disable();
						CM_getBoton('editar-'+idContenedor).disable();
						CM_getBoton('guardar-'+idContenedor).disable();
						
						_CP.getPagina(layout_solser.getIdContentHijo()).pagina.bloquearMenu()
						
					}
									
				}
				cm_EnableSelect(sel,row,selected);
			}
			this.iniciaFormulario();
			iniciarEventosFormularios();
			
			ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				tipo:'personal',
				id_empleado:empleado.id_empleado,
				id_empresa:empleado.id_empresa,
				tipo_adq:'Servicio'
			}
		});

			layout_solser.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}