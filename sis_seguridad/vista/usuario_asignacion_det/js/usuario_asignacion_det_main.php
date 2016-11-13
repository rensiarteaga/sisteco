<?php
/**
 * Nombre:		  	    usuario_Asignacion_det.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2013-11-25
 *
 */
session_start();

?>
//<script>
var paginaUsuarioAsignacionDet;

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

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_usuario_asignacion_det(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_solicitud_compra_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 */
function pagina_usuario_asignacion_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	var gestion;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_presupuesto',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_presupuesto',
		'desc_presupuesto',
		'id_gestion'
		]),remoteSort:true});

	
	
	// DEFINICIÓN DATOS DEL MAESTRO

var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//DATA STORE COMBOS

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra_det
	//en la posición 0 siempre esta la llave primaria

	
	Atributos[0]={
		validacion:{
			name:'desc_presupuesto',
			desc:'desc_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			//store:ds_servicio,
			//renderer:render_id_servicio,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:390,
			width:200,
			pageSize:10,
			//direccion:direccion,
			//filterCols:filterCols_servicio,
			//filterValues:filterValues_servicio,
			grid_indice:2
			},
		tipo:'TextField',
		save_as:'id_servicio',
		filtro_0:true,
		defecto:'',
		filterColValue:'presup.desc_presupuesto'
		
	};
	
	
	
	
	
	//----------- FUNCIONES RENDER
	

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Presupuesto',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_usuario_asignacion_det = new DocsLayoutMaestro(idContenedor);
	layout_usuario_asignacion_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_usuario_asignacion_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={//guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php'},
	Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
	ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Servicio Solicitado'
	
	/*grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Servicio',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Datos Pedido',
				columna:0,
				id_grupo:2
			},
			
			{
				tituloGrupo:'Informacion Presupuestaria',
				columna:0,
				id_grupo:3
			}
			]*/
	
	}};
	
	
	
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//var datos=Ext.urlDecode(decodeURIComponent(params));
		
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_asignacion_estructura:maestro.id_asignacion_estructura
			}
		};
		
		this.btnActualizar();
		
		//Atributos[5].defecto=maestro.id_solicitud_compra;
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_gestion;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_gestion;
		paramFunciones.ConfirmSave.parametros='&m_id_solicitud_compra='+maestro.id_gestion;
		this.InitFunciones(paramFunciones)
	};
	
	

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		
		
	  
	 	
	    
	}

	
	this.btnNew=function(){
	
	   
		CM_btnNew();
		
	}
	
	
	

	
	
	this.btnEdit=function(){
		
			CM_btnEdit();
		
	}
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_usuario_asignacion_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_usuario_asignacion_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}