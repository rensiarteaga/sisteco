<?php 
/**
 * Nombre:		  	    emision_recibo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-29 17:35:04
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var elemento={pagina:new pagina_emision_recibo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_emision_recibo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-29 17:35:04
 */
function pagina_emision_recibo(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/factura_recibo/ActionListarEmisionRecibo.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_factura_recibo',totalRecords:'TotalCount'
		},[		
				'id_factura_recibo',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_caja',
		'nombre_unidad_unidad_organizacional',
		'desc_caja',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_cajero',
		'id_concepto_ingas',
		'desc_partida_partida',
		'desc_ingas_concepto_ingas',
		'desc_concepto_ingas',
		'id_moneda',
		'desc_moneda',
		'nro_factura',
		'importe_factura',
		'nro_deposito',
		{name: 'fecha_factura',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_deposito',type:'date',dateFormat:'Y-m-d'},
		'razon_social'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','nombre_unidad'])
	});

     var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});

    var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');

		function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja']);}
		var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','</div>');

			function render_id_cajero(value, p, record){return String.format('{0}', record.data['desc_cajero']);}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');

		function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
		var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_factura_recibo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_factura_recibo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_factura_recibo'
	};
// txt id_fina_regi_prog_proy_acti
	Atributos[1]={
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
			grid_indice:12,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};
// txt id_unidad_organizacional
	Atributos[2]={
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
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional',
			id_grupo:0
	};
// txt id_caja
	Atributos[3]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'id_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_caja,
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
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG_3.nombre_unidad',
		save_as:'id_caja'
	};
// txt id_cajero
	Atributos[4]={
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
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre##EMPLEA.codigo_empleado',
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
			grid_indice:11		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_4.apellido_paterno#PERSON_4.apellido_materno#PERSON_4.nombre##EMPLEA_4.codigo_empleado',
		save_as:'id_cajero',
			id_grupo:0
	};
// txt id_concepto_ingas
	Atributos[5]={
			validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto Ingreso Gasto',
			allowBlank:false,			
			emptyText:'Concepto Ingreso Gasto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida#CONING.desc_ingas',
			typeAhead:true,
			tpl:tpl_id_concepto_ingas,
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
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			width:'100%',
			disabled:false,
			grid_indice:10		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID_5.desc_partida#CONING_5.desc_ingas',
		save_as:'id_concepto_ingas',
			id_grupo:2
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
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:6		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda',
			id_grupo:2
	};
// txt nro_factura
	Atributos[7]={
		validacion:{
			name:'nro_factura',
			fieldLabel:'No de Recibo',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:3		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'FACREC.nro_factura',
		save_as:'nro_factura'
	};
// txt importe_factura
	Atributos[8]={
		validacion:{
			name:'importe_factura',
			fieldLabel:'Importe',
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
			grid_indice:7		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'FACREC.importe_factura',
		save_as:'importe_factura',
			id_grupo:2
	};
// txt nro_deposito
	Atributos[9]={
		validacion:{
			name:'nro_deposito',
			fieldLabel:'No de Deposito',
			allowBlank:true,
			maxLength:15,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:13		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'FACREC.nro_deposito',
		save_as:'nro_deposito',
			id_grupo:3
	};
// txt fecha_factura
	Atributos[10]= {
		validacion:{
			name:'fecha_factura',
			fieldLabel:'Fecha Recibo',
			allowBlank:true,
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
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'FACREC.fecha_factura',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_factura'
	};
// txt fecha_deposito
	Atributos[11]= {
		validacion:{
			name:'fecha_deposito',
			fieldLabel:'Fecha Deposito',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:14		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'FACREC.fecha_deposito',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_deposito',
			id_grupo:3
	};
// txt razon_social
	Atributos[12]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razón Social',
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
			grid_indice:4		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		save_as:'razon_social',
			id_grupo:2
	};



	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'emision_recibo',grid_maestro:'grid-'+idContenedor};
	var layout_emision_recibo=new DocsLayoutMaestroEP(idContenedor);
	layout_emision_recibo.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_emision_recibo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEliminar=this.btnEliminar;
	var CM_enableSelect=this.EnableSelect;
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/factura_recibo/ActionEliminarEmisionRecibo.php',mensaje:'Esta seguro de anular el recibo?'},
		Save:{url:direccion+'../../../control/factura_recibo/ActionGuardarEmisionRecibo.php'},
		ConfirmSave:{url:direccion+'../../../control/factura_recibo/ActionGuardarEmisionRecibo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['47%','47%'],grupos:[{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1},{tituloGrupo:'Datos de Recibo',columna:1,id_grupo:2},{tituloGrupo:'Datos Deposito',columna:1,id_grupo:3}],width:'70%',minWidth:150,minHeight:200,	closable:true,titulo:'emision_recibo'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	function btn_anular(){
		CM_btnEliminar();
	}
	this.EnableSelect=function(x,z,y){
			
		enable(x,z,y);
		
		
	}
	
	
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_emision_recibo.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Recibo',btn_anular,true,'anular_recibo','Anulación');
	var CM_getBoton=this.getBoton;
	CM_getBoton('anular_recibo-'+idContenedor).enable();
	CM_getBoton('editar-'+idContenedor).enable();
			
	
	
	function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				       
        			   if(record.razon_social=='ANULADO'){
					       		CM_getBoton('anular_recibo-'+idContenedor).disable();
								CM_getBoton('editar-'+idContenedor).disable();
					       }
					       
					       else{
					       		CM_getBoton('anular_recibo-'+idContenedor).enable();
								CM_getBoton('editar-'+idContenedor).enable();
					       }

				}
				CM_enableSelect(sel,row,selected);
				
			}		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_emision_recibo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}