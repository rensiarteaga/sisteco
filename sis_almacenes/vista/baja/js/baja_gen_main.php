<?php 
/**
 * Nombre:		  	    baja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Jose Abraham Mita Huanca
 * Fecha creación:		2007-12-13
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
	}
	?>
	var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_baja(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_transferencia_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-11-21 08:59:18
*/
function pagina_baja(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var data_ep_origen;
	var data_ep_destino;
	var componentes=new Array();
	var tipo_ord='Baja';
	var combo_almacen_origen,combo_almacen_destino,combo_almacen_logico_origen,combo_almacen_logico_destino;
	var	cmb_ep_origen,cmb_ep_destino,combo_motivo_ingreso,combo_motivo_ingreso_cuenta,combo_motivo_salida;
	var	combo_motivo_salida_cuenta,combo_empleado;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transferencia/ActionListarTransfBorrador.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_transferencia',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_transferencia',
		'prestamo',
		'estado_transferencia',
		'motivo',
		'descripcion',
		'observaciones',
		{name: 'fecha_pendiente_sal',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_pendiente_ing',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_finalizado_anulado',type:'date',dateFormat:'Y-m-d'},
		'id_empleado',
		'desc_empleado',
		'id_firma_autorizada_transf',
		'desc_firma_autorizada',
		'id_almacen_logico',
		'desc_almacen_logico_orig',
		'id_almacen_logico_destino',
		'desc_almacen_logico_dest',
		'id_motivo_ingreso_cuenta',
		'desc_motivo_ingreso_cuenta',
		'desc_almacen_orig',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'desc_almacen_dest',
		'nombre_financiador_dest',
		'nombre_regional_dest',
		'nombre_programa_dest',
		'nombre_proyecto_dest',
		'nombre_actividad_dest',
		'id_financiador_dest',
		'id_regional_dest',
		'id_programa_dest',
		'id_proyecto_dest',
		'id_actividad_dest',
		'codigo_financiador_dest',
		'codigo_regional_dest',
		'codigo_programa_dest',
		'codigo_proyecto_dest',
		'codigo_actividad_dest',
		{name: 'fecha_borrador',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_pendiente',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_rechazado',type:'date',dateFormat:'Y-m-d'},
		'id_ingreso',
		'id_salida',
		'id_tipo_material',
		'desc_tipo_material',
		'id_motivo_salida_cuenta',
		'desc_motivo_salida_cuenta',
		'desc_motivo_ingreso',
		'desc_motivo_salida'
		]),remoteSort:true
	});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			tipo:tipo_ord
		}
	});
	//DATA STORE COMBOS

	ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado_tpm_frppa/ActionListarEmpleadoUsuarioTpmFrppa.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_empleado',
		totalRecords: 'TotalCount'
	}, ['id_empleado','id_persona','codigo_empleado','desc_nombrecompleto'])
	});

	ds_almacen_logico_origen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen_logico',
		totalRecords: 'TotalCount'
	}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])
	});

	ds_almacen_logico_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_almacen_logico',
		totalRecords: 'TotalCount'
	}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])
	});

	ds_almacen_origen=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php?id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen',
		totalRecords:'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_almacen_destino=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/almacen/ActionListarAlmacenEP.php?id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_almacen',
		totalRecords:'TotalCount'
	}, ['id_almacen','nombre','descripcion'])
	});

	ds_motivo_ingreso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso/ActionListarMotivoIngresoEP.php?tipo=Baja&id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_ingreso',
		totalRecords: 'TotalCount'
	}, ['id_motivo_ingreso','nombre','descripcion','fecha_reg'])
	});

	ds_motivo_ingreso_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso_cuenta/ActionListarMotivoIngresoCuenta.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_motivo_ingreso_cuenta',
		totalRecords: 'TotalCount'
	}, ['id_motivo_ingreso_cuenta','desc_cuenta','descripcion','fecha_reg','codigo_ep'])
	});

	ds_motivo_salida=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_salida/ActionListarMotivoSalidaEP.php?tipo=Transferencia&id_financiador=-&id_regional=-&id_programa=-&id_proyecto=-&id_actividad=-'}),
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

	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function render_id_almacen_logico_origen(value, p, record){return String.format('{0}', record.data['desc_almacen_logico_orig']);}
	function render_id_almacen_logico_destino(value, p, record){return String.format('{0}', record.data['desc_almacen_logico_dest']);}
	function render_id_almacen_origen(value, p, record){return String.format('{0}', record.data['desc_almacen_orig']);}
	function render_id_almacen_destino(value, p, record){return String.format('{0}', record.data['desc_almacen_dest']);}
	function render_id_motivo_ingreso(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso']);}
	function render_id_motivo_ingreso_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_ingreso_cuenta']);}
	function render_id_motivo_salida(value, p, record){return String.format('{0}', record.data['desc_motivo_salida']);}
	function render_id_motivo_salida_cuenta(value, p, record){return String.format('{0}', record.data['desc_motivo_salida_cuenta']);}
	function render_id_tipo_material(value, p, record){return String.format('{0}', record.data['desc_tipo_material']);}

	var resultTplAlmacenOrigen = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenDestino = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplAlmacenLogicoOrigen = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	var resultTplAlmacenLogicoDestino = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}','<br>{desc_tipo_almacen}</FONT>','</div>');
	var resultTplMotivoIngreso = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplMotivoIngresoCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');
	var resultTplMotivoSalida = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplMotivoSalidaCuenta = new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{desc_cuenta}','<br>{codigo_ep}</FONT>','</div>');
	var resultTplTipoMaterial = new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b><i>{desc_nombrecompleto}</i></b>','<br><FONT COLOR="#B5A642">{id_empleado}</FONT>','</div>');

	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_transferencia
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_transferencia',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_transferencia'
	};

	vectorAtributos[1]= {
		validacion:{
			fieldLabel: 'EP Origen',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estructura Programática',
			name: 'id_ep_origen',     //indica la columna del store principal "ds" del que proviane el id
			minChars: 1,
			triggerAction: 'all',
			editable: false,
			grid_visible:true,
			grid_indice:21,
			grid_editable:false,
			width:300
		},
		lf:'Financiador Origen',
		lr:'Regional Origen',
		lp:'Programa Origen',
		lpr:'Proyecto Origen',
		la:'Actividad Origen',
		tipo: 'epField',
		save_as:'txt_id_ep_origen',
		id_grupo:0
	};

	vectorAtributos[2]= {
		validacion:{
			labelSeparator:'',
			allowBlank: false,
			name: 'id_ep_destino',     //indica la columna del store principal "ds" del que proviane el id
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		lf:'Financiador Destino',
		lr:'Regional Destino',
		lp:'Programa Destino',
		lpr:'Proyecto Destino',
		la:'Actividad Destino',
		f:'id_financiador_dest',
		r:'id_regional_dest',
		p:'id_programa_dest',
		pr:'id_proyecto_dest',
		a:'id_actividad_dest',
		nf:'nombre_financiador_dest',
		nr:'nombre_regional_dest',
		np:'nombre_programa_dest',
		npr:'nombre_proyecto_dest',
		na:'nombre_actividad_dest',
		cf:'codigo_financiador_dest',
		cr:'codigo_regional_dest',
		cp:'codigo_programa_dest',
		cpr:'codigo_proyecto_dest',
		ca:'codigo_actividad_dest',
		tipo: 'Field',
		save_as:'txt_id_ep_destino',

	};

	filterCols_almacen_origen=new Array();
	filterValues_almacen_origen=new Array();

	vectorAtributos[3]= {
		validacion:{
			name:'id_almacen',     //indica la columna del store principal ds del que proviane el id
			fieldLabel:'Almacen Físico Origen',
			allowBlank:true,
			emptyText:'Almacen Físico Origen...',
			desc:'desc_almacen_orig', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_origen,
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			filterCols:filterCols_almacen_origen,
			filterValues:filterValues_almacen_origen,
			//onSelect: function(record){componentes[18].setValue(record.data.nombre); componentes[3].collapse(); },
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacenOrigen,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'80%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_origen,
			grid_visible:true,
			grid_editable:false,
			width:300,
			width_grid:100, // ancho de columna en el gris
			grid_indice:1
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'ALMACE.nombre',
		defecto:'',
		save_as:'txt_id_almacen',
		id_grupo:0
	};

	filterCols_almacen_destino=new Array();
	filterValues_almacen_destino=new Array();

	vectorAtributos[4]= {
		validacion:{
			labelSeparator:'',
			allowBlank:false,
			name:'id_almacen_destino',     //indica la columna del store principal ds del que proviane el id
			desc:'desc_almacen_dest', //indica la columna del store principal ds del que proviane la descripcion
			valueField:'id_almacen',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'ALMACE.nombre#ALMACE.descripcion',
			filterCols:filterCols_almacen_destino,
			filterValues:filterValues_almacen_destino,
			typeAhead:true,
			forceSelection:false,
			tpl: resultTplAlmacenDestino,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:false,
			renderer:render_id_almacen_destino,
			inputType:'hidden',
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'ALMACE.nombre#ALMACE.descripcion',
		defecto:'',
		save_as:'txt_id_almacen_destino'
	};

	filterCols_almacen_logico_origen=new Array();
	filterValues_almacen_logico_origen=new Array();
	filterCols_almacen_logico_origen[0]='ALMACE.id_almacen';
	filterValues_almacen_logico_origen[0]='-';

	vectorAtributos[5] = {
		validacion: {
			name:'id_almacen_logico',
			fieldLabel:'Almacén Lógico Origen',
			allowBlank:false,
			emptyText:'Almacén Lógico Origen...',
			desc: 'desc_almacen_logico_orig', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_logico_origen,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG.codigo#ALMLOG.nombre#ALMLOG.descripcion',
			filterCols:filterCols_almacen_logico_origen,
			filterValues:filterValues_almacen_logico_origen,
			typeAhead:true,
			forceSelection:true,
			//onSelect: function(record){componentes[19].setValue(record.data.nombre); componentes[5].collapse(); },
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			tpl: resultTplAlmacenLogicoOrigen,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico_origen,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ALMLOG.nombre',
		defecto: '',
		save_as:'txt_id_almacen_logico',
		id_grupo:0
	};

	filterCols_almacen_logico_destino=new Array();
	filterValues_almacen_logico_destino=new Array();
	filterCols_almacen_logico_destino[0]='ALMACE.id_almacen';
	filterValues_almacen_logico_destino[0]='-';

	vectorAtributos[6]= {
		validacion: {
			labelSeparator:'',
			name:'id_almacen_logico_destino',
			allowBlank:false,
			desc: 'desc_almacen_logico_dest', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_almacen_logico_destino,
			valueField: 'id_almacen_logico',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ALMLOG1.codigo#ALMLOG1.nombre#ALMLOG1.descripcion',
			filterCols:filterCols_almacen_logico_destino,
			filterValues:filterValues_almacen_logico_destino,
			typeAhead:true,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			tpl: resultTplAlmacenLogicoDestino,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_almacen_logico_destino,
			inputType:'hidden',
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'ALMLOG1.codigo#ALMLOG1.nombre',
		defecto: '',
		save_as:'txt_id_almacen_logico_destino'
	};

	// txt id_tipo_material
	vectorAtributos[7]={
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
			tpl:resultTplTipoMaterial,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_material,
			grid_visible:true,
			grid_editable:false,
			width_grid:110 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPMAT.nombre',
		defecto: '',
		save_as:'txt_id_tipo_material',
		id_grupo:1
	};


	// txt prestamo
	vectorAtributos[8]= {
		validacion: {
			labelSeparator:'',
			name:'prestamo',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',

			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			width:100,
			forceSelection:false,
			inputType:'hidden',
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'TRASUB.prestamo',
		save_as:'txt_prestamo',
		id_grupo:1
	};

	// txt motivo
	vectorAtributos[9]= {
		validacion:{
			name:'motivo',
			fieldLabel:'Motivo',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			grid_indice:8,
			width_grid:120
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TRANSF.motivo',
		save_as:'txt_motivo',
		id_grupo:1
	};

	// txt descripcion
	vectorAtributos[10]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			grid_indice:5,
			width_grid:150
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TRANSF.descripcion',
		save_as:'txt_descripcion',
		id_grupo:1
	};

	// txt observaciones
	vectorAtributos[11]= {
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width:'100%',
			grid_indice:9,
			width_grid:150
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TRANSF.observaciones',
		save_as:'txt_observaciones',
		id_grupo:1
	};


	filterCols_motivo_ingreso=new Array();
	filterValues_motivo_ingreso=new Array();
	filterCols_motivo_ingreso[0]='MOTING.tipo'
	filterValues_motivo_ingreso[0]=tipo_ord


	// txt id_motivo_ingreso
	vectorAtributos[12]= {
		validacion: {
			fieldLabel:'Motivo ingreso',
			allowBlank:true,
			emptyText:'Motivo Ingreso ...',
			name: 'id_motivo_ingreso',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_motivo_ingreso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_motivo_ingreso,
			valueField: 'id_motivo_ingreso',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			tpl:resultTplMotivoIngreso,
			typeAhead:true,
			forceSelection:true,
			filterCols:filterCols_motivo_ingreso,
			filterValues:filterValues_motivo_ingreso,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_ingreso,
			grid_visible:false,
			grid_editable:false,
			grid_indice:22,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MOTING.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_ingreso'
	};

	filterCols_motivo_ingreso_cuenta=new Array();
	filterValues_motivo_ingreso_cuenta=new Array();
	filterCols_motivo_ingreso_cuenta[0]='MOTING.id_motivo_ingreso';
	filterValues_motivo_ingreso_cuenta[0]='-';

	// txt id_motivo_ingreso_cuenta
	vectorAtributos[13]={
		validacion: {
			name:'id_motivo_ingreso_cuenta',
			fieldLabel:'Cuenta Ingreso',
			allowBlank:false,
			emptyText:'Cuenta ...',
			name: 'id_motivo_ingreso_cuenta',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_motivo_ingreso_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_motivo_ingreso_cuenta,
			valueField: 'id_motivo_ingreso_cuenta',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MINGCU.descripcion',
			tpl:resultTplMotivoIngresoCuenta,
			filterCols:filterCols_motivo_ingreso_cuenta,
			filterValues:filterValues_motivo_ingreso_cuenta,
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_ingreso_cuenta,
			grid_visible:false,
			grid_editable:false,
			grid_indice:23,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MOINCU.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_ingreso_cuenta'
	};

	vectorAtributos[14]= {
		validacion: {
			labelSeparator:'',
			allowBlank:false,
			name: 'id_motivo_salida',     //indica la columna del store principal ds del que proviane el id
			desc: 'desc_motivo_salida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_motivo_salida,
			valueField: 'id_motivo_salida',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MOTSAL.descripcion',
			tpl:resultTplMotivoSalida,
			typeAhead:true,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_motivo_salida,
			inputType:'hidden',
			width_grid:170 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MOTSAL.descripcion',
		defecto: '',
		save_as:'txt_id_motivo_salida',
		id_grupo:0
	};


	filterCols_motivo_salida_cuenta=new Array();
	filterValues_motivo_salida_cuenta=new Array();
	filterCols_motivo_salida_cuenta[0]='MOTSAL.id_motivo_salida';
	filterValues_motivo_salida_cuenta[0]='-';

	// txt id_motivo_salida_cuenta
	vectorAtributos[15]={
		validacion:{
			labelSeparator:'',
			allowBlank:false,
			name:'id_motivo_salida_cuenta',     //indica la columna del store principal ds del que proviane el id//indica la columna del store principal ds del que proviane la descripcion
			store:ds_motivo_salida_cuenta,
			valueField: 'id_motivo_salida_cuenta',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'MSALCU.descripcion',
			tpl:resultTplMotivoSalidaCuenta,
			filterCols:filterCols_motivo_salida_cuenta,
			filterValues:filterValues_motivo_salida_cuenta,
			typeAhead:true,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			renderer:render_id_motivo_salida_cuenta,
			inputType:'hidden',
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'Field',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'MSALCU.descripcion',
		save_as:'txt_id_motivo_salida_cuenta',
		id_grupo:0
	};

	// txt id_empleado
	vectorAtributos[16]= {
		validacion: {
			name:'id_empleado',
			fieldLabel:'Responsable Transferencia',
			allowBlank:false,
			emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_nombrecompleto',
			queryParam: 'filterValue_0',
			filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:450,
			tpl:resultTplEmpleado,
			grow:true,
			width:300,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			grid_indice:11,
			width_grid:130 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.id_persona#PERSON1.nombre#PERSON1.apellido_paterno#PERSON1.apellido_materno',
		defecto: '',
		save_as:'txt_id_empleado',
		id_grupo:1
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
		titulo_maestro:'baja',
		grid_maestro:'grid-'+idContenedor
	};
	layout_baja=new DocsLayoutMaestro(idContenedor);
	layout_baja.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_baja,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
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
		btnEliminar:{url:direccion+'../../../control/transferencia/ActionEliminarTransfBorrador.php'},
		Save:{url:direccion+'../../../control/transferencia/ActionGuardarBajas.php'},
		ConfirmSave:{url:direccion+'../../../control/transferencia/ActionGuardarBajas.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'80%',
		width:'60%',
		minWidth:150,minHeight:200,	closable:true,titulo:'bajas',
		//columnas:['47%','47%'],
		columnas:['97%'],
		grupos:[
		{tituloGrupo:'Origen',id_grupo:0,columna:0},
		{tituloGrupo:'Datos generales',id_grupo:2,columna:0}
		]}};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//Para manejo de eventos
		function iniciarEventosFormularios()
		{
			combo_almacen_origen = ClaseMadre_getComponente('id_almacen');
			combo_almacen_destino = ClaseMadre_getComponente('id_almacen_destino');
			combo_almacen_logico_origen = ClaseMadre_getComponente('id_almacen_logico');
			combo_almacen_logico_destino = ClaseMadre_getComponente('id_almacen_logico_destino');
			cmb_ep_origen=ClaseMadre_getComponente('id_ep_origen');
			cmb_ep_destino=ClaseMadre_getComponente('id_ep_destino');
			combo_motivo_ingreso = ClaseMadre_getComponente('id_motivo_ingreso');
			combo_motivo_ingreso_cuenta = ClaseMadre_getComponente('id_motivo_ingreso_cuenta');
			combo_motivo_salida = ClaseMadre_getComponente('id_motivo_salida');
			combo_motivo_salida_cuenta = ClaseMadre_getComponente('id_motivo_salida_cuenta');
			combo_empleado = ClaseMadre_getComponente('id_empleado');
			var onMotivoIngresoSelect = function(e) {
				var id = combo_motivo_ingreso.getValue();
				if(id=="") id='-';
				combo_motivo_ingreso_cuenta.filterValues[0] = id;
				combo_motivo_ingreso_cuenta.modificado = true;
				combo_motivo_ingreso_cuenta.setValue('');
				combo_motivo_ingreso.modificado=true;
			};
			var onMotivoSalidaSelect = function(e) {
				var id = combo_motivo_salida.getValue();
				if(id=="") id='-';
				combo_motivo_salida_cuenta.filterValues[0] = id;
				combo_motivo_salida_cuenta.modificado = true;
				combo_motivo_salida_cuenta.setValue('');
				combo_motivo_salida.modificado=true;
			};
			var onEpOrigenSelect = function(e){
				var ep=cmb_ep_origen.getValue();
				data_ep_origen='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
				//Actualiza los datastore de los combos para filtrar por EP
				actualizar_ds_combosOrigen();
				//Limpia los valores de los combos
				combo_almacen_origen.setValue('');
				combo_almacen_logico_origen.setValue('');
				combo_motivo_salida.setValue('');
				combo_motivo_salida_cuenta.setValue('');
				combo_almacen_origen.modificado=true;
				combo_almacen_logico_origen.modificado=true;
				combo_motivo_salida.modificado=true;
				combo_motivo_salida_cuenta.modificado=true;
			};

			function actualizar_ds_combosOrigen()
			{
				//actualiza el data store de almacén y almacén lógico en función de la EP seleccionada
				var datos=Ext.urlDecode(decodeURIComponent(data_ep_origen));
				Ext.apply(combo_almacen_origen.store.baseParams,datos);
				Ext.apply(combo_almacen_logico_origen.store.baseParams,datos);
				Ext.apply(combo_motivo_ingreso.store.baseParams,datos);
				Ext.apply(combo_motivo_ingreso_cuenta.baseParams,datos);


			}

			var onEpDestinoSelect = function(e){
				var ep=cmb_ep_destino.getValue();
				data_ep_destino='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
				//Actualiza los datastore de los combos para filtrar por EP
				actualizar_ds_combosDestino();
				//Limpia los valores de los combos
				combo_almacen_destino.setValue('');
				combo_almacen_logico_destino.setValue('');
				combo_motivo_ingreso.setValue('');
				combo_motivo_ingreso_cuenta.setValue('');
				//Notifica que se modificó combo para que vuelva a sacar los datos de la BD
				combo_almacen_destino.modificado=true;
				combo_almacen_logico_destino.modificado=true;
				combo_motivo_ingreso.modificado=true;
				combo_motivo_ingreso_cuenta.modificado=true;
			};

			//alert("REVISAR.........   data_ep_origen" + data_ep_origen)
			function actualizar_ds_combosDestino()
			{
				//alert(data_ep_origen);
				var datos=Ext.urlDecode(decodeURIComponent(data_ep_origen));
				//Ext.apply(combo_almacen_origen.store.baseParams,datos);
				//Ext.apply(combo_almacen_logico_origen.store.baseParams,datos);
				Ext.apply(combo_motivo_ingreso.store.baseParams,datos);
				Ext.apply(combo_motivo_ingreso_cuenta.baseParams,datos);
			}


			var onAlmacenOrigenSelect = function(e) {
				var id = combo_almacen_origen.getValue();
				if(id=='') id='x';
				combo_almacen_logico_origen.filterValues[0] =  id;
				combo_almacen_logico_origen.modificado = true;
				combo_almacen_logico_origen.setValue('');
				combo_almacen_origen.modificado=true;

			};

			var onAlmacenDestinoSelect = function(e) {
				var id = combo_almacen_destino.getValue();
				if(id=='') id='x';
				combo_almacen_logico_destino.filterValues[0] =  id;
				combo_almacen_logico_destino.modificado = true;
				combo_almacen_logico_destino.setValue('');
				combo_almacen_destino.modificado=true;
			};

			combo_almacen_destino.on('select', onAlmacenDestinoSelect);
			combo_almacen_destino.on('change', onAlmacenDestinoSelect);
			cmb_ep_destino.on('change',onEpDestinoSelect);
			combo_motivo_ingreso.on('select',onMotivoIngresoSelect);
			combo_motivo_ingreso.on('change',onMotivoIngresoSelect);

			combo_almacen_origen.on('select', onAlmacenOrigenSelect);
			combo_almacen_origen.on('change', onAlmacenOrigenSelect);
			cmb_ep_origen.on('change',onEpOrigenSelect);
			combo_motivo_salida.on('select',onMotivoSalidaSelect);
			combo_motivo_salida.on('change',onMotivoSalidaSelect);

		}

		function Destroy(){
			delete vectorAtributos;
		}



		function btn_baja_detalle()
		{
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();

			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				var data='m_id_transferencia='+SelectionsRecord.data.id_transferencia;
				data=data+'&m_id_almacen_logico='+SelectionsRecord.data.id_almacen_logico;
				data=data+'&m_almacen_logico='+SelectionsRecord.data.desc_almacen_logico_orig;

				var ParamVentana={Ventana:{width:'70%',height:'60%'}}
				layout_baja.loadWindows(direccion+'../../../vista/baja_det/baja_gen_det.php?'+data,'Detalle Bajas',ParamVentana);
				layout_baja.getVentana().on('resize',function(){
					layout_baja.getLayout().layout();
				})
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}

		//función para terminar la orden de ingreso
		function btn_fin()
		{
			var sm=getSelectionModel();
			var NumSelect=sm.getCount();

			if(NumSelect!=0)
			{
				if(confirm("¿Está seguro finalizar el registro de bajas?"))
				{
					var SelectionsRecord=sm.getSelected();
					var data=SelectionsRecord.data.id_transferencia
					Ext.Ajax.request({
						url:direccion+"../../../control/transferencia/ActionFinalizarBajas.php?hidden_id_transferencia_0="+data,
						method:'GET',
						success:terminado,
						failure:ClaseMadre_conexionFailure,
						timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
					});
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}

		function terminado(resp)
		{
			Ext.MessageBox.hide();
			Ext.MessageBox.alert('Estado', '<br>Finalización satisfactoria.<br>');
			ClaseMadre_btnActualizar();
		}

		function InitPaginaBaja()
		{
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();
			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
			for(i=0;i<vectorAtributos.length;i++){
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			}
		}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){return layout_baja.getLayout();};
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
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de la Baja',btn_baja_detalle,true,'baja_detalle','');
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar la Solicitud de Baja',btn_fin,true,'Finalizar Baja','');
		this.iniciaFormulario();
		iniciarEventosFormularios();
		InitPaginaBaja();
		layout_baja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

