/**
 * Nombre:		  	    pagina_tipo_horario_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_tipo_horario(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_tipo_horario;
	var txt_codigo,txt_nombre,txt_fecha_reg;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_horario/ActionListarTipoHorario.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_horario',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_tipo_horario',
		'codigo',
		'nombre',			
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}			
		]),remoteSort:true});
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//Definición de datos
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_horario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_horario'
	};
	

	// txt codigo
	vectorAtributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
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
		filterColValue:'TIPHOR.codigo',
		save_as:'txt_codigo'	
	};
	
	// txt nombre
	vectorAtributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
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
		filterColValue:'TIPHOR.nombre',
		save_as:'txt_nombre'
	};	
	vectorAtributos[3]= {	
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:100
		},
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPHOR.fecha_reg',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_reg'	
	};
	
	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Tipo de Horario',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_horario=new DocsLayoutMaestro(idContenedor);
	layout_tipo_horario.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_horario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	
	
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
		btnEliminar:{url:direccion+'../../../control/tipo_horario/ActionEliminarTipoHorario.php'},
		Save:{url:direccion+'../../../control/tipo_horario/ActionGuardarTipoHorario.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_horario/ActionGuardarTipoHorario.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Tipo Horario'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	/*function btn_empleado_tpm_frppa()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_tpm_frppa/empleado_tpm_frppa_det.php?'+data,'Empleados Estructura Programática',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}*/
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
	    txt_codigo=ClaseMadre_getComponente ('codigo');
        txt_nombre=ClaseMadre_getComponente ('nombre');
        txt_fecha_reg=ClaseMadre_getComponente ('fecha_reg');
		
	}
	
	
	
	/*function btn_seguro()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_seguro/empleado_seguro.php?'+data,'Empleados - Seguro',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	
	
	function btn_afp()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_empleado='+SelectionsRecord.data.id_empleado;
			data=data+'&m_id_persona='+SelectionsRecord.data.id_persona;
			data=data+'&m_codigo_empleado='+SelectionsRecord.data.codigo_empleado;
			data=data+'&m_desc_persona='+SelectionsRecord.data.desc_persona;
			data=data+'&m_email1='+SelectionsRecord.data.email1;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_empleado.loadWindows(direccion+'../../empleado_afp/empleado_afp.php?'+data,'Empleados - AFP',ParamVentana);
            layout_empleado.getVentana().on('resize',function(){layout_empleado.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}*/
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_horario.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
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
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignación de EP',btn_empleado_tpm_frppa,true,'empleado_tpm_frppa','Asignar Estructura Programática');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Seguro',btn_seguro,true,'seguro','Seguro');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','AFP',btn_afp,true,'afp','AFP');
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_horario.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}