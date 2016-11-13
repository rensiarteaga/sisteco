/**
 * Nombre:		  	    pagina_empleado_trabajo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		11-08-2010
 */
function pagina_empleado_trabajo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_trabajo/ActionListarEmpleadoTrabajo.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_trabajo',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_trabajo',
		'id_empleado',
		
		'descripcion','cargo',
		'id_institucion',
		'tipo_institucion',
		
		{name:'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'desc_institucion','desc_empleado'
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
	

	
	
	ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_institucion',
		totalRecords: 'TotalCount'
	}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});
	//FUNCIONES RENDER
	
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	
	function render_financiado(value){
		if(value=='si'){value='Si'	}
		else if(value=='no'){	value='No'		}
		else if(value=='parcial'){value='Parcial'}
		return value
	}
	
	function render_tipo_institucion(value)
	{
		if(value=='privado'){value='Privado'	}
		else if(value=='publico'){value='Público'	}
		return value
	}
	
	
	// Definición de datos //
	// hidden id_empleado_frppa
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_trabajo',
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
	
	
    
	vectorAtributos[2]= {
		validacion: {
			name:'tipo_institucion',
			emptyText:'Tipo Institucion',
			fieldLabel:'Tipo Institucion',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['publico','Publico'],['privado','Privado']
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_tipo_institucion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPTRA.tipo_institucion',
		save_as:'tipo_institucion'
		};
	
		vectorAtributos[3]= {
				validacion: {
				name:'id_institucion',
				fieldLabel:'Institución',
				allowBlank:false,
				emptyText:'Institución...',
				name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
				desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_institucion,
				valueField: 'id_institucion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'INSTIT.nombre#INSTIT.casilla',
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:150,
				minListWidth:450,
				grow:true,
				width:'100%',
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_institucion,
				grid_visible:true,
				grid_editable:false,
				width_grid:150 // ancho de columna en el gris
	
			},
			tipo:'ComboBox',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'INSTIT.nombre',
			defecto: '',
			form:true,
			save_as:'id_institucion'
			
		};
		
				
vectorAtributos[4]={
		validacion:{
			name:'cargo',
			fieldLabel:'Cargo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPTRA.cargo'	
	};
		
vectorAtributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPTRA.descripcion'	
	};
	// txt fecha_registro
	vectorAtributos[6]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPTRA.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini'
	};	
	
		vectorAtributos[7]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPTRA.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin'
	};	

	//----------- FUNCIONES RENDER
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Registro Empleados (Maestro)',
		titulo_detalle:'Empleados Trabajo (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_empleado_trabajo=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_empleado_trabajo.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_trabajo,idContenedor);
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
	btnEliminar:{url:direccion+'../../../control/empleado_trabajo/ActionEliminarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Save:{url:direccion+'../../../control/empleado_trabajo/ActionGuardarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	ConfirmSave:{url:direccion+'../../../control/empleado_trabajo/ActionGuardarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'trabajo'}};
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
	    btnEliminar:{url:direccion+'../../../control/empleado_trabajo/ActionEliminarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Save:{url:direccion+'../../../control/empleado_trabajo/ActionGuardarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	  ConfirmSave:{url:direccion+'../../../control/empleado_trabajo/ActionGuardarEmpleadoTrabajo.php',parametros:'&m_id_empleado='+maestro.id_empleado},
	   Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'trabajo'}};
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
		
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_trabajo.getLayout()
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
	layout_empleado_trabajo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}