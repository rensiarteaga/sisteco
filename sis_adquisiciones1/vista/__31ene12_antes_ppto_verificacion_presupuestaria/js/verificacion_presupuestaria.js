function pagina_verificacion_presupuestaria(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var data='';
	var id_solicitud_compra;
	//prueba guardado
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/seguimiento_solicitud/ActionListarSeguimientoSolicitud.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_solicitud_compra',totalRecords:'TotalCount'
		},[		
				'id_solicitud_compra',
		'observaciones',
		'localidad',
		'siguiente_estado',
		'tipo_adjudicacion',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_empleado_frppa_solicitante',
		'desc_empleado_tpm_frppa',
		'id_moneda',
		'desc_moneda',
		'id_rpa',
		'desc_rpa',
		'id_cuenta',
		'desc_cuenta',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'reformulacion',
		{name: 'fecha_estado',type:'date',dateFormat:'Y-m-d'},
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','tipo_adq','num_solicitud','estado','numeracion_periodo','gestion','tiene_presupuesto'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			vista:'verificacion'
		}
	});
	//DATA STORE COMBOS

    var ds_tipo_categoria_adq = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php?tipo=sol'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq','fecha_reg','id_categoria_adq','estado_categoria','tipo','nombre','desc_categoria_adq'])
	});
//
//    var ds_empleado_tpm_frppa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoTpmFrppa.php'}),
//			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_frppa',totalRecords: 'TotalCount'},['id_empleado_frppa','id_empleado','fecha_registro','hora_ingreso','id_fina_regi_prog_proy_acti'])
//	});
//
//    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
//			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
//	});
//
//    var ds_rpa = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rpa/ActionListarRpa.php'}),
//			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_rpa',totalRecords: 'TotalCount'},['id_rpa','fecha_reg','estado','id_empleado_frppa','id_categoria_adq'])
//	});
//
//    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
//			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','id_cuenta_padre'])
//	});
//
//    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
//			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
//	});
//
//	//FUNCIONES RENDER
//	
	function render_id_tipo_categoria_adq(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_categoria_adq']+ '</span>';}else {return record.data['desc_categoria_adq'];}}
		var tpl_id_tipo_categoria_adq=new Ext.Template('<div class="search-item">','<b><i>{desc_categoria_adq}</i></b>','<br><FONT COLOR="#B5A642">{tipo}</FONT>','</div>');
//
//		function render_id_empleado_frppa_solicitante(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_empleado_tpm_frppa']+ '</span>';}else {return record.data['desc_empleado_tpm_frppa'];}}
//		var tpl_id_empleado_frppa_solicitante=new Ext.Template('<div class="search-item">','<b><i>{id_empleado}</i></b>','<br><FONT COLOR="#B5A642">{id_fina_regi_prog_proy_acti}</FONT>','</div>');
//
//		function render_id_moneda(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_moneda']+ '</span>';}else {return record.data['desc_moneda'];}}
//		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');
//
//		function render_id_rpa(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_rpa']+ '</span>';}else {return record.data['desc_rpa'];}}
//		var tpl_id_rpa=new Ext.Template('<div class="search-item">','<b><i>{id_empleado_frppa}</i></b>','<br><FONT COLOR="#B5A642">{id_empleado_frppa}</FONT>','</div>');
//
//		function render_id_cuenta(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_cuenta']+ '</span>';}else {return record.data['desc_cuenta'];}}
//		var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<b><i>{nro_cuenta}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
//
//		function render_id_unidad_organizacional(val,cell,record,row,colum,store){if(record.get('reformulacion')=='1'){return '<span style="color:red;font-size:8pt">' + record.data['desc_unidad_organizacional']+ '</span>';}else {return record.data['desc_unidad_organizacional'];}}
//		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642">{centro}</FONT>','</div>');
//		
			
		
		function negrita(val,cell,record,row,colum,store){
			if(record.get('reformulacion')=='1'){
								
				if(colum=='3'){
					return '<span style="color:red;font-size:8pt">Reformulación Pendiente</span>';
				}
				else{
					return '<span style="color:red;font-size:8pt"><b>' + val + '</b></span>';
				}
			}
			else
			{
				return val;
			}
		}
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra
	//en la posiciï¿½n 0 siempre esta la llave primaria

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
		save_as:'id_solicitud_compra'
	};
	
	
	Atributos[1]={
		validacion:{
			name:'numeracion_periodo',
			fieldLabel:'Número Solicitud',
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
			grid_indice:2,
			renderer:negrita
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.num_solicitud#SEGSOL.periodo',
		save_as:'txt_num_solicitud',
		id_grupo:0
	};
	
	// txt id_empleado_frppa_solicitante
	
	
	Atributos[2]={
		validacion:{
			name:'desc_empleado_tpm_frppa',
			fieldLabel:'Solicitante',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:3	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP_6.apellido_paterno#EMPLEP_6.apellido_materno#EMPLEP_6.nombre',
		id_grupo:0
	};

     Atributos[3]={
		validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Centro',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:4
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		id_grupo:0
	};
	
//		Atributos[3]={
//			validacion:{
//			name:'id_unidad_organizacional',
//			fieldLabel:'Centro',
//			allowBlank:false,			
//			emptyText:'Centro...',
//			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
//			store:ds_unidad_organizacional,
//			valueField: 'id_unidad_organizacional',
//			displayField: 'nombre_unidad',
//			queryParam: 'filterValue_0',
//			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
//			typeAhead:true,
//			tpl:tpl_id_unidad_organizacional,
//			forceSelection:true,
//			mode:'remote',
//			queryDelay:250,
//			pageSize:100,
//			minListWidth:'80%',
//			grow:true,
//			resizable:true,
//			queryParam:'filterValue_0',
//			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
//			triggerAction:'all',
//			editable:true,
//			renderer:render_id_unidad_organizacional,
//			grid_visible:true,
//			grid_editable:false,
//			width_grid:120,
//			width:'80%',
//			disable:false,
//			grid_indice:3		
//		},
//		tipo:'ComboBox',
//		form: true,
//		filtro_0:true,
//		filterColValue:'UNIORG.nombre_unidad',
//		save_as:'id_unidad_organizacional'
//	};

	
	
	
Atributos[4]={
		validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:5
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:0
	};
	
	// txt localidad
	Atributos[5]={
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
			disable:false,
			grid_indice:6,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.localidad',
		save_as:'localidad',
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo Adquisicion',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7
		},
		tipo: 'TextArea',
		form:true,
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		id_grupo:0
	};
	
	
// txt id_rpa

Atributos[7]={
		validacion:{
			name:'desc_rpa',
			fieldLabel:'RPA',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:8
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEP_8.apellido_paterno#EMPLEP_8.apellido_materno#EMPLEP_8.nombre',
		id_grupo:0
	};
	// txt tipo_adjudicacion
	Atributos[8]={
		validacion:{
			name:'tipo_adjudicacion',
			fieldLabel:'Adjudicación',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'40%',
			disable:false,
			grid_indice:9,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.tipo_adjudicacion',
		save_as:'tipo_adjudicacion',
		id_grupo:0
	};
	
	
	
Atributos[9]={
		validacion:{
			name:'desc_tipo_categoria_adq',
			fieldLabel:'Tipo Categoria',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'45%',
			disable:false,
			grid_indice:10
			
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TIPCAT.nombre',
		id_grupo:0
	};
	
	Atributos[10]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:55,
			width:'100%',
			disable:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form:true,
		filtro_0:true,
		filterColValue:'SEGSOL.gestion',
		id_grupo:0
	};
	
	
// txt observaciones

	Atributos[11]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11,
			renderer:negrita		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'ESTPRO.observaciones',
		save_as:'observaciones',
		id_grupo:1
	};


	Atributos[12]={
		validacion:{
			name:'siguiente_estado',
			fieldLabel:'Siguiente Estado',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'40%',
			disable:false,
			grid_indice:12,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SEGSOL.siguiente_estado',
		save_as:'siguiente_estado',
		id_grupo:0
	};

// txt id_tipo_categoria_adq
	
	Atributos[13]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,		
			width:300,
			renderer:negrita
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:0
		};
		
		// txt num_solicitud



	
	// txt localidad
	Atributos[14]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'45%',
			disable:false,
			grid_indice:14,
			renderer:negrita		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.nombre',
		save_as:'estado',
		id_grupo:0
	};
	
	Atributos[15]= {
        validacion:{
			name:'fecha_estado',
			fieldLabel:'Fecha Inicio Estado',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:110,
			disabled:true,
			grid_indice:15
			
		},
		tipo:'DateField',
		form:true,
		filtro_0:true,
		dateFormat:'m-d-Y',
		filterColValue:'ESTPRO.fecha_ini',
		save_as:'fecha_estado',
		id_grupo:0
	};
	
	
	
	
	/*Atributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_tipo_categoria_adq'
	};*/
	
	Atributos[17]={
			validacion:{
			name:'id_tipo_categoria_adq',
			fieldLabel:'Categoria',
			allowBlank:false,			
			emptyText:'Categoria...',
			desc: 'desc_categoria_adq', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_categoria_adq,
			valueField: 'id_tipo_categoria_adq',
			displayField: 'desc_categoria_adq',
			queryParam: 'filterValue_0',
			filterCol:'TIPADQ.nombre',
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
		filterColValue:'MONEDA.nombre',
		save_as:'id_tipo_categoria_adq',
		id_grupo:2
	};

    Atributos[16]={ 
		validacion: {
			name:'permite_agrupar',
			fieldLabel: 'Agrupar',
			width: '8%',
			grid_visible:false, 
			grid_editable:false, 
			width_grid:40,
			renderer:formatBoolean 
		},
		tipo:'Checkbox',
		form:true,
		id_grupo:2
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	
	function formatBoolean(value){
        if(value=="true"){
        	return "si";
        }else{
            return "no";
        }
    };
	
	/*function formatDate(val,cell,record,row,colum,store){
		
		if(record.get('reformulacion')=='1'){
			
			return '<span style="color:red;font-size:8pt">'+ val?val.dateFormat('d/m/Y'):'' +'</span>';
		}
		
		else
		{
			return val?val.dateFormat('d/m/Y'):'';
		}
	}*/
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Aprobacion Gerencial',grid_maestro:'grid-'+idContenedor};
	layout_verificacion_presupuestaria=new DocsLayoutMaestroEP(idContenedor);
	layout_verificacion_presupuestaria.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_verificacion_presupuestaria,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_enableSelect=this.EnableSelect;
    var CM_btnEdit=this.btnEdit;
    var CM_ocultarGrupo=this.ocultarGrupo;
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
	    editar:{crear:true,separador:false},
	    actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		//Save:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/solicitud_compra/ActionModificarModalidadSolCom.php'},
		//ConfirmSave:{url:direccion+'../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php'},
		ConfirmSave:{url:direccion+'../../../control/solicitud_compra/ActionModificarModalidadSolCom.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,columnas:['90%'],grupos:[
		{tituloGrupo:'Datos',columna:0,id_grupo:0},
		{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1},
		{tituloGrupo:'Categoria',columna:0,id_grupo:2}
		],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Aprobacion Gerencial'}};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		    CM_ocultarGrupo('Datos');  
		    CM_ocultarGrupo('Estructura Programatica');
        	CM_btnEdit();
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
	function btn_solicitud_compra_det(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
			data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.tipo_adq=='Bien'){
				layout_verificacion_presupuestaria.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_verificacion_solicitud_bien/detalle_verificacion_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
			else{
				layout_verificacion_presupuestaria.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_verificacion_solicitud_servicio/detalle_verificacion_solicitud_det.php?'+data,'Detalle Seguimiento Solicitud',ParamVentana);
			}
		
layout_verificacion_presupuestaria.getVentana().on('resize',function(){
			layout_verificacion_presupuestaria.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	function btn_cancelar(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			Ext.MessageBox.show({
           title: 'Observaciones',
           msg: 'Ingrese observaciones a la solicitud:',
           width:300,
           buttons: Ext.MessageBox.OK,
           multiline: true,
           fn: getObservaciones
           
       });
			data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=cancelar';
			
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	
	
	function btn_aprobar(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
		    
		    var SelectionsRecord=sm.getSelected();
		    
		    if(parseFloat(SelectionsRecord.data.tiene_presupuesto)>0){
		  	   Ext.MessageBox.show({
                   title: 'Observaciones de Aprobación',
                   msg: 'Ingrese las observaciones de aprobación:',
                   width:300,
                   buttons: Ext.MessageBox.OK,
                   multiline: true,
                   fn: getObservaciones
                   
               });
			id_solicitud_compra=SelectionsRecord.data.id_solicitud_compra;
       		data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=aprobar_presupuesto';
		    }else{
		        if(confirm('No tiene presupuesto para aprobar esta solicitud, desea continuar?')){
		            if(parseFloat(SelectionsRecord.data.tiene_presupuesto)>0){
        		  	   Ext.MessageBox.show({
                           title: 'Observaciones de Aprobación',
                           msg: 'Ingrese las observaciones de aprobación:',
                           width:300,
                           buttons: Ext.MessageBox.OK,
                           multiline: true,
                           fn: getObservaciones
                           
                       });
        			id_solicitud_compra=SelectionsRecord.data.id_solicitud_compra;
               		data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
        			data=data+'&operacion=aprobar_presupuesto';
		        }
		    }
		  }
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	
	function btn_correccion(){
		data='';
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			Ext.MessageBox.show({
           title: 'Observaciones de Corrección',
           msg: 'Ingrese observaciones para corrección:',
           width:300,
           buttons: Ext.MessageBox.OK,
           multiline: true,
           fn: getObservacionesC
           
       });
			data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
			data=data+'&operacion=correccion';
			
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}
	function getObservaciones(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		data=data+'&observaciones='+observaciones;
		data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
			Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
			method:'GET',
			success:esteSuccess,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	function getObservacionesC(btn,text){
		if(btn!='cancel'){
		observaciones=text;
		
		data=data+'&observaciones='+observaciones;
		data=data+"&filtro=ESTCOM.nombre like 'pendiente_pre_aprobacion'";
		
		Ext.Ajax.request({
			url:direccion+"../../../control/seguimiento_solicitud/ActionGuardarSeguimientoSolicitud.php?"+data,
			method:'GET',
			success:esteSuccessC,
			failure:ClaseMadre_conexionFailure,
			timeout:100000000
		});}		
	}
	
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	function esteSuccessC(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	
	function btn_reporte_solicitud_compra(){
	  window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVer.php?'+data)	
	
	}
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}	
	
	function btn_verificar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='id_solicitud_compra='+SelectionsRecord.data.id_solicitud_compra;
							
			window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFVerificacion.php?'+data)	
			
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	   txt_check=getComponente('permite_agrupar');
	   
	   var onCheck=function(e,v){
	       if(!v){
	           getComponente('id_tipo_categoria_adq').enable();
	       }else{
	           getComponente('id_tipo_categoria_adq').disable();
	       }
	   }
	   
	   txt_check.on('check', onCheck);
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_verificacion_presupuestaria.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','Detalle');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección',btn_correccion,true,'pedir_correccion','Corrección');
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Solicitud',btn_aprobar,true,'aprobar_presupuesto','Aprobación');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Verificar Presupuesto',btn_verificar,true,'verificar_presupuesto','Presupuesto');
	//this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Reporte Solicitud Compra',btn_reporte_solicitud_compra,true,'reporte_solicitud_compra','');	
	var CM_getBoton=this.getBoton;
	CM_getBoton('pedir_correccion-'+idContenedor).enable();
	CM_getBoton('aprobar_presupuesto-'+idContenedor).enable();
	CM_getBoton('verificar_presupuesto-'+idContenedor).enable();	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedor).pagina.btnActualizar();
	}
	
	function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				       
        			   
					       if(record.reformulacion=='1'){
					       		CM_getBoton('pedir_correccion-'+idContenedor).disable();
								CM_getBoton('aprobar_presupuesto-'+idContenedor).disable();
								CM_getBoton('verificar_presupuesto-'+idContenedor).disable();
					       }
					       else{
					       	 	CM_getBoton('pedir_correccion-'+idContenedor).enable();
								CM_getBoton('aprobar_presupuesto-'+idContenedor).enable();
								CM_getBoton('verificar_presupuesto-'+idContenedor).enable();
					       }
				       		

				}
				CM_enableSelect(sel,row,selected);
				
			}		

	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_verificacion_presupuestaria.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	//layout_verificacion_presupuestaria.getVentana().addListener('beforehide',salta);
	
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}