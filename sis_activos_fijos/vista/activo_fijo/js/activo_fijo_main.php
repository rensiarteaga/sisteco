<?php 
/**
 * Nombre:		  	    tipo_adq_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:47:21
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
    echo "var usuario='$usuario';"
	?> 
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:2,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_activo_fijo(idContenedor,direccion,paramConfig, usuario),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main); 


/*** Nombre:		  	pagina_activo_fijo.js
* Proposito: 			pagina objeto principal
* Autor:				Rensi Arteaga Copari
* Fecha creacion:		2010-06-23 11:47:21
* Fecha modificacion:   RCM a partir del 30/11/2010
*/
function pagina_activo_fijo(idContenedor,direccion,paramConfig,usuario){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var h_txt_fecha_reg,combo_metodo_depreciacion,combo_flag_depreciacion, v_item, data1='';
	var combo_tipo_activo,combo_sub_tipo_activo,h_txt_vida_util_original,h_txt_vida_util_restante;
	var h_txt_tasa_depreciacion,h_txt_id_moneda,h_txt_monto_compra_mon_orig,h_txt_monto_compra,h_txt_tipo_cambio,h_txt_monto_actual,h_txt_fecha_reg;
	var	combo_moneda_original,combo_con_garantia,h_txt_num_poliza_garantia,h_txt_fecha_fin_gar,h_txt_fecha_ini_dep,h_txt_fecha_compra,h_txt_orden_compra;
	var	h_txt_codigo,h_txt_correlativo_act,h_txt_responsable;
	var cod_tipo_activo='';
	var tipo_cod;
	//23/04/2015
	var programa_activo;
	var combo_tension,combo_tension_adt,combo_tension_gen;
	//---DATA STORE
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/activo_fijo/ActionListaActivoFijo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name: 'descripcion', type: 'string'},
		'id_activo_fijo',
		'codigo',
		'descripcion',
		'descripcion_larga',
		'vida_util_original',
		'vida_util_restante',
		'tasa_depreciacion',
		{name: 'fecha_ultima_deprec', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'depreciacion_acum_ant',
		'depreciacion_acum',
		'depreciacion_periodo',
		'flag_revaloriz',
		'valor_rescate',
		{name: 'fecha_compra', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		'monto_compra_mon_orig',
		'monto_compra',
		'monto_actual',
		'con_garantia',
		'num_poliza_garantia',
		{name: 'fecha_fin_gar', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'}, //dateFormat en este caso es el formato en que lee desde el archivo XML
		//'foto_activo',
		'num_factura',
		'tipo_cambio',
		'estado',
		'observaciones',
		'id_sub_tipo_activo',
		'id_institucion',
		'id_moneda',
		'id_moneda_original',
		'desc_tipo_activo',
		'desc_sub_tipo_activo',
		'id_tipo_activo',
		'simbolo_moneda',
		'simbolo_moneda_orig',
		'nombre_institucion',
		{name: 'fecha_ini_dep', type: 'date', dateFormat: 'Y-m-d'},//dateFormat en este caso es el formato en que lee desde el archivo XML
		'ubicacion_fisica',
		'orden_compra',
		'id_estado_funcional',
		'desc_estado_funcional',
		'responsable',
		'origen',
		'id_depto',
		'desc_depto',
		'id_cotizacion',
		'desc_cotizacion',
		'id_cotizacion_det',
		'desc_cotdet',
		'id_ep',
		'desc_ep',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'id_lugar',
		'desc_lugar',
		'id_ppto',
		'tipo_ppto',
		'id_gestion',
		'gestion',
		'id_solicitud_compra',
		'clonacion',
		'id_deposito',
		'nombre_deposito',
		'tipo_af_bien',
		'nombre_moneda',
		'nombre_moneda_orig',
		'proyecto',
		'custodio',
		'id_unidad_constructiva',
		'desc_unidad_constructiva',
		'id_ubicacion_fisica',
		'desc_ubicacion_fisica',
		'tension','tipo_bien_adt','tipo_bien_gen'
		]),
		remoteSort: true // metodo de ordenacion remoto
	});

	//STORE COMBOS
	/////DATA STORE COMBOS////////////
	//agregado en fecha 10 de enero 2o11 la variable ds_deposito
	var ds_deposito = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/deposito/ActionListarDeposito.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_deposito',
			totalRecords: 'TotalCount'

		}, ['id_deposito','nombre_deposito'])
	});
	
	var ds_tipo_activo = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_activo/ActionListaTipoActivo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_activo',
			totalRecords: 'TotalCount'
		}, ['id_tipo_activo','descripcion','codigo'])
	});
	
	var ds_sub_tipo_activo = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_sub_tipo_activo',
			totalRecords: 'TotalCount'
		}, ['id_sub_tipo_activo','descripcion','codigo','correlativo_act','vida_util','tasa_depreciacion'])//,
	});
	
	var ds_moneda_orig = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_moneda',totalRecords: 'TotalCount'	}, ['id_moneda','nombre'])//,
	});
	
	var ds_moneda_princ = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_moneda',totalRecords: 'TotalCount'}, ['id_moneda','nombre'])//,
	});

	var ds_estado_funcional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/estado_funcional/ActionListaEstadoFuncional.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_estado_funcional',totalRecords: 'TotalCount'}, ['id_estado_funcional','descripcion'])//,
	});
	
	var ds_lugar= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php?filtro_nivel=3'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_lugar',totalRecords: 'TotalCount'}, ['id_lugar','codigo','nombre','desc_lugar'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),	
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','nombre_corto','nombre_largo','codificacion'])
	});

	var ds_cotizacion= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/cotizacion/ActionListarCotizacionAF.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion',totalRecords: 'TotalCount'},['id_cotizacion','id_proveedor','desc_proveedor','desc_moneda','precio_total_adjudicado','numeracion_oc','gestion','id_moneda',{name: 'fecha_orden_compra', type: 'date', dateFormat: 'Y-m-d'},'num_factura','oc_completo'])
	});
	
	var ds_cotizacion_det= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/cotizacion_det/ActionListarCotizacionServDet.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cotizacion_det',totalRecords: 'TotalCount'},['id_cotizacion_det','id_item','nombre_item','codigo_item','abreviatura','precio','especificaciones_tecnicas','servicio','id_servicio'])
	});
		
	var ds_gestion= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
		
	var ds_ppto= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres','id_fina_regi_prog_proy_acti','desc_epe','id_unidad_organizacional','nombre_unidad','nombre_financiador','nombre_regional','nombre_proyecto','nombre_programa','nombre_actividad','gestion_pres'])
	});
		
	var ds_solicitud_compra= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/activo_fijo_tpm_frppa/ActionListarEPActivoFijo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra',totalRecords: 'TotalCount'},['id_solicitud_compra','solicitante','num_sol','cantidad_adj','id_fina_regi_prog_proy_acti','desc_ep','id_unidad_organizacional','nombre_unidad','tipo_presu','id_presupuesto','id_gestion','gestion', 'cantidad_adj' ])
	});
	
	var ds_unidad_constructiva = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/unidad_constructiva/ActionListarUnidadConstructiva.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_unidad_constructiva',totalRecords: 'TotalCount'}, ['id_unidad_constructiva','descripcion'])
	});
	
	var ds_ubicacion_fisica = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ubicacion/ActionListarUbicacion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_ubicacion',totalRecords:'TotalCount'},['id_ubicacion','id_lugar','codigo','ubicacion','estado'])
	});
	////////////////FUNCIONES RENDER ////////////
	function renderDeposito(value, p, record){return String.format('{0}', record.data['nombre_deposito']);}
	function renderTipoActivo(value, p, record){return String.format('{0}', record.data['desc_tipo_activo']);}
	function renderSubtipoActivo(value, p, record){return String.format('{0}', record.data['desc_sub_tipo_activo']);}
	function renderMonedaOrig(value, p, record){return String.format('{0}', record.data['nombre_moneda_orig']);}
	function renderEstadoFuncional(value, p, record){return String.format('{0}', record.data['desc_estado_funcional']);}
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	function render_id_cotizacion(value, p, record){return String.format('{0}', record.data['desc_cotizacion']);}
	function render_id_cotizacion_det(value, p, record){return String.format('{0}', record.data['desc_cotdet']);}
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	function render_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
	function render_id_ep(value, p, record){return String.format('{0}', record.data['desc_ep']);}
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_id_ppto(value, p, record){return String.format('{0}', record.data['desc_ep']);}
	
	function render_id_af(value, p, record){
		if(record.data.clonacion=='si'){
			return '<span style="color:red;font-size:8pt">' + String.format('{0}', record.data['descripcion']) + '</span>';
		}else{
			return String.format('{0}', record.data['descripcion']);
		}
	}
	
	function renderUnidadConstructiva(value, p, record){return String.format('{0}', record.data['desc_unidad_constructiva']);}
	function renderUbicacionFisica(value, p, record){return String.format('{0}', record.data['desc_ubicacion_fisica']);}
	
	var tpl_id_tipo=new Ext.Template('<div class="search-item">','{descripcion}<br>','<FONT COLOR="#B5A642">Codigo:{codigo}</FONT>','</div>');
	var tpl_id_subtipo=new Ext.Template('<div class="search-item">','{descripcion}<br>','<FONT COLOR="#B5A642">Codigo:{codigo}</FONT>','</div>');
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}','</div>');
	var tpl_id_cotizacion=new Ext.Template('<div class="search-item">','<b>{oc_completo}',' , Proveedor: {desc_proveedor}</b><br>','<FONT COLOR="#B5A642">Importe: {precio_total_adjudicado}',' {desc_moneda}</FONT>','</div>');
	var tpl_id_cotizacion_det=new Ext.Template('<div class="search-item">','<b>{nombre_item}</b><br>','<FONT COLOR="#B5A642">{codigo_item}</FONT>','<b>{precio}</b><br>','<b>{especificaciones_tecnicas}</b><br>','</div>');
	var tpl_id_lugar=new Ext.Template('<div class="search-item">','<b>{nombre}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');	
    
	var tpl_id_ppto=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>',
    		'<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_financiador}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_regional}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_programa}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_proyecto}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_actividad}</FONT>',
			'<br><b><i>{tipo_pres}</i></b>',
			'<br><b><i>{nombre_unidad}</i></b>',
       		'</div>');
	
	var tpl_id_solicitud_compra=new Ext.Template('<div class="search-item">','<b><i>{num_sol}</i></b>',
    		'<br><FONT  SIZE="1" COLOR="#B5A642">{solicitante}</FONT>',
       		'</div>');
 	
	var tpl_unidad_constructiva=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');
	var tpl_ubicacion_fisica=new Ext.Template('<div class="search-item">','{ubicacion}<br>','<FONT COLOR="#B5A642">Codigo:{codigo}</FONT>','</div>');

	function renderBienPropOtros(value)
	{
		var res;
		switch(value)
		{
			case 'bienes_produccion': res = 'BIENES EN PRODUCCION';return res;
			case 'bienes_produccion_aereo': res = 'BIENES EN PRODUCCION AEREO';return res; 
			case 'bienes_produccion_subt': res = 'BIENES EN PRODUCCION SUBTERRNEO';return res; 
			case 'propiedad_general': res = 'PROPIEDAD GENERAL';return res; 
			case 'propiedad_general_tra': res = 'PROPIEDAD GENERAL DE TRANSMISION';return res;  
		}

	}
	function renderBienPropGeneracion(value)
	{
			var res;
			switch(value)
			{
				case 'hidraulica':res ='HIDRA&Uacute;LICA';return res;
				case 'otra_generacion':res ='OTRA GENERACION (DIESEL OTROS)';return res;
				case 'propiedad_general':res ='PROPIEDAD GENERAL';return res;
				case 'turbina':res ='CON TURBINA';return res;
				case 'vapor':res ='A VAPOR';return res;
				case 'fotovoltaje':res='GENERACION FOTOVOLTAICA';return res;
			}
	}
	

	
	/////////////////////////
	// Definicion de datos //
	/////////////////////////
	//en la posicion 0 siempre tiene que estar la llave primaria
	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			fieldLabel:'ID Activo Fijo',
			name: 'id_activo_fijo',
			//inputType:'hidden',
			readOnly: true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			grid_indice:1,
			locked:true
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'AF.id_activo_fijo'
	};
	
	Atributos[1]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Unidad AF',
			allowBlank:false,
			emptyText:'Unidad Activos Fijos...',
			desc: 'desc_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:220,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false,
			grid_indice:19
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filtro_1:true,
		filterColValue:'depto.nombre_depto',
		id_grupo:0
	};
	
	Atributos[2]={
		validacion: {
			name: 'origen',
			fieldLabel: 'Origen',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields:['id', 'desc'],
				data:[['compro','COMPRO'],['otros', 'Otros']] // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65, // ancho de columna en el gris
			width:200,
			grid_indice:17
		},
		tipo:'ComboBox',
		filtro_0:false,
		filterColValue:'AF.origen',
		filtro_1:false,
		defecto:'otros',
		id_grupo:1
	};
	
	/////////// txt codigo//////
	Atributos[3]={
		validacion: {
			name: 'codigo',
			fieldLabel: 'Codigo',
			allowBlank: false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			disabled: false,
			grid_indice:1,
			width:200,
			locked:true
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'AF.codigo',
		id_grupo: 0
	};
	
	/////////// hidden_id_tipo_activo//////
	Atributos[4] = {
		validacion:{
			fieldLabel: 'Tipo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Tipo de Activo...',
			name: 'id_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_tipo_activo',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_tipo_activo,
			valueField: 'id_tipo_activo',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIP.codigo#TIP.descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderTipoActivo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_tipo,
			grid_indice:20
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIP.descripcion#TIP.codigo',
		id_grupo:0
	};
	
	filterCols_sub_tipo_activo = new Array();
	filterValues_sub_tipo_activo= new Array();
	filterCols_sub_tipo_activo[0] = 'tip.id_tipo_activo';
	filterValues_sub_tipo_activo[0] = '%';
	/////////// txt sub_tipo_activo//////
	Atributos[5] = {
		validacion:{
			fieldLabel: 'Subtipo',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Subtipo...',
			name: 'id_sub_tipo_activo',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_sub_tipo_activo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_sub_tipo_activo,
			valueField: 'id_sub_tipo_activo',//'id_sub_tipo_activo',
			displayField: 'descripcion',//'codigo',
			queryParam: 'filterValue_0',
			filterCol:'sub.codigo#sub.descripcion',
			filterCols:filterCols_sub_tipo_activo,
			filterValues:filterValues_sub_tipo_activo,
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minismo requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderSubtipoActivo,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl:tpl_id_subtipo,
			grid_indice:21
		},
		tipo: 'ComboBox',
		id_grupo:0
	};

	Atributos[6] = {
		validacion:{
			fieldLabel: 'Orden Compra',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Proveedor...',
			name: 'id_cotizacion',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_cotizacion',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_cotizacion,
			valueField: 'id_cotizacion',
			displayField: 'desc_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'desc_proveedor',
			//typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_cotizacion,
			onSelect:function(record){
				getComponente('id_cotizacion').setValue(record.data.id_cotizacion);
				getComponente('id_cotizacion').setRawValue(record.data.desc_proveedor);
				getComponente('num_factura').setValue(record.data.num_factura);
				getComponente('fecha_compra').setValue(record.data.fecha_orden_compra.dateFormat('m-d-Y'));
				getComponente('num_factura').setValue(record.data.num_factura);
				getComponente('id_moneda_original').setValue(record.data.id_moneda);
				getComponente('orden_compra').setValue(record.data.oc_completo);
				
				getComponente('id_cotizacion_det').setValue('');
				getComponente('id_cotizacion_det').enable();
				getComponente('id_cotizacion_det').modificado=true;
				ds_cotizacion_det.baseParams={
					m_id_cotizacion:record.data.id_cotizacion,
					adjudicado:1
				};
				getComponente('id_cotizacion_det').modificado=true;
				getComponente('desc_ep').setValue('');
				getComponente('desc_unidad_organizacional').setValue('');
				getComponente('id_cotizacion').collapse();
			},
			onChange:function(record){
				getComponente('id_cotizacion').setValue(record.data.id_cotizacion);
				getComponente('id_cotizacion').setRawValue(record.data.desc_proveedor);
				getComponente('num_factura').setValue(record.data.num_factura);
				getComponente('fecha_compra').setValue(record.data.fecha_orden_compra.dateFormat('d/m/Y'));
				getComponente('num_factura').setValue(record.data.num_factura);
				getComponente('id_moneda_original').setValue(record.data.id_moneda);
				getComponente('orden_compra').setValue(record.data.oc_completo);
				
				getComponente('id_cotizacion_det').setValue('');
				ds_cotizacion_det.baseParams={
					m_id_cotizacion:record.data.id_cotizacion,
					adjudicado:1
				};
				getComponente('id_cotizacion_det').enable();
				getComponente('id_cotizacion_det').modificado=true;
				getComponente('monto_compra').setValue('');
				getComponente('monto_actual').setValue('');
				getComponente('monto_compra_mon_orig').setValue('');
				
				getComponente('desc_ep').setValue('');
				getComponente('desc_unidad_organizacional').setValue('');
				getComponente('id_cotizacion').collapse();
				
			},
			tpl:tpl_id_cotizacion,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,m	m	
			width_grid:200, // ancho de columna en el gris
			width:200,
			//grid_indice:3
			grid_indice:3
		},
		tipo: 'ComboBox',
		filtro_0:false,
		id_grupo:1
	};
	
	Atributos[7] = {
		validacion:{
			fieldLabel: 'Item',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Item...',
			name: 'id_cotizacion_det',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_cotdet',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store: ds_cotizacion_det,
			valueField: 'id_cotizacion_det',
			displayField: 'nombre_item',
			queryParam: 'filterValue_0',
			filterCol:'nombre_item',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			onSelect:function(record){
				getComponente('id_solicitud_compra').setValue('');
				getComponente('id_solicitud_compra').modificado=true;
				getComponente('monto_compra_mon_orig').setValue(record.data.precio);
				getComponente('monto_compra_mon_orig').modificado=true;
				if(getComponente('tipo_cambio')!=''){
				  getComponente('monto_compra').setValue(record.data.precio * getComponente('tipo_cambio').getValue());
				  getComponente('monto_actual').setValue(record.data.precio * getComponente('tipo_cambio').getValue());
				}
				getComponente('id_cotizacion_det').setValue(record.data.id_cotizacion_det);

				if(record.data.id_item!=undefined && record.data.id_item!=null){
								getComponente('id_cotizacion_det').setRawValue(record.data.nombre_item);
								getComponente('descripcion').setValue(record.data.nombre_item);
				}else{
					getComponente('id_cotizacion_det').setRawValue(record.data.servicio);
					getComponente('descripcion').setValue(record.data.servicio);
				}
				getComponente('id_cotizacion_det').collapse();
				
				v_item=record.data.id_item_aprobado;
				Ext.Ajax.request({
					url:direccion+"../../../../sis_activos_fijos/control/activo_fijo_tpm_frppa/ActionListarEPActivoFijo.php?filtro_af=1&id_item="+record.data.id_item+"&id_cotizacion_det="+record.data.id_cotizacion_det+"&id_servicio="+record.data.id_servicio,
					method:'GET',
					success:  cargar_epuo,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
				
				Ext.MessageBox.show({
							title: 'Espere por favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Cargando EP, UO...</div>",
							width:150,
							height:200,
							closable:false
					});
			},
			onChange:function(record){
				getComponente('id_solicitud_compra').setValue('');
				getComponente('id_solicitud_compra').modificado=true;
				getComponente('monto_compra_mon_orig').setValue(record.data.precio);
				getComponente('monto_compra_mon_orig').modificado=true;
				if(getComponente('tipo_cambio')!=''){
				  getComponente('monto_compra').setValue(record.data.precio * getComponente('tipo_cambio').getValue());
				  getComponente('monto_actual').setValue(record.data.precio * getComponente('tipo_cambio').getValue());
				  
				 
				}
				getComponente('id_cotizacion_det').setValue(record.data.id_cotizacion_det);
				getComponente('id_cotizacion_det').setRawValue(record.data.nombre_item);
				getComponente('descripcion').setValue(record.data.nombre_item);
				getComponente('id_cotizacion_det').collapse();
				v_item=record.data.id_item_aprobado;
					Ext.Ajax.request({
					url:direccion+"../../../../sis_activos_fijos/control/activo_fijo_tpm_frppa/ActionListarEPActivoFijo.php?filtro_af=1&id_item="+record.data.id_item+"&id_cotizacion_det="+record.data.id_cotizacion_det,
					method:'GET',
					success:  cargar_epuo,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
				Ext.MessageBox.show({
							title: 'Espere por favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Cargando EP, UO...</div>",
							width:150,
							height:200,
							closable:false
					});
			},
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_cotizacion_det,
			tpl: tpl_id_cotizacion_det,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			//grid_indice:3
			width:200,
			grid_indice:22
		},
		tipo: 'ComboBox',
		filtro_0:false,
		id_grupo:1
	};
	
	/////////// txt descripcion//////
	Atributos[8] = {
		validacion:{
			name: 'descripcion',
			fieldLabel: 'Denominacion',
			allowBlank: false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			renderer:render_id_af,
			width: '100%',
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200, // ancho de columna en el grid
			grid_indice:2
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'AF.descripcion',
		filtro_1:true,
		id_grupo: 1
	}
	
	Atributos[9] = {
		validacion:{
			fieldLabel: 'Solicitud Compra',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Solicitud Compra...',
			name: 'id_solicitud_compra',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'num_sol',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_solicitud_compra,
			valueField: 'id_solicitud_compra',
			displayField: 'num_sol',
			queryParam: 'filterValue_0',
			filterCol:'s.num_solicitud#s.periodo#s.gestion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			//renderer: renderTipoActivo,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_solicitud_compra,
			
		},
		tipo: 'ComboBox',
		filtro_0:false,
		id_grupo:1
	};
	
	////////// txt descripcion larga//////
	Atributos[10] = {
		validacion:{
			name: 'descripcion_larga',
			fieldLabel: 'Descripcion',
			allowBlank: false,
			maxLength:5000,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			width:'100%',
			grow:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:350, // ancho de columna en el grid
			grid_indice:4
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'AF.descripcion_larga',
		filtro_1:true,
		id_grupo: 1
	}
	
	Atributos[11]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,
			emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'gestio.gestion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:220,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:200,				
			disabled:false,
			grid_indice:14
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filtro_1:false,
		filterColValue:'ges.gestion',
		id_grupo:1
	};
	
	Atributos[12] = {
		validacion:{
			fieldLabel: 'Presupuesto',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Presupuesto...',
			name: 'id_ppto',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'tipo_ppto',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_ppto,
			valueField: 'id_presupuesto',
			displayField: 'desc_epe',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.tipo_pres#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.nombre_unidad',
			forceSelection: true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 20,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			//renderer: render_id_ppto,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_ppto,
			grid_indice:15
		},
		tipo: 'ComboBox',
		filtro_0:false,
		filterColValue:'ppto.tipo_pres',
		id_grupo:1
	};
	
	Atributos[13] = {
		validacion:{
			name: 'desc_ep',
			desc:'desc_ep',
			renderer:render_id_ep,			
			fieldLabel: 'EP',
			allowBlank: true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			disabled:false,
			width: '100%',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el grid
			grid_indice:12
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'ppto.nombre_financiador#ppto.nombre_regional#ppto.nombre_programa#ppto.nombre_proyecto#ppto.nombre_actividad',
		filtro_1:true,
		defecto:' ',
		id_grupo: 1
	};
	
	Atributos[14] = {
		validacion:{
			name: 'desc_unidad_organizacional',
			desc:'desc_unidad_organizacional',
			fieldLabel: 'Unidad Organizacional',
			allowBlank: true,
			renderer:render_id_unidad_organizacional,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: '100%',
			disabled:true,
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el grid
			grid_indice:13
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'ppto.nombre_unidad',
		filtro_1:true,
		defecto:' ',
		id_grupo: 1
	};
	
	Atributos[15] = {
		validacion:{
			fieldLabel: 'Lugar',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Lugar...',
			name: 'id_lugar',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_lugar',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			//typeAhead: true,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: render_id_lugar,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_id_lugar,
			grid_indice:24
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'lug.nombre',
		id_grupo:8
	};

	Atributos[16] = {
		validacion:{
			name: 'tipo_ppto',
			fieldLabel: 'Presupuesto',
			allowBlank: true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '85%',
			width:200,
			disabled:true,
			grid_visible:true, // se muestra en el grid
			width_grid:200, // ancho de columna en el grid
			grid_indice:25
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'UO.nombre_unidad',
		filtro_1:true,
		defecto:'gasto',
		id_grupo: 1
	};
	
	Atributos[17]={
		validacion:{
			name: 'fecha_reg',
			fieldLabel: 'Fecha registro',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Doa no volido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer:formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled: false,
			width:200,
			grid_indice:26
		},
		tipo: 'DateField',
		form:true,
		filtro_0:true,
		filterColValue:'AF.fecha_reg',
		filtro_1:true,
		dateFormat:'m-d-Y', //formato de fecha que envoa para guardar
		defecto:"", // valor por default para este campo
		id_grupo:0
	}
	
	Atributos[18]= {
		validacion:{
			fieldLabel: 'Estado Funcional',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Estado Funcional...',
			name: 'id_estado_funcional',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_estado_funcional',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_estado_funcional,
			valueField: 'id_estado_funcional',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 200,
			width:200,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderEstadoFuncional,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			//grid_indice:3
			grid_indice:27
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EF.descripcion',
		id_grupo:1
	}
	
	////////// txt estado//////
	Atributos[19]={
		validacion: {
			name: 'estado',
			fieldLabel: 'Estado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields:['id', 'desc'],
				data:[['registrado','Registrado'],['alta','Alta'],['codificado','Codificado']] // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65, // ancho de columna en el gris
			width:200,
			//disabled:true,
			grid_indice:16
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AF.estado',
		filtro_1:true,
		defecto:'registrado',
		id_grupo:1
	}
	
	////////// txt flag_revaloriz//////
	Atributos[20]={
		validacion: {
			name: 'flag_revaloriz',
			fieldLabel: 'Revalorizado',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['si', 'no'],
				data : [['si', 'Si'],['no', 'No']] // from states.js
			}),
			valueField:'si',
			displayField:'no',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:70, // ancho de columna en el grid
			width: '85%',
			//disabled: true,
			width:200,
			grid_indice:28
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AF.flag_revaloriz',
		filtro_1:true,
		defecto: 'no',
		id_grupo:1
	}
	
	////////// txt id_moneda//////
	Atributos[21]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false
	}
	
	////////// txt orden_compra//////
	Atributos[22] = {
		validacion:{
			name: 'orden_compra',
			fieldLabel: 'No Orden Compra',
			allowBlank: true,
			selectOnFocus:true,
			vtype:"texto",
			maxLength:20,
			minLength:0,
			//width: '75%',
			width:200,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			//grid_indice:21
			grid_indice:30
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'AF.orden_compra',
		filtro_1:true,
		id_grupo: 1
	};
	
	/////////// hidden_id_moneda_original//////
	Atributos[23]={
		validacion:{
			fieldLabel: 'Moneda original',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Moneda...',
			name: 'id_moneda_original',     //indica la columna del store principal "ds" del que proviene el id
			desc: 'nombre_moneda_orig', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_moneda_orig,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'nombre',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres monimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			editable : true,
			renderer: renderMonedaOrig,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			width_grid:120, // ancho de columna en el grisde
			width:200,
			grid_indice:31
		},
		tipo: 'ComboBox',
		defecto:'1',
		id_grupo: 1
	}
	
	////////// txt monto_compra_mon_orig//////
	Atributos[24]={
		validacion:{
			name: 'monto_compra_mon_orig',
			//fieldLabel: 'Valor compra (moneda original)',
			fieldLabel: 'Valor de Compra',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:115, // ancho de columna en el grid
			//grid_indice:15
			grid_indice:5
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.monto_compra_mon_orig',
		filtro_1:true,
		id_grupo: 1
	}
	
	////////// txt fecha_compra//////
	Atributos[25]={
		validacion:{
			name: 'fecha_compra',
			fieldLabel: 'Fecha de Compra',
			allowBlank: false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'DÃ­a no vÃ¡lido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			width:200,
			grid_indice:6
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'AF.fecha_compra',
		filtro_1:true,
		dateFormat:'m-d-Y', //formato de fecha que envoa para guardar
		defecto:"", // valor por default para este campo
		id_grupo:1
	}
	
	////////// txt Num_factura//////
	Atributos[26]= {
		validacion:{
			name: 'num_factura',
			fieldLabel: 'Factura',
			allowBlank: true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			//grid_indice:21
			grid_indice:8
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'AF.num_factura',
		filtro_1:true,
		id_grupo: 1
	}
	
	////////// txt tipo_cambio//////
	Atributos[27]={
		validacion:{
			name: 'tipo_cambio',
			fieldLabel: 'Tipo Cambio',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled: true,
			//grid_indice:19
			grid_indice:32
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'AF.tipo_cambio',
		filtro_1:false,
		id_grupo: 2
	}
	
	////////// txt monto_compra//////
	Atributos[28]={
		validacion:{
			name: 'monto_compra',
			fieldLabel: 'Valor compra (moneda principal)',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:165, // ancho de columna en el grid
			disabled: true,
			//grid_indice:18
			grid_indice:33
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.monto_compra',
		filtro_1:true,
		id_grupo: 2
	}
	
	////////// txt vida_util_original//////
	Atributos[29]= {
		validacion:{
			name: 'vida_util_original',
			fieldLabel: 'Vida Util Original(meses)',
			allowBlank: false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:80, // ancho de columna en el grid
			//grid_indice:14
			grid_indice:7
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.vida_util_original',
		filtro_1:true,
		id_grupo: 3
	}
	
	////////// txt tasa_depreciacion//////
	Atributos[30]={
		validacion:{
			name: 'tasa_depreciacion',
			fieldLabel: 'Tasa Deprec.',
			allowBlank: false,
			maxLength:800,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			maxValue: 1,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled: true,
			//grid_indice:12
			grid_indice:34
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'AF.tasa_depreciacion',
		filtro_1:false,
		id_grupo: 3
	}
	
	////////// txt valor_rescate//////
	Atributos[31]= {
		validacion:{
			name: 'valor_rescate',
			fieldLabel: 'Valor rescate (moneda principal)',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:165, // ancho de columna en el grid
			//grid_indice:16
			grid_indice:35
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'AF.valor_rescate',
		filtro_1:false,
		defecto: 1,
		id_grupo: 3
	}
	
	/////////////////////////////////////
	Atributos[32]= {
		validacion:{
			name: 'fecha_ini_dep',
			fieldLabel: 'Inicio Depreciacion',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Doa no volido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:130,// ancho de columna en el gris
			disabled:false,
			width:200,
			grid_indice:36
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'AF.fecha_ini_dep',
		filtro_1:true,
		dateFormat:'m-d-Y', //formato de fecha que envoa para guardar
		defecto:"", // valor por default para este campo
		id_grupo:3
	}
	
	////////// txt vida_util_restante//////
	Atributos[33]={
		validacion:{
			name: 'vida_util_restante',
			fieldLabel: 'Vida Util Restante(meses)',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: -1,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			//grid_indice:8
			grid_indice:37
			//disabled: true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.vida_util_restante',
		filtro_1:true,
		id_grupo: 4
	}
	
	////////// txt fecha_ultima_deprec//////
	Atributos[34]={
		validacion:{
			name: 'fecha_ultima_deprec',
			fieldLabel: 'Fecha Ult. Deprec.',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'D�a no volido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled: true,
			width:200,
			grid_indice:38
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'AF.fecha_ultima_deprec',
		filtro_1:true,
		dateFormat:'m-d-Y', //formato de fecha que envoa para guardar
		defecto:"", // valor por default para este campo
		id_grupo:4
	}
	
	////////// txt con_garantia//////
	Atributos[35]= {
		validacion: {
			name: 'con_garantia',
			fieldLabel: 'Tiene Garantia',
			typeAhead: false,
			loadMask: true,
			allowBlank: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data : [['si', 'Si'],['no', 'No']]// from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:75, // ancho de columna en el grid
			width:200,
			grid_indice:39
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AF.con_garantia',
		filtro_1:true,
		defecto: 'no',
		id_grupo:5
	}
	
	////////// txt num_poliza_garantia//////
	Atributos[36]={
		validacion:{
			name: 'num_poliza_garantia',
			fieldLabel: 'Poliza de garantia',
			allowBlank: true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled:true,
			//grid_indice:24
			grid_indice:40
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'AF.num_poliza_garantia',
		filtro_1:false,
		id_grupo: 5
	}
	
	////////// txt fecha_fin_gar//////
	Atributos[37]= {
		validacion:{
			name: 'fecha_fin_gar',
			fieldLabel: 'Fin Garantia',
			allowBlank: true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			//disabledDays: [0, 7],
			disabledDaysText: 'Doa no volido',
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			renderer: formatDate,
			width_grid:120, // ancho de columna en el gris
			disabled:true,
			width:200,
			grid_indice:41
		},
		tipo: 'DateField',
		filtro_0:true,
		filterColValue:'AF.fecha_fin_gar',
		filtro_1:true,
		dateFormat:'m-d-Y', //formato de fecha que envoa para guardar
		defecto:"", // valor por default para este campo
		id_grupo:5
	}
	
	////////// txt depreciacion_acum_ant//////

	Atributos[38]={
		validacion:{
			name: 'depreciacion_acum_ant',
			fieldLabel: 'Depreciacion Acum. Ant.',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled: true,
			//grid_indice:11
			grid_indice:42
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'AF.depreciacion_acum_ant',
		filtro_1:false,
		defecto:'0',
		id_grupo:6
	}
	
	////////// txt depreciacion_acum//////esto habilitar
	Atributos[39]={
		validacion:{
			name: 'depreciacion_acum',
			fieldLabel: 'Depreciacion Acumulada',
			allowBlank: true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			//disabled: true,
			//grid_indice:9
			grid_indice:43
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.depreciacion_acum',
		filtro_1:true,
		defecto:'0',
		id_grupo:6
	}
	
	////////// txt depreciacion_periodo//////
	Atributos[40]={
		validacion:{
			name: 'depreciacion_periodo',
			fieldLabel: 'Deprec. Periodo',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled: true,
			//grid_indice:10
			grid_indice:44
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'AF.depreciacion_periodo',
		filtro_1:false,
		defecto:'0',
		id_grupo:6
	}
	
	////////// txt monto_actual//////
	Atributos[41]={
		validacion:{
			name: 'monto_actual',
			fieldLabel: 'Valor actual',
			allowBlank: false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: true,
			allowNegative: false,
			minValue: 0,
			decimalPrecision : 2,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: '75%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			disabled: true,
			//grid_indice:7
			grid_indice:45
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'AF.monto_actual',
		filtro_1:true,
		//id_grupo: 4
		id_grupo:6
	}
	
	////////// txt observaciones//////
	Atributos[42]={
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			allowBlank: true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			width: '100%',
			grow: true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200, // ancho de columna en el grid
			//grid_indice:29
			grid_indice:11
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'AF.observaciones',
		filtro_1:true,
		id_grupo:7
	}
		
	////////// txt responsable//////
	Atributos[43]={
		validacion:{
			name: 'responsable',
			fieldLabel: 'Responsable',
			allowBlank: false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: 100,
			//width: '85%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el grid
			disabled: true,
			//grid_indice:29
			grid_indice:9
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'responsable',
		form:false,
		id_grupo:7
	}
	
	////////// txt ubicacion fisica//////
	Atributos[44]={
		validacion:{
			name: 'ubicacion_fisica',
			fieldLabel: 'Ubicacion Descriptiva',
			allowBlank: true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			width: '100%',
			grow: true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:250, // ancho de columna en el grid
			grid_indice:53 //10
		},
		tipo: 'TextArea',
		filtro_0:true,
		filterColValue:'AF.ubicacion_fisica',
		filtro_1:true,
		id_grupo: 8
	}
	
	Atributos[45] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'clonacion',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid
		},
		tipo: 'Field',
		filtro_0:false
	}			
	
	/////////////////////////////////// hasta aqui reorganizadas las columnas por mflores: 18/05/2012 //////////////////////////////////////
	
	Atributos[46]={
		validacion:{
			name: 'num_clones',
			fieldLabel: 'Cant. Clones',
			allowBlank: true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			allowDecimals: false,
			allowNegative: false,
			minValue: 0,
			vtype:"texto",
			width:200,
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			grid_indice:47
		},
		tipo: 'NumberField',
		filtro_0:false,
		defecto:0,
		id_grupo:9
	}	
	
	/////////// txt codigo//////
	Atributos[47]={
		validacion: {
			name: 'codigo_ant',
			fieldLabel: 'Codigo Ant.',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:48,
			width:200
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'AF.codigo_ant',
		filtro_1:true,
		form:false,
		id_grupo: 0
	}
	Atributos[48]={
			validacion:{
				name:'id_deposito',
				fieldLabel:'Nombre Deposito',
				allowBlank:false,
				emptyText:'Nombre de Deposito...',
				desc: 'nombre_deposito', //indica la columna del store principal ds del que proviane el nombre_deposito
				store:ds_deposito,
				valueField: 'id_deposito',
				displayField: 'nombre_deposito',
				queryParam: 'filterValue_0',
				filterCol:'DEPOSI.id_deposito#DEPOSI.nombre_deposito',
				typeAhead:false,
				//tpl:tpl_id_depto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:220,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres monimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:renderDeposito,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:250,
				disabled:false,
				grid_indice:49
				
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filtro_1:false,
			filterColValue:'DEPOSI.nombre_deposito',
			save_as:'id_deposito',
			id_grupo:0
		}
	
		Atributos[49]={
		validacion: {
			name: 'tipo_af_bien',
			fieldLabel: 'Tipo',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields:['id', 'desc'],
				data:[['activo','activo'],['bien_resp', 'bien bajo resopnsabilidad']] // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65, // ancho de columna en el gris
			width:200,
			grid_indice:50
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AF.tipo_af_bien',
		filtro_1:true,
		defecto:'activo',
		id_grupo:0
	}
	
	Atributos[50]={
		validacion: {
			name: 'proyecto',
			fieldLabel: 'Proyecto',
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields:['id', 'desc'],
				data:[['si','si'],['no', 'no']] // from states.js
			}),
			valueField:'id',
			displayField:'desc',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:65, // ancho de columna en el gris
			width:200,
			grid_indice:18
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'AF.proyecto',
		filtro_1:true,
		defecto:'no',
		id_grupo:0
	};		
	
	Atributos[51]={
		validacion:{
			name: 'custodio',
			fieldLabel: 'Custodio',
			allowBlank: false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			//vtype:"alphaLatino",
			vtype:"texto",
			//width: 100,
			//width: '85%',
			width:200,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:200, // ancho de columna en el grid
			disabled: true,
			grid_indice:51
		},
		tipo: 'TextField',
		filtro_0:false,
		filtro_1:true,
		filterColValue:'person.apellido_paterno',
		form:false,
		id_grupo:7
	}
	
	Atributos[52] = {
		validacion:{
			fieldLabel: 'Ubicacion Fisica',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Ubicacion Fisica ...',
			name: 'id_ubicacion_fisica',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_ubicacion_fisica',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_ubicacion_fisica,
			valueField: 'id_ubicacion',
			displayField: 'ubicacion',
			queryParam: 'filterValue_0',
			filterCol:'ubi.ubicacion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderUbicacionFisica,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_ubicacion_fisica,
			grid_indice:52
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UF.ubicacion',
		save_as:'id_ubicacion',
		id_grupo:8
	};
	
	Atributos[53] = {
		validacion:{
			fieldLabel: 'Concepto Agrupador',
			allowBlank: true,
			vtype:"texto",
			emptyText:'Concepto Agrupador...',
			name: 'id_unidad_constructiva',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'desc_unidad_constructiva',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_unidad_constructiva,
			valueField: 'id_unidad_constructiva',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'UC.descripcion',
			typeAhead: false,
			forceSelection : true,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 1, ///caracteres minimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			renderer: renderUnidadConstructiva,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:200, // ancho de columna en el gris
			width:200,
			tpl: tpl_unidad_constructiva,
			grid_indice:54
		},
		tipo: 'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UC.descripcion',
		save_as:'id_unidad_constructiva',
		id_grupo:9
	};

	//23/04/2015
	Atributos[54]={
			validacion: {
				name: 'programa',
				fieldLabel: 'Programa',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Programa...',
				store:new Ext.data.SimpleStore({fields:['id_programa','cod_programa'],data:[['GEN','Generacion'],['TRA', 'Transmisión'],['DIST', 'Distribución'],['ADM', 'Bienes de uso Administración Central']]}),
				valueField:'id_programa',
				displayField:'cod_programa',
				mode:'local',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				width:250,
				grid_visible:false,			
				disabled:true
			},
			form:true,
			id_grupo:11,
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'det.programa',
			defecto:' ',
			save_as:'txt_programa'
		};
	Atributos[55] = {
			validacion: {
				name:'tension',
				fieldLabel: 'Tensi&oacute;n',
				allowBlank:true,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				mode:'local',
				emptyText:'tension...',
				store:new Ext.data.SimpleStore({fields:['cod_tension','desc_tension'],
												data:[
												      ['alta','ALTA'],
												      ['media', 'MEDIA'],
												      ['baja', 'BAJA']
												       ]
												 }),
				valueField:'cod_tension',
				displayField:'desc_tension',
				lazyRender:true,
				forceSelection:false,
				width_grid:100,
				triggerAction:'all',
				width:250,
				grid_visible:false,			
				disabled:false
				
			},
			form:true,
			id_grupo:11,
			tipo:'ComboBox',
			filtro_0:true,
			save_as:'txt_tension',
			defecto:''
	
		};
		Atributos[56] = {
			validacion: {
				name:'tipo_bien_adt',//ADMINISTRACION,TRANSMISION Y DISTRIBUCION
				fieldLabel: 'Bien/Propiedad Otros',
				allowBlank:true,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Tipo Bien Propiedad...',
				store:new Ext.data.SimpleStore({	fields:['cod_tipo_bien','desc_tipo_bien'],
													data:[
													      ['bienes_produccion','BIENES EN PRODUCCION'],
													      ['bienes_produccion_aereo', 'BIENES EN PRODUCCION AEREO'],
													      ['bienes_produccion_subt', 'BIENES EN PRODUCCION SUBTERRANEO'],
													      ['propiedad_general', 'PROPIEDAD GENERAL'],
													      ['propiedad_general_tra', 'PROPIEDAD GENERAL DE TRANSIMISION'],
													       ]
												}),
				valueField:'cod_tipo_bien',
				displayField:'desc_tipo_bien',
				mode:'local',
				renderer:renderBienPropOtros,
				lazyRender:true,
				forceSelection:false,
				width_grid:250,
				triggerAction:'all',
				width:350,
				grid_visible:false,			
				disabled:false
			},
			form:true,
			tipo:'ComboBox',
			filtro_0:false,
			save_as:'txt_tipo_bien_adt',
			defecto:' ',
			id_grupo:11
	
		};
		Atributos[57] = {
			validacion: {
				name:'tipo_bien_gen',//generacion
				fieldLabel: 'Tipo Bien/Propiedad Generaci&oacute;n',
				allowBlank:true,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'Tipo Bien Propiedad...',
				store:new Ext.data.SimpleStore({	fields:['cod_tipo_bien','desc_tipo_bien'],
													data:[
													      ['hidraulica','HIDRA&Uacute;LICA'],
													      ['otra_generacion', 'OTRA GENERACION (DIESEL OTROS)'],
													      ['propiedad_general', 'PROPIEDAD GENERAL'],
													      ['turbina', 'CON TURBINA'],
													      ['vapor', 'A VAPOR'],
													      ['fotovoltaje','GENERACION FOTOVOLTAICA']
													       ]}),
				valueField:'cod_tipo_bien',
				displayField:'desc_tipo_bien',
				mode:'local',
				renderer:renderBienPropGeneracion,
				lazyRender:true,
				forceSelection:false,
				width_grid:250,
				triggerAction:'all',
				width:350,
				grid_visible:false,			
				disabled:false
			},
			form:true,
			tipo:'ComboBox',
			filtro_0:false,
			save_as:'txt_tipo_bien_gen',
			defecto:' ',
			id_grupo:11
		};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
 
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Alta de Activos Fijos',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/activo_fijo_proceso/activo_fijo_proceso.php'};
	var layout_activo_fijo=new DocsLayoutMaestroDetalleEP(idContenedor);

	layout_activo_fijo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_activo_fijo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_SaveAndOther= this.ClaseMadre_SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_enableSelect=this.EnableSelect;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodo=this.ocultarTodosComponente
	var CM_mostrarTodo=this.motrarTodosComponente;
	var getFormulario=this.getFormulario;
	
	///////////////////////////////////
	// DEFINICIoN DE LA BARRA DE MENo//
	///////////////////////////////////

	var paramMenu = {
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear :true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIoN DE FUNCIONES ------------------------- //
	//  aquo se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/activo_fijo/ActionEliminaActivoFijo.php'},
		Save:{url:direccion+'../../../control/activo_fijo/ActionSaveActivoFijo.php'},
		ConfirmSave:{url:direccion+'../../../control/activo_fijo/ActionCambiarActivoFijo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,width:'68%',height:470,minWidth:150,minHeight:200,closable:true,
		columnas:['45%','45%'],
		titulo:'Registro Activo Fijo',
		grupos:[
		{	tituloGrupo:'Informacion General del Activo Fijo',columna:0,	id_grupo:0	},
		{	tituloGrupo:'Datos de adquisicion',columna:0,	id_grupo:1	},
		{	tituloGrupo:'Datos de adquisicion en moneda principal',	columna:0,	id_grupo:2	},
		{	tituloGrupo:'Datos de depreciacion',columna:1,	id_grupo:3	},
		{	tituloGrupo:'Datos vigentes',columna:1,	id_grupo:4	},
		{	tituloGrupo:'Garantia',	columna:1,	id_grupo:5	},
		{	tituloGrupo:'Datos Depreciacion',columna:1,	id_grupo:6	}, 
		{	tituloGrupo:'Observaciones',columna:1,	id_grupo:7	},
		{	tituloGrupo:'Datos de Ubicacion',columna:1,	id_grupo:8	},
		{	tituloGrupo:'Datos de Agrupador',columna:1,	id_grupo:9	},
		{	tituloGrupo:'Clones',columna:1,	id_grupo:10	},
		//23/04/2015
		{	tituloGrupo:'Tensiones',columna:1,	id_grupo:11	}	 
		]}
		
	};

	this.EnableSelect=function(x,z,y){
		enable(x,z,y);
		_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.desbloquearMenu();
	}

	//-------------- DEFINICIoN DE FUNCIONES PROPIAS --------------//
	function cargar_epuo(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			
			if(root.getElementsByTagName('id_fina_regi_prog_proy_acti')[0].firstChild != undefined && root.getElementsByTagName('id_fina_regi_prog_proy_acti')[0].firstChild != null)
			{
				//alert(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue);
				ds_solicitud_compra.baseParams={
				  	filtro_af:1,
				  	id_cotizacion_det:getComponente('id_cotizacion_det').getValue(),
				  	id_item: v_item
				  };	
				    getComponente('id_solicitud_compra').modificado=true;
				if(parseFloat(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>=1){ 
					CM_mostrarComponente(getComponente('id_solicitud_compra'));
					getComponente('desc_ep').setValue(root.getElementsByTagName('desc_ep')[0].firstChild.nodeValue);
					getComponente('desc_unidad_organizacional').setValue(root.getElementsByTagName('nombre_unidad')[0].firstChild.nodeValue);
					
					getComponente('id_ppto').setValue(root.getElementsByTagName('id_presupuesto')[0].firstChild.nodeValue);
					getComponente('tipo_ppto').setValue(root.getElementsByTagName('tipo_presu')[0].firstChild.nodeValue);
					
					getComponente('id_gestion').setValue(root.getElementsByTagName('id_gestion')[0].firstChild.nodeValue);
					getComponente('id_gestion').setRawValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
					getComponente('id_solicitud_compra').setValue(root.getElementsByTagName('id_solicitud_compra')[0].firstChild.nodeValue);
					getComponente('id_solicitud_compra').setRawValue(root.getElementsByTagName('num_sol')[0].firstChild.nodeValue);
				}else{}
			}
		}
	}
	//VENTANAS

	//Abre la ventana de Subtipos de Activos
	function btnCaracteristicas(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas
		if(NumSelect != 0)//Verifica si hay filas seleccionadas
		{		var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
		var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
		data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
		data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
		data = data + "&maestro_descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
		data = data + "&maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
		data = data + "&maestro_id_sub_tipo_activo=" + SelectionsRecord.data.id_sub_tipo_activo;
		var ParamVentana={Ventana:{width:'90%',height:'70%'}}
		layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_caracteristicas/activo_fijo_caracteristicas_det.php?'+data,'Caracteristicas AF',ParamVentana);
		layout_activo_fijo.getVentana().on('resize',function(){
			layout_activo_fijo.getLayout().layout();
		})
		//Abre la pestaoa del detalle
		//Docs.loadTab('../activo_fijo_caracteristicas/activo_fijo_caracteristicas_det.php?'+data, "Definicion de Caracterosticas [" + SelectionsRecord.data.codigo + "]");
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function btnComponentes(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0){//Verifica si hay filas seleccionadas
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
			data = data + "&maestro_descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
			data = data + "&maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
			data = data + "&maestro_id_sub_tipo_activo=" + SelectionsRecord.data.id_sub_tipo_activo;
			//Abre la pestaoa del detalle
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_componentes/activo_fijo_componentes_det.php?'+data,'Componentes AF',ParamVentana);
			layout_activo_fijo.getVentana().on('resize',function(){
				layout_activo_fijo.getLayout().layout();
			})
		}
		else
		{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')		}
	}


	function btnResponsables(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas
		if(NumSelect != 0){//Verifica si hay filas seleccionadas
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
			data = data + "&maestro_descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
			//Abre la pestaoa del detalle
			//Docs.loadTab('../activo_fijo_empleado/activo_fijo_empleado_det.php?'+data, "Responsables [" + SelectionsRecord.data.codigo + "]");
			var ParamVentana={Ventana:{width:'70%',height:'70%'}}
			layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo_empleado/activo_fijo_empleado_det.php?'+data,'Registro de Gastos',ParamVentana);
		}
		else
		{		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');		}
	}

	//Abre la ventana de Reparaciones
	function btnReparaciones(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas
		if(NumSelect != 0){//Verifica si hay filas seleccionadas
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
			data = data + "&maestro_descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
			//Abre la pestaoa del detalle
			var ParamVentana={Ventana:{width:'90%',height:'90%'}}
				
			layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/reparacion/reparacion_det.php?'+data,'Reparaciones',ParamVentana);
		}
		else
		{		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function btnEp(){
		var sm = getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
		//sm.clearSelections() ;//limpiar las selecciones realizadas

		if(NumSelect != 0){//Verifica si hay filas seleccionadas
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
			data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
			data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
			data = data + "&maestro_descripcion_larga=" + SelectionsRecord.data.descripcion_larga;
			data = data + "&maestro_id_tipo_activo=" + SelectionsRecord.data.id_tipo_activo;
			data = data + "&maestro_id_sub_tipo_activo=" + SelectionsRecord.data.id_sub_tipo_activo;
			//Abre la pestaoa del detalle
			//Docs.loadTab('../activo_fijo_componentes/activo_fijo_componentes_det.php?'+data, "Componentes [" + SelectionsRecord.data.codigo + "]");
			var ParamVentana={Ventana:{width:'60%',height:'40%'}}
			layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/activo_fijo/estructura_programatica_det.php?'+data,'Estructura Programática',ParamVentana);
			layout_activo_fijo.getVentana().on('resize',function(){
				layout_activo_fijo.getLayout().layout();
			})
		}
		else
		{	Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')		}
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name);
		}

		//23/04/2015
		combo_tension=getComponente('tension');
		combo_tension_adt=getComponente('tipo_bien_adt');
		combo_tension_gen=getComponente('tipo_bien_gen');
		
		combo_tipo_activo=getComponente('id_tipo_activo');
		combo_sub_tipo_activo=getComponente('id_sub_tipo_activo');
		h_txt_vida_util_original=getComponente('vida_util_original');
		h_txt_vida_util_restante=getComponente('vida_util_restante');
		h_txt_tasa_depreciacion=getComponente('tasa_depreciacion');
		h_txt_id_moneda=getComponente('id_moneda');
		h_txt_monto_compra_mon_orig=getComponente('monto_compra_mon_orig');
		h_txt_monto_compra=getComponente('monto_compra');
		h_txt_tipo_cambio=getComponente('tipo_cambio');
		h_txt_monto_actual=getComponente('monto_actual');
		h_txt_fecha_reg=getComponente('fecha_reg');
		combo_moneda_original=getComponente('id_moneda_original');
		combo_con_garantia = getComponente('con_garantia');
		h_txt_num_poliza_garantia = getComponente('num_poliza_garantia');
		h_txt_fecha_fin_gar = getComponente('fecha_fin_gar');
		h_txt_fecha_ini_dep = getComponente('fecha_ini_dep');
		h_txt_fecha_compra = getComponente('fecha_compra');
		h_txt_orden_compra = getComponente('orden_compra');
		h_txt_codigo = getComponente('codigo');
		h_txt_correlativo_act=getComponente('correlativo_act');
		h_txt_responsable=getComponente('responsable');
		combo_depto=getComponente('id_depto');
		ds_depto.baseParams={subsistema:'actif'};
		txt_origen=getComponente('origen');
		combo_cotizacion=getComponente('id_cotizacion');
		combo_cotizacion_det=getComponente('id_cotizacion_det');
		combo_sol=getComponente('id_solicitud_compra');
		
		combo_ppto=getComponente('id_ppto');
		combo_gestion=getComponente('id_gestion');
		getComponente('tipo_af_bien').on('select',onTipoAfBien);	
		
		h_txt_codigo.disable();	
		
		var onDepto=function(e,r,i){			    
			ds_deposito.baseParams.id_depto=getComponente('id_depto').getValue();
			getComponente('id_ppto').modificado=true;
							
			if(r.data.codificacion == 'abierto'){						
				h_txt_codigo.enable();
				h_txt_codigo.setValue('');
			}else{						
				h_txt_codigo.disable();				
			}				
			tipo_cod = r.data.codificacion; //abierto o normal			
		}
		
		combo_depto.on('select',onDepto);
		
		var onGestion=function(e){
			getComponente('id_ppto').setValue('');				
			getComponente('id_ppto').modificado=true;
			getComponente('id_ppto').enable();
			
			ds_ppto.baseParams={
				id_gestion:e.value
			}
			getComponente('id_ppto').modificado=true;
		}
		
		combo_gestion.on('select',onGestion);
		combo_gestion.on('change',onGestion);
		
		var onPpto=function(e,r,i){
			getComponente('desc_ep').setValue('');
			getComponente('desc_unidad_organizacional').setValue('');
			getComponente('desc_ep').setValue(r.data.desc_epe);
			getComponente('desc_unidad_organizacional').setValue(r.data.nombre_unidad);		
			getComponente('tipo_ppto').setValue(r.data.tipo_pres);

			//23/04/2015
			programa_activo = obtener_programa(getComponente('desc_ep').getValue());
			verifica_programa('COD',programa_activo);
		}
		combo_ppto.on('select',onPpto);
		
		var onSol=function(e,r,i){ 
			//getComponente('desc_ep').setValue('');
			//getComponente('desc_unidad_organizacional').setValue('');
			getComponente('desc_ep').setValue(r.data.desc_ep);
			//getComponente('id_ep').setValue(r.data.id_fina_regi_prog_proy_acti);
			getComponente('desc_unidad_organizacional').setValue(r.data.nombre_unidad);
			//getComponente('id_unidad_organizacional').setValue(r.data.id_unidad_organizacional);
					
			getComponente('id_ppto').setValue(r.data.id_presupuesto);
			getComponente('tipo_ppto').setValue(r.data.tipo_presu);
					
			getComponente('id_gestion').setValue(r.data.id_gestion);
			getComponente('id_gestion').setRawValue(r.data.gestion);
			
			getComponente('id_solicitud_compra').setValue(r.data.id_solicitud_compra);

			if(parseFloat(r.data.cantidad_adj)>1){
				Ext.MessageBox.show({
       			title: 'ALERTA',
       			msg: 'Existen <br />'+r.data.cantidad_adj+'<br /> items en esta compra, registrarlos todos?',
       			width:305,
       			buttons: Ext.MessageBox.YESNO,
       			fn: getObservaciones,
       			icon:Ext.MessageBox.QUESTION
       			});
			}
		}
		combo_sol.on('select',onSol);

		var onOrigen=function(e){
			getComponente('desc_ep').setValue('');
			getComponente('desc_unidad_organizacional').setValue('');
			getComponente('tipo_ppto').setValue('');
			getComponente('id_gestion').setValue('');
			
			if(e.value=='compro'){
				CM_ocultarComponente(getComponente('id_ppto'));
				
				ds_cotizacion.baseParams={
				   	 filtro_af:1,
				   	 depto:getComponente('id_depto').getValue()
				};
				ds_cotizacion.modificado=true;
				
				CM_mostrarComponente(getComponente('id_cotizacion'));
				CM_mostrarComponente(getComponente('id_cotizacion_det'));
				//CM_ocultarComponente(getComponente('descripcion'));
				getComponente('id_cotizacion').allowBlank=false;
				getComponente('id_cotizacion_det').allowBlank=false;
				getComponente('descripcion').setValue(' ');
				CM_ocultarComponente(getComponente('id_ppto'));
				getComponente('id_gestion').disable();
			}else{
				CM_mostrarComponente(getComponente('id_ppto'));
				CM_ocultarComponente(getComponente('id_cotizacion'));
				CM_ocultarComponente(getComponente('id_cotizacion_det'));
				//CM_mostrarComponente(getComponente('descripcion'));
				getComponente('id_cotizacion').allowBlank=true;
				getComponente('id_cotizacion_det').allowBlank=true;
				getComponente('descripcion').allowBlank=false;
				
				getComponente('id_cotizacion').setValue('');
				getComponente('id_cotizacion_det').setValue('');
				getComponente('id_cotizacion_det').disable();
				
				getComponente('orden_compra').setValue('');
				getComponente('id_moneda_original').setValue('');
				getComponente('monto_compra_mon_orig').setValue('');
				getComponente('fecha_compra').setValue('');
				getComponente('num_factura').setValue('');
				getComponente('monto_compra').setValue('');
				getComponente('monto_actual').setValue('');
				
				getComponente('id_gestion').enable();
				getComponente('id_gestion').setValue('');
				getComponente('id_ppto').disable();
				getComponente('id_ppto').setValue('');
				ds_ppto.baseParams={
					id_gestion:getComponente('id_gestion').getValue()
				}
				getComponente('id_ppto').modificado=true;
			}
		}
		
		txt_origen.on('select',onOrigen);
		txt_origen.on('change',onOrigen);
	
		var onTipoActivoSelect = function(e){															
			id_tipo_activo = combo_tipo_activo.getValue();
			combo_sub_tipo_activo.setValue("");
			combo_sub_tipo_activo.filterValues[0] = id_tipo_activo;
			combo_sub_tipo_activo.modificado = true;
							
			//Obtener el codigo del tipo de activo
			if(combo_tipo_activo.store.getById(id_tipo_activo).data.codigo!=undefined){				
				if(tipo_cod == 'abierto'){							
					h_txt_codigo.enable();
				}else{						
					h_txt_codigo.disable();
					h_txt_codigo.setValue(combo_tipo_activo.store.getById(id_tipo_activo).data.codigo);
					cod_tipo_activo=h_txt_codigo.getValue();
				}															
			}else{
				h_txt_codigo.setValue('');	
				cod_tipo_activo='';
			}
		}

		//Obtiene los datos vigentes
		function get_datos_subtipo(){
			//Obtener el codigo del tipo de activo
			id_sub_tipo_activo=combo_sub_tipo_activo.getValue();
			if(combo_sub_tipo_activo.store.getById(id_sub_tipo_activo).data!=undefined){
				var data=combo_sub_tipo_activo.store.getById(id_sub_tipo_activo).data;
				h_txt_vida_util_original.setValue(data.vida_util);
				h_txt_vida_util_restante.setValue(data.vida_util);
				h_txt_tasa_depreciacion.setValue(data.tasa_depreciacion);
				txt_codtipo=h_txt_codigo.getValue(data.codigo);
				
				if(tipo_cod != 'abierto'){	
					h_txt_codigo.setValue(cod_tipo_activo+data.codigo);
					h_txt_codigo.disable();	
				}else{
					h_txt_codigo.enable();	
				}			
			}
		}

		function convertir_monto(){
			var postData;
			
			var fecha = get_fecha(h_txt_fecha_reg.getValue());
			Ext.MessageBox.hide();
			Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionConvertirMonedas.php?fecha=" + fecha + "&monto="+h_txt_monto_compra_mon_orig.getValue()+"&id_moneda1="+h_txt_id_moneda.getValue()+"&id_moneda2="+combo_moneda_original.getValue()+"&tipo=O",
				method:'GET',
				success:  cargar_monto_convertido,
				failure:Cm_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}
		
		//Carga el monto convertido
		function cargar_monto_convertido(resp){
			Ext.MessageBox.hide();
			//console.log(resp);
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if(root.getElementsByTagName('monto')[0].firstChild != undefined && root.getElementsByTagName('monto')[0].firstChild != null){
					h_txt_monto_compra.setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
					h_txt_monto_actual.setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
				}else{
					h_txt_monto_compra.setValue('');
					h_txt_monto_actual.setValue('');
				}
			}
		}

		//Funcion que deshabilita los controles de poliza de garantoa y fecha fin garantoa si se elige no
		function garantia(){
			if(combo_con_garantia.getValue() == 'si'){
				h_txt_num_poliza_garantia.enable();
				h_txt_fecha_fin_gar.enable();
			}else{
				h_txt_num_poliza_garantia.setValue("");
				h_txt_fecha_fin_gar.setValue("");
				h_txt_num_poliza_garantia.disable();
				h_txt_fecha_fin_gar.disable();
			}
		}

		function calcular_tasa_dep(){
			if(h_txt_vida_util_original.getValue() != undefined && h_txt_vida_util_original.getValue() != null){
				//Copia el valor en vida util restante
				if(h_txt_vida_util_restante.getValue()==''){
					h_txt_vida_util_restante.setValue(h_txt_vida_util_original.getValue());
				}

				if(h_txt_vida_util_original.getValue() != ""){
					h_txt_tasa_depreciacion.setValue(redondear(100/h_txt_vida_util_original.getValue(),6));
				}else{
					h_txt_tasa_depreciacion.setValue("");
				}
			}else{
				h_txt_tasa_depreciacion.setValue("");
			}
		}
		//Define los eventos de los componentes y las acciones a ejecutar
		//combo_tipo_activo.on('valid', get_fecha_bd);
		combo_tipo_activo.on('select', onTipoActivoSelect);
		combo_tipo_activo.on('change', onTipoActivoSelect);
		combo_sub_tipo_activo.on('select', get_datos_subtipo);
		combo_sub_tipo_activo.on('change', get_datos_subtipo);
		h_txt_monto_compra_mon_orig.on('change', convertir_monto);
		combo_moneda_original.on('select', get_tipo_cambio);
		combo_moneda_original.on('change', get_tipo_cambio);
		combo_con_garantia.on('change', garantia);
		combo_con_garantia.on('select', garantia);
		h_txt_vida_util_original.on('valid',calcular_tasa_dep);
		h_txt_fecha_compra.on('blur', cargar_fecha_ini_dep);//valid
		h_txt_fecha_compra.on('valid',get_tipo_cambio);
		h_txt_monto_compra_mon_orig.on('change',get_tipo_cambio);

		getSelectionModel().on('rowdeselect',function(){
			if(_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.limpiarStore()){
				_CP.getPagina(layout_activo_fijo.getIdContentHijo()).pagina.bloquearMenu()
			}
		})

		//23/04/2015
		function obtener_programa(prog)
		{
			if(prog != '')
			{
				var res = prog.split('-');
				return res[2];
			}
		}
		function verifica_programa(cod_tipo,programa)
		{
			getComponente('programa').setValue(programa);
			
			if(programa == 'DIS' || programa == 'ADM' || programa =='TRA')
			{
				if(programa == 'DIS')
				{
					CM_mostrarComponente(combo_tension);
					combo_tension.enable();
					combo_tension.allowBlank=true;
					
					CM_mostrarComponente(combo_tension_adt);
					combo_tension_adt.enable();
					combo_tension_adt.allowBlank=true;
					
					CM_ocultarComponente(combo_tension_gen);
					combo_tension_gen.setValue('');
					combo_tension_gen.disable();
				}
				else
				{
					CM_mostrarComponente(combo_tension_adt);
					combo_tension_adt.enable();
					combo_tension_adt.allowBlank=true;

					CM_ocultarComponente(combo_tension);
					combo_tension.setValue('');
					combo_tension.disable();
					
					CM_ocultarComponente(combo_tension_gen);
					combo_tension_gen.setValue('');
					combo_tension_gen.disable();		
				}	
			}
			else
			{
					CM_mostrarComponente(combo_tension_gen);
					combo_tension_gen.enable();
					combo_tension_gen.allowBlank=true;
				
					CM_ocultarComponente(combo_tension);
					combo_tension.setValue('');
					combo_tension.disable()
					
					CM_ocultarComponente(combo_tension_adt);
					combo_tension_adt.setValue('');
					combo_tension_adt.disable();
			}
		}
	}

	function onTipoAfBien(s,r,i){
			gestionarGruposBien(r.data.id);
	}


	function getObservaciones(btn,text){
		if(btn!='no'){
			getComponente('clonacion').setValue('si');
		}else{
			getComponente('clonacion').setValue('no');
		}
	 }
		
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}else{
			Cm_conexionFailure();
		}
	}
		
	function get_fecha(fecha){ 
		var fecha = new Date(fecha);
		var dia;
		var mes;
		var anio;
		var fecha_res;
		dia = fecha.getDate();
		mes = fecha.getMonth() + 1;
		anio = fecha.getFullYear();
		fecha_res = dia + "/" + mes + "/" + anio;
		return fecha_res;
	}
		
	function get_fecha_bd(){
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}

	function cargar_fecha_bd(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha_reg.getValue()==""){
				h_txt_fecha_reg.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				
				Ext.Ajax.request({
					url:direccion+"../../../../sis_parametros/control/depto/ActionListarDepartamento.php?usuario="+usuario+'&subsistema=actif',

					method:'GET',
					success:cargar_depto_af,
					failure:Cm_conexionFailure,
					timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
				Ext.MessageBox.show({
						title: 'Espere por favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Cargando Unidad...</div>",
						width:150,
						height:200,
						closable:false
				});
			}
		}
	}
		
	function cargar_depto_af(resp){
			Ext.MessageBox.hide();					
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
                    
					getComponente('id_depto').setValue(root.getElementsByTagName('id_depto')[0].firstChild.nodeValue);
					getComponente('id_depto').setRawValue(root.getElementsByTagName('nombre_depto')[0].firstChild.nodeValue);
					ds_deposito.baseParams.id_depto=getComponente('id_depto').getValue();
					getComponente('id_deposito').modificado=true;
					
					
				}else{
					getComponente('id_depto').setValue('');
				}
			}
			
		}

	function get_moneda_principal(){

		Ext.MessageBox.hide();
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerMonedaPrincipal.php",
			method:'GET',
			success:  cargar_moneda_principal,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
		});


	}

	//Carga la moneda principal
	function cargar_moneda_principal(resp){
		Ext.MessageBox.hide();
		if((resp.responseXML.documentElement.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0)
		{	var root = resp.responseXML.documentElement;
		h_txt_id_moneda.setValue(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
		h_txt_id_moneda.modificado=true;
		

		}
	}


		function get_tipo_cambio(){

			//var fecha = get_fecha(h_txt_fecha_compra.getValue());

          if(getComponente('fecha_compra').getValue()!=''&&getComponente('fecha_compra').getValue()!=null){
          
			Ext.MessageBox.hide();
			Ext.Ajax.request({
				url:direccion+"../../../../lib/lib_control/action/ActionObtenerTipoCambio.php?fecha=" + getComponente('fecha_compra').getValue().dateFormat('d/m/Y') + "&id_moneda1=" + h_txt_id_moneda.getValue()  + "&id_moneda2=" + combo_moneda_original.getValue() + "&tipo=O",
				method:'GET',
				success:  cargar_tipo_cambio,
				failure:Cm_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
            }

		}


		//Carga el tipo de cambio obtenido en los componentes
		function cargar_tipo_cambio(resp){
			//alert(resp.responseXML.documentElement.getElementsByTagName('tipo_cambio')[0].firstChild.nodeValue);
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
			{	var root = resp.responseXML.documentElement;
			if(root.getElementsByTagName('tipo_cambio')[0].firstChild.nodeValue != 0) {
				if(root.getElementsByTagName('tipo_cambio')[0].firstChild != undefined && root.getElementsByTagName('tipo_cambio')[0].firstChild != null)
				{	h_txt_tipo_cambio.setValue(root.getElementsByTagName('tipo_cambio')[0].firstChild.nodeValue);
				}
				else
				{	if(root.getElementsByTagName('tipo_cambio')[0].firstChild != 0  && root.getElementsByTagName('tipo_cambio')[0].firstChild != null)
				{	h_txt_tipo_cambio.setValue(root.getElementsByTagName('tipo_cambio')[0].firstChild.nodeValue);
				}
				else
				{	h_txt_tipo_cambio.setValue("");
				//Ext.MessageBox.alert('Tipo de cambio no definido', 'No existe el tipo de cambio para la fecha y moneda especificada.');
				Ext.Msg.show({
					title: 'Tipo de cambio no definido',
					msg: "No existe el tipo de cambio para la fecha y moneda especificada",
					minWidth:300,
					buttons: Ext.Msg.OK
				});
				}
				}
				//Recalcula el monto en la moneda principal
				if(h_txt_monto_compra_mon_orig.getValue() != "" && h_txt_tipo_cambio.getValue())
				{	h_txt_monto_compra.setValue(h_txt_monto_compra_mon_orig.getValue() * h_txt_tipo_cambio.getValue());
				h_txt_monto_actual.setValue(h_txt_monto_compra_mon_orig.getValue() * h_txt_tipo_cambio.getValue());
				}
			}
			else
			{	h_txt_tipo_cambio.setValue("");
			Ext.Msg.show({
				title: 'Tipo de cambio no definido',
				msg: "No existe el tipo de cambio para la fecha y moneda especificada",
				minWidth:300,
				buttons: Ext.Msg.OK
			});
			}
			}
		}

		function cargar_fecha_ini_dep(){
			if(h_txt_fecha_compra.getValue() != '')
			{	h_txt_fecha_ini_dep.setValue(h_txt_fecha_compra.getValue());
			}
			//}
			else
			{		h_txt_fecha_ini_dep.setValue('');
			}
		}



		this.btnNew = function(){
			h_txt_codigo.disable();
			data1='';
			v_item='';
			CM_mostrarTodo();
			CM_ocultarComponente(getComponente('id_cotizacion'));
			CM_ocultarComponente(getComponente('num_clones'));
			CM_ocultarComponente(getComponente('id_solicitud_compra'));
			CM_ocultarComponente(getComponente('id_cotizacion_det'));
			CM_ocultarComponente(getComponente('fecha_reg'));
			CM_mostrarComponente(getComponente('id_ppto'));
			getComponente('id_gestion').enable();
			getComponente('id_ppto').disable();
			getComponente('id_cotizacion_det').disable();
			getComponente('id_tipo_activo').enable();
			getComponente('id_sub_tipo_activo').enable();
			getComponente('depreciacion_acum_ant').setValue(0);
			CM_ocultarGrupo('Clones');
//			ds_unidad_organizacional.baseParams={m_sw_presupuesto:'si'};
//			ds_unidad_organizacional.modificado=true;
			ClaseMadre_btnNew();
			gestionarGruposBien('activo');
			get_fecha_bd();
			
			get_moneda_principal();
			if (sw==0){
				//Carga el valor por defecto a la moneda principal como Bolivianos
				var  params = new Array();
				params['id_moneda'] = 1;
				params['nombre'] = 'Bolivianos';
				var aux = new Ext.data.Record(params,1);
				combo_moneda_original.store.add(aux)
				combo_moneda_original.setValue(1);
				sw=1;
			}
			if(combo_moneda_original.getValue() != ""){
				h_txt_tipo_cambio.setValue("1");
			}
			ds_gestion.baseParams={
				estado:'abierto'
			}
		}
		
		
		
		this.btnEdit = function(){
			
			h_txt_codigo.disable();
			data1='';
			CM_mostrarTodo();
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();

			ds_cotizacion.baseParams={
			  	 filtro_af:1,
			  	 depto:getComponente('id_depto').getValue()
			};
			CM_ocultarComponente(getComponente('num_clones'));
			ds_cotizacion.modificado=true;
			CM_ocultarComponente(getComponente('id_solicitud_compra'));
			CM_ocultarGrupo('Clones');
				if(NumSelect!=0)
				{
					var SelectionsRecord=sm.getSelected();
					CM_ocultarComponente(getComponente('fecha_reg'));
					getComponente('id_ppto').disable();
					
					if(SelectionsRecord.data.origen=='compro'){
						getComponente('id_gestion').disable();
						CM_ocultarComponente(getComponente('id_ppto'));
						//CM_ocultarComponente(getComponente('descripcion'));
						CM_mostrarComponente(getComponente('id_cotizacion'));
						CM_mostrarComponente(getComponente('id_cotizacion_det'));
						getComponente('id_cotizacion_det').disable();
						getComponente('id_cotizacion_det').allowBlank=false;
						getComponente('id_cotizacion').allowBlank=false;
						
					}else{
						CM_mostrarComponente(getComponente('id_ppto'));
						//CM_mostrarComponente(getComponente('descripcion'));
						CM_ocultarComponente(getComponente('id_cotizacion'));
						CM_ocultarComponente(getComponente('id_cotizacion_det'));
						getComponente('id_cotizacion_det').allowBlank=true;
						getComponente('id_cotizacion').allowBlank=true;
					}
					if(SelectionsRecord.data.estado=='registrado'){
						getComponente('id_tipo_activo').enable();
						getComponente('id_sub_tipo_activo').enable();
					}
					else{
						getComponente('id_tipo_activo').disable();
						getComponente('id_sub_tipo_activo').disable();
					}
					
					if(SelectionsRecord.data.estado == 'codificado')
					{						
						getComponente('codigo').disable();
					}

					//23/04/2015
					update_tension(SelectionsRecord.data.desc_ep,'tipo');
															
					ClaseMadre_btnEdit();
					gestionarGruposBien(SelectionsRecord.data.tipo_af_bien);
					ds_deposito.baseParams.id_depto=getComponente('id_depto').getValue();
					getComponente('id_deposito').modificado=true;
					getComponente('vida_util_restante').setValue(SelectionsRecord.data.vida_util_restante);
						
				}else{
					alert('Debe seleccionar un item');
				}
		}

		//23/04/2015	
		function gestionarComboTension(combo)
		{
			//1 combo combo_tension
			//2 combo combo_tension_adt
			//3 combo combo_tension_gen
			
			if(combo == 1)
			{
				
				CM_ocultarComponente(combo_tension_gen);
				combo_tension_gen.setValue('');
				combo_tension_gen.disable();
				
				CM_mostrarComponente(combo_tension);
				combo_tension.enable();
				combo_tension.allowBlank=true;
				
				CM_mostrarComponente(combo_tension_adt);
				combo_tension_adt.enable();
				combo_tension_adt.allowBlank=true;
			}
			else if(combo == 2)
			{
				CM_mostrarComponente(combo_tension_adt);
				combo_tension_adt.enable();
				combo_tension_adt.allowBlank=true;
				
				CM_ocultarComponente(combo_tension);
				combo_tension.setValue('');
				combo_tension.disable()
				
				CM_ocultarComponente(combo_tension_gen);
				combo_tension_gen.setValue('');
				combo_tension_gen.disable()
			}	
			else if(combo == 3)
			{
				CM_ocultarComponente(combo_tension_adt);
				combo_tension_adt.setValue('');
				combo_tension_adt.disable()
								
				CM_mostrarComponente(combo_tension_gen);
				combo_tension_gen.enable();
				combo_tension_gen.allowBlank=true;
				
				CM_ocultarComponente(combo_tension);
				combo_tension.setValue('');
				combo_tension.disable()
			}
		}
		
		function update_tension(prog,tipo)
		{
			var res = prog.split('-');
			var programa = res[2];
			//var cod_activo = tipo.substring(0,2);
			
			getComponente('programa').setValue(programa);
			
			if(programa == 'DIS' || programa == 'ADM' || programa =='TRA')
			{
				if(programa == 'DIS')
				{
					gestionarComboTension(1);
				}
				else
				{
					gestionarComboTension(2);
				}
			}
			else
					gestionarComboTension(3);
		}
		// fin 23/04/2015

		this.btnSave = function(){

			ClaseMadre_Save();
			alert(session.getValue("cod_activo_fijo_grabar"));
		}


		function btnClon(){
			var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				if(NumSelect!=0){ 
					if(clones.getValue()>0){
						var data="cantidad_ids=1&id_activo_fijo_0="+SelectionsRecord.data.id_activo_fijo+'&num_clones_0='+clones.getValue();
							Ext.Ajax.request({url:direccion+"../../../control/activo_fijo/ActionSaveActivoFijo.php",
							params:data,
							method:'POST',
							failure:Cm_conexionFailure,
							success:exito,
							timeout:100000000
							});	
					}else{
						alert('La cantidad de Clones no puede ser 0');
					}
					
				}else{
					alert('antes debe seleccionar un item');
				}
					
		}
		
	
			function exito(resp){
       			Ext.MessageBox.alert('Estado','Clonacion completada');		
					ds.load({
						params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
						}
					});
			}
			
	function btnCodif(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		
		if(NumSelect==1){
			if(confirm('oEsto seguro de generar el Codigo del Activo Fijo?')){
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando Codigo...</div>",
					width:300,
					height:200,
					closable:false
				});
				Ext.Ajax.request({
					url:direccion+"../../../control/activo_fijo/ActionCodificarActivo.php",
					method:'POST',
					params:{cantidad_ids:'1',id_activo_fijo_0:SelectionsRecord.data.id_activo_fijo},
					success:esteSuccess,
					failure:Cm_conexionFailure,
					timeout:100000000
				});			
			}
		} else{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		} 
	}
	
	function btnImprimir(){		
		var sm=getSelectionModel();				
		var NumSelect=sm.getCount();
				if(NumSelect==1){
					var SelectionsRecord=sm.getSelected();	
					var data='m_id_activo_fijo='+SelectionsRecord.data.id_activo_fijo;
					data=data+'&txt_codigo='+SelectionsRecord.data.codigo;
					data=data+'&txt_descripcion='+SelectionsRecord.data.descripcion;
					
					window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/codigo_barras_128/ActionPDFCodigoBarrasImprimir.php?'+data);					
				}
				else if(NumSelect>1) {
					Ext.MessageBox.alert('Estado', 'Tiene mas de un registro seleccionado.');
				}	
				else{
					Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro')
				}
	}
	
	function gestionarGruposBien(tipo){
		if(tipo=='bien_resp'){
			CM_ocultarGrupo('Datos de adquisicion en moneda principal');
			CM_ocultarGrupo('Datos de depreciacion');
			CM_ocultarGrupo('Datos vigentes');
			CM_ocultarGrupo('Garantoa');
			CM_ocultarGrupo('Datos Depreciacion');
			SiBlancosGrupo(2);
			SiBlancosGrupo(3);
			SiBlancosGrupo(4);
			SiBlancosGrupo(5);
			SiBlancosGrupo(6);
			getComponente('vida_util_original').setValue(1);
			getComponente('vida_util_restante').setValue(1);
			getComponente('tasa_depreciacion').setValue(1);
			
		}
		else{
			
			CM_mostrarGrupo('Datos de adquisicion en moneda principal');
			CM_mostrarGrupo('Datos de depreciacion');
			CM_mostrarGrupo('Datos vigentes');
			CM_mostrarGrupo('Garantoa');
			CM_mostrarGrupo('Datos Depreciacion');
			NoBlancosGrupo(2);
			NoBlancosGrupo(3);
			NoBlancosGrupo(4);
			NoBlancosGrupo(5);
			NoBlancosGrupo(6);
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
	
	function esteSuccess(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement){
			ClaseMadre_btnActualizar();
		} else{
			Cm_conexionFailure();
		}
	}
	

		//para que los hijos puedan ajustarse al tamaoo
		this.getLayout=function(){return layout_activo_fijo.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);
		//InitBarraMenu(array DE PARoMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);
		
		var CM_getBoton=this.getBoton;
		var clones =new Ext.form.NumberField({
			allowNegative: false,
			allowBlank: false,
			
            allowDecimals: false,
			minValue:0,
			width:30
		});
		
//		clones.on('blur',function (){
//// 				if(clones.getValue()>0){
//// 					CM_getBoton('clon-'+idContenedor).enable();	
//// 				}else{
//// 					CM_getBoton('clon-'+idContenedor).disable();	
//// 				}
//   });
		
		this.AdicionarBoton("../../../lib/imagenes/detalle.png",'<b>Caracteristicas<b>',btnCaracteristicas,true,'caracteristicas','Caracteristicas');
		this.AdicionarBoton("../../../lib/imagenes/bricks.png",'<b>Componentes<b>',btnComponentes,true,'componentes','Componentes');
		this.AdicionarBoton("../../../lib/imagenes/user_otro.png",'<b>Responsables<b>',btnResponsables,true,'responsables','Responsables');
		this.AdicionarBoton("../../../lib/imagenes/wrench.png",'<b>Reparaciones<b>',btnReparaciones,true,'reparaciones','Reparaciones');
		this.AdicionarBoton("../../../lib/imagenes/wrench.png",'<b>Codificar<b>',btnCodif,true,'codificar','Codificar');

		this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Estructura Programatica<b>',btnEp,true,'ep','Estructura Programatica');
		this.AdicionarBoton("",'<b>Clonar AF<b>',btnClon,true,'clon','Clonar AF');
		this.AdicionarBotonCombo(clones,'clon');
		this.AdicionarBoton('../../../lib/imagenes/codigo_barras22.png','Impresión del código de barras',btnImprimir,true,'Reporte','');


		this.AdicionarBoton('../../../lib/imagenes/lupa2.png','Otras Observaciones',btnObservacionesVarios,true,'obs_varias','Observaciones'); 


		function rol_observaciones_varias()
		{
				Ext.MessageBox.hide();
				Ext.Ajax.request({
				url:direccion+"../../../../sis_activos_fijos/control/observaciones_varias/ActionControlRolObservaciones.php",
				method: 'GET',
				params:  {id_usuario : usuario,rol_observaciones : 'si'},
				success: cargar_observaciones,
				failure: Cm_conexionFailure,
				timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
				});
			};
		function cargar_observaciones(resp)
		{
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
			{
				var root = resp.responseXML.documentElement;
				if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue > 0)
				{
					CM_getBoton('obs_varias-'+idContenedor).setVisible(true);
				}
				else
				{
					CM_getBoton('obs_varias-'+idContenedor).setVisible(false);
				}
			}
		}
		
		function btnObservacionesVarios()
		{
			var sm = getSelectionModel();
			var filas = ds.getModifiedRecords();
			var cont = filas.length;
			var NumSelect = sm.getCount(); //recupera la cantidad de filas selecionadas
			
			if(NumSelect != 0){//Verifica si hay filas seleccionadas
				var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
				var data = "maestro_id_activo_fijo=" + SelectionsRecord.data.id_activo_fijo;
				data = data + "&maestro_codigo=" + SelectionsRecord.data.codigo;
				data = data + "&maestro_descripcion=" + SelectionsRecord.data.descripcion;
	
				var ParamVentana={Ventana:{width:'90%',height:'90%'}}
					
				layout_activo_fijo.loadWindows(direccion+'../../../../sis_activos_fijos/vista/observaciones_varias/observaciones_varias.php?'+data,'Reparaciones',ParamVentana);
			}
			else
			{		Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro.');
			}
		}
		
		//SOBRE CARGA DE FUNCIONES

		
		function enable(sel,row,selected){
			var record=selected.data;
			clones.setValue(0);
			CM_getBoton('clon-'+idContenedor).enable();
			if(record.clonacion=='si'){
				CM_getBoton('clon-'+idContenedor).disable();	
			}else{
				CM_getBoton('clon-'+idContenedor).enable();
			}
			if(record.estado=='alta'){
				//CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
			}else{
				//CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
			}
			
			if(record.estado == 'codificado')
			{
				CM_getBoton('codificar-'+idContenedor).disable();
				h_txt_codigo.disable();
				combo_depto.disable();
			}
			else
			{
				combo_depto.enable();
				CM_getBoton('codificar-'+idContenedor).enable();
			}				
			
			CM_enableSelect(sel,row,selected)
		}

		this.iniciaFormulario();
		rol_observaciones_varias();
		iniciarEventosFormularios();

		layout_activo_fijo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);


		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
			}
		});

}
