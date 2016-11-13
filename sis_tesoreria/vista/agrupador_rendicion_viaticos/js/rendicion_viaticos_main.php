<?php 
/**
 * Nombre:		  	    rendicion_viaticos_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
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
var paramConfig={TamanoPagina:100,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_rendicion_viaticos(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_solicitud_viaticos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-12 11:42:20
 */
function pagina_rendicion_viaticos(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	//alert('llega que cagada');
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/viatico_rinde/ActionListarRendicionViaticos.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_viatico_rinde',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_viatico_rinde',
		'id_viatico',		
		'id_concepto_ingas',
		'desc_concepto_ingas',
		'importe_rendicion',
		'importe_documento',
		'tipo_documento',
		'desc_plantilla',
		'nro_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'codigo_control',
		'id_presupuesto',
        'desc_presupuesto',        
        'estado_rendicion',
        'id_transaccion',
        'id_partida_ejecucion',
        'descripcion',
        'contador'
		]),remoteSort:true});

		
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ])//,
	//baseParams:{m_nombre_vista:'rendicion_viaticos',m_id_uo:1,sw_inv_gasto:'si'}
	});
			
	var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoPartidaCuentaAux.php?sw_tesoro=3&ver_ant=si'}),   //para filtrar solo los conceptos de viaticos sw_tesoro=3
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv','desc_cuenta','desc_auxiliar' ])
	});
	
	var ds_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro'])
	});
	
	
	function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
	var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">',
		'<b>{desc_ingas_item_serv}</b><br>',
		'    Partida: <FONT COLOR="#B50000">{desc_partida}</FONT>',
		'<br>Cuenta:  <FONT COLOR="#B5A642">{desc_cuenta}</FONT>',
		'<br>Auxiliar:  <FONT COLOR="#B50000">{desc_auxiliar}</FONT>',
		'</div>');

	function render_tipo_documento(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
	//var tpl_tipo_documento=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

			
	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		/*var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<b>   Tipo Presupuesto: </b><FONT COLOR="#B5A642">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamineto: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');*/	
		
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B50000">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
		
	function renderDocumento(value, p, record)
	{
		if(value == 1){return "Compra Con Credito Fiscal"}
		if(value == 4){return "Compra Sin Credito Fiscal"}	
		if(value == 8){return "Recibo Sin Retenciones"}	
		if(value == 9){return "Recibo Retenciones Bienes"}	
		if(value == 10){return "Recibo Retenciones Servicios"}
		//return 'Otro';
	}	

	function renderEstado(value, p, record)
	{
		if(value == 1)
		{return "Verificación"}
		if(value == 2)
		{return "Comprometido"}
		if(value == 3)
		{return "Contabilizado"}
		if(value == 4)
		{return "Validado"}
		//return 'Otro';
	}
	

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_viatico_rinde
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_viatico_rinde',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
	//combo presupuesto	
     Atributos[1]={
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
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad#PROYEC.nombre_proyecto',// cone estos campos filtramos en la grilla
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	// txt id_concepto_ingas
	Atributos[2]={
			validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto',
			allowBlank:false,			
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:250,
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONING.desc_ingas',
		save_as:'id_concepto_ingas',
		id_grupo:0
	};
	
// txt importe_rendicion
	Atributos[3]={
		validacion:{
			name:'importe_documento',
			fieldLabel:'Importe Documento',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0.01,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VIARIN.importe_documento',
		id_grupo:0
	};
	
	//// PLantilla /////////
	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='PLANT.sw_tesoro';
	filterValues[0]='1';
	
	Atributos[4]={
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
			onSelect: function(record)
					{
						componentes[4].setValue(record.data.tipo_plantilla);
						componentes[4].collapse();
						
						if(record.data.tipo=='1')
						{
							CM_mostrarGrupo('Datos Factura');
							NoBlancosGrupo(2);
						}
						else
						{
							CM_ocultarGrupo('Datos Factura');
							SiBlancosGrupo(2);
						}
					},
			filterCols:filterCols,
			filterValues:filterValues,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			renderer:render_tipo_documento,
			grid_indice:3,
			width_grid:170,
			width:250
		},
		tipo:'ComboBox',
		save_as:'tipo_documento',
		filtro_0:false,
		id_grupo:1
	};
	
// txt nro_documento
	Atributos[5]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nro de Factura o Recibo',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento',
		id_grupo:1
	};
// txt fecha_documento
	Atributos[6]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha de Factura o Recibo',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:8		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y',
		defecto:'',
		id_grupo:1
	};
// txt razon_social
	Atributos[7]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razón Social',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		id_grupo:1
	};
	
// txt nro_nit
	Atributos[8]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			allowDecimals:false,
			width:'100%',
			disabled:false,
			grid_indice:8		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit',
		id_grupo:2
	};
	
// txt nro_autorizacion
	Atributos[9]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Nro Autorización',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			allowDecimals:false,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion',
		id_grupo:2
	};
	
// txt codigo_control
	Atributos[10]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:10		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control',
		id_grupo:2
	};
	
	// txt id_viatico
	Atributos[11]={
		validacion:{
			name:'id_viatico',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};		
	
	// txt estado_avance
	Atributos[12]={
		validacion:{
			name:'estado_rendicion',
			fieldLabel:'Estado Rendición',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Verificación'],['2','Comprometido'],['3','Contabilizado'],['4','Validado']]}),
			valueField:'id',
			displayField:'valor',
			renderer: renderEstado,
			lazyRender:true,
			forceSelection:true,
			width_grid:100,
			width:150,
			grid_visible:true,
			grid_indice:27,
			disabled:false		
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:false,
		defecto:1,
		id_grupo:3,
		filterColValue:'VIACAL.estado_rendicion'		
	};	

	Atributos[13]={
		validacion:{
			name:'id_transaccion',
			fieldLabel:'Id Transacción',
			allowBlank:false,
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
		tipo: 'Field',
		form: true,
		save_as:'id_transaccion',		
		id_grupo:3
	};
	
	Atributos[14]={
		validacion:{
			name:'id_partida_ejecucion',
			fieldLabel:'Id Partida Ejecución',
			allowBlank:false,
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
		tipo: 'Field',
		form: true,
		save_as:'id_partida_ejecucion',		
		id_grupo:3
	};
	
	// txt descripcion
	Atributos[15]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			//maxLength:100,
			minLength:0,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false,
			grid_indice:7		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'VIARIN.descripcion',
		id_grupo:1
	};
	
	// txt importe_rendicion
	Atributos[16]={
		validacion:{
			name:'importe_rendicion',
			fieldLabel:'Importe Líquido',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0.01,
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
		filterColValue:'VIARIN.importe_rendicion',
		id_grupo:3
	};
	
	// contador
	Atributos[17]={
		validacion:{
			name:'contador',
			fieldLabel:'Nº',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0.01,
			grid_visible:true,
			grid_editable:false,
			width_grid:40,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: false,		
		id_grupo:3
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud de Viáticos',grid_maestro:'grid-'+idContenedor};
	var layout_rendicion_viaticos=new DocsLayoutMaestro(idContenedor);
	layout_rendicion_viaticos.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_rendicion_viaticos,idContenedor);
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var cm_EnableSelect=this.EnableSelect;

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
		btnEliminar:{url:direccion+'../../../control/viatico_rinde/ActionEliminarRendicionViaticos.php'},
		Save:{url:direccion+'../../../control/viatico_rinde/ActionGuardarRendicionViaticos.php'},
		ConfirmSave:{url:direccion+'../../../control/viatico_rinde/ActionGuardarRendicionViaticos.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
			columnas:['95%'],	//,'48%'
			grupos:[{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Documento',columna:0,id_grupo:1},
			{tituloGrupo:'Datos Factura',columna:0,id_grupo:2},
			{tituloGrupo:'Oculto',columna:0,id_grupo:3}],
			height:'60%',  //alto
			width:'40%',   //ancho
			minWidth:150,
			minHeight:200,	
			closable:true,
			titulo:'Rendición de Viáticos'}};
			
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.reload=function(m)
	{
			maestro=m;			
			
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_viatico:maestro.id_viatico
				}
			};
			this.btnActualizar();
			
			Atributos[11].defecto=maestro.id_viatico;
			paramFunciones.btnEliminar.parametros='&id_viatico='+maestro.id_viatico;
			paramFunciones.Save.parametros='&id_viatico='+maestro.id_viatico;
			paramFunciones.ConfirmSave.parametros='&id_viatico='+maestro.id_viatico;
			this.InitFunciones(paramFunciones)
			
			componentes[1].store.baseParams={m_nombre_vista:'rendicion_viaticos',m_id_uo:maestro.id_unidad_organizacional,sw_inv_gasto:'si'};
			componentes[1].modificado=true;	
			
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();		
	};	
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for (var i=0;i<Atributos.length;i++)
		{			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}	
		
		componentes[1].on('select',evento_presupuesto);   //cuando selecciono un presupuesto salta el evento
		
		componentes[3].on('change',evento_importe_documento);   //cuando se coloca un importe documento salta el evento	
	}	
	
	this.EnableSelect=function(sm,row,rec)
	{
				datas_edit=rec.data;
				enable(sm,row,rec);			
	}
	
	this.btnNew = function()
	{		
		CM_ocultarGrupo('Datos Factura');
		CM_ocultarGrupo('Oculto');
		CM_btnNew();
	}
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.estado_rendicion==1)
			{	
				CM_mostrarGrupo('Datos Factura');
				CM_ocultarGrupo('Oculto');
				CM_btnEdit();
				
				componentes[16].setValue( componentes[3].getValue() );	
			}
			else
			{
				Ext.MessageBox.alert('Estado','Solo rendiciones en estado VERIFICACIÓN pueden ser modificados')
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		}				
	}
	
	this.btnEliminar = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{
			if(SelectionsRecord.data.estado_rendicion==1)
			{
				CM_btnEliminar();
			}
			else
			{
				Ext.MessageBox.alert('Estado','Solo rendiciones en estado VERIFICACIÓN pueden ser eliminados')
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.')
		}
	}
	
	function evento_presupuesto( combo, record, index )
	{	
		//filtramos los conceptos de tesoreria por unidad organizacional y presupuesto	
		componentes[2].reset();
		componentes[2].store.baseParams={m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional,m_id_presupuesto:record.data.id_presupuesto};
		componentes[2].modificado=true;								
 	}
 	
 	function evento_importe_documento( combo, record, index )
	{	
		componentes[16].setValue( componentes[3].getValue() );								
 	}
	
	function SiBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++)
		{
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=true;
		}
	}
	
	function NoBlancosGrupo(grupo)
	{
		for (var i=0;i<componentes.length;i++)
		{
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}	
		

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rendicion_viaticos.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	
	CM_getBoton('editar-'+idContenedor).disable();
	CM_getBoton('eliminar-'+idContenedor).disable();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);			
		
		if(rec.data['estado_rendicion']=='1')//verificacion
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();			
		}
		if(rec.data['estado_rendicion']=='2')//comprometido
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();			
		}
		if(rec.data['estado_rendicion']=='3')//contabilizado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();			
		}
		if(rec.data['estado_rendicion']=='4')//validado
		{
			//alert("llega disa");
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();			
		}
	}
			
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_rendicion_viaticos.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}