<?php 
/**
 * Nombre:		  	    vales_caja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-22 10:36:48
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
var elemento={pagina:new pagina_vales_caja_rendi(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added


/**
 * Nombre:		  	    pagina_vales_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-22 10:36:48
 */
function pagina_vales_caja_rendi(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	var reporte=0;//1 es vale, 2 es rendición o otro vale depende del caso
	var id_vale,id_cotizacion,tipo_vale;
	var datas_edit;
	var dialogo;
	var g_sw_contabilizar;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarValesCaja.php?tipo=rendido'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_regis',totalRecords:'TotalCount'
		},[		
		'id_caja_regis',
		'id_caja',
		'nombre_moneda',
		'tipo_caja',
		'desc_caja',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'estado_cajero_cajero',
		'desc_cajero',
		'id_empleado',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_empleado',
		'importe_regis',
		{name: 'fecha_regis',type:'date',dateFormat:'Y-m-d'},
		'nombre_unidad',
		'estado_regis',
		'id_subsistema',
		'desc_persona',
		'concepto_regis',
		'id_cotizacion',
		'sw_contabilizar',
		'nombre_depto',
		'id_depto',
		'nro_vale',
		'id_devengado',
		'id_proveedor',
		'tipo_vale'
		]),remoteSort:true});

	
	

    

	//FUNCIONES RENDER
	
		

	function renderTipo(value, p, record){	//solo registros diferentes de tesoreria
		if(value == 1){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Caja"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Caja"+ '</span>');} else{return "Caja"}}
		if(value == 2){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Caja Chica"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Caja Chica"+ '</span>');} else{return "Caja Chica"}}
		if(value == 3){if(record.get('id_subsistema')!=12){return '<span style="color:blue;font-size:8pt">'+"Fondo Rotatorio"+ '</span>'}if((record.get('concepto_regis')).substring(0,7)=='viatico'){return String.format('{0}', '<span style="color:brown;font-size:8pt">'+"Fondo Rotatorio"+ '</span>');} else{return "Fondo Rotatorio"}}
		
	}	
	
	
	
	function renderEstado(value, p, record){
		if(value == 0){return "Reposición"}
		if(value == 1){return "Pendiente"}
		if(value == 2){return "Rendición"}
		if(value == 3){return "3"}
		if(value == 4){return "Comprometido"}
		if(value == 5){return "Contabilizado"}
		if(value == 6){return "Validado"}		
	}
	
	
	
	
	function negrita(val,cell,record,row,colum,store){
						
			
				if(record.get('id_subsistema')!=12)
				{
					return '<span style="color:blue;font-size:8pt">' + val+ '</span>';
				}
				else if((record.get('concepto_regis')).substring(0,7)=='viatico') 
				{
					return  '<span style="color:brown;font-size:8pt">' + val+ '</span>';
				} 
				else
				{ 
					return val;
				}
			
				
		}		
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_regis'
	};
	
	Atributos[1]={
			validacion:{
				name:'nombre_depto',
				fieldLabel:'Departamento de Tesorería', 
				grid_visible:true,
				grid_editable:false,
				width_grid:220,
				grid_indice:1,
				renderer:negrita
			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'depto.nombre_depto'
		};
	
	
// txt id_caja
	Atributos[2]={
			validacion:{
			name:'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Caja',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			grid_indice:1,
			renderer:negrita		
		},
		tipo:'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'MONEDA_0.nombre#UNIORG_0.nombre_unidad'
	};
// txt id_cajero
	Atributos[3]={
			validacion:{
			name:'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			fieldLabel:'Cajero',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:4		
		},
		tipo:'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'EMPLEA_1.apellido_paterno#EMPLEA_1.apellido_materno#EMPLEA_1.nombre#EMPLEA_1.codigo_empleado'
		
	};
// txt id_empleado

	
// txt importe_regis
	Atributos[4]={
		validacion:{
			name:'importe_regis',
			fieldLabel:'Importe Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.importe_regis'
	};
// txt fecha_regis
	Atributos[5]= {
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			grid_indice:7		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_regis',
		dateFormat:'m-d-Y'
	};
// txt nombre_unidad
	Atributos[6]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Unidad Organizacional',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:5		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	// txt nombre_unidad
	Atributos[7]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo de Caja',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:1,
			renderer:renderTipo		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false
	};
	
	// txt nombre_unidad
	Atributos[8]={
		validacion:{
			name:'estado_regis',
			fieldLabel:'Estado Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5,
			renderer:renderEstado	
		},
		tipo: 'TextField',
		form: false
		
	};
	Atributos[9]={
		validacion:{
			labelSeparator:'',
			name: 'estado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'estado_regis'
	};
	
	// txt fecha_regis
	Atributos[10]= {
		validacion:{
			name:'importe_entregado',
			fieldLabel:'Importe Entregado',
			grid_visible:false,
			grid_editable:false,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			width_grid:85,
			grid_indice:7		
		},
		form:true,
		tipo:'NumberField',
		filtro_0:false
	};
	
	// txt nombre_unidad
	Atributos[11]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Concepto Vale',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis'
	};
	
		
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'id_susbsistema',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		form:true,
		filtro_0:false,
		save_as:'id_subsistema'
	};
	
	// txt fecha_regis
	Atributos[13]= {
		validacion:{
			name:'nro_vale',
			fieldLabel:'Nro',
			grid_visible:true,
			grid_editable:false,
			allowDecimals:false,
			width_grid:50,
			grid_indice:1		
		},
		form:false,
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CAJREG.nro_documento'	
	};
	
	 Atributos[14]={//==> se usa//30
			validacion: {
			name:'tipo_vale',
			fieldLabel:'Tipo de Vale',
			grid_visible:true,
			grid_indice:2,
			grid_editable:false
			
		},
		tipo:'ComboBox',
		form: false,
		defecto:'provisorio'
	};
	
	Atributos[15]={
		validacion:{
			name:'desc_empleado',
			fieldLabel:'A nombre de',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis'		
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vales de Caja',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/vales_caja_rendi/rendiciones_det.php'};
	var layout_vales_caja=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_vales_caja.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_vales_caja,idContenedor);
	var CM_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var cm_EnableSelect=this.EnableSelect;
	
	
	
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarValesCaja.php'},
		Save:{url:direccion+'../../../control/caja_regis/ActionGuardarValesCaja.php'},
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarValesCaja.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Vales de Caja'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{		
		
		//para iniciar eventos en el formulario
	
		getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.desbloquearMenu()
					}
		})
		
	}
	
	function btnProvisional(){
		var sm=getSelectionModel();
		id_vale =sm.getSelected().data.id_caja_regis;
		var data = "id_caja_regis=" +id_vale;
		//alert(sm.getSelected().data.tipo_vale); 
		if(sm.getSelected().data.tipo_vale=='provisorio')		
			{		
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReporteRendicion.php?'+data);
			}
			else{
				window.open(direccion+'../../../control/caja_regis/Reportes/ActionReportePago.php?'+data);				
			}		
	}
		
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
				datas_edit=rec.data;
				
				_CP.getPagina(layout_vales_caja.getIdContentHijo()).pagina.reload(rec.data);
					
	}	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_vales_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	
	var CM_getBoton=this.getBoton;
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Provisional',btnProvisional,true,'provisional','Provisional'); //tucrem
	
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_vales_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}