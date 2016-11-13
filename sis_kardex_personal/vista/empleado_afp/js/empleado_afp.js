/**
 * Nombre:		  	    pagina_empleado_afp.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		11-08-2010
 */
function pagina_empleado_afp(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_afp/ActionListarEmpleadoAfp.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_afp',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_afp',
		'id_empleado',
		'id_afp',
		'nro_afp',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_reg','desc_afp','desc_empleado','jubilado',
		{name:'fecha_asignacion',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_finalizacion',type:'date',dateFormat:'Y-m-d'}
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_empleado:maestro.id_empleado
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    var dataMaestro=[['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]];
	var dsMaestro=new Ext.data.Store({proxy:new Ext.data.MemoryProxy(dataMaestro),reader:new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width:300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS
	
	ds_afp=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/afp/ActionListarAfp.php?estado=activo"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_afp',totalRecords:'TotalCount'},['id_afp','nombre'])});
	
	//FUNCIONES RENDER
	function render_id_afp(value,p,record){return String.format('{0}',record.data['desc_afp'])}
	
	function render_estado_reg(value){
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_afp',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'id_empleado'
	};
	
	vectorAtributos[2]={
	validacion:{
		fieldLabel:'Afp',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Nº afp...',
		name:'id_afp',
		desc:'desc_afp',
		store:ds_afp,
		valueField:'id_afp',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_afp,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200
	},
	save_as:'id_afp',
	tipo:'ComboBox',
	filtro_0:true,
	filterColValue:'AAFFPP.nombre'
};
    
	
vectorAtributos[3]={
		validacion:{
			name:'nro_afp',
			fieldLabel:'Nº AFP',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:150
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPAFP.nro_afp'	
	};
	
	vectorAtributos[4]= {
		validacion: {
			name:'jubilado',
			emptyText:'Jubilado',
			fieldLabel:'Jubilado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPAFP.jubilado',
		save_as:'jubilado'
	};
		
		
	// txt fecha_registro
	vectorAtributos[5]={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:true,
			width:150
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPAFP.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};	
	
	vectorAtributos[6]= {
		validacion: {
			name:'estado_reg',
			emptyText:'Estado',
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
			grid_editable:false,
			width_grid:60,
			width:150
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPAFP.estado_reg',
		save_as:'estado_reg'
		};
		
		
		vectorAtributos[7]={
		validacion:{
			name:'fecha_asignacion',
			fieldLabel:'Fecha Asignación',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false,
			width:150
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPAFP.fecha_asignacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_asignacion'
	};	
	
	
	vectorAtributos[8]={
		validacion:{
			name:'fecha_finalizacion',
			fieldLabel:'Fecha Finalización',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false,
			width:150
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPAFP.fecha_finalizacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_finalizacion'
	};	
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Empleados afp (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_empleado_afp=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_empleado_afp.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_afp,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/empleado_afp/ActionEliminarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/empleado_afp/ActionGuardarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/empleado_afp/ActionGuardarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'afp'}};
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_empleado=datos.m_id_empleado;
		maestro.id_persona=datos.m_id_persona;
		maestro.codigo_empleado=datos.m_codigo_empleado;
		maestro.desc_persona=datos.m_desc_persona;
		maestro.email1=datos.m_email1;
	    gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Funcionario',maestro.id_empleado],['Funcionario',maestro.desc_persona],['Email',maestro.email1]]);
		vectorAtributos[1].defecto=maestro.id_empleado;
		paramFunciones={
	    btnEliminar:{url:direccion+'../../../control/empleado_afp/ActionEliminarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/empleado_afp/ActionGuardarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/empleado_afp/ActionGuardarEmpleadoAfp.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'afp'}};
		this.InitFunciones(paramFunciones);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
			};
		this.btnActualizar()
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){	
		
		
	}
	this.btnNew=function(){
		ocultarComponente(getComponente('fecha_reg'));
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
	mostrarComponente(getComponente('fecha_reg'));
	ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_afp.getLayout()
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
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado_afp.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}