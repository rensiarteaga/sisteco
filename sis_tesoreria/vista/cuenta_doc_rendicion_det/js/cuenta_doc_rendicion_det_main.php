<?php
/**
 * Nombre:		  	    cuenta_doc_rendicion_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				RCM
 * Fecha creación:		31/10/2009
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
var maestro={
		id_cuenta_doc_rendicion:<?php echo $m_id_cuenta_doc_rendicion;?>,
		id_cuenta_doc:<?php echo $m_id_cuenta_doc;?>,
		tipo_cuenta_doc:<?php echo "'$m_tipo_cuenta_doc'";?>,
		solo_lectura:<?php if($m_solo_lectura!=''){ echo $m_solo_lectura;} else{echo "'no'";};?>,
		nro_documento:decodeURIComponent('<?php echo $m_nro_documento;?>'),
		razon_social:decodeURIComponent('<?php echo $m_razon_social;?>'),
		fecha_documento:decodeURIComponent('<?php echo $m_fecha_documento;?>'),
		importe_total:decodeURIComponent('<?php echo $m_importe_total;?>'),
		sw_viatico:decodeURIComponent('<?php echo $m_sw_viatico;?>'),
		desc_moneda:decodeURIComponent('<?php echo $m_desc_moneda;?>')};
		
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new pagina_cuenta_doc_rendicion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//sub view added

/**
* Nombre:		  	    pagina_devengado_detalle.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		2008-10-21 15:43:29
*/
function pagina_cuenta_doc_rendicion_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_doc_det/ActionListarDetalleViatico.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta_doc_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'cantidad',
		'tipo_transporte',
		'importe',
		'importe_entregado',
		'id_tipo_destino',
		'desc_tipo_destino',
		'id_cobertura',
		'desc_cobertura',
		'id_cuenta_doc_det',
		'id_cuenta_doc',
		'desc_cuenta_doc',
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'id_presupuesto',
		'desc_presupuesto',
		'observaciones',
		'id_cuenta_doc_rendicion',
		'id_orden_trabajo',
		'desc_orden_trabajo',
		'id_partida',
		'desc_partida',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},		
		'id_parametro',
		'desc_parametro'
		
		]),remoteSort:true});


	// DEFINICIï¿½N DATOS DEL MAESTRO


	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Nro.Documento',maestro.nro_documento],['Razón social',maestro.razon_social],['Fecha documento',maestro.fecha_documento],['Importe factura',maestro.importe_total],['Moneda',maestro.desc_moneda]];

	//DATA STORE COMBOS

	
	
	var ds_tipo_destino = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_destino/ActionListarTipoDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_destino',totalRecords: 'TotalCount'},['id_tipo_destino','descripcion','id_moneda','fecha_reg','id_usr_reg'])
	});

    var ds_cobertura = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords: 'TotalCount'},['id_cobertura','porcentaje','sw_hotel','descripcion'])
	});

	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php?sw_tesoro=1'}),   //para filtrar solo los conceptos de viaticos sw_tesoro=3
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
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','id_gestion'])
	});	
	
	
	//FUNCIONES RENDER

	function render_id_tipo_destino(value, p, record){return String.format('{0}', record.data['desc_tipo_destino']);}
	var tpl_id_tipo_destino=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_cobertura(value, p, record){return String.format('{0}', record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','{descripcion}<br>','</div>');

	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">',
		'<b>{desc_ingas_item_serv}</b><br>',
		'    Partida: <FONT COLOR="#B5A642">{desc_partida}</FONT>',
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
	var tpl_id_orden_trabajo=new Ext.Template('<div class="search-item">','<b><i>{desc_orden}</i></b>','<br><FONT COLOR="#B5A642">{motivo_orden}</FONT>','</div>');

	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','{desc_par}<br>','</div>');

	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','{nombre_cuenta}<br>','</div>');

	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','{nombre_auxiliar}<br>','</div>');

	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','</div>');
	

	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////

	// hidden id_devengado_detalle
	//en la posiciï¿½n 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_cuenta_doc_det',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
		Atributos[1]={
				validacion:{
					name:'id_cuenta_doc_rendicion',
					labelSeparator:'',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false,
					disabled:true
				},
				tipo:'Field',
				filtro_0:false,
				defecto:maestro.id_cuenta_doc_rendicion
		};
		
		// txt id_parametro
		Atributos[2]={
				validacion:{
				name:'id_parametro',
				fieldLabel:'Gestión',
				allowBlank:false,			
				//emptyText:'Parame...',
				desc: 'desc_parametro', //indica la columna del store principal ds del que proviene la descripcion
				store:ds_parametro,
				valueField: 'id_parametro',
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
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'90%',
				grid_indice:1,  //para colocar el orden en el indice			
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			id_grupo:0,
			filterColValue:'PARAMP.gestion_pres'		
		};
	
		
		Atributos[3]={
				validacion:{
				name:'id_presupuesto',
				fieldLabel:'Presupuesto',
				allowBlank:false,					
				desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_presupuesto,
				valueField: 'id_presupuesto',
				displayField: 'desc_presupuesto',
				queryParam: 'filterValue_0',
				filterCol:'PRESUP.desc_presupuesto',
				typeAhead:false,
				tpl:tpl_id_presupuesto,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_presupuesto,
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:'90%',
				disabled:true		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PRESUP.desc_presupuesto',
			id_grupo:0
		};
		
		
		// txt id_concepto_ingas
		Atributos[4]={
				validacion:{
				name:'id_concepto_ingas',
				fieldLabel:'Concepto',
				allowBlank:false,			
				//emptyText:'Concepto...',
				desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_concepto_ingas,
				valueField: 'id_concepto_ingas',
				displayField: 'desc_ingas',
				queryParam: 'filterValue_0',
				filterCol:'CONING.desc_ingas',
				typeAhead:false,
				tpl:tpl_id_concepto_ingas,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_concepto_ingas,
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:'90%',
				disabled:true					
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CONING.desc_ingas',
			id_grupo:0
		};
		
	
	// txt importe
		Atributos[5]={
			validacion:{
				name:'importe',
				fieldLabel:'Importe Solicitado',
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
				width:'90%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'CUDODE.importe',
			id_grupo:0
		};
		
		
	
	// txt id_presupuesto		
		Atributos[6]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Detalle',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:200,
				width:'90%',
				disabled:false						
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'CUDOC.observaciones',
			id_grupo:0			
		};	
		
		Atributos[7]={
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
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_orden_trabajo,
				grid_visible:true,
				grid_editable:true,
				width_grid:150,
				width:'90%',
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'ORDTRA.desc_orden_trabajo',
			id_grupo:0
		};
		
		Atributos[8]={
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
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_partida,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'90%',
				disabled:false		
			},
			tipo:'ComboBox',
			form: false,
			filtro_0:true,
			filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
			id_grupo:0
		};
		
		Atributos[9]={
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
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
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
		
		Atributos[10]={
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
				tpl:tpl_id_auxiliar,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
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
		
		// txt importe
		Atributos[11]={
			validacion:{
				name:'importe_entregado',
				fieldLabel:'Importe Entregado',
				allowBlank:false,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'CUDODE.importe',
			id_grupo:0
		};

	if(maestro.sw_viatico=='si'){
		Atributos[12]={
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
				id_grupo:1
			};	
				Atributos[13]={
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
					width:'90%',
					disabled:false		
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'TIPDES.descripcion',
				id_grupo:1
			};
		// txt id_cobertura
			Atributos[14]={
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
					width:'90%',
					disabled:false		
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'COBERT.descripcion',
				id_grupo:1
			};
	
			Atributos[15]= {
				validacion:{
					name:'fecha_ini',
					fieldLabel:'Fecha Inicio',
					allowBlank:false,
					format:'d/m/Y', //formato para validacion
					minValue:'01/01/1900',
					grid_visible:true,
					renderer: formatDate,
					disabledDaysText:'Día no válido'
				},
				tipo:'DateField',
				dateFormat:'m-d-Y',
				defecto:'',
				save_as:'fecha_ini',
				id_grupo:1
			};
			
			Atributos[16]= {
				validacion:{
					name:'fecha_fin',
					fieldLabel:'Fecha Fin',
					allowBlank:false,
					format:'d/m/Y', //formato para validacion
					minValue:'01/01/1900',
					grid_visible:true,
					renderer: formatDate,
					disabledDaysText:'Día no válido'
				},
				tipo:'DateField',
				dateFormat:'m-d-Y',
				defecto:'',
				save_as:'fecha_fin',
				id_grupo:1
			};
	}
	

	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Rendición',titulo_detalle:'Detalle Gastos',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout.init(config);


	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_mostrarComp=this.mostrarComponente;
	var CM_ocultarComp=this.ocultarComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_grid=this.getGrid;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;


	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var agrupos,acolumnas=Array;
	if(maestro.sw_viatico=='si'){
		
		agrupos=[
			{tituloGrupo:'Datos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Viático',columna:1,id_grupo:1}
			];	
		acolumnas=['47%','47%'];
			
	}
	else{
		agrupos=[
			{tituloGrupo:'Datos',columna:0,id_grupo:0}
			];	
		acolumnas=['95%'];	
		
	}
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_doc_det/ActionEliminarDetalleViatico.php',parametros:'&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion},
		Save:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php',parametros:'&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion},
		ConfirmSave:{url:direccion+'../../../control/cuenta_doc_det/ActionGuardarDetalleViatico.php',parametros:'&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'55%',
		columnas:acolumnas,
		width:'70%',
		minWidth:350,
		minHeight:400,	
		closable:true,
		titulo:'Detalle Gastos',
		grupos:agrupos	
		}};

	//-------------- Sobrecarga de funciones --------------------//

	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));

		maestro.id_cuenta_doc_rendicion=datos.m_id_cuenta_doc_rendicion;
		maestro.nit=datos.m_nit;
		maestro.razon_social=datos.m_razon_social;
		maestro.fecha_documento=datos.m_fecha_documento;
		maestro.importe_total=datos.m_importe_total;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.sw_viatico=datos.m_sw_viatico;
		maestro.id_cuenta_doc=datos.m_id_cuenta_doc;
		maestro.tipo_cuenta_doc=datos.m_tipo_cuenta_doc;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cuenta_doc_rendicion:maestro.id_cuenta_doc_rendicion
			}
		};
		this.btnActualizar();
		data_maestro=[['Nro.Documento',maestro.nro_documento],['Razï¿½n social',maestro.razon_social],['Fecha documento',maestro.fecha_documento],['Importe factura',maestro.importe_total],['Moneda',maestro.desc_moneda]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_cuenta_doc_rendicion;

		paramFunciones.btnEliminar.parametros='&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion;
		paramFunciones.Save.parametros='&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion;
		paramFunciones.ConfirmSave.parametros='&m_id_cuenta_doc_rendicion='+maestro.id_cuenta_doc_rendicion;
		maestro.solo_lectura=datos.m_solo_lectura;
		
		if(maestro.solo_lectura=='3'){
			
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('nuevo-'+idContenedor).disable();
		}
		else{
			
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
			CM_getBoton('nuevo-'+idContenedor).enable();
			
		}
		this.InitFunciones(paramFunciones);
	};

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for (var i=0;i<Atributos.length;i++)
		{			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
			
		componentes[2].on('select',evento_parametro); //salta al seleccionar la gestion
		componentes[3].on('select',evento_presupuesto);   //cuando selecciono un presupuesto salta el evento		
		if(maestro.sw_viatico=='si'){
			
			componentes[13].on('select',obtenerImporte);
			componentes[14].on('select',obtenerImporte);
			componentes[15].on('blur',obtenerImporte);
			componentes[16].on('blur',obtenerImporte);	
			componentes[5].setDisabled(true);
			ClaseMadre_getComponente('via').on('select',filtrar_cobertura);
		}
		
	}
		
	
	function evento_parametro( combo, record, index )
	{		
			//Filtramos los presupuestos segun la gestion seleccionada
			componentes[3].store.baseParams={id_parametro:record.data.id_parametro};
			componentes[3].modificado=true;			
			componentes[3].setValue('');			
			componentes[3].setDisabled(false);												
 	}

	function evento_presupuesto( combo, record, index )
	{	
		componentes[4].store.baseParams={};
		componentes[4].setValue();
		if(maestro.tipo_cuenta_doc=='rendicion_viatico')
			componentes[4].store.baseParams={sw_tesoro:6,m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional, m_id_presupuesto:record.data.id_presupuesto};
		else if(maestro.tipo_cuenta_doc=='rendicion_avance')
			componentes[4].store.baseParams={sw_tesoro:4,m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional, m_id_presupuesto:record.data.id_presupuesto};
		else if(maestro.tipo_cuenta_doc=='solicitud_efectivo')
			componentes[4].store.baseParams={sw_tesoro:5,m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional, m_id_presupuesto:record.data.id_presupuesto};
		else
			componentes[4].store.baseParams={m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional, m_id_presupuesto:record.data.id_presupuesto};
		componentes[4].modificado=true;
		componentes[4].setDisabled(false);								
 	}
	function filtrar_cobertura(combo,record, index)
	{		//alert(record.data.ID);
		//componentes[10].setValue();
		ClaseMadre_getComponente('id_cobertura').store.baseParams={via:record.data.ID,nuevo:'si'};
	
	
		componentes[14].modificado=true;
		componentes[14].setDisabled(false);
		
	}
 	function obtenerImporte(combo,record,index){
		
		if(componentes[13].getValue()=='' || componentes[14].getValue()=='' || componentes[15].getValue()=='' || componentes[16].getValue()==''){
			
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
			parametros={fecha_ini:componentes[15].getValue().dateFormat('m-d-Y'),
							id_cobertura:componentes[14].getValue(),id_tipo_destino:componentes[13].getValue(),fecha_fin:componentes[16].getValue().dateFormat('m-d-Y'),
								id_cuenta_doc:maestro.id_cuenta_doc};
			
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
			
			if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1')
			{
				componentes[5].setValue(root.getElementsByTagName('monto')[0].firstChild.nodeValue);
			}
			else if(root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='-2')
			{
				Ext.MessageBox.alert('Alerta','La fecha final no puede ser anterior a la fecha inicio');
			}
			else
			{ 
			
				Ext.MessageBox.alert('Alerta','No se puede obtener el importe para la cobertura y categoría seleccionados. Por favor revise la categoria seleccionada en la cabecera de la solicitud');
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
	

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	
	if(maestro.solo_lectura=='3'){
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('nuevo-'+idContenedor).disable();
	}
	else{
		CM_getBoton('editar-'+idContenedor).enable();
		CM_getBoton('eliminar-'+idContenedor).enable();
		CM_getBoton('nuevo-'+idContenedor).enable();
		
	}
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_cuenta_doc_rendicion:maestro.id_cuenta_doc_rendicion
		}
	});


	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	layout.getVentana(idContenedor).on('resize',function(){layout.getLayout().layout()})

}