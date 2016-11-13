<?php 
/**
 * Nombre:		  	    carta_amortizacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-18 20:39:05
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_carta_amortizacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_carta_amortizacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-18 20:39:05
 */
function pagina_carta_amortizacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/carta/ActionListarCartaRegistro.php?sw_estado=2'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_carta',totalRecords:'TotalCount'
		},[		
		'id_carta',
        'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_moneda',
		'desc_moneda',
		'nombre_moneda',
		'clase_carta',
		'tipo_carta',
		'estado_carta',
		'id_cuenta_bancaria',
		'nro_cuenta_banco_cuenta_bancaria',
		'desc_cuenta_bancaria_inst',
		'id_institucion',
		'desc_institucion',
		'desc_cuenta_banc_inst',
		'id_proveedor',
		'desc_proveedor',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_vence',type:'date',dateFormat:'Y-m-d'},
		'obs_carta',
		'importe_carta',
		'importe_pagado',
		'id_cheque',
		'nombre_cheque_cheque',
		'nro_cheque_cheque',
		'fecha_cheque_cheque',
		'desc_cheque',
		'id_comprobante',
		'desc_comprobante',
		'fk_carta',
		'nombre_unidad_unidad_organizacional',
		'clase_carta_carta',
		'tipo_carta_carta',
		'desc_carta'
		
		]),remoteSort:true});

	
	//DATA STORE COMBOS
   
  var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion',
	'desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco'])
	         
	});

    var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_institucion',totalRecords: 'TotalCount'},['id_institucion','doc_id','nombre','casilla','telefono1',
	'telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion',
	'estado_institucion','id_persona','direccion','id_tipo_doc_institucion'])
	});
	
	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords: 'TotalCount'},['id_proveedor','id_institucion',
	'desc_institucion','id_persona','desc_persona','telefono2','celular1','nombre_pago',
	'nombre_proveedor','telefono1_proveedor','fax_proveedor','desc_insti_per'])
	});
	
	var ds_cheque = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cheque/ActionListarCheque.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cheque',totalRecords: 'TotalCount'},
	['id_cheque','id_transaccion','desc_transaccion','nro_cheque','nro_deposito','fecha_cheque','nombre_cheque','estado_cheque',
	'id_cuenta_bancaria','desc_cuenta_bancaria_inst','nro_cuenta_cuenta','descripcion_cuenta','nro_cuenta_banco_cuenta_bancaria'])
	});

	var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/comprobante/ActionListarComprobante.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},
	['id_comprobante','id_parametro','desc_parametro','nro_cbte','momento_cbte','fecha_cbte',
	'concepto_cbte','glosa_cbte','acreedor','aprobacion','conformidad','pedido','id_periodo_subsis',
	'periodo_sub','id_moneda_reg','desc_moneda','id_usuario','desc_usuario','id_subsistema','desc_subsistema',
	'id_cbte_clase','desc_clases','id_moneda','desc_moneda'])
	});
	   

    var ds_carta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/carta/ActionListarCarta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_carta',totalRecords: 'TotalCount'},
	['id_carta','clase_carta','id_institucion','desc_institucion','id_moneda','desc_moneda','importe_carta',
	'importe_pagado','fecha_inicio','id_unidad_organizacional','desc_unidad_organizacional','estado_carta','obs_carta',
	'desc_cuenta_banc_inst'])
	});
		        
	//FUNCIONES RENDER
			
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
		
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
			
		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria_inst']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b>{nro_cuenta_banco}</b>','<br><FONT COLOR="#B5A642"><b>Cuenta: </b>{desc_cuenta}</FONT>','</div>'); 
		
		function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	    var tpl_id_institucion=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Dirección: </b>{direccion}</FONT>','</div>'); 
		
	    function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	    var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b>{desc_institucion}</b><b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Teléfono: </b>{telefono1_proveedor}</FONT>','</div>'); 
		
	    
		function render_id_cheque(value, p, record){return String.format('{0}', record.data['desc_cheque']);}
		var tpl_id_cheque=new Ext.Template('<div class="search-item">','<b>{nro_cheque}</b>','<br><FONT COLOR="#B5A642"><b>Nombre: </b>{nombre_cheque}</FONT>','</div>'); 

		function render_id_comprobante(value, p, record){return String.format('{0}', record.data['desc_comprobante']);}
		var tpl_id_comprobante=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nro_cbte}</FONT><br>','<FONT COLOR="#B5A642">{concepto_cbte}</FONT>','</div>');

		function render_id_carta(value, p, record){return String.format('{0}', record.data['desc_cuenta_banc_inst']);}
		var tpl_id_carta=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{desc_cuenta_banc_inst}</FONT><br>','</div>');

		
		
	function render_clase_carta(value){
		if(value==1){value='Entidad Financiera' }
		if(value==2){value='Institucion' }
		return value
	}
	
	function render_estado_carta(value){
		if(value==1){value='Pendiente' }
		if(value==2){value='Amortiza' }
		if(value==3){value='Cerrado' }
		if(value==4){value='Vencido' }
		return value
	}
	
	function render_tipo_carta(value){
		if(value==1){value='Ingreso' }
		if(value==2){value='Pago' }
		return value
	}
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_carta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_carta'
	};
// txt id_fina_regi_prog_proy_acti
		
		Atributos[1]={
		validacion:{
			name:'clase_carta',
			fieldLabel:'Clase Carta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.carta_amortizacion_combo.clase_carta}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Entidad Financiera'],['2','Institucion']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_clase_carta,
			grid_editable:false,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		save_as:'clase_carta',
		id_grupo:0
		
		};
		
		// txt id_cuenta_bancaria
 	        Atributos[2]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_cuenta_bancaria_inst', //indica la columna del store principal ds del que proviane la descripcion******
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
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre#CUEBAN.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:0
		
	};
// txt id_institucion
	Atributos[3]={
			validacion:{
			name:'id_institucion',
			fieldLabel:'Institución',
			allowBlank:true,			
			emptyText:'Institución...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_institucion,
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
			renderer:render_id_institucion,
			grid_visible:false,
			grid_editable:false,
			width_grid:80,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		save_as:'id_institucion',
		id_grupo:0
		
	};
	
	Atributos[4]={
		validacion:{
			name:'desc_cuenta_bancaria_inst',
			fieldLabel:'Institución',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'75%',
			disable:false		
		},
		tipo:'TextArea',
		form:true,
		filtro_0:true,
		save_as:'desc_cuenta_bancaria_inst',
		filterColValue:'desc_cuenta_bancaria_inst',
		id_grupo:0			
	};		
	
	// txt id_proveedor
	
	Atributos[5]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'Proveedor',
			allowBlank:true,			
			emptyText:'Proveedor...',
			desc: 'desc_proveedor', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'desc_insti_per',
			queryParam: 'filterValue_0',
			filterCol:'desc_proveedor',
			typeAhead:true,
			tpl:tpl_id_proveedor,
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
			renderer:render_id_proveedor,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'desc_proveedor',
		save_as:'id_proveedor',
		id_grupo:1
	};
			
	// txt id_moneda
	Atributos[6]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
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
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1
	};
	
	
	// txt importe_carta
	Atributos[7]={
		validacion:{
			name:'importe_carta',
			fieldLabel:'Importe Carta',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CARTA.importe_carta',
		save_as:'importe_carta',
		id_grupo:1
	};
// txt importe_pagado
	Atributos[8]={
		validacion:{
			name:'importe_pagado',
			fieldLabel:'Importe Pagado',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CARTA.importe_pagado',
		defecto:'0',
		save_as:'importe_pagado',
		id_grupo:1
	};

	Atributos[9]= {
		validacion:{
			name:'fecha_inicio',
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
		filtro_0:true,
		filterColValue:'CARTA.fecha_inicio',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio',
		id_grupo:1
	};
	
// txt fecha_vence
	Atributos[10]= {
		validacion:{
			name:'fecha_vence',
			fieldLabel:'Fecha Vencimiento',
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
		filtro_0:true,
		filterColValue:'CARTA.fecha_vence',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_vence',
		id_grupo:1
	};
	
	
	Atributos[11]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
		id_grupo:2
	};
  Atributos[12]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:false,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:2
		};
		// txt obs_carta
	Atributos[13]={
		validacion:{
			name:'obs_carta',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CARTA.obs_carta',
		save_as:'obs_carta',
		id_grupo:3
	};
	
 Atributos[14]={
		validacion:{
			name:'estado_carta',
			fieldLabel:'Estado Carta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Pendiente'],['2','Amortiza'],['3','Cerrado'],['4','Vencido']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_carta,
			grid_editable:false,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		defecto:'1',
		save_as:'estado_carta',
		id_grupo:3
		
		};
// txt tipo_carta
		
	Atributos[15]={
		validacion:{
			name:'tipo_carta',
			fieldLabel:'Tipo Carta',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Ingreso'],['2','Pago']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			renderer:render_tipo_carta,
			grid_visible:false,
			grid_editable:false,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		defecto:'1',
		save_as:'tipo_carta',
		id_grupo:3
		};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={titulo_maestro:'Carta Amortizacion',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/carta_amortizacion_detalle/carta_amortizacion_detalle.php'};
    var layout_carta_amortizacion=new DocsLayoutMaestroDeatalle(idContenedor);
    layout_carta_amortizacion.init(config);

	// INICIAMOS HERENCIA //
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_carta_amortizacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
	var btnEliminar=this.btnEliminar;
	var btnEliminar=this.btnEliminar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarFormulario=this.ocultarFormulario;
		var Cm_conexionFailure=this.conexionFailure;
		var Cm_btnActualizar=this.btnActualizar;
		var getGrid=this.getGrid;
		var getDialog= this.getDialog;
		var cm_EnableSelect=this.EnableSelect;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		//guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/carta/ActionEliminarCartaRegistro.php'},
		Save:{url:direccion+'../../../control/carta/ActionGuardarCartaRegistro.php'},
		ConfirmSave:{url:direccion+'../../../control/carta/ActionGuardarCartaRegistro.php'},
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:400,width:480,
		minWidth:150,minHeight:200,
		closable:true,titulo:'carta',
		grupos:[{
			tituloGrupo:'Carta',
			columna: 0,
			id_grupo:0
		},
		{	tituloGrupo:'Proveedor',
			columna:0,
			id_grupo:1
		},
		{	tituloGrupo:'Unidad Organizacional',
			columna:0,
			id_grupo:2
		},
		{	tituloGrupo:'Observaciones',
			columna:0,
			id_grupo:3
		}
				
	    ]
		}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_carta_docs(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_carta='+SelectionsRecord.data.id_carta;
			data=data+'&m_clase_carta='+SelectionsRecord.data.clase_carta;
			data=data+'&m_desc_cuenta_bancaria_inst='+SelectionsRecord.data.desc_cuenta_bancaria_inst;
			data=data+'&m_desc_proveedor='+SelectionsRecord.data.desc_proveedor;
			data=data+'&m_importe_carta='+SelectionsRecord.data.importe_carta;
			data=data+'&m_fecha_inicio='+SelectionsRecord.data.fecha_inicio;
			data=data+'&m_fecha_vence='+SelectionsRecord.data.fecha_vence;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_carta_amortizacion.loadWindows(direccion+'../../../../sis_tesoreria/vista/carta_docs/carta_docs.php?'+data,'Documentos por Carta',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
	txt_clase_carta=ClaseMadre_getComponente('clase_carta');
	txt_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
	txt_fecha_vence=ClaseMadre_getComponente('fecha_vence');

	var onClaseCartaSelect=function(e){
			var id=txt_clase_carta.getValue();
			if (id==1){
				CM_ocultarComponente(componentes[3]);
				CM_mostrarComponente(componentes[2]);
			}
		   else{
		     	CM_ocultarComponente(componentes[2]);
				CM_mostrarComponente(componentes[3]);
		    }
		};	
		txt_clase_carta.on('select',onClaseCartaSelect);
		//////////////////////////////////////////////////
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_carta_amortizacion.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_carta_amortizacion.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
		/////////////////////////////////////////////////////
	}
	
	this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_carta_amortizacion.getIdContentHijo()).pagina.reload(rec.data);			
				_CP.getPagina(layout_carta_amortizacion.getIdContentHijo()).pagina.desbloquearMenu()
			};
	
		
function InitPaginaCartaRegistro()
	{	for(var i=0; i<Atributos.length; i++)
		{	componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}
	
	this.btnNew=function(){
		CM_ocultarComponente(componentes[2]);
		CM_ocultarComponente(componentes[3]);
		CM_ocultarComponente(componentes[4]);
		CM_ocultarComponente(componentes[8]);
		CM_ocultarComponente(componentes[14]);
		CM_ocultarComponente(componentes[15]);
		btnNew();		
	}
	
	
	 this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.importe_pagado!=0){
				Ext.MessageBox.alert('...', 'El importe pagado es mayor a 0, nose puede Modificar.');
			}
			else{
				CM_ocultarComponente(componentes[4]);
				CM_ocultarComponente(componentes[8]);
				CM_ocultarComponente(componentes[14]);
				CM_ocultarComponente(componentes[15]);
				
				btnEdit(); 
			}
		 }
	
		 else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');	}
		
	 }	
	 
	  this.btnEliminar=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
			
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(SelectionsRecord.data.importe_pagado!=0){
			Ext.MessageBox.alert('...', 'El importe pagado es mayor a 0, nose puede Eliminar.');
			}
			else{
				btnEliminar(); 
			}
		 }
	
		 else
		{	Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');	}
		
	 }	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_carta_amortizacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			    start:0,
			    limit: paramConfig.TamanoPagina,
			    CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Documentos por Carta',btn_carta_docs,true,'carta_docs','');
	this.iniciaFormulario();
	InitPaginaCartaRegistro();
	iniciarEventosFormularios();
	layout_carta_amortizacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}