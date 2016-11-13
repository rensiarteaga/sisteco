/**
 * Nombre:		  	    pagina_procesar_solicitud_licencia.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_procesar_solicitud_licencia(idContenedor,direccion,paramConfig){
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_procesar_solicitud_licencia;
	var sw=0;
	var componentes=new Array;
	var g_tipo_contrato_proc='';
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/vacacion/ActionListarAprobarSolicitudLicencia.php?tipo=procesar'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_horario',totalRecords:'TotalCount'
		},[		
		'id_empleado',
		'nombre_completo',
		'id_tipo_horario',
		'nombre_tipo_horario',
		'id_vacacion',
		'id_empleado_aprobacion',
		'num_solicitud',
		'estado_reg'
		]),remoteSort:true});
	
	//DATA STORE COMBOS
      
	//FUNCIONES RENDER	
	function render_id_tipo_horario(value,p,record){return String.format('{0}',record.data['nombre_tipo_horario'])}
	function render_id_empleado(value,p,record){return String.format('{0}',record.data['nombre_completo'])}
	function render_estado_reg(value){
		if(value=='borrador'){value='Borrador'	}
		if(value=='pendiente_aprobacion'){value='Pendiente Aprobación'}
		if(value=='aprobado'){value='Aprobado'}
		if(value=='en_proceso'){value='En Proceso'}
		if(value=='reformulado'){value='Reformulado'}
		if(value=='finalizado'){value='Finalizado'}
		if(value=='inactivo'){value='Inactivo'}
		return value
	}
	// Definición de datos //		
	Atributos[0]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Solicitante',
			allowBlank:false,	
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'EMPLEA.nombre_completo'
	};
// txt id_gestion
	Atributos[1]={
			validacion:{
			name:'id_tipo_horario',
			fieldLabel:'Tipo Licencia',
			allowBlank:false,	
			renderer:render_id_tipo_horario,
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TIPHOR.nombre'
	};
	Atributos[2]={
		validacion:{
			labelSeparator:'',
			name:'id_vacacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false		
	};
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_aprobacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false		
	};
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name:'num_solicitud',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false		
	};
	Atributos[5]={
		validacion:{
			labelSeparator:'',
			name:'estado_reg',
			fieldLabel:'Estado',
			grid_visible:true,
			renderer:render_estado_reg, 
			grid_editable:false
		},
		tipo:'TextField',
		filtro_0:false		
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Vacaciones',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/vacacion/procesar_solicitud_licencia_det.php'};
	layout_procesar_solicitud_licencia=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_procesar_solicitud_licencia.init(config);
	
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_procesar_solicitud_licencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		//guardar:{crear:true,separador:false},
	    //nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		//btnEliminar:{url:direccion+'../../../control/horario/ActionEliminarHorario.php'},
		//Save:{url:direccion+'../../../control/horario/ActionGuardarHorario.php'},
		//ConfirmSave:{url:direccion+'../../../control/horario/ActionGuardarHorario.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Reformula Solicitud'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.limpiarStore())
			{
				//_CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.limpiarStore();
				_CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu()
			}
			
		} )	
	}
	this.EnableSelect=function(sm,row,rec){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		cm_EnableSelect(sm,row,rec);
		
		 _CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.desbloquearMenu();
		_CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.reload(rec.data);
		enable(sm,row,rec);		
	}
	function btn_procesar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de procesar la solicitud del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_vacacion_0='+SelectionsRecord.data.id_vacacion;
				    data=data+'&hidden_id_tipo_horario_0='+SelectionsRecord.data.id_tipo_horario;
				    data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				    data=data+'&hidden_id_empleado_aprobacion_0='+SelectionsRecord.data.id_empleado_aprobacion;
				    data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
				    data=data+'&tipo=procesa';
				Ext.Ajax.request({url:direccion+"../../../control/vacacion/ActionAprobarSolicitudLicenciaDet.php",
			    params:data,
			    success:finaliza_proceso,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function btn_finaliza(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de finalizar la solicitud del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_vacacion_0='+SelectionsRecord.data.id_vacacion;
				    data=data+'&hidden_id_tipo_horario_0='+SelectionsRecord.data.id_tipo_horario;
				    data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				    data=data+'&hidden_id_empleado_aprobacion_0='+SelectionsRecord.data.id_empleado_aprobacion;
				    data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
				    data=data+'&tipo=finaliza';
				Ext.Ajax.request({url:direccion+"../../../control/vacacion/ActionAprobarSolicitudLicenciaDet.php",
			    params:data,
			    success:finaliza_vacacion,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function btn_reformular(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de finalizar la solicitud del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_vacacion_0='+SelectionsRecord.data.id_vacacion;
				    data=data+'&hidden_id_tipo_horario_0='+SelectionsRecord.data.id_tipo_horario;
				    data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				    data=data+'&hidden_id_empleado_aprobacion_0='+SelectionsRecord.data.id_empleado_aprobacion;
				    data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
				    data=data+'&tipo=reformula';
				Ext.Ajax.request({url:direccion+"../../../control/vacacion/ActionAprobarSolicitudLicenciaDet.php",
			    params:data,
			    success:finaliza_vacacion,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function btn_finaliza_reformular(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de finalizar la solicitud del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_vacacion_0='+SelectionsRecord.data.id_vacacion;
				    data=data+'&hidden_id_tipo_horario_0='+SelectionsRecord.data.id_tipo_horario;
				    data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				    data=data+'&hidden_id_empleado_aprobacion_0='+SelectionsRecord.data.id_empleado_aprobacion;
				    data=data+'&m_num_solicitud='+SelectionsRecord.data.num_solicitud;
				    data=data+'&tipo=finaliza_reformular';
				Ext.Ajax.request({url:direccion+"../../../control/vacacion/ActionAprobarSolicitudLicenciaDet.php",
			    params:data,
			    success:finaliza_vacacion,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function finaliza_proceso(){
		Ext.MessageBox.alert('Estado','La vacación se inició satisfactoriamente');
		 ClaseMadre_btnActualizar();
		 
	}	
	function finaliza_vacacion(){
		Ext.MessageBox.alert('Estado','La vacación se finalizó satisfactoriamente');
		 ClaseMadre_btnActualizar();
		 
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_procesar_solicitud_licencia.getLayout()
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
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Procesar Licencia',btn_procesar,true,'procesar_solicitud','Procesar Licencia');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Reformular Licencia',btn_reformular,true,'reformular_solicitud','Reformular Licencia');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Finalizar Reformulación',btn_finaliza_reformular,true,'finaliza_reformular_solicitud','Finalizar Reformulación');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Finalizar Licencia',btn_finaliza,true,'finaliza_vacacion','Finaliza Licencia');
	var CM_getBoton=this.getBoton;
	function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){ 
				   if(record.estado_reg=='en_proceso'){
				   	CM_getBoton('reformular_solicitud-'+idContenedor).enable();
				   	CM_getBoton('finaliza_reformular_solicitud-'+idContenedor).disable();
				   	CM_getBoton('procesar_solicitud-'+idContenedor).disable();
				   	_CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu();
				   	CM_getBoton('finaliza_vacacion-'+idContenedor).enable();
				   }
				   else{
				   	if(record.estado_reg=='aprobado'){
				   	  CM_getBoton('reformular_solicitud-'+idContenedor).disable();
				   	  CM_getBoton('finaliza_reformular_solicitud-'+idContenedor).disable();
				   	  CM_getBoton('procesar_solicitud-'+idContenedor).enable();
				   	  _CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu();
				   	  CM_getBoton('finaliza_vacacion-'+idContenedor).disable();	
				   	}
				   	else{
				   		if(record.estado_reg=='reformulado'){
				   			CM_getBoton('reformular_solicitud-'+idContenedor).disable();
				   			CM_getBoton('finaliza_reformular_solicitud-'+idContenedor).enable();
				   			_CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.desbloquearMenu()
				   	        CM_getBoton('procesar_solicitud-'+idContenedor).disable();
				   	        CM_getBoton('finaliza_vacacion-'+idContenedor).disable();
				   		}
				   		else{
				   			CM_getBoton('reformular_solicitud-'+idContenedor).disable();
				   			CM_getBoton('finaliza_reformular_solicitud-'+idContenedor).disable();
				   	        CM_getBoton('procesar_solicitud-'+idContenedor).disable();
				   	        _CP.getPagina(layout_procesar_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu()
				   	        CM_getBoton('finaliza_vacacion-'+idContenedor).disable();
				   		}
				   	}
				   	 }
				}

				cm_EnableSelect(sel,row,selected);
			}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	var tipo_contrato_proc =new Ext.form.ComboBox({
			typeAhead: true,
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['planta','Planta'],['otros','Otros']]}),
			valueField:'ID',
			displayField:'valor',
			triggerAction:'all',
			emptyText:'tipo contrato...',
			selectOnFocus:true,
			width:100
		});
  tipo_contrato_proc.on('select',function (combo, record, index){g_tipo_contrato_proc=tipo_contrato_proc.getValue();
  	//carga datos XML
  ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_tipo_contrato_proc:g_tipo_contrato_proc
		}
	});	
  });
  this.AdicionarBotonCombo(tipo_contrato_proc,'tipo_contrato_proc');
	layout_procesar_solicitud_licencia.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}