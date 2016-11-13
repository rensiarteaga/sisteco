/**
 * Nombre:		  	    pagina_marcas.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_marcas(idContenedor,direccion,paramConfig,idContenedorPadre){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_marcas;
	var maestro=new Array();
	var sw=0;
	var combo_observaciones,combo_tipo_movimiento;
	var	combo_turno,h_txt_hora;
	var componentes=new Array;
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/lectura_depurada/ActionListarLecturaDepuradaResumen.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lectura_depurada',totalRecords:'TotalCount'},
		[
		'id_lectura_depurada',
		'id_empleado',
		'codigo_empleado',
		{name:'fecha', type:'date', dateFormat:'Y-m-d'},
		'hora',
		'tipo_movimiento',
		'observaciones',
		'turno','aprobado','hora_marcada','tipo_marca']),remoteSort:true});		
	

vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_lectura_depurada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_depurada'
	};
 /////////// txt observaciones //////
	vectorAtributos[1]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Vacacion','Vacacion'],['Comision de Viaje','Comision de Viaje'],['Comision Sindical','Comision Sindical'],['Baja Medica','Baja Medica'],['Capacitacion','Capacitacion'],['horario continuo','horario continuo'],['Otro','Otro'],['Ninguna','Ninguna']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:5
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'observaciones',
		save_as:'txt_observaciones',
		defecto:""
	};
		/////////// txt turno //////
	vectorAtributos[2]={
		validacion:{
			name:'turno',
			fieldLabel:'Turno',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			disabled:true,
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Mañana','Mañana'],['Tarde','Tarde'],['Jornada Completa','Jornada Completa']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150
			},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'turno',
		save_as:'txt_turno',
		defecto:""
	};
		/////////// txt hora //////
	vectorAtributos[3]={
		validacion:{
			name:'hora',
			fieldLabel:'Hora',
			emptyText:'Hora...',
			allowBlank:true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled:false,
			grid_visible:true,
			grid_editable:true,
			width_grid:70,
			grid_indice:3
		},
		tipo:'TextField',
		filtro_0:true,
		save_as:'txt_hora',
		defecto:""
	};
   ///////// txt tipo_movimiento //////
	vectorAtributos[4]={
		validacion:{
			name:'tipo_movimiento',
			fieldLabel:'Tipo Movimiento',
			typeAhead:true,
			emptyText:'Movimiento...',
			loadMask:true,
			allowBlank:true,
			disabled:false,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','nombre'],data:[['Entrada','Entrada'],['Salida','Salida']]}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:120,
			grid_indice:4
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'tipo_movimiento',
		save_as:'txt_tipo_movimiento',
		defecto:""
	};
	/////////// txt aprobado //////
	vectorAtributos[5]={
		validacion:{
			name:'aprobado',
			fieldLabel:'Aprobado',
			allowBlank:true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:6	
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		save_as:'txt_aprobado',
		defecto:""
		};	
		vectorAtributos[6]={
		validacion:{
			name:'hora_marcada',
			fieldLabel:'Hora Marcada',
			allowBlank:true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:7	
		},
		form:false,
		tipo:'TextField',
		filtro_0:true
		};
			/////////// txt aprobado //////
	vectorAtributos[7]={
		validacion:{
			name:'tipo_marca',
			fieldLabel:'Tipo de Registro',
			allowBlank:true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:8	
		},
		form:false,
		tipo:'TextField',
		filtro_0:true
		};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	var config={titulo_maestro:'Resumen Marcas (Maestro)',titulo_detalle:'Marcas (Detalle)',grid_maestro:'grid-'+idContenedor};
		
	layout_marcas=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_marcas.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_marcas,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var getDialog=this.getDialog;
	var getForm=this.getFormulario;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_saveSuccess=this.saveSuccess;
	var ClaseMadre_eliminarSuccess=this.eliminarSucess;	
	var ClaseMadre_limpiar=this.limpiarStore;
	
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
		btnEliminar:{url:direccion+'../../../control/lectura_depurada/ActionEliminarLecturaDepurada.php',success:eliminarSuccess},
		Save:{url:direccion+'../../../control/lectura_depurada/ActionGuardarLecturaDepurada.php',success:Success},
		ConfirmSave:{url:direccion+'../../../control/lectura_depurada/ActionGuardarLecturaDepurada.php',success:Success},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:295,	//alto
		width:400,
		//minWidth:400,
		//minHeight:300,	
		closable:true,
		titulo:'Marcas Funcionario'}
	};	
	
	this.reload=function(m)
	{
			maestro=m;			
	       // console.log(maestro);
	        var fecha=maestro.fecha_resumen.dateFormat('m/d/Y');
	        //fecha.dateFormat('d/m/Y')
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_empleado:maestro.id_empleado,
					fecha_marca:fecha
				}
			};			
				
			this.btnActualizar();
			paramFunciones.btnEliminar.parametros='&txt_id_empleado='+maestro.id_empleado+'&txt_fecha='+fecha+'&resumen=si';
		    paramFunciones.Save.parametros='&txt_id_empleado_0='+maestro.id_empleado+'&txt_fecha_0='+fecha+'&resumen=si';
		    paramFunciones.ConfirmSave.parametros='&txt_id_empleado_0='+maestro.id_empleado+'&txt_fecha_0='+fecha+'&resumen=si';		
			this.InitFunciones(paramFunciones)
	};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		
		combo_observaciones=ClaseMadre_getComponente('observaciones');
		combo_tipo_movimiento=ClaseMadre_getComponente('tipo_movimiento');
		combo_turno=ClaseMadre_getComponente('turno');
		h_txt_hora=ClaseMadre_getComponente('hora');
		function opcion_obs(){
			if(combo_observaciones.getValue()=='Vacacion' || combo_observaciones.getValue()=='Comision de Viaje' || combo_observaciones.getValue()=='Comision Sindical' || combo_observaciones.getValue()=='Baja Medica' || combo_observaciones.getValue()=='Capacitacion' || combo_observaciones.getValue()=='Otro'){
				combo_tipo_movimiento.allowBlank=true;
				combo_tipo_movimiento.disable();
				combo_turno.enable();
				h_txt_hora.allowBlank=true;
				h_txt_hora.disable()
			}
			else{
			if (combo_observaciones.getValue()=='Ninguna'){
				combo_tipo_movimiento.allowBlank=false;
				combo_tipo_movimiento.enable();
				combo_tipo_movimiento.setValue('');
				combo_observaciones.setValue('');
				combo_turno.disable();
				combo_turno.reset();
				h_txt_hora.allowBlank=false;
				h_txt_hora.enable();
				h_txt_hora.setValue('')
			}
			}
		}
		//Define los eventos de los componentes para ejecutar acciones
		combo_observaciones.on('change',opcion_obs);
		combo_observaciones.on('select',opcion_obs)
		for(i=0;i<vectorAtributos.length;i++)
		{			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);			
		}
		sm=getSelectionModel();
	}	
	this.btnNew=function(){
		combo_tipo_movimiento.store.reload();
		combo_observaciones.store.reload();
		combo_tipo_movimiento.store.reload();
		combo_turno.store.reload();
	    h_txt_hora.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnNew();
		};

	
this.btnEdit=function(){
	    combo_tipo_movimiento.store.reload();
		combo_observaciones.store.reload();
		combo_tipo_movimiento.store.reload();
		combo_turno.store.reload();
	   	h_txt_hora.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnEdit()
	};
	this.SaveAndOther=function(){
	combo_tipo_movimiento.store.reload();
	combo_observaciones.store.reload();
	combo_tipo_movimiento.store.reload();
	combo_turno.store.reload();
	ClaseMadre_SaveAndOther()
	};		
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_marcas.getLayout()
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
	
	function eliminarSuccess(resp){
		//Ext.MessageBox.hide();
		//ClaseMadre_limpiar();
		ClaseMadre_eliminarSuccess(resp);
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
		
	};
	function Success(resp){	
	//Ext.MessageBox.hide();
	//this.dlgInfo.hide();
	//ClaseMadre_limpiar();
	ClaseMadre_saveSuccess(resp);
	_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
	};
	
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_marcas.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}