<?php
/**
 * Nombre:		  	    registro_documento_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
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
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var maestro={
	id_transaccion:<?php echo $m_id_transaccion;?>,
	desc_comprobante:'<?php echo ($m_desc_comprobante);?>',
	concepto_tran:'<?php echo ($m_concepto_tran);?>',
	desc_cuenta:'<?php echo ($m_desc_cuenta);?>',
	desc_auxiliar:'<?php echo ($m_desc_auxiliar);?>',
	desc_partida:'<?php echo ($m_desc_partida);?>',
	id_moneda:<?php echo ($m_id_moneda);?>,
	desc_moneda:'<?php echo ($m_desc_moneda);?>',
	id_parametro:<?php echo ($m_id_parametro);?>,
	importe_debe:<?php echo ($m_importe_debe);?>,
	importe_haber:<?php echo($m_importe_haber);?>

};

var idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento;
elemento={idContenedor:idContenedor,pagina:new pagina_registro_documentoCCf(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};


//else { elemento={idContenedor:idContenedor,pagina:new pagina_registro_documento(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};}

_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_registro_documento.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:13
 */
function pagina_registro_documentoCCf(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{ 
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var componentes_grid=new Array();
	var grid;	
	var var_record;	
	var txt_id_transaccion;
	var txt_tipo_documento;
	var txt_nro_nit;	
	var txt_nro_documento;	
	var txt_nro_autorizacion;	
	var txt_codigo_control;	
	var txt_razon_social;	
	var txt_importe_total;	
	var	txt_importe_ice;	
	var	txt_importe_no_gravado;	
	var	txt_importe_sujeto;	
		
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','tipo','nro_linea','desc_plantilla'])});
  	var monedas_for=new Ext.form.MonedaField({name:'monto',fieldLabel:'monto', allowBlank:false,align:'right', maxLength:50,minLength:0,selectOnFocus:true,allowDecimals:true,	decimalPrecision:2,allowNegative:false,minValue:0,});
  	
  	var Documento = Ext.data.Record.create(['id_documento','desc_plantilla','tipo_documento','nro_nit','nro_documento',
  	'nro_autorizacion','codigo_control','razon_social',{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},'importe_total','importe_ice',
  	'importe_no_gravado','importe_sujeto','importe_credito','id_moneda','nombre','importe_debito','importe_iue','importe_it','estado_documento'
//2016
,'importe_descuento','importe_exportaciones','importe_ventas_gravadas_tasa_0','tipo_compra'


  	]);
	
  	var ds = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarRegistroDocumento.php'}),
  	reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_documento',	totalRecords: 'TotalCount'}, Documento),baseParams:{m_id_moneda:maestro.id_moneda},remoteSort:true});

 	var tpl_id_plantilla=new Ext.Template('<div class="search-item">','<b>Tipo: </b><FONT COLOR="#B5A642">{tipo_plantilla}</FONT> ><b> Plantilla: </b><FONT COLOR="#B5A642">{desc_plantilla}</FONT>','<br>','</div>');
	function render_id_plantilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function render_estado_documento(value, p, record){
		if(value==2){return 'VIGENTE';}
		if(value==3){return 'ANULADO';}
		if(value==4){return 'N/APLICAR';}
	}	
	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[['Comprobante ',maestro.desc_comprobante],['Transacción ',maestro.concepto_tran],
		['Cuenta-Partida ',maestro.desc_cuenta],['Auxiliar ',maestro.desc_auxiliar]
	];
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?'}),		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
	
	ds_parametro.load({params:{start:0,limit: 1,CantFiltros:1,m_id_parametro:maestro.id_parametro,m_sw_reg_documento:'si'}});
	
	

	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_reg_comp:'si'}
	});

	//FUNCIONES RENDER
	function render_id_moneda(value, p, record){rf = ds_moneda.getById(value);if(rf!=null){record.data['nombre'] =rf.data['nombre'];}return String.format('{0}', record.data['nombre'])	}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');	

	function renderMoneda(value,cell,record,row,colum,store){ return monedas_for.formatMoneda(value) }
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_documento
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};
	
	//  tipo_documento 
	Atributos[1]={
		validacion:{
			name:'tipo_documento',
			fieldLabel:'Tipo Documento',
			allowBlank:false,			
			emptyText:'Documento...',
			desc: 'desc_plantilla', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_plantilla,
			valueField: 'tipo_plantilla',
			displayField: 'desc_plantilla',
			queryParam: 'filterValue_0',
			filterCol:' PLANT.tipo_plantilla#PLANT.desc_plantilla',
			typeAhead:false,
			tpl:tpl_id_plantilla,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_plantilla,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'tipo_documento',
 		save_as:'tipo_documento'
	};	

	// txt nro_nit
	Atributos[2]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit',
		save_as:'nro_nit'
	};
	
	// txt nro_documento
	Atributos[3]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nro.Documento',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento',
		save_as:'nro_documento'
	};
	
	// txt nro_autorizacion
	Atributos[4]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Nro.Autorización',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	
	// txt codigo_control
	Atributos[5]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código Control',
			allowBlank:true,
			maxLength:14,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			regex: /^((([0-9]|[a-z])([a-z]|[0-9])-){3}([0-9]|[a-z])([a-z]|[0-9])(-([0-9]|[a-z])([a-z]|[0-9]))?)$/i,
			maskRe: /[\d\s-abcdef]/i,
			invalidText: 'Código inválido. Formato correcto "1b-df-14-10-2d"'
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control',
		save_as:'codigo_control'
	};
	
	// txt razon_social
	Atributos[6]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		save_as:'razon_social'
	};

	// txt fecha_documento
	Atributos[7]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha',
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
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y',
		defecto: new Date(),
		save_as:'fecha_documento'
	};
	 
	// txt id_moneda
	Atributos[8]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	

	//01-2016

	Atributos[11]={
		validacion:{
			name:'importe_descuento',
			fieldLabel:'Importe Descuento',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		defecto:0,
		filterColValue:'DOCVAL.importe_descuento',
		save_as:'importe_descuento'
	};

	Atributos[10]={
			validacion:{
				name:'importe_exportaciones',
				fieldLabel:'Importe Exportaciones',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:true,
				//renderer: renderMoneda,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			//tipo: 'MonedaField',
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			defecto:0,
			filterColValue:'DOCVAL.importe_exportaciones',
			save_as:'importe_exportaciones'
		};
	
	Atributos[12]={
			validacion:{
				name:'importe_ventas_gravadas_tasa_0',
				fieldLabel:'Venta Gravada Tasa 0',
				allowBlank:true,
				maxLength:50,
				align:'right', 
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:true,
				//renderer: renderMoneda,
				width_grid:100,
				width:'100%',
				disabled:false		
			},
			//tipo: 'MonedaField',
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			defecto:0,
			filterColValue:'DOCVAL.importe_ventas_gravadas_tasa_0',
			save_as:'importe_ventas_gravadas_tasa_0'
		};
	
	Atributos[9]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Documento',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		defecto:0,
		filterColValue:'DOCVAL.importe_total',
		save_as:'importe_total'
	};
 
	Atributos[13]={
		validacion:{
			name:'importe_ice', 
			fieldLabel:'ICE',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		defecto:0,
		form: true,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_ice',
		save_as:'importe_ice'
	};
	
	Atributos[14]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe no Gravado',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_no_gravado',
		save_as:'importe_no_gravado'
	};
	
	Atributos[15]={
		validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Sujeto a Impuesto',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:true		
		},
	 	//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		defecto:0,
		filterColValue:'DOCVAL.importe_sujeto',
		save_as:'importe_sujeto'
	};
	
 	Atributos[16]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'Importe Crédito',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_credito',
		save_as:'importe_credito'
	};
 	
	Atributos[17]={
		validacion:{
			name:'importe_debito',
			fieldLabel:'Importe Debito',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_debito',
		save_as:'importe_debito'
	};

	Atributos[18]={
		validacion:{
			name:'importe_iue',
			fieldLabel:'Importe I.U.E.',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_iue',
		save_as:'importe_iue'
	};
	Atributos[19]={
		validacion:{
			name:'importe_it',
			fieldLabel:'Importe I.T.',
			allowBlank:true,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderMoneda,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		//tipo: 'MonedaField',
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'DOCVAL.importe_it',
		save_as:'importe_it'
	};
		
	Atributos[20]={
		validacion:{
			name:'estado_documento',
			fieldLabel:'Estado',
			allowBlank:false,
			align:'left',
			emptyText:'Estado...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['3','ANULADO'],['2','VIGENTE'],['4','N/APLICAR']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			renderer:render_estado_documento,
			grid_editable:false,
			width_grid:200,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filterColValue:'DOCUME.estado_documento',
		save_as:'estado_documento'
	}; 


	
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Transsación (Maestro)',titulo_detalle:'Documento con Credito Fiscal (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_documento = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_registro_documento.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_registro_documento,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var getCM=this.getColumnModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnEdit =this.btnEdit;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};

	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/documento/ActionEliminarRegistroDocumento.php',parametros:'&id_transaccion='+maestro.id_transaccion},
	Save:{url:direccion+'../../../control/documento/ActionGuardarRegistroDocumento.php',parametros:'&m_sw_documento=si&id_transaccion='+maestro.id_transaccion+'&tipo_documento='+maestro.tipo_plantilla},
	ConfirmSave:{url:direccion+'../../../control/documento/ActionGuardarRegistroDocumento.php',parametros:'&m_sw_documento=si&id_transaccion='+maestro.id_transaccion+'&tipo_documento='+maestro.tipo_plantilla},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480/*,minWidth:150,minHeight:200*/,	closable:true,titulo:'registro_documento'}};

	function MaestroJulio(data){
		var mayor=0;		
		var j;
		
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		
		html=html+"</tr>";
		for(j=0;j<data.length;j++){
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
			
			for(i=0;i<data[j].length;i++){
				if(data[j]){
					if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
			}
			html=html+"</tr>";
		}
		html=html+"</table>";
		 
		return html
	};		
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){ 
		var datos=Ext.urlDecode(params);
		//var datos=Ext.urlDecode(decodeURIComponent(params));
	    //var datos=params;
	
		maestro.id_transaccion=datos.m_id_transaccion;
		maestro.tipo_plantilla=datos.m_tipo_plantilla;
		maestro.desc_plantilla=datos.m_desc_plantilla;
		maestro.desc_comprobante=datos.m_desc_comprobante;
		maestro.concepto_tran=datos.m_concepto_tran;
		maestro.desc_cuenta=datos.m_desc_cuenta;
		maestro.desc_auxiliar=datos.m_desc_auxiliar;
		maestro.desc_partida=datos.m_desc_partida;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.desc_moneda=datos.m_desc_moneda;
		
		this.getBotonNombre('monedas').setValue(maestro.id_moneda);	

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_transaccion:maestro.id_transaccion,
				m_sw_reg_documento:'si',
				m_id_moneda:maestro.id_moneda
			},
			callback: function(){
			 	 if(ds.getTotalCount()==0){insertarRegistro(0)} 
			}
		};
		
		this.btnActualizar();
			
		var data_maestro=[['Comprobante ',maestro.desc_comprobante],['Transacción ',maestro.concepto_tran],
		                  ['Cuenta-Partida ',maestro.desc_cuenta],['Auxiliar ',maestro.desc_auxiliar]];
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		paramFunciones.btnEliminar.parametros='&id_transaccion='+maestro.id_transaccion;
		paramFunciones.Save.parametros='&m_sw_documento=si&id_transaccion='+maestro.id_transaccion+'&tipo_documento='+maestro.tipo_plantilla;
		paramFunciones.ConfirmSave.parametros='&m_sw_documento=si&id_transaccion='+maestro.id_transaccion+'&tipo_documento='+maestro.tipo_plantilla;
	 	
		this.InitFunciones(paramFunciones)
	};
	
	var padre=this; 	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		getSelectionModel().on('rowselect',function( SM,rowIndex){
		var_record=SM.getSelected();
	})
		
	}
	
	function InitRegistroDocumento(){ 
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		
		
		formulario=ClaseMadre_getFormulario();
		txt_id_transaccion=	ClaseMadre_getComponente('id_transaccion');	
		txt_tipo_documento=	ClaseMadre_getComponente('tipo_documento');	
		txt_nro_nit=	ClaseMadre_getComponente('nro_nit');	
		txt_nro_documento=	ClaseMadre_getComponente('nro_documento');	
		txt_nro_autorizacion=	ClaseMadre_getComponente('nro_autorizacion');	
		txt_codigo_control=	ClaseMadre_getComponente('codigo_control');	
		txt_razon_social=	ClaseMadre_getComponente('razon_social');	
		
		txt_importe_total=	ClaseMadre_getComponente('importe_total');	
		txt_importe_ice=	ClaseMadre_getComponente('importe_ice');	
		txt_importe_no_gravado=	ClaseMadre_getComponente('importe_no_gravado');	
		txt_importe_sujeto=	ClaseMadre_getComponente('importe_sujeto');	

		//2016
		txt_importe_descuento=	ClaseMadre_getComponente('importe_descuento');	
		txt_importe_exportaciones=	ClaseMadre_getComponente('importe_exportaciones');	
		txt_importe_ventas_gravadas_tasa_0=ClaseMadre_getComponente('importe_ventas_gravadas_tasa_0');
		//fin 2016
		

		
		txt_tipo_documento.on('select',filtrarCamposDocumento); 
		txt_importe_total.on('blur',calculoImporteSujeto); 
		txt_importe_ice.on('blur',calculoImporteSujeto); 
		txt_importe_no_gravado.on('blur',calculoImporteSujeto); 
		txt_importe_descuento.on('blur',calculoImporteSujeto);
		txt_importe_exportaciones.on('blur',calculoImporteSujeto);  
		txt_importe_ventas_gravadas_tasa_0.on('blur',calculoImporteSujeto); 
		
		txt_nro_nit.on('blur',obtenerDatosProveedor);

	

		
		
		
	};

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
			
			if( root.getElementsByTagName('respuesta')[0]!=undefined &&root.getElementsByTagName('respuesta')[0].firstChild!=null &&root.getElementsByTagName('respuesta')[0].firstChild.nodeValue=='1'){
				txt_nro_autorizacion.setValue(root.getElementsByTagName('nro_autoriza')[0].firstChild.nodeValue);
				txt_razon_social.setValue(root.getElementsByTagName('razon_social')[0].firstChild.nodeValue);
			}else{
				txt_nro_autorizacion.setValue('');
				txt_razon_social.setValue('');
			}
		}
	}

	function calculoImporteSujeto(componente){
		txt_importe_sujeto.setValue(txt_importe_total.getValue()-txt_importe_ice.getValue()-txt_importe_no_gravado.getValue()
				-txt_importe_descuento.getValue()-txt_importe_exportaciones.getValue()-txt_importe_ventas_gravadas_tasa_0.getValue()
				);
	}

	

	/*function obtenerTotal(e){
		txt_importe_total.setValue(e.value);
	}*/
	//fin 2016
	function filtrarCamposDocumento(combo, record, index){
		if (record.data['tipo']==1){
			txt_nro_nit.allowBlank=false;
			CM_mostrarComponente(txt_nro_nit);
			CM_mostrarComponente(txt_nro_autorizacion);
			CM_mostrarComponente(txt_codigo_control);
			
		}else{
			txt_nro_nit.allowBlank=true;
			txt_nro_autorizacion.allowBlank=true;
			CM_ocultarComponente(txt_nro_nit);
			CM_ocultarComponente(txt_nro_autorizacion);
			CM_ocultarComponente(txt_codigo_control);
			txt_nro_nit.setValue('');
			txt_nro_autorizacion.setValue('');
			txt_codigo_control.setValue('');
			
		}
	}

	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
	});
		
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			defecto: maestro.id_moneda,
			tpl:tpl_id_moneda_reg
		});

		ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
		
		monedas.on('select', function (combo, record, index){
			ds.baseParams={};
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_transaccion:maestro.id_transaccion,
						m_sw_reg_documento:'si',
						m_id_moneda:record.data.id_moneda
			}});
		});

		function insertarRegistro(index){ alert("llega aqui");
			var p = new Documento({
			  	id_documento:0,
			  	nro_nit:0,
			  	nro_documento:0,
			  	nro_autorizacion:0,
			  	codigo_control:0,
			  	razon_social:0,
			  	fecha_documento:new Date(),
			  	importe_total:maestro.importe_debe,
			  	importe_ice:0,
			  	importe_no_gravado:0,
			  	importe_sujeto:maestro.importe_debe,
			  	importe_credito:maestro.importe_debe*ds_parametro.getAt(0).data.porcen_iva/100,
			  	id_moneda:maestro.id_moneda,
			  	importe_descuento:0, //2016
			  	nombre:maestro.desc_moneda});
		  	var_record=p;  
		  	ds.insert(index,p);
	  	}

	function btn_nuevo_grid(){
		if(ds.getAt(0)==undefined ||ds.getAt(0).data.nro_nit!=0){ 
			insertarRegistro(0);
		}
		var_record=ds.getAt(0);
	  	getSelectionModel().clearSelections();
		grid.startEditing(0,0);
	}	

	this.getLayout=function(){return layout_registro_documento.getLayout()};
	//para el manejo de hijos
	//DATA STORE COMBOS
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_transaccion:maestro.id_transaccion,
			m_sw_reg_documento:'si',
			m_id_moneda:maestro.id_moneda
			},
			callback: function(){}
	});	
	
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	InitRegistroDocumento();
	
	this.AdicionarBotonCombo(monedas,'monedas');	

	layout_registro_documento.getLayout().addListener('layout',this.onResize);
	layout_registro_documento.getVentana().addListener('beforehide',function(){ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar()})
	
}