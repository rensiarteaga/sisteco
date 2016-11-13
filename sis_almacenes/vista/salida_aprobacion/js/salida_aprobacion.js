/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_salida_aprobacion(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var grid;
	var dialog;
	var sm;
	var formulario;
	var url;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/salida/ActionListarSalidaAprobacion.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_salida',totalRecords:'TotalCount'},
		[
		// define el mapeo de XML a las etiquetas (campos)
		'id_salida',
		'codigo',
		'correlativo_sal',
		'correlativo_vale',
		{name: 'fecha_pendiente',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'estado_salida',
		'motivo_cancelacion',
		'estado_registro',
		'desc_responsable_almacen',
		'desc_almacen_logico',
		'desc_empleado',
		'desc_firma_autorizada',
		'desc_contratista',
		'desc_tipo_material',
		'desc_institucion',
		'desc_subactividad',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',
		'nro_cuenta',
		'observaciones',
		'emergencia',
		'desc_motivo_salida',
		'tipo_pedido',
		'tipo_entrega'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,

		}
	});

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_salida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		form:true,
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
	};

	vectorAtributos[1]={
		validacion:{
			name:'correlativo_vale',
			fieldLabel:'Corr. Vale',
			grid_visible:false,
			grid_editable:true,
			width_grid:70
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.correlativo_vale'
	};

	vectorAtributos[2]= {
		validacion:{
			name:'fecha_pendiente',
			fieldLabel:'Fecha Solicitud',
			format: 'd/m/Y', //formato para validacion
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			grid_indice:12,
			disabled:true
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.fecha_pendiente',
		dateFormat:'m-d-Y'
	};

	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.descripcion'
	};

	vectorAtributos[4]={
		validacion:{
			fieldLabel:'Almacen Lógico',
			name:'desc_almacen_logico',
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:100
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion'
	};

	vectorAtributos[5]= {
		validacion: {
			fieldLabel:'Funcionario',
			name: 'desc_empleado',
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'EMPLEA.id_persona#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno'
	};

	vectorAtributos[6]= {
		validacion: {
			name:'desc_contratista',
			fieldLabel:'Contratista',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CONTRA.codigo'
	};
	
	vectorAtributos[7]= {
		validacion: {
			name:'desc_institucion',
			fieldLabel:'Institución',
			grid_visible:true,
			grid_editable:false,
			grid_indice:5,
			width_grid:120
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'INSTIT.nombre'
	};

	vectorAtributos[8]= {
		validacion: {
			name:'desc_tipo_material',
			fieldLabel:'Tipo Material',
			grid_visible:true,
			grid_editable:false,
			grid_indice:8,
			width_grid:110
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'TIPMAT.nombre'
	};

	vectorAtributos[9]={
		validacion: {
			fieldLabel:'Cuenta',
			name: 'desc_motivo_salida_cuenta',
			grid_visible:true,
			grid_editable:false,
			grid_indice:7,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'MOSACU.descripcion'
	};
	
	vectorAtributos[10]={
		validacion: {
			fieldLabel:'Firma Autorizada',
			name: 'desc_firma_autorizada',
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'PERSON2.nombre#PERSON2.apellido_paterno#PERSON2.apellido_materno'
	};
	
	vectorAtributos[11]={
		validacion:{
			name:'estado_salida',
			fieldLabel:'Estado',
			grid_visible:false,
			grid_editable:false,
			width_grid:100
		},
		form:true,
		tipo: 'Field',
		filtro_0:false,
		filterColValue:'SALIDA.estado_salida',
		save_as:'txt_estado_salida'
	};

	vectorAtributos[12]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			grid_visible:true,
			grid_editable:false,
			grid_indice:11,
			width_grid:100,
			width:'100%'
		},
		form:true,
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'SALIDA.observaciones',
		save_as:'txt_observaciones'
	};

	vectorAtributos[13]={
		validacion:{
			name:'emergencia',
			fieldLabel:'Emergencia',
			grid_visible:true,
			grid_editable:false,
			grid_indice:9,
			width_grid:100
		},
		form:true,
		tipo: 'Field',
		filtro_0:false,
		filterColValue:'SALIDA.estado_salida',
		save_as:'txt_emergencia'
	};

	vectorAtributos[14]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_empleado'
	};

	vectorAtributos[15]={
		validacion: {
			fieldLabel:'Motivo Salida',
			name: 'desc_motivo_salida',
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'MOTSAL.nombre'
	};

	vectorAtributos[16]={
		validacion: {
			fieldLabel:'Tipo de Pedido',
			name: 'tipo_pedido',
			grid_visible:true,
			grid_editable:false,
			grid_indice:0,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:true,
		filterColValue:'SALIDA.tipo_pedido'
	};

	vectorAtributos[17]={
		validacion: {
			fieldLabel:'Tipo Entrega',
			name: 'tipo_entrega',
			grid_visible:true,
			grid_editable:false,
			grid_indice:13,
			width_grid:200
		},
		form:false,
		tipo:'Field',
		filtro_0:false,
		filterColValue:'SALIDA.tipo_entrega'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y'):''
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'salida',
		grid_maestro:'grid-'+idContenedor
	};
	layout_salida_aprobacion=new DocsLayoutMaestro(idContenedor);
	layout_salida_aprobacion.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida_aprobacion,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var Cm_getComponente=this.getComponente;
	var Cm_getDialog=this.getDialog;
	var Cm_getGrid=this.getGrid;
	var Cm_getFormulario=this.getFormulario;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_onResize=this.onResize;
	var CM_ocultarComponente=this.ocultarComponente;
	var Cm_btnEdit=this.btnEdit;
	var Cm_Destroy=this.Destroy;
	var Cm_btnActualizar=this.btnActualizar;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={actualizar:{crear:true,separador:false}};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones={
		Save:{url:direccion+'../../../control/salida/ActionAprobarSalida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,
		width:480,
		minWidth:150,minHeight:200,	closable:true,titulo:'Aprobación de Salida'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_detalle_material(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_estado_reg='+SelectionsRecord.data.estado_registro;
			data = data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'80%',height:'70%'}}
			if(SelectionsRecord.data.tipo_pedido=='Item'){
				url='../../salida_aprobacion_detalle/salida_aprobacion_detalle_det.php?';
			}else{
				if(SelectionsRecord.data.tipo_pedido=='Tipo Unidad Constructiva'){
					url='../../salida_aprobacion_detalle/salida_aprobacion_det_tuc.php?';///cambiar!!!!
				}
				else{//Unidad Constructiva
					url:'../../salida_aprobacion_detalle/salida_aprobacion_det_tuc.php?';//cambiar...
				}
			}
			layout_salida_aprobacion.loadWindows(direccion+url+data,'Detalles de Aprobación de Salida',ParamVentana);
			layout_salida_aprobacion.getVentana().on('resize',function(){
				layout_salida_aprobacion.getLayout().layout();
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function btn_aprobar()
	{
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		var tipoEntrega = SelectionsRecord.data.tipo_entrega;
		var sw=1;

		if(tipoEntrega=='Parcial')
		{
			if(confirm("Las existencias de materiales no cubren todo el Pedido TUC.\n\n¿Quiere aprobar el Pedido de todas formas?"))
			{sw=1;}
			else
			{sw=0;}
		}
		else
		{
			if(tipoEntrega=='Verificado')
			{
				Ext.MessageBox.alert('Alerta', 'Previamente debe ejecutar el proceso de Verificación.');
				sw=0;
			}
		}
		if(sw)
		{
			dialog.setTitle("Aprobar Pedido");
			CM_ocultarComponente(componentes[1]);
			CM_ocultarComponente(componentes[3]);
			componentes[1].setValue("Aprobado");
			componentes[2].setValue("");
			dialog.buttons[0].enable();
			dialog.buttons[0].setText("Aprobar");
			Cm_btnEdit()
		}
	}

	function btn_rechazar(){
		CM_ocultarComponente(componentes[3]);
		if(componentes[3].getValue()=='No'){
			dialog.setTitle("Rechazar Pedido");
			CM_ocultarComponente(componentes[1]);
			componentes[1].setValue("Rechazado");
			componentes[2].setValue("");
			dialog.buttons[0].enable();
			dialog.buttons[0].setText("Rechazar");
			Cm_btnEdit()
		}
		else{
			Ext.MessageBox.alert('Estado', 'No es posible rechazar esta salida');
		}

	}
	function btn_correccion(){
		CM_ocultarComponente(componentes[3]);
		if(componentes[3].getValue()=='No'){
			dialog.setTitle("Solicitar Corrección");
			CM_ocultarComponente(componentes[1]);
			componentes[1].setValue("Borrador");
			componentes[2].setValue("");
			dialog.buttons[0].enable();
			dialog.buttons[0].setText("Solicitar Correccion");
			Cm_btnEdit()
		}
		else{
			Ext.MessageBox.alert('Estado', 'No es posible realizar la solicitud de corrección');
		}
	}

	function btn_salida_aprobacion(){

		datax = "hidden_id_salida=" + Cm_getComponente('id_salida').getValue();
		window.open(direccion+'../../../control/_reportes/salida_almacen/ActionReporteSalidaAprobacion.php?'+datax)
	}

	//función para verificar y reservar los materailes del pedido
	function btn_ver(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();

		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.tipo_pedido=='Item')
			{
				Ext.MessageBox.alert('Información', 'Este proceso de Verificación se aplica solo para Pedidos de (Tipos de) Unidades Constructivas.')
			}
			else
			{
				if(SelectionsRecord.data.tipo_pedido=='Tipo Unidad Constructiva')
				{
					if(confirm("¿Está seguro de verificar las existencias del Pedido?\n\nEste proceso puede tardar varios minutos!"))
					{
						var SelectionsRecord=sm.getSelected();
						Ext.Ajax.request({
							url:direccion+"../../../control/salida/ActionVerificarReservarExistenciasUc.php?id_salida="+SelectionsRecord.data.id_salida+"&id_almacen_logico="+SelectionsRecord.data.id_almacen_logico,
							method:'GET',
							success:verificado,
							failure:Cm_conexionFailure,
							timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
						})
					}
				}
				else //Unidad Constructiva
				{
					Ext.MessageBox.alert('ESTADO', 'Pedido UC.')
				}
			}

		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}

	function verificado(resp){
		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText);
		if(regreso.mensaje=='true'){
			Ext.MessageBox.alert('Estado', 'Verificación de exitosa')
		}
		else{
			alert("reporte de faltantes")
		}
		Cm_btnActualizar()
	}

	function iniciarPaginaSalidaAprobacion()
	{
		grid=Cm_getGrid();
		dialog=Cm_getDialog();
		sm=getSelectionModel();
		formulario=Cm_getFormulario();
		componentes[1]=Cm_getComponente("estado_salida");
		componentes[2]=Cm_getComponente("observaciones");
		componentes[3]=Cm_getComponente("emergencia");
		componentes[4]=Cm_getComponente("id_empleado")
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_salida_aprobacion.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.Destroy=function(){delete this.pagina;	Cm_Destroy()};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle del Pedido',btn_detalle_material,true,'det_ped','');
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar el Pedido',btn_aprobar,true,'apr_ped','');
	this.AdicionarBoton('../../../lib/imagenes/pedido_delete.png','Rechazar el Pedido',btn_rechazar,false,'rech_ped','');
	this.AdicionarBoton('../../../lib/imagenes/det.ico','Solicitar Corrección del Pedido',btn_correccion,false,'correc_ped','');
	this.AdicionarBoton('../../../lib/imagenes/lightning.png','Verificar Existencias Tipo de Unidad Constructiva',btn_ver,false,'verificar','');
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Imprimir Vale',btn_salida_aprobacion,true,'rep_ped','');
	this.iniciaFormulario();
	iniciarPaginaSalidaAprobacion();


	layout_salida_aprobacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}