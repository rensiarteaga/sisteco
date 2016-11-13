<?php 
/**
 * Nombre:		  	    plan_llamada_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:01
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_plan_llamada(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_plan_llamada_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:01
 */
function pagina_plan_llamada(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_plan_llamada;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/plan_llamada/ActionListarPlanLlamada.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_plan_llamada',
			totalRecords:'TotalCount'
		},[
		'id_plan_llamada',
		'nombre',
		'descripcion',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'monto_llamada',
		'monto_datos','tarifa_win','estado_reg','usuario_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_plan_llamada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_plan_llamada'
	};
// txt nombre_plan_llamada
	vectorAtributos[1]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre Plan',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width:'62%',
				width_grid:195
			},
			tipo:'TextField',
			filtro_0:true,
			filterColValue:'PLALLAM.nombre',
			save_as:'nombre'
		};
// txt costo_minuto
	vectorAtributos[2]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripcion',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:195,
				width:'62%'
			},
			tipo:'TextArea',
			filtro_0:true,
			filterColValue:'PLALLAM.descripcion',
			save_as:'descripcion'
		};

	vectorAtributos[3]={
			validacion:{
				name:'monto_llamada',
				fieldLabel:'Monto para Llamadas(Bs)',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'62%',
				disable:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PLALLAM.monto_llamada',
			
			save_as:'monto_llamada'
		};

	vectorAtributos[4]={
			validacion:{
				name:'monto_datos',
				fieldLabel:'Monto Plan Datos(Bs)',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'62%',
				disable:false
				
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PLALLAM.monto_datos',
			
			save_as:'monto_datos'
		};

	    vectorAtributos[5]={
			validacion:{
				name:'tarifa_win',
				fieldLabel:'Tarifa Win(Bs)',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:75,
				width:'62%',
				disable:false
				
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PLALLAM.tarifa_win',
			
			save_as:'tarifa_win'
		};
	
	
	vectorAtributos[6]= {
			validacion:{
				name:'fecha_ini',
				fieldLabel:'Fecha Inicio',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width:150,
				disabled:false,
				width_grid:65,

			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			
			filterColValue:'PLALLAM.fecha_ini',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_ini'
			
		};
	
	vectorAtributos[7]= {
			validacion: {
				name:'estado_reg',			
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',			
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				width:'50%',
				grid_editable:true,
				width_grid:100
			},
			tipo:'ComboBox',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'PLALLAM.estado_reg',
			save_as:'estado_reg'
		};
	vectorAtributos[8]= {
			validacion:{
				name:'fecha_fin',
				fieldLabel:'Fecha Fin',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width:150,
				disabled:false,
				width_grid:65,

			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			
			filterColValue:'PLALLAM.fecha_fin',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin'
			
		};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'plan_llamada',grid_maestro:'grid-'+idContenedor};
	layout_plan_llamada=new DocsLayoutMaestro(idContenedor);
	layout_plan_llamada.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_plan_llamada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/plan_llamada/ActionEliminarPlanLlamada.php'},
		Save:{url:direccion+'../../../control/plan_llamada/ActionGuardarPlanLlamada.php'},
		ConfirmSave:{url:direccion+'../../../control/plan_llamada/ActionGuardarPlanLlamada.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,closable:true,titulo:'PlanLlamada'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.getLayout=function(){
		return layout_plan_llamada.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
  
	this.iniciaFormulario();
	layout_plan_llamada.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}