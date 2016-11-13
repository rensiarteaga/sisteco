/**
 * Nombre:		  	    pagina_resumen_marcas_dia.js
 * Propósito: 			pagina objeto principal
 * Autor:				Fernando Prudencio Cardona
 * Fecha creación:		11-08-2010
 */
function pagina_resumen_marcas_dia(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,ds_empleado;
	var elementos=new Array();
	var layout_resumen_marcas_dia;
	var marcas_html,div_dlgFrm,dlgFrm,FechaDesde,FechaHasta;
	var sw=0;
	var componentes=new Array;
	//---DATA STORE
	 ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/resumen_marcas_dia/ActionListarResumenMarcasDia.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_resumen_marcas_dia',totalRecords:'TotalCount'
		},[		
				'id_resumen_marcas_dia',
				{name: 'fecha_resumen',type:'date',dateFormat:'Y-m-d'},
				'horas_trabajadas',
				'horas_no_trabajadas',
				'horas_extra',
				'estado_reg',
				{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
				'id_empleado',
				'nombre_completo'
		
		]),remoteSort:true});
				//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});	

	 ds_empleado=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarFuncionario.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'
		},['id_empleado','id_persona','desc_persona'])
	}); 

	//FUNCIONES RENDER
	function render_id_empleado(val,cell,record,row,colum,store){if(record.get('estado_reg')=='aprobado'){return '<span style="color:red;font-size:8pt">' + record.data['nombre_completo']+ '</span>';}else {return record.data['nombre_completo'];}}
	function render_estado_reg(value)
	{
		if(value=='borrador'){value='Borrador'	}
		else if(value=='aprobado'){value='<span style="color:red;font-size:8pt">Aprobado</span>'	}
		return value
	}
	function color(val,cell,record,row,colum,store){
			if(record.get('estado_reg')=='aprobado'){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				return val;
			}
		}
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_columna_tipo
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_resumen_marcas_dia',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_resumen_marcas_dia'
	};
	
	// txt id_tipo_horario
	vectorAtributos[1]={
			validacion: {
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:true,			
			desc:'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			width:'100%',
			resizable:true,
			filterCol:'FUNCIO.desc_persona',
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.nombre_completo',
		defecto:'',
		save_as:'hidden_id_empleado'
	};
	
	// txt fecha_inicio
	vectorAtributos[2]= {	
		validacion:{
			name:'fecha_resumen',
			fieldLabel:'Fecha Resumen',
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
		filterColValue:'RESMARC.fecha_resumen',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_resumen'	
	};
	// txt fecha_inicio
	vectorAtributos[3]= {	
		validacion:{
			name:'horas_trabajadas',
			fieldLabel:'Horas Trabajadas',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			renderer:color, 
			width_grid:150,
			disabled:true
		},
		filtro_0:true,
		filtro_1:true,
		defecto:'00:00:00',
		tipo:'TextField',
		filterColValue:'RESMARC.horas_trabajadas',
		save_as:'txt_horas_trabajadas'	
	};
	// txt fecha_inicio
	vectorAtributos[4]= {	
		validacion:{
			name:'horas_no_trabajadas',
			fieldLabel:'Horas No Trabajadas',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			renderer:color,
			width_grid:150,
			disabled:true
		},
		filtro_0:true,
		filtro_1:true,
		defecto:'00:00:00',
		tipo:'TextField',
		filterColValue:'RESMARC.horas_no_trabajadas',
		save_as:'txt_horas_no_trabajadas'	
	};
	
	// txt horas_por_dia
	vectorAtributos[5]={
		validacion:{
			name:'horas_extra',
			fieldLabel:'Horas Extra',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer:color,
			width_grid:100,
			disabled:true
		},
		filtro_0:true,
		filtro_1:true,
		defecto:'00:00:00',
		tipo:'TextField',
		filterColValue:'RESMARC.horas_extra',
		save_as:'txt_horas_extra'
	};
	
	vectorAtributos[6]= {	
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
		filterColValue:'RESMARC.fecha_reg',
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_reg'	
	};
	// txt estado_reg
	vectorAtributos[7]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			renderer:render_estado_reg,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESMARC.estado_reg'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Resumen Marcas',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_control_asistencia/vista/marcas/marcas.php'};
	layout_resumen_marcas_dia=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_resumen_marcas_dia.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_resumen_marcas_dia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		nuevo:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/resumen_marcas_dia/ActionEliminarResumenMarcasDia.php'},
		Save:{url:direccion+'../../../control/resumen_marcas_dia/ActionGuardarResumenMarcasDia.php'},
		ConfirmSave:{url:direccion+'../../../control/resumen_marcas_dia/ActionGuardarResumenMarcasDia.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Resumen Marcas'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_resumen_marcas_dia.getIdContentHijo()).pagina.limpiarStore())
			{
				_CP.getPagina(layout_resumen_marcas_dia.getIdContentHijo()).pagina.bloquearMenu()
			}
		} )	
	}
	function InitPaginaResumenMarcasDias()
	{	for(var i=0; i<vectorAtributos.length; i++)
		{	componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)	}
	}
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		if(rec.data.estado_reg=='borrador'){
			               		CM_getBoton('resumen_marcas_dia-'+idContenedor).enable();
			               		CM_getBoton('desaprobar_resumen_marcas_dia-'+idContenedor).disable();
			               		_CP.getPagina(layout_resumen_marcas_dia.getIdContentHijo()).pagina.desbloquearMenu();
			               	}
			               	else{
			               		CM_getBoton('resumen_marcas_dia-'+idContenedor).disable();
			               		CM_getBoton('desaprobar_resumen_marcas_dia-'+idContenedor).enable();
			               		_CP.getPagina(layout_resumen_marcas_dia.getIdContentHijo()).pagina.bloquearMenu()
			               	}
		_CP.getPagina(layout_resumen_marcas_dia.getIdContentHijo()).pagina.reload(rec.data);
			
		
	}
	function btn_procesar_resumen(){					   
				dlgFrm.show()													   									 
	}
		function btn_resumen_marcas_dia(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de aprobar el resúmen de marcas del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_resumen_marcas_dia_0='+SelectionsRecord.data.id_resumen_marcas_dia;
				data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				data=data+'&txt_fecha_resumen_0='+SelectionsRecord.data.fecha_resumen.dateFormat('m/d/Y');
				
				data=data+'&txt_aprueba_0=si';
				Ext.Ajax.request({url:direccion+"../../../control/resumen_marcas_dia/ActionGuardarResumenMarcasDia.php",
			    params:data,
			    success:finaliza_aprobacion(1),
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			    ClaseMadre_btnActualizar();
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function btn_desaprobar_resumen_marcas_dia(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(confirm("Está seguro de desaprobar el resúmen de marcas del funcionario "+SelectionsRecord.data.nombre_completo+"?")){
				var data='cantidad_ids=1&hidden_id_resumen_marcas_dia_0='+SelectionsRecord.data.id_resumen_marcas_dia;
				data=data+'&hidden_id_empleado_0='+SelectionsRecord.data.id_empleado;
				data=data+'&txt_fecha_resumen_0='+SelectionsRecord.data.fecha_resumen.dateFormat('m/d/Y');
				data=data+'&txt_aprueba_0=no';
				Ext.Ajax.request({url:direccion+"../../../control/resumen_marcas_dia/ActionGuardarResumenMarcasDia.php",
			    params:data,
			    success:finaliza_aprobacion(2),
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			    ClaseMadre_btnActualizar();
			 }						
		}
	   else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro.')
	    }
	    ClaseMadre_clearSelections()
	}
	function finaliza_aprobacion(apro){
		if(apro==1){
		Ext.MessageBox.alert('Estado','El resumen de marcas se aprobó satisfactoriamente');	
		//ClaseMadre_btnActualizar();
		}
		else{
		Ext.MessageBox.alert('Estado','El resumen de marcas se desaprobó satisfactoriamente');	
		//ClaseMadre_btnActualizar();
		}
		 
	}
	function ProcesarResumen(){
		
		var txt_fecha_desde=FechaDesde.getValue();
		var txt_fecha_hasta=FechaHasta.getValue();
		var data="cantidad_ids=1&txt_fecha_desde_0="+txt_fecha_desde.dateFormat('m/d/Y');
			data=data+"&txt_fecha_hasta_0="+txt_fecha_hasta.dateFormat('m/d/Y');
			data=data+'&tipo_0=1';
			
			Ext.Ajax.request({url:direccion+"../../../control/resumen_marcas_dia/ActionGuardarResumenMarcasDia.php",
			    params:data,
			    success:finaliza_resumen,
			    method:'POST',
			    failure:ClaseMadre_conexionFailure,
			    timeout:100000});
			     Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});
			   
	}
	function finaliza_resumen(){
		dlgFrm.hide();
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado','El resumen se generó correctamente');
		 ClaseMadre_btnActualizar()
	}
	function crearDialogFechas(){
		marcas_html="<div class='x-dlg-hd'>"+'Rango de Fechas'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
		div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
		var Formulario=new Ext.form.Form({
			id:'frm_'+idContenedor,
			name:'frm_'+idContenedor,
			labelWidth:70 // label settings here cascade unless overridden
		});
		dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
			modal:true,
			labelWidth:70,
			width:250,
			height:170,
			closable:paramFunciones.Formulario.closable
		});
		dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);//tecla escape
		dlgFrm.addButton('Procesar',ProcesarResumen);
		dlgFrm.addButton('Cancelar',ocultarFrm);
		//creación de componentes
		FechaDesde=new Ext.form.DateField({
			name:'fecha_desde',
			fieldLabel:'Fecha Desde',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		FechaHasta=new Ext.form.DateField({
			name:'fecha_hasta',
			fieldLabel:'Fecha Hasta',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			renderer:formatDate,
			width_grid:100
		});
		
		Formulario.fieldset({legend:'Procesar Resúmen'},FechaDesde,FechaHasta);
		Formulario.render("form-ct2_"+idContenedor)
	}
	function ocultarFrm(){dlgFrm.hide()}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_resumen_marcas_dia.getLayout()
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
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Procesar Resúmen',btn_procesar_resumen,true,'procesar_resumen','Procesar Resúmen');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Aprobar Resúmen de Marcas',btn_resumen_marcas_dia,true,'resumen_marcas_dia','Aprobar Resúmen de Marcas');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Modificar Resúmen de Marcas',btn_desaprobar_resumen_marcas_dia,true,'desaprobar_resumen_marcas_dia','Modificar Resúmen de Marcas');
	var CM_getBoton=this.getBoton;
			CM_getBoton('resumen_marcas_dia-'+idContenedor).disable();
			CM_getBoton('desaprobar_resumen_marcas_dia-'+idContenedor).disable();

	this.iniciaFormulario();
	crearDialogFechas();
	InitPaginaResumenMarcasDias();
	iniciarEventosFormularios();
	layout_resumen_marcas_dia.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}