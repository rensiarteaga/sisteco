/**
 * Nombre:		  	    pagina_autorizacion_presupuesto.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-08-18 17:10:52
 */
function pagina_autorizacion_presupuesto(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_usuario_autorizado',totalRecords:'TotalCount'
		},[		
		'id_usuario_autorizado',
		'id_usuario',
	 	'desc_usuario',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'sw_responsable',
		'estado',
		'desc_usuario_reg',
		'fecha_reg',
		'fecha_ultima_mod'
		
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

    var ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuarioEmpleado.php?m_sw_presupuesto=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','desc_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion','cargo'])
	});
	
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?m_sw_presupuesto=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	
	 var ds_usuario_reg = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuarioEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','desc_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado','fecha_expiracion','cargo'])
	});

	//FUNCIONES RENDER
	
		function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
		//var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b> {desc_persona} </b><br>','<b>Cargo: </b><FONT COLOR="#B5A642">{cargo}</FONT><br>','</div>');
		var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Cargo: </b>{cargo}</FONT>','</div>');
	
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</i></b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');

		function render_id_usuario_reg(value, p, record){return String.format('{0}', record.data['desc_usuario_reg']);}
		//var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b> {desc_persona} </b><br>','<b>Cargo: </b><FONT COLOR="#B5A642">{cargo}</FONT><br>','</div>');
		var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Cargo: </b>{cargo}</FONT>','</div>');
	
		
	/*function renderSwResponsable(value, p, record)
	{
		if(value == 1)
		{return "Si"}
		if(value == 2)
		{return "No"}		
		return '';
	}*/
	
	function renderSwResponsable(value, p, record)
	{
		if(value == 1)
		{return "Responsable"}
		if(value == 2)
		{return "Formular"}
		if(value == 3)
		{return "Consultar"}	
		if(value == 9)
		{return "Inactivo"}	
		return 'Otros';
	}
		
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_usuario_autorizado
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_autorizado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_usuario_autorizado'
	};
// txt id_usuario
		Atributos[1]={
			validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:false,			
			//emptyText:'Usuario ...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:280,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usuario'
	};
 
	// txt id_unidad_organizacional
	Atributos[2]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			//emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			//desc: 'nombre_unidad',
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',//
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:350,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad#UNIORG.centro',//
		save_as:'id_unidad_organizacional'
	};
	
	Atributos[3] = {
		validacion: {
			name:'sw_responsable',			
			fieldLabel:'Responsabilidad',
			//vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,			
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :[
				       
				        ['1', 'Responsable'],
				        ['2', 'Formular'],
				        ['3', 'Consultar']
				                 
				        ] // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderSwResponsable,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			width:150
		},
		tipo:'ComboBox',
		filtro_0:false,		
		form: true,
		save_as:'sw_responsable'		
	};	
	
	// txt estado
	Atributos[4] 	= {
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			desc: 'estado',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			align: 'center',
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Activo','Activo'],['Inactivo','Inactivo']]}),			
			valueField:'ID',
			displayField:'valor',
			//renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, 
			grid_editable:false, 
			width_grid:70, 
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,	
		filterColValue:'USUAUT.estado',		
		save_as:'estado'
	};
	
	// txt id_unidad_organizacional
	Atributos[5]={
			validacion:{
			name:'desc_usuario_reg',
			fieldLabel:'Usuario Registro',
			allowBlank:false,			
			//emptyText:'Usuario ...',
			desc: 'desc_usuario_reg', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_reg,
			valueField: 'desc_usuario_reg',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_reg,
			grid_visible:false,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'PERSON2.apellido_paterno#PERSON2.apellido_materno#PERSON2.nombre',
		save_as:'desc_usuario_reg'
	};	

	Atributos[6]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:false,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'USUAUT.fecha_reg'
	};
	
	Atributos[7]={
		validacion:{			
			name:'fecha_ultima_mod',
			fieldLabel:'Fecha Ultima Modificación',
			grid_visible:false,
			grid_editable:false,
			width_grid:100		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'USUAUT.fecha_ultima_mod'
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function btn_estado_autorizado(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_usuario_autorizado='+SelectionsRecord.data.id_usuario_autorizado;
			 data+='&m_desc_usuario='+SelectionsRecord.data.desc_usuario;
			 data+='&m_desc_unidad_organizacional='+SelectionsRecord.data.desc_unidad_organizacional;
			 
			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_autorizacion_presupuesto.loadWindows(direccion+'../../../../sis_presupuesto/vista/estado_autorizado/estado_autorizado.php?'+data,'Cambio Estado Autorización',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};	

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Autorización Presupuesto',grid_maestro:'grid-'+idContenedor};
	var layout_autorizacion_presupuesto=new DocsLayoutMaestro(idContenedor);
	layout_autorizacion_presupuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_autorizacion_presupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/usuario_autorizado/ActionEliminarAutorizacionPresupuesto.php'},
		Save:{url:direccion+'../../../control/usuario_autorizado/ActionGuardarAutorizacionPresupuesto.php'},
		ConfirmSave:{url:direccion+'../../../control/usuario_autorizado/ActionGuardarAutorizacionPresupuesto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Autorización a Presupuestar'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_autorizacion_presupuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Autorización a Cambiar de Etapa',btn_estado_autorizado,true,'estado_autorizado','Etapas Presupuestarias');
	
	layout_autorizacion_presupuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}