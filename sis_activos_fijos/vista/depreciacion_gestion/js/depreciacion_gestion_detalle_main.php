<?php
/**
 * Nombre:		  	    depreciacion_gestion_detalle_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		27/10/2015
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

var maestro=undefined;

var elemento={idContenedor:idContenedor,pagina:new pag_depreciacion_gestion_detalle(idContenedor,direccion,paramConfig,maestro)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pag_depreciacion_gestion_detalle(idContenedor,direccion,paramConfig,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depreciacion_gestion/ActionListarDepreciacionGestionDetalle.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depreciacion_gestion_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depreciacion_gestion_det','id_depreciacion_gestion',
		{name: 'fecha_desde',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_hasta',type:'date',dateFormat:'Y-m-d'},
		'monto_vigente_ant',
		'monto_vigente',
		'vida_util_restante',
		'tipo_cambio_ini',
		'tipo_cambio_fin',
		'depreciacion_acum_ant',
		'depreciacion',
		'depreciacion_acum',
		'id_moneda',
		'desc_moneda',
		'monto_actualiz_ant','monto_actualiz','dep_acum_actualiz',
		'id_activo_fijo',
		'codigo',
		'vida_util_original',
		]),remoteSort:true});

	
	// DEFINICI�N DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	
	
	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	// hidden id_depreciacion
	//en la posici�n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depreciacion_gestion_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
// txt fecha_desde
	Atributos[1]={
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Desde',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			renderer: formatDate,
			grid_indice:2		
		},
		tipo:'DateField',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.fecha_desde'
	};
// txt fecha_hasta
	Atributos[2]={
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Hasta',
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			renderer: formatDate,
			grid_indice:3		
		},
		tipo:'DateField',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.fecha_hasta'
	};
// txt monto_vigente_ant
	Atributos[3]={
		validacion:{
			name:'monto_vigente_ant',
			fieldLabel:'Monto anterior',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:12		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.monto_vigente_ant'
	};
// txt monto_vigente
	Atributos[4]={
		validacion:{
			name:'monto_vigente',
			fieldLabel:'Monto Vigente',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:13		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.monto_vigente'
	};
// txt vida_util
	Atributos[5]={
		validacion:{
			name:'vida_util_restante',
			fieldLabel:'Vida Util Restante',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			grid_indice:4		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.vida_util'
	};
// txt tipo_cambio_ini
	Atributos[6]={
		validacion:{
			name:'tipo_cambio_ini',
			fieldLabel:'Tipo cambio ini',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:14		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.tipo_cambio_ini'
	};
// txt tipo_cambio_fin
	Atributos[7]={
		validacion:{
			name:'tipo_cambio_fin',
			fieldLabel:'Tipo cambio fin',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:15	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.tipo_cambio_fin'
	};
// txt depreciacion_acum_ant
	Atributos[8]={
		validacion:{
			name:'depreciacion_acum_ant',
			fieldLabel:'Depreciacion acumulada ant',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			grid_indice:7		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.depreciacion_acum_ant'
	};
// txt depreciacion
	Atributos[9]={
		validacion:{
			name:'depreciacion',
			fieldLabel:'Depreciacion',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:10		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.depreciacion'
	};

	

// txt depreciacion_acum
	Atributos[10]={
		validacion:{
			name:'depreciacion_acum',
			fieldLabel:'Depreciacion acumulada',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:11		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.depreciacion_acum'
	};
// txt id_activo_fijo
	Atributos[11]={
		validacion:{
			name:'codigo',
			fieldLabel:'Activo Fijo',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			grid_indice:1	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'AF.codigo'
	};

// txt monto_actualiz_ant
	Atributos[12]={
		validacion:{
			name:'monto_actualiz_ant',
			fieldLabel:'Monto actualiz. ant.',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:5		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.monto_actualiz_ant'
	};
// txt monto_actualiz
	Atributos[13]={
		validacion:{
			name:'monto_actualiz',
			fieldLabel:'Monto actualiz.',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:6	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.monto_actualiz'
	};
// txt dep_acum_actualiz
	Atributos[14]={
		validacion:{
			name:'dep_acum_actualiz',
			fieldLabel:'Depreciación acum. actualiz.',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:8	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DG.dep_acum_actualiz'
	};

// txt id_grupo_depreciacion
	Atributos[15]={
		validacion:{
			name:'id_depreciacion_gestion',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Depreciaciones 2 (Maestro)',titulo_detalle:'depreciacion2_det (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_depreciacion2_det = new DocsLayoutMaestro(idContenedor);
	layout_depreciacion2_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_depreciacion2_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
//DEFINICI�N DE LA BARRA DE MEN�
	var paramMenu={eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICI�N DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depreciacion_gestion/ActionEliminarDepreciacionGestionDetalle.php'},
	Save:{url:direccion+'../../../control/depreciacion/ActionGuardarDepreciacion2Det.php'},
	ConfirmSave:{url:direccion+'../../../control/depreciacion/ActionGuardarDepreciacion2Det.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'depreciacion_gestion_detalle'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		maestro=params;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depreciacion_gestion:maestro.id_depreciacion_gestion
			}
		};
		this.btnActualizar();
		Atributos[15].defecto=maestro.id_depreciacion_gestion;

		paramFunciones.btnEliminar.parametros='&id_depreciacion_gestion='+maestro.id_depreciacion_gestion;
		paramFunciones.Save.parametros='&id_depreciacion_gestion='+maestro.id_depreciacion_gestion;
		paramFunciones.ConfirmSave.parametros='&id_depreciacion_gestion='+maestro.id_depreciacion_gestion;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tama�o
	this.getLayout=function(){return layout_depreciacion2_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_depreciacion2_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	
}