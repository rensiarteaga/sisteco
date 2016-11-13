<?php 
/**
 * Nombre:		  	    registro_conciliacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 10:33:49
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
var elemento={pagina:new pagina_registro_conciliacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_registro_conciliacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 10:33:49
 */
function pagina_registro_conciliacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cheque/ActionListarRegistroConciliacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},[		
				'id_cheque',
		'id_transaccion',
		'desc_transaccion',
		'nro_cheque',
		'nro_deposito',
		{name: 'fecha_cheque',type:'date',dateFormat:'Y-m-d'},
		'nombre_cheque',
		'estado_cheque',
		'id_cuenta_bancaria',
		'nro_cuenta_cuenta',
		'descripcion_cuenta',
		'nro_cuenta_banco_cuenta_bancaria',
		'desc_cuenta_bancaria'
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_transaccion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/transaccion/ActionListarTransaccion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_transaccion',totalRecords: 'TotalCount'},['id_transaccion','id_comprobante','id_fuente_financiamiento','id_unidad_organizacional','id_cuenta','id_partida','id_auxiliar','id_orden_trabajo','id_oec','concepto_tran','id_fina_regi_prog_proy_acti'])
	});

    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['CUENTA_7.nro_cuenta','CUENTA_7.descripcion','CUEBAN_7.nro_cuenta_banco'])
	});

	//FUNCIONES RENDER
	
		function render_id_transaccion(value, p, record){return String.format('{0}', record.data['desc_transaccion']);}
		var tpl_id_transaccion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['desc_cuenta_bancaria']);}
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{CUENTA_7.nro_cuenta}</FONT><br>','<FONT COLOR="#B5A642">{CUENTA_7.descripcion}</FONT><br>','<FONT COLOR="#B5A642">{CUEBAN_7.nro_cuenta_banco}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_cheque
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};
// txt id_transaccion
	Atributos[1]={
			validacion:{
			name:'id_transaccion',
			fieldLabel:'id_transaccion',
			allowBlank:false,			
			emptyText:'id_transaccion...',
			desc: 'desc_transaccion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_transaccion,
			valueField: 'id_transaccion',
			displayField: '',
			queryParam: 'filterValue_0',
			filterCol:'TRANSC.',
			typeAhead:true,
			tpl:tpl_id_transaccion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:100,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_transaccion,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'TRANSC.',
		save_as:'id_transaccion'
	};
// txt nro_cheque
	Atributos[2]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'nro_cheque',
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
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'.nro_cheque',
		save_as:'nro_cheque'
	};
// txt nro_deposito
	Atributos[3]={
		validacion:{
			name:'nro_deposito',
			fieldLabel:'nro_deposito',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'.nro_deposito',
		save_as:'nro_deposito'
	};
// txt fecha_cheque
	Atributos[4]= {
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'fecha_cheque',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:false,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false		
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'.fecha_cheque',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_cheque'
	};
// txt nombre_cheque
	Atributos[5]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'nombre_cheque',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		filterColValue:'.nombre_cheque',
		save_as:'nombre_cheque'
	};
// txt estado_cheque
	Atributos[6]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'estado_cheque',
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
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'.estado_cheque',
		save_as:'estado_cheque'
	};
// txt id_cuenta_bancaria
	Atributos[7]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'id_cuenta_bancaria',
			allowBlank:false,			
			emptyText:'id_cuenta_bancaria...',
			desc: 'desc_cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'id_cuenta_bancaria',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion##CUEBAN.nro_cuenta_banco',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:100,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta_bancaria,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'CUENTA_7.nro_cuenta#CUENTA_7.descripcion##CUEBAN_7.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'registro_conciliacion',grid_maestro:'grid-'+idContenedor};
	var layout_registro_conciliacion=new DocsLayoutMaestro(idContenedor);
	layout_registro_conciliacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_registro_conciliacion,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/cheque/ActionEliminarRegistroConciliacion.php'},
		Save:{url:direccion+'../../../control/cheque/ActionGuardarRegistroConciliacion.php'},
		ConfirmSave:{url:direccion+'../../../control/cheque/ActionGuardarRegistroConciliacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'registro_conciliacion'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_registro_conciliacion.getLayout()};
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
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_registro_conciliacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}