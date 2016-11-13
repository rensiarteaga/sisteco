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
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_salida_pedido_p(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_salida_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-25 15:08:17
*/
function pagina_salida_pedido_p(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var componentes=new Array();
	var data_ep;
	var ds;
	var elementos=new Array();
	var sw=0;

	var combo_almacen,combo_almacen_logico,combo_motivo_salida,combo_motivo_salida_cuenta,cmb_ep;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/salida/ActionListarSalidaPedidoPersonal.php'}),
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
		'id_tipo_material',
		'desc_tipo_material',
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
		'tipo_pedido'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo:'Personal',
			tipo_pedido:'Item'
		}
	});
	//DATA STORE COMBOS
	ds_almacen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen',
		totalRecords:'TotalCount'
	},['id_almacen','nombre','descripcion'])
	});

	ds_almacen_logico=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEp.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen_logico',
		totalRecords:'TotalCount'
	}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])
	});


	ds_motivo_salida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_salida/ActionListarMotivoSalidaEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_salida',
		totalRecords: 'TotalCount'
	}, ['id_motivo_salida','nombre','descripcion','fecha_reg'])
	});

	ds_motivo_salida_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_salida_cuenta/ActionListarMotivoSalidaCuenta.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_salida_cuenta',
		totalRecords: 'TotalCount'
	}, ['id_motivo_salida_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
	});

	ds_tipo_material = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_material/ActionListarTipoMaterial.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_tipo_material',
		totalRecords: 'TotalCount'
	}, ['id_tipo_material','nombre','descripcion','observaciones','fecha_reg'])
	});

	//FUNCIONES RENDER
	function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen'])}
	function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico'])}
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado'])}
	function render_id_motivo_salida_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_salida_cuenta'])}
	function render_id_motivo_salida(value, p, record){return String.format('{0}', record.data['desc_motivo_salida'])}
	function render_id_tipo_material(value, p, record){return String.format('{0}', record.data['desc_tipo_material'])}
	function render_observaciones(value, p, record){return String.format('<b><font color="#FF0000">{0}</font></b>', record.data['observaciones'])}

	// Template combo
	var resultTplAlmacen = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogico = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	var resultTplTipoMaterial = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplMotivoSalida = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplMotivoSalidaCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');

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
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
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
			width_grid:200,
			grid_indice:8
		},
		tipo:'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'SALIDA.descripcion',
		save_as:'txt_descripcion',
		id_grupo:4
	};

	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Almacen Físico',
			allowBlank:false,
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
			grid_indice:2,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen',
		id_grupo:2
	};
	filterCols_almacen_logico=new Array();
	filterValues_almacen_logico=new Array();
	filterCols_almacen_logico[0]='ALMACE.id_almacen';
	filterValues_almacen_logico[0]='x';

	vectorAtributos[3]={
		validacion:{
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
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:2
	};

	vectorAtributos[1]={
		validacion: {
			name:'id_tipo_material',
			fieldLabel:'Tipo Material',
			allowBlank:false,
			emptyText:'Tipo Material...',
			desc: 'desc_tipo_material',
			store:ds_tipo_material,
			valueField: 'id_tipo_material',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPMAT.nombre#TIPMAT.descripcion',
			tpl:resultTplTipoMaterial,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_material,
			grid_visible:true,
			grid_editable:false,
			grid_indice:7,
			width_grid:110
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMAT.nombre',
		defecto: '',
		save_as:'txt_id_tipo_material',
		id_grupo:4
	};

	fcC=new Array();
	fcV=new Array();
	fcC[0]='MOTSAL.tipo';
	fcV[0]='Personal';

	vectorAtributos[5]={
		validacion: {
			fieldLabel:'Motivo salida',
			allowBlank:false,
			emptyText:'Motivo Salida ...',
			name:'id_motivo_salida',
			desc:'desc_motivo_salida',
			store:ds_motivo_salida,
			valueField: 'id_motivo_salida',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MOTSAL.descripcion',
			filterCols:fcC,
			filterValues:fcV,
			tpl:resultTplMotivoSalida,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:250,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_salida,
			grid_visible:true,
			grid_editable:false,
			grid_indice:5,
			width_grid:170
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MOTSAL.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_salida',
		id_grupo:3
	};


	filterCols_motivo_salida_cuenta=new Array();
	filterValues_motivo_salida_cuenta=new Array();
	filterCols_motivo_salida_cuenta[0]='MOTSAL.id_motivo_salida';
	filterValues_motivo_salida_cuenta[0]='%';

	vectorAtributos[6]={
		validacion:{
			fieldLabel:'Cuenta',
			allowBlank:false,
			emptyText:'Cuenta ...',
			name:'id_motivo_salida_cuenta',
			desc:'desc_motivo_salida_cuenta',
			store:ds_motivo_salida_cuenta,
			valueField: 'id_motivo_salida_cuenta',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MSALCU.descripcion',
			tpl:resultTplMotivoSalidaCuenta,
			filterCols:filterCols_motivo_salida_cuenta,
			filterValues:filterValues_motivo_salida_cuenta,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_salida_cuenta,
			grid_visible:true,
			grid_editable:false,
			grid_indice:6,
			width_grid:170
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MOSACU.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_salida_cuenta',
		id_grupo:3
	};

	vectorAtributos[7]= {
		validacion:{
			fieldLabel: 'Estructura Programática',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep',
			minChars: 1,
			triggerAction: 'all',
			editable:false,
			grid_editable:false,
			grid_visible:true,
			grid_indice:18,
			width:350
		},
		tipo: 'epField',
		save_as:'hidden_id_ep1',
		id_grupo:0
	};

	vectorAtributos[8]={
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

	vectorAtributos[9]={
		validacion:{
			name:'desc_empleado',
			fieldLabel:'Funcionario',
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			width:'100%',
			grid_indice:4,
			width_grid:150
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_desc_empleado',
		id_grupo:1
	};
	vectorAtributos[10]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			disabled:false,
			renderer:render_observaciones,
			grid_visible:false,
			grid_editable:false,
			grid_indice:9,
			width_grid:200
		},
		form:true,
		tipo:'TextArea',
		filtro_0:false,
		filterColValue:'SALIDA.observaciones',
		id_grupo:0
	};

	vectorAtributos[11]={
		validacion:{
			name:'tipo_pedido',
			fieldLabel:'Tipo pedido',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			grid_indice:10,
			align:'center',
			width_grid:100
		},
		tipo:'TextField',
		defecto:'Item',
		save_as:'txt_tipo_pedido',
		id_grupo:0
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={titulo_maestro:'Pedido',grid_maestro:'grid-'+idContenedor};
	layout_salida=new DocsLayoutMaestro(idContenedor);
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
	var Cm_getComponente=this.getComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnNew=this.btnNew;
	var Cm_btnEdit=this.btnEdit;
	var Cm_onResize=this.onResize;
	var Cm_SaveAndOther=this.SaveAndOther;
	var Cm_btnActualizar = this.btnActualizar;
	var Cm_Destroy = this.Cm_Destroy;
	var Cm_getGrid=this.getGrid;
	var Cm_EnableSelect=this.EnableSelect;
	var Cm_getDialog=this.getDialog;
	var Cm_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;

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
		btnEliminar:{url:direccion+'../../../control/salida/ActionEliminarSalida.php',parametros:'&tipo=Personal&tipo_pedido=Item'},
		Save:{url:direccion+'../../../control/salida/ActionGuardarSalidaPedido.php',parametros:'&tipo=Personal&tipo_pedido=Item'},
		ConfirmSave:{url:direccion+'../../../control/salida/ActionGuardarSalidaPedido.php',parametros:'&tipo=Personal&tipo_pedido=Item'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',columnas:['96%'],
		grupos:[{tituloGrupo:'Estructura Programática',columna:0,id_grupo:0},
		{tituloGrupo:'Funcionario Solicitante',columna:0,id_grupo:1},
		{tituloGrupo:'Almacén',columna:0,id_grupo:2},
		{tituloGrupo:'Motivo de Salida',columna:0,id_grupo:3},
		{tituloGrupo:'Datos Pedido',columna:0,id_grupo:4}
		],minWidth:150,minHeight:200,	closable:true,titulo:'Pedido'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_salida_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			data=data+'&m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_salida.loadWindows(direccion+'../../salida_pedido_detalle/salida_pedido_detalle_det.php?'+data,'Detalles Material Solicitud',ParamVentana);
			layout_salida.getVentana().on('resize',function(){
				layout_salida.getLayout().layout();
			})
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		combo_almacen = Cm_getComponente('id_almacen');
		combo_almacen_logico = Cm_getComponente('id_almacen_logico');
		combo_motivo_salida = Cm_getComponente('id_motivo_salida');
		combo_motivo_salida_cuenta = Cm_getComponente('id_motivo_salida_cuenta');
		cmb_ep=Cm_getComponente('id_ep');

		var onMotivoSalidaSelect = function(e){
			var id = combo_motivo_salida.getValue();
			combo_motivo_salida_cuenta.filterValues[0] =  id;
			combo_motivo_salida_cuenta.modificado = true;
			combo_motivo_salida_cuenta.setValue('');
			combo_motivo_salida.modificado=true;
			combo_motivo_salida_cuenta.enable()
		};

		var onAlmacenSelect = function(e){
			var id = combo_almacen.getValue();
			combo_almacen_logico.filterValues[0] =  id;
			combo_almacen_logico.modificado = true;
			combo_almacen_logico.setValue('');
			combo_almacen.modificado=true;
			combo_almacen_logico.enable()
		};

		var onEpSelect = function(e){
			var ep=cmb_ep.getValue();
			data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			//Actualiza los datastore de los combos para filtrar por EP
			actualizar_ds_combos();
			//Limpia los valores de los combos
			combo_almacen.setValue('');
			combo_almacen_logico.setValue('');
			combo_motivo_salida.setValue('');
			combo_motivo_salida_cuenta.setValue('');
			//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
			combo_almacen.modificado=true;
			combo_almacen_logico.modificado=true;
			combo_motivo_salida.modificado=true;
			combo_motivo_salida_cuenta.modificado=true;
			combo_almacen.enable();
			combo_motivo_salida.enable()
		};

		combo_almacen.on('select', onAlmacenSelect);
		combo_almacen.on('change', onAlmacenSelect);
		combo_motivo_salida.on('select',onMotivoSalidaSelect);
		combo_motivo_salida.on('change',onMotivoSalidaSelect);
		cmb_ep.on('change',onEpSelect);
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.btnNew=function(){
		CM_ocultarComponente(componentes[10]);
		CM_ocultarComponente(componentes[11]);//tipo_pedido
		componentes[2].disable();//almacen fisico
		componentes[3].disable();//almacen logico
		componentes[5].disable();//motivo salida
		componentes[6].disable();//motivo salida cuenta
		obtEmpleado();
		Cm_btnNew()
	}
	this.btnEdit=function(){
		CM_ocultarComponente(componentes[10]);
		CM_ocultarComponente(componentes[11]);//tipo_pedido
		componentes[2].enable();//almacen fisico
		componentes[3].enable();//almacen logico
		componentes[5].enable();//motivo salida
		componentes[6].enable();//motivo salida cuenta
		Cm_btnEdit()
	}

	this.EnableSelect=function(selModel,row,selected){
		Cm_EnableSelect(selModel,row,selected)
		var ep=cmb_ep.getValue();
		data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
		//Actualiza los datastore de los combos para filtrar por EP
		actualizar_ds_combos();
		combo_motivo_salida_cuenta.filterValues[0]=combo_motivo_salida.getValue();
		var id=combo_almacen.getValue();
		combo_almacen_logico.filterValues[0] =  id;
		combo_almacen.modificado=true;
		combo_almacen_logico.modificado=true;
		combo_motivo_salida.modificado=true;
		combo_motivo_salida_cuenta.modificado=true
	};

	//función para terminar la orden de ingreso
	function btn_fin_ped(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			if(confirm("¿Está seguro de terminar el Pedido?")){
				var SelectionsRecord=sm.getSelected();
				var data=SelectionsRecord.data.id_salida;
				Ext.Ajax.request({
					url:direccion+"../../../control/salida/ActionGuardarSalidaPedidoFin.php?hidden_id_salida_0="+data,
					method:'GET',
					success:terminado,
					failure:Cm_conexionFailure,
					timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
				})
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
	}
	//función para terminar la orden de ingreso
	function obtEmpleado(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionEmpleadoLogueado.php",
			method:'GET',
			success:ter,
			failure:Cm_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		})
	}
	//recupera nombre e id de empleado y llena el formulario
	function ter(resp){
		var root = resp.responseXML.documentElement;
		if(root.getElementsByTagName('id_empleado')[0]!==undefined){
			id_emp = root.getElementsByTagName('id_empleado')[0].firstChild.nodeValue;
			if(id_emp!="null"){
				componentes[8].setValue(id_emp);
				var empleado=root.getElementsByTagName('nombre')[0].firstChild.nodeValue;
				empleado=empleado+" "+ root.getElementsByTagName('paterno')[0].firstChild.nodeValue;
				empleado=empleado+" " +root.getElementsByTagName('materno')[0].firstChild.nodeValue;
				componentes[9].setValue(empleado)
			}
			else{
				alert("Solamentes usuarios registrados como empleados pueden hacer pedidos");
				dialog.hide()
			}
		}
		else{
			alert("Ocurrió un error en la petición de verificación de usuario")
		}
	}

	function terminado(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado', '<br>Finalización satisfactoria del Pedido.<br>');
		Cm_btnActualizar()
	}
	function btn_pedido_almacen(){
		datax = "hidden_id_salida="+Cm_getComponente('id_salida').getValue();
		window.open(direccion+'../../../control/_reportes/pedidos/ActionReportePedidos.php?'+datax)
	}

	function actualizar_ds_combos(){
		var datos=Ext.urlDecode(decodeURIComponent(data_ep)); 	
		Ext.apply(combo_almacen.store.baseParams,datos);
		Ext.apply(combo_almacen_logico.store.baseParams,datos);
		Ext.apply(combo_motivo_salida.store.baseParams,datos);
		Ext.apply(combo_motivo_salida_cuenta.baseParams,datos)
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

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_orden_ingreso_sol.getLayout()
	};

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_salida.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Destroy=function(){delete this.pagina;	Cm_Destroy()};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle del Pedido',btn_salida_detalle,true,'salida_detalle','');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar el Pedido',btn_fin_ped,true,'fin_pe','');
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Imprimir el Pedido',btn_pedido_almacen,true,'rep_ped','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitPaginaSalidaPedido();
	layout_salida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}