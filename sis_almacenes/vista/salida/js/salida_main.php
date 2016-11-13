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
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
var elemento={pagina:new pagina_salida(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_salida_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 15:08:17
 */
function pagina_salida(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/salida/ActionListarSalida.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_salida',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_salida',
		'codigo',
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
		'id_subactividad'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

    ds_responsable_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/responsable_almacen/ActionListarResponsableAlmacen.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_responsable_almacen',
			totalRecords: 'TotalCount'
		}, ['id_responsable_almacen','estado','cargo','fecha_asignacion','fecha_reg','observaciones','id_almacen','id_empleado'])
	});

    ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogico.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_logico',
			totalRecords: 'TotalCount'
		}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])
	});

    ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'
		}, ['id_empleado','id_persona','codigo_empleado'])
	});

    ds_firma_autorizada = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/firma_autorizada/ActionListarFirmaAutorizada.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_firma_autorizada',
			totalRecords: 'TotalCount'
		}, ['id_firma_autorizada','descripcion','prioridad','estado_reg','observaciones','fecha_reg','id_empleado_frppa','id_motivo_salida','id_motivo_ingreso'])
	});

    ds_contratista = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/contratista/ActionListarContratista.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_contratista',
			totalRecords: 'TotalCount'
		}, ['id_contratista','codigo','observaciones','estado_registro','fecha_reg','id_institucion','id_persona'])
	});

    ds_tipo_material = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_material/ActionListarTipoMaterial.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_material',
			totalRecords: 'TotalCount'
		}, ['id_tipo_material','nombre','descripcion','observaciones','fecha_reg'])
	});

    ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});

    ds_subactividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/subactividad/ActionListarSubactividad.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subactividad',
			totalRecords: 'TotalCount'
		}, ['id_subactividad','codigo','direccion','descripcion','observaciones','fecha_reg','id_prog_proy_acti'])
	});

	//FUNCIONES RENDER
	
			function render_id_responsable_almacen(value, p, record){return String.format('{0}', record.data['desc_responsable_almacen']);}
			function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
			function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
			function render_id_firma_autorizada(value, p, record){return String.format('{0}', record.data['desc_firma_autorizada']);}
			function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista']);}
			function render_id_tipo_material(value, p, record){return String.format('{0}', record.data['desc_tipo_material']);}
			function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
			function render_id_subactividad(value, p, record){return String.format('{0}', record.data['desc_subactividad']);}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_salida
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_salida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_salida'
	};
	// txt codigo
	vectorAtributos[1] = {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.codigo',
		save_as:'txt_codigo'
	};
	// txt correlativo_sal
	vectorAtributos[2] = {
		validacion:{
			name:'correlativo_sal',
			fieldLabel:'Cor. Salida',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.correlativo_sal',
		save_as:'txt_correlativo_sal'
	};
	// txt correlativo_vale
	vectorAtributos[3] = {
		validacion:{
			name:'correlativo_vale',
			fieldLabel:'Corr. Vale',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.correlativo_vale',
		save_as:'txt_correlativo_vale'
	};
	// txt descripcion
	vectorAtributos[4] = {
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
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'SALIDA.descripcion',
		save_as:'txt_descripcion'
	};
	// txt contabilizar
	vectorAtributos[5] = {
			validacion: {
			name:'contabilizar',
			fieldLabel:'Contabilizar',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_combo.contabilizar}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.contabilizar',
		defecto:'si',
		save_as:'txt_contabilizar'
	};
	// txt contabilizado
	vectorAtributos[6] = {
			validacion: {
			name:'contabilizado',
			fieldLabel:'Contabilizado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_combo.contabilizado}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.contabilizado',
		defecto:'si',
		save_as:'txt_contabilizado'
	};
	// txt estado_salida
	vectorAtributos[7] = {
			validacion: {
			name:'estado_salida',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_combo.estado_salida}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Borrador','Borrador'],['Pendiente','Pendiente'],['Aprobado','Aprobado'],['Rechazado','Rechazado'],['Entregado','Entregado'],['Finalizado','Finalizado'],['Cancelado','Cancelado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.estado_salida',
		defecto:'Borrador',
		save_as:'txt_estado_salida'
	};
	// txt tipo_entrega
	vectorAtributos[8] = {
			validacion: {
			name:'tipo_entrega',
			fieldLabel:'Tipo Entrega',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_combo.tipo_entrega}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Provisional','Provisional'],['Consolidado','Consolidado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.tipo_entrega',
		defecto:'Provisional',
		save_as:'txt_tipo_entrega'
	};
	// txt estado_registro
	vectorAtributos[9] = {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.salida_combo.estado_registro}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['activo','activo'],['inactivo','inactivo'],['eliminado','eliminado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SALIDA.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	// txt motivo_cancelacion
	vectorAtributos[10] = {
		validacion:{
			name:'motivo_cancelacion',
			fieldLabel:'Motivo Can',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'SALIDA.motivo_cancelacion',
		save_as:'txt_motivo_cancelacion'
	};
	// txt id_responsable_almacen
	vectorAtributos[11] = {
			validacion: {
			name:'id_responsable_almacen',
			fieldLabel:'Responsable',
			allowBlank:false,			
			emptyText:'Responsable...',
			desc: 'desc_responsable_almacen', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_responsable_almacen,
			valueField: 'id_responsable_almacen',
			displayField: 'cargo',
			queryParam: 'filterValue_0',
			filterCol:'RESALM.cargo',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_responsable_almacen,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RESALM.cargo',
		defecto: '',
		save_as:'txt_id_responsable_almacen'
	};
	// txt id_almacen_logico
	vectorAtributos[12] = {
			validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico',
			allowBlank:false,			
			emptyText:'Almacén Lógico...',
			desc: 'desc_almacen_logico', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_logico,
			valueField: 'id_almacen_logico',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMLOG.codigo',
		defecto: '',
		save_as:'txt_id_almacen_logico'
	};
	// txt id_empleado
	vectorAtributos[13] = {
			validacion: {
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:false,			
			emptyText:'Funcionario...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.id_persona',
		defecto: '',
		save_as:'txt_id_empleado'
	};
	// txt id_firma_autorizada
	vectorAtributos[14] = {
			validacion: {
			name:'id_firma_autorizada',
			fieldLabel:'Firma Autorizada',
			allowBlank:false,			
			emptyText:'Firma Autorizada...',
			desc: 'desc_firma_autorizada', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_firma_autorizada,
			valueField: 'id_firma_autorizada',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'FIRAUT.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_firma_autorizada,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'FIRAUT.descripcion',
		defecto: '',
		save_as:'txt_id_firma_autorizada'
	};
	// txt id_contratista
	vectorAtributos[15] = {
			validacion: {
			name:'id_contratista',
			fieldLabel:'Contratista',
			allowBlank:false,			
			emptyText:'Contratista...',
			desc: 'desc_contratista', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_contratista,
			valueField: 'id_contratista',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'CONTRA.codigo#CONTRA.observaciones',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_contratista,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONTRA.codigo',
		defecto: '',
		save_as:'txt_id_contratista'
	};
	// txt id_tipo_material
	vectorAtributos[16] = {
			validacion: {
			name:'id_tipo_material',
			fieldLabel:'Tipo Material',
			allowBlank:false,			
			emptyText:'Tipo Material...',
			desc: 'desc_tipo_material', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_material,
			valueField: 'id_tipo_material',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPMAT.nombre#TIPMAT.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_material,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMAT.nombre',
		defecto: '',
		save_as:'txt_id_tipo_material'
	};
	// txt id_institucion
	vectorAtributos[17] = {
			validacion: {
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,			
			emptyText:'Institución...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INSTIT.nombre',
		defecto: '',
		save_as:'txt_id_institucion'
	};
	// txt id_subactividad
	vectorAtributos[18] = {
			validacion: {
			name:'id_subactividad',
			fieldLabel:'Sub Actividad',
			allowBlank:true,			
			emptyText:'Sub Actividad...',
			desc: 'desc_subactividad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subactividad,
			valueField: 'id_subactividad',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'SUBACT.codigo#SUBACT.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subactividad,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBACT.codigo',
		defecto: '',
		save_as:'txt_id_subactividad'
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
	var config = {
		titulo_maestro:'salida',
		grid_maestro:'grid-'+idContenedor
	};
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
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

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
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/salida/ActionEliminarSalida.php'},
		Save:{url:direccion+'../../../control/salida/ActionGuardarSalida.php'},
		ConfirmSave:{url:direccion+'../../../control/salida/ActionGuardarSalida.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
		width:480,
			minWidth:150,minHeight:200,	closable:true,titulo:'salida'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_salida_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_salida='+SelectionsRecord.data.id_salida;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={ventana:{width:'90%',height:'70%'}}
			layout_salida.loadWindows(direccion+'../../salida_detalle/salida_detalle_det.php?'+data,'Detalles Material Solicitud',ParamVentana);
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
		
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_salida.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_salida_detalle,true,'salida_detalle','Detalles Material Solicitud');

				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_salida.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}