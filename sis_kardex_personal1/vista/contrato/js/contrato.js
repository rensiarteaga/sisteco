/**
 * Nombre:		  	    pagina_contrato.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		02-09-2010
 */
function pagina_contrato(idContenedor,direccion,paramConfig){
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	
	var combo_persona,txt_codigo_empleado,txt_nombre_tipo_documento;
    var txt_doc_id,txt_email1;
    var maestro=new Array();
	var sw=0;
	var componentes=new Array;
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/contrato/ActionListarContrato.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_contrato',totalRecords:'TotalCount'
		},[		
				'id_contrato',
		'nro_contrato',
		'tipo_contrato',
		'sueldo',
		'id_moneda',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		'id_empleado','desc_empleado','desc_moneda',
		'forma_pago',
		'tiene_quincena',
		'porcen_quincena',
		'socio_cooperativa',
		'monto_fijo',
		'porcen_fijo_cooperativa',
		{name: 'fecha_inicio_quincena',type:'date',dateFormat:'Y-m-d'}, 'tipo_registro_contrato'
		
		]),remoteSort:true});
	//DATA STORE COMBOS   	
	
		ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/moneda/ActionListarMoneda.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo'])});
	//FUNCIONES RENDER
	
function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda'])}
	
	function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else if(value=='inactivo'){value='Inactivo'	}
		else if(value=='eliminado'){value='Eliminado'}
		return value
	}
	
	
    
Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_contrato',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};

	

	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		defecto:maestro.id_empleado,
		filtro_0:false
		
	};
// txt nombre
	Atributos[3]={
		validacion:{
			name:'nro_contrato',
			fieldLabel:'Nº Contrato',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'contra.nro_contrato',
		id_grupo:0
	};

	
	Atributos[2]= {
		validacion: {
			name:'tipo_contrato',			
			fieldLabel:'Tipo Contrato',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['planta','Planta'],['consultor','Consultor'],['servicio','Servicio'], ['eventual','Eventual']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		id_grupo:0,
		filterColValue:'contra.tipo_contrato'		
	};
	
	
	Atributos[4]={
		validacion:{
			name:'sueldo',
			fieldLabel:'Sueldo',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:true,
			decimalPrecision:2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'contra.sueldo',
		id_grupo:0
	};

	
	
	Atributos[5]={
	validacion:{
		fieldLabel:'Moneda',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Moneda...',
		name:'id_moneda',
		desc:'desc_moneda',
		store:ds_moneda,
		valueField:'id_moneda',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_moneda,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:230,
		width:150,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:120
	},
	save_as:'id_moneda',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'MONEDA.nombre',
	id_grupo:0
};


	Atributos[6]={
		validacion:{
			labelSeparator:'',
			name: 'estado_reg',
			fieldLabel:'Estado Registro',
			inputType:'hidden',
			grid_visible:true, 
			renderer:render_estado_reg,
			grid_editable:false
		},
		tipo: 'Field',
		defecto:'activo',
		filtro_0:false
		
	};
	
	Atributos[7]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Inicio Contrato',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'contra.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
	};
	
	Atributos[8]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fin Contrato',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'contra.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
	};
	// txt fecha_reg
	Atributos[9]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:true		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'contra.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:''
		
	};

	
	Atributos[10]= {
		validacion: {
			name:'forma_pago',			
			fieldLabel:'Forma de Pago',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','Cheque'],['transferencia','Transf. Bancaria'],['efectivo','Efectivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		
		filterColValue:'contra.forma_pago'	,
		id_grupo:0	
	};
	
	/*Atributos[11]= {
		validacion: {
			name:'tiene_quincena',			
			fieldLabel:'Quincena',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		defecto:'no',
		id_grupo:1,
		filterColValue:'contra.tiene_quincena'		
	};
	
	
	Atributos[12]={
		validacion:{
			name:'porcen_quincena',
			fieldLabel:'Anticipo',
			allowBlank:true,
			
			minLength:0,
			
			minValue:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:true,
			decimalPrecision:2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'contra.porcen_quincena',
		id_grupo:1
	};

	
	Atributos[13]= {
		validacion: {
			name:'socio_cooperativa',			
			fieldLabel:'Socio Coop.',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,	
		defecto:'no',	
		id_grupo:1,
		filterColValue:'contra.socio_cooperativa'		
	};
	
	Atributos[14]={
		validacion:{
			name:'monto_fijo',
			fieldLabel:'Aporte Cooperativa($us)',
			allowBlank:true,
			
			minLength:0,
			minValue:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:true,
			decimalPrecision:2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'contra.monto_fijo',
		id_grupo:1
	};
	
	Atributos[15]={
		validacion:{
			name:'porcen_fijo_cooperativa',
			fieldLabel:'% Aporte Cooperativa',
			allowBlank:true,
			
			minLength:0,
			maxValue:100,
			minValue:0,
			selectOnFocus:true,
			vtype:'texto',
			allowDecimals:true,
			decimalPrecision:2,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'contra.porcen_fijo_cooperativa',
		id_grupo:1
	};
	
	
	
	
	Atributos[16]= {
		validacion:{
			name:'fecha_inicio_quincena',
			fieldLabel:'Inicio Quincena/Socio',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'contra.fecha_inicio_quincena',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:1
		
	};
	
	*/
	Atributos[11]= {
		validacion: {
			name:'tipo_registro_contrato',			
			fieldLabel:'Tipo Reg. Ctto',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['nuevo','nuevo'],['modificacion','modificacion']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		defecto:'nuevo',
		id_grupo:0,
		filterColValue:'contra.tipo_registro_contrato'		
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	/*var config={
		titulo_maestro:'Empleado Cuenta',
		grid_maestro:'grid-'+idContenedor
	};*/
	var config={titulo_maestro:'Empleado (Maestro)',titulo_detalle:'Contrato (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	
	var layout_contrato=new DocsLayoutMaestro(idContenedor);
	layout_contrato.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_contrato,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_contrato,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	
	
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
		btnEliminar:{url:direccion+'../../../control/contrato/ActionEliminarContrato.php'},
		Save:{url:direccion+'../../../control/contrato/ActionGuardarContrato.php'},
		ConfirmSave:{url:direccion+'../../../control/contrato/ActionGuardarContrato.php'},
		Formulario:
		    {html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'contrato',
		    
		    grupos:[
				{	tituloGrupo:'Información Contractual',columna:0,	id_grupo:0	},
				{	tituloGrupo:'Datos de Funcionarios de Planta',columna:0,	id_grupo:1	}
					]
		    }};
	
	this.reload=function(m)
	{
			maestro=m;			
	
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_empleado:maestro.id_empleado					
				}
			};			
				
			this.btnActualizar();
			Atributos[1].defecto=maestro.id_empleado;
			
			paramFunciones.btnEliminar.parametros='&m_id_empleado='+maestro.id_empleado;
			paramFunciones.Save.parametros='&m_id_empleado='+maestro.id_empleado;
			paramFunciones.ConfirmSave.parametros='&m_id_empleado='+maestro.id_empleado;			
			
			this.InitFunciones(paramFunciones)
	};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		t_tipo_contrato=getComponente('tipo_contrato');
		/*t_tiene_quincena=getComponente('tiene_quincena');
		t_socio_cooperativa=getComponente('socio_cooperativa');*/
		
		var onTipoCto=function(e){
			if(e.value=='planta'){
				CM_mostrarGrupo('Datos de Funcionarios de Planta');
				//CM_ocultarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=true;
				getComponente('fecha_fin').reset();
			}else  { 
				CM_ocultarGrupo('Datos de Funcionarios de Planta');
				//CM_mostrarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=false;
			}
		}
		t_tipo_contrato.on('select',onTipoCto);
		
		/*var onQuincena=function(e){
		   if(e.value=='si'){
		   	  CM_mostrarComponente(getComponente('porcen_quincena'));
		   	  getComponente('porcen_quincena').allowBlank=false;
		   	  		   	  getComponente('fecha_inicio_quincena').allowBlank=false;

		   }else{
		   	  CM_ocultarComponente(getComponente('porcen_quincena'));
		   	  getComponente('porcen_quincena').allowBlank=true;
		      getComponente('porcen_quincena').reset();
		       getComponente('fecha_inicio_quincena').allowBlank=true;
		       getComponente('fecha_inicio_quincena').reset();

		   }
		}*/
		
		
		
		/*var onSocio=function(e){
		   if(e.value=='si'){
		   	  CM_mostrarComponente(getComponente('porcen_fijo_cooperativa'));
		   	  CM_mostrarComponente(getComponente('monto_fijo'));
		   	  
		   	  getComponente('porcen_fijo_cooperativa').allowBlank=false;
		   	  getComponente('monto_fijo').allowBlank=false;
		   }else{
		   	  CM_ocultarComponente(getComponente('porcen_fijo_cooperativa'));
		   	  CM_ocultarComponente(getComponente('monto_fijo'));
		   	  getComponente('porcen_fijo_cooperativa').allowBlank=true;
		   	  getComponente('monto_fijo').allowBlank=true;
		   	  
		   	  getComponente('porcen_fijo_cooperativa').reset();
		   	  getComponente('monto_fijo').reset();
		   	  
		   }
		}*/
		/*t_tiene_quincena.on('select',onQuincena);
		t_socio_cooperativa.on('select',onSocio);
		t_tiene_quincena.on('change',onQuincena);
		t_socio_cooperativa.on('change',onSocio);*/
	}

	
	this.btnNew=function(){
		CM_ocultarGrupo('Datos de Funcionarios de Planta');
		//getComponente('tiene_quincena').setValue('no');
		//getComponente('socio_cooperativa').setValue('no');
		CM_ocultarComponente(getComponente('estado_reg'));
		//CM_ocultarComponente(getComponente('porcen_quincena'));
		//CM_ocultarComponente(getComponente('monto_fijo'));
		//CM_ocultarComponente(getComponente('porcen_fijo_cooperativa'));
		CM_btnNew();
	}
	
	this.btnEdit=function(){
		
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			/*if(SelectionsRecord.data.tiene_quincena=='si'){
				CM_mostrarComponente(getComponente('porcen_quincena'));
			}else{
				CM_ocultarComponente(getComponente('porcen_quincena'));
			}*/
			
			/*if(SelectionsRecord.data.socio_cooperativa=='si'){
				CM_mostrarComponente(getComponente('monto_fijo'));
				CM_mostrarComponente(getComponente('porcen_fijo_cooperativa'));
			}else{
				CM_ocultarComponente(getComponente('monto_fijo'));
				CM_ocultarComponente(getComponente('porcen_fijo_cooperativa'));
			}*/
			
			if(SelectionsRecord.data.tipo_contrato=='planta'){
				//CM_ocultarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=true;
				getComponente('fecha_fin').reset();
			}else{
				//CM_mostrarComponente(getComponente('fecha_fin'));
				getComponente('fecha_fin').allowBlank=false;
			}
			CM_btnEdit();
		}else{
			alert('Es necesario seleccionar un item');
		}
	};
	//para que los hijos puedan ajustarse al tamaño
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}
	this.getLayout=function(){
		return layout_contrato.getLayout()
	};
	//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
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
	function enable(sel,row,selected){
			var record=selected.data;
			if(record.estado_reg=='inactivo'){
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();	
			}else{
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();	
			}
			CM_enableSelect(sel,row,selected)
	}
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_contrato.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}