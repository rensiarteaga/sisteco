<?php 
/**
 * Nombre:		  	    rendiciones_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-06 19:01:08
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
var elemento={pagina:new pagina_rendiciones(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_rendiciones.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-06 19:01:08
 */
function pagina_rendiciones(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarRendicionesPendientes.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',totalRecords:'TotalCount'
		},[		
				'id_cotizacion',
		
		'importe_total',
		'tipo_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'nro_documento',
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'nro_autorizacion',
		'codigo_control',
		'tipo'
		]),remoteSort:true});

	
	
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cotizacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cotizacion'
	};

// txt importe_regis
	Atributos[1]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Registro',
			allowBlank:false,
			align:'right', 
			selectOnFocus:true,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:3		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false
		
	};


// txt tipo_documento
	Atributos[2]={
		validacion:{
			name:'tipo_documento',
			disabled:true,
			allowBlank:false,
			fieldLabel:'Tipo Documento',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:1			
		},
		tipo:'TextField',
		form: true,
		filtro_0:false,
		save_as:'tipo_documento',
		id_grupo:0
	};
// txt fecha_documento
	Atributos[3]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:4		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCU.fecha_documento',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_documento',
		id_grupo:0
	};
// txt nro_documento
	Atributos[4]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'No Documento',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:5		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCU.nro_documento',
		save_as:'nro_documento',
		id_grupo:0
	};
// txt razon_social
	Atributos[5]={
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
			disabled:false,
			grid_indice:2	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DOCU.razon_social',
		save_as:'razon_social',
		id_grupo:0
	};
// txt nro_nit
	Atributos[6]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:6		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCU.nro_nit',
		save_as:'nro_nit',
		id_grupo:1
	};
// txt nro_autorizacion
	Atributos[7]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'No Autorización',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:7	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCU.nro_autorizacion',
		save_as:'nro_autorizacion',
		id_grupo:1
	};
// txt codigo_control
	Atributos[8]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:8		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCU.codigo_control',
		save_as:'codigo_control',
		id_grupo:1
	};
	
	Atributos[9]={
		validacion:{
			name:'tipo',
			allowBlank:false,
			inputType:'hidden'
		},
		tipo:'Field',
		form: true,
		filtro_0:false
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'rendiciones',grid_maestro:'grid-'+idContenedor};
	var layout_rendiciones=new DocsLayoutMaestroEP(idContenedor);
	layout_rendiciones.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_rendiciones,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnEdit=this.btnEdit;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		editar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarRendiciones.php'},
		Save:{url:direccion+'../../../control/caja_regis/ActionGuardarRendicionesPendientes.php'},
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarRendicionesPendientes.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos Generales',columna:0,id_grupo:0},{tituloGrupo:'Datos Factura',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'rendiciones'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		CM_ocultarGrupo('Datos Factura');
	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	this.btnEdit=function(){
		
		if(componentes[9].getValue()=='1'){
			NoBlancosGrupo(1);
			CM_mostrarGrupo('Datos Factura');
		}
		else{
			SiBlancosGrupo(1);
			CM_ocultarGrupo('Datos Factura');
		}
		CM_btnEdit();
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rendiciones.getLayout()};
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
	layout_rendiciones.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}