<?php
/**
 * Nombre:		  	    depreciacion2_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-07-20 14:54:41
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

var elemento={idContenedor:idContenedor,pagina:new pagina_depreciacion2_det(idContenedor,direccion,paramConfig,maestro)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_depreciacion2_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-07-20 14:54:41
 */
function pagina_depreciacion2_det(idContenedor,direccion,paramConfig,maestro)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depreciacion/ActionListarDepreciacion2Det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depreciacion',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_depreciacion',
		{name: 'fecha_desde',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_hasta',type:'date',dateFormat:'Y-m-d'},
		'monto_vigente_ant',
		'monto_vigente',
		'vida_util',
		'tipo_cambio_ini',
		'tipo_cambio_fin',
		'depreciacion_acum_ant',
		'depreciacion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado',
		'depreciacion_acum',
		'id_activo_fijo',
		'desc_activo_fijo',
		'id_moneda',
		'desc_moneda',
		'monto_vigente_ant_2',
		'monto_vigente_2',
		'vida_util_2',
		'depreciacion_acum_ant_2',
		'depreciacion_2',
		'depreciacion_acum_2',
		'monto_actualiz_ant',
		'monto_actualiz',
		'dep_acum_actualiz',
		'monto_actualiz_2',
		'dep_acum_actualiz_2',
		'id_grupo_depreciacion',
		'desc_grupo_depreciacion'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_depreciacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depreciacion',
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
		filterColValue:'DEPRE.fecha_desde'
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
		filterColValue:'DEPRE.fecha_hasta'
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
		filterColValue:'DEPRE.monto_vigente_ant'
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
		filterColValue:'DEPRE.monto_vigente'
	};
// txt vida_util
	Atributos[5]={
		validacion:{
			name:'vida_util',
			fieldLabel:'Vida Util Restante',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			grid_indice:4		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.vida_util'
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
		filterColValue:'DEPRE.tipo_cambio_ini'
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
		filterColValue:'DEPRE.tipo_cambio_fin'
	};
// txt depreciacion_acum_ant
	Atributos[8]={
		validacion:{
			name:'depreciacion_acum_ant',
			fieldLabel:'Depreciación acumulada ant',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			grid_indice:7		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion_acum_ant'
	};
// txt depreciacion
	Atributos[9]={
		validacion:{
			name:'depreciacion',
			fieldLabel:'Depreciación',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			grid_indice:10		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion'
	};

	

// txt depreciacion_acum
	Atributos[10]={
		validacion:{
			name:'depreciacion_acum',
			fieldLabel:'Depreciación acumulada',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			grid_indice:11		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion_acum'
	};
// txt id_activo_fijo
	Atributos[11]={
		validacion:{
			name:'desc_activo_fijo',
			fieldLabel:'Activo',
			grid_visible:true,
			grid_editable:false,
			width_grid:140,
			grid_indice:1	
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'ACTIF.codigo'
	};

// txt monto_vigente_ant_2
	Atributos[12]={
		validacion:{
			name:'monto_vigente_ant_2',
			fieldLabel:'monto_vigente_ant_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:18		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.monto_vigente_ant_2'
	};
// txt monto_vigente_2
	Atributos[13]={
		validacion:{
			name:'monto_vigente_2',
			fieldLabel:'monto_vigente_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:19		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.monto_vigente_2'
	};
// txt vida_util_2
	Atributos[14]={
		validacion:{
			name:'vida_util_2',
			fieldLabel:'Vida Util',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:9		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.vida_util_2'
	};
// txt depreciacion_acum_ant_2
	Atributos[15]={
		validacion:{
			name:'depreciacion_acum_ant_2',
			fieldLabel:'depreciacion_acum_ant_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:21		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion_acum_ant_2'
	};
// txt depreciacion_2
	Atributos[16]={
		validacion:{
			name:'depreciacion_2',
			fieldLabel:'depreciacion_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:22		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion_2'
	};
// txt depreciacion_acum_2
	Atributos[17]={
		validacion:{
			name:'depreciacion_acum_2',
			fieldLabel:'depreciacion_acum_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:23		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.depreciacion_acum_2'
	};
// txt monto_actualiz_ant
	Atributos[18]={
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
		filterColValue:'DEPRE.monto_actualiz_ant'
	};
// txt monto_actualiz
	Atributos[19]={
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
		filterColValue:'DEPRE.monto_actualiz'
	};
// txt dep_acum_actualiz
	Atributos[20]={
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
		filterColValue:'DEPRE.dep_acum_actualiz'
	};
// txt monto_actualiz_ant_2
	Atributos[21]={
		validacion:{
			name:'monto_actualiz_2',
			fieldLabel:'Monto Act. Depre.',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			grid_indice:6		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.monto_actualiz_ant_2'
	};
// txt dep_acum_actualiz_2
	Atributos[22]={
		validacion:{
			name:'dep_acum_actualiz_2',
			fieldLabel:'dep_acum_actualiz_2',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			grid_indice:25		
		},
		tipo:'Field',
		filtro_0:true,
		form:false,		
		filterColValue:'DEPRE.dep_acum_actualiz_2'
	};
// txt id_grupo_depreciacion
	Atributos[23]={
		validacion:{
			name:'id_grupo_depreciacion',
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
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/depreciacion/ActionEliminarDepreciacion2Det.php'},
	Save:{url:direccion+'../../../control/depreciacion/ActionGuardarDepreciacion2Det.php'},
	ConfirmSave:{url:direccion+'../../../control/depreciacion/ActionGuardarDepreciacion2Det.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'depreciacion2_det'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		maestro=params;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_grupo_depreciacion:maestro.id_grupo_depreciacion
			}
		};
		this.btnActualizar();
		Atributos[23].defecto=maestro.id_grupo_depreciacion;

		paramFunciones.btnEliminar.parametros='&id_grupo_depreciacion='+maestro.id_grupo_depreciacion;
		paramFunciones.Save.parametros='&id_grupo_depreciacion='+maestro.id_grupo_depreciacion;
		paramFunciones.ConfirmSave.parametros='&id_grupo_depreciacion='+maestro.id_grupo_depreciacion;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
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