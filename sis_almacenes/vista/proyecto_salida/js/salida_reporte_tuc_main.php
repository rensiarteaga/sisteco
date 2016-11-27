<?php 
/**
 * Nombre:		  	    salida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:08:17
 *
 */
session_start();
?>
//<script>
function main(){
	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
	echo "var idContenedor='$idContenedor';";
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:3,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
	var elemento={pagina:new pagina_salida_reporte_tuc(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_salida_reporte_tuc(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var componentes=new Array();
	var data_ep;
	var ds;
	var elementos=new Array();
	var sw=0;

	var combo_almacen,combo_almacen_logico,combo_solicitante,combo_contratista,combo_empleado,combo_institucion;
	var combo_motivo_salida,combo_motivo_salida_cuenta,cmb_ep,cmb_subactividad,cmb_tramo_subactividad,cmb_tramo_unidad_constructiva;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/salida/ActionListarSalidaReporte.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_salida',totalRecords:'TotalCount'},
		[
		// define el mapeo de XML a las etiquetas (campos)
		'id_salida',
		'correlativo_sal',
		'correlativo_vale',
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
		'id_motivo_salida',
		'desc_motivo_salida',
		'desc_almacen',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'observaciones',
		'tipo_pedido',
		'receptor',
		'id_tramo_subactividad',
		'id_tramo_unidad_constructiva',
		'desc_tramo',
		'desc_unidad_cons',
		{name: 'fecha_borrador',type:'date',dateFormat:'Y-m-d'},
		'id_supervisor',
		'receptor_ci',
		'solicitante',
		'solicitante_ci',
		'num_contrato',
		'nombre_superv',
		'gestion',
		'id_motivo_salida',
		'id_almacen'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo_pedido:'Tipo Unidad Constructiva'
		}
	});
	//DATA STORE COMBOS
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'idalmacen',totalRecords:'TotalCount'}, ['id_almacen','nombre','descripcion'])});
	ds_almacen_logico=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEP.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_almacen_logico',totalRecords:'TotalCount'}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])});
	
	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico'])}
	
	

	function render_observaciones(value, p, record){return String.format('<b><font color="#FF0000">{0}</font></b>', record.data['observaciones'])}
	

	// Template combo
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			//fieldLabel:'ID',
			name: 'id_salida',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:1,
			width_grid:50
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
	};

	

	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Almacen Físico',
			allowBlank:true,
			emptyText:'Almacen Físico...',
			name:'id_almacen',
			desc:'desc_almacen',
			store:ds_almacen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacen,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
			width_grid:140
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen',
		id_grupo:1
	};


	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='%';

	vectorAtributos[2]={
		validacion:{
			name:'id_almacen_logico',
			fieldLabel:'Almacen Lógico',
			allowBlank:false,
			emptyText:'Almacen Lógico...',
			name:'id_almacen_logico',
			desc:'desc_almacen_logico',
			store:ds_almacen_logico,
			valueField:'id_almacen_logico',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico,
			filterValues:filterValues_almacen_logico,
			typeAhead:true,
			forceSelection:true,
			tpl: resultTplAlmacenLogico,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			width_grid:140
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:1
	};


	vectorAtributos[3]={
		validacion:{
			fieldLabel: 'Estructura Programática',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:25
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:0
	};
	
	 vectorAtributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			width_grid:220,
			width:'100%',
			//grid_indice:3
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'SALIDA.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
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
	var config={titulo_maestro:'Pedido',grid_maestro:'grid-'+idContenedor};
	var layout_salida=new DocsLayoutMaestro(idContenedor);
	layout_salida.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_salida,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var Cm_EnableSelect=this.EnableSelect;
	var Cm_getComponente=this.getComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnNew=this.btnNew;
	var Cm_btnEdit=this.btnEdit;
	var Cm_onResize=this.onResize;
	var Cm_btnActualizar = this.btnActualizar;

	var Cm_getGrid=this.getGrid;
	var Cm_getDialog=this.getDialog;
	var Cm_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var Cm_Destroy=this.Destroy;
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
		btnEliminar:{url:direccion+'../../../control/salida/ActionEliminarSalida.php',parametros:'&tipo_pedido=Tipo Unidad Constructiva&tipo='},
		Save:{url:direccion+'../../../control/salida/ActionGuardarSalidaReporte.php',parametros:'&tipo_pedido=Tipo Unidad Constructiva&tipo='},
		ConfirmSave:{url:direccion+'../../../control/salida/ActionGuardarSalidaReporte.php',parametros:'&tipo_pedido=Tipo Unidad Constructiva&tipo='},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',columnas:['96%'],
		grupos:[{tituloGrupo:'Estructura Programática',columna:0,id_grupo:0},		
		{tituloGrupo:'Almacén',columna:0,id_grupo:1},		
		{tituloGrupo:'Descripción del Reporte',columna:0,id_grupo:2}		],
		minWidth:150,minHeight:200,	closable:true,titulo:'Pedido'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_almacen = Cm_getComponente('id_almacen');
		combo_almacen_logico = Cm_getComponente('id_almacen_logico');
		
		cmb_ep=Cm_getComponente('id_ep');
		

		

		var onAlmacenSelect=function(e) {
			var id = combo_almacen.getValue();
			combo_almacen_logico.filterValues[0] =  id;
			combo_almacen_logico.modificado = true;
			combo_almacen_logico.enable();//almacen logico
			combo_almacen_logico.setValue('');
			combo_almacen.modificado=true
		};

		
		var onEpSelect = function(e){
			var ep=cmb_ep.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			combo_almacen.setValue('');
			combo_almacen_logico.setValue('');
			
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			combo_almacen.modificado=true;
			combo_almacen.enable();
			combo_almacen_logico.modificado=true;
			
			
			
		};

		combo_almacen.on('select', onAlmacenSelect);
		combo_almacen.on('change', onAlmacenSelect);
		cmb_ep.on('change',onEpSelect);
		
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.btnNew=function(){
		//Sólo muestra el contratista por defecto
		
		
		componentes[1].disable();//almacen fisico
		componentes[2].disable();//almacen logico
		Cm_btnNew()
	}
	//Sobrecarga del edit, para desplegar el origen del ingreso
	this.btnEdit=function(){		
		componentes[1].enable();//almacen fisico
		componentes[2].enable();//almacen logico		
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){			
			Cm_btnEdit()
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}


	};

	this.EnableSelect=function(selModel,row,selected){
		Cm_EnableSelect(selModel,row,selected)
		var ep=cmb_ep.getValue();
		data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
		//Actualiza los datastore de los combos para filtrar por EP
		actualizar_ds_combos();		
		var id=combo_almacen.getValue();
		combo_almacen_logico.filterValues[0] =  id;
		combo_almacen.modificado=true;
		combo_almacen_logico.modificado=true;
		

	};

	

	function terminado(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Finalización satisfactoria del Pedido.<br>');
		Cm_btnActualizar()
	}


	//función para verificar y reservar los materailes del pedido
	function btn_ver(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(confirm("¿Está seguro de verificar las existencias del Pedido?\n\nEste proceso puede tardar varios minutos.")){
				var SelectionsRecord=sm.getSelected();
				Ext.MessageBox.show({
						title: 'Verificando existencias',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Espere por favor...</div>",
						width:200,
						height:200,
						closable:false
					});
				Ext.Ajax.request({
					url:direccion+"../../../control/salida/ActionVerificarExistenciasUc.php?id_salida="+SelectionsRecord.data.id_salida+"&id_almacen_logico="+SelectionsRecord.data.id_almacen_logico,
					method:'GET',
					success:verificado,
					failure:Cm_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				})
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
			Ext.MessageBox.alert('Estado', 'Existencias suficientes para el Pedido.')
		}
		else{
			alert("No hay existencias suficientes para cubrir con el Pedido.");
			//RCM: 08/06/2008 yucumo
			datax = "hidden_id_salida=" + Cm_getComponente('id_salida').getValue();
			//datax = 'maestro_id_salida='+idSalida;
			window.open(direccion+'../../../control/_reportes/pedido_materiales/ActionReporteFaltantesTUC.php?'+datax)


		}
		Cm_btnActualizar()

	}
	
	
	//Imprime el listado del material sin firmas, sólo para consulta
	function btn_listado_material(){
		var idSalida = Cm_getComponente('id_salida').getValue();
		if(idSalida!=''){
			var data='hidden_id_salida='+idSalida;
			window.open(direccion+'../../../control/_reportes/pedido_materiales/ActionReporteFaltantesTUC.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar una salida.')
		}
	}

	//Imprime el Pedido de material, sólo la cabecera
	function btn_pedido_cab(){
		var idSalida = Cm_getComponente('id_salida').getValue();
		if(idSalida!=''){
			var data='maestro_id_salida='+idSalida;
			window.open(direccion+'../../../control/_reportes/pedido_materiales/ActionPedidoCab.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar una salida.')
		}
	}

	function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep));
		Ext.apply(combo_almacen.store.baseParams,datos);
		Ext.apply(combo_almacen_logico.store.baseParams,datos)
		
	}

	//Obtener los componentes del formulario
	function InitPaginaSalidaPedido(){
		grid=Cm_getGrid();
		dialog=Cm_getDialog();
		sm=getSelectionModel();
		formulario=Cm_getFormulario();
		for(i=0;i<vectorAtributos.length;i++){
			componentes[i]=Cm_getComponente(vectorAtributos[i].validacion.name)
		}
	
	}
	
	function btn_pedido_tuc_int(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_correlativo_sal='+SelectionsRecord.data.correlativo_sal;
			var ParamVentana={Ventana:{width:'90%',height:'80%'}}
			layout_salida.loadWindows(direccion+'../../../vista/pedido_tuc_int/pedido_tuc_int_det.php?'+data,'Materiales',ParamVentana);
			layout_salida.getVentana().on('resize',function(){layout_salida.getLayout().layout()})
		}
		else{Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	
	function btn_verificar(){
		
		var sm=getSelectionModel();
	
	
		
		var SelectionsRecord=sm.getSelected();
		//var data='maestro_id_salida='+SelectionsRecord.data.id_salida+'&maestro_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
		
		var data='hidden_id_salida='+SelectionsRecord.data.id_salida;
		
		console.log('data....', data)
		if(SelectionsRecord.data){
			
			
			
			window.open(direccion+'../../../control/_reportes/pedido_materiales/ActionReporteConsolidadoTUC.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar una salida.')
		}
	}
	
	
	
	function btn_verificar_resumen(){
		
		var sm=getSelectionModel();
	
	
		
		var SelectionsRecord=sm.getSelected();
		//var data='maestro_id_salida='+SelectionsRecord.data.id_salida+'&maestro_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
		
		var data='hidden_id_salida='+SelectionsRecord.data.id_salida;
		
		console.log('data....', data)
		if(SelectionsRecord.data){
			
			
			
			window.open(direccion+'../../../control/_reportes/pedido_materiales/ActionReporteConsolidadoResTUC.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar una salida.')
		}
	}
	
	
	
	function btn_salida_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_salida.loadWindows(direccion+'../../salida_pedido_detalle/salida_pedido_unidad_cons_arb.php?'+data,'Detalles Material Solicitud',ParamVentana);
			layout_salida.getVentana().on('resize',function(){layout_salida.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_salida.getLayout()
	};
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
	
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle del Pedido',btn_salida_detalle,true,'salida_detalle','');
	this.AdicionarBoton('../../../lib/imagenes/lightning.png','Verificar Existencias Tipo de Unidad Constructiva',btn_ver,true,'vr','');	
	this.AdicionarBoton('../../../lib/imagenes/book_open.png','Materiales',btn_pedido_tuc_int,true,'pedido_tuc_int','');
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Imprimir Lista de Materiales',btn_listado_material,true,'listado','');	
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Verificar  Unidades Constructivas',btn_verificar,true,'verexist','',false);
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Verificar  Resumen Unidades Constructivas',btn_verificar_resumen,true,'verexistres','',false);
	

	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSalidaPedido();
	layout_salida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}