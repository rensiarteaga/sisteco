/**
 * Nombre:		  	    pagina_solicitud_licencia_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-17 09:25:59
 */
function pagina_solicitud_licencia_det(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var elementos=new Array();
	var componentes=new Array;
	var marcas_html,div_dlgFrm,dlgFrm,FechaDesde,FechaHasta,PeriodoAdelantado,ObservacionesAdelantado;
	var marcas_html_1,div_dlgFrm_1,dlgFrm_1,GenerarReporte,TipoLicencia;
	var layout_solicitud_licencia_det;
	var maestro=new Array();
	var data;
	var sw=0;
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/vacacion/ActionListarSolicitudLicenciaDet.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_horario',totalRecords:'TotalCount'
		},[		
		'id_horario',
		'id_tipo_horario',
		'nombre_tipo_horario',
		'id_vacacion',
		{name:'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'tipo_periodo',
		'horas_por_dia',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		'estado_reg',
		'id_empleado_aprobacion',
		'nombre_completo',
		'repite_anualmente'
		]),remoteSort:true});
	//DATA STORE COMBOS
	var ds_tipo_horario=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/tipo_horario/ActionListarTipoHorario.php?tipo=licencia'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_horario',totalRecords: 'TotalCount'},['id_tipo_horario','codigo','nombre'])
	});
	//FUNCIONES RENDER
	function render_id_tipo_horario(value,p,record){return String.format('{0}',record.data['nombre_tipo_horario'])}
	function render_id_empleado_aprobacion(value,p,record){return String.format('{0}',record.data['nombre_completo'])}
	var tpl_id_tipo_horario=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','<b><br>Codigo: </b><FONT COLOR="#B5A642">{codigo}</FONT>','</div>'); //
	function render_estado_reg(value){
		if(value=='borrador'){value='Borrador'	}
		if(value=='pendiente_aprobacion'){value='Pendiente Aprobación'}
		if(value=='aprobado'){value='Aprobado'}
		if(value=='en_proceso'){value='En Proceso'}
		if(value=='finalizado'){value='Finalizado'}
		if(value=='inactivo'){value='Inactivo'}
		return value
	} 
	function render_tipo_periodo(value){
		if(value=='dia_completo'){value='Dia Completo'}
		else{
			if(value=='manana'){value='Mañana'}
		    else{value='Tarde'} }
		return value
	}
	function render_adelanta(value){
		if(value=='si'){value='Si'}
		else{
		    value='No' }
		return value
	} 
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_vacacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_horario',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false		
	};
// txt id_gestion
	Atributos[1]={
			validacion:{
			name:'id_tipo_horario',
			fieldLabel:'Tipo Licencia',
			allowBlank:false,	
			emptyText:'Tipo Licencia...',
			desc:'nombre_tipo_horario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_horario,
			valueField:'id_tipo_horario',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'TIPHOR.nombre#TIPHOR.codigo',
			typeAhead:false,			
			tpl:tpl_id_tipo_horario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_horario,
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'ComboBox',
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
	Atributos[3]= {	
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
		    renderer:formatDate,
			width_grid:100
		},
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.fecha_inicio',
		tipo:'DateField',
		dateFormat:'m-d-Y'
	};
	
// txt total_dias
	Atributos[4]= {	
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
		    renderer:formatDate,
			width_grid:100
		},
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.fecha_fin',
		tipo:'DateField',
		dateFormat:'m-d-Y'
	};
	Atributos[5]={
			validacion: {
			name:'tipo_periodo',
			fieldLabel:'Periodo',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['dia_completo','Dia Completo'],['manana','Mañana'],['tarde','Tarde']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			renderer:render_tipo_periodo,
			width_grid:150,
			disabled:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'HORARI.tipo_periodo'
	};
	Atributos[6]={
		validacion:{
			name:'horas_por_dia',
			fieldLabel:'Total Dias',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
			},
			form:false,
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'HORARI.horas_por_dia'
	};
	Atributos[7]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:255,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'HORARI.observaciones'
	};
	Atributos[8]={
		validacion:{
			name:'estado_reg',			
			fieldLabel:'Estado',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer:render_estado_reg,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'HORARI.estado_reg'
	};
	Atributos[9]= {	
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
		filterColValue:'HORARI.fecha_reg',
		tipo:'DateField',
		dateFormat:'m-d-Y'	
	};
	Atributos[10]={
		validacion:{
			name:'id_empleado_aprobacion',			
			fieldLabel:'Aprobador',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_empleado_aprobacion,
			width_grid:200
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.nombre_completo'
	};
	Atributos[11]={
		validacion:{
			name:'repite_anualmente',
			fieldLabel:'Adelanto',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer:render_adelanta,
			width_grid:100
			},
			form:false,
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'HORARI.repite_anualmente'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vacación',grid_maestro:'grid-'+idContenedor};
	layout_solicitud_licencia_det=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_solicitud_licencia_det.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_licencia_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_saveSuccess=this.saveSuccess;
	var ClaseMadre_eliminarSuccess=this.eliminarSucess;
	var CMenableSelect=this.EnableSelect;
	var getDialog=this.getDialog;
	var getForm=this.getFormulario;
	var ClaseMadre_limpiar=this.limpiarStore;	
	var ClaseMadre_clearSelections=this.clearSelections;
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
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/vacacion/ActionEliminarSolicitudLicenciaDet.php',success:eliminarSuccess},
		Save:{url:direccion+'../../../control/vacacion/ActionGuardarSolicitudLicenciaDet.php',success:Success},
		ConfirmSave:{url:direccion+'../../../control/vacacion/ActionGuardarSolicitudLicenciaDet.php',success:Success},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Solicitud Licencia'}
	};
		
	this.reload=function(m)
	{
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_vacacion:maestro.id_vacacion
			}
		};
		this.btnActualizar();
		//data_maestro=[['Nro.Documento',maestro.nro_documento],['Razón social',maestro.razon_social],['Fecha documento',maestro.fecha_documento],['Importe factura',maestro.importe_total],['Moneda',maestro.desc_moneda]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[2].defecto=maestro.id_vacacion;
		paramFunciones.btnEliminar.parametros='&m_id_vacacion='+maestro.id_vacacion;
		paramFunciones.Save.parametros='&m_id_vacacion='+maestro.id_vacacion;
		paramFunciones.ConfirmSave.parametros='&m_id_vacacion='+maestro.id_vacacion;			
		
		this.InitFunciones(paramFunciones);
	};	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	for(i=0;i<Atributos.length;i++)
		{			
			componentes[i]=getComponente(Atributos[i].validacion.name);			
		}
		sm=getSelectionModel();
	}
	function btn_finaliza_solicitud()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de finalizar su solicitud?")){
				var data='cantidad_ids=1&hidden_id_horario_0='+SelectionsRecord.data.id_horario;
				    data=data+'&m_id_vacacion='+maestro.id_vacacion;
				    data=data+'&tipo=solicitud';
				Ext.Ajax.request({url:direccion+"../../../control/vacacion/ActionFinalizaSolicitudLicencia.php",
			    params:data,
			    success:finaliza_aprobacion,
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
	function finaliza_aprobacion(){
		Ext.MessageBox.alert('Estado','La solicitud se envió para su aprobación');
		 ClaseMadre_btnActualizar();
		 
	}
	function btn_adelanta_solicitud(){					   
		   dlgFrm.show()											   									 
	}
	function SolicitarAdelanto(){
		
			var txt_fecha_desde=FechaDesde.getValue();
		    var txt_fecha_hasta=FechaHasta.getValue();
		    var txt_periodo=PeriodoAdelantado.getValue();
		    var txt_observaciones=ObservacionesAdelantado.getValue();
		    var txt_id_vacacion=maestro.id_vacacion;
			var data='txt_fecha_desde_0='+txt_fecha_desde.dateFormat('m/d/Y');
			data=data+'&txt_fecha_hasta_0='+txt_fecha_hasta.dateFormat('m/d/Y');
			data=data+'&txt_periodo_0='+txt_periodo;
			data=data+'&txt_observaciones_0='+txt_observaciones;
			data=data+'&txt_id_vacacion_0='+txt_id_vacacion;			
			Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/vacacion/ActionGuardarAdelantaLicencia.php?"+data,
						success:adelanta_licencia,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:350,
					height:350,
					closable:false
				});
		
	}	
		
	function adelanta_licencia(){
		Ext.MessageBox.alert('Estado','Se realizó la solicitud de adelanto de licencia');
		ocultarFrm();
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
		 ClaseMadre_btnActualizar();
		 
	}
	function crearDialogAdelantoLic(){
		marcas_html="<div class='x-dlg-hd'>"+'Adelanto de Licencia'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:100 // label settings here cascade unless overridden
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:100,
			width:450,
			height:300,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm.addButton('Guardar',SolicitarAdelanto);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		//creación de componentes
		FechaDesde=new Ext.form.DateField({
			name:'fecha_desde',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		FechaHasta=new Ext.form.DateField({
			name:'fecha_hasta',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		PeriodoAdelantado=new Ext.form.ComboBox({
			name:'periodo_adelantado',
			fieldLabel:'Periodo',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['dia_completo','Dia Completo'],['manana','Mañana'],['tarde','Tarde']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width_grid:100
		});
		ObservacionesAdelantado=new Ext.form.TextArea({
			name:'observaciones_adelantado',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:255,
			minLength:0,
			width_grid:100
		});
		
		Formulario.fieldset({legend:'Adelanto de Licencias'},FechaDesde,FechaHasta,PeriodoAdelantado,ObservacionesAdelantado);
		Formulario.render("form-ct2_"+idContenedor)
	}
	
	function btn_rep_res_sol()
	{	
		dlgFrm_1.show();
	}
	
	function generaReporteLic()
	{		
		marcas_html_1 = "<div class='x-dlg-hd'>"+'Resúmen Solicitud'+"</div><div class='x-dlg-bd'><div id='form-ct3_"+idContenedor+"'></div></div>";
		div_dlgFrm_1 = Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm_1'+idContenedor,html:marcas_html_1});
		var Formulario= new Ext.form.Form({
			id:'frm_1'+idContenedor,
			name:'frm_1'+idContenedor,
			labelWidth:100 // label settings here cascade unless overridden
		});
		
		dlgFrm_1=new Ext.BasicDialog(div_dlgFrm_1,{
			modal:true,
			labelWidth:100,
			width:330,
			height:150,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm_1.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm_1.addButton('Generar',GenerarReporte);
		dlgFrm_1.addButton('Cancelar',ocultarRep);
		
		TipoLicencia=new Ext.form.ComboBox({
			name:'tipo_licencia',
			fieldLabel:'Tipo Licencia',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['3','Vacación'],['4','Compensación']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			defecto: 'Vacación',
			width_grid:100
		});
		
		Formulario.fieldset({legend:'Resúmen'},TipoLicencia);
		Formulario.render("form-ct3_"+idContenedor)
	}
	
	function GenerarReporte()
	{		
		var txt_tipo_licencia = TipoLicencia.getValue();
		var txt_id_vacacion = maestro.id_vacacion;
		var data='&txt_tipo_licencia_0='+txt_tipo_licencia;				
		data=data+'&txt_id_vacacion_0='+txt_id_vacacion;			
		Ext.Ajax.request({
			url:direccion+"../../../control/vacacion/ActionPDFResumenSolicitud.php?"+data,
			success:generar_reporte,
			failure:ClaseMadre_conexionFailure,
			timeout:paramConfig.TiempoEspera
			});
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando...</div>",
			width:350,
			height:350,
			closable:false
		});		
	}
	
	function generar_reporte()
	{
		window.open(direccion+'../../../vista/vacacion/PDFResumenSolicitud.php');
		Ext.MessageBox.alert('Estado','El reporte se generó correctamente');
		ocultarRep();
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
		ClaseMadre_btnActualizar();
	}
	
	function ocultarRep()
	{
		dlgFrm_1.hide();
	}
	
	function ocultarFrm(){dlgFrm.hide()}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_licencia_det.getLayout()};
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
	this.EnableSelect=function(sm,row,rec){
					enable(sm,row,rec);
			}
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	function eliminarSuccess(resp){
		ClaseMadre_eliminarSuccess(resp);
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
		
	};
	function Success(resp){	
	ClaseMadre_saveSuccess(resp);
	_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
	};
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Finalizar Solicitud',btn_finaliza_solicitud,true,'finaliza_solicitud','Finalizar Solicitud');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Adelantar días',btn_adelanta_solicitud,true,'adelanta_solicitud','Adelantar días');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Listar Solicitudes',btn_rep_res_sol,true,'listar_solicitudes','Listar Solicitudes');
	var CM_getBoton=this.getBoton;
	this.BotonAdelanta=function (tipo){
		if(tipo==0){
		  CM_getBoton('adelanta_solicitud-'+idContenedor).disable();	
		}
		else{
			CM_getBoton('adelanta_solicitud-'+idContenedor).enable();	
		}
	}
	function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
					
				   if(record.estado_reg=='borrador'){
				   	CM_getBoton('finaliza_solicitud-'+idContenedor).enable();
				   	CM_getBoton('guardar-'+idContenedor).enable();
		            CM_getBoton('eliminar-'+idContenedor).enable();
	                CM_getBoton('editar-'+idContenedor).enable();
				   }
				   else{
				   	CM_getBoton('finaliza_solicitud-'+idContenedor).disable();
				   	CM_getBoton('guardar-'+idContenedor).disable();
		            CM_getBoton('eliminar-'+idContenedor).disable();
	                CM_getBoton('editar-'+idContenedor).disable();
				   	 }
				   	 
				}

				CMenableSelect(sel,row,selected);
			}
	this.iniciaFormulario();
	crearDialogAdelantoLic();
	generaReporteLic();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_solicitud_licencia_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}