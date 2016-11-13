/**
* Nombre:		  	    pagina_devengado_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:43:29
*/
function pagina_devengado_dcto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var v_porcentaje_devengado,v_importe_devengado,cmb_porc_mon,v_con_ep,v_ep='';
	var data;

	//maestro.solo_lectura: 1 sólo lectura
	//						0 no de sólo lectura

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/devengado_dcto/ActionListarDevengadoDcto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_devengado_dcto',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_devengado_dcto',
		'id_devengado',
		'fecha_reg',
		'id_documento',
		'id_transaccion',
		'tipo_documento',
		'nro_documento',
		'fecha_documento',
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'id_actividad',
		'codigo_control',
		'poliza_dui',
		'formulario',
		'tipo_retencion',
		'estado_documento',
		'id_documento_valor',
		'importe_total',
		'importe_ice',
		'importe_no_gravado',
		'importe_sujeto',
		'importe_credito',
		'importe_iue',
		'importe_it',
		'importe_debito',
		'desc_tipo_documento',
		'desc_estado_documento',
		'id_moneda',
		'desc_moneda',
		'estado',
		'fk_devengado_dcto',
		'desc_tipo_documento_padre',
		'nro_documento_padre'
		]),remoteSort:true
	});


	// DEFINICIÓN DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Concepto Ingreso Gasto',maestro.desc_concepto_ingas],['Moneda',maestro.desc_moneda],['Importe Devengado',maestro.importe_devengado],['Estado Devengado',maestro.estado_devengado],['Tipo Devengado',maestro.tipo_devengado]];

	//DATA STORE COMBOS

	//FUNCIONES RENDER

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_devengado_detalle
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_devengado_dcto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_devengado_dcto'
	};
	// txt id_devengado
	Atributos[1]={
		validacion:{
			name:'id_devengado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_devengado,
		save_as:'id_devengado'
	};

	// tipo_documento
	Atributos[2]={
		validacion:{
			fieldLabel:'Fecha Registro',
			name:'fecha_reg',
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:80,
			grid_indice:10
		},
		tipo:'Field',
		form:false,
		save_as:'fecha_reg'
	};

	//fecha_reg
	Atributos[3]={
		validacion:{
			fieldLabel:'Id.Documento',
			name:'id_documento',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'id_documento'
	};

	Atributos[4]={
		validacion:{
			fieldLabel:'Id.Transaccion',
			name:'id_transaccion',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'id_transaccion'
	};

	// tipo_documento
	Atributos[5]={
		validacion:{
			fieldLabel:'Tipo Documento',
			name:'tipo_documento',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'tipo_documento'
	};

	Atributos[6]={
		validacion:{
			fieldLabel:'Importe',
			name:'importe_doc',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_doc'
	};


	Atributos[7]={
		validacion:{
			fieldLabel:'Moneda',
			name:'id_moneda',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'id_moneda'
	};

	Atributos[8]={
		validacion:{
			fieldLabel:'Nro. Documento',
			name:'nro_documento',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:4
		},
		tipo:'Field',
		form:false,
		save_as:'nro_documento'
	};

	Atributos[9]={
		validacion:{
			fieldLabel:'Fecha Documento',
			name:'fecha_documento',
			grid_visible:true,
			align:'center',
			grid_editable:false,
			width_grid:80,
			grid_indice:2
		},
		tipo:'Field',
		form:false,
		save_as:'fecha_documento'
	};

	Atributos[10]={
		validacion:{
			fieldLabel:'Razón Social',
			name:'razon_social',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			grid_indice:3
		},
		tipo:'Field',
		form:false,
		save_as:'razon_social'
	};

	Atributos[11]={
		validacion:{
			fieldLabel:'NIT',
			name:'nro_nit',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:5
		},
		tipo:'Field',
		form:false,
		save_as:'nro_nit'
	};

	Atributos[12]={
		validacion:{
			fieldLabel:'Nro. Autorización',
			name:'nro_autorizacion',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:6
		},
		tipo:'Field',
		form:false,
		save_as:'nro_autorizacion'
	};


	Atributos[13]={
		validacion:{
			fieldLabel:'Código Control',
			name:'codigo_control',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'codigo_control'
	};

	Atributos[14]={
		validacion:{
			fieldLabel:'Póliza DUI',
			name:'poliza_dui',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'poliza_dui'
	};

	// tipo_documento
	Atributos[15]={
		validacion:{
			fieldLabel:'Formulario',
			name:'formulario',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'formulario'
	};

	Atributos[16]={
		validacion:{
			fieldLabel:'Tipo Retención',
			name:'tipo_retencion',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'tipo_retencion'
	};

	Atributos[17]={
		validacion:{
			fieldLabel:'Estado Documento',
			name:'estado_documento',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'estado_documento'
	};

	Atributos[18]={
		validacion:{
			fieldLabel:'Id. Documento Valor',
			name:'id_documento_valor',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'id_documento_valor'
	};

	Atributos[19]={
		validacion:{
			fieldLabel:'Importe Total',
			name:'importe_total',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width:300,
			grid_indice:8
		},
		tipo:'Field',
		form:false,
		save_as:'importe_total'
	};

	Atributos[20]={
		validacion:{
			fieldLabel:'Importe ICE',
			name:'importe_ice',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_ice'
	};

	Atributos[21]={
		validacion:{
			fieldLabel:'Importe no gravado',
			name:'importe_no_gravado',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_no_gravado'
	};

	Atributos[22]={
		validacion:{
			fieldLabel:'Importe Sujeto',
			name:'importe_sujeto',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_sujeto'
	};

	Atributos[23]={
		validacion:{
			fieldLabel:'Importe Crédito',
			name:'importe_credito',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_credito'
	};

	Atributos[24]={
		validacion:{
			fieldLabel:'Importe IUE',
			name:'importe_iue',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_iue'
	};

	Atributos[25]={
		validacion:{
			fieldLabel:'Importe IT',
			name:'importe_it',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_it'
	};

	Atributos[26]={
		validacion:{
			fieldLabel:'Importe Débito',
			name:'importe_debito',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false,
		save_as:'importe_debito'
	};

	Atributos[27]={
		validacion:{
			fieldLabel:'Tipo Documento',
			name:'desc_tipo_documento',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:1
		},
		tipo:'Field',
		form:false,
		save_as:'desc_tipo_documento'
	};

	Atributos[28]={
		validacion:{
			fieldLabel:'Datos',
			name:'desc_estado_documento',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:9
		},
		tipo:'Field',
		form:false,
		save_as:'desc_estado_documento'
	};

	Atributos[29]={
		validacion:{
			fieldLabel:'Estado',
			name:'estado',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:9
		},
		tipo:'Field',
		form:false,
		save_as:'estado'
	};

	Atributos[30]={
		validacion:{
			fieldLabel:'Tipo Doc. Padre',
			name:'desc_tipo_documento_padre',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:9
		},
		tipo:'Field',
		form:false,
		save_as:'desc_tipo_documento_padre'
	};

	Atributos[31]={
		validacion:{
			fieldLabel:'Nro. Doc. Padre',
			name:'nro_documento_padre',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:9
		},
		tipo:'Field',
		form:false,
		save_as:'nro_documento_padre'
	};

	Atributos[32]={
		validacion:{
			fieldLabel:'fk_devengado_dcto',
			name:'fk_devengado_dcto',
			grid_visible:false,
			grid_editable:false,
			width:300,
			grid_indice:9
		},
		tipo:'Field',
		form:false,
		save_as:'fk_devengado_dcto'
	};

	Atributos[33]={
		validacion:{
			fieldLabel:'id_cotizacion',
			name:'id_cotizacion',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		save_as:'id_cotizacion'
	};

	Atributos[34]={
		validacion:{
			fieldLabel:'id_plan_pago',
			name:'id_plan_pago',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		save_as:'id_plan_pago'
	};


	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Devengar Servicios (Maestro)',titulo_detalle:'Facturas/Recibos',grid_maestro:'grid-'+idContenedor};
	var layout_devengado_detalle = new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_devengado_detalle.init(config);



	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_devengado_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;
	var CM_enableSelect=this.EnableSelect;
	var CM_deselectRow=this.DeselectRow;

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/devengado_detalle/ActionEliminarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Save:{url:direccion+'../../../control/devengado_detalle/ActionGuardarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		ConfirmSave:{url:direccion+'../../../control/devengado_detalle/ActionAprobarDevengadoDetalle.php',parametros:'&m_id_devengado='+maestro.id_devengado},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:280,columnas:['80%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}],width:'50%',minWidth:120,minHeight:170,	closable:true,titulo:'Documentos (Facturas/Recibos)'}
	};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));

		maestro.id_devengado=datos.m_id_devengado;
		maestro.desc_concepto_ingas=datos.m_desc_concepto_ingas;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.importe_devengado=datos.m_importe_devengado;
		maestro.estado_devengado=datos.m_estado_devengado;
		maestro.tipoFormDev=datos.tipoFormDev;
		maestro.proforma=datos.m_proforma;
		maestro.solo_lectura=datos.m_solo_lectura;
		maestro.tipo_doc_fijo=datos.m_tipo_doc_fijo;
		maestro.id_cotizacion=datos.m_id_cotizacion;
		maestro.id_plan_pago=datos.m_id_plan_pago;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_devengado:maestro.id_devengado
			}
		};
		this.btnActualizar();
		data_maestro=[['Concepto Ingreso Gasto',maestro.desc_concepto_ingas],['Moneda',maestro.desc_moneda],['Importe Devengado',maestro.importe_devengado],['Estado Devengado',maestro.estado_devengado],['Tipo Devengado',maestro.tipo_devengado]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_devengado;

		paramFunciones.btnEliminar.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.Save.parametros='&m_id_devengado='+maestro.id_devengado;
		paramFunciones.ConfirmSave.parametros='&m_id_devengado='+maestro.id_devengado;

		if(maestro.tipoFormDev=='pag'){
			if(maestro.solo_lectura==1){
				//sólo lectura
				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).disable();
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			}
			else{
				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).enable();
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
			}
			CM_getBoton('btn_reg_pro-'+idContenedor).hide();
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
			CM_getBoton('btn_reg_pro-'+idContenedor).hide();
		}

		this.InitFunciones(paramFunciones)
	};

	this.btnNew=function(){
		data='m_nombre_tabla=tesoro.tts_devengado_dcto';
		data=data+'&m_nombre_campo=id_devengado';
		data=data+'&m_id_tabla='+maestro.id_devengado;
		data=data+'&m_id_moneda='+maestro.id_moneda;
		data=data+'&m_id_documento=0';
		data=data+'&m_importe='+maestro.importe_devengado;
		data=data+'&m_nuevo=si';
		data=data+'&m_nit='+maestro.nit;
		data=data+'&m_razon_social='+maestro.razon_social;
		data=data+'&m_tipo_doc_fijo='+maestro.tipo_doc_fijo;
		//data=data+'&m_regulariz='+maestro.proforma;

		//Verifica si el pago viene de adquisiciones para obtener el tipo de documento
		/*var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		if(SelectionsRecord.data.tipo_documento==''){*/
		if(maestro.tipo_doc_fijo=='si'){
			if(maestro.id_cotizacion!=''){
				var aux='id_cotizacion='+maestro.id_cotizacion+'&id_plan_pago='+maestro.id_plan_pago;
				Ext.Ajax.request({
					url:direccion+'../../../control/devengado_dcto/ActionListarTipoDocumentoAdq.php?'+aux,
					method:'POST',
					success:f_exito_obtener_tipo_documento,
					failure:CM_conexionFailure,
					timeout:100000
				})
			} else{
				//Llama la ventana de registro de documentos
				var ParamVentana={Ventana:{width:450,height:400}};
				layout_devengado_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
			}
		}
		else{
			//Llama la ventana de registro de documentos
			var ParamVentana={Ventana:{width:450,height:400}};
			layout_devengado_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
		}

	}

	function f_exito_obtener_tipo_documento(resp){
		var root = resp.responseXML.documentElement;
		var v_tipo_doc = root.getElementsByTagName('tipo_documento')[0].firstChild.nodeValue;
		var v_tipo = root.getElementsByTagName('tipo')[0].firstChild.nodeValue;
		//Llama la ventana de registro de documentos
		var ParamVentana={Ventana:{width:450,height:400}};
		data=data+'&m_tipo_documento='+v_tipo_doc+'&m_tipo='+v_tipo;
		layout_devengado_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
	}

	this.btnEdit=function(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_nombre_tabla=tesoro.tts_devengado_dcto';
			data=data+'&m_nombre_campo=id_devengado';
			data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_importe='+maestro.importe_devengado;
			data=data+'&m_nit='+maestro.nit;
			data=data+'&m_razon_social='+maestro.razon_social;
			data=data+'&m_tipo_doc_fijo='+maestro.tipo_doc_fijo;
			data=data+'&m_tipo_documento=-1';

			var ParamVentana={Ventana:{width:450,height:400}};
			layout_devengado_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}

	}

	this.btnEliminar=function(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			var id_documento=sm.getSelected().data.id_documento;
			if(id_documento!=undefined&&id_documento!=''){
				//alert('id_documento:'+id_documento);
				data='id_documento='+id_documento+'&nombre_tabla=tesoro.tts_devengado_dcto&nombre_campo=id_devengado_dcto&id_tabla='+sm.getSelected().data.id_devengado_dcto;
				if(confirm('¿Está seguro de eliminar el Documento?')){
					Ext.Ajax.request({
						url:direccion+'../../../../sis_contabilidad/control/documento/ActionEliminarDocumento.php?'+data,
						method:'GET',
						success:exito_doc_del,
						failure:CM_conexionFailure,
						timeout:100000
					})}
			}
			else{
				Ext.MessageBox.alert('Estado','Documento inexistente')
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function exito_doc_del(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado','Documento eliminado');
		CM_btnAct()
	}

	//Evento sobrecargado del EnableSelect
	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
	}

	//Evento al Seleccionar una fila
	function enable(sel,row,selected){
		//Habilita o deshabilita los botones dependiendo del tipo de la vista
		var record=selected.data;
		if(selected&&record!=-1){
			if(maestro.tipoFormDev=='pag'){
				//Si están en pagos habilita los botones ABM, y si sonb proforma habilita el botón regularizar
				if(maestro.solo_lectura==1){
					//sólo lectura
					CM_getBoton('nuevo-'+idContenedor).show();
					CM_getBoton('editar-'+idContenedor).show();
					CM_getBoton('eliminar-'+idContenedor).show();
					CM_getBoton('nuevo-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
				}
				else{
					CM_getBoton('nuevo-'+idContenedor).show();
					CM_getBoton('editar-'+idContenedor).show();
					CM_getBoton('eliminar-'+idContenedor).show();
					CM_getBoton('nuevo-'+idContenedor).enable();
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
				}
				//Botón de regularización
				if((record.tipo_documento==16||record.tipo_documento==17||record.tipo_documento==18)&&maestro.proforma==2&&record.estado=='activo'){
					CM_getBoton('btn_reg_pro-'+idContenedor).show();
				}
				else{
					CM_getBoton('btn_reg_pro-'+idContenedor).hide();
				}
			}
			else{
				//Esconde los botones
				CM_getBoton('nuevo-'+idContenedor).hide();
				CM_getBoton('editar-'+idContenedor).hide();
				CM_getBoton('eliminar-'+idContenedor).hide();
				CM_getBoton('btn_reg_pro-'+idContenedor).hide();
			}
		}
		CM_enableSelect(sel,row,selected);
	}

	//Evento sobrecargado al deseleccionar una fila
	this.DeselectRow=function(x,z){
		if(maestro.tipoFormDev=='pag'){
			if(maestro.solo_lectura==1){
				//sólo lectura
				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).disable();
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			}
			else{

				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).enable();
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
			}
			CM_getBoton('btn_reg_pro-'+idContenedor).hide();
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
			CM_getBoton('btn_reg_pro-'+idContenedor).hide();
		}
	}

	function f_regulariz_prof(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_nombre_tabla=tesoro.tts_devengado_dcto';
			data=data+'&m_nombre_campo=id_devengado';
			data=data+'&m_id_tabla='+SelectionsRecord.data.id_devengado;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_importe='+maestro.importe_devengado;
			data=data+'&m_nit='+maestro.nit;
			data=data+'&m_razon_social='+maestro.razon_social;
			data=data+'&m_regulariz='+maestro.proforma;
			data=data+'&m_id_devengado_dcto='+SelectionsRecord.data.id_devengado_dcto;

			var ParamVentana={Ventana:{width:450,height:400}};
			layout_devengado_detalle.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){

	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_devengado_detalle.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_devengado:maestro.id_devengado
		}
	});

	//alert('tipoformdev:'+maestro.tipoFormDev)
	var CM_getBoton=this.getBoton;
	//Se aumenta el botón para regularizar proformas
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Regularizar Proforma',f_regulariz_prof,false,'btn_reg_pro','Regularizar');

	if(maestro.tipoFormDev=='pag'){
		if(maestro.solo_lectura==1){
			//sólo lectura
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).show();
			CM_getBoton('editar-'+idContenedor).show();
			CM_getBoton('eliminar-'+idContenedor).show();
		}
		CM_getBoton('btn_reg_pro-'+idContenedor).hide();
	}
	else{
		CM_getBoton('nuevo-'+idContenedor).hide();
		CM_getBoton('editar-'+idContenedor).hide();
		CM_getBoton('eliminar-'+idContenedor).hide();
		CM_getBoton('btn_reg_pro-'+idContenedor).hide();
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();

	layout_devengado_detalle.getLayout().addListener('layout',this.onResize);
	layout_devengado_detalle.getVentana(idContenedor).on('resize',function(){layout_devengado_detalle.getLayout().layout()})

}