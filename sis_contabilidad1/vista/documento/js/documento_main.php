//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TiempoEspera:10000};
var maestro={ nombre_tabla:'<?php echo $m_nombre_tabla;?>',
              nombre_campo:'<?php echo $m_nombre_campo;?>',
              id_tabla:'<?php echo $m_id_tabla;?>',
              fk_avance:'<?php echo $m_fk_avance;?>',
              id_moneda:'<?php echo $m_id_moneda;?>',
              id_documento:'<?php echo $m_id_documento;?>',
              importe:'<?php echo $m_importe;?>',
              nuevo:'<?php echo $m_nuevo;?>',
              nit:'<?php echo $m_nit;?>',
              razon_social:'<?php echo $m_razon_social;?>',
              regulariz:'<?php echo $m_regulariz;?>',
              id_devengado_dcto:<?php if($m_id_devengado_dcto==''){echo '-1';} else{echo $m_id_devengado_dcto;}?>,
              tipo_doc_fijo:'<?php if($m_tipo_doc_fijo==''){echo 'no';} else{echo $m_tipo_doc_fijo;}?>',
              tipo_documento:<?php if($m_tipo_documento==''){echo '-1';} else{echo $m_tipo_documento;}?>,
              tipo:<?php if($m_tipo==''){echo '-1';} else{echo $m_tipo;}?>,
              compro:'<?php echo $m_compro;?>',//compro=si, tesoro=ts
              desc_plantilla:'<?php echo $m_desc_plantilla;?>',
              desc_moneda:'<?php echo $m_desc_moneda;?>',
              id_plan_pago:'<?php echo $m_id_plan_pago;?>',
              
              id_presupuesto:'<?php echo $m_id_presupuesto;?>',
              desc_presupuesto:'<?php echo $m_desc_presupuesto;?>',
              id_parametro:'<?php echo $m_id_parametro;?>',
              desc_parametro:'<?php echo $m_desc_parametro;?>',
              sw_viatico:'<?php echo $m_sw_viatico;?>'
              
              
             };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new Documento(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function Documento(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array;
	var ContPes=1;
	var layout_documento;
	var combo_tipo_documento,combo_moneda,combo_parametro,combo_presupuesto,combo_concepto_ingas,combo_orden_trabajo;
	var txt_importe_avance,txt_fecha_documento;
	var txt_nro_documento,txt_razon_social,txt_nro_nit;
	var txt_nro_autorizacion,txt_codigo_control;
	var txt_nombre_tabla,txt_nombre_campo;
	var txt_id_tabla,v_nuevo; //nuevo = 0, modificaciï¿½n = 1
	var ds_doc;
	var componentes=new Array;
	//var boolSubmit=1;//Variable que indica si se llama directamente al submit

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro'])
	});
	
	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php?'}),   //para filtrar solo los conceptos de viaticos sw_tesoro=3
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv','desc_cuenta','desc_auxiliar' ])
	});

	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																										'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																										'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																										'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																										'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																										]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
	
	var ds_orden_trabajo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/orden_trabajo/ActionListarOrdenTrabajo.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario','desc_usuario'])
	//reader:new Ext.data.XmlReader({record:'ROWS',id:'id_orden_trabajo',totalRecords: 'TotalCount'},['id_orden_trabajo','desc_orden','motivo_orden','fecha_inicio','fecha_final','estado_orden','id_usuario','desc_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona' ])
	});
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});	
	
    var ds_tipo_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/tipo_destino/ActionListarTipoDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_destino',totalRecords: 'TotalCount'},['id_tipo_destino','descripcion','id_moneda','fecha_reg','id_usr_reg'])
	});

    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','descripcion'])
	});

	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
			
	function render_id_tipo_destino(value, p, record){return String.format('{0}', record.data['desc_tipo_destino']);}
	var tpl_id_tipo_destino=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">',
		'<b>{desc_ingas_item_serv}</b><br>',
		'   Partida: <FONT COLOR="#B50000">{desc_partida}</FONT>',
		'<br>Cuenta: <FONT COLOR="#B5A642">{desc_cuenta}</FONT>',
		'<br>Auxiliar: <FONT COLOR="#B50000">{desc_auxiliar}</FONT>',
		'</div>');
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
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
	//var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</b></i><br>','</div>');
	var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>'); 
	
	///////id tabla/////////
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_documento',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:3,
		save_as:'id_documento'
	};

	//// PLantilla /////////
	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='PLANT.sw_tesoro';
	filterValues[0]='1';
	Atributos[1]={
		validacion:{
			name:'tipo_documento',
			fieldLabel:'Tipo Documento',
			allowBlank:false,
			//emptyText:'Tipo Documento...',
			store:ds_plantilla,
			valueField:'tipo_plantilla',
			displayField:'desc_plantilla',
			queryParam:'filterValue_0',
			filterCol:'PLANT.desc_plantilla',
			filterCols:filterCols,
			filterValues:filterValues,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:300
		},
		tipo:'ComboBox',
		save_as:'tipo_documento',
		id_grupo:1
	};

	//// Moneda /////////
	Atributos[2]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,
			emptyText:'Moneda...',
			store:ds_moneda,
			valueField:'id_moneda',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_moneda',
		id_grupo:3
	};
	
	// importe documento
	Atributos[3]={
		validacion:{
			name:'importe_avance',
			fieldLabel:'Importe Documento',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%'
		},
		tipo:'NumberField',
		save_as:'importe_avance',
		id_grupo:3
	};
	
	// txt fecha_documento
	Atributos[4]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Dia no valido'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_documento',
		id_grupo:3
	};

	// txt nro_documento
	Atributos[5]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'No Documento',
			allowBlank:false,
			allowDecimals:false,
			maxLength:50,
			minLength:0,
			width:'75%'
		},
		tipo:'NumberField',
		save_as:'nro_documento',
		id_grupo:3
	};
	
	// txt nro_nit
	Atributos[6]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			width:'100%'
		},
		tipo:'TextField',
		id_grupo:2,
		save_as:'nro_nit'
	};
	
	// txt razon_social
	Atributos[7]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			width:'100%'
		},
		tipo:'TextArea',
		save_as:'razon_social',
		id_grupo:3
	};
	
	// txt nro_autorizacion
	Atributos[8]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'No Autorización',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			width:'100%'
		},
		tipo:'TextField',
		id_grupo:2,
		save_as:'nro_autorizacion'
	};
	
	// txt codigo_control
	Atributos[9]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:14,
			minLength:0,
			width:'100%',
			regex: /^((([0-9]|[a-z])([a-z]|[0-9])-){3}([0-9]|[a-z])([a-z]|[0-9])(-([0-9]|[a-z])([a-z]|[0-9]))?)$/i,
			maskRe: /[\d\s-abcdef]/i,
			invalidText: 'Código inválido. Formato correcto "1b-df-14-10-2d"'
		},
		tipo:'TextField',
		id_grupo:2,
		save_as:'codigo_control'
	};
	
	///////nombre table/////////
	Atributos[10]={
		validacion:{
			labelSeparator:'',
			name:'nombre_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'nombre_tabla'
	};
	
	///////nombre campo/////////
	Atributos[11]={
		validacion:{
			labelSeparator:'',
			name:'nombre_campo',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'nombre_campo'
	};
	
	///////id tabla/////////
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name:'id_tabla',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'id_tabla'
	};

	///////id devengado_dcto/////////
	Atributos[13]={
		validacion:{
			labelSeparator:'',
			name:'id_devengado_dcto',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'id_devengado_dcto'
	};

	//importe exento
	Atributos[14]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'ICE',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			width:'50%'
		},
		tipo:'NumberField',
		save_as:'importe_ice',
		id_grupo:4
	};

	//importe exento
	Atributos[15]={
		validacion:{
			name:'importe_exento',
			fieldLabel:'Importe Exento',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			width:'50%'
		},
		tipo:'NumberField',
		save_as:'importe_exento',
		id_grupo:4
	};
		
	Atributos[16]={
		validacion:{
			labelSeparator:'',
			name:'id_plan_pago',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'id_plan_pago'
	};
	
	// txt id_parametro
	Atributos[17]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			//displayField: 'desc_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			//grid_indice:1,  //para colocar el orden en el indice			
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres'		
	};
	
	//combo presupuesto	
     Atributos[18]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,				
			desc: 'desc_presupuesto', //columna del ds_store principal del que proviene la descripcion //que es lo que se muestra en la grilla
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',	//que es lo que se muestra en el formulario
			queryParam: 'filterValue_0',
			filterCol: 'PRESUP.nombre_unidad#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog', //con estos campos filtramos en el formulario
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
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:true
			//grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',// cone estos campos filtramos en la grilla
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	// txt id_concepto_ingas
	Atributos[19]={
		validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto',
			allowBlank:true,			
			//emptyText:'Concepto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.desc_partida#CONING.desc_ingas#CUENTA.nro_cuenta#CUENTA.nombre_cuenta#AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:true,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:50,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:300,
			disabled:true
			//grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		save_as:'id_concepto_ingas',
		id_grupo:0
	};

	Atributos[20]={
		validacion:{
			name:'id_orden_trabajo',
			fieldLabel:'Orden de Trabajo (OT)',
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
			pageSize:30,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_orden_trabajo,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'ORDTRA.desc_orden_trabajo',
		save_as:'id_orden_trabajo',
		id_grupo:0
	};
	
	Atributos[21]={
		validacion: {
			name:'via',
			fieldLabel:'Via',
			allowBlank:false,
			emptyText:'Via...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['aereo','Aereo'],['terrestre','Terrestre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer: renderSwHotel,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			minListWidth:100,
			disable:false
			//grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.via',
		defecto:'aereo',
		save_as:'via',
		id_grupo:5
	};	
	
	Atributos[22]={
		validacion:{
			name:'id_tipo_destino',
			fieldLabel:'Tipo de Destino',
			allowBlank:false,			
			emptyText:'Tipo de Destino...',
			desc: 'desc_tipo_destino', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_destino,
			valueField: 'id_tipo_destino',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'TIPDES.descripcion',
			typeAhead:true,
			tpl:tpl_id_tipo_destino,
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
			renderer:render_id_tipo_destino,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		save_as:'id_tipo_destino',
		id_grupo:5
	};
	
	Atributos[23]={
		validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura',
			allowBlank:false,			
			emptyText:'Cobertura...',
			desc: 'desc_cobertura', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,
			valueField: 'id_cobertura',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.descripcion',
			typeAhead:true,
			tpl:tpl_id_cobertura,
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
			renderer:render_id_cobertura,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		save_as:'id_cobertura',
		id_grupo:5
	};

	
	Atributos[24]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini',
		id_grupo:5
	};
	
	Atributos[25]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin',
		id_grupo:5
	};
	
	Atributos[26]={
		validacion:{
			labelSeparator:'',
			name:'sw_viatico',
			inputType:'hidden'
		},
		tipo:'Field',
		id_grupo:4,
		save_as:'sw_viatico'
	};
	

	//Verifica si es nuevo o no
	if(maestro.nuevo==''){
		maestro.nuevo='no';
	}

	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Documentos"};
	layout_documento=new DocsLayoutProceso(idContenedor,idContenedorPadre);
	layout_documento.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,Atributos,layout_documento,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_conexionFailure=this.conexionFailure;
	var CM_getComponente=this.getComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnActualizar=this.btnActualizar;
	var CM_conexionFailure=this.conexionFailure;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	
	//var CM_submit=this.submit;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Documentos "+ContPes;
		ContPes ++;
		return titulo
	}
	function retorno(resp){
		Ext.MessageBox.hide();
		_CP.getVentana(idContenedor).hide();

		var root = resp.responseXML.documentElement;
		var mensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;

		Ext.Msg.show({
			title:'Estado',
			msg:mensaje,
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		});
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar()
	}
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //

	//Define el Action para guardar los datos
	var paramFunciones;
	if(maestro.regulariz==2){
		//Para regularizaciï¿½n de proformas
		paramFunciones={
			Formulario:{html_apply:'dlgInfo-'+idContenedor,labelWidth:75,
			url:direccion+'../../../../sis_tesoreria/control/devengado_dcto/ActionRegularizProformaDevegado.php',
			abrir_pestana:false,
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			success:retorno,
			//columnas:[410],
			columnas:['47%','47%'],
			height:500, //alto
			width:850,  //ancho
			closable:true,
			titulo:'Documento',
			grupos:[
			{tituloGrupo:'Datos3 Presupuesto',columna:0,id_grupo:0},
				{tituloGrupo:'Tipo Documento',columna:0,id_grupo:1},
				{tituloGrupo:'Datos Factura',columna:0,id_grupo:2},
				{tituloGrupo:'Datos Documento',columna:1,id_grupo:3},			
				{tituloGrupo:'Oculto',columna:1,id_grupo:4},
				{tituloGrupo:'Datos Viatico',columna:0,id_grupo:5}
			],parametros:''}
		};
	}
	else{
		//Caso normal
		paramFunciones={
				
			Formulario:{html_apply:'dlgInfo-'+idContenedor,labelWidth:75,
			url:direccion+'../../../../sis_contabilidad/control/documento/ActionGuardarDocumento.php',
			abrir_pestana:false,
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			success:retorno,
			//columnas:[410],
			columnas:['47%','47%'],
			height:500, //alto
			width:850,  //ancho
			closable:true,
			titulo:'Documento',
			grupos:[
			{tituloGrupo:'Datos Presupuesto',columna:0,id_grupo:0},
			{tituloGrupo:'Tipo Documento',columna:0,id_grupo:1},
			{tituloGrupo:'Datos Factura',columna:0,id_grupo:2},
			{tituloGrupo:'Datos Documento',columna:1,id_grupo:3},			
			{tituloGrupo:'Oculto',columna:1,id_grupo:4},
			{tituloGrupo:'Datos Viatico',columna:0,id_grupo:5}
			],parametros:''}
		};
	}

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.nombre_tabla=datos.m_nombre_tabla;
		maestro.nombre_campo=datos.m_nombre_campo;
		maestro.id_tabla=datos.m_id_tabla;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.fk_avance=datos.m_fk_avance;
		maestro.id_documento=datos.m_id_documento;
		maestro.importe=datos.m_importe;
		maestro.nuevo=datos.m_nuevo;
		maestro.nit=datos.m_nit;
		maestro.razon_social=datos.m_razon_social;
		maestro.regulariz=datos.m_regulariz;
		maestro.id_devengado_dcto=datos.m_id_devengado_dcto;
		maestro.tipo_doc_fijo=datos.m_tipo_doc_fijo;
		// para plantilla-COMPRO
		maestro.compro=datos.m_compro;
		maestro.desc_plantilla=datos.m_desc_plantilla;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.tipo=datos.m_tipo;
		maestro.tipo_documento=datos.m_tipo_documento;
		maestro.id_plan_pago=datos.m_id_plan_pago;
		
		maestro.id_presupuesto=datos.m_id_presupuesto;
		maestro.desc_presupuesto=datos.m_desc_presupuesto;
		maestro.sw_viatico=datos.m_sw_viatico;
		
		//Carga el id_devengado_dcto si es que tiene
		txt_id_devengado_dcto.setValue(maestro.id_devengado_dcto);

		if(maestro.nuevo=='si'){
			//insert
			txt_id_documento.setValue('');
			limpiar_formulario();
			nuevo_documento();
		}
		else{
			txt_id_documento.setValue(maestro.id_documento);
			cargar_datos();
		}
		//Verifica si es para registrar un nuevo documento o para modificaciï¿½n
		/*if(maestro.id_documento!=''&&maestro.id_documento!=undefined){
		//alert('id_documento:'+maestro.id_documento)
		txt_id_documento.setValue(maestro.id_documento);
		cargar_datos();
		}
		else{
		limpiar_formulario();
		nuevo_documento();
		};*/

		//Deshabilita componentes
		combo_moneda.disable();

		//Define el Action para guardar los datos
		if(maestro.regulariz==2){
			//Para regularizaciï¿½n de proformas
			paramFunciones={
				Formulario:{html_apply:'dlgInfo-'+idContenedor,labelWidth:75,
				url:direccion+'../../../../sis_tesoreria/control/devengado_dcto/ActionRegularizProformaDevegado.php',
				abrir_pestana:false,
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				success:retorno,
				//columnas:[410],
				columnas:['47%','47%'],
				height:500, //alto
				width:850,  //ancho
				closable:true,
				titulo:'Documento',
				grupos:[
				{tituloGrupo:'Datos3 Presupuesto',columna:0,id_grupo:0},
				{tituloGrupo:'Tipo Documento',columna:0,id_grupo:1},
				{tituloGrupo:'Datos Factura',columna:0,id_grupo:2},
				{tituloGrupo:'Datos Documento',columna:1,id_grupo:3},			
				{tituloGrupo:'Oculto',columna:1,id_grupo:4},
				{tituloGrupo:'Datos Viatico',columna:0,id_grupo:5}
				],parametros:''}
			};
		}
		else{
			//Caso normal
			paramFunciones={
				Formulario:{html_apply:'dlgInfo-'+idContenedor,labelWidth:75,
				url:direccion+'../../../../sis_contabilidad/control/documento/ActionGuardarDocumento.php',
				abrir_pestana:false,
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				success:retorno,
				//columnas:[410],
				columnas:['47%','47%'],
				height:500, //alto
				width:850,  //ancho
				closable:true,
				titulo:'Documento',
				grupos:[
				{tituloGrupo:'Datos Presupuesto',columna:0,id_grupo:0},
				{tituloGrupo:'Tipo Documento',columna:0,id_grupo:1},
				{tituloGrupo:'Datos Factura',columna:0,id_grupo:2},
				{tituloGrupo:'Datos Documento',columna:1,id_grupo:3},
				{tituloGrupo:'Oculto',columna:1,id_grupo:4},
				{tituloGrupo:'Datos Viatico',columna:0,id_grupo:5}
				],parametros:''}
			};
		}

		//Verifica si se deshabilita el Tipo de Documento
		if(maestro.tipo_doc_fijo=='si'){
			combo_tipo_documento.disable();
		}
		else{
			combo_tipo_documento.enable();
		}
		this.InitFunciones(paramFunciones)
	};


	//Para manejo de eventos
	function iniciarEventosFormularios(){
		ds_moneda.reload();
		ds_plantilla.reload();
		combo_tipo_documento=CM_getComponente('tipo_documento');
		combo_moneda=CM_getComponente('id_moneda');
		combo_parametro=CM_getComponente('id_parametro');
		combo_presupuesto=CM_getComponente('id_presupuesto');
		combo_concepto_ingas=CM_getComponente('id_concepto_ingas');
		combo_orden_trabajo=CM_getComponente('id_orden_trabajo');
		
		txt_importe_avance=CM_getComponente('importe_avance');
		txt_fecha_documento=CM_getComponente('fecha_documento');
		txt_nro_documento=CM_getComponente('nro_documento');
		txt_razon_social=CM_getComponente('razon_social');
		txt_nro_nit=CM_getComponente('nro_nit');
		txt_nro_autorizacion=CM_getComponente('nro_autorizacion');
		txt_codigo_control=CM_getComponente('codigo_control');
		txt_nombre_tabla=CM_getComponente('nombre_tabla');
		txt_nombre_campo=CM_getComponente('nombre_campo');
		txt_id_tabla=CM_getComponente('id_tabla');
		txt_id_documento=CM_getComponente('id_documento');
		txt_id_devengado_dcto=CM_getComponente('id_devengado_dcto');
		txt_importe_ice=CM_getComponente('importe_ice');
		txt_importe_exento=CM_getComponente('importe_exento');

		//Define la alineaciï¿½n de los importes
		txt_importe_avance.getEl().setStyle("text-align","right");
		txt_importe_ice.getEl().setStyle("text-align","right");
		txt_importe_exento.getEl().setStyle("text-align","right");

		//Carga el id_devengado_dcto si es que tiene
		txt_id_devengado_dcto.setValue(maestro.id_devengado_dcto);
		for (var i=0;i<Atributos.length;i++){			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}

		//Verifica si el tipo de documento debe deshabilitarse
		if(maestro.tipo_doc_fijo=='si'){
			combo_tipo_documento.disable();
		}else{
			combo_tipo_documento.enable();
		}

		/*****************************/			
		//Verifica si es para registrar un nuevo documento o para modificaciï¿½n
		if(maestro.nuevo=='si'){
			//insert
			txt_id_documento.setValue('');
			limpiar_formulario();
			nuevo_documento();
		}
		else{
			txt_id_documento.setValue(maestro.id_documento);
			cargar_datos();
		}
		/*if(maestro.id_documento!=''){
		//update
		txt_id_documento.setValue(maestro.id_documento);
		cargar_datos();
		}
		else{
		//insert
		limpiar_formulario();
		nuevo_documento();
		};*/

		//Deshabilita componentes
		combo_moneda.disable();

		var onTipoDocSelect=function(e){
			//var id=combo_tipo_documento.getValue();
			//alert('tipo documento:'+id);
			var recPlantilla = combo_tipo_documento.store.getById(combo_tipo_documento.getValue());
			var v_tipo=recPlantilla.data.tipo;
			var v_tipo_plantilla=recPlantilla.data.tipo_plantilla;
			CM_ocultarGrupo('Oculto');

			//if (id==1||id==4){
			if(v_tipo==1){
				CM_mostrarGrupo('Datos Factura');
				
				//txt_nro_nit.reset();
				txt_nro_autorizacion.reset();
				txt_codigo_control.reset();
				txt_nro_nit.allowBlank=false;
				
				//adicion de asignacion para COMPRO
				txt_nro_nit.setValue(maestro.nit);				
				
				txt_nro_autorizacion.allowBlank=false;
				//txt_codigo_control.allowBlank=false
				txt_nro_documento.allowBlank=false;
			}
			else{
				CM_ocultarGrupo('Datos Factura');				
				
				//txt_nro_nit.reset();
				txt_nro_autorizacion.reset();
				txt_codigo_control.reset();
				txt_nro_nit.allowBlank=true;
				txt_nro_autorizacion.allowBlank=true;
				txt_codigo_control.allowBlank=true
				//Dependiendo si es proforma permite registrar sin algï¿½n dato
				//if(id==16||id==17||id==18){
				txt_nro_documento.allowBlank=false;
			}
		}
		
		combo_tipo_documento.on('select',onTipoDocSelect);
		combo_tipo_documento.on('change',onTipoDocSelect);
		txt_nro_nit.on('blur',obtenerDatosProveedor);
		
		/*txt_importe_avance.on('blur',onValidImportes);
		txt_importe_ice.on('blur',onValidImportes);
		txt_importe_exento.on('blur',onValidImportes);*/
		
		combo_parametro.on('select',evento_parametro);   //cuando selecciono un presupuesto salta el evento
		combo_presupuesto.on('select',evento_presupuesto);   //cuando selecciono un presupuesto salta el evento
		if(maestro.compro=='rendicion_viatico')
			combo_concepto_ingas.on('select',validarConcepto);
		
			componentes[22].on('select',obtenerImporte);
			componentes[23].on('select',obtenerImporte);
			componentes[24].on('valid',obtenerImporte);
			componentes[25].on('valid',obtenerImporte);
			ClaseMadre_getComponente('via').on('select',filtrar_cobertura);
		}
	
	function validarConcepto(combo,record,index){
		var nombre_concepto;
		nombre_concepto=record.data.desc_ingas.toLowerCase();
		
		if(nombre_concepto.indexOf('viaticos')!=-1 || nombre_concepto.indexOf('viaticos')!=-1){
			tipoViatico();
		}
		else{
			tipoOtro();
		}
	}
	
	function tipoViatico(){
		CM_mostrarGrupo('Datos Viatico');
		NoBlancosGrupo(5);
		componentes[3].reset();
		componentes[3].setDisabled(true);
		componentes[26].setValue('1');	
	}
	
	function tipoOtro(){
		CM_ocultarGrupo('Datos Viatico');
		SiBlancosGrupo(5);
		componentes[3].setDisabled(false);
		componentes[26].setValue('0');
	}
	
	function obtenerImporte(combo,record,index){
		if(componentes[22].getValue()=='' || componentes[23].getValue()=='' || componentes[24].getValue()=='' || componentes[25].getValue()==''){
			
		}
		else{
			Ext.MessageBox.show({
							title: 'Cargando Importe...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Importe...</div>",
							width:150,
							height:200,
							closable:false
						});
			var parametros=new Array;
			parametros={fecha_ini:componentes[24].getValue().dateFormat('m-d-Y'),
							id_cobertura:componentes[23].getValue(),id_tipo_destino:componentes[22].getValue(),fecha_fin:componentes[25].getValue().dateFormat('m-d-Y'),
								id_cuenta_doc:componentes[12].getValue()};
			
			Ext.Ajax.request({
						url:direccion+"../../../../sis_tesoreria/control/cuenta_doc_det/ActionObtenerImporteViatico.php",
						success:cargar_respuesta2,
						//params:{id_cobertura:componentes[8].getValue(),id_categoria:maestro.id_categoria,id_tipo_destino:componentes[7].getValue(),cantidad:componentes[4].getValue()},
						params:parametros,
						
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
		}
	}
	
	function cargar_respuesta2(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;
			
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1'){
				componentes[3].setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
			}
			else if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='-2'){
				Ext.MessageBox.alert('Alerta','La fecha final no puede ser menor a la fecha inicio');
			}
			else{ 
			
				Ext.MessageBox.alert('Alerta','No se puede obtener el importe para la cobertura y categoría seleccionados. Por favor revise la parametrización');
			}								
		}
	}
	
	function filtrar_cobertura(combo,record, index){
		//alert(record.data.ID);
		//componentes[10].setValue();
		ClaseMadre_getComponente('id_cobertura').store.baseParams={via:record.data.ID,nuevo:'si'};
	
		componentes[23].modificado=true;
		componentes[23].setDisabled(false);
	}
	
	function obtenerDatosProveedor(campo,valorNuevo,valorAntiguo){
		Ext.MessageBox.show({
							title: 'Cargando Datos de Proveedor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando Datos de Proveedor...</div>",
							width:150,
							height:200,
							closable:false
						});
		Ext.Ajax.request({
						url:direccion+"../../../control/documento/ActionObtenerDatosProveedor.php",
						success:cargar_respuesta,
						params:{nit:txt_nro_nit.getValue()},
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
	}
	
	function cargar_respuesta(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined){
			var root=resp.responseXML.documentElement;
			//if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1')
			if( root.getElementsByTagName('respuesta')[0]!=undefined && root.getElementsByTagName('respuesta')[0].firstChild!=null && root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1'){
				txt_nro_autorizacion.setValue(root.getElementsByTagName('nro_autoriza')[0].firstChild.nodeValue);
				txt_razon_social.setValue(root.getElementsByTagName('razon_social')[0].firstChild.nodeValue);
			}
			else{
				txt_nro_autorizacion.setValue('');
				txt_razon_social.setValue('');
			}	
		}
	}
	
	function evento_parametro( combo, record, index ){		
			//Filtramos los presupuestos segun la gestion seleccionada
			combo_presupuesto.store.baseParams={id_parametro:record.data.id_parametro};
			combo_presupuesto.modificado=true;			
			combo_presupuesto.setValue('');			
			combo_presupuesto.setDisabled(false);												
 	}
	
	function evento_presupuesto( combo, record, index ){	
		//filtramos los conceptos de tesoreria por unidad organizacional y presupuesto	
		combo_concepto_ingas.reset();		
	
		if(maestro.compro=='rendicion_viatico'){
			//para listar solo los conceptos de gasto de viaticos
			combo_concepto_ingas.store.baseParams={sw_tesoro:6,m_sw_rendicion:'si',m_id_presupuesto:record.data.id_presupuesto};
		}
		else if(maestro.compro=='rendicion_avance'){
			//para listar solo los conceptos de gasto de fondos en avance
			combo_concepto_ingas.store.baseParams={sw_tesoro:4,m_sw_rendicion:'si',m_id_presupuesto:record.data.id_presupuesto};
		}
		else if(maestro.compro=='rendicion_rendido'){ //rendicion rendido
			//para listar solo los conceptos de gasto de cajas   1=lista todos los conceptos
			combo_concepto_ingas.store.baseParams={sw_tesoro:5,m_sw_rendicion:'si',m_id_presupuesto:record.data.id_presupuesto};
		}
		
		combo_concepto_ingas.modificado=true;
		combo_concepto_ingas.enable();								
 	}

	function limpiar_formulario(){
		combo_tipo_documento.setValue('');
		combo_moneda.setValue('');
		combo_parametro.setValue('');
		combo_presupuesto.setValue('');
		combo_concepto_ingas.setValue('');
		combo_orden_trabajo.setValue('');
		
		txt_importe_avance.setValue('');
		txt_fecha_documento.setValue('');
		txt_nro_documento.setValue('');
		//txt_razon_social.setValue('');
		//txt_nro_nit.setValue('');
		txt_nro_autorizacion.setValue('');
		txt_codigo_control.setValue('');
		txt_nombre_tabla.setValue('');
		txt_nombre_campo.setValue('');
		txt_id_tabla.setValue('');
		txt_importe_ice.setValue('');
		txt_importe_exento.setValue('');

		//Establece los valores por defecto
		combo_moneda.setValue(maestro.id_moneda);
		txt_nombre_tabla.setValue(maestro.nombre_tabla);
		txt_nombre_campo.setValue(maestro.nombre_campo);
		txt_id_tabla.setValue(maestro.id_tabla);
		txt_importe_avance.setValue(maestro.importe);
		txt_nro_nit.setValue(maestro.nit);
		txt_razon_social.setValue(maestro.razon_social);
		txt_importe_ice.setValue('0');
		txt_importe_exento.setValue('0');
	}

	function nuevo_documento(){
		ds_plantilla.reload();
		CM_ocultarGrupo('Datos Factura');
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Datos Viatico');
		SiBlancosGrupo(5);
		componentes[3].setDisabled(false);
		combo_parametro.allowBlank=true;
		combo_presupuesto.allowBlank=true;
		combo_concepto_ingas.allowBlank=true;
		combo_concepto_ingas.disable();
		CM_ocultarGrupo('Datos Presupuesto');
		txt_nro_nit.allowBlank=true;
		txt_nro_autorizacion.allowBlank=true;
		txt_codigo_control.allowBlank=true;
		//Carga el tipo de documento si el parï¿½metro ha sido enviado
		if(maestro.tipo_documento!=-1){
			combo_tipo_documento.setValue(maestro.tipo_documento);
		}
		
		if(maestro.compro=='si'){
			combo_tipo_documento.setValue(maestro.tipo_documento);
			combo_tipo_documento.setRawValue(maestro.desc_plantilla);
			txt_nro_nit.setValue(maestro.nit);
			txt_importe_avance.setValue(maestro.importe);
			txt_importe_avance.disable();
			combo_moneda.setRawValue(maestro.desc_moneda);
			CM_getComponente('id_plan_pago').setValue(maestro.id_plan_pago);
			
			if(maestro.tipo==1){				
				CM_mostrarGrupo('Datos Factura');
				//txt_nro_nit.reset();
				txt_nro_autorizacion.reset();
				txt_codigo_control.reset();
				txt_nro_nit.allowBlank=false;
				
				//adicion de asignacion para COMPRO
				txt_nro_nit.setValue(maestro.nit);
				
				txt_nro_autorizacion.allowBlank=false;
				//txt_codigo_control.allowBlank=false
				txt_nro_documento.allowBlank=false;
			}
			else{
				CM_ocultarGrupo('Datos Factura');
				//txt_nro_nit.reset();
				txt_nro_autorizacion.reset();
				txt_codigo_control.reset();
				txt_nro_nit.allowBlank=true;
				txt_nro_autorizacion.allowBlank=true;
				txt_codigo_control.allowBlank=true;
				//Dependiendo si es proforma permite registrar sin algï¿½n dato
				//if(id==16||id==17||id==18){
				txt_nro_documento.allowBlank=false;
			}			
		}
		else{
			if(maestro.compro=='rendicion_viatico'||maestro.compro=='rendicion_avance'||maestro.compro=='rendicion_rendido'){ //rendicion_rendido	
				combo_parametro.allowBlank=true;		
				combo_presupuesto.allowBlank=false;
				combo_concepto_ingas.allowBlank=false;
				combo_moneda.setRawValue(maestro.desc_moneda);
				CM_mostrarGrupo('Datos Presupuesto');				
				
				//Se aumenta registro en combo de parametros para definir el valor por defecto del padre
				var params2 = new Array();
				params2['id_parametro'] = maestro.id_parametro;
				params2['gestion_pres'] = maestro.desc_parametro;
				var aux2 = new Ext.data.Record(params2);
				Atributos[17].validacion.store.add(aux2);					
				combo_parametro.setValue(maestro.id_parametro);	
				
				var  params = new Array();
				params['id_presupuesto'] = maestro.id_presupuesto;
				params['desc_presupuesto'] = maestro.desc_presupuesto;				
				var aux = new Ext.data.Record(params);				
				Atributos[18].validacion.store.add(aux);
				combo_presupuesto.setValue(maestro.id_presupuesto);
				evento_presupuesto('nada',aux,'nada');
			}
			else{
				combo_presupuesto.allowBlank=true;
				combo_concepto_ingas.allowBlank=true;
				CM_ocultarGrupo('Datos Presupuesto');
			}
		}		
	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo){
				componentes[i].allowBlank=true;
				componentes[i].setValue('');
			}
		}
	}
	
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo){
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
			}
		}
	}

	function cargar_datos(){
		if(maestro.compro=='si'){
			combo_tipo_documento.setValue(maestro.tipo_documento);
			combo_tipo_documento.setRawValue(maestro.desc_plantilla);
			txt_importe_avance.disable();
		}
		else{
			txt_importe_avance.enable();
		}
		data='id_documento='+maestro.id_documento+'&id_moneda='+maestro.id_moneda;
		//alert('data:'+data)
		Ext.Ajax.request({
			url:direccion+'../../../../sis_contabilidad/control/documento/ActionListarDocumentoImporte.php?'+data,
			method:'GET',
			success:exito_carga,
			failure:CM_conexionFailure,
			timeout:100000
		})
	}

	function exito_carga(resp){
		var root = resp.responseXML.documentElement;
		CM_ocultarGrupo('Oculto');

		//Carga los datos del documento en variables internas
		var count = root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
		if(count>0){
			v_tipo=root.getElementsByTagName('tipo')[0].firstChild==undefined ? '':root.getElementsByTagName('tipo')[0].firstChild.nodeValue;
			v_tipo_documento=root.getElementsByTagName('tipo_documento')[0].firstChild==undefined ? '':root.getElementsByTagName('tipo_documento')[0].firstChild.nodeValue;
			v_id_moneda=root.getElementsByTagName('id_moneda')[0].firstChild==undefined ? '':root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue;
			v_importe_total=root.getElementsByTagName('importe_total')[0].firstChild==undefined ? '':root.getElementsByTagName('importe_total')[0].firstChild.nodeValue;
			v_fecha_documento=root.getElementsByTagName('fecha_documento')[0].firstChild==undefined ? '':root.getElementsByTagName('fecha_documento')[0].firstChild.nodeValue;
			v_nro_documento=root.getElementsByTagName('nro_documento')[0].firstChild==undefined ? '':root.getElementsByTagName('nro_documento')[0].firstChild.nodeValue;
			v_razon_social=root.getElementsByTagName('razon_social')[0].firstChild==undefined ? '':root.getElementsByTagName('razon_social')[0].firstChild.nodeValue;
			v_nro_nit=root.getElementsByTagName('nro_nit')[0].firstChild==undefined ? '':root.getElementsByTagName('nro_nit')[0].firstChild.nodeValue;
			v_nro_autorizacion=root.getElementsByTagName('nro_autorizacion')[0].firstChild==undefined ? '':root.getElementsByTagName('nro_autorizacion')[0].firstChild.nodeValue;
			v_codigo_control=root.getElementsByTagName('codigo_control')[0].firstChild==undefined ? '':root.getElementsByTagName('codigo_control')[0].firstChild.nodeValue;
			v_importe_ice=root.getElementsByTagName('importe_ice')[0].firstChild==undefined ? '':root.getElementsByTagName('importe_ice')[0].firstChild.nodeValue;
			v_importe_exento=root.getElementsByTagName('importe_exento')[0].firstChild==undefined ? '':root.getElementsByTagName('importe_exento')[0].firstChild.nodeValue;

			/*alert('tipo_documento:'+v_tipo_documento);
			alert('id_moneda:'+v_id_moneda);
			alert('importe_total:'+v_importe_total);
			alert('fecha_documento:'+v_fecha_documento);
			alert('nro_documento:'+v_nro_documento);
			alert('razon social:'+v_razon_social);
			alert('nro_nit:'+v_nro_nit);
			alert('nro_autorizacion:'+v_nro_autorizacion);
			alert('codigo_control:'+v_codigo_control);*/

			//Carga los datos en los controles del formulario
			combo_tipo_documento.setValue(v_tipo_documento);
			if(maestro.compro=='si')
			{
				combo_tipo_documento.setRawValue(maestro.desc_plantilla);
			}
			//combo_moneda.setValue(v_id_moneda);
			txt_importe_avance.setValue(v_importe_total);
			txt_importe_ice.setValue(v_importe_ice);
			txt_importe_exento.setValue(v_importe_exento);
			txt_fecha_documento.setValue(v_fecha_documento);
			txt_nro_documento.setValue(v_nro_documento);
			txt_razon_social.setValue(v_razon_social);

			if(v_tipo==1){
				CM_mostrarGrupo('Datos Factura');
				
				if(maestro.compro=='rendicion_viatico'||maestro.compro=='rendicion_avance'||maestro.compro=='rendicion_rendido'){ //rendicion_rendido
					CM_ocultarGrupo('Datos Presupuesto');
				}			
				else{
					CM_ocultarGrupo('Datos Presupuesto');
				}
				
				txt_nro_nit.setValue(v_nro_nit);
				txt_nro_autorizacion.setValue(v_nro_autorizacion);
				txt_codigo_control.setValue(v_codigo_control);
				txt_nro_nit.allowBlank=false;
				txt_nro_autorizacion.allowBlank=false;
				//txt_codigo_control.allowBlank=false;
				txt_nro_documento.allowBlank=false;
			}
			else{
				CM_ocultarGrupo('Datos Factura');
				if(maestro.compro=='rendicion_viatico'||maestro.compro=='rendicion_avance'||maestro.compro=='rendicion_rendido'){  //rendicion_rendido
					CM_ocultarGrupo('Datos Presupuesto');
				}			
				else{
					CM_ocultarGrupo('Datos Presupuesto');
				}
				txt_nro_nit.allowBlank=true;
				txt_nro_autorizacion.allowBlank=true;
				txt_codigo_control.allowBlank=true;
				txt_nro_documento.allowBlank=false;
			}
		}
		combo_moneda.setValue(maestro.id_moneda);
		//Carga los valores para asociar a tablas externas
		txt_nombre_tabla.setValue(maestro.nombre_tabla);
		txt_nombre_campo.setValue(maestro.nombre_campo);
		txt_id_tabla.setValue(maestro.id_tabla);
		
		CM_ocultarGrupo('Datos Viatico');
		SiBlancosGrupo(5);
		if(maestro.sw_viatico=='si'){
			componentes[3].setDisabled(true);
		}
		else{
			componentes[3].setDisabled(false);
		}

	}
	
	_CP.getVentana(idContenedor).on('resize',this.onResizePrimario);

	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}