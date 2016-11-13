/**
 * Nombre:		  	    pagina_cuenta_doc_rendicion_cab.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 19:06:46
 */
function pagina_cuenta_doc_rendicion_cab(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_rendicion_cab/ActionListarCuentaDocRendicionCab.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_doc',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_doc',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'id_usuario_rendicion',
		'desc_usuario',
		'estado',
		'nro_documento',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'observaciones',
		'id_depto',
		'desc_depto',
		'fk_id_cuenta_doc',
		'id_presupuesto',
		'desc_presupuesto',
		'id_empleado',
		'desc_empleado',
		'id_moneda',
		'desc_moneda',
		'id_comprobante',
		'tipo_cuenta_doc',
		'solo_lectura',
		'id_parametro',
		'desc_parametro',
		'id_autorizacion',
		'desc_autorizacion',
		'tipo_contrato'
	]),remoteSort:true});
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			fk_id_cuenta_doc:maestro.id_cuenta_doc
		}
	});
	
	//DATA STORE COMBOS
    var ds_cuenta_doc = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarCuentaDoc.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_doc',totalRecords: 'TotalCount'},['id_cuenta_doc','codigo_depto','nombre_depto','desc_categoria','apellido_paterno','apellido_materno','nombre','codigo_empleado','nro_documento'])
	});
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});
	var ds_id_autorizacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado','email1'])
	});

	//FUNCIONES RENDER
	function render_fk_id_cuenta_doc(value, p, record){return String.format('{0}', record.data['desc_cuenta_doc']);}
	var tpl_fk_id_cuenta_doc=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT><br>','<FONT COLOR="#B5A642">{desc_categoria}</FONT><br>','<FONT COLOR="#B5A642">{apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT><br>','<FONT COLOR="#B5A642">{nro_documento}</FONT>','</div>');

	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
	
	function render_id_autorizacion(value, p, record){if(record.get('id_caja')!='' ){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_autorizacion']+ '</span>');}else{return String.format('{0}', record.data['desc_autorizacion']);}}
	var tpl_id_autorizacion=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');  //codigo_empleado
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cuenta_doc
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	// txt id_parametro
	Atributos[1]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			grid_indice:1,  //para colocar el orden en el indice			
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:1,
		filterColValue:'PARAMP.gestion_pres'		
	};
	
	Atributos[2]= {
		validacion:{
			name:'fecha_sol',
			fieldLabel:'Fecha de Rendición',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:7		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_sol',
		dateFormat:'m-d-Y'
		//defecto:fecha.dateFormat('d/m/Y'),			
	};
	
	// txt fecha_ini
	Atributos[3]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:''
	};
	
	// txt fecha_fin
	Atributos[4]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:''
	};
	
	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Concepto de la Rendición',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		defecto:maestro.observacion,
		filterColValue:'CUDOC.observaciones'
	};
	
	Atributos[6]={
		validacion:{
			name:'fk_id_cuenta_doc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_cuenta_doc
	};
	
	Atributos[7]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nro. Rendición',
			grid_visible:true,
			grid_editable:false
		},
		tipo:'Field',
		form:false,
		filtro_0:true,
		filterColValue:'CUDOC.nro_documento'
	}
	// txt nro_documento
	Atributos[8]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'CUDOC.estado'
	};
	
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'id_comprobante',
			fieldLabel:'Id Comprobante',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:80
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'CUEDOC.id_comprobante'  // con estos campos filtramos en la tabla
	};
	
	Atributos[10]={
		validacion:{
			name:'tipo_cuenta_doc',
			fieldLabel:'Tipo Cuenta Doc',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:true		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'CUDOC.tipo_cuenta_doc'
	};
	
	// txt id_empleado
	Atributos[11]={
		validacion:{
			name:'id_autorizacion',
			fieldLabel:'Firma Autorización', //Empleado de la gerencia que autoriza los viajes
			allowBlank:true,			
			//emptyText:'Empleado...',
			desc: 'desc_autorizacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_autorizacion,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			tpl:tpl_id_autorizacion,
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
			renderer:render_id_autorizacion,
			grid_visible:true,
			grid_editable:true,
			width_grid:220,
			width:240,
			disabled:false//,
			//grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'CUDOC.desc_autorizacion',
		id_grupo:1
	};
	
	if(maestro.vista=='solicitud_viatico'){	
		Atributos[12]={
			validacion: {
				name:'tipo_contrato',
				fieldLabel:'Personal de',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['planta','Planta - Sin retención'],['contrato','Contrato - Sin retención'] ,['comision','Comisión - Con retención'],['miembro','Miembros del Directorio - Con retención']]}),  //,['comision','Comisión - Con retención']
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				disabled:false,
				grid_indice:9		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filterColValue:'CUDOC.tipo_contrato',		
			defecto:maestro.tipo_contrato
			//id_grupo:4		
		};
	}
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	if(maestro.vista=='solicitud_viatico'){	
		var config={titulo_maestro:'Rendición de Viáticos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/cuenta_doc_rendicion/cuenta_doc_rendicion.php'};
	}else{
		var config={titulo_maestro:'Rendición de Viáticos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/cuenta_doc_rendicion/cuenta_doc_rendicion_fa.php'};
	}
	var layout = new DocsLayoutMaestroDeatalle(idContenedor);
	layout.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_getComponente=this.getComponente;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cuenta_doc_rendicion_cab/ActionEliminarCuentaDocRendicionCab.php',parametros:'&fk_id_cuenta_doc='+maestro.id_cuenta_doc},
	Save:{url:direccion+'../../../control/cuenta_doc_rendicion_cab/ActionGuardarCuentaDocRendicionCab.php',parametros:'&fk_id_cuenta_doc='+maestro.id_cuenta_doc},
	ConfirmSave:{url:direccion+'../../../control/cuenta_doc_rendicion_cab/ActionGuardarCuentaDocRendicionCab.php',parametros:'&fk_id_cuenta_doc='+maestro.id_cuenta_doc},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Registro de rendiciones',	
	grupos:[{
				tituloGrupo:'Datos Rendición',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:1
			}]
	}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_cuenta_doc=datos.id_cuenta_doc;
		maestro.observacion=datos.observacion;
		maestro.tipo_contrato=datos.tipo_contrato;
		maestro.vista=datos.vista;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				fk_id_cuenta_doc:maestro.id_cuenta_doc
			}
		};		

		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
		CM_getBoton('reporte_rendicion-'+idContenedor).disable();
		CM_getBoton('fin_rend-'+idContenedor).disable();
		CM_getBoton('corregir_rendicion-'+idContenedor).disable();
		
		_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu();
		
		this.btnActualizar();
		
		Atributos[5].defecto=maestro.observacion;
		Atributos[6].defecto=maestro.id_cuenta_doc;
		
		if(maestro.vista=='solicitud_viatico'){
			CM_mostrarComp(componentes[12]);
			Atributos[12].defecto=maestro.tipo_contrato;
		}
		
		paramFunciones.btnEliminar.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.Save.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.ConfirmSave.parametros='&fk_id_cuenta_doc='+maestro.id_cuenta_doc;
		this.InitFunciones(paramFunciones)		
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function(){
			if(_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore()){
				_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu()
			}
		})	
		
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
	}
	
	this.EnableSelect=function(sm,row,rec){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
		
		if(NumSelect!=0){
			if(rec.data.estado=='en_rendicion'){ //en_rendicion	
				rec.data.solo_lectura=0;    //lectura y escritura
			}else{
				rec.data.solo_lectura=1;	//solo lectura
			}	
		}
		if(rec.data['estado']=='en_rendicion'){  //si el estado del registro seleccionado es en_rendicion
			_CP.getPagina(layout.getIdContentHijo()).pagina.desbloquearMenu();
		}else{
			_CP.getPagina(layout.getIdContentHijo()).pagina.bloquearMenu();
		}
		
		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data);
	}
	
	this.btnNew = function(){
		CM_ocultarGrupo('Oculto');
		//Ejecución función de inserción
		CM_btnNew();
	}
	
	function btn_verificacion_presupuestaria(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			var data='&id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;	
			data= data + '&tipo_vista=avance'; 
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionVerificacion.php?'+data)
		}else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function btn_vista_previa_rendicion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0){
			var data='&id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;	
			data= data + '&tipo_vista=avance';
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data)
		}else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}
		
	function btn_reporte_rendicion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0){
			var data='&id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data)
		}else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function btn_finalizar_rendicion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();	
		
		if(NumSelect!=0){	
			Ext.MessageBox.show({
				title: 'Procesando',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Finalizando Rendición. Espere por favor...</div>",
				width:300,
				height:150,
				closable:false
			});
			
			Ext.Ajax.request({
				url:direccion+"../../../control/cuenta_doc/ActionEstadoViatico.php",
				method:'POST',
				params:{cantidad_ids:'1',id_cuenta_doc:SelectionsRecord.data.id_cuenta_doc,accion:'finalizar_rendicion'},
				success:finarlizarRendicionSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}
	}
	
	function finarlizarRendicionSuccess(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement){
			btn_reporte_rendicion();
			ClaseMadre_btnActualizar();
		}else{
			ClaseMadre_conexionFailure();
		}
	}	
	
	function btn_corregir_rendicion(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0){
			Ext.Ajax.request({
				url:direccion+"../../../../sis_contabilidad/control/comprobante/ActionEliminarRegistroComprobante.php",
				method:'POST',
				params:{cantidad_ids:'1',id_comprobante_0:SelectionsRecord.data.id_comprobante,observacion_0:'Comprobante eliminado por correccion de rendicion'},
				success:corregirRendicionSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
		}else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}	
	
	function corregirRendicionSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){	
			Ext.MessageBox.alert('Exito', 'Reverción exitosa, ahora puede corregir la rendición.')
			ClaseMadre_btnActualizar();
		}else{
			ClaseMadre_conexionFailure();
		}
	}
	
	function btn_reporte_documentos_respaldo(){
	    /*parametros reporte */	
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
    	var data='start=0';
		data+='&limit=1000';
		
		data+='&id_comprobante='+SelectionsRecord.data.id_comprobante;
		data+='&id_moneda='+SelectionsRecord.data.id_moneda;
		data+='&desc_moneda='+SelectionsRecord.data.desc_moneda;
	
		window.open(direccion+'../../../../sis_contabilidad/control/documento/reporte/ActionPDFDocumentosRespaldo.php?'+data);
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir la verificación presupuestaria',btn_verificacion_presupuestaria,true,'verificacion_presupuestaria','Verificación Presupuestaria');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir la vista previa de rendición',btn_vista_previa_rendicion,true,'reporte_rendicion','Reporte Rendicion');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Finalizar rendición',btn_finalizar_rendicion,true,'fin_rend','Finalizar Rendición');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Revertir la finalización de la rendición',btn_corregir_rendicion,true,'corregir_rendicion','Corregir Rendición');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Documentos Respaldo',btn_reporte_documentos_respaldo,true,'reporte_documentos_respaldo','Reporte Documentos Respaldo');
	
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
	CM_getBoton('reporte_rendicion-'+idContenedor).disable();
	CM_getBoton('fin_rend-'+idContenedor).disable();
	CM_getBoton('corregir_rendicion-'+idContenedor).disable();
	CM_getBoton('reporte_documentos_respaldo-'+idContenedor).disable();
	
	function enable(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data['estado']=='en_rendicion'){ //en_rendicion
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).enable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();
			CM_getBoton('fin_rend-'+idContenedor).enable();
			CM_getBoton('corregir_rendicion-'+idContenedor).disable();
			CM_getBoton('reporte_documentos_respaldo-'+idContenedor).disable();
		}
		if(rec.data['estado']=='conta_rendicion'){ //conta_rendicion
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();
			CM_getBoton('fin_rend-'+idContenedor).disable();
			CM_getBoton('corregir_rendicion-'+idContenedor).enable();
			CM_getBoton('reporte_documentos_respaldo-'+idContenedor).enable();
		}
		if(rec.data['estado']=='fin_rendicion'){ //fin_rendicion
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('verificacion_presupuestaria-'+idContenedor).disable();
			CM_getBoton('reporte_rendicion-'+idContenedor).enable();
			CM_getBoton('fin_rend-'+idContenedor).disable();
			CM_getBoton('corregir_rendicion-'+idContenedor).disable();
			CM_getBoton('reporte_documentos_respaldo-'+idContenedor).enable();
		}
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	
}