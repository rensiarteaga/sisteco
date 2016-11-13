<?php 
/**
 * Nombre:		  	    equipo_main.php
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
var elemento={pagina:new pagina_equipo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_equipo_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-18 19:44:01
 */
function pagina_equipo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_equipo;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/equipos/ActionListarEquipo.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_equipo',
			totalRecords:'TotalCount'
		},[
		'id_equipo',
		'modelo',
		'marca',
		{name: 'fecha_ingreso',type:'date',dateFormat:'Y-m-d'},
		'estado_reg',
		'observaciones','imei'
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
			name:'id_equipo',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_equipo'
	};

	vectorAtributos[1]={
			validacion:{
				name:'imei',
				fieldLabel:'IMEI',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:195
			},
			tipo:'TextField',
			filtro_0:true,
			filterColValue:'EQUIPO.imei',
			save_as:'imei'
		};

	
// txt nombre_equipo
	vectorAtributos[2]={
			validacion:{
				name:'modelo',
				fieldLabel:'Modelo',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:195
			},
			tipo:'TextField',
			filtro_0:true,
			filterColValue:'EQUIPO.modelo',
			save_as:'modelo'
		};
// txt costo_minuto
	vectorAtributos[3]={
			validacion:{
				name:'marca',
				fieldLabel:'Marca',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:195
			},
			tipo:'TextField',
			filtro_0:true,
			filterColValue:'EQUIPO.marca',
			save_as:'marca'
		};

	vectorAtributos[4]= {
			validacion:{
				name:'fecha_ingreso',
				fieldLabel:'Fecha Ingreso',
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
			filtro_1:true,
			filterColValue:'EQUIPO.fecha_ingreso',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_ingreso'
			
		};
	
// txt descripcion
	vectorAtributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Accesorios',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:195
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'EQUIPO.observaciones',
		save_as:'observaciones'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'equipo',grid_maestro:'grid-'+idContenedor};
	layout_equipo=new DocsLayoutMaestro(idContenedor);
	layout_equipo.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_equipo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/equipos/ActionEliminarEquipo.php'},
		Save:{url:direccion+'../../../control/equipos/ActionGuardarEquipo.php'},
		ConfirmSave:{url:direccion+'../../../control/equipos/ActionGuardarEquipo.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Equipo'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
		
	};
	

	
	this.getLayout=function(){
		return layout_equipo.getLayout()
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
	layout_equipo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}