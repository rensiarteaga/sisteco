/**
 * Nombre:		  	    pagina_compensacion.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creaciï¿½n:		12-05-2011
 */
function pagina_compensacion(idContenedor,direccion,paramConfig){
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/compensacion/ActionListarCompensacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_compensacion',totalRecords:'TotalCount'
		},[		
		'id_compensacion',
		{name:'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'compensado',
		'id_empleado',
		'desc_empleado',
		'total_dias',
		'dias_tomados'		
		]),remoteSort:true});
	//DATA STORE COMBOS   	
	
		//FUNCIONES RENDER
	
	function render_compensado(value)
	{
		if(value=='si'){value='Si'	}
		else {value='No'}
		return value
	}
Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_compensacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		defecto:maestro.id_empleado,
		filtro_0:false		
	};

	Atributos[2]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Desde',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'COMPEN.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:''
	};
	
	Atributos[3]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Hasta',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'COMPEN.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:''		
	};
	// txt fecha_reg
	
	Atributos[4]={
		validacion:{
			name:'total_dias',
			fieldLabel:'Dias para Compensar',
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
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'COMPEN.total_dias'
	};
		Atributos[5]={
		validacion:{
			labelSeparator:'',
			name:'dias_tomados',
			fieldLabel:'Dias Tomados',
			grid_visible:true, 
			grid_editable:false
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'COMPEN.dias_tomados'		
	};
	Atributos[6]={
		validacion:{
			labelSeparator:'',
			name:'compensado',
			fieldLabel:'Compensado',
			grid_visible:true, 
			grid_editable:false,
			renderer:render_compensado
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'COMPEN.compensado'		
	};
Atributos[7]= {
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
		filterColValue:'COMPEN.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:''
	};
	Atributos[8]={
		validacion:{
			labelSeparator:'',
			name:'desc_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false	
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
	var config={titulo_maestro:'Empleado (Maestro)',titulo_detalle:'Compensacion (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	
	var layout_compensacion=new DocsLayoutMaestro(idContenedor);
	layout_compensacion.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_compensacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_btnEdit=this.btnEdit;
	
	
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/compensacion/ActionEliminarCompensacion.php'},
		Save:{url:direccion+'../../../control/compensacion/ActionGuardarCompensacion.php'},
		ConfirmSave:{url:direccion+'../../../control/compensacion/ActionGuardarCompensacion.php'},
		Formulario:
		    {html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,closable:true,titulo:'compensacion'
		    }};
	this.reload=function(m)
	{
			maestro=m;			
			ds.lastOptions={
				params:{
					start:0,
					limit:paramConfig.TamanoPagina,
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
		
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}
	this.getLayout=function(){
		return layout_compensacion.getLayout()
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
	
	//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	var CM_getBoton=this.getBoton;
	function enable(sel,row,selected){
			var record=selected.data;
			if(record.dias_tomados > 0){
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
	layout_compensacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}