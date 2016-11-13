<?php
/**
 * Nombre:		  	    cuenta_doc_rendicion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				RCM
 * Fecha creación:		29/10/2009
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
	echo "var vista='$vista';";
	?>
	var fa=false;

	<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	//var maestro={
	//	id_cuenta_doc:<?php echo $m_id_cuenta_doc;?>};
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	//var elemento={idContenedor:idContenedor,pagina:new pagina_cuenta_doc_rendicion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	var elemento={idContenedor:idContenedor,pagina:new pagina_cuenta_doc_rendicion(idContenedor,direccion,paramConfig,idContenedorPadre,vista)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
* Nombre:		  	    pagina_cuenta_doc_rendicion.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				RCM
* Fecha creaciï¿½n:		29/10/2009
*/


function pagina_cuenta_doc_rendicion(idContenedor,direccion,paramConfig,idContenedorPadre,vista)
{
	var Atributos=new Array,sw=0;
	var maestro;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'valor',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000}	
	);
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_rendicion/ActionListarCuentaDocRendicion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cuenta_doc_rendicion',totalRecords:'TotalCount'
		},[
		'id_cuenta_doc_rendicion',
		'id_cuenta_doc',
		'id_documento',
		'fecha_reg',
		'id_transaccion',
		'tipo_documento',
		'nro_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'d/m/Y'},
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'codigo_control',
		'poliza_dui',
		'formulario',
		'tipo_retencion',
		'estado_documento',
		'id_documento_valor',
		'importe_total',
		'importe_total_ren',
		'importe_ice',
		'importe_exento',
		'importe_sujeto',
		'importe_credito',
		'importe_iue',
		'importe_it',
		'importe_debito',
		'desc_tipo_documento',
		'id_moneda',
		'desc_moneda',
		'importe_rendicion',
		'id_presupuesto',
		'desc_presupuesto',
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'id_orden_trabajo',
		'desc_orden_trabajo',
		'estado',
		'id_partida',
		'desc_partida',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'sw_viatico',
		'importe_retencion'
	]),remoteSort:true});

	///////////////////////
	// Definicion de datos //
	/////////////////////////
		
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
																								'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
																								'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																								'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																								])//,
	//baseParams:{m_nombre_vista:'rendicion_viaticos',m_id_uo:1,sw_inv_gasto:'si'}
	});
			
	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php?sw_tesoro=1'}),   //para filtrar solo los conceptos de viaticos sw_tesoro=3
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv','desc_cuenta','desc_auxiliar' ])
	});
	
	var ds_orden_trabajo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario','desc_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona' ])
	});
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });	
	
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
			['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','desc_cta2']) });
		  
 	var ds_auxiliar=new Ext.data.Store({	proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},
		['id_cuenta_auxiliar','id_cuenta','nombre_cuenta','id_auxiliar','nombre_auxiliar','codigo_auxiliar']),remoteSort:true});	
	
	
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">',
		'<b>{desc_ingas_item_serv}</b><br>',
		'    Partida: <FONT COLOR="#B5A642">{desc_partida}</FONT>',
		'<br>Cuenta:  <FONT COLOR="#B5A642">{desc_cuenta}</FONT>',
		'<br>Auxiliar:  <FONT COLOR="#B5A642">{desc_auxiliar}</FONT>',
		'</div>');

	function render_tipo_documento(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	//var tpl_tipo_documento=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

			
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}				
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
		'</div>');
		
	function render_id_orden_trabajo(value, p, record){return String.format('{0}', record.data['desc_orden_trabajo']);}
	var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
	
	function negrita(val,cell,record,row,colum,store){
		if(record.get('estado')=='en_rendicion'||record.get['estado']=='en_conta'){
			return '<span style="color:red;font-size:8pt">' + val + '</span>';
		}else if(record.get('estado')=='compro'){
			return '<span style="color:blue;font-size:8pt">' + val + '</span>';
		}else{
			return val;
		}
	}	
	
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','{desc_par}<br>','</div>');

	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','{nombre_cuenta}<br>','</div>');

	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','{nombre_auxiliar}<br>','</div>');

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}	

	// hidden id_cotizacion_det
	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_rendicion',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			grid_indice:0
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:1
	};

	Atributos[1]={
		validacion:{
			name:'id_cuenta_doc',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		id_grupo:1			
	};

	Atributos[2]={
		validacion:{
			fieldLabel:'Fecha Registro',
			name:'fecha_reg',
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:90,
			grid_indice:18
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};

	Atributos[3]={
		validacion:{
			fieldLabel:'Id.Documento',
			name:'id_documento',
			grid_visible:false,
			grid_editable:false,
			width:300
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};

	Atributos[4]={
		validacion:{
			fieldLabel:'Tipo Documento',
			name:'desc_tipo_documento',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			grid_indice:2,
			renderer:negrita
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};

	Atributos[5]={
		validacion:{
			fieldLabel:'Importe Total Doc',
			name:'importe_total',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:10,
			align:'right', 
			renderer: render_total
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};

	Atributos[6]={
		validacion:{
			fieldLabel:'Moneda',
			name:'desc_moneda',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			grid_indice:8
		},
		tipo:'Field',
		form:false,
		id_grupo:2
	};

	Atributos[7]={
		validacion:{
			fieldLabel:'No.Documento',
			name:'nro_documento',
			grid_visible:true,
			grid_editable:true,
			allowDecimals:false,
			allowNegative:false,
			width:300,
			grid_indice:4
		},
		tipo:'NumberField',
		form:false,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento'
	};

	Atributos[8]={
		validacion:{
			fieldLabel:'Fecha Documento',
			name:'fecha_documento',
			grid_visible:true,
			align:'center',
			grid_editable:true,
			width_grid:110,
			grid_indice:1,
			renderer: formatDate
		},
		tipo:'DateField',
		form:true,
		dateFormat:'m-d-Y',
		id_grupo:1
	};

	Atributos[9]={
		validacion:{
			fieldLabel:'Razón Social',
			name:'razon_social',
			grid_visible:true,
			grid_editable:true,
			allowDecimals:false,
			allowNegative:false,
			width_grid:200,
			grid_indice:3,
			renderer:negrita
		},
		tipo:'TextField',
		form:false,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social'
		
	};

	Atributos[10]={
		validacion:{
			fieldLabel:'NIT',
			name:'nro_nit',
			grid_visible:true,
			allowDecimals:false,
			allowNegative:false,
			grid_editable:true,
			width:300,
			grid_indice:5
		},
		tipo:'NumberField',
		form:false,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit'
	};

	Atributos[11]={
		validacion:{
			fieldLabel:'Autorización',
			name:'nro_autorizacion',
			grid_visible:true,
			grid_editable:true,
			width:300,
			grid_indice:6
		},
		tipo:'TextField',
		form:false,
		id_grupo:1,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion'
	};

	Atributos[12]={
		validacion:{
			fieldLabel:'Código Control',
			name:'codigo_control',
			grid_visible:true,
			grid_editable:true,
			width:300,
			grid_indice:7
		},
		tipo:'TextField',
		form:false,
		id_grupo:1
		
	};

	Atributos[13]={
		validacion:{
			fieldLabel:'Estado Documento',
			name:'estado_documento',
			grid_visible:false,
			grid_editable:false,
			width_grid:150
		},
		tipo:'Field',
		form:false,
		id_grupo:1			
	};

	Atributos[14]={
		validacion:{
			fieldLabel:'Importe IT',
			name:'importe_it',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width:300,
			width_grid:100,
			grid_indice:14
		},
		tipo:'Field',
		form:false,
		id_grupo:1			
	};
	
	Atributos[15]={
		validacion:{
			fieldLabel:'Importe Líquido', //Importe guardado en la Rendicion
			name:'importe_rendicion',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:12
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
			
		//combo presupuesto	
     Atributos[16]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,				
			desc: 'desc_presupuesto', //columna del ds_store principal del que proviene la descripcion //que es lo que se muestra en la grilla
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',	//que es lo que se muestra en el formulario
			queryParam: 'filterValue_0',
			filterCol: 'PRESUP.nombre_unidad#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad', //con estos campos filtramos en el formulario
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:50,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:250,
			disabled:false,
			grid_indice:19		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',// cone estos campos filtramos en la grilla
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	// txt id_concepto_ingas
	Atributos[17]={
		validacion:{
			name:'desc_concepto_ingas',
			fieldLabel:'Concepto',
			renderer:negrita,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:1	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas_item_serv',
		save_as:'id_concepto_ingas',
		id_grupo:0
	};	
	
	Atributos[18]={
		validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo',
			allowBlank:true,
			desc: 'desc_orden_trabajo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_orden_trabajo,
			valueField: 'id_orden_trabajo',
			displayField: 'desc_orden',
			queryParam: 'filterValue_0',
			filterCol:'ORDTRA.desc_orden#ORDTRA.motivo_orden',
			typeAhead:false,
			tpl:tpl_id_orden_trabajo,
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
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:300,
			disabled:false,
			grid_indice:21		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'ORDTRA.desc_orden_trabajo',
		id_grupo:0
	};	
	
	Atributos[19]={
		validacion:{
			fieldLabel:'Importe ICE',
			name:'importe_ice',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:16
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
			
	Atributos[20]={
		validacion:{
			fieldLabel:'Importe Exento',
			name:'importe_exento',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:17
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
			
	Atributos[21]={
		validacion:{
			fieldLabel:'Importe Crédito',
			name:'importe_credito',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:13
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
			
	Atributos[22]={
		validacion:{
			fieldLabel:'Importe IUE',
			name:'importe_iue',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:15
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};
	
	Atributos[23]={
		validacion:{
			fieldLabel:'Importe Sujeto',
			name:'importe_sujeto',
			grid_visible:true,
			grid_editable:false,
			align:'right', 
			renderer: render_total,
			width_grid:100,
			grid_indice:11
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};		
			
	Atributos[24]={
		validacion:{
			fieldLabel:'Importe Total Ren',
			name:'importe_total_ren',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:10,
			align:'right', 
			renderer: render_total
		},
		tipo:'Field',
		form:false,
		id_grupo:1
	};	
		
	Atributos[25]={
		validacion:{
			name:'id_partida',
			fieldLabel:'Partida Presupuestaria',
			allowBlank:true,
			desc: 'desc_partida', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_partida',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			tpl:tpl_id_partida,
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
			renderer:render_id_partida,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		id_grupo:0
	};
		
	Atributos[26]={
		validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta Contable',
			allowBlank:true,
			desc: 'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cuenta',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			typeAhead:false,
			tpl:tpl_id_cuenta,
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
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
		id_grupo:0
	};
	
	Atributos[27]={
		validacion:{
			name:'id_auxiliar',
			fieldLabel:'Auxiliar Contable',
			allowBlank:true,
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'desc_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			tpl:tpl_id_orden_trabajo,
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
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
		id_grupo:0
	};

	if(vista=='rendicion_rendido'||vista=='rendicion_recibo'){
		Atributos[28]={
			validacion:{
				fieldLabel:'Estado',
				name:'estado',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:13
			},
			tipo:'Field',
			form:false
		};		
	
	}else if(vista=='rendicion_viatico'){
		Atributos[28]= {
			validacion:{
				name:'fecha_ini',
				fieldLabel:'Fecha Inicio',
				format:'d/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				grid_indice:13
			},
			tipo:'DateField',
			dateFormat:'m-d-Y',
			form:true,
			defecto:'',
			save_as:'fecha_ini'
		};
		
		Atributos[29]= {
			validacion:{
				name:'fecha_fin',
				fieldLabel:'Fecha Fin',
				format:'d/m/Y', //formato para validacion
				grid_visible:true,
				grid_editable:true,
				renderer: formatDate,
				grid_indice:13
			},
			tipo:'DateField',
			dateFormat:'m-d-Y',
			form:true,
			defecto:'',
			save_as:'fecha_fin'
		};
		// importe retener
		Atributos[30]={
			validacion:{
				name:'importe_retencion',
				fieldLabel:'RC-IVA',
				allowBlank:false,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:true,
				vtype:'texto',
				align:'right', 
				renderer: render_total,
				grid_indice:9
			},
			tipo:'NumberField',
			save_as:'importe_retencion'
		};
	}
		
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Facturas/Recibos',grid_maestro:'grid-'+idContenedor};
	var layout= new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	var enableSelect=this.EnableSelect;
	var CM_btnAct=this.btnActualizar;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	
	if(vista=='rendicion_rendido'){
		var paramMenu={
			guardar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
	}else{
		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
	}
	//DEFINICION DE FUNCIONES

	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionEliminarCuentaDocRendicion.php'},
			Save:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionGuardarCuentaDocRendicion.php'},
			ConfirmSave:{url:direccion+'../../../control/cuenta_doc_rendicion/ActionGuardarCuentaDocRendicion.php'},
			Formulario:{
				html_apply:'dlgInfo-'+idContenedor,
				height:280,columnas:['80%'],
				grupos:[
				{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Documento',columna:0,id_grupo:1},
				{tituloGrupo:'Oculto',columna:0,id_grupo:2}],
				width:'50%',
				minWidth:120,
				minHeight:170,	
				closable:true,
				titulo:'Documentos (Facturas/Recibos)'}
	};

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cuenta_doc:maestro.id_cuenta_doc					
			}
		};
			
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_cuenta_doc;
		
		paramFunciones.btnEliminar.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.Save.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;
		paramFunciones.ConfirmSave.parametros='&m_id_cuenta_doc='+maestro.id_cuenta_doc;
		if(maestro.solo_lectura==0){
			CM_getBoton('guardar-'+idContenedor).enable();
		}
		if(maestro.solo_lectura==3){
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('gastos-'+idContenedor).enable();
		}
		
		this.InitFunciones(paramFunciones)
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	}
	
	this.btnNew=function(){			
		//var SelectionsRecord=sm.getSelected();
		CM_mostrarGrupo('Datos Generales');
		CM_mostrarGrupo('Datos Documento');
		CM_ocultarGrupo('Oculto');
		
		//console.log(maestro);
		data='m_nombre_tabla=tesoro.tts_cuenta_doc_rendicion';
		data=data+'&m_nombre_campo=id_cuenta_doc';
		data=data+'&m_id_tabla='+maestro.id_cuenta_doc;	//enviamos el id del padre para insertar
		data=data+'&m_id_moneda='+maestro.id_moneda;						
		
		data=data+'&m_id_documento=0';
		data=data+'&m_importe='+maestro.importe;
		data=data+'&m_nuevo=si';			
		data=data+'&m_razon_social=';
		data=data+'&m_tipo_doc_fijo=no';			
		data=data+'&m_compro='+maestro.tipo_cuenta_doc;
		
		//data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
		data=data+'&m_desc_moneda='+maestro.desc_moneda;
		
		data=data+'&m_id_presupuesto='+maestro.id_presupuesto;
		data=data+'&m_desc_presupuesto='+maestro.desc_presupuesto;	
		
		data=data+'&m_id_parametro='+maestro.id_parametro;
		data=data+'&m_desc_parametro='+maestro.desc_parametro;		
							
		//Llama la ventana de registro de documentos
		var ParamVentana={Ventana:{width:950,height:450}};
		layout.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana);
	}

	this.btnEdit=function(){
		CM_ocultarGrupo('Datos Generales');
		CM_mostrarGrupo('Datos Documento');
		CM_ocultarGrupo('Oculto');
		
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_nombre_tabla=tesoro.tts_cuenta_doc_rendicion';
			data=data+'&m_nombre_campo=id_cuenta_doc_rendicion';
			data=data+'&m_id_tabla='+SelectionsRecord.data.id_cuenta_doc_rendicion;	//enviamos el id de la rendicion para editar
			data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
			data=data+'&m_id_documento='+SelectionsRecord.data.id_documento;
			data=data+'&m_importe='+SelectionsRecord.data.importe_total_ren;
			data=data+'&m_nit='+maestro.nit;
			data=data+'&m_razon_social=';
			data=data+'&m_tipo_doc_fijo=no';
			data=data+'&m_tipo_documento=-1';
			data=data+'&m_sw_viatico='+SelectionsRecord.data.sw_viatico;
			//data=data+'&m_compro=ts';
			data=data+'&m_compro='+maestro.tipo_cuenta_doc;

			var ParamVentana={Ventana:{width:950,height:450}};
			layout.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento/documento.php?'+data,'Documentos',ParamVentana)
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}

	this.btnEliminar=function(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){
			var id_documento=sm.getSelected().data.id_documento;
			if(id_documento!=undefined&&id_documento!=''){
				//alert('id_documento:'+id_documento);
				data='id_documento='+id_documento+'&nombre_tabla=tesoro.tts_cuenta_doc_rendicion&nombre_campo=id_cuenta_doc_rendicion&id_tabla='+sm.getSelected().data.id_cuenta_doc_rendicion;
				if(confirm('¿Está seguro de eliminar el Documento?')){
					Ext.Ajax.request({
						url:direccion+'../../../../sis_contabilidad/control/documento/ActionEliminarDocumento.php?'+data,
						method:'GET',
						success:exito_doc_del,
						failure:CM_conexionFailure,
						timeout:100000
					})}
			}else{
				Ext.MessageBox.alert('Estado','Documento inexistente')
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.')
		}
	}

	function exito_doc_del(resp){
		Ext.MessageBox.hide();
		Ext.MessageBox.alert('Estado','Documento eliminado');
		CM_btnAct()
	}

	this.EnableSelect=function(x,z,y){
		enable(x,z,y)
	}
	
	function bloquearBotones(){
		if(vista!='rendicion_rendido'){
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('gastos-'+idContenedor).disable();
			CM_getBoton('imp_recibo_pago-'+idContenedor).disable();	
		}
		if(vista!='rendicion_viatico' && vista!='rendicion_avance')
			CM_getBoton('marcar/desmarcar-'+idContenedor).disable();
	}
	
	//Evento al Seleccionar una fila
	function enable(sel,row,selected){
		bloquearBotones();
		
		//Habilita o deshabilita los botones dependiendo del tipo de la vista
		var record=selected.data;
		if (vista=='rendicion_viatico'){
			CM_getBoton('imp_recibo_pago-'+idContenedor).enable();
		}
		
		if(selected&&record!=-1){
			if(vista!='rendicion_rendido'){
			//Si están en pagos habilita los botones ABM, y si sonb proforma habilita el botón regularizar
				if(maestro.solo_lectura==1){
					if(selected.data.sw_viatico=='si')
						CM_getBoton('imp_recibo_pago-'+idContenedor).enable();
						CM_getBoton('guardar-'+idContenedor).enable();
				} else if(maestro.solo_lectura==0){
					CM_getBoton('guardar-'+idContenedor).enable();
					CM_getBoton('nuevo-'+idContenedor).enable();
					if(selected.data.estado=='sin_marcar'){
						CM_getBoton('gastos-'+idContenedor).enable();
						CM_getBoton('editar-'+idContenedor).enable();
						CM_getBoton('eliminar-'+idContenedor).enable();
					}
					if(selected.data.sw_viatico=='si')
						CM_getBoton('imp_recibo_pago-'+idContenedor).enable();
					if(selected.data.importe_retencion > 0){
						CM_getBoton('editar-'+idContenedor).disable();
					}else{
						if(selected.data.tipo_documento == 25){
							CM_getBoton('editar-'+idContenedor).disable();
							CM_getBoton('gastos-'+idContenedor).disable();
						}else{
							CM_getBoton('editar-'+idContenedor).enable();
							CM_getBoton('gastos-'+idContenedor).enable();}
					}
				}else if(maestro.solo_lectura==3){
					CM_getBoton('guardar-'+idContenedor).enable();
					CM_getBoton('gastos-'+idContenedor).enable();
					
					if(selected.data.sw_viatico=='si')
						CM_getBoton('imp_recibo_pago-'+idContenedor).enable();	
				}
			}else{
				CM_getBoton('guardar-'+idContenedor).enable();
				CM_getBoton('gastos-'+idContenedor).enable();
			}
			if(vista!='rendicion_viatico' && vista!='rendicion_avance'){
				if(selected.data.estado=='sin_marcar'||selected.data.estado=='en_rendicion')
					CM_getBoton('marcar/desmarcar-'+idContenedor).enable();
			}
		}
		
		enableSelect(sel,row,selected);
	}
	
	function btnRegGastos(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_cuenta_doc_rendicion='+SelectionsRecord.data.id_cuenta_doc_rendicion;
			data=data+'&m_nro_documento='+SelectionsRecord.data.nro_documento;
			data=data+'&m_razon_social='+SelectionsRecord.data.razon_social;
			data=data+'&m_fecha_documento='+SelectionsRecord.data.fecha_documento;
			data=data+'&m_importe_total='+SelectionsRecord.data.importe_total;
			data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
			data=data+'&m_solo_lectura='+maestro.solo_lectura;
			data=data+'&m_sw_viatico='+SelectionsRecord.data.sw_viatico;
			data=data+'&m_id_cuenta_doc='+maestro.id_cuenta_doc;
			data=data+'&m_tipo_cuenta_doc='+maestro.tipo_cuenta_doc;
			var ParamVentana={Ventana:{width:'70%',height:'70%'}};
			if(SelectionsRecord.data.sw_viatico=='si'){
				layout.loadWindows(direccion+'../../../../sis_tesoreria/vista/cuenta_doc_rendicion_det/cuenta_doc_rendicion_det_vi.php?'+data,'Registro de Gastos',ParamVentana);
			}else{
				layout.loadWindows(direccion+'../../../../sis_tesoreria/vista/cuenta_doc_rendicion_det/cuenta_doc_rendicion_det.php?'+data,'Registro de Gastos',ParamVentana);
			}
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}
	
	function btn_marcar(){			
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1){
			var sm=getSelectionModel();
			Ext.Ajax.request({
				url:direccion+"../../../control/cuenta_doc_rendicion/ActionMarcarRendiciones.php",
				success:esteSuccess,
				params:{'id_cuenta_doc':sm.getSelected().data.id_cuenta_doc_rendicion},
				failure:CM_conexionFailure,
				timeout:paramConfig.TiempoEspera
			})
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una Rendicion.')
		}		
	}
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			CM_btnAct();
		}else{
			CM_conexionFailure();
		}
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	var CM_getBoton=this.getBoton;
	
	function btn_reporte(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_cuenta_doc_rendicion='+SelectionsRecord.data.id_cuenta_doc_rendicion;
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
				window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFReciboPago.php?'+data);
			
			Ext.MessageBox.hide();
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Recibo de Pago',btn_reporte,true,'imp_recibo_pago','Impresion');
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle Gastos',btnRegGastos,true,'gastos','Gastos');
	
	if(vista!='rendicion_viatico' && vista!='rendicion_avance')
		this.AdicionarBoton('../../../lib/imagenes/detalle.png','Marcar o Desmarcar',btn_marcar,true,'marcar/desmarcar','Marcar/Desmarcar');
	
	CM_getBoton('gastos-'+idContenedor).disable();
	
	if(vista!='rendicion_rendido'){
		CM_getBoton('editar-'+idContenedor).disable();
		CM_getBoton('eliminar-'+idContenedor).disable();
		CM_getBoton('guardar-'+idContenedor).disable();
		CM_getBoton('actualizar-'+idContenedor).disable();
		CM_getBoton('nuevo-'+idContenedor).disable();
	}
	
	if(vista!='rendicion_viatico' && vista!='rendicion_avance'){
		CM_getBoton('marcar/desmarcar-'+idContenedor).disable();
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();

	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}