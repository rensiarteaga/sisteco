/**
 * Nombre:		  	    pagina_detalle_viatico.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-10-27 11:50:09
 */
function pagina_rendicion(idContenedor,direccion,paramConfig) 

{
	var maestro;
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var vista='rendicion_caja'
	var dialog;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc/ActionListarSolicitudViaticos2.php?tipo_cuenta_doc='+vista}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cuenta_doc',totalRecords:'TotalCount'
		},[		
		'id_cuenta_doc',
		'id_presupuesto',
		'desc_presupuesto',
		'id_empleado',
		'desc_empleado',
		'id_categoria',
		'desc_categoria',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		'tipo_pago',
		'tipo_contrato',
		'id_usuario_rendicion',
		'desc_usuario',
		'estado',
		'nro_documento',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'motivo',
		'recorrido',
		'observaciones',
		'id_moneda',
		'desc_moneda',
		'id_depto',
		'desc_depto',
		'id_caja',
		'desc_caja',
		'id_cajero',
		'desc_cajero',
		'id_cuenta_bancaria',
		'desc_cuenta_bancaria',
		'importe',
		'id_comprobante'
		]),remoteSort:true});


	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','desc_institucion','nro_cuenta_banco'])
	});
	
	function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
	var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</b></i><br>','<FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT>','</div>');

		
	

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
		filtro_0:false,
		save_as:'id_cuenta_doc'
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja'
	};
	
	
	Atributos[2]={
		validacion:{
			name: 'nro_documento', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'No',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:1		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CUDOC.nro_documento',
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
			disabled:false,
			grid_indice:2		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
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
			disabled:false,
			grid_indice:3		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CUDOC.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:0
		
	};

// txt estado
	
// txt nro_documento
	
	
	
	Atributos[5]={
		validacion:{
			name: 'importe', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Importe',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			grid_indice:4		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CUDOC.importe',
	};
// txt fecha_reg
	

// txt observaciones
	Atributos[6]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUDOC.observaciones',
		id_grupo:0
		
	};
	
	Atributos[7]={
		validacion:{
			name: 'fecha_reg', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Fecha de Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6,
			renderer:formatDate		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CUDOC.fecha_reg',
	};
// txt estado
	Atributos[8]={
		validacion:{
			name: 'estado', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:7		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'CUDOC.estado',
	};
	
	// txt id_cuenta_bancaria
	Atributos[9]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#CUEBAN.nro_cuenta_banco',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
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
			renderer:render_id_cuenta_bancaria,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT_0.nombre#CUEBAN_0.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:1
		
	};
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name: 'reporte',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'reporte'
	};
	Atributos[11]={
		validacion:{
			name:'tipo_rendicion',
			fieldLabel:'Rendir',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['todo','todo'],['viaticos-fa','viaticos-fa'],['documentos','documentos']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			disabled:false	
		},
		tipo: 'ComboBox',
		form: true,
		defecto:'todo',
		id_grupo:0	
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
		
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Rendicion de cajas (Maestro)',titulo_detalle:'Rendiciones (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_rendicion_caja = new DocsLayoutMaestro(idContenedor);
	layout_rendicion_caja.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_rendicion_caja,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getGrid=this.getGrid;
	var CM_InitFunciones=this.InitFunciones;
	var CM_Save=this.Save;
	var cm_EnableSelect=this.EnableSelect;
	var cm_getDialog=this.getDialog;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/cuenta_doc/ActionEliminarSolicitudViaticos2.php'},
	Save:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php'},
	ConfirmSave:{url:direccion+'../../../control/cuenta_doc/ActionGuardarSolicitudViaticos2.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'40%',width:'50%',minWidth:350,minHeight:400,	closable:true,titulo:'Rendicion de cajas',
		
			grupos:[
			{
				tituloGrupo:'Datos Rendicion',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Cuenta',
				columna:0,
				id_grupo:1
			}]
		}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_caja:maestro.id_caja,
				vista:vista
			}
		};
		this.btnActualizar();
		
		paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja;
		paramFunciones.ConfirmSave.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja;
		paramFunciones.btnEliminar.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja;
		
		Atributos[1].defecto=maestro.id_caja;
		this.InitFunciones(paramFunciones);
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		dialog=cm_getDialog();
    }
	
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
	}
	
	
	this.btnNew=function(){
		paramFunciones.Formulario.guardar=CM_Save;
		paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=otra';
		componentes[10].setValue('false');
		CM_InitFunciones(paramFunciones);
		CM_mostrarGrupo('Datos Rendicion');
		CM_ocultarGrupo('Datos Cuenta');
		SiBlancosGrupo(1);
		NoBlancosGrupo(0);
		CM_mostrarComponente(componentes[6]);
		dialog.buttons[0].setText('Guardar Datos');
		dialog.buttons[0].setHandler(CM_Save);
		CM_btnNew();
				
	}	
	this.btnEdit=function(){
		paramFunciones.Formulario.guardar=CM_Save;
		componentes[10].setValue('false');
		paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=otra';
		CM_InitFunciones(paramFunciones);
		CM_mostrarGrupo('Datos Rendicion');
		CM_ocultarGrupo('Datos Cuenta');
		SiBlancosGrupo(1);
		NoBlancosGrupo(0);
		CM_mostrarComponente(componentes[6]);
		componentes[11].setValue('todo');
		dialog.buttons[0].setText('Guardar Datos');
		dialog.buttons[0].setHandler(CM_Save);
		CM_btnEdit();
		
				
	}
	
	/*btn_repo=function(){
		
		paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=generar_reposicion';
		CM_InitFunciones(paramFunciones);
		CM_ocultarGrupo('Datos Rendicion');
		CM_mostrarGrupo('Datos Cuenta');
		SiBlancosGrupo(0);
		NoBlancosGrupo(1);
		CM_btnEdit();
		
				
	}*/
	
	
	/*function btn_docu_rend(){
		//this.btnActualizar;
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
		  var SelectionsRecord=sm.getSelected();
				var data='m_id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;
			//	alert(data);	
				var ParamVentana={Ventana:{width:'90%',height:'70%'}};
				layout_rendicion_caja.loadWindows(direccion+'../../../../sis_tesoreria/vista/rendicion_documento/rendicion_documento.php?'+data,'Rendicion Documento',ParamVentana);
				layout_rendicion_caja.getVentana().on('resize',function(){
				layout_rendicion_caja.getLayout().layout();
				})
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
			}
		}*/
	

	function btn_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		
		if(NumSelect!=0)
		{			
			var data='id_cuenta_doc='+SelectionsRecord.data.id_cuenta_doc;	
			data= data + '&tipo_vista=avance';	
				  	 	   			   	   
			//window.open(direccion+'../../../control/_reporte/cuenta_doc_rendicion/ActionPDFRendicionCuenta.php?'+data)	
			//window.open(direccion+'../../../control/descargo/reporte/ActionPDFRendicionCuenta.php?'+data)						
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc.php?'+data)						
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}
	
	function btn_vp_rendicion()
	{
		dialog.buttons[0].setText('Generar Reporte');
		dialog.buttons[0].setHandler(guardarVP);
		componentes[10].setValue('false');
		CM_mostrarGrupo('Datos Rendicion');
		CM_ocultarGrupo('Datos Cuenta');
		CM_ocultarComponente(componentes[6]);
		SiBlancosGrupo(1);
		NoBlancosGrupo(0);
		CM_btnNew();
		dialog.buttons[1].hide();
	}
	
	var guardarVP=function()
	{
		
		var data='fecha_ini='+componentes[3].getValue().dateFormat('d/m/Y');	
			data= data + '&fecha_fin='+componentes[4].getValue().dateFormat('d/m/Y');
			data= data + '&tipo_rendicion='+componentes[11].getValue();	
			data= data + '&id_caja='+maestro.id_caja;	
			   
			
			window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRendicionCuentaDoc2.php?'+data)						
			dialog.hide();
	}
		
	
	btn_conta=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=contabilizar_rendicion';
			CM_InitFunciones(paramFunciones);
			
			SiBlancosGrupo(1);
			NoBlancosGrupo(0);
			componentes[11].setValue('todo');
			CM_Save();
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro.');
				
		}
				
	}
	
	btn_fin=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect==1){
			paramFunciones.Save.parametros='&vista='+vista+'&id_caja_0='+maestro.id_caja+'&accion=finalizar_rendicion';
			CM_InitFunciones(paramFunciones);
			
			SiBlancosGrupo(1);
			NoBlancosGrupo(0);
			CM_Save();
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro.');
				
		}
	}
	
	function btn_corregir_rendicion()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect!=0)
		{
			Ext.MessageBox.show({
				title: 'Procesando',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Habilitandola Rendición para permitir modificaciones...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			Ext.Ajax.request({
				url:direccion+"../../../../sis_contabilidad/control/comprobante/ActionEliminarRegistroComprobante.php",
				//http://cincel.ende.bo/endesis_desarrollo/sis_contabilidad/control/comprobante/ActionEliminarRegistroComprobante.php
				method:'POST',
				params:{cantidad_ids:'1',id_comprobante_0:SelectionsRecord.data.id_comprobante,observacion_0:'Comprobante eliminado por correccion de rendicion'},
				success:corregirRendicionSuccess,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
			});
			
			//Ext.MessageBox.alert('Exito', 'Reverción exitosa, ahora puede corregir la rendición.')										
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		} 
	}	
	
	function corregirRendicionSuccess(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{	
			Ext.MessageBox.alert('Exito', 'Reverción exitosa, ahora puede corregir la rendición.')					
			ClaseMadre_btnActualizar();
		}
		else
		{
			ClaseMadre_conexionFailure();
		}
	}
	
	
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rendicion_caja.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la Rendición',btn_rendicion,true,'rendicion','Reporte Rendición');
	this.AdicionarBoton("../../../lib/imagenes/det.ico",'Contabilizar',btn_conta,true, 'contabilizar','Contabilizar');
	this.AdicionarBoton("../../../lib/imagenes/print.gif",'Vista Previa Rendición',btn_vp_rendicion,true, 'vis_previa','Vista Previa');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Revertir la finalización de la rendición',btn_corregir_rendicion,true,'corregir_rendicion','Corregir Rendición');
	//this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Rendicion',btn_fin,true,'fin','Finalizar Rendicion');
	function bloquearbotones(){
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('rendicion-'+idContenedor).disable();
		CM_getBoton('contabilizar-'+idContenedor).disable();
		CM_getBoton('corregir_rendicion-'+idContenedor).disable();
		//CM_getBoton('reposicion-'+idContenedor).disable();
		//CM_getBoton('fin-'+idContenedor).disable();
			
	}
	
	enable=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		bloquearbotones();
		CM_getBoton('rendicion-'+idContenedor).enable();
		if(rec.data['estado']=='borrador'){
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('contabilizar-'+idContenedor).enable();
			
			
		}
		else if(rec.data['estado']=='conta_rendicion'){
			//CM_getBoton('reposicion-'+idContenedor).enable();
			CM_getBoton('corregir_rendicion-'+idContenedor).enable();
						
		}
	}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_rendicion_caja.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}