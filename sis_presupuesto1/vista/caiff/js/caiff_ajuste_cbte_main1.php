<?php 
/**
 * Nombre:		  	    caiff_cbte_ajuste_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_caiff_cbte_ajuste(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_caiff_cbte_ajuste_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 */
function pagina_caiff_cbte_ajuste(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarRegistroComprobante.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[	'id_comprobante',
		'id_parametro',
		'desc_parametro',
		'nro_cbte',
		'momento_cbte',
		{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
		'concepto_cbte',
		'glosa_cbte',
		'acreedor',
		'aprobacion',
		'conformidad',
		'pedido',
		'id_periodo_subsis',
		'desc_periodo',
		'id_usuario',
		'desc_usuario',
		'id_subsistema',
		'desc_subsistema',
		'id_cbte_clase',
		'desc_clase',
		'id_moneda',
		'desc_moneda',
		'id_gestion',
		'nombre_depto',
		'id_depto',
		'titulo_cbte',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
		'id_moneda_cbte',
		'tipo_cambio',
		'nombre_moneda_cbte',
		'prioridad_moneda_cbte',
		'estado_cbte',
		'id_usuario_mod',
		'fk_comprobante',
		'fk_desc_cbte',
		'tipo_relacion',
		'desc_cbte',
		'sw_activo_fijo',
		'cbtes_depen','variacion_tc'
		]),
		
		baseParams:{m_sw_vista:'caiff_ajuste'},
		remoteSort:true});
		
	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});*/
	
	/*var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/interfaz_siet/ActionListarComprobanteFal.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},
	['id_comprobante','nro_cbte','concepto_cbte'
	,'desc_clase','glosa_cbte','desc_parametro'
	,'acreedor','desc_subsistema'
	])
	//,baseParams:{m_vista_siet:'caiff_cbte_ajuste',id_siet_declara:maestro.id_siet_declara}
	});
*/
	/*function render_id_comprobante(value, p, record){return String.format('{0}', record.data['nro_cbte']);}
	var tpl_id_comprobante=new Ext.Template('<div class="search-item">'
		,'<b>Comprobante: </b><FONT COLOR="#B5A642">{nro_cbte} {concepto_cbte}</FONT><br>',
		'<b>Acreedor: </b><FONT COLOR="#B5A642">{acreedor}</FONT><br>',
		'<b>Clase: </b><FONT COLOR="#B5A642">{desc_clase}</FONT><br>',
		'<b>Subsistema: </b><FONT COLOR="#B5A642">{desc_subsistema}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>','</div>');
	*/
	function render_fk_cbte(value, p, record){return String.format('{0}', record.data['fk_desc_cbte']);}
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	
	function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
	
	function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
	
	function render_id_cbte_clase(value, p, record){return String.format('{0}', record.data['desc_clase']);}
	
	function render_id_periodo_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']+' - '+record.data['desc_periodo']);}
	
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
		
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda_cbte']);}
			
	function render_id_tipo_cambioOCV(value, p, record){rf = ds_tipo_cambioOCV.getById(value);}
		
	function render_id_usuario_mod(value, p, record){return String.format('{0}', record.data['desc_usuario_mod']);}
	//FIN RCM

	function render_momento(value, p, record)
	{	if(value==0){return 'Contable';}
		if(value==1||value==3){return 'Devengado';}
		if(value==4){return 'Pagado o Percibido';}
		if(value==5){return 'Reversion Devengado';}
		if(value==6){return 'Reversion Pagado o Percibido';	}
		if(value==7){return 'Ajustar Devengado';	}
		if(value==8){return 'Ajustar Pagado o Percibido';	}
	}	
	function render_sw_activo_fijo(value, p, record)
	{	if(value=='si'){return 'SI';}
		if(value=='no'){return 'NO';}
	}
	
	function render_tipo_relacion(value, p, record)
	{	if(value=='pagado_del_devengado'){return 'Pagado del Devengado';}
		if(value=='pagado_del_devengado_y_ajuste'){return 'Pagado del Devengado y Ajuste';}
		if(value=='ajuste'){return 'Ajuste';}
		if(value=='dependiente'){return 'Dependiente';}
	}
	
	function render_cbtes_depen(value,cell,record,row,colum,store){
		if(store.getAt(row).data['cbtes_depen'] > 0){
		return  '<span style="color:red;">' + value +'</span>'}	
		if(store.getAt(row).data['cbtes_depen'] == 0){return  value }
	 
	}	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprobante',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			id_grupo:0,
			filtro_0:false,
			save_as:'id_comprobante'
		};
		
		Atributos[1]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Identificador',
				name: 'id_comprobante',
				allowBlank:true,
				maxLength:70,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				renderer: render_cbtes_depen,
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: false,
			id_grupo:1,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.id_comprobante'
		};
		
		// txt id_parametro
		Atributos[2]={
			validacion:{
				name:'id_parametro',
				fieldLabel:'Gestion',
				allowBlank:false,
				emptyText:'Gestion...',
				desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_parametro,
				valueField: 'id_parametro',
				displayField: 'gestion_conta',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:true,
				//tpl:tpl_id_parametro,
				forceSelection:true,
				align:'center',
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
				renderer:render_id_parametro,
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:150,
				disabled:false,
				grid_indice:3

			},
			tipo:'ComboBox',
			form: false,
			id_grupo:1,
			//filtro_0:true,
			//filterColValue:'PARAM.gestion_conta',
			save_as:'id_parametro'
		};

		Atributos[3]={
			validacion:{
				name:'id_periodo_subsis',
				fieldLabel:'Periodo SubSistema',
				allowBlank:false,
				emptyText:'Periodo Subsistema...',
				desc: 'desc_periodo', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_periodo_subsistema ,
				valueField: 'id_periodo_subsistema',
				displayField: 'desc_periodo',
				queryParam: 'filterValue_0',
				filterCol:'PERSIS.desc_periodo',
				typeAhead:true,
				//tpl:tpl_id_periodo_subsistema,
				forceSelection:true,
				//mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_periodo_subsistema,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:150,
				disabled:false,
				//grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			//filtro_0:true,
			//filterColValue:'PERSUB.estado_periodo',
			//id_grupo:1,
			save_as:'id_periodo_subsis'
		};

		// txt fecha_cbte
		Atributos[4]= {
			validacion:{
				name:'fecha_cbte',
				fieldLabel:'Fecha Registro',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				align:'center',
				disabledDaysText: 'Dia no valido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:90,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.fecha_cbte',
			dateFormat:'m-d-Y',
			id_grupo:1,
			defecto:new Date(),
			save_as:'fecha_cbte'
		};
		// txt nro_cbte
		Atributos[5]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Numero',
				name: 'nro_cbte',
				allowBlank:true,
				allowDecimals:false,
				maxLength:70,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:'100%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'NumberField',
			form: true,
			id_grupo:1,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.nro_cbte',
			save_as:'nro_cbte'
		};

		// txt id_subsistema
		Atributos[6]={
			validacion:{
				name:'id_subsistema',
				fieldLabel:'Subsistema',
				allowBlank:true,
				emptyText:'Subsistema...',
				desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_subsistema,
				valueField: 'id_subsistema',
				displayField: 'nombre_corto',
				queryParam: 'filterValue_0',
				filterCol:'SUBSIS.codigo#SUBSIS.nombre_corto',
				typeAhead:true,
				//tpl:tpl_id_subsistema,
				forceSelection:true,
				//mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
			    renderer:render_id_subsistema,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			//defecto:g_id_subsistem_contabilidad,
			id_grupo:1,
			filterColValue:'SUBSIS.codigo',
			save_as:'id_subsistema'
		};

		// txt id_documento_nro
		Atributos[7]={
			validacion:{
				name:'id_cbte_clase',
				fieldLabel:'Comprobante de',
				allowBlank:false,
				emptyText:'Comprobante de...',
				desc: 'desc_clase', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_cbte_clase,
				valueField: 'id_clase_cbte',
				displayField: 'desc_clase',
				queryParam: 'filterValue_0',
				filterCol:'CBCLAS.desc_clase',
				typeAhead:true,
				//tpl:tpl_id_cbte_clase,
				forceSelection:true,
				//mode:'remote',
				queryDelay:280,
				pageSize:5,
				minListWidth:280,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_cbte_clase,
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:280,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CBCLAS.desc_clase',
			save_as:'id_clase_cbte'
		};
		Atributos[8]={
			validacion:{
				name:'momento_cbte',
				fieldLabel:'Momento',
				allowBlank:false,
				align:'left',
				emptyText:'Momento...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['0','Contable'],['1','Devengado'],['4','Pagado o Percibido'],['5','Reversion Devengado'],['6','Reversion Pagado o Percibido'],['7','Ajustar Devengado'],['8','Ajustar Pagado o Percibido']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_momento,
				grid_editable:false,
				width_grid:120,
				minListWidth:200,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			save_as:'momento_cbte'
		};

		// txt acreedor
		Atributos[9]={
			validacion:{
				name:'acreedor',
				fieldLabel:'Acreedor',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.acreedor',
			save_as:'acreedor'
		};
		// txt aprobacion
		Atributos[10]={
			validacion:{
				name:'aprobacion',
				fieldLabel:'Aprobacion',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.aprobacion',
			save_as:'aprobacion'
		};
		// txt conformidad
		Atributos[11]={
			validacion:{
				name:'conformidad',
				fieldLabel:'Conformidad',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.conformidad',
			save_as:'conformidad'
		};
		// txt pedido
		Atributos[12]={
			validacion:{
				name:'pedido',
				fieldLabel:'Pedido',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.pedido',
			save_as:'pedido'
		};

		// txt concepto_cbte
		Atributos[13]={
			validacion:{
				name:'concepto_cbte',
				fieldLabel:'Concepto',
				allowBlank:false,
				maxLength:1500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.concepto_cbte',
			save_as:'concepto_cbte'
		};
		// txt glosa_cbte
		Atributos[14]={
			validacion:{
				name:'glosa_cbte',
				fieldLabel:'Observacion',
				allowBlank:true,
				maxLength:1500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.glosa_cbte',
			save_as:'glosa_cbte'
		};

		//id_depto
		Atributos[15]={
			validacion:{
				name:'id_depto',
				fieldLabel:'Departamento Contable',
				//allowBlank:false,
				allowBlank:true,
				emptyText:'Departamento...',
				desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_depto,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO.id_depto#DEPTO.nombre_depto',
				typeAhead:false,
				//tpl:tpl_id_depto,
				forceSelection:true,
				//mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'80%',
				//	onSelect:function(record){},
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto,
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				width:280,
				disabled:false,
				grid_indice:4
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'dep.nombre_depto',
			save_as:'id_depto'
		};

		Atributos[16]={
			validacion:{
				name:'desc_usuario',
				fieldLabel:'Usuario',
				allowBlank:true,
				maxLength:1500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea'
			
		};
		
		Atributos[17]={
			validacion:{
				name:'id_moneda_cbte',
				fieldLabel:'Moneda',
				allowBlank:true,
				emptyText:'Moneda...',
				desc: 'nombre_moneda_cbte', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:false,
				//tpl:tpl_id_moneda_reg,
				forceSelection:true,
				//mode:'remote',
				queryDelay:200,
				pageSize:10,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:false,
				width_grid:105,
				width:150,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			defecto:1,
			filterColValue:'monedacbte.nombre',
			save_as:'id_moneda_cbte'
		};
		Atributos[18]={
			validacion:{
				name:'id_tipo_cambio',
				fieldLabel:'T/C Origen',
				allowBlank:true,
				emptyText:'T/C...',
				desc: 'desc_tc', //indica la columna del store principal ds del que proviane la descripcion
				//store:ds_tipo_cambioOCV,
				valueField: 'tc_origen',
				displayField: 'desc_tc',
				queryParam: 'filterValue_0',
				//filterCol:'MONEDA.nombre',
				typeAhead:false,
				//tpl:tpl_id_tipo_cambioOCV,
				forceSelection:true,
				//mode:'remote',
				queryDelay:200,
				pageSize:10,
				minListWidth:350,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_tipo_cambioOCV,
				grid_visible:false,
				grid_editable:true,
				width_grid:150,
				width:280,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false
		};
		Atributos[19]={
			validacion:{
				name:'tipo_cambio',
				fieldLabel:'Tipo Cambio',
				allowBlank:true,
				align:'right',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:10,//para numeros float
				allowNegative:false,
				allowMil:true,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				//renderer:render_moneda_16,
				width_grid:80,
				width:100,
				disabled:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'COMPRO.tipo_cambio',
			save_as:'tipo_cambio'
		};

		Atributos[20]={
			validacion:{
				name:'id_usuario_mod',
				fieldLabel:'Usuario Responsable Modificacion',
				allowBlank:true,
				emptyText:'Nombre...',
			//	store:ds_usuario_mod,
				valueField:'id_usuario',
				displayField:'nombre_completo',
				queryParam:'filterValue_0',
				filterCol:'nombre_completo',
				typeAhead:false,
				//tpl:tpl_id_usuario_mod,
				forceSelection:false,
				//mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				width:200
			},
			form: true,
			tipo:'ComboBox'			
		};

		Atributos[21]={
			validacion:{
				name:'estado_cbte',
				fieldLabel:'Estado',
				width_grid:50,
				grid_editable:false,
				grid_visible:true
			},
			tipo:'Field',
			form:false
			
		};
		Atributos[22]={
				validacion:{
					name:'justificacion_edicion',
					fieldLabel:'Justificacion',
					allowBlank:true,
					maxLength:500,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:false,
					grid_editable:false,
					width_grid:100,
					width:'100%',
					disabled:false
				},
				tipo: 'TextArea',
				
				form: true,
			};
		 
		Atributos[23]={
				validacion:{
					name:'fk_comprobante',
					fieldLabel:'Ajuste o Devengado',
					allowBlank:true,
					emptyText:'Ajuste...',
					desc: 'fk_desc_cbte', //indica la columna del store principal ds del que proviane la descripcion
					//store:ds_cbte,
					valueField: 'id_comprobante',
					displayField: 'desc_cbte',
					queryParam: 'filterValue_0',
					filterCol:'COMPRO.nro_cbte#COMPRO.momento_cbte#COMPRO.fecha_cbte#COMPRO.concepto_cbte#COMPRO.glosa_cbte#COMPRO.acreedor#COMPRO.aprobacion#COMPRO.conformidad#COMPRO.pedido',
					typeAhead:false,
					//tpl:tpl_fk_id_cbte,
					forceSelection:true,
					//mode:'remote',
					queryDelay:300,
					pageSize:10,
					minListWidth:300,
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_fk_cbte,
					grid_visible:true,
					grid_editable:false,
					width_grid:150,
					width:280,
					disabled:false
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filtro_1:true,
		 		filterColValue:'compro.fk_comprobante',
				
				save_as:'fk_comprobante'
			};
		
		Atributos[24]={
				validacion:{
					name:'tipo_relacion',
					fieldLabel:'Tipo Relacion',
					allowBlank:true,
					align:'left',
					emptyText:'Tipo Relaci...',
					loadMask:true,
					maxLength:50,
					minLength:0,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['pagado_del_devengado','pagado_del_devengado'],['pagado_del_devengado_y_ajuste','pagado_del_devengado_y_ajuste'],['ajuste','ajuste']]}),
					displayField:'valor',
					mode:'local',
					lazyRender:true,
					forceSelection:true,
					grid_visible:true,
					renderer:render_tipo_relacion,
					grid_editable:false,
					width_grid:100,
					minListWidth:200,
					disabled:false
				},
				tipo:'ComboBox',
				form: true,
				
				save_as:'tipo_relacion'
			};
		Atributos[25]={
			validacion:{
				name:'sw_activo_fijo',
				fieldLabel:'Activo Fijo',
				allowBlank:true,
				align:'left',
				emptyText:'Activo Fijo...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','SI'],['no','NO']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_sw_activo_fijo,
				grid_editable:false,
				width_grid:100,
				minListWidth:200,
				width:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
		 	filterColValue:'compro.sw_activo_fijo',
		
			save_as:'sw_activo_fijo'
		}; 
		
		Atributos[26]={
			validacion:{
				labelSeparator:'',
				name: 'cbtes_depen',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			
			filtro_0:false,
			save_as:'cbtes_depen'
		};
		
		//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	/*var config = {
		titulo_maestro:'caiff_cbte_ajuste',
		grid_maestro:'grid-'+idContenedor
	};*/
	var config={titulo_maestro:'comprobante_caiff',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_presupuesto/vista/caiff/caiff_ajuste_transac.php?idSub='+decodeURI('Transaccion Detalle')+'&'};
	var layout_caiff_cbte_ajuste=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_caiff_cbte_ajuste.init(config);
	


	
	/*layout_caiff_cbte_ajuste=new DocsLayoutMaestro(idContenedor);
	layout_caiff_cbte_ajuste.init(config);*/

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caiff_cbte_ajuste,idContenedor);
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
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php'},
		Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbte.php'},
		ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbte.php'},
		Formulario:{
			titulo:'caiff_cbte_ajuste',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'48%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
/*	function btn_solicitud_compra_det(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();
		var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
            //alert(maestro.id_parametro);
			var data='m_id_caiff_cbte_ajuste='+SelectionsRecord.data.id_caiff_cbte_ajuste;
			    data=data+'& m_id_siet_declara='+SelectionsRecord.data.id_siet_declara;		
			    data=data+'& m_id_parametro='+maestro.id_parametro;		
			    
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.id_subsistema==9){
					layout_caiff_cbte_ajuste.loadWindows(direccion+'../../../../sis_presupuesto/vista/interfaz_siet/caiff_cbte_ajuste_partida.php?'+data,'Detalle de Partidas',ParamVentana);
			    	layout_caiff_cbte_ajuste.getVentana().on('resize',function(){
					layout_caiff_cbte_ajuste.getLayout().layout();
				})
			}else{
				Ext.MessageBox.alert('Estado', 'Solo Cbtes de Contabilidad pueden acceder a esta función');
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_reporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff_cbte_ajuste='+SelectionsRecord.data.id_caiff_cbte_ajuste;	
		        data=data+'&id_siet_declara='+SelectionsRecord.data.id_siet_declara;				
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
*/
/***********************************************************************REPORTE X oec*************************/
/*	function btn_reporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_caiff_cbte_ajuste='+SelectionsRecord.data.id_caiff_cbte_ajuste;	
		        data=data+'&id_siet_declara='+SelectionsRecord.data.id_siet_declara;				
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	*/
	/*******************************************FIN REPORTE X OEC*********************************/
	
/*	this.reload=function(m)
	{
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara,
				m_id_parametro:maestro.id_parametro	,
				m_tipo_declara:maestro.tipo_declara				
			}
		};
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);

		
		ds_comprobante.baseParams={
				id_siet_declara:maestro.id_siet_declara,
				m_vista_siet:'caiff_cbte_ajuste'
		}
		Atributos[1].defecto=maestro.id_siet_declara;
		Atributos[11].defecto=maestro.id_gestion;
	};
		*/

	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caiff_cbte_ajuste.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};

	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
   // this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','');
	
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el relacionamiento de cbtes y partidas',btn_reporte,true,'imp_ejecucion','Reporte');
	
	
	this.iniciaFormulario();
	layout_caiff_cbte_ajuste.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}