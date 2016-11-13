/**
* Nombre:		  	    pagina_cuenta_doc_rendicion.js
* Propósito: 			pagina objeto principal
* Autor:				RCM
* Fecha creación:		29/10/2009
*/
function pagina_cuenta_doc_rendicion(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0; 
	var data,maestro;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_rendicion/ActionListarCuentaDocRendicion.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_doc_rendicion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_doc_rendicion',
		'id_cuenta_doc',
		'importe_rendicion',
		'descripcion_rendicion',
		'id_moneda',
		'id_documento'
		]),remoteSort:true
	});

	//DATA STORE COMBOS

	//FUNCIONES RENDER

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_rendicion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
			name:'id_cuenta_doc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true,
			grid_indice:1
		},
		tipo:'Field',
		filtro_0:false
		//defecto:maestro.id_cuenta_doc
	};

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
		form:false
	};

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
		form:false
	};

	Atributos[4]={
		validacion:{
			fieldLabel:'Tipo Documento',
			name:'desc_tipo_documento',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false
	};

	Atributos[5]={
		validacion:{
			fieldLabel:'Importe documento',
			name:'importe_doc',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false
	};

	Atributos[6]={
		validacion:{
			fieldLabel:'Moneda',
			name:'desc_moneda',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false
	};

	Atributos[7]={
		validacion:{
			fieldLabel:'Nro. Documento',
			name:'nro_documento',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:4
		},
		tipo:'Field',
		form:false
	};

	Atributos[8]={
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
		form:false
	};

	Atributos[9]={
		validacion:{
			fieldLabel:'Razón Social',
			name:'razon_social',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			grid_indice:3
		},
		tipo:'Field',
		form:false
	};

	Atributos[10]={
		validacion:{
			fieldLabel:'NIT',
			name:'nro_nit',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:5
		},
		tipo:'Field',
		form:false
	};

	Atributos[11]={
		validacion:{
			fieldLabel:'Nro. Autorización',
			name:'nro_autorizacion',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:6
		},
		tipo:'Field',
		form:false
	};

	Atributos[12]={
		validacion:{
			fieldLabel:'Código Control',
			name:'codigo_control',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false
	};

	Atributos[13]={
		validacion:{
			fieldLabel:'Estado Documento',
			name:'estado_documento',
			grid_visible:true,
			grid_editable:false,
			width:300,
			grid_indice:7
		},
		tipo:'Field',
		form:false
	};

	Atributos[14]={
		validacion:{
			fieldLabel:'Importe retenido',
			name:'importe_retenido',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			width:300,
			grid_indice:8
		},
		tipo:'Field',
		form:false
	};
	
	Atributos[15]={
			validacion:{
				fieldLabel:'Importe Líquido',
				name:'importe_liquido',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width:300,
				grid_indice:8
			},
			tipo:'Field',
			form:false
		};

	


	//----------- FUNCIONES RENDER

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Rendición (Maestro)',titulo_detalle:'Facturas/Recibos',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutMaestro(idContenedor);
	layout.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
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
	//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionEliminarCuentaDocRendicion.php'},
		Save:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionGuardarCuentaDocRendicion.php'},
		ConfirmSave:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionGuardarCuentaDocRendicion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:280,columnas:['80%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0}],width:'50%',minWidth:120,minHeight:170,	closable:true,titulo:'Documentos (Facturas/Recibos)'}
	};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params){
		maestro=params;
		console.log(maestro);

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cuenta_doc:maestro.id_cuenta_doc
			}
		};
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_cuenta_doc;

		paramFunciones.btnEliminar.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.Save.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.ConfirmSave.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;

		if (maestro.solo_lectura == 1) {
			// sólo lectura
			CM_getBoton('nuevo-' + idContenedor).show();
			CM_getBoton('editar-' + idContenedor).show();
			CM_getBoton('eliminar-' + idContenedor).show();
			CM_getBoton('nuevo-' + idContenedor).disable();
			CM_getBoton('editar-' + idContenedor).disable();
			CM_getBoton('eliminar-' + idContenedor).disable();
		} else {
			CM_getBoton('nuevo-' + idContenedor).show();
			CM_getBoton('editar-' + idContenedor).show();
			CM_getBoton('eliminar-' + idContenedor).show();
			CM_getBoton('nuevo-' + idContenedor).enable();
			CM_getBoton('editar-' + idContenedor).enable();
			CM_getBoton('eliminar-' + idContenedor).enable();
		}

		this.InitFunciones(paramFunciones)
	};

	this.btnNew=function(){
		console.log(maestro);
		data='m_nombre_tabla=tesoro.tts_cuenta_doc_rendicion';
		data=data+'&m_nombre_campo=id_cuenta_doc';
		data=data+'&m_id_tabla='+maestro.id_cuenta_doc;
		data=data+'&m_id_moneda='+maestro.id_moneda;
		data=data+'&m_id_documento=0';
		data=data+'&m_importe='+maestro.importe;
		data=data+'&m_nuevo=si';
		data=data+'&m_nit='+maestro.nit;
		data=data+'&m_razon_social='+maestro.razon_social;
		data=data+'&m_tipo_doc_fijo=no';
		//data=data+'&m_regulariz='+maestro.proforma;

		//Llama la ventana de registro de documentos
		var ParamVentana={Ventana:{width:450,height:400}};
		layout.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana);

	}

	this.btnEdit=function(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_nombre_tabla=tesoro.tts_cuenta_doc_rendicion';
			data=data+'&m_nombre_campo=id_cuenta_doc';
			data=data+'&m_id_tabla='+SelectionsRecord.data.id_cuenta_doc;
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_importe='+maestro.importe;
			data=data+'&m_nit='+maestro.nit;
			data=data+'&m_razon_social='+maestro.razon_social;
			data=data+'&m_tipo_doc_fijo=no';
			data=data+'&m_tipo_documento=-1';

			var ParamVentana={Ventana:{width:450,height:400}};
			layout.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
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
				data='id_documento='+id_documento+'&nombre_tabla=tesoro.tts_cuenta_doc_rendicion&nombre_campo=id_cuenta_doc_rendicion&id_tabla='+sm.getSelected().data.id_cuenta_doc_rendicion;
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
			//Si están en pagos habilita los botones ABM, y si sonb proforma habilita el botón regularizar
			if(maestro.solo_lectura==1){
				//sólo lectura
				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).disable();
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			} else{
				CM_getBoton('nuevo-'+idContenedor).show();
				CM_getBoton('editar-'+idContenedor).show();
				CM_getBoton('eliminar-'+idContenedor).show();
				CM_getBoton('nuevo-'+idContenedor).enable();
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
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
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).hide();
			CM_getBoton('editar-'+idContenedor).hide();
			CM_getBoton('eliminar-'+idContenedor).hide();
		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){

	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_cuenta_doc:maestro.id_cuenta_doc
		}
	});*/

	//alert('tipoformdev:'+maestro.tipoFormDev)
	var CM_getBoton=this.getBoton;

	/*if(maestro.solo_lectura==1){
		// sólo lectura
		CM_getBoton('nuevo-'+idContenedor).disable();
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
	}
	else{
		CM_getBoton('nuevo-'+idContenedor).show();
		CM_getBoton('editar-'+idContenedor).show();
		CM_getBoton('eliminar-'+idContenedor).show();
	}*/

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	layout.getVentana(idContenedor).on('resize',function(){layout.getLayout().layout()})

}