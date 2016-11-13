/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_salida_pendiente(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var url;
	var combo_provisional,combo_prov_entreg,combo_tuc,emergencia,estado_salida,tipo_pedido;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida/ActionListarSalidaPendiente.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_salida',totalRecords: 'TotalCount'},
		[
		// define el mapeo de XML a las etiquetas (campos)
		'id_salida',
		'codigo',
		'correlativo_sal',
		'correlativo_vale',
		{name: 'fecha_aprobado_rechazado',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'contabilizar',
		'contabilizado',
		'estado_salida',
		'tipo_entrega',
		'estado_registro',
		'motivo_cancelacion',
		'id_responsable_almacen',
		'desc_responsable_almacen',
		'id_almacen_logico',
		'desc_almacen_logico',
		'id_empleado',
		'desc_empleado',
		'id_firma_autorizada',
		'desc_firma_autorizada',
		'id_contratista',
		'desc_contratista',
		'id_tipo_material',
		'desc_tipo_material',
		'id_institucion',
		'desc_institucion',
		'desc_subactividad',
		'id_subactividad',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',
		'nro_cuenta',
		'observaciones',
		'emergencia',
		'desc_motivo_salida',
		'tipo_pedido',
		'tipo_entrega'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});

		/////////////////////////
		// Definición de datos //
		/////////////////////////

		vectorAtributos[0]= {
			validacion:{
				labelSeparator:'',
				name:'id_salida',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
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
				width_grid:70,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			filterColValue:'SALIDA.correlativo_vale',
			save_as:'txt_correlativo_vale'
		};

		vectorAtributos[2]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				grid_visible:true,
				grid_editable:false,
				grid_indice:10,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:false,
			filterColValue:'SALIDA.descripcion',
			save_as:'txt_descripcion'
		};

		vectorAtributos[3]={
			validacion:{
				fieldLabel:'Almacen Lógico',
				name:'desc_almacen_logico',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:100
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			save_as:'txt_id_almacen_logico'
		};

		vectorAtributos[4]= {
			validacion: {
				fieldLabel:'Funcionario',
				name:'desc_empleado',
				grid_visible:true,
				grid_editable:false,
				grid_indice:3,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'EMPLEA.id_persona#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			save_as:'txt_id_empleado'
		};

		vectorAtributos[5]= {
			validacion: {
				name:'desc_contratista',
				fieldLabel:'Contratista',
				grid_visible:true,
				grid_editable:false,
				grid_indice:4,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'CONTRA.codigo',
			save_as:'txt_id_contratista'
		};

		vectorAtributos[6]= {
			validacion: {
				name:'desc_institucion',
				fieldLabel:'Institución',
				grid_visible:true,
				grid_editable:false,
				grid_indice:5,
				width_grid:120
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'INSTIT.nombre',
			save_as:'txt_id_institucion'
		};

		vectorAtributos[7]= {
			validacion: {
				name:'desc_tipo_material',
				fieldLabel:'Tipo Material',
				grid_visible:true,
				grid_editable:false,
				grid_indice:8,
				width_grid:110
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'TIPMAT.nombre',
			save_as:'txt_id_tipo_material'
		};

		vectorAtributos[8]= {
			validacion: {
				fieldLabel:'Cuenta',
				name: 'desc_motivo_salida_cuenta',
				editable:false,
				grid_visible:true,
				grid_editable:false,
				grid_indice:7,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'MOSACU.descripcion',
			save_as:'txt_id_motivo_salida_cuenta'
		};

		vectorAtributos[9]= {
			validacion: {
				fieldLabel:'Firma Autorizada',
				name: 'desc_firma_autorizada',
				grid_visible:true,
				grid_editable:false,
				grid_indice:2,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'FIRAUT.descripcion#PERSOn2.nombre#PERSON2.apellido_paterno#PERSON2.apellido_materno',
			save_as:'txt_id_firma_autorizada'
		};

		vectorAtributos[10]= {
			validacion: {
				name:'estado_salida_normal',
				fieldLabel:'Tipo de Entrega',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data:Ext.salida_pendiente_combo.estado_salida}),
				store: new Ext.data.SimpleStore({fields: ['ID','valor'],data: [['Entregado','Consolidado'],['Provisional','Provisional']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:60
			},
			tipo:'ComboBox',
			save_as:'txt_estado_salida_normal',
			id_grupo: 1
		};

		vectorAtributos[11]= {
			validacion: {
				name:'estado_registro',
				fieldLabel:'Estado registro',
				grid_visible:false,
				grid_editable:false,
				width_grid:60
			},
			tipo:'Field',
			filtro_0:false,
			filterColValue:'SALIDA.estado_registro',
			save_as:'txt_estado_registro'
		};

		vectorAtributos[12]={
			validacion:{
				name:'emergencia',
				fieldLabel:'Emergencia',
				grid_visible:true,
				grid_editable:true,
				grid_indice:9,
				width_grid:100
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'SALIDA.emergencia',
			save_as:'txt_emergencia'
		};

		vectorAtributos[13]= {
			validacion: {
				name:'estado_salida_emergencia',
				fieldLabel:'Tipo de Entrega',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data:Ext.salida_pendiente_combo.estado_salida_emergencia}),
				store: new Ext.data.SimpleStore({fields: ['ID','valor'],data:[['Provisional','Provisional']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:60
			},
			tipo:'ComboBox',
			save_as:'txt_estado_salida_emergencia',
			id_grupo:1
		};

		vectorAtributos[14]={
			validacion:{
				name:'estado_salida',
				fieldLabel:'Estado Salida',
				grid_visible:false,
				grid_editable:true,
				width_grid:100
			},
			tipo:'Field',
			filterColValue:'SALIDA.estado_salida',
			save_as:'txt_estado_salida'
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
			tipo:'Field',
			filtro_0:true,
			filterColValue:'MOTSAL.nombre'
		};

		vectorAtributos[16]={
			validacion: {
				fieldLabel:'Tipo Pedido',
				name: 'tipo_pedido',
				grid_visible:true,
				grid_editable:false,
				grid_indice:15,
				width_grid:200
			},
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
				grid_indice:15,
				width_grid:200
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'SALIDA.tipo_entrega'
		};

		vectorAtributos[18]= {
			validacion: {
				name:'estado_salida_tuc',
				fieldLabel:'Tipo de Entrega',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data:Ext.salida_pendiente_combo.estado_salida_tuc}),
				store: new Ext.data.SimpleStore({fields: ['ID','valor'],data:[['Entregado','Consolidado']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:true,
				width_grid:60
			},
			tipo:'ComboBox',
			save_as:'txt_estado_salida_tuc',
			id_grupo:1
		};

		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : ''
		};
		//////////////////////////////////////////////////////////////
		//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		//////////////////////////////////////////////////////////////
		//Inicia Layout
		var config = {
			titulo_maestro:'salida',
			grid_maestro:'grid-'+idContenedor
		};
		layout_salida_pendiente=new DocsLayoutMaestro(idContenedor);
		layout_salida_pendiente.init(config);
		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////
		/// HEREDAMOS DE LA CLASE MADRE
		this.pagina = Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,vectorAtributos,ds,layout_salida_pendiente,idContenedor);
		//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_getDialog=this.getDialog;
		var ClaseMadre_save=this.Save;
		var ClaseMadre_getGrid=this.getGrid;
		var ClaseMadre_getFormulario=this.getFormulario;
		var ClaseMadre_onResize=this.onResize;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var ClaseMadre_btnEdit=this.btnEdit;
		var ClaseMadre_btnEliminar = this.btnEliminar;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var Cm_Destroy=this.Destroy;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////
		var paramMenu={actualizar:{crear:true,separador:false}};
		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		//datos necesarios para el filtro
		var paramFunciones = {
			btnEliminar:{url:direccion+'../../../control/salida/ActionEliminarSalida.php'},
			Save:{url:direccion+'../../../control/salida/ActionGuardarSalidaPendiente.php'},
			ConfirmSave:{url:direccion+'../../../control/salida/ActionGuardarSalidaPendiente.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'30%',width:'45%',
			minWidth:150,minHeight:200,	closable:true,titulo:'Tipo de Entrega',
			grupos:[{tituloGrupo:'Oculto',columna:0,id_grupo:0},
			{tituloGrupo:'Entrega de Pedido',columna:0,id_grupo:1}
			]}
		};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function btn_detalle_pendiente(){
			var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_salida='+SelectionsRecord.data.id_salida;
				data=data+'&m_estado_reg='+SelectionsRecord.data.estado_registro;
				data=data+'&m_emergencia='+SelectionsRecord.data.emergencia;
				var ParamVentana={Ventana:{width:'70%',height:'60%'}}
				if(SelectionsRecord.data.tipo_pedido=='Item'){
					url='../../salida_pendiente_detalle/salida_pendiente_detalle_det.php?';
				}else{
					if(SelectionsRecord.data.tipo_pedido=='Tipo Unidad Constructiva'){
						url='../../salida_pendiente_detalle/salida_pendiente_det_tuc.php?';///cambiar!!!!
					}
					else{//Unidad Constructiva
						//url:'../../salida_pendiente_detalle/salida_pendiente_detalle_det2.php?';//cambiar...
						url:'../../salida_pendiente_detalle/salida_pendiente_det_tuc.php?';//cambiar...
					}
				}
				layout_salida_pendiente.loadWindows(direccion+url+data,'Detalles de Salidas Pendientes',ParamVentana);
				layout_salida_pendiente.getVentana().on('resize',function(){
					layout_salida_pendiente.getLayout().layout()
				})
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
			}
		}
		function btn_entregar_pedido(){

			CM_ocultarGrupo('Oculto');
			//CM_mostrarComponente(componentes[9]);

			if(componentes[15].getValue()=='Item')
			{

				if(componentes[11].getValue()=='Si'){
					//Emergencia
					CM_mostrarComponente(componentes[12]);
					CM_ocultarComponente(componentes[9]);
					CM_ocultarComponente(componentes[17]);
				}else{
					CM_ocultarComponente(componentes[12]);
					CM_mostrarComponente(componentes[9]);
					CM_ocultarComponente(componentes[17]);
				}
			}
			else
			{
				if(componentes[15].getValue()=='Tipo Unidad Constructiva')
				{
					CM_mostrarComponente(componentes[17]);
					CM_ocultarComponente(componentes[9]);
					CM_ocultarComponente(componentes[12]);
				}
				else //Unidad Constructiva
				{
					CM_mostrarComponente(componentes[17]);
					CM_ocultarComponente(componentes[9]);
					CM_ocultarComponente(componentes[12]);
				}
			}

			ClaseMadre_btnEdit();
		}
		function btn_salida_almacen(){

			datax = "hidden_id_salida=" + ClaseMadre_getComponente('id_salida').getValue();
			window.open(direccion+'../../../control/_reportes/salida_almacen/ActionReporteSalidaAlmacen.php?'+datax)
		}

		//Para manejo de eventos
		function iniciarEventosFormularios(){

			combo_provisional= ClaseMadre_getComponente('estado_salida_emergencia');
			combo_prov_entreg= ClaseMadre_getComponente('estado_salida_normal');
			combo_tuc= ClaseMadre_getComponente('estado_salida_tuc');
			emergencia= ClaseMadre_getComponente('emergencia');
			estado_salida = ClaseMadre_getComponente('estado_salida');
			tipo_pedido = ClaseMadre_getComponente('tipo_pedido');

			var onEstadoSalida = function(e){

				if(tipo_pedido.getValue()=='Item')
				{
					if(emergencia.getValue()=='Si'){
						estado_salida.setValue(combo_provisional.getValue())
					}
					else{
						estado_salida.setValue(combo_prov_entreg.getValue())
					}
				}
				else
				{
					if(tipo_pedido.getValue()=='Tipo Unidad Constructiva')
					{
						estado_salida.setValue(combo_tuc.getValue())
					}
					else //Unidad Constructiva
					{
						estado_salida.setValue(combo_tuc.getValue())
					}
				}
			};

			combo_provisional.on('select',onEstadoSalida);
			combo_provisional.on('change',onEstadoSalida);
			combo_prov_entreg.on('select',onEstadoSalida);
			combo_prov_entreg.on('change',onEstadoSalida)
			combo_tuc.on('select',onEstadoSalida);
			combo_tuc.on('change',onEstadoSalida)
		}

		function iniciarPaginaSalidaPendiente()
		{
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();
			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
			for(i=0;i<vectorAtributos.length-1;i++){

				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
			}
		}
		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_salida_pendiente.getLayout()};
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

		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle del Pedido',btn_detalle_pendiente,true,'sal_pend','');
		this.AdicionarBoton('../../../lib/imagenes/pedido.png','Entregar Material',btn_entregar_pedido,true,'sal_ent','');
		this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Imprimir Vale',btn_salida_almacen,true,'rep_val','');

		this.iniciaFormulario();
		iniciarPaginaSalidaPendiente();
		iniciarEventosFormularios();
		layout_salida_pendiente.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}
