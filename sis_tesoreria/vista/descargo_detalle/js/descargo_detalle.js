/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_descargo_detalle(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var cmp_aprobador,cmp_tipo_avance,cmp_fecha_avance;
	var cmp_importe_avance,cmp_tipo_documento,cmp_nro_documento;
	//  DATA STORE //
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/avance/ActionListarDescargoDetalle.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_avance',
			totalRecords:'TotalCount'
		}, [
		'id_avance',
		'tipo_avance',
		{name:'fecha_avance',type:'date',dateFormat:'Y-m-d'},
		'importe_avance',
		'estado_avance',
		'id_moneda',
		'nombre_moneda',
		'id_documento',
		'tipo_documento',
		'nro_documento',
		{name:'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'codigo_control',
		'fk_avance',
		'importe_detalle',
		'sw_valida',
		'id_usuario_aprueba',
		'aprobador',
		'id_presupuesto',
		'id_unidad_organizacional',
		'id_usr_reg',
		'id_empleado_reg',
		'id_depto'
		]),remoteSort:true
	});
	// Definición de datos //
	var ds_usuario_aprueba=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php?sw_autoriza=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional','sw_responsable'])
	});
	function render_id_usuario_aprueba(value,p,record){return String.format('{0}', record.data['aprobador']);}
	var tpl_id_usuario_aprueba=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><B><I>{desc_usuario}</I></B></FONT><br>','<FONT COLOR="#B5A642">Unidad:{desc_unidad_organizacional}</FONT>','</div>');
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_avance',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_avance'
	};
	// txt tipo_avance
	Atributos[1]={
		validacion:{
			name:'tipo_avance',
			fieldLabel:'Tipo Avance',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width:150
		},
		tipo:'NumberField',
		form:false,
		save_as:'tipo_avance'
	};
		// txt id_usuario_aprueba
	Atributos[2]={
			validacion:{
			name:'id_usuario_aprueba',
			fieldLabel:'Aprobado por',
			allowBlank:false,			
			emptyText:'Aprobador...',
			desc:'aprobador', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_aprueba,
			valueField:'id_usuario_autorizado',
			displayField:'desc_usuario',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_usuario_aprueba,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario_aprueba,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'95%',
			disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usuario_aprueba'
	};
	// txt fecha_avance
	Atributos[3]={
		validacion:{
			name:'fecha_avance',
			fieldLabel:'Fecha Descargo',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:95
		},

		tipo:'DateField',
		filtro_0:true,
		filterColValue:'AVANCE.fecha_avance',
		dateFormat:'m-d-Y',
		save_as:'fecha_avance'
	};
	// txt estado_avance
	Atributos[4]={
		validacion:{
			name:'estado_avance',
			fieldLabel:'Estado Avance',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Pendiente'],['2','Descargo'],['3','Cerrado']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			width:150
		},
		tipo:'ComboBox',
		form:false,
		save_as:'estado_avance'
	};
	// txt id_moneda
	Atributos[5]={
		validacion:{
			name:'nombre_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	// txt importe_avance
	Atributos[6]={
		validacion:{
			name:'importe_avance',
			fieldLabel:'Importe Descargo',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:115,
			width:100,
			disabled:false
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'AVANCE.importe_avance',
		save_as:'importe_avance'
	};
	Atributos[7]={
		validacion:{
			labelSeparator:'',
			name:'id_documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};
	// txt id_moneda
	Atributos[8]={
		validacion:{
			name:'tipo_documento',
			fieldLabel:'Documento',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			renderer:formatDocumento,
			width_grid:90
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.tipo_documento',
		save_as:'tipo_documento'
	};
	// txt id_moneda
	Atributos[9]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nro Documento',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento',
		save_as:'nro_documento'
	};
	// txt fecha_avance
	Atributos[10]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:105
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y',
		save_as:'fecha_documento'
	};
	Atributos[11]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razón Social',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		save_as:'razon_social'
	};
	Atributos[12]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'Nit',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit',
		save_as:'nro_nit'
	};
	Atributos[13]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Número de Autorización',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:140
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	Atributos[14]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:115
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control',
		save_as:'codigo_control'
	};
	// txt fk_avance
	Atributos[15]={
		validacion:{
			labelSeparator:'',
			name:'fk_avance',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'fk_avance'
	};
	// importe_detalle
	Atributos[16]={
		validacion:{
			name:'importe_detalle',
			fieldLabel:'Importe Detalle',
			allowBlank:true,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width:150
		},
		tipo:'NumberField',
		form:false,
		save_as:'importe_detalle'
	};
	/////////// txt sw_valida //////
	Atributos[17]={
		validacion:{
			name:'sw_valida',
			fieldLabel:'Aprobado',
			checked:false,
			renderer:formatValida,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:70
		},
		tipo:'Checkbox',
		save_as:'sw_valida'
	};
Atributos[18]={
		validacion:{
			labelSeparator:'',
			name:'id_presupuesto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_presupuesto'
	};
	Atributos[19]={
		validacion:{
			labelSeparator:'',
			name:'id_unidad_organizacional',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_unidad_organizacional'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function formatDocumento(value){
		if(value==1) return "Compra con Crédito Fiscal";
		if(value==15) return "Compra con Crédito Fiscal Proyectos";
		if(value==16) return "Proforma de Facturas";
		if(value==4) return "Compra sin Crédito Fiscal";
		if(value==8) return "Sin Retenciones";
		if(value==9) return "Retenciones Bienes";
		if(value==10) return "Retenciones Servicios";
		else return "Recibo";
	};
	function formatValida(value){
		if (value==1) return 'Si';
		else return 'No'
	};
	tituloM='Descargo';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Descargo (Maestro)',titulo_detalle:'Detalle de Descargo (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_descargo_detalle= new DocsLayoutMaestro(idContenedor);
	layout_descargo_detalle.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_descargo_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var dialog= this.getFormulario;
	var EstehtmlMaestro=this.htmlMaestro;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/avance/ActionEliminarDescargoDetalle.php'},
		Save:{url:direccion+'../../../control/avance/ActionGuardarDescargoDetalle.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,columnas:[400],
					width:440,minWidth:350,minHeight:200,closable:true,titulo:'Aprobador'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		// alert (maestro.id_avance);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_avance:maestro.id_avance
			}
		};
		this.btnActualizar();
		m_id_avance=maestro.id_avance;
		m_id_moneda=maestro.id_moneda;
		m_importe_avance=maestro.importe_avance;
		paramFunciones.btnEliminar.parametros='&m_id_avance='+maestro.id_avance;
		this.InitFunciones(paramFunciones)
	};
	//Para manejo de eventos
	this.EnableSelect=function(x,z,y){
				enable(x,z,y)	
			};
	function iniciarEventosFormularios(){
		txt_sw_valida=getComponente('sw_valida');
		cmp_aprobador=getComponente('id_usuario_aprueba');
		cmp_tipo_avance=getComponente('tipo_avance');
		cmp_fecha_avance=getComponente('fecha_avance');
		cmp_importe_avance=getComponente('importe_avance');
		cmp_tipo_documento=getComponente('tipo_documento');
		cmp_nro_documento=getComponente('nro_documento');
	}
	this.btnEliminar=function(){
		if(txt_sw_valida.getValue()==1){
			Ext.MessageBox.alert('ESTADO', 'No se puede eliminar porque el documento ya fue aprobado.');
		}
		else{
			CM_btnEliminar()
		}
	};
	function btn_documento(){
		var data='m_nombre_tabla=tesoro.tts_avance';
		data=data+'&m_nombre_campo=fk_avance';
		data=data+'&m_id_tabla='+m_id_avance;
		data=data+'&m_id_moneda='+m_id_moneda;
		data=data+'&m_importe='+m_importe_avance;
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			alert('existe documento')
			var SelectionsRecord=sm.getSelected();
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
		}
		else{
			alert('entra al else')
		}
		var ParamVentana={Ventana:{width:450,height:400}};
		alert('data:'+data)
		layout_descargo_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
	}
	function btn_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.sw_valida==1){
				Ext.MessageBox.alert('ESTADO', 'El Documento ya fue aprobado.');
			}
			else{
				var data='m_id_avance='+SelectionsRecord.data.id_avance;
				data=data+'&m_fecha_avance='+SelectionsRecord.data.fecha_avance;
				data=data+'&m_importe_avance='+SelectionsRecord.data.importe_avance;
				data=data+'&m_id_empleado_reg='+SelectionsRecord.data.id_empleado_reg;
				data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
				var ParamVentana={Ventana:{width:'50%',height:'60%'}}
				layout_descargo_detalle.loadWindows(direccion+'../../../../sis_tesoreria/vista/avance_detalle/avance_detalle.php?'+data,'Detalle',ParamVentana);
			}
		}
		else
		{
			Ext.MessageBox.alert('ESTADO', 'Antes debe seleccionar un Documento.');
		}
	}
	function btn_aprobar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.sw_valida==1){
				Ext.MessageBox.alert('ESTADO','El Documento ya fue aprobado.');
			}
			else{
				if(SelectionsRecord.data.razon_social=='Solicitud Adquisiciones'){
					Ext.MessageBox.alert('ESTADO', 'Debe completar los datos del documento antes de aprobar.');
				}
				else{				   
				    if(SelectionsRecord.data.importe_avance==SelectionsRecord.data.importe_detalle){
                      CM_ocultarTodosComponente();
                      CM_mostrarComponente(cmp_aprobador);
                      CM_btnEdit()				
				      }
				    else{
					  Ext.MessageBox.alert('ESTADO', 'La suma del importe de los detalles debe ser igual al importe del documento.');
				     }	
				}
			}
		}
		else
		{
			Ext.MessageBox.alert('ESTADO','Antes debe seleccionar un Documento.');
		}
	}
	function btn_cambio_aprobador(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
							   
				    if(SelectionsRecord.data.importe_avance==SelectionsRecord.data.importe_detalle){
                      CM_ocultarTodosComponente();
                      CM_mostrarComponente(cmp_aprobador);
                      CM_btnEdit()				
				      }
				    else{
					  Ext.MessageBox.alert('ESTADO', 'La suma del importe de los detalles debe ser igual al importe del documento.');
				     }	
				
			
		}
		else
		{
			Ext.MessageBox.alert('ESTADO','Antes debe seleccionar un Documento.');
		}
	}
	//####################################################
	//################################# RCM 18/03/2009 ###
	//####################################################
	
	function btn_doc_nuevo(){
		var data='m_nombre_tabla=tesoro.tts_avance';
		data=data+'&m_nombre_campo=fk_avance';
		data=data+'&m_id_tabla='+m_id_avance;
		data=data+'&m_id_moneda='+m_id_moneda;
		data=data+'&m_id_documento=0';
		data=data+'&m_importe='+m_importe_avance;
		data=data+'&m_nuevo=si';
		var ParamVentana={Ventana:{width:450,height:400}};
		layout_descargo_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
	}
	function btn_doc_editar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){			
			var SelectionsRecord=sm.getSelected();
			if (SelectionsRecord.data.id_usuario_aprueba >= 1){
				Ext.MessageBox.alert('Estado', 'No se puede editar el documento porque ya se aprobó.');
			}
			else{
				var data='m_nombre_tabla=tesoro.tts_avance';
			        data=data+'&m_nombre_campo=fk_avance';
					data=data+'&m_id_tabla='+SelectionsRecord.data.id_avance;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
					data=data+'&m_importe='+maestro.importe_avance;
					var ParamVentana={Ventana:{width:450,height:400}};
					layout_descargo_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
			}
			
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btn_doc_del(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			if (sm.getSelected().data.id_usuario_aprueba > 1){
				Ext.MessageBox.alert('Estado', 'No se puede eliminar el documento porque ya se aprobó.');
			}
			else{
			   var id_documento=sm.getSelected().data.id_documento;
			if(id_documento!=undefined&&id_documento!=''){
				//alert('id_documento:'+id_documento);
				data='id_documento='+id_documento+'&nombre_tabla=tesoro.tts_avance&nombre_campo=id_avance&id_tabla='+sm.getSelected().data.id_avance;
				if(confirm('¿Está seguro de eliminar el Documento?')){
					Ext.Ajax.request({
						url:direccion+'../../../../sis_contabilidad/control/documento/ActionEliminarDocumento.php?'+data,
						method:'GET',
						success:exito_doc_del,
						failure:Cm_conexionFailure,
						timeout:100000
					})}
			}
			else{
				Ext.MessageBox.alert('Estado','Documento inexistente')
			}	
			}			
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	function exito_doc_del(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado','Documento eliminado');
		CM_btnActualizar()
	}			
	//########################################
	//#################################FIN RCM
	//########################################
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_descargo_detalle.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBoton('../../../lib/imagenes/nuevo.png','<b>Nuevo</b>',btn_doc_nuevo,false,'new','');
	this.AdicionarBoton('../../../lib/imagenes/editar.png','<b>Editar</b>',btn_doc_editar,false,'edit','');
	this.AdicionarBoton('../../../lib/imagenes/eliminar.png','<b>Eliminar</b>',btn_doc_del,false,'delete','');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Detalle',btn_detalle,true,'detalle','Detalle');
	this.AdicionarBoton('../../../lib/imagenes/ok.png',' Aprobar Documento',btn_aprobar,true,'aprobar','Aprobar Documento');
	this.AdicionarBoton('../../../lib/imagenes/cambio_ap.png',' Modificar Aprobador',btn_cambio_aprobador,true,'cambio_aprobador','Modificar Aprobador');
	var CM_getBoton=this.getBoton;
			CM_getBoton('detalle-'+idContenedor).disable();
			CM_getBoton('aprobar-'+idContenedor).disable();
			CM_getBoton('cambio_aprobador-'+idContenedor).disable();
			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
			        if(record.sw_valida==1){
			               	CM_getBoton('detalle-'+idContenedor).disable();
			                CM_getBoton('aprobar-'+idContenedor).disable();
			                CM_getBoton('cambio_aprobador-'+idContenedor).enable();
			               }
			               else{
			               	CM_getBoton('cambio_aprobador-'+idContenedor).disable();
			               	if(record.importe_avance==record.importe_detalle){			               		
                            	CM_getBoton('detalle-'+idContenedor).enable();
                            	CM_getBoton('aprobar-'+idContenedor).enable();                           			                    
                            }
                            else{
                            	CM_getBoton('detalle-'+idContenedor).enable();
			                    CM_getBoton('aprobar-'+idContenedor).disable();
                            }
			               }			               
				}
				enableSelect(sel,row,selected);				
			}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_descargo_detalle.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}