<?php 
/**
 * Nombre:		  	    caja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
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
var paramConfig={TamanoPagina:30,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_caja(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:					Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
 */
function pagina_caja(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja',totalRecords:'TotalCount'
		},[		
		'id_caja',
		'tipo_caja',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_moneda',
		'desc_moneda',
		'id_dosifica',
		'desc_dosifica',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_cierre',type:'date',dateFormat:'Y-m-d'},
		'sw_factura',
		'importe_maximo',
		'porcentaje_compra',
		'porcentaje_rinde',
		'nro_recibo',
		'estado_caja',
		'id_partida_cuenta',
		'desc_parcta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_fina_regi_prog_proy_acti',
		'epe',
		'id_depto',
		'nombre_depto',
		'codigo_caja',
		'id_usuario',
		'desc_usuario'
		]),remoteSort:true});

	//DATA STORE COMBOS
      
    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});
	//usuario
	var ds_usuario_responsable = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/usuario/ActionListarUsuario.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords: 'TotalCount'},['id_usuario','id_persona','desc_persona','estado_usuario','desc_usuario'])
	});

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

    var ds_dosifica = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/dosifica/ActionListarDosifica.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_dosifica',totalRecords: 'TotalCount'},['id_dosifica','fecha_vence','llave_activar','nro_autoriza','nro_inicial','nro_final','estado_dosifica'])
	});
    
	var ds_epe = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuarioSCI.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','id_financiador','codigo_financiador','nombre_financiador','id_regional','codigo_regional','nombre_regional','id_programa','codigo_programa','nombre_programa','id_proyecto','codigo_proyecto','nombre_proyecto','id_actividad','codigo_actividad','nombre_actividad','desc_epe'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_ep',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
	});
		
	var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarPartidaCuenta.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_debe','debe','id_haber','haber','id_recurso','recurso','id_gasto','gasto','sw_deha','sw_rega','id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida','desc_parcta','id_moneda','desc_moneda'])
	});
	
	var ds_auxiliar=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
		reader:new Ext.data.XmlReader({	record:'ROWS',id:'id_auxiliar',	totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});	
	
	//FUNCIONES RENDER
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
	
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b>{desc_usuario}</b>','<br><FONT COLOR="#B5A642"><b>Usuario: </b>{desc_usuario}</FONT>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_usuario}</FONT>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
	function render_id_dosifica(value, p, record){return String.format('{0}', record.data['desc_dosifica']);}
	var tpl_id_dosifica=new Ext.Template('<div class="search-item">','<b>{llave_activar}</b>','<br><FONT COLOR="#B5A642"><b>Fecha Vencimiento: </b>{fecha_vence}</FONT>','</div>');
	  
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');
	
	function render_id_partida_cuenta(value, p, record){return String.format('{0}', record.data['desc_parcta'])};
	var tpl_id_partida_cuenta=new Ext.Template('<div class="search-item">','<b>Partida: </b><FONT COLOR="#B5A642">{recurso}</FONT>','<FONT COLOR="#B5A642">{gasto}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{haber}</FONT>','<FONT COLOR="#B5A642">{debe}</FONT><br>','</div>');
	
	var resultTpl=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</i></b>','<b><br>Código: <i>{codigo_auxiliar}</i></b>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');	
	function render_auxiliar(value,p,record){return String.format('{0}',record.data['desc_auxiliar'])};
	
	function render_id_epe(value, p, record){rf = ds_epe.getById(value);if(rf!=null){record.data['id_fina_regi_prog_proy_acti'] =rf.data['id_fina_regi_prog_proy_acti'];record.data['epe'] =rf.data['desc_epe'];};return String.format('{0}',record.data['epe'])}	  
	var tpl_id_epe=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_financiador}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_regional}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_programa}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_proyecto}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_actividad}</FONT>','</div>');		  
	
	function render_tipo_caja(value){
		if(value==1){value='Caja' }
		if(value==2){value='Caja Chica' }
		if(value==3){value='Fondo Rotatorio' }
		
		return value
	}
	
	function render_sw_factura(value){
		if(value==1){value='Si' }
		if(value==2){value='No' }
		
		return value
	}
	
	function render_estado_caja(value){
		if(value==1){value='Abierto' }
		if(value==2){value='Cerrado' }
		
		return value
	}
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja',
			fieldLabel:'ID',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false,
			width_grid:60,
			grid_indice:1
		},
		tipo: 'Field',
		filtro_0:true,
		//form:false,
		save_as:'id_caja'
	};
	
	Atributos[1]={
		validacion:{
			name:'codigo_caja',
			fieldLabel:'Código Caja',
			allowBlank:true,
			maxLength:40,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:100,
			disabled:false,
			grid_indice:2					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'codigo_caja',
		id_grupo:0
	};
	
	Atributos[2]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo Caja',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.caja_combo.tipo_caja}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Caja'],['2','Caja Chica'],['3','Fondo Rotatorio']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_tipo_caja,
			grid_editable:false,
			forceSelection:true,
			width:300,
			grid_indice:3
		},
		tipo:'ComboBox',
		save_as:'tipo_caja',
		id_grupo:0
	};
		
	Atributos[3]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Tesorería',
			allowBlank:false,
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:300,
			disabled:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'DEP.nombre',
		save_as:'id_depto',
		id_grupo:0
	};
	
	Atributos[4]={
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
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
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
			width_grid:300,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
		id_grupo:0
	};
	
	Atributos[5]={
		validacion:{
			name:'id_fina_regi_prog_proy_acti',
			fieldLabel:'Estructura Programática',
			allowBlank:false,			
			emptyText:'Estructura Programàtica...',
			desc: 'epe', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_epe,
			valueField: 'id_fina_regi_prog_proy_acti',
			displayField: 'desc_epe',
			queryParam: 'filterValue_0',
			filterCol:'FRPPA.desc_epe#FRPPA.nombre_financiador#FRPPA.nombre_regional#FRPPA.nombre_programa#FRPPA.nombre_proyecto#FRPPA.nombre_actividad',
			typeAhead:false,
			tpl:tpl_id_epe,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:5,
			minListWidth:300,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_epe,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'epe',
		save_as:'id_fina_regi_prog_proy_acti'
	};

	Atributos[6]={
		validacion:{
			name:'sw_factura',
			fieldLabel:'Factura',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.caja_combo.sw_factura}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Si'],['2','No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_sw_factura,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'sw_factura',
		id_grupo:2
	};
	
	Atributos[7]={
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
			width_grid:80,
			width:150,
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
		id_grupo:1,
	};

	Atributos[8]={
		validacion:{
			name:'id_dosifica',
			fieldLabel:'Dosificación',
			allowBlank:false,			
			emptyText:'Dosificación...',
			desc: 'desc_dosifica', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_dosifica,
			valueField: 'id_dosifica',
			displayField: 'llave_activar',
			queryParam: 'filterValue_0',
			filterCol:'DOSIFI.llave_activar#DOSIFI.fecha_vence#DOSIFI.nro_autoriza',
			typeAhead:true,
			tpl:tpl_id_dosifica,
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
			renderer:render_id_dosifica,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'DOSIFI.llave_activar',
		save_as:'id_dosifica',
		id_grupo:2
	};
	
	Atributos[9]={
		validacion:{
			name:'importe_maximo',
			fieldLabel:'Importe Máximo',
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
		tipo:'NumberField',
		form:true,
		filtro_0:true,
		filterColValue:'CAJA.importe_maximo',
		save_as:'importe_maximo',
		id_grupo:1
	};
	
	Atributos[10]={
		validacion:{
			name:'porcentaje_compra',
			fieldLabel:'% Compra',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			minValue:0,
			maxValue:100,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_compra',
		save_as:'porcentaje_compra',
		id_grupo:1
	};

	Atributos[11]={
		validacion:{
			name:'porcentaje_rinde',
			fieldLabel:'% Rendicion',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			minValue:0,
			maxValue:100,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_rinde',
		save_as:'porcentaje_rinde',
		id_grupo:1
	};
	
	Atributos[12]={
		validacion:{
			fieldLabel:'Partida - Cuenta',
			allowBlank:false,
			emptyText:'Partida Cueta...',
			name:'id_partida_cuenta',
			desc:'desc_parcta',
			store:ds_partida_cuenta,
			valueField:'id_partida_cuenta',
			displayField:'desc_parcta',
			queryParam:'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta#PARTID.codigo_partida#PARTID.nombre_partida',
			tpl:tpl_id_partida_cuenta,
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_id_partida_cuenta,
			grid_visible:true,
			grid_editable:false,
			width:300,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		id_grupo:0,
		save_as:'id_partida_cuenta'
	};
	
	Atributos[13]={
		validacion:{
			fieldLabel:'Auxiliar de Cuenta',
			allowBlank:true,
			emptyText:'Auxiliar...',
			name:'id_auxiliar',
			desc:'desc_auxiliar',
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			tpl:resultTpl,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:250,
			grow:false,
			resizable:true,
			minChars:3,
			triggerAction:'all',
			renderer:render_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width:300,
			width_grid:400 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		id_grupo:0,
		save_as:'id_auxiliar'
	};
	
	Atributos[14]={
		validacion:{
			name:'estado_caja',
			fieldLabel:'Estado Caja',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.caja_combo.estado_caja}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Abierto'],['2','Cerrado']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			renderer:render_estado_caja,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'estado_caja',
		defecto:'2',
		id_grupo:2
	};
		
	Atributos[15]={
		validacion:{
			name:'id_usuario',
			fieldLabel:'Usuario Responsable',
			allowBlank:false,			
			emptyText:'Usuario Responsable...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario_responsable,
			valueField: 'id_usuario',
			displayField: 'desc_usuario',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre', // ver en la base de datos cmo
			typeAhead:true,
			tpl:tpl_id_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:300,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'id_usuario',
		id_grupo:2
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'caja',grid_maestro:'grid-'+idContenedor};
	var layout_caja=new DocsLayoutMaestro(idContenedor);
	layout_caja.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caja,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var btnNew=this.btnNew;
	var btnEdit=this.btnEdit;
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
	var enableSelect=this.EnableSelect;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja/ActionEliminarCaja.php'},
		Save:{url:direccion+'../../../control/caja/ActionGuardarCaja.php'},
		ConfirmSave:{url:direccion+'../../../control/caja/ActionGuardarCaja.php'},
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:500,width:480,
		minWidth:150,minHeight:200,
		closable:true,titulo:'caja',
		grupos:[{
			tituloGrupo:'Caja',
			columna: 0,
			id_grupo:0
		},
		{	tituloGrupo:'Importe',
			columna:0,
			id_grupo:1
		},
		{	tituloGrupo:'Emisión',
			columna:0,
			id_grupo:2
		}
				
	    ]
	}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_cajero(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
						
			var SelectionsRecord=sm.getSelected();
			var data='m_id_caja='+SelectionsRecord.data.id_caja;
			data=data+'&m_tipo_caja='+SelectionsRecord.data.tipo_caja;
			data=data+'&m_desc_unidad_organizacional='+SelectionsRecord.data.desc_unidad_organizacional;
			
			
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_caja.loadWindows(direccion+'../../../../sis_tesoreria/vista/cajero/cajero.php?'+data,'cajeros',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		txt_estado_caja=ClaseMadre_getComponente('estado_caja');
		txt_sw_factura=ClaseMadre_getComponente('sw_factura');
		txt_id_patcta=ClaseMadre_getComponente('id_partida_cuenta');
	
		var onEstadoSelect=function(e){
			var id=txt_sw_factura.getValue();
		};	
		txt_sw_factura.on('select',onEstadoSelect);
		txt_id_patcta.on('select',f_filtrar_auxiliar);
		
		function f_filtrar_auxiliar(combo,record,index){
			var var_id_cuenta ;
			if(record.data.id_debe==''){var_id_cuenta =record.data.id_haber}
			if(record.data.id_haber==''){var_id_cuenta =record.data.id_debe}
			componentes[13].setDisabled(false);
			componentes[13].store.baseParams={ sw_referencia_cuenta:'si',m_id_cuenta:var_id_cuenta  };
			componentes[13].modificado=true;
			componentes[7].setValue(record.data.id_moneda);
		}
	}
	
	function InitPaginaCaja(){
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}
	
	this.btnNew=function(){
		componentes[14].setDisabled(true);
		componentes[14].setValue('2');
		componentes[13].setDisabled(true);
		componentes[15].setDisabled(true);
		btnNew();
	}
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		componentes[13].setDisabled(true);	
		componentes[15].setDisabled(true);	
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			if(componentes[14].getValue()=='2'){
				btnEdit();
			}else{
				Ext.MessageBox.alert('...', 'El estado de la Caja esta ABIERTO y no se puede modificar.');		
			}
		}else{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}	
					
	this.EnableSelect=function(x,z,y){
		enable(x,z,y)
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caja.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','cajeros',btn_cajero,true,'cajeros','Cajeros');
	var CM_getBoton=this.getBoton;
	function  enable(sel,row,selected){
		var record=selected.data;
		
		if(selected&&record!=-1){
			if (record.estado_caja==2){
				//CM_getBoton('cajeros-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('guardar-'+idContenedor).enable();
			}else{
				//CM_getBoton('cajeros-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('guardar-'+idContenedor).disable();
			}
		}
		enableSelect(sel,row,selected);
	}
	
	this.iniciaFormulario();
	InitPaginaCaja();
	iniciarEventosFormularios();
	layout_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}