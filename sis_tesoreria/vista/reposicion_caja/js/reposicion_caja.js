/**
 * Nombre:		  	    pagina_reposicion_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 15:53:15
 */
function pagina_reposicion_caja(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var g_tipo_regis;
	
	var data_reporte_ultimo;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarReposicionCaja.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_regis',totalRecords:'TotalCount'
		},[		
		'id_caja_regis',
		'id_caja',
		'moneda',
		'tipo_caja',
		'desc_caja',
		'id_cajero',
		'nombre_moneda',
		'tipo_caja_caja',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'estado_cajero_cajero',
		'desc_cajero',
		{name: 'fecha_regis',type:'date',dateFormat:'Y-m-d'},
		'importe_regis',
		'nombre_unidad',
		'nombre_depto',
		'tipo_regis',
		'estado_regis',
		'id_depto',
		'id_moneda',
		'id_cheque',
		'nro_documento',
		'codigo_repo',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'}
	
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
		});
	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','desc_institucion','nro_cuenta_banco'])
	});

	//FUNCIONES RENDER
	
		function render_id_caja(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
	
		function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i><br>','<FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT>','</div>');

		
	function renderTipo(value, p, record){
		if(value == 1){return "Caja"}
		if(value == 2){return "Caja Chica"}
		if(value == 3){return "Fondo Rotatorio"}
		
	}	
 
	function renderEstadoRegis(value, p, record){
		if(value == 0){return "Reposición"}
		if(value == 5){return "Contabilizado"}
		if(value == 6){return "Validado"}
		if(value == 7){return "Finalizado"}
		
	}	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_regis'
	};
	
	
	Atributos[1]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Departamento de Tesorería',
				allowBlank:false,
				emptyText:'Departamento...',
				desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'80%',
				
				onSelect:function(record){
				
				
				componentes[1].setValue(record.data.id_depto);
				componentes[1].collapse();
				componentes[2].clearValue();
				ds_caja.baseParams.m_id_depto=record.data.id_depto;
				componentes[2].modificado=true							
			},
				
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
				width:'80%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'depto.nombre_depto',
			save_as:'id_depto',
			id_grupo:1
		};
	
// txt id_caja
	Atributos[2]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'nombre_unidad', // indica la columna del store principal ds del que proviane la descripcion
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
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA_1.nombre#UNIORG.nombre_unidad',
		save_as:'id_caja',
		id_grupo:1
	};
// txt id_cajero
	Atributos[3]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:true,			
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:false,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:true,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_2.apellido_paterno#PERSON_2.apellido_materno#PERSON_2.nombre#EMPLEA_2.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:0
	};
// txt fecha_regis
	Atributos[4]= {
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false,
			grid_indice:6		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_regis',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_regis',
		id_grupo:0
	};
// txt importe_regis
	Atributos[5]={
		validacion:{
			name:'importe_regis',
			fieldLabel:'Importe Registro',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:115,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.importe_regis',
		save_as:'importe_regis',
		id_grupo:0
	};
// txt nombre_unidad
	Atributos[6]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'nombre_unidad',
		id_grupo:1
	};
// txt nombre
	Atributos[7]={
		validacion:{
			name:'moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'MONEDA.nombre',
		save_as:'nombre',
		id_grupo:0
	};
	
	// txt nombre_unidad
	Atributos[8]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo de Caja',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:2,
			renderer:renderTipo		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		save_as:'tipo_caja',
		id_grupo:0
	};
	Atributos[9]={
		validacion:{
			name:'tipo_regis',
			fieldLabel:'Tipo Registro',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
	 		width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'tipo_registro',
		id_grupo:0
	};

	// txt id_cuenta_bancaria
	Atributos[10]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#CUEBAN.nro_cuenta_banco',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
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
			renderer:render_id_cuenta_bancaria,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT_0.nombre#CUEBAN_0.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:2
		
	};
	Atributos[11]={
		validacion:{
			name:'estado_regis',
			fieldLabel:'Estado Registro',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			renderer:renderEstadoRegis,
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		save_as:'estado_regis',
		id_grupo:0
	};
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	Atributos[13]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	//
	Atributos[14]={
		validacion:{
			name:'codigo_repo',
			fieldLabel:'Nº Rendición',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		save_as:'codigo_repo',
		id_grupo:1
	};
	
	
	// txt fecha_ini
	Atributos[15]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false,
			grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		
		save_as:'fecha_ini',
		id_grupo:1
	};
	
	// txt fecha_fin
	Atributos[16]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Final',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false,
			grid_indice:6		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin',
		id_grupo:1
	};
	
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatDateBase(value){return value?value.dateFormat('m/d/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'reposicion_caja',grid_maestro:'grid-'+idContenedor};
	var layout_reposicion_caja=new DocsLayoutMaestro(idContenedor);
	layout_reposicion_caja.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_reposicion_caja,idContenedor);
	var getComponente=this.getComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	
	var CM_btnAct=this.btnActualizar;
	var CM_saveSuccess=this.saveSuccess;
	var CM_getComponente=this.getComponente;
	
	var CM_Save=this.Save;
	
	
	//var CM_btnEdit=this.btnEdit;
	var cm_EnableSelect=this.EnableSelect;
	var CM_getBoton=this.getBoton;
	var CM_conexionFailure=this.conexionFailure;
	
	
	
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

	
	
	
	
function btn_rendicion()
	{ 
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			//alert (SelectionsRecord.data.id_caja_regis+" - "+SelectionsRecord.data.id_caja);
		    //var data='&id_caja_regis='+SelectionsRecord.data.id_caja_regis+'&id_caja='+SelectionsRecord.data.id_caja+'&fecha_regis='+SelectionsRecord.data.fecha_regis;		   	   			   	   
		     var data='id_caja_regis='+SelectionsRecord.data.id_caja_regis;		   	   			   	   
		    //window.open(direccion+'../../../control/descargo/rendicion/ActionReporteRendicion.php?'+data)				
		    window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)				
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.')
		} 
	}	
		//argument:{dd:'dora'}
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarReposicionCaja.php'},
		Save:{
			url:direccion+'../../../control/caja_regis/ActionGuardarReposicionCaja.php'
		    //success:btn_rendicion_reporte
		}	,
		
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarReposicionCaja.php'},
		Formulario:{
			
			html_apply:'dlgInfo-'+idContenedor,height:400,
			columnas:['75%','15%'],
			//guardar:btn_rep_ultimo,
		grupos:[
		{tituloGrupo:'Oculto',columna:1,id_grupo:0},
		{tituloGrupo:'Datos Generales',columna:0,id_grupo:1},
		{tituloGrupo:'Datos Cheque',columna:0,id_grupo:2}
		],
		width:400,minWidth:150,minHeight:200,closable:true,titulo:'Reposicion Caja'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
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
 
	
 
this.btnNew=function(){
		txt_id_cajero.setDisabled(true);
	 CM_mostrarGrupo('Datos Generales');
	 CM_ocultarGrupo('Datos Cheque');
	 CM_ocultarGrupo('Oculto');
	 /*CM_mostrarGrupo('Datos Cheque');
	 CM_mostrarGrupo('Oculto');*/
	 SiBlancosGrupo(2);
		btnNew();
	}
this.btnEdit=function(){
	
		txt_id_cajero.setDisabled(true);
	  CM_mostrarGrupo('Datos Generales');
	  SiBlancosGrupo(2);
	 CM_ocultarGrupo('Datos Cheque');
	 CM_ocultarGrupo('Oculto');
		btnEdit();
	}
	//Para manejo de eventos
function iniciarEventosFormularios(){
	g_tipo_regis= CM_getComponente('tipo_regis');
 	g_tipo_regis.setVisible(false);
 	g_estado_regis= CM_getComponente('estado_regis');
 	
 	g_estado_regis.setVisible(false);
	for (var i=0;i<Atributos.length;i++){
		componentes[i]=CM_getComponente(Atributos[i].validacion.name);
	}
		txt_id_caja=ClaseMadre_getComponente('id_caja');
		txt_id_cajero=ClaseMadre_getComponente('id_cajero');
		function f_filtrar_cajero(combo,record,index){
		txt_id_cajero.setDisabled(false);
		txt_id_cajero.store.baseParams={ m_id_caja:record.data.id_caja };
		txt_id_cajero.modificado=true;
		}
		txt_id_caja.on('select',f_filtrar_cajero);
	}
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
				
		enable(sm,row,rec);
				cm_EnableSelect(sm,row,rec);
				//alert ("entra al enable");
				//Pagina.reload(rec.data);
				//layout_reposicion_caja.reload(rec.data);
				//_CP.getPagina(layout_reposicion_caja.getComponente()).pagina.reload(rec.data);
				//_CP.getPagina(layout_reposicion_caja.getIdContentHijo()).pagina.desbloquearMenu();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_reposicion_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	
	
	function btn_cerrar(){
		//formulario= this.getFormulario();
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			
			if(SelectionsRecord.data.estado_regis==0)
			{
				var sw=false;
				if(confirm('¿Esta seguro de cerrar la reposición?'))
						{sw=true}
						if(sw){				
							CM_mostrarGrupo('Datos Cheque');
							CM_mostrarGrupo('Datos Generales');
							CM_ocultarGrupo('Oculto');
							 data_reporte_ultimo='&id_caja_regis='+SelectionsRecord.data.id_caja_regis+'&id_caja='+SelectionsRecord.data.id_caja+'&fecha_regis='+SelectionsRecord.data.fecha_regis;		   	   			   	   
				   			//window.open(direccion+'../../../control/_reportes/rendicion/ActionReporteRendicion.php?'+data_reporte_ultimo)	
				   			g_estado_regis.setValue('5');
				   			 btnEdit();
				   			//ClaseMadre_save();
							//g_tipo_regis.setValue('0');
						}	
				
			}
			else
			{	
				Ext.MessageBox.alert('Estado','La solicitud seleccionada ya fue contabilizada.')			
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una solicitud.')
	    }	
	}
	
	function btn_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
				if(SelectionsRecord.data.estado_regis!=6)
				{		
					Ext.MessageBox.alert('Estado','Primero debe ser contabilizada.')			
				}
				else
				{	
					var sw=false;
					if(confirm('¿Esta seguro de imprimir el cheque?'))
							{sw=true}
					if(sw){	
						var data_cheque='m_id_moneda='+SelectionsRecord.data.id_moneda+'&m_id_cheque='+SelectionsRecord.data.id_cheque;			
						var data='id_caja_regis_0='+SelectionsRecord.data.id_caja_regis;
							data=data+'&id_caja_0='+SelectionsRecord.data.id_caja;
							data=data+'&id_cajero_0='+SelectionsRecord.data.id_cajero;
							data=data+'&importe_regis_0='+SelectionsRecord.data.importe_regis;
							data=data+'&estado_regis_0=7';
							data=data+'&codigo_repo_0='+SelectionsRecord.data.codigo_repo;
							data=data+'&tipo_registro_0='+SelectionsRecord.data.tipo_regis;
							data=data+'&fecha_regis_0='+formatDateBase(SelectionsRecord.data.fecha_regis);
							//data=data+'&id_cuenta_bancaria_0='+SelectionsRecord.data.id_cuenta_bancaria;
							data=data+'&fecha_ini_0='+formatDateBase(SelectionsRecord.data.fecha_ini) ;
							data=data+'&fecha_fin_0='+formatDateBase(SelectionsRecord.data.fecha_fin);
						//alert(data);
						Ext.Ajax.request({
							url:direccion+"../../../control/caja_regis/ActionGuardarReposicionCaja.php?"+data,
							method:'GET',
							success:fin_ajust,
							failure:CM_conexionFailure,
							timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						});
						window.open(direccion+'../../../control/avance/reporte/ActionPDFCheque.php?'+data_cheque)
					}	
				}	
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una solicitud.')
	    }	
	}
	function fin_ajust(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Impresión Realizado satisfactoriamente<br>');
		CM_btnAct()
	}
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Rendición',btn_rendicion,true,'rendicion','Rendición');
	this.AdicionarBoton("../../../lib/imagenes/det.ico",'Contabilizar',btn_cerrar,true, 'contabilizar','Contabilizar');
	this.AdicionarBoton("../../../lib/imagenes/print.gif",'Imprime Cheque',btn_cheque,true, 'imprime_cheque','Imprimir Cheque');
	


	
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		//texto = rec.data['concepto_regis'].substring(0,7);
		//alert (rec.data['tipo_regis']);
		if(rec.data['tipo_regis']==0 && rec.data['estado_regis']==5){
								
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
				//	CM_getBoton('rendicion-'+idContenedor).disable();
				}
				else{
					
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
					CM_getBoton('rendicion-'+idContenedor).enable();
				}
	if(rec.data['estado_regis']==6){
					CM_getBoton('imprime_cheque-'+idContenedor).enable();
				}
				else{
					CM_getBoton('imprime_cheque-'+idContenedor).disable();
				}			
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	function btn_rep_ultimo()
	{ 
		
		window.open(direccion+'../../../control/_reportes/rendicion/ActionReporteRendicion.php?'+data_reporte_ultimo);					
		//alert(data_reporte_ultimo +"   llega "+componentes[10].getValue());		 
		ClaseMadre_save();
	}
	
	layout_reposicion_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}