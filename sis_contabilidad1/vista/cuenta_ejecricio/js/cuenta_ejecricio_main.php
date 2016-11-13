<?php 
/**
 * Nombre:		  	    cuenta_ejecricio_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-16 11:37:00
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
var elemento={pagina:new pagina_cuenta_ejecricio(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_cuenta_ejecricio.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-16 11:37:00
 */
function pagina_cuenta_ejecricio(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	var g_id_gestion='';
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_ejercicio/ActionListarCuentaEjercicio.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_ejercicio',totalRecords:'TotalCount'
		},[		
		'id_ejercicio',
		'id_partida_cuenta',
		'desc_parcta',
		'tipo_ejercicio',
		'desc_ejercicio',
		'id_gestion',
		'id_auxiliar',
		'desc_auxiliar'
		]),remoteSort:true});
	  
	//DATA STORE COMBOS
	var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarPartidaCuenta.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_debe','debe','id_haber','haber','id_recurso','recurso','id_gasto','gasto','sw_deha','sw_rega','id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida','desc_parcta'])});
	function render_id_partida_cuenta(value, p, record){return String.format('{0}', record.data['desc_parcta'])};
	var tpl_id_partida_cuenta=new Ext.Template('<div class="search-item">','<b>Partida: </b><FONT COLOR="#B5A642">{recurso}</FONT>','<FONT COLOR="#B5A642">{gasto}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{haber}</FONT>','<FONT COLOR="#B5A642">{debe}</FONT>','<b> - </b><FONT COLOR="#B5A642">{desc_parametro}</FONT><br>','</div>');
		
	ds_auxiliar=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({	record:'ROWS',id:'id_auxiliar',	totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});	
	var resultTpl=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</i></b>','<b><br>Código: <i>{codigo_auxiliar}</i></b>','<br><FONT COLOR="#B5A642">{email1}</FONT>','</div>');	
	function render_auxiliar(value,p,record){return String.format('{0}',record.data['desc_auxiliar'])};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_ejercicio
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_ejercicio',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_ejercicio'
	};

	// txt tipo_ejercicio
	Atributos[1]={
		validacion:{
			name:'tipo_ejercicio',
			fieldLabel:'Código de Ejercicio',
			allowBlank:false,
			align:'right', 
			maxLength:2,
			minLength:1,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'50%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CUEJE.tipo_ejercicio',
		save_as:'tipo_ejercicio'
	};
	
	Atributos[2]= {
		validacion:{
			name:'desc_ejercicio',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			disabled:false,		
			width_grid:220
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CUEJE.desc_ejercicio',
		save_as:'desc_ejercicio'
	};
	
	Atributos[3]={
		validacion:{
				fieldLabel:'Partida - Cuenta',
				allowBlank:false,
				emptyText:'Partida Cuenta...',
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
				queryDelay:250,
				pageSize:20,
				minListWidth:400,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_id_partida_cuenta,
				grid_visible:true,
				grid_editable:false,
				width:400,
				width_grid:550 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			save_as:'id_partida_cuenta'
	};
		
    Atributos[4]={
		validacion:{
			labelSeparator:'',
			name:'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		defecto:g_id_gestion,
		form: true,
		filtro_0:false,
		save_as:'id_gestion'
	};
	
	// txt id_tipo_unidad_constructiva_reemplazo
	 Atributos[5]={
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
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:400,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_auxiliar,
				grid_visible:true,
				grid_editable:false,
				width:400,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'codigo_auxiliar',
			save_as:'id_auxiliar'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cuenta Ejercicio',grid_maestro:'grid-'+idContenedor};
	var layout_cuenta_ejecricio=new DocsLayoutMaestro(idContenedor);
	layout_cuenta_ejecricio.init(config);

	
	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cuenta_ejecricio,idContenedor);
	var getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_ejercicio/ActionEliminarCuentaEjercicio.php'},
		Save:{url:direccion+'../../../control/cuenta_ejercicio/ActionGuardarCuentaEjercicio.php'},
		ConfirmSave:{url:direccion+'../../../control/cuenta_ejercicio/ActionGuardarCuentaEjercicio.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:580,minWidth:150,minHeight:200,	closable:true,titulo:'Cuenta Ejecricio'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
/*	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	cmpId_gestion=ClaseMadre_getComponente('id_gestion');
	cmpId_cuenta=ClaseMadre_getComponente('id_cuenta');
	}*/
	
	function InitPaginaCuentaEjercicio(){
		for(var i=0; i<Atributos.length; i++)
		{	componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		componentes[3].on('select',f_filtrar_auxiliar)
	}
	
	function f_filtrar_auxiliar(combo,record,index){
		var var_id_cuenta ;
		if(record.data.id_debe==''){var_id_cuenta =record.data.id_haber}
		if(record.data.id_haber==''){var_id_cuenta =record.data.id_debe}
		componentes[5].setDisabled(false);
		componentes[5].store.baseParams={ sw_referencia_cuenta:'si',m_id_cuenta:var_id_cuenta  };
		componentes[5].modificado=true;
	}
	
	this.btnEdit=function(){
		componentes[5].setDisabled(true);
		ClaseMadre_btnEdit();
		componentes[4].setValue(g_id_gestion);	
	};
	
	this.btnNew=function(){
		ClaseMadre_btnNew();
		componentes[4].setValue(g_id_gestion);
		componentes[5].setDisabled(true);
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cuenta_ejecricio.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
//	ds.load({
//		params:{
//			start:0,
//			limit: paramConfig.TamanoPagina,
//			CantFiltros:paramConfig.CantFiltros
//		}
//	});
	
	//para agregar botones
	this.iniciaFormulario();

	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var gestion =new Ext.form.ComboBox({
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_gestion',
			tpl:tpl_gestion
		});
	
	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();
  
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion,
				m_sw_cuenta_ejercicio:'si'
			}
		});	
		componentes[4].setValue(g_id_gestion);
		componentes[3].store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:g_id_gestion}; 
		componentes[3].modificado=true;
	});
	
	this.AdicionarBotonCombo(gestion,'gestion');														
	InitPaginaCuentaEjercicio();
	//iniciarEventosFormularios();
	layout_cuenta_ejecricio.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}