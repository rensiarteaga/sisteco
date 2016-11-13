<?php 
/**
 * Nombre:		  	    ingreso_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 20:49:02
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
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};
var elemento={pagina:new pagina_ingreso(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_ingreso_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 20:49:02
 */
function pagina_ingreso(idContenedor,direccion,paramConfig)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ingreso/ActionListarIngreso.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_ingreso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_ingreso',
		'correlativo_ord_ing',
		'correlativo_ing',
		'codigo',
		'descripcion',
		'observaciones',
		'costo_total',
		'contabilizar',
		'contabilizado',
		'estado_ingreso',
		'estado_registro',
		'cod_inf_tec',
		'resumen_inf_tec',
		{name: 'fecha_borrador',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_pendiente',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_aprobado_rechazado',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_ing_fisico',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_ing_valorado',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_finalizado_cancelado',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_responsable_almacen',
		'desc_responsable_almacen',
		'id_proveedor',
		'desc_proveedor',
		'id_contratista',
		'desc_contratista',
		'id_empleado',
		'desc_empleado',
		'id_almacen_logico',
		'desc_almacen_logico',
		'id_firma_autorizada',
		'desc_firma_autorizada',
		'id_institucion',
		'desc_institucion',
		'id_motivo_ingreso',
		'desc_motivo_ingreso',
		'desc_almacen',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad'
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

    ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proveedor',
			totalRecords: 'TotalCount'
		}, ['id_proveedor','codigo','observaciones','fecha_reg','id_institucion','id_persona'])
	});

    ds_contratista = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/contratista/ActionListarContratista.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_contratista',
			totalRecords: 'TotalCount'
		}, ['id_contratista','codigo','observaciones','estado_registro','fecha_reg','id_institucion','id_persona'])
	});

    ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'
		}, ['id_empleado','id_persona','codigo_empleado'])
	});

    ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogico.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_almacen_logico',
			totalRecords: 'TotalCount'
		}, ['id_almacen_logico','codigo','bloqueado','nombre','descripcion','estado_registro','fecha_reg','obsevaciones','id_almacen_ep','id_tipo_almacen'])
	});

    ds_firma_autorizada = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/firma_autorizada/ActionListarFirmaAutorizada.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_firma_autorizada',
			totalRecords: 'TotalCount'
		}, ['id_firma_autorizada','estado','descripcion','prioridad','estado_reg','observaciones','fecha_reg','id_empleado','id_empleado_frppa','id_motivo_salida','id_motivo_ingreso'])
	});

    ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_institucion',
			totalRecords: 'TotalCount'
		}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});

    ds_motivo_ingreso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngreso.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_motivo_ingreso',
			totalRecords: 'TotalCount'
		}, ['id_motivo_ingreso','nombre','descripcion','estado_registro','fecha_reg'])
	});

	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_financiador',totalRecords:'TotalCount'},['id_financiador','nombre_financiador'])});
	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/regional/ActionListaRegionalEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_regional',totalRecords:'TotalCount'},['id_regional','nombre_regional'])});
	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/programa/ActionListaProgramaEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_programa',totalRecords:'TotalCount'},['id_programa','nombre_programa'])});
	ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords:'TotalCount'},['id_proyecto','nombre_proyecto'])});
	ds_actividad = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+"../../../../sis_parametros/control/actividad/ActionListaActividadEP.php"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_actividad',totalRecords:'TotalCount'},['id_actividad','nombre_actividad'])});
	
	//FUNCIONES RENDER
	
			function render_id_responsable_almacen(value, p, record){return String.format('{0}', record.data['desc_responsable_almacen']);}
			function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
			function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista']);}
			function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
			function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
			function render_id_firma_autorizada(value, p, record){return String.format('{0}', record.data['desc_firma_autorizada']);}
			function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
			function render_id_motivo_ingreso(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso']);}
	function renderFinanciador(value,p,record){return String.format('{0}',record.data['desc_financiador']);}
	function renderRegional(value,p,record){return String.format('{0}',record.data['desc_regional']);}
	function renderPrograma(value,p,record){return String.format('{0}',record.data['desc_programa']);}
	function renderProyecto(value,p,record){return String.format('{0}',record.data['desc_proyecto']);}
	function renderActividad(value,p,record){return String.format('{0}',record.data['desc_actividad']);}
	
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_ingreso
	//en la posición 0 siempre esta la llave primaria

	var param_id_ingreso = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_ingreso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_ingreso'
	};
	vectorAtributos[0] = param_id_ingreso;
// txt correlativo_ord_ing
	var param_correlativo_ord_ing= {
		validacion:{
			name:'correlativo_ord_ing',
			fieldLabel:'Correlativo Ord. Ingreso',
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
		filterColValue:'INGRES.correlativo_ord_ing',
		save_as:'txt_correlativo_ord_ing'
	};
	vectorAtributos[1] = param_correlativo_ord_ing;
// txt correlativo_ing
	var param_correlativo_ing= {
		validacion:{
			name:'correlativo_ing',
			fieldLabel:'Correlativo Ingreso',
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
		filterColValue:'INGRES.correlativo_ing',
		save_as:'txt_correlativo_ing'
	};
	vectorAtributos[2] = param_correlativo_ing;
// txt codigo
	var param_codigo= {
		validacion:{
			name:'codigo',
			fieldLabel:'codigo',
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
		filterColValue:'INGRES.codigo',
		save_as:'txt_codigo'
	};
	vectorAtributos[3] = param_codigo;
// txt descripcion
	var param_descripcion= {
		validacion:{
			name:'descripcion',
			fieldLabel:'descripcion',
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
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[4] = param_descripcion;
// txt observaciones
	var param_observaciones= {
		validacion:{
			name:'observaciones',
			fieldLabel:'observaciones',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.observaciones',
		save_as:'txt_observaciones'
	};
	vectorAtributos[5] = param_observaciones;
// txt costo_total
	var param_costo_total= {
		validacion:{
			name:'costo_total',
			fieldLabel:'Costo Total',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :3,//para numeros float
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
		filterColValue:'INGRES.costo_total',
		save_as:'txt_costo_total'
	};
	vectorAtributos[6] = param_costo_total;
// txt contabilizar
	var param_contabilizar= {
			validacion: {
			name:'contabilizar',
			fieldLabel:'contabilizar',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.ingreso_combo.contabilizar}),
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data :  [['si','si'],['no','no']]}),
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
		filterColValue:'INGRES.contabilizar',
		defecto:'si',
		save_as:'txt_contabilizar'
	};
	vectorAtributos[7] = param_contabilizar;
// txt contabilizado
	var param_contabilizado= {
			validacion: {
			name:'contabilizado',
			fieldLabel:'contabilizado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.ingreso_combo.contabilizado}),
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
		filterColValue:'INGRES.contabilizado',
		defecto:'si',
		save_as:'txt_contabilizado'
	};
	vectorAtributos[8] = param_contabilizado;
// txt estado_ingreso
	var param_estado_ingreso= {
			validacion: {
			name:'estado_ingreso',
			fieldLabel:'estado_ingreso',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : [['Borrador','Borrador'],['Pendiente','Pendiente'],['Aprobado','Aprobado'],['Ejecutado','Ejecutado'],['Anulado','Anulado']]}),
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
		filterColValue:'INGRES.estado_ingreso',
		defecto:'Borrador',
		save_as:'txt_estado_ingreso'
	};
	vectorAtributos[9] = param_estado_ingreso;
// txt estado_registro
	var param_estado_registro= {
			validacion: {
			name:'estado_registro',
			fieldLabel:'Estado registro',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID','valor'],data : Ext.ingreso_combo.estado_registro}),
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
		filterColValue:'INGRES.estado_registro',
		defecto:'activo',
		save_as:'txt_estado_registro'
	};
	vectorAtributos[10] = param_estado_registro;
// txt cod_inf_tec
	var param_cod_inf_tec= {
		validacion:{
			name:'cod_inf_tec',
			fieldLabel:'cod_inf_tec',
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
		filterColValue:'INGRES.cod_inf_tec',
		save_as:'txt_cod_inf_tec'
	};
	vectorAtributos[11] = param_cod_inf_tec;
// txt resumen_inf_tec
	var param_resumen_inf_tec= {
		validacion:{
			name:'resumen_inf_tec',
			fieldLabel:'Resumen Inf Técnico',
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
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.resumen_inf_tec',
		save_as:'txt_resumen_inf_tec'
	};
	vectorAtributos[12] = param_resumen_inf_tec;
// txt fecha_borrador
	var param_fecha_borrador= {
		validacion:{
			name:'fecha_borrador',
			fieldLabel:'Fecha borrador',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_borrador',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_borrador'
	};
	vectorAtributos[13] = param_fecha_borrador;
// txt fecha_pendiente
	var param_fecha_pendiente= {
		validacion:{
			name:'fecha_pendiente',
			fieldLabel:'Fecha pendiente',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_pendiente',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_pendiente'
	};
	vectorAtributos[14] = param_fecha_pendiente;
// txt fecha_aprobado_rechazado
	var param_fecha_aprobado_rechazado= {
		validacion:{
			name:'fecha_aprobado_rechazado',
			fieldLabel:'Fecha aprobación',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_aprobado_rechazado',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_aprobado_rechazado'
	};
	vectorAtributos[15] = param_fecha_aprobado_rechazado;
// txt fecha_ing_fisico
	var param_fecha_ing_fisico= {
		validacion:{
			name:'fecha_ing_fisico',
			fieldLabel:'Fecha ingreso físico',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_ing_fisico',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ing_fisico'
	};
	vectorAtributos[16] = param_fecha_ing_fisico;
// txt fecha_ing_valorado
	var param_fecha_ing_valorado= {
		validacion:{
			name:'fecha_ing_valorado',
			fieldLabel:'Fecha valorado',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_ing_valorado',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ing_valorado'
	};
	vectorAtributos[17] = param_fecha_ing_valorado;
// txt fecha_finalizado_cancelado
	var param_fecha_finalizado_cancelado= {
		validacion:{
			name:'fecha_finalizado_cancelado',
			fieldLabel:'Fecha finalizado',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_finalizado_cancelado',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_finalizado_cancelado'
	};
	vectorAtributos[18] = param_fecha_finalizado_cancelado;
// txt fecha_reg
	var param_fecha_reg= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'INGRES.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[19] = param_fecha_reg;
// txt id_responsable_almacen
	var param_id_responsable_almacen= {
			validacion: {
			name:'id_responsable_almacen',
			fieldLabel:'Id Responsable',
			allowBlank:false,			
			emptyText:'Id Responsable...',
			name: 'id_responsable_almacen',     //indica la columna del store principal ds del que proviane el id
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
	vectorAtributos[20] = param_id_responsable_almacen;
// txt id_proveedor
	var param_id_proveedor= {
			validacion: {
			name:'id_proveedor',
			fieldLabel:'id_proveedor',
			allowBlank:false,			
			emptyText:'id_proveedor...',
			name: 'id_proveedor',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'codigo',
			queryParam: 'filterValue_0',
			filterCol:'PROVEE.codigo#PROVEE.observaciones',
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
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROVEE.codigo',
		defecto: '',
		save_as:'txt_id_proveedor'
	};
	vectorAtributos[21] = param_id_proveedor;
// txt id_contratista
	var param_id_contratista= {
			validacion: {
			name:'id_contratista',
			fieldLabel:'id_contratista',
			allowBlank:false,			
			emptyText:'id_contratista...',
			name: 'id_contratista',     //indica la columna del store principal ds del que proviane el id
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
	vectorAtributos[22] = param_id_contratista;
// txt id_empleado
	var param_id_empleado= {
			validacion: {
			name:'id_empleado',
			fieldLabel:'id_empleado',
			allowBlank:false,			
			emptyText:'id_empleado...',
			name: 'id_empleado',     //indica la columna del store principal ds del que proviane el id
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
	vectorAtributos[23] = param_id_empleado;
// txt id_almacen_logico
	var param_id_almacen_logico= {
			validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Id Almacén Lógico',
			allowBlank:false,			
			emptyText:'Id Almacén Lógico...',
			name: 'id_almacen_logico',     //indica la columna del store principal ds del que proviane el id
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
	vectorAtributos[24] = param_id_almacen_logico;
// txt id_firma_autorizada
	var param_id_firma_autorizada= {
			validacion: {
			name:'id_firma_autorizada',
			fieldLabel:'Id Firma Autorizada',
			allowBlank:false,			
			emptyText:'Id Firma Autorizada...',
			name: 'id_firma_autorizada',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_firma_autorizada', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_firma_autorizada,
			valueField: 'id_firma_autorizada',
			displayField: 'estado',
			queryParam: 'filterValue_0',
			filterCol:'FIRAUT.estado#FIRAUT.descripcion',
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
		filterColValue:'FIRAUT.estado',
		defecto: '',
		save_as:'txt_id_firma_autorizada'
	};
	vectorAtributos[25] = param_id_firma_autorizada;
// txt id_institucion
	var param_id_institucion= {
			validacion: {
			name:'id_institucion',
			fieldLabel:'id_institucion',
			allowBlank:false,			
			emptyText:'id_institucion...',
			name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
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
	vectorAtributos[26] = param_id_institucion;
// txt id_motivo_ingreso
	var param_id_motivo_ingreso= {
			validacion: {
			name:'id_motivo_ingreso',
			fieldLabel:'id_motivo_ingreso',
			allowBlank:false,			
			emptyText:'id_motivo_ingreso...',
			name: 'id_motivo_ingreso',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_motivo_ingreso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_motivo_ingreso,
			valueField: 'id_motivo_ingreso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MOTING.nombre#MOTING.descripcion',
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
			renderer:render_id_motivo_ingreso,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MOTING.nombre',
		defecto: '',
		save_as:'txt_id_motivo_ingreso'
	};
	vectorAtributos[27] = param_id_motivo_ingreso;

	var param_id_financiador={validacion:{fieldLabel:'Financiador',allowBlank:false,vtype:'texto',emptyText:'Financiador...',name:'id_financiador',desc:'desc_financiador',store:ds_financiador,valueField:'id_financiador',displayField:'nombre_financiador',queryParam:'filterValue_0',filterCol:'nombre_financiador',typeAhead:true,forceSelection:true,renderer:renderFinanciador,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_financiador',tipo:'ComboBox'};
	vectorAtributos[28] = param_id_financiador;
	filterCols_regional=new Array();
	filterValues_regional=new Array();
	filterCols_regional[0]='frppa.id_financiador';
	filterValues_regional[0]='%';

	var param_id_regional={validacion:{fieldLabel:'Regional',allowBlank:false,vtype:'texto',emptyText:'Regional...',name:'id_regional',desc:'desc_regional',store:ds_regional,valueField:'id_regional',displayField:'nombre_regional',queryParam:'filterValue_0',filterCol:'REGION.codigo_regional#REGION.descripcion_regional',filterCols:filterCols_regional,filterValues:filterValues_regional,typeAhead:true,forceSelection:true,renderer:renderRegional,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_regional',tipo:'ComboBox'};
	vectorAtributos[29]=param_id_regional;
	filterCols_programa=new Array();
	filterValues_programa=new Array();
	filterCols_programa[0]='frppa.id_financiador';
	filterValues_programa[0]='%';
	filterCols_programa[1]='frppa.id_regional';
	filterValues_programa[1]='%';

	var param_id_programa={validacion:{fieldLabel:'Programa',allowBlank:false,vtype:'texto',emptyText:'Programa...',name:'id_programa',desc:'desc_programa',store:ds_programa,valueField:'id_programa',displayField:'nombre_programa',queryParam:'filterValue_0',filterCol:'nombre_programa',filterCols:filterCols_programa,filterValues:filterValues_programa,typeAhead:true,forceSelection:true,renderer:renderPrograma,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_programa',tipo:'ComboBox'};
	vectorAtributos[30]=param_id_programa;
	filterCols_proyecto=new Array();
	filterValues_proyecto=new Array();
	filterCols_proyecto[0]='frppa.id_financiador';
	filterValues_proyecto[0]='%';
	filterCols_proyecto[1]='frppa.id_regional';
	filterValues_proyecto[1]='%';
	filterCols_proyecto[2]='ppa.id_programa';
	filterValues_proyecto[2]='%';

	var paramId_proyecto={validacion:{fieldLabel:'Proyecto',allowBlank:false,vtype:'texto',emptyText:'Proyecto...',name:'id_proyecto',desc:'desc_proyecto',store:ds_proyecto,valueField:'id_proyecto',displayField:'nombre_proyecto',queryParam:'filterValue_0',filterCol:'nombre_proyecto',filterCols:filterCols_proyecto,filterValues:filterValues_proyecto,typeAhead:true,forceSelection:true,renderer:renderProyecto,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_proyecto',tipo:'ComboBox'};
	vectorAtributos[31]=paramId_proyecto;
	filterCols_actividad=new Array();
	filterValues_actividad=new Array();
	filterCols_actividad[0]='frppa.id_financiador';
	filterValues_actividad[0]='%';
	filterCols_actividad[1]='frppa.id_regional';
	filterValues_actividad[1]='%';
	filterCols_actividad[2]='ppa.id_programa';
	filterValues_actividad[2]='%';
	filterCols_actividad[3]='ppa.id_proyecto';
	filterValues_actividad[3]='%';

	var param_id_actividad={validacion:{fieldLabel:'Actividad',allowBlank:false,vtype:'texto',emptyText:'Actividad...',name:'id_actividad',desc:'desc_actividad',store:ds_actividad ,valueField:'id_actividad',displayField:'nombre_actividad',queryParam:'filterValue_0',filterCol:'nombre_actividad',filterCols:filterCols_actividad,filterValues:filterValues_actividad,typeAhead:true,forceSelection:true,renderer:renderActividad,mode:'remote',queryDelay:50,pageSize:10,minListWidth:300,width:200,resizable:true,queryParam:'filterValue_0',minChars:0,triggerAction:'all',editable:true,grid_visible:true,grid_editable:false,width_grid:100},id_grupo:1,save_as:'txt_id_actividad',tipo:'ComboBox'};
	vectorAtributos[32]=param_id_actividad;
	
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
		titulo_maestro:'ingreso',
		grid_maestro:'grid-'+idContenedor
	};
	layout_ingreso=new DocsLayoutMaestroEP(idContenedor);
	layout_ingreso.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_ingreso,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/ingreso/ActionEliminarIngreso.php'},
		Save:{url:direccion+'../../../control/ingreso/ActionGuardarIngreso.php'},
		ConfirmSave:{url:direccion+'../../../control/ingreso/ActionGuardarIngreso.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
			columnas:['47%','47%'],grupos:[{tituloGrupo:'almacen_ep',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',	columna:1,id_grupo:1}],width:'90%',
			minWidth:150,minHeight:200,	closable:true,titulo:'ingreso'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_ingreso_detalle(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_ingreso='+SelectionsRecord.data.id_ingreso;
			data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;

			var ParamVentana={ventan:{width:'90%',height:'70%'}}
			layout_ingreso.loadWindows(direccion+'../../../Almacenes/ingreso_detalle/ingreso_detalle_det.php?'+data,'Detalle Orden Ingreso (Aprobación)',ParamVentana);
layout_ingreso.getVentana().on('resize',function(){
			layout_ingreso.getLayout().layout();
				})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		

		// EVENTOS EP
		combo_financiador = ClaseMadre_getComponente('id_financiador');
		combo_regional = ClaseMadre_getComponente('id_regional');
		combo_programa = ClaseMadre_getComponente('id_programa');
		combo_proyecto = ClaseMadre_getComponente('id_proyecto');
		combo_actividad = ClaseMadre_getComponente('id_actividad');


		var onFinanciadorSelect = function(e) {
			var id = combo_financiador.getValue()
			combo_regional.filterValues[0] =  id;
			combo_regional.modificado = true;
			combo_programa.filterValues[0] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[0] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[0] =  id;
			combo_actividad.modificado = true;
			combo_regional.setValue('');
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onRegionalSelect = function(e) {
			var id = combo_regional.getValue()
			combo_programa.filterValues[1] =  id;
			combo_programa.modificado = true;
			combo_proyecto.filterValues[1] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[1] =  id;
			combo_actividad.modificado = true;
			combo_programa.setValue('');
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProgramaSelect = function(e) {
			var id = combo_programa.getValue()
			combo_proyecto.filterValues[2] =  id;
			combo_proyecto.modificado = true;
			combo_actividad.filterValues[2] =  id;
			combo_actividad.modificado = true;
			combo_proyecto.setValue('');
			combo_actividad.setValue('');

		};
		var onProyectoSelect = function(e) {
			var id = combo_proyecto.getValue()
			combo_actividad.filterValues[3] =  id;
			combo_actividad.modificado = true;
			combo_actividad.setValue('');

		};

		combo_financiador.on('select', onFinanciadorSelect);
		combo_financiador.on('change', onFinanciadorSelect);
		combo_regional.on('select', onRegionalSelect);
		combo_regional.on('change', onRegionalSelect);
		combo_programa.on('select', onProgramaSelect);
		combo_programa.on('change', onProgramaSelect);
		combo_proyecto.on('select', onProyectoSelect);
		combo_proyecto.on('change', onProyectoSelect);
		//fin eventos EP
	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_ingreso.getLayout();};
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
				
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_ingreso_detalle,true,'ingreso_detalle','Detalle Orden Ingreso (Aprobación)');

				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_ingreso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}