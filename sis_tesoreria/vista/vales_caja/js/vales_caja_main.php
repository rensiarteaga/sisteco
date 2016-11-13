<?php 
/**
 * Nombre:		  	    vales_caja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-22 10:36:48
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
var elemento={pagina:new pagina_vales_caja(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_vales_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-22 10:36:48
 */
function pagina_vales_caja(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var reporte=0;//1 es vale, 2 es rendición o otro vale depende del caso
	var id_vale,id_cotizacion,tipo_vale;
	var datas_edit;
	var dialogo;
	var g_sw_contabilizar;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarValesCaja.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_regis',totalRecords:'TotalCount'
		},[		
		'id_caja_regis',
		'id_caja',
		'nombre_moneda',
		'tipo_caja',
		'desc_caja',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'estado_cajero_cajero',
		'desc_cajero',
		'id_empleado',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_empleado',
		'importe_regis',
		{name: 'fecha_regis',type:'date',dateFormat:'Y-m-d'},
		'nombre_unidad',
		'estado_regis',
		'id_subsistema',
		'desc_persona',
		'concepto_regis',
		'id_cotizacion',
		'sw_contabilizar',
		'nombre_depto',
		'id_depto',
		'nro_vale',
		'id_devengado',
		'id_proveedor',
		'tipo_vale'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

     var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	});

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});
    var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?unidad=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','codigo_empleado'])
	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','desc_ep'])
		});
		
		
	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_proveedor',totalRecords:'TotalCount'},['id_proveedor','codigo','observaciones','fecha_reg','usuario','contrasena','confirmado','id_persona','id_institucion','nombre_proveedor','direccion_proveedor','mail_proveedor','telefono1_proveedor','telefono2_proveedor','fax_proveedor'])
		});

	//FUNCIONES RENDER
		
		function render_id_caja(value, p, record){
			if(record.get('estado_id_subsistema')!=12)
			{
				return '<span style="color:blue;font-size:8pt">' + record.data['desc_caja']+ '</span>';
			}
			else if((record.get('concepto_regis')).substring(0,7)=='viatico') 
			{
				return  '<span style="color:brown;font-size:8pt">' + record.data['desc_caja']+ '</span>';
			} 
			else
			{ 
				return record.data['desc_caja'];
			}
	
		}
		function render_id_caja(value, p, record){if(record.get('id_subsistema')!=12){return String.format('{0}', '<span style="color:blue;font-size:8pt">'+record.data['desc_caja']+ '</span>');}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+record.data['desc_caja']+ '</span>');}else{return String.format('{0}', record.data['desc_caja']);}}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');

		function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
		var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b><i>{desc_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

	function renderTipo(value, p, record){	//solo registros diferentes de tesoreria
		if(value == 1){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Caja"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Caja"+ '</span>');} else{return "Caja"}}
		if(value == 2){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Caja Chica"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Caja Chica"+ '</span>');} else{return "Caja Chica"}}
		if(value == 3){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Fondo Rotatorio"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Fondo Rotatorio"+ '</span>');} else{return "Fondo Rotatorio"}}
		
	}	
	
	function render_id_depto(value, p, record){
		if(record.get('id_subsistema')!=12)
		{
			return '<span style="color:blue;font-size:8pt">' + record.data['nombre_depto']+ '</span>';
		}
		else if((record.get('concepto_regis')).substring(0,7)=='viatico') 
		{
			return  '<span style="color:brown;font-size:8pt">' + record.data['nombre_depto']+ '</span>';
		} 
		else
		{ 
			return record.data['nombre_depto'];
		}
	
	}
	
	
	
		var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','{nombre_depto}','</div>');

	
	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_proveedor=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	
	
	function renderEstado(value, p, record){
		if(value == 0){return "Reposición"}
		if(value == 1){return "Pendiente"}
		if(value == 2){return "Rendición"}
		if(value == 3){return "3"}
		if(value == 4){return "Comprometido"}
		if(value == 5){return "Contabilizado"}
		if(value == 6){return "Validado"}		
	}
	
	
	
	
	function negrita(val,cell,record,row,colum,store){
						
			
			if(dias>dias_min && dias<=dias_max && record.get('estado')!='borrador' && record.get('estado')!='anulado' && record.get('estado')!='finalizado'){
								
				
				return '<span style="color:orange;font-size:8pt">' + val + '</span>';
				
			}
			else if(dias>dias_max  && record.get('estado')!='borrador' && record.get('estado')!='anulado' && record.get('estado')!='finalizado'){
				return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else
			{
				return val;
			}
		}		
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_regis'
	};
	
	Atributos[1]={
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
				queryDelay:250,
				pageSize:100,
				minListWidth:'80%',
				
				onSelect:function(record){
				
				
				componentes[1].setValue(record.data.id_depto);
				componentes[1].collapse();
				componentes[2].clearValue();
				ds_caja.baseParams.m_id_depto=record.data.id_depto;
				componentes[2].modificado=true							
			},
				
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
				width:'80%',
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'depto.nombre_depto',
			save_as:'id_depto',
			id_grupo:1
		};
	
	
// txt id_caja
	Atributos[2]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			onSelect:function(record){
				
				
				componentes[2].setValue(record.data.id_caja);
				componentes[2].collapse();
				componentes[3].clearValue();
				ds_cajero.baseParams.m_id_caja=record.data.id_caja;
				componentes[3].modificado=true							
			},
			
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad',
		save_as:'id_caja',
			id_grupo:1
	};
// txt id_cajero
	Atributos[3]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			emptyText:'Cajero...',
			desc: 'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_cajero,
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
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:1
	};
// txt id_empleado
	Atributos[4]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:true,
			tpl:tpl_id_empleado,
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
			renderer:render_id_empleado,
			grid_visible:false,
			width:'100%',
			disabled:false	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_empleado',
		id_grupo:2
	};
	
	// txt id_empleado
	Atributos[5]={
			validacion:{
			name:'id_proveedor',
			fieldLabel:'A Orden De',
			allowBlank:true,			
			emptyText:'Proveedor...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proveedor,
			valueField: 'id_proveedor',
			displayField: 'nombre_proveedor',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#INSTIT.nombre',
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
			grid_visible:false,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		save_as:'id_proveedor',
		id_grupo:2
	};
	
// txt importe_regis
	Atributos[6]={
		validacion:{
			name:'importe_regis',
			fieldLabel:'Importe Registro',
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
			width:'100%',
			disabled:false,
			grid_indice:6		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.importe_regis',
		save_as:'importe_regis',
		id_grupo:2	
	};
// txt fecha_regis
	Atributos[7]= {
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:7		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_regis',
		dateFormat:'m-d-Y'
	};
// txt nombre_unidad
	Atributos[8]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	// txt nombre_unidad
	Atributos[9]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo de Caja',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:1,
			renderer:renderTipo		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false
	};
	
	// txt nombre_unidad
	Atributos[10]={
		validacion:{
			name:'estado_regis',
			fieldLabel:'Estado Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5,
			renderer:renderEstado	
		},
		tipo: 'TextField',
		form: false
		
	};
	Atributos[11]={
		validacion:{
			labelSeparator:'',
			name: 'estado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'estado_regis'
	};
	
	// txt fecha_regis
	Atributos[12]= {
		validacion:{
			name:'importe_entregado',
			fieldLabel:'Importe Entregado',
			grid_visible:false,
			grid_editable:false,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			width_grid:85,
			grid_indice:7		
		},
		form:true,
		tipo:'NumberField',
		filtro_0:false,
		id_grupo:3
	};
	
	// txt nombre_unidad
	Atributos[13]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Concepto Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis',
		id_grupo:2		
	};
	
	Atributos[14]={
		validacion:{
			name:'sw_contabilizar',
			fieldLabel:'Contabilizar',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo: 'NumberField',
		form: false,
		save_as:'sw_contabilizar'
	};
	
	Atributos[15]={
		validacion:{
			labelSeparator:'',
			name: 'id_susbsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_subsistema'
	};
	
	// txt fecha_regis
	Atributos[16]= {
		validacion:{
			name:'nro_vale',
			fieldLabel:'Nro',
			grid_visible:true,
			grid_editable:false,
			allowDecimals:false,
			width_grid:50,
			grid_indice:1		
		},
		form:false,
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CAJREG.nro_documento'	
	};
	
	 Atributos[17]={//==> se usa//30
			validacion: {
			name:'tipo_vale',
			fieldLabel:'Tipo de Vale',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['provisorio','A nombre de Empleado'],['pago','A nombre de Proveedor']]}),
			valueField:'ID',
			displayField:'valor',
			onSelect:function(record){
				
				CM_getComponente('tipo_vale').setValue(record.data.ID);
				CM_getComponente('tipo_vale').collapse();
				if(CM_getComponente('tipo_vale').getValue()=='provisorio'){//es para el empleado
				
					cm_mostrarComponente(componentes[4]);
					cm_ocultarComponente(componentes[5]);
					cm_mostrarComponente(componentes[6]);
					componentes[5].allowBlank=true;	
					componentes[4].allowBlank=false;
					componentes[5].reset();
					
					
				}
				else{
					cm_ocultarComponente(componentes[4]);
					cm_mostrarComponente(componentes[5]);
					cm_ocultarComponente(componentes[6]);
					componentes[5].allowBlank=false;	
				    componentes[4].allowBlank=true;
				    componentes[6].allowBlank=true;
				    componentes[4].reset();
				    componentes[6].reset();
				    
				}
						
			},
			forceSelection:true,
			grid_visible:true,
			grid_indice:2,
			grid_editable:false,
			align:'center',
			width:180,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		defecto:'provisorio',
		id_grupo:1
	};
	
	Atributos[18]={
		validacion:{
			name:'desc_empleado',
			fieldLabel:'A nombre de',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis'		
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vales de Caja',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/vales_caja/rendiciones_det.php'};
	var layout_vales_caja=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_vales_caja.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_vales_caja,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	var getGrid=this.getGrid;
	var CM_Save=this.Save;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var cm_btnNew=this.btnNew;
	var cm_btnEdit=this.btnEdit;
	var cm_ocultarTodosComponente=this.ocultarTodosComponente;
	var cm_mostrarTodosComponente=this.motrarTodosComponente;
	var cm_mostrarComponente=this.mostrarComponente;
	var cm_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_saveSuccess=this.saveSuccess;
	var CM_getDailog=this.getDialog;
	
	
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
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
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarValesCaja.php'},
		Save:{url:direccion+'../../../control/caja_regis/ActionGuardarValesCaja.php',
		success:miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarValesCaja.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,
		
			grupos:[
			{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Vale',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Importe Entregado',
				columna:0,
				id_grupo:3
			}
			],width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Vales de Caja'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{		
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		dialogo=CM_getDailog();
		//para iniciar eventos en el formulario
	
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.desbloquearMenu()
					}
		})
		
	}
	
		
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
				datas_edit=rec.data;
				enable(sm,row,rec);
				_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.reload(rec.data);
				
					
	}	
	
	
	function miFuncionSuccess(resp)
	{		
		if(reporte==1)
		{	
			
			var data = "id_caja_regis=" +id_vale;
			window.open(direccion+'../../../control/caja_regis/Reportes/ActionReporteValeCaja.php?'+data)
			CM_saveSuccess(resp);
		}
		else if(reporte==2)
		{	
								   
			var data = "id_caja_regis=" + id_vale;

			if(tipo_vale=='provisorio')		
			{		
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReporteRendicion.php?'+data);
			}
			else
			{
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReportePago.php?'+data);				
			}
				id_cotizacion='';
				CM_saveSuccess(resp);			
		}
		else
		{
			
			CM_saveSuccess(resp);
		}
		reporte=0;
		componentes[1].allowBlank=false;
	}
	
		
	function btnProvisional(){
		var sm=getSelectionModel();
		id_vale =sm.getSelected().data.id_caja_regis;
		var data = "id_caja_regis=" +id_vale+'&tipo=1';
		//alert(sm.getSelected().data.tipo_vale); 
		if(sm.getSelected().data.tipo_vale=='provisorio')		
			{		
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReporteRendicion.php?'+data);
			}
			else{
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReportePago.php?'+data);				
			}		
	}
			
			
	function btn_reporte_vale()
	{
		var sm=getSelectionModel();
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
				
				id_vale =sm.getSelected().data.id_caja_regis;
				reporte=1;
				componentes[11].setValue('2');
				componentes[1].allowBlank=true;
				componentes[5].allowBlank=true;	
				componentes[4].allowBlank=true;
				componentes[6].allowBlank=true;
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Datos Generales');
			    CM_ocultarGrupo('Datos Vale');
			    CM_mostrarGrupo('Importe Entregado');
			    componentes[12].setValue(componentes[6].getValue());
				cm_btnEdit();
				dialogo.buttons[0].enable();
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un Vale.')
		}	
		
	}
	
	this.btnNew=function(){
		validar_campos();
		cm_btnNew();
	}
	
	
	function validar_campos(){
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Importe Entregado');
		CM_mostrarGrupo('Datos Generales');
	    CM_mostrarGrupo('Datos Vale');
		
		if(NumSelect==1)
		{			
			if(SelectionsRecord.data.id_proveedor=='' || SelectionsRecord.data.id_proveedor==undefined){//es para el empleado
				
				cm_ocultarComponente(componentes[5]);
				componentes[5].allowBlank=true;	
				componentes[4].allowBlank=false;
				componentes[6].allowBlank=false;
				
				
			}
			else{
				
				cm_ocultarComponente(componentes[4]);
				cm_ocultarComponente(componentes[6]);
				componentes[5].allowBlank=false;	
			    componentes[4].allowBlank=true;
			    componentes[6].allowBlank=true;
			}
			
		}
		else
		{
			componentes[4].allowBlank=false;
			componentes[6].allowBlank=false;
			cm_mostrarComponente(componentes[4]);
			cm_ocultarComponente(componentes[5]);
			cm_mostrarComponente(componentes[6]);
			
		}
		
		
	}
	
	
	
	function btn_fin_vale()
	{
		reporte=2
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
				var sm=getSelectionModel();
				id_vale =sm.getSelected().data.id_caja_regis;
				id_cotizacion =sm.getSelected().data.id_cotizacion;
				tipo_vale=sm.getSelected().data.tipo_vale;
				Ext.Ajax.request({
					url:direccion+"../../../control/caja_regis/ActionVerificarRendicionVale.php",
					success:cargar_respuesta,
					params:{'id_caja_regis':sm.getSelected().data.id_caja_regis},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un Vale.')
		}		
	}
	
		
	function cargar_respuesta(resp){
		
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			var mensaje='¿Está seguro de comprometer el importe de la rendición del vale?';
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1')
			{
				mensaje='La rendición del vale excede con ' + root.getElementsByTagName('monto')[0].firstChild.nodeValue + ' el valor del mismo. Se generará otro vale por el valor indicado. ¿Desea Continuar?';
			}
			else 
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='-1')
			{
				mensaje='La rendición del vale no completa el valor del mismo. Se generará una reposición por ' + root.getElementsByTagName('monto')[0].firstChild.nodeValue + ' . ¿Desea Continuar?';
			}
			else
			{
				mensaje='¿Esta seguro de comprometer el importe de la rendición del vale?';
			}
			
			if(confirm(mensaje))
			{
				componentes[11].setValue('4');
				CM_Save();
			}						
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_vales_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	
	var CM_getBoton=this.getBoton;
	
	
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
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Recibo',btn_reporte_vale,true,'reporte_vale','Recibo Provisional');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Editar Rendición',btn_editar_rendicion,true,'todos','Editar Rendición');
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Mostrar Todos los Registros',btn_todos,true,'todos','Mostrar Todos');
	this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Rendición',btn_fin_vale,true,'fin_vale','Finalizar Rendición');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Vista Previa',btnProvisional,true,'provisional','Vista Previa'); //tucrem
	
    
	
    
    //var CM_getBoton=this.getBoton;
	function enable(sm,row,rec){
		
		cm_EnableSelect(sm,row,rec);
		texto = rec.data['concepto_regis'].substring(0,7);
		if(rec.data['estado_regis']!=1){
					
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					CM_getBoton('provisional-'+idContenedor).enable();
					
				}
				else{
					CM_getBoton('editar-'+idContenedor).enable();
					CM_getBoton('eliminar-'+idContenedor).enable();
					CM_getBoton('provisional-'+idContenedor).disable();
					
				}
		if(rec.data['estado_regis']==2)
		{
			CM_getBoton('reporte_vale-'+idContenedor).disable();
			CM_getBoton('fin_vale-'+idContenedor).enable();
		}
		else
		{
			CM_getBoton('reporte_vale-'+idContenedor).enable();
			CM_getBoton('fin_vale-'+idContenedor).disable();
		}		
	}
	
	ds_cajero.baseParams.estado=3;
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_vales_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}